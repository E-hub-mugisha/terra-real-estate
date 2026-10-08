<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\RentLedgerEntries;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentLedgerController extends Controller
{
    /**
     * Display all ledger entries.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $entries = RentLedgerEntries::with([
            'tenant',
            'lease',
            'lease.unit',
            'unit',
            'unit.floor',
            'unit.floor.building',
            'unit.floor.building.property',
            'invoice',
            'payment',
        ])
        ->whereHas('unit.floor.building.property', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->when($request->filled('tenant_id'), function ($query) use ($request) {
            $query->where('tenant_id', $request->tenant_id);
        })
        ->when($request->filled('lease_id'), function ($query) use ($request) {
            $query->where('lease_id', $request->lease_id);
        })
        ->when($request->filled('entry_type'), function ($query) use ($request) {
            $query->where('entry_type', $request->entry_type);
        })
        ->when($request->filled('search'), function ($query) use ($request) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('description', 'like', "%{$search}%")

                    ->orWhereHas('tenant', function ($tenant) use ($search) {
                        $tenant
                            ->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })

                    ->orWhereHas('invoice', function ($invoice) use ($search) {
                        $invoice->where(
                            'invoice_number',
                            'like',
                            "%{$search}%"
                        );
                    })

                    ->orWhereHas('payment', function ($payment) use ($search) {
                        $payment
                            ->where(
                                'payment_number',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'transaction_id',
                                'like',
                                "%{$search}%"
                            );
                    });
            });
        })
        ->orderByDesc('entry_date')
        ->orderByDesc('id')
        ->paginate(20)
        ->withQueryString();

        $tenants = Tenant::query()
            ->whereHas(
                'leases.unit.floor.building.property',
                function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            )
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view(
            'property-management.ledger.index',
            compact('entries', 'tenants')
        );
    }


    /**
     * Display ledger for a specific lease.
     */
    public function leaseLedger(Lease $lease)
    {
        /*
        |--------------------------------------------------------------------------
        | Load lease relationships
        |--------------------------------------------------------------------------
        */

        $lease->load([
            'tenant',
            'unit',
            'unit.floor',
            'unit.floor.building',
            'unit.floor.building.property',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get property
        |--------------------------------------------------------------------------
        */

        $property = $lease->unit
            ?->floor
            ?->building
            ?->property;

        /*
        |--------------------------------------------------------------------------
        | Property must exist
        |--------------------------------------------------------------------------
        */

        if (!$property) {
            abort(404, 'Property associated with this lease was not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Verify ownership
        |--------------------------------------------------------------------------
        */

        if ((int) $property->user_id !== (int) Auth::id()) {
            abort(403, 'You are not authorized to view this lease ledger.');
        }

        /*
        |--------------------------------------------------------------------------
        | Get ledger entries
        |--------------------------------------------------------------------------
        */

        $entries = RentLedgerEntries::with([
            'tenant',
            'lease',
            'unit',
            'invoice',
            'payment',
        ])
        ->where('lease_id', $lease->id)
        ->orderBy('entry_date')
        ->orderBy('id')
        ->get();

        /*
        |--------------------------------------------------------------------------
        | Calculate totals
        |--------------------------------------------------------------------------
        */

        $totalDebit = $entries->sum('debit');

        $totalCredit = $entries->sum('credit');

        $currentBalance = $entries->last()?->balance ?? 0;

        return view(
            'property-management.ledger.lease',
            compact(
                'lease',
                'property',
                'entries',
                'totalDebit',
                'totalCredit',
                'currentBalance'
            )
        );
    }


    /**
     * Display one ledger entry.
     */
    public function show(RentLedgerEntries $entry)
    {
        $entry->load([
            'tenant',
            'lease',
            'lease.unit',
            'lease.unit.floor',
            'lease.unit.floor.building',
            'lease.unit.floor.building.property',
            'unit',
            'unit.floor',
            'unit.floor.building',
            'unit.floor.building.property',
            'invoice',
            'payment',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get property
        |--------------------------------------------------------------------------
        */

        $property = null;

        if ($entry->unit) {
            $property = $entry->unit
                ->floor
                ?->building
                ?->property;
        }

        if (!$property && $entry->lease?->unit) {
            $property = $entry->lease->unit
                ->floor
                ?->building
                ?->property;
        }

        if (!$property) {
            abort(
                404,
                'Property associated with this ledger entry was not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ownership check
        |--------------------------------------------------------------------------
        */

        if ((int) $property->user_id !== (int) Auth::id()) {
            abort(403, 'You are not authorized to view this ledger entry.');
        }

        return view(
            'property-management.ledger.show',
            compact('entry')
        );
    }
}