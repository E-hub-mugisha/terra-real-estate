@extends('layouts.professional')

@section('title', 'Add New Design — Terra Professional')
@section('page_title', 'Add New Design')

@section('content')
<div class="page-header">
    <div>
        <h1>Add New Design</h1>
        <p>Publish an architectural design to your portfolio</p>
    </div>
    <a href="{{ route('professional.designs.index') }}" class="btn-outline">← Back to Designs</a>
</div>

<form method="POST" action="{{ route('professional.designs.store') }}" enctype="multipart/form-data">
@csrf

{{-- ── Basic Info ───────────────────────────────────────────────────── --}}
<div class="form-card" style="margin-bottom:20px">
    <h2 class="form-section-title">Basic Information</h2>
    <div class="form-grid">
        <div class="form-group full">
            <label>Design Title <span class="req">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Modern Villa with Pool — 4 Bedroom">
            @error('title')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Category <span class="req">*</span></label>
            <select name="category">
                <option value="">Select Category</option>
                @foreach(['Residential','Commercial','Mixed-Use','Industrial','Institutional','Landscape'] as $cat)
                    <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @error('category')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Architectural Style</label>
            <input type="text" name="style" value="{{ old('style') }}" placeholder="e.g. Modern, Contemporary, Traditional">
        </div>
        <div class="form-group full">
            <label>Description <span class="req">*</span></label>
            <textarea name="description" rows="5" placeholder="Describe the design in detail — style, materials, special features, ideal location…">{{ old('description') }}</textarea>
            @error('description')<span class="form-error">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

{{-- ── Specifications ───────────────────────────────────────────────── --}}
<div class="form-card" style="margin-bottom:20px">
    <h2 class="form-section-title">Specifications</h2>
    <div class="form-grid-3">
        <div class="form-group">
            <label>Bedrooms</label>
            <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" min="0" placeholder="e.g. 4">
        </div>
        <div class="form-group">
            <label>Bathrooms</label>
            <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" min="0" placeholder="e.g. 3">
        </div>
        <div class="form-group">
            <label>Floors</label>
            <input type="number" name="floors" value="{{ old('floors') }}" min="1" placeholder="e.g. 2">
        </div>
        <div class="form-group">
            <label>Total Area (sqft)</label>
            <input type="number" name="total_area_sqft" value="{{ old('total_area_sqft') }}" min="0" step="0.01" placeholder="e.g. 2400">
        </div>
        <div class="form-group">
            <label>Price <span class="req">*</span></label>
            <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01" placeholder="e.g. 5000000">
            @error('price')<span class="form-error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label>Currency <span class="req">*</span></label>
            <select name="currency">
                <option value="RWF" {{ old('currency','RWF') === 'RWF' ? 'selected' : '' }}>RWF — Rwandan Franc</option>
                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD — US Dollar</option>
            </select>
        </div>
    </div>
</div>

{{-- ── Features ─────────────────────────────────────────────────────── --}}
<div class="form-card" style="margin-bottom:20px">
    <h2 class="form-section-title">Key Features</h2>
    <div id="features-list" class="features-list">
        @forelse(old('features', ['']) as $feature)
        <div class="feature-row">
            <input type="text" name="features[]" value="{{ $feature }}" placeholder="e.g. Private swimming pool">
            <button type="button" class="btn-remove-feature" onclick="this.closest('.feature-row').remove()">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        @endforelse
    </div>
    <button type="button" class="btn-add-feature" onclick="addFeature()">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Feature
    </button>
</div>

{{-- ── Media ────────────────────────────────────────────────────────── --}}
<div class="form-card" style="margin-bottom:20px">
    <h2 class="form-section-title">Media</h2>
    <div class="form-grid">

        <div class="form-group">
            <label>Cover Image <span class="req">*</span></label>
            <label class="file-upload" for="cover_image">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="var(--muted)" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <p><strong>Click to upload</strong> cover image</p>
                <p style="font-size:12px">JPG, PNG, WEBP · Max 4MB</p>
            </label>
            <input type="file" id="cover_image" name="cover_image" accept="image/*" onchange="previewFile(this, 'cover-preview')">
            <img id="cover-preview" src="" alt="" style="display:none;max-height:140px;border-radius:8px;margin-top:8px;object-fit:cover;">
            @error('cover_image')<span class="form-error">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Gallery Images</label>
            <label class="file-upload" for="gallery">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="var(--muted)" stroke-width="1.5" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <p><strong>Click to upload</strong> gallery (multiple)</p>
                <p style="font-size:12px">JPG, PNG, WEBP · Max 4MB each</p>
            </label>
            <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple>
        </div>

        <div class="form-group">
            <label>Blueprint / Floor Plan (PDF)</label>
            <label class="file-upload" for="blueprint_pdf">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="var(--muted)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <p><strong>Click to upload</strong> blueprint PDF</p>
                <p style="font-size:12px">PDF only · Max 10MB</p>
            </label>
            <input type="file" id="blueprint_pdf" name="blueprint_pdf" accept="application/pdf">
        </div>

        <div class="form-group">
            <label>Tags</label>
            <input type="text" name="tags" value="{{ old('tags') }}" placeholder="modern, pool, garden, eco-friendly">
            <span class="form-hint">Comma-separated tags for search</span>
        </div>
    </div>
</div>

{{-- ── Publish ───────────────────────────────────────────────────────── --}}
<div class="form-card" style="margin-bottom:28px">
    <h2 class="form-section-title">Publishing</h2>
    <div class="form-grid">
        <div class="form-group">
            <label>Status <span class="req">*</span></label>
            <select name="status">
                <option value="draft"  {{ old('status','draft') === 'draft'  ? 'selected' : '' }}>Draft — not visible to users</option>
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active — visible on Terra</option>
            </select>
        </div>
    </div>
</div>

<div style="display:flex;gap:12px">
    <button type="submit" class="btn-gold-lg">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Publish Design
    </button>
    <a href="{{ route('professional.designs.index') }}" class="btn-outline">Cancel</a>
</div>

</form>
@endsection

@push('scripts')
<script>
function previewFile(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
function addFeature() {
    const list = document.getElementById('features-list');
    const row = document.createElement('div');
    row.className = 'feature-row';
    row.innerHTML = `
        <input type="text" name="features[]" placeholder="e.g. Solar panels installed">
        <button type="button" class="btn-remove-feature" onclick="this.closest('.feature-row').remove()">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>`;
    list.appendChild(row);
    row.querySelector('input').focus();
}
</script>
@endpush
