{{-- resources/views/admin/service-reports/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container-fluid" style="--green:#00a667;">
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="small text-muted">Total Amount Reported</div>
                    <div class="fs-4 fw-bold">{{ number_format($totals['total_amount']) }} RWF</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="small text-muted">Terra Commission</div>
                    <div class="fs-4 fw-bold" style="color:var(--green);">{{ number_format($totals['terra_commission']) }} RWF</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="small text-muted">Paid to Consultants</div>
                    <div class="fs-4 fw-bold">{{ number_format($totals['consultant_paid']) }} RWF</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="small text-muted">Pending Review</div>
                    <div class="fs-4 fw-bold text-warning">{{ $totals['pending_count'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <form method="GET" class="row g-2 align-items-center">
                <div class="col-auto">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-auto">
                    <input type="date" name="from" class="form-control form-control-sm" value="{{ request('from') }}">
                </div>
                <div class="col-auto">
                    <input type="date" name="to" class="form-control form-control-sm" value="{{ request('to') }}">
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-outline-secondary">Filter</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Consultant</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Date / Time</th>
                        <th>Amount</th>
                        <th>Terra</th>
                        <th>Consultant</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($reports as $report)
                    <tr>
                        <td>{{ $report->consultant->name }}</td>
                        <td>{{ $report->client_name }}<br><span class="small text-muted">{{ $report->client_phone }}</span></td>
                        <td>{{ $report->service->title }}</td>
                        <td>{{ $report->service_date->format('d M Y') }} {{ \Carbon\Carbon::parse($report->service_time)->format('H:i') }}</td>
                        <td>{{ number_format($report->amount) }}</td>
                        <td style="color:var(--green);font-weight:600;">{{ number_format($report->terra_commission_amount) }}</td>
                        <td>{{ number_format($report->consultant_amount) }}</td>
                        <td>
                            <span class="badge bg-{{ $report->status === 'approved' ? 'success' : ($report->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.service-reports.show', $report) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">No service reports yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection