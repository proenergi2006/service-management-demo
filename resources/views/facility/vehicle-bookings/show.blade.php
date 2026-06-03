<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Booking Kendaraan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800">

@php
    function vehicleDetailStatusClass($status) {
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

    $totalCost =
        (float) ($booking->fuel_cost ?? 0) +
        (float) ($booking->parking_cost ?? 0) +
        (float) ($booking->toll_cost ?? 0) +
        (float) ($booking->other_cost ?? 0);
@endphp

<header class="border-b bg-white shadow-sm">
    <div class="mx-auto max-w-7xl px-4 py-5">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10 w-auto">
                <div>
                    <h1 class="text-2xl font-black text-[#0B1F3A]">Detail Booking Kendaraan</h1>
                    <p class="text-sm text-slate-500">{{ $booking->booking_number }}</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                @if(auth()->user()?->role === 'it')
                    <a href="{{ route('vehicle-bookings.index') }}"
                       class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                        Approval Kendaraan
                    </a>
                @endif

                <a href="{{ route('vehicle-bookings.my') }}"
                   class="rounded-2xl bg-white px-5 py-3 text-sm font-bold text-[#0B1F3A] ring-1 ring-slate-200 hover:bg-slate-50">
                    Booking Saya
                </a>

                <a href="{{ url('/') }}"
                   class="rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-bold text-white hover:bg-[#123B6D]">
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

    {{-- HERO DETAIL --}}
    <section class="overflow-hidden rounded-3xl bg-[#0B1F3A] shadow-xl">
        <div class="px-6 py-7 text-white">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <div class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-black">
                        Vehicle Booking Detail
                    </div>

                    <h2 class="mt-3 text-2xl font-black">
                        {{ $booking->destination ?? '-' }}
                    </h2>

                    <p class="mt-1 max-w-2xl text-sm text-blue-100">
                        {{ $booking->purpose ?? 'Tidak ada keperluan tertulis.' }}
                    </p>

                    <div class="mt-4">
                        <span class="inline-flex rounded-full px-4 py-2 text-xs font-black uppercase {{ vehicleDetailStatusClass($booking->status) }}">
                            {{ str_replace('_', ' ', $booking->status) }}
                        </span>
                    </div>
                </div>

                <div class="rounded-3xl bg-white/10 px-5 py-4 ring-1 ring-white/20">
                    <div class="text-xs text-blue-100">Nomor Booking</div>
                    <div class="mt-1 text-xl font-black text-white">{{ $booking->booking_number }}</div>
                    <div class="mt-2 text-xs text-blue-100">
                        Dibuat oleh {{ $booking->requester_name ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MAIN GRID --}}
    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- LEFT CONTENT --}}
        <div class="space-y-6 xl:col-span-2">

            {{-- INFORMASI PEMOHON --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-black text-slate-800">Informasi Pemohon</h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Nama</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $booking->requester_name ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Email</div>
                        <div class="mt-1 break-all font-bold text-slate-800">{{ $booking->requester_email ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Department</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $booking->department ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Branch</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $booking->branch ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- INFORMASI KENDARAAN --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-black text-slate-800">Informasi Kendaraan</h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Plat Nomor</div>
                        <div class="mt-1 font-black text-[#0B1F3A]">
                            {{ $booking->vehicle?->plate_number ?? 'Belum ditentukan GA' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Nama Kendaraan</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->vehicle?->vehicle_name ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Brand / Model</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ trim(($booking->vehicle?->brand ?? '-') . ' ' . ($booking->vehicle?->model ?? '')) }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Kapasitas</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->vehicle?->capacity ?? '-' }} Orang
                        </div>
                    </div>
                </div>
            </div>

            {{-- INFORMASI PERJALANAN --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-black text-slate-800">Informasi Perjalanan</h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                        <div class="text-xs font-black uppercase text-slate-400">Tujuan</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $booking->destination ?? '-' }}</div>
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
                        <div class="text-xs font-black uppercase text-slate-400">Jumlah Penumpang</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $booking->passenger_count ?? '-' }} Orang</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Driver Source</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ strtoupper(str_replace('_', ' ', $booking->driver_source ?? '-')) }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                        <div class="text-xs font-black uppercase text-slate-400">Nama Penumpang</div>
                        <div class="mt-1 whitespace-pre-line text-sm text-slate-700">{{ $booking->passenger_names ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                        <div class="text-xs font-black uppercase text-slate-400">Keperluan</div>
                        <div class="mt-1 whitespace-pre-line text-sm text-slate-700">{{ $booking->purpose ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                        <div class="text-xs font-black uppercase text-slate-400">Catatan</div>
                        <div class="mt-1 whitespace-pre-line text-sm text-slate-700">{{ $booking->notes ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- BIAYA & ODOMETER --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-black text-slate-800">Aktual Trip & Biaya</h3>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Actual Berangkat</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->actual_departure_at?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Actual Kembali</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->actual_return_at?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">KM Awal</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $booking->start_odometer ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">KM Akhir</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $booking->end_odometer ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">BBM</div>
                        <div class="mt-1 font-bold text-slate-800">
                            Rp {{ number_format((float) ($booking->fuel_cost ?? 0), 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Parkir</div>
                        <div class="mt-1 font-bold text-slate-800">
                            Rp {{ number_format((float) ($booking->parking_cost ?? 0), 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Tol</div>
                        <div class="mt-1 font-bold text-slate-800">
                            Rp {{ number_format((float) ($booking->toll_cost ?? 0), 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-[#0B1F3A] p-4 text-white">
                        <div class="text-xs font-black uppercase text-blue-100">Total Biaya</div>
                        <div class="mt-1 font-black">
                            Rp {{ number_format($totalCost, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="space-y-6">

            {{-- APPROVAL --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-black text-slate-800">Approval</h3>

                <div class="space-y-4">
                    <div>
                        <div class="text-xs font-black uppercase text-slate-400">Status</div>
                        <div class="mt-2">
                            <span class="inline-flex rounded-full px-4 py-2 text-xs font-black uppercase {{ vehicleDetailStatusClass($booking->status) }}">
                                {{ str_replace('_', ' ', $booking->status) }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-black uppercase text-slate-400">Approver</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $booking->approver?->name ?? '-' }}</div>
                    </div>

                    <div>
                        <div class="text-xs font-black uppercase text-slate-400">Approved At</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $booking->approved_at?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-xs font-black uppercase text-slate-400">Approval Note</div>
                        <div class="mt-1 rounded-2xl bg-slate-50 p-4 text-sm text-slate-700">
                            {{ $booking->approval_note ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-black text-slate-800">Action</h3>

                <div class="space-y-3">
                    @if($booking->status === 'pending')
                        <form action="{{ route('vehicle-bookings.approve', $booking) }}"
                              method="POST"
                              onsubmit="return confirm('Approve booking kendaraan ini?')">
                            @csrf
                            @method('PATCH')

                            <textarea name="approval_note"
                                      rows="2"
                                      placeholder="Catatan approval opsional"
                                      class="mb-3 w-full rounded-2xl border-slate-300 text-sm"></textarea>

                            <button class="w-full rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">
                                Approve Booking
                            </button>
                        </form>

                        <form action="{{ route('vehicle-bookings.reject', $booking) }}"
                              method="POST"
                              onsubmit="return confirm('Reject booking kendaraan ini?')">
                            @csrf
                            @method('PATCH')

                            <textarea name="approval_note"
                                      rows="2"
                                      placeholder="Alasan reject"
                                      class="mb-3 w-full rounded-2xl border-slate-300 text-sm"></textarea>

                            <button class="w-full rounded-2xl bg-rose-600 px-5 py-3 text-sm font-black text-white hover:bg-rose-700">
                                Reject Booking
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'approved')
                        <form action="{{ route('vehicle-bookings.start-trip', $booking) }}"
                              method="POST"
                              onsubmit="return confirm('Mulai trip kendaraan ini?')">
                            @csrf
                            @method('PATCH')

                            <input type="number"
                                   name="start_odometer"
                                   placeholder="KM Awal"
                                   class="mb-3 w-full rounded-2xl border-slate-300 text-sm">

                            <button class="w-full rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white hover:bg-blue-700">
                                Start Trip
                            </button>
                        </form>
                    @endif

                    @if($booking->status === 'on_trip')
                        <form action="{{ route('vehicle-bookings.return-trip', $booking) }}"
                              method="POST"
                              onsubmit="return confirm('Selesaikan trip dan return kendaraan?')">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-3">
                                <input type="number" name="end_odometer" placeholder="KM Akhir" class="w-full rounded-2xl border-slate-300 text-sm">
                                <input type="number" name="fuel_cost" placeholder="Biaya BBM" class="w-full rounded-2xl border-slate-300 text-sm">
                                <input type="number" name="parking_cost" placeholder="Biaya Parkir" class="w-full rounded-2xl border-slate-300 text-sm">
                                <input type="number" name="toll_cost" placeholder="Biaya Tol" class="w-full rounded-2xl border-slate-300 text-sm">
                                <input type="number" name="other_cost" placeholder="Biaya Lainnya" class="w-full rounded-2xl border-slate-300 text-sm">

                                <button class="w-full rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-black text-white hover:bg-[#123B6D]">
                                    Return Trip
                                </button>
                            </div>
                        </form>
                    @endif

                    @if($booking->status === 'pending' && $booking->user_id === auth()->id())
                        <form action="{{ route('vehicle-bookings.destroy', $booking) }}"
                              method="POST"
                              onsubmit="return confirm('Batalkan booking kendaraan ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="w-full rounded-2xl bg-slate-100 px-5 py-3 text-sm font-black text-slate-600 hover:bg-slate-200">
                                Cancel Booking
                            </button>
                        </form>
                    @endif

                    @if(!in_array($booking->status, ['pending', 'approved', 'on_trip']))
                        <div class="rounded-2xl bg-slate-50 px-5 py-4 text-center text-sm font-bold text-slate-400">
                            Tidak ada action lanjutan.
                        </div>
                    @endif
                </div>
            </div>

            {{-- META --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-black text-slate-800">System Info</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Created By</span>
                        <span class="font-bold text-slate-700">{{ $booking->created_by ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Updated By</span>
                        <span class="font-bold text-slate-700">{{ $booking->updated_by ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Created At</span>
                        <span class="font-bold text-slate-700">{{ $booking->created_at?->format('d/m/Y H:i') ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between gap-3">
                        <span class="text-slate-500">Updated At</span>
                        <span class="font-bold text-slate-700">{{ $booking->updated_at?->format('d/m/Y H:i') ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

</body>
</html>