<x-app-layout>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard GA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800">

<main class="w-full space-y-6 px-6 py-8 lg:px-10 xl:px-14">

    {{-- HEADER --}}
    <section class="overflow-hidden rounded-[2rem] bg-[#0B1F3A] p-6 text-white shadow-xl">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow">
                    <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10 w-auto">
                </div>

                <div>
                    <div class="text-xs font-black uppercase tracking-widest text-blue-100">
                        Facility Management
                    </div>
                    <h1 class="text-3xl font-black">Dashboard GA</h1>
                    <p class="mt-1 text-sm text-blue-100">
                        Monitoring booking ruangan, kendaraan, tamu, dan approval GA.
                    </p>
                </div>
            </div>

            <div class="rounded-3xl bg-white/10 px-5 py-4 ring-1 ring-white/15">
                <div class="text-xs text-blue-100">Tanggal</div>
                <div class="mt-1 font-black">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
        </div>
    </section>

    {{-- SUMMARY --}}
    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-black text-slate-400">Booking Ruangan Hari Ini</p>
            <div class="mt-3 text-4xl font-black text-[#0B1F3A]">{{ $summary['room_today'] ?? 0 }}</div>
        </div>

        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-black text-slate-400">Booking Kendaraan Hari Ini</p>
            <div class="mt-3 text-4xl font-black text-[#0B1F3A]">{{ $summary['vehicle_today'] ?? 0 }}</div>
        </div>

        <div class="rounded-3xl bg-emerald-50 p-5 shadow-sm ring-1 ring-emerald-200">
            <p class="text-sm font-black text-emerald-700">Tamu Aktif</p>
            <div class="mt-3 text-4xl font-black text-emerald-700">{{ $summary['guest_active'] ?? 0 }}</div>
        </div>

        <div class="rounded-3xl bg-blue-50 p-5 shadow-sm ring-1 ring-blue-200">
            <p class="text-sm font-black text-blue-700">Kendaraan On Trip</p>
            <div class="mt-3 text-4xl font-black text-blue-700">{{ $summary['vehicle_on_trip'] ?? 0 }}</div>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl bg-amber-50 p-5 shadow-sm ring-1 ring-amber-200">
            <p class="text-sm font-black text-amber-700">Pending Approval Ruangan</p>
            <div class="mt-3 text-4xl font-black text-amber-700">{{ $summary['room_pending'] ?? 0 }}</div>
        </div>

        <div class="rounded-3xl bg-orange-50 p-5 shadow-sm ring-1 ring-orange-200">
            <p class="text-sm font-black text-orange-700">Pending Approval Kendaraan</p>
            <div class="mt-3 text-4xl font-black text-orange-700">{{ $summary['vehicle_pending'] ?? 0 }}</div>
        </div>

        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-black text-slate-400">Total Ruangan Aktif</p>
            <div class="mt-3 text-4xl font-black text-slate-800">{{ $summary['total_rooms'] ?? 0 }}</div>
        </div>

        <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-black text-slate-400">Total Kendaraan Aktif</p>
            <div class="mt-3 text-4xl font-black text-slate-800">{{ $summary['total_vehicles'] ?? 0 }}</div>
        </div>
    </section>

    {{-- MAIN CONTENT --}}
    <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- ROOM TODAY --}}
        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Booking Ruangan Hari Ini</h2>
                        <p class="text-sm text-slate-500">Jadwal pemakaian ruang meeting hari ini.</p>
                    </div>

                    <a href="{{ route('room-bookings.index') }}"
                       class="rounded-2xl bg-[#0B1F3A] px-4 py-2 text-xs font-black text-white">
                        Lihat
                    </a>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($roomBookingsToday as $booking)
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs font-black text-blue-700">
                                    {{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}
                                </div>

                                <div class="mt-1 font-black text-slate-800">
                                    {{ $booking->title ?? '-' }}
                                </div>

                                <div class="mt-1 text-sm text-slate-500">
                                    {{ $booking->room?->room_name ?? '-' }} · {{ $booking->requester_name ?? '-' }}
                                </div>
                            </div>

                            <span class="rounded-full px-3 py-1 text-xs font-black uppercase
                                {{ $booking->status === 'approved'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : 'bg-amber-100 text-amber-700' }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm font-bold text-slate-400">
                        Tidak ada booking ruangan hari ini.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- VEHICLE TODAY --}}
        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Booking Kendaraan Hari Ini</h2>
                        <p class="text-sm text-slate-500">Jadwal pemakaian kendaraan operasional.</p>
                    </div>

                    <a href="{{ route('vehicle-bookings.index') }}"
                       class="rounded-2xl bg-[#0B1F3A] px-4 py-2 text-xs font-black text-white">
                        Lihat
                    </a>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($vehicleBookingsToday as $booking)
                    <div class="p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="text-xs font-black text-blue-700">
                                    {{ $booking->departure_datetime?->format('H:i') ?? '-' }}
                                    -
                                    {{ $booking->return_datetime?->format('H:i') ?? '-' }}
                                </div>

                                <div class="mt-1 font-black text-slate-800">
                                    {{ $booking->vehicle?->plate_number ?? 'Menunggu GA' }}
                                </div>

                                <div class="mt-1 text-sm text-slate-500">
                                    {{ $booking->destination ?? '-' }} · {{ $booking->requester_name ?? '-' }}
                                </div>
                            </div>

                            <span class="rounded-full px-3 py-1 text-xs font-black uppercase
                                {{ $booking->status === 'on_trip'
                                    ? 'bg-blue-100 text-blue-700'
                                    : ($booking->status === 'approved'
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : 'bg-amber-100 text-amber-700') }}">
                                {{ str_replace('_', ' ', $booking->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm font-bold text-slate-400">
                        Tidak ada booking kendaraan hari ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- SECOND CONTENT --}}
    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- ACTIVE GUEST --}}
        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 xl:col-span-1">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Tamu Aktif</h2>
                        <p class="text-sm text-slate-500">Tamu yang masih berada di kantor.</p>
                    </div>

                    <a href="{{ route('guests.index') }}"
                       class="rounded-2xl bg-[#0B1F3A] px-4 py-2 text-xs font-black text-white">
                        Lihat
                    </a>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($activeGuests as $guest)
                    <div class="p-5">
                        <div class="font-black text-slate-800">{{ $guest->guest_name }}</div>
                        <div class="mt-1 text-sm text-slate-500">
                            {{ $guest->company_name ?? '-' }}
                        </div>
                        <div class="mt-2 text-xs font-bold text-emerald-700">
                            Check-In {{ $guest->checkin_at?->format('H:i') ?? '-' }}
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-sm font-bold text-slate-400">
                        Tidak ada tamu aktif.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PENDING APPROVAL --}}
        <div class="grid grid-cols-1 gap-6 xl:col-span-2">

            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-100 px-6 py-5">
                    <h2 class="text-lg font-black text-slate-800">Pending Approval Ruangan</h2>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($pendingRooms as $booking)
                        <div class="flex flex-col gap-3 p-5 md:flex-row md:items-center md:justify-between">
                            <div>
                                <div class="font-black text-slate-800">{{ $booking->title ?? '-' }}</div>
                                <div class="text-sm text-slate-500">
                                    {{ $booking->room?->room_name ?? '-' }} ·
                                    {{ $booking->booking_date?->format('d/m/Y') ?? '-' }}
                                    {{ substr($booking->start_time, 0, 5) }}
                                </div>
                            </div>

                            <a href="{{ route('room-bookings.show', $booking) }}"
                               class="rounded-2xl bg-amber-50 px-4 py-2 text-xs font-black text-amber-700">
                                Review
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center text-sm font-bold text-slate-400">
                            Tidak ada pending approval ruangan.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-100 px-6 py-5">
                    <h2 class="text-lg font-black text-slate-800">Pending Approval Kendaraan</h2>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($pendingVehicles as $booking)
                        <div class="flex flex-col gap-3 p-5 md:flex-row md:items-center md:justify-between">
                            <div>
                                <div class="font-black text-slate-800">{{ $booking->destination ?? '-' }}</div>
                                <div class="text-sm text-slate-500">
                                    {{ $booking->departure_datetime?->format('d/m/Y H:i') ?? '-' }} ·
                                    {{ $booking->requester_name ?? '-' }}
                                </div>
                            </div>

                            <a href="{{ route('vehicle-bookings.show', $booking) }}"
                               class="rounded-2xl bg-amber-50 px-4 py-2 text-xs font-black text-amber-700">
                                Review
                            </a>
                        </div>
                    @empty
                        <div class="p-8 text-center text-sm font-bold text-slate-400">
                            Tidak ada pending approval kendaraan.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>

</main>

</body>
</html>
</x-app-layout>