@extends('layouts.base')

@section('title', 'My Dashboard — Terra')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --navy:   #19265d;
        --navy-dk:#111a42;
        --navy-lt:#f0f2f8;
        --gold:   #D05208;
        --gold-lt:#fdf3ec;
        --white:  #ffffff;
        --gray-50:#f8f9fb;
        --gray-100:#f0f1f5;
        --gray-200:#e0e3ed;
        --gray-400:#9aa0b8;
        --gray-600:#5a6082;
        --gray-800:#2d3258;
        --radius-sm: 6px;
        --radius-md: 10px;
        --radius-lg: 16px;
        --shadow-sm: 0 1px 4px rgba(25,38,93,.08);
        --shadow-md: 0 4px 20px rgba(25,38,93,.12);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--gray-50);
        color: var(--gray-800);
        min-height: 100vh;
    }

    /* ── LAYOUT ───────────────────────────────────── */
    .layout { display: flex; min-height: 100vh; }

    /* ── SIDEBAR ──────────────────────────────────── */
    .sidebar {
        width: 260px;
        flex-shrink: 0;
        background: var(--navy);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0; bottom: 0;
        z-index: 100;
        overflow-y: auto;
    }

    .sidebar-brand {
        padding: 28px 24px 20px;
        border-bottom: 1px solid rgba(255,255,255,.08);
    }

    .sidebar-brand .brand-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 26px;
        font-weight: 600;
        color: #fff;
        letter-spacing: .5px;
    }

    .sidebar-brand .brand-tagline {
        font-size: 11px;
        color: rgba(255,255,255,.45);
        letter-spacing: 1.2px;
        text-transform: uppercase;
        margin-top: 2px;
    }

    .sidebar-user {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: var(--gold);
        display: flex; align-items: center; justify-content: center;
        font-weight: 600; font-size: 14px;
        color: #fff;
        flex-shrink: 0;
    }

    .user-meta .user-name {
        font-size: 14px;
        font-weight: 500;
        color: #fff;
    }

    .user-meta .user-role {
        font-size: 11px;
        color: rgba(255,255,255,.5);
        margin-top: 1px;
    }

    .role-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .6px;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 20px;
        margin-top: 4px;
    }

    .role-badge.professional { background: rgba(208,82,8,.2); color: #f5a06a; }
    .role-badge.consultant   { background: rgba(79,134,209,.2); color: #8ab8f0; }
    .role-badge.user         { background: rgba(255,255,255,.1); color: rgba(255,255,255,.6); }

    .sidebar-nav { padding: 16px 12px; flex: 1; }

    .nav-section-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        color: rgba(255,255,255,.3);
        padding: 0 12px;
        margin-bottom: 6px;
        margin-top: 16px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius-sm);
        color: rgba(255,255,255,.65);
        font-size: 14px;
        font-weight: 400;
        text-decoration: none;
        transition: all .15s ease;
        cursor: pointer;
        position: relative;
    }

    .nav-item:hover { background: rgba(255,255,255,.07); color: #fff; }

    .nav-item.active {
        background: rgba(208,82,8,.18);
        color: #fff;
    }

    .nav-item.active::before {
        content: '';
        position: absolute;
        left: 0; top: 6px; bottom: 6px;
        width: 3px;
        background: var(--gold);
        border-radius: 0 2px 2px 0;
    }

    .nav-icon {
        width: 18px; height: 18px;
        opacity: .75;
        flex-shrink: 0;
    }

    .nav-item.active .nav-icon { opacity: 1; }

    .nav-badge {
        margin-left: auto;
        background: var(--gold);
        color: #fff;
        font-size: 10px;
        font-weight: 600;
        padding: 1px 7px;
        border-radius: 20px;
    }

    .sidebar-footer {
        padding: 16px 12px 24px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    /* ── MAIN CONTENT ─────────────────────────────── */
    .main {
        margin-left: 260px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* ── TOPBAR ───────────────────────────────────── */
    .topbar {
        background: var(--white);
        border-bottom: 1px solid var(--gray-200);
        padding: 0 32px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 50;
    }

    .topbar-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px;
        font-weight: 600;
        color: var(--navy);
    }

    .topbar-actions { display: flex; align-items: center; gap: 12px; }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: all .15s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--navy);
        color: #fff;
    }

    .btn-primary:hover { background: var(--navy-dk); }

    .btn-gold {
        background: var(--gold);
        color: #fff;
    }

    .btn-gold:hover { background: #b84607; }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
    }

    .btn-outline:hover { background: var(--gray-50); border-color: var(--gray-400); }

    .btn-sm { padding: 6px 12px; font-size: 12px; }

    /* ── PAGE CONTENT ─────────────────────────────── */
    .page-content { padding: 32px; flex: 1; }

    /* ── STATS STRIP ──────────────────────────────── */
    .stats-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        padding: 20px 22px;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
    }

    .stat-card.pending::before  { background: #f59e0b; }
    .stat-card.progress::before { background: #3b82f6; }
    .stat-card.done::before     { background: #10b981; }
    .stat-card.overdue::before  { background: #ef4444; }

    .stat-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .8px;
        text-transform: uppercase;
        color: var(--gray-400);
        margin-bottom: 8px;
    }

    .stat-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 36px;
        font-weight: 600;
        color: var(--navy);
        line-height: 1;
    }

    .stat-sub {
        font-size: 12px;
        color: var(--gray-400);
        margin-top: 4px;
    }

    /* ── SECTION HEADER ───────────────────────────── */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-weight: 600;
        color: var(--navy);
    }

    /* ── TASK TABLE ───────────────────────────────── */
    .task-table-wrap {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .task-filter-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 18px;
        border-bottom: 1px solid var(--gray-100);
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        background: transparent;
        border: 1px solid var(--gray-200);
        color: var(--gray-600);
        transition: all .15s;
    }

    .filter-tab.active {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }

    .search-box {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
        padding: 6px 12px;
    }

    .search-box input {
        border: none;
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: 13px;
        color: var(--gray-800);
        outline: none;
        width: 180px;
    }

    table.task-table {
        width: 100%;
        border-collapse: collapse;
    }

    .task-table thead th {
        padding: 11px 18px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .8px;
        text-transform: uppercase;
        color: var(--gray-400);
        border-bottom: 1px solid var(--gray-100);
        background: var(--gray-50);
    }

    .task-table tbody tr {
        border-bottom: 1px solid var(--gray-100);
        transition: background .1s;
    }

    .task-table tbody tr:last-child { border-bottom: none; }
    .task-table tbody tr:hover { background: var(--navy-lt); }

    .task-table tbody td {
        padding: 14px 18px;
        font-size: 13.5px;
        color: var(--gray-800);
        vertical-align: middle;
    }

    .task-title-cell { font-weight: 500; color: var(--navy); }

    .task-desc-cell {
        font-size: 12px;
        color: var(--gray-400);
        margin-top: 2px;
    }

    /* ── BADGES ───────────────────────────────────── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .3px;
    }

    .badge-pending  { background: #fef3c7; color: #92400e; }
    .badge-progress { background: #dbeafe; color: #1e40af; }
    .badge-done     { background: #d1fae5; color: #065f46; }
    .badge-overdue  { background: #fee2e2; color: #991b1b; }
    .badge-review   { background: #ede9fe; color: #4c1d95; }

    .priority-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .priority-high   { background: #ef4444; }
    .priority-medium { background: #f59e0b; }
    .priority-low    { background: #10b981; }

    /* ── ACTION BUTTONS IN TABLE ──────────────────── */
    .tbl-actions { display: flex; align-items: center; gap: 6px; }

    .icon-btn {
        width: 30px; height: 30px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--gray-200);
        background: transparent;
        cursor: pointer;
        color: var(--gray-600);
        transition: all .15s;
    }

    .icon-btn:hover { background: var(--gray-100); color: var(--navy); }

    /* ── DEADLINE ─────────────────────────────────── */
    .deadline-cell { display: flex; align-items: center; gap: 6px; font-size: 13px; }
    .deadline-cell.overdue { color: #dc2626; }

    /* ── TABS ─────────────────────────────────────── */
    .tabs {
        display: flex;
        gap: 0;
        border-bottom: 2px solid var(--gray-200);
        margin-bottom: 24px;
    }

    .tab {
        padding: 12px 22px;
        font-size: 14px;
        font-weight: 500;
        color: var(--gray-400);
        cursor: pointer;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        transition: all .15s;
    }

    .tab.active {
        color: var(--navy);
        border-bottom-color: var(--gold);
    }

    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── SUBMIT TASK FORM ─────────────────────────── */
    .form-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        padding: 28px 32px;
        max-width: 780px;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group { margin-bottom: 20px; }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--gray-600);
        margin-bottom: 7px;
    }

    .form-label span.required { color: var(--gold); margin-left: 2px; }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--gray-800);
        background: var(--white);
        transition: border-color .15s;
        outline: none;
    }

    .form-control:focus { border-color: var(--navy); }

    select.form-control { cursor: pointer; appearance: none; }

    textarea.form-control { resize: vertical; min-height: 100px; }

    /* ── FILE UPLOAD AREA ─────────────────────────── */
    .upload-area {
        border: 2px dashed var(--gray-200);
        border-radius: var(--radius-md);
        padding: 36px 24px;
        text-align: center;
        cursor: pointer;
        transition: all .2s;
        position: relative;
    }

    .upload-area:hover, .upload-area.drag-over {
        border-color: var(--navy);
        background: var(--navy-lt);
    }

    .upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-icon {
        width: 44px; height: 44px;
        margin: 0 auto 12px;
        background: var(--navy-lt);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }

    .upload-label {
        font-size: 14px;
        font-weight: 500;
        color: var(--navy);
    }

    .upload-hint {
        font-size: 12px;
        color: var(--gray-400);
        margin-top: 4px;
    }

    /* ── FILE LIST ────────────────────────────────── */
    .file-list { margin-top: 16px; display: flex; flex-direction: column; gap: 10px; }

    .file-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-sm);
    }

    .file-icon {
        width: 34px; height: 34px;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .file-icon.pdf   { background: #fee2e2; color: #dc2626; }
    .file-icon.docx  { background: #dbeafe; color: #2563eb; }
    .file-icon.image { background: #d1fae5; color: #059669; }
    .file-icon.other { background: var(--gray-100); color: var(--gray-600); }

    .file-meta { flex: 1; min-width: 0; }

    .file-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--navy);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .file-size { font-size: 11px; color: var(--gray-400); margin-top: 1px; }

    .file-remove {
        width: 26px; height: 26px;
        border: none;
        background: transparent;
        cursor: pointer;
        border-radius: 4px;
        display: flex; align-items: center; justify-content: center;
        color: var(--gray-400);
        transition: all .15s;
    }

    .file-remove:hover { background: #fee2e2; color: #dc2626; }

    /* ── DOCUMENTS GRID ───────────────────────────── */
    .doc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .doc-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        padding: 20px 18px;
        cursor: pointer;
        transition: all .15s;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 10px;
    }

    .doc-card:hover {
        border-color: var(--navy);
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .doc-card-icon {
        width: 50px; height: 50px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
    }

    .doc-card-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--navy);
        word-break: break-word;
    }

    .doc-card-meta { font-size: 11px; color: var(--gray-400); }

    /* ── EMPTY STATE ──────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--gray-400);
    }

    .empty-state svg { margin-bottom: 12px; opacity: .4; }
    .empty-state p { font-size: 14px; }

    /* ── RESPONSIVE ───────────────────────────────── */
    @media (max-width: 1024px) {
        .stats-strip { grid-template-columns: repeat(2, 1fr); }
        .form-grid-2 { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); transition: transform .25s; }
        .sidebar.open { transform: translateX(0); }
        .main { margin-left: 0; }
        .page-content { padding: 20px 16px; }
        .stats-strip { grid-template-columns: 1fr 1fr; }
    }
</style>



<div class="layout">

    {{-- ── SIDEBAR ──────────────────────────────────── --}}
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-brand">
            <div class="brand-name">Terra</div>
            <div class="brand-tagline">Real Estate Platform</div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->first_name, 0, 1) . substr(auth()->user()->last_name, 0, 1)) }}
            </div>
            <div class="user-meta">
                <div class="user-name">{{ auth()->user()->full_name }}</div>
                <div class="user-role">{{ auth()->user()->email }}</div>
                <div class="role-badge {{ strtolower(auth()->user()->role) }}">
                    {{ ucfirst(auth()->user()->role) }}
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section-label">Workspace</div>

            <a href="#" class="nav-item active" onclick="showTab('tasks'); return false;">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                My Tasks
                @php $pending = $tasks->where('status','pending')->count(); @endphp
                @if($pending > 0)
                    <span class="nav-badge">{{ $pending }}</span>
                @endif
            </a>

            <a href="#" class="nav-item" onclick="showTab('submit'); return false;">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Submit Task
            </a>

            <a href="#" class="nav-item" onclick="showTab('documents'); return false;">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                My Documents
            </a>

            <div class="nav-section-label">Account</div>

            <a href="{{ route('profile.edit') }}" class="nav-item">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Profile
            </a>

        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item" style="width:100%; border:none; cursor:pointer; background:transparent;">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>

    </aside>

    {{-- ── MAIN ──────────────────────────────────────── --}}
    <main class="main">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="topbar-title" id="topbar-title">My Tasks</div>
            <div class="topbar-actions">
                <button class="btn btn-gold" onclick="showTab('submit')">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Submit Task
                </button>
            </div>
        </div>

        <div class="page-content">

            {{-- Flash messages --}}
            @if(session('success'))
                <div style="background:#d1fae5; border:1px solid #6ee7b7; border-radius:8px; padding:12px 18px; font-size:14px; color:#065f46; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ── STATS STRIP ──────────────────────────── --}}
            <div class="stats-strip">
                <div class="stat-card pending">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value">{{ $tasks->where('status','pending')->count() }}</div>
                    <div class="stat-sub">Awaiting action</div>
                </div>
                <div class="stat-card progress">
                    <div class="stat-label">In Progress</div>
                    <div class="stat-value">{{ $tasks->where('status','in_progress')->count() }}</div>
                    <div class="stat-sub">Currently active</div>
                </div>
                <div class="stat-card done">
                    <div class="stat-label">Completed</div>
                    <div class="stat-value">{{ $tasks->where('status','completed')->count() }}</div>
                    <div class="stat-sub">This month</div>
                </div>
                <div class="stat-card overdue">
                    <div class="stat-label">Overdue</div>
                    <div class="stat-value">{{ $tasks->where('status','overdue')->count() }}</div>
                    <div class="stat-sub">Needs attention</div>
                </div>
            </div>

            {{-- ── TABS ──────────────────────────────────── --}}
            <div class="tabs">
                <div class="tab active" id="tab-tasks"     onclick="showTab('tasks')">My Tasks</div>
                <div class="tab"        id="tab-submit"    onclick="showTab('submit')">Submit Task</div>
                <div class="tab"        id="tab-documents" onclick="showTab('documents')">My Documents</div>
            </div>

            {{-- ══════════════════════════════════════════════
                 TAB 1: MY TASKS
            ══════════════════════════════════════════════ --}}
            <div class="tab-panel active" id="panel-tasks">

                <div class="section-header">
                    <div class="section-title">Assigned Tasks</div>
                </div>

                <div class="task-table-wrap">

                    <div class="task-filter-bar">
                        <button class="filter-tab active" onclick="filterTasks(this,'all')">All</button>
                        <button class="filter-tab"        onclick="filterTasks(this,'pending')">Pending</button>
                        <button class="filter-tab"        onclick="filterTasks(this,'in_progress')">In Progress</button>
                        <button class="filter-tab"        onclick="filterTasks(this,'completed')">Completed</button>
                        <button class="filter-tab"        onclick="filterTasks(this,'overdue')">Overdue</button>

                        <div class="search-box">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9aa0b8" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                            </svg>
                            <input type="text" placeholder="Search tasks…" id="taskSearch" onkeyup="searchTasks(this.value)">
                        </div>
                    </div>

                    @if($tasks->count())
                    <table class="task-table" id="taskTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Deadline</th>
                                <th>Files</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $i => $task)
                            <tr data-status="{{ $task->status }}">
                                <td style="color:var(--gray-400); font-size:12px;">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="task-title-cell">{{ $task->title }}</div>
                                    <div class="task-desc-cell">{{ Str::limit($task->description, 55) }}</div>
                                </td>
                                <td>
                                    <span class="priority-dot priority-{{ $task->priority }}"></span>
                                    {{ ucfirst($task->priority) }}
                                </td>
                                <td>
                                    @php
                                        $badgeMap = [
                                            'pending'     => 'badge-pending',
                                            'in_progress' => 'badge-progress',
                                            'completed'   => 'badge-done',
                                            'overdue'     => 'badge-overdue',
                                            'under_review'=> 'badge-review',
                                        ];
                                    @endphp
                                    <span class="badge {{ $badgeMap[$task->status] ?? 'badge-pending' }}">
                                        {{ ucwords(str_replace('_',' ',$task->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="deadline-cell {{ $task->isOverdue() ? 'overdue' : '' }}">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $task->deadline ? $task->deadline->format('d M Y') : '—' }}
                                    </div>
                                </td>
                                <td>
                                    @if($task->files->count())
                                        <span style="font-size:12px; color:var(--navy); font-weight:500;">
                                            {{ $task->files->count() }} file{{ $task->files->count() > 1 ? 's' : '' }}
                                        </span>
                                    @else
                                        <span style="font-size:12px; color:var(--gray-400);">None</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="tbl-actions">
                                        {{-- View --}}
                                        <a href="{{ route('tasks.show', $task) }}" class="icon-btn" title="View Details">
                                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        {{-- Submit / Upload --}}
                                        @if(in_array($task->status,['pending','in_progress']))
                                            <button class="icon-btn" title="Submit Files"
                                                onclick="prefillSubmit({{ $task->id }}, '{{ addslashes($task->title) }}')">
                                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div style="padding:14px 18px; border-top:1px solid var(--gray-100); display:flex; align-items:center; justify-content:space-between;">
                        <span style="font-size:12px; color:var(--gray-400);">
                            Showing {{ $tasks->count() }} task{{ $tasks->count() !== 1 ? 's' : '' }}
                        </span>
                        {{ $tasks->links() }}
                    </div>

                    @else
                    <div class="empty-state">
                        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#9aa0b8" stroke-width="1.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p>No tasks assigned yet. Check back later.</p>
                    </div>
                    @endif

                </div>
            </div>

            {{-- ══════════════════════════════════════════════
                 TAB 2: SUBMIT TASK
            ══════════════════════════════════════════════ --}}
            <div class="tab-panel" id="panel-submit">

                <div class="section-header">
                    <div class="section-title">Submit a Task</div>
                </div>

                <div class="form-card">
                    <form method="POST" action="{{ route('tasks.submit') }}" enctype="multipart/form-data" id="submitForm">
                        @csrf

                        <input type="hidden" name="task_id" id="form_task_id">

                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Related Task <span class="required">*</span></label>
                                <select name="task_id_select" id="form_task_select" class="form-control" required
                                    onchange="document.getElementById('form_task_id').value = this.value">
                                    <option value="">— Select task —</option>
                                    @foreach($activeTasks as $t)
                                        <option value="{{ $t->id }}">{{ $t->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Submission Type <span class="required">*</span></label>
                                <select name="submission_type" class="form-control" required>
                                    <option value="progress_update">Progress Update</option>
                                    <option value="final_delivery">Final Delivery</option>
                                    <option value="additional_documents">Additional Documents</option>
                                    <option value="revision">Revision</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject / Title <span class="required">*</span></label>
                            <input type="text" name="subject" class="form-control"
                                placeholder="Brief subject for this submission" required maxlength="120">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Notes / Message</label>
                            <textarea name="notes" class="form-control"
                                placeholder="Describe what you're submitting, any notes for the reviewer…"></textarea>
                        </div>

                        {{-- File Upload --}}
                        <div class="form-group">
                            <label class="form-label">Attachments</label>

                            <div class="upload-area" id="uploadArea">
                                <input type="file" name="files[]" id="fileInput"
                                    multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.zip">
                                <div class="upload-icon">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#19265d" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <div class="upload-label">Drop files here or click to browse</div>
                                <div class="upload-hint">PDF, Word, Excel, Images, ZIP — max 20 MB each</div>
                            </div>

                            <div class="file-list" id="fileList"></div>
                        </div>

                        <div style="display:flex; gap:12px; margin-top:8px;">
                            <button type="submit" class="btn btn-primary">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Submit
                            </button>
                            <button type="button" class="btn btn-outline" onclick="clearForm()">Clear</button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════
                 TAB 3: MY DOCUMENTS
            ══════════════════════════════════════════════ --}}
            <div class="tab-panel" id="panel-documents">

                <div class="section-header">
                    <div class="section-title">My Documents</div>
                </div>

                @if($documents->count())
                <div class="doc-grid">
                    @foreach($documents as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc->original_name, PATHINFO_EXTENSION));
                        $iconClass = match(true) {
                            $ext === 'pdf'               => 'pdf',
                            in_array($ext,['doc','docx'])=> 'docx',
                            in_array($ext,['jpg','jpeg','png','gif','webp']) => 'image',
                            default => 'other'
                        };
                        $iconEmoji = match($iconClass) {
                            'pdf'   => '📄',
                            'docx'  => '📝',
                            'image' => '🖼',
                            default => '📁'
                        };
                    @endphp
                    <div class="doc-card">
                        <div class="doc-card-icon file-icon {{ $iconClass }}" style="font-size:22px;">{{ $iconEmoji }}</div>
                        <div class="doc-card-name">{{ Str::limit($doc->original_name, 28) }}</div>
                        <div class="doc-card-meta">
                            {{ strtoupper($ext) }} &middot; {{ number_format($doc->size / 1024, 1) }} KB
                        </div>
                        <div class="doc-card-meta" style="margin-top:2px;">{{ $doc->created_at->format('d M Y') }}</div>
                        <a href="{{ route('documents.download', $doc) }}"
                           class="btn btn-outline btn-sm" style="margin-top:4px;">
                            Download
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#9aa0b8" stroke-width="1.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                    <p>No documents uploaded yet.</p>
                </div>
                @endif

            </div>

        </div>{{-- /page-content --}}
    </main>

</div>


<script>
/* ── TAB SWITCHING ───────────────────────────── */
const titles = { tasks:'My Tasks', submit:'Submit a Task', documents:'My Documents' };

function showTab(name) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));

    document.getElementById('panel-' + name).classList.add('active');
    document.getElementById('tab-' + name).classList.add('active');
    document.getElementById('topbar-title').textContent = titles[name] || '';
}

/* ── PREFILL SUBMIT FROM TASK ROW ────────────── */
function prefillSubmit(taskId, taskTitle) {
    showTab('submit');
    const sel = document.getElementById('form_task_select');
    sel.value = taskId;
    document.getElementById('form_task_id').value = taskId;
}

/* ── TASK FILTER ─────────────────────────────── */
function filterTasks(btn, status) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('#taskTable tbody tr').forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });
}

/* ── TASK SEARCH ─────────────────────────────── */
function searchTasks(val) {
    const q = val.toLowerCase();
    document.querySelectorAll('#taskTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

/* ── FILE UPLOAD PREVIEW ─────────────────────── */
const fileInput  = document.getElementById('fileInput');
const fileList   = document.getElementById('fileList');
const uploadArea = document.getElementById('uploadArea');

let selectedFiles = [];

fileInput.addEventListener('change', handleFiles);

uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('drag-over'); });
uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
uploadArea.addEventListener('drop', e => {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    const dt = new DataTransfer();
    [...e.dataTransfer.files].forEach(f => dt.items.add(f));
    fileInput.files = dt.files;
    handleFiles();
});

function handleFiles() {
    const incoming = [...fileInput.files];
    incoming.forEach(f => {
        if (!selectedFiles.find(x => x.name === f.name)) selectedFiles.push(f);
    });
    renderFileList();
}

function renderFileList() {
    fileList.innerHTML = '';
    selectedFiles.forEach((file, i) => {
        const ext = file.name.split('.').pop().toLowerCase();
        const iconClass = ext === 'pdf' ? 'pdf' : ['doc','docx'].includes(ext) ? 'docx' : ['jpg','jpeg','png','gif','webp'].includes(ext) ? 'image' : 'other';
        const iconSvg = ext === 'pdf'
            ? `<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M6 2a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6H6zm7 1.5L18.5 9H13V3.5zM9 13h6v1H9v-1zm0 3h4v1H9v-1z"/></svg>`
            : `<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm0 2l4 4h-4V4z"/></svg>`;

        const div = document.createElement('div');
        div.className = 'file-item';
        div.innerHTML = `
            <div class="file-icon ${iconClass}">${iconSvg}</div>
            <div class="file-meta">
                <div class="file-name">${file.name}</div>
                <div class="file-size">${(file.size / 1024).toFixed(1)} KB</div>
            </div>
            <button type="button" class="file-remove" onclick="removeFile(${i})">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>`;
        fileList.appendChild(div);
    });

    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    fileInput.files = dt.files;
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderFileList();
}

function clearForm() {
    document.getElementById('submitForm').reset();
    selectedFiles = [];
    fileList.innerHTML = '';
    document.getElementById('form_task_id').value = '';
}
</script>
@endsection