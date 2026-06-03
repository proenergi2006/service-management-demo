<?php

namespace App\Http\Controllers;

use App\Models\MasterVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterVehicleController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->get('search', ''));
        $status = $request->get('vehicle_status', '');
        $branch = $request->get('branch', '');

        $query = MasterVehicle::query()->latest();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('vehicle_code', 'like', "%{$search}%")
                    ->orWhere('plate_number', 'like', "%{$search}%")
                    ->orWhere('vehicle_name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($status !== '') {
            $query->where('vehicle_status', $status);
        }

        if ($branch !== '') {
            $query->where('branch', $branch);
        }

        $vehicles = $query->paginate(10)->withQueryString();

        $branches = MasterVehicle::whereNotNull('branch')
            ->select('branch')
            ->distinct()
            ->orderBy('branch')
            ->pluck('branch');

        return view('facility.master-vehicles.index', compact(
            'vehicles',
            'branches',
            'search',
            'status',
            'branch'
        ));
    }

    public function create()
    {
        return view('facility.master-vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_code' => 'required|string|max:50|unique:master_vehicles,vehicle_code',
            'plate_number' => 'required|string|max:30|unique:master_vehicles,plate_number',
            'vehicle_name' => 'required|string|max:150',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'ownership_status' => 'nullable|string|max:50',
            'branch' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'vehicle_status' => 'required|in:available,booked,maintenance,inactive',
            'stnk_expired_date' => 'nullable|date',
            'kir_expired_date' => 'nullable|date',
            'insurance_expired_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated) {
            MasterVehicle::create([
                ...$validated,
                'is_active' => request()->boolean('is_active', true),
                'created_by' => auth()->user()->name ?? 'system',
                'updated_by' => auth()->user()->name ?? 'system',
            ]);
        });

        return redirect()
            ->route('master-vehicles.index')
            ->with('success', 'Master kendaraan berhasil ditambahkan.');
    }

    public function show(MasterVehicle $master_vehicle)
    {
        return redirect()->route('master-vehicles.edit', $master_vehicle);
    }

    public function edit(MasterVehicle $master_vehicle)
    {
        return view('facility.master-vehicles.edit', [
            'vehicle' => $master_vehicle,
        ]);
    }

    public function update(Request $request, MasterVehicle $master_vehicle)
    {
        $validated = $request->validate([
            'vehicle_code' => 'required|string|max:50|unique:master_vehicles,vehicle_code,' . $master_vehicle->id,
            'plate_number' => 'required|string|max:30|unique:master_vehicles,plate_number,' . $master_vehicle->id,
            'vehicle_name' => 'required|string|max:150',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            'capacity' => 'nullable|integer|min:1',
            'ownership_status' => 'nullable|string|max:50',
            'branch' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:150',
            'vehicle_status' => 'required|in:available,booked,maintenance,inactive',
            'stnk_expired_date' => 'nullable|date',
            'kir_expired_date' => 'nullable|date',
            'insurance_expired_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $master_vehicle->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return redirect()
            ->route('master-vehicles.index')
            ->with('success', 'Master kendaraan berhasil diperbarui.');
    }

    public function destroy(MasterVehicle $master_vehicle)
    {
        $master_vehicle->update([
            'is_active' => false,
            'vehicle_status' => 'inactive',
            'updated_by' => auth()->user()->name ?? 'system',
        ]);

        return back()->with('success', 'Master kendaraan berhasil dinonaktifkan.');
    }
}