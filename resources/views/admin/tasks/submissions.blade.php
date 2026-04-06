@extends('layouts.app')

@section('title', 'Submissions — ' . $task->title . ' — Terra Admin')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root{
    --navy:#19265d;--navy-dk:#111a42;--navy-lt:#f0f2f8;
    --gold:#D05208;--white:#fff;--g50:#f8f9fb;--g100:#f0f1f5;
    --g200:#e0e3ed;--g400:#9aa0b8;--g600:#5a6082;--g800:#2d3258;
    --r-sm:6px;--r-md:10px;--r-lg:16px;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--g50);color:var(--g800)}

/* ── HEADER ──────────────────────────────────────── */
.page-header{background:var(--white);border-bottom:1px solid var(--g200);padding:22px 32px;
    display:flex;align-items:center;gap:16px;flex-wrap:wrap}
.back-btn{width:34px;height:34px;border-radius:var(--r-sm);border:1px solid var(--g200);
    background:transparent;display:flex;align-items:center;justify-content:center;
    cursor:pointer;color:var(--g600);text-decoration:none;transition:all .15s;flex-shrink:0}
.back-btn:hover{background:var(--g100)}
.header-title h1{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:var(--navy)}
.header-title p{font-size:13px;color:var(--g400);margin-top:2px}
.header-meta{margin-left:auto;display:flex;align-items:center;gap:10px}

/* ── TASK INFO STRIP ─────────────────────────────── */
.task-strip{background:var(--white);border-bottom:1px solid var(--g200);
    padding:16px 32px;display:flex;align-items:center;gap:28px;flex-wrap:wrap}
.task-strip-item{display:flex;align-items:center;gap:7px;font-size:13px;color:var(--g600)}
.task-strip-item strong{color:var(--navy);font-weight:500}
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;
    border-radius:20px;font-size:11px;font-weight:600}
.badge-pending     {background:#fef3c7;color:#92400e}
.badge-in_progress {background:#dbeafe;color:#1e40af}
.badge-under_review{background:#ede9fe;color:#4c1d95}
.badge-completed   {background:#d1fae5;color:#065f46}
.badge-overdue     {background:#fee2e2;color:#991b1b}
.badge-approved    {background:#d1fae5;color:#065f46}
.badge-rejected    {background:#fee2e2;color:#991b1b}

/* ── LAYOUT ──────────────────────────────────────── */
.layout{display:grid;grid-template-columns:1fr 300px;gap:24px;padding:28px 32px;align-items:start}

/* ── SUBMISSIONS LIST ────────────────────────────── */
.sub-card{background:var(--white);border:1px solid var(--g200);border-radius:var(--r-lg);
    margin-bottom:18px;overflow:hidden;transition:box-shadow .15s}
.sub-card:hover{box-shadow:0 4px 20px rgba(25,38,93,.09)}
.sub-card.review-pending{border-left:4px solid #8b5cf6}
.sub-card.review-approved{border-left:4px solid #10b981}
.sub-card.review-rejected{border-left:4px solid #ef4444}

.sub-header{padding:16px 20px;border-bottom:1px solid var(--g100);
    display:flex;align-items:flex-start;gap:12px}
.sub-num{width:32px;height:32px;border-radius:50%;background:var(--navy);
    display:flex;align-items:center;justify-content:center;font-size:12px;
    font-weight:600;color:#fff;flex-shrink:0;margin-top:1px}
.sub-meta{flex:1}
.sub-title{font-weight:500;color:var(--navy);font-size:14px}
.sub-subtitle{font-size:12px;color:var(--g400);margin-top:3px;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.sub-actions{display:flex;align-items:center;gap:8px;flex-shrink:0}

.sub-body{padding:16px 20px}
.sub-notes{font-size:13.5px;color:var(--g600);line-height:1.65;
    background:var(--g50);border-radius:var(--r-sm);padding:14px;border-left:3px solid var(--g200)}

/* ── FILE ATTACHMENTS ────────────────────────────── */
.files-section{margin-top:16px}
.files-label{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.8px;
    color:var(--g400);margin-bottom:10px}
.files-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:10px}
.file-card{background:var(--g50);border:1px solid var(--g200);border-radius:var(--r-md);
    padding:14px 12px;display:flex;flex-direction:column;align-items:center;text-align:center;
    gap:8px;cursor:pointer;transition:all .15s;text-decoration:none}
.file-card:hover{border-color:var(--navy);background:var(--navy-lt)}
.file-card-icon{width:44px;height:44px;border-radius:10px;
    display:flex;align-items:center;justify-content:center;font-size:20px}
.file-card-icon.pdf  {background:#fee2e2;color:#dc2626}
.file-card-icon.doc  {background:#dbeafe;color:#2563eb}
.file-card-icon.xls  {background:#d1fae5;color:#059669}
.file-card-icon.img  {background:#fef3c7;color:#d97706}
.file-card-icon.zip  {background:#ede9fe;color:#7c3aed}
.file-card-icon.oth  {background:var(--g100);color:var(--g600)}
.file-card-name{font-size:12px;font-weight:500;color:var(--navy);word-break:break-word;line-height:1.4}
.file-card-size{font-size:11px;color:var(--g400)}

/* ── REVIEW FORM ──────────────────────────────────── */
.review-form{background:var(--white);border:1px solid var(--g200);border-radius:var(--r-md);
    padding:16px 20px;margin-top:16px;display:none}
.review-form.open{display:block}
.review-form textarea{width:100%;padding:10px 12px;border:1px solid var(--g200);
    border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:13px;
    color:var(--g800);resize:vertical;min-height:80px;outline:none;transition:border-color .15s}
.review-form textarea:focus{border-color:var(--navy)}
.review-btns{display:flex;gap:8px;margin-top:12px}

/* ── BUTTONS ─────────────────────────────────────── */
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;
    border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:13px;
    font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:all .15s}
.btn-primary{background:var(--navy);color:#fff}
.btn-primary:hover{background:var(--navy-dk)}
.btn-gold{background:var(--gold);color:#fff}
.btn-outline{background:transparent;border:1px solid var(--g200);color:var(--g600)}
.btn-outline:hover{background:var(--g50)}
.btn-approve{background:#d1fae5;color:#065f46;border:1px solid #6ee7b7}
.btn-approve:hover{background:#a7f3d0}
.btn-reject{background:#fee2e2;color:#dc2626;border:1px solid #fca5a5}
.btn-reject:hover{background:#fecaca}
.btn-sm{padding:6px 12px;font-size:12px}

/* ── SIDEBAR SUMMARY ──────────────────────────────── */
.sidebar-card{background:var(--white);border:1px solid var(--g200);border-radius:var(--r-lg);overflow:hidden;margin-bottom:16px}
.sc-header{padding:14px 18px;border-bottom:1px solid var(--g100);
    font-family:'Cormorant Garamond',serif;font-size:16px;font-weight:600;color:var(--navy)}
.sc-body{padding:16px 18px}
.sc-row{display:flex;justify-content:space-between;align-items:center;
    font-size:13px;padding:7px 0;border-bottom:1px solid var(--g100)}
.sc-row:last-child{border-bottom:none}
.sc-label{color:var(--g400)}
.sc-val{font-weight:500;color:var(--navy)}

/* ── ASSIGNEE CARD ────────────────────────────────── */
.assignee-wrap{display:flex;align-items:center;gap:10px;padding:16px 18px}
.av-avatar{width:42px;height:42px;border-radius:50%;background:var(--navy);
    display:flex;align-items:center;justify-content:center;font-size:14px;
    font-weight:600;color:#fff;flex-shrink:0}
.av-name{font-size:14px;font-weight:500;color:var(--navy)}
.av-meta{font-size:12px;color:var(--g400);margin-top:2px}

/* ── TIMELINE ─────────────────────────────────────── */
.timeline{padding:4px 0}
.tl-item{display:flex;gap:12px;padding:10px 0;position:relative}
.tl-item:not(:last-child)::before{content:'';position:absolute;left:11px;top:28px;bottom:0;width:1px;background:var(--g200)}
.tl-dot{width:22px;height:22px;border-radius:50%;display:flex;align-items:center;
    justify-content:center;flex-shrink:0;margin-top:2px}
.tl-dot.submitted{background:#ede9fe;color:#7c3aed}
.tl-dot.approved {background:#d1fae5;color:#059669}
.tl-dot.rejected {background:#fee2e2;color:#dc2626}
.tl-dot.created  {background:var(--navy-lt);color:var(--navy)}
.tl-text{font-size:12px;color:var(--g600);line-height:1.5}
.tl-text strong{color:var(--navy);font-size:13px}

/* ── EMPTY ───────────────────────────────────────── */
.empty-state{text-align:center;padding:52px 20px;color:var(--g400)}
.empty-state svg{margin-bottom:12px;opacity:.35}
</style>
@endpush

@section('content')

{{-- ── HEADER ───────────────────────────────────────── --}}
<div class="page-header">
    <a href="{{ route('admin.tasks.index') }}" class="back-btn">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div class="header-title">
        <h1>Submissions — {{ $task->title }}</h1>
        <p>Review files and feedback submitted by {{ $task->assignee->full_name }}</p>
    </div>
    <div class="header-meta">
        <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-outline btn-sm">Edit Task</a>
    </div>
</div>

{{-- ── TASK STRIP ───────────────────────────────────── --}}
<div class="task-strip">
    <div class="task-strip-item">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <strong>{{ $task->assignee->full_name }}</strong>
        <span style="font-size:11px;background:var(--navy-lt);color:var(--navy);padding:1px 8px;border-radius:20px">{{ ucfirst($task->assignee->role) }}</span>
    </div>
    <div class="task-strip-item">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Due <strong>{{ $task->deadline?->format('d M Y') ?? '—' }}</strong>
    </div>
    <div class="task-strip-item">
        Status: <span class="badge badge-{{ $task->status }}">{{ ucwords(str_replace('_',' ',$task->status)) }}</span>
    </div>
    <div class="task-strip-item">
        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
        <strong>{{ $task->submissions->count() }}</strong> submission{{ $task->submissions->count() !== 1 ? 's' : '' }}
    </div>
    {{-- Quick status update --}}
    <form method="POST" action="{{ route('admin.tasks.status', $task) }}" style="margin-left:auto;display:flex;gap:8px">
        @csrf @method('PATCH')
        <select name="status" class="filter-select" style="padding:6px 10px;border:1px solid var(--g200);border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:12px;background:var(--g50);outline:none">
            @foreach(['pending','in_progress','under_review','completed','overdue'] as $s)
                <option value="{{ $s }}" {{ $task->status===$s?'selected':'' }}>{{ ucwords(str_replace('_',' ',$s)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
    </form>
</div>

@if(session('success'))
<div style="margin:16px 32px 0;background:#d1fae5;border:1px solid #6ee7b7;border-radius:8px;padding:11px 16px;font-size:13px;color:#065f46;display:flex;align-items:center;gap:8px">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="layout">

    {{-- ── SUBMISSIONS ───────────────────────────── --}}
    <div>

        @if($task->submissions->count())
        @foreach($task->submissions as $i => $sub)
        @php
            $statusClass = match($sub->status) {
                'approved' => 'review-approved',
                'rejected' => 'review-rejected',
                default    => 'review-pending',
            };
        @endphp

        <div class="sub-card {{ $statusClass }}">

            <div class="sub-header">
                <div class="sub-num">{{ str_pad($task->submissions->count() - $i, 2, '0', STR_PAD_LEFT) }}</div>
                <div class="sub-meta">
                    <div class="sub-title">{{ $sub->subject }}</div>
                    <div class="sub-subtitle">
                        <span>{{ $sub->typeLabel() }}</span>
                        <span>·</span>
                        <span>{{ $sub->created_at->format('d M Y, g:i A') }}</span>
                        <span>·</span>
                        <span>{{ $sub->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="sub-actions">
                    <span class="badge badge-{{ $sub->status }}">
                        {{ ucwords(str_replace('_',' ',$sub->status)) }}
                    </span>
                    @if($sub->isPending())
                        <button class="btn btn-approve btn-sm" onclick="toggleReview('approve-{{ $sub->id }}')">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Approve
                        </button>
                        <button class="btn btn-reject btn-sm" onclick="toggleReview('reject-{{ $sub->id }}')">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            Reject
                        </button>
                    @endif
                </div>
            </div>

            <div class="sub-body">

                @if($sub->notes)
                <div class="sub-notes">{{ $sub->notes }}</div>
                @endif

                @if($sub->files->count())
                <div class="files-section">
                    <div class="files-label">Attachments ({{ $sub->files->count() }})</div>
                    <div class="files-grid">
                        @foreach($sub->files as $file)
                        @php
                            $ext = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
                            $fc = match(true) {
                                $ext === 'pdf'                          => 'pdf',
                                in_array($ext, ['doc','docx'])          => 'doc',
                                in_array($ext, ['xls','xlsx'])          => 'xls',
                                in_array($ext, ['jpg','jpeg','png','gif','webp']) => 'img',
                                in_array($ext, ['zip','rar','7z'])      => 'zip',
                                default => 'oth',
                            };
                            $icon = match($fc) {
                                'pdf' => '📄', 'doc' => '📝', 'xls' => '📊',
                                'img' => '🖼', 'zip' => '🗜', default => '📁',
                            };
                        @endphp
                        <a href="{{ route('admin.documents.download', $file) }}"
                           class="file-card" title="Download {{ $file->original_name }}">
                            <div class="file-card-icon {{ $fc }}">{{ $icon }}</div>
                            <div class="file-card-name">{{ Str::limit($file->original_name, 22) }}</div>
                            <div class="file-card-size">{{ $file->humanSize() }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Reviewer feedback (if already reviewed) --}}
                @if($sub->reviewer_notes)
                <div style="margin-top:14px;padding:12px 14px;background:{{ $sub->isApproved() ? '#d1fae5' : '#fee2e2' }};border-radius:var(--r-sm)">
                    <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.7px;color:{{ $sub->isApproved() ? '#065f46' : '#991b1b' }};margin-bottom:6px">
                        Admin Feedback
                    </div>
                    <div style="font-size:13px;color:{{ $sub->isApproved() ? '#065f46' : '#991b1b' }}">{{ $sub->reviewer_notes }}</div>
                </div>
                @endif

                {{-- Inline review forms --}}
                @if($sub->isPending())
                <form method="POST" action="{{ route('admin.tasks.submissions.approve', $sub) }}"
                    class="review-form" id="approve-{{ $sub->id }}">
                    @csrf @method('PATCH')
                    <p style="font-size:13px;font-weight:500;color:#065f46;margin-bottom:10px">
                        ✓ Approve this submission
                    </p>
                    <textarea name="reviewer_notes" placeholder="Optional feedback for the assignee…"></textarea>
                    <div class="review-btns">
                        <button type="submit" class="btn btn-approve">Confirm Approval</button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="toggleReview('approve-{{ $sub->id }}')">Cancel</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('admin.tasks.submissions.reject', $sub) }}"
                    class="review-form" id="reject-{{ $sub->id }}">
                    @csrf @method('PATCH')
                    <p style="font-size:13px;font-weight:500;color:#dc2626;margin-bottom:10px">
                        ✗ Reject this submission
                    </p>
                    <textarea name="reviewer_notes" placeholder="Explain what needs to be revised…" required></textarea>
                    <div class="review-btns">
                        <button type="submit" class="btn btn-reject">Confirm Rejection</button>
                        <button type="button" class="btn btn-outline btn-sm" onclick="toggleReview('reject-{{ $sub->id }}')">Cancel</button>
                    </div>
                </form>
                @endif

            </div>
        </div>
        @endforeach

        @else
        <div class="empty-state">
            <svg width="52" height="52" fill="none" viewBox="0 0 24 24" stroke="#9aa0b8" stroke-width="1.1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <p>No submissions yet for this task.</p>
        </div>
        @endif

    </div>

    {{-- ── SIDEBAR ─────────────────────────────────── --}}
    <div>

        {{-- Summary --}}
        <div class="sidebar-card">
            <div class="sc-header">Task Summary</div>
            <div class="sc-body">
                <div class="sc-row"><span class="sc-label">Total Submissions</span><span class="sc-val">{{ $task->submissions->count() }}</span></div>
                <div class="sc-row"><span class="sc-label">Pending Review</span>
                    <span class="sc-val" style="color:#7c3aed">{{ $task->submissions->where('status','under_review')->count() }}</span></div>
                <div class="sc-row"><span class="sc-label">Approved</span>
                    <span class="sc-val" style="color:#065f46">{{ $task->submissions->where('status','approved')->count() }}</span></div>
                <div class="sc-row"><span class="sc-label">Rejected</span>
                    <span class="sc-val" style="color:#dc2626">{{ $task->submissions->where('status','rejected')->count() }}</span></div>
                <div class="sc-row"><span class="sc-label">Total Files</span>
                    <span class="sc-val">{{ $task->files->count() + $task->submissions->sum(fn($s) => $s->files->count()) }}</span></div>
            </div>
        </div>

        {{-- Assignee --}}
        <div class="sidebar-card">
            <div class="sc-header">Assignee</div>
            <div class="assignee-wrap">
                <div class="av-avatar">
                    {{ strtoupper(substr($task->assignee->first_name,0,1).substr($task->assignee->last_name,0,1)) }}
                </div>
                <div>
                    <div class="av-name">{{ $task->assignee->full_name }}</div>
                    <div class="av-meta">{{ ucfirst($task->assignee->role) }}</div>
                    <div class="av-meta">{{ $task->assignee->email }}</div>
                </div>
            </div>
        </div>

        {{-- Activity Timeline --}}
        <div class="sidebar-card">
            <div class="sc-header">Timeline</div>
            <div class="sc-body">
                <div class="timeline">

                    <div class="tl-item">
                        <div class="tl-dot created">
                            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div class="tl-text">
                            <strong>Task Created</strong><br>
                            {{ $task->created_at->format('d M Y') }} by {{ $task->assignedBy?->full_name ?? 'Admin' }}
                        </div>
                    </div>

                    @foreach($task->submissions->sortBy('created_at') as $sub)
                    <div class="tl-item">
                        <div class="tl-dot submitted">
                            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <div class="tl-text">
                            <strong>Submission: {{ Str::limit($sub->subject,30) }}</strong><br>
                            {{ $sub->created_at->format('d M Y, g:i A') }}
                            @if($sub->files->count()) · {{ $sub->files->count() }} file{{ $sub->files->count()>1?'s':'' }} @endif
                        </div>
                    </div>

                    @if($sub->status !== 'under_review')
                    <div class="tl-item">
                        <div class="tl-dot {{ $sub->status }}">
                            @if($sub->isApproved())
                            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            @else
                            <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            @endif
                        </div>
                        <div class="tl-text">
                            <strong>{{ $sub->isApproved() ? 'Approved' : 'Rejected' }}</strong><br>
                            {{ $sub->updated_at->format('d M Y') }}
                        </div>
                    </div>
                    @endif
                    @endforeach

                </div>
            </div>
        </div>

        {{-- Admin Files for this task --}}
        @if($task->files->count())
        <div class="sidebar-card">
            <div class="sc-header">Task Reference Files</div>
            <div class="sc-body" style="padding-top:10px">
                @foreach($task->files as $f)
                <a href="{{ route('admin.documents.download', $f) }}"
                   style="display:flex;align-items:center;gap:8px;padding:8px 0;border-bottom:1px solid var(--g100);text-decoration:none;color:var(--navy);font-size:12px">
                    <svg width="14" height="14" fill="#9aa0b8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm0 2l4 4h-4V4z"/></svg>
                    <span style="flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $f->original_name }}</span>
                    <span style="color:var(--g400);font-size:11px;flex-shrink:0">{{ $f->humanSize() }}</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleReview(id) {
    document.querySelectorAll('.review-form').forEach(f => {
        if (f.id !== id) f.classList.remove('open');
    });
    document.getElementById(id)?.classList.toggle('open');
}
</script>
@endpush
