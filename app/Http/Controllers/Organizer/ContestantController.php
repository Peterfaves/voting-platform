<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contestant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContestantController extends Controller
{
    /**
     * Show the form for creating a new contestant.
     */
    public function create(Category $category)
    {
        // Ensure user owns this category's event
        if ($category->event->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('organizer.contestants.create', compact('category'));
    }

    /**
     * Store a newly created contestant.
     */
    public function store(Request $request, Category $category)
    {
        if ($category->event->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
        ]);

        // Generate unique slug for this category
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Contestant::where('category_id', $category->id)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('contestants', 'public');
        }

        Contestant::create([
            'category_id' => $category->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'bio' => $validated['bio'] ?? null,
            'photo' => $photoPath,
            'video_url' => $validated['video_url'] ?? null,
            'total_votes' => 0,
            'status' => 'active',
        ]);

        return redirect()
            ->route('organizer.events.show', $category->event)
            ->with('success', 'Contestant added successfully!');
    }

    /**
     * Show the form for editing the contestant.
     */
    public function edit(Contestant $contestant)
    {
        // Ensure user owns this contestant's event
        if ($contestant->category->event->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('organizer.contestants.edit', compact('contestant'));
    }

    /**
     * Update the contestant.
     */
    public function update(Request $request, Contestant $contestant)
    {
        if ($contestant->category->event->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'status' => 'required|in:active,evicted',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($contestant->photo) {
                Storage::disk('public')->delete($contestant->photo);
            }
            $validated['photo'] = $request->file('photo')->store('contestants', 'public');
        }

        $contestant->update($validated);

        return redirect()
            ->route('organizer.events.show', $contestant->category->event)
            ->with('success', 'Contestant updated successfully!');
    }

    /**
     * Delete the contestant.
     */
    public function destroy(Contestant $contestant)
    {
        if ($contestant->category->event->user_id !== Auth::id()) {
            abort(403);
        }
        
        $event = $contestant->category->event;
        
        // Delete photo
        if ($contestant->photo) {
            Storage::disk('public')->delete($contestant->photo);
        }
        
        $contestant->delete();

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Contestant deleted successfully!');
    }
}