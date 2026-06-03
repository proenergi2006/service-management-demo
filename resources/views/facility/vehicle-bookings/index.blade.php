<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Approval Booking Kendaraan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800">

@php
    function vehicleAdminStatusClass($status) {
        return match($status) {
            'pending' => 'bg-amber-100 text-amber-700 ring-1 ring-amber-200',
            'approved' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
            'rejected' => 'bg-rose-100 text-rose-700 ring-1 ring-rose-200',
            'on_trip' => 'bg-blue-100 text-blue-700 ring-1 ring-blue-200',
            'returned' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
            'cancelled' => 'bg-gray-100 text-gray-500 ring-1 ring-gray-200',
            default => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
        };
    }
@endphp

<header class="border-b bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-5">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10 w-auto">
                <div>
                    <h1 class="text-2xl font-black text-[#0B1F3A]">Approval Booking Kendaraan</h1>
                    <p class="text-sm text-slate-500">Monitoring, approval, start trip, dan return kendaraan operasional.</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('master-vehicles.index') }}"
                   class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                    Master Kendaraan
                </a>

                <a href="{{ route('vehicle-bookings.create') }}"
                   class="rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-bold text-white hover:bg-[#123B6D]">
                    + Booking Kendaraan
                </a>

                <a href="{{ url('/') }}"
                   class="rounded-2xl bg-white px-5 py-3 text-sm font-bold text-[#0B1F3A] ring-1 ring-slate-200 hover:bg-slate-50">
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
                        GA Facility Control
                    </div>

                    <h2 class="mt-3 text-2xl font-black">Dashboard Booking Kendaraan</h2>

                    <p class="mt-1 max-w-2xl text-sm text-blue-100">
                        Gunakan halaman ini untuk menyetujui pengajuan, memulai perjalanan, dan mencatat pengembalian kendaraan.
                    </p>
                </div>

                <div class="rounded-3xl bg-white/10 px-5 py-4 ring-1 ring-white/20">
                    <div class="text-xs text-blue-100">Total Data Tampil</div>
                    <div class="mt-1 text-3xl font-black text-white">{{ $bookings->count() }}</div>
                </div>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-5">
            <h3 class="text-lg font-black text-slate-800">Filter Booking</h3>
            <p class="text-sm text-slate-500">Filter berdasarkan status dan kendaraan.</p>
        </div>

        <form method="GET" action="{{ route('vehicle-bookings.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div>
                <label class="mb-1 block text-sm font-bold text-slate-600">Status</label>
                <select name="status" class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected($status === 'pending')>Pending</option>
                    <option value="approved" @selected($status === 'approved')>Approved</option>
                    <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                    <option value="on_trip" @selected($status === 'on_trip')>On Trip</option>
                    <option value="returned" @selected($status === 'returned')>Returned</option>
                    <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-bold text-slate-600">Kendaraan</label>
                <select name="vehicle_id" class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    <option value="">Semua Kendaraan</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" @selected($vehicleId == $vehicle->id)>
                            {{ $vehicle->plate_number }} - {{ $vehicle->vehicle_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-3">
                <button class="rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-bold text-white hover:bg-[#123B6D]">
                    Filter
                </button>

                <a href="{{ route('vehicle-bookings.index') }}"
                   class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                    Reset
                </a>
            </div>
        </form>
    </section>

    <section class="grid grid-cols-1 gap-5">
        @forelse($bookings as $booking)
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-xs font-black text-[#0B1F3A]">
                                    {{ $booking->booking_number }}
                                </span>

                                <span class="rounded-full px-3 py-1 text-xs font-black uppercase {{ vehicleAdminStatusClass($booking->status) }}">
                                    {{ str_replace('_', ' ', $booking->status) }}
                                </span>
                            </div>

                            <h3 class="mt-2 text-xl font-black text-slate-800">
                                {{ $booking->destination ?? '-' }}
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $booking->purpose ?? 'Tidak ada keperluan tertulis.' }}
                            </p>
                        </div>

                        <div class="text-left lg:text-right">
                            <div class="text-sm font-bold text-slate-500">Pemohon</div>
                            <div class="font-black text-slate-800">{{ $booking->requester_name ?? '-' }}</div>
                            <div class="text-xs text-slate-400">{{ $booking->department ?? '-' }} / {{ $booking->branch ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 p-6 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Kendaraan</div>
                        <div class="mt-1 font-black text-[#0B1F3A]">
                            {{ $booking->vehicle?->plate_number ?? 'Belum ditentukan' }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $booking->vehicle?->vehicle_name ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Waktu Berangkat</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->departure_datetime?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Estimasi Kembali</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->return_datetime?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Penumpang</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->passenger_count ?? '-' }} Orang
                        </div>
                        <div class="truncate text-xs text-slate-500">
                            {{ $booking->passenger_names ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Driver Source</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ strtoupper(str_replace('_', ' ', $booking->driver_source ?? '-')) }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Driver</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->driver_name ?? '-' }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $booking->driver_phone ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Actual Berangkat</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->actual_departure_at?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                        <div class="text-xs text-slate-500">
                            KM Awal: {{ $booking->start_odometer ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Actual Kembali</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->actual_return_at?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                        <div class="text-xs text-slate-500">
                            KM Akhir: {{ $booking->end_odometer ?? '-' }}
                        </div>
                    </div>
                </div>

                @if($booking->notes || $booking->approval_note)
                    <div class="border-t border-slate-100 px-6 py-5">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">Catatan Pemohon</div>
                                <div class="mt-1 text-sm text-slate-700">{{ $booking->notes ?? '-' }}</div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">Catatan Approval</div>
                                <div class="mt-1 text-sm text-slate-700">{{ $booking->approval_note ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="border-t border-slate-100 bg-white px-6 py-5">
                    <div class="flex flex-wrap justify-end gap-2">

                        <a href="{{ route('vehicle-bookings.show', $booking) }}"
                           class="rounded-2xl bg-blue-50 px-4 py-2 text-xs font-black text-blue-700 hover:bg-blue-100">
                            Detail
                        </a>

                        @if($booking->status === 'pending')
                        <form action="{{ route('vehicle-bookings.approve', $booking) }}"
                              method="POST"
                              class="grid grid-cols-1 gap-2 md:grid-cols-3"
                              onsubmit="return confirm('Approve booking kendaraan ini?')">
                            @csrf
                            @method('PATCH')
                    
                            <select name="vehicle_id"
                                    required
                                    class="rounded-xl border-slate-300 text-xs">
                                <option value="">Pilih Kendaraan</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" @selected($booking->vehicle_id == $vehicle->id)>
                                        {{ $vehicle->plate_number }} - {{ $vehicle->vehicle_name }}
                                    </option>
                                @endforeach
                            </select>
                    
                            <input type="text"
                                   name="approval_note"
                                   placeholder="Catatan approval"
                                   class="rounded-xl border-slate-300 text-xs">
                    
                            <button class="rounded-2xl bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700 hover:bg-emerald-100">
                                Approve
                            </button>
                        </form>
                    @endif

                        @if($booking->status === 'approved')
                            <form action="{{ route('vehicle-bookings.start-trip', $booking) }}"
                                  method="POST"
                                  class="flex flex-wrap gap-2"
                                  onsubmit="return confirm('Mulai trip kendaraan ini?')">
                                @csrf
                                @method('PATCH')

                                <input type="number"
                                       name="start_odometer"
                                       placeholder="KM Awal"
                                       class="w-32 rounded-xl border-slate-300 text-xs">

                                <button class="rounded-2xl bg-blue-50 px-4 py-2 text-xs font-black text-blue-700 hover:bg-blue-100">
                                    Start Trip
                                </button>
                            </form>
                        @endif

                        @if($booking->status === 'on_trip')
                            <form action="{{ route('vehicle-bookings.return-trip', $booking) }}"
                                  method="POST"
                                  class="grid grid-cols-2 gap-2 md:flex md:flex-wrap"
                                  onsubmit="return confirm('Selesaikan trip dan return kendaraan?')">
                                @csrf
                                @method('PATCH')

                                <input type="number" name="end_odometer" placeholder="KM Akhir" class="w-32 rounded-xl border-slate-300 text-xs">
                                <input type="number" name="fuel_cost" placeholder="BBM" class="w-28 rounded-xl border-slate-300 text-xs">
                                <input type="number" name="parking_cost" placeholder="Parkir" class="w-28 rounded-xl border-slate-300 text-xs">
                                <input type="number" name="toll_cost" placeholder="Tol" class="w-28 rounded-xl border-slate-300 text-xs">
                                <input type="number" name="other_cost" placeholder="Lainnya" class="w-28 rounded-xl border-slate-300 text-xs">

                                <button class="rounded-2xl bg-[#0B1F3A] px-4 py-2 text-xs font-black text-white hover:bg-[#123B6D]">
                                    Return Trip
                                </button>
                            </form>
                        @endif

                        @if(!in_array($booking->status, ['pending', 'approved', 'on_trip']))
                            <span class="rounded-2xl bg-slate-100 px-4 py-2 text-xs font-black text-slate-400">
                                Done
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center shadow-sm">
                <h3 class="text-lg font-black text-slate-700">Belum ada booking kendaraan</h3>
                <p class="mt-1 text-sm text-slate-500">Data booking kendaraan belum tersedia.</p>
            </div>
        @endforelse
    </section>

    @if($bookings->hasPages())
        <div class="rounded-3xl bg-white px-6 py-4 shadow-sm">
            {{ $bookings->links() }}
        </div>
    @endif
</main>

</body>
</html>