@extends('layouts.organizer')

@section('title', 'Ticket Orders')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
    <div>
        <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 4px;">Ticket Orders</h1>
        <p style="color: var(--text-light);">View and manage all ticket purchases</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('organizer.tickets.scan') }}" class="quick-action-btn">
            <i class="fas fa-qrcode"></i>
            Scan Tickets
        </a>
        <a href="{{ route('organizer.tickets.index') }}" class="quick-action-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Tickets
        </a>
    </div>
</div>

<div class="section-card">
    @if($orders->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-light);">
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Order #</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Buyer Details</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Event</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Ticket Type</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Qty</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Amount</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Payment</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Status</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Date</th>
                        <th style="padding: 16px; text-align: left; font-weight: 600; color: var(--text-medium); font-size: 13px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr style="border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 16px; font-weight: 600; font-family: monospace; font-size: 12px;">
                                {{ $order->order_number }}
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-weight: 600; margin-bottom: 2px;">{{ $order->buyer_name }}</div>
                                <div style="font-size: 12px; color: var(--text-light); margin-bottom: 2px;">{{ $order->buyer_email }}</div>
                                @if($order->buyer_phone)
                                    <div style="font-size: 12px; color: var(--text-light);">{{ $order->buyer_phone }}</div>
                                @endif
                            </td>
                            <td style="padding: 16px; font-weight: 500;">{{ $order->ticket->event->name }}</td>
                            <td style="padding: 16px; font-weight: 600;">{{ $order->ticket->name }}</td>
                            <td style="padding: 16px; font-weight: 600; text-align: center;">{{ $order->quantity }}</td>
                            <td style="padding: 16px; font-weight: 700; color: var(--primary-gold);">₦{{ number_format($order->total_amount, 2) }}</td>
                            <td style="padding: 16px;">
                                <span style="padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                    {{ $order->payment_status === 'success' ? 'background: #DCFCE7; color: #166534;' : 
                                       ($order->payment_status === 'pending' ? 'background: #FEF3C7; color: #92400E;' : 
                                       'background: #FEE2E2; color: #991B1B;') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <span style="padding: 6px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;
                                    {{ $order->status === 'active' ? 'background: #DCFCE7; color: #166534;' : 
                                       ($order->status === 'used' ? 'background: #E0E7FF; color: #3730A3;' : 
                                       ($order->status === 'cancelled' ? 'background: #FEE2E2; color: #991B1B;' :
                                       'background: #F3F4F6; color: #374151;')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td style="padding: 16px; color: var(--text-medium); font-size: 13px;">
                                {{ $order->created_at->format('M d, Y') }}
                                <div style="font-size: 11px; color: var(--text-light);">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td style="padding: 16px;">
                                @if($order->canBeUsed())
                                    <button onclick="validateTicket('{{ $order->order_number }}')"
                                            style="padding: 8px 12px; background: #22C55E; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                        <i class="fas fa-check"></i> Validate
                                    </button>
                                @elseif($order->isUsed())
                                    <div style="font-size: 12px; color: var(--text-light);">
                                        Used on<br>{{ $order->used_at->format('M d, Y H:i') }}
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 24px;">
            {{ $orders->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 60px; color: var(--text-light);">
            <i class="fas fa-receipt" style="font-size: 64px; opacity: 0.3; margin-bottom: 20px;"></i>
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">No orders yet</h3>
            <p>Ticket orders will appear here once purchased</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function validateTicket(orderNumber) {
    if (!confirm('Are you sure you want to validate this ticket?')) {
        return;
    }

    fetch('{{ route("organizer.tickets.validate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ order_number: orderNumber })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✓ Ticket validated successfully!');
            location.reload();
        } else {
            alert('✗ ' + data.message);
        }
    })
    .catch(error => {
        alert('Error validating ticket');
        console.error('Error:', error);
    });
}
</script>
@endpush