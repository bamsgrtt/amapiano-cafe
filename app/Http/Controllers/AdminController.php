<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Promo;
use App\Models\Reservation;
use App\Models\StoreOperationalDate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request)
    {
        // 1. Statistics
        $startOfMonth = now()->startOfMonth()->toDateString();
        $endOfMonth = now()->endOfMonth()->toDateString();

        $totalReservationsMonth = Reservation::whereBetween('date', [$startOfMonth, $endOfMonth])->count();
        $checkinsToday = Reservation::whereDate('date', today())->where('status', 'checked_in')->count();

        // Capped occupancy percentage
        $totalTables = 25;
        $occupiedTablesCount = Reservation::whereDate('date', today())->where('status', 'checked_in')->distinct('table_id')->count();
        $occupancyRate = $totalTables > 0 ? min(100, round(($occupiedTablesCount / $totalTables) * 100)) : 0;

        // Estimated revenue — Rp 40.000 weekday / Rp 60.000 weekend per checked-in guest
        $todayIsWeekend = now()->timezone('Asia/Jakarta')->isWeekend();
        $todayRate = $todayIsWeekend ? 60000 : 40000;

        $checkedInGuestsToday = Reservation::whereDate('date', today())
            ->where('status', 'checked_in')
            ->sum('guests');
        $estimatedRevenueToday = $checkedInGuestsToday * $todayRate;

        // Weekly: sum each day's guests * that day's rate
        $startOfWeek = now()->startOfWeek();
        $estimatedRevenueWeekly = 0;
        for ($d = 0; $d <= 6; $d++) {
            $day = $startOfWeek->copy()->addDays($d);
            $rate = $day->isWeekend() ? 60000 : 40000;
            $guests = Reservation::whereDate('date', $day->toDateString())
                ->where('status', 'checked_in')
                ->sum('guests');
            $estimatedRevenueWeekly += $guests * $rate;
        }

        // Monthly: sum each day's guests * that day's rate
        $startOfMonthDay = now()->startOfMonth();
        $daysInMonth = now()->daysInMonth;
        $estimatedRevenueMonthly = 0;
        for ($d = 0; $d < $daysInMonth; $d++) {
            $day = $startOfMonthDay->copy()->addDays($d);
            $rate = $day->isWeekend() ? 60000 : 40000;
            $guests = Reservation::whereDate('date', $day->toDateString())
                ->where('status', 'checked_in')
                ->sum('guests');
            $estimatedRevenueMonthly += $guests * $rate;
        }

        /** Format a raw amount to a readable IDR string (Rb / Jt). */
        $formatRevenue = static function (int $amount): string {
            if ($amount >= 1000000) {
                return 'Rp '.number_format($amount / 1000000, 1).'Jt';
            }

            return 'Rp '.number_format($amount / 1000, 0).'Rb';
        };

        $estimatedRevenue = $formatRevenue($estimatedRevenueToday);
        $estimatedRevenueWeek = $formatRevenue($estimatedRevenueWeekly);
        $estimatedRevenueMonth = $formatRevenue($estimatedRevenueMonthly);

        // 2. Chart data: last 7 days reservation vs checkins
        $chartLabels = [];
        $chartReservations = [];
        $chartCheckins = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('d M');
            $chartReservations[] = Reservation::whereDate('date', $date->toDateString())->count();
            $chartCheckins[] = Reservation::whereDate('date', $date->toDateString())->where('status', 'checked_in')->count();
        }

        // 3. Reservations search & list
        $search = $request->input('search');
        $reservationsQuery = Reservation::latest();
        if (! empty($search)) {
            $searchClean = ltrim(strtoupper(trim($search)), '#');
            $reservationsQuery->where(function ($q) use ($search, $searchClean) {
                $q->where('fullname', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$searchClean}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $reservations = $reservationsQuery->paginate(10)->withQueryString();

        // 4. Users list (admin & staff)
        $users = User::whereIn('role', ['admin', 'staff'])->get();

        // 5. Store open status
        $todaySchedule = StoreOperationalDate::where('date', today())->first();
        $storeOpen = $todaySchedule ? $todaySchedule->is_open : true;
        $storeOperationalDates = StoreOperationalDate::orderBy('date')->get();

                // 6. Promos
        $promoItems = Promo::where('type', '!=', 'Event / Live Music')->orderBy('start_date')->get();

        // 7. Categories & Menu items (DITAMBAHKAN)
        $categories = Category::orderBy('name')->get(); // <--- AMBIL DATA KATEGORI
        $menuItems = MenuItem::orderBy('category')->orderBy('name')->get();
        $allMenuItems = MenuItem::orderBy('category')->orderBy('name')->get();

        // TAMBAHKAN 'categories' DI DALAM COMPACT
        return view('admin.dashboard', compact(
            'totalReservationsMonth',
            'checkinsToday',
            'occupancyRate',
            'estimatedRevenue',
            'estimatedRevenueWeek',
            'estimatedRevenueMonth',
            'chartLabels',
            'chartReservations',
            'chartCheckins',
            'reservations',
            'users',
            'storeOpen',
            'storeOperationalDates',
            'promoItems',
            'menuItems',
            'allMenuItems',
            'categories' // <--- JANGAN LUPA TAMBAHKAN INI
        ));
    }

    /**
     * Store a newly created admin or staff user.
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,staff',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return back()->with('success_user', 'User successfully registered.');
    }

    /**
     * Toggle the cafe operational status.
     */
    public function toggleStoreStatus(Request $request)
    {
        $open = $request->boolean('open');
        Cache::put('store_open', $open);

        return response()->json([
            'success' => true,
            'store_open' => $open,
            'message' => 'Status operasional berhasil diperbarui.',
        ]);
    }

    /**
     * Store a date-based operational rule.
     */
    public function storeOperationalDate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($validated['start_date'])->startOfDay();
        $endDate = Carbon::parse($validated['end_date'])->startOfDay();

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            StoreOperationalDate::updateOrCreate([
                'date' => $date->toDateString(),
            ], [
                'is_open' => false,
            ]);
        }

        return back()->with('success_store_schedule', 'Cafe ditutup dari ' . $startDate->translatedFormat('d M Y') . ' hingga ' . $endDate->translatedFormat('d M Y') . '.');
    }

    /**
     * Delete date-based operational rules.
     */
    public function deleteOperationalDate($id): RedirectResponse
    {
        $idArray = explode(',', $id);
        StoreOperationalDate::whereIn('id', $idArray)->delete();

        return back()->with('success_store_schedule', 'Jadwal operasional berhasil dihapus.');
    }

    /**
     * Delete an admin or staff user account.
     */
    public function deleteUser($id): RedirectResponse
    {
        if (auth()->id() == $id) {
            return back()->withErrors(['error_user' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success_user', 'User berhasil dihapus.');
    }

    /**
     * Update reservation status directly from admin panel.
     */
       /**
     * Update reservation status directly from admin panel.
     */
      /**
     * Update reservation status directly from admin panel.
     */
    public function updateReservationStatus(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,checked_in,cancelled',
        ]);

        $res = Reservation::findOrFail($id);
        $updateData = ['status' => $validated['status']];
        
        if ($validated['status'] === 'checked_in') {
            // 1. Validasi Tanggal (HARUS hari ini)
            $today = now()->timezone('Asia/Jakarta')->toDateString();
            if ($res->date !== $today) {
                return back()->with('error_reservation', 'Tidak dapat melakukan check-in: Tanggal reservasi tidak sesuai (harus hari ini).');
            }

            // 2. Validasi Waktu (Sewa 2 Jam: Maksimal datang 2 jam sebelum, dan maksimal telat 2 jam)
            $bookingDateTime = Carbon::parse($res->date.' '.$res->time, 'Asia/Jakarta');
            $now = now()->timezone('Asia/Jakarta');
            
            // Batas awal: 2 jam sebelum waktu reservasi (Misal booking 19:00, boleh masuk dari 17:00)
            $earliestCheckInTime = $bookingDateTime->copy()->subHours(2); 
            
            // Batas akhir: Tepat 2 jam setelah waktu reservasi / waktu sewa habis (Misal booking 19:00, maksimal masuk jam 21:00)
            $latestCheckInTime = $bookingDateTime->copy()->addHours(2);   

            // Cek jika TERLALU AWAL
            if ($now->lt($earliestCheckInTime)) {
                $formattedLimit = $earliestCheckInTime->format('H:i');
                return back()->with('error_reservation', "Terlalu awal. Check-in hanya bisa dilakukan mulai 2 jam sebelum waktu reservasi (pukul {$formattedLimit}).");
            }

            // Cek jika TERLALU TELAT (Waktu sewa sudah habis)
            if ($now->gt($latestCheckInTime)) {
                $formattedLateLimit = $latestCheckInTime->format('H:i');
                return back()->with('error_reservation', "Waktu sewa sudah habis. Maksimal check-in adalah 2 jam setelah waktu reservasi (pukul {$formattedLateLimit}). Silakan buat reservasi baru.");
            }

            $updateData['checked_in_at'] = now();
        }
        
        $res->update($updateData);

        return back()->with('success_reservation', 'Status reservasi berhasil diperbarui.');
    }

    /**
     * Store a new menu item.
     */
    public function storeMenuItem(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string', // <-- DIUBAH: Hapus 'in:Western,...' agar bisa menerima kategori dinamis
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $menuItem = new MenuItem();
        $menuItem->fill([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'price' => (int) $validated['price'],
            'category' => $validated['category'],
        ]);

        if ($request->hasFile('photo')) {
            $menuItem->image_path = $request->file('photo')->store('menu_items', 'public');
        }

        $menuItem->save();

        return redirect()->route('admin.dashboard', ['tab' => 'menu-promo'])
            ->with('success_menu', 'Menu berhasil ditambahkan.');
    }

    /**
     * Update an existing menu item.
     */
       public function updateMenuItem(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string', // <-- DIUBAH: Hapus 'in:Western,...' di sini juga
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $menuItem->fill([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'price' => (int) $validated['price'],
            'category' => $validated['category'],
        ]);

        if ($request->hasFile('photo')) {
            if ($menuItem->image_path) {
                Storage::disk('public')->delete($menuItem->image_path);
            }
            $menuItem->image_path = $request->file('photo')->store('menu_items', 'public');
        }

        $menuItem->save();

        return redirect()->route('admin.dashboard', ['tab' => 'menu-promo'])
            ->with('success_menu', 'Menu berhasil diperbarui.');
    }
    /**
     * Delete a menu item.
     */
    public function deleteMenuItem($id): RedirectResponse
    {
        $menuItem = MenuItem::findOrFail($id);
        if ($menuItem->image_path) {
            Storage::disk('public')->delete($menuItem->image_path);
        }
        $menuItem->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'menu-promo'])
            ->with('success_menu', 'Menu berhasil dihapus.');
    }

        /**
     * Store a new menu category.
     */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        \App\Models\Category::create([
            'name' => ucfirst(strtolower($validated['name'])), // Format huruf kapital di awal
        ]);

        return back()->with('success_category', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Delete a menu category.
     */
    public function deleteCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        
        // Opsional: Cek apakah ada menu yang memakai kategori ini
        $menuCount = \App\Models\MenuItem::where('category', $category->name)->count();
        if ($menuCount > 0) {
            return back()->with('error_category', "Gagal menghapus: Ada {$menuCount} menu yang menggunakan kategori ini. Ubah kategori menu tersebut terlebih dahulu.");
        }

        $category->delete();
        return back()->with('success_category', 'Kategori berhasil dihapus.');
    }

    /**
     * Store a new promo or event.
     */
    public function storePromo(Request $request)
    {
        $validated = $request->validate([
    'title' => 'required|string|max:255',
    'start' => 'required|date',
    'end' => 'required|date|after_or_equal:start',
    'description' => 'nullable|string',
    'menu_items' => 'nullable|array',
    'menu_items.*' => 'integer|exists:menu_items,id',
]);
       $promo = Promo::create([
    'title' => $validated['title'],
    'type' => 'Promo',
    'start_date' => $validated['start'],
    'end_date' => $validated['end'],
    'description' => $validated['description'] ?? '',
    'status' => 'Aktif',
]);

        if (!empty($validated['menu_items']))
{
    $promo->menuItems()->sync($validated['menu_items']);
}

        return back()->with('success_promo', 'Promo / Event berhasil dipublikasikan.');
    }

    /**
     * Update an existing promo or event.
     */
    public function updatePromo(Request $request, $id)
    {
        $promo = Promo::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'menu_items' => 'nullable|array',
            'menu_items.*' => 'integer|exists:menu_items,id',
        ]);

        $promo->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'start_date' => $validated['start'],
            'end_date' => $validated['end'],
            'description' => $validated['description'] ?? '',
            'status' => $validated['status'],
        ]);

        if ($validated['type'] !== 'Event / Live Music') {
            $promo->menuItems()->sync($validated['menu_items'] ?? []);
        }

        return back()->with('success_promo', 'Promo / Event berhasil diperbarui.');
    }

    /**
     * Delete a promo/event by ID.
     */
    public function deletePromo($id): RedirectResponse
    {
        $promo = Promo::findOrFail($id);
        if ($promo->image_path) {
            Storage::disk('public')->delete($promo->image_path);
        }
        $promo->delete();

        return back()->with('success_promo', 'Promo / Event berhasil dihapus.');
    }
}