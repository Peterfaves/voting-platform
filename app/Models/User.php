<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'status',
        'bank_name',
        'account_number',
        'account_name',
        'bank_code',
        'admin_notes',
        'last_login_at',
        'last_login_ip',
        'suspended_at',
        'suspended_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'suspended_at' => 'datetime',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the events for the user.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get the votes for the user.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get the withdrawals for the user.
     */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role?->name, ['admin', 'super_admin']);
    }

    /**
     * Check if user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->role?->name === 'super_admin';
    }

    /**
     * Check if user is an organizer.
     */
    public function isOrganizer(): bool
    {
        return $this->role?->name === 'organizer';
    }

    /**
     * Check if user is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Check if user is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' || $this->status === null;
    }

    /**
     * Scope for organizers.
     */
    public function scopeOrganizers($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->where('name', 'organizer');
        });
    }

    /**
     * Scope for admins.
     */
    public function scopeAdmins($query)
    {
        return $query->whereHas('role', function ($q) {
            $q->whereIn('name', ['admin', 'super_admin']);
        });
    }

    /**
     * Scope for active users.
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'active')
              ->orWhereNull('status');
        });
    }

    /**
     * Scope for suspended users.
     */
    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }
}