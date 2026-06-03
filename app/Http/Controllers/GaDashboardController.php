<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\VehicleBooking;
use App\Models\GuestVisit;
use App\Models\MasterRoom;
use App\Models\MasterVehicle;

class GaDashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $summary = [
            'room_today' => RoomBooking::whereDate('booking_date', $today)
                ->whereIn('status', ['pending', 'approved'])
                ->count(),

            'vehicle_today' => VehicleBooking::whereDate('departure_datetime', $today)
                ->whereIn('status', ['pending', 'approved', 'on_trip'])
                ->count(),

            'guest_active' => GuestVisit::where('status', 'checked_in')->count(),

            'room_pending' => RoomBooking::where('status', 'pending')->count(),

            'vehicle_pending' => VehicleBooking::where('status', 'pending')->count(),

            'vehicle_on_trip' => VehicleBooking::where('status', 'on_trip')->count(),

            'total_rooms' => MasterRoom::where('is_active', true)->count(),

            'total_vehicles' => MasterVehicle::where('is_active', true)->count(),
        ];

        $roomBookingsToday = RoomBooking::with(['room', 'user'])
            ->whereDate('booking_date', $today)
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('start_time')
            ->limit(8)
            ->get();

        $vehicleBookingsToday = VehicleBooking::with(['vehicle', 'user'])
            ->whereDate('departure_datetime', $today)
            ->whereIn('status', ['pending', 'approved', 'on_trip'])
            ->orderBy('departure_datetime')
            ->limit(8)
            ->get();

        $activeGuests = GuestVisit::where('status', 'checked_in')
            ->latest('checkin_at')
            ->limit(8)
            ->get();

        $pendingRooms = RoomBooking::with('room')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $pendingVehicles = VehicleBooking::with('vehicle')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('ga.dashboard', compact(
            'summary',
            'roomBookingsToday',
            'vehicleBookingsToday',
            'activeGuests',
            'pendingRooms',
            'pendingVehicles'
        ));
    }
}