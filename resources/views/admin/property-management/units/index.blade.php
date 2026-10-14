@extends('layouts.property-management.app')

@section('title', 'Units')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Units</h1>
            <p class="text-muted mb-0">Manage rental units across your managed properties.</p>
        </div>

        <a href="{{ route('admin.property-management.units.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Add Unit
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.property-management.units.index') }}"
                  class="row g-3">
                <div class="col-md-5">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search"
                           class="form-control"
                           placeholder="Unit number or property name"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
                    <label for="managed_property_id" class="form-label">Property</label>
                    <select name="managed_property_id" id="managed_property_id"
                            class="form-select">
                        <option value="">All properties</option>
                        @foreach ($properties as $property)
                            <option value="{{ $property->id }}"
                                @selected(request('managed_property_id') == $property->id)>
                                {{ $property->name }} ({{ $property->property_code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All statuses</option>
                        @foreach (['available', 'reserved', 'occupied', 'maintenance', 'unavailable'] as $status)
                            <option value="{{ $status }}"
                                @selected(request('status') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-dark" type="submit">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.property-management.units.index') }}"
                       class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Unit</th>
                            <th>Property</th>
                            <th>Building / Floor</th>
                            <th>Monthly Rent</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $unit)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">{{ $unit->unit_number }}</div>
                                    <small class="text-muted">
                                        {{ ucwords(str_replace('_', ' ', $unit->unit_type)) }}
                                    </small>
                                </td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $unit->managedProperty->name ?? '—' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $unit->managedProperty->property_code ?? '' }}
                                    </small>
                                </td>
                                <td>
                                    {{ $unit->building->name ?? 'Standalone' }}
                                    @if ($unit->floor)
                                        <div class="small text-muted">
                                            {{ $unit->floor->name }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    {{ $unit->currency }}
                                    {{ number_format((float) $unit->monthly_rent, 2) }}
                                </td>
                                <td>
                                    @php
                                        $statusClass = match ($unit->status) {
                                            'available' => 'success',
                                            'occupied' => 'primary',
                                            'reserved' => 'warning',
                                            'maintenance' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge text-bg-{{ $statusClass }}">
                                        {{ ucfirst($unit->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.property-management.units.show', $unit) }}"
                                       class="btn btn-sm btn-outline-dark">View</a>
                                    <a href="{{ route('admin.property-management.units.edit', $unit) }}"
                                       class="btn btn-sm btn-outline-primary">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    No units found. Add your first unit to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($units->hasPages())
            <div class="card-footer bg-white">
                {{ $units->links() }}
            </div>
        @endif
    </div>
</div>
@endsection