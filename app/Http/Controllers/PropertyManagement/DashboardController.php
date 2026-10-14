<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\ManagedProperty;
use App\Models\MaintenanceRequest;
use App\Models\PropertyExpense;
use App\Models\RentPayment;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->first();

        abort_unless($owner, 403, 'Property owner profile not found.');

        $propertyIds = ManagedProperty::query()
            ->where('property_owner_id', $owner->id)
            ->select('id');

        $unitIds = Unit::query()
            ->whereIn('managed_property_id', $propertyIds)
            ->select('id');

        $leaseIds = Lease::query()
            ->whereIn('unit_id', $unitIds)
            ->select('id');

        $propertiesCount = ManagedProperty::where(
            'property_owner_id',
            $owner->id
        )->count();

        $unitsCount = Unit::whereIn(
            'managed_property_id',
            $propertyIds
        )->count();

        $occupiedUnits = Unit::whereIn(
            'managed_property_id',
            $propertyIds
        )->where('status', 'occupied')->count();

        $activeLeases = Lease::whereIn(
            'unit_id',
            $unitIds
        )->where('status', 'active')->count();

        $tenantIds = Lease::query()
            ->whereIn('unit_id', $unitIds)
            ->where('status', 'active')
            ->select('tenant_id')
            ->distinct();

        $tenantsCount = Tenant::whereIn('id', $tenantIds)->count();

        $rentCollected = RentPayment::whereIn(
            'lease_id',
            $leaseIds
        )
            ->where('status', 'completed')
            ->where('payment_type', 'rent')
            ->sum('amount');

        $expensesTotal = PropertyExpense::where(
            'managed_property_id',
            $owner->properties()->select('id')
        )->whereIn('status', ['recorded', 'approved'])
            ->sum('amount');

        $pendingMaintenance = MaintenanceRequest::whereIn(
            'managed_property_id',
            $propertyIds
        )->whereIn('status', ['submitted', 'assigned', 'in_progress'])
            ->count();

        $recentProperties = ManagedProperty::where(
            'property_owner_id',
            $owner->id
        )->latest()->take(5)->get();

        return view('property-management.dashboard', compact(
            'propertiesCount',
            'unitsCount',
            'occupiedUnits',
            'activeLeases',
            'tenantsCount',
            'rentCollected',
            'expensesTotal',
            'pendingMaintenance',
            'recentProperties'
        ));
    }
}