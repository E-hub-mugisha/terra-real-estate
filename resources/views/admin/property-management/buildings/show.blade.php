@extends('layouts.property-management.app')

@section('title', 'Building Details')
@section('breadcrumb', 'Property Management / Buildings / Details')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.buildings.index') }}"
               class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Back to Buildings
            </a>

            <h4 class="fw-bold mt-2 mb-1">{{ $building->name }}</h4>
            <p class="text-muted mb-0">
                {{ $building->building_code ?: 'No building code assigned' }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.property-management.buildings.edit', $building) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>

            <form action="{{ route('admin.property-management.buildings.destroy', $building) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this building? This action cannot be undone.')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Building Information</h6>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small">Building Name</div>
                        <div class="fw-semibold">{{ $building->name }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Building Code</div>
                        <div>{{ $building->building_code ?: '—' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Expected Number of Floors</div>
                        <div>{{ $building->number_of_floors ?? '—' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Status</div>
                        @if($building->is_active)
                            <span class="badge bg-success-subtle text-success">Active</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                        @endif
                    </div>

                    <div>
                        <div class="text-muted small">Description</div>
                        <div>{{ $building->description ?: 'No description provided.' }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Managed Property</h6>
                </div>

                <div class="card-body">
                    @if($building->managedProperty)
                        <div class="fw-semibold">
                            {{ $building->managedProperty->name }}
                        </div>

                        <div class="text-muted small mb-3">
                            {{ $building->managedProperty->property_code }}
                        </div>

                        <div class="mb-3">
                            <div class="text-muted small">Property Owner</div>
                            {{ $building->managedProperty->owner?->user?->name ?? '—' }}
                        </div>

                        <a href="{{ route('admin.property-management.properties.show', $building->managedProperty) }}"
                           class="btn btn-outline-primary btn-sm">
                            View Managed Property
                        </a>
                    @else
                        <p class="text-muted mb-0">No managed property is associated with this building.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Floors</h6>
                    <span class="badge bg-light text-dark border">
                        {{ $building->floors->count() }} floors
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Floor</th>
                                    <th>Floor Number</th>
                                    <th>Units</th>
                                </tr>
                            </thead>

                            <tbody>
                            @forelse($building->floors as $floor)
                                <tr>
                                    <td class="fw-semibold">{{ $floor->name }}</td>
                                    <td>{{ $floor->floor_number }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $floor->units->count() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-5">
                                        No floors registered yet. The Floors module will allow you
                                        to add floors to this building.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection