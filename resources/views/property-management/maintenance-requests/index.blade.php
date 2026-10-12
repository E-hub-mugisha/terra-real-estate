@extends('layouts.property-management')

@section('title', 'Maintenance Management')
@section('page-title', 'Maintenance Management')
@section('page-subtitle', 'Review and manage tenant repair requests.')

@section('content')

<div class="container-fluid px-0">

    <div class="row g-3 mb-4">
        @foreach([
            ['label' => 'Total Requests', 'value' => $stats['total'], 'icon' => 'bi-clipboard-data'],
            ['label' => 'Pending Review', 'value' => $stats['pending'], 'icon' => 'bi-clock-history'],
            ['label' => 'In Progress', 'value' => $stats['in_progress'], 'icon' => 'bi-tools'],
            ['label' => 'Completed', 'value' => $stats['completed'], 'icon' => 'bi-check-circle'],
        ] as $stat)
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-muted small">{{ $stat['label'] }}</div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <h3 class="fw-bold mb-0">{{ $stat['value'] }}</h3>
                            <i class="bi {{ $stat['icon'] }} fs-3 text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET"
                  action="{{ route('property-management.maintenance-requests.index') }}"
                  class="row g-3">

                <div class="col-lg-5">
                    <label class="form-label">Search requests</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control"
                           placeholder="Request number or description">
                </div>

                <div class="col-lg-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All statuses</option>
                        @foreach([
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'in_progress' => 'In Progress',
                            'on_hold' => 'On Hold',
                            'completed' => 'Completed',
                            'rejected' => 'Rejected',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                @selected(request('status') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-select">
                        <option value="">All priorities</option>
                        @foreach(['low', 'normal', 'high', 'urgent'] as $priority)
                            <option value="{{ $priority }}"
                                @selected(request('priority') === $priority)>
                                {{ ucfirst($priority) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary flex-grow-1" type="submit">
                        <i class="bi bi-search me-1"></i>
                        Filter
                    </button>
                    <a href="{{ route('property-management.maintenance-requests.index') }}"
                       class="btn btn-light border">
                        Reset
                    </a>
                </div>

            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Request</th>
                        <th>Tenant</th>
                        <th>Property / Unit</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($requests as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-semibold">{{ $item->title }}</div>
                                <div class="small text-muted">
                                    {{ $item->request_number }}
                                </div>
                            </td>

                            <td>
                                {{ $item->tenant->full_name
                                    ?? trim(($item->tenant->first_name ?? '') . ' ' .
                                            ($item->tenant->last_name ?? ''))
                                    ?: 'Tenant'
                                }}
                            </td>

                            <td>
                                <div>
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
                                <span class="badge
                                    @if($item->status === 'completed') bg-success
                                    @elseif($item->status === 'rejected') bg-danger
                                    @elseif($item->status === 'in_progress') bg-info
                                    @elseif($item->status === 'approved') bg-primary
                                    @elseif($item->status === 'on_hold') bg-secondary
                                    @else bg-warning text-dark
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>

                            <td>{{ $item->created_at->format('d M Y') }}</td>

                            <td class="text-end pe-4">
                                <a href="{{ route('property-management.maintenance-requests.show', $item) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-tools fs-1 text-muted"></i>
                                <h6 class="mt-3 fw-semibold">No maintenance requests found</h6>
                                <p class="text-muted mb-0">
                                    New tenant requests will appear here.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        @if($requests->hasPages())
            <div class="card-footer bg-white">
                {{ $requests->links() }}
            </div>
        @endif
    </div>

</div>

@endsection