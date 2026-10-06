@extends('layouts.property-management')

@section('title', 'Property Management')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

        <div>
            <h1 class="h3 fw-bold mb-1">
                Property Management
            </h1>

            <p class="text-muted mb-0">
                Manage your properties, buildings, units and rental portfolio.
            </p>
        </div>

        <a href="{{ route('property-management.properties.index') }}"
           class="btn btn-dark">
            <i class="bi bi-buildings me-1"></i>
            My Properties
        </a>

    </div>


    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- Statistics --}}
    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Properties
                    </div>

                    <div class="fs-3 fw-bold">
                        {{ $totalProperties }}
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Buildings
                    </div>

                    <div class="fs-3 fw-bold">
                        {{ $totalBuildings }}
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Total Units
                    </div>

                    <div class="fs-3 fw-bold">
                        {{ $totalUnits }}
                    </div>

                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Occupied Units
                    </div>

                    <div class="fs-3 fw-bold">
                        {{ $occupiedUnits }}
                    </div>

                    <div class="small text-muted">
                        {{ $vacantUnits }} vacant
                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- Properties --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="fw-bold mb-1">
                        My Properties
                    </h5>

                    <p class="text-muted small mb-0">
                        Properties available for management
                    </p>
                </div>

                <a href="{{ route('property-management.properties.index') }}"
                   class="btn btn-outline-dark btn-sm">
                    View All
                </a>

            </div>

        </div>


        <div class="card-body p-0">

            @if($properties->count())

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th class="px-4">Property</th>
                                <th>Location</th>
                                <th>Buildings</th>
                                <th>Management</th>
                                <th></th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($properties as $property)

                                <tr>

                                    <td class="px-4">

                                        <div class="fw-semibold">
                                            {{ $property->title }}
                                        </div>

                                        <small class="text-muted">
                                            {{ ucfirst($property->type) }}
                                        </small>

                                    </td>

                                    <td>
                                        {{ $property->district }},
                                        {{ $property->sector }}
                                    </td>

                                    <td>
                                        {{ $property->buildings_count }}
                                    </td>

                                    <td>

                                        @if($property->is_managed)

                                            <span class="badge bg-success-subtle text-success">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge bg-secondary-subtle text-secondary">
                                                Not Managed
                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-end pe-4">

                                        <a href="{{ route(
                                            'property-management.properties.show',
                                            $property
                                        ) }}"
                                           class="btn btn-sm btn-outline-dark">
                                            Manage
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <h5 class="fw-bold">
                        No properties yet
                    </h5>

                    <p class="text-muted">
                        Properties you own will appear here.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection