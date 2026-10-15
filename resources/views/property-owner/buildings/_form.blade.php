@php($editing = isset($building))

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
    <div class="card-body p-4">
        @if($editing)
            <div class="mb-3">
                <label class="form-label">Building Code</label>
                <input class="form-control bg-light"
                       value="{{ $building->building_code }}"
                       readonly>
            </div>
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Building Name *</label>
            <input name="name" id="name" required maxlength="255"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $building->name ?? '') }}"
                   placeholder="e.g. Block A">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="number_of_floors" class="form-label">
                Number of Floors *
            </label>
            <input type="number" name="number_of_floors"
                   id="number_of_floors" min="1" max="200" required
                   class="form-control"
                   value="{{ old('number_of_floors', $building->number_of_floors ?? 1) }}">
            <div class="form-text">
                This records the building's floor count. Floor records may need
                to be created separately before adding units.
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4"
                      maxlength="5000"
                      class="form-control">{{ old('description', $building->description ?? '') }}</textarea>
        </div>

        @if($editing)
            <div class="form-check mb-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active"
                       value="1" class="form-check-input"
                       @checked((bool) old('is_active', $building->is_active))>
                <label for="is_active" class="form-check-label">
                    Building is active
                </label>
            </div>
        @endif
    </div>
</div>

<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('property-owner.buildings.index', $property) }}"
       class="btn btn-light border">Cancel</a>
    <button class="btn btn-terra">
        {{ $editing ? 'Save Changes' : 'Create Building' }}
    </button>
</div>