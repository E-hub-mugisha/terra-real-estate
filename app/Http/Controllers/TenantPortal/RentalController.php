<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Always retrieve the tenant profile of the logged-in user.
        $tenant = $user->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        $activeLease = $tenant->leases()
            ->where('status', 'active')
            ->with([
                'unit.managedProperty',
                'unit.building',
                'unit.floor',
                'rentPayments',
            ])
            ->orderByDesc('start_date')
            ->first();

        $leases = $tenant->leases()
            ->with([
                'unit.managedProperty',
                'unit.building',
                'unit.floor',
            ])
            ->orderByDesc('start_date')
            ->paginate(10);

        return view('tenant-portal.rental.index', compact(
            'tenant',
            'activeLease',
            'leases'
        ));
    }
}