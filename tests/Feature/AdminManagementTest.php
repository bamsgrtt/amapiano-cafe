<?php

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

test('admin can delete staff user account', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $staff = User::factory()->create(['role' => 'staff']);

    $response = $this->actingAs($admin)->delete("/admin/users/{$staff->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('users', ['id' => $staff->id]);
});

test('admin cannot delete own user account', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->delete("/admin/users/{$admin->id}");

    $response->assertRedirect();
    $this->assertDatabaseHas('users', ['id' => $admin->id]);
});

test('admin can delete promo', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Cache::put('promos', [
        ['id' => 1, 'title' => 'Test Promo 1', 'type' => 'Diskon', 'start' => '2026-05-30', 'end' => '2026-06-05', 'description' => '', 'status' => 'Aktif'],
        ['id' => 2, 'title' => 'Test Promo 2', 'type' => 'Diskon', 'start' => '2026-05-30', 'end' => '2026-06-05', 'description' => '', 'status' => 'Aktif'],
    ]);

    $response = $this->actingAs($admin)->delete('/admin/promos/1');

    $response->assertRedirect();
    $promos = Cache::get('promos', []);
    expect($promos)->toHaveCount(1);
    expect($promos[0]['id'])->toBe(2);
});

test('admin can update reservation status', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $reservation = Reservation::create([
        'code' => 'AMP-TEST',
        'fullname' => 'Test Customer',
        'phone' => '1234567890',
        'date' => now()->toDateString(),
        'time' => '19:00',
        'area' => 'Main Hall',
        'table_id' => 'hb-1',
        'guests' => 2,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post("/admin/reservations/{$reservation->id}/status", [
        'status' => 'checked_in',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'status' => 'checked_in',
    ]);
});

test('bookings are rejected when store is closed', function () {
    
    
    // Create a closed operational date for the requested reservation date.
    $closedDate = now()->addDays(2)->toDateString();
    \App\Models\StoreOperationalDate::create(['date' => $closedDate, 'is_open' => false]);

    $response = $this->postJson('/reservations', [
        'fullname' => 'Bambang Sugiarto',
        'phone' => '082333900690',
        'date' => $closedDate,
        'time' => '11:00',
        'area' => 'Terrace',
        'table_id' => 'cg-3',
        'guests' => 4,
    ]);

    $response->assertStatus(422)
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Reservasi untuk tanggal tersebut ditutup oleh pengelola.');
});

test('admin cannot update status to checked_in for a future reservation', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $tomorrow = now()->timezone('Asia/Jakarta')->addDay();
    $reservation = Reservation::create([
        'code' => 'AMP-FUT-ADM',
        'fullname' => 'Future Customer',
        'phone' => '1234567890',
        'date' => $tomorrow->toDateString(),
        'time' => '19:00',
        'area' => 'Main Hall',
        'table_id' => 'hb-1',
        'guests' => 2,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post("/admin/reservations/{$reservation->id}/status", [
        'status' => 'checked_in',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error_reservation', 'Tidak dapat melakukan check-in: Tanggal reservasi tidak sesuai (harus hari ini).');

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'status' => 'pending',
    ]);
});

test('admin cannot update status to checked_in for an early reservation', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $nowInJakarta = now()->timezone('Asia/Jakarta');
    $futureTime = $nowInJakarta->copy()->addHour();

    $reservation = Reservation::create([
        'code' => 'AMP-ERL-ADM',
        'fullname' => 'Early Customer',
        'phone' => '1234567890',
        'date' => $nowInJakarta->toDateString(),
        'time' => $futureTime->format('H:i'),
        'area' => 'Main Hall',
        'table_id' => 'hb-1',
        'guests' => 2,
        'status' => 'pending',
    ]);

    $response = $this->actingAs($admin)->post("/admin/reservations/{$reservation->id}/status", [
        'status' => 'checked_in',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error_reservation', 'Tidak dapat melakukan check-in: Waktu reservasi belum tiba.');

    $this->assertDatabaseHas('reservations', [
        'id' => $reservation->id,
        'status' => 'pending',
    ]);
});
