<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .ticket {
            border: 3px solid #D4AF37;
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #D4AF37;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #D4AF37;
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        .qr-code {
            text-align: center;
            margin: 30px 0;
        }
        .qr-code img {
            width: 200px;
            height: 200px;
        }
        .info-table {
            width: 100%;
            margin-top: 20px;
        }
        .info-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 40%;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #D4AF37;
            font-size: 12px;
            color: #666;
        }
        .order-number {
            background: #FFF7ED;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>{{ $order->ticket->event->name }}</h1>
            <p style="color: #666; margin: 5px 0;">Event Ticket</p>
            <p style="color: #666; margin: 5px 0;">
                {{ $order->ticket->event->start_date->format('l, F d, Y') }}
            </p>
        </div>

        <div class="order-number">
            {{ $order->order_number }}
        </div>

        <div class="qr-code">
            <img src="{{ public_path('storage/' . $order->qr_code) }}" alt="QR Code">
            <p style="color: #666; font-size: 12px; margin-top: 10px;">
                Scan this code at the event entrance
            </p>
        </div>

        <table class="info-table">
            <tr>
                <td>Ticket Type</td>
                <td>{{ $order->ticket->name }}</td>
            </tr>
            <tr>
                <td>Quantity</td>
                <td>{{ $order->quantity }} ticket(s)</td>
            </tr>
            <tr>
                <td>Buyer Name</td>
                <td>{{ $order->buyer_name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $order->buyer_email }}</td>
            </tr>
            @if($order->buyer_phone)
            <tr>
                <td>Phone</td>
                <td>{{ $order->buyer_phone }}</td>
            </tr>
            @endif
            <tr>
                <td>Amount Paid</td>
                <td style="color: #D4AF37; font-weight: bold;">₦{{ number_format($order->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td>Purchase Date</td>
                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td style="color: #22C55E; font-weight: bold;">{{ ucfirst($order->status) }}</td>
            </tr>
        </table>

        <div style="background: #FEF3C7; padding: 15px; border-radius: 8px; margin-top: 20px;">
            <p style="margin: 0; font-size: 14px;">
                <strong>Important:</strong> Please bring this ticket (printed or on your mobile device) to the event. 
                This QR code will be scanned at the entrance for verification.
            </p>
        </div>

        <div class="footer">
            <p><strong>VoteNaija</strong></p>
            <p>support@votenaija.ng | www.votenaija.ng</p>
            <p style="margin-top: 10px;">Thank you for your purchase!</p>
        </div>
    </div>
</body>
</html>