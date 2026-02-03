@extends('admin.layouts.admin')

@section('title', $event->name . ' - Event Details')

@section('breadcrumb')
<a href="{{ route('admin.events.index') }}">Events</a>
<i class="fas fa-chevron-right"></i>
<span>{{ Str::limit($event->name, 30) }}</span>
@endsection

@section('content')
<!-- Page Header -->
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 20px;">
        @if($event->banner_image)
            <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->name }}"
                 style="width: 80px; height: 80px; border-radius: 16px; object-fit: cover;">
        @else
            <div style="width: 80px; height: 80px; border-radius: 16px; background: linear-gradient(135deg, var(--admin-accent) 0%, var(--admin-accent-dark) 100%); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-trophy" style="font-size: 32px; color: white;"></i>
            </div>
        @endif
        <div>
            <h1 class="page-title" style="margin-bottom: 4px;">{{ $event->name }}</h1>
            <p style="color: var(--text-light); font-size: 14px;">by {{ $event->user->name ?? 'Unknown' }} • Created {{ $event->created_at->format('M d, Y') }}</p>
            <div style="display: flex; gap: 8px; margin-top: 8px;">
                @if($event->status === 'active')
                    <span class="badge badge-success"><i class="fas fa-circle" style="font-size: 6px;"></i> Live</span>
                @elseif($event->status === 'draft')
                    <span class="badge badge-warning">Draft</span>
                @elseif($event->status === 'completed')
                    <span class="badge badge-secondary">Completed</span>
                @elseif($event->status === 'suspended')
                    <span class="badge badge-danger">Suspended</span>
                @endif
                <span class="badge badge-secondary">₦{{ number_format($event->vote_price) }}/vote</span>
            </div>
        </div>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="btn btn-secondary">
            <i class="fas fa-external-link-alt"></i>
            View Public Page
        </a>
        @if($event->status !== 'suspended')
            <form method="POST" action="{{ route('admin.events.suspend', $event) }}" onsubmit="return confirm('Suspend this event?')">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-ban"></i>
                    Suspend Event
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.events.activate', $event) }}">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    Activate Event
                </button>
            </form>
        @endif
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid mb-6">
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon primary">
                <i class="fas fa-vote-yea"></i>
            </div>
        </div>
        <div class="stat-value">{{ number_format($stats['total_votes'] ?? 0) }}</div>
        <div class="stat-label">Total Votes</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon success">
                <i class="fas fa-naira-sign"></i>
            </div>
        </div>
        <div class="stat-value">₦{{ number_format($stats['total_revenue'] ?? 0) }}</div>
        <div class="stat-label">Total Revenue</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon info">
                <i class="fas fa-folder"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_categories'] ?? 0 }}</div>
        <div class="stat-label">Categories</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-header">
            <div class="stat-icon warning">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-value">{{ $stats['total_contestants'] ?? 0 }}</div>
        <div class="stat-label">Contestants</div>
    </div>
</div>

<div class="grid-2">
    <!-- Categories & Contestants -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-folder-open"></i>
                Categories & Contestants
            </h3>
        </div>
        <div class="card-body no-padding">
            @if($event->categories->count() > 0)
                @foreach($event->categories as $category)
                    <div style="padding: 16px 20px; border-bottom: 1px solid var(--border-color);">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <h4 style="font-weight: 600;">{{ $category->name }}</h4>
                            <span class="badge badge-secondary">{{ $category->contestants->count() }} contestants</span>
                        </div>
                        @if($category->contestants->count() > 0)
                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach($category->contestants->sortByDesc('total_votes')->take(5) as $contestant)
                                    <div style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; background: var(--main-bg); border-radius: 8px; font-size: 13px;">
                                        @if($contestant->photo)
                                            <img src="{{ asset('storage/' . $contestant->photo) }}" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--admin-accent); display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: 700;">
                                                {{ strtoupper(substr($contestant->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span>{{ Str::limit($contestant->name, 15) }}</span>
                                        <span style="color: var(--success); font-weight: 600;">{{ number_format($contestant->total_votes) }}</span>
                                    </div>
                                @endforeach
                                @if($category->contestants->count() > 5)
                                    <span style="padding: 8px 12px; color: var(--text-light); font-size: 13px;">+{{ $category->contestants->count() - 5 }} more</span>
                                @endif
                            </div>
                        @else
                            <p style="color: var(--text-light); font-size: 13px;">No contestants yet</p>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <p>No categories created yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Votes -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history"></i>
                Recent Votes
            </h3>
            <a href="{{ route('admin.transactions.index', ['event' => $event->id]) }}" class="btn btn-secondary btn-sm">View All</a>
        </div>
        <div class="card-body no-padding">
            @if($recentVotes->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Voter</th>
                            <th>Contestant</th>
                            <th>Votes</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentVotes as $vote)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <h4>{{ $vote->voter_name ?? 'Anonymous' }}</h4>
                                        <p style="font-size: 11px;">{{ $vote->voter_email ?? '' }}</p>
                                    </div>
                                </td>
                                <td>{{ $vote->contestant->name ?? 'N/A' }}</td>
                                <td><strong>{{ number_format($vote->number_of_votes) }}</strong></td>
                                <td style="color: var(--success);">₦{{ number_format($vote->amount_paid) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-vote-yea"></i>
                    <p>No votes yet</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Organizer Info -->
<div class="card mt-6">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user"></i>
            Organizer Information
        </h3>
        <a href="{{ route('admin.users.show', $event->user) }}" class="btn btn-secondary btn-sm">View Profile</a>
    </div>
    <div class="card-body">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div class="user-avatar" style="width: 56px; height: 56px; font-size: 20px;">
                {{ strtoupper(substr($event->user->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <h4 style="font-weight: 600; font-size: 16px;">{{ $event->user->name ?? 'Unknown' }}</h4>
                <p style="color: var(--text-light);">{{ $event->user->email ?? '' }}</p>
            </div>
            <div style="margin-left: auto; text-align: right;">
                <p style="font-size: 13px; color: var(--text-light);">Member since</p>
                <p style="font-weight: 600;">{{ $event->user->created_at->format('M d, Y') ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Event Details -->
<div class="card mt-6">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-info-circle"></i>
            Event Details
        </h3>
    </div>
    <div class="card-body">
        @if($event->description)
            <div style="margin-bottom: 24px;">
                <label style="font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; display: block; margin-bottom: 8px;">Description</label>
                <p style="color: var(--text-medium); line-height: 1.6;">{{ $event->description }}</p>
            </div>
        @endif
        <div class="grid-3">
            <div>
                <label style="font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; display: block; margin-bottom: 8px;">Start Date</label>
                <p style="font-weight: 600;">{{ $event->start_date ? $event->start_date->format('M d, Y h:i A') : 'Not set' }}</p>
            </div>
            <div>
                <label style="font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; display: block; margin-bottom: 8px;">End Date</label>
                <p style="font-weight: 600;">{{ $event->end_date ? $event->end_date->format('M d, Y h:i A') : 'Not set' }}</p>
            </div>
            <div>
                <label style="font-size: 12px; font-weight: 600; color: var(--text-light); text-transform: uppercase; display: block; margin-bottom: 8px;">Vote Price</label>
                <p style="font-weight: 600; color: var(--admin-accent);">₦{{ number_format($event->vote_price) }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
