@extends('layouts.property-management.app')

@section('title', 'Managed Properties')
@section('breadcrumb', 'Property Management / Properties')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Managed Properties</h4>
            <p class="text-muted mb-0">
                Manage properties registered under verified and existing owners.
            </p>
        </div>

        <a href="{{ route('admin.property-management.properties.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i> Add Property
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.property-management.properties.index') }}"
                  class="row g-2 mb-4">

                <div class="col-md-5">
                    <input type="search"
                           name="search"
                           class="form-control"
                           placeholder="Search property name or code..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="management_status" class="form-select">
                        <option value="">All statuses</option>
                        <option value="active"
                            @selected(request('management_status') === 'active')>
                            Active
                        </option>
                        <option value="inactive"
                            @selected(request('management_status') === 'inactive')>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search me-1"></i> Search
                    </button>

                    <a href="{{ route('admin.property-management.properties.index') }}"
                       class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Property</th>
                            <th>Owner</th>
                            <th>Location</th>
                            <th>Units</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($properties as $property)
                        <tr>
                            <td>
                                <div class="fw-semibold">
                                    {{ $property->name }}
                                </div>
                                <small class="text-muted">
                                    {{ $property->property_code }}
                                </small>
                            </td>

                            <td>
                                <div>
                                    {{ $property->owner?->user?->name ?? 'Unknown owner' }}
                                </div>
                                <small class="text-muted">
                                    {{ $property->owner?->user?->email ?? '—' }}
                                </small>
                            </td>

                            <td>
                                {{ collect([
                                    $property->district,
                                    $property->province
                                ])->filter()->implode(', ') ?: ($property->address ?: '—') }}
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $property->units_count ?? 0 }}
                                </span>
                            </td>

                            <td>
                                @if($property->management_status === 'active')
                                    <span class="badge bg-success-subtle text-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="{{ route('admin.property-management.properties.show', $property) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="View property">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.property-management.properties.edit', $property) }}"
                                       class="btn btn-sm btn-outline-secondary"
                                       title="Edit property">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-buildings fs-2 text-muted"></i>
                                <h6 class="mt-3">No managed properties found</h6>
                                <p class="text-muted mb-3">
                                    Register a property to begin managing its buildings and units.
                                </p>
                                <a href="{{ route('admin.property-management.properties.create') }}"
                                   class="btn btn-primary btn-sm">
                                    Add Property
                                </a>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $properties->withQueryString()->links() }}
            </div>

        </div>
    </div>
</div>
@endsection