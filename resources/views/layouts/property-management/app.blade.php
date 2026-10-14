<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | Terra</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --terra-orange: #D05208;
            --terra-orange-dark: #AD4306;
            --terra-navy: #19265D;
            --terra-sidebar: #19265D;
            --terra-sidebar-hover: rgba(255, 255, 255, .10);
            --terra-page-bg: #F5F6F8;
            --terra-border: #E8EAF0;
            --terra-text: #252B3B;
            --terra-muted: #737B8C;
            --terra-white: #FFFFFF;
            --terra-sidebar-width: 260px;
            --terra-topbar-height: 72px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            color: var(--terra-text);
            background: var(--terra-page-bg);
            font-size: 14px;
        }

        a {
            text-decoration: none;
        }

        .admin-wrapper {
            min-height: 100vh;
        }

        .admin-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--terra-sidebar-width);
            background: var(--terra-sidebar);
            color: #fff;
            display: flex;
            flex-direction: column;
            z-index: 1045;
            overflow-y: auto;
            transition: transform .25s ease;
        }

        .admin-brand {
            min-height: var(--terra-topbar-height);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            color: #fff;
        }

        .admin-brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: var(--terra-orange);
            color: white;
            font-size: 20px;
            font-weight: 700;
        }

        .admin-brand-name {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -.5px;
        }

        .admin-brand-subtitle {
            color: rgba(255, 255, 255, .62);
            font-size: 11px;
        }

        .sidebar-content {
            padding: 20px 12px;
            flex: 1;
        }

        .sidebar-label {
            padding: 0 12px;
            margin: 20px 0 9px;
            color: rgba(255, 255, 255, .50);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .sidebar-label:first-child {
            margin-top: 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 13px;
            margin-bottom: 4px;
            border-radius: 8px;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
            font-weight: 500;
            transition: background .2s ease, color .2s ease;
        }

        .sidebar-link i {
            width: 19px;
            font-size: 17px;
            text-align: center;
        }

        .sidebar-link:hover {
            background: var(--terra-sidebar-hover);
            color: white;
        }

        .sidebar-link.active {
            background: var(--terra-orange);
            color: white;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, .12);
        }

        .sidebar-footer .admin-user-name {
            font-size: 13px;
            font-weight: 600;
            color: white;
        }

        .sidebar-footer .admin-user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, .58);
        }

        .admin-main {
            min-height: 100vh;
            margin-left: var(--terra-sidebar-width);
        }

        .admin-topbar {
            height: var(--terra-topbar-height);
            position: sticky;
            top: 0;
            z-index: 1030;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 28px;
            background: white;
            border-bottom: 1px solid var(--terra-border);
        }

        .topbar-page-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--terra-navy);
            margin: 0;
        }

        .topbar-breadcrumb {
            color: var(--terra-muted);
            font-size: 12px;
            margin-top: 2px;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #FFF0E8;
            color: var(--terra-orange);
            font-weight: 700;
        }

        .topbar-user-name {
            font-size: 13px;
            font-weight: 600;
        }

        .topbar-user-role {
            font-size: 11px;
            color: var(--terra-muted);
        }

        .admin-content {
            padding: 28px;
            min-height: calc(100vh - var(--terra-topbar-height) - 65px);
        }

        .admin-footer {
            padding: 20px 28px;
            border-top: 1px solid var(--terra-border);
            background: white;
            color: var(--terra-muted);
            font-size: 12px;
        }

        .btn-primary {
            --bs-btn-bg: var(--terra-orange);
            --bs-btn-border-color: var(--terra-orange);
            --bs-btn-hover-bg: var(--terra-orange-dark);
            --bs-btn-hover-border-color: var(--terra-orange-dark);
            --bs-btn-active-bg: var(--terra-orange-dark);
            --bs-btn-active-border-color: var(--terra-orange-dark);
        }

        .text-primary {
            color: var(--terra-orange) !important;
        }

        .admin-card {
            background: white;
            border: 1px solid var(--terra-border);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(25, 38, 93, .025);
        }

        .admin-card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--terra-border);
        }

        .admin-card-body {
            padding: 22px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--terra-text);
        }

        .form-control,
        .form-select {
            min-height: 42px;
            border-color: #DDE1E8;
            border-radius: 7px;
            font-size: 13px;
        }

        textarea.form-control {
            min-height: auto;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--terra-orange);
            box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .12);
        }

        .table {
            --bs-table-hover-bg: #FAFAFC;
        }

        .table > :not(caption) > * > * {
            padding: 14px 16px;
            border-bottom-color: var(--terra-border);
        }

        .table thead th {
            color: #667085;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .45px;
            white-space: nowrap;
        }

        .btn {
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-sm {
            font-size: 12px;
        }

        .admin-overlay {
            display: none;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1040;
                background: rgba(15, 23, 42, .45);
            }

            .admin-topbar {
                padding: 0 18px;
            }

            .admin-content {
                padding: 20px 16px;
            }

            .admin-footer {
                padding: 18px 16px;
            }
        }

        @media (max-width: 575.98px) {
            .topbar-user-details {
                display: none;
            }

            .admin-topbar {
                gap: 10px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
<div class="admin-wrapper">

    @include('layouts.property-management.partials.sidebar')

    <div class="admin-overlay" id="adminOverlay"></div>

    <div class="admin-main">

        @include('layouts.property-management.partials.topbar')

        <main class="admin-content">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show"
                     role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show"
                     role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show"
                     role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')

        </main>

        <footer class="admin-footer d-flex flex-wrap justify-content-between gap-2">
            <span>&copy; {{ date('Y') }} Terra Real Estate. All rights reserved.</span>
            <span>Property Management Administration</span>
        </footer>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminOverlay');
        const toggle = document.getElementById('sidebarToggle');

        function closeSidebar() {
            sidebar?.classList.remove('show');
            overlay?.classList.remove('show');
        }

        toggle?.addEventListener('click', function () {
            sidebar?.classList.toggle('show');
            overlay?.classList.toggle('show');
        });

        overlay?.addEventListener('click', closeSidebar);

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                closeSidebar();
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>