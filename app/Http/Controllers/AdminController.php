<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

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
        $storeOpen = Cache::get('store_open', true);

        // 6. Promos & Events
        $promos = Cache::get('promos', [
            [
                'id' => 1,
                'title' => 'Amapiano Jazz Night',
                'type' => 'Event / Live Music',
                'start' => now()->toDateString(),
                'end' => now()->addDays(7)->toDateString(),
                'description' => 'Setiap Jumat & Sabtu malam 19:00 - 22:00',
                'status' => 'Aktif',
            ],
            [
                'id' => 2,
                'title' => 'Happy Hour Coffee',
                'type' => 'Diskon',
                'start' => now()->toDateString(),
                'end' => now()->addDays(15)->toDateString(),
                'description' => 'Diskon 20% untuk semua menu minuman.',
                'status' => 'Aktif',
            ],
        ]);

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
            'promos'
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
     * Store a new promo / event.
     */
    public function storePromo(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'description' => 'nullable|string',
        ]);

        $promos = Cache::get('promos', []);
        $newPromo = [
            'id' => count($promos) + 1,
            'title' => $validated['title'],
            'type' => $validated['type'],
            'start' => $validated['start'],
            'end' => $validated['end'],
            'description' => $validated['description'] ?? '',
            'status' => 'Aktif',
        ];

        $promos[] = $newPromo;
        Cache::put('promos', $promos);

        return back()->with('success_promo', 'Promo / Event berhasil dipublikasikan.');
    }

    /**
     * Delete a promo/event by ID.
     */
    public function deletePromo($id): RedirectResponse
    {
        $promos = Cache::get('promos', []);
        $promos = array_filter($promos, function ($p) use ($id) {
            return $p['id'] != $id;
        });
        $promos = array_values($promos);
        Cache::put('promos', $promos);

        return back()->with('success_promo', 'Promo / Event berhasil dihapus.');
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
    public function updateReservationStatus(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,checked_in,cancelled',
        ]);

        $res = Reservation::findOrFail($id);
        $updateData = ['status' => $validated['status']];
        if ($validated['status'] === 'checked_in') {
            // Validate Date & Time
            $today = now()->timezone('Asia/Jakarta')->toDateString();
            if ($res->date !== $today) {
                return back()->with('error_reservation', 'Tidak dapat melakukan check-in: Tanggal reservasi tidak sesuai (harus hari ini).');
            }

            $bookingDateTime = Carbon::parse($res->date.' '.$res->time, 'Asia/Jakarta');
            $now = now()->timezone('Asia/Jakarta');
            if ($now->lt($bookingDateTime)) {
                return back()->with('error_reservation', 'Tidak dapat melakukan check-in: Waktu reservasi belum tiba.');
            }

            $updateData['checked_in_at'] = now();
        }
        $res->update($updateData);

        return back()->with('success_reservation', 'Status reservasi berhasil diperbarui.');
    }
}
