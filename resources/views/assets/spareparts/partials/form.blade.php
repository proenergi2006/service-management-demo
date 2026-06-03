@php
    $isEdit = isset($sparepart) && $sparepart;
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Kode Sparepart *</label>
        <input name="sparepart_code"
               value="{{ old('sparepart_code', $sparepart->sparepart_code ?? '') }}"
               required
               placeholder="SP-TRK-001"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Nama Sparepart *</label>
        <input name="sparepart_name"
               value="{{ old('sparepart_name', $sparepart->sparepart_name ?? '') }}"
               required
               placeholder="Oli Mesin Truck"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Kategori</label>
        <input name="category"
               value="{{ old('category', $sparepart->category ?? '') }}"
               placeholder="Truck / AC / IT / Genset"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Unit *</label>
        <input name="unit"
               value="{{ old('unit', $sparepart->unit ?? 'pcs') }}"
               required
               placeholder="pcs / liter / set / kg"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Standard Price</label>
        <input type="number"
               step="0.01"
               name="standard_price"
               value="{{ old('standard_price', $sparepart->standard_price ?? 0) }}"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold text-slate-700">Vendor</label>
        <input name="vendor_name"
               value="{{ old('vendor_name', $sparepart->vendor_name ?? '') }}"
               placeholder="Nama vendor"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-bold text-slate-700">Description</label>
        <textarea name="description"
                  rows="4"
                  class="w-full rounded-2xl border-slate-300"
                  placeholder="Deskripsi sparepart...">{{ old('description', $sparepart->description ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   @checked(old('is_active', $sparepart->is_active ?? true))
                   class="rounded border-slate-300 text-[#0B1F3A]">
            <span class="text-sm font-bold text-slate-700">Aktif</span>
        </label>
    </div>
</div>

<div class="flex justify-end gap-3 border-t pt-6">
    <a href="{{ route('assets.spareparts.index') }}"
       class="rounded-2xl bg-slate-200 px-6 py-3 text-sm font-black text-slate-700">
        Batal
    </a>

    <button class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-black text-white hover:bg-[#123B6D]">
        {{ $isEdit ? 'Update Sparepart' : 'Simpan Sparepart' }}
    </button>
</div>