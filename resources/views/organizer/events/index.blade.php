@extends('layouts.organizer')

@section('title', 'My Events')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">My Events</h1>
        <p style="color: var(--text-light);">Manage all your voting events</p>
    </div>
    <a href="{{ route('organizer.events.create') }}" class="create-event-btn">
        <i class="fas fa-plus"></i>
        Create New Event
    </a>
</div>

@if(isset($events) && $events->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px;">
        @foreach($events as $event)
            <div class="section-card" style="padding: 0; overflow: hidden;">
                <!-- Event Banner -->
                <div style="height: 160px; background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-dark) 100%); position: relative;">
                    @if($event->banner_image)
                        <img src="{{ asset('storage/' . $event->banner_image) }}" 
                             alt="{{ $event->name }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt" style="font-size: 48px; color: rgba(255,255,255,0.3);"></i>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <span style="position: absolute; top: 12px; right: 12px; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
                        {{ $event->status === 'active' ? 'background: #22C55E; color: white;' : 
                           ($event->status === 'completed' ? 'background: #6B7280; color: white;' : 
                           'background: #F59E0B; color: white;') }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>
                
                <!-- Event Details -->
                <div style="padding: 20px;">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 8px; color: var(--text-dark);">
                        {{ $event->name }}
                    </h3>
                    
                    <div style="display: flex; gap: 16px; margin-bottom: 16px; font-size: 13px; color: var(--text-light);">
                        <span><i class="fas fa-layer-group"></i> {{ $event->categories_count ?? 0 }} Categories</span>
                        <span><i class="fas fa-vote-yea"></i> {{ number_format($event->votes_count ?? 0) }} Votes</span>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px; font-size: 13px; color: var(--text-light);">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $event->start_date->format('M d') }} - {{ $event->end_date->format('M d, Y') }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid var(--border-light);">
                        <span style="font-size: 16px; font-weight: 700; color: var(--primary-gold);">
                            ₦{{ number_format($event->vote_price) }}/vote
                        </span>
                        
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('organizer.events.show', $event) }}" 
                               style="padding: 8px 16px; background: var(--primary-gold); color: white; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('organizer.events.edit', $event) }}" 
                               style="padding: 8px 16px; border: 2px solid var(--border-light); color: var(--text-medium); border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 32px;">
        {{ $events->links() }}
    </div>
@else
    <div class="section-card" style="text-align: center; padding: 60px 40px;">
        <div style="width: 80px; height: 80px; background: var(--sidebar-bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i class="fas fa-calendar-plus" style="font-size: 32px; color: var(--primary-gold);"></i>
        </div>
        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">No events yet</h3>
        <p style="color: var(--text-light); margin-bottom: 24px;">Get started by creating your first voting event</p>
        <a href="{{ route('organizer.events.create') }}" class="create-event-btn">
            <i class="fas fa-plus"></i>
            Create Event
        </a>
    </div>
@endif
@endsection