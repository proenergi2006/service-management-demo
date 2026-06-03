<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Pro Energi Service Management</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-[#F4F6F9] text-slate-800">

<div class="flex min-h-screen flex-col">

    <main class="flex flex-1 items-center justify-center px-4 py-8">
        <div class="grid w-full max-w-7xl grid-cols-1 overflow-hidden rounded-[36px] border border-slate-200 bg-white shadow-2xl lg:grid-cols-2">

            {{-- LEFT BRANDING --}}
            <section class="relative hidden overflow-hidden bg-gradient-to-br from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] p-10 text-white lg:flex">
                <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-blue-300/20 blur-3xl"></div>

                <div class="relative z-10 flex w-full flex-col justify-between">
                    <div>
                        <div class="mb-10 flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-lg">
                                <img src="{{ asset('images/proenergi-logo.png') }}"
                                     alt="Pro Energi"
                                     class="h-11 w-auto object-contain">
                            </div>

                            <div>
                                <div class="text-3xl font-black tracking-tight">
                                    Pro Energi
                                </div>
                                <div class="text-sm font-semibold text-blue-100">
                                    Service Management Portal
                                </div>
                            </div>
                        </div>

                        <div class="inline-flex rounded-2xl bg-white/15 px-4 py-2 text-xs font-black uppercase tracking-wider ring-1 ring-white/20">
                            Integrated Internal Services
                        </div>

                       
                  

                    <div class="mt-10 grid grid-cols-1 gap-4">
                        <div class="rounded-3xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                            <div class="font-black">IT Helpdesk</div>
                            <div class="mt-1 text-sm text-blue-100">
                                Buat dan pantau ticket software, hardware, network, dan multimedia.
                            </div>
                        </div>

                        <div class="rounded-3xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                            <div class="font-black">Facility Booking</div>
                            <div class="mt-1 text-sm text-blue-100">
                                Booking ruangan dan kendaraan operasional dengan approval GA.
                            </div>
                        </div>

                        <div class="rounded-3xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                            <div class="font-black">Asset Lifecycle</div>
                            <div class="mt-1 text-sm text-blue-100">
                                Tracking asset, QR scan, maintenance history, dan dokumen pendukung.
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </section>

            {{-- RIGHT FORM --}}
            <section class="flex items-center p-6 sm:p-8 lg:p-12">
                <div class="mx-auto w-full max-w-md">

                    <div class="mb-8 text-center lg:hidden">
                        <img src="{{ asset('images/proenergi-logo.png') }}"
                             alt="Pro Energi"
                             class="mx-auto mb-4 h-14 w-auto">

                        <h1 class="text-2xl font-black text-[#0B1F3A]">
                            Pro Energi Service Management
                        </h1>

                        <p class="mt-2 text-sm text-slate-500">
                            Login untuk mengakses layanan internal.
                        </p>
                    </div>

                    <div class="mb-8 hidden lg:block">
                        <div class="inline-flex rounded-2xl bg-blue-50 px-4 py-2 text-xs font-black uppercase tracking-wider text-[#0B1F3A] ring-1 ring-blue-100">
                            Secure Login
                        </div>

                        <h2 class="mt-4 text-4xl font-black text-[#0B1F3A]">
                            Masuk
                        </h2>

                        <p class="mt-2 text-sm font-medium text-slate-500">
                            Gunakan akun Anda untuk mengakses Service Management Portal.
                        </p>
                    </div>

                    @if (session('status'))
                        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            <div class="mb-1 font-black">Login gagal</div>
                            <ul class="list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-black text-slate-700">
                                Email
                            </label>

                            <input id="email"
                                   name="email"
                                   type="email"
                                   value="{{ old('email') }}"
                                   required
                                   autofocus
                                   placeholder="nama@proenergi.co.id"
                                   class="w-full rounded-2xl border-slate-300 bg-white px-4 py-3.5 text-slate-800 shadow-sm focus:border-[#123B6D] focus:ring-[#123B6D]">
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label for="password" class="block text-sm font-black text-slate-700">
                                    Password
                                </label>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-sm font-black text-[#123B6D] hover:text-[#0B1F3A]">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>

                            <input id="password"
                                   name="password"
                                   type="password"
                                   required
                                   placeholder="Masukkan password"
                                   class="w-full rounded-2xl border-slate-300 bg-white px-4 py-3.5 text-slate-800 shadow-sm focus:border-[#123B6D] focus:ring-[#123B6D]">
                        </div>

                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600">
                                <input id="remember_me"
                                       type="checkbox"
                                       name="remember"
                                       class="rounded border-slate-300 text-[#0B1F3A] focus:ring-[#123B6D]">

                                <span>Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit"
                                class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-[#0B1F3A] via-[#123B6D] to-[#1E4F8A] px-4 py-3.5 text-base font-black text-white shadow-lg shadow-blue-200 transition hover:from-[#123B6D] hover:to-[#0B1F3A]">
                            Masuk ke Service Management
                        </button>

                        @if (Route::has('register'))
                            <div class="pt-2 text-center text-sm text-slate-500">
                                Belum punya akun?
                                <a href="{{ route('register') }}"
                                   class="font-black text-[#123B6D] hover:text-[#0B1F3A]">
                                    Daftar sekarang
                                </a>
                            </div>
                        @endif
                    </form>

                 

                </div>
            </section>

        </div>
    </main>

    <footer class="px-4 pb-6">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 text-sm text-slate-500 md:flex-row">
            <div>
                © {{ date('Y') }}
                <span class="font-black text-[#0B1F3A]">PT Pro Energi</span>.
                All rights reserved.
            </div>

            <div class="font-semibold">
                Service Management Portal · Internal Platform
            </div>
        </div>
    </footer>

</div>

</body>
</html>