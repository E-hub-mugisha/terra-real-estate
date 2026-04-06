@extends('layouts.app')

@section('title', ($task->exists ? 'Edit Task' : 'Assign New Task') . ' — Terra Admin')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root{
    --navy:#19265d;--navy-dk:#111a42;--navy-lt:#f0f2f8;
    --gold:#D05208;--gold-lt:#fdf3ec;
    --white:#fff;--g50:#f8f9fb;--g100:#f0f1f5;--g200:#e0e3ed;
    --g400:#9aa0b8;--g600:#5a6082;--g800:#2d3258;
    --r-sm:6px;--r-md:10px;--r-lg:16px;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'DM Sans',sans-serif;background:var(--g50);color:var(--g800)}

.page-header{background:var(--white);border-bottom:1px solid var(--g200);
    padding:22px 32px;display:flex;align-items:center;gap:14px}
.back-btn{width:34px;height:34px;border-radius:var(--r-sm);border:1px solid var(--g200);
    background:transparent;display:flex;align-items:center;justify-content:center;
    cursor:pointer;color:var(--g600);text-decoration:none;transition:all .15s}
.back-btn:hover{background:var(--g100)}
.page-header h1{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:var(--navy)}
.page-header p{font-size:13px;color:var(--g400);margin-top:2px}

.form-layout{display:grid;grid-template-columns:1fr 320px;gap:24px;padding:28px 32px;align-items:start}

/* ── CARDS ───────────────────────────────────────── */
.card{background:var(--white);border:1px solid var(--g200);border-radius:var(--r-lg);overflow:hidden}
.card-header{padding:18px 24px;border-bottom:1px solid var(--g100);display:flex;align-items:center;gap:10px}
.card-header-icon{width:34px;height:34px;border-radius:var(--r-sm);background:var(--navy-lt);
    display:flex;align-items:center;justify-content:center;flex-shrink:0}
.card-title{font-family:'Cormorant Garamond',serif;font-size:17px;font-weight:600;color:var(--navy)}
.card-body{padding:24px}

/* ── FORM CONTROLS ───────────────────────────────── */
.form-group{margin-bottom:20px}
.form-group:last-child{margin-bottom:0}
.form-label{display:block;font-size:13px;font-weight:500;color:var(--g600);margin-bottom:7px}
.form-label .req{color:var(--gold);margin-left:2px}
.form-label .hint{font-weight:400;color:var(--g400);margin-left:6px;font-size:12px}
.form-control{width:100%;padding:10px 14px;border:1px solid var(--g200);border-radius:var(--r-sm);
    font-family:'DM Sans',sans-serif;font-size:14px;color:var(--g800);
    background:var(--white);transition:border-color .15s;outline:none}
.form-control:focus{border-color:var(--navy);box-shadow:0 0 0 3px rgba(25,38,93,.07)}
.form-control.error{border-color:#ef4444}
select.form-control{cursor:pointer;appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239aa0b8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 12px center;padding-right:32px}
textarea.form-control{resize:vertical;min-height:110px;line-height:1.6}
.form-error{font-size:12px;color:#dc2626;margin-top:5px;display:flex;align-items:center;gap:4px}
.form-hint{font-size:12px;color:var(--g400);margin-top:5px}

/* ── GRID ────────────────────────────────────────── */
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:16px}

/* ── ASSIGNEE SEARCH ─────────────────────────────── */
.assignee-search-wrap{position:relative}
.assignee-dropdown{position:absolute;top:100%;left:0;right:0;background:var(--white);
    border:1px solid var(--g200);border-radius:var(--r-sm);margin-top:4px;
    box-shadow:0 8px 24px rgba(25,38,93,.12);z-index:200;max-height:240px;overflow-y:auto;display:none}
.assignee-dropdown.open{display:block}
.assignee-option{display:flex;align-items:center;gap:10px;padding:10px 14px;cursor:pointer;transition:background .1s}
.assignee-option:hover{background:var(--navy-lt)}
.ao-avatar{width:32px;height:32px;border-radius:50%;background:var(--navy);
    display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:#fff;flex-shrink:0}
.ao-name{font-size:13px;font-weight:500;color:var(--navy)}
.ao-meta{font-size:11px;color:var(--g400)}
.role-pill{display:inline-block;padding:1px 8px;border-radius:20px;font-size:10px;font-weight:600;margin-left:6px}
.role-pill.professional{background:rgba(208,82,8,.12);color:#b84607}
.role-pill.consultant{background:rgba(59,130,246,.12);color:#1d4ed8}
.role-pill.user{background:var(--g100);color:var(--g600)}

/* ── SELECTED ASSIGNEE ───────────────────────────── */
.selected-assignee{display:flex;align-items:center;gap:10px;padding:10px 14px;
    background:var(--navy-lt);border:1px solid var(--g200);border-radius:var(--r-sm);display:none}
.sa-clear{margin-left:auto;width:24px;height:24px;border:none;background:transparent;
    cursor:pointer;border-radius:4px;display:flex;align-items:center;justify-content:center;color:var(--g400)}
.sa-clear:hover{background:var(--g200)}

/* ── FILE UPLOAD ─────────────────────────────────── */
.upload-zone{border:2px dashed var(--g200);border-radius:var(--r-md);padding:28px 20px;
    text-align:center;cursor:pointer;transition:all .2s;position:relative}
.upload-zone:hover,.upload-zone.over{border-color:var(--navy);background:var(--navy-lt)}
.upload-zone input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.upload-zone p{font-size:13px;color:var(--g600);margin-top:8px}
.upload-zone span{font-size:11px;color:var(--g400)}
.file-pill{display:flex;align-items:center;gap:8px;padding:8px 12px;
    background:var(--g50);border:1px solid var(--g200);border-radius:var(--r-sm);margin-top:8px}
.file-pill-name{font-size:12px;font-weight:500;color:var(--navy);flex:1;
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.file-pill-size{font-size:11px;color:var(--g400)}
.file-pill-rm{border:none;background:transparent;cursor:pointer;color:var(--g400);
    padding:2px;border-radius:3px;display:flex;align-items:center}
.file-pill-rm:hover{color:#dc2626}

/* ── PRIORITY SELECTOR ───────────────────────────── */
.priority-group{display:flex;gap:8px}
.priority-opt{flex:1}
.priority-opt input{display:none}
.priority-opt label{display:flex;align-items:center;justify-content:center;gap:6px;
    padding:9px 12px;border:1px solid var(--g200);border-radius:var(--r-sm);
    cursor:pointer;font-size:13px;font-weight:500;color:var(--g600);
    transition:all .15s;background:var(--white)}
.priority-opt input:checked + label.high  {border-color:#ef4444;background:#fee2e2;color:#dc2626}
.priority-opt input:checked + label.medium{border-color:#f59e0b;background:#fef3c7;color:#b45309}
.priority-opt input:checked + label.low   {border-color:#10b981;background:#d1fae5;color:#065f46}
.priority-opt label:hover{background:var(--g50)}

/* ── BUTTONS ─────────────────────────────────────── */
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 20px;
    border-radius:var(--r-sm);font-family:'DM Sans',sans-serif;font-size:14px;
    font-weight:500;cursor:pointer;border:none;text-decoration:none;transition:all .15s}
.btn-primary{background:var(--navy);color:#fff}
.btn-primary:hover{background:var(--navy-dk)}
.btn-gold{background:var(--gold);color:#fff}
.btn-gold:hover{background:#b84607}
.btn-outline{background:transparent;border:1px solid var(--g200);color:var(--g600)}
.btn-outline:hover{background:var(--g50)}

/* ── EXISTING FILES (edit mode) ──────────────────── */
.existing-file{display:flex;align-items:center;gap:10px;padding:10px 14px;
    background:var(--g50);border:1px solid var(--g200);border-radius:var(--r-sm);margin-bottom:8px}
.ef-icon{width:30px;height:30px;border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.ef-icon.pdf{background:#fee2e2;color:#dc2626}
.ef-icon.doc{background:#dbeafe;color:#2563eb}
.ef-icon.img{background:#d1fae5;color:#059669}
.ef-icon.oth{background:var(--g100);color:var(--g600)}
.ef-name{font-size:12px;font-weight:500;color:var(--navy);flex:1}
.ef-size{font-size:11px;color:var(--g400)}
</style>

<div class="page-header">
    <a href="{{ route('admin.tasks.index') }}" class="back-btn">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
    </a>
    <div>
        <h1>{{ $task->exists ? 'Edit Task' : 'Assign New Task' }}</h1>
        <p>{{ $task->exists ? 'Update task details, assignee or deadline' : 'Create and assign a task to a professional, consultant or user' }}</p>
    </div>
</div>

<form method="POST"
    action="{{ $task->exists ? route('admin.tasks.update', $task) : route('admin.tasks.store') }}"
    enctype="multipart/form-data"
    id="taskForm">
    @csrf
    @if($task->exists) @method('PUT') @endif

    <div class="form-layout">

        {{-- ── LEFT COLUMN ──────────────────────── --}}
        <div>

            {{-- Task Details --}}
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#19265d" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                        </svg>
                    </div>
                    <div class="card-title">Task Details</div>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label class="form-label">Title <span class="req">*</span></label>
                        <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'error' : '' }}"
                            value="{{ old('title', $task->title) }}"
                            placeholder="Clear, descriptive task title" required maxlength="120">
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description
                            <span class="hint">— What should be done? Any specific requirements?</span>
                        </label>
                        <textarea name="description" class="form-control"
                            placeholder="Detailed description of the task…">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="grid-2">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control">
                                <option value="">— None —</option>
                                @foreach(['Property Valuation','Legal Documentation','Site Inspection','Contract Review','Market Analysis','Financial Report','Other'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category',$task->category)===$cat?'selected':'' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Deadline <span class="req">*</span></label>
                            <input type="date" name="deadline" class="form-control {{ $errors->has('deadline') ? 'error' : '' }}"
                                value="{{ old('deadline', $task->deadline?->format('Y-m-d')) }}" required
                                min="{{ now()->format('Y-m-d') }}">
                            @error('deadline')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- Attachments --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#19265d" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                    </div>
                    <div class="card-title">Attachments
                        <span style="font-size:13px;font-weight:400;color:var(--g400);font-family:'DM Sans',sans-serif"> — optional reference files for the assignee</span>
                    </div>
                </div>
                <div class="card-body">

                    @if($task->exists && $task->files->count())
                    <div style="margin-bottom:16px">
                        <p style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.7px;color:var(--g400);margin-bottom:10px">Existing Files</p>
                        @foreach($task->files as $file)
                        @php
                            $ext = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
                            $ic  = $ext === 'pdf' ? 'pdf' : (in_array($ext, ['doc','docx']) ? 'doc' : (in_array($ext, ['jpg','jpeg','png','gif']) ? 'img' : 'oth'));
                        @endphp
                        <div class="existing-file">
                            <div class="ef-icon {{ $ic }}">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm0 2l4 4h-4V4z"/></svg>
                            </div>
                            <div class="ef-name">{{ $file->original_name }}</div>
                            <div class="ef-size">{{ $file->humanSize() }}</div>
                            <label style="display:flex;align-items:center;gap:5px;font-size:12px;color:#dc2626;cursor:pointer">
                                <input type="checkbox" name="delete_files[]" value="{{ $file->id }}"> Remove
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="upload-zone" id="uploadZone">
                        <input type="file" name="attachments[]" id="attachInput"
                            multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.zip">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#9aa0b8" stroke-width="1.5" style="margin:0 auto">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p>Drop files or click to attach</p>
                        <span>PDF, Word, Excel, Images — max 20 MB each</span>
                    </div>
                    <div id="filePreview"></div>

                </div>
            </div>

        </div>

        {{-- ── RIGHT COLUMN ─────────────────────── --}}
        <div>

            {{-- Assignee --}}
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#19265d" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="card-title">Assign To <span style="color:#ef4444;font-size:14px">*</span></div>
                </div>
                <div class="card-body">
                    <input type="hidden" name="assigned_to" id="assignedToInput"
                        value="{{ old('assigned_to', $task->assigned_to) }}" required>

                    {{-- Selected display --}}
                    <div class="selected-assignee" id="selectedAssignee"
                        style="{{ $task->exists ? 'display:flex' : '' }}">
                        <div class="ao-avatar" id="selAvatar">
                            @if($task->exists)
                                {{ strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $task->assignee->name), 0, 2)))) }}
                            @endif
                        </div>
                        <div>
                            <div class="ao-name" id="selName">{{ $task->exists ? $task->assignee->name : '' }}</div>
                            <div class="ao-meta" id="selMeta">{{ $task->exists ? ucfirst($task->assignee->role).' · '.$task->assignee->email : '' }}</div>
                        </div>
                        <button type="button" class="sa-clear" onclick="clearAssignee()">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    {{-- Search --}}
                    <div class="assignee-search-wrap" id="assigneeSearch"
                        style="{{ $task->exists ? 'display:none' : '' }}">
                        <input type="text" class="form-control" id="assigneeQ"
                            placeholder="Search by name, email or role…"
                            onkeyup="searchAssignees(this.value)"
                            autocomplete="off">
                        <div class="assignee-dropdown" id="assigneeDropdown">
                            @foreach($assignableUsers as $u)
                            <div class="assignee-option" onclick="selectAssignee({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}', '{{ $u->role }}')">
                                <div class="ao-avatar">
                                    {{ strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $u->name), 0, 2)))) }}
                                </div>
                                <div>
                                    <div class="ao-name">{{ $u->name }}
                                        <span class="role-pill {{ $u->role }}">{{ ucfirst($u->role) }}</span>
                                    </div>
                                    <div class="ao-meta">{{ $u->email }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    @error('assigned_to')<div class="form-error" style="margin-top:8px">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Priority & Status --}}
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#19265d" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="card-title">Priority & Status</div>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label class="form-label">Priority <span class="req">*</span></label>
                        <div class="priority-group">
                            @foreach(['high','medium','low'] as $p)
                            <div class="priority-opt">
                                <input type="radio" name="priority" id="pri_{{ $p }}" value="{{ $p }}"
                                    {{ old('priority', $task->priority ?? 'medium') === $p ? 'checked' : '' }}>
                                <label for="pri_{{ $p }}" class="{{ $p }}">
                                    <span style="width:7px;height:7px;border-radius:50%;background:{{ $p==='high'?'#ef4444':($p==='medium'?'#f59e0b':'#10b981') }};display:inline-block"></span>
                                    {{ ucfirst($p) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    @if($task->exists)
                    <div class="form-group" style="margin-bottom:0">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            @foreach(['pending','in_progress','under_review','completed','overdue'] as $s)
                            <option value="{{ $s }}" {{ old('status', $task->status) === $s ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $s)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Internal Notes --}}
            <div class="card" style="margin-bottom:20px">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#19265d" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                    </div>
                    <div class="card-title">Internal Notes</div>
                </div>
                <div class="card-body">
                    <textarea name="admin_notes" class="form-control" style="min-height:80px"
                        placeholder="Private notes visible only to admins…">{{ old('admin_notes', $task->admin_notes) }}</textarea>
                </div>
            </div>

            {{-- Submit --}}
            <div style="display:flex;flex-direction:column;gap:10px">
                <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ $task->exists ? 'Save Changes' : 'Assign Task' }}
                </button>
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline" style="width:100%;justify-content:center">
                    Cancel
                </a>
            </div>

        </div>

    </div>
</form>

<script>
/* ── ASSIGNEE SEARCH ────────────────────────── */
const allUsers = {{ Illuminate\Support\Js::from($assignableUsersJson) }};

function searchAssignees(q) {
    const dd = document.getElementById('assigneeDropdown');
    const filtered = q.length < 1 ? [] : allUsers.filter(u =>
        u.name.toLowerCase().includes(q.toLowerCase()) ||
        u.email.toLowerCase().includes(q.toLowerCase()) ||
        u.role.toLowerCase().includes(q.toLowerCase())
    );
    dd.innerHTML = filtered.map(u => `
        <div class="assignee-option" onclick="selectAssignee(${u.id},'${u.name.replace(/'/g,"\\'")}','${u.email}','${u.role}')">
            <div class="ao-avatar">${u.init}</div>
            <div>
                <div class="ao-name">${u.name} <span class="role-pill ${u.role}">${u.role.charAt(0).toUpperCase()+u.role.slice(1)}</span></div>
                <div class="ao-meta">${u.email}</div>
            </div>
        </div>`).join('');
    dd.classList.toggle('open', filtered.length > 0 && q.length > 0);
}

function selectAssignee(id, name, email, role) {
    document.getElementById('assignedToInput').value = id;
    document.getElementById('selAvatar').textContent  = name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
    document.getElementById('selName').textContent    = name;
    document.getElementById('selMeta').textContent    = role.charAt(0).toUpperCase() + role.slice(1) + ' · ' + email;
    document.getElementById('selectedAssignee').style.display = 'flex';
    document.getElementById('assigneeSearch').style.display   = 'none';
    document.getElementById('assigneeDropdown').classList.remove('open');
}

function clearAssignee() {
    document.getElementById('assignedToInput').value = '';
    document.getElementById('assigneeQ').value       = '';
    document.getElementById('selectedAssignee').style.display = 'none';
    document.getElementById('assigneeSearch').style.display   = 'block';
}

document.addEventListener('click', e => {
    if (!e.target.closest('.assignee-search-wrap'))
        document.getElementById('assigneeDropdown').classList.remove('open');
});

/* ── FILE UPLOAD PREVIEW ────────────────────── */
let selFiles = [];
const attachInput = document.getElementById('attachInput');
const filePreview = document.getElementById('filePreview');
const uploadZone  = document.getElementById('uploadZone');

attachInput.addEventListener('change', addFiles);
uploadZone.addEventListener('dragover',  e => { e.preventDefault(); uploadZone.classList.add('over'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('over'));
uploadZone.addEventListener('drop', e => {
    e.preventDefault(); uploadZone.classList.remove('over');
    const dt = new DataTransfer();
    [...e.dataTransfer.files].forEach(f => dt.items.add(f));
    attachInput.files = dt.files;
    addFiles();
});

function addFiles() {
    [...attachInput.files].forEach(f => { if (!selFiles.find(x => x.name === f.name)) selFiles.push(f); });
    renderPreviews();
}

function renderPreviews() {
    filePreview.innerHTML = selFiles.map((f, i) => `
        <div class="file-pill">
            <svg width="14" height="14" fill="#5a6082" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm0 2l4 4h-4V4z"/></svg>
            <span class="file-pill-name">${f.name}</span>
            <span class="file-pill-size">${(f.size / 1024).toFixed(1)} KB</span>
            <button type="button" class="file-pill-rm" onclick="removeFile(${i})">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>`).join('');
    const dt = new DataTransfer();
    selFiles.forEach(f => dt.items.add(f));
    attachInput.files = dt.files;
}

function removeFile(i) { selFiles.splice(i, 1); renderPreviews(); }
</script>
@endsection