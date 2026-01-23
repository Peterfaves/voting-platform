<?php
// app/Http/Controllers/Admin/VoteAnalyticsController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteAnalyticsController extends Controller
{
    public function index(Event $event)
    {
        $this->authorize('view', $event);

        $votes = Vote::whereHas('contestant.category', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
        ->where('payment_status', 'success')
        ->with('contestant.category')
        ->latest()
        ->paginate(50);

        $rankings = $event->categories->flatMap(function ($category) {
            return $category->contestants()
                ->where('status', 'active')
                ->orderBy('total_votes', 'desc')
                ->get()
                ->map(function ($contestant, $index) use ($category) {
                    return [
                        'rank' => $index + 1,
                        'contestant' => $contestant,
                        'category' => $category,
                    ];
                });
        });

        return view('admin.analytics.votes', compact('event', 'votes', 'rankings'));
    }
}