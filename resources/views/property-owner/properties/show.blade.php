@extends('layouts.propertyOwner.app')

@section('title', 'Property Details')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
        <a href="{{ route('property-owner.properties.index') }}"
           class="text-decoration-none">
            &larr; Back to My Properties
        </a>

        <h2 class="fw-bold mt-3 mb-1">
            {{ $property->name }}
        </h2>

        <p class="text-muted mb-0">
            {{ $property->address ?? 'Address not provided' }}
        </p>
    </div>

    <a href="{{ route('property-owner.properties.edit', $property) }}"
       class="btn btn-terra">
        Edit Property
    </a>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center gap-3">
            <div>
                <h5 class="fw-bold mb-1">Buildings & Rental Units</h5>
                <p class="text-muted small mb-0">
                    Manage buildings, floors, and individual rental units.
                </p>
            </div>

            <a href="{{ route('property-owner.buildings.index', $property) }}"
               class="btn btn-terra">
                Manage Buildings
            </a>
        </div>
    </div>
</div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white p-4">
                    <h5 class="fw-bold mb-0">Property Information</h5>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Property Name</div>
                            <div class="fw-semibold">
                                {{ $property->name ?? $property->title ?? 'Property #' . $property->id }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Status</div>
                            <div class="fw-semibold">
                                {{ ucfirst(str_replace('_', ' ', $property->status ?? 'Not specified')) }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-muted small mb-1">Address</div>
                            <div class="fw-semibold">
                                {{ $property->address ?? 'Not provided' }}
                            </div>
                        </div>

                        @if(isset($property->description))
                            <div class="col-12">
                                <div class="text-muted small mb-1">Description</div>
                                <p class="mb-0">{{ $property->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold">Property Management</h5>
                    <p class="text-muted small">
                        For changes to this property's information, units, or management arrangements,
                        contact your assigned property manager.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection