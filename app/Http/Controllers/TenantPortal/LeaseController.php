<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaseController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        $leases = $tenant->leases()
    ->with(['unit.managedProperty', 'unit.building', 'unit.floor'])
    ->latest('start_date')
    ->paginate(10);

        return view('tenant-portal.leases.index', compact(
            'tenant',
            'leases'
        ));
    }

    public function show(Request $request, int $lease): View
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        // Only retrieve leases belonging to this tenant.
        $lease = $tenant->leases()
            ->with(['unit.managedProperty', 'unit.building', 'unit.floor', 'creator'])
            ->whereKey($lease)
            ->firstOrFail();

        return view('tenant-portal.leases.show', compact(
            'tenant',
            'lease'
        ));
    }
}