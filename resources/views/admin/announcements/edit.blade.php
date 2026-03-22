{{-- ================================================================
     SAVE AS: resources/views/admin/announcements/edit.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'Edit Announcement — ' . $announcement->title)
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--violet:#7c3aed;--violet-lt:#8b5cf6;--green:#22c55e;--amber:#f59e0b;}
    .ae3-page{padding:1.75rem 0 3rem;max-width:940px;margin:0 auto;}
    .ae3-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .ae3-breadcrumb a{color:var(--muted);text-decoration:none;}.ae3-breadcrumb a:hover{color:var(--violet);}
    .ae3-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;}
    .ae3-heading-icon{width:42px;height:42px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#7c3aed18,#7c3aed30);border:1px solid #7c3aed30;display:flex;align-items:center;justify-content:center;color:var(--violet);}
    .ae3-heading h4{font-size:1.15rem;font-weight:700;color:var(--text);margin:0;}
    .ae3-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .ae3-heading-meta{margin-left:auto;display:flex;align-items:center;gap:.6rem;}
    .ae3-layout{display:grid;grid-template-columns:1fr 260px;gap:1.25rem;align-items:start;}
    .ae3-main{display:flex;flex-direction:column;gap:1.25rem;}
    .ae3-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .ae3-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ae3-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .ae3-card-header-icon{width:32px;height:32px;border-radius:8px;background:#7c3aed14;display:flex;align-items:center;justify-content:center;color:var(--violet);flex-shrink:0;}
    .ae3-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .ae3-card-body{padding:1.5rem;}
    .ae3-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .ae3-label .req{color:var(--danger);margin-left:.2rem;}
    .ae3-input,.ae3-select,.ae3-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .ae3-input:focus,.ae3-select:focus,.ae3-textarea:focus{border-color:var(--violet);box-shadow:0 0 0 3px rgba(124,58,237,.1);}
    .ae3-input.is-invalid{border-color:var(--danger);}
    .ae3-textarea{resize:vertical;line-height:1.7;min-height:200px;}
    .ae3-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .ae3-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;}
    .ae3-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .ae3-gap{display:flex;flex-direction:column;gap:1rem;}
    .ae3-slug-wrap{position:relative;}
    .ae3-slug-prefix{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);font-size:.8rem;color:var(--muted);pointer-events:none;font-family:monospace;}
    .ae3-slug-input{padding-left:8rem!important;font-family:monospace;font-size:.84rem;}
    .ae3-status-grid{display:grid;grid-template-columns:1fr;gap:.4rem;}
    .ae3-status-radio{display:none;}
    .ae3-status-label{display:flex;align-items:center;gap:.6rem;padding:.6rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);cursor:pointer;transition:all .15s;user-select:none;font-weight:500;}
    .ae3-status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .ae3-status-radio[value="active"]:checked   +.ae3-status-label{border-color:var(--green);background:#f0fdf4;color:#166534;}
    .ae3-status-radio[value="paid"]:checked     +.ae3-status-label{border-color:#bfdbfe;background:#eff6ff;color:#1d4ed8;}
    .ae3-status-radio[value="pending"]:checked  +.ae3-status-label{border-color:#fde68a;background:#fffbeb;color:#92400e;}
    .ae3-status-radio[value="expired"]:checked  +.ae3-status-label{border-color:#fecaca;background:#fef2f2;color:#991b1b;}
    .ae3-status-radio[value="inactive"]:checked +.ae3-status-label{border-color:var(--border);background:var(--surface);color:var(--muted);}
    .ae3-status-desc{font-size:.7rem;margin-left:.15rem;opacity:.75;}
    .ae3-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .ae3-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .ae3-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .ae3-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .ae3-alert li{margin-bottom:.2rem;}
    .ae3-submit-bar{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .ae3-submit-bar-left{font-size:.78rem;color:var(--muted);display:flex;align-items:center;gap:.4rem;}
    .ae3-submit-bar-right{display:flex;gap:.6rem;}
    .ae3-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .ae3-btn-primary{background:var(--violet);color:#fff;}.ae3-btn-primary:hover{background:var(--violet-lt);color:#fff;transform:translateY(-1px);}
    .ae3-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.ae3-btn-ghost:hover{border-color:var(--violet);color:var(--violet);}
    .ae3-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.ae3-btn-danger:hover{background:#fef2f2;}
    .ae3-btn-sm{padding:.42rem .9rem;font-size:.78rem;}
    .ae3-status-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.24rem .7rem;border-radius:100px;font-size:.7rem;font-weight:600;border:1px solid;}
    @media(max-width:860px){.ae3-layout{grid-template-columns:1fr;}.ae3-side{position:static;}.ae3-row-2{grid-template-columns:1fr;}}
</style>

<div class="ae3-page">
    <nav class="ae3-breadcrumb">
        <a href="{{ route('admin.announcements.index') }}">Announcements</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('admin.announcements.show',$announcement->id) }}">{{ Str::limit($announcement->title,40) }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Edit</span>
    </nav>

    <div class="ae3-heading">
        <div class="ae3-heading-icon"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
        <div>
            <h4>Edit Announcement</h4>
            <p>{{ $announcement->title }} — updated {{ $announcement->updated_at->diffForHumans() }}</p>
        </div>
        <div class="ae3-heading-meta">
            @php $sc = ['active'=>'color:#166534;border-color:#bbf7d0;background:#f0fdf4','paid'=>'color:#1d4ed8;border-color:#bfdbfe;background:#eff6ff','pending'=>'color:#92400e;border-color:#fde68a;background:#fffbeb','expired'=>'color:#991b1b;border-color:#fecaca;background:#fef2f2','inactive'=>'color:var(--muted);border-color:var(--border);background:var(--surface)'][$announcement->status] ?? ''; @endphp
            <span class="ae3-status-badge" style="{{ $sc }}">{{ ucfirst($announcement->status) }}</span>
            <a href="{{ route('admin.announcements.show',$announcement->id) }}" class="ae3-btn ae3-btn-ghost ae3-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="ae3-alert ae3-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif
    @if(session('success'))
        <div class="ae3-alert ae3-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.announcements.update',$announcement->id) }}">
        @csrf @method('PUT')
        <div class="ae3-layout">
            <div class="ae3-main">

                <div class="ae3-card">
                    <div class="ae3-card-header">
                        <div class="ae3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                        <h6>Announcement Details</h6>
                    </div>
                    <div class="ae3-card-body">
                        <div class="ae3-gap">
                            <div>
                                <label class="ae3-label">Title <span class="req">*</span></label>
                                <input type="text" name="title" class="ae3-input @error('title') is-invalid @enderror" value="{{ old('title',$announcement->title) }}" required>
                                @error('title')<p class="ae3-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ae3-label">Slug</label>
                                <div class="ae3-slug-wrap">
                                    <span class="ae3-slug-prefix">announcement/</span>
                                    <input type="text" name="slug" class="ae3-input ae3-slug-input @error('slug') is-invalid @enderror" value="{{ old('slug',$announcement->slug) }}">
                                </div>
                                @error('slug')<p class="ae3-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ae3-label">Content</label>
                                <textarea name="content" class="ae3-textarea @error('content') is-invalid @enderror">{{ old('content',$announcement->content) }}</textarea>
                                @error('content')<p class="ae3-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ae3-card">
                    <div class="ae3-card-header">
                        <div class="ae3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div>
                        <h6>Date Range</h6>
                    </div>
                    <div class="ae3-card-body">
                        <div class="ae3-row-2">
                            <div>
                                <label class="ae3-label">Start Date</label>
                                <input type="date" name="start_date" class="ae3-input @error('start_date') is-invalid @enderror" value="{{ old('start_date',$announcement->start_date?->format('Y-m-d')) }}">
                                @error('start_date')<p class="ae3-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ae3-label">End Date</label>
                                <input type="date" name="end_date" class="ae3-input @error('end_date') is-invalid @enderror" value="{{ old('end_date',$announcement->end_date?->format('Y-m-d')) }}">
                                @error('end_date')<p class="ae3-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ae3-submit-bar">
                    <div class="ae3-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $announcement->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="ae3-submit-bar-right">
                        <a href="{{ route('admin.announcements.show',$announcement->id) }}" class="ae3-btn ae3-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="ae3-btn ae3-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="ae3-side">

                {{-- Status --}}
                <div class="ae3-card">
                    <div class="ae3-card-header">
                        <div class="ae3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
                        <h6>Status</h6>
                    </div>
                    <div class="ae3-card-body">
                        <div class="ae3-status-grid">
                            @foreach(['active'=>['var(--green)','Admin only'],'paid'=>['#3b82f6','Live — public'],'pending'=>['var(--amber)','Awaiting review'],'inactive'=>['var(--muted)','Hidden'],'expired'=>['var(--danger)','Past end date']] as $val=>$meta)
                                <input type="radio" name="status" id="st_{{ $val }}" value="{{ $val }}" class="ae3-status-radio"
                                    {{ old('status',$announcement->status) === $val ? 'checked' : '' }}>
                                <label for="st_{{ $val }}" class="ae3-status-label">
                                    <span class="ae3-status-dot" style="background:{{ $meta[0] }}"></span>
                                    {{ ucfirst($val) }} <span class="ae3-status-desc">— {{ $meta[1] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Meta --}}
                <div class="ae3-card">
                    <div class="ae3-card-header">
                        <div class="ae3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                        <h6>Info</h6>
                    </div>
                    <div class="ae3-card-body">
                        <div style="display:flex;flex-direction:column;gap:.6rem;font-size:.81rem;color:var(--text-dim);">
                            <div style="display:flex;justify-content:space-between;"><span style="color:var(--muted)">Created by</span><span>{{ $announcement->creator?->name ?? '—' }}</span></div>
                            <div style="display:flex;justify-content:space-between;"><span style="color:var(--muted)">Created</span><span>{{ $announcement->created_at->format('M j, Y') }}</span></div>
                            <div style="display:flex;justify-content:space-between;"><span style="color:var(--muted)">Last updated</span><span>{{ $announcement->updated_at->diffForHumans() }}</span></div>
                        </div>
                    </div>
                </div>

                {{-- Danger --}}
                <div class="ae3-card" style="border-color:#fecaca;">
                    <div class="ae3-card-header" style="background:#fef2f2;border-color:#fecaca;">
                        <div class="ae3-card-header-icon" style="background:#fee2e2;color:var(--danger);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/></svg></div>
                        <h6 style="color:var(--danger)">Danger Zone</h6>
                    </div>
                    <div class="ae3-card-body">
                        <p style="font-size:.8rem;color:var(--muted);margin-bottom:.85rem;line-height:1.55;">Moves this announcement to Trash (soft delete). It can be restored.</p>
                        <form method="POST" action="{{ route('admin.announcements.destroy',$announcement->id) }}" onsubmit="return confirm('Move to trash?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="ae3-btn ae3-btn-danger" style="width:100%;justify-content:center;font-size:.82rem;padding:.55rem 1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                                Move to Trash
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection