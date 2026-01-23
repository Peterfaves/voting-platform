<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contestant;
use App\Models\Category;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of organizer's events
     */
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->withCount('categories')
            ->with('categories.contestants')
            ->latest()
            ->get()
            ->map(function ($event) {
                // Calculate votes count manually
                $event->votes_count = Vote::whereHas('contestant.category', function ($query) use ($event) {
                    $query->where('event_id', $event->id);
                })->count();
                
                return $event;
            });
        
        // Paginate manually if needed
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $pagedData = $events->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $events = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $events->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('organizer.events.index', compact('events'));
    }

    /**
     * Display events for management (alternative view)
     */
    public function manage()
    {
        $events = Event::where('user_id', Auth::id())
            ->with(['categories.contestants'])
            ->latest()
            ->get()
            ->map(function ($event) {
                $event->votes_count = Vote::whereHas('contestant.category', function ($query) use ($event) {
                    $query->where('event_id', $event->id);
                })->count();
                
                return $event;
            });
        
        return view('organizer.events.manage', compact('events'));
    }

    /**
     * Show the form for creating a new event
     */
    public function create()
    {
        return view('organizer.events.create');
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'vote_price' => 'required|numeric|min:0',
            'status' => 'nullable|in:draft,active,completed',
        ]);

        // Handle banner upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        $validated['user_id'] = Auth::id();
        $validated['status'] = $validated['status'] ?? 'draft';

        $event = Event::create($validated);

        return redirect()
            ->route('organizer.events.show', $event->id)
            ->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event
     */
    public function show(Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $event->load([
            'categories.contestants' => function ($query) {
                $query->orderBy('total_votes', 'desc');
            }
        ]);

        // Get statistics
        $stats = [
            'total_votes' => Vote::whereHas('contestant.category', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })->count(),
            'total_revenue' => Vote::whereHas('contestant.category', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })->where('payment_status', 'success')->sum('amount_paid'),
            'total_earnings' => Vote::whereHas('contestant.category', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })->where('payment_status', 'success')->sum('amount_paid'),
            'total_contestants' => Contestant::whereHas('category', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })->count(),
            'total_categories' => $event->categories()->count(),
        ];

        // Get recent votes for this event
        $recentVotes = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
        ->with('contestant')
        ->latest()
        ->take(10)
        ->get();

        return view('organizer.events.show', compact('event', 'stats', 'recentVotes'));
    }

    /**
     * Show the form for editing the specified event
     */
    public function edit(Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('organizer.events.edit', compact('event'));
    }

    /**
     * Update the specified event
     */
    public function update(Request $request, Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'vote_price' => 'required|numeric|min:0',
            'status' => 'nullable|in:draft,active,completed',
        ]);

        // Handle banner upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('events/banners', 'public');
        }

        // Update slug if name changed
        if ($event->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::random(6);
        }

        $event->update($validated);

        return redirect()
            ->route('organizer.events.show', $event->id)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event
     */
    public function destroy(Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent deletion if event has votes
        $votesCount = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->count();

        if ($votesCount > 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot delete event with existing votes.');
        }

        // Delete banner
        if ($event->banner_image) {
            Storage::disk('public')->delete($event->banner_image);
        }

        // Delete related data
        foreach ($event->categories as $category) {
            foreach ($category->contestants as $contestant) {
                if ($contestant->photo) {
                    Storage::disk('public')->delete($contestant->photo);
                }
            }
        }

        $event->delete();

        return redirect()
            ->route('organizer.events.index')
            ->with('success', 'Event deleted successfully!');
    }

    /**
     * Publish the event
     */
    public function publish(Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validate that event has at least one category and contestant
        if ($event->categories()->count() === 0) {
            return redirect()
                ->back()
                ->with('error', 'Cannot publish event without categories.');
        }

        $hasContestants = false;
        foreach ($event->categories as $category) {
            if ($category->contestants()->count() > 0) {
                $hasContestants = true;
                break;
            }
        }

        if (!$hasContestants) {
            return redirect()
                ->back()
                ->with('error', 'Cannot publish event without contestants.');
        }

        $event->update(['status' => 'active']);

        return redirect()
            ->back()
            ->with('success', 'Event published successfully!');
    }

    /**
     * End the event
     */
    public function end(Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $event->update([
            'status' => 'completed',
            'end_date' => now(),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Event ended successfully!');
    }

    /**
     * Show event analytics
     */
    public function analytics(Event $event)
    {
        // Ensure the organizer owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Get vote statistics
        $totalVotes = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->count();
        
        $totalRevenue = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->where('payment_status', 'success')->sum('amount_paid');
        
        // Votes over time (last 30 days)
        $votesOverTime = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
        ->where('created_at', '>=', now()->subDays(30))
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(amount_paid) as revenue')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Top contestants
        $topContestants = Contestant::whereHas('category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
        ->with('category')
        ->orderBy('total_votes', 'desc')
        ->take(10)
        ->get();

        // Category breakdown
        $categoryStats = Category::where('event_id', $event->id)
            ->withCount('contestants')
            ->with('contestants')
            ->get()
            ->map(function ($category) {
                $category->total_votes = $category->contestants->sum('total_votes');
                return $category;
            });

        // Payment status breakdown (using payment_status instead of payment_method)
        $paymentMethods = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
        ->selectRaw('payment_status, COUNT(*) as count, SUM(amount_paid) as total')
        ->groupBy('payment_status')
        ->get()
        ->map(function ($item) {
            // Map payment_status to a more friendly display name
            $item->payment_method = ucfirst($item->payment_status);
            return $item;
        });

        return view('organizer.events.analytics', compact(
            'event',
            'totalVotes',
            'totalRevenue',
            'votesOverTime',
            'topContestants',
            'categoryStats',
            'paymentMethods'
        ));
    }

    /**
     * Show event category view (public facing)
     */
    public function category($eventSlug, $categorySlug)
    {
        $event = Event::where('slug', $eventSlug)->firstOrFail();
        
        $category = $event->categories()
            ->where('slug', $categorySlug)
            ->with(['contestants' => function ($query) {
                $query->orderBy('total_votes', 'desc');
            }])
            ->firstOrFail();

        return view('events.category', compact('event', 'category'));
    }
}