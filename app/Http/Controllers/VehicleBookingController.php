<?php

namespace App\Http\Controllers;

use App\Models\MasterVehicle;
use App\Models\VehicleBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', '');
        $vehicleId = $request->get('vehicle_id', '');

        $query = VehicleBooking::with(['vehicle', 'user', 'approver'])->latest();

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($vehicleId !== '') {
            $query->where('vehicle_id', $vehicleId);
        }

        $bookings = $query->paginate(10)->withQueryString();
        $vehicles = MasterVehicle::where('is_active', true)->orderBy('plate_number')->get();

        return view('facility.vehicle-bookings.index', compact('bookings', 'vehicles', 'status', 'vehicleId'));
    }

    public function myBookings(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);
        $status = $request->get('status', '');
    
        $bookings = VehicleBooking::with('vehicle')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
    
        $calendarBookings = VehicleBooking::with('vehicle')
            ->whereYear('departure_datetime', $year)
            ->whereMonth('departure_datetime', $month)
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->orderBy('departure_datetime')
            ->get();
    
        return view('facility.vehicle-bookings.my', compact(
            'bookings',
            'calendarBookings',
            'month',
            'year',
            'status'
        ));
    }

    public function create()
    {
        $vehicles = MasterVehicle::where('is_active', true)
            ->whereIn('vehicle_status', ['available', 'booked'])
            ->orderBy('plate_number')
            ->get();

        return view('facility.vehicle-bookings.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'nullable|exists:master_vehicles,id',
            'destination' => 'required|string|max:255',
            'purpose' => 'nullable|string',
            'driver_source' => 'required|in:internal,vendor,self_drive',
            'driver_name' => 'nullable|string|max:150',
            'driver_phone' => 'nullable|string|max:50',
            'departure_datetime' => 'required|date',
            'return_datetime' => 'nullable|date|after:departure_datetime',
            'passenger_count' => 'nullable|integer|min:1',
            'passenger_names' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if (!empty($validated['vehicle_id']) && !empty($validated['return_datetime'])) {
            $isConflict = VehicleBooking::where('vehicle_id', $validated['vehicle_id'])
                ->whereIn('status', ['pending', 'approved', 'on_trip'])
                ->where(function ($q) use ($validated) {
                    $q->where('departure_datetime', '<', $validated['return_datetime'])
                        ->where('return_datetime', '>', $validated['departure_datetime']);
                })
                ->exists();

            if ($isConflict) {
                return back()
                    ->withInput()
                    ->with('error', 'Kendaraan sudah dibooking pada rentang waktu tersebut.');
            }
        }

        DB::transaction(function () use ($validated) {
            VehicleBooking::create([
                ...$validated,
                'booking_number' => $this->generateBookingNumber('VEH'),
                'user_id' => auth()->id(),
                'requester_name' => auth()->user()->name ?? null,
                'requester_email' => auth()->user()->email ?? null,
                'department' => auth()->user()->department ?? null,
                'branch' => auth()->user()->branch ?? null,
                'status' => 'pending',
                'created_by' => auth()->user()->name ?? 'system',
                'updated_by' => auth()->user()->name ?? 'system',
            ]);
        });

        return redirect()
            ->route('vehicle-bookings.my')
            ->with('success', 'Booking kendaraan berhasil dibuat dan menunggu approval.');
    }

    public function show(VehicleBooking $vehicle_booking)
    {
        $vehicle_booking->load(['vehicle', 'user', 'approver']);

        return view('facility.vehicle-bookings.show', ['booking' => $vehicle_booking]);
    }

    public function approve(Request $request, VehicleBooking $vehicle_booking)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:master_vehicles,id',
            'approval_note' => 'nullable|string',
        ]);
    
        if (!$vehicle_booking->return_datetime) {
            return back()->with('error', 'Estimasi waktu kembali wajib diisi sebelum approval.');
        }
    
        $isConflict = VehicleBooking::where('id', '!=', $vehicle_booking->id)
            ->where('vehicle_id', $validated['vehicle_id'])
            ->whereIn('status', ['pending', 'approved', 'on_trip'])
            ->where(function ($q) use ($vehicle_booking) {
                $q->where('departure_datetime', '<', $vehicle_booking->return_datetime)
                    ->where('return_datetime', '>', $vehicle_booking->departure_datetime);
            })
            ->exists();
    
        if ($isConflict) {
            return back()->with('error', 'Kendaraan tersebut sudah digunakan pada rentang waktu booking ini.');
        }
    
        $vehicle_booking->update([
            'vehicle_id' => $validated['vehicle_id'],
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_note' => $validated['approval_note'] ?? null,
            'updated_by' => auth()->user()->name ?? 'system',
        ]);
    
        $vehicle_booking->vehicle?->update([
            'vehicle_status' => 'booked',
        ]);
    
        return back()->with('success', 'Booking kendaraan disetujui dan kendaraan berhasil di-assign.');
    }

    public function reject(VehicleBooking $vehicle_booking)
    {
        $vehicle_booking->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_note' => request('approval_note'),
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return back()->with('success', 'Booking kendaraan ditolak.');
    }

    public function startTrip(VehicleBooking $vehicle_booking)
    {
        $vehicle_booking->update([
            'status' => 'on_trip',
            'actual_departure_at' => now(),
            'start_odometer' => request('start_odometer'),
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        if ($vehicle_booking->vehicle) {
            $vehicle_booking->vehicle->update(['vehicle_status' => 'on_trip']);
        }

        return back()->with('success', 'Trip dimulai.');
    }

    public function returnTrip(VehicleBooking $vehicle_booking)
    {
        $vehicle_booking->update([
            'status' => 'returned',
            'actual_return_at' => now(),
            'end_odometer' => request('end_odometer'),
            'fuel_cost' => request('fuel_cost'),
            'parking_cost' => request('parking_cost'),
            'toll_cost' => request('toll_cost'),
            'other_cost' => request('other_cost'),
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        if ($vehicle_booking->vehicle) {
            $vehicle_booking->vehicle->update(['vehicle_status' => 'available']);
        }

        return back()->with('success', 'Kendaraan sudah kembali.');
    }

    public function destroy(VehicleBooking $vehicle_booking)
    {
        if ($vehicle_booking->user_id !== auth()->id() && auth()->user()->role !== 'it') {
            abort(403);
        }

        $vehicle_booking->update([
            'status' => 'cancelled',
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
            'cancel_reason' => 'Cancelled by user',
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return back()->with('success', 'Booking kendaraan berhasil dibatalkan.');
    }

    private function generateBookingNumber(string $prefix): string
    {
        $date = now()->format('Ymd');
        $count = VehicleBooking::whereDate('created_at', now())->count() + 1;

        return $prefix . '-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function edit(VehicleBooking $vehicle_booking)
{
    if ($vehicle_booking->user_id !== auth()->id() || $vehicle_booking->status !== 'pending') {
        abort(403);
    }

    $vehicles = MasterVehicle::where('is_active', true)
        ->whereIn('vehicle_status', ['available', 'booked'])
        ->orderBy('plate_number')
        ->get();

    return view('facility.vehicle-bookings.edit', [
        'booking' => $vehicle_booking,
        'vehicles' => $vehicles,
    ]);
}

public function update(Request $request, VehicleBooking $vehicle_booking)
{
    if ($vehicle_booking->user_id !== auth()->id() || $vehicle_booking->status !== 'pending') {
        abort(403);
    }

    $validated = $request->validate([
        'vehicle_id' => 'nullable|exists:master_vehicles,id',
        'destination' => 'required|string|max:255',
        'purpose' => 'nullable|string',
        'driver_source' => 'required|in:internal,vendor,self_drive',
        'driver_name' => 'nullable|string|max:150',
        'driver_phone' => 'nullable|string|max:50',
        'departure_datetime' => 'required|date',
        'return_datetime' => 'nullable|date|after:departure_datetime',
        'passenger_count' => 'nullable|integer|min:1',
        'passenger_names' => 'nullable|string',
        'notes' => 'nullable|string',
    ]);

    if (!empty($validated['vehicle_id']) && !empty($validated['return_datetime'])) {
        $isConflict = VehicleBooking::where('id', '!=', $vehicle_booking->id)
            ->where('vehicle_id', $validated['vehicle_id'])
            ->whereIn('status', ['pending', 'approved', 'on_trip'])
            ->where(function ($q) use ($validated) {
                $q->where('departure_datetime', '<', $validated['return_datetime'])
                    ->where('return_datetime', '>', $validated['departure_datetime']);
            })
            ->exists();

        if ($isConflict) {
            return back()
                ->withInput()
                ->with('error', 'Kendaraan sudah dibooking pada rentang waktu tersebut.');
        }
    }

    $vehicle_booking->update([
        ...$validated,
        'updated_by' => auth()->user()->name ?? 'system',
    ]);

    return redirect()
        ->route('vehicle-bookings.my')
        ->with('success', 'Booking kendaraan berhasil diperbarui.');
}

public function cancel(VehicleBooking $vehicleBooking)
{
    if ($vehicleBooking->user_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses untuk membatalkan booking ini.');
    }

    if ($vehicleBooking->status !== 'pending') {
        return back()->with('error', 'Booking tidak dapat dibatalkan karena status sudah berubah.');
    }

    $vehicleBooking->update([
        'status' => 'cancelled',
        'cancelled_at' => now(),
        'cancelled_by' => auth()->id(),
    ]);

    return back()->with('success', 'Booking kendaraan berhasil dibatalkan.');
}
}