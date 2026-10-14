@extends('layouts.property-management.app')

@section('title', 'Payment Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.payments.index') }}"
               class="small text-muted text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> All Payments
            </a>
            <h1 class="h3 fw-bold mt-2 mb-1">{{ $payment->receipt_number }}</h1>
            <p class="text-muted mb-0">Payment transaction details.</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.property-management.payments.receipt', $payment) }}"
               class="btn btn-light border">
                <i class="bi bi-printer me-1"></i> View Receipt
            </a>

            @if($payment->status !== 'completed')
                <a href="{{ route('admin.property-management.payments.edit', $payment) }}"
                   class="btn btn-primary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Payment Summary</h5>
                            <p class="text-muted small mb-0">
                                Recorded {{ $payment->created_at?->format('d M Y, H:i') }}
                            </p>
                        </div>

                        @php
                            $statusClass = match ($payment->status) {
                                'completed' => 'success',
                                'pending' => 'warning',
                                'failed' => 'danger',
                                default => 'secondary',
                            };
                        @endphp

                        <span class="badge text-bg-{{ $statusClass }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>

                    <div class="p-4 rounded bg-light mb-4">
                        <div class="text-muted small">Payment Amount</div>
                        <div class="display-6 fw-bold">
                            {{ $payment->currency }}
                            {{ number_format((float) $payment->amount, 2) }}
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small">Payment Date</div>
                            <div class="fw-semibold">
                                {{ $payment->payment_date?->format('d F Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Payment Method</div>
                            <div class="fw-semibold">
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Payment Type</div>
                            <div class="fw-semibold">
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Transaction Reference</div>
                            <div class="fw-semibold">
                                {{ $payment->transaction_reference ?: '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Period Start</div>
                            <div class="fw-semibold">
                                {{ $payment->period_start?->format('d M Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Period End</div>
                            <div class="fw-semibold">
                                {{ $payment->period_end?->format('d M Y') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Recorded By</div>
                            <div class="fw-semibold">
                                {{ $payment->recorder?->name ?? 'System' }}
                            </div>
                        </div>
                    </div>

                    @if($payment->notes)
                        <hr class="my-4">
                        <h6 class="fw-bold">Notes</h6>
                        <p class="mb-0" style="white-space: pre-line">{{ $payment->notes }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Tenant</h5>

                    <div class="fw-semibold fs-5">
                        {{ $payment->lease?->tenant?->first_name }}
                        {{ $payment->lease?->tenant?->last_name }}
                    </div>

                    <div class="text-muted small mb-3">
                        {{ $payment->lease?->tenant?->tenant_code }}
                    </div>

                    <div class="small text-muted">Phone</div>
                    <div>{{ $payment->lease?->tenant?->phone ?? '—' }}</div>

                    <hr>

                    <h6 class="fw-bold">Lease</h6>
                    <div>{{ $payment->lease?->lease_number }}</div>

                    <div class="small text-muted mt-3">Property</div>
                    <div>
                        {{ $payment->lease?->unit?->managedProperty?->name ?? '—' }}
                    </div>

                    <div class="small text-muted mt-3">Unit</div>
                    <div>
                        {{ $payment->lease?->unit?->unit_number ?? '—' }}
                    </div>

                    <div class="small text-muted mt-3">Monthly Rent</div>
                    <div class="fw-semibold">
                        {{ $payment->lease?->currency }}
                        {{ number_format((float) ($payment->lease?->monthly_rent ?? 0), 2) }}
                    </div>

                    <a href="{{ route('admin.property-management.leases.show', $payment->lease) }}"
                       class="btn btn-light border w-100 mt-3">
                        View Lease
                    </a>
                </div>
            </div>

            @if($payment->status !== 'completed')
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-danger">Delete Payment Record</h6>
                        <p class="text-muted small">
                            Only non-completed payment records can be deleted.
                        </p>

                        <form method="POST"
                              action="{{ route('admin.property-management.payments.destroy', $payment) }}"
                              onsubmit="return confirm('Delete this payment record?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-outline-danger w-100">
                                Delete Record
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection