<x-app-layout>
    

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">

            <x-flash-message />

            {{-- HERO --}}
            <div class="overflow-hidden rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] shadow-2xl">
                <div class="px-8 py-8 text-white">

                    <div class="flex flex-col gap-8 xl:flex-row xl:items-center xl:justify-between">

                        <div class="max-w-4xl">
                            <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase tracking-wider text-white ring-1 ring-white/20 backdrop-blur">
                                {{ $workOrder->work_order_no }}
                            </div>

                            <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl">
                                {{ ucfirst(str_replace('_', ' ', $workOrder->maintenance_type)) }}
                            </h1>

                            <p class="mt-4 max-w-3xl text-sm leading-7 text-blue-100 sm:text-base">
                                {{ $workOrder->asset->asset_code ?? '-' }}
                                -
                                {{ $workOrder->asset->asset_name ?? '-' }}
                            </p>

                            <div class="mt-6 flex flex-wrap gap-3">

                                <span class="rounded-full bg-white/15 px-4 py-2 text-xs font-black text-white">
                                    Status:
                                    {{ ucfirst(str_replace('_', ' ', $workOrder->status)) }}
                                </span>

                                <span class="rounded-full bg-amber-500/20 px-4 py-2 text-xs font-black text-amber-100">
                                    Priority:
                                    {{ ucfirst($workOrder->priority ?? '-') }}
                                </span>

                                <span class="rounded-full bg-emerald-500/20 px-4 py-2 text-xs font-black text-emerald-100">
                                    Cost:
                                    Rp {{ number_format($workOrder->actual_cost ?? 0, 0, ',', '.') }}
                                </span>

                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">

                            <a href="{{ route('assets.work-orders.export-pdf', $workOrder) }}"
   target="_blank"
   class="inline-flex items-center justify-center rounded-2xl bg-rose-600 px-6 py-3 text-sm font-black text-white shadow-lg hover:bg-rose-700">
    Export PDF
</a>

                            <a
                                href="{{ route('assets.work-orders.index') }}"
                                class="inline-flex items-center justify-center rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-black text-white backdrop-blur transition hover:bg-white/20">

                                Kembali

                            </a>

                            @if($workOrder->status === 'draft')

                                <a
                                    href="{{ route('assets.work-orders.edit', $workOrder) }}"
                                    class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3 text-sm font-black text-[#0B1F3A] shadow-lg transition hover:bg-blue-50">

                                    Edit WO

                                </a>

                            @endif

                        </div>

                    </div>
                </div>
            </div>

            {{-- STATUS FLOW --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-5">

                @foreach(['draft','submitted','approved','in_progress','completed'] as $status)

                    <div class="rounded-[28px] border p-5 shadow-sm
                        {{ $workOrder->status === $status
                            ? 'border-[#0B1F3A] bg-[#0B1F3A] text-white'
                            : 'border-slate-200 bg-white text-slate-600'
                        }}">

                        <div class="text-xs font-black uppercase tracking-widest">
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </div>

                    </div>

                @endforeach

            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                {{-- LEFT --}}
                <div class="space-y-6 xl:col-span-2">

                    {{-- WORK ORDER INFO --}}
                    <div class="rounded-[32px] border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">

                            <h3 class="text-xl font-black text-[#0B1F3A]">
                                Informasi Work Order
                            </h3>

                        </div>

                        <div class="grid grid-cols-1 gap-4 p-6 md:grid-cols-2">

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Asset
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ $workOrder->asset->asset_code ?? '-' }}
                                    -
                                    {{ $workOrder->asset->asset_name ?? '-' }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Maintenance Type
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ ucfirst(str_replace('_', ' ', $workOrder->maintenance_type)) }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Requester
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ $workOrder->requester->name ?? '-' }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Technician
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ $workOrder->technician->name ?? '-' }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Approver
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ $workOrder->approver->name ?? '-' }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Vendor
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ $workOrder->vendor_name ?? '-' }}
                                </div>
                            </div>

                        </div>

                        <div class="px-6 pb-6">

                            <div class="rounded-2xl bg-slate-50 p-5">

                                <div class="text-xs font-black uppercase text-slate-400">
                                    Problem Description
                                </div>

                                <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-700">
                                    {{ $workOrder->problem_description ?? '-' }}
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- DOWNTIME --}}
                    <div class="rounded-[32px] border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">

                            <h3 class="text-xl font-black text-[#0B1F3A]">
                                Downtime Tracking
                            </h3>

                        </div>

                        <div class="grid grid-cols-1 gap-4 p-6 md:grid-cols-3">

                            <div class="rounded-2xl bg-rose-50 p-4">

                                <div class="text-xs font-black uppercase text-rose-400">
                                    Breakdown Time
                                </div>

                                <div class="mt-2 font-bold text-rose-800">
                                    {{ $workOrder->breakdown_at?->format('d/m/Y H:i') ?? '-' }}
                                </div>

                            </div>

                            <div class="rounded-2xl bg-blue-50 p-4">

                                <div class="text-xs font-black uppercase text-blue-400">
                                    Repair Started
                                </div>

                                <div class="mt-2 font-bold text-blue-800">
                                    {{ $workOrder->repair_started_at?->format('d/m/Y H:i') ?? '-' }}
                                </div>

                            </div>

                            <div class="rounded-2xl bg-emerald-50 p-4">

                                <div class="text-xs font-black uppercase text-emerald-400">
                                    Repair Finished
                                </div>

                                <div class="mt-2 font-bold text-emerald-800">
                                    {{ $workOrder->repair_finished_at?->format('d/m/Y H:i') ?? '-' }}
                                </div>

                            </div>

                        </div>

                        <div class="grid grid-cols-1 gap-4 px-6 pb-6 md:grid-cols-2">

                            <div class="rounded-2xl bg-slate-50 p-5">

                                <div class="text-xs font-black uppercase text-slate-400">
                                    Repair Duration
                                </div>

                                <div class="mt-2 text-2xl font-black text-blue-700">
                                    {{ number_format($workOrder->repair_duration_minutes ?? 0, 0, ',', '.') }}
                                    menit
                                </div>

                            </div>

                            <div class="rounded-2xl bg-slate-50 p-5">

                                <div class="text-xs font-black uppercase text-slate-400">
                                    Total Downtime
                                </div>

                                <div class="mt-2 text-2xl font-black text-rose-700">
                                    {{ number_format($workOrder->downtime_minutes ?? 0, 0, ',', '.') }}
                                    menit
                                </div>

                            </div>

                        </div>

                        @if($workOrder->downtime_notes)

                            <div class="px-6 pb-6">

                                <div class="rounded-2xl bg-slate-50 p-5">

                                    <div class="text-xs font-black uppercase text-slate-400">
                                        Downtime Notes
                                    </div>

                                    <div class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-700">
                                        {{ $workOrder->downtime_notes }}
                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>
{{-- CHECKLIST --}}
<div class="rounded-[32px] border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
        <h3 class="text-xl font-black text-[#0B1F3A]">
            Checklist Execution
        </h3>

        <p class="mt-1 text-sm text-slate-500">
            Checklist pekerjaan teknisi pada Work Order ini.
        </p>
    </div>

    {{-- ATTACH TEMPLATE --}}
    @if(($workOrder->checklistItems ?? collect())->count() === 0)
        <div class="border-b border-slate-100 bg-white p-6">
            <form method="POST"
                  action="{{ route('assets.work-orders.checklist.attach-template', $workOrder) }}"
                  class="grid grid-cols-1 gap-4 md:grid-cols-4">

                @csrf

                <div class="md:col-span-3">
                    <label class="mb-1 block text-sm font-bold text-slate-700">
                        Pilih Checklist Template
                    </label>

                    <select name="template_id"
                            required
                            class="w-full rounded-2xl border-slate-300">
                        <option value="">Pilih Checklist Template</option>

                        @foreach($templates ?? [] as $template)
                            <option value="{{ $template->id }}">
                                {{ $template->template_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button class="w-full rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-black text-white hover:bg-[#123B6D]">
                        Attach Checklist
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- CHECKLIST ITEMS --}}
    <div class="space-y-3 p-6">

        @forelse($workOrder->checklistItems ?? [] as $item)

            <form method="POST"
                  action="{{ route('assets.work-orders.checklist-items.update', $item) }}"
                  class="rounded-2xl border border-slate-100 bg-slate-50 p-5">

                @csrf
                @method('PUT')

                <div class="flex items-start justify-between gap-4">

                    <div class="flex items-start gap-4">

                        <input type="hidden" name="is_done" value="0">

                        <input type="checkbox"
                               name="is_done"
                               value="1"
                               onchange="this.form.submit()"
                               {{ $item->is_done ? 'checked' : '' }}
                               class="mt-1 h-6 w-6 rounded border-slate-300 text-emerald-600">

                        <div>
                            <div class="font-black text-slate-800">
                                {{ $item->item_name ?? '-' }}
                            </div>

                            @if($item->item_description)
                                <div class="mt-1 text-sm text-slate-500">
                                    {{ $item->item_description }}
                                </div>
                            @endif

                            @if($item->result_notes)
                                <div class="mt-2 rounded-xl bg-white px-4 py-2 text-xs text-slate-500">
                                    {{ $item->result_notes }}
                                </div>
                            @endif
                        </div>

                    </div>

                    <div>
                        @if($item->is_done)
                            <span class="rounded-full bg-emerald-100 px-4 py-2 text-xs font-black text-emerald-700">
                                DONE
                            </span>
                        @else
                            <span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-black text-amber-700">
                                PENDING
                            </span>
                        @endif
                    </div>

                </div>

            </form>

        @empty

            <div class="rounded-2xl bg-slate-50 px-5 py-10 text-center text-sm text-slate-500">
                Belum ada checklist. Silakan pilih template checklist terlebih dahulu.
            </div>

        @endforelse

    </div>
</div>

{{-- SPAREPART USAGE --}}
<div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="text-xl font-black text-[#0B1F3A]">
                    Sparepart Usage
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Tambahkan sparepart yang digunakan pada Work Order ini.
                </p>
            </div>

            <div class="rounded-full bg-emerald-100 px-4 py-2 text-xs font-black text-emerald-700">
                Total:
                Rp {{ number_format(($workOrder->spareparts ?? collect())->sum('total_price'), 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="border-b border-slate-100 bg-white p-6">
        <form method="POST"
              action="{{ route('assets.work-orders.spareparts.store', $workOrder) }}"
              class="grid grid-cols-1 gap-4 xl:grid-cols-12">

            @csrf

            <div class="xl:col-span-3">
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Master Sparepart
                </label>

                <select name="sparepart_id"
                        class="w-full rounded-2xl border-slate-300"
                        onchange="fillSparepart(this)">
                    <option value="">Pilih Sparepart</option>

                    @foreach($spareparts ?? [] as $sp)
                        <option value="{{ $sp->id }}"
                                data-name="{{ $sp->sparepart_name }}"
                                data-unit="{{ $sp->unit }}"
                                data-price="{{ $sp->standard_price }}"
                                data-stock="{{ $sp->current_stock ?? 0 }}">
                            {{ $sp->sparepart_code }} - {{ $sp->sparepart_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="xl:col-span-3">
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Nama Sparepart
                </label>

                <input type="text"
                       name="sparepart_name"
                       id="sparepart_name"
                       placeholder="Nama sparepart"
                       required
                       class="w-full rounded-2xl border-slate-300">
            </div>

            <div class="xl:col-span-1">
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Qty
                </label>

                <input type="number"
                       step="0.01"
                       min="0.01"
                       name="qty"
                       id="qty"
                       value="1"
                       required
                       oninput="calculateSparepartTotal()"
                       class="w-full rounded-2xl border-slate-300">
            </div>

            <div class="xl:col-span-2">
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Unit Price
                </label>

                <input type="number"
                       step="0.01"
                       min="0"
                       name="unit_price"
                       id="unit_price"
                       value="0"
                       required
                       oninput="calculateSparepartTotal()"
                       class="w-full rounded-2xl border-slate-300">
            </div>

            <div class="xl:col-span-2">
                <label class="mb-1 block text-sm font-bold text-slate-700">
                    Est. Total
                </label>

                <input type="text"
                       id="total_preview"
                       readonly
                       value="Rp 0"
                       class="w-full rounded-2xl border-slate-300 bg-slate-100 font-black text-slate-700">
            </div>

            <input type="hidden" name="unit" id="unit" value="pcs">

            <div class="xl:col-span-1 flex items-end">
                <button class="w-full rounded-2xl bg-[#0B1F3A] px-5 py-3 text-sm font-black text-white hover:bg-[#123B6D]">
                    +
                </button>
            </div>

            <div class="xl:col-span-12">
                <div id="stock_info"
                     class="hidden rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm font-bold text-blue-700">
                </div>
            </div>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">
                        Sparepart
                    </th>
                    <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-500">
                        Qty
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">
                        Unit
                    </th>
                    <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-500">
                        Unit Price
                    </th>
                    <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-500">
                        Total
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($workOrder->spareparts ?? [] as $sparepart)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-5">
                            <div class="font-black text-slate-800">
                                {{ $sparepart->sparepart_name }}
                            </div>

                            @if($sparepart->notes)
                                <div class="mt-1 text-xs text-slate-500">
                                    {{ $sparepart->notes }}
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-5 text-right font-bold text-slate-700">
                            {{ number_format($sparepart->qty, 2, ',', '.') }}
                        </td>

                        <td class="px-6 py-5 font-bold text-slate-600">
                            {{ $sparepart->unit }}
                        </td>

                        <td class="px-6 py-5 text-right font-bold text-slate-700">
                            Rp {{ number_format($sparepart->unit_price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-5 text-right font-black text-emerald-700">
                            Rp {{ number_format($sparepart->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-14 text-center">
                            <div class="text-sm font-bold text-slate-400">
                                Belum ada sparepart digunakan.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

            @if(($workOrder->spareparts ?? collect())->count())
                <tfoot class="bg-slate-50">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right text-sm font-black text-slate-700">
                            Total Sparepart Cost
                        </td>
                        <td class="px-6 py-4 text-right text-lg font-black text-emerald-700">
                            Rp {{ number_format($workOrder->spareparts->sum('total_price'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>

<script>
    function fillSparepart(select) {
        const option = select.options[select.selectedIndex];

        document.getElementById('sparepart_name').value = option.dataset.name || '';
        document.getElementById('unit_price').value = option.dataset.price || 0;
        document.getElementById('unit').value = option.dataset.unit || 'pcs';

        const stockInfo = document.getElementById('stock_info');

        if (option.value) {
            stockInfo.classList.remove('hidden');
            stockInfo.innerText = `Stock tersedia: ${option.dataset.stock || 0} ${option.dataset.unit || 'pcs'}`;
        } else {
            stockInfo.classList.add('hidden');
            stockInfo.innerText = '';
        }

        calculateSparepartTotal();
    }

    function calculateSparepartTotal() {
        const qty = parseFloat(document.getElementById('qty')?.value || 0);
        const price = parseFloat(document.getElementById('unit_price')?.value || 0);
        const total = qty * price;

        document.getElementById('total_preview').value =
            new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(total);
    }
</script>
                </div>

                {{-- RIGHT --}}
                <div class="space-y-6">

                    {{-- ACTION --}}
                    <div class="rounded-[32px] border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">

                            <h3 class="text-xl font-black text-[#0B1F3A]">
                                Action
                            </h3>

                        </div>

                        <div class="space-y-3 p-6">

                            @if($workOrder->status === 'draft')

                                <form method="POST"
                                      action="{{ route('assets.work-orders.submit', $workOrder) }}">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        class="w-full rounded-2xl bg-blue-600 px-5 py-3 text-sm font-black text-white hover:bg-blue-700">

                                        Submit Work Order

                                    </button>

                                </form>

                            @endif

                            @if($workOrder->status === 'submitted')

                                <form method="POST"
                                      action="{{ route('assets.work-orders.approve', $workOrder) }}">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        class="w-full rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">

                                        Approve WO

                                    </button>

                                </form>

                                <form method="POST"
                                      action="{{ route('assets.work-orders.reject', $workOrder) }}">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        class="w-full rounded-2xl bg-rose-600 px-5 py-3 text-sm font-black text-white hover:bg-rose-700">

                                        Reject WO

                                    </button>

                                </form>

                            @endif

                            @if($workOrder->status === 'approved')

                                <form method="POST"
                                      action="{{ route('assets.work-orders.start', $workOrder) }}">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        class="w-full rounded-2xl bg-amber-500 px-5 py-3 text-sm font-black text-white hover:bg-amber-600">

                                        Start Work

                                    </button>

                                </form>

                            @endif

                            @if($workOrder->status === 'in_progress')

    <form method="POST"
          action="{{ route('assets.work-orders.complete', $workOrder) }}"
          class="space-y-4">

        @csrf
        @method('PATCH')

        <div>
            <label class="mb-1 block text-sm font-bold text-slate-700">
                Breakdown Time
            </label>
            <input type="datetime-local"
                   name="breakdown_at"
                   value="{{ old('breakdown_at', $workOrder->breakdown_at?->format('Y-m-d\TH:i')) }}"
                   class="w-full rounded-2xl border-slate-300">
        </div>

        <div>
            <label class="mb-1 block text-sm font-bold text-slate-700">
                Repair Started
            </label>
            <input type="datetime-local"
                   name="repair_started_at"
                   value="{{ old('repair_started_at', $workOrder->repair_started_at?->format('Y-m-d\TH:i')) }}"
                   class="w-full rounded-2xl border-slate-300">
        </div>

        <div>
            <label class="mb-1 block text-sm font-bold text-slate-700">
                Repair Finished
            </label>
            <input type="datetime-local"
                   name="repair_finished_at"
                   value="{{ old('repair_finished_at', now()->format('Y-m-d\TH:i')) }}"
                   class="w-full rounded-2xl border-slate-300">
        </div>

        <div>
            <label class="mb-1 block text-sm font-bold text-slate-700">
                Resolution Notes
            </label>
            <textarea name="resolution_notes"
                      rows="3"
                      class="w-full rounded-2xl border-slate-300"
                      placeholder="Catatan penyelesaian WO...">{{ old('resolution_notes', $workOrder->resolution_notes) }}</textarea>
        </div>

        <div>
            <label class="mb-1 block text-sm font-bold text-slate-700">
                Downtime Notes
            </label>
            <textarea name="downtime_notes"
                      rows="3"
                      class="w-full rounded-2xl border-slate-300"
                      placeholder="Catatan downtime...">{{ old('downtime_notes', $workOrder->downtime_notes) }}</textarea>
        </div>

        <button class="w-full rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-black text-white hover:bg-emerald-700">
            Complete Work Order
        </button>

    </form>

@endif

                        </div>

                    </div>

                    {{-- ASSET INFO --}}
                    <div class="rounded-[32px] border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">

                            <h3 class="text-xl font-black text-[#0B1F3A]">
                                Asset Information
                            </h3>

                        </div>

                        <div class="space-y-4 p-6">

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Asset Code
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ $workOrder->asset->asset_code ?? '-' }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Asset Name
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ $workOrder->asset->asset_name ?? '-' }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Lifecycle Status
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ ucfirst($workOrder->asset->lifecycle_status ?? '-') }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">
                                    Condition
                                </div>

                                <div class="mt-2 font-bold text-slate-800">
                                    {{ ucfirst($workOrder->asset->condition_status ?? '-') }}
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>