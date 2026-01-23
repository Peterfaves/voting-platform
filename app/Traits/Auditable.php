<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            if (!self::shouldAudit()) {
                return;
            }
            
            AuditLog::log(
                'create', 
                $model, 
                null, 
                $model->getAttributes(), 
                class_basename($model) . " created"
            );
        });

        static::updated(function ($model) {
            if (!self::shouldAudit()) {
                return;
            }
            
            $changes = $model->getChanges();
            $original = array_intersect_key($model->getOriginal(), $changes);
            
            if (!empty($changes)) {
                AuditLog::log(
                    'update', 
                    $model, 
                    $original, 
                    $changes,
                    class_basename($model) . " updated"
                );
            }
        });

        static::deleted(function ($model) {
            if (!self::shouldAudit()) {
                return;
            }
            
            AuditLog::log(
                'delete', 
                $model, 
                $model->getAttributes(), 
                null,
                class_basename($model) . " deleted"
            );
        });
    }

    /**
     * Determine if the model should be audited
     */
    protected static function shouldAudit(): bool
    {
        // Don't audit during tests or if audit logging is disabled
        return !app()->runningInConsole() || app()->runningUnitTests();
    }
}