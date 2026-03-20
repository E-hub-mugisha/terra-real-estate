{{-- ================================================================
     SAVE AS: resources/views/admin/tenders/create.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'Post New Tender')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--indigo:#4f46e5;--indigo-lt:#6366f1;--green:#22c55e;}
    .tc-page{padding:1.75rem 0 3rem;max-width:940px;margin:0 auto;}
    .tc-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .tc-breadcrumb a{color:var(--muted);text-decoration:none;}.tc-breadcrumb a:hover{color:var(--indigo);}
    .tc-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;}
    .tc-heading-icon{width:48px;height:48px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#4f46e518,#4f46e530);border:1px solid #4f46e530;display:flex;align-items:center;justify-content:center;color:var(--indigo);}
    .tc-heading h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .tc-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .tc-layout{display:grid;grid-template-columns:1fr 260px;gap:1.25rem;align-items:start;}
    .tc-main{display:flex;flex-direction:column;gap:1.25rem;}
    .tc-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .tc-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .tc-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .tc-card-header-icon{width:32px;height:32px;border-radius:8px;background:#4f46e514;display:flex;align-items:center;justify-content:center;color:var(--indigo);flex-shrink:0;}
    .tc-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .tc-card-body{padding:1.5rem;}
    .tc-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .tc-label .req{color:var(--danger);margin-left:.2rem;}
    .tc-input,.tc-select,.tc-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .tc-input:focus,.tc-select:focus,.tc-textarea:focus{border-color:var(--indigo);box-shadow:0 0 0 3px rgba(79,70,229,.1);}
    .tc-input.is-invalid{border-color:var(--danger);}
    .tc-textarea{resize:vertical;line-height:1.7;min-height:160px;}
    .tc-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .tc-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;display:flex;align-items:center;gap:.3rem;}
    .tc-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .tc-gap{display:flex;flex-direction:column;gap:1rem;}
    /* PDF upload */
    .tc-pdf-upload{border:2px dashed var(--border);border-radius:10px;padding:1.5rem;background:var(--surface);cursor:pointer;transition:border-color .2s,background .2s;position:relative;text-align:center;}
    .tc-pdf-upload:hover{border-color:var(--indigo);background:#4f46e504;}
    .tc-pdf-upload input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .tc-pdf-icon{width:44px;height:44px;border-radius:10px;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto .65rem;color:var(--danger);}
    .tc-pdf-selected{display:none;align-items:center;gap:.75rem;padding:.85rem 1rem;border:1px solid #bbf7d0;border-radius:8px;background:#f0fdf4;margin-top:.75rem;}
    .tc-pdf-selected.visible{display:flex;}
    /* status toggle */
    .tc-status-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;}
    .tc-status-radio{display:none;}
    .tc-status-label{display:flex;align-items:center;gap:.5rem;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);cursor:pointer;transition:all .15s;user-select:none;font-weight:500;}
    .tc-status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .tc-status-radio[value="1"]:checked+.tc-status-label{border-color:var(--green);background:#f0fdf4;color:#166534;}
    .tc-status-radio[value="0"]:checked+.tc-status-label{border-color:#fecaca;background:#fef2f2;color:#991b1b;}
    /* alerts */
    .tc-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .tc-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .tc-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .tc-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .tc-alert li{margin-bottom:.2rem;}
    /* submit bar */
    .tc-submit-bar{display:flex;align-items:center;justify-content:flex-end;gap:.6rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .tc-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .tc-btn-primary{background:var(--indigo);color:#fff;}.tc-btn-primary:hover{background:var(--indigo-lt);color:#fff;transform:translateY(-1px);}
    .tc-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.tc-btn-ghost:hover{border-color:var(--indigo);color:var(--indigo);}
    /* summary card */
    .tc-summary{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .tc-summary-header{padding:.9rem 1.2rem;background:linear-gradient(135deg,#4f46e514,#4f46e508);border-bottom:1px solid var(--border);font-size:.82rem;font-weight:600;color:var(--text);display:flex;align-items:center;gap:.5rem;}
    .tc-summary-body{padding:1.1rem;}
    .tc-summary-row{display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;font-size:.79rem;padding:.45rem 0;border-bottom:1px solid var(--border);}
    .tc-summary-row:last-child{border-bottom:none;padding-bottom:0;}
    .tc-summary-key{color:var(--muted);flex-shrink:0;}
    .tc-summary-val{color:var(--text);text-align:right;word-break:break-word;max-width:160px;}
    @media(max-width:860px){.tc-layout{grid-template-columns:1fr;}.tc-side{position:static;}.tc-row-2{grid-template-columns:1fr;}}
</style>

<div class="tc-page">
    <nav class="tc-breadcrumb">
        <a href="{{ route('admin.tenders.index') }}">Tenders</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Post New Tender</span>
    </nav>

    <div class="tc-heading">
        <div class="tc-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><path d="M10 9H9H8"/></svg>
        </div>
        <div>
            <h4>Post New Tender</h4>
            <p>Fill in the details and upload the tender document.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="tc-alert tc-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif
    @if(session('success'))
        <div class="tc-alert tc-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.tenders.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="tc-layout">
            <div class="tc-main">

                {{-- Core Details --}}
                <div class="tc-card">
                    <div class="tc-card-header">
                        <div class="tc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                        <h6>Tender Details</h6>
                    </div>
                    <div class="tc-card-body">
                        <div class="tc-gap">
                            <div>
                                <label class="tc-label">Title <span class="req">*</span></label>
                                <input type="text" name="title" id="titleInput" class="tc-input @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" placeholder="e.g. Supply of Construction Materials for Phase II" oninput="updateSummary()" required>
                                @error('title')<p class="tc-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="tc-label">Description <span class="req">*</span></label>
                                <textarea name="description" class="tc-textarea @error('description') is-invalid @enderror"
                                          placeholder="Full tender description including scope of work, requirements, eligibility criteria…">{{ old('description') }}</textarea>
                                @error('description')<p class="tc-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="tc-row-2">
                                <div>
                                    <label class="tc-label">Reference Number</label>
                                    <input type="text" name="reference_no" id="refInput" class="tc-input @error('reference_no') is-invalid @enderror"
                                           value="{{ old('reference_no') }}" placeholder="Auto-generated if blank" oninput="updateSummary()">
                                    <p class="tc-hint">Leave blank to auto-generate.</p>
                                    @error('reference_no')<p class="tc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="tc-label">Location</label>
                                    <input type="text" name="location" id="locInput" class="tc-input @error('location') is-invalid @enderror"
                                           value="{{ old('location') }}" placeholder="e.g. Kigali, Gasabo" oninput="updateSummary()">
                                    @error('location')<p class="tc-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="tc-row-2">
                                <div>
                                    <label class="tc-label">Budget (RWF)</label>
                                    <input type="number" name="budget" id="budgetInput" class="tc-input @error('budget') is-invalid @enderror"
                                           value="{{ old('budget') }}" placeholder="e.g. 50000000" min="0" step="1" oninput="updateSummary()">
                                    <p class="tc-hint">Leave blank if not disclosed.</p>
                                    @error('budget')<p class="tc-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="tc-label">Submission Deadline <span class="req">*</span></label>
                                    <input type="date" name="submission_deadline" id="deadlineInput" class="tc-input @error('submission_deadline') is-invalid @enderror"
                                           value="{{ old('submission_deadline') }}" min="{{ now()->addDay()->format('Y-m-d') }}" oninput="updateSummary()" required>
                                    @error('submission_deadline')<p class="tc-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Document --}}
                <div class="tc-card">
                    <div class="tc-card-header">
                        <div class="tc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                        <h6>Tender Document</h6>
                    </div>
                    <div class="tc-card-body">
                        <div class="tc-pdf-upload">
                            <input type="file" name="document_path" id="pdfInput" accept=".pdf">
                            <div class="tc-pdf-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                            </div>
                            <p style="font-size:.85rem;font-weight:600;color:var(--text);margin:0 0 .2rem">Upload tender document</p>
                            <p style="font-size:.75rem;color:var(--muted);margin:0">PDF only — max 10MB</p>
                        </div>
                        <div class="tc-pdf-selected" id="pdfSelected">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--green);flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
                            <span id="pdfFileName" style="font-size:.83rem;color:var(--text);flex:1">—</span>
                            <span id="pdfFileSize" style="font-size:.73rem;color:var(--muted)">—</span>
                        </div>
                        @error('document_path')<p class="tc-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="tc-submit-bar">
                    <a href="{{ route('admin.tenders.index') }}" class="tc-btn tc-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        Cancel
                    </a>
                    <button type="submit" class="tc-btn tc-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Publish Tender
                    </button>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="tc-side">

                {{-- Status --}}
                <div class="tc-card">
                    <div class="tc-card-header">
                        <div class="tc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
                        <h6>Status</h6>
                    </div>
                    <div class="tc-card-body">
                        <div class="tc-status-grid">
                            <input type="radio" name="is_open" id="isOpen1" value="1" class="tc-status-radio" {{ old('is_open','1')==='1'?'checked':'' }}>
                            <label for="isOpen1" class="tc-status-label">
                                <span class="tc-status-dot" style="background:var(--green)"></span>Open
                            </label>
                            <input type="radio" name="is_open" id="isOpen0" value="0" class="tc-status-radio" {{ old('is_open')==='0'?'checked':'' }}>
                            <label for="isOpen0" class="tc-status-label">
                                <span class="tc-status-dot" style="background:var(--muted)"></span>Closed
                            </label>
                        </div>
                        @error('is_open')<p class="tc-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Live summary --}}
                <div class="tc-summary">
                    <div class="tc-summary-header">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--indigo)"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                        Summary Preview
                    </div>
                    <div class="tc-summary-body">
                        <div class="tc-summary-row">
                            <span class="tc-summary-key">Title</span>
                            <span class="tc-summary-val" id="sumTitle" style="color:var(--muted);font-style:italic">Not entered</span>
                        </div>
                        <div class="tc-summary-row">
                            <span class="tc-summary-key">Ref No.</span>
                            <span class="tc-summary-val" id="sumRef" style="color:var(--muted);font-style:italic">Auto</span>
                        </div>
                        <div class="tc-summary-row">
                            <span class="tc-summary-key">Budget</span>
                            <span class="tc-summary-val" id="sumBudget" style="color:var(--muted);font-style:italic">Not set</span>
                        </div>
                        <div class="tc-summary-row">
                            <span class="tc-summary-key">Deadline</span>
                            <span class="tc-summary-val" id="sumDeadline" style="color:var(--muted);font-style:italic">Not set</span>
                        </div>
                        <div class="tc-summary-row">
                            <span class="tc-summary-key">Location</span>
                            <span class="tc-summary-val" id="sumLocation" style="color:var(--muted);font-style:italic">Not set</span>
                        </div>
                    </div>
                </div>

                {{-- Tips --}}
                <div class="tc-card">
                    <div class="tc-card-header">
                        <div class="tc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg></div>
                        <h6>Tips</h6>
                    </div>
                    <div class="tc-card-body">
                        <ul style="font-size:.79rem;color:var(--text-dim);line-height:1.65;padding-left:1.1rem;margin:0;">
                            <li style="margin-bottom:.4rem">Reference numbers are auto-generated if left blank.</li>
                            <li style="margin-bottom:.4rem">Deadline must be a future date.</li>
                            <li style="margin-bottom:.4rem">Upload the full PDF tender document for applicants.</li>
                            <li>Set status to <strong>Closed</strong> to hide from public listings.</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
function updateSummary(){
    const title    = document.getElementById('titleInput').value.trim();
    const ref      = document.getElementById('refInput').value.trim();
    const budget   = document.getElementById('budgetInput').value;
    const deadline = document.getElementById('deadlineInput').value;
    const loc      = document.getElementById('locInput').value.trim();

    const set = (id,val,fallback,style='')=>{
        const el=document.getElementById(id);
        if(val){el.textContent=val;el.style.cssText='color:var(--text);'+style;}
        else{el.textContent=fallback;el.style.cssText='color:var(--muted);font-style:italic;';}
    };

    set('sumTitle', title.length>40?title.slice(0,40)+'…':title, 'Not entered');
    set('sumRef', ref||'', 'Auto-generated', 'font-family:monospace;font-size:.77rem');
    set('sumBudget', budget?'RWF '+parseInt(budget).toLocaleString():'', 'Not set');
    set('sumDeadline', deadline?new Date(deadline).toLocaleDateString('en-GB',{day:'numeric',month:'short',year:'numeric'}):'', 'Not set');
    set('sumLocation', loc, 'Not set');
}
document.getElementById('pdfInput').addEventListener('change',function(){
    const file=this.files[0];
    const box=document.getElementById('pdfSelected');
    if(file){
        document.getElementById('pdfFileName').textContent=file.name;
        document.getElementById('pdfFileSize').textContent=(file.size/1024/1024).toFixed(2)+' MB';
        box.classList.add('visible');
    } else { box.classList.remove('visible'); }
});
</script>
@endsection
