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
        <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
            <x-flash-message />

            <div class="rounded-3xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-800">Scan QR Audit</h3>
                    <p class="text-sm text-gray-500">
                        Arahkan kamera ke QR code asset untuk langsung mencatat hasil audit.
                    </p>
                </div>

                <div class="space-y-6 p-6">
                    <form id="audit-scan-form" method="POST" action="{{ route('assets.audits.scan.store', $audit) }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Scanner Kamera</label>

                            <div class="overflow-hidden rounded-2xl border border-gray-300 bg-slate-50">
                                <div id="reader" class="w-full"></div>
                            </div>

                            <input type="hidden" name="qr_code" id="qr_code" value="{{ old('qr_code') }}">

                            @error('qr_code')
                                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                            <div id="scan-status" class="mt-3 rounded-2xl bg-slate-50 px-4 py-3 text-sm text-gray-600">
                                Menunggu scan QR code...
                            </div>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Status Audit</label>
                            <select
                                name="audit_status"
                                id="audit_status"
                                class="w-full rounded-2xl border-gray-300 text-base shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            >
                                <option value="found" @selected(old('audit_status', 'found') == 'found')>Found</option>
                                <option value="damaged" @selected(old('audit_status') == 'damaged')>Damaged</option>
                                <option value="need_review" @selected(old('audit_status') == 'need_review')>Need Review</option>
                                <option value="not_found" @selected(old('audit_status') == 'not_found')>Not Found</option>
                            </select>
                            @error('audit_status')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-gray-700">Lokasi Aktual</label>
                                <input
                                    type="text"
                                    name="actual_location"
                                    id="actual_location"
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
                                    id="actual_holder"
                                    value="{{ old('actual_holder') }}"
                                    placeholder="Nama user / PIC aktual"
                                    class="w-full rounded-2xl border-gray-300 text-base shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                >
                                @error('actual_holder')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Catatan</label>
                            <textarea
                                name="notes"
                                id="notes"
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
                                id="submit-btn"
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

                    <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                        Tips:
                        <ul class="mt-2 space-y-1">
                            <li>• Izinkan akses kamera saat diminta browser.</li>
                            <li>• Arahkan QR code ke area scanner sampai terbaca.</li>
                            <li>• Setelah QR terbaca, form akan otomatis terkirim.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
            let scannerStarted = false;
            let html5QrcodeScanner = null;
            let isSubmitting = false;

            const statusBox = document.getElementById('scan-status');
            const qrInput = document.getElementById('qr_code');
            const form = document.getElementById('audit-scan-form');
            const submitBtn = document.getElementById('submit-btn');

            function setStatus(message, type = 'default') {
                const baseClass = 'mt-3 rounded-2xl px-4 py-3 text-sm';
                let colorClass = 'bg-slate-50 text-gray-600';

                if (type === 'success') {
                    colorClass = 'bg-emerald-50 text-emerald-700';
                } else if (type === 'error') {
                    colorClass = 'bg-red-50 text-red-700';
                } else if (type === 'info') {
                    colorClass = 'bg-blue-50 text-blue-700';
                }

                statusBox.className = `${baseClass} ${colorClass}`;
                statusBox.textContent = message;
            }

            function submitAuditForm(decodedText) {
                if (isSubmitting) return;

                isSubmitting = true;
                qrInput.value = decodedText;
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-70', 'cursor-not-allowed');
                setStatus(`QR terbaca: ${decodedText}. Mengirim data...`, 'success');

                if (html5QrcodeScanner) {
                    html5QrcodeScanner.clear().catch(() => {});
                }

                setTimeout(() => {
                    form.submit();
                }, 400);
            }

            function onScanSuccess(decodedText, decodedResult) {
                if (!decodedText || isSubmitting) return;
                submitAuditForm(decodedText);
            }

            function onScanFailure(error) {
                // sengaja dikosongkan agar tidak spam error di UI
            }

            function startScanner() {
                if (scannerStarted) return;

                scannerStarted = true;
                setStatus('Memulai kamera...', 'info');

                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader",
                    {
                        fps: 10,
                        qrbox: { width: 220, height: 220 },
                        aspectRatio: 1.0,
                        rememberLastUsedCamera: true,
                        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                    },
                    false
                );

                html5QrcodeScanner.render(onScanSuccess, onScanFailure);

                setTimeout(() => {
                    if (!isSubmitting) {
                        setStatus('Arahkan kamera ke QR code asset.', 'info');
                    }
                }, 1000);
            }

            document.addEventListener('DOMContentLoaded', function () {
                startScanner();
            });
        </script>
    @endpush
</x-app-layout>