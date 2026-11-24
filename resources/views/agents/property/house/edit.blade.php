@extends('layouts.agents')
@section('title', 'Edit house')

@section('content')
@php
    $types = ['house' => 'House', 'apartment' => 'Apartment', 'villa' => 'Villa', 'townhouse' => 'Townhouse', 'bungalow' => 'Bungalow', 'duplex' => 'Duplex', 'studio' => 'Studio', 'short-stay' => 'Short stay'];
    if ($house->type && !array_key_exists($house->type, $types)) {
        $types = [$house->type => ucfirst(str_replace(['_', '-'], ' ', $house->type))] + $types;
    }
    $selectedFacilities = old('facilities', $house->facilities->pluck('id')->all());
    // Numbers come back from decimal columns as "500000000.00"; show them without trailing zeros.
    $v = fn ($field, $default = null) => (fn ($x) => is_string($x) && is_numeric($x) && str_contains($x, '.') ? (string) ($x + 0) : $x)(old($field, $house->{$field} ?? $default));
@endphp

<div class="tp-page-head">
    <div>
        <nav class="breadcrumb mb-2">
            <a class="breadcrumb-item" href="{{ route('agent.properties.houses.index') }}">My houses</a>
            <a class="breadcrumb-item" href="{{ route('agent.properties.houses.show', $house->id) }}">{{ \Illuminate\Support\Str::limit($house->title, 32) }}</a>
            <span class="breadcrumb-item active">Edit</span>
        </nav>
        <h1>Edit house</h1>
        <p>
            <span class="tu-badge {{ $house->is_approved ? 'tu-badge-success' : 'tu-badge-warn' }}">{{ $house->is_approved ? 'Live on Terra' : 'Pending review' }}</span>
            <span class="ms-2">Changing the title or price of a live listing sends it back for a quick review.</span>
        </p>
    </div>
    <div class="d-flex gap-2">
        @if ($house->is_approved)
            <a href="{{ route('front.buy.home.details', $house) }}" target="_blank" rel="noopener" class="tu-btn tu-btn-sm"><x-tu-icon name="external" size="15" /> View live</a>
        @endif
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">Please check the highlighted fields — {{ $errors->count() }} {{ \Illuminate\Support\Str::plural('issue', $errors->count()) }} found.</div>
@endif

<form method="POST" action="{{ route('agent.properties.houses.update', $house->id) }}" enctype="multipart/form-data" id="editForm" novalidate>
    @csrf
    @method('PUT')

    <div class="row g-3">
        <div class="col-xl-8">
            {{-- Basics --}}
            <div class="card mb-3">
                <div class="card-header">Basics</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $v('title') }}" maxlength="255" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <span class="form-label d-block">Property type <span class="text-danger">*</span></span>
                        <div class="tp-seg">
                            @foreach ($types as $val => $label)
                                <input type="radio" name="type" id="type_{{ $val }}" value="{{ $val }}" @checked($v('type') === $val) required>
                                <label for="type_{{ $val }}">{{ $label }}</label>
                            @endforeach
                        </div>
                        @error('type')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <span class="form-label d-block">Listing <span class="text-danger">*</span></span>
                            <div class="tp-seg">
                                <input type="radio" name="condition" id="cond_sale" value="for_sale" @checked($v('condition', 'for_sale') === 'for_sale')>
                                <label for="cond_sale">For sale</label>
                                <input type="radio" name="condition" id="cond_rent" value="for_rent" @checked($v('condition') === 'for_rent')>
                                <label for="cond_rent">For rent</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="status">Availability <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach (['available' => 'Available', 'reserved' => 'Reserved', 'sold' => 'Sold', 'rented' => 'Rented'] as $val => $label)
                                    <option value="{{ $val }}" @selected($v('status', 'available') === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="upi">UPI <span class="text-muted fw-normal">(optional)</span></label>
                            <input type="text" id="upi" name="upi" class="form-control @error('upi') is-invalid @enderror" value="{{ $v('upi') }}" placeholder="e.g. 1/02/03/04/1234">
                            @error('upi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="area_sqft">Floor area (sqft)</label>
                            <input type="number" id="area_sqft" name="area_sqft" min="1" class="form-control @error('area_sqft') is-invalid @enderror" value="{{ $v('area_sqft') }}">
                            @error('area_sqft')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rooms --}}
            <div class="card mb-3">
                <div class="card-header">Rooms</div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach (['bedrooms' => ['Bedrooms', 'bed'], 'bathrooms' => ['Bathrooms', 'bath'], 'garages' => ['Parking spaces', 'car']] as $field => [$label, $icon])
                            <div class="col-md-4">
                                <label class="form-label" for="{{ $field }}">{{ $label }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-light" data-step="-1" data-target="{{ $field }}" aria-label="Decrease {{ $label }}">−</button>
                                    <input type="number" id="{{ $field }}" name="{{ $field }}" min="0" max="50" class="form-control text-center @error($field) is-invalid @enderror" value="{{ $v($field, 0) }}" required>
                                    <button type="button" class="btn btn-light" data-step="1" data-target="{{ $field }}" aria-label="Increase {{ $label }}">+</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between"><span>Description</span><span class="text-muted small fw-normal" id="descCount"></span></div>
                <div class="card-body">
                    <textarea id="description" name="description" rows="7" class="form-control @error('description') is-invalid @enderror" required
                        placeholder="Describe the home: layout, finishes, neighbourhood, what's nearby…">{{ $v('description') }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            @include('includes.panel.photo-manager', [
                'images' => $house->images,
                'dir' => 'image/houses',
                'downloadUrl' => route('agent.properties.houses.images.download', $house->id),
            ])

            {{-- Location --}}
            <div class="card mb-3">
                <div class="card-header">Location</div>
                <div class="card-body">
                    @include('includes.panel.location-picker', [
                        'value' => $house->only(['province', 'district', 'sector', 'cell', 'village']),
                        'required' => ['province', 'cell', 'village'],
                    ])
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label class="form-label" for="latitude">Latitude</label>
                            <input type="number" step="any" id="latitude" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ $v('latitude') }}" placeholder="-1.9441">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="longitude">Longitude</label>
                            <input type="number" step="any" id="longitude" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ $v('longitude') }}" placeholder="30.0619">
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-light mt-3" id="useMyLocation"><x-tu-icon name="pin" size="15" /> Use my current location</button>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            {{-- Price --}}
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

            {{-- Amenities --}}
            <div class="card mb-3">
                <div class="card-header">Amenities</div>
                <div class="card-body">
                    @forelse ($facilities as $facility)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="facilities[]" value="{{ $facility->id }}" id="fac_{{ $facility->id }}" @checked(in_array($facility->id, $selectedFacilities))>
                            <label class="form-check-label" for="fac_{{ $facility->id }}">{{ $facility->name }}</label>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No amenities have been set up yet.</p>
                    @endforelse
                </div>
            </div>

            {{-- Video --}}
            <div class="card mb-3">
                <div class="card-header">Video tour</div>
                <div class="card-body">
                    <input type="url" name="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ $v('video_url') }}" placeholder="https://youtube.com/watch?v=…">
                    @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">YouTube, Vimeo or a direct MP4 link.</div>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="card tp-danger-zone">
                <div class="card-header">Delete listing</div>
                <div class="card-body">
                    <p class="small text-muted">Removes the house and all its photos from Terra. This can't be undone.</p>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-delete-listing>Delete this house</button>
                </div>
            </div>
        </div>
    </div>

    <div class="tp-savebar" id="saveBar">
        <span class="tp-dirty">You have unsaved changes</span>
        <div class="d-flex gap-2 ms-auto">
            <a href="{{ route('agent.properties.houses.show', $house->id) }}" class="btn btn-light">Cancel</a>
            <button type="submit" class="btn btn-primary" id="saveBtn">Save changes</button>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('agent.properties.houses.destroy', $house->id) }}" id="deleteListingForm" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@include('agents.property.partials.edit-scripts')
