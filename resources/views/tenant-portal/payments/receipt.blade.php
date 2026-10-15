@extends('layouts.tenant.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 no-print">
        <div>
            <a href="{{ route('tenant-portal.payments.index') }}"
               class="text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i>
                Back to payments
            </a>

            <h3 class="fw-bold mt-2 mb-1">Payment Receipt</h3>
            <p class="text-muted mb-0">
                Review or print your rent payment receipt.
            </p>
        </div>

        <button type="button"
                class="btn btn-primary"
                onclick="window.print()">
            <i class="bi bi-printer me-1"></i>
            Print receipt
        </button>
    </div>

    @php
        $lease = $payment->lease;
        $unit = $lease?->unit;
        $property = $unit?->managedProperty;

        $propertyName = $property?->name
            ?? $property?->title
            ?? 'Managed property';

        $currency = $payment->currency
            ?: $lease?->currency
            ?: 'RWF';
    @endphp

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">

            <div class="card border-0 shadow-sm receipt-card">
                <div class="card-body p-4 p-md-5">

                    {{-- Receipt heading --}}
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 border-bottom pb-4 mb-4">
                        <div>
                            <h4 class="fw-bold mb-1">TERRA</h4>
                            <p class="text-muted mb-0">
                                Real Estate & Property Management
                            </p>
                            <small class="text-muted">
                                Rent payment receipt
                            </small>
                        </div>

                        <div class="text-md-end">
                            <span class="badge bg-success fs-6">
                                <i class="bi bi-check-circle me-1"></i>
                                Payment completed
                            </span>

                            <div class="mt-2">
                                <small class="text-muted d-block">
                                    Receipt number
                                </small>
                                <strong>
                                    {{ $payment->receipt_number
                                        ?: 'Not assigned' }}
                                </strong>
                            </div>
                        </div>
                    </div>

                    {{-- Amount --}}
                    <div class="rounded-3 bg-light p-4 text-center mb-4">
                        <small class="text-muted d-block mb-2">
                            Amount received
                        </small>

                        <h2 class="fw-bold mb-1">
                            {{ number_format(
                                (float) $payment->amount,
                                2
                            ) }}
                            {{ $currency }}
                        </h2>

                        <p class="text-success mb-0">
                            <i class="bi bi-shield-check me-1"></i>
                            Recorded as completed
                        </p>
                    </div>

                    {{-- Payment information --}}
                    <h5 class="fw-bold mb-3">Payment information</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th class="table-light" style="width: 40%;">
                                        Payment date
                                    </th>
                                    <td>
                                        {{ $payment->payment_date
                                            ? $payment->payment_date->format('d F Y')
                                            : 'Not recorded' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="table-light">Payment method</th>
                                    <td>
                                        {{ ucwords(str_replace(
                                            '_',
                                            ' ',
                                            $payment->payment_method ?? 'Other'
                                        )) }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="table-light">
                                        Transaction reference
                                    </th>
                                    <td>
                                        {{ $payment->transaction_reference
                                            ?: 'Not provided' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="table-light">Payment type</th>
                                    <td>
                                        {{ $payment->payment_type
                                            ? ucwords(str_replace(
                                                '_',
                                                ' ',
                                                $payment->payment_type
                                            ))
                                            : 'Rent payment' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="table-light">Status</th>
                                    <td>
                                        <span class="badge bg-success">
                                            Completed
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Rental information --}}
                    <h5 class="fw-bold mt-4 mb-3">Rental information</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th class="table-light" style="width: 40%;">
                                        Property
                                    </th>
                                    <td>{{ $propertyName }}</td>
                                </tr>

                                <tr>
                                    <th class="table-light">Unit number</th>
                                    <td>{{ $unit?->unit_number ?? 'Not specified' }}</td>
                                </tr>

                                <tr>
                                    <th class="table-light">Lease number</th>
                                    <td>
                                        {{ $lease?->lease_number
                                            ?? 'Lease #' . $payment->lease_id }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="table-light">Payment period</th>
                                    <td>
                                        @if ($payment->period_start || $payment->period_end)
                                            {{ $payment->period_start?->format('d M Y')
                                                ?? 'Start not specified' }}
                                            &mdash;
                                            {{ $payment->period_end?->format('d M Y')
                                                ?? 'End not specified' }}
                                        @else
                                            Not specified
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Notes --}}
                    @if ($payment->notes)
                        <div class="mt-4">
                            <h6 class="fw-bold">Additional notes</h6>
                            <p class="text-muted mb-0"
                               style="white-space: pre-line;">{{ $payment->notes }}</p>
                        </div>
                    @endif

                    {{-- Footer --}}
                    <div class="border-top mt-4 pt-4 text-center">
                        <p class="fw-semibold mb-1">
                            Thank you for your payment.
                        </p>

                        <p class="small text-muted mb-0">
                            This receipt reflects the payment record stored
                            in Terra Real Estate. Please contact your property
                            manager if you notice any discrepancies.
                        </p>

                        <p class="small text-muted mt-3 mb-0">
                            Receipt generated on
                            {{ now()->format('d F Y, H:i') }}
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<style>
    @media print {
        .no-print,
        nav,
        aside,
        footer {
            display: none !important;
        }

        body {
            background: #fff !important;
        }

        .container-fluid {
            padding: 0 !important;
        }

        .receipt-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }

        .card-body {
            padding: 20px !important;
        }

        .table {
            font-size: 12px;
        }

        .badge {
            border: 1px solid #777;
            color: #000 !important;
            background: #fff !important;
        }
    }
</style>
@endsection
