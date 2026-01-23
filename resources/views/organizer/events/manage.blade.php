@extends('layouts.organizer')

@section('title', 'Manage Events')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">Manage Events</h1>
        <p style="color: var(--text-light);">Comprehensive view of all your events</p>
    </div>
    <a href="{{ route('organizer.events.create') }}" class="create-event-btn">
        <i class="fas fa-plus"></i>
        Create New Event
    </a>
</div>

@if(session('success'))
    <div style="background: #DCFCE7; border: 2px solid #22C55E; color: #166534; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #FEE2E2; border: 2px solid #EF4444; color: #991B1B; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

@if(isset($events) && $events->count() > 0)
    @foreach($events as $event)
        <div class="section-card" style="margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px;">
                <!-- Event Info -->
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <h2 style="font-size: 22px; font-weight: 700;">{{ $event->name }}</h2>
                        <span style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
                            {{ $event->status === 'active' ? 'background: #DCFCE7; color: #166534;' : 
                               ($event->status === 'completed' ? 'background: #F3F4F6; color: #374151;' : 
                               'background: #FEF3C7; color: #92400E;') }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>
                    
                    <p style="color: var(--text-medium); margin-bottom: 16px; line-height: 1.6;">
                        {{ Str::limit($event->description, 200) }}
                    </p>

                    <!-- Stats Row -->
                    <div style="display: flex; flex-wrap: wrap; gap: 24px; margin-bottom: 16px; padding: 16px; background: var(--sidebar-bg); border-radius: 12px;">
                        <div>
                            <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Categories</div>
                            <div style="font-size: 20px; font-weight: 700; color: var(--text-dark);">{{ $event->categories->count() }}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Contestants</div>
                            <div style="font-size: 20px; font-weight: 700; color: var(--text-dark);">
                                {{ $event->categories->sum(function($cat) { return $cat->contestants->count(); }) }}
                            </div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Total Votes</div>
                            <div style="font-size: 20px; font-weight: 700; color: var(--primary-gold);">{{ number_format($event->votes_count ?? 0) }}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Vote Price</div>
                            <div style="font-size: 20px; font-weight: 700; color: var(--primary-gold);">₦{{ number_format($event->vote_price) }}</div>
                        </div>
                    </div>

                    <!-- Dates -->
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--text-light); margin-bottom: 16px;">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $event->start_date->format('M d, Y') }} - {{ $event->end_date->format('M d, Y') }}</span>
                    </div>

                    <!-- Categories Preview -->
                    @if($event->categories->count() > 0)
                        <div style="margin-bottom: 16px;">
                            <h4 style="font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 12px;">Categories:</h4>
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px;">
                                @foreach($event->categories as $category)
                                    <div style="border: 1px solid var(--border-light); border-radius: 10px; padding: 12px;">
                                        <div style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">{{ $category->name }}</div>
                                        <div style="font-size: 12px; color: var(--text-light);">
                                            {{ $category->contestants->count() }} contestant{{ $category->contestants->count() !== 1 ? 's' : '' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Banner Image -->
                @if($event->banner_image)
                    <img src="{{ asset('storage/' . $event->banner_image) }}" 
                         alt="{{ $event->name }}"
                         style="width: 200px; height: 150px; object-fit: cover; border-radius: 12px; flex-shrink: 0;">
                @endif
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; flex-wrap: wrap; gap: 10px; padding-top: 20px; border-top: 1px solid var(--border-light); margin-top: 20px;">
                <a href="{{ route('organizer.events.show', $event) }}" 
                   style="padding: 10px 20px; background: var(--primary-gold); color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px;">
                    <i class="fas fa-eye"></i> View Details
                </a>
                
                <a href="{{ route('organizer.events.edit', $event) }}" 
                   class="quick-action-btn">
                    <i class="fas fa-edit"></i> Edit
                </a>
                
                <a href="{{ route('organizer.events.analytics', $event) }}" 
                   style="padding: 10px 20px; background: #8B5CF6; color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px;">
                    <i class="fas fa-chart-bar"></i> Analytics
                </a>
                
                <a href="{{ route('events.show', $event->slug) }}" 
                   target="_blank"
                   style="padding: 10px 20px; background: #22C55E; color: white; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px;">
                    <i class="fas fa-external-link-alt"></i> Public Page
                </a>

                @if($event->status === 'draft')
                    <form action="{{ route('organizer.events.publish', $event) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" 
                                style="padding: 10px 20px; background: #22C55E; color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer;">
                            <i class="fas fa-rocket"></i> Publish
                        </button>
                    </form>
                @endif

                @if($event->status === 'active')
                    <form action="{{ route('organizer.events.end', $event) }}" method="POST" style="display: inline;"
                          onsubmit="return confirm('Are you sure you want to end this event?')">
                        @csrf
                        <button type="submit" 
                                style="padding: 10px 20px; background: #F59E0B; color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer;">
                            <i class="fas fa-stop"></i> End Event
                        </button>
                    </form>
                @endif

                <form action="{{ route('organizer.events.destroy', $event) }}" method="POST" style="display: inline;"
                      onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            style="padding: 10px 20px; background: #EF4444; color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer;">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    @endforeach
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