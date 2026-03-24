@extends('layouts.app')
@section('title', 'System Users')
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

    {{-- Top bar --}}
    <div class="ag-topbar">
        <div>
            <h4>System Users</h4>
            <p>Manage all registered users and linked accounts.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="ag-btn ag-btn-primary">
            Add User
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="ag-alert ag-alert-success">{{ session('success') }}</div>
    @endif

    {{-- Stats --}}
    <div class="ag-stats">
        <div class="ag-stat">
            <div class="ag-stat-val accent">{{ $users->count() }}</div>
            <div class="ag-stat-label">Total Users</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val green">{{ $users->where('status','active')->count() }}</div>
            <div class="ag-stat-label">Active</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val blue">{{ $users->whereNotNull('agent')->count() }}</div>
            <div class="ag-stat-label">Agents</div>
        </div>
        <div class="ag-stat">
            <div class="ag-stat-val amber">{{ $users->whereNotNull('consultant')->count() }}</div>
            <div class="ag-stat-label">Consultants</div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="ag-filters">
        <div class="ag-search-wrap">
            <input type="text" id="userSearch" class="ag-search"
                placeholder="Search name, email…"
                oninput="filterUsers()">
        </div>

        <select id="userRoleFilter" class="ag-filter-select" onchange="filterUsers()">
            <option value="">All Roles</option>
            @foreach($users->pluck('role')->unique()->filter() as $role)
                <option value="{{ strtolower($role) }}">{{ $role }}</option>
            @endforeach
        </select>

        <p class="ag-count" id="userCount">
            <strong>{{ $users->count() }}</strong> users
        </p>
    </div>

    {{-- Table --}}
    <div class="ag-card">
        <div class="ag-card-toolbar">
            <div class="ag-card-title">All Users</div>
        </div>

        <div style="overflow-x:auto">
            <table class="ag-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Account Type</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="userBody">
                    @forelse($users as $user)
                    <tr
                        data-name="{{ strtolower($user->name.' '.$user->email) }}"
                        data-role="{{ strtolower($user->role ?? '') }}"
                    >

                        {{-- Checkbox --}}
                        <td>
                            <input type="checkbox" class="row-check">
                        </td>

                        {{-- User --}}
                        <td>
                            <div class="ag-agent-cell">
                                <div class="ag-avatar-wrap">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/'.$user->profile_image) }}" class="ag-avatar">
                                    @else
                                        <div class="ag-avatar-initials">
                                            {{ strtoupper(substr($user->name,0,2)) }}
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <div class="ag-agent-name">{{ $user->name }}</div>
                                    <div class="ag-agent-role">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Role --}}
                        <td>{{ $user->role ?? '—' }}</td>

                        {{-- Account Type --}}
                        <td>
                            @if($user->agent)
                                <span class="ag-exp-badge">Agent</span>
                            @elseif($user->consultant)
                                <span class="ag-exp-badge">Consultant</span>
                            @elseif($user->professional)
                                <span class="ag-exp-badge">Professional</span>
                            @else
                                <span class="ag-exp-badge">User</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="ag-exp-badge">
                                {{ ucfirst($user->status ?? 'active') }}
                            </span>
                        </td>

                        {{-- Created --}}
                        <td>
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="ag-actions">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="ag-icon-btn">👁</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="ag-icon-btn">✏️</a>

                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                    @csrf @method('DELETE')
                                    <button class="ag-icon-btn danger">🗑</button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="ag-empty">
                                <h5>No users found</h5>
                                <p>Add your first user.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- FILTER SCRIPT --}}
<script>
function filterUsers() {
    const q = document.getElementById('userSearch').value.toLowerCase();
    const role = document.getElementById('userRoleFilter').value;
    const rows = document.querySelectorAll('#userBody tr[data-name]');
    let shown = 0;

    rows.forEach(r => {
        const nameMatch = r.dataset.name.includes(q);
        const roleMatch = !role || r.dataset.role === role;

        const visible = nameMatch && roleMatch;
        r.style.display = visible ? '' : 'none';

        if (visible) shown++;
    });

    document.getElementById('userCount').innerHTML =
        '<strong>' + shown + '</strong> users';
}
</script>

{{-- ══ DELETE MODALS ══ --}}
@foreach($users as $user)
<div class="modal fade ag-modal" id="deleteUser{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="ag-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                        <line x1="12" x2="12" y1="9" y2="13" />
                        <line x1="12" x2="12.01" y1="17" y2="17" />
                    </svg>
                </div>
                <h5 class="modal-title">Delete user</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="ag-delete-box">
                    Are you sure you want to delete <strong>{{ $user->full_name }}</strong>?
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
                    Delete user
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach


@endsection