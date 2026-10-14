@extends('layouts.property-management.app')

@section('title', 'Floor Details')
@section('breadcrumb', 'Property Management / Floors / Details')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.floors.index') }}"
               class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Back to Floors
            </a>

            <h4 class="fw-bold mt-2 mb-1">{{ $floor->name }}</h4>

            <p class="text-muted mb-0">
                Floor number: {{ $floor->floor_number }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.property-management.floors.edit', $floor) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Floor
            </a>

            <form action="{{ route('admin.property-management.floors.destroy', $floor) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this floor? This action cannot be undone.')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Floor Information</h6>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small">Floor Name</div>
                        <div class="fw-semibold">{{ $floor->name }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Floor Number</div>
                        <div>{{ $floor->floor_number }}</div>
                    </div>

                    <div>
                        <div class="text-muted small">Description</div>
                        <div>{{ $floor->description ?: 'No description provided.' }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Building & Property</h6>
                </div>

                <div class="card-body">
                    <div class="text-muted small">Building</div>

                    <div class="fw-semibold mb-3">
                        {{ $floor->building?->name ?? '—' }}
                    </div>

                    <div class="text-muted small">Managed Property</div>

                    <div class="fw-semibold mb-3">
                        {{ $floor->building?->managedProperty?->name ?? '—' }}
                    </div>

                    <div class="text-muted small">Property Owner</div>

                    <div class="fw-semibold mb-3">
                        {{ $floor->building?->managedProperty?->owner?->user?->name ?? '—' }}
                    </div>

                    @if($floor->building)
                        <a href="{{ route('admin.property-management.buildings.show', $floor->building) }}"
                           class="btn btn-outline-primary btn-sm">
                            View Building
                        </a>
                    @endif

                    @if($floor->building?->managedProperty)
                        <a href="{{ route('admin.property-management.properties.show', $floor->building->managedProperty) }}"
                           class="btn btn-outline-secondary btn-sm mt-2">
                            View Property
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Units on This Floor</h6>

                    <span class="badge bg-light text-dark border">
                        {{ $floor->units->count() }} units
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Unit Number</th>
                                    <th>Unit Type</th>
                                    <th>Monthly Rent</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                            @forelse($floor->units as $unit)
                                <tr>
                                    <td class="fw-semibold">{{ $unit->unit_number }}</td>

                                    <td>
                                        {{ ucwords(str_replace('_', ' ', $unit->unit_type)) }}
                                    </td>

                                    <td>
                                        {{ number_format((float) $unit->monthly_rent, 0) }}
                                        {{ $unit->currency ?? 'RWF' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ ucfirst($unit->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        No units are registered on this floor yet.
                                        You can add them in the Units module.
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