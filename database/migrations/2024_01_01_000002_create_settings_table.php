<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json, array
            $table->string('group')->default('general'); // general, fees, voting, payment, notifications
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('group');
        });

        // Insert default settings
        $this->seedDefaultSettings();
    }

    /**
     * Seed default platform settings.
     */
    private function seedDefaultSettings(): void
    {
        $settings = [
            // Fee Settings
            [
                'key' => 'platform_fee',
                'value' => '10',
                'type' => 'integer',
                'group' => 'fees',
                'label' => 'Platform Fee (%)',
                'description' => 'Percentage charged on all withdrawals'
            ],
            [
                'key' => 'min_withdrawal',
                'value' => '1000',
                'type' => 'integer',
                'group' => 'fees',
                'label' => 'Minimum Withdrawal (₦)',
                'description' => 'Minimum amount for withdrawal requests'
            ],
            [
                'key' => 'max_withdrawal',
                'value' => '1000000',
                'type' => 'integer',
                'group' => 'fees',
                'label' => 'Maximum Withdrawal (₦)',
                'description' => 'Maximum amount for a single withdrawal'
            ],
            
            // Voting Settings
            [
                'key' => 'default_vote_price',
                'value' => '100',
                'type' => 'integer',
                'group' => 'voting',
                'label' => 'Default Vote Price (₦)',
                'description' => 'Suggested vote price for new events'
            ],
            [
                'key' => 'min_vote_price',
                'value' => '50',
                'type' => 'integer',
                'group' => 'voting',
                'label' => 'Minimum Vote Price (₦)',
                'description' => 'Minimum vote price organizers can set'
            ],
            [
                'key' => 'max_votes_per_transaction',
                'value' => '1000',
                'type' => 'integer',
                'group' => 'voting',
                'label' => 'Max Votes Per Transaction',
                'description' => 'Maximum votes in one transaction'
            ],
            
            // Withdrawal Schedule
            [
                'key' => 'withdrawal_days',
                'value' => json_encode(['monday', 'wednesday', 'friday']),
                'type' => 'json',
                'group' => 'fees',
                'label' => 'Withdrawal Days',
                'description' => 'Days when withdrawals are allowed'
            ],
            [
                'key' => 'processing_days',
                'value' => '3',
                'type' => 'integer',
                'group' => 'fees',
                'label' => 'Processing Time (Days)',
                'description' => 'Expected withdrawal processing time'
            ],
            
            // Payment Settings
            [
                'key' => 'payment_gateway',
                'value' => 'paystack',
                'type' => 'string',
                'group' => 'payment',
                'label' => 'Payment Gateway',
                'description' => 'Active payment gateway'
            ],
            
            // Notification Settings
            [
                'key' => 'notify_withdrawals',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Withdrawal Notifications',
                'description' => 'Notify on new withdrawal requests'
            ],
            [
                'key' => 'notify_registrations',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Registration Notifications',
                'description' => 'Notify on new user registrations'
            ],
            [
                'key' => 'notify_high_value',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'High Value Notifications',
                'description' => 'Notify on high-value transactions'
            ],
            [
                'key' => 'notify_suspicious',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notifications',
                'label' => 'Suspicious Activity Alerts',
                'description' => 'Notify on suspicious patterns'
            ],
        ];

        foreach ($settings as $setting) {
            \DB::table('settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
