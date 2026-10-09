@extends('layouts.property-management')

@section('title', $maintenanceRequest->request_number)
@section('page-title', 'Maintenance Request Details')
@section('page-subtitle', $maintenanceRequest->request_number)

@section('content')

@php
    $statusClasses = [
        'pending' => 'warning',
        'approved' => 'primary',
        'in_progress' => 'info',
        'on_hold' => 'secondary',
        'completed' => 'success',
        'rejected' => 'danger',
    ];

    $statusClass = $statusClasses[$maintenanceRequest->status] ?? 'secondary';
@endphp

<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i>
            All Requests
        </a>

        <span class="badge bg-{{ $statusClass }} fs-6">
            {{ ucfirst(str_replace('_', ' ', $maintenanceRequest->status)) }}
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                        <div>
                            <div class="text-muted small">
                                Request Reference
                            </div>
                            <h5 class="fw-bold mb-0">
                                {{ $maintenanceRequest->request_number }}
                            </h5>
                        </div>

                        <div>
                            <div class="text-muted small">
                                Priority
                            </div>
                            <span class="badge
                                @if($maintenanceRequest->priority === 'urgent') bg-danger
                                @elseif($maintenanceRequest->priority === 'high') bg-warning text-dark
                                @else bg-light text-dark
                                @endif">
                                {{ ucfirst($maintenanceRequest->priority) }}
                            </span>
                        </div>
                    </div>

                    <h4 class="fw-bold">
                        {{ $maintenanceRequest->title }}
                    </h4>

                    <div class="text-muted small mb-4">
                        {{ ucfirst($maintenanceRequest->category) }}
                        · Submitted {{ $maintenanceRequest->created_at->format('d M Y, H:i') }}
                    </div>

                    <h6 class="fw-bold">Description</h6>

                    <p class="text-break" style="white-space: pre-line;">{{ $maintenanceRequest->description }}</p>

                    @if($maintenanceRequest->attachment_path)
                        <div class="border-top pt-4 mt-4">
                            <h6 class="fw-bold mb-3">Attached Photo</h6>

                            <a href="{{ asset('storage/' . $maintenanceRequest->attachment_path) }}"
                               target="_blank"
                               rel="noopener noreferrer">
                                <img src="{{ asset('storage/' . $maintenanceRequest->attachment_path) }}"
                                     alt="Maintenance issue"
                                     class="img-fluid rounded border"
                                     style="max-height: 360px;">
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            @if($maintenanceRequest->manager_notes)
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold">
                            <i class="bi bi-chat-left-text me-2"></i>
                            Property Manager Update
                        </h6>

                        <p class="mb-0" style="white-space: pre-line;">{{ $maintenanceRequest->manager_notes }}</p>
                    </div>
                </div>
            @endif

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Property Details</h6>

                    <div class="text-muted small">Property</div>
                    <div class="fw-semibold mb-3">
                        {{ $maintenanceRequest->unit->floor->building->property->title ?? 'Property' }}
                    </div>

                    <div class="text-muted small">Unit</div>
                    <div class="fw-semibold mb-3">
                        {{ $maintenanceRequest->unit->unit_number ?? $maintenanceRequest->unit_id }}
                    </div>

                    <div class="text-muted small">Preferred Access</div>
                    <div class="fw-semibold">
                        {{ $maintenanceRequest->preferred_access_at?->format('d M Y, H:i') ?? 'Not specified' }}
                    </div>

                    @if($maintenanceRequest->assignee)
                        <div class="text-muted small mt-3">Assigned To</div>
                        <div class="fw-semibold">
                            {{ $maintenanceRequest->assignee->name }}
                        </div>
                    @endif

                    @if($maintenanceRequest->completed_at)
                        <div class="text-muted small mt-3">Completed On</div>
                        <div class="fw-semibold">
                            {{ $maintenanceRequest->completed_at->format('d M Y, H:i') }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Request Progress</h6>

                    <div class="d-flex gap-3 mb-3">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <div>
                            <div class="fw-semibold">Submitted</div>
                            <div class="text-muted small">
                                {{ $maintenanceRequest->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <i class="bi
                            @if($maintenanceRequest->status === 'completed')
                                bi-check-circle-fill text-success
                            @elseif($maintenanceRequest->status === 'rejected')
                                bi-x-circle-fill text-danger
                            @else
                                bi-clock text-muted
                            @endif
                        "></i>

                        <div>
                            <div class="fw-semibold">
                                {{ ucfirst(str_replace('_', ' ', $maintenanceRequest->status)) }}
                            </div>
                            <div class="text-muted small">
                                @if($maintenanceRequest->status === 'pending')
                                    Waiting for property manager review.
                                @elseif($maintenanceRequest->status === 'approved')
                                    Approved for maintenance.
                                @elseif($maintenanceRequest->status === 'in_progress')
                                    The repair is in progress.
                                @elseif($maintenanceRequest->status === 'on_hold')
                                    The repair is temporarily on hold.
                                @elseif($maintenanceRequest->status === 'completed')
                                    The request has been marked completed.
                                @elseif($maintenanceRequest->status === 'rejected')
                                    The request was rejected.
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

@endsection