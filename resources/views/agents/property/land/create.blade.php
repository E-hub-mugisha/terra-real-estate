@extends('layouts.agents')
@section('title', 'Add New Land Property')
@section('content')

<style>
    :root {
        --accent: #c9a96e;
        --accent-lt: #e4c990;
        --danger: #dc3545;
        --success: #198754;
        --border: #e2e8f0;
        --surface: #f8fafc;
        --muted: #94a3b8;
        --text: #1e293b;
        --text-dim: #64748b;
        --radius: 10px;
    }

    .lp-page {
        padding: 1.75rem 0 3rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* ── Page heading ── */
    .lp-heading {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .lp-heading-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: linear-gradient(135deg, #c9a96e22, #c9a96e44);
        border: 1px solid #c9a96e55;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        flex-shrink: 0;
    }

    .lp-heading h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .lp-heading p {
        font-size: .82rem;
        color: var(--text-dim);
        margin: .15rem 0 0;
    }

    /* ── Step pills ── */
    .lp-steps {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 2rem;
        overflow-x: auto;
        padding-bottom: .25rem;
    }

    .lp-step {
        display: flex;
        align-items: center;
        gap: .55rem;
        padding: .55rem 1.1rem;
        font-size: .78rem;
        font-weight: 500;
        color: var(--muted);
        white-space: nowrap;
    }

    .lp-step.active {
        color: var(--accent);
    }

    .lp-step.done {
        color: var(--success);
    }

    .lp-step-num {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1.5px solid currentColor;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .7rem;
        flex-shrink: 0;
    }

    .lp-step.active .lp-step-num {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }

    .lp-step-sep {
        flex: 1;
        height: 1px;
        min-width: 24px;
        background: var(--border);
    }

    /* ── Section card ── */
    .lp-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-bottom: 1.25rem;
        overflow: hidden;
    }

    .lp-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .lp-card-header-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #c9a96e18;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        flex-shrink: 0;
    }

    .lp-card-header h6 {
        margin: 0;
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
    }

    .lp-card-header span {
        margin-left: auto;
        font-size: .73rem;
        color: var(--muted);
    }

    .lp-card-body {
        padding: 1.5rem;
    }

    /* ── Form controls ── */
    .lp-label {
        display: block;
        font-size: .77rem;
        font-weight: 600;
        letter-spacing: .03em;
        color: var(--text-dim);
        text-transform: uppercase;
        margin-bottom: .45rem;
    }

    .lp-label .req {
        color: var(--danger);
        margin-left: .2rem;
    }

    .lp-input,
    .lp-select,
    .lp-textarea {
        width: 100%;
        padding: .65rem .9rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .875rem;
        color: var(--text);
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
        font-family: inherit;
    }

    .lp-input:focus,
    .lp-select:focus,
    .lp-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px #c9a96e18;
    }

    .lp-input.is-invalid,
    .lp-select.is-invalid,
    .lp-textarea.is-invalid {
        border-color: var(--danger);
    }

    .lp-textarea {
        resize: vertical;
        line-height: 1.6;
    }

    .lp-hint {
        font-size: .73rem;
        color: var(--muted);
        margin-top: .35rem;
    }

    .lp-error {
        font-size: .73rem;
        color: var(--danger);
        margin-top: .35rem;
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    /* ── Price input ── */
    .lp-input-group {
        position: relative;
        display: flex;
        align-items: stretch;
    }

    .lp-input-group-text {
        padding: .65rem .85rem;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-right: none;
        border-radius: 8px 0 0 8px;
        font-size: .82rem;
        font-weight: 600;
        color: var(--muted);
        display: flex;
        align-items: center;
    }

    .lp-input-group .lp-input {
        border-radius: 0 8px 8px 0;
        flex: 1;
    }

    /* ── Image upload zone ── */
    .lp-dropzone {
        border: 2px dashed var(--border);
        border-radius: 10px;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: var(--surface);
        position: relative;
    }

    .lp-dropzone:hover,
    .lp-dropzone.dragover {
        border-color: var(--accent);
        background: #c9a96e08;
    }

    .lp-dropzone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .lp-dropzone-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #c9a96e18;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto .75rem;
        color: var(--accent);
    }

    .lp-dropzone h6 {
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
        margin: 0 0 .25rem;
    }

    .lp-dropzone p {
        font-size: .78rem;
        color: var(--muted);
        margin: 0;
    }

    .lp-dropzone .lp-browse {
        color: var(--accent);
        font-weight: 500;
    }

    /* ── Image previews ── */
    .lp-previews {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: .6rem;
        margin-top: 1rem;
    }

    .lp-preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1;
        background: var(--border);
    }

    .lp-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .lp-preview-remove {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(0, 0, 0, .6);
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 10px;
        line-height: 1;
    }

    /* ── Doc upload ── */
    .lp-file-btn {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .75rem 1rem;
        border: 1.5px dashed var(--border);
        border-radius: 8px;
        background: var(--surface);
        cursor: pointer;
        transition: border-color .2s;
        position: relative;
    }

    .lp-file-btn:hover {
        border-color: var(--accent);
    }

    .lp-file-btn input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }

    .lp-file-btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #c9a96e18;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        flex-shrink: 0;
    }

    .lp-file-btn-text {
        font-size: .82rem;
        color: var(--text-dim);
    }

    .lp-file-btn-text strong {
        display: block;
        color: var(--text);
        font-size: .85rem;
        margin-bottom: .1rem;
    }

    /* ── Zoning badge grid ── */
    .lp-zone-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: .5rem;
    }

    .lp-zone-item {
        display: none;
    }

    .lp-zone-label {
        display: flex;
        align-items: center;
        gap: .5rem;
        padding: .6rem .85rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .8rem;
        color: var(--text-dim);
        cursor: pointer;
        transition: all .15s;
        user-select: none;
    }

    .lp-zone-item:checked+.lp-zone-label {
        border-color: var(--accent);
        background: #c9a96e10;
        color: var(--accent);
        font-weight: 500;
    }

    .lp-zone-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        border: 2px solid currentColor;
        flex-shrink: 0;
    }

    .lp-zone-item:checked+.lp-zone-label .lp-zone-dot {
        background: var(--accent);
        border-color: var(--accent);
    }

    /* ── Submit bar ── */
    .lp-submit-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .75rem;
        padding: 1.25rem 1.5rem;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        margin-top: 1.25rem;
    }

    .lp-btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .65rem 1.5rem;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        font-family: inherit;
    }

    .lp-btn-primary {
        background: var(--accent);
        color: #fff;
    }

    .lp-btn-primary:hover {
        background: var(--accent-lt);
        color: #fff;
        transform: translateY(-1px);
    }

    .lp-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .lp-btn-ghost:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    /* ── Alerts ── */
    .lp-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: flex-start;
        margin-bottom: 1.25rem;
    }

    .lp-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    .lp-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .lp-alert ul {
        margin: .35rem 0 0 1rem;
        padding: 0;
    }

    .lp-alert li {
        margin-bottom: .2rem;
    }
</style>

<div class="lp-page">

    {{-- ── Page heading ── --}}
    <div class="lp-heading">
        <div class="lp-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <path d="M9 22V12h6v10" />
            </svg>
        </div>
        <div>
            <h4>Add New Land Property</h4>
            <p>Fill in all required fields then submit for approval.</p>
        </div>
    </div>

    {{-- ── Steps ── --}}
    <div class="lp-steps">
        <div class="lp-step active">
            <span class="lp-step-num">1</span> Property Info
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step">
            <span class="lp-step-num">2</span> Location
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step">
            <span class="lp-step-num">3</span> Media
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step">
            <span class="lp-step-num">4</span> Review
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
    <div class="lp-alert lp-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4m0 4h.01" />
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="lp-alert lp-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('agent.properties.lands.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- ══ SECTION 1 — Property Details ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                </div>
                <h6>Property Details</h6>
                <span>Step 1 of 4</span>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">

                    {{-- Title --}}
                    <div class="col-12">
                        <label class="lp-label">Property Title <span class="req">*</span></label>
                        <input type="text" name="title" class="lp-input @error('title') is-invalid @enderror"
                            placeholder="e.g. Prime Residential Plot in Kicukiro"
                            value="{{ old('title') }}" required>
                        @error('title')<p class="lp-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 8v4m0 4h.01" />
                            </svg>
                            {{ $message }}
                        </p>@enderror
                    </div>

                    {{-- UPI + Service --}}
                    <div class="col-md-6">
                        <label class="lp-label">Land UPI</label>
                        <input type="text" name="upi" class="lp-input @error('upi') is-invalid @enderror"
                            placeholder="e.g. 1/01/01/01/1234"
                            value="{{ old('upi') }}">
                        <p class="lp-hint">Unique Parcel Identifier from RLMUA.</p>
                        @error('upi')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="lp-label">Service <span class="req">*</span></label>
                        <select name="service_id" class="lp-select @error('service_id') is-invalid @enderror" required>
                            <option value="">Select service</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->title }}
                            </option>
                            @endforeach
                        </select>
                        @error('service_id')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Price + Area + Status --}}
                    <div class="col-md-4">
                        <label class="lp-label">Price <span class="req">*</span></label>
                        <div class="lp-input-group">
                            <span class="lp-input-group-text">$</span>
                            <input type="number" name="price" class="lp-input @error('price') is-invalid @enderror"
                                placeholder="0.00" min="0" step="0.01"
                                value="{{ old('price') }}" required>
                        </div>
                        @error('price')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="lp-label">Area <span class="req">*</span></label>
                        <div class="lp-input-group">
                            <input type="number" name="size_sqm" class="lp-input @error('size_sqm') is-invalid @enderror"
                                placeholder="0" min="1"
                                value="{{ old('size_sqm') }}" required
                                style="border-radius:8px 0 0 8px;border-right:none;">
                            <span class="lp-input-group-text" style="border-left:none;border-radius:0 8px 8px 0;">sqm</span>
                        </div>
                        @error('size_sqm')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="lp-label">Status <span class="req">*</span></label>
                        <select name="status" class="lp-select @error('status') is-invalid @enderror" required>
                            <option value="available" {{ old('status','available') === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved" {{ old('status') === 'reserved'  ? 'selected' : '' }}>Reserved</option>
                            <option value="sold" {{ old('status') === 'sold'      ? 'selected' : '' }}>Sold</option>
                        </select>
                        @error('status')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Land Use --}}
                    <div class="col-md-6">
                        <label class="lp-label">Land Use <span class="req">*</span></label>
                        <select name="land_use" class="lp-select @error('land_use') is-invalid @enderror" required>
                            <option value="">Select land use</option>
                            @foreach([
                            'Residential' => 'Residential',
                            'Commercial' => 'Commercial',
                            'Industrial' => 'Industrial',
                            'Agricultural' => 'Agricultural',
                            'Mixed-use' => 'Mixed-use',
                            'Institutional' => 'Institutional',
                            'Recreational' => 'Recreational',
                            'Conservation' => 'Conservation',
                            'Transportation' => 'Transportation',
                            'Hospitality & Tourism' => 'Hospitality & Tourism',
                            ] as $val => $label)
                            <option value="{{ $val }}" {{ old('land_use') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('land_use')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Zoning --}}
                    <div class="col-md-6">
                        <label class="lp-label">Zoning Type <span class="req">*</span></label>
                        <div class="lp-zone-grid">
                            @php
                            $zones = [
                            'R1' => 'R1 Low density',
                            'R2' => 'R2 Medium density',
                            'R3' => 'R3 High density',
                            'Commercial' => 'Commercial',
                            'Industrial' => 'Industrial',
                            'Agricultural'=> 'Agricultural',
                            ];
                            @endphp
                            @foreach($zones as $val => $label)
                            <input type="radio" name="zoning" id="zone_{{ $val }}"
                                value="{{ $val }}" class="lp-zone-item"
                                {{ old('zoning', 'R1') === $val ? 'checked' : '' }}>
                            <label for="zone_{{ $val }}" class="lp-zone-label">
                                <span class="lp-zone-dot"></span>{{ $label }}
                            </label>
                            @endforeach
                        </div>
                        @error('zoning')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="lp-label">Description</label>
                        <textarea name="description" class="lp-textarea @error('description') is-invalid @enderror"
                            rows="4" placeholder="Describe the land — access roads, utilities, surrounding amenities…">{{ old('description') }}</textarea>
                        @error('description')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ══ SECTION 2 — Location ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>
                <h6>Location Details</h6>
                <span>Step 2 of 4</span>
            </div>
            <div class="lp-card-body">
                @include('includes.form')
            </div>
        </div>

        {{-- ══ SECTION 3 — Media ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <circle cx="9" cy="9" r="2" />
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                    </svg>
                </div>
                <h6>Photos &amp; Documents</h6>
                <span>Step 3 of 4</span>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">

                    {{-- Images --}}
                    <div class="col-12">
                        <label class="lp-label">Property Photos</label>
                        <div class="lp-dropzone" id="imageDropzone">
                            <input type="file" name="images[]" id="imageInput"
                                accept="image/*" multiple>
                            <div class="lp-dropzone-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="17 8 12 3 7 8" />
                                    <line x1="12" x2="12" y1="3" y2="15" />
                                </svg>
                            </div>
                            <h6>Drag &amp; drop photos here</h6>
                            <p>or <span class="lp-browse">browse files</span> — JPG, PNG, WEBP, up to 5MB each</p>
                        </div>
                        <div class="lp-previews" id="imagePreviews"></div>
                        @error('images.*')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Title deed --}}
                    <div class="col-12">
                        <label class="lp-label">Title Deed / Document</label>
                        <div class="lp-file-btn" id="titleDocBtn">
                            <input type="file" name="title_doc" id="titleDocInput"
                                accept=".pdf,.jpg,.jpeg,.png">
                            <div class="lp-file-btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                </svg>
                            </div>
                            <div class="lp-file-btn-text">
                                <strong id="titleDocName">Click to upload title deed</strong>
                                PDF, JPG, PNG — max 4MB
                            </div>
                        </div>
                        <p class="lp-hint">Optional. Upload the official land title or ownership document.</p>
                        @error('title_doc')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>
        </div>
        {{-- ── Listing Package ─────────────────────────────────────────── --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Listing Package <span class="text-danger">*</span></label>
                <select name="listing_package_id" class="form-select" onchange="recalcFee()" required>
                    <option value="">Select a package</option>
                    @foreach($packages as $pkg)
                    <option value="{{ $pkg->id }}"
                        data-price="{{ $pkg->price_per_day }}"
                        data-agent-pct="{{ $pkg->agent_commission_pct }}"
                        data-terra-pct="{{ $pkg->terra_share_pct }}"
                        {{ old('listing_package_id') == $pkg->id ? 'selected' : '' }}>
                        {{ ucfirst($pkg->package_tier) }}
                        — RWF {{ number_format($pkg->price_per_day) }}/day
                        (you earn {{ $pkg->agent_commission_pct }}%)
                    </option>
                    @endforeach
                </select>
                @error('listing_package_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Listing Duration (days) <span class="text-danger">*</span></label>
                <input type="number" name="listing_days" class="form-control"
                    value="{{ old('listing_days', 30) }}" min="1" oninput="recalcFee()" required>
                <div class="form-text">31-59 days: 10% off &nbsp;·&nbsp; 61-89 days: 15% off &nbsp;·&nbsp; 90+ days: 20% off</div>
                @error('listing_days')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Fee breakdown preview --}}
        <div id="feeBreakdown" class="p-3 mb-4 rounded border" style="display:none;background:#f8fafc;font-size:.85rem;">
            <h6 class="mb-3 fw-semibold" style="color:#1e293b;">💰 Fee Breakdown</h6>
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Gross listing fee</span><strong id="fbGross">—</strong>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Duration discount</span>
                <strong id="fbDiscount" style="color:#22c55e">—</strong>
            </div>
            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                <span class="text-muted">Net listing fee (owner pays)</span><strong id="fbNet">—</strong>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Your commission (<span id="fbAgentPct">0</span>%)</span>
                <strong id="fbAgentAmt" style="color:#c9a96e">—</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Terra platform fee</span><strong id="fbTerra">—</strong>
            </div>
        </div>

        {{-- ── Owner Information ────────────────────────────────────────── --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">Property Owner Information</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Owner Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror"
                            value="{{ old('owner_name') }}" placeholder="Full legal name" required>
                        @error('owner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">National ID / Passport No.</label>
                        <input type="text" name="owner_id_number" class="form-control @error('owner_id_number') is-invalid @enderror"
                            value="{{ old('owner_id_number') }}" placeholder="1 XXXX X XXXXXXX X XX">
                        @error('owner_id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Phone <span class="text-danger">*</span></label>
                        <input type="text" name="owner_phone" class="form-control @error('owner_phone') is-invalid @enderror"
                            value="{{ old('owner_phone') }}" placeholder="+250 7XX XXX XXX" required>
                        @error('owner_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Email</label>
                        <input type="email" name="owner_email" class="form-control @error('owner_email') is-invalid @enderror"
                            value="{{ old('owner_email') }}" placeholder="owner@email.com">
                        @error('owner_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <script>
            const discountRules = [{
                    min: 90,
                    pct: 20
                },
                {
                    min: 61,
                    pct: 15
                },
                {
                    min: 31,
                    pct: 10
                },
                {
                    min: 0,
                    pct: 0
                },
            ];

            function getDiscount(days) {
                for (const r of discountRules) {
                    if (days >= r.min) return r.pct;
                }
                return 0;
            }

            function fmt(n) {
                return 'RWF ' + Math.round(n).toLocaleString('en-RW');
            }

            function recalcFee() {
                const sel = document.querySelector('[name="listing_package_id"]');
                const daysEl = document.querySelector('[name="listing_days"]');
                const days = parseInt(daysEl?.value || 0);
                const opt = sel?.options[sel.selectedIndex];
                const price = parseFloat(opt?.dataset.price || 0);
                const agentPct = parseFloat(opt?.dataset.agentPct || 0);
                const terraPct = parseFloat(opt?.dataset.terraPct || 0);
                const box = document.getElementById('feeBreakdown');

                if (!sel?.value || days < 1 || !price) {
                    box.style.display = 'none';
                    return;
                }

                const dPct = getDiscount(days);
                const gross = price * days;
                const discAmt = gross * dPct / 100;
                const net = gross - discAmt;
                const agentAmt = net * agentPct / 100;
                const terraAmt = net * terraPct / 100;

                document.getElementById('fbGross').textContent = fmt(gross);
                document.getElementById('fbDiscount').textContent = dPct > 0 ? `- ${fmt(discAmt)} (${dPct}%)` : 'None';
                document.getElementById('fbNet').textContent = fmt(net);
                document.getElementById('fbAgentPct').textContent = agentPct;
                document.getElementById('fbAgentAmt').textContent = fmt(agentAmt);
                document.getElementById('fbTerra').textContent = fmt(terraAmt);
                box.style.display = 'block';
            }

            // Recalculate whenever either field changes
            document.querySelector('[name="listing_package_id"]')?.addEventListener('change', recalcFee);
        </script>
        {{-- ══ Submit bar ══ --}}
        <div class="lp-submit-bar">
            <a href="{{ route('agent.properties.land.index') }}" class="lp-btn lp-btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Cancel
            </a>
            <button type="submit" class="lp-btn lp-btn-primary">
                Save &amp; Continue
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </button>
        </div>

    </form>
</div>

<script>
    /* ── Image previews ── */
    const imageInput = document.getElementById('imageInput');
    const imagePreviews = document.getElementById('imagePreviews');
    const imageDropzone = document.getElementById('imageDropzone');
    let selectedFiles = [];

    imageInput.addEventListener('change', () => addFiles(imageInput.files));

    imageDropzone.addEventListener('dragover', e => {
        e.preventDefault();
        imageDropzone.classList.add('dragover');
    });
    imageDropzone.addEventListener('dragleave', () => imageDropzone.classList.remove('dragover'));
    imageDropzone.addEventListener('drop', e => {
        e.preventDefault();
        imageDropzone.classList.remove('dragover');
        addFiles(e.dataTransfer.files);
    });

    function addFiles(files) {
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            selectedFiles.push(file);
            const reader = new FileReader();
            reader.onload = e => renderPreview(e.target.result, selectedFiles.length - 1);
            reader.readAsDataURL(file);
        });
        syncInput();
    }

    function renderPreview(src, idx) {
        const div = document.createElement('div');
        div.className = 'lp-preview-item';
        div.dataset.idx = idx;
        div.innerHTML = `<img src="${src}" alt="preview">
            <button type="button" class="lp-preview-remove" onclick="removePreview(${idx})">✕</button>`;
        imagePreviews.appendChild(div);
    }

    function removePreview(idx) {
        selectedFiles[idx] = null;
        document.querySelector(`.lp-preview-item[data-idx="${idx}"]`)?.remove();
        syncInput();
    }

    function syncInput() {
        const dt = new DataTransfer();
        selectedFiles.filter(Boolean).forEach(f => dt.items.add(f));
        imageInput.files = dt.files;
    }

    /* ── Title doc name ── */
    document.getElementById('titleDocInput').addEventListener('change', function() {
        document.getElementById('titleDocName').textContent =
            this.files[0] ? this.files[0].name : 'Click to upload title deed';
    });
</script>

@endsection