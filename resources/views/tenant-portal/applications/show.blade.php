@extends('layouts.tenant.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('tenant-portal.applications.index') }}"
               class="text-decoration-none">
                &larr; My Applications
            </a>

            <h3 class="fw-bold mt-3 mb-1">Application Details</h3>
            <p class="text-muted mb-0">
                {{ $application->application_number }}
            </p>
        </div>

        <span class="badge bg-secondary fs-6">
            {{ ucfirst(str_replace('_', ' ', $application->status)) }}
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Application Information</h5>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <small class="text-muted">Application Number</small>
                            <div class="fw-semibold">
                                {{ $application->application_number }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Application Date</small>
                            <div class="fw-semibold">
                                {{ $application->application_date?->format('d M Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Desired Move-in</small>
                            <div class="fw-semibold">
                                {{ $application->desired_move_in_date?->format('d M Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Occupants</small>
                            <div class="fw-semibold">
                                {{ $application->number_of_occupants }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Offered Monthly Rent</small>
                            <div class="fw-semibold">
                                {{ $application->currency }}
                                {{ number_format((float) $application->offered_monthly_rent, 2) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Employment Status</small>
                            <div class="fw-semibold">
                                {{ $application->employment_status ?: 'Not provided' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <small class="text-muted">Additional Information</small>
                            <p class="mb-0">
                                {{ $application->additional_information ?: 'None provided.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($application->reviewed_at || $application->decision_notes)
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">Review and Decision</h5>
                    </div>

                    <div class="card-body">
                        @if($application->reviewed_at)
                            <p>
                                <strong>Reviewed on:</strong>
                                {{ $application->reviewed_at->format('d M Y, H:i') }}
                            </p>
                        @endif

                        @if($application->reviewer)
                            <p>
                                <strong>Reviewed by:</strong>
                                {{ $application->reviewer->name }}
                            </p>
                        @endif

                        @if($application->decision_notes)
                            <p class="mb-0">
                                <strong>Decision Notes:</strong><br>
                                {{ $application->decision_notes }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Application Status</h5>
                </div>

                <div class="card-body">
                    <p>
                        Your application is currently
                        <strong>{{ str_replace('_', ' ', $application->status) }}</strong>.
                    </p>

                    @if($application->status === 'pending')
                        <p class="text-muted mb-0">
                            Your application has been submitted and is awaiting review.
                        </p>
                    @elseif($application->status === 'under_review')
                        <p class="text-muted mb-0">
                            The property management team is reviewing your application.
                        </p>
                    @elseif($application->status === 'approved')
                        <p class="text-muted mb-0">
                            Your application has been approved. Contact the property manager for the next steps.
                        </p>
                    @elseif($application->status === 'rejected')
                        <p class="text-muted mb-0">
                            Your application was not approved. Review any decision notes for further information.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection