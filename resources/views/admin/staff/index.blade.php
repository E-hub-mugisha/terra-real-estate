@extends('layouts.app')
@section('title', 'Staff')
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
        --green:    #22c55e;
        --amber:    #f59e0b;
    }

    .st-page { padding: 1.75rem 0 3rem; max-width: 1280px; margin: 0 auto; }

    /* ── Top bar ── */
    .st-topbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.75rem; }
    .st-topbar h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .st-topbar p  { font-size: .82rem; color: var(--muted); margin: .15rem 0 0; }

    /* ── Buttons ── */
    .st-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.2rem; border-radius: 8px; font-size: .84rem; font-weight: 600;
        border: none; cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .st-btn-primary       { background: var(--accent); color: #fff; }
    .st-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }
    .st-btn-ghost         { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .st-btn-ghost:hover   { border-color: var(--accent); color: var(--accent); }
    .st-btn-danger        { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .st-btn-danger:hover  { background: #fef2f2; }
    .st-btn-sm { padding: .38rem .85rem; font-size: .78rem; }

    /* ── Alerts ── */
    .st-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: center; margin-bottom: 1.25rem; }
    .st-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .st-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    /* ── Stat cards ── */
    .st-stats { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px,1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .st-stat { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); padding: 1rem 1.25rem; }
    .st-stat-val   { font-size: 1.6rem; font-weight: 700; line-height: 1; color: var(--text); }
    .st-stat-val.accent { color: var(--accent); }
    .st-stat-val.green  { color: var(--green); }
    .st-stat-val.amber  { color: var(--amber); }
    .st-stat-val.muted  { color: var(--muted); }
    .st-stat-label { font-size: .7rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); margin-top: .3rem; }

    /* ── Filters ── */
    .st-filters {
        display: flex; align-items: center; flex-wrap: wrap; gap: .75rem;
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        padding: .9rem 1.2rem; margin-bottom: 1.25rem;
    }
    .st-search-wrap { position: relative; flex: 1; min-width: 200px; max-width: 320px; }
    .st-search-wrap svg { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .st-search {
        width: 100%; padding: .56rem .85rem .56rem 2.3rem;
        border: 1.5px solid var(--border); border-radius: 8px; font-size: .84rem;
        color: var(--text); background: var(--surface); outline: none; font-family: inherit; transition: border-color .2s;
    }
    .st-search:focus { border-color: var(--accent); }
    .st-filter-select {
        padding: .56rem .85rem; border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .82rem; color: var(--text-dim); background: var(--surface);
        outline: none; cursor: pointer; font-family: inherit; transition: border-color .2s;
    }
    .st-filter-select:focus { border-color: var(--accent); }
    .st-count { margin-left: auto; font-size: .78rem; color: var(--muted); white-space: nowrap; }
    .st-count strong { color: var(--text-dim); }

    /* ── Table card ── */
    .st-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .st-card-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: .9rem 1.4rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }
    .st-card-title { display: flex; align-items: center; gap: .5rem; font-size: .86rem; font-weight: 600; color: var(--text); }

    .st-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .st-table thead { background: var(--surface); }
    .st-table th { padding: .75rem 1.1rem; text-align: left; font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); border-bottom: 1px solid var(--border); white-space: nowrap; }
    .st-table td { padding: .85rem 1.1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .st-table tr:last-child td { border-bottom: none; }
    .st-table tbody tr { transition: background .15s; }
    .st-table tbody tr:hover { background: #fafafa; }

    /* ── Staff cell ── */
    .st-staff-cell { display: flex; align-items: center; gap: .75rem; }
    .st-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: #c9a96e20; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .82rem; color: var(--accent); flex-shrink: 0;
    }
    .st-staff-name  { font-weight: 600; color: var(--text); font-size: .87rem; }
    .st-staff-email { font-size: .74rem; color: var(--muted); margin-top: .1rem; }

    /* ── Emp ID ── */
    .st-emp-id {
        display: inline-block; padding: .2rem .6rem;
        background: var(--surface); border: 1px solid var(--border);
        border-radius: 6px; font-family: monospace; font-size: .76rem; color: var(--text-dim);
    }

    /* ── Dept badge ── */
    .st-dept-badge {
        display: inline-flex; align-items: center; gap: .3rem; padding: .22rem .65rem;
        border-radius: 100px; font-size: .71rem; font-weight: 600;
        background: #c9a96e0d; border: 1px solid #c9a96e30; color: var(--accent); white-space: nowrap;
    }

    /* ── Position ── */
    .st-position { font-size: .83rem; color: var(--text-dim); }

    /* ── Phone ── */
    .st-phone { font-size: .82rem; color: var(--text-dim); white-space: nowrap; }

    /* ── Status badge ── */
    .st-status {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .24rem .7rem; border-radius: 100px; font-size: .7rem; font-weight: 600; border: 1px solid;
    }
    .st-status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .st-status.active   { color: #166534; border-color: #bbf7d0; background: #f0fdf4; }
    .st-status.inactive { color: #92400e; border-color: #fde68a; background: #fffbeb; }
    .st-status.on_leave { color: #1d4ed8; border-color: #bfdbfe; background: #eff6ff; }
    .st-status.terminated { color: #991b1b; border-color: #fecaca; background: #fef2f2; }

    /* ── Joined date ── */
    .st-date { font-size: .8rem; color: var(--text-dim); white-space: nowrap; }
    .st-date span { display: block; font-size: .71rem; color: var(--muted); margin-top: .1rem; }

    /* ── Actions ── */
    .st-actions { display: flex; align-items: center; gap: .35rem; }
    .st-icon-btn {
        width: 30px; height: 30px; border-radius: 7px; border: 1px solid var(--border);
        background: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
        color: var(--text-dim); transition: all .15s; text-decoration: none;
    }
    .st-icon-btn:hover        { border-color: var(--accent); color: var(--accent); background: #c9a96e08; }
    .st-icon-btn.danger:hover { border-color: #fecaca; color: var(--danger); background: #fef2f2; }

    /* ── Empty ── */
    .st-empty { text-align: center; padding: 4rem 2rem; }
    .st-empty-icon { width: 54px; height: 54px; border-radius: 12px; background: #c9a96e12; border: 1px solid #c9a96e28; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--accent); }
    .st-empty h5 { font-size: .96rem; font-weight: 600; color: var(--text); margin: 0 0 .4rem; }
    .st-empty p  { font-size: .82rem; color: var(--muted); margin: 0 0 1.1rem; }

    /* ── Pagination ── */
    .st-pagination { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; padding: .9rem 1.2rem; border-top: 1px solid var(--border); }
    .st-pagination-info { font-size: .78rem; color: var(--muted); }
    .st-pagination-info strong { color: var(--text-dim); }
    .st-pages { display: flex; gap: .3rem; }
    .st-page-btn { min-width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border); background: none; color: var(--text-dim); font-size: .78rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-family: inherit; transition: all .15s; padding: 0 .4rem; }
    .st-page-btn:hover { border-color: var(--accent); color: var(--accent); }
    .st-page-btn.current { background: var(--accent); color: #fff; border-color: var(--accent); font-weight: 600; }
    .st-page-btn.disabled { opacity: .35; pointer-events: none; }

    /* ── Modal ── */
    .st-modal .modal-content { border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 8px 32px rgba(0,0,0,.12); overflow: hidden; }
    .st-modal .modal-header  { background: var(--surface); border-bottom: 1px solid var(--border); padding: 1rem 1.4rem; display: flex; align-items: center; gap: .75rem; }
    .st-modal-icon { width: 30px; height: 30px; border-radius: 7px; background: #c9a96e18; display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0; }
    .st-modal-icon.danger { background: #fef2f2; color: var(--danger); }
    .st-modal .modal-title  { font-size: .92rem; font-weight: 700; color: var(--text); margin: 0; }
    .st-modal .modal-body   { padding: 1.4rem; display: flex; flex-direction: column; gap: 1rem; }
    .st-modal .modal-footer { padding: .85rem 1.4rem; border-top: 1px solid var(--border); gap: .5rem; }

    .st-label { display: block; font-size: .75rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: var(--text-dim); margin-bottom: .45rem; }
    .st-label .req { color: var(--danger); margin-left: .2rem; }
    .st-input, .st-select, .st-textarea {
        width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .875rem; color: var(--text); background: #fff; outline: none; font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }
    .st-input:focus, .st-select:focus, .st-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }
    .st-textarea { resize: vertical; line-height: 1.65; }
    .st-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: .85rem; }
    .st-delete-box { font-size: .87rem; color: var(--text-dim); line-height: 1.6; padding: .85rem 1rem; border-radius: 8px; border: 1px solid #fecaca; background: #fef2f2; }
    .st-delete-box strong { color: var(--text); }

    @media (max-width: 640px) {
        .st-row-2 { grid-template-columns: 1fr; }
    }
</style>

<div class="st-page">

    {{-- ── Top bar ── --}}
    <div class="st-topbar">
        <div>
            <h4>Staff</h4>
            <p>Manage all employees and their department assignments.</p>
        </div>
        <button class="st-btn st-btn-primary" data-bs-toggle="modal" data-bs-target="#createStaffModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Add Staff
        </button>
    </div>
{{-- ── Alerts ── --}}
    @if ($errors->any())
        <div class="se-alert se-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div>
                <strong>Please fix the following errors:</strong>
                <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="se-alert se-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    {{-- ── Alerts ── --}}
    @if(session('success'))
        <div class="st-alert st-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="st-alert st-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="st-stats">
        <div class="st-stat">
            <div class="st-stat-val accent">{{ $staff->count() }}</div>
            <div class="st-stat-label">Total</div>
        </div>
        <div class="st-stat">
            <div class="st-stat-val green">{{ $staff->where('status','active')->count() }}</div>
            <div class="st-stat-label">Active</div>
        </div>
        <div class="st-stat">
            <div class="st-stat-val muted">{{ $staff->where('status','inactive')->count() }}</div>
            <div class="st-stat-label">Inactive</div>
        </div>
        <div class="st-stat">
            <div class="st-stat-val" style="color:var(--text-dim)">{{ $departments->count() }}</div>
            <div class="st-stat-label">Departments</div>
        </div>
    </div>

    {{-- ── Filters ── --}}
    <div class="st-filters">
        <div class="st-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="stSearch" class="st-search" placeholder="Search name, ID, position…" oninput="filterStaff()">
        </div>
        <select id="stDeptFilter" class="st-filter-select" onchange="filterStaff()">
            <option value="">All departments</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
            @endforeach
        </select>
        <select id="stStatusFilter" class="st-filter-select" onchange="filterStaff()">
            <option value="">All statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <p class="st-count" id="stCount">
            <strong>{{ $staff->count() }}</strong> staff member{{ $staff->count() === 1 ? '' : 's' }}
        </p>
    </div>

    {{-- ── Table ── --}}
    <div class="st-card">
        <div class="st-card-toolbar">
            <div class="st-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                All Staff Members
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="st-table">
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Employee</th>
                        <th>Employee ID</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th style="width:96px">Actions</th>
                    </tr>
                </thead>
                <tbody id="stBody">
                    @forelse($staff as $member)
                        <tr data-name="{{ strtolower($member->user?->name . ' ' . $member->position . ' ' . $member->employee_id) }}"
                            data-dept="{{ $member->department_id }}"
                            data-status="{{ $member->status }}">

                            {{-- # --}}
                            <td><span style="display:inline-flex;align-items:center;justify-content:center;width:24px;height:24px;border-radius:6px;background:var(--surface);border:1px solid var(--border);font-size:.73rem;font-weight:600;color:var(--muted)">{{ $loop->iteration }}</span></td>

                            {{-- Employee --}}
                            <td>
                                <div class="st-staff-cell">
                                    <div class="st-avatar">{{ strtoupper(substr($member->user?->name ?? 'ST', 0, 2)) }}</div>
                                    <div>
                                        <div class="st-staff-name">{{ $member->user?->name ?? '—' }}</div>
                                        <div class="st-staff-email">{{ $member->user?->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Employee ID --}}
                            <td><span class="st-emp-id">{{ $member->employee_id ?? '—' }}</span></td>

                            {{-- Department --}}
                            <td>
                                @if($member->department)
                                    <span class="st-dept-badge">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01"/></svg>
                                        {{ $member->department->name }}
                                    </span>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>

                            {{-- Position --}}
                            <td><span class="st-position">{{ $member->position ?? '—' }}</span></td>

                            {{-- Phone --}}
                            <td>
                                @if($member->phone)
                                    <a href="tel:{{ $member->phone }}" class="st-phone" style="text-decoration:none;color:var(--text-dim)">{{ $member->phone }}</a>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @php
                                    $statusClass = match($member->status) {
                                        'active'     => 'active',
                                        'inactive'   => 'inactive',
                                        default      => 'inactive',
                                    };
                                    $statusLabel = match($member->status) {
                                        'active'     => 'Active',
                                        'inactive'   => 'Inactive',
                                        default      => ucfirst($member->status),
                                    };
                                @endphp
                                <span class="st-status {{ $statusClass }}">
                                    <span class="st-status-dot"></span>
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- Joined ── --}}
                            <td>
                                @if($member->joined_at)
                                    <div class="st-date">
                                        {{ $member->joined_at->format('M j, Y') }}
                                        <span>{{ $member->joined_at->diffForHumans() }}</span>
                                    </div>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="st-actions">
                                    <a href="{{ route('admin.staff.show', $member->id) }}"
                                       class="st-icon-btn" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.staff.edit', $member->id) }}"
                                       class="st-icon-btn" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="st-icon-btn danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteStaff{{ $member->id }}"
                                            title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="st-empty">
                                    <div class="st-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                    </div>
                                    <h5>No staff members yet</h5>
                                    <p>Add your first staff member to get started.</p>
                                    <button class="st-btn st-btn-primary st-btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#createStaffModal">
                                        Add Staff Member
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(method_exists($staff, 'hasPages') && $staff->hasPages())
            <div class="st-pagination">
                <p class="st-pagination-info">
                    Showing <strong>{{ $staff->firstItem() }}</strong>–<strong>{{ $staff->lastItem() }}</strong>
                    of <strong>{{ $staff->total() }}</strong>
                </p>
                <div class="st-pages">
                    @if($staff->onFirstPage())
                        <span class="st-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></span>
                    @else
                        <a href="{{ $staff->previousPageUrl() }}" class="st-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></a>
                    @endif
                    @foreach($staff->getUrlRange(max(1,$staff->currentPage()-2), min($staff->lastPage(),$staff->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="st-page-btn {{ $page == $staff->currentPage() ? 'current' : '' }}">{{ $page }}</a>
                    @endforeach
                    @if($staff->hasMorePages())
                        <a href="{{ $staff->nextPageUrl() }}" class="st-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></a>
                    @else
                        <span class="st-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ══ CREATE MODAL ══ --}}
<div class="modal fade st-modal" id="createStaffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" action="{{ route('admin.staff.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="st-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </div>
                <h5 class="modal-title">Add Staff Member</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                {{-- Info banner --}}
                <div style="display:flex;align-items:flex-start;gap:.65rem;padding:.85rem 1rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.82rem;color:#1d4ed8;margin-bottom:.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                    <span>A login account will be <strong>created automatically</strong>. A secure password will be generated and emailed to the staff member's address.</span>
                </div>

                {{-- ── Account Details ── --}}
                <p style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);padding:.8rem 0 .5rem;">Account Details</p>
                <div style="height:1px;background:var(--border);margin-bottom:1rem;"></div>

                <div class="st-row-2">
                    <div>
                        <label class="st-label">Full Name <span class="req">*</span></label>
                        <input type="text" name="name" class="st-input"
                               placeholder="e.g. John Mukasa"
                               oninput="autoEmpId(this.value)" required>
                    </div>
                    <div>
                        <label class="st-label">Email Address <span class="req">*</span></label>
                        <input type="email" name="email" class="st-input"
                               placeholder="john@company.com" required>
                        <p style="font-size:.71rem;color:var(--muted);margin-top:.35rem;">
                            Login credentials will be sent here.
                        </p>
                    </div>
                </div>

                {{-- ── Staff Details ── --}}
                <p style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);padding:.8rem 0 .5rem;">Staff Details</p>
                <div style="height:1px;background:var(--border);margin-bottom:1rem;"></div>

                <div class="st-row-2">
                    <div>
                        <label class="st-label">Department</label>
                        <select name="department_id" class="st-select">
                            <option value="">Select department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="st-label">Employee ID</label>
                        <input type="text" name="employee_id" id="empIdInput"
                               class="st-input" placeholder="Auto-generated" readonly>
                    </div>
                </div>
                <div class="st-row-2">
                    <div>
                        <label class="st-label">Position</label>
                        <input type="text" name="position" class="st-input" placeholder="e.g. Sales Agent">
                    </div>
                    <div>
                        <label class="st-label">Phone</label>
                        <input type="text" name="phone" class="st-input" placeholder="+250 7XX XXX XXX">
                    </div>
                </div>
                <div class="st-row-2">
                    <div>
                        <label class="st-label">Role <span class="req">*</span></label>
                        <select name="role" class="st-select" required>
                            <option value="admin">Admin</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
                    <div>
                        <label class="st-label">Status <span class="req">*</span></label>
                        <select name="status" class="st-select" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="st-label">Joined Date</label>
                        <input type="date" name="joined_at" class="st-input"
                               value="{{ now()->format('Y-m-d') }}">
                    </div>
                </div>
                <div>
                    <label class="st-label">Notes</label>
                    <textarea name="notes" rows="2" class="st-textarea"
                              placeholder="Optional internal notes…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="st-btn st-btn-ghost st-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="st-btn st-btn-primary st-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                    Create &amp; Send Credentials
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ DELETE MODALS ══ --}}
@foreach($staff as $member)
    <div class="modal fade st-modal" id="deleteStaff{{ $member->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.staff.destroy', $member->id) }}" class="modal-content">
                @csrf @method('DELETE')
                <div class="modal-header">
                    <div class="st-modal-icon danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    </div>
                    <h5 class="modal-title" style="color:var(--danger)">Remove Staff Member</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="st-delete-box">
                        Are you sure you want to remove <strong>{{ $member->user?->name ?? 'this staff member' }}</strong>
                        @if($member->employee_id) ({{ $member->employee_id }})@endif from the system?
                        <br><br>
                        <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="st-btn st-btn-ghost st-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="st-btn st-btn-danger st-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Remove
                    </button>
                </div>
            </form>
        </div>
    </div>
@endforeach

<script>
/* ── Auto-generate employee ID from name ── */
function autoEmpId(name) {
    const field = document.getElementById('empIdInput');
    if (field.dataset.edited) return; // user has manually typed — don't override
    const initials = name.trim().split(/\s+/).map(w => w[0]?.toUpperCase() ?? '').join('').slice(0, 3);
    const ts       = String(Date.now()).slice(-4);
    field.value    = initials ? 'EMP-' + initials + '-' + ts : '';
}
document.getElementById('empIdInput')?.addEventListener('input', function () {
    this.dataset.edited = this.value ? '1' : '';
});

function filterStaff() {
    const q      = document.getElementById('stSearch').value.toLowerCase();
    const dept   = document.getElementById('stDeptFilter').value;
    const status = document.getElementById('stStatusFilter').value;
    const rows   = document.querySelectorAll('#stBody tr[data-name]');
    let shown    = 0;

    rows.forEach(r => {
        const nameMatch   = r.dataset.name.includes(q);
        const deptMatch   = !dept   || r.dataset.dept   === dept;
        const statusMatch = !status || r.dataset.status === status;
        const visible     = nameMatch && deptMatch && statusMatch;
        r.style.display   = visible ? '' : 'none';
        if (visible) shown++;
    });

    document.getElementById('stCount').innerHTML =
        '<strong>' + shown + '</strong> staff member' + (shown === 1 ? '' : 's');
}
</script>

@endsection