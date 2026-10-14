@extends('layouts.property-management.app')

@section('title', 'Application Details')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.applications.index') }}"
               class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Back to Applications
            </a>

            <h1 class="h3 fw-bold mt-2 mb-1">
                {{ $application->application_number }}
            </h1>

            <p class="text-muted mb-0">
                Application for {{ $application->tenant->full_name ?? 'tenant' }}
            </p>
        </div>

        @if ($application->status === 'pending')
            <a href="{{ route('admin.property-management.applications.edit', $application) }}"
               class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Edit Application
            </a>
        @endif
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <h2 class="h5 fw-bold mb-0">Application Information</h2>

                        @php
                            $statusClass = match ($application->status) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'secondary',
                            };
                        @endphp

                        <span class="badge text-bg-{{ $statusClass }}">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Application Date</div>
                            <div class="fw-semibold">
                                {{ $application->application_date?->format('d M Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Desired Move-in Date</div>
                            <div class="fw-semibold">
                                {{ $application->desired_move_in_date?->format('d M Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Number of Occupants</div>
                            <div class="fw-semibold">{{ $application->number_of_occupants }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Employment Status</div>
                            <div class="fw-semibold">
                                {{ $application->employment_status
                                    ? ucwords(str_replace('_', ' ', $application->employment_status))
                                    : 'Not provided' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-muted small mb-1">Additional Information</div>
                            <div>{{ $application->additional_information ?: 'No additional information provided.' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Tenant</h2>

                    <div class="fw-semibold">
                        {{ $application->tenant->full_name ?? 'Tenant unavailable' }}
                    </div>

                    <div class="text-muted">
                        {{ $application->tenant->email ?? '' }}
                    </div>

                    <div class="text-muted">
                        {{ $application->tenant->phone ?? '' }}
                    </div>

                    @if ($application->tenant)
                        <a href="{{ route('admin.property-management.tenants.show', $application->tenant) }}"
                           class="btn btn-sm btn-outline-dark mt-3">
                            View Tenant Profile
                        </a>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Decision History</h2>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Reviewed By</div>
                        <div class="fw-semibold">
                            {{ $application->reviewer->name ?? 'Not reviewed' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Review Date</div>
                        <div>
                            {{ $application->reviewed_at?->format('d M Y, H:i') ?? '—' }}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">Decision Notes</div>
                        <div>{{ $application->decision_notes ?: 'No decision notes recorded.' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Unit Details</h2>

                    <div class="fw-semibold">
                        Unit {{ $application->unit->unit_number ?? '—' }}
                    </div>

                    <div class="text-muted mb-3">
                        {{ $application->unit->managedProperty->name ?? 'Property unavailable' }}
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Advertised Monthly Rent</div>
                        <div class="fw-semibold">
                            {{ $application->unit->currency ?? $application->currency }}
                            {{ number_format((float) ($application->unit->monthly_rent ?? 0), 2) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Applicant's Offered Rent</div>
                        <div class="h5 fw-bold mb-0">
                            {{ $application->currency }}
                            {{ number_format((float) $application->offered_monthly_rent, 2) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Current Unit Status</div>
                        <span class="badge text-bg-secondary">
                            {{ ucfirst($application->unit->status ?? 'unknown') }}
                        </span>
                    </div>

                    @if ($application->unit)
                        <a href="{{ route('admin.property-management.units.show', $application->unit) }}"
                           class="btn btn-sm btn-outline-dark">
                            View Unit
                        </a>
                    @endif
                </div>
            </div>

            @if ($application->status === 'pending')
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-2">Approve Application</h2>
                        <p class="small text-muted">
                            Approval will reserve the unit if it is still available.
                        </p>

                        <form action="{{ route('admin.property-management.applications.approve', $application) }}"
                              method="POST"
                              onsubmit="return confirm('Approve this application and reserve the unit?');">
                            @csrf

                            <label for="approval_notes" class="form-label">
                                Decision Notes
                            </label>

                            <textarea name="decision_notes" id="approval_notes"
                                      rows="3" maxlength="5000"
                                      class="form-control mb-3"
                                      placeholder="Optional approval notes">{{ old('decision_notes') }}</textarea>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-check-circle me-1"></i> Approve & Reserve Unit
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-2">Reject Application</h2>
                        <p class="small text-muted">
                            Record a reason for rejecting this application.
                        </p>

                        <form action="{{ route('admin.property-management.applications.reject', $application) }}"
                              method="POST"
                              onsubmit="return confirm('Reject this application?');">
                            @csrf

                            <label for="rejection_notes" class="form-label">
                                Reason <span class="text-danger">*</span>
                            </label>

                            <textarea name="decision_notes" id="rejection_notes"
                                      rows="3" maxlength="5000"
                                      class="form-control mb-3"
                                      required
                                      placeholder="Explain the reason for rejection">{{ old('decision_notes') }}</textarea>

                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle me-1"></i> Reject Application
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h6 fw-bold mb-2">Delete Application</h2>
                        <p class="small text-muted">
                            Only use this for pending or rejected applications that should not be retained.
                        </p>

                        <form action="{{ route('admin.property-management.applications.destroy', $application) }}"
                              method="POST"
                              onsubmit="return confirm('Permanently delete this application?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-secondary w-100">
                                Delete Application
                            </button>
                        </form>
                    </div>
                </div>
            @elseif ($application->status === 'rejected')
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h6 fw-bold mb-2">Delete Application</h2>
                        <p class="small text-muted">
                            This rejected application can be removed if your record-retention policy permits.
                        </p>

                        <form action="{{ route('admin.property-management.applications.destroy', $application) }}"
                              method="POST"
                              onsubmit="return confirm('Permanently delete this rejected application?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-danger w-100">
                                Delete Application
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection