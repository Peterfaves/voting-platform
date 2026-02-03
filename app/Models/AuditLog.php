<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Create an audit log entry
     */
    public static function log(
        string $action,
        ?Model $model = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): self {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'auditable_type' => $model ? get_class($model) : null,
            'auditable_id' => $model?->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get the user name (accessor for admin UI)
     */
    public function getUserNameAttribute(): string
    {
        return $this->user?->name ?? 'System';
    }

    /**
     * Get action badge color for admin UI.
     */
    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'create' => 'success',
            'update' => 'info',
            'delete' => 'danger',
            'approve' => 'success',
            'reject' => 'danger',
            'suspend' => 'warning',
            'activate' => 'success',
            'login' => 'info',
            'logout' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get action icon for admin UI.
     */
    public function getActionIconAttribute(): string
    {
        return match ($this->action) {
            'create' => 'fa-plus',
            'update' => 'fa-edit',
            'delete' => 'fa-trash',
            'approve' => 'fa-check',
            'reject' => 'fa-times',
            'suspend' => 'fa-ban',
            'activate' => 'fa-check-circle',
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            default => 'fa-circle',
        };
    }

    /**
     * Alias for model_type (for admin views compatibility)
     */
    public function getModelTypeAttribute()
    {
        return $this->auditable_type;
    }

    /**
     * Alias for model_id (for admin views compatibility)
     */
    public function getModelIdAttribute()
    {
        return $this->auditable_id;
    }
}