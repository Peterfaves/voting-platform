<?php
// app/Http/Controllers/Admin/TicketManagementController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketManagementController extends Controller
{
    public function create(Event $event)
    {
        $this->authorize('update', $event);

        return view('admin.tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:regular,vip,vvip,early_bird',
        ]);

        $event->tickets()->create($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Ticket created successfully');
    }

    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket->event);

        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket->event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:regular,vip,vvip,early_bird',
        ]);

        $ticket->update($validated);

        return redirect()->route('admin.events.show', $ticket->event)
            ->with('success', 'Ticket updated successfully');
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket->event);

        $ticket->delete();

        return back()->with('success', 'Ticket deleted successfully');
    }
}