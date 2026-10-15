<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MaintenanceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        $maintenanceRequests = MaintenanceRequest::query()
            ->where('tenant_id', $tenant->id)
            ->with([
                'unit',
                'managedProperty',
                'assignee',
            ])
            ->orderByDesc('requested_date')
            ->orderByDesc('id')
            ->paginate(10);

        return view('tenant-portal.maintenance-requests.index', [
            'tenant' => $tenant,
            'maintenanceRequests' => $maintenanceRequests,
        ]);
    }

    public function create(Request $request): View
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        $leases = $tenant->leases()
            ->where('status', 'active')
            ->with(['unit.managedProperty'])
            ->orderByDesc('start_date')
            ->get();

        // Only offer units with an active lease.
        $units = $leases
            ->pluck('unit')
            ->filter()
            ->unique('id')
            ->values();

        return view('tenant-portal.maintenance-requests.create', [
            'tenant' => $tenant,
            'units' => $units,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        $validated = $request->validate([
            'unit_id' => [
                'required',
                'integer',
                Rule::exists('units', 'id')->whereIn(
                    'id',
                    $tenant->leases()
                        ->where('status', 'active')
                        ->select('unit_id')
                ),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'category' => [
                'required',
                Rule::in([
                    'plumbing',
                    'electrical',
                    'structural',
                    'appliance',
                    'cleaning',
                    'pest_control',
                    'security',
                    'other',
                ]),
            ],
            'priority' => [
                'required',
                Rule::in(['low', 'medium', 'high', 'urgent']),
            ],
        ]);

        $unit = $tenant->leases()
            ->where('status', 'active')
            ->where('unit_id', $validated['unit_id'])
            ->with('unit.managedProperty')
            ->firstOrFail()
            ->unit;

        $maintenanceRequest = MaintenanceRequest::create([
            'managed_property_id' => $unit->managed_property_id,
            'unit_id' => $unit->id,
            'tenant_id' => $tenant->id,
            'requested_by' => $request->user()->id,
            'request_number' => $this->generateRequestNumber(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'status' => 'pending',
            'requested_date' => now()->toDateString(),
            'currency' => $unit->currency ?: 'RWF',
        ]);

        return redirect()
            ->route('tenant-portal.maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Your maintenance request has been submitted.');
    }

    public function show(
        Request $request,
        MaintenanceRequest $maintenanceRequest
    ): View {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403, 'Tenant profile not found.');

        // Prevent tenants from viewing other tenants' requests.
        abort_unless(
            (int) $maintenanceRequest->tenant_id === (int) $tenant->id,
            404
        );

        $maintenanceRequest->load([
            'unit',
            'managedProperty',
            'assignee',
            'activities',
        ]);

        return view('tenant-portal.maintenance-requests.show', [
            'tenant' => $tenant,
            'maintenanceRequest' => $maintenanceRequest,
        ]);
    }

    private function generateRequestNumber(): string
    {
        do {
            $number = 'MR-' . now()->format('Ymd') . '-'
                . Str::upper(Str::random(6));
        } while (
            MaintenanceRequest::where('request_number', $number)->exists()
        );

        return $number;
    }
}
