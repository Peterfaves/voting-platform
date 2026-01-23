@extends('layouts.organizer')

@section('title', 'Scan Tickets')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('organizer.tickets.index') }}" style="color: var(--primary-gold); text-decoration: none; font-weight: 500;">
        <i class="fas fa-arrow-left"></i> Back to Tickets
    </a>
</div>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="section-card" style="text-align: center;">
        <h1 style="font-size: 28px; font-weight: 800; margin-bottom: 8px;">
            <i class="fas fa-qrcode" style="color: var(--primary-gold);"></i> Scan Ticket QR Code
        </h1>
        <p style="color: var(--text-light); margin-bottom: 32px;">Scan ticket QR codes to validate entry</p>

        <!-- Camera Scanner -->
        <div id="scanner-container" style="position: relative; max-width: 500px; margin: 0 auto 32px;">
            <video id="qr-video" style="width: 100%; border-radius: 16px; background: #000;"></video>
            
            <div id="scanner-status" style="margin-top: 16px; padding: 12px; background: var(--sidebar-bg); border-radius: 8px;">
                <p style="color: var(--text-medium); margin: 0;">
                    <i class="fas fa-camera"></i> <span id="status-text">Initializing camera...</span>
                </p>
            </div>
        </div>

        <!-- Manual Entry -->
        <div style="background: white; padding: 32px; border: 2px solid var(--border-light); border-radius: 16px;">
            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px;">Or Enter Order Number Manually</h3>
            
            <form onsubmit="validateTicket(event)" style="display: flex; gap: 12px;">
                <input type="text" 
                       id="order_number" 
                       placeholder="TKT-XXXXXXXXXX"
                       required
                       style="flex: 1; padding: 16px 20px; border: 2px solid var(--border-light); border-radius: 12px; font-size: 16px; font-family: monospace;"
                       onfocus="this.style.borderColor='var(--primary-gold)'" 
                       onblur="this.style.borderColor='var(--border-light)'">
                <button type="submit" 
                        class="create-event-btn"
                        style="padding: 16px 32px;">
                    <i class="fas fa-check"></i>
                    Validate
                </button>
            </form>
        </div>
    </div>

    <!-- Validation Result -->
    <div id="validation-result" style="display: none; margin-top: 24px;"></div>
</div>
@endsection

@push('styles')
<style>
    #qr-video {
        max-height: 400px;
        object-fit: cover;
    }
</style>
@endpush

@push('scripts')
<!-- QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
let html5QrcodeScanner;

// Initialize QR Scanner
document.addEventListener('DOMContentLoaded', function() {
    const statusText = document.getElementById('status-text');
    
    html5QrcodeScanner = new Html5Qrcode("qr-video");
    
    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 }
    };
    
    // Start scanning
    html5QrcodeScanner.start(
        { facingMode: "environment" }, // Use back camera
        config,
        onScanSuccess,
        onScanError
    ).then(() => {
        statusText.textContent = 'Camera ready - Point at QR code';
        statusText.parentElement.style.background = '#DCFCE7';
        statusText.parentElement.style.color = '#166534';
    }).catch(err => {
        console.error('Camera error:', err);
        statusText.textContent = 'Camera not available - Use manual entry below';
        statusText.parentElement.style.background = '#FEF3C7';
        statusText.parentElement.style.color = '#92400E';
    });
});

// When QR code is successfully scanned
function onScanSuccess(decodedText, decodedResult) {
    console.log('QR Code detected:', decodedText);
    
    // Stop scanning temporarily
    html5QrcodeScanner.pause();
    
    // Validate the scanned code
    validateTicketByCode(decodedText);
}

function onScanError(error) {
    // Ignore errors - they happen constantly while scanning
}

// Validate ticket by QR code content
function validateTicketByCode(orderNumber) {
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
        showValidationResult(data);
        
        // Resume scanning after 3 seconds
        setTimeout(() => {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.resume();
            }
        }, 3000);
    })
    .catch(error => {
        console.error('Error:', error);
        showValidationResult({
            success: false,
            message: 'Failed to validate ticket'
        });
        
        // Resume scanning
        setTimeout(() => {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.resume();
            }
        }, 3000);
    });
}

// Manual validation
function validateTicket(event) {
    event.preventDefault();
    
    const orderNumber = document.getElementById('order_number').value;
    validateTicketByCode(orderNumber);
}

// Show validation result
function showValidationResult(data) {
    const resultDiv = document.getElementById('validation-result');
    resultDiv.style.display = 'block';
    
    if (data.success) {
        resultDiv.innerHTML = `
            <div class="section-card" style="background: #DCFCE7; border: 2px solid #22C55E;">
                <div style="text-align: center; padding: 20px;">
                    <i class="fas fa-check-circle" style="font-size: 64px; color: #22C55E; margin-bottom: 16px;"></i>
                    <h2 style="font-size: 24px; font-weight: 800; color: #166534; margin-bottom: 8px;">✓ Ticket Valid!</h2>
                    <p style="color: #166534; margin-bottom: 24px;">${data.message}</p>
                    
                    <div style="background: white; padding: 20px; border-radius: 12px; text-align: left;">
                        <div style="margin-bottom: 12px;">
                            <strong>Buyer:</strong> ${data.order.buyer_name}
                        </div>
                        <div style="margin-bottom: 12px;">
                            <strong>Ticket:</strong> ${data.order.ticket.name}
                        </div>
                        <div style="margin-bottom: 12px;">
                            <strong>Quantity:</strong> ${data.order.quantity}
                        </div>
                        <div>
                            <strong>Event:</strong> ${data.order.ticket.event.name}
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('order_number').value = '';
        
        // Play success sound
        playSound('success');
    } else {
        resultDiv.innerHTML = `
            <div class="section-card" style="background: #FEE2E2; border: 2px solid #EF4444;">
                <div style="text-align: center; padding: 20px;">
                    <i class="fas fa-times-circle" style="font-size: 64px; color: #EF4444; margin-bottom: 16px;"></i>
                    <h2 style="font-size: 24px; font-weight: 800; color: #991B1B; margin-bottom: 8px;">✗ Ticket Invalid</h2>
                    <p style="color: #991B1B;">${data.message}</p>
                </div>
            </div>
        `;
        
        // Play error sound
        playSound('error');
    }
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        resultDiv.style.display = 'none';
    }, 5000);
}

// Play sound feedback
function playSound(type) {
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    
    if (type === 'success') {
        oscillator.frequency.value = 800;
        gainNode.gain.value = 0.3;
    } else {
        oscillator.frequency.value = 300;
        gainNode.gain.value = 0.3;
    }
    
    oscillator.start();
    oscillator.stop(audioContext.currentTime + 0.1);
}

// Cleanup on page leave
window.addEventListener('beforeunload', () => {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.stop();
    }
});
</script>
@endpush