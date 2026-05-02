@extends('layouts.app')
@section('title', 'Edit Land Property — ' . $land->title)
@section('content')

<style>
    :root {
        --accent: #c9a96e;
        --accent-lt: #e4c990;
        --danger: #dc3545;
        --success: #198754;
        --warning: #f59e0b;
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

    .lp-heading-badge {
        margin-left: auto;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .35rem .85rem;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 600;
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
        flex-shrink: 0;
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

    .lp-step.active { color: var(--accent); }
    .lp-step.done   { color: var(--success); }

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

    .lp-step.done .lp-step-num {
        background: var(--success);
        border-color: var(--success);
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

    .lp-card-body { padding: 1.5rem; }

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

    .lp-label .req { color: var(--danger); margin-left: .2rem; }

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
    .lp-textarea.is-invalid { border-color: var(--danger); }

    .lp-textarea { resize: vertical; line-height: 1.6; }

    .lp-hint { font-size: .73rem; color: var(--muted); margin-top: .35rem; }

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

    .lp-input-group .lp-input { border-radius: 0 8px 8px 0; flex: 1; }

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

    .lp-dropzone h6 { font-size: .88rem; font-weight: 600; color: var(--text); margin: 0 0 .25rem; }
    .lp-dropzone p  { font-size: .78rem; color: var(--muted); margin: 0; }
    .lp-dropzone .lp-browse { color: var(--accent); font-weight: 500; }

    /* ── Existing + new image previews ── */
    .lp-existing-images {
        margin-bottom: 1rem;
    }

    .lp-existing-label {
        font-size: .73rem;
        font-weight: 600;
        color: var(--text-dim);
        text-transform: uppercase;
        letter-spacing: .03em;
        margin-bottom: .6rem;
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .lp-existing-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .lp-previews {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: .6rem;
        margin-top: .5rem;
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
        background: rgba(0,0,0,.6);
        border: none;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 10px;
        line-height: 1;
        transition: background .15s;
    }

    .lp-preview-remove:hover { background: var(--danger); }

    .lp-preview-item.marked-delete img { opacity: .35; filter: grayscale(1); }

    .lp-preview-item.marked-delete::after {
        content: 'Will be deleted';
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .6rem;
        font-weight: 700;
        color: var(--danger);
        text-align: center;
        padding: .25rem;
        pointer-events: none;
    }

    .lp-preview-undo {
        position: absolute;
        bottom: 4px;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 4px;
        font-size: .6rem;
        font-weight: 600;
        color: var(--text-dim);
        padding: 1px 5px;
        cursor: pointer;
        white-space: nowrap;
        display: none;
    }

    .lp-preview-item.marked-delete .lp-preview-undo { display: block; }

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

    .lp-file-btn:hover { border-color: var(--accent); }

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

    .lp-file-btn-text { font-size: .82rem; color: var(--text-dim); }
    .lp-file-btn-text strong { display: block; color: var(--text); font-size: .85rem; margin-bottom: .1rem; }

    /* Existing doc row */
    .lp-existing-doc {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .65rem 1rem;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        margin-bottom: .6rem;
        font-size: .82rem;
        color: #166534;
    }

    .lp-existing-doc a { color: inherit; font-weight: 600; }
    .lp-existing-doc a:hover { color: var(--accent); }

    .lp-replace-toggle {
        margin-left: auto;
        font-size: .73rem;
        font-weight: 600;
        color: var(--accent);
        cursor: pointer;
        text-decoration: underline;
        background: none;
        border: none;
        padding: 0;
        font-family: inherit;
    }

    /* ── Zoning badge grid ── */
    .lp-zone-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: .5rem;
    }

    .lp-zone-item { display: none; }

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

    .lp-zone-item:checked + .lp-zone-label {
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

    .lp-zone-item:checked + .lp-zone-label .lp-zone-dot {
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

    .lp-submit-bar-info {
        margin-right: auto;
        font-size: .78rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: .4rem;
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

    .lp-btn-primary { background: var(--accent); color: #fff; }
    .lp-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }

    .lp-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .lp-btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

    .lp-btn-danger {
        background: none;
        border: 1.5px solid #fecaca;
        color: var(--danger);
    }

    .lp-btn-danger:hover { background: #fef2f2; border-color: var(--danger); }

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

    .lp-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .lp-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .lp-alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }

    .lp-alert ul { margin: .35rem 0 0 1rem; padding: 0; }
    .lp-alert li { margin-bottom: .2rem; }

    /* ── Status pill ── */
    .lp-status-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .3rem .75rem;
        border-radius: 20px;
        font-size: .73rem;
        font-weight: 600;
    }

    .lp-status-pill.pending  { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .lp-status-pill.approved { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .lp-status-pill.rejected { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .lp-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
</style>

<div class="lp-page">

    {{-- ── Page heading ── --}}
    <div class="lp-heading">
        <div class="lp-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
        </div>
        <div>
            <h4>Edit Land Property</h4>
            <p>Editing: <strong>{{ $land->title }}</strong> &mdash; Last updated {{ $land->updated_at->diffForHumans() }}</p>
        </div>
        <div class="lp-heading-badge" style="margin-left:auto">
            <span class="lp-status-dot"></span>
            @php
                $statusMap = ['pending'=>'Pending Review','approved'=>'Approved','rejected'=>'Rejected'];
            @endphp
            {{ $statusMap[$land->status] ?? ucfirst($land->status) }}
        </div>
    </div>

    {{-- ── Steps ── --}}
    <div class="lp-steps">
        <div class="lp-step done">
            <span class="lp-step-num">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
            </span> Property Info
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step done">
            <span class="lp-step-num">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
            </span> Location
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step done">
            <span class="lp-step-num">
                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
            </span> Media
        </div>
        <div class="lp-step-sep"></div>
        <div class="lp-step active">
            <span class="lp-step-num">4</span> Review
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
    <div class="lp-alert lp-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
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
            <path d="M20 6 9 17l-5-5"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if($land->status === 'rejected' && $land->rejection_reason)
    <div class="lp-alert lp-alert-warning">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem">
            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4m0 4h.01"/>
        </svg>
        <div>
            <strong>This listing was rejected.</strong> Reason: {{ $land->rejection_reason }}
            <br><small>Update the details below and resubmit for review.</small>
        </div>
    </div>
    @endif

    <form method="POST"
          action="{{ route('admin.properties.lands.update', $land) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ══ SECTION 1 — Property Details ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                </div>
                <h6>Property Details</h6>
                <span>Step 1 of 4</span>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="lp-label">Property Title <span class="req">*</span></label>
                        <input type="text" name="title"
                            class="lp-input @error('title') is-invalid @enderror"
                            placeholder="e.g. Prime Residential Plot in Kicukiro"
                            value="{{ old('title', $land->title) }}" required>
                        @error('title')<p class="lp-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            {{ $message }}
                        </p>@enderror
                    </div>

                    {{-- UPI --}}
                    <div class="col-md-6">
                        <label class="lp-label">Land UPI</label>
                        <input type="text" name="upi"
                            class="lp-input @error('upi') is-invalid @enderror"
                            placeholder="e.g. 1/01/01/01/1234"
                            value="{{ old('upi', $land->upi) }}">
                        <p class="lp-hint">Unique Parcel Identifier from RLMUA.</p>
                        @error('upi')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Price --}}
                    <div class="col-md-4">
                        <label class="lp-label">Price <span class="req">*</span></label>
                        <div class="lp-input-group">
                            <span class="lp-input-group-text">$</span>
                            <input type="number" name="price"
                                class="lp-input @error('price') is-invalid @enderror"
                                placeholder="0.00" min="0" step="0.01"
                                value="{{ old('price', $land->price) }}" required>
                        </div>
                        @error('price')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Area --}}
                    <div class="col-md-4">
                        <label class="lp-label">Area <span class="req">*</span></label>
                        <div class="lp-input-group">
                            <input type="number" name="size_sqm"
                                class="lp-input @error('size_sqm') is-invalid @enderror"
                                placeholder="0" min="1"
                                value="{{ old('size_sqm', $land->size_sqm) }}" required
                                style="border-radius:8px 0 0 8px;border-right:none;">
                            <span class="lp-input-group-text" style="border-left:none;border-radius:0 8px 8px 0;">sqm</span>
                        </div>
                        @error('size_sqm')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Condition --}}
                    <div class="col-md-4">
                        <label class="lp-label">Condition <span class="req">*</span></label>
                        <select name="condition" class="lp-select @error('condition') is-invalid @enderror" required>
                            <option value="for_rent"  {{ old('condition', $land->condition) === 'for_rent'  ? 'selected' : '' }}>For Rent</option>
                            <option value="for_sale"  {{ old('condition', $land->condition) === 'for_sale'  ? 'selected' : '' }}>For Sale</option>
                        </select>
                        @error('condition')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Land Use --}}
                    <div class="col-md-6">
                        <label class="lp-label">Land Use <span class="req">*</span></label>
                        <select name="land_use" class="lp-select @error('land_use') is-invalid @enderror" required>
                            <option value="">Select land use</option>
                            @foreach([
                                'Residential'         => 'Residential',
                                'Commercial'          => 'Commercial',
                                'Industrial'          => 'Industrial',
                                'Agricultural'        => 'Agricultural',
                                'Mixed-use'           => 'Mixed-use',
                                'Institutional'       => 'Institutional',
                                'Recreational'        => 'Recreational',
                                'Conservation'        => 'Conservation',
                                'Transportation'      => 'Transportation',
                                'Hospitality & Tourism' => 'Hospitality & Tourism',
                            ] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('land_use', $land->land_use) === $val ? 'selected' : '' }}>
                                {{ $lbl }}
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
                                'R1'           => 'R1 Low density',
                                'R2'           => 'R2 Medium density',
                                'R3'           => 'R3 High density',
                                'R4'           => 'R4 High density',
                                'Commercial'   => 'Commercial',
                                'Industrial'   => 'Industrial',
                                'Agricultural' => 'Agricultural',
                            ];
                            @endphp
                            @foreach($zones as $val => $lbl)
                            <input type="radio" name="zoning" id="zone_{{ $val }}"
                                value="{{ $val }}" class="lp-zone-item"
                                {{ old('zoning', $land->zoning) === $val ? 'checked' : '' }}>
                            <label for="zone_{{ $val }}" class="lp-zone-label">
                                <span class="lp-zone-dot"></span>{{ $lbl }}
                            </label>
                            @endforeach
                        </div>
                        @error('zoning')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label class="lp-label">Description</label>
                        <textarea name="description"
                            class="lp-textarea @error('description') is-invalid @enderror"
                            rows="4"
                            placeholder="Describe the land — access roads, utilities, surrounding amenities…">{{ old('description', $land->description) }}</textarea>
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
                        <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                </div>
                <h6>Location Details</h6>
                <span>Step 2 of 4</span>
            </div>
            <div class="lp-card-body">
                {{-- Pass $land to the shared form include so it can pre-fill location fields --}}
                @include('includes.form', ['model' => $land])

                <!-- Location Details Form longitude and latitude Fields -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="lp-label">Latitude</label>
                        <input type="text" name="latitude"
                               class="lp-input @error('latitude') is-invalid @enderror"
                               value="{{ old('latitude', $land->latitude) }}"
                               placeholder="-1.970579">
                        @error('latitude')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="lp-label">Longitude</label>
                        <input type="text" name="longitude"
                               class="lp-input @error('longitude') is-invalid @enderror"
                               value="{{ old('longitude', $land->longitude) }}"
                               placeholder="30.104429">
                        @error('longitude')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ SECTION 3 — Media ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect width="18" height="18" x="3" y="3" rx="2"/>
                        <circle cx="9" cy="9" r="2"/>
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                    </svg>
                </div>
                <h6>Photos &amp; Documents</h6>
                <span>Step 3 of 4</span>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">

                    {{-- ── Images ── --}}
                    <div class="col-12">
                        <label class="lp-label">Property Photos</label>

                        {{-- Existing images --}}
                        @if($land->images && $land->images->count())
                        <div class="lp-existing-images">
                            <div class="lp-existing-label">{{ $land->images->count() }} existing photo{{ $land->images->count() > 1 ? 's' : '' }}</div>
                            <div class="lp-previews" id="existingImageGrid">
                                @foreach($land->images as $img)
                                <div class="lp-preview-item" id="existing-{{ $img->id }}">
                                    <img src="{{asset('image/lands/')}}/{{ $img->image_path }}" alt="Property photo">
                                    {{-- Hidden input: initially NOT checked (= keep) --}}
                                    <input type="checkbox" name="delete_images[]"
                                        value="{{ $img->id }}"
                                        id="del_img_{{ $img->id }}"
                                        style="display:none">
                                    <button type="button" class="lp-preview-remove"
                                        onclick="toggleDeleteImage({{ $img->id }})"
                                        title="Mark for deletion">✕</button>
                                    <button type="button" class="lp-preview-undo"
                                        onclick="toggleDeleteImage({{ $img->id }})">Undo</button>
                                </div>
                                @endforeach
                            </div>
                            <p class="lp-hint" style="margin-top:.6rem">Click ✕ on a photo to mark it for removal. Changes apply on save.</p>
                        </div>
                        @endif

                        {{-- New image upload --}}
                        <div class="lp-dropzone" id="imageDropzone">
                            <input type="file" name="images[]" id="imageInput" accept="image/*" multiple>
                            <div class="lp-dropzone-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" x2="12" y1="3" y2="15"/>
                                </svg>
                            </div>
                            <h6>Add more photos</h6>
                            <p>Drag &amp; drop or <span class="lp-browse">browse files</span> — JPG, PNG, WEBP, up to 5MB each</p>
                        </div>
                        <div class="lp-previews" id="imagePreviews"></div>
                        @error('images.*')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- ── Video URL ── --}}
                    <div class="col-12">
                        <label class="lp-label">Video URL</label>
                        <input type="text" name="video_url" class="form-control" placeholder="Enter video URL" value="{{ old('video_url', $land->video_url) }}">
                        @error('video_url')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- ── Title Deed ── --}}
                    <div class="col-12">
                        <label class="lp-label">Title Deed / Document</label>

                        @if($land->title_doc)
                        <div class="lp-existing-doc" id="existingDocRow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                            <span>Current document:&nbsp;
                                <a href="{{ Storage::url($land->title_doc) }}" target="_blank">
                                    {{ basename($land->title_doc) }}
                                </a>
                            </span>
                            <button type="button" class="lp-replace-toggle" onclick="showDocReplace()">Replace</button>
                        </div>
                        <input type="hidden" name="keep_title_doc" value="1" id="keepTitleDoc">
                        <div id="docReplaceArea" style="display:none">
                        @endif

                            <div class="lp-file-btn" id="titleDocBtn">
                                <input type="file" name="title_doc" id="titleDocInput"
                                    accept=".pdf,.jpg,.jpeg,.png">
                                <div class="lp-file-btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                    </svg>
                                </div>
                                <div class="lp-file-btn-text">
                                    <strong id="titleDocName">
                                        {{ $land->title_doc ? 'Choose replacement file' : 'Click to upload title deed' }}
                                    </strong>
                                    PDF, JPG, PNG — max 4MB
                                </div>
                            </div>

                            @if($land->title_doc)
                            <button type="button" onclick="cancelDocReplace()" style="margin-top:.5rem;font-size:.75rem;color:var(--muted);background:none;border:none;cursor:pointer;padding:0;">
                                ← Keep existing document
                            </button>
                            </div>{{-- #docReplaceArea --}}
                            @endif

                        <p class="lp-hint">Optional. Upload the official land title or ownership document.</p>
                        @error('title_doc')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Listing Package ── --}}
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
                        {{ old('listing_package_id', $land->listing_package_id) == $pkg->id ? 'selected' : '' }}>
                       {{ $pkg->listing_type }} - {{ ucfirst($pkg->package_tier) }}
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
                    value="{{ old('listing_days', $land->listing_days ?? 30) }}"
                    min="1" oninput="recalcFee()" required>
                <div class="form-text">31-59 days: 10% off &nbsp;·&nbsp; 61-89 days: 15% off &nbsp;·&nbsp; 90+ days: 20% off</div>
                @error('listing_days')
                <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- ── Owner Information ── --}}
        <div class="card mb-4">
            <div class="card-header fw-semibold">Property Owner Information</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Owner Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="owner_name"
                            class="form-control @error('owner_name') is-invalid @enderror"
                            value="{{ old('owner_name', $land->owner_name) }}"
                            placeholder="Full legal name" required>
                        @error('owner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">National ID / Passport No.</label>
                        <input type="text" name="owner_id_number"
                            class="form-control @error('owner_id_number') is-invalid @enderror"
                            value="{{ old('owner_id_number', $land->owner_id_number) }}"
                            placeholder="1 XXXX X XXXXXXX X XX">
                        @error('owner_id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Phone <span class="text-danger">*</span></label>
                        <input type="text" name="owner_phone"
                            class="form-control @error('owner_phone') is-invalid @enderror"
                            value="{{ old('owner_phone', $land->owner_phone) }}"
                            placeholder="+250 7XX XXX XXX" required>
                        @error('owner_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Email</label>
                        <input type="email" name="owner_email"
                            class="form-control @error('owner_email') is-invalid @enderror"
                            value="{{ old('owner_email', $land->owner_email) }}"
                            placeholder="owner@email.com">
                        @error('owner_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ Submit bar ══ --}}
        <div class="lp-submit-bar">
            <span class="lp-submit-bar-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
                </svg>
                Changes will be saved and re-submitted for review.
            </span>
            <a href="{{ route('admin.properties.lands.index') }}" class="lp-btn lp-btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Cancel
            </a>
            <a href="{{ route('admin.properties.lands.show', $land) }}" class="lp-btn lp-btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>
                </svg>
                View Listing
            </a>
            <button type="submit" class="lp-btn lp-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
                </svg>
                Save Changes
            </button>
        </div>

    </form>
</div>

<script>
    /* ── New image previews ── */
    const imageInput    = document.getElementById('imageInput');
    const imagePreviews = document.getElementById('imagePreviews');
    const imageDropzone = document.getElementById('imageDropzone');
    let selectedFiles   = [];

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

    /* ── Toggle delete existing images ── */
    function toggleDeleteImage(id) {
        const item     = document.getElementById(`existing-${id}`);
        const checkbox = document.getElementById(`del_img_${id}`);
        const isMarked = item.classList.toggle('marked-delete');
        checkbox.checked = isMarked;
    }

    /* ── Title doc replace toggle ── */
    function showDocReplace() {
        document.getElementById('docReplaceArea').style.display = 'block';
        document.getElementById('existingDocRow').style.opacity = '.4';
        document.getElementById('existingDocRow').style.pointerEvents = 'none';
        document.getElementById('keepTitleDoc').value = '0';
    }

    function cancelDocReplace() {
        document.getElementById('docReplaceArea').style.display = 'none';
        document.getElementById('existingDocRow').style.opacity = '1';
        document.getElementById('existingDocRow').style.pointerEvents = '';
        document.getElementById('keepTitleDoc').value = '1';
        document.getElementById('titleDocInput').value = '';
        document.getElementById('titleDocName').textContent = 'Choose replacement file';
    }

    /* ── New title doc filename ── */
    document.getElementById('titleDocInput').addEventListener('change', function () {
        document.getElementById('titleDocName').textContent =
            this.files[0] ? this.files[0].name : 'Choose replacement file';
    });

    /* ── recalcFee (same as create) ── */
    function recalcFee() {
        const select = document.querySelector('select[name="listing_package_id"]');
        const days   = parseInt(document.querySelector('input[name="listing_days"]')?.value) || 0;
        if (!select?.value || !days) return;
        const opt       = select.options[select.selectedIndex];
        const perDay    = parseFloat(opt.dataset.price) || 0;
        let   discount  = 0;
        if      (days >= 90) discount = .20;
        else if (days >= 61) discount = .15;
        else if (days >= 31) discount = .10;
        const total = perDay * days * (1 - discount);
        // update any fee display element you may have in the UI
        const feeEl = document.getElementById('feeDisplay');
        if (feeEl) feeEl.textContent = 'RWF ' + total.toLocaleString();
    }

    // Run on page load to reflect pre-selected values
    document.addEventListener('DOMContentLoaded', recalcFee);
</script>

@endsection