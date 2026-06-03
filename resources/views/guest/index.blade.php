<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Tamu</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">
<main class="w-full space-y-6 px-6 py-8 lg:px-10 xl:px-14">

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-black text-[#0B1F3A]">Daftar Tamu</h1>
            <p class="text-sm text-slate-500">Monitoring tamu yang check-in melalui QR.</p>
        </div>

        <a href="{{ url('/') }}"
           class="rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-bold text-white hover:bg-[#123B6D]">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 font-semibold text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    <section class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <form method="GET" action="{{ route('guests.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <input type="date"
                   name="date"
                   value="{{ $date }}"
                   class="rounded-2xl border-slate-300 px-4 py-3 font-semibold focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">

            <select name="status"
                    class="rounded-2xl border-slate-300 px-4 py-3 font-semibold focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                <option value="">Semua Status</option>
                <option value="checked_in" @selected($status === 'checked_in')>Checked In</option>
                <option value="checked_out" @selected($status === 'checked_out')>Checked Out</option>
            </select>

            <button class="rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-black text-white hover:bg-[#123B6D]">
                Filter
            </button>

            <a href="{{ route('guests.index') }}"
               class="rounded-2xl bg-slate-200 px-5 py-3 text-center text-sm font-black text-slate-700 hover:bg-slate-300">
                Reset
            </a>
        </form>
    </section>

    <section class="grid grid-cols-1 gap-5">
        @forelse($guests as $guest)
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div>
                        <div class="text-xs font-black tracking-wide text-[#0B1F3A]">
                            {{ $guest->guest_code }}
                        </div>

                        <h2 class="mt-1 text-2xl font-black text-slate-900">
                            {{ $guest->guest_name }}
                        </h2>

                        <p class="mt-1 text-sm font-semibold text-slate-500">
                            {{ $guest->company_name ?? '-' }}
                        </p>
                    </div>

                    <span class="w-fit rounded-full px-4 py-2 text-xs font-black uppercase
                        {{ $guest->status === 'checked_in'
                            ? 'bg-emerald-100 text-emerald-700'
                            : 'bg-slate-100 text-slate-600' }}">
                        {{ strtoupper(str_replace('_', ' ', $guest->status)) }}
                    </span>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">No. HP</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $guest->phone ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Bertemu Dengan</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $guest->host_name ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Lokasi</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $guest->branch ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">No. Kendaraan</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $guest->vehicle_number ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Tujuan Kunjungan</div>
                        <div class="mt-1 font-bold text-slate-800">{{ $guest->purpose ?? '-' }}</div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Check-In</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $guest->checkin_at?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Check-Out</div>
                        <div class="mt-1 font-bold text-slate-800">
                            {{ $guest->checkout_at?->format('d/m/Y H:i') ?? '-' }}
                        </div>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="text-xs font-black uppercase text-slate-400">Durasi</div>
                        <div class="mt-1 font-bold text-slate-800">
                            @if($guest->checkin_at && $guest->checkout_at)
                                {{ $guest->checkin_at->diffForHumans($guest->checkout_at, true) }}
                            @elseif($guest->checkin_at)
                                {{ $guest->checkin_at->diffForHumans(now(), true) }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>

                @if($guest->notes)
                    <div class="mt-4 rounded-2xl bg-blue-50 p-4">
                        <div class="text-xs font-black uppercase text-blue-500">Catatan</div>
                        <div class="mt-1 text-sm font-semibold text-blue-900">
                            {{ $guest->notes }}
                        </div>
                    </div>
                @endif

                @if($guest->status === 'checked_in')
                    <form method="POST"
                          action="{{ route('guests.checkout', $guest) }}"
                          class="mt-5"
                          onsubmit="return confirm('Checkout tamu ini?')">
                        @csrf
                        @method('PATCH')

                        <button class="rounded-2xl bg-orange-500 px-5 py-3 text-sm font-black text-white hover:bg-orange-600">
                            Check-Out Tamu
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <div class="rounded-3xl bg-white p-10 text-center shadow-sm ring-1 ring-slate-200">
                <div class="text-lg font-black text-slate-700">Belum ada tamu</div>
                <p class="mt-1 text-sm text-slate-500">Data tamu akan muncul setelah tamu melakukan check-in.</p>
            </div>
        @endforelse
    </section>

    <div>
        {{ $guests->links() }}
    </div>
</main>
</body>
</html>