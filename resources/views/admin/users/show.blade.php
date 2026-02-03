@extends('admin.layouts.admin')

@section('title', $organizer->name . ' - Organizer Details')

@section('breadcrumb')
<a href="{{ route('admin.users.index') }}">Organizers</a>
<i class="fas fa-chevron-right"></i>
<span>{{ $organizer->name }}</span>
@endsection

@section('content')
<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
    <div style="display: flex; align-items: center; gap: 20px;">
        <div class="user-avatar" style="width: 72px; height: 72px; font-size: 28px; border-radius: 16px;">
            {{ strtoupper(substr($organizer->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="page-title" style="margin-bottom: 4px;">{{ $organizer->name }}</h1>
            <p style="color: var(--text-light); font-size: 14px;">{{ $organizer->email }}</p>
            <div style="display: flex; gap: 8px; margin-top: 8px;">
                @if($organizer->status === 'suspended')
                    <span class="badge badge-danger">Suspended</span>
                @else
                    <span class="badge badge-success">Active</span>
                @endif
                <span class="badge badge-secondary">Joined {{ $organizer->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
    <div style="display: flex; gap: 12px;">
        @if($organizer->status === 'suspended')
            <form method="POST" action="{{ route('admin.users.activate', $organizer) }}">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    Activate Account
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.users.suspend', $organizer) }}" onsubmit="return confirm('Are you sure you want to suspend this organizer?')">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-ban"></i>
                    Suspend Account
                </button>
            </form>
        @endif
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
        <div class="stat-value">{{ $organizer->events_count ?? $organizer->events->count() }}</div>
        <div class="stat-label">Total Events</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon primary">
                <i class="fas fa-vote-yea"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_votes'] ?? 0) }}</div>
        <div class="stat-label">Total Votes Received</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-naira-sign"></i>
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['total_earnings'] ?? 0) }}</div>
        <div class="stat-label">Total Earnings</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon warning">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['total_withdrawn'] ?? 0) }}</div>
        <div class="stat-label">Total Withdrawn</div>
    </div>
</div>

<div class="grid-2">
    <!-- Left Column -->
    <div>
        <!-- Account Information -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    Account Information
                </h3>
            </div>
            <div class="card-body">
                <table style="width: 100%;">
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light); width: 40%;">Full Name</td>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600;">{{ $organizer->name }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Email Address</td>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600;">{{ $organizer->email }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Phone Number</td>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600;">{{ $organizer->phone ?? 'Not provided' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Email Verified</td>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color);">
                            @if($organizer->email_verified_at)
                                <span class="badge badge-success">Verified</span>
                            @else
                                <span class="badge badge-warning">Not Verified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Registration Date</td>
                        <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600;">{{ $organizer->created_at->format('F d, Y') }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; color: var(--text-light);">Last Login</td>
                        <td style="padding: 12px 0; font-weight: 600;">{{ $organizer->last_login_at ? $organizer->last_login_at->diffForHumans() : 'Never' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Bank Details -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-university"></i>
                    Bank Details
                </h3>
            </div>
            <div class="card-body">
                @if($organizer->bank_name)
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light); width: 40%;">Bank Name</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600;">{{ $organizer->bank_name }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); color: var(--text-light);">Account Number</td>
                            <td style="padding: 12px 0; border-bottom: 1px solid var(--border-color); font-weight: 600; font-family: monospace;">{{ $organizer->account_number }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: var(--text-light);">Account Name</td>
                            <td style="padding: 12px 0; font-weight: 600;">{{ $organizer->account_name }}</td>
                        </tr>
                    </table>
                @else
                    <div class="empty-state" style="padding: 32px;">
                        <i class="fas fa-university" style="font-size: 32px;"></i>
                        <p style="margin-top: 12px;">Bank details not configured</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div>
        <!-- Recent Events -->
        <div class="card mb-6">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-check"></i>
                    Recent Events
                </h3>
                <a href="{{ route('admin.events.index', ['organizer' => $organizer->id]) }}" class="btn btn-secondary btn-sm">View All</a>
            </div>
            <div class="card-body no-padding">
                @if($organizer->events->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Votes</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($organizer->events->take(5) as $event)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <h4>{{ Str::limit($event->name, 25) }}</h4>
                                            <p>{{ $event->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </td>
                                    <td>{{ number_format($event->total_votes ?? 0) }}</td>
                                    <td>
                                        @if($event->status === 'active')
                                            <span class="badge badge-success">Live</span>
                                        @elseif($event->status === 'draft')
                                            <span class="badge badge-warning">Draft</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($event->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state" style="padding: 32px;">
                        <i class="fas fa-calendar-times"></i>
                        <p>No events created yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Withdrawal History -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-hand-holding-usd"></i>
                    Withdrawal History
                </h3>
                <a href="{{ route('admin.withdrawals.index', ['user' => $organizer->id]) }}" class="btn btn-secondary btn-sm">View All</a>
            </div>
            <div class="card-body no-padding">
                @if(isset($withdrawals) && $withdrawals->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdrawals->take(5) as $withdrawal)
                                <tr>
                                    <td><strong>₦{{ number_format($withdrawal->amount) }}</strong></td>
                                    <td>
                                        @if($withdrawal->status === 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @elseif($withdrawal->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $withdrawal->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state" style="padding: 32px;">
                        <i class="fas fa-hand-holding-usd"></i>
                        <p>No withdrawals yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Admin Notes Section -->
<div class="card mt-6">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-sticky-note"></i>
            Admin Notes
        </h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.note', $organizer) }}">
            @csrf
            <textarea name="note" rows="3" placeholder="Add a note about this organizer (only visible to admins)..."
                      style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; resize: vertical; margin-bottom: 16px;">{{ $organizer->admin_notes ?? '' }}</textarea>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Save Note
            </button>
        </form>
    </div>
</div>
@endsection
