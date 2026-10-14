<header class="admin-topbar">

    <div class="d-flex align-items-center gap-3">
        <button type="button"
            class="btn btn-light d-lg-none"
            id="sidebarToggle"
            aria-label="Toggle navigation">
            <i class="bi bi-list fs-5"></i>
        </button>

        <div>
            <h1 class="topbar-page-title">
                @yield('title', 'Admin Dashboard')
            </h1>

            <div class="topbar-breadcrumb">
                <a href="{{ url('/admin') }}" class="text-secondary">
                    Admin
                </a>

                <i class="bi bi-chevron-right mx-1"></i>

                <span>@yield('breadcrumb', 'Overview')</span>
            </div>
        </div>
    </div>

    <a href="{{ route('notifications.index') }}"
        class="btn btn-light position-relative"
        aria-label="Notifications">

        <i class="bi bi-bell fs-5"></i>

        @php
        $unreadNotificationsCount = auth()->user()
        ->unreadNotifications()
        ->where(function ($query) {
        $query->whereNull('expires_at')
        ->orWhere('expires_at', '>', now());
        })
        ->count();
        @endphp

        @if ($unreadNotificationsCount > 0)
        <span class="position-absolute top-0 start-100 translate-middle
                     badge rounded-pill bg-danger">
            {{ $unreadNotificationsCount > 99
                ? '99+'
                : $unreadNotificationsCount }}
        </span>
        @endif
    </a>
    <div class="topbar-user">

        <div class="dropdown">
            <button class="btn btn-light border-0 dropdown-toggle d-flex align-items-center gap-2"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <div class="topbar-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>

                <div class="topbar-user-details text-start">
                    <div class="topbar-user-name">
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </div>
                    <div class="topbar-user-role">Admin account</div>
                </div>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li>
                    <h6 class="dropdown-header">
                        {{ auth()->user()->email ?? '' }}
                    </h6>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Sign out
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>

</header>