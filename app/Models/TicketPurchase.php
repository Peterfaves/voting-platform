<?php

// app/Models/TicketPurchase.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketPurchase extends Model
{
    protected $fillable = [
        'ticket_id', 'user_id', 'buyer_name', 'buyer_email', 
        'buyer_phone', 'quantity', 'total_amount', 
        'payment_reference', 'ticket_code', 'payment_status', 'used_at'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_amount' => 'decimal:2',
        'used_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isUsed(): bool
    {
        return !is_null($this->used_at);
    }
}