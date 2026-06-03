<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AssetMaintenanceSchedule;
use App\Models\AssetWorkOrder;
use App\Models\User;
use App\Models\AssetMaintenanceVendor;

class AssetMaintenanceScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetMaintenanceSchedule::with([
            'asset',
            'assignedUser',
            'lastWorkOrder',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('frequency_type')) {
            $query->where('frequency_type', $request->frequency_type);
        }

        if ($request->filled('maintenance_type')) {
            $query->where('maintenance_type', $request->maintenance_type);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('schedule_no', 'like', "%{$search}%")
                    ->orWhere('schedule_name', 'like', "%{$search}%")
                    ->orWhereHas('asset', function ($assetQ) use ($search) {
                        $assetQ->where('asset_code', 'like', "%{$search}%")
                            ->orWhere('asset_name', 'like', "%{$search}%");
                    });
            });
        }

        $schedules = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'total' => AssetMaintenanceSchedule::count(),
            'active' => AssetMaintenanceSchedule::where('status', 'active')->count(),
            'due' => AssetMaintenanceSchedule::whereDate('next_execution_date', '<=', now())->count(),
            'upcoming' => AssetMaintenanceSchedule::whereBetween(
                'next_execution_date',
                [now(), now()->addDays(7)]
            )->count(),
        ];

        return view('assets.schedules.index', compact(
            'schedules',
            'summary'
        ));
    }

    public function create(Request $request)
    {
        $userRole = strtoupper(auth()->user()->role ?? '');
    
        $assets = Asset::query()
            ->when(in_array($userRole, ['IT', 'GA', 'LOGISTIK']), function ($query) use ($userRole) {
                $query->where('owner_role', $userRole);
            })
            ->orderBy('asset_name')
            ->get();
    
        $technicians = User::orderBy('name')->get();
    
        $vendors = AssetMaintenanceVendor::where('is_active', true)
            ->orderBy('vendor_name')
            ->get();
    
        return view('assets.schedules.create', [
            'assets' => $assets,
            'technicians' => $technicians,
            'vendors' => $vendors,
            'selectedAssetId' => $request->asset_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'maintenance_type' => 'required',
            'schedule_name' => 'required|string|max:255',
            'description' => 'nullable|string',

            'frequency_type' => 'required',
            'frequency_interval' => 'required|integer|min:1',

            'start_date' => 'nullable|date',
            'next_execution_date' => 'nullable|date',

            'next_meter' => 'nullable|numeric',

            'priority' => 'required',
            'assigned_to' => 'nullable|exists:users,id',

            'vendor_name' => 'nullable|string|max:255',
            'estimated_cost' => 'nullable|numeric',

            'auto_generate_wo' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['schedule_no'] = $this->generateScheduleNo();

        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        $schedule = AssetMaintenanceSchedule::create($validated);

        return redirect()
            ->route('assets.schedules.show', $schedule)
            ->with('success', 'Maintenance schedule berhasil dibuat.');
    }

    public function show(AssetMaintenanceSchedule $schedule)
    {
        $schedule->load([
            'asset',
            'assignedUser',
            'lastWorkOrder',
        ]);

        return view('assets.schedules.show', compact('schedule'));
    }

    public function edit(AssetMaintenanceSchedule $schedule)
    {
        $userRole = strtoupper(auth()->user()->role ?? '');
    
        if (
            in_array($userRole, ['IT', 'GA', 'LOGISTIK']) &&
            $schedule->asset &&
            $schedule->asset->owner_role !== $userRole
        ) {
            abort(403, 'Anda tidak memiliki akses ke schedule ini.');
        }
    
        $assets = Asset::query()
            ->when(in_array($userRole, ['IT', 'GA', 'LOGISTIK']), function ($query) use ($userRole) {
                $query->where('owner_role', $userRole);
            })
            ->orderBy('asset_name')
            ->get();
    
        $technicians = User::orderBy('name')->get();
    
        $vendors = AssetMaintenanceVendor::where('is_active', true)
            ->orderBy('vendor_name')
            ->get();
    
        return view('assets.schedules.edit', compact(
            'schedule',
            'assets',
            'technicians',
            'vendors'
        ));
    }

    public function update(Request $request, AssetMaintenanceSchedule $schedule)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'maintenance_type' => 'required',
            'schedule_name' => 'required|string|max:255',
            'description' => 'nullable|string',

            'frequency_type' => 'required',
            'frequency_interval' => 'required|integer|min:1',

            'start_date' => 'nullable|date',
            'next_execution_date' => 'nullable|date',

            'next_meter' => 'nullable|numeric',

            'priority' => 'required',
            'assigned_to' => 'nullable|exists:users,id',

            'vendor_name' => 'nullable|string|max:255',
            'estimated_cost' => 'nullable|numeric',

            'auto_generate_wo' => 'nullable|boolean',
            'notes' => 'nullable|string',

            'status' => 'required',
        ]);

        $validated['updated_by'] = Auth::id();

        $schedule->update($validated);

        return redirect()
            ->route('assets.schedules.show', $schedule)
            ->with('success', 'Maintenance schedule berhasil diperbarui.');
    }

    public function destroy(AssetMaintenanceSchedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Schedule berhasil dihapus.');
    }

    private function generateScheduleNo(): string
    {
        $date = now()->format('Ymd');

        $count = AssetMaintenanceSchedule::whereDate('created_at', now())
            ->count() + 1;

        return 'PM-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }


    public function generateWorkOrder(AssetMaintenanceSchedule $schedule)
{
    if ($schedule->status !== 'active') {
        return back()->with('error', 'Schedule tidak aktif, tidak bisa generate Work Order.');
    }

    $workOrder = AssetWorkOrder::create([
        'asset_id' => $schedule->asset_id,
        'work_order_no' => $this->generateWorkOrderNo(),

        'maintenance_type' => match ($schedule->maintenance_type) {
            'preventive', 'service' => 'preventive',
            'inspection' => 'inspection',
            'calibration' => 'calibration',
            default => 'preventive',
        },

        'priority' => $schedule->priority ?? 'medium',

        'problem_description' =>
            'Preventive Maintenance Schedule: ' . $schedule->schedule_name .
            "\n\n" .
            ($schedule->description ?? '-'),

        'requested_by' => auth()->id(),
        'assigned_to' => $schedule->assigned_to,

        'status' => 'draft',

        'planned_start_date' => $schedule->next_execution_date,
        'planned_finish_date' => $schedule->next_execution_date,

        'estimated_cost' => $schedule->estimated_cost ?? 0,

        'vendor_name' => $schedule->vendor_name,
        'notes' => 'Generated from schedule: ' . $schedule->schedule_no,

        'created_by' => auth()->id(),
        'updated_by' => auth()->id(),
    ]);

    $schedule->update([
        'last_work_order_id' => $workOrder->id,
        'updated_by' => auth()->id(),
    ]);

    $schedule->asset?->logActivity(
        activityType: 'schedule_generate_work_order',
        title: 'Work Order dibuat dari schedule',
        description: 'Schedule ' . $schedule->schedule_no . ' generate WO ' . $workOrder->work_order_no,
        userId: auth()->id(),
        referenceType: AssetWorkOrder::class,
        referenceId: $workOrder->id
    );

    return redirect()
        ->route('assets.work-orders.show', $workOrder)
        ->with('success', 'Work Order berhasil dibuat dari maintenance schedule.');
}

private function generateWorkOrderNo(): string
{
    $date = now()->format('Ymd');

    $count = AssetWorkOrder::whereDate('created_at', now())->count() + 1;

    return 'WO-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
}
}