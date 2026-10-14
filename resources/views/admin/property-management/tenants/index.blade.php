@extends('layouts.property-management.app')

@section('title', 'Tenants')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Tenants</h1>
            <p class="text-muted mb-0">Manage tenant profiles and rental relationships.</p>
        </div>

        <a href="{{ route('admin.property-management.tenants.create') }}"
           class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Register Tenant
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('admin.property-management.tenants.index') }}"
                  class="row g-3">
                <div class="col-md-8">
                    <label for="search" class="form-label">Search tenants</label>
                    <input type="text"
                           name="search"
                           id="search"
                           class="form-control"
                           value="{{ request('search') }}"
                           placeholder="Name, tenant code, email or phone">
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All statuses</option>
                        @foreach (['active', 'inactive'] as $status)
                            <option value="{{ $status }}"
                                @selected(request('status') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button class="btn btn-dark w-100" type="submit" title="Search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                <div class="col-12">
                    <a href="{{ route('admin.property-management.tenants.index') }}"
                       class="small text-decoration-none">Reset filters</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tenant</th>
                            <th>Contact</th>
                            <th>Applications</th>
                            <th>Leases</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tenants as $tenant)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">
                                        {{ $tenant->first_name }} {{ $tenant->last_name }}
                                    </div>
                                    <small class="text-muted">{{ $tenant->tenant_code }}</small>
                                </td>
                                <td>
                                    <div>{{ $tenant->email }}</div>
                                    <small class="text-muted">{{ $tenant->phone }}</small>
                                </td>
                                <td>{{ $tenant->applications_count }}</td>
                                <td>{{ $tenant->leases_count }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $tenant->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($tenant->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.property-management.tenants.show', $tenant) }}"
                                       class="btn btn-sm btn-outline-dark">View</a>
                                    <a href="{{ route('admin.property-management.tenants.edit', $tenant) }}"
                                       class="btn btn-sm btn-outline-primary">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    No tenants found. Register your first tenant to get started.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($tenants->hasPages())
            <div class="card-footer bg-white">
                {{ $tenants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection