@extends('layouts.app')
@section('title', 'Consultant Bookings – Admin')

@section('content')


<style>
    .stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 20px;
        min-width: 100px;
        text-align: center;
    }

    .stat-num {
        font-size: 24px;
        font-weight: 700;
    }

    .stat-label {
        font-size: 13px;
        color: #6b7280;
    }

    .btn-terra {
        background: #1D9E75;
        color: #fff;
        border: none;
    }

    .btn-terra:hover {
        background: #0F6E56;
        color: #fff;
    }
</style>

<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h4 class="mb-0 fw-600">Consultant Bookings</h4>
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name / ref / email…" value="{{ request('search') }}" style="width:220px;">
            <select name="status" class="form-select form-select-sm" style="width:150px;">
                <option value="">All statuses</option>
                <option value="pending" {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="rejected" {{ request('status') === 'rejected'  ? 'selected' : '' }}>Rejected</option>
            </select>
            <button class="btn btn-sm btn-terra">Filter</button>
        </form>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-auto">
            <div class="stat-card">
                <div class="stat-num text-warning">{{ $counts['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-auto">
            <div class="stat-card">
                <div class="stat-num text-success">{{ $counts['confirmed'] }}</div>
                <div class="stat-label">Confirmed</div>
            </div>
        </div>
        <div class="col-auto">
            <div class="stat-card">
                <div class="stat-num text-danger">{{ $counts['rejected'] }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Reference</th>
                    <th>Client</th>
                    <th>Consultant</th>
                    <th>Service</th>
                    <th>District</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td><code>{{ $b->reference }}</code></td>
                    <td>
                        <div>{{ $b->client_name }}</div>
                        <div style="font-size:12px;color:#6b7280;">{{ $b->client_email }}</div>
                    </td>
                    <td>{{ $b->consultant->name }}</td>
                    <td>{{ $b->service_label }}</td>
                    <td>{{ $b->district }}</td>
                    <td>{{ $b->appointment_date?->format('d M Y') ?? '—' }}</td>
                    <td>
                        <span class="badge {{ $b->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($b->payment_status) }}
                        </span>
                    </td>
                    <td>
                        @if($b->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($b->status === 'confirmed')
                        <span class="badge bg-success">Confirmed</span>
                        @elseif($b->status === 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-outline-secondary">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $bookings->withQueryString()->links() }}

</div>
@endsection