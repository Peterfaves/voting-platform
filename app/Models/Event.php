<?php

// app/Models/Event.php
namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use Auditable;  // Enable automatic audit logging
    
    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'banner_image',
        'vote_price', 'start_date', 'end_date', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'vote_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->name);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get all votes for this event through contestants
     */
    public function votes()
    {
        return Vote::whereHas('contestant.category', function ($query) {
            $query->where('event_id', $this->id);
        });
    }

    public function isActive(): bool
    {
        return $this->status === 'active' 
            && now()->between($this->start_date, $this->end_date);
    }

    public function getTotalVotesAttribute(): int
    {
        return $this->categories->sum(function ($category) {
            return $category->contestants->sum('total_votes');
        });
    }

    public function getTotalRevenueAttribute(): float
    {
        return Vote::whereHas('contestant.category', function ($query) {
            $query->where('event_id', $this->id);
        })->where('payment_status', 'success')->sum('amount_paid');
    }

    /**
     * Scope to get votes count for this event
     */
    public function scopeWithVotesCount($query)
    {
        return $query->withCount([
            'categories as votes_count' => function ($query) {
                $query->join('contestants', 'categories.id', '=', 'contestants.category_id')
                      ->join('votes', 'contestants.id', '=', 'votes.contestant_id');
            }
        ]);
    }
}