@csrf

<div class="mb-3">
    <label for="floor_number" class="form-label">
        Floor Number <span class="text-danger">*</span>
    </label>

    <input
        type="number"
        name="floor_number"
        id="floor_number"
        min="0"
        max="200"
        class="form-control @error('floor_number') is-invalid @enderror"
        value="{{ old('floor_number', $floor->floor_number ?? '') }}"
        required
    >

    <div class="form-text">
        Use 0 for the ground floor, 1 for the first floor, and so on.
    </div>

    @error('floor_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="name" class="form-label">Floor Name</label>

    <input
        type="text"
        name="name"
        id="name"
        class="form-control @error('name') is-invalid @enderror"
        placeholder="e.g. Ground Floor, First Floor"
        value="{{ old('name', $floor->name ?? '') }}"
    >

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>

    <textarea
        name="description"
        id="description"
        rows="4"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Optional details about this floor"
    >{{ old('description', $floor->description ?? '') }}</textarea>

    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-terra">
        {{ $submitLabel ?? 'Save Floor' }}
    </button>

    <a
        href="{{ route('property-owner.floors.index', [$property, $building]) }}"
        class="btn btn-outline-secondary"
    >
        Cancel
    </a>
</div>