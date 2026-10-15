@extends('layouts.tenant.app')

@section('title', 'Dashboard')
@section('header-title', 'My Dashboard')

@section('content')

@php
    $completedPayments = $rentPayments->where('status', 'completed');
    $totalPaid = $completedPayments->sum('amount');
    $pendingApplications = $applications->where('status', 'pending')->count();
    $openMaintenance = $maintenanceRequests
        ->whereIn('status', ['open', 'in_progress', 'on_hold'])
        ->count();
@endphp

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h4 class="tenant-page-title mb-1">
            Welcome, {{ $tenant->first_name }}!
        </h4>
        <p class="text-secondary mb-0">
            Here's an overview of your rental account.
        </p>
    </div>

    <a href="{{ route('tenant-portal.maintenance-requests.create') }}"
       class="btn btn-terra">
        <i class="bi bi-plus-lg me-1"></i>
        Report a maintenance issue
    </a>
</div>

{{-- Summary cards --}}
<div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="tenant-card p-3 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small mb-2">Current rental</div>
                    <h5 class="fw-bold mb-1">
                        {{ $activeLease?->unit?->unit_number ?? 'Not assigned' }}
                    </h5>
                    <small class="text-secondary">
                        {{ $activeLease?->unit?->managedProperty?->name ?? 'No active lease' }}
                    </small>
                </div>
                <i class="bi bi-house-door fs-3 text-terra"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="tenant-card p-3 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small mb-2">Monthly rent</div>
                    <h5 class="fw-bold mb-1">
                        @if ($activeLease)
                            {{ $activeLease->currency }}
                            {{ number_format((float) $activeLease->monthly_rent, 0) }}
                        @else
                            —
                        @endif
                    </h5>
                    <small class="text-secondary">Current lease</small>
                </div>
                <i class="bi bi-wallet2 fs-3 text-terra"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="tenant-card p-3 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small mb-2">Payments recorded</div>
                    <h5 class="fw-bold mb-1">
                        {{ $completedPayments->count() }}
                    </h5>
                    <small class="text-secondary">Completed payments</small>
                </div>
                <i class="bi bi-receipt fs-3 text-terra"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="tenant-card p-3 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-secondary small mb-2">Open maintenance</div>
                    <h5 class="fw-bold mb-1">{{ $openMaintenance }}</h5>
                    <small class="text-secondary">Requests needing attention</small>
                </div>
                <i class="bi bi-tools fs-3 text-terra"></i>
            </div>
        </div>
    </div>

</div>

{{-- Current lease --}}
<div class="tenant-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">My current lease</h5>

        <a href="{{ route('tenant-portal.leases.index') }}"
           class="text-terra text-decoration-none small fw-semibold">
            View leases <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    @if ($activeLease)
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <div class="text-secondary small mb-1">Property</div>
                <div class="fw-semibold">
                    {{ $activeLease->unit?->managedProperty?->name ?? '—' }}
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="text-secondary small mb-1">Unit</div>
                <div class="fw-semibold">
                    {{ $activeLease->unit?->unit_number ?? '—' }}
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="text-secondary small mb-1">Lease status</div>
                <span class="badge text-bg-success">
                    {{ ucfirst($activeLease->status) }}
                </span>
            </div>

            <div class="col-6 col-md-3">
                <div class="text-secondary small mb-1">Start date</div>
                <div>
                    {{ $activeLease->start_date?->format('d M Y') ?? '—' }}
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="text-secondary small mb-1">End date</div>
                <div>
                    {{ $activeLease->end_date?->format('d M Y') ?? '—' }}
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="text-secondary small mb-1">Rent due day</div>
                <div>
                    {{ $activeLease->rent_due_day
                        ? 'Day ' . $activeLease->rent_due_day
                        : 'Not specified' }}
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="text-secondary small mb-1">Payment frequency</div>
                <div>{{ ucfirst($activeLease->payment_frequency ?? 'monthly') }}</div>
            </div>
        </div>
    @else
        <div class="text-center py-4">
            <i class="bi bi-house fs-1 text-secondary"></i>
            <p class="fw-semibold mt-2 mb-1">No active lease found</p>
            <p class="text-secondary small mb-0">
                Your rental information will appear here once an active lease is assigned.
            </p>
        </div>
    @endif
</div>

<div class="row g-4">

    {{-- Recent payments --}}
    <div class="col-12 col-xl-7">
        <div class="tenant-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Recent payments</h5>

                <a href="{{ route('tenant-portal.payments.index') }}"
                   class="text-terra text-decoration-none small fw-semibold">
                    View all
                </a>
            </div>

            @forelse ($rentPayments->sortByDesc('payment_date')->take(5) as $payment)
                <div class="d-flex justify-content-between align-items-center gap-3 py-3 border-bottom">
                    <div>
                        <div class="fw-semibold">
                            {{ $payment->receipt_number }}
                        </div>
                        <small class="text-secondary">
                            {{ $payment->payment_date?->format('d M Y') ?? 'Date unavailable' }}
                            · {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                        </small>
                    </div>

                    <div class="text-end">
                        <div class="fw-semibold">
                            {{ $payment->currency }}
                            {{ number_format((float) $payment->amount, 0) }}
                        </div>

                        @if ($payment->status === 'completed')
                            <span class="badge text-bg-success">Completed</span>
                        @elseif ($payment->status === 'pending')
                            <span class="badge text-bg-warning">Pending</span>
                        @else
                            <span class="badge text-bg-secondary">
                                {{ ucfirst($payment->status) }}
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-secondary py-3 mb-0">
                    No payment records are available yet.
                </p>
            @endforelse
        </div>
    </div>

    {{-- Applications --}}
    <div class="col-12 col-xl-5">
        <div class="tenant-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Recent applications</h5>

                <a href="{{ route('tenant-portal.applications.index') }}"
                   class="text-terra text-decoration-none small fw-semibold">
                    View all
                </a>
            </div>

            @forelse ($applications as $application)
                <div class="py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <div class="fw-semibold">
                                {{ $application->application_number }}
                            </div>
                            <small class="text-secondary">
                                {{ $application->unit?->managedProperty?->name ?? 'Property' }}
                                · Unit {{ $application->unit?->unit_number ?? '—' }}
                            </small>
                        </div>

                        <span class="badge
                            @if ($application->status === 'approved') text-bg-success
                            @elseif ($application->status === 'rejected') text-bg-danger
                            @elseif ($application->status === 'pending') text-bg-warning
                            @else text-bg-secondary
                            @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                    </div>

                    <a href="{{ route('tenant-portal.applications.show', $application) }}"
                       class="small text-terra text-decoration-none">
                        View application
                    </a>
                </div>
            @empty
                <p class="text-secondary py-3 mb-0">
                    You have no property applications yet.
                </p>
            @endforelse
        </div>
    </div>

    {{-- Maintenance --}}
    <div class="col-12">
        <div class="tenant-card p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                <h5 class="fw-bold mb-0">Recent maintenance requests</h5>

                <a href="{{ route('tenant-portal.maintenance-requests.index') }}"
                   class="text-terra text-decoration-none small fw-semibold">
                    View all requests
                </a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Request</th>
                            <th>Issue</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($maintenanceRequests as $request)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $request->request_number }}
                                </td>
                                <td>{{ $request->title }}</td>
                                <td>{{ ucfirst($request->priority) }}</td>
                                <td>
                                    <span class="badge
                                        @if ($request->status === 'completed') text-bg-success
                                        @elseif ($request->status === 'cancelled') text-bg-secondary
                                        @elseif ($request->status === 'in_progress') text-bg-primary
                                        @else text-bg-warning
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $request->requested_date?->format('d M Y') ?? '—' }}
                                </td>
                                <td>
                                    <a href="{{ route('tenant-portal.maintenance-requests.show', $request) }}"
                                       class="btn btn-sm btn-outline-secondary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">
                                    No maintenance requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection