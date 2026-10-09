@extends('layouts.property-management')

@section('title', 'Pay Invoice')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <a href="{{ route('tenant-portal.payments.index') }}"
           class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to My Payments
        </a>

        <h1 class="h3 fw-bold mt-3 mb-1">Submit a Payment</h1>
        <p class="text-muted mb-0">
            Submit your payment details for verification.
        </p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please correct the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Invoice Summary</h5>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <div class="small text-muted">Invoice Number</div>
                        <div class="fw-semibold">
                            {{ $invoice->invoice_number }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted">Description</div>
                        <div>{{ $invoice->description }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="small text-muted">Due Date</div>
                        <div>
                            {{ $invoice->due_date?->format('d M Y') ?? '—' }}
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Invoice Amount</span>
                        <span class="fw-semibold">
                            {{ number_format((float) $invoice->amount, 0) }} RWF
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Already Paid</span>
                        <span>
                            {{ number_format((float) $invoice->paid_amount, 0) }} RWF
                        </span>
                    </div>

                    <div class="d-flex justify-content-between pt-2">
                        <span class="fw-bold">Outstanding Balance</span>
                        <span class="fw-bold text-primary fs-5">
                            {{ number_format((float) $invoice->balance, 0) }} RWF
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0">Payment Details</h5>
                </div>

                <div class="card-body">
                    <form method="POST"
                          action="{{ route('tenant-portal.payments.store', ['invoice' => $invoice->id]) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="amount" class="form-label fw-semibold">
                                Amount (RWF)
                            </label>

                            <input type="number"
                                   id="amount"
                                   name="amount"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   min="1"
                                   max="{{ $invoice->balance }}"
                                   step="0.01"
                                   value="{{ old('amount', $invoice->balance) }}"
                                   required>

                            <div class="form-text">
                                You can make a partial payment or pay the full outstanding balance.
                            </div>

                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label fw-semibold">
                                Payment Method
                            </label>

                            <select id="payment_method"
                                    name="payment_method"
                                    class="form-select"
                                    required>
                                <option value="">Select payment method</option>
                                <option value="mobile_money"
                                    @selected(old('payment_method') === 'mobile_money')>
                                    Mobile Money
                                </option>
                                <option value="bank_transfer"
                                    @selected(old('payment_method') === 'bank_transfer')>
                                    Bank Transfer
                                </option>
                                <option value="cash"
                                    @selected(old('payment_method') === 'cash')>
                                    Cash
                                </option>
                                <option value="card"
                                    @selected(old('payment_method') === 'card')>
                                    Card
                                </option>
                                <option value="other"
                                    @selected(old('payment_method') === 'other')>
                                    Other
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="provider" class="form-label fw-semibold">
                                Provider / Bank
                            </label>

                            <input type="text"
                                   id="provider"
                                   name="provider"
                                   class="form-control"
                                   placeholder="e.g. MTN MoMo, Airtel Money, Bank of Kigali"
                                   value="{{ old('provider') }}">
                        </div>

                        <div class="mb-3">
                            <label for="transaction_id" class="form-label fw-semibold">
                                Transaction Reference
                            </label>

                            <input type="text"
                                   id="transaction_id"
                                   name="transaction_id"
                                   class="form-control"
                                   placeholder="Enter your transaction reference, if available"
                                   value="{{ old('transaction_id') }}">
                        </div>

                        <div class="mb-3">
                            <label for="payment_date" class="form-label fw-semibold">
                                Payment Date
                            </label>

                            <input type="date"
                                   id="payment_date"
                                   name="payment_date"
                                   class="form-control"
                                   value="{{ old('payment_date', today()->toDateString()) }}"
                                   max="{{ today()->toDateString() }}"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">
                                Additional Notes
                            </label>

                            <textarea id="notes"
                                      name="notes"
                                      class="form-control"
                                      rows="3"
                                      placeholder="Optional payment details">{{ old('notes') }}</textarea>
                        </div>

                        <div class="alert alert-info small">
                            Submitting these details does not confirm that money has been received.
                            Your payment will remain pending until it is verified.
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>
                                Submit Payment
                            </button>

                            <a href="{{ route('tenant-portal.payments.index') }}"
                               class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection