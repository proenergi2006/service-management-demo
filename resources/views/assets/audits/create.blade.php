<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-bold text-gray-800">
                Buat Audit Asset
            </h2>
            <p class="text-sm text-gray-500">
                Buat sesi stock opname berdasarkan departemen.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <form method="POST" action="{{ route('assets.audits.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Judul Audit
                        </label>
                        <input
                            type="text"
                            name="audit_name"
                            value="{{ old('audit_name') }}"
                            placeholder="Contoh: Stock Opname IT April 2026"
                            class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >
                        @error('audit_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Departemen
                        </label>
                        <select
                            name="owner_role"
                            class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >
                            <option value="">-- Pilih Departemen --</option>
                            <option value="IT" @selected(old('owner_role') == 'IT')>IT</option>
                            <option value="GA" @selected(old('owner_role') == 'GA')>GA</option>
                            <option value="LOGISTIK" @selected(old('owner_role') == 'LOGISTIK')>LOGISTIK</option>
                        </select>
                        @error('owner_role')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Tanggal Audit
                        </label>
                        <input
                            type="date"
                            name="audit_date"
                            value="{{ old('audit_date', now()->format('Y-m-d')) }}"
                            class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                        >
                        @error('audit_date')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">
                            Deskripsi
                        </label>
                        <textarea
                            name="description"
                            rows="4"
                            class="w-full rounded-2xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Catatan audit..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('assets.audits.index') }}"
                           class="rounded-2xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="rounded-2xl bg-emerald-600 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-700"
                        >
                            Simpan Audit
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>