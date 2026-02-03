@extends('admin.layouts.admin')

@section('title', 'All Transactions')

@section('breadcrumb')
<span>Transactions</span>
@endsection

@section('content')
<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
    <div class="page-header" style="margin-bottom: 0;">
        <h1 class="page-title">Transactions</h1>
        <p class="page-subtitle">Complete financial transparency for all platform transactions</p>
    </div>
    <button class="btn btn-secondary">
        <i class="fas fa-download"></i>
        Export CSV
    </button>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon primary">
                <i class="fas fa-naira-sign"></i>
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['total_revenue'] ?? 0) }}</div>
        <div class="stat-label">Total Revenue</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['successful_transactions'] ?? 0) }}</div>
        <div class="stat-label">Successful Transactions</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon warning">
                <i class="fas fa-clock"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['pending_transactions'] ?? 0) }}</div>
        <div class="stat-label">Pending</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon danger">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['failed_transactions'] ?? 0) }}</div>
        <div class="stat-label">Failed</div>
    </div>
</div>

<!-- Financial Summary Cards -->
<div class="grid-3 mb-6">
    <div class="card">
        <div class="card-body" style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: var(--success-bg); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-wallet" style="font-size: 24px; color: var(--success);"></i>
            </div>
            <div>
                <p style="font-size: 13px; color: var(--text-light); margin-bottom: 4px;">Available Balance</p>
                <h3 style="font-size: 24px; font-weight: 700;">₦{{ number_format($stats['available_balance'] ?? 0) }}</h3>
                <p style="font-size: 12px; color: var(--success);">Ready to withdraw</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body" style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: var(--warning-bg); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-hand-holding-usd" style="font-size: 24px; color: var(--warning);"></i>
            </div>
            <div>
                <p style="font-size: 13px; color: var(--text-light); margin-bottom: 4px;">Total Earnings</p>
                <h3 style="font-size: 24px; font-weight: 700;">₦{{ number_format($stats['total_earnings'] ?? 0) }}</h3>
                <p style="font-size: 12px; color: var(--text-light);">Lifetime earnings</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body" style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: var(--info-bg); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-money-bill-transfer" style="font-size: 24px; color: var(--info);"></i>
            </div>
            <div>
                <p style="font-size: 13px; color: var(--text-light); margin-bottom: 4px;">Total Withdrawals</p>
                <h3 style="font-size: 24px; font-weight: 700;">₦{{ number_format($stats['total_withdrawn'] ?? 0) }}</h3>
                <p style="font-size: 12px; color: var(--text-light);">Withdrawn to date</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Search</label>
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Email, contestant, or ID..." 
                           style="width: 100%; padding: 10px 14px 10px 42px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
                </div>
            </div>
            <div style="min-width: 180px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Event</label>
                <select name="event" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Events</option>
                    @foreach($events ?? [] as $event)
                        <option value="{{ $event->id }}" {{ request('event') == $event->id ? 'selected' : '' }}>
                            {{ Str::limit($event->name, 25) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="min-width: 140px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Status</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div style="min-width: 150px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Date</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
                Filter
            </button>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Reset
            </a>
        </form>
    </div>
</div>

<!-- Transactions Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-exchange-alt"></i>
            All Transactions
        </h3>
        <span style="font-size: 14px; color: var(--text-light);">
            {{ $transactions->total() ?? 0 }} total transactions
        </span>
    </div>
    <div class="card-body no-padding">
        @if($transactions->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Voter</th>
                        <th>Contestant</th>
                        <th>Event</th>
                        <th>Votes</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>
                                <span class="font-mono" style="font-size: 12px; background: var(--main-bg); padding: 4px 8px; border-radius: 4px;">
                                    {{ $transaction->reference ?? 'VOTE-' . str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <h4>{{ $transaction->voter_name ?? 'Anonymous' }}</h4>
                                    <p style="font-size: 11px;">{{ $transaction->voter_email ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <h4>{{ $transaction->contestant->name ?? 'N/A' }}</h4>
                                    <p style="font-size: 11px;">ID: {{ $transaction->contestant_id ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td>{{ Str::limit($transaction->contestant->category->event->name ?? 'N/A', 20) }}</td>
                            <td><strong>{{ number_format($transaction->number_of_votes ?? 1) }}</strong></td>
                            <td><strong style="color: var(--success);">₦{{ number_format($transaction->amount_paid ?? 0) }}</strong></td>
                            <td>
                                @if($transaction->payment_status === 'success')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i>
                                        Success
                                    </span>
                                @elseif($transaction->payment_status === 'pending')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i>
                                        Pending
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i>
                                        Failed
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div style="font-size: 11px; color: var(--text-light);">{{ $transaction->created_at->format('h:i A') }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Transactions Found</h3>
                <p>No transactions match your current filters.</p>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($transactions->hasPages())
    <div style="margin-top: 24px; display: flex; justify-content: center;">
        {{ $transactions->links() }}
    </div>
@endif
@endsection
