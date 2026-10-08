@extends('layouts.property-management')

@section('title', 'Create Invoice')

@section('page-title', 'Create Rent Invoice')

@section('page-subtitle', 'Issue rent, deposit or other charges against an active lease')

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ route('property-management.invoices.index') }}">
            Rent Invoices
        </a>
    </li>

    <li class="breadcrumb-item active">
        Create
    </li>

@endsection

@section('content')

<form
    method="POST"
    action="{{ route('property-management.invoices.store') }}"
>

    @csrf

    <div class="row g-4">

        {{-- =====================================================
             MAIN FORM
        ====================================================== --}}

        <div class="col-xl-8">

            <div class="terra-card mb-4">

                <div class="terra-card-header">

                    <div>
                        <h5>Invoice Information</h5>

                        <small class="text-muted">
                            Select the active lease that this charge belongs to.
                        </small>
                    </div>

                </div>


                <div class="terra-card-body">

                    <div class="row g-3">

                        {{-- Lease --}}
                        <div class="col-12">

                            <label class="form-label">
                                Active Lease <span class="text-danger">*</span>
                            </label>

                            <select
                                name="lease_id"
                                id="lease_id"
                                class="form-select @error('lease_id') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    Select active lease
                                </option>

                                @foreach($leases as $lease)

                                    @php

                                        $tenantName =
                                            $lease->tenant->full_name
                                            ?? trim(
                                                ($lease->tenant->first_name ?? '') .
                                                ' ' .
                                                ($lease->tenant->last_name ?? '')
                                            )
                                            ?: 'Tenant';

                                        $propertyName =
                                            $lease->unit
                                                ->floor
                                                ->building
                                                ->property
                                                ->title
                                                ?? 'Property';

                                    @endphp

                                    <option
                                        value="{{ $lease->id }}"
                                        data-rent="{{ $lease->monthly_rent }}"
                                        data-deposit="{{ $lease->deposit_amount }}"
                                        data-tenant="{{ $tenantName }}"
                                        data-unit="{{ $lease->unit->unit_number ?? '—' }}"
                                        data-property="{{ $propertyName }}"
                                        @selected(
                                            old('lease_id', $selectedLease?->id)
                                            == $lease->id
                                        )
                                    >

                                        {{ $lease->lease_number }}
                                        —
                                        {{ $tenantName }}
                                        —
                                        Unit {{ $lease->unit->unit_number ?? '—' }}

                                    </option>

                                @endforeach

                            </select>

                            @error('lease_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Selected lease summary --}}
                        <div class="col-12">

                            <div
                                id="leaseSummary"
                                class="border rounded p-3 bg-light"
                            >

                                <div class="text-muted small">
                                    Select a lease to see its details.
                                </div>

                            </div>

                        </div>


                        {{-- Invoice Type --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Invoice Type <span class="text-danger">*</span>
                            </label>

                            <select
                                name="invoice_type"
                                id="invoice_type"
                                class="form-select @error('invoice_type') is-invalid @enderror"
                                required
                            >

                                <option
                                    value="rent"
                                    @selected(old('invoice_type', 'rent') === 'rent')
                                >
                                    Rent
                                </option>

                                <option
                                    value="deposit"
                                    @selected(old('invoice_type') === 'deposit')
                                >
                                    Security Deposit
                                </option>

                                <option
                                    value="service_charge"
                                    @selected(old('invoice_type') === 'service_charge')
                                >
                                    Service Charge
                                </option>

                                <option
                                    value="other"
                                    @selected(old('invoice_type') === 'other')
                                >
                                    Other
                                </option>

                            </select>

                            @error('invoice_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Description <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="description"
                                id="description"
                                value="{{ old('description') }}"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="e.g. October 2026 Rent"
                                required
                            >

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Billing period --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Billing Period Start
                            </label>

                            <input
                                type="date"
                                name="billing_period_start"
                                value="{{ old('billing_period_start') }}"
                                class="form-control @error('billing_period_start') is-invalid @enderror"
                            >

                            @error('billing_period_start')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Billing Period End
                            </label>

                            <input
                                type="date"
                                name="billing_period_end"
                                value="{{ old('billing_period_end') }}"
                                class="form-control @error('billing_period_end') is-invalid @enderror"
                            >

                            @error('billing_period_end')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Issue date --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Issue Date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="issue_date"
                                value="{{ old('issue_date', now()->format('Y-m-d')) }}"
                                class="form-control @error('issue_date') is-invalid @enderror"
                                required
                            >

                            @error('issue_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Due date --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Due Date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="due_date"
                                value="{{ old('due_date') }}"
                                class="form-control @error('due_date') is-invalid @enderror"
                                required
                            >

                            @error('due_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Amount --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Amount (RWF)
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                value="{{ old('amount') }}"
                                class="form-control @error('amount') is-invalid @enderror"
                                min="0.01"
                                step="0.01"
                                placeholder="0"
                                required
                            >

                            @error('amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Status --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status"
                                class="form-select @error('status') is-invalid @enderror"
                                required
                            >

                                <option
                                    value="issued"
                                    @selected(old('status', 'issued') === 'issued')
                                >
                                    Issue Invoice
                                </option>

                                <option
                                    value="draft"
                                    @selected(old('status') === 'draft')
                                >
                                    Save as Draft
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Notes --}}
                        <div class="col-12">

                            <label class="form-label">
                                Notes
                            </label>

                            <textarea
                                name="notes"
                                rows="4"
                                class="form-control @error('notes') is-invalid @enderror"
                                placeholder="Additional notes about this invoice..."
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            <div class="d-flex justify-content-end gap-2">

                <a
                    href="{{ route('property-management.invoices.index') }}"
                    class="btn btn-light border"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-terra"
                >
                    <i class="bi bi-check-lg me-1"></i>
                    Create Invoice
                </button>

            </div>

        </div>


        {{-- =====================================================
             SIDE INFORMATION
        ====================================================== --}}

        <div class="col-xl-4">

            <div class="terra-card">

                <div class="terra-card-header">

                    <h5>Invoice Summary</h5>

                </div>

                <div class="terra-card-body">

                    <div class="mb-3">

                        <small class="text-muted d-block">
                            Amount
                        </small>

                        <strong
                            id="summaryAmount"
                            class="fs-4"
                            style="color:var(--terra-navy);"
                        >
                            RWF 0
                        </strong>

                    </div>


                    <div class="border-top pt-3">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted small">
                                Invoice Type
                            </span>

                            <strong
                                id="summaryType"
                                class="small"
                            >
                                Rent
                            </strong>

                        </div>


                        <div class="d-flex justify-content-between">

                            <span class="text-muted small">
                                Status
                            </span>

                            <span class="badge rounded-pill badge-active">
                                Issued
                            </span>

                        </div>

                    </div>


                    <div class="alert alert-light border mt-4 mb-0">

                        <small>
                            Issued invoices immediately create a debit
                            entry in the tenant's rent ledger.
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>

</form>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const leaseSelect =
        document.getElementById('lease_id');

    const leaseSummary =
        document.getElementById('leaseSummary');

    const invoiceType =
        document.getElementById('invoice_type');

    const description =
        document.getElementById('description');

    const amount =
        document.getElementById('amount');

    const summaryAmount =
        document.getElementById('summaryAmount');

    const summaryType =
        document.getElementById('summaryType');


    function formatMoney(value) {

        return new Intl.NumberFormat('en-RW', {
            maximumFractionDigits: 0
        }).format(value || 0);

    }


    function updateLease() {

        const option =
            leaseSelect.options[
                leaseSelect.selectedIndex
            ];

        if (!option || !option.value) {

            leaseSummary.innerHTML = `
                <div class="text-muted small">
                    Select a lease to see its details.
                </div>
            `;

            return;
        }


        const tenant =
            option.dataset.tenant || 'Tenant';

        const unit =
            option.dataset.unit || '—';

        const property =
            option.dataset.property || 'Property';

        const rent =
            parseFloat(option.dataset.rent || 0);

        const deposit =
            parseFloat(option.dataset.deposit || 0);


        leaseSummary.innerHTML = `

            <div class="row g-3">

                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Tenant
                    </small>

                    <strong>
                        ${tenant}
                    </strong>

                </div>

                <div class="col-md-6">

                    <small class="text-muted d-block">
                        Unit
                    </small>

                    <strong>
                        ${unit}
                    </strong>

                </div>

                <div class="col-md-8">

                    <small class="text-muted d-block">
                        Property
                    </small>

                    <strong>
                        ${property}
                    </strong>

                </div>

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Monthly Rent
                    </small>

                    <strong>
                        RWF ${formatMoney(rent)}
                    </strong>

                </div>

            </div>

        `;


        /*
        |--------------------------------------------------------------------------
        | Automatically suggest rent amount
        |--------------------------------------------------------------------------
        */

        if (
            invoiceType.value === 'rent' &&
            !amount.value
        ) {
            amount.value = rent;
        }

        if (
            invoiceType.value === 'deposit' &&
            !amount.value
        ) {
            amount.value = deposit;
        }

        updateSummary();

    }


    function updateSummary() {

        const value =
            parseFloat(amount.value || 0);

        summaryAmount.textContent =
            'RWF ' + formatMoney(value);

        summaryType.textContent =
            invoiceType.options[
                invoiceType.selectedIndex
            ]?.text || 'Rent';

    }


    leaseSelect.addEventListener(
        'change',
        updateLease
    );

    invoiceType.addEventListener(
        'change',
        function () {

            const option =
                leaseSelect.options[
                    leaseSelect.selectedIndex
                ];

            if (option && option.value) {

                if (invoiceType.value === 'rent') {

                    amount.value =
                        option.dataset.rent || '';

                }

                if (invoiceType.value === 'deposit') {

                    amount.value =
                        option.dataset.deposit || '';

                }

            }

            updateSummary();

        }
    );


    amount.addEventListener(
        'input',
        updateSummary
    );


    /*
    |--------------------------------------------------------------------------
    | Auto description
    |--------------------------------------------------------------------------
    */

    invoiceType.addEventListener(
        'change',
        function () {

            if (description.value.trim() !== '') {
                return;
            }

            if (invoiceType.value === 'rent') {

                description.value =
                    'Rent';

            } else if (
                invoiceType.value === 'deposit'
            ) {

                description.value =
                    'Security Deposit';

            } else if (
                invoiceType.value === 'service_charge'
            ) {

                description.value =
                    'Service Charge';

            }

        }
    );


    updateLease();
    updateSummary();

});

</script>

@endpush