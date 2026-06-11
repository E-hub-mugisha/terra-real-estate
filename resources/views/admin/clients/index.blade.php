@extends('layouts.app')

@section('title', 'Clients – Terra Admin')

@section('content')

<style>
    /* ─── Terra Admin Design Tokens ──────────────────────────── */
    :root {
        --tp: #D05208;
        --tp-dk: #19265d;
        --tp-lt: #f0faf5;
        --tp-border: #c3e6d3;
        --accent: #f0a500;
        --text: #1a1a2e;
        --muted: #6b7280;
        --border: #e5e7eb;
        --bg: #f9fafb;
        --white: #ffffff;
        --radius: 10px;
        --shadow: 0 2px 12px rgba(0, 0, 0, .07);
        --shadow-lg: 0 8px 32px rgba(0, 0, 0, .11);
        --danger: #dc2626;
        --danger-lt: #fee2e2;
    }

    /* ─── Page Header ─────────────────────────────────────────── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 24px;
    }

    .page-header-left h1 {
        font-size: 1.55rem;
        font-weight: 800;
        color: var(--text);
        margin: 0 0 4px;
    }

    .page-header-left h1 em {
        font-style: normal;
        color: var(--tp);
    }

    .page-header-left p {
        font-size: 13px;
        color: var(--muted);
        margin: 0;
    }

    /* ─── Stats Row ───────────────────────────────────────────── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 18px;
        box-shadow: var(--shadow);
    }

    .stat-card .stat-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
        margin-bottom: 6px;
    }

    .stat-card .stat-value {
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--text);
        line-height: 1;
    }

    .stat-card .stat-sub {
        font-size: 12px;
        color: var(--muted);
        margin-top: 4px;
    }

    .stat-card.green {
        border-left: 4px solid var(--tp);
    }

    .stat-card.amber {
        border-left: 4px solid var(--accent);
    }

    .stat-card.blue {
        border-left: 4px solid #3b82f6;
    }

    .stat-card.purple {
        border-left: 4px solid #8b5cf6;
    }

    /* ─── Toolbar ─────────────────────────────────────────────── */
    .toolbar {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 16px;
        box-shadow: var(--shadow);
    }

    .toolbar-search {
        flex: 1;
        min-width: 200px;
        max-width: 300px;
        position: relative;
    }

    .toolbar-search input {
        width: 100%;
        padding: 9px 12px 9px 36px;
        border: 1px solid var(--border);
        border-radius: 7px;
        font-size: 14px;
        color: var(--text);
        outline: none;
        transition: border-color .2s;
    }

    .toolbar-search input:focus {
        border-color: var(--tp);
    }

    .toolbar-search svg {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
    }

    .toolbar-select {
        padding: 9px 12px;
        border: 1px solid var(--border);
        border-radius: 7px;
        font-size: 14px;
        color: var(--text);
        background: var(--white);
        outline: none;
        cursor: pointer;
    }

    .toolbar-select:focus {
        border-color: var(--tp);
    }

    .toolbar-count {
        margin-left: auto;
        font-size: 13px;
        color: var(--muted);
        white-space: nowrap;
    }

    .toolbar-count strong {
        color: var(--text);
    }

    /* ─── Buttons ─────────────────────────────────────────────── */
    .btn-terra {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--tp);
        color: var(--white);
        font-size: 14px;
        font-weight: 600;
        padding: 9px 18px;
        border-radius: 7px;
        border: none;
        cursor: pointer;
        transition: background .2s;
        text-decoration: none;
    }

    .btn-terra:hover {
        background: var(--tp-dk);
        color: var(--white);
    }

    .btn-outline-terra {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        color: var(--tp);
        font-size: 13px;
        font-weight: 600;
        padding: 7px 14px;
        border-radius: 7px;
        border: 1.5px solid var(--tp);
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }

    .btn-outline-terra:hover {
        background: var(--tp);
        color: var(--white);
    }

    .btn-danger-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: transparent;
        color: var(--danger);
        font-size: 12px;
        font-weight: 600;
        padding: 5px 11px;
        border-radius: 6px;
        border: 1.5px solid #fca5a5;
        cursor: pointer;
        transition: all .2s;
    }

    .btn-danger-sm:hover {
        background: var(--danger);
        color: var(--white);
        border-color: var(--danger);
    }

    .btn-view-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0faf5;
        color: var(--tp);
        font-size: 12px;
        font-weight: 600;
        padding: 5px 11px;
        border-radius: 6px;
        border: 1px solid var(--tp-border);
        text-decoration: none;
        transition: all .2s;
    }

    .btn-view-sm:hover {
        background: var(--tp);
        color: var(--white);
    }

    .btn-edit-sm {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #fffbeb;
        color: #92400e;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 11px;
        border-radius: 6px;
        border: 1px solid #fde68a;
        cursor: pointer;
        transition: all .2s;
    }

    .btn-edit-sm:hover {
        background: var(--accent);
        color: var(--white);
        border-color: var(--accent);
    }

    /* ─── Table ───────────────────────────────────────────────── */
    .table-wrap {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }

    .clients-table {
        width: 100%;
        border-collapse: collapse;
    }

    .clients-table thead tr {
        background: var(--bg);
        border-bottom: 2px solid var(--border);
    }

    .clients-table thead th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
        white-space: nowrap;
    }

    .clients-table thead th.sortable {
        cursor: pointer;
        user-select: none;
    }

    .clients-table thead th.sortable:hover {
        color: var(--tp);
    }

    .clients-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }

    .clients-table tbody tr:last-child {
        border-bottom: none;
    }

    .clients-table tbody tr:hover {
        background: #fafcfb;
    }

    .clients-table td {
        padding: 13px 16px;
        font-size: 14px;
        vertical-align: middle;
    }

    .client-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--tp), var(--tp-dk));
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .client-name-cell {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .client-name {
        font-weight: 600;
        color: var(--text);
    }

    .client-nid {
        font-size: 11px;
        color: var(--muted);
        margin-top: 2px;
    }

    .type-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .type-owner {
        background: #d1fae5;
        color: #065f46;
    }

    .type-agent {
        background: #dbeafe;
        color: #1e40af;
    }

    .type-developer {
        background: #ede9fe;
        color: #5b21b6;
    }

    .type-company {
        background: #fef3c7;
        color: #92400e;
    }

    .status-dot {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }

    .status-dot::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .status-active::before {
        background: #10b981;
    }

    .status-inactive::before {
        background: #9ca3af;
    }

    .prop-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 600;
        color: var(--tp);
    }

    .actions-cell {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* ─── Empty State ─────────────────────────────────────────── */
    .empty-row td {
        padding: 60px 24px;
        text-align: center;
    }

    .empty-icon {
        font-size: 44px;
        margin-bottom: 12px;
    }

    .empty-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 6px;
    }

    .empty-sub {
        font-size: 13px;
        color: var(--muted);
    }

    /* ─── Pagination ──────────────────────────────────────────── */
    .pagi-wrap {
        padding: 16px 18px;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pagi-info {
        font-size: 13px;
        color: var(--muted);
    }

    .pagi-wrap .pagination {
        margin: 0;
    }

    .pagi-wrap .page-link {
        border-radius: 6px !important;
        font-size: 13px;
        color: var(--tp);
        border-color: var(--border);
        padding: 6px 12px;
    }

    .pagi-wrap .page-item.active .page-link {
        background: var(--tp);
        border-color: var(--tp);
        color: var(--white);
    }

    /* ─── Alert ───────────────────────────────────────────────── */
    .alert-terra {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 16px;
        border-radius: var(--radius);
        margin-bottom: 18px;
        font-size: 14px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background: var(--danger-lt);
        color: var(--danger);
        border: 1px solid #fca5a5;
    }

    /* ─── Modal Base ──────────────────────────────────────────── */
    .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--tp), var(--tp-dk));
        padding: 18px 22px;
        border-bottom: none;
    }

    .modal-header .modal-title {
        color: var(--white);
        font-size: 16px;
        font-weight: 700;
    }

    .modal-header .btn-close {
        filter: invert(1);
        opacity: .8;
    }

    .modal-body {
        padding: 22px;
    }

    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid var(--border);
        background: var(--bg);
    }

    .form-label-terra {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
        margin-bottom: 6px;
        display: block;
    }

    .form-control-terra,
    .form-select-terra {
        width: 100%;
        padding: 9px 13px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: 14px;
        color: var(--text);
        background: var(--white);
        outline: none;
        transition: border-color .2s;
        font-family: inherit;
    }

    .form-control-terra:focus,
    .form-select-terra:focus {
        border-color: var(--tp);
        box-shadow: 0 0 0 3px rgba(44, 110, 73, .1);
    }

    .form-control-terra.is-invalid,
    .form-select-terra.is-invalid {
        border-color: var(--danger);
    }

    .field-error {
        font-size: 12px;
        color: var(--danger);
        margin-top: 4px;
        display: none;
    }

    .field-error.show {
        display: block;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media(max-width:576px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .form-section-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--muted);
        padding-bottom: 8px;
        border-bottom: 1px solid var(--border);
        margin: 18px 0 14px;
    }

    /* Delete modal */
    .delete-modal .modal-header {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
    }

    .delete-warning {
        background: var(--danger-lt);
        border: 1px solid #fca5a5;
        border-radius: 8px;
        padding: 14px 16px;
        font-size: 14px;
        color: #7f1d1d;
        margin-bottom: 16px;
    }

    .delete-confirm-info {
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 14px 16px;
    }

    .delete-confirm-name {
        font-weight: 700;
        font-size: 15px;
        color: var(--text);
    }

    .delete-confirm-sub {
        font-size: 13px;
        color: var(--muted);
        margin-top: 2px;
    }

    .btn-confirm-delete {
        background: var(--danger);
        color: var(--white);
        border: none;
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 20px;
        cursor: pointer;
        transition: background .2s;
    }

    .btn-confirm-delete:hover {
        background: #b91c1c;
    }

    .btn-cancel {
        background: var(--white);
        color: var(--text);
        border: 1.5px solid var(--border);
        border-radius: 7px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 20px;
        cursor: pointer;
        transition: all .2s;
    }

    .btn-cancel:hover {
        border-color: var(--tp);
        color: var(--tp);
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- ── FLASH MESSAGES ──────────────────────────────────── --}}
    @if(session('success'))
    <div class="alert-terra alert-success">
        ✅ {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert-terra alert-error">
        ⚠️ {{ session('error') }}
    </div>
    @endif

    {{-- ── PAGE HEADER ─────────────────────────────────────── --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1>Client <em>Registry</em></h1>
            <p>All registered property owners, agents, and developers on Terra</p>
        </div>
        <button class="btn-terra" onclick="openAddModal()">
            <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                <path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
            </svg>
            Register Client
        </button>
    </div>

    {{-- ── STATS ───────────────────────────────────────────── --}}
    <div class="stats-row">
        <div class="stat-card green">
            <div class="stat-label">Total Clients</div>
            <div class="stat-value">{{ $stats['total'] ?? $clients->total() }}</div>
            <div class="stat-sub">All registered</div>
        </div>
        <div class="stat-card amber">
            <div class="stat-label">Owners</div>
            <div class="stat-value">{{ $stats['owners'] ?? \App\Models\Client::where('client_type','owner')->count() }}</div>
            <div class="stat-sub">Property owners</div>
        </div>
        <div class="stat-card blue">
            <div class="stat-label">Agents</div>
            <div class="stat-value">{{ $stats['agents'] ?? \App\Models\Client::where('client_type','agent')->count() }}</div>
            <div class="stat-sub">Licensed agents</div>
        </div>
        <div class="stat-card purple">
            <div class="stat-label">Developers</div>
            <div class="stat-value">{{ $stats['developers'] ?? \App\Models\Client::whereIn('client_type',['developer','company'])->count() }}</div>
            <div class="stat-sub">Developers & companies</div>
        </div>
    </div>

    {{-- ── TOOLBAR ─────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.clients.index') }}" class="toolbar">
        <div class="toolbar-search">
            <svg width="15" height="15" viewBox="0 0 20 20" fill="none">
                <circle cx="8.5" cy="8.5" r="5.75" stroke="currentColor" stroke-width="1.7" />
                <path d="M13 13l4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
            </svg>
            <input type="text" name="search" placeholder="Search name, phone, email…"
                value="{{ request('search') }}" autocomplete="off">
        </div>

        <select name="type" class="toolbar-select" onchange="this.form.submit()">
            <option value="">All Types</option>
            <option value="owner" {{ request('type')=='owner'     ?'selected':'' }}>Owner</option>
            <option value="agent" {{ request('type')=='agent'     ?'selected':'' }}>Agent</option>
            <option value="developer" {{ request('type')=='developer' ?'selected':'' }}>Developer</option>
            <option value="company" {{ request('type')=='company'   ?'selected':'' }}>Company</option>
        </select>

        <select name="district" class="toolbar-select" onchange="this.form.submit()">
            <option value="">All Districts</option>
            @foreach(['Gasabo','Kicukiro','Nyarugenge','Bugesera','Gatsibo','Kayonza','Kirehe',
            'Ngoma','Rwamagana','Burera','Gakenke','Gicumbi','Musanze','Rulindo',
            'Gisagara','Huye','Kamonyi','Muhanga','Nyamagabe','Nyanza','Nyaruguru',
            'Ruhango','Karongi','Ngororero','Nyabihu','Nyamasheke','Rubavu','Rusizi',
            'Rutsiro','Nyagatare'] as $d)
            <option value="{{ $d }}" {{ request('district')==$d ?'selected':'' }}>{{ $d }}</option>
            @endforeach
        </select>

        <select name="status" class="toolbar-select" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="1" {{ request('status')==='1' ?'selected':'' }}>Active</option>
            <option value="0" {{ request('status')==='0' ?'selected':'' }}>Inactive</option>
        </select>

        <button type="submit" class="btn-terra" style="padding:9px 16px;">Search</button>

        @if(request()->hasAny(['search','type','district','status']))
        <a href="{{ route('admin.clients.index') }}" class="btn-outline-terra">✕ Clear</a>
        @endif

        <span class="toolbar-count">
            <strong>{{ $clients->total() }}</strong> clients
        </span>
    </form>

    {{-- ── TABLE ───────────────────────────────────────────── --}}
    <div class="table-wrap">
        <table class="clients-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Properties</th>
                    <th>Status</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    {{-- # --}}
                    <td style="color:var(--muted); font-size:13px;">
                        {{ $clients->firstItem() + $loop->index }}
                    </td>

                    {{-- Client name + NID --}}
                    <td>
                        <div class="client-name-cell">
                            <div class="client-avatar">
                                {{ strtoupper(substr($client->full_name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="client-name">{{ $client->full_name }}</div>
                                @if($client->national_id)
                                <div class="client-nid">NID: {{ $client->national_id }}</div>
                                @endif
                                @if($client->company_name)
                                <div class="client-nid">🏢 {{ $client->company_name }}</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Contact --}}
                    <td>
                        <div style="font-size:14px; font-weight:500;">{{ $client->phone }}</div>
                        @if($client->email)
                        <div style="font-size:12px; color:var(--muted);">{{ $client->email }}</div>
                        @endif
                    </td>

                    {{-- Location --}}
                    <td style="font-size:13px; color:var(--muted);">
                        @if($client->district)
                        📍 {{ $client->district }}
                        @if($client->province) · {{ $client->province }} @endif
                        @else
                        —
                        @endif
                    </td>

                    {{-- Property count --}}
                    <td>
                        <!-- client properties count house and land -->
                        <span class="prop-count">
                            🏠 {{ $client->properties_count }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="status-dot {{ $client->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $client->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>

                    {{-- Date --}}
                    <td style="font-size:12px; color:var(--muted); white-space:nowrap;">
                        {{ $client->created_at->format('d M Y') }}
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('admin.clients.show', $client->id) }}"
                                class="btn-view-sm" title="View details">
                                👁
                            </a>
                            <button class="btn-edit-sm" title="Edit"
                                onclick="openEditModal({{ $client->id }})">
                                ✏️
                            </button>
                            <button class="btn-danger-sm" title="Delete"
                                onclick="openDeleteModal({{ $client->id }}, '{{ addslashes($client->full_name) }}', '{{ $client->phone }}', {{ $client->properties_count }})">
                                🗑
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="9">
                        <div class="empty-icon">👥</div>
                        <div class="empty-title">No clients found</div>
                        <div class="empty-sub">
                            @if(request()->hasAny(['search','type','district','status']))
                            Try adjusting your filters.
                            @else
                            Register the first client to get started.
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($clients->hasPages())
        <div class="pagi-wrap">
            <span class="pagi-info">
                Showing {{ $clients->firstItem() }}–{{ $clients->lastItem() }}
                of {{ $clients->total() }} clients
            </span>
            {{ $clients->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>{{-- /container --}}


{{-- ════════════════════════════════════════════════════════
     ADD CLIENT MODAL
     ════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">➕ Register New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="addClientForm" method="POST" action="{{ route('admin.clients.store') }}" novalidate>
                @csrf
                <div class="modal-body">

                    {{-- Personal Info --}}
                    <div class="form-section-title">Personal Information</div>
                    <div class="form-grid-2">
                        <div>
                            <label class="form-label-terra">Full Name *</label>
                            <input type="text" name="full_name" id="add_full_name"
                                class="form-control-terra" placeholder="e.g. Jean Paul Nkurunziza" required>
                            <span class="field-error" id="err_add_full_name"></span>
                        </div>
                        <div>
                            <label class="form-label-terra">National ID (NID)</label>
                            <input type="text" name="national_id" id="add_national_id"
                                class="form-control-terra" placeholder="16-digit Rwanda NID">
                            <span class="field-error" id="err_add_national_id"></span>
                        </div>
                        <div>
                            <label class="form-label-terra">Phone *</label>
                            <input type="tel" name="phone" id="add_phone"
                                class="form-control-terra" placeholder="+250 7xx xxx xxx" required>
                            <span class="field-error" id="err_add_phone"></span>
                        </div>
                        <div>
                            <label class="form-label-terra">Email</label>
                            <input type="email" name="email" id="add_email"
                                class="form-control-terra" placeholder="optional">
                            <span class="field-error" id="err_add_email"></span>
                        </div>
                    </div>

                    {{-- Client Type --}}
                    <div class="form-section-title">Client Classification</div>
                    <div class="form-grid-2">
                        <div>
                            <label class="form-label-terra">Client Type *</label>
                            <select name="client_type" id="add_client_type" class="form-select-terra"
                                onchange="toggleCompanyField('add')">
                                <option value="owner">Owner</option>
                                <option value="agent">Agent</option>
                                <option value="developer">Developer</option>
                                <option value="company">Company</option>
                            </select>
                        </div>
                        <div id="add_company_wrap">
                            <label class="form-label-terra">Company Name</label>
                            <input type="text" name="company_name" id="add_company_name"
                                class="form-control-terra" placeholder="Company / Organization">
                        </div>
                    </div>

                    {{-- Location --}}
                    <div class="form-section-title">Location</div>
                    <div class="form-grid-2">
                        <div>
                            <label class="form-label-terra">Province</label>
                            <select name="province" id="add_province" class="form-select-terra">
                                <option value="">Select province</option>
                                <option value="Kigali City">Kigali City</option>
                                <option value="Northern">Northern</option>
                                <option value="Southern">Southern</option>
                                <option value="Eastern">Eastern</option>
                                <option value="Western">Western</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label-terra">District</label>
                            <select name="district" id="add_district" class="form-select-terra">
                                <option value="">Select district</option>
                                @foreach(['Gasabo','Kicukiro','Nyarugenge','Bugesera','Gatsibo','Kayonza','Kirehe',
                                'Ngoma','Rwamagana','Burera','Gakenke','Gicumbi','Musanze','Rulindo',
                                'Gisagara','Huye','Kamonyi','Muhanga','Nyamagabe','Nyanza','Nyaruguru',
                                'Ruhango','Karongi','Ngororero','Nyabihu','Nyamasheke','Rubavu','Rusizi',
                                'Rutsiro','Nyagatare'] as $d)
                                <option value="{{ $d }}">{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label-terra">Sector</label>
                            <input type="text" name="sector" id="add_sector"
                                class="form-control-terra" placeholder="e.g. Kimironko">
                        </div>
                    </div>

                    {{-- Status + Notes --}}
                    <div class="form-section-title">Additional</div>
                    <div class="form-grid-2">
                        <div>
                            <label class="form-label-terra">Status</label>
                            <select name="is_active" class="form-select-terra">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top:14px;">
                        <label class="form-label-terra">Notes</label>
                        <textarea name="notes" class="form-control-terra" rows="3"
                            placeholder="Any notes about this client…" style="resize:vertical;"></textarea>
                    </div>

                </div>{{-- /modal-body --}}

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-terra" id="addSubmitBtn">
                        Save Client →
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     EDIT CLIENT MODAL
     ════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">✏️ Edit Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editClientForm" method="POST" action="" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div id="editLoadingState" style="text-align:center; padding:40px; color:var(--muted);">
                        <div class="spinner-border spinner-border-sm text-success me-2"></div>
                        Loading client data…
                    </div>
                    <div id="editFormFields" style="display:none;">

                        <div class="form-section-title">Personal Information</div>
                        <div class="form-grid-2">
                            <div>
                                <label class="form-label-terra">Full Name *</label>
                                <input type="text" name="full_name" id="edit_full_name"
                                    class="form-control-terra" required>
                                <span class="field-error" id="err_edit_full_name"></span>
                            </div>
                            <div>
                                <label class="form-label-terra">National ID (NID)</label>
                                <input type="text" name="national_id" id="edit_national_id"
                                    class="form-control-terra">
                                <span class="field-error" id="err_edit_national_id"></span>
                            </div>
                            <div>
                                <label class="form-label-terra">Phone *</label>
                                <input type="tel" name="phone" id="edit_phone"
                                    class="form-control-terra" required>
                                <span class="field-error" id="err_edit_phone"></span>
                            </div>
                            <div>
                                <label class="form-label-terra">Email</label>
                                <input type="email" name="email" id="edit_email"
                                    class="form-control-terra">
                                <span class="field-error" id="err_edit_email"></span>
                            </div>
                        </div>

                        <div class="form-section-title">Client Classification</div>
                        <div class="form-grid-2">
                            <div>
                                <label class="form-label-terra">Client Type *</label>
                                <select name="client_type" id="edit_client_type" class="form-select-terra"
                                    onchange="toggleCompanyField('edit')">
                                    <option value="owner">Owner</option>
                                    <option value="agent">Agent</option>
                                    <option value="developer">Developer</option>
                                    <option value="company">Company</option>
                                </select>
                            </div>
                            <div id="edit_company_wrap">
                                <label class="form-label-terra">Company Name</label>
                                <input type="text" name="company_name" id="edit_company_name"
                                    class="form-control-terra" placeholder="Company / Organization">
                            </div>
                        </div>

                        <div class="form-section-title">Location</div>
                        <div class="form-grid-2">
                            <div>
                                <label class="form-label-terra">Province</label>
                                <select name="province" id="edit_province" class="form-select-terra">
                                    <option value="">Select province</option>
                                    <option value="Kigali City">Kigali City</option>
                                    <option value="Northern">Northern</option>
                                    <option value="Southern">Southern</option>
                                    <option value="Eastern">Eastern</option>
                                    <option value="Western">Western</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label-terra">District</label>
                                <select name="district" id="edit_district" class="form-select-terra">
                                    <option value="">Select district</option>
                                    @foreach(['Gasabo','Kicukiro','Nyarugenge','Bugesera','Gatsibo','Kayonza','Kirehe',
                                    'Ngoma','Rwamagana','Burera','Gakenke','Gicumbi','Musanze','Rulindo',
                                    'Gisagara','Huye','Kamonyi','Muhanga','Nyamagabe','Nyanza','Nyaruguru',
                                    'Ruhango','Karongi','Ngororero','Nyabihu','Nyamasheke','Rubavu','Rusizi',
                                    'Rutsiro','Nyagatare'] as $d)
                                    <option value="{{ $d }}">{{ $d }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label-terra">Sector</label>
                                <input type="text" name="sector" id="edit_sector" class="form-control-terra">
                            </div>
                        </div>

                        <div class="form-section-title">Additional</div>
                        <div class="form-grid-2">
                            <div>
                                <label class="form-label-terra">Status</label>
                                <select name="is_active" id="edit_is_active" class="form-select-terra">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-top:14px;">
                            <label class="form-label-terra">Notes</label>
                            <textarea name="notes" id="edit_notes" class="form-control-terra" rows="3"
                                style="resize:vertical;"></textarea>
                        </div>

                    </div>{{-- /editFormFields --}}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-terra" id="editSubmitBtn">
                        Save Changes →
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     DELETE CONFIRMATION MODAL
     ════════════════════════════════════════════════════════ --}}
<div class="modal fade delete-modal" id="deleteClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">🗑️ Delete Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="deleteClientForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">

                    <div class="delete-warning">
                        ⚠️ This action is permanent and cannot be undone. The client record will be deleted.
                        <span id="deletePropertyWarning" style="display:none;">
                            <br><br><strong>Note:</strong> This client has linked properties — their
                            <code>client_id</code> will be set to <code>null</code> (properties are kept).
                        </span>
                    </div>

                    <div class="delete-confirm-info">
                        <div class="client-avatar" id="deleteAvatar" style="width:44px;height:44px;font-size:18px;">
                            ?
                        </div>
                        <div>
                            <div class="delete-confirm-name" id="deleteClientName">—</div>
                            <div class="delete-confirm-sub" id="deleteClientSub">—</div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-confirm-delete">
                        Yes, Delete Client
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ════════════════════════════════════════════════════════
     SCRIPTS
     ════════════════════════════════════════════════════════ --}}
<script>
    // ── Open Add modal ───────────────────────────────────────────
    function openAddModal() {
        document.getElementById('addClientForm').reset();
        clearErrors('add');
        toggleCompanyField('add');
        new bootstrap.Modal(document.getElementById('addClientModal')).show();
    }

    // ── Open Edit modal ──────────────────────────────────────────
    function openEditModal(id) {
        const modal = new bootstrap.Modal(document.getElementById('editClientModal'));
        document.getElementById('editLoadingState').style.display = 'block';
        document.getElementById('editFormFields').style.display = 'none';
        clearErrors('edit');
        modal.show();

        fetch(`{{ url('admin/clients') }}/${id}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(data => {
                const c = data.client;
                // Set form action
                document.getElementById('editClientForm').action =
                    `{{ url('admin/clients') }}/${c.id}`;
                // Fill fields
                setValue('edit_full_name', c.full_name);
                setValue('edit_national_id', c.national_id ?? '');
                setValue('edit_phone', c.phone);
                setValue('edit_email', c.email ?? '');
                setValue('edit_client_type', c.client_type);
                setValue('edit_company_name', c.company_name ?? '');
                setValue('edit_province', c.province ?? '');
                setValue('edit_district', c.district ?? '');
                setValue('edit_sector', c.sector ?? '');
                setValue('edit_notes', c.notes ?? '');
                document.getElementById('edit_is_active').value = c.is_active ? '1' : '0';
                toggleCompanyField('edit');

                document.getElementById('editLoadingState').style.display = 'none';
                document.getElementById('editFormFields').style.display = 'block';
            })
            .catch(() => {
                document.getElementById('editLoadingState').innerHTML =
                    '<span style="color:var(--danger);">Failed to load client. Please try again.</span>';
            });
    }

    // ── Open Delete modal ────────────────────────────────────────
    function openDeleteModal(id, name, phone, propCount) {
        document.getElementById('deleteClientForm').action = `{{ url('admin/clients') }}/${id}`;
        document.getElementById('deleteClientName').textContent = name;
        document.getElementById('deleteClientSub').textContent = phone;
        document.getElementById('deleteAvatar').textContent = name.charAt(0).toUpperCase();
        document.getElementById('deletePropertyWarning').style.display =
            propCount > 0 ? 'inline' : 'none';
        new bootstrap.Modal(document.getElementById('deleteClientModal')).show();
    }

    // ── Helpers ──────────────────────────────────────────────────
    function setValue(id, val) {
        const el = document.getElementById(id);
        if (!el) return;
        if (el.tagName === 'TEXTAREA' || el.tagName === 'INPUT') el.value = val;
        else if (el.tagName === 'SELECT') el.value = val;
    }

    function toggleCompanyField(prefix) {
        const type = document.getElementById(`${prefix}_client_type`).value;
        const wrap = document.getElementById(`${prefix}_company_wrap`);
        wrap.style.display = (type === 'company' || type === 'developer') ? 'block' : 'none';
    }

    function clearErrors(prefix) {
        document.querySelectorAll(`[id^="err_${prefix}_"]`).forEach(el => {
            el.textContent = '';
            el.classList.remove('show');
        });
        document.querySelectorAll(`#${prefix}ClientForm .form-control-terra,
                               #${prefix}ClientForm .form-select-terra`).forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    // ── Client-side form validation ──────────────────────────────
    function validateForm(prefix) {
        clearErrors(prefix);
        let valid = true;

        const name = document.getElementById(`${prefix}_full_name`);
        const phone = document.getElementById(`${prefix}_phone`);

        if (!name.value.trim()) {
            showError(`err_${prefix}_full_name`, 'Full name is required.');
            name.classList.add('is-invalid');
            valid = false;
        }
        if (!phone.value.trim()) {
            showError(`err_${prefix}_phone`, 'Phone number is required.');
            phone.classList.add('is-invalid');
            valid = false;
        } else if (!/^[+\d\s\-()]{7,20}$/.test(phone.value.trim())) {
            showError(`err_${prefix}_phone`, 'Enter a valid phone number.');
            phone.classList.add('is-invalid');
            valid = false;
        }

        const email = document.getElementById(`${prefix}_email`);
        if (email && email.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            showError(`err_${prefix}_email`, 'Enter a valid email address.');
            email.classList.add('is-invalid');
            valid = false;
        }

        return valid;
    }

    function showError(elId, msg) {
        const el = document.getElementById(elId);
        if (el) {
            el.textContent = msg;
            el.classList.add('show');
        }
    }

    // Attach submit handlers
    document.getElementById('addClientForm').addEventListener('submit', function(e) {
        if (!validateForm('add')) {
            e.preventDefault();
            return;
        }
        document.getElementById('addSubmitBtn').disabled = true;
        document.getElementById('addSubmitBtn').textContent = 'Saving…';
    });
    document.getElementById('editClientForm').addEventListener('submit', function(e) {
        if (!validateForm('edit')) {
            e.preventDefault();
            return;
        }
        document.getElementById('editSubmitBtn').disabled = true;
        document.getElementById('editSubmitBtn').textContent = 'Saving…';
    });

    // Init company field visibility on load
    document.addEventListener('DOMContentLoaded', function() {
        toggleCompanyField('add');
    });
</script>

@endsection