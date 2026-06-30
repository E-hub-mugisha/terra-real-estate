@extends('layouts.app')
@section('title', 'Agents')
@section('content')

<style>
    :root {
        --accent:    #D05208;
        --accent-lt: #e4c990;
        --danger:    #dc3545;
        --border:    #e2e8f0;
        --surface:   #f8fafc;
        --muted:     #94a3b8;
        --text:      #1e293b;
        --text-dim:  #64748b;
        --radius:    10px;
        --green:     #22c55e;
        --amber:     #f59e0b;
        --blue:      #3b82f6;
    }

    .ag-page { padding: 1.75rem 0 3rem; max-width: 1320px; margin: 0 auto; }

    /* ── Top bar ── */
    .ag-topbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.75rem; }
    .ag-topbar h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .ag-topbar p  { font-size: .82rem; color: var(--muted); margin: .15rem 0 0; }

    /* ── Buttons ── */
    .ag-btn { display: inline-flex; align-items: center; gap: .45rem; padding: .6rem 1.2rem; border-radius: 8px; font-size: .84rem; font-weight: 600; border: none; cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit; }
    .ag-btn-primary { background: var(--accent); color: #fff; }
    .ag-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }
    .ag-btn-ghost   { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .ag-btn-ghost:hover { border-color: var(--accent); color: var(--accent); }
    .ag-btn-danger  { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .ag-btn-danger:hover { background: #fef2f2; }
    .ag-btn-sm { padding: .38rem .85rem; font-size: .78rem; }

    /* ── Alerts ── */
    .ag-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: center; margin-bottom: 1.25rem; }
    .ag-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .ag-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    /* ── Stats ── */
    .ag-stats { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .ag-stat { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); padding: 1rem 1.25rem; }
    .ag-stat-val { font-size: 1.55rem; font-weight: 700; line-height: 1; }
    .ag-stat-val.accent { color: var(--accent); }
    .ag-stat-val.green  { color: var(--green); }
    .ag-stat-val.amber  { color: var(--amber); }
    .ag-stat-val.blue   { color: var(--blue); }
    .ag-stat-val.danger { color: var(--danger); }
    .ag-stat-label { font-size: .7rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); margin-top: .3rem; }

    /* ── Filters ── */
    .ag-filters { display: flex; align-items: center; flex-wrap: wrap; gap: .75rem; background: #fff; border: 1px solid var(--border); border-radius: var(--radius); padding: .9rem 1.2rem; margin-bottom: 1.25rem; }
    .ag-search-wrap { position: relative; flex: 1; min-width: 200px; max-width: 280px; }
    .ag-search-wrap svg { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .ag-search { width: 100%; padding: .56rem .85rem .56rem 2.3rem; border: 1.5px solid var(--border); border-radius: 8px; font-size: .84rem; color: var(--text); background: var(--surface); outline: none; font-family: inherit; transition: border-color .2s; }
    .ag-search:focus { border-color: var(--accent); }
    .ag-filter-select { padding: .56rem .85rem; border: 1.5px solid var(--border); border-radius: 8px; font-size: .82rem; color: var(--text-dim); background: var(--surface); outline: none; cursor: pointer; font-family: inherit; transition: border-color .2s; }
    .ag-filter-select:focus { border-color: var(--accent); }
    .ag-count { margin-left: auto; font-size: .78rem; color: var(--muted); white-space: nowrap; }
    .ag-count strong { color: var(--text-dim); }

    /* ── Status badges ── */
    .ag-status { display: inline-flex; align-items: center; gap: .3rem; padding: .22rem .65rem; border-radius: 100px; font-size: .71rem; font-weight: 600; white-space: nowrap; }
    .ag-status-active    { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .ag-status-suspended { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .ag-status-pending   { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
    .ag-status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .ag-status-active .ag-status-dot    { background: #22c55e; }
    .ag-status-suspended .ag-status-dot { background: #dc3545; }
    .ag-status-pending .ag-status-dot   { background: #f59e0b; }

    /* ── Table card ── */
    .ag-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .ag-card-toolbar { display: flex; align-items: center; justify-content: space-between; padding: .9rem 1.4rem; border-bottom: 1px solid var(--border); background: var(--surface); }
    .ag-card-title { display: flex; align-items: center; gap: .5rem; font-size: .86rem; font-weight: 600; color: var(--text); }
    .ag-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .ag-table thead { background: var(--surface); }
    .ag-table th { padding: .75rem 1.1rem; text-align: left; font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--border); white-space: nowrap; }
    .ag-table td { padding: .9rem 1.1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .ag-table tr:last-child td { border-bottom: none; }
    .ag-table tbody tr { transition: background .15s; }
    .ag-table tbody tr:hover { background: #fafafa; }

    /* ── Agent cell ── */
    .ag-agent-cell { display: flex; align-items: center; gap: .75rem; }
    .ag-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid var(--border); }
    .ag-avatar-initials { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-lt)); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .8rem; color: #fff; border: 2px solid rgba(201,169,110,.3); flex-shrink: 0; }
    .ag-agent-name { font-weight: 600; color: var(--text); font-size: .87rem; text-decoration: none; transition: color .15s; }
    .ag-agent-name:hover { color: var(--accent); }
    .ag-agent-sub { font-size: .75rem; color: var(--muted); margin-top: .1rem; }

    /* ── Location chip ── */
    .ag-location { display: inline-flex; align-items: center; gap: .3rem; font-size: .75rem; color: var(--text-dim); }
    .ag-location svg { flex-shrink: 0; color: var(--muted); }
    .ag-location-sector { font-size: .68rem; color: var(--muted); margin-top: .15rem; }

    /* ── Mini stats ── */
    .ag-mini-stats { display: flex; gap: 1.25rem; }
    .ag-mini-stat { text-align: center; }
    .ag-mini-val   { font-size: .88rem; font-weight: 700; color: var(--text); display: block; }
    .ag-mini-label { font-size: .68rem; color: var(--muted); letter-spacing: .04em; text-transform: uppercase; }

    /* ── Contact buttons ── */
    .ag-contact { display: flex; gap: .4rem; }
    .ag-contact-btn { width: 30px; height: 30px; border-radius: 7px; border: 1px solid var(--border); background: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-dim); transition: all .15s; text-decoration: none; }
    .ag-contact-btn:hover { border-color: var(--accent); color: var(--accent); background: #D0520808; }
    .ag-contact-btn.phone:hover { border-color: #bbf7d0; color: var(--green); background: #f0fdf4; }

    /* ── Actions ── */
    .ag-actions { display: flex; align-items: center; gap: .35rem; }
    .ag-icon-btn { width: 30px; height: 30px; border-radius: 7px; border: 1px solid var(--border); background: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-dim); transition: all .15s; text-decoration: none; }
    .ag-icon-btn:hover { border-color: var(--accent); color: var(--accent); background: #D0520808; }
    .ag-icon-btn.danger:hover { border-color: #fecaca; color: var(--danger); background: #fef2f2; }
    .ag-icon-btn.status-btn:hover { border-color: #bfdbfe; color: var(--blue); background: #eff6ff; }

    /* ── Empty ── */
    .ag-empty { text-align: center; padding: 4rem 2rem; }
    .ag-empty-icon { width: 54px; height: 54px; border-radius: 12px; background: #D0520812; border: 1px solid #D0520828; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--accent); }
    .ag-empty h5 { font-size: .96rem; font-weight: 600; color: var(--text); margin: 0 0 .4rem; }
    .ag-empty p  { font-size: .82rem; color: var(--muted); margin: 0 0 1.1rem; }

    /* ── Pagination ── */
    .ag-pagination { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; padding: .9rem 1.2rem; border-top: 1px solid var(--border); }
    .ag-pagination-info { font-size: .78rem; color: var(--muted); }
    .ag-pagination-info strong { color: var(--text-dim); }
    .ag-pages { display: flex; gap: .3rem; }
    .ag-page-btn { min-width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border); background: none; color: var(--text-dim); font-size: .78rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-family: inherit; transition: all .15s; padding: 0 .4rem; }
    .ag-page-btn:hover { border-color: var(--accent); color: var(--accent); }
    .ag-page-btn.current { background: var(--accent); color: #fff; border-color: var(--accent); font-weight: 600; }
    .ag-page-btn.disabled { opacity: .35; pointer-events: none; }

    /* ── Active filter pill ── */
    .ag-active-filters { display: flex; flex-wrap: wrap; gap: .4rem; margin-bottom: 1rem; }
    .ag-filter-pill { display: inline-flex; align-items: center; gap: .35rem; padding: .24rem .65rem; background: #D052080d; border: 1px solid #D0520830; border-radius: 100px; font-size: .74rem; color: var(--accent); font-weight: 500; }
    .ag-filter-pill a { color: inherit; text-decoration: none; opacity: .6; font-weight: 700; margin-left: .1rem; }
    .ag-filter-pill a:hover { opacity: 1; }

    /* ── Status Update Modal ── */
    .ag-modal .modal-content { border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 8px 32px rgba(0,0,0,.12); overflow: hidden; }
    .ag-modal .modal-header { background: var(--surface); border-bottom: 1px solid var(--border); padding: 1rem 1.4rem; display: flex; align-items: center; gap: .75rem; }
    .ag-modal-icon { width: 30px; height: 30px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ag-modal-icon.danger { background: #fef2f2; color: var(--danger); }
    .ag-modal-icon.blue   { background: #eff6ff; color: var(--blue); }
    .ag-modal .modal-title { font-size: .92rem; font-weight: 700; margin: 0; }
    .ag-modal .modal-body  { padding: 1.4rem; }
    .ag-modal .modal-footer { padding: .85rem 1.4rem; border-top: 1px solid var(--border); gap: .5rem; }

    /* ── Status radio group ── */
    .ag-status-options { display: flex; flex-direction: column; gap: .55rem; }
    .ag-status-option { display: flex; align-items: center; gap: .75rem; padding: .75rem 1rem; border: 1.5px solid var(--border); border-radius: 8px; cursor: pointer; transition: all .15s; }
    .ag-status-option:has(input:checked) { border-color: var(--accent); background: #D052080a; }
    .ag-status-option input { accent-color: var(--accent); flex-shrink: 0; }
    .ag-status-option-label { font-size: .85rem; font-weight: 600; color: var(--text); }
    .ag-status-option-desc  { font-size: .72rem; color: var(--muted); margin-top: .1rem; }

    @media (max-width: 768px) {
        .ag-mini-stats { display: none; }
        .ag-count { display: none; }
        .ag-table th:nth-child(4), .ag-table td:nth-child(4) { display: none; }
    }
</style>

@php
    $rwProvinces = $rwProvinces ?? [];
    $rwDistricts = $rwDistricts ?? [];
    $rwSectors   = $rwSectors   ?? [];
    $allDistricts = array_unique(array_merge(...array_values($rwDistricts)));
    sort($allDistricts);

    $totalCount = $agents instanceof \Illuminate\Pagination\LengthAwarePaginator ? $agents->total() : $agents->count();
@endphp

<div class="ag-page">

    {{-- ── Top bar ── --}}
    <div class="ag-topbar">
        <div>
            <h4>Agents</h4>
            <p>Manage all registered agents and their performance.</p>
        </div>
        <a href="{{ route('admin.agents.create') }}" class="ag-btn ag-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Add Agent
        </a>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
    <div class="ag-alert ag-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="ag-alert ag-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="ag-stats">
        <div class="ag-stat">
            <div class="ag-stat-val accent">{{ $totalCount }}</div>
            <div class="ag-stat-label">Total</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val green">{{ $agents->where('status','Active')->count() }}</div>
            <div class="ag-stat-label">Active</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val amber">{{ $agents->where('status','Pending Approval')->count() }}</div>
            <div class="ag-stat-label">Pending</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val danger">{{ $agents->where('status','Suspended')->count() }}</div>
            <div class="ag-stat-label">Suspended</div>
        </div>
    </div>

    {{-- ── Active filter pills ── --}}
    @php
        $activeFilters = array_filter([
            'search'   => request('search'),
            'status'   => request('status'),
            'province' => request('province'),
            'district' => request('district'),
            'sector'   => request('sector'),
        ]);
    @endphp
    @if(count($activeFilters))
    <div class="ag-active-filters">
        @foreach($activeFilters as $key => $val)
        <span class="ag-filter-pill">
            {{ ucfirst($key) }}: {{ $val }}
            <a href="{{ request()->fullUrlWithQuery([$key => null]) }}" title="Remove">✕</a>
        </span>
        @endforeach
        <a href="{{ route('admin.agents.index') }}" style="font-size:.74rem;color:var(--muted);align-self:center;text-decoration:none;margin-left:.25rem;">Clear all</a>
    </div>
    @endif

    {{-- ── Filters ── --}}
    <form method="GET" action="{{ route('admin.agents.index') }}" id="filterForm">
        <div class="ag-filters">

            {{-- Search --}}
            <div class="ag-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" name="search" class="ag-search"
                    placeholder="Name, email…"
                    value="{{ request('search') }}"
                    oninput="debounceSubmit()">
            </div>

            {{-- Status --}}
            <select name="status" class="ag-filter-select" onchange="this.form.submit()">
                <option value="">All statuses</option>
                <option value="Active"           {{ request('status') === 'Active'           ? 'selected' : '' }}>Active</option>
                <option value="Pending Approval" {{ request('status') === 'Pending Approval' ? 'selected' : '' }}>Pending Approval</option>
                <option value="Suspended"        {{ request('status') === 'Suspended'        ? 'selected' : '' }}>Suspended</option>
            </select>

            {{-- Province --}}
            <select name="province" class="ag-filter-select" onchange="this.form.submit()">
                <option value="">All provinces</option>
                @foreach($rwProvinces as $prov)
                <option value="{{ $prov }}" {{ request('province') === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>

            {{-- District — only if province selected --}}
            @if(request('province') && isset($rwDistricts[request('province')]))
            <select name="district" class="ag-filter-select" onchange="this.form.submit()">
                <option value="">All districts</option>
                @foreach($rwDistricts[request('province')] as $dist)
                <option value="{{ $dist }}" {{ request('district') === $dist ? 'selected' : '' }}>{{ $dist }}</option>
                @endforeach
            </select>
            @endif

            {{-- Sector — only if district selected and sectors exist --}}
            @if(request('district') && isset($rwSectors[request('district')]))
            <select name="sector" class="ag-filter-select" onchange="this.form.submit()">
                <option value="">All sectors</option>
                @foreach($rwSectors[request('district')] as $sec)
                <option value="{{ $sec }}" {{ request('sector') === $sec ? 'selected' : '' }}>{{ $sec }}</option>
                @endforeach
            </select>
            @endif

            <p class="ag-count">
                <strong>{{ $totalCount }}</strong>
                agent{{ $totalCount === 1 ? '' : 's' }}
            </p>
        </div>
    </form>

    {{-- ── Table ── --}}
    <div class="ag-card">
        <div class="ag-card-toolbar">
            <div class="ag-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                All Agents
            </div>
            <span style="font-size:.73rem;color:var(--muted);">{{ $totalCount }} total</span>
        </div>

        <div style="overflow-x:auto">
            <table class="ag-table">
                <thead>
                    <tr>
                        <th style="width:40px">
                            <input type="checkbox" id="selectAll" style="cursor:pointer;accent-color:var(--accent);">
                        </th>
                        <th>Agent</th>
                        <th>Location</th>
                        <th>Status</th>
                        <!-- <th>Performance</th> -->
                        <th>Contact</th>
                        <th style="width:120px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agents as $agent)
                    @php
                        $st = $agent->status ?? 'Pending Approval';
                        $stClass = match($st) {
                            'Active'           => 'active',
                            'Suspended'        => 'suspended',
                            default            => 'pending',
                        };
                    @endphp
                    <tr>
                        <td>
                            <input type="checkbox" class="row-check" value="{{ $agent->id }}"
                                style="cursor:pointer;accent-color:var(--accent);">
                        </td>

                        {{-- Agent ── --}}
                        <td>
                            <div class="ag-agent-cell">
                                @if($agent->profile_image)
                                <img src="{{ asset('image/agents/') }}/{{ $agent->profile_image }}"
                                    alt="{{ $agent->full_name }}" class="ag-avatar">
                                @else
                                <div class="ag-avatar-initials">{{ strtoupper(substr($agent->full_name, 0, 2)) }}</div>
                                @endif
                                <div>
                                    <a href="{{ route('admin.agents.show', $agent->id) }}" class="ag-agent-name">{{ $agent->full_name }}</a>
                                    <div class="ag-agent-sub">{{ $agent->email ?? '—' }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Location ── --}}
                        <td>
                            @if($agent->district || $agent->province)
                            <div class="ag-location">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ implode(', ', array_filter([$agent->district, $agent->province])) }}
                            </div>
                            @if($agent->sector)
                            <div class="ag-location-sector">{{ $agent->sector }} sector</div>
                            @endif
                            @elseif($agent->office_location)
                            <div class="ag-location">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $agent->office_location }}
                            </div>
                            @else
                            <span style="color:var(--muted);font-size:.78rem;">—</span>
                            @endif
                        </td>

                        {{-- Status ── --}}
                        <td>
                            <span class="ag-status ag-status-{{ $stClass }}">
                                <span class="ag-status-dot"></span>
                                {{ $st }}
                            </span>
                        </td>

                        {{-- Performance ── --}}
                        <!-- <td>
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
                        </td> -->

                        {{-- Contact ── --}}
                        <td>
                            <div class="ag-contact">
                                @if($agent->email)
                                <a href="mailto:{{ $agent->email }}" class="ag-contact-btn" title="Email">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                </a>
                                @endif
                                @if($agent->phone)
                                <a href="tel:{{ $agent->phone }}" class="ag-contact-btn phone" title="Call">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </a>
                                @endif
                            </div>
                        </td>

                        {{-- Actions ── --}}
                        <td>
                            <div class="ag-actions">
                                <a href="{{ route('admin.agents.show', $agent->id) }}" class="ag-icon-btn" title="View">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <a href="{{ route('admin.agents.edit', $agent->id) }}" class="ag-icon-btn" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                {{-- Status toggle button --}}
                                <button class="ag-icon-btn status-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#statusModal{{ $agent->id }}"
                                    title="Change Status">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                                </button>
                                <button class="ag-icon-btn danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteAgent{{ $agent->id }}"
                                    title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="ag-empty">
                                <div class="ag-empty-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                </div>
                                <h5>No agents found</h5>
                                <p>
                                    @if(request()->hasAny(['search','status','province','district','sector']))
                                    Try adjusting your filters.
                                    @else
                                    Add your first agent to get started.
                                    @endif
                                </p>
                                <a href="{{ route('admin.agents.create') }}" class="ag-btn ag-btn-primary ag-btn-sm">Add First Agent</a>
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
                <span class="ag-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></span>
                @else
                <a href="{{ $agents->appends(request()->query())->previousPageUrl() }}" class="ag-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></a>
                @endif
                @foreach($agents->getUrlRange(max(1,$agents->currentPage()-2), min($agents->lastPage(),$agents->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="ag-page-btn {{ $page == $agents->currentPage() ? 'current' : '' }}">{{ $page }}</a>
                @endforeach
                @if($agents->hasMorePages())
                <a href="{{ $agents->appends(request()->query())->nextPageUrl() }}" class="ag-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></a>
                @else
                <span class="ag-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ══ PER-ROW MODALS ══ --}}
@foreach($agents as $agent)
@php
    $st = $agent->status ?? 'Pending Approval';
@endphp

{{-- ── Status Update Modal ── --}}
<div class="modal fade ag-modal" id="statusModal{{ $agent->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <form method="POST"
              action="{{ route('admin.agents.update-status', $agent->id) }}"
              class="modal-content">
            @csrf @method('PATCH')
            <div class="modal-header">
                <div class="ag-modal-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                </div>
                <h5 class="modal-title" style="color:var(--text)">Update Status</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="font-size:.83rem;color:var(--muted);margin-bottom:1rem;">
                    Select a new status for <strong style="color:var(--text)">{{ $agent->full_name }}</strong>.
                    Current: <span style="font-weight:600;color:var(--text-dim)">{{ $st }}</span>
                </p>
                <div class="ag-status-options">
                    <label class="ag-status-option">
                        <input type="radio" name="status" value="Active" {{ $st === 'Active' ? 'checked' : '' }}>
                        <div>
                            <div class="ag-status-option-label" style="color:#166534">
                                <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e;margin-right:.4rem"></span>
                                Active
                            </div>
                            <div class="ag-status-option-desc">Agent is live and can manage listings.</div>
                        </div>
                    </label>
                    <label class="ag-status-option">
                        <input type="radio" name="status" value="Pending Approval" {{ $st === 'Pending Approval' ? 'checked' : '' }}>
                        <div>
                            <div class="ag-status-option-label" style="color:#92400e">
                                <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#f59e0b;margin-right:.4rem"></span>
                                Pending Approval
                            </div>
                            <div class="ag-status-option-desc">Awaiting review before going live.</div>
                        </div>
                    </label>
                    <label class="ag-status-option">
                        <input type="radio" name="status" value="Suspended" {{ $st === 'Suspended' ? 'checked' : '' }}>
                        <div>
                            <div class="ag-status-option-label" style="color:#b91c1c">
                                <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#dc3545;margin-right:.4rem"></span>
                                Suspended
                            </div>
                            <div class="ag-status-option-desc">Account disabled. Agent cannot log in.</div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ag-btn ag-btn-ghost ag-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="ag-btn ag-btn-primary ag-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                    Save Status
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── Delete Modal ── --}}
<div class="modal fade ag-modal" id="deleteAgent{{ $agent->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.agents.destroy', $agent->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="ag-modal-icon danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                </div>
                <h5 class="modal-title" style="color:var(--danger)">Delete Agent</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;">
                    Are you sure you want to delete <strong>{{ $agent->full_name }}</strong>?
                    All their listings and performance data will be affected.
                    <br><br>
                    <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ag-btn ag-btn-ghost ag-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="ag-btn ag-btn-danger ag-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Delete Agent
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    let searchTimer;
    function debounceSubmit() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => document.getElementById('filterForm').submit(), 400);
    }
    document.getElementById('selectAll').addEventListener('change', function () {
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