<x-app-layout>
    <style>
        .sap-page {
            background: #f5f6f7;
            min-height: 100vh;
            color: #32363a;
        }

        .sap-container {
            width: 100%;
            padding: 24px 40px;
        }

        .sap-card {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
        }

        .sap-header {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
        }

        .sap-breadcrumb {
            font-size: 12px;
            color: #6a6d70;
            margin-bottom: 6px;
        }

        .sap-title {
            font-size: 28px;
            font-weight: 900;
            color: #32363a;
            line-height: 1.2;
        }

        .sap-subtitle {
            margin-top: 6px;
            font-size: 13px;
            color: #6a6d70;
            line-height: 1.6;
        }

        .sap-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 0 16px;
            border-radius: 8px;
            border: 1px solid #c9cdd1;
            background: #ffffff;
            color: #32363a;
            font-size: 13px;
            font-weight: 800;
            transition: .15s;
            white-space: nowrap;
        }

        .sap-btn:hover {
            background: #f5f6f7;
        }

        .sap-btn-primary {
            background: #0a6ed1;
            border-color: #0a6ed1;
            color: #ffffff;
        }

        .sap-btn-primary:hover {
            background: #085caf;
        }

        .sap-btn-dark {
            background: #354a5f;
            border-color: #354a5f;
            color: #ffffff;
        }

        .sap-btn-success {
            background: #107e3e;
            border-color: #107e3e;
            color: #ffffff;
        }

        .sap-btn-warning {
            background: #e9730c;
            border-color: #e9730c;
            color: #ffffff;
        }

        .sap-btn-danger {
            background: #bb0000;
            border-color: #bb0000;
            color: #ffffff;
        }

        .sap-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 900;
            border: 1px solid #d9d9d9;
            background: #f5f6f7;
            color: #354a5f;
        }

        .sap-section-header {
            border-bottom: 1px solid #edf0f2;
            background: #f5f6f7;
            padding: 16px 20px;
        }

        .sap-section-title {
            font-size: 16px;
            font-weight: 900;
            color: #32363a;
        }

        .sap-section-desc {
            margin-top: 3px;
            font-size: 13px;
            color: #6a6d70;
        }

        .sap-kpi {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            padding: 18px;
            position: relative;
            overflow: hidden;
        }

        .sap-kpi::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: var(--sap-color);
        }

        .sap-kpi-label {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #6a6d70;
        }

        .sap-kpi-value {
            margin-top: 10px;
            font-size: 24px;
            font-weight: 900;
            color: #32363a;
        }

        .sap-kpi-desc {
            margin-top: 4px;
            font-size: 12px;
            color: #6a6d70;
        }

        .sap-info-box {
            border: 1px solid #edf0f2;
            background: #ffffff;
            border-radius: 10px;
            padding: 14px;
        }

        .sap-info-label {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #6a6d70;
        }

        .sap-info-value {
            margin-top: 6px;
            font-size: 13px;
            font-weight: 800;
            color: #32363a;
            word-break: break-word;
        }

        .sap-badge {
            display: inline-flex;
            border-radius: 999px;
            padding: 6px 11px;
            font-size: 11px;
            font-weight: 900;
            line-height: 1;
            border: 1px solid transparent;
        }

        .sap-input,
        .sap-select,
        .sap-textarea {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #c9cdd1;
            background: #ffffff;
            font-size: 13px;
            color: #32363a;
            box-shadow: none;
        }

        .sap-input,
        .sap-select {
            height: 40px;
        }

        .sap-textarea {
            min-height: 80px;
        }

        .sap-input:focus,
        .sap-select:focus,
        .sap-textarea:focus {
            border-color: #0a6ed1;
            box-shadow: 0 0 0 3px rgba(10,110,209,.15);
        }

        .sap-label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 900;
            color: #32363a;
        }

        .sap-list-item {
            border: 1px solid #edf0f2;
            background: #ffffff;
            border-radius: 12px;
            padding: 14px;
        }

        .sap-empty {
            border: 1px dashed #c9cdd1;
            background: #fafafa;
            border-radius: 12px;
            padding: 32px 16px;
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            color: #6a6d70;
        }

        .sap-sidebar-sticky {
            position: sticky;
            top: 88px;
        }

        @media (max-width: 768px) {
            .sap-container {
                padding: 16px;
            }

            .sap-title {
                font-size: 22px;
            }

            .sap-sidebar-sticky {
                position: static;
            }
        }
    </style>

    @php
        $lifeClass = match($asset->lifecycle_status) {
            'in_stock' => 'background:#eef2f5;color:#354a5f;border-color:#d9d9d9;',
            'assigned' => 'background:#eaf3ff;color:#0a6ed1;border-color:#b8d8f4;',
            'maintenance' => 'background:#fff0e0;color:#e9730c;border-color:#ffc48c;',
            'disposed' => 'background:#ffeaea;color:#bb0000;border-color:#f5b5b5;',
            'lost' => 'background:#ffeaf2;color:#c2185b;border-color:#f7b5cc;',
            default => 'background:#eef2f5;color:#354a5f;border-color:#d9d9d9;',
        };

        $conditionClass = match($asset->condition_status) {
            'good' => 'background:#e4f5e9;color:#107e3e;border-color:#bfe6c8;',
            'fair' => 'background:#fff4ce;color:#8a6d00;border-color:#f5d76e;',
            'damaged' => 'background:#ffeaea;color:#bb0000;border-color:#f5b5b5;',
            'repair' => 'background:#fff0e0;color:#e9730c;border-color:#ffc48c;',
            'disposed' => 'background:#eef2f5;color:#354a5f;border-color:#d9d9d9;',
            default => 'background:#eef2f5;color:#354a5f;border-color:#d9d9d9;',
        };

        $assetTypeLabel = match($asset->asset_type ?? '') {
            'it_device' => 'IT Device',
            'network_device' => 'Network Device',
            'office_equipment' => 'Office Equipment',
            'office_vehicle' => 'Mobil Operasional Kantor',
            'ga_facility' => 'GA Facility',
            'building_equipment' => 'Building Equipment',
            'truck_tank' => 'Truck Tangki',
            'forklift' => 'Forklift',
            'fleet_vehicle' => 'Fleet Vehicle',
            default => '-',
        };

        $photo = $asset->documents->firstWhere('document_type', 'photo');

        $isVehicleAsset = in_array($asset->asset_type, [
            'office_vehicle',
            'truck_tank',
            'forklift',
            'fleet_vehicle',
        ]);

        $isFacilityAsset = in_array($asset->asset_type, [
            'ga_facility',
            'building_equipment',
            'office_equipment',
        ]);

        $isItAsset = in_array($asset->asset_type, [
            'it_device',
            'network_device',
        ]);

        $warrantyDays = $asset->warranty_end_date
            ? now()->diffInDays($asset->warranty_end_date, false)
            : null;
    @endphp

    <div class="sap-page">
        <div class="sap-container space-y-5">
            <x-flash-message />

            {{-- HEADER --}}
            <div class="sap-header p-5">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                    <div class="min-w-0">
                        <div class="sap-breadcrumb">
                            Asset Management / Asset Master / Detail
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <span class="sap-chip">{{ $asset->asset_code }}</span>
                            <span class="sap-chip">{{ $asset->category->name ?? '-' }}</span>
                            <span class="sap-chip">{{ $assetTypeLabel }}</span>
                        </div>

                        <h1 class="sap-title mt-4">
                            {{ $asset->asset_name }}
                        </h1>

                        <p class="sap-subtitle max-w-4xl">
                            Kelola status aset, assignment user, histori maintenance, dokumen pendukung,
                            QR tracking, dan lifecycle asset dalam satu halaman enterprise.
                        </p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="sap-badge" style="{{ $lifeClass }}">
                                Lifecycle: {{ ucfirst(str_replace('_', ' ', $asset->lifecycle_status)) }}
                            </span>

                            <span class="sap-badge" style="{{ $conditionClass }}">
                                Condition: {{ ucfirst($asset->condition_status) }}
                            </span>

                            <span class="sap-chip">
                                Holder: {{ $asset->activeAssignment?->user?->name ?? 'Belum diassign' }}
                            </span>

                            <span class="sap-chip">
                                Owner: {{ $asset->owner_role ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 xl:justify-end">
                        <a href="{{ route('assets.edit', $asset) }}" class="sap-btn sap-btn-primary">
                            Edit Asset
                        </a>

                        <a href="{{ route('assets.qr', $asset) }}" class="sap-btn">
                            QR Code
                        </a>

                        @if($asset->qr_code)
                            <a href="{{ route('assets.scan.public', $asset->qr_code) }}" target="_blank" class="sap-btn">
                                Public Scan
                            </a>
                        @endif

                        <a href="{{ route('assets.qr-sticker', $asset) }}" target="_blank" class="sap-btn">
                            Print Sticker
                        </a>

                        <a href="{{ route('assets.index') }}" class="sap-btn">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- KPI --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                <div class="sap-kpi" style="--sap-color:#0a6ed1">
                    <div class="sap-kpi-label">Owner</div>
                    <div class="sap-kpi-value">{{ $asset->owner_role ?? '-' }}</div>
                    <div class="sap-kpi-desc">Department Asset Owner</div>
                </div>

                <div class="sap-kpi" style="--sap-color:#354a5f">
                    <div class="sap-kpi-label">Asset Type</div>
                    <div class="sap-kpi-value text-lg">{{ $assetTypeLabel }}</div>
                    <div class="sap-kpi-desc">Jenis asset</div>
                </div>

                <div class="sap-kpi" style="--sap-color:#e9730c">
                    <div class="sap-kpi-label">Warranty</div>
                    <div class="sap-kpi-value">{{ is_null($warrantyDays) ? '-' : $warrantyDays }}</div>
                    <div class="sap-kpi-desc">Hari menuju expired</div>
                </div>

                <div class="sap-kpi" style="--sap-color:#107e3e">
                    <div class="sap-kpi-label">Maintenance</div>
                    <div class="sap-kpi-value">{{ $asset->maintenances->count() }}</div>
                    <div class="sap-kpi-desc">Histori maintenance</div>
                </div>

                <div class="sap-kpi" style="--sap-color:#6a6d70">
                    <div class="sap-kpi-label">Documents</div>
                    <div class="sap-kpi-value">{{ $asset->documents->count() }}</div>
                    <div class="sap-kpi-desc">Attached files</div>
                </div>
            </div>

            {{-- BASIC SUMMARY --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="sap-card p-4">
                    <div class="sap-info-label">Lokasi</div>
                    <div class="sap-info-value">{{ $asset->location->name ?? '-' }}</div>
                    <div class="mt-1 text-xs text-slate-500">Posisi aset saat ini</div>
                </div>

                <div class="sap-card p-4">
                    <div class="sap-info-label">Pemegang Aktif</div>
                    <div class="sap-info-value">{{ $asset->activeAssignment?->user?->name ?? '-' }}</div>
                    <div class="mt-1 text-xs text-slate-500">User yang sedang menggunakan</div>
                </div>

                <div class="sap-card p-4">
                    <div class="sap-info-label">Lifecycle</div>
                    <div class="mt-2">
                        <span class="sap-badge" style="{{ $lifeClass }}">
                            {{ ucfirst(str_replace('_', ' ', $asset->lifecycle_status)) }}
                        </span>
                    </div>
                    <div class="mt-2 text-xs text-slate-500">Status operasional aset</div>
                </div>

                <div class="sap-card p-4">
                    <div class="sap-info-label">Condition</div>
                    <div class="mt-2">
                        <span class="sap-badge" style="{{ $conditionClass }}">
                            {{ ucfirst($asset->condition_status) }}
                        </span>
                    </div>
                    <div class="mt-2 text-xs text-slate-500">Kondisi fisik / teknis</div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 xl:grid-cols-3">
                {{-- LEFT --}}
                <div class="space-y-5 xl:col-span-2">

                    {{-- INFORMASI UTAMA --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Informasi Utama</h3>
                            <p class="sap-section-desc">Data master dan referensi integrasi asset.</p>
                        </div>

                        @if($photo)
                            <div class="border-b border-slate-100 p-5">
                                <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                                         alt="{{ $asset->asset_name }}"
                                         class="max-h-[460px] w-full object-contain bg-slate-100 p-4">
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 gap-3 p-5 md:grid-cols-2">
                            @php
                                $infoItems = [
                                    ['label' => 'Brand', 'value' => $asset->brand ?? '-'],
                                    ['label' => 'Model', 'value' => $asset->model ?? '-'],
                                    ['label' => 'Serial Number', 'value' => $asset->serial_number ?? '-'],
                                    ['label' => 'QR Code', 'value' => $asset->qr_code ?? '-'],
                                    ['label' => 'Asset Type', 'value' => $assetTypeLabel],
                                    ['label' => 'Departemen Pemilik', 'value' => $asset->owner_role ?? '-'],
                                    ['label' => 'Lokasi', 'value' => $asset->location->name ?? '-'],
                                    ['label' => 'Pemegang Aktif', 'value' => $asset->activeAssignment?->user?->name ?? '-'],
                                    ['label' => 'Purchase Date', 'value' => $asset->purchase_date?->format('d M Y') ?? '-'],
                                    ['label' => 'Received Date', 'value' => $asset->received_date?->format('d M Y') ?? '-'],
                                    ['label' => 'Warranty Start', 'value' => $asset->warranty_start_date?->format('d M Y') ?? '-'],
                                    ['label' => 'Warranty End', 'value' => $asset->warranty_end_date?->format('d M Y') ?? '-'],
                                    ['label' => 'SYOP PR No', 'value' => $asset->syop_pr_no ?? '-'],
                                    ['label' => 'SYOP PO No', 'value' => $asset->syop_po_no ?? '-'],
                                ];
                            @endphp

                            @foreach($infoItems as $item)
                                <div class="sap-info-box">
                                    <div class="sap-info-label">{{ $item['label'] }}</div>
                                    <div class="sap-info-value">{{ $item['value'] }}</div>
                                </div>
                            @endforeach

                            <div class="sap-info-box md:col-span-2">
                                <div class="sap-info-label">Accurate Asset ID</div>
                                <div class="sap-info-value">{{ $asset->accurate_asset_id ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box md:col-span-2">
                                <div class="sap-info-label">Description</div>
                                <div class="mt-2 text-sm leading-7 text-slate-700">{{ $asset->description ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box md:col-span-2">
                                <div class="sap-info-label">Notes</div>
                                <div class="mt-2 text-sm leading-7 text-slate-700">{{ $asset->notes ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- IT INFO --}}
                    @if($isItAsset)
                        <div class="sap-card overflow-hidden">
                            <div class="sap-section-header">
                                <h3 class="sap-section-title">Informasi IT Asset</h3>
                                <p class="sap-section-desc">Informasi tambahan perangkat IT / network.</p>
                            </div>

                            <div class="grid grid-cols-1 gap-3 p-5 md:grid-cols-2">
                                <div class="sap-info-box">
                                    <div class="sap-info-label">IP Address</div>
                                    <div class="sap-info-value">{{ $asset->ip_address ?? '-' }}</div>
                                </div>

                                <div class="sap-info-box">
                                    <div class="sap-info-label">Hostname</div>
                                    <div class="sap-info-value">{{ $asset->hostname ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- VEHICLE INFO --}}
                    @if($isVehicleAsset)
                        <div class="sap-card overflow-hidden">
                            <div class="sap-section-header">
                                <h3 class="sap-section-title">Informasi Kendaraan / Fleet</h3>
                                <p class="sap-section-desc">Untuk mobil operasional GA, truck tangki, forklift, dan kendaraan logistik.</p>
                            </div>

                            <div class="grid grid-cols-1 gap-3 p-5 md:grid-cols-2 xl:grid-cols-3">
                                @php
                                    $vehicleItems = [
                                        ['label' => 'No Polisi', 'value' => $asset->plate_number ?? '-'],
                                        ['label' => 'No Mesin', 'value' => $asset->engine_number ?? '-'],
                                        ['label' => 'No Rangka', 'value' => $asset->chassis_number ?? '-'],
                                        ['label' => 'Kapasitas', 'value' => ($asset->capacity ? $asset->capacity . ' ' . ($asset->capacity_unit ?? '') : '-')],
                                        ['label' => 'Fuel Type', 'value' => $asset->fuel_type ?? '-'],
                                        ['label' => 'Odometer', 'value' => $asset->odometer ? number_format($asset->odometer, 0, ',', '.') . ' KM' : '-'],
                                        ['label' => 'STNK Expired', 'value' => $asset->stnk_expired_date?->format('d M Y') ?? '-'],
                                        ['label' => 'KIR Expired', 'value' => $asset->kir_expired_date?->format('d M Y') ?? '-'],
                                        ['label' => 'Insurance Expired', 'value' => $asset->insurance_expired_date?->format('d M Y') ?? '-'],
                                        ['label' => 'Service Interval KM', 'value' => $asset->service_interval_km ? number_format($asset->service_interval_km, 0, ',', '.') . ' KM' : '-'],
                                        ['label' => 'Last Service Date', 'value' => $asset->last_service_date?->format('d M Y') ?? '-'],
                                        ['label' => 'Next Service Date', 'value' => $asset->next_service_date?->format('d M Y') ?? '-'],
                                    ];
                                @endphp

                                @foreach($vehicleItems as $item)
                                    <div class="sap-info-box">
                                        <div class="sap-info-label">{{ $item['label'] }}</div>
                                        <div class="sap-info-value">{{ $item['value'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- FACILITY INFO --}}
                    @if($isFacilityAsset)
                        <div class="sap-card overflow-hidden">
                            <div class="sap-section-header">
                                <h3 class="sap-section-title">Informasi Facility / GA</h3>
                                <p class="sap-section-desc">Informasi area facility, lantai, dan ruangan.</p>
                            </div>

                            <div class="grid grid-cols-1 gap-3 p-5 md:grid-cols-3">
                                <div class="sap-info-box">
                                    <div class="sap-info-label">Area Facility</div>
                                    <div class="sap-info-value">{{ $asset->facility_area ?? '-' }}</div>
                                </div>

                                <div class="sap-info-box">
                                    <div class="sap-info-label">Lantai</div>
                                    <div class="sap-info-value">{{ $asset->floor ?? '-' }}</div>
                                </div>

                                <div class="sap-info-box">
                                    <div class="sap-info-label">Nama Ruangan</div>
                                    <div class="sap-info-value">{{ $asset->room_name ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ASSIGNMENT HISTORY --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Histori Assignment</h3>
                            <p class="sap-section-desc">Riwayat pemegang aset dari waktu ke waktu.</p>
                        </div>

                        <div class="space-y-3 p-5">
                            @forelse($asset->assignments as $assignment)
                                <div class="sap-list-item">
                                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                        <div>
                                            <div class="font-black text-slate-800">{{ $assignment->user->name ?? '-' }}</div>
                                            <div class="mt-1 text-sm text-slate-500">
                                                Assigned: {{ $assignment->assigned_date?->format('d M Y') ?? '-' }}
                                                @if($assignment->returned_date)
                                                    <span class="mx-1">•</span>
                                                    Returned: {{ $assignment->returned_date?->format('d M Y') }}
                                                @endif
                                            </div>

                                            @if($assignment->remarks)
                                                <div class="mt-2 text-sm text-slate-700">{{ $assignment->remarks }}</div>
                                            @endif
                                        </div>

                                        <span class="sap-badge" style="background:#eaf3ff;color:#0a6ed1;border-color:#b8d8f4;">
                                            {{ ucfirst($assignment->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="sap-empty">Belum ada histori assignment.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- WORK ORDER HISTORY --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Work Order History</h3>
                            <p class="sap-section-desc">Riwayat maintenance work order asset ini.</p>
                        </div>

                        <div class="space-y-3 p-5">
                            @forelse($asset->workOrders as $wo)
                                <a href="{{ route('assets.work-orders.show', $wo) }}" class="sap-list-item block hover:bg-blue-50">
                                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                        <div>
                                            <div class="text-xs font-black uppercase text-blue-700">
                                                {{ $wo->work_order_no }}
                                            </div>

                                            <div class="mt-1 font-black text-slate-800">
                                                {{ ucfirst($wo->maintenance_type) }} - {{ ucfirst($wo->priority) }}
                                            </div>

                                            <div class="mt-1 text-sm text-slate-500">
                                                {{ $wo->problem_description }}
                                            </div>

                                            <div class="mt-2 text-xs text-slate-400">
                                                Requester: {{ $wo->requester->name ?? '-' }}
                                                · Technician: {{ $wo->technician->name ?? '-' }}
                                                · Approver: {{ $wo->approver->name ?? '-' }}
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <span class="sap-badge" style="background:#eaf3ff;color:#0a6ed1;border-color:#b8d8f4;">
                                                {{ ucfirst(str_replace('_', ' ', $wo->status)) }}
                                            </span>

                                            <span class="sap-badge" style="background:#e4f5e9;color:#107e3e;border-color:#bfe6c8;">
                                                Rp {{ number_format($wo->actual_cost ?? 0, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="sap-empty">Belum ada work order history untuk asset ini.</div>
                            @endforelse
                        </div>
                    </div>

                    {{-- ACTIVITY LOG --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Activity Log</h3>
                            <p class="sap-section-desc">Jejak aktivitas aset untuk audit dan tracking operasional.</p>
                        </div>

                        <div class="space-y-3 p-5">
                            @forelse($asset->activityLogs as $log)
                                <div class="sap-list-item">
                                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                        <div class="min-w-0">
                                            <div class="font-black text-slate-800">{{ $log->title }}</div>
                                            <div class="mt-1 text-sm text-slate-600">{{ $log->description ?? '-' }}</div>
                                            <div class="mt-2 text-xs text-slate-400">
                                                Oleh: {{ $log->user->name ?? 'System' }}
                                            </div>
                                        </div>

                                        <div class="shrink-0 text-xs text-slate-400">
                                            {{ $log->created_at?->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="sap-empty">Belum ada activity log.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- RIGHT SIDEBAR --}}
                <div class="space-y-5">
                    {{-- QUICK ACTIONS --}}
                    <div class="sap-card sap-sidebar-sticky overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Quick Actions</h3>
                            <p class="sap-section-desc">Aksi cepat untuk pengelolaan asset.</p>
                        </div>

                        <div class="grid gap-2 p-5">
                            <a href="{{ route('assets.edit', $asset) }}" class="sap-btn sap-btn-primary w-full">
                                Edit Data Asset
                            </a>

                            <a href="{{ route('assets.work-orders.create', ['asset_id' => $asset->id]) }}" class="sap-btn sap-btn-success w-full">
                                Buat Work Order
                            </a>

                            <a href="{{ route('assets.qr', $asset) }}" class="sap-btn w-full">
                                Buka QR Code
                            </a>

                            <a href="{{ route('assets.qr-sticker', $asset) }}" target="_blank" class="sap-btn w-full">
                                Print QR Sticker
                            </a>

                            @if($asset->qr_code)
                                <a href="{{ route('assets.scan.public', $asset->qr_code) }}" target="_blank" class="sap-btn w-full">
                                    Public Scan
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- ASSIGN ASSET --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Assign Asset</h3>
                            <p class="sap-section-desc">Serahkan asset ke user tertentu.</p>
                        </div>

                        <div class="p-5">
                            @if($asset->activeAssignment)
                                <div class="sap-list-item text-sm text-slate-700">
                                    Asset sedang aktif dipegang oleh
                                    <span class="font-black">{{ $asset->activeAssignment?->user?->name ?? '-' }}</span>.
                                    Return asset terlebih dahulu sebelum assign ke user lain.
                                </div>
                            @else
                                <form method="POST" action="{{ route('assets.assignments.store', $asset) }}" class="space-y-4">
                                    @csrf

                                    <div>
                                        <label class="sap-label">Pilih User</label>
                                        <select name="user_id" class="sap-select">
                                            <option value="">-- Pilih User --</option>
                                            @foreach(\App\Models\User::orderBy('name')->get() as $user)
                                                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label class="sap-label">Assigned Date</label>
                                        <input type="date" name="assigned_date"
                                               value="{{ old('assigned_date', now()->format('Y-m-d')) }}"
                                               class="sap-input">
                                    </div>

                                    <div>
                                        <label class="sap-label">Expected Return Date</label>
                                        <input type="date" name="expected_return_date"
                                               value="{{ old('expected_return_date') }}"
                                               class="sap-input">
                                    </div>

                                    <div>
                                        <label class="sap-label">Remarks</label>
                                        <textarea name="remarks" rows="3"
                                                  class="sap-textarea"
                                                  placeholder="Catatan serah terima asset...">{{ old('remarks') }}</textarea>
                                    </div>

                                    <button type="submit" class="sap-btn sap-btn-primary w-full">
                                        Assign ke User
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- RETURN ASSET --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Return Asset</h3>
                            <p class="sap-section-desc">Tandai aset sudah dikembalikan.</p>
                        </div>

                        <div class="p-5">
                            @if(!$asset->activeAssignment)
                                <div class="sap-list-item text-sm text-slate-700">
                                    Saat ini tidak ada assignment aktif untuk asset ini.
                                </div>
                            @else
                                <form method="POST" action="{{ route('assets.assignments.return', $asset) }}" class="space-y-4">
                                    @csrf

                                    <div class="sap-list-item text-sm text-slate-700">
                                        Asset saat ini dipegang oleh
                                        <span class="font-black">{{ $asset->activeAssignment?->user?->name ?? '-' }}</span>.
                                    </div>

                                    <div>
                                        <label class="sap-label">Returned Date</label>
                                        <input type="date" name="returned_date"
                                               value="{{ old('returned_date', now()->format('Y-m-d')) }}"
                                               class="sap-input">
                                    </div>

                                    <div>
                                        <label class="sap-label">Next Status</label>
                                        <select name="next_status" class="sap-select">
                                            <option value="in_stock" @selected(old('next_status') == 'in_stock')>In Stock</option>
                                            <option value="maintenance" @selected(old('next_status') == 'maintenance')>Maintenance</option>
                                            <option value="disposed" @selected(old('next_status') == 'disposed')>Disposed</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="sap-label">Remarks</label>
                                        <textarea name="remarks" rows="3"
                                                  class="sap-textarea"
                                                  placeholder="Catatan pengembalian asset...">{{ old('remarks') }}</textarea>
                                    </div>

                                    <button type="submit" class="sap-btn sap-btn-warning w-full">
                                        Return Asset
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- DOCUMENTS --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Dokumen Asset</h3>
                            <p class="sap-section-desc">Upload invoice, photo, warranty, manual, dan dokumen lainnya.</p>
                        </div>

                        <div class="p-5">
                            <form method="POST" action="{{ route('assets.documents.store', $asset) }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf

                                <div>
                                    <label class="sap-label">Jenis Dokumen</label>
                                    <select name="document_type" class="sap-select">
                                        <option value="invoice">Invoice</option>
                                        <option value="photo">Photo</option>
                                        <option value="warranty">Warranty</option>
                                        <option value="manual">Manual</option>
                                        <option value="bast">BAST</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="sap-label">File</label>
                                    <input type="file"
                                           name="file"
                                           class="block w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 file:mr-4 file:rounded-md file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-black file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="mt-1 text-xs text-slate-500">
                                        Format: PDF, JPG, PNG, WEBP, DOC, DOCX, XLS, XLSX. Maks 5 MB.
                                    </p>
                                </div>

                                <div>
                                    <label class="sap-label">Notes</label>
                                    <textarea name="notes"
                                              rows="2"
                                              class="sap-textarea"
                                              placeholder="Catatan dokumen...">{{ old('notes') }}</textarea>
                                </div>

                                <button type="submit" class="sap-btn sap-btn-dark w-full">
                                    Upload Dokumen
                                </button>
                            </form>

                            <div class="mt-5 space-y-3">
                                @forelse($asset->documents as $document)
                                    <div class="sap-list-item">
                                        <div class="font-black text-slate-800">{{ $document->file_name }}</div>
                                        <div class="mt-1 text-sm text-slate-500">
                                            {{ strtoupper($document->document_type ?? 'document') }}
                                            @if($document->file_size)
                                                • {{ number_format($document->file_size / 1024, 1) }} KB
                                            @endif
                                        </div>

                                        @if($document->notes)
                                            <div class="mt-1 text-sm text-slate-600">{{ $document->notes }}</div>
                                        @endif

                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <a href="{{ asset('storage/' . $document->file_path) }}"
                                               target="_blank"
                                               class="sap-btn">
                                                Lihat
                                            </a>

                                            <form action="{{ route('assets.documents.destroy', [$asset, $document]) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="sap-btn sap-btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="sap-empty">Belum ada dokumen.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- METER READING --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Meter Reading</h3>
                            <p class="sap-section-desc">Input KM, hour meter, atau runtime asset.</p>
                        </div>

                        <div class="p-5">
                            <form method="POST"
                                  action="{{ route('assets.meter-readings.store', $asset) }}"
                                  class="grid grid-cols-1 gap-3">
                                @csrf

                                <select name="meter_type" class="sap-select">
                                    <option value="km">KM</option>
                                    <option value="hour_meter">Hour Meter</option>
                                    <option value="runtime">Runtime</option>
                                </select>

                                <input type="number"
                                       step="0.01"
                                       name="meter_value"
                                       placeholder="Meter Value"
                                       class="sap-input"
                                       required>

                                <input type="date"
                                       name="reading_date"
                                       value="{{ now()->format('Y-m-d') }}"
                                       class="sap-input"
                                       required>

                                <button class="sap-btn sap-btn-primary w-full">
                                    Simpan Meter
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- RELATED TICKETS --}}
                    <div class="sap-card overflow-hidden">
                        <div class="sap-section-header">
                            <h3 class="sap-section-title">Ticket Terkait</h3>
                            <p class="sap-section-desc">Histori ticket yang berhubungan dengan asset ini.</p>
                        </div>

                        <div class="space-y-3 p-5">
                            @forelse($asset->tickets as $ticket)
                                <div class="sap-list-item">
                                    <div class="font-black text-slate-800">#{{ $ticket->id }}</div>
                                    <div class="mt-1 text-sm text-slate-600">{{ $ticket->title ?? $ticket->subject ?? '-' }}</div>
                                </div>
                            @empty
                                <div class="sap-empty">Belum ada ticket terkait.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>