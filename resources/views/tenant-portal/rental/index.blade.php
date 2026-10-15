@extends('layouts.tenant.app')

@section('title', 'My Rental')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">My Rental</h3>
            <p class="text-muted mb-0">
                Manage your rental and view your lease information.
            </p>
        </div>

        <a href="{{ route('tenant-portal.leases.index') }}"
           class="btn btn-outline-primary">
            <i class="bi bi-file-earmark-text me-1"></i>
            My Leases
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($activeLease)
        @php
            $unit = $activeLease->unit;
            $property = $unit?->managedProperty;
            $building = $unit?->building;
            $floor = $unit?->floor;

            $unitName = $unit?->getAttribute('unit_number')
                ?? $unit?->getAttribute('name')
                ?? ('Unit #' . ($unit?->id ?? 'N/A'));

            $propertyName = $property?->getAttribute('title')
                ?? $property?->getAttribute('name')
                ?? 'Managed property';

            $monthlyRent = $activeLease->getAttribute('monthly_rent')
                ?? $activeLease->getAttribute('rent_amount');

            $endDate = $activeLease->getAttribute('end_date');
        @endphp

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between
                            align-items-start gap-3 mb-4">

                    <div>
                        <span class="badge bg-success mb-2">
                            Active lease
                        </span>

                        <h4 class="fw-bold mb-1">
                            {{ $propertyName }}
                        </h4>

                        <p class="text-muted mb-0">
                            {{ $unitName }}
                        </p>
                    </div>

                    <a href="{{ route('tenant-portal.leases.index') }}"
                       class="btn btn-primary">
                        View lease details
                    </a>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 col-xl-3">
                        <div class="bg-light rounded p-3 h-100">
                            <small class="text-muted d-block mb-2">
                                Lease start
                            </small>
                            <strong>
                                {{ $activeLease->start_date
                                    ? \Carbon\Carbon::parse(
                                        $activeLease->start_date
                                    )->format('d M Y')
                                    : 'Not specified' }}
                            </strong>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="bg-light rounded p-3 h-100">
                            <small class="text-muted d-block mb-2">
                                Lease end
                            </small>
                            <strong>
                                {{ $endDate
                                    ? \Carbon\Carbon::parse($endDate)
                                        ->format('d M Y')
                                    : 'Not specified' }}
                            </strong>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="bg-light rounded p-3 h-100">
                            <small class="text-muted d-block mb-2">
                                Monthly rent
                            </small>
                            <strong>
                                {{ is_numeric($monthlyRent)
                                    ? number_format((float) $monthlyRent)
                                        . ' RWF'
                                    : 'Check lease agreement' }}
                            </strong>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="bg-light rounded p-3 h-100">
                            <small class="text-muted d-block mb-2">
                                Payments recorded
                            </small>
                            <strong>
                                {{ $activeLease->rentPayments->count() }}
                            </strong>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-semibold mb-3">
                    Rental location and unit
                </h5>

                <div class="row g-3">
                    <div class="col-md-4">
                        <span class="text-muted d-block small">
                            Property
                        </span>
                        {{ $propertyName }}
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted d-block small">
                            Building
                        </span>
                        {{ $building?->getAttribute('name')
                            ?? 'Not specified' }}
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted d-block small">
                            Floor
                        </span>
                        {{ $floor?->getAttribute('name')
                            ?? 'Not specified' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between
                            align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Recent payments</h5>

                    <a href="{{ route('tenant-portal.payments.index') }}"
                       class="text-decoration-none">
                        View all
                    </a>
                </div>

                @forelse (
                    $activeLease->rentPayments
                        ->sortByDesc('payment_date')
                        ->take(5) as $payment
                )
                    <div class="d-flex flex-wrap justify-content-between
                                align-items-center border-bottom py-3 gap-2">
                        <div>
                            <strong>
                                {{ $payment->getAttribute('payment_number')
                                    ?? 'Rent payment' }}
                            </strong>

                            <div class="text-muted small">
                                {{ $payment->payment_date
                                    ? \Carbon\Carbon::parse(
                                        $payment->payment_date
                                    )->format('d M Y')
                                    : 'Date not recorded' }}
                            </div>
                        </div>

                        <div class="text-end">
                            <strong>
                                {{ number_format(
                                    (float) $payment->amount
                                ) }} RWF
                            </strong>

                            <div>
                                <span class="badge
                                    {{ $payment->status === 'completed'
                                        ? 'bg-success'
                                        : 'bg-secondary' }}">
                                    {{ ucfirst($payment->status ?? 'pending') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">
                            No payments have been recorded for this lease.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-house-door fs-1 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    No active rental
                </h5>

                <p class="text-muted mb-4">
                    You do not currently have an active lease.
                    You can review your previous leases or explore available
                    rental units.
                </p>

                <a href="{{ route('tenant-portal.leases.index') }}"
                   class="btn btn-outline-primary me-2">
                    View my leases
                </a>

                <a href="{{ route('terra.properties.index') }}"
                   class="btn btn-primary">
                    Explore rentals
                </a>
            </div>
        </div>
    @endif

    @if ($leases->count() > 0)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Lease history</h5>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Unit</th>
                                <th>Start date</th>
                                <th>End date</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($leases as $lease)
                                <tr>
                                    <td>
                                        {{ $lease->unit?->getAttribute(
                                            'unit_number'
                                        ) ?? 'Unit #' . $lease->unit_id }}
                                    </td>

                                    <td>
                                        {{ $lease->start_date
                                            ? \Carbon\Carbon::parse(
                                                $lease->start_date
                                            )->format('d M Y')
                                            : '—' }}
                                    </td>

                                    <td>
                                        {{ $lease->getAttribute('end_date')
                                            ? \Carbon\Carbon::parse(
                                                $lease->end_date
                                            )->format('d M Y')
                                            : '—' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($lease->status) }}
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <a href="{{
                                            route(
                                                'tenant-portal.leases.show',
                                                $lease
                                            )
                                        }}"
                                           class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $leases->links() }}
            </div>
        </div>
    @endif

</div>
@endsection