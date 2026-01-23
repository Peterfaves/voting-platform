<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Tickets - {{ $event->name }}</title>
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .event-header {
            background: white;
            padding: 40px;
            border-radius: 16px;
            margin-bottom: 32px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .ticket-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }
        
        .ticket-card {
            background: white;
            border: 2px solid var(--border-light);
            border-radius: 16px;
            padding: 32px;
            transition: all 0.3s ease;
        }
        
        .ticket-card:hover {
            border-color: var(--primary-gold);
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(212, 175, 55, 0.15);
        }
        
        .ticket-name {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 12px;
            color: var(--text-dark);
        }
        
        .ticket-price {
            font-size: 36px;
            font-weight: 800;
            color: var(--primary-gold);
            margin-bottom: 16px;
        }
        
        .ticket-benefits {
            list-style: none;
            margin-bottom: 24px;
        }
        
        .ticket-benefits li {
            padding: 8px 0;
            color: var(--text-medium);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .ticket-benefits li i {
            color: var(--primary-gold);
        }
        
        .buy-btn {
            width: 100%;
            padding: 16px;
            background: var(--primary-gold);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .buy-btn:hover {
            background: var(--primary-gold-dark);
        }
        
        .buy-btn:disabled {
            background: #9CA3AF;
            cursor: not-allowed;
        }
        
        .available-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #DCFCE7;
            color: #166534;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }
        
        .sold-out-badge {
            display: inline-block;
            padding: 6px 12px;
            background: #FEE2E2;
            color: #991B1B;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 16px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border-light);
            border-radius: 10px;
            font-size: 15px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-gold);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="event-header">
            @if($event->banner_image)
                <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->name }}" 
                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 12px; margin-bottom: 24px;">
            @endif
            
            <h1 style="font-size: 36px; font-weight: 800; margin-bottom: 12px;">{{ $event->name }}</h1>
            <p style="font-size: 18px; color: var(--text-medium); margin-bottom: 8px;">{{ $event->description }}</p>
            <div style="display: flex; gap: 24px; color: var(--text-light); font-size: 15px;">
                <span><i class="fas fa-calendar"></i> {{ $event->start_date->format('M d, Y') }} - {{ $event->end_date->format('M d, Y') }}</span>
            </div>
        </div>

        @if($tickets->count() > 0)
            <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 24px;">Available Tickets</h2>
            
            <div class="ticket-grid">
                @foreach($tickets as $ticket)
                    <div class="ticket-card">
                        @if($ticket->isSoldOut())
                            <span class="sold-out-badge">
                                <i class="fas fa-times-circle"></i> Sold Out
                            </span>
                        @else
                            <span class="available-badge">
                                <i class="fas fa-check-circle"></i> {{ $ticket->available }} Available
                            </span>
                        @endif

                        <div class="ticket-name">{{ $ticket->name }}</div>
                        <div class="ticket-price">₦{{ number_format($ticket->price, 2) }}</div>
                        
                        @if($ticket->description)
                            <p style="color: var(--text-medium); margin-bottom: 16px;">{{ $ticket->description }}</p>
                        @endif

                        @if($ticket->benefits && count($ticket->benefits) > 0)
                            <ul class="ticket-benefits">
                                @foreach($ticket->benefits as $benefit)
                                    <li>
                                        <i class="fas fa-check"></i>
                                        <span>{{ $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <button class="buy-btn" 
                                onclick="openBuyModal({{ $ticket->id }}, '{{ $ticket->name }}', {{ $ticket->price }}, {{ $ticket->available }})"
                                {{ $ticket->isSoldOut() ? 'disabled' : '' }}>
                            <i class="fas fa-shopping-cart"></i> 
                            {{ $ticket->isSoldOut() ? 'Sold Out' : 'Buy Ticket' }}
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 16px;">
                <i class="fas fa-ticket-alt" style="font-size: 64px; color: var(--border-light); margin-bottom: 20px;"></i>
                <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 12px;">No Tickets Available</h3>
                <p style="color: var(--text-medium);">Tickets for this event are not available at the moment.</p>
            </div>
        @endif
    </div>

    <!-- Buy Modal -->
    <div id="buyModal" class="modal">
        <div class="modal-content">
            <h2 style="font-size: 24px; font-weight: 800; margin-bottom: 24px;">Purchase Ticket</h2>
            
            <form id="purchaseForm" method="POST">
                @csrf
                <input type="hidden" name="ticket_id" id="modal_ticket_id">
                
                <div style="background: var(--sidebar-bg); padding: 16px; border-radius: 12px; margin-bottom: 24px;">
                    <div style="font-size: 18px; font-weight: 700; margin-bottom: 8px;" id="modal_ticket_name"></div>
                    <div style="font-size: 28px; font-weight: 800; color: var(--primary-gold);" id="modal_ticket_price"></div>
                </div>

                <div class="form-group">
                    <label>Quantity <span style="color: #EF4444;">*</span></label>
                    <input type="number" name="quantity" id="quantity" min="1" max="10" value="1" required 
                           onchange="updateTotal()">
                    <p style="font-size: 13px; color: var(--text-light); margin-top: 6px;" id="available_text"></p>
                </div>

                <div class="form-group">
                    <label>Full Name <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="buyer_name" required placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label>Email <span style="color: #EF4444;">*</span></label>
                    <input type="email" name="buyer_email" required placeholder="your@email.com">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="buyer_phone" placeholder="+234 800 000 0000">
                </div>

                <div style="background: var(--sidebar-bg); padding: 16px; border-radius: 12px; margin-bottom: 24px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                        <span>Subtotal:</span>
                        <span id="subtotal" style="font-weight: 600;"></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: 800; color: var(--primary-gold);">
                        <span>Total:</span>
                        <span id="total"></span>
                    </div>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="button" onclick="closeBuyModal()" 
                            style="flex: 1; padding: 14px; background: transparent; color: var(--text-medium); border: 2px solid var(--border-light); border-radius: 10px; font-weight: 600; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit" class="buy-btn" style="flex: 2;">
                        Proceed to Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let currentTicketPrice = 0;
        let currentTicketAvailable = 0;

        function openBuyModal(ticketId, ticketName, ticketPrice, available) {
            currentTicketPrice = ticketPrice;
            currentTicketAvailable = available;
            
            document.getElementById('modal_ticket_id').value = ticketId;
            document.getElementById('modal_ticket_name').textContent = ticketName;
            document.getElementById('modal_ticket_price').textContent = '₦' + ticketPrice.toLocaleString();
            document.getElementById('available_text').textContent = available + ' tickets available';
            document.getElementById('quantity').max = Math.min(10, available);
            document.getElementById('purchaseForm').action = '/tickets/' + ticketId + '/checkout';
            
            updateTotal();
            document.getElementById('buyModal').classList.add('active');
        }

        function closeBuyModal() {
            document.getElementById('buyModal').classList.remove('active');
        }

        function updateTotal() {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const total = currentTicketPrice * quantity;
            
            document.getElementById('subtotal').textContent = '₦' + total.toLocaleString();
            document.getElementById('total').textContent = '₦' + total.toLocaleString();
        }

        // Close modal when clicking outside
        document.getElementById('buyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBuyModal();
            }
        });
    </script>
</body>
</html>