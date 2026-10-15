<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Owner Portal') | Terra</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        :root {
            --terra-orange: #D05208;
            --terra-navy: #19265d;
            --terra-bg: #f6f7fb;
        }

        body {
            background: var(--terra-bg);
            color: #202433;
            font-family: Arial, sans-serif;
        }

        .owner-navbar {
            background: #fff;
            border-bottom: 1px solid #e8eaf0;
        }

        .terra-brand {
            color: var(--terra-orange);
            font-weight: 800;
            font-size: 1.4rem;
            text-decoration: none;
        }

        .nav-link {
            color: var(--terra-navy);
            font-weight: 500;
        }

        .nav-link.active,
        .nav-link:hover {
            color: var(--terra-orange);
        }

        .btn-terra {
            background: var(--terra-orange);
            color: #fff;
            border-color: var(--terra-orange);
        }

        .btn-terra:hover {
            background: #ad4307;
            color: #fff;
        }

        .owner-footer {
            color: #73798a;
            font-size: .875rem;
        }
    </style>

    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg owner-navbar">
        <div class="container">
            <a href="{{ route('property-owner.dashboard') }}"
                class="terra-brand">TERRA</a>

            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#ownerNavigation"
                aria-controls="ownerNavigation"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="ownerNavigation">
                <ul class="navbar-nav ms-lg-4 me-auto gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('property-owner.dashboard') ? 'active' : '' }}"
                            href="{{ route('property-owner.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('property-owner.properties.*') ? 'active' : '' }}"
                            href="{{ route('property-owner.properties.index') }}">
                            My Properties
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('property-owner.tenants.*') ? 'active' : '' }}"
                            href="{{ route('property-owner.tenants.index') }}">
                            Tenants
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 py-2 py-lg-0">
                    <span class="small text-muted">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-secondary btn-sm">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-lg-5">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="container py-4 owner-footer border-top">
        <div class="d-flex justify-content-between flex-wrap gap-2">
            <span>Terra Real Estate</span>
            <span>Property Owner Portal</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>