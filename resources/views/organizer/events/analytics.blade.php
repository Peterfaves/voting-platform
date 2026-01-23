@extends('layouts.organizer')

@section('title', $event->name . ' - Analytics')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.events.show', $event) }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Event
    </a>
</div>

<!-- Event Header -->
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">{{ $event->name }}</h1>
    <p style="color: var(--text-light);">Event Analytics & Insights</p>
</div>

<!-- Overview Stats -->
<div class="stats-grid" style="margin-bottom: 32px;">
    <div class="stat-card">
        <div class="stat-icon" style="background: #DCFCE7;"><i class="fas fa-vote-yea" style="color: #22C55E;"></i></div>
        <div class="stat-value">{{ number_format($totalVotes) }}</div>
        <div class="stat-label">Total Votes</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #FEF3C7;"><i class="fas fa-wallet" style="color: #F59E0B;"></i></div>
        <div class="stat-value">₦{{ number_format($totalRevenue, 2) }}</div>
        <div class="stat-label">Total Revenue</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #E0E7FF;"><i class="fas fa-users" style="color: #6366F1;"></i></div>
        <div class="stat-value">{{ $topContestants->count() }}</div>
        <div class="stat-label">Total Contestants</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #FCE7F3;"><i class="fas fa-layer-group" style="color: #EC4899;"></i></div>
        <div class="stat-value">{{ $categoryStats->count() }}</div>
        <div class="stat-label">Categories</div>
    </div>
</div>

<!-- Votes Over Time Chart -->
<div class="section-card" style="margin-bottom: 24px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">
        <i class="fas fa-chart-line" style="color: var(--primary-gold);"></i> Votes Over Time (Last 30 Days)
    </h2>
    
    @if($votesOverTime->count() > 0)
        <div style="overflow-x: auto;">
            <div style="min-width: 600px; height: 300px; position: relative;">
                @php
                    $maxVotes = $votesOverTime->max('count') ?: 1;
                    $maxRevenue = $votesOverTime->max('revenue') ?: 1;
                @endphp
                
                <div style="display: flex; align-items: flex-end; justify-content: space-between; height: 250px; padding: 20px 0; gap: 4px;">
                    @foreach($votesOverTime as $data)
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
                            <div style="width: 100%; background: linear-gradient(180deg, var(--primary-gold) 0%, var(--primary-gold-dark) 100%); 
                                        border-radius: 8px 8px 0 0; height: {{ ($data->count / $maxVotes) * 100 }}%; min-height: 4px; position: relative;"
                                 title="{{ number_format($data->count) }} votes">
                                <div style="position: absolute; top: -24px; left: 50%; transform: translateX(-50%); font-size: 12px; font-weight: 600; color: var(--text-dark); white-space: nowrap;">
                                    {{ number_format($data->count) }}
                                </div>
                            </div>
                            <div style="font-size: 11px; color: var(--text-light); writing-mode: vertical-rl; transform: rotate(180deg);">
                                {{ \Carbon\Carbon::parse($data->date)->format('M d') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 48px; color: var(--text-light);">
            <i class="fas fa-chart-line" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
            <p>No voting data available yet</p>
        </div>
    @endif
</div>

<!-- Top Contestants -->
<div class="section-card" style="margin-bottom: 24px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">
        <i class="fas fa-trophy" style="color: var(--primary-gold);"></i> Top Contestants
    </h2>
    
    @if($topContestants->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($topContestants as $index => $contestant)
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px; background: {{ $index < 3 ? 'linear-gradient(135deg, #FFF7ED 0%, #FFFBEB 100%)' : 'var(--sidebar-bg)' }}; border-radius: 12px; border: 2px solid {{ $index === 0 ? 'var(--primary-gold)' : 'var(--border-light)' }};">
                    <!-- Rank -->
                    <div style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 50%; background: {{ $index === 0 ? 'var(--primary-gold)' : ($index === 1 ? '#C0C0C0' : ($index === 2 ? '#CD7F32' : 'var(--border-light)')) }}; color: white; font-size: 20px; font-weight: 800; flex-shrink: 0;">
                        #{{ $index + 1 }}
                    </div>
                    
                    <!-- Photo -->
                    @if($contestant->photo)
                        <img src="{{ asset('storage/' . $contestant->photo) }}" 
                             alt="{{ $contestant->name }}"
                             style="width: 56px; height: 56px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid {{ $index === 0 ? 'var(--primary-gold)' : 'var(--border-light)' }};">
                    @else
                        <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--primary-gold); display: flex; align-items: center; justify-content: center; color: white; font-size: 20px; font-weight: 700; flex-shrink: 0;">
                            {{ strtoupper(substr($contestant->name, 0, 1)) }}
                        </div>
                    @endif
                    
                    <!-- Info -->
                    <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 16px; margin-bottom: 4px;">{{ $contestant->name }}</div>
                        <div style="font-size: 13px; color: var(--text-light);">{{ $contestant->category->name ?? 'N/A' }}</div>
                    </div>
                    
                    <!-- Votes -->
                    <div style="text-align: right;">
                        <div style="font-size: 24px; font-weight: 800; color: var(--primary-gold);">{{ number_format($contestant->total_votes) }}</div>
                        <div style="font-size: 12px; color: var(--text-light);">votes</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 48px; color: var(--text-light);">
            <i class="fas fa-trophy" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
            <p>No contestants yet</p>
        </div>
    @endif
</div>

<!-- Category Breakdown -->
<div class="section-card" style="margin-bottom: 24px;">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">
        <i class="fas fa-layer-group" style="color: var(--primary-gold);"></i> Category Breakdown
    </h2>
    
    @if($categoryStats->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 16px;">
            @foreach($categoryStats as $category)
                <div style="border: 2px solid var(--border-light); border-radius: 12px; padding: 20px;">
                    <h3 style="font-weight: 700; font-size: 16px; margin-bottom: 12px;">{{ $category->name }}</h3>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <span style="color: var(--text-light); font-size: 14px;">Contestants:</span>
                        <span style="font-weight: 600; font-size: 16px;">{{ $category->contestants_count }}</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: var(--text-light); font-size: 14px;">Total Votes:</span>
                        <span style="font-weight: 700; font-size: 18px; color: var(--primary-gold);">{{ number_format($category->total_votes) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 48px; color: var(--text-light);">
            <i class="fas fa-layer-group" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
            <p>No categories yet</p>
        </div>
    @endif
</div>

<!-- Payment Methods -->
<div class="section-card">
    <h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">
        <i class="fas fa-credit-card" style="color: var(--primary-gold);"></i> Payment Methods
    </h2>
    
    @if($paymentMethods->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
            @foreach($paymentMethods as $method)
                <div style="border: 2px solid var(--border-light); border-radius: 12px; padding: 20px; text-align: center;">
                    <div style="font-size: 14px; color: var(--text-light); margin-bottom: 8px; text-transform: capitalize;">
                        {{ $method->payment_method ?? 'Unknown' }}
                    </div>
                    <div style="font-size: 24px; font-weight: 800; color: var(--text-dark); margin-bottom: 4px;">
                        {{ number_format($method->count) }}
                    </div>
                    <div style="font-size: 16px; font-weight: 600; color: var(--primary-gold);">
                        ₦{{ number_format($method->total, 2) }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; padding: 48px; color: var(--text-light);">
            <i class="fas fa-credit-card" style="font-size: 48px; opacity: 0.3; margin-bottom: 16px;"></i>
            <p>No payment data available yet</p>
        </div>
    @endif
</div>
@endsection