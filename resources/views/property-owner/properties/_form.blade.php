@php
    $editing = isset($property);

    $propertyTypes = [
        'residential' => 'Residential',
        'commercial' => 'Commercial',
        'mixed_use' => 'Mixed Use',
        'industrial' => 'Industrial',
        'land' => 'Land',
        'other' => 'Other',
    ];

    $locations = [
        'Eastern Province',
        'Kigali City',
        'Northern Province',
        'Southern Province',
        'Western Province',
    ];
@endphp

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Please correct the following errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white p-4">
        <h5 class="fw-bold mb-1">Basic Information</h5>
        <p class="text-muted small mb-0">
            Provide the property's name, type and description.
        </p>
    </div>

    <div class="card-body p-4">
        @if($editing)
            <div class="mb-3">
                <label class="form-label">Property Code</label>
                <input type="text"
                       class="form-control bg-light"
                       value="{{ $property->property_code }}"
                       readonly>
                <div class="form-text">
                    This system-generated code cannot be changed.
                </div>
            </div>
        @endif

        <div class="row g-3">
            <div class="col-md-7">
                <label for="name" class="form-label">
                    Property Name <span class="text-danger">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       maxlength="255"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $property->name ?? '') }}"
                       placeholder="e.g. Kigali Heights Apartment"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-5">
                <label for="property_type" class="form-label">
                    Property Type <span class="text-danger">*</span>
                </label>
                <select name="property_type"
                        id="property_type"
                        class="form-select @error('property_type') is-invalid @enderror"
                        required>
                    <option value="">Select property type</option>
                    @foreach($propertyTypes as $value => $label)
                        <option value="{{ $value }}"
                            @selected(old('property_type', $property->property_type ?? '') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('property_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label">
                    Description
                </label>
                <textarea name="description"
                          id="description"
                          rows="4"
                          maxlength="5000"
                          class="form-control"
                          placeholder="Describe the property and its features.">{{ old('description', $property->description ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white p-4">
        <h5 class="fw-bold mb-1">Property Location</h5>
        <p class="text-muted small mb-0">
            Enter the property's administrative location in Rwanda.
        </p>
    </div>

    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="province" class="form-label">
                    Province / City <span class="text-danger">*</span>
                </label>
                <select name="province"
                        id="province"
                        class="form-select @error('province') is-invalid @enderror"
                        required>
                    <option value="">Select province or city</option>
                    @foreach($locations as $location)
                        <option value="{{ $location }}"
                            @selected(old('province', $property->province ?? '') === $location)>
                            {{ $location }}
                        </option>
                    @endforeach
                </select>
                @error('province')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="district" class="form-label">
                    District <span class="text-danger">*</span>
                </label>
                <input type="text"
                       id="district"
                       name="district"
                       maxlength="100"
                       class="form-control @error('district') is-invalid @enderror"
                       value="{{ old('district', $property->district ?? '') }}"
                       placeholder="e.g. Gasabo"
                       required>
                @error('district')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label for="sector" class="form-label">Sector</label>
                <input type="text" id="sector" name="sector"
                       maxlength="100" class="form-control"
                       value="{{ old('sector', $property->sector ?? '') }}">
            </div>

            <div class="col-md-4">
                <label for="cell" class="form-label">Cell</label>
                <input type="text" id="cell" name="cell"
                       maxlength="100" class="form-control"
                       value="{{ old('cell', $property->cell ?? '') }}">
            </div>

            <div class="col-md-4">
                <label for="village" class="form-label">Village</label>
                <input type="text" id="village" name="village"
                       maxlength="100" class="form-control"
                       value="{{ old('village', $property->village ?? '') }}">
            </div>

            <div class="col-12">
                <label for="address" class="form-label">
                    Street Address / Directions
                </label>
                <textarea name="address" id="address" rows="2"
                          maxlength="500" class="form-control"
                          placeholder="Enter the physical address or directions">{{ old('address', $property->address ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label for="upi_reference" class="form-label">
                    UPI Reference
                </label>
                <input type="text"
                       name="upi_reference"
                       id="upi_reference"
                       maxlength="100"
                       class="form-control"
                       value="{{ old('upi_reference', $property->upi_reference ?? '') }}"
                       placeholder="Unique Parcel Identifier">
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white p-4">
        <h5 class="fw-bold mb-1">Map Coordinates</h5>
        <p class="text-muted small mb-0">
            Coordinates are optional. Enter valid decimal latitude and longitude.
        </p>
    </div>

    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="number"
                       step="any"
                       min="-90"
                       max="90"
                       id="latitude"
                       name="latitude"
                       class="form-control @error('latitude') is-invalid @enderror"
                       value="{{ old('latitude', $property->latitude ?? '') }}"
                       placeholder="-1.9441">
                @error('latitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="number"
                       step="any"
                       min="-180"
                       max="180"
                       id="longitude"
                       name="longitude"
                       class="form-control @error('longitude') is-invalid @enderror"
                       value="{{ old('longitude', $property->longitude ?? '') }}"
                       placeholder="30.0619">
                @error('longitude')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white p-4">
        <h5 class="fw-bold mb-1">Additional Notes</h5>
    </div>

    <div class="card-body p-4">
        <label for="notes" class="form-label">Internal Notes</label>
        <textarea name="notes"
                  id="notes"
                  rows="3"
                  maxlength="5000"
                  class="form-control"
                  placeholder="Any additional information for property management.">{{ old('notes', $property->notes ?? '') }}</textarea>
    </div>
</div>

<div class="d-flex flex-wrap justify-content-end gap-2 mb-4">
    <a href="{{ route('property-owner.properties.index') }}"
       class="btn btn-light border px-4">
        Cancel
    </a>

    <button type="submit" class="btn btn-terra px-4">
        {{ $editing ? 'Save Changes' : 'Create Property' }}
    </button>
</div>