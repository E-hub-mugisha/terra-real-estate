@extends('layouts.app')
@section('title', 'Consultant Bookings')

@section('content')

<style>
    :root {
        --accent: #00a667;
        --accent-light: #e6f7ef;
        --accent-dark: #007a4d;
        --ink: #1a1a1a;
        --muted: #6b7280;
        --border: #e5e7eb;
        --bg-soft: #f9fafb;
    }

    body { background: #f6f8f7; }

    .page-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem;
    }

    .page-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--ink);
    }

    .filter-input,
    .filter-select {
        border: 1px solid var(--border);
        border-radius: 8px;
    }
    .filter-input:focus,
    .filter-select:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-light);
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 14px 22px;
        min-width: 110px;
        text-align: center;
    }
    .stat-num { font-size: 24px; font-weight: 700; color: var(--ink); }
    .stat-label { font-size: 13px; color: var(--muted); margin-top: 2px; }

    .stat-pending .stat-num { color: #b45309; }
    .stat-confirmed .stat-num { color: var(--accent-dark); }
    .stat-rejected .stat-num { color: #b91c1c; }

    .btn-terra {
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
    }
    .btn-terra:hover { background: var(--accent-dark); color: #fff; }

    .alert-success {
        background: var(--accent-light);
        border: 1px solid #bbf0d9;
        color: var(--accent-dark);
        border-radius: 8px;
    }

    .table-wrap {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }

    table.terra-table {
        margin-bottom: 0;
    }
    table.terra-table thead th {
        background: var(--bg-soft);
        color: var(--muted);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: 1px solid var(--border);
        padding: 12px 16px;
    }
    table.terra-table tbody td {
        padding: 12px 16px;
        font-size: 14px;
        color: var(--ink);
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    table.terra-table tbody tr:last-child td { border-bottom: none; }
    table.terra-table tbody tr:hover { background: #fafcfb; }

    .ref-code {
        font-size: 12.5px;
        background: var(--bg-soft);
        border: 1px solid var(--border);
        padding: 2px 8px;
        border-radius: 6px;
        color: var(--ink);
    }

    .client-email { font-size: 12px; color: var(--muted); }

    .pill {
        display: inline-block;
        font-size: 12px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .pill-success { background: var(--accent-light); color: var(--accent-dark); }
    .pill-warning { background: #fef9c3; color: #854d0e; }
    .pill-danger  { background: #fee2e2; color: #b91c1c; }

    .btn-view {
        border: 1px solid var(--border);
        color: var(--muted);
        background: #fff;
        border-radius: 8px;
        font-size: 13px;
        padding: 5px 14px;
    }
    .btn-view:hover { border-color: var(--accent); color: var(--accent-dark); background: var(--accent-light); }
</style>

<div class="container-fluid py-4">

    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <h4 class="page-title mb-0">Consultant Bookings</h4>
        <form method="GET" class="d-flex gap-2 flex-wrap">
            <input type="text" name="search" class="form-control form-control-sm filter-input" placeholder="Search name / ref / email…" value="{{ request('search') }}" style="width:220px;">
            <select name="status" class="form-select form-select-sm filter-select" style="width:150px;">
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
            <div class="stat-card stat-pending">
                <div class="stat-num">{{ $counts['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="col-auto">
            <div class="stat-card stat-confirmed">
                <div class="stat-num">{{ $counts['confirmed'] }}</div>
                <div class="stat-label">Confirmed</div>
            </div>
        </div>
        <div class="col-auto">
            <div class="stat-card stat-rejected">
                <div class="stat-num">{{ $counts['rejected'] }}</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Table --}}
    <div class="table-wrap">
        <div class="table-responsive">
            <table class="table terra-table align-middle mb-0">
                <thead>
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
                        <td><span class="ref-code">{{ $b->reference }}</span></td>
                        <td>
                            <div>{{ $b->client_name }}</div>
                            <div class="client-email">{{ $b->client_email }}</div>
                        </td>
                        <td>{{ $b->consultant->name }}</td>
                        <td>{{ $b->service_label }}</td>
                        <td>{{ $b->district }}</td>
                        <td>{{ $b->appointment_date?->format('d M Y') ?? '—' }}</td>
                        <td>
                            <span class="pill {{ $b->payment_status === 'paid' ? 'pill-success' : 'pill-warning' }}">
                                {{ ucfirst($b->payment_status) }}
                            </span>
                        </td>
                        <td>
                            @if($b->status === 'pending')
                            <span class="pill pill-warning">Pending</span>
                            @elseif($b->status === 'confirmed')
                            <span class="pill pill-success">Confirmed</span>
                            @elseif($b->status === 'rejected')
                            <span class="pill pill-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.bookings.show', $b) }}" class="btn btn-sm btn-view">View</a>
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
    </div>

    <div class="mt-3">
        {{ $bookings->withQueryString()->links() }}
    </div>

</div>
@endsection