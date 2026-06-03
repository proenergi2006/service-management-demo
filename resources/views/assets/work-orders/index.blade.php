<x-app-layout>
   

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">
            <x-flash-message />

            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            Plant Maintenance Lite
                        </div>
                        <h1 class="mt-4 text-4xl font-black">Work Order Maintenance</h1>
                        <p class="mt-2 text-sm text-blue-100">Request, approval, schedule, execution, dan closing maintenance asset.</p>
                    </div>

                    <a href="{{ route('assets.work-orders.create') }}"
                       class="rounded-2xl bg-white px-6 py-3 text-sm font-black text-[#0B1F3A]">
                        + Buat Work Order
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-sm font-bold text-slate-400">Total WO</div>
                    <div class="mt-2 text-4xl font-black text-[#0B1F3A]">{{ $summary['total'] }}</div>
                </div>

                <div class="rounded-3xl bg-blue-50 p-5 shadow-sm ring-1 ring-blue-100">
                    <div class="text-sm font-bold text-blue-600">Submitted</div>
                    <div class="mt-2 text-4xl font-black text-blue-700">{{ $summary['submitted'] }}</div>
                </div>

                <div class="rounded-3xl bg-amber-50 p-5 shadow-sm ring-1 ring-amber-100">
                    <div class="text-sm font-bold text-amber-600">In Progress</div>
                    <div class="mt-2 text-4xl font-black text-amber-700">{{ $summary['in_progress'] }}</div>
                </div>

                <div class="rounded-3xl bg-emerald-50 p-5 shadow-sm ring-1 ring-emerald-100">
                    <div class="text-sm font-bold text-emerald-600">Completed</div>
                    <div class="mt-2 text-4xl font-black text-emerald-700">{{ $summary['completed'] }}</div>
                </div>
            </div>

            <div class="rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari WO / asset..."
                           class="rounded-2xl border-slate-300 md:col-span-2">

                    <select name="status" class="rounded-2xl border-slate-300">
                        <option value="">Semua Status</option>
                        @foreach(['draft','submitted','approved','scheduled','in_progress','completed','rejected','cancelled'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>
                                {{ ucfirst(str_replace('_',' ', $s)) }}
                            </option>
                        @endforeach
                    </select>

                    <select name="maintenance_type" class="rounded-2xl border-slate-300">
                        <option value="">Semua Type</option>
                        @foreach(['preventive','corrective','inspection','calibration','breakdown'] as $t)
                            <option value="{{ $t }}" @selected(request('maintenance_type') === $t)>
                                {{ ucfirst($t) }}
                            </option>
                        @endforeach
                    </select>

                    <button class="rounded-2xl bg-[#0B1F3A] px-5 py-3 font-black text-white">
                        Filter
                    </button>
                </form>
            </div>

            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b bg-slate-50 px-6 py-5">
                    <h3 class="text-xl font-black text-[#0B1F3A]">Daftar Work Order</h3>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($workOrders as $wo)
                        <a href="{{ route('assets.work-orders.show', $wo) }}"
                           class="block p-6 transition hover:bg-slate-50">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <div class="text-xs font-black uppercase text-blue-700">{{ $wo->work_order_no }}</div>
                                    <h3 class="mt-1 text-lg font-black text-slate-800">
                                        {{ $wo->asset->asset_code ?? '-' }} - {{ $wo->asset->asset_name ?? '-' }}
                                    </h3>
                                    <p class="mt-1 line-clamp-2 text-sm text-slate-500">
                                        {{ $wo->problem_description }}
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-black text-slate-700">
                                        {{ ucfirst($wo->maintenance_type) }}
                                    </span>
                                    <span class="rounded-full bg-blue-100 px-4 py-2 text-xs font-black text-blue-700">
                                        {{ ucfirst(str_replace('_',' ', $wo->status)) }}
                                    </span>
                                    <span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-black text-amber-700">
                                        {{ ucfirst($wo->priority) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-10 text-center text-sm font-bold text-slate-400">
                            Belum ada Work Order.
                        </div>
                    @endforelse
                </div>

                <div class="border-t px-6 py-4">
                    {{ $workOrders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>