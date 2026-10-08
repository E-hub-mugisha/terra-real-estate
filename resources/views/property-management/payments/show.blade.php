@extends('layouts.property-management')

@section('title', 'Payment ' . $payment->payment_number)

@section('page-title', 'Payment Details')

@section('page-subtitle', $payment->payment_number)

@section('content')

<div class="d-flex justify-content-end mb-4">

    <button type="button"
            onclick="window.print()"
            class="btn btn-outline-secondary">

        <i class="bi bi-printer me-1"></i>
        Print Receipt

    </button>

</div>

<div class="card border-0 shadow-sm receipt-card">

    <div class="card-body p-5">

        <div class="row mb-5">

            <div class="col-md-7">

                <h2 class="fw-bold mb-1"
                    style="color:#D05208;">
                    TERRA
                </h2>

                <div class="text-muted">
                    Property Management
                </div>

            </div>

            <div class="col-md-5 text-md-end mt-4 mt-md-0">

                <div class="text-muted">
                    PAYMENT RECEIPT
                </div>

                <div class="fs-4 fw-bold">
                    {{ $payment->payment_number }}
                </div>

            </div>

        </div>

        <div class="row g-4 mb-5">

            <div class="col-md-6">

                <div class="text-muted small mb-1">
                    Tenant
                </div>

                <div class="fw-semibold">

                    {{ $payment->tenant->full_name
                        ?? trim(
                            ($payment->tenant->first_name ?? '') .
                            ' ' .
                            ($payment->tenant->last_name ?? '')
                        )
                    }}

                </div>

                @if($payment->tenant->phone)

                    <div class="text-muted">
                        {{ $payment->tenant->phone }}
                    </div>

                @endif

                @if($payment->tenant->email)

                    <div class="text-muted">
                        {{ $payment->tenant->email }}
                    </div>

                @endif

            </div>

            <div class="col-md-6">

                <div class="text-muted small mb-1">
                    Payment Date
                </div>

                <div class="fw-semibold">
                    {{ $payment->payment_date?->format('d M Y') }}
                </div>

                <div class="text-muted mt-2">
                    Method:
                    {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                </div>

                @if($payment->transaction_id)

                    <div class="text-muted">
                        Reference:
                        {{ $payment->transaction_id }}
                    </div>

                @endif

            </div>

        </div>


        <div class="table-responsive mb-4">

            <table class="table">

                <thead>

                    <tr>

                        <th>
                            Invoice
                        </th>

                        <th>
                            Description
                        </th>

                        <th class="text-end">
                            Amount
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($payment->allocations as $allocation)

                        <tr>

                            <td>
                                {{ $allocation->invoice->invoice_number }}
                            </td>

                            <td>

                                {{ $allocation->invoice->description
                                    ?: ucfirst(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $allocation->invoice->invoice_type
                                        )
                                    )
                                }}

                            </td>

                            <td class="text-end">

                                {{ number_format(
                                    $allocation->amount,
                                    0
                                ) }}
                                RWF

                            </td>

                        </tr>

                    @endforeach

                </tbody>

                <tfoot>

                    <tr>

                        <th colspan="2"
                            class="text-end">

                            Total Paid

                        </th>

                        <th class="text-end fs-5">

                            {{ number_format(
                                $payment->amount,
                                0
                            ) }}
                            RWF

                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>


        @if($payment->unallocated_amount > 0)

            <div class="alert alert-warning">

                Unallocated amount:

                <strong>
                    {{ number_format(
                        $payment->unallocated_amount,
                        0
                    ) }}
                    RWF
                </strong>

            </div>

        @endif


        <div class="row mt-5">

            <div class="col-md-6">

                <div class="text-muted small">
                    Received By
                </div>

                <div>
                    {{ $payment->recorder->name ?? 'System' }}
                </div>

            </div>

            <div class="col-md-6 text-md-end">

                <div class="text-muted small">
                    Received At
                </div>

                <div>
                    {{ $payment->received_at?->format('d M Y H:i') }}
                </div>

            </div>

        </div>

        @if($payment->notes)

            <div class="border-top mt-4 pt-4">

                <div class="text-muted small">
                    Notes
                </div>

                <div>
                    {{ $payment->notes }}
                </div>

            </div>

        @endif

    </div>

</div>

@endsection


@push('styles')

<style>

@media print {

    body * {
        visibility: hidden;
    }

    .receipt-card,
    .receipt-card * {
        visibility: visible;
    }

    .receipt-card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
    }

}

</style>

@endpush