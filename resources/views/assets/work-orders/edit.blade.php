<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-black text-[#0B1F3A]">
                Edit Work Order
            </h2>

            <p class="text-sm text-slate-500">
                Update informasi maintenance work order.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">

            <x-flash-message />

            <div class="overflow-hidden rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] shadow-2xl">
                <div class="px-8 py-8 text-white">
                    <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                        <div class="max-w-4xl">
                            <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase tracking-wider text-white">
                                Work Order Maintenance
                            </div>

                            <h1 class="mt-5 text-4xl font-black tracking-tight">
                                {{ $workOrder->work_order_no }}
                            </h1>

                            <p class="mt-3 text-sm leading-7 text-blue-100">
                                Update data maintenance, assignment, vendor, scheduling, dan progress pengerjaan.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('assets.work-orders.show', $workOrder) }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-black text-white transition hover:bg-white/20">
                                Detail WO
                            </a>

                            <a href="{{ route('assets.work-orders.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-black text-[#0B1F3A]">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-slate-50 px-8 py-6">
                    <h3 class="text-2xl font-black text-[#0B1F3A]">
                        Form Edit Work Order
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Perbarui informasi work order maintenance asset.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('assets.work-orders.update', $workOrder) }}"
                      class="space-y-6 p-8">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

                        <div class="xl:col-span-2">
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Asset *
                            </label>

                            <select name="asset_id" required class="w-full rounded-2xl border-slate-300">
                                <option value="">Pilih Asset</option>

                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}"
                                            @selected(old('asset_id', $workOrder->asset_id) == $asset->id)>
                                        {{ $asset->asset_code }} - {{ $asset->asset_name }} | {{ $asset->location->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Maintenance Type *
                            </label>

                            <select name="maintenance_type" required class="w-full rounded-2xl border-slate-300">
                                @foreach(['preventive','corrective','inspection','calibration','breakdown'] as $type)
                                    <option value="{{ $type }}"
                                            @selected(old('maintenance_type', $workOrder->maintenance_type) === $type)>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Priority *
                            </label>

                            <select name="priority" required class="w-full rounded-2xl border-slate-300">
                                @foreach(['low','medium','high','critical'] as $priority)
                                    <option value="{{ $priority }}"
                                            @selected(old('priority', $workOrder->priority) === $priority)>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="xl:col-span-2">
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Problem Description *
                            </label>

                            <textarea name="problem_description"
                                      rows="4"
                                      required
                                      class="w-full rounded-2xl border-slate-300">{{ old('problem_description', $workOrder->problem_description) }}</textarea>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Maintenance Source
                            </label>

                            <select id="maintenance_source"
                                    onchange="toggleMaintenanceSource()"
                                    class="w-full rounded-2xl border-slate-300">
                                <option value="internal" @selected(old('vendor_name', $workOrder->vendor_name) == '')>
                                    Internal Technician
                                </option>
                                <option value="external" @selected(old('vendor_name', $workOrder->vendor_name) != '')>
                                    External Vendor
                                </option>
                            </select>
                        </div>

                        <div id="internal_section">
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Technician / PIC
                            </label>

                            <select name="assigned_to" class="w-full rounded-2xl border-slate-300">
                                <option value="">Belum Assign</option>

                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}"
                                            @selected(old('assigned_to', $workOrder->assigned_to) == $tech->id)>
                                        {{ $tech->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="vendor_section" class="hidden xl:col-span-2">
                            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                                <div>
                                    <label class="mb-2 block text-sm font-black text-slate-700">
                                        Vendor
                                    </label>

                                    <select id="vendor_select"
                                            onchange="fillVendorInfo(this)"
                                            class="w-full rounded-2xl border-slate-300">
                                        <option value="">Pilih Vendor</option>

                                        @foreach($vendors ?? [] as $vendor)
                                            <option value="{{ $vendor->id }}"
                                                    data-name="{{ $vendor->vendor_name }}"
                                                    data-pic="{{ $vendor->pic_name ?? $vendor->vendor_pic ?? '' }}"
                                                    data-phone="{{ $vendor->phone ?? $vendor->vendor_phone ?? '' }}"
                                                    @selected(old('vendor_name', $workOrder->vendor_name) === $vendor->vendor_name)>
                                                {{ $vendor->vendor_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="hidden"
                                           name="vendor_name"
                                           id="vendor_name"
                                           value="{{ old('vendor_name', $workOrder->vendor_name) }}">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-black text-slate-700">
                                        Vendor PIC
                                    </label>

                                    <input type="text"
                                           name="vendor_pic"
                                           id="vendor_pic"
                                           value="{{ old('vendor_pic', $workOrder->vendor_pic) }}"
                                           readonly
                                           class="w-full rounded-2xl border-slate-300 bg-slate-100">
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-black text-slate-700">
                                        Vendor Phone
                                    </label>

                                    <input type="text"
                                           name="vendor_phone"
                                           id="vendor_phone"
                                           value="{{ old('vendor_phone', $workOrder->vendor_phone) }}"
                                           readonly
                                           class="w-full rounded-2xl border-slate-300 bg-slate-100">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Estimated Cost
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="estimated_cost"
                                   value="{{ old('estimated_cost', $workOrder->estimated_cost) }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Start Meter / KM
                            </label>

                            <input type="number"
                                   name="start_meter"
                                   value="{{ old('start_meter', $workOrder->start_meter) }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Planned Start
                            </label>

                            <input type="datetime-local"
                                   name="planned_start_date"
                                   value="{{ old('planned_start_date', optional($workOrder->planned_start_date)->format('Y-m-d\TH:i')) }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Planned Finish
                            </label>

                            <input type="datetime-local"
                                   name="planned_finish_date"
                                   value="{{ old('planned_finish_date', optional($workOrder->planned_finish_date)->format('Y-m-d\TH:i')) }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div class="xl:col-span-2">
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Notes
                            </label>

                            <textarea name="notes"
                                      rows="3"
                                      class="w-full rounded-2xl border-slate-300">{{ old('notes', $workOrder->notes) }}</textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
                        <a href="{{ route('assets.work-orders.show', $workOrder) }}"
                           class="rounded-2xl bg-slate-200 px-6 py-3 text-sm font-black text-slate-700">
                            Batal
                        </a>

                        <button type="submit"
                                class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-black text-white transition hover:bg-[#123B6D]">
                            Update Work Order
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

            const vendorSelect = document.getElementById('vendor_select');

            if (vendorSelect && vendorSelect.value) {
                fillVendorInfo(vendorSelect);
            }
        });
    </script>
</x-app-layout>