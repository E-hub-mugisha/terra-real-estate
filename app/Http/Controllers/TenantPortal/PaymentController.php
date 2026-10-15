<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\RentPayment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        $leaseQuery = $tenant->leases();

        $leaseIds = (clone $leaseQuery)->select('id');

        $payments = RentPayment::query()
            ->whereIn('lease_id', $leaseIds)
            ->with(['lease.unit.managedProperty'])
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate(10);

        $totalPaid = RentPayment::query()
            ->whereIn('lease_id', $leaseIds)
            ->where('status', 'completed')
            ->sum('amount');

        $pendingAmount = RentPayment::query()
            ->whereIn('lease_id', $leaseIds)
            ->where('status', 'pending')
            ->sum('amount');

        $activeLeases = (clone $leaseQuery)
            ->where('status', 'active')
            ->with('unit')
            ->get();

        return view('tenant-portal.payments.index', compact(
            'tenant',
            'payments',
            'totalPaid',
            'pendingAmount',
            'activeLeases'
        ));
    }

    public function receipt(Request $request, int $payment): View
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        $leaseIds = $tenant->leases()->select('id');

        $payment = RentPayment::query()
            ->whereIn('lease_id', $leaseIds)
            ->whereKey($payment)
            ->with([
                'lease.unit.managedProperty',
                'lease.unit.building',
                'lease.unit.floor',
            ])
            ->firstOrFail();

        abort_unless(
            $payment->status === 'completed',
            404,
            'A receipt is only available for completed payments.'
        );

        return view('tenant-portal.payments.receipt', compact(
            'tenant',
            'payment'
        ));
    }
}
