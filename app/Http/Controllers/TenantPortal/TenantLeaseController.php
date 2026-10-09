<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantLeaseController extends Controller
{
    /**
     * Display leases belonging to the authenticated tenant.
     */
    public function index(Request $request)
    {
        $tenant = Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();

        $leases = Lease::with([
            'unit.floor.building.property',
            'application',
        ])
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->paginate(10);

        return view('tenant-portal.leases.index', compact('leases'));
    }

    /**
     * Display details of one lease belonging to the authenticated tenant.
     */

    public function show(Request $request, Lease $lease)
    {
        $tenant = Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();

        abort_unless(
            (int) $lease->tenant_id === (int) $tenant->id,
            403
        );

        $lease->load([
            'unit.floor.building.property',
            'application',
            'signer',
            'invoices' => function ($query) {
                $query->orderByDesc('issue_date');
            },
            'payments' => function ($query) {
                $query->orderByDesc('payment_date');
            },
            'ledgerEntries' => function ($query) {
                $query->orderByDesc('entry_date')
                    ->orderByDesc('id');
            },
        ]);

        return view('tenant-portal.leases.show', compact('lease'));
    }
}
