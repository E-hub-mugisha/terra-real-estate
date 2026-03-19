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
    }

    .stat-pill.all {
        background: #f1f5f9;
        color: #475569;
        border-color: #e2e8f0;
    }

    .stat-pill.active {
        background: #e8f5e9;
        color: #1E7A5A;
        border-color: #a7d7ba;
    }

    .stat-pill.on {
        background: #1E7A5A;
        color: #fff;
        border-color: #1E7A5A;
    }

    .stat-pill.pending {
        background: #fef9c3;
        color: #854d0e;
        border-color: #fde68a;
    }

    .stat-pill.sold {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .stat-pill.inactive {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    .stat-pill .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .search-wrap {
        position: relative;
    }

    .search-wrap svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        color: #9ca3af;
        pointer-events: none;
    }

    .search-wrap input {
        padding: 7px 10px 7px 30px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: .81rem;
        width: 220px;
        transition: border-color .18s;
    }

    .search-wrap input:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .fsel {
        padding: 7px 28px 7px 10px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: .81rem;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 8px center no-repeat;
        appearance: none;
        cursor: pointer;
    }

    .fsel:focus {
        outline: none;
        border-color: #3b82f6;
    }

    .table> :not(caption)>*>th,
    .table> :not(caption)>*>td {
        vertical-align: middle;
        font-size: .82rem;
    }

    .table thead th {
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-weight: 600;
        white-space: nowrap;
    }

    .upi-code {
        font-family: monospace;
        font-size: .77rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 2px 7px;
        border-radius: 5px;
        color: #475569;
    }

    .prop-thumb {
        width: 44px;
        height: 36px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .prop-thumb svg {
        width: 16px;
        height: 16px;
        color: #94a3b8;
    }

    .prop-title {
        font-weight: 600;
        font-size: .83rem;
        color: #1e293b;
        transition: color .15s;
    }

    .prop-title:hover {
        color: #2563eb;
    }

    .prop-sub {
        font-size: .72rem;
        color: #94a3b8;
    }

    .zoning-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: .67rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .z-r1,
    .z-r2,
    .z-r3 {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .z-commercial {
        background: #fef9c3;
        color: #854d0e;
    }

    .z-industrial {
        background: #f3e8ff;
        color: #6b21a8;
    }

    .z-agricultural {
        background: #dcfce7;
        color: #166534;
    }

    .z-default {
        background: #f1f5f9;
        color: #475569;
    }

    .size-badge {
        font-size: .78rem;
        font-weight: 600;
        color: #475569;
    }

    .price-val {
        font-weight: 700;
        font-size: .85rem;
        color: #1e293b;
    }

    .price-unit {
        font-size: .68rem;
        color: #94a3b8;
        font-weight: 400;
    }

    .action-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: grid;
        place-items: center;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
        color: #64748b;
        font-size: .82rem;
        transition: all .18s;
        cursor: pointer;
    }

    .action-btn:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        color: #2563eb;
    }

    .action-btn.edit:hover {
        background: #fef9c3;
        border-color: #fde68a;
        color: #854d0e;
    }

    .action-btn.del:hover {
        background: #fef2f2;
        border-color: #fca5a5;
        color: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: #94a3b8;
    }

    .empty-state svg {
        width: 40px;
        height: 40px;
        margin-bottom: 12px;
        opacity: .4;
    }

    .row-hidden {
        display: none;
    }
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
<div class="filter-bar">
    <div class="d-flex align-items-center gap-2 flex-wrap">

        {{-- Status pills --}}
        <div class="d-flex gap-1 flex-wrap" id="status-pills">
            <button class="stat-pill all on" data-s="all">All <span class="ms-1 fw-bold" id="cnt-all">{{ $lands->count() }}</span></button>
            <button class="stat-pill active" data-s="active">
                <span class="dot"></span>Active
                <span class="ms-1 fw-bold" id="cnt-active">{{ $lands->where('status','active')->count() }}</span>
            </button>
            <button class="stat-pill pending" data-s="pending">
                <span class="dot"></span>Pending
                <span class="ms-1 fw-bold" id="cnt-pending">{{ $lands->where('status','pending')->count() }}</span>
            </button>
            <button class="stat-pill sold" data-s="sold">
                <span class="dot"></span>Sold
                <span class="ms-1 fw-bold" id="cnt-sold">{{ $lands->where('status','sold')->count() }}</span>
            </button>
            <button class="stat-pill inactive" data-s="inactive">
                <span class="dot"></span>Inactive
                <span class="ms-1 fw-bold" id="cnt-inactive">{{ $lands->where('status','inactive')->count() }}</span>
            </button>
        </div>

        <div class="vr d-none d-md-block mx-1" style="height:28px"></div>

        {{-- Search --}}
        <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35" />
            </svg>
            <input type="text" id="srch" placeholder="Search title, UPI, district…">
        </div>

        {{-- Zoning --}}
        <select class="fsel" id="fzone">
            <option value="">Any Zoning</option>
            <option>R1</option>
            <option>R2</option>
            <option>R3</option>
            <option>Commercial</option>
            <option>Industrial</option>
            <option>Agricultural</option>
        </select>

        {{-- District --}}
        <select class="fsel" id="fdistrict">
            <option value="">Any District</option>
            @foreach($lands->pluck('district')->filter()->unique()->sort() as $d)
            <option>{{ $d }}</option>
            @endforeach
        </select>

        {{-- Sort --}}
        <select class="fsel ms-auto" id="fsort">
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
            <option value="price-asc">Price ↑</option>
            <option value="price-desc">Price ↓</option>
            <option value="size-asc">Size ↑</option>
            <option value="size-desc">Size ↓</option>
        </select>

        {{-- Result count --}}
        <span class="text-muted small ms-1 d-none d-md-inline" id="result-count">
            <b id="vis-count">{{ $lands->count() }}</b> results
        </span>
    </div>
</div>

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
                        <th>Status</th>
                        <th>Listed</th>
                        <th style="width:100px">Actions</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @forelse($lands as $i => $land)
                    @php
                    $zClass = match(strtolower($land->zoning ?? '')) {
                    'r1' => 'z-r1',
                    'r2' => 'z-r2',
                    'r3' => 'z-r3',
                    'commercial' => 'z-commercial',
                    'industrial' => 'z-industrial',
                    'agricultural'=> 'z-agricultural',
                    default => 'z-default',
                    };
                    $sClass = match(strtolower($land->status ?? 'active')) {
                    'active' => 'bg-success',
                    'pending' => 'bg-warning text-dark',
                    'sold' => 'bg-primary',
                    'inactive' => 'bg-danger',
                    default => 'bg-secondary',
                    };
                    @endphp
                    <tr data-title="{{ strtolower($land->title) }}"
                        data-upi="{{ strtolower($land->upi ?? '') }}"
                        data-district="{{ strtolower($land->district ?? '') }}"
                        data-zone="{{ strtolower($land->zoning ?? '') }}"
                        data-status="{{ strtolower($land->status ?? 'active') }}"
                        data-price="{{ $land->price }}"
                        data-size="{{ $land->size_sqm ?? 0 }}"
                        data-created="{{ $land->created_at->timestamp }}">

                        <td><input class="form-check-input row-chk" type="checkbox"></td>

                        {{-- Property --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="prop-thumb">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5z" />
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
                        <td><span class="size-badge">{{ number_format($land->size_sqm ?? 0) }} <span class="fw-normal text-muted">sqm</span></span></td>

                        {{-- Price --}}
                        <td>
                            <span class="price-val">{{ number_format($land->price) }}</span>
                            <span class="price-unit">RWF</span>
                        </td>

                        {{-- Status --}}
                        <td><span class="badge {{ $sClass }}">{{ ucfirst($land->status ?? 'Active') }}</span></td>

                        {{-- Date --}}
                        <td class="text-muted small">{{ $land->created_at->format('d M Y') }}</td>

                        {{-- Actions --}}
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.properties.lands.show', $land->id) }}"
                                    class="action-btn" title="View"><i class="ri-eye-line"></i></a>
                                <a href="{{ route('admin.properties.lands.edit', $land->id) }}"
                                    class="action-btn edit" title="Edit"><i class="ri-edit-line"></i></a>
                                <button class="action-btn del"
                                    title="Delete"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    data-id="{{ $land->id }}"
                                    data-title="{{ $land->title }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="no-data-row">
                        <td colspan="10">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9v17.1l.16-.03L9 18.9l6 2.1 5.64-1.9V3.5z" />
                                </svg>
                                <p class="mb-0 fw-500">No land properties found</p>
                                <p class="small">Start by adding your first land listing.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- JS empty state --}}
        <div id="js-empty" class="empty-state" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35M11 8v3m0 3h.01" />
            </svg>
            <p class="mb-0 fw-500">No properties match your filters</p>
            <p class="small">Try adjusting your search or clearing filters.</p>
        </div>

        {{-- Footer --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 px-3 py-2 border-top">
            <p class="text-muted small mb-0">
                Showing <b id="showing-count">0</b> of <b>{{ $lands->count() }}</b> properties
            </p>
            <div id="bulk-actions" class="d-none gap-2">
                <button class="btn btn-sm btn-outline-danger" id="bulk-delete">
                    <i class="ri-delete-bin-line me-1"></i>Delete Selected
                </button>
            </div>
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
            <input type="hidden" id="deletePropertyId">
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
    (function() {
        const rows = Array.from(document.querySelectorAll('#tbody tr[data-title]'));
        const empty = document.getElementById('js-empty');
        const showing = document.getElementById('showing-count');
        const chkAll = document.getElementById('chk-all');
        const bulkEl = document.getElementById('bulk-actions');

        let state = {
            q: '',
            status: 'all',
            zone: '',
            district: '',
            sort: 'newest'
        };

        function debounce(fn, ms) {
            let t;
            return (...a) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...a), ms);
            };
        }

        function run() {
            const q = state.q.toLowerCase();
            let vis = rows.filter(r => {
                if (state.status !== 'all' && r.dataset.status !== state.status) return false;
                if (state.zone && r.dataset.zone !== state.zone) return false;
                if (state.district && r.dataset.district !== state.district) return false;
                if (q && !(r.dataset.title + r.dataset.upi + r.dataset.district).includes(q)) return false;
                return true;
            });

            if (state.sort === 'price-asc') vis.sort((a, b) => +a.dataset.price - +b.dataset.price);
            if (state.sort === 'price-desc') vis.sort((a, b) => +b.dataset.price - +a.dataset.price);
            if (state.sort === 'size-asc') vis.sort((a, b) => +a.dataset.size - +b.dataset.size);
            if (state.sort === 'size-desc') vis.sort((a, b) => +b.dataset.size - +a.dataset.size);
            if (state.sort === 'oldest') vis.sort((a, b) => +a.dataset.created - +b.dataset.created);
            if (state.sort === 'newest') vis.sort((a, b) => +b.dataset.created - +a.dataset.created);

            const vs = new Set(vis);
            const tbody = document.getElementById('tbody');
            rows.forEach(r => {
                r.style.display = vs.has(r) ? '' : 'none';
            });
            vis.forEach(r => tbody.appendChild(r));

            const n = vis.length;
            showing.textContent = n;
            if (empty) empty.style.display = n === 0 ? 'block' : 'none';
        }

        /* Status pills */
        document.querySelectorAll('#status-pills .stat-pill').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('#status-pills .stat-pill').forEach(b => b.classList.remove('on'));
                btn.classList.add('on');
                state.status = btn.dataset.s;
                run();
            });
        });

        document.getElementById('srch')
            .addEventListener('input', debounce(e => {
                state.q = e.target.value;
                run();
            }, 200));
        document.getElementById('fzone')
            .addEventListener('change', e => {
                state.zone = e.target.value.toLowerCase();
                run();
            });
        document.getElementById('fdistrict')
            .addEventListener('change', e => {
                state.district = e.target.value.toLowerCase();
                run();
            });
        document.getElementById('fsort')
            .addEventListener('change', e => {
                state.sort = e.target.value;
                run();
            });

        /* Check-all */
        if (chkAll) chkAll.addEventListener('change', () => {
            document.querySelectorAll('.row-chk').forEach(c => c.checked = chkAll.checked);
            updateBulk();
        });
        document.addEventListener('change', e => {
            if (e.target.classList.contains('row-chk')) updateBulk();
        });

        function updateBulk() {
            const any = document.querySelectorAll('.row-chk:checked').length > 0;
            if (bulkEl) bulkEl.classList.toggle('d-none', !any);
            bulkEl.classList.toggle('d-flex', any);
        }

        /* Delete modal: wire up data */
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', e => {
                const btn = e.relatedTarget;
                document.getElementById('deletePropertyId').value = btn.dataset.id;
                document.getElementById('delete-modal-title').textContent =
                    '"' + btn.dataset.title + '" — this action cannot be undone.';
                document.getElementById('deleteForm').action =
                    '{{ url("admin/properties/lands") }}/' + btn.dataset.id;
            });
        }

        run();
    })();
</script>

@endsection