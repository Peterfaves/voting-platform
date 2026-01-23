<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Order #{{ $order->order_number }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gold: #D4AF37;
            --primary-gold-dark: #B8941E;
            --text-dark: #1F2937;
            --text-medium: #4B5563;
            --text-light: #6B7280;
            --border-light: #E5E7EB;
            --sidebar-bg: #FFFBF0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #F9FAFB;
            color: var(--text-dark);
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 60px auto;
            padding: 0 20px;
        }
        
        .card {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: #DCFCE7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        
        .qr-code {
            background: white;
            padding: 20px;
            border: 2px solid var(--border-light);
            border-radius: 12px;
            display: inline-block;
            margin: 24px 0;
        }
        
        .ticket-info {
            background: var(--sidebar-bg);
            padding: 24px;
            border-radius: 12px;
            text-align: left;
            margin: 24px 0;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-light);
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .btn {
            display: inline-block;
            padding: 14px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--primary-gold);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-gold-dark);
        }
        
        .btn-secondary {
            background: white;
            color: var(--text-dark);
            border: 2px solid var(--border-light);
        }
        
        .btn-secondary:hover {
            border-color: var(--primary-gold);
            color: var(--primary-gold);
        }

        .order-number-box {
            background: #F3F4F6;
            padding: 16px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid var(--primary-gold);
        }

        .order-number-box strong {
            font-size: 18px;
            font-family: monospace;
            color: var(--primary-gold);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="success-icon">
                <i class="fas fa-check" style="font-size: 40px; color: #22C55E;"></i>
            </div>

            <h1 style="font-size: 32px; font-weight: 800; margin-bottom: 12px; color: #22C55E;">Payment Successful!</h1>
            <p style="font-size: 18px; color: var(--text-medium); margin-bottom: 32px;">
                Your ticket(s) have been confirmed and sent to your email
            </p>

            <!-- Order Number Display -->
            <div class="order-number-box">
                <p style="margin: 0; color: var(--text-medium); font-size: 14px;">Order Number</p>
                <strong>{{ $order->order_number }}</strong>
                <p style="margin: 8px 0 0 0; color: var(--text-light); font-size: 12px;">
                    <i class="fas fa-info-circle"></i> Use this number for ticket validation
                </p>
            </div>

            <!-- QR Code -->
            <div class="qr-code">
                @if($order->qr_code)
                    @if(str_starts_with($order->qr_code, 'data:image'))
                        <!-- Base64 embedded image -->
                        <img src="{{ $order->qr_code }}" alt="QR Code" style="width: 250px; height: 250px;">
                    @elseif(Storage::disk('public')->exists($order->qr_code))
                        <!-- SVG file from storage -->
                        <div style="width: 250px; height: 250px; display: flex; align-items: center; justify-content: center;">
                            {!! Storage::disk('public')->get($order->qr_code) !!}
                        </div>
                    @else
                        <!-- Fallback -->
                        <div style="width: 250px; height: 250px; background: #F3F4F6; display: flex; align-items: center; justify-content: center; border-radius: 12px;">
                            <p style="color: #6B7280;">QR Code unavailable</p>
                        </div>
                    @endif
                @else
                    <div style="width: 250px; height: 250px; background: #F3F4F6; display: flex; align-items: center; justify-content: center; border-radius: 12px;">
                        <p style="color: #6B7280;">QR Code</p>
                    </div>
                @endif
            </div>
            <!-- Ticket Information -->
            <div class="ticket-info">
                <div class="info-row">
                    <span style="font-weight: 600;">Event</span>
                    <span>{{ $order->ticket->event->name }}</span>
                </div>
                <div class="info-row">
                    <span style="font-weight: 600;">Ticket Type</span>
                    <span>{{ $order->ticket->name }}</span>
                </div>
                <div class="info-row">
                    <span style="font-weight: 600;">Quantity</span>
                    <span>{{ $order->quantity }} ticket(s)</span>
                </div>
                <div class="info-row">
                    <span style="font-weight: 600;">Buyer Name</span>
                    <span>{{ $order->buyer_name }}</span>
                </div>
                <div class="info-row">
                    <span style="font-weight: 600;">Email</span>
                    <span>{{ $order->buyer_email }}</span>
                </div>
                @if($order->buyer_phone)
                <div class="info-row">
                    <span style="font-weight: 600;">Phone</span>
                    <span>{{ $order->buyer_phone }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span style="font-weight: 600;">Amount Paid</span>
                    <span style="color: var(--primary-gold); font-weight: 700;">₦{{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="info-row">
                    <span style="font-weight: 600;">Purchase Date</span>
                    <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span style="font-weight: 600;">Payment Method</span>
                    <span>{{ ucfirst($order->payment_method ?? 'Card') }}</span>
                </div>
                <div class="info-row">
                    <span style="font-weight: 600;">Status</span>
                    <span style="color: #22C55E; font-weight: 700;">{{ ucfirst($order->status) }}</span>
                </div>
            </div>

            <!-- Important Notice -->
            <div style="background: #FEF3C7; padding: 16px; border-radius: 8px; text-align: left; margin: 24px 0; border-left: 4px solid #F59E0B;">
                <h4 style="font-weight: 700; color: #92400E; margin-bottom: 8px;">
                    <i class="fas fa-exclamation-triangle"></i> Important
                </h4>
                <p style="color: #92400E; font-size: 14px; margin: 0;">
                    Please present this QR code OR your order number ({{ $order->order_number }}) at the event entrance. 
                    Save this page or download your ticket PDF for easy access.
                </p>
            </div>

            <!-- Action Buttons -->
            <div style="margin-top: 32px;">
                <a href="{{ route('tickets.download', $order) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download Ticket PDF
                </a>
                <a href="{{ route('events.show', $order->ticket->event->slug) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Event
                </a>
            </div>

            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-light); color: var(--text-light); font-size: 14px;">
                <p>A confirmation email has been sent to <strong>{{ $order->buyer_email }}</strong></p>
                <p style="margin-top: 8px;">Need help? Contact support at support@chilkyvote.com</p>
            </div>
        </div>
    </div>
</body>
</html>