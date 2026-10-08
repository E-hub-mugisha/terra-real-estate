@extends('layouts.property-management')

@section('title', 'Edit Invoice')

@section('page-title', 'Edit Invoice')

@section('page-subtitle', $invoice->invoice_number)

@section('breadcrumb')

    <li class="breadcrumb-item">
        <a href="{{ route('property-management.invoices.index') }}">
            Rent Invoices
        </a>
    </li>

    <li class="breadcrumb-item">

        <a href="{{ route(
            'property-management.invoices.show',
            $invoice
        ) }}">
            {{ $invoice->invoice_number }}
        </a>

    </li>

    <li class="breadcrumb-item active">
        Edit
    </li>

@endsection

@section('content')

<form
    method="POST"
    action="{{ route(
        'property-management.invoices.update',
        $invoice
    ) }}"
>

    @csrf
    @method('PUT')

    <div class="row g-4">

        <div class="col-xl-8">

            <div class="terra-card">

                <div class="terra-card-header">

                    <div>

                        <h5>Edit Invoice</h5>

                        <small class="text-muted">
                            {{ $invoice->invoice_number }}
                        </small>

                    </div>

                    <span class="badge rounded-pill badge-info-soft">
                        {{ ucwords(
                            str_replace(
                                '_',
                                ' ',
                                $invoice->invoice_type
                            )
                        ) }}
                    </span>

                </div>


                <div class="terra-card-body">

                    <div class="row g-3">

                        <div class="col-12">

                            <label class="form-label">
                                Description
                            </label>

                            <input
                                type="text"
                                name="description"
                                value="{{ old(
                                    'description',
                                    $invoice->description
                                ) }}"
                                class="form-control @error('description') is-invalid @enderror"
                                required
                            >

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Billing Period Start
                            </label>

                            <input
                                type="date"
                                name="billing_period_start"
                                value="{{ old(
                                    'billing_period_start',
                                    $invoice->billing_period_start?->format('Y-m-d')
                                ) }}"
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
                                value="{{ old(
                                    'billing_period_end',
                                    $invoice->billing_period_end?->format('Y-m-d')
                                ) }}"
                                class="form-control @error('billing_period_end') is-invalid @enderror"
                            >

                            @error('billing_period_end')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Issue Date
                            </label>

                            <input
                                type="date"
                                name="issue_date"
                                value="{{ old(
                                    'issue_date',
                                    $invoice->issue_date?->format('Y-m-d')
                                ) }}"
                                class="form-control @error('issue_date') is-invalid @enderror"
                                required
                            >

                            @error('issue_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Due Date
                            </label>

                            <input
                                type="date"
                                name="due_date"
                                value="{{ old(
                                    'due_date',
                                    $invoice->due_date?->format('Y-m-d')
                                ) }}"
                                class="form-control @error('due_date') is-invalid @enderror"
                                required
                            >

                            @error('due_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Amount (RWF)
                            </label>

                            <input
                                type="number"
                                name="amount"
                                value="{{ old(
                                    'amount',
                                    $invoice->amount
                                ) }}"
                                min="0.01"
                                step="0.01"
                                class="form-control @error('amount') is-invalid @enderror"
                                required
                            >

                            @error('amount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="col-12">

                            <label class="form-label">
                                Notes
                            </label>

                            <textarea
                                name="notes"
                                rows="4"
                                class="form-control @error('notes') is-invalid @enderror"
                            >{{ old(
                                'notes',
                                $invoice->notes
                            ) }}</textarea>

                            @error('notes')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            <div class="d-flex justify-content-end gap-2 mt-4">

                <a
                    href="{{ route(
                        'property-management.invoices.show',
                        $invoice
                    ) }}"
                    class="btn btn-light border"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-terra"
                >
                    <i class="bi bi-check-lg me-1"></i>
                    Save Changes
                </button>

            </div>

        </div>


        <div class="col-xl-4">

            <div class="terra-card">

                <div class="terra-card-header">
                    <h5>Current Balance</h5>
                </div>

                <div class="terra-card-body">

                    <small class="text-muted">
                        Invoice Amount
                    </small>

                    <div class="fs-4 fw-bold">
                        RWF {{ number_format($invoice->amount, 0) }}
                    </div>

                    <hr>

                    <small class="text-muted">
                        Paid
                    </small>

                    <div class="fw-semibold text-success">
                        RWF {{ number_format($invoice->paid_amount, 0) }}
                    </div>

                    <hr>

                    <small class="text-muted">
                        Outstanding
                    </small>

                    <div class="fs-5 fw-bold text-danger">
                        RWF {{ number_format($invoice->balance, 0) }}
                    </div>

                    @if($invoice->paid_amount > 0)

                        <div class="alert alert-warning mt-4 mb-0">

                            <small>
                                This invoice already has payments.
                                Its amount should not be reduced below
                                the amount already paid.
                            </small>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</form>

@endsection