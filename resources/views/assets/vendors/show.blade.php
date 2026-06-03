<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-black text-[#0B1F3A]">Detail Vendor Maintenance</h2>
            <p class="text-sm text-slate-500">{{ $vendor->vendor_code }}</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">
            <x-flash-message />

            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase">
                            {{ $vendor->vendor_code }}
                        </div>

                        <h1 class="mt-4 text-4xl font-black">{{ $vendor->vendor_name }}</h1>

                        <p class="mt-2 text-sm text-blue-100">
                            {{ $vendor->vendor_type ?? 'Vendor Maintenance' }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('assets.vendors.edit', $vendor) }}"
                           class="rounded-2xl bg-white px-6 py-3 text-sm font-black text-[#0B1F3A]">
                            Edit
                        </a>

                        <a href="{{ route('assets.vendors.index') }}"
                           class="rounded-2xl border border-white/20 bg-white/10 px-6 py-3 text-sm font-black text-white">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Vendor Type</div>
                    <div class="mt-2 text-xl font-black text-[#0B1F3A]">
                        {{ $vendor->vendor_type ?? '-' }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">PIC</div>
                    <div class="mt-2 text-xl font-black text-[#0B1F3A]">
                        {{ $vendor->pic_name ?? '-' }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Rating</div>
                    <div class="mt-2 text-xl font-black text-amber-700">
                        ⭐ {{ number_format($vendor->rating ?? 0, 2) }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-xs font-black uppercase text-slate-400">Status</div>
                    <div class="mt-3">
                        <span class="rounded-full px-4 py-2 text-xs font-black {{ $vendor->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $vendor->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
                <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b bg-slate-50 px-6 py-5">
                        <h3 class="text-xl font-black text-[#0B1F3A]">Contact Information</h3>
                    </div>

                    <div class="space-y-4 p-6">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Phone</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $vendor->phone ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Email</div>
                            <div class="mt-1 font-bold text-slate-800">{{ $vendor->email ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="text-xs font-black uppercase text-slate-400">Address</div>
                            <div class="mt-1 whitespace-pre-line text-sm text-slate-700">{{ $vendor->address ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden rounded-[32px] bg-white shadow-sm ring-1 ring-slate-200">
                    <div class="border-b bg-slate-50 px-6 py-5">
                        <h3 class="text-xl font-black text-[#0B1F3A]">Service Scope</h3>
                    </div>

                    <div class="p-6 whitespace-pre-line text-sm leading-7 text-slate-700">
                        {{ $vendor->service_scope ?? 'Belum ada service scope.' }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>