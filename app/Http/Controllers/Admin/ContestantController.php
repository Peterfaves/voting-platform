<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contestant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContestantController extends Controller
{
    public function create(Category $category)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.contestants.create', compact('category'));
    }

    public function store(Request $request, Category $category)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('contestants', 'public');
        }

        $category->contestants()->create($validated);

        return redirect()->route('admin.events.show', $category->event)
            ->with('success', 'Contestant added successfully');
    }

    public function edit(Contestant $contestant)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $contestant->category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.contestants.edit', compact('contestant'));
    }

    public function update(Request $request, Contestant $contestant)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $contestant->category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:active,evicted',
        ]);

        if ($request->hasFile('photo')) {
            if ($contestant->photo) {
                Storage::disk('public')->delete($contestant->photo);
            }
            $validated['photo'] = $request->file('photo')
                ->store('contestants', 'public');
        }

        $contestant->update($validated);

        return redirect()->route('admin.events.show', $contestant->category->event)
            ->with('success', 'Contestant updated successfully');
    }

    public function destroy(Contestant $contestant)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $contestant->category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        if ($contestant->photo) {
            Storage::disk('public')->delete($contestant->photo);
        }

        $event = $contestant->category->event;
        $contestant->delete();

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Contestant deleted successfully');
    }

    public function evictBottom(Category $category)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $bottomThree = $category->contestants()
            ->where('status', 'active')
            ->orderBy('total_votes', 'asc')
            ->limit(3)
            ->get();

        foreach ($bottomThree as $contestant) {
            $contestant->update(['status' => 'evicted']);
        }

        return redirect()->route('admin.events.show', $category->event)
            ->with('success', 'Bottom 3 contestants evicted successfully');
    }
}