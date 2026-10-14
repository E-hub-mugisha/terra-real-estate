@extends('layouts.property-management.app')

@section('title', 'Maintenance Request Details')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.maintenance-requests.index') }}"
                class="small text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Maintenance requests
            </a>
            <h1 class="h3 mt-2 mb-1">{{ $maintenanceRequest->title }}</h1>
            <p class="text-muted mb-0">
                {{ $maintenanceRequest->request_number }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.property-management.maintenance-requests.edit', $maintenanceRequest) }}"
                class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit request
            </a>

            <form method="POST"
                action="{{ route('admin.property-management.maintenance-requests.destroy', $maintenanceRequest) }}"
                onsubmit="return confirm('Delete this maintenance request?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger" type="submit">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                        <div>
                            <div class="text-muted small">Status</div>
                            <span class="badge text-bg-primary mt-1">
                                {{ ucfirst(str_replace('_', ' ', $maintenanceRequest->status)) }}
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Priority</div>
                            <span class="badge text-bg-warning mt-1">
                                {{ ucfirst($maintenanceRequest->priority) }}
                            </span>
                        </div>
                        <div>
                            <div class="text-muted small">Category</div>
                            <div class="fw-semibold mt-1">
                                {{ ucfirst(str_replace('_', ' ', $maintenanceRequest->category)) }}
                            </div>
                        </div>
                    </div>

                    <h5>Description</h5>
                    <p class="mb-0" style="white-space: pre-line">{{ $maintenanceRequest->description }}</p>

                    @if ($maintenanceRequest->resolution_notes)
                    <hr class="my-4">
                    <h5>Resolution notes</h5>
                    <p class="mb-0" style="white-space: pre-line">{{ $maintenanceRequest->resolution_notes }}</p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4">Schedule and costs</h5>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-muted small">Date reported</div>
                            <div class="fw-semibold">
                                {{ $maintenanceRequest->requested_date?->format('d M Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small">Scheduled date</div>
                            <div class="fw-semibold">
                                {{ $maintenanceRequest->scheduled_date?->format('d M Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small">Completed date</div>
                            <div class="fw-semibold">
                                {{ $maintenanceRequest->completed_date?->format('d M Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small">Estimated cost</div>
                            <div class="fw-semibold">
                                {{ $maintenanceRequest->estimated_cost !== null
                                    ? $maintenanceRequest->currency . ' ' . number_format((float) $maintenanceRequest->estimated_cost, 2)
                                    : '—' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small">Actual cost</div>
                            <div class="fw-semibold">
                                {{ $maintenanceRequest->actual_cost !== null
                                    ? $maintenanceRequest->currency . ' ' . number_format((float) $maintenanceRequest->actual_cost, 2)
                                    : '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3">Property information</h5>

                    <div class="mb-3">
                        <div class="text-muted small">Managed property</div>
                        <div class="fw-semibold">
                            {{ $maintenanceRequest->managedProperty?->name ?? '—' }}
                        </div>
                        <div class="text-muted small">
                            {{ $maintenanceRequest->managedProperty?->property_code ?? '' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Unit</div>
                        <div class="fw-semibold">
                            {{ $maintenanceRequest->unit?->unit_number ?? 'Property-wide' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small">Reporting tenant</div>
                        <div class="fw-semibold">
                            @if ($maintenanceRequest->tenant)
                            {{ $maintenanceRequest->tenant->first_name }}
                            {{ $maintenanceRequest->tenant->last_name }}
                            @else
                            Not linked to a tenant
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-3">Assignment</h5>

                    <div class="mb-3">
                        <div class="text-muted small">Assigned to</div>
                        <div class="fw-semibold">
                            {{ $maintenanceRequest->assignee?->name ?? 'Unassigned' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small">Reported by</div>
                        <div class="fw-semibold">
                            {{ $maintenanceRequest->requester?->name ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>

            @php
            $allowedTransitions = [
            'open' => ['in_progress', 'on_hold', 'cancelled'],
            'in_progress' => ['on_hold', 'completed', 'cancelled'],
            'on_hold' => ['in_progress', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
            ];

            $nextStatuses = $allowedTransitions[$maintenanceRequest->status] ?? [];

            $statusLabels = [
            'open' => 'Open',
            'in_progress' => 'In Progress',
            'on_hold' => 'On Hold',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            ];
            @endphp

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Update Request Status</h5>
                </div>

                <div class="card-body">
                    <p class="text-muted small">
                        Current status:
                        <strong>{{ $statusLabels[$maintenanceRequest->status] ?? $maintenanceRequest->status }}</strong>
                    </p>

                    @if (count($nextStatuses))
                    <form
                        method="POST"
                        action="{{ route('admin.property-management.maintenance-requests.status', $maintenanceRequest) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="status" class="form-label">
                                Next status <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required>
                                <option value="">Select next status</option>

                                @foreach ($nextStatuses as $nextStatus)
                                <option
                                    value="{{ $nextStatus }}"
                                    @selected(old('status')===$nextStatus)>
                                    {{ $statusLabels[$nextStatus] ?? $nextStatus }}
                                </option>
                                @endforeach
                            </select>

                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">
                                Update notes
                            </label>

                            <textarea
                                name="notes"
                                id="notes"
                                rows="3"
                                maxlength="5000"
                                class="form-control @error('notes') is-invalid @enderror"
                                placeholder="Explain the progress, delay, or reason for cancellation...">{{ old('notes') }}</textarea>

                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="resolution_notes" class="form-label">
                                Resolution notes
                            </label>

                            <textarea
                                name="resolution_notes"
                                id="resolution_notes"
                                rows="3"
                                maxlength="5000"
                                class="form-control @error('resolution_notes') is-invalid @enderror"
                                placeholder="Describe the repair completed and its outcome...">{{ old('resolution_notes') }}</textarea>

                            @error('resolution_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="form-text">
                                Required when completing the request.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="actual_cost" class="form-label">
                                Actual cost (RWF or selected currency)
                            </label>

                            <input
                                type="number"
                                name="actual_cost"
                                id="actual_cost"
                                min="0"
                                step="0.01"
                                class="form-control @error('actual_cost') is-invalid @enderror"
                                value="{{ old('actual_cost', $maintenanceRequest->actual_cost) }}">

                            @error('actual_cost')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Status Update
                        </button>
                    </form>
                    @else
                    <div class="alert alert-light border mb-0">
                        This request is {{ $maintenanceRequest->status }} and cannot transition to another status.
                    </div>
                    @endif
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Request Activity History</h5>
                </div>

                <div class="card-body">
                    @forelse ($maintenanceRequest->activities as $activity)
                    <div class="d-flex gap-3 pb-4">
                        <div class="pt-1">
                            <span class="d-inline-flex align-items-center justify-content-center
                        rounded-circle border bg-light"
                                style="width: 38px; height: 38px;">
                                <i class="bi bi-arrow-left-right"></i>
                            </span>
                        </div>

                        <div class="flex-grow-1">
                            <div class="d-flex flex-wrap justify-content-between gap-2">
                                <strong>
                                    @if ($activity->from_status)
                                    {{ ucfirst(str_replace('_', ' ', $activity->from_status)) }}
                                    &rarr;
                                    @else
                                    Request created &rarr;
                                    @endif

                                    {{ ucfirst(str_replace('_', ' ', $activity->to_status)) }}
                                </strong>

                                <small class="text-muted">
                                    {{ $activity->created_at?->format('d M Y, H:i') }}
                                </small>
                            </div>

                            <div class="small text-muted mt-1">
                                By {{ $activity->user?->name ?? 'System / unavailable user' }}
                            </div>

                            @if ($activity->notes)
                            <p class="mb-0 mt-2">{{ $activity->notes }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-muted mb-0">
                        No activity has been recorded for this request yet.
                    </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection