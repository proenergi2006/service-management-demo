<x-app-layout>
   

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">
            <x-flash-message />

            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            Vendor Master Data
                        </div>

                        <h1 class="mt-4 text-4xl font-black">Maintenance Vendor</h1>

                        <p class="mt-2 text-sm text-blue-100">
                            Kelola vendor maintenance untuk AC, truck, IT, genset, forklift, kalibrasi, dan facility.
                        </p>
                    </div>

                    <a href="{{ route('assets.vendors.create') }}"
                       class="rounded-2xl bg-white px-6 py-3 text-sm font-black text-[#0B1F3A]">
                        + Tambah Vendor
                    </a>
                </div>
            </div>

            <div class="rounded-[32px] bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari kode, nama, PIC..."
                           class="rounded-2xl border-slate-300 md:col-span-2">

                    <select name="vendor_type" class="rounded-2xl border-slate-300">
                        <option value="">Semua Type</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" @selected(request('vendor_type') === $type)>
                                {{ $type }}
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
                    <h3 class="text-xl font-black text-[#0B1F3A]">Daftar Vendor</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Vendor</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">PIC</th>
                                <th class="px-6 py-4 text-left text-xs font-black uppercase text-slate-500">Kontak</th>
                                <th class="px-6 py-4 text-center text-xs font-black uppercase text-slate-500">Rating</th>
                                <th class="px-6 py-4 text-center text-xs font-black uppercase text-slate-500">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-black uppercase text-slate-500">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($vendors as $vendor)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-sm font-black text-blue-700">
                                        {{ $vendor->vendor_code }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-black text-slate-800">{{ $vendor->vendor_name }}</div>
                                        @if($vendor->service_scope)
                                            <div class="mt-1 line-clamp-1 text-xs text-slate-500">
                                                {{ $vendor->service_scope }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $vendor->vendor_type ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $vendor->pic_name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <div>{{ $vendor->phone ?? '-' }}</div>
                                        <div class="text-xs text-slate-400">{{ $vendor->email ?? '-' }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-black text-amber-700">
                                            ⭐ {{ number_format($vendor->rating ?? 0, 2) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span class="rounded-full px-3 py-1 text-xs font-black {{ $vendor->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $vendor->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('assets.vendors.show', $vendor) }}"
                                               class="rounded-xl bg-blue-50 px-3 py-2 text-xs font-black text-blue-700 hover:bg-blue-100">
                                                Detail
                                            </a>

                                            <a href="{{ route('assets.vendors.edit', $vendor) }}"
                                               class="rounded-xl bg-amber-50 px-3 py-2 text-xs font-black text-amber-700 hover:bg-amber-100">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-sm font-bold text-slate-400">
                                        Belum ada vendor maintenance.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t px-6 py-4">
                    {{ $vendors->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>