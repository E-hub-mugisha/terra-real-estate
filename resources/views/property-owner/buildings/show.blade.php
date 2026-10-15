@extends('layouts.propertyOwner.app')

@section('title', 'Building Details')

@section('content')
    <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('property-owner.buildings.index', $property) }}">
                &larr; Back to Buildings
            </a>
            <h2 class="fw-bold mt-3 mb-1">{{ $building->name }}</h2>
            <p class="text-muted mb-0">
                {{ $property->name }} &middot; {{ $building->building_code }}
            </p>
        </div>

        <a href="{{ route('property-owner.buildings.edit', [$property, $building]) }}"
           class="btn btn-terra">Edit Building</a>
    </div>
    <a
    href="{{ route('property-owner.floors.index', [$property, $building]) }}"
    class="btn btn-terra"
>
    <i class="bi bi-layers"></i> Manage Floors
</a>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="text-muted small">Planned Floors</div>
                    <h4>{{ $building->number_of_floors }}</h4>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">Created Floor Records</div>
                    <h4>{{ $building->floors->count() }}</h4>
                </div>
                <div class="col-md-4">
                    <div class="text-muted small">Status</div>
                    <h4>{{ $building->is_active ? 'Active' : 'Inactive' }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Floors and Units</h4>
        <a href="{{ route('property-owner.units.index', [$property, $building]) }}"
           class="btn btn-outline-primary">View All Units</a>
    </div>

    @forelse($building->floors as $floor)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white p-3">
                <strong>{{ $floor->name ?? 'Floor ' . $floor->floor_number }}</strong>
            </div>
            <div class="card-body">
                @forelse($floor->units as $unit)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <strong>{{ $unit->unit_number }}</strong>
                            <span class="text-muted small">
                                &middot; {{ $unit->unit_type ?? 'Rental unit' }}
                            </span>
                        </div>
                        <a href="{{ route('property-owner.units.show', [$property, $building, $unit]) }}"
                           class="btn btn-sm btn-outline-secondary">View</a>
                    </div>
                @empty
                    <p class="text-muted mb-0">No units on this floor yet.</p>
                @endforelse
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            This building has no floor records yet. Create floors using your
            existing floor-management workflow before adding rental units.
        </div>
    @endforelse
@endsection