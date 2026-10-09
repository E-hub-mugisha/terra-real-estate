@extends('layouts.property-management')

@section('title', 'My Leases')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">My Leases</h1>
            <p class="text-muted mb-0">
                View your rental agreements and lease details.
            </p>
        </div>

        <a href="{{ route('tenant-portal.dashboard') }}"
           class="btn btn-outline-secondary">
            Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($leases->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h5 class="fw-bold">No leases yet</h5>
                <p class="text-muted">
                    Your rental agreements will appear here once they have
                    been created for you.
                </p>

                <a href="{{ route('tenant-portal.properties.index') }}"
                   class="btn btn-primary">
                    Browse Properties
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Lease Number</th>
                            <th>Property</th>
                            <th>Unit</th>
                            <th>Lease Period</th>
                            <th>Monthly Rent</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($leases as $lease)
                            @php
                                $unit = $lease->unit;
                                $property = $unit?->floor?->building?->property;

                                $statusClasses = [
                                    'draft' => 'secondary',
                                    'pending_signature' => 'warning',
                                    'active' => 'success',
                                    'expired' => 'dark',
                                    'terminated' => 'danger',
                                    'cancelled' => 'danger',
                                ];

                                $statusClass = $statusClasses[$lease->status]
                                    ?? 'secondary';
                            @endphp

                            <tr>
                                <td class="fw-semibold">
                                    {{ $lease->lease_number }}
                                </td>

                                <td>
                                    {{ $property?->title ?? 'Property unavailable' }}
                                </td>

                                <td>
                                    {{ $unit?->unit_number ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $lease->start_date?->format('d M Y') }}
                                    <div class="small text-muted">
                                        to
                                        {{ $lease->end_date?->format('d M Y') }}
                                    </div>
                                </td>

                                <td>
                                    {{ number_format((float) $lease->monthly_rent, 0) }}
                                    RWF
                                </td>

                                <td>
                                    <span class="badge bg-{{ $statusClass }}">
                                        {{ ucwords(str_replace('_', ' ', $lease->status)) }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('tenant-portal.leases.show', $lease) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View Lease
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body">
                {{ $leases->links() }}
            </div>
        </div>
    @endif

</div>
@endsection