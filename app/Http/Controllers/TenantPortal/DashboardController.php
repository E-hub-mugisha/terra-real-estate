<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $tenant = $user->tenantProfile;

        abort_unless($tenant, 403, 'Your tenant profile is not linked to your account.');

        $tenant->loadCount([
            'applications',
            'leases',
            'maintenanceRequests',
        ]);

        // Current active lease
        $activeLease = $tenant->leases()
            ->with([
                'unit.managedProperty',
                'unit.building',
                'unit.floor',
            ])
            ->where('status', 'active')
            ->latest('start_date')
            ->first();

        // Recent rent payments across the tenant's leases
        $rentPayments = $tenant->leases()
            ->with('rentPayments')
            ->get()
            ->pluck('rentPayments')
            ->flatten()
            ->sortByDesc('payment_date')
            ->take(5)
            ->values();

        // Recent maintenance requests
        $maintenanceRequests = $tenant->maintenanceRequests()
            ->with([
                'managedProperty',
                'unit',
            ])
            ->latest()
            ->take(5)
            ->get();

        // Recent applications
        $applications = $tenant->applications()
            ->with([
                'unit.managedProperty',
            ])
            ->latest()
            ->take(5)
            ->get();

        $pendingApplications = $tenant->applications()
            ->where('status', 'pending')
            ->count();

        return view('tenant-portal.dashboard', compact(
            'tenant',
            'activeLease',
            'rentPayments',
            'maintenanceRequests',
            'applications',
            'pendingApplications'
        ));
    }
}