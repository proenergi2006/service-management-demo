<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Kendaraan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800">
    <header class="border-b bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10 w-auto">
                    <div>
                        <h1 class="text-2xl font-black text-[#0B1F3A]">Master Kendaraan</h1>
                        <p class="text-sm text-slate-500">Kelola data kendaraan operasional perusahaan.</p>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ url('/') }}"
                       class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                        Kembali
                    </a>

                    <a href="{{ route('master-vehicles.create') }}"
                       class="rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-bold text-white hover:bg-[#123B6D]">
                        + Tambah Kendaraan
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

        <section class="rounded-3xl bg-white p-6 shadow-sm border border-slate-200">
            <form method="GET" action="{{ route('master-vehicles.index') }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">Search</label>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Kode, plat nomor, nama, brand..."
                           class="w-full rounded-2xl border-slate-300">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">Status</label>
                    <select name="vehicle_status" class="w-full rounded-2xl border-slate-300">
                        <option value="">Semua Status</option>
                        <option value="available" @selected($status === 'available')>Available</option>
                        <option value="booked" @selected($status === 'booked')>Booked</option>
                        <option value="maintenance" @selected($status === 'maintenance')>Maintenance</option>
                        <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">Cabang</label>
                    <select name="branch" class="w-full rounded-2xl border-slate-300">
                        <option value="">Semua Cabang</option>
                        @foreach($branches as $item)
                            <option value="{{ $item }}" @selected($branch === $item)>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4 flex gap-3">
                    <button class="rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-bold text-white">
                        Filter
                    </button>
                    <a href="{{ route('master-vehicles.index') }}"
                       class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700">
                        Reset
                    </a>
                </div>
            </form>
        </section>

        <section class="overflow-hidden rounded-3xl bg-white shadow-sm border border-slate-200">
            <div class="border-b px-6 py-5">
                <h2 class="text-lg font-black text-slate-800">Daftar Kendaraan</h2>
                <p class="text-sm text-slate-500">Total tampil: {{ $vehicles->count() }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="px-5 py-4 text-left">No</th>
                            <th class="px-5 py-4 text-left">Kendaraan</th>
                            <th class="px-5 py-4 text-left">Plat Nomor</th>
                            <th class="px-5 py-4 text-left">Cabang</th>
                            <th class="px-5 py-4 text-left">Lokasi</th>
                            <th class="px-5 py-4 text-left">Kapasitas</th>
                            <th class="px-5 py-4 text-left">Status</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($vehicles as $index => $vehicle)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-4 font-bold text-slate-500">
                                    {{ $vehicles->firstItem() + $index }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="font-black text-slate-800">{{ $vehicle->vehicle_code }}</div>
                                    <div class="text-sm text-slate-600">{{ $vehicle->vehicle_name }}</div>
                                    <div class="text-xs text-slate-400">
                                        {{ trim(($vehicle->brand ?? '-') . ' ' . ($vehicle->model ?? '')) }}
                                    </div>
                                </td>

                                <td class="px-5 py-4 font-bold text-[#0B1F3A]">
                                    {{ $vehicle->plate_number }}
                                </td>

                                <td class="px-5 py-4">{{ $vehicle->branch ?? '-' }}</td>
                                <td class="px-5 py-4">{{ $vehicle->location ?? '-' }}</td>
                                <td class="px-5 py-4">{{ $vehicle->capacity ?? '-' }}</td>

                                <td class="px-5 py-4">
                                    @php
                                        $statusClass = match($vehicle->vehicle_status) {
                                            'available' => 'bg-emerald-100 text-emerald-700',
                                            'booked' => 'bg-blue-100 text-blue-700',
                                            'maintenance' => 'bg-amber-100 text-amber-700',
                                            'inactive' => 'bg-slate-100 text-slate-500',
                                            default => 'bg-slate-100 text-slate-500',
                                        };
                                    @endphp

                                    <span class="rounded-full px-3 py-1 text-xs font-black {{ $statusClass }}">
                                        {{ strtoupper($vehicle->vehicle_status) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('master-vehicles.edit', $vehicle) }}"
                                           class="rounded-xl bg-blue-50 px-4 py-2 text-xs font-black text-blue-700 hover:bg-blue-100">
                                            Edit
                                        </a>

                                        <form action="{{ route('master-vehicles.destroy', $vehicle) }}"
                                              method="POST"
                                              onsubmit="return confirm('Nonaktifkan kendaraan ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="rounded-xl bg-rose-50 px-4 py-2 text-xs font-black text-rose-700 hover:bg-rose-100">
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-14 text-center text-slate-500">
                                    Belum ada data kendaraan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($vehicles->hasPages())
                <div class="border-t px-6 py-4">
                    {{ $vehicles->links() }}
                </div>
            @endif
        </section>
    </main>
</body>
</html>