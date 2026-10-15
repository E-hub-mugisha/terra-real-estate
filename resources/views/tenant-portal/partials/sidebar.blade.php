<a
    href="{{ route('tenant-portal.dashboard') }}"
    class="tenant-brand d-inline-block mb-4 mt-2">
    Terra<span>.</span>
</a>

<div class="mb-4 p-3 rounded-3" style="background:#f5f7fb;">
    <div class="small tenant-muted">Tenant Account</div>

    <div class="fw-semibold mt-1">
        {{ auth()->user()->name }}
    </div>

    <div class="small tenant-muted">
        {{ auth()->user()->email }}
    </div>
</div>

<div class="small text-uppercase tenant-muted fw-bold mb-2">
    My Account
</div>

<a
    href="{{ route('tenant-portal.dashboard') }}"
    class="tenant-nav-link {{ request()->routeIs('tenant-portal.dashboard') ? 'active' : '' }}">
    <i class="bi bi-grid"></i>
    Dashboard
</a>

<a
    href="{{ route('tenant-portal.profile.edit') }}"
    class="tenant-nav-link {{ request()->routeIs('tenant-portal.profile.*') ? 'active' : '' }}">
    <i class="bi bi-person"></i>
    My Profile
</a>

<div class="small text-uppercase tenant-muted fw-bold mt-4 mb-2">
    My Property
</div>

<a
    href="{{ route('tenant-portal.rental.index') }}"
    class="tenant-nav-link {{ request()->routeIs('tenant-portal.rental.*') ? 'active' : '' }}">
    <i class="bi bi-house"></i>
    My Rental
</a>

<a
    href="{{ route('tenant-portal.applications.index') }}"
    class="tenant-nav-link {{ request()->routeIs('tenant-portal.applications.*') ? 'active' : '' }}">
    <i class="bi bi-file-earmark-text"></i>
    Applications
</a>

<a
    href="{{ route('tenant-portal.leases.index') }}"
    class="tenant-nav-link {{ request()->routeIs('tenant-portal.leases.*') ? 'active' : '' }}">
    <i class="bi bi-file-earmark-check"></i>
    My Leases
</a>

<div class="small text-uppercase tenant-muted fw-bold mt-4 mb-2">
    Payments & Services
</div>

<a
    href="{{ route('tenant-portal.payments.index') }}"
    class="tenant-nav-link {{ request()->routeIs('tenant-portal.payments.*') ? 'active' : '' }}">
    <i class="bi bi-wallet2"></i>
    Rent & Payments
</a>

<a
    href="{{ route('tenant-portal.maintenance-requests.index') }}"
    class="tenant-nav-link {{ request()->routeIs('tenant-portal.maintenance-requests.*') ? 'active' : '' }}">
    <i class="bi bi-tools"></i>
    Maintenance
</a>