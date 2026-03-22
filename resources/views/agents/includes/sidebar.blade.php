<div id="main-sidebar" class="main-sidebar">
    <div class="sidebar-wrapper">
        <a href="#!" class="navbar-brand">
            {{ config('app.name') }}
            <div class="logo-lg">
                {{ config('app.name') }}
                <!-- <img src="{{ asset('dashboard/assets/images/main-logo.png') }}" loading="lazy" aria-label="logo" alt="" height="18"
                    class="mx-auto logo-dark">
                <img src="{{ asset('dashboard/assets/images/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="18"
                    class="mx-auto logo-light"> -->
            </div>
            <div class="logo-sm">
                {{ config('app.name') }}
                <!-- <img src="{{ asset('dashboard/assets/images/logo-sm.png') }}" loading="lazy" aria-label="logo" alt="" height="22"
                    class="mx-auto logo-dark">
                <img src="{{ asset('dashboard/assets/images/logo-sm-white.png') }}" loading="lazy" aria-label="logo" alt="" height="22"
                    class="mx-auto logo-light"> -->
            </div>
        </a>
        <div class="dropdown profile-dropdown">
            <a href="#!" class="btn d-flex align-items-center w-100 gap-2 p-4 text-start" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="{{ asset('dashboard/assets/images/user.jfif') }}" loading="lazy" alt="" class="size-10 rounded">
                <div class="flex-grow-1 content">
                    <h6 class="fw-medium text-truncate mb-0 text-white" data-translate="pe-sophia-martinez">{{ Auth::user()->name }}</h6>
                    <p class="fs-14">ID: {{ Auth::user()->id }}</p>
                </div>
                <div class="arrow">
                    <i data-lucide="chevron-down" class="size-4 "></i>
                </div>
            </a>
            <div class="dropdown-menu p-4 profile-dropdown-menu">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('dashboard/assets/images/user.jfif') }}" loading="lazy" alt=""
                        class="rounded-circle size-10 flex-shrink-0">
                    <div class="flex-grow-1 overflow-hidden">
                        <h6 class="mb-0 text-truncate">{{ Auth::user()->name }}</h6>
                        <p class="mb-0 text-truncate"><a href="#!"
                                class="link link-primary text-dark fw-medium">{{ Auth::user()->email }}</a></p>
                    </div>
                </div>
                <div class="pt-2 mt-3 border-top">
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a class="profile-link" href="pages-user-activity.html"><i data-lucide="bell-dot"
                                    class="d-inline-block me-2 size-4"></i> Profile Activity</a>
                        </li>
                        <li>
                            <a class="profile-link" href="pages-user-projects.html"><i data-lucide="presentation"
                                    class="d-inline-block me-2 size-4"></i> Manage Projects</a>
                        </li>
                        <li>
                            <a class="profile-link" href="pages-account-settings.html"><i data-lucide="settings"
                                    class="d-inline-block me-2 size-4"></i> Account Settings</a>
                        </li>
                        <li>
                            <a class="profile-link" href="pages-help-center.html"><i data-lucide="headset"
                                    class="d-inline-block me-2 size-4"></i> Help Center</a>
                        </li>
                        <li>
                            <a class="profile-link" href="pages-pricing.html"><i data-lucide="gem"
                                    class="d-inline-block me-2 size-4"></i> Upgrade Plan</a>
                        </li>
                    </ul>
                </div>
                <div class="pt-3 mt-2 border-top">
                    <a class="profile-link pb-0" href="auth-signin-basic.html"><i data-lucide="log-out"
                            class="inline-block me-2 size-4"></i> Log Out</a>
                </div>
            </div>
        </div>
        <div class="navbar-menu px-5" id="navbar-menu-list" data-simplebar>
            <ul class="list-unstyled p-0 navbar-nav-menu">
                <li class="nav-menu-title">Main</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('agent.dashboard.*') ? 'active' : '' }}"
                        href="{{ route('agent.dashboard.index') }}">
                        <span class="icons"><i class="las la-tachometer-alt"></i></span>
                        <span class="content">Dashboard</span>
                    </a>
                </li>

                <li class="nav-menu-title">Property Management</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-toggle="collapse"
                        href="#agentPropertyMenu" aria-expanded="false">
                        <span class="icons"><i class="las la-home"></i></span>
                        <span class="content">Properties</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="agentPropertyMenu">
                        <ul class="nav-menu-sub">
                            <li>
                                <a href="{{ route('agent.properties.land.index') }}" class="nav-link">
                                    Land
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('agent.properties.houses.index') }}" class="nav-link">
                                    Houses
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('agent.designs.index') }}" class="nav-link">
                                    Architectural Designs
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-menu-title">Services</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('agents.services.*') ? 'active' : '' }}"
                        href="{{ route('agents.services.index') }}">
                        <span class="icons"><i class="las la-cogs"></i></span>
                        <span class="content">My Services</span>
                    </a>
                </li>

                <li class="nav-menu-title">Communication</li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icons"><i class="las la-envelope"></i></span>
                        <span class="content">Inquiries</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icons"><i class="las la-calendar-alt"></i></span>
                        <span class="content">Appointments</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icons"><i class="las la-star"></i></span>
                        <span class="content">Reviews</span>
                    </a>
                </li>

                <li class="nav-menu-title">Account</li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agent.profile.view') }}">
                        <span class="icons"><i class="las la-user"></i></span>
                        <span class="content">Profile</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icons"><i class="las la-gem"></i></span>
                        <span class="content">Subscription / Plan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="icons"><i class="las la-chart-line"></i></span>
                        <span class="content">Analytics</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<div id="sidebar-backdrop" class="sidebar-backdrop"></div>