@extends('layouts.property-management.app')

@section('title', 'Tenant Applications')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Tenant Applications</h1>
            <p class="text-muted mb-0">Review rental applications and manage decisions.</p>
        </div>

        <a href="{{ route('admin.property-management.applications.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> New Application
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('admin.property-management.applications.index') }}"
                  class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" id="search" name="search"
                           class="form-control"
                           value="{{ request('search') }}"
                           placeholder="Application number, tenant, email or unit">
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All statuses</option>
                        @foreach (['pending', 'approved', 'rejected'] as $status)
                            <option value="{{ $status }}"
                                @selected(request('status') === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button class="btn btn-dark" type="submit">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.property-management.applications.index') }}"
                       class="btn btn-outline-secondary">Reset</a>
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
                            <th class="ps-4">Application</th>
                            <th>Tenant</th>
                            <th>Unit / Property</th>
                            <th>Move-in Date</th>
                            <th>Offered Rent</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($applications as $application)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">
                                        {{ $application->application_number }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $application->application_date?->format('d M Y') ?? '—' }}
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $application->tenant->full_name ?? 'Tenant unavailable' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $application->tenant->email ?? '' }}
                                    </small>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $application->unit->unit_number ?? '—' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $application->unit->managedProperty->name ?? '—' }}
                                    </small>
                                </td>

                                <td>
                                    {{ $application->desired_move_in_date?->format('d M Y') ?? '—' }}
                                </td>

                                <td>
                                    {{ $application->currency }}
                                    {{ number_format((float) $application->offered_monthly_rent, 2) }}
                                </td>

                                <td>
                                    @php
                                        $statusClass = match ($application->status) {
                                            'pending' => 'warning',
                                            'approved' => 'success',
                                            'rejected' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge text-bg-{{ $statusClass }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>

                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.property-management.applications.show', $application) }}"
                                       class="btn btn-sm btn-outline-dark">View</a>

                                    @if ($application->status === 'pending')
                                        <a href="{{ route('admin.property-management.applications.edit', $application) }}"
                                           class="btn btn-sm btn-outline-primary">Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    No applications found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($applications->hasPages())
            <div class="card-footer bg-white">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection