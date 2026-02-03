<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'platform_fee',
        'net_amount',
        'reference',
        'bank_name',
        'account_number',
        'account_name',
        'status',
        'admin_note',
        'processed_at',
        'processed_by',           // ADD THIS
        'rejection_reason',       // ADD THIS
        'transaction_reference',  // ADD THIS
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who processed the withdrawal.
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Scope for pending withdrawals.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope for approved withdrawals.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Check if the withdrawal is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the withdrawal is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Approve the withdrawal.
     */
    public function approve($admin, ?string $notes = null): bool
    {
        $this->update([
            'status' => self::STATUS_APPROVED,
            'processed_by' => $admin->id,
            'processed_at' => now(),
            'admin_note' => $notes,
        ]);

        AuditLog::log(
            'approve',
            $this,
            null,
            null,
            "Approved withdrawal of ₦" . number_format($this->amount) . " for {$this->user->name}"
        );

        return true;
    }

    /**
     * Reject the withdrawal.
     */
    public function reject($admin, string $reason, ?string $notes = null): bool
    {
        $this->update([
            'status' => self::STATUS_REJECTED,
            'rejection_reason' => $reason,
            'processed_by' => $admin->id,
            'processed_at' => now(),
            'admin_note' => $notes,
        ]);

        AuditLog::log(
            'reject',
            $this,
            null,
            null,
            "Rejected withdrawal of ₦" . number_format($this->amount) . ". Reason: {$reason}"
        );

        return true;
    }
}