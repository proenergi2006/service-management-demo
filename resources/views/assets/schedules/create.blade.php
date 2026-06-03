<x-app-layout>
    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">

            <x-flash-message />

            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            Preventive Maintenance
                        </div>

                        <h1 class="mt-4 text-4xl font-black">
                            New Preventive Schedule
                        </h1>

                        <p class="mt-2 text-sm text-blue-100">
                            Jadwalkan service berkala berdasarkan tanggal, KM, atau hour meter.
                        </p>
                    </div>

                    <a href="{{ route('assets.schedules.index') }}"
                       class="rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-black text-white">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b bg-slate-50 px-7 py-5">
                    <h3 class="text-xl font-black text-[#0B1F3A]">
                        Form Schedule
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Tentukan asset, interval PM, PIC teknisi, vendor, dan estimasi biaya.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('assets.schedules.store') }}"
                      class="space-y-6 p-7">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

                        <div class="xl:col-span-2">
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Asset *
                            </label>

                            <select name="asset_id"
                                    required
                                    class="w-full rounded-2xl border-slate-300">
                                <option value="">Pilih Asset</option>

                                @foreach($assets ?? [] as $asset)
                                    <option value="{{ $asset->id }}" @selected(old('asset_id', $selectedAssetId ?? '') == $asset->id)>
                                        {{ $asset->asset_code }} - {{ $asset->asset_name }} | {{ $asset->location->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Schedule Name *
                            </label>

                            <input type="text"
                                   name="schedule_name"
                                   required
                                   value="{{ old('schedule_name') }}"
                                   placeholder="Service AC 3 Bulanan / Service Truck 10.000 KM"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Maintenance Type *
                            </label>

                            <select name="maintenance_type"
                                    required
                                    class="w-full rounded-2xl border-slate-300">
                                @foreach(['preventive','inspection','calibration'] as $type)
                                    <option value="{{ $type }}" @selected(old('maintenance_type', 'preventive') === $type)>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Frequency Type *
                            </label>

                            <select name="frequency_type"
                                    required
                                    class="w-full rounded-2xl border-slate-300">
                                <option value="daily" @selected(old('frequency_type') === 'daily')>DAILY</option>
                                <option value="weekly" @selected(old('frequency_type') === 'weekly')>WEEKLY</option>
                                <option value="monthly" @selected(old('frequency_type', 'monthly') === 'monthly')>MONTHLY</option>
                                <option value="yearly" @selected(old('frequency_type') === 'yearly')>YEARLY</option>
                                <option value="km" @selected(old('frequency_type') === 'km')>KM</option>
                                <option value="hour_meter" @selected(old('frequency_type') === 'hour_meter')>HOUR METER</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Frequency Interval *
                            </label>

                            <input type="number"
                                   name="frequency_interval"
                                   required
                                   min="1"
                                   value="{{ old('frequency_interval', 1) }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Start Date
                            </label>

                            <input type="date"
                                   name="start_date"
                                   value="{{ old('start_date') }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Next Execution Date
                            </label>

                            <input type="date"
                                   name="next_execution_date"
                                   value="{{ old('next_execution_date') }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Next Meter / KM
                            </label>

                            <input type="number"
                                   name="next_meter"
                                   value="{{ old('next_meter') }}"
                                   placeholder="Contoh: 10000"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Reminder Days Before
                            </label>

                            <input type="number"
                                   name="reminder_days_before"
                                   value="{{ old('reminder_days_before', 7) }}"
                                   min="0"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Priority *
                            </label>

                            <select name="priority"
                                    required
                                    class="w-full rounded-2xl border-slate-300">
                                @foreach(['low','medium','high','critical'] as $priority)
                                    <option value="{{ $priority }}" @selected(old('priority', 'medium') === $priority)>
                                        {{ ucfirst($priority) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Assigned Technician / PIC
                            </label>

                            <select name="assigned_to"
                                    class="w-full rounded-2xl border-slate-300">
                                <option value="">Belum assign</option>

                                @foreach($technicians ?? [] as $user)
                                    <option value="{{ $user->id }}" @selected(old('assigned_to') == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Vendor
                            </label>

                            <select id="vendor_select"
                                    onchange="fillVendorSchedule(this)"
                                    class="w-full rounded-2xl border-slate-300">
                                <option value="">Pilih Vendor</option>

                                @foreach($vendors ?? [] as $vendor)
                                    <option value="{{ $vendor->id }}"
                                            data-name="{{ $vendor->vendor_name }}"
                                            data-pic="{{ $vendor->pic_name ?? $vendor->vendor_pic ?? '' }}"
                                            data-phone="{{ $vendor->phone ?? $vendor->vendor_phone ?? '' }}"
                                            @selected(old('vendor_name') === $vendor->vendor_name)>
                                        {{ $vendor->vendor_name }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="hidden"
                                   name="vendor_name"
                                   id="vendor_name"
                                   value="{{ old('vendor_name') }}">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Estimated Cost
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="estimated_cost"
                                   value="{{ old('estimated_cost', 0) }}"
                                   class="w-full rounded-2xl border-slate-300">
                        </div>

                        <div class="xl:col-span-2">
                            <label class="inline-flex items-center gap-3">
                                <input type="checkbox"
                                       name="auto_generate_wo"
                                       value="1"
                                       @checked(old('auto_generate_wo'))
                                       class="rounded border-slate-300 text-[#0B1F3A]">
                                <span class="text-sm font-bold text-slate-700">
                                    Auto Generate Work Order saat due
                                </span>
                            </label>
                        </div>

                        <div class="xl:col-span-2">
                            <label class="mb-2 block text-sm font-black text-slate-700">
                                Notes
                            </label>

                            <textarea name="notes"
                                      rows="3"
                                      class="w-full rounded-2xl border-slate-300">{{ old('notes') }}</textarea>
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">
                        <a href="{{ route('assets.schedules.index') }}"
                           class="rounded-2xl bg-slate-200 px-6 py-3 text-sm font-black text-slate-700">
                            Batal
                        </a>

                        <button type="submit"
                                class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-black text-white hover:bg-[#123B6D]">
                            Simpan Schedule
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        function fillVendorSchedule(select) {
            const option = select.options[select.selectedIndex];

            document.getElementById('vendor_name').value = option.dataset.name || '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const vendorSelect = document.getElementById('vendor_select');

            if (vendorSelect && vendorSelect.value) {
                fillVendorSchedule(vendorSelect);
            }
        });
    </script>
</x-app-layout>