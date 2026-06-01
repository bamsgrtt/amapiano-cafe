<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\StoreOperationalDate;
use Illuminate\Support\Facades\Cache;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    /**
     * Store a newly created reservation in the database.
     *
     * @return RedirectResponse
     */
    public function store(Request $request): Response
    {
        // 1. Static table configurations for server-side validation (matching the frontend rooms)
        $tableCapacities = [
            'hb-1' => 2, 'hb-2' => 4, 'hb-3' => 4, 'hb-4' => 6, 'hb-5' => 2, 'hb-6' => 4, 'hb-7' => 4, 'hb-8' => 6,
            'cg-1' => 2, 'cg-2' => 4, 'cg-3' => 4, 'cg-4' => 6, 'cg-5' => 2, 'cg-6' => 4, 'cg-7' => 4, 'cg-8' => 6, 'cg-9' => 4, 'cg-10' => 8,
            'lb-1' => 2, 'lb-2' => 4, 'lb-3' => 4, 'lb-4' => 2, 'lb-5' => 6, 'lb-6' => 4, 'lb-7' => 4,
        ];

        $tableNames = [
            'hb-1' => 'Table HB-1', 'hb-2' => 'Table HB-2', 'hb-3' => 'Table HB-3', 'hb-4' => 'Table HB-4', 'hb-5' => 'Table HB-5', 'hb-6' => 'Table HB-6', 'hb-7' => 'Table HB-7', 'hb-8' => 'Table HB-8',
            'cg-1' => 'Table CG-1', 'cg-2' => 'Table CG-2', 'cg-3' => 'Table CG-3', 'cg-4' => 'Table CG-4', 'cg-5' => 'Table CG-5', 'cg-6' => 'Table CG-6', 'cg-7' => 'Table CG-7', 'cg-8' => 'Table CG-8', 'cg-9' => 'Table CG-9', 'cg-10' => 'Table CG-10',
            'lb-1' => 'Table LB-1', 'lb-2' => 'Table LB-2', 'lb-3' => 'Table LB-3', 'lb-4' => 'Table LB-4', 'lb-5' => 'Table LB-5', 'lb-6' => 'Table LB-6', 'lb-7' => 'Table LB-7',
        ];

        // 2. Validate standard request inputs
        $validated = $request->validate([
            'fullname' => 'required|string|min:2|max:255',
            'phone' => 'required|string|min:5|max:50',
            'date' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:'.now()->addDays(7)->toDateString()],
            'time' => 'required|string|in:10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00,18:00,19:00',
            'area' => 'required|string|in:Main Hall,Terrace,VIP Lounge',
            'table_id' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $schedule = StoreOperationalDate::where('date', $validated['date'])->first();
        if ($schedule !== null && ! $schedule->is_open) {
            $errorMsg = 'Reservasi untuk tanggal tersebut ditutup oleh pengelola.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 422);
            }

            return back()->withErrors(['store' => $errorMsg])->withInput();
        }

        $tableId = strtolower($validated['table_id']);
        $guests = (int) $validated['guests'];

        // 3. Verify table exists and capacity constraint
        if (! array_key_exists($tableId, $tableCapacities)) {
            $errorMsg = 'The selected table code is invalid.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 422);
            }

            return back()->withErrors(['table_id' => $errorMsg])->withInput();
        }

        $maxCapacity = $tableCapacities[$tableId];
        if ($guests > $maxCapacity) {
            $errorMsg = "The selected table ({$tableNames[$tableId]}) holds a maximum of {$maxCapacity} guests.";
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 422);
            }

            return back()->withErrors(['guests' => $errorMsg])->withInput();
        }

        // 4. Verify table is not already booked for the date and time slot (2-hour duration check)
        $requestedMinutes = $this->timeToMinutes($validated['time']);

        $reservations = Reservation::where('date', $validated['date'])
            ->where('table_id', $tableId)
            ->where('status', '!=', 'cancelled')
            ->get();

        $isBooked = false;
        foreach ($reservations as $res) {
            $resMinutes = $this->timeToMinutes($res->time);
            if (abs($requestedMinutes - $resMinutes) < 120) {
                $isBooked = true;
                break;
            }
        }

        if ($isBooked) {
            $errorMsg = 'Meja ini sudah dipesan untuk jadwal tersebut (durasi per reservasi adalah 2 jam).';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 422);
            }

            return back()->withErrors(['table_id' => $errorMsg])->withInput();
        }

        // Normalize table ID to lowercase for DB consistency
        $validated['table_id'] = $tableId;

        // 5. Create reservation record
        $reservation = Reservation::create($validated);

        // 6. Redirect or return JSON response
        $successData = $reservation->toArray();
        $successData['table_name'] = $tableNames[$tableId];

        // Generate QR Code on the server using SimpleQRCode
        $qrSvg = QrCode::size(150)->generate($reservation->code);
        $successData['qr_code'] = base64_encode($qrSvg);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'reservation' => $successData,
            ]);
        }

        return redirect()->back()->with('success', $successData);
    }

    /**
     * Get a list of booked table IDs for a date and time slot.
     */
    public function booked(Request $request): JsonResponse
    {
        $date = $request->input('date');
        $time = $request->input('time');

        if (empty($date) || empty($time)) {
            return response()->json([]);
        }

        $requestedMinutes = $this->timeToMinutes($time);

        $reservations = Reservation::where('date', $date)
            ->where('status', '!=', 'cancelled')
            ->get();

        $bookedTableIds = [];
        foreach ($reservations as $res) {
            $resMinutes = $this->timeToMinutes($res->time);
            if (abs($requestedMinutes - $resMinutes) < 120) {
                $bookedTableIds[] = strtolower($res->table_id);
            }
        }

        $bookedTableIds = array_values(array_unique($bookedTableIds));

        return response()->json($bookedTableIds);
    }

    /**
     * Download the reservation ticket as PDF.
     */
    public function download(string $code): Response
    {
        $reservation = Reservation::where('code', $code)->firstOrFail();

        $pdf = Pdf::loadView('pdf.reservation_ticket', compact('reservation'));

        return $pdf->download("Amapiano-Ticket-{$reservation->code}.pdf");
    }

    /**
     * Convert time string (H:i) to minutes since midnight.
     */
    private function timeToMinutes(string $time): int
    {
        [$hours, $minutes] = explode(':', $time);

        return ((int) $hours) * 60 + ((int) $minutes);
    }
}
