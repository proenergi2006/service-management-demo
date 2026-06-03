<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Admin IT</title>
    <link rel="icon" type="image/png" href="{{ asset('images/proenergi-logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/themes/light-border.css" />

    <style>
        :root {
            --sap-primary: #0a6ed1;
            --sap-shell: #354a5f;
            --sap-bg: #f5f6f7;
            --sap-border: #d9d9d9;
            --sap-text: #32363a;
            --sap-muted: #6a6d70;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: var(--sap-bg);
            color: var(--sap-text);
            font-family: 'Figtree', sans-serif;
        }

        body {
            min-height: 100vh;
        }

        .sap-app-shell {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
            background: linear-gradient(180deg, #f5f6f7 0%, #eef1f4 100%);
        }

        .sap-page-header {
            background: #ffffff;
            border-bottom: 1px solid var(--sap-border);
            box-shadow: 0 1px 4px rgba(15, 23, 42, .06);
            position: relative;
            z-index: 5;
        }

        .sap-page-header-inner {
            width: 100%;
            max-width: 1700px;
            margin: 0 auto;
            padding: 18px 32px;
        }

        .sap-main {
            width: 100%;
            max-width: 1700px;
            margin: 0 auto;
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .sap-footer {
            margin-top: auto;
            background: #354a5f;
            border-top: 1px solid rgba(255,255,255,.12);
            color: #ffffff;
            position: relative;
            z-index: 20;
            width: 100%;
            overflow: hidden;
        }

        .sap-footer-inner {
            width: 100%;
            max-width: 1700px;
            margin: 0 auto;
            padding: 22px 32px;
        }

        .sap-footer-logo {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #ffffff;
            padding: 7px;
            flex-shrink: 0;
            box-shadow: 0 1px 5px rgba(15,23,42,.20);
        }

        .sap-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            background: rgba(255,255,255,.10);
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 800;
            color: #e5edf3;
            border: 1px solid rgba(255,255,255,.14);
            white-space: nowrap;
        }

        .sap-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #2eb67d;
            box-shadow: 0 0 0 3px rgba(46,182,125,.18);
            flex-shrink: 0;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 8px;
            transition: all .2s ease;
        }

        .tippy-box[data-theme~='light-border'] {
            border-radius: 8px;
            font-size: 12px;
            color: #32363a;
            box-shadow: 0 8px 24px rgba(15,23,42,.16);
        }

        .sap-page-loader {
            position: fixed;
            inset: 0;
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(245, 246, 247, .82);
            backdrop-filter: blur(6px);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity .25s ease, visibility .25s ease;
        }

        .sap-page-loader.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .sap-loader-card {
            width: 320px;
            border-radius: 16px;
            border: 1px solid #d9d9d9;
            background: #ffffff;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .20);
            overflow: hidden;
            animation: sapLoaderPop .28s ease forwards;
        }

        .sap-loader-bar {
            height: 5px;
            width: 100%;
            background: linear-gradient(90deg, #0a6ed1, #64b5f6, #0a6ed1);
            background-size: 200% 100%;
            animation: sapLoaderMove 1s linear infinite;
        }

        .sap-loader-body {
            padding: 22px;
            text-align: center;
        }

        .sap-loader-spinner {
            width: 42px;
            height: 42px;
            margin: 0 auto 14px;
            border-radius: 999px;
            border: 4px solid #d9d9d9;
            border-top-color: #0a6ed1;
            animation: sapSpin .8s linear infinite;
        }

        @keyframes sapLoaderMove {
            from { background-position: 200% 0; }
            to { background-position: -200% 0; }
        }

        @keyframes sapSpin {
            to { transform: rotate(360deg); }
        }

        @keyframes sapLoaderPop {
            from {
                opacity: 0;
                transform: translateY(10px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 768px) {
            .sap-page-header-inner {
                padding: 16px;
            }

            .sap-main {
                width: 100%;
                overflow-x: hidden;
            }

            .sap-footer {
                margin-top: 24px;
            }

            .sap-footer-inner {
                padding: 20px 16px;
            }

            .sap-footer-content {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 20px;
            }

            .sap-footer-brand,
            .sap-footer-status,
            .sap-footer-right {
                width: 100%;
            }

            .sap-footer-right {
                align-items: flex-start !important;
            }

            .sap-status-pill {
                width: fit-content;
                max-width: 100%;
                font-size: 11px;
            }

            .sap-loader-card {
                width: calc(100% - 32px);
            }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div id="sapPageLoader" class="sap-page-loader">
        <div class="sap-loader-card">
            <div class="sap-loader-bar"></div>

            <div class="sap-loader-body">
                <div class="sap-loader-spinner"></div>

                <div class="text-sm font-black text-slate-800">
                    Loading Page
                </div>

                <div class="mt-1 text-xs font-semibold text-slate-500">
                    Mohon tunggu sebentar...
                </div>
            </div>
        </div>
    </div>

    <div class="sap-app-shell">

        @include('layouts.navigation')

        @isset($header)
            <header class="sap-page-header">
                <div class="sap-page-header-inner">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="sap-main">
            {{ $slot }}
        </main>

        <footer class="sap-footer">
            <div class="sap-footer-inner">
                <div class="sap-footer-content flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                    <div class="sap-footer-brand flex items-center gap-4">
                        <div class="sap-footer-logo">
                            <img src="{{ asset('images/proenergi-logo.png') }}"
                                 alt="Pro Energi"
                                 class="h-full w-full object-contain">
                        </div>

                        <div class="min-w-0">
                            <div class="sap-footer-title text-sm font-black tracking-tight text-white">
                                Pro Energi Enterprise Service Management
                            </div>

                            <div class="sap-footer-subtitle mt-1 text-xs font-medium text-slate-300">
                                IT Helpdesk · Facility Booking · Asset Lifecycle · Guest Management
                            </div>
                        </div>
                    </div>

                    <div class="sap-footer-status flex flex-wrap items-center gap-2">
                        <span class="sap-status-pill">
                            <span class="sap-status-dot"></span>
                            Service Online
                        </span>

                        <span class="sap-status-pill">
                            Internal Platform
                        </span>
                    </div>

                    <div class="sap-footer-right flex flex-col gap-1 md:items-end">
                        <div class="sap-footer-copy text-sm text-slate-200">
                            © {{ date('Y') }}
                            <span class="font-black text-white">PT Pro Energi</span>.
                            All rights reserved.
                        </div>

                        <div class="sap-footer-powered text-xs text-slate-300">
                            Powered by IT Department · {{ config('app.name', 'Laravel') }}
                        </div>
                    </div>

                </div>
            </div>
        </footer>

    </div>

    @stack('scripts')

    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.tippy) {
                tippy('[data-tippy-content]', {
                    animation: 'shift-away',
                    theme: 'light-border',
                    delay: [100, 50],
                    placement: 'top',
                });
            }
        
            const loader = document.getElementById('sapPageLoader');
            if (!loader) return;
        
            function showPageLoaderNow() {
                loader.classList.add('show');
            }
        
            function hidePageLoader() {
                loader.classList.remove('show');
            }
        
            document.addEventListener('click', function (event) {
                const link = event.target.closest('a');
                if (!link) return;
        
                const href = link.getAttribute('href');
        
                if (!href) return;
                if (href === '#') return;
                if (href.startsWith('javascript:')) return;
                if (href.startsWith('mailto:')) return;
                if (href.startsWith('tel:')) return;
                if (link.target === '_blank') return;
                if (link.hasAttribute('download')) return;
                if (link.dataset.noLoader === 'true') return;
        
                if (event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
        
                let linkUrl;
        
                try {
                    linkUrl = new URL(href, window.location.href);
                } catch (e) {
                    return;
                }
        
                if (linkUrl.host !== window.location.host) return;
        
                if (linkUrl.pathname === window.location.pathname && linkUrl.hash) return;
        
                event.preventDefault();
        
                showPageLoaderNow();
        
                setTimeout(() => {
                    window.location.href = link.href;
                }, 700);
            });
        
            document.addEventListener('submit', function (event) {
                const form = event.target;
        
                if (!form) return;
                if (form.dataset.noLoader === 'true') return;
                if (form.dataset.submitted === 'true') return;
        
                event.preventDefault();
        
                form.dataset.submitted = 'true';
        
                showPageLoaderNow();
        
                setTimeout(() => {
                    form.submit();
                }, 700);
            });
        
            window.addEventListener('pageshow', function () {
                hidePageLoader();
            });
        
            window.addEventListener('load', function () {
                hidePageLoader();
            });
        
            window.addEventListener('popstate', function () {
                hidePageLoader();
            });
        });
        </script>
</body>

</html>