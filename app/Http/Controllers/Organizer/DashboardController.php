<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Vote;
use App\Models\Contestant;
use App\Models\TicketOrder;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the organizer dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's events
        $userEventIds = Event::where('user_id', $user->id)->pluck('id');
        
        // Get category IDs for user's events
        $userCategoryIds = Category::whereIn('event_id', $userEventIds)->pluck('id');
        
        // Get contestant IDs for user's events
        $userContestantIds = Contestant::whereIn('category_id', $userCategoryIds)->pluck('id');
        
        // Calculate statistics
        $stats = $this->calculateStats($user, $userEventIds, $userCategoryIds, $userContestantIds);
        
        // Get recent transactions (votes for user's events)
        $recentTransactions = Vote::whereIn('contestant_id', $userContestantIds)
            ->with(['contestant.category.event'])
            ->where('payment_status', 'success')
            ->latest()
            ->take(5)
            ->get();
        
        // Get top contestants across all user's events
        $topContestants = Contestant::whereIn('category_id', $userCategoryIds)
            ->where('status', 'active')
            ->orderByDesc('total_votes')
            ->take(5)
            ->get();
        
        // Get event dates for calendar
        $eventDates = Event::where('user_id', $user->id)
            ->where('status', 'active')
            ->get()
            ->flatMap(function ($event) {
                $dates = [];
                $start = Carbon::parse($event->start_date);
                $end = Carbon::parse($event->end_date);
                
                // Limit to 60 days to prevent memory issues
                $maxDays = 60;
                $dayCount = 0;
                
                while ($start->lte($end) && $dayCount < $maxDays) {
                    $dates[] = $start->format('Y-m-d');
                    $start->addDay();
                    $dayCount++;
                }
                
                return $dates;
            })
            ->unique()
            ->values()
            ->toArray();
        
        // Set notifications to 0 (no notification system yet)
        $unreadNotifications = 0;
        
        return view('organizer.dashboard', compact(
            'stats',
            'recentTransactions',
            'topContestants',
            'eventDates',
            'unreadNotifications'
        ));
    }
    
    /**
     * Calculate dashboard statistics.
     */
    private function calculateStats($user, $userEventIds, $userCategoryIds, $userContestantIds)
    {
        $now = Carbon::now();
        $startOfThisWeek = $now->copy()->startOfWeek();
        $endOfThisWeek = $now->copy()->endOfWeek();
        $startOfLastWeek = $now->copy()->subWeek()->startOfWeek();
        $endOfLastWeek = $now->copy()->subWeek()->endOfWeek();
        
        // Total votes (from contestants table - total_votes field)
        $totalVotes = Contestant::whereIn('category_id', $userCategoryIds)->sum('total_votes');
        
        // Votes this week (from votes table)
        $votesThisWeek = Vote::whereIn('contestant_id', $userContestantIds)
            ->where('payment_status', 'success')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->sum('vote_count');
        
        // Votes last week
        $votesLastWeek = Vote::whereIn('contestant_id', $userContestantIds)
            ->where('payment_status', 'success')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->sum('vote_count');
        
        // Total earnings (from paid votes)
        $totalEarnings = Vote::whereIn('contestant_id', $userContestantIds)
            ->where('payment_status', 'success')
            ->sum('amount_paid');
        
        // Earnings this week
        $earningsThisWeek = Vote::whereIn('contestant_id', $userContestantIds)
            ->where('payment_status', 'success')
            ->whereBetween('created_at', [$startOfThisWeek, $endOfThisWeek])
            ->sum('amount_paid');
        
        // Earnings last week
        $earningsLastWeek = Vote::whereIn('contestant_id', $userContestantIds)
            ->where('payment_status', 'success')
            ->whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])
            ->sum('amount_paid');
        
        // Event counts
        $totalEvents = Event::where('user_id', $user->id)->count();
        $activeEvents = Event::where('user_id', $user->id)
            ->where('status', 'active')
            ->count();
        $completedEvents = Event::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();
        
        return [
            'total_votes' => $totalVotes,
            'votes_this_week' => $votesThisWeek,
            'votes_last_week' => $votesLastWeek,
            'total_earnings' => $totalEarnings,
            'earnings_this_week' => $earningsThisWeek,
            'earnings_last_week' => $earningsLastWeek,
            'total_events' => $totalEvents,
            'active_events' => $activeEvents,
            'completed_events' => $completedEvents,
        ];
    }
}