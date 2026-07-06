{{-- resources/views/admin/service-reports/show.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid service-report-show" style="--green:#00a667;">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <a href="{{ route('admin.service-reports.index') }}" class="text-muted small text-decoration-none">
                <i class="ti ti-arrow-left"></i> Back to Service Reports
            </a>
            <h4 class="fw-semibold mb-0 mt-1">Service Report #{{ $serviceReport->id }}</h4>
        </div>
        <span class="badge status-badge status-{{ $serviceReport->status }}">
            {{ ucfirst($serviceReport->status) }}
        </span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        {{-- Main details --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold">Service &amp; Client Details</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="detail-label">Consultant</div>
                            <div class="detail-value">
                                {{ $serviceReport->consultant->name }}
                                <div class="small text-muted">{{ $serviceReport->consultant->phone }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Service</div>
                            <div class="detail-value">{{ $serviceReport->service->title }}</div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-label">Client Name</div>
                            <div class="detail-value">{{ $serviceReport->client_name }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-label">Client Phone</div>
                            <div class="detail-value">
                                <a href="tel:{{ $serviceReport->client_phone }}" class="text-decoration-none">
                                    {{ $serviceReport->client_phone }}
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="detail-label">Date</div>
                            <div class="detail-value">{{ $serviceReport->service_date->format('d M Y') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Time</div>
                            <div class="detail-value">{{ \Carbon\Carbon::parse($serviceReport->service_time)->format('H:i') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-label">Location</div>
                            <div class="detail-value">{{ $serviceReport->location }}</div>
                        </div>

                        @if ($serviceReport->notes)
                            <div class="col-12">
                                <div class="detail-label">Consultant's Notes</div>
                                <div class="detail-value fw-normal">{{ $serviceReport->notes }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Financial breakdown --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold">Financial Breakdown</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="amount-box">
                                <div class="small text-muted">Amount Charged</div>
                                <div class="fs-5 fw-bold">{{ number_format($serviceReport->amount) }} RWF</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="amount-box amount-box-green">
                                <div class="small text-muted">Terra Commission</div>
                                <div class="fs-5 fw-bold" style="color:var(--green);">
                                    {{ number_format($serviceReport->terra_commission_amount) }} RWF
                                </div>
                                <div class="small text-muted mt-1">
                                    {{ $serviceReport->commission_type === 'fixed'
                                        ? number_format($serviceReport->commission_value) . ' RWF fixed'
                                        : $serviceReport->commission_value . '% rate' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="amount-box">
                                <div class="small text-muted">Consultant Receives</div>
                                <div class="fs-5 fw-bold">{{ number_format($serviceReport->consultant_amount) }} RWF</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar: status / review --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold">Review Status</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="detail-label">Submitted</div>
                        <div class="detail-value fw-normal">{{ $serviceReport->created_at->format('d M Y, H:i') }}</div>
                    </div>

                    @if ($serviceReport->status !== 'pending')
                        <div class="mb-3">
                            <div class="detail-label">Reviewed By</div>
                            <div class="detail-value fw-normal">
                                {{ $serviceReport->reviewer?->name ?? '—' }}
                                <div class="small text-muted">{{ $serviceReport->reviewed_at?->format('d M Y, H:i') }}</div>
                            </div>
                        </div>

                        @if ($serviceReport->admin_notes)
                            <div class="mb-3">
                                <div class="detail-label">Admin Notes</div>
                                <div class="detail-value fw-normal">{{ $serviceReport->admin_notes }}</div>
                            </div>
                        @endif
                    @endif

                    @if ($serviceReport->status === 'pending')
                        <hr>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-approve"
                                data-bs-toggle="modal"
                                data-bs-target="#reviewModal"
                                data-action="approved"
                                data-title="Approve Service Report"
                                data-btn-label="Approve Report"
                                data-btn-class="btn-approve">
                                <i class="ti ti-check"></i> Approve
                            </button>
                            <button type="button" class="btn btn-reject"
                                data-bs-toggle="modal"
                                data-bs-target="#reviewModal"
                                data-action="rejected"
                                data-title="Reject Service Report"
                                data-btn-label="Reject Report"
                                data-btn-class="btn-reject">
                                <i class="ti ti-x"></i> Reject
                            </button>
                        </div>
                    @else
                        <hr>
                        <button type="button" class="btn btn-outline-secondary w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#reviewModal"
                            data-action="{{ $serviceReport->status === 'approved' ? 'rejected' : 'approved' }}"
                            data-title="Change Decision"
                            data-btn-label="Update Status"
                            data-btn-class="{{ $serviceReport->status === 'approved' ? 'btn-reject' : 'btn-approve' }}">
                            <i class="ti ti-refresh"></i> Change Decision
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Approve / Reject Modal --}}
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.service-reports.update-status', $serviceReport) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" id="modalStatusInput" value="">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleText">Review Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="summary-box mb-3">
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Client</span>
                                <span class="fw-medium text-dark">{{ $serviceReport->client_name }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mt-1">
                                <span>Service</span>
                                <span class="fw-medium text-dark">{{ $serviceReport->service->title }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mt-1">
                                <span>Terra Commission</span>
                                <span class="fw-medium" style="color:var(--green);">
                                    {{ number_format($serviceReport->terra_commission_amount) }} RWF
                                </span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mt-1">
                                <span>Consultant Amount</span>
                                <span class="fw-medium text-dark">
                                    {{ number_format($serviceReport->consultant_amount) }} RWF
                                </span>
                            </div>
                        </div>

                        <label class="form-label">Admin Notes <span class="text-muted small">(optional)</span></label>
                        <textarea name="admin_notes" class="form-control" rows="3"
                            placeholder="Add a reason or comment for this decision...">{{ old('admin_notes') }}</textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" id="modalSubmitBtn">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
.service-report-show .detail-label {
    font-size: .75rem;
    text-transform: uppercase;
    letter-spacing: .03em;
    color: #94a3b8;
    margin-bottom: 2px;
}
.service-report-show .detail-value {
    font-size: .95rem;
    font-weight: 600;
    color: #1e293b;
}
.service-report-show .amount-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 14px 16px;
}
.service-report-show .amount-box-green {
    background: #f2fbf7;
    border-color: rgba(0,166,103,.25);
}
.service-report-show .summary-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 14px;
}
.status-badge { font-size: .8rem; padding: 6px 12px; border-radius: 20px; }
.status-pending  { background:#fff7e6; color:#b45309; }
.status-approved { background:#e9f9f1; color:#00a667; }
.status-rejected { background:#fdeceb; color:#c0392b; }

.btn-approve {
    background: var(--green);
    color: #fff;
    border: none;
}
.btn-approve:hover { background:#00925a; color:#fff; }

.btn-reject {
    background: #fdeceb;
    color: #c0392b;
    border: none;
}
.btn-reject:hover { background:#f8d7d5; color:#c0392b; }
</style>
@endsection

@push('scripts')
<script>
    const reviewModal = document.getElementById('reviewModal');

    reviewModal.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;

        const action = trigger.getAttribute('data-action');
        const title = trigger.getAttribute('data-title');
        const btnLabel = trigger.getAttribute('data-btn-label');
        const btnClass = trigger.getAttribute('data-btn-class');

        document.getElementById('modalStatusInput').value = action;
        document.getElementById('modalTitleText').textContent = title;

        const submitBtn = document.getElementById('modalSubmitBtn');
        submitBtn.textContent = btnLabel;
        submitBtn.className = 'btn text-white ' + btnClass;
    });
</script>
@endpush