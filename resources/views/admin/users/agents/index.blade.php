@extends('layouts.app')
@section('title', 'Agents')
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
        --green: #22c55e;
        --amber: #f59e0b;
        --blue: #3b82f6;
    }

    .ag-page {
        padding: 1.75rem 0 3rem;
        max-width: 1320px;
        margin: 0 auto;
    }

    /* ── Top bar ── */
    .ag-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .ag-topbar h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
    }

    .ag-topbar p {
        font-size: .82rem;
        color: var(--muted);
        margin: .15rem 0 0;
    }

    /* ── Buttons ── */
    .ag-btn {
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

    .ag-btn-primary {
        background: var(--accent);
        color: #fff;
    }

    .ag-btn-primary:hover {
        background: var(--accent-lt);
        color: #fff;
        transform: translateY(-1px);
    }

    .ag-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .ag-btn-ghost:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    .ag-btn-danger {
        background: none;
        border: 1.5px solid #fecaca;
        color: var(--danger);
    }

    .ag-btn-danger:hover {
        background: #fef2f2;
    }

    .ag-btn-sm {
        padding: .38rem .85rem;
        font-size: .78rem;
    }

    /* ── Alerts ── */
    .ag-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .ag-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .ag-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    /* ── Stats ── */
    .ag-stats {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .ag-stat {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem 1.25rem;
    }

    .ag-stat-val {
        font-size: 1.55rem;
        font-weight: 700;
        line-height: 1;
    }

    .ag-stat-val.accent {
        color: var(--accent);
    }

    .ag-stat-val.green {
        color: var(--green);
    }

    .ag-stat-val.amber {
        color: var(--amber);
    }

    .ag-stat-val.blue {
        color: var(--blue);
    }

    .ag-stat-label {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: .3rem;
    }

    /* ── Filters ── */
    .ag-filters {
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

    .ag-search-wrap {
        position: relative;
        flex: 1;
        min-width: 200px;
        max-width: 320px;
    }

    .ag-search-wrap svg {
        position: absolute;
        left: .85rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
    }

    .ag-search {
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

    .ag-search:focus {
        border-color: var(--accent);
    }

    .ag-filter-select {
        padding: .56rem .85rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .82rem;
        color: var(--text-dim);
        background: var(--surface);
        outline: none;
        cursor: pointer;
        font-family: inherit;
        transition: border-color .2s;
    }

    .ag-filter-select:focus {
        border-color: var(--accent);
    }

    .ag-count {
        margin-left: auto;
        font-size: .78rem;
        color: var(--muted);
        white-space: nowrap;
    }

    .ag-count strong {
        color: var(--text-dim);
    }

    /* ── Table card ── */
    .ag-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .ag-card-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .9rem 1.4rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .ag-card-title {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .86rem;
        font-weight: 600;
        color: var(--text);
    }

    .ag-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .84rem;
    }

    .ag-table thead {
        background: var(--surface);
    }

    .ag-table th {
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

    .ag-table td {
        padding: .9rem 1.1rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .ag-table tr:last-child td {
        border-bottom: none;
    }

    .ag-table tbody tr {
        transition: background .15s;
    }

    .ag-table tbody tr:hover {
        background: #fafafa;
    }

    /* ── Agent cell ── */
    .ag-agent-cell {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .ag-avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }

    .ag-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border);
    }

    .ag-avatar-initials {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .8rem;
        color: #fff;
        border: 2px solid rgba(201, 169, 110, .3);
        flex-shrink: 0;
    }

    .ag-online-dot {
        position: absolute;
        bottom: 1px;
        right: 1px;
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: var(--green);
        border: 1.5px solid #fff;
    }

    .ag-agent-name {
        font-weight: 600;
        color: var(--text);
        font-size: .87rem;
        text-decoration: none;
        transition: color .15s;
    }

    .ag-agent-name:hover {
        color: var(--accent);
    }

    .ag-agent-role {
        font-size: .75rem;
        color: var(--muted);
        margin-top: .1rem;
    }

    /* ── Rating ── */
    .ag-rating {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .22rem .6rem;
        border-radius: 100px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        font-size: .72rem;
        font-weight: 700;
        color: #92400e;
    }

    /* ── Stat mini ── */
    .ag-mini-stats {
        display: flex;
        gap: 1.25rem;
    }

    .ag-mini-stat {
        text-align: center;
    }

    .ag-mini-val {
        font-size: .88rem;
        font-weight: 700;
        color: var(--text);
        display: block;
    }

    .ag-mini-label {
        font-size: .68rem;
        color: var(--muted);
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    /* ── Contact buttons ── */
    .ag-contact {
        display: flex;
        gap: .4rem;
    }

    .ag-contact-btn {
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

    .ag-contact-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: #c9a96e08;
    }

    .ag-contact-btn.phone:hover {
        border-color: #bbf7d0;
        color: var(--green);
        background: #f0fdf4;
    }

    /* ── Actions ── */
    .ag-actions {
        display: flex;
        align-items: center;
        gap: .35rem;
    }

    .ag-icon-btn {
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

    .ag-icon-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: #c9a96e08;
    }

    .ag-icon-btn.danger:hover {
        border-color: #fecaca;
        color: var(--danger);
        background: #fef2f2;
    }

    /* ── Experience badge ── */
    .ag-exp-badge {
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

    /* ── Empty ── */
    .ag-empty {
        text-align: center;
        padding: 4rem 2rem;
    }

    .ag-empty-icon {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        background: #c9a96e12;
        border: 1px solid #c9a96e28;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--accent);
    }

    .ag-empty h5 {
        font-size: .96rem;
        font-weight: 600;
        color: var(--text);
        margin: 0 0 .4rem;
    }

    .ag-empty p {
        font-size: .82rem;
        color: var(--muted);
        margin: 0 0 1.1rem;
    }

    /* ── Pagination ── */
    .ag-pagination {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: .75rem;
        padding: .9rem 1.2rem;
        border-top: 1px solid var(--border);
    }

    .ag-pagination-info {
        font-size: .78rem;
        color: var(--muted);
    }

    .ag-pagination-info strong {
        color: var(--text-dim);
    }

    .ag-pages {
        display: flex;
        gap: .3rem;
    }

    .ag-page-btn {
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

    .ag-page-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    .ag-page-btn.current {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
        font-weight: 600;
    }

    .ag-page-btn.disabled {
        opacity: .35;
        pointer-events: none;
    }

    /* ── Delete modal ── */
    .ag-modal .modal-content {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
        overflow: hidden;
    }

    .ag-modal .modal-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 1rem 1.4rem;
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .ag-modal-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: #fef2f2;
        color: var(--danger);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .ag-modal .modal-title {
        font-size: .92rem;
        font-weight: 700;
        color: var(--danger);
        margin: 0;
    }

    .ag-modal .modal-body {
        padding: 1.4rem;
    }

    .ag-modal .modal-footer {
        padding: .85rem 1.4rem;
        border-top: 1px solid var(--border);
        gap: .5rem;
    }

    .ag-delete-box {
        font-size: .87rem;
        color: var(--text-dim);
        line-height: 1.6;
        padding: .85rem 1rem;
        border-radius: 8px;
        border: 1px solid #fecaca;
        background: #fef2f2;
    }

    .ag-delete-box strong {
        color: var(--text);
    }

    @media (max-width: 768px) {
        .ag-mini-stats {
            display: none;
        }

        .ag-count {
            display: none;
        }
    }
</style>

<div class="ag-page">

    {{-- ── Top bar ── --}}
    <div class="ag-topbar">
        <div>
            <h4>Agents</h4>
            <p>Manage all registered agents and their performance.</p>
        </div>
        <a href="{{ route('admin.agents.create') }}" class="ag-btn ag-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            Add Agent
        </a>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
    <div class="ag-alert ag-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="ag-alert ag-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4m0 4h.01" />
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="ag-stats">
        <div class="ag-stat">
            <div class="ag-stat-val accent">{{ $agents->count() }}</div>
            <div class="ag-stat-label">Total Agents</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val green">{{ $agents->where('status','active')->count() }}</div>
            <div class="ag-stat-label">Active</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val amber">{{ number_format($agents->avg('rating'), 1) }}</div>
            <div class="ag-stat-label">Avg Rating</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val blue">{{ number_format($agents->avg('years_experience'), 0) }}</div>
            <div class="ag-stat-label">Avg Exp. (yrs)</div>
        </div>
    </div>

    {{-- ── Filters ── --}}
    <div class="ag-filters">
        <div class="ag-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input type="text" id="agSearch" class="ag-search"
                placeholder="Search name, role, email…" oninput="filterAgents()">
        </div>
        <select id="agRoleFilter" class="ag-filter-select" onchange="filterAgents()">
            <option value="">All roles</option>
            @foreach($agents->pluck('role')->unique()->filter() as $role)
            <option value="{{ strtolower($role) }}">{{ $role }}</option>
            @endforeach
        </select>
        <select id="agExpFilter" class="ag-filter-select" onchange="filterAgents()">
            <option value="">All experience</option>
            <option value="1">0–2 years</option>
            <option value="3">3–5 years</option>
            <option value="6">6–10 years</option>
            <option value="10">10+ years</option>
        </select>
        <p class="ag-count" id="agCount">
            <strong>{{ $agents->count() }}</strong> agent{{ $agents->count() === 1 ? '' : 's' }}
        </p>
    </div>

    {{-- ── Table ── --}}
    <div class="ag-card">
        <div class="ag-card-toolbar">
            <div class="ag-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--accent)">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
                All Agents
            </div>
            <div style="display:flex;gap:.4rem;">
                <span style="font-size:.73rem;color:var(--muted);align-self:center;">
                    {{ $agents->count() }} total
                </span>
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="ag-table">
                <thead>
                    <tr>
                        <th style="width:48px">
                            <input type="checkbox" id="selectAll" style="cursor:pointer;accent-color:var(--accent);">
                        </th>
                        <th>Agent</th>
                        <th>Role</th>
                        <th>Rating</th>
                        <th>Experience</th>
                        <th>Performance</th>
                        <th>Contact</th>
                        <th style="width:100px">Actions</th>
                    </tr>
                </thead>
                <tbody id="agBody">
                    @forelse($agents as $agent)
                    <tr data-name="{{ strtolower($agent->full_name . ' ' . $agent->role . ' ' . ($agent->email ?? '')) }}"
                        data-role="{{ strtolower($agent->role ?? '') }}"
                        data-exp="{{ $agent->years_experience ?? 0 }}">

                        {{-- Checkbox --}}
                        <td>
                            <input type="checkbox" class="row-check" value="{{ $agent->id }}"
                                style="cursor:pointer;accent-color:var(--accent);">
                        </td>

                        {{-- Agent ── --}}
                        <td>
                            <div class="ag-agent-cell">
                                <div class="ag-avatar-wrap">
                                    @if($agent->profile_image)
                                    <img src="{{asset('image/agents/')}}/{{ $agent->profile_image }}"
                                        alt="{{ $agent->full_name }}" class="ag-avatar">
                                    @else
                                    <div class="ag-avatar-initials">
                                        {{ strtoupper(substr($agent->full_name, 0, 2)) }}
                                    </div>
                                    @endif
                                    <span class="ag-online-dot" title="Online"></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.agents.show', $agent->id) }}"
                                        class="ag-agent-name">{{ $agent->full_name }}</a>
                                    <div class="ag-agent-role">{{ $agent->email ?? '—' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Role --}}
                        <td style="color:var(--text-dim);font-size:.82rem;">
                            {{ $agent->role ?? '—' }}
                        </td>

                        {{-- Rating --}}
                        <td>
                            @if($agent->rating)
                            <span class="ag-rating">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                </svg>
                                {{ number_format($agent->rating, 1) }}
                            </span>
                            @else
                            <span style="color:var(--muted);font-size:.8rem">—</span>
                            @endif
                        </td>

                        {{-- Experience --}}
                        <td>
                            @if($agent->years_experience)
                            <span class="ag-exp-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                {{ $agent->years_experience }} yr{{ $agent->years_experience > 1 ? 's' : '' }}
                            </span>
                            @else
                            <span style="color:var(--muted);font-size:.8rem">—</span>
                            @endif
                        </td>

                        {{-- Performance ── --}}
                        <td>
                            <div class="ag-mini-stats">
                                <div class="ag-mini-stat">
                                    <span class="ag-mini-val">{{ $agent->sales_count ?? 0 }}</span>
                                    <span class="ag-mini-label">Sales</span>
                                </div>
                                <div class="ag-mini-stat">
                                    <span class="ag-mini-val">{{ $agent->clients_count ?? 0 }}</span>
                                    <span class="ag-mini-label">Clients</span>
                                </div>
                                <div class="ag-mini-stat">
                                    <span class="ag-mini-val">{{ $agent->properties_count ?? 0 }}</span>
                                    <span class="ag-mini-label">Listings</span>
                                </div>
                            </div>
                        </td>

                        {{-- Contact --}}
                        <td>
                            <div class="ag-contact">
                                @if($agent->email)
                                <a href="mailto:{{ $agent->email }}" class="ag-contact-btn" title="Email">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect width="20" height="16" x="2" y="4" rx="2" />
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                    </svg>
                                </a>
                                @endif
                                @if($agent->phone)
                                <a href="tel:{{ $agent->phone }}" class="ag-contact-btn phone" title="Call">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="ag-actions">
                                <a href="{{ route('admin.agents.show', $agent->id) }}"
                                    class="ag-icon-btn" title="View Profile">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.agents.edit', $agent->id) }}"
                                    class="ag-icon-btn" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                                <button class="ag-icon-btn danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteAgent{{ $agent->id }}"
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
                        <td colspan="8">
                            <div class="ag-empty">
                                <div class="ag-empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="8" r="4" />
                                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                                    </svg>
                                </div>
                                <h5>No agents found</h5>
                                <p>
                                    @if(request('search') || request('role'))
                                    Try adjusting your filters.
                                    @else
                                    Add your first agent to get started.
                                    @endif
                                </p>
                                <a href="{{ route('admin.agents.create') }}" class="ag-btn ag-btn-primary ag-btn-sm">
                                    Add First Agent
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($agents, 'hasPages') && $agents->hasPages())
        <div class="ag-pagination">
            <p class="ag-pagination-info">
                Showing <strong>{{ $agents->firstItem() }}</strong>–<strong>{{ $agents->lastItem() }}</strong>
                of <strong>{{ $agents->total() }}</strong>
            </p>
            <div class="ag-pages">
                @if($agents->onFirstPage())
                <span class="ag-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m15 18-6-6 6-6" />
                    </svg></span>
                @else
                <a href="{{ $agents->previousPageUrl() }}" class="ag-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m15 18-6-6 6-6" />
                    </svg></a>
                @endif
                @foreach($agents->getUrlRange(max(1,$agents->currentPage()-2), min($agents->lastPage(),$agents->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="ag-page-btn {{ $page == $agents->currentPage() ? 'current' : '' }}">{{ $page }}</a>
                @endforeach
                @if($agents->hasMorePages())
                <a href="{{ $agents->nextPageUrl() }}" class="ag-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6" />
                    </svg></a>
                @else
                <span class="ag-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6" />
                    </svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ══ DELETE MODALS ══ --}}
@foreach($agents as $agent)
<div class="modal fade ag-modal" id="deleteAgent{{ $agent->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.agents.destroy', $agent->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="ag-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                        <line x1="12" x2="12" y1="9" y2="13" />
                        <line x1="12" x2="12.01" y1="17" y2="17" />
                    </svg>
                </div>
                <h5 class="modal-title">Delete Agent</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="ag-delete-box">
                    Are you sure you want to delete <strong>{{ $agent->full_name }}</strong>?
                    All their listings and performance data will be affected.
                    <br><br>
                    <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ag-btn ag-btn-ghost ag-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="ag-btn ag-btn-danger ag-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                    </svg>
                    Delete Agent
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    /* ── Live filter ── */
    function filterAgents() {
        const q = document.getElementById('agSearch').value.toLowerCase();
        const role = document.getElementById('agRoleFilter').value;
        const expVal = parseInt(document.getElementById('agExpFilter').value) || 0;
        const rows = document.querySelectorAll('#agBody tr[data-name]');
        let shown = 0;

        rows.forEach(r => {
            const nameMatch = r.dataset.name.includes(q);
            const roleMatch = !role || r.dataset.role === role;
            const exp = parseInt(r.dataset.exp) || 0;
            let expMatch = true;
            if (expVal === 1) expMatch = exp <= 2;
            if (expVal === 3) expMatch = exp >= 3 && exp <= 5;
            if (expVal === 6) expMatch = exp >= 6 && exp <= 10;
            if (expVal === 10) expMatch = exp > 10;

            const visible = nameMatch && roleMatch && expMatch;
            r.style.display = visible ? '' : 'none';
            if (visible) shown++;
        });

        document.getElementById('agCount').innerHTML =
            '<strong>' + shown + '</strong> agent' + (shown === 1 ? '' : 's');
    }

    /* ── Select all ── */
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
    });
    document.querySelectorAll('.row-check').forEach(cb => {
        cb.addEventListener('change', () => {
            const all = document.querySelectorAll('.row-check');
            const checked = document.querySelectorAll('.row-check:checked');
            const sel = document.getElementById('selectAll');
            sel.indeterminate = checked.length > 0 && checked.length < all.length;
            sel.checked = checked.length === all.length;
        });
    });
</script>

@endsection