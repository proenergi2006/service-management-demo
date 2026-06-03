<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetWorkOrder;
use App\Models\User;
use App\Models\AssetChecklistTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\AssetSparepartMovement;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AssetWorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetWorkOrder::with(['asset.category', 'asset.location', 'requester', 'technician', 'approver'])
            ->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('work_order_no', 'like', "%{$search}%")
                    ->orWhere('problem_description', 'like', "%{$search}%")
                    ->orWhereHas('asset', function ($assetQuery) use ($search) {
                        $assetQuery->where('asset_code', 'like', "%{$search}%")
                            ->orWhere('asset_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('maintenance_type')) {
            $query->where('maintenance_type', $request->maintenance_type);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $workOrders = $query->paginate(10)->withQueryString();

        $summary = [
            'total' => AssetWorkOrder::count(),
            'submitted' => AssetWorkOrder::where('status', 'submitted')->count(),
            'in_progress' => AssetWorkOrder::where('status', 'in_progress')->count(),
            'completed' => AssetWorkOrder::where('status', 'completed')->count(),
        ];

        return view('assets.work-orders.index', compact('workOrders', 'summary'));
    }

    public function create(Request $request)
    {
        $assets = Asset::with(['category', 'location'])
            ->orderBy('asset_code')
            ->get();
    
        $technicians = User::orderBy('name')->get();
    
        $vendors = \App\Models\AssetMaintenanceVendor::where('is_active', true)
            ->orderBy('vendor_name')
            ->get();
    
        $selectedAssetId = $request->get('asset_id');
    
        return view('assets.work-orders.create', compact(
            'assets',
            'technicians',
            'vendors',
            'selectedAssetId'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
            'maintenance_type' => ['required', Rule::in([
                'preventive',
                'corrective',
                'inspection',
                'calibration',
                'breakdown',
            ])],
            'priority' => ['required', Rule::in([
                'low',
                'medium',
                'high',
                'critical',
            ])],
            'problem_description' => ['required', 'string'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'planned_start_date' => ['nullable', 'date'],
            'planned_finish_date' => ['nullable', 'date', 'after_or_equal:planned_start_date'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
            'vendor_name' => ['nullable', 'string', 'max:150'],
            'vendor_pic' => ['nullable', 'string', 'max:150'],
            'vendor_phone' => ['nullable', 'string', 'max:50'],
            'start_meter' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);
    
        $validated['work_order_no'] = $this->generateWorkOrderNo();
        $validated['status'] = 'draft';
        $validated['requested_by'] = Auth::id();
        $validated['estimated_cost'] = $validated['estimated_cost'] ?? 0;
        $validated['actual_cost'] = 0;
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();
    
        $workOrder = AssetWorkOrder::create($validated);
    
        $workOrder->asset?->logActivity(
            activityType: 'work_order_created',
            title: 'Work Order dibuat',
            description: 'WO ' . $workOrder->work_order_no . ' berhasil dibuat.',
            userId: Auth::id(),
            referenceType: AssetWorkOrder::class,
            referenceId: $workOrder->id
        );
    
        return redirect()
            ->route('assets.work-orders.show', $workOrder)
            ->with('success', 'Work Order berhasil dibuat.');
    }

    public function show(AssetWorkOrder $workOrder)
{
    $workOrder->load([
        'asset.category',
        'asset.location',
        'requester',
        'technician',
        'approver',
        'checklistItems.checker',
        'spareparts.sparepart',
    ]);

    $templates = AssetChecklistTemplate::where('is_active', true)
        ->orderBy('template_name')
        ->get();

    $userRole = strtoupper(auth()->user()->role ?? '');

    $sparepartsQuery = \App\Models\AssetSparepart::where('is_active', true);

    if ($userRole === 'IT') {
        $sparepartsQuery->where('sparepart_code', 'like', 'SP-IT%');
    }

    if ($userRole === 'GA') {
        $sparepartsQuery->where(function ($q) {
            $q->where('sparepart_code', 'like', 'SP-AC%')
              ->orWhere('sparepart_code', 'like', 'SP-GA%');
        });
    }

    if ($userRole === 'LOGISTIK') {
        $sparepartsQuery->where(function ($q) {
            $q->where('sparepart_code', 'like', 'SP-TRK%')
              ->orWhere('sparepart_code', 'like', 'SP-GEN%');
        });
    }

    $spareparts = $sparepartsQuery
        ->orderBy('sparepart_name')
        ->get();

    return view('assets.work-orders.show', compact(
        'workOrder',
        'templates',
        'spareparts'
    ));
}

public function edit(AssetWorkOrder $workOrder)
{
    if (!in_array($workOrder->status, ['draft', 'submitted', 'scheduled'])) {
        return back()->with('error', 'Work Order tidak bisa diedit pada status ini.');
    }

    $assets = Asset::with(['category', 'location'])
        ->orderBy('asset_code')
        ->get();

    $technicians = User::orderBy('name')->get();

    $vendors = \App\Models\AssetMaintenanceVendor::where('is_active', true)
        ->orderBy('vendor_name')
        ->get();

    return view('assets.work-orders.edit', compact(
        'workOrder',
        'assets',
        'technicians',
        'vendors'
    ));
}

    public function update(Request $request, AssetWorkOrder $workOrder)
    {
        if (!in_array($workOrder->status, ['draft', 'submitted', 'scheduled'])) {
            return back()->with('error', 'Work Order tidak bisa diperbarui pada status ini.');
        }

        $validated = $request->validate([
            'asset_id' => ['required', 'exists:assets,id'],
            'maintenance_type' => ['required', Rule::in(['preventive', 'corrective', 'inspection', 'calibration', 'breakdown'])],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'problem_description' => ['required', 'string'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'planned_start_date' => ['nullable', 'date'],
            'planned_finish_date' => ['nullable', 'date', 'after_or_equal:planned_start_date'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
            'vendor_name' => ['nullable', 'string', 'max:150'],
            'vendor_pic' => ['nullable', 'string', 'max:150'],
            'vendor_phone' => ['nullable', 'string', 'max:50'],
            'start_meter' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['estimated_cost'] = $validated['estimated_cost'] ?? 0;
        $validated['updated_by'] = Auth::id();

        $workOrder->update($validated);

        return redirect()
            ->route('assets.work-orders.show', $workOrder)
            ->with('success', 'Work Order berhasil diperbarui.');
    }

    public function submit(AssetWorkOrder $workOrder)
    {
        if ($workOrder->status !== 'draft') {
            return back()->with('error', 'Hanya Work Order draft yang bisa disubmit.');
        }

        $workOrder->update([
            'status' => 'submitted',
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Work Order berhasil disubmit.');
    }

    public function approve(Request $request, AssetWorkOrder $workOrder)
    {
        if ($workOrder->status !== 'submitted') {
            return back()->with('error', 'Hanya Work Order submitted yang bisa diapprove.');
        }

        $workOrder->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_note' => $request->approval_note,
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Work Order berhasil diapprove.');
    }

    public function reject(Request $request, AssetWorkOrder $workOrder)
    {
        if ($workOrder->status !== 'submitted') {
            return back()->with('error', 'Hanya Work Order submitted yang bisa direject.');
        }

        $workOrder->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_note' => $request->approval_note,
            'updated_by' => Auth::id(),
        ]);

        return back()->with('success', 'Work Order berhasil direject.');
    }

    public function start(AssetWorkOrder $workOrder)
    {
        if (!in_array($workOrder->status, ['approved', 'scheduled'])) {
            return back()->with('error', 'Work Order belum bisa dimulai.');
        }

        $workOrder->update([
            'status' => 'in_progress',
            'actual_start_date' => now(),
            'updated_by' => Auth::id(),
        ]);

        $workOrder->asset?->update([
            'lifecycle_status' => 'maintenance',
        ]);

        return back()->with('success', 'Work Order dimulai.');
    }

    public function complete(Request $request, AssetWorkOrder $workOrder)
    {
        $validated = $request->validate([
            'actual_start_date' => 'nullable|date',
            'actual_finish_date' => 'nullable|date|after_or_equal:actual_start_date',
    
            'actual_cost' => 'nullable|numeric|min:0',
    
            'resolution_notes' => 'nullable|string',
    
            'vendor_name' => 'nullable|string|max:255',
    
            'downtime_minutes' => 'nullable|integer|min:0',
    
            'start_meter' => 'nullable|numeric|min:0',
            'end_meter' => 'nullable|numeric|min:0',
            'breakdown_at' => 'nullable|date',
'repair_started_at' => 'nullable|date',
'repair_finished_at' => 'nullable|date|after_or_equal:repair_started_at',
'downtime_notes' => 'nullable|string',
        ]);
    
        /*
        |--------------------------------------------------------------------------
        | UPDATE WORK ORDER
        |--------------------------------------------------------------------------
        */

        $breakdownAt = !empty($validated['breakdown_at'])
    ? \Carbon\Carbon::parse($validated['breakdown_at'])
    : null;

$repairStartedAt = !empty($validated['repair_started_at'])
    ? \Carbon\Carbon::parse($validated['repair_started_at'])
    : null;

$repairFinishedAt = !empty($validated['repair_finished_at'])
    ? \Carbon\Carbon::parse($validated['repair_finished_at'])
    : now();

$repairDurationMinutes = 0;
$downtimeMinutes = 0;

if ($repairStartedAt && $repairFinishedAt) {
    $repairDurationMinutes = $repairStartedAt->diffInMinutes($repairFinishedAt);
}

if ($breakdownAt && $repairFinishedAt) {
    $downtimeMinutes = $breakdownAt->diffInMinutes($repairFinishedAt);
}
    
        $workOrder->update([
            'status' => 'completed',
    
            'actual_start_date' => $validated['actual_start_date'] ?? now(),
            'actual_finish_date' => $validated['actual_finish_date'] ?? now(),
    
            'actual_cost' => $validated['actual_cost'] ?? 0,
    
            'resolution_notes' => $validated['resolution_notes'] ?? null,
    
            'vendor_name' => $validated['vendor_name'] ?? $workOrder->vendor_name,
    
            'downtime_minutes' => $validated['downtime_minutes'] ?? 0,
    
            'start_meter' => $validated['start_meter'] ?? $workOrder->start_meter,
            'end_meter' => $validated['end_meter'] ?? $workOrder->end_meter,
    
            'completed_at' => now(),
            'completed_by' => auth()->id(),
    
            'updated_by' => auth()->id(),

            'breakdown_at' => $breakdownAt,
'repair_started_at' => $repairStartedAt,
'repair_finished_at' => $repairFinishedAt,
'repair_duration_minutes' => $repairDurationMinutes,
'downtime_minutes' => $downtimeMinutes,
'downtime_notes' => $validated['downtime_notes'] ?? null,
        ]);
    
        /*
        |--------------------------------------------------------------------------
        | UPDATE ASSET STATUS
        |--------------------------------------------------------------------------
        */
    
        if ($workOrder->asset) {
    
            $workOrder->asset->update([
                'lifecycle_status' => 'assigned',
                'updated_by' => auth()->id(),
            ]);
    
            $workOrder->asset->logActivity(
                activityType: 'work_order_completed',
                title: 'Work Order Completed',
                description: 'WO ' . $workOrder->work_order_no . ' berhasil diselesaikan.',
                userId: auth()->id(),
                referenceType: AssetWorkOrder::class,
                referenceId: $workOrder->id
            );
        }
    
        /*
        |--------------------------------------------------------------------------
        | UPDATE PREVENTIVE MAINTENANCE SCHEDULE
        |--------------------------------------------------------------------------
        */
    
        $schedule = \App\Models\AssetMaintenanceSchedule::where(
            'last_work_order_id',
            $workOrder->id
        )->first();
    
        if ($schedule) {
    
            $lastExecutionDate = now();
    
            /*
            |--------------------------------------------------------------------------
            | NEXT DATE CALCULATION
            |--------------------------------------------------------------------------
            */
    
            $nextExecutionDate = match ($schedule->frequency_type) {
    
                'daily' => $lastExecutionDate
                    ->copy()
                    ->addDays($schedule->frequency_interval),
    
                'weekly' => $lastExecutionDate
                    ->copy()
                    ->addWeeks($schedule->frequency_interval),
    
                'monthly' => $lastExecutionDate
                    ->copy()
                    ->addMonths($schedule->frequency_interval),
    
                'yearly' => $lastExecutionDate
                    ->copy()
                    ->addYears($schedule->frequency_interval),
    
                default => null,
            };
    
            /*
            |--------------------------------------------------------------------------
            | METER CALCULATION
            |--------------------------------------------------------------------------
            */
    
            $currentMeter =
                $validated['end_meter']
                ?? $schedule->last_meter
                ?? 0;
    
            $nextMeter = null;
    
            if (in_array($schedule->frequency_type, ['km', 'hour_meter'])) {
    
                $nextMeter =
                    $currentMeter + $schedule->frequency_interval;
            }
    
            /*
            |--------------------------------------------------------------------------
            | UPDATE SCHEDULE
            |--------------------------------------------------------------------------
            */
    
            $schedule->update([
    
                'last_execution_date' =>
                    $lastExecutionDate->toDateString(),
    
                'next_execution_date' =>
                    $nextExecutionDate?->toDateString(),
    
                'last_meter' =>
                    $currentMeter,
    
                'next_meter' =>
                    $nextMeter,
    
                'updated_by' =>
                    auth()->id(),
            ]);
    
            /*
            |--------------------------------------------------------------------------
            | LOG ACTIVITY
            |--------------------------------------------------------------------------
            */
    
            $workOrder->asset?->logActivity(
                activityType: 'schedule_updated',
                title: 'PM Schedule Updated',
                description:
                    'Schedule ' . $schedule->schedule_no .
                    ' otomatis diperbarui setelah WO complete.',
                userId: auth()->id(),
                referenceType: \App\Models\AssetMaintenanceSchedule::class,
                referenceId: $schedule->id
            );
        }
    
        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */
    
        return redirect()
            ->route('assets.work-orders.show', $workOrder)
            ->with(
                'success',
                'Work Order berhasil diselesaikan dan maintenance schedule berhasil diperbarui.'
            );
    }

    public function destroy(AssetWorkOrder $workOrder)
    {
        if (!in_array($workOrder->status, ['draft', 'rejected', 'cancelled'])) {
            return back()->with('error', 'Work Order tidak bisa dihapus pada status ini.');
        }

        $workOrder->delete();

        return redirect()
            ->route('assets.work-orders.index')
            ->with('success', 'Work Order berhasil dihapus.');
    }

    private function generateWorkOrderNo(): string
    {
        $date = now()->format('Ymd');
        $count = AssetWorkOrder::whereDate('created_at', now())->count() + 1;

        return 'WO-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function exportPdf(AssetWorkOrder $workOrder)
{
    $workOrder->load([
        'asset.category',
        'asset.location',
        'requester',
        'technician',
        'approver',
        'checklistItems.checker',
        'spareparts.sparepart',
    ]);

    $pdf = Pdf::loadView('assets.work-orders.pdf', compact('workOrder'))
        ->setPaper('a4', 'portrait');

    return $pdf->stream($workOrder->work_order_no . '.pdf');
}
}