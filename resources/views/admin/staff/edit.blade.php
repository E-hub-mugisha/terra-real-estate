@extends('layouts.app')
@section('title', 'Edit Staff — ' . ($staff->user?->name ?? 'Staff Member'))
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
        --blue:     #3b82f6;
    }

    .se-page { padding: 1.75rem 0 3rem; max-width: 1060px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .se-breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: var(--muted); margin-bottom: 1.5rem; }
    .se-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
    .se-breadcrumb a:hover { color: var(--accent); }

    /* ── Heading ── */
    .se-heading { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; }
    .se-heading-avatar {
        width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 1rem; color: #fff;
        border: 2px solid rgba(201,169,110,.3);
    }
    .se-heading h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .se-heading p  { font-size: .82rem; color: var(--text-dim); margin: .15rem 0 0; }
    .se-heading-meta { margin-left: auto; display: flex; align-items: center; gap: .6rem; }

    /* ── Status badge ── */
    .se-status {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .24rem .7rem; border-radius: 100px; font-size: .7rem; font-weight: 600; border: 1px solid;
    }
    .se-status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .se-status.active     { color: #166534; border-color: #bbf7d0; background: #f0fdf4; }
    .se-status.inactive   { color: #92400e; border-color: #fde68a; background: #fffbeb; }
    .se-status.on_leave   { color: #1d4ed8; border-color: #bfdbfe; background: #eff6ff; }
    .se-status.terminated { color: #991b1b; border-color: #fecaca; background: #fef2f2; }

    /* ── Layout ── */
    .se-layout { display: grid; grid-template-columns: 1fr 280px; gap: 1.25rem; align-items: start; }
    .se-main { display: flex; flex-direction: column; gap: 1.25rem; }
    .se-side { display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: 80px; }

    /* ── Card ── */
    .se-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .se-card-header {
        display: flex; align-items: center; gap: .75rem;
        padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }
    .se-card-header-icon {
        width: 32px; height: 32px; border-radius: 8px; background: #c9a96e18;
        display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;
    }
    .se-card-header h6 { margin: 0; font-size: .88rem; font-weight: 600; color: var(--text); }
    .se-card-body { padding: 1.5rem; }

    /* ── Section divider ── */
    .se-section-title {
        font-size: .72rem; font-weight: 700; letter-spacing: .1em;
        text-transform: uppercase; color: var(--muted);
        padding: .8rem 0 .5rem; margin-top: .25rem;
    }
    .se-section-divider { height: 1px; background: var(--border); margin-bottom: 1.1rem; }

    /* ── Form controls ── */
    .se-label {
        display: block; font-size: .77rem; font-weight: 600; letter-spacing: .03em;
        color: var(--text-dim); text-transform: uppercase; margin-bottom: .45rem;
    }
    .se-label .req { color: var(--danger); margin-left: .2rem; }
    .se-input, .se-select, .se-textarea {
        width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .875rem; color: var(--text); background: #fff; outline: none; font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }
    .se-input:focus, .se-select:focus, .se-textarea:focus { border-color: var(--accent); box-shadow: 0 0 0 3px #c9a96e18; }
    .se-input.is-invalid, .se-select.is-invalid, .se-textarea.is-invalid { border-color: var(--danger); }
    .se-input:disabled, .se-select:disabled { background: var(--surface); color: var(--muted); cursor: not-allowed; }
    .se-textarea { resize: vertical; line-height: 1.65; }
    .se-hint  { font-size: .73rem; color: var(--muted); margin-top: .35rem; }
    .se-error { font-size: .73rem; color: var(--danger); margin-top: .35rem; display: flex; align-items: center; gap: .3rem; }

    /* ── Grid helpers ── */
    .se-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .se-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
    .se-gap   { display: flex; flex-direction: column; gap: 1rem; }

    /* ── Status selector ── */
    .se-status-grid { display: grid; grid-template-columns: repeat(2,1fr); gap: .5rem; }
    .se-status-radio { display: none; }
    .se-status-label {
        display: flex; align-items: center; gap: .5rem; padding: .6rem .85rem;
        border: 1.5px solid var(--border); border-radius: 8px; font-size: .8rem;
        color: var(--text-dim); cursor: pointer; transition: all .15s; user-select: none; font-weight: 500;
    }
    .se-status-dot-sm { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .se-status-radio[value="active"]:checked     + .se-status-label { border-color: #22c55e; background: #f0fdf4; color: #166534; }
    .se-status-radio[value="inactive"]:checked   + .se-status-label { border-color: #f59e0b; background: #fffbeb; color: #92400e; }
    .se-status-radio[value="on_leave"]:checked   + .se-status-label { border-color: #3b82f6; background: #eff6ff; color: #1d4ed8; }
    .se-status-radio[value="terminated"]:checked + .se-status-label { border-color: var(--danger); background: #fef2f2; color: #991b1b; }

    /* ── Profile preview (sidebar) ── */
    .se-profile-preview {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden;
    }
    .se-preview-banner {
        height: 56px;
        background: linear-gradient(135deg, #c9a96e22, #e4c99014);
        border-bottom: 1px solid var(--border);
    }
    .se-preview-body { padding: 0 1.25rem 1.25rem; }
    .se-preview-avatar-wrap { margin-top: -20px; margin-bottom: .65rem; }
    .se-preview-avatar {
        width: 42px; height: 42px; border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent-lt));
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .85rem; color: #fff;
        border: 2px solid #fff; box-shadow: 0 2px 6px rgba(0,0,0,.1);
    }
    .se-preview-name  { font-size: .9rem; font-weight: 700; color: var(--text); margin: 0 0 .15rem; }
    .se-preview-email { font-size: .76rem; color: var(--muted); word-break: break-all; }

    /* ── Password reset card (sidebar) ── */
    .se-reset-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }

    /* ── Alerts ── */
    .se-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: flex-start; margin-bottom: 1.25rem; }
    .se-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
    .se-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .se-alert ul { margin: .35rem 0 0 1rem; padding: 0; }
    .se-alert li { margin-bottom: .2rem; }

    /* ── Submit bar ── */
    .se-submit-bar {
        display: flex; align-items: center; justify-content: space-between; gap: .75rem;
        padding: 1.1rem 1.5rem; background: #fff;
        border: 1px solid var(--border); border-radius: var(--radius);
    }
    .se-submit-bar-left { font-size: .78rem; color: var(--muted); display: flex; align-items: center; gap: .4rem; }
    .se-submit-bar-right { display: flex; gap: .6rem; }

    /* ── Buttons ── */
    .se-btn {
        display: inline-flex; align-items: center; gap: .45rem; padding: .65rem 1.4rem;
        border-radius: 8px; font-size: .85rem; font-weight: 600; border: none;
        cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .se-btn-primary       { background: var(--accent); color: #fff; }
    .se-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }
    .se-btn-ghost         { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .se-btn-ghost:hover   { border-color: var(--accent); color: var(--accent); }
    .se-btn-blue          { background: none; border: 1.5px solid #bfdbfe; color: var(--blue); }
    .se-btn-blue:hover    { background: #eff6ff; }
    .se-btn-sm { padding: .42rem .9rem; font-size: .78rem; }

    @media (max-width: 880px) {
        .se-layout { grid-template-columns: 1fr; }
        .se-side { position: static; }
        .se-row-2, .se-row-3 { grid-template-columns: 1fr; }
    }
    @media (max-width: 500px) {
        .se-status-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="se-page">

    {{-- ── Breadcrumb ── --}}
    <nav class="se-breadcrumb">
        <a href="{{ route('admin.staff.index') }}">Staff</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('admin.staff.show', $staff->id) }}">{{ $staff->user?->name ?? 'Staff Member' }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Edit</span>
    </nav>

    {{-- ── Heading ── --}}
    <div class="se-heading">
        <div class="se-heading-avatar" id="previewAvatar">
            {{ strtoupper(substr($staff->user?->name ?? 'ST', 0, 2)) }}
        </div>
        <div>
            <h4>Edit Staff Member</h4>
            <p>{{ $staff->user?->name ?? '—' }} &mdash; last updated {{ $staff->updated_at->diffForHumans() }}</p>
        </div>
        <div class="se-heading-meta">
            @php
                $sc = match($staff->status) {
                    'active'     => 'active',
                    'inactive'   => 'inactive',
                    'on_leave'   => 'on_leave',
                    'terminated' => 'terminated',
                    default      => 'inactive',
                };
                $sl = match($staff->status) {
                    'active'     => 'Active',
                    'inactive'   => 'Inactive',
                    'on_leave'   => 'On Leave',
                    'terminated' => 'Terminated',
                    default      => ucfirst($staff->status),
                };
            @endphp
            <span class="se-status {{ $sc }}">
                <span class="se-status-dot"></span>{{ $sl }}
            </span>
            <a href="{{ route('admin.staff.show', $staff->id) }}" class="se-btn se-btn-ghost se-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View Profile
            </a>
        </div>
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

    <form method="POST"
          action="{{ route('admin.staff.update', $staff->id) }}">
        @csrf
        @method('PUT')

        <div class="se-layout">

            {{-- ══ MAIN ══ --}}
            <div class="se-main">

                {{-- ── Account Details ── --}}
                <div class="se-card">
                    <div class="se-card-header">
                        <div class="se-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        </div>
                        <h6>Account Details</h6>
                    </div>
                    <div class="se-card-body">
                        <div class="se-row-2">

                            {{-- Full name --}}
                            <div>
                                <label class="se-label">Full Name <span class="req">*</span></label>
                                <input type="text" name="name" id="nameInput"
                                       class="se-input @error('name') is-invalid @enderror"
                                       value="{{ old('name', $staff->user?->name) }}"
                                       oninput="updatePreview()"
                                       placeholder="e.g. John Mukasa" required>
                                @error('name')<p class="se-error">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                                    {{ $message }}</p>@enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="se-label">Email Address <span class="req">*</span></label>
                                <input type="email" name="email" id="emailInput"
                                       class="se-input @error('email') is-invalid @enderror"
                                       value="{{ old('email', $staff->user?->email) }}"
                                       oninput="updatePreview()"
                                       placeholder="john@company.com" required>
                                <p class="se-hint">Changing this also updates the login email.</p>
                                @error('email')<p class="se-error">{{ $message }}</p>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Staff Details ── --}}
                <div class="se-card">
                    <div class="se-card-header">
                        <div class="se-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <h6>Staff Details</h6>
                    </div>
                    <div class="se-card-body">
                        <div class="se-gap">

                            <div class="se-row-2">
                                {{-- Department --}}
                                <div>
                                    <label class="se-label">Department</label>
                                    <select name="department_id"
                                            class="se-select @error('department_id') is-invalid @enderror">
                                        <option value="">Select department</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}"
                                                {{ old('department_id', $staff->department_id) == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('department_id')<p class="se-error">{{ $message }}</p>@enderror
                                </div>

                                {{-- Employee ID --}}
                                <div>
                                    <label class="se-label">Employee ID</label>
                                    <input type="text" name="employee_id"
                                           class="se-input @error('employee_id') is-invalid @enderror"
                                           value="{{ old('employee_id', $staff->employee_id) }}"
                                           placeholder="e.g. EMP-001">
                                    @error('employee_id')<p class="se-error">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="se-row-2">
                                {{-- Position --}}
                                <div>
                                    <label class="se-label">Position</label>
                                    <input type="text" name="position"
                                           class="se-input @error('position') is-invalid @enderror"
                                           value="{{ old('position', $staff->position) }}"
                                           placeholder="e.g. Sales Agent">
                                    @error('position')<p class="se-error">{{ $message }}</p>@enderror
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label class="se-label">Phone</label>
                                    <input type="text" name="phone"
                                           class="se-input @error('phone') is-invalid @enderror"
                                           value="{{ old('phone', $staff->phone) }}"
                                           placeholder="+250 7XX XXX XXX">
                                    @error('phone')<p class="se-error">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            {{-- Joined date --}}
                            <div>
                                <label class="se-label">Joined Date</label>
                                <input type="date" name="joined_at"
                                       class="se-input @error('joined_at') is-invalid @enderror"
                                       value="{{ old('joined_at', $staff->joined_at?->format('Y-m-d')) }}">
                                @error('joined_at')<p class="se-error">{{ $message }}</p>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── Status ── --}}
                <div class="se-card">
                    <div class="se-card-header">
                        <div class="se-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                        <h6>Employment Status</h6>
                    </div>
                    <div class="se-card-body">
                        <div class="se-status-grid">
                            @foreach([
                                'active'     => ['label' => 'Active',     'color' => '#22c55e'],
                                'inactive'   => ['label' => 'Inactive',   'color' => '#f59e0b'],
                                'on_leave'   => ['label' => 'On Leave',   'color' => '#3b82f6'],
                                'terminated' => ['label' => 'Terminated', 'color' => '#ef4444'],
                            ] as $val => $meta)
                                <input type="radio" name="status" id="status_{{ $val }}"
                                       value="{{ $val }}" class="se-status-radio"
                                       {{ old('status', $staff->status) === $val ? 'checked' : '' }} required>
                                <label for="status_{{ $val }}" class="se-status-label">
                                    <span class="se-status-dot-sm" style="background:{{ $meta['color'] }}"></span>
                                    {{ $meta['label'] }}
                                </label>
                            @endforeach
                        </div>
                        @error('status')<p class="se-error" style="margin-top:.6rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Notes ── --}}
                <div class="se-card">
                    <div class="se-card-header">
                        <div class="se-card-header-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                        </div>
                        <h6>Internal Notes</h6>
                    </div>
                    <div class="se-card-body">
                        <textarea name="notes" rows="4"
                                  class="se-textarea @error('notes') is-invalid @enderror"
                                  placeholder="Optional internal notes about this staff member…">{{ old('notes', $staff->notes) }}</textarea>
                        @error('notes')<p class="se-error">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Submit bar ── --}}
                <div class="se-submit-bar">
                    <div class="se-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $staff->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="se-submit-bar-right">
                        <a href="{{ route('admin.staff.show', $staff->id) }}" class="se-btn se-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="se-btn se-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>

            </div>{{-- /.se-main --}}

            {{-- ══ SIDEBAR ══ --}}
            <div class="se-side">

                {{-- ── Live preview ── --}}
                <div class="se-profile-preview">
                    <div class="se-preview-banner"></div>
                    <div class="se-preview-body">
                        <div class="se-preview-avatar-wrap">
                            <div class="se-preview-avatar" id="sideAvatar">
                                {{ strtoupper(substr($staff->user?->name ?? 'ST', 0, 2)) }}
                            </div>
                        </div>
                        <p class="se-preview-name" id="previewName">{{ $staff->user?->name ?? '—' }}</p>
                        <p class="se-preview-email" id="previewEmail">{{ $staff->user?->email ?? '' }}</p>
                    </div>
                </div>

                {{-- ── Reset password ── --}}
                <div class="se-reset-card">
                    <div class="se-card-header">
                        <div class="se-card-header-icon" style="background:#eff6ff;color:var(--blue)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h6>Password</h6>
                    </div>
                    <div class="se-card-body">
                        <p style="font-size:.81rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">
                            Generate a new secure password and email it to this staff member.
                        </p>
                        <form method="POST" action="{{ route('admin.staff.reset-password', $staff->id) }}">
                            @csrf
                            <button type="submit" class="se-btn se-btn-blue"
                                    style="width:100%;justify-content:center;"
                                    onclick="return confirm('Reset password and send credentials to {{ $staff->user?->email }}?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                Reset &amp; Email Password
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ── Danger zone ── --}}
                <div class="se-card" style="border-color:#fecaca;">
                    <div class="se-card-header" style="background:#fef2f2;border-color:#fecaca;">
                        <div class="se-card-header-icon" style="background:#fee2e2;color:var(--danger);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                        </div>
                        <h6 style="color:var(--danger)">Danger Zone</h6>
                    </div>
                    <div class="se-card-body">
                        <p style="font-size:.8rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">
                            Permanently removes this staff member and their login account.
                        </p>
                        <form method="POST" action="{{ route('admin.staff.destroy', $staff->id) }}"
                              onsubmit="return confirm('Delete {{ $staff->user?->name }} and their account? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="se-btn"
                                    style="width:100%;justify-content:center;background:none;border:1.5px solid #fecaca;color:var(--danger);font-size:.82rem;padding:.55rem 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                Remove Staff Member
                            </button>
                        </form>
                    </div>
                </div>

            </div>{{-- /.se-side --}}

        </div>{{-- /.se-layout --}}
    </form>
</div>

<script>
function updatePreview() {
    const name  = document.getElementById('nameInput').value;
    const email = document.getElementById('emailInput').value;

    const initials = name.trim().split(/\s+/).map(w => w[0]?.toUpperCase() ?? '').slice(0, 2).join('') || 'ST';
    document.getElementById('previewAvatar').textContent = initials;
    document.getElementById('sideAvatar').textContent    = initials;
    document.getElementById('previewName').textContent   = name  || '—';
    document.getElementById('previewEmail').textContent  = email || '';
}
</script>

@endsection