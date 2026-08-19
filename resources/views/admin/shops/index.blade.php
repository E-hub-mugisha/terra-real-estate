@extends('layouts.app')
@section('title', 'Shops')
@section('content')

<div class="shops-index">

    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-0 page-title">Shops</h1>
            <p class="text-muted small mt-1 mb-0">{{ $shops->total() }} {{ Str::plural('shop', $shops->total()) }} registered</p>
        </div>

        <a href="{{ route('admin.shops.create') }}" class="btn d-flex align-items-center gap-2 fw-semibold create-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:16px;height:16px">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Add Shop
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="d-flex flex-wrap gap-2 mb-4 filter-form">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by shop name"
            class="form-control form-control-sm filter-input" style="width: 240px;">

        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm filter-input" style="width: auto;">
            <option value="">All statuses</option>
            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
            <option value="approved" @selected(request('status') === 'approved')>Approved</option>
            <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
            <option value="suspended" @selected(request('status') === 'suspended')>Suspended</option>
        </select>

        <button type="submit" class="btn btn-sm fw-medium filter-btn">Filter</button>

        @if (request('q') || request('status'))
        <a href="{{ route('admin.shops.index') }}" class="btn btn-sm fw-medium clear-btn">Clear</a>
        @endif
    </form>

    {{-- Table --}}
    <div class="table-card">
        @if ($shops->isEmpty())
        <div class="text-center py-5 text-muted">
            No shops found.
        </div>
        @else
        <div class="table-responsive">
            <table class="table align-middle mb-0 shops-table">
                <thead>
                    <tr>
                        <th style="width:64px;"></th>
                        <th>Shop</th>
                        <th>Owner</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th class="text-center">Featured</th>
                        <th class="text-end">Views</th>
                        <th>Registered</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shops as $shop)
                    <tr>
                        <td>
                            <div class="shop-avatar">
                                @if ($shop->logo)
                                <img src="{{ asset('image/shops/logos/' . $shop->logo) }}" alt="{{ $shop->name }}">
                                @else
                                <span>{{ Str::substr($shop->name, 0, 1) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.shops.show', $shop->id) }}" class="fw-medium shop-name-link text-decoration-none">
                                {{ $shop->name }}
                            </a>
                            <div class="text-muted small">{{ $shop->slug }}</div>
                        </td>
                        <td>
                            <div class="small">{{ $shop->user->name ?? '—' }}</div>
                            <div class="text-muted" style="font-size:.72rem;">{{ $shop->phone }}</div>
                        </td>
                        <td class="small text-muted">
                            {{ $shop->district }}{{ $shop->district && $shop->province ? ', ' : '' }}{{ $shop->province }}
                        </td>
                        <td>
                            <span @class([ 'badge status-badge' , 'status-approved'=> $shop->status === 'approved',
                                'status-pending' => $shop->status === 'pending',
                                'status-rejected' => $shop->status === 'rejected',
                                'status-suspended' => $shop->status === 'suspended',
                                ])>
                                {{ ucfirst($shop->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if ($shop->is_featured)
                            <svg viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px;color:#D05208">
                                <path d="M12 2l2.9 6.6 7.1.6-5.4 4.7 1.7 7-6.3-3.8L5.7 21l1.7-7-5.4-4.7 7.1-.6z"/>
                            </svg>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-end small text-muted">{{ number_format($shop->views_count) }}</td>
                        <td class="small text-muted">{{ $shop->created_at->format('M j, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.shops.show', $shop->id) }}" class="btn btn-sm view-btn">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-3 pagination-wrap">
            {{ $shops->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    :root {
        --navy-dark: #111a45;
        --navy: #19265d;
        --gold: #D05208;
        --gold-light: #fff3e9;
        --font-heading: 'Cormorant Garamond', serif;
        --font-body: 'DM Sans', sans-serif;
    }

    .shops-index {
        font-family: var(--font-body);
        color: var(--navy-dark);
    }

    .page-title {
        font-family: var(--font-heading);
        color: var(--navy-dark);
        font-size: 1.9rem;
    }

    .create-btn {
        background-color: var(--gold);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: .5rem 1.1rem;
        transition: background-color .15s ease;
    }

    .create-btn:hover {
        background-color: #b34606;
        color: #fff;
    }

    .filter-input {
        border: 1px solid #e2e5ee;
        border-radius: 8px;
    }

    .filter-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .12);
    }

    .filter-btn {
        background-color: var(--navy);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: .25rem 1rem;
        transition: background-color .15s ease;
    }

    .filter-btn:hover {
        background-color: var(--navy-dark);
        color: #fff;
    }

    .clear-btn {
        background-color: #fff;
        color: #6b7280;
        border: 1px solid #e2e5ee;
        border-radius: 8px;
        padding: .25rem 1rem;
    }

    .clear-btn:hover {
        border-color: var(--navy);
        color: var(--navy);
    }

    .table-card {
        background: #fff;
        border: 1px solid #eef0f5;
        border-radius: 14px;
        box-shadow: 0 6px 24px rgba(17, 26, 69, .06);
        overflow: hidden;
    }

    .shops-table thead th {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #6b7280;
        border-bottom: 1px solid #eef0f5;
        padding: .9rem 1rem;
        background-color: #fafbfd;
    }

    .shops-table tbody td {
        padding: .8rem 1rem;
        border-bottom: 1px solid #f3f4f8;
    }

    .shops-table tbody tr:last-child td {
        border-bottom: none;
    }

    .shops-table tbody tr:hover {
        background-color: #fafbfd;
    }

    .shop-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        overflow: hidden;
        background-color: var(--gold-light);
        color: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .9rem;
    }

    .shop-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .shop-name-link {
        color: var(--navy-dark);
    }

    .shop-name-link:hover {
        color: var(--gold);
    }

    .status-badge {
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03em;
        padding: .35rem .7rem;
    }

    .status-approved {
        background-color: #ecfdf3;
        color: #15803d;
    }

    .status-pending {
        background-color: #fffbeb;
        color: #b45309;
    }

    .status-rejected {
        background-color: #fef2f2;
        color: #b91c1c;
    }

    .status-suspended {
        background-color: #f3f4f6;
        color: #4b5563;
    }

    .view-btn {
        background-color: var(--gold-light);
        color: var(--gold);
        border: none;
        border-radius: 8px;
        font-size: .78rem;
        font-weight: 600;
        padding: .4rem .8rem;
        transition: background-color .15s ease, color .15s ease;
    }

    .view-btn:hover {
        background-color: var(--gold);
        color: #fff;
    }

    .pagination-wrap .page-link {
        color: var(--navy);
        border-color: #eef0f5;
    }

    .pagination-wrap .page-link:hover {
        color: var(--gold);
        background-color: var(--gold-light);
    }

    .pagination-wrap .page-item.active .page-link {
        background-color: var(--gold);
        border-color: var(--gold);
    }
</style>

@once
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@endonce

@endsection