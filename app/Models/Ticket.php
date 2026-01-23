<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'quantity',
        'sold',
        'status',
        'sale_start',
        'sale_end',
        'benefits',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'sold' => 'integer',
        'sale_start' => 'date',  // Changed from 'datetime' to 'date'
        'sale_end' => 'date',    // Changed from 'datetime' to 'date'
        'benefits' => 'array',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(TicketOrder::class);
    }

    public function getAvailableAttribute(): int
    {
        return $this->quantity - $this->sold;
    }

    public function isAvailable(): bool
    {
        return $this->status === 'active' 
            && $this->available > 0
            && (!$this->sale_end || now()->startOfDay()->lte($this->sale_end))
            && (!$this->sale_start || now()->startOfDay()->gte($this->sale_start));
    }

    public function isSoldOut(): bool
    {
        return $this->sold >= $this->quantity;
    }
}