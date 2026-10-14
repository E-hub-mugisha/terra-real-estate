@extends('layouts.property-management.app')

@section('title', 'Unit Details')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.units.index') }}"
               class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Back to Units
            </a>

            <h1 class="h3 fw-bold mt-2 mb-1">
                Unit {{ $unit->unit_number }}
            </h1>

            <p class="text-muted mb-0">
                {{ $unit->managedProperty->name ?? 'Managed property' }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.property-management.units.edit', $unit) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Unit
            </a>

            <form action="{{ route('admin.property-management.units.destroy', $unit) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this unit?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Unit Information</h2>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Unit Number</div>
                            <div class="fw-semibold">{{ $unit->unit_number }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Unit Type</div>
                            <div class="fw-semibold">
                                {{ ucwords(str_replace('_', ' ', $unit->unit_type)) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Building</div>
                            <div class="fw-semibold">{{ $unit->building->name ?? 'Standalone unit' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Floor</div>
                            <div class="fw-semibold">{{ $unit->floor->name ?? 'Not assigned' }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Bedrooms</div>
                            <div class="fw-semibold">{{ $unit->bedrooms ?? '—' }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Bathrooms</div>
                            <div class="fw-semibold">{{ $unit->bathrooms ?? '—' }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Area</div>
                            <div class="fw-semibold">
                                {{ $unit->area_sqm !== null ? number_format((float) $unit->area_sqm, 2).' m²' : '—' }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="text-muted small mb-1">Description</div>
                            <div>{{ $unit->description ?: 'No description provided.' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Tenant Applications</h2>

                    @forelse ($unit->applications as $application)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                            <div>
                                <div class="fw-semibold">
                                    {{ $application->application_number }}
                                </div>
                                <div class="small text-muted">
                                    {{ $application->tenant->full_name ?? 'Tenant' }}
                                </div>
                            </div>
                            <span class="badge text-bg-secondary">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No applications for this unit yet.</p>
                    @endforelse

                    <hr class="my-4">

                    <h2 class="h5 fw-bold mb-3">Leases</h2>

                    @forelse ($unit->leases as $lease)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                            <div>
                                <div class="fw-semibold">{{ $lease->lease_number }}</div>
                                <div class="small text-muted">
                                    {{ $lease->tenant->full_name ?? 'Tenant' }}
                                </div>
                                <div class="small text-muted">
                                    {{ $lease->start_date?->format('d M Y') ?? '—' }}
                                    –
                                    {{ $lease->end_date?->format('d M Y') ?? 'Ongoing' }}
                                </div>
                            </div>
                            <span class="badge text-bg-secondary">
                                {{ ucfirst($lease->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No leases for this unit yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Rental Information</h2>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Monthly Rent</div>
                        <div class="h4 fw-bold mb-0">
                            {{ $unit->currency }}
                            {{ number_format((float) $unit->monthly_rent, 2) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Security Deposit</div>
                        <div class="fw-semibold">
                            {{ $unit->currency }}
                            {{ number_format((float) ($unit->security_deposit ?? 0), 2) }}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">Current Status</div>
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
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Managed Property</h2>
                    <div class="fw-semibold">
                        {{ $unit->managedProperty->name ?? '—' }}
                    </div>
                    <div class="small text-muted mb-3">
                        {{ $unit->managedProperty->property_code ?? '' }}
                    </div>

                    @if ($unit->managedProperty)
                        <a href="{{ route('admin.property-management.properties.show', $unit->managedProperty) }}"
                           class="btn btn-outline-dark btn-sm">
                            View Property
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection