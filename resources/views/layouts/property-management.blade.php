<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Property Management') | Terra Real Estate</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap"
        rel="stylesheet">

    {{-- Bootstrap 5 + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ==================================================
           DESIGN TOKENS
        ================================================== */
        :root {
            --terra-orange: #D05208;
            --terra-orange-dark: #a94006;
            --terra-orange-soft: rgba(208, 82, 8, .09);

            --terra-navy: #19265d;
            --terra-navy-dark: #111a42;
            --terra-navy-deep: #0c1233;

            --terra-bg: #f4f5f8;
            --terra-light: #f4f5f8;
            --terra-surface: #ffffff;
            --terra-surface-2: #f9fafc;
            --terra-border: #e4e7ee;
            --terra-border-strong: #d3d8e3;

            --terra-text: #1f2937;
            --terra-muted: #6b7280;

            --terra-success: #15803d;
            --terra-warning: #a16207;
            --terra-danger: #b91c1c;
            --terra-info: #1d4ed8;

            --sidebar-width: 268px;
            --topbar-height: 68px;

            --radius-sm: 6px;
            --radius: 10px;
            --radius-lg: 14px;

            --shadow-sm: 0 1px 2px rgba(17, 26, 66, .05);
            --shadow-md: 0 4px 16px rgba(17, 26, 66, .07);

            --font-display: "Cormorant Garamond", Georgia, serif;
            --font-body: "DM Sans", Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        /* ==================================================
           GLOBAL
        ================================================== */
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--terra-bg);
            color: var(--terra-text);
            font-family: var(--font-body);
            font-size: 14px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; }
        button { font-family: inherit; }

        :focus-visible {
            outline: 2px solid var(--terra-orange);
            outline-offset: 2px;
        }

        ::selection { background: rgba(208, 82, 8, .2); }

        /* ==================================================
           SIDEBAR
        ================================================== */
        .terra-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, var(--terra-navy) 0%, var(--terra-navy-dark) 100%);
            color: #fff;
            z-index: 1050;
            transition: transform .3s ease;
        }

        .terra-sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 12px;
        }

        .terra-sidebar-scroll::-webkit-scrollbar { width: 5px; }
        .terra-sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .18);
            border-radius: 10px;
        }

        /* Brand */
        .terra-brand {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            flex-shrink: 0;
        }

        .terra-brand-logo {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 9px;
            background: var(--terra-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 26px;
            font-weight: 700;
            line-height: 1;
            box-shadow: 0 4px 12px rgba(208, 82, 8, .35);
        }

        .terra-brand-text strong {
            display: block;
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 700;
            line-height: 1;
            letter-spacing: .01em;
        }

        .terra-brand-text small {
            display: block;
            margin-top: 4px;
            color: rgba(255, 255, 255, .55);
            font-size: 11.5px;
        }

        /* Sections */
        .sidebar-section { padding: 22px 14px 0; }

        .sidebar-section-title {
            color: rgba(255, 255, 255, .45);
            font-size: 11.5px;
            font-weight: 600;
            padding: 0 12px 8px;
        }

        /* Links */
        .terra-sidebar .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, .72);
            border-radius: var(--radius-sm);
            padding: 10px 12px;
            margin-bottom: 2px;
            font-size: 14px;
            font-weight: 500;
            transition: background .2s ease, color .2s ease;
        }

        .terra-sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
            flex-shrink: 0;
            opacity: .85;
        }

        .terra-sidebar .nav-link:hover {
            background: rgba(255, 255, 255, .07);
            color: #fff;
        }

        .terra-sidebar .nav-link.active {
            background: rgba(255, 255, 255, .11);
            color: #fff;
            font-weight: 600;
        }

        .terra-sidebar .nav-link.active i {
            color: #ff8a47;
            opacity: 1;
        }

        .terra-sidebar .nav-link.active::before {
            content: "";
            position: absolute;
            left: -14px;
            top: 8px;
            bottom: 8px;
            width: 3px;
            border-radius: 0 3px 3px 0;
            background: var(--terra-orange);
        }

        /* Sidebar footer (user) */
        .sidebar-footer {
            flex-shrink: 0;
            padding: 14px;
            border-top: 1px solid rgba(255, 255, 255, .08);
        }

        .sidebar-back {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            color: rgba(255, 255, 255, .72);
            font-size: 13.5px;
            font-weight: 500;
            background: rgba(255, 255, 255, .05);
            transition: background .2s ease, color .2s ease;
        }

        .sidebar-back:hover {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        /* Backdrop for mobile */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(12, 18, 51, .55);
            z-index: 1040;
        }

        .sidebar-backdrop.show { display: block; }

        /* ==================================================
           MAIN AREA
        ================================================== */
        .terra-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ==================================================
           TOPBAR
        ================================================== */
        .terra-topbar {
            height: var(--topbar-height);
            background: rgba(255, 255, 255, .92);
            backdrop-filter: saturate(160%) blur(10px);
            border-bottom: 1px solid var(--terra-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .page-heading { min-width: 0; }

        .page-heading h1 {
            font-family: var(--font-display);
            font-size: 26px;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: .005em;
            margin: 0;
            color: var(--terra-navy);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .page-heading small {
            display: block;
            margin-top: 3px;
            color: var(--terra-muted);
            font-size: 12.5px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-divider {
            width: 1px;
            height: 28px;
            background: var(--terra-border);
        }

        /* ==================================================
           BUTTONS
        ================================================== */
        .btn-terra {
            background: var(--terra-orange);
            border: 1px solid var(--terra-orange);
            color: #fff;
            font-weight: 600;
        }

        .btn-terra:hover,
        .btn-terra:focus,
        .btn-terra:active {
            background: var(--terra-orange-dark) !important;
            border-color: var(--terra-orange-dark) !important;
            color: #fff !important;
        }

        .btn-terra-outline {
            border: 1px solid var(--terra-orange);
            color: var(--terra-orange);
            background: transparent;
            font-weight: 600;
        }

        .btn-terra-outline:hover {
            background: var(--terra-orange);
            color: #fff;
        }

        .btn-terra-navy {
            background: var(--terra-navy);
            border: 1px solid var(--terra-navy);
            color: #fff;
            font-weight: 600;
        }

        .btn-terra-navy:hover {
            background: var(--terra-navy-dark);
            color: #fff;
        }

        .btn { border-radius: 8px; font-size: 13.5px; }

        .quick-action-button {
            min-height: 40px;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13.5px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(208, 82, 8, .25);
        }

        /* ==================================================
           USER MENU
        ================================================== */
        .user-button {
            background: transparent;
            border: 0;
            padding: 4px 6px 4px 4px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--terra-navy);
            transition: background .2s ease;
        }

        .user-button:hover { background: var(--terra-surface-2); }

        .user-avatar {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--terra-navy) 0%, #2c3d8f 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .user-info { text-align: left; }

        .user-info strong {
            display: block;
            font-size: 13px;
            line-height: 1.2;
            color: var(--terra-navy);
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-info small {
            display: block;
            margin-top: 2px;
            font-size: 11.5px;
            color: var(--terra-muted);
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ==================================================
           DROPDOWN
        ================================================== */
        .dropdown-menu {
            border: 1px solid var(--terra-border);
            border-radius: var(--radius);
            padding: 8px;
            box-shadow: var(--shadow-md) !important;
            min-width: 220px;
        }

        .dropdown-item {
            border-radius: var(--radius-sm);
            padding: 9px 11px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .dropdown-item:hover { background: var(--terra-light); }
        .dropdown-item i { width: 18px; color: var(--terra-muted); }
        .dropdown-item.text-danger i { color: inherit; }

        .dropdown-header {
            color: var(--terra-muted);
            font-size: 12px;
            font-weight: 600;
            padding: 6px 11px;
        }

        /* ==================================================
           CONTENT
        ================================================== */
        .terra-content {
            flex: 1;
            padding: 32px;
            width: 100%;
            max-width: 1600px;
        }

        /* Optional page header: @section('page-actions') in child views */
        .terra-page-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* ==================================================
           CARDS
        ================================================== */
        .terra-card {
            background: var(--terra-surface);
            border: 1px solid var(--terra-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .terra-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--terra-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            background: var(--terra-surface);
        }

        .terra-card-header h5 {
            margin: 0;
            color: var(--terra-navy);
            font-family: var(--font-display);
            font-size: 21px;
            font-weight: 700;
            line-height: 1.2;
        }

        .terra-card-body { padding: 22px; }

        .terra-card-footer {
            padding: 14px 22px;
            border-top: 1px solid var(--terra-border);
            background: var(--terra-surface-2);
        }

        /* ==================================================
           STAT CARDS
        ================================================== */
        .terra-stat-card {
            position: relative;
            background: var(--terra-surface);
            border: 1px solid var(--terra-border);
            border-radius: var(--radius-lg);
            padding: 20px 22px;
            height: 100%;
            box-shadow: var(--shadow-sm);
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: start;
            column-gap: 12px;
        }

        .terra-stat-icon {
            grid-column: 2;
            grid-row: 1 / span 2;
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: var(--terra-orange-soft);
            color: var(--terra-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .terra-stat-card:has(.terra-stat-icon) .terra-stat-label { grid-column: 1; grid-row: 1; }
        .terra-stat-card:has(.terra-stat-icon) .terra-stat-value { grid-column: 1; grid-row: 2; }

        .terra-stat-value {
            margin-top: 6px;
            font-size: 28px;
            font-weight: 700;
            line-height: 1.15;
            color: var(--terra-navy);
            font-variant-numeric: tabular-nums;
            letter-spacing: -.01em;
        }

        .terra-stat-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--terra-muted);
        }

        .terra-stat-meta {
            grid-column: 1 / -1;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed var(--terra-border);
            font-size: 12.5px;
            color: var(--terra-muted);
        }

        /* Stat icon colour variants */
        .terra-stat-icon.is-navy { background: rgba(25, 38, 93, .08); color: var(--terra-navy); }
        .terra-stat-icon.is-success { background: rgba(21, 128, 61, .10); color: var(--terra-success); }
        .terra-stat-icon.is-info { background: rgba(29, 78, 216, .09); color: var(--terra-info); }
        .terra-stat-icon.is-danger { background: rgba(185, 28, 28, .09); color: var(--terra-danger); }

        /* ==================================================
           TABLES
        ================================================== */
        .terra-table { margin-bottom: 0; --bs-table-hover-bg: var(--terra-surface-2); }

        .terra-table thead th {
            background: var(--terra-surface-2);
            color: var(--terra-muted);
            font-size: 12px;
            font-weight: 600;
            border-bottom: 1px solid var(--terra-border);
            padding: 12px 16px;
            white-space: nowrap;
        }

        .terra-table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 14px;
            border-color: var(--terra-border);
        }

        .terra-table tbody tr:last-child td { border-bottom: 0; }

        .table-responsive { scrollbar-width: thin; }

        /* ==================================================
           BADGES (status pills with dot)
        ================================================== */
        .badge {
            font-weight: 600;
            font-size: 12px;
            padding: .4em .75em;
            border-radius: 999px;
        }

        .badge-terra,
        .badge-active,
        .badge-pending,
        .badge-danger-soft,
        .badge-info-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-terra::before,
        .badge-active::before,
        .badge-pending::before,
        .badge-danger-soft::before,
        .badge-info-soft::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .badge-terra { background: var(--terra-orange-soft); color: var(--terra-orange-dark); }
        .badge-active { background: rgba(21, 128, 61, .10); color: var(--terra-success); }
        .badge-pending { background: rgba(234, 179, 8, .16); color: var(--terra-warning); }
        .badge-danger-soft { background: rgba(185, 28, 28, .09); color: var(--terra-danger); }
        .badge-info-soft { background: rgba(29, 78, 216, .09); color: var(--terra-info); }

        /* ==================================================
           FILTER BAR / EMPTY STATE / PROGRESS
        ================================================== */
        .terra-filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--terra-border);
            background: var(--terra-surface-2);
        }

        .terra-empty {
            text-align: center;
            padding: 56px 20px;
            color: var(--terra-muted);
        }

        .terra-empty i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--terra-orange-soft);
            color: var(--terra-orange);
            font-size: 28px;
            margin-bottom: 14px;
        }

        .terra-empty h6 {
            color: var(--terra-navy);
            font-weight: 700;
            margin-bottom: 4px;
        }

        .terra-progress {
            height: 6px;
            border-radius: 999px;
            background: var(--terra-border);
            overflow: hidden;
        }

        .terra-progress > span {
            display: block;
            height: 100%;
            background: var(--terra-orange);
            border-radius: inherit;
        }

        /* ==================================================
           BREADCRUMB
        ================================================== */
        .terra-breadcrumb { margin-bottom: 20px; }
        .terra-breadcrumb .breadcrumb { margin-bottom: 0; font-size: 13px; }
        .terra-breadcrumb a { color: var(--terra-orange); font-weight: 500; }
        .terra-breadcrumb a:hover { color: var(--terra-orange-dark); }
        .terra-breadcrumb .breadcrumb-item.active { color: var(--terra-muted); }

        /* ==================================================
           FORMS
        ================================================== */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--terra-navy);
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            border-color: var(--terra-border-strong);
            border-radius: 8px;
            padding: 10px 13px;
            font-size: 14px;
            background-color: #fff;
        }

        .form-control::placeholder { color: #9aa1b0; }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--terra-orange);
            box-shadow: 0 0 0 .22rem rgba(208, 82, 8, .13);
        }

        .form-check-input:checked {
            background-color: var(--terra-orange);
            border-color: var(--terra-orange);
        }

        .form-check-input:focus {
            border-color: var(--terra-orange);
            box-shadow: 0 0 0 .22rem rgba(208, 82, 8, .13);
        }

        /* ==================================================
           ALERTS
        ================================================== */
        .alert {
            border-radius: var(--radius);
            font-size: 14px;
            border-width: 1px;
            padding: 14px 18px;
        }

        .alert-success { background: #f0faf4; border-color: #bfe5cd; color: #14532d; }
        .alert-danger { background: #fef4f4; border-color: #f3c6c6; color: #7f1d1d; }

        /* Pagination */
        .pagination .page-link {
            color: var(--terra-navy);
            border-color: var(--terra-border);
            font-size: 13px;
        }

        .pagination .page-item.active .page-link {
            background: var(--terra-navy);
            border-color: var(--terra-navy);
            color: #fff;
        }

        /* ==================================================
           MOBILE SIDEBAR BUTTON
        ================================================== */
        .sidebar-toggle {
            display: none;
            border: 1px solid var(--terra-border);
            background: #fff;
            color: var(--terra-navy);
            font-size: 22px;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            padding: 0;
        }

        /* ==================================================
           FOOTER
        ================================================== */
        .terra-footer {
            background: transparent;
            border-top: 1px solid var(--terra-border);
            padding: 16px 32px;
        }

        .terra-footer-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .terra-footer-text {
            margin: 0;
            font-size: 12.5px;
            color: var(--terra-muted);
        }

        .terra-footer-brand { color: var(--terra-navy); font-weight: 600; }
        .terra-footer-brand span { color: var(--terra-orange); }

        /* ==================================================
           RESPONSIVE
        ================================================== */
        @media (max-width: 991.98px) {
            .terra-sidebar { transform: translateX(-100%); }
            .terra-sidebar.show { transform: translateX(0); box-shadow: 0 0 40px rgba(0, 0, 0, .3); }
            .terra-main { margin-left: 0; }
            .sidebar-toggle { display: inline-flex; align-items: center; justify-content: center; }
            .terra-content { padding: 22px; }
            .terra-topbar { padding: 0 20px; }
            .terra-footer { padding: 15px 22px; }
        }

        @media (max-width: 575.98px) {
            .terra-content { padding: 16px; }
            .terra-topbar { height: 64px; padding: 0 14px; }
            .page-heading h1 { font-size: 21px; }
            .page-heading small { display: none; }
            .terra-card-header { padding: 14px 16px; }
            .terra-card-body { padding: 16px; }
            .topbar-divider { display: none; }

            .quick-action-button span,
            .quick-action-button .bi-chevron-down { display: none; }

            .quick-action-button {
                width: 40px;
                height: 40px;
                padding: 0;
                justify-content: center;
            }

            .user-info,
            .user-button > .bi-chevron-down { display: none; }

            .terra-footer { padding: 14px 15px; }
            .terra-footer-content { flex-direction: column; text-align: center; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }

        @media print {
            .terra-sidebar, .terra-topbar, .terra-footer { display: none !important; }
            .terra-main { margin-left: 0; }
            .terra-card { box-shadow: none; }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}
    <aside class="terra-sidebar" id="terraSidebar" aria-label="Main navigation">

        <div class="terra-brand">
            <div class="terra-brand-logo">T</div>
            <div class="terra-brand-text">
                <strong>Terra</strong>
                <small>Property Management</small>
            </div>
        </div>

        <nav class="terra-sidebar-scroll">

            <div class="sidebar-section">
                <div class="sidebar-section-title">Overview</div>

                <a href="{{ route('property-management.dashboard') }}"
                    class="nav-link {{ request()->routeIs('property-management.dashboard') ? 'active' : '' }}"
                    @if(request()->routeIs('property-management.dashboard')) aria-current="page" @endif>
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Portfolio</div>

                <a href="{{ route('property-management.properties.index') }}"
                    class="nav-link {{ request()->routeIs('property-management.properties.*') ? 'active' : '' }}"
                    @if(request()->routeIs('property-management.properties.*')) aria-current="page" @endif>
                    <i class="bi bi-buildings"></i>
                    <span>Properties</span>
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Tenants</div>

                <a href="{{ route('property-management.tenants.index') }}"
                    class="nav-link {{ request()->routeIs('property-management.tenants.*') ? 'active' : '' }}"
                    @if(request()->routeIs('property-management.tenants.*')) aria-current="page" @endif>
                    <i class="bi bi-people"></i>
                    <span>Tenants</span>
                </a>

                <a href="{{ route('property-management.applications.index') }}"
                    class="nav-link {{ request()->routeIs('property-management.applications.*') ? 'active' : '' }}"
                    @if(request()->routeIs('property-management.applications.*')) aria-current="page" @endif>
                    <i class="bi bi-person-plus"></i>
                    <span>Applications</span>
                </a>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Contracts</div>

                <a href="{{ route('property-management.leases.index') }}"
                    class="nav-link {{ request()->routeIs('property-management.leases.*') ? 'active' : '' }}"
                    @if(request()->routeIs('property-management.leases.*')) aria-current="page" @endif>
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Leases</span>
                </a>
            </div>

        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('front.home') }}" class="sidebar-back">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Terra</span>
            </a>
        </div>

    </aside>

    {{-- =====================================================
         MAIN
    ====================================================== --}}
    <div class="terra-main">

        <header class="terra-topbar">

            {{-- Left --}}
            <div class="d-flex align-items-center gap-3 min-w-0">

                <button type="button" class="sidebar-toggle" id="sidebarToggle"
                    aria-label="Toggle navigation" aria-controls="terraSidebar">
                    <i class="bi bi-list"></i>
                </button>

                <div class="page-heading">
                    <h1>@yield('page-title', 'Property Management')</h1>
                    <small>@yield('page-subtitle', 'Manage your properties and rental operations')</small>
                </div>

            </div>

            {{-- Right --}}
            <div class="topbar-actions">

                <div class="dropdown">
                    <button type="button"
                        class="btn btn-terra quick-action-button d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus-lg"></i>
                        <span>Quick Action</span>
                        <i class="bi bi-chevron-down small"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Create new</h6></li>

                        <li>
                            <a class="dropdown-item" href="{{ route('property-management.properties.create') }}">
                                <i class="bi bi-building me-2"></i> Register Property
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('property-management.tenants.create') }}">
                                <i class="bi bi-person-plus me-2"></i> Register Tenant
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('property-management.leases.create') }}">
                                <i class="bi bi-file-earmark-plus me-2"></i> Create Lease
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="topbar-divider"></div>

                <div class="dropdown">
                    <button type="button" class="user-button" data-bs-toggle="dropdown" aria-expanded="false">

                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>

                        <div class="user-info d-none d-md-block">
                            <strong>{{ auth()->user()->name ?? 'User' }}</strong>
                            <small>{{ auth()->user()->email ?? '' }}</small>
                        </div>

                        <i class="bi bi-chevron-down small"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('front.home') }}">
                                <i class="bi bi-house me-2"></i> Terra Website
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>

        </header>

        <main class="terra-content">

            @hasSection('breadcrumb')
            <div class="terra-breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
            @endif

            @hasSection('page-actions')
            <div class="terra-page-actions">
                @yield('page-actions')
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <div class="fw-semibold mb-2">Please correct the following errors:</div>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')

        </main>

        <footer class="terra-footer">
            <div class="terra-footer-content">
                <p class="terra-footer-text">
                    &copy; {{ date('Y') }}
                    <span class="terra-footer-brand">Terra<span> Real Estate</span></span>.
                    All rights reserved.
                </p>
                <p class="terra-footer-text">Property Management System</p>
            </div>
        </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('terraSidebar');
            const toggle = document.getElementById('sidebarToggle');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (!sidebar || !toggle || !backdrop) return;

            const setOpen = function (open) {
                sidebar.classList.toggle('show', open);
                backdrop.classList.toggle('show', open);
            };

            toggle.addEventListener('click', function () {
                setOpen(!sidebar.classList.contains('show'));
            });

            backdrop.addEventListener('click', function () { setOpen(false); });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setOpen(false);
            });

            sidebar.querySelectorAll('.nav-link').forEach(function (link) {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 991) setOpen(false);
                });
            });
        });
    </script>

    @stack('scripts')

</body>

</html>