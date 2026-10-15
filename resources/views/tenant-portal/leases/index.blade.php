@extends('layouts.tenant.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Page heading --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">My Leases</h3>
            <p class="text-muted mb-0">
                View and manage your current and previous rental agreements.
            </p>
        </div>

        <a href="{{ route('tenant-portal.dashboard') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Dashboard
        </a>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Summary --}}
    @php
        $activeCount = $leases->getCollection()
            ->where('status', 'active')
            ->count();
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-primary-subtle text-primary p-3">
                            <i class="bi bi-file-earmark-text fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">
                                Leases on this page
                            </p>
                            <h4 class="fw-bold mb-0">
                                {{ $leases->count() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-success-subtle text-success p-3">
                            <i class="bi bi-house-check fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">
                                Active leases on this page
                            </p>
                            <h4 class="fw-bold mb-0">
                                {{ $activeCount }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-info-subtle text-info p-3">
                            <i class="bi bi-calendar-check fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small">
                                Total leases
                            </p>
                            <h4 class="fw-bold mb-0">
                                {{ $leases->total() }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lease cards --}}
    @forelse ($leases as $lease)
        @php
            $unit = $lease->unit;
            $property = $unit?->managedProperty;

            $propertyName = $property?->getAttribute('name')
                ?? $property?->getAttribute('title')
                ?? 'Managed property';

            $unitNumber = $unit?->unit_number ?? 'N/A';

            $status = strtolower($lease->status ?? 'unknown');

            $statusClass = match ($status) {
                'active' => 'bg-success',
                'pending' => 'bg-warning text-dark',
                'expired' => 'bg-secondary',
                'terminated', 'cancelled' => 'bg-danger',
                default => 'bg-light text-dark border',
            };

            $rent = $lease->monthly_rent;
            $currency = $lease->currency ?: 'RWF';

            $leaseStart = $lease->start_date;
            $leaseEnd = $lease->end_date;
        @endphp

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center g-4">

                    {{-- Property and unit --}}
                    <div class="col-lg-5">
                        <div class="d-flex align-items-start gap-3">
                            <div class="rounded-3 bg-light p-3">
                                <i class="bi bi-house-door fs-3 text-primary"></i>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1">
                                    {{ $propertyName }}
                                </h5>

                                <p class="text-muted mb-2">
                                    Unit {{ $unitNumber }}
                                    @if ($unit?->unit_type)
                                        &middot; {{ ucwords(str_replace(
                                            '_',
                                            ' ',
                                            $unit->unit_type
                                        )) }}
                                    @endif
                                </p>

                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>

                                @if ($lease->lease_number)
                                    <div class="small text-muted mt-2">
                                        Lease No: {{ $lease->lease_number }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Lease dates --}}
                    <div class="col-sm-6 col-lg-2">
                        <small class="text-muted d-block mb-1">
                            Start date
                        </small>
                        <strong>
                            {{ $leaseStart?->format('d M Y') ?? 'Not specified' }}
                        </strong>

                        <small class="text-muted d-block mt-3 mb-1">
                            End date
                        </small>
                        <strong>
                            {{ $leaseEnd?->format('d M Y') ?? 'Not specified' }}
                        </strong>
                    </div>

                    {{-- Rent --}}
                    <div class="col-sm-6 col-lg-2">
                        <small class="text-muted d-block mb-1">
                            Monthly rent
                        </small>
                        <h5 class="fw-bold mb-1">
                            {{ number_format((float) $rent, 2) }}
                        </h5>
                        <span class="text-muted small">{{ $currency }}</span>

                        @if ($unit?->bedrooms !== null)
                            <div class="small text-muted mt-2">
                                {{ $unit->bedrooms }} bedroom(s)
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="col-lg-3">
                        <a href="{{ route('tenant-portal.leases.show', $lease) }}"
                           class="btn btn-primary w-100">
                            <i class="bi bi-eye me-1"></i>
                            View lease
                        </a>

                        <a href="{{ route('tenant-portal.payments.index') }}"
                           class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-wallet2 me-1"></i>
                            Rent payments
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="rounded-circle bg-light d-inline-flex p-4 mb-3">
                    <i class="bi bi-file-earmark-text fs-1 text-muted"></i>
                </div>

                <h5 class="fw-bold">No leases found</h5>

                <p class="text-muted mx-auto" style="max-width: 480px;">
                    Your rental agreements will appear here once a lease
                    has been created and linked to your tenant profile.
                </p>

                <a href="{{ route('tenant-portal.dashboard') }}"
                   class="btn btn-outline-primary">
                    Return to dashboard
                </a>
            </div>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if ($leases->hasPages())
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-4">
            <small class="text-muted">
                Showing {{ $leases->firstItem() }}–{{ $leases->lastItem() }}
                of {{ $leases->total() }} leases
            </small>

            {{ $leases->links() }}
        </div>
    @endif

</div>
@endsection
