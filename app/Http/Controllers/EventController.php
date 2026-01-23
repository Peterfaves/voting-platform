<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->with(['categories.contestants' => function ($query) {
                $query->where('status', 'active')
                      ->orderBy('total_votes', 'desc');
            }])
            ->firstOrFail();

        return view('events.show', compact('event'));
    }

    public function category($eventSlug, $categorySlug)
    {
        $event = Event::where('slug', $eventSlug)->firstOrFail();
        
        $category = $event->categories()
            ->where('slug', $categorySlug)
            ->with(['contestants' => function ($query) {
                $query->where('status', 'active')
                      ->orderBy('total_votes', 'desc');
            }])
            ->firstOrFail();

        return view('events.category', compact('event', 'category'));
    }
}