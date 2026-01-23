@extends('layouts.organizer')

@section('title', 'Reports')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">Reports</h1>
    <p style="color: var(--text-light);">Download detailed reports on votes and earnings in PDF format.</p>
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

<div class="section-card" style="max-width: 800px;">
    <form method="GET" action="{{ route('organizer.reports.download') }}">
        <div style="margin-bottom: 24px;">
            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">
                Events
            </label>
            <select name="event_id" 
                    required
                    style="width: 100%; padding: 14px 16px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 15px; background: white;"
                    onfocus="this.style.borderColor='var(--primary-gold)'" 
                    onblur="this.style.borderColor='var(--border-light)'">
                <option value="">Select an event</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" 
                class="create-event-btn"
                style="width: 100%;">
            <i class="fas fa-download"></i>
            Download report as PDF
        </button>
    </form>
</div>
@endsection