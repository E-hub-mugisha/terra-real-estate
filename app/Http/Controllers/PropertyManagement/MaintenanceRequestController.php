<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaintenanceRequestController extends Controller
{
    private function requestsQuery()
    {
        return MaintenanceRequest::whereHas(
            'unit.floor.building.property',
            function ($query) {
                $query->where('user_id', auth()->id());
            }
        );
    }

    public function index(Request $request)
    {
        $query = $this->requestsQuery()->with([
            'tenant',
            'unit.floor.building.property',
            'assignee',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($builder) use ($search) {
                $builder->where('request_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $requests = $query->latest()->paginate(15)->withQueryString();

        $baseQuery = $this->requestsQuery();

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
        ];

        return view('property-management.maintenance-requests.index', compact(
            'requests',
            'stats'
        ));
    }

    public function show(MaintenanceRequest $maintenanceRequest)
    {
        $this->authorizeRequest($maintenanceRequest);

        $maintenanceRequest->load([
            'tenant',
            'lease',
            'unit.floor.building.property',
            'assignee',
        ]);

        // This is a basic user list for technician assignment.
        // Restrict this query further if your app has technician roles.
        $technicians = User::orderBy('name')->get(['id', 'name']);

        return view('property-management.maintenance-requests.show', compact(
            'maintenanceRequest',
            'technicians'
        ));
    }

    public function update(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $this->authorizeRequest($maintenanceRequest);

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'approved',
                    'in_progress',
                    'on_hold',
                    'completed',
                    'rejected',
                ]),
            ],
            'priority' => [
                'required',
                Rule::in(['low', 'normal', 'high', 'urgent']),
            ],
            'assigned_to' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],
            'manager_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $validated['completed_at'] = $validated['status'] === 'completed'
            ? ($maintenanceRequest->completed_at ?? now())
            : null;

        $maintenanceRequest->update($validated);

        return redirect()
            ->route('property-management.maintenance-requests.show', $maintenanceRequest)
            ->with('success', 'Maintenance request updated successfully.');
    }

    private function authorizeRequest(MaintenanceRequest $maintenanceRequest): void
    {
        abort_unless(
            $this->requestsQuery()
                ->whereKey($maintenanceRequest->id)
                ->exists(),
            403
        );
    }
}