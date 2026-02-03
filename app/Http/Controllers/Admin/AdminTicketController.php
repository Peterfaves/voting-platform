<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketOrder;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminTicketController extends Controller
{
    /**
     * Display a listing of all ticket sales.
     */
    public function index(Request $request)
    {
        // Check if tickets table exists
        if (!Schema::hasTable('tickets')) {
            return view('admin.tickets.index', [
                'tickets' => collect(),
                'events' => collect(),
                'stats' => [
                    'total_tickets_sold' => 0,
                    'total_revenue' => 0,
                    'total_ticket_types' => 0,
                    'active_tickets' => 0,
                ],
                'recentPurchases' => collect(),
            ]);
        }

        // Get all tickets with event data
        $query = Ticket::with(['event.user']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('event', function ($eq) use ($search) {
                      $eq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by event
        if ($request->filled('event')) {
            $query->where('event_id', $request->event);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tickets = $query->latest()->paginate(20)->withQueryString();

        // Calculate sold count and revenue for each ticket
        foreach ($tickets as $ticket) {
            $ticket->sold_count = TicketOrder::where('ticket_id', $ticket->id)
                ->where('status', 'completed')
                ->sum('quantity') ?? 0;
            
            $ticket->total_revenue = TicketOrder::where('ticket_id', $ticket->id)
                ->where('status', 'completed')
                ->sum('total_amount') ?? 0;
        }

        // Events for filter
        $events = Event::whereHas('tickets')->orderBy('name')->get(['id', 'name']);

        // Stats
        $stats = [
            'total_tickets_sold' => TicketOrder::where('status', 'completed')->sum('quantity') ?? 0,
            'total_revenue' => TicketOrder::where('status', 'completed')->sum('total_amount') ?? 0,
            'total_ticket_types' => Ticket::count(),
            'active_tickets' => Ticket::where('status', 'active')->count(),
        ];

        // Recent purchases
        $recentPurchases = TicketOrder::with(['ticket.event'])
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.tickets.index', compact('tickets', 'events', 'stats', 'recentPurchases'));
    }

    /**
     * Display the specified ticket details.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load(['event.user']);

        // Get purchases for this ticket
        $purchases = TicketOrder::where('ticket_id', $ticket->id)
            ->latest()
            ->paginate(20);

        // Stats
        $soldCount = TicketOrder::where('ticket_id', $ticket->id)
            ->where('status', 'completed')
            ->sum('quantity') ?? 0;

        $stats = [
            'total_sold' => $soldCount,
            'total_revenue' => TicketOrder::where('ticket_id', $ticket->id)
                ->where('status', 'completed')
                ->sum('total_amount') ?? 0,
            'available' => $ticket->quantity - $soldCount,
        ];

        return view('admin.tickets.show', compact('ticket', 'purchases', 'stats'));
    }
}