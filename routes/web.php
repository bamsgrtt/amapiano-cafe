<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StaffController;
use App\Models\MenuItem;
use App\Models\StoreOperationalDate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $todaySchedule = StoreOperationalDate::where('date', today())->first();
    $storeOpen = $todaySchedule ? $todaySchedule->is_open : true;

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
    Route::post('/admin/menu-items', [AdminController::class, 'storeMenuItem'])->name('admin.menu-items.store');
    Route::put('/admin/menu-items/{id}', [AdminController::class, 'updateMenuItem'])->name('admin.menu-items.update');
    Route::delete('/admin/menu-items/{id}', [AdminController::class, 'deleteMenuItem'])->name('admin.menu-items.delete');
    Route::post('/admin/promos', [AdminController::class, 'storePromo'])->name('admin.promos.store');
    Route::put('/admin/promos/{id}', [AdminController::class, 'updatePromo'])->name('admin.promos.update');
    Route::delete('/admin/promos/{id}', [AdminController::class, 'deletePromo'])->name('admin.promos.delete');
    Route::post('/admin/store/schedule', [AdminController::class, 'storeOperationalDate'])->name('admin.store.schedule');
    Route::delete('/admin/store/schedule/{id}', [AdminController::class, 'deleteOperationalDate'])->name('admin.store.schedule.delete');
    Route::post('/admin/reservations/{id}/status', [AdminController::class, 'updateReservationStatus'])->name('admin.reservations.status');
});

// Staff Routes
Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
    Route::get('/staff/validate', [StaffController::class, 'validateReservation'])->name('staff.validate');
    Route::post('/staff/checkin', [StaffController::class, 'checkIn'])->name('staff.checkin');
});
Route::get('/reservation', function () {
    $todaySchedule = StoreOperationalDate::where('date', today())->first();
    $storeOpen = $todaySchedule ? $todaySchedule->is_open : true;

    $closedDates = StoreOperationalDate::whereBetween('date', [today()->toDateString(), now()->addDays(7)->toDateString()])
        ->where('is_open', false)
        ->pluck('date')
        ->map(fn ($date) => $date->toDateString());

    return view('reservation', compact('storeOpen', 'closedDates'));
})->name('reservation');

Route::get('/menu', function () {
    // Ambil data paling dasar dulu untuk memastikan tidak ada error query
    $categories = \App\Models\Category::orderBy('name', 'asc')->get();
    $menuItems = \App\Models\MenuItem::orderBy('category')->orderBy('name')->get();

    return view('menu', compact('categories', 'menuItems'));
})->name('menu');

Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/booked', [ReservationController::class, 'booked'])->name('reservations.booked');
Route::get('/reservations/{code}/download', [ReservationController::class, 'download'])->name('reservations.download');
Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
Route::delete('/admin/categories/{id}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');