<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Booking Ruangan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-[#f8fbff] to-[#eef6ff] font-sans text-slate-800">

@php
    function bookingStatusClass($status) {
        return match($status) {
            'pending' => 'bg-orange-100 text-orange-700 ring-1 ring-orange-200',
            'approved' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
            'rejected' => 'bg-rose-100 text-rose-700 ring-1 ring-rose-200',
            'cancelled' => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
            'completed' => 'bg-blue-100 text-blue-700 ring-1 ring-blue-200',
            default => 'bg-slate-100 text-slate-600 ring-1 ring-slate-200',
        };
    }
@endphp

<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur shadow-sm">
    <div class="mx-auto max-w-[1600px] px-5 py-4 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-md ring-1 ring-slate-200">
                    <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10 w-auto object-contain">
                </div>

                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                        Approval Booking Ruangan
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Monitoring dan approval pengajuan pemakaian ruang meeting.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('master-rooms.index') }}"
                   class="rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#1C7ED6] px-5 py-3 text-sm font-bold text-white shadow hover:scale-[1.02] transition">
                    Master Ruangan
                </a>

                <a href="{{ url('/') }}"
                   class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</header>

<main class="py-8">
    <div class="mx-auto max-w-[1600px] space-y-6 px-5 lg:px-8">

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-700 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- HERO --}}
        <section class="overflow-hidden rounded-[32px] bg-[#0F5DA9] shadow-xl">
            <div class="px-8 py-8 lg:px-10">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="text-white">
                        <div class="inline-flex rounded-full bg-orange-500 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-white">
                            Facility Approval
                        </div>

                        <h2 class="mt-5 text-3xl font-black text-white">
                            Room Booking Approval Center
                        </h2>

                        <p class="mt-2 max-w-3xl text-sm text-blue-100">
                            Review booking ruangan, cek jadwal, lalu approve atau reject sesuai ketersediaan fasilitas.
                        </p>
                    </div>

                    <div class="rounded-3xl bg-white px-6 py-5 text-slate-800 shadow-lg">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">Login sebagai</div>
                        <div class="mt-2 text-lg font-black text-slate-800">{{ auth()->user()->name ?? '-' }}</div>
                        <div class="text-sm text-slate-500">{{ auth()->user()->email ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- FILTER --}}
        <section class="rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('room-bookings.index') }}" class="grid grid-cols-1 gap-3 md:grid-cols-12">
                <div class="md:col-span-3">
                    <select name="status" class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                        <option value="">Semua Status</option>
                        <option value="pending" @selected($status === 'pending')>Pending</option>
                        <option value="approved" @selected($status === 'approved')>Approved</option>
                        <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                        <option value="cancelled" @selected($status === 'cancelled')>Cancelled</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <input type="date"
                           name="date"
                           value="{{ $date }}"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                </div>

                <div class="md:col-span-4">
                    <select name="room_id" class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                        <option value="">Semua Ruangan</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" @selected($roomId == $room->id)>
                                {{ $room->room_name }} - {{ $room->location ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <button class="w-full rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#F97316] px-5 py-3 text-sm font-black text-white shadow">
                        Filter
                    </button>
                </div>
            </form>
        </section>

        {{-- TABLE --}}
        <section class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Daftar Pengajuan Booking</h3>
                        <p class="text-sm text-slate-500">Data booking ruangan dari seluruh user.</p>
                    </div>

                    <div class="text-sm text-slate-500">
                        Total tampil: <span class="font-bold text-slate-800">{{ $bookings->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-5 py-4 text-left font-black">No</th>
                            <th class="px-5 py-4 text-left font-black">Booking</th>
                            <th class="px-5 py-4 text-left font-black">Pemohon</th>
                            <th class="px-5 py-4 text-left font-black">Ruangan</th>
                            <th class="px-5 py-4 text-left font-black">Tanggal</th>
                            <th class="px-5 py-4 text-left font-black">Jam</th>
                            <th class="px-5 py-4 text-center font-black">Status</th>
                            <th class="px-5 py-4 text-right font-black">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($bookings as $index => $booking)
                            <tr class="hover:bg-blue-50/40 transition">
                                <td class="px-5 py-4 font-semibold text-slate-500">
                                    {{ $bookings->firstItem() + $index }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-black text-slate-800">{{ $booking->booking_number }}</div>
                                    <div class="mt-1 text-xs text-slate-500">{{ $booking->title }}</div>
                                    @if($booking->purpose)
                                        <div class="mt-1 text-xs text-slate-400">
                                            {{ \Illuminate\Support\Str::limit($booking->purpose, 55) }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-bold text-slate-800">{{ $booking->requester_name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $booking->requester_email ?? '-' }}</div>
                                    <div class="text-xs text-blue-600">{{ $booking->department ?? '-' }}</div>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-bold text-slate-800">{{ $booking->room?->room_name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">
                                        {{ $booking->room?->location ?? '-' }}
                                        @if($booking->room?->floor)
                                            · Lantai {{ $booking->room?->floor }}
                                        @endif
                                    </div>
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    {{ $booking->booking_date?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td class="px-5 py-4 whitespace-nowrap">
                                    {{ substr($booking->start_time, 0, 5) }}
                                    -
                                    {{ substr($booking->end_time, 0, 5) }}
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-black uppercase {{ bookingStatusClass($booking->status) }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('room-bookings.show', $booking) }}"
                                           class="rounded-xl bg-blue-50 px-4 py-2 text-xs font-black text-blue-700 hover:bg-blue-100">
                                            Detail
                                        </a>

                                        @if($booking->status === 'pending')

                                        {{-- APPROVE --}}
                                        <form action="{{ route('room-bookings.approve', $booking) }}"
                                              method="POST"
                                              onsubmit="return confirm('Approve booking ini?')">
                                            @csrf
                                            @method('PATCH')
                                    
                                            <button type="submit"
                                                    class="rounded-xl bg-emerald-50 px-4 py-2 text-xs font-black text-emerald-700 hover:bg-emerald-100">
                                                Approve
                                            </button>
                                        </form>
                                    
                                        {{-- REJECT --}}
                                        <form action="{{ route('room-bookings.reject', $booking) }}"
                                              method="POST"
                                              onsubmit="return confirm('Reject booking ini?')">
                                            @csrf
                                            @method('PATCH')
                                    
                                            <button type="submit"
                                                    class="rounded-xl bg-rose-50 px-4 py-2 text-xs font-black text-rose-700 hover:bg-rose-100">
                                                Reject
                                            </button>
                                        </form>
                                    
                                    @else
                                    
                                        <span class="rounded-xl bg-slate-100 px-4 py-2 text-xs font-black text-slate-400">
                                            Done
                                        </span>
                                    
                                    @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-16 text-center">
                                    <div class="text-5xl mb-3">🏢</div>
                                    <div class="text-lg font-black text-slate-700">Belum ada pengajuan booking</div>
                                    <p class="mt-1 text-sm text-slate-500">Data approval booking ruangan belum tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $bookings->links() }}
                </div>
            @endif
        </section>
    </div>
</main>

</body>
</html>