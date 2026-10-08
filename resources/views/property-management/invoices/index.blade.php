@extends('layouts.property-management')

@section('title', 'Rent Invoices')

@section('page-title', 'Rent Invoices')

@section('page-subtitle', 'Manage rent, deposits and other property charges')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>
        <h2 class="h4 fw-bold mb-1" style="color:var(--terra-navy);">
            Rent Invoices
        </h2>

        <p class="text-muted mb-0 small">
            Track invoices, payments and outstanding balances.
        </p>
    </div>

    <a
        href="{{ route('property-management.invoices.create') }}"
        class="btn btn-terra">
        <i class="bi bi-plus-lg me-1"></i>
        Create Invoice
    </a>

</div>


{{-- =========================================================
     SUMMARY
========================================================= --}}

<div class="row g-3 mb-4">

    <div class="col-xl-3 col-md-6">

        <div class="terra-stat-card">

            <div class="d-flex justify-content-between">

                <div>
                    <div class="terra-stat-label">
                        Total Invoiced
                    </div>

                    <div class="terra-stat-value">
                        {{ number_format($totalInvoiced, 0) }}
                    </div>

                    <small class="text-muted">
                        RWF
                    </small>
                </div>

                <div class="terra-stat-icon">
                    <i class="bi bi-receipt"></i>
                </div>

            </div>

        </div>

    </div>


    <div class="col-xl-3 col-md-6">

        <div class="terra-stat-card">

            <div class="d-flex justify-content-between">

                <div>
                    <div class="terra-stat-label">
                        Total Paid
                    </div>

                    <div class="terra-stat-value text-success">
                        {{ number_format($totalPaid, 0) }}
                    </div>

                    <small class="text-muted">
                        RWF
                    </small>
                </div>

                <div class="terra-stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>

            </div>

        </div>

    </div>


    <div class="col-xl-3 col-md-6">

        <div class="terra-stat-card">

            <div class="d-flex justify-content-between">

                <div>
                    <div class="terra-stat-label">
                        Outstanding
                    </div>

                    <div class="terra-stat-value text-warning">
                        {{ number_format($totalOutstanding, 0) }}
                    </div>

                    <small class="text-muted">
                        RWF
                    </small>
                </div>

                <div class="terra-stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>

            </div>

        </div>

    </div>


    <div class="col-xl-3 col-md-6">

        <div class="terra-stat-card">

            <div class="d-flex justify-content-between">

                <div>
                    <div class="terra-stat-label">
                        Overdue Invoices
                    </div>

                    <div class="terra-stat-value text-danger">
                        {{ number_format($overdueCount) }}
                    </div>

                    <small class="text-muted">
                        Require attention
                    </small>
                </div>

                <div class="terra-stat-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     FILTERS
========================================================= --}}

<div class="terra-card mb-4">

    <div class="terra-card-body">

        <form
            method="GET"
            action="{{ route('property-management.invoices.index') }}">

            <div class="row g-3 align-items-end">

                <div class="col-lg-4">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Invoice number or tenant">

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        Type
                    </label>

                    <select
                        name="invoice_type"
                        class="form-select">

                        <option value="">
                            All Types
                        </option>

                        <option
                            value="rent"
                            @selected(request('invoice_type')==='rent' )>
                            Rent
                        </option>

                        <option
                            value="deposit"
                            @selected(request('invoice_type')==='deposit' )>
                            Deposit
                        </option>

                        <option
                            value="service_charge"
                            @selected(request('invoice_type')==='service_charge' )>
                            Service Charge
                        </option>

                        <option
                            value="other"
                            @selected(request('invoice_type')==='other' )>
                            Other
                        </option>

                    </select>

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="">
                            All Statuses
                        </option>

                        @foreach([
                        'draft',
                        'issued',
                        'partially_paid',
                        'paid',
                        'overdue',
                        'cancelled'
                        ] as $status)

                        <option
                            value="{{ $status }}"
                            @selected(request('status')===$status)>
                            {{ ucwords(str_replace('_', ' ', $status)) }}
                        </option>

                        @endforeach

                    </select>

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        From
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="form-control">

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        To
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="form-control">

                </div>


                <div class="col-12 d-flex gap-2">

                    <button class="btn btn-terra">

                        <i class="bi bi-search me-1"></i>
                        Filter

                    </button>

                    <a
                        href="{{ route('property-management.invoices.index') }}"
                        class="btn btn-light border">
                        Clear
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     INVOICE TABLE
========================================================= --}}

<div class="terra-card">

    <div class="terra-card-header">

        <div>
            <h5>Invoice Register</h5>

            <small class="text-muted">
                {{ $invoices->total() }} invoice(s)
            </small>
        </div>

    </div>


    <div class="table-responsive">

        <table class="table terra-table">

            <thead>

                <tr>
                    <th>Invoice</th>
                    <th>Tenant</th>
                    <th>Property / Unit</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th></th>
                </tr>

            </thead>

            <tbody>

                @forelse($invoices as $invoice)

                @php

                $statusClass = match($invoice->status) {

                'paid' =>
                'badge-active',

                'partially_paid' =>
                'badge-pending',

                'overdue' =>
                'badge-danger-soft',

                'cancelled' =>
                'badge-danger-soft',

                'draft' =>
                'badge-info-soft',

                default =>
                'badge-pending',

                };

                $isOverdue =
                $invoice->due_date &&
                $invoice->due_date->isPast() &&
                $invoice->balance > 0 &&
                !in_array(
                $invoice->status,
                ['paid', 'cancelled']
                );

                @endphp

                <tr>

                    <td>

                        <a
                            href="{{ route('property-management.invoices.show', $invoice) }}"
                            class="fw-semibold"
                            style="color:var(--terra-navy);">
                            {{ $invoice->invoice_number }}
                        </a>

                        <small class="d-block text-muted">
                            {{ ucfirst(str_replace('_', ' ', $invoice->invoice_type)) }}
                        </small>

                    </td>


                    <td>

                        <div class="fw-semibold">

                            {{ $invoice->tenant->full_name
                                ?? trim(
                                    ($invoice->tenant->first_name ?? '') .
                                    ' ' .
                                    ($invoice->tenant->last_name ?? '')
                                )
                                ?: 'Tenant' }}

                        </div>

                    </td>


                    <td>

                        <div>
                            Unit
                            {{ $invoice->unit->unit_number ?? '—' }}
                        </div>

                        <small class="text-muted">
                            {{ $invoice->unit->floor->building->property->title ?? '—' }}
                        </small>

                    </td>


                    <td>

                        {{ $invoice->due_date?->format('d M Y') }}

                        @if($isOverdue)

                        <small class="d-block text-danger">
                            Overdue
                        </small>

                        @endif

                    </td>


                    <td class="fw-semibold">

                        {{ number_format($invoice->amount, 0) }}

                        <small class="text-muted">
                            RWF
                        </small>

                    </td>


                    <td>

                        <span
                            class="
                                fw-semibold
                                {{ $invoice->balance > 0
                                    ? 'text-danger'
                                    : 'text-success' }}
                            ">
                            {{ number_format($invoice->balance, 0) }}
                        </span>

                        <small class="text-muted">
                            RWF
                        </small>

                    </td>


                    <td>

                        <span class="badge rounded-pill {{ $statusClass }}">

                            {{ ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $invoice->status
                                )
                            ) }}

                        </span>

                    </td>


                    <td class="text-end">

                        <a
                            href="{{ route('property-management.invoices.show', $invoice) }}"
                            class="btn btn-sm btn-light border"
                            title="View invoice">
                            <i class="bi bi-eye"></i>
                        </a>

                        @if(in_array($invoice->status, ['draft', 'issued']))

                        <a
                            href="{{ route('property-management.invoices.edit', $invoice) }}"
                            class="btn btn-sm btn-light border"
                            title="Edit invoice">
                            <i class="bi bi-pencil"></i>
                        </a>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="8"
                        class="text-center py-5">

                        <i
                            class="bi bi-receipt fs-1 text-muted"></i>

                        <div class="fw-semibold mt-3">
                            No invoices found
                        </div>

                        <p class="text-muted small mb-3">
                            Create your first rent invoice to begin tracking
                            tenant balances.
                        </p>

                        <a
                            href="{{ route('property-management.invoices.create') }}"
                            class="btn btn-terra btn-sm">
                            Create Invoice
                        </a>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    @if($invoices->hasPages())

    <div class="p-3 border-top">

        {{ $invoices->links() }}

    </div>

    @endif

</div>

@endsection