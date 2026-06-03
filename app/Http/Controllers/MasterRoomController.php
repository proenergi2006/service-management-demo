<?php

namespace App\Http\Controllers;

use App\Models\MasterRoom;
use Illuminate\Http\Request;

class MasterRoomController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));
        $status = $request->get('status', '');

        $query = MasterRoom::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('room_code', 'like', "%{$search}%")
                    ->orWhere('room_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('floor', 'like', "%{$search}%");
            });
        }

        if ($status !== '') {
            $query->where('is_active', $status === 'active');
        }

        $rooms = $query->latest()->paginate(10)->withQueryString();

        return view('facility.master-rooms.index', compact('rooms', 'search', 'status'));
    }

    public function create()
    {
        return view('facility.master-rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_code' => 'required|string|max:50|unique:master_rooms,room_code',
            'room_name' => 'required|string|max:150',
            'location' => 'nullable|string|max:150',
            'floor' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:1',
            'facilities' => 'nullable|array',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        MasterRoom::create([
            ...$validated,
            'facilities' => $validated['facilities'] ?? [],
            'is_active' => $request->boolean('is_active'),
            'created_by' => auth()->user()->name ?? 'system',
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return redirect()
            ->route('master-rooms.index')
            ->with('success', 'Master ruangan berhasil ditambahkan.');
    }

    public function show(MasterRoom $master_room)
    {
        $master_room->load('bookings');

        return view('facility.master-rooms.show', [
            'room' => $master_room,
        ]);
    }

    public function edit(MasterRoom $master_room)
    {
        return view('facility.master-rooms.edit', [
            'room' => $master_room,
        ]);
    }

    public function update(Request $request, MasterRoom $master_room)
    {
        $validated = $request->validate([
            'room_code' => 'required|string|max:50|unique:master_rooms,room_code,' . $master_room->id,
            'room_name' => 'required|string|max:150',
            'location' => 'nullable|string|max:150',
            'floor' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:1',
            'facilities' => 'nullable|array',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $master_room->update([
            ...$validated,
            'facilities' => $validated['facilities'] ?? [],
            'is_active' => $request->boolean('is_active'),
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return redirect()
            ->route('master-rooms.index')
            ->with('success', 'Master ruangan berhasil diperbarui.');
    }

    public function destroy(MasterRoom $master_room)
    {
        if ($master_room->bookings()->exists()) {
            return back()->with('error', 'Ruangan tidak bisa dihapus karena sudah memiliki data booking.');
        }

        $master_room->delete();

        return back()->with('success', 'Master ruangan berhasil dihapus.');
    }
}