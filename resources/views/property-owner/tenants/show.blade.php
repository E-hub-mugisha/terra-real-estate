@extends('layouts.propertyOwner.app')

@section('title', 'Tenant Details')

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <a href="{{ route('property-owner.tenants.index') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left"></i> Back to Tenants
            </a>
            <h2 class="mt-3 mb-1">{{ $tenant->full_name }}</h2>
            <p class="text-muted mb-0">{{ $tenant->tenant_code }}</p>
        </div>

        <a href="{{ route('property-owner.tenants.edit', $tenant) }}" class="btn btn-terra">
            <i class="bi bi-pencil"></i> Edit Tenant
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Personal Details</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-1">Status</p>
                    <p class="fw-semibold">{{ ucfirst($tenant->status ?? 'Unknown') }}</p>

                    <p class="text-muted mb-1">Email</p>
                    <p>{{ $tenant->email ?: '—' }}</p>

                    <p class="text-muted mb-1">Phone</p>
                    <p>{{ $tenant->phone ?: '—' }}</p>

                    <p class="text-muted mb-1">Alternative Phone</p>
                    <p>{{ $tenant->alternative_phone ?: '—' }}</p>

                    <p class="text-muted mb-1">National ID</p>
                    <p>{{ $tenant->national_id ?: '—' }}</p>

                    <p class="text-muted mb-1">Date of Birth</p>
                    <p>{{ $tenant->date_of_birth?->format('d M Y') ?? '—' }}</p>

                    <p class="text-muted mb-1">Gender</p>
                    <p>{{ $tenant->gender ? ucfirst($tenant->gender) : '—' }}</p>

                    <p class="text-muted mb-1">Occupation</p>
                    <p>{{ $tenant->occupation ?: '—' }}</p>

                    <p class="text-muted mb-1">Employer</p>
                    <p>{{ $tenant->employer ?: '—' }}</p>

                    <p class="text-muted mb-1">Emergency Contact</p>
                    <p>{{ $tenant->emergency_contact_name ?: '—' }}</p>
                    <p>{{ $tenant->emergency_contact_phone ?: '—' }}</p>

                    <p class="text-muted mb-1">Address</p>
                    <p>{{ $tenant->address ?: '—' }}</p>

                    @if($tenant->notes)
                        <p class="text-muted mb-1">Internal Notes</p>
                        <p class="mb-0">{{ $tenant->notes }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Rental Applications</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Application</th>
                                    <th>Unit</th>
                                    <th>Applied On</th>
                                    <th>Monthly Rent</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tenant->applications as $application)
                                    <tr>
                                        <td>{{ $application->application_number }}</td>
                                        <td>
                                            {{ $application->unit->managedProperty->name ?? 'Property' }}
                                            <br>
                                            <small class="text-muted">
                                                Unit {{ $application->unit->unit_number ?? '—' }}
                                            </small>
                                        </td>
                                        <td>{{ $application->application_date?->format('d M Y') ?? '—' }}</td>
                                        <td>
                                            {{ $application->currency ?? 'RWF' }}
                                            {{ number_format((float) $application->offered_monthly_rent) }}
                                        </td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $application->status ?? 'unknown')) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            No applications found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Leases</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Unit</th>
                                    <th>Property</th>
                                    <th>Lease Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tenant->leases as $lease)
                                    <tr>
                                        <td>{{ $lease->unit->unit_number ?? '—' }}</td>
                                        <td>{{ $lease->unit->managedProperty->name ?? '—' }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $lease->status ?? 'unknown')) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            No leases found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection