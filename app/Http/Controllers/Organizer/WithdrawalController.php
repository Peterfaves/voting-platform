<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WithdrawalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Calculate available balance (successful votes minus previous withdrawals)
        $totalEarnings = Vote::whereHas('contestant.category.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('payment_status', 'success')
        ->sum('amount_paid');
        
        $totalWithdrawn = Withdrawal::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'processing'])
            ->sum('amount');
        
        $availableBalance = $totalEarnings - $totalWithdrawn;
        
        // Get withdrawal history
        $withdrawals = Withdrawal::where('user_id', $user->id)
            ->latest()
            ->paginate(10);
        
        // Check if today is a withdrawal day (Monday, Wednesday, Friday)
        $today = Carbon::now()->dayOfWeek;
        $isWithdrawalDay = in_array($today, [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY]);
        
        return view('organizer.withdrawals.index', compact(
            'availableBalance',
            'totalEarnings',
            'totalWithdrawn',
            'withdrawals',
            'isWithdrawalDay'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Check if it's a withdrawal day
        $today = Carbon::now()->dayOfWeek;
        if (!in_array($today, [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY])) {
            return redirect()
                ->back()
                ->with('error', 'Withdrawals are only allowed on Mondays, Wednesdays, and Fridays.');
        }
        
        // Check if user has bank details
        if (!$user->bank_name || !$user->account_number || !$user->account_name) {
            return redirect()
                ->route('organizer.settings')
                ->with('error', 'Please update your bank details before requesting a withdrawal.');
        }
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);
        
        // Calculate available balance
        $totalEarnings = Vote::whereHas('contestant.category.event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->where('payment_status', 'success')
        ->sum('amount_paid');
        
        $totalWithdrawn = Withdrawal::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'processing'])
            ->sum('amount');
        
        $availableBalance = $totalEarnings - $totalWithdrawn;
        
        if ($validated['amount'] > $availableBalance) {
            return redirect()
                ->back()
                ->with('error', 'Insufficient balance.');
        }
        
        // Calculate platform fee (10%)
        $platformFee = $validated['amount'] * 0.10;
        $netAmount = $validated['amount'] - $platformFee;
        
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'platform_fee' => $platformFee,
            'net_amount' => $netAmount,
            'reference' => 'WTH-' . strtoupper(Str::random(10)),
            'bank_name' => $user->bank_name,
            'account_number' => $user->account_number,
            'account_name' => $user->account_name,
            'status' => 'pending',
        ]);
        
        return redirect()
            ->back()
            ->with('success', 'Withdrawal request submitted successfully!');
    }
}