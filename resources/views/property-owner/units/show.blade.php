@extends('layouts.propertyOwner.app')

@section('title', 'Unit Details')

@section('content')
    <a href="{{ route('property-owner.units.index', [$property, $building]) }}">
        &larr; Back to Units
    </a>

    <div class="d-flex justify-content-between align-items-start gap-3 mt-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Unit {{ $unit->unit_number }}</h2>
            <p class="text-muted mb-0">{{ $property->name }} / {{ $building->name }}</p>
        </div>

        <a href="{{ route('property-owner.units.edit', [$property, $building, $unit]) }}"
           class="btn btn-terra">Edit Unit</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="text-muted small">Unit Type</div>
                    <strong>{{ ucfirst($unit->unit_type ?? 'Not specified') }}</strong>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Floor</div>
                    <strong>{{ $unit->floor->name ?? 'Floor ' . ($unit->floor->floor_number ?? '—') }}</strong>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Monthly Rent</div>
                    <strong>RWF {{ number_format((float) $unit->rent, 2) }}</strong>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Deposit</div>
                    <strong>RWF {{ number_format((float) ($unit->deposit ?? 0), 2) }}</strong>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Size</div>
                    <strong>{{ $unit->size !== null ? $unit->size . ' m²' : 'Not specified' }}</strong>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Availability</div>
                    <strong>{{ ucfirst($unit->availability) }}</strong>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Bedrooms</div>
                    <strong>{{ $unit->bedrooms ?? 0 }}</strong>
                </div>
                <div class="col-md-6">
                    <div class="text-muted small">Bathrooms</div>
                    <strong>{{ $unit->bathrooms ?? 0 }}</strong>
                </div>
                <div class="col-12">
                    <div class="text-muted small">Description</div>
                    <p class="mb-0">{{ $unit->description ?: 'No description provided.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection