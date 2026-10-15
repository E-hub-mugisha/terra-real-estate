@extends('layouts.propertyOwner.app')

@section('title', 'Manage Floors')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <a
                href="{{ route('property-owner.buildings.show', [$property, $building]) }}"
                class="text-decoration-none"
            >
                <i class="bi bi-arrow-left"></i> Back to Building
            </a>

            <h2 class="mt-3 mb-1">Floors</h2>

            <p class="text-muted mb-0">
                {{ $property->name }} / {{ $building->name }}
            </p>
        </div>

        <a
            href="{{ route('property-owner.floors.create', [$property, $building]) }}"
            class="btn btn-terra"
        >
            <i class="bi bi-plus-lg"></i> Add Floor
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Floor</th>
                            <th>Floor Name</th>
                            <th>Units</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($floors as $floor)
                            <tr>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $floor->floor_number }}
                                    </span>
                                </td>

                                <td>
                                    {{ $floor->name ?: 'Floor '.$floor->floor_number }}
                                </td>

                                <td>{{ $floor->units_count }}</td>

                                <td class="text-end">
                                    <a
                                        href="{{ route('property-owner.floors.show', [$property, $building, $floor]) }}"
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('property-owner.floors.edit', [$property, $building, $floor]) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('property-owner.floors.destroy', [$property, $building, $floor]) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Delete this floor? This action cannot be undone.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            @disabled($floor->units_count > 0)
                                            title="{{ $floor->units_count > 0 ? 'Remove its units before deleting' : 'Delete floor' }}"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <h5>No floors yet</h5>
                                    <p class="text-muted">
                                        Create floors before adding units to this building.
                                    </p>

                                    <a
                                        href="{{ route('property-owner.floors.create', [$property, $building]) }}"
                                        class="btn btn-terra"
                                    >
                                        Add First Floor
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($floors->hasPages())
            <div class="card-footer bg-white">
                {{ $floors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection