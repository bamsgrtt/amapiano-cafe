<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $storeOpen = Cache::get('store_open', true);

    return view('welcome', compact('storeOpen'));
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/admin/promos', [AdminController::class, 'storePromo'])->name('admin.promos.store');
    Route::delete('/admin/promos/{id}', [AdminController::class, 'deletePromo'])->name('admin.promos.delete');
    Route::post('/admin/store/toggle', [AdminController::class, 'toggleStoreStatus'])->name('admin.store.toggle');
    Route::post('/admin/reservations/{id}/status', [AdminController::class, 'updateReservationStatus'])->name('admin.reservations.status');
});

// Staff Routes
Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
    Route::get('/staff/validate', [StaffController::class, 'validateReservation'])->name('staff.validate');
    Route::post('/staff/checkin', [StaffController::class, 'checkIn'])->name('staff.checkin');
});
Route::get('/reservation', function () {
    $storeOpen = Cache::get('store_open', true);

    return view('reservation', compact('storeOpen'));
})->name('reservation');

Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/booked', [ReservationController::class, 'booked'])->name('reservations.booked');
Route::get('/reservations/{code}/download', [ReservationController::class, 'download'])->name('reservations.download');
