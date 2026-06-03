<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            👥 Dashboard Tim IT Departemen
        </h2>
    </x-slot>

    <style>
        .sap-page {
            background: #f5f6f7;
            min-height: 100vh;
        }

        .sap-main {
            width: 100%;
            padding: 24px 32px;
        }

        .sap-kpi,
        .sap-filter-card,
        .sap-table-card {
            background: #fff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 1px 4px rgba(15, 23, 42, .05);
        }

        .sap-kpi {
            position: relative;
            overflow: hidden;
            padding: 24px;
            text-align: center;
        }

        .sap-kpi::before {
            content: "";
            position: absolute;
            inset: 0 auto 0 0;
            width: 4px;
            background: var(--sap-color);
        }

        .sap-filter-card {
            padding: 22px;
        }

        .sap-filter-card select {
            min-width: 180px;
            height: 40px;
            border: 1px solid #cfd4d9;
            border-radius: 8px;
            background: #fff;
            font-size: 13px;
            font-weight: 600;
            color: #32363a;
            padding: 0 34px 0 12px;
        }

        .sap-filter-card select:focus {
            border-color: #0a6ed1;
            box-shadow: 0 0 0 3px rgba(10, 110, 209, .14);
            outline: none;
        }

        .sap-table-header {
            padding: 20px 24px;
            border-bottom: 1px solid #edf0f2;
        }

        .sap-table-title {
            font-size: 18px;
            font-weight: 900;
            color: #32363a;
        }

        .sap-table-subtitle {
            margin-top: 4px;
            font-size: 13px;
            color: #6a6d70;
        }

        .sap-table-wrapper {
            width: 100%;
            overflow-x: auto;
            padding: 18px 24px 24px;
        }

        #ticketTable {
            width: 100% !important;
            border-collapse: collapse !important;
            background: #fff;
        }

        #ticketTable thead th {
            background: #f7f8fa !important;
            color: #55616d !important;
            border-bottom: 1px solid #d9d9d9 !important;
            padding: 14px 12px !important;
            font-size: 11px !important;
            font-weight: 900 !important;
            letter-spacing: .05em !important;
            text-transform: uppercase !important;
            white-space: nowrap !important;
        }

        #ticketTable tbody td {
            padding: 17px 12px !important;
            border-bottom: 1px solid #edf0f2 !important;
            color: #32363a !important;
            vertical-align: middle !important;
            font-size: 13px !important;
        }

        #ticketTable tbody tr:hover {
            background: #f9fbfc !important;
        }

        .sap-ticket-code {
            color: #0a6ed1;
            font-weight: 900;
        }

        .sap-link-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 4px;
            border: 0;
            background: transparent;
            color: #0a6ed1;
            font-size: 11px;
            font-weight: 900;
        }

        .sap-link-btn:hover {
            text-decoration: underline;
        }

        .priority-dropdown {
            min-width: 128px !important;
            height: 38px !important;
            border-radius: 8px !important;
            border: 1px solid #cfd4d9 !important;
            font-size: 13px !important;
            font-weight: 800 !important;
            padding: 0 32px 0 12px !important;
        }

        .priority-low {
            background: #eafaf1 !important;
            color: #107e3e !important;
            border-color: #b7e4c7 !important;
        }

        .priority-medium {
            background: #fff8dd !important;
            color: #8a6d00 !important;
            border-color: #f5d76e !important;
        }

        .priority-critical {
            background: #fff1f0 !important;
            color: #bb0000 !important;
            border-color: #ffb8b8 !important;
        }

        .status-badge {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 118px !important;
            height: 34px !important;
            border-radius: 999px !important;
            font-size: 11px !important;
            font-weight: 900 !important;
            border: 1px solid transparent !important;
        }

        .status-badge.bg-yellow-500 {
            background: #fff8dd !important;
            color: #8a6d00 !important;
            border-color: #f5d76e !important;
        }

        .status-badge.bg-blue-500 {
            background: #eaf3ff !important;
            color: #0a6ed1 !important;
            border-color: #b8d8f4 !important;
        }

        .status-badge.bg-green-600 {
            background: #eafaf1 !important;
            color: #107e3e !important;
            border-color: #b7e4c7 !important;
        }

        .status-badge.bg-red-500 {
            background: #fff1f0 !important;
            color: #bb0000 !important;
            border-color: #ffb8b8 !important;
        }

        .status-badge.bg-purple-600 {
            background: #f3edff !important;
            color: #6f42c1 !important;
            border-color: #d9c8ff !important;
        }

        .status-badge.bg-orange-500 {
            background: #fff0e0 !important;
            color: #e9730c !important;
            border-color: #ffc48c !important;
        }

        .sap-action-stack {
            display: flex;
            flex-direction: column;
            gap: 7px;
            min-width: 118px;
        }

        .sap-btn-table {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100%;
            min-height: 34px;
            border-radius: 8px;
            border: 1px solid #cfd4d9;
            background: #fff;
            font-size: 12px;
            font-weight: 900;
            transition: .15s;
        }

        .sap-btn-table:hover {
            background: #f4f6f8;
        }

        .sap-btn-blue {
            color: #0a6ed1 !important;
            border-color: #b8d8f4 !important;
        }

        .sap-btn-blue:hover {
            background: #eaf3ff !important;
        }

        .sap-btn-green {
            color: #107e3e !important;
            border-color: #b7e4c7 !important;
        }

        .sap-btn-green:hover {
            background: #eafaf1 !important;
        }

        .sap-btn-orange {
            color: #e9730c !important;
            border-color: #ffc48c !important;
        }

        .sap-btn-orange:hover {
            background: #fff0e0 !important;
        }

        .sap-dropdown-menu {
            position: absolute;
            z-index: 50;
            margin-top: 6px;
            width: 180px;
            overflow: hidden;
            border-radius: 10px;
            border: 1px solid #d9d9d9;
            background: #fff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .14);
        }

        .sap-dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 800;
            color: #32363a;
            background: #fff;
        }

        .sap-dropdown-item:hover {
            background: #f5faff;
        }

        .sap-modal {
            animation: sapFade .18s ease;
        }

        @keyframes sapFade {
            from {
                opacity: 0;
                transform: scale(.98);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #cfd4d9 !important;
            border-radius: 8px !important;
            height: 38px !important;
            padding: 0 12px !important;
            background: #fff !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            border: 1px solid #d9d9d9 !important;
            background: #fff !important;
            color: #32363a !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #0a6ed1 !important;
            color: #fff !important;
            border-color: #0a6ed1 !important;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='%236a6d70' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .7rem center;
            background-size: 1rem;
        }

        @media (max-width: 768px) {
            .sap-main {
                padding: 16px;
            }

            #ticketTable th,
            #ticketTable td {
                white-space: nowrap;
            }
        }
    </style>

    <div class="sap-page">
        <div class="sap-main space-y-6">

            {{-- KPI --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="sap-kpi" style="--sap-color:#0a6ed1">
                    <div class="text-3xl font-black text-[#0a6ed1]">{{ $openCount }}</div>
                    <p class="text-sm font-black text-slate-500">Tiket Open</p>
                </div>

                <div class="sap-kpi" style="--sap-color:#e9730c">
                    <div class="text-3xl font-black text-amber-600">{{ $inProgressCount }}</div>
                    <p class="text-sm font-black text-slate-500">Sedang Dikerjakan</p>
                </div>

                <div class="sap-kpi" style="--sap-color:#107e3e">
                    <div class="text-3xl font-black text-emerald-600">{{ $resolvedCount }}</div>
                    <p class="text-sm font-black text-slate-500">Selesai</p>
                </div>
            </div>

            {{-- Filter --}}
            <div class="sap-filter-card">
                <div class="mb-4">
                    <div class="text-base font-black text-slate-800">Smart Filter Ticket</div>
                    <div class="text-sm text-slate-500">
                        Filter ticket berdasarkan tanggal, cabang, kategori, dan status.
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <select id="filterTanggal">
                        <option value="">Semua Tanggal</option>
                        <option value="today">Hari Ini</option>
                    </select>

                    <select id="filterCabang">
                        <option value="">Semua Cabang</option>
                        @foreach ($cabangs as $cabang)
                            <option value="{{ $cabang }}">{{ $cabang }}</option>
                        @endforeach
                    </select>

                    <select id="filterKategori">
                        <option value="">Semua Kategori</option>
                        <option value="software">Software</option>
                        <option value="hardware">Hardware</option>
                    </select>

                    <select id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="open">Open</option>
                        <option value="in_progress">Sedang Dikerjakan</option>
                        <option value="resolved">Selesai</option>
                        <option value="Hold - Third Party">Hold - Third Party</option>
                        <option value="Hold - Waiting User Response">Hold - Waiting User</option>
                        <option value="Hold - Teknisi">Hold - Teknisi</option>
                    </select>
                </div>
            </div>

            {{-- Spinner --}}
            <div id="loadingSpinner" class="hidden py-4 text-center">
                <div class="flex justify-center">
                    <svg class="h-8 w-8 animate-spin text-[#0a6ed1]" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </div>
                <p class="mt-2 text-sm text-gray-600">Memuat data...</p>
            </div>

            {{-- Table --}}
            <div class="sap-table-card">
                <div class="sap-table-header">
                    <div>
                        <div class="sap-table-title">Daftar Tiket Terbaru</div>
                        <div class="sap-table-subtitle">
                            Monitoring ticket masuk, status pekerjaan, priority, dan assignment teknisi.
                        </div>
                    </div>
                </div>

                <div class="sap-table-wrapper">
                    <table id="ticketTable" class="min-w-full text-sm text-gray-700">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Cabang</th>
                                <th>Kategori</th>
                                <th>Klasifikasi</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Dikerjakan Oleh</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Durasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="ticketBody">
                            @foreach ($tickets as $ticket)
                                @php
                                    $durasi = '-';

                                    if ($ticket->started_at && $ticket->finished_at) {
                                        $diff = $ticket->started_at->diff($ticket->finished_at);
                                        $durasi =
                                            ($diff->h ? $diff->h . ' jam ' : '') .
                                            ($diff->i ? $diff->i . ' menit ' : '') .
                                            ($diff->s ? $diff->s . ' detik' : '');
                                    }

                                    $statusColor = match ($ticket->status) {
                                        'open' => 'bg-yellow-500',
                                        'cancel' => 'bg-red-500',
                                        'in_progress' => 'bg-blue-500',
                                        'resolved' => 'bg-green-600',
                                        'Hold - Third Party' => 'bg-purple-600',
                                        'Hold - Waiting User Response' => 'bg-orange-500',
                                        'Hold - Teknisi' => 'bg-red-500',
                                        default => 'bg-gray-400',
                                    };
                                @endphp

                                <tr>
                                    <td>
                                        <span class="sap-ticket-code">
                                            {{ strtoupper(substr($ticket->category, 0, 1)) }}{{ str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>

                                    <td>{{ $ticket->nama }}</td>

                                    <td class="font-semibold">
                                        {{ $ticket->title }}
                                    </td>

                                    <td>{{ $ticket->cabang }}</td>

                                    <td class="capitalize">{{ $ticket->category }}</td>

                                    <td class="capitalize">
                                        <div>{{ $ticket->klasifikasi }}</div>

                                        @if ($ticket->description)
                                            <button type="button"
                                                    class="sap-link-btn btn-view-desc"
                                                    data-desc="{{ e($ticket->description) }}"
                                                    data-id="{{ $ticket->id }}">
                                                <span>▣</span>
                                                <span>Deskripsi</span>
                                            </button>
                                        @endif
                                    </td>

                                    <td>
                                        <select
                                            class="priority-dropdown
                                                {{ $ticket->priority === 'Low' ? 'priority-low' : '' }}
                                                {{ $ticket->priority === 'Medium' ? 'priority-medium' : '' }}
                                                {{ $ticket->priority === 'Critical' ? 'priority-critical' : '' }}"
                                            data-id="{{ $ticket->id }}">
                                            <option value="Low" {{ $ticket->priority === 'Low' ? 'selected' : '' }}>● Low</option>
                                            <option value="Medium" {{ $ticket->priority === 'Medium' ? 'selected' : '' }}>● Medium</option>
                                            <option value="Critical" {{ $ticket->priority === 'Critical' ? 'selected' : '' }}>● Critical</option>
                                        </select>
                                    </td>

                                    <td>
                                        <span class="status-badge {{ $statusColor }}">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>

                                    <td>
                                        <div>{{ $ticket->takenByUser?->name ?? '-' }}</div>

                                        @if ($ticket->status === 'resolved' && $ticket->resolution_note)
                                            <button type="button"
                                                    class="sap-link-btn btn-view-note"
                                                    data-note="{{ e($ticket->resolution_note) }}"
                                                    data-id="{{ $ticket->id }}">
                                                <span>▣</span>
                                                <span>Detail</span>
                                            </button>
                                        @endif
                                    </td>

                                    <td>{{ $ticket->started_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>{{ $ticket->finished_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                    <td>{{ $durasi }}</td>

                                    <td>
                                        <div class="sap-action-stack">
                                            @if ($ticket->status !== 'resolved' && $ticket->status !== 'cancel')
                                                <button type="button"
                                                        class="sap-btn-table sap-btn-blue transfer-btn"
                                                        data-id="{{ $ticket->id }}">
                                                    <span>⇄</span>
                                                    <span>Transfer</span>
                                                </button>
                                            @else
                                                <span class="text-xs italic text-slate-400">-</span>
                                            @endif

                                            @if ($ticket->status === 'open')
                                                <div x-data="{ open: false }" class="relative">
                                                    <button type="button"
                                                            @click="open = !open"
                                                            class="sap-btn-table sap-btn-blue">
                                                        <span>⚙</span>
                                                        <span>Aksi</span>
                                                        <span>⌄</span>
                                                    </button>

                                                    <div x-show="open"
                                                         @click.away="open = false"
                                                         class="sap-dropdown-menu">
                                                        <form action="{{ route('tickets.updateStatus', $ticket->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="in_progress">

                                                            <button type="submit" class="sap-dropdown-item">
                                                                <span>▶</span>
                                                                <span>Ambil Ticket</span>
                                                            </button>
                                                        </form>

                                                        <button type="button"
                                                                data-id="{{ $ticket->id }}"
                                                                class="sap-dropdown-item btn-delete">
                                                            <span>✕</span>
                                                            <span>Cancel Ticket</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @elseif (in_array($ticket->status, ['in_progress', 'Hold - Third Party', 'Hold - Waiting User Response', 'Hold - Teknisi']))
                                                <button type="button"
                                                        class="sap-btn-table sap-btn-green btn-finish"
                                                        data-id="{{ $ticket->id }}">
                                                    <span>✓</span>
                                                    <span>Selesai</span>
                                                </button>

                                                <div x-data="{ open: false }" class="relative">
                                                    <button type="button"
                                                            @click="open = !open"
                                                            class="sap-btn-table sap-btn-orange">
                                                        <span>Ⅱ</span>
                                                        <span>Tahan</span>
                                                        <span>⌄</span>
                                                    </button>

                                                    <div x-show="open"
                                                         @click.away="open = false"
                                                         class="sap-dropdown-menu">
                                                        <form action="{{ route('tickets.updateStatus', $ticket->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="Hold - Third Party">

                                                            <button type="submit" class="sap-dropdown-item">
                                                                <span>◇</span>
                                                                <span>Third Party</span>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('tickets.updateStatus', $ticket->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="Hold - Waiting User Response">

                                                            <button type="submit" class="sap-dropdown-item">
                                                                <span>□</span>
                                                                <span>Waiting User</span>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('tickets.updateStatus', $ticket->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="Hold - Teknisi">

                                                            <button type="submit" class="sap-dropdown-item">
                                                                <span>△</span>
                                                                <span>Teknisi</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs italic text-slate-400">Done</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal Deskripsi --}}
            <div id="descModal" class="sap-modal hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl shadow-lg w-[90%] max-w-2xl p-5 overflow-y-auto max-h-[90vh]">
                    <h2 class="text-lg font-semibold text-blue-700 mb-3">📝 Deskripsi Masalah</h2>

                    <div id="descContent"
                         class="text-gray-700 text-sm whitespace-pre-line border p-3 rounded-md bg-gray-50 mb-4">
                    </div>

                    <div id="descAttachments" class="space-y-3"></div>

                    <div class="text-right mt-4">
                        <button id="closeDescModal"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            {{-- Modal Catatan --}}
            <div id="noteModal" class="sap-modal hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl shadow-lg w-96 p-4">
                    <h2 class="text-lg font-semibold text-blue-700 mb-2">📝 Catatan Penyelesaian</h2>
                    <div id="noteContent" class="text-gray-700 text-sm whitespace-pre-line border p-2 rounded-md bg-gray-50">
                    </div>
                    <div class="text-right mt-4">
                        <button id="closeNoteModal"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">

        <script>
            $(document).ready(function() {
                const table = $('#ticketTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [5, 10, 25, 50, 100],
                    order: [],
                    language: {
                        search: "🔍 Cari:",
                        lengthMenu: "Tampilkan _MENU_ tiket per halaman",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ tiket",
                        infoEmpty: "Tidak ada data tiket",
                        paginate: {
                            previous: "← Sebelumnya",
                            next: "Berikutnya →"
                        },
                        emptyTable: "Belum ada tiket tercatat"
                    },
                    responsive: true,
                    autoWidth: false,
                });

                $(document).on('click', '.btn-view-note', function() {
                    const note = $(this).data('note');
                    $('#noteContent').text(note);
                    $('#noteModal').removeClass('hidden');
                });

                $('#closeNoteModal').on('click', function() {
                    $('#noteModal').addClass('hidden');
                });

                $(document).on('click', function(e) {
                    if ($(e.target).is('#noteModal')) {
                        $('#noteModal').addClass('hidden');
                    }
                });

                const spinner = $('#loadingSpinner');

                $('#filterCabang, #filterKategori, #filterStatus, #filterTanggal').on('change', function() {
                    spinner.removeClass('hidden');

                    setTimeout(() => {
                        const cabang = $('#filterCabang').val().toLowerCase();
                        const kategori = $('#filterKategori').val().toLowerCase();
                        const status = $('#filterStatus').val().toLowerCase();
                        const tanggal = $('#filterTanggal').val();

                        table.rows().every(function() {
                            const data = this.data();
                            const row = $(this.node());
                            const cabangCol = data[3]?.toLowerCase() ?? '';
                            const kategoriCol = data[4]?.toLowerCase() ?? '';
                            const statusCol = data[7]?.toLowerCase() ?? '';

                            let matchTanggal = true;

                            if (tanggal === 'today') {
                                const today = new Date().toLocaleDateString('id-ID');
                                matchTanggal = data[9]?.startsWith(today);
                            }

                            const match =
                                (!cabang || cabangCol.includes(cabang)) &&
                                (!kategori || kategoriCol.includes(kategori)) &&
                                (!status || statusCol.includes(status)) &&
                                matchTanggal;

                            if (match) row.show();
                            else row.hide();
                        });

                        spinner.addClass('hidden');
                    }, 300);
                });

                $('.priority-dropdown').on('change', async function() {
                    const id = $(this).data('id');
                    const value = $(this).val();

                    try {
                        const res = await fetch(`/tickets/${id}/priority`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                priority: value
                            })
                        });

                        const data = await res.json();

                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1200
                            });

                            $(this)
                                .removeClass('priority-low priority-medium priority-critical')
                                .addClass(
                                    value === 'Critical'
                                        ? 'priority-critical'
                                        : value === 'Medium'
                                            ? 'priority-medium'
                                            : 'priority-low'
                                );
                        } else {
                            throw new Error('Gagal update priority');
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan',
                            text: 'Gagal memperbarui priority.'
                        });
                    }
                });

                $(document).on('click', '.btn-delete', async function() {
                    const id = $(this).data('id');
                    const row = $(this).closest('tr');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    const { value: cancelNote } = await Swal.fire({
                        title: "Batalkan Tiket?",
                        input: "textarea",
                        inputPlaceholder: "Tuliskan alasan pembatalan...",
                        showCancelButton: true,
                        confirmButtonColor: "#dc2626",
                        cancelButtonColor: "#6b7280",
                        confirmButtonText: "Ya, Batalkan",
                        cancelButtonText: "Batal",
                        inputValidator: value => {
                            if (!value) return "Catatan wajib diisi!";
                        }
                    });

                    if (!cancelNote) return;

                    try {
                        const res = await fetch(`/tickets/${id}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                                "Accept": "application/json",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                cancel_note: cancelNote
                            })
                        });

                        const data = await res.json();

                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Dibatalkan!",
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false,
                            });

                            $('#ticketTable').DataTable().row(row).remove().draw(false);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: data.message
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Terjadi kesalahan server."
                        });
                    }
                });

                $(document).on('click', '.btn-finish', async function() {
                    const id = $(this).data('id');

                    const { value: note } = await Swal.fire({
                        title: '📝 Catatan Penyelesaian',
                        input: 'textarea',
                        inputPlaceholder: 'Tuliskan bagaimana masalah ini diselesaikan...',
                        showCancelButton: true,
                        confirmButtonText: 'Simpan & Selesai',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#16a34a',
                        cancelButtonColor: '#6b7280',
                        inputValidator: (value) => {
                            if (!value) return 'Catatan wajib diisi!';
                        }
                    });

                    if (note) {
                        try {
                            const csrfToken = document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');

                            const res = await fetch(`/tickets/${id}/status`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({
                                    status: 'resolved',
                                    resolution_note: note,
                                }),
                            });

                            if (!res.ok) throw new Error('HTTP ' + res.status);
                            const data = await res.json();

                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Tiket diselesaikan!',
                                    text: 'Catatan tersimpan sebagai dokumentasi internal.',
                                    timer: 1500,
                                    showConfirmButton: false,
                                });

                                setTimeout(() => location.reload(), 1200);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal update',
                                    text: data.message || 'Terjadi kesalahan saat memperbarui tiket.',
                                });
                            }
                        } catch (e) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal menyimpan',
                                text: 'Terjadi kesalahan saat memperbarui tiket.',
                            });
                        }
                    }
                });

                $('.transfer-btn').on('click', function() {
                    let ticketId = $(this).data('id');

                    Swal.fire({
                        title: "Alihkan Ticket ke Teknisi?",
                        input: "select",
                        inputOptions: {
                            @foreach ($technicians as $t)
                                "{{ $t->id }}": "{{ $t->name }}",
                            @endforeach
                        },
                        inputPlaceholder: "Pilih teknisi",
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#9ca3af',
                        confirmButtonText: "Transfer"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/tickets/${ticketId}/transfer`,
                                type: 'PUT',
                                data: {
                                    new_technician_id: result.value,
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function(res) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: res.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    setTimeout(() => location.reload(), 1200);
                                },
                                error: function(err) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: err.responseJSON?.message ?? 'Terjadi kesalahan.',
                                    });
                                }
                            });
                        }
                    });
                });

                $(document).on('click', '.btn-view-desc', function() {
                    const desc = $(this).data('desc');
                    const ticketId = $(this).data('id');

                    $('#descContent').text(desc || '-');
                    $('#descAttachments').html('<p class="text-gray-400 text-sm italic">Memuat lampiran...</p>');
                    $('#descModal').removeClass('hidden');

                    $.get(`/tickets/${ticketId}/detail`, function(data) {
                        const attachDiv = $('#descAttachments');
                        attachDiv.empty();

                        if (data.attachments && data.attachments.length > 0) {
                            data.attachments.forEach(file => {
                                const url = `/storage/${file.file_path}`;
                                const ext = file.file_name.split('.').pop().toLowerCase();

                                if (['jpg', 'jpeg', 'png'].includes(ext)) {
                                    attachDiv.append(`
                                        <div class="border rounded-md p-2 bg-gray-50 mb-3">
                                            <p class="text-sm text-gray-600 mb-1 font-semibold">📷 ${file.file_name}</p>
                                            <img src="${url}" alt="${file.file_name}" class="max-h-64 rounded-lg shadow mx-auto">
                                        </div>
                                    `);
                                } else if (ext === 'pdf') {
                                    attachDiv.append(`
                                        <div class="border rounded-md p-2 bg-gray-50 mb-3">
                                            <p class="text-sm text-gray-600 mb-1 font-semibold">📄 ${file.file_name}</p>
                                            <iframe src="${url}" class="w-full h-64 border rounded-lg"></iframe>
                                        </div>
                                    `);
                                } else {
                                    attachDiv.append(`
                                        <div class="border rounded-md p-2 bg-gray-50 mb-3">
                                            <p class="text-sm text-gray-600 mb-1 font-semibold">📎 ${file.file_name}</p>
                                            <a href="${url}" target="_blank" class="text-blue-600 hover:underline text-sm">Lihat / Unduh File</a>
                                        </div>
                                    `);
                                }
                            });
                        } else {
                            attachDiv.html(`<p class="text-gray-500 text-sm italic">Tidak ada lampiran.</p>`);
                        }
                    }).fail(() => {
                        $('#descAttachments').html(`<p class="text-red-500 text-sm italic">Gagal memuat lampiran.</p>`);
                    });
                });

                $('#closeDescModal').on('click', function() {
                    $('#descModal').addClass('hidden');
                });

                $(document).on('click', function(e) {
                    if ($(e.target).is('#descModal')) {
                        $('#descModal').addClass('hidden');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>