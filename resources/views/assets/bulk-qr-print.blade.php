<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk QR Sticker Print</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            background: #f5f6f7;
            color: #32363a;
        }

        .sap-toolbar {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
        }

        .sap-breadcrumb {
            font-size: 12px;
            color: #6a6d70;
        }

        .sap-title {
            font-size: 24px;
            font-weight: 900;
            color: #32363a;
        }

        .sap-subtitle {
            font-size: 13px;
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

        .sap-empty {
            background: #ffffff;
            border: 1px dashed #c9cdd1;
            border-radius: 14px;
            padding: 40px;
            text-align: center;
            color: #6a6d70;
            font-size: 14px;
            font-weight: 700;
        }

        .sap-sticker {
            background: #ffffff;
            border: 1px solid #32363a;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, .10);
            overflow: hidden;
        }

        .sap-sticker-header {
            background: #354a5f;
            border-bottom: 3px solid #0a6ed1;
            color: #ffffff;
            padding: 9px 10px;
        }

        .sap-logo-box {
            width: 36px;
            height: 36px;
            border-radius: 7px;
            background: #ffffff;
            padding: 6px;
            flex-shrink: 0;
        }

        .sap-label {
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #6a6d70;
        }

        .sap-value {
            margin-top: 2px;
            font-size: 10px;
            font-weight: 800;
            color: #32363a;
            word-break: break-word;
        }

        .sap-qr-frame {
            border: 1px solid #d9d9d9;
            background: #ffffff;
            border-radius: 8px;
            padding: 8px;
            box-shadow: inset 0 0 0 4px #f5f6f7;
        }

        .sap-info-grid {
            background: #f5f6f7;
            border: 1px solid #d9d9d9;
            border-radius: 8px;
            overflow: hidden;
        }

        .sap-footer-note {
            border-top: 1px solid #edf0f2;
            background: #fafafa;
        }

        @media print {
            body {
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .sheet {
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
            }

            .sap-sticker {
                break-inside: avoid;
                page-break-inside: avoid;
                box-shadow: none !important;
            }

            .sap-sticker-grid {
                gap: 8mm !important;
            }
        }

        @media (max-width: 768px) {
            .sheet {
                padding: 16px !important;
            }

            .sap-sticker-grid {
                grid-template-columns: 1fr !important;
            }

            .sap-title {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="sheet mx-auto max-w-7xl px-4 py-6">

        {{-- TOOLBAR --}}
        <div class="sap-toolbar no-print mb-6 p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="sap-breadcrumb">
                        Asset Management / QR Sticker / Bulk Print
                    </div>

                    <h1 class="sap-title mt-1">
                        Bulk QR Sticker Print
                    </h1>

                    <p class="sap-subtitle mt-1">
                        Total asset: {{ $assets->count() }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="button"
                            onclick="window.print()"
                            class="sap-btn sap-btn-primary">
                        Print Sekarang
                    </button>

                    <a href="{{ route('assets.index') }}" class="sap-btn">
                        Kembali ke Asset
                    </a>
                </div>
            </div>
        </div>

        @if($assets->isEmpty())
            <div class="sap-empty">
                Tidak ada asset untuk dicetak.
            </div>
        @else
            <div class="sap-sticker-grid grid grid-cols-2 gap-4">
                @foreach($assets as $asset)
                    <div class="sap-sticker">

                        {{-- HEADER --}}
                        <div class="sap-sticker-header">
                            <div class="flex items-center gap-3">
                                <div class="sap-logo-box">
                                    <img src="{{ asset('images/proenergi-logo.png') }}"
                                         alt="Pro Energi"
                                         class="h-full w-full object-contain">
                                </div>

                                <div class="min-w-0">
                                    <div class="text-[9px] font-black uppercase tracking-[0.14em] text-slate-200">
                                        Enterprise Asset Tag
                                    </div>

                                    <div class="mt-0.5 text-xs font-black leading-tight text-white">
                                        PT. PRO ENERGI
                                    </div>

                                    <div class="text-[9px] font-semibold text-slate-300">
                                        Asset Lifecycle Management
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ASSET CODE --}}
                        <div class="px-4 pt-3 text-center">
                            <div class="sap-label">
                                Asset Code
                            </div>

                            <div class="mt-1 text-sm font-black tracking-wide text-[#0a6ed1]">
                                {{ $asset->asset_code }}
                            </div>
                        </div>

                        {{-- QR --}}
                        <div class="mt-3 flex justify-center px-4">
                            <div class="sap-qr-frame">
                                {!! QrCode::size(110)->generate(route('assets.scan.public', $asset->qr_code)) !!}
                            </div>
                        </div>

                        {{-- ASSET NAME --}}
                        <div class="px-4 pt-3 text-center">
                            <div class="line-clamp-2 text-xs font-black leading-snug text-slate-800">
                                {{ $asset->asset_name }}
                            </div>

                            <div class="mt-1 text-[10px] font-semibold text-slate-500">
                                {{ $asset->category->name ?? '-' }}
                            </div>
                        </div>

                        {{-- INFO --}}
                        <div class="px-4 py-3">
                            <div class="sap-info-grid grid grid-cols-2">
                                <div class="border-r border-[#d9d9d9] p-2">
                                    <div class="sap-label">Lokasi</div>
                                    <div class="sap-value line-clamp-2">
                                        {{ $asset->location->name ?? '-' }}
                                    </div>
                                </div>

                                <div class="p-2">
                                    <div class="sap-label">Serial</div>
                                    <div class="sap-value break-all">
                                        {{ $asset->serial_number ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="sap-footer-note px-4 py-2 text-center">
                            <div class="break-all text-[9px] font-bold text-slate-400">
                                {{ $asset->qr_code }}
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>