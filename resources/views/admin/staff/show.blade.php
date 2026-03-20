@extends('layouts.app')
@section('title', ($staff->user?->name ?? 'Staff') . ' — Staff Profile')
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
        --blue:     #3b82f6;
    }

    .sp-page { padding: 1.75rem 0 3rem; max-width: 1100px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .sp-breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: var(--muted); margin-bottom: 1.5rem; }
    .sp-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
    .sp-breadcrumb a:hover { color: var(--accent); }

    /* ── Layout ── */
    .sp-layout { display: grid; grid-template-columns: 300px 1fr; gap: 1.25rem; align-items: start; }
    .sp-left  { display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: 80px; }
    .sp-right { display: flex; flex-direction: column; gap: 1.25rem; }

    /* ── Buttons ── */
    .sp-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .6rem 1.2rem; border-radius: 8px; font-size: .84rem; font-weight: 600;
        border: none; cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .sp-btn-primary       { background: var(--accent); color: #fff; }
    .sp-btn-primary:hover { background: var(--accent-lt); color: #fff; }
    .sp-btn-ghost         { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .sp-btn-ghost:hover   { border-color: var(--accent); color: var(--accent); }
    .sp-btn-danger        { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .sp-btn-danger:hover  { background: #fef2f2; }
    .sp-btn-sm { padding: .38rem .85rem; font-size: .78rem; }
    .sp-btn-blue { background: none; border: 1.5px solid #bfdbfe; color: var(--blue); }
    .sp-btn-blue:hover { background: #eff6ff; }

    /* ── Alerts ── */
    .sp-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: center; margin-bottom: 1.25rem; }
    .sp-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .sp-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .sp-alert-warning { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }

    /* ── Profile card ── */
    .sp-profile-card {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        overflow: hidden;
    }
    .sp-profile-banner {
        height: 80px;
        background: linear-gradient(135deg, #c9a96e30, #e4c99020);
        border-bottom: 1px solid var(--border);
        position: relative;
    }
    .sp-profile-body { padding: 0 1.4rem 1.4rem; }
    .sp-avatar-wrap {
        margin-top: -28px; margin-bottom: .85rem;
    }
    .sp-avatar {
        width: 56px; height: 56px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1.1rem; color: #fff;
        border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,.12);
    }
    .sp-profile-name  { font-size: 1rem; font-weight: 700; color: var(--text); margin: 0 0 .2rem; }
    .sp-profile-pos   { font-size: .82rem; color: var(--text-dim); margin: 0 0 .75rem; }
    .sp-profile-email {
        display: flex; align-items: center; gap: .4rem;
        font-size: .8rem; color: var(--muted); margin-bottom: .35rem;
        word-break: break-all;
    }
    .sp-profile-email a { color: var(--muted); text-decoration: none; }
    .sp-profile-email a:hover { color: var(--accent); }

    /* ── Status badge ── */
    .sp-status {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .24rem .7rem; border-radius: 100px; font-size: .7rem; font-weight: 600; border: 1px solid;
    }
    .sp-status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .sp-status.active     { color: #166534; border-color: #bbf7d0; background: #f0fdf4; }
    .sp-status.inactive   { color: #92400e; border-color: #fde68a; background: #fffbeb; }
    .sp-status.on_leave   { color: #1d4ed8; border-color: #bfdbfe; background: #eff6ff; }
    .sp-status.terminated { color: #991b1b; border-color: #fecaca; background: #fef2f2; }

    /* ── Card ── */
    .sp-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .sp-card-header {
        display: flex; align-items: center; gap: .75rem;
        padding: .9rem 1.4rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }
    .sp-card-header-icon {
        width: 30px; height: 30px; border-radius: 7px; background: #c9a96e18;
        display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;
    }
    .sp-card-header h6 { margin: 0; font-size: .86rem; font-weight: 600; color: var(--text); }
    .sp-card-header .sp-card-action { margin-left: auto; }
    .sp-card-body { padding: 1.4rem; }

    /* ── Info grid ── */
    .sp-info-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 1px;
        background: var(--border); border: 1px solid var(--border); border-radius: 8px; overflow: hidden;
    }
    .sp-info-cell { background: #fff; padding: .85rem 1rem; }
    .sp-info-cell:hover { background: var(--surface); }
    .sp-info-key { font-size: .68rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); margin-bottom: .3rem; }
    .sp-info-val { font-size: .88rem; color: var(--text); font-weight: 500; }
    .sp-info-val.muted  { color: var(--muted); font-weight: 400; font-style: italic; }
    .sp-info-val.accent { color: var(--accent); }
    .sp-info-val.mono   { font-family: monospace; font-size: .82rem; }

    /* ── Info list (sidebar) ── */
    .sp-info-list { display: flex; flex-direction: column; gap: .7rem; }
    .sp-info-item { display: flex; align-items: flex-start; justify-content: space-between; gap: .5rem; font-size: .82rem; }
    .sp-info-item .lbl { color: var(--muted); display: flex; align-items: center; gap: .4rem; white-space: nowrap; flex-shrink: 0; }
    .sp-info-item .val { color: var(--text-dim); text-align: right; }
    .sp-info-item .val.accent { color: var(--accent); font-weight: 600; }

    /* ── Notes ── */
    .sp-notes { font-size: .88rem; color: var(--text-dim); line-height: 1.75; }
    .sp-no-notes { font-size: .84rem; color: var(--muted); font-style: italic; }

    /* ── Timeline ── */
    .sp-timeline { display: flex; flex-direction: column; gap: 0; }
    .sp-timeline-item { display: flex; gap: 1rem; padding-bottom: 1.25rem; position: relative; }
    .sp-timeline-item:last-child { padding-bottom: 0; }
    .sp-timeline-left { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
    .sp-timeline-dot {
        width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center;
        justify-content: center; flex-shrink: 0; border: 2px solid var(--border); background: #fff;
        color: var(--muted);
    }
    .sp-timeline-dot.accent { border-color: var(--accent); background: #c9a96e12; color: var(--accent); }
    .sp-timeline-dot.blue   { border-color: #bfdbfe; background: #eff6ff; color: var(--blue); }
    .sp-timeline-dot.green  { border-color: #bbf7d0; background: #f0fdf4; color: var(--green); }
    .sp-timeline-line {
        width: 1px; flex: 1; background: var(--border); margin-top: 4px; min-height: 16px;
    }
    .sp-timeline-item:last-child .sp-timeline-line { display: none; }
    .sp-timeline-content { flex: 1; padding-top: .2rem; }
    .sp-timeline-title { font-size: .86rem; font-weight: 600; color: var(--text); }
    .sp-timeline-meta  { font-size: .76rem; color: var(--muted); margin-top: .2rem; }

    /* ── Quick actions ── */
    .sp-actions-list { display: flex; flex-direction: column; gap: .5rem; }
    .sp-action-btn {
        display: flex; align-items: center; gap: .6rem; padding: .65rem .9rem;
        border-radius: 8px; border: 1.5px solid var(--border); background: none;
        font-family: inherit; font-size: .82rem; font-weight: 500; cursor: pointer;
        transition: all .15s; color: var(--text-dim); text-align: left; width: 100%;
        text-decoration: none;
    }
    .sp-action-btn:hover            { border-color: var(--accent); color: var(--text); background: #c9a96e06; }
    .sp-action-btn.blue:hover       { border-color: #bfdbfe; color: var(--blue); background: #eff6ff; }
    .sp-action-btn.danger:hover     { border-color: #fecaca; color: var(--danger); background: #fef2f2; }

    /* ── Dept badge ── */
    .sp-dept-badge {
        display: inline-flex; align-items: center; gap: .3rem; padding: .22rem .65rem;
        border-radius: 100px; font-size: .71rem; font-weight: 600;
        background: #c9a96e0d; border: 1px solid #c9a96e30; color: var(--accent);
    }

    /* ── Modal ── */
    .sp-modal .modal-content { border: 1px solid var(--border); border-radius: var(--radius); box-shadow: 0 8px 32px rgba(0,0,0,.12); overflow: hidden; }
    .sp-modal .modal-header  { background: var(--surface); border-bottom: 1px solid var(--border); padding: 1rem 1.4rem; display: flex; align-items: center; gap: .75rem; }
    .sp-modal-icon { width: 30px; height: 30px; border-radius: 7px; background: #c9a96e18; display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0; }
    .sp-modal-icon.danger { background: #fef2f2; color: var(--danger); }
    .sp-modal-icon.blue   { background: #eff6ff; color: var(--blue); }
    .sp-modal .modal-title  { font-size: .92rem; font-weight: 700; color: var(--text); margin: 0; }
    .sp-modal .modal-body   { padding: 1.4rem; display: flex; flex-direction: column; gap: 1rem; }
    .sp-modal .modal-footer { padding: .85rem 1.4rem; border-top: 1px solid var(--border); gap: .5rem; }
    .sp-label { display: block; font-size: .75rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: var(--text-dim); margin-bottom: .45rem; }
    .sp-select { width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border); border-radius: 8px; font-size: .875rem; color: var(--text); background: #fff; outline: none; font-family: inherit; transition: border-color .2s, box-shadow .2s; }
    .sp-select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }
    .sp-delete-box { font-size: .87rem; color: var(--text-dim); line-height: 1.6; padding: .85rem 1rem; border-radius: 8px; border: 1px solid #fecaca; background: #fef2f2; }
    .sp-delete-box strong { color: var(--text); }

    @media (max-width: 900px) {
        .sp-layout { grid-template-columns: 1fr; }
        .sp-left { position: static; }
        .sp-info-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="sp-page">

    {{-- ── Breadcrumb ── --}}
    <nav class="sp-breadcrumb">
        <a href="{{ route('admin.staff.index') }}">Staff</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">{{ $staff->user?->name ?? 'Staff Profile' }}</span>
    </nav>

    {{-- ── Alerts ── --}}
    @if(session('success'))
        <div class="sp-alert sp-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="sp-alert sp-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="sp-alert sp-alert-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
            {{ session('warning') }}
        </div>
    @endif

    <div class="sp-layout">

        {{-- ══ LEFT COLUMN ══ --}}
        <div class="sp-left">

            {{-- ── Profile card ── --}}
            <div class="sp-profile-card">
                <div class="sp-profile-banner"></div>
                <div class="sp-profile-body">
                    <div class="sp-avatar-wrap">
                        <div class="sp-avatar">{{ strtoupper(substr($staff->user?->name ?? 'ST', 0, 2)) }}</div>
                    </div>
                    <p class="sp-profile-name">{{ $staff->user?->name ?? '—' }}</p>
                    <p class="sp-profile-pos">{{ $staff->position ?? 'No position set' }}</p>

                    <div style="margin-bottom:.65rem;">
                        @php
                            $statusClass = match($staff->status) {
                                'active'     => 'active',
                                'inactive'   => 'inactive',
                                'on_leave'   => 'on_leave',
                                'terminated' => 'terminated',
                                default      => 'inactive',
                            };
                            $statusLabel = match($staff->status) {
                                'active'     => 'Active',
                                'inactive'   => 'Inactive',
                                'on_leave'   => 'On Leave',
                                'terminated' => 'Terminated',
                                default      => ucfirst($staff->status),
                            };
                        @endphp
                        <span class="sp-status {{ $statusClass }}">
                            <span class="sp-status-dot"></span>
                            {{ $statusLabel }}
                        </span>
                    </div>

                    @if($staff->user?->email)
                        <div class="sp-profile-email">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            <a href="mailto:{{ $staff->user->email }}">{{ $staff->user->email }}</a>
                        </div>
                    @endif

                    @if($staff->phone)
                        <div class="sp-profile-email">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <a href="tel:{{ $staff->phone }}">{{ $staff->phone }}</a>
                        </div>
                    @endif

                    @if($staff->department)
                        <div style="margin-top:.75rem;">
                            <span class="sp-dept-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01"/></svg>
                                {{ $staff->department->name }}
                            </span>
                        </div>
                    @endif

                    <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-top:1.1rem;padding-top:1rem;border-top:1px solid var(--border);">
                        <a href="{{ route('admin.staff.edit', $staff->id) }}"
                           class="sp-btn sp-btn-primary sp-btn-sm" style="flex:1;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <button class="sp-btn sp-btn-danger sp-btn-sm"
                                data-bs-toggle="modal" data-bs-target="#deleteStaffModal"
                                style="flex:1;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            {{-- ── Quick info ── --}}
            <div class="sp-card">
                <div class="sp-card-header">
                    <div class="sp-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h6>Quick Info</h6>
                </div>
                <div class="sp-card-body">
                    <div class="sp-info-list">
                        <div class="sp-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="9" height="11" x="1" y="6" rx="1"/><path d="M10 12H3"/><rect width="9" height="11" x="14" y="6" rx="1"/><path d="M21 12h-7"/></svg>
                                Employee ID
                            </span>
                            <span class="val" style="font-family:monospace;font-size:.8rem">{{ $staff->employee_id ?? '—' }}</span>
                        </div>
                        <div class="sp-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4M8 6h.01M16 6h.01M12 6h.01"/></svg>
                                Department
                            </span>
                            <span class="val">{{ $staff->department?->name ?? '—' }}</span>
                        </div>
                        <div class="sp-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                Joined
                            </span>
                            <span class="val">{{ $staff->joined_at?->format('M j, Y') ?? '—' }}</span>
                        </div>
                        <div class="sp-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Tenure
                            </span>
                            <span class="val accent">{{ $staff->joined_at ? $staff->joined_at->diffForHumans(null, true) : '—' }}</span>
                        </div>
                        <div class="sp-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Last Updated
                            </span>
                            <span class="val">{{ $staff->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Quick actions ── --}}
            <div class="sp-card">
                <div class="sp-card-header">
                    <div class="sp-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    </div>
                    <h6>Quick Actions</h6>
                </div>
                <div class="sp-card-body">
                    <div class="sp-actions-list">

                        {{-- Change status --}}
                        <button class="sp-action-btn"
                                data-bs-toggle="modal" data-bs-target="#statusModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            Change Status
                        </button>

                        {{-- Reset password --}}
                        <button class="sp-action-btn blue"
                                data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Reset Password
                        </button>

                        {{-- Send credentials --}}
                        <form method="POST" action="{{ route('admin.staff.reset-password', $staff->id) }}">
                            @csrf
                            <button type="submit" class="sp-action-btn"
                                    onclick="return confirm('Generate a new password and email it to {{ $staff->user?->email }}?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                Resend Credentials
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>{{-- /.sp-left --}}

        {{-- ══ RIGHT COLUMN ══ --}}
        <div class="sp-right">

            {{-- ── Employment Details ── --}}
            <div class="sp-card">
                <div class="sp-card-header">
                    <div class="sp-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    </div>
                    <h6>Employment Details</h6>
                    <a href="{{ route('admin.staff.edit', $staff->id) }}"
                       class="sp-card-action sp-btn sp-btn-ghost sp-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                </div>
                <div class="sp-card-body" style="padding:0">
                    <div class="sp-info-grid">
                        <div class="sp-info-cell">
                            <div class="sp-info-key">Full Name</div>
                            <div class="sp-info-val">{{ $staff->user?->name ?? '—' }}</div>
                        </div>
                        <div class="sp-info-cell">
                            <div class="sp-info-key">Email</div>
                            <div class="sp-info-val" style="font-size:.83rem">
                                <a href="mailto:{{ $staff->user?->email }}"
                                   style="color:var(--accent);text-decoration:none">
                                    {{ $staff->user?->email ?? '—' }}
                                </a>
                            </div>
                        </div>
                        <div class="sp-info-cell">
                            <div class="sp-info-key">Employee ID</div>
                            <div class="sp-info-val mono">{{ $staff->employee_id ?? '—' }}</div>
                        </div>
                        <div class="sp-info-cell">
                            <div class="sp-info-key">Position</div>
                            <div class="sp-info-val">{{ $staff->position ?? '—' }}</div>
                        </div>
                        <div class="sp-info-cell">
                            <div class="sp-info-key">Department</div>
                            <div class="sp-info-val">{{ $staff->department?->name ?? '—' }}</div>
                        </div>
                        <div class="sp-info-cell">
                            <div class="sp-info-key">Phone</div>
                            <div class="sp-info-val">
                                @if($staff->phone)
                                    <a href="tel:{{ $staff->phone }}" style="color:var(--text);text-decoration:none">
                                        {{ $staff->phone }}
                                    </a>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </div>
                        </div>
                        <div class="sp-info-cell">
                            <div class="sp-info-key">Status</div>
                            <div class="sp-info-val">
                                <span class="sp-status {{ $statusClass }}">
                                    <span class="sp-status-dot"></span>
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>
                        <div class="sp-info-cell">
                            <div class="sp-info-key">Joined Date</div>
                            <div class="sp-info-val">{{ $staff->joined_at?->format('F j, Y') ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Notes ── --}}
            <div class="sp-card">
                <div class="sp-card-header">
                    <div class="sp-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <h6>Internal Notes</h6>
                </div>
                <div class="sp-card-body">
                    @if($staff->notes)
                        <p class="sp-notes">{{ $staff->notes }}</p>
                    @else
                        <p class="sp-no-notes">No internal notes on this staff member.</p>
                    @endif
                </div>
            </div>

            {{-- ── Activity timeline ── --}}
            <div class="sp-card">
                <div class="sp-card-header">
                    <div class="sp-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h6>Activity Timeline</h6>
                </div>
                <div class="sp-card-body">
                    <div class="sp-timeline">

                        {{-- Joined --}}
                        @if($staff->joined_at)
                            <div class="sp-timeline-item">
                                <div class="sp-timeline-left">
                                    <div class="sp-timeline-dot accent">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                                    </div>
                                    <div class="sp-timeline-line"></div>
                                </div>
                                <div class="sp-timeline-content">
                                    <div class="sp-timeline-title">Joined the team</div>
                                    <div class="sp-timeline-meta">{{ $staff->joined_at->format('F j, Y') }} &mdash; {{ $staff->joined_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endif

                        {{-- Account created --}}
                        @if($staff->user?->created_at)
                            <div class="sp-timeline-item">
                                <div class="sp-timeline-left">
                                    <div class="sp-timeline-dot blue">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                                    </div>
                                    <div class="sp-timeline-line"></div>
                                </div>
                                <div class="sp-timeline-content">
                                    <div class="sp-timeline-title">User account created</div>
                                    <div class="sp-timeline-meta">{{ $staff->user->created_at->format('F j, Y') }} &mdash; {{ $staff->user->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endif

                        {{-- Last profile update --}}
                        <div class="sp-timeline-item">
                            <div class="sp-timeline-left">
                                <div class="sp-timeline-dot">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </div>
                                <div class="sp-timeline-line"></div>
                            </div>
                            <div class="sp-timeline-content">
                                <div class="sp-timeline-title">Profile last updated</div>
                                <div class="sp-timeline-meta">{{ $staff->updated_at->format('F j, Y') }} &mdash; {{ $staff->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        {{-- Current status ── --}}
                        <div class="sp-timeline-item">
                            <div class="sp-timeline-left">
                                <div class="sp-timeline-dot {{ in_array($staff->status, ['active']) ? 'green' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>
                                </div>
                            </div>
                            <div class="sp-timeline-content">
                                <div class="sp-timeline-title">Current status: {{ $statusLabel }}</div>
                                <div class="sp-timeline-meta">Use Quick Actions to change status</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ── Danger zone ── --}}
            <div class="sp-card" style="border-color:#fecaca;">
                <div class="sp-card-header" style="background:#fef2f2;border-color:#fecaca;">
                    <div class="sp-card-header-icon" style="background:#fee2e2;color:var(--danger);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    </div>
                    <h6 style="color:var(--danger)">Danger Zone</h6>
                </div>
                <div class="sp-card-body">
                    <p style="font-size:.82rem;color:var(--muted);margin-bottom:1rem;line-height:1.55;">
                        Removing this staff member will permanently delete their profile and their linked login account from the system.
                    </p>
                    <button class="sp-btn sp-btn-danger"
                            style="width:100%;justify-content:center;"
                            data-bs-toggle="modal" data-bs-target="#deleteStaffModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Remove Staff Member
                    </button>
                </div>
            </div>

        </div>{{-- /.sp-right --}}
    </div>{{-- /.sp-layout --}}
</div>

{{-- ══ STATUS MODAL ══ --}}
<div class="modal fade sp-modal" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.staff.status', $staff->id) }}" class="modal-content">
            @csrf @method('PATCH')
            <div class="modal-header">
                <div class="sp-modal-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <h5 class="modal-title">Change Status</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="sp-label">New Status</label>
                <select name="status" class="sp-select" required>
                    <option value="active"     {{ $staff->status === 'active'     ? 'selected' : '' }}>Active</option>
                    <option value="inactive"   {{ $staff->status === 'inactive'   ? 'selected' : '' }}>Inactive</option>
                    <option value="on_leave"   {{ $staff->status === 'on_leave'   ? 'selected' : '' }}>On Leave</option>
                    <option value="terminated" {{ $staff->status === 'terminated' ? 'selected' : '' }}>Terminated</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="sp-btn sp-btn-ghost sp-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="sp-btn sp-btn-primary sp-btn-sm">Update Status</button>
            </div>
        </form>
    </div>
</div>

{{-- ══ RESET PASSWORD MODAL ══ --}}
<div class="modal fade sp-modal" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.staff.reset-password', $staff->id) }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="sp-modal-icon blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="display:flex;align-items:flex-start;gap:.65rem;padding:.85rem 1rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.83rem;color:#1d4ed8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                    <span>A new secure password will be generated and sent to <strong>{{ $staff->user?->email }}</strong>. The old password will stop working immediately.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="sp-btn sp-btn-ghost sp-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="sp-btn sp-btn-sm" style="background:var(--blue);color:#fff;border:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Reset &amp; Send
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ DELETE MODAL ══ --}}
<div class="modal fade sp-modal" id="deleteStaffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.staff.destroy', $staff->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="sp-modal-icon danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                </div>
                <h5 class="modal-title" style="color:var(--danger)">Remove Staff Member</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="sp-delete-box">
                    You are about to permanently remove <strong>{{ $staff->user?->name ?? 'this staff member' }}</strong>
                    @if($staff->employee_id)({{ $staff->employee_id }})@endif.
                    Their login account will also be deleted.
                    <br><br>
                    <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="sp-btn sp-btn-ghost sp-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="sp-btn sp-btn-danger sp-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Remove
                </button>
            </div>
        </form>
    </div>
</div>

@endsection