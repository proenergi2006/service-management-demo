<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\AssetMaintenanceSchedule;
use App\Models\AssetWorkOrder;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssetDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $warrantyThreshold = Carbon::today()->addDays(30);

        $userRole = strtoupper(auth()->user()->role ?? '');

        /*
        |--------------------------------------------------------------------------
        | FILTER ASSET BY ROLE
        |--------------------------------------------------------------------------
        | IT       -> owner_role IT
        | GA       -> owner_role GA
        | LOGISTIK -> owner_role LOGISTIK
        | role lain -> lihat semua
        */

        $baseAssetQuery = Asset::query();

        if (in_array($userRole, ['IT', 'GA', 'LOGISTIK'])) {
            $baseAssetQuery->where('owner_role', $userRole);
        }

        $assetIds = (clone $baseAssetQuery)->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | SUMMARY ASSET
        |--------------------------------------------------------------------------
        */

        $summary = [
            'total_assets' => (clone $baseAssetQuery)->count(),

            'assigned_assets' => (clone $baseAssetQuery)
                ->where('lifecycle_status', 'assigned')
                ->count(),

            'maintenance_assets' => (clone $baseAssetQuery)
                ->where('lifecycle_status', 'maintenance')
                ->count(),

            'disposed_lost_assets' => (clone $baseAssetQuery)
                ->whereIn('lifecycle_status', ['disposed', 'lost'])
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | DISTRIBUTION
        |--------------------------------------------------------------------------
        */

        $assetsByCategory = (clone $baseAssetQuery)
            ->select('category_id', DB::raw('COUNT(*) as total'))
            ->with('category:id,name')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get();

        $assetsByLocation = (clone $baseAssetQuery)
            ->select('location_id', DB::raw('COUNT(*) as total'))
            ->with('location:id,name')
            ->groupBy('location_id')
            ->orderByDesc('total')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | WARRANTY
        |--------------------------------------------------------------------------
        */

        $warrantyExpiring = (clone $baseAssetQuery)
            ->with(['category', 'location'])
            ->whereNotNull('warranty_end_date')
            ->whereDate('warranty_end_date', '>=', $today)
            ->whereDate('warranty_end_date', '<=', $warrantyThreshold)
            ->orderBy('warranty_end_date')
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | MAINTENANCE OPEN
        |--------------------------------------------------------------------------
        */

        $maintenanceOpen = AssetMaintenance::with(['asset'])
            ->whereIn('asset_id', $assetIds)
            ->whereIn('status', ['open', 'scheduled', 'on_progress'])
            ->latest()
            ->limit(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | LATEST ASSETS
        |--------------------------------------------------------------------------
        */

        $latestAssets = (clone $baseAssetQuery)
            ->with(['category', 'location', 'documents'])
            ->latest()
            ->limit(8)
            ->get();


            $lowStockSparepartsQuery = \App\Models\AssetSparepart::query()
            ->whereColumn('current_stock', '<=', 'minimum_stock');
        
        if ($userRole === 'IT') {
            $lowStockSparepartsQuery->where('sparepart_code', 'like', 'SP-IT%');
        }
        
        if ($userRole === 'LOGISTIK') {
            $lowStockSparepartsQuery->where('sparepart_code', 'like', 'SP-TRK%');
        }
        
        if ($userRole === 'GA') {
            $lowStockSparepartsQuery->where('sparepart_code', 'like', 'SP-AC%');
        }
        
        $lowStockSpareparts = $lowStockSparepartsQuery
            ->orderBy('current_stock')
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PM SUMMARY
        |--------------------------------------------------------------------------
        | Tidak pakai is_active karena kolom belum ada.
        */

        $pmSummary = [
            'active_schedule' => AssetMaintenanceSchedule::whereIn('asset_id', $assetIds)
                ->count(),

            'due_today' => AssetMaintenanceSchedule::whereIn('asset_id', $assetIds)
                ->whereDate('next_execution_date', $today)
                ->count(),

            'overdue' => AssetMaintenanceSchedule::whereIn('asset_id', $assetIds)
                ->whereDate('next_execution_date', '<', $today)
                ->count(),

            'due_7_days' => AssetMaintenanceSchedule::whereIn('asset_id', $assetIds)
                ->whereDate('next_execution_date', '>=', $today)
                ->whereDate('next_execution_date', '<=', $today->copy()->addDays(7))
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | WORK ORDER SUMMARY
        |--------------------------------------------------------------------------
        */

        $woSummary = [
            'draft' => AssetWorkOrder::whereIn('asset_id', $assetIds)
                ->where('status', 'draft')
                ->count(),

            'submitted' => AssetWorkOrder::whereIn('asset_id', $assetIds)
                ->where('status', 'submitted')
                ->count(),

            'approved' => AssetWorkOrder::whereIn('asset_id', $assetIds)
                ->where('status', 'approved')
                ->count(),

            'in_progress' => AssetWorkOrder::whereIn('asset_id', $assetIds)
                ->where('status', 'in_progress')
                ->count(),

            'completed' => AssetWorkOrder::whereIn('asset_id', $assetIds)
                ->where('status', 'completed')
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | PM MONITORING LIST
        |--------------------------------------------------------------------------
        */

        $overdueSchedules = AssetMaintenanceSchedule::with(['asset'])
            ->whereIn('asset_id', $assetIds)
            ->whereDate('next_execution_date', '<', $today)
            ->orderBy('next_execution_date')
            ->limit(8)
            ->get();

        $upcomingSchedules = AssetMaintenanceSchedule::with(['asset'])
            ->whereIn('asset_id', $assetIds)
            ->whereDate('next_execution_date', '>=', $today)
            ->whereDate('next_execution_date', '<=', $today->copy()->addDays(7))
            ->orderBy('next_execution_date')
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | OPEN WORK ORDERS
        |--------------------------------------------------------------------------
        */

        $openWorkOrders = AssetWorkOrder::with(['asset', 'technician'])
            ->whereIn('asset_id', $assetIds)
            ->whereIn('status', ['draft', 'submitted', 'approved', 'in_progress'])
            ->latest()
            ->limit(8)
            ->get();

        return view('assets.dashboard', compact(
            'summary',
            'assetsByCategory',
            'assetsByLocation',
            'warrantyExpiring',
            'maintenanceOpen',
            'latestAssets',
            'pmSummary',
            'woSummary',
            'overdueSchedules',
            'upcomingSchedules',
            'openWorkOrders',
             'lowStockSpareparts'
        ));
    }

    public function maintenanceCostReport(Request $request)
{
    $userRole = strtoupper(auth()->user()->role ?? '');

    $query = \App\Models\AssetWorkOrder::with([
        'asset.category',
        'technician',
    ])
    ->where('status', 'completed');

    /*
    |--------------------------------------------------------------------------
    | FILTER ROLE
    |--------------------------------------------------------------------------
    */

    if ($userRole === 'IT') {
        $query->whereHas('asset', function ($q) {
            $q->where('owner_role', 'IT');
        });
    }

    if ($userRole === 'GA') {
        $query->whereHas('asset', function ($q) {
            $q->where('owner_role', 'GA');
        });
    }

    if ($userRole === 'LOGISTIK') {
        $query->whereHas('asset', function ($q) {
            $q->where('owner_role', 'LOGISTIK');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER
    |--------------------------------------------------------------------------
    */

    if ($request->filled('asset_id')) {
        $query->where('asset_id', $request->asset_id);
    }

    if ($request->filled('maintenance_type')) {
        $query->where('maintenance_type', $request->maintenance_type);
    }

    if ($request->filled('date_from')) {
        $query->whereDate('updated_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $query->whereDate('updated_at', '<=', $request->date_to);
    }

    $workOrders = $query
        ->latest('updated_at')
        ->paginate(10)
        ->withQueryString();

    /*
    |--------------------------------------------------------------------------
    | SUMMARY
    |--------------------------------------------------------------------------
    */

    $summary = [
        'total_cost' => (clone $query)->sum('actual_cost'),

        'total_wo' => (clone $query)->count(),

        'avg_cost' => (clone $query)->avg('actual_cost'),

        'preventive_cost' => (clone $query)
            ->where('maintenance_type', 'preventive')
            ->sum('actual_cost'),

        'corrective_cost' => (clone $query)
            ->where('maintenance_type', 'corrective')
            ->sum('actual_cost'),
    ];

    /*
    |--------------------------------------------------------------------------
    | ASSET LIST
    |--------------------------------------------------------------------------
    */

    $assets = \App\Models\Asset::query();

    if ($userRole === 'IT') {
        $assets->where('owner_role', 'IT');
    }

    if ($userRole === 'GA') {
        $assets->where('owner_role', 'GA');
    }

    if ($userRole === 'LOGISTIK') {
        $assets->where('owner_role', 'LOGISTIK');
    }

    $assets = $assets
        ->orderBy('asset_name')
        ->get();


        $startDate = $request->date_from;
$endDate = $request->date_to;
$selectedAssetId = $request->asset_id;
$selectedMaintenanceType = $request->maintenance_type;
    return view(
        'assets.reports.maintenance-cost',
        compact(
            'workOrders',
            'summary',
            'assets',
            'startDate',
            'endDate',
            'selectedAssetId',
            'selectedMaintenanceType'
        )
    );
}

public function reliability()
{
    $userRole = strtoupper(auth()->user()->role ?? '');

    $query = AssetWorkOrder::with('asset')
        ->where('status', 'completed');

    if (in_array($userRole, ['IT', 'GA', 'LOGISTIK'])) {
        $query->whereHas('asset', function ($q) use ($userRole) {
            $q->where('owner_role', $userRole);
        });
    }

    $completedWO = $query->get();

    $assetReliability = $completedWO
        ->filter(fn ($wo) => $wo->asset)
        ->groupBy('asset_id')
        ->map(function ($rows) {
            $asset = $rows->first()->asset;

            $breakdownCount = $rows->count();
            $totalRepairMinutes = $rows->sum('repair_duration_minutes');
            $totalDowntimeMinutes = $rows->sum('downtime_minutes');

            $mttr = $breakdownCount > 0
                ? round($totalRepairMinutes / $breakdownCount, 2)
                : 0;

            $operatingMinutes = 43200;

            $mtbf = $breakdownCount > 0
                ? round($operatingMinutes / $breakdownCount, 2)
                : 0;

            $reliabilityScore = $mtbf > 0
                ? round(($mtbf / ($mtbf + $mttr)) * 100, 2)
                : 100;

            return [
                'asset' => $asset,
                'breakdown_count' => $breakdownCount,
                'total_repair_minutes' => $totalRepairMinutes,
                'total_downtime_minutes' => $totalDowntimeMinutes,
                'mttr' => $mttr,
                'mtbf' => $mtbf,
                'reliability_score' => $reliabilityScore,
            ];
        })
        ->sortByDesc('total_downtime_minutes');

    return view('assets.reports.reliability', compact('assetReliability'));
}
}