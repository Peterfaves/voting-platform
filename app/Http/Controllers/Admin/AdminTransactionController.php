<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Event;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminTransactionController extends Controller
{
    /**
     * Display a listing of all transactions.
     */
    public function index(Request $request)
    {
        $query = Vote::with(['contestant.category.event', 'contestant.category.event.user']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('voter_email', 'like', "%{$search}%")
                  ->orWhere('voter_name', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhereHas('contestant', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by event
        if ($request->filled('event')) {
            $query->whereHas('contestant.category', function ($q) use ($request) {
                $q->where('event_id', $request->event);
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $transactions = $query->latest()->paginate(30)->withQueryString();

        // Events for filter dropdown
        $events = Event::orderBy('name')->get(['id', 'name']);

        // Stats
        $stats = [
            'total_revenue' => Vote::where('payment_status', 'success')->sum('amount_paid'),
            'successful_transactions' => Vote::where('payment_status', 'success')->count(),
            'pending_transactions' => Vote::where('payment_status', 'pending')->count(),
            'failed_transactions' => Vote::where('payment_status', 'failed')->count(),
            'available_balance' => $this->calculateAvailableBalance(),
            'total_earnings' => Vote::where('payment_status', 'success')->sum('amount_paid'),
            'total_withdrawn' => Withdrawal::whereIn('status', ['approved', 'completed'])->sum('net_amount'),
        ];

        return view('admin.transactions.index', compact('transactions', 'events', 'stats'));
    }

    /**
     * Display the specified transaction.
     */
    public function show(Vote $transaction)
    {
        $transaction->load(['contestant.category.event.user']);

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Export transactions to CSV.
     */
    public function export(Request $request)
    {
        $query = Vote::with(['contestant.category.event']);

        // Apply same filters as index
        if ($request->filled('event')) {
            $query->whereHas('contestant.category', function ($q) use ($request) {
                $q->where('event_id', $request->event);
            });
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $transactions = $query->latest()->get();

        $filename = 'transactions_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'Transaction ID',
                'Reference',
                'Voter Name',
                'Voter Email',
                'Contestant',
                'Event',
                'Votes',
                'Amount',
                'Status',
                'Date',
            ]);

            // Data rows
            foreach ($transactions as $t) {
                fputcsv($file, [
                    $t->id,
                    $t->reference ?? 'N/A',
                    $t->voter_name ?? 'Anonymous',
                    $t->voter_email ?? 'N/A',
                    $t->contestant->name ?? 'N/A',
                    $t->contestant->category->event->name ?? 'N/A',
                    $t->number_of_votes,
                    $t->amount_paid,
                    $t->payment_status,
                    $t->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate total available balance (revenue - withdrawals).
     */
    protected function calculateAvailableBalance(): float
    {
        $totalRevenue = Vote::where('payment_status', 'success')->sum('amount_paid');
        $totalWithdrawn = Withdrawal::whereIn('status', ['approved', 'completed', 'pending', 'processing'])->sum('amount');

        return max(0, $totalRevenue - $totalWithdrawn);
    }
}
