@extends('layouts.app')
@section('title', 'Job Listings')

@section('content')

<div class="container py-5">

    {{-- Header ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:var(--terra-navy)">Job Listings</h1>
            <p class="text-muted mb-0" style="font-size:.9rem">Manage all company job announcements</p>
        </div>
        <a href="{{ route('admin.job-listings.create') }}" class="btn btn-outline-primary btn-sm">
            Add Job ↗
        </a>
        <a href="{{ route('front.jobs.index') }}" target="_blank" class="btn btn-outline-secondary btn-sm">
            View Public Board ↗
        </a>
    </div>

    {{-- Stats row ── --}}
    <div class="row g-3 mb-4">
        @php
        $statCards = [
            ['label' => 'Total',    'value' => $stats['total'],   'color' => 'var(--terra-navy)',   'icon' => 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z'],
            ['label' => 'Active',   'value' => $stats['active'],  'color' => '#2E7D32',             'icon' => 'M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z'],
            ['label' => 'Pending',  'value' => $stats['pending'], 'color' => '#F57F17',             'icon' => 'M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z'],
            ['label' => 'Expired',  'value' => $stats['expired'], 'color' => '#C62828',             'icon' => 'M12 2a10 10 0 100 20A10 10 0 0012 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z'],
            ['label' => 'Revenue',  'value' => number_format($stats['revenue']) . ' RWF', 'color' => 'var(--terra-orange)', 'icon' => 'M21 18v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1h-9a2 2 0 00-2 2v8a2 2 0 002 2h9zm-9-2h10V8H12v8zm4-2.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z'],
        ];
        @endphp

        @foreach($statCards as $stat)
        <div class="col-xl col-md-4 col-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:40px;height:40px;border-radius:10px;background:{{ $stat['color'] }}18;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="{{ $stat['color'] }}">
                                <path d="{{ $stat['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size:.72rem;color:#7A736B;text-transform:uppercase;letter-spacing:.05em">{{ $stat['label'] }}</div>
                            <div style="font-size:1.1rem;font-weight:700;color:var(--terra-navy)">{{ $stat['value'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Flash ── --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filter form ── --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control form-control-sm" style="max-width:220px" placeholder="Search title or company…">

                <select name="status" class="form-select form-select-sm" style="max-width:160px">
                    <option value="">All Statuses</option>
                    @foreach(['draft','pending_payment','active','expired','rejected','paused'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $s)) }}
                    </option>
                    @endforeach
                </select>

                <select name="payment" class="form-select form-select-sm" style="max-width:160px">
                    <option value="">All Payments</option>
                    <option value="pending" {{ request('payment') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid"    {{ request('payment') === 'paid'    ? 'selected' : '' }}>Paid</option>
                    <option value="failed"  {{ request('payment') === 'failed'  ? 'selected' : '' }}>Failed</option>
                </select>

                <button type="submit" class="btn btn-sm btn-dark">Filter</button>
                <a href="{{ route('admin.job-listings.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </form>
        </div>
    </div>

    {{-- Table ── --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" style="font-size:.85rem">
                    <thead>
                        <tr style="background:#F7F5F2;border-bottom:2px solid #E8E3DC">
                            <th class="px-4 py-3 fw-semibold" style="color:var(--terra-navy)">Job / Company</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Type</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Package</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Amount</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Payment</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Status</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Expires</th>
                            <th class="py-3 fw-semibold" style="color:var(--terra-navy)">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jobs as $job)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-semibold" style="color:var(--terra-navy)">{{ Str::limit($job->title, 40) }}</div>
                                <div style="font-size:.78rem;color:#7A736B">{{ $job->company_name }} · {{ $job->company_email }}</div>
                            </td>

                            <td class="py-3">
                                <span style="font-size:.75rem;font-weight:600;padding:3px 8px;border-radius:20px;background:#EBF5FB;color:#1a5276">
                                    {{ $job->job_type_label }}
                                </span>
                            </td>

                            <td class="py-3">
                                <div style="font-size:.82rem;font-weight:600;color:var(--terra-navy)">{{ $job->package?->tier_label }}</div>
                                <div style="font-size:.75rem;color:#7A736B">{{ $job->days_purchased }}d</div>
                            </td>

                            <td class="py-3">
                                <div style="font-weight:700;color:var(--terra-orange)">{{ number_format($job->total_amount) }}</div>
                                <div style="font-size:.72rem;color:#7A736B">RWF</div>
                            </td>

                            <td class="py-3">
                                @php
                                $payColors = ['pending'=>['#F57F17','#FFF8E1'],'paid'=>['#2E7D32','#E8F5E9'],'failed'=>['#C62828','#FFEBEE']];
                                [$pc,$pb] = $payColors[$job->payment_status] ?? ['#7A736B','#F5F5F5'];
                                @endphp
                                <span style="font-size:.72rem;font-weight:700;padding:3px 8px;border-radius:20px;background:{{ $pb }};color:{{ $pc }}">
                                    {{ ucfirst($job->payment_status) }}
                                </span>
                            </td>

                            <td class="py-3">
                                @php
                                $stColors = ['draft'=>['#7A736B','#F5F5F5'],'pending_payment'=>['#F57F17','#FFF8E1'],'active'=>['#2E7D32','#E8F5E9'],'expired'=>['#C62828','#FFEBEE'],'rejected'=>['#C62828','#FFEBEE'],'paused'=>['#7A736B','#F5F5F5']];
                                [$sc,$sb] = $stColors[$job->status] ?? ['#7A736B','#F5F5F5'];
                                @endphp
                                <span style="font-size:.72rem;font-weight:700;padding:3px 8px;border-radius:20px;background:{{ $sb }};color:{{ $sc }}">
                                    {{ ucwords(str_replace('_',' ',$job->status)) }}
                                </span>
                            </td>

                            <td class="py-3" style="font-size:.82rem;color:#7A736B">
                                @if($job->expires_at)
                                    <div>{{ $job->expires_at->format('d M Y') }}</div>
                                    @if($job->status === 'active')
                                    <div style="font-size:.72rem;color:{{ $job->days_remaining <= 3 ? '#C62828' : '#2E7D32' }}">
                                        {{ $job->days_remaining }}d left
                                    </div>
                                    @endif
                                @else
                                    <span style="color:#E8E3DC">—</span>
                                @endif
                            </td>

                            <td class="py-3 pe-3">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.job-listings.show', $job) }}"
                                        class="btn btn-sm btn-outline-secondary" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 11c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4z"/>
                                            <circle cx="12" cy="12" r="2"/>
                                        </svg>
                                    </a>

                                    @if($job->payment_status !== 'paid')
                                    <button class="btn btn-sm btn-success" title="Activate"
                                        onclick="openActivate({{ $job->id }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                        </svg>
                                    </button>
                                    @endif

                                    @if($job->status === 'active')
                                    <form method="POST" action="{{ route('admin.job-listings.expire', $job) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning" title="Force Expire"
                                            onclick="return confirm('Force expire this listing?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.job-listings.destroy', $job) }}" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                            onclick="return confirm('Delete this job listing permanently?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No job listings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination ── --}}
    <div class="mt-4">
        {{ $jobs->links() }}
    </div>

</div>

{{-- Activate Modal ── --}}
<div class="modal fade" id="activateModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" style="color:var(--terra-navy)">Manually Activate Listing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="activate-form">
                @csrf
                <div class="modal-body pt-3">
                    <p style="font-size:.85rem;color:#7A736B">
                        Enter the offline payment details to activate this listing immediately.
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.82rem">Payment Reference <span class="text-danger">*</span></label>
                        <input type="text" name="payment_reference" class="form-control" required
                            placeholder="e.g. MTN-123456789">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.82rem">Payment Method <span class="text-danger">*</span></label>
                        <select name="payment_method" class="form-select" required>
                            <option value="">— Select —</option>
                            <option value="momo">MTN MoMo</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm px-4">Activate Listing</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openActivate(id) {
    document.getElementById('activate-form').action = `/admin/job-listings/${id}/activate`;
    new bootstrap.Modal(document.getElementById('activateModal')).show();
}
</script>

@endsection
