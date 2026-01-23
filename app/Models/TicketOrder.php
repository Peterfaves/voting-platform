<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TicketOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'order_number',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'quantity',
        'unit_price',
        'total_amount',
        'payment_reference',
        'payment_method',
        'payment_status',
        'status',
        'qr_code',
        'used_at',
        'used_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'used_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'TKT-' . strtoupper(Str::random(10));
            }
            if (empty($order->payment_reference)) {
                $order->payment_reference = 'PAY-' . strtoupper(Str::random(12));
            }
        });
    }

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
        return $this->status === 'used' || !is_null($this->used_at);
    }

    public function canBeUsed(): bool
    {
        return $this->payment_status === 'success' 
            && $this->status === 'active'
            && !$this->isUsed();
    }
}