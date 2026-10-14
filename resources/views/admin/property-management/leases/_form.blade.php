@php
    $isEdit = $lease->exists;
@endphp

<form method="POST"
      action="{{ $isEdit
          ? route('admin.property-management.leases.update', $lease)
          : route('admin.property-management.leases.store') }}">
    @csrf

    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-12">
            <h6 class="fw-bold mb-0">Tenant and Unit</h6>
            <hr>
        </div>

        <div class="col-md-6">
            <label for="tenant_id" class="form-label">Tenant *</label>
            <select name="tenant_id" id="tenant_id"
                    class="form-select @error('tenant_id') is-invalid @enderror"
                    required>
                <option value="">Select tenant</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}"
                        @selected(old('tenant_id', $lease->tenant_id) == $tenant->id)>
                        {{ $tenant->first_name }} {{ $tenant->last_name }}
                        — {{ $tenant->tenant_code }}
                    </option>
                @endforeach
            </select>
            @error('tenant_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="unit_id" class="form-label">Property Unit *</label>
            <select name="unit_id" id="unit_id"
                    class="form-select @error('unit_id') is-invalid @enderror"
                    required>
                <option value="">Select unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}"
                            data-rent="{{ $unit->monthly_rent }}"
                            data-currency="{{ $unit->currency }}"
                        @selected(old('unit_id', $lease->unit_id) == $unit->id)>
                        {{ $unit->managedProperty->name ?? 'Property' }}
                        — Unit {{ $unit->unit_number }}
                        ({{ ucfirst($unit->status) }})
                    </option>
                @endforeach
            </select>
            @error('unit_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 mt-4">
            <h6 class="fw-bold mb-0">Lease Period</h6>
            <hr>
        </div>

        <div class="col-md-6">
            <label for="start_date" class="form-label">Start Date *</label>
            <input type="date" id="start_date" name="start_date"
                   class="form-control @error('start_date') is-invalid @enderror"
                   value="{{ old('start_date', $lease->start_date?->format('Y-m-d')) }}"
                   required>
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="end_date" class="form-label">End Date *</label>
            <input type="date" id="end_date" name="end_date"
                   class="form-control @error('end_date') is-invalid @enderror"
                   value="{{ old('end_date', $lease->end_date?->format('Y-m-d')) }}"
                   required>
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="monthly_rent" class="form-label">Monthly Rent *</label>
            <input type="number" id="monthly_rent" name="monthly_rent"
                   min="0" step="0.01"
                   class="form-control @error('monthly_rent') is-invalid @enderror"
                   value="{{ old('monthly_rent', $lease->monthly_rent) }}"
                   required>
            @error('monthly_rent')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="security_deposit" class="form-label">Security Deposit</label>
            <input type="number" id="security_deposit" name="security_deposit"
                   min="0" step="0.01"
                   class="form-control @error('security_deposit') is-invalid @enderror"
                   value="{{ old('security_deposit', $lease->security_deposit ?? 0) }}">
            @error('security_deposit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="currency" class="form-label">Currency *</label>
            <select name="currency" id="currency" class="form-select" required>
                <option value="RWF" @selected(old('currency', $lease->currency ?? 'RWF') === 'RWF')>
                    RWF
                </option>
                <option value="USD" @selected(old('currency', $lease->currency) === 'USD')>
                    USD
                </option>
            </select>
            @error('currency')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4">
            <label for="rent_due_day" class="form-label">Rent Due Day *</label>
            <input type="number" id="rent_due_day" name="rent_due_day"
                   min="1" max="31"
                   class="form-control @error('rent_due_day') is-invalid @enderror"
                   value="{{ old('rent_due_day', $lease->rent_due_day ?? 1) }}"
                   required>
            @error('rent_due_day')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Day of the month rent is due.</div>
        </div>

        <div class="col-md-4">
            <label for="payment_frequency" class="form-label">Payment Frequency *</label>
            <select name="payment_frequency" id="payment_frequency"
                    class="form-select" required>
                @foreach(['monthly' => 'Monthly', 'weekly' => 'Weekly',
                    'quarterly' => 'Quarterly', 'annually' => 'Annually'] as $value => $label)
                    <option value="{{ $value }}"
                        @selected(old('payment_frequency', $lease->payment_frequency ?? 'monthly') === $value)>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('payment_frequency')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label for="terms" class="form-label">Lease Terms and Conditions</label>
            <textarea name="terms" id="terms" rows="5"
                      class="form-control @error('terms') is-invalid @enderror"
                      placeholder="Enter any additional lease terms...">{{ old('terms', $lease->terms) }}</textarea>
            @error('terms')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ $isEdit
            ? route('admin.property-management.leases.show', $lease)
            : route('admin.property-management.leases.index') }}"
           class="btn btn-light border">
            Cancel
        </a>

        <button type="submit" class="btn btn-primary">
            {{ $isEdit ? 'Save Changes' : 'Create Draft Lease' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const unitSelect = document.getElementById('unit_id');
        const rentInput = document.getElementById('monthly_rent');
        const currencySelect = document.getElementById('currency');

        unitSelect?.addEventListener('change', function () {
            const option = this.options[this.selectedIndex];

            if (option?.dataset.rent !== undefined && option.dataset.rent !== '') {
                rentInput.value = option.dataset.rent;
            }

            if (option?.dataset.currency) {
                currencySelect.value = option.dataset.currency;
            }
        });
    });
</script>
@endpush