@extends('layouts.app')
@section('title', 'Services')
@section('content')

<style>
    :root {
        --accent:   #c9a96e;
        --accent-lt:#e4c990;
        --danger:   #dc3545;
        --border:   #e2e8f0;
        --surface:  #f8fafc;
        --muted:    #94a3b8;
        --text:     #1e293b;
        --text-dim: #64748b;
        --radius:   10px;
    }

    .sv-page { padding: 1.75rem 0 3rem; max-width: 1100px; margin: 0 auto; }

    /* ── Top bar ── */
    .sv-topbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.75rem; }
    .sv-topbar h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .sv-topbar p  { font-size: .82rem; color: var(--muted); margin: .15rem 0 0; }

    /* ── Buttons ── */
    .sv-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.2rem; border-radius: 8px; font-size: .84rem; font-weight: 600;
        border: none; cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .sv-btn-primary       { background: var(--accent); color: #fff; }
    .sv-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }
    .sv-btn-ghost         { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .sv-btn-ghost:hover   { border-color: var(--accent); color: var(--accent); }
    .sv-btn-danger        { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .sv-btn-danger:hover  { background: #fef2f2; }
    .sv-btn-sm { padding: .38rem .85rem; font-size: .78rem; }

    /* ── Alerts ── */
    .sv-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: flex-start; margin-bottom: 1.25rem; }
    .sv-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .sv-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .sv-alert ul { margin: .35rem 0 0 1rem; padding: 0; }
    .sv-alert li { margin-bottom: .2rem; }

    /* ── Stats + search strip ── */
    .sv-strip {
        display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        padding: .9rem 1.4rem; margin-bottom: 1.25rem;
    }
    .sv-stat-val   { font-size: 1.5rem; font-weight: 700; color: var(--accent); line-height: 1; }
    .sv-stat-label { font-size: .7rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); margin-top: .1rem; }
    .sv-strip-sep  { width: 1px; height: 32px; background: var(--border); }

    .sv-search-wrap { position: relative; flex: 1; min-width: 200px; max-width: 340px; }
    .sv-search-wrap svg { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .sv-search {
        width: 100%; padding: .56rem .85rem .56rem 2.3rem;
        border: 1.5px solid var(--border); border-radius: 8px; font-size: .84rem;
        color: var(--text); background: var(--surface); outline: none; font-family: inherit; transition: border-color .2s;
    }
    .sv-search:focus { border-color: var(--accent); }

    /* ── Category filter chips ── */
    .sv-chips { display: flex; gap: .4rem; flex-wrap: wrap; margin-bottom: 1rem; }
    .sv-chip {
        padding: .3rem .85rem; border-radius: 100px; border: 1.5px solid var(--border);
        font-size: .74rem; font-weight: 500; color: var(--text-dim); background: none;
        cursor: pointer; transition: all .15s; white-space: nowrap;
    }
    .sv-chip:hover, .sv-chip.active { border-color: var(--accent); color: var(--accent); background: #c9a96e0d; }

    /* ── Table card ── */
    .sv-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .sv-card-toolbar {
        display: flex; align-items: center; justify-content: space-between; gap: .75rem;
        padding: .9rem 1.4rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }
    .sv-card-title { display: flex; align-items: center; gap: .5rem; font-size: .86rem; font-weight: 600; color: var(--text); }

    .sv-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .sv-table thead { background: var(--surface); }
    .sv-table th { padding: .75rem 1.2rem; text-align: left; font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--border); white-space: nowrap; }
    .sv-table td { padding: .9rem 1.2rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .sv-table tr:last-child td { border-bottom: none; }
    .sv-table tbody tr { transition: background .15s; }
    .sv-table tbody tr:hover { background: #fafafa; }

    /* ── Name cell ── */
    .sv-name-cell { display: flex; align-items: center; gap: .75rem; }
    .sv-icon { width: 34px; height: 34px; border-radius: 8px; background: #c9a96e12; border: 1px solid #c9a96e28; display: flex; align-items: center; justify-content: center; color: var(--accent); font-size: .72rem; font-weight: 700; flex-shrink: 0; }
    .sv-name-text { font-weight: 600; color: var(--text); font-size: .87rem; }

    /* ── Badges ── */
    .sv-cat-badge {
        display: inline-flex; align-items: center; gap: .3rem; padding: .22rem .65rem;
        border-radius: 100px; font-size: .7rem; font-weight: 600;
        background: #c9a96e0d; border: 1px solid #c9a96e30; color: var(--accent); white-space: nowrap;
    }
    .sv-sub-badge {
        display: inline-flex; align-items: center; padding: .22rem .65rem;
        border-radius: 100px; font-size: .7rem; font-weight: 500;
        background: var(--surface); border: 1px solid var(--border); color: var(--text-dim); white-space: nowrap;
    }

    .sv-desc { color: var(--text-dim); font-size: .81rem; line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; max-width: 280px; }
    .sv-index { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 6px; background: var(--surface); border: 1px solid var(--border); font-size: .73rem; font-weight: 600; color: var(--muted); }

    /* ── Actions ── */
    .sv-actions { display: flex; align-items: center; gap: .4rem; }
    .sv-icon-btn { width: 32px; height: 32px; border-radius: 7px; border: 1px solid var(--border); background: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-dim); transition: all .15s; }
    .sv-icon-btn:hover        { border-color: var(--accent); color: var(--accent); background: #c9a96e08; }
    .sv-icon-btn.danger:hover { border-color: #fecaca; color: var(--danger); background: #fef2f2; }

    /* ── Empty ── */
    .sv-empty { text-align: center; padding: 4rem 2rem; }
    .sv-empty-icon { width: 52px; height: 52px; border-radius: 12px; background: #c9a96e12; border: 1px solid #c9a96e28; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--accent); }
    .sv-empty h5 { font-size: .96rem; font-weight: 600; color: var(--text); margin: 0 0 .4rem; }
    .sv-empty p  { font-size: .82rem; color: var(--muted); margin: 0 0 1.1rem; }

    /* ── Pagination ── */
    .sv-pagination { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; padding: .9rem 1.2rem; border-top: 1px solid var(--border); }
    .sv-pagination-info { font-size: .78rem; color: var(--muted); }
    .sv-pagination-info strong { color: var(--text-dim); }
    .sv-pages { display: flex; gap: .3rem; }
    .sv-page-btn { min-width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border); background: none; color: var(--text-dim); font-size: .78rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-family: inherit; transition: all .15s; padding: 0 .4rem; }
    .sv-page-btn:hover { border-color: var(--accent); color: var(--accent); }
    .sv-page-btn.current { background: var(--accent); color: #fff; border-color: var(--accent); font-weight: 600; }
    .sv-page-btn.disabled { opacity: .35; pointer-events: none; }

    /* ── Modal ── */
    .sv-modal .modal-content { border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 8px 32px rgba(0,0,0,.12); overflow: hidden; }
    .sv-modal .modal-header  { background: var(--surface); border-bottom: 1px solid var(--border); padding: 1rem 1.4rem; display: flex; align-items: center; gap: .75rem; }
    .sv-modal-icon { width: 30px; height: 30px; border-radius: 7px; background: #c9a96e18; display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0; }
    .sv-modal-icon.danger { background: #fef2f2; color: var(--danger); }
    .sv-modal .modal-title  { font-size: .92rem; font-weight: 700; color: var(--text); margin: 0; }
    .sv-modal .modal-body   { padding: 1.4rem; display: flex; flex-direction: column; gap: 1rem; }
    .sv-modal .modal-footer { padding: .85rem 1.4rem; border-top: 1px solid var(--border); gap: .5rem; }

    .sv-label { display: block; font-size: .75rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: var(--text-dim); margin-bottom: .45rem; }
    .sv-label .req { color: var(--danger); margin-left: .2rem; }
    .sv-input, .sv-select, .sv-textarea {
        width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .875rem; color: var(--text); background: #fff; outline: none; font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }
    .sv-input:focus, .sv-select:focus, .sv-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }
    .sv-textarea { resize: vertical; line-height: 1.65; }

    /* ── Sub loading spinner ── */
    .sv-select-loading { color: var(--muted); font-size: .8rem; margin-top: .35rem; display: none; align-items: center; gap: .4rem; }
    .sv-select-loading.visible { display: flex; }
    @keyframes spin { to { transform: rotate(360deg); } }
    .sv-spinner { width: 12px; height: 12px; border: 2px solid var(--border); border-top-color: var(--accent); border-radius: 50%; animation: spin .6s linear infinite; }

    .sv-delete-box { font-size: .87rem; color: var(--text-dim); line-height: 1.6; padding: .85rem 1rem; border-radius: 8px; border: 1px solid #fecaca; background: #fef2f2; }
    .sv-delete-box strong { color: var(--text); }
</style>

<div class="sv-page">

    {{-- ── Top bar ── --}}
    <div class="sv-topbar">
        <div>
            <h4>Services</h4>
            <p>Manage all available services across categories.</p>
        </div>
        <button class="sv-btn sv-btn-primary" data-bs-toggle="modal" data-bs-target="#createServiceModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Add Service
        </button>
    </div>

    {{-- ── Alerts ── --}}
    @if($errors->any())
        <div class="sv-alert sv-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        </div>
    @endif
    @if(session('success'))
        <div class="sv-alert sv-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Stats + search strip ── --}}
    <div class="sv-strip">
        <div>
            <div class="sv-stat-val">{{ $services->count() }}</div>
            <div class="sv-stat-label">Services</div>
        </div>
        <div class="sv-strip-sep"></div>
        <div>
            <div class="sv-stat-val" style="font-size:1.2rem;color:var(--text-dim)">{{ $categories->count() }}</div>
            <div class="sv-stat-label">Categories</div>
        </div>
        <div class="sv-strip-sep"></div>
        <div class="sv-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="svSearch" class="sv-search" placeholder="Filter services…" oninput="filterRows()">
        </div>
    </div>

    {{-- ── Category filter chips ── --}}
    <div class="sv-chips" id="svChips">
        <button class="sv-chip active" onclick="filterByCat('', this)">All</button>
        @foreach($categories as $cat)
            <button class="sv-chip" onclick="filterByCat('{{ $cat->id }}', this)">{{ $cat->name }}</button>
        @endforeach
    </div>

    {{-- ── Table card ── --}}
    <div class="sv-card">
        <div class="sv-card-toolbar">
            <div class="sv-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                All Services
            </div>
            <span id="svCount" style="font-size:.75rem;color:var(--muted)">
                {{ $services->count() }} service{{ $services->count() === 1 ? '' : 's' }}
            </span>
        </div>

        <div style="overflow-x:auto">
            <table class="sv-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Description</th>
                        <th style="width:96px">Actions</th>
                    </tr>
                </thead>
                <tbody id="svBody">
                    @forelse($services as $service)
                        <tr data-name="{{ strtolower($service->title) }}"
                            data-cat="{{ $service->category_id }}">
                            <td><span class="sv-index">{{ $loop->iteration }}</span></td>
                            <td>
                                <div class="sv-name-cell">
                                    <div class="sv-icon">{{ strtoupper(substr($service->title, 0, 2)) }}</div>
                                    <span class="sv-name-text">{{ $service->title }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="sv-cat-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/></svg>
                                    {{ $service->category?->name ?? '—' }}
                                </span>
                            </td>
                            <td>
                                @if($service->subcategory)
                                    <span class="sv-sub-badge">{{ $service->subcategory->name }}</span>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td><p class="sv-desc">{{ $service->description ?: '—' }}</p></td>
                            <td>
                                <div class="sv-actions">
                                    <button class="sv-icon-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editServiceModal{{ $service->id }}"
                                            title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button class="sv-icon-btn danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteServiceModal{{ $service->id }}"
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="sv-empty">
                                    <div class="sv-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                    </div>
                                    <h5>No services yet</h5>
                                    <p>Add your first service to get started.</p>
                                    <button class="sv-btn sv-btn-primary sv-btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#createServiceModal">
                                        Add First Service
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($services, 'hasPages') && $services->hasPages())
            <div class="sv-pagination">
                <p class="sv-pagination-info">
                    Showing <strong>{{ $services->firstItem() }}</strong>–<strong>{{ $services->lastItem() }}</strong>
                    of <strong>{{ $services->total() }}</strong>
                </p>
                <div class="sv-pages">
                    @if($services->onFirstPage())
                        <span class="sv-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></span>
                    @else
                        <a href="{{ $services->previousPageUrl() }}" class="sv-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></a>
                    @endif
                    @foreach($services->getUrlRange(max(1,$services->currentPage()-2), min($services->lastPage(),$services->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="sv-page-btn {{ $page == $services->currentPage() ? 'current' : '' }}">{{ $page }}</a>
                    @endforeach
                    @if($services->hasMorePages())
                        <a href="{{ $services->nextPageUrl() }}" class="sv-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></a>
                    @else
                        <span class="sv-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ══ CREATE MODAL ══ --}}
<div class="modal fade sv-modal" id="createServiceModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('services.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="sv-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
                <h5 class="modal-title">Add Service</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div>
                    <label class="sv-label">Category <span class="req">*</span></label>
                    <select class="sv-select categorySelect"
                            data-target="#subcategorySelectCreate"
                            name="service_category_id" required>
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="sv-label">Subcategory <span class="req">*</span></label>
                    <select id="subcategorySelectCreate" name="service_subcategory_id"
                            class="sv-select" required>
                        <option value="">Select category first</option>
                    </select>
                    <div class="sv-select-loading" id="loadingCreate">
                        <span class="sv-spinner"></span> Loading subcategories…
                    </div>
                </div>
                <div>
                    <label class="sv-label">Service Name <span class="req">*</span></label>
                    <input type="text" name="title" class="sv-input"
                           placeholder="e.g. Property Valuation" autofocus required>
                </div>
                <div>
                    <label class="sv-label">Description <span class="req">*</span></label>
                    <textarea name="description" rows="3" class="sv-textarea"
                              placeholder="Brief description of this service…" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="sv-btn sv-btn-ghost sv-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="sv-btn sv-btn-primary sv-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                    Create Service
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ EDIT + DELETE MODALS ══ --}}
@foreach($services as $service)

    {{-- Edit --}}
    <div class="modal fade sv-modal" id="editServiceModal{{ $service->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('services.update', $service->id) }}" class="modal-content">
                @csrf @method('PUT')
                <div class="modal-header">
                    <div class="sv-modal-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <h5 class="modal-title">Edit Service</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="sv-label">Category <span class="req">*</span></label>
                        <select class="sv-select categorySelect"
                                data-target="#subcategorySelect{{ $service->id }}"
                                name="service_category_id" required>
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ $service->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="sv-label">Subcategory <span class="req">*</span></label>
                        <select id="subcategorySelect{{ $service->id }}"
                                name="service_subcategory_id"
                                class="sv-select"
                                data-selected="{{ $service->subcategory_id }}"
                                required>
                            <option value="">Select subcategory</option>
                            @if($service->category_id)
                                @foreach($service->category->subcategories as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ $service->subcategory_id == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <div class="sv-select-loading" id="loading{{ $service->id }}">
                            <span class="sv-spinner"></span> Loading subcategories…
                        </div>
                    </div>
                    <div>
                        <label class="sv-label">Service Name <span class="req">*</span></label>
                        <input type="text" name="title" value="{{ $service->title }}"
                               class="sv-input" required>
                    </div>
                    <div>
                        <label class="sv-label">Description <span class="req">*</span></label>
                        <textarea name="description" rows="3"
                                  class="sv-textarea" required>{{ $service->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="sv-btn sv-btn-ghost sv-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="sv-btn sv-btn-primary sv-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete --}}
    <div class="modal fade sv-modal" id="deleteServiceModal{{ $service->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('services.destroy', $service->id) }}" class="modal-content">
                @csrf @method('DELETE')
                <div class="modal-header">
                    <div class="sv-modal-icon danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    </div>
                    <h5 class="modal-title" style="color:var(--danger)">Delete Service</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="sv-delete-box">
                        Are you sure you want to delete <strong>{{ $service->title }}</strong>?
                        This service will be removed from all listings it is currently attached to.
                        <br><br>
                        <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="sv-btn sv-btn-ghost sv-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="sv-btn sv-btn-danger sv-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

@endforeach

<script>
/* ── Client-side filter ── */
let activeCat = '';

function filterRows() {
    const q    = document.getElementById('svSearch').value.toLowerCase();
    const rows = document.querySelectorAll('#svBody tr[data-name]');
    let shown  = 0;
    rows.forEach(r => {
        const nameMatch = r.dataset.name.includes(q);
        const catMatch  = !activeCat || r.dataset.cat === activeCat;
        r.style.display = (nameMatch && catMatch) ? '' : 'none';
        if (nameMatch && catMatch) shown++;
    });
    document.getElementById('svCount').textContent =
        shown + ' service' + (shown === 1 ? '' : 's');
}

function filterByCat(catId, btn) {
    activeCat = catId;
    document.querySelectorAll('#svChips .sv-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    filterRows();
}

/* ── Dynamic subcategory loader ── */
document.addEventListener('DOMContentLoaded', function () {

    function loadSubcategories(categorySelect, preselected = null) {
        const categoryId   = categorySelect.value;
        const targetId     = categorySelect.dataset.target;
        const subSelect    = document.querySelector(targetId);
        const modalId      = categorySelect.closest('.modal')?.id ?? '';
        const loaderId     = modalId === 'createServiceModal'
            ? 'loadingCreate'
            : 'loading' + modalId.replace('editServiceModal', '');
        const loader       = document.getElementById(loaderId);

        subSelect.innerHTML = '<option value="">Loading…</option>';
        if (loader) loader.classList.add('visible');

        if (!categoryId) {
            subSelect.innerHTML = '<option value="">Select category first</option>';
            if (loader) loader.classList.remove('visible');
            return;
        }

        fetch(`/subcategories/${categoryId}`)
            .then(res => res.json())
            .then(data => {
                if (loader) loader.classList.remove('visible');
                subSelect.innerHTML = data.length
                    ? '<option value="">Select subcategory</option>'
                    : '<option value="">No subcategories available</option>';
                data.forEach(sub => {
                    const opt = document.createElement('option');
                    opt.value = sub.id;
                    opt.text  = sub.name;
                    if (preselected && preselected == sub.id) opt.selected = true;
                    subSelect.appendChild(opt);
                });
            })
            .catch(() => {
                if (loader) loader.classList.remove('visible');
                subSelect.innerHTML = '<option value="">Error loading subcategories</option>';
            });
    }

    // Category change → reload subcategories
    document.querySelectorAll('.categorySelect').forEach(sel => {
        sel.addEventListener('change', function () {
            loadSubcategories(this);
        });
    });

    // Edit modal open → pre-load subcategories with current selection
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('show.bs.modal', function () {
            const catSel = this.querySelector('.categorySelect');
            if (catSel && catSel.value) {
                const subSel     = document.querySelector(catSel.dataset.target);
                const preselected = subSel?.dataset.selected ?? null;
                loadSubcategories(catSel, preselected);
            }
        });
    });
});
</script>

@endsection