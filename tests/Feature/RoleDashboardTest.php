<?php

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login redirects admin to admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->post('/login', [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/admin/dashboard');
});

test('login redirects staff to staff dashboard', function () {
    $staff = User::factory()->create(['role' => 'staff']);

    $response = $this->post('/login', [
        'email' => $staff->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/staff/dashboard');
});

test('login redirects customer to home page', function () {
    $customer = User::factory()->create(['role' => 'user']);

    $response = $this->post('/login', [
        'email' => $customer->email,
        'password' => 'password',
    ]);

    $response->assertRedirect('/');
});

test('unauthorized users cannot access admin dashboard', function () {
    $staff = User::factory()->create(['role' => 'staff']);
    $customer = User::factory()->create(['role' => 'user']);

    $this->get('/admin/dashboard')->assertRedirect('/login');

    $this->actingAs($customer)->get('/admin/dashboard')->assertStatus(403);

    $this->actingAs($staff)->get('/admin/dashboard')->assertStatus(403);
});

test('admin can access admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)->get('/admin/dashboard')->assertStatus(200);
});

test('staff and admin can access staff dashboard', function () {
    $staff = User::factory()->create(['role' => 'staff']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($staff)->get('/staff/dashboard')->assertStatus(200);
    $this->actingAs($admin)->get('/staff/dashboard')->assertStatus(200);
});

test('staff can validate pending reservation code', function () {
    $staff = User::factory()->create(['role' => 'staff']);
    $reservation = Reservation::create([
        'code' => 'AMP-TST1',
        'fullname' => 'Test Customer',
        'phone' => '1234567890',
        'date' => now()->toDateString(),
        'time' => '19:00',
        'area' => 'Main Hall',
        'table_id' => 'hb-1',
        'guests' => 2,
        'status' => 'pending'
    ]);

    $response = $this->actingAs($staff)->getJson('/staff/validate?code=AMP-TST1');

    $response->assertStatus(200)
             ->assertJsonPath('valid', true)
             ->assertJsonPath('status', 'pending');
});

test('staff can check in a reservation', function () {
    $staff = User::factory()->create(['role' => 'staff']);
    $reservation = Reservation::create([
        'code' => 'AMP-TST2',
        'fullname' => 'Test Customer 2',
        'phone' => '1234567890',
        'date' => now()->toDateString(),
        'time' => '19:00',
        'area' => 'Main Hall',
        'table_id' => 'hb-2',
        'guests' => 2,
        'status' => 'pending'
    ]);

    $response = $this->actingAs($staff)->postJson('/staff/checkin', ['code' => 'AMP-TST2']);

    $response->assertStatus(200)
             ->assertJsonPath('success', true);

    $this->assertDatabaseHas('reservations', [
        'code' => 'AMP-TST2',
        'status' => 'checked_in'
    ]);
});
