<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Vote;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of organizers.
     */
    public function index(Request $request)
    {
        $query = User::organizers()
            ->with('role')
            ->withCount('events');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'suspended') {
                $query->suspended();
            }
        }

        // Sort
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'events':
                $query->orderByDesc('events_count');
                break;
            default:
                $query->latest();
        }

        $organizers = $query->paginate(20)->withQueryString();

        // Calculate votes, earnings, and withdrawals for each organizer
        foreach ($organizers as $organizer) {
            $eventIds = $organizer->events()->pluck('id');
            
            if ($eventIds->count() > 0) {
                $organizer->total_votes = Vote::whereHas('contestant.category', function ($q) use ($eventIds) {
                    $q->whereIn('event_id', $eventIds);
                })->where('payment_status', 'success')->sum('number_of_votes') ?? 0;
                
                $organizer->total_earnings = Vote::whereHas('contestant.category', function ($q) use ($eventIds) {
                    $q->whereIn('event_id', $eventIds);
                })->where('payment_status', 'success')->sum('amount_paid') ?? 0;
            } else {
                $organizer->total_votes = 0;
                $organizer->total_earnings = 0;
            }

            // Get withdrawals
            $organizer->total_withdrawn = Withdrawal::where('user_id', $organizer->id)
                ->whereIn('status', ['approved', 'completed'])
                ->sum('net_amount') ?? 0;
        }

        // Stats
        $stats = [
            'total_organizers' => User::organizers()->count(),
            'active_organizers' => User::organizers()->active()->count(),
            'suspended_organizers' => User::organizers()->suspended()->count(),
            'new_this_month' => User::organizers()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('admin.users.index', compact('organizers', 'stats'));
    }

    /**
     * Display the specified organizer.
     */
    public function show(User $user)
    {
        $organizer = $user->load(['role', 'events' => function ($q) {
            $q->latest()->take(10);
        }]);

        // Get event IDs for this organizer
        $eventIds = $user->events()->pluck('id');

        // Get stats
        if ($eventIds->count() > 0) {
            $totalVotes = Vote::whereHas('contestant.category', function ($q) use ($eventIds) {
                $q->whereIn('event_id', $eventIds);
            })->where('payment_status', 'success')->sum('number_of_votes') ?? 0;
            
            $totalEarnings = Vote::whereHas('contestant.category', function ($q) use ($eventIds) {
                $q->whereIn('event_id', $eventIds);
            })->where('payment_status', 'success')->sum('amount_paid') ?? 0;
        } else {
            $totalVotes = 0;
            $totalEarnings = 0;
        }

        $stats = [
            'total_events' => $user->events()->count(),
            'total_votes' => $totalVotes,
            'total_earnings' => $totalEarnings,
            'total_withdrawn' => Withdrawal::where('user_id', $user->id)
                ->whereIn('status', ['approved', 'completed'])
                ->sum('net_amount') ?? 0,
        ];

        // Recent withdrawals
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('admin.users.show', compact('organizer', 'stats', 'withdrawals'));
    }

    /**
     * Suspend an organizer.
     */
    public function suspend(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        $user->update([
            'status' => 'suspended',
            'suspended_at' => now(),
            'suspended_reason' => $request->reason,
        ]);

        // Log the action
        AuditLog::log(
            'suspend',
            $user,
            null,
            null,
            "Suspended organizer: {$user->name}" . ($request->reason ? ". Reason: {$request->reason}" : '')
        );

        return back()->with('success', "Organizer {$user->name} has been suspended.");
    }

    /**
     * Activate a suspended organizer.
     */
    public function activate(User $user)
    {
        $user->update([
            'status' => 'active',
            'suspended_at' => null,
            'suspended_reason' => null,
        ]);

        // Log the action
        AuditLog::log(
            'activate',
            $user,
            null,
            null,
            "Activated organizer: {$user->name}"
        );

        return back()->with('success', "Organizer {$user->name} has been activated.");
    }

    /**
     * Update admin notes for an organizer.
     */
    public function updateNote(Request $request, User $user)
    {
        $request->validate([
            'note' => 'nullable|string|max:5000',
        ]);

        $user->update([
            'admin_notes' => $request->note,
        ]);

        return back()->with('success', 'Admin notes updated successfully.');
    }

    /**
     * Delete an organizer (soft delete recommended).
     */
    public function destroy(User $user)
    {
        // Check if user has any active events
        if ($user->events()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete organizer with active events.');
        }

        $userName = $user->name;

        // Log before deletion
        AuditLog::log(
            'delete',
            $user,
            null,
            null,
            "Deleted organizer: {$userName}"
        );

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Organizer {$userName} has been deleted.");
    }
}