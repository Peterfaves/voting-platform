<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Vote;
use App\Models\Contestant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('organizer.reports.index', compact('events'));
    }

    public function download(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);
        
        $event = Event::where('id', $validated['event_id'])
            ->where('user_id', Auth::id())
            ->with(['categories.contestants'])
            ->firstOrFail();
        
        // Get statistics
        $totalVotes = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->count();
        
        $totalRevenue = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
        ->where('payment_status', 'success')
        ->sum('amount_paid');
        
        $contestants = Contestant::whereHas('category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
        ->with('category')
        ->orderBy('total_votes', 'desc')
        ->get();
        
        $votes = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
        ->with('contestant')
        ->latest()
        ->get();
        
        $pdf = Pdf::loadView('organizer.reports.pdf', compact(
            'event',
            'totalVotes',
            'totalRevenue',
            'contestants',
            'votes'
        ));
        
        return $pdf->download($event->slug . '-report.pdf');
    }
}