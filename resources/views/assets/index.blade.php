<x-app-layout>
    <style>
        .sap-page {
            background: #f5f6f7;
            min-height: 100vh;
        }

        .sap-shell {
            width: 100%;
            padding: 24px 40px;
        }

        .sap-topbar {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
        }

        .sap-breadcrumb {
            font-size: 12px;
            color: #6a6d70;
            margin-bottom: 4px;
        }

        .sap-title {
            font-size: 24px;
            font-weight: 800;
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
            gap: 8px;
            height: 40px;
            padding: 0 16px;
            border-radius: 8px;
            border: 1px solid #c9cdd1;
            background: #ffffff;
            color: #32363a;
            font-size: 13px;
            font-weight: 700;
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

        .sap-btn-soft {
            background: #eff4f9;
            border-color: #d1e4f7;
            color: #0a6ed1;
        }

        .sap-btn-danger {
            background: #bb0000;
            border-color: #bb0000;
            color: #ffffff;
        }

        .sap-btn-danger:hover {
            background: #970000;
        }

        .sap-card {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
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
            font-size: 13px;
            font-weight: 700;
            color: #6a6d70;
        }

        .sap-kpi-value {
            margin-top: 8px;
            font-size: 32px;
            line-height: 1;
            font-weight: 900;
            color: #32363a;
        }

        .sap-kpi-desc {
            margin-top: 8px;
            font-size: 12px;
            color: #6a6d70;
        }

        .sap-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 800;
            background: #eef2f5;
            color: #354a5f;
        }

        .sap-input,
        .sap-select {
            width: 100%;
            height: 42px;
            border-radius: 8px;
            border: 1px solid #c9cdd1;
            background: #ffffff;
            font-size: 14px;
            color: #32363a;
            box-shadow: none;
        }

        .sap-input:focus,
        .sap-select:focus {
            border-color: #0a6ed1;
            box-shadow: 0 0 0 3px rgba(10, 110, 209, .15);
        }

        .sap-label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 800;
            color: #32363a;
        }

        .sap-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .sap-table thead th {
            position: sticky;
            top: 0;
            z-index: 5;
            background: #f5f6f7;
            border-bottom: 1px solid #d9d9d9;
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #6a6d70;
            text-align: left;
            white-space: nowrap;
        }

        .sap-table tbody td {
            border-bottom: 1px solid #edf0f2;
            padding: 13px 16px;
            font-size: 13px;
            color: #32363a;
            vertical-align: middle;
            white-space: nowrap;
        }

        .sap-table tbody tr:hover {
            background: #f7fbff;
        }

        .sap-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #d9d9d9;
            background: #ffffff;
            color: #354a5f;
            transition: .15s;
        }

        .sap-action:hover {
            background: #eef4fb;
            color: #0a6ed1;
            border-color: #b8d8f4;
        }

        .sap-badge {
            display: inline-flex;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 900;
            line-height: 1;
        }

        .sap-section-title {
            font-size: 16px;
            font-weight: 900;
            color: #32363a;
        }

        .sap-section-desc {
            font-size: 13px;
            color: #6a6d70;
        }

        .sap-file {
            height: 40px;
            border-radius: 8px;
            border: 1px solid #c9cdd1;
            background: #ffffff;
            font-size: 13px;
            padding: 7px;
        }

        .sap-scroll {
            max-height: 620px;
            overflow: auto;
        }

        .sap-confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, .45);
            backdrop-filter: blur(6px);
        }

        .sap-confirm-box {
            width: min(460px, calc(100vw - 32px));
            overflow: hidden;
            border-radius: 18px;
            border: 1px solid #d9d9d9;
            background: #ffffff;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .28);
            animation: sapConfirmPop .25s ease forwards;
        }

        .sap-confirm-header {
            border-bottom: 1px solid #edf0f2;
            background: #ffeaea;
            padding: 18px 20px;
            color: #bb0000;
            font-weight: 900;
        }

        .sap-confirm-body {
            padding: 20px;
            color: #32363a;
        }

        .sap-confirm-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #edf0f2;
            background: #fafafa;
            padding: 14px 20px;
        }

        @keyframes sapConfirmPop {
            from {
                opacity: 0;
                transform: translateY(14px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 768px) {
            .sap-shell {
                padding: 16px;
            }

            .sap-confirm-actions {
                flex-direction: column-reverse;
            }

            .sap-confirm-actions .sap-btn {
                width: 100%;
            }
        }
    </style>

    <div class="sap-page">
        <div class="sap-shell space-y-5">
            <x-flash-message />

            {{-- SAP TOP BAR --}}
            <div class="sap-topbar px-6 py-5">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <div class="sap-breadcrumb">
                            Asset Management / Monitoring / Dashboard
                        </div>

                        <div class="sap-title">
                            Asset Monitoring Dashboard
                        </div>

                        <div class="sap-subtitle">
                            Enterprise asset lifecycle monitoring, QR tracking, maintenance, dan reporting.
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('assets.template', 'it') }}" class="sap-btn sap-btn-soft">
                            Template IT
                        </a>

                        <a href="{{ route('assets.template', 'ga') }}" class="sap-btn sap-btn-soft">
                            Template GA
                        </a>

                        <a href="{{ route('assets.template', 'logistik') }}" class="sap-btn sap-btn-soft">
                            Template Logistik
                        </a>

                        <form method="POST"
                              action="{{ route('assets.import') }}"
                              enctype="multipart/form-data"
                              class="flex flex-wrap items-center gap-2">
                            @csrf

                            <input type="file"
                                   name="file"
                                   required
                                   class="sap-file">

                            <button class="sap-btn sap-btn-dark">
                                Import Asset
                            </button>
                        </form>

                        <a href="{{ route('assets.export', request()->query()) }}" class="sap-btn">
                            Export Excel
                        </a>

                        <a href="{{ route('assets.bulk-qr-print', request()->query()) }}"
                           target="_blank"
                           class="sap-btn">
                            Print Bulk QR
                        </a>

                        <a href="{{ route('assets.create') }}" class="sap-btn sap-btn-primary">
                            + Tambah Asset
                        </a>
                    </div>
                </div>
            </div>

            {{-- KPI --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="sap-kpi" style="--sap-color:#0a6ed1">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="sap-kpi-label">Total Asset</div>
                            <div class="sap-kpi-value">{{ $summary['total'] }}</div>
                            <div class="sap-kpi-desc">Seluruh asset yang terdaftar di sistem</div>
                        </div>
                        <span class="sap-chip">ALL</span>
                    </div>
                </div>

                <div class="sap-kpi" style="--sap-color:#0a6ed1">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="sap-kpi-label">Assigned</div>
                            <div class="sap-kpi-value">{{ $summary['assigned'] }}</div>
                            <div class="sap-kpi-desc">Asset yang sedang digunakan user</div>
                        </div>
                        <span class="sap-chip">USED</span>
                    </div>
                </div>

                <div class="sap-kpi" style="--sap-color:#e9730c">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="sap-kpi-label">Maintenance</div>
                            <div class="sap-kpi-value">{{ $summary['maintenance'] }}</div>
                            <div class="sap-kpi-desc">Asset yang sedang masuk perbaikan</div>
                        </div>
                        <span class="sap-chip">SERVICE</span>
                    </div>
                </div>

                <div class="sap-kpi" style="--sap-color:#bb0000">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="sap-kpi-label">Disposed / Lost</div>
                            <div class="sap-kpi-value">{{ $summary['disposed_lost'] }}</div>
                            <div class="sap-kpi-desc">Asset yang sudah tidak aktif atau hilang</div>
                        </div>
                        <span class="sap-chip">RISK</span>
                    </div>
                </div>
            </div>

            {{-- SMART FILTER --}}
            <div class="sap-card p-5">
                <div class="mb-5 flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <div class="sap-section-title">Smart Filter Asset</div>
                        <div class="sap-section-desc">
                            Gunakan parameter pencarian untuk menemukan asset dengan cepat dan akurat.
                        </div>
                    </div>

                    <a href="{{ route('assets.index') }}" class="sap-btn">
                        Reset Filter
                    </a>
                </div>

                <form method="GET"
                      action="{{ route('assets.index') }}"
                      class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">

                    <div class="xl:col-span-2">
                        <label class="sap-label">Search</label>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Kode asset, nama, serial number, brand..."
                               class="sap-input">
                    </div>

                    <div>
                        <label class="sap-label">Kategori</label>
                        <select name="category_id" class="sap-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="sap-label">Lokasi</label>
                        <select name="location_id" class="sap-select">
                            <option value="">Semua Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}" @selected(request('location_id') == $location->id)>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="sap-label">Lifecycle</label>
                        <select name="lifecycle_status" class="sap-select">
                            <option value="">Semua Status</option>
                            @foreach(['in_stock','assigned','maintenance','disposed','lost'] as $status)
                                <option value="{{ $status }}" @selected(request('lifecycle_status') == $status)>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="sap-label">Kondisi</label>
                        <select name="condition_status" class="sap-select">
                            <option value="">Semua Kondisi</option>
                            @foreach(['good','fair','damaged','repair','disposed'] as $status)
                                <option value="{{ $status }}" @selected(request('condition_status') == $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2 xl:col-span-4">
                        <button type="submit" class="sap-btn sap-btn-primary">
                            Filter Data
                        </button>

                        <a href="{{ route('assets.index') }}" class="sap-btn">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="sap-card overflow-hidden">
                <div class="flex flex-col gap-3 border-b border-[#d9d9d9] px-5 py-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="sap-section-title">Daftar Asset</div>
                        <div class="sap-section-desc">
                            Menampilkan data asset yang sudah terdaftar.
                        </div>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-slate-500">
                        Total tampil:
                        <span class="font-black text-slate-800">{{ $assets->count() }}</span>
                    </div>
                </div>

                <div class="sap-scroll">
                    <table class="sap-table">
                        <thead>
                            <tr>
                                <th class="w-16">No</th>
                                <th class="min-w-[320px]">Asset</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Departemen</th>
                                <th>Pemegang</th>
                                <th>Kondisi</th>
                                <th>Lifecycle</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($assets as $index => $asset)
                                <tr>
                                    <td class="font-bold text-slate-500">
                                        {{ $assets->firstItem() + $index }}
                                    </td>

                                    <td>
                                        @php
                                            $photo = $asset->documents->firstWhere('document_type', 'photo');
                                        @endphp

                                        <a href="{{ route('assets.show', $asset) }}" class="flex items-center gap-3">
                                            <div class="h-11 w-11 shrink-0 overflow-hidden rounded-lg border border-[#d9d9d9] bg-slate-100">
                                                @if($photo)
                                                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                                                         alt="{{ $asset->asset_name }}"
                                                         class="h-full w-full object-cover">
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-[9px] font-black uppercase text-slate-400">
                                                        No Img
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="min-w-0">
                                                <div class="font-black text-[#0a6ed1]">
                                                    {{ $asset->asset_code }}
                                                </div>

                                                <div class="truncate text-sm font-semibold text-slate-800">
                                                    {{ $asset->asset_name }}
                                                </div>

                                                <div class="truncate text-xs text-slate-500">
                                                    {{ trim(($asset->brand ?? '-') . ' ' . ($asset->model ?? '')) }}
                                                </div>
                                            </div>
                                        </a>
                                    </td>

                                    <td>{{ $asset->category->name ?? '-' }}</td>
                                    <td>{{ $asset->location->name ?? '-' }}</td>
                                    <td>{{ $asset->owner_role ?? '-' }}</td>
                                    <td>{{ $asset->activeAssignment?->user?->name ?? '-' }}</td>

                                    <td>
                                        @php
                                            $conditionClass = match($asset->condition_status) {
                                                'good' => 'background:#e4f5e9;color:#107e3e;border:1px solid #bfe6c8;',
                                                'fair' => 'background:#fff4ce;color:#8a6d00;border:1px solid #f5d76e;',
                                                'damaged' => 'background:#ffeaea;color:#bb0000;border:1px solid #f5b5b5;',
                                                'repair' => 'background:#fff0e0;color:#e9730c;border:1px solid #ffc48c;',
                                                default => 'background:#eef2f5;color:#354a5f;border:1px solid #d9d9d9;',
                                            };
                                        @endphp

                                        <span class="sap-badge" style="{{ $conditionClass }}">
                                            {{ ucfirst($asset->condition_status) }}
                                        </span>
                                    </td>

                                    <td>
                                        @php
                                            $lifeClass = match($asset->lifecycle_status) {
                                                'in_stock' => 'background:#eef2f5;color:#354a5f;border:1px solid #d9d9d9;',
                                                'assigned' => 'background:#eaf3ff;color:#0a6ed1;border:1px solid #b8d8f4;',
                                                'maintenance' => 'background:#fff0e0;color:#e9730c;border:1px solid #ffc48c;',
                                                'disposed' => 'background:#ffeaea;color:#bb0000;border:1px solid #f5b5b5;',
                                                'lost' => 'background:#ffeaf2;color:#c2185b;border:1px solid #f7b5cc;',
                                                default => 'background:#eef2f5;color:#354a5f;border:1px solid #d9d9d9;',
                                            };
                                        @endphp

                                        <span class="sap-badge" style="{{ $lifeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $asset->lifecycle_status)) }}
                                        </span>
                                    </td>

                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">

                                            <a href="{{ route('assets.show', $asset) }}"
                                               data-tippy-content="Detail Asset"
                                               class="sap-action">
                                                👁
                                            </a>

                                            <a href="{{ route('assets.edit', $asset) }}"
                                               data-tippy-content="Edit Asset"
                                               class="sap-action">
                                                ✎
                                            </a>

                                            <a href="{{ route('assets.qr', $asset) }}"
                                               data-tippy-content="Generate QR"
                                               class="sap-action">
                                                ⊞
                                            </a>

                                            @if (!empty($asset->qr_code_value))
                                                <a href="{{ route('assets.scan.public', ['qr_code' => $asset->qr_code_value]) }}"
                                                   target="_blank"
                                                   data-tippy-content="Public Scan"
                                                   class="sap-action">
                                                    ↗
                                                </a>
                                            @else
                                                <span class="sap-action text-slate-300"
                                                      data-tippy-content="QR belum tersedia">
                                                    ×
                                                </span>
                                            @endif

                                            <a href="{{ route('assets.qr-sticker', $asset) }}"
                                               target="_blank"
                                               data-tippy-content="Print QR Sticker"
                                               class="sap-action">
                                                ≡
                                            </a>

                                            <form action="{{ route('assets.destroy', $asset) }}"
                                                  method="POST"
                                                  class="sap-delete-form"
                                                  data-asset-code="{{ $asset->asset_code }}"
                                                  data-asset-name="{{ $asset->asset_name }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button"
                                                        data-tippy-content="Hapus Asset"
                                                        class="sap-action sap-delete-trigger hover:!border-red-200 hover:!bg-red-50 hover:!text-red-600">
                                                    🗑
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-16 text-center">
                                        <div class="mx-auto max-w-md">
                                            <div class="text-lg font-black text-slate-800">
                                                Belum ada data asset
                                            </div>

                                            <p class="mt-2 text-sm text-slate-500">
                                                Data asset yang Anda cari belum tersedia atau belum pernah ditambahkan.
                                            </p>

                                            <div class="mt-5">
                                                <a href="{{ route('assets.create') }}" class="sap-btn sap-btn-primary">
                                                    + Tambah Asset
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($assets->hasPages())
                    <div class="border-t border-[#d9d9d9] bg-white px-5 py-4">
                        {{ $assets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.sap-delete-trigger').forEach(button => {
                button.addEventListener('click', function () {
                    const form = button.closest('.sap-delete-form');

                    if (!form) return;

                    const assetCode = form.dataset.assetCode || '-';
                    const assetName = form.dataset.assetName || 'asset ini';

                    document.querySelectorAll('.sap-confirm-overlay').forEach(el => el.remove());

                    const modal = document.createElement('div');
                    modal.className = 'sap-confirm-overlay';

                    modal.innerHTML = `
                        <div class="sap-confirm-box">
                            <div class="sap-confirm-header">
                                Konfirmasi Hapus Asset
                            </div>

                            <div class="sap-confirm-body">
                                <div class="text-base font-black">
                                    Yakin ingin menghapus asset ini?
                                </div>

                                <div class="mt-3 rounded-xl border border-red-100 bg-red-50 p-4">
                                    <div class="text-sm font-black text-red-700">${assetCode}</div>
                                    <div class="mt-1 text-sm text-slate-700">${assetName}</div>
                                </div>

                                <p class="mt-4 text-sm leading-6 text-slate-500">
                                    Data yang dihapus dapat mempengaruhi histori asset, QR tracking,
                                    assignment, dan laporan asset.
                                </p>
                            </div>

                            <div class="sap-confirm-actions">
                                <button type="button" class="sap-btn sap-cancel-delete">
                                    Batal
                                </button>

                                <button type="button" class="sap-btn sap-btn-danger sap-confirm-delete">
                                    Ya, Hapus
                                </button>
                            </div>
                        </div>
                    `;

                    document.body.appendChild(modal);

                    modal.querySelector('.sap-cancel-delete').onclick = () => modal.remove();

                    modal.addEventListener('click', function (e) {
                        if (e.target === modal) modal.remove();
                    });

                    modal.querySelector('.sap-confirm-delete').onclick = () => {
                        const btn = modal.querySelector('.sap-confirm-delete');

                        btn.disabled = true;
                        btn.innerHTML = 'Menghapus...';

                        setTimeout(() => {
                            form.submit();
                        }, 500);
                    };
                });
            });
        });
    </script>
</x-app-layout>