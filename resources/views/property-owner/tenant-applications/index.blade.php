
@extends('layouts.propertyOwner.app')

@section('title', 'Tenant Applications')

@section('content')
<div class="container-fluid py-4">

    {{-- Page header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Tenant Applications</h2>
            <p class="text-muted mb-0">
                Review and manage applications for your rental properties.
            </p>
        </div>

        <a href="{{ route('property-owner.tenants.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-people me-1"></i>
            Manage Tenants
        </a>
    </div>

    {{-- Feedback messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('property-owner.tenant-applications.index') }}">
                <div class="row g-3">
                    <div class="col-lg-5">
                        <label for="search" class="form-label">
                            Search applications
                        </label>
                        <input
                            type="search"
                            name="search"
                            id="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Application number, tenant, email or unit"
                        >
                    </div>

                    <div class="col-lg-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All statuses</option>
                            @foreach([
                                'pending' => 'Pending',
                                'under_review' => 'Under Review',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                'withdrawn' => 'Withdrawn',
                            ] as $value => $label)
                                <option value="{{ $value }}"
                                    @selected(request('status') === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-terra">
                            <i class="bi bi-search me-1"></i> Search
                        </button>

                        <a href="{{ route('property-owner.tenant-applications.index') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Applications table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Applications</h5>
                <span class="text-muted small">
                    {{ $applications->total() }} total
                </span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Application</th>
                            <th>Tenant</th>
                            <th>Property / Unit</th>
                            <th>Monthly Rent</th>
                            <th>Move-in Date</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($applications as $application)
                            <tr>
                                <td>
                                    <span class="fw-semibold">
                                        {{ $application->application_number }}
                                    </span>
                                    <div class="text-muted small">
                                        {{ $application->application_date?->format('d M Y') ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $application->tenant?->full_name ?? 'Unknown tenant' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $application->tenant?->email ?? '—' }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $application->tenant?->phone ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $application->unit?->managedProperty?->name ?? '—' }}
                                    </div>
                                    <div class="text-muted small">
                                        Unit {{ $application->unit?->unit_number ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $application->currency ?? 'RWF' }}
                                    {{ number_format((float) $application->offered_monthly_rent, 0) }}
                                </td>

                                <td>
                                    {{ $application->desired_move_in_date?->format('d M Y') ?? 'Not specified' }}
                                </td>

                                <td>
                                    @php
                                        $statusClass = match ($application->status) {
                                            'approved' => 'success',
                                            'rejected', 'withdrawn' => 'danger',
                                            'under_review' => 'info',
                                            'pending' => 'warning',
                                            default => 'secondary',
                                        };
                                    @endphp

                                    <span class="badge text-bg-{{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $application->status ?? 'unknown')) }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a
                                        href="{{ route('property-owner.tenant-applications.show', $application) }}"
                                        class="btn btn-sm btn-outline-secondary"
                                    >
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-file-earmark-text fs-1 text-muted"></i>
                                    <h5 class="mt-3">No applications found</h5>
                                    <p class="text-muted mb-0">
                                        Applications for your properties will appear here.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($applications->hasPages())
            <div class="card-footer bg-white">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
