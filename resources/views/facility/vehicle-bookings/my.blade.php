<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking Kendaraan Saya</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800">

@php
    $calendarDate = \Carbon\Carbon::create($year, $month, 1);
    $startOfMonth = $calendarDate->copy()->startOfMonth();
    $endOfMonth = $calendarDate->copy()->endOfMonth();
    $startCalendar = $startOfMonth->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
    $endCalendar = $endOfMonth->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

    $bookingsByDate = $calendarBookings->groupBy(fn($item) => $item->departure_datetime?->format('Y-m-d'));

    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    $totalBooking = $calendarBookings->count();
    $pendingCount = $calendarBookings->where('status', 'pending')->count();
    $approvedCount = $calendarBookings->where('status', 'approved')->count();
    $onTripCount = $calendarBookings->where('status', 'on_trip')->count();
@endphp

<header class="border-b bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-5">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10 w-auto">

                <div>
                    <h1 class="text-2xl font-black text-[#0B1F3A]">Booking Kendaraan Saya</h1>
                    <p class="text-sm text-slate-500">Pantau jadwal booking kendaraan dalam tampilan kalender.</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('vehicle-bookings.create') }}"
                   class="rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-bold text-white hover:bg-[#123B6D]">
                    + Booking Kendaraan
                </a>

                <a href="{{ url('/') }}"
                   class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</header>

<main class="mx-auto max-w-7xl space-y-6 px-4 py-8">

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    <section class="overflow-hidden rounded-3xl bg-[#0B1F3A] shadow-xl">
        <div class="px-6 py-7 text-white">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <div class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-black">
                        Facility Management
                    </div>

                    <h2 class="mt-3 text-2xl font-black">Kalender Booking Kendaraan</h2>

                    <p class="mt-1 max-w-2xl text-sm text-blue-100">
                        Lihat jadwal kendaraan berdasarkan bulan, tahun, dan status booking.
                    </p>
                </div>

                <div class="rounded-3xl bg-white/10 px-5 py-4 ring-1 ring-white/20">
                    <div class="text-xs text-blue-100">Login sebagai</div>
                    <div class="mt-1 font-black text-white">{{ auth()->user()->name ?? '-' }}</div>
                    <div class="text-xs text-blue-100">{{ auth()->user()->email ?? '-' }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm font-bold text-slate-500">Total Bulan Ini</div>
            <div class="mt-3 text-3xl font-black text-[#0B1F3A]">{{ $totalBooking }}</div>
            <p class="mt-2 text-xs text-slate-400">Booking sesuai filter kalender</p>
        </div>

        <div class="rounded-3xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
            <div class="text-sm font-bold text-amber-700">Pending</div>
            <div class="mt-3 text-3xl font-black text-amber-700">{{ $pendingCount }}</div>
            <p class="mt-2 text-xs text-amber-600">Menunggu approval GA/Admin</p>
        </div>

        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
            <div class="text-sm font-bold text-emerald-700">Approved</div>
            <div class="mt-3 text-3xl font-black text-emerald-700">{{ $approvedCount }}</div>
            <p class="mt-2 text-xs text-emerald-600">Sudah disetujui</p>
        </div>

        <div class="rounded-3xl border border-blue-200 bg-blue-50 p-5 shadow-sm">
            <div class="text-sm font-bold text-blue-700">On Trip</div>
            <div class="mt-3 text-3xl font-black text-blue-700">{{ $onTripCount }}</div>
            <p class="mt-2 text-xs text-blue-600">Kendaraan sedang digunakan</p>
        </div>
    </section>

    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-lg font-black text-slate-800">Kalender Booking Kendaraan</h3>
                    <p class="text-sm text-slate-500">
                        Periode: {{ $months[$month] }} {{ $year }}
                    </p>
                </div>

                <form method="GET" action="{{ route('vehicle-bookings.my') }}" class="flex flex-wrap gap-3">
                    <select name="month" class="rounded-2xl border-slate-300 text-sm font-bold focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                        @foreach($months as $num => $label)
                            <option value="{{ $num }}" @selected($month == $num)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <select name="year" class="rounded-2xl border-slate-300 text-sm font-bold focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                        @for($y = now()->year - 2; $y <= now()->year + 2; $y++)
                            <option value="{{ $y }}" @selected($year == $y)>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>

                    <select name="status" class="rounded-2xl border-slate-300 text-sm font-bold focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                        <option value="">Semua Status</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="approved" @selected($status === 'approved')>Approved</option>
                        <option value="on_trip" @selected($status === 'on_trip')>On Trip</option>
                        <option value="returned" @selected($status === 'returned')>Returned</option>
                        <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
                        <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                    </select>

                    <button class="rounded-2xl bg-[#0B1F3A] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#123B6D]">
                        Filter
                    </button>

                    <a href="{{ route('vehicle-bookings.my') }}"
                       class="rounded-2xl bg-slate-200 px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-300">
                        Reset
                    </a>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50 text-center text-xs font-black uppercase tracking-wide text-slate-500">
            <div class="px-2 py-3">Sen</div>
            <div class="px-2 py-3">Sel</div>
            <div class="px-2 py-3">Rab</div>
            <div class="px-2 py-3">Kam</div>
            <div class="px-2 py-3">Jum</div>
            <div class="px-2 py-3">Sab</div>
            <div class="px-2 py-3">Min</div>
        </div>

        <div class="grid grid-cols-7">
            @php $day = $startCalendar->copy(); @endphp

            @while($day <= $endCalendar)
                @php
                    $dateKey = $day->format('Y-m-d');
                    $dayBookings = $bookingsByDate->get($dateKey, collect());
                    $isCurrentMonth = $day->month == $month;
                    $isToday = $day->isToday();
                @endphp

                <div class="min-h-[150px] border-b border-r border-slate-100 p-2
                    {{ !$isCurrentMonth ? 'bg-slate-50/70 text-slate-300' : 'bg-white' }}
                    {{ $isToday ? 'ring-2 ring-inset ring-[#0B1F3A]' : '' }}">

                    <div class="mb-2 flex items-center justify-between">
                        <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-black
                            {{ $isToday ? 'bg-[#0B1F3A] text-white' : 'text-slate-700' }}">
                            {{ $day->day }}
                        </span>

                        @if($dayBookings->count() > 0)
                            <span class="rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-black text-[#0B1F3A]">
                                {{ $dayBookings->count() }}
                            </span>
                        @endif
                    </div>

                    <div class="space-y-1">
                        @foreach($dayBookings->take(3) as $booking)
                            <button type="button"
                                onclick="openVehicleBookingModal(this)"
                                data-title="{{ e($booking->purpose ?? 'Booking Kendaraan') }}"
                                data-number="{{ e($booking->booking_number ?? '-') }}"
                                data-vehicle="{{ e($booking->vehicle?->plate_number ?? 'Menunggu GA') }}"
                                data-vehicle-name="{{ e($booking->vehicle?->vehicle_name ?? '-') }}"
                                data-destination="{{ e($booking->destination ?? '-') }}"
                                data-time="{{ $booking->departure_datetime?->format('d/m/Y H:i') ?? '-' }} - {{ $booking->return_datetime?->format('d/m/Y H:i') ?? '-' }}"
                                data-requester="{{ e($booking->requester_name ?? '-') }}"
                                data-passenger="{{ e($booking->passenger_count ?? '-') }}"
                                data-passenger-names="{{ e($booking->passenger_names ?? '-') }}"
                                data-status="{{ e($booking->status ?? '-') }}"
                                data-notes="{{ e($booking->notes ?? '-') }}"
                                data-edit-url="{{ $booking->status === 'pending' ? route('vehicle-bookings.edit', $booking) : '' }}"
                                data-cancel-url="{{ $booking->status === 'pending' ? route('vehicle-bookings.cancel', $booking) : '' }}"
                                class="w-full rounded-xl border px-2 py-1 text-left text-[11px] transition hover:scale-[1.01]
                                    {{ $booking->status === 'approved'
                                        ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                        : ($booking->status === 'on_trip'
                                            ? 'border-blue-200 bg-blue-50 text-blue-700'
                                            : ($booking->status === 'rejected'
                                                ? 'border-rose-200 bg-rose-50 text-rose-700'
                                                : ($booking->status === 'cancelled'
                                                    ? 'border-slate-200 bg-slate-50 text-slate-500'
                                                    : ($booking->status === 'returned'
                                                        ? 'border-slate-200 bg-slate-100 text-slate-700'
                                                        : 'border-amber-200 bg-amber-50 text-amber-700')))) }}">
                                <div class="truncate font-black">
                                    {{ $booking->departure_datetime?->format('H:i') ?? '-' }}
                                    -
                                    {{ $booking->vehicle?->plate_number ?? 'Menunggu GA' }}
                                </div>
                                <div class="truncate">
                                    {{ $booking->destination ?? '-' }}
                                </div>
                            </button>
                        @endforeach

                        @if($dayBookings->count() > 3)
                            <div class="text-[11px] font-bold text-[#0B1F3A]">
                                +{{ $dayBookings->count() - 3 }} booking lagi
                            </div>
                        @endif
                    </div>
                </div>

                @php $day->addDay(); @endphp
            @endwhile
        </div>
    </section>
</main>

{{-- MODAL DETAIL --}}
<div id="vehicleBookingModal" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-2xl overflow-hidden rounded-3xl bg-white shadow-2xl">
        <div class="bg-[#0B1F3A] px-6 py-5 text-white">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-black uppercase text-blue-100">Detail Booking Kendaraan</p>
                    <h3 id="modalVehicleTitle" class="mt-2 text-2xl font-black"></h3>
                    <p id="modalVehicleNumber" class="mt-1 text-sm text-blue-100"></p>
                </div>

                <button type="button" onclick="closeVehicleBookingModal()"
                    class="rounded-xl bg-white/15 px-3 py-2 font-bold hover:bg-white/25">
                    ✕
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 p-6 md:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4">
                <div class="text-xs font-black uppercase text-slate-400">Kendaraan</div>
                <div id="modalVehicleName" class="mt-1 font-bold text-slate-800"></div>
                <div id="modalVehicleDesc" class="text-xs text-slate-400"></div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <div class="text-xs font-black uppercase text-slate-400">Tujuan</div>
                <div id="modalVehicleDestination" class="mt-1 font-bold text-slate-800"></div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <div class="text-xs font-black uppercase text-slate-400">Waktu</div>
                <div id="modalVehicleTime" class="mt-1 font-bold text-slate-800"></div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <div class="text-xs font-black uppercase text-slate-400">Requester</div>
                <div id="modalVehicleRequester" class="mt-1 font-bold text-slate-800"></div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <div class="text-xs font-black uppercase text-slate-400">Jumlah Penumpang</div>
                <div id="modalVehiclePassenger" class="mt-1 font-bold text-slate-800"></div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4">
                <div class="text-xs font-black uppercase text-slate-400">Status</div>
                <div id="modalVehicleStatus" class="mt-1 inline-flex rounded-full px-3 py-1 text-xs font-black uppercase"></div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                <div class="text-xs font-black uppercase text-slate-400">Nama Penumpang</div>
                <div id="modalVehiclePassengerNames" class="mt-1 whitespace-pre-line text-sm text-slate-700"></div>
            </div>

            <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                <div class="text-xs font-black uppercase text-slate-400">Catatan</div>
                <div id="modalVehicleNotes" class="mt-1 whitespace-pre-line text-sm text-slate-700"></div>
            </div>
        </div>

        <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 px-6 py-4">
            <a id="modalVehicleEditBtn"
               href="#"
               class="hidden rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-white hover:bg-amber-600">
                Edit Booking
            </a>

            <form id="modalVehicleCancelForm" method="POST" action="#" class="hidden">
                @csrf
                @method('PATCH')

                <button type="submit"
                    onclick="return confirm('Yakin ingin membatalkan booking kendaraan ini?')"
                    class="rounded-2xl bg-rose-500 px-5 py-3 text-sm font-black text-white hover:bg-rose-600">
                    Cancel Booking
                </button>
            </form>

            <button type="button"
                onclick="closeVehicleBookingModal()"
                class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-black text-slate-700 hover:bg-slate-300">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function setStatusClass(statusEl, status) {
        statusEl.className = 'mt-1 inline-flex rounded-full px-3 py-1 text-xs font-black uppercase';

        if (status === 'pending') {
            statusEl.classList.add('bg-amber-100', 'text-amber-700', 'ring-1', 'ring-amber-200');
        } else if (status === 'approved') {
            statusEl.classList.add('bg-emerald-100', 'text-emerald-700', 'ring-1', 'ring-emerald-200');
        } else if (status === 'on_trip') {
            statusEl.classList.add('bg-blue-100', 'text-blue-700', 'ring-1', 'ring-blue-200');
        } else if (status === 'rejected') {
            statusEl.classList.add('bg-rose-100', 'text-rose-700', 'ring-1', 'ring-rose-200');
        } else if (status === 'cancelled') {
            statusEl.classList.add('bg-gray-100', 'text-gray-500', 'ring-1', 'ring-gray-200');
        } else if (status === 'returned') {
            statusEl.classList.add('bg-slate-100', 'text-slate-700', 'ring-1', 'ring-slate-200');
        } else {
            statusEl.classList.add('bg-slate-100', 'text-slate-600', 'ring-1', 'ring-slate-200');
        }
    }

    function openVehicleBookingModal(el) {
        document.getElementById('modalVehicleTitle').innerText = el.dataset.title || '-';
        document.getElementById('modalVehicleNumber').innerText = el.dataset.number || '-';
        document.getElementById('modalVehicleName').innerText = el.dataset.vehicle || '-';
        document.getElementById('modalVehicleDesc').innerText = el.dataset.vehicleName || '-';
        document.getElementById('modalVehicleDestination').innerText = el.dataset.destination || '-';
        document.getElementById('modalVehicleTime').innerText = el.dataset.time || '-';
        document.getElementById('modalVehicleRequester').innerText = el.dataset.requester || '-';
        document.getElementById('modalVehiclePassenger').innerText = el.dataset.passenger || '-';
        document.getElementById('modalVehiclePassengerNames').innerText = el.dataset.passengerNames || '-';
        document.getElementById('modalVehicleNotes').innerText = el.dataset.notes || '-';

        const status = el.dataset.status || '-';
        const statusEl = document.getElementById('modalVehicleStatus');

        statusEl.innerText = status;
        setStatusClass(statusEl, status);

        const editBtn = document.getElementById('modalVehicleEditBtn');

        if (el.dataset.editUrl) {
            editBtn.href = el.dataset.editUrl;
            editBtn.classList.remove('hidden');
        } else {
            editBtn.href = '#';
            editBtn.classList.add('hidden');
        }

        const cancelForm = document.getElementById('modalVehicleCancelForm');

        if (el.dataset.cancelUrl) {
            cancelForm.action = el.dataset.cancelUrl;
            cancelForm.classList.remove('hidden');
        } else {
            cancelForm.action = '#';
            cancelForm.classList.add('hidden');
        }

        const modal = document.getElementById('vehicleBookingModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeVehicleBookingModal() {
        const modal = document.getElementById('vehicleBookingModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('vehicleBookingModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeVehicleBookingModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeVehicleBookingModal();
        }
    });
</script>

</body>
</html> 