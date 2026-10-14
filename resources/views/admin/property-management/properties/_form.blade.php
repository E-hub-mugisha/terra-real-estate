@csrf

@if($property->exists)
    @method('PUT')
@endif

{{-- Property ownership --}}
<h6 class="fw-bold mb-3">Ownership Information</h6>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label for="property_owner_id" class="form-label">
            Property Owner <span class="text-danger">*</span>
        </label>

        <select name="property_owner_id"
                id="property_owner_id"
                class="form-select @error('property_owner_id') is-invalid @enderror"
                required>
            <option value="">Select property owner</option>

            @foreach($owners as $ownerOption)
                <option value="{{ $ownerOption->id }}"
                    @selected(
                        (string) old('property_owner_id', $property->property_owner_id)
                        === (string) $ownerOption->id
                    )>
                    {{ $ownerOption->user?->name ?? 'Unknown user' }}
                    — {{ $ownerOption->user?->email ?? 'No email' }}
                </option>
            @endforeach
        </select>

        @error('property_owner_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if($owners->isEmpty())
            <div class="form-text text-danger">
                No property owners are available. Create an owner first.
            </div>
        @endif
    </div>
</div>

<hr class="my-4">

{{-- Basic information --}}
<h6 class="fw-bold mb-3">Property Information</h6>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <label for="name" class="form-label">
            Property Name <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="name"
               id="name"
               value="{{ old('name', $property->name) }}"
               class="form-control @error('name') is-invalid @enderror"
               maxlength="255"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="property_code" class="form-label">
            Property Code <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="property_code"
               id="property_code"
               value="{{ old('property_code', $property->property_code) }}"
               class="form-control @error('property_code') is-invalid @enderror"
               maxlength="100"
               required>

        @error('property_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="form-text">
            Must be unique across managed properties.
        </div>
    </div>

    <div class="col-md-6">
        <label for="property_type" class="form-label">
            Property Type <span class="text-danger">*</span>
        </label>

        @php
            $propertyTypes = [
                'residential' => 'Residential',
                'commercial' => 'Commercial',
                'mixed_use' => 'Mixed Use',
                'industrial' => 'Industrial',
                'land' => 'Land',
                'other' => 'Other',
            ];
        @endphp

        <select name="property_type"
                id="property_type"
                class="form-select @error('property_type') is-invalid @enderror"
                required>
            <option value="">Select property type</option>

            @foreach($propertyTypes as $value => $label)
                <option value="{{ $value }}"
                    @selected(old('property_type', $property->property_type) === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('property_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="management_status" class="form-label">
            Management Status <span class="text-danger">*</span>
        </label>

        <select name="management_status"
                id="management_status"
                class="form-select @error('management_status') is-invalid @enderror"
                required>
            <option value="active"
                @selected(old('management_status', $property->management_status ?? 'active') === 'active')>
                Active
            </option>

            <option value="inactive"
                @selected(old('management_status', $property->management_status) === 'inactive')>
                Inactive
            </option>
        </select>

        @error('management_status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description</label>

        <textarea name="description"
                  id="description"
                  rows="3"
                  class="form-control @error('description') is-invalid @enderror"
                  maxlength="5000">{{ old('description', $property->description) }}</textarea>

        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr class="my-4">

{{-- Location --}}
<h6 class="fw-bold mb-3">Property Location</h6>

<div class="row g-3 mb-4">
    @foreach([
        'province' => 'Province',
        'district' => 'District',
        'sector' => 'Sector',
        'cell' => 'Cell',
        'village' => 'Village',
    ] as $field => $label)
        <div class="col-md-4">
            <label for="{{ $field }}" class="form-label">{{ $label }}</label>

            <input type="text"
                   name="{{ $field }}"
                   id="{{ $field }}"
                   value="{{ old($field, $property->{$field}) }}"
                   class="form-control @error($field) is-invalid @enderror"
                   maxlength="100">

            @error($field)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    @endforeach

    <div class="col-12">
        <label for="address" class="form-label">Street / Physical Address</label>

        <textarea name="address"
                  id="address"
                  rows="2"
                  class="form-control @error('address') is-invalid @enderror"
                  maxlength="1000">{{ old('address', $property->address) }}</textarea>

        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="upi_reference" class="form-label">UPI Reference</label>

        <input type="text"
               name="upi_reference"
               id="upi_reference"
               value="{{ old('upi_reference', $property->upi_reference) }}"
               class="form-control @error('upi_reference') is-invalid @enderror"
               maxlength="100">

        @error('upi_reference')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="latitude" class="form-label">Latitude</label>

        <input type="number"
               name="latitude"
               id="latitude"
               step="any"
               min="-90"
               max="90"
               value="{{ old('latitude', $property->latitude) }}"
               class="form-control @error('latitude') is-invalid @enderror">

        @error('latitude')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="longitude" class="form-label">Longitude</label>

        <input type="number"
               name="longitude"
               id="longitude"
               step="any"
               min="-180"
               max="180"
               value="{{ old('longitude', $property->longitude) }}"
               class="form-control @error('longitude') is-invalid @enderror">

        @error('longitude')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr class="my-4">

{{-- Internal notes --}}
<h6 class="fw-bold mb-3">Internal Notes</h6>

<div class="row">
    <div class="col-12">
        <label for="notes" class="form-label">Notes</label>

        <textarea name="notes"
                  id="notes"
                  rows="3"
                  class="form-control @error('notes') is-invalid @enderror"
                  maxlength="5000">{{ old('notes', $property->notes) }}</textarea>

        @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>