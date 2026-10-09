<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\MaintenanceRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MaintenanceRequestController extends Controller
{
    private function getTenant(Request $request): Tenant
    {
        return Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();
    }

    private function activeLeases(Tenant $tenant)
    {
        return Lease::with([
            'unit.floor.building.property',
        ])
            ->where('tenant_id', $tenant->id)
            ->where('status', 'active')
            ->get();
    }

    public function index(Request $request)
    {
        $tenant = $this->getTenant($request);

        $requests = MaintenanceRequest::with([
            'unit.floor.building.property',
            'assignee',
        ])
            ->where('tenant_id', $tenant->id)
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => MaintenanceRequest::where('tenant_id', $tenant->id)->count(),

            'pending' => MaintenanceRequest::where('tenant_id', $tenant->id)
                ->where('status', 'pending')
                ->count(),

            'in_progress' => MaintenanceRequest::where('tenant_id', $tenant->id)
                ->where('status', 'in_progress')
                ->count(),

            'completed' => MaintenanceRequest::where('tenant_id', $tenant->id)
                ->where('status', 'completed')
                ->count(),
        ];

        return view('tenant-portal.maintenance-requests.index', compact(
            'tenant',
            'requests',
            'stats'
        ));
    }

    public function create(Request $request)
    {
        $tenant = $this->getTenant($request);
        $leases = $this->activeLeases($tenant);

        return view('tenant-portal.maintenance-requests.create', compact(
            'tenant',
            'leases'
        ));
    }

    public function store(Request $request)
    {
        $tenant = $this->getTenant($request);

        $validated = $request->validate([
            'lease_id' => [
                'required',
                'integer',
                Rule::exists('leases', 'id')->where(
                    fn ($query) => $query
                        ->where('tenant_id', $tenant->id)
                        ->where('status', 'active')
                ),
            ],
            'title' => ['required', 'string', 'max:150'],
            'category' => [
                'required',
                Rule::in([
                    'plumbing',
                    'electrical',
                    'appliance',
                    'structural',
                    'cleaning',
                    'internet',
                    'security',
                    'other',
                ]),
            ],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'priority' => [
                'required',
                Rule::in(['low', 'normal', 'high', 'urgent']),
            ],
            'preferred_access_at' => [
                'nullable',
                'date',
                'after:now',
            ],
            'attachment' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $lease = Lease::with('unit.floor.building.property')
            ->where('tenant_id', $tenant->id)
            ->where('status', 'active')
            ->findOrFail($validated['lease_id']);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('maintenance-requests', 'public');
        }

        $maintenanceRequest = MaintenanceRequest::create([
            'request_number' => $this->generateRequestNumber(),
            'tenant_id' => $tenant->id,
            'lease_id' => $lease->id,
            'unit_id' => $lease->unit_id,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'pending',
            'attachment_path' => $attachmentPath,
            'preferred_access_at' => $validated['preferred_access_at'] ?? null,
        ]);

        return redirect()
            ->route('tenant-portal.maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Your maintenance request has been submitted successfully.');
    }

    public function show(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $tenant = $this->getTenant($request);

        abort_unless(
            (int) $maintenanceRequest->tenant_id === (int) $tenant->id,
            403
        );

        $maintenanceRequest->load([
            'unit.floor.building.property',
            'assignee',
        ]);

        return view('tenant-portal.maintenance-requests.show', [
            'tenant' => $tenant,
            'maintenanceRequest' => $maintenanceRequest,
        ]);
    }

    private function generateRequestNumber(): string
    {
        do {
            $number = 'TRM-' . now()->format('Ymd') . '-' .
                strtoupper(Str::random(6));
        } while (
            MaintenanceRequest::where('request_number', $number)->exists()
        );

        return $number;
    }
}