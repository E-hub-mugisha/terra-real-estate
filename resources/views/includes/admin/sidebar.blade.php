<div id="main-sidebar" class="main-sidebar">
    <div class="sidebar-wrapper">
        <a href="#!" class="navbar-brand">
            <div class="logo-lg">
                <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="40"
                    class="mx-auto logo-dark">
                <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="40"
                    class="mx-auto logo-light">
            </div>
            <div class="logo-sm">
                <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="50"
                    class="mx-auto logo-dark">
                <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" loading="lazy" aria-label="logo" alt="" height="50"
                    class="mx-auto logo-light">
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

                {{-- DASHBOARD --}}
                <li class="nav-menu-title">Dashboard</li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                        <span class="icons"><i class="las la-tachometer-alt"></i></span>
                        <span class="content">Dashboard</span>
                    </a>
                </li>

                {{-- ADMIN MANAGEMENT --}}
                <li class="nav-menu-title">Administration</li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('staff.departments.index') }}">
                        <span class="icons"><i class="las la-building"></i></span>
                        <span class="content">Departments</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.roles.index') }}">
                        <span class="icons"><i class="las la-user-shield"></i></span>
                        <span class="content">Roles</span>
                    </a>
                </li>

                <!-- booking -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.bookings.index') }}">
                        <span class="icons"><i class="las la-calendar-check"></i></span>
                        <span class="content">Bookings</span>
                    </a>
                </li>

                {{-- PROPERTY MANAGEMENT --}}
                <li class="nav-menu-title">Property Management</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseeCommerce">
                        <span class="icons"><i class="las la-home"></i></span>
                        <span class="content">Properties</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseeCommerce">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.properties.lands.index') }}" class="nav-link">Land</a></li>
                            <li><a href="{{ route('admin.properties.houses.index') }}" class="nav-link">House</a></li>
                            <li><a href="{{ route('admin.architectural-designs.index')}}" class="nav-link">Architectural Designs</a></li>
                            <li><a href="{{ route('admin.design-categories.index')}}" class="nav-link">Design Categories</a></li>
                            <li><a href="{{ route('admin.facilities.index') }}" class="nav-link">Facilities</a></li>
                        </ul>
                    </div>
                </li>

                {{-- SERVICES --}}
                <li class="nav-menu-title">Services</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseServiceCategory">
                        <span class="icons"><i class="las la-users"></i></span>
                        <span class="content">Service Management</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseServiceCategory">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('services.index')}}" class="nav-link">Services</a></li>
                            <li><a href="{{ route('service-categories.index')}}" class="nav-link">Categories</a></li>
                            <li><a href="{{ route('service-subcategories.index')}}" class="nav-link">Sub Categories</a></li>
                        </ul>
                    </div>
                </li>

                {{-- USERS --}}
                <li class="nav-menu-title">User Management</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseUsersAgencies">
                        <span class="icons"><i class="las la-user-check"></i></span>
                        <span class="content">Users & Agents</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseUsersAgencies">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.staff.index') }}" class="nav-link">Staff</a></li>
                            <li><a href="{{ route('admin.agents.index') }}" class="nav-link">Agents</a></li>
                            <li><a href="{{ route('admin.professionals.index') }}" class="nav-link">Professionals</a></li>
                            <li><a href="{{ route('admin.consultants.index') }}" class="nav-link">Consultants</a></li>
                            <li><a href="{{ route('admin.users.index') }}" class="nav-link">Users</a></li>
                        </ul>
                    </div>
                </li>

                {{-- CONTENT --}}
                <li class="nav-menu-title">Content & Media</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#NewsAds">
                        <span class="icons"><i class="las la-bullhorn"></i></span>
                        <span class="content">News & Ads</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="NewsAds">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.advertisements.index') }}" class="nav-link">Advertisements</a></li>
                            <li><a href="{{ route('admin.announcements.index') }}" class="nav-link">Announcements</a></li>
                            <li><a href="{{ route('admin.blogs.index') }}" class="nav-link">News</a></li>
                            <li><a href="{{ route('admin.blog-categories.index') }}" class="nav-link">News Categories</a></li>
                            <li><a href="{{ route('admin.job-listings.index') }}" class="nav-link">Job Listings</a></li>
                        </ul>
                    </div>
                </li>

                {{-- BUSINESS --}}
                <li class="nav-menu-title">Business</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseTenders">
                        <span class="icons"><i class="las la-file-contract"></i></span>
                        <span class="content">Tenders</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseTenders">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.tenders.index') }}" class="nav-link">Tenders</a></li>
                            <li><a href="{{ route('admin.tasks.index') }}" class="nav-link">Tasks</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.partners.index') }}" class="nav-link">
                        <span class="icons"><i class="las la-handshake"></i></span>
                        <span class="content">Partners</span>
                    </a>
                </li>

                {{-- FINANCE --}}
                <li class="nav-menu-title">Finance & Plans</li>

                <li class="nav-item">
                    <a href="{{ route('admin.commissions.index') }}" class="nav-link">
                        <span class="icons"><i class="las la-handshake"></i></span>
                        <span class="content">Commissions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.listing-packages.index') }}" class="nav-link">
                        <span class="icons"><i class="las la-box"></i></span>
                        <span class="content">Listing Packages</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.commission-tiers.index') }}" class="nav-link">
                        <span class="icons"><i class="las la-tags"></i></span>
                        <span class="content">Commission Tiers</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.agent-levels.index') }}" class="nav-link">
                        <span class="icons"><i class="las la-level-up-alt"></i></span>
                        <span class="content">Agent Levels</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.duration-discounts.index') }}" class="nav-link">
                        <span class="icons"><i class="las la-clock"></i></span>
                        <span class="content">Duration Discounts</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<div id="sidebar-backdrop" class="sidebar-backdrop"></div>