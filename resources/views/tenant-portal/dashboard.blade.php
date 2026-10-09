@extends('layouts.property-management')

@section('title', 'Tenant Dashboard')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-wrap justify-content-between
                align-items-center gap-3 mb-4">
        <div>
            <span class="text-muted small">TERRA TENANT PORTAL</span>
            <h1 class="h3 fw-bold mb-1">
                Welcome, {{ $tenant->first_name ?? auth()->user()->name }}
            </h1>
            <p class="text-muted mb-0">
                Manage your rental, payments and maintenance requests.
            </p>
        </div>

        <a href="{{ route('tenant-portal.properties.index') }}"
           class="btn btn-terra">
            Browse Properties
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
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

    <div class="row g-3 mb-4">

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Available Units</div>
                    <div class="fs-2 fw-bold">
                        {{ $availableUnits }}
                    </div>
                    <a href="{{ route('tenant-portal.properties.index') }}"
                       class="small text-decoration-none">
                        Explore rentals
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Applications</div>
                    <div class="fs-2 fw-bold">
                        {{ $applications->count() }}
                    </div>
                    <span class="small text-muted">
                        Recent applications
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Leases</div>
                    <div class="fs-2 fw-bold">
                        {{ $leases->where('status', 'active')->count() }}
                    </div>
                    <a href="{{ route('tenant-portal.leases.index') }}"
                       class="small text-decoration-none">
                        View leases
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Outstanding Balance</div>
                    <div class="fs-4 fw-bold">
                        {{ number_format(
                            (float) $invoices->sum('balance'),
                            0
                        ) }} RWF
                    </div>
                    <a href="{{ route('tenant-portal.payments.index') }}"
                       class="small text-decoration-none">
                        Payment history
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 mb-0">Recent Applications</h2>
                </div>

                <div class="card-body">
                    @forelse($applications as $application)
                        <div class="d-flex justify-content-between
                                    align-items-start gap-3 py-3
                                    border-bottom">
                            <div>
                                <div class="fw-semibold">
                                    {{ $application->unit->floor
                                        ->building->property->title
                                        ?? 'Rental application' }}
                                </div>

                                <div class="text-muted small">
                                    Unit {{ $application->unit->unit_number }}
                                </div>
                            </div>

                            <span class="badge bg-light text-dark">
                                {{ ucfirst(str_replace(
                                    '_',
                                    ' ',
                                    $application->status
                                )) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            You have not submitted any applications yet.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 mb-0">Recent Payments</h2>
                </div>

                <div class="card-body">
                    @forelse($payments as $payment)
                        <div class="d-flex justify-content-between
                                    gap-3 py-3 border-bottom">
                            <div>
                                <div class="fw-semibold">
                                    {{ $payment->payment_number }}
                                </div>
                                <div class="text-muted small">
                                    {{ $payment->payment_date?->format('d M Y') }}
                                </div>
                            </div>

                            <div class="text-end">
                                <div class="fw-bold">
                                    {{ number_format(
                                        (float) $payment->amount,
                                        0
                                    ) }} {{ $payment->currency }}
                                </div>
                                <a class="small"
                                   href="{{ route(
                                       'tenant-portal.payments.receipt',
                                       $payment
                                   ) }}">
                                    View receipt
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            No confirmed payments to display.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <div class="row g-3 mt-2">
        <div class="col-12 col-md-4">
            <a href="{{ route('tenant-portal.profile.edit') }}"
               class="btn btn-outline-secondary w-100 py-3">
                Manage Profile
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="{{ route('tenant-portal.leases.index') }}"
               class="btn btn-outline-secondary w-100 py-3">
                View Lease Documents
            </a>
        </div>

        <div class="col-12 col-md-4">
            <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
               class="btn btn-outline-secondary w-100 py-3">
                Maintenance Requests
            </a>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .btn-terra {
        background: #D05208;
        color: #fff;
        border: 1px solid #D05208;
    }

    .btn-terra:hover,
    .btn-terra:focus {
        background: #ad4407;
        color: #fff;
    }
</style>
@endpush