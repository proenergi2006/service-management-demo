<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kendaraan</title>
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
                        <h1 class="text-2xl font-black text-[#0B1F3A]">Edit Kendaraan</h1>
                        <p class="text-sm text-slate-500">{{ $vehicle->vehicle_code }} - {{ $vehicle->plate_number }}</p>
                    </div>
                </div>

                <a href="{{ route('master-vehicles.index') }}"
                   class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                    Kembali
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8">
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
                <h2 class="text-xl font-black">Form Edit Master Kendaraan</h2>
                <p class="mt-1 text-sm text-blue-100">Perbarui informasi kendaraan operasional.</p>
            </div>

            <form method="POST" action="{{ route('master-vehicles.update', $vehicle) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Kode Kendaraan <span class="text-rose-500">*</span></label>
                        <input type="text" name="vehicle_code" value="{{ old('vehicle_code', $vehicle->vehicle_code) }}"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Plat Nomor <span class="text-rose-500">*</span></label>
                        <input type="text" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}"
                               class="w-full rounded-2xl border-slate-300 uppercase focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-bold text-slate-600">Nama Kendaraan <span class="text-rose-500">*</span></label>
                        <input type="text" name="vehicle_name" value="{{ old('vehicle_name', $vehicle->vehicle_name) }}"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Brand</label>
                        <input type="text" name="brand" value="{{ old('brand', $vehicle->brand) }}"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Model</label>
                        <input type="text" name="model" value="{{ old('model', $vehicle->model) }}"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Tipe Kendaraan</label>
                        <select name="type" class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                            <option value="">Pilih Tipe</option>
                            @foreach(['MPV','SUV','Sedan','Pickup','Truck','Motor'] as $type)
                                <option value="{{ $type }}" @selected(old('type', $vehicle->type) === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Kapasitas Penumpang</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $vehicle->capacity) }}" min="1"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Ownership Status</label>
                        <select name="ownership_status" class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                            <option value="">Pilih Status Kepemilikan</option>
                            <option value="company" @selected(old('ownership_status', $vehicle->ownership_status) === 'company')>Company Owned</option>
                            <option value="rental" @selected(old('ownership_status', $vehicle->ownership_status) === 'rental')>Rental</option>
                            <option value="leasing" @selected(old('ownership_status', $vehicle->ownership_status) === 'leasing')>Leasing</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Status Kendaraan <span class="text-rose-500">*</span></label>
                        <select name="vehicle_status" class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                            <option value="available" @selected(old('vehicle_status', $vehicle->vehicle_status) === 'available')>Available</option>
                            <option value="booked" @selected(old('vehicle_status', $vehicle->vehicle_status) === 'booked')>Booked</option>
                            <option value="maintenance" @selected(old('vehicle_status', $vehicle->vehicle_status) === 'maintenance')>Maintenance</option>
                            <option value="inactive" @selected(old('vehicle_status', $vehicle->vehicle_status) === 'inactive')>Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Cabang</label>
                        <select name="branch" class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                            <option value="">Pilih Cabang</option>
                            @foreach(['Head Office','Jakarta','Surabaya','Samarinda','Palembang','Banjarmasin','Pontianak','Sulawesi'] as $branch)
                                <option value="{{ $branch }}" @selected(old('branch', $vehicle->branch) === $branch)>{{ $branch }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location', $vehicle->location) }}"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">STNK Expired</label>
                        <input type="date" name="stnk_expired_date"
                               value="{{ old('stnk_expired_date', optional($vehicle->stnk_expired_date)->format('Y-m-d')) }}"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">KIR Expired</label>
                        <input type="date" name="kir_expired_date"
                               value="{{ old('kir_expired_date', optional($vehicle->kir_expired_date)->format('Y-m-d')) }}"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-600">Insurance Expired</label>
                        <input type="date" name="insurance_expired_date"
                               value="{{ old('insurance_expired_date', optional($vehicle->insurance_expired_date)->format('Y-m-d')) }}"
                               class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    </div>

                    <div class="flex items-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                               class="rounded border-slate-300 text-[#0B1F3A] focus:ring-[#0B1F3A]"
                               @checked(old('is_active', $vehicle->is_active))>
                        <span class="ml-2 text-sm font-bold text-slate-700">Aktif</span>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-bold text-slate-600">Catatan</label>
                        <textarea name="notes" rows="4"
                                  class="w-full rounded-2xl border-slate-300 focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">{{ old('notes', $vehicle->notes) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-6">
                    <a href="{{ route('master-vehicles.index') }}"
                       class="rounded-2xl bg-slate-200 px-5 py-3 text-sm font-bold text-slate-700 hover:bg-slate-300">
                        Batal
                    </a>

                    <button type="submit"
                            class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-bold text-white hover:bg-[#123B6D]">
                        Update Kendaraan
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>