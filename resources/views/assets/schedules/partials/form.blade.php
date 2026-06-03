@php
    $isEdit = isset($schedule) && $schedule;
@endphp

<div class="grid grid-cols-1 gap-6 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-bold">Asset *</label>
        <select name="asset_id" required class="w-full rounded-2xl border-slate-300">
            <option value="">Pilih Asset</option>
            @foreach($assets as $asset)
                <option value="{{ $asset->id }}"
                    @selected(old('asset_id', $schedule->asset_id ?? $selectedAssetId ?? '') == $asset->id)>
                    {{ $asset->asset_code }} - {{ $asset->asset_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Schedule Name *</label>
        <input name="schedule_name" required
               value="{{ old('schedule_name', $schedule->schedule_name ?? '') }}"
               placeholder="Service AC 3 Bulanan / Service Truck 10.000 KM"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Maintenance Type *</label>
        <select name="maintenance_type" required class="w-full rounded-2xl border-slate-300">
            @foreach(['preventive','inspection','calibration','service'] as $type)
                <option value="{{ $type }}" @selected(old('maintenance_type', $schedule->maintenance_type ?? 'preventive') === $type)>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Frequency Type *</label>
        <select name="frequency_type" required class="w-full rounded-2xl border-slate-300">
            @foreach(['daily','weekly','monthly','yearly','km','hour_meter'] as $type)
                <option value="{{ $type }}" @selected(old('frequency_type', $schedule->frequency_type ?? 'monthly') === $type)>
                    {{ strtoupper(str_replace('_',' ', $type)) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Frequency Interval *</label>
        <input type="number" name="frequency_interval" min="1" required
               value="{{ old('frequency_interval', $schedule->frequency_interval ?? 1) }}"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Start Date</label>
        <input type="date" name="start_date"
               value="{{ old('start_date', $schedule?->start_date?->format('Y-m-d') ?? '') }}"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Next Execution Date</label>
        <input type="date" name="next_execution_date"
               value="{{ old('next_execution_date', $schedule?->next_execution_date?->format('Y-m-d') ?? '') }}"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Next Meter / KM</label>
        <input type="number" name="next_meter"
               value="{{ old('next_meter', $schedule->next_meter ?? '') }}"
               placeholder="Contoh: 10000"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Reminder Days Before</label>
        <input type="number" name="reminder_days_before" min="0"
               value="{{ old('reminder_days_before', $schedule->reminder_days_before ?? 7) }}"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Priority *</label>
        <select name="priority" required class="w-full rounded-2xl border-slate-300">
            @foreach(['low','medium','high','critical'] as $priority)
                <option value="{{ $priority }}" @selected(old('priority', $schedule->priority ?? 'medium') === $priority)>
                    {{ ucfirst($priority) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Assigned To</label>
        <input type="number" name="assigned_to"
               value="{{ old('assigned_to', $schedule->assigned_to ?? '') }}"
               placeholder="User ID teknisi sementara"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Vendor Name</label>
        <input name="vendor_name"
               value="{{ old('vendor_name', $schedule->vendor_name ?? '') }}"
               class="w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="mb-1 block text-sm font-bold">Estimated Cost</label>
        <input type="number" step="0.01" name="estimated_cost"
               value="{{ old('estimated_cost', $schedule->estimated_cost ?? 0) }}"
               class="w-full rounded-2xl border-slate-300">
    </div>

    @if($isEdit)
        <div>
            <label class="mb-1 block text-sm font-bold">Status</label>
            <select name="status" class="w-full rounded-2xl border-slate-300">
                @foreach(['active','inactive','completed'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $schedule->status) === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="auto_generate_wo" value="1"
                   @checked(old('auto_generate_wo', $schedule->auto_generate_wo ?? false))
                   class="rounded border-slate-300 text-[#0B1F3A]">
            <span class="text-sm font-bold text-slate-700">Auto Generate Work Order saat due</span>
        </label>
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-bold">Description</label>
        <textarea name="description" rows="3" class="w-full rounded-2xl border-slate-300">{{ old('description', $schedule->description ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-bold">Notes</label>
        <textarea name="notes" rows="3" class="w-full rounded-2xl border-slate-300">{{ old('notes', $schedule->notes ?? '') }}</textarea>
    </div>
</div>

<div class="flex justify-end gap-3 border-t pt-6">
    <a href="{{ route('assets.schedules.index') }}"
       class="rounded-2xl bg-slate-200 px-6 py-3 text-sm font-black text-slate-700">
        Batal
    </a>

    <button class="rounded-2xl bg-[#0B1F3A] px-6 py-3 text-sm font-black text-white">
        {{ $isEdit ? 'Update Schedule' : 'Simpan Schedule' }}
    </button>
</div>