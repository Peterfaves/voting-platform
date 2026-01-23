@extends('layouts.organizer')

@section('title', $event->name . ' - Event Details')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.events.index') }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Events
    </a>
</div>

<!-- Event Header -->
<div class="section-card" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <h1 style="font-size: 28px; font-weight: 800;">{{ $event->name }}</h1>
                <span style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
                    {{ $event->status === 'active' ? 'background: #DCFCE7; color: #166534;' : 
                       ($event->status === 'completed' ? 'background: #F3F4F6; color: #374151;' : 
                       'background: #FEF3C7; color: #92400E;') }}">
                    {{ ucfirst($event->status) }}
                </span>
            </div>
            <p style="color: var(--text-light); max-width: 600px;">{{ $event->description }}</p>
        </div>
        
        <div style="display: flex; gap: 10px;">
            @if($event->status === 'draft')
                <form method="POST" action="{{ route('organizer.events.publish', $event) }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="padding: 10px 20px; background: #22C55E; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-rocket"></i> Publish
                    </button>
                </form>
            @elseif($event->status === 'active')
                <form method="POST" action="{{ route('organizer.events.end', $event) }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="padding: 10px 20px; background: #6B7280; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">
                        <i class="fas fa-stop"></i> End Event
                    </button>
                </form>
            @endif
            <a href="{{ route('organizer.events.edit', $event) }}" class="quick-action-btn">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('events.show', $event->slug) }}" target="_blank" style="padding: 10px 20px; background: var(--primary-gold); color: white; border-radius: 10px; text-decoration: none; font-weight: 600;">
                <i class="fas fa-external-link-alt"></i> View Public Page
            </a>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid" style="margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-value">₦{{ number_format($event->vote_price) }}</div>
        <div class="stat-label">Vote Price</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-vote-yea"></i></div>
        <div class="stat-value">{{ number_format($stats['total_votes'] ?? 0) }}</div>
        <div class="stat-label">Total Votes</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        <div class="stat-value">₦{{ number_format($stats['total_earnings'] ?? 0) }}</div>
        <div class="stat-label">Total Revenue</div>
    </div>
</div>

<!-- Categories & Contestants Section -->
<div class="section-card" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 700;">
            <i class="fas fa-layer-group" style="color: var(--primary-gold);"></i> Categories & Contestants
        </h2>
        <a href="{{ route('organizer.categories.create', $event) }}" class="create-event-btn" style="padding: 10px 20px; font-size: 14px;">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>

    @if($event->categories && $event->categories->count() > 0)
        @foreach($event->categories as $category)
            <div style="border: 1px solid var(--border-light); border-radius: 16px; margin-bottom: 20px; overflow: hidden;">
                <!-- Category Header -->
                <div style="background: var(--sidebar-bg); padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">{{ $category->name }}</h3>
                        @if($category->description)
                            <p style="font-size: 13px; color: var(--text-light);">{{ $category->description }}</p>
                        @endif
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('organizer.contestants.create', $category) }}" 
                           style="padding: 8px 14px; background: #22C55E; color: white; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">
                            <i class="fas fa-user-plus"></i> Add Contestant
                        </a>
                        <a href="{{ route('organizer.categories.edit', $category) }}" 
                           style="padding: 8px 14px; border: 2px solid var(--border-light); color: var(--text-medium); border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>

                <!-- Contestants Grid -->
                <div style="padding: 20px;">
                    @if($category->contestants && $category->contestants->count() > 0)
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                            @foreach($category->contestants->sortByDesc('total_votes') as $index => $contestant)
                                <div style="border: 2px solid {{ $contestant->status === 'evicted' ? '#FEE2E2' : 'var(--border-light)' }}; border-radius: 12px; padding: 16px; text-align: center; background: {{ $contestant->status === 'evicted' ? '#FEF2F2' : 'white' }};">
                                    <!-- Rank Badge -->
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                        <span style="font-size: 20px; font-weight: 800; color: {{ $index === 0 ? 'var(--primary-gold)' : 'var(--text-light)' }};">#{{ $index + 1 }}</span>
                                        @if($contestant->status === 'evicted')
                                            <span style="padding: 4px 10px; background: #EF4444; color: white; border-radius: 12px; font-size: 11px; font-weight: 600;">Evicted</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Photo -->
                                    @if($contestant->photo)
                                        <img src="{{ asset('storage/' . $contestant->photo) }}" 
                                             alt="{{ $contestant->name }}"
                                             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin: 0 auto 12px; border: 3px solid {{ $index === 0 ? 'var(--primary-gold)' : 'var(--border-light)' }};">
                                    @else
                                        <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--primary-gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; color: white; font-size: 24px; font-weight: 700;">
                                            {{ strtoupper(substr($contestant->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    
                                    <!-- Name & Votes -->
                                    <h4 style="font-size: 14px; font-weight: 700; margin-bottom: 4px;">{{ $contestant->name }}</h4>
                                    <p style="font-size: 20px; font-weight: 800; color: var(--primary-gold); margin-bottom: 12px;">
                                        {{ number_format($contestant->total_votes) }} <span style="font-size: 12px; font-weight: 500; color: var(--text-light);">votes</span>
                                    </p>
                                    
                                    <!-- Edit Link -->
                                    <a href="{{ route('organizer.contestants.edit', $contestant) }}" 
                                       style="color: var(--primary-gold); font-size: 13px; text-decoration: none; font-weight: 500;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 32px; color: var(--text-light);">
                            <i class="fas fa-users" style="font-size: 32px; margin-bottom: 12px; opacity: 0.5;"></i>
                            <p>No contestants yet. Add your first contestant!</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div style="text-align: center; padding: 48px; color: var(--text-light);">
            <i class="fas fa-layer-group" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">No categories yet</h3>
            <p style="margin-bottom: 20px;">Get started by creating your first category</p>
            <a href="{{ route('organizer.categories.create', $event) }}" class="create-event-btn" style="display: inline-flex;">
                <i class="fas fa-plus"></i> Create Category
            </a>
        </div>
    @endif
</div>

<!-- Recent Votes -->
<div class="section-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 20px; font-weight: 700;">
            <i class="fas fa-chart-line" style="color: var(--primary-gold);"></i> Recent Votes
        </h2>
        <a href="{{ route('organizer.transactions') }}" class="see-all-btn">View All</a>
    </div>

    @if(isset($recentVotes) && $recentVotes->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Voter</th>
                    <th>Contestant</th>
                    <th>Votes</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentVotes as $vote)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $vote->voter_name }}</div>
                            <div style="font-size: 12px; color: var(--text-light);">{{ $vote->voter_email }}</div>
                        </td>
                        <td>{{ $vote->contestant->name ?? 'N/A' }}</td>
                        <td>{{ $vote->vote_count }}</td>
                        <td style="font-weight: 600;">₦{{ number_format($vote->amount_paid, 2) }}</td>
                        <td>{{ $vote->created_at->format('M d, H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 32px; color: var(--text-light);">
            <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 12px; opacity: 0.5;"></i>
            <p>No votes yet</p>
        </div>
    @endif
</div>
@endsection