<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $tickets = Ticket::whereHas('event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with('event')
        ->latest()
        ->paginate(20);
        
        $totalTicketsSold = TicketOrder::whereHas('ticket.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('payment_status', 'success')
        ->sum('quantity');
        
        $totalTicketRevenue = TicketOrder::whereHas('ticket.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('payment_status', 'success')
        ->sum('total_amount');
        
        $recentOrders = TicketOrder::whereHas('ticket.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['ticket.event'])
        ->latest()
        ->take(10)
        ->get();
        
        return view('organizer.tickets.index', compact(
            'tickets',
            'totalTicketsSold',
            'totalTicketRevenue',
            'recentOrders'
        ));
    }

    public function create(Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('organizer.tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'sale_start' => 'nullable|date',
            'sale_end' => 'nullable|date|after:sale_start',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string|max:255',
        ]);

        $validated['event_id'] = $event->id;
        $validated['status'] = 'active';

        Ticket::create($validated);

        return redirect()
            ->route('organizer.tickets.index')
            ->with('success', 'Ticket created successfully!');
    }

    public function edit(Ticket $ticket)
    {
        // Ensure the organizer owns this ticket's event
        if ($ticket->event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('organizer.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Ensure the organizer owns this ticket's event
        if ($ticket->event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:' . $ticket->sold,
            'sale_start' => 'nullable|date',
            'sale_end' => 'nullable|date|after:sale_start',
            'status' => 'required|in:active,inactive',
            'benefits' => 'nullable|array',
            'benefits.*' => 'string|max:255',
        ]);

        $ticket->update($validated);

        return redirect()
            ->route('organizer.tickets.index')
            ->with('success', 'Ticket updated successfully!');
    }

    public function destroy(Ticket $ticket)
    {
        // Ensure the organizer owns this ticket's event
        if ($ticket->event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent deletion if tickets have been sold
        if ($ticket->sold > 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot delete ticket with existing orders.');
        }

        $ticket->delete();

        return redirect()
            ->route('organizer.tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }

    public function orders()
    {
        $user = Auth::user();
        
        $orders = TicketOrder::whereHas('ticket.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->with(['ticket.event'])
        ->latest()
        ->paginate(50);
        
        return view('organizer.tickets.orders', compact('orders'));
    }

    public function validateTicket(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = TicketOrder::where('order_number', $validated['order_number'])
            ->with(['ticket.event'])
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Ticket not found.'
            ], 404);
        }

        // Ensure the organizer owns this ticket's event
        if ($order->ticket->event->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.'
            ], 403);
        }

        if (!$order->canBeUsed()) {
            return response()->json([
                'success' => false,
                'message' => 'This ticket cannot be used. Status: ' . $order->status,
                'order' => $order
            ]);
        }

        // Mark as used
        $order->update([
            'status' => 'used',
            'used_at' => now(),
            'used_by' => Auth::user()->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket validated successfully!',
            'order' => $order
        ]);
    }

    public function scan()
    {
        return view('organizer.tickets.scan');
    }
}