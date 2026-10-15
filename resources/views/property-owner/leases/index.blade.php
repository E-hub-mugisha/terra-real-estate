@extends('layouts.property-management.app')

@section('title', 'Leases')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Leases</h1>
            <p class="text-muted mb-0">Manage rental agreements and lease periods.</p>
        </div>

        <a href="{{ route('admin.property-management.leases.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Create Lease
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-7">
                    <input type="search" name="search" class="form-control"
                           placeholder="Search lease, tenant, unit or property..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All statuses</option>
                        @foreach(['draft', 'active', 'expired', 'terminated'] as $status)
                            <option value="{{ $status }}"
                                @selected(request('status') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-primary flex-grow-1">Filter</button>
                    <a href="{{ route('admin.property-management.leases.index') }}"
                       class="btn btn-light border">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Lease</th>
                        <th>Tenant</th>
                        <th>Unit / Property</th>
                        <th>Lease Period</th>
                        <th>Monthly Rent</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($leases as $lease)
                        <tr>
                            <td>
                                <a href="{{ route('admin.property-management.leases.show', $lease) }}"
                                   class="fw-semibold text-decoration-none">
                                    {{ $lease->lease_number }}
                                </a>
                                <div class="small text-muted">
                                    Due day: {{ $lease->rent_due_day }}
                                </div>
                            </td>

                            <td>
                                {{ $lease->tenant?->first_name }}
                                {{ $lease->tenant?->last_name }}
                                <div class="small text-muted">
                                    {{ $lease->tenant?->phone }}
                                </div>
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    Unit {{ $lease->unit?->unit_number }}
                                </div>
                                <div class="small text-muted">
                                    {{ $lease->unit?->managedProperty?->name }}
                                </div>
                            </td>

                            <td>
                                {{ $lease->start_date?->format('d M Y') }}
                                <div class="small text-muted">
                                    to {{ $lease->end_date?->format('d M Y') }}
                                </div>
                            </td>

                            <td class="fw-semibold">
                                {{ $lease->currency }}
                                {{ number_format((float) $lease->monthly_rent, 2) }}
                            </td>

                            <td>
                                @php
                                    $statusClass = match ($lease->status) {
                                        'active' => 'success',
                                        'draft' => 'secondary',
                                        'expired' => 'warning',
                                        'terminated' => 'danger',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge text-bg-{{ $statusClass }}">
                                    {{ ucfirst($lease->status) }}
                                </span>
                            </td>

                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.property-management.leases.show', $lease) }}"
                                   class="btn btn-sm btn-light border" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if($lease->status === 'draft')
                                    <a href="{{ route('admin.property-management.leases.edit', $lease) }}"
                                       class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-file-earmark-text fs-2 text-muted"></i>
                                <p class="fw-semibold mt-2 mb-1">No leases found</p>
                                <p class="text-muted small mb-3">
                                    Create a lease to get started.
                                </p>
                                <a href="{{ route('admin.property-management.leases.create') }}"
                                   class="btn btn-primary btn-sm">Create Lease</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leases->hasPages())
            <div class="card-footer bg-white">
                {{ $leases->links() }}
            </div>
        @endif
    </div>
</div>
@endsection