@extends('layouts.property-management')

@section('title', 'Payment ' . $payment->payment_number)

@section('page-title', 'Payment Details')

@section('page-subtitle', $payment->payment_number)

@section('content')

@php
    $statusClasses = [
        'pending'   => 'bg-warning text-dark',
        'confirmed' => 'bg-success',
        'failed'    => 'bg-danger',
        'reversed'  => 'bg-danger',
        'cancelled' => 'bg-secondary',
    ];

    $statusClass = $statusClasses[$payment->status] ?? 'bg-secondary';

    $tenantName = $payment->tenant->full_name
        ?? trim(
            ($payment->tenant->first_name ?? '') . ' ' .
            ($payment->tenant->last_name ?? '')
        );

    $isConfirmed = $payment->status === 'confirmed';
@endphp

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4"
         role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4"
         role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>
        {{ session('error') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger mb-4">
        <div class="fw-semibold mb-2">
            Please correct the following errors:
        </div>

        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- Payment Confirmation Panel --}}
<div class="card border-0 shadow-sm mb-4 no-print">
    <div class="card-body p-4">

        <div class="d-flex flex-wrap justify-content-between
                    align-items-center gap-3">

            <div>
                <h5 class="fw-bold mb-2">
                    <i class="bi bi-shield-check me-2"></i>
                    Payment Confirmation
                </h5>

                <div class="text-muted small mb-2">
                    Payment reference:
                    <span class="fw-semibold">
                        {{ $payment->payment_number }}
                    </span>
                </div>

                <span class="badge {{ $statusClass }} px-3 py-2">
                    {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                </span>

                <div class="mt-3">
                    <div class="text-muted small">
                        Payment Amount
                    </div>

                    <div class="fs-4 fw-bold">
                        {{ number_format((float) $payment->amount, 0) }}
                        RWF
                    </div>
                </div>
            </div>

            <div>
                @if($payment->status === 'pending')

                    <div class="d-flex flex-wrap gap-2">

                        {{-- Confirm Payment --}}
                        <form method="POST"
                              action="{{ route('property-management.payments.confirm', $payment->id) }}"
                              onsubmit="return confirm('Confirm this payment? This action will update the invoice balances and ledger.');">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Confirm Payment
                            </button>
                        </form>

                        {{-- Mark Payment as Failed --}}
                        <form method="POST"
                              action="{{ route('property-management.payments.reject', $payment->id) }}"
                              onsubmit="return confirm('Are you sure you want to mark this payment as failed?');">

                            @csrf
                            @method('PATCH')

                            <button type="submit"
                                    class="btn btn-outline-danger">
                                <i class="bi bi-x-circle me-1"></i>
                                Mark as Failed
                            </button>
                        </form>

                    </div>

                    <div class="text-muted small mt-2">
                        Confirm only after verifying that the payment was received.
                    </div>

                @elseif($payment->status === 'confirmed')

                    <div class="confirmation-status text-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span class="fw-semibold">
                            Payment confirmed successfully
                        </span>
                    </div>

                    <div class="text-muted small mt-2">
                        This payment has been confirmed.
                    </div>

                @elseif($payment->status === 'failed')

                    <div class="text-danger fw-semibold">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        Payment marked as failed
                    </div>

                @elseif($payment->status === 'reversed')

                    <div class="text-danger fw-semibold">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>
                        Payment reversed
                    </div>

                @elseif($payment->status === 'cancelled')

                    <div class="text-muted fw-semibold">
                        <i class="bi bi-slash-circle me-2"></i>
                        Payment cancelled
                    </div>

                @endif
            </div>

        </div>

    </div>
</div>


{{-- Print Receipt Button --}}
<div class="d-flex justify-content-end mb-4 no-print">

    @if($isConfirmed)

        <button type="button"
                onclick="window.print()"
                class="btn btn-outline-secondary">

            <i class="bi bi-printer me-1"></i>
            Print Receipt

        </button>

    @else

        <span class="text-muted small">
            <i class="bi bi-info-circle me-1"></i>
            An official receipt will be available after confirmation.
        </span>

    @endif

</div>


{{-- Payment Receipt --}}
<div class="card border-0 shadow-sm receipt-card">

    <div class="card-body p-4 p-md-5">

        {{-- Receipt Header --}}
        <div class="row align-items-start mb-5">

            <div class="col-md-7">

                <h2 class="fw-bold mb-1"
                    style="color: #D05208;">
                    TERRA
                </h2>

                <div class="text-muted">
                    Property Management
                </div>

            </div>

            <div class="col-md-5 text-md-end mt-4 mt-md-0">

                <div class="text-muted small">
                    @if($isConfirmed)
                        PAYMENT RECEIPT
                    @else
                        PAYMENT SUBMISSION
                    @endif
                </div>

                <div class="fs-4 fw-bold">
                    {{ $payment->payment_number }}
                </div>

                @if(!$isConfirmed)
                    <div class="mt-2">
                        <span class="badge {{ $statusClass }}">
                            {{ strtoupper(str_replace('_', ' ', $payment->status)) }}
                        </span>
                    </div>

                    <div class="small text-muted mt-2">
                        This document is not proof of confirmed payment.
                    </div>
                @else
                    <div class="mt-2">
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i>
                            CONFIRMED
                        </span>
                    </div>
                @endif

            </div>

        </div>


        {{-- Tenant and Payment Information --}}
        <div class="row g-4 mb-5">

            <div class="col-md-6">

                <h6 class="text-uppercase text-muted small fw-bold mb-3">
                    Tenant Information
                </h6>

                <div class="fw-semibold">
                    {{ $tenantName ?: 'N/A' }}
                </div>

                @if($payment->tenant?->phone)
                    <div class="text-muted mt-1">
                        <i class="bi bi-telephone me-1"></i>
                        {{ $payment->tenant->phone }}
                    </div>
                @endif

                @if($payment->tenant?->email)
                    <div class="text-muted mt-1">
                        <i class="bi bi-envelope me-1"></i>
                        {{ $payment->tenant->email }}
                    </div>
                @endif

            </div>

            <div class="col-md-6">

                <h6 class="text-uppercase text-muted small fw-bold mb-3">
                    Payment Information
                </h6>

                <div class="text-muted small">
                    Payment Date
                </div>

                <div class="fw-semibold">
                    {{ $payment->payment_date?->format('d M Y') ?? 'N/A' }}
                </div>

                <div class="text-muted small mt-3">
                    Payment Method
                </div>

                <div class="fw-semibold">
                    {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                </div>

                @if($payment->provider)
                    <div class="text-muted small mt-3">
                        Payment Provider
                    </div>

                    <div>
                        {{ $payment->provider }}
                    </div>
                @endif

                @if($payment->transaction_id)
                    <div class="text-muted small mt-3">
                        Transaction Reference
                    </div>

                    <div class="fw-semibold">
                        {{ $payment->transaction_id }}
                    </div>
                @endif

            </div>

        </div>


        {{-- Allocated Invoices --}}
        <div class="mb-4">

            <h6 class="text-uppercase text-muted small fw-bold mb-3">
                Payment Breakdown
            </h6>

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>Invoice Number</th>
                            <th>Description</th>
                            <th class="text-end">Allocated Amount</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($payment->allocations as $allocation)

                            <tr>

                                <td class="fw-semibold">
                                    {{ $allocation->invoice?->invoice_number ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $allocation->invoice?->description
                                        ?: ucfirst(str_replace(
                                            '_',
                                            ' ',
                                            $allocation->invoice?->invoice_type ?? 'Payment'
                                        ))
                                    }}
                                </td>

                                <td class="text-end">
                                    {{ number_format((float) $allocation->amount, 0) }}
                                    RWF
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3"
                                    class="text-center text-muted py-4">
                                    No invoice allocations have been recorded.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                    <tfoot>

                        <tr>
                            <th colspan="2" class="text-end">
                                Total Payment
                            </th>

                            <th class="text-end fs-5">
                                {{ number_format((float) $payment->amount, 0) }}
                                RWF
                            </th>
                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>


        {{-- Unallocated Amount --}}
        @if((float) ($payment->unallocated_amount ?? 0) > 0)

            <div class="alert alert-warning">
                <div class="fw-semibold mb-1">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    Unallocated Amount
                </div>

                <div>
                    {{ number_format((float) $payment->unallocated_amount, 0) }}
                    RWF has not been allocated to an invoice.
                </div>
            </div>

        @endif


        {{-- Confirmation Details --}}
        @if($isConfirmed)

            <div class="row g-4 mt-4 pt-4 border-top">

                <div class="col-md-6">

                    <div class="text-muted small mb-1">
                        Confirmed By
                    </div>

                    <div class="fw-semibold">
                        {{ $payment->recorder?->name ?? 'System' }}
                    </div>

                </div>

                <div class="col-md-6 text-md-end">

                    <div class="text-muted small mb-1">
                        Confirmation Date
                    </div>

                    <div class="fw-semibold">
                        {{ $payment->received_at?->format('d M Y H:i') ?? 'Not recorded' }}
                    </div>

                </div>

            </div>

        @endif


        {{-- Notes --}}
        @if($payment->notes)

            <div class="border-top mt-4 pt-4">

                <div class="text-muted small fw-bold mb-2">
                    Notes
                </div>

                <div class="text-break">
                    {{ $payment->notes }}
                </div>

            </div>

        @endif


        {{-- Footer --}}
        <div class="border-top mt-5 pt-4 text-center">

            @if($isConfirmed)

                <div class="text-success fw-semibold mb-2">
                    <i class="bi bi-check-circle-fill me-1"></i>
                    Payment confirmed
                </div>

                <div class="text-muted small">
                    This receipt confirms the payment recorded by Terra Property Management.
                </div>

            @else

                <div class="text-muted small">
                    This is a payment submission record, not an official receipt.
                    Confirmation is pending verification.
                </div>

            @endif

            <div class="text-muted small mt-3">
                Terra Property Management
            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>
    .confirmation-status {
        display: flex;
        align-items: center;
    }

    .receipt-card {
        background: #fff;
    }

    @media print {

        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            background: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body * {
            visibility: hidden;
        }

        .receipt-card,
        .receipt-card * {
            visibility: visible;
        }

        .receipt-card {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .receipt-card .card-body {
            padding: 0 !important;
        }

        .no-print {
            display: none !important;
        }

        .table-responsive {
            overflow: visible !important;
        }

        .table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6 !important;
        }

        .alert {
            border: 1px solid #dee2e6 !important;
        }
    }
</style>

@endpush