@extends('layouts.property-management.app')

@section('title', 'Lease Details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('admin.property-management.leases.index') }}"
               class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left me-1"></i> All Leases
            </a>
            <h1 class="h3 fw-bold mt-2 mb-1">{{ $lease->lease_number }}</h1>
            <p class="text-muted mb-0">Lease agreement details and payment history.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            @if($lease->status === 'draft')
                <a href="{{ route('admin.property-management.leases.edit', $lease) }}"
                   class="btn btn-light border">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>

                <form method="POST"
                      action="{{ route('admin.property-management.leases.activate', $lease) }}"
                      onsubmit="return confirm('Activate this lease and mark the unit as occupied?')">
                    @csrf
                    <button class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Activate Lease
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('admin.property-management.leases.destroy', $lease) }}"
                      onsubmit="return confirm('Delete this draft lease permanently?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">Delete Draft</button>
                </form>
            @elseif($lease->status === 'active')
                <button type="button" class="btn btn-outline-danger"
                        data-bs-toggle="modal" data-bs-target="#terminateLeaseModal">
                    <i class="bi bi-x-circle me-1"></i> Terminate Lease
                </button>
            @endif
        </div>
    </div>

    @if($errors->has('lease'))
        <div class="alert alert-danger">
            {{ $errors->first('lease') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Lease Overview</h5>
                            <p class="text-muted small mb-0">
                                Created by {{ $lease->creator?->name ?? 'System' }}
                            </p>
                        </div>

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
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Lease Start</div>
                            <div class="fw-semibold">
                                {{ $lease->start_date?->format('d F Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Lease End</div>
                            <div class="fw-semibold">
                                {{ $lease->end_date?->format('d F Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Monthly Rent</div>
                            <div class="h5 fw-bold mb-0">
                                {{ $lease->currency }}
                                {{ number_format((float) $lease->monthly_rent, 2) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Security Deposit</div>
                            <div class="h5 fw-bold mb-0">
                                {{ $lease->currency }}
                                {{ number_format((float) $lease->security_deposit, 2) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Rent Due Day</div>
                            <div class="fw-semibold">
                                Day {{ $lease->rent_due_day }} of each month
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="text-muted small mb-1">Payment Frequency</div>
                            <div class="fw-semibold">
                                {{ ucfirst($lease->payment_frequency) }}
                            </div>
                        </div>
                    </div>

                    @if($lease->terms)
                        <hr class="my-4">
                        <h6 class="fw-bold">Terms and Conditions</h6>
                        <div class="text-muted" style="white-space: pre-line">{{ $lease->terms }}</div>
                    @endif

                    @if($lease->status === 'terminated')
                        <hr class="my-4">
                        <h6 class="fw-bold text-danger">Termination Details</h6>
                        <p class="mb-1">
                            <strong>Date:</strong>
                            {{ $lease->terminated_at?->format('d F Y H:i') ?? '—' }}
                        </p>
                        <p class="mb-0">
                            <strong>Reason:</strong>
                            {{ $lease->termination_reason ?? '—' }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Rent Payment History</h5>

                    @if($lease->rentPayments->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Receipt</th>
                                        <th>Payment Date</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lease->rentPayments as $payment)
                                        <tr>
                                            <td>{{ $payment->receipt_number }}</td>
                                            <td>{{ $payment->payment_date?->format('d M Y') }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                            <td>{{ ucfirst($payment->status) }}</td>
                                            <td class="text-end fw-semibold">
                                                {{ $payment->currency }}
                                                {{ number_format((float) $payment->amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-receipt fs-2 text-muted"></i>
                            <p class="text-muted mb-0 mt-2">
                                No rent payments have been recorded for this lease.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Tenant</h5>

                    <div class="fw-semibold fs-5">
                        {{ $lease->tenant?->first_name }}
                        {{ $lease->tenant?->last_name }}
                    </div>

                    <div class="text-muted small mb-3">
                        {{ $lease->tenant?->tenant_code }}
                    </div>

                    <hr>

                    <div class="small text-muted">Email</div>
                    <div class="mb-3">
                        {{ $lease->tenant?->email ?? '—' }}
                    </div>

                    <div class="small text-muted">Phone</div>
                    <div>{{ $lease->tenant?->phone ?? '—' }}</div>

                    @if($lease->tenant)
                        <a href="{{ route('admin.property-management.tenants.show', $lease->tenant) }}"
                           class="btn btn-light border w-100 mt-3">
                            View Tenant Profile
                        </a>
                    @endif
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Property Unit</h5>

                    <div class="fw-semibold fs-5">
                        Unit {{ $lease->unit?->unit_number }}
                    </div>

                    <div class="text-muted mb-3">
                        {{ $lease->unit?->managedProperty?->name }}
                    </div>

                    <hr>

                    <div class="small text-muted">Unit Type</div>
                    <div class="mb-3">
                        {{ ucfirst(str_replace('_', ' ', $lease->unit?->unit_type ?? '—')) }}
                    </div>

                    <div class="small text-muted">Building</div>
                    <div class="mb-3">
                        {{ $lease->unit?->building?->name ?? 'Standalone unit' }}
                    </div>

                    <div class="small text-muted">Unit Status</div>
                    <div>
                        {{ ucfirst($lease->unit?->status ?? '—') }}
                    </div>

                    @if($lease->unit)
                        <a href="{{ route('admin.property-management.units.show', $lease->unit) }}"
                           class="btn btn-light border w-100 mt-3">
                            View Unit
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($lease->status === 'active')
    <div class="modal fade" id="terminateLeaseModal" tabindex="-1"
         aria-labelledby="terminateLeaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST"
                  action="{{ route('admin.property-management.leases.terminate', $lease) }}"
                  class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="terminateLeaseModalLabel">
                        Terminate Lease
                    </h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted">
                        This will terminate the lease and release the unit if no
                        other active lease remains.
                    </p>

                    <label for="termination_reason" class="form-label">
                        Reason for termination *
                    </label>
                    <textarea id="termination_reason" name="termination_reason"
                              class="form-control" rows="4" maxlength="2000"
                              required>{{ old('termination_reason') }}</textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        Confirm Termination
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif
@endsection