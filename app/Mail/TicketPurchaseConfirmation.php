<?php

namespace App\Mail;

use App\Models\TicketOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class TicketPurchaseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(TicketOrder $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Purchase Confirmation - ' . $this->order->ticket->event->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}