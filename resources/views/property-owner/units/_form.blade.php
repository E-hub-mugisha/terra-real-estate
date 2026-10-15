@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white p-4">
        <h5 class="fw-bold mb-0">Unit Information</h5>
    </div>

    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="floor_id" class="form-label">Floor *</label>
                <select name="floor_id" id="floor_id"
                        class="form-select" required>
                    <option value="">Select floor</option>
                    @foreach($floors as $floor)
                        <option value="{{ $floor->id }}"
                            @selected((string) old('floor_id', $unit->floor_id ?? '') === (string) $floor->id)>
                            {{ $floor->name ?? 'Floor ' . $floor->floor_number }}
                        </option>
                    @endforeach
                </select>
                @if($floors->isEmpty())
                    <div class="form-text text-danger">
                        No floors exist yet. Create a floor before adding a unit.
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label for="unit_number" class="form-label">Unit Number *</label>
                <input type="text" name="unit_number" id="unit_number"
                       maxlength="100" required class="form-control"
                       value="{{ old('unit_number', $unit->unit_number ?? '') }}"
                       placeholder="e.g. A-101">
            </div>

            <div class="col-md-6">
                <label for="unit_type" class="form-label">Unit Type</label>
                <select name="unit_type" id="unit_type" class="form-select">
                    <option value="">Select type</option>
                    @foreach(['apartment', 'house', 'studio', 'shop', 'office', 'warehouse', 'other'] as $type)
                        <option value="{{ $type }}"
                            @selected(old('unit_type', $unit->unit_type ?? '') === $type)>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="size" class="form-label">Size (m²)</label>
                <input type="number" name="size" id="size"
                       min="0" step="0.01" class="form-control"
                       value="{{ old('size', $unit->size ?? '') }}">
            </div>

            <div class="col-md-6">
                <label for="bedrooms" class="form-label">Bedrooms</label>
                <input type="number" name="bedrooms" id="bedrooms"
                       min="0" max="100" class="form-control"
                       value="{{ old('bedrooms', $unit->bedrooms ?? 0) }}">
            </div>

            <div class="col-md-6">
                <label for="bathrooms" class="form-label">Bathrooms</label>
                <input type="number" name="bathrooms" id="bathrooms"
                       min="0" max="100" class="form-control"
                       value="{{ old('bathrooms', $unit->bathrooms ?? 0) }}">
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white p-4">
        <h5 class="fw-bold mb-0">Rent and Availability</h5>
    </div>

    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="rent" class="form-label">Monthly Rent (RWF) *</label>
                <input type="number" name="rent" id="rent"
                       min="0" step="0.01" required class="form-control"
                       value="{{ old('rent', $unit->rent ?? '') }}">
            </div>

            <div class="col-md-6">
                <label for="deposit" class="form-label">Deposit (RWF)</label>
                <input type="number" name="deposit" id="deposit"
                       min="0" step="0.01" class="form-control"
                       value="{{ old('deposit', $unit->deposit ?? '') }}">
            </div>

            <div class="col-md-6">
                <label for="availability" class="form-label">Availability *</label>
                <select name="availability" id="availability"
                        class="form-select" required>
                    @foreach(['available', 'unavailable', 'reserved'] as $status)
                        <option value="{{ $status }}"
                            @selected(old('availability', $unit->availability ?? 'available') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="4"
                          maxlength="5000" class="form-control"
                          placeholder="Describe the unit, its features and amenities.">{{ old('description', $unit->description ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('property-owner.units.index', [$property, $building]) }}"
       class="btn btn-light border">Cancel</a>

    <button type="submit" class="btn btn-terra"
            @disabled($floors->isEmpty())>
        {{ isset($unit) ? 'Save Changes' : 'Create Unit' }}
    </button>
</div>