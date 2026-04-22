@extends('layouts.app')
@section('title', $tender->title . ' — Tender')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--indigo:#4f46e5;--indigo-lt:#6366f1;--green:#22c55e;--amber:#f59e0b;--red:#ef4444;}
    .ts-page{padding:1.75rem 0 3rem;max-width:1160px;margin:0 auto;}
    .ts-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .ts-breadcrumb a{color:var(--muted);text-decoration:none;}.ts-breadcrumb a:hover{color:var(--indigo);}
    .ts-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .ts-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .ts-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .ts-layout{display:grid;grid-template-columns:1fr 300px;gap:1.25rem;align-items:start;}
    .ts-main{display:flex;flex-direction:column;gap:1.25rem;}
    .ts-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    /* Buttons */
    .ts-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .ts-btn-primary{background:var(--indigo);color:#fff;}.ts-btn-primary:hover{background:var(--indigo-lt);color:#fff;}
    .ts-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.ts-btn-ghost:hover{border-color:var(--indigo);color:var(--indigo);}
    .ts-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.ts-btn-danger:hover{background:#fef2f2;}
    .ts-btn-warning{background:none;border:1.5px solid #fde68a;color:#92400e;}.ts-btn-warning:hover{background:#fffbeb;}
    .ts-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    /* Hero */
    .ts-hero{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ts-hero-banner{height:8px;background:linear-gradient(90deg,var(--indigo),var(--indigo-lt),#818cf8);}
    .ts-hero-body{padding:1.75rem 2rem;}
    .ts-hero-top{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.25rem;}
    .ts-hero-icon{width:48px;height:48px;border-radius:10px;background:#4f46e512;border:1px solid #4f46e520;display:flex;align-items:center;justify-content:center;color:var(--indigo);flex-shrink:0;}
    .ts-hero-title{font-size:1.25rem;font-weight:700;color:var(--text);margin:0 0 .35rem;line-height:1.3;}
    .ts-hero-meta{display:flex;flex-wrap:wrap;align-items:center;gap:.75rem;font-size:.8rem;color:var(--muted);}
    .ts-hero-meta span{display:flex;align-items:center;gap:.3rem;}
    .ts-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.24rem .7rem;border-radius:100px;font-size:.71rem;font-weight:600;white-space:nowrap;}
    .ts-badge-open{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .ts-badge-closed{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;}
    .ts-badge-expiring{background:#fffbeb;border:1px solid #fde68a;color:#92400e;}
    .ts-badge-expired{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;}
    .ts-hero-actions{display:flex;gap:.5rem;flex-wrap:wrap;}
    /* Cards */
    .ts-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ts-card-header{display:flex;align-items:center;gap:.75rem;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .ts-card-header-icon{width:30px;height:30px;border-radius:7px;background:#4f46e514;display:flex;align-items:center;justify-content:center;color:var(--indigo);flex-shrink:0;}
    .ts-card-header h6{margin:0;font-size:.86rem;font-weight:600;color:var(--text);}
    .ts-card-action{margin-left:auto;}
    .ts-card-body{padding:1.4rem;}
    /* Description */
    .ts-description{font-size:.9rem;color:var(--text-dim);line-height:1.85;white-space:pre-line;}
    /* Info grid */
    .ts-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--border);border:1px solid var(--border);border-radius:8px;overflow:hidden;}
    .ts-info-cell{background:#fff;padding:.85rem 1rem;transition:background .15s;}
    .ts-info-cell:hover{background:var(--surface);}
    .ts-info-key{font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-bottom:.3rem;}
    .ts-info-val{font-size:.88rem;color:var(--text);font-weight:500;}
    .ts-info-val.indigo{color:var(--indigo);}
    .ts-info-val.muted{color:var(--muted);font-weight:400;font-style:italic;}
    .ts-info-val.mono{font-family:monospace;font-size:.82rem;}
    /* Deadline card */
    .ts-deadline-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:1.25rem;text-align:center;}
    .ts-deadline-val{font-size:1.5rem;font-weight:700;line-height:1;margin-bottom:.3rem;}
    .ts-deadline-label{font-size:.72rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);}
    /* Document card */
    .ts-doc-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .ts-doc-inner{display:flex;align-items:center;gap:1rem;padding:1.25rem;}
    .ts-doc-icon{width:48px;height:48px;border-radius:10px;background:#fef2f2;display:flex;align-items:center;justify-content:center;color:var(--danger);flex-shrink:0;}
    .ts-doc-info strong{display:block;font-size:.87rem;color:var(--text);margin-bottom:.2rem;}
    .ts-doc-info span{font-size:.73rem;color:var(--muted);}
    /* Action btn */
    .ts-action-btn{display:flex;align-items:center;gap:.6rem;padding:.65rem .9rem;border-radius:8px;border:1.5px solid var(--border);background:none;font-family:inherit;font-size:.82rem;font-weight:500;cursor:pointer;transition:all .15s;color:var(--text-dim);text-align:left;width:100%;text-decoration:none;}
    .ts-action-btn:hover{border-color:var(--indigo);color:var(--text);background:#4f46e504;}
    .ts-action-btn.warning:hover{border-color:#fde68a;color:#92400e;background:#fffbeb;}
    .ts-action-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    .ts-action-btn.success:hover{border-color:#bbf7d0;color:var(--green);background:#f0fdf4;}
    .ts-actions-list{display:flex;flex-direction:column;gap:.5rem;}
    /* Timeline */
    .ts-tl{display:flex;flex-direction:column;}
    .ts-tl-item{display:flex;gap:1rem;padding-bottom:1.25rem;}
    .ts-tl-item:last-child{padding-bottom:0;}
    .ts-tl-left{display:flex;flex-direction:column;align-items:center;flex-shrink:0;}
    .ts-tl-dot{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid var(--border);background:#fff;color:var(--muted);flex-shrink:0;}
    .ts-tl-dot.indigo{border-color:#c7d2fe;background:#eef2ff;color:var(--indigo);}
    .ts-tl-dot.green{border-color:#bbf7d0;background:#f0fdf4;color:var(--green);}
    .ts-tl-dot.amber{border-color:#fde68a;background:#fffbeb;color:var(--amber);}
    .ts-tl-dot.red{border-color:#fecaca;background:#fef2f2;color:var(--red);}
    .ts-tl-line{width:1px;flex:1;background:var(--border);margin-top:4px;min-height:16px;}
    .ts-tl-item:last-child .ts-tl-line{display:none;}
    .ts-tl-content{flex:1;padding-top:.2rem;}
    .ts-tl-title{font-size:.86rem;font-weight:600;color:var(--text);}
    .ts-tl-meta{font-size:.76rem;color:var(--muted);margin-top:.2rem;}
    /* Modal */
    .ts-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .ts-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .ts-modal-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .ts-modal-icon.danger{background:#fef2f2;color:var(--danger);}
    .ts-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--danger);margin:0;}
    .ts-modal .modal-body{padding:1.4rem;}
    .ts-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    .ts-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .ts-delete-box strong{color:var(--text);}
    @media(max-width:960px){.ts-layout{grid-template-columns:1fr;}.ts-side{position:static;}.ts-info-grid{grid-template-columns:1fr;}}
</style>

<div class="ts-page">
    <nav class="ts-breadcrumb">
        <a href="{{ route('admin.tenders.index') }}">Tenders</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">{{ Str::limit($tender->title, 50) }}</span>
    </nav>

    @if(session('success'))
        <div class="ts-alert ts-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="ts-alert ts-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @php
        $isExpired = $tender->submission_deadline < now();
        $isUrgent  = !$isExpired && $tender->submission_deadline <= now()->addDays(7);
    @endphp

    <div class="ts-layout">
        {{-- ── MAIN ── --}}
        <div class="ts-main">

            {{-- Hero --}}
            <div class="ts-hero">
                <div class="ts-hero-banner"></div>
                <div class="ts-hero-body">
                    <div class="ts-hero-top">
                        <div style="display:flex;align-items:flex-start;gap:1rem;flex:1;min-width:0;">
                            <div class="ts-hero-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <h2 class="ts-hero-title">{{ $tender->title }}</h2>
                                <div class="ts-hero-meta">
                                    @if($tender->reference_no)
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="9" height="11" x="1" y="6" rx="1"/><path d="M10 12H3"/><rect width="9" height="11" x="14" y="6" rx="1"/><path d="M21 12h-7"/></svg>
                                            <span style="font-family:monospace">{{ $tender->reference_no }}</span>
                                        </span>
                                    @endif
                                    @if($tender->location)
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                            {{ $tender->location }}
                                        </span>
                                    @endif
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        Posted {{ $tender->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;flex-shrink:0;">
                            @if($isExpired)
                                <span class="ts-badge ts-badge-expired">Expired</span>
                            @elseif($isUrgent)
                                <span class="ts-badge ts-badge-expiring">Closing Soon</span>
                            @elseif($tender->is_open)
                                <span class="ts-badge ts-badge-open">Open</span>
                            @else
                                <span class="ts-badge ts-badge-closed">Closed</span>
                            @endif
                        </div>
                    </div>

                    <div class="ts-hero-actions">
                        <a href="{{ route('admin.tenders.edit',$tender->id) }}" class="ts-btn ts-btn-primary ts-btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        @if($tender->document_path)
                            <a href="{{ asset('storage/'.$tender->document_path) }}" target="_blank" class="ts-btn ts-btn-ghost ts-btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                Download Document
                            </a>
                        @endif
                        <form method="POST" action="{{ route('admin.tenders.toggle',$tender->id) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="ts-btn ts-btn-sm {{ $tender->is_open ? 'ts-btn-warning' : 'ts-btn-ghost' }}" style="border:1.5px solid">
                                @if($tender->is_open)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    Close Tender
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
                                    Reopen Tender
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Details grid --}}
            <div class="ts-card">
                <div class="ts-card-header">
                    <div class="ts-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg></div>
                    <h6>Tender Details</h6>
                    <a href="{{ route('admin.tenders.edit',$tender->id) }}" class="ts-card-action ts-btn ts-btn-ghost ts-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                </div>
                <div class="ts-card-body" style="padding:0">
                    <div class="ts-info-grid">
                        <div class="ts-info-cell"><div class="ts-info-key">Title</div><div class="ts-info-val">{{ $tender->title }}</div></div>
                        <div class="ts-info-cell"><div class="ts-info-key">Reference No.</div><div class="ts-info-val mono">{{ $tender->reference_no ?? '—' }}</div></div>
                        <div class="ts-info-cell"><div class="ts-info-key">Budget</div>
                            <div class="ts-info-val {{ $tender->budget ? 'indigo' : 'muted' }}">
                                {{ $tender->budget ? 'RWF ' . number_format($tender->budget) : 'Not disclosed' }}
                            </div>
                        </div>
                        <div class="ts-info-cell"><div class="ts-info-key">Deadline</div>
                            <div class="ts-info-val" style="{{ $isExpired ? 'color:var(--muted);text-decoration:line-through' : ($isUrgent ? 'color:var(--red);font-weight:700' : '') }}">
                                {{ $tender->submission_deadline->format('F j, Y') }}
                            </div>
                        </div>
                        <div class="ts-info-cell"><div class="ts-info-key">Location</div><div class="ts-info-val">{{ $tender->location ?? '—' }}</div></div>
                        <div class="ts-info-cell"><div class="ts-info-key">Status</div>
                            <div class="ts-info-val">
                                @if($isExpired)
                                    <span class="ts-badge ts-badge-expired">Expired</span>
                                @elseif($isUrgent)
                                    <span class="ts-badge ts-badge-expiring">Closing Soon</span>
                                @elseif($tender->is_open)
                                    <span class="ts-badge ts-badge-open">Open</span>
                                @else
                                    <span class="ts-badge ts-badge-closed">Closed</span>
                                @endif
                            </div>
                        </div>
                        <div class="ts-info-cell"><div class="ts-info-key">Posted By</div><div class="ts-info-val">{{ $tender->user?->name ?? '—' }}</div></div>
                        <div class="ts-info-cell"><div class="ts-info-key">Posted On</div><div class="ts-info-val">{{ $tender->created_at->format('M j, Y') }}</div></div>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div class="ts-card">
                <div class="ts-card-header">
                    <div class="ts-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                    <h6>Description</h6>
                </div>
                <div class="ts-card-body">
                    <p class="ts-description">{{ $tender->description }}</p>
                </div>
            </div>

            {{-- Document --}}
            @if($tender->document_path)
                <div class="ts-doc-card">
                    <div class="ts-doc-inner">
                        <div class="ts-doc-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/></svg>
                        </div>
                        <div style="flex:1;min-width:0;">
                            <strong style="display:block;font-size:.88rem;color:var(--text);margin-bottom:.15rem">{{ basename($tender->document_path) }}</strong>
                            <span style="font-size:.75rem;color:var(--muted)">Tender document · PDF</span>
                        </div>
                        <a href="{{ asset('storage/'.$tender->document_path) }}" target="_blank" class="ts-btn ts-btn-primary ts-btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            Download
                        </a>
                    </div>
                </div>
            @endif

        </div>{{-- /.ts-main --}}

        {{-- ── SIDE ── --}}
        <div class="ts-side">

            {{-- Deadline countdown --}}
            <div class="ts-deadline-card" style="border:1px solid {{ $isExpired ? '#fecaca' : ($isUrgent ? '#fde68a' : '#c7d2fe') }}; background: {{ $isExpired ? '#fef2f2' : ($isUrgent ? '#fffbeb' : '#eef2ff') }}">
                <div class="ts-deadline-val" style="color:{{ $isExpired ? 'var(--red)' : ($isUrgent ? 'var(--amber)' : 'var(--indigo)') }}">
                    @if($isExpired)
                        Expired
                    @else
                        {{ $tender->submission_deadline->diffForHumans(['parts' => 1]) }}
                    @endif
                </div>
                <div class="ts-deadline-label">
                    @if($isExpired) Deadline passed on @else Deadline @endif
                    {{ $tender->submission_deadline->format('M j, Y') }}
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="ts-card">
                <div class="ts-card-header">
                    <div class="ts-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg></div>
                    <h6>Quick Actions</h6>
                </div>
                <div class="ts-card-body">
                    <div class="ts-actions-list">
                        <a href="{{ route('admin.tenders.edit',$tender->id) }}" class="ts-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Tender
                        </a>
                        <form method="POST" action="{{ route('admin.tenders.toggle',$tender->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="ts-action-btn {{ $tender->is_open ? 'warning' : 'success' }}">
                                @if($tender->is_open)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    Close Tender
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
                                    Reopen Tender
                                @endif
                            </button>
                        </form>
                        @if($tender->document_path)
                            <a href="{{ asset('storage/'.$tender->document_path) }}" target="_blank" class="ts-action-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                Download Document
                            </a>
                        @endif
                        <button class="ts-action-btn danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                            Delete Tender
                        </button>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="ts-card">
                <div class="ts-card-header">
                    <div class="ts-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <h6>Timeline</h6>
                </div>
                <div class="ts-card-body">
                    <div class="ts-tl">
                        <div class="ts-tl-item">
                            <div class="ts-tl-left">
                                <div class="ts-tl-dot indigo"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg></div>
                                <div class="ts-tl-line"></div>
                            </div>
                            <div class="ts-tl-content">
                                <div class="ts-tl-title">Tender published</div>
                                <div class="ts-tl-meta">{{ $tender->created_at->format('F j, Y') }} — by {{ $tender->user?->name ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="ts-tl-item">
                            <div class="ts-tl-left">
                                <div class="ts-tl-dot {{ $tender->is_open ? 'green' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg></div>
                                <div class="ts-tl-line"></div>
                            </div>
                            <div class="ts-tl-content">
                                <div class="ts-tl-title">Current status: {{ $tender->is_open ? 'Open' : 'Closed' }}</div>
                                <div class="ts-tl-meta">{{ $tender->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="ts-tl-item">
                            <div class="ts-tl-left">
                                <div class="ts-tl-dot {{ $isExpired ? 'red' : ($isUrgent ? 'amber' : '') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                </div>
                            </div>
                            <div class="ts-tl-content">
                                <div class="ts-tl-title">{{ $isExpired ? 'Deadline passed' : 'Submission deadline' }}</div>
                                <div class="ts-tl-meta">{{ $tender->submission_deadline->format('F j, Y') }} {{ !$isExpired ? '— '.$tender->submission_deadline->diffForHumans() : '' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="ts-card" style="border-color:#fecaca;">
                <div class="ts-card-header" style="background:#fef2f2;border-color:#fecaca;">
                    <div class="ts-card-header-icon" style="background:#fee2e2;color:var(--danger);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/></svg></div>
                    <h6 style="color:var(--danger)">Danger Zone</h6>
                </div>
                <div class="ts-card-body">
                    <p style="font-size:.82rem;color:var(--muted);margin-bottom:1rem;line-height:1.55;">Permanently deletes this tender and its attached document.</p>
                    <button class="ts-btn ts-btn-danger" style="width:100%;justify-content:center;" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                        Delete Tender
                    </button>
                </div>
            </div>

        </div>{{-- /.ts-side --}}
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade ts-modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.tenders.destroy',$tender->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="ts-modal-icon danger"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                <h5 class="modal-title">Delete Tender</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="ts-delete-box">
                    Permanently delete <strong>{{ $tender->title }}</strong>? The attached PDF document will also be removed.
                    <br><br>
                    <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="ts-btn ts-btn-ghost ts-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="ts-btn ts-btn-danger ts-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

@endsection