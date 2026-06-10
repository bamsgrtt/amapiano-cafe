<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Admin Account
        User::updateOrCreate(
            ['email' => 'admin@amapiano.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Seed Staff Account
        User::updateOrCreate(
            ['email' => 'staff@amapiano.com'],
            [
                'name' => 'Staff Front Desk',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'email_verified_at' => now(),
            ]
        );
    }
}

