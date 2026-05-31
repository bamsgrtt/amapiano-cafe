<?php

use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a table cannot be reserved twice within 2 hours on the same day', function () {
    // 1. Create a reservation at 12:00
    Reservation::create([
        'code' => 'AMP-1111',
        'fullname' => 'John Doe',
        'phone' => '081234567890',
        'date' => '2026-06-01',
        'time' => '12:00',
        'area' => 'Main Hall',
        'table_id' => 'hb-1',
        'guests' => 2,
        'status' => 'pending',
    ]);

    // 2. Try to reserve the same table at 13:00 (within 2 hours) -> Should fail
    $responseFail = $this->postJson('/reservations', [
        'fullname' => 'Jane Doe',
        'phone' => '081234567891',
        'date' => '2026-06-01',
        'time' => '13:00',
        'area' => 'Main Hall',
        'table_id' => 'hb-1',
        'guests' => 2,
    ]);

    $responseFail->assertStatus(422)
        ->assertJsonPath('success', false)
        ->assertJsonPath('message', 'Meja ini sudah dipesan untuk jadwal tersebut (durasi per reservasi adalah 2 jam).');

    // 3. Try to reserve the same table at 14:00 (exactly 2 hours later) -> Should succeed
    $responseSuccess = $this->postJson('/reservations', [
        'fullname' => 'Bob Smith',
        'phone' => '081234567892',
        'date' => '2026-06-01',
        'time' => '14:00',
        'area' => 'Main Hall',
        'table_id' => 'hb-1',
        'guests' => 2,
    ]);

    $responseSuccess->assertSuccessful()
        ->assertJsonPath('success', true);

    $this->assertDatabaseHas('reservations', [
        'fullname' => 'Bob Smith',
        'time' => '14:00',
        'table_id' => 'hb-1',
    ]);
});

test('booked endpoint returns booked tables within 2 hours window', function () {
    // 1. Create a reservation at 12:00
    Reservation::create([
        'code' => 'AMP-2222',
        'fullname' => 'John Doe',
        'phone' => '081234567890',
        'date' => '2026-06-01',
        'time' => '12:00',
        'area' => 'Main Hall',
        'table_id' => 'hb-1',
        'guests' => 2,
        'status' => 'pending',
    ]);

    // 2. Query booked tables at 13:00 -> hb-1 should be in the list
    $response1300 = $this->getJson('/reservations/booked?date=2026-06-01&time=13:00');
    $response1300->assertSuccessful();
    expect($response1300->json())->toContain('hb-1');

    // 3. Query booked tables at 14:00 -> hb-1 should NOT be in the list
    $response1400 = $this->getJson('/reservations/booked?date=2026-06-01&time=14:00');
    $response1400->assertSuccessful();
    expect($response1400->json())->not->toContain('hb-1');
});
