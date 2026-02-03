<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    /**
     * Cache key prefix
     */
    const CACHE_PREFIX = 'settings_';
    const CACHE_TTL = 3600; // 1 hour

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = self::CACHE_PREFIX . $key;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            return self::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value.
     */
    public static function set(string $key, $value, ?string $type = null): bool
    {
        $setting = self::where('key', $key)->first();

        if ($setting) {
            // Handle array/json values
            if (is_array($value)) {
                $value = json_encode($value);
                $type = $type ?? 'json';
            }

            $setting->update([
                'value' => $value,
                'type' => $type ?? $setting->type,
            ]);
        } else {
            // Create new setting
            if (is_array($value)) {
                $value = json_encode($value);
                $type = 'json';
            }

            self::create([
                'key' => $key,
                'value' => $value,
                'type' => $type ?? 'string',
            ]);
        }

        // Clear cache
        Cache::forget(self::CACHE_PREFIX . $key);
        Cache::forget(self::CACHE_PREFIX . 'all');

        return true;
    }

    /**
     * Get all settings.
     */
    public static function getAll(): array
    {
        return Cache::remember(self::CACHE_PREFIX . 'all', self::CACHE_TTL, function () {
            $settings = [];
            
            foreach (self::all() as $setting) {
                $settings[$setting->key] = self::castValue($setting->value, $setting->type);
            }

            return $settings;
        });
    }

    /**
     * Get settings by group.
     */
    public static function getByGroup(string $group): array
    {
        $settings = [];
        
        foreach (self::where('group', $group)->get() as $setting) {
            $settings[$setting->key] = self::castValue($setting->value, $setting->type);
        }

        return $settings;
    }

    /**
     * Cast value based on type.
     */
    protected static function castValue($value, string $type)
    {
        return match ($type) {
            'integer', 'int' => (int) $value,
            'float', 'double' => (float) $value,
            'boolean', 'bool' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'json', 'array' => json_decode($value, true) ?? [],
            default => $value,
        };
    }

    /**
     * Clear all settings cache.
     */
    public static function clearCache(): void
    {
        $settings = self::all();

        foreach ($settings as $setting) {
            Cache::forget(self::CACHE_PREFIX . $setting->key);
        }

        Cache::forget(self::CACHE_PREFIX . 'all');
    }

    /**
     * Get platform fee percentage.
     */
    public static function getPlatformFee(): int
    {
        return (int) self::get('platform_fee', 10);
    }

    /**
     * Get minimum withdrawal amount.
     */
    public static function getMinWithdrawal(): int
    {
        return (int) self::get('min_withdrawal', 1000);
    }

    /**
     * Get maximum withdrawal amount.
     */
    public static function getMaxWithdrawal(): int
    {
        return (int) self::get('max_withdrawal', 1000000);
    }

    /**
     * Get withdrawal days.
     */
    public static function getWithdrawalDays(): array
    {
        return self::get('withdrawal_days', ['monday', 'wednesday', 'friday']);
    }

    /**
     * Check if today is a withdrawal day.
     */
    public static function isWithdrawalDay(): bool
    {
        $today = strtolower(now()->format('l'));
        return in_array($today, self::getWithdrawalDays());
    }

    /**
     * Get active payment gateway.
     */
    public static function getPaymentGateway(): string
    {
        return self::get('payment_gateway', 'paystack');
    }
}
