@extends('layouts.propertyOwner.app')

@section('title', 'Floor Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <a
                href="{{ route('property-owner.floors.index', [$property, $building]) }}"
                class="text-decoration-none"
            >
                <i class="bi bi-arrow-left"></i> Back to Floors
            </a>

            <h2 class="mt-3 mb-1">
                {{ $floor->name ?: 'Floor '.$floor->floor_number }}
            </h2>

            <p class="text-muted mb-0">
                {{ $property->name }} / {{ $building->name }}
            </p>
        </div>

        <a
            href="{{ route('property-owner.floors.edit', [$property, $building, $floor]) }}"
            class="btn btn-terra"
        >
            <i class="bi bi-pencil"></i> Edit Floor
        </a>
    </div>

    <a 
        href="{{ route('property-owner.units.index', [$property, $building]) }}"
        class="btn btn-outline-primary mb-4"
    >
        <i class="bi bi-list"></i> View All Units
    </a>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Floor Number</p>
                    <h3>{{ $floor->floor_number }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Units</p>
                    <h3>{{ $floor->units->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-1">Building</p>
                    <h5>{{ $building->name }}</h5>
                </div>
            </div>
        </div>
    </div>

    @if ($floor->description)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5>Description</h5>
                <p class="mb-0">{{ $floor->description }}</p>
            </div>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Units on This Floor</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Unit Number</th>
                            <th>Unit Type</th>
                            <th>Rent (RWF)</th>
                            <th>Availability</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($floor->units as $unit)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $unit->unit_number }}
                                </td>

                                <td>{{ ucfirst(str_replace('_', ' ', $unit->unit_type ?? 'N/A')) }}</td>

                                <td>
                                    {{ number_format((float) $unit->rent) }}
                                </td>

                                <td>
                                    {{ ucfirst($unit->availability ?? 'N/A') }}
                                </td>

                                <td class="text-end">
                                    <a
                                        href="{{ route('property-owner.units.show', [$property, $building, $unit]) }}"
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        View Unit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <p class="text-muted mb-0">
                                        No units have been added to this floor yet.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection