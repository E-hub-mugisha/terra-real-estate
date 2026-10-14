<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\MaintenanceRequestActivity;
use App\Models\ManagedProperty;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MaintenanceRequestController extends Controller
{
    private const STATUSES = [
        'open',
        'in_progress',
        'on_hold',
        'completed',
        'cancelled',
    ];

    private const PRIORITIES = [
        'low',
        'medium',
        'high',
        'urgent',
    ];

    public function index(Request $request)
    {
        $query = MaintenanceRequest::with([
            'managedProperty',
            'unit',
            'tenant',
            'assignee',
        ])->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhereHas('managedProperty', function ($property) use ($search) {
                        $property->where('name', 'like', "%{$search}%")
                            ->orWhere('property_code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('unit', function ($unit) use ($search) {
                        $unit->where('unit_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('tenant', function ($tenant) use ($search) {
                        $tenant->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('property_id')) {
            $query->where('managed_property_id', $request->property_id);
        }

        if ($request->filled('from')) {
            $query->whereDate('requested_date', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('requested_date', '<=', $request->to);
        }

        $requests = $query->paginate(15)->withQueryString();

        $properties = ManagedProperty::orderBy('name')->get([
            'id',
            'name',
        ]);

        return view(
            'admin.property-management.maintenance-requests.index',
            compact('requests', 'properties')
        );
    }

    public function create()
    {
        $maintenanceRequest = new MaintenanceRequest([
            'requested_date' => now()->toDateString(),
            'priority' => 'medium',
            'status' => 'open',
            'currency' => 'RWF',
        ]);

        return view(
            'admin.property-management.maintenance-requests.create',
            $this->formData($maintenanceRequest)
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        $validated['status'] = 'open';
        $validated['requested_by'] = auth()->id();
        $validated['request_number'] = $this->generateRequestNumber();

        $maintenanceRequest = DB::transaction(function () use ($validated) {
            $maintenanceRequest = MaintenanceRequest::create($validated);

            MaintenanceRequestActivity::create([
                'maintenance_request_id' => $maintenanceRequest->id,
                'user_id' => auth()->id(),
                'from_status' => null,
                'to_status' => 'open',
                'notes' => 'Maintenance request created.',
            ]);

            return $maintenanceRequest;
        });

        return redirect()
            ->route(
                'admin.property-management.maintenance-requests.show',
                $maintenanceRequest
            )
            ->with('success', 'Maintenance request created successfully.');
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load([
            'managedProperty.owner.user',
            'unit',
            'tenant',
            'requester',
            'assignee',
            'activities.user',
        ]);

        return view(
            'admin.property-management.maintenance-requests.show',
            compact('maintenanceRequest')
        );
    }

    public function edit(MaintenanceRequest $maintenanceRequest)
    {
        return view(
            'admin.property-management.maintenance-requests.edit',
            $this->formData($maintenanceRequest)
        );
    }

    public function update(
        Request $request,
        MaintenanceRequest $maintenanceRequest
    ) {
        $validated = $this->validateRequest($request);

        // Status changes must go through updateStatus().
        $validated['status'] = $maintenanceRequest->status;

        $maintenanceRequest->update($validated);

        return redirect()
            ->route(
                'admin.property-management.maintenance-requests.show',
                $maintenanceRequest
            )
            ->with('success', 'Maintenance request updated successfully.');
    }

    public function destroy(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->delete();

        return redirect()
            ->route('admin.property-management.maintenance-requests.index')
            ->with('success', 'Maintenance request deleted successfully.');
    }

    private function formData(MaintenanceRequest $maintenanceRequest): array
    {
        return [
            'maintenanceRequest' => $maintenanceRequest,
            'properties' => ManagedProperty::orderBy('name')->get(),
            'units' => Unit::with('managedProperty')
                ->orderBy('unit_number')
                ->get(),
            'tenants' => Tenant::orderBy('first_name')
                ->orderBy('last_name')
                ->get(),
            'users' => User::orderBy('name')->get(),
            'statuses' => self::STATUSES,
            'priorities' => self::PRIORITIES,
        ];
    }

    private function validateRequest(Request $request): array
    {
        $validated = $request->validate([
            'managed_property_id' => [
                'required',
                'integer',
                'exists:managed_properties,id',
            ],
            'unit_id' => [
                'nullable',
                'integer',
                'exists:units,id',
            ],
            'tenant_id' => [
                'nullable',
                'integer',
                'exists:tenants,id',
            ],
            'assigned_to' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'category' => ['required', 'string', 'max:100'],
            'priority' => ['required', Rule::in(self::PRIORITIES)],
            'status' => ['required', Rule::in(self::STATUSES)],
            'requested_date' => ['required', 'date'],
            'scheduled_date' => ['nullable', 'date'],
            'completed_date' => ['nullable', 'date'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
            'actual_cost' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', Rule::in(['RWF', 'USD'])],
            'resolution_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        // Prevent a unit from being attached to the wrong managed property.
        if (!empty($validated['unit_id'])) {
            $unitBelongsToProperty = Unit::whereKey($validated['unit_id'])
                ->where('managed_property_id', $validated['managed_property_id'])
                ->exists();

            if (!$unitBelongsToProperty) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'unit_id' => 'The selected unit does not belong to this property.',
                ]);
            }
        }

        // If both a unit and tenant are selected, ensure the tenant is connected
        // to that unit through a lease or application only if your business rules
        // require it. This implementation intentionally allows general requests.

        if (
            !empty($validated['scheduled_date'])
            && $validated['scheduled_date'] < $validated['requested_date']
        ) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'scheduled_date' => 'The scheduled date cannot be before the requested date.',
            ]);
        }

        return $validated;
    }

    private function generateRequestNumber(): string
    {
        do {
            $number = 'MR-' . now()->format('Ymd') . '-'
                . strtoupper(\Illuminate\Support\Str::random(6));
        } while (MaintenanceRequest::where('request_number', $number)->exists());

        return $number;
    }

    public function updateStatus(
        Request $request,
        MaintenanceRequest $maintenanceRequest
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'open',
                    'in_progress',
                    'on_hold',
                    'completed',
                    'cancelled',
                ]),
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
            'resolution_notes' => ['nullable', 'string', 'max:5000'],
            'actual_cost' => ['nullable', 'numeric', 'min:0'],
        ]);

        $allowedTransitions = [
            'open' => [
                'in_progress',
                'on_hold',
                'cancelled',
            ],
            'in_progress' => [
                'on_hold',
                'completed',
                'cancelled',
            ],
            'on_hold' => [
                'in_progress',
                'cancelled',
            ],
            'completed' => [],
            'cancelled' => [],
        ];

        DB::transaction(function () use (
            $maintenanceRequest,
            $validated,
            $allowedTransitions
        ) {
            // Lock the record so simultaneous requests cannot overwrite
            // each other's status changes.
            $lockedRequest = MaintenanceRequest::query()
                ->lockForUpdate()
                ->findOrFail($maintenanceRequest->id);

            $oldStatus = $lockedRequest->status;
            $newStatus = $validated['status'];

            if (
                ! in_array(
                    $newStatus,
                    $allowedTransitions[$oldStatus] ?? [],
                    true
                )
            ) {
                throw ValidationException::withMessages([
                    'status' => "The request cannot transition from {$oldStatus} to {$newStatus}.",
                ]);
            }

            $notes = trim(
                $validated['resolution_notes']
                    ?? $validated['notes']
                    ?? ''
            );

            if ($newStatus === 'completed' && $notes === '') {
                throw ValidationException::withMessages([
                    'resolution_notes' => 'Resolution notes are required before completing a request.',
                ]);
            }

            $lockedRequest->status = $newStatus;

            if ($newStatus === 'completed') {
                $lockedRequest->completed_date = now()->toDateString();
            }

            if (array_key_exists('actual_cost', $validated)) {
                $lockedRequest->actual_cost = $validated['actual_cost'];
            }

            if ($newStatus === 'completed') {
                $lockedRequest->resolution_notes = $notes;
            } elseif ($notes !== '') {
                // Preserve the existing resolution notes when no new
                // notes are provided for an ordinary transition.
                $lockedRequest->resolution_notes = $notes;
            }

            $lockedRequest->save();

            MaintenanceRequestActivity::create([
                'maintenance_request_id' => $lockedRequest->id,
                'user_id' => auth()->id(),
                'from_status' => $oldStatus,
                'to_status' => $newStatus,
                'notes' => $notes !== '' ? $notes : null,
            ]);
        });

        return redirect()
            ->route(
                'admin.property-management.maintenance-requests.show',
                $maintenanceRequest
            )
            ->with('success', 'Maintenance request status updated successfully.');
    }
}
