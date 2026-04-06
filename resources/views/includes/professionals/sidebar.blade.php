<div id="main-sidebar" class="main-sidebar">
    <div class="sidebar-wrapper">

        {{-- Logo --}}
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <div class="logo-lg">
                <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="40" class="mx-auto logo-dark">
                <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="40" class="mx-auto logo-light">
            </div>
            <div class="logo-sm">
                <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="50" class="mx-auto logo-dark">
                <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="50" class="mx-auto logo-light">
            </div>
        </a>

        {{-- Profile --}}
        <div class="dropdown profile-dropdown">
            <a href="#!" class="btn d-flex align-items-center w-100 gap-2 p-4 text-start" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="avatar-title bg-primary text-white fw-bold rounded-circle size-10 d-flex align-items-center justify-content-center fs-16">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                </span>
                <div class="flex-grow-1 content overflow-hidden">
                    <h6 class="fw-medium text-truncate mb-0 text-white">{{ Auth::user()->name }}</h6>
                    <p class="fs-12 mb-0 text-white-50">Administrator</p>
                </div>
                <div class="arrow">
                    <i data-lucide="chevron-down" class="size-4"></i>
                </div>
            </a>
            <div class="dropdown-menu p-4 profile-dropdown-menu">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar-title bg-primary text-white fw-bold rounded-circle size-10 flex-shrink-0 d-flex align-items-center justify-content-center">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                    </span>
                    <div class="flex-grow-1 overflow-hidden">
                        <h6 class="mb-0 text-truncate">{{ Auth::user()->name }}</h6>
                        <p class="mb-0 text-truncate fs-13 text-muted">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <div class="pt-2 mt-3 border-top">
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a class="profile-link" href="{{ route('activity-logs.index') }}">
                                <i data-lucide="activity" class="d-inline-block me-2 size-4"></i> Activity Logs
                            </a>
                        </li>
                        <li>
                            <a class="profile-link" href="{{ route('admin.roles.index') }}">
                                <i data-lucide="shield" class="d-inline-block me-2 size-4"></i> Roles & Permissions
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="admin-logout-form">
                                @csrf
                                <a href="#" class="profile-link pb-0"
                                   onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                    <i data-lucide="log-out" class="d-inline-block me-2 size-4"></i> Log Out
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="navbar-menu px-5" id="navbar-menu-list" data-simplebar>
            <ul class="list-unstyled p-0 navbar-nav-menu">

                {{-- DASHBOARD --}}
                <li class="nav-menu-title">Overview</li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                       href="{{ route('admin.dashboard') }}">
                        <span class="icons"><i class="las la-tachometer-alt"></i></span>
                        <span class="content">Dashboard</span>
                    </a>
                </li>

                {{-- ADMINISTRATION --}}
                <li class="nav-menu-title">Administration</li>

                <li class="nav-item">
                    <a class="nav-link collapsed {{ request()->routeIs('admin.roles.*') || request()->routeIs('staff.departments.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#collapseAdmin">
                        <span class="icons"><i class="las la-shield-alt"></i></span>
                        <span class="content">Access Control</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.roles.*') || request()->routeIs('staff.departments.*') ? 'show' : '' }}"
                         id="collapseAdmin">
                        <ul class="nav-menu-sub">
                            <li>
                                <a href="{{ route('staff.departments.index') }}"
                                   class="nav-link {{ request()->routeIs('staff.departments.*') ? 'active' : '' }}">
                                    Departments
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.roles.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                    Roles & Permissions
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}"
                       href="{{ route('admin.staff.index') }}">
                        <span class="icons"><i class="las la-user-tie"></i></span>
                        <span class="content">Staff</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}"
                       href="{{ route('activity-logs.index') }}">
                        <span class="icons"><i class="las la-history"></i></span>
                        <span class="content">Activity Logs</span>
                    </a>
                </li>

                {{-- PROPERTY MANAGEMENT --}}
                <li class="nav-menu-title">Property Management</li>

                <li class="nav-item">
                    <a class="nav-link collapsed {{ request()->routeIs('admin.properties.*') || request()->routeIs('admin.architectural-designs.*') || request()->routeIs('admin.design-categories.*') || request()->routeIs('admin.facilities.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#collapseProperties">
                        <span class="icons"><i class="las la-home"></i></span>
                        <span class="content">Properties</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.properties.*') || request()->routeIs('admin.architectural-designs.*') || request()->routeIs('admin.design-categories.*') || request()->routeIs('admin.facilities.*') ? 'show' : '' }}"
                         id="collapseProperties">
                        <ul class="nav-menu-sub">
                            <li>
                                <a href="{{ route('admin.properties.lands.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.properties.lands.*') ? 'active' : '' }}">
                                    Land Listings
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.properties.houses.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.properties.houses.*') ? 'active' : '' }}">
                                    House Listings
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.architectural-designs.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.architectural-designs.*') ? 'active' : '' }}">
                                    Architectural Designs
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.design-categories.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.design-categories.*') ? 'active' : '' }}">
                                    Design Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.facilities.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
                                    Facilities
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- SERVICES --}}
                <li class="nav-menu-title">Services</li>

                <li class="nav-item">
                    <a class="nav-link collapsed {{ request()->routeIs('services.*') || request()->routeIs('service-categories.*') || request()->routeIs('service-subcategories.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#collapseServices">
                        <span class="icons"><i class="las la-concierge-bell"></i></span>
                        <span class="content">Service Management</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('services.*') || request()->routeIs('service-categories.*') || request()->routeIs('service-subcategories.*') ? 'show' : '' }}"
                         id="collapseServices">
                        <ul class="nav-menu-sub">
                            <li>
                                <a href="{{ route('services.index') }}"
                                   class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                                    Services
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('service-categories.index') }}"
                                   class="nav-link {{ request()->routeIs('service-categories.*') ? 'active' : '' }}">
                                    Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('service-subcategories.index') }}"
                                   class="nav-link {{ request()->routeIs('service-subcategories.*') ? 'active' : '' }}">
                                    Sub Categories
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- USER MANAGEMENT --}}
                <li class="nav-menu-title">User Management</li>

                <li class="nav-item">
                    <a class="nav-link collapsed {{ request()->routeIs('admin.agents.*') || request()->routeIs('admin.professionals.*') || request()->routeIs('admin.consultants.*') || request()->routeIs('admin.users.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#collapseUsers">
                        <span class="icons"><i class="las la-users"></i></span>
                        <span class="content">Users & Agents</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.agents.*') || request()->routeIs('admin.professionals.*') || request()->routeIs('admin.consultants.*') || request()->routeIs('admin.users.*') ? 'show' : '' }}"
                         id="collapseUsers">
                        <ul class="nav-menu-sub">
                            <li>
                                <a href="{{ route('admin.agents.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
                                    Agents
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.professionals.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.professionals.*') ? 'active' : '' }}">
                                    Professionals
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.consultants.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.consultants.*') ? 'active' : '' }}">
                                    Consultants
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    General Users
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- CONTENT & MEDIA --}}
                <li class="nav-menu-title">Content & Media</li>

                <li class="nav-item">
                    <a class="nav-link collapsed {{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.announcements.*') || request()->routeIs('admin.ads.*') || request()->routeIs('admin.job-listings.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#collapseContent">
                        <span class="icons"><i class="las la-newspaper"></i></span>
                        <span class="content">News & Media</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blog-categories.*') || request()->routeIs('admin.announcements.*') || request()->routeIs('admin.ads.*') || request()->routeIs('admin.job-listings.*') ? 'show' : '' }}"
                         id="collapseContent">
                        <ul class="nav-menu-sub">
                            <li>
                                <a href="{{ route('admin.blogs.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                                    News Articles
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.blog-categories.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
                                    News Categories
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.announcements.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                                    Announcements
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.ads.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.ads.*') ? 'active' : '' }}">
                                    Promo Ads
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.job-listings.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.job-listings.*') ? 'active' : '' }}">
                                    Job Listings
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- BUSINESS --}}
                <li class="nav-menu-title">Business</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.tenders.*') ? 'active' : '' }}"
                       href="{{ route('admin.tenders.index') }}">
                        <span class="icons"><i class="las la-file-contract"></i></span>
                        <span class="content">Tenders</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.advertisements.*') ? 'active' : '' }}"
                       href="{{ route('admin.advertisements.index') }}">
                        <span class="icons"><i class="las la-ad"></i></span>
                        <span class="content">Advertisements</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}"
                       href="{{ route('admin.partners.index') }}">
                        <span class="icons"><i class="las la-handshake"></i></span>
                        <span class="content">Partners</span>
                    </a>
                </li>

                {{-- FINANCE & PLANS --}}
                <li class="nav-menu-title">Finance & Plans</li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.commissions.*') ? 'active' : '' }}"
                       href="{{ route('admin.commissions.index') }}">
                        <span class="icons"><i class="las la-percentage"></i></span>
                        <span class="content">Commissions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed {{ request()->routeIs('admin.listing-packages.*') || request()->routeIs('admin.commission-tiers.*') || request()->routeIs('admin.agent-levels.*') || request()->routeIs('admin.duration-discounts.*') ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#collapseFinance">
                        <span class="icons"><i class="las la-cog"></i></span>
                        <span class="content">Pricing Config</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.listing-packages.*') || request()->routeIs('admin.commission-tiers.*') || request()->routeIs('admin.agent-levels.*') || request()->routeIs('admin.duration-discounts.*') ? 'show' : '' }}"
                         id="collapseFinance">
                        <ul class="nav-menu-sub">
                            <li>
                                <a href="{{ route('admin.listing-packages.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.listing-packages.*') ? 'active' : '' }}">
                                    Listing Packages
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.commission-tiers.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.commission-tiers.*') ? 'active' : '' }}">
                                    Commission Tiers
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.agent-levels.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.agent-levels.*') ? 'active' : '' }}">
                                    Agent Levels
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.duration-discounts.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.duration-discounts.*') ? 'active' : '' }}">
                                    Duration Discounts
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
<div id="sidebar-backdrop" class="sidebar-backdrop"></div>
