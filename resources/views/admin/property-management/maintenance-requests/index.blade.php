@extends('layouts.property-management.app')

@section('title', 'Maintenance Requests')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Maintenance requests</h1>
            <p class="text-muted mb-0">Track repairs, assignments, costs, and completion.</p>
        </div>

        <a href="{{ route('admin.property-management.maintenance-requests.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New request
        </a>
    </div>

    <div class="row g-3 mb-4">
        @foreach ([
            'open' => ['Open', 'bi-inbox'],
            'in_progress' => ['In progress', 'bi-tools'],
            'completed' => ['Completed', 'bi-check-circle'],
        ] as $key => $details)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-3 p-3 bg-light">
                            <i class="bi {{ $details[1] }} fs-4"></i>
                        </div>
                        <div>
                            <div class="text-muted small">{{ $details[0] }}</div>
                            <div class="h4 mb-0">
                                {{ \App\Models\MaintenanceRequest::where('status', $key)->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('admin.property-management.maintenance-requests.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Search</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               value="{{ request('search') }}"
                               placeholder="Request number, title, tenant...">
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Property</label>
                        <select name="property_id" class="form-select">
                            <option value="">All properties</option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->id }}"
                                    @selected(request('property_id') == $property->id)>
                                    {{ $property->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            @foreach (['open', 'in_progress', 'on_hold', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}"
                                    @selected(request('status') === $status)>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="">All priorities</option>
                            @foreach (['low', 'medium', 'high', 'urgent'] as $priority)
                                <option value="{{ $priority }}"
                                    @selected(request('priority') === $priority)>
                                    {{ ucfirst($priority) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-1 col-md-6">
                        <label class="form-label">From</label>
                        <input type="date" name="from" class="form-control"
                               value="{{ request('from') }}">
                    </div>

                    <div class="col-lg-1 col-md-6">
                        <label class="form-label">To</label>
                        <input type="date" name="to" class="form-control"
                               value="{{ request('to') }}">
                    </div>

                    <div class="col-lg-1 col-md-6 d-grid">
                        <button class="btn btn-primary" type="submit">
                            Filter
                        </button>
                    </div>
                </div>

                @if (request()->hasAny(['search', 'property_id', 'status', 'priority', 'from', 'to']))
                    <div class="mt-3">
                        <a href="{{ route('admin.property-management.maintenance-requests.index') }}"
                           class="small text-decoration-none">
                            Clear filters
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Request</th>
                        <th>Property / Unit</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Reported</th>
                        <th>Assigned to</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $maintenanceRequest)
                        <tr>
                            <td>
                                <a class="fw-semibold text-decoration-none"
                                   href="{{ route('admin.property-management.maintenance-requests.show', $maintenanceRequest) }}">
                                    {{ $maintenanceRequest->request_number }}
                                </a>
                                <div class="text-muted small">
                                    {{ \Illuminate\Support\Str::limit($maintenanceRequest->title, 45) }}
                                </div>
                            </td>

                            <td>
                                <div>{{ $maintenanceRequest->managedProperty?->name ?? '—' }}</div>
                                <div class="text-muted small">
                                    Unit: {{ $maintenanceRequest->unit?->unit_number ?? 'Property-wide' }}
                                </div>
                            </td>

                            <td>{{ ucfirst(str_replace('_', ' ', $maintenanceRequest->category)) }}</td>

                            <td>
                                @php
                                    $priorityClass = match ($maintenanceRequest->priority) {
                                        'urgent' => 'danger',
                                        'high' => 'warning',
                                        'medium' => 'primary',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge text-bg-{{ $priorityClass }}">
                                    {{ ucfirst($maintenanceRequest->priority) }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $statusClass = match ($maintenanceRequest->status) {
                                        'completed' => 'success',
                                        'in_progress' => 'primary',
                                        'on_hold' => 'warning',
                                        'cancelled' => 'secondary',
                                        default => 'info',
                                    };
                                @endphp
                                <span class="badge text-bg-{{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $maintenanceRequest->status)) }}
                                </span>
                            </td>

                            <td>
                                {{ $maintenanceRequest->requested_date?->format('d M Y') ?? '—' }}
                            </td>

                            <td>{{ $maintenanceRequest->assignee?->name ?? 'Unassigned' }}</td>

                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a class="btn btn-sm btn-light border"
                                       title="View"
                                       href="{{ route('admin.property-management.maintenance-requests.show', $maintenanceRequest) }}">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a class="btn btn-sm btn-light border"
                                       title="Edit"
                                       href="{{ route('admin.property-management.maintenance-requests.edit', $maintenanceRequest) }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.property-management.maintenance-requests.destroy', $maintenanceRequest) }}"
                                          onsubmit="return confirm('Delete this maintenance request? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-light border text-danger"
                                                title="Delete" type="submit">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-tools fs-2 text-muted"></i>
                                <p class="mt-2 mb-1 fw-semibold">No maintenance requests found</p>
                                <p class="text-muted small mb-3">
                                    Create a request or adjust your search filters.
                                </p>
                                <a href="{{ route('admin.property-management.maintenance-requests.create') }}"
                                   class="btn btn-primary btn-sm">
                                    Create request
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($requests->hasPages())
            <div class="card-footer bg-white">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection