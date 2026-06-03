<x-app-layout>
    <style>
        :root{
            --sap-primary:#0a6ed1;
            --sap-shell:#354a5f;
            --sap-bg:#f5f6f7;
            --sap-border:#d9d9d9;
            --sap-text:#32363a;
            --sap-sub:#6a6d70;
        }

        .sap-page{
            background:var(--sap-bg);
            min-height:100vh;
            color:var(--sap-text);
        }

        .sap-container{
            padding:24px;
        }

        .sap-header,
        .sap-card,
        .sap-kpi{
            background:#fff;
            border:1px solid var(--sap-border);
            border-radius:14px;
            box-shadow:0 2px 8px rgba(15,23,42,.05);
        }

        .sap-header{
            padding:20px;
        }

        .sap-breadcrumb{
            font-size:12px;
            color:#6a6d70;
        }

        .sap-title{
            margin-top:4px;
            font-size:28px;
            font-weight:900;
            color:var(--sap-text);
        }

        .sap-subtitle{
            margin-top:6px;
            font-size:13px;
            color:var(--sap-sub);
            line-height:1.6;
        }

        .sap-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:40px;
            padding:0 16px;
            border-radius:8px;
            border:1px solid #c9cdd1;
            background:#fff;
            font-size:13px;
            font-weight:800;
            color:var(--sap-text);
            transition:.15s;
        }

        .sap-btn:hover{
            background:#f5f6f7;
        }

        .sap-btn-primary{
            background:var(--sap-primary);
            border-color:var(--sap-primary);
            color:#fff;
        }

        .sap-btn-primary:hover{
            background:#085caf;
        }

        .sap-filterbar{
            background:#fff;
            border:1px solid var(--sap-border);
            border-radius:14px;
            overflow:hidden;
            box-shadow:0 2px 8px rgba(15,23,42,.05);
        }

        .sap-filter-header{
            padding:16px 20px;
            border-bottom:1px solid #edf0f2;
            background:#fafbfc;
        }

        .sap-filter-title{
            font-size:15px;
            font-weight:900;
            color:var(--sap-text);
        }

        .sap-filter-desc{
            margin-top:4px;
            font-size:12px;
            color:var(--sap-sub);
        }

        .sap-filter-body{
            padding:20px;
        }

        .sap-input{
            width:100%;
            height:42px;
            border:1px solid #c9cdd1;
            border-radius:8px;
            background:#fff;
            padding:0 14px;
            font-size:13px;
            color:var(--sap-text);
        }

        .sap-input:focus{
            outline:none;
            border-color:var(--sap-primary);
            box-shadow:0 0 0 3px rgba(10,110,209,.12);
        }

        .sap-kpi{
            position:relative;
            overflow:hidden;
            transition:.2s;
        }

        .sap-kpi:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 24px rgba(15,23,42,.08);
        }

        .sap-kpi::before{
            content:"";
            position:absolute;
            left:0;
            top:0;
            width:5px;
            height:100%;
            background:var(--sap-color);
        }

        .sap-kpi-body{
            padding:20px;
        }

        .sap-kpi-label{
            font-size:11px;
            font-weight:900;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:var(--sap-sub);
        }

        .sap-kpi-value{
            margin-top:12px;
            font-size:38px;
            line-height:1;
            font-weight:900;
            color:var(--sap-text);
        }

        .sap-kpi-footer{
            margin-top:12px;
            font-size:12px;
            color:var(--sap-sub);
        }

        .sap-card-header{
            padding:16px 20px;
            border-bottom:1px solid #edf0f2;
            background:#fafbfc;
        }

        .sap-card-title{
            font-size:15px;
            font-weight:900;
            color:var(--sap-text);
        }

        .sap-card-desc{
            margin-top:4px;
            font-size:12px;
            color:var(--sap-sub);
        }

        .sap-worklist{
            padding:16px;
            display:flex;
            flex-direction:column;
            gap:12px;
        }

        .sap-work-item{
            border:1px solid #edf0f2;
            border-radius:10px;
            padding:14px;
            transition:.15s;
            background:#fff;
        }

        .sap-work-item:hover{
            border-color:#b8d8f4;
            background:#f8fbff;
        }

        .sap-work-title{
            font-size:13px;
            font-weight:900;
            color:var(--sap-text);
        }

        .sap-work-sub{
            margin-top:6px;
            font-size:12px;
            color:var(--sap-sub);
        }

        .sap-badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border-radius:999px;
            padding:6px 10px;
            font-size:11px;
            font-weight:900;
        }

        .sap-badge-danger{
            background:#ffeaea;
            color:#bb0000;
        }

        .sap-badge-warning{
            background:#fff4ce;
            color:#8a6d00;
        }

        .sap-badge-primary{
            background:#eaf3ff;
            color:#0a6ed1;
        }

        .sap-badge-success{
            background:#e4f5e9;
            color:#107e3e;
        }

        .sap-table{
            width:100%;
            border-collapse:collapse;
        }

        .sap-table thead{
            background:#fafbfc;
        }

        .sap-table th{
            text-align:left;
            padding:14px 16px;
            font-size:11px;
            text-transform:uppercase;
            letter-spacing:.08em;
            color:#6a6d70;
            border-bottom:1px solid #edf0f2;
        }

        .sap-table td{
            padding:14px 16px;
            border-bottom:1px solid #edf0f2;
            font-size:13px;
            color:#32363a;
        }

        .sap-table tbody tr:hover{
            background:#f8fbff;
        }

        @media(max-width:768px){

            .sap-container{
                padding:16px;
            }

            .sap-title{
                font-size:22px;
            }

            .sap-kpi-value{
                font-size:30px;
            }
        }
    </style>

    <div class="sap-page">

        <div class="sap-container space-y-5">

            {{-- PAGE HEADER --}}
            <div class="sap-header">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">

                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white p-2 ring-1 ring-slate-200">
                            <img src="{{ asset('images/proenergi-logo.png') }}"
                                 class="h-full w-full object-contain">
                        </div>

                        <div>
                            <div class="sap-breadcrumb">
                                Asset Management / Dashboard
                            </div>

                            <h1 class="sap-title">
                                Asset Management Overview
                            </h1>

                            <p class="sap-subtitle">
                                Enterprise Asset Lifecycle Management · SAP Fiori Concept
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('assets.index') }}" class="sap-btn">
                            Asset List
                        </a>

                        <a href="{{ route('assets.create') }}" class="sap-btn sap-btn-primary">
                            Create Asset
                        </a>
                    </div>

                </div>
            </div>

            {{-- SMART FILTER BAR --}}
            <div class="sap-filterbar">

                <div class="sap-filter-header">
                    <div class="sap-filter-title">
                        Smart Filter Bar
                    </div>

                    <div class="sap-filter-desc">
                        Filter operational asset, maintenance, work order, dan monitoring dashboard.
                    </div>
                </div>

                <div class="sap-filter-body">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wide text-slate-500">
                                Search
                            </label>

                            <input type="text"
                                   class="sap-input"
                                   placeholder="Search asset / WO / PM">
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wide text-slate-500">
                                Location
                            </label>

                            <select class="sap-input">
                                <option>All Location</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wide text-slate-500">
                                Category
                            </label>

                            <select class="sap-input">
                                <option>All Category</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-wide text-slate-500">
                                Lifecycle
                            </label>

                            <select class="sap-input">
                                <option>All Lifecycle</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button class="sap-btn sap-btn-primary w-full">
                                Apply Filter
                            </button>
                        </div>

                    </div>

                </div>

            </div>

            {{-- KPI --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-6">

                <div class="sap-kpi" style="--sap-color:#0a6ed1">
                    <div class="sap-kpi-body">
                        <div class="sap-kpi-label">Total Asset</div>
                        <div class="sap-kpi-value">
                            {{ $summary['total_assets'] ?? 0 }}
                        </div>
                        <div class="sap-kpi-footer">
                            Registered Asset
                        </div>
                    </div>
                </div>

                <div class="sap-kpi" style="--sap-color:#107e3e">
                    <div class="sap-kpi-body">
                        <div class="sap-kpi-label">Assigned</div>
                        <div class="sap-kpi-value">
                            {{ $summary['assigned_assets'] ?? 0 }}
                        </div>
                        <div class="sap-kpi-footer">
                            In Use
                        </div>
                    </div>
                </div>

                <div class="sap-kpi" style="--sap-color:#e9730c">
                    <div class="sap-kpi-body">
                        <div class="sap-kpi-label">PM Due</div>
                        <div class="sap-kpi-value">
                            {{ $pmSummary['due_today'] ?? 0 }}
                        </div>
                        <div class="sap-kpi-footer">
                            Due Today
                        </div>
                    </div>
                </div>

                <div class="sap-kpi" style="--sap-color:#bb0000">
                    <div class="sap-kpi-body">
                        <div class="sap-kpi-label">Overdue</div>
                        <div class="sap-kpi-value">
                            {{ $pmSummary['overdue'] ?? 0 }}
                        </div>
                        <div class="sap-kpi-footer">
                            Need Attention
                        </div>
                    </div>
                </div>

                <div class="sap-kpi" style="--sap-color:#925ace">
                    <div class="sap-kpi-body">
                        <div class="sap-kpi-label">WO Open</div>
                        <div class="sap-kpi-value">
                            {{ $woSummary['open'] ?? 0 }}
                        </div>
                        <div class="sap-kpi-footer">
                            Active Work Orders
                        </div>
                    </div>
                </div>

                <div class="sap-kpi" style="--sap-color:#d20a0a">
                    <div class="sap-kpi-body">
                        <div class="sap-kpi-label">Low Stock</div>
                        <div class="sap-kpi-value">
                            {{ $sparepartSummary['low_stock'] ?? 0 }}
                        </div>
                        <div class="sap-kpi-footer">
                            Sparepart Critical
                        </div>
                    </div>
                </div>

            </div>

            {{-- ANALYTICS --}}
            <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">

                <div class="sap-card overflow-hidden">
                    <div class="sap-card-header">
                        <div class="sap-card-title">
                            Asset Lifecycle Distribution
                        </div>

                        <div class="sap-card-desc">
                            Lifecycle monitoring analysis
                        </div>
                    </div>

                    <div class="p-5">
                        <canvas id="assetStatusChart" height="240"></canvas>
                    </div>
                </div>

                <div class="sap-card overflow-hidden">
                    <div class="sap-card-header">
                        <div class="sap-card-title">
                            Work Order Monitoring
                        </div>

                        <div class="sap-card-desc">
                            WO operational monitoring
                        </div>
                    </div>

                    <div class="p-5">
                        <canvas id="woStatusChart" height="240"></canvas>
                    </div>
                </div>

                <div class="sap-card overflow-hidden">
                    <div class="sap-card-header">
                        <div class="sap-card-title">
                            Asset by Category
                        </div>

                        <div class="sap-card-desc">
                            Asset distribution analysis
                        </div>
                    </div>

                    <div class="p-5">
                        <canvas id="categoryChart" height="240"></canvas>
                    </div>
                </div>

            </div>

            {{-- EXCEPTION MONITORING --}}
            <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">

                {{-- OVERDUE --}}
                <div class="sap-card overflow-hidden">

                    <div class="sap-card-header">
                        <div class="sap-card-title">
                            Overdue Maintenance
                        </div>

                        <div class="sap-card-desc">
                            Maintenance schedule overdue
                        </div>
                    </div>

                    <div class="sap-worklist">

                        @forelse($overdueSchedules as $schedule)

                            <a href="{{ route('assets.schedules.show', $schedule) }}"
                               class="sap-work-item">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <div class="sap-work-title">
                                            {{ $schedule->schedule_name }}
                                        </div>

                                        <div class="sap-work-sub">
                                            {{ $schedule->asset->asset_code ?? '-' }}
                                        </div>
                                    </div>

                                    <span class="sap-badge sap-badge-danger">
                                        OVERDUE
                                    </span>

                                </div>

                            </a>

                        @empty

                            <div class="text-sm text-slate-500">
                                No overdue maintenance.
                            </div>

                        @endforelse

                    </div>

                </div>

                {{-- UPCOMING --}}
                <div class="sap-card overflow-hidden">

                    <div class="sap-card-header">
                        <div class="sap-card-title">
                            Upcoming Maintenance
                        </div>

                        <div class="sap-card-desc">
                            Next maintenance execution
                        </div>
                    </div>

                    <div class="sap-worklist">

                        @forelse($upcomingSchedules as $schedule)

                            <a href="{{ route('assets.schedules.show', $schedule) }}"
                               class="sap-work-item">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <div class="sap-work-title">
                                            {{ $schedule->schedule_name }}
                                        </div>

                                        <div class="sap-work-sub">
                                            {{ $schedule->asset->asset_code ?? '-' }}
                                        </div>
                                    </div>

                                    <span class="sap-badge sap-badge-primary">
                                        UPCOMING
                                    </span>

                                </div>

                            </a>

                        @empty

                            <div class="text-sm text-slate-500">
                                No upcoming maintenance.
                            </div>

                        @endforelse

                    </div>

                </div>

                {{-- OPEN WO --}}
                <div class="sap-card overflow-hidden">

                    <div class="sap-card-header">
                        <div class="sap-card-title">
                            Open Work Orders
                        </div>

                        <div class="sap-card-desc">
                            Work order operational monitoring
                        </div>
                    </div>

                    <div class="sap-worklist">

                        @forelse($openWorkOrders as $wo)

                            <a href="{{ route('assets.work-orders.show', $wo) }}"
                               class="sap-work-item">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <div class="sap-work-title">
                                            {{ $wo->work_order_no }}
                                        </div>

                                        <div class="sap-work-sub">
                                            {{ $wo->asset->asset_code ?? '-' }}
                                        </div>
                                    </div>

                                    <span class="sap-badge sap-badge-warning">
                                        OPEN
                                    </span>

                                </div>

                            </a>

                        @empty

                            <div class="text-sm text-slate-500">
                                No open work orders.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="sap-card overflow-hidden">

                <div class="sap-card-header">
                    <div class="sap-card-title">
                        Latest Registered Assets
                    </div>

                    <div class="sap-card-desc">
                        Recently created enterprise assets
                    </div>
                </div>

                <div class="overflow-x-auto">

                    <table class="sap-table">

                        <thead>
                            <tr>
                                <th>Asset Code</th>
                                <th>Asset Name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($latestAssets as $asset)

                                <tr>

                                    <td>
                                        <a href="{{ route('assets.show', $asset) }}"
                                           class="font-black text-[#0a6ed1]">
                                            {{ $asset->asset_code }}
                                        </a>
                                    </td>

                                    <td>
                                        {{ $asset->asset_name }}
                                    </td>

                                    <td>
                                        {{ $asset->category->name ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $asset->location->name ?? '-' }}
                                    </td>

                                    <td>
                                        <span class="sap-badge sap-badge-success">
                                            {{ ucfirst($asset->lifecycle_status) }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center text-slate-500">
                                        No assets found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</x-app-layout>