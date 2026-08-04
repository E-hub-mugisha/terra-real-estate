@extends('layouts.app')
@section('title', 'Edit ' . $shop->name)
@section('content')

<div class="shop-edit">

    <nav class="small mb-3 breadcrumb-nav">
        <a href="{{ route('admin.shops.index') }}" class="text-decoration-none">Shops</a>
        <span class="mx-1">/</span>
        <a href="{{ route('admin.shops.show', $shop->id) }}" class="text-decoration-none">{{ $shop->name }}</a>
        <span class="mx-1">/</span>
        <span class="fw-medium current-crumb">Edit</span>
    </nav>

    <h1 class="fw-bold mb-4 page-title">Edit Shop</h1>

    @if ($errors->any())
    <div class="error-box mb-4">
        <strong>Please fix the following:</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.shops.update', $shop->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- Basic info --}}
            <div class="col-lg-8">
                <div class="detail-card mb-4">
                    <h2 class="section-label mb-3">Basic Information</h2>

                    <div class="mb-3">
                        <label for="ownname" class="form-label field-label-lg">Owner</label>
                        <input type="text" name="ownname" id="ownname" class="form-control form-input"
                            value="{{ old('ownname', $shop->ownname) }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label field-label-lg">Shop name <span class="required-mark">*</span></label>
                        <input type="text" name="name" id="name" class="form-control form-input"
                            value="{{ old('name', $shop->name) }}" required>
                        <p class="field-hint mt-1 mb-0">Slug: {{ $shop->slug }} (regenerates only if left blank on creation — unaffected by name edits here).</p>
                    </div>

                    <div class="mb-0">
                        <label for="description" class="form-label field-label-lg">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control form-input">{{ old('description', $shop->description) }}</textarea>
                    </div>
                </div>

                <div class="detail-card mb-4">
                    <h2 class="section-label mb-3">Contact</h2>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="phone" class="form-label field-label-lg">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control form-input"
                                value="{{ old('phone', $shop->phone) }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="whatsapp_number" class="form-label field-label-lg">WhatsApp number</label>
                            <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control form-input"
                                value="{{ old('whatsapp_number', $shop->whatsapp_number) }}">
                        </div>
                        <div class="col-sm-12">
                            <label for="email" class="form-label field-label-lg">Email</label>
                            <input type="email" name="email" id="email" class="form-control form-input"
                                value="{{ old('email', $shop->email) }}">
                        </div>
                    </div>
                </div>

                <div class="detail-card">
                    <h2 class="section-label mb-3">Location</h2>

                    <div class="row g-3">
                        <div class="col-sm-4">
                            <label for="province" class="form-label field-label-lg">Province</label>
                            <input type="text" name="province" id="province" class="form-control form-input"
                                value="{{ old('province', $shop->province) }}">
                        </div>
                        <div class="col-sm-4">
                            <label for="district" class="form-label field-label-lg">District</label>
                            <input type="text" name="district" id="district" class="form-control form-input"
                                value="{{ old('district', $shop->district) }}">
                        </div>
                        <div class="col-sm-4">
                            <label for="sector" class="form-label field-label-lg">Sector</label>
                            <input type="text" name="sector" id="sector" class="form-control form-input"
                                value="{{ old('sector', $shop->sector) }}">
                        </div>
                        <div class="col-sm-12">
                            <label for="address" class="form-label field-label-lg">Street address</label>
                            <input type="text" name="address" id="address" class="form-control form-input"
                                value="{{ old('address', $shop->address) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Media + status --}}
            <div class="col-lg-4">
                <div class="detail-card mb-4">
                    <h2 class="section-label mb-3">Logo</h2>
                    <div class="upload-box mb-2" id="logo-preview-box">
                        @if ($shop->logo)
                        <img src="{{ asset('storage/' . $shop->logo) }}" alt="{{ $shop->name }}">
                        @else
                        <span class="upload-placeholder">No logo uploaded</span>
                        @endif
                    </div>
                    <input type="file" name="logo" id="logo" accept="image/*" class="form-control form-input">
                    <p class="field-hint mt-1 mb-0">Leave blank to keep the current logo.</p>
                </div>

                <div class="detail-card mb-4">
                    <h2 class="section-label mb-3">Cover Image</h2>
                    <div class="upload-box upload-box-wide mb-2" id="cover-preview-box">
                        @if ($shop->cover_image)
                        <img src="{{ asset('storage/' . $shop->cover_image) }}" alt="{{ $shop->name }} cover">
                        @else
                        <span class="upload-placeholder">No cover image uploaded</span>
                        @endif
                    </div>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*" class="form-control form-input">
                    <p class="field-hint mt-1 mb-0">Leave blank to keep the current cover image.</p>
                </div>

                <div class="detail-card">
                    <h2 class="section-label mb-3">Status</h2>

                    <div class="mb-3">
                        <label for="status" class="form-label field-label-lg">Approval status</label>
                        <select name="status" id="status" class="form-select form-input">
                            <option value="approved" @selected(old('status', $shop->status) === 'approved')>Approved</option>
                            <option value="pending" @selected(old('status', $shop->status) === 'pending')>Pending</option>
                            <option value="rejected" @selected(old('status', $shop->status) === 'rejected')>Rejected</option>
                            <option value="suspended" @selected(old('status', $shop->status) === 'suspended')>Suspended</option>
                        </select>
                    </div>

                    <div class="mb-3" id="rejection-reason-wrap" style="{{ old('status', $shop->status) === 'rejected' ? '' : 'display:none;' }}">
                        <label for="rejection_reason" class="form-label field-label-lg">Rejection reason</label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="3" class="form-control form-input"
                            placeholder="Shown to the shop owner">{{ old('rejection_reason', $shop->rejection_reason) }}</textarea>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1"
                            @checked(old('is_featured', $shop->is_featured))>
                        <label for="is_featured" class="form-check-label field-label-lg mb-0">Feature this shop</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn save-btn fw-semibold">Save Changes</button>
            <a href="{{ route('admin.shops.show', $shop->id) }}" class="btn cancel-btn fw-medium">Cancel</a>
        </div>
    </form>
</div>

<style>
    :root {
        --navy-dark: #111a45;
        --navy: #19265d;
        --gold: #D05208;
        --gold-light: #fff3e9;
        --font-heading: 'Cormorant Garamond', serif;
        --font-body: 'DM Sans', sans-serif;
    }

    .shop-edit {
        font-family: var(--font-body);
        color: var(--navy-dark);
    }

    .breadcrumb-nav {
        color: #6b7280;
    }

    .breadcrumb-nav a {
        color: #6b7280;
        transition: color .15s ease;
    }

    .breadcrumb-nav a:hover {
        color: var(--gold);
    }

    .current-crumb {
        color: var(--navy-dark);
    }

    .page-title {
        font-family: var(--font-heading);
        color: var(--navy-dark);
        font-size: 1.9rem;
    }

    .error-box {
        background-color: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        border-radius: 10px;
        padding: 1rem 1.2rem;
        font-size: .88rem;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #eef0f5;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 6px 24px rgba(17, 26, 69, .06);
    }

    .section-label {
        font-family: var(--font-heading);
        font-size: 1.2rem;
        color: var(--navy);
        margin: 0;
    }

    .field-label-lg {
        font-size: .82rem;
        font-weight: 600;
        color: var(--navy-dark);
    }

    .required-mark {
        color: var(--gold);
    }

    .form-input {
        border: 1px solid #e2e5ee;
        border-radius: 8px;
    }

    .form-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .12);
    }

    .field-hint {
        font-size: .76rem;
        color: #9ca3af;
    }

    .upload-box {
        height: 88px;
        border-radius: 10px;
        background-color: var(--gold-light);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .upload-box-wide {
        height: 100px;
    }

    .upload-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .upload-placeholder {
        font-size: .78rem;
        color: var(--gold);
        font-weight: 500;
    }

    .form-check-input:checked {
        background-color: var(--gold);
        border-color: var(--gold);
    }

    .save-btn {
        background-color: var(--gold);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: .55rem 1.4rem;
        transition: background-color .15s ease;
    }

    .save-btn:hover {
        background-color: #b34606;
        color: #fff;
    }

    .cancel-btn {
        background-color: #fff;
        color: #6b7280;
        border: 1px solid #e2e5ee;
        border-radius: 8px;
        padding: .55rem 1.4rem;
    }

    .cancel-btn:hover {
        border-color: var(--navy);
        color: var(--navy);
    }
</style>

@once
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@endonce

<script>
    function previewImage(inputId, boxId) {
        const input = document.getElementById(inputId);
        const box = document.getElementById(boxId);
        input.addEventListener('change', function () {
            if (!this.files || !this.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                box.innerHTML = `<img src="${e.target.result}" alt="preview">`;
            };
            reader.readAsDataURL(this.files[0]);
        });
    }

    previewImage('logo', 'logo-preview-box');
    previewImage('cover_image', 'cover-preview-box');

    document.getElementById('status').addEventListener('change', function () {
        document.getElementById('rejection-reason-wrap').style.display =
            this.value === 'rejected' ? '' : 'none';
    });
</script>

@endsection