@csrf

@if($floor->exists)
    @method('PUT')
@endif

<div class="row g-3">

    <div class="col-12">
        <label for="building_id" class="form-label">
            Building <span class="text-danger">*</span>
        </label>

        <select name="building_id"
                id="building_id"
                class="form-select @error('building_id') is-invalid @enderror"
                required>
            <option value="">Select building</option>

            @foreach($buildings as $buildingOption)
                <option value="{{ $buildingOption->id }}"
                    @selected(
                        (string) old('building_id', $floor->building_id)
                        === (string) $buildingOption->id
                    )>
                    {{ $buildingOption->name }}
                    @if($buildingOption->building_code)
                        ({{ $buildingOption->building_code }})
                    @endif
                    — {{ $buildingOption->managedProperty?->name ?? 'No property assigned' }}
                </option>
            @endforeach
        </select>

        @error('building_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if($buildings->isEmpty())
            <div class="form-text text-danger">
                Create a building first before registering a floor.
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <label for="name" class="form-label">
            Floor Name <span class="text-danger">*</span>
        </label>

        <input type="text"
               name="name"
               id="name"
               value="{{ old('name', $floor->name) }}"
               class="form-control @error('name') is-invalid @enderror"
               maxlength="255"
               placeholder="e.g. Ground Floor"
               required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="floor_number" class="form-label">
            Floor Number <span class="text-danger">*</span>
        </label>

        <input type="number"
               name="floor_number"
               id="floor_number"
               value="{{ old('floor_number', $floor->floor_number) }}"
               class="form-control @error('floor_number') is-invalid @enderror"
               min="-5"
               max="300"
               required>

        @error('floor_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <div class="form-text">
            Use 0 for ground floor, positive numbers for upper floors, and negative numbers for basements.
        </div>
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Description</label>

        <textarea name="description"
                  id="description"
                  rows="4"
                  maxlength="5000"
                  class="form-control @error('description') is-invalid @enderror"
                  placeholder="Optional details about this floor">{{ old('description', $floor->description) }}</textarea>

        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>