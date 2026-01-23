<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #D4AF37;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .ticket-info {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #D4AF37;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Ticket Purchase Confirmed!</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $order->buyer_name }},</p>
            
            <p>Thank you for your ticket purchase! Your order has been confirmed.</p>
            
            <div class="ticket-info">
                <h3 style="margin-top: 0;">Order Details</h3>
                
                <div class="info-row">
                    <strong>Order Number:</strong>
                    <span style="font-family: monospace; color: #D4AF37; font-weight: bold;">{{ $order->order_number }}</span>
                </div>
                
                <div class="info-row">
                    <strong>Event:</strong>
                    <span>{{ $order->ticket->event->name }}</span>
                </div>
                
                <div class="info-row">
                    <strong>Ticket Type:</strong>
                    <span>{{ $order->ticket->name }}</span>
                </div>
                
                <div class="info-row">
                    <strong>Quantity:</strong>
                    <span>{{ $order->quantity }} ticket(s)</span>
                </div>
                
                <div class="info-row">
                    <strong>Total Paid:</strong>
                    <span style="color: #D4AF37; font-weight: bold;">₦{{ number_format($order->total_amount, 2) }}</span>
                </div>
                
                <div class="info-row">
                    <strong>Purchase Date:</strong>
                    <span>{{ $order->created_at->format('M d, Y H:i A') }}</span>
                </div>
            </div>

            @if($order->qr_code)
            <div class="qr-code">
                <p><strong>Your QR Code:</strong></p>
                @if(str_starts_with($order->qr_code, 'data:image'))
                    <img src="{{ $order->qr_code }}" alt="QR Code" style="width: 200px; height: 200px;">
                @elseif(Storage::disk('public')->exists($order->qr_code))
                    <div style="display: inline-block; padding: 10px; background: white; border: 2px solid #ddd; border-radius: 8px;">
                        {!! Storage::disk('public')->get($order->qr_code) !!}
                    </div>
                @endif
                <p style="margin-top: 10px; font-size: 12px; color: #666;">
                    Order Number: <strong style="font-family: monospace;">{{ $order->order_number }}</strong>
                </p>
            </div>
            @endif  

            <div style="background: #fff3cd; padding: 15px; border-radius: 6px; margin: 20px 0;">
                <strong>⚠️ Important:</strong>
                <p style="margin: 10px 0 0 0;">Please present your QR code or order number <strong>{{ $order->order_number }}</strong> at the event entrance.</p>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('tickets.success', $order) }}" class="button">
                    View Your Ticket
                </a>
            </div>
            
            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                If you have any questions, please contact our support team at support@chilkyvote.com
            </p>
            
            <p style="font-size: 14px; color: #666;">
                Thank you for choosing ChilkyVote!
            </p>
        </div>
    </div>
</body>
</html>