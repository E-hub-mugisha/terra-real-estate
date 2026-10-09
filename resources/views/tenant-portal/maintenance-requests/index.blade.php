@extends('layouts.property-management')

@section('title', 'Maintenance Requests')
@section('page-title', 'Maintenance Requests')
@section('page-subtitle', 'Report issues and track repairs for your rented property.')

@section('content')

@php
    $statusClasses = [
        'pending' => 'warning',
        'approved' => 'primary',
        'in_progress' => 'info',
        'on_hold' => 'secondary',
        'completed' => 'success',
        'rejected' => 'danger',
    ];
@endphp

<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">My Maintenance Requests</h4>
            <p class="text-muted mb-0">Submit a problem or check on an existing repair.</p>
        </div>

        <a href="{{ route('tenant-portal.maintenance-requests.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            New Request
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        @foreach([
            ['label' => 'Total Requests', 'value' => $stats['total'], 'icon' => 'bi-clipboard'],
            ['label' => 'Pending', 'value' => $stats['pending'], 'icon' => 'bi-clock'],
            ['label' => 'In Progress', 'value' => $stats['in_progress'], 'icon' => 'bi-tools'],
            ['label' => 'Completed', 'value' => $stats['completed'], 'icon' => 'bi-check-circle'],
        ] as $stat)
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-muted small">{{ $stat['label'] }}</div>
                                <div class="fs-3 fw-bold">{{ $stat['value'] }}</div>
                            </div>
                            <i class="bi {{ $stat['icon'] }} fs-3 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Request</th>
                            <th>Property / Unit</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Date Submitted</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($requests as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">{{ $item->title }}</div>
                                    <div class="text-muted small">
                                        {{ $item->request_number }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ ucfirst($item->category) }}
                                    </div>
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $item->unit->floor->building->property->title ?? 'Property' }}
                                    </div>
                                    <div class="text-muted small">
                                        Unit {{ $item->unit->unit_number ?? $item->unit_id }}
                                    </div>
                                </td>

                                <td>
                                    <span class="badge
                                        @if($item->priority === 'urgent') bg-danger
                                        @elseif($item->priority === 'high') bg-warning text-dark
                                        @else bg-light text-dark
                                        @endif">
                                        {{ ucfirst($item->priority) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge bg-{{ $statusClasses[$item->status] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    </span>
                                </td>

                                <td>{{ $item->created_at->format('d M Y') }}</td>

                                <td class="text-end pe-4">
                                    <a href="{{ route('tenant-portal.maintenance-requests.show', $item) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-tools fs-1 text-muted"></i>
                                    <h6 class="mt-3 fw-semibold">No maintenance requests yet</h6>
                                    <p class="text-muted mb-3">
                                        Report a maintenance issue to get started.
                                    </p>
                                    <a href="{{ route('tenant-portal.maintenance-requests.create') }}"
                                       class="btn btn-primary btn-sm">
                                        Submit a Request
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

        @if($requests->hasPages())
            <div class="card-footer bg-white">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

</div>

@endsection