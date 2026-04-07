@extends('layouts.app')
@section('title', $task->title)
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600&family=Geist+Mono:wght@400&display=swap');

    .ts-root {
        font-family: 'Syne', sans-serif;
        padding: 2rem 0;
    }

    .ts-crumb {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 2rem;
        font-size: 12px;
        color: #6b7280;
    }

    .ts-crumb a {
        color: #6b7280;
        text-decoration: none;
    }

    .ts-crumb a:hover {
        color: #111;
    }

    .ts-hero {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .ts-title {
        font-size: 26px;
        font-weight: 600;
        line-height: 1.25;
        margin-bottom: .5rem;
        letter-spacing: -.3px;
    }

    .ts-meta-inline {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .ts-actions {
        display: flex;
        gap: 8px;
        flex-shrink: 0;
    }

    .ts-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        border: 1px solid #d1d5db;
        background: #fff;
        color: #111;
        cursor: pointer;
        font-family: 'Syne', sans-serif;
        text-decoration: none;
        transition: background .15s;
    }

    .ts-btn:hover {
        background: #f9fafb;
        color: #111;
    }

    .ts-btn-dark {
        background: #111;
        color: #fff;
        border-color: transparent;
    }

    .ts-btn-dark:hover {
        background: #222;
        color: #fff;
        opacity: 1;
    }

    .ts-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
        font-family: 'Syne', sans-serif;
        letter-spacing: .02em;
    }

    .ts-badge .dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
        display: inline-block;
    }

    .b-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .b-inprog {
        background: #dbeafe;
        color: #1e40af;
    }

    .b-review {
        background: #ede9fe;
        color: #5b21b6;
    }

    .b-completed {
        background: #dcfce7;
        color: #166534;
    }

    .b-overdue {
        background: #fee2e2;
        color: #991b1b;
    }

    .b-high {
        background: #fee2e2;
        color: #991b1b;
    }

    .b-medium {
        background: #fef3c7;
        color: #92400e;
    }

    .b-low {
        background: #dcfce7;
        color: #166534;
    }

    .b-cat {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #e5e7eb;
    }

    .ts-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }

    .ts-col {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .ts-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
    }

    .ts-card-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #9ca3af;
        margin-bottom: .9rem;
        font-weight: 500;
    }

    .ts-divider {
        border: none;
        border-top: 1px solid #f3f4f6;
        margin: .9rem 0;
    }

    .ts-text-block {
        font-size: 14px;
        line-height: 1.75;
        color: #4b5563;
        background: #f9fafb;
        border-radius: 8px;
        padding: 12px 14px;
    }

    .ts-note-block {
        font-size: 14px;
        line-height: 1.75;
        color: #4b5563;
        background: #f9fafb;
        border-radius: 0 8px 8px 0;
        border-left: 3px solid #1e40af;
        padding: 12px 14px;
    }

    .ts-empty {
        font-size: 13px;
        color: #9ca3af;
        font-style: italic;
    }

    .ts-file-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 6px;
        background: #fff;
    }

    .ts-file-row:last-child {
        margin-bottom: 0;
    }

    .ts-file-icon {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 600;
        flex-shrink: 0;
        font-family: 'Geist Mono', monospace;
    }

    .ts-file-name {
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        flex: 1;
        min-width: 0;
        color: #111;
    }

    .ts-file-size {
        font-size: 11px;
        color: #9ca3af;
    }

    .ts-dl-link {
        font-size: 12px;
        color: #1e40af;
        text-decoration: none;
        flex-shrink: 0;
        font-weight: 500;
    }

    .ts-dl-link:hover {
        text-decoration: underline;
    }

    .ts-person-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ts-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        flex-shrink: 0;
        font-family: 'Syne', sans-serif;
    }

    .ts-person-name {
        font-size: 14px;
        font-weight: 500;
        color: #111;
    }

    .ts-person-role {
        font-size: 12px;
        color: #9ca3af;
    }

    .ts-detail-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #9ca3af;
        font-weight: 500;
        margin-bottom: 3px;
    }

    .ts-detail-value {
        font-size: 14px;
        font-weight: 500;
        color: #111;
    }

    .ts-progress-bg {
        height: 3px;
        background: #f3f4f6;
        border-radius: 3px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .ts-progress-fill {
        height: 100%;
        border-radius: 3px;
        background: #1e40af;
    }

    .ts-tl-item {
        display: flex;
        gap: 10px;
        align-items: flex-start;
    }

    .ts-tl-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 5px;
        background: #d1d5db;
    }

    .ts-tl-text {
        font-size: 13px;
        line-height: 1.4;
        color: #374151;
    }

    .ts-tl-date {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 2px;
    }

    .ts-deadline-urgent {
        color: #991b1b !important;
    }

    .ts-deadline-ok {
        color: #166534 !important;
    }

    .ts-days-pill {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: 4px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .ts-layout {
            grid-template-columns: 1fr;
        }

        .ts-hero {
            flex-direction: column;
        }

        .ts-actions {
            width: 100%;
        }

        .ts-btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>


<div class="container ts-root">

    {{-- Breadcrumb --}}
    <div class="ts-crumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M4.5 2.5L7.5 6l-3 3.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <a href="{{ route('admin.tasks.index') }}">Tasks</a>
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M4.5 2.5L7.5 6l-3 3.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <span>{{ Str::limit($task->title, 40) }}</span>
    </div>

    {{-- Hero --}}
    <div class="ts-hero">
        <div style="flex:1;min-width:220px">
            <div class="ts-meta-inline">
                {{-- Status badge --}}
                @php
                $statusClass = match($task->status) {
                'pending' => 'b-pending',
                'in_progress' => 'b-inprog',
                'under_review' => 'b-review',
                'completed' => 'b-completed',
                'overdue' => 'b-overdue',
                default => 'b-pending',
                };
                $statusDotColor = match($task->status) {
                'pending' => '#92400e',
                'in_progress' => '#1e40af',
                'under_review' => '#5b21b6',
                'completed' => '#166534',
                'overdue' => '#991b1b',
                default => '#92400e',
                };
                $priorityClass = match($task->priority) {
                'high' => 'b-high',
                'medium' => 'b-medium',
                'low' => 'b-low',
                default => 'b-low',
                };
                @endphp
                <span class="ts-badge {{ $statusClass }}">
                    <span class="dot" style="background:{{ $statusDotColor }}"></span>
                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                </span>
                <span class="ts-badge {{ $priorityClass }}">{{ ucfirst($task->priority) }} priority</span>
                @if($task->category)
                <span class="ts-badge b-cat">{{ $task->category }}</span>
                @endif
                @if($task->id)
                <span style="font-size:11px;color:#9ca3af;font-family:'Geist Mono',monospace">#TK-{{ str_pad($task->id, 3, '0', STR_PAD_LEFT) }}</span>
                @endif
            </div>
            <h1 class="ts-title">{{ $task->title }}</h1>
            <p style="font-size:13px;color:#9ca3af;margin-top:6px">
                Created {{ $task->created_at->format('M d, Y') }}
                by <strong style="font-weight:500;color:#6b7280">{{ $task->assignedBy->name }}</strong>
            </p>
        </div>
        <div class="ts-actions">
            <a href="{{ route('admin.tasks.edit', $task) }}" class="ts-btn">
                <svg width="13" height="13" viewBox="0 0 14 14" fill="none">
                    <path d="M10 2l2 2-7 7H3v-2L10 2z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round" />
                </svg>
                Edit task
            </a>
            @if($task->status !== \App\Models\TerraTask::STATUS_COMPLETED)
            <form method="POST" action="{{ route('admin.tasks.complete', $task) }}" style="display:inline">
                @csrf @method('PATCH')
                <button type="submit" class="ts-btn ts-btn-dark">Mark complete</button>
            </form>
            @endif
        </div>
    </div>

    {{-- Two-column layout --}}
    <div class="ts-layout">

        {{-- LEFT COLUMN --}}
        <div class="ts-col">

            {{-- Description --}}
            @if($task->description)
            <div class="ts-card">
                <div class="ts-card-label">Description</div>
                <div class="ts-text-block">{{ $task->description }}</div>
            </div>
            @endif

            {{-- Admin notes --}}
            @if($task->admin_notes)
            <div class="ts-card">
                <div class="ts-card-label">Admin notes</div>
                <div class="ts-note-block">{{ $task->admin_notes }}</div>
            </div>
            @endif

            {{-- Attachments --}}
            @if($task->files && $task->files->count())
            <div class="ts-card">
                <div class="ts-card-label">Attachments <span style="font-size:10px;opacity:.6;font-weight:400">({{ $task->files->count() }} {{ Str::plural('file', $task->files->count()) }})</span></div>
                @foreach($task->files as $file)
                @php
                $ext = strtoupper(pathinfo($file->original_name ?? $file->path, PATHINFO_EXTENSION));
                [$iconBg, $iconColor] = match(true) {
                in_array($ext, ['PDF']) => ['#fee2e2', '#991b1b'],
                in_array($ext, ['XLS','XLSX','CSV']) => ['#dbeafe', '#1e40af'],
                in_array($ext, ['DOC','DOCX']) => ['#ede9fe', '#5b21b6'],
                in_array($ext, ['ZIP','RAR']) => ['#fef3c7', '#92400e'],
                in_array($ext, ['PNG','JPG','JPEG','GIF','WEBP']) => ['#dcfce7', '#166534'],
                default => ['#f3f4f6', '#374151'],
                };
                @endphp
                <div class="ts-file-row">
                    <div class="ts-file-icon" style="background:{{ $iconBg }};color:{{ $iconColor }}">{{ $ext ?: 'FILE' }}</div>
                    <div style="flex:1;min-width:0">
                        <div class="ts-file-name">{{ $file->original_name ?? basename($file->path) }}</div>
                        @if($file->size)
                        <div class="ts-file-size">{{ number_format($file->size / 1024, 0) }} KB</div>
                        @endif
                    </div>
                    <a href="{{ Storage::url($file->path) }}" target="_blank" class="ts-dl-link">Download</a>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Submissions --}}
            @if($task->submissions && $task->submissions->count())
            <div class="ts-card">
                <div class="ts-card-label">Submissions <span style="font-size:10px;opacity:.6;font-weight:400">({{ $task->submissions->count() }})</span></div>
                @foreach($task->submissions->take(3) as $sub)
                <div style="padding:10px 0;border-bottom:1px solid #f3f4f6">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                        <span style="font-size:13px;font-weight:500">{{ ucfirst($sub->status ?? 'Submitted') }}</span>
                        <span style="font-size:11px;color:#9ca3af">{{ $sub->created_at->format('M d, Y') }}</span>
                    </div>
                    @if($sub->notes)
                    <p style="font-size:13px;color:#6b7280;line-height:1.5;margin:0">{{ Str::limit($sub->notes, 120) }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @endif

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="ts-col">

            {{-- People --}}
            <div class="ts-card">
                <div class="ts-card-label">People</div>
                @php
                $assigneeName = $task->assignee->name;
                $assigneeInitials = collect(explode(' ', $assigneeName))->map(fn($w) => strtoupper($w[0]))->take(2)->join('');
                $assignerName = $task->assignedBy->name;
                $assignerInitials = collect(explode(' ', $assignerName))->map(fn($w) => strtoupper($w[0]))->take(2)->join('');
                @endphp
                <div class="ts-person-row">
                    <div class="ts-avatar" style="background:#ede9fe;color:#5b21b6">{{ $assigneeInitials }}</div>
                    <div>
                        <div class="ts-person-name">{{ $assigneeName }}</div>
                        <div class="ts-person-role">Assigned to</div>
                    </div>
                </div>
                <hr class="ts-divider">
                <div class="ts-person-row">
                    <div class="ts-avatar" style="background:#d1fae5;color:#065f46">{{ $assignerInitials }}</div>
                    <div>
                        <div class="ts-person-name">{{ $assignerName }}</div>
                        <div class="ts-person-role">Assigned by</div>
                    </div>
                </div>
            </div>

            {{-- Details --}}
            <div class="ts-card">
                <div class="ts-card-label">Details</div>
                <div style="display:flex;flex-direction:column;gap:14px">

                    {{-- Deadline --}}
                    <div>
                        <div class="ts-detail-label">Deadline</div>
                        @php
                        $days = $task->daysUntilDeadline();
                        $deadlineClass = ($days !== null && $days <= 3) ? 'ts-deadline-urgent' : 'ts-deadline-ok' ;
                            $pillBg=($days !==null && $days <=3) ? '#fee2e2' : '#dcfce7' ;
                            $pillClr=($days !==null && $days <=3) ? '#991b1b' : '#166534' ;
                            $pillTxt=$days !==null
                            ? ($days < 0 ? abs($days).'d overdue' : ($days===0 ? 'Due today' : $days.'d left'))
                            : '' ;
                            @endphp
                            <div class="ts-detail-value {{ $deadlineClass }}">
                            {{ $task->deadline->format('M d, Y') }}
                            @if($pillTxt)
                            <span class="ts-days-pill" style="background:{{ $pillBg }};color:{{ $pillClr }}">{{ $pillTxt }}</span>
                            @endif
                    </div>
                </div>

                <hr class="ts-divider" style="margin:0">

                {{-- Status --}}
                <div>
                    <div class="ts-detail-label">Status</div>
                    <span class="ts-badge {{ $statusClass }}" style="margin-top:2px">
                        <span class="dot" style="background:{{ $statusDotColor }}"></span>
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>

                <hr class="ts-divider" style="margin:0">

                {{-- Priority --}}
                <div>
                    <div class="ts-detail-label">Priority</div>
                    <span class="ts-badge {{ $priorityClass }}" style="margin-top:2px">{{ ucfirst($task->priority) }}</span>
                </div>

                @if($task->category)
                <hr class="ts-divider" style="margin:0">
                <div>
                    <div class="ts-detail-label">Category</div>
                    <span class="ts-badge b-cat" style="margin-top:2px">{{ $task->category }}</span>
                </div>
                @endif

            </div>
        </div>

        {{-- Activity --}}
        <div class="ts-card">
            <div class="ts-card-label">Activity</div>
            <div style="display:flex;flex-direction:column;gap:12px">
                @if($task->latestSubmission)
                <div class="ts-tl-item">
                    <div class="ts-tl-dot" style="background:#1e40af"></div>
                    <div>
                        <div class="ts-tl-text">New submission added</div>
                        <div class="ts-tl-date">{{ $task->latestSubmission->created_at->format('M d, Y') }} · {{ $task->assignee->name }}</div>
                    </div>
                </div>
                @endif
                @if($task->files->count())
                <div class="ts-tl-item">
                    <div class="ts-tl-dot"></div>
                    <div>
                        <div class="ts-tl-text">{{ $task->files->count() }} {{ Str::plural('file', $task->files->count()) }} attached</div>
                        <div class="ts-tl-date">{{ $task->updated_at->format('M d, Y') }}</div>
                    </div>
                </div>
                @endif
                <div class="ts-tl-item">
                    <div class="ts-tl-dot"></div>
                    <div>
                        <div class="ts-tl-text">Task created and assigned to <strong style="font-weight:500">{{ $task->assignee->name }}</strong></div>
                        <div class="ts-tl-date">{{ $task->created_at->format('M d, Y') }} · {{ $task->assignedBy->name }}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</div>
@endsection