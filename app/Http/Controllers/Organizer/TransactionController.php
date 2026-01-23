<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Event;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Calculate stats
        $totalEarnings = Vote::whereHas('contestant.category.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('payment_status', 'success')
        ->sum('amount_paid');
        
        $totalWithdrawn = Withdrawal::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'processing'])
            ->sum('amount');
        
        $availableBalance = $totalEarnings - $totalWithdrawn;
        
        // Get all events for filter
        $events = Event::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Build query
        $query = Vote::whereHas('contestant.category.event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['contestant.category.event']);
        
        // Apply filters
        if ($request->filled('event_id')) {
            $query->whereHas('contestant.category', function ($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }
        
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('voter_email', 'like', "%{$search}%")
                  ->orWhere('payment_reference', 'like', "%{$search}%")
                  ->orWhereHas('contestant', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $transactions = $query->latest()->paginate(20);
        
        return view('organizer.transactions.index', compact(
            'transactions',
            'events',
            'availableBalance',
            'totalEarnings',
            'totalWithdrawn'
        ));
    }

    public function export(Request $request)
    {
        // Implementation for CSV export
        $user = Auth::user();
        
        $transactions = Vote::whereHas('contestant.category.event', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->with(['contestant.category.event'])
        ->latest()
        ->get();
        
        $filename = 'transactions-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        
        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Voter Email', 'Contestant', 'Event', 'Amount', 'Status', 'Date']);
            
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->voter_email,
                    $transaction->contestant->name ?? 'N/A',
                    $transaction->contestant->category->event->name ?? 'N/A',
                    '₦' . number_format($transaction->amount_paid, 2),
                    ucfirst($transaction->payment_status),
                    $transaction->created_at->format('M d, Y H:i'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}