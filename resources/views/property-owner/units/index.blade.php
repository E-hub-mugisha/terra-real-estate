@extends('layouts.propertyOwner.app')

@section('title', 'Rental Units')

@section('content')
    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('property-owner.buildings.show', [$property, $building]) }}">
                &larr; Back to Building
            </a>
            <h2 class="fw-bold mt-2 mb-1">Rental Units</h2>
            <p class="text-muted mb-0">{{ $property->name }} / {{ $building->name }}</p>
        </div>

        <a href="{{ route('property-owner.units.create', [$property, $building]) }}"
           class="btn btn-terra">Add Unit</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Unit</th>
                        <th>Floor</th>
                        <th>Type</th>
                        <th>Monthly Rent</th>
                        <th>Availability</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units as $unit)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $unit->unit_number }}</td>
                            <td>{{ $unit->floor->name ?? 'Floor ' . ($unit->floor->floor_number ?? '—') }}</td>
                            <td>{{ ucfirst($unit->unit_type ?? 'Unit') }}</td>
                            <td>RWF {{ number_format((float) $unit->rent, 0) }}</td>
                            <td>
                                <span class="badge {{ $unit->availability === 'available' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($unit->availability) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('property-owner.units.show', [$property, $building, $unit]) }}"
                                   class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('property-owner.units.edit', [$property, $building, $unit]) }}"
                                   class="btn btn-sm btn-outline-secondary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No units have been added to this building yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $units->links() }}
        </div>
    </div>
@endsection