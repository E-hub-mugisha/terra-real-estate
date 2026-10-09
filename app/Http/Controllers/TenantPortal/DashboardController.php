<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\RentInvoice;
use App\Models\RentPayment;
use App\Models\Tenant;
use App\Models\TenantApplication;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();

        $applications = TenantApplication::with([
            'unit.floor.building.property',
        ])
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->take(5)
            ->get();

        $leases = Lease::with([
            'unit.floor.building.property',
        ])
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->get();

        $invoices = RentInvoice::where('tenant_id', $tenant->id)
            ->whereNotIn('status', ['draft', 'cancelled'])
            ->latest('due_date')
            ->take(5)
            ->get();

        $payments = RentPayment::where('tenant_id', $tenant->id)
            ->where('status', 'confirmed')
            ->latest('payment_date')
            ->take(5)
            ->get();

        $availableUnits = Unit::where('availability', 'available')
            ->where('occupancy_status', 'vacant')
            ->whereHas('floor.building.property', function ($query) {
                $query->where('management_status', 'active')
                    ->where('is_managed', true)
                    ->where('is_approved', true);
            })
            ->count();

        return view('tenant-portal.dashboard', compact(
            'tenant',
            'applications',
            'leases',
            'invoices',
            'payments',
            'availableUnits'
        ));
    }
}