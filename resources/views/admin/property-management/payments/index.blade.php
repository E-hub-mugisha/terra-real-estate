@extends('layouts.property-management.app')

@section('title', 'Rent Payments')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Rent Payments</h1>
            <p class="text-muted mb-0">Track rent receipts and payment transactions.</p>
        </div>

        <a href="{{ route('admin.property-management.payments.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Record Payment
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-lg-4">
                    <input type="search" name="search" class="form-control"
                           value="{{ request('search') }}"
                           placeholder="Receipt, tenant, lease or reference">
                </div>

                <div class="col-lg-2">
                    <select name="status" class="form-select">
                        <option value="">All statuses</option>
                        @foreach(['pending', 'completed', 'failed'] as $status)
                            <option value="{{ $status }}"
                                @selected(request('status') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <select name="payment_method" class="form-select">
                        <option value="">All methods</option>
                        @foreach([
                            'cash' => 'Cash',
                            'bank_transfer' => 'Bank Transfer',
                            'mobile_money' => 'Mobile Money',
                            'card' => 'Card',
                            'payment_gateway' => 'Payment Gateway',
                            'other' => 'Other',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(request('payment_method') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <input type="date" name="from" class="form-control"
                           aria-label="From date" value="{{ request('from') }}">
                </div>

                <div class="col-lg-2">
                    <input type="date" name="to" class="form-control"
                           aria-label="To date" value="{{ request('to') }}">
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('admin.property-management.payments.index') }}"
                       class="btn btn-light border">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Receipt</th>
                        <th>Tenant / Lease</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Period Covered</th>
                        <th>Status</th>
                        <th class="text-end">Amount</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>
                                <a href="{{ route('admin.property-management.payments.show', $payment) }}"
                                   class="fw-semibold text-decoration-none">
                                    {{ $payment->receipt_number }}
                                </a>
                                <div class="small text-muted">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}
                                </div>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $payment->lease?->tenant?->first_name }}
                                    {{ $payment->lease?->tenant?->last_name }}
                                </div>
                                <div class="small text-muted">
                                    {{ $payment->lease?->lease_number }}
                                </div>
                            </td>

                            <td>{{ $payment->payment_date?->format('d M Y') }}</td>

                            <td>
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            </td>

                            <td>
                                @if($payment->period_start || $payment->period_end)
                                    {{ $payment->period_start?->format('d M Y') ?? '—' }}
                                    <div class="small text-muted">
                                        to {{ $payment->period_end?->format('d M Y') ?? '—' }}
                                    </div>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>

                            <td>
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
                            </td>

                            <td class="text-end fw-semibold text-nowrap">
                                {{ $payment->currency }}
                                {{ number_format((float) $payment->amount, 2) }}
                            </td>

                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.property-management.payments.show', $payment) }}"
                                   class="btn btn-sm btn-light border" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.property-management.payments.receipt', $payment) }}"
                                   class="btn btn-sm btn-light border" title="Receipt">
                                    <i class="bi bi-receipt"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="bi bi-receipt fs-2 text-muted"></i>
                                <p class="fw-semibold mt-2 mb-1">No payments found</p>
                                <p class="text-muted small mb-3">
                                    Record a payment to begin tracking transactions.
                                </p>
                                <a href="{{ route('admin.property-management.payments.create') }}"
                                   class="btn btn-primary btn-sm">Record Payment</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="card-footer bg-white">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection