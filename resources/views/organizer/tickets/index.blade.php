@extends('layouts.organizer')

@section('title', 'Tickets')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">Ticket Management</h1>
        <p style="color: var(--text-light);">Create and manage tickets for your events</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('organizer.tickets.scan') }}" class="quick-action-btn">
            <i class="fas fa-qrcode"></i>
            Scan Tickets
        </a>
        
        @if(Auth::user()->events()->count() > 0)
            <!-- Dropdown button to select event -->
            <div style="position: relative;">
                <button onclick="toggleEventDropdown()" class="create-event-btn" style="cursor: pointer; border: none;">
                    <i class="fas fa-plus"></i>
                    Create Ticket
                </button>
                
                <!-- Dropdown menu -->
                <div id="eventDropdown" style="display: none; position: absolute; top: 100%; right: 0; margin-top: 8px; background: white; border: 2px solid var(--border-light); border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 280px; max-height: 400px; overflow-y: auto; z-index: 100;">
                    <div style="padding: 16px; border-bottom: 2px solid var(--border-light);">
                        <div style="font-weight: 700; font-size: 14px; color: var(--text-dark);">Select Event</div>
                        <div style="font-size: 12px; color: var(--text-light);">Choose which event to create ticket for</div>
                    </div>
                    @foreach(Auth::user()->events()->latest()->get() as $event)
                        <a href="{{ route('organizer.tickets.create', $event) }}" 
                           style="display: block; padding: 12px 16px; text-decoration: none; color: var(--text-dark); transition: background 0.2s ease;"
                           onmouseover="this.style.background='var(--sidebar-bg)'" 
                           onmouseout="this.style.background='white'">
                            <div style="font-weight: 600; margin-bottom: 4px;">{{ $event->name }}</div>
                            <div style="font-size: 12px; color: var(--text-light);">
                                <i class="fas fa-calendar"></i> {{ $event->start_date->format('M d, Y') }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <a href="{{ route('organizer.events.create') }}" class="create-event-btn">
                <i class="fas fa-plus"></i>
                Create Event First
            </a>
        @endif
    </div>
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

@if(Auth::user()->events()->count() == 0)
    <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
        <p style="color: #92400E; margin: 0;">
            <strong><i class="fas fa-info-circle"></i> No Events Yet</strong><br>
            You need to create an event first before you can create tickets. 
            <a href="{{ route('organizer.events.create') }}" style="color: var(--primary-gold); font-weight: 600; text-decoration: underline;">Create your first event</a>
        </p>
    </div>
@endif

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 32px;">
    <div class="section-card" style="padding: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: #DCFCE7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-ticket-alt" style="color: #22C55E; font-size: 24px;"></i>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Total Tickets Sold</div>
                <div style="font-size: 28px; font-weight: 800; color: var(--text-dark);">{{ number_format($totalTicketsSold) }}</div>
            </div>
        </div>
    </div>

    <div class="section-card" style="padding: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: #FEF3C7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-money-bill-wave" style="color: var(--primary-gold); font-size: 24px;"></i>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Ticket Revenue</div>
                <div style="font-size: 28px; font-weight: 800; color: var(--primary-gold);">₦{{ number_format($totalTicketRevenue, 2) }}</div>
            </div>
        </div>
    </div>

    <div class="section-card" style="padding: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: #E0E7FF; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-tags" style="color: #6366F1; font-size: 24px;"></i>
            </div>
            <div>
                <div style="font-size: 12px; color: var(--text-light); margin-bottom: 4px;">Ticket Types</div>
                <div style="font-size: 28px; font-weight: 800; color: var(--text-dark);">{{ $tickets->total() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Tickets Table -->
<div class="section-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 2px solid var(--border-light);">
        <h2 style="font-size: 20px; font-weight: 700;">
            <i class="fas fa-ticket-alt" style="color: var(--primary-gold);"></i> All Tickets
        </h2>
        <a href="{{ route('organizer.tickets.orders') }}" class="quick-action-btn">
            <i class="fas fa-receipt"></i>
            View All Orders
        </a>
    </div>

    @if($tickets->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-light);">
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Event</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Ticket Name</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Price</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Sold / Total</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Available</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Status</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr style="border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; margin-bottom: 4px;">{{ $ticket->event->name }}</div>
                                <div style="font-size: 12px; color: var(--text-light);">{{ $ticket->event->start_date->format('M d, Y') }}</div>
                            </td>
                            <td style="padding: 16px; font-weight: 600;">{{ $ticket->name }}</td>
                            <td style="padding: 16px; font-weight: 700; color: var(--primary-gold);">₦{{ number_format($ticket->price, 2) }}</td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; margin-bottom: 4px;">{{ number_format($ticket->sold) }} / {{ number_format($ticket->quantity) }}</div>
                                <div style="width: 100%; height: 6px; background: var(--border-light); border-radius: 3px; overflow: hidden;">
                                    <div style="width: {{ $ticket->quantity > 0 ? ($ticket->sold / $ticket->quantity * 100) : 0 }}%; height: 100%; background: var(--primary-gold);"></div>
                                </div>
                            </td>
                            <td style="padding: 16px; font-weight: 600; color: {{ $ticket->available > 0 ? '#22C55E' : '#EF4444' }};">
                                {{ number_format($ticket->available) }}
                            </td>
                            <td style="padding: 16px;">
                                <span style="padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                    {{ $ticket->status === 'active' ? 'background: #DCFCE7; color: #166534;' : 'background: #F3F4F6; color: #374151;' }}">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('organizer.tickets.edit', $ticket) }}" 
                                       style="padding: 8px 12px; background: var(--primary-gold); color: white; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    @if($ticket->sold == 0)
                                        <form action="{{ route('organizer.tickets.destroy', $ticket) }}" method="POST" style="display: inline;"
                                              onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    style="padding: 8px 12px; background: #EF4444; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 24px;">
            {{ $tickets->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 60px; color: var(--text-light);">
            <i class="fas fa-ticket-alt" style="font-size: 64px; opacity: 0.3; margin-bottom: 20px;"></i>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">No tickets yet</h3>
            <p style="margin-bottom: 24px;">Create tickets for your events to start selling</p>
        </div>
    @endif
</div>

<!-- Recent Orders -->
<div class="section-card" style="margin-top: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 20px; font-weight: 700;">
            <i class="fas fa-receipt" style="color: var(--primary-gold);"></i> Recent Orders
        </h2>
    </div>

    @if($recentOrders->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-light);">
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Order #</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Buyer</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Ticket</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Qty</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Amount</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Status</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr style="border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 16px; font-weight: 600; font-family: monospace;">{{ $order->order_number }}</td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; margin-bottom: 2px;">{{ $order->buyer_name }}</div>
                                <div style="font-size: 12px; color: var(--text-light);">{{ $order->buyer_email }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; margin-bottom: 2px;">{{ $order->ticket->name }}</div>
                                <div style="font-size: 12px; color: var(--text-light);">{{ $order->ticket->event->name }}</div>
                            </td>
                            <td style="padding: 16px; font-weight: 600;">{{ $order->quantity }}</td>
                            <td style="padding: 16px; font-weight: 700; color: var(--primary-gold);">₦{{ number_format($order->total_amount, 2) }}</td>
                            <td style="padding: 16px;">
                                <span style="padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                    {{ $order->status === 'active' ? 'background: #DCFCE7; color: #166534;' : 
                                       ($order->status === 'used' ? 'background: #E0E7FF; color: #3730A3;' : 
                                       'background: #FEE2E2; color: #991B1B;') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td style="padding: 16px; color: var(--text-medium); font-size: 14px;">{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="text-align: center; padding: 32px; color: var(--text-light);">
            <i class="fas fa-inbox" style="font-size: 48px; opacity: 0.3; margin-bottom: 12px;"></i>
            <p>No orders yet</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleEventDropdown() {
    const dropdown = document.getElementById('eventDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('eventDropdown');
    const button = event.target.closest('button[onclick="toggleEventDropdown()"]');
    
    if (dropdown && !dropdown.contains(event.target) && !button) {
        dropdown.style.display = 'none';
    }
});
</script>
@endpush