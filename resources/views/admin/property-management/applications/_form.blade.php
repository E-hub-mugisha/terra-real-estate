@if ($errors->any())
    <div class="alert alert-danger">
        <div class="fw-semibold mb-1">Please correct the following errors:</div>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <h2 class="h5 fw-bold mb-3">Application Details</h2>

        @if ($application->exists)
            <div class="alert alert-light border">
                <span class="text-muted">Application reference:</span>
                <strong>{{ $application->application_number }}</strong>
            </div>
        @endif

        <div class="row g-3">
            <div class="col-md-6">
                <label for="tenant_id" class="form-label">
                    Tenant <span class="text-danger">*</span>
                </label>

                <select name="tenant_id" id="tenant_id"
                        class="form-select @error('tenant_id') is-invalid @enderror"
                        required>
                    <option value="">Select tenant</option>
                    @foreach ($tenants as $tenant)
                        <option value="{{ $tenant->id }}"
                            @selected((string) old('tenant_id', $application->tenant_id) === (string) $tenant->id)>
                            {{ $tenant->full_name }} — {{ $tenant->tenant_code }}
                        </option>
                    @endforeach
                </select>

                @error('tenant_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="unit_id" class="form-label">
                    Available Unit <span class="text-danger">*</span>
                </label>

                <select name="unit_id" id="unit_id"
                        class="form-select @error('unit_id') is-invalid @enderror"
                        required>
                    <option value="">Select unit</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}"
                                data-rent="{{ $unit->monthly_rent }}"
                                data-currency="{{ $unit->currency }}"
                            @selected((string) old('unit_id', $application->unit_id) === (string) $unit->id)>
                            {{ $unit->unit_number }}
                            — {{ $unit->managedProperty->name ?? 'Property' }}
                            ({{ $unit->status }})
                        </option>
                    @endforeach
                </select>

                @error('unit_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="form-text">
                    The server will verify the unit's availability when saving and approving.
                </div>
            </div>

            <div class="col-md-6">
                <label for="application_date" class="form-label">Application Date</label>
                <input type="date" name="application_date" id="application_date"
                       class="form-control @error('application_date') is-invalid @enderror"
                       value="{{ old('application_date', $application->application_date?->format('Y-m-d') ?? now()->toDateString()) }}">
                @error('application_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="desired_move_in_date" class="form-label">
                    Desired Move-in Date <span class="text-danger">*</span>
                </label>
                <input type="date" name="desired_move_in_date" id="desired_move_in_date"
                       class="form-control @error('desired_move_in_date') is-invalid @enderror"
                       value="{{ old('desired_move_in_date', $application->desired_move_in_date?->format('Y-m-d')) }}"
                       required>
                @error('desired_move_in_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="number_of_occupants" class="form-label">
                    Number of Occupants <span class="text-danger">*</span>
                </label>
                <input type="number" min="1" max="100"
                       name="number_of_occupants" id="number_of_occupants"
                       class="form-control @error('number_of_occupants') is-invalid @enderror"
                       value="{{ old('number_of_occupants', $application->number_of_occupants ?? 1) }}"
                       required>
                @error('number_of_occupants')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="offered_monthly_rent" class="form-label">
                    Offered Monthly Rent <span class="text-danger">*</span>
                </label>
                <input type="number" min="0" step="0.01"
                       name="offered_monthly_rent" id="offered_monthly_rent"
                       class="form-control @error('offered_monthly_rent') is-invalid @enderror"
                       value="{{ old('offered_monthly_rent', $application->offered_monthly_rent) }}"
                       required>
                @error('offered_monthly_rent')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="currency" class="form-label">
                    Currency <span class="text-danger">*</span>
                </label>
                <select name="currency" id="currency"
                        class="form-select @error('currency') is-invalid @enderror"
                        required>
                    <option value="RWF"
                        @selected(old('currency', $application->currency ?? 'RWF') === 'RWF')>
                        RWF — Rwandan Franc
                    </option>
                    <option value="USD"
                        @selected(old('currency', $application->currency ?? 'RWF') === 'USD')>
                        USD — US Dollar
                    </option>
                </select>
                @error('currency')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="employment_status" class="form-label">Employment Status</label>
                <select name="employment_status" id="employment_status"
                        class="form-select @error('employment_status') is-invalid @enderror">
                    <option value="">Select employment status</option>
                    @foreach (['employed', 'self_employed', 'unemployed', 'student', 'retired', 'other'] as $employment)
                        <option value="{{ $employment }}"
                            @selected(old('employment_status', $application->employment_status) === $employment)>
                            {{ ucwords(str_replace('_', ' ', $employment)) }}
                        </option>
                    @endforeach
                </select>
                @error('employment_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="additional_information" class="form-label">
                    Additional Information
                </label>
                <textarea name="additional_information" id="additional_information"
                          rows="4"
                          class="form-control @error('additional_information') is-invalid @enderror"
                          placeholder="Additional information provided with the application">{{ old('additional_information', $application->additional_information) }}</textarea>
                @error('additional_information')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="card-footer bg-white p-3 d-flex justify-content-between">
        <a href="{{ $application->exists
            ? route('admin.property-management.applications.show', $application)
            : route('admin.property-management.applications.index') }}"
           class="btn btn-outline-secondary">Cancel</a>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i>
            {{ $application->exists ? 'Save Changes' : 'Create Application' }}
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitSelect = document.getElementById('unit_id');
    const rentInput = document.getElementById('offered_monthly_rent');
    const currencySelect = document.getElementById('currency');

    unitSelect.addEventListener('change', function () {
        const option = this.options[this.selectedIndex];

        if (option && option.dataset.rent !== undefined) {
            rentInput.value = option.dataset.rent;
            currencySelect.value = option.dataset.currency || 'RWF';
        }
    });
});
</script>