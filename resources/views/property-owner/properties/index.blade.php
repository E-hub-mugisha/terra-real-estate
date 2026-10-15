@extends('layouts.propertyOwner.app')

@section('title', 'My Properties')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">My Properties</h2>
        <p class="text-muted mb-0">
            Manage the properties associated with your owner account.
        </p>
    </div>

    <a href="{{ route('property-owner.properties.create') }}"
        class="btn btn-terra">
        + Register Property
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($properties->isEmpty())
        <div class="text-center py-5 px-3">
            <h5>No properties found</h5>
            <p class="text-muted mb-0">
                Properties assigned to your owner profile will appear here.
            </p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Property</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $property)
                    <tr>
                        <td class="ps-4 fw-semibold">
                            {{ $property->name ?? $property->title ?? 'Property #' . $property->id }}
                        </td>

                        <td>
                            {{ $property->address ?? 'Not provided' }}
                        </td>

                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ ucfirst(str_replace('_', ' ', $property->status ?? 'unavailable')) }}
                            </span>
                        </td>

                        <td class="text-end pe-4">
                            <a href="{{ route('property-owner.properties.show', $property) }}"
                                class="btn btn-sm btn-outline-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $properties->links() }}
        </div>
        @endif
    </div>
</div>
@endsection