<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Exports\AssetsExport;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $userRole = strtoupper(auth()->user()->role ?? '');
    
        $query = Asset::with([
            'category',
            'location',
            'activeAssignment.user',
            'documents',
        ]);
    
        if (in_array($userRole, ['IT', 'GA', 'LOGISTIK'])) {
            $query->where('owner_role', $userRole);
        }
    
        if ($request->filled('search')) {
            $search = trim($request->search);
    
            $query->where(function ($q) use ($search) {
                $q->where('asset_code', 'like', "%{$search}%")
                    ->orWhere('asset_name', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }
    
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }
    
        if ($request->filled('lifecycle_status')) {
            $query->where('lifecycle_status', $request->lifecycle_status);
        }
    
        if ($request->filled('condition_status')) {
            $query->where('condition_status', $request->condition_status);
        }
    
        $assets = $query->latest()->paginate(10)->withQueryString();
    
        $categories = AssetCategory::where('is_active', true)->orderBy('name')->get();
        $locations = AssetLocation::where('is_active', true)->orderBy('name')->get();
    
        $summary = [
            'total' => (clone $query)->count(),
            'assigned' => (clone $query)->where('lifecycle_status', 'assigned')->count(),
            'maintenance' => (clone $query)->where('lifecycle_status', 'maintenance')->count(),
            'disposed_lost' => (clone $query)->whereIn('lifecycle_status', ['disposed', 'lost'])->count(),
        ];
    
        return view('assets.index', compact('assets', 'categories', 'locations', 'summary'));
    }

    public function create()
    {
        $categories = AssetCategory::where('is_active', true)->orderBy('name')->get();
        $locations = AssetLocation::where('is_active', true)->orderBy('name')->get();

        return view('assets.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_code' => ['required', 'string', 'max:100', 'unique:assets,asset_code'],
            'asset_name' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'exists:asset_categories,id'],
            'location_id' => ['nullable', 'exists:asset_locations,id'],
            'owner_role' => ['required', Rule::in(['IT', 'GA', 'LOGISTIK'])],
            'brand' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:150'],
            'qr_code' => ['nullable', 'string', 'max:150', 'unique:assets,qr_code'],
            'purchase_date' => ['nullable', 'date'],
            'received_date' => ['nullable', 'date'],
            'warranty_start_date' => ['nullable', 'date'],
            'warranty_end_date' => ['nullable', 'date', 'after_or_equal:warranty_start_date'],
            'condition_status' => ['required', Rule::in(['good', 'fair', 'damaged', 'repair', 'disposed'])],
            'lifecycle_status' => ['required', Rule::in(['in_stock', 'assigned', 'maintenance', 'disposed', 'lost'])],
            'syop_pr_no' => ['nullable', 'string', 'max:100'],
            'syop_po_no' => ['nullable', 'string', 'max:100'],
            'accurate_asset_id' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'asset_type' => ['nullable', Rule::in([
    'it_device',
    'network_device',
    'office_equipment',
    'office_vehicle',
    'ga_facility',
    'building_equipment',
    'truck_tank',
    'forklift',
    'fleet_vehicle',
])],

'plate_number' => ['nullable', 'string', 'max:50'],
'engine_number' => ['nullable', 'string', 'max:100'],
'chassis_number' => ['nullable', 'string', 'max:100'],
'capacity' => ['nullable', 'numeric', 'min:0'],
'capacity_unit' => ['nullable', 'string', 'max:50'],

'stnk_expired_date' => ['nullable', 'date'],
'kir_expired_date' => ['nullable', 'date'],
'insurance_expired_date' => ['nullable', 'date'],

'fuel_type' => ['nullable', 'string', 'max:50'],
'odometer' => ['nullable', 'integer', 'min:0'],
'service_interval_km' => ['nullable', 'integer', 'min:0'],
'last_service_date' => ['nullable', 'date'],
'next_service_date' => ['nullable', 'date'],

'facility_area' => ['nullable', 'string', 'max:150'],
'floor' => ['nullable', 'string', 'max:50'],
'room_name' => ['nullable', 'string', 'max:150'],
        ]);

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        if (empty($validated['qr_code'])) {
            $validated['qr_code'] = 'QR-' . strtoupper(uniqid());
        }

        $asset = Asset::create($validated);

        $asset->logActivity(
            activityType: 'created',
            title: 'Asset dibuat',
            description: 'Data asset berhasil ditambahkan ke sistem.',
            userId: Auth::id()
        );

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Asset berhasil ditambahkan.');
    }

    public function show(Asset $asset)
{
    $userRole = strtoupper(auth()->user()->role ?? '');

    if (in_array($userRole, ['IT', 'GA', 'LOGISTIK']) && $asset->owner_role !== $userRole) {
        abort(403, 'Anda tidak memiliki akses ke asset ini.');
    }

    $asset->load([
        'category',
        'location',
        'activeAssignment.user',
        'assignments.user',
        'assignments.assignedBy',
        'maintenances.ticket',
        'maintenances.requester',
        'maintenances.handler',
        'mutations.fromLocation',
        'mutations.toLocation',
        'mutations.fromUser',
        'mutations.toUser',
        'documents.uploader',
        'documents',
        'tickets',
        'activityLogs.user',
        'workOrders.requester',
        'workOrders.technician',
        'workOrders.approver',
        'maintenanceSchedules.assignedUser',
'maintenanceSchedules.lastWorkOrder',
    ]);

    return view('assets.show', compact('asset'));
}

    public function edit(Asset $asset)
    {
        $categories = AssetCategory::where('is_active', true)->orderBy('name')->get();
        $locations = AssetLocation::where('is_active', true)->orderBy('name')->get();

        return view('assets.edit', compact('asset', 'categories', 'locations'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'asset_code' => ['required', 'string', 'max:100', Rule::unique('assets', 'asset_code')->ignore($asset->id)],
            'asset_name' => ['required', 'string', 'max:200'],
            'category_id' => ['required', 'exists:asset_categories,id'],
            'location_id' => ['nullable', 'exists:asset_locations,id'],
            'owner_role' => ['required', Rule::in(['IT', 'GA', 'LOGISTIK'])],
            'brand' => ['nullable', 'string', 'max:100'],
            'model' => ['nullable', 'string', 'max:100'],
            'serial_number' => ['nullable', 'string', 'max:150'],
            'qr_code' => [
                'nullable',
                'string',
                'max:150',
                Rule::unique('assets', 'qr_code')->ignore($asset->id),
            ],
            'purchase_date' => ['nullable', 'date'],
            'received_date' => ['nullable', 'date'],
            'warranty_start_date' => ['nullable', 'date'],
            'warranty_end_date' => ['nullable', 'date', 'after_or_equal:warranty_start_date'],
            'condition_status' => ['required', Rule::in(['good', 'fair', 'damaged', 'repair', 'disposed'])],
            'lifecycle_status' => ['required', Rule::in(['in_stock', 'assigned', 'maintenance', 'disposed', 'lost'])],
            'syop_pr_no' => ['nullable', 'string', 'max:100'],
            'syop_po_no' => ['nullable', 'string', 'max:100'],
            'accurate_asset_id' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'asset_type' => ['nullable', Rule::in([
    'it_device',
    'network_device',
    'office_equipment',
    'office_vehicle',
    'ga_facility',
    'building_equipment',
    'truck_tank',
    'forklift',
    'fleet_vehicle',
])],

'plate_number' => ['nullable', 'string', 'max:50'],
'engine_number' => ['nullable', 'string', 'max:100'],
'chassis_number' => ['nullable', 'string', 'max:100'],
'capacity' => ['nullable', 'numeric', 'min:0'],
'capacity_unit' => ['nullable', 'string', 'max:50'],

'stnk_expired_date' => ['nullable', 'date'],
'kir_expired_date' => ['nullable', 'date'],
'insurance_expired_date' => ['nullable', 'date'],

'fuel_type' => ['nullable', 'string', 'max:50'],
'odometer' => ['nullable', 'integer', 'min:0'],
'service_interval_km' => ['nullable', 'integer', 'min:0'],
'last_service_date' => ['nullable', 'date'],
'next_service_date' => ['nullable', 'date'],

'facility_area' => ['nullable', 'string', 'max:150'],
'floor' => ['nullable', 'string', 'max:50'],
'room_name' => ['nullable', 'string', 'max:150'],
        ]);

        $validated['updated_by'] = Auth::id();

        $asset->update($validated);

        $asset->logActivity(
            activityType: 'updated',
            title: 'Asset diperbarui',
            description: 'Informasi asset telah diperbarui.',
            userId: Auth::id()
        );

        return redirect()
            ->route('assets.show', $asset)
            ->with('success', 'Asset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->update([
            'updated_by' => Auth::id(),
        ]);

        $asset->delete();

        return redirect()
            ->route('assets.index')
            ->with('success', 'Asset berhasil dihapus.');
    }

    public function qr(Asset $asset)
{
    $asset->load([
        'category',
        'location',
        'activeAssignment.user',
    ]);

    return view('assets.qr', compact('asset'));
}

public function qrSticker(Asset $asset)
{
    $asset->load([
        'category',
        'location',
        'activeAssignment.user',
    ]);

    return view('assets.qr-sticker', compact('asset'));
}

public function bulkQrPrint(Request $request)
{
    $userRole = strtoupper(auth()->user()->role ?? '');

    $assets = Asset::with(['category', 'location'])
        ->when(in_array($userRole, ['IT', 'GA', 'LOGISTIK']), function ($query) use ($userRole) {
            $query->where('owner_role', $userRole);
        })
        ->when($request->filled('category_id'), function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        })
        ->when($request->filled('location_id'), function ($query) use ($request) {
            $query->where('location_id', $request->location_id);
        })
        ->when($request->filled('lifecycle_status'), function ($query) use ($request) {
            $query->where('lifecycle_status', $request->lifecycle_status);
        })
        ->orderBy('asset_code')
        ->get();

    return view('assets.bulk-qr-print', compact('assets'));
}

public function export(Request $request)
{
    $filters = $request->only([
        'search',
        'category_id',
        'location_id',
        'lifecycle_status',
        'condition_status',
    ]);

    $fileName = 'assets-export-' . now()->format('Ymd-His') . '.xlsx';

    return Excel::download(new AssetsExport($filters), $fileName);
}
}