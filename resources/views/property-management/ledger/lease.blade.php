@extends('layouts.property-management')

@section('title', 'Lease Ledger')

@section('page-title', 'Lease Ledger')

@section('page-subtitle', $lease->lease_number)

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ route('property-management.leases.index') }}">
            Leases
        </a>
    </li>

    <li class="breadcrumb-item">
        <a href="{{ route('property-management.leases.show', $lease) }}">
            {{ $lease->lease_number }}
        </a>
    </li>

    <li class="breadcrumb-item active">
        Ledger
    </li>

@endsection


@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

    <div>

        <h2
            class="h4 fw-bold mb-1"
            style="color:var(--terra-navy);"
        >
            Lease Ledger
        </h2>

        <p class="text-muted mb-0">
            Financial activity for lease
            <strong>{{ $lease->lease_number }}</strong>
        </p>

    </div>

    <a
        href="{{ route('property-management.leases.show', $lease) }}"
        class="btn btn-light border"
    >
        <i class="bi bi-arrow-left me-1"></i>
        Back to Lease
    </a>

</div>


{{-- =========================================================
     SUMMARY
========================================================= --}}

<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="terra-stat-card">

            <div class="terra-stat-label">
                Total Charges
            </div>

            <div class="terra-stat-value">
                {{ number_format($totalDebit, 0) }}
            </div>

            <small class="text-muted">
                RWF
            </small>

        </div>

    </div>


    <div class="col-md-4">

        <div class="terra-stat-card">

            <div class="terra-stat-label">
                Total Payments
            </div>

            <div class="terra-stat-value text-success">
                {{ number_format($totalCredit, 0) }}
            </div>

            <small class="text-muted">
                RWF
            </small>

        </div>

    </div>


    <div class="col-md-4">

        <div class="terra-stat-card">

            <div class="terra-stat-label">
                Current Balance
            </div>

            <div
                class="terra-stat-value
                {{ $currentBalance > 0
                    ? 'text-danger'
                    : 'text-success' }}"
            >
                {{ number_format($currentBalance, 0) }}
            </div>

            <small class="text-muted">
                RWF
            </small>

        </div>

    </div>

</div>


<div class="row g-4">

    {{-- =====================================================
         LEDGER
    ====================================================== --}}

    <div class="col-xl-8">

        <div class="terra-card">

            <div class="terra-card-header">

                <div>

                    <h5 class="mb-1">
                        Ledger Activity
                    </h5>

                    <small class="text-muted">
                        Charges and payments recorded against this lease
                    </small>

                </div>

            </div>


            <div class="table-responsive">

                <table class="table terra-table mb-0">

                    <thead>

                        <tr>

                            <th>Date</th>

                            <th>Type</th>

                            <th>Description</th>

                            <th class="text-end">
                                Debit
                            </th>

                            <th class="text-end">
                                Credit
                            </th>

                            <th class="text-end">
                                Balance
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($entries as $entry)

                        <tr>

                            <td class="text-nowrap">

                                {{ $entry->entry_date?->format('d M Y') }}

                            </td>


                            <td>

                                @php

                                    $typeClass = match($entry->entry_type) {

                                        'invoice' =>
                                            'badge-info-soft',

                                        'payment' =>
                                            'badge-active',

                                        'deposit' =>
                                            'badge-pending',

                                        'refund' =>
                                            'badge-danger-soft',

                                        default =>
                                            'badge-pending',

                                    };

                                @endphp


                                <span class="badge rounded-pill {{ $typeClass }}">

                                    {{ ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $entry->entry_type
                                        )
                                    ) }}

                                </span>

                            </td>


                            <td>

                                <div class="fw-semibold">

                                    {{ $entry->description }}

                                </div>


                                @if($entry->invoice)

                                    <small class="text-muted">

                                        Invoice:
                                        {{ $entry->invoice->invoice_number }}

                                    </small>

                                @elseif($entry->payment)

                                    <small class="text-muted">

                                        Payment:
                                        {{ $entry->payment->payment_number }}

                                    </small>

                                @endif

                            </td>


                            <td class="text-end">

                                @if($entry->debit > 0)

                                    {{ number_format($entry->debit, 0) }}

                                @else

                                    —

                                @endif

                            </td>


                            <td class="text-end text-success">

                                @if($entry->credit > 0)

                                    {{ number_format($entry->credit, 0) }}

                                @else

                                    —

                                @endif

                            </td>


                            <td class="text-end fw-semibold">

                                {{ number_format($entry->balance, 0) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5 text-muted"
                            >

                                <i class="bi bi-journal-text fs-2 d-block mb-2"></i>

                                No ledger entries have been recorded for this lease.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>


                    @if($entries->count())

                        <tfoot>

                            <tr class="fw-bold">

                                <td colspan="3" class="text-end">
                                    Totals
                                </td>

                                <td class="text-end">
                                    {{ number_format($totalDebit, 0) }}
                                </td>

                                <td class="text-end text-success">
                                    {{ number_format($totalCredit, 0) }}
                                </td>

                                <td class="text-end">
                                    {{ number_format($currentBalance, 0) }}
                                </td>

                            </tr>

                        </tfoot>

                    @endif

                </table>

            </div>

        </div>

    </div>


    {{-- =====================================================
         LEASE INFORMATION
    ====================================================== --}}

    <div class="col-xl-4">

        <div class="terra-card mb-4">

            <div class="terra-card-header">

                <h5>Lease Information</h5>

            </div>


            <div class="terra-card-body">

                <div class="mb-3">

                    <small class="text-muted d-block">
                        Lease Number
                    </small>

                    <strong>
                        {{ $lease->lease_number }}
                    </strong>

                </div>


                <div class="mb-3">

                    <small class="text-muted d-block">
                        Tenant
                    </small>

                    <strong>

                        {{ $lease->tenant->full_name
                            ?? trim(
                                ($lease->tenant->first_name ?? '') .
                                ' ' .
                                ($lease->tenant->last_name ?? '')
                            )
                            ?: 'Tenant' }}

                    </strong>

                </div>


                <div class="mb-3">

                    <small class="text-muted d-block">
                        Monthly Rent
                    </small>

                    <strong>

                        {{ number_format($lease->monthly_rent, 0) }}

                        <small class="text-muted">
                            RWF
                        </small>

                    </strong>

                </div>


                <div class="mb-3">

                    <small class="text-muted d-block">
                        Lease Period
                    </small>

                    <strong>

                        {{ $lease->start_date?->format('d M Y') }}

                        —

                        {{ $lease->end_date?->format('d M Y') }}

                    </strong>

                </div>


                <div>

                    <small class="text-muted d-block">
                        Status
                    </small>

                    <span class="badge rounded-pill badge-active">

                        {{ ucwords($lease->status) }}

                    </span>

                </div>

            </div>

        </div>


        {{-- =================================================
             PROPERTY
        ================================================== --}}

        <div class="terra-card">

            <div class="terra-card-header">

                <h5>Property & Unit</h5>

            </div>


            <div class="terra-card-body">

                <div class="fw-semibold">

                    {{ $property->title }}

                </div>


                <div class="mt-3">

                    <small class="text-muted d-block">
                        Building
                    </small>

                    <div>

                        {{ $lease->unit->floor->building->name ?? '—' }}

                    </div>

                </div>


                <div class="mt-3">

                    <small class="text-muted d-block">
                        Floor
                    </small>

                    <div>

                        {{ $lease->unit->floor->name ?? '—' }}

                    </div>

                </div>


                <div class="mt-3">

                    <small class="text-muted d-block">
                        Unit
                    </small>

                    <div class="fw-semibold">

                        {{ $lease->unit->unit_number ?? '—' }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection