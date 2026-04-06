@extends('layouts.app')

@section('title', 'Task Management — Terra Admin')
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
    --g50:    #f8f9fb;
    --g100:   #f0f1f5;
    --g200:   #e0e3ed;
    --g400:   #9aa0b8;
    --g600:   #5a6082;
    --g800:   #2d3258;
    --r-sm:6px; --r-md:10px; --r-lg:16px;
    --sh-sm: 0 1px 4px rgba(25,38,93,.07);
    --sh-md: 0 4px 24px rgba(25,38,93,.11);
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--g50);color:var(--g800)}

/* ── PAGE HEADER ─────────────────────────────────── */
.page-header{
    background:var(--white);
    border-bottom:1px solid var(--g200);
    padding:24px 32px;
    display:flex;align-items:center;justify-content:space-between;
    flex-wrap:wrap;gap:14px;
}
.page-header-left h1{
    font-family:'Cormorant Garamond',serif;
    font-size:26px;font-weight:600;color:var(--navy);
}
.page-header-left p{font-size:13px;color:var(--g400);margin-top:2px}
.page-actions{display:flex;gap:10px;align-items:center}

/* ── BUTTONS ─────────────────────────────────────── */
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;
    border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:13px;
    font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:all .15s}
.btn-primary{background:var(--navy);color:#fff}
.btn-primary:hover{background:var(--navy-dk)}
.btn-gold{background:var(--gold);color:#fff}
.btn-gold:hover{background:#b84607}
.btn-outline{background:transparent;border:1px solid var(--g200);color:var(--g600)}
.btn-outline:hover{background:var(--g50);border-color:var(--g400)}
.btn-danger{background:#fee2e2;color:#dc2626;border:1px solid #fca5a5}
.btn-danger:hover{background:#fecaca}
.btn-success{background:#d1fae5;color:#065f46;border:1px solid #6ee7b7}
.btn-success:hover{background:#a7f3d0}
.btn-sm{padding:6px 12px;font-size:12px}
.btn-xs{padding:4px 9px;font-size:11px;border-radius:4px}

/* ── STATS STRIP ──────────────────────────────────── */
.stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;padding:24px 32px}
.stat-card{background:var(--white);border:1px solid var(--g200);border-radius:var(--r-md);
    padding:18px 20px;position:relative;overflow:hidden}
.stat-card::after{content:'';position:absolute;top:0;left:0;right:0;height:3px}
.stat-card.all::after{background:var(--navy)}
.stat-card.pending::after{background:#f59e0b}
.stat-card.progress::after{background:#3b82f6}
.stat-card.review::after{background:#8b5cf6}
.stat-card.done::after{background:#10b981}
.stat-label{font-size:11px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:var(--g400);margin-bottom:6px}
.stat-value{font-family:'Cormorant Garamond',serif;font-size:34px;font-weight:600;color:var(--navy);line-height:1}
.stat-sub{font-size:11px;color:var(--g400);margin-top:4px}

/* ── TOOLBAR ─────────────────────────────────────── */
.toolbar{
    display:flex;align-items:center;gap:10px;
    padding:14px 32px;background:var(--white);
    border-bottom:1px solid var(--g200);flex-wrap:wrap;
}
.filter-tab{padding:6px 16px;border-radius:20px;font-size:13px;font-weight:500;
    cursor:pointer;background:transparent;border:1px solid var(--g200);color:var(--g600);transition:all .15s}
.filter-tab.active{background:var(--navy);border-color:var(--navy);color:#fff}
.toolbar-right{margin-left:auto;display:flex;gap:8px;align-items:center}
.search-wrap{display:flex;align-items:center;gap:8px;background:var(--g50);
    border:1px solid var(--g200);border-radius:var(--r-sm);padding:7px 12px}
.search-wrap input{border:none;background:transparent;font-family:'DM Sans',sans-serif;
    font-size:13px;color:var(--g800);outline:none;width:200px}
select.filter-select{padding:7px 12px;border:1px solid var(--g200);border-radius:var(--r-sm);
    font-family:'DM Sans',sans-serif;font-size:13px;color:var(--g600);background:var(--g50);
    outline:none;cursor:pointer}

/* ── TABLE ───────────────────────────────────────── */
.table-wrap{margin:24px 32px;background:var(--white);border:1px solid var(--g200);
    border-radius:var(--r-lg);overflow:hidden;box-shadow:var(--sh-sm)}
table.main-table{width:100%;border-collapse:collapse}
.main-table thead th{padding:11px 16px;text-align:left;font-size:11px;font-weight:600;
    letter-spacing:.8px;text-transform:uppercase;color:var(--g400);
    border-bottom:1px solid var(--g100);background:var(--g50);white-space:nowrap}
.main-table thead th:first-child{width:40px}
.main-table tbody tr{border-bottom:1px solid var(--g100);transition:background .1s}
.main-table tbody tr:last-child{border-bottom:none}
.main-table tbody tr:hover{background:var(--navy-lt)}
.main-table tbody tr.selected{background:#f0f2f8}
.main-table td{padding:13px 16px;font-size:13.5px;color:var(--g800);vertical-align:middle}

/* ── BADGES ──────────────────────────────────────── */
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;
    border-radius:20px;font-size:11px;font-weight:600;white-space:nowrap}
.badge-pending     {background:#fef3c7;color:#92400e}
.badge-in_progress {background:#dbeafe;color:#1e40af}
.badge-under_review{background:#ede9fe;color:#4c1d95}
.badge-completed   {background:#d1fae5;color:#065f46}
.badge-overdue     {background:#fee2e2;color:#991b1b}

.pri-dot{width:7px;height:7px;border-radius:50%;display:inline-block;margin-right:5px;flex-shrink:0}
.pri-high{background:#ef4444}.pri-medium{background:#f59e0b}.pri-low{background:#10b981}

/* ── ASSIGNEE CHIP ───────────────────────────────── */
.assignee-chip{display:flex;align-items:center;gap:8px}
.chip-avatar{width:28px;height:28px;border-radius:50%;background:var(--navy);
    display:flex;align-items:center;justify-content:center;font-size:11px;
    font-weight:600;color:#fff;flex-shrink:0}
.chip-name{font-size:13px;font-weight:500;color:var(--navy)}
.chip-role{font-size:11px;color:var(--g400)}

/* ── ROW ACTIONS ─────────────────────────────────── */
.row-actions{display:flex;align-items:center;gap:5px}
.icon-btn{width:30px;height:30px;border-radius:var(--r-sm);display:flex;align-items:center;
    justify-content:center;border:1px solid var(--g200);background:transparent;cursor:pointer;
    color:var(--g600);transition:all .15s;text-decoration:none}
.icon-btn:hover{background:var(--g100);color:var(--navy)}
.icon-btn.del:hover{background:#fee2e2;border-color:#fca5a5;color:#dc2626}

/* ── BULK BAR ────────────────────────────────────── */
.bulk-bar{display:none;align-items:center;gap:12px;padding:10px 32px;
    background:#eef1ff;border-bottom:1px solid #d0d8f8;font-size:13px;color:var(--navy)}
.bulk-bar.visible{display:flex}

/* ── PAGINATION ──────────────────────────────────── */
.table-footer{display:flex;align-items:center;justify-content:space-between;
    padding:12px 18px;border-top:1px solid var(--g100)}
.table-footer span{font-size:12px;color:var(--g400)}

/* ── EMPTY STATE ──────────────────────────────────── */
.empty-state{text-align:center;padding:64px 20px;color:var(--g400)}
.empty-state svg{margin-bottom:12px;opacity:.35}
.empty-state p{font-size:14px}

/* ── DEADLINE ────────────────────────────────────── */
.deadline{display:flex;align-items:center;gap:5px;font-size:13px}
.deadline.overdue{color:#dc2626;font-weight:500}

/* ── SUBMISSIONS COUNT ───────────────────────────── */
.sub-count{display:inline-flex;align-items:center;gap:5px;font-size:12px;
    background:var(--navy-lt);color:var(--navy);padding:3px 9px;border-radius:20px;font-weight:500}
</style>


{{-- ── PAGE HEADER ──────────────────────────────────── --}}
<div class="page-header">
    <div class="page-header-left">
        <h1>Task Management</h1>
        <p>Assign, track, and review tasks for professionals, consultants and users</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-gold">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Assign New Task
        </a>
        <a href="{{ route('admin.tasks.submissions.index') }}" class="btn btn-outline">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            All Submissions
            @if($pendingSubmissions > 0)
                <span style="background:var(--gold);color:#fff;font-size:10px;padding:1px 7px;border-radius:20px;font-weight:600;">
                    {{ $pendingSubmissions }}
                </span>
            @endif
        </a>
    </div>
</div>

{{-- ── STATS ────────────────────────────────────────── --}}
<div class="stats-strip">
    <div class="stat-card all">
        <div class="stat-label">Total Tasks</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
        <div class="stat-sub">All time</div>
    </div>
    <div class="stat-card pending">
        <div class="stat-label">Pending</div>
        <div class="stat-value">{{ $stats['pending'] }}</div>
        <div class="stat-sub">Not started</div>
    </div>
    <div class="stat-card progress">
        <div class="stat-label">In Progress</div>
        <div class="stat-value">{{ $stats['in_progress'] }}</div>
        <div class="stat-sub">Active</div>
    </div>
    <div class="stat-card review">
        <div class="stat-label">Under Review</div>
        <div class="stat-value">{{ $stats['under_review'] }}</div>
        <div class="stat-sub">Needs action</div>
    </div>
    <div class="stat-card done">
        <div class="stat-label">Completed</div>
        <div class="stat-value">{{ $stats['completed'] }}</div>
        <div class="stat-sub">This month</div>
    </div>
</div>

{{-- Flash --}}
@if(session('success'))
<div style="margin:0 32px 4px;background:#d1fae5;border:1px solid #6ee7b7;border-radius:8px;padding:11px 16px;font-size:13px;color:#065f46;display:flex;align-items:center;gap:8px">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- ── TOOLBAR ──────────────────────────────────────── --}}
<div class="toolbar">
    @foreach(['all'=>'All','pending'=>'Pending','in_progress'=>'In Progress','under_review'=>'Under Review','completed'=>'Completed','overdue'=>'Overdue'] as $val=>$label)
        <button class="filter-tab {{ request('status','all') === $val ? 'active' : '' }}"
            onclick="applyFilter('status','{{ $val }}')">{{ $label }}</button>
    @endforeach

    <div class="toolbar-right">
        <select class="filter-select" onchange="applyFilter('priority',this.value)">
            <option value="">All Priorities</option>
            <option value="high"   {{ request('priority')==='high'   ? 'selected':'' }}>High</option>
            <option value="medium" {{ request('priority')==='medium' ? 'selected':'' }}>Medium</option>
            <option value="low"    {{ request('priority')==='low'    ? 'selected':'' }}>Low</option>
        </select>

        <select class="filter-select" onchange="applyFilter('role',this.value)">
            <option value="">All Roles</option>
            <option value="professional" {{ request('role')==='professional' ? 'selected':'' }}>Professional</option>
            <option value="consultant"   {{ request('role')==='consultant'   ? 'selected':'' }}>Consultant</option>
            <option value="user"         {{ request('role')==='user'         ? 'selected':'' }}>User</option>
        </select>

        <div class="search-wrap">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9aa0b8" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
            </svg>
            <input type="text" placeholder="Search tasks or assignees…" id="searchInput"
                value="{{ request('q') }}" onkeyup="debounceSearch(this.value)">
        </div>
    </div>
</div>

{{-- ── BULK ACTION BAR ──────────────────────────────── --}}
<div class="bulk-bar" id="bulkBar">
    <span id="bulkCount">0 selected</span>
    <form method="POST" action="{{ route('admin.tasks.bulk') }}" id="bulkForm">
        @csrf
        <input type="hidden" name="action" id="bulkAction">
        <input type="hidden" name="ids" id="bulkIds">
        <button type="button" class="btn btn-sm btn-success" onclick="bulkAction('mark_complete')">Mark Complete</button>
        <button type="button" class="btn btn-sm btn-outline"  onclick="bulkAction('mark_overdue')">Mark Overdue</button>
        <button type="button" class="btn btn-sm btn-danger"   onclick="bulkAction('delete')">Delete</button>
    </form>
    <button class="btn btn-sm btn-outline" onclick="clearSelection()">Cancel</button>
</div>

{{-- ── TASK TABLE ───────────────────────────────────── --}}
<div class="table-wrap">
    @if($tasks->count())
    <table class="main-table" id="taskTable">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll" onchange="toggleAll(this)" style="cursor:pointer"></th>
                <th>Task</th>
                <th>Assigned To</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Submissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tasks as $task)
        <tr data-id="{{ $task->id }}">
            <td>
                <input type="checkbox" class="row-check" value="{{ $task->id }}"
                    onchange="updateBulkBar()" style="cursor:pointer">
            </td>
            <td>
                <div style="font-weight:500;color:var(--navy);font-size:14px;">{{ $task->title }}</div>
                <div style="font-size:11px;color:var(--g400);margin-top:2px">{{ Str::limit($task->description,55) }}</div>
                <div style="font-size:11px;color:var(--g400);margin-top:2px">
                    Created {{ $task->created_at->diffForHumans() }}
                </div>
            </td>
            <td>
                <div class="assignee-chip">
                    <div class="chip-avatar">
                        {{ strtoupper(substr($task->assignee->first_name,0,1).substr($task->assignee->last_name,0,1)) }}
                    </div>
                    <div>
                        <div class="chip-name">{{ $task->assignee->full_name }}</div>
                        <div class="chip-role">{{ ucfirst($task->assignee->role) }}</div>
                    </div>
                </div>
            </td>
            <td>
                <span class="pri-dot pri-{{ $task->priority }}"></span>
                {{ ucfirst($task->priority) }}
            </td>
            <td>
                <span class="badge badge-{{ $task->status }}">
                    {{ ucwords(str_replace('_',' ',$task->status)) }}
                </span>
            </td>
            <td>
                <div class="deadline {{ $task->isOverdue() ? 'overdue' : '' }}">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $task->deadline ? $task->deadline->format('d M Y') : '—' }}
                </div>
                @if($task->deadline)
                    <div style="font-size:11px;color:{{ $task->isOverdue() ? '#dc2626' : 'var(--g400)' }};margin-top:2px">
                        {{ $task->isOverdue() ? 'Overdue by '.$task->deadline->diffForHumans(null,true) : 'Due '.$task->deadline->diffForHumans() }}
                    </div>
                @endif
            </td>
            <td>
                @if($task->submissions_count > 0)
                    <a href="{{ route('admin.tasks.submissions', $task) }}" class="sub-count">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        {{ $task->submissions_count }} submission{{ $task->submissions_count > 1 ? 's' : '' }}
                    </a>
                @else
                    <span style="font-size:12px;color:var(--g400)">None yet</span>
                @endif
            </td>
            <td>
                <div class="row-actions">
                    <a href="{{ route('admin.tasks.show', $task) }}" class="icon-btn" title="View">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <a href="{{ route('admin.tasks.edit', $task) }}" class="icon-btn" title="Edit">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    @if($task->submissions_count > 0)
                    <a href="{{ route('admin.tasks.submissions', $task) }}" class="icon-btn" title="Submissions">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </a>
                    @endif
                    <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}"
                        onsubmit="return confirm('Delete this task? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="icon-btn del" title="Delete">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div class="table-footer">
        <span>{{ $tasks->total() }} task{{ $tasks->total() !== 1 ? 's' : '' }} total</span>
        {{ $tasks->appends(request()->query())->links() }}
    </div>

    @else
    <div class="empty-state">
        <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="#9aa0b8" stroke-width="1.1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p>No tasks found. <a href="{{ route('admin.tasks.create') }}" style="color:var(--navy);font-weight:500">Assign one now</a>.</p>
    </div>
    @endif
</div>


<script>
/* ── FILTER ──────────────────────────────── */
function applyFilter(key, val) {
    const params = new URLSearchParams(window.location.search);
    if (!val || val === 'all') params.delete(key); else params.set(key, val);
    params.delete('page');
    window.location = '?' + params.toString();
}

/* ── SEARCH ──────────────────────────────── */
let timer;
function debounceSearch(val) {
    clearTimeout(timer);
    timer = setTimeout(() => {
        const params = new URLSearchParams(window.location.search);
        val ? params.set('q', val) : params.delete('q');
        params.delete('page');
        window.location = '?' + params.toString();
    }, 500);
}

/* ── BULK SELECTION ──────────────────────── */
function toggleAll(cb) {
    document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
    updateBulkBar();
}

function updateBulkBar() {
    const checked = [...document.querySelectorAll('.row-check:checked')];
    const bar = document.getElementById('bulkBar');
    document.getElementById('bulkCount').textContent = checked.length + ' selected';
    bar.classList.toggle('visible', checked.length > 0);
    document.getElementById('selectAll').indeterminate =
        checked.length > 0 && checked.length < document.querySelectorAll('.row-check').length;
}

function clearSelection() {
    document.querySelectorAll('.row-check, #selectAll').forEach(c => c.checked = false);
    document.getElementById('bulkBar').classList.remove('visible');
}

function bulkAction(action) {
    const ids = [...document.querySelectorAll('.row-check:checked')].map(c => c.value);
    if (!ids.length) return;
    if (action === 'delete' && !confirm('Delete ' + ids.length + ' task(s)? Cannot be undone.')) return;
    document.getElementById('bulkAction').value = action;
    document.getElementById('bulkIds').value = ids.join(',');
    document.getElementById('bulkForm').submit();
}
</script>
@endsection
