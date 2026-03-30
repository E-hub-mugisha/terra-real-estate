@extends('layouts.app')
@section('title', 'Edit Land Property — ' . $land->title)
@section('content')

<style>
    :root {
        --accent:   #c9a96e;
        --accent-lt:#e4c990;
        --danger:   #dc3545;
        --success:  #198754;
        --warning:  #f59e0b;
        --border:   #e2e8f0;
        --surface:  #f8fafc;
        --muted:    #94a3b8;
        --text:     #1e293b;
        --text-dim: #64748b;
        --radius:   10px;
    }

    .lp-page { padding: 1.75rem 0 3rem; max-width: 1100px; margin: 0 auto; }

    /* ── Page heading ── */
    .lp-heading { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
    .lp-heading-icon {
        width: 44px; height: 44px; border-radius: 10px;
        background: linear-gradient(135deg,#c9a96e22,#c9a96e44);
        border: 1px solid #c9a96e55;
        display: flex; align-items: center; justify-content: center;
        color: var(--accent); flex-shrink: 0;
    }
    .lp-heading h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .lp-heading p  { font-size: .82rem; color: var(--text-dim); margin: .15rem 0 0; }

    .lp-heading-meta { margin-left: auto; display: flex; align-items: center; gap: .6rem; }
    .lp-status-pill {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .3rem .85rem; border-radius: 100px; font-size: .72rem; font-weight: 600;
    }
    .lp-status-pill.available { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
    .lp-status-pill.reserved  { background:#fffbeb; color:#92400e; border:1px solid #fde68a; }
    .lp-status-pill.sold      { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .lp-status-dot { width:7px; height:7px; border-radius:50%; background:currentColor; }

    /* ── Section card ── */
    .lp-card { background:#fff; border:1px solid var(--border); border-radius:var(--radius); margin-bottom:1.25rem; overflow:hidden; }
    .lp-card-header {
        display:flex; align-items:center; gap:.75rem;
        padding:1rem 1.5rem; border-bottom:1px solid var(--border); background:var(--surface);
    }
    .lp-card-header-icon {
        width:32px; height:32px; border-radius:8px; background:#c9a96e18;
        display:flex; align-items:center; justify-content:center; color:var(--accent); flex-shrink:0;
    }
    .lp-card-header h6 { margin:0; font-size:.88rem; font-weight:600; color:var(--text); }
    .lp-card-header span { margin-left:auto; font-size:.73rem; color:var(--muted); }
    .lp-card-body { padding:1.5rem; }

    /* ── Form controls ── */
    .lp-label { display:block; font-size:.77rem; font-weight:600; letter-spacing:.03em; color:var(--text-dim); text-transform:uppercase; margin-bottom:.45rem; }
    .lp-label .req { color:var(--danger); margin-left:.2rem; }
    .lp-input, .lp-select, .lp-textarea {
        width:100%; padding:.65rem .9rem; border:1.5px solid var(--border); border-radius:8px;
        font-size:.875rem; color:var(--text); background:#fff;
        transition:border-color .2s,box-shadow .2s; outline:none; font-family:inherit;
    }
    .lp-input:focus,.lp-select:focus,.lp-textarea:focus { border-color:var(--accent); box-shadow:0 0 0 3px #c9a96e18; }
    .lp-input.is-invalid,.lp-select.is-invalid,.lp-textarea.is-invalid { border-color:var(--danger); }
    .lp-textarea { resize:vertical; line-height:1.6; }
    .lp-hint  { font-size:.73rem; color:var(--muted); margin-top:.35rem; }
    .lp-error { font-size:.73rem; color:var(--danger); margin-top:.35rem; display:flex; align-items:center; gap:.3rem; }

    /* ── Input group ── */
    .lp-input-group { display:flex; align-items:stretch; }
    .lp-input-group-text {
        padding:.65rem .85rem; background:var(--surface); border:1.5px solid var(--border);
        font-size:.82rem; font-weight:600; color:var(--muted); display:flex; align-items:center;
    }
    .lp-input-group-text.prefix { border-right:none; border-radius:8px 0 0 8px; }
    .lp-input-group-text.suffix { border-left:none;  border-radius:0 8px 8px 0; }
    .lp-input-group .lp-input.with-prefix { border-radius:0 8px 8px 0; }
    .lp-input-group .lp-input.with-suffix { border-radius:8px 0 0 8px; border-right:none; }

    /* ── Zoning radio grid ── */
    .lp-zone-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(140px,1fr)); gap:.5rem; }
    .lp-zone-item { display:none; }
    .lp-zone-label {
        display:flex; align-items:center; gap:.5rem; padding:.6rem .85rem;
        border:1.5px solid var(--border); border-radius:8px; font-size:.8rem; color:var(--text-dim);
        cursor:pointer; transition:all .15s; user-select:none;
    }
    .lp-zone-item:checked + .lp-zone-label { border-color:var(--accent); background:#c9a96e10; color:var(--accent); font-weight:500; }
    .lp-zone-dot { width:8px; height:8px; border-radius:50%; border:2px solid currentColor; flex-shrink:0; }
    .lp-zone-item:checked + .lp-zone-label .lp-zone-dot { background:var(--accent); border-color:var(--accent); }

    /* ── Existing images grid ── */
    .lp-img-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(110px,1fr)); gap:.75rem; margin-bottom:1.25rem; }
    .lp-img-item {
        position:relative; border-radius:10px; overflow:hidden;
        aspect-ratio:1; background:var(--border);
        border:2px solid transparent; transition:border-color .2s;
    }
    .lp-img-item img { width:100%; height:100%; object-fit:cover; display:block; }
    .lp-img-item.marked-delete { opacity:.35; }
    .lp-img-item.marked-delete .lp-img-overlay { background:rgba(220,53,69,.75); }
    .lp-img-overlay {
        position:absolute; inset:0; display:flex; flex-direction:column;
        align-items:center; justify-content:center; gap:.25rem;
        background:rgba(0,0,0,0); transition:background .2s;
    }
    .lp-img-item:hover .lp-img-overlay { background:rgba(0,0,0,.45); }
    .lp-img-del-btn {
        width:30px; height:30px; border-radius:50%; background:rgba(220,53,69,.9);
        border:none; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;
        opacity:0; transition:opacity .2s; font-size:12px;
    }
    .lp-img-item:hover .lp-img-del-btn { opacity:1; }
    .lp-img-item.marked-delete .lp-img-del-btn { opacity:1; background:rgba(100,116,139,.9); }
    .lp-img-badge {
        position:absolute; top:5px; left:5px;
        background:var(--accent); color:#fff; font-size:.6rem; font-weight:700;
        padding:.18rem .5rem; border-radius:100px; letter-spacing:.04em;
    }
    .lp-img-deleted-label {
        position:absolute; bottom:5px; left:50%; transform:translateX(-50%);
        background:var(--danger); color:#fff; font-size:.6rem; font-weight:700;
        padding:.18rem .55rem; border-radius:100px; white-space:nowrap; opacity:0;
    }
    .lp-img-item.marked-delete .lp-img-deleted-label { opacity:1; }

    /* ── Dropzone ── */
    .lp-dropzone {
        border:2px dashed var(--border); border-radius:10px; padding:1.75rem 1.5rem;
        text-align:center; cursor:pointer; transition:border-color .2s,background .2s;
        background:var(--surface); position:relative;
    }
    .lp-dropzone:hover,.lp-dropzone.dragover { border-color:var(--accent); background:#c9a96e08; }
    .lp-dropzone input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
    .lp-dropzone-icon { width:40px; height:40px; border-radius:10px; background:#c9a96e18; display:flex; align-items:center; justify-content:center; margin:0 auto .65rem; color:var(--accent); }
    .lp-dropzone h6 { font-size:.85rem; font-weight:600; color:var(--text); margin:0 0 .2rem; }
    .lp-dropzone p  { font-size:.76rem; color:var(--muted); margin:0; }
    .lp-browse      { color:var(--accent); font-weight:500; }

    /* New image previews */
    .lp-previews { display:grid; grid-template-columns:repeat(auto-fill,minmax(90px,1fr)); gap:.6rem; margin-top:1rem; }
    .lp-preview-item { position:relative; border-radius:8px; overflow:hidden; aspect-ratio:1; background:var(--border); }
    .lp-preview-item img { width:100%; height:100%; object-fit:cover; display:block; }
    .lp-preview-remove {
        position:absolute; top:4px; right:4px; width:20px; height:20px; border-radius:50%;
        background:rgba(0,0,0,.6); border:none; color:#fff; display:flex; align-items:center;
        justify-content:center; cursor:pointer; font-size:10px; line-height:1;
    }
    .lp-new-badge {
        position:absolute; bottom:4px; left:4px; background:#3b82f6; color:#fff;
        font-size:.58rem; font-weight:700; padding:.15rem .45rem; border-radius:100px;
    }

    /* ── Doc upload ── */
    .lp-file-btn {
        display:flex; align-items:center; gap:.75rem; padding:.75rem 1rem;
        border:1.5px dashed var(--border); border-radius:8px; background:var(--surface);
        cursor:pointer; transition:border-color .2s; position:relative;
    }
    .lp-file-btn:hover { border-color:var(--accent); }
    .lp-file-btn input { position:absolute; inset:0; opacity:0; cursor:pointer; }
    .lp-file-btn-icon { width:36px; height:36px; border-radius:8px; background:#c9a96e18; display:flex; align-items:center; justify-content:center; color:var(--accent); flex-shrink:0; }
    .lp-file-btn-text { font-size:.82rem; color:var(--text-dim); }
    .lp-file-btn-text strong { display:block; color:var(--text); font-size:.85rem; margin-bottom:.1rem; }

    /* ── Existing doc preview ── */
    .lp-doc-preview {
        display:flex; align-items:center; gap:.75rem; padding:.75rem 1rem;
        border:1px solid var(--border); border-radius:8px; background:#fff; margin-bottom:.75rem;
    }
    .lp-doc-icon { width:36px; height:36px; border-radius:8px; background:#fee2e2; display:flex; align-items:center; justify-content:center; color:var(--danger); flex-shrink:0; }
    .lp-doc-info { flex:1; min-width:0; }
    .lp-doc-info strong { display:block; font-size:.83rem; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .lp-doc-info span   { font-size:.73rem; color:var(--muted); }
    .lp-doc-actions { display:flex; gap:.4rem; }
    .lp-doc-btn {
        display:inline-flex; align-items:center; gap:.3rem; padding:.3rem .7rem;
        border-radius:6px; font-size:.73rem; font-weight:500; border:1px solid;
        cursor:pointer; text-decoration:none; transition:all .15s; font-family:inherit; background:none;
    }
    .lp-doc-btn.view   { color:#3b82f6; border-color:#bfdbfe; }
    .lp-doc-btn.view:hover { background:#eff6ff; }
    .lp-doc-btn.remove { color:var(--danger); border-color:#fecaca; }
    .lp-doc-btn.remove:hover { background:#fef2f2; }

    /* ── Alerts ── */
    .lp-alert { border-radius:8px; padding:.85rem 1.1rem; font-size:.84rem; display:flex; gap:.6rem; align-items:flex-start; margin-bottom:1.25rem; }
    .lp-alert-danger  { background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; }
    .lp-alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
    .lp-alert-warning { background:#fffbeb; border:1px solid #fde68a; color:#92400e; }
    .lp-alert ul { margin:.35rem 0 0 1rem; padding:0; }
    .lp-alert li { margin-bottom:.2rem; }

    /* ── Submit bar ── */
    .lp-submit-bar {
        display:flex; align-items:center; justify-content:space-between; gap:.75rem;
        padding:1.25rem 1.5rem; background:#fff;
        border:1px solid var(--border); border-radius:var(--radius); margin-top:1.25rem;
    }
    .lp-submit-bar-left { display:flex; align-items:center; gap:.5rem; font-size:.78rem; color:var(--muted); }
    .lp-submit-bar-right { display:flex; gap:.6rem; }
    .lp-btn {
        display:inline-flex; align-items:center; gap:.45rem; padding:.65rem 1.5rem;
        border-radius:8px; font-size:.85rem; font-weight:600; border:none; cursor:pointer;
        transition:all .2s; text-decoration:none; font-family:inherit;
    }
    .lp-btn-primary { background:var(--accent); color:#fff; }
    .lp-btn-primary:hover { background:var(--accent-lt); color:#fff; transform:translateY(-1px); }
    .lp-btn-ghost   { background:none; border:1.5px solid var(--border); color:var(--text-dim); }
    .lp-btn-ghost:hover { border-color:var(--accent); color:var(--accent); }
    .lp-btn-danger  { background:none; border:1.5px solid #fecaca; color:var(--danger); }
    .lp-btn-danger:hover { background:#fef2f2; }
</style>

<div class="lp-page">

    {{-- ── Page heading ── --}}
    <div class="lp-heading">
        <div class="lp-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div>
            <h4>Edit Land Property</h4>
            <p>{{ Str::limit($land->title, 60) }} &mdash; last updated {{ $land->updated_at->diffForHumans() }}</p>
        </div>
        <div class="lp-heading-meta">
            <span class="lp-status-pill {{ $land->status }}">
                <span class="lp-status-dot"></span>
                {{ ucfirst($land->status) }}
            </span>
            <a href="{{ route('admin.properties.lands.show', $land->id) }}" class="lp-btn lp-btn-ghost" style="padding:.4rem .9rem;font-size:.78rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Preview
            </a>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
        <div class="lp-alert lp-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="lp-alert lp-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="lp-alert lp-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.properties.lands.update', $land->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- ══ SECTION 1 — Property Details ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h6>Property Details</h6>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">

                    {{-- Title --}}
                    <div class="col-12">
                        <label class="lp-label">Property Title <span class="req">*</span></label>
                        <input type="text" name="title"
                               class="lp-input @error('title') is-invalid @enderror"
                               value="{{ old('title', $land->title) }}"
                               placeholder="e.g. Prime Residential Plot in Kicukiro" required>
                        @error('title')<p class="lp-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            {{ $message }}</p>@enderror
                    </div>

                    {{-- UPI + Service --}}
                    <div class="col-md-6">
                        <label class="lp-label">Land UPI</label>
                        <input type="text" name="upi"
                               class="lp-input @error('upi') is-invalid @enderror"
                               value="{{ old('upi', $land->upi) }}"
                               placeholder="e.g. 1/01/01/01/1234">
                        <p class="lp-hint">Unique Parcel Identifier from RLMUA.</p>
                        @error('upi')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Price + Area + Status --}}
                    <div class="col-md-4">
                        <label class="lp-label">Price <span class="req">*</span></label>
                        <div class="lp-input-group">
                            <span class="lp-input-group-text prefix">$</span>
                            <input type="number" name="price"
                                   class="lp-input with-prefix @error('price') is-invalid @enderror"
                                   value="{{ old('price', $land->price) }}"
                                   placeholder="0.00" min="0" step="0.01" required>
                        </div>
                        @error('price')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="lp-label">Area <span class="req">*</span></label>
                        <div class="lp-input-group">
                            <input type="number" name="size_sqm"
                                   class="lp-input with-suffix @error('size_sqm') is-invalid @enderror"
                                   value="{{ old('size_sqm', $land->size_sqm) }}"
                                   placeholder="0" min="1" required>
                            <span class="lp-input-group-text suffix">sqm</span>
                        </div>
                        @error('size_sqm')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="lp-label">Status <span class="req">*</span></label>
                        <select name="status"
                                class="lp-select @error('status') is-invalid @enderror" required>
                            <option value="available" {{ old('status', $land->status) === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="reserved"  {{ old('status', $land->status) === 'reserved'  ? 'selected' : '' }}>Reserved</option>
                            <option value="sold"      {{ old('status', $land->status) === 'sold'      ? 'selected' : '' }}>Sold</option>
                        </select>
                        @error('status')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Land Use + Zoning --}}
                    <div class="col-md-6">
                        <label class="lp-label">Land Use <span class="req">*</span></label>
                        <select name="land_use"
                                class="lp-select @error('land_use') is-invalid @enderror" required>
                            <option value="">Select land use</option>
                            @foreach([
                                'Residential'           => 'Residential',
                                'Commercial'            => 'Commercial',
                                'Industrial'            => 'Industrial',
                                'Agricultural'          => 'Agricultural',
                                'Mixed-use'             => 'Mixed-use',
                                'Institutional'         => 'Institutional',
                                'Recreational'          => 'Recreational',
                                'Conservation'          => 'Conservation',
                                'Transportation'        => 'Transportation',
                                'Hospitality & Tourism' => 'Hospitality & Tourism',
                            ] as $val => $label)
                                <option value="{{ $val }}"
                                    {{ old('land_use', $land->land_use) === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('land_use')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="lp-label">Zoning Type <span class="req">*</span></label>
                        <div class="lp-zone-grid">
                            @php
                                $zones = [
                                    'R1'           => 'R1 Low density',
                                    'R2'           => 'R2 Medium density',
                                    'R3'           => 'R3 High density',
                                    'Commercial'   => 'Commercial',
                                    'Industrial'   => 'Industrial',
                                    'Agricultural' => 'Agricultural',
                                ];
                            @endphp
                            @foreach($zones as $val => $label)
                                <input type="radio" name="zoning" id="zone_{{ $val }}"
                                       value="{{ $val }}" class="lp-zone-item"
                                       {{ old('zoning', $land->zoning) === $val ? 'checked' : '' }}>
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
                        <textarea name="description" rows="4"
                                  class="lp-textarea @error('description') is-invalid @enderror"
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <h6>Location Details</h6>
            </div>
            <div class="lp-card-body">
                @include('includes.form')
            </div>
        </div>

        {{-- ══ SECTION 3 — Media ══ --}}
        <div class="lp-card">
            <div class="lp-card-header">
                <div class="lp-card-header-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                </div>
                <h6>Photos &amp; Documents</h6>
            </div>
            <div class="lp-card-body">
                <div class="row g-4">

                    {{-- Existing images --}}
                    <div class="col-12">
                        <label class="lp-label">Current Photos</label>

                        @if($land->images && $land->images->count())
                            <div class="lp-img-grid" id="existingGrid">
                                @foreach($land->images as $index => $image)
                                    <div class="lp-img-item" id="img-item-{{ $image->id }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="Property photo {{ $index + 1 }}">
                                        @if($index === 0)
                                            <span class="lp-img-badge">Cover</span>
                                        @endif
                                        <span class="lp-img-deleted-label">Removed</span>
                                        <div class="lp-img-overlay">
                                            <button type="button" class="lp-img-del-btn"
                                                    onclick="toggleDeleteImage({{ $image->id }}, this)"
                                                    title="Mark for removal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                        {{-- Hidden input toggled by JS --}}
                                        <input type="checkbox" name="delete_images[]"
                                               value="{{ $image->id }}"
                                               id="del-{{ $image->id }}"
                                               style="display:none">
                                    </div>
                                @endforeach
                            </div>
                            <p class="lp-hint">Click the × on a photo to mark it for removal. Changes apply on save.</p>
                        @else
                            <div style="padding:1.25rem;border:1px dashed var(--border);border-radius:8px;text-align:center;color:var(--muted);font-size:.83rem;margin-bottom:1rem;">
                                No photos uploaded yet.
                            </div>
                        @endif
                    </div>

                    {{-- Add new images --}}
                    <div class="col-12">
                        <label class="lp-label">Add More Photos</label>
                        <div class="lp-dropzone" id="imageDropzone">
                            <input type="file" name="images[]" id="imageInput" accept="image/*" multiple>
                            <div class="lp-dropzone-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            </div>
                            <h6>Drag &amp; drop new photos here</h6>
                            <p>or <span class="lp-browse">browse files</span> — JPG, PNG, WEBP, up to 5MB each</p>
                        </div>
                        <div class="lp-previews" id="imagePreviews"></div>
                        @error('images.*')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                    {{-- Title deed --}}
                    <div class="col-12">
                        <label class="lp-label">Title Deed / Document</label>

                        @if($land->title_doc_path)
                            <div class="lp-doc-preview">
                                <div class="lp-doc-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <div class="lp-doc-info">
                                    <strong>{{ basename($land->title_doc_path) }}</strong>
                                    <span>Current title document</span>
                                </div>
                                <div class="lp-doc-actions">
                                    <a href="{{ asset('storage/' . $land->title_doc_path) }}"
                                       target="_blank" class="lp-doc-btn view">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        View
                                    </a>
                                    <button type="button" class="lp-doc-btn remove"
                                            onclick="toggleDeleteDoc(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="delete_title_doc" id="deleteTitleDoc" value="0">
                        @endif

                        <div class="lp-file-btn" id="titleDocBtn">
                            <input type="file" name="title_doc" id="titleDocInput"
                                   accept=".pdf,.jpg,.jpeg,.png">
                            <div class="lp-file-btn-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div class="lp-file-btn-text">
                                <strong id="titleDocName">
                                    {{ $land->title_doc_path ? 'Replace title deed' : 'Click to upload title deed' }}
                                </strong>
                                PDF, JPG, PNG — max 4MB
                            </div>
                        </div>
                        @error('title_doc')<p class="lp-error">{{ $message }}</p>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ══ Submit bar ══ --}}
        <div class="lp-submit-bar">
            <div class="lp-submit-bar-left">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Last saved {{ $land->updated_at->format('M j, Y \a\t g:i A') }}
            </div>
            <div class="lp-submit-bar-right">
                <a href="{{ route('admin.properties.lands.index') }}" class="lp-btn lp-btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                    Cancel
                </a>
                <button type="submit" class="lp-btn lp-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Changes
                </button>
            </div>
        </div>

    </form>
</div>

<script>
/* ── Existing image delete toggle ── */
function toggleDeleteImage(id, btn) {
    const item     = document.getElementById('img-item-' + id);
    const checkbox = document.getElementById('del-' + id);
    const marked   = item.classList.toggle('marked-delete');
    checkbox.checked = marked;
    btn.title = marked ? 'Undo removal' : 'Mark for removal';
}

/* ── Title doc remove toggle ── */
function toggleDeleteDoc(btn) {
    const input   = document.getElementById('deleteTitleDoc');
    const deleting = input.value === '0';
    input.value   = deleting ? '1' : '0';
    btn.textContent = deleting ? 'Undo remove' : 'Remove';
    btn.closest('.lp-doc-preview').style.opacity = deleting ? '.4' : '1';
}

/* ── New image previews ── */
const imageInput    = document.getElementById('imageInput');
const imagePreviews = document.getElementById('imagePreviews');
const imageDropzone = document.getElementById('imageDropzone');
let selectedFiles   = [];

imageInput.addEventListener('change', () => addFiles(imageInput.files));

imageDropzone.addEventListener('dragover',  e => { e.preventDefault(); imageDropzone.classList.add('dragover'); });
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
    div.className   = 'lp-preview-item';
    div.dataset.idx = idx;
    div.innerHTML   = `<img src="${src}" alt="preview">
        <button type="button" class="lp-preview-remove" onclick="removePreview(${idx})">✕</button>
        <span class="lp-new-badge">New</span>`;
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
document.getElementById('titleDocInput').addEventListener('change', function () {
    document.getElementById('titleDocName').textContent =
        this.files[0] ? this.files[0].name : 'Replace title deed';
});
</script>

@endsection