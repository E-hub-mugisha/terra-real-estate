<aside id="main-sidebar" class="main-sidebar">
    <div class="sidebar-wrapper">
        <a href="{{ route('agent.dashboard.index') }}" class="navbar-brand">
            {{ config('app.name') }}
        </a>

        <div class="dropdown profile-dropdown">
            <a href="#!" class="btn d-flex align-items-center w-100 gap-2 p-4 text-start" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('dashboard/assets/images/user.jfif') }}"
                     loading="lazy" alt="{{ Auth::user()->name }}" class="size-10 rounded-circle object-fit-cover">
                <div class="flex-grow-1 content">
                    <h6 class="fw-medium text-truncate mb-0 text-white">{{ Auth::user()->name }}</h6>
                    <p class="fs-14 mb-0 text-white-50">ID: {{ Auth::user()->id }}</p>
                </div>
                <div class="arrow">
                    <i data-lucide="chevron-down" class="size-4"></i>
                </div>
            </a>
            <div class="dropdown-menu p-4 profile-dropdown-menu">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('dashboard/assets/images/user.jfif') }}"
                         loading="lazy" alt="" class="rounded-circle size-10 flex-shrink-0 object-fit-cover">
                    <div class="flex-grow-1 overflow-hidden">
                        <h6 class="mb-0 text-truncate">{{ Auth::user()->name }}</h6>
                        <a href="#!" class="link link-primary text-dark fw-medium text-truncate d-block">{{ Auth::user()->email }}</a>
                    </div>
                </div>
                <div class="pt-2 mt-3 border-top">
                    <ul class="list-unstyled mb-0">
                        <li><a class="profile-link" href="{{ route('agent.profile.view') }}"><i data-lucide="user" class="d-inline-block me-2 size-4"></i> My Profile</a></li>
                        <li><a class="profile-link" href="#!"><i data-lucide="presentation" class="d-inline-block me-2 size-4"></i> Manage Projects</a></li>
                        <li><a class="profile-link" href="#!"><i data-lucide="settings" class="d-inline-block me-2 size-4"></i> Account Settings</a></li>
                        <li><a class="profile-link" href="#!"><i data-lucide="headset" class="d-inline-block me-2 size-4"></i> Help Center</a></li>
                    </ul>
                </div>
                <div class="pt-3 mt-2 border-top">
                    <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form">
                        @csrf
                        <a href="#" class="profile-link pb-0 text-danger" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                            <i data-lucide="log-out" class="d-inline-block me-2 size-4"></i> Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <nav class="navbar-menu px-5" id="navbar-menu-list" data-simplebar>
            <ul class="list-unstyled p-0 navbar-nav-menu">
                <li class="nav-menu-title">Main</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('agent.dashboard.*') ? 'active' : '' }}" href="{{ route('agent.dashboard.index') }}">
                        <span class="icons"><i class="las la-tachometer-alt"></i></span>
                        <span class="content">Dashboard</span>
                    </a>
                </li>

                <li class="nav-menu-title">Property Management</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs(['agent.properties.*','agent.designs.*']) ? '' : 'collapsed' }}"
                       data-bs-toggle="collapse" href="#agentPropertyMenu"
                       aria-expanded="{{ request()->routeIs(['agent.properties.*','agent.designs.*']) ? 'true' : 'false' }}">
                        <span class="icons"><i class="las la-home"></i></span>
                        <span class="content">Properties</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse {{ request()->routeIs(['agent.properties.*','agent.designs.*']) ? 'show' : '' }}" id="agentPropertyMenu">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('agent.properties.land.index') }}" class="nav-link {{ request()->routeIs('agent.properties.land.*') ? 'active' : '' }}">Land</a></li>
                            <li><a href="{{ route('agent.properties.houses.index') }}" class="nav-link {{ request()->routeIs('agent.properties.houses.*') ? 'active' : '' }}">Houses</a></li>
                            <li><a href="{{ route('agent.designs.index') }}" class="nav-link {{ request()->routeIs('agent.designs.*') ? 'active' : '' }}">Architectural Designs</a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-menu-title">Services</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('agents.services.*') ? 'active' : '' }}" href="{{ route('agents.services.index') }}">
                        <span class="icons"><i class="las la-cogs"></i></span>
                        <span class="content">My Services</span>
                    </a>
                </li>

                <li class="nav-menu-title">Communication</li>
                <li class="nav-item">
                    <a class="nav-link" href="#!">
                        <span class="icons"><i class="las la-envelope"></i></span>
                        <span class="content">Inquiries</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#!">
                        <span class="icons"><i class="las la-calendar-alt"></i></span>
                        <span class="content">Appointments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#!">
                        <span class="icons"><i class="las la-star"></i></span>
                        <span class="content">Reviews</span>
                    </a>
                </li>

                <li class="nav-menu-title">Account</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}" href="{{ route('agent.profile.view') }}">
                        <span class="icons"><i class="las la-user"></i></span>
                        <span class="content">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#!">
                        <span class="icons"><i class="las la-gem"></i></span>
                        <span class="content">Subscription / Plan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#!">
                        <span class="icons"><i class="las la-chart-line"></i></span>
                        <span class="content">Analytics</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<div id="sidebar-backdrop" class="sidebar-backdrop"></div>

<style>
    :root {
        --t-primary: #00a667;
        --t-primary-dark: #00834f;
        --t-primary-light: #e6f7ef;
        --t-sidebar-bg: #0f1b16;
        --t-sidebar-bg-active: #15261f;
        --t-text-muted: rgba(255,255,255,.55);
    }
    .main-sidebar { background: var(--t-sidebar-bg); }
    .main-sidebar .navbar-brand { color: #fff; font-weight: 700; letter-spacing: .3px; }
    .main-sidebar .nav-menu-title { color: var(--t-text-muted); font-size: 11px; text-transform: uppercase; letter-spacing: .6px; font-weight: 600; padding: 14px 12px 6px; }
    .main-sidebar .navbar-nav-menu .nav-link { color: rgba(255,255,255,.75); border-radius: 8px; display: flex; align-items: center; gap: 10px; padding: 9px 12px; transition: all .15s ease; }
    .main-sidebar .navbar-nav-menu .nav-link:hover { background: var(--t-sidebar-bg-active); color: #fff; }
    .main-sidebar .navbar-nav-menu .nav-link.active { background: var(--t-primary); color: #fff; font-weight: 500; }
    .main-sidebar .nav-menu-sub { list-style: none; padding-left: 34px; margin: 2px 0 6px; }
    .main-sidebar .nav-menu-sub .nav-link { padding: 7px 10px; font-size: 13.5px; color: rgba(255,255,255,.6); }
    .main-sidebar .nav-menu-sub .nav-link.active, .main-sidebar .nav-menu-sub .nav-link:hover { color: var(--t-primary); background: transparent; }
    .profile-dropdown-menu .profile-link { display: flex; align-items: center; padding: 8px 4px; color: #1f2937; border-radius: 6px; font-size: 14px; }
    .profile-dropdown-menu .profile-link:hover { background: var(--t-primary-light); color: var(--t-primary-dark); }
</style>
