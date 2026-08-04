@extends('layouts.shop')
@section('page-title', 'Shop Profile')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --terra-navy: #19265d;
        --terra-navy-deep: #121b45;
        --terra-navy-light: #2a3a82;
        --terra-orange: #D05208;
        --terra-orange-light: #ea6f1f;
        --terra-bg-soft: #f5f6fb;
        --terra-ink: #1c2340;
        --terra-muted: #6b7290;
        --terra-line: #eaebf4;
    }

    [data-h-scope="shop-profile"] {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--terra-ink);
    }
    [data-h-scope="shop-profile"] h1,
    [data-h-scope="shop-profile"] h2,
    [data-h-scope="shop-profile"] h5,
    [data-h-scope="shop-profile"] .h-heading {
        font-family: 'Sora', sans-serif;
    }

    /* ---------- Page header ---------- */
    [data-h-scope="shop-profile"] .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    [data-h-scope="shop-profile"] .page-eyebrow {
        text-transform: uppercase;
        letter-spacing: .1em;
        font-size: .7rem;
        font-weight: 700;
        color: var(--terra-orange);
        margin-bottom: .25rem;
    }
    [data-h-scope="shop-profile"] .page-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0;
    }
    [data-h-scope="shop-profile"] .page-sub {
        color: var(--terra-muted);
        font-size: .88rem;
        margin-top: .15rem;
    }

    /* ---------- Alert ---------- */
    [data-h-scope="shop-profile"] .alert-terra-success {
        background: rgba(30,158,99,.1);
        border: 1px solid rgba(30,158,99,.25);
        color: #157a4c;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: .6rem;
        font-weight: 500;
        font-size: .9rem;
    }

    /* ---------- Form shell ---------- */
    [data-h-scope="shop-profile"] .form-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 14px rgba(25, 38, 93, 0.07);
        overflow: hidden;
    }
    [data-h-scope="shop-profile"] .form-section {
        padding: 1.75rem 2rem;
        border-bottom: 1px solid var(--terra-line);
    }
    [data-h-scope="shop-profile"] .form-section:last-of-type {
        border-bottom: none;
    }
    [data-h-scope="shop-profile"] .section-eyebrow {
        display: flex;
        align-items: center;
        gap: .6rem;
        margin-bottom: 1.25rem;
    }
    [data-h-scope="shop-profile"] .section-icon {
        width: 34px; height: 34px; border-radius: 9px;
        background: rgba(25,38,93,.08);
        color: var(--terra-navy);
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
    }
    [data-h-scope="shop-profile"] .section-title {
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        margin: 0;
    }
    [data-h-scope="shop-profile"] .section-desc {
        color: var(--terra-muted);
        font-size: .8rem;
        margin: 0;
    }

    /* ---------- Fields ---------- */
    [data-h-scope="shop-profile"] .form-label {
        font-weight: 600;
        font-size: .82rem;
        color: var(--terra-ink);
        margin-bottom: .4rem;
    }
    [data-h-scope="shop-profile"] .form-label .optional-tag {
        font-weight: 400;
        color: var(--terra-muted);
        text-transform: none;
        letter-spacing: 0;
    }
    [data-h-scope="shop-profile"] .form-control,
    [data-h-scope="shop-profile"] .form-select {
        border: 1px solid var(--terra-line);
        border-radius: 10px;
        padding: .6rem .85rem;
        font-size: .9rem;
        background: var(--terra-bg-soft);
    }
    [data-h-scope="shop-profile"] .form-control:focus,
    [data-h-scope="shop-profile"] .form-select:focus {
        border-color: var(--terra-navy);
        box-shadow: 0 0 0 3px rgba(25,38,93,.1);
        background: #fff;
    }
    [data-h-scope="shop-profile"] .form-control.is-invalid {
        border-color: var(--terra-orange);
        background: #fff;
    }
    [data-h-scope="shop-profile"] .invalid-feedback {
        font-size: .78rem;
        color: var(--terra-orange);
    }
    [data-h-scope="shop-profile"] .input-icon-group {
        position: relative;
    }
    [data-h-scope="shop-profile"] .input-icon-group .form-control {
        padding-left: 2.35rem;
    }
    [data-h-scope="shop-profile"] .input-icon-group i {
        position: absolute;
        left: .85rem; top: 50%;
        transform: translateY(-50%);
        color: var(--terra-muted);
        font-size: .9rem;
        pointer-events: none;
    }
    [data-h-scope="shop-profile"] .form-text-hint {
        font-size: .76rem;
        color: var(--terra-muted);
        margin-top: .3rem;
    }

    /* ---------- Image uploaders ---------- */
    [data-h-scope="shop-profile"] .uploader {
        border: 1.5px dashed var(--terra-line);
        border-radius: 14px;
        background: var(--terra-bg-soft);
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: border-color .15s ease, background .15s ease;
        cursor: pointer;
        position: relative;
    }
    [data-h-scope="shop-profile"] .uploader:hover {
        border-color: var(--terra-orange);
        background: #fff;
    }
    [data-h-scope="shop-profile"] .uploader input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer;
    }
    [data-h-scope="shop-profile"] .uploader-preview {
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        background: #fff;
        border: 1px solid var(--terra-line);
    }
    [data-h-scope="shop-profile"] .uploader-preview.logo-preview { width: 64px; height: 64px; }
    [data-h-scope="shop-profile"] .uploader-preview.cover-preview { width: 96px; height: 60px; }
    [data-h-scope="shop-profile"] .uploader-placeholder {
        border-radius: 10px;
        background: #fff;
        border: 1px solid var(--terra-line);
        display: flex; align-items: center; justify-content: center;
        color: var(--terra-muted);
        flex-shrink: 0;
    }
    [data-h-scope="shop-profile"] .uploader-placeholder.logo-preview { width: 64px; height: 64px; font-size: 1.2rem; }
    [data-h-scope="shop-profile"] .uploader-placeholder.cover-preview { width: 96px; height: 60px; font-size: 1.2rem; }
    [data-h-scope="shop-profile"] .uploader-text-title {
        font-weight: 600;
        font-size: .85rem;
        color: var(--terra-ink);
    }
    [data-h-scope="shop-profile"] .uploader-text-sub {
        font-size: .76rem;
        color: var(--terra-muted);
    }
    [data-h-scope="shop-profile"] .uploader-text-sub .js-file-name {
        color: var(--terra-orange);
        font-weight: 600;
    }

    /* ---------- Sticky action bar ---------- */
    [data-h-scope="shop-profile"] .form-actions {
        background: #fbfbfe;
        padding: 1.1rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    [data-h-scope="shop-profile"] .form-actions-hint {
        font-size: .8rem;
        color: var(--terra-muted);
        display: flex;
        align-items: center;
        gap: .4rem;
    }
    [data-h-scope="shop-profile"] .btn-terra {
        background: var(--terra-navy);
        border-color: var(--terra-navy);
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: .6rem 1.4rem;
        font-size: .88rem;
    }
    [data-h-scope="shop-profile"] .btn-terra:hover {
        background: var(--terra-navy-light);
        border-color: var(--terra-navy-light);
        color: #fff;
    }
    [data-h-scope="shop-profile"] .btn-terra-outline {
        background: transparent;
        border: 1px solid var(--terra-line);
        color: var(--terra-muted);
        font-weight: 600;
        border-radius: 10px;
        padding: .6rem 1.2rem;
        font-size: .88rem;
    }
    [data-h-scope="shop-profile"] .btn-terra-outline:hover {
        border-color: var(--terra-navy);
        color: var(--terra-navy);
    }

    @media (max-width: 767px) {
        [data-h-scope="shop-profile"] .form-section { padding: 1.25rem 1.25rem; }
        [data-h-scope="shop-profile"] .form-actions { padding: 1rem 1.25rem; }
    }
</style>
@endpush

@section('content')
<div data-h-scope="shop-profile">

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Shop settings</div>
            <h1 class="page-title">Shop Profile</h1>
            <div class="page-sub">Keep your shop details accurate so buyers can find and trust you.</div>
        </div>
    </div>

    @if (session('status') === 'shop-updated')
        <div class="alert alert-terra-success py-3 px-4 mb-4">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>Shop profile updated successfully.</span>
        </div>
    @endif

    <form method="POST" action="{{ route('shop-panel.profile.update') }}" enctype="multipart/form-data" class="card form-card">
        @csrf @method('PUT')

        {{-- Branding --}}
        <div class="form-section">
            <div class="section-eyebrow">
                <div class="section-icon"><i class="bi bi-image"></i></div>
                <div>
                    <p class="section-title">Branding</p>
                    <p class="section-desc">Your logo and cover photo appear across your shop page and listings.</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Logo</label>
                    <label class="uploader">
                        <input type="file" name="logo" accept="image/*" id="logoInput">
                        @if ($shop->logo)
                            <img src="{{ asset('storage/' . $shop->logo) }}" class="uploader-preview logo-preview" id="logoPreview">
                        @else
                            <div class="uploader-placeholder logo-preview" id="logoPreview"><i class="bi bi-shop"></i></div>
                        @endif
                        <div>
                            <div class="uploader-text-title">Upload logo</div>
                            <div class="uploader-text-sub">Square image, at least 200×200px <span class="js-file-name" id="logoFileName"></span></div>
                        </div>
                    </label>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Cover Image</label>
                    <label class="uploader">
                        <input type="file" name="cover_image" accept="image/*" id="coverInput">
                        @if ($shop->cover_image)
                            <img src="{{ asset('storage/' . $shop->cover_image) }}" class="uploader-preview cover-preview" id="coverPreview">
                        @else
                            <div class="uploader-placeholder cover-preview" id="coverPreview"><i class="bi bi-image"></i></div>
                        @endif
                        <div>
                            <div class="uploader-text-title">Upload cover</div>
                            <div class="uploader-text-sub">Wide banner, 1200×600px recommended <span class="js-file-name" id="coverFileName"></span></div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        {{-- Basic details --}}
        <div class="form-section">
            <div class="section-eyebrow">
                <div class="section-icon"><i class="bi bi-shop-window"></i></div>
                <div>
                    <p class="section-title">Basic Details</p>
                    <p class="section-desc">The name and description shown on your public shop page.</p>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Shop Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $shop->name) }}" placeholder="e.g. Kigali Home Essentials">
                @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="mb-0">
                <label class="form-label">Description <span class="optional-tag">(optional)</span></label>
                <textarea name="description" rows="4" class="form-control" placeholder="Tell buyers what your shop offers...">{{ old('description', $shop->description) }}</textarea>
            </div>
        </div>

        {{-- Contact --}}
        <div class="form-section">
            <div class="section-eyebrow">
                <div class="section-icon"><i class="bi bi-headset"></i></div>
                <div>
                    <p class="section-title">Contact Information</p>
                    <p class="section-desc">How buyers can reach you directly.</p>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Phone</label>
                    <div class="input-icon-group">
                        <i class="bi bi-telephone"></i>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $shop->phone) }}" placeholder="0788 123 456">
                    </div>
                    @error('phone') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">WhatsApp Number</label>
                    <div class="input-icon-group">
                        <i class="bi bi-whatsapp"></i>
                        <input type="text" name="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror" value="{{ old('whatsapp_number', $shop->whatsapp_number) }}" placeholder="0788 123 456">
                    </div>
                    @error('whatsapp_number') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email <span class="optional-tag">(optional)</span></label>
                    <div class="input-icon-group">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $shop->email) }}" placeholder="shop@example.com">
                    </div>
                    @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Location --}}
        <div class="form-section">
            <div class="section-eyebrow">
                <div class="section-icon"><i class="bi bi-geo-alt"></i></div>
                <div>
                    <p class="section-title">Location</p>
                    <p class="section-desc">Helps buyers find you and estimate delivery.</p>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Province</label>
                    <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province', $shop->province) }}">
                    @error('province') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">District</label>
                    <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district', $shop->district) }}">
                    @error('district') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sector</label>
                    <input type="text" name="sector" class="form-control @error('sector') is-invalid @enderror" value="{{ old('sector', $shop->sector) }}">
                    @error('sector') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-0">
                <label class="form-label">Address <span class="optional-tag">(optional)</span></label>
                <div class="input-icon-group">
                    <i class="bi bi-pin-map"></i>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $shop->address) }}" placeholder="Street, building, landmark...">
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="form-actions">
            <div class="form-actions-hint">
                <i class="bi bi-shield-check"></i> Changes are visible on your public shop page immediately.
            </div>
            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-terra-outline">Cancel</a>
                <button type="submit" class="btn btn-terra">
                    <i class="bi bi-check2"></i> Save Changes
                </button>
            </div>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function wireUploader(inputId, previewId, fileNameId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const fileNameEl = document.getElementById(fileNameId);
        if (!input) return;

        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) return;

            fileNameEl.textContent = '· ' + file.name;

            const reader = new FileReader();
            reader.onload = function (e) {
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.id = preview.id;
                    img.src = e.target.result;
                    img.className = preview.className.replace('uploader-placeholder', 'uploader-preview');
                    preview.replaceWith(img);
                }
            };
            reader.readAsDataURL(file);
        });
    }

    wireUploader('logoInput', 'logoPreview', 'logoFileName');
    wireUploader('coverInput', 'coverPreview', 'coverFileName');
});
</script>
@endpush