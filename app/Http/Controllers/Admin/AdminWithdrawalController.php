<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\AuditLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminWithdrawalController extends Controller
{
    /**
     * Display a listing of withdrawals.
     */
    public function index(Request $request)
    {
        $query = Withdrawal::with(['user', 'processor']);

        // Search by user
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Default to pending first, then by date
        if (!$request->filled('status')) {
            $query->orderByRaw("FIELD(status, 'pending', 'processing', 'approved', 'completed', 'rejected')")
                  ->latest();
        } else {
            $query->latest();
        }

        $withdrawals = $query->paginate(20)->withQueryString();

        // Stats
        $stats = [
            'pending_count' => Withdrawal::pending()->count(),
            'pending_amount' => Withdrawal::pending()->sum('amount'),
            'approved_this_month' => Withdrawal::where('status', 'approved')
                ->whereMonth('processed_at', now()->month)
                ->whereYear('processed_at', now()->year)
                ->sum('net_amount'),
            'total_withdrawn' => Withdrawal::whereIn('status', ['approved', 'completed'])->sum('net_amount'),
        ];

        return view('admin.withdrawals.index', compact('withdrawals', 'stats'));
    }

    /**
     * Display the specified withdrawal.
     */
    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load(['user', 'processor']);

        // Get user's withdrawal history
        $userHistory = Withdrawal::where('user_id', $withdrawal->user_id)
            ->where('id', '!=', $withdrawal->id)
            ->latest()
            ->take(5)
            ->get();

        // Get user's total earnings
        $userEarnings = DB::table('votes')
            ->join('contestants', 'votes.contestant_id', '=', 'contestants.id')
            ->join('categories', 'contestants.category_id', '=', 'categories.id')
            ->join('events', 'categories.event_id', '=', 'events.id')
            ->where('events.user_id', $withdrawal->user_id)
            ->where('votes.payment_status', 'success')
            ->sum('votes.amount_paid');

        // Calculate available balance
        $totalWithdrawn = Withdrawal::where('user_id', $withdrawal->user_id)
            ->whereIn('status', ['approved', 'completed', 'pending', 'processing'])
            ->sum('amount');

        $availableBalance = $userEarnings - $totalWithdrawn;

        return view('admin.withdrawals.show', compact(
            'withdrawal',
            'userHistory',
            'userEarnings',
            'availableBalance'
        ));
    }

    /**
     * Approve a withdrawal request.
     */
    public function approve(Request $request, Withdrawal $withdrawal)
    {
        if (!$withdrawal->isPending()) {
            return back()->with('error', 'This withdrawal has already been processed.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $withdrawal->approve(auth()->user(), $request->notes);

            // TODO: Initiate actual bank transfer via payment gateway
            // $this->initiateTransfer($withdrawal);

            DB::commit();

            return back()->with('success', "Withdrawal of ₦" . number_format($withdrawal->amount) . " has been approved.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve withdrawal: ' . $e->getMessage());
        }
    }

    /**
     * Reject a withdrawal request.
     */
    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if (!$withdrawal->isPending()) {
            return back()->with('error', 'This withdrawal has already been processed.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $withdrawal->reject(auth()->user(), $request->rejection_reason, $request->notes);

            // TODO: Send notification to user about rejection
            // $withdrawal->user->notify(new WithdrawalRejected($withdrawal));

            DB::commit();

            return back()->with('success', "Withdrawal has been rejected.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reject withdrawal: ' . $e->getMessage());
        }
    }

    /**
     * Mark withdrawal as completed (after bank transfer is confirmed).
     */
    public function markCompleted(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'approved') {
            return back()->with('error', 'Only approved withdrawals can be marked as completed.');
        }

        $request->validate([
            'transaction_reference' => 'nullable|string|max:255',
        ]);

        $withdrawal->update([
            'status' => 'completed',
            'transaction_reference' => $request->transaction_reference,
        ]);

        // Log the action
        AuditLog::log(
            auth()->user(),
            'complete',
            $withdrawal,
            "Marked withdrawal as completed. Reference: " . ($request->transaction_reference ?? 'N/A')
        );

        return back()->with('success', "Withdrawal has been marked as completed.");
    }

    /**
     * Initiate bank transfer (placeholder for payment gateway integration).
     */
    protected function initiateTransfer(Withdrawal $withdrawal)
    {
        // This is where you'd integrate with Paystack/Flutterwave transfer API
        // Example with Paystack:
        /*
        $paystack = new \Yabacon\Paystack(config('services.paystack.secret'));
        
        $transfer = $paystack->transfer->initiate([
            'source' => 'balance',
            'amount' => $withdrawal->net_amount * 100, // Convert to kobo
            'recipient' => $withdrawal->user->paystack_recipient_code,
            'reason' => 'VoteAfrika Withdrawal #' . $withdrawal->id,
        ]);

        $withdrawal->update([
            'transaction_reference' => $transfer->data->transfer_code,
            'status' => 'processing',
        ]);
        */
    }
}
