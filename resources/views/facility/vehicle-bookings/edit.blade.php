<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Booking Kendaraan</title>
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
                    <h1 class="text-2xl font-black text-[#0B1F3A]">Edit Booking Kendaraan</h1>
                    <p class="text-sm text-slate-500">{{ $booking->booking_number }}</p>
                </div>
            </div>

            <a href="{{ route('vehicle-bookings.my') }}"
               class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                Kembali
            </a>
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
            <h2 class="text-2xl font-black">Form Edit Booking Kendaraan</h2>
            <p class="mt-1 text-sm text-blue-100">
                Booking hanya bisa diedit selama status masih pending.
            </p>
        </div>

        <form method="POST" action="{{ route('vehicle-bookings.update', $booking) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="md:col-span-2 rounded-2xl bg-slate-50 p-5">
                    <h3 class="mb-4 text-lg font-black text-slate-800">Informasi Pemohon</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm font-bold text-slate-600">Nama</label>
                            <input type="text" value="{{ $booking->requester_name ?? '-' }}" readonly
                                   class="w-full rounded-2xl border-slate-200 bg-white text-slate-600">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold text-slate-600">Email</label>
                            <input type="text" value="{{ $booking->requester_email ?? '-' }}" readonly
                                   class="w-full rounded-2xl border-slate-200 bg-white text-slate-600">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold text-slate-600">Department</label>
                            <input type="text" value="{{ $booking->department ?? '-' }}" readonly
                                   class="w-full rounded-2xl border-slate-200 bg-white text-slate-600">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold text-slate-600">Status</label>
                            <input type="text" value="{{ strtoupper($booking->status) }}" readonly
                                   class="w-full rounded-2xl border-slate-200 bg-white text-slate-600">
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">Kendaraan</label>
                    <select name="vehicle_id"
                            class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                        <option value="">Tentukan oleh GA</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $booking->vehicle_id) == $vehicle->id)>
                                {{ $vehicle->plate_number }} - {{ $vehicle->vehicle_name }} | {{ strtoupper($vehicle->vehicle_status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">
                        Tujuan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           name="destination"
                           value="{{ old('destination', $booking->destination) }}"
                           required
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">
                        Tanggal & Jam Berangkat <span class="text-rose-500">*</span>
                    </label>
                    <input type="datetime-local"
                           name="departure_datetime"
                           value="{{ old('departure_datetime', $booking->departure_datetime?->format('Y-m-d\TH:i')) }}"
                           required
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">
                        Estimasi Tanggal & Jam Kembali
                    </label>
                    <input type="datetime-local"
                           name="return_datetime"
                           value="{{ old('return_datetime', $booking->return_datetime?->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">Jumlah Penumpang</label>
                    <input type="number"
                           name="passenger_count"
                           value="{{ old('passenger_count', $booking->passenger_count) }}"
                           min="1"
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
                        <option value="self_drive" @selected(old('driver_source', $booking->driver_source) === 'self_drive')>Self Drive</option>
                        <option value="vendor" @selected(old('driver_source', $booking->driver_source) === 'vendor')>Vendor Driver</option>
                        <option value="internal" @selected(old('driver_source', $booking->driver_source) === 'internal')>Internal</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">Nama Driver</label>
                    <input type="text"
                           name="driver_name"
                           value="{{ old('driver_name', $booking->driver_name) }}"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-bold text-slate-600">No HP Driver</label>
                    <input type="text"
                           name="driver_phone"
                           value="{{ old('driver_phone', $booking->driver_phone) }}"
                           class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">Nama Penumpang</label>
                    <textarea name="passenger_names"
                              rows="3"
                              class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">{{ old('passenger_names', $booking->passenger_names) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">Keperluan</label>
                    <textarea name="purpose"
                              rows="4"
                              class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">{{ old('purpose', $booking->purpose) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1 block text-sm font-bold text-slate-600">Catatan Tambahan</label>
                    <textarea name="notes"
                              rows="3"
                              class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">{{ old('notes', $booking->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-6">
                <a href="{{ route('vehicle-bookings.my') }}"
                   class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                    Batal
                </a>

                <button type="submit"
                        class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-bold text-white hover:bg-[#123B6D]">
                    Update Booking
                </button>
            </div>
        </form>
    </section>
</main>

</body>
</html>