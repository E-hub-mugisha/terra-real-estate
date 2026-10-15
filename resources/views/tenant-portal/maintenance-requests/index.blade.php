@extends('layouts.tenant.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Maintenance Requests</h3>
            <p class="text-muted mb-0">
                Report repairs and track maintenance progress for your rental.
            </p>
        </div>

        <a href="{{ route('tenant-portal.maintenance-requests.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            New request
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        $collection = $maintenanceRequests->getCollection();

        $openCount = $collection->whereNotIn(
            'status',
            ['completed', 'cancelled', 'rejected']
        )->count();

        $completedCount = $collection->where('status', 'completed')->count();
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <small class="text-muted">Requests on this page</small>
                    <h3 class="fw-bold mt-2 mb-0">
                        {{ $maintenanceRequests->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <small class="text-muted">Open on this page</small>
                    <h3 class="fw-bold mt-2 mb-0">{{ $openCount }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <small class="text-muted">Completed on this page</small>
                    <h3 class="fw-bold mt-2 mb-0">{{ $completedCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="p-4 border-bottom">
                <h5 class="fw-bold mb-1">Your requests</h5>
                <p class="text-muted small mb-0">
                    Select a request to see its latest recorded details.
                </p>
            </div>

            @if ($maintenanceRequests->isEmpty())
                <div class="text-center py-5 px-3">
                    <i class="bi bi-tools fs-1 text-muted"></i>
                    <h5 class="fw-bold mt-3">No maintenance requests</h5>
                    <p class="text-muted">
                        If something needs repair, submit a request here.
                    </p>
                    <a href="{{ route('tenant-portal.maintenance-requests.create') }}"
                       class="btn btn-primary">
                        Submit a request
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4">Request</th>
                                <th>Rental unit</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Date submitted</th>
                                <th>Status</th>
                                <th class="text-end px-4">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($maintenanceRequests as $item)
                                @php
                                    $status = strtolower($item->status ?? 'unknown');

                                    $statusClass = match ($status) {
                                        'pending' => 'bg-warning text-dark',
                                        'assigned', 'scheduled', 'in_progress'
                                            => 'bg-primary',
                                        'completed' => 'bg-success',
                                        'cancelled', 'rejected' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };

                                    $priority = strtolower($item->priority ?? 'medium');

                                    $priorityClass = match ($priority) {
                                        'urgent' => 'bg-danger',
                                        'high' => 'bg-warning text-dark',
                                        'low' => 'bg-light text-dark border',
                                        default => 'bg-info text-dark',
                                    };
                                @endphp

                                <tr>
                                    <td class="px-4">
                                        <strong>{{ $item->request_number }}</strong>
                                        <div>{{ $item->title }}</div>
                                    </td>

                                    <td>
                                        <div>
                                            {{ $item->managedProperty?->name
                                                ?? $item->managedProperty?->title
                                                ?? 'Managed property' }}
                                        </div>
                                        <small class="text-muted">
                                            Unit {{ $item->unit?->unit_number ?? 'N/A' }}
                                        </small>
                                    </td>

                                    <td>
                                        {{ ucwords(str_replace('_', ' ', $item->category)) }}
                                    </td>

                                    <td>
                                        <span class="badge {{ $priorityClass }}">
                                            {{ ucfirst($priority) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $item->requested_date?->format('d M Y')
                                            ?? 'Not recorded' }}
                                    </td>

                                    <td>
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucwords(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>

                                    <td class="text-end px-4">
                                        <a href="{{ route(
                                            'tenant-portal.maintenance-requests.show',
                                            $item
                                        ) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            View details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $maintenanceRequests->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
