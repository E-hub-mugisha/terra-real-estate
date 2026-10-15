@extends('layouts.tenant.app')

@section('content')
<div class="container-fluid py-4">

    @php
        $status = strtolower($maintenanceRequest->status ?? 'unknown');

        $statusClass = match ($status) {
            'pending' => 'bg-warning text-dark',
            'assigned', 'scheduled', 'in_progress' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled', 'rejected' => 'bg-danger',
            default => 'bg-secondary',
        };

        $priority = strtolower($maintenanceRequest->priority ?? 'medium');

        $priorityClass = match ($priority) {
            'urgent' => 'bg-danger',
            'high' => 'bg-warning text-dark',
            'low' => 'bg-light text-dark border',
            default => 'bg-info text-dark',
        };
    @endphp

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
               class="text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i>
                Back to maintenance requests
            </a>

            <h3 class="fw-bold mt-2 mb-1">
                {{ $maintenanceRequest->title }}
            </h3>

            <p class="text-muted mb-2">
                Request #{{ $maintenanceRequest->request_number }}
            </p>

            <span class="badge {{ $statusClass }}">
                {{ ucwords(str_replace('_', ' ', $status)) }}
            </span>
        </div>

        <span class="badge {{ $priorityClass }} fs-6">
            {{ ucfirst($priority) }} priority
        </span>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">

        <div class="col-lg-8">

            {{-- Description --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Problem description</h5>

                    <div style="white-space: pre-line;">{{ $maintenanceRequest->description }}</div>

                    <hr>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Category
                            </small>
                            <strong>
                                {{ ucwords(str_replace(
                                    '_',
                                    ' ',
                                    $maintenanceRequest->category ?? 'Other'
                                )) }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Date submitted
                            </small>
                            <strong>
                                {{ $maintenanceRequest->requested_date?->format('d M Y')
                                    ?? 'Not recorded' }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Scheduling and completion --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Maintenance progress</h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Assigned technician / staff
                            </small>
                            <strong>
                                {{ $maintenanceRequest->assignee?->name
                                    ?? 'Not yet assigned' }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Scheduled date
                            </small>
                            <strong>
                                {{ $maintenanceRequest->scheduled_date?->format('d M Y')
                                    ?? 'Not scheduled yet' }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Completion date
                            </small>
                            <strong>
                                {{ $maintenanceRequest->completed_date?->format('d M Y')
                                    ?? 'Not completed yet' }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Current status
                            </small>
                            <span class="badge {{ $statusClass }}">
                                {{ ucwords(str_replace('_', ' ', $status)) }}
                            </span>
                        </div>
                    </div>

                    @if ($maintenanceRequest->resolution_notes)
                        <hr>

                        <h6 class="fw-bold">Resolution notes</h6>
                        <div style="white-space: pre-line;">{{ $maintenanceRequest->resolution_notes }}</div>
                    @endif
                </div>
            </div>

            {{-- Activity history --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Activity history</h5>

                    @forelse ($maintenanceRequest->activities as $activity)
                        <div class="d-flex gap-3 pb-4">
                            <div>
                                <span class="d-inline-flex rounded-circle bg-light p-2">
                                    <i class="bi bi-clock-history text-primary"></i>
                                </span>
                            </div>

                            <div class="flex-grow-1 border-bottom pb-3">
                                <div class="d-flex flex-wrap justify-content-between gap-2">
                                    <strong>
                                        {{ $activity->user?->name ?? 'System update' }}
                                    </strong>

                                    <small class="text-muted">
                                        {{ $activity->created_at?->format('d M Y, H:i') }}
                                    </small>
                                </div>

                                @if ($activity->description ?? false)
                                    <p class="text-muted mb-0 mt-2">
                                        {{ $activity->description }}
                                    </p>
                                @elseif ($activity->notes ?? false)
                                    <p class="text-muted mb-0 mt-2">
                                        {{ $activity->notes }}
                                    </p>
                                @else
                                    <p class="text-muted small mb-0 mt-2">
                                        An activity was recorded for this request.
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            No activity updates have been recorded yet.
                            Check this page again for progress updates.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Rental details --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Rental details</h5>

                    <div class="mb-3">
                        <small class="text-muted d-block">Property</small>
                        <strong>
                            {{ $maintenanceRequest->managedProperty?->name
                                ?? $maintenanceRequest->managedProperty?->title
                                ?? 'Managed property' }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Unit</small>
                        <strong>
                            {{ $maintenanceRequest->unit?->unit_number
                                ?? 'Not specified' }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">Building</small>
                        <strong>
                            {{ $maintenanceRequest->unit?->building?->name
                                ?? 'Not specified' }}
                        </strong>
                    </div>

                    <div>
                        <small class="text-muted d-block">Floor</small>
                        <strong>
                            {{ $maintenanceRequest->unit?->floor?->name
                                ?? 'Not specified' }}
                        </strong>
                    </div>
                </div>
            </div>

            {{-- Costs are displayed for transparency, not editable by tenants --}}
            @if ($maintenanceRequest->estimated_cost !== null
                || $maintenanceRequest->actual_cost !== null)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Recorded costs</h5>

                        @if ($maintenanceRequest->estimated_cost !== null)
                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    Estimated cost
                                </small>
                                <strong>
                                    {{ number_format(
                                        (float) $maintenanceRequest->estimated_cost,
                                        2
                                    ) }}
                                    {{ $maintenanceRequest->currency ?: 'RWF' }}
                                </strong>
                            </div>
                        @endif

                        @if ($maintenanceRequest->actual_cost !== null)
                            <div>
                                <small class="text-muted d-block">
                                    Actual cost
                                </small>
                                <strong>
                                    {{ number_format(
                                        (float) $maintenanceRequest->actual_cost,
                                        2
                                    ) }}
                                    {{ $maintenanceRequest->currency ?: 'RWF' }}
                                </strong>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-2">Need further assistance?</h6>
                    <p class="text-muted small mb-0">
                        Contact your property manager if the issue worsens,
                        requires urgent attention, or the scheduling
                        information needs clarification.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
