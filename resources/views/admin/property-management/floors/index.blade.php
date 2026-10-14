@extends('layouts.property-management.app')

@section('title', 'Floors')
@section('breadcrumb', 'Property Management / Floors')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Floors</h4>
            <p class="text-muted mb-0">Manage floors within registered buildings.</p>
        </div>

        <a href="{{ route('admin.property-management.floors.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Floor
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.property-management.floors.index') }}"
                  class="row g-2 mb-4">

                <div class="col-md-5">
                    <input type="search"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Search floor or building">
                </div>

                <div class="col-md-4">
                    <select name="building_id" class="form-select">
                        <option value="">All buildings</option>
                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}"
                                @selected((string) request('building_id') === (string) $building->id)>
                                {{ $building->name }}
                                — {{ $building->managedProperty?->name ?? 'No property' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.property-management.floors.index') }}"
                       class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Floor</th>
                            <th>Building</th>
                            <th>Managed Property</th>
                            <th>Floor Number</th>
                            <th>Units</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($floors as $floor)
                        <tr>
                            <td class="fw-semibold">{{ $floor->name }}</td>

                            <td>
                                {{ $floor->building?->name ?? '—' }}
                                <div class="small text-muted">
                                    {{ $floor->building?->building_code ?? '' }}
                                </div>
                            </td>

                            <td>{{ $floor->building?->managedProperty?->name ?? '—' }}</td>

                            <td>{{ $floor->floor_number }}</td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $floor->units_count }}
                                </span>
                            </td>

                            <td class="text-end">
                                <a href="{{ route('admin.property-management.floors.show', $floor) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.property-management.floors.edit', $floor) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-layers fs-2 text-muted"></i>
                                <h6 class="mt-3">No floors found</h6>
                                <p class="text-muted mb-0">
                                    Create a floor under an existing building.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $floors->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection