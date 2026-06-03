<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold text-gray-800">Scan Audit Asset</h2>
            <p class="text-sm text-gray-500">
                {{ $audit->audit_name }} • {{ $audit->audit_code }} • {{ $audit->owner_role }}
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl space-y-6 px-4 sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">Input QR Audit</h3>
                    <p class="text-sm text-gray-500">
                        Scan atau input QR code asset untuk memperbarui hasil audit.
                    </p>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('assets.audits.scan.store', $audit) }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">QR Code</label>
                            <input
                                autofocus
                                type="text"
                                name="qr_code"
                                value="{{ old('qr_code') }}"
                                placeholder="Scan / input QR code"
                                class="w-full rounded-2xl border-gray-300 text-base shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('qr_code')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Status Audit</label>
                            <select
                                name="audit_status"
                                class="w-full rounded-2xl border-gray-300 text-base shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >
                                <option value="found" @selected(old('audit_status') == 'found')>Found</option>
                                <option value="damaged" @selected(old('audit_status') == 'damaged')>Damaged</option>
                                <option value="need_review" @selected(old('audit_status') == 'need_review')>Need Review</option>
                                <option value="not_found" @selected(old('audit_status') == 'not_found')>Not Found</option>
                            </select>
                            @error('audit_status')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Lokasi Aktual</label>
                            <input
                                type="text"
                                name="actual_location"
                                value="{{ old('actual_location') }}"
                                placeholder="Contoh: Gudang A / Ruang IT"
                                class="w-full rounded-2xl border-gray-300 text-base shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('actual_location')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Holder Aktual</label>
                            <input
                                type="text"
                                name="actual_holder"
                                value="{{ old('actual_holder') }}"
                                placeholder="Nama user / PIC aktual"
                                class="w-full rounded-2xl border-gray-300 text-base shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >
                            @error('actual_holder')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Catatan</label>
                            <textarea
                                name="notes"
                                rows="4"
                                placeholder="Catatan hasil audit..."
                                class="w-full rounded-2xl border-gray-300 text-base shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <button
                                type="submit"
                                class="rounded-2xl bg-emerald-600 px-6 py-3 text-base font-semibold text-white hover:bg-emerald-700"
                            >
                                Simpan Hasil Scan
                            </button>

                            <a
                                href="{{ route('assets.audits.show', $audit) }}"
                                class="rounded-2xl border border-gray-300 px-6 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50"
                            >
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>