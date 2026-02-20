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
                <!-- <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseChat" aria-expanded="false">
                        <span class="icons"><i class="las la-comments"></i></span>
                        <span class="content" data-translate="pe-chat">Chat</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseChat">
                        <ul class="nav-menu-sub">
                            <li><a href="apps-chat-default.html" class="nav-link"><span
                                        data-translate="pe-default">Default</span></a></li>
                            <li><a href="apps-chat-group.html" class="nav-link"><span
                                        data-translate="pe-group">Group</span></a></li>
                            <li><a href="apps-chat-group-video.html" class="nav-link"><span
                                        data-translate="pe-video-call">Video Call</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseCalendar" aria-expanded="false">
                        <span class="icons"><i class="las la-calendar-minus"></i></span>
                        <span class="content" data-translate="pe-calendar">Calendar</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseCalendar">
                        <ul class="nav-menu-sub">
                            <li><a href="apps-calendar-default.html" class="nav-link"><span
                                        data-translate="pe-default">Default</span></a></li>
                            <li><a href="apps-calendar-weeknumber.html" class="nav-link"><span
                                        data-translate="pe-week-number">Week Number</span></a></li>
                            <li><a href="apps-calendar-localize.html" class="nav-link"><span
                                        data-translate="pe-localize">Localize</span></a></li>
                            <li><a href="apps-calendar-dayview.html" class="nav-link"><span
                                        data-translate="pe-day-view">Day View</span></a></li>
                            <li><a href="apps-calendar-listview.html" class="nav-link"><span
                                        data-translate="pe-list-view">List View</span></a></li>
                            <li><a href="apps-calendar-timegrid.html" class="nav-link"><span
                                        data-translate="pe-time-grid-view">Time Grid View</span></a></li>
                            <li><a href="apps-calendar-multi-month-stack.html" class="nav-link"><span
                                        data-translate="pe-multi-month-stack">Multi-Month Stack</span></a></li>
                            <li><a href="apps-calendar-multi-month-grid.html" class="nav-link"><span
                                        data-translate="pe-multi-month-grid">Multi-Month Grid</span></a></li>
                            <li><a href="apps-calendar-timeline.html" class="nav-link"><span
                                        data-translate="pe-timeline">Timeline</span></a></li>
                            <li><a href="apps-calendar-date-nav-link.html" class="nav-link"><span
                                        data-translate="pe-date-nav-link">Date Nav Link</span></a></li>
                            <li><a href="apps-calendar-date-clicking.html" class="nav-link"><span
                                        data-translate="pe-clicking-selecting">Clicking &amp; Selecting</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseEmail" aria-expanded="false">
                        <span class="icons"><i class="las la-envelope"></i></span>
                        <span class="content" data-translate="pe-email">Email</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseEmail">
                        <ul class="nav-menu-sub">
                            <li><a href="apps-mailbox.html" class="nav-link"><span
                                        data-translate="pe-mailbox">Mailbox</span></a></li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseTemplates" aria-expanded="false">
                                    <span data-translate="pe-templates">Templates</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseTemplates">
                                    <ul class="nav-menu-sub">
                                        <li><a href="apps-email-templates-welcome.html" class="nav-link"><span
                                                    data-translate="pe-welcome">Welcome</span></a></li>
                                        <li><a href="apps-email-templates-newsletter.html" class="nav-link"><span
                                                    data-translate="pe-newsletter">NewsLetter</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="apps-review.html">
                        <span class="icons"><i class="las la-pen-nib"></i></span>
                        <span class="content" data-translate="pe-review">Review</span>
                    </a>
                </li> -->
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
                <!-- <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseCustomers" aria-expanded="false">
                        <span class="icons"><i class="las la-users"></i></span>
                        <span class="content" data-translate="pe-customers">Customers</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseCustomers">
                        <ul class="nav-menu-sub">
                            <li><a href="apps-customer-listview.html" class="nav-link"><span
                                        data-translate="pe-list-view">List View</span></a></li>
                            <li><a href="apps-customer-details.html" class="nav-link"><span
                                        data-translate="pe-customer-details">Customer Details</span></a></li>
                        </ul>
                    </div>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link collapsed" href="apps-contact-requests.html">
                        <span class="icons"><i class="las la-question-circle"></i></span>
                        <span class="content" data-translate="pe-contact-requests">Contact Requests</span>
                    </a>
                </li> -->
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
                <!-- <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseTransactions" aria-expanded="false">
                        <span class="icons"><i class="las la-credit-card"></i></span>
                        <span class="content" data-translate="pe-transactions">Transactions</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseTransactions">
                        <ul class="nav-menu-sub">
                            <li><a href="apps-transictions-listview.html" class="nav-link"><span
                                        data-translate="pe-list-view">List View</span></a></li>
                            <li><a href="apps-transictions-add.html" class="nav-link"><span
                                        data-translate="pe-add-transaction">Add Transaction</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseInvoices" aria-expanded="false">
                        <span class="icons"><i class="las la-file-alt"></i></span>
                        <span class="content" data-translate="pe-invoices">Invoices</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseInvoices">
                        <ul class="nav-menu-sub">
                            <li><a href="apps-invoice-listview.html" class="nav-link"><span
                                        data-translate="pe-list-view">List View</span></a></li>
                            <li><a href="apps-invoices-add.html" class="nav-link"><span
                                        data-translate="pe-create-invoice">Create Invoice</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="apps-tracking.html">
                        <span class="icons"><i class="las la-compass"></i></span>
                        <span class="content" data-translate="pe-tracking">Tracking</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="apps-revenue-report.html">
                        <span class="icons"><i class="las la-chart-bar"></i></span>
                        <span class="content" data-translate="pe-revenue">Revenue</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="apps-booking.html">
                        <span class="icons"><i class="las la-calendar-alt"></i></span>
                        <span class="content" data-translate="pe-booking">Booking</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="apps-schedule.html">
                        <span class="icons"><i class="las la-clock"></i></span>
                        <span class="content" data-translate="pe-schedule">Schedule</span>
                    </a>
                </li>
                <li class="nav-menu-title" data-translate="pe-pages">Pages</li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseAuthentication" aria-expanded="false">
                        <span class="icons"><i class="las la-user-friends"></i></span>
                        <span class="content" data-translate="pe-authentication">Authentication</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseAuthentication">
                        <ul class="nav-menu-sub">
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseSignIn" aria-expanded="false">
                                    <span data-translate="pe-sign-in">Sign In</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseSignIn">
                                    <ul class="nav-menu-sub">
                                        <li><a href="auth-signin-basic.html" class="nav-link"><span
                                                    data-translate="pe-basic">Basic</span></a></li>
                                        <li><a href="auth-signin-modern.html" class="nav-link"><span
                                                    data-translate="pe-modern">Modern</span></a></li>
                                        <li><a href="auth-signin-creative.html" class="nav-link"><span
                                                    data-translate="pe-creative">Creative</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseSignUp" aria-expanded="false">
                                    <span data-translate="pe-sign-up">Sign Up</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseSignUp">
                                    <ul class="nav-menu-sub">
                                        <li><a href="auth-signup-basic.html" class="nav-link"><span
                                                    data-translate="pe-basic">Basic</span></a></li>
                                        <li><a href="auth-signup-modern.html" class="nav-link"><span
                                                    data-translate="pe-modern">Modern</span></a></li>
                                        <li><a href="auth-signup-creative.html" class="nav-link"><span
                                                    data-translate="pe-creative">Creative</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseForgotPassword" aria-expanded="false">
                                    <span data-translate="pe-forgot-password">Forgot Password</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseForgotPassword">
                                    <ul class="nav-menu-sub">
                                        <li><a href="auth-forgot-password-basic.html" class="nav-link"><span
                                                    data-translate="pe-basic">Basic</span></a></li>
                                        <li><a href="auth-forgot-password-modern.html" class="nav-link"><span
                                                    data-translate="pe-modern">Modern</span></a></li>
                                        <li><a href="auth-forgot-password-creative.html" class="nav-link"><span
                                                    data-translate="pe-creative">Creative</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseTwoStepVerification" aria-expanded="false">
                                    <span data-translate="pe-two-step-verification">Two Step Verification</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseTwoStepVerification">
                                    <ul class="nav-menu-sub">
                                        <li><a href="auth-two-step-verification-basic.html" class="nav-link"><span
                                                    data-translate="pe-basic">Basic</span></a></li>
                                        <li><a href="auth-two-step-verification-modern.html" class="nav-link"><span
                                                    data-translate="pe-modern">Modern</span></a></li>
                                        <li><a href="auth-two-step-verification-creative.html"
                                                class="nav-link"><span
                                                    data-translate="pe-creative">Creative</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseResetPassword" aria-expanded="false">
                                    <span data-translate="pe-reset-password">Reset Password</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseResetPassword">
                                    <ul class="nav-menu-sub">
                                        <li><a href="auth-reset-password-basic.html" class="nav-link"><span
                                                    data-translate="pe-basic">Basic</span></a></li>
                                        <li><a href="auth-reset-password-modern.html" class="nav-link"><span
                                                    data-translate="pe-modern">Modern</span></a></li>
                                        <li><a href="auth-reset-password-creative.html" class="nav-link"><span
                                                    data-translate="pe-creative">Creative</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseSuccessfulPassword" aria-expanded="false">
                                    <span data-translate="pe-successful-password">Successful Password</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseSuccessfulPassword">
                                    <ul class="nav-menu-sub">
                                        <li><a href="auth-successful-password-basic.html" class="nav-link"><span
                                                    data-translate="pe-basic">Basic</span></a></li>
                                        <li><a href="auth-successful-password-modern.html" class="nav-link"><span
                                                    data-translate="pe-modern">Modern</span></a></li>
                                        <li><a href="auth-successful-password-creative.html" class="nav-link"><span
                                                    data-translate="pe-creative">Creative</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseAccountDeactivation" aria-expanded="false">
                                    <span data-translate="pe-account-deactivation">Account Deactivation</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseAccountDeactivation">
                                    <ul class="nav-menu-sub">
                                        <li><a href="auth-account-deactivation-basic.html" class="nav-link"><span
                                                    data-translate="pe-basic">Basic</span></a></li>
                                        <li><a href="auth-account-deactivation-modern.html" class="nav-link"><span
                                                    data-translate="pe-modern">Modern</span></a></li>
                                        <li><a href="auth-account-deactivation-creative.html" class="nav-link"><span
                                                    data-translate="pe-creative">Creative</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-position="right-top"
                        data-bs-toggle="collapse" href="#collapsePages" aria-expanded="false">
                        <span class="icons"><i class="las la-box"></i></span>
                        <span class="content" data-translate="pe-pages">Pages</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapsePages">
                        <ul class="nav-menu-sub">
                            <li><a href="pages-starter.html" class="nav-link"><span
                                        data-translate="pe-blank">Blank</span></a></li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseAccount" aria-expanded="false">
                                    <span data-translate="pe-account">Account</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseAccount">
                                    <ul class="nav-menu-sub">
                                        <li><a href="pages-account-settings.html" class="nav-link"><span
                                                    data-translate="pe-account">Account</span></a></li>
                                        <li><a href="pages-account-security.html" class="nav-link"><span
                                                    data-translate="pe-security">Security</span></a></li>
                                        <li><a href="pages-account-billing-plan.html" class="nav-link"><span
                                                    data-translate="pe-billing-plans">Billing &amp; Plans</span></a>
                                        </li>
                                        <li><a href="pages-account-notification.html" class="nav-link"><span
                                                    data-translate="pe-notification">Notification</span></a></li>
                                        <li><a href="pages-account-statements.html" class="nav-link"><span
                                                    data-translate="pe-statements">Statements</span></a></li>
                                        <li><a href="pages-account-logs.html" class="nav-link"><span
                                                    data-translate="pe-logs">Logs</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseUserProfile" aria-expanded="false">
                                    <span data-translate="pe-user-profile">User Profile</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseUserProfile">
                                    <ul class="nav-menu-sub">
                                        <li><a href="pages-user.html" class="nav-link"><span
                                                    data-translate="pe-overview">Overview</span></a></li>
                                        <li><a href="pages-user-activity.html" class="nav-link"><span
                                                    data-translate="pe-activity">Activity</span></a></li>
                                        <li><a href="pages-user-followers.html" class="nav-link"><span
                                                    data-translate="pe-followers">Followers</span></a></li>
                                        <li><a href="pages-user-documents.html" class="nav-link"><span
                                                    data-translate="pe-documents">Documents</span></a></li>
                                        <li><a href="pages-user-notes.html" class="nav-link"><span
                                                    data-translate="pe-notes">Notes</span></a></li>
                                        <li><a href="pages-user-projects.html" class="nav-link"><span
                                                    data-translate="pe-projects">Projects</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapsePricing" aria-expanded="false">
                                    <span data-translate="pe-pricing">Pricing</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapsePricing">
                                    <ul class="nav-menu-sub">
                                        <li><a href="pages-pricing.html" class="nav-link"><span
                                                    data-translate="pe-user">User</span></a></li>
                                        <li><a href="pages-pricing-admin.html" class="nav-link"><span
                                                    data-translate="pe-admin">Admin</span></a></li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="pages-contact-us.html" class="nav-link"><span
                                        data-translate="pe-contact-us">Contact Us</span></a></li>
                            <li><a href="pages-faq.html" class="nav-link"><span
                                        data-translate="pe-faqs">FAQ's</span></a></li>
                            <li><a href="pages-licenses.html" class="nav-link"><span
                                        data-translate="pe-licenses">Licenses</span></a></li>
                            <li><a href="pages-coming-soon.html" class="nav-link"><span
                                        data-translate="pe-coming-soon">Coming Soon</span></a></li>
                            <li><a href="pages-maintenance.html" class="nav-link"><span
                                        data-translate="pe-maintenance">Maintenance</span></a></li>
                            <li><a href="pages-privacy-policy.html" class="nav-link"><span
                                        data-translate="pe-privacy-policy">Privacy Policy</span></a></li>
                            <li><a href="pages-help-center.html" class="nav-link"><span
                                        data-translate="pe-help-center">Help Center</span></a></li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseErrorPages" aria-expanded="false">
                                    <span data-translate="pe-error-pages">Error Pages</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseErrorPages">
                                    <ul class="nav-menu-sub">
                                        <li><a href="pages-404.html" class="nav-link"><span
                                                    data-translate="pe-404">404</span></a></li>
                                        <li><a href="pages-500.html" class="nav-link"><span
                                                    data-translate="pe-500">500</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseWidgets" aria-expanded="false">
                        <span class="icons"><i class="las la-th-large"></i></span>
                        <span class="content" data-translate="pe-widgets">Widgets</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseWidgets">
                        <ul class="nav-menu-sub">
                            <li><a href="widgets-cards.html" class="nav-link"><span
                                        data-translate="pe-cards">Cards</span></a></li>
                            <li><a href="widgets-banners.html" class="nav-link"><span
                                        data-translate="pe-banners">Banners</span></a></li>
                            <li><a href="widgets-charts.html" class="nav-link"><span
                                        data-translate="pe-charts">Charts</span></a></li>
                            <li><a href="widgets-data.html" class="nav-link"><span
                                        data-translate="pe-data">Data</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-menu-title" data-translate="pe-components">Components</li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseUIElements" aria-expanded="false">
                        <span class="icons"><i class="las la-key"></i></span>
                        <span class="content" data-translate="pe-ui-elements">UI Elements</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseUIElements">
                        <ul class="nav-menu-sub">
                            <li><a href="ui-alerts.html" class="nav-link"><span
                                        data-translate="pe-alerts">Alerts</span></a></li>
                            <li><a href="ui-badge.html" class="nav-link"><span
                                        data-translate="pe-badges">Badges</span></a></li>
                            <li><a href="ui-breadcrumb.html" class="nav-link"><span
                                        data-translate="pe-breadcrumb">Breadcrumb</span></a></li>
                            <li><a href="ui-buttons-group.html" class="nav-link"><span
                                        data-translate="pe-buttons-group">Buttons Group</span></a></li>
                            <li><a href="ui-buttons.html" class="nav-link"><span
                                        data-translate="pe-buttons">Buttons</span></a></li>
                            <li><a href="ui-button-navigation.html" class="nav-link"><span
                                        data-translate="pe-buttons-navigation">Buttons Navigation</span></a></li>
                            <li><a href="ui-dropdown.html" class="nav-link"><span
                                        data-translate="pe-dropdown">Dropdown</span></a></li>
                            <li><a href="ui-loader.html" class="nav-link"><span
                                        data-translate="pe-loader">Loader</span></a></li>
                            <li><a href="ui-accordion.html" class="nav-link"><span
                                        data-translate="pe-accordion">Accordion</span></a></li>
                            <li><a href="ui-modal.html" class="nav-link"><span
                                        data-translate="pe-modal">Modal</span></a></li>
                            <li><a href="ui-links.html" class="nav-link"><span
                                        data-translate="pe-links">Links</span></a></li>
                            <li><a href="ui-tabs.html" class="nav-link"><span
                                        data-translate="pe-tabs">Tabs</span></a></li>
                            <li><a href="ui-drawer.html" class="nav-link"><span
                                        data-translate="pe-drawer">Drawer</span></a></li>
                            <li><a href="ui-pagination.html" class="nav-link"><span
                                        data-translate="pe-pagination">Pagination</span></a></li>
                            <li><a href="ui-progress-bar.html" class="nav-link"><span
                                        data-translate="pe-progress-bar">Progress Bar</span></a></li>
                            <li><a href="ui-tooltips.html" class="nav-link"><span
                                        data-translate="pe-tooltips">Tooltips</span></a></li>
                            <li><a href="ui-cards.html" class="nav-link"><span
                                        data-translate="pe-cards">Cards</span></a></li>
                            <li><a href="ui-timeline.html" class="nav-link"><span
                                        data-translate="pe-timeline">Timeline</span></a></li>
                            <li><a href="ui-notification.html" class="nav-link"><span
                                        data-translate="pe-notification">Notification</span></a></li>
                            <li><a href="ui-list-group.html" class="nav-link"><span
                                        data-translate="pe-list-group">List Group</span></a></li>
                            <li><a href="ui-cookie.html" class="nav-link"><span
                                        data-translate="pe-cookie-consent">Cookie Consent</span></a></li>
                            <li><a href="ui-gallery.html" class="nav-link"><span
                                        data-translate="pe-gallery">Gallery</span></a></li>
                            <li><a href="ui-video.html" class="nav-link"><span
                                        data-translate="pe-video">Video</span></a></li>
                            <li><a href="ui-colors.html" class="nav-link"><span
                                        data-translate="pe-colors">Colors</span></a></li>
                            <li><a href="ui-typography.html" class="nav-link"><span
                                        data-translate="pe-typography">Typography</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseAdvancedUI" aria-expanded="false">
                        <span class="icons"><i class="las la-gem"></i></span>
                        <span class="content" data-translate="pe-advanced-ui">Advanced UI</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseAdvancedUI">
                        <ul class="nav-menu-sub">
                            <li><a href="ui-advanced-animation.html" class="nav-link"><span
                                        data-translate="pe-animation">Animation</span></a></li>
                            <li><a href="ui-advanced-sweetalerts.html" class="nav-link"><span
                                        data-translate="pe-sweetalerts">SweetAlerts</span></a></li>
                            <li><a href="ui-advanced-simplebar.html" class="nav-link"><span
                                        data-translate="pe-simplebar">Simplebar</span></a></li>
                            <li><a href="ui-advanced-swiper.html" class="nav-link"><span
                                        data-translate="pe-swiper">Swiper</span></a></li>
                            <li><a href="ui-advanced-3d-effect.html" class="nav-link"><span
                                        data-translate="pe-3d-effect">3D Effect</span></a></li>
                            <li><a href="ui-advanced-word-counter.html" class="nav-link"><span
                                        data-translate="pe-word-counter">Word Counter</span></a></li>
                            <li><a href="ui-advanced-bot.html" class="nav-link"><span
                                        data-translate="pe-chat-bot">Chat Bot</span></a></li>
                            <li><a href="ui-advanced-image-annotation.html" class="nav-link"><span
                                        data-translate="pe-images-annotation">Images Annotation</span></a></li>
                            <li><a href="ui-advanced-tree.html" class="nav-link"><span
                                        data-translate="pe-tree-map">Tree Map</span></a></li>
                            <li><a href="ui-advanced-highlight.html" class="nav-link"><span
                                        data-translate="pe-highlight-code">Highlight Code</span></a></li>
                            <li><a href="ui-advanced-mask.html" class="nav-link"><span
                                        data-translate="pe-mask-input">Mask Input</span></a></li>
                            <li><a href="ui-advanced-vis-timeline.html" class="nav-link"><span
                                        data-translate="pe-vis-timeline">Vis Timeline</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseIcons" aria-expanded="false">
                        <span class="icons"><i class="las la-pencil-ruler"></i></span>
                        <span class="content" data-translate="pe-icons">Icons</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseIcons">
                        <ul class="nav-menu-sub">
                            <li><a href="icons-lucide.html" class="nav-link"><span
                                        data-translate="pe-lucide">Lucide</span></a></li>
                            <li><a href="icons-remix.html" class="nav-link"><span
                                        data-translate="pe-remix-icons">Remix Icons</span></a></li>
                            <li><a href="icons-bootstrap.html" class="nav-link"><span
                                        data-translate="pe-bootstrap">Bootstrap</span></a></li>
                            <li><a href="icons-boxicon.html" class="nav-link"><span
                                        data-translate="pe-boxicon">Boxicon</span></a></li>
                            <li><a href="icons-line-awesome.html" class="nav-link"><span
                                        data-translate="pe-line-awesome">Line Awesome</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-menu-title" data-translate="pe-forms-and-tables">Forms &amp; Tables</li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseForms" aria-expanded="false">
                        <span class="icons"><i class="las la-book-open"></i></span>
                        <span class="content" data-translate="pe-forms">Forms</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseForms">
                        <ul class="nav-menu-sub">
                            <li><a href="form-basic-input.html" class="nav-link"><span
                                        data-translate="pe-basic-input">Basic Input</span></a></li>
                            <li><a href="form-input-group.html" class="nav-link"><span
                                        data-translate="pe-input-group">Input Group</span></a></li>
                            <li><a href="form-file-input.html" class="nav-link"><span
                                        data-translate="pe-file-upload">File Upload</span></a></li>
                            <li><a href="form-select.html" class="nav-link"><span
                                        data-translate="pe-select">Select</span></a></li>
                            <li><a href="form-pickers.html" class="nav-link"><span
                                        data-translate="pe-pickers">Pickers</span></a></li>
                            <li><a href="form-range.html" class="nav-link"><span
                                        data-translate="pe-sliders">Sliders</span></a></li>
                            <li><a href="form-switches.html" class="nav-link"><span
                                        data-translate="pe-switches">Switches</span></a></li>
                            <li><a href="form-checkbox-radio.html" class="nav-link"><span
                                        data-translate="pe-checkbox-radio">Checkbox &amp; Radio</span></a></li>
                            <li><a href="form-input-spin.html" class="nav-link"><span
                                        data-translate="pe-input-spin">Input Spin</span></a></li>
                            <li><a href="form-recaptcha.html" class="nav-link"><span
                                        data-translate="pe-recaptcha">reCAPTCHA</span></a></li>
                            <li><a href="form-autosize.html" class="nav-link"><span
                                        data-translate="pe-autosize">Autosize</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="form-editors.html">
                        <span class="icons"><i class="las la-pen-nib"></i></span>
                        <span class="content" data-translate="pe-editors">Editors</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="form-clipboard.html">
                        <span class="icons"><i class="las la-clipboard"></i></span>
                        <span class="content" data-translate="pe-clipboard">Clipboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="form-wizard-basic.html">
                        <span class="icons"><i class="las la-quote-right"></i></span>
                        <span class="content" data-translate="pe-form-wizard">Form Wizard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseTables" aria-expanded="false">
                        <span class="icons"><i class="las la-table"></i></span>
                        <span class="content" data-translate="pe-tables">Tables</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseTables">
                        <ul class="nav-menu-sub">
                            <li><a href="table-base.html" class="nav-link"><span
                                        data-translate="pe-base">Base</span></a></li>
                            <li><a href="table-grid.html" class="nav-link"><span
                                        data-translate="pe-grid-js">Grid.js</span></a></li>
                            <li><a href="table-tabulator.html" class="nav-link"><span
                                        data-translate="pe-tabulator">Tabulator</span></a></li>
                            <li>
                                <a class="nav-link" data-position="right-top" data-bs-toggle="collapse"
                                    href="#collapseDataTables" aria-expanded="false">
                                    <span data-translate="pe-data-tables">Data Tables</span>
                                    <span class="ms-auto"><i data-lucide="chevron-down"
                                            class="size-4 menu-arrow"></i></span>
                                </a>
                                <div class="collapse" id="collapseDataTables">
                                    <ul class="nav-menu-sub">
                                        <li><a href="table-datatables-basic.html" class="nav-link"><span
                                                    data-translate="pe-basic">Basic</span></a></li>
                                        <li><a href="table-datatables-bordered.html" class="nav-link"><span
                                                    data-translate="pe-bordered">Bordered</span></a></li>
                                        <li><a href="table-datatables-stripe.html" class="nav-link"><span
                                                    data-translate="pe-stripe">Stripe</span></a></li>
                                        <li><a href="table-datatables-hover.html" class="nav-link"><span
                                                    data-translate="pe-hover-effect">Hover Effect</span></a></li>
                                        <li><a href="table-datatables-row-grouping.html" class="nav-link"><span
                                                    data-translate="pe-row-grouping">Row Grouping</span></a></li>
                                        <li><a href="table-datatables-enable-disable.html" class="nav-link"><span
                                                    data-translate="pe-feature-enable-disable">Feature enable /
                                                    disable</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-menu-title" data-translate="pe-charts-maps">Charts &amp; Maps</li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseApexcharts" aria-expanded="false">
                        <span class="icons"><i class="las la-chart-bar"></i></span>
                        <span class="content" data-translate="pe-apexcharts">Apexcharts</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseApexcharts">
                        <ul class="nav-menu-sub">
                            <li><a href="apexchart-area.html" class="nav-link"><span
                                        data-translate="pe-area">Area</span></a></li>
                            <li><a href="apexchart-bar.html" class="nav-link"><span
                                        data-translate="pe-bar">Bar</span></a></li>
                            <li><a href="apexchart-box-whisker.html" class="nav-link"><span
                                        data-translate="pe-box-whisher">Box Whisher</span></a></li>
                            <li><a href="apexchart-bubble.html" class="nav-link"><span
                                        data-translate="pe-bubble">Bubble</span></a></li>
                            <li><a href="apexchart-candlestick.html" class="nav-link"><span
                                        data-translate="pe-candlestick">Candlestick</span></a></li>
                            <li><a href="apexchart-column.html" class="nav-link"><span
                                        data-translate="pe-column">Column</span></a></li>
                            <li><a href="apexchart-funnel.html" class="nav-link"><span
                                        data-translate="pe-funnel">Funnel</span></a></li>
                            <li><a href="apexchart-heatmap.html" class="nav-link"><span
                                        data-translate="pe-heatmap">Heatmap</span></a></li>
                            <li><a href="apexchart-line.html" class="nav-link"><span
                                        data-translate="pe-line">Line</span></a></li>
                            <li><a href="apexchart-mixed.html" class="nav-link"><span
                                        data-translate="pe-mixed">Mixed</span></a></li>
                            <li><a href="apexchart-pie.html" class="nav-link"><span
                                        data-translate="pe-pie">Pie</span></a></li>
                            <li><a href="apexchart-polar-area.html" class="nav-link"><span
                                        data-translate="pe-polar-area">Polar Area</span></a></li>
                            <li><a href="apexchart-radar.html" class="nav-link"><span
                                        data-translate="pe-radar">Radar</span></a></li>
                            <li><a href="apexchart-radialbar.html" class="nav-link"><span
                                        data-translate="pe-radialbar">Radialbar</span></a></li>
                            <li><a href="apexchart-range-area.html" class="nav-link"><span
                                        data-translate="pe-range-area">Range Area</span></a></li>
                            <li><a href="apexchart-scatter.html" class="nav-link"><span
                                        data-translate="pe-scatter">Scatter</span></a></li>
                            <li><a href="apexchart-slope.html" class="nav-link"><span
                                        data-translate="pe-slope">Slope</span></a></li>
                            <li><a href="apexchart-timeline.html" class="nav-link"><span
                                        data-translate="pe-timeline">Timeline</span></a></li>
                            <li><a href="apexchart-treemap.html" class="nav-link"><span
                                        data-translate="pe-treemap">Treemap</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="charts-apexsankey.html">
                        <span class="icons"><i class="las la-dna"></i></span>
                        <span class="content" data-translate="pe-apexsankey">ApexSankey</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseEcharts" aria-expanded="false">
                        <span class="icons"><i class="las la-chart-area"></i></span>
                        <span class="content" data-translate="pe-echarts">Echarts</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseEcharts">
                        <ul class="nav-menu-sub">
                            <li><a href="echart-bar.html" class="nav-link"><span
                                        data-translate="pe-bar">Bar</span></a></li>
                            <li><a href="echart-line.html" class="nav-link"><span
                                        data-translate="pe-line">Line</span></a></li>
                            <li><a href="echart-pie.html" class="nav-link"><span
                                        data-translate="pe-pie">Pie</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-position="right-top" data-bs-toggle="collapse"
                        href="#collapseMaps" aria-expanded="false">
                        <span class="icons"><i class="las la-map-marked-alt"></i></span>
                        <span class="content" data-translate="pe-maps">Maps</span>
                        <span class="ms-auto menu-arrow"><i class="las la-angle-down"></i></span>
                    </a>
                    <div class="collapse" id="collapseMaps">
                        <ul class="nav-menu-sub">
                            <li><a href="maps-google.html" class="nav-link"><span
                                        data-translate="pe-google-maps">Google Maps</span></a></li>
                            <li><a href="maps-vector.html" class="nav-link"><span
                                        data-translate="pe-vector">Vector</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-menu-title" data-translate="pe-docs-changelog">Docs &amp; ChangeLog</li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank" href="#!">
                        <span class="icons"><i class="las la-life-ring"></i></span>
                        <span class="content" data-translate="pe-support">Support</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank"
                        href="https://srbthemes.kcubeinfotech.com/evohus/docs/html/index.html">
                        <span class="icons"><i class="las la-file-alt"></i></span>
                        <span class="content" data-translate="pe-documentation">Documentation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" target="_blank"
                        href="https://srbthemes.kcubeinfotech.com/evohus/docs/html/changelog.html">
                        <span class="icons"><i class="las la-feather-alt"></i></span>
                        <span class="content" data-translate="pe-changelog">ChangeLog</span>
                    </a>
                </li> -->
            </ul>
        </div>
    </div>
</div>
<div id="sidebar-backdrop" class="sidebar-backdrop"></div>