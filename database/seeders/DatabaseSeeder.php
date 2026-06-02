<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@amapiano.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Staff
        User::factory()->create([
            'name' => 'Staff Front Desk',
            'email' => 'staff@amapiano.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        // Create Customer
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Seed some reservations
        $areas = ['Main Hall', 'Terrace', 'VIP Lounge'];
        $tables = [
            'Main Hall' => ['hb-1', 'hb-2', 'hb-3', 'hb-4', 'hb-5', 'hb-6', 'hb-7', 'hb-8'],
            'Terrace' => ['cg-1', 'cg-2', 'cg-3', 'cg-4', 'cg-5', 'cg-6', 'cg-7', 'cg-8', 'cg-9', 'cg-10'],
            'VIP Lounge' => ['lb-1', 'lb-2', 'lb-3', 'lb-4', 'lb-5', 'lb-6', 'lb-7'],
        ];

        // Seed checked-in reservations
        Reservation::create([
            'code' => 'AMP-8291',
            'fullname' => 'Dewi Lestari',
            'phone' => '081234567890',
            'date' => now()->toDateString(),
            'time' => '19:00',
            'area' => 'Main Hall',
            'table_id' => 'hb-1',
            'guests' => 2,
            'notes' => 'Dekat live music',
            'status' => 'checked_in',
            'checked_in_at' => now()->subMinutes(15),
        ]);

        // Seed pending reservations
        Reservation::create([
            'code' => 'AMP-8292',
            'fullname' => 'Budi Santoso',
            'phone' => '089876543210',
            'date' => now()->toDateString(),
            'time' => '19:00',
            'area' => 'Terrace',
            'table_id' => 'cg-3',
            'guests' => 4,
            'notes' => 'No smoking area',
            'status' => 'pending',
        ]);

        Reservation::create([
            'code' => 'AMP-8293',
            'fullname' => 'Ahmad Fauzi',
            'phone' => '087711223344',
            'date' => now()->toDateString(),
            'time' => '20:00',
            'area' => 'Main Hall',
            'table_id' => 'hb-3',
            'guests' => 4,
            'status' => 'pending',
        ]);

        Reservation::create([
            'code' => 'AMP-8294',
            'fullname' => 'Sarah Putri',
            'phone' => '081199887766',
            'date' => now()->toDateString(),
            'time' => '19:00',
            'area' => 'VIP Lounge',
            'table_id' => 'lb-1',
            'guests' => 2,
            'notes' => 'Acara ulang tahun',
            'status' => 'pending',
        ]);

        // Seed some history/other reservations
        for ($i = 0; $i < 20; $i++) {
            $area = $areas[array_rand($areas)];
            $table = $tables[$area][array_rand($tables[$area])];
            $status = rand(0, 10) > 3 ? 'checked_in' : 'pending';
            
            Reservation::create([
                'code' => Reservation::generateUniqueCode(),
                'fullname' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'date' => now()->subDays(rand(1, 15))->toDateString(),
                'time' => ['17:00', '18:00', '19:00', '20:00', '21:00'][rand(0, 4)],
                'area' => $area,
                'table_id' => $table,
                'guests' => rand(1, 4),
                'status' => $status,
                'checked_in_at' => $status === 'checked_in' ? now()->subDays(rand(1, 15)) : null,
            ]);
        }
    }
}