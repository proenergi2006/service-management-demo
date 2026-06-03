<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pro Energi Service Management</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">

    @vite('resources/css/app.css')

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f5f6f7;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
        }

        .sap-shell {
            max-width: 1600px;
            margin: 0 auto;
            padding: 24px 32px;
        }

        .sap-card {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
        }

        .sap-header {
            background: #354a5f;
            color: #ffffff;
            border-radius: 18px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, .16);
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

        .sap-btn:hover { background: #f5f6f7; }

        .sap-btn-primary {
            background: #0a6ed1;
            border-color: #0a6ed1;
            color: #ffffff;
        }

        .sap-btn-primary:hover { background: #085caf; }

        .sap-btn-dark {
            background: #354a5f;
            border-color: #354a5f;
            color: #ffffff;
        }

        .sap-kpi {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 18px;
            padding: 22px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
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

        .sap-calendar-head {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            background: #354a5f;
            color: #ffffff;
            text-align: center;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .14em;
        }

        .sap-calendar-head > div { padding: 14px 8px; }

        .sap-calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }

        .sap-calendar-cell {
            min-height: 190px;
            border-right: 1px solid #edf0f2;
            border-bottom: 1px solid #edf0f2;
            padding: 12px;
            background: #ffffff;
        }

        .sap-calendar-cell-muted {
            background: #f8fafc;
            color: #94a3b8;
        }

        .sap-day-number {
            display: flex;
            height: 34px;
            width: 34px;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #eef2f5;
            font-size: 13px;
            font-weight: 900;
            color: #354a5f;
        }

        .sap-day-today {
            background: #0a6ed1;
            color: #ffffff;
            box-shadow: 0 6px 14px rgba(10, 110, 209, .25);
        }

        .sap-count-badge {
            display: flex;
            height: 24px;
            width: 24px;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #fff0e0;
            color: #e9730c;
            font-size: 11px;
            font-weight: 900;
        }

        .sap-booking-card {
            width: 100%;
            border-radius: 12px;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            transition: .15s;
        }

        .sap-booking-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(10, 110, 209, .10);
        }

        .sap-booking-success {
            border: 1px solid #bfe6c8;
            background: #e4f5e9;
            color: #107e3e;
        }

        .sap-booking-warning {
            border: 1px solid #ffc48c;
            background: #fff0e0;
            color: #e9730c;
        }

        @media (max-width: 768px) {
            .sap-shell { padding: 16px; }
            .sap-calendar-cell { min-height: 145px; padding: 8px; }
            .sap-calendar-head { font-size: 9px; letter-spacing: .08em; }
        }
    </style>
</head>

<body class="font-sans text-slate-800"
    x-data="{
        showModal: {{ auth()->check() && request('open_ticket') ? 'true' : 'false' }},
        showDetailModal: false,
        roomCalendarOpen: localStorage.getItem('roomCalendarOpen') !== 'false',
        vehicleCalendarOpen: localStorage.getItem('vehicleCalendarOpen') !== 'false',
        toggleRoomCalendar() {
            this.roomCalendarOpen = !this.roomCalendarOpen;
            localStorage.setItem('roomCalendarOpen', this.roomCalendarOpen);
        },
        toggleVehicleCalendar() {
            this.vehicleCalendarOpen = !this.vehicleCalendarOpen;
            localStorage.setItem('vehicleCalendarOpen', this.vehicleCalendarOpen);
        },
        detailTicket: {
            code: '',
            nama: '',
            title: '',
            cabang: '',
            category: '',
            klasifikasi: '',
            priority: '',
            status: '',
            description: '',
            takenBy: '',
            createdAt: ''
        }
    }">

<div class="sap-shell">

    {{-- HEADER --}}
    <header class="sap-header mb-6 px-6 py-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white p-2">
                    <img src="{{ asset('images/proenergi-logo.png') }}" alt="Pro Energi" class="h-full w-full object-contain">
                </div>

                <div>
                    <div class="text-xs font-black uppercase tracking-[0.18em] text-blue-100">
                        SAP Enterprise Workspace
                    </div>
                    <h1 class="mt-1 text-2xl font-black text-white">
                        Pro Energi Service Management
                    </h1>
                    <p class="text-sm text-slate-200">
                        IT Helpdesk · Facility Booking · Asset Lifecycle · Operational Support
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-end">
                <div id="clock" class="rounded-xl bg-white/10 px-4 py-2 text-sm font-bold text-white"></div>

                @auth
                    <button @click="showModal = true" class="sap-btn sap-btn-primary">
                        + Buat Ticket
                    </button>

                    @if (auth()->user()->role === 'it')
                        <a href="{{ route('dashboard') }}" class="sap-btn">
                            Dashboard IT
                        </a>
                    @endif

                    <div class="flex items-center gap-3 rounded-xl bg-white/10 px-3 py-2">
                        <div class="text-right">
                            <div class="text-sm font-black text-white">{{ auth()->user()->name }}</div>
                            <div class="text-xs font-bold capitalize text-slate-300">{{ auth()->user()->role }}</div>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white font-black text-[#354a5f]">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg bg-red-50 px-4 py-2 text-sm font-black text-red-600">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login.user', ['redirect' => url('/?open_ticket=1')]) }}" class="sap-btn sap-btn-primary">
                        + Buat Ticket
                    </a>

                    <a href="{{ route('login.user') }}" class="sap-btn">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- KPI --}}
    <section class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="sap-kpi" style="--sap-color:#0a6ed1">
            <p class="text-sm font-black text-slate-400">Ticket Hari Ini</p>
            <div class="mt-2 text-5xl font-black text-[#0a6ed1]">{{ $totalToday ?? 0 }}</div>
            <div class="mt-2 text-xs font-black text-slate-400">Today</div>
        </div>

        <div class="sap-kpi" style="--sap-color:#e9730c">
            <p class="text-sm font-black text-slate-400">Menunggu</p>
            <div class="mt-2 text-5xl font-black text-amber-600">{{ $openCount ?? 0 }}</div>
            <div class="mt-2 text-xs font-black text-slate-400">Open</div>
        </div>

        <div class="sap-kpi" style="--sap-color:#107e3e">
            <p class="text-sm font-black text-slate-400">Selesai</p>
            <div class="mt-2 text-5xl font-black text-emerald-600">{{ $resolvedCount ?? 0 }}</div>
            <div class="mt-2 text-xs font-black text-slate-400">Done</div>
        </div>
    </section>

    {{-- QUICK MENU --}}
    <section class="mb-8 grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
        <button @click="showModal = true" class="sap-card p-6 text-left transition hover:-translate-y-1">
            <div class="text-base font-black text-slate-800">IT Helpdesk</div>
            <p class="mt-1 text-sm text-slate-500">Buat ticket bantuan IT</p>
        </button>

        @auth
            <a href="{{ route('tickets.my') }}" class="sap-card p-6 transition hover:-translate-y-1">
        @else
            <a href="{{ route('login.user') }}" class="sap-card p-6 transition hover:-translate-y-1">
        @endauth
            <div class="text-base font-black text-slate-800">Ticket Saya</div>
            <p class="mt-1 text-sm text-slate-500">Pantau ticket yang Anda buat</p>
        </a>

        @auth
            <a href="{{ route('room-bookings.create') }}" class="sap-card p-6 transition hover:-translate-y-1">
        @else
            <a href="{{ route('login.user') }}" class="sap-card p-6 transition hover:-translate-y-1">
        @endauth
            <div class="text-base font-black text-slate-800">Booking Ruangan</div>
            <p class="mt-1 text-sm text-slate-500">Reservasi meeting room</p>
        </a>

        @auth
            <a href="{{ route('vehicle-bookings.create') }}" class="sap-card p-6 transition hover:-translate-y-1">
        @else
            <a href="{{ route('login.user') }}" class="sap-card p-6 transition hover:-translate-y-1">
        @endauth
            <div class="text-base font-black text-slate-800">Booking Kendaraan</div>
            <p class="mt-1 text-sm text-slate-500">Ajukan kendaraan operasional</p>
        </a>
    </section>

    @php
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $roomMonth = (int) request('room_month', now()->month);
        $roomYear = (int) request('room_year', now()->year);
        $selectedRoom = request('room_id', '');
        $selectedCabang = request('room_cabang', '');

        $calendarDate = \Carbon\Carbon::create($roomYear, $roomMonth, 1);
        $startCalendar = $calendarDate->copy()->startOfMonth()->startOfWeek(\Carbon\Carbon::MONDAY);
        $endCalendar = $calendarDate->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SUNDAY);

        $bookingsByDate = collect($calendarRoomBookings ?? [])
            ->groupBy(fn($item) => $item->booking_date?->format('Y-m-d'));
    @endphp

    {{-- ROOM CALENDAR --}}
    <section class="mb-8">
        <div class="sap-card overflow-hidden">
            <div class="border-b border-slate-100 bg-white px-6 py-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="text-xs font-black uppercase tracking-[0.16em] text-[#0a6ed1]">
                            SAP Calendar Object
                        </div>
                        <h2 class="mt-1 text-2xl font-black text-slate-800">Kalender Booking Ruangan</h2>
                        <p class="text-sm text-slate-500">Monitoring penggunaan ruangan berdasarkan tanggal.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" @click="toggleRoomCalendar()" class="sap-btn">
                            <span x-show="roomCalendarOpen">Minimize Calendar</span>
                            <span x-show="!roomCalendarOpen">Expand Calendar</span>
                        </button>

                        <form method="GET" action="{{ url('/') }}" class="flex flex-wrap gap-3">
                            <select name="room_month" class="rounded-xl border-slate-300 text-sm font-bold">
                                @foreach($months as $num => $label)
                                    <option value="{{ $num }}" @selected($roomMonth == $num)>{{ $label }}</option>
                                @endforeach
                            </select>

                            <select name="room_year" class="rounded-xl border-slate-300 text-sm font-bold">
                                @for($y = now()->year - 2; $y <= now()->year + 2; $y++)
                                    <option value="{{ $y }}" @selected($roomYear == $y)>{{ $y }}</option>
                                @endfor
                            </select>

                            <select name="room_id" class="rounded-xl border-slate-300 text-sm font-bold">
                                <option value="">Semua Ruangan</option>
                                @foreach(($rooms ?? []) as $room)
                                    <option value="{{ $room->id }}" @selected($selectedRoom == $room->id)>
                                        {{ $room->room_name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="room_cabang" class="rounded-xl border-slate-300 text-sm font-bold">
                                <option value="">Semua Cabang</option>
                                @foreach(($roomCabangs ?? []) as $cabang)
                                    <option value="{{ $cabang }}" @selected($selectedCabang == $cabang)>
                                        {{ $cabang }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="sap-btn sap-btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="roomCalendarOpen" x-transition>
                <div class="sap-calendar-head">
                    <div>Senin</div><div>Selasa</div><div>Rabu</div><div>Kamis</div><div>Jumat</div><div>Sabtu</div><div>Minggu</div>
                </div>

                <div class="sap-calendar-grid">
                    @php $day = $startCalendar->copy(); @endphp

                    @while($day <= $endCalendar)
                        @php
                            $dateKey = $day->format('Y-m-d');
                            $dayBookings = $bookingsByDate->get($dateKey, collect());
                            $isCurrentMonth = $day->month == $roomMonth;
                            $isToday = $day->isToday();
                        @endphp

                        <div class="sap-calendar-cell {{ !$isCurrentMonth ? 'sap-calendar-cell-muted' : '' }}">
                            <div class="mb-4 flex items-center justify-between">
                                <span class="sap-day-number {{ $isToday ? 'sap-day-today' : '' }}">{{ $day->day }}</span>

                                @if($dayBookings->count() > 0)
                                    <span class="sap-count-badge">{{ $dayBookings->count() }}</span>
                                @endif
                            </div>

                            <div class="space-y-2">
                                @foreach($dayBookings->take(3) as $booking)
                                    <button type="button"
                                        onclick="openRoomBookingModal(this)"
                                        data-room="{{ $booking->room?->room_name ?? '-' }}"
                                        data-cabang="{{ $booking->room?->location ?? '-' }}"
                                        data-title="{{ e($booking->title ?? '-') }}"
                                        data-time="{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}"
                                        data-requester="{{ e($booking->requester_name ?? '-') }}"
                                        data-status="{{ e($booking->status ?? '-') }}"
                                        data-purpose="{{ e($booking->purpose ?? '-') }}"
                                        class="sap-booking-card {{ $booking->status === 'approved' ? 'sap-booking-success' : 'sap-booking-warning' }}">
                                        <div class="truncate font-black">
                                            {{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}
                                            · {{ $booking->room?->room_name ?? '-' }}
                                        </div>
                                        <div class="mt-1 truncate font-semibold">{{ $booking->title ?? '-' }}</div>
                                        <div class="mt-1 truncate text-[11px]">Oleh: {{ $booking->requester_name ?? '-' }}</div>
                                    </button>
                                @endforeach

                                @if($dayBookings->count() > 3)
                                    <div class="text-xs font-black text-[#0a6ed1]">
                                        +{{ $dayBookings->count() - 3 }} booking lagi
                                    </div>
                                @endif
                            </div>
                        </div>

                        @php $day->addDay(); @endphp
                    @endwhile
                </div>
            </div>
        </div>
    </section>

    @php
        $vehicleMonth = (int) request('vehicle_month', now()->month);
        $vehicleYear = (int) request('vehicle_year', now()->year);
        $selectedVehicle = request('vehicle_id', '');
        $selectedVehicleStatus = request('vehicle_status', '');

        $vehicleCalendarDate = \Carbon\Carbon::create($vehicleYear, $vehicleMonth, 1);
        $vehicleStartCalendar = $vehicleCalendarDate->copy()->startOfMonth()->startOfWeek(\Carbon\Carbon::MONDAY);
        $vehicleEndCalendar = $vehicleCalendarDate->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SUNDAY);

        $vehicleBookingsByDate = collect($calendarVehicleBookings ?? [])
            ->groupBy(fn($item) => $item->departure_datetime?->format('Y-m-d'));
    @endphp

    {{-- VEHICLE CALENDAR --}}
    <section class="mb-8">
        <div class="sap-card overflow-hidden">
            <div class="border-b border-slate-100 bg-white px-6 py-5">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="text-xs font-black uppercase tracking-[0.16em] text-[#0a6ed1]">
                            SAP Fleet Calendar Object
                        </div>
                        <h2 class="mt-1 text-2xl font-black text-slate-800">Kalender Booking Kendaraan</h2>
                        <p class="text-sm text-slate-500">Monitoring penggunaan kendaraan operasional berdasarkan tanggal.</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" @click="toggleVehicleCalendar()" class="sap-btn">
                            <span x-show="vehicleCalendarOpen">Minimize Calendar</span>
                            <span x-show="!vehicleCalendarOpen">Expand Calendar</span>
                        </button>

                        <form method="GET" action="{{ url('/') }}" class="flex flex-wrap gap-3">
                            <select name="vehicle_month" class="rounded-xl border-slate-300 text-sm font-bold">
                                @foreach($months as $num => $label)
                                    <option value="{{ $num }}" @selected($vehicleMonth == $num)>{{ $label }}</option>
                                @endforeach
                            </select>

                            <select name="vehicle_year" class="rounded-xl border-slate-300 text-sm font-bold">
                                @for($y = now()->year - 2; $y <= now()->year + 2; $y++)
                                    <option value="{{ $y }}" @selected($vehicleYear == $y)>{{ $y }}</option>
                                @endfor
                            </select>

                            <select name="vehicle_id" class="rounded-xl border-slate-300 text-sm font-bold">
                                <option value="">Semua Kendaraan</option>
                                @foreach(($vehicles ?? []) as $vehicle)
                                    <option value="{{ $vehicle->id }}" @selected($selectedVehicle == $vehicle->id)>
                                        {{ $vehicle->plate_number }} - {{ $vehicle->vehicle_name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="vehicle_status" class="rounded-xl border-slate-300 text-sm font-bold">
                                <option value="">Semua Status</option>
                                @foreach(['pending','approved','on_trip','returned'] as $vStatus)
                                    <option value="{{ $vStatus }}" @selected($selectedVehicleStatus == $vStatus)>
                                        {{ strtoupper(str_replace('_', ' ', $vStatus)) }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit" class="sap-btn sap-btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
            </div>

            <div x-show="vehicleCalendarOpen" x-transition>
                <div class="sap-calendar-head">
                    <div>Senin</div><div>Selasa</div><div>Rabu</div><div>Kamis</div><div>Jumat</div><div>Sabtu</div><div>Minggu</div>
                </div>

                <div class="sap-calendar-grid">
                    @php $vehicleDay = $vehicleStartCalendar->copy(); @endphp

                    @while($vehicleDay <= $vehicleEndCalendar)
                        @php
                            $vehicleDateKey = $vehicleDay->format('Y-m-d');
                            $dayVehicleBookings = $vehicleBookingsByDate->get($vehicleDateKey, collect());
                            $isVehicleCurrentMonth = $vehicleDay->month == $vehicleMonth;
                            $isVehicleToday = $vehicleDay->isToday();
                        @endphp

                        <div class="sap-calendar-cell {{ !$isVehicleCurrentMonth ? 'sap-calendar-cell-muted' : '' }}">
                            <div class="mb-4 flex items-center justify-between">
                                <span class="sap-day-number {{ $isVehicleToday ? 'sap-day-today' : '' }}">{{ $vehicleDay->day }}</span>

                                @if($dayVehicleBookings->count() > 0)
                                    <span class="sap-count-badge">{{ $dayVehicleBookings->count() }}</span>
                                @endif
                            </div>

                            <div class="space-y-2">
                                @foreach($dayVehicleBookings->take(3) as $booking)
                                    <button type="button"
                                        onclick="openVehicleBookingModal(this)"
                                        data-title="{{ e($booking->purpose ?? 'Booking Kendaraan') }}"
                                        data-vehicle="{{ e($booking->vehicle?->plate_number ?? 'Menunggu GA') }}"
                                        data-route="{{ e($booking->destination ?? '-') }}"
                                        data-time="{{ $booking->departure_datetime?->format('d/m/Y H:i') ?? '-' }} - {{ $booking->return_datetime?->format('d/m/Y H:i') ?? '-' }}"
                                        data-requester="{{ e($booking->requester_name ?? '-') }}"
                                        data-status="{{ e($booking->status ?? '-') }}"
                                        class="sap-booking-card {{ in_array($booking->status, ['approved','on_trip','returned']) ? 'sap-booking-success' : 'sap-booking-warning' }}">
                                        <div class="truncate font-black">
                                            {{ $booking->departure_datetime?->format('H:i') ?? '-' }}
                                            -
                                            {{ $booking->return_datetime?->format('H:i') ?? '-' }}
                                            · {{ $booking->vehicle?->plate_number ?? 'Menunggu GA' }}
                                        </div>
                                        <div class="mt-1 truncate font-semibold">{{ $booking->destination ?? '-' }}</div>
                                        <div class="mt-1 truncate text-[11px]">Oleh: {{ $booking->requester_name ?? '-' }}</div>
                                    </button>
                                @endforeach

                                @if($dayVehicleBookings->count() > 3)
                                    <div class="text-xs font-black text-[#0a6ed1]">
                                        +{{ $dayVehicleBookings->count() - 3 }} booking lagi
                                    </div>
                                @endif
                            </div>
                        </div>

                        @php $vehicleDay->addDay(); @endphp
                    @endwhile
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="mt-10 border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        © {{ date('Y') }} <strong>PT Pro Energi</strong> — Service Management
    </footer>
</div>

{{-- MODAL FORM TICKET, DETAIL TICKET, ROOM, VEHICLE, CHATBOT --}}
{{-- Bagian modal dan script bawah dari file lama Anda tetap digunakan tanpa perubahan --}}

<script>
    function updateClock() {
        const clock = document.getElementById('clock');

        if (clock) {
            clock.innerText = new Date().toLocaleString('id-ID', {
                weekday: 'long',
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }

    updateClock();
    setInterval(updateClock, 1000);

    function openRoomBookingModal(el) {
        document.getElementById('modalRoomTitle').innerText = el.dataset.title || '-';
        document.getElementById('modalRoomName').innerText = el.dataset.room || '-';
        document.getElementById('modalRoomCabang').innerText = el.dataset.cabang || '-';
        document.getElementById('modalRoomTime').innerText = el.dataset.time || '-';
        document.getElementById('modalRoomRequester').innerText = el.dataset.requester || '-';
        document.getElementById('modalRoomStatus').innerText = el.dataset.status || '-';
        document.getElementById('modalRoomPurpose').innerText = el.dataset.purpose || '-';

        const modal = document.getElementById('roomBookingModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRoomBookingModal() {
        const modal = document.getElementById('roomBookingModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openVehicleBookingModal(el) {
        document.getElementById('modalVehicleTitle').innerText = el.dataset.title || '-';
        document.getElementById('modalVehicleName').innerText = el.dataset.vehicle || '-';
        document.getElementById('modalVehicleRoute').innerText = el.dataset.route || '-';
        document.getElementById('modalVehicleTime').innerText = el.dataset.time || '-';
        document.getElementById('modalVehicleRequester').innerText = el.dataset.requester || '-';
        document.getElementById('modalVehicleStatus').innerText = el.dataset.status || '-';

        const modal = document.getElementById('vehicleBookingModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeVehicleBookingModal() {
        const modal = document.getElementById('vehicleBookingModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

</body>
</html>