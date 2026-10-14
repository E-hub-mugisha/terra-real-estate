@extends('layouts.property-management.app')

@section('title', 'Buildings')
@section('breadcrumb', 'Property Management / Buildings')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Buildings</h4>
            <p class="text-muted mb-0">Manage buildings within registered properties.</p>
        </div>

        <a href="{{ route('admin.property-management.buildings.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Building
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.property-management.buildings.index') }}"
                  class="row g-2 mb-4">

                <div class="col-md-4">
                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search building name or code">
                </div>

                <div class="col-md-5">
                    <select name="managed_property_id" class="form-select">
                        <option value="">All properties</option>
                        @foreach($properties as $property)
                            <option value="{{ $property->id }}"
                                @selected((string) request('managed_property_id') === (string) $property->id)>
                                {{ $property->name }} ({{ $property->property_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.property-management.buildings.index') }}"
                       class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Building</th>
                            <th>Managed Property</th>
                            <th>Owner</th>
                            <th>Floors</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($buildings as $building)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $building->name }}</div>
                                <small class="text-muted">
                                    {{ $building->building_code ?: 'No code assigned' }}
                                </small>
                            </td>

                            <td>
                                @if($building->managedProperty)
                                    <a class="text-decoration-none"
                                       href="{{ route('admin.property-management.properties.show', $building->managedProperty) }}">
                                        {{ $building->managedProperty->name }}
                                    </a>
                                    <div class="small text-muted">
                                        {{ $building->managedProperty->property_code }}
                                    </div>
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                {{ $building->managedProperty?->owner?->user?->name ?? '—' }}
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $building->floors_count ?? 0 }}
                                </span>
                            </td>

                            <td>
                                @if($building->is_active)
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Inactive</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('admin.property-management.buildings.show', $building) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.property-management.buildings.edit', $building) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-building fs-2 text-muted"></i>
                                <h6 class="mt-3">No buildings found</h6>
                                <p class="text-muted">Create a building under a managed property.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $buildings->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection