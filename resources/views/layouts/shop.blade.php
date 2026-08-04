<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop Panel') — Terra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --terra-green: #19265d;
            --terra-green-dark: #121b45;
            --terra-green-light: #253785;
            --terra-gold: #D05208;
            --terra-bg: #f4f7f5;
            --terra-border: #e7ece9;
            --terra-text-muted: #6b7a74;
        }

        * { font-family: 'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif; }

        body {
            background: var(--terra-bg);
        }

        /* ---------- Sidebar ---------- */
        .sp-sidebar {
            width: 264px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--terra-green-dark) 0%, #101a40 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: transform .25s ease;
            display: flex;
            flex-direction: column;
        }

        .sp-sidebar .brand {
            padding: 1.5rem 1.5rem 1.1rem;
            font-weight: 800;
            font-size: 1.3rem;
            color: #fff;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .sp-sidebar .brand .brand-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--terra-gold);
            display: inline-block;
        }

        .sp-sidebar .shop-chip {
            margin: 0 1rem 1rem;
            padding: .85rem;
            background: rgba(255,255,255,.06);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .sp-sidebar .shop-chip img,
        .sp-sidebar .shop-chip .shop-chip-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .sp-sidebar .shop-chip .shop-chip-placeholder {
            background: rgba(255,255,255,.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,.6);
        }

        .sp-sidebar .shop-chip .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }

        .sp-sidebar .nav-section-label {
            color: rgba(255,255,255,.35);
            font-size: .68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 1rem 1.5rem .4rem;
        }

        .sp-sidebar .nav-link {
            color: rgba(255,255,255,.7);
            padding: .7rem 1.5rem;
            font-size: .89rem;
            font-weight: 500;
            display: flex;
            gap: .7rem;
            align-items: center;
            border-left: 3px solid transparent;
            margin: 0 0;
        }

        .sp-sidebar .nav-link i { font-size: 1.05rem; width: 18px; }

        .sp-sidebar .nav-link:hover {
            background: rgba(255,255,255,.06);
            color: #fff;
        }

        .sp-sidebar .nav-link.active {
            background: rgba(255,255,255,.08);
            color: #fff;
            border-left-color: var(--terra-gold);
            font-weight: 600;
        }

        .sp-sidebar .nav-footer {
            margin-top: auto;
            padding: 1rem 0;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        /* ---------- Main ---------- */
        .sp-main {
            margin-left: 264px;
            min-height: 100vh;
        }

        .sp-topbar {
            background: #fff;
            border-bottom: 1px solid var(--terra-border);
            padding: 1rem 1.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .sp-topbar h6 {
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .sp-user-chip {
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .sp-user-chip .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--terra-green);
            color: #fff;
            font-weight: 700;
            font-size: .85rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sp-user-chip .user-name {
            font-size: .87rem;
            font-weight: 600;
            color: #1c2b25;
            line-height: 1.1;
        }

        .sp-user-chip .user-role {
            font-size: .72rem;
            color: var(--terra-text-muted);
        }

        main.sp-content {
            padding: 1.75rem;
        }

        /* ---------- Shared elements ---------- */
        .btn-terra {
            background: var(--terra-green);
            border-color: var(--terra-green);
            color: #fff;
            font-weight: 500;
        }
        .btn-terra:hover {
            background: var(--terra-green-light);
            border-color: var(--terra-green-light);
            color: #fff;
        }

        .badge-soft-success { background: rgba(40,167,69,.12); color: #1e7e34; }
        .badge-soft-warning { background: rgba(240,173,78,.18); color: #a06b15; }
        .badge-soft-danger  { background: rgba(220,53,69,.12); color: #c62839; }
        .badge-soft-secondary { background: rgba(108,117,125,.14); color: #495057; }

        .panel-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(25, 38, 93, 0.06);
        }
        .panel-card .card-header {
            border-bottom: 1px solid var(--terra-border);
            border-radius: 14px 14px 0 0 !important;
            background: #fff;
            font-weight: 600;
        }

        @media (max-width: 991.98px) {
            .sp-sidebar { transform: translateX(-100%); }
            .sp-sidebar.show { transform: translateX(0); }
            .sp-main { margin-left: 0; }
            .sp-toggle { display: inline-flex !important; }
        }

        .sp-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(18,27,69,.45);
            z-index: 1025;
        }
        .sp-backdrop.show { display: block; }
    </style>
    @stack('styles')
</head>

<body>

    @php $shop = auth()->user()->shop; @endphp

    <div class="sp-backdrop" id="spBackdrop"></div>

    <aside class="sp-sidebar" id="spSidebar">
        <div class="brand">
            <span class="brand-dot"></span> Terra <span style="color:var(--terra-gold); font-weight:600;">Shop</span>
        </div>

        <div class="shop-chip">
            @if ($shop->logo)
                <img src="{{ asset('storage/' . $shop->logo) }}" alt="{{ $shop->name }}">
            @else
                <div class="shop-chip-placeholder"><i class="bi bi-shop"></i></div>
            @endif
            <div class="text-truncate">
                <div class="text-white small fw-medium text-truncate" style="max-width:140px;">{{ $shop->name }}</div>
                @php
                    $dot = ['pending'=>'#f0ad4e','approved'=>'#2ecc71','rejected'=>'#e35d6a','suspended'=>'#9aa5a0'][$shop->status] ?? '#9aa5a0';
                @endphp
                <span class="status-dot" style="background:{{ $dot }}"></span>
                <span class="text-white-50" style="font-size:.72rem;">{{ ucfirst($shop->status) }}</span>
            </div>
        </div>

        <div class="nav-section-label">Overview</div>
        <nav class="nav flex-column">
            <a href="{{ route('shop-panel.dashboard') }}" class="nav-link {{ request()->routeIs('shop-panel.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </nav>

        <div class="nav-section-label">My Account</div>
        <nav class="nav flex-column">
            <a href="{{ route('shop-panel.profile.show') }}" class="nav-link {{ request()->routeIs('shop-panel.profile.*') ? 'active' : '' }}">
                <i class="bi bi-shop"></i> Shop Profile
            </a>
            <a href="{{ route('shop-panel.products.index') }}" class="nav-link {{ request()->routeIs('shop-panel.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> My Products
            </a>
            @if ($shop->isApproved())
                <a href="{{ route('shops.show', $shop->slug) }}" target="_blank" class="nav-link">
                    <i class="bi bi-box-arrow-up-right"></i> View Public Shop
                </a>
            @endif
        </nav>

        <div class="nav-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="sp-main">
        <header class="sp-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary d-none sp-toggle" id="spToggle">
                    <i class="bi bi-list"></i>
                </button>
                <h6 class="mb-0">@yield('page-title', 'Shop Panel')</h6>
            </div>

            <div class="sp-user-chip">
                <div class="text-end d-none d-sm-block">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Shop Owner</div>
                </div>
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
            </div>
        </header>

        <main class="sp-content">
            @if ($shop->status === 'rejected' && $shop->rejection_reason)
                <div class="alert alert-danger d-flex align-items-start gap-2">
                    <i class="bi bi-exclamation-octagon mt-1"></i>
                    <div><strong>Your shop was rejected:</strong> {{ $shop->rejection_reason }}. Update your details and it will be reviewed again.</div>
                </div>
            @elseif ($shop->status === 'pending')
                <div class="alert alert-warning d-flex align-items-start gap-2">
                    <i class="bi bi-hourglass-split mt-1"></i>
                    <div>Your shop is pending review. It won't be visible publicly until approved.</div>
                </div>
            @elseif ($shop->status === 'suspended')
                <div class="alert alert-secondary d-flex align-items-start gap-2">
                    <i class="bi bi-slash-circle mt-1"></i>
                    <div>Your shop is currently suspended. Contact support for details.</div>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    <div>
                        @switch(session('status'))
                            @case('product-created') Product created and sent for review. @break
                            @case('product-updated') Product updated. @break
                            @case('product-deleted') Product removed. @break
                            @case('shop-updated') Shop profile updated. @break
                            @default {{ session('status') }}
                        @endswitch
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        const spSidebar = document.getElementById('spSidebar');
        const spBackdrop = document.getElementById('spBackdrop');

        document.getElementById('spToggle')?.addEventListener('click', () => {
            spSidebar.classList.toggle('show');
            spBackdrop.classList.toggle('show');
        });

        spBackdrop?.addEventListener('click', () => {
            spSidebar.classList.remove('show');
            spBackdrop.classList.remove('show');
        });
    </script>
    @stack('scripts')
</body>

</html>