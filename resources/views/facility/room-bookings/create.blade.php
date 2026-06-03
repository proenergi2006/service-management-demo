<x-app-layout>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Ruangan</title>

    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-[#f8fbff] to-[#eef6ff] font-sans text-slate-800">

    {{-- HEADER --}}
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur shadow-sm">
        <div class="mx-auto max-w-[1500px] px-5 py-4 lg:px-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-md ring-1 ring-slate-200">
                        <img src="{{ asset('images/proenergi-logo.png') }}" alt="Pro Energi" class="h-10 w-auto object-contain">
                    </div>

                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
                            Booking Ruangan
                        </h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Ajukan pemakaian ruang meeting / fasilitas kantor.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('room-bookings.my') }}"
                       class="rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#1C7ED6] px-5 py-3 text-sm font-bold text-white shadow-lg hover:scale-[1.02] transition">
                        Booking Saya
                    </a>

                    <a href="{{ url('/') }}"
                       class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="py-8">
        <div class="mx-auto max-w-[1500px] space-y-6 px-5 lg:px-8">

            @if (session('error'))
                <div class="rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-semibold text-rose-700 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-3xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-700 shadow-sm">
                    <div class="mb-2 font-bold">Form belum lengkap:</div>
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- HERO --}}
            <section class="overflow-hidden rounded-[32px] bg-[#0F5DA9] shadow-xl">
                <div class="px-8 py-8 lg:px-10">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="text-white">
                            <div class="inline-flex rounded-full bg-orange-500 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-white">
                                Facility Management
                            </div>

                            <h2 class="mt-5 text-3xl font-black text-white">
                                Form Booking Ruangan
                            </h2>

                            <p class="mt-2 max-w-3xl text-sm text-blue-100">
                                Lengkapi data booking ruangan. Sistem akan melakukan pengecekan bentrok jadwal secara otomatis.
                            </p>
                        </div>

                        <div class="rounded-3xl bg-white px-6 py-5 text-slate-800 shadow-lg">
                            <div class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Status Awal
                            </div>
                            <div class="mt-2 text-2xl font-black text-orange-500">
                                PENDING
                            </div>
                            <div class="mt-1 text-sm text-slate-500">
                                Menunggu approval GA/Admin
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <form method="POST" action="{{ route('room-bookings.store') }}">
                @csrf

                <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

                    {{-- LEFT CONTENT --}}
                    <div class="space-y-6 xl:col-span-8">

                        {{-- INFORMASI PEMOHON --}}
                        <section class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="mb-5 flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-black text-slate-800">
                                        Informasi Pemohon
                                    </h3>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Data otomatis dari akun login.
                                    </p>
                                </div>

                                <div class="rounded-full bg-blue-100 px-4 py-1 text-xs font-black text-blue-700">
                                    USER INFO
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div>
                                    <label class="mb-1 block text-sm font-bold text-slate-700">Nama</label>
                                    <input type="text"
                                           value="{{ auth()->user()->name ?? '-' }}"
                                           readonly
                                           class="w-full rounded-2xl border-slate-200 bg-slate-50 text-slate-600">
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-bold text-slate-700">Email</label>
                                    <input type="text"
                                           value="{{ auth()->user()->email ?? '-' }}"
                                           readonly
                                           class="w-full rounded-2xl border-slate-200 bg-slate-50 text-slate-600">
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-bold text-slate-700">Department</label>
                                    <input type="text"
                                           value="{{ auth()->user()->department ?? '-' }}"
                                           readonly
                                           class="w-full rounded-2xl border-slate-200 bg-slate-50 text-slate-600">
                                </div>
                            </div>
                        </section>

                        {{-- DETAIL BOOKING --}}
                        <section class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="mb-5">
                                <h3 class="text-xl font-black text-slate-800">
                                    Detail Booking
                                </h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    Pilih ruangan, tanggal, jam, dan agenda meeting.
                                </p>
                            </div>

                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <div class="md:col-span-2">
                                    <label class="mb-1 block text-sm font-bold text-slate-700">
                                        Ruangan <span class="text-rose-500">*</span>
                                    </label>

                                    <select name="room_id"
                                            required
                                            class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                                        <option value="">Pilih Ruangan</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>
                                                {{ $room->room_name }}
                                                @if($room->location)
                                                    - {{ $room->location }}
                                                @endif
                                                @if($room->floor)
                                                    | Lantai {{ $room->floor }}
                                                @endif
                                                | Kapasitas {{ $room->capacity }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-1 block text-sm font-bold text-slate-700">
                                        Judul Meeting <span class="text-rose-500">*</span>
                                    </label>

                                    <input type="text"
                                           name="title"
                                           value="{{ old('title') }}"
                                           required
                                           placeholder="Contoh: Weekly Meeting Commercial"
                                           class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-bold text-slate-700">
                                        Tanggal Booking <span class="text-rose-500">*</span>
                                    </label>

                                    <input type="date"
                                           name="booking_date"
                                           value="{{ old('booking_date') }}"
                                           required
                                           class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-bold text-slate-700">
                                        Jumlah Peserta
                                    </label>

                                    <input type="number"
                                           name="participant_count"
                                           value="{{ old('participant_count') }}"
                                           min="1"
                                           placeholder="Contoh: 10"
                                           class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-bold text-slate-700">
                                        Jam Mulai <span class="text-rose-500">*</span>
                                    </label>

                                    <input type="time"
                                           name="start_time"
                                           value="{{ old('start_time') }}"
                                           required
                                           class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                                </div>

                                <div>
                                    <label class="mb-1 block text-sm font-bold text-slate-700">
                                        Jam Selesai <span class="text-rose-500">*</span>
                                    </label>

                                    <input type="time"
                                           name="end_time"
                                           value="{{ old('end_time') }}"
                                           required
                                           class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="mb-1 block text-sm font-bold text-slate-700">
                                        Tujuan / Agenda
                                    </label>

                                    <textarea name="purpose"
                                              rows="4"
                                              placeholder="Jelaskan agenda meeting atau kebutuhan ruangan..."
                                              class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">{{ old('purpose') }}</textarea>
                                </div>
                            </div>
                        </section>

                        {{-- FASILITAS --}}
                        <section class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="mb-5">
                                <h3 class="text-xl font-black text-slate-800">
                                    Fasilitas Tambahan
                                </h3>
                                <p class="mt-1 text-sm text-slate-500">
                                    Pilih fasilitas tambahan yang dibutuhkan saat meeting.
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
                                @php
                                    $facilities = [
                                        'Projector',
                                        'TV Display',
                                        'Whiteboard',
                                        'Sound System',
                                        'Video Conference',
                                        'Snack / Drink',
                                        'Extension Cable',
                                        'Pointer',
                                    ];
                                @endphp

                                @foreach ($facilities as $facility)
                                    <label class="flex cursor-pointer items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold transition hover:border-orange-200 hover:bg-orange-50">
                                        <input type="checkbox"
                                               name="additional_facilities[]"
                                               value="{{ $facility }}"
                                               class="rounded border-slate-300 text-orange-500 focus:ring-orange-500"
                                               @checked(in_array($facility, old('additional_facilities', [])))>
                                        <span>{{ $facility }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-5">
                                <label class="mb-1 block text-sm font-bold text-slate-700">
                                    Catatan Tambahan
                                </label>

                                <textarea name="notes"
                                          rows="3"
                                          placeholder="Contoh: butuh setup sebelum meeting dimulai..."
                                          class="w-full rounded-2xl border-slate-300 focus:border-[#1C7ED6] focus:ring-[#1C7ED6]">{{ old('notes') }}</textarea>
                            </div>
                        </section>
                    </div>

                    {{-- RIGHT SIDEBAR --}}
                    <aside class="space-y-6 xl:col-span-4">

                        <section class="rounded-[32px] border border-orange-200 bg-gradient-to-br from-orange-50 to-white p-6 shadow-sm">
                            <div class="text-sm font-black uppercase tracking-wider text-orange-600">
                                Panduan Booking
                            </div>

                            <h3 class="mt-3 text-2xl font-black text-slate-800">
                                Pastikan data sudah benar
                            </h3>

                            <div class="mt-5 space-y-4 text-sm text-slate-600">
                                <div class="flex gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-xs font-black text-white">1</div>
                                    <div>
                                        Pilih ruangan sesuai kapasitas peserta.
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-xs font-black text-white">2</div>
                                    <div>
                                        Pastikan jam mulai dan selesai tidak bentrok.
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-xs font-black text-white">3</div>
                                    <div>
                                        Booking masuk status pending sampai disetujui GA/Admin.
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-[32px] border border-blue-200 bg-white p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-black text-blue-700">
                                        Status Awal
                                    </div>
                                    <div class="mt-2 text-4xl font-black text-orange-500">
                                        PENDING
                                    </div>
                                </div>

                                <div class="rounded-2xl bg-blue-100 px-4 py-2 text-xs font-black text-blue-700">
                                    APPROVAL
                                </div>
                            </div>

                            <p class="mt-4 text-sm text-slate-500">
                                Setelah submit, booking Anda akan menunggu approval dari GA/Admin.
                            </p>
                        </section>

                        <section class="rounded-[32px] border border-slate-200 bg-[#0F172A] p-6 text-white shadow-sm">
                            <div class="text-sm font-black uppercase tracking-wider text-blue-200">
                                ProEnergi Facility
                            </div>

                            <h3 class="mt-3 text-xl font-black">
                                Smart Office Booking
                            </h3>

                            <p class="mt-3 text-sm leading-relaxed text-slate-300">
                                Modul ini membantu monitoring penggunaan ruangan, jadwal meeting, dan approval fasilitas kantor.
                            </p>
                        </section>
                    </aside>
                </div>

                {{-- ACTION --}}
                <div class="mt-6 flex flex-wrap justify-end gap-3 rounded-[28px] border border-slate-200 bg-white p-5 shadow-sm">
                    <a href="{{ url('/') }}"
                       class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                        Batal
                    </a>

                    <button type="submit"
                            class="rounded-2xl bg-gradient-to-r from-[#0F5DA9] to-[#F97316] px-7 py-3 text-sm font-black text-white shadow-lg transition hover:scale-[1.02]">
                        Submit Booking
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
</x-app-layout>