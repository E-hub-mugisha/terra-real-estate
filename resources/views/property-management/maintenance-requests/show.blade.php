@extends('layouts.property-management')

@section('title', 'Review ' . $maintenanceRequest->request_number)
@section('page-title', 'Review Maintenance Request')
@section('page-subtitle', $maintenanceRequest->request_number)

@section('content')

<div class="container-fluid px-0">

    <div class="mb-4">
        <a href="{{ route('property-management.maintenance-requests.index') }}"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Maintenance Requests
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        <div class="col-lg-7">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-3">
                        <span class="text-muted small">
                            {{ $maintenanceRequest->request_number }}
                        </span>

                        <span class="badge bg-light text-dark">
                            {{ ucfirst($maintenanceRequest->priority) }} priority
                        </span>
                    </div>

                    <h4 class="fw-bold">{{ $maintenanceRequest->title }}</h4>

                    <div class="text-muted small mb-4">
                        {{ ucfirst($maintenanceRequest->category) }}
                        · Submitted {{ $maintenanceRequest->created_at->format('d M Y, H:i') }}
                    </div>

                    <h6 class="fw-bold">Problem Description</h6>
                    <p style="white-space: pre-line;" class="text-break">
                        {{ $maintenanceRequest->description }}
                    </p>

                    @if($maintenanceRequest->attachment_path)
                        <hr>

                        <h6 class="fw-bold mb-3">Attached Photo</h6>

                        <a href="{{ asset('storage/' . $maintenanceRequest->attachment_path) }}"
                           target="_blank"
                           rel="noopener noreferrer">
                            <img src="{{ asset('storage/' . $maintenanceRequest->attachment_path) }}"
                                 alt="Reported maintenance issue"
                                 class="img-fluid rounded border"
                                 style="max-height: 350px;">
                        </a>
                    @endif

                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">Update Request</h5>

                    <form method="POST"
                          action="{{ route('property-management.maintenance-requests.update', $maintenanceRequest) }}">

                        @csrf
                        @method('PATCH')

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Status
                                </label>

                                <select name="status" class="form-select" required>
                                    @foreach([
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'in_progress' => 'In Progress',
                                        'on_hold' => 'On Hold',
                                        'completed' => 'Completed',
                                        'rejected' => 'Rejected',
                                    ] as $value => $label)
                                        <option value="{{ $value }}"
                                            @selected(old('status', $maintenanceRequest->status) === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Priority
                                </label>

                                <select name="priority" class="form-select" required>
                                    @foreach(['low', 'normal', 'high', 'urgent'] as $priority)
                                        <option value="{{ $priority }}"
                                            @selected(old('priority', $maintenanceRequest->priority) === $priority)>
                                            {{ ucfirst($priority) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Assign Technician
                                </label>

                                <select name="assigned_to" class="form-select">
                                    <option value="">Unassigned</option>

                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}"
                                            @selected((string) old('assigned_to', $maintenanceRequest->assigned_to) === (string) $technician->id)>
                                            {{ $technician->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="form-text">
                                    The available users depend on the technician access rules configured for your application.
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    Manager Notes
                                </label>

                                <textarea name="manager_notes"
                                          rows="4"
                                          maxlength="5000"
                                          class="form-control"
                                          placeholder="Add an update, repair details, or a reason for placing the request on hold or rejecting it...">{{ old('manager_notes', $maintenanceRequest->manager_notes) }}</textarea>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>
                                Save Changes
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

        <div class="col-lg-5">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">Tenant Information</h5>

                    <div class="fw-semibold">
                        {{ $maintenanceRequest->tenant->full_name
                            ?? trim(($maintenanceRequest->tenant->first_name ?? '') . ' ' .
                                    ($maintenanceRequest->tenant->last_name ?? ''))
                            ?: 'Tenant'
                        }}
                    </div>

                    @if($maintenanceRequest->tenant->phone)
                        <div class="text-muted mt-2">
                            <i class="bi bi-telephone me-2"></i>
                            {{ $maintenanceRequest->tenant->phone }}
                        </div>
                    @endif

                    @if($maintenanceRequest->tenant->email)
                        <div class="text-muted mt-2">
                            <i class="bi bi-envelope me-2"></i>
                            {{ $maintenanceRequest->tenant->email }}
                        </div>
                    @endif

                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">Property Information</h5>

                    <div class="text-muted small">Property</div>
                    <div class="fw-semibold mb-3">
                        {{ $maintenanceRequest->unit->floor->building->property->title ?? 'Property' }}
                    </div>

                    <div class="text-muted small">Unit</div>
                    <div class="fw-semibold mb-3">
                        {{ $maintenanceRequest->unit->unit_number ?? $maintenanceRequest->unit_id }}
                    </div>

                    <div class="text-muted small">Preferred Access</div>
                    <div class="fw-semibold mb-3">
                        {{ $maintenanceRequest->preferred_access_at?->format('d M Y, H:i') ?? 'Not specified' }}
                    </div>

                    <div class="text-muted small">Assigned Technician</div>
                    <div class="fw-semibold">
                        {{ $maintenanceRequest->assignee?->name ?? 'Not assigned' }}
                    </div>

                    @if($maintenanceRequest->completed_at)
                        <div class="text-muted small mt-3">Completed At</div>
                        <div class="fw-semibold">
                            {{ $maintenanceRequest->completed_at->format('d M Y, H:i') }}
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>

</div>

@endsection