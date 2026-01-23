<?php

// app/Models/Contestant.php
namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Contestant extends Model
{
    use Auditable;  // Enable automatic audit logging
    
    protected $fillable = [
        'category_id', 'name', 'slug', 'bio', 'photo', 
        'video_url', 'total_votes', 'status'
    ];

    protected $casts = [
        'total_votes' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($contestant) {
            if (empty($contestant->slug)) {
                $contestant->slug = Str::slug($contestant->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function incrementVotes(int $count = 1): void
    {
        $this->increment('total_votes', $count);
    }

    public function getRankInCategoryAttribute(): int
    {
        return Contestant::where('category_id', $this->category_id)
            ->where('status', 'active')
            ->where('total_votes', '>', $this->total_votes)
            ->count() + 1;
    }
}
