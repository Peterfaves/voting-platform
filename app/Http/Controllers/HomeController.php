<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'active')
            ->where('end_date', '>=', now())
            ->with(['categories', 'user'])
            ->latest()
            ->paginate(12);

        return view('home', compact('events'));
    }
}