@extends('layouts.propertyOwner.app')

@section('title', 'Tenant Management')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Tenant Management</h2>
            <p class="text-muted mb-0">Manage tenants applying for or renting your properties.</p>
        </div>

        <a href="{{ route('property-owner.tenants.create') }}" class="btn btn-terra">
            <i class="bi bi-person-plus"></i> Register Tenant
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('property-owner.tenants.index') }}">
                <div class="row g-2">
                    <div class="col-md-7">
                        <input
                            type="search"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Search by name, email, phone or tenant code"
                        >
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All statuses</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                            <option value="active" @selected(request('status') === 'active')>Active</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button class="btn btn-terra flex-fill">Search</button>
                        <a href="{{ route('property-owner.tenants.index') }}"
                           class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tenant</th>
                            <th>Contact</th>
                            <th>Applications</th>
                            <th>Leases</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $tenant->full_name }}</div>
                                    <small class="text-muted">{{ $tenant->tenant_code }}</small>
                                </td>
                                <td>
                                    <div>{{ $tenant->email }}</div>
                                    <small class="text-muted">{{ $tenant->phone }}</small>
                                </td>
                                <td>{{ $tenant->applications_count }}</td>
                                <td>{{ $tenant->leases_count }}</td>
                                <td>
                                    @php
                                        $statusClass = match ($tenant->status) {
                                            'active' => 'success',
                                            'pending' => 'warning',
                                            'inactive' => 'secondary',
                                            default => 'light',
                                        };
                                    @endphp

                                    <span class="badge text-bg-{{ $statusClass }}">
                                        {{ ucfirst($tenant->status ?? 'Unknown') }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('property-owner.tenants.show', $tenant) }}"
                                       class="btn btn-sm btn-outline-secondary">View</a>

                                    <a href="{{ route('property-owner.tenants.edit', $tenant) }}"
                                       class="btn btn-sm btn-outline-primary">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <h5>No tenants found</h5>
                                    <p class="text-muted">Register a tenant to start an application for one of your units.</p>
                                    <a href="{{ route('property-owner.tenants.create') }}"
                                       class="btn btn-terra">Register Tenant</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($tenants->hasPages())
            <div class="card-footer bg-white">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection