{{-- resources/views/admin/activity-logs/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')

<style>
    /* ── Layout ─────────────────────────────────────── */
    .al-page          { padding: 2rem 2.5rem; max-width: 1400px; margin: 0 auto; }
    .al-header        { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 1.75rem; }
    .al-breadcrumb    { font-family: 'DM Sans', sans-serif; font-size: .75rem; color: #8a8f9e; margin-bottom: .3rem; letter-spacing: .04em; }
    .al-title         { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; color: #19265d; margin: 0; }

    /* ── Export btn ─────────────────────────────────── */
    .al-export-btn    { display: inline-flex; align-items: center; gap: .4rem; font-family: 'DM Sans', sans-serif; font-size: .8rem; font-weight: 500; color: #19265d; border: 1px solid #d4d8e8; border-radius: 6px; padding: .5rem 1rem; text-decoration: none; transition: border-color .2s, background .2s; }
    .al-export-btn:hover { background: #f4f5fb; border-color: #C8873A; color: #C8873A; }

    /* ── Filters Card ───────────────────────────────── */
    .al-filters-card  { background: #fff; border: 1px solid #e8eaf2; border-radius: 10px; padding: 1.25rem 1.5rem; margin-bottom: 1.25rem; }
    .al-filters-form  { display: flex; flex-wrap: wrap; gap: .85rem; align-items: flex-end; }
    .al-filter-group  { display: flex; flex-direction: column; gap: .3rem; flex: 1 1 140px; }
    .al-label         { font-family: 'DM Sans', sans-serif; font-size: .7rem; font-weight: 600; color: #8a8f9e; letter-spacing: .06em; text-transform: uppercase; }
    .al-input         { font-family: 'DM Sans', sans-serif; font-size: .85rem; color: #19265d; border: 1px solid #dde0ee; border-radius: 6px; padding: .45rem .75rem; background: #fafbff; outline: none; transition: border-color .2s; }
    .al-input:focus   { border-color: #C8873A; }
    .al-filter-actions { display: flex; gap: .5rem; align-items: flex-end; }
    .al-btn-primary   { font-family: 'DM Sans', sans-serif; font-size: .82rem; font-weight: 600; background: #19265d; color: #fff; border: none; border-radius: 6px; padding: .5rem 1.2rem; cursor: pointer; transition: background .2s; }
    .al-btn-primary:hover { background: #C8873A; }
    .al-btn-ghost     { font-family: 'DM Sans', sans-serif; font-size: .82rem; font-weight: 500; color: #8a8f9e; border: 1px solid #dde0ee; border-radius: 6px; padding: .45rem 1rem; text-decoration: none; background: #fff; transition: color .2s, border-color .2s; }
    .al-btn-ghost:hover { color: #19265d; border-color: #19265d; }

    /* ── Stats Row ──────────────────────────────────── */
    .al-stats-row     { display: flex; align-items: center; gap: 0; background: #fff; border: 1px solid #e8eaf2; border-radius: 10px; padding: 1rem 2rem; margin-bottom: 1.25rem; }
    .al-stat          { display: flex; flex-direction: column; align-items: center; flex: 1; }
    .al-stat-value    { font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-weight: 700; color: #19265d; line-height: 1; }
    .al-stat-label    { font-family: 'DM Sans', sans-serif; font-size: .7rem; color: #8a8f9e; margin-top: .2rem; letter-spacing: .04em; }
    .al-stat-gold     { color: #C8873A; }
    .al-stat-danger   { color: #d94f4f; }
    .al-stat-divider  { width: 1px; height: 36px; background: #e8eaf2; margin: 0 .5rem; }

    /* ── Table Card ─────────────────────────────────── */
    .al-table-card    { background: #fff; border: 1px solid #e8eaf2; border-radius: 10px; overflow: hidden; }
    .al-table-wrap    { overflow-x: auto; }
    .al-table         { width: 100%; border-collapse: collapse; font-family: 'DM Sans', sans-serif; font-size: .83rem; }
    .al-table thead th { background: #f7f8fd; color: #8a8f9e; font-size: .68rem; font-weight: 600; letter-spacing: .07em; text-transform: uppercase; padding: .75rem 1rem; border-bottom: 1px solid #e8eaf2; white-space: nowrap; text-align: left; }
    .al-row           { border-bottom: 1px solid #f0f1f8; transition: background .15s; }
    .al-row:last-child { border-bottom: none; }
    .al-row:hover     { background: #fafbff; }
    .al-table td      { padding: .8rem 1rem; vertical-align: middle; color: #2c3252; }
    .al-cell-muted    { color: #9099b5; font-size: .8rem; }
    .al-cell-mono     { font-family: 'Courier New', monospace; font-size: .78rem; color: #9099b5; }

    /* ── User cell ──────────────────────────────────── */
    .al-user-cell     { display: flex; align-items: center; gap: .65rem; }
    .al-avatar        { width: 30px; height: 30px; border-radius: 50%; background: #19265d; color: #fff; font-size: .72rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .al-user-name     { font-weight: 500; color: #19265d; white-space: nowrap; }
    .al-user-email    { font-size: .72rem; color: #9099b5; }

    /* ── Badges ─────────────────────────────────────── */
    .al-badge         { display: inline-block; font-size: .7rem; font-weight: 600; letter-spacing: .04em; border-radius: 4px; padding: .2rem .55rem; text-transform: capitalize; }
    .al-badge--created  { background: #e6f9f0; color: #1a7a4a; }
    .al-badge--updated  { background: #fff3e0; color: #b85c00; }
    .al-badge--deleted  { background: #fdecea; color: #c0392b; }
    .al-badge--viewed   { background: #e8eef9; color: #3455a4; }
    .al-badge--exported { background: #f3e8ff; color: #7c3aed; }
    .al-badge--login    { background: #e0f7fa; color: #00796b; }
    .al-badge--logout   { background: #fce4ec; color: #c2185b; }
    .al-badge--default,
    .al-badge          { background: #ebebeb; color: #555; }

    /* ── Module & Subject ───────────────────────────── */
    .al-module-tag    { font-size: .72rem; font-weight: 600; color: #19265d; background: #eceffe; border-radius: 4px; padding: .2rem .55rem; white-space: nowrap; }
    .al-subject-type  { font-size: .78rem; color: #5a6285; }
    .al-subject-id    { font-size: .75rem; color: #C8873A; font-weight: 600; margin-left: .25rem; }
    .al-desc-cell     { max-width: 280px; }

    /* ── Detail Btn ─────────────────────────────────── */
    .al-detail-btn    { background: none; border: 1px solid #dde0ee; border-radius: 5px; padding: .3rem .4rem; cursor: pointer; color: #9099b5; display: flex; align-items: center; transition: color .15s, border-color .15s; }
    .al-detail-btn:hover { color: #C8873A; border-color: #C8873A; }

    /* ── Pagination ─────────────────────────────────── */
    .al-pagination      { display: flex; align-items: center; justify-content: space-between; padding: .9rem 1.25rem; border-top: 1px solid #f0f1f8; flex-wrap: wrap; gap: .5rem; }
    .al-pagination-info { font-family: 'DM Sans', sans-serif; font-size: .78rem; color: #9099b5; }

    /* ── Empty state ────────────────────────────────── */
    .al-empty         { display: flex; flex-direction: column; align-items: center; gap: .75rem; padding: 4rem; color: #9099b5; font-family: 'DM Sans', sans-serif; font-size: .9rem; }

    /* ── Modal ──────────────────────────────────────── */
    .al-modal-backdrop { position: fixed; inset: 0; background: rgba(25,38,93,.45); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 999; opacity: 0; pointer-events: none; transition: opacity .2s; }
    .al-modal-backdrop.al-open { opacity: 1; pointer-events: all; }
    .al-modal         { background: #fff; border-radius: 12px; width: 100%; max-width: 560px; max-height: 85vh; display: flex; flex-direction: column; overflow: hidden; transform: translateY(12px); transition: transform .2s; }
    .al-modal-backdrop.al-open .al-modal { transform: translateY(0); }
    .al-modal-header  { display: flex; align-items: center; justify-content: space-between; padding: 1.1rem 1.4rem; border-bottom: 1px solid #e8eaf2; }
    .al-modal-title   { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600; color: #19265d; margin: 0; }
    .al-modal-close   { background: none; border: none; cursor: pointer; color: #9099b5; padding: .25rem; display: flex; align-items: center; transition: color .15s; }
    .al-modal-close:hover { color: #d94f4f; }
    .al-modal-body    { overflow-y: auto; padding: 1.4rem; }
    .al-modal-loading { text-align: center; color: #9099b5; font-family: 'DM Sans', sans-serif; font-size: .85rem; padding: 2rem; }

    /* ── Modal detail rows ──────────────────────────── */
    .al-detail-row    { display: flex; gap: 1rem; padding: .6rem 0; border-bottom: 1px solid #f0f1f8; font-family: 'DM Sans', sans-serif; font-size: .84rem; }
    .al-detail-row:last-child { border-bottom: none; }
    .al-detail-key    { flex: 0 0 120px; color: #9099b5; font-size: .72rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; padding-top: .1rem; }
    .al-detail-val    { color: #19265d; word-break: break-all; }
    .al-detail-json   { background: #f7f8fd; border-radius: 6px; padding: .7rem 1rem; font-family: 'Courier New', monospace; font-size: .78rem; color: #3a4275; line-height: 1.6; white-space: pre-wrap; margin-top: .5rem; border: 1px solid #e8eaf2; }

    @media (max-width: 768px) {
        .al-page       { padding: 1rem; }
        .al-stats-row  { gap: 0; padding: .75rem 1rem; }
        .al-stat-value { font-size: 1.25rem; }
        .al-modal      { margin: 1rem; max-height: 90vh; }
    }
</style>
<div class="al-page">

    {{-- Header --}}
    <div class="al-header">
        <div>
            <p class="al-breadcrumb">Admin &rsaquo; System</p>
            <h1 class="al-title">Activity Logs</h1>
        </div>
        <a href="{{ route('admin.activity-logs.export') }}" class="al-export-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Export CSV
        </a>
    </div>

    {{-- Filters --}}
    <div class="al-filters-card">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="al-filters-form">
            <div class="al-filter-group">
                <label class="al-label">Search</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Description, module, user…"
                    class="al-input"
                >
            </div>
            <div class="al-filter-group">
                <label class="al-label">Module</label>
                <select name="module" class="al-input">
                    <option value="">All Modules</option>
                    @foreach($modules as $module)
                        <option value="{{ $module }}" @selected(request('module') === $module)>
                            {{ $module }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="al-filter-group">
                <label class="al-label">Action</label>
                <select name="action" class="al-input">
                    <option value="">All Actions</option>
                    @foreach(['created','updated','deleted','viewed','exported','login','logout'] as $act)
                        <option value="{{ $act }}" @selected(request('action') === $act)>
                            {{ ucfirst($act) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="al-filter-group">
                <label class="al-label">User</label>
                <select name="user_id" class="al-input">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="al-filter-group">
                <label class="al-label">From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="al-input">
            </div>
            <div class="al-filter-group">
                <label class="al-label">To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="al-input">
            </div>
            <div class="al-filter-actions">
                <button type="submit" class="al-btn-primary">Filter</button>
                <a href="{{ route('admin.activity-logs.index') }}" class="al-btn-ghost">Clear</a>
            </div>
        </form>
    </div>

    {{-- Stats Bar --}}
    <div class="al-stats-row">
        <div class="al-stat">
            <span class="al-stat-value">{{ number_format($totalCount) }}</span>
            <span class="al-stat-label">Total Events</span>
        </div>
        <div class="al-stat-divider"></div>
        <div class="al-stat">
            <span class="al-stat-value">{{ number_format($todayCount) }}</span>
            <span class="al-stat-label">Today</span>
        </div>
        <div class="al-stat-divider"></div>
        <div class="al-stat">
            <span class="al-stat-value al-stat-danger">{{ number_format($deletedCount) }}</span>
            <span class="al-stat-label">Deletions (30d)</span>
        </div>
        <div class="al-stat-divider"></div>
        <div class="al-stat">
            <span class="al-stat-value al-stat-gold">{{ number_format($activeUsers) }}</span>
            <span class="al-stat-label">Active Users (7d)</span>
        </div>
    </div>

    {{-- Table --}}
    <div class="al-table-card">
        @if($logs->isEmpty())
            <div class="al-empty">
                <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" opacity=".3">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                </svg>
                <p>No activity logs found.</p>
            </div>
        @else
            <div class="al-table-wrap">
                <table class="al-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Module</th>
                            <th>Description</th>
                            <th>Subject</th>
                            <th>IP Address</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr class="al-row">
                            <td class="al-cell-muted">{{ $log->id }}</td>
                            <td>
                                <div class="al-user-cell">
                                    <div class="al-avatar">{{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}</div>
                                    <div>
                                        <div class="al-user-name">{{ $log->user->name ?? '—' }}</div>
                                        <div class="al-user-email">{{ $log->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="al-badge al-badge--{{ $log->action }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td>
                                <span class="al-module-tag">{{ $log->module }}</span>
                            </td>
                            <td class="al-desc-cell" title="{{ $log->description }}">
                                {{ Str::limit($log->description, 60) }}
                            </td>
                            <td class="al-cell-muted">
                                @if($log->subject_type)
                                    <span class="al-subject-type">{{ class_basename($log->subject_type) }}</span>
                                    <span class="al-subject-id">#{{ $log->subject_id }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="al-cell-mono">{{ $log->ip_address ?? '—' }}</td>
                            <td class="al-cell-muted">
                                <span title="{{ $log->created_at }}">
                                    {{ $log->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td>
                                <button
                                    class="al-detail-btn"
                                    onclick="openDetail({{ $log->id }})"
                                    title="View details"
                                >
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="al-pagination">
                <span class="al-pagination-info">
                    Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ number_format($logs->total()) }} entries
                </span>
                {{ $logs->withQueryString()->links('vendor.pagination.terra') }}
            </div>
        @endif
    </div>
</div>

{{-- Detail Modal --}}
<div class="al-modal-backdrop" id="alModal" onclick="closeDetail(event)">
    <div class="al-modal">
        <div class="al-modal-header">
            <h2 class="al-modal-title">Log Detail</h2>
            <button class="al-modal-close" onclick="closeDetail(null, true)">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="al-modal-body" id="alModalBody">
            <div class="al-modal-loading">Loading…</div>
        </div>
    </div>
</div>



<script>
    @php $logsById = $logs->keyBy('id'); @endphp

    function openDetail(id) {
        const log = @json($logsById)[id];
        if (!log) return;

        const body = document.getElementById('alModalBody');

        const rows = [
            ['ID',          `#${log.id}`],
            ['User',        log.user ? `${log.user.name} &lt;${log.user.email}&gt;` : '—'],
            ['Action',      `<span class="al-badge al-badge--${log.action}">${cap(log.action)}</span>`],
            ['Module',      `<span class="al-module-tag">${log.module}</span>`],
            ['Description', log.description],
            ['Subject',     log.subject_type ? `${basename(log.subject_type)} #${log.subject_id}` : '—'],
            ['IP Address',  log.ip_address ?? '—'],
            ['User Agent',  log.user_agent ?? '—'],
            ['Created',     log.created_at],
        ];

        let html = rows.map(([k, v]) =>
            `<div class="al-detail-row"><div class="al-detail-key">${k}</div><div class="al-detail-val">${v}</div></div>`
        ).join('');

        if (log.properties && Object.keys(log.properties).length > 0) {
            html += `<div class="al-detail-row"><div class="al-detail-key">Properties</div><div class="al-detail-val" style="width:100%"></div></div>`;
            html += `<div class="al-detail-json">${JSON.stringify(log.properties, null, 2)}</div>`;
        }

        body.innerHTML = html;
        document.getElementById('alModal').classList.add('al-open');
    }

    function closeDetail(e, force = false) {
        if (force || e?.target === document.getElementById('alModal')) {
            document.getElementById('alModal').classList.remove('al-open');
        }
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetail(null, true); });

    const cap  = s => s ? s.charAt(0).toUpperCase() + s.slice(1) : '';
    const basename = s => s ? s.split('\\').pop().split('/').pop() : s;
</script>

@endsection