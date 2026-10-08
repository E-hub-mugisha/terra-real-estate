@extends('layouts.property-management')

@section('title', 'Payments')

@section('page-title', 'Payments')

@section('page-subtitle', 'Record and monitor rent payments received from tenants.')

@section('content')

<div class="d-flex justify-content-end mb-4">
    <a href="{{ route('property-management.payments.create') }}"
       class="btn btn-terra">
        <i class="bi bi-plus-lg me-1"></i>
        Record Payment
    </a>
</div>

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white border-0 p-4">

        <form method="GET"
              action="{{ route('property-management.payments.index') }}">

            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label">
                        Search
                    </label>

                    <input type="text"
                           name="search"
                           class="form-control"
                           value="{{ request('search') }}"
                           placeholder="Payment number, tenant or transaction reference">

                </div>

                <div class="col-md-3">

                    <label class="form-label">
                        Payment Method
                    </label>

                    <select name="payment_method"
                            class="form-select">

                        <option value="">All methods</option>

                        @foreach([
                            'cash' => 'Cash',
                            'bank_transfer' => 'Bank Transfer',
                            'mobile_money' => 'Mobile Money',
                            'card' => 'Card',
                            'cheque' => 'Cheque',
                            'other' => 'Other',
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                @selected(request('payment_method') === $value)>
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button class="btn btn-terra w-100">
                        Search
                    </button>

                </div>

            </div>

        </form>

    </div>

    <div class="table-responsive">

        <table class="table align-middle mb-0">

            <thead class="table-light">

                <tr>
                    <th>Payment</th>
                    <th>Tenant</th>
                    <th>Date</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th></th>
                </tr>

            </thead>

            <tbody>

                @forelse($payments as $payment)

                    <tr>

                        <td>

                            <div class="fw-semibold">
                                {{ $payment->payment_number }}
                            </div>

                            @if($payment->transaction_id)
                                <small class="text-muted">
                                    Ref:
                                    {{ $payment->transaction_id }}
                                </small>
                            @endif

                        </td>

                        <td>

                            {{ $payment->tenant->full_name
                                ?? trim(
                                    ($payment->tenant->first_name ?? '') .
                                    ' ' .
                                    ($payment->tenant->last_name ?? '')
                                )
                            }}

                        </td>

                        <td>
                            {{ $payment->payment_date?->format('d M Y') }}
                        </td>

                        <td>
                            {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                        </td>

                        <td class="fw-semibold">
                            {{ number_format($payment->amount, 0) }} RWF
                        </td>

                        <td>

                            <span class="badge
                                @if($payment->status === 'completed')
                                    bg-success
                                @elseif($payment->status === 'pending')
                                    bg-warning text-dark
                                @else
                                    bg-secondary
                                @endif">

                                {{ ucfirst($payment->status) }}

                            </span>

                        </td>

                        <td class="text-end">

                            <a href="{{ route(
                                'property-management.payments.show',
                                $payment
                            ) }}"
                               class="btn btn-sm btn-outline-secondary">

                                View

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-5 text-muted">

                            No payments have been recorded yet.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($payments->hasPages())

        <div class="card-footer bg-white border-0 p-4">

            {{ $payments->links() }}

        </div>

    @endif

</div>

@endsection