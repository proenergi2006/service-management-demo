<x-app-layout>

   
    <div class="py-6">

        <div class="w-full space-y-6 px-6 lg:px-10 xl:px-14">

            {{-- HERO --}}
            <div class="rounded-[32px] bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-8 text-white shadow-2xl">

                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                    <div>

                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase tracking-widest">
                            SAP PM STYLE ANALYTICS
                        </div>

                        <h1 class="mt-5 text-4xl font-black">
                            Asset Reliability Analytics
                        </h1>

                        <p class="mt-4 max-w-3xl text-sm leading-7 text-blue-100">
                            Monitoring MTTR, MTBF, downtime dan reliability performance asset perusahaan.
                        </p>

                    </div>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="overflow-hidden rounded-[32px] border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">

                    <h3 class="text-xl font-black text-[#0B1F3A]">
                        Reliability Asset Report
                    </h3>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-slate-500">
                                    Asset
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-slate-500">
                                    Breakdown
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-slate-500">
                                    Downtime
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-slate-500">
                                    MTTR
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-slate-500">
                                    MTBF
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-widest text-slate-500">
                                    Reliability
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">

                            @forelse($assetReliability as $row)

                                <tr class="hover:bg-slate-50">

                                    <td class="px-6 py-5">

                                        <div class="font-black text-slate-800">
                                            {{ $row['asset']->asset_code ?? '-' }}
                                        </div>

                                        <div class="mt-1 text-sm text-slate-500">
                                            {{ $row['asset']->asset_name ?? '-' }}
                                        </div>

                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="rounded-full bg-rose-100 px-4 py-2 text-xs font-black text-rose-700">
                                            {{ $row['breakdown_count'] }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 font-bold text-rose-700">
                                        {{ number_format($row['total_downtime_minutes'], 0, ',', '.') }}
                                        min
                                    </td>

                                    <td class="px-6 py-5 font-bold text-blue-700">
                                        {{ number_format($row['mttr'], 2) }}
                                        min
                                    </td>

                                    <td class="px-6 py-5 font-bold text-emerald-700">
                                        {{ number_format($row['mtbf'], 2) }}
                                        min
                                    </td>

                                    <td class="px-6 py-5">

                                        @php
                                            $score = $row['reliability_score'];
                                        @endphp

                                        <div class="flex items-center gap-3">

                                            <div class="h-3 w-40 overflow-hidden rounded-full bg-slate-200">

                                                <div
                                                    class="h-full rounded-full
                                                    {{ $score >= 90 ? 'bg-emerald-500' : '' }}
                                                    {{ $score >= 70 && $score < 90 ? 'bg-amber-500' : '' }}
                                                    {{ $score < 70 ? 'bg-rose-500' : '' }}"
                                                    style="width: {{ $score }}%">
                                                </div>

                                            </div>

                                            <div class="text-sm font-black text-slate-700">
                                                {{ $score }}%
                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6"
                                        class="px-6 py-10 text-center text-sm text-slate-500">

                                        Belum ada data reliability.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>