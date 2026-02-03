@extends('admin.layouts.admin')

@section('title', 'Ticket Sales')

@section('breadcrumb')
<span>Ticket Sales</span>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Ticket Management</h1>
    <p class="page-subtitle">Monitor all ticket sales across the platform</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon primary">
                <i class="fas fa-ticket-alt"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_tickets_sold'] ?? 0) }}</div>
        <div class="stat-label">Total Tickets Sold</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-naira-sign"></i>
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['total_revenue'] ?? 0) }}</div>
        <div class="stat-label">Ticket Revenue</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-tags"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_ticket_types'] ?? 0 }}</div>
        <div class="stat-label">Ticket Types</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon warning">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['active_tickets'] ?? 0 }}</div>
        <div class="stat-label">Active Tickets</div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tickets..." 
                       style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
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
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="sold_out" {{ request('status') === 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
                Filter
            </button>
        </form>
    </div>
</div>

<!-- Tickets Table -->
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-ticket-alt"></i>
            All Tickets
        </h3>
    </div>
    <div class="card-body no-padding">
        @if($tickets->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Ticket Name</th>
                        <th>Price</th>
                        <th>Sold / Total</th>
                        <th>Revenue</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <h4>{{ Str::limit($ticket->event->name ?? 'N/A', 25) }}</h4>
                                    <p>by {{ $ticket->event->user->name ?? 'Unknown' }}</p>
                                </div>
                            </td>
                            <td><strong>{{ $ticket->name }}</strong></td>
                            <td>₦{{ number_format($ticket->price) }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-weight: 600;">{{ $ticket->sold_count ?? 0 }}</span>
                                    <span style="color: var(--text-light);">/</span>
                                    <span>{{ $ticket->quantity }}</span>
                                </div>
                                <div style="width: 80px; height: 4px; background: var(--border-color); border-radius: 2px; margin-top: 4px;">
                                    @php $percentage = $ticket->quantity > 0 ? (($ticket->sold_count ?? 0) / $ticket->quantity) * 100 : 0; @endphp
                                    <div style="width: {{ $percentage }}%; height: 100%; background: var(--success); border-radius: 2px;"></div>
                                </div>
                            </td>
                            <td><strong style="color: var(--success);">₦{{ number_format($ticket->total_revenue ?? 0) }}</strong></td>
                            <td>
                                @if($ticket->status === 'active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($ticket->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-ticket-alt"></i>
                <h3>No Tickets Found</h3>
                <p>No tickets match your current filters.</p>
            </div>
        @endif
    </div>
</div>

<!-- Recent Purchases -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-cart"></i>
            Recent Purchases
        </h3>
    </div>
    <div class="card-body no-padding">
        @if(isset($recentPurchases) && $recentPurchases->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Buyer</th>
                        <th>Ticket</th>
                        <th>Event</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPurchases as $purchase)
                        <tr>
                            <td>
                                <span class="font-mono" style="font-size: 12px;">#{{ str_pad($purchase->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <h4>{{ $purchase->user->name ?? $purchase->buyer_name ?? 'Guest' }}</h4>
                                    <p style="font-size: 11px;">{{ $purchase->user->email ?? $purchase->buyer_email ?? '' }}</p>
                                </div>
                            </td>
                            <td>{{ $purchase->ticket->name ?? 'N/A' }}</td>
                            <td>{{ Str::limit($purchase->ticket->event->name ?? 'N/A', 20) }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td><strong style="color: var(--success);">₦{{ number_format($purchase->total_amount) }}</strong></td>
                            <td>{{ $purchase->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-shopping-cart"></i>
                <p>No recent purchases</p>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($tickets->hasPages())
    <div style="margin-top: 24px; display: flex; justify-content: center;">
        {{ $tickets->links() }}
    </div>
@endif
@endsection
