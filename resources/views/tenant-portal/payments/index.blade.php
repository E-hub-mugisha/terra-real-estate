@extends('layouts.property-management')

@section('title', 'My Payments')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">My Payments</h1>
            <p class="text-muted mb-0">
                View your rental invoices, payment history, and outstanding balances.
            </p>
        </div>

        <a href="{{ route('tenant-portal.dashboard') }}"
            class="btn btn-outline-secondary">
            Back to Dashboard
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Total Invoiced</div>
                    <h4 class="fw-bold mt-2 mb-0">
                        {{ number_format((float) $invoiceStats->total_invoiced, 0) }} RWF
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Invoice Payments Recorded</div>
                    <h4 class="fw-bold mt-2 mb-0">
                        {{ number_format((float) $invoiceStats->total_paid, 0) }} RWF
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Outstanding Balance</div>
                    <h4 class="fw-bold mt-2 mb-0">
                        {{ number_format((float) $invoiceStats->total_balance, 0) }} RWF
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Rental Invoices</h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Description</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($invoices as $invoice)
                    @php
                    $invoiceClasses = [
                    'paid' => 'success',
                    'partially_paid' => 'warning',
                    'overdue' => 'danger',
                    'issued' => 'primary',
                    'draft' => 'secondary',
                    'cancelled' => 'dark',
                    ];

                    $invoiceStatus = $invoice->status;

                    if (
                    (float) $invoice->balance > 0 &&
                    $invoice->due_date &&
                    $invoice->due_date->lt(today()) &&
                    !in_array($invoiceStatus, ['paid', 'cancelled', 'draft'])
                    ) {
                    $invoiceStatus = 'overdue';
                    }

                    $invoiceClass = $invoiceClasses[$invoiceStatus] ?? 'secondary';
                    @endphp

                    <tr>
                        <td class="fw-semibold">
                            {{ $invoice->invoice_number }}
                        </td>

                        <td>
                            {{ $invoice->description ?? 'Rental invoice' }}
                        </td>

                        <td>
                            {{ $invoice->issue_date?->format('d M Y') ?? '—' }}
                        </td>

                        <td>
                            {{ $invoice->due_date?->format('d M Y') ?? '—' }}
                        </td>

                        <td>
                            {{ number_format((float) $invoice->amount, 0) }} RWF
                        </td>

                        <td class="fw-semibold">
                            {{ number_format((float) $invoice->balance, 0) }} RWF
                        </td>

                        <td>
                            <span class="badge bg-{{ $invoiceClass }}">
                                {{ ucfirst($invoiceStatus) }}
                            </span>
                        </td>
                        <td class="text-end">
                            @if (
                            (float) $invoice->balance > 0 &&
                            !in_array($invoice->status, ['paid', 'cancelled', 'draft'])
                            )
                            <a href="{{ route('tenant-portal.payments.create', ['invoice' => $invoice->id]) }}"
                                class="btn btn-sm btn-primary">
                                <i class="bi bi-credit-card me-1"></i>
                                Pay Now
                            </a>
                            @elseif ($invoice->status === 'paid')
                            <span class="text-success small fw-semibold">
                                <i class="bi bi-check-circle me-1"></i> Paid
                            </span>
                            @else
                            <span class="text-muted small">Unavailable</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <h6 class="fw-bold">No invoices yet</h6>
                            <p class="text-muted mb-0">
                                Your rental invoices will appear here when issued.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $invoices->links() }}
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Payment History</h5>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Payment Number</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Transaction ID</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                    @php
                    $paymentClasses = [
                    'completed' => 'success',
                    'pending' => 'warning',
                    'failed' => 'danger',
                    'cancelled' => 'dark',
                    ];

                    $paymentClass = $paymentClasses[$payment->status]
                    ?? 'secondary';
                    @endphp

                    <tr>
                        <td class="fw-semibold">
                            {{ $payment->payment_number }}
                        </td>

                        <td>
                            {{ $payment->payment_date?->format('d M Y') ?? '—' }}
                        </td>

                        <td>
                            {{ ucwords(str_replace('_', ' ', $payment->payment_method ?? '—')) }}
                        </td>

                        <td>
                            {{ $payment->transaction_id ?? '—' }}
                        </td>

                        <td>
                            {{ number_format((float) $payment->amount, 0) }} {{ $payment->currency ?? 'RWF' }}
                        </td>

                        <td>
                            <span class="badge bg-{{ $paymentClass }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>

                        <td>
                            @if($payment->status === 'completed')
                            <a href="{{ route('tenant-portal.payments.receipt', $payment) }}"
                                class="btn btn-sm btn-outline-primary">
                                Receipt
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <h6 class="fw-bold">No payments recorded</h6>
                            <p class="text-muted mb-0">
                                Your recorded rent payments will appear here.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $payments->links() }}
        </div>
    </div>

</div>
@endsection