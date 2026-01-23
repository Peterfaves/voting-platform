@extends('layouts.organizer')

@section('title', 'Transactions')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">Transactions</h1>
    <p style="color: var(--text-light);">Complete financial transparency for all your events.</p>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 32px;">
    <div class="section-card" style="padding: 24px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <div style="width: 48px; height: 48px; background: #FEF3C7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-wallet" style="color: var(--primary-gold); font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Available Balance</div>
                <div style="font-size: 24px; font-weight: 800; color: var(--text-dark);">₦{{ number_format($availableBalance) }}</div>
                <div style="font-size: 11px; color: var(--primary-gold); font-style: italic;">Ready To Withdraw?</div>
            </div>
        </div>
    </div>

    <div class="section-card" style="padding: 24px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <div style="width: 48px; height: 48px; background: #DCFCE7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-hand-holding-usd" style="color: #22C55E; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Total Earnings</div>
                <div style="font-size: 24px; font-weight: 800; color: var(--text-dark);">₦{{ number_format($totalEarnings) }}</div>
                <div style="font-size: 11px; color: #22C55E; font-style: italic;">lifetime earnings</div>
            </div>
        </div>
    </div>

    <div class="section-card" style="padding: 24px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <div style="width: 48px; height: 48px; background: #E0E7FF; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-money-bill-transfer" style="color: #6366F1; font-size: 20px;"></i>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Total Withdrawals</div>
                <div style="font-size: 24px; font-weight: 800; color: var(--text-dark);">₦{{ number_format($totalWithdrawn) }}</div>
                <div style="font-size: 11px; color: #6366F1; font-style: italic;">Withdrawn To Date</div>
            </div>
        </div>
    </div>

    <div class="section-card" style="padding: 24px; background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-dark) 100%); color: white;">
        <div style="margin-bottom: 12px;">
            <div style="font-size: 14px; margin-bottom: 8px; opacity: 0.9;">Ready to withdraw?</div>
            <div style="font-size: 20px; font-weight: 700; margin-bottom: 16px;">Proceed to Withdrawal</div>
        </div>
        <a href="{{ route('organizer.withdrawals') }}" 
           style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: white; color: var(--primary-gold); border-radius: 8px; text-decoration: none; font-weight: 600;">
            <span>Withdraw</span>
            <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Filters and Search -->
<div class="section-card" style="margin-bottom: 24px;">
    <form method="GET" action="{{ route('organizer.transactions') }}">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <select name="event_id" 
                        style="width: 100%; padding: 12px 16px; border: 2px solid var(--border-light); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Events</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                            {{ $event->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <input type="date" 
                       name="date" 
                       value="{{ request('date') }}"
                       style="width: 100%; padding: 12px 16px; border: 2px solid var(--border-light); border-radius: 10px; font-size: 14px;">
            </div>

            <div style="display: flex; gap: 8px;">
                <button type="submit" 
                        style="flex: 1; padding: 12px; background: var(--primary-gold); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('organizer.transactions') }}" 
                   style="padding: 12px 16px; border: 2px solid var(--border-light); color: var(--text-medium); border-radius: 10px; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-redo"></i>
                </a>
            </div>
        </div>

        <div style="position: relative;">
            <i class="fas fa-search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search email, contestants, or ID"
                   style="width: 100%; padding: 12px 16px 12px 45px; border: 2px solid var(--border-light); border-radius: 10px; font-size: 14px;">
        </div>
    </form>
</div>

<!-- Transactions Table -->
<div class="section-card">
    @if($transactions->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-light);">
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Voter's Email</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Contestants</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Event</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Amount</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Date & Time</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr style="border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; margin-bottom: 4px;">{{ $transaction->voter_email }}</div>
                                <div style="font-size: 12px; color: var(--text-light);">{{ $transaction->payment_reference }}</div>
                            </td>
                            <td style="padding: 16px; font-weight: 500;">{{ $transaction->contestant->name ?? 'N/A' }}</td>
                            <td style="padding: 16px; color: var(--text-medium);">{{ $transaction->contestant->category->event->name ?? 'N/A' }}</td>
                            <td style="padding: 16px; font-weight: 700; color: var(--primary-gold);">₦{{ number_format($transaction->amount_paid, 2) }}</td>
                            <td style="padding: 16px; color: var(--text-medium); font-size: 14px;">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                            <td style="padding: 16px;">
                                <span style="padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                    {{ $transaction->payment_status === 'success' ? 'background: #DCFCE7; color: #166534;' : 
                                       ($transaction->payment_status === 'pending' ? 'background: #FEF3C7; color: #92400E;' : 
                                       'background: #FEE2E2; color: #991B1B;') }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 24px;">
            {{ $transactions->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 60px; color: var(--text-light);">
            <i class="fas fa-receipt" style="font-size: 64px; opacity: 0.3; margin-bottom: 20px;"></i>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">No transactions found.</h3>
            <p>Transactions will appear here once votes are cast.</p>
        </div>
    @endif
</div>
@endsection