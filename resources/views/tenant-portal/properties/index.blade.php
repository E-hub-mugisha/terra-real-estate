@extends('layouts.property-management')

@section('title', 'Available Properties')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Find a Property</h1>
            <p class="text-muted mb-0">
                Browse available rental units and submit an application.
            </p>
        </div>

        <a href="{{ route('tenant-portal.applications.index') }}"
           class="btn btn-outline-dark">
            My Applications
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($units->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h2 class="h5 fw-bold">No units currently available</h2>
                <p class="text-muted mb-0">
                    Please check again later for available rental properties.
                </p>
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($units as $unit)
                @php
                    $property = $unit->floor?->building?->property;
                @endphp

                @if($property)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body p-4">

                                <span class="badge text-bg-success mb-3">
                                    Available
                                </span>

                                <h2 class="h5 fw-bold">
                                    {{ $property->title }}
                                </h2>

                                <p class="text-muted small mb-3">
                                    {{ $property->district ?? 'Location not specified' }}
                                    @if($property->sector)
                                        , {{ $property->sector }}
                                    @endif
                                </p>

                                <div class="border-top border-bottom py-3 mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Unit</span>
                                        <strong>{{ $unit->unit_number }}</strong>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Type</span>
                                        <strong>
                                            {{ ucfirst(str_replace('_', ' ', $unit->unit_type)) }}
                                        </strong>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Bedrooms</span>
                                        <strong>{{ $unit->bedrooms ?? 'N/A' }}</strong>
                                    </div>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Monthly rent</span>
                                        <strong class="text-success">
                                            {{ number_format((float) $unit->rent, 0) }} RWF
                                        </strong>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Deposit</span>
                                        <strong>
                                            {{ number_format((float) $unit->deposit, 0) }} RWF
                                        </strong>
                                    </div>
                                </div>

                                <a href="{{ route('tenant-portal.properties.show', $unit) }}"
                                   class="btn btn-terra w-100">
                                    View Details
                                </a>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="mt-4">
            {{ $units->links() }}
        </div>
    @endif
</div>

<style>
    .btn-terra {
        background: #D05208;
        color: #fff;
        border: 1px solid #D05208;
    }

    .btn-terra:hover {
        background: #ad4306;
        color: #fff;
        border-color: #ad4306;
    }
</style>
@endsection