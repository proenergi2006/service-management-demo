@php
    $isEdit = isset($asset);

    $selectedOwnerRole = old('owner_role', $asset->owner_role ?? '');
    $selectedAssetType = old('asset_type', $asset->asset_type ?? '');

    $vehicleTypes = ['office_vehicle', 'truck_tank', 'forklift', 'fleet_vehicle'];
    $facilityTypes = ['ga_facility', 'building_equipment', 'office_equipment'];
    $itTypes = ['it_device', 'network_device'];

    $assetTypes = [
        'IT' => [
            'it_device' => 'IT Device',
            'network_device' => 'Network Device',
            'office_equipment' => 'Office Equipment',
        ],
        'GA' => [
            'ga_facility' => 'GA Facility',
            'building_equipment' => 'Building Equipment',
            'office_equipment' => 'Office Equipment',
            'office_vehicle' => 'Mobil Operasional Kantor',
        ],
        'LOGISTIK' => [
            'truck_tank' => 'Truck Tangki',
            'forklift' => 'Forklift',
            'fleet_vehicle' => 'Fleet Vehicle',
        ],
    ];
@endphp

<div class="space-y-8">

    {{-- INFORMASI UTAMA --}}
    <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-7 py-5">
            <h3 class="text-xl font-black text-[#0B1F3A]">Informasi Utama</h3>
            <p class="mt-1 text-sm text-slate-500">
                Data dasar untuk identifikasi asset.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-7 md:grid-cols-2">

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Asset Code <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="asset_code"
                    required
                    value="{{ old('asset_code', $asset->asset_code ?? '') }}"
                    placeholder="Contoh: AST-IT-0001"
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                @error('asset_code')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Asset Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="asset_name"
                    required
                    value="{{ old('asset_name', $asset->asset_name ?? '') }}"
                    placeholder="Contoh: Laptop Lenovo ThinkPad / Truck Tangki 8000L"
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                @error('asset_name')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select
                    name="category_id"
                    required
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $asset->category_id ?? '') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Departemen Pemilik <span class="text-red-500">*</span>
                </label>
                <select
                    name="owner_role"
                    id="owner_role"
                    required
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                    <option value="">-- Pilih Departemen --</option>
                    <option value="IT" @selected($selectedOwnerRole === 'IT')>IT</option>
                    <option value="GA" @selected($selectedOwnerRole === 'GA')>GA</option>
                    <option value="LOGISTIK" @selected($selectedOwnerRole === 'LOGISTIK')>LOGISTIK</option>
                </select>
                @error('owner_role')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Jenis Asset
                </label>

                <select
                    name="asset_type"
                    id="asset_type"
                    data-selected="{{ $selectedAssetType }}"
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                    <option value="">-- Pilih Jenis Asset --</option>

                    @foreach($assetTypes as $role => $types)
                        @foreach($types as $value => $label)
                            <option
                                value="{{ $value }}"
                                data-role="{{ $role }}"
                                @selected($selectedAssetType === $value)
                            >
                                {{ $label }}
                            </option>
                        @endforeach
                    @endforeach
                </select>

                <p class="mt-2 text-xs font-semibold text-slate-400">
                    Pilihan jenis asset akan menyesuaikan Departemen Pemilik.
                </p>

                @error('asset_type')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Lokasi
                </label>
                <select
                    name="location_id"
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('location_id', $asset->location_id ?? '') == $location->id)>
                            {{ $location->name }}
                        </option>
                    @endforeach
                </select>
                @error('location_id')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Brand</label>
                <input
                    type="text"
                    name="brand"
                    value="{{ old('brand', $asset->brand ?? '') }}"
                    placeholder="Contoh: Lenovo / Hino / Daikin"
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                @error('brand')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Model</label>
                <input
                    type="text"
                    name="model"
                    value="{{ old('model', $asset->model ?? '') }}"
                    placeholder="Contoh: ThinkPad T14 / Dutro / Split Wall"
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                @error('model')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Serial Number</label>
                <input
                    type="text"
                    name="serial_number"
                    value="{{ old('serial_number', $asset->serial_number ?? '') }}"
                    placeholder="Serial number perangkat"
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                @error('serial_number')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">QR Code</label>
                <input
                    type="text"
                    name="qr_code"
                    value="{{ old('qr_code', $asset->qr_code ?? '') }}"
                    placeholder="Kosongkan jika auto generate"
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                @error('qr_code')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- FIELD IT --}}
    <div id="itFields" class="hidden overflow-hidden rounded-[32px] border border-cyan-100 bg-cyan-50/60 shadow-sm">
        <div class="border-b border-cyan-100 px-7 py-5">
            <h3 class="text-xl font-black text-[#0B1F3A]">Informasi IT Asset</h3>
            <p class="mt-1 text-sm text-slate-500">
                Untuk laptop, PC, printer, CCTV, server, network device, dan perangkat IT lainnya.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-7 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">IP Address</label>
                <input type="text" name="ip_address" value="{{ old('ip_address', $asset->ip_address ?? '') }}" placeholder="Opsional jika asset jaringan" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Hostname / Device Name</label>
                <input type="text" name="hostname" value="{{ old('hostname', $asset->hostname ?? '') }}" placeholder="Contoh: LAPTOP-HO-001" class="w-full rounded-2xl border-slate-300">
            </div>
        </div>
    </div>

    {{-- FIELD KENDARAAN --}}
    <div id="vehicleFields" class="hidden overflow-hidden rounded-[32px] border border-blue-100 bg-blue-50/60 shadow-sm">
        <div class="border-b border-blue-100 px-7 py-5">
            <h3 class="text-xl font-black text-[#0B1F3A]">Informasi Kendaraan / Fleet</h3>
            <p class="mt-1 text-sm text-slate-500">
                Untuk mobil operasional GA, truck tangki, forklift, dan kendaraan logistik.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-7 md:grid-cols-2 xl:grid-cols-3">
            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">No. Polisi</label>
                <input type="text" name="plate_number" value="{{ old('plate_number', $asset->plate_number ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">No. Mesin</label>
                <input type="text" name="engine_number" value="{{ old('engine_number', $asset->engine_number ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">No. Rangka</label>
                <input type="text" name="chassis_number" value="{{ old('chassis_number', $asset->chassis_number ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Kapasitas</label>
                <input type="number" step="0.01" name="capacity" value="{{ old('capacity', $asset->capacity ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Satuan Kapasitas</label>
                <select name="capacity_unit" class="w-full rounded-2xl border-slate-300">
                    <option value="">-- Pilih Satuan --</option>
                    <option value="Liter" @selected(old('capacity_unit', $asset->capacity_unit ?? '') === 'Liter')>Liter</option>
                    <option value="KL" @selected(old('capacity_unit', $asset->capacity_unit ?? '') === 'KL')>KL</option>
                    <option value="Ton" @selected(old('capacity_unit', $asset->capacity_unit ?? '') === 'Ton')>Ton</option>
                    <option value="Seat" @selected(old('capacity_unit', $asset->capacity_unit ?? '') === 'Seat')>Seat</option>
                    <option value="Unit" @selected(old('capacity_unit', $asset->capacity_unit ?? '') === 'Unit')>Unit</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Fuel Type</label>
                <input type="text" name="fuel_type" value="{{ old('fuel_type', $asset->fuel_type ?? '') }}" placeholder="Solar / Bensin" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">STNK Expired</label>
                <input type="date" name="stnk_expired_date" value="{{ old('stnk_expired_date', isset($asset) && $asset->stnk_expired_date ? $asset->stnk_expired_date->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">KIR Expired</label>
                <input type="date" name="kir_expired_date" value="{{ old('kir_expired_date', isset($asset) && $asset->kir_expired_date ? $asset->kir_expired_date->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Insurance Expired</label>
                <input type="date" name="insurance_expired_date" value="{{ old('insurance_expired_date', isset($asset) && $asset->insurance_expired_date ? $asset->insurance_expired_date->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Odometer</label>
                <input type="number" name="odometer" value="{{ old('odometer', $asset->odometer ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Service Interval KM</label>
                <input type="number" name="service_interval_km" value="{{ old('service_interval_km', $asset->service_interval_km ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Last Service Date</label>
                <input type="date" name="last_service_date" value="{{ old('last_service_date', isset($asset) && $asset->last_service_date ? $asset->last_service_date->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Next Service Date</label>
                <input type="date" name="next_service_date" value="{{ old('next_service_date', isset($asset) && $asset->next_service_date ? $asset->next_service_date->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>
        </div>
    </div>

    {{-- FIELD FACILITY --}}
    <div id="facilityFields" class="hidden overflow-hidden rounded-[32px] border border-emerald-100 bg-emerald-50/60 shadow-sm">
        <div class="border-b border-emerald-100 px-7 py-5">
            <h3 class="text-xl font-black text-[#0B1F3A]">Informasi Facility / GA</h3>
            <p class="mt-1 text-sm text-slate-500">
                Untuk AC, furniture, CCTV, genset, pompa, building equipment, dan fasilitas kantor.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-7 md:grid-cols-3">
            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Area Facility</label>
                <input type="text" name="facility_area" value="{{ old('facility_area', $asset->facility_area ?? '') }}" placeholder="Lobby / Meeting Room / Warehouse" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Lantai</label>
                <input type="text" name="floor" value="{{ old('floor', $asset->floor ?? '') }}" placeholder="Lantai 1 / 2 / Basement" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Nama Ruangan</label>
                <input type="text" name="room_name" value="{{ old('room_name', $asset->room_name ?? '') }}" placeholder="Ruang Meeting / Server Room" class="w-full rounded-2xl border-slate-300">
            </div>
        </div>
    </div>

    {{-- STATUS --}}
    <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-7 py-5">
            <h3 class="text-xl font-black text-[#0B1F3A]">Status Asset</h3>
            <p class="mt-1 text-sm text-slate-500">
                Tentukan kondisi dan status operasional asset saat ini.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-7 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Condition Status <span class="text-red-500">*</span>
                </label>
                <select
                    name="condition_status"
                    required
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                    @foreach(['good','fair','damaged','repair','disposed'] as $status)
                        <option value="{{ $status }}" @selected(old('condition_status', $asset->condition_status ?? 'good') == $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('condition_status')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Lifecycle Status <span class="text-red-500">*</span>
                </label>
                <select
                    name="lifecycle_status"
                    required
                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                >
                    @foreach(['in_stock','assigned','maintenance','disposed','lost'] as $status)
                        <option value="{{ $status }}" @selected(old('lifecycle_status', $asset->lifecycle_status ?? 'in_stock') == $status)>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
                @error('lifecycle_status')
                    <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- PEMBELIAN & WARRANTY --}}
    <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-7 py-5">
            <h3 class="text-xl font-black text-[#0B1F3A]">Pembelian & Warranty</h3>
            <p class="mt-1 text-sm text-slate-500">
                Informasi tanggal pembelian, penerimaan, dan garansi asset.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-7 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Purchase Date</label>
                <input type="date" name="purchase_date" value="{{ old('purchase_date', isset($asset->purchase_date) ? $asset->purchase_date?->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Received Date</label>
                <input type="date" name="received_date" value="{{ old('received_date', isset($asset->received_date) ? $asset->received_date?->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Warranty Start</label>
                <input type="date" name="warranty_start_date" value="{{ old('warranty_start_date', isset($asset->warranty_start_date) ? $asset->warranty_start_date?->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Warranty End</label>
                <input type="date" name="warranty_end_date" value="{{ old('warranty_end_date', isset($asset->warranty_end_date) ? $asset->warranty_end_date?->format('Y-m-d') : '') }}" class="w-full rounded-2xl border-slate-300">
            </div>
        </div>
    </div>

    {{-- INTEGRASI --}}
    <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-7 py-5">
            <h3 class="text-xl font-black text-[#0B1F3A]">Integrasi Referensi</h3>
            <p class="mt-1 text-sm text-slate-500">
                Nomor referensi dari sistem lain seperti SYOP dan Accurate.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-7 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">SYOP PR No</label>
                <input type="text" name="syop_pr_no" value="{{ old('syop_pr_no', $asset->syop_pr_no ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">SYOP PO No</label>
                <input type="text" name="syop_po_no" value="{{ old('syop_po_no', $asset->syop_po_no ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>

            <div class="md:col-span-2">
                <label class="mb-1 block text-sm font-bold text-slate-700">Accurate Asset ID</label>
                <input type="text" name="accurate_asset_id" value="{{ old('accurate_asset_id', $asset->accurate_asset_id ?? '') }}" class="w-full rounded-2xl border-slate-300">
            </div>
        </div>
    </div>

    {{-- CATATAN --}}
    <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-7 py-5">
            <h3 class="text-xl font-black text-[#0B1F3A]">Keterangan Tambahan</h3>
            <p class="mt-1 text-sm text-slate-500">
                Tambahkan deskripsi dan catatan lain yang diperlukan.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 p-7">
            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Description</label>
                <textarea name="description" rows="4" class="w-full rounded-2xl border-slate-300">{{ old('description', $asset->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold text-slate-700">Notes</label>
                <textarea name="notes" rows="4" class="w-full rounded-2xl border-slate-300">{{ old('notes', $asset->notes ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- ACTION BUTTON --}}
    <div class="flex flex-wrap items-center gap-3 pt-2">
        <button
            type="submit"
            class="sap-save-btn inline-flex items-center justify-center rounded-2xl bg-[#0B1F3A] px-7 py-3 text-sm font-black text-white shadow-sm transition hover:bg-[#123B6D]"
        >
            {{ $isEdit ? 'Update Asset' : 'Simpan Asset' }}
        </button>

        @if($isEdit)
            <a href="{{ route('assets.show', $asset) }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-7 py-3 text-sm font-black text-slate-700 transition hover:bg-slate-50">
                Kembali ke Detail
            </a>
        @else
            <a href="{{ route('assets.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-7 py-3 text-sm font-black text-slate-700 transition hover:bg-slate-50">
                Kembali ke List
            </a>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ownerRole = document.getElementById('owner_role');
    const assetType = document.getElementById('asset_type');

    const itFields = document.getElementById('itFields');
    const vehicleFields = document.getElementById('vehicleFields');
    const facilityFields = document.getElementById('facilityFields');

    const allTypeOptions = Array.from(assetType?.querySelectorAll('option[data-role]') || []);

    const itTypes = ['it_device', 'network_device'];
    const vehicleTypes = ['office_vehicle', 'truck_tank', 'forklift', 'fleet_vehicle'];
    const facilityTypes = ['ga_facility', 'building_equipment', 'office_equipment'];

    function filterAssetTypesByOwner() {
        const role = ownerRole?.value || '';
        const currentValue = assetType?.value || '';

        allTypeOptions.forEach(option => {
            const optionRole = option.dataset.role;
            option.hidden = role !== '' && optionRole !== role;
            option.disabled = role !== '' && optionRole !== role;
        });

        if (role !== '' && currentValue) {
            const selectedOption = assetType.querySelector(`option[value="${currentValue}"]`);
            if (selectedOption && selectedOption.dataset.role !== role) {
                assetType.value = '';
            }
        }
    }

    function toggleAssetExtraFields() {
        const value = assetType?.value || '';

        itFields?.classList.toggle('hidden', !itTypes.includes(value));
        vehicleFields?.classList.toggle('hidden', !vehicleTypes.includes(value));
        facilityFields?.classList.toggle('hidden', !facilityTypes.includes(value));
    }

    ownerRole?.addEventListener('change', function () {
        filterAssetTypesByOwner();
        toggleAssetExtraFields();
    });

    assetType?.addEventListener('change', toggleAssetExtraFields);

    filterAssetTypesByOwner();
    toggleAssetExtraFields();
});
</script>