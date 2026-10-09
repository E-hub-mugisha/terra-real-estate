@extends('layouts.property-management')

@section('title', 'My Applications')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">My Applications</h1>
            <p class="text-muted mb-0">
                Track the status of your rental applications.
            </p>
        </div>

        <a href="{{ route('tenant-portal.properties.index') }}"
           class="btn btn-outline-dark">
            Browse Properties
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($applications->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h2 class="h5 fw-bold">No applications yet</h2>
                <p class="text-muted">
                    Browse available properties to submit your first application.
                </p>
                <a href="{{ route('tenant-portal.properties.index') }}"
                   class="btn btn-terra">
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
                            <th>Property / Unit</th>
                            <th>Application Date</th>
                            <th>Preferred Move-in</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            @php
                                $property = $application->unit?->floor?->building?->property;

                                $statusClass = match($application->status) {
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    'under_review' => 'info',
                                    'withdrawn' => 'secondary',
                                    default => 'warning',
                                };
                            @endphp

                            <tr>
                                <td>
                                    <strong>{{ $property?->title ?? 'Property unavailable' }}</strong>
                                    <div class="small text-muted">
                                        Unit {{ $application->unit?->unit_number ?? 'N/A' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $application->application_date?->format('d M Y') ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $application->preferred_move_in_date?->format('d M Y') ?? 'Not specified' }}
                                </td>

                                <td>
                                    <span class="badge text-bg-{{ $statusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('tenant-portal.applications.show', $application) }}"
                                       class="btn btn-sm btn-outline-dark">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    @endif
</div>

<style>
    .btn-terra {
        background: #D05208;
        color: #fff;
        border-color: #D05208;
    }

    .btn-terra:hover {
        background: #ad4306;
        color: #fff;
    }
</style>
@endsection