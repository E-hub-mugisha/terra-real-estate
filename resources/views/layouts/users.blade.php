<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Terra Consultant</title>

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════════
           DESIGN TOKENS
        ══════════════════════════════════════════ */
        :root {
            --navy: #19265d;
            --navy-deep: #111c48;
            --navy-mid: #1e2f6e;
            --gold: #D05208;
            --gold-hover: #b8470a;
            --gold-pale: rgba(208, 82, 8, .09);
            --cream: #f7f5f1;
            --white: #ffffff;
            --muted: #7b849a;
            --border: rgba(25, 38, 93, .09);
            --sidebar-w: 258px;
            --header-h: 66px;
            --radius: 12px;
            --shadow-sm: 0 1px 4px rgba(25, 38, 93, .06), 0 2px 12px rgba(25, 38, 93, .05);
            --shadow-md: 0 4px 24px rgba(25, 38, 93, .10), 0 1px 4px rgba(25, 38, 93, .05);
            --transition: .2s cubic-bezier(.4, 0, .2, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--navy);
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: inherit;
            cursor: pointer;
        }

        /* ══════════════════════════════════════════
           LAYOUT SHELL
        ══════════════════════════════════════════ */
        .layout {
            display: grid;
            grid-template-columns: var(--sidebar-w) 1fr;
            grid-template-rows: var(--header-h) 1fr;
            min-height: 100vh;
        }

        /* ══════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════ */
        .sidebar {
            grid-row: 1 / -1;
            background: var(--navy);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-w);
            z-index: 200;
            overflow: hidden;
        }

        /* Subtle noise texture overlay */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3CfeColorMatrix type='saturate' values='0'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: .4;
            pointer-events: none;
        }

        /* Gold glow at bottom-right */
        .sidebar::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(208, 82, 8, .22) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Brand ── */
        .sidebar-brand {
            padding: 1.5rem 1.5rem 1rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            position: relative;
            z-index: 1;
        }

        .brand-mark {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(208, 82, 8, .4);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
            letter-spacing: .01em;
        }

        .brand-role {
            font-size: .68rem;
            font-weight: 500;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .35);
        }

        /* ── Nav sections ── */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
            position: relative;
            z-index: 1;
            scrollbar-width: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .nav-section {
            margin-bottom: .25rem;
        }

        .nav-section-label {
            font-size: .63rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .25);
            padding: 1rem 1.5rem .4rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .62rem 1.5rem;
            color: rgba(255, 255, 255, .55);
            font-size: .87rem;
            font-weight: 400;
            position: relative;
            transition: color var(--transition), background var(--transition);
            cursor: pointer;
        }

        .nav-item:hover {
            color: rgba(255, 255, 255, .9);
            background: rgba(255, 255, 255, .05);
        }

        .nav-item.active {
            color: #fff;
            background: rgba(255, 255, 255, .07);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: var(--gold);
            border-radius: 0 3px 3px 0;
        }

        .nav-item svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            opacity: .7;
            transition: opacity var(--transition);
        }

        .nav-item:hover svg,
        .nav-item.active svg {
            opacity: 1;
        }

        /* Badge on nav item */
        .nav-badge {
            margin-left: auto;
            background: var(--gold);
            color: #fff;
            font-size: .68rem;
            font-weight: 600;
            padding: .1rem .45rem;
            border-radius: 50px;
            min-width: 18px;
            text-align: center;
        }

        /* ── Sidebar footer (profile) ── */
        .sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, .07);
            padding: 1rem 1.25rem;
            position: relative;
            z-index: 1;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem .75rem;
            border-radius: 10px;
            transition: background var(--transition);
            cursor: pointer;
        }

        .sidebar-profile:hover {
            background: rgba(255, 255, 255, .06);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--navy-mid));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            flex-shrink: 0;
            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
            min-width: 0;
        }

        .profile-name {
            font-size: .85rem;
            font-weight: 500;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-label {
            font-size: .72rem;
            color: rgba(255, 255, 255, .35);
            margin-top: .05rem;
        }

        .profile-arrow {
            color: rgba(255, 255, 255, .3);
            transition: color var(--transition);
        }

        .sidebar-profile:hover .profile-arrow {
            color: rgba(255, 255, 255, .6);
        }

        /* ══════════════════════════════════════════
           HEADER
        ══════════════════════════════════════════ */
        .header {
            grid-column: 2;
            height: var(--header-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        /* Mobile toggle */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--navy);
            padding: .4rem;
            border-radius: 8px;
            transition: background var(--transition);
        }

        .sidebar-toggle:hover {
            background: var(--cream);
        }

        /* Page title breadcrumb */
        .header-title {
            display: flex;
            flex-direction: column;
            gap: .05rem;
        }

        .header-page {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--navy);
            line-height: 1;
        }

        .header-breadcrumb {
            font-size: .72rem;
            color: var(--muted);
        }

        .header-breadcrumb span {
            color: var(--gold);
        }

        .header-spacer {
            flex: 1;
        }

        /* Search bar */
        .header-search {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: .42rem .85rem;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .header-search:focus-within {
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(25, 38, 93, .06);
        }

        .header-search svg {
            color: var(--muted);
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }

        .header-search input {
            background: none;
            border: none;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: .85rem;
            color: var(--navy);
            width: 180px;
        }

        .header-search input::placeholder {
            color: var(--muted);
        }

        /* Header action buttons */
        .header-actions {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .hdr-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--cream);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            cursor: pointer;
            position: relative;
            transition: all var(--transition);
        }

        .hdr-btn:hover {
            background: var(--navy);
            color: #fff;
            border-color: var(--navy);
        }

        .hdr-btn svg {
            width: 17px;
            height: 17px;
        }

        .hdr-notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--gold);
            border: 1.5px solid var(--white);
        }

        /* Header profile chip */
        .hdr-profile {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .35rem .75rem .35rem .35rem;
            border: 1px solid var(--border);
            border-radius: 50px;
            background: var(--cream);
            cursor: pointer;
            transition: all var(--transition);
            position: relative;
        }

        .hdr-profile:hover {
            border-color: var(--navy);
            background: #fff;
        }

        .hdr-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--navy));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            font-weight: 600;
            color: #fff;
            overflow: hidden;
        }

        .hdr-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hdr-name {
            font-size: .82rem;
            font-weight: 500;
            color: var(--navy);
        }

        .hdr-chevron {
            color: var(--muted);
        }

        .hdr-chevron svg {
            width: 14px;
            height: 14px;
        }

        /* Header dropdown */
        .hdr-dropdown {
            position: absolute;
            top: calc(100% + .5rem);
            right: 0;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            min-width: 190px;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
            transform: translateY(-6px);
            transition: opacity var(--transition), transform var(--transition);
            z-index: 300;
        }

        .hdr-profile.open .hdr-dropdown {
            opacity: 1;
            pointer-events: all;
            transform: translateY(0);
        }

        .hdr-dropdown-item {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .7rem 1rem;
            font-size: .85rem;
            color: var(--navy);
            transition: background var(--transition);
            cursor: pointer;
        }

        .hdr-dropdown-item:hover {
            background: var(--cream);
        }

        .hdr-dropdown-item svg {
            width: 15px;
            height: 15px;
            color: var(--muted);
        }

        .hdr-dropdown-divider {
            height: 1px;
            background: var(--border);
        }

        .hdr-dropdown-item.danger {
            color: #dc2626;
        }

        .hdr-dropdown-item.danger svg {
            color: #dc2626;
        }

        /* ══════════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════════ */
        .main-content {
            grid-column: 2;
            min-height: calc(100vh - var(--header-h));
            padding: 2rem 2rem 3rem;
            margin-left: 0;
            /* offset handled by grid */
        }

        /* Flash alerts */
        .flash {
            padding: .75rem 1.25rem;
            border-radius: var(--radius);
            font-size: .875rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1.5rem;
        }

        .flash-success {
            background: #d1fae5;
            color: #065f46;
        }

        .flash-error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ══════════════════════════════════════════
           MOBILE OVERLAY
        ══════════════════════════════════════════ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(10, 15, 35, .45);
            z-index: 190;
            backdrop-filter: blur(2px);
        }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform var(--transition);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: block;
                opacity: 0;
                pointer-events: none;
                transition: opacity var(--transition);
            }

            .sidebar-overlay.open {
                opacity: 1;
                pointer-events: all;
            }

            .header {
                grid-column: 1;
            }

            .main-content {
                grid-column: 1;
            }

            .sidebar-toggle {
                display: flex;
            }

            .header-search {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .main-content {
                padding: 1.25rem 1rem 2rem;
            }

            .hdr-name {
                display: none;
            }
        }
    </style>

    
</head>

<body>
    <div class="layout">

        {{-- ═══════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════ --}}
        <aside class="sidebar" id="sidebar">
            {{-- Brand --}}
            <div class="sidebar-brand">
                <div class="brand-mark">T</div>
                <div class="brand-text">
                    <span class="brand-name">Terra</span>
                    <span class="brand-role">Consultant Portal</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar-nav">

                <div class="nav-section">
                    <div class="nav-section-label">Main</div>

                    <a href="{{ route('users.dashboard.index') }}"
                        class="nav-item {{ request()->routeIs('users.dashboard.index') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('consultant.bookings.index') }}"
                        class="nav-item {{ request()->routeIs('consultant.bookings*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Bookings
                        @php $pendingCount = auth()->user()->consultant->bookings()->where('status','pending')->count(); @endphp
                        @if($pendingCount > 0)
                        <span class="nav-badge">{{ $pendingCount }}</span>
                        @endif
                    </a>

                    <a href="{{ route('users.clients.index') }}"
                        class="nav-item {{ request()->routeIs('users.clients*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5.916-3.516M9 20H4v-2a4 4 0 015.916-3.516M15 7a4 4 0 11-8 0 4 4 0 018 0zm6 4a3 3 0 11-6 0 3 3 0 016 0zm-18 0a3 3 0 116 0 3 3 0 01-6 0z" />
                        </svg>
                        Clients
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-label">Services</div>

                    <a href="{{ route('users.tasks.index') }}"
                        class="nav-item {{ request()->routeIs('users.tasks*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        My Tasks
                    </a>
                    <a href="#"
                        class="nav-item {{ request()->routeIs('consultant.services*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        My Services
                    </a>

                    <a href="#"
                        class="nav-item {{ request()->routeIs('consultant.schedule') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Availability
                    </a>

                    <a href="#"
                        class="nav-item {{ request()->routeIs('consultant.earnings') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Earnings
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-label">Account</div>

                    <a href="#"
                        class="nav-item {{ request()->routeIs('consultant.profile') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        My Profile
                    </a>

                    <a href="#"
                        class="nav-item {{ request()->routeIs('consultant.settings') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Settings
                    </a>
                </div>
            </nav>

            {{-- Profile footer --}}
            <div class="sidebar-footer">
                <div class="sidebar-profile">
                    <div class="profile-avatar">
                        @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="">
                        @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->name }}</div>
                        <div class="profile-label">Consultant</div>
                    </div>
                    <svg class="profile-arrow" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </aside>

        {{-- Sidebar overlay (mobile) --}}
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

        {{-- ═══════════════════════════════════
         HEADER
    ═══════════════════════════════════ --}}
        <header class="header">
            {{-- Mobile toggle --}}
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" aria-label="Toggle menu">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Page title --}}
            <div class="header-title">
                <span class="header-page">@yield('page-title', 'Dashboard')</span>
                <span class="header-breadcrumb">Terra &rsaquo; <span>@yield('page-title', 'Dashboard')</span></span>
            </div>

            <div class="header-spacer"></div>

            {{-- Search --}}
            <div class="header-search">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search bookings, clients…">
            </div>

            {{-- Actions --}}
            <div class="header-actions">
                {{-- Notifications --}}
                <button class="hdr-btn" title="Notifications">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-9.33-4.976A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if($pendingCount > 0)<span class="hdr-notif-dot"></span>@endif
                </button>

                {{-- Profile dropdown --}}
                <div class="hdr-profile" id="hdrProfile" onclick="toggleProfileMenu()">
                    <div class="hdr-avatar">
                        @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" alt="">
                        @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <span class="hdr-name">{{ auth()->user()->name }}</span>
                    <span class="hdr-chevron">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>

                    <div class="hdr-dropdown">
                        <a href="#" class="hdr-dropdown-item">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            My Profile
                        </a>
                        <a href="#" class="hdr-dropdown-item">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                        <div class="hdr-dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hdr-dropdown-item danger" style="width:100%;background:none;border:none;text-align:left;">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- ═══════════════════════════════════
         MAIN CONTENT
    ═══════════════════════════════════ --}}
        <main class="main-content">
            @if(session('success'))
            <div class="flash flash-success">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>

    </div>

    <script>
        /* Sidebar toggle (mobile) */
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('open');
        }

        /* Header profile dropdown */
        function toggleProfileMenu() {
            document.getElementById('hdrProfile').classList.toggle('open');
        }
        document.addEventListener('click', function(e) {
            const p = document.getElementById('hdrProfile');
            if (p && !p.contains(e.target)) p.classList.remove('open');
        });
    </script>

    @stack('scripts')
</body>

</html>