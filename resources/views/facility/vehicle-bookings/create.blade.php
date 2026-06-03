<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking Kendaraan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800">

<header class="border-b bg-white shadow-sm">
    <div class="mx-auto max-w-6xl px-4 py-5">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10 w-auto">
                <div>
                    <h1 class="text-2xl font-black text-[#0B1F3A]">Booking Kendaraan</h1>
                    <p class="text-sm text-slate-500">Ajukan pemakaian kendaraan operasional perusahaan.</p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('vehicle-bookings.my') }}"
                   class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
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

<main class="mx-auto max-w-6xl px-4 py-8">

    @if (session('error'))
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-700">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-700">
            <div class="mb-2 font-black">Form belum lengkap:</div>
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="bg-[#0B1F3A] px-6 py-6 text-white">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-black">
                        Facility Management
                    </div>
                    <h2 class="mt-3 text-2xl font-black">Form Booking Kendaraan</h2>
                    <p class="mt-1 text-sm text-blue-100">
                        Isi detail perjalanan, tujuan, waktu keberangkatan, dan jumlah penumpang.
                    </p>
                </div>

                <div class="rounded-3xl bg-white/10 px-5 py-4 text-right ring-1 ring-white/20">
                    <div class="text-xs text-blue-100">Status Awal</div>
                    <div class="text-lg font-black">PENDING</div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('vehicle-bookings.store') }}" class="p-6">
            @csrf

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- INFORMASI PEMOHON --}}
                <div class="md:col-span-2 rounded-2xl bg-slate-50 p-5">
                    <div class="mb-4">
                        <h3 class="text-lg font-black text-slate-800">Informasi Pemohon</h3>
                        <p class="text-sm text-slate-500">Data pemohon otomatis dari akun login.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-bold text-slate-600">Nama</label>
                            <input type="text" value="{{ auth()->user()->name ?? '-' }}" readonly
                                   class="w-full rounded-2xl border-slate-200 bg-white text-slate-600">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold text-slate-600">Email</label>
                            <input type="text" value="{{ auth()->user()->email ?? '-' }}" readonly
                                   class="w-full rounded-2xl border-slate-200 bg-white text-slate-600">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold text-slate-600">Department</label>
                            <input type="text" value="{{ auth()->user()->department ?? '-' }}" readonly
                                   class="w-full rounded-2xl border-slate-200 bg-white text-slate-600">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold text-slate-600">Cabang</label>
                            <input type="text" value="{{ auth()->user()->branch ?? '-' }}" readonly
                                   class="w-full rounded-2xl border-slate-200 bg-white text-slate-600">
                        </div>
                    </div>
                </div>

                {{-- KENDARAAN --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">
                        Kendaraan
                        <span class="text-xs font-normal text-slate-400">(opsional, GA bisa menentukan jika kosong)</span>
                    </label>

                    <select name="vehicle_id"
                            class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                        <option value="">Pilih Kendaraan / Tentukan oleh GA</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" @selected(old('vehicle_id') == $vehicle->id)>
                                {{ $vehicle->plate_number }}
                                - {{ $vehicle->vehicle_name }}
                                @if($vehicle->brand || $vehicle->model)
                                    | {{ trim(($vehicle->brand ?? '') . ' ' . ($vehicle->model ?? '')) }}
                                @endif
                                @if($vehicle->capacity)
                                    | Kapasitas {{ $vehicle->capacity }}
                                @endif
                                | {{ strtoupper($vehicle->vehicle_status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TUJUAN --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">
                        Tujuan / Lokasi Perjalanan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="destination"
                           value="{{ old('destination') }}"
                           required
                           placeholder="Contoh: Kantor Cabang Jakarta / Meeting Customer"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                {{-- WAKTU --}}
                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">
                        Tanggal & Jam Berangkat <span class="text-rose-500">*</span>
                    </label>
                    <input type="datetime-local"
                           name="departure_datetime"
                           value="{{ old('departure_datetime') }}"
                           required
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">
                        Estimasi Tanggal & Jam Kembali
                    </label>
                    <input type="datetime-local"
                           name="return_datetime"
                           value="{{ old('return_datetime') }}"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                {{-- PENUMPANG --}}
                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">Jumlah Penumpang</label>
                    <input type="number"
                           name="passenger_count"
                           value="{{ old('passenger_count') }}"
                           min="1"
                           placeholder="Contoh: 3"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">
                        Sumber Driver <span class="text-rose-500">*</span>
                    </label>
                    <select name="driver_source"
                            required
                            class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                        <option value="">Pilih Sumber Driver</option>
                        <option value="self_drive" @selected(old('driver_source') === 'self_drive')>Self Drive / Bawa Sendiri</option>
                        <option value="vendor" @selected(old('driver_source') === 'vendor')>Vendor Driver</option>
                        <option value="internal" @selected(old('driver_source') === 'internal')>Internal</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">Nama Driver</label>
                    <input type="text"
                           name="driver_name"
                           value="{{ old('driver_name') }}"
                           placeholder="Opsional"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">No. HP Driver</label>
                    <input type="text"
                           name="driver_phone"
                           value="{{ old('driver_phone') }}"
                           placeholder="Opsional"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">Nama Penumpang</label>
                    <textarea name="passenger_names"
                              rows="3"
                              placeholder="Contoh: Iwan, Budi, Sari"
                              class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">{{ old('passenger_names') }}</textarea>
                </div>

                {{-- PURPOSE --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">Keperluan / Agenda</label>
                    <textarea name="purpose"
                              rows="4"
                              placeholder="Jelaskan tujuan penggunaan kendaraan..."
                              class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">{{ old('purpose') }}</textarea>
                </div>

                {{-- NOTES --}}
                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">Catatan Tambahan</label>
                    <textarea name="notes"
                              rows="3"
                              placeholder="Contoh: butuh mobil besar / membawa barang / estimasi lembur..."
                              class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ url('/') }}"
                   class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                    Batal
                </a>

                <button type="submit"
                        class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-bold text-white shadow hover:bg-[#123B6D]">
                    Submit Booking
                </button>
            </div>
        </form>
    </section>

    <div class="mt-5 rounded-2xl border border-blue-100 bg-blue-50 px-5 py-4 text-sm text-[#0B1F3A]">
        <strong>Info:</strong> Booking kendaraan akan masuk status <strong>Pending</strong> dan menunggu approval GA/Admin.
    </div>
</main>

</body>
</html>