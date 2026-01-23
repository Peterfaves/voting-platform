<?php

// app/Http/Controllers/TicketController.php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index($eventSlug)
    {
        $event = Event::where('slug', $eventSlug)
            ->with('tickets')
            ->firstOrFail();

        return view('tickets.index', compact('event'));
    }

    public function purchase(Request $request, Ticket $ticket)
    {
        $request->validate([
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email',
            'buyer_phone' => 'required|string',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        if ($ticket->available_quantity < $request->quantity) {
            return back()->with('error', 'Not enough tickets available');
        }

        $totalAmount = $ticket->price * $request->quantity;
        $reference = 'TICKET-' . strtoupper(Str::random(12));
        $ticketCode = 'TC-' . strtoupper(Str::random(10));

        $purchase = TicketPurchase::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'buyer_name' => $request->buyer_name,
            'buyer_email' => $request->buyer_email,
            'buyer_phone' => $request->buyer_phone,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount,
            'payment_reference' => $reference,
            'ticket_code' => $ticketCode,
            'payment_status' => 'pending',
        ]);

        return $this->initializeTicketPayment($purchase);
    }

    private function initializeTicketPayment(TicketPurchase $purchase)
    {
        $paymentSetting = \App\Models\PaymentSetting::where('is_active', true)->first();
        
        $url = "https://api.paystack.co/transaction/initialize";
        
        $fields = [
            'email' => $purchase->buyer_email,
            'amount' => $purchase->total_amount * 100,
            'reference' => $purchase->payment_reference,
            'callback_url' => route('tickets.callback'),
            'metadata' => [
                'purchase_id' => $purchase->id,
                'ticket_name' => $purchase->ticket->name,
                'quantity' => $purchase->quantity,
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $paymentSetting->secret_key,
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response);

        if ($result->status) {
            return redirect($result->data->authorization_url);
        }

        return back()->with('error', 'Payment initialization failed');
    }

    public function callback(Request $request)
    {
        $reference = $request->reference;
        $paymentSetting = \App\Models\PaymentSetting::where('is_active', true)->first();
        
        $url = "https://api.paystack.co/transaction/verify/" . $reference;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $paymentSetting->secret_key,
        ]);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $result = json_decode($response);

        if ($result->status && $result->data->status === 'success') {
            $purchase = TicketPurchase::where('payment_reference', $reference)->first();
            
            if ($purchase && $purchase->payment_status !== 'success') {
                $purchase->update(['payment_status' => 'success']);
                $purchase->ticket->increment('sold', $purchase->quantity);

                // Send email with ticket code here
                
                return redirect()
                    ->route('tickets.success', $purchase)
                    ->with('success', 'Ticket purchased successfully!');
            }
        }

        return redirect()->route('home')->with('error', 'Payment verification failed');
    }

    public function success(TicketPurchase $purchase)
    {
        if ($purchase->payment_status !== 'success') {
            abort(404);
        }

        $purchase->load('ticket.event');

        return view('tickets.success', compact('purchase'));
    }
}