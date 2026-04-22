@extends('layouts.app')
@section('title', 'New Announcement')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--violet:#7c3aed;--violet-lt:#8b5cf6;--green:#22c55e;--amber:#f59e0b;}
    .ac2-page{padding:1.75rem 0 3rem;max-width:940px;margin:0 auto;}
    .ac2-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .ac2-breadcrumb a{color:var(--muted);text-decoration:none;}.ac2-breadcrumb a:hover{color:var(--violet);}
    .ac2-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;}
    .ac2-heading-icon{width:48px;height:48px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#7c3aed18,#7c3aed30);border:1px solid #7c3aed30;display:flex;align-items:center;justify-content:center;color:var(--violet);}
    .ac2-heading h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .ac2-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .ac2-layout{display:grid;grid-template-columns:1fr 260px;gap:1.25rem;align-items:start;}
    .ac2-main{display:flex;flex-direction:column;gap:1.25rem;}
    .ac2-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .ac2-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ac2-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .ac2-card-header-icon{width:32px;height:32px;border-radius:8px;background:#7c3aed14;display:flex;align-items:center;justify-content:center;color:var(--violet);flex-shrink:0;}
    .ac2-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .ac2-card-body{padding:1.5rem;}
    .ac2-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .ac2-label .req{color:var(--danger);margin-left:.2rem;}
    .ac2-input,.ac2-select,.ac2-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .ac2-input:focus,.ac2-select:focus,.ac2-textarea:focus{border-color:var(--violet);box-shadow:0 0 0 3px rgba(124,58,237,.1);}
    .ac2-input.is-invalid{border-color:var(--danger);}
    .ac2-textarea{resize:vertical;line-height:1.7;min-height:200px;}
    .ac2-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .ac2-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;display:flex;align-items:center;gap:.3rem;}
    .ac2-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .ac2-gap{display:flex;flex-direction:column;gap:1rem;}
    .ac2-slug-wrap{position:relative;}
    .ac2-slug-prefix{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);font-size:.8rem;color:var(--muted);pointer-events:none;font-family:monospace;}
    .ac2-slug-input{padding-left:8rem!important;font-family:monospace;font-size:.84rem;}
    /* status selector */
    .ac2-status-grid{display:grid;grid-template-columns:1fr;gap:.4rem;}
    .ac2-status-radio{display:none;}
    .ac2-status-label{display:flex;align-items:center;gap:.6rem;padding:.6rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);cursor:pointer;transition:all .15s;user-select:none;font-weight:500;}
    .ac2-status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .ac2-status-radio[value="active"]:checked    +.ac2-status-label{border-color:var(--green);background:#f0fdf4;color:#166534;}
    .ac2-status-radio[value="paid"]:checked      +.ac2-status-label{border-color:#bfdbfe;background:#eff6ff;color:#1d4ed8;}
    .ac2-status-radio[value="pending"]:checked   +.ac2-status-label{border-color:#fde68a;background:#fffbeb;color:#92400e;}
    .ac2-status-radio[value="expired"]:checked   +.ac2-status-label{border-color:#fecaca;background:#fef2f2;color:#991b1b;}
    .ac2-status-radio[value="inactive"]:checked  +.ac2-status-label{border-color:var(--border);background:var(--surface);color:var(--muted);}
    .ac2-status-desc{font-size:.7rem;margin-left:.25rem;opacity:.75;}
    /* alerts */
    .ac2-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .ac2-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .ac2-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .ac2-alert li{margin-bottom:.2rem;}
    /* submit bar */
    .ac2-submit-bar{display:flex;align-items:center;justify-content:flex-end;gap:.6rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .ac2-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .ac2-btn-primary{background:var(--violet);color:#fff;}.ac2-btn-primary:hover{background:var(--violet-lt);color:#fff;transform:translateY(-1px);}
    .ac2-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.ac2-btn-ghost:hover{border-color:var(--violet);color:var(--violet);}
    /* live preview */
    .ac2-preview{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ac2-preview-banner{height:4px;background:linear-gradient(90deg,var(--violet),var(--violet-lt));}
    .ac2-preview-body{padding:1rem 1.1rem;}
    .ac2-preview-title{font-size:.9rem;font-weight:700;color:var(--text);margin:0 0 .25rem;word-break:break-word;}
    .ac2-preview-slug{font-size:.72rem;font-family:monospace;color:var(--muted);margin-bottom:.5rem;}
    @media(max-width:860px){.ac2-layout{grid-template-columns:1fr;}.ac2-side{position:static;}.ac2-row-2{grid-template-columns:1fr;}}
</style>

<div class="ac2-page">
    <nav class="ac2-breadcrumb">
        <a href="{{ route('admin.announcements.index') }}">Announcements</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">New</span>
    </nav>

    <div class="ac2-heading">
        <div class="ac2-heading-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/><path d="M12 5V3"/></svg></div>
        <div><h4>New Announcement</h4><p>Set title, status, date range and publish.</p></div>
    </div>

    @if($errors->any())
        <div class="ac2-alert ac2-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.announcements.store') }}">
        @csrf
        <div class="ac2-layout">
            <div class="ac2-main">

                {{-- Details --}}
                <div class="ac2-card">
                    <div class="ac2-card-header">
                        <div class="ac2-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                        <h6>Announcement Details</h6>
                    </div>
                    <div class="ac2-card-body">
                        <div class="ac2-gap">
                            <div>
                                <label class="ac2-label">Title <span class="req">*</span></label>
                                <input type="text" name="title" id="titleInput" class="ac2-input @error('title') is-invalid @enderror" value="{{ old('title') }}" oninput="autoSlug()" placeholder="e.g. New Office Hours — December 2025" required>
                                @error('title')<p class="ac2-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ac2-label">Slug</label>
                                <div class="ac2-slug-wrap">
                                    <span class="ac2-slug-prefix">announcement/</span>
                                    <input type="text" name="slug" id="slugInput" class="ac2-input ac2-slug-input @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="auto-from-title">
                                </div>
                                <p class="ac2-hint">Leave blank to auto-generate.</p>
                                @error('slug')<p class="ac2-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ac2-label">Content</label>
                                <textarea name="content" id="contentArea" class="ac2-textarea @error('content') is-invalid @enderror" placeholder="Announcement body text — can be HTML or plain text.">{{ old('content') }}</textarea>
                                @error('content')<p class="ac2-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Date Range --}}
                <div class="ac2-card">
                    <div class="ac2-card-header">
                        <div class="ac2-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div>
                        <h6>Date Range</h6>
                    </div>
                    <div class="ac2-card-body">
                        <div class="ac2-row-2">
                            <div>
                                <label class="ac2-label">Start Date</label>
                                <input type="date" name="start_date" class="ac2-input @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}">
                                @error('start_date')<p class="ac2-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ac2-label">End Date</label>
                                <input type="date" name="end_date" class="ac2-input @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}">
                                @error('end_date')<p class="ac2-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ac2-submit-bar">
                    <a href="{{ route('admin.announcements.index') }}" class="ac2-btn ac2-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        Cancel
                    </a>
                    <button type="submit" class="ac2-btn ac2-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        Create Announcement
                    </button>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="ac2-side">

                {{-- Status --}}
                <div class="ac2-card">
                    <div class="ac2-card-header">
                        <div class="ac2-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
                        <h6>Status</h6>
                    </div>
                    <div class="ac2-card-body">
                        <div class="ac2-status-grid">
                            @foreach([
                                'active'   => ['dot'=>'var(--green)',   'desc'=>'Visible to admin only'],
                                'paid'     => ['dot'=>'#3b82f6',         'desc'=>'Live on public site'],
                                'pending'  => ['dot'=>'var(--amber)',    'desc'=>'Awaiting review'],
                                'inactive' => ['dot'=>'var(--muted)',    'desc'=>'Hidden'],
                                'expired'  => ['dot'=>'var(--danger)',   'desc'=>'Past end date'],
                            ] as $val => $meta)
                                <input type="radio" name="status" id="status_{{ $val }}" value="{{ $val }}" class="ac2-status-radio"
                                    {{ old('status','pending') === $val ? 'checked' : '' }} required>
                                <label for="status_{{ $val }}" class="ac2-status-label">
                                    <span class="ac2-status-dot" style="background:{{ $meta['dot'] }}"></span>
                                    {{ ucfirst($val) }}
                                    <span class="ac2-status-desc">— {{ $meta['desc'] }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('status')<p class="ac2-error" style="margin-top:.5rem">{{ $message }}</p>@enderror

                        <div style="margin-top:.85rem;padding:.75rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.77rem;color:#1d4ed8;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:.3rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            Only <strong>Paid</strong> shows publicly.
                        </div>
                    </div>
                </div>

                {{-- Live preview --}}
                <div class="ac2-preview">
                    <div class="ac2-preview-banner"></div>
                    <div class="ac2-preview-body">
                        <p class="ac2-preview-title" id="previewTitle" style="color:var(--muted);font-style:italic;font-weight:400">Enter title…</p>
                        <p class="ac2-preview-slug" id="previewSlug">announcement/—</p>
                        <p style="font-size:.75rem;color:var(--muted)">Created by {{ Auth::user()->name }}</p>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
function autoSlug(){
    const t=document.getElementById('titleInput').value;
    const s=document.getElementById('slugInput');
    const pTitle=document.getElementById('previewTitle');
    const pSlug=document.getElementById('previewSlug');
    if(!s.dataset.manual){
        s.value=t.toLowerCase().trim().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
    }
    if(t){pTitle.textContent=t;pTitle.style.cssText='font-size:.9rem;font-weight:700;color:var(--text);margin:0 0 .25rem;word-break:break-word;';}
    else{pTitle.textContent='Enter title…';pTitle.style.cssText='color:var(--muted);font-style:italic;font-weight:400;';}
    pSlug.textContent='announcement/'+(s.value||'—');
}
document.getElementById('slugInput').addEventListener('input',function(){
    this.dataset.manual='1';
    document.getElementById('previewSlug').textContent='announcement/'+(this.value||'—');
});
</script>
@endsection