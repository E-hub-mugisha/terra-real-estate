@extends('layouts.property-management.app')

@section('title', 'Payment Receipt')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.property-management.payments.show', $payment) }}"
           class="btn btn-light border">
            <i class="bi bi-arrow-left me-1"></i> Back to Payment
        </a>

        <button type="button" onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer me-1"></i> Print Receipt
        </button>
    </div>

    <div class="card border-0 shadow-sm mx-auto" style="max-width: 800px;">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-start border-bottom pb-4 mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color:#D05208;">TERRA</h2>
                    <div class="text-muted">Property Management</div>
                    <div class="text-muted small">Rent Payment Receipt</div>
                </div>

                <div class="text-end">
                    <div class="text-muted small">Receipt Number</div>
                    <div class="fw-bold">{{ $payment->receipt_number }}</div>
                    <div class="text-muted small mt-2">Payment Date</div>
                    <div class="fw-semibold">
                        {{ $payment->payment_date?->format('d F Y') ?? '—' }}
                    </div>
                </div>
            </div>

            <div class="alert {{ $payment->status === 'completed' ? 'alert-success' : 'alert-warning' }}">
                Payment status: <strong>{{ strtoupper($payment->status) }}</strong>
                @if($payment->status !== 'completed')
                    <div class="small">
                        This record is not confirmation of a completed payment.
                    </div>
                @endif
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="text-muted small mb-1">Received From</div>
                    <div class="fw-bold">
                        {{ $payment->lease?->tenant?->first_name }}
                        {{ $payment->lease?->tenant?->last_name }}
                    </div>
                    <div>{{ $payment->lease?->tenant?->phone ?? '—' }}</div>
                    <div>{{ $payment->lease?->tenant?->email ?? '—' }}</div>
                </div>

                <div class="col-md-6">
                    <div class="text-muted small mb-1">Property Details</div>
                    <div class="fw-semibold">
                        {{ $payment->lease?->unit?->managedProperty?->name ?? '—' }}
                    </div>
                    <div>Unit: {{ $payment->lease?->unit?->unit_number ?? '—' }}</div>
                    <div>Lease: {{ $payment->lease?->lease_number ?? '—' }}</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Description</th>
                            <th>Method</th>
                            <th>Transaction Reference</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                @if($payment->period_start || $payment->period_end)
                                    <div class="small text-muted">
                                        {{ $payment->period_start?->format('d M Y') ?? '—' }}
                                        to {{ $payment->period_end?->format('d M Y') ?? '—' }}
                                    </div>
                                @endif
                            </td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>{{ $payment->transaction_reference ?: '—' }}</td>
                            <td class="text-end text-nowrap fw-bold">
                                {{ $payment->currency }}
                                {{ number_format((float) $payment->amount, 2) }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th class="text-end text-nowrap">
                                {{ $payment->currency }}
                                {{ number_format((float) $payment->amount, 2) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($payment->notes)
                <div class="mt-4">
                    <div class="text-muted small mb-1">Notes</div>
                    <div>{{ $payment->notes }}</div>
                </div>
            @endif

            <div class="border-top pt-4 mt-5 text-center text-muted small">
                <p class="mb-1">Thank you. Please keep this receipt for your records.</p>
                <p class="mb-0">
                    Recorded by {{ $payment->recorder?->name ?? 'System' }}
                </p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body {
            background: #fff !important;
        }

        .sidebar,
        .topbar,
        nav,
        .btn,
        footer {
            display: none !important;
        }

        .container,
        .card,
        .card-body {
            max-width: 100% !important;
            width: 100% !important;
            box-shadow: none !important;
            border: none !important;
        }

        .card-body {
            padding: 0 !important;
        }

        @page {
            size: A4;
            margin: 15mm;
        }
    }
</style>
@endpush
@endsection