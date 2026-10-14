@php
    $isEdit = $payment->exists;
@endphp

<form method="POST"
      action="{{ $isEdit
          ? route('admin.property-management.payments.update', $payment)
          : route('admin.property-management.payments.store') }}">
    @csrf

    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-12">
            <h6 class="fw-bold">Lease Information</h6>
            <hr>
        </div>

        <div class="col-12">
            <label for="lease_id" class="form-label">Lease *</label>
            <select name="lease_id" id="lease_id"
                    class="form-select @error('lease_id') is-invalid @enderror"
                    required>
                <option value="">Select lease</option>
                @foreach($leases as $lease)
                    <option value="{{ $lease->id }}"
                        data-currency="{{ $lease->currency }}"
                        @selected(old('lease_id', $payment->lease_id) == $lease->id)>
                        {{ $lease->lease_number }}
                        — {{ $lease->tenant?->first_name }}
                        {{ $lease->tenant?->last_name }}
                        — Unit {{ $lease->unit?->unit_number }}
                        — {{ $lease->currency }}
                        {{ number_format((float) $lease->monthly_rent, 2) }}
                    </option>
                @endforeach
            </select>
            @error('lease_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">
                Draft leases cannot receive payments.
            </div>
        </div>

        <div class="col-12">
            <h6 class="fw-bold mt-2">Payment Details</h6>
            <hr>
        </div>

        <div class="col-md-6">
            <label for="amount" class="form-label">Amount Received *</label>
            <input type="number" name="amount" id="amount"
                   class="form-control @error('amount') is-invalid @enderror"
                   min="0.01" step="0.01"
                   value="{{ old('amount', $payment->amount) }}" required>
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="currency" class="form-label">Currency *</label>
            <select name="currency" id="currency"
                    class="form-select @error('currency') is-invalid @enderror"
                    required>
                <option value="RWF" @selected(old('currency', $payment->currency ?? 'RWF') === 'RWF')>RWF</option>
                <option value="USD" @selected(old('currency', $payment->currency) === 'USD')>USD</option>
            </select>
            @error('currency')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="payment_date" class="form-label">Payment Date *</label>
            <input type="date" name="payment_date" id="payment_date"
                   class="form-control @error('payment_date') is-invalid @enderror"
                   value="{{ old('payment_date', $payment->payment_date?->format('Y-m-d')) }}"
                   required>
            @error('payment_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="payment_method" class="form-label">Payment Method *</label>
            <select name="payment_method" id="payment_method"
                    class="form-select" required>
                @foreach([
                    'mobile_money' => 'Mobile Money',
                    'bank_transfer' => 'Bank Transfer',
                    'cash' => 'Cash',
                    'card' => 'Card',
                    'payment_gateway' => 'Payment Gateway',
                    'other' => 'Other',
                ] as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('payment_method', $payment->payment_method ?? 'mobile_money') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('payment_method')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="payment_type" class="form-label">Payment Type *</label>
            <select name="payment_type" id="payment_type"
                    class="form-select" required>
                @foreach([
                    'rent' => 'Rent',
                    'deposit' => 'Security Deposit',
                    'service_charge' => 'Service Charge',
                    'other' => 'Other',
                ] as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('payment_type', $payment->payment_type ?? 'rent') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('payment_type')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="transaction_reference" class="form-label">
                Transaction Reference
            </label>
            <input type="text" name="transaction_reference"
                   id="transaction_reference"
                   class="form-control @error('transaction_reference') is-invalid @enderror"
                   value="{{ old('transaction_reference', $payment->transaction_reference) }}"
                   maxlength="255">
            @error('transaction_reference')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <h6 class="fw-bold mt-2">Rental Period Covered</h6>
            <hr>
        </div>

        <div class="col-md-6">
            <label for="period_start" class="form-label">Period Start</label>
            <input type="date" name="period_start" id="period_start"
                   class="form-control @error('period_start') is-invalid @enderror"
                   value="{{ old('period_start', $payment->period_start?->format('Y-m-d')) }}">
            @error('period_start')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="period_end" class="form-label">Period End</label>
            <input type="date" name="period_end" id="period_end"
                   class="form-control @error('period_end') is-invalid @enderror"
                   value="{{ old('period_end', $payment->period_end?->format('Y-m-d')) }}">
            @error('period_end')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="status" class="form-label">Payment Status *</label>
            <select name="status" id="status" class="form-select" required>
                @foreach(['pending' => 'Pending', 'completed' => 'Completed', 'failed' => 'Failed'] as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('status', $payment->status ?? 'completed') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
            <div class="form-text">
                Mark a payment completed only after confirming receipt of funds.
            </div>
        </div>

        <div class="col-12">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" rows="4"
                      class="form-control @error('notes') is-invalid @enderror"
                      maxlength="5000">{{ old('notes', $payment->notes) }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ $isEdit
            ? route('admin.property-management.payments.show', $payment)
            : route('admin.property-management.payments.index') }}"
           class="btn btn-light border">Cancel</a>

        <button type="submit" class="btn btn-primary">
            {{ $isEdit ? 'Save Changes' : 'Record Payment' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const leaseSelect = document.getElementById('lease_id');
    const currencySelect = document.getElementById('currency');

    leaseSelect?.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];

        if (selected?.dataset.currency) {
            currencySelect.value = selected.dataset.currency;
        }
    });
});
</script>
@endpush