@php
$lands = collect(App\Models\Land::latest()->take(5)->get()
->map(fn($l) => [
'type' => 'land',
'label' => 'Land',
'title' => $l->title,
'image' => $l->image ?? null,
'created_at' => $l->created_at,
'icon' => 'map',
]));

$houses = collect(App\Models\House::latest()->take(5)->get()
->map(fn($h) => [
'type' => 'house',
'label' => 'House',
'title' => $h->title,
'image' => $h->image ?? null,
'created_at' => $h->created_at,
'icon' => 'home',
]));

$designs = collect(App\Models\ArchitecturalDesign::latest()->take(5)->get()
->map(fn($d) => [
'type' => 'design',
'label' => 'Design',
'title' => $d->title,
'image' => $d->image ?? null,
'created_at' => $d->created_at,
'icon' => 'drafting-compass',
]));

$agents = collect(App\Models\Agent::latest()->take(5)->get()
->map(fn($a) => [
'type' => 'agent',
'label' => 'Agent',
'title' => $a->name,
'image' => $a->profile_image ?? null,
'created_at' => $a->created_at,
'icon' => 'user-check',
]));

$consultants = collect(App\Models\Consultant::latest()->take(5)->get()
->map(fn($c) => [
'type' => 'consultant',
'label' => 'Consultant',
'title' => $c->name,
'image' => $c->profile_image ?? null,
'created_at' => $c->created_at,
'icon' => 'briefcase',
]));

$notifications = $lands
->merge($houses)
->merge($designs)
->merge($agents)
->merge($consultants)
->sortByDesc('created_at')
->take(10);

$notifCount = $notifications->count();
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:wght@300;400;500&display=swap');

    .t-topbar {
        position: fixed;
        top: 0;
        left: 260px;
        right: 0;
        height: 60px;
        background: #fff;
        border-bottom: 1px solid rgba(25, 38, 93, 0.08);
        display: flex;
        align-items: center;
        padding: 0 24px;
        gap: 12px;
        z-index: 900;
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Mobile toggle ── */
    .t-topbar-toggle {
        display: none;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: transparent;
        border: none;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        color: #19265d;
        transition: background 0.15s;
        flex-shrink: 0;
    }

    .t-topbar-toggle:hover {
        background: rgba(25, 38, 93, 0.06);
    }

    @media (max-width: 991px) {
        .t-topbar {
            left: 0;
        }

        .t-topbar-toggle {
            display: flex;
        }
    }

    /* ── Search ── */
    .t-search-wrap {
        position: relative;
        flex: 1;
        max-width: 340px;
    }

    .t-search-wrap svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 15px;
        height: 15px;
        color: rgba(25, 38, 93, 0.35);
        pointer-events: none;
    }

    .t-search-input {
        width: 100%;
        height: 36px;
        background: rgba(25, 38, 93, 0.04);
        border: 1px solid rgba(25, 38, 93, 0.08);
        border-radius: 8px;
        padding: 0 14px 0 36px;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        color: #19265d;
        outline: none;
        transition: border-color 0.15s, background 0.15s;
    }

    .t-search-input::placeholder {
        color: rgba(25, 38, 93, 0.35);
    }

    .t-search-input:focus {
        background: #fff;
        border-color: rgba(208, 82, 8, 0.35);
    }

    /* ── Actions area ── */
    .t-topbar-actions {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-left: auto;
    }

    /* ── Icon buttons ── */
    .t-icon-btn {
        position: relative;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: transparent;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(25, 38, 93, 0.55);
        transition: background 0.15s, color 0.15s;
        flex-shrink: 0;
    }

    .t-icon-btn:hover {
        background: rgba(25, 38, 93, 0.06);
        color: #19265d;
    }

    .t-icon-btn svg {
        width: 17px;
        height: 17px;
    }

    /* ── Badge dot ── */
    .t-badge-dot {
        position: absolute;
        top: 7px;
        right: 7px;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        border: 1.5px solid #fff;
    }

    .t-badge-dot.gold {
        background: #D05208;
    }

    .t-badge-dot.red {
        background: #d94f4f;
    }

    /* ── Dropdown panel shared ── */
    .t-dropdown {
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        width: 340px;
        background: #fff;
        border: 1px solid rgba(25, 38, 93, 0.08);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(25, 38, 93, 0.1);
        display: none;
        z-index: 1000;
        overflow: hidden;
    }

    .t-dropdown.show {
        display: block;
    }

    .t-dropdown-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 18px 12px;
        border-bottom: 1px solid rgba(25, 38, 93, 0.06);
    }

    .t-dropdown-title {
        font-size: 13px;
        font-weight: 500;
        color: #19265d;
        font-family: 'Cormorant Garamond', serif;
        font-size: 15px;
        letter-spacing: 0.01em;
    }

    .t-dropdown-link {
        font-size: 11.5px;
        color: #D05208;
        text-decoration: none;
        font-weight: 500;
    }

    .t-dropdown-link:hover {
        text-decoration: underline;
    }

    .t-dropdown-body {
        max-height: 340px;
        overflow-y: auto;
        scrollbar-width: none;
        padding: 8px 0;
    }

    .t-dropdown-body::-webkit-scrollbar {
        display: none;
    }

    /* ── Notification items ── */
    .t-notif-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 18px;
        text-decoration: none;
        transition: background 0.12s;
        cursor: pointer;
    }

    .t-notif-item:hover {
        background: rgba(25, 38, 93, 0.03);
    }

    .t-notif-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .t-notif-icon.land {
        background: rgba(208, 82, 8, 0.1);
        color: #D05208;
    }

    .t-notif-icon.house {
        background: rgba(25, 38, 93, 0.08);
        color: #19265d;
    }

    .t-notif-icon.design {
        background: rgba(42, 157, 92, 0.1);
        color: #2a9d5c;
    }

    .t-notif-icon.agent {
        background: rgba(208, 82, 8, 0.08);
        color: #c06020;
    }

    .t-notif-icon.consultant {
        background: rgba(25, 38, 93, 0.06);
        color: #445580;
    }

    .t-notif-icon svg {
        width: 15px;
        height: 15px;
    }

    .t-notif-title {
        font-size: 13px;
        font-weight: 500;
        color: #19265d;
        line-height: 1.3;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 220px;
    }

    .t-notif-meta {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .t-notif-type {
        font-size: 10.5px;
        font-weight: 500;
        padding: 2px 7px;
        border-radius: 20px;
        letter-spacing: 0.03em;
    }

    .t-notif-type.land {
        background: rgba(208, 82, 8, 0.08);
        color: #D05208;
    }

    .t-notif-type.house {
        background: rgba(25, 38, 93, 0.07);
        color: #19265d;
    }

    .t-notif-type.design {
        background: rgba(42, 157, 92, 0.08);
        color: #2a9d5c;
    }

    .t-notif-type.agent {
        background: rgba(208, 82, 8, 0.07);
        color: #c06020;
    }

    .t-notif-type.consultant {
        background: rgba(25, 38, 93, 0.05);
        color: #445580;
    }

    .t-notif-time {
        font-size: 11px;
        color: rgba(25, 38, 93, 0.35);
    }

    /* ── Dark mode toggle ── */
    .t-theme-btn .sun-icon {
        display: none;
    }

    [data-bs-theme="dark"] .t-theme-btn .sun-icon {
        display: block;
    }

    [data-bs-theme="dark"] .t-theme-btn .moon-icon {
        display: none;
    }

    /* ── Divider ── */
    .t-topbar-divider {
        width: 1px;
        height: 20px;
        background: rgba(25, 38, 93, 0.1);
        margin: 0 4px;
        flex-shrink: 0;
    }

    /* ── Profile button ── */
    .t-profile-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 10px 5px 5px;
        border-radius: 10px;
        border: none;
        background: transparent;
        cursor: pointer;
        transition: background 0.15s;
    }

    .t-profile-btn:hover {
        background: rgba(25, 38, 93, 0.05);
    }

    .t-profile-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #19265d, #2e3f8a);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 500;
        color: #fff;
        flex-shrink: 0;
        letter-spacing: 0.04em;
    }

    .t-profile-info {
        text-align: left;
    }

    .t-profile-name {
        font-size: 13px;
        font-weight: 500;
        color: #19265d;
        line-height: 1.2;
    }

    .t-profile-role {
        font-size: 11px;
        color: rgba(25, 38, 93, 0.45);
    }

    /* ── Profile dropdown ── */
    .t-profile-menu {
        width: 220px;
    }

    .t-profile-menu .t-dropdown-head {
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
        padding: 16px 18px;
    }

    .t-profile-menu-name {
        font-size: 14px;
        font-weight: 500;
        color: #19265d;
    }

    .t-profile-menu-email {
        font-size: 11.5px;
        color: rgba(25, 38, 93, 0.45);
    }

    .t-profile-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 18px;
        font-size: 13px;
        color: rgba(25, 38, 93, 0.65);
        text-decoration: none;
        transition: background 0.12s, color 0.12s;
        cursor: pointer;
        border: none;
        background: transparent;
        width: 100%;
    }

    .t-profile-link:hover {
        background: rgba(25, 38, 93, 0.04);
        color: #19265d;
    }

    .t-profile-link svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    .t-profile-link.danger {
        color: rgba(217, 79, 79, 0.75);
    }

    .t-profile-link.danger:hover {
        background: rgba(217, 79, 79, 0.06);
        color: #d94f4f;
    }

    .t-profile-menu-divider {
        height: 1px;
        background: rgba(25, 38, 93, 0.06);
        margin: 4px 0;
    }

    /* ── Dropdown wrapper (for positioning) ── */
    .t-dd-wrap {
        position: relative;
    }

    /* ── Responsive hide ── */
    /* Fix dropdown overflow on mobile — pin to viewport edges */
    @media (max-width: 767px) {
        .t-search-wrap {
            display: none;
        }

        .t-topbar-hide-sm {
            display: none !important;
        }

        /* Full-width dropdowns on small screens */
        .t-dropdown {
            width: calc(100vw - 20px);
            right: 0;
            left: auto;
        }

        /* Keep notification dropdown from clipping left edge */
        #notifDropdown {
            right: -40px;
            /* offset to stay on screen when bell is near right */
        }

        .t-topbar {
            left: 0;
            /* already in your code */
            padding: 0 12px;
        }
    }

    /* Add a tap-to-open search button for mobile */
    @media (max-width: 767px) {
        .t-search-mobile-btn {
            display: flex;
        }
    }

    .t-search-mobile-btn {
        display: none;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: transparent;
        align-items: center;
        justify-content: center;
        color: rgba(25, 38, 93, 0.55);
        cursor: pointer;
    }

    /* ── Page content offset ── */
    .page-wrapper {
        padding-top: 60px;
    }
</style>

<header class="t-topbar" id="main-topbar">

    {{-- Sidebar toggle (mobile) --}}
    <button class="t-topbar-toggle" id="toggleSidebar" aria-label="Toggle sidebar">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="18" rx="1" />
            <path d="M14 7h7M14 12h7M14 17h7" />
        </svg>
    </button>

    {{-- Mobile search trigger --}}
    <button class="t-search-mobile-btn t-icon-btn" id="mobileSearchBtn" aria-label="Search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
        </svg>
    </button>

    {{-- Full-screen search overlay (mobile only) --}}
    <div id="mobileSearchOverlay" style="display:none; position:fixed; inset:0; z-index:1100; background:#fff; padding:14px; flex-direction:column; gap:12px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="position:relative; flex:1;">
                <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:rgba(25,38,93,0.35);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="search" id="mobileSearchInput" placeholder="Search Terra…"
                    style="width:100%;height:40px;background:rgba(25,38,93,0.04);border:1px solid rgba(25,38,93,0.12);border-radius:9px;padding:0 14px 0 36px;font-size:14px;outline:none;">
            </div>
            <button id="mobileSearchClose" style="font-size:13px;color:#D05208;border:none;background:none;cursor:pointer;white-space:nowrap;padding:4px;">Cancel</button>
        </div>
    </div>

    {{-- Search --}}
    <div class="t-search-wrap">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
        </svg>
        <input type="search" class="t-search-input" placeholder="Search Terra…">
    </div>

    {{-- Actions --}}
    <div class="t-topbar-actions">

        {{-- Notifications --}}
        <div class="t-dd-wrap">
            <button class="t-icon-btn" id="notifToggle" aria-label="Notifications">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                    <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                </svg>
                @if($notifCount > 0)
                <span class="t-badge-dot gold"></span>
                @endif
            </button>

            <div class="t-dropdown" id="notifDropdown">
                <div class="t-dropdown-head">
                    <span class="t-dropdown-title">Notifications</span>
                    <a href="#!" class="t-dropdown-link">Mark all read</a>
                </div>
                <div class="t-dropdown-body">
                    @forelse($notifications as $notif)
                    <div class="t-notif-item">
                        <div class="t-notif-icon {{ $notif['type'] }}">
                            @if($notif['type'] === 'land')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 17l4-8 4 5 3-3 4 6H3z" />
                            </svg>
                            @elseif($notif['type'] === 'house')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                            @elseif($notif['type'] === 'design')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                            @elseif($notif['type'] === 'agent')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            @else
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                            @endif
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div class="t-notif-title">{{ $notif['title'] }}</div>
                            <div class="t-notif-meta">
                                <span class="t-notif-type {{ $notif['type'] }}">{{ $notif['label'] }}</span>
                                <span class="t-notif-time">{{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="padding: 24px 18px; text-align:center; font-size:13px; color: rgba(25,38,93,0.4);">
                        No new notifications
                    </div>
                    @endforelse
                </div>
                <div style="padding: 10px 18px; border-top: 1px solid rgba(25,38,93,0.06); text-align:center;">
                    <a href="#!" class="t-dropdown-link" style="font-size: 12.5px;">View all notifications</a>
                </div>
            </div>
        </div>

        {{-- Dark mode toggle --}}
        <button class="t-icon-btn t-theme-btn" id="darkModeButton" aria-label="Toggle dark mode">
            <svg class="moon-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
            </svg>
            <svg class="sun-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5" />
                <line x1="12" y1="1" x2="12" y2="3" />
                <line x1="12" y1="21" x2="12" y2="23" />
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                <line x1="1" y1="12" x2="3" y2="12" />
                <line x1="21" y1="12" x2="23" y2="12" />
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
            </svg>
        </button>

        <div class="t-topbar-divider"></div>

        {{-- Profile --}}
        <div class="t-dd-wrap">
            <button class="t-profile-btn" id="profileToggle" aria-label="Profile menu">
                <div class="t-profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
                <div class="t-profile-info t-topbar-hide-sm">
                    <div class="t-profile-name">{{ Str::limit(Auth::user()->name ?? 'Admin', 16) }}</div>
                    <div class="t-profile-role">{{ Auth::user()->role ?? 'Administrator' }}</div>
                </div>
                <svg class="t-topbar-hide-sm" style="width:12px;height:12px;color:rgba(25,38,93,0.35);margin-left:2px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9" />
                </svg>
            </button>

            <div class="t-dropdown t-profile-menu" id="profileDropdown">
                <div class="t-dropdown-head">
                    <div class="t-profile-menu-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="t-profile-menu-email">{{ Auth::user()->email ?? '' }}</div>
                </div>
                <div style="padding: 6px 0;">
                    <a href="{{ route('profile.show') }}" class="t-profile-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        My Profile
                    </a>
                    <a href="{{ route('admin.tasks.index') }}" class="t-profile-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4" />
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                        </svg>
                        Tasks
                    </a>
                    <a href="{{ route('admin.activity-logs.index') }}" class="t-profile-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                        </svg>
                        Activity Logs
                    </a>
                    <div class="t-profile-menu-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" id="topbar-logout-form">
                        @csrf
                        <button type="submit" class="t-profile-link danger">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>

<script>
    (function() {
        // Generic dropdown toggler
        function initDropdown(btnId, dropId) {
            const btn = document.getElementById(btnId);
            const drop = document.getElementById(dropId);
            if (!btn || !drop) return;

            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                // Close all other dropdowns first
                document.querySelectorAll('.t-dropdown.show').forEach(function(d) {
                    if (d !== drop) d.classList.remove('show');
                });
                drop.classList.toggle('show');
            });
        }

        initDropdown('notifToggle', 'notifDropdown');
        initDropdown('profileToggle', 'profileDropdown');

        // Close on outside click
        document.addEventListener('click', function() {
            document.querySelectorAll('.t-dropdown.show').forEach(function(d) {
                d.classList.remove('show');
            });
        });

        // Sidebar toggle
        var sidebarToggle = document.getElementById('toggleSidebar');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation(); // ← ADD THIS — prevents the document click handler from immediately closing it
                var sidebar = document.getElementById('new-sidebar');
                var backdrop = document.getElementById('sidebar-backdrop');
                if (sidebar) sidebar.classList.toggle('open');
                if (backdrop) backdrop.classList.toggle('show');
            });
        }

        // Backdrop click closes sidebar
        var backdrop = document.getElementById('sidebar-backdrop');
        if (backdrop) {
            backdrop.addEventListener('click', function() {
                var sidebar = document.getElementById('new-sidebar');
                if (sidebar) sidebar.classList.remove('open');
                backdrop.classList.remove('show');
            });
        }


        // Dark mode toggle
        var darkBtn = document.getElementById('darkModeButton');
        if (darkBtn) {
            darkBtn.addEventListener('click', function() {
                var html = document.documentElement;
                var theme = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-bs-theme', theme);
                localStorage.setItem('terra-theme', theme);
            });

            // Restore on load
            var saved = localStorage.getItem('terra-theme');
            if (saved) document.documentElement.setAttribute('data-bs-theme', saved);
        }

        // Mobile search overlay
        var mobileSearchBtn = document.getElementById('mobileSearchBtn');
        var mobileSearchOverlay = document.getElementById('mobileSearchOverlay');
        var mobileSearchClose = document.getElementById('mobileSearchClose');
        var mobileSearchInput = document.getElementById('mobileSearchInput');

        if (mobileSearchBtn) {
            mobileSearchBtn.addEventListener('click', function() {
                mobileSearchOverlay.style.display = 'flex';
                setTimeout(function() {
                    mobileSearchInput && mobileSearchInput.focus();
                }, 50);
            });
        }
        if (mobileSearchClose) {
            mobileSearchClose.addEventListener('click', function() {
                mobileSearchOverlay.style.display = 'none';
            });
        }
    })();
</script>