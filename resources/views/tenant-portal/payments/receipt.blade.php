@extends('layouts.property-management')

@section('title', 'Payment Receipt')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('tenant-portal.payments.index') }}"
           class="text-decoration-none">
            &larr; Back to Payments
        </a>

        <button type="button"
                onclick="window.print()"
                class="btn btn-primary">
            Print Receipt
        </button>
    </div>

    <div class="card border-0 shadow-sm mx-auto" style="max-width: 800px;">
        <div class="card-body p-4 p-md-5">

            <div class="d-flex justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <h2 class="fw-bold mb-1">TERRA</h2>
                    <p class="text-muted mb-0">Rental Payment Receipt</p>
                </div>

                <div class="text-md-end">
                    <div class="text-muted small">Receipt Reference</div>
                    <h5 class="fw-bold">
                        {{ $payment->payment_number }}
                    </h5>
                </div>
            </div>

            <hr>

            <div class="row g-4 my-3">
                <div class="col-md-6">
                    <div class="text-muted small">Payment Date</div>
                    <div class="fw-semibold">
                        {{ $payment->payment_date?->format('d F Y') ?? '—' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Payment Status</div>
                    <span class="badge bg-success">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Payment Method</div>
                    <div class="fw-semibold">
                        {{ ucwords(str_replace('_', ' ', $payment->payment_method ?? '—')) }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Transaction Reference</div>
                    <div class="fw-semibold">
                        {{ $payment->transaction_id ?? '—' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Lease Number</div>
                    <div class="fw-semibold">
                        {{ $payment->lease?->lease_number ?? '—' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small">Unit</div>
                    <div class="fw-semibold">
                        {{ $payment->unit?->unit_number ?? '—' }}
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center py-3">
                <div>
                    <div class="text-muted small">Amount Received</div>
                    <h3 class="fw-bold mb-0">
                        {{ number_format((float) $payment->amount, 2) }}
                        {{ $payment->currency ?? 'RWF' }}
                    </h3>
                </div>
            </div>

            <hr>

            <p class="text-muted small mb-0">
                This receipt confirms that a payment has been recorded as completed
                in the Terra rental management system.
            </p>

        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }

    .card, .card * {
        visibility: visible;
    }

    .card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
    }

    button, a {
        display: none !important;
    }
}
</style>
@endsection