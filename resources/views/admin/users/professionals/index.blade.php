@extends('layouts.app')
@section('title', 'Professionals')
@section('content')

<style>
    :root {
        --accent:#c9a96e;--accent-lt:#e4c990;--danger:#dc3545;--border:#e2e8f0;
        --surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;
        --radius:10px;--green:#22c55e;--amber:#f59e0b;--blue:#3b82f6;--purple:#7c3aed;
    }
    .pr-page{padding:1.75rem 0 3rem;max-width:1320px;margin:0 auto;}
    .pr-topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem;}
    .pr-topbar h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .pr-topbar p{font-size:.82rem;color:var(--muted);margin:.15rem 0 0;}
    .pr-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .pr-btn-primary{background:var(--accent);color:#fff;}
    .pr-btn-primary:hover{background:var(--accent-lt);color:#fff;transform:translateY(-1px);}
    .pr-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}
    .pr-btn-ghost:hover{border-color:var(--accent);color:var(--accent);}
    .pr-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}
    .pr-btn-danger:hover{background:#fef2f2;}
    .pr-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    .pr-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .pr-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .pr-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .pr-stats{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:1rem;margin-bottom:1.5rem;}
    .pr-stat{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:1rem 1.25rem;}
    .pr-stat-val{font-size:1.55rem;font-weight:700;line-height:1;}
    .pr-stat-val.accent{color:var(--accent);}
    .pr-stat-val.green{color:var(--green);}
    .pr-stat-val.amber{color:var(--amber);}
    .pr-stat-val.purple{color:var(--purple);}
    .pr-stat-label{font-size:.7rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-top:.3rem;}
    .pr-filters{display:flex;align-items:center;flex-wrap:wrap;gap:.75rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:.9rem 1.2rem;margin-bottom:1.25rem;}
    .pr-search-wrap{position:relative;flex:1;min-width:200px;max-width:320px;}
    .pr-search-wrap svg{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
    .pr-search{width:100%;padding:.56rem .85rem .56rem 2.3rem;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;color:var(--text);background:var(--surface);outline:none;font-family:inherit;transition:border-color .2s;}
    .pr-search:focus{border-color:var(--accent);}
    .pr-filter-select{padding:.56rem .85rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);background:var(--surface);outline:none;cursor:pointer;font-family:inherit;transition:border-color .2s;}
    .pr-filter-select:focus{border-color:var(--accent);}
    .pr-count{margin-left:auto;font-size:.78rem;color:var(--muted);white-space:nowrap;}
    .pr-count strong{color:var(--text-dim);}
    .pr-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .pr-card-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .pr-card-title{display:flex;align-items:center;gap:.5rem;font-size:.86rem;font-weight:600;color:var(--text);}
    .pr-table{width:100%;border-collapse:collapse;font-size:.84rem;}
    .pr-table thead{background:var(--surface);}
    .pr-table th{padding:.75rem 1.1rem;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap;}
    .pr-table td{padding:.9rem 1.1rem;border-bottom:1px solid var(--border);vertical-align:middle;}
    .pr-table tr:last-child td{border-bottom:none;}
    .pr-table tbody tr{transition:background .15s;}
    .pr-table tbody tr:hover{background:#fafafa;}
    .pr-prof-cell{display:flex;align-items:center;gap:.75rem;}
    .pr-avatar-wrap{position:relative;flex-shrink:0;}
    .pr-avatar{width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid var(--border);}
    .pr-avatar-initials{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--purple),#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;color:#fff;flex-shrink:0;}
    .pr-verified-dot{position:absolute;bottom:1px;right:1px;width:9px;height:9px;border-radius:50%;background:var(--green);border:1.5px solid #fff;}
    .pr-prof-name{font-weight:600;color:var(--text);font-size:.87rem;text-decoration:none;transition:color .15s;}
    .pr-prof-name:hover{color:var(--accent);}
    .pr-prof-sub{font-size:.75rem;color:var(--muted);margin-top:.1rem;}
    .pr-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:100px;font-size:.71rem;font-weight:600;white-space:nowrap;}
    .pr-badge-profession{background:#f5f3ff;border:1px solid #ddd6fe;color:var(--purple);}
    .pr-badge-verified{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .pr-badge-unverified{background:#fef2f2;border:1px solid #fecaca;color:#991b1b;}
    .pr-rating{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .6rem;border-radius:100px;background:#fffbeb;border:1px solid #fde68a;font-size:.72rem;font-weight:700;color:#92400e;}
    .pr-exp-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:100px;font-size:.71rem;font-weight:600;background:#c9a96e0d;border:1px solid #c9a96e30;color:var(--accent);white-space:nowrap;}
    .pr-contact{display:flex;gap:.4rem;}
    .pr-contact-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-dim);transition:all .15s;text-decoration:none;}
    .pr-contact-btn:hover{border-color:var(--accent);color:var(--accent);background:#c9a96e08;}
    .pr-contact-btn.phone:hover{border-color:#bbf7d0;color:var(--green);background:#f0fdf4;}
    .pr-actions{display:flex;align-items:center;gap:.35rem;}
    .pr-icon-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-dim);transition:all .15s;text-decoration:none;}
    .pr-icon-btn:hover{border-color:var(--accent);color:var(--accent);background:#c9a96e08;}
    .pr-icon-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    .pr-empty{text-align:center;padding:4rem 2rem;}
    .pr-empty-icon{width:54px;height:54px;border-radius:12px;background:#c9a96e12;border:1px solid #c9a96e28;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;color:var(--accent);}
    .pr-empty h5{font-size:.96rem;font-weight:600;color:var(--text);margin:0 0 .4rem;}
    .pr-empty p{font-size:.82rem;color:var(--muted);margin:0 0 1.1rem;}
    .pr-pagination{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;padding:.9rem 1.2rem;border-top:1px solid var(--border);}
    .pr-pagination-info{font-size:.78rem;color:var(--muted);}
    .pr-pagination-info strong{color:var(--text-dim);}
    .pr-pages{display:flex;gap:.3rem;}
    .pr-page-btn{min-width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:none;color:var(--text-dim);font-size:.78rem;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-family:inherit;transition:all .15s;padding:0 .4rem;}
    .pr-page-btn:hover{border-color:var(--accent);color:var(--accent);}
    .pr-page-btn.current{background:var(--accent);color:#fff;border-color:var(--accent);font-weight:600;}
    .pr-page-btn.disabled{opacity:.35;pointer-events:none;}
    .pr-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .pr-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .pr-modal-icon{width:30px;height:30px;border-radius:7px;background:#fef2f2;color:var(--danger);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .pr-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--danger);margin:0;}
    .pr-modal .modal-body{padding:1.4rem;}
    .pr-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    .pr-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .pr-delete-box strong{color:var(--text);}
</style>

<div class="pr-page">
    <div class="pr-topbar">
        <div>
            <h4>Professionals</h4>
            <p>Manage architects, lawyers, valuers and other property professionals.</p>
        </div>
        <a href="{{ route('admin.professionals.create') }}" class="pr-btn pr-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Add Professional
        </a>
    </div>

    @if(session('success'))
        <div class="pr-alert pr-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="pr-alert pr-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="pr-stats">
        <div class="pr-stat"><div class="pr-stat-val accent">{{ $professionals->count() }}</div><div class="pr-stat-label">Total</div></div>
        <div class="pr-stat"><div class="pr-stat-val green">{{ $professionals->where('is_verified',true)->count() }}</div><div class="pr-stat-label">Verified</div></div>
        <div class="pr-stat"><div class="pr-stat-val amber">{{ number_format($professionals->avg('rating'),1) }}</div><div class="pr-stat-label">Avg Rating</div></div>
        <div class="pr-stat"><div class="pr-stat-val purple">{{ $professionals->pluck('profession')->unique()->filter()->count() }}</div><div class="pr-stat-label">Professions</div></div>
    </div>

    <div class="pr-filters">
        <div class="pr-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="prSearch" class="pr-search" placeholder="Search name, profession, email…" oninput="filterProfessionals()">
        </div>
        <select id="prProfFilter" class="pr-filter-select" onchange="filterProfessionals()">
            <option value="">All professions</option>
            @foreach($professionals->pluck('profession')->unique()->filter() as $prof)
                <option value="{{ strtolower($prof) }}">{{ $prof }}</option>
            @endforeach
        </select>
        <select id="prVerFilter" class="pr-filter-select" onchange="filterProfessionals()">
            <option value="">All statuses</option>
            <option value="1">Verified</option>
            <option value="0">Unverified</option>
        </select>
        <p class="pr-count" id="prCount"><strong>{{ $professionals->count() }}</strong> professional{{ $professionals->count() === 1 ? '' : 's' }}</p>
    </div>

    <div class="pr-card">
        <div class="pr-card-toolbar">
            <div class="pr-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--accent)"><path d="M22 20V8l-10-6L2 8v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2z"/><path d="M6 20v-8l6-4 6 4v8"/></svg>
                All Professionals
            </div>
        </div>
        <div style="overflow-x:auto">
            <table class="pr-table">
                <thead>
                    <tr>
                        <th style="width:48px"><input type="checkbox" id="selectAll" style="cursor:pointer;accent-color:var(--accent);"></th>
                        <th>Professional</th>
                        <th>Profession</th>
                        <th>Rating</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th>Contact</th>
                        <th style="width:100px">Actions</th>
                    </tr>
                </thead>
                <tbody id="prBody">
                    @forelse($professionals as $pro)
                        <tr data-name="{{ strtolower($pro->full_name . ' ' . $pro->profession . ' ' . $pro->email) }}"
                            data-prof="{{ strtolower($pro->profession ?? '') }}"
                            data-ver="{{ $pro->is_verified ? '1' : '0' }}">
                            <td><input type="checkbox" class="row-check" value="{{ $pro->id }}" style="cursor:pointer;accent-color:var(--accent);"></td>
                            <td>
                                <div class="pr-prof-cell">
                                    <div class="pr-avatar-wrap">
                                        @if($pro->profile_image)
                                            <img src="{{ asset('storage/'.$pro->profile_image) }}" alt="{{ $pro->full_name }}" class="pr-avatar">
                                        @else
                                            <div class="pr-avatar-initials">{{ strtoupper(substr($pro->full_name,0,2)) }}</div>
                                        @endif
                                        @if($pro->is_verified)<span class="pr-verified-dot" title="Verified"></span>@endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.professionals.show',$pro->id) }}" class="pr-prof-name">{{ $pro->full_name }}</a>
                                        <div class="pr-prof-sub">{{ $pro->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($pro->profession)
                                    <span class="pr-badge pr-badge-profession">{{ $pro->profession }}</span>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td>
                                @if($pro->rating)
                                    <span class="pr-rating">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                        {{ number_format($pro->rating,1) }}
                                    </span>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td>
                                @if($pro->years_experience)
                                    <span class="pr-exp-badge">{{ $pro->years_experience }} yr{{ $pro->years_experience != 1 ? 's':'' }}</span>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="pr-badge {{ $pro->is_verified ? 'pr-badge-verified' : 'pr-badge-unverified' }}">
                                    {{ $pro->is_verified ? '✓ Verified' : 'Unverified' }}
                                </span>
                            </td>
                            <td>
                                <div class="pr-contact">
                                    @if($pro->email)
                                        <a href="mailto:{{ $pro->email }}" class="pr-contact-btn" title="Email">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                        </a>
                                    @endif
                                    @if($pro->phone)
                                        <a href="tel:{{ $pro->phone }}" class="pr-contact-btn phone" title="Call">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="pr-actions">
                                    <a href="{{ route('admin.professionals.show',$pro->id) }}" class="pr-icon-btn" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.professionals.edit',$pro->id) }}" class="pr-icon-btn" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="pr-icon-btn danger" data-bs-toggle="modal" data-bs-target="#deletePro{{ $pro->id }}" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">
                            <div class="pr-empty">
                                <div class="pr-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 20V8l-10-6L2 8v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2z"/></svg></div>
                                <h5>No professionals yet</h5>
                                <p>Add your first professional to the directory.</p>
                                <a href="{{ route('admin.professionals.create') }}" class="pr-btn pr-btn-primary pr-btn-sm">Add Professional</a>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($professionals,'hasPages') && $professionals->hasPages())
            <div class="pr-pagination">
                <p class="pr-pagination-info">Showing <strong>{{ $professionals->firstItem() }}</strong>–<strong>{{ $professionals->lastItem() }}</strong> of <strong>{{ $professionals->total() }}</strong></p>
                <div class="pr-pages">
                    @if($professionals->onFirstPage())<span class="pr-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></span>
                    @else<a href="{{ $professionals->previousPageUrl() }}" class="pr-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></a>@endif
                    @foreach($professionals->getUrlRange(max(1,$professionals->currentPage()-2),min($professionals->lastPage(),$professionals->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="pr-page-btn {{ $page==$professionals->currentPage()?'current':'' }}">{{ $page }}</a>
                    @endforeach
                    @if($professionals->hasMorePages())<a href="{{ $professionals->nextPageUrl() }}" class="pr-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></a>
                    @else<span class="pr-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>@endif
                </div>
            </div>
        @endif
    </div>
</div>

@foreach($professionals as $pro)
<div class="modal fade pr-modal" id="deletePro{{ $pro->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.professionals.destroy',$pro->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="pr-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                <h5 class="modal-title">Delete Professional</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="pr-delete-box">Are you sure you want to delete <strong>{{ $pro->full_name }}</strong>? Their login account will also be removed.<br><br><span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="pr-btn pr-btn-ghost pr-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="pr-btn pr-btn-danger pr-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function filterProfessionals(){
    const q=document.getElementById('prSearch').value.toLowerCase();
    const prof=document.getElementById('prProfFilter').value;
    const ver=document.getElementById('prVerFilter').value;
    const rows=document.querySelectorAll('#prBody tr[data-name]');
    let shown=0;
    rows.forEach(r=>{
        const ok=r.dataset.name.includes(q)&&(!prof||r.dataset.prof===prof)&&(!ver||r.dataset.ver===ver);
        r.style.display=ok?'':'none';
        if(ok)shown++;
    });
    document.getElementById('prCount').innerHTML='<strong>'+shown+'</strong> professional'+(shown===1?'':'s');
}
document.getElementById('selectAll').addEventListener('change',function(){
    document.querySelectorAll('.row-check').forEach(cb=>cb.checked=this.checked);
});
</script>
@endsection