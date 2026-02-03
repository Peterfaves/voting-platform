@extends('admin.layouts.admin')

@section('title', 'All Events')

@section('breadcrumb')
<span>Events</span>
@endsection

@section('content')
<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
    <div class="page-header" style="margin-bottom: 0;">
        <h1 class="page-title">Event Management</h1>
        <p class="page-subtitle">Monitor and manage all events on the platform</p>
    </div>
    <button class="btn btn-secondary">
        <i class="fas fa-download"></i>
        Export Data
    </button>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_events'] ?? 0) }}</div>
        <div class="stat-label">Total Events</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-broadcast-tower"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['active_events'] ?? 0 }}</div>
        <div class="stat-label">Live Events</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon warning">
                <i class="fas fa-edit"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['draft_events'] ?? 0 }}</div>
        <div class="stat-label">Draft Events</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon primary">
                <i class="fas fa-check-double"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['completed_events'] ?? 0 }}</div>
        <div class="stat-label">Completed Events</div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-body">
        <form method="GET" style="display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;">
            <div style="flex: 1; min-width: 250px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Search</label>
                <div style="position: relative;">
                    <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..." 
                           style="width: 100%; padding: 10px 14px 10px 42px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px;">
                </div>
            </div>
            <div style="min-width: 150px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
            <div style="min-width: 180px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Organizer</label>
                <select name="organizer" style="width: 100%; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; background: white;">
                    <option value="">All Organizers</option>
                    @foreach($organizers ?? [] as $organizer)
                        <option value="{{ $organizer->id }}" {{ request('organizer') == $organizer->id ? 'selected' : '' }}>
                            {{ $organizer->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
                Filter
            </button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Reset
            </a>
        </form>
    </div>
</div>

<!-- Events Table -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-calendar-check"></i>
            All Events
        </h3>
        <span style="font-size: 14px; color: var(--text-light);">
            {{ $events->total() ?? 0 }} total events
        </span>
    </div>
    <div class="card-body no-padding">
        @if($events->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Organizer</th>
                        <th>Categories</th>
                        <th>Contestants</th>
                        <th>Total Votes</th>
                        <th>Revenue</th>
                        <th>Vote Price</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    @if($event->banner_image)
                                        <img src="{{ asset('storage/' . $event->banner_image) }}" 
                                             alt="{{ $event->name }}"
                                             style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover;">
                                    @else
                                        <div style="width: 48px; height: 48px; border-radius: 8px; background: linear-gradient(135deg, #dab904 0%, #bc893a 100%); display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-trophy" style="color: white;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 style="font-weight: 600; color: var(--text-dark); margin-bottom: 2px;">{{ Str::limit($event->name, 30) }}</h4>
                                        <p style="font-size: 12px; color: var(--text-light);">ID: {{ $event->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="user-info">
                                    <h4>{{ $event->user->name ?? 'Unknown' }}</h4>
                                    <p style="font-size: 11px;">{{ $event->user->email ?? '' }}</p>
                                </div>
                            </td>
                            <td>{{ $event->categories_count ?? $event->categories->count() }}</td>
                            <td>{{ $event->contestants_count ?? 0 }}</td>
                            <td><strong>{{ number_format($event->total_votes ?? 0) }}</strong></td>
                            <td><strong style="color: var(--success);">₦{{ number_format($event->total_revenue ?? 0) }}</strong></td>
                            <td>₦{{ number_format($event->vote_price) }}</td>
                            <td>
                                @if($event->status === 'active')
                                    <span class="badge badge-success">
                                        <i class="fas fa-circle" style="font-size: 6px;"></i>
                                        Live
                                    </span>
                                @elseif($event->status === 'draft')
                                    <span class="badge badge-warning">Draft</span>
                                @elseif($event->status === 'completed')
                                    <span class="badge badge-secondary">Completed</span>
                                @elseif($event->status === 'suspended')
                                    <span class="badge badge-danger">Suspended</span>
                                @endif
                            </td>
                            <td>{{ $event->created_at->format('M d, Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('admin.events.show', $event) }}" class="btn btn-secondary btn-sm btn-icon" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="btn btn-secondary btn-sm btn-icon" title="View Public Page">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    @if($event->status !== 'suspended')
                                        <form method="POST" action="{{ route('admin.events.suspend', $event) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Suspend Event" onclick="return confirm('Suspend this event?')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.events.activate', $event) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm btn-icon" title="Activate Event">
                                                <i class="fas fa-check"></i>
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
                <i class="fas fa-calendar-times"></i>
                <h3>No Events Found</h3>
                <p>No events match your current filters.</p>
            </div>
        @endif
    </div>
</div>

<!-- Pagination -->
@if($events->hasPages())
    <div style="margin-top: 24px; display: flex; justify-content: center;">
        {{ $events->links() }}
    </div>
@endif
@endsection
