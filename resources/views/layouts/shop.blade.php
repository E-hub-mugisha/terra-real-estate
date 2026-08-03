<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Terra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --terra-primary: #1a7a4c;
            --terra-primary-dark: #145c3a;
            --terra-bg: #f5f7f6;
            --terra-sidebar-bg: #0f2e21;
            --terra-sidebar-hover: #164a37;
            --terra-text-muted: #6c7a75;
        }

        body {
            background: var(--terra-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Sidebar */
        .terra-sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--terra-sidebar-bg);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: transform 0.25s ease;
        }

        .terra-sidebar .brand {
            padding: 1.25rem 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .terra-sidebar .brand span {
            color: var(--terra-primary);
        }

        .terra-sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 0.75rem 1.5rem;
            font-size: 0.925rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            border-left: 3px solid transparent;
        }

        .terra-sidebar .nav-link i {
            font-size: 1.05rem;
            width: 20px;
        }

        .terra-sidebar .nav-link:hover {
            background: var(--terra-sidebar-hover);
            color: #fff;
        }

        .terra-sidebar .nav-link.active {
            background: var(--terra-sidebar-hover);
            color: #fff;
            border-left-color: var(--terra-primary);
        }

        .terra-sidebar .nav-section-label {
            color: rgba(255,255,255,0.35);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 1rem 1.5rem 0.4rem;
        }

        /* Main content */
        .terra-main {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .terra-topbar {
            background: #fff;
            border-bottom: 1px solid #e7ebe9;
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .terra-topbar .user-chip {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.9rem;
        }

        .terra-topbar .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--terra-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .sidebar-toggle-btn {
            display: none;
        }

        /* Mobile */
        @media (max-width: 991.98px) {
            .terra-sidebar {
                transform: translateX(-100%);
            }
            .terra-sidebar.show {
                transform: translateX(0);
            }
            .terra-main {
                margin-left: 0;
            }
            .sidebar-toggle-btn {
                display: inline-flex;
            }
            .sidebar-backdrop {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.4);
                z-index: 1025;
            }
            .sidebar-backdrop.show {
                display: block;
            }
        }

        .btn-terra {
            background: var(--terra-primary);
            border-color: var(--terra-primary);
            color: #fff;
        }
        .btn-terra:hover {
            background: var(--terra-primary-dark);
            border-color: var(--terra-primary-dark);
            color: #fff;
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <aside class="terra-sidebar" id="terraSidebar">
        <div class="brand">Terra<span>.</span></div>

        <nav class="nav flex-column pt-2">
            <div class="nav-section-label">My Account</div>

            <a href="{{ route('dashboard.profile.edit') }}"
               class="nav-link {{ request()->routeIs('dashboard.profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i> My Profile
            </a>

            <div class="nav-section-label">Marketplace</div>

            <a href="{{ route('dashboard.products.index') }}"
               class="nav-link {{ request()->routeIs('dashboard.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> My Products
            </a>

            @auth
                @if (auth()->user()->shop)
                    <a href="{{ route('shops.show', auth()->user()->shop->slug) }}" class="nav-link" target="_blank">
                        <i class="bi bi-shop"></i> View My Shop
                    </a>
                @endif
            @endauth

            <div class="nav-section-label">Account</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </aside>

    <div class="terra-main">
        <header class="terra-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary sidebar-toggle-btn" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
            </div>

            <div class="user-chip">
                <div class="avatar-circle">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
            </div>
        </header>

        <main class="flex-grow-1">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('terraSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn?.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            backdrop.classList.toggle('show');
        });

        backdrop?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        });
    </script>

    @stack('scripts')
</body>
</html>