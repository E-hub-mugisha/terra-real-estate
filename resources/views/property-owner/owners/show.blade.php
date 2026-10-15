@extends('layouts.property-management.app')

@section('title', 'Property Owner Details')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Property Owner Details</h1>
            <p class="text-muted mb-0">
                View the owner profile and associated managed properties.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.property-management.owners.index') }}"
               class="btn btn-outline-secondary">
                Back
            </a>

            <a href="{{ route('admin.property-management.owners.edit', $owner) }}"
               class="btn btn-primary">
                Edit Owner
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 mb-0">Owner Information</h2>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Full name</div>
                            <div class="fw-semibold">
                                {{ $owner->user?->name ?? 'User unavailable' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Email</div>
                            <div>
                                {{ $owner->user?->email ?? '—' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Phone</div>
                            <div>{{ $owner->phone ?: '—' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Owner type</div>
                            <div>{{ ucfirst($owner->owner_type) }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Company name</div>
                            <div>{{ $owner->company_name ?: '—' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">National ID</div>
                            <div>{{ $owner->national_id ?: '—' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">TIN</div>
                            <div>{{ $owner->tin ?: '—' }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="small text-muted mb-1">Address</div>
                            <div>{{ $owner->address ?: '—' }}</div>
                        </div>

                        <div class="col-12">
                            <div class="small text-muted mb-1">Internal notes</div>
                            <div>{{ $owner->notes ?: 'No notes added.' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 mb-0">Account Summary</h2>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <div class="small text-muted mb-2">
                            Verification status
                        </div>

                        @php
                            $badgeClass = match ($owner->verification_status) {
                                'verified' => 'text-bg-success',
                                'rejected' => 'text-bg-danger',
                                default => 'text-bg-warning',
                            };
                        @endphp

                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst($owner->verification_status) }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <div class="small text-muted mb-1">
                            Managed properties
                        </div>
                        <div class="display-6 fw-semibold">
                            {{ $owner->properties_count }}
                        </div>
                    </div>

                    <div class="small text-muted">
                        Owner profile created
                    </div>
                    <div>
                        {{ $owner->created_at?->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h2 class="h5 mb-0">Managed Properties</h2>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">Property</th>
                            <th>Code</th>
                            <th>Location</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($properties as $property)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-semibold">
                                        {{ $property->name }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ ucfirst(str_replace('_', ' ', $property->property_type)) }}
                                    </div>
                                </td>

                                <td>{{ $property->property_code }}</td>

                                <td>
                                    {{ collect([
                                        $property->district,
                                        $property->province,
                                    ])->filter()->implode(', ') ?: ($property->address ?: '—') }}
                                </td>

                                <td>
                                    <span class="badge {{ $property->management_status === 'active' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ ucfirst($property->management_status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    This owner has no managed properties yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($properties->hasPages())
            <div class="card-footer bg-white">
                {{ $properties->links() }}
            </div>
        @endif
    </div>
</div>
@endsection