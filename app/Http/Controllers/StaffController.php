<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display the staff dashboard.
     */
    public function index(Request $request)
    {
        $today = today()->toDateString();

        // 1. All reservations from today onwards (including future dates)
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $reservationsQuery = Reservation::where('date', '>=', $today);

        if (! empty($search)) {
            $searchClean = ltrim(strtoupper(trim($search)), '#');
            $reservationsQuery->where(function ($q) use ($search, $searchClean) {
                $q->where('fullname', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$searchClean}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $reservationsQuery->orderBy('date')->orderBy('time');

        if (! empty($statusFilter) && $statusFilter !== 'Semua Status') {
            $statusMap = [
                'Pending' => 'pending',
                'Checked In' => 'checked_in',
                'Cancelled' => 'cancelled',
            ];
            if (isset($statusMap[$statusFilter])) {
                $reservationsQuery->where('status', $statusMap[$statusFilter]);
            }
        }

        $reservations = $reservationsQuery->get();

        // 2. Statistics for today
        $totalToday = Reservation::whereDate('date', $today)->count();
        $checkedInToday = Reservation::whereDate('date', $today)->where('status', 'checked_in')->count();
        $pendingToday = Reservation::whereDate('date', $today)->where('status', 'pending')->count();
        $cancelledToday = Reservation::whereDate('date', $today)->where('status', 'cancelled')->count();

        // 3. Recent check-ins
        $recentCheckins = Reservation::where('status', 'checked_in')
            ->whereDate('date', $today)
            ->latest('checked_in_at')
            ->limit(10)
            ->get();

        // 4. Area occupancy info (for next hour)
        $areas = ['Main Hall', 'Terrace', 'VIP Lounge'];
        $areaOccupancy = [];
        $tableCapacities = [
            'Main Hall' => 8,
            'Terrace' => 10,
            'VIP Lounge' => 7,
        ];
        foreach ($areas as $area) {
            $occupied = Reservation::whereDate('date', $today)
                ->where('area', $area)
                ->where('status', 'checked_in')
                ->distinct('table_id')
                ->count();
            $areaOccupancy[$area] = [
                'occupied' => $occupied,
                'total' => $tableCapacities[$area],
            ];
        }

        // 5. Next hour bookings
        $nextHourBookings = Reservation::whereDate('date', $today)
            ->where('status', 'pending')
            ->whereTime('time', '>=', now()->toTimeString())
            ->orderBy('time')
            ->limit(5)
            ->get();

        return view('admin.staff', compact(
            'reservations',
            'totalToday',
            'checkedInToday',
            'pendingToday',
            'cancelledToday',
            'recentCheckins',
            'areaOccupancy',
            'nextHourBookings'
        ));
    }

    /**
     * AJAX check-in validation.
     */
    public function validateReservation(Request $request)
    {
        $code = strtoupper(trim($request->input('code')));
        $code = ltrim($code, '#');

        if (empty($code)) {
            return response()->json([
                'valid' => false,
                'status' => 'empty',
                'message' => 'Format kode reservasi salah.',
            ]);
        }

        $reservation = Reservation::where('code', $code)
            ->orWhere('code', 'AMP-'.$code)
            ->first();

        if (! $reservation) {
            return response()->json([
                'valid' => false,
                'status' => 'not_found',
                'message' => 'Kode tidak ditemukan. Pastikan pelanggan memberikan kode yang benar.',
            ]);
        }

        if ($reservation->status === 'checked_in') {
            $timeStr = $reservation->checked_in_at ? Carbon::parse($reservation->checked_in_at)->timezone('Asia/Jakarta')->format('H:i') : '-';

            return response()->json([
                'valid' => false,
                'status' => 'used',
                'message' => 'Kode Sudah Digunakan!',
                'checked_in_at' => $timeStr,
            ]);
        }

        if ($reservation->status === 'cancelled') {
            return response()->json([
                'valid' => false,
                'status' => 'cancelled',
                'message' => 'Reservasi ini telah dibatalkan.',
            ]);
        }

        // Validate Date & Time
        $today = now()->timezone('Asia/Jakarta')->toDateString();
        if ($reservation->date !== $today) {
            return response()->json([
                'valid' => false,
                'status' => 'invalid_datetime',
                'message' => 'Tidak dapat melakukan check-in: Tanggal reservasi tidak sesuai (harus hari ini).',
            ]);
        }

        $bookingDateTime = Carbon::parse($reservation->date.' '.$reservation->time, 'Asia/Jakarta');
        $now = now()->timezone('Asia/Jakarta');
        if ($now->lt($bookingDateTime)) {
            return response()->json([
                'valid' => false,
                'status' => 'invalid_datetime',
                'message' => 'Tidak dapat melakukan check-in: Waktu reservasi belum tiba.',
            ]);
        }

        // Check if user is late (more than 15 minutes past scheduled time)
        $late = false;

        if ($now->greaterThan($bookingDateTime->copy()->addMinutes(15))) {
            $late = true;
        }

        $tableNames = [
            'hb-1' => 'Table HB-1', 'hb-2' => 'Table HB-2', 'hb-3' => 'Table HB-3', 'hb-4' => 'Table HB-4', 'hb-5' => 'Table HB-5', 'hb-6' => 'Table HB-6', 'hb-7' => 'Table HB-7', 'hb-8' => 'Table HB-8',
            'cg-1' => 'Table CG-1', 'cg-2' => 'Table CG-2', 'cg-3' => 'Table CG-3', 'cg-4' => 'Table CG-4', 'cg-5' => 'Table CG-5', 'cg-6' => 'Table CG-6', 'cg-7' => 'Table CG-7', 'cg-8' => 'Table CG-8', 'cg-9' => 'Table CG-9', 'cg-10' => 'Table CG-10',
            'lb-1' => 'Table LB-1', 'lb-2' => 'Table LB-2', 'lb-3' => 'Table LB-3', 'lb-4' => 'Table LB-4', 'lb-5' => 'Table LB-5', 'lb-6' => 'Table LB-6', 'lb-7' => 'Table LB-7',
        ];

        return response()->json([
            'valid' => true,
            'status' => 'pending',
            'late' => $late,
            'reservation' => [
                'code' => $reservation->code,
                'fullname' => $reservation->fullname,
                'phone' => $reservation->phone,
                'datetime' => Carbon::parse($reservation->date)->translatedFormat('d M Y').', '.$reservation->time,
                'location' => $reservation->area.' / '.($tableNames[$reservation->table_id] ?? $reservation->table_id),
            ],
        ]);
    }

    /**
     * Confirm / Process check-in.
     */
    public function checkIn(Request $request)
    {
        $code = strtoupper(trim($request->input('code')));
        $code = ltrim($code, '#');

        $reservation = Reservation::where('code', $code)
            ->orWhere('code', 'AMP-'.$code)
            ->firstOrFail();

        if ($reservation->status === 'checked_in') {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi ini sudah di-check-in sebelumnya.',
            ]);
        }

        // Validate Date & Time
        $today = now()->timezone('Asia/Jakarta')->toDateString();
        if ($reservation->date !== $today) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat melakukan check-in: Tanggal reservasi tidak sesuai (harus hari ini).',
            ]);
        }

        $bookingDateTime = Carbon::parse($reservation->date.' '.$reservation->time, 'Asia/Jakarta');
        $now = now()->timezone('Asia/Jakarta');
        if ($now->lt($bookingDateTime)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat melakukan check-in: Waktu reservasi belum tiba.',
            ]);
        }

        $reservation->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
        ]);

        $initials = '';
        $words = explode(' ', $reservation->fullname);
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        $initials = substr($initials, 0, 2);

        $tableNames = [
            'hb-1' => 'Table HB-1', 'hb-2' => 'Table HB-2', 'hb-3' => 'Table HB-3', 'hb-4' => 'Table HB-4', 'hb-5' => 'Table HB-5', 'hb-6' => 'Table HB-6', 'hb-7' => 'Table HB-7', 'hb-8' => 'Table HB-8',
            'cg-1' => 'Table CG-1', 'cg-2' => 'Table CG-2', 'cg-3' => 'Table CG-3', 'cg-4' => 'Table CG-4', 'cg-5' => 'Table CG-5', 'cg-6' => 'Table CG-6', 'cg-7' => 'Table CG-7', 'cg-8' => 'Table CG-8', 'cg-9' => 'Table CG-9', 'cg-10' => 'Table CG-10',
            'lb-1' => 'Table LB-1', 'lb-2' => 'Table LB-2', 'lb-3' => 'Table LB-3', 'lb-4' => 'Table LB-4', 'lb-5' => 'Table LB-5', 'lb-6' => 'Table LB-6', 'lb-7' => 'Table LB-7',
        ];

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil dikonfirmasi.',
            'reservation' => [
                'fullname' => $reservation->fullname,
                'initials' => $initials,
                'location' => $reservation->area.' / '.($tableNames[$reservation->table_id] ?? $reservation->table_id),
                'time' => now()->timezone('Asia/Jakarta')->format('H:i'),
            ],
        ]);
    }
}
