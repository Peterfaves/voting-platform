@extends('admin.layouts.admin')

@section('title', 'Manage Organizers')

@section('breadcrumb')
<span>Organizers</span>
@endsection

@section('content')
<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
    <div class="page-header" style="margin-bottom: 0;">
        <h1 class="page-title">Organizers</h1>
        <p class="page-subtitle">Manage all registered organizers on the platform</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <button class="btn btn-secondary">
            <i class="fas fa-download"></i>
            Export
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_organizers'] ?? 0) }}</div>
        <div class="stat-label">Total Organizers</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['active_organizers'] ?? 0) }}</div>
        <div class="stat-label">Active Organizers</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon warning">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['new_this_month'] ?? 0) }}</div>
        <div class="stat-label">New This Month</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon danger">
                <i class="fas fa-user-slash"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['suspended_organizers'] ?? 0) }}</div>
        <div class="stat-label">Suspended</div>
    </div>
</div>

<!-- Filters & Search -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 250px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Search</label>
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email..." 
                           style="width: 100%; padding: 10px 14px 10px 42px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
                </div>
            </div>
            <div style="min-width: 150px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div style="min-width: 150px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Sort By</label>
                <select name="sort" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="events" {{ request('sort') === 'events' ? 'selected' : '' }}>Most Events</option>
                    <option value="earnings" {{ request('sort') === 'earnings' ? 'selected' : '' }}>Highest Earnings</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
                Filter
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Reset
            </a>
        </form>
    </div>
</div>

<!-- Organizers Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-users"></i>
            All Organizers
        </h3>
        <span style="font-size: 14px; color: var(--text-light);">
            Showing {{ $organizers->firstItem() ?? 0 }} - {{ $organizers->lastItem() ?? 0 }} of {{ $organizers->total() ?? 0 }}
        </span>
    </div>
    <div class="card-body no-padding">
        @if($organizers->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Organizer</th>
                        <th>Events</th>
                        <th>Total Votes</th>
                        <th>Total Earnings</th>
                        <th>Withdrawals</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($organizers as $organizer)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar" style="background: linear-gradient(135deg, {{ ['#667eea', '#f093fb', '#4facfe', '#43e97b', '#fa709a'][array_rand(['#667eea', '#f093fb', '#4facfe', '#43e97b', '#fa709a'])] }} 0%, {{ ['#764ba2', '#f5576c', '#00f2fe', '#38f9d7', '#fee140'][array_rand(['#764ba2', '#f5576c', '#00f2fe', '#38f9d7', '#fee140'])] }} 100%);">
                                        {{ strtoupper(substr($organizer->name, 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <h4>{{ $organizer->name }}</h4>
                                        <p>{{ $organizer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600;">{{ $organizer->events_count ?? 0 }}</span>
                                <span style="color: var(--text-light); font-size: 12px;">events</span>
                            </td>
                            <td>{{ number_format($organizer->total_votes ?? 0) }}</td>
                            <td><strong style="color: var(--success);">₦{{ number_format($organizer->total_earnings ?? 0) }}</strong></td>
                            <td>₦{{ number_format($organizer->total_withdrawn ?? 0) }}</td>
                            <td>
                                @if($organizer->status === 'suspended')
                                    <span class="badge badge-danger">Suspended</span>
                                @else
                                    <span class="badge badge-success">Active</span>
                                @endif
                            </td>
                            <td>{{ $organizer->created_at->format('M d, Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('admin.users.show', $organizer) }}" class="btn btn-secondary btn-sm btn-icon" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($organizer->status === 'suspended')
                                        <form method="POST" action="{{ route('admin.users.activate', $organizer) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm btn-icon" title="Activate">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.suspend', $organizer) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Suspend" onclick="return confirm('Are you sure you want to suspend this organizer?')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h3>No Organizers Found</h3>
                <p>No organizers match your current filters.</p>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($organizers->hasPages())
    <div style="margin-top: 24px; display: flex; justify-content: center;">
        {{ $organizers->links() }}
    </div>
@endif
@endsection