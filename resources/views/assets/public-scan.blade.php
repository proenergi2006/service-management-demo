<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Scan - {{ $asset->asset_code }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #f5f6f7;
            color: #32363a;
        }

        .sap-shell {
            min-height: 100vh;
            background: linear-gradient(180deg, #f5f6f7 0%, #eef1f4 100%);
        }

        .sap-container {
            width: 100%;
            max-width: 1120px;
            margin: 0 auto;
            padding: 24px;
        }

        .sap-header {
            background: #354a5f;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 10px 28px rgba(15,23,42,.18);
            overflow: hidden;
        }

        .sap-logo-box {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: #ffffff;
            padding: 9px;
            flex-shrink: 0;
        }

        .sap-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 900;
            border: 1px solid rgba(255,255,255,.18);
            background: rgba(255,255,255,.10);
            color: #ffffff;
        }

        .sap-card {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
            overflow: hidden;
        }

        .sap-section-header {
            background: #f5f6f7;
            border-bottom: 1px solid #edf0f2;
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

        .sap-info-box {
            border: 1px solid #edf0f2;
            background: #ffffff;
            border-radius: 10px;
            padding: 14px;
        }

        .sap-label {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #6a6d70;
        }

        .sap-value {
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

        .sap-photo-box {
            border: 1px solid #d9d9d9;
            background: #f5f6f7;
            border-radius: 14px;
            overflow: hidden;
        }

        .sap-empty-photo {
            height: 288px;
            border: 1px dashed #c9cdd1;
            background: #fafafa;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #6a6d70;
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

        .sap-footer-note {
            font-size: 12px;
            color: #6a6d70;
            text-align: center;
        }

        @media (max-width: 768px) {
            .sap-container {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    @php
        $photo = $asset->documents->firstWhere('document_type', 'photo') ?? null;

        $lifeClass = match($asset->lifecycle_status) {
            'in_stock' => 'background:#eef2f5;color:#354a5f;border-color:#d9d9d9;',
            'assigned' => 'background:#eaf3ff;color:#0a6ed1;border-color:#b8d8f4;',
            'borrowed' => 'background:#f0edff;color:#5b3fd1;border-color:#d5ccff;',
            'maintenance' => 'background:#fff0e0;color:#e9730c;border-color:#ffc48c;',
            'in_repair' => 'background:#fff0e0;color:#e9730c;border-color:#ffc48c;',
            'disposed' => 'background:#ffeaf2;color:#c2185b;border-color:#f7b5cc;',
            'lost' => 'background:#ffeaea;color:#bb0000;border-color:#f5b5b5;',
            'idle' => 'background:#eef2f5;color:#354a5f;border-color:#d9d9d9;',
            default => 'background:#eef2f5;color:#354a5f;border-color:#d9d9d9;',
        };

        $conditionClass = match($asset->condition_status) {
            'excellent' => 'background:#e4f5e9;color:#107e3e;border-color:#bfe6c8;',
            'good' => 'background:#e4f5e9;color:#107e3e;border-color:#bfe6c8;',
            'fair' => 'background:#fff4ce;color:#8a6d00;border-color:#f5d76e;',
            'broken' => 'background:#ffeaea;color:#bb0000;border-color:#f5b5b5;',
            'lost' => 'background:#ffeaf2;color:#c2185b;border-color:#f7b5cc;',
            default => 'background:#eef2f5;color:#354a5f;border-color:#d9d9d9;',
        };

        $lifeLabel = match($asset->lifecycle_status) {
            'in_stock' => 'Tersedia',
            'assigned' => 'Sedang Digunakan',
            'borrowed' => 'Dipinjam',
            'maintenance' => 'Dalam Maintenance',
            'in_repair' => 'Dalam Perbaikan',
            'disposed' => 'Sudah Disposisi',
            'lost' => 'Tidak Ditemukan',
            'idle' => 'Tidak Aktif',
            default => ucfirst(str_replace('_', ' ', $asset->lifecycle_status)),
        };

        $conditionLabel = match($asset->condition_status) {
            'excellent' => 'Sangat Baik',
            'good' => 'Baik',
            'fair' => 'Cukup',
            'broken' => 'Rusak',
            'lost' => 'Hilang',
            default => ucfirst($asset->condition_status),
        };

        $assignmentLabel = $asset->activeAssignment
            ? 'Sedang digunakan / dipegang user terkait'
            : 'Belum sedang di-assignment';
    @endphp

    <div class="sap-shell">
        <div class="sap-container space-y-5">

            {{-- SAP PUBLIC HEADER --}}
            <div class="sap-header">
                <div class="p-5 sm:p-6">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="sap-logo-box">
                                <img src="{{ asset('images/proenergi-logo.png') }}"
                                     alt="Pro Energi"
                                     class="h-full w-full object-contain">
                            </div>

                            <div>
                                <div class="text-[11px] font-black uppercase tracking-[0.14em] text-slate-300">
                                    PT Pro Energi
                                </div>

                                <h1 class="mt-1 text-2xl font-black text-white sm:text-3xl">
                                    Asset QR Scan
                                </h1>

                                <p class="mt-1 text-sm text-slate-300">
                                    Informasi ringkas asset untuk pengecekan, identifikasi, dan tracking internal.
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span class="sap-chip">{{ $asset->asset_code }}</span>
                            <span class="sap-chip">{{ $lifeLabel }}</span>
                            <span class="sap-chip">Public View</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ASSET OBJECT HEADER --}}
            <div class="sap-card">
                <div class="sap-section-header">
                    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                        <div>
                            <div class="text-xs font-black uppercase tracking-wide text-[#0a6ed1]">
                                {{ $asset->asset_code }}
                            </div>

                            <h2 class="mt-1 text-2xl font-black text-slate-800">
                                {{ $asset->asset_name }}
                            </h2>

                            <p class="sap-section-desc">
                                {{ $asset->category->category_name ?? '-' }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span class="sap-badge" style="{{ $lifeClass }}">
                                {{ $lifeLabel }}
                            </span>

                            <span class="sap-badge" style="{{ $conditionClass }}">
                                Kondisi: {{ $conditionLabel }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5">
                    {{-- PHOTO --}}
                    <div class="border-b border-slate-100 p-5 lg:col-span-2 lg:border-b-0 lg:border-r">
                        @if($photo)
                            <div class="sap-photo-box">
                                <img src="{{ asset('storage/' . $photo->file_path) }}"
                                     alt="{{ $asset->asset_name }}"
                                     class="h-72 w-full object-cover">
                            </div>
                        @else
                            <div class="sap-empty-photo">
                                <div>
                                    <div class="text-5xl">📦</div>
                                    <div class="mt-3 text-sm font-black text-slate-700">
                                        Foto asset belum tersedia
                                    </div>
                                    <div class="mt-1 text-xs text-slate-500">
                                        Silakan hubungi tim pengelola asset bila diperlukan.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- SUMMARY --}}
                    <div class="p-5 lg:col-span-3">
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div class="sap-info-box">
                                <div class="sap-label">Brand</div>
                                <div class="sap-value">{{ $asset->brand_name ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">Model</div>
                                <div class="sap-value">{{ $asset->model ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">Serial Number</div>
                                <div class="sap-value">{{ $asset->serial_number ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">QR Token</div>
                                <div class="sap-value">{{ $asset->qr_code_value ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">Tanggal Pembelian</div>
                                <div class="sap-value">
                                    {{ $asset->purchase_date?->format('d M Y') ?? '-' }}
                                </div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">Garansi Berakhir</div>
                                <div class="sap-value">
                                    {{ $asset->warranty_end_date?->format('d M Y') ?? '-' }}
                                </div>
                            </div>

                            <div class="sap-info-box sm:col-span-2">
                                <div class="sap-label">Lokasi Asset</div>
                                <div class="sap-value">
                                    {{ $asset->location->location_name ?? '-' }}
                                </div>

                                @if(!empty($asset->current_branch))
                                    <div class="mt-1 text-xs font-semibold text-slate-500">
                                        Cabang: {{ $asset->current_branch }}
                                    </div>
                                @endif
                            </div>

                            <div class="sap-info-box sm:col-span-2">
                                <div class="sap-label">Status Pemakaian</div>
                                <div class="sap-value">
                                    {{ $assignmentLabel }}
                                </div>

                                @if($asset->holder)
                                    <div class="mt-1 text-xs font-semibold text-slate-500">
                                        PIC / Holder saat ini: {{ $asset->holder->name }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STATUS --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="sap-card p-5">
                    <div class="sap-label">Lifecycle Status</div>
                    <div class="mt-3">
                        <span class="sap-badge" style="{{ $lifeClass }}">
                            {{ $lifeLabel }}
                        </span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Menunjukkan posisi atau kondisi operasional asset saat ini.
                    </p>
                </div>

                <div class="sap-card p-5">
                    <div class="sap-label">Condition Status</div>
                    <div class="mt-3">
                        <span class="sap-badge" style="{{ $conditionClass }}">
                            {{ $conditionLabel }}
                        </span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Menunjukkan kondisi fisik atau kelayakan penggunaan asset.
                    </p>
                </div>
            </div>

            {{-- DESCRIPTION / NOTES --}}
            @if($asset->description || $asset->notes)
                <div class="sap-card">
                    <div class="sap-section-header">
                        <h3 class="sap-section-title">
                            Informasi Tambahan
                        </h3>
                        <p class="sap-section-desc">
                            Deskripsi dan catatan asset.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 p-5">
                        @if($asset->description)
                            <div class="sap-info-box">
                                <div class="sap-label">Deskripsi</div>
                                <div class="mt-2 text-sm leading-7 text-slate-700">
                                    {{ $asset->description }}
                                </div>
                            </div>
                        @endif

                        @if($asset->notes)
                            <div class="sap-info-box">
                                <div class="sap-label">Catatan</div>
                                <div class="mt-2 text-sm leading-7 text-slate-700">
                                    {{ $asset->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- CTA --}}
            <div class="sap-card p-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="text-base font-black text-slate-800">
                            Butuh informasi lebih lanjut?
                        </div>

                        <div class="mt-1 text-sm leading-6 text-slate-500">
                            Silakan hubungi tim IT / Helpdesk untuk pengecekan lebih detail atau pelaporan kendala asset ini.
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @auth
                            <a href="{{ route('assets.show', $asset) }}" class="sap-btn sap-btn-primary">
                                Buka Detail Asset
                            </a>
                        @endauth

                        <a href="{{ route('welcome') }}" class="sap-btn">
                            Ke Helpdesk
                        </a>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="sap-footer-note">
                Powered by <span class="font-black text-[#0a6ed1]">Helpdesk Asset Lifecycle Management</span>
            </div>
        </div>
    </div>
</body>
</html>