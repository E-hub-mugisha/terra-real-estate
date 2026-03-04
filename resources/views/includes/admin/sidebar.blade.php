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
                <li class="nav-menu-title" data-translate="pe-dashboards">Dashboards</li>
                <li class="nav-item">
                    <a class="nav-link active" data-position="right-top" href="{{ route('admin.dashboard') }}">
                        <span class="icons"><i class="las la-tachometer-alt"></i></span>
                        <span class="content" data-translate="pe-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="nav-menu-title" data-translate="pe-apps">Apps</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseeCommerce" aria-expanded="false">
                        <span class="icons"><i class="las la-home"></i></span>
                        <span class="content" data-translate="pe-property">Property</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseeCommerce">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.properties.land.index') }}" class="nav-link"><span
                                        data-translate="pe-list-view">Land</span></a></li>
                            <li><a href="{{ route('admin.properties.house.index') }}" class="nav-link"><span
                                        data-translate="pe-grid-view">House</span></a></li>
                            <li><a href="{{ route('admin.property.create') }}" class="nav-link"><span
                                        data-translate="pe-add-property">Add Property</span></a></li>
                            <li><a href="apps-property-categories.html" class="nav-link"><span
                                        data-translate="pe-categories-types">Categories / Types</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseChat" aria-expanded="false">
                        <span class="icons"><i class="las la-comments"></i></span>
                        <span class="content" data-translate="pe-chat">Architectural</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseChat">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.architectural-designs.index')}}" class="nav-link"><span
                                        data-translate="pe-default">Architectural Designs</span></a></li>
                            <li><a href="{{ route('admin.design-categories.index')}}" class="nav-link"><span
                                        data-translate="pe-group">Design Category</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseServiceCategory" aria-expanded="false">
                        <span class="icons"><i class="las la-users"></i></span>
                        <span class="content" data-translate="pe-customers">Service</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseServiceCategory">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('services.index')}}" class="nav-link"><span
                                        data-translate="pe-list-view">Services</span></a></li>
                            <li><a href="{{ route('service-categories.index')}}" class="nav-link"><span
                                        data-translate="pe-list-view">Service Category</span></a></li>
                            <li><a href="{{ route('service-subcategories.index')}}" class="nav-link"><span
                                        data-translate="pe-customer-details">Service SubCategory</span></a></li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseUsers&Agencies" aria-expanded="false">
                        <span class="icons"><i class="las la-user-check"></i></span>
                        <span class="content" data-translate="pe-agents-agencies">Users</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseUsers&Agencies">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.agents.index') }}" class="nav-link"><span
                                        data-translate="pe-list-view">Agents</span></a></li>
                            <li><a href="{{ route('admin.professionals.index') }}" class="nav-link"><span
                                        data-translate="pe-create-agent">Professionals</span></a></li>
                            <li><a href="{{ route('admin.consultants.index') }}" class="nav-link"><span
                                        data-translate="pe-create-agent">consultants</span></a></li>
                        </ul>
                    </div>
                </li>
                <!-- tender -->
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseTenders" aria-expanded="false">
                        <span class="icons"><i class="las la-file-contract"></i></span>
                        <span class="content" data-translate="pe-tenders">Tenders</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseTenders">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.tenders.index') }}" class="nav-link"><span
                                        data-translate="pe-list-view">List View</span></a></li>
                            <li><a href="{{ route('admin.tenders.create') }}" class="nav-link"><span
                                        data-translate="pe-create-tender">Create Tender</span></a></li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#News&Ads" aria-expanded="false">
                        <span class="icons"><i class="las la-home"></i></span>
                        <span class="content" data-translate="pe-property">News & Ads</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="News&Ads">
                        <ul class="nav-menu-sub">
                            <li><a href="{{ route('admin.ads.index') }}" class="nav-link"><span
                                        data-translate="pe-list-view">Ads</span></a></li>
                            <li><a href="{{ route('admin.announcements.index') }}" class="nav-link"><span
                                        data-translate="pe-grid-view">Announcements</span></a></li>

                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="sidebar-backdrop" class="sidebar-backdrop"></div>