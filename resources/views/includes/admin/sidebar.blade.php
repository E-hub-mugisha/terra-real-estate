<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<style>
    .new-sidebar {
        width: 260px;
        min-width: 260px;
        height: 100vh;
        background: #19265d;
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        font-family: 'DM Sans', sans-serif;
        overflow: hidden;
        overflow-y: auto;
        /* allows scroll AND doesn't clip transform */
    }

    .new-sidebar::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 1px;
        height: 100%;
        background: linear-gradient(to bottom, transparent, rgba(208, 82, 8, 0.4) 30%, rgba(208, 82, 8, 0.2) 70%, transparent);
        pointer-events: none;
    }

    /* ── Brand ── */
    .t-brand {
        padding: 26px 24px 22px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        gap: 12px;
        flex-shrink: 0;
    }

    .t-brand-icon {
        width: 38px;
        height: 38px;
        background: #D05208;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .t-brand-icon svg {
        width: 20px;
        height: 20px;
    }

    .t-brand-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.04em;
        line-height: 1;
        text-decoration: none;
    }

    .t-brand-sub {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.35);
        letter-spacing: 0.18em;
        text-transform: uppercase;
        margin-top: 3px;
    }

    /* ── Scrollable nav body ── */
    .t-nav-body {
        flex: 1;
        overflow-y: auto;
        padding: 10px 0 24px;
        scrollbar-width: none;
    }

    .t-nav-body::-webkit-scrollbar {
        display: none;
    }

    /* ── Section labels ── */
    .t-section-label {
        font-size: 9.5px;
        font-weight: 500;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: rgba(208, 82, 8, 0.7);
        padding: 18px 24px 6px;
        display: block;
    }

    /* ── Nav items ── */
    .t-nav-item {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 9px 18px 9px 24px;
        cursor: pointer;
        position: relative;
        transition: background 0.15s;
        text-decoration: none;
        color: rgba(255, 255, 255, 0.5);
        font-size: 13.5px;
        font-weight: 400;
        user-select: none;
    }

    .t-nav-item:hover {
        background: rgba(255, 255, 255, 0.05);
        color: rgba(255, 255, 255, 0.82);
        text-decoration: none;
    }

    .t-nav-item.active {
        color: #fff;
        background: rgba(208, 82, 8, 0.14);
    }

    .t-nav-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 5px;
        bottom: 5px;
        width: 3px;
        background: #D05208;
        border-radius: 0 2px 2px 0;
    }

    .t-nav-item .t-ico {
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        opacity: 0.75;
    }

    .t-nav-item.active .t-ico,
    .t-nav-item:hover .t-ico {
        opacity: 1;
    }

    .t-nav-item .t-arrow {
        margin-left: auto;
        display: flex;
        align-items: center;
        opacity: 0.35;
        transition: transform 0.22s ease;
    }

    .t-nav-item[aria-expanded="true"] .t-arrow {
        transform: rotate(180deg);
        opacity: 0.65;
    }

    /* ── Sub-menu ── */
    .t-sub-menu {
        background: rgba(0, 0, 0, 0.18);
        border-left: 1px solid rgba(208, 82, 8, 0.22);
        margin: 2px 12px 4px 36px;
        border-radius: 0 0 6px 6px;
        overflow: hidden;
    }

    .t-sub-item {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 7px 14px;
        font-size: 12.5px;
        color: rgba(255, 255, 255, 0.4);
        cursor: pointer;
        transition: color 0.15s;
        text-decoration: none;
    }

    .t-sub-item::before {
        content: '';
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: rgba(208, 82, 8, 0.45);
        flex-shrink: 0;
    }

    .t-sub-item:hover {
        color: rgba(255, 255, 255, 0.72);
        text-decoration: none;
    }

    .t-sub-item.active {
        color: #D05208;
    }

    .t-sub-item.active::before {
        background: #D05208;
    }

    /* ── Footer user block ── */
    .t-sidebar-footer {
        padding: 14px 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .t-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #D05208, #e8722a);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 500;
        color: #fff;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .t-user-info .t-user-name {
        font-size: 12.5px;
        color: rgba(255, 255, 255, 0.72);
        font-weight: 500;
        line-height: 1.2;
    }

    .t-user-info .t-user-role {
        font-size: 10.5px;
        color: rgba(255, 255, 255, 0.3);
    }

    .t-logout-btn {
        margin-left: auto;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.05);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.15s;
        flex-shrink: 0;
    }

    .t-logout-btn:hover {
        background: rgba(208, 82, 8, 0.22);
    }

    /* ── Page content offset ── */
    .page-wrapper {
        margin-left: 260px;
    }

    /* ── Mobile backdrop ── */
    .sidebar-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 998;
    }

    @media (max-width: 991px) {
        .new-sidebar {
            transform: translateX(-100%);
            transition: transform 0.28s ease;
            z-index: 1000;
        }

        .new-sidebar.open {
            transform: translateX(0);
        }

        .sidebar-backdrop.show {
            display: block;
        }

        .page-wrapper {
            margin-left: 0;
        }
    }

    .t-sidebar-close {
        display: none;
        margin-left: auto;
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: rgba(255, 255, 255, 0.06);
        border: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        flex-shrink: 0;
        transition: background 0.15s;
    }

    .t-sidebar-close:hover {
        background: rgba(208, 82, 8, 0.3);
    }

    @media (max-width: 991px) {
        .t-sidebar-close {
            display: flex;
        }
    }
</style>

<div id="new-sidebar" class="new-sidebar">

    {{-- Brand --}}
    <div class="t-brand">
        <div class="t-brand-icon">
            <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2L3 7v11h14V7L10 2z" fill="rgba(255,255,255,0.18)" stroke="#fff" stroke-width="1.3" stroke-linejoin="round" />
                <path d="M7 18v-6h6v6" stroke="#fff" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="t-brand-name">Terra</a>
            <div class="t-brand-sub">Real Estate Platform</div>
        </div>
        <button class="t-sidebar-close" id="sidebarClose" aria-label="Close sidebar">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M3 3l10 10M13 3L3 13" stroke="rgba(255,255,255,0.5)" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    {{-- Scrollable nav --}}
    <div class="t-nav-body">
        <ul class="list-unstyled mb-0">

            {{-- DASHBOARD --}}
            <li><span class="t-section-label">Overview</span></li>

            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="t-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <rect x="1" y="1" width="6" height="6" rx="1.5" fill="currentColor" />
                            <rect x="9" y="1" width="6" height="6" rx="1.5" fill="currentColor" opacity=".5" />
                            <rect x="1" y="9" width="6" height="6" rx="1.5" fill="currentColor" opacity=".5" />
                            <rect x="9" y="9" width="6" height="6" rx="1.5" fill="currentColor" opacity=".5" />
                        </svg>
                    </span>
                    Dashboard
                </a>
            </li>

            {{-- ADMINISTRATION --}}
            <li><span class="t-section-label">Administration</span></li>

            <li>
                <a href="{{ route('staff.departments.index') }}"
                    class="t-nav-item {{ request()->routeIs('staff.departments.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <rect x="1" y="3" width="14" height="10" rx="2" stroke="currentColor" stroke-width="1.3" />
                            <path d="M1 7h14" stroke="currentColor" stroke-width="1.3" />
                            <path d="M5.5 10h2M9 10h1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                        </svg>
                    </span>
                    Departments
                </a>
            </li>

            <li>
                <a href="{{ route('admin.roles.index') }}"
                    class="t-nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <circle cx="8" cy="5.5" r="3" stroke="currentColor" stroke-width="1.3" />
                            <path d="M2 14c0-3.314 2.686-5 6-5s6 1.686 6 5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                            <path d="M11.5 2l1.5 1.5-1.5 1.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Roles
                </a>
            </li>

            <li>
                <a href="{{ route('admin.bookings.index') }}"
                    class="t-nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <rect x="1" y="3" width="14" height="11" rx="2" stroke="currentColor" stroke-width="1.3" />
                            <path d="M5 3V1.5M11 3V1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                            <path d="M1 7h14" stroke="currentColor" stroke-width="1.3" />
                            <path d="M5 10l1.5 1.5L11 9" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Bookings
                </a>
            </li>

            {{-- PROPERTY MANAGEMENT --}}
            <li><span class="t-section-label">Property Management</span></li>

            <li>
                <a class="t-nav-item {{ request()->routeIs('admin.properties.*', 'admin.architectural-designs.*', 'admin.design-categories.*', 'admin.facilities.*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#collapseProperties"
                    aria-expanded="{{ request()->routeIs('admin.properties.*', 'admin.architectural-designs.*', 'admin.design-categories.*', 'admin.facilities.*') ? 'true' : 'false' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 1.5L1.5 6.5V14.5H6V10H10V14.5H14.5V6.5L8 1.5Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Properties
                    <span class="t-arrow">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M3 4.5l3 3 3-3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.properties.*', 'admin.architectural-designs.*', 'admin.design-categories.*', 'admin.facilities.*') ? 'show' : '' }}"
                    id="collapseProperties">
                    <div class="t-sub-menu">
                        <a href="{{ route('admin.properties.lands.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.properties.lands.*') ? 'active' : '' }}">Land</a>
                        <a href="{{ route('admin.properties.houses.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.properties.houses.*') ? 'active' : '' }}">Houses</a>
                        <a href="{{ route('admin.architectural-designs.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.architectural-designs.*') ? 'active' : '' }}">Architectural Designs</a>
                        <a href="{{ route('admin.design-categories.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.design-categories.*') ? 'active' : '' }}">Design Categories</a>
                        <a href="{{ route('admin.facilities.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">Facilities</a>
                    </div>
                </div>
            </li>

            {{-- SERVICES --}}
            <li><span class="t-section-label">Services</span></li>

            <li>
                <a class="t-nav-item {{ request()->routeIs('services.*', 'service-categories.*', 'service-subcategories.*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#collapseServices"
                    aria-expanded="{{ request()->routeIs('services.*', 'service-categories.*', 'service-subcategories.*') ? 'true' : 'false' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 1.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13z" stroke="currentColor" stroke-width="1.3" />
                            <path d="M5.5 8.5l1.5 1.5 3-3.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Service Management
                    <span class="t-arrow">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M3 4.5l3 3 3-3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
                <div class="collapse {{ request()->routeIs('services.*', 'service-categories.*', 'service-subcategories.*') ? 'show' : '' }}"
                    id="collapseServices">
                    <div class="t-sub-menu">
                        <a href="{{ route('services.index') }}"
                            class="t-sub-item {{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a>
                        <a href="{{ route('service-categories.index') }}"
                            class="t-sub-item {{ request()->routeIs('service-categories.*') ? 'active' : '' }}">Categories</a>
                        <a href="{{ route('service-subcategories.index') }}"
                            class="t-sub-item {{ request()->routeIs('service-subcategories.*') ? 'active' : '' }}">Sub-categories</a>
                    </div>
                </div>
            </li>

            {{-- USER MANAGEMENT --}}
            <li><span class="t-section-label">User Management</span></li>

            <li>
                <a class="t-nav-item {{ request()->routeIs('admin.staff.*', 'admin.agents.*', 'admin.professionals.*', 'admin.consultants.*', 'admin.users.*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#collapseUsers"
                    aria-expanded="{{ request()->routeIs('admin.staff.*', 'admin.agents.*', 'admin.professionals.*', 'admin.consultants.*', 'admin.users.*') ? 'true' : 'false' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <circle cx="5.5" cy="5" r="2.5" stroke="currentColor" stroke-width="1.3" />
                            <path d="M1 13c0-2.5 2-4 4.5-4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                            <circle cx="11" cy="6" r="2" stroke="currentColor" stroke-width="1.3" />
                            <path d="M8 13.5c0-2 1.3-3.5 3-3.5s3 1.5 3 3.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                        </svg>
                    </span>
                    Users & Agents
                    <span class="t-arrow">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M3 4.5l3 3 3-3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.staff.*', 'admin.agents.*', 'admin.professionals.*', 'admin.consultants.*', 'admin.users.*') ? 'show' : '' }}"
                    id="collapseUsers">
                    <div class="t-sub-menu">
                        <a href="{{ route('admin.staff.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">Staff</a>
                        <a href="{{ route('admin.agents.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">Agents</a>
                        <a href="{{ route('admin.professionals.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.professionals.*') ? 'active' : '' }}">Professionals</a>
                        <a href="{{ route('admin.consultants.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.consultants.*') ? 'active' : '' }}">Consultants</a>
                        <a href="{{ route('admin.users.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
                    </div>
                </div>
            </li>

            {{-- CONTENT & MEDIA --}}
            <li><span class="t-section-label">Content & Media</span></li>

            <li>
                <a class="t-nav-item {{ request()->routeIs('admin.advertisements.*', 'admin.announcements.*', 'admin.blogs.*', 'admin.blog-categories.*', 'admin.job-listings.*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#collapseContent"
                    aria-expanded="{{ request()->routeIs('admin.advertisements.*', 'admin.announcements.*', 'admin.blogs.*', 'admin.blog-categories.*', 'admin.job-listings.*') ? 'true' : 'false' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M2 4h12M2 8h8M2 12h5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                        </svg>
                    </span>
                    News & Ads
                    <span class="t-arrow">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M3 4.5l3 3 3-3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.advertisements.*', 'admin.announcements.*', 'admin.blogs.*', 'admin.blog-categories.*', 'admin.job-listings.*') ? 'show' : '' }}"
                    id="collapseContent">
                    <div class="t-sub-menu">
                        <a href="{{ route('admin.advertisements.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.advertisements.*') ? 'active' : '' }}">Advertisements</a>
                        <a href="{{ route('admin.announcements.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">Announcements</a>
                        <a href="{{ route('admin.blogs.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">News</a>
                        <a href="{{ route('admin.blog-categories.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">News Categories</a>
                        <a href="{{ route('admin.job-listings.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.job-listings.*') ? 'active' : '' }}">Job Listings</a>
                    </div>
                </div>
            </li>

            {{-- BUSINESS --}}
            <li><span class="t-section-label">Business</span></li>

            <li>
                <a class="t-nav-item {{ request()->routeIs('admin.tenders.*', 'admin.tasks.*') ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#collapseTenders"
                    aria-expanded="{{ request()->routeIs('admin.tenders.*', 'admin.tasks.*') ? 'true' : 'false' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3 5h10M3 8h7M3 11h5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                            <rect x="1" y="2" width="14" height="12" rx="2" stroke="currentColor" stroke-width="1.3" />
                        </svg>
                    </span>
                    Tenders
                    <span class="t-arrow">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M3 4.5l3 3 3-3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.tenders.*', 'admin.tasks.*') ? 'show' : '' }}"
                    id="collapseTenders">
                    <div class="t-sub-menu">
                        <a href="{{ route('admin.tenders.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.tenders.*') ? 'active' : '' }}">Tenders</a>
                        <a href="{{ route('admin.tasks.index') }}"
                            class="t-sub-item {{ request()->routeIs('admin.tasks.*') ? 'active' : '' }}">Tasks</a>
                    </div>
                </div>
            </li>

            <li>
                <a href="{{ route('admin.partners.index') }}"
                    class="t-nav-item {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M2 9.5c0-1 .5-2 1.5-2.5L8 4.5l4.5 2.5c1 .5 1.5 1.5 1.5 2.5v.5a2 2 0 01-2 2H4a2 2 0 01-2-2v-.5z" stroke="currentColor" stroke-width="1.3" />
                            <path d="M5.5 7v5M10.5 7v5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                        </svg>
                    </span>
                    Partners
                </a>
            </li>

            {{-- FINANCE & PLANS --}}
            <li><span class="t-section-label">Finance & Plans</span></li>

            <li>
                <a href="{{ route('admin.commissions.index') }}"
                    class="t-nav-item {{ request()->routeIs('admin.commissions.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.3" />
                            <path d="M8 4.5v1.2M8 10.3v1.2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                            <path d="M6 7c0-.83.9-1.5 2-1.5s2 .67 2 1.5-2 1-2 2 .9 1.5 2 1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                        </svg>
                    </span>
                    Commissions
                </a>
            </li>

            <li>
                <a href="{{ route('admin.listing-packages.index') }}"
                    class="t-nav-item {{ request()->routeIs('admin.listing-packages.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <rect x="1.5" y="3.5" width="13" height="9" rx="1.5" stroke="currentColor" stroke-width="1.3" />
                            <path d="M5 8h6M5 6h3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" />
                        </svg>
                    </span>
                    Listing Packages
                </a>
            </li>

            <li>
                <a href="{{ route('admin.commission-tiers.index') }}"
                    class="t-nav-item {{ request()->routeIs('admin.commission-tiers.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M2 11l3-5 3 3 2-3 4 5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Commission Tiers
                </a>
            </li>

            <li>
                <a href="{{ route('admin.agent-levels.index') }}"
                    class="t-nav-item {{ request()->routeIs('admin.agent-levels.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 1.5l1.8 3.6 4 .58-2.9 2.82.68 3.98L8 10.5l-3.58 1.98.68-3.98L2.2 5.68l4-.58L8 1.5z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Agent Levels
                </a>
            </li>

            <li>
                <a href="{{ route('admin.duration-discounts.index') }}"
                    class="t-nav-item {{ request()->routeIs('admin.duration-discounts.*') ? 'active' : '' }}">
                    <span class="t-ico">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.3" />
                            <path d="M8 4.5V8l2.5 2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    Duration Discounts
                </a>
            </li>

        </ul>
    </div>

    {{-- Footer --}}
    <div class="t-sidebar-footer">
        <div class="t-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}
        </div>
        <div class="t-user-info">
            <div class="t-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
            <div class="t-user-role">{{ auth()->user()->roles->first()->name ?? 'Administrator' }}</div>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <button type="submit" class="t-logout-btn" title="Sign out">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M5 2H2a1 1 0 00-1 1v8a1 1 0 001 1h3" stroke="rgba(255,255,255,0.5)" stroke-width="1.3" stroke-linecap="round" />
                    <path d="M9 10l3-3-3-3M5 7h7" stroke="rgba(255,255,255,0.5)" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </form>
    </div>

</div>

<div id="sidebar-backdrop" class="sidebar-backdrop"></div>

<script>
    (function() {
        var closeBtn = document.getElementById('sidebarClose');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                document.getElementById('new-sidebar').classList.remove('open');
                document.getElementById('sidebar-backdrop').classList.remove('show');
            });
        }
    })();
</script>