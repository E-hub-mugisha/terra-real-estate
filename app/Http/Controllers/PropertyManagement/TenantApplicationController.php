<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantApplication;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TenantApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = TenantApplication::with([
            'tenant',
            'unit.floor.building.property',
        ])->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('tenant', function ($tenant) use ($search) {
                    $tenant->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });

                $q->orWhereHas('unit', function ($unit) use ($search) {
                    $unit->where(
                        'unit_number',
                        'like',
                        "%{$search}%"
                    );
                });
            });
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $applications = $query
            ->paginate(15)
            ->withQueryString();

        return view(
            'property-management.applications.index',
            compact('applications')
        );
    }

    public function create()
    {
        $tenants = Tenant::where('status', 'active')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $units = Unit::with([
            'floor.building.property',
        ])
            ->where('occupancy_status', 'vacant')
            ->where('availability', 'available')
            ->orderBy('unit_number')
            ->get();

        return view(
            'property-management.applications.create',
            compact('tenants', 'units')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => [
                'required',
                'exists:tenants,id',
            ],

            'unit_id' => [
                'required',
                'exists:units,id',
            ],

            'application_date' => [
                'required',
                'date',
            ],

            'preferred_move_in_date' => [
                'nullable',
                'date',
                'after_or_equal:application_date',
            ],

            'offered_rent' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'offered_deposit' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        // Always start new applications as pending
        $validated['status'] = 'pending';

        $unit = Unit::findOrFail($validated['unit_id']);

        if (
            $unit->occupancy_status !== 'vacant' ||
            $unit->availability !== 'available'
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'The selected unit is no longer available.'
                );
        }

        TenantApplication::create($validated);

        return redirect()
            ->route('property-management.applications.index')
            ->with(
                'success',
                'Tenant application created successfully.'
            );
    }

    public function show(TenantApplication $application)
    {
        $application->load([
            'tenant',
            'unit.floor.building.property',
            'reviewer',
            'lease',
        ]);

        return view(
            'property-management.applications.show',
            compact('application')
        );
    }

    public function edit(TenantApplication $application)
    {
        if (
            in_array(
                $application->status,
                ['approved', 'rejected', 'withdrawn']
            )
        ) {
            return back()->with(
                'error',
                'This application can no longer be edited.'
            );
        }

        $tenants = Tenant::where('status', 'active')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $units = Unit::with([
            'floor.building.property',
        ])
            ->where(function ($query) use ($application) {
                $query->where('occupancy_status', 'vacant')
                    ->where('availability', 'available')
                    ->orWhere('id', $application->unit_id);
            })
            ->orderBy('unit_number')
            ->get();

        return view(
            'property-management.applications.edit',
            compact(
                'application',
                'tenants',
                'units'
            )
        );
    }

    public function update(
        Request $request,
        TenantApplication $application
    ) {
        if (
            in_array(
                $application->status,
                ['approved', 'rejected', 'withdrawn']
            )
        ) {
            return back()->with(
                'error',
                'This application can no longer be modified.'
            );
        }

        $validated = $request->validate([
            'tenant_id' => [
                'required',
                'exists:tenants,id',
            ],

            'unit_id' => [
                'required',
                'exists:units,id',
            ],

            'application_date' => [
                'required',
                'date',
            ],

            'preferred_move_in_date' => [
                'nullable',
                'date',
                'after_or_equal:application_date',
            ],

            'offered_rent' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'offered_deposit' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'under_review',
                    'approved',
                    'rejected',
                    'withdrawn',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $unit = Unit::findOrFail(
            $validated['unit_id']
        );

        if (
            $unit->id !== $application->unit_id &&
            (
                $unit->occupancy_status !== 'vacant' ||
                $unit->availability !== 'available'
            )
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'The selected unit is no longer available.'
                );
        }

        $application->update($validated);

        return redirect()
            ->route(
                'property-management.applications.show',
                $application
            )
            ->with(
                'success',
                'Tenant application updated successfully.'
            );
    }

    public function approve(
        TenantApplication $application
    ) {
        if ($application->status === 'approved') {
            return back()->with(
                'error',
                'This application is already approved.'
            );
        }

        if ($application->status === 'withdrawn') {
            return back()->with(
                'error',
                'A withdrawn application cannot be approved.'
            );
        }

        DB::transaction(function () use ($application) {

            $application->load('unit');

            $unit = $application->unit;

            if (
                $unit->occupancy_status !== 'vacant' ||
                $unit->availability !== 'available'
            ) {
                abort(
                    422,
                    'The selected unit is no longer available.'
                );
            }

            $application->update([
                'status' => 'approved',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'Tenant application approved successfully.'
        );
    }

    public function reject(
        Request $request,
        TenantApplication $application
    ) {
        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $application->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with(
            'success',
            'Tenant application rejected.'
        );
    }

    public function destroy(
        TenantApplication $application
    ) {
        if ($application->status === 'approved') {
            return back()->with(
                'error',
                'An approved application cannot be deleted.'
            );
        }

        $application->delete();

        return redirect()
            ->route('property-management.applications.index')
            ->with(
                'success',
                'Tenant application deleted successfully.'
            );
    }
}
