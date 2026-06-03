<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking Ruangan</title>

    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-[#f8fbff] to-[#eef6ff] font-sans text-slate-800">

@php
    function roomDetailStatusClass($status)
    {
        return match ($status) {
            'pending' => 'bg-orange-100 text-orange-700 ring-orange-200',
            'approved' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            'rejected' => 'bg-rose-100 text-rose-700 ring-rose-200',
            'completed' => 'bg-blue-100 text-blue-700 ring-blue-200',
            'cancelled' => 'bg-slate-100 text-slate-600 ring-slate-200',
            default => 'bg-slate-100 text-slate-600 ring-slate-200',
        };
    }

    $facilities = is_array($booking->additional_facilities ?? null)
        ? $booking->additional_facilities
        : [];

    $canApprove = in_array(auth()->user()->role ?? '', ['it', 'admin_it', 'support', 'ga', 'admin_ga'])
        && $booking->status === 'pending';

    $canEdit = $booking->user_id === auth()->id() && $booking->status === 'pending';

    $canCancel = ($booking->user_id === auth()->id() || in_array(auth()->user()->role ?? '', ['it', 'admin_it', 'support', 'ga', 'admin_ga']))
        && $booking->status === 'pending';
@endphp

<header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur shadow-sm">
    <div class="mx-auto max-w-[1500px] px-5 py-4 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-md ring-1 ring-slate-200">
                    <img src="{{ asset('images/proenergi-logo.png') }}" alt="Pro Energi" class="h-10 w-auto object-contain">
                </div>

                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                        Detail Booking Ruangan
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">
                        Informasi lengkap pengajuan booking ruangan.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('room-bookings.my') }}"
                   class="rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#1C7ED6] px-5 py-3 text-sm font-bold text-white shadow hover:scale-[1.02] transition">
                    Booking Saya
                </a>

                <a href="{{ url()->previous() }}"
                   class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</header>

<main class="py-8">
    <div class="mx-auto max-w-[1500px] space-y-6 px-5 lg:px-8">

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
                            Facility Booking
                        </div>

                        <h2 class="mt-5 text-3xl font-black text-white">
                            {{ $booking->title }}
                        </h2>

                        <p class="mt-2 max-w-3xl text-sm text-blue-100">
                            {{ $booking->booking_number ?? '-' }} · {{ $booking->room?->room_name ?? '-' }}
                        </p>
                    </div>

                    <div class="rounded-3xl bg-white px-6 py-5 text-slate-800 shadow-lg">
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            Status Booking
                        </div>

                        <div class="mt-3">
                            <span class="inline-flex rounded-full px-4 py-2 text-sm font-black uppercase ring-1 {{ roomDetailStatusClass($booking->status) }}">
                                {{ $booking->status }}
                            </span>
                        </div>

                        <div class="mt-3 text-xs text-slate-500">
                            Dibuat: {{ $booking->created_at?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

            {{-- MAIN DETAIL --}}
            <section class="space-y-6 xl:col-span-8">

                {{-- DETAIL BOOKING --}}
                <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-black text-slate-800">
                                Informasi Booking
                            </h3>
                            <p class="mt-1 text-sm text-slate-500">
                                Detail jadwal dan ruangan yang diajukan.
                            </p>
                        </div>

                        <span class="rounded-full bg-blue-100 px-4 py-1 text-xs font-black text-blue-700">
                            ROOM
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Nomor Booking</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->booking_number ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Ruangan</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->room?->room_name ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Lokasi</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->room?->location ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Lantai</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->room?->floor ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Tanggal</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->booking_date?->format('d/m/Y') ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Jam</div>
                            <div class="mt-1 font-bold text-slate-800">
                                {{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Jumlah Peserta</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->participant_count ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Kapasitas Ruangan</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->room?->capacity ?? '-' }} orang</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <div class="text-xs font-black uppercase text-slate-400">Tujuan / Agenda</div>
                            <div class="mt-1 whitespace-pre-line text-sm text-slate-700">
                                {{ $booking->purpose ?? '-' }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <div class="text-xs font-black uppercase text-slate-400">Catatan Tambahan</div>
                            <div class="mt-1 whitespace-pre-line text-sm text-slate-700">
                                {{ $booking->notes ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FASILITAS --}}
                <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-black text-slate-800">
                        Fasilitas Tambahan
                    </h3>

                    <div class="mt-4 flex flex-wrap gap-2">
                        @forelse($facilities as $facility)
                            <span class="rounded-full bg-orange-100 px-4 py-2 text-xs font-black text-orange-700">
                                {{ $facility }}
                            </span>
                        @empty
                            <span class="text-sm text-slate-400">Tidak ada fasilitas tambahan.</span>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- SIDEBAR --}}
            <aside class="space-y-6 xl:col-span-4">

                {{-- PEMOHON --}}
                <section class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="text-sm font-black uppercase tracking-wider text-blue-700">
                        Pemohon
                    </div>

                    <div class="mt-4 rounded-3xl bg-slate-50 p-5">
                        <div class="text-lg font-black text-slate-800">
                            {{ $booking->requester_name ?? '-' }}
                        </div>

                        <div class="mt-1 text-sm text-slate-500">
                            {{ $booking->requester_email ?? '-' }}
                        </div>

                        <div class="mt-2 rounded-full bg-blue-100 px-3 py-1 text-xs font-black text-blue-700 inline-flex">
                            {{ $booking->department ?? '-' }}
                        </div>
                    </div>
                </section>

                {{-- APPROVAL --}}
                <section class="rounded-[32px] border border-orange-200 bg-gradient-to-br from-orange-50 to-white p-6 shadow-sm">
                    <div class="text-sm font-black uppercase tracking-wider text-orange-600">
                        Approval Info
                    </div>

                    <div class="mt-4 space-y-4">
                        <div>
                            <div class="text-xs font-black uppercase text-slate-400">Approved By</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->approver?->name ?? '-' }}</div>
                        </div>

                        <div>
                            <div class="text-xs font-black uppercase text-slate-400">Approved At</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $booking->approved_at?->format('d/m/Y H:i') ?? '-' }}</div>
                        </div>

                        <div>
                            <div class="text-xs font-black uppercase text-slate-400">Approval Note</div>
                            <div class="mt-1 text-sm text-slate-700">{{ $booking->approval_note ?? '-' }}</div>
                        </div>
                    </div>
                </section>

                {{-- ACTION --}}
                <section class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="text-sm font-black uppercase tracking-wider text-slate-500">
                        Action
                    </div>

                    <div class="mt-5 space-y-3">
                        @if($canEdit)
                            <a href="{{ route('room-bookings.edit', $booking) }}"
                               class="block rounded-2xl bg-orange-500 px-5 py-3 text-center text-sm font-black text-white hover:bg-orange-600">
                                Edit Booking
                            </a>
                        @endif

                        @if($canApprove)

                        {{-- APPROVE --}}
                        <form action="{{ route('room-bookings.approve', $booking) }}"
                              method="POST"
                              onsubmit="return confirm('Approve booking ini?')">
                            @csrf
                            @method('PATCH')
                    
                            <button type="submit"
                                    class="w-full rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">
                                Approve Booking
                            </button>
                        </form>
                    
                        {{-- REJECT --}}
                        <form action="{{ route('room-bookings.reject', $booking) }}"
                              method="POST"
                              onsubmit="return confirm('Reject booking ini?')">
                            @csrf
                            @method('PATCH')
                    
                            <button type="submit"
                                    class="w-full rounded-2xl bg-rose-600 px-5 py-3 text-sm font-black text-white hover:bg-rose-700">
                                Reject Booking
                            </button>
                        </form>
                    
                    @endif

                       

                        <a href="{{ url()->previous() }}"
                           class="block rounded-2xl border border-slate-300 bg-white px-5 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-50">
                            Kembali
                        </a>
                    </div>
                </section>

            </aside>
        </div>
    </div>
</main>

</body>
</html>