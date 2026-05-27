@extends('layouts.app')
@section('title', 'Land Properties')
@section('content')

<style>
    .filter-bar {
        background: var(--card-bg, #fff);
        border: 1px solid var(--border-color, #e5e7eb);
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

    .stat-pill.all      { background:#f1f5f9;color:#475569;border-color:#e2e8f0; }
    .stat-pill.active   { background:#e8f5e9;color:#1E7A5A;border-color:#a7d7ba; }
    .stat-pill.pending  { background:#fef9c3;color:#854d0e;border-color:#fde68a; }
    .stat-pill.sold     { background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe; }
    .stat-pill.inactive { background:#fef2f2;color:#991b1b;border-color:#fecaca; }

    .stat-pill.on.all      { background:#475569;color:#fff;border-color:#475569; }
    .stat-pill.on.active   { background:#1E7A5A;color:#fff;border-color:#1E7A5A; }
    .stat-pill.on.pending  { background:#854d0e;color:#fff;border-color:#854d0e; }
    .stat-pill.on.sold     { background:#1d4ed8;color:#fff;border-color:#1d4ed8; }
    .stat-pill.on.inactive { background:#991b1b;color:#fff;border-color:#991b1b; }

    .stat-pill .dot {
        width: 7px; height: 7px;
        border-radius: 50%; background: currentColor;
    }

    .search-wrap { position: relative; }
    .search-wrap svg {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%);
        width: 14px; height: 14px; color: #9ca3af; pointer-events: none;
    }
    .search-wrap input {
        padding: 7px 10px 7px 30px;
        border: 1.5px solid #e5e7eb; border-radius: 8px;
        font-size: .81rem; width: 220px; transition: border-color .18s;
    }
    .search-wrap input:focus { outline: none; border-color: #3b82f6; }

    .fsel {
        padding: 7px 28px 7px 10px;
        border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: .81rem;
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

    .upi-code {
        font-family: monospace; font-size: .77rem;
        background: #f8fafc; border: 1px solid #e2e8f0;
        padding: 2px 7px; border-radius: 5px; color: #475569;
    }

    .prop-thumb {
        width: 44px; height: 36px; border-radius: 6px;
        border: 1px solid #e5e7eb; background: #f1f5f9;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .prop-thumb svg { width: 16px; height: 16px; color: #94a3b8; }

    .prop-title {
        font-weight: 600; font-size: .83rem; color: #1e293b;
        transition: color .15s; text-decoration: none;
    }
    .prop-title:hover { color: #2563eb; }
    .prop-sub { font-size: .72rem; color: #94a3b8; }

    .zoning-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 2px 8px; border-radius: 5px;
        font-size: .67rem; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
    }
    .z-r1,.z-r2,.z-r3 { background:#eff6ff;color:#1d4ed8; }
    .z-commercial      { background:#fef9c3;color:#854d0e; }
    .z-industrial      { background:#f3e8ff;color:#6b21a8; }
    .z-agricultural    { background:#dcfce7;color:#166534; }
    .z-default         { background:#f1f5f9;color:#475569; }

    .size-badge { font-size: .78rem; font-weight: 600; color: #475569; }

    .price-val  { font-weight: 700; font-size: .85rem; color: #1e293b; }
    .price-unit { font-size: .68rem; color: #94a3b8; font-weight: 400; }

    .approved-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 20px;
        font-size: .68rem; font-weight: 700;
        letter-spacing: .04em; white-space: nowrap;
    }
    .approved-badge.yes { background:#dcfce7;color:#166534; }
    .approved-badge.no  { background:#fef9c3;color:#854d0e; }
    .approved-badge .dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: currentColor; flex-shrink: 0;
    }

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

    .empty-state { text-align: center; padding: 48px 20px; color: #94a3b8; }
    .empty-state svg { width: 40px; height: 40px; margin-bottom: 12px; opacity: .4; }

    /* ── Pagination ── */
    .pag-wrap {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
        padding: 12px 16px; border-top: 1px solid #f1f5f9;
    }
    .pag-info { font-size: .78rem; color: #64748b; }
    .pag-info b { color: #1e293b; }

    .pagination { margin: 0; gap: 3px; display: flex; flex-wrap: wrap; }
    .pagination .page-item .page-link {
        min-width: 32px; height: 32px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 7px !important;
        border: 1.5px solid #e5e7eb; font-size: .78rem; font-weight: 500;
        color: #475569; background: #fff; padding: 0 9px; line-height: 1;
        transition: all .15s;
    }
    .pagination .page-item .page-link:hover {
        background: #e8f5e9; border-color: #a7d7ba; color: #1E7A5A;
    }
    .pagination .page-item.active .page-link {
        background: #1E7A5A; border-color: #1E7A5A; color: #fff; font-weight: 600;
    }
    .pagination .page-item.disabled .page-link {
        background: #f8fafc; color: #cbd5e1; border-color: #e5e7eb; cursor: default;
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link { border-radius: 7px !important; }
</style>

{{-- Page heading --}}
<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
        <h5 class="mb-0 fw-semibold">Land Properties</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="#">Property</a></li>
                <li class="breadcrumb-item active">Lands</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('admin.properties.lands.create') }}"
        class="btn btn-primary btn-sm d-flex align-items-center gap-1">
        <i class="ri-add-line"></i> Add Land
    </a>
</div>

{{-- ── Filter Bar ── --}}
<form method="GET" action="{{ route('admin.properties.lands.index') }}" id="filter-form">
<div class="filter-bar">
    <div class="d-flex align-items-center gap-2 flex-wrap">

        {{-- Status pills --}}
        <input type="hidden" name="status" id="status-input" value="{{ request('status', 'all') }}">
        @php $activeStatus = request('status', 'all'); @endphp
        <div class="d-flex gap-1 flex-wrap" id="status-pills">
            <button type="button" class="stat-pill all {{ $activeStatus === 'all' ? 'on' : '' }}" data-s="all">
                All <span class="ms-1 fw-bold">{{ $counts['all'] }}</span>
            </button>
            <button type="button" class="stat-pill active {{ $activeStatus === 'active' ? 'on' : '' }}" data-s="active">
                <span class="dot"></span>Approved
                <span class="ms-1 fw-bold">{{ $counts['active'] }}</span>
            </button>
            <button type="button" class="stat-pill pending {{ $activeStatus === 'pending' ? 'on' : '' }}" data-s="pending">
                <span class="dot"></span>Pending
                <span class="ms-1 fw-bold">{{ $counts['pending'] }}</span>
            </button>
            <button type="button" class="stat-pill sold {{ $activeStatus === 'sold' ? 'on' : '' }}" data-s="sold">
                <span class="dot"></span>Sold
                <span class="ms-1 fw-bold">{{ $counts['sold'] }}</span>
            </button>
            <button type="button" class="stat-pill inactive {{ $activeStatus === 'inactive' ? 'on' : '' }}" data-s="inactive">
                <span class="dot"></span>Inactive
                <span class="ms-1 fw-bold">{{ $counts['inactive'] }}</span>
            </button>
        </div>

        <div class="vr d-none d-md-block mx-1" style="height:28px"></div>

        {{-- Search --}}
        <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="q" id="srch"
                placeholder="Search title, UPI, district…"
                value="{{ request('q') }}">
        </div>

        {{-- Zoning --}}
        <select class="fsel" name="zone" id="fzone">
            <option value="">Any Zoning</option>
            @foreach(['R1','R2','R3','R4','Commercial','Industrial','Agricultural'] as $z)
            <option value="{{ strtolower($z) }}" {{ request('zone') === strtolower($z) ? 'selected' : '' }}>
                {{ $z }}
            </option>
            @endforeach
        </select>

        {{-- District --}}
        <select class="fsel" name="district" id="fdistrict">
            <option value="">Any District</option>
            @foreach($allDistricts as $d)
            <option value="{{ strtolower($d) }}" {{ request('district') === strtolower($d) ? 'selected' : '' }}>
                {{ $d }}
            </option>
            @endforeach
        </select>

        {{-- Sort --}}
        <select class="fsel ms-auto" name="sort" id="fsort">
            @foreach(['newest'=>'Newest','oldest'=>'Oldest','price-asc'=>'Price ↑','price-desc'=>'Price ↓','size-asc'=>'Size ↑','size-desc'=>'Size ↓'] as $val => $label)
            <option value="{{ $val }}" {{ ($sort ?? 'newest') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>

        {{-- Clear filters --}}
        @if(request()->hasAny(['q','zone','district']) || (request('status','all') !== 'all'))
        <a href="{{ route('admin.properties.lands.index') }}"
            class="btn btn-sm btn-light border text-muted"
            style="font-size:.75rem;padding:5px 10px;border-radius:8px">
            <i class="ri-close-line"></i> Clear
        </a>
        @endif

        <span class="text-muted small ms-1 d-none d-md-inline">
            <b>{{ $lands->total() }}</b> results
        </span>
    </div>
</div>
</form>

{{-- ── Table Card ── --}}
<div class="card shadow-none border">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="lands-table">
                <thead class="bg-light">
                    <tr>
                        <th style="width:36px">
                            <input class="form-check-input" type="checkbox" id="chk-all">
                        </th>
                        <th>Property</th>
                        <th>UPI</th>
                        <th>District</th>
                        <th>Zoning</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Approved</th>
                        <th>Status</th>
                        <th>Listed</th>
                        <th style="width:100px">Actions</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @forelse($lands as $land)
                    @php
                        $rowStatus = in_array(strtolower($land->status ?? ''), ['sold','inactive'])
                            ? strtolower($land->status)
                            : ($land->is_approved ? 'active' : 'pending');

                        $zClass = match(strtolower($land->zoning ?? '')) {
                            'r1'           => 'z-r1',
                            'r2'           => 'z-r2',
                            'r3'           => 'z-r3',
                            'r4'           => 'z-r4',
                            'commercial'   => 'z-commercial',
                            'industrial'   => 'z-industrial',
                            'agricultural' => 'z-agricultural',
                            default        => 'z-default',
                        };

                        $sClass = match($rowStatus) {
                            'active'   => 'bg-success',
                            'pending'  => 'bg-warning text-dark',
                            'sold'     => 'bg-primary',
                            'inactive' => 'bg-danger',
                            default    => 'bg-secondary',
                        };
                    @endphp
                    <tr>
                        <td><input class="form-check-input row-chk" type="checkbox" value="{{ $land->id }}"></td>

                        {{-- Property --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="prop-thumb">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <a href="{{ route('admin.properties.lands.show', $land->id) }}"
                                        class="prop-title d-block">{{ $land->title }}</a>
                                    <span class="prop-sub">{{ $land->sector }}, {{ $land->district }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- UPI --}}
                        <td><span class="upi-code">{{ $land->upi ?? '—' }}</span></td>

                        {{-- District --}}
                        <td class="text-muted small">{{ $land->district }}</td>

                        {{-- Zoning --}}
                        <td><span class="zoning-badge {{ $zClass }}">{{ $land->zoning ?? '—' }}</span></td>

                        {{-- Size --}}
                        <td>
                            <span class="size-badge">
                                {{ number_format($land->size_sqm ?? 0) }}
                                <span class="fw-normal text-muted">sqm</span>
                            </span>
                        </td>

                        {{-- Price --}}
                        <td>
                            <span class="price-val">{{ number_format($land->price) }}</span>
                            <span class="price-unit">{{ $land->currency ?? 'RWF' }}</span>
                            <span class="price-negotiable">{{ $land->negotiable ? ' (Negotiable)' : ' (Non-negotiable)' }}</span>
                        </td>

                        {{-- Approved --}}
                        <td>
                            @if($land->is_approved)
                                <span class="approved-badge yes"><span class="dot"></span> Approved</span>
                            @else
                                <span class="approved-badge no"><span class="dot"></span> Pending</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td><span class="badge {{ $sClass }}">{{ ucfirst($rowStatus) }}</span></td>

                        {{-- Date --}}
                        <td class="text-muted small">{{ $land->created_at->format('d M Y') }}</td>

                        {{-- Actions --}}
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.properties.lands.show', $land->id) }}"
                                    class="action-btn" title="View"><i class="ri-eye-line"></i></a>
                                <a href="{{ route('admin.properties.lands.edit', $land->id) }}"
                                    class="action-btn edit" title="Edit"><i class="ri-edit-line"></i></a>
                                <button class="action-btn del" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-id="{{ $land->id }}"
                                    data-title="{{ $land->title }}"
                                    data-destroy="{{ route('admin.properties.lands.destroy', $land) }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9v17.1l.16-.03L9 18.9l6 2.1 5.64-1.9V3.5z"/>
                                </svg>
                                <p class="mb-0 fw-500">No land properties found</p>
                                <p class="small">
                                    @if(request()->hasAny(['q','zone','district','status']))
                                        No properties match your filters. <a href="{{ route('admin.properties.lands.index') }}">Clear filters</a>
                                    @else
                                        Start by adding your first land listing.
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
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <p class="pag-info mb-0">
                    @if($lands->total() > 0)
                        Showing
                        <b>{{ $lands->firstItem() }}</b>–<b>{{ $lands->lastItem() }}</b>
                        of <b>{{ $lands->total() }}</b> propert{{ $lands->total() === 1 ? 'y' : 'ies' }}
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

            @if($lands->hasPages())
            <div>
                {{ $lands->onEachSide(1)->links() }}
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
            <h6 class="mb-1">Delete Land Property?</h6>
            <p class="text-muted small mb-3" id="delete-modal-title">This action cannot be undone.</p>
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
    const form      = document.getElementById('filter-form');
    const statusInp = document.getElementById('status-input');
    const chkAll    = document.getElementById('chk-all');
    const bulkEl    = document.getElementById('bulk-actions');
    const selCnt    = document.getElementById('selected-count');

    /* ── Status pills ── */
    document.querySelectorAll('#status-pills .stat-pill').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('#status-pills .stat-pill').forEach(b => b.classList.remove('on'));
            btn.classList.add('on');
            statusInp.value = btn.dataset.s;
            submitForm();
        });
    });

    /* ── Auto-submit selects ── */
    ['fzone', 'fdistrict', 'fsort'].forEach(id => {
        document.getElementById(id)?.addEventListener('change', submitForm);
    });

    /* ── Debounced search ── */
    let searchTimer;
    document.getElementById('srch')?.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(submitForm, 400);
    });

    function submitForm() {
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
            const all     = document.querySelectorAll('.row-chk');
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