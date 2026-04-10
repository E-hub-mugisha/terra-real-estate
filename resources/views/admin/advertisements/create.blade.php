@extends('layouts.app')

@section('title', 'New Advertisement')

@section('content')

<style>
    :root {
        --navy:   #19265d;
        --gold:   #C8873A;
        --gold-lt:#e0a55e;
        --cream:  #f9f6f1;
        --ink:    #1a1a2e;
        --muted:  #6b7280;
        --border: rgba(200,135,58,.18);
        --card-bg:#ffffff;
        --shadow: 0 2px 16px rgba(25,38,93,.08);
        --error:  #dc2626;
    }

    /* ── Header ──────────────────────────────────────────────── */
    .form-header {
        margin-bottom: 2rem;
    }

    .form-header .breadcrumb-label {
        font-family: 'DM Sans', sans-serif;
        font-size: .7rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: .3rem;
    }

    .form-header h1 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.9rem;
        font-weight: 600;
        color: var(--navy);
        margin: 0;
    }

    /* ── Form layout ─────────────────────────────────────────── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 860px) {
        .form-grid { grid-template-columns: 1fr; }
    }

    /* ── Section card ────────────────────────────────────────── */
    .section-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        margin-bottom: 1.25rem;
    }

    .section-card:last-child { margin-bottom: 0; }

    .section-title {
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--gold);
        font-weight: 600;
        margin-bottom: 1.1rem;
        padding-bottom: .6rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* ── Form fields ─────────────────────────────────────────── */
    .field-group {
        margin-bottom: 1.1rem;
    }

    .field-group:last-child { margin-bottom: 0; }

    .field-group label {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--navy);
        margin-bottom: .4rem;
    }

    .field-group label .req {
        color: var(--gold);
        margin-left: .15rem;
    }

    .field-group input[type="text"],
    .field-group input[type="email"],
    .field-group input[type="number"],
    .field-group input[type="tel"],
    .field-group select,
    .field-group textarea {
        width: 100%;
        font-family: 'DM Sans', sans-serif;
        font-size: .875rem;
        color: var(--ink);
        border: 1px solid rgba(25,38,93,.18);
        border-radius: 7px;
        padding: .6rem .85rem;
        background: var(--cream);
        outline: none;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
    }

    .field-group input:focus,
    .field-group select:focus,
    .field-group textarea:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(200,135,58,.1);
    }

    .field-group textarea { resize: vertical; min-height: 100px; }

    .field-group .field-hint {
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        color: var(--muted);
        margin-top: .3rem;
    }

    .field-group .error-msg {
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        color: var(--error);
        margin-top: .3rem;
    }

    .field-group input.is-invalid,
    .field-group select.is-invalid,
    .field-group textarea.is-invalid {
        border-color: var(--error);
    }

    /* Two-col fields */
    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 600px) { .two-col { grid-template-columns: 1fr; } }

    /* ── File upload ─────────────────────────────────────────── */
    .upload-zone {
        border: 2px dashed rgba(200,135,58,.35);
        border-radius: 8px;
        padding: 1.5rem 1rem;
        text-align: center;
        background: rgba(200,135,58,.03);
        cursor: pointer;
        transition: border-color .2s, background .2s;
        position: relative;
    }

    .upload-zone:hover {
        border-color: var(--gold);
        background: rgba(200,135,58,.06);
    }

    .upload-zone input[type="file"] {
        position: absolute; inset: 0;
        opacity: 0; cursor: pointer;
        width: 100%; height: 100%;
    }

    .upload-zone .upload-icon {
        font-size: 1.8rem;
        color: var(--gold);
        margin-bottom: .4rem;
    }

    .upload-zone p {
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        color: var(--muted);
        margin: 0;
    }

    .upload-zone p strong { color: var(--navy); }

    #image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: .5rem;
        margin-top: .75rem;
    }

    #image-preview img {
        width: 72px; height: 72px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid var(--border);
    }

    /* ── Submit button ───────────────────────────────────────── */
    .btn-terra {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 600;
        letter-spacing: .05em;
        padding: .65rem 1.5rem;
        border-radius: 8px;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: all .18s;
    }

    .btn-terra.primary { background: var(--gold); color: #fff; }
    .btn-terra.primary:hover { background: #b5752e; color: #fff; transform: translateY(-1px); }
    .btn-terra.outline { background: transparent; border-color: var(--navy); color: var(--navy); }
    .btn-terra.outline:hover { background: var(--navy); color: #fff; }

    /* ── Package selector ────────────────────────────────────── */
    .pkg-cards {
        display: flex;
        flex-direction: column;
        gap: .6rem;
    }

    .pkg-card {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .8rem 1rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        cursor: pointer;
        transition: all .18s;
        background: var(--cream);
    }

    .pkg-card:hover { border-color: var(--gold); }

    .pkg-card input[type="radio"] {
        accent-color: var(--gold);
        width: 16px; height: 16px;
        flex-shrink: 0;
    }

    .pkg-card input[type="radio"]:checked + .pkg-info { color: var(--navy); }

    .pkg-card:has(input:checked) {
        border-color: var(--gold);
        background: rgba(200,135,58,.06);
    }

    .pkg-card .pkg-info .pkg-name {
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        font-weight: 600;
        color: var(--navy);
    }

    .pkg-card .pkg-info .pkg-price {
        font-family: 'DM Sans', sans-serif;
        font-size: .75rem;
        color: var(--gold);
    }

    /* ── Cost preview ────────────────────────────────────────── */
    .cost-preview {
        background: var(--navy);
        color: #fff;
        border-radius: 8px;
        padding: 1rem 1.1rem;
        margin-top: .75rem;
        font-family: 'DM Sans', sans-serif;
        display: none;
    }

    .cost-preview.visible { display: block; }

    .cost-preview .cost-row {
        display: flex;
        justify-content: space-between;
        font-size: .82rem;
        padding: .2rem 0;
        color: rgba(255,255,255,.7);
    }

    .cost-preview .cost-total {
        display: flex;
        justify-content: space-between;
        font-size: 1rem;
        font-weight: 700;
        padding-top: .5rem;
        margin-top: .4rem;
        border-top: 1px solid rgba(255,255,255,.15);
        color: var(--gold-lt);
    }
</style>

<div class="container-fluid py-4 px-4">

    {{-- Header --}}
    <div class="form-header">
        <div class="breadcrumb-label">
            <a href="{{ route('admin.advertisements.index') }}"
               style="color:var(--gold);text-decoration:none;">Advertisements</a>
            &rsaquo; New
        </div>
        <h1>Create Advertisement</h1>
    </div>

    <form
        method="POST"
        action="{{ route('admin.advertisements.store') }}"
        enctype="multipart/form-data"
        id="ad-form"
    >
        @csrf

        <div class="form-grid">

            {{-- ── LEFT ─────────────────────────────────────────── --}}
            <div>

                {{-- Core info --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="bi bi-file-text"></i> Core Information
                    </div>

                    <div class="field-group">
                        <label>Title <span class="req">*</span></label>
                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="e.g. Premium 3-Bedroom in Nyarutarama"
                            class="{{ $errors->has('title') ? 'is-invalid' : '' }}"
                            required
                        >
                        @error('title')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label>Description <span class="req">*</span></label>
                        <textarea
                            name="description"
                            placeholder="Describe the property or service being advertised…"
                            class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                            required
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label>Location</label>
                        <input
                            type="text"
                            name="location"
                            value="{{ old('location') }}"
                            placeholder="e.g. Kigali, Gasabo District"
                        >
                    </div>

                    <div class="two-col">
                        <div class="field-group">
                            <label>Price Amount</label>
                            <input
                                type="number"
                                name="price_amount"
                                value="{{ old('price_amount') }}"
                                placeholder="0"
                                min="0"
                            >
                        </div>
                        <div class="field-group">
                            <label>Currency</label>
                            <select name="currency">
                                <option value="RWF" @selected(old('currency','RWF') === 'RWF')>RWF</option>
                                <option value="USD" @selected(old('currency') === 'USD')>USD</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Contact --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="bi bi-telephone"></i> Contact Details
                    </div>

                    <div class="two-col">
                        <div class="field-group">
                            <label>Phone <span class="req">*</span></label>
                            <input
                                type="tel"
                                name="contact_phone"
                                value="{{ old('contact_phone') }}"
                                placeholder="+250 7XX XXX XXX"
                                class="{{ $errors->has('contact_phone') ? 'is-invalid' : '' }}"
                                required
                            >
                            @error('contact_phone')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="field-group">
                            <label>Email</label>
                            <input
                                type="email"
                                name="contact_email"
                                value="{{ old('contact_email') }}"
                                placeholder="contact@example.com"
                            >
                        </div>
                    </div>
                </div>

                {{-- Media --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="bi bi-images"></i> Media
                    </div>

                    <div class="field-group">
                        <label>Images</label>
                        <div class="upload-zone" id="image-drop-zone">
                            <input
                                type="file"
                                name="images[]"
                                id="image-input"
                                accept="image/*"
                                multiple
                            >
                            <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                            <p><strong>Click to upload</strong> or drag &amp; drop</p>
                            <p>PNG, JPG, WEBP · Max 2 MB each</p>
                        </div>
                        <div id="image-preview"></div>
                        @error('images.*')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label>Video</label>
                        <input
                            type="file"
                            name="video"
                            accept="video/*"
                            class="{{ $errors->has('video') ? 'is-invalid' : '' }}"
                            style="background:var(--cream);border:1px solid rgba(25,38,93,.18);border-radius:7px;padding:.5rem .85rem;width:100%;"
                        >
                        <p class="field-hint">MP4 recommended · Max 50 MB</p>
                        @error('video')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Payment --}}
                <div class="section-card">
                    <div class="section-title">
                        <i class="bi bi-phone"></i> MoMo Payment
                    </div>

                    <div class="two-col">
                        <div class="field-group">
                            <label>MoMo Phone</label>
                            <input
                                type="tel"
                                name="momo_phone"
                                value="{{ old('momo_phone') }}"
                                placeholder="+250 7XX XXX XXX"
                            >
                        </div>
                        <div class="field-group">
                            <label>Transaction ID</label>
                            <input
                                type="text"
                                name="momo_transaction_id"
                                value="{{ old('momo_transaction_id') }}"
                                placeholder="e.g. TXN123456789"
                            >
                        </div>
                    </div>

                    <div class="two-col">
                        <div class="field-group">
                            <label>Payment Status</label>
                            <select name="payment_status">
                                @foreach(['pending','confirmed','rejected'] as $ps)
                                    <option value="{{ $ps }}"
                                        @selected(old('payment_status','pending') === $ps)>
                                        {{ ucfirst($ps) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group">
                            <label>Ad Status</label>
                            <select name="status">
                                @foreach(['draft','pending_review','active','paused','expired','rejected'] as $s)
                                    <option value="{{ $s }}"
                                        @selected(old('status','draft') === $s)>
                                        {{ ucfirst(str_replace('_',' ',$s)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Admin notes --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-sticky"></i> Admin Notes</div>
                    <div class="field-group" style="margin-bottom:0;">
                        <textarea
                            name="admin_notes"
                            placeholder="Internal notes (not shown to the user)…"
                            style="min-height:70px;"
                        >{{ old('admin_notes') }}</textarea>
                    </div>
                </div>

            </div>

            {{-- ── RIGHT ────────────────────────────────────────── --}}
            <div>

                {{-- Owner --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-person"></i> Owner</div>
                    <div class="field-group" style="margin-bottom:0;">
                        <label>User <span class="req">*</span></label>
                        <select name="user_id"
                                class="{{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                required>
                            <option value="">— Select user —</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    @selected(old('user_id') == $user->id)>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Package --}}
                <div class="section-card">
                    <div class="section-title"><i class="bi bi-box"></i> Package</div>

                    <div class="pkg-cards" id="pkg-container">
                        @foreach($packages as $pkg)
                        <label class="pkg-card">
                            <input
                                type="radio"
                                name="listing_package_id"
                                value="{{ $pkg->id }}"
                                data-price="{{ $pkg->price_per_day }}"
                                @checked(old('listing_package_id') == $pkg->id)
                            >
                            <div class="pkg-info">
                                <div class="pkg-name">{{ $pkg->name }}</div>
                                <div class="pkg-price">
                                    {{ number_format($pkg->price_per_day) }} RWF / day
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    @error('listing_package_id')
                        <p class="error-msg" style="margin-top:.5rem;">{{ $message }}</p>
                    @enderror

                    <div class="field-group" style="margin-top:1rem;">
                        <label>Duration (days) <span class="req">*</span></label>
                        <input
                            type="number"
                            name="listing_days"
                            id="listing-days"
                            value="{{ old('listing_days', 7) }}"
                            min="1"
                            max="365"
                            class="{{ $errors->has('listing_days') ? 'is-invalid' : '' }}"
                            required
                        >
                        @error('listing_days')
                            <p class="error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Live cost preview --}}
                    <div class="cost-preview" id="cost-preview">
                        <div class="cost-row">
                            <span>Package rate</span>
                            <span id="cp-rate">—</span>
                        </div>
                        <div class="cost-row">
                            <span>Duration</span>
                            <span id="cp-days">—</span>
                        </div>
                        <div class="cost-total">
                            <span>Total</span>
                            <span id="cp-total">—</span>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="section-card">
                    <div style="display:flex;gap:.75rem;flex-direction:column;">
                        <button type="submit" class="btn-terra primary" style="width:100%;justify-content:center;">
                            <i class="bi bi-plus-circle"></i> Create Advertisement
                        </button>
                        <a href="{{ route('admin.advertisements.index') }}"
                           class="btn-terra outline"
                           style="width:100%;justify-content:center;">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>

</div>

<script>
    // Image preview
    document.getElementById('image-input')?.addEventListener('change', function () {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        Array.from(this.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // Live cost calculator
    function recalc() {
        const radio = document.querySelector('input[name="listing_package_id"]:checked');
        const days  = parseInt(document.getElementById('listing-days')?.value) || 0;
        const preview = document.getElementById('cost-preview');

        if (!radio || !days) { preview.classList.remove('visible'); return; }

        const rate  = parseInt(radio.dataset.price) || 0;
        const total = rate * days;

        document.getElementById('cp-rate').textContent  = rate.toLocaleString() + ' RWF/day';
        document.getElementById('cp-days').textContent  = days + ' day(s)';
        document.getElementById('cp-total').textContent = total.toLocaleString() + ' RWF';
        preview.classList.add('visible');
    }

    document.querySelectorAll('input[name="listing_package_id"]')
        .forEach(r => r.addEventListener('change', recalc));
    document.getElementById('listing-days')?.addEventListener('input', recalc);
    recalc();
</script>
@endsection