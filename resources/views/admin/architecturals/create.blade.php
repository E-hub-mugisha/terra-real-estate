@extends('layouts.app')
@section('title', 'Upload Architectural Design')
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
        --blue: #3b82f6;
    }

    .ad-page {
        padding: 1.75rem 0 3rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* ── Heading ── */
    .ad-heading {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .ad-heading-icon {
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

    .ad-heading h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .ad-heading p {
        font-size: .82rem;
        color: var(--text-dim);
        margin: .15rem 0 0;
    }

    /* ── Layout ── */
    .ad-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 1.25rem;
        align-items: start;
    }

    .ad-main {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .ad-side {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        position: sticky;
        top: 80px;
    }

    /* ── Card ── */
    .ad-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .ad-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .ad-card-header-icon {
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

    .ad-card-header h6 {
        margin: 0;
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
    }

    .ad-card-body {
        padding: 1.5rem;
    }

    /* ── Form controls ── */
    .ad-label {
        display: block;
        font-size: .77rem;
        font-weight: 600;
        letter-spacing: .03em;
        color: var(--text-dim);
        text-transform: uppercase;
        margin-bottom: .45rem;
    }

    .ad-label .req {
        color: var(--danger);
        margin-left: .2rem;
    }

    .ad-input,
    .ad-select,
    .ad-textarea {
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

    .ad-input:focus,
    .ad-select:focus,
    .ad-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px #c9a96e18;
    }

    .ad-input.is-invalid,
    .ad-select.is-invalid,
    .ad-textarea.is-invalid {
        border-color: var(--danger);
    }

    .ad-textarea {
        resize: vertical;
        line-height: 1.65;
    }

    .ad-hint {
        font-size: .73rem;
        color: var(--muted);
        margin-top: .35rem;
    }

    .ad-error {
        font-size: .73rem;
        color: var(--danger);
        margin-top: .35rem;
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    /* ── Input group ── */
    .ad-input-group {
        display: flex;
        align-items: stretch;
    }

    .ad-input-addon {
        padding: .65rem .85rem;
        background: var(--surface);
        border: 1.5px solid var(--border);
        font-size: .82rem;
        font-weight: 600;
        color: var(--muted);
        display: flex;
        align-items: center;
    }

    .ad-input-addon.prefix {
        border-right: none;
        border-radius: 8px 0 0 8px;
    }

    .ad-input-addon.suffix {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .ad-input-group .ad-input.pfx {
        border-radius: 0 8px 8px 0;
    }

    .ad-input-group .ad-input.sfx {
        border-radius: 8px 0 0 8px;
        border-right: none;
    }

    /* ── File upload ── */
    .ad-upload-zone {
        border: 2px dashed var(--border);
        border-radius: 10px;
        padding: 2rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        background: var(--surface);
        position: relative;
    }

    .ad-upload-zone:hover,
    .ad-upload-zone.dragover {
        border-color: var(--accent);
        background: #c9a96e07;
    }

    .ad-upload-zone input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .ad-upload-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        background: #c9a96e18;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto .75rem;
        color: var(--accent);
    }

    .ad-upload-zone h6 {
        font-size: .88rem;
        font-weight: 600;
        color: var(--text);
        margin: 0 0 .25rem;
    }

    .ad-upload-zone p {
        font-size: .77rem;
        color: var(--muted);
        margin: 0;
    }

    .ad-upload-browse {
        color: var(--accent);
        font-weight: 500;
    }

    /* ── File selected state ── */
    .ad-file-selected {
        display: none;
        align-items: center;
        gap: .75rem;
        padding: .85rem 1rem;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: #fff;
        margin-top: .75rem;
    }

    .ad-file-selected.visible {
        display: flex;
    }

    .ad-file-type-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .04em;
    }

    .ad-file-type-icon.pdf {
        background: #fef2f2;
        color: #b91c1c;
    }

    .ad-file-type-icon.zip {
        background: #fffbeb;
        color: #92400e;
    }

    .ad-file-type-icon.dwg {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .ad-file-type-icon.img {
        background: #f0fdf4;
        color: #166534;
    }

    .ad-file-info {
        flex: 1;
        min-width: 0;
    }

    .ad-file-info strong {
        display: block;
        font-size: .83rem;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ad-file-info span {
        font-size: .73rem;
        color: var(--muted);
    }

    .ad-file-clear {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--muted);
        padding: .25rem;
        border-radius: 4px;
        transition: color .15s;
    }

    .ad-file-clear:hover {
        color: var(--danger);
    }

    /* ── Image preview ── */
    .ad-img-preview {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 16/9;
        background: var(--surface);
        border: 1px solid var(--border);
        display: none;
        margin-top: .75rem;
        position: relative;
    }

    .ad-img-preview.visible {
        display: block;
    }

    .ad-img-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .ad-img-preview-remove {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: rgba(0, 0, 0, .6);
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
    }

    /* ── Toggle switch ── */
    .ad-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .85rem 0;
        border-bottom: 1px solid var(--border);
    }

    .ad-toggle-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .ad-toggle-label {
        font-size: .84rem;
        color: var(--text);
        font-weight: 500;
    }

    .ad-toggle-desc {
        font-size: .73rem;
        color: var(--muted);
        margin-top: .1rem;
    }

    .ad-switch {
        position: relative;
        width: 38px;
        height: 22px;
        flex-shrink: 0;
    }

    .ad-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .ad-switch-track {
        position: absolute;
        inset: 0;
        background: var(--border);
        border-radius: 100px;
        cursor: pointer;
        transition: background .2s;
    }

    .ad-switch-track::before {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #fff;
        top: 3px;
        left: 3px;
        transition: transform .2s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
    }

    .ad-switch input:checked+.ad-switch-track {
        background: var(--accent);
    }

    .ad-switch input:checked+.ad-switch-track::before {
        transform: translateX(16px);
    }

    /* ── Status selector ── */
    .ad-status-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .5rem;
    }

    .ad-status-radio {
        display: none;
    }

    .ad-status-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .35rem;
        padding: .7rem .5rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        cursor: pointer;
        font-size: .74rem;
        font-weight: 500;
        color: var(--text-dim);
        text-align: center;
        transition: all .15s;
    }

    .ad-status-dot-lg {
        width: 9px;
        height: 9px;
        border-radius: 50%;
    }

    .ad-status-radio[value="pending"]:checked+.ad-status-label {
        border-color: #f59e0b;
        background: #fffbeb;
        color: #92400e;
    }

    .ad-status-radio[value="approved"]:checked+.ad-status-label {
        border-color: #22c55e;
        background: #f0fdf4;
        color: #166534;
    }

    .ad-status-radio[value="rejected"]:checked+.ad-status-label {
        border-color: var(--danger);
        background: #fef2f2;
        color: #991b1b;
    }

    /* ── Alerts ── */
    .ad-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: flex-start;
        margin-bottom: 1.25rem;
    }

    .ad-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    .ad-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .ad-alert ul {
        margin: .35rem 0 0 1rem;
        padding: 0;
    }

    .ad-alert li {
        margin-bottom: .2rem;
    }

    /* ── Submit bar ── */
    .ad-submit-bar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: .6rem;
        padding: 1.1rem 1.5rem;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
    }

    .ad-btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .65rem 1.4rem;
        border-radius: 8px;
        font-size: .85rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        font-family: inherit;
    }

    .ad-btn-primary {
        background: var(--accent);
        color: #fff;
    }

    .ad-btn-primary:hover {
        background: var(--accent-lt);
        color: #fff;
        transform: translateY(-1px);
    }

    .ad-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .ad-btn-ghost:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    @media (max-width: 900px) {
        .ad-layout {
            grid-template-columns: 1fr;
        }

        .ad-side {
            position: static;
        }
    }
</style>

<div class="ad-page">

    {{-- ── Heading ── --}}
    <div class="ad-heading">
        <div class="ad-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <polyline points="17 8 12 3 7 8" />
                <line x1="12" x2="12" y1="3" y2="15" />
            </svg>
        </div>
        <div>
            <h4>Upload Architectural Design</h4>
            <p>Add a new design file with metadata, preview image, and pricing.</p>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
    <div class="ad-alert ad-alert-danger">
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
    <div class="ad-alert ad-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST"
        action="{{ route('admin.architectural-designs.store') }}"
        enctype="multipart/form-data">
        @csrf

        <div class="ad-layout">

            {{-- ══ MAIN ══ --}}
            <div class="ad-main">

                {{-- ── Design Info ── --}}
                <div class="ad-card">
                    <div class="ad-card-header">
                        <div class="ad-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                            </svg>
                        </div>
                        <h6>Design Information</h6>
                    </div>
                    <div class="ad-card-body">
                        <div class="row g-4">

                            {{-- Title --}}
                            <div class="col-12">
                                <label class="ad-label">Title <span class="req">*</span></label>
                                <input type="text" name="title"
                                    class="ad-input @error('title') is-invalid @enderror"
                                    placeholder="e.g. Modern 3-Bedroom Villa Blueprint"
                                    value="{{ old('title') }}" required>
                                <p class="ad-hint">A clear slug will be auto-generated from this title.</p>
                                @error('title')<p class="ad-error">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="M12 8v4m0 4h.01" />
                                    </svg>
                                    {{ $message }}
                                </p>@enderror
                            </div>

                            {{-- Category + Service --}}
                            <div class="col-md-6">
                                <label class="ad-label">Category <span class="req">*</span></label>
                                <select name="category_id"
                                    class="ad-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')<p class="ad-error">{{ $message }}</p>@enderror
                            </div>

                            {{-- Assign User (optional) --}}
                            <div class="col-md-6">
                                <label class="ad-label">Assign to User</label>
                                <select name="user_id"
                                    class="ad-select @error('user_id') is-invalid @enderror">
                                    <option value="">— Upload as admin —</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                                <p class="ad-hint">Leave blank to attribute the design to your admin account.</p>
                                @error('user_id')<p class="ad-error">{{ $message }}</p>@enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="ad-label">Description</label>
                                <textarea name="description" rows="4"
                                    class="ad-textarea @error('description') is-invalid @enderror"
                                    placeholder="Describe the design — floor plan, dimensions, style, included deliverables…">{{ old('description') }}</textarea>
                                @error('description')<p class="ad-error">{{ $message }}</p>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Design File ── --}}
                <div class="ad-card">
                    <div class="ad-card-header">
                        <div class="ad-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" x2="12" y1="3" y2="15" />
                            </svg>
                        </div>
                        <h6>Design File <span style="color:var(--danger);margin-left:.2rem">*</span></h6>
                    </div>
                    <div class="ad-card-body">

                        <div class="ad-upload-zone" id="designDropzone">
                            <input type="file" name="design_file" id="designFileInput"
                                accept=".pdf,.zip,.dwg" required>
                            <div class="ad-upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                    <polyline points="14 2 14 8 20 8" />
                                    <line x1="12" x2="12" y1="11" y2="17" />
                                    <line x1="9" x2="15" y1="14" y2="14" />
                                </svg>
                            </div>
                            <h6>Drop your design file here</h6>
                            <p>or <span class="ad-upload-browse">browse files</span> — PDF, ZIP, DWG — max 20 MB</p>
                        </div>

                        <div class="ad-file-selected" id="designFilePreview">
                            <div class="ad-file-type-icon" id="designFileIcon">PDF</div>
                            <div class="ad-file-info">
                                <strong id="designFileName">—</strong>
                                <span id="designFileSize">—</span>
                            </div>
                            <button type="button" class="ad-file-clear" onclick="clearFile('design')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M18 6 6 18M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        @error('design_file')<p class="ad-error" style="margin-top:.6rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Preview Image ── --}}
                <div class="ad-card">
                    <div class="ad-card-header">
                        <div class="ad-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="18" x="3" y="3" rx="2" />
                                <circle cx="9" cy="9" r="2" />
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                            </svg>
                        </div>
                        <h6>Preview Image</h6>
                    </div>
                    <div class="ad-card-body">

                        <div class="ad-upload-zone" id="previewDropzone">
                            <input type="file" name="preview_image" id="previewImageInput"
                                accept="image/*">
                            <div class="ad-upload-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect width="18" height="18" x="3" y="3" rx="2" />
                                    <circle cx="9" cy="9" r="2" />
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                </svg>
                            </div>
                            <h6>Drop a preview image</h6>
                            <p>or <span class="ad-upload-browse">browse</span> — JPG, PNG, WEBP — max 4 MB</p>
                        </div>

                        <div class="ad-img-preview" id="previewImgBox">
                            <img id="previewImgTag" src="" alt="Preview">
                            <button type="button" class="ad-img-preview-remove" onclick="clearFile('preview')">✕</button>
                        </div>

                        @error('preview_image')<p class="ad-error" style="margin-top:.6rem">{{ $message }}</p>@enderror
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
                {{-- ── Submit bar ── --}}
                <div class="ad-submit-bar">
                    <a href="{{ route('admin.architectural-designs.index') }}" class="ad-btn ad-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="ad-btn ad-btn-primary">
                        Upload &amp; Continue
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

            </div>{{-- /.ad-main --}}

            {{-- ══ SIDEBAR ══ --}}
            <div class="ad-side">

                {{-- ── Pricing ── --}}
                <div class="ad-card">
                    <div class="ad-card-header">
                        <div class="ad-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v2m0 8v2m-3-7h6m-6 0a3 3 0 0 0 6 0" />
                            </svg>
                        </div>
                        <h6>Pricing</h6>
                    </div>
                    <div class="ad-card-body">
                        <label class="ad-label">Price</label>
                        <div class="ad-input-group" style="margin-bottom:.75rem">
                            <span class="ad-input-addon prefix">$</span>
                            <input type="number" name="price" id="priceInput"
                                class="ad-input pfx @error('price') is-invalid @enderror"
                                placeholder="0.00" min="0" step="0.01"
                                value="{{ old('price', 0) }}"
                                oninput="updateFreeToggle()">
                        </div>
                        <p class="ad-hint" id="priceHint">Set to <strong>0</strong> to make this design free.</p>
                        @error('price')<p class="ad-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Status ── --}}
                <div class="ad-card">
                    <div class="ad-card-header">
                        <div class="ad-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 8v4m0 4h.01" />
                            </svg>
                        </div>
                        <h6>Status</h6>
                    </div>
                    <div class="ad-card-body">
                        <div class="ad-status-grid">
                            @foreach(['pending' => ['label' => 'Pending', 'color' => '#f59e0b'], 'approved' => ['label' => 'Approved', 'color' => '#22c55e'], 'rejected' => ['label' => 'Rejected', 'color' => '#ef4444']] as $val => $meta)
                            <input type="radio" name="status" id="status_{{ $val }}"
                                value="{{ $val }}" class="ad-status-radio"
                                {{ old('status', 'pending') === $val ? 'checked' : '' }} required>
                            <label for="status_{{ $val }}" class="ad-status-label">
                                <span class="ad-status-dot-lg" style="background:{{ $meta['color'] }}"></span>
                                {{ $meta['label'] }}
                            </label>
                            @endforeach
                        </div>
                        @error('status')<p class="ad-error" style="margin-top:.6rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Options ── --}}
                <div class="ad-card">
                    <div class="ad-card-header">
                        <div class="ad-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </div>
                        <h6>Options</h6>
                    </div>
                    <div class="ad-card-body">

                        {{-- Featured toggle --}}
                        <div class="ad-toggle-row">
                            <div>
                                <div class="ad-toggle-label">Featured</div>
                                <div class="ad-toggle-desc">Show on homepage spotlight</div>
                            </div>
                            <label class="ad-switch">
                                <input type="checkbox" name="featured" value="1"
                                    {{ old('featured') ? 'checked' : '' }}>
                                <span class="ad-switch-track"></span>
                            </label>
                        </div>

                    </div>
                </div>

            </div>{{-- /.ad-side --}}

        </div>{{-- /.ad-layout --}}
    </form>
</div>

<script>
    /* ── Design file input ── */
    const designInput = document.getElementById('designFileInput');
    const designPreview = document.getElementById('designFilePreview');
    const designName = document.getElementById('designFileName');
    const designSize = document.getElementById('designFileSize');
    const designIcon = document.getElementById('designFileIcon');
    const designZone = document.getElementById('designDropzone');

    designInput.addEventListener('change', () => showDesignFile(designInput.files[0]));

    designZone.addEventListener('dragover', e => {
        e.preventDefault();
        designZone.classList.add('dragover');
    });
    designZone.addEventListener('dragleave', () => designZone.classList.remove('dragover'));
    designZone.addEventListener('drop', e => {
        e.preventDefault();
        designZone.classList.remove('dragover');
        if (e.dataTransfer.files[0]) {
            const dt = new DataTransfer();
            dt.items.add(e.dataTransfer.files[0]);
            designInput.files = dt.files;
            showDesignFile(e.dataTransfer.files[0]);
        }
    });

    function showDesignFile(file) {
        if (!file) return;
        const ext = file.name.split('.').pop().toLowerCase();
        designName.textContent = file.name;
        designSize.textContent = formatBytes(file.size);
        designIcon.textContent = ext.toUpperCase();
        designIcon.className = 'ad-file-type-icon ' + (ext === 'pdf' ? 'pdf' : ext === 'zip' ? 'zip' : 'dwg');
        designPreview.classList.add('visible');
    }

    /* ── Preview image ── */
    const previewInput = document.getElementById('previewImageInput');
    const previewBox = document.getElementById('previewImgBox');
    const previewTag = document.getElementById('previewImgTag');
    const previewZone = document.getElementById('previewDropzone');

    previewInput.addEventListener('change', () => {
        if (previewInput.files[0]) showPreviewImg(previewInput.files[0]);
    });

    previewZone.addEventListener('dragover', e => {
        e.preventDefault();
        previewZone.classList.add('dragover');
    });
    previewZone.addEventListener('dragleave', () => previewZone.classList.remove('dragover'));
    previewZone.addEventListener('drop', e => {
        e.preventDefault();
        previewZone.classList.remove('dragover');
        if (e.dataTransfer.files[0]) {
            const dt = new DataTransfer();
            dt.items.add(e.dataTransfer.files[0]);
            previewInput.files = dt.files;
            showPreviewImg(e.dataTransfer.files[0]);
        }
    });

    function showPreviewImg(file) {
        const reader = new FileReader();
        reader.onload = e => {
            previewTag.src = e.target.result;
            previewBox.classList.add('visible');
        };
        reader.readAsDataURL(file);
    }

    /* ── Clear files ── */
    function clearFile(type) {
        if (type === 'design') {
            designInput.value = '';
            designPreview.classList.remove('visible');
        } else {
            previewInput.value = '';
            previewBox.classList.remove('visible');
            previewTag.src = '';
        }
    }

    /* ── Price → free hint ── */
    function updateFreeToggle() {
        const v = parseFloat(document.getElementById('priceInput').value) || 0;
        const hint = document.getElementById('priceHint');
        hint.innerHTML = v === 0 ?
            'This design will be listed as <strong>Free</strong>.' :
            `This design will be listed at <strong>$${v.toFixed(2)}</strong>.`;
    }
    updateFreeToggle();

    /* ── Helpers ── */
    function formatBytes(b) {
        if (b < 1024) return b + ' B';
        if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
        return (b / 1048576).toFixed(1) + ' MB';
    }
</script>

@endsection