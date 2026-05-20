@extends('layouts.app')
@section('title', 'House Properties')
@section('content')

<style>
    .filter-bar {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 600;
        cursor: pointer;
        border: 1.5px solid transparent;
        transition: all .18s;
        white-space: nowrap;
        background: none;
    }

    .sp-all      { background:#f1f5f9;color:#475569;border-color:#e2e8f0; }
    .sp-for_sale { background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe; }
    .sp-for_rent { background:#f0fdf4;color:#166534;border-color:#bbf7d0; }
    .sp-sold     { background:#fdf4ff;color:#7e22ce;border-color:#e9d5ff; }
    .sp-inactive { background:#fef2f2;color:#dc2626;border-color:#fecaca; }
    .sp-active   { background:#f0fdf4;color:#166534;border-color:#bbf7d0; }
    .sp-pending  { background:#fffbeb;color:#92400e;border-color:#fde68a; }

    .stat-pill.on.sp-all      { background:#475569;color:#fff;border-color:#475569; }
    .stat-pill.on.sp-for_sale { background:#1d4ed8;color:#fff;border-color:#1d4ed8; }
    .stat-pill.on.sp-for_rent { background:#166534;color:#fff;border-color:#166534; }
    .stat-pill.on.sp-sold     { background:#7e22ce;color:#fff;border-color:#7e22ce; }
    .stat-pill.on.sp-inactive { background:#dc2626;color:#fff;border-color:#dc2626; }
    .stat-pill.on.sp-active   { background:#166534;color:#fff;border-color:#166534; }
    .stat-pill.on.sp-pending  { background:#92400e;color:#fff;border-color:#92400e; }

    .stat-pill .dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .search-wrap { position: relative; }
    .search-wrap svg {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%);
        width: 14px; height: 14px; color: #9ca3af; pointer-events: none;
    }
    .search-wrap input {
        padding: 7px 10px 7px 30px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px; font-size: .81rem; width: 220px;
        transition: border-color .18s;
    }
    .search-wrap input:focus { outline: none; border-color: #3b82f6; }

    .fsel {
        padding: 7px 28px 7px 10px;
        border: 1.5px solid #e5e7eb; border-radius: 8px;
        font-size: .81rem;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 8px center no-repeat;
        appearance: none; cursor: pointer;
    }
    .fsel:focus { outline: none; border-color: #3b82f6; }

    .table > :not(caption) > * > th,
    .table > :not(caption) > * > td { vertical-align: middle; font-size: .82rem; }
    .table thead th {
        font-size: .72rem; text-transform: uppercase;
        letter-spacing: .06em; font-weight: 600; white-space: nowrap;
    }

    .prop-img {
        width: 48px; height: 40px; border-radius: 7px;
        object-fit: cover; border: 1px solid #e5e7eb;
        flex-shrink: 0; background: #f1f5f9;
    }
    .prop-img-placeholder {
        width: 48px; height: 40px; border-radius: 7px;
        border: 1px solid #e5e7eb; background: #f1f5f9;
        display: grid; place-items: center; flex-shrink: 0;
    }
    .prop-img-placeholder svg { width: 16px; height: 16px; color: #cbd5e1; }

    .prop-title {
        font-weight: 600; font-size: .83rem; color: #1e293b;
        transition: color .15s; text-decoration: none; display: block;
    }
    .prop-title:hover { color: #2563eb; }
    .prop-sub { font-size: .72rem; color: #94a3b8; }

    .cond-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 5px;
        font-size: .67rem; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
    }
    .cond-badge::before {
        content: ''; width: 5px; height: 5px;
        border-radius: 50%; background: currentColor;
    }
    .cb-for_sale { background:#eff6ff;color:#1d4ed8; }
    .cb-for_rent { background:#f0fdf4;color:#166534; }
    .cb-sold     { background:#fdf4ff;color:#7e22ce; }
    .cb-inactive { background:#fef2f2;color:#dc2626; }

    .type-badge {
        display: inline-block; padding: 2px 7px; border-radius: 5px;
        font-size: .67rem; font-weight: 600;
        background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
    }

    .spec-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
    .spec-item {
        display: flex; align-items: center; gap: 3px;
        font-size: .75rem; color: #64748b; white-space: nowrap;
    }
    .spec-item svg { width: 11px; height: 11px; }

    .price-val { font-weight: 700; font-size: .85rem; color: #1e293b; }
    .price-unit { font-size: .68rem; color: #94a3b8; }

    .action-btn {
        width: 30px; height: 30px; border-radius: 7px;
        display: grid; place-items: center;
        border: 1px solid #e5e7eb; background: #f8fafc;
        color: #64748b; font-size: .82rem;
        transition: all .18s; cursor: pointer; text-decoration: none;
    }
    .action-btn:hover      { background:#eff6ff;border-color:#93c5fd;color:#2563eb; }
    .action-btn.edit:hover { background:#fef9c3;border-color:#fde68a;color:#854d0e; }
    .action-btn.del:hover  { background:#fef2f2;border-color:#fca5a5;color:#dc2626; }

    .empty-state {
        text-align: center; padding: 48px 20px; color: #94a3b8;
    }
    .empty-state svg { width: 40px; height: 40px; margin-bottom: 12px; opacity: .4; }

    /* ── Pagination ── */
    .pag-wrap {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
        padding: 12px 16px; border-top: 1px solid #f1f5f9;
    }
    .pag-info { font-size: .78rem; color: #64748b; }
    .pag-info b { color: #1e293b; }

    /* Override Laravel's default pagination to match the design */
    .pagination {
        margin: 0; gap: 3px; display: flex; flex-wrap: wrap;
    }
    .pagination .page-item .page-link {
        min-width: 32px; height: 32px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 7px !important;
        border: 1.5px solid #e5e7eb;
        font-size: .78rem; font-weight: 500;
        color: #475569; background: #fff;
        padding: 0 9px; line-height: 1;
        transition: all .15s;
    }
    .pagination .page-item .page-link:hover {
        background: #eff6ff; border-color: #93c5fd; color: #2563eb;
    }
    .pagination .page-item.active .page-link {
        background: #1d4ed8; border-color: #1d4ed8;
        color: #fff; font-weight: 600;
    }
    .pagination .page-item.disabled .page-link {
        background: #f8fafc; color: #cbd5e1; border-color: #e5e7eb;
        cursor: default;
    }
    /* Remove Bootstrap's default border-radius overrides */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link { border-radius: 7px !important; }

    /* Active filter indicator on pills */
    .filter-active-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: #f59e0b; display: inline-block; margin-left: 2px;
    }
</style>

{{-- Page heading --}}
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
        <h5 class="mb-0 fw-semibold">House Properties</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="#">Property</a></li>
                <li class="breadcrumb-item active">Houses</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.properties.houses.create') }}"
        class="btn btn-primary btn-sm d-flex align-items-center gap-1">
        <i class="ri-add-line"></i> Add House
    </a>
</div>

{{-- ── Filter Bar ── --}}
<form method="GET" action="{{ route('admin.properties.houses.index') }}" id="filter-form">
<div class="filter-bar">
    <div class="d-flex align-items-center gap-2 flex-wrap">

        {{-- Status pills (hidden input carries the value) --}}
        <input type="hidden" name="status" id="status-input" value="{{ request('status','all') }}">
        <div class="d-flex gap-1 flex-wrap" id="status-pills">
            @php
            $activeStatus = request('status','all');
            $pills = [
                'all'      => ['label'=>'All',      'class'=>'sp-all',      'count'=>$counts['all']],
                'for_sale' => ['label'=>'For Sale',  'class'=>'sp-for_sale', 'count'=>$counts['for_sale'], 'dot'=>true],
                'for_rent' => ['label'=>'For Rent',  'class'=>'sp-for_rent', 'count'=>$counts['for_rent'], 'dot'=>true],
                'active'   => ['label'=>'Approved',  'class'=>'sp-active',   'count'=>$counts['active'],   'dot'=>true],
                'pending'  => ['label'=>'Pending',   'class'=>'sp-pending',  'count'=>$counts['pending'],  'dot'=>true],
                'sold'     => ['label'=>'Sold',      'class'=>'sp-sold',     'count'=>$counts['sold'],     'dot'=>true],
                'inactive' => ['label'=>'Inactive',  'class'=>'sp-inactive', 'count'=>$counts['inactive'], 'dot'=>true],
            ];
            @endphp
            @foreach($pills as $key => $pill)
            <button type="button"
                class="stat-pill {{ $pill['class'] }} {{ $activeStatus === $key ? 'on' : '' }}"
                data-s="{{ $key }}">
                @if(!empty($pill['dot']))<span class="dot"></span>@endif
                {{ $pill['label'] }}
                <span class="ms-1 fw-bold">{{ $pill['count'] }}</span>
            </button>
            @endforeach
        </div>

        <div class="vr d-none d-md-block mx-1" style="height:28px"></div>

        {{-- Search --}}
        <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="q" id="srch"
                placeholder="Search title, address…"
                value="{{ request('q') }}">
        </div>

        {{-- Type --}}
        <select class="fsel" name="type" id="ftype">
            <option value="">Any Type</option>
            @foreach($allHouses->pluck('type')->filter()->unique()->sort() as $t)
            <option value="{{ strtolower($t) }}" {{ request('type') === strtolower($t) ? 'selected' : '' }}>
                {{ $t }}
            </option>
            @endforeach
        </select>

        {{-- Bedrooms --}}
        <select class="fsel" name="beds" id="fbeds">
            <option value="">Any Beds</option>
            @foreach([1,2,3,4,5] as $n)
            <option value="{{ $n }}" {{ request('beds') == $n ? 'selected' : '' }}>{{ $n }}+ Beds</option>
            @endforeach
        </select>

        {{-- District --}}
        <select class="fsel" name="district" id="fdistrict">
            <option value="">Any Location</option>
            @foreach($allHouses->pluck('district')->filter()->unique()->sort() as $d)
            <option value="{{ strtolower($d) }}" {{ request('district') === strtolower($d) ? 'selected' : '' }}>
                {{ $d }}
            </option>
            @endforeach
        </select>

        {{-- Sort --}}
        <select class="fsel ms-auto" name="sort" id="fsort">
            @foreach(['newest'=>'Newest','oldest'=>'Oldest','price-asc'=>'Price ↑','price-desc'=>'Price ↓','beds-asc'=>'Beds ↑','beds-desc'=>'Beds ↓','az'=>'A–Z'] as $val => $label)
            <option value="{{ $val }}" {{ ($sort ?? 'newest') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        {{-- Clear filters (only show when any filter is active) --}}
        @if(request()->hasAny(['q','type','beds','district','status','sort']) && request('status','all') !== 'all' || request()->hasAny(['q','type','beds','district']))
        <a href="{{ route('admin.properties.houses.index') }}"
            class="btn btn-sm btn-light border text-muted"
            style="font-size:.75rem;padding:5px 10px;border-radius:8px">
            <i class="ri-close-line"></i> Clear
        </a>
        @endif

        <span class="text-muted small ms-1 d-none d-md-inline">
            <b>{{ $houses->total() }}</b> results
        </span>
    </div>
</div>
</form>

{{-- ── Table Card ── --}}
<div class="card shadow-none border">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width:36px">
                            <input class="form-check-input" type="checkbox" id="chk-all">
                        </th>
                        <th>Property</th>
                        <th>Type</th>
                        <th>Condition</th>
                        <th>Specs</th>
                        <th>Price</th>
                        <th>Approved</th>
                        <th>Status</th>
                        <th>Listed</th>
                        <th style="width:110px">Actions</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @forelse($houses as $house)
                    @php
                    $img  = $house->images->first()?->image_path;
                    $cond = strtolower($house->condition ?? 'for_sale');
                    $cbMap = ['for_sale'=>'cb-for_sale','for_rent'=>'cb-for_rent','sold'=>'cb-sold','inactive'=>'cb-inactive'];
                    $cb   = $cbMap[$cond] ?? 'cb-for_sale';
                    $rowStatus = in_array(strtolower($house->status ?? ''), ['sold','inactive'])
                        ? strtolower($house->status)
                        : ($house->is_approved ? 'active' : 'pending');
                    $sClass = match($rowStatus) {
                        'active'   => 'bg-success',
                        'pending'  => 'bg-warning text-dark',
                        'sold'     => 'bg-primary',
                        'inactive' => 'bg-danger',
                        default    => 'bg-secondary',
                    };
                    @endphp
                    <tr>
                        <td><input class="form-check-input row-chk" type="checkbox" value="{{ $house->id }}"></td>

                        {{-- Property --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($img)
                                <img src="{{ asset('image/houses') }}/{{ $img }}"
                                    alt="{{ $house->title }}" class="prop-img" loading="lazy">
                                @else
                                <div class="prop-img-placeholder">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.properties.houses.show', $house->id) }}"
                                        class="prop-title">{{ $house->title }}</a>
                                    <span class="prop-sub d-flex align-items-center gap-1">
                                        <svg viewBox="0 0 24 24" fill="currentColor"
                                            style="width:10px;height:10px;color:#c8873a">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                        </svg>
                                        {{ Str::limit(($house->province ?? '').', '.($house->district ?? ''), 36) }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- Type --}}
                        <td><span class="type-badge">{{ $house->type ?? '—' }}</span></td>

                        {{-- Condition --}}
                        <td>
                            <span class="cond-badge {{ $cb }}">
                                {{ ucwords(str_replace('_',' ', $house->condition ?? 'for sale')) }}
                            </span>
                        </td>

                        {{-- Specs --}}
                        <td>
                            <div class="spec-row">
                                @if($house->bedrooms)
                                <div class="spec-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z"/>
                                    </svg>
                                    {{ $house->bedrooms }}bd
                                </div>
                                @endif
                                @if($house->bathrooms)
                                <div class="spec-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z"/>
                                    </svg>
                                    {{ $house->bathrooms }}ba
                                </div>
                                @endif
                                @if($house->area_sqft)
                                <div class="spec-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/>
                                    </svg>
                                    {{ number_format($house->area_sqft) }}ft²
                                </div>
                                @endif
                            </div>
                        </td>

                        {{-- Price --}}
                        <td>
                            <span class="price-val">{{ number_format($house->price) }}</span>
                            <span class="price-unit">{{ $house->currency }}</span>
                        </td>

                        {{-- Approved --}}
                        <td>
                            @if($house->is_approved)
                            <span class="approved-badge yes"><span class="dot"></span> Approved</span>
                            @else
                            <span class="approved-badge no"><span class="dot"></span> Pending</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td><span class="badge {{ $sClass }}">{{ ucfirst($rowStatus) }}</span></td>

                        {{-- Date --}}
                        <td class="text-muted small">{{ $house->created_at->format('d M Y') }}</td>

                        {{-- Actions --}}
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.properties.houses.show', $house->id) }}"
                                    class="action-btn" title="View">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="{{ route('admin.properties.houses.edit', $house->id) }}"
                                    class="action-btn edit" title="Edit">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <button class="action-btn del" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-id="{{ $house->id }}"
                                    data-title="{{ $house->title }}"
                                    data-destroy="{{ route('admin.properties.houses.destroy', $house) }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                    <polyline points="9 22 9 12 15 12 15 22"/>
                                </svg>
                                <p class="mb-0 fw-500">No house properties found</p>
                                <p class="small">
                                    @if(request()->hasAny(['q','type','beds','city','status']))
                                        No properties match your filters. <a href="{{ route('admin.properties.houses.index') }}">Clear filters</a>
                                    @else
                                        Start by adding your first property.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination footer ── --}}
        <div class="pag-wrap">
            {{-- Left: info + bulk actions --}}
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <p class="pag-info mb-0">
                    @if($houses->total() > 0)
                        Showing
                        <b>{{ $houses->firstItem() }}</b>–<b>{{ $houses->lastItem() }}</b>
                        of <b>{{ $houses->total() }}</b> propert{{ $houses->total() === 1 ? 'y' : 'ies' }}
                    @else
                        No properties found
                    @endif
                </p>
                <div id="bulk-actions" class="d-none gap-2 align-items-center">
                    <span class="text-muted small"><b id="selected-count">0</b> selected</span>
                    <button class="btn btn-sm btn-outline-danger" id="bulk-delete" type="button">
                        <i class="ri-delete-bin-line me-1"></i>Delete Selected
                    </button>
                </div>
            </div>

            {{-- Right: pagination links --}}
            @if($houses->hasPages())
            <div>
                {{ $houses->onEachSide(1)->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── Delete Modal ── --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px">
        <div class="modal-content p-4 text-center">
            <div class="d-flex justify-content-center mb-3">
                <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                    style="width:56px;height:56px">
                    <i class="ri-delete-bin-line text-danger fs-4"></i>
                </div>
            </div>
            <h6 class="mb-1">Delete House Property?</h6>
            <p class="text-muted small mb-4" id="delete-modal-title">This action cannot be undone.</p>
            <div class="d-flex justify-content-center gap-2">
                <form id="deleteForm" method="POST" action="">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4">Delete</button>
                </form>
                <button class="btn btn-outline-secondary btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const form       = document.getElementById('filter-form');
    const statusInp  = document.getElementById('status-input');
    const chkAll     = document.getElementById('chk-all');
    const bulkEl     = document.getElementById('bulk-actions');
    const selCnt     = document.getElementById('selected-count');

    /* ── Status pills: update hidden input then submit ── */
    document.querySelectorAll('#status-pills .stat-pill').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('#status-pills .stat-pill').forEach(b => b.classList.remove('on'));
            btn.classList.add('on');
            statusInp.value = btn.dataset.s;
            submitForm();
        });
    });

    /* ── Auto-submit on select changes ── */
    ['ftype','fbeds','fcity','fsort'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', submitForm);
    });

    /* ── Debounced search submit ── */
    let searchTimer;
    document.getElementById('srch')?.addEventListener('input', e => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(submitForm, 400);
    });

    function submitForm() {
        // Reset to page 1 when filters change
        const pageInput = form.querySelector('input[name="page"]');
        if (pageInput) pageInput.value = 1;
        form.submit();
    }

    /* ── Check-all ── */
    if (chkAll) {
        chkAll.addEventListener('change', () => {
            document.querySelectorAll('.row-chk').forEach(c => c.checked = chkAll.checked);
            updateBulk();
        });
    }
    document.addEventListener('change', e => {
        if (e.target.classList.contains('row-chk')) {
            // Sync check-all state
            const all   = document.querySelectorAll('.row-chk');
            const checked = document.querySelectorAll('.row-chk:checked');
            if (chkAll) {
                chkAll.indeterminate = checked.length > 0 && checked.length < all.length;
                chkAll.checked = checked.length === all.length && all.length > 0;
            }
            updateBulk();
        }
    });

    function updateBulk() {
        const checked = document.querySelectorAll('.row-chk:checked');
        const any = checked.length > 0;
        if (bulkEl) {
            bulkEl.classList.toggle('d-none', !any);
            bulkEl.classList.toggle('d-flex', any);
        }
        if (selCnt) selCnt.textContent = checked.length;
    }

    /* ── Delete modal ── */
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', e => {
            const btn = e.relatedTarget;
            document.getElementById('delete-modal-title').textContent =
                '"' + btn.dataset.title + '" — this action cannot be undone.';
            document.getElementById('deleteForm').action = btn.dataset.destroy;
        });
    }
})();
</script>

@endsection