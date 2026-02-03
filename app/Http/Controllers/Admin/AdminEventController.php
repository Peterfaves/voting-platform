<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Vote;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    /**
     * Display a listing of all events.
     */
    public function index(Request $request)
    {
        $query = Event::with(['user', 'categories.contestants'])
            ->withCount('categories');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by organizer
        if ($request->filled('organizer')) {
            $query->where('user_id', $request->organizer);
        }

        // Sort
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
        }

        $events = $query->paginate(20)->withQueryString();

        // Calculate votes and revenue for each event
        foreach ($events as $event) {
            // Count contestants
            $event->contestants_count = $event->categories->sum(function ($category) {
                return $category->contestants->count();
            });

            // Get votes and revenue
            $event->total_votes = Vote::whereHas('contestant.category', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })->where('payment_status', 'success')->sum('number_of_votes') ?? 0;

            $event->total_revenue = Vote::whereHas('contestant.category', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })->where('payment_status', 'success')->sum('amount_paid') ?? 0;
        }

        // Organizers for filter dropdown
        $organizers = User::where('role', 'organizer')
            ->whereHas('events')
            ->orderBy('name')
            ->get(['id', 'name']);

        // Stats
        $stats = [
            'total_events' => Event::count(),
            'active_events' => Event::where('status', 'active')->count(),
            'draft_events' => Event::where('status', 'draft')->count(),
            'completed_events' => Event::where('status', 'completed')->count(),
        ];

        return view('admin.events.index', compact('events', 'organizers', 'stats'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load([
            'user',
            'categories.contestants'
        ]);

        // Stats
        $stats = [
            'total_votes' => Vote::whereHas('contestant.category', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })->where('payment_status', 'success')->sum('number_of_votes') ?? 0,
            
            'total_revenue' => Vote::whereHas('contestant.category', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })->where('payment_status', 'success')->sum('amount_paid') ?? 0,
            
            'total_contestants' => $event->categories->sum(function ($cat) {
                return $cat->contestants->count();
            }),
            
            'total_categories' => $event->categories->count(),
        ];

        // Recent votes
        $recentVotes = Vote::with(['contestant', 'contestant.category'])
            ->whereHas('contestant.category', function ($q) use ($event) {
                $q->where('event_id', $event->id);
            })
            ->where('payment_status', 'success')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.events.show', compact('event', 'stats', 'recentVotes'));
    }

    /**
     * Suspend an event.
     */
    public function suspend(Request $request, Event $event)
    {
        $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        $event->update([
            'status' => 'suspended',
        ]);

        // Log the action
        AuditLog::log(
            'suspend',
            $event,
            null,
            null,
            "Suspended event: {$event->name}" . ($request->reason ? ". Reason: {$request->reason}" : '')
        );

        return back()->with('success', "Event '{$event->name}' has been suspended.");
    }

    /**
     * Activate a suspended event.
     */
    public function activate(Event $event)
    {
        $event->update([
            'status' => 'active',
        ]);

        // Log the action
        AuditLog::log(
            'activate',
            $event,
            null,
            null,
            "Activated event: {$event->name}"
        );

        return back()->with('success', "Event '{$event->name}' has been activated.");
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Event $event)
    {
        $event->update([
            'is_featured' => !$event->is_featured,
        ]);

        $status = $event->is_featured ? 'featured' : 'unfeatured';

        // Log the action
        AuditLog::log(
            'update',
            $event,
            null,
            null,
            "Event '{$event->name}' has been {$status}"
        );

        return back()->with('success', "Event has been {$status}.");
    }

    /**
     * Delete an event.
     */
    public function destroy(Event $event)
    {
        // Check if event has any votes
        $hasVotes = Vote::whereHas('contestant.category', function ($q) use ($event) {
            $q->where('event_id', $event->id);
        })->where('payment_status', 'success')->exists();

        if ($hasVotes) {
            return back()->with('error', 'Cannot delete event with existing votes. Consider suspending it instead.');
        }

        $eventName = $event->name;

        // Log before deletion
        AuditLog::log(
            'delete',
            $event,
            null,
            null,
            "Deleted event: {$eventName}"
        );

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', "Event '{$eventName}' has been deleted.");
    }
}