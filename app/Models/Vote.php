<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use Auditable;  // Enable automatic audit logging

    protected $fillable = [
        'contestant_id', 
        'user_id', 
        'voter_name', 
        'voter_email', 
        'voter_phone', 
        'vote_count',                   // Keep for backward compatibility
        'number_of_votes',              // NEW - primary field name
        'amount_paid', 
        'payment_reference', 
        'payment_status',
        'payment_method',               // NEW - card, bank_transfer, ussd
        'ip_address',
        'user_agent',
        'gateway_transaction_id',      
        'gateway_reference',            
        'gateway_metadata',             
        'verified_at',                  
    ];

    protected $casts = [
        'vote_count' => 'integer',
        'number_of_votes' => 'integer', // NEW - for consistency with controller
        'amount_paid' => 'decimal:2',
        'gateway_metadata' => 'array',
        'verified_at' => 'datetime',
    ];

    // Accessor to support both field names
    public function getNumberOfVotesAttribute($value)
    {
        // If number_of_votes exists, use it; otherwise fall back to vote_count
        return $value ?? $this->attributes['vote_count'] ?? 0;
    }

    // Mutator to keep both fields in sync
    public function setNumberOfVotesAttribute($value)
    {
        $this->attributes['number_of_votes'] = $value;
        $this->attributes['vote_count'] = $value; // Keep in sync
    }

    public function contestant(): BelongsTo
    {
        return $this->belongsTo(Contestant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Status check methods
    public function isSuccessful(): bool
    {
        return $this->payment_status === 'success';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->payment_status === 'failed';
    }

    // Query scopes
    public function scopeSuccessful($query)
    {
        return $query->where('payment_status', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('payment_status', 'failed');
    }

    public function scopeForContestant($query, $contestantId)
    {
        return $query->where('contestant_id', $contestantId);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Helper methods
    public function getTotalAmount(): float
    {
        return (float) $this->amount_paid;
    }

    public function getVotesCount(): int
    {
        return $this->number_of_votes ?? $this->vote_count ?? 0;
    }

    public function getPaymentChannelAttribute(): ?string
    {
        return $this->payment_method ?? 
               ($this->gateway_metadata['channel'] ?? null);
    }

    // Relationship helpers
    public function getContestantName(): string
    {
        return $this->contestant->name ?? 'Unknown';
    }

    public function getEventName(): string
    {
        return $this->contestant->category->event->name ?? 'Unknown';
    }

    public function getCategoryName(): string
    {
        return $this->contestant->category->name ?? 'Unknown';
    }
}