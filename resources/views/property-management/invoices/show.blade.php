@extends('layouts.property-management')

@section('title', 'Invoice ' . $invoice->invoice_number)

@section('page-title', 'Invoice Details')

@section('page-subtitle', $invoice->invoice_number)

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ route('property-management.invoices.index') }}">
            Rent Invoices
        </a>
    </li>

    <li class="breadcrumb-item active">
        {{ $invoice->invoice_number }}
    </li>

@endsection

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>

        <h2
            class="h4 fw-bold mb-1"
            style="color:var(--terra-navy);"
        >
            {{ $invoice->invoice_number }}
        </h2>

        <p class="text-muted mb-0">
            {{ $invoice->description }}
        </p>

    </div>


    <div class="d-flex gap-2">

        @if(in_array($invoice->status, ['draft', 'issued']))

            <a
                href="{{ route('property-management.invoices.edit', $invoice) }}"
                class="btn btn-light border"
            >
                <i class="bi bi-pencil me-1"></i>
                Edit
            </a>

        @endif


        @if(
            $invoice->paid_amount == 0 &&
            $invoice->status !== 'cancelled'
        )

            <form
                method="POST"
                action="{{ route('property-management.invoices.cancel', $invoice) }}"
                onsubmit="return confirm('Cancel this invoice?');"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-danger"
                >
                    <i class="bi bi-x-circle me-1"></i>
                    Cancel
                </button>

            </form>

        @endif

    </div>

</div>


{{-- =========================================================
     STATUS
========================================================= --}}

<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="terra-stat-card">

            <div class="terra-stat-label">
                Invoice Amount
            </div>

            <div class="terra-stat-value">
                {{ number_format($invoice->amount, 0) }}
            </div>

            <small class="text-muted">
                RWF
            </small>

        </div>

    </div>


    <div class="col-md-4">

        <div class="terra-stat-card">

            <div class="terra-stat-label">
                Paid
            </div>

            <div class="terra-stat-value text-success">
                {{ number_format($invoice->paid_amount, 0) }}
            </div>

            <small class="text-muted">
                RWF
            </small>

        </div>

    </div>


    <div class="col-md-4">

        <div class="terra-stat-card">

            <div class="terra-stat-label">
                Outstanding
            </div>

            <div
                class="terra-stat-value
                {{ $invoice->balance > 0
                    ? 'text-danger'
                    : 'text-success' }}"
            >
                {{ number_format($invoice->balance, 0) }}
            </div>

            <small class="text-muted">
                RWF
            </small>

        </div>

    </div>

</div>


<div class="row g-4">

    {{-- =====================================================
         INVOICE INFORMATION
    ====================================================== --}}

    <div class="col-xl-8">

        <div class="terra-card mb-4">

            <div class="terra-card-header">

                <h5>Invoice Information</h5>

                @php

                    $statusClass = match($invoice->status) {

                        'paid' =>
                            'badge-active',

                        'partially_paid' =>
                            'badge-pending',

                        'cancelled' =>
                            'badge-danger-soft',

                        'draft' =>
                            'badge-info-soft',

                        default =>
                            'badge-pending',

                    };

                @endphp

                <span class="badge rounded-pill {{ $statusClass }}">

                    {{ ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $invoice->status
                        )
                    ) }}

                </span>

            </div>


            <div class="terra-card-body">

                <div class="row g-4">

                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Invoice Number
                        </small>

                        <strong>
                            {{ $invoice->invoice_number }}
                        </strong>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Invoice Type
                        </small>

                        <strong>
                            {{ ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $invoice->invoice_type
                                )
                            ) }}
                        </strong>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Issue Date
                        </small>

                        <strong>
                            {{ $invoice->issue_date?->format('d M Y') }}
                        </strong>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Due Date
                        </small>

                        <strong>
                            {{ $invoice->due_date?->format('d M Y') }}
                        </strong>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Billing Period
                        </small>

                        <strong>

                            @if(
                                $invoice->billing_period_start &&
                                $invoice->billing_period_end
                            )

                                {{ $invoice->billing_period_start->format('d M Y') }}
                                —
                                {{ $invoice->billing_period_end->format('d M Y') }}

                            @else

                                Not specified

                            @endif

                        </strong>

                    </div>


                    <div class="col-md-6">

                        <small class="text-muted d-block">
                            Lease
                        </small>

                        <a
                            href="{{ route(
                                'property-management.leases.show',
                                $invoice->lease
                            ) }}"
                            class="fw-semibold"
                            style="color:var(--terra-orange);"
                        >
                            {{ $invoice->lease->lease_number }}
                        </a>

                    </div>

                </div>


                @if($invoice->notes)

                    <div class="border-top mt-4 pt-4">

                        <small class="text-muted d-block mb-1">
                            Notes
                        </small>

                        <div>
                            {{ $invoice->notes }}
                        </div>

                    </div>

                @endif

            </div>

        </div>


        {{-- =================================================
             PAYMENT ALLOCATIONS
        ================================================== --}}

        <div class="terra-card mb-4">

            <div class="terra-card-header">

                <div>
                    <h5>Payments</h5>

                    <small class="text-muted">
                        Payments allocated to this invoice
                    </small>
                </div>

            </div>


            <div class="table-responsive">

                <table class="table terra-table">

                    <thead>

                        <tr>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Transaction</th>
                            <th>Amount</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($invoice->allocations as $allocation)

                        <tr>

                            <td>

                                @if($allocation->payment)

                                    <a
                                        href="{{ route(
                                            'property-management.payments.show',
                                            $allocation->payment
                                        ) }}"
                                        class="fw-semibold"
                                        style="color:var(--terra-navy);"
                                    >
                                        {{ $allocation->payment->payment_number }}
                                    </a>

                                @else

                                    —

                                @endif

                            </td>

                            <td>
                                {{ $allocation->payment?->payment_date?->format('d M Y') ?? '—' }}
                            </td>

                            <td>
                                {{ ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        $allocation->payment?->payment_method ?? '—'
                                    )
                                ) }}
                            </td>

                            <td>
                                {{ $allocation->payment?->transaction_id ?? '—' }}
                            </td>

                            <td class="fw-semibold text-success">

                                {{ number_format(
                                    $allocation->amount,
                                    0
                                ) }}

                                <small class="text-muted">
                                    RWF
                                </small>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center py-4 text-muted"
                            >
                                No payments have been allocated to this invoice.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =================================================
             LEDGER
        ================================================== --}}

        <div class="terra-card">

            <div class="terra-card-header">

                <div>
                    <h5>Ledger Activity</h5>

                    <small class="text-muted">
                        Financial entries related to this invoice
                    </small>
                </div>

                <a
                    href="{{ route(
                        'property-management.leases.ledger',
                        $invoice->lease
                    ) }}"
                    class="btn btn-sm btn-terra-outline"
                >
                    View Full Ledger
                </a>

            </div>


            <div class="table-responsive">

                <table class="table terra-table">

                    <thead>

                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($invoice->ledgerEntries as $entry)

                        <tr>

                            <td>
                                {{ $entry->entry_date?->format('d M Y') }}
                            </td>

                            <td>
                                {{ $entry->description }}
                            </td>

                            <td>

                                @if($entry->debit > 0)

                                    {{ number_format(
                                        $entry->debit,
                                        0
                                    ) }}

                                @else

                                    —

                                @endif

                            </td>

                            <td class="text-success">

                                @if($entry->credit > 0)

                                    {{ number_format(
                                        $entry->credit,
                                        0
                                    ) }}

                                @else

                                    —

                                @endif

                            </td>

                            <td class="fw-semibold">

                                {{ number_format(
                                    $entry->balance,
                                    0
                                ) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center py-4 text-muted"
                            >
                                No ledger entries yet.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TENANT / PROPERTY
    ====================================================== --}}

    <div class="col-xl-4">

        <div class="terra-card mb-4">

            <div class="terra-card-header">
                <h5>Tenant</h5>
            </div>

            <div class="terra-card-body">

                <div class="fw-semibold fs-5">

                    {{ $invoice->tenant->full_name
                        ?? trim(
                            ($invoice->tenant->first_name ?? '') .
                            ' ' .
                            ($invoice->tenant->last_name ?? '')
                        )
                        ?: 'Tenant' }}

                </div>

                @if($invoice->tenant->email ?? null)

                    <div class="small text-muted mt-1">
                        {{ $invoice->tenant->email }}
                    </div>

                @endif

                @if($invoice->tenant->phone ?? null)

                    <div class="small text-muted">
                        {{ $invoice->tenant->phone }}
                    </div>

                @endif

            </div>

        </div>


        <div class="terra-card">

            <div class="terra-card-header">
                <h5>Property & Unit</h5>
            </div>

            <div class="terra-card-body">

                <div class="fw-semibold">
                    {{ $invoice->unit->floor->building->property->title ?? '—' }}
                </div>

                <div class="mt-2">

                    <small class="text-muted">
                        Building
                    </small>

                    <div>
                        {{ $invoice->unit->floor->building->name ?? '—' }}
                    </div>

                </div>

                <div class="mt-2">

                    <small class="text-muted">
                        Floor
                    </small>

                    <div>
                        {{ $invoice->unit->floor->name ?? '—' }}
                    </div>

                </div>

                <div class="mt-2">

                    <small class="text-muted">
                        Unit
                    </small>

                    <div class="fw-semibold">
                        {{ $invoice->unit->unit_number ?? '—' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection