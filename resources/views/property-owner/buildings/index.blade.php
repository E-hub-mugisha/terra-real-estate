@extends('layouts.propertyOwner.app')

@section('title', 'Buildings')

@section('content')
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('property-owner.properties.show', $property) }}">
                &larr; Back to Property
            </a>
            <h2 class="fw-bold mt-2 mb-1">Buildings</h2>
            <p class="text-muted mb-0">{{ $property->name }}</p>
        </div>

        <a href="{{ route('property-owner.buildings.create', $property) }}"
           class="btn btn-terra">Add Building</a>
    </div>

    @forelse($buildings as $building)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1">{{ $building->name }}</h5>
                    <div class="text-muted small">
                        Code: {{ $building->building_code }}
                        &middot; Floors: {{ $building->number_of_floors }}
                        &middot; Recorded floors: {{ $building->floors_count }}
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('property-owner.buildings.edit', [$property, $building]) }}"
                       class="btn btn-outline-secondary btn-sm">Edit</a>

                    <a href="{{ route('property-owner.buildings.show', [$property, $building]) }}"
                       class="btn btn-terra btn-sm">Manage Building</a>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h5>No buildings yet</h5>
                <p class="text-muted">Create a building to start organizing floors and rental units.</p>
                <a href="{{ route('property-owner.buildings.create', $property) }}"
                   class="btn btn-terra">Add First Building</a>
            </div>
        </div>
    @endforelse

    {{ $buildings->links() }}
@endsection