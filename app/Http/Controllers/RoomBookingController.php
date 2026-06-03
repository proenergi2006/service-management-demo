<?php

namespace App\Http\Controllers;

use App\Models\MasterRoom;
use App\Models\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomBookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', '');
        $date = $request->get('date', '');
        $roomId = $request->get('room_id', '');

        $query = RoomBooking::with(['room', 'user', 'approver'])->latest();

        if ($status !== '') {
            $query->where('status', $status);
        }

        if ($date !== '') {
            $query->whereDate('booking_date', $date);
        }

        if ($roomId !== '') {
            $query->where('room_id', $roomId);
        }

        $bookings = $query->paginate(10)->withQueryString();
        $rooms = MasterRoom::where('is_active', true)->orderBy('room_name')->get();

        return view('facility.room-bookings.index', compact('bookings', 'rooms', 'status', 'date', 'roomId'));
    }

    public function myBookings(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);
        $roomId = $request->get('room_id', '');
        $cabang = $request->get('cabang', '');
    
        $startDate = now()->setDate($year, $month, 1)->startOfMonth()->toDateString();
        $endDate = now()->setDate($year, $month, 1)->endOfMonth()->toDateString();
    
        $calendarBookings = RoomBooking::with(['room', 'user'])
            ->whereBetween('booking_date', [$startDate, $endDate])
            ->whereIn('status', ['pending', 'approved']);
    
        if ($roomId !== '') {
            $calendarBookings->where('room_id', $roomId);
        }
    
        if ($cabang !== '') {
            $calendarBookings->whereHas('room', function ($q) use ($cabang) {
                $q->where('location', $cabang);
            });
        }
    
        $calendarBookings = $calendarBookings
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();
    
        $bookings = RoomBooking::with('room')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10)
            ->withQueryString();
    
        $rooms = MasterRoom::where('is_active', true)->orderBy('room_name')->get();
    
        $cabangs = MasterRoom::where('is_active', true)
            ->whereNotNull('location')
            ->select('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');
    
        return view('facility.room-bookings.my', compact(
            'bookings',
            'calendarBookings',
            'month',
            'year',
            'rooms',
            'roomId',
            'cabangs',
            'cabang'
        ));
    }
    public function create()
    {
        $rooms = MasterRoom::where('is_active', true)->orderBy('room_name')->get();

        return view('facility.room-bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:master_rooms,id',
            'title' => 'required|string|max:200',
            'purpose' => 'nullable|string',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'participant_count' => 'nullable|integer|min:1',
            'additional_facilities' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $isConflict = RoomBooking::where('room_id', $validated['room_id'])
            ->whereDate('booking_date', $validated['booking_date'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($validated) {
                $q->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time']);
            })
            ->exists();

        if ($isConflict) {
            return back()
                ->withInput()
                ->with('error', 'Ruangan sudah dibooking pada tanggal dan jam tersebut.');
        }

        DB::transaction(function () use ($validated) {
            RoomBooking::create([
                ...$validated,
                'booking_number' => $this->generateBookingNumber('ROOM'),
                'user_id' => auth()->id(),
                'requester_name' => auth()->user()->name ?? null,
                'requester_email' => auth()->user()->email ?? null,
                'department' => auth()->user()->department ?? null,
                'status' => 'pending',
                'created_by' => auth()->user()->name ?? 'system',
                'updated_by' => auth()->user()->name ?? 'system',
            ]);
        });

        return redirect()
            ->route('room-bookings.my')
            ->with('success', 'Booking ruangan berhasil dibuat dan menunggu approval.');
    }

    public function show(RoomBooking $room_booking)
    {
        $room_booking->load(['room', 'user', 'approver']);

        return view('facility.room-bookings.show', ['booking' => $room_booking]);
    }

    public function edit(RoomBooking $room_booking)
    {
        if ($room_booking->user_id !== auth()->id() || $room_booking->status !== 'pending') {
            abort(403);
        }

        $rooms = MasterRoom::where('is_active', true)->orderBy('room_name')->get();

        return view('facility.room-bookings.edit', [
            'booking' => $room_booking,
            'rooms' => $rooms,
        ]);
    }

    public function update(Request $request, RoomBooking $room_booking)
    {
        if ($room_booking->user_id !== auth()->id() || $room_booking->status !== 'pending') {
            abort(403);
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:master_rooms,id',
            'title' => 'required|string|max:200',
            'purpose' => 'nullable|string',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'participant_count' => 'nullable|integer|min:1',
            'additional_facilities' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $isConflict = RoomBooking::where('id', '!=', $room_booking->id)
            ->where('room_id', $validated['room_id'])
            ->whereDate('booking_date', $validated['booking_date'])
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($validated) {
                $q->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time']);
            })
            ->exists();

        if ($isConflict) {
            return back()
                ->withInput()
                ->with('error', 'Ruangan sudah dibooking pada tanggal dan jam tersebut.');
        }

        $room_booking->update([
            ...$validated,
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return redirect()
            ->route('room-bookings.my')
            ->with('success', 'Booking ruangan berhasil diperbarui.');
    }

    public function destroy(RoomBooking $room_booking)
    {
        if ($room_booking->user_id !== auth()->id() && auth()->user()->role !== 'it') {
            abort(403);
        }

        $room_booking->update([
            'status' => 'cancelled',
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
            'cancel_reason' => 'Cancelled by user',
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return back()->with('success', 'Booking ruangan berhasil dibatalkan.');
    }

    public function approve(RoomBooking $room_booking)
    {
        $room_booking->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_note' => request('approval_note'),
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return back()->with('success', 'Booking ruangan disetujui.');
    }

    public function reject(RoomBooking $room_booking)
    {
        $room_booking->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'approval_note' => request('approval_note'),
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return back()->with('success', 'Booking ruangan ditolak.');
    }

    private function generateBookingNumber(string $prefix): string
    {
        $date = now()->format('Ymd');
        $count = RoomBooking::whereDate('created_at', now())->count() + 1;

        return $prefix . '-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}