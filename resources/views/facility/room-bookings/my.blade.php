<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Ruangan Saya</title>

    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-[#f8fbff] to-[#eef6ff] font-sans text-slate-800">

    @php
        $totalBooking = $bookings->total();
        $pendingCount = $bookings->where('status', 'pending')->count();
        $approvedCount = $bookings->where('status', 'approved')->count();
        $cancelledCount = $bookings->where('status', 'cancelled')->count();

        function roomBookingStatusClass($status)
        {
            return match ($status) {
                'pending' => 'bg-orange-100 text-orange-700 ring-1 ring-orange-200',
                'approved' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
                'rejected' => 'bg-rose-100 text-rose-700 ring-1 ring-rose-200',
                'completed' => 'bg-blue-100 text-blue-700 ring-1 ring-blue-200',
                'cancelled' => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
                default => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
            };
        }

        function roomBookingStatusIcon($status)
        {
            return match ($status) {
                'pending' => '⏳',
                'approved' => '✅',
                'rejected' => '❌',
                'completed' => '🏁',
                'cancelled' => '🚫',
                default => '📌',
            };
        }
    @endphp

    {{-- HEADER --}}
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur shadow-sm">
        <div class="mx-auto max-w-[1600px] px-5 py-4 lg:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-md ring-1 ring-slate-200">
                        <img src="{{ asset('images/proenergi-logo.png') }}"
                            class="h-10 w-auto object-contain">
                    </div>

                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                            Booking Ruangan Saya
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Monitoring pengajuan booking ruangan dan jadwal meeting internal.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">

                    <a href="{{ route('room-bookings.create') }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#1C7ED6] px-5 py-3 text-sm font-bold text-white shadow-lg transition hover:scale-[1.02]">
                        <span>+</span>
                        Booking Ruangan
                    </a>

                    <a href="{{ url('/') }}"
                        class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Kembali
                    </a>

                </div>
            </div>
        </div>
    </header>

    <main class="py-8">
        <div class="mx-auto max-w-[1600px] space-y-6 px-5 lg:px-8">

            {{-- ALERT --}}
            @if (session('success'))
                <div
                    class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-700 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- HERO --}}
           {{-- HERO --}}
<section class="overflow-hidden rounded-[32px] bg-[#0F5DA9] shadow-xl">
    <div class="px-8 py-8 lg:px-10">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="text-white">
                <div class="inline-flex rounded-full bg-orange-500 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-white">
                    Facility Management
                </div>

                <h2 class="mt-5 text-3xl font-black text-white">
                    Dashboard Booking Ruangan
                </h2>

                <p class="mt-2 max-w-3xl text-sm text-blue-100">
                    Kelola booking meeting room, jadwal rapat, approval, dan monitoring penggunaan ruangan perusahaan.
                </p>
            </div>

            <div class="rounded-3xl bg-white px-6 py-5 text-slate-800 shadow-lg">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    Login Sebagai
                </div>
                <div class="mt-2 text-lg font-black text-slate-800">
                    {{ auth()->user()->name ?? '-' }}
                </div>
                <div class="text-sm text-slate-500">
                    {{ auth()->user()->email ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</section>

            {{-- SUMMARY --}}
            <section class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">

                {{-- TOTAL --}}
                <div
                    class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                    <div class="flex items-center justify-between">
                        <div class="text-sm font-bold text-slate-500">
                            Total Booking
                        </div>

                        <div
                            class="rounded-full bg-blue-100 px-3 py-1 text-xs font-black text-blue-700">
                            ALL
                        </div>
                    </div>

                    <div class="mt-5 text-5xl font-black tracking-tight text-slate-800">
                        {{ $totalBooking }}
                    </div>

                    <div class="mt-3 text-sm text-slate-400">
                        Total seluruh booking ruangan
                    </div>
                </div>

                {{-- PENDING --}}
                <div
                    class="rounded-[28px] border border-orange-200 bg-gradient-to-br from-orange-50 to-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                    <div class="flex items-center justify-between">
                        <div class="text-sm font-bold text-orange-700">
                            Pending Approval
                        </div>

                        <div
                            class="rounded-full bg-orange-100 px-3 py-1 text-xs font-black text-orange-700">
                            WAIT
                        </div>
                    </div>

                    <div class="mt-5 text-5xl font-black tracking-tight text-orange-700">
                        {{ $pendingCount }}
                    </div>

                    <div class="mt-3 text-sm text-orange-600">
                        Menunggu approval GA/Admin
                    </div>
                </div>

                {{-- APPROVED --}}
                <div
                    class="rounded-[28px] border border-emerald-200 bg-gradient-to-br from-emerald-50 to-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                    <div class="flex items-center justify-between">
                        <div class="text-sm font-bold text-emerald-700">
                            Approved
                        </div>

                        <div
                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-black text-emerald-700">
                            OK
                        </div>
                    </div>

                    <div class="mt-5 text-5xl font-black tracking-tight text-emerald-700">
                        {{ $approvedCount }}
                    </div>

                    <div class="mt-3 text-sm text-emerald-600">
                        Booking sudah disetujui
                    </div>
                </div>

                {{-- CANCEL --}}
                <div
                    class="rounded-[28px] border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">

                    <div class="flex items-center justify-between">
                        <div class="text-sm font-bold text-slate-500">
                            Cancelled
                        </div>

                        <div
                            class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-600">
                            CANCEL
                        </div>
                    </div>

                    <div class="mt-5 text-5xl font-black tracking-tight text-slate-700">
                        {{ $cancelledCount }}
                    </div>

                    <div class="mt-3 text-sm text-slate-400">
                        Booking dibatalkan
                    </div>
                </div>

            </section>

            @php
    $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $calendarDate = \Carbon\Carbon::create($year, $month, 1);
    $startOfMonth = $calendarDate->copy()->startOfMonth();
    $endOfMonth = $calendarDate->copy()->endOfMonth();

    $startCalendar = $startOfMonth->copy()->startOfWeek(\Carbon\Carbon::MONDAY);
    $endCalendar = $endOfMonth->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);

    $bookingsByDate = $calendarBookings->groupBy(function ($item) {
        return $item->booking_date->format('Y-m-d');
    });
@endphp

            {{-- CALENDAR --}}
            <section
                class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-xl">

                <div
                    class="border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white px-8 py-6">

                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                        <div>
                            <h3 class="text-2xl font-black text-slate-800">
                                Kalender Booking
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Monitoring penggunaan ruangan berdasarkan tanggal.
                            </p>
                        </div>

                        <form method="GET" action="{{ route('room-bookings.my') }}" class="flex flex-wrap gap-3">

                            <select name="month" class="rounded-2xl border-slate-300 text-sm font-semibold shadow-sm">
                                @foreach ($months as $num => $label)
                                    <option value="{{ $num }}" @selected($month == $num)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        
                            <select name="year" class="rounded-2xl border-slate-300 text-sm font-semibold shadow-sm">
                                @for ($y = now()->year - 2; $y <= now()->year + 2; $y++)
                                    <option value="{{ $y }}" @selected($year == $y)>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        
                            <select name="room_id" class="rounded-2xl border-slate-300 text-sm font-semibold shadow-sm">
                                <option value="">Semua Ruangan</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" @selected($roomId == $room->id)>
                                        {{ $room->room_name }}
                                    </option>
                                @endforeach
                            </select>
                        
                            <select name="cabang" class="rounded-2xl border-slate-300 text-sm font-semibold shadow-sm">
                                <option value="">Semua Cabang</option>
                                @foreach ($cabangs as $item)
                                    <option value="{{ $item }}" @selected($cabang == $item)>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        
                            <button class="rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#F97316] px-6 py-3 text-sm font-bold text-white shadow-lg">
                                Filter
                            </button>
                        </form>
                    </div>
                </div>

                {{-- DAY HEADER --}}
                <div
                    class="grid grid-cols-7 border-b border-slate-100 bg-[#0F172A] text-center text-xs font-black uppercase tracking-widest text-white">

                    <div class="px-2 py-4">Senin</div>
                    <div class="px-2 py-4">Selasa</div>
                    <div class="px-2 py-4">Rabu</div>
                    <div class="px-2 py-4">Kamis</div>
                    <div class="px-2 py-4">Jumat</div>
                    <div class="px-2 py-4">Sabtu</div>
                    <div class="px-2 py-4">Minggu</div>

                </div>

                {{-- GRID --}}
                <div class="grid grid-cols-7">

                    @php
                        $day = $startCalendar->copy();
                    @endphp

                    @while ($day <= $endCalendar)
                        @php
                            $dateKey = $day->format('Y-m-d');
                            $dayBookings = $bookingsByDate->get(
                                $dateKey,
                                collect(),
                            );

                            $isCurrentMonth = $day->month == $month;
                            $isToday = $day->isToday();
                        @endphp

                        <div
                            class="min-h-[180px] border-b border-r border-slate-100 p-3 transition hover:bg-blue-50/40
                        {{ !$isCurrentMonth ? 'bg-slate-50/60 text-slate-300' : 'bg-white' }}
                        {{ $isToday ? 'ring-2 ring-inset ring-[#1C7ED6]' : '' }}">

                            <div
                                class="mb-3 flex items-center justify-between">

                                <span
                                    class="flex h-9 w-9 items-center justify-center rounded-2xl text-sm font-black
                                {{ $isToday ? 'bg-[#1C7ED6] text-white shadow-lg' : 'bg-slate-100 text-slate-700' }}">

                                    {{ $day->day }}
                                </span>

                                @if ($dayBookings->count() > 0)
                                    <span
                                        class="rounded-full bg-orange-100 px-2 py-1 text-[10px] font-black text-orange-700">
                                        {{ $dayBookings->count() }}
                                    </span>
                                @endif

                            </div>

                            <div class="space-y-2">

                                @foreach ($dayBookings->take(3) as $booking)
                                <button type="button"
                                    onclick="openBookingModal(this)"
                                    data-booking-number="{{ $booking->booking_number }}"
                                    data-title="{{ e($booking->title) }}"
                                    data-room="{{ e($booking->room?->room_name ?? '-') }}"
                                    data-cabang="{{ e($booking->room?->location ?? '-') }}"
                                    data-date="{{ $booking->booking_date?->format('d/m/Y') }}"
                                    data-time="{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}"
                                    data-requester="{{ e($booking->requester_name ?? '-') }}"
                                    data-email="{{ e($booking->requester_email ?? '-') }}"
                                    data-status="{{ e($booking->status) }}"
                                    data-purpose="{{ e($booking->purpose ?? '-') }}"
                                    class="w-full text-left rounded-2xl border px-3 py-2 text-[11px] shadow-sm transition hover:scale-[1.02]
                                    {{ $booking->status === 'approved'
                                        ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
                                        : 'border-orange-200 bg-orange-50 text-orange-700' }}">
                            
                                    <div class="font-black truncate">
                                        {{ substr($booking->start_time, 0, 5) }}
                                        -
                                        {{ substr($booking->end_time, 0, 5) }}
                                        ·
                                        {{ $booking->room?->room_name ?? '-' }}
                                    </div>
                            
                                    <div class="mt-1 truncate">
                                        {{ $booking->title }}
                                    </div>
                            
                                    <div class="mt-1 truncate text-[10px] opacity-80">
                                        Oleh: {{ $booking->requester_name ?? '-' }}
                                    </div>
                                </button>
                            @endforeach

                                @if ($dayBookings->count() > 3)
                                    <div
                                        class="text-[11px] font-black text-[#1C7ED6]">
                                        +{{ $dayBookings->count() - 3 }}
                                        booking lagi
                                    </div>
                                @endif

                            </div>
                        </div>

                        @php
                            $day->addDay();
                        @endphp
                    @endwhile

                </div>
            </section>

        </div>
    </main>

    <div id="bookingModal"
     class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-2xl overflow-hidden rounded-[32px] bg-white shadow-2xl">
        <div class="bg-[#0F5DA9] px-6 py-5 text-white">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div id="modalBookingNumber" class="text-xs font-bold uppercase text-blue-100"></div>
                    <h3 id="modalTitle" class="mt-2 text-2xl font-black"></h3>
                </div>

                <button type="button"
                        onclick="closeBookingModal()"
                        class="rounded-2xl bg-white/15 px-3 py-2 text-sm font-bold hover:bg-white/25">
                    ✕
                </button>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase text-slate-400">Ruangan</div>
                    <div id="modalRoom" class="mt-1 font-bold text-slate-800"></div>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase text-slate-400">Cabang / Lokasi</div>
                    <div id="modalCabang" class="mt-1 font-bold text-slate-800"></div>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase text-slate-400">Tanggal</div>
                    <div id="modalDate" class="mt-1 font-bold text-slate-800"></div>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase text-slate-400">Jam Booking</div>
                    <div id="modalTime" class="mt-1 font-bold text-slate-800"></div>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase text-slate-400">Dibooking Oleh</div>
                    <div id="modalRequester" class="mt-1 font-bold text-slate-800"></div>
                    <div id="modalEmail" class="text-xs text-slate-500"></div>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <div class="text-xs font-black uppercase text-slate-400">Status</div>
                    <div id="modalStatus" class="mt-1 font-bold uppercase text-orange-600"></div>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                    <div class="text-xs font-black uppercase text-slate-400">Keterangan / Agenda</div>
                    <div id="modalPurpose" class="mt-1 whitespace-pre-line text-sm text-slate-700"></div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button"
                        onclick="closeBookingModal()"
                        class="rounded-2xl bg-slate-900 px-5 py-3 text-sm font-bold text-white hover:bg-slate-800">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openBookingModal(el) {
        document.getElementById('modalBookingNumber').innerText = el.dataset.bookingNumber || '-';
        document.getElementById('modalTitle').innerText = el.dataset.title || '-';
        document.getElementById('modalRoom').innerText = el.dataset.room || '-';
        document.getElementById('modalCabang').innerText = el.dataset.cabang || '-';
        document.getElementById('modalDate').innerText = el.dataset.date || '-';
        document.getElementById('modalTime').innerText = el.dataset.time || '-';
        document.getElementById('modalRequester').innerText = el.dataset.requester || '-';
        document.getElementById('modalEmail').innerText = el.dataset.email || '-';
        document.getElementById('modalStatus').innerText = el.dataset.status || '-';
        document.getElementById('modalPurpose').innerText = el.dataset.purpose || '-';

        const modal = document.getElementById('bookingModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('bookingModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeBookingModal();
        }
    });
</script>

</body>

</html>