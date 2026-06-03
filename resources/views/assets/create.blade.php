<x-app-layout>
    <style>
        .sap-page {
            background: #f5f6f7;
            min-height: 100vh;
            color: #32363a;
        }

        .sap-container {
            width: 100%;
            padding: 24px 40px;
        }

        .sap-card {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .05);
        }

        .sap-header {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
        }

        .sap-breadcrumb {
            font-size: 12px;
            color: #6a6d70;
            margin-bottom: 6px;
        }

        .sap-title {
            font-size: 28px;
            font-weight: 900;
            color: #32363a;
            line-height: 1.2;
        }

        .sap-subtitle {
            margin-top: 6px;
            font-size: 13px;
            color: #6a6d70;
            line-height: 1.6;
        }

        .sap-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 11px;
            font-weight: 900;
            border: 1px solid #d9d9d9;
            background: #f5f6f7;
            color: #354a5f;
        }

        .sap-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 40px;
            padding: 0 16px;
            border-radius: 8px;
            border: 1px solid #c9cdd1;
            background: #ffffff;
            color: #32363a;
            font-size: 13px;
            font-weight: 800;
            transition: .15s;
            white-space: nowrap;
        }

        .sap-btn:hover {
            background: #f5f6f7;
        }

        .sap-btn-primary {
            background: #0a6ed1;
            border-color: #0a6ed1;
            color: #ffffff;
        }

        .sap-btn-primary:hover {
            background: #085caf;
        }

        .sap-section-header {
            border-bottom: 1px solid #edf0f2;
            background: #f5f6f7;
            padding: 16px 20px;
        }

        .sap-section-title {
            font-size: 16px;
            font-weight: 900;
            color: #32363a;
        }

        .sap-section-desc {
            margin-top: 3px;
            font-size: 13px;
            color: #6a6d70;
        }

        .sap-guide-item {
            border: 1px solid #edf0f2;
            background: #ffffff;
            border-radius: 12px;
            padding: 14px;
        }

        .sap-guide-no {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #0a6ed1;
            color: #ffffff;
            font-size: 12px;
            font-weight: 900;
            flex-shrink: 0;
        }

        .sap-check-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 999px;
            background: #e4f5e9;
            color: #107e3e;
            font-size: 12px;
            font-weight: 900;
            flex-shrink: 0;
        }

        .sap-sidebar-sticky {
            position: sticky;
            top: 88px;
        }

        .sap-animate-up {
            opacity: 0;
            transform: translateY(18px);
            animation: sapFadeUp .55s ease forwards;
        }

        .sap-delay-1 {
            animation-delay: .08s;
        }

        .sap-delay-2 {
            animation-delay: .16s;
        }

        @keyframes sapFadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sap-field-error {
            border-color: #bb0000 !important;
            box-shadow: 0 0 0 3px rgba(187, 0, 0, .12) !important;
        }

        .sap-laravel-error-hide {
            display: none !important;
        }

        /* SAP TOAST */

        .sap-toast {
            position: fixed;
            top: 92px;
            right: 24px;
            z-index: 99999;
            width: 430px;
            border-radius: 16px;
            background: #fff;
            border: 1px solid #d9d9d9;
            overflow: hidden;
            box-shadow:
                0 20px 50px rgba(15,23,42,.22),
                0 6px 16px rgba(15,23,42,.08);
            animation: sapToastIn .35s ease forwards;
            backdrop-filter: blur(8px);
        }

        .sap-toast-progress {
            height: 5px;
            width: 100%;
        }

        .sap-toast-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            font-size: 14px;
            font-weight: 900;
        }

        .sap-toast-body {
            padding: 16px;
            font-size: 13px;
            color: #32363a;
            line-height: 1.8;
        }

        .sap-toast-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: 900;
            background: transparent;
            border: 0;
            cursor: pointer;
            transition: .15s;
        }

        .sap-toast-close:hover {
            background: rgba(0,0,0,.06);
        }

        @keyframes sapToastIn {
            from {
                opacity: 0;
                transform: translateX(45px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @media (max-width: 768px) {

            .sap-container {
                padding: 16px;
            }

            .sap-title {
                font-size: 22px;
            }

            .sap-sidebar-sticky {
                position: static;
            }

            .sap-toast {
                top: auto;
                bottom: 18px;
                left: 16px;
                right: 16px;
                width: auto;
            }
        }
    </style>

    <div class="sap-page">

        <div class="sap-container space-y-5">

            {{-- HIDE DEFAULT LARAVEL ERROR --}}
            <div class="sap-laravel-error-hide">
                <x-flash-message />
            </div>

            {{-- HEADER --}}
            <div class="sap-header p-5 sap-animate-up">

                <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">

                    <div class="min-w-0">

                        <div class="sap-breadcrumb">
                            Asset Management / Asset Master / Create
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <span class="sap-chip">Enterprise Asset Registration</span>
                            <span class="sap-chip">QR Ready</span>
                            <span class="sap-chip">Audit Friendly</span>
                            <span class="sap-chip">Lifecycle Tracking</span>
                        </div>

                        <h1 class="sap-title mt-4">
                            Tambahkan Asset Baru
                        </h1>

                        <p class="sap-subtitle max-w-4xl">
                            Lengkapi informasi asset untuk mempermudah tracking lokasi,
                            assignment user, histori maintenance, dokumentasi, warranty,
                            dan integrasi operasional perusahaan.
                        </p>

                    </div>

                    <div class="flex flex-wrap gap-2 xl:justify-end">
                        <a href="{{ route('assets.index') }}" class="sap-btn">
                            Kembali ke List
                        </a>
                    </div>

                </div>

            </div>

            {{-- CONTENT --}}
            <div class="grid grid-cols-1 gap-5 2xl:grid-cols-12">

                {{-- FORM --}}
                <div class="2xl:col-span-8">

                    <div class="sap-card overflow-hidden sap-animate-up sap-delay-1">

                        <div class="sap-section-header">
                            <h3 class="sap-section-title">
                                Form Registrasi Asset
                            </h3>

                            <p class="sap-section-desc">
                                Isi seluruh informasi asset secara lengkap untuk mempermudah monitoring dan lifecycle management.
                            </p>
                        </div>

                        <div class="p-5 lg:p-6">

                            <form id="assetCreateForm"
                                  method="POST"
                                  action="{{ route('assets.store') }}">

                                @csrf

                                @include('assets.partials.form')

                            </form>

                        </div>

                    </div>

                </div>

                {{-- SIDEBAR --}}
                <div class="space-y-5 2xl:col-span-4">

                    <div class="sap-sidebar-sticky space-y-5 sap-animate-up sap-delay-2">

                        {{-- PANDUAN --}}
                        <div class="sap-card overflow-hidden">

                            <div class="sap-section-header">
                                <h3 class="sap-section-title">
                                    Panduan Singkat
                                </h3>

                                <p class="sap-section-desc">
                                    Pastikan data asset diinput dengan benar sejak awal.
                                </p>
                            </div>

                            <div class="space-y-3 p-5">

                                @foreach([
                                    ['01','Gunakan kode asset unik','Contoh: AST-IT-0001 atau format internal perusahaan.'],
                                    ['02','Pilih kategori & lokasi yang sesuai','Penting untuk reporting, audit, dan tracking operasional.'],
                                    ['03','Isi serial number bila ada','Membantu identifikasi perangkat saat maintenance dan stock opname.'],
                                    ['04','Lengkapi referensi integrasi','Gunakan SYOP PR/PO No dan Accurate Asset ID bila tersedia.'],
                                ] as $guide)

                                    <div class="sap-guide-item">

                                        <div class="flex items-start gap-3">

                                            <div class="sap-guide-no">
                                                {{ $guide[0] }}
                                            </div>

                                            <div>

                                                <div class="font-black text-slate-800">
                                                    {{ $guide[1] }}
                                                </div>

                                                <div class="mt-1 text-sm leading-6 text-slate-500">
                                                    {{ $guide[2] }}
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- VALIDATION ERROR TOAST --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                showSapToast(
                    'Terjadi Kesalahan',
                    `{!! implode('', $errors->all('<div>• :message</div>')) !!}`,
                    'error',
                    15000
                );

            });
        </script>
    @endif

    <script>
        function showSapToast(title, message, type = 'error', duration = 15000) {

            document.querySelectorAll('.sap-toast')
                .forEach(el => el.remove());

            const colors = {
                success: {
                    border: '#bfe6c8',
                    bg: '#e4f5e9',
                    text: '#107e3e',
                    progress: '#107e3e'
                },
                error: {
                    border: '#f5b5b5',
                    bg: '#ffeaea',
                    text: '#bb0000',
                    progress: '#bb0000'
                },
                warning: {
                    border: '#f5d76e',
                    bg: '#fff4ce',
                    text: '#8a6d00',
                    progress: '#e9730c'
                }
            };

            const config = colors[type] || colors.error;

            const toast = document.createElement('div');

            toast.className = 'sap-toast';

            toast.style.borderColor = config.border;

            toast.innerHTML = `
                <div class="sap-toast-progress"
                     style="background:${config.progress}">
                </div>

                <div class="sap-toast-header"
                     style="
                        background:${config.bg};
                        color:${config.text};
                     ">

                    <div class="flex items-center gap-2">
                        <span>${title}</span>
                    </div>

                    <button type="button"
                            class="sap-toast-close">
                        ×
                    </button>

                </div>

                <div class="sap-toast-body">
                    ${message}
                </div>
            `;

            document.body.appendChild(toast);

            const progress = toast.querySelector('.sap-toast-progress');

            progress.animate(
                [
                    { width: '100%' },
                    { width: '0%' }
                ],
                {
                    duration: duration,
                    easing: 'linear'
                }
            );

            const closeToast = () => {

                toast.style.opacity = '0';
                toast.style.transform = 'translateX(40px)';
                toast.style.transition = '.35s ease';

                setTimeout(() => toast.remove(), 350);

            };

            toast.querySelector('.sap-toast-close')
                .addEventListener('click', closeToast);

            setTimeout(closeToast, duration);
        }

        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('assetCreateForm');

            if (!form) return;

            function getFieldLabel(field) {

                const wrapper = field.closest('div');

                const label = wrapper
                    ? wrapper.querySelector('label')
                    : null;

                if (label && label.innerText.trim() !== '') {
                    return label.innerText.trim().replace('*', '');
                }

                if (field.placeholder) {
                    return field.placeholder;
                }

                if (field.name) {
                    return field.name.replaceAll('_', ' ');
                }

                return 'Field wajib';

            }

            function isEmptyField(field) {

                if (field.type === 'checkbox' || field.type === 'radio') {

                    const group = form.querySelectorAll(`[name="${field.name}"]`);

                    return !Array.from(group).some(item => item.checked);

                }

                return !field.value || field.value.trim() === '';

            }

            form.addEventListener('submit', function (e) {

                let isValid = true;

                let firstError = null;

                let messages = [];

                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(field => {

                    field.classList.remove('sap-field-error');

                    if (isEmptyField(field)) {

                        isValid = false;

                        field.classList.add('sap-field-error');

                        const label = getFieldLabel(field);

                        messages.push(`<div>• ${label} wajib diisi</div>`);

                        if (!firstError) firstError = field;

                    }

                });

                if (!isValid) {

                    e.preventDefault();

                    showSapToast(
                        'Validasi Gagal',
                        messages.slice(0, 6).join(''),
                        'error',
                        12000
                    );

                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    return false;
                }

                const submitButton =
                    form.querySelector('button[type="submit"]');

                if (submitButton) {

                    submitButton.disabled = true;

                    submitButton.innerHTML = `
                        <span class="inline-flex items-center gap-2">

                            <svg class="h-4 w-4 animate-spin"
                                 viewBox="0 0 24 24"
                                 fill="none">

                                <circle class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4">
                                </circle>

                                <path class="opacity-75"
                                      fill="currentColor"
                                      d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>

                            </svg>

                            Menyimpan Asset...

                        </span>
                    `;

                }

            });

        });
    </script>
</x-app-layout>