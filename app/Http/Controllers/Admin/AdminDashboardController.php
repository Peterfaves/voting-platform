<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Vote;
use App\Models\Withdrawal;
use App\Models\Setting;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Main stats
        $stats = [
            // Revenue stats
            'total_revenue' => Vote::where('payment_status', 'success')->sum('amount_paid'),
            'platform_earnings' => $this->calculatePlatformEarnings(),
            'revenue_today' => Vote::where('payment_status', 'success')
                ->whereDate('created_at', today())
                ->sum('amount_paid'),
            
            // User stats
            'total_organizers' => User::where('role', 'organizer')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            
            // Event stats
            'total_events' => Event::count(),
            'active_events' => Event::where('status', 'active')->count(),
            'events_today' => Event::whereDate('created_at', today())->count(),
            
            // Voting stats
            'total_votes' => Vote::where('payment_status', 'success')->sum('number_of_votes'),
            'votes_today' => Vote::where('payment_status', 'success')
                ->whereDate('created_at', today())
                ->sum('number_of_votes'),
            
            // Ticket stats (if you have tickets)
            'tickets_sold' => cache()->remember('has_ticket_purchases_table', 3600, function () {
                return \Schema::hasTable('ticket_purchases');
            }) 
                ? DB::table('ticket_purchases')->where('status', 'completed')->count() 
                : 0,
            
            // Withdrawal stats
            'pending_withdrawals_count' => Withdrawal::pending()->count(),
            'pending_withdrawals_amount' => Withdrawal::pending()->sum('amount'),
            
            // Platform fee rate
            'platform_fee_rate' => Setting::getPlatformFee(),
        ];

        // Get the count for the sidebar badge
        $pendingWithdrawalsCount = Withdrawal::pending()->count();

        // Pending withdrawals for quick action
        $pendingWithdrawals = Withdrawal::with('user')
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        // Recent transactions
        $recentTransactions = Vote::with(['contestant.category.event'])
            ->where('payment_status', 'success')
            ->latest()
            ->take(5)
            ->get();

        // Top events by revenue - FIXED (votes -> contestants -> categories -> events)
        $topEvents = Event::select('events.*')
            ->with('user')
            ->withCount('categories')
            ->addSelect([
                'total_revenue' => Vote::selectRaw('COALESCE(SUM(votes.amount_paid), 0)')
                    ->join('contestants', 'votes.contestant_id', '=', 'contestants.id')
                    ->join('categories', 'contestants.category_id', '=', 'categories.id')
                    ->whereColumn('categories.event_id', 'events.id')
                    ->where('votes.payment_status', 'success'),
                'total_votes' => Vote::selectRaw('COALESCE(SUM(votes.number_of_votes), 0)')
                    ->join('contestants', 'votes.contestant_id', '=', 'contestants.id')
                    ->join('categories', 'contestants.category_id', '=', 'categories.id')
                    ->whereColumn('categories.event_id', 'events.id')
                    ->where('votes.payment_status', 'success')
            ])
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        // Top organizers - FIXED
        $topOrganizers = User::select('users.*')
            ->where('role', 'organizer')
            ->withCount('events')
            ->addSelect([
                'total_earnings' => Vote::selectRaw('COALESCE(SUM(votes.amount_paid), 0)')
                    ->join('contestants', 'votes.contestant_id', '=', 'contestants.id')
                    ->join('categories', 'contestants.category_id', '=', 'categories.id')
                    ->join('events', 'categories.event_id', '=', 'events.id')
                    ->whereColumn('events.user_id', 'users.id')
                    ->where('votes.payment_status', 'success')
            ])
            ->orderByDesc('total_earnings')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'pendingWithdrawals',
            'pendingWithdrawalsCount',
            'recentTransactions',
            'topEvents',
            'topOrganizers'
        ));
    }

    /**
     * Calculate total platform earnings (fees).
     */
    protected function calculatePlatformEarnings(): float
    {
        $totalWithdrawn = Withdrawal::whereIn('status', ['approved', 'completed'])->sum('platform_fee');
        return $totalWithdrawn;
    }

    /**
     * Get stats for API.
     */
    public function getStats()
    {
        $stats = [
            'total_revenue' => Vote::where('payment_status', 'success')->sum('amount_paid'),
            'total_organizers' => User::where('role', 'organizer')->count(),
            'total_events' => Event::count(),
            'total_votes' => Vote::where('payment_status', 'success')->sum('number_of_votes'),
            'pending_withdrawals' => Withdrawal::pending()->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get revenue chart data.
     */
    public function getRevenueChart(Request $request)
    {
        $days = $request->get('days', 7);
        $startDate = now()->subDays($days);

        $revenue = Vote::where('payment_status', 'success')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(amount_paid) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        // Fill in missing dates with 0
        $labels = [];
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M d');
            $data[] = $revenue[$date] ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * Get votes chart data.
     */
    public function getVotesChart(Request $request)
    {
        $days = $request->get('days', 7);
        $startDate = now()->subDays($days);

        $votes = Vote::where('payment_status', 'success')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(number_of_votes) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        $labels = [];
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M d');
            $data[] = $votes[$date] ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * Get recent activity.
     */
    public function getRecentActivity()
    {
        $activities = AuditLog::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'user' => $log->user_name,
                    'action' => $log->action,
                    'description' => $log->description,
                    'time' => $log->created_at->diffForHumans(),
                    'color' => $log->action_color,
                    'icon' => $log->action_icon,
                ];
            });

        return response()->json($activities);
    }
}