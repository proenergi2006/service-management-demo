<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $audit->audit_name }}
                </h2>
                <p class="text-sm text-gray-500">
                    {{ $audit->audit_code }} • {{ $audit->owner_role }} • {{ $audit->audit_date?->format('d M Y') }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('assets.audits.scan', $audit) }}"
                    class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
                >
                    Scan Asset
                </a>

                <a
                    href="{{ route('assets.audits.index') }}"
                    class="rounded-2xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50"
                >
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="overflow-hidden rounded-[28px] border border-blue-200 bg-white shadow-sm">
                <div class="px-6 py-6 sm:px-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="max-w-3xl">
                            <div class="mb-3 flex flex-wrap gap-2">
                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 ring-1 ring-blue-200">
                                    {{ $audit->audit_code }}
                                </span>

                                <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">
                                    {{ $audit->owner_role }}
                                </span>

                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                                    {{ ucfirst($audit->status) }}
                                </span>
                            </div>

                            <h1 class="text-3xl font-bold tracking-tight text-gray-800">
                                {{ $audit->audit_name }}
                            </h1>

                            <p class="mt-2 text-sm text-gray-500">
                                Tanggal Audit: {{ $audit->audit_date?->format('d M Y') ?? '-' }}
                            </p>

                            @if($audit->description)
                                <div class="mt-4 rounded-2xl bg-slate-50 p-4 text-sm text-gray-700">
                                    {{ $audit->description }}
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-2xl border border-gray-200 bg-white p-4 text-center shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Total</div>
                                <div class="mt-2 text-2xl font-bold text-gray-800">{{ $summary['total'] }}</div>
                            </div>

                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-center shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Found</div>
                                <div class="mt-2 text-2xl font-bold text-emerald-800">{{ $summary['found'] }}</div>
                            </div>

                            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-center shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-wide text-red-700">Not Found</div>
                                <div class="mt-2 text-2xl font-bold text-red-800">{{ $summary['not_found'] }}</div>
                            </div>

                            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-4 text-center shadow-sm">
                                <div class="text-xs font-semibold uppercase tracking-wide text-amber-700">Damaged</div>
                                <div class="mt-2 text-2xl font-bold text-amber-800">{{ $summary['damaged'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Detail Audit Asset
                    </h3>
                    <p class="text-sm text-gray-500">
                        Lakukan update hasil audit untuk setiap asset yang masuk dalam sesi ini.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4 min-w-[220px]">Asset</th>
                                <th class="px-6 py-4">Lokasi Sistem</th>
                                <th class="px-6 py-4">Holder Sistem</th>
                                <th class="px-6 py-4">Status Audit</th>
                                <th class="px-6 py-4 min-w-[320px]">Update Hasil</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach($audit->items as $item)
                                <tr class="align-top hover:bg-gray-50/70">
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800">
                                            {{ $item->asset->asset_code ?? '-' }}
                                        </div>
                                        <div class="text-sm text-gray-600">
                                            {{ $item->asset->asset_name ?? '-' }}
                                        </div>
                                        <div class="mt-1 text-xs text-gray-400">
                                            {{ $item->asset->category->name ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $item->asset->location->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $item->asset->activeAssignment?->user?->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @php
                                            $statusClass = match($item->audit_status) {
                                                'found' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
                                                'not_found' => 'bg-red-100 text-red-700 ring-1 ring-red-200',
                                                'damaged' => 'bg-amber-100 text-amber-700 ring-1 ring-amber-200',
                                                'need_review' => 'bg-purple-100 text-purple-700 ring-1 ring-purple-200',
                                                default => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200',
                                            };
                                        @endphp

                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $item->audit_status)) }}
                                        </span>

                                        @if($item->checked_at)
                                            <div class="mt-2 text-xs text-gray-400">
                                                {{ $item->checked_at?->format('d M Y H:i') }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <form method="POST" action="{{ route('assets.audits.items.update', [$audit, $item]) }}" class="grid gap-3">
                                            @csrf
                                            @method('PUT')

                                            <select
                                                name="audit_status"
                                                class="rounded-xl border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                            >
                                                <option value="pending" @selected($item->audit_status === 'pending')>Pending</option>
                                                <option value="found" @selected($item->audit_status === 'found')>Found</option>
                                                <option value="not_found" @selected($item->audit_status === 'not_found')>Not Found</option>
                                                <option value="damaged" @selected($item->audit_status === 'damaged')>Damaged</option>
                                                <option value="need_review" @selected($item->audit_status === 'need_review')>Need Review</option>
                                            </select>

                                            <input
                                                type="text"
                                                name="actual_location"
                                                value="{{ old('actual_location', $item->actual_location) }}"
                                                placeholder="Lokasi aktual"
                                                class="rounded-xl border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                            >

                                            <input
                                                type="text"
                                                name="actual_holder"
                                                value="{{ old('actual_holder', $item->actual_holder) }}"
                                                placeholder="Holder aktual"
                                                class="rounded-xl border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                            >

                                            <textarea
                                                name="notes"
                                                rows="2"
                                                placeholder="Catatan audit"
                                                class="rounded-xl border-gray-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                            >{{ old('notes', $item->notes) }}</textarea>

                                            <button
                                                type="submit"
                                                class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700"
                                            >
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            @if($audit->items->isEmpty())
                                <tr>
                                    <td colspan="6" class="px-6 py-14 text-center">
                                        <div class="text-lg font-semibold text-gray-700">Belum ada item audit</div>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Belum ada asset yang masuk ke sesi audit ini.
                                        </p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>