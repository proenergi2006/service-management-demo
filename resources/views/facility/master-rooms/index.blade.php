<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master Ruangan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-[#f8fbff] to-[#eef6ff] text-slate-800">
<header class="border-b bg-white/90 shadow-sm">
    <div class="mx-auto max-w-[1500px] px-5 py-4 lg:px-8 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10">
            <div>
                <h1 class="text-2xl font-black">Master Ruangan</h1>
                <p class="text-sm text-slate-500">Kelola data ruang meeting / fasilitas kantor.</p>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('master-rooms.create') }}"
               class="rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#F97316] px-5 py-3 text-sm font-black text-white shadow">
                + Tambah Ruangan
            </a>
            <a href="{{ url('/') }}"
               class="rounded-2xl border bg-white px-5 py-3 text-sm font-semibold">
                Kembali
            </a>
        </div>
    </div>
</header>

<main class="mx-auto max-w-[1500px] px-5 py-8 lg:px-8 space-y-6">

    @if(session('success'))
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-emerald-700 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl bg-rose-50 border border-rose-200 px-5 py-4 text-rose-700 font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <section class="rounded-[32px] bg-[#0F5DA9] p-8 text-white shadow-xl">
        <div class="inline-flex rounded-full bg-orange-500 px-4 py-1.5 text-xs font-bold uppercase">
            GA Facility Master
        </div>
        <h2 class="mt-5 text-3xl font-black">Room Management</h2>
        <p class="mt-2 text-blue-100">Master ini digunakan pada form booking ruangan user.</p>
    </section>

    <section class="rounded-[28px] bg-white border border-slate-200 p-5 shadow-sm">
        <form method="GET" action="{{ route('master-rooms.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-7">
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari kode, nama ruangan, lokasi, lantai..."
                       class="w-full rounded-2xl border-slate-300">
            </div>

            <div class="md:col-span-3">
                <select name="status" class="w-full rounded-2xl border-slate-300">
                    <option value="">Semua Status</option>
                    <option value="active" @selected($status === 'active')>Active</option>
                    <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button class="w-full rounded-2xl bg-slate-900 px-5 py-3 text-sm font-bold text-white">
                    Filter
                </button>
            </div>
        </form>
    </section>

    <section class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b px-6 py-5 flex justify-between">
            <div>
                <h3 class="text-xl font-black">Daftar Ruangan</h3>
                <p class="text-sm text-slate-500">Data ruangan aktif akan tampil di dropdown booking.</p>
            </div>
            <div class="text-sm text-slate-500">
                Total tampil: <strong>{{ $rooms->count() }}</strong>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-5 py-4 text-left">No</th>
                    <th class="px-5 py-4 text-left">Ruangan</th>
                    <th class="px-5 py-4 text-left">Lokasi</th>
                    <th class="px-5 py-4 text-left">Kapasitas</th>
                    <th class="px-5 py-4 text-left">Fasilitas</th>
                    <th class="px-5 py-4 text-center">Status</th>
                    <th class="px-5 py-4 text-right">Aksi</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                @forelse($rooms as $index => $room)
                    <tr class="hover:bg-blue-50/40">
                        <td class="px-5 py-4 font-semibold">
                            {{ $rooms->firstItem() + $index }}
                        </td>

                        <td class="px-5 py-4">
                            <div class="font-black text-slate-800">{{ $room->room_name }}</div>
                            <div class="text-xs text-blue-600 font-bold">{{ $room->room_code }}</div>
                        </td>

                        <td class="px-5 py-4">
                            <div>{{ $room->location ?? '-' }}</div>
                            <div class="text-xs text-slate-400">Lantai: {{ $room->floor ?? '-' }}</div>
                        </td>

                        <td class="px-5 py-4">
                            {{ $room->capacity ?? '-' }} orang
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse(($room->facilities ?? []) as $facility)
                                    <span class="rounded-full bg-blue-100 px-2 py-1 text-[11px] font-bold text-blue-700">
                                        {{ $facility }}
                                    </span>
                                @empty
                                    <span class="text-slate-400">-</span>
                                @endforelse
                            </div>
                        </td>

                        <td class="px-5 py-4 text-center">
                            <span class="rounded-full px-3 py-1 text-xs font-black
                                {{ $room->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $room->is_active ? 'ACTIVE' : 'INACTIVE' }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('master-rooms.edit', $room) }}"
                                   class="rounded-xl bg-orange-50 px-4 py-2 text-xs font-black text-orange-700">
                                    Edit
                                </a>

                                <form action="{{ route('master-rooms.destroy', $room) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus ruangan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-xl bg-rose-50 px-4 py-2 text-xs font-black text-rose-700">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-14 text-center text-slate-500">
                            Belum ada master ruangan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($rooms->hasPages())
            <div class="border-t px-6 py-4">
                {{ $rooms->links() }}
            </div>
        @endif
    </section>
</main>
</body>
</html>