@php
    $isEdit = $expense->exists;
@endphp

<form method="POST"
      enctype="multipart/form-data"
      action="{{ $isEdit
          ? route('admin.property-management.expenses.update', $expense)
          : route('admin.property-management.expenses.store') }}">
    @csrf

    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-12">
            <h6 class="fw-bold">Property Details</h6>
            <hr>
        </div>

        <div class="col-md-6">
            <label for="managed_property_id" class="form-label">Managed Property *</label>
            <select name="managed_property_id" id="managed_property_id"
                    class="form-select @error('managed_property_id') is-invalid @enderror"
                    required>
                <option value="">Select property</option>
                @foreach($properties as $property)
                    <option value="{{ $property->id }}"
                        @selected(old('managed_property_id', $expense->managed_property_id) == $property->id)>
                        {{ $property->name }} ({{ $property->property_code }})
                    </option>
                @endforeach
            </select>
            @error('managed_property_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="unit_id" class="form-label">Unit (Optional)</label>
            <select name="unit_id" id="unit_id"
                    class="form-select @error('unit_id') is-invalid @enderror">
                <option value="">Property-wide expense</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}"
                            data-property="{{ $unit->managed_property_id }}"
                        @selected(old('unit_id', $expense->unit_id) == $unit->id)>
                        {{ $unit->managedProperty?->name }}
                        — Unit {{ $unit->unit_number }}
                    </option>
                @endforeach
            </select>
            @error('unit_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Only select a unit when the expense relates to a specific unit.</div>
        </div>

        <div class="col-12">
            <h6 class="fw-bold mt-2">Expense Information</h6>
            <hr>
        </div>

        <div class="col-md-6">
            <label for="category" class="form-label">Category *</label>
            <input type="text" name="category" id="category" list="expense-categories"
                   class="form-control @error('category') is-invalid @enderror"
                   value="{{ old('category', $expense->category) }}"
                   placeholder="e.g. Repairs and Maintenance" maxlength="100" required>
            <datalist id="expense-categories">
                @foreach([
                    'Repairs and Maintenance',
                    'Utilities',
                    'Cleaning',
                    'Security',
                    'Insurance',
                    'Property Taxes',
                    'Landscaping',
                    'Management Fees',
                    'Supplies',
                    'Other',
                ] as $category)
                    <option value="{{ $category }}">
                @endforeach
            </datalist>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="expense_date" class="form-label">Expense Date *</label>
            <input type="date" name="expense_date" id="expense_date"
                   class="form-control @error('expense_date') is-invalid @enderror"
                   value="{{ old('expense_date', $expense->expense_date?->format('Y-m-d')) }}"
                   required>
            @error('expense_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="amount" class="form-label">Amount *</label>
            <input type="number" name="amount" id="amount" min="0.01" step="0.01"
                   class="form-control @error('amount') is-invalid @enderror"
                   value="{{ old('amount', $expense->amount) }}" required>
            @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="currency" class="form-label">Currency *</label>
            <select name="currency" id="currency"
                    class="form-select @error('currency') is-invalid @enderror" required>
                <option value="RWF"
                    @selected(old('currency', $expense->currency ?? 'RWF') === 'RWF')>RWF</option>
                <option value="USD"
                    @selected(old('currency', $expense->currency) === 'USD')>USD</option>
            </select>
            @error('currency')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="vendor_name" class="form-label">Vendor / Supplier</label>
            <input type="text" name="vendor_name" id="vendor_name"
                   class="form-control @error('vendor_name') is-invalid @enderror"
                   value="{{ old('vendor_name', $expense->vendor_name) }}"
                   maxlength="255">
            @error('vendor_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="receipt" class="form-label">Receipt or Supporting Document</label>
            <input type="file" name="receipt" id="receipt"
                   accept=".pdf,.jpg,.jpeg,.png"
                   class="form-control @error('receipt') is-invalid @enderror">
            <div class="form-text">PDF, JPG, or PNG; maximum 5 MB.</div>
            @error('receipt')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if($expense->receipt_path)
                <div class="small mt-2">
                    A receipt is already attached.
                </div>
            @endif
        </div>

        <div class="col-12">
            <label for="description" class="form-label">Description *</label>
            <textarea name="description" id="description" rows="3"
                      class="form-control @error('description') is-invalid @enderror"
                      maxlength="2000" required>{{ old('description', $expense->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12">
            <label for="notes" class="form-label">Internal Notes</label>
            <textarea name="notes" id="notes" rows="3"
                      class="form-control @error('notes') is-invalid @enderror"
                      maxlength="5000">{{ old('notes', $expense->notes) }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <a href="{{ $isEdit
            ? route('admin.property-management.expenses.show', $expense)
            : route('admin.property-management.expenses.index') }}"
           class="btn btn-light border">Cancel</a>

        <button type="submit" class="btn btn-primary">
            {{ $isEdit ? 'Save Changes' : 'Record Expense' }}
        </button>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const propertySelect = document.getElementById('managed_property_id');
    const unitSelect = document.getElementById('unit_id');

    function filterUnits() {
        const propertyId = propertySelect.value;
        const selectedOption = unitSelect.options[unitSelect.selectedIndex];

        if (
            selectedOption &&
            selectedOption.value &&
            selectedOption.dataset.property !== propertyId
        ) {
            unitSelect.value = '';
        }

        Array.from(unitSelect.options).forEach(function (option) {
            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = option.dataset.property !== propertyId;
        });
    }

    propertySelect.addEventListener('change', filterUnits);
    filterUnits();
});
</script>
@endpush