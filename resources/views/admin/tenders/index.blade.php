@extends('layouts.app')
@section('title', 'Tenders')
@section('content')

<style>
    :root {
        --accent: #c9a96e;
        --danger: #dc3545;
        --border: #e2e8f0;
        --surface: #f8fafc;
        --muted: #94a3b8;
        --text: #1e293b;
        --text-dim: #64748b;
        --radius: 10px;
        --indigo: #4f46e5;
        --indigo-lt: #6366f1;
        --green: #22c55e;
        --amber: #f59e0b;
        --red: #ef4444;
    }

    .td-page {
        padding: 1.75rem 0 3rem;
        max-width: 1320px;
        margin: 0 auto;
    }

    .td-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .td-topbar h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .td-topbar p {
        font-size: .82rem;
        color: var(--muted);
        margin: .15rem 0 0;
    }

    .td-btn {
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

    .td-btn-primary {
        background: var(--indigo);
        color: #fff;
    }

    .td-btn-primary:hover {
        background: var(--indigo-lt);
        color: #fff;
        transform: translateY(-1px);
    }

    .td-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .td-btn-ghost:hover {
        border-color: var(--indigo);
        color: var(--indigo);
    }

    .td-btn-danger {
        background: none;
        border: 1.5px solid #fecaca;
        color: var(--danger);
    }

    .td-btn-danger:hover {
        background: #fef2f2;
    }

    .td-btn-sm {
        padding: .38rem .85rem;
        font-size: .78rem;
    }

    .td-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .td-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .td-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    /* stats */
    .td-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .td-stat {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem 1.25rem;
        position: relative;
        overflow: hidden;
    }

    .td-stat::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 100%;
        background: var(--bar-color, var(--indigo));
    }

    .td-stat-val {
        font-size: 1.55rem;
        font-weight: 700;
        line-height: 1;
        color: var(--bar-color, var(--indigo));
    }

    .td-stat-label {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: .3rem;
    }

    /* filters */
    .td-filters {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: .75rem;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: .9rem 1.2rem;
        margin-bottom: 1.25rem;
    }

    .td-search-wrap {
        position: relative;
        flex: 1;
        min-width: 200px;
        max-width: 320px;
    }

    .td-search-wrap svg {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
    }

    .td-search {
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

    .td-search:focus {
        border-color: var(--indigo);
    }

    .td-filter-select {
        padding: .56rem .85rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .82rem;
        color: var(--text-dim);
        background: var(--surface);
        outline: none;
        cursor: pointer;
        font-family: inherit;
    }

    .td-filter-select:focus {
        border-color: var(--indigo);
    }

    .td-count {
        margin-left: auto;
        font-size: .78rem;
        color: var(--muted);
    }

    .td-count strong {
        color: var(--text-dim);
    }

    /* table card */
    .td-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .td-card-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .9rem 1.4rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .td-card-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .86rem;
        font-weight: 600;
        color: var(--text);
    }

    .td-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .84rem;
    }

    .td-table thead {
        background: var(--surface);
    }

    .td-table th {
        padding: .75rem 1.1rem;
        text-align: left;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .td-table td {
        padding: .9rem 1.1rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .td-table tr:last-child td {
        border-bottom: none;
    }

    .td-table tbody tr {
        transition: background .15s;
    }

    .td-table tbody tr:hover {
        background: #fafafa;
    }

    /* title cell */
    .td-title-wrap {
        display: flex;
        align-items: flex-start;
        gap: .75rem;
    }

    .td-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #4f46e512;
        border: 1px solid #4f46e520;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--indigo);
        flex-shrink: 0;
    }

    .td-title-name {
        font-weight: 600;
        color: var(--text);
        font-size: .87rem;
        text-decoration: none;
        transition: color .15s;
        display: block;
    }

    .td-title-name:hover {
        color: var(--indigo);
    }

    .td-ref {
        font-size: .73rem;
        color: var(--muted);
        font-family: monospace;
        margin-top: .1rem;
    }

    /* badges */
    .td-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .22rem .65rem;
        border-radius: 100px;
        font-size: .71rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .td-badge-open {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .td-badge-closed {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .td-badge-expiring {
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #92400e;
    }

    .td-badge-expired {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    /* deadline */
    .td-deadline {
        font-size: .82rem;
        color: var(--text-dim);
    }

    .td-deadline.urgent {
        color: var(--red);
        font-weight: 600;
    }

    .td-deadline.expired {
        color: var(--muted);
        text-decoration: line-through;
    }

    /* budget */
    .td-budget {
        font-size: .85rem;
        font-weight: 600;
        color: var(--text);
    }

    .td-budget-none {
        font-size: .82rem;
        color: var(--muted);
        font-style: italic;
    }

    /* actions */
    .td-actions {
        display: flex;
        align-items: center;
        gap: .35rem;
    }

    .td-icon-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1px solid var(--border);
        background: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-dim);
        transition: all .15s;
        text-decoration: none;
    }

    .td-icon-btn:hover {
        border-color: var(--indigo);
        color: var(--indigo);
        background: #4f46e508;
    }

    .td-icon-btn.danger:hover {
        border-color: #fecaca;
        color: var(--danger);
        background: #fef2f2;
    }

    .td-icon-btn.success:hover {
        border-color: #bbf7d0;
        color: var(--green);
        background: #f0fdf4;
    }

    /* empty */
    .td-empty {
        text-align: center;
        padding: 4rem 2rem;
    }

    .td-empty-icon {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        background: #4f46e512;
        border: 1px solid #4f46e520;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--indigo);
    }

    .td-empty h5 {
        font-size: .96rem;
        font-weight: 600;
        color: var(--text);
        margin: 0 0 .4rem;
    }

    .td-empty p {
        font-size: .82rem;
        color: var(--muted);
        margin: 0 0 1.1rem;
    }

    /* pagination */
    .td-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        padding: .9rem 1.2rem;
        border-top: 1px solid var(--border);
    }

    .td-pagination-info {
        font-size: .78rem;
        color: var(--muted);
    }

    .td-pagination-info strong {
        color: var(--text-dim);
    }

    .td-pages {
        display: flex;
        gap: .3rem;
    }

    .td-page-btn {
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

    .td-page-btn:hover {
        border-color: var(--indigo);
        color: var(--indigo);
    }

    .td-page-btn.current {
        background: var(--indigo);
        color: #fff;
        border-color: var(--indigo);
        font-weight: 600;
    }

    .td-page-btn.disabled {
        opacity: .35;
        pointer-events: none;
    }

    /* modal */
    .td-modal .modal-content {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
        overflow: hidden;
    }

    .td-modal .modal-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 1rem 1.4rem;
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .td-modal-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .td-modal-icon.danger {
        background: #fef2f2;
        color: var(--danger);
    }

    .td-modal .modal-title {
        font-size: .92rem;
        font-weight: 700;
        color: var(--danger);
        margin: 0;
    }

    .td-modal .modal-body {
        padding: 1.4rem;
    }

    .td-modal .modal-footer {
        padding: .85rem 1.4rem;
        border-top: 1px solid var(--border);
        gap: .5rem;
    }

    .td-delete-box {
        font-size: .87rem;
        color: var(--text-dim);
        line-height: 1.6;
        padding: .85rem 1rem;
        border-radius: 8px;
        border: 1px solid #fecaca;
        background: #fef2f2;
    }

    .td-delete-box strong {
        color: var(--text);
    }
</style>

<div class="td-page">
    <div class="td-topbar">
        <div>
            <h4>Tenders</h4>
            <p>Publish and manage open tender opportunities.</p>
        </div>
        <a href="{{ route('admin.tenders.create') }}" class="td-btn td-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            Post Tender
        </a>
    </div>

    @if(session('success'))
    <div class="td-alert td-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="td-alert td-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4m0 4h.01" />
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="td-stats">
        <div class="td-stat" style="--bar-color:var(--indigo)">
            <div class="td-stat-val">{{ $stats['total'] }}</div>
            <div class="td-stat-label">Total</div>
        </div>
        <div class="td-stat" style="--bar-color:var(--green)">
            <div class="td-stat-val">{{ $stats['open'] }}</div>
            <div class="td-stat-label">Open</div>
        </div>
        <div class="td-stat" style="--bar-color:var(--muted)">
            <div class="td-stat-val">{{ $stats['closed'] }}</div>
            <div class="td-stat-label">Closed</div>
        </div>
        <div class="td-stat" style="--bar-color:var(--amber)">
            <div class="td-stat-val">{{ $stats['expiring_soon'] }}</div>
            <div class="td-stat-label">Expiring Soon</div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="td-filters">
        <div class="td-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input type="text" id="tdSearch" class="td-search" placeholder="Search title, reference, location…" oninput="filterTenders()">
        </div>
        <select id="tdStatusFilter" class="td-filter-select" onchange="filterTenders()">
            <option value="">All statuses</option>
            <option value="open">Open</option>
            <option value="closed">Closed</option>
        </select>
        <p class="td-count" id="tdCount"><strong>{{ $tenders->count() }}</strong> tender{{ $tenders->count()===1?'':'s' }}</p>
    </div>

    {{-- Table --}}
    <div class="td-card">
        <div class="td-card-toolbar">
            <div class="td-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--indigo)">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" x2="8" y1="13" y2="13" />
                    <line x1="16" x2="8" y1="17" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
                All Tenders
            </div>
        </div>
        <div style="overflow-x:auto">
            <table class="td-table">
                <thead>
                    <tr>
                        <th>Tender</th>
                        <th>Status</th>
                        <th>Budget</th>
                        <th>Deadline</th>
                        <th>Location</th>
                        <th>Posted By</th>
                        <th style="width:110px">Actions</th>
                    </tr>
                </thead>
                <tbody id="tdBody">
                    @forelse($tenders as $tender)
                    @php
                    $isExpired = $tender->submission_deadline < now();
                        $isUrgent=!$isExpired && $tender->submission_deadline <= now()->addDays(7);
                            $statusKey = $tender->is_open ? 'open' : 'closed';
                            @endphp
                            <tr data-name="{{ strtolower($tender->title . ' ' . $tender->reference_no . ' ' . $tender->location) }}"
                                data-status="{{ $statusKey }}">
                                <td>
                                    <div class="td-title-wrap">
                                        <div class="td-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                <polyline points="14 2 14 8 20 8" />
                                            </svg>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.tenders.show',$tender->id) }}" class="td-title-name">{{ $tender->title }}</a>
                                            @if($tender->reference_no)
                                            <div class="td-ref">{{ $tender->reference_no }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($isExpired)
                                    <span class="td-badge td-badge-expired">Expired</span>
                                    @elseif($isUrgent)
                                    <span class="td-badge td-badge-expiring">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="currentColor">
                                            <circle cx="12" cy="12" r="10" />
                                        </svg>
                                        Closing Soon
                                    </span>
                                    @elseif($tender->is_open)
                                    <span class="td-badge td-badge-open">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 24 24" fill="currentColor">
                                            <circle cx="12" cy="12" r="10" />
                                        </svg>
                                        Open
                                    </span>
                                    @else
                                    <span class="td-badge td-badge-closed">Closed</span>
                                    @endif
                                </td>
                                <td>
                                    @if($tender->budget)
                                    <span class="td-budget">RWF {{ number_format($tender->budget) }}</span>
                                    @else
                                    <span class="td-budget-none">Not specified</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="td-deadline {{ $isExpired ? 'expired' : ($isUrgent ? 'urgent' : '') }}">
                                        {{ $tender->submission_deadline->format('M j, Y') }}
                                    </div>
                                    @if(!$isExpired)
                                    <div style="font-size:.71rem;color:var(--muted);margin-top:.1rem">
                                        {{ $tender->submission_deadline->diffForHumans() }}
                                    </div>
                                    @endif
                                </td>
                                <td style="color:var(--text-dim);font-size:.82rem">{{ $tender->location ?? '—' }}</td>
                                <td>
                                    @if($tender->user)
                                    <div style="font-size:.82rem;color:var(--text-dim)">{{ $tender->user->name }}</div>
                                    @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="td-actions">
                                        <a href="{{ route('admin.tenders.show',$tender->id) }}" class="td-icon-btn" title="View">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.tenders.edit',$tender->id) }}" class="td-icon-btn" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.tenders.toggle',$tender->id) }}" style="display:inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="td-icon-btn {{ $tender->is_open ? 'danger' : 'success' }}" title="{{ $tender->is_open ? 'Close tender' : 'Reopen tender' }}">
                                                @if($tender->is_open)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect width="18" height="11" x="3" y="11" rx="2" />
                                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                                </svg>
                                                @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect width="18" height="11" x="3" y="11" rx="2" />
                                                    <path d="M7 11V7a5 5 0 0 1 9.9-1" />
                                                </svg>
                                                @endif
                                            </button>
                                        </form>
                                        <button class="td-icon-btn danger" data-bs-toggle="modal" data-bs-target="#deleteTender{{ $tender->id }}" title="Delete">
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
                                <td colspan="7">
                                    <div class="td-empty">
                                        <div class="td-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                <polyline points="14 2 14 8 20 8" />
                                            </svg></div>
                                        <h5>No tenders yet</h5>
                                        <p>Post your first tender opportunity.</p>
                                        <a href="{{ route('admin.tenders.create') }}" class="td-btn td-btn-primary td-btn-sm">Post Tender</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($tenders,'hasPages') && $tenders->hasPages())
        <div class="td-pagination">
            <p class="td-pagination-info">Showing <strong>{{ $tenders->firstItem() }}</strong>–<strong>{{ $tenders->lastItem() }}</strong> of <strong>{{ $tenders->total() }}</strong></p>
            <div class="td-pages">
                @if($tenders->onFirstPage())<span class="td-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m15 18-6-6 6-6" />
                    </svg></span>
                @else<a href="{{ $tenders->previousPageUrl() }}" class="td-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m15 18-6-6 6-6" />
                    </svg></a>@endif
                @foreach($tenders->getUrlRange(max(1,$tenders->currentPage()-2),min($tenders->lastPage(),$tenders->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="td-page-btn {{ $page==$tenders->currentPage()?'current':'' }}">{{ $page }}</a>
                @endforeach
                @if($tenders->hasMorePages())<a href="{{ $tenders->nextPageUrl() }}" class="td-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6" />
                    </svg></a>
                @else<span class="td-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6" />
                    </svg></span>@endif
            </div>
        </div>
        @endif
    </div>
</div>

@foreach($tenders as $tender)
<div class="modal fade td-modal" id="deleteTender{{ $tender->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.tenders.destroy',$tender->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="td-modal-icon danger"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                        <line x1="12" x2="12" y1="9" y2="13" />
                        <line x1="12" x2="12.01" y1="17" y2="17" />
                    </svg></div>
                <h5 class="modal-title">Delete Tender</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="td-delete-box">Delete tender <strong>{{ $tender->title }}</strong>? The attached document will also be permanently removed.<br><br><span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="td-btn td-btn-ghost td-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="td-btn td-btn-danger td-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                    </svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    function filterTenders() {
        const q = document.getElementById('tdSearch').value.toLowerCase();
        const status = document.getElementById('tdStatusFilter').value;
        const rows = document.querySelectorAll('#tdBody tr[data-name]');
        let shown = 0;
        rows.forEach(r => {
            const ok = r.dataset.name.includes(q) && (!status || r.dataset.status === status);
            r.style.display = ok ? '' : 'none';
            if (ok) shown++;
        });
        document.getElementById('tdCount').innerHTML = '<strong>' + shown + '</strong> tender' + (shown === 1 ? '' : 's');
    }
</script>
@endsection