<?php

namespace Database\Seeders;

use App\Models\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    public function run(): void
    {
        PaymentSetting::firstOrCreate(
            ['provider' => 'paystack'],
            [
                'public_key' => env('PAYSTACK_PUBLIC_KEY', 'pk_test_xxxxxxxxxxxxx'),
                'secret_key' => env('PAYSTACK_SECRET_KEY', 'sk_test_xxxxxxxxxxxxx'),
                'is_active' => true,
            ]
        );
    }
}