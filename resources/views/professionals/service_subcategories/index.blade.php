@extends('layouts.app')
@section('title', 'Service Subcategories')
@section('content')

<style>
    :root {
        --accent: #c9a96e;
        --accent-lt: #e4c990;
        --danger: #dc3545;
        --border: #e2e8f0;
        --surface: #f8fafc;
        --muted: #94a3b8;
        --text: #1e293b;
        --text-dim: #64748b;
        --radius: 10px;
    }

    .sc-page {
        padding: 1.75rem 0 3rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    .sc-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .sc-topbar h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .sc-topbar p {
        font-size: .82rem;
        color: var(--muted);
        margin: .15rem 0 0;
    }

    .sc-btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .6rem 1.2rem;
        border-radius: 8px;
        font-size: .84rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        font-family: inherit;
    }

    .sc-btn-primary {
        background: var(--accent);
        color: #fff;
    }

    .sc-btn-primary:hover {
        background: var(--accent-lt);
        color: #fff;
        transform: translateY(-1px);
    }

    .sc-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .sc-btn-ghost:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    .sc-btn-danger {
        background: none;
        border: 1.5px solid #fecaca;
        color: var(--danger);
    }

    .sc-btn-danger:hover {
        background: #fef2f2;
    }

    .sc-btn-sm {
        padding: .38rem .85rem;
        font-size: .78rem;
    }

    .sc-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .sc-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .sc-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    /* ── Stats + search strip ── */
    .sc-strip {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: .9rem 1.4rem;
        margin-bottom: 1.25rem;
    }

    .sc-stat-val {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--accent);
        line-height: 1;
    }

    .sc-stat-label {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: .1rem;
    }

    .sc-strip-sep {
        width: 1px;
        height: 32px;
        background: var(--border);
    }

    .sc-search-wrap {
        position: relative;
        flex: 1;
        min-width: 200px;
        max-width: 340px;
    }

    .sc-search-wrap svg {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
    }

    .sc-search {
        width: 100%;
        padding: .56rem .85rem .56rem 2.3rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .84rem;
        color: var(--text);
        background: var(--surface);
        outline: none;
        font-family: inherit;
        transition: border-color .2s;
    }

    .sc-search:focus {
        border-color: var(--accent);
    }

    /* ── Category filter chips ── */
    .sc-chips {
        display: flex;
        gap: .4rem;
        flex-wrap: wrap;
    }

    .sc-chip {
        padding: .3rem .8rem;
        border-radius: 100px;
        border: 1.5px solid var(--border);
        font-size: .74rem;
        font-weight: 500;
        color: var(--text-dim);
        background: none;
        cursor: pointer;
        transition: all .15s;
        white-space: nowrap;
    }

    .sc-chip:hover,
    .sc-chip.active {
        border-color: var(--accent);
        color: var(--accent);
        background: #c9a96e0d;
    }

    /* ── Table card ── */
    .sc-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .sc-card-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding: .9rem 1.4rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .sc-card-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .86rem;
        font-weight: 600;
        color: var(--text);
    }

    .sc-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .84rem;
    }

    .sc-table thead {
        background: var(--surface);
    }

    .sc-table th {
        padding: .75rem 1.2rem;
        text-align: left;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
    }

    .sc-table td {
        padding: .9rem 1.2rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .sc-table tr:last-child td {
        border-bottom: none;
    }

    .sc-table tbody tr {
        transition: background .15s;
    }

    .sc-table tbody tr:hover {
        background: #fafafa;
    }

    .sc-name-cell {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .sc-icon {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        background: #c9a96e12;
        border: 1px solid #c9a96e28;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        font-size: .72rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .sc-name-text {
        font-weight: 600;
        color: var(--text);
        font-size: .86rem;
    }

    /* ── Category badge ── */
    .sc-cat-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .22rem .65rem;
        border-radius: 100px;
        font-size: .71rem;
        font-weight: 600;
        background: #c9a96e0d;
        border: 1px solid #c9a96e30;
        color: var(--accent);
        white-space: nowrap;
    }

    .sc-desc {
        color: var(--text-dim);
        font-size: .81rem;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        max-width: 300px;
    }

    .sc-index {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 6px;
        background: var(--surface);
        border: 1px solid var(--border);
        font-size: .73rem;
        font-weight: 600;
        color: var(--muted);
    }

    .sc-actions {
        display: flex;
        align-items: center;
        gap: .4rem;
    }

    .sc-icon-btn {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        border: 1px solid var(--border);
        background: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dim);
        transition: all .15s;
    }

    .sc-icon-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: #c9a96e08;
    }

    .sc-icon-btn.danger:hover {
        border-color: #fecaca;
        color: var(--danger);
        background: #fef2f2;
    }

    /* ── Empty ── */
    .sc-empty {
        text-align: center;
        padding: 4rem 2rem;
    }

    .sc-empty-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #c9a96e12;
        border: 1px solid #c9a96e28;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--accent);
    }

    .sc-empty h5 {
        font-size: .96rem;
        font-weight: 600;
        color: var(--text);
        margin: 0 0 .4rem;
    }

    .sc-empty p {
        font-size: .82rem;
        color: var(--muted);
        margin: 0 0 1.1rem;
    }

    /* ── Modal ── */
    .sc-modal .modal-content {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
        overflow: hidden;
    }

    .sc-modal .modal-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 1rem 1.4rem;
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .sc-modal-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: #c9a96e18;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--accent);
        flex-shrink: 0;
    }

    .sc-modal-icon.danger {
        background: #fef2f2;
        color: var(--danger);
    }

    .sc-modal .modal-title {
        font-size: .92rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .sc-modal .modal-body {
        padding: 1.4rem;
        display: flex;
        flex-direction: column;
        gap: 1.1rem;
    }

    .sc-modal .modal-footer {
        padding: .85rem 1.4rem;
        border-top: 1px solid var(--border);
        gap: .5rem;
    }

    .sc-label {
        display: block;
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: var(--text-dim);
        margin-bottom: .45rem;
    }

    .sc-label .req {
        color: var(--danger);
        margin-left: .2rem;
    }

    .sc-input,
    .sc-select,
    .sc-textarea {
        width: 100%;
        padding: .65rem .9rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .875rem;
        color: var(--text);
        background: #fff;
        outline: none;
        font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }

    .sc-input:focus,
    .sc-select:focus,
    .sc-textarea:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px #c9a96e18;
    }

    .sc-textarea {
        resize: vertical;
        line-height: 1.65;
    }

    .sc-delete-box {
        font-size: .87rem;
        color: var(--text-dim);
        line-height: 1.6;
        padding: .85rem 1rem;
        border-radius: 8px;
        border: 1px solid #fecaca;
        background: #fef2f2;
    }

    .sc-delete-box strong {
        color: var(--text);
    }

    /* ── Pagination ── */
    .sc-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        padding: .9rem 1.2rem;
        border-top: 1px solid var(--border);
    }

    .sc-pagination-info {
        font-size: .78rem;
        color: var(--muted);
    }

    .sc-pagination-info strong {
        color: var(--text-dim);
    }

    .sc-pages {
        display: flex;
        gap: .3rem;
    }

    .sc-page-btn {
        min-width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid var(--border);
        background: none;
        color: var(--text-dim);
        font-size: .78rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-family: inherit;
        transition: all .15s;
        padding: 0 .4rem;
    }

    .sc-page-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    .sc-page-btn.current {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
        font-weight: 600;
    }

    .sc-page-btn.disabled {
        opacity: .35;
        pointer-events: none;
    }
</style>

<div class="sc-page">

    {{-- ── Top bar ── --}}
    <div class="sc-topbar">
        <div>
            <h4>Service Subcategories</h4>
            <p>Manage subcategories grouped under each service category.</p>
        </div>
        <button class="sc-btn sc-btn-primary" data-bs-toggle="modal" data-bs-target="#createSub">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            Add Subcategory
        </button>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
    <div class="sc-alert sc-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="sc-alert sc-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4m0 4h.01" />
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Stats + search strip ── --}}
    <div class="sc-strip">
        <div>
            <div class="sc-stat-val">{{ $subcategories->count() }}</div>
            <div class="sc-stat-label">Subcategories</div>
        </div>
        <div class="sc-strip-sep"></div>
        <div>
            <div class="sc-stat-val" style="color:var(--text-dim);font-size:1.2rem">{{ $categories->count() }}</div>
            <div class="sc-stat-label">Parent categories</div>
        </div>
        <div class="sc-strip-sep"></div>
        <div class="sc-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input type="text" id="scSearch" class="sc-search"
                placeholder="Filter subcategories…" oninput="filterRows()">
        </div>
    </div>

    {{-- ── Category filter chips ── --}}
    <div class="sc-chips" id="scChips" style="margin-bottom:1rem;">
        <button class="sc-chip active" onclick="filterByCategory('', this)">All</button>
        @foreach($categories as $cat)
        <button class="sc-chip" onclick="filterByCategory('{{ $cat->id }}', this)">
            {{ $cat->name }}
        </button>
        @endforeach
    </div>

    {{-- ── Table card ── --}}
    <div class="sc-card">
        <div class="sc-card-toolbar">
            <div class="sc-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--accent)">
                    <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                    <path d="M7 7h.01" />
                </svg>
                All Subcategories
            </div>
            <span id="scCount" style="font-size:.75rem;color:var(--muted)">
                {{ $subcategories->count() }} subcategor{{ $subcategories->count() === 1 ? 'y' : 'ies' }}
            </span>
        </div>

        <div style="overflow-x:auto">
            <table class="sc-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Subcategory</th>
                        <th>Parent Category</th>
                        <th>Description</th>
                        <th style="width:96px">Actions</th>
                    </tr>
                </thead>
                <tbody id="scBody">
                    @forelse($subcategories as $sub)
                    <tr data-name="{{ strtolower($sub->name) }}"
                        data-cat="{{ $sub->service_category_id }}">
                        <td><span class="sc-index">{{ $loop->iteration }}</span></td>
                        <td>
                            <div class="sc-name-cell">
                                <div class="sc-icon">{{ strtoupper(substr($sub->name, 0, 2)) }}</div>
                                <span class="sc-name-text">{{ $sub->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="sc-cat-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                                </svg>
                                {{ $sub->category->name }}
                            </span>
                        </td>
                        <td>
                            <p class="sc-desc">{{ $sub->description ?: '—' }}</p>
                        </td>
                        <td>
                            <div class="sc-actions">
                                <button class="sc-icon-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $sub->id }}"
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </button>
                                <button class="sc-icon-btn danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#delete{{ $sub->id }}"
                                    title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        <path d="M10 11v6M14 11v6" />
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="sc-empty">
                                <div class="sc-empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z" />
                                        <path d="M7 7h.01" />
                                    </svg>
                                </div>
                                <h5>No subcategories yet</h5>
                                <p>Create your first subcategory under an existing category.</p>
                                <button class="sc-btn sc-btn-primary sc-btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#createSub">
                                    Add First Subcategory
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($subcategories, 'hasPages') && $subcategories->hasPages())
        <div class="sc-pagination">
            <p class="sc-pagination-info">
                Showing <strong>{{ $subcategories->firstItem() }}</strong>–<strong>{{ $subcategories->lastItem() }}</strong>
                of <strong>{{ $subcategories->total() }}</strong>
            </p>
            <div class="sc-pages">
                @if($subcategories->onFirstPage())
                <span class="sc-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m15 18-6-6 6-6" />
                    </svg></span>
                @else
                <a href="{{ $subcategories->previousPageUrl() }}" class="sc-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m15 18-6-6 6-6" />
                    </svg></a>
                @endif
                @foreach($subcategories->getUrlRange(max(1,$subcategories->currentPage()-2), min($subcategories->lastPage(),$subcategories->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="sc-page-btn {{ $page == $subcategories->currentPage() ? 'current' : '' }}">{{ $page }}</a>
                @endforeach
                @if($subcategories->hasMorePages())
                <a href="{{ $subcategories->nextPageUrl() }}" class="sc-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6" />
                    </svg></a>
                @else
                <span class="sc-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6" />
                    </svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ══ CREATE MODAL ══ --}}
<div class="modal fade sc-modal" id="createSub" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('service-subcategories.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="sc-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </div>
                <h5 class="modal-title">Add Subcategory</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div>
                    <label class="sc-label">Parent Category <span class="req">*</span></label>
                    <select name="service_category_id" class="sc-select" required>
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="sc-label">Subcategory Name <span class="req">*</span></label>
                    <input type="text" name="name" class="sc-input"
                        placeholder="e.g. Apartment Rentals" autofocus required>
                </div>
                <div>
                    <label class="sc-label">Description <span class="req">*</span></label>
                    <textarea name="description" rows="3" class="sc-textarea"
                        placeholder="Brief description…" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="sc-btn sc-btn-ghost sc-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="sc-btn sc-btn-primary sc-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    Create
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ EDIT + DELETE MODALS ══ --}}
@foreach($subcategories as $sub)

{{-- Edit --}}
<div class="modal fade sc-modal" id="edit{{ $sub->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('service-subcategories.update', $sub) }}" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header">
                <div class="sc-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </div>
                <h5 class="modal-title">Edit Subcategory</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div>
                    <label class="sc-label">Parent Category <span class="req">*</span></label>
                    <select name="service_category_id" class="sc-select" required>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            @selected($cat->id == $sub->service_category_id)>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="sc-label">Subcategory Name <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ $sub->name }}"
                        class="sc-input" required>
                </div>
                <div>
                    <label class="sc-label">Description <span class="req">*</span></label>
                    <textarea name="description" rows="3" class="sc-textarea" required>{{ $sub->description }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="sc-btn sc-btn-ghost sc-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="sc-btn sc-btn-primary sc-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete --}}
<div class="modal fade sc-modal" id="delete{{ $sub->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('service-subcategories.destroy', $sub) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="sc-modal-icon danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                        <line x1="12" x2="12" y1="9" y2="13" />
                        <line x1="12" x2="12.01" y1="17" y2="17" />
                    </svg>
                </div>
                <h5 class="modal-title" style="color:var(--danger)">Delete Subcategory</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="sc-delete-box">
                    Are you sure you want to delete <strong>{{ $sub->name }}</strong>
                    under <strong>{{ $sub->category->name }}</strong>?
                    Any services assigned to this subcategory may be affected.
                    <br><br>
                    <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="sc-btn sc-btn-ghost sc-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="sc-btn sc-btn-danger sc-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                    </svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

@endforeach

<script>
    let activeCategory = '';

    function filterRows() {
        const q = document.getElementById('scSearch').value.toLowerCase();
        const rows = document.querySelectorAll('#scBody tr[data-name]');
        let shown = 0;
        rows.forEach(r => {
            const nameMatch = r.dataset.name.includes(q);
            const catMatch = !activeCategory || r.dataset.cat === activeCategory;
            const visible = nameMatch && catMatch;
            r.style.display = visible ? '' : 'none';
            if (visible) shown++;
        });
        document.getElementById('scCount').textContent =
            shown + ' subcategor' + (shown === 1 ? 'y' : 'ies');
    }

    function filterByCategory(catId, btn) {
        activeCategory = catId;
        document.querySelectorAll('#scChips .sc-chip').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        filterRows();
    }
</script>

@endsection