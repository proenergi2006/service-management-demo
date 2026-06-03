<x-app-layout>
 

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">

            <x-flash-message />

            {{-- HERO --}}
            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-6 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            Cost Monitoring
                        </div>

                        <h1 class="mt-4 text-4xl font-black">
                            Maintenance Cost Analysis
                        </h1>

                        <p class="mt-2 text-sm text-blue-100">
                            Monitoring biaya maintenance asset, sparepart, preventive, corrective, dan asset paling mahal.
                        </p>
                    </div>

                    <a href="{{ route('assets.dashboard') }}"
                       class="rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-black text-white">
                        Kembali Dashboard
                    </a>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-700">
                            Start Date
                        </label>
                        <input type="date"
                               name="date_from"
                               value="{{ $startDate ?? '' }}"
                               class="w-full rounded-2xl border-slate-300">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-bold text-slate-700">
                            End Date
                        </label>
                        <input type="date"
                               name="date_to"
                               value="{{ $endDate ?? '' }}"
                               class="w-full rounded-2xl border-slate-300">
                    </div>

                    <div class="flex items-end">
                        <button class="w-full rounded-2xl bg-[#0B1F3A] px-5 py-3 font-black text-white">
                            Filter
                        </button>
                    </div>

                    <div class="flex items-end">
                        <a href="{{ route('assets.reports.maintenance-cost') }}"
                           class="w-full rounded-2xl bg-slate-200 px-5 py-3 text-center font-black text-slate-700">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- KPI --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">

                <div class="rounded-[28px] border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
                    <div class="text-sm font-bold text-emerald-700">
                        Total Cost
                    </div>
                    <div class="mt-3 text-3xl font-black text-emerald-800">
                        Rp {{ number_format($summary['total_cost'] ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="mt-3 text-xs font-semibold text-emerald-500">
                        Total biaya maintenance periode ini
                    </div>
                </div>

                <div class="rounded-[28px] border border-blue-200 bg-blue-50 p-6 shadow-sm">
                    <div class="text-sm font-bold text-blue-700">
                        Total Work Order
                    </div>
                    <div class="mt-3 text-4xl font-black text-blue-800">
                        {{ $summary['total_wo'] ?? 0 }}
                    </div>
                    <div class="mt-3 text-xs font-semibold text-blue-500">
                        Jumlah WO pada periode ini
                    </div>
                </div>

                <div class="rounded-[28px] border border-amber-200 bg-amber-50 p-6 shadow-sm">
                    <div class="text-sm font-bold text-amber-700">
                        Completed WO
                    </div>
                    <div class="mt-3 text-4xl font-black text-amber-800">
                        {{ $summary['completed_wo'] ?? $summary['total_wo'] ?? 0 }}
                    </div>
                    <div class="mt-3 text-xs font-semibold text-amber-500">
                        WO selesai
                    </div>
                </div>

                <div class="rounded-[28px] border border-fuchsia-200 bg-fuchsia-50 p-6 shadow-sm">
                    <div class="text-sm font-bold text-fuchsia-700">
                        Average Cost / WO
                    </div>
                    <div class="mt-3 text-3xl font-black text-fuchsia-800">
                        Rp {{ number_format($summary['avg_cost'] ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="mt-3 text-xs font-semibold text-fuchsia-500">
                        Rata-rata biaya per WO
                    </div>
                </div>

            </div>

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b bg-slate-50 px-6 py-5">
                    <h3 class="text-xl font-black text-[#0B1F3A]">
                        Work Order Cost Detail
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">WO No</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">Asset</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">Technician</th>
                                <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-500">Cost</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">Updated</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($workOrders as $wo)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-5">
                                        <a href="{{ route('assets.work-orders.show', $wo) }}"
                                           class="font-black text-blue-700 hover:underline">
                                            {{ $wo->work_order_no }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="font-black text-slate-800">
                                            {{ $wo->asset->asset_code ?? '-' }}
                                        </div>
                                        <div class="mt-1 text-sm text-slate-500">
                                            {{ $wo->asset->asset_name ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 font-bold text-slate-700">
                                        {{ ucfirst(str_replace('_', ' ', $wo->maintenance_type ?? '-')) }}
                                    </td>

                                    <td class="px-6 py-5 font-bold text-slate-700">
                                        {{ $wo->technician->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5 text-right font-black text-emerald-700">
                                        Rp {{ number_format($wo->actual_cost ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-5 text-sm text-slate-500">
                                        {{ $wo->updated_at?->format('d/m/Y H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-14 text-center text-sm font-bold text-slate-400">
                                        Belum ada data maintenance cost.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-100 px-6 py-4">
                    {{ $workOrders->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>