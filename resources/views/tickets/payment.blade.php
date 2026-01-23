<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Order #{{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: {
                            DEFAULT: '#D4AF37',
                            dark: '#B8941E',
                            light: '#FFFBF0',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-10 max-w-6xl">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gold-light rounded-full mb-4">
                <i class="fas fa-lock text-4xl text-gold"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Complete Your Payment</h1>
            <p class="text-gray-600">Secure payment powered by Paystack</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Order Summary Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-receipt text-gold mr-3"></i>
                    Order Summary
                </h2>
                
                <!-- Order Number -->
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-1">Order Number</p>
                    <p class="text-lg font-mono font-bold text-gold">{{ $order->order_number }}</p>
                </div>

                <div class="border-t border-gray-200 my-6"></div>

                <!-- Event Details -->
                <div class="space-y-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Event</p>
                        <p class="font-semibold text-gray-900">{{ $order->ticket->event->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-1">Ticket Type</p>
                        <p class="font-semibold text-gray-900">{{ $order->ticket->name }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-200 my-6"></div>

                <!-- Buyer Info -->
                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-1">Buyer Information</p>
                    <p class="font-semibold text-gray-900">{{ $order->buyer_name }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $order->buyer_email }}</p>
                </div>

                <div class="border-t border-gray-200 my-6"></div>

                <!-- Price Breakdown -->
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Quantity</span>
                        <span class="font-semibold text-gray-900">{{ $order->quantity }} ticket(s)</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Price per ticket</span>
                        <span class="font-semibold text-gray-900">₦{{ number_format($order->unit_price, 2) }}</span>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-gold-light rounded-xl p-5 flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-900">Total Amount</span>
                    <span class="text-3xl font-bold text-gold">₦{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Payment Method Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-credit-card text-gold mr-3"></i>
                    Select Payment Method
                </h2>
                
                <form method="POST" action="{{ route('tickets.process-payment', $order) }}" id="paymentForm">
                    @csrf
                    
                    <div class="space-y-4 mb-8">
                        <!-- Card Payment -->
                        <label class="payment-option block cursor-pointer group">
                            <input type="radio" name="payment_method" value="card" class="hidden peer" checked>
                            <div class="border-2 border-gray-200 rounded-xl p-5 transition-all peer-checked:border-gold peer-checked:bg-gold-light hover:border-gold hover:bg-gold-light/50">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-gold to-gold-dark rounded-lg flex items-center justify-center text-white text-xl flex-shrink-0">
                                        <i class="fas fa-credit-card"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Card Payment</h3>
                                        <p class="text-sm text-gray-600">Visa, Mastercard, or Verve</p>
                                    </div>
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center peer-checked:border-gold peer-checked:bg-gold transition-all">
                                        <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- Bank Transfer -->
                        <label class="payment-option block cursor-pointer group">
                            <input type="radio" name="payment_method" value="bank_transfer" class="hidden peer">
                            <div class="border-2 border-gray-200 rounded-xl p-5 transition-all peer-checked:border-gold peer-checked:bg-gold-light hover:border-gold hover:bg-gold-light/50">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-gold to-gold-dark rounded-lg flex items-center justify-center text-white text-xl flex-shrink-0">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">Bank Transfer</h3>
                                        <p class="text-sm text-gray-600">Direct bank account payment</p>
                                    </div>
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center peer-checked:border-gold peer-checked:bg-gold transition-all">
                                        <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- USSD -->
                        <label class="payment-option block cursor-pointer group">
                            <input type="radio" name="payment_method" value="ussd" class="hidden peer">
                            <div class="border-2 border-gray-200 rounded-xl p-5 transition-all peer-checked:border-gold peer-checked:bg-gold-light hover:border-gold hover:bg-gold-light/50">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-gold to-gold-dark rounded-lg flex items-center justify-center text-white text-xl flex-shrink-0">
                                        <i class="fas fa-mobile-alt"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900">USSD Payment</h3>
                                        <p class="text-sm text-gray-600">Pay with your bank's USSD code</p>
                                    </div>
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center peer-checked:border-gold peer-checked:bg-gold transition-all">
                                        <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Payment Info Box -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-500 text-lg mt-0.5"></i>
                            <div>
                                <p class="text-sm text-blue-900 font-semibold mb-1">Secure Payment</p>
                                <p class="text-xs text-blue-800">You will be redirected to Paystack to complete your payment securely.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pay Button -->
                    <button type="submit" id="payButton" class="w-full bg-gold hover:bg-gold-dark text-white font-bold py-4 px-6 rounded-xl transition-all flex items-center justify-center gap-3 text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98]">
                        <i class="fas fa-lock"></i>
                        <span>Pay ₦{{ number_format($order->total_amount, 2) }}</span>
                    </button>
                </form>

                <!-- Security Badge -->
                <div class="mt-6 flex items-center justify-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-shield-alt text-green-600"></i>
                    <span>Secured with 256-bit SSL encryption</span>
                </div>

                <!-- Paystack Logo -->
                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-500">Powered by</p>
                    <img src="https://paystack.com/assets/img/logo/logo.svg" alt="Paystack" class="h-6 mx-auto mt-1 opacity-60">
                </div>
            </div>
        </div>
    </div>

    <!-- Paystack Inline JS -->
    <script src="https://js.paystack.co/v1/inline.js"></script>
    
    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const payButton = document.getElementById('payButton');
            const originalContent = payButton.innerHTML;
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Processing...</span>';
            payButton.disabled = true;
            
            // Initialize Paystack payment
            const handler = PaystackPop.setup({
                key: '{{ $paystackPublicKey }}',
                email: '{{ $order->buyer_email }}',
                amount: {{ $order->total_amount * 100 }}, // Amount in kobo
                currency: 'NGN',
                ref: '{{ $order->payment_reference }}',
                metadata: {
                    order_id: {{ $order->id }},
                    order_number: '{{ $order->order_number }}',
                    buyer_name: '{{ $order->buyer_name }}',
                    ticket_name: '{{ $order->ticket->name }}',
                    event_name: '{{ $order->ticket->event->name }}',
                    quantity: {{ $order->quantity }},
                    custom_fields: [
                        {
                            display_name: "Order Number",
                            variable_name: "order_number",
                            value: "{{ $order->order_number }}"
                        },
                        {
                            display_name: "Event",
                            variable_name: "event",
                            value: "{{ $order->ticket->event->name }}"
                        }
                    ]
                },
                callback: function(response) {
                    // Payment successful - redirect to callback URL
                    window.location.href = '{{ route('tickets.callback') }}?reference=' + response.reference;
                },
                onClose: function() {
                    // Reset button state when payment window is closed
                    payButton.innerHTML = originalContent;
                    payButton.disabled = false;
                    
                    // Show message
                    alert('Payment window closed. Your order is still pending. Click "Pay" again to complete your purchase.');
                }
            });
            
            handler.openIframe();
        });
    </script>
</body>
</html>