<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold text-gray-800">
                Asset Audit (Stock Opname)
            </h2>
            <p class="text-sm text-gray-500">
                Kelola sesi audit dan monitoring hasil pengecekan asset.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="overflow-hidden rounded-[28px] border border-emerald-200 bg-emerald-600 shadow-xl">
                <div class="px-6 py-7 text-white sm:px-8">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="max-w-3xl">
                            <div class="inline-flex rounded-full bg-white/15 px-3 py-1 text-xs font-semibold backdrop-blur">
                                Asset Audit Dashboard
                            </div>

                            <h1 class="mt-4 text-3xl font-bold tracking-tight sm:text-4xl">
                                Stock Opname Asset per Departemen
                            </h1>

                            <p class="mt-3 text-sm leading-6 text-emerald-50/90 sm:text-base">
                                Buat sesi audit, lakukan pengecekan fisik asset, lalu bandingkan hasil lapangan dengan data sistem untuk meningkatkan akurasi kontrol asset.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <a
                                href="{{ route('assets.audits.create') }}"
                                class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50"
                            >
                                + Buat Audit
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Sesi Audit</h3>
                            <p class="text-sm text-gray-500">
                                Menampilkan seluruh sesi audit asset yang sudah dibuat.
                            </p>
                        </div>

                        <div class="text-sm text-gray-500">
                            Total tampil: <span class="font-semibold text-gray-700">{{ $audits->count() }}</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Audit</th>
                                <th class="px-6 py-4">Departemen</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Total Asset</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($audits as $audit)
                                <tr class="transition hover:bg-gray-50/80">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-500">
                                        {{ $loop->iteration + ($audits->currentPage() - 1) * $audits->perPage() }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800">{{ $audit->audit_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $audit->audit_code }}</div>
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-700">
                                        {{ $audit->owner_role ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $audit->audit_date?->format('d M Y') ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $audit->items_count ?? 0 }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @php
                                            $statusClass = match($audit->status) {
                                                'open' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
                                                'closed' => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200',
                                                'draft' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                                                default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-200',
                                            };
                                        @endphp

                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst($audit->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a
                                                href="{{ route('assets.audits.show', $audit) }}"
                                                class="rounded-xl border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 transition hover:bg-gray-50"
                                            >
                                                Detail
                                            </a>

                                            <a
                                                href="{{ route('assets.audits.scan', $audit) }}"
                                                class="rounded-xl border border-blue-300 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-50"
                                            >
                                                Scan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-14 text-center">
                                        <div class="mx-auto max-w-md">
                                            <div class="text-lg font-semibold text-gray-700">Belum ada sesi audit</div>
                                            <p class="mt-2 text-sm text-gray-500">
                                                Buat sesi audit baru untuk mulai proses stock opname asset per departemen.
                                            </p>
                                            <div class="mt-5">
                                                <a
                                                    href="{{ route('assets.audits.create') }}"
                                                    class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"
                                                >
                                                    + Buat Audit
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($audits->hasPages())
                    <div class="border-t border-gray-100 px-6 py-4">
                        {{ $audits->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>