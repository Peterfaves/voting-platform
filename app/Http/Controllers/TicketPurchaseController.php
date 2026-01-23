<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketOrder;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\TicketPurchaseConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Services\PaystackService;

class TicketPurchaseController extends Controller
{
    protected $paystack;

    public function __construct(PaystackService $paystack)
    {
        $this->paystack = $paystack;
    }

    public function show(Event $event)
    {
        $allTickets = $event->tickets()->where('status', 'active')->get();
        $tickets = $allTickets->filter(fn($ticket) => $ticket->isAvailable());
        
        return view('tickets.show', compact('event', 'tickets'));
    }

    public function checkout(Request $request, Ticket $ticket)
    {
        if (!$ticket->isAvailable()) {
            return redirect()->back()->with('error', 'This ticket is no longer available.');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email|max:255',
            'buyer_phone' => 'nullable|string|max:20',
        ]);

        if ($validated['quantity'] > $ticket->available) {
            return redirect()->back()->with('error', 'Only ' . $ticket->available . ' tickets available.');
        }

        $totalAmount = $ticket->price * $validated['quantity'];

        $order = TicketOrder::create([
            'ticket_id' => $ticket->id,
            'buyer_name' => $validated['buyer_name'],
            'buyer_email' => $validated['buyer_email'],
            'buyer_phone' => $validated['buyer_phone'] ?? null,
            'quantity' => $validated['quantity'],
            'unit_price' => $ticket->price,
            'total_amount' => $totalAmount,
            'payment_status' => 'pending',
            'status' => 'active',
        ]);

        return redirect()->route('tickets.payment', $order);
    }

    public function payment(TicketOrder $order)
    {
        if ($order->payment_status === 'success') {
            return redirect()->route('tickets.success', $order);
        }

        $paystackPublicKey = $this->paystack->getPublicKey();
        
        return view('tickets.payment', compact('order', 'paystackPublicKey'));
    }

    public function processPayment(Request $request, TicketOrder $order)
    {
        try {
            $metadata = [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'buyer_name' => $order->buyer_name,
                'ticket_name' => $order->ticket->name,
                'event_name' => $order->ticket->event->name,
                'quantity' => $order->quantity,
            ];

            $response = $this->paystack->initializeTransaction(
                $order->buyer_email,
                $order->total_amount,
                $order->payment_reference,
                $metadata
            );

            if ($response['status']) {
                return redirect($response['data']['authorization_url']);
            }

            return redirect()->back()->with('error', 'Payment initialization failed.');

        } catch (\Exception $e) {
            logger('Paystack initialization error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Payment initialization failed.');
        }
    }

    public function callback(Request $request)
    {
        try {
            $reference = $request->query('reference');

            if (!$reference) {
                return redirect()->route('home')->with('error', 'Invalid payment reference.');
            }

            $response = $this->paystack->verifyTransaction($reference);

            if (!$response['status'] || $response['data']['status'] !== 'success') {
                return redirect()->route('home')->with('error', 'Payment verification failed.');
            }

            $data = $response['data'];
            $order = TicketOrder::where('payment_reference', $data['reference'])->first();

            if (!$order) {
                return redirect()->route('home')->with('error', 'Order not found.');
            }

            if ($order->payment_status === 'success') {
                return redirect()->route('tickets.success', $order);
            }

            // Verify amount
            $expectedAmount = $order->total_amount * 100;
            if ($data['amount'] != $expectedAmount) {
                $order->update(['payment_status' => 'failed']);
                return redirect()->route('home')->with('error', 'Payment amount mismatch.');
            }

            // Update order
            $order->update([
                'payment_status' => 'success',
                'payment_method' => $data['channel'] ?? 'card',
            ]);

            $order->ticket->increment('sold', $order->quantity);

            // Generate QR Code
            $qrCode = QrCode::format('svg')->size(300)->generate($order->order_number);
            $qrPath = 'qrcodes/' . $order->order_number . '.svg';
            Storage::disk('public')->put($qrPath, $qrCode);
            $order->update(['qr_code' => $qrPath]);

            // Send email
            try {
                Mail::to($order->buyer_email)->send(new TicketPurchaseConfirmation($order));
            } catch (\Exception $e) {
                logger('Email send failed: ' . $e->getMessage());
            }

            return redirect()->route('tickets.success', $order);

        } catch (\Exception $e) {
            logger('Paystack callback error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Payment processing failed.');
        }
    }

    public function success(TicketOrder $order)
    {
        if ($order->payment_status !== 'success') {
            return redirect()->route('events.show', $order->ticket->event);
        }

        return view('tickets.success', compact('order'));
    }

    public function download(TicketOrder $order)
    {
        if ($order->payment_status !== 'success') {
            abort(403);
        }

        $pdf = Pdf::loadView('tickets.pdf', compact('order'));
        return $pdf->download('ticket-' . $order->order_number . '.pdf');
    }
}