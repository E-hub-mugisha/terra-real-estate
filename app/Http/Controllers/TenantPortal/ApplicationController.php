<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $tenant = Tenant::where(
            'user_id',
            $request->user()->id
        )->firstOrFail();

        $applications = TenantApplication::with([
            'unit.floor.building.property',
        ])
            ->where('tenant_id', $tenant->id)
            ->latest('application_date')
            ->paginate(10);

        return view(
            'tenant-portal.applications.index',
            compact('applications')
        );
    }

    public function show(
        Request $request,
        TenantApplication $application
    ) {
        $tenant = Tenant::where(
            'user_id',
            $request->user()->id
        )->firstOrFail();

        abort_unless(
            $application->tenant_id === $tenant->id,
            404
        );

        $application->load([
            'unit.floor.building.property',
            'reviewer',
        ]);

        return view(
            'tenant-portal.applications.show',
            compact('application')
        );
    }
}