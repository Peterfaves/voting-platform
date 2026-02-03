<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminSettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::getAll();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $rules = [
            // Fees
            'platform_fee' => 'nullable|numeric|min:0|max:50',
            'min_withdrawal' => 'nullable|numeric|min:0',
            'max_withdrawal' => 'nullable|numeric|min:0',
            
            // Voting
            'default_vote_price' => 'nullable|numeric|min:0',
            'min_vote_price' => 'nullable|numeric|min:0',
            'max_votes_per_transaction' => 'nullable|integer|min:1',
            
            // Withdrawal days
            'withdrawal_days' => 'nullable|array',
            'withdrawal_days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'processing_days' => 'nullable|integer|min:1|max:14',
            
            // Payment
            'payment_gateway' => 'nullable|in:paystack,flutterwave',
            
            // Notifications
            'notify_withdrawals' => 'nullable|boolean',
            'notify_registrations' => 'nullable|boolean',
            'notify_high_value' => 'nullable|boolean',
            'notify_suspicious' => 'nullable|boolean',
        ];

        $request->validate($rules);

        $updated = [];

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            // Handle checkboxes (convert to boolean)
            if (str_starts_with($key, 'notify_')) {
                $value = $request->has($key) ? '1' : '0';
            }

            // Handle arrays (withdrawal_days)
            if (is_array($value)) {
                $value = json_encode($value);
            }

            $oldValue = Setting::get($key);
            Setting::set($key, $value);
            
            if ($oldValue != $value) {
                $updated[$key] = ['old' => $oldValue, 'new' => $value];
            }
        }

        // Log the changes
        if (!empty($updated)) {
            AuditLog::log(
                auth()->user(),
                AuditLog::ACTION_UPDATE,
                null,
                'Updated platform settings: ' . implode(', ', array_keys($updated)),
                array_column($updated, 'old'),
                array_column($updated, 'new')
            );
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Clear application cache.
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            
            Setting::clearCache();

            AuditLog::log(
                auth()->user(),
                'cache_clear',
                null,
                'Cleared all application caches'
            );

            return back()->with('success', 'All caches cleared successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    /**
     * Toggle maintenance mode.
     */
    public function toggleMaintenance(Request $request)
    {
        try {
            if (app()->isDownForMaintenance()) {
                Artisan::call('up');
                $message = 'Maintenance mode disabled. Site is now live.';
                $action = 'maintenance_off';
            } else {
                // Create a secret key for admin access during maintenance
                $secret = $request->get('secret', \Str::random(32));
                Artisan::call('down', [
                    '--secret' => $secret,
                ]);
                $message = "Maintenance mode enabled. Access via: /secret/{$secret}";
                $action = 'maintenance_on';
            }

            AuditLog::log(
                auth()->user(),
                $action,
                null,
                $message
            );

            return back()->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to toggle maintenance mode: ' . $e->getMessage());
        }
    }
}
