@extends('layouts.property-management')

@section('title', 'Application Details')

@section('content')
@php
    $property = $application->unit?->floor?->building?->property;

    $statusClass = match($application->status) {
        'approved' => 'success',
        'rejected' => 'danger',
        'under_review' => 'info',
        'withdrawn' => 'secondary',
        default => 'warning',
    };
@endphp

<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('tenant-portal.applications.index') }}"
           class="text-decoration-none text-muted">
            &larr; Back to My Applications
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-lg-5">

            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
                <div>
                    <h1 class="h3 fw-bold mb-1">Application Details</h1>
                    <p class="text-muted mb-0">
                        Application #{{ $application->id }}
                    </p>
                </div>

                <span class="badge text-bg-{{ $statusClass }} fs-6">
                    {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                </span>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <h2 class="h6 text-muted">Property</h2>
                    <p class="fw-semibold">
                        {{ $property?->title ?? 'Property unavailable' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <h2 class="h6 text-muted">Unit</h2>
                    <p class="fw-semibold">
                        {{ $application->unit?->unit_number ?? 'N/A' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <h2 class="h6 text-muted">Application date</h2>
                    <p>
                        {{ $application->application_date?->format('d M Y') ?? 'N/A' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <h2 class="h6 text-muted">Preferred move-in date</h2>
                    <p>
                        {{ $application->preferred_move_in_date?->format('d M Y') ?? 'Not specified' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <h2 class="h6 text-muted">Offered monthly rent</h2>
                    <p>
                        {{ $application->offered_rent !== null
                            ? number_format((float) $application->offered_rent, 0) . ' RWF'
                            : 'Not specified' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <h2 class="h6 text-muted">Offered deposit</h2>
                    <p>
                        {{ $application->offered_deposit !== null
                            ? number_format((float) $application->offered_deposit, 0) . ' RWF'
                            : 'Not specified' }}
                    </p>
                </div>

                @if($application->notes)
                    <div class="col-12">
                        <h2 class="h6 text-muted">Your notes</h2>
                        <p class="mb-0">{{ $application->notes }}</p>
                    </div>
                @endif

                @if($application->status === 'rejected' && $application->rejection_reason)
                    <div class="col-12">
                        <div class="alert alert-danger mb-0">
                            <h2 class="h6 fw-bold">Reason for rejection</h2>
                            {{ $application->rejection_reason }}
                        </div>
                    </div>
                @endif

                @if($application->reviewed_at)
                    <div class="col-12">
                        <h2 class="h6 text-muted">Last reviewed</h2>
                        <p class="mb-0">
                            {{ $application->reviewed_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                @endif
            </div>

            @if(in_array($application->status, ['pending', 'under_review']))
                <div class="alert alert-info mt-4 mb-0">
                    Your application is being processed. The property manager will
                    update its status after reviewing it.
                </div>
            @elseif($application->status === 'approved')
                <div class="alert alert-success mt-4 mb-0">
                    Your application has been approved. Please follow the instructions
                    from the property manager regarding the lease.
                </div>
            @endif

        </div>
    </div>
</div>
@endsection