<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(Event $event)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.categories.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $event->categories()->create($validated);

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $category->update($validated);

        return redirect()->route('admin.events.show', $category->event)
            ->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        // Check if user owns this event or is admin
        if (!auth()->user()->isAdmin() && $category->event->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $event = $category->event;
        $category->delete();

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Category deleted successfully');
    }
}