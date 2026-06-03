<x-app-layout>
    <style>
        .sap-page {
            min-height: 100vh;
            background: #f5f6f7;
            color: #32363a;
        }

        .sap-container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px 24px;
        }

        .sap-header {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
            padding: 20px;
        }

        .sap-breadcrumb {
            font-size: 12px;
            color: #6a6d70;
            margin-bottom: 6px;
        }

        .sap-title {
            font-size: 26px;
            font-weight: 900;
            color: #32363a;
        }

        .sap-subtitle {
            margin-top: 6px;
            font-size: 13px;
            color: #6a6d70;
        }

        .sap-card {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
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

        .sap-qr-box {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            padding: 18px;
            box-shadow: inset 0 0 0 6px #f5f6f7;
        }

        .sap-info-box {
            border: 1px solid #edf0f2;
            background: #ffffff;
            border-radius: 10px;
            padding: 12px 14px;
        }

        .sap-label {
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #6a6d70;
        }

        .sap-value {
            margin-top: 5px;
            font-size: 13px;
            font-weight: 800;
            color: #32363a;
            word-break: break-word;
        }

        .sap-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 900;
            border: 1px solid #b8d8f4;
            background: #eaf3ff;
            color: #0a6ed1;
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

        @media print {
            body * {
                visibility: hidden;
            }

            .sap-print-area,
            .sap-print-area * {
                visibility: visible;
            }

            .sap-print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 24px;
            }

            .sap-no-print {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .sap-container {
                padding: 16px;
            }

            .sap-title {
                font-size: 22px;
            }
        }
    </style>

    <div class="sap-page">
        <div class="sap-container space-y-5">

            {{-- HEADER --}}
            <div class="sap-header sap-no-print">
                <div class="sap-breadcrumb">
                    Asset Management / Asset Master / QR Code
                </div>

                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <h1 class="sap-title">
                            QR Code Asset
                        </h1>

                        <p class="sap-subtitle">
                            Scan QR untuk melihat informasi ringkas asset melalui halaman public scan.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('assets.show', $asset) }}" class="sap-btn">
                            Lihat Detail Asset
                        </a>

                        <button type="button" onclick="window.print()" class="sap-btn sap-btn-primary">
                            Print QR
                        </button>
                    </div>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="sap-card sap-print-area overflow-hidden">
                <div class="sap-section-header">
                    <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="sap-section-title">
                                Asset QR Identity
                            </h3>

                            <p class="sap-section-desc">
                                QR token terhubung ke halaman public asset scan.
                            </p>
                        </div>

                        <span class="sap-chip">
                            {{ $asset->asset_code }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 p-6 md:grid-cols-2 md:items-center">
                    {{-- QR --}}
                    <div class="flex justify-center">
                        <div class="sap-qr-box">
                            {!! QrCode::size(220)->generate(route('assets.scan.public', $asset->qr_code)) !!}
                        </div>
                    </div>

                    {{-- DETAIL --}}
                    <div>
                        <div class="text-xs font-black uppercase tracking-wide text-slate-500">
                            Asset Code
                        </div>

                        <h2 class="mt-2 text-2xl font-black text-[#32363a]">
                            {{ $asset->asset_name }}
                        </h2>

                        <div class="mt-1 text-sm font-bold text-[#0a6ed1]">
                            {{ $asset->asset_code }}
                        </div>

                        <div class="mt-5 grid grid-cols-1 gap-3">
                            <div class="sap-info-box">
                                <div class="sap-label">Kategori</div>
                                <div class="sap-value">{{ $asset->category->name ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">Lokasi</div>
                                <div class="sap-value">{{ $asset->location->name ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">Pemegang</div>
                                <div class="sap-value">{{ $asset->activeAssignment?->user?->name ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">Serial Number</div>
                                <div class="sap-value">{{ $asset->serial_number ?? '-' }}</div>
                            </div>

                            <div class="sap-info-box">
                                <div class="sap-label">QR Token</div>
                                <div class="sap-value">{{ $asset->qr_code ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="sap-no-print mt-6 flex flex-wrap gap-2">
                            <a href="{{ route('assets.show', $asset) }}" class="sap-btn sap-btn-primary">
                                Lihat Detail Asset
                            </a>

                            <button type="button" onclick="window.print()" class="sap-btn">
                                Print QR
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>