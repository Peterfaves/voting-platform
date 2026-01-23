<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $organizerRole = Role::where('name', 'organizer')->first();

        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@chilkyvote.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'phone' => '+234800000000',
                'email_verified_at' => now(),
            ]
        );

        // Create Organizer User
        User::firstOrCreate(
            ['email' => 'organizer@chilkyvote.com'],
            [
                'name' => 'Event Organizer',
                'password' => Hash::make('password'),
                'role_id' => $organizerRole->id,
                'phone' => '+234800000001',
                'email_verified_at' => now(),
            ]
        );
    }
}