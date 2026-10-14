@extends('layouts.property-management.app')

@section('title', 'Tenant Details')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.tenants.index') }}"
               class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Back to Tenants
            </a>

            <h1 class="h3 fw-bold mt-2 mb-1">
                {{ $tenant->first_name }} {{ $tenant->last_name }}
            </h1>

            <p class="text-muted mb-0">
                Tenant reference: {{ $tenant->tenant_code }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.property-management.tenants.edit', $tenant) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit Tenant
            </a>

            <form action="{{ route('admin.property-management.tenants.destroy', $tenant) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this tenant profile? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="bi bi-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-light"
                             style="width: 56px; height: 56px;">
                            <i class="bi bi-person fs-3 text-secondary"></i>
                        </div>
                        <div>
                            <h2 class="h5 fw-bold mb-1">
                                {{ $tenant->first_name }} {{ $tenant->last_name }}
                            </h2>
                            <span class="badge text-bg-{{ $tenant->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($tenant->status) }}
                            </span>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Email</div>
                        <div class="fw-semibold text-break">{{ $tenant->email }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Phone</div>
                        <div class="fw-semibold">{{ $tenant->phone }}</div>
                    </div>

                    @if ($tenant->alternate_phone)
                        <div class="mb-3">
                            <div class="text-muted small mb-1">Alternate Phone</div>
                            <div>{{ $tenant->alternate_phone }}</div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <div class="text-muted small mb-1">National ID</div>
                        <div>{{ $tenant->national_id ?: 'Not provided' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Date of Birth</div>
                        <div>{{ $tenant->date_of_birth?->format('d M Y') ?? 'Not provided' }}</div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Gender</div>
                        <div>{{ $tenant->gender ? ucwords(str_replace('_', ' ', $tenant->gender)) : 'Not provided' }}</div>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">Residential Address</div>
                        <div>{{ $tenant->address ?: 'Not provided' }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Employment</h2>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Occupation</div>
                        <div>{{ $tenant->occupation ?: 'Not provided' }}</div>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">Employer</div>
                        <div>{{ $tenant->employer ?: 'Not provided' }}</div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Emergency Contact</h2>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Contact Name</div>
                        <div>{{ $tenant->emergency_contact_name ?: 'Not provided' }}</div>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">Contact Phone</div>
                        <div>{{ $tenant->emergency_contact_phone ?: 'Not provided' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h2 class="h5 fw-bold mb-3">Linked Terra Account</h2>

                    @if ($tenant->user)
                        <div class="fw-semibold">{{ $tenant->user->name }}</div>
                        <div class="text-muted">{{ $tenant->user->email }}</div>
                        <span class="badge text-bg-success mt-2">Account linked</span>
                    @else
                        <p class="text-muted mb-0">
                            This tenant profile is not linked to a Terra login account.
                        </p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0">Applications</h2>
                        <span class="badge text-bg-light">
                            {{ $tenant->applications->count() }}
                        </span>
                    </div>

                    @forelse ($tenant->applications as $application)
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $application->application_number }}
                                    </div>
                                    <div class="small text-muted">
                                        Unit {{ $application->unit->unit_number ?? '—' }}
                                        @if ($application->unit?->managedProperty)
                                            · {{ $application->unit->managedProperty->name }}
                                        @endif
                                    </div>
                                    <div class="small text-muted">
                                        Applied {{ $application->application_date?->format('d M Y') ?? '—' }}
                                    </div>
                                </div>

                                <span class="badge text-bg-secondary align-self-start">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No applications recorded.</p>
                    @endforelse
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h5 fw-bold mb-0">Leases</h2>
                        <span class="badge text-bg-light">
                            {{ $tenant->leases->count() }}
                        </span>
                    </div>

                    @forelse ($tenant->leases as $lease)
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $lease->lease_number }}</div>
                                    <div class="small text-muted">
                                        Unit {{ $lease->unit->unit_number ?? '—' }}
                                        @if ($lease->unit?->managedProperty)
                                            · {{ $lease->unit->managedProperty->name }}
                                        @endif
                                    </div>
                                    <div class="small text-muted">
                                        {{ $lease->start_date?->format('d M Y') ?? '—' }}
                                        –
                                        {{ $lease->end_date?->format('d M Y') ?? 'Ongoing' }}
                                    </div>
                                </div>

                                <div class="text-end">
                                    <div class="fw-semibold">
                                        {{ $lease->currency }}
                                        {{ number_format((float) $lease->monthly_rent, 2) }}/month
                                    </div>
                                    <span class="badge text-bg-secondary mt-1">
                                        {{ ucfirst($lease->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No leases recorded.</p>
                    @endforelse
                </div>
            </div>

            @if ($tenant->notes)
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 fw-bold mb-3">Internal Notes</h2>
                        <p class="mb-0">{{ $tenant->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection