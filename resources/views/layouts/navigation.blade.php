<nav x-data="{ open: false }" class="sticky top-0 z-50">
    <style>
        [x-cloak] { display: none !important; }

        .sap-shell {
            height: 64px;
            background: #354a5f;
            border-bottom: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 2px 10px rgba(15,23,42,.18);
        }

        .sap-logo {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #ffffff;
            padding: 6px;
            box-shadow: 0 1px 4px rgba(15,23,42,.15);
        }

        .sap-nav-btn {
            height: 38px;
            padding: 0 13px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #d5dadd;
            transition: .15s ease;
            white-space: nowrap;
        }

        .sap-nav-btn:hover {
            background: rgba(255,255,255,.10);
            color: #ffffff;
        }

        .sap-nav-active {
            background: #0a6ed1 !important;
            color: #ffffff !important;
        }

        .sap-icon {
            width: 18px;
            height: 18px;
            color: currentColor;
            opacity: .95;
        }

        .sap-dropdown {
            position: absolute;
            left: 0;
            margin-top: 10px;
            width: 340px;
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 12px;
            box-shadow: 0 16px 42px rgba(15,23,42,.18);
            overflow: hidden;
            z-index: 70;
        }

        .sap-dropdown-section {
            padding: 10px 16px;
            background: #f5f6f7;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .08em;
            color: #6a6d70;
            text-transform: uppercase;
        }

        .sap-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 650;
            color: #32363a;
            transition: .15s ease;
        }

        .sap-dropdown-item:hover {
            background: #f5f9ff;
            color: #0a6ed1;
        }

        .sap-dropdown-active {
            background: #eaf3ff !important;
            color: #0a6ed1 !important;
            font-weight: 900;
            border-left: 4px solid #0a6ed1;
            padding-left: 12px;
        }

        .sap-divider {
            border-top: 1px solid #edf0f2;
        }

        .sap-user {
            border-left: 1px solid rgba(255,255,255,.16);
            padding-left: 16px;
        }

        .sap-avatar {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: rgba(255,255,255,.13);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #ffffff;
        }

        .sap-status {
            height: 8px;
            width: 8px;
            border-radius: 999px;
            background: #2eb67d;
            box-shadow: 0 0 0 3px rgba(46,182,125,.18);
        }

        .sap-mobile-link {
            display: block;
            border-radius: 10px;
            background: rgba(255,255,255,.08);
            padding: 12px 14px;
            color: #e5e7eb;
            font-size: 14px;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,.10);
        }

        .sap-mobile-section {
            padding-top: 12px;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: #aeb6be;
        }
    </style>

    @php
        $userRole = strtoupper(auth()->user()->role ?? '');
        $assetOnlyRoles = ['GA', 'LOGISTIK'];
        $isAssetOnlyRole = in_array($userRole, $assetOnlyRoles);

        $adminRoles = ['it', 'admin_it', 'support', 'ga', 'admin_ga'];
        $canManageFacility = in_array(auth()->user()->role ?? '', $adminRoles);
    @endphp

    <div class="sap-shell">
        <div class="mx-auto max-w-[1700px] px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">

                {{-- LEFT --}}
                <div class="flex min-w-0 items-center gap-6">

                    {{-- BRAND --}}
                    <a href="{{ route('dashboard') }}" class="flex shrink-0 items-center gap-3">
                        <div class="sap-logo">
                            <img src="{{ asset('images/proenergi-logo.png') }}"
                                 alt="Pro Energi Logo"
                                 class="h-full w-full object-contain">
                        </div>

                        <div class="hidden xl:block leading-tight">
                            <div class="text-[11px] font-bold tracking-wide text-slate-300">
                                PRO ENERGI
                            </div>
                            <div class="text-sm font-black text-white">
                                Enterprise Service Management
                            </div>
                        </div>
                    </a>

                    {{-- DESKTOP MENU --}}
                    <div class="hidden items-center gap-1 sm:flex">

                        @if(!$isAssetOnlyRole)
                            <a href="{{ route('dashboard') }}"
                               class="sap-nav-btn {{ request()->routeIs('dashboard') ? 'sap-nav-active' : '' }}">
                                <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h8V3H3v10.5zM13 21h8V10.5h-8V21zM3 21h8v-5.5H3V21zM13 8.5h8V3h-8v5.5z"/>
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            <a href="{{ route('trend') }}"
                               class="sap-nav-btn {{ request()->routeIs('trend') ? 'sap-nav-active' : '' }}">
                                <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 7-9M14 6h6v6"/>
                                </svg>
                                <span>Trend</span>
                            </a>
                        @endif

                        {{-- ASSETS --}}
                        <div x-data="{ openAssets: false }" class="relative">
                            <button type="button"
                                    @click="openAssets = !openAssets"
                                    @click.outside="openAssets = false"
                                    class="sap-nav-btn {{ request()->routeIs('assets.*') ? 'sap-nav-active' : '' }}">
                                <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5L12 3 3 7.5m18 0V16.5L12 21m9-13.5L12 12m0 9V12m0 0L3 7.5"/>
                                </svg>
                                <span>Assets</span>
                                <svg class="h-4 w-4 transition" :class="openAssets ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9.75l-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </button>

                            <div x-cloak x-show="openAssets" x-transition class="sap-dropdown">
                                <div class="sap-dropdown-section">Dashboard</div>

                                <a href="{{ route('assets.dashboard') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.dashboard') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h8V3H3v10.5zM13 21h8V10.5h-8V21zM3 21h8v-5.5H3V21zM13 8.5h8V3h-8v5.5z"/>
                                    </svg>
                                    <span>Dashboard Assets</span>
                                </a>

                                <div class="sap-divider"></div>
                                {{-- <div class="sap-dropdown-section">Operations</div> --}}
{{-- 
                                <a href="{{ route('assets.work-orders.index') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.work-orders.*') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.83-5.83M11.42 15.17l2.47-2.47a3.375 3.375 0 00-4.77-4.77L6.65 10.4m4.77 4.77L6.65 10.4m0 0L3 14.06V21h6.94l3.66-3.65"/>
                                    </svg>
                                    <span>Work Order</span>
                                </a>

                                <a href="{{ route('assets.schedules.index') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.schedules.*') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5A1.5 1.5 0 0120.25 6.75v12A1.5 1.5 0 0118.75 20.25H5.25A1.5 1.5 0 013.75 18.75v-12A1.5 1.5 0 015.25 5.25z"/>
                                    </svg>
                                    <span>PM Schedule</span>
                                </a>

                                <a href="{{ route('assets.audits.index') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.audits.*') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2 2 4-4M4.5 6.75h15M6.75 3.75h10.5A1.5 1.5 0 0118.75 5.25v15A1.5 1.5 0 0117.25 21H6.75A1.5 1.5 0 015.25 19.5V5.25A1.5 1.5 0 016.75 3.75z"/>
                                    </svg>
                                    <span>Asset Audit</span>
                                </a> --}}

                                <div class="sap-divider"></div>
                                <div class="sap-dropdown-section">Master Data</div>

                                <a href="{{ route('assets.index') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.index') || request()->routeIs('assets.show') || request()->routeIs('assets.create') || request()->routeIs('assets.edit') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5L12 3 3 7.5m18 0V16.5L12 21m9-13.5L12 12m0 9V12m0 0L3 7.5"/>
                                    </svg>
                                    <span>Asset Master</span>
                                </a>

                                {{-- <a href="{{ route('assets.spareparts.index') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.spareparts.*') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.558-.94 1.108-.94h2.596c.55 0 1.018.398 1.108.94l.213 1.281c.063.374.313.686.645.87.19.105.376.214.558.33.326.21.738.24 1.08.099l1.19-.492a1.125 1.125 0 011.45.584l1.298 2.247a1.125 1.125 0 01-.296 1.507l-1.003.788c-.298.234-.438.613-.43.992a7.7 7.7 0 010 .708c-.008.379.132.758.43.992l1.003.788c.46.361.58 1.007.296 1.507l-1.298 2.247a1.125 1.125 0 01-1.45.584l-1.19-.492c-.342-.141-.754-.111-1.08.099a7.3 7.3 0 01-.558.33c-.332.184-.582.496-.645.87l-.213 1.281c-.09.542-.558.94-1.108.94h-2.596c-.55 0-1.018-.398-1.108-.94l-.213-1.281c-.063-.374-.313-.686-.645-.87a7.3 7.3 0 01-.558-.33c-.326-.21-.738-.24-1.08-.099l-1.19.492a1.125 1.125 0 01-1.45-.584L3.16 15.117a1.125 1.125 0 01.296-1.507l1.003-.788c.298-.234.438-.613.43-.992a7.7 7.7 0 010-.708c.008-.379-.132-.758-.43-.992l-1.003-.788A1.125 1.125 0 013.16 8.883L4.458 6.636a1.125 1.125 0 011.45-.584l1.19.492c.342.141.754.111 1.08-.099.182-.116.368-.225.558-.33.332-.184.582-.496.645-.87l.213-1.281z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>Sparepart Master</span>
                                </a> --}}

                                {{-- <a href="{{ route('assets.vendors.index') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.vendors.*') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                                    </svg>
                                    <span>Vendor Maintenance</span>
                                </a> --}}

                                <div class="sap-divider"></div>
                                {{-- <div class="sap-dropdown-section">Reports</div>

                                <a href="{{ route('assets.reports.maintenance-cost') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.reports.maintenance-cost') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m3-9.75A3 3 0 009.75 6.75H9a3 3 0 000 6h6a3 3 0 010 6h-.75A3 3 0 019 15.75"/>
                                    </svg>
                                    <span>Maintenance Cost</span>
                                </a>

                                <a href="{{ route('assets.reports.reliability') }}"
                                   class="sap-dropdown-item {{ request()->routeIs('assets.reports.reliability') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14l3-3 3 2 4-5"/>
                                    </svg>
                                    <span>Reliability Report</span>
                                </a> --}}
                            </div>
                        </div>

                        {{-- FACILITY --}}
                        <div x-data="{ openFacility: false }" class="relative">
                            {{-- <button type="button"
                                    @click="openFacility = !openFacility"
                                    @click.outside="openFacility = false"
                                    class="sap-nav-btn {{ request()->routeIs('room-bookings.*') || request()->routeIs('vehicle-bookings.*') || request()->routeIs('master-rooms.*') || request()->routeIs('master-vehicles.*') || request()->routeIs('guests.*') || request()->routeIs('ga.dashboard') ? 'sap-nav-active' : '' }}">
                                <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                                </svg>
                                <span>Facility</span>
                                <svg class="h-4 w-4 transition" :class="openFacility ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9.75l-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </button> --}}

                            {{-- <div x-cloak x-show="openFacility" x-transition class="sap-dropdown">
                                <div class="sap-dropdown-section">Dashboard</div>

                                <a href="{{ route('ga.dashboard') }}" class="sap-dropdown-item {{ request()->routeIs('ga.dashboard') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.5h8V3H3v10.5zM13 21h8V10.5h-8V21zM3 21h8v-5.5H3V21zM13 8.5h8V3h-8v5.5z"/>
                                    </svg>
                                    <span>Dashboard GA</span>
                                </a>

                                <div class="sap-divider"></div>
                                <div class="sap-dropdown-section">Booking</div>

                                <a href="{{ route('room-bookings.create') }}" class="sap-dropdown-item">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 21V5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25V21M9 7.5h1.5M9 11.25h1.5M9 15h1.5M13.5 7.5H15M13.5 11.25H15M13.5 15H15"/>
                                    </svg>
                                    <span>Booking Ruangan</span>
                                </a>

                                <a href="{{ route('room-bookings.my') }}" class="sap-dropdown-item {{ request()->routeIs('room-bookings.my') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5A1.5 1.5 0 0120.25 6.75v12A1.5 1.5 0 0118.75 20.25H5.25A1.5 1.5 0 013.75 18.75v-12A1.5 1.5 0 015.25 5.25z"/>
                                    </svg>
                                    <span>Booking Ruangan Saya</span>
                                </a>

                                <a href="{{ route('vehicle-bookings.create') }}" class="sap-dropdown-item">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM18.75 18.75a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3.75 15.75h16.5l-1.5-6A2.25 2.25 0 0016.57 8.25H7.43a2.25 2.25 0 00-2.18 1.5l-1.5 6z"/>
                                    </svg>
                                    <span>Booking Kendaraan</span>
                                </a>

                                <a href="{{ route('vehicle-bookings.my') }}" class="sap-dropdown-item {{ request()->routeIs('vehicle-bookings.my') ? 'sap-dropdown-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5A1.5 1.5 0 0120.25 6.75v12A1.5 1.5 0 0118.75 20.25H5.25A1.5 1.5 0 013.75 18.75v-12A1.5 1.5 0 015.25 5.25z"/>
                                    </svg>
                                    <span>Booking Kendaraan Saya</span>
                                </a>

                                @if($canManageFacility)
                                    <div class="sap-divider"></div>
                                    <div class="sap-dropdown-section">Approval</div>

                                    <a href="{{ route('room-bookings.index') }}" class="sap-dropdown-item {{ request()->routeIs('room-bookings.index') ? 'sap-dropdown-active' : '' }}">
                                        <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2 2 4-4M4.5 6.75h15M6.75 3.75h10.5A1.5 1.5 0 0118.75 5.25v15A1.5 1.5 0 0117.25 21H6.75A1.5 1.5 0 015.25 19.5V5.25A1.5 1.5 0 016.75 3.75z"/>
                                        </svg>
                                        <span>Approval Ruangan</span>
                                    </a>

                                    <a href="{{ route('vehicle-bookings.index') }}" class="sap-dropdown-item {{ request()->routeIs('vehicle-bookings.index') ? 'sap-dropdown-active' : '' }}">
                                        <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l2 2 4-4M4.5 6.75h15M6.75 3.75h10.5A1.5 1.5 0 0118.75 5.25v15A1.5 1.5 0 0117.25 21H6.75A1.5 1.5 0 015.25 19.5V5.25A1.5 1.5 0 016.75 3.75z"/>
                                        </svg>
                                        <span>Approval Kendaraan</span>
                                    </a>

                                    <div class="sap-divider"></div>
                                    <div class="sap-dropdown-section">Guest Management</div>

                                    <a href="{{ route('guest.check-in') }}" class="sap-dropdown-item">
                                        <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 21a7.5 7.5 0 0115 0"/>
                                        </svg>
                                        <span>Guest Check-In</span>
                                    </a>

                                    <a href="{{ route('guests.index') }}" class="sap-dropdown-item {{ request()->routeIs('guests.*') ? 'sap-dropdown-active' : '' }}">
                                        <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 6.75h15M4.5 12h15M4.5 17.25h15"/>
                                        </svg>
                                        <span>Daftar Tamu</span>
                                    </a>

                                    <div class="sap-divider"></div>
                                    <div class="sap-dropdown-section">Master Data</div>

                                    <a href="{{ route('master-rooms.index') }}" class="sap-dropdown-item {{ request()->routeIs('master-rooms.*') ? 'sap-dropdown-active' : '' }}">
                                        <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 21V5.25A2.25 2.25 0 016.75 3h10.5a2.25 2.25 0 012.25 2.25V21"/>
                                        </svg>
                                        <span>Master Ruangan</span>
                                    </a>

                                    <a href="{{ route('master-vehicles.index') }}" class="sap-dropdown-item {{ request()->routeIs('master-vehicles.*') ? 'sap-dropdown-active' : '' }}">
                                        <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM18.75 18.75a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3.75 15.75h16.5l-1.5-6A2.25 2.25 0 0016.57 8.25H7.43a2.25 2.25 0 00-2.18 1.5l-1.5 6z"/>
                                        </svg>
                                        <span>Master Kendaraan</span>
                                    </a>
                                @endif
                            </div> --}}
                        </div>

                        @if(!$isAssetOnlyRole)
                            {{-- REPORT --}}
                            <div x-data="{ openReport: false }" class="relative">
                                <button type="button"
                                        @click="openReport = !openReport"
                                        @click.outside="openReport = false"
                                        class="sap-nav-btn {{ request()->routeIs('reports.*') || request()->routeIs('user-access-management.*') ? 'sap-nav-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14l3-3 3 2 4-5"/>
                                    </svg>
                                    <span>Report</span>
                                    <svg class="h-4 w-4 transition" :class="openReport ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9.75l-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </button>

                                <div x-cloak x-show="openReport" x-transition class="sap-dropdown !w-72">
                                    <a href="{{ route('reports.index') }}" class="sap-dropdown-item">Report Ticket</a>
                                    <a href="{{ route('reports.feedback') }}" class="sap-dropdown-item">Report Feedback</a>
                                    <a href="{{ route('reports.sla') }}" class="sap-dropdown-item">SLA Report</a>
                                    <div class="sap-divider"></div>
                                    <a href="{{ route('user-access-management.index') }}" class="sap-dropdown-item">User Management</a>
                                </div>
                            </div>

                            {{-- PROJECTS --}}
                            <div x-data="{ openProjects: false }" class="relative">
                                <button type="button"
                                        @click="openProjects = !openProjects"
                                        @click.outside="openProjects = false"
                                        class="sap-nav-btn {{ request()->routeIs('projects.*') ? 'sap-nav-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5A1.5 1.5 0 014.5 6h4.379a1.5 1.5 0 011.06.44l1.12 1.12A1.5 1.5 0 0012.12 8H19.5A1.5 1.5 0 0121 9.5v8A1.5 1.5 0 0119.5 19h-15A1.5 1.5 0 013 17.5v-10z"/>
                                    </svg>
                                    <span>Projects</span>
                                    <svg class="h-4 w-4 transition" :class="openProjects ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9.75l-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </button>

                                <div x-cloak x-show="openProjects" x-transition class="sap-dropdown !w-64">
                                    <a href="{{ route('projects.index') }}" class="sap-dropdown-item">Project List</a>
                                    <a href="{{ route('projects.board') }}" class="sap-dropdown-item">Kanban Board</a>
                                </div>
                            </div>

                            {{-- KNOWLEDGE --}}
                            <div x-data="{ openDocs: false }" class="relative">
                                <button type="button"
                                        @click="openDocs = !openDocs"
                                        @click.outside="openDocs = false"
                                        class="sap-nav-btn {{ request()->routeIs('documents.*') || request()->routeIs('meetings.*') ? 'sap-nav-active' : '' }}">
                                    <svg class="sap-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5 5.754 5 4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18c1.746 0 3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span>Knowledge</span>
                                    <svg class="h-4 w-4 transition" :class="openDocs ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 9.75l-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </button>

                                <div x-cloak x-show="openDocs" x-transition class="sap-dropdown !w-64">
                                    <a href="{{ route('documents.index') }}" class="sap-dropdown-item">Dokumentasi</a>
                                    <a href="{{ route('meetings.index') }}" class="sap-dropdown-item">Meeting MoM</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="sap-user hidden items-center gap-4 sm:flex">
                    <div class="hidden items-center gap-2 text-xs font-bold text-slate-300 md:inline-flex">
                        <span class="sap-status"></span>
                        <span>System Online</span>
                    </div>

                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-3 rounded-lg px-2 py-1 transition hover:bg-white/10">
                                    <span class="sap-avatar">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>

                                    <div class="hidden text-left leading-tight lg:block">
                                        <div class="text-sm font-black text-white">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-slate-300">{{ auth()->user()->email }}</div>
                                    </div>

                                    <svg class="h-4 w-4 text-slate-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="overflow-hidden rounded-xl bg-white text-slate-700 ring-1 ring-slate-200">
                                    <div class="border-b border-slate-100 px-4 py-3">
                                        <div class="text-sm font-black text-slate-800">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                                    </div>

                                    <x-dropdown-link :href="route('profile.edit')" class="hover:!bg-blue-50 hover:!text-blue-700">
                                        Profile
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                         class="hover:!bg-red-50 hover:!text-red-700"
                                                         onclick="event.preventDefault(); this.closest('form').submit();">
                                            Log Out
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    @endauth
                </div>

                {{-- MOBILE TOGGLE --}}
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open"
                            class="inline-flex items-center justify-center rounded-lg bg-white/10 p-2 text-white ring-1 ring-white/10 transition hover:bg-white/15 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div :class="{ 'block': open, 'hidden': !open }"
         class="hidden border-t border-white/10 bg-[#354a5f] px-4 pb-4 pt-3 sm:hidden">

        <div class="space-y-2">
            @if(!$isAssetOnlyRole)
                <a href="{{ route('dashboard') }}" class="sap-mobile-link">Dashboard</a>
                <a href="{{ route('trend') }}" class="sap-mobile-link">Trend</a>
            @endif

            <div class="sap-mobile-section">Assets</div>
            <a href="{{ route('assets.dashboard') }}" class="sap-mobile-link">Dashboard Assets</a>
            <a href="{{ route('assets.work-orders.index') }}" class="sap-mobile-link">Work Order</a>
            <a href="{{ route('assets.schedules.index') }}" class="sap-mobile-link">PM Schedule</a>
            <a href="{{ route('assets.audits.index') }}" class="sap-mobile-link">Asset Audit</a>
            <a href="{{ route('assets.index') }}" class="sap-mobile-link">Asset Master</a>
            <a href="{{ route('assets.spareparts.index') }}" class="sap-mobile-link">Sparepart Master</a>
            <a href="{{ route('assets.vendors.index') }}" class="sap-mobile-link">Vendor Maintenance</a>
            <a href="{{ route('assets.reports.maintenance-cost') }}" class="sap-mobile-link">Maintenance Cost</a>
            <a href="{{ route('assets.reports.reliability') }}" class="sap-mobile-link">Reliability Report</a>

            <div class="sap-mobile-section">Facility</div>
            <a href="{{ route('ga.dashboard') }}" class="sap-mobile-link">Dashboard GA</a>
            <a href="{{ route('room-bookings.create') }}" class="sap-mobile-link">Booking Ruangan</a>
            <a href="{{ route('room-bookings.my') }}" class="sap-mobile-link">Booking Ruangan Saya</a>
            <a href="{{ route('vehicle-bookings.create') }}" class="sap-mobile-link">Booking Kendaraan</a>
            <a href="{{ route('vehicle-bookings.my') }}" class="sap-mobile-link">Booking Kendaraan Saya</a>

            @if($canManageFacility)
                <div class="sap-mobile-section">Approval</div>
                <a href="{{ route('room-bookings.index') }}" class="sap-mobile-link">Approval Ruangan</a>
                <a href="{{ route('vehicle-bookings.index') }}" class="sap-mobile-link">Approval Kendaraan</a>

                <div class="sap-mobile-section">Guest Management</div>
                <a href="{{ route('guest.check-in') }}" class="sap-mobile-link">Guest Check-In</a>
                <a href="{{ route('guests.index') }}" class="sap-mobile-link">Daftar Tamu</a>

                <div class="sap-mobile-section">Master Data</div>
                <a href="{{ route('master-rooms.index') }}" class="sap-mobile-link">Master Ruangan</a>
                <a href="{{ route('master-vehicles.index') }}" class="sap-mobile-link">Master Kendaraan</a>
            @endif

            @if(!$isAssetOnlyRole)
                <div class="sap-mobile-section">Report</div>
                <a href="{{ route('reports.index') }}" class="sap-mobile-link">Report Ticket</a>
                <a href="{{ route('reports.feedback') }}" class="sap-mobile-link">Report Feedback</a>
                <a href="{{ route('reports.sla') }}" class="sap-mobile-link">SLA Report</a>
                <a href="{{ route('user-access-management.index') }}" class="sap-mobile-link">User Management</a>

                <div class="sap-mobile-section">Projects</div>
                <a href="{{ route('projects.index') }}" class="sap-mobile-link">Project List</a>
                <a href="{{ route('projects.board') }}" class="sap-mobile-link">Kanban Board</a>

                <div class="sap-mobile-section">Knowledge</div>
                <a href="{{ route('documents.index') }}" class="sap-mobile-link">Dokumentasi</a>
                <a href="{{ route('meetings.index') }}" class="sap-mobile-link">Meeting MoM</a>
            @endif

            @auth
                <div class="mt-4 rounded-xl border border-white/10 bg-white/10 p-4">
                    <div class="text-sm font-black text-white">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-slate-300">{{ auth()->user()->email }}</div>

                    <div class="mt-3 space-y-2">
                        <a href="{{ route('profile.edit') }}" class="sap-mobile-link">Profile</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sap-mobile-link w-full text-left">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>