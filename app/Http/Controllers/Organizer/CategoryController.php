<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Show the form for creating a new category.
     */
    public function create(Event $event)
    {
        // Ensure user owns this event
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('organizer.categories.create', compact('event'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request, Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        // Generate unique slug for this event
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('event_id', $event->id)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        Category::create([
            'event_id' => $event->id,
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the category.
     */
    public function edit(Category $category)
    {
        // Ensure user owns this category's event
        if ($category->event->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('organizer.categories.edit', compact('category'));
    }

    /**
     * Update the category.
     */
    public function update(Request $request, Category $category)
    {
        if ($category->event->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $category->update($validated);

        return redirect()
            ->route('organizer.events.show', $category->event)
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Delete the category.
     */
    public function destroy(Category $category)
    {
        if ($category->event->user_id !== Auth::id()) {
            abort(403);
        }
        
        $event = $category->event;
        $category->delete();

        return redirect()
            ->route('organizer.events.show', $event)
            ->with('success', 'Category deleted successfully!');
    }
}