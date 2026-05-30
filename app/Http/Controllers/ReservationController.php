<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Store a newly created reservation in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        // 1. Static table configurations for server-side validation (matching the frontend rooms)
        $tableCapacities = [
            'hb-1' => 2, 'hb-2' => 4, 'hb-3' => 4, 'hb-4' => 6, 'hb-5' => 2, 'hb-6' => 4, 'hb-7' => 4, 'hb-8' => 6,
            'cg-1' => 2, 'cg-2' => 4, 'cg-3' => 4, 'cg-4' => 6, 'cg-5' => 2, 'cg-6' => 4, 'cg-7' => 4, 'cg-8' => 6, 'cg-9' => 4, 'cg-10' => 8,
            'lb-1' => 2, 'lb-2' => 4, 'lb-3' => 4, 'lb-4' => 2, 'lb-5' => 6, 'lb-6' => 4, 'lb-7' => 4
        ];

        $tableNames = [
            'hb-1' => 'Table HB-1', 'hb-2' => 'Table HB-2', 'hb-3' => 'Table HB-3', 'hb-4' => 'Table HB-4', 'hb-5' => 'Table HB-5', 'hb-6' => 'Table HB-6', 'hb-7' => 'Table HB-7', 'hb-8' => 'Table HB-8',
            'cg-1' => 'Table CG-1', 'cg-2' => 'Table CG-2', 'cg-3' => 'Table CG-3', 'cg-4' => 'Table CG-4', 'cg-5' => 'Table CG-5', 'cg-6' => 'Table CG-6', 'cg-7' => 'Table CG-7', 'cg-8' => 'Table CG-8', 'cg-9' => 'Table CG-9', 'cg-10' => 'Table CG-10',
            'lb-1' => 'Table LB-1', 'lb-2' => 'Table LB-2', 'lb-3' => 'Table LB-3', 'lb-4' => 'Table LB-4', 'lb-5' => 'Table LB-5', 'lb-6' => 'Table LB-6', 'lb-7' => 'Table LB-7'
        ];

        // Verify cafe operational status
        if (!\Illuminate\Support\Facades\Cache::get('store_open', true)) {
            $errorMsg = 'Reservasi online saat ini sedang ditutup.';
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 422);
            }
            return back()->withErrors(['store' => $errorMsg])->withInput();
        }

        // 2. Validate standard request inputs
        $validated = $request->validate([
            'fullname' => 'required|string|min:2|max:255',
            'phone' => 'required|string|min:5|max:50',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string|in:10:00,11:00,12:00,13:00,14:00,15:00,16:00,17:00,18:00,19:00',
            'area' => 'required|string|in:Main Hall,Terrace,VIP Lounge',
            'table_id' => 'required|string',
            'guests' => 'required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $tableId = strtolower($validated['table_id']);
        $guests = (int) $validated['guests'];

        // 3. Verify table exists and capacity constraint
        if (!array_key_exists($tableId, $tableCapacities)) {
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

        // 4. Verify table is not already booked for the date and time slot
        $isBooked = Reservation::where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->where('area', $validated['area'])
            ->where('table_id', $tableId)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($isBooked) {
            $errorMsg = 'This table has already been reserved for the selected date and time.';
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

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'reservation' => $successData
            ]);
        }

        return redirect()->back()->with('success', $successData);
    }

    /**
     * Get a list of booked table IDs for a date and time slot.
     */
    public function booked(Request $request): \Illuminate\Http\JsonResponse
    {
        $date = $request->input('date');
        $time = $request->input('time');

        if (empty($date) || empty($time)) {
            return response()->json([]);
        }

        $bookedTableIds = Reservation::where('date', $date)
            ->where('time', $time)
            ->where('status', '!=', 'cancelled')
            ->pluck('table_id')
            ->toArray();

        $bookedTableIds = array_map('strtolower', $bookedTableIds);

        return response()->json($bookedTableIds);
    }
}
