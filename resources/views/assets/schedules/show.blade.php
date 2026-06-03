<x-app-layout>
  

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">
            <x-flash-message />

            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            {{ $schedule->schedule_no }}
                        </div>

                        <h1 class="mt-4 text-4xl font-black">
                            {{ $schedule->schedule_name }}
                        </h1>

                        <p class="mt-3 max-w-4xl text-sm leading-7 text-blue-100">
                            {{ $schedule->description ?? 'Preventive maintenance schedule untuk asset.' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('assets.schedules.index') }}"
                           class="rounded-2xl border border-white/20 bg-white/10 px-5 py-3 text-sm font-black text-white">
                            Kembali
                        </a>

                        <a href="{{ route('assets.schedules.edit', $schedule) }}"
                           class="rounded-2xl bg-white px-5 py-3 text-sm font-black text-[#0B1F3A]">
                            Edit
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Status</div>
                    <div class="mt-2 text-xl font-black text-[#0B1F3A]">
                        {{ ucfirst($schedule->status) }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Type</div>
                    <div class="mt-2 text-xl font-black text-[#0B1F3A]">
                        {{ ucfirst($schedule->maintenance_type) }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Frequency</div>
                    <div class="mt-2 text-xl font-black text-[#0B1F3A]">
                        {{ strtoupper(str_replace('_', ' ', $schedule->frequency_type)) }}
                        / {{ $schedule->frequency_interval }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Next Due</div>
                    <div class="mt-2 text-xl font-black text-[#0B1F3A]">
                        {{ $schedule->next_execution_date?->format('d/m/Y') ?? ($schedule->next_meter ? number_format($schedule->next_meter, 0, ',', '.') : '-') }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="space-y-6 xl:col-span-2">

                    <div class="rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <h3 class="text-xl font-black text-[#0B1F3A]">Informasi Schedule</h3>

                        <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                            @foreach([
                                'Asset' => ($schedule->asset->asset_code ?? '-') . ' - ' . ($schedule->asset->asset_name ?? '-'),
                                'Maintenance Type' => ucfirst($schedule->maintenance_type),
                                'Frequency Type' => strtoupper(str_replace('_', ' ', $schedule->frequency_type)),
                                'Frequency Interval' => $schedule->frequency_interval,
                                'Start Date' => $schedule->start_date?->format('d/m/Y') ?? '-',
                                'Last Execution Date' => $schedule->last_execution_date?->format('d/m/Y') ?? '-',
                                'Next Execution Date' => $schedule->next_execution_date?->format('d/m/Y') ?? '-',
                                'Last Meter' => $schedule->last_meter ? number_format($schedule->last_meter, 0, ',', '.') : '-',
                                'Next Meter' => $schedule->next_meter ? number_format($schedule->next_meter, 0, ',', '.') : '-',
                                'Reminder Days Before' => $schedule->reminder_days_before . ' hari',
                                'Priority' => ucfirst($schedule->priority),
                                'Assigned To' => $schedule->assignedUser->name ?? '-',
                                'Vendor' => $schedule->vendor_name ?? '-',
                                'Estimated Cost' => 'Rp ' . number_format($schedule->estimated_cost ?? 0, 0, ',', '.'),
                                'Auto Generate WO' => $schedule->auto_generate_wo ? 'Ya' : 'Tidak',
                                'Last Work Order' => $schedule->lastWorkOrder->work_order_no ?? '-',
                            ] as $label => $value)
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-xs font-black uppercase text-slate-400">{{ $label }}</div>
                                    <div class="mt-1 text-sm font-bold text-slate-800">{{ $value }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <h3 class="text-xl font-black text-[#0B1F3A]">Description & Notes</h3>

                        <div class="mt-5 space-y-4">
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">Description</div>
                                <div class="mt-2 whitespace-pre-line text-sm text-slate-700">
                                    {{ $schedule->description ?? '-' }}
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4">
                                <div class="text-xs font-black uppercase text-slate-400">Notes</div>
                                <div class="mt-2 whitespace-pre-line text-sm text-slate-700">
                                    {{ $schedule->notes ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="space-y-6">

                    <div class="rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <h3 class="text-xl font-black text-[#0B1F3A]">Action</h3>

                        <div class="mt-5 space-y-3">
                            <a href="{{ route('assets.schedules.edit', $schedule) }}"
                               class="block rounded-2xl bg-[#0B1F3A] px-5 py-3 text-center text-sm font-black text-white">
                                Edit Schedule
                            </a>

                            <form method="POST"
                            action="{{ route('assets.schedules.generate-work-order', $schedule) }}"
                            onsubmit="return confirm('Generate Work Order dari schedule ini?')">
                          @csrf
                      
                          <button type="submit"
                                  class="w-full rounded-2xl border border-emerald-300 bg-emerald-50 px-5 py-3 text-center text-sm font-black text-emerald-700 hover:bg-emerald-100">
                              Generate Work Order
                          </button>
                      </form>

                            <a href="{{ route('assets.show', $schedule->asset) }}"
                               class="block rounded-2xl border border-blue-300 bg-blue-50 px-5 py-3 text-center text-sm font-black text-blue-700">
                                Lihat Asset
                            </a>

                            <form method="POST"
                                  action="{{ route('assets.schedules.destroy', $schedule) }}"
                                  onsubmit="return confirm('Yakin ingin hapus schedule ini?')">
                                @csrf
                                @method('DELETE')

                                <button class="w-full rounded-2xl border border-red-300 bg-red-50 px-5 py-3 text-sm font-black text-red-700">
                                    Hapus Schedule
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="rounded-[32px] bg-blue-50 p-6 shadow-sm ring-1 ring-blue-100">
                        <h3 class="text-lg font-black text-blue-900">Asset Terkait</h3>

                        <div class="mt-4 rounded-2xl bg-white p-4">
                            <div class="text-xs font-black uppercase text-blue-400">Asset Code</div>
                            <div class="mt-1 font-black text-slate-800">
                                {{ $schedule->asset->asset_code ?? '-' }}
                            </div>

                            <div class="mt-3 text-xs font-black uppercase text-blue-400">Asset Name</div>
                            <div class="mt-1 font-bold text-slate-800">
                                {{ $schedule->asset->asset_name ?? '-' }}
                            </div>

                            <div class="mt-3 text-xs font-black uppercase text-blue-400">Location</div>
                            <div class="mt-1 font-bold text-slate-800">
                                {{ $schedule->asset->location->name ?? '-' }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>