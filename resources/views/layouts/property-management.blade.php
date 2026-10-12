<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Dashboard') | Terra Property Management
    </title>

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">

    {{-- Your application assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --terra-orange: #D05208;
            --terra-navy: #19265d;
            --terra-sidebar-bg: #ffffff;
            --terra-sidebar-text: #465064;
            --terra-sidebar-muted: #8b94a5;
            --terra-sidebar-border: #edf0f4;
            --terra-sidebar-hover: #fff4ed;
        }

        /* Sidebar container */
        .terra-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            width: 270px;
            height: 100vh;
            height: 100dvh;
            background: var(--terra-sidebar-bg);
            border-right: 1px solid var(--terra-sidebar-border);
            box-shadow: 4px 0 24px rgba(25, 38, 93, 0.035);
            transition: transform 0.25s ease;
        }

        /* Brand */
        .terra-sidebar-brand {
            min-height: 82px;
            padding: 20px 21px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--terra-sidebar-border);
        }

        .terra-brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--terra-navy);
            text-decoration: none;
        }

        .terra-brand-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            color: #fff;
            background: var(--terra-orange);
            border-radius: 12px;
            font-size: 21px;
        }

        .terra-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .terra-brand-text strong {
            font-size: 21px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .terra-brand-text small {
            margin-top: 4px;
            color: var(--terra-sidebar-muted);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.8px;
        }

        /* User profile */
        .terra-sidebar-user {
            display: flex;
            align-items: center;
            gap: 11px;
            margin: 17px 15px 12px;
            padding: 13px 12px;
            background: #f8f9fb;
            border: 1px solid #f0f1f5;
            border-radius: 12px;
        }

        .terra-user-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            overflow: hidden;
            color: #fff;
            background: var(--terra-navy);
            border-radius: 50%;
            font-size: 17px;
            font-weight: 700;
        }

        .terra-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .terra-user-info {
            display: flex;
            flex: 1;
            flex-direction: column;
            min-width: 0;
        }

        .terra-user-info strong {
            overflow: hidden;
            color: #202a43;
            font-size: 13px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .terra-user-info span {
            margin-top: 4px;
            color: var(--terra-sidebar-muted);
            font-size: 11px;
        }

        .terra-user-status {
            flex-shrink: 0;
            width: 8px;
            height: 8px;
            background: #24a36a;
            border: 2px solid #dff7eb;
            border-radius: 50%;
        }

        /* Navigation scrolling */
        .terra-sidebar-nav {
            flex: 1;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 7px 14px 18px;
            scrollbar-width: thin;
            scrollbar-color: #e2e5eb transparent;
        }

        .terra-nav-group {
            margin-bottom: 19px;
        }

        .terra-nav-heading {
            padding: 12px 12px 8px;
            color: var(--terra-sidebar-muted);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.05px;
            text-transform: uppercase;
        }

        .terra-nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 43px;
            margin: 3px 0;
            padding: 10px 12px;
            color: var(--terra-sidebar-text);
            border-radius: 9px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition:
                color 0.2s ease,
                background-color 0.2s ease,
                transform 0.2s ease;
        }

        .terra-nav-link:hover {
            color: var(--terra-orange);
            background: var(--terra-sidebar-hover);
            transform: translateX(2px);
        }

        .terra-nav-link.active {
            color: var(--terra-orange);
            background: var(--terra-sidebar-hover);
            font-weight: 700;
        }

        .terra-nav-icon {
            flex-shrink: 0;
            width: 19px;
            font-size: 16px;
            text-align: center;
        }

        .terra-nav-active-indicator {
            position: absolute;
            top: 10px;
            right: 0;
            bottom: 10px;
            width: 3px;
            background: var(--terra-orange);
            border-radius: 4px 0 0 4px;
        }

        /* Empty state */
        .terra-sidebar-empty {
            padding: 30px 15px;
            color: var(--terra-sidebar-muted);
            text-align: center;
            font-size: 13px;
        }

        .terra-sidebar-empty i {
            display: block;
            margin-bottom: 10px;
            font-size: 26px;
        }

        /* Footer */
        .terra-sidebar-footer {
            flex-shrink: 0;
            padding: 12px 15px 15px;
            background: #fff;
            border-top: 1px solid var(--terra-sidebar-border);
        }

        .terra-footer-link,
        .terra-logout-button {
            display: flex;
            align-items: center;
            gap: 11px;
            width: 100%;
            min-height: 40px;
            padding: 9px 12px;
            color: var(--terra-sidebar-text);
            background: transparent;
            border: 0;
            border-radius: 8px;
            text-align: left;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .terra-footer-link:hover {
            color: var(--terra-orange);
            background: var(--terra-sidebar-hover);
        }

        .terra-logout-button {
            color: #b42318;
            cursor: pointer;
        }

        .terra-logout-button:hover {
            color: #8e1b13;
            background: #fff0ef;
        }

        .terra-logout-button:disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }

        .terra-sidebar-version {
            margin-top: 10px;
            padding-top: 12px;
            color: #a0a6b2;
            border-top: 1px solid var(--terra-sidebar-border);
            text-align: center;
            font-size: 10px;
        }

        /* Close button */
        .terra-sidebar-close {
            padding: 5px 8px;
            color: var(--terra-sidebar-text);
            background: transparent;
            border: 0;
            font-size: 20px;
        }

        /* Overlay hidden on desktop */
        .terra-sidebar-overlay {
            display: none;
        }

        /*
|--------------------------------------------------------------------------
| Main content positioning
|--------------------------------------------------------------------------
| Add the class "terra-main-content" to the main content wrapper.
*/
        .terra-main-content {
            min-width: 0;
            margin-left: 270px;
            transition: margin-left 0.25s ease;
        }

        /* Tablet and mobile */
        @media (max-width: 991.98px) {
            .terra-sidebar {
                transform: translateX(-100%);
            }

            .terra-sidebar.is-open {
                transform: translateX(0);
            }

            .terra-sidebar-overlay.is-visible {
                position: fixed;
                inset: 0;
                z-index: 1040;
                display: block;
                background: rgba(13, 20, 40, 0.45);
            }

            .terra-main-content {
                margin-left: 0;
            }

            body.terra-sidebar-open {
                overflow: hidden;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @php
    use Illuminate\Support\Facades\Route;

    $user = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Normalize User Role
    |--------------------------------------------------------------------------
    */
    $role = strtolower(trim(
    str_replace([' ', '-'], '_', $user->role ?? '')
    ));

    $roleAliases = [
    'owner' => 'property_owner',
    'landlord' => 'property_owner',
    'property_manager' => 'property_manager',
    'manager' => 'property_manager',
    'agent' => 'real_estate_agent',
    'technician' => 'service_provider',
    'finance_officer' => 'accountant',
    'finance' => 'accountant',
    'terra_admin' => 'admin',
    'super_admin' => 'admin',
    ];

    $role = $roleAliases[$role] ?? $role;

    $roleLabels = [
    'property_owner' => 'Property Owner',
    'property_manager' => 'Property Manager',
    'tenant' => 'Tenant',
    'real_estate_agent'=> 'Real Estate Agent',
    'service_provider' => 'Service Provider',
    'accountant' => 'Accountant / Finance',
    'admin' => 'Terra Administrator',
    ];

    $roleLabel = $roleLabels[$role] ?? 'User Dashboard';

    /*
    |--------------------------------------------------------------------------
    | Sidebar Helpers
    |--------------------------------------------------------------------------
    | Route links are used when the route exists.
    | Otherwise, the item uses a placeholder URL for future implementation.
    */
    $routeUrl = function ($routeName, $fallback = '#', $parameters = []) {
    return Route::has($routeName)
    ? route($routeName, $parameters)
    : url($fallback);
    };

    $isRouteActive = function ($patterns) {
    foreach ((array) $patterns as $pattern) {
    if (request()->routeIs($pattern)) {
    return true;
    }
    }

    return false;
    };

    $isUrlActive = function ($path) {
    return request()->is(ltrim($path, '/'))
    || request()->is(ltrim($path, '/') . '/*');
    };

    /*
    |--------------------------------------------------------------------------
    | Navigation Items
    |--------------------------------------------------------------------------
    | Each item contains:
    | label, icon, URL, route patterns, and optional placeholder path.
    */
    $navigation = [];

    /*
    |--------------------------------------------------------------------------
    | PROPERTY OWNER
    |--------------------------------------------------------------------------
    */
    if ($role === 'property_owner') {
    $navigation = [
    [
    'heading' => 'Overview',
    'items' => [
    [
    'label' => 'Dashboard',
    'icon' => 'bi-speedometer2',
    'url' => $routeUrl(
    'property-management.dashboard',
    '/property-management'
    ),
    'routes' => ['property-management.dashboard'],
    ],
    ],
    ],
    [
    'heading' => 'Property Management',
    'items' => [
    [
    'label' => 'My Properties',
    'icon' => 'bi-buildings',
    'url' => $routeUrl(
    'property-management.properties.index',
    '/property-management/properties'
    ),
    'routes' => ['property-management.properties.*'],
    ],
    [
    'label' => 'Buildings',
    'icon' => 'bi-building',
    'url' => $routeUrl(
    'property-management.buildings.index',
    '/property-management/buildings'
    ),
    'routes' => ['property-management.buildings.*'],
    ],
    [
    'label' => 'Floors',
    'icon' => 'bi-layers',
    'url' => $routeUrl(
    'property-management.floors.index',
    '/property-management/floors'
    ),
    'routes' => ['property-management.floors.*'],
    ],
    [
    'label' => 'Units',
    'icon' => 'bi-grid',
    'url' => $routeUrl(
    'property-management.units.index',
    '/property-management/units'
    ),
    'routes' => ['property-management.units.*'],
    ],
    ],
    ],
    [
    'heading' => 'Tenants & Leases',
    'items' => [
    [
    'label' => 'Tenants',
    'icon' => 'bi-people',
    'url' => $routeUrl(
    'property-management.tenants.index',
    '/property-management/tenants'
    ),
    'routes' => ['property-management.tenants.*'],
    ],
    [
    'label' => 'Applications',
    'icon' => 'bi-file-earmark-text',
    'url' => $routeUrl(
    'property-management.applications.index',
    '/property-management/applications'
    ),
    'routes' => ['property-management.applications.*'],
    ],
    [
    'label' => 'Leases',
    'icon' => 'bi-file-earmark-check',
    'url' => $routeUrl(
    'property-management.leases.index',
    '/property-management/leases'
    ),
    'routes' => ['property-management.leases.*'],
    ],
    ],
    ],
    [
    'heading' => 'Finance',
    'items' => [
    [
    'label' => 'Invoices',
    'icon' => 'bi-receipt',
    'url' => $routeUrl(
    'property-management.invoices.index',
    '/property-management/invoices'
    ),
    'routes' => ['property-management.invoices.*'],
    ],
    [
    'label' => 'Payments',
    'icon' => 'bi-wallet2',
    'url' => $routeUrl(
    'property-management.payments.index',
    '/property-management/payments'
    ),
    'routes' => ['property-management.payments.*'],
    ],
    [
    'label' => 'Rent Ledger',
    'icon' => 'bi-journal-text',
    'url' => url('/property-management/ledgers'),
    'active_paths' => ['property-management/ledgers'],
    ],
    [
    'label' => 'Financial Reports',
    'icon' => 'bi-graph-up',
    'url' => url('/property-management/reports/finance'),
    'active_paths' => ['property-management/reports/finance'],
    ],
    ],
    ],
    [
    'heading' => 'Operations',
    'items' => [
    [
    'label' => 'Maintenance Requests',
    'icon' => 'bi-tools',
    'url' => $routeUrl(
    'property-management.maintenance-requests.index',
    '/property-management/maintenance-requests'
    ),
    'routes' => ['property-management.maintenance-requests.*'],
    ],
    [
    'label' => 'Documents',
    'icon' => 'bi-folder2-open',
    'url' => url('/property-management/documents'),
    'active_paths' => ['property-management/documents'],
    ],
    [
    'label' => 'Communications',
    'icon' => 'bi-chat-dots',
    'url' => url('/property-management/communications'),
    'active_paths' => ['property-management/communications'],
    ],
    [
    'label' => 'Reports & Performance',
    'icon' => 'bi-bar-chart',
    'url' => url('/property-management/reports'),
    'active_paths' => ['property-management/reports'],
    ],
    ],
    ],
    ];
    }

    /*
    |--------------------------------------------------------------------------
    | PROPERTY MANAGER
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'property_manager') {
    $navigation = [
    [
    'heading' => 'Overview',
    'items' => [
    [
    'label' => 'Dashboard',
    'icon' => 'bi-speedometer2',
    'url' => $routeUrl(
    'property-management.dashboard',
    '/property-management'
    ),
    'routes' => ['property-management.dashboard'],
    ],
    ],
    ],
    [
    'heading' => 'Portfolio',
    'items' => [
    [
    'label' => 'Managed Properties',
    'icon' => 'bi-buildings',
    'url' => $routeUrl(
    'property-management.properties.index',
    '/property-management/properties'
    ),
    'routes' => ['property-management.properties.*'],
    ],
    [
    'label' => 'Buildings',
    'icon' => 'bi-building',
    'url' => $routeUrl(
    'property-management.buildings.index',
    '/property-management/buildings'
    ),
    'routes' => ['property-management.buildings.*'],
    ],
    [
    'label' => 'Floors',
    'icon' => 'bi-layers',
    'url' => $routeUrl(
    'property-management.floors.index',
    '/property-management/floors'
    ),
    'routes' => ['property-management.floors.*'],
    ],
    [
    'label' => 'Units',
    'icon' => 'bi-grid',
    'url' => $routeUrl(
    'property-management.units.index',
    '/property-management/units'
    ),
    'routes' => ['property-management.units.*'],
    ],
    ],
    ],
    [
    'heading' => 'Tenants & Leasing',
    'items' => [
    [
    'label' => 'Tenants',
    'icon' => 'bi-people',
    'url' => $routeUrl(
    'property-management.tenants.index',
    '/property-management/tenants'
    ),
    'routes' => ['property-management.tenants.*'],
    ],
    [
    'label' => 'Applications',
    'icon' => 'bi-file-earmark-text',
    'url' => $routeUrl(
    'property-management.applications.index',
    '/property-management/applications'
    ),
    'routes' => ['property-management.applications.*'],
    ],
    [
    'label' => 'Leases',
    'icon' => 'bi-file-earmark-check',
    'url' => $routeUrl(
    'property-management.leases.index',
    '/property-management/leases'
    ),
    'routes' => ['property-management.leases.*'],
    ],
    ],
    ],
    [
    'heading' => 'Finance & Operations',
    'items' => [
    [
    'label' => 'Invoices',
    'icon' => 'bi-receipt',
    'url' => $routeUrl(
    'property-management.invoices.index',
    '/property-management/invoices'
    ),
    'routes' => ['property-management.invoices.*'],
    ],
    [
    'label' => 'Payments',
    'icon' => 'bi-wallet2',
    'url' => $routeUrl(
    'property-management.payments.index',
    '/property-management/payments'
    ),
    'routes' => ['property-management.payments.*'],
    ],
    [
    'label' => 'Maintenance Requests',
    'icon' => 'bi-tools',
    'url' => $routeUrl(
    'property-management.maintenance-requests.index',
    '/property-management/maintenance-requests'
    ),
    'routes' => ['property-management.maintenance-requests.*'],
    ],
    [
    'label' => 'Communications',
    'icon' => 'bi-chat-dots',
    'url' => url('/property-management/communications'),
    'active_paths' => ['property-management/communications'],
    ],
    [
    'label' => 'Reports',
    'icon' => 'bi-bar-chart',
    'url' => url('/property-management/reports'),
    'active_paths' => ['property-management/reports'],
    ],
    ],
    ],
    ];
    }

    /*
    |--------------------------------------------------------------------------
    | TENANT
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'tenant') {
    $navigation = [
    [
    'heading' => 'My Account',
    'items' => [
    [
    'label' => 'Dashboard',
    'icon' => 'bi-speedometer2',
    'url' => $routeUrl(
    'tenant-portal.dashboard',
    '/tenant-portal'
    ),
    'routes' => ['tenant-portal.dashboard'],
    ],
    [
    'label' => 'My Profile',
    'icon' => 'bi-person',
    'url' => $routeUrl(
    'tenant-portal.profile.edit',
    '/tenant-portal/profile'
    ),
    'routes' => ['tenant-portal.profile.*'],
    ],
    ],
    ],
    [
    'heading' => 'Properties & Leasing',
    'items' => [
    [
    'label' => 'Find Properties',
    'icon' => 'bi-search',
    'url' => $routeUrl(
    'tenant-portal.properties.index',
    '/tenant-portal/properties'
    ),
    'routes' => ['tenant-portal.properties.index'],
    ],
    [
    'label' => 'My Applications',
    'icon' => 'bi-file-earmark-text',
    'url' => $routeUrl(
    'tenant-portal.applications.index',
    '/tenant-portal/applications'
    ),
    'routes' => ['tenant-portal.applications.*'],
    ],
    [
    'label' => 'My Leases',
    'icon' => 'bi-file-earmark-check',
    'url' => $routeUrl(
    'tenant-portal.leases.index',
    '/tenant-portal/leases'
    ),
    'routes' => ['tenant-portal.leases.*'],
    ],
    [
    'label' => 'Documents',
    'icon' => 'bi-folder2-open',
    'url' => url('/tenant-portal/documents'),
    'active_paths' => ['tenant-portal/documents'],
    ],
    ],
    ],
    [
    'heading' => 'Rent & Payments',
    'items' => [
    [
    'label' => 'My Payments',
    'icon' => 'bi-wallet2',
    'url' => $routeUrl(
    'tenant-portal.payments.index',
    '/tenant-portal/payments'
    ),
    'routes' => ['tenant-portal.payments.*'],
    ],
    [
    'label' => 'Payment Receipts',
    'icon' => 'bi-receipt',
    'url' => url('/tenant-portal/receipts'),
    'active_paths' => ['tenant-portal/receipts'],
    ],
    ],
    ],
    [
    'heading' => 'Support',
    'items' => [
    [
    'label' => 'Maintenance Requests',
    'icon' => 'bi-tools',
    'url' => $routeUrl(
    'tenant-portal.maintenance-requests.index',
    '/tenant-portal/maintenance-requests'
    ),
    'routes' => ['tenant-portal.maintenance-requests.*'],
    ],
    [
    'label' => 'Messages',
    'icon' => 'bi-chat-dots',
    'url' => url('/tenant-portal/messages'),
    'active_paths' => ['tenant-portal/messages'],
    ],
    [
    'label' => 'Notifications',
    'icon' => 'bi-bell',
    'url' => url('/tenant-portal/notifications'),
    'active_paths' => ['tenant-portal/notifications'],
    ],
    [
    'label' => 'Renewal / Move-out',
    'icon' => 'bi-calendar-check',
    'url' => url('/tenant-portal/lease-actions'),
    'active_paths' => ['tenant-portal/lease-actions'],
    ],
    ],
    ],
    ];
    }

    /*
    |--------------------------------------------------------------------------
    | REAL ESTATE AGENT
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'real_estate_agent') {
    $navigation = [
    [
    'heading' => 'Overview',
    'items' => [
    [
    'label' => 'Dashboard',
    'icon' => 'bi-speedometer2',
    'url' => url('/agent/dashboard'),
    'active_paths' => ['agent/dashboard'],
    ],
    ],
    ],
    [
    'heading' => 'Property Listings',
    'items' => [
    [
    'label' => 'My Listings',
    'icon' => 'bi-buildings',
    'url' => url('/agent/properties'),
    'active_paths' => ['agent/properties'],
    ],
    [
    'label' => 'Register Property',
    'icon' => 'bi-plus-square',
    'url' => url('/agent/properties/create'),
    'active_paths' => ['agent/properties/create'],
    ],
    ],
    ],
    [
    'heading' => 'Clients & Deals',
    'items' => [
    [
    'label' => 'Clients',
    'icon' => 'bi-people',
    'url' => url('/agent/clients'),
    'active_paths' => ['agent/clients'],
    ],
    [
    'label' => 'Transactions',
    'icon' => 'bi-arrow-left-right',
    'url' => url('/agent/transactions'),
    'active_paths' => ['agent/transactions'],
    ],
    [
    'label' => 'Commissions',
    'icon' => 'bi-cash-stack',
    'url' => url('/agent/commissions'),
    'active_paths' => ['agent/commissions'],
    ],
    ],
    ],
    ];
    }

    /*
    |--------------------------------------------------------------------------
    | SERVICE PROVIDER / TECHNICIAN
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'service_provider') {
    $navigation = [
    [
    'heading' => 'Overview',
    'items' => [
    [
    'label' => 'Dashboard',
    'icon' => 'bi-speedometer2',
    'url' => url('/service-provider/dashboard'),
    'active_paths' => ['service-provider/dashboard'],
    ],
    ],
    ],
    [
    'heading' => 'Work Management',
    'items' => [
    [
    'label' => 'Assigned Requests',
    'icon' => 'bi-tools',
    'url' => url('/service-provider/requests'),
    'active_paths' => ['service-provider/requests'],
    ],
    [
    'label' => 'Work History',
    'icon' => 'bi-clock-history',
    'url' => url('/service-provider/work-history'),
    'active_paths' => ['service-provider/work-history'],
    ],
    [
    'label' => 'Schedule',
    'icon' => 'bi-calendar-week',
    'url' => url('/service-provider/schedule'),
    'active_paths' => ['service-provider/schedule'],
    ],
    ],
    ],
    [
    'heading' => 'Account',
    'items' => [
    [
    'label' => 'My Profile',
    'icon' => 'bi-person',
    'url' => url('/service-provider/profile'),
    'active_paths' => ['service-provider/profile'],
    ],
    [
    'label' => 'Messages',
    'icon' => 'bi-chat-dots',
    'url' => url('/service-provider/messages'),
    'active_paths' => ['service-provider/messages'],
    ],
    ],
    ],
    ];
    }

    /*
    |--------------------------------------------------------------------------
    | ACCOUNTANT / FINANCE OFFICER
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'accountant') {
    $navigation = [
    [
    'heading' => 'Finance Overview',
    'items' => [
    [
    'label' => 'Dashboard',
    'icon' => 'bi-speedometer2',
    'url' => url('/finance/dashboard'),
    'active_paths' => ['finance/dashboard'],
    ],
    ],
    ],
    [
    'heading' => 'Rent & Payments',
    'items' => [
    [
    'label' => 'Invoices',
    'icon' => 'bi-receipt',
    'url' => $routeUrl(
    'property-management.invoices.index',
    '/property-management/invoices'
    ),
    'routes' => ['property-management.invoices.*'],
    ],
    [
    'label' => 'Payments',
    'icon' => 'bi-wallet2',
    'url' => $routeUrl(
    'property-management.payments.index',
    '/property-management/payments'
    ),
    'routes' => ['property-management.payments.*'],
    ],
    [
    'label' => 'Lease Ledgers',
    'icon' => 'bi-journal-text',
    'url' => url('/finance/ledgers'),
    'active_paths' => ['finance/ledgers'],
    ],
    [
    'label' => 'Outstanding Balances',
    'icon' => 'bi-exclamation-circle',
    'url' => url('/finance/outstanding-balances'),
    'active_paths' => ['finance/outstanding-balances'],
    ],
    ],
    ],
    [
    'heading' => 'Financial Records',
    'items' => [
    [
    'label' => 'Receipts',
    'icon' => 'bi-file-earmark-check',
    'url' => url('/finance/receipts'),
    'active_paths' => ['finance/receipts'],
    ],
    [
    'label' => 'Expenses',
    'icon' => 'bi-cash-stack',
    'url' => url('/finance/expenses'),
    'active_paths' => ['finance/expenses'],
    ],
    [
    'label' => 'Financial Reports',
    'icon' => 'bi-bar-chart',
    'url' => url('/finance/reports'),
    'active_paths' => ['finance/reports'],
    ],
    ],
    ],
    ];
    }

    /*
    |--------------------------------------------------------------------------
    | TERRA ADMINISTRATOR
    |--------------------------------------------------------------------------
    */
    elseif ($role === 'admin') {
    $navigation = [
    [
    'heading' => 'Platform Overview',
    'items' => [
    [
    'label' => 'Admin Dashboard',
    'icon' => 'bi-speedometer2',
    'url' => url('/admin/dashboard'),
    'active_paths' => ['admin/dashboard'],
    ],
    ],
    ],
    [
    'heading' => 'Platform Management',
    'items' => [
    [
    'label' => 'Users',
    'icon' => 'bi-people',
    'url' => url('/admin/users'),
    'active_paths' => ['admin/users'],
    ],
    [
    'label' => 'Properties',
    'icon' => 'bi-buildings',
    'url' => url('/admin/properties'),
    'active_paths' => ['admin/properties'],
    ],
    [
    'label' => 'Property Managers',
    'icon' => 'bi-person-badge',
    'url' => url('/admin/property-managers'),
    'active_paths' => ['admin/property-managers'],
    ],
    [
    'label' => 'Agents',
    'icon' => 'bi-person-workspace',
    'url' => url('/admin/agents'),
    'active_paths' => ['admin/agents'],
    ],
    [
    'label' => 'Service Providers',
    'icon' => 'bi-tools',
    'url' => url('/admin/service-providers'),
    'active_paths' => ['admin/service-providers'],
    ],
    ],
    ],
    [
    'heading' => 'Finance & Oversight',
    'items' => [
    [
    'label' => 'Transactions',
    'icon' => 'bi-arrow-left-right',
    'url' => url('/admin/transactions'),
    'active_paths' => ['admin/transactions'],
    ],
    [
    'label' => 'Reports',
    'icon' => 'bi-bar-chart',
    'url' => url('/admin/reports'),
    'active_paths' => ['admin/reports'],
    ],
    [
    'label' => 'Platform Settings',
    'icon' => 'bi-gear',
    'url' => url('/admin/settings'),
    'active_paths' => ['admin/settings'],
    ],
    ],
    ],
    ];
    }
    @endphp

    <aside class="terra-sidebar" id="terraSidebar">

        {{-- Brand --}}
        <div class="terra-sidebar-brand">
            <a href="{{ url('/') }}" class="terra-brand-link">
                <span class="terra-brand-icon">
                    <i class="bi bi-buildings-fill"></i>
                </span>

                <span class="terra-brand-text">
                    <strong>TERRA</strong>
                    <small>PROPERTY MANAGEMENT</small>
                </span>
            </a>

            <button
                type="button"
                class="terra-sidebar-close d-lg-none"
                id="terraSidebarClose"
                aria-label="Close sidebar">
                <i class="bi bi-x-lg"></i>
            </button>

            <button
                type="button"
                id="terraSidebarToggle"
                class="btn btn-light d-lg-none"
                aria-label="Open navigation">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>

        {{-- Current user --}}
        <div class="terra-sidebar-user">
            <div class="terra-user-avatar">
                @if (!empty($user->profile_photo_path))
                <img
                    src="{{ asset('storage/' . $user->profile_photo_path) }}"
                    alt="{{ $user->name }}">
                @else
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                @endif
            </div>

            <div class="terra-user-info">
                <strong>{{ $user->name ?? 'User' }}</strong>
                <span>{{ $roleLabel }}</span>
            </div>

            <span class="terra-user-status" title="Signed in"></span>
        </div>

        {{-- Navigation --}}
        <nav class="terra-sidebar-nav" aria-label="Main navigation">

            @forelse ($navigation as $group)
            <div class="terra-nav-group">

                <div class="terra-nav-heading">
                    {{ $group['heading'] }}
                </div>

                @foreach ($group['items'] as $item)
                @php
                $active = false;

                if (!empty($item['routes'])) {
                $active = $isRouteActive($item['routes']);
                }

                if (!$active && !empty($item['active_paths'])) {
                foreach ($item['active_paths'] as $path) {
                if ($isUrlActive($path)) {
                $active = true;
                break;
                }
                }
                }
                @endphp

                <a
                    href="{{ $item['url'] }}"
                    class="terra-nav-link {{ $active ? 'active' : '' }}"
                    @if ($active) aria-current="page" @endif>
                    <i class="bi {{ $item['icon'] }} terra-nav-icon"></i>

                    <span>{{ $item['label'] }}</span>

                    @if ($active)
                    <span class="terra-nav-active-indicator"></span>
                    @endif
                </a>
                @endforeach

            </div>
            @empty
            <div class="terra-sidebar-empty">
                <i class="bi bi-shield-lock"></i>
                <p>No navigation has been configured for your role.</p>
            </div>
            @endforelse

        </nav>

        {{-- Sidebar footer --}}
        <div class="terra-sidebar-footer">

            <a href="{{ url('/') }}" class="terra-footer-link">
                <i class="bi bi-globe2"></i>
                <span>Visit Terra Website</span>
            </a>

            @if (Route::has('profile.edit'))
            <a href="{{ route('profile.edit') }}" class="terra-footer-link">
                <i class="bi bi-person-gear"></i>
                <span>Account Settings</span>
            </a>
            @endif

            <form
                method="POST"
                action="{{ Route::has('logout') ? route('logout') : '#' }}"
                class="terra-logout-form">
                @csrf

                <button
                    type="submit"
                    class="terra-logout-button"
                    @if (!Route::has('logout')) disabled @endif>
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </button>
            </form>

            <div class="terra-sidebar-version">
                Terra Property Management
            </div>

        </div>

    </aside>

    {{-- Mobile overlay --}}
    <div class="terra-sidebar-overlay" id="terraSidebarOverlay"></div>

    <div class="terra-main-content">

        {{-- Header --}}
        <header class="bg-white border-bottom px-3 px-lg-4 py-3">
            <div class="d-flex align-items-center justify-content-between gap-3">

                <div class="d-flex align-items-center gap-3">
                    <button
                        type="button"
                        id="terraSidebarToggle"
                        class="btn btn-light d-lg-none"
                        aria-label="Open navigation">
                        <i class="bi bi-list fs-4"></i>
                    </button>

                    <div>
                        <h1 class="h5 mb-1 fw-bold">
                            @yield('page-heading', 'Dashboard')
                        </h1>

                        <small class="text-muted">
                            @yield('breadcrumb', 'Property Management')
                        </small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span class="d-none d-sm-inline text-muted small">
                        {{ auth()->user()->name ?? 'User' }}
                    </span>

                    <a
                        href="{{ url('/') }}"
                        class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-globe2 me-1"></i>
                        Website
                    </a>
                </div>

            </div>
        </header>

        {{-- Page content --}}
        <main class="container-fluid px-3 px-lg-4 py-4">

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
            @endif

            @yield('content')

        </main>

        <footer class="border-top bg-white px-4 py-3">
            <div class="d-flex flex-wrap justify-content-between gap-2">
                <small class="text-muted">
                    &copy; {{ date('Y') }} Terra. All rights reserved.
                </small>

                <small class="text-muted">
                    Property Management
                </small>
            </div>
        </footer>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('terraSidebar');
            const overlay = document.getElementById('terraSidebarOverlay');
            const closeButton = document.getElementById('terraSidebarClose');

            // Add a toggle button with this ID in your top header.
            const openButton = document.getElementById('terraSidebarToggle');

            if (!sidebar || !overlay) {
                return;
            }

            function openSidebar() {
                sidebar.classList.add('is-open');
                overlay.classList.add('is-visible');
                document.body.classList.add('terra-sidebar-open');
            }

            function closeSidebar() {
                sidebar.classList.remove('is-open');
                overlay.classList.remove('is-visible');
                document.body.classList.remove('terra-sidebar-open');
            }

            if (openButton) {
                openButton.addEventListener('click', openSidebar);
            }

            if (closeButton) {
                closeButton.addEventListener('click', closeSidebar);
            }

            overlay.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>