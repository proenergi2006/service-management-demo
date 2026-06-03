<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Sticker - {{ $asset->asset_code }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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

        .sap-sticker-card {
            width: 340px;
            background: #ffffff;
            border: 1px solid #32363a;
            border-radius: 10px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .15);
            overflow: hidden;
        }

        .sap-sticker-header {
            background: #354a5f;
            color: #ffffff;
            padding: 12px 14px;
            border-bottom: 4px solid #0a6ed1;
        }

        .sap-logo-box {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #ffffff;
            padding: 7px;
            flex-shrink: 0;
        }

        .sap-label {
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #6a6d70;
        }

        .sap-value {
            margin-top: 3px;
            font-size: 12px;
            font-weight: 800;
            color: #32363a;
            word-break: break-word;
        }

        .sap-qr-frame {
            border: 1px solid #d9d9d9;
            background: #ffffff;
            border-radius: 8px;
            padding: 10px;
            box-shadow: inset 0 0 0 5px #f5f6f7;
        }

        .sap-info-grid {
            background: #f5f6f7;
            border: 1px solid #d9d9d9;
            border-radius: 8px;
        }

        .sap-footer-note {
            border-top: 1px solid #edf0f2;
            background: #fafafa;
        }

        @media print {
            @page {
                size: auto;
                margin: 8mm;
            }

            body {
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .sticker-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
            }

            .sap-sticker-card {
                box-shadow: none !important;
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }

        @media (max-width: 640px) {
            .sticker-wrapper {
                padding: 16px !important;
            }

            .sap-sticker-card {
                width: 100%;
                max-width: 340px;
            }
        }
    </style>
</head>

<body class="min-h-screen">
    <div class="sticker-wrapper mx-auto max-w-3xl px-4 py-8">

        {{-- TOOLBAR --}}
        <div class="sap-toolbar no-print mb-6 p-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="text-xs font-black uppercase tracking-wide text-slate-500">
                        Asset Management / QR Sticker
                    </div>

                    <div class="mt-1 text-lg font-black text-slate-800">
                        Print QR Sticker
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="button"
                            onclick="window.print()"
                            class="sap-btn sap-btn-primary">
                        Print Sticker
                    </button>

                    <a href="{{ route('assets.show', $asset) }}" class="sap-btn">
                        Kembali ke Detail Asset
                    </a>
                </div>
            </div>
        </div>

        {{-- STICKER --}}
        <div class="flex justify-center">
            <div class="sap-sticker-card">

                {{-- HEADER --}}
                <div class="sap-sticker-header">
                    <div class="flex items-center gap-3">
                        <div class="sap-logo-box">
                            <img src="{{ asset('images/proenergi-logo.png') }}"
                                 alt="Pro Energi"
                                 class="h-full w-full object-contain">
                        </div>

                        <div class="min-w-0">
                            <div class="text-[10px] font-black uppercase tracking-[0.16em] text-slate-200">
                                Enterprise Asset Tag
                            </div>

                            <div class="mt-1 text-sm font-black leading-tight text-white">
                                PT. PRO ENERGI
                            </div>

                            <div class="text-[10px] font-semibold text-slate-300">
                                Asset Lifecycle Management
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ASSET CODE --}}
                <div class="px-5 pt-4 text-center">
                    <div class="sap-label">
                        Asset Code
                    </div>

                    <div class="mt-1 text-xl font-black tracking-wide text-[#0a6ed1]">
                        {{ $asset->asset_code }}
                    </div>
                </div>

                {{-- QR --}}
                <div class="mt-4 flex justify-center px-5">
                    <div class="sap-qr-frame">
                        {!! QrCode::size(180)->generate(route('assets.scan.public', $asset->qr_code)) !!}
                    </div>
                </div>

                {{-- NAME --}}
                <div class="px-5 pt-4 text-center">
                    <div class="line-clamp-2 text-sm font-black leading-snug text-slate-800">
                        {{ $asset->asset_name }}
                    </div>

                    <div class="mt-1 text-xs font-semibold text-slate-500">
                        {{ $asset->category->name ?? '-' }}
                    </div>
                </div>

                {{-- INFO --}}
                <div class="px-5 py-4">
                    <div class="sap-info-grid grid grid-cols-2 gap-0 overflow-hidden">
                        <div class="border-r border-[#d9d9d9] p-3">
                            <div class="sap-label">Lokasi</div>
                            <div class="sap-value">
                                {{ $asset->location->name ?? '-' }}
                            </div>
                        </div>

                        <div class="p-3">
                            <div class="sap-label">Serial No</div>
                            <div class="sap-value break-all">
                                {{ $asset->serial_number ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="sap-footer-note px-5 py-3 text-center">
                    <div class="text-[11px] font-semibold text-slate-500">
                        Scan QR untuk melihat informasi asset
                    </div>

                    <div class="mt-1 break-all text-[10px] font-bold text-slate-400">
                        {{ $asset->qr_code }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>