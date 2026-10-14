@csrf

@if($building->exists)
    @method('PUT')
@endif

<h6 class="fw-bold mb-3">Building Information</h6>

<div class="row g-3">
    <div class="col-12">
        <label for="managed_property_id" class="form-label">
            Managed Property <span class="text-danger">*</span>
        </label>

        <select name="managed_property_id"
                id="managed_property_id"
                class="form-select @error('managed_property_id') is-invalid @enderror"
                required>
            <option value="">Select property</option>

            @foreach($properties as $property)
                <option value="{{ $property->id }}"
                    @selected((string) old('managed_property_id', $building->managed_property_id) === (string) $property->id)>
                    {{ $property->name }} ({{ $property->property_code }})
                    — {{ $property->owner?->user?->name ?? 'Unknown owner' }}
                </option>
            @endforeach
        </select>

        @error('managed_property_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if($properties->isEmpty())
            <div class="form-text text-danger">
                Register a managed property before creating a building.
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="name" class="form-label">
            Building Name <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="name"
               id="name"
               value="{{ old('name', $building->name) }}"
               class="form-control @error('name') is-invalid @enderror"
               maxlength="255"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="building_code" class="form-label">Building Code</label>

        <input type="text"
               name="building_code"
               id="building_code"
               value="{{ old('building_code', $building->building_code) }}"
               class="form-control @error('building_code') is-invalid @enderror"
               maxlength="100">

        @error('building_code')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="form-text">Optional; unique within the selected property.</div>
    </div>

    <div class="col-md-6">
        <label for="number_of_floors" class="form-label">Number of Floors</label>

        <input type="number"
               name="number_of_floors"
               id="number_of_floors"
               value="{{ old('number_of_floors', $building->number_of_floors) }}"
               class="form-control @error('number_of_floors') is-invalid @enderror"
               min="0"
               max="200">

        @error('number_of_floors')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="form-text">
            This is the expected number of floors; floors are registered separately.
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label d-block">Building Status</label>

        <input type="hidden" name="is_active" value="0">

        <div class="form-check form-switch mt-2">
            <input type="checkbox"
                   name="is_active"
                   id="is_active"
                   value="1"
                   class="form-check-input"
                   role="switch"
                   @checked((bool) old('is_active', $building->exists ? $building->is_active : true))>

            <label for="is_active" class="form-check-label">
                Active building
            </label>
        </div>
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description</label>

        <textarea name="description"
                  id="description"
                  rows="4"
                  maxlength="5000"
                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $building->description) }}</textarea>

        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>