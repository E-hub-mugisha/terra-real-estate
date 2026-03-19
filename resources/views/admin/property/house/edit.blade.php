@extends('layouts.app')
@section('title', 'Edit House — '.$house->title)
@section('content')

<style>
.he-topbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }
.he-back-btn { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border:1.5px solid #e2e8f0; border-radius:8px; background:#fff; font-size:.81rem; font-weight:500; color:#475569; transition:all .18s; text-decoration:none; }
.he-back-btn:hover { border-color:#3b82f6; color:#2563eb; background:#eff6ff; }
.he-back-btn svg { width:14px; height:14px; }

.he-card { background:#fff; border:1px solid #e5e7eb; border-radius:12px; margin-bottom:16px; overflow:hidden; }
.he-card-head { padding:14px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:8px; }
.he-card-icon { width:30px; height:30px; border-radius:7px; background:#eff6ff; border:1px solid #bfdbfe; display:grid; place-items:center; flex-shrink:0; }
.he-card-icon svg { width:14px; height:14px; color:#2563eb; }
.he-card-title { font-size:.88rem; font-weight:700; color:#1e293b; margin:0; }
.he-card-body { padding:20px; }

.he-label { font-size:.72rem; font-weight:600; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:5px; display:block; }
.he-input { width:100%; padding:9px 12px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:.83rem; color:#1e293b; font-family:inherit; transition:border-color .18s, box-shadow .18s; background:#fafbfc; }
.he-input:focus { outline:none; border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.1); background:#fff; }
.he-input.is-invalid { border-color:#f87171; }
.he-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:32px; }
.he-textarea { resize:vertical; min-height:100px; }
.he-hint  { font-size:.72rem; color:#94a3b8; margin-top:4px; }
.he-error { font-size:.72rem; color:#dc2626; margin-top:4px; }

/* Stepper (bedrooms / bathrooms / garages) */
.he-stepper { display:flex; align-items:center; border:1.5px solid #e2e8f0; border-radius:9px; overflow:hidden; background:#fafbfc; }
.he-stepper button { width:36px; height:38px; border:none; background:transparent; font-size:1rem; cursor:pointer; color:#475569; transition:background .15s; flex-shrink:0; }
.he-stepper button:hover { background:#eff6ff; color:#2563eb; }
.he-stepper input { flex:1; border:none; background:transparent; text-align:center; font-size:.88rem; font-weight:700; color:#1e293b; padding:0; min-width:0; -moz-appearance:textfield; }
.he-stepper input::-webkit-outer-spin-button,
.he-stepper input::-webkit-inner-spin-button { -webkit-appearance:none; }
.he-stepper input:focus { outline:none; }

/* Image manager */
.he-img-grid { display:flex; flex-wrap:wrap; gap:10px; }
.he-img-item { position:relative; width:90px; height:72px; border-radius:8px; overflow:hidden; border:1px solid #e2e8f0; }
.he-img-item img { width:100%; height:100%; object-fit:cover; display:block; }
.he-img-del { position:absolute; top:3px; right:3px; width:20px; height:20px; border-radius:50%; background:rgba(220,38,38,.85); border:none; cursor:pointer; display:grid; place-items:center; }
.he-img-del svg { width:10px; height:10px; color:#fff; }
.he-img-dl { position:absolute; bottom:3px; right:3px; width:20px; height:20px; border-radius:50%; background:rgba(0,0,0,.55); display:grid; place-items:center; text-decoration:none; }
.he-img-dl svg { width:10px; height:10px; color:#fff; }

/* Upload drop zone */
.he-drop { border:2px dashed #e2e8f0; border-radius:10px; padding:20px; text-align:center; background:#fafbfc; cursor:pointer; transition:all .18s; }
.he-drop:hover, .he-drop.dragover { border-color:#3b82f6; background:#eff6ff; }
.he-drop svg { width:26px; height:26px; color:#94a3b8; margin-bottom:6px; }
.he-drop p { font-size:.8rem; color:#64748b; margin:0; }
.he-drop span { font-size:.72rem; color:#94a3b8; }
.he-upload-previews { display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }
.he-prev-thumb { position:relative; width:72px; height:58px; border-radius:7px; overflow:hidden; border:1px solid #e2e8f0; }
.he-prev-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
.he-prev-rm { position:absolute; top:2px; right:2px; width:16px; height:16px; border-radius:50%; background:rgba(220,38,38,.85); border:none; cursor:pointer; display:grid; place-items:center; }
.he-prev-rm svg { width:9px; height:9px; color:#fff; }

/* Amenity checkboxes */
.he-amenity-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:8px; }
.he-amenity-check { display:flex; align-items:center; gap:8px; padding:9px 12px; border-radius:9px; border:1.5px solid #e2e8f0; background:#fafbfc; cursor:pointer; transition:all .18s; font-size:.81rem; color:#475569; }
.he-amenity-check:hover { border-color:#bfdbfe; background:#eff6ff; }
.he-amenity-check input[type=checkbox] { width:15px; height:15px; flex-shrink:0; accent-color:#2563eb; }
.he-amenity-check.checked { border-color:#bfdbfe; background:#eff6ff; color:#1d4ed8; font-weight:600; }
</style>

{{-- Top bar --}}
<div class="he-topbar">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.properties.houses.show', $house->id) }}" class="he-back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to Details
        </a>
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="#">Property</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.properties.houses.index') }}">Houses</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.properties.houses.show', $house->id) }}">{{ Str::limit($house->title, 28) }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.properties.houses.show', $house->id) }}"
           class="btn btn-sm btn-outline-secondary">Discard</a>
        <button type="submit" form="house-edit-form"
                class="btn btn-sm btn-primary d-flex align-items-center gap-1">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
        </button>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show small mb-3" role="alert">
    <strong>Please fix the following errors:</strong>
    <ul class="mb-0 mt-1 ps-3">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show small mb-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<form id="house-edit-form" method="POST"
      action="{{ route('admin.properties.houses.update', $house->id) }}">
@csrf @method('PUT')

<div class="row g-3">

    {{-- ══ LEFT ══ --}}
    <div class="col-xl-8">

        {{-- Basic Info ── --}}
        <div class="he-card">
            <div class="he-card-head">
                <div class="he-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>
                <h6 class="he-card-title">Basic Information</h6>
            </div>
            <div class="he-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="he-label">Property Title <span class="text-danger">*</span></label>
                        <input type="text" name="title"
                               class="he-input @error('title') is-invalid @enderror"
                               value="{{ old('title', $house->title) }}"
                               placeholder="e.g. Modern 3-Bedroom House in Kigali" required>
                        @error('title')<div class="he-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="he-label">Property upi <span class="text-danger">*</span></label>
                        <input type="text" name="upi"
                               class="he-input @error('upi') is-invalid @enderror"
                               value="{{ old('upi', $house->upi) }}"
                               placeholder="e.g. 1/01/05/06/3723" required>
                        @error('upi')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Property Type <span class="text-danger">*</span></label>
                        <select name="type" class="he-input he-select @error('type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            @foreach(['House','Apartment','Villa','Townhouse','Duplex','Studio','Penthouse','Bungalow'] as $t)
                            <option value="{{ $t }}" {{ old('type', $house->type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                        @error('type')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Condition <span class="text-danger">*</span></label>
                        <select name="condition" class="he-input he-select @error('condition') is-invalid @enderror" required>
                            @foreach(['for_sale' => 'For Sale', 'for_rent' => 'For Rent', 'sold' => 'Sold'] as $val => $label)
                            <option value="{{ $val }}" {{ old('condition', $house->condition) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('condition')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="he-input he-select @error('status') is-invalid @enderror" required>
                            @foreach(['active','pending','inactive'] as $s)
                            <option value="{{ $s }}" {{ old('status', $house->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Service / Category</label>
                        <select name="service_id" class="he-input he-select @error('service_id') is-invalid @enderror">
                            <option value="">No Service</option>
                            @foreach($services ?? [] as $svc)
                            <option value="{{ $svc->id }}" {{ old('service_id', $house->service_id) == $svc->id ? 'selected' : '' }}>
                                {{ $svc->title }}
                            </option>
                            @endforeach
                        </select>
                        @error('service_id')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="he-label">Description</label>
                        <textarea name="description"
                                  class="he-input he-textarea @error('description') is-invalid @enderror"
                                  placeholder="Describe the property — location highlights, features, surroundings…">{{ old('description', $house->description) }}</textarea>
                        @error('description')<div class="he-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Specifications ── --}}
        <div class="he-card">
            <div class="he-card-head">
                <div class="he-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg></div>
                <h6 class="he-card-title">Specifications</h6>
            </div>
            <div class="he-card-body">
                <div class="row g-3">

                    {{-- Bedrooms stepper --}}
                    <div class="col-md-4">
                        <label class="he-label">Bedrooms <span class="text-danger">*</span></label>
                        <div class="he-stepper">
                            <button type="button" onclick="stepVal('bedrooms',-1)">−</button>
                            <input type="number" name="bedrooms" id="bedrooms" min="0" max="20"
                                   value="{{ old('bedrooms', $house->bedrooms ?? 1) }}" required>
                            <button type="button" onclick="stepVal('bedrooms',1)">+</button>
                        </div>
                        @error('bedrooms')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Bathrooms stepper --}}
                    <div class="col-md-4">
                        <label class="he-label">Bathrooms <span class="text-danger">*</span></label>
                        <div class="he-stepper">
                            <button type="button" onclick="stepVal('bathrooms',-1)">−</button>
                            <input type="number" name="bathrooms" id="bathrooms" min="0" max="20"
                                   value="{{ old('bathrooms', $house->bathrooms ?? 1) }}" required>
                            <button type="button" onclick="stepVal('bathrooms',1)">+</button>
                        </div>
                        @error('bathrooms')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    {{-- Garages stepper --}}
                    <div class="col-md-4">
                        <label class="he-label">Garages</label>
                        <div class="he-stepper">
                            <button type="button" onclick="stepVal('garages',-1)">−</button>
                            <input type="number" name="garages" id="garages" min="0" max="10"
                                   value="{{ old('garages', $house->garages ?? 0) }}">
                            <button type="button" onclick="stepVal('garages',1)">+</button>
                        </div>
                        @error('garages')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Area (ft²) <span class="text-danger">*</span></label>
                        <input type="number" name="area_sqft" step="0.01" min="0"
                               class="he-input @error('area_sqft') is-invalid @enderror"
                               value="{{ old('area_sqft', $house->area_sqft) }}"
                               placeholder="e.g. 1200" required>
                        @error('area_sqft')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Year Built</label>
                        <input type="number" name="year_built" min="1900" max="{{ date('Y') }}"
                               class="he-input @error('year_built') is-invalid @enderror"
                               value="{{ old('year_built', $house->year_built) }}"
                               placeholder="e.g. 2018">
                        @error('year_built')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Price (RWF) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.8rem;border-radius:9px 0 0 9px;border:1.5px solid #e2e8f0;border-right:none;background:#f8fafc">RWF</span>
                            <input type="number" name="price" step="0.01" min="0"
                                   class="he-input @error('price') is-invalid @enderror"
                                   style="border-radius:0 9px 9px 0"
                                   value="{{ old('price', $house->price) }}"
                                   placeholder="e.g. 25000000" required>
                        </div>
                        @error('price')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Furnishing</label>
                        <select name="furnishing" class="he-input he-select @error('furnishing') is-invalid @enderror">
                            <option value="">Select Furnishing</option>
                            @foreach(['Unfurnished','Semi-Furnished','Fully Furnished'] as $f)
                            <option value="{{ $f }}" {{ old('furnishing', $house->furnishing ?? '') === $f ? 'selected' : '' }}>{{ $f }}</option>
                            @endforeach
                        </select>
                        @error('furnishing')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- Location ── --}}
        <div class="he-card">
            <div class="he-card-head">
                <div class="he-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg></div>
                <h6 class="he-card-title">Location</h6>
            </div>
            <div class="he-card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="he-label">Street Address <span class="text-danger">*</span></label>
                        <input type="text" name="address"
                               class="he-input @error('address') is-invalid @enderror"
                               value="{{ old('address', $house->address) }}"
                               placeholder="e.g. KG 15 Avenue" required>
                        @error('address')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">City <span class="text-danger">*</span></label>
                        <input type="text" name="city"
                               class="he-input @error('city') is-invalid @enderror"
                               value="{{ old('city', $house->city) }}"
                               placeholder="e.g. Kigali" required>
                        @error('city')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">State / Province</label>
                        <input type="text" name="state"
                               class="he-input @error('state') is-invalid @enderror"
                               value="{{ old('state', $house->state) }}"
                               placeholder="e.g. Kigali City">
                        @error('state')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">Country</label>
                        <input type="text" name="country"
                               class="he-input @error('country') is-invalid @enderror"
                               value="{{ old('country', $house->country ?? 'Rwanda') }}"
                               placeholder="Rwanda">
                        @error('country')<div class="he-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="he-label">ZIP / Postal Code</label>
                        <input type="text" name="zip_code"
                               class="he-input @error('zip_code') is-invalid @enderror"
                               value="{{ old('zip_code', $house->zip_code) }}"
                               placeholder="e.g. 00000">
                        @error('zip_code')<div class="he-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Amenities ── --}}
        <div class="he-card">
            <div class="he-card-head">
                <div class="he-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <h6 class="he-card-title">Amenities &amp; Features</h6>
                <span class="text-muted small ms-auto">Select all that apply</span>
            </div>
            <div class="he-card-body">
                @php
                $amenityList = [
                    'Swimming Pool','Gym','Parking','Garden','Security',
                    'Air Conditioning','Generator','Balcony','Fireplace',
                    'CCTV','Elevator','Solar Panels','Borehole','Fence','Staff Quarters'
                ];
                $currentFacilities = $house->facilities->pluck('name')->toArray();
                @endphp
                <div class="he-amenity-grid" id="amenity-grid">
                    @foreach($amenityList as $amenity)
                    @php $checked = in_array($amenity, $currentFacilities); @endphp
                    <label class="he-amenity-check {{ $checked ? 'checked' : '' }}">
                        <input type="checkbox" name="amenities[]"
                               value="{{ $amenity }}"
                               {{ $checked ? 'checked' : '' }}>
                        {{ $amenity }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

    </div>{{-- /col-xl-8 --}}

    {{-- ══ RIGHT: Sidebar ══ --}}
    <div class="col-xl-4">
        <div class="position-sticky" style="top:24px">

            {{-- Current Images ── --}}
            <div class="he-card">
                <div class="he-card-head">
                    <div class="he-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg></div>
                    <h6 class="he-card-title">Current Photos</h6>
                    <span class="badge bg-secondary ms-auto">{{ $house->images->count() }}</span>
                </div>
                <div class="he-card-body">
                    @if($house->images->count())
                    <div class="he-img-grid mb-3">
                        @foreach($house->images as $img)
                        <div class="he-img-item" id="img-{{ $img->id }}">
                            <img src="{{ asset('storage/'.$img->image_path) }}" alt="Photo">
                            <a href="{{ asset('storage/'.$img->image_path) }}" download
                               class="he-img-dl" title="Download">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
                            </a>
                            <button type="button" class="he-img-del"
                                    onclick="deleteImage({{ $img->id }}, this)"
                                    title="Remove photo">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted small text-center py-2 mb-3">No photos uploaded yet.</p>
                    @endif

                    <p class="he-label mb-2">Add More Photos</p>
                    <div class="he-drop" id="he-drop"
                         onclick="document.getElementById('new-photos').click()">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.35 10.04A7.49 7.49 0 0012 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 000 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                        <p><b>Click to upload</b> or drag &amp; drop</p>
                        <span>JPEG, PNG, WEBP · Max 5MB each</span>
                        <input type="file" id="new-photos" name="new_images[]"
                               multiple accept="image/*" style="display:none">
                    </div>
                    <div class="he-upload-previews" id="he-previews"></div>
                </div>
            </div>

            {{-- Summary ── --}}
            <div class="he-card">
                <div class="he-card-head">
                    <div class="he-card-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg></div>
                    <h6 class="he-card-title">Current Values</h6>
                </div>
                <div class="he-card-body">
                    <div style="font-size:.8rem;display:flex;flex-direction:column;gap:8px">
                        <div class="d-flex justify-content-between"><span class="text-muted">Type</span><span class="fw-600">{{ $house->type ?? '—' }}</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Condition</span><span class="fw-600">{{ ucwords(str_replace('_',' ',$house->condition ?? '—')) }}</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Beds / Baths</span><span class="fw-600">{{ $house->bedrooms }}bd / {{ $house->bathrooms }}ba</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Area</span><span class="fw-600">{{ number_format($house->area_sqft ?? 0) }} ft²</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Price</span><span class="fw-600 text-primary">{{ number_format($house->price) }} RWF</span></div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Status</span>
                            <span class="badge {{ match($house->status) { 'active'=>'bg-success','pending'=>'bg-warning text-dark',default=>'bg-danger' } }}">
                                {{ ucfirst($house->status) }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between"><span class="text-muted">Last updated</span><span class="fw-600">{{ $house->updated_at->format('d M Y') }}</span></div>
                    </div>
                </div>
            </div>

            {{-- Save ── --}}
            <div class="d-flex flex-column gap-2">
                <button type="submit" form="house-edit-form"
                        class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.properties.houses.show', $house->id) }}"
                   class="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                    Discard &amp; Go Back
                </a>
            </div>

        </div>
    </div>

</div>{{-- /row --}}
</form>

<script>
/* ── Stepper ── */
window.stepVal = function (id, delta) {
    const el  = document.getElementById(id);
    const min = parseInt(el.min ?? 0);
    const max = parseInt(el.max ?? 99);
    el.value  = Math.min(max, Math.max(min, (parseInt(el.value) || 0) + delta));
};

/* ── Amenity checkbox styling ── */
document.querySelectorAll('.he-amenity-check input[type=checkbox]').forEach(cb => {
    cb.addEventListener('change', () => {
        cb.closest('.he-amenity-check').classList.toggle('checked', cb.checked);
    });
});

/* ── Image delete (AJAX) ── */
window.deleteImage = function (id, btn) {
    if (!confirm('Remove this photo?')) return;
    btn.disabled = true;
    fetch('{{ url("admin/properties/houses") }}/' + {{ $house->id }} + '/images/' + id, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(d => {
        if (d.success) {
            const el = document.getElementById('img-' + id);
            if (el) el.remove();
        } else { alert('Could not delete image.'); btn.disabled = false; }
    })
    .catch(() => { alert('Error deleting image.'); btn.disabled = false; });
};

/* ── New photo previews + auto-upload ── */
const photoInput = document.getElementById('new-photos');
const previewsEl = document.getElementById('he-previews');
let newFiles = [];

function renderPreviews() {
    previewsEl.innerHTML = '';
    newFiles.forEach((f, i) => {
        const url  = URL.createObjectURL(f);
        const wrap = document.createElement('div');
        wrap.className = 'he-prev-thumb';
        wrap.innerHTML = `<img src="${url}"><button type="button" class="he-prev-rm" data-i="${i}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>`;
        previewsEl.appendChild(wrap);
    });
}

if (photoInput) {
    photoInput.addEventListener('change', e => {
        newFiles = [...newFiles, ...Array.from(e.target.files)];
        renderPreviews();
        if (newFiles.length) uploadNewPhotos();
    });
}

previewsEl.addEventListener('click', e => {
    const btn = e.target.closest('[data-i]');
    if (btn) { newFiles.splice(+btn.dataset.i, 1); renderPreviews(); }
});

const dropEl = document.getElementById('he-drop');
if (dropEl) {
    dropEl.addEventListener('dragover',  e => { e.preventDefault(); dropEl.classList.add('dragover'); });
    dropEl.addEventListener('dragleave', ()=> dropEl.classList.remove('dragover'));
    dropEl.addEventListener('drop', e => {
        e.preventDefault(); dropEl.classList.remove('dragover');
        newFiles = [...newFiles, ...Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'))];
        renderPreviews();
        if (newFiles.length) uploadNewPhotos();
    });
}

function uploadNewPhotos() {
    const fd = new FormData();
    fd.append('_token', '{{ csrf_token() }}');
    newFiles.forEach(f => fd.append('images[]', f));
    fetch('{{ route("admin.properties.houses.images.upload", $house->id) }}', {
        method: 'POST', body: fd
    }).then(r => { if (r.ok) window.location.reload(); })
      .catch(() => alert('Upload failed. Please try again.'));
}

/* Attach new_images[] to main form on submit */
const mainForm = document.getElementById('house-edit-form');
if (mainForm) {
    mainForm.addEventListener('submit', () => {
        if (newFiles.length && photoInput) {
            const dt = new DataTransfer();
            newFiles.forEach(f => dt.items.add(f));
            photoInput.files = dt.files;
        }
    });
}
</script>

@endsection