@php
    $isEdit = isset($vendor) && $vendor;
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Vendor Code *</label>
        <input name="vendor_code"
               value="{{ old('vendor_code', $vendor->vendor_code ?? '') }}"
               required
               placeholder="VND-MTC-001"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Vendor Name *</label>
        <input name="vendor_name"
               value="{{ old('vendor_name', $vendor->vendor_name ?? '') }}"
               required
               placeholder="Nama vendor maintenance"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Vendor Type</label>
        <input name="vendor_type"
               value="{{ old('vendor_type', $vendor->vendor_type ?? '') }}"
               placeholder="AC / Truck / IT / Genset / Kalibrasi"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">PIC Name</label>
        <input name="pic_name"
               value="{{ old('pic_name', $vendor->pic_name ?? '') }}"
               placeholder="Nama PIC"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Phone</label>
        <input name="phone"
               value="{{ old('phone', $vendor->phone ?? '') }}"
               placeholder="No. HP / Telepon"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Email</label>
        <input type="email"
               name="email"
               value="{{ old('email', $vendor->email ?? '') }}"
               placeholder="email@vendor.com"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Rating</label>
        <input type="number"
               step="0.01"
               min="0"
               max="5"
               name="rating"
               value="{{ old('rating', $vendor->rating ?? 0) }}"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div class="flex items-end">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   @checked(old('is_active', $vendor->is_active ?? true))
                   class="rounded border-slate-300 text-[#0B1F3A]">
            <span class="text-sm font-bold text-slate-700">Vendor Aktif</span>
        </label>
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-bold text-slate-700">Address</label>
        <textarea name="address"
                  rows="3"
                  class="w-full rounded-2xl border-slate-300"
                  placeholder="Alamat vendor...">{{ old('address', $vendor->address ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-bold text-slate-700">Service Scope</label>
        <textarea name="service_scope"
                  rows="4"
                  class="w-full rounded-2xl border-slate-300"
                  placeholder="Contoh: service AC, perbaikan truck, genset, kalibrasi...">{{ old('service_scope', $vendor->service_scope ?? '') }}</textarea>
    </div>
</div>

<div class="flex justify-end gap-3 border-t pt-6">
    <a href="{{ route('assets.vendors.index') }}"
       class="rounded-2xl bg-slate-200 px-6 py-3 text-sm font-black text-slate-700">
        Batal
    </a>

    <button class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-black text-white hover:bg-[#123B6D]">
        {{ $isEdit ? 'Update Vendor' : 'Simpan Vendor' }}
    </button>
</div>