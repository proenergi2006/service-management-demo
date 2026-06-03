@if (session('success'))
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm"
    >
        <div class="flex items-start justify-between gap-3">
            <div>
                <div class="font-semibold">Berhasil</div>
                <div class="text-sm">{{ session('success') }}</div>
            </div>

            <button
                type="button"
                @click="show = false"
                class="text-emerald-600 hover:text-emerald-800"
            >
                ✕
            </button>
        </div>
    </div>
@endif

@if ($errors->any())
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm"
    >
        <div class="flex items-start justify-between gap-3">
            <div>
                <div class="font-semibold">Terjadi kesalahan</div>
                <ul class="mt-2 list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            <button
                type="button"
                @click="show = false"
                class="text-red-600 hover:text-red-800"
            >
                ✕
            </button>
        </div>
    </div>
@endif