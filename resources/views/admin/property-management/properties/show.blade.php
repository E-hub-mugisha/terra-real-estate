@extends('layouts.property-management.app')

@section('title', 'Property Details')
@section('breadcrumb', 'Property Management / Properties / Details')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.properties.index') }}"
               class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Back to Properties
            </a>

            <h4 class="fw-bold mt-2 mb-1">{{ $property->name }}</h4>

            <div class="text-muted">
                Property Code: {{ $property->property_code }}
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.property-management.properties.edit', $property) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Property
            </a>

            <form action="{{ route('admin.property-management.properties.destroy', $property) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.')">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Property Type</div>
                    <h5 class="fw-bold mb-0">
                        {{ ucwords(str_replace('_', ' ', $property->property_type)) }}
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Total Units</div>
                    <h5 class="fw-bold mb-0">{{ $property->units->count() }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Management Status</div>

                    @if($property->management_status === 'active')
                        <span class="badge bg-success-subtle text-success fs-6">
                            Active
                        </span>
                    @else
                        <span class="badge bg-secondary-subtle text-secondary fs-6">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- Property information --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Property Information</h6>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small">Property Name</div>
                            <div class="fw-semibold">{{ $property->name }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Property Code</div>
                            <div class="fw-semibold">{{ $property->property_code }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Property Type</div>
                            <div>
                                {{ ucwords(str_replace('_', ' ', $property->property_type)) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">UPI Reference</div>
                            <div>{{ $property->upi_reference ?: '—' }}</div>
                        </div>

                        <div class="col-12">
                            <div class="text-muted small">Description</div>
                            <div>{{ $property->description ?: 'No description provided.' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Location --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Location</h6>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        @foreach([
                            'province' => 'Province',
                            'district' => 'District',
                            'sector' => 'Sector',
                            'cell' => 'Cell',
                            'village' => 'Village',
                        ] as $field => $label)
                            <div class="col-md-4">
                                <div class="text-muted small">{{ $label }}</div>
                                <div>{{ $property->{$field} ?: '—' }}</div>
                            </div>
                        @endforeach

                        <div class="col-12">
                            <div class="text-muted small">Physical Address</div>
                            <div>{{ $property->address ?: '—' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Latitude</div>
                            <div>{{ $property->latitude ?? '—' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small">Longitude</div>
                            <div>{{ $property->longitude ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Units --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0">Units</h6>
                    <span class="badge bg-light text-dark border">
                        {{ $property->units->count() }} units
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Unit</th>
                                    <th>Type</th>
                                    <th>Monthly Rent</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                            @forelse($property->units as $unit)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $unit->unit_number }}
                                    </td>

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
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No units have been registered for this property yet.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Owner details and buildings --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Property Owner</h6>
                </div>

                <div class="card-body">
                    <div class="fw-bold fs-5">
                        {{ $property->owner?->user?->name ?? 'Unknown owner' }}
                    </div>

                    <div class="text-muted mb-3">
                        {{ $property->owner?->user?->email ?? '—' }}
                    </div>

                    <hr>

                    <div class="mb-3">
                        <div class="text-muted small">Phone</div>
                        <div>{{ $property->owner?->phone ?: '—' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small">Owner Type</div>
                        <div>
                            {{ ucfirst($property->owner?->owner_type ?? '—') }}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small">Verification Status</div>
                        <div>
                            {{ ucfirst($property->owner?->verification_status ?? '—') }}
                        </div>
                    </div>

                    <a href="{{ $property->owner
                        ? route('admin.property-management.owners.show', $property->owner)
                        : '#' }}"
                       class="btn btn-outline-primary btn-sm w-100 mt-3"
                       @if(!$property->owner) aria-disabled="true" @endif>
                        View Owner Profile
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0">Buildings</h6>
                </div>

                <div class="card-body">
                    @forelse($property->buildings as $building)
                        <div class="d-flex align-items-start gap-2 mb-3">
                            <i class="bi bi-building text-muted fs-5"></i>

                            <div>
                                <div class="fw-semibold">{{ $building->name }}</div>
                                <small class="text-muted">
                                    {{ $building->building_code ?: 'No building code' }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            No buildings have been added to this property yet.
                        </p>
                    @endforelse
                </div>
            </div>

            @if($property->notes)
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0">Internal Notes</h6>
                    </div>
                    <div class="card-body">
                        {{ $property->notes }}
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection