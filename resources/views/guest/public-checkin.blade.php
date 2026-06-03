<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Check-In</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-white to-blue-50 font-sans text-slate-800">

<main class="mx-auto flex min-h-screen max-w-xl items-center px-4 py-6">
    <div class="w-full overflow-hidden rounded-[32px] bg-white shadow-2xl ring-1 ring-slate-200">

        <div class="relative overflow-hidden bg-[#0B1F3A] px-6 py-8 text-white">
            <div class="absolute -right-16 -top-16 h-40 w-40 rounded-full bg-blue-400/20 blur-2xl"></div>

            <div class="relative z-10">
                <div class="mb-5 flex items-center gap-3">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow">
                        <img src="{{ asset('images/proenergi-logo.png') }}" class="h-10 w-auto">
                    </div>

                    <div>
                        <div class="text-xs font-black uppercase tracking-widest text-blue-100">
                            PT Pro Energi
                        </div>
                        <div class="text-lg font-black">
                            Guest Registration
                        </div>
                    </div>
                </div>

                <h1 class="text-3xl font-black leading-tight">
                    Selamat Datang
                </h1>

                <p class="mt-2 text-sm leading-6 text-blue-100">
                    Silakan lengkapi data kunjungan sebelum memasuki area kantor.
                </p>

                <div class="mt-5 rounded-2xl bg-white/10 px-4 py-3 text-xs font-semibold text-blue-50 ring-1 ring-white/15">
                    Data ini digunakan untuk kebutuhan keamanan dan pencatatan tamu.
                </div>
            </div>
        </div>

        <form id="guestForm" method="POST" action="{{ route('guest.check-in.store') }}" class="space-y-5 p-5 sm:p-6">
            @csrf

            @if ($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <div>
                <label class="mb-1 block text-sm font-black text-slate-700">
                    Nama Tamu <span class="text-rose-500">*</span>
                </label>
                <input
                    name="guest_name"
                    value="{{ old('guest_name') }}"
                    data-label="Nama Tamu"
                    class="required-field w-full rounded-2xl border-slate-300 px-4 py-3 text-base focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                    placeholder="Masukkan nama lengkap">
            </div>

            <div>
                <label class="mb-1 block text-sm font-black text-slate-700">
                    Perusahaan <span class="text-rose-500">*</span>
                </label>
                <input
                    name="company_name"
                    value="{{ old('company_name') }}"
                    data-label="Perusahaan"
                    class="required-field w-full rounded-2xl border-slate-300 px-4 py-3 text-base focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                    placeholder="Contoh: PT ABC">
            </div>

            <div>
                <label class="mb-1 block text-sm font-black text-slate-700">
                    No. HP <span class="text-rose-500">*</span>
                </label>
                <input
                    name="phone"
                    value="{{ old('phone') }}"
                    data-label="No. HP"
                    inputmode="tel"
                    class="required-field w-full rounded-2xl border-slate-300 px-4 py-3 text-base focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                    placeholder="Contoh: 08123456789">
            </div>

            <div>
                <label class="mb-1 block text-sm font-black text-slate-700">
                    Bertemu Dengan <span class="text-rose-500">*</span>
                </label>
                <input
                    name="host_name"
                    value="{{ old('host_name') }}"
                    data-label="Bertemu Dengan"
                    class="required-field w-full rounded-2xl border-slate-300 px-4 py-3 text-base focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                    placeholder="Nama karyawan yang dituju">
            </div>

            <div>
                <label class="mb-1 block text-sm font-black text-slate-700">
                    Cabang / Lokasi <span class="text-rose-500">*</span>
                </label>
                <select
                    name="branch"
                    data-label="Cabang / Lokasi"
                    class="required-field w-full rounded-2xl border-slate-300 px-4 py-3 text-base focus:border-[#0B1F3A] focus:ring-[#0B1F3A]">
                    <option value="">Pilih Lokasi</option>
                    <option @selected(old('branch') === 'Head Office')>Head Office</option>
                    <option @selected(old('branch') === 'Jakarta')>Jakarta</option>
                    <option @selected(old('branch') === 'Surabaya')>Surabaya</option>
                    <option @selected(old('branch') === 'Samarinda')>Samarinda</option>
                    <option @selected(old('branch') === 'Palembang')>Palembang</option>
                    <option @selected(old('branch') === 'Banjarmasin')>Banjarmasin</option>
                    <option @selected(old('branch') === 'Pontianak')>Pontianak</option>
                    <option @selected(old('branch') === 'Sulawesi')>Sulawesi</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-black text-slate-700">
                    Tujuan Kunjungan <span class="text-rose-500">*</span>
                </label>
                <input
                    name="purpose"
                    value="{{ old('purpose') }}"
                    data-label="Tujuan Kunjungan"
                    class="required-field w-full rounded-2xl border-slate-300 px-4 py-3 text-base focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                    placeholder="Contoh: Meeting, interview, delivery, maintenance">
            </div>

            <div>
                <label class="mb-1 block text-sm font-black text-slate-700">
                    No. Kendaraan
                    <span class="text-xs font-bold text-slate-400">(Opsional)</span>
                </label>
                <input
                    name="vehicle_number"
                    value="{{ old('vehicle_number') }}"
                    class="w-full rounded-2xl border-slate-300 px-4 py-3 text-base uppercase focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                    placeholder="Contoh: B 1234 ABC">
            </div>

            <div>
                <label class="mb-1 block text-sm font-black text-slate-700">
                    Catatan
                    <span class="text-xs font-bold text-slate-400">(Opsional)</span>
                </label>
                <textarea
                    name="notes"
                    rows="3"
                    class="w-full rounded-2xl border-slate-300 px-4 py-3 text-base focus:border-[#0B1F3A] focus:ring-[#0B1F3A]"
                    placeholder="Catatan tambahan jika ada">{{ old('notes') }}</textarea>
            </div>

            <button
                type="submit"
                class="w-full rounded-2xl bg-[#0B1F3A] px-5 py-4 text-base font-black text-white shadow-lg shadow-slate-300 transition hover:bg-[#123B6D]">
                Check-In Sekarang
            </button>

            <p class="text-center text-xs leading-5 text-slate-400">
                Dengan melakukan check-in, Anda menyetujui pencatatan data kunjungan oleh PT Pro Energi.
            </p>
        </form>
    </div>
</main>

<script>
    const form = document.getElementById('guestForm');

    const requiredFields = [
        'guest_name',
        'company_name',
        'phone',
        'host_name',
        'branch',
        'purpose',
    ];

    function resetFieldError(field) {
        if (!field) return;

        field.classList.remove(
            'border-red-500',
            'ring-2',
            'ring-red-200',
            'bg-red-50'
        );
    }

    function setFieldError(field) {
        if (!field) return;

        field.classList.add(
            'border-red-500',
            'ring-2',
            'ring-red-200',
            'bg-red-50'
        );
    }

    requiredFields.forEach(name => {
        const field = form.querySelector(`[name="${name}"]`);

        field?.addEventListener('input', () => {
            if (field.value.trim() !== '') {
                resetFieldError(field);
            }
        });

        field?.addEventListener('change', () => {
            if (field.value.trim() !== '') {
                resetFieldError(field);
            }
        });
    });

    form.addEventListener('submit', function(e) {
        let firstInvalidField = null;
        let missingFields = [];

        requiredFields.forEach(name => {
            const field = form.querySelector(`[name="${name}"]`);

            resetFieldError(field);

            if (!field || field.value.trim() === '') {
                setFieldError(field);

                missingFields.push(field?.dataset?.label || name);

                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            }
        });

        if (missingFields.length > 0) {
            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Form belum lengkap',
                html: `
                    <div style="text-align:left">
                        <p style="margin-bottom:10px;">
                            Mohon lengkapi field berikut:
                        </p>
                        <ul style="padding-left:18px;">
                            ${missingFields.map(item =>
                                `<li style="margin-bottom:6px;"><strong>${item}</strong></li>`
                            ).join('')}
                        </ul>
                    </div>
                `,
                confirmButtonText: 'Lengkapi',
                confirmButtonColor: '#0B1F3A',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl'
                }
            }).then(() => {
                firstInvalidField?.focus();
            });

            return false;
        }

        Swal.fire({
            title: 'Menyimpan Check-In...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
</script>

</body>
</html>