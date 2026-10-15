@extends('layouts.tenant.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">My Applications</h3>
            <p class="text-muted mb-0">Track your rental applications.</p>
        </div>

        <a href="{{ route('tenant-portal.applications.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Apply for a Unit
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($applications->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h5>No applications yet</h5>
                <p class="text-muted">
                    Browse available units and submit your first application.
                </p>
                <a href="{{ route('tenant-portal.applications.create') }}"
                   class="btn btn-primary">
                    Start Application
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Application No.</th>
                            <th>Unit</th>
                            <th>Applied On</th>
                            <th>Move-in Date</th>
                            <th>Offered Rent</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td class="fw-semibold">
                                    {{ $application->application_number }}
                                </td>
                                <td>
                                    {{ $application->unit->name
                                        ?? 'Unit #' . $application->unit_id }}
                                </td>
                                <td>
                                    {{ $application->application_date?->format('d M Y') }}
                                </td>
                                <td>
                                    {{ $application->desired_move_in_date?->format('d M Y') }}
                                </td>
                                <td>
                                    {{ $application->currency }}
                                    {{ number_format((float) $application->offered_monthly_rent, 0) }}
                                </td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-warning text-dark',
                                            'under_review' => 'bg-info text-dark',
                                            'approved' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'withdrawn' => 'bg-secondary',
                                        ];
                                    @endphp

                                    <span class="badge {{ $statusClasses[$application->status] ?? 'bg-secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('tenant-portal.applications.show', $application) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body">
                {{ $applications->links() }}
            </div>
        </div>
    @endif
</div>
@endsection