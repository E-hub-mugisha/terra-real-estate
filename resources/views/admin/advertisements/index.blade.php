@extends('layouts.app')
@section('title', 'Manage Advertisements')

@section('content')
<div class="container-fluid py-4">
<!-- create button -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Manage Advertisements</h3>
        <a href="{{ route('advertisements.create') }}" class="btn btn-primary">Create Advertisement</a>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        @php
        $statCards = [
            ['label'=>'Pending Review','value'=>$counts['pending_review'],'color'=>'#f59e0b','icon'=>'bi-clock-history'],
            ['label'=>'Active Ads',    'value'=>$counts['active'],        'color'=>'#10b981','icon'=>'bi-megaphone'],
            ['label'=>'Total Ads',     'value'=>$counts['total'],         'color'=>'#19265d','icon'=>'bi-collection'],
        ];
        @endphp
        @foreach($statCards as $s)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius:12px">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:48px;height:48px;background:{{ $s['color'] }}22">
                        <i class="bi {{ $s['icon'] }} fs-4" style="color:{{ $s['color'] }}"></i>
                    </div>
                    <div>
                        <div class="text-muted small">{{ $s['label'] }}</div>
                        <div class="fw-bold fs-4" style="color:{{ $s['color'] }}">{{ $s['value'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search title or user…" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                @foreach(['draft','pending_review','active','paused','expired','rejected'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="payment_status" class="form-select">
                <option value="">All Payment Statuses</option>
                @foreach(['pending','confirmed','rejected'] as $s)
                    <option value="{{ $s }}" {{ request('payment_status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn w-100" style="background:#19265d;color:#fff">Filter</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#f8f9ff">
                    <tr class="small text-uppercase text-muted">
                        <th>#ID</th>
                        <th>User</th>
                        <th>Title</th>
                        <th>Package</th>
                        <th>Days</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ads as $ad)
                    <tr>
                        <td class="text-muted small">#{{ $ad->id }}</td>
                        <td>
                            <div class="fw-semibold small">{{ $ad->user->name }}</div>
                            <div class="text-muted" style="font-size:.75rem">{{ $ad->user->email }}</div>
                        </td>
                        <td class="small">{{ Str::limit($ad->title, 35) }}</td>
                        <td class="small">{{ $ad->listingPackage?->tier_label ?? '—' }}</td>
                        <td class="small">{{ $ad->listing_days }}d</td>
                        <td class="small fw-semibold" style="color:#D05208">{{ $ad->formatted_total }}</td>
                        <td>
                            @php $pb = $ad->payment_badge @endphp
                            <span class="badge bg-{{ str_replace('badge-','',$pb['class']) }}">{{ $pb['label'] }}</span>
                        </td>
                        <td>
                            @php $sb = $ad->status_badge @endphp
                            <span class="badge bg-{{ str_replace('badge-','',$sb['class']) }}">{{ $sb['label'] }}</span>
                        </td>
                        <td class="small text-muted">
                            {{ $ad->payment_submitted_at?->format('d M Y') ?? '—' }}
                        </td>
                        <td>
                            <a href="{{ route('admin.advertisements.show', $ad) }}" class="btn btn-sm btn-outline-primary">Review</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="text-center text-muted py-4">No advertisements found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $ads->links() }}</div>
</div>
@endsection