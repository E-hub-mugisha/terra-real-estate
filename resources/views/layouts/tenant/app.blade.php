<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Tenant Portal') | Terra Real Estate</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --terra-orange: #D05208;
            --terra-navy: #19265d;
            --terra-bg: #f5f7fb;
            --terra-border: #e8ebf1;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--terra-bg);
            color: #273047;
        }

        .tenant-sidebar {
            width: 255px;
            min-height: 100vh;
            background: #fff;
            border-right: 1px solid var(--terra-border);
        }

        .tenant-brand {
            color: var(--terra-navy);
            font-weight: 700;
            font-size: 1.35rem;
            text-decoration: none;
        }

        .tenant-brand span {
            color: var(--terra-orange);
        }

        .tenant-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            margin-bottom: 5px;
            border-radius: 8px;
            color: #5c6578;
            text-decoration: none;
            font-weight: 500;
        }

        .tenant-nav-link:hover,
        .tenant-nav-link.active {
            color: var(--terra-orange);
            background: #fff2e9;
        }

        .tenant-nav-link i {
            font-size: 1.1rem;
        }

        .tenant-topbar {
            background: #fff;
            border-bottom: 1px solid var(--terra-border);
        }

        .tenant-card {
            background: #fff;
            border: 1px solid var(--terra-border);
            border-radius: 14px;
            box-shadow: 0 3px 12px rgba(25, 38, 93, .03);
        }

        .tenant-page-title {
            color: var(--terra-navy);
            font-weight: 700;
        }

        .btn-terra {
            background: var(--terra-orange);
            border-color: var(--terra-orange);
            color: #fff;
        }

        .btn-terra:hover {
            background: #b94707;
            border-color: #b94707;
            color: #fff;
        }

        .text-terra {
            color: var(--terra-orange) !important;
        }

        .tenant-content {
            min-width: 0;
        }

        @media (max-width: 991.98px) {
            .tenant-sidebar {
                width: 100%;
                min-height: auto;
                border-right: 0;
                border-bottom: 1px solid var(--terra-border);
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="d-lg-flex min-vh-100">

    {{-- Sidebar --}}
    <aside class="tenant-sidebar p-3">
        <div class="d-flex align-items-center justify-content-between mb-4 px-2">
            <a href="{{ route('tenant-portal.dashboard') }}" class="tenant-brand">
                terra<span>.</span>
            </a>

            <button class="btn btn-sm btn-outline-secondary d-lg-none"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#tenantNavigation"
                    aria-controls="tenantNavigation"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
        </div>

        <div class="collapse d-lg-block" id="tenantNavigation">
            <div class="text-uppercase text-secondary small fw-bold px-3 mb-2">
                My account
            </div>

            <nav>
                <a href="{{ route('tenant-portal.dashboard') }}"
                   class="tenant-nav-link {{ request()->routeIs('tenant-portal.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>

                <a href="{{ route('tenant-portal.rental.index') }}"
                   class="tenant-nav-link {{ request()->routeIs('tenant-portal.rental.*') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> My rental
                </a>

                <a href="{{ route('tenant-portal.applications.index') }}"
                   class="tenant-nav-link {{ request()->routeIs('tenant-portal.applications.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Applications
                </a>

                <a href="{{ route('tenant-portal.leases.index') }}"
                   class="tenant-nav-link {{ request()->routeIs('tenant-portal.leases.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-check"></i> My leases
                </a>

                <a href="{{ route('tenant-portal.payments.index') }}"
                   class="tenant-nav-link {{ request()->routeIs('tenant-portal.payments.*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i> Rent payments
                </a>

                <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
                   class="tenant-nav-link {{ request()->routeIs('tenant-portal.maintenance-requests.*') ? 'active' : '' }}">
                    <i class="bi bi-tools"></i> Maintenance
                </a>

                @if (Route::has('notifications.index'))
                    <a href="{{ route('notifications.index') }}"
                       class="tenant-nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <i class="bi bi-bell"></i> Notifications
                    </a>
                @endif

                <hr class="my-3">

                <a href="{{ route('tenant-portal.profile.edit') }}"
                   class="tenant-nav-link {{ request()->routeIs('tenant-portal.profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person"></i> My profile
                </a>
            </nav>
        </div>
    </aside>

    {{-- Main content --}}
    <div class="tenant-content flex-grow-1">
        <header class="tenant-topbar px-3 px-md-4 py-3">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <div>
                    <div class="fw-semibold text-dark">
                        @yield('header-title', 'Tenant Portal')
                    </div>
                    <small class="text-secondary">
                        Manage your rental with Terra
                    </small>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-semibold">
                            {{ auth()->user()->name }}
                        </div>
                        <small class="text-secondary">Tenant</small>
                    </div>

                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                         style="width: 40px; height: 40px; background: #fff2e9; color: #D05208;">
                        <i class="bi bi-person fs-5"></i>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="btn btn-sm btn-outline-secondary"
                                title="Log out">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-md-inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="p-3 p-md-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <div class="fw-semibold mb-1">Please correct the following:</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="px-4 py-3 text-secondary small">
            &copy; {{ date('Y') }} Terra Real Estate. All rights reserved.
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>