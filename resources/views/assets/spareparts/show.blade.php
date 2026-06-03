<x-app-layout>


    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">

            <x-flash-message />

            {{-- HERO --}}
            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            {{ $sparepart->sparepart_code }}
                        </div>

                        <h1 class="mt-4 text-4xl font-black">
                            {{ $sparepart->sparepart_name }}
                        </h1>

                        <p class="mt-2 text-sm text-blue-100">
                            {{ $sparepart->category ?? 'Tanpa Kategori' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('assets.spareparts.edit', $sparepart) }}"
                           class="rounded-2xl bg-white px-6 py-3 text-sm font-black text-[#0B1F3A]">
                            Edit
                        </a>

                        <a href="{{ route('assets.spareparts.index') }}"
                           class="rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-black text-white">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-6">

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Unit</div>
                    <div class="mt-2 text-2xl font-black text-[#0B1F3A]">
                        {{ $sparepart->unit }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Current Stock</div>
                    <div class="mt-2 text-2xl font-black text-[#0B1F3A]">
                        {{ number_format($sparepart->current_stock ?? 0, 2, ',', '.') }}
                        {{ $sparepart->unit }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Minimum Stock</div>
                    <div class="mt-2 text-2xl font-black text-amber-700">
                        {{ number_format($sparepart->minimum_stock ?? 0, 2, ',', '.') }}
                        {{ $sparepart->unit }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Standard Price</div>
                    <div class="mt-2 text-2xl font-black text-emerald-700">
                        Rp {{ number_format($sparepart->standard_price ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Vendor</div>
                    <div class="mt-2 text-lg font-black text-[#0B1F3A]">
                        {{ $sparepart->vendor_name ?? '-' }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Status</div>
                    <div class="mt-3">
                        <span class="rounded-full px-4 py-2 text-xs font-black {{ $sparepart->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $sparepart->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>

            </div>

            {{-- LOW STOCK ALERT --}}
            @if(($sparepart->current_stock ?? 0) <= ($sparepart->minimum_stock ?? 0))
                <div class="rounded-[28px] border border-rose-200 bg-rose-50 px-6 py-5 text-rose-700">
                    <div class="font-black">
                        ⚠️ Stock sparepart berada di bawah atau sama dengan minimum stock.
                    </div>
                    <div class="mt-1 text-sm">
                        Segera lakukan pengadaan / stock in agar sparepart tersedia saat maintenance.
                    </div>
                </div>
            @endif

            {{-- STOCK MOVEMENT FORM --}}
            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b bg-slate-50 px-6 py-5">
                    <h3 class="text-xl font-black text-[#0B1F3A]">
                        Stock Movement
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Input stock in, stock out, atau adjustment.
                    </p>
                </div>

                <div class="p-6">
                    <form method="POST"
                          action="{{ route('assets.spareparts.movements.store', $sparepart) }}"
                          class="grid grid-cols-1 gap-4 md:grid-cols-5">
                        @csrf

                        <select name="movement_type"
                                required
                                class="rounded-2xl border-slate-300">
                            <option value="stock_in">Stock In</option>
                            <option value="stock_out">Stock Out</option>
                            <option value="adjustment">Adjustment</option>
                        </select>

                        <input type="number"
                               step="0.01"
                               min="0"
                               name="qty"
                               required
                               placeholder="Qty"
                               class="rounded-2xl border-slate-300">

                        <input type="date"
                               name="movement_date"
                               value="{{ now()->format('Y-m-d') }}"
                               required
                               class="rounded-2xl border-slate-300">

                        <input type="text"
                               name="notes"
                               placeholder="Catatan"
                               class="rounded-2xl border-slate-300">

                        <button class="rounded-2xl bg-[#0B1F3A] px-5 py-3 font-black text-white hover:bg-[#123B6D]">
                            Simpan Stock
                        </button>
                    </form>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

                {{-- DESCRIPTION --}}
                <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b bg-slate-50 px-6 py-5">
                        <h3 class="text-xl font-black text-[#0B1F3A]">
                            Description
                        </h3>
                    </div>

                    <div class="p-6 text-sm leading-7 text-slate-600">
                        {{ $sparepart->description ?? 'Tidak ada deskripsi.' }}
                    </div>
                </div>

                {{-- STOCK HISTORY --}}
                <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b bg-slate-50 px-6 py-5">
                        <h3 class="text-xl font-black text-[#0B1F3A]">
                            Stock History
                        </h3>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($sparepart->movements as $movement)
                            <div class="p-5">
                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <div class="text-xs font-black uppercase text-blue-700">
                                            {{ strtoupper(str_replace('_', ' ', $movement->movement_type)) }}
                                        </div>

                                        <div class="mt-1 font-bold text-slate-800">
                                            Qty:
                                            {{ number_format($movement->qty, 2, ',', '.') }}
                                            {{ $sparepart->unit }}
                                        </div>

                                        <div class="mt-1 text-sm text-slate-500">
                                            Stock:
                                            {{ number_format($movement->stock_before, 2, ',', '.') }}
                                            →
                                            {{ number_format($movement->stock_after, 2, ',', '.') }}
                                        </div>

                                        @if($movement->notes)
                                            <div class="mt-1 text-sm text-slate-500">
                                                {{ $movement->notes }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-right text-sm text-slate-500">
                                        <div class="font-black text-slate-700">
                                            {{ $movement->movement_date?->format('d/m/Y') }}
                                        </div>
                                        <div>
                                            {{ $movement->creator->name ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-sm font-bold text-slate-400">
                                Belum ada stock movement.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- USAGE HISTORY --}}
            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b bg-slate-50 px-6 py-5">
                    <h3 class="text-xl font-black text-[#0B1F3A]">
                        Usage History
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Riwayat penggunaan sparepart pada Work Order.
                    </p>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse($sparepart->workOrderSpareparts as $usage)
                        <a href="{{ route('assets.work-orders.show', $usage->workOrder) }}"
                           class="block p-5 hover:bg-slate-50">
                            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                                <div>
                                    <div class="text-xs font-black uppercase text-blue-700">
                                        {{ $usage->workOrder->work_order_no ?? '-' }}
                                    </div>

                                    <div class="mt-1 font-black text-slate-800">
                                        {{ $usage->workOrder->asset->asset_code ?? '-' }}
                                        -
                                        {{ $usage->workOrder->asset->asset_name ?? '-' }}
                                    </div>

                                    <div class="mt-1 text-sm text-slate-500">
                                        Qty:
                                        {{ number_format($usage->qty, 2, ',', '.') }}
                                        {{ $usage->unit }}
                                        · Harga:
                                        Rp {{ number_format($usage->unit_price, 0, ',', '.') }}
                                    </div>

                                    @if($usage->notes)
                                        <div class="mt-1 text-sm text-slate-500">
                                            {{ $usage->notes }}
                                        </div>
                                    @endif
                                </div>

                                <div class="text-right text-sm font-black text-emerald-700">
                                    Rp {{ number_format($usage->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-10 text-center text-sm font-bold text-slate-400">
                            Belum ada penggunaan sparepart.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>