@extends('layouts.property-management')

@section('title', 'Record Payment')

@section('page-title', 'Record Payment')

@section('page-subtitle', 'Record money received and allocate it against outstanding invoices.')

@section('content')

<form method="POST"
      action="{{ route('property-management.payments.store') }}">

    @csrf

    {{-- Hidden payment currency --}}
    <input type="hidden"
           name="currency"
           value="{{ old('currency', 'RWF') }}">

    {{-- Unit is automatically determined from lease --}}
    <input type="hidden"
           name="unit_id"
           id="unit_id"
           value="{{ old('unit_id') }}">

    <div class="row g-4">

        <div class="col-lg-8">

            {{-- Payment Information --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white border-0 p-4">

                    <h5 class="mb-1">
                        Payment Information
                    </h5>

                    <p class="text-muted mb-0">
                        Enter the payment received from the tenant.
                    </p>

                </div>

                <div class="card-body p-4">

                    <div class="row g-3">

                        {{-- Tenant --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Tenant
                                <span class="text-danger">*</span>
                            </label>

                            <select name="tenant_id"
                                    id="tenant_id"
                                    class="form-select @error('tenant_id') is-invalid @enderror"
                                    required>

                                <option value="">
                                    Select tenant
                                </option>

                                @foreach($tenants as $tenant)

                                    @php
                                        $tenantName =
                                            $tenant->full_name
                                            ?? trim(
                                                ($tenant->first_name ?? '') .
                                                ' ' .
                                                ($tenant->last_name ?? '')
                                            );
                                    @endphp

                                    <option value="{{ $tenant->id }}"
                                        @selected(old('tenant_id') == $tenant->id)>

                                        {{ $tenantName }}

                                        @if($tenant->phone)
                                            — {{ $tenant->phone }}
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                            @error('tenant_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Lease --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Lease
                                <span class="text-danger">*</span>
                            </label>

                            <select name="lease_id"
                                    id="lease_id"
                                    class="form-select @error('lease_id') is-invalid @enderror"
                                    required>

                                <option value="">
                                    Select lease
                                </option>

                                @foreach($leases as $lease)

                                    <option value="{{ $lease->id }}"
                                            data-tenant="{{ $lease->tenant_id }}"
                                            data-unit="{{ $lease->unit_id }}"
                                            @selected(old('lease_id') == $lease->id)>

                                        {{ $lease->lease_number }}

                                        —

                                        {{ $lease->unit->unit_number ?? 'Unit' }}

                                    </option>

                                @endforeach

                            </select>

                            @error('lease_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Payment Date --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Payment Date
                                <span class="text-danger">*</span>
                            </label>

                            <input type="date"
                                   name="payment_date"
                                   class="form-control @error('payment_date') is-invalid @enderror"
                                   value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                                   required>

                            @error('payment_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Amount --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Amount
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <input type="number"
                                       name="amount"
                                       id="payment_amount"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       min="0.01"
                                       step="0.01"
                                       value="{{ old('amount') }}"
                                       required>

                                <span class="input-group-text">
                                    RWF
                                </span>

                            </div>

                            @error('amount')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Payment Method --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Payment Method
                                <span class="text-danger">*</span>
                            </label>

                            <select name="payment_method"
                                    class="form-select @error('payment_method') is-invalid @enderror"
                                    required>

                                <option value="">
                                    Select payment method
                                </option>

                                <option value="cash"
                                    @selected(old('payment_method') === 'cash')>
                                    Cash
                                </option>

                                <option value="bank_transfer"
                                    @selected(old('payment_method') === 'bank_transfer')>
                                    Bank Transfer
                                </option>

                                <option value="mobile_money"
                                    @selected(old('payment_method') === 'mobile_money')>
                                    Mobile Money
                                </option>

                                <option value="card"
                                    @selected(old('payment_method') === 'card')>
                                    Card
                                </option>

                                <option value="payment_gateway"
                                    @selected(old('payment_method') === 'payment_gateway')>
                                    Payment Gateway
                                </option>

                                <option value="other"
                                    @selected(old('payment_method') === 'other')>
                                    Other
                                </option>

                            </select>

                            @error('payment_method')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Currency --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Currency
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="RWF"
                                   readonly>

                            <small class="text-muted">
                                Payments are recorded in Rwandan Francs.
                            </small>

                        </div>


                        {{-- Transaction Reference --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Transaction Reference
                            </label>

                            <input type="text"
                                   name="transaction_id"
                                   class="form-control @error('transaction_id') is-invalid @enderror"
                                   value="{{ old('transaction_id') }}"
                                   placeholder="e.g. MTN / Airtel / Bank transaction ID">

                            @error('transaction_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Provider --}}
                        <div class="col-md-6">

                            <label class="form-label">
                                Provider
                            </label>

                            <input type="text"
                                   name="provider"
                                   class="form-control @error('provider') is-invalid @enderror"
                                   value="{{ old('provider') }}"
                                   placeholder="e.g. MTN Mobile Money">

                            @error('provider')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="col-12">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="3">{{ old('description') }}</textarea>

                            @error('description')
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

                            <textarea name="notes"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      rows="3">{{ old('notes') }}</textarea>

                            @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- Invoice Allocation --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0 p-4">

                    <h5 class="mb-1">
                        Allocate Payment
                    </h5>

                    <p class="text-muted mb-0">
                        Apply the payment to outstanding invoices.
                    </p>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th width="50">Select</th>
                                <th>Invoice</th>
                                <th>Due Date</th>
                                <th>Outstanding</th>
                                <th width="180">Allocation</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($invoices as $invoice)

                                <tr
                                    data-invoice-tenant="{{ $invoice->tenant_id }}"
                                    data-invoice-lease="{{ $invoice->lease_id }}"
                                    data-invoice-unit="{{ $invoice->unit_id }}"
                                    class="invoice-row">

                                    <td>

                                        <input type="checkbox"
                                               class="form-check-input invoice-check"
                                               value="{{ $invoice->id }}"
                                               data-balance="{{ $invoice->balance }}">

                                    </td>

                                    <td>

                                        <div class="fw-semibold">
                                            {{ $invoice->invoice_number }}
                                        </div>

                                        <small class="text-muted">
                                            {{ ucfirst(str_replace('_', ' ', $invoice->invoice_type)) }}
                                        </small>

                                    </td>

                                    <td>
                                        {{ $invoice->due_date?->format('d M Y') }}
                                    </td>

                                    <td>

                                        <span class="fw-semibold">
                                            {{ number_format($invoice->balance, 0) }}
                                            RWF
                                        </span>

                                    </td>

                                    <td>

                                        <input type="number"
                                               name="allocations[{{ $invoice->id }}][amount]"
                                               class="form-control allocation-input"
                                               min="0"
                                               step="0.01"
                                               max="{{ $invoice->balance }}"
                                               value="0"
                                               disabled>

                                        <input type="hidden"
                                               name="allocations[{{ $invoice->id }}][rent_invoice_id]"
                                               value="{{ $invoice->id }}"
                                               disabled>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="text-center text-muted py-5">

                                        There are no outstanding invoices.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="card-footer bg-white p-4">

                    <div class="row justify-content-end">

                        <div class="col-md-5">

                            <div class="d-flex justify-content-between mb-2">

                                <span>
                                    Payment Amount
                                </span>

                                <strong id="paymentTotal">
                                    0 RWF
                                </strong>

                            </div>

                            <div class="d-flex justify-content-between mb-2">

                                <span>
                                    Allocated
                                </span>

                                <strong id="allocatedTotal">
                                    0 RWF
                                </strong>

                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">

                                <span>
                                    Remaining
                                </span>

                                <strong id="remainingTotal">
                                    0 RWF
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Summary --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h5 class="mb-3">
                        Payment Summary
                    </h5>

                    <p class="text-muted small">
                        Record the payment and optionally allocate it
                        to the tenant's outstanding invoices.
                    </p>

                    <div class="alert alert-light border">

                        <div class="small text-muted">
                            Payment amount
                        </div>

                        <div class="fs-4 fw-bold"
                             id="summaryAmount">
                            0 RWF
                        </div>

                    </div>

                    @error('allocations')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror

                    <button type="submit"
                            class="btn btn-terra w-100">

                        <i class="bi bi-check2-circle me-1"></i>

                        Confirm Payment

                    </button>

                    <a href="{{ route('property-management.payments.index') }}"
                       class="btn btn-outline-secondary w-100 mt-2">

                        Cancel

                    </a>

                </div>

            </div>

        </div>

    </div>

</form>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const tenantSelect =
        document.getElementById('tenant_id');

    const leaseSelect =
        document.getElementById('lease_id');

    const unitInput =
        document.getElementById('unit_id');

    const amountInput =
        document.getElementById('payment_amount');

    const paymentTotal =
        document.getElementById('paymentTotal');

    const allocatedTotal =
        document.getElementById('allocatedTotal');

    const remainingTotal =
        document.getElementById('remainingTotal');

    const summaryAmount =
        document.getElementById('summaryAmount');


    /*
    |--------------------------------------------------------------------------
    | Format money
    |--------------------------------------------------------------------------
    */

    function money(value) {

        return Number(value || 0)
            .toLocaleString('en-US') + ' RWF';

    }


    /*
    |--------------------------------------------------------------------------
    | Update totals
    |--------------------------------------------------------------------------
    */

    function updateTotals() {

        let allocated = 0;

        document
            .querySelectorAll('.allocation-input')
            .forEach(input => {

                if (!input.disabled) {

                    allocated += Number(
                        input.value || 0
                    );

                }

            });


        const payment =
            Number(amountInput.value || 0);


        const remaining =
            payment - allocated;


        paymentTotal.textContent =
            money(payment);

        allocatedTotal.textContent =
            money(allocated);

        remainingTotal.textContent =
            money(Math.max(0, remaining));

        summaryAmount.textContent =
            money(payment);

    }


    /*
    |--------------------------------------------------------------------------
    | Update unit from selected lease
    |--------------------------------------------------------------------------
    */

    function updateUnitFromLease() {

        const selectedOption =
            leaseSelect.options[
                leaseSelect.selectedIndex
            ];

        if (
            selectedOption &&
            selectedOption.value
        ) {

            unitInput.value =
                selectedOption.dataset.unit || '';

        } else {

            unitInput.value = '';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Filter invoices
    |--------------------------------------------------------------------------
    */

    function filterInvoices() {

        const tenantId =
            tenantSelect.value;

        const leaseId =
            leaseSelect.value;

        const unitId =
            unitInput.value;


        document
            .querySelectorAll('.invoice-row')
            .forEach(row => {

                const invoiceTenant =
                    row.dataset.invoiceTenant;

                const invoiceLease =
                    row.dataset.invoiceLease;

                const invoiceUnit =
                    row.dataset.invoiceUnit;


                const tenantMatches =
                    !tenantId ||
                    invoiceTenant === tenantId;

                const leaseMatches =
                    !leaseId ||
                    invoiceLease === leaseId;

                const unitMatches =
                    !unitId ||
                    invoiceUnit === unitId;


                if (
                    tenantMatches &&
                    leaseMatches &&
                    unitMatches
                ) {

                    row.style.display = '';

                } else {

                    row.style.display = 'none';


                    const checkbox =
                        row.querySelector(
                            '.invoice-check'
                        );

                    const amount =
                        row.querySelector(
                            '.allocation-input'
                        );

                    const hidden =
                        row.querySelector(
                            'input[type="hidden"]'
                        );


                    checkbox.checked = false;

                    amount.disabled = true;

                    amount.value = 0;

                    hidden.disabled = true;

                }

            });


        updateTotals();

    }


    /*
    |--------------------------------------------------------------------------
    | Tenant changed
    |--------------------------------------------------------------------------
    */

    tenantSelect.addEventListener(
        'change',
        function () {

            /*
             * Reset lease when tenant changes
             */
            const tenantId =
                this.value;

            Array.from(
                leaseSelect.options
            ).forEach(option => {

                if (!option.value) {
                    option.hidden = false;
                    return;
                }

                option.hidden =
                    option.dataset.tenant !== tenantId;

            });


            /*
             * Clear current lease
             * if it does not belong to tenant
             */
            const selected =
                leaseSelect.options[
                    leaseSelect.selectedIndex
                ];

            if (
                selected &&
                selected.value &&
                selected.dataset.tenant !== tenantId
            ) {

                leaseSelect.value = '';

                unitInput.value = '';

            }


            updateUnitFromLease();

            filterInvoices();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Lease changed
    |--------------------------------------------------------------------------
    */

    leaseSelect.addEventListener(
        'change',
        function () {

            updateUnitFromLease();

            filterInvoices();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Payment amount changed
    |--------------------------------------------------------------------------
    */

    amountInput.addEventListener(
        'input',
        updateTotals
    );


    /*
    |--------------------------------------------------------------------------
    | Invoice checkbox
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.invoice-check')
        .forEach(checkbox => {

            checkbox.addEventListener(
                'change',
                function () {

                    const row =
                        this.closest(
                            '.invoice-row'
                        );

                    const input =
                        row.querySelector(
                            '.allocation-input'
                        );

                    const hidden =
                        row.querySelector(
                            'input[type="hidden"]'
                        );


                    input.disabled =
                        !this.checked;

                    hidden.disabled =
                        !this.checked;


                    if (
                        this.checked &&
                        !input.value
                    ) {

                        input.value =
                            Math.min(
                                Number(
                                    this.dataset.balance
                                ),
                                Number(
                                    amountInput.value || 0
                                )
                            );

                    }


                    if (!this.checked) {

                        input.value = 0;

                    }


                    updateTotals();

                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Allocation inputs
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.allocation-input')
        .forEach(input => {

            input.addEventListener(
                'input',
                updateTotals
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Initial state
    |--------------------------------------------------------------------------
    */

    updateUnitFromLease();

    filterInvoices();

    updateTotals();

});

</script>

@endpush