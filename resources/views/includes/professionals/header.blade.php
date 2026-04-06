@php
/**
 * Admin Topbar Header
 * Notifications: merges recent Lands, Houses, Designs, Agents, Consultants
 */

$lands = collect(App\Models\Land::latest()->take(4)->get()
    ->map(fn($l) => [
        'type'       => 'land',
        'icon'       => 'las la-map-marked-alt',
        'color'      => 'success',
        'label'      => 'New Land Listed',
        'title'      => $l->title,
        'image'      => $l->image ?? null,
        'route'      => route('admin.properties.lands.show', $l->id),
        'created_at' => $l->created_at,
    ]));

$houses = collect(App\Models\House::latest()->take(4)->get()
    ->map(fn($h) => [
        'type'       => 'house',
        'icon'       => 'las la-home',
        'color'      => 'primary',
        'label'      => 'New House Listed',
        'title'      => $h->title,
        'image'      => $h->image ?? null,
        'route'      => route('admin.properties.houses.show', $h->id),
        'created_at' => $h->created_at,
    ]));

$designs = collect(App\Models\ArchitecturalDesign::latest()->take(3)->get()
    ->map(fn($d) => [
        'type'       => 'design',
        'icon'       => 'las la-drafting-compass',
        'color'      => 'warning',
        'label'      => 'New Design Uploaded',
        'title'      => $d->title,
        'image'      => $d->image ?? null,
        'route'      => route('admin.properties.architectural-designs.show', $d->id),
        'created_at' => $d->created_at,
    ]));

$agents = collect(App\Models\Agent::latest()->take(3)->get()
    ->map(fn($a) => [
        'type'       => 'agent',
        'icon'       => 'las la-user-check',
        'color'      => 'info',
        'label'      => 'New Agent Registered',
        'title'      => $a->name,
        'image'      => $a->profile_image ?? null,
        'route'      => route('admin.agents.show', $a->id),
        'created_at' => $a->created_at,
    ]));

$notifications = $lands
    ->merge($houses)
    ->merge($designs)
    ->merge($agents)
    ->sortByDesc('created_at')
    ->take(10);

$notifCount = $notifications->count();
@endphp

<header class="main-topbar gap-md-2" id="main-topbar">

    {{-- Brand / Toggle --}}
    <div class="navbar-brand">
        <div class="logos">
            <a href="{{ route('admin.dashboard') }}" aria-label="Logo">
                <img src="{{ asset('front/assets/img/logo/logo.png') }}" loading="lazy" height="18" alt="" class="logo-dark">
                <img src="{{ asset('front/assets/img/logo/logo.png') }}" loading="lazy" height="18" alt="" class="logo-light">
            </a>
        </div>
        <button type="button" id="toggleSidebar" class="sidebar-toggle btn p-0" aria-label="sidebar-toggle">
            <i data-lucide="panel-right-open" class="size-4"></i>
        </button>
    </div>

    {{-- Search --}}
    <div class="align-items-center d-none d-lg-flex">
        <div class="position-relative navbar-search">
            <i data-lucide="search" class="size-4 icon"></i>
            <input type="search" class="form-control border-0 shadow-none" placeholder="Search Terra Admin…">
        </div>
    </div>

    {{-- Right Controls --}}
    <div class="d-flex align-items-center gap-2 gap-md-3 ms-auto">

        {{-- Notifications --}}
        <div class="dropdown">
            <button class="btn topbar-link position-relative" type="button"
                    aria-label="Notifications" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-notification-4-line fs-lg"></i>
                @if($notifCount > 0)
                    <span class="notification-animate bg-danger rounded-circle"></span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0">
                <div class="d-flex align-items-center gap-2 p-4 pb-0">
                    <h6 class="flex-grow-1 mb-0">Notifications</h6>
                    <span class="badge bg-danger-subtle text-danger">{{ $notifCount }} New</span>
                </div>

                <div class="topbar-notifications p-4" style="max-height:340px; overflow-y:auto;">
                    <div class="vstack gap-4">
                        @forelse($notifications as $notif)
                            <a href="{{ $notif['route'] }}" class="d-flex gap-3 py-1 rounded text-decoration-none">
                                {{-- Avatar / Icon --}}
                                <div class="flex-shrink-0">
                                    @if($notif['image'])
                                        <img src="{{ asset('storage/' . $notif['image']) }}"
                                             alt="{{ $notif['title'] }}"
                                             class="rounded-circle size-9 object-fit-cover">
                                    @else
                                        <span class="avatar-title bg-{{ $notif['color'] }}-subtle text-{{ $notif['color'] }} rounded-circle size-9 d-flex align-items-center justify-content-center">
                                            <i class="{{ $notif['icon'] }} fs-18"></i>
                                        </span>
                                    @endif
                                </div>
                                {{-- Text --}}
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <span class="badge bg-{{ $notif['color'] }}-subtle text-{{ $notif['color'] }} fs-11 mb-1">
                                            {{ $notif['label'] }}
                                        </span>
                                        <span class="fs-12 text-muted ms-2 flex-shrink-0">
                                            {{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="mb-0 fs-14 text-body fw-medium text-truncate" style="max-width:200px;">
                                        {{ $notif['title'] }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="las la-bell-slash fs-30 d-block mb-2"></i>
                                No new notifications
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="border-top p-3 text-center">
                    <a href="{{ route('activity-logs.index') }}" class="link link-custom-primary small">
                        View All Activity <i class="ri-arrow-right-s-line"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Pending Approvals quick-link --}}
        <div class="dropdown d-none d-md-block">
            <button class="btn topbar-link position-relative" type="button"
                    aria-label="Pending Approvals" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-checkbox-circle-line fs-lg"></i>
                @php
                    $pendingCount = App\Models\Land::where('is_approved', false)->count()
                                 + App\Models\House::where('is_approved', false)->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="notification-animate bg-warning rounded-circle"></span>
                @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end p-0" style="min-width:260px;">
                <div class="p-4 pb-0">
                    <h6 class="mb-1">Pending Approvals</h6>
                    <p class="text-muted fs-13 mb-0">Items awaiting your review</p>
                </div>
                <ul class="list-unstyled p-4 vstack gap-3 mb-0">
                    @php $pendingLands = App\Models\Land::where('is_approved', false)->count(); @endphp
                    @php $pendingHouses = App\Models\House::where('is_approved', false)->count(); @endphp
                    <li>
                        <a href="{{ route('admin.properties.lands.index') }}" class="d-flex align-items-center gap-3 text-decoration-none text-body">
                            <span class="avatar-title bg-success-subtle text-success rounded-circle size-9 d-flex align-items-center justify-content-center">
                                <i class="las la-map-marked-alt fs-18"></i>
                            </span>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-medium fs-14">Land Listings</p>
                                <p class="mb-0 text-muted fs-12">{{ $pendingLands }} pending</p>
                            </div>
                            @if($pendingLands > 0)
                                <span class="badge bg-success">{{ $pendingLands }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.properties.houses.index') }}" class="d-flex align-items-center gap-3 text-decoration-none text-body">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle size-9 d-flex align-items-center justify-content-center">
                                <i class="las la-home fs-18"></i>
                            </span>
                            <div class="flex-grow-1">
                                <p class="mb-0 fw-medium fs-14">House Listings</p>
                                <p class="mb-0 text-muted fs-12">{{ $pendingHouses }} pending</p>
                            </div>
                            @if($pendingHouses > 0)
                                <span class="badge bg-primary">{{ $pendingHouses }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Dark Mode --}}
        <button type="button" id="darkModeButton" class="topbar-link topbar-mode btn" aria-label="Toggle theme">
            <i class="ri-moon-line fs-lg dark"></i>
            <i class="ri-sun-line fs-lg light"></i>
        </button>

        {{-- Admin Profile --}}
        <div class="dropdown profile-dropdown">
            <button class="btn px-0 d-flex align-items-center text-body dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <span class="avatar-title bg-primary text-white fw-bold rounded-circle p-1 size-9 d-flex align-items-center justify-content-center">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                </span>
                <span class="text-start ms-3 d-none d-xl-block">
                    <span class="d-block fw-medium pr-name fs-sm">{{ Auth::user()->name }}</span>
                    <small class="text-muted pr-desc">Administrator</small>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-md p-4 profile-dropdown-menu">
                <ul class="list-unstyled mb-0">
                    <li>
                        <a class="profile-link" href="{{ route('activity-logs.index') }}">
                            <i class="ri-history-line d-inline-block me-2 fs-17"></i> Activity Logs
                        </a>
                    </li>
                    <li>
                        <a class="profile-link" href="{{ route('admin.roles.index') }}">
                            <i class="ri-shield-line d-inline-block me-2 fs-17"></i> Roles & Permissions
                        </a>
                    </li>
                    <li>
                        <a class="profile-link" href="{{ route('front.home') }}" target="_blank">
                            <i class="ri-external-link-line d-inline-block me-2 fs-17"></i> View Site
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" id="topbar-admin-logout">
                            @csrf
                            <a href="#" class="profile-link pb-0"
                               onclick="event.preventDefault(); document.getElementById('topbar-admin-logout').submit();">
                                <i class="ri-logout-circle-r-line me-2 fs-17"></i> Log Out
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
