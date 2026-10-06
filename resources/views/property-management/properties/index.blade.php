@extends('layouts.property-management')

@section('title', 'Properties')
@section('page-title', 'Properties')
@section('page-subtitle', 'Properties registered for management')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('property-management.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Properties</li>
@endsection

@section('page-actions')
    <a href="{{ route('property-management.properties.create') }}" class="btn btn-terra">
        <i class="bi bi-plus-lg me-1"></i> Add Property
    </a>
@endsection

@push('styles')
<style>
    .prop-cell { display: flex; align-items: center; gap: 12px; min-width: 240px; }

    .prop-icon {
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 10px;
        background: var(--terra-orange-soft);
        color: var(--terra-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .prop-title {
        font-weight: 600;
        color: var(--terra-navy);
        line-height: 1.3;
    }

    a.prop-title:hover { color: var(--terra-orange); }

    .prop-sub {
        font-size: 12.5px;
        color: var(--terra-muted);
        line-height: 1.4;
    }

    .prop-price { font-weight: 700; color: var(--terra-navy); white-space: nowrap; font-variant-numeric: tabular-nums; }

    .prop-tag {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 6px;
        background: var(--terra-light);
        color: var(--terra-navy);
        border: 1px solid var(--terra-border);
    }

    .prop-tag.rent { background: rgba(29, 78, 216, .08); color: var(--terra-info); border-color: transparent; }
    .prop-tag.sale { background: var(--terra-orange-soft); color: var(--terra-orange-dark); border-color: transparent; }

    .prop-buildings {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
        color: var(--terra-navy);
    }

    .prop-buildings i { color: var(--terra-muted); }

    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid var(--terra-border);
        background: #fff;
        color: var(--terra-navy);
        transition: all .2s ease;
    }

    .action-btn:hover { border-color: var(--terra-orange); color: var(--terra-orange); }

    /* Mobile: turn rows into stacked cards */
    @media (max-width: 767.98px) {
        .prop-table thead { display: none; }

        .prop-table, .prop-table tbody, .prop-table tr, .prop-table td { display: block; width: 100%; }

        .prop-table tr {
            padding: 14px 16px;
            border-bottom: 1px solid var(--terra-border);
        }

        .prop-table tbody td {
            border: 0;
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .prop-table tbody td[data-label]::before {
            content: attr(data-label);
            font-size: 12px;
            font-weight: 600;
            color: var(--terra-muted);
        }

        .prop-table tbody td.prop-main { display: block; padding-bottom: 10px; }
        .prop-table tbody td.prop-actions { justify-content: flex-end; padding-top: 10px; }
    }
</style>
@endpush

@section('content')

@php
    $statusBadge = [
        'active'    => 'badge-active',
        'available' => 'badge-active',
        'approved'  => 'badge-active',
        'pending'   => 'badge-pending',
        'draft'     => 'badge-pending',
        'sold'      => 'badge-info-soft',
        'rented'    => 'badge-info-soft',
        'inactive'  => 'badge-danger-soft',
        'rejected'  => 'badge-danger-soft',
        'expired'   => 'badge-danger-soft',
    ];

    $badgeFor = fn ($value) => $statusBadge[strtolower((string) $value)] ?? 'badge-terra';
@endphp

{{-- ==============================
     SUMMARY (optional: pass $stats from controller)
============================== --}}
@isset($stats)
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="terra-stat-card">
            <div class="terra-stat-label">Total properties</div>
            <div class="terra-stat-value">{{ number_format($stats['total'] ?? $properties->total()) }}</div>
            <div class="terra-stat-icon is-navy"><i class="bi bi-buildings"></i></div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="terra-stat-card">
            <div class="terra-stat-label">Under management</div>
            <div class="terra-stat-value">{{ number_format($stats['managed'] ?? 0) }}</div>
            <div class="terra-stat-icon is-success"><i class="bi bi-shield-check"></i></div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="terra-stat-card">
            <div class="terra-stat-label">Not managed</div>
            <div class="terra-stat-value">{{ number_format($stats['unmanaged'] ?? 0) }}</div>
            <div class="terra-stat-icon"><i class="bi bi-dash-circle"></i></div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="terra-stat-card">
            <div class="terra-stat-label">Buildings</div>
            <div class="terra-stat-value">{{ number_format($stats['buildings'] ?? 0) }}</div>
            <div class="terra-stat-icon is-info"><i class="bi bi-building"></i></div>
        </div>
    </div>
</div>
@endisset


{{-- ==============================
     TABLE
============================== --}}
<div class="terra-card">

    <div class="terra-card-header">
        <h5>All properties</h5>
        <span class="text-muted small">
            {{ $properties->total() }} {{ \Illuminate\Support\Str::plural('property', $properties->total()) }}
        </span>
    </div>

    {{-- Filters (work with GET query; see controller note) --}}
    <form method="GET" action="{{ route('property-management.properties.index') }}" class="terra-filter-bar">

        <div class="flex-grow-1" style="min-width: 220px; max-width: 360px;">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="search" name="search" value="{{ request('search') }}"
                    class="form-control border-start-0"
                    placeholder="Search title, UPI, district or sector" aria-label="Search properties">
            </div>
        </div>

        <select name="listing_type" class="form-select w-auto" aria-label="Listing type">
            <option value="">All listings</option>
            <option value="rent" @selected(request('listing_type') === 'rent')>For rent</option>
            <option value="sale" @selected(request('listing_type') === 'sale')>For sale</option>
        </select>

        <select name="managed" class="form-select w-auto" aria-label="Management">
            <option value="">All management</option>
            <option value="1" @selected(request('managed') === '1')>Managed</option>
            <option value="0" @selected(request('managed') === '0')>Not managed</option>
        </select>

        <button type="submit" class="btn btn-terra-navy">
            <i class="bi bi-funnel me-1"></i> Filter
        </button>

        @if(request()->hasAny(['search', 'listing_type', 'managed']))
            <a href="{{ route('property-management.properties.index') }}" class="btn btn-link text-muted">
                Clear
            </a>
        @endif

    </form>

    @if($properties->count())

    <div class="table-responsive">
        <table class="table terra-table prop-table table-hover align-middle">

            <thead>
                <tr>
                    <th>Property</th>
                    <th>Location</th>
                    <th>Listing</th>
                    <th>Price</th>
                    <th>Buildings</th>
                    <th>Management</th>
                    <th>Status</th>
                    <th>Expires</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
            @foreach($properties as $property)

                @php
                    $location = collect([$property->village, $property->cell, $property->sector, $property->district])
                        ->filter()->implode(', ');

                    $isRent = $property->isForRent();

                    $expired  = $property->expires_at && $property->expires_at->isPast();
                    $expiring = $property->expires_at && !$expired && $property->expires_at->diffInDays(now()) <= 30;
                @endphp

                <tr>

                    {{-- Property --}}
                    <td class="prop-main">
                        <div class="prop-cell">
                            <div class="prop-icon">
                                <i class="bi bi-{{ $property->buildings_count > 1 ? 'buildings' : 'house-door' }}"></i>
                            </div>

                            <div class="min-w-0">
                                <a href="{{ route('property-management.properties.show', $property) }}"
                                   class="prop-title d-block">
                                    {{ $property->title }}
                                </a>

                                <div class="prop-sub">
                                    {{ ucfirst($property->type) }}
                                    @if($property->property_category)
                                        &middot; {{ ucfirst($property->property_category) }}
                                    @endif
                                </div>

                                @if($property->upi_reference)
                                    <div class="prop-sub">UPI {{ $property->upi_reference }}</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Location --}}
                    <td data-label="Location">
                        <div>
                            <div>{{ $property->sector }}{{ $property->sector && $property->district ? ',' : '' }} {{ $property->district }}</div>
                            @if($property->address)
                                <div class="prop-sub">{{ \Illuminate\Support\Str::limit($property->address, 38) }}</div>
                            @endif
                        </div>
                    </td>

                    {{-- Listing --}}
                    <td data-label="Listing">
                        <span class="prop-tag {{ $isRent ? 'rent' : 'sale' }}">
                            {{ $isRent ? 'For rent' : ucfirst($property->listing_type ?? '—') }}
                        </span>
                    </td>

                    {{-- Price --}}
                    <td data-label="Price">
                        <span class="prop-price">
                            RWF {{ number_format($property->price) }}
                        </span>
                        @if($isRent)
                            <span class="prop-sub">/ month</span>
                        @endif
                    </td>

                    {{-- Buildings --}}
                    <td data-label="Buildings">
                        <span class="prop-buildings">
                            <i class="bi bi-building"></i>
                            {{ $property->buildings_count }}
                        </span>
                    </td>

                    {{-- Management --}}
                    <td data-label="Management">
                        @if($property->isManaged())
                            <span class="badge badge-active">Managed</span>
                        @else
                            <span class="badge badge-pending">Not managed</span>
                        @endif

                        @if($property->management_status)
                            <div class="prop-sub mt-1">{{ ucfirst(str_replace('_', ' ', $property->management_status)) }}</div>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td data-label="Status">
                        <div class="d-flex flex-column align-items-end align-items-md-start gap-1">
                            @if($property->status)
                                <span class="badge {{ $badgeFor($property->status) }}">
                                    {{ ucfirst(str_replace('_', ' ', $property->status)) }}
                                </span>
                            @endif

                            @unless($property->is_approved)
                                <span class="badge badge-pending">Awaiting approval</span>
                            @endunless
                        </div>
                    </td>

                    {{-- Expires --}}
                    <td data-label="Expires">
                        @if($property->expires_at)
                            <span class="{{ $expired ? 'text-danger' : ($expiring ? 'text-warning-emphasis' : '') }}">
                                {{ $property->expires_at->format('d M Y') }}
                            </span>
                            @if($expired)
                                <div class="prop-sub text-danger">Expired</div>
                            @elseif($expiring)
                                <div class="prop-sub">In {{ $property->expires_at->diffInDays(now()) }} days</div>
                            @endif
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="text-end prop-actions">
                        <a href="{{ route('property-management.properties.show', $property) }}"
                           class="btn btn-sm btn-terra-outline">
                            Manage
                        </a>
                    </td>

                </tr>

            @endforeach
            </tbody>

        </table>
    </div>

    @if($properties->hasPages())
        <div class="terra-card-footer d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div class="text-muted small">
                Showing {{ $properties->firstItem() }}–{{ $properties->lastItem() }} of {{ $properties->total() }}
            </div>

            {{ $properties->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    @endif

    @else

    <div class="terra-empty">
        <i class="bi bi-buildings"></i>
        <h6>No properties found</h6>
        <p class="mb-3">
            @if(request()->hasAny(['search', 'listing_type', 'managed']))
                No property matches your filters. Try changing or clearing them.
            @else
                You don't have any properties registered under your account yet.
            @endif
        </p>
        <a href="{{ route('property-management.properties.create') }}" class="btn btn-terra">
            <i class="bi bi-plus-lg me-1"></i> Add your first property
        </a>
    </div>

    @endif

</div>

@endsection