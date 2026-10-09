@extends('layouts.property-management')

@section('title', 'Lease Details')

@section('content')
<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('tenant-portal.leases.index') }}"
           class="text-decoration-none text-muted">
            &larr; My Leases
        </a>

        <h1 class="h3 fw-bold mt-2 mb-1">Lease Details</h1>

        <p class="text-muted mb-0">
            Lease number: {{ $lease->lease_number }}
        </p>
    </div>

    @php
        $unit = $lease->unit;
        $property = $unit?->floor?->building?->property;

        $statusClasses = [
            'draft' => 'secondary',
            'pending_signature' => 'warning',
            'active' => 'success',
            'expired' => 'dark',
            'terminated' => 'danger',
            'cancelled' => 'danger',
        ];

        $statusClass = $statusClasses[$lease->status] ?? 'secondary';
    @endphp

    <div class="row g-4">

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Rental Agreement</h5>
                            <p class="text-muted mb-0">
                                {{ $property?->title ?? 'Property unavailable' }}
                            </p>
                        </div>

                        <span class="badge bg-{{ $statusClass }}">
                            {{ ucwords(str_replace('_', ' ', $lease->status)) }}
                        </span>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small">Lease Number</div>
                            <div class="fw-semibold">
                                {{ $lease->lease_number }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Unit Number</div>
                            <div class="fw-semibold">
                                {{ $unit?->unit_number ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Start Date</div>
                            <div class="fw-semibold">
                                {{ $lease->start_date?->format('d F Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">End Date</div>
                            <div class="fw-semibold">
                                {{ $lease->end_date?->format('d F Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Payment Frequency</div>
                            <div class="fw-semibold">
                                {{ ucwords(str_replace('_', ' ', $lease->payment_frequency)) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Signed At</div>
                            <div class="fw-semibold">
                                {{ $lease->signed_at?->format('d F Y, H:i') ?? 'Not signed yet' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Lease Terms</h5>

                    <div class="mb-4">
                        <div class="text-muted small mb-1">Terms and Conditions</div>
                        <div>
                            {!! nl2br(e($lease->terms ?: 'No terms have been provided.')) !!}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">Special Conditions</div>
                        <div>
                            {!! nl2br(e($lease->special_conditions ?: 'No special conditions have been provided.')) !!}
                        </div>
                    </div>

                    @if($lease->notes)
                        <hr>
                        <div class="text-muted small mb-1">Additional Notes</div>
                        <div>{!! nl2br(e($lease->notes)) !!}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Financial Summary</h5>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Monthly Rent</span>
                        <strong>
                            {{ number_format((float) $lease->monthly_rent, 0) }} RWF
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Security Deposit</span>
                        <strong>
                            {{ number_format((float) $lease->deposit_amount, 0) }} RWF
                        </strong>
                    </div>

                    <hr>

                    <div class="small text-muted">
                        For questions about your lease or payment terms,
                        contact your property manager.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection