
@extends('layouts.app')
@section('title', $announcement->title . ' — Announcement')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--violet:#7c3aed;--violet-lt:#8b5cf6;--green:#22c55e;--amber:#f59e0b;--red:#ef4444;--sky:#0ea5e9;}
    .as3-page{padding:1.75rem 0 3rem;max-width:1160px;margin:0 auto;}
    .as3-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .as3-breadcrumb a{color:var(--muted);text-decoration:none;}.as3-breadcrumb a:hover{color:var(--violet);}
    .as3-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .as3-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .as3-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .as3-layout{display:grid;grid-template-columns:1fr 280px;gap:1.25rem;align-items:start;}
    .as3-main{display:flex;flex-direction:column;gap:1.25rem;}
    .as3-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .as3-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .as3-btn-primary{background:var(--violet);color:#fff;}.as3-btn-primary:hover{background:var(--violet-lt);color:#fff;}
    .as3-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.as3-btn-ghost:hover{border-color:var(--violet);color:var(--violet);}
    .as3-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.as3-btn-danger:hover{background:#fef2f2;}
    .as3-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    /* hero */
    .as3-hero{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .as3-hero-banner{height:6px;background:linear-gradient(90deg,var(--violet),var(--violet-lt),#a78bfa);}
    .as3-hero-body{padding:1.75rem 2rem;}
    .as3-hero-meta{display:flex;flex-wrap:wrap;align-items:center;gap:.75rem;font-size:.8rem;color:var(--muted);margin-bottom:.85rem;}
    .as3-hero-meta span{display:flex;align-items:center;gap:.3rem;}
    .as3-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.24rem .7rem;border-radius:100px;font-size:.71rem;font-weight:600;white-space:nowrap;}
    .as3-badge-dot{width:6px;height:6px;border-radius:50%;background:currentColor;}
    .as3-badge.active  {background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .as3-badge.paid    {background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;}
    .as3-badge.pending {background:#fffbeb;border:1px solid #fde68a;color:#92400e;}
    .as3-badge.expired {background:#fef2f2;border:1px solid #fecaca;color:#991b1b;}
    .as3-badge.inactive{background:var(--surface);border:1px solid var(--border);color:var(--muted);}
    .as3-hero-title{font-size:1.45rem;font-weight:700;color:var(--text);margin:0 0 .3rem;line-height:1.3;}
    .as3-hero-slug{font-size:.8rem;font-family:monospace;color:var(--muted);margin-bottom:1.25rem;}
    .as3-hero-actions{display:flex;gap:.5rem;flex-wrap:wrap;padding-top:1.25rem;border-top:1px solid var(--border);}
    /* cards */
    .as3-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .as3-card-header{display:flex;align-items:center;gap:.75rem;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .as3-card-header-icon{width:30px;height:30px;border-radius:7px;background:#7c3aed14;display:flex;align-items:center;justify-content:center;color:var(--violet);flex-shrink:0;}
    .as3-card-header h6{margin:0;font-size:.86rem;font-weight:600;color:var(--text);}
    .as3-card-action{margin-left:auto;}
    .as3-card-body{padding:1.4rem;}
    /* content */
    .as3-content{font-size:.92rem;color:var(--text-dim);line-height:1.85;white-space:pre-line;}
    /* info grid */
    .as3-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--border);border:1px solid var(--border);border-radius:8px;overflow:hidden;}
    .as3-info-cell{background:#fff;padding:.85rem 1rem;transition:background .15s;}
    .as3-info-cell:hover{background:var(--surface);}
    .as3-info-key{font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:.3rem;}
    .as3-info-val{font-size:.88rem;color:var(--text);font-weight:500;}
    .as3-info-val.violet{color:var(--violet);}
    .as3-info-val.mono{font-family:monospace;font-size:.82rem;}
    .as3-info-val.muted{color:var(--muted);font-style:italic;font-weight:400;}
    /* date card */
    .as3-date-range{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .as3-date-box{padding:1rem;border-radius:8px;border:1px solid var(--border);background:var(--surface);text-align:center;}
    .as3-date-box-label{font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:.35rem;}
    .as3-date-box-val{font-size:1rem;font-weight:700;color:var(--text);}
    .as3-date-box-sub{font-size:.72rem;color:var(--muted);margin-top:.2rem;}
    /* actions */
    .as3-action-btn{display:flex;align-items:center;gap:.6rem;padding:.65rem .9rem;border-radius:8px;border:1.5px solid var(--border);background:none;font-family:inherit;font-size:.82rem;font-weight:500;cursor:pointer;transition:all .15s;color:var(--text-dim);text-align:left;width:100%;text-decoration:none;}
    .as3-action-btn:hover{border-color:var(--violet);color:var(--text);background:#7c3aed04;}
    .as3-action-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    .as3-actions-list{display:flex;flex-direction:column;gap:.5rem;}
    /* status change card */
    .as3-status-grid{display:grid;grid-template-columns:1fr;gap:.35rem;}
    .as3-st-radio{display:none;}
    .as3-st-label{display:flex;align-items:center;gap:.5rem;padding:.5rem .75rem;border:1.5px solid var(--border);border-radius:7px;font-size:.79rem;color:var(--text-dim);cursor:pointer;transition:all .15s;user-select:none;font-weight:500;}
    .as3-st-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0;}
    .as3-st-radio[value="active"]:checked   +.as3-st-label{border-color:var(--green);background:#f0fdf4;color:#166534;}
    .as3-st-radio[value="paid"]:checked     +.as3-st-label{border-color:#bfdbfe;background:#eff6ff;color:#1d4ed8;}
    .as3-st-radio[value="pending"]:checked  +.as3-st-label{border-color:#fde68a;background:#fffbeb;color:#92400e;}
    .as3-st-radio[value="expired"]:checked  +.as3-st-label{border-color:#fecaca;background:#fef2f2;color:#991b1b;}
    .as3-st-radio[value="inactive"]:checked +.as3-st-label{border-color:var(--border);background:var(--surface);color:var(--muted);}
    /* timeline */
    .as3-tl{display:flex;flex-direction:column;}
    .as3-tl-item{display:flex;gap:1rem;padding-bottom:1.25rem;}
    .as3-tl-item:last-child{padding-bottom:0;}
    .as3-tl-left{display:flex;flex-direction:column;align-items:center;flex-shrink:0;}
    .as3-tl-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid var(--border);background:#fff;color:var(--muted);flex-shrink:0;}
    .as3-tl-dot.violet{border-color:#ddd6fe;background:#f5f3ff;color:var(--violet);}
    .as3-tl-dot.green{border-color:#bbf7d0;background:#f0fdf4;color:var(--green);}
    .as3-tl-line{width:1px;flex:1;background:var(--border);margin-top:4px;min-height:16px;}
    .as3-tl-item:last-child .as3-tl-line{display:none;}
    .as3-tl-content{flex:1;padding-top:.2rem;}
    .as3-tl-title{font-size:.86rem;font-weight:600;color:var(--text);}
    .as3-tl-meta{font-size:.76rem;color:var(--muted);margin-top:.2rem;}
    /* modal */
    .as3-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .as3-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .as3-modal-icon{width:30px;height:30px;border-radius:7px;background:#fef2f2;color:var(--danger);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .as3-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--danger);margin:0;}
    .as3-modal .modal-body,.as3-modal .modal-footer{padding:1.4rem;}
    .as3-modal .modal-footer{border-top:1px solid var(--border);gap:.5rem;}
    .as3-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .as3-delete-box strong{color:var(--text);}
    @media(max-width:960px){.as3-layout{grid-template-columns:1fr;}.as3-side{position:static;}.as3-info-grid,.as3-date-range{grid-template-columns:1fr;}}
</style>

<div class="as3-page">
    <nav class="as3-breadcrumb">
        <a href="{{ route('admin.announcements.index') }}">Announcements</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">{{ Str::limit($announcement->title, 50) }}</span>
    </nav>

    @if(session('success'))
        <div class="as3-alert as3-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="as3-alert as3-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="as3-layout">
        {{-- Main --}}
        <div class="as3-main">

            {{-- Hero --}}
            <div class="as3-hero">
                <div class="as3-hero-banner"></div>
                <div class="as3-hero-body">
                    <div class="as3-hero-meta">
                        <span class="as3-badge {{ $announcement->status }}">
                            <span class="as3-badge-dot"></span>
                            {{ ucfirst($announcement->status) }}
                            @if($announcement->status === 'paid')<span style="font-size:.68rem;opacity:.75"> — visible to public</span>@endif
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            {{ $announcement->creator?->name ?? '—' }}
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $announcement->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <h1 class="as3-hero-title">{{ $announcement->title }}</h1>
                    <p class="as3-hero-slug">announcement/{{ $announcement->slug }}</p>
                    <div class="as3-hero-actions">
                        <a href="{{ route('admin.announcements.edit',$announcement->id) }}" class="as3-btn as3-btn-primary as3-btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <button class="as3-btn as3-btn-danger as3-btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            {{-- Details grid --}}
            <div class="as3-card">
                <div class="as3-card-header">
                    <div class="as3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                    <h6>Details</h6>
                    <a href="{{ route('admin.announcements.edit',$announcement->id) }}" class="as3-card-action as3-btn as3-btn-ghost as3-btn-sm">Edit</a>
                </div>
                <div class="as3-card-body" style="padding:0">
                    <div class="as3-info-grid">
                        <div class="as3-info-cell"><div class="as3-info-key">Title</div><div class="as3-info-val">{{ $announcement->title }}</div></div>
                        <div class="as3-info-cell"><div class="as3-info-key">Slug</div><div class="as3-info-val mono">{{ $announcement->slug }}</div></div>
                        <div class="as3-info-cell"><div class="as3-info-key">Status</div>
                            <div class="as3-info-val">
                                <span class="as3-badge {{ $announcement->status }}"><span class="as3-badge-dot"></span>{{ ucfirst($announcement->status) }}</span>
                            </div>
                        </div>
                        <div class="as3-info-cell"><div class="as3-info-key">Created By</div><div class="as3-info-val">{{ $announcement->creator?->name ?? '—' }}</div></div>
                        <div class="as3-info-cell"><div class="as3-info-key">Created</div><div class="as3-info-val">{{ $announcement->created_at->format('M j, Y g:i A') }}</div></div>
                        <div class="as3-info-cell"><div class="as3-info-key">Last Updated</div><div class="as3-info-val">{{ $announcement->updated_at->diffForHumans() }}</div></div>
                    </div>
                </div>
            </div>

            {{-- Date range --}}
            @if($announcement->start_date || $announcement->end_date)
                <div class="as3-card">
                    <div class="as3-card-header">
                        <div class="as3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div>
                        <h6>Date Range</h6>
                    </div>
                    <div class="as3-card-body">
                        <div class="as3-date-range">
                            <div class="as3-date-box">
                                <div class="as3-date-box-label">Start Date</div>
                                @if($announcement->start_date)
                                    <div class="as3-date-box-val">{{ $announcement->start_date->format('M j, Y') }}</div>
                                    <div class="as3-date-box-sub">{{ $announcement->start_date->diffForHumans() }}</div>
                                @else
                                    <div class="as3-date-box-val" style="color:var(--muted);font-size:.85rem;font-style:italic">Not set</div>
                                @endif
                            </div>
                            <div class="as3-date-box">
                                <div class="as3-date-box-label">End Date</div>
                                @if($announcement->end_date)
                                    @php $isOver = $announcement->end_date < now(); @endphp
                                    <div class="as3-date-box-val" style="{{ $isOver ? 'color:var(--red)' : '' }}">{{ $announcement->end_date->format('M j, Y') }}</div>
                                    <div class="as3-date-box-sub">{{ $isOver ? 'Expired ' : '' }}{{ $announcement->end_date->diffForHumans() }}</div>
                                @else
                                    <div class="as3-date-box-val" style="color:var(--muted);font-size:.85rem;font-style:italic">Not set</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Content --}}
            @if($announcement->content)
                <div class="as3-card">
                    <div class="as3-card-header">
                        <div class="as3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                        <h6>Content</h6>
                    </div>
                    <div class="as3-card-body">
                        <div class="as3-content">{!! $announcement->content !!}</div>
                    </div>
                </div>
            @endif

        </div>

        {{-- Side --}}
        <div class="as3-side">

            {{-- Change status --}}
            <div class="as3-card">
                <div class="as3-card-header">
                    <div class="as3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
                    <h6>Change Status</h6>
                </div>
                <div class="as3-card-body">
                    <form method="POST" action="{{ route('admin.announcements.status',$announcement->id) }}">
                        @csrf @method('PATCH')
                        <div class="as3-status-grid">
                            @foreach(['active'=>['var(--green)','Admin only'],'paid'=>['#3b82f6','Live — public'],'pending'=>['var(--amber)','Awaiting'],'inactive'=>['var(--muted)','Hidden'],'expired'=>['var(--danger)','Past end']] as $val=>$meta)
                                <input type="radio" name="status" id="show_st_{{ $val }}" value="{{ $val }}" class="as3-st-radio" {{ $announcement->status === $val ? 'checked' : '' }}>
                                <label for="show_st_{{ $val }}" class="as3-st-label"><span class="as3-st-dot" style="background:{{ $meta[0] }}"></span>{{ ucfirst($val) }} <span style="font-size:.68rem;opacity:.7;margin-left:.1rem">— {{ $meta[1] }}</span></label>
                            @endforeach
                        </div>
                        <button type="submit" class="as3-btn as3-btn-primary" style="width:100%;justify-content:center;margin-top:.85rem;font-size:.82rem;padding:.58rem 1rem;">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="as3-card">
                <div class="as3-card-header">
                    <div class="as3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg></div>
                    <h6>Quick Actions</h6>
                </div>
                <div class="as3-card-body">
                    <div class="as3-actions-list">
                        <a href="{{ route('admin.announcements.edit',$announcement->id) }}" class="as3-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Details
                        </a>
                        <button class="as3-action-btn danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            Move to Trash
                        </button>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="as3-card">
                <div class="as3-card-header">
                    <div class="as3-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <h6>Activity</h6>
                </div>
                <div class="as3-card-body">
                    <div class="as3-tl">
                        <div class="as3-tl-item">
                            <div class="as3-tl-left"><div class="as3-tl-dot violet"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></div><div class="as3-tl-line"></div></div>
                            <div class="as3-tl-content"><div class="as3-tl-title">Created</div><div class="as3-tl-meta">{{ $announcement->created_at->format('F j, Y g:i A') }} by {{ $announcement->creator?->name }}</div></div>
                        </div>
                        <div class="as3-tl-item">
                            <div class="as3-tl-left"><div class="as3-tl-dot {{ $announcement->status === 'paid' ? 'green' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div><div class="as3-tl-line"></div></div>
                            <div class="as3-tl-content"><div class="as3-tl-title">Status: {{ ucfirst($announcement->status) }}</div><div class="as3-tl-meta">Current status</div></div>
                        </div>
                        <div class="as3-tl-item">
                            <div class="as3-tl-left"><div class="as3-tl-dot"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></div></div>
                            <div class="as3-tl-content"><div class="as3-tl-title">Last updated</div><div class="as3-tl-meta">{{ $announcement->updated_at->format('F j, Y g:i A') }} — {{ $announcement->updated_at->diffForHumans() }}</div></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── VIEW ANALYTICS CARD ─────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">👁 View Analytics</h6>
                    @if($announcement->status !== 'active')
                    <span style="font-size:.68rem;color:#7A736B;background:#F5F5F5;padding:2px 8px;border-radius:10px">
                        Only tracked when active
                    </span>
                    @endif
                </div>

                {{-- Top counters ── --}}
                <div class="card-body p-0">
                    <div class="row g-0" style="border-bottom:1px solid #E8E3DC">

                        {{-- Total views --}}
                        <div class="col-6" style="padding:16px 20px;border-right:1px solid #E8E3DC">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Total Views</div>
                            <div style="font-size:1.6rem;font-weight:800;color:var(--terra-navy);line-height:1">
                                {{ number_format($viewStats['total']) }}
                            </div>
                            <div style="font-size:.7rem;color:#7A736B;margin-top:3px">all time</div>
                        </div>

                        {{-- Unique views --}}
                        <div class="col-6" style="padding:16px 20px">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Unique Visitors</div>
                            <div style="font-size:1.6rem;font-weight:800;color:#1a5276;line-height:1">
                                {{ number_format($viewStats['unique']) }}
                            </div>
                            <div style="font-size:.7rem;color:#7A736B;margin-top:3px">distinct IPs</div>
                        </div>
                    </div>

                    {{-- Period breakdown ── --}}
                    <div style="padding:12px 20px;border-bottom:1px solid #E8E3DC">
                        @php
                        $periods = [
                        ['label' => 'Today', 'value' => $viewStats['today']],
                        ['label' => 'This Week', 'value' => $viewStats['this_week']],
                        ['label' => 'This Month', 'value' => $viewStats['this_month']],
                        ];
                        // Compute the max for the tiny bar widths
                        $maxPeriod = max(max(array_column($periods, 'value')), 1);
                        @endphp

                        @foreach($periods as $period)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div style="width:72px;font-size:.72rem;color:#7A736B;flex-shrink:0">{{ $period['label'] }}</div>
                            <div style="flex:1;height:6px;background:#F0EDE8;border-radius:3px;overflow:hidden">
                                <div style="height:100%;width:{{ $maxPeriod > 0 ? round(($period['value'] / $maxPeriod) * 100) : 0 }}%;background:var(--terra-navy);border-radius:3px;transition:width .4s ease"></div>
                            </div>
                            <div style="width:28px;text-align:right;font-size:.78rem;font-weight:700;color:var(--terra-navy);flex-shrink:0">
                                {{ number_format($period['value']) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- 14-day sparkline ── --}}
                    <div style="padding:16px 20px">
                        <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px">
                            Last 14 Days
                        </div>

                        @php
                        $chartData = $viewStats['daily_chart']; // ['Y-m-d' => count]
                        $chartMax = max(array_values($chartData) ?: [1]);
                        $chartDates = array_keys($chartData);
                        $chartVals = array_values($chartData);
                        $barCount = count($chartVals);
                        @endphp

                        @if(array_sum($chartVals) === 0)
                        <div style="text-align:center;padding:20px 0;color:#7A736B;font-size:.78rem">
                            No views recorded in the last 14 days.
                        </div>
                        @else
                        {{-- SVG sparkline --}}
                        <svg viewBox="0 0 280 60" xmlns="http://www.w3.org/2000/svg"
                            style="width:100%;height:60px;overflow:visible"
                            aria-label="Daily views chart">

                            {{-- Grid lines --}}
                            <line x1="0" y1="0" x2="280" y2="0" stroke="#E8E3DC" stroke-width=".5" />
                            <line x1="0" y1="30" x2="280" y2="30" stroke="#E8E3DC" stroke-width=".5" stroke-dasharray="3,3" />
                            <line x1="0" y1="59" x2="280" y2="59" stroke="#E8E3DC" stroke-width=".5" />

                            @php
                            $barW = floor(280 / $barCount) - 2;
                            $barW = max($barW, 4);
                            $gap = (280 - ($barW * $barCount)) / ($barCount + 1);
                            @endphp

                            @foreach($chartVals as $i => $val)
                            @php
                            $barH = $chartMax > 0 ? max(2, round(($val / $chartMax) * 56)) : 2;
                            $x = round($gap + $i * ($barW + $gap));
                            $y = 58 - $barH;
                            $isLast = $i === $barCount - 1;
                            @endphp
                            <rect x="{{ $x }}" y="{{ $y }}"
                                width="{{ $barW }}" height="{{ $barH }}"
                                rx="2"
                                fill="{{ $isLast ? 'var(--terra-navy, #19265d)' : '#B8C5D6' }}"
                                opacity="{{ $isLast ? '1' : '0.6' }}">
                                <title>{{ $chartDates[$i] }}: {{ $val }} view{{ $val === 1 ? '' : 's' }}</title>
                            </rect>
                            @endforeach
                        </svg>

                        {{-- x-axis labels: first, mid, last --}}
                        <div style="display:flex;justify-content:space-between;margin-top:4px">
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse($chartDates[0])->format('d M') }}
                            </span>
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse($chartDates[floor($barCount/2)])->format('d M') }}
                            </span>
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse(end($chartDates))->format('d M') }}
                            </span>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade as3-modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.announcements.destroy',$announcement->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="as3-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                <h5 class="modal-title">Move to Trash</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="as3-delete-box">Move <strong>{{ $announcement->title }}</strong> to Trash? It will be hidden but can be restored from the Trash view.<br><br><span style="font-size:.79rem;color:var(--amber)">⚠ Soft delete — restorable.</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="as3-btn as3-btn-ghost as3-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="as3-btn as3-btn-danger as3-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Move to Trash
                </button>
            </div>
        </form>
    </div>
</div>

@endsection