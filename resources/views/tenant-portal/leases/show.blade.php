@extends('layouts.tenant.app')

@section('content')
<div class="container-fluid py-4">

    @php
        $unit = $lease->unit;
        $property = $unit?->managedProperty;
        $building = $unit?->building;
        $floor = $unit?->floor;

        $propertyName = $property?->getAttribute('name')
            ?? $property?->getAttribute('title')
            ?? 'Managed property';

        $status = strtolower($lease->status ?? 'unknown');

        $statusClass = match ($status) {
            'active' => 'bg-success',
            'pending' => 'bg-warning text-dark',
            'expired' => 'bg-secondary',
            'terminated', 'cancelled' => 'bg-danger',
            default => 'bg-light text-dark border',
        };

        $currency = $lease->currency ?: 'RWF';

        $daysRemaining = $lease->end_date
            ? (int) now()->startOfDay()->diffInDays(
                $lease->end_date->copy()->startOfDay(),
                false
            )
            : null;

        $documentExists = filled($lease->document_path);
    @endphp

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('tenant-portal.leases.index') }}"
               class="text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i>
                Back to my leases
            </a>

            <h3 class="fw-bold mt-2 mb-1">Lease Agreement</h3>

            <p class="text-muted mb-2">
                {{ $lease->lease_number
                    ? 'Lease No: ' . $lease->lease_number
                    : 'Rental agreement details' }}
            </p>

            <span class="badge {{ $statusClass }}">
                {{ ucfirst($status) }}
            </span>
        </div>

        <a href="{{ route('tenant-portal.payments.index') }}"
           class="btn btn-primary">
            <i class="bi bi-wallet2 me-1"></i>
            View payments
        </a>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($status === 'active' && $daysRemaining !== null)
        @if ($daysRemaining < 0)
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                The scheduled lease end date has passed.
                Contact your property manager to confirm your tenancy status.
            </div>
        @elseif ($daysRemaining <= 60)
            <div class="alert alert-info">
                <i class="bi bi-calendar-event me-2"></i>
                @if ($daysRemaining === 0)
                    Your scheduled lease end date is today.
                @else
                    Your lease is scheduled to end in
                    {{ $daysRemaining }} day(s).
                @endif
                Contact your property manager about renewal if needed.
            </div>
        @endif
    @endif

    <div class="row g-4">

        {{-- Main content --}}
        <div class="col-lg-8">

            {{-- Property information --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-house-door me-2 text-primary"></i>
                        Rental property
                    </h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Property name
                            </small>
                            <strong>{{ $propertyName }}</strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Unit number
                            </small>
                            <strong>{{ $unit?->unit_number ?? 'Not specified' }}</strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Building
                            </small>
                            <strong>
                                {{ $building?->getAttribute('name')
                                    ?? 'Not specified' }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Floor
                            </small>
                            <strong>
                                {{ $floor?->getAttribute('name')
                                    ?? 'Not specified' }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Unit type
                            </small>
                            <strong>
                                {{ $unit?->unit_type
                                    ? ucwords(str_replace(
                                        '_',
                                        ' ',
                                        $unit->unit_type
                                    ))
                                    : 'Not specified' }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Floor area
                            </small>
                            <strong>
                                {{ $unit?->area_sqm !== null
                                    ? number_format(
                                        (float) $unit->area_sqm,
                                        2
                                    ) . ' m²'
                                    : 'Not specified' }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Bedrooms
                            </small>
                            <strong>{{ $unit?->bedrooms ?? 'Not specified' }}</strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Bathrooms
                            </small>
                            <strong>{{ $unit?->bathrooms ?? 'Not specified' }}</strong>
                        </div>
                    </div>

                    @if ($unit?->description)
                        <hr class="my-4">

                        <h6 class="fw-semibold">Unit description</h6>
                        <p class="text-muted mb-0">
                            {{ $unit->description }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Lease period --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-calendar-range me-2 text-primary"></i>
                        Lease period
                    </h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Start date
                            </small>
                            <h6 class="fw-bold">
                                {{ $lease->start_date?->format('d F Y')
                                    ?? 'Not specified' }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Scheduled end date
                            </small>
                            <h6 class="fw-bold">
                                {{ $lease->end_date?->format('d F Y')
                                    ?? 'Not specified' }}
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Lease status
                            </small>
                            <span class="badge {{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </div>

                        @if ($lease->terminated_at)
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">
                                    Termination date
                                </small>
                                <strong>
                                    {{ $lease->terminated_at->format('d F Y') }}
                                </strong>
                            </div>
                        @endif

                        @if ($lease->termination_reason)
                            <div class="col-12">
                                <small class="text-muted d-block mb-1">
                                    Termination reason
                                </small>
                                <p class="mb-0">
                                    {{ $lease->termination_reason }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Financial terms --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-cash-stack me-2 text-primary"></i>
                        Financial terms
                    </h5>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="rounded-3 bg-light p-3 h-100">
                                <small class="text-muted d-block mb-2">
                                    Monthly rent
                                </small>
                                <h4 class="fw-bold mb-0">
                                    {{ number_format(
                                        (float) $lease->monthly_rent,
                                        2
                                    ) }}
                                </h4>
                                <small class="text-muted">
                                    {{ $currency }}
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="rounded-3 bg-light p-3 h-100">
                                <small class="text-muted d-block mb-2">
                                    Security deposit
                                </small>
                                <h4 class="fw-bold mb-0">
                                    {{ number_format(
                                        (float) $lease->security_deposit,
                                        2
                                    ) }}
                                </h4>
                                <small class="text-muted">
                                    {{ $currency }}
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Rent due day
                            </small>
                            <strong>
                                {{ $lease->rent_due_day
                                    ? 'Day ' . $lease->rent_due_day
                                        . ' of each month'
                                    : 'Not specified' }}
                            </strong>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted d-block mb-1">
                                Payment frequency
                            </small>
                            <strong>
                                {{ $lease->payment_frequency
                                    ? ucwords(str_replace(
                                        '_',
                                        ' ',
                                        $lease->payment_frequency
                                    ))
                                    : 'Not specified' }}
                            </strong>
                        </div>
                    </div>

                    <div class="alert alert-light border mt-4 mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        This section shows the financial terms recorded
                        on your lease. Check your invoices and payment
                        history for the actual outstanding balance.
                    </div>
                </div>
            </div>

            {{-- Terms --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-file-text me-2 text-primary"></i>
                        Terms and conditions
                    </h5>

                    @if ($lease->terms)
                        <div class="text-body-secondary"
                             style="white-space: pre-line;">{{ $lease->terms }}</div>
                    @else
                        <p class="text-muted mb-0">
                            No additional terms and conditions have been
                            recorded for this lease.
                        </p>
                    @endif
                </div>
            </div>

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Agreement document --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-file-earmark-pdf me-2 text-primary"></i>
                        Lease document
                    </h5>

                    @if ($documentExists)
                        <p class="text-muted small">
                            A lease document is recorded for this agreement.
                        </p>

                        <div class="alert alert-light border mb-0">
                            <i class="bi bi-shield-lock me-2"></i>
                            Document access should use an authenticated
                            download route that verifies tenant ownership.
                        </div>
                    @else
                        <p class="text-muted mb-0">
                            No lease document has been uploaded for this
                            agreement yet. Contact your property manager
                            if you need a copy.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Payment actions --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Rental services</h5>

                    <a href="{{ route('tenant-portal.payments.index') }}"
                       class="btn btn-primary w-100 mb-2">
                        <i class="bi bi-wallet2 me-2"></i>
                        Payments and receipts
                    </a>

                    <a href="{{ route(
                        'tenant-portal.maintenance-requests.index'
                    ) }}"
                       class="btn btn-outline-primary w-100">
                        <i class="bi bi-tools me-2"></i>
                        Maintenance requests
                    </a>
                </div>
            </div>

            {{-- Lease metadata --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">Agreement information</h6>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Lease reference
                        </small>
                        <strong>
                            {{ $lease->lease_number ?? 'Not assigned' }}
                        </strong>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted d-block">
                            Created by
                        </small>
                        <strong>
                            {{ $lease->creator?->name ?? 'Not specified' }}
                        </strong>
                    </div>

                    <div>
                        <small class="text-muted d-block">
                            Record created
                        </small>
                        <strong>
                            {{ $lease->created_at?->format('d M Y')
                                ?? 'Not specified' }}
                        </strong>
                    </div>

                    <hr>

                    <p class="small text-muted mb-0">
                        For lease renewals, corrections, or questions about
                        the agreement, contact your property manager.
                        Changes must be authorized and recorded by the
                        appropriate property-management user.
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
