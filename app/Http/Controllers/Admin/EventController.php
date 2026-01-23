<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $events = Event::with('user')->latest()->paginate(15);
        } else {
            $events = $user->events()->latest()->paginate(15);
        }

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|max:2048',
            'vote_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,active,completed',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')
                ->store('events', 'public');
        }

        $validated['user_id'] = auth()->id();

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully');
    }

    public function show(Event $event)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $event->load(['categories.contestants' => function ($query) {
            $query->orderBy('total_votes', 'desc');
        }]);

        $totalVotes = 0;
        $totalRevenue = 0;

        // Calculate stats if event has categories
        if ($event->categories) {
            foreach ($event->categories as $category) {
                foreach ($category->contestants as $contestant) {
                    $totalVotes += $contestant->total_votes;
                }
            }
        }

        return view('admin.events.show', compact('event', 'totalVotes', 'totalRevenue'));
    }

    public function edit(Event $event)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|max:2048',
            'vote_price' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,active,completed',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')
                ->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($event->banner_image) {
            Storage::disk('public')->delete($event->banner_image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully');
    }
}