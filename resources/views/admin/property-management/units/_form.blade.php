@php
    $selectedProperty = old('managed_property_id', $unit->managed_property_id);
    $selectedBuilding = old('building_id', $unit->building_id);
    $selectedFloor = old('floor_id', $unit->floor_id);
@endphp

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
        <h2 class="h5 fw-bold mb-3">Unit Information</h2>

        <div class="row g-3">
            <div class="col-md-6">
                <label for="managed_property_id" class="form-label">
                    Managed Property <span class="text-danger">*</span>
                </label>
                <select name="managed_property_id" id="managed_property_id"
                        class="form-select @error('managed_property_id') is-invalid @enderror"
                        required>
                    <option value="">Select property</option>
                    @foreach ($properties as $property)
                        <option value="{{ $property->id }}"
                            @selected((string) $selectedProperty === (string) $property->id)>
                            {{ $property->name }} ({{ $property->property_code }})
                        </option>
                    @endforeach
                </select>
                @error('managed_property_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="unit_number" class="form-label">
                    Unit Number <span class="text-danger">*</span>
                </label>
                <input type="text" name="unit_number" id="unit_number"
                       class="form-control @error('unit_number') is-invalid @enderror"
                       value="{{ old('unit_number', $unit->unit_number) }}"
                       placeholder="e.g. A-101" required>
                @error('unit_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Unit numbers must be unique within a property.</div>
            </div>

            <div class="col-md-6">
                <label for="building_id" class="form-label">Building</label>
                <select name="building_id" id="building_id"
                        class="form-select @error('building_id') is-invalid @enderror">
                    <option value="">Standalone / no building</option>
                    @foreach ($buildings as $building)
                        <option value="{{ $building->id }}"
                                data-property-id="{{ $building->managed_property_id }}"
                            @selected((string) $selectedBuilding === (string) $building->id)>
                            {{ $building->name }} — {{ $building->managedProperty->name ?? 'Unknown property' }}
                        </option>
                    @endforeach
                </select>
                @error('building_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="floor_id" class="form-label">Floor</label>
                <select name="floor_id" id="floor_id"
                        class="form-select @error('floor_id') is-invalid @enderror">
                    <option value="">No floor selected</option>
                    @foreach ($floors as $floor)
                        <option value="{{ $floor->id }}"
                                data-building-id="{{ $floor->building_id }}"
                            @selected((string) $selectedFloor === (string) $floor->id)>
                            {{ $floor->name }} — {{ $floor->building->name ?? 'Unknown building' }}
                        </option>
                    @endforeach
                </select>
                @error('floor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="unit_type" class="form-label">
                    Unit Type <span class="text-danger">*</span>
                </label>
                <select name="unit_type" id="unit_type"
                        class="form-select @error('unit_type') is-invalid @enderror" required>
                    <option value="">Select type</option>
                    @foreach ([
                        'apartment' => 'Apartment',
                        'house' => 'House',
                        'room' => 'Room',
                        'office' => 'Office',
                        'shop' => 'Shop',
                        'warehouse' => 'Warehouse',
                        'other' => 'Other',
                    ] as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('unit_type', $unit->unit_type) === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('unit_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="bedrooms" class="form-label">Bedrooms</label>
                <input type="number" min="0" name="bedrooms" id="bedrooms"
                       class="form-control @error('bedrooms') is-invalid @enderror"
                       value="{{ old('bedrooms', $unit->bedrooms) }}">
                @error('bedrooms')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label for="bathrooms" class="form-label">Bathrooms</label>
                <input type="number" min="0" name="bathrooms" id="bathrooms"
                       class="form-control @error('bathrooms') is-invalid @enderror"
                       value="{{ old('bathrooms', $unit->bathrooms) }}">
                @error('bathrooms')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="area_sqm" class="form-label">Area (m²)</label>
                <input type="number" min="0" step="0.01" name="area_sqm" id="area_sqm"
                       class="form-control @error('area_sqm') is-invalid @enderror"
                       value="{{ old('area_sqm', $unit->area_sqm) }}">
                @error('area_sqm')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="monthly_rent" class="form-label">
                    Monthly Rent <span class="text-danger">*</span>
                </label>
                <input type="number" min="0" step="0.01" name="monthly_rent"
                       id="monthly_rent"
                       class="form-control @error('monthly_rent') is-invalid @enderror"
                       value="{{ old('monthly_rent', $unit->monthly_rent ?? 0) }}"
                       required>
                @error('monthly_rent')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="security_deposit" class="form-label">Security Deposit</label>
                <input type="number" min="0" step="0.01" name="security_deposit"
                       id="security_deposit"
                       class="form-control @error('security_deposit') is-invalid @enderror"
                       value="{{ old('security_deposit', $unit->security_deposit ?? 0) }}">
                @error('security_deposit')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="currency" class="form-label">
                    Currency <span class="text-danger">*</span>
                </label>
                <select name="currency" id="currency"
                        class="form-select @error('currency') is-invalid @enderror" required>
                    <option value="RWF" @selected(old('currency', $unit->currency ?? 'RWF') === 'RWF')>
                        RWF — Rwandan Franc
                    </option>
                    <option value="USD" @selected(old('currency', $unit->currency ?? 'RWF') === 'USD')>
                        USD — US Dollar
                    </option>
                </select>
                @error('currency')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="status" class="form-label">
                    Status <span class="text-danger">*</span>
                </label>
                <select name="status" id="status"
                        class="form-select @error('status') is-invalid @enderror" required>
                    @foreach ([
                        'available' => 'Available',
                        'reserved' => 'Reserved',
                        'occupied' => 'Occupied',
                        'maintenance' => 'Under Maintenance',
                        'unavailable' => 'Unavailable',
                    ] as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('status', $unit->status ?? 'available') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Optional details about the unit">{{ old('description', $unit->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="card-footer bg-white p-3 d-flex justify-content-between">
        <a href="{{ route('admin.property-management.units.index') }}"
           class="btn btn-outline-secondary">Cancel</a>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i>
            {{ $unit->exists ? 'Save Changes' : 'Create Unit' }}
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const propertySelect = document.getElementById('managed_property_id');
    const buildingSelect = document.getElementById('building_id');
    const floorSelect = document.getElementById('floor_id');

    function filterBuildings() {
        const propertyId = propertySelect.value;

        Array.from(buildingSelect.options).forEach(option => {
            if (!option.value) return;

            option.hidden = propertyId !== '' &&
                option.dataset.propertyId !== propertyId;

            if (option.hidden && option.selected) {
                buildingSelect.value = '';
            }
        });

        filterFloors();
    }

    function filterFloors() {
        const buildingId = buildingSelect.value;

        Array.from(floorSelect.options).forEach(option => {
            if (!option.value) return;

            option.hidden = buildingId === '' ||
                option.dataset.buildingId !== buildingId;

            if (option.hidden && option.selected) {
                floorSelect.value = '';
            }
        });
    }

    propertySelect.addEventListener('change', function () {
        buildingSelect.value = '';
        floorSelect.value = '';
        filterBuildings();
    });

    buildingSelect.addEventListener('change', function () {
        floorSelect.value = '';
        filterFloors();
    });

    filterBuildings();

    // Restore a valid selected floor on initial edit/create form load.
    if (buildingSelect.value) {
        filterFloors();
    }
});
</script>