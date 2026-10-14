<aside class="admin-sidebar" id="adminSidebar">

    <a href="{{ url('/admin') }}" class="admin-brand">
        <div class="admin-brand-mark">T</div>

        <div>
            <div class="admin-brand-name">TERRA</div>
            <div class="admin-brand-subtitle">Real Estate Administration</div>
        </div>
    </a>

    <div class="sidebar-content">

        <div class="sidebar-label">Overview</div>

        <a href="{{ url('/admin') }}"
            class="sidebar-link {{ request()->is('admin') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span>Dashboard</span>
        </a>

        <div class="sidebar-label">Property Management</div>

        <a href="{{ route('admin.property-management.owners.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.owners.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Property Owners</span>
        </a>

        <a href="{{ url('/admin/property-management/properties') }}"
            class="sidebar-link {{ request()->is('admin/property-management/properties*') ? 'active' : '' }}">
            <i class="bi bi-buildings"></i>
            <span>Managed Properties</span>
        </a>

        <a href="{{ route('admin.property-management.buildings.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.buildings.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>
            <span>Buildings</span>
        </a>

        <a href="{{ route('admin.property-management.floors.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.floors.*') ? 'active' : '' }}">
            <i class="bi bi-layers"></i>
            <span>Floors</span>
        </a>

        <a href="{{ route('admin.property-management.units.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.units.*') ? 'active' : '' }}">
            <i class="bi bi-door-open"></i>
            <span>Units</span>
        </a>

        <div class="sidebar-label">Tenancy</div>

        <a href="{{ route('admin.property-management.tenants.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.tenants.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            <span>Tenants</span>
        </a>

        <a href="{{ route('admin.property-management.applications.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.applications.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Tenant Applications</span>
        </a>

        <a href="{{ route('admin.property-management.leases.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.leases.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-check"></i>
            <span>Leases</span>
        </a>

        <div class="sidebar-label">Finance & Operations</div>

        <a href="{{ route('admin.property-management.payments.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.payments.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i>
            <span>Rent Payments</span>
        </a>

        <a href="{{ route('admin.property-management.expenses.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.expenses.*') ? 'active' : '' }}">
            <i class="bi bi-wallet2"></i>
            <span>Property Expenses</span>
        </a>

        <a href="{{ route('admin.property-management.maintenance-requests.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.property-management.maintenance-requests.*') ? 'active' : '' }}">
            <i class="bi bi-tools"></i>
            <span>Maintenance Requests</span>
        </a>

        <div class="sidebar-label">Marketplace</div>

        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-link">
            <i class="bi bi-shop"></i>
            <span>Marketplace Admin</span>
        </a>

    </div>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div class="topbar-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>

            <div class="flex-grow-1 overflow-hidden">
                <div class="admin-user-name text-truncate">
                    {{ auth()->user()->name ?? 'Administrator' }}
                </div>
                <div class="admin-user-role">Administrator</div>
            </div>
        </div>
    </div>

</aside>