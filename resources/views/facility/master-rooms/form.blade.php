<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-[#f8fbff] to-[#eef6ff] text-slate-800">
<header class="border-b bg-white/90 shadow-sm">
    <div class="mx-auto max-w-[1200px] px-5 py-4 lg:px-8 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10">
            <div>
                <h1 class="text-2xl font-black">{{ $title }}</h1>
                <p class="text-sm text-slate-500">{{ $subtitle }}</p>
            </div>
        </div>

        <a href="{{ route('master-rooms.index') }}"
           class="rounded-2xl border bg-white px-5 py-3 text-sm font-semibold">
            Kembali
        </a>
    </div>
</header>

<main class="mx-auto max-w-[1200px] px-5 py-8 lg:px-8">
    @if($errors->any())
        <div class="mb-5 rounded-2xl bg-rose-50 border border-rose-200 px-5 py-4 text-rose-700">
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $action }}">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
            <section class="xl:col-span-8 rounded-[32px] bg-white border border-slate-200 p-6 shadow-sm">
                <h2 class="text-xl font-black mb-5">Informasi Ruangan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-bold">Kode Ruangan *</label>
                        <input name="room_code" value="{{ old('room_code', $room->room_code ?? '') }}"
                               placeholder="ROOM-HO-01"
                               class="mt-1 w-full rounded-2xl border-slate-300">
                    </div>

                    <div>
                        <label class="text-sm font-bold">Nama Ruangan *</label>
                        <input name="room_name" value="{{ old('room_name', $room->room_name ?? '') }}"
                               placeholder="Meeting Room Lantai 2"
                               class="mt-1 w-full rounded-2xl border-slate-300">
                    </div>

                    <div>
                        <label class="text-sm font-bold">Lokasi</label>
                        <input name="location" value="{{ old('location', $room->location ?? '') }}"
                               placeholder="Head Office"
                               class="mt-1 w-full rounded-2xl border-slate-300">
                    </div>

                    <div>
                        <label class="text-sm font-bold">Lantai</label>
                        <input name="floor" value="{{ old('floor', $room->floor ?? '') }}"
                               placeholder="2"
                               class="mt-1 w-full rounded-2xl border-slate-300">
                    </div>

                    <div>
                        <label class="text-sm font-bold">Kapasitas</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $room->capacity ?? '') }}"
                               placeholder="12"
                               class="mt-1 w-full rounded-2xl border-slate-300">
                    </div>

                    <div>
                        <label class="text-sm font-bold">Status</label>
                        <select name="is_active" class="mt-1 w-full rounded-2xl border-slate-300">
                            <option value="1" @selected(old('is_active', $room->is_active ?? 1) == 1)>Active</option>
                            <option value="0" @selected(old('is_active', $room->is_active ?? 1) == 0)>Inactive</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm font-bold">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 w-full rounded-2xl border-slate-300">{{ old('description', $room->description ?? '') }}</textarea>
                    </div>
                </div>
            </section>

            <aside class="xl:col-span-4 space-y-6">
                <section class="rounded-[32px] border border-orange-200 bg-orange-50 p-6">
                    <h3 class="text-lg font-black text-slate-800">Fasilitas Ruangan</h3>
                    <p class="mt-1 text-sm text-slate-500">Pilih fasilitas tersedia.</p>

                    @php
                        $facilityOptions = [
                            'Projector',
                            'TV Display',
                            'Whiteboard',
                            'Sound System',
                            'Video Conference',
                            'Snack / Drink',
                            'Extension Cable',
                            'Pointer',
                        ];

                        $selectedFacilities = old('facilities', $room->facilities ?? []);
                    @endphp

                    <div class="mt-5 space-y-3">
                        @foreach($facilityOptions as $facility)
                            <label class="flex items-center gap-3 rounded-2xl bg-white px-4 py-3 text-sm font-semibold">
                                <input type="checkbox"
                                       name="facilities[]"
                                       value="{{ $facility }}"
                                       class="rounded text-orange-500"
                                       @checked(in_array($facility, $selectedFacilities ?? []))>
                                {{ $facility }}
                            </label>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-[32px] bg-[#0F5DA9] p-6 text-white">
                    <h3 class="text-xl font-black">Master Room</h3>
                    <p class="mt-2 text-sm text-blue-100">
                        Data ruangan aktif otomatis muncul di form booking user.
                    </p>
                </section>
            </aside>
        </div>

        <div class="mt-6 flex justify-end gap-3 rounded-[28px] bg-white border border-slate-200 p-5 shadow-sm">
            <a href="{{ route('master-rooms.index') }}"
               class="rounded-2xl border px-5 py-3 text-sm font-semibold">
                Batal
            </a>

            <button class="rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#F97316] px-7 py-3 text-sm font-black text-white shadow">
                Simpan
            </button>
        </div>
    </form>
</main>
</body>
</html>