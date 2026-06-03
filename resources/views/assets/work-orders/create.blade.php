<x-app-layout>
   

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">
            <x-flash-message />

            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            Maintenance Request
                        </div>
                        <h1 class="mt-4 text-4xl font-black">Buat Work Order Baru</h1>
                        <p class="mt-2 text-sm text-blue-100">Masukkan kebutuhan maintenance, prioritas, jadwal, vendor, dan estimasi biaya.</p>
                    </div>

                    <a href="{{ route('assets.work-orders.index') }}"
                       class="rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-black text-white">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b bg-slate-50 px-7 py-5">
                    <h3 class="text-xl font-black text-[#0B1F3A]">Form Work Order</h3>
                </div>

                <form method="POST" action="{{ route('assets.work-orders.store') }}" class="space-y-6 p-7">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-bold">Asset *</label>
                            <select name="asset_id" required class="w-full rounded-2xl border-slate-300">
                                <option value="">Pilih Asset</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}" @selected(old('asset_id', $selectedAssetId) == $asset->id)>
                                        {{ $asset->asset_code }} - {{ $asset->asset_name }} | {{ $asset->location->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold">Maintenance Type *</label>
                            <select name="maintenance_type" required class="w-full rounded-2xl border-slate-300">
                                @foreach(['preventive','corrective','inspection','calibration','breakdown'] as $type)
                                    <option value="{{ $type }}" @selected(old('maintenance_type','corrective') === $type)>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-bold">Priority *</label>
                            <select name="priority" required class="w-full rounded-2xl border-slate-300">
                                @foreach(['low','medium','high','critical'] as $priority)
                                    <option value="{{ $priority }}" @selected(old('priority','medium') === $priority)>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-bold">Problem Description *</label>
                            <textarea name="problem_description" rows="4" required
                                      class="w-full rounded-2xl border-slate-300"
                                      placeholder="Jelaskan kerusakan / kebutuhan maintenance...">{{ old('problem_description') }}</textarea>
                        </div>

                        {{-- ASSIGNMENT --}}
<div>
    <label class="mb-1 block text-sm font-bold">
        Maintenance Source *
    </label>

    <select name="maintenance_source"
            id="maintenance_source"
            onchange="toggleMaintenanceSource()"
            class="w-full rounded-2xl border-slate-300">
        <option value="internal" @selected(old('maintenance_source', 'internal') === 'internal')>
            Internal Technician
        </option>
        <option value="external" @selected(old('maintenance_source') === 'external')>
            External Vendor
        </option>
    </select>
</div>

<div id="internal_section">
    <label class="mb-1 block text-sm font-bold">
        Technician / PIC
    </label>

    <select name="assigned_to" class="w-full rounded-2xl border-slate-300">
        <option value="">Belum assign</option>
        @foreach($technicians as $user)
            <option value="{{ $user->id }}" @selected(old('assigned_to') == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

<div id="vendor_section" class="md:col-span-2 hidden">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

        <div>
            <label class="mb-1 block text-sm font-bold">
                Vendor
            </label>

            <select id="vendor_select"
                    class="w-full rounded-2xl border-slate-300"
                    onchange="fillVendorInfo(this)">
                <option value="">Pilih Vendor</option>

                @foreach($vendors ?? [] as $vendor)
                    <option value="{{ $vendor->id }}"
                            data-name="{{ $vendor->vendor_name }}"
                            data-pic="{{ $vendor->pic_name ?? $vendor->vendor_pic ?? '' }}"
                            data-phone="{{ $vendor->phone ?? $vendor->vendor_phone ?? '' }}">
                        {{ $vendor->vendor_name }}
                    </option>
                @endforeach
            </select>

            <input type="hidden" name="vendor_name" id="vendor_name" value="{{ old('vendor_name') }}">
        </div>

        <div>
            <label class="mb-1 block text-sm font-bold">
                Vendor PIC
            </label>

            <input type="text"
                   name="vendor_pic"
                   id="vendor_pic"
                   value="{{ old('vendor_pic') }}"
                   readonly
                   class="w-full rounded-2xl border-slate-300 bg-slate-100">
        </div>

        <div>
            <label class="mb-1 block text-sm font-bold">
                Vendor Phone
            </label>

            <input type="text"
                   name="vendor_phone"
                   id="vendor_phone"
                   value="{{ old('vendor_phone') }}"
                   readonly
                   class="w-full rounded-2xl border-slate-300 bg-slate-100">
        </div>

    </div>
</div>

                        <div>
                            <label class="mb-1 block text-sm font-bold">Start Meter / KM</label>
                            <input type="number" name="start_meter" value="{{ old('start_meter') }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-1 block text-sm font-bold">Notes</label>
                            <textarea name="notes" rows="3" class="w-full rounded-2xl border-slate-300">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t pt-6">
                        <a href="{{ route('assets.work-orders.index') }}"
                           class="rounded-2xl bg-slate-200 px-6 py-3 text-sm font-black text-slate-700">
                            Batal
                        </a>

                        <button class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-black text-white">
                            Simpan Work Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleMaintenanceSource() {
            const source = document.getElementById('maintenance_source').value;
            const internalSection = document.getElementById('internal_section');
            const vendorSection = document.getElementById('vendor_section');
    
            if (source === 'external') {
                internalSection.classList.add('hidden');
                vendorSection.classList.remove('hidden');
            } else {
                internalSection.classList.remove('hidden');
                vendorSection.classList.add('hidden');
    
                document.getElementById('vendor_name').value = '';
                document.getElementById('vendor_pic').value = '';
                document.getElementById('vendor_phone').value = '';
            }
        }
    
        function fillVendorInfo(select) {
            const option = select.options[select.selectedIndex];
    
            document.getElementById('vendor_name').value = option.dataset.name || '';
            document.getElementById('vendor_pic').value = option.dataset.pic || '';
            document.getElementById('vendor_phone').value = option.dataset.phone || '';
        }
    
        document.addEventListener('DOMContentLoaded', function () {
            toggleMaintenanceSource();
        });
    </script>
</x-app-layout>