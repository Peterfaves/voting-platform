@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
<span>Dashboard</span>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Dashboard Overview</h1>
    <p class="page-subtitle">Welcome back! Here's what's happening on VoteAfrika today.</p>
</div>

<!-- Primary Stats -->
<div class="stats-grid">
    <!-- Total Revenue -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon primary">
                <i class="fas fa-naira-sign"></i>
            </div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                12.5%
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['total_revenue'] ?? 0) }}</div>
        <div class="stat-label">Total Platform Revenue</div>
    </div>

    <!-- Platform Earnings (Fees) -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-coins"></i>
            </div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                8.2%
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['platform_earnings'] ?? 0) }}</div>
        <div class="stat-label">Platform Earnings (Fees)</div>
    </div>

    <!-- Total Organizers -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                5.3%
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_organizers'] ?? 0) }}</div>
        <div class="stat-label">Registered Organizers</div>
    </div>

    <!-- Total Events -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon warning">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_events'] ?? 0) }}</div>
        <div class="stat-label">Total Events Created</div>
    </div>
</div>

<!-- Secondary Stats Row -->
<div class="stats-grid mb-6">
    <!-- Total Votes -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon primary">
                <i class="fas fa-vote-yea"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_votes'] ?? 0) }}</div>
        <div class="stat-label">Total Votes Cast</div>
    </div>

    <!-- Tickets Sold -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-ticket-alt"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['tickets_sold'] ?? 0) }}</div>
        <div class="stat-label">Tickets Sold</div>
    </div>

    <!-- Pending Withdrawals -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon danger">
                <i class="fas fa-clock"></i>
            </div>
            @if(($stats['pending_withdrawals_count'] ?? 0) > 0)
                <span class="badge badge-danger">Action Required</span>
            @endif
        </div>
        <div class="stat-value">{{ $stats['pending_withdrawals_count'] ?? 0 }}</div>
        <div class="stat-label">Pending Withdrawals</div>
    </div>

    <!-- Active Events -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-broadcast-tower"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['active_events'] ?? 0 }}</div>
        <div class="stat-label">Live Events</div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid-2 mb-6">
    <!-- Revenue Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-line"></i>
                Revenue Overview
            </h3>
            <select class="btn btn-secondary btn-sm" style="padding: 6px 12px; font-size: 12px;">
                <option>Last 7 Days</option>
                <option>Last 30 Days</option>
                <option>Last 90 Days</option>
            </select>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <i class="fas fa-chart-area" style="font-size: 48px; opacity: 0.3;"></i>
                <p style="margin-top: 12px;">Revenue chart will be displayed here</p>
            </div>
        </div>
    </div>

    <!-- Voting Activity Chart -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-bar"></i>
                Voting Activity
            </h3>
            <select class="btn btn-secondary btn-sm" style="padding: 6px 12px; font-size: 12px;">
                <option>Last 7 Days</option>
                <option>Last 30 Days</option>
            </select>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <i class="fas fa-chart-bar" style="font-size: 48px; opacity: 0.3;"></i>
                <p style="margin-top: 12px;">Voting activity chart will be displayed here</p>
            </div>
        </div>
    </div>
</div>

<!-- Tables Section -->
<div class="grid-2">
    <!-- Pending Withdrawals -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-hand-holding-usd"></i>
                Pending Withdrawals
            </h3>
            <a href="{{ route('admin.withdrawals.index') ?? '#' }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="card-body no-padding">
            @if(isset($pendingWithdrawals) && count($pendingWithdrawals) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Organizer</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingWithdrawals as $withdrawal)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar">{{ strtoupper(substr($withdrawal->user->name ?? 'U', 0, 1)) }}</div>
                                        <div class="user-info">
                                            <h4>{{ $withdrawal->user->name ?? 'Unknown' }}</h4>
                                            <p>{{ $withdrawal->user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>₦{{ number_format($withdrawal->amount) }}</strong></td>
                                <td>{{ $withdrawal->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.withdrawals.show', $withdrawal) ?? '#' }}" class="btn btn-primary btn-sm">Review</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-check-circle"></i>
                    <h3>All Caught Up!</h3>
                    <p>No pending withdrawal requests.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-exchange-alt"></i>
                Recent Transactions
            </h3>
            <a href="{{ route('admin.transactions.index') ?? '#' }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="card-body no-padding">
            @if(isset($recentTransactions) && count($recentTransactions) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Voter</th>
                            <th>Event</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <h4>{{ $transaction->voter_name ?? 'Anonymous' }}</h4>
                                        <p class="text-muted font-mono" style="font-size: 11px;">{{ $transaction->voter_email ?? '' }}</p>
                                    </div>
                                </td>
                                <td>{{ Str::limit($transaction->contestant->category->event->name ?? 'N/A', 20) }}</td>
                                <td><strong>₦{{ number_format($transaction->amount_paid) }}</strong></td>
                                <td>
                                    <span class="badge badge-{{ $transaction->payment_status === 'success' ? 'success' : ($transaction->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($transaction->payment_status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No Transactions</h3>
                    <p>Transactions will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bottom Section -->
<div class="grid-3 mt-6">
    <!-- Top Events -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-trophy"></i>
                Top Events
            </h3>
        </div>
        <div class="card-body no-padding">
            @if(isset($topEvents) && count($topEvents) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Votes</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topEvents as $event)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <h4>{{ Str::limit($event->name, 25) }}</h4>
                                        <p>by {{ $event->user->name ?? 'Unknown' }}</p>
                                    </div>
                                </td>
                                <td>{{ number_format($event->total_votes ?? 0) }}</td>
                                <td><strong>₦{{ number_format($event->total_revenue ?? 0) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>No events yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Top Organizers -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-star"></i>
                Top Organizers
            </h3>
        </div>
        <div class="card-body no-padding">
            @if(isset($topOrganizers) && count($topOrganizers) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Organizer</th>
                            <th>Events</th>
                            <th>Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topOrganizers as $organizer)
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar" style="width: 32px; height: 32px; font-size: 12px;">{{ strtoupper(substr($organizer->name, 0, 1)) }}</div>
                                        <div class="user-info">
                                            <h4>{{ $organizer->name }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $organizer->events_count ?? 0 }}</td>
                                <td><strong>₦{{ number_format($organizer->total_earnings ?? 0) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>No organizers yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i>
                Quick Stats
            </h3>
        </div>
        <div class="card-body">
            <div style="space-y: 16px;">
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-medium);">Events Today</span>
                    <strong>{{ $stats['events_today'] ?? 0 }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-medium);">Votes Today</span>
                    <strong>{{ number_format($stats['votes_today'] ?? 0) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-medium);">Revenue Today</span>
                    <strong>₦{{ number_format($stats['revenue_today'] ?? 0) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                    <span style="color: var(--text-medium);">New Users Today</span>
                    <strong>{{ $stats['new_users_today'] ?? 0 }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 12px 0;">
                    <span style="color: var(--text-medium);">Platform Fee Rate</span>
                    <strong>{{ $stats['platform_fee_rate'] ?? 10 }}%</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
