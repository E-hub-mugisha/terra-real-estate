@extends('layouts.app')
@section('title', 'Edit House Property — ' . $house->title)
@section('content')

<style>
    :root {
        --accent:   #c9a96e;
        --accent-lt:#e4c990;
        --danger:   #dc3545;
        --success:  #198754;
        --border:   #e2e8f0;
        --surface:  #f8fafc;
        --muted:    #94a3b8;
        --text:     #1e293b;
        --text-dim: #64748b;
        --radius:   10px;
    }

    .hp-page { padding: 1.75rem 0 3rem; max-width: 1200px; margin: 0 auto; }

    /* ── Page heading ── */
    .hp-heading { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .hp-heading-icon {
        width: 44px; height: 44px; border-radius: 10px;
        background: linear-gradient(135deg,#c9a96e22,#c9a96e44);
        border: 1px solid #c9a96e55;
        display: flex; align-items: center; justify-content: center;
        color: var(--accent); flex-shrink: 0;
    }
    .hp-heading h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .hp-heading p  { font-size: .82rem; color: var(--text-dim); margin: .15rem 0 0; }
    .hp-heading-meta { margin-left: auto; display: flex; align-items: center; gap: .6rem; }
    .hp-status-pill {
        display: inline-flex; align-items: center; gap: .4rem;
        padding: .3rem .85rem; border-radius: 100px; font-size: .72rem; font-weight: 600;
    }
    .hp-status-pill.available { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
    .hp-status-pill.reserved  { background:#fffbeb; color:#92400e; border:1px solid #fde68a; }
    .hp-status-pill.sold      { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
    .hp-status-dot { width:7px; height:7px; border-radius:50%; background:currentColor; }

    /* ── Layout ── */
    .hp-layout { display: grid; grid-template-columns: 1fr 320px; gap: 1.25rem; align-items: start; }
    .hp-main { display: flex; flex-direction: column; gap: 1.25rem; }
    .hp-side { display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: 80px; }

    /* ── Card ── */
    .hp-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .hp-card-header {
        display: flex; align-items: center; gap: .75rem;
        padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }
    .hp-card-header-icon {
        width: 32px; height: 32px; border-radius: 8px; background: #c9a96e18;
        display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;
    }
    .hp-card-header h6 { margin: 0; font-size: .88rem; font-weight: 600; color: var(--text); }
    .hp-card-body { padding: 1.5rem; }

    /* ── Form controls ── */
    .hp-label { display: block; font-size: .77rem; font-weight: 600; letter-spacing: .03em; color: var(--text-dim); text-transform: uppercase; margin-bottom: .45rem; }
    .hp-label .req { color: var(--danger); margin-left: .2rem; }
    .hp-input, .hp-select, .hp-textarea {
        width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .875rem; color: var(--text); background: #fff;
        transition: border-color .2s, box-shadow .2s; outline: none; font-family: inherit;
    }
    .hp-input:focus, .hp-select:focus, .hp-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }
    .hp-input.is-invalid, .hp-select.is-invalid, .hp-textarea.is-invalid { border-color: var(--danger); }
    .hp-textarea { resize: vertical; line-height: 1.6; }
    .hp-hint  { font-size: .73rem; color: var(--muted); margin-top: .35rem; }
    .hp-error { font-size: .73rem; color: var(--danger); margin-top: .35rem; display: flex; align-items: center; gap: .3rem; }

    /* ── Input group ── */
    .hp-input-group { display: flex; align-items: stretch; }
    .hp-input-addon {
        padding: .65rem .85rem; background: var(--surface); border: 1.5px solid var(--border);
        font-size: .82rem; font-weight: 600; color: var(--muted); display: flex; align-items: center; white-space: nowrap;
    }
    .hp-input-addon.prefix { border-right: none; border-radius: 8px 0 0 8px; }
    .hp-input-addon.suffix { border-left: none;  border-radius: 0 8px 8px 0; }
    .hp-input-group .hp-input.pfx { border-radius: 0 8px 8px 0; }
    .hp-input-group .hp-input.sfx { border-radius: 8px 0 0 8px; border-right: none; }

    /* ── Counter ── */
    .hp-counter {
        display: flex; align-items: center; border: 1.5px solid var(--border); border-radius: 8px;
        overflow: hidden; background: #fff; transition: border-color .2s, box-shadow .2s;
    }
    .hp-counter:focus-within { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }
    .hp-counter-btn {
        width: 38px; height: 38px; border: none; background: var(--surface); cursor: pointer;
        display: flex; align-items: center; justify-content: center; color: var(--text-dim);
        font-size: 1.1rem; transition: background .15s, color .15s; flex-shrink: 0; font-family: inherit;
    }
    .hp-counter-btn:hover { background: #e4c99022; color: var(--accent); }
    .hp-counter input {
        flex: 1; border: none; outline: none; text-align: center; font-size: .9rem;
        font-weight: 600; color: var(--text); background: transparent; font-family: inherit; min-width: 0; padding: 0;
    }
    .hp-counter input::-webkit-inner-spin-button,
    .hp-counter input::-webkit-outer-spin-button { -webkit-appearance: none; }
    .hp-counter input[type=number] { -moz-appearance: textfield; }

    /* ── Type selector ── */
    .hp-type-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: .6rem; }
    .hp-type-radio { display: none; }
    .hp-type-label {
        display: flex; flex-direction: column; align-items: center; gap: .45rem;
        padding: .85rem .5rem; border: 1.5px solid var(--border); border-radius: 10px;
        cursor: pointer; transition: all .15s; font-size: .76rem; color: var(--text-dim); font-weight: 500; text-align: center;
    }
    .hp-type-label svg { color: var(--muted); transition: color .15s; }
    .hp-type-radio:checked + .hp-type-label { border-color: var(--accent); background: #c9a96e0d; color: var(--accent); }
    .hp-type-radio:checked + .hp-type-label svg { color: var(--accent); }

    /* ── Existing images ── */
    .hp-img-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: .6rem; margin-bottom: 1rem; }
    .hp-img-item {
        position: relative; border-radius: 8px; overflow: hidden; aspect-ratio: 1;
        background: var(--border); transition: opacity .2s;
    }
    .hp-img-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hp-img-item.marked-delete { opacity: .3; }
    .hp-img-item.marked-delete .hp-img-del-label { opacity: 1; }
    .hp-img-overlay {
        position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
        background: rgba(0,0,0,0); transition: background .2s;
    }
    .hp-img-item:hover .hp-img-overlay { background: rgba(0,0,0,.4); }
    .hp-img-del-btn {
        width: 28px; height: 28px; border-radius: 50%; background: rgba(220,53,69,.9);
        border: none; color: #fff; cursor: pointer; display: flex; align-items: center;
        justify-content: center; opacity: 0; transition: opacity .2s; font-size: 11px;
    }
    .hp-img-item:hover .hp-img-del-btn { opacity: 1; }
    .hp-img-item.marked-delete .hp-img-del-btn { opacity: 1; background: rgba(100,116,139,.9); }
    .hp-img-cover-badge {
        position: absolute; top: 4px; left: 4px; background: var(--accent); color: #fff;
        font-size: .6rem; font-weight: 700; padding: .15rem .5rem; border-radius: 100px;
    }
    .hp-img-del-label {
        position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%);
        background: var(--danger); color: #fff; font-size: .6rem; font-weight: 700;
        padding: .15rem .5rem; border-radius: 100px; white-space: nowrap; opacity: 0; transition: opacity .2s;
    }

    /* ── Dropzone ── */
    .hp-dropzone {
        border: 2px dashed var(--border); border-radius: 10px; padding: 1.5rem 1.25rem;
        text-align: center; cursor: pointer; transition: border-color .2s, background .2s;
        background: var(--surface); position: relative;
    }
    .hp-dropzone:hover, .hp-dropzone.dragover { border-color: var(--accent); background: #c9a96e08; }
    .hp-dropzone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .hp-dropzone-icon { width: 38px; height: 38px; border-radius: 10px; background: #c9a96e18; display: flex; align-items: center; justify-content: center; margin: 0 auto .6rem; color: var(--accent); }
    .hp-dropzone h6 { font-size: .83rem; font-weight: 600; color: var(--text); margin: 0 0 .2rem; }
    .hp-dropzone p  { font-size: .74rem; color: var(--muted); margin: 0; }
    .hp-browse { color: var(--accent); font-weight: 500; }

    .hp-previews { display: grid; grid-template-columns: repeat(3,1fr); gap: .5rem; margin-top: .75rem; }
    .hp-preview-item { position: relative; border-radius: 8px; overflow: hidden; aspect-ratio: 1; background: var(--border); }
    .hp-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hp-preview-remove {
        position: absolute; top: 3px; right: 3px; width: 20px; height: 20px; border-radius: 50%;
        background: rgba(0,0,0,.65); border: none; color: #fff; display: flex; align-items: center;
        justify-content: center; cursor: pointer; font-size: 9px;
    }
    .hp-new-badge {
        position: absolute; bottom: 4px; left: 4px; background: #3b82f6; color: #fff;
        font-size: .58rem; font-weight: 700; padding: .15rem .45rem; border-radius: 100px;
    }
    .hp-preview-count { font-size: .72rem; color: var(--muted); text-align: center; margin-top: .5rem; }

    /* ── Facilities ── */
    .hp-facilities-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; }
    .hp-facility-item { display: none; }
    .hp-facility-label {
        display: flex; align-items: center; gap: .55rem; padding: .55rem .8rem;
        border: 1.5px solid var(--border); border-radius: 8px; font-size: .8rem;
        color: var(--text-dim); cursor: pointer; transition: all .15s; user-select: none; font-weight: 400;
    }
    .hp-facility-label svg { color: var(--muted); flex-shrink: 0; transition: color .15s; }
    .hp-facility-item:checked + .hp-facility-label { border-color: var(--accent); background: #c9a96e0d; color: var(--accent); font-weight: 500; }
    .hp-facility-item:checked + .hp-facility-label svg { color: var(--accent); }
    .hp-facility-check {
        width: 16px; height: 16px; border-radius: 4px; border: 1.5px solid var(--border);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all .15s; margin-left: auto;
    }
    .hp-facility-item:checked + .hp-facility-label .hp-facility-check { background: var(--accent); border-color: var(--accent); }

    /* ── Alerts ── */
    .hp-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: flex-start; margin-bottom: 1.25rem; }
    .hp-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .hp-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .hp-alert ul { margin: .35rem 0 0 1rem; padding: 0; }
    .hp-alert li { margin-bottom: .2rem; }

    /* ── Submit bar ── */
    .hp-submit-bar {
        display: flex; align-items: center; justify-content: space-between; gap: .75rem;
        padding: 1.1rem 1.5rem; background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
    }
    .hp-submit-bar-left { font-size: .78rem; color: var(--muted); display: flex; align-items: center; gap: .4rem; }
    .hp-submit-bar-right { display: flex; gap: .6rem; }
    .hp-btn {
        display: inline-flex; align-items: center; gap: .45rem; padding: .65rem 1.4rem;
        border-radius: 8px; font-size: .85rem; font-weight: 600; border: none;
        cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .hp-btn-primary { background: var(--accent); color: #fff; }
    .hp-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }
    .hp-btn-ghost { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .hp-btn-ghost:hover { border-color: var(--accent); color: var(--accent); }

    @media (max-width: 960px) {
        .hp-layout { grid-template-columns: 1fr; }
        .hp-side { position: static; }
        .hp-type-grid { grid-template-columns: repeat(2,1fr); }
    }
</style>

<div class="hp-page">

    {{-- ── Heading ── --}}
    <div class="hp-heading">
        <div class="hp-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div>
            <h4>Edit House Property</h4>
            <p>{{ Str::limit($house->title, 55) }} &mdash; last updated {{ $house->updated_at->diffForHumans() }}</p>
        </div>
        <div class="hp-heading-meta">
            <span class="hp-status-pill {{ $house->status }}">
                <span class="hp-status-dot"></span>
                {{ ucfirst($house->status) }}
            </span>
            <a href="{{ route('admin.properties.houses.show', $house->id) }}" class="hp-btn hp-btn-ghost" style="padding:.4rem .9rem;font-size:.78rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Preview
            </a>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
        <div class="hp-alert hp-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="hp-alert hp-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.properties.houses.update', $house->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="hp-layout">

            {{-- ══ MAIN COLUMN ══ --}}
            <div class="hp-main">

                {{-- ── Property Details ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <h6>Property Details</h6>
                    </div>
                    <div class="hp-card-body">
                        <div class="row g-4">

                            {{-- Title + UPI --}}
                            <div class="col-md-7">
                                <label class="hp-label">Property Title <span class="req">*</span></label>
                                <input type="text" name="title"
                                       class="hp-input @error('title') is-invalid @enderror"
                                       value="{{ old('title', $house->title) }}"
                                       placeholder="e.g. Modern Family Home in Kigali Heights" required>
                                @error('title')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-5">
                                <label class="hp-label">Property UPI</label>
                                <input type="text" name="upi"
                                       class="hp-input @error('upi') is-invalid @enderror"
                                       value="{{ old('upi', $house->upi) }}"
                                       placeholder="e.g. 1/01/01/01/1234">
                                @error('upi')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            {{-- Property Type ── visual cards --}}
                            <div class="col-12">
                                <label class="hp-label">Property Type <span class="req">*</span></label>
                                <div class="hp-type-grid">
                                    @php
                                        $types = [
                                            'house'     => ['label' => 'House',     'icon' => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>'],
                                            'apartment' => ['label' => 'Apartment', 'icon' => '<rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01M12 10h.01M8 10h.01M16 10h.01M12 14h.01M8 14h.01M16 14h.01"/>'],
                                            'villa'     => ['label' => 'Villa',     'icon' => '<path d="M2 20h20M4 20V10l8-6 8 6v10"/><path d="M10 20v-5h4v5"/>'],
                                            'townhouse' => ['label' => 'Townhouse', 'icon' => '<path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/><path d="M9 21V12h6v9"/>'],
                                        ];
                                    @endphp
                                    @foreach($types as $val => $meta)
                                        <input type="radio" name="type" id="type_{{ $val }}"
                                               value="{{ $val }}" class="hp-type-radio"
                                               {{ old('type', $house->type) === $val ? 'checked' : '' }} required>
                                        <label for="type_{{ $val }}" class="hp-type-label">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">{!! $meta['icon'] !!}</svg>
                                            {{ $meta['label'] }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('type')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="hp-label">Condition <span class="req">*</span></label>
                                <select name="condition"
                                    class="hp-select @error('condition') is-invalid @enderror" required>
                                    <option value="">Select condition</option>
                                    <option value="for_sale" {{ old('condition', $house->condition) === 'for_sale' ? 'selected' : '' }}>For Sale</option>
                                    <option value="for_rent" {{ old('condition', $house->condition) === 'for_rent'  ? 'selected' : '' }}>For Rent</option>
                                </select>
                                @error('condition')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="hp-label">Status <span class="req">*</span></label>
                                <select name="status"
                                        class="hp-select @error('status') is-invalid @enderror" required>
                                    <option value="available" {{ old('status', $house->status) === 'available' ? 'selected' : '' }}>Available</option>
                                </select>
                                @error('status')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            {{-- Price + Area --}}
                            <div class="col-md-6">
                                <label class="hp-label">Price <span class="req">*</span></label>
                                <div class="hp-input-group">
                                    <span class="hp-input-addon prefix">$</span>
                                    <input type="number" name="price"
                                           class="hp-input pfx @error('price') is-invalid @enderror"
                                           value="{{ old('price', $house->price) }}"
                                           placeholder="0.00" min="0" step="0.01" required>
                                </div>
                                @error('price')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="hp-label">Area <span class="req">*</span></label>
                                <div class="hp-input-group">
                                    <input type="number" name="area_sqft"
                                           class="hp-input sfx @error('area_sqft') is-invalid @enderror"
                                           value="{{ old('area_sqft', $house->area_sqft) }}"
                                           placeholder="0" min="1" required>
                                    <span class="hp-input-addon suffix">sq ft</span>
                                </div>
                                @error('area_sqft')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            {{-- Bedrooms / Bathrooms / Garages --}}
                            <div class="col-md-4">
                                <label class="hp-label">Bedrooms <span class="req">*</span></label>
                                <div class="hp-counter">
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('bedrooms',-1)">−</button>
                                    <input type="number" name="bedrooms" id="bedrooms"
                                           value="{{ old('bedrooms', $house->bedrooms) }}" min="0" max="20" required>
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('bedrooms',1)">+</button>
                                </div>
                                @error('bedrooms')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="hp-label">Bathrooms <span class="req">*</span></label>
                                <div class="hp-counter">
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('bathrooms',-1)">−</button>
                                    <input type="number" name="bathrooms" id="bathrooms"
                                           value="{{ old('bathrooms', $house->bathrooms) }}" min="0" max="20" required>
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('bathrooms',1)">+</button>
                                </div>
                                @error('bathrooms')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            <div class="col-md-4">
                                <label class="hp-label">Garages</label>
                                <div class="hp-counter">
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('garages',-1)">−</button>
                                    <input type="number" name="garages" id="garages"
                                           value="{{ old('garages', $house->garages) }}" min="0" max="10">
                                    <button type="button" class="hp-counter-btn" onclick="stepCounter('garages',1)">+</button>
                                </div>
                                @error('garages')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <label class="hp-label">Description</label>
                                <textarea name="description" rows="4"
                                          class="hp-textarea @error('description') is-invalid @enderror"
                                          placeholder="Describe the property…">{{ old('description', $house->description) }}</textarea>
                                @error('description')<p class="hp-error">{{ $message }}</p>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Location ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h6>Location Details</h6>
                    </div>
                    <div class="hp-card-body">
                        @include('includes.form')
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
                        {{ old('listing_package_id', $house->listing_package_id) == $pkg->id ? 'selected' : '' }}>
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
                    value="{{ old('listing_days', $house->listing_days ?? 30) }}"
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
                            value="{{ old('owner_name', $house->owner_name) }}"
                            placeholder="Full legal name" required>
                        @error('owner_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">National ID / Passport No.</label>
                        <input type="text" name="owner_id_number"
                            class="form-control @error('owner_id_number') is-invalid @enderror"
                            value="{{ old('owner_id_number', $house->owner_id_number) }}"
                            placeholder="1 XXXX X XXXXXXX X XX">
                        @error('owner_id_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Phone <span class="text-danger">*</span></label>
                        <input type="text" name="owner_phone"
                            class="form-control @error('owner_phone') is-invalid @enderror"
                            value="{{ old('owner_phone', $house->owner_phone) }}"
                            placeholder="+250 7XX XXX XXX" required>
                        @error('owner_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Owner Email</label>
                        <input type="email" name="owner_email"
                            class="form-control @error('owner_email') is-invalid @enderror"
                            value="{{ old('owner_email', $house->owner_email) }}"
                            placeholder="owner@email.com">
                        @error('owner_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

                {{-- ── Submit bar ── --}}
                <div class="hp-submit-bar">
                    <div class="hp-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $house->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="hp-submit-bar-right">
                        <a href="{{ route('admin.properties.houses.index') }}" class="hp-btn hp-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="hp-btn hp-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>{{-- /.hp-main --}}

            {{-- ══ SIDEBAR ══ --}}
            <div class="hp-side">

                {{-- ── Photos ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        </div>
                        <h6>Photos</h6>
                    </div>
                    <div class="hp-card-body">

                        {{-- Existing images --}}
                        @if($house->images && $house->images->count())
                            <p style="font-size:.73rem;font-weight:600;letter-spacing:.04em;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem;">
                                Current ({{ $house->images->count() }})
                            </p>
                            <div class="hp-img-grid" id="existingGrid">
                                @foreach($house->images as $i => $image)
                                    <div class="hp-img-item" id="img-item-{{ $image->id }}">
                                        <img src="{{ asset('image/houses/' . $image->image_path) }}" alt="Photo {{ $i + 1 }}">
                                        @if($i === 0)
                                            <span class="hp-img-cover-badge">Cover</span>
                                        @endif
                                        <span class="hp-img-del-label">Remove</span>
                                        <div class="hp-img-overlay">
                                            <button type="button" class="hp-img-del-btn"
                                                    onclick="toggleDelImg({{ $image->id }}, this)"
                                                    title="Mark for removal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                        <input type="checkbox" name="delete_images[]"
                                               value="{{ $image->id }}" id="del-{{ $image->id }}"
                                               style="display:none">
                                    </div>
                                @endforeach
                            </div>
                            <p class="hp-hint" style="margin-bottom:1rem;">Click × to mark a photo for removal.</p>
                        @else
                            <div style="text-align:center;padding:1rem;border:1px dashed var(--border);border-radius:8px;color:var(--muted);font-size:.8rem;margin-bottom:1rem;">
                                No photos yet.
                            </div>
                        @endif

                        {{-- Add new --}}
                        <p style="font-size:.73rem;font-weight:600;letter-spacing:.04em;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem;">
                            Add New
                        </p>
                        <div class="hp-dropzone" id="imgDropzone">
                            <input type="file" name="images[]" id="imgInput" accept="image/*" multiple>
                            <div class="hp-dropzone-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            </div>
                            <h6>Drop photos here</h6>
                            <p>or <span class="hp-browse">browse</span></p>
                        </div>
                        <div class="hp-previews" id="imgPreviews"></div>
                        <p class="hp-preview-count" id="imgCount"></p>
                        @error('images.*')<p class="hp-error">{{ $message }}</p>@enderror

                    </div>
                </div>

                {{-- ── Facilities ── --}}
                <div class="hp-card">
                    <div class="hp-card-header">
                        <div class="hp-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                        </div>
                        <h6>Facilities</h6>
                    </div>
                    <div class="hp-card-body" style="padding-top:1.1rem;">
                        @php
                            $currentFacilities = old('facilities', $house->facilities->pluck('id')->toArray());
                        @endphp
                        <div class="hp-facilities-grid">
                            @foreach($facilities as $facility)
                                <input type="checkbox" name="facilities[]"
                                       id="fac_{{ $facility->id }}"
                                       value="{{ $facility->id }}"
                                       class="hp-facility-item"
                                       {{ in_array($facility->id, $currentFacilities) ? 'checked' : '' }}>
                                <label for="fac_{{ $facility->id }}" class="hp-facility-label">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                                    {{ $facility->name }}
                                    <span class="hp-facility-check">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"><path d="M20 6 9 17l-5-5"/></svg>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('facilities')<p class="hp-error" style="margin-top:.75rem">{{ $message }}</p>@enderror
                    </div>
                </div>

            </div>{{-- /.hp-side --}}

        </div>{{-- /.hp-layout --}}
    </form>
</div>

<script>
/* ── Counter buttons ── */
function stepCounter(id, delta) {
    const input = document.getElementById(id);
    const min   = parseInt(input.min ?? 0);
    const max   = parseInt(input.max ?? 999);
    input.value = Math.min(max, Math.max(min, (parseInt(input.value) || 0) + delta));
}

/* ── Mark existing image for deletion ── */
function toggleDelImg(id, btn) {
    const item     = document.getElementById('img-item-' + id);
    const checkbox = document.getElementById('del-' + id);
    const marked   = item.classList.toggle('marked-delete');
    checkbox.checked = marked;
    btn.title = marked ? 'Undo removal' : 'Mark for removal';
}

/* ── New image drag-and-drop ── */
const imgInput    = document.getElementById('imgInput');
const imgPreviews = document.getElementById('imgPreviews');
const imgDropzone = document.getElementById('imgDropzone');
const imgCount    = document.getElementById('imgCount');
let selectedFiles = [];

imgInput.addEventListener('change', () => addFiles(imgInput.files));
imgDropzone.addEventListener('dragover',  e => { e.preventDefault(); imgDropzone.classList.add('dragover'); });
imgDropzone.addEventListener('dragleave', () => imgDropzone.classList.remove('dragover'));
imgDropzone.addEventListener('drop', e => {
    e.preventDefault();
    imgDropzone.classList.remove('dragover');
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
    const div       = document.createElement('div');
    div.className   = 'hp-preview-item';
    div.dataset.idx = idx;
    div.innerHTML   = `<img src="${src}" alt="preview">
        <button type="button" class="hp-preview-remove" onclick="removePreview(${idx})">✕</button>
        <span class="hp-new-badge">New</span>`;
    imgPreviews.appendChild(div);
    updateCount();
}

function removePreview(idx) {
    selectedFiles[idx] = null;
    document.querySelector(`.hp-preview-item[data-idx="${idx}"]`)?.remove();
    syncInput();
    updateCount();
}

function syncInput() {
    const dt = new DataTransfer();
    selectedFiles.filter(Boolean).forEach(f => dt.items.add(f));
    imgInput.files = dt.files;
}

function updateCount() {
    const n = selectedFiles.filter(Boolean).length;
    imgCount.textContent = n ? `${n} new photo${n > 1 ? 's' : ''} queued` : '';
}
</script>

@endsection