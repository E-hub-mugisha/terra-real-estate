@extends('layouts.agents')
@section('title', 'Edit land')

@section('content')
@php
    $zonings = ['R1' => 'R1 · Low density', 'R2' => 'R2 · Medium', 'R3' => 'R3 · High', 'R4' => 'R4 · Very high', 'Commercial' => 'Commercial', 'Industrial' => 'Industrial', 'Agricultural' => 'Agricultural'];
    $landUses = ['Residential', 'Commercial', 'Industrial', 'Agricultural', 'Mixed-use', 'Institutional', 'Recreational', 'Conservation', 'Transportation'];
    if ($land->land_use && !in_array($land->land_use, $landUses)) array_unshift($landUses, $land->land_use);
    // Numbers come back from decimal columns as "500000000.00"; show them without trailing zeros.
    $v = fn ($field, $default = null) => (fn ($x) => is_string($x) && is_numeric($x) && str_contains($x, '.') ? (string) ($x + 0) : $x)(old($field, $land->{$field} ?? $default));
@endphp

<div class="tp-page-head">
    <div>
        <nav class="breadcrumb mb-2">
            <a class="breadcrumb-item" href="{{ route('agent.properties.land.index') }}">My land</a>
            <a class="breadcrumb-item" href="{{ route('agent.properties.lands.show', $land->id) }}">{{ \Illuminate\Support\Str::limit($land->title, 32) }}</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
        <h1>Edit land</h1>
        <p>
            <span class="tu-badge {{ $land->is_approved ? 'tu-badge-success' : 'tu-badge-warn' }}">{{ $land->is_approved ? 'Live on Terra' : 'Pending review' }}</span>
            <span class="ms-2">Changing the title or price of a live listing sends it back for a quick review.</span>
        </p>
    </div>
    @if ($land->is_approved)
        <a href="{{ route('front.buy.land.details', $land) }}" target="_blank" rel="noopener" class="tu-btn tu-btn-sm"><x-tu-icon name="external" size="15" /> View live</a>
    @endif
</div>

@if ($errors->any())
    <div class="alert alert-danger">Please check the highlighted fields — {{ $errors->count() }} {{ \Illuminate\Support\Str::plural('issue', $errors->count()) }} found.</div>
@endif

<form method="POST" action="{{ route('agent.properties.lands.update', $land->id) }}" enctype="multipart/form-data" id="editForm" novalidate>
    @csrf
    @method('PUT')

    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card mb-3">
                <div class="card-header">Basics</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $v('title') }}" maxlength="255" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <span class="form-label d-block">Listing <span class="text-danger">*</span></span>
                            <div class="tp-seg">
                                <input type="radio" name="condition" id="cond_sale" value="for_sale" @checked($v('condition', 'for_sale') === 'for_sale')>
                                <label for="cond_sale">For sale</label>
                                <input type="radio" name="condition" id="cond_rent" value="for_rent" @checked($v('condition') === 'for_rent')>
                                <label for="cond_rent">For rent / lease</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="status">Availability <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select">
                                @foreach (['available' => 'Available', 'reserved' => 'Reserved', 'sold' => 'Sold', 'rented' => 'Leased'] as $val => $label)
                                    <option value="{{ $val }}" @selected($v('status', 'available') === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="size_sqm">Plot size (m²) <span class="text-danger">*</span></label>
                            <input type="number" id="size_sqm" name="size_sqm" min="1" step="any" class="form-control @error('size_sqm') is-invalid @enderror" value="{{ $v('size_sqm') }}" required>
                            @error('size_sqm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="upi">UPI <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" id="upi" name="upi" class="form-control @error('upi') is-invalid @enderror" value="{{ $v('upi') }}" placeholder="e.g. 1/02/03/04/1234">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Zoning &amp; use</div>
                <div class="card-body">
                    <span class="form-label d-block">Zoning <span class="text-danger">*</span></span>
                    <div class="tp-seg mb-3">
                        @foreach ($zonings as $val => $label)
                            <input type="radio" name="zoning" id="zone_{{ $val }}" value="{{ $val }}" @checked($v('zoning', 'R1') === $val) required>
                            <label for="zone_{{ $val }}">{{ $label }}</label>
                        @endforeach
                    </div>
                    @error('zoning')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                    <label class="form-label" for="land_use">Land use</label>
                    <select id="land_use" name="land_use" class="form-select">
                        <option value="">Not specified</option>
                        @foreach ($landUses as $use)
                            <option value="{{ $use }}" @selected($v('land_use') === $use)>{{ $use }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between"><span>Description</span><span class="text-muted small fw-normal" id="descCount"></span></div>
                <div class="card-body">
                    <textarea id="description" name="description" rows="6" class="form-control @error('description') is-invalid @enderror"
                        placeholder="Access road, utilities, slope, views, title status…">{{ $v('description') }}</textarea>
                </div>
            </div>

            @include('includes.panel.photo-manager', [
                'images' => $land->images,
                'dir' => 'image/lands',
                'downloadUrl' => route('agent.properties.lands.images.download', $land->id),
            ])

            <div class="card mb-3">
                <div class="card-header">Location</div>
                <div class="card-body">
                    @include('includes.panel.location-picker', [
                        'value' => $land->only(['province', 'district', 'sector', 'cell', 'village']),
                        'required' => ['province', 'district', 'sector', 'cell'],
                    ])
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label" for="latitude">Latitude</label>
                            <input type="number" step="any" id="latitude" name="latitude" class="form-control" value="{{ $v('latitude') }}" placeholder="-1.9441">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="longitude">Longitude</label>
                            <input type="number" step="any" id="longitude" name="longitude" class="form-control" value="{{ $v('longitude') }}" placeholder="30.0619">
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-light mt-3" id="useMyLocation"><x-tu-icon name="pin" size="15" /> Use my current location</button>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card mb-3">
                <div class="card-header">Price</div>
                <div class="card-body">
                    <label class="form-label" for="price">Price <span class="text-danger">*</span></label>
                    <div class="input-group mb-3">
                        <input type="number" id="price" name="price" min="0" step="1" class="form-control @error('price') is-invalid @enderror" value="{{ $v('price') }}" required>
                        <select name="currency" class="form-select" style="max-width:96px" aria-label="Currency">
                            @foreach (['RWF', 'USD'] as $cur)
                                <option value="{{ $cur }}" @selected($v('currency', 'RWF') === $cur)>{{ $cur }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="small text-muted mb-3" id="pricePreview"></div>
                    <div class="tp-seg">
                        <input type="radio" name="negotiable" id="neg_yes" value="negotiable" @checked($v('negotiable', 'negotiable') === 'negotiable')>
                        <label for="neg_yes">Negotiable</label>
                        <input type="radio" name="negotiable" id="neg_no" value="non_negotiable" @checked($v('negotiable') === 'non_negotiable')>
                        <label for="neg_no">Fixed price</label>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">Video tour</div>
                <div class="card-body">
                    <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ $v('video_url') }}" placeholder="https://youtube.com/watch?v=…">
                    @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">A drone or walk-through video helps buyers a lot.</div>
                </div>
            </div>

            <div class="card tp-danger-zone">
                <div class="card-header">Delete listing</div>
                <div class="card-body">
                    <p class="small text-muted">Removes the plot and all its photos from Terra. This can't be undone.</p>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-delete-listing>Delete this plot</button>
                </div>
            </div>
        </div>
    </div>

    <div class="tp-savebar" id="saveBar">
        <span class="tp-dirty">You have unsaved changes</span>
        <div class="d-flex gap-2 ms-auto">
            <a href="{{ route('agent.properties.lands.show', $land->id) }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save changes</button>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('agent.properties.lands.destroy', $land->id) }}" id="deleteListingForm" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@include('agents.property.partials.edit-scripts')
