<header class="main-topbar gap-md-2" id="main-topbar">
    <div class="navbar-brand">
        <div class="logos">
            <a href="#!" aria-label="Topbar Logo">
                {{ config('app.name') }}
                <!-- <img src="{{ asset('dashboard/assets/images/main-logo.png') }}" loading="lazy" height="18" alt="" class="logo-dark">
                <img src="{{ asset('dashboard/assets/images/logo-white.png') }}" loading="lazy" height="18" alt="" class="logo-light"> -->
            </a>
        </div>
        <button type="button" id="toggleSidebar" class="sidebar-toggle btn p-0" aria-label="sidebar-toggle"><i
                data-lucide="panel-right-open" class="size-4"></i></button>
    </div>
    <div class="align-items-center d-none d-lg-flex">
        <div class="position-relative navbar-search">
            <i data-lucide="search" class="size-4 icon"></i>
            <input type="search" class="form-control border-0 shadow-none" placeholder="Search for Evohus">
        </div>
    </div>
    <div class="d-flex align-items-center gap-2 gap-md-3 ms-auto">
        <div class="dropdown">
            <button class="btn topbar-link" type="button" aria-label="Notification-button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span class="position-relative">
                    <i class="ri-notification-4-line fs-lg"></i>
                    <span class="notification-animate bg-info rounded-circle"></span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0">
                <div class="d-flex align-items-center gap-2 p-5 pb-0">
                    <h6 class="flex-grow-1 mb-0">Notification (4)</h6>
                    <a href="#!" class="link link-custom-primary"><i data-lucide="settings" class="size-4"></i></a>
                </div>
                <div class="py-5">
                    <div class="topbar-notification px-5" style="height: 360px;" data-simplebar>
                        <div class="vstack gap-3">
                            <a href="#!"
                                class="notification-item position-relative d-flex gap-3 p-3 rounded unread">
                                <div class="position-relative">
                                    <img src="assets/images/user-2.png" loading="lazy"
                                        alt="Profile picture of Donna Berlin"
                                        class="rounded-circle size-9 flex-shrink-0">
                                    <span class="bg-primary badge rounded-circle notification top-end"><i
                                            class="ri-chat-3-line"></i></span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fs-14 text-muted"><span class="text-body fw-medium">Donna
                                            Berlin</span> wants to edit <span class="text-body fw-medium">Evohus
                                            Admin &amp; Dashboard</span></p>
                                    <p class="fs-12 text-muted">5 min ago</p>
                                </div>
                            </a>
                            <a href="#!" class="notification-item position-relative d-flex gap-3 p-3 rounded">
                                <div class="position-relative">
                                    <img src="assets/images/user-3.png" loading="lazy"
                                        alt="Profile picture of Michael Adams"
                                        class="rounded-circle size-9 flex-shrink-0">
                                    <span class="bg-success badge rounded-circle notification top-end"><i
                                            class="ri-check-line"></i></span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fs-14 text-muted"><span class="text-body fw-medium">Michael
                                            Adams</span> completed task <span class="text-body fw-medium">Create
                                            Analytics Report</span></p>
                                    <p class="fs-12 text-muted">12 min ago</p>
                                </div>
                            </a>
                            <a href="#!" class="notification-item position-relative d-flex gap-3 p-3 rounded">
                                <div
                                    class="avatar text-danger fs-xl rounded-2 bg-danger-subtle size-9 rounded-circle flex-shrink-0">
                                    <i class="ri-spam-line"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fs-14 text-muted"><span class="text-body fw-medium">System
                                            Alert:</span> High CPU usage detected on <span
                                            class="text-body fw-medium">Server #3</span></p>
                                    <p class="fs-12 text-muted">30 min ago</p>
                                </div>
                            </a>
                            <a href="#!" class="notification-item position-relative d-flex gap-3 p-3 rounded">
                                <div class="position-relative">
                                    <img src="assets/images/user-5.png" loading="lazy"
                                        alt="Profile picture of Sarah Miller"
                                        class="rounded-circle size-9 flex-shrink-0">
                                    <span class="bg-info badge rounded-circle notification top-end"><i
                                            class="ri-message-3-line"></i></span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fs-14 text-muted"><span class="text-body fw-medium">Sarah
                                            Miller</span> sent you a new message</p>
                                    <p class="fs-12 text-muted">1 hr ago</p>
                                </div>
                            </a>
                            <a href="#!" class="notification-item position-relative d-flex gap-3 p-3 rounded">
                                <div
                                    class="avatar text-warning fs-xl rounded-2 bg-warning-subtle size-9 rounded-circle flex-shrink-0">
                                    <i class="ri-hourglass-line"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fs-14 text-muted"><span class="text-body fw-medium">Meeting
                                            Reminder:</span> Product Strategy Call at <span
                                            class="text-body fw-medium">3:00 PM</span></p>
                                    <p class="fs-12 text-muted">Today</p>
                                </div>
                            </a>
                            <a href="#!" class="notification-item position-relative d-flex gap-3 p-3 rounded">
                                <div class="position-relative">
                                    <img src="assets/images/user-7.png" loading="lazy"
                                        alt="Profile picture of Alex Johnson"
                                        class="rounded-circle size-9 flex-shrink-0">
                                    <span class="bg-info badge rounded-circle notification top-end"><i
                                            class="ri-add-line"></i></span>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fs-14 text-muted"><span class="text-body fw-medium">Alex
                                            Johnson</span> joined your project <span class="text-body fw-medium">UI
                                            Redesign</span></p>
                                    <p class="fs-12 text-muted">Yesterday</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dropdown d-none d-md-block">
            <button class="btn topbar-link" type="button" aria-label="Message-button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span class="position-relative">
                    <i class="ri-message-3-line fs-lg"></i>
                    <span class="notification-animate bg-danger rounded-circle"></span>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0">
                <div class="d-flex align-items-center gap-2 p-5 pb-0">
                    <h6 class="flex-grow-1 mb-0">Messages</h6>
                    <a href="#!" class="link link-custom-primary small">View All <i
                            class="ri-arrow-right-s-line"></i></a>
                </div>
                <div class="topbar-messages p-5">
                    <div class="vstack gap-5">
                        <a href="#!" class="d-flex gap-3 py-1 rounded position-relative">
                            <img src="assets/images/user-2.png" alt="Emma Brown"
                                class="rounded-circle size-9 flex-shrink-0">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1 fw-medium text-body">Emma Brown</h6>
                                    <span class="fs-12 text-muted">2 min ago</span>
                                </div>
                                <p class="mb-1 fs-14 text-muted">Hi, could you please share details for the 3BHK
                                    apartment at Park Avenue?</p>
                                <span class="badge bg-success-subtle text-success fs-11">New Inquiry</span>
                            </div>
                        </a>
                        <a href="#!" class="d-flex gap-3 py-1 rounded position-relative">
                            <img src="assets/images/user-3.png" alt="David Miller"
                                class="rounded-circle size-9 flex-shrink-0">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1 fw-medium text-body">David Miller</h6>
                                    <span class="fs-12 text-muted">10 min ago</span>
                                </div>
                                <p class="mb-1 fs-14 text-muted">I’m interested in the villa you listed last week.
                                    Is it still available?</p>
                                <span class="badge bg-info-subtle text-info fs-11">Follow Up</span>
                            </div>
                        </a>
                        <a href="#!" class="d-flex gap-3 py-1 rounded position-relative">
                            <img src="assets/images/user-5.png" alt="Sophia Turner"
                                class="rounded-circle size-9 flex-shrink-0">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-1 fw-medium text-body">Sophia Turner</h6>
                                    <span class="fs-12 text-muted">45 min ago</span>
                                </div>
                                <p class="mb-1 fs-14 text-muted">Can we schedule a visit for the Greenview project
                                    tomorrow morning?</p>
                                <span class="badge bg-warning-subtle text-warning fs-11">Appointment</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dropdown profile-dropdown">
            <button class="btn px-0 d-flex align-items-center text-body dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('dashboard/assets/images/user.jfif') }}" loading="lazy" alt="en"
                    class="object-fit-cover rounded-3 size-9">
                <span class="text-start ms-3 d-none d-xl-block">
                    <span class="d-block fw-medium pr-name fs-sm">{{ Auth::user()->name }}</span>
                    <small class="text-muted pr-desc">{{ Auth::user()->role }}</small>
                </span>
                <span class="d-none d-xl-inline-flex bg-primary badge badge-square ms-4 rounded-circle">2</span>
            </button>
            <div class="dropdown-menu dropdown-menu-md p-4 profile-dropdown-menu">
                <ul class="list-unstyled mb-0">
                    <li>
                        <a class="profile-link" href="{{ route('agent.profile.view') }}">
                            <i class="ri-user-3-line d-inline-block me-2 fs-17"></i>
                            My Profile
                            <span class="text-primary">@ {{ auth()->user()->name }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="profile-link" href="pages-account-settings.html"><i
                                class="ri-settings-3-line d-inline-block me-2 fs-17"></i> Account Settings</a>
                    </li>
                    <li>
                        <a class="profile-link" href="pages-help-center.html"><i
                                class="ri-customer-service-line d-inline-block me-2 fs-17"></i> Help Center</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a href="#" class="profile-link pb-0"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ri-logout-circle-r-line me-2 fs-17"></i> Log Out
                            </a>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</header>
