{{-- ================================================================
     SAVE AS: resources/views/admin/tenders/edit.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'Edit Tender — ' . $tender->title)
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--indigo:#4f46e5;--indigo-lt:#6366f1;--green:#22c55e;}
    .te-page{padding:1.75rem 0 3rem;max-width:940px;margin:0 auto;}
    .te-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .te-breadcrumb a{color:var(--muted);text-decoration:none;}.te-breadcrumb a:hover{color:var(--indigo);}
    .te-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;}
    .te-heading-icon{width:42px;height:42px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#4f46e518,#4f46e530);border:1px solid #4f46e530;display:flex;align-items:center;justify-content:center;color:var(--indigo);}
    .te-heading h4{font-size:1.15rem;font-weight:700;color:var(--text);margin:0;}
    .te-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .te-heading-meta{margin-left:auto;display:flex;align-items:center;gap:.6rem;}
    .te-layout{display:grid;grid-template-columns:1fr 260px;gap:1.25rem;align-items:start;}
    .te-main{display:flex;flex-direction:column;gap:1.25rem;}
    .te-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .te-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .te-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .te-card-header-icon{width:32px;height:32px;border-radius:8px;background:#4f46e514;display:flex;align-items:center;justify-content:center;color:var(--indigo);flex-shrink:0;}
    .te-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .te-card-body{padding:1.5rem;}
    .te-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .te-label .req{color:var(--danger);margin-left:.2rem;}
    .te-input,.te-select,.te-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .te-input:focus,.te-select:focus,.te-textarea:focus{border-color:var(--indigo);box-shadow:0 0 0 3px rgba(79,70,229,.1);}
    .te-input.is-invalid{border-color:var(--danger);}
    .te-textarea{resize:vertical;line-height:1.7;min-height:160px;}
    .te-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .te-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;display:flex;align-items:center;gap:.3rem;}
    .te-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .te-gap{display:flex;flex-direction:column;gap:1rem;}
    .te-status-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;}
    .te-status-radio{display:none;}
    .te-status-label{display:flex;align-items:center;gap:.5rem;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);cursor:pointer;transition:all .15s;user-select:none;font-weight:500;}
    .te-status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .te-status-radio[value="1"]:checked+.te-status-label{border-color:var(--green);background:#f0fdf4;color:#166534;}
    .te-status-radio[value="0"]:checked+.te-status-label{border-color:#fecaca;background:#fef2f2;color:#991b1b;}
    .te-current-doc{display:flex;align-items:center;gap:.85rem;padding:.85rem 1rem;border:1px solid var(--border);border-radius:8px;background:var(--surface);margin-bottom:.85rem;}
    .te-doc-icon{width:38px;height:38px;border-radius:8px;background:#fef2f2;display:flex;align-items:center;justify-content:center;color:var(--danger);flex-shrink:0;}
    .te-pdf-upload{border:2px dashed var(--border);border-radius:10px;padding:1.25rem;background:var(--surface);cursor:pointer;transition:border-color .2s,background .2s;position:relative;text-align:center;}
    .te-pdf-upload:hover{border-color:var(--indigo);background:#4f46e504;}
    .te-pdf-upload input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .te-new-doc{display:none;align-items:center;gap:.75rem;padding:.75rem 1rem;border:1px solid #bbf7d0;border-radius:8px;background:#f0fdf4;margin-top:.75rem;}
    .te-new-doc.visible{display:flex;}
    .te-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .te-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .te-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .te-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .te-alert li{margin-bottom:.2rem;}
    .te-submit-bar{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .te-submit-bar-left{font-size:.78rem;color:var(--muted);display:flex;align-items:center;gap:.4rem;}
    .te-submit-bar-right{display:flex;gap:.6rem;}
    .te-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .te-btn-primary{background:var(--indigo);color:#fff;}.te-btn-primary:hover{background:var(--indigo-lt);color:#fff;transform:translateY(-1px);}
    .te-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.te-btn-ghost:hover{border-color:var(--indigo);color:var(--indigo);}
    .te-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.te-btn-danger:hover{background:#fef2f2;}
    .te-btn-sm{padding:.42rem .9rem;font-size:.78rem;}
    @media(max-width:860px){.te-layout{grid-template-columns:1fr;}.te-side{position:static;}.te-row-2{grid-template-columns:1fr;}}
</style>

<div class="te-page">
    <nav class="te-breadcrumb">
        <a href="{{ route('admin.tenders.index') }}">Tenders</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('admin.tenders.show',$tender->id) }}">{{ Str::limit($tender->title,40) }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Edit</span>
    </nav>

    <div class="te-heading">
        <div class="te-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div>
            <h4>Edit Tender</h4>
            <p>{{ $tender->reference_no }} — last updated {{ $tender->updated_at->diffForHumans() }}</p>
        </div>
        <div class="te-heading-meta">
            <a href="{{ route('admin.tenders.show',$tender->id) }}" class="te-btn te-btn-ghost te-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="te-alert te-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif
    @if(session('success'))
        <div class="te-alert te-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.tenders.update',$tender->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="te-layout">
            <div class="te-main">

                {{-- Core Details --}}
                <div class="te-card">
                    <div class="te-card-header">
                        <div class="te-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                        <h6>Tender Details</h6>
                    </div>
                    <div class="te-card-body">
                        <div class="te-gap">
                            <div>
                                <label class="te-label">Title <span class="req">*</span></label>
                                <input type="text" name="title" class="te-input @error('title') is-invalid @enderror" value="{{ old('title',$tender->title) }}" required>
                                @error('title')<p class="te-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="te-label">Description <span class="req">*</span></label>
                                <textarea name="description" class="te-textarea @error('description') is-invalid @enderror">{{ old('description',$tender->description) }}</textarea>
                                @error('description')<p class="te-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="te-row-2">
                                <div>
                                    <label class="te-label">Reference Number</label>
                                    <input type="text" name="reference_no" class="te-input @error('reference_no') is-invalid @enderror" value="{{ old('reference_no',$tender->reference_no) }}">
                                    @error('reference_no')<p class="te-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="te-label">Location</label>
                                    <input type="text" name="location" class="te-input @error('location') is-invalid @enderror" value="{{ old('location',$tender->location) }}" placeholder="e.g. Kigali, Gasabo">
                                    @error('location')<p class="te-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="te-row-2">
                                <div>
                                    <label class="te-label">Budget (RWF)</label>
                                    <input type="number" name="budget" class="te-input @error('budget') is-invalid @enderror" value="{{ old('budget',$tender->budget) }}" min="0" step="1">
                                    @error('budget')<p class="te-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="te-label">Submission Deadline <span class="req">*</span></label>
                                    <input type="date" name="submission_deadline" class="te-input @error('submission_deadline') is-invalid @enderror" value="{{ old('submission_deadline',$tender->submission_deadline->format('Y-m-d')) }}" required>
                                    @error('submission_deadline')<p class="te-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Document --}}
                <div class="te-card">
                    <div class="te-card-header">
                        <div class="te-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <h6>Tender Document</h6>
                    </div>
                    <div class="te-card-body">
                        @if($tender->document_path)
                            <div class="te-current-doc">
                                <div class="te-doc-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <div style="flex:1;min-width:0">
                                    <strong style="display:block;font-size:.83rem;color:var(--text)">{{ basename($tender->document_path) }}</strong>
                                    <span style="font-size:.73rem;color:var(--muted)">Current document</span>
                                </div>
                                <a href="{{ asset('storage/'.$tender->document_path) }}" target="_blank" class="te-btn te-btn-ghost te-btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                    View
                                </a>
                            </div>
                        @endif
                        <div class="te-pdf-upload">
                            <input type="file" name="document_path" id="pdfInput" accept=".pdf">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--indigo);margin-bottom:.4rem"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            <p style="font-size:.83rem;font-weight:600;color:var(--text);margin:0 0 .2rem">{{ $tender->document_path ? 'Replace document' : 'Upload document' }}</p>
                            <p style="font-size:.74rem;color:var(--muted);margin:0">PDF only — max 10MB</p>
                        </div>
                        <div class="te-new-doc" id="newDocBox">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--green);flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
                            <span id="newDocName" style="font-size:.83rem;color:var(--text);flex:1">—</span>
                            <span id="newDocSize" style="font-size:.73rem;color:var(--muted)">—</span>
                        </div>
                        @error('document_path')<p class="te-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="te-submit-bar">
                    <div class="te-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $tender->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="te-submit-bar-right">
                        <a href="{{ route('admin.tenders.show',$tender->id) }}" class="te-btn te-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="te-btn te-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="te-side">

                {{-- Status --}}
                <div class="te-card">
                    <div class="te-card-header">
                        <div class="te-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
                        <h6>Status</h6>
                    </div>
                    <div class="te-card-body">
                        <div class="te-status-grid">
                            <input type="radio" name="is_open" id="isOpen1" value="1" class="te-status-radio" {{ old('is_open', $tender->is_open ? '1' : '0') === '1' ? 'checked' : '' }}>
                            <label for="isOpen1" class="te-status-label"><span class="te-status-dot" style="background:var(--green)"></span>Open</label>
                            <input type="radio" name="is_open" id="isOpen0" value="0" class="te-status-radio" {{ old('is_open', $tender->is_open ? '1' : '0') === '0' ? 'checked' : '' }}>
                            <label for="isOpen0" class="te-status-label"><span class="te-status-dot" style="background:var(--muted)"></span>Closed</label>
                        </div>
                    </div>
                </div>

                {{-- Meta info --}}
                <div class="te-card">
                    <div class="te-card-header">
                        <div class="te-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                        <h6>Tender Info</h6>
                    </div>
                    <div class="te-card-body">
                        <div style="display:flex;flex-direction:column;gap:.65rem;font-size:.81rem;color:var(--text-dim);">
                            <div style="display:flex;justify-content:space-between;"><span style="color:var(--muted)">Posted by</span><span>{{ $tender->user?->name ?? '—' }}</span></div>
                            <div style="display:flex;justify-content:space-between;"><span style="color:var(--muted)">Posted on</span><span>{{ $tender->created_at->format('M j, Y') }}</span></div>
                            <div style="display:flex;justify-content:space-between;"><span style="color:var(--muted)">Deadline</span>
                                <span style="{{ $tender->submission_deadline < now() ? 'color:var(--danger);font-weight:600' : '' }}">{{ $tender->submission_deadline->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Danger --}}
                <div class="te-card" style="border-color:#fecaca;">
                    <div class="te-card-header" style="background:#fef2f2;border-color:#fecaca;">
                        <div class="te-card-header-icon" style="background:#fee2e2;color:var(--danger);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/></svg></div>
                        <h6 style="color:var(--danger)">Danger Zone</h6>
                    </div>
                    <div class="te-card-body">
                        <p style="font-size:.8rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">Permanently deletes this tender and its document.</p>
                        <form method="POST" action="{{ route('admin.tenders.destroy',$tender->id) }}" onsubmit="return confirm('Delete this tender? Cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="te-btn te-btn-danger" style="width:100%;justify-content:center;font-size:.82rem;padding:.55rem 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                Delete Tender
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('pdfInput').addEventListener('change',function(){
    const file=this.files[0];
    const box=document.getElementById('newDocBox');
    if(file){
        document.getElementById('newDocName').textContent=file.name;
        document.getElementById('newDocSize').textContent=(file.size/1024/1024).toFixed(2)+' MB';
        box.classList.add('visible');
    } else { box.classList.remove('visible'); }
});
</script>
@endsection