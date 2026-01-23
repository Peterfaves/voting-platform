<?php

// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Vote;
use App\Models\TicketPurchase;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $events = Event::withCount(['categories', 'tickets'])
                ->with('user')
                ->latest()
                ->paginate(10);
        } else {
            $events = $user->events()
                ->withCount(['categories', 'tickets'])
                ->latest()
                ->paginate(10);
        }

        $stats = [
            'total_events' => $user->isAdmin() ? Event::count() : $user->events->count(),
            'total_votes' => $this->getTotalVotes($user),
            'total_revenue' => $this->getTotalRevenue($user),
            'active_events' => $this->getActiveEvents($user),
        ];

        return view('admin.dashboard', compact('events', 'stats'));
    }

    private function getTotalVotes($user)
    {
        if ($user->isAdmin()) {
            return Vote::where('payment_status', 'success')->sum('vote_count');
        }
        
        return Vote::whereHas('contestant.category.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('payment_status', 'success')->sum('vote_count');
    }

    private function getTotalRevenue($user)
    {
        if ($user->isAdmin()) {
            $votingRevenue = Vote::where('payment_status', 'success')->sum('amount_paid');
            $ticketRevenue = TicketPurchase::where('payment_status', 'success')->sum('total_amount');
            return $votingRevenue + $ticketRevenue;
        }
        
        $votingRevenue = Vote::whereHas('contestant.category.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('payment_status', 'success')->sum('amount_paid');
        
        $ticketRevenue = TicketPurchase::whereHas('ticket.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('payment_status', 'success')->sum('total_amount');
        
        return $votingRevenue + $ticketRevenue;
    }

    private function getActiveEvents($user)
    {
        if ($user->isAdmin()) {
            return Event::where('status', 'active')->count();
        }
        
        return $user->events()->where('status', 'active')->count();
    }
}
