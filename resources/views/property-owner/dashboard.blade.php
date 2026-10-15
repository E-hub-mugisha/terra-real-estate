@extends('layouts.propertyOwner.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1">Welcome, {{ auth()->user()->name }}</h2>
        <p class="text-muted mb-0">
            Manage your properties and monitor your portfolio.
        </p>
    </div>

    <a href="{{ route('property-owner.properties.index') }}"
        class="btn btn-terra">
        View My Properties
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="text-muted small mb-2">Total Properties</div>
                <h2 class="fw-bold mb-2">{{ $totalProperties }}</h2>
                <span class="small text-muted">
                    Properties linked to your account
                </span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="text-muted small mb-2">Owner Type</div>
                <h4 class="fw-bold mb-2">
                    {{ ucfirst(str_replace('_', ' ', $owner->owner_type ?? 'Individual')) }}
                </h4>
                <span class="small text-muted">Owner profile</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="text-muted small mb-2">Verification Status</div>
                <h4 class="fw-bold mb-2">
                    {{ ucfirst(str_replace('_', ' ', $owner->verification_status ?? 'pending')) }}
                </h4>
                <span class="small text-muted">
                    Your owner verification status
                </span>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1">My Properties</h5>
                <p class="text-muted small mb-0">
                    Your recently registered properties.
                </p>
            </div>

            <a href="{{ route('property-owner.properties.index') }}"
                class="text-decoration-none">
                View all
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        @forelse($properties->take(5) as $property)
        <div class="d-flex justify-content-between align-items-center gap-3 p-4 border-top">
            <div>
                <h6 class="fw-semibold mb-1">
                    {{ $property->name ?? $property->title ?? 'Property #' . $property->id }}
                </h6>
                <span class="small text-muted">
                    {{ $property->address ?? 'Address not provided' }}
                </span>
            </div>

            <a href="{{ route('property-owner.properties.show', $property) }}"
                class="btn btn-outline-secondary btn-sm">
                Details
            </a>
        </div>
        @empty
        <div class="text-center py-5 px-3">
            <h6>No properties linked yet</h6>
            <p class="text-muted mb-0">
                Contact the Terra administrator or property manager to link your properties.
            </p>
        </div>
        @endforelse
    </div>
</div>

<a href="{{ route('property-owner.tenants.index') }}"
    class="text-decoration-none">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Tenant Management</h5>
                    <p class="text-muted mb-0">
                        View tenant profiles, applications and leases.
                    </p>
                </div>
                <i class="bi bi-people fs-2" style="color: #D05208;"></i>
            </div>
        </div>
    </div>
</a>
@endsection