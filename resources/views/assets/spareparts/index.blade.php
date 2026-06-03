<x-app-layout>
   

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">
            <x-flash-message />

            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            Sparepart Master Data
                        </div>

                        <h1 class="mt-4 text-4xl font-black">Maintenance Sparepart</h1>

                        <p class="mt-2 text-sm text-blue-100">
                            Database sparepart untuk AC, truck, IT device, genset, forklift, dan asset operasional.
                        </p>
                    </div>

                    <a href="{{ route('assets.spareparts.create') }}"
                       class="rounded-2xl bg-white px-6 py-3 text-sm font-black text-[#0B1F3A]">
                        + Tambah Sparepart
                    </a>
                </div>
            </div>

            <div class="rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-5">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari kode, nama, vendor..."
                           class="rounded-2xl border-slate-300 md:col-span-2">

                    <select name="category" class="rounded-2xl border-slate-300">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>

                    <select name="stock_status" class="rounded-2xl border-slate-300">
                        <option value="">Semua Stock</option>
                        <option value="low_stock" @selected(request('stock_status') === 'low_stock')>
                            Low Stock
                        </option>
                        <option value="safe_stock" @selected(request('stock_status') === 'safe_stock')>
                            Safe Stock
                        </option>
                    </select>

                    <button class="rounded-2xl bg-[#0B1F3A] px-5 py-3 font-black text-white">
                        Filter
                    </button>
                </form>
            </div>

            <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b bg-slate-50 px-6 py-5">
                    <h3 class="text-xl font-black text-[#0B1F3A]">Daftar Sparepart</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Sparepart</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Unit</th>
                                <th class="px-6 py-4 text-right text-xs font-black uppercase text-slate-500">Stock</th>
                                <th class="px-6 py-4 text-right text-xs font-black uppercase text-slate-500">Harga</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Vendor</th>
                                <th class="px-6 py-4 text-center text-xs font-black uppercase text-slate-500">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-black uppercase text-slate-500">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($spareparts as $sparepart)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm font-black text-blue-700">
                                        {{ $sparepart->sparepart_code }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-black text-slate-800">{{ $sparepart->sparepart_name }}</div>
                                        @if($sparepart->description)
                                            <div class="mt-1 line-clamp-1 text-xs text-slate-500">
                                                {{ $sparepart->description }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $sparepart->category ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-bold text-slate-700">
                                        {{ $sparepart->unit }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-black {{ ($sparepart->current_stock ?? 0) <= ($sparepart->minimum_stock ?? 0) ? 'text-rose-700' : 'text-[#0B1F3A]' }}">
                                        {{ number_format($sparepart->current_stock ?? 0, 2, ',', '.') }}
                                        <span class="text-xs text-slate-400">{{ $sparepart->unit }}</span>
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm font-black text-emerald-700">
                                        Rp {{ number_format($sparepart->standard_price ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $sparepart->vendor_name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <span class="rounded-full px-3 py-1 text-xs font-black {{ $sparepart->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                                {{ $sparepart->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                    
                                            @if(($sparepart->current_stock ?? 0) <= ($sparepart->minimum_stock ?? 0))
                                                <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-black text-rose-700">
                                                    Low Stock
                                                </span>
                                            @else
                                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-black text-blue-700">
                                                    Safe Stock
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('assets.spareparts.show', $sparepart) }}"
                                               class="rounded-xl bg-blue-50 px-3 py-2 text-xs font-black text-blue-700 hover:bg-blue-100">
                                                Detail
                                            </a>

                                            <a href="{{ route('assets.spareparts.edit', $sparepart) }}"
                                               class="rounded-xl bg-amber-50 px-3 py-2 text-xs font-black text-amber-700 hover:bg-amber-100">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center text-sm font-bold text-slate-400">
                                        Belum ada master sparepart.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t px-6 py-4">
                    {{ $spareparts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>