@extends('layouts.tenant.app')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Rent Payments</h3>
            <p class="text-muted mb-0">
                Review your payment history and access completed receipts.
            </p>
        </div>

        <a href="{{ route('tenant-portal.leases.index') }}"
           class="btn btn-outline-primary">
            <i class="bi bi-file-earmark-text me-1"></i>
            My Leases
        </a>
    </div>

    {{-- Summary cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Confirmed payments</small>
                            <h4 class="fw-bold mt-2 mb-0">
                                {{ number_format((float) $totalPaid, 2) }}
                            </h4>
                            <small class="text-muted">Across all leases</small>
                        </div>
                        <div class="rounded-3 bg-success-subtle text-success p-3">
                            <i class="bi bi-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Pending payments</small>
                            <h4 class="fw-bold mt-2 mb-0">
                                {{ number_format((float) $pendingAmount, 2) }}
                            </h4>
                            <small class="text-muted">Not yet confirmed</small>
                        </div>
                        <div class="rounded-3 bg-warning-subtle text-warning p-3">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Active leases</small>
                            <h4 class="fw-bold mt-2 mb-0">
                                {{ $activeLeases->count() }}
                            </h4>
                            <small class="text-muted">Current agreements</small>
                        </div>
                        <div class="rounded-3 bg-primary-subtle text-primary p-3">
                            <i class="bi bi-house-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Active lease rent overview --}}
    @if ($activeLeases->isNotEmpty())
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Your current rentals</h5>

                <div class="row g-3">
                    @foreach ($activeLeases as $lease)
                        <div class="col-md-6 col-xl-4">
                            <div class="border rounded-3 p-3 h-100">
                                <div class="d-flex justify-content-between gap-2">
                                    <div>
                                        <h6 class="fw-bold mb-1">
                                            {{ $lease->unit?->managedProperty?->name
                                                ?? $lease->unit?->managedProperty?->title
                                                ?? 'Managed property' }}
                                        </h6>
                                        <small class="text-muted">
                                            Unit {{ $lease->unit?->unit_number ?? 'N/A' }}
                                        </small>
                                    </div>
                                    <span class="badge bg-success align-self-start">
                                        Active
                                    </span>
                                </div>

                                <h5 class="fw-bold mt-3 mb-1">
                                    {{ number_format((float) $lease->monthly_rent, 2) }}
                                    {{ $lease->currency ?: 'RWF' }}
                                </h5>

                                <small class="text-muted">Monthly rent</small>

                                <div class="mt-3">
                                    <a href="{{ route(
                                        'tenant-portal.leases.show',
                                        $lease
                                    ) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View lease
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Payment table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="p-4 border-bottom">
                <h5 class="fw-bold mb-1">Payment history</h5>
                <p class="text-muted small mb-0">
                    Receipts are available for completed payments only.
                </p>
            </div>

            @if ($payments->isEmpty())
                <div class="text-center py-5 px-3">
                    <i class="bi bi-wallet2 fs-1 text-muted"></i>
                    <h5 class="fw-bold mt-3">No payments recorded</h5>
                    <p class="text-muted mb-0">
                        Payments recorded against your rental leases
                        will appear here.
                    </p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Receipt / Reference</th>
                                <th>Property / Lease</th>
                                <th>Payment date</th>
                                <th>Method</th>
                                <th class="text-end">Amount</th>
                                <th>Status</th>
                                <th class="text-end px-4">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($payments as $payment)
                                @php
                                    $status = strtolower(
                                        $payment->status ?? 'unknown'
                                    );

                                    $statusClass = match ($status) {
                                        'completed' => 'bg-success',
                                        'pending' => 'bg-warning text-dark',
                                        'failed', 'cancelled' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };

                                    $lease = $payment->lease;
                                    $property = $lease?->unit?->managedProperty;
                                @endphp

                                <tr>
                                    <td class="px-4">
                                        <strong>
                                            {{ $payment->receipt_number
                                                ?? 'Not issued' }}
                                        </strong>

                                        @if ($payment->transaction_reference)
                                            <div class="small text-muted">
                                                Ref:
                                                {{ $payment->transaction_reference }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div>
                                            {{ $property?->name
                                                ?? $property?->title
                                                ?? 'Managed property' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $lease?->lease_number
                                                ?? 'Lease #' . $payment->lease_id }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ $payment->payment_date
                                            ? $payment->payment_date->format('d M Y')
                                            : 'Not recorded' }}
                                    </td>

                                    <td>
                                        {{ ucwords(str_replace(
                                            '_',
                                            ' ',
                                            $payment->payment_method ?? 'Other'
                                        )) }}
                                    </td>

                                    <td class="text-end text-nowrap">
                                        <strong>
                                            {{ number_format(
                                                (float) $payment->amount,
                                                2
                                            ) }}
                                        </strong>
                                        <div class="small text-muted">
                                            {{ $payment->currency ?: 'RWF' }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    <td class="text-end px-4">
                                        @if ($status === 'completed')
                                            <a href="{{ route(
                                                'tenant-portal.payments.receipt',
                                                $payment
                                            ) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-receipt me-1"></i>
                                                Receipt
                                            </a>
                                        @else
                                            <span class="text-muted small">
                                                Unavailable
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
