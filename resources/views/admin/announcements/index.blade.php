@extends('layouts.app')
@section('title', 'Announcements')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--violet:#7c3aed;--violet-lt:#8b5cf6;--green:#22c55e;--amber:#f59e0b;--red:#ef4444;--sky:#0ea5e9;}
    .an-page{padding:1.75rem 0 3rem;max-width:1320px;margin:0 auto;}
    .an-topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem;}
    .an-topbar h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .an-topbar p{font-size:.82rem;color:var(--muted);margin:.15rem 0 0;}
    .an-topbar-actions{display:flex;gap:.5rem;align-items:center;}
    .an-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .an-btn-primary{background:var(--violet);color:#fff;}.an-btn-primary:hover{background:var(--violet-lt);color:#fff;transform:translateY(-1px);}
    .an-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.an-btn-ghost:hover{border-color:var(--violet);color:var(--violet);}
    .an-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.an-btn-danger:hover{background:#fef2f2;}
    .an-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    .an-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .an-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .an-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    /* stats */
    .an-stats{display:grid;grid-template-columns:repeat(auto-fill,minmax(138px,1fr));gap:1rem;margin-bottom:1.5rem;}
    .an-stat{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:1rem 1.25rem;position:relative;overflow:hidden;}
    .an-stat::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:var(--bc,var(--violet));}
    .an-stat-val{font-size:1.55rem;font-weight:700;line-height:1;color:var(--bc,var(--violet));}
    .an-stat-label{font-size:.7rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-top:.3rem;}
    /* filters */
    .an-filters{display:flex;align-items:center;flex-wrap:wrap;gap:.75rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:.9rem 1.2rem;margin-bottom:1.25rem;}
    .an-search-wrap{position:relative;flex:1;min-width:200px;max-width:320px;}
    .an-search-wrap svg{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
    .an-search{width:100%;padding:.56rem .85rem .56rem 2.3rem;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;color:var(--text);background:var(--surface);outline:none;font-family:inherit;}
    .an-search:focus{border-color:var(--violet);}
    .an-filter-select{padding:.56rem .85rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);background:var(--surface);outline:none;cursor:pointer;font-family:inherit;}
    .an-filter-select:focus{border-color:var(--violet);}
    .an-count{margin-left:auto;font-size:.78rem;color:var(--muted);}
    .an-count strong{color:var(--text-dim);}
    /* table card */
    .an-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .an-card-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .an-card-title{display:flex;align-items:center;gap:.5rem;font-size:.86rem;font-weight:600;color:var(--text);}
    .an-table{width:100%;border-collapse:collapse;font-size:.84rem;}
    .an-table thead{background:var(--surface);}
    .an-table th{padding:.75rem 1.1rem;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap;}
    .an-table td{padding:.85rem 1.1rem;border-bottom:1px solid var(--border);vertical-align:middle;}
    .an-table tr:last-child td{border-bottom:none;}
    .an-table tbody tr{transition:background .15s;}
    .an-table tbody tr:hover{background:#fafafa;}
    /* title cell */
    .an-title-wrap{display:flex;align-items:flex-start;gap:.65rem;}
    .an-title-icon{width:34px;height:34px;border-radius:8px;background:#7c3aed12;border:1px solid #7c3aed20;display:flex;align-items:center;justify-content:center;color:var(--violet);flex-shrink:0;}
    .an-title-name{font-weight:600;color:var(--text);font-size:.87rem;text-decoration:none;transition:color .15s;display:block;}
    .an-title-name:hover{color:var(--violet);}
    .an-slug{font-size:.72rem;color:var(--muted);font-family:monospace;margin-top:.1rem;}
    /* status badges */
    .an-status{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:100px;font-size:.71rem;font-weight:600;white-space:nowrap;}
    .an-status-dot{width:6px;height:6px;border-radius:50%;background:currentColor;}
    .an-status.active   {background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .an-status.paid     {background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;}
    .an-status.pending  {background:#fffbeb;border:1px solid #fde68a;color:#92400e;}
    .an-status.expired  {background:#fef2f2;border:1px solid #fecaca;color:#991b1b;}
    .an-status.inactive {background:var(--surface);border:1px solid var(--border);color:var(--muted);}
    /* date */
    .an-date{font-size:.81rem;color:var(--text-dim);}
    .an-date-sub{font-size:.7rem;color:var(--muted);margin-top:.1rem;}
    /* actions */
    .an-actions{display:flex;align-items:center;gap:.35rem;}
    .an-icon-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-dim);transition:all .15s;text-decoration:none;}
    .an-icon-btn:hover{border-color:var(--violet);color:var(--violet);background:#7c3aed08;}
    .an-icon-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    /* empty */
    .an-empty{text-align:center;padding:4rem 2rem;}
    .an-empty-icon{width:54px;height:54px;border-radius:12px;background:#7c3aed12;border:1px solid #7c3aed20;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;color:var(--violet);}
    .an-empty h5{font-size:.96rem;font-weight:600;color:var(--text);margin:0 0 .4rem;}
    .an-empty p{font-size:.82rem;color:var(--muted);margin:0 0 1.1rem;}
    /* pagination */
    .an-pagination{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;padding:.9rem 1.2rem;border-top:1px solid var(--border);}
    .an-pagination-info{font-size:.78rem;color:var(--muted);}
    .an-pagination-info strong{color:var(--text-dim);}
    .an-pages{display:flex;gap:.3rem;}
    .an-page-btn{min-width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:none;color:var(--text-dim);font-size:.78rem;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-family:inherit;transition:all .15s;padding:0 .4rem;}
    .an-page-btn:hover{border-color:var(--violet);color:var(--violet);}
    .an-page-btn.current{background:var(--violet);color:#fff;border-color:var(--violet);font-weight:600;}
    .an-page-btn.disabled{opacity:.35;pointer-events:none;}
    /* modal */
    .an-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .an-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .an-modal-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .an-modal-icon.danger{background:#fef2f2;color:var(--danger);}
    .an-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--danger);margin:0;}
    .an-modal .modal-body{padding:1.4rem;}
    .an-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    .an-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .an-delete-box strong{color:var(--text);}
    /* status quick-select modal */
    .an-status-label{display:flex;align-items:center;gap:.5rem;padding:.6rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;cursor:pointer;transition:all .15s;font-weight:500;color:var(--text-dim);user-select:none;}
    .an-status-radio{display:none;}
    .an-status-radio:checked+.an-status-label{border-color:var(--violet);background:#7c3aed08;color:var(--violet);}
    .an-status-option-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
</style>

<div class="an-page">
    <div class="an-topbar">
        <div><h4>Announcements</h4><p>Manage public announcements and their visibility.</p></div>
        <div class="an-topbar-actions">
            <a href="{{ route('admin.announcements.trashed') }}" class="an-btn an-btn-ghost an-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                Trash
            </a>
            <a href="{{ route('admin.announcements.create') }}" class="an-btn an-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                New Announcement
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="an-alert an-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="an-alert an-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="an-stats">
        <div class="an-stat" style="--bc:var(--violet)"><div class="an-stat-val">{{ $stats['total'] }}</div><div class="an-stat-label">Total</div></div>
        <div class="an-stat" style="--bc:var(--green)"><div class="an-stat-val">{{ $stats['active'] }}</div><div class="an-stat-label">Active</div></div>
        <div class="an-stat" style="--bc:var(--sky)"><div class="an-stat-val">{{ $stats['paid'] }}</div><div class="an-stat-label">Paid (Live)</div></div>
        <div class="an-stat" style="--bc:var(--amber)"><div class="an-stat-val">{{ $stats['pending'] }}</div><div class="an-stat-label">Pending</div></div>
        <div class="an-stat" style="--bc:var(--red)"><div class="an-stat-val">{{ $stats['expired'] }}</div><div class="an-stat-label">Expired</div></div>
    </div>

    {{-- Info strip --}}
    <div style="display:flex;align-items:center;gap:.6rem;padding:.75rem 1rem;border-radius:8px;background:#eff6ff;border:1px solid #bfdbfe;font-size:.8rem;color:#1d4ed8;margin-bottom:1.25rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
        Only announcements with status <strong style="margin:0 .25rem">Paid</strong> are visible to the public.
    </div>

    {{-- Filters --}}
    <div class="an-filters">
        <div class="an-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="anSearch" class="an-search" placeholder="Search title, slug…" oninput="filterAnnouncements()">
        </div>
        <select id="anStatusFilter" class="an-filter-select" onchange="filterAnnouncements()">
            <option value="">All statuses</option>
            <option value="active">Active</option>
            <option value="paid">Paid</option>
            <option value="pending">Pending</option>
            <option value="expired">Expired</option>
            <option value="inactive">Inactive</option>
        </select>
        <p class="an-count" id="anCount"><strong>{{ $announcements->count() }}</strong> announcement{{ $announcements->count()===1?'':'s' }}</p>
    </div>

    {{-- Table --}}
    <div class="an-card">
        <div class="an-card-toolbar">
            <div class="an-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--violet)"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                All Announcements
            </div>
        </div>
        <div style="overflow-x:auto">
            <table class="an-table">
                <thead>
                    <tr>
                        <th style="width:48px"><input type="checkbox" id="selectAll" style="cursor:pointer;accent-color:var(--violet);"></th>
                        <th>Announcement</th>
                        <th>Status</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Created By</th>
                        <th style="width:110px">Actions</th>
                    </tr>
                </thead>
                <tbody id="anBody">
                    @forelse($announcements as $ann)
                        <tr data-name="{{ strtolower($ann->title . ' ' . $ann->slug) }}"
                            data-status="{{ $ann->status }}">
                            <td><input type="checkbox" class="row-check" value="{{ $ann->id }}" style="cursor:pointer;accent-color:var(--violet);"></td>
                            <td>
                                <div class="an-title-wrap">
                                    <div class="an-title-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                    </div>
                                    <div style="min-width:0">
                                        <a href="{{ route('admin.announcements.show',$ann->id) }}" class="an-title-name">{{ $ann->title }}</a>
                                        <div class="an-slug">/{{ $ann->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="an-status {{ $ann->status }}">
                                    <span class="an-status-dot"></span>
                                    {{ ucfirst($ann->status) }}
                                </span>
                            </td>
                            <td>
                                @if($ann->start_date)
                                    <div class="an-date">{{ $ann->start_date->format('M j, Y') }}</div>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td>
                                @if($ann->end_date)
                                    @php $isOver = $ann->end_date < now(); @endphp
                                    <div class="an-date {{ $isOver ? 'text-danger' : '' }}" style="{{ $isOver ? 'color:var(--red)' : '' }}">
                                        {{ $ann->end_date->format('M j, Y') }}
                                    </div>
                                    <div class="an-date-sub">{{ $ann->end_date->diffForHumans() }}</div>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td style="font-size:.81rem;color:var(--text-dim)">{{ $ann->creator?->name ?? '—' }}</td>
                            <td>
                                <div class="an-actions">
                                    <a href="{{ route('admin.announcements.show',$ann->id) }}" class="an-icon-btn" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.announcements.edit',$ann->id) }}" class="an-icon-btn" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="an-icon-btn danger" data-bs-toggle="modal" data-bs-target="#deleteAnn{{ $ann->id }}" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="an-empty">
                                <div class="an-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
                                <h5>No announcements yet</h5>
                                <p>Create your first announcement.</p>
                                <a href="{{ route('admin.announcements.create') }}" class="an-btn an-btn-primary an-btn-sm">New Announcement</a>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($announcements,'hasPages') && $announcements->hasPages())
            <div class="an-pagination">
                <p class="an-pagination-info">Showing <strong>{{ $announcements->firstItem() }}</strong>–<strong>{{ $announcements->lastItem() }}</strong> of <strong>{{ $announcements->total() }}</strong></p>
                <div class="an-pages">
                    @if($announcements->onFirstPage())<span class="an-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></span>
                    @else<a href="{{ $announcements->previousPageUrl() }}" class="an-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></a>@endif
                    @foreach($announcements->getUrlRange(max(1,$announcements->currentPage()-2),min($announcements->lastPage(),$announcements->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="an-page-btn {{ $page==$announcements->currentPage()?'current':'' }}">{{ $page }}</a>
                    @endforeach
                    @if($announcements->hasMorePages())<a href="{{ $announcements->nextPageUrl() }}" class="an-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></a>
                    @else<span class="an-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>@endif
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Delete Modals --}}
@foreach($announcements as $ann)
<div class="modal fade an-modal" id="deleteAnn{{ $ann->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.announcements.destroy',$ann->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="an-modal-icon danger"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/></svg></div>
                <h5 class="modal-title">Delete Announcement</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="an-delete-box">Move <strong>{{ $ann->title }}</strong> to trash? You can restore it later from the Trash view.<br><br><span style="font-size:.79rem;color:var(--amber)">⚠ This is a soft delete — the record can be restored.</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="an-btn an-btn-ghost an-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="an-btn an-btn-danger an-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Move to Trash
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function filterAnnouncements(){
    const q=document.getElementById('anSearch').value.toLowerCase();
    const status=document.getElementById('anStatusFilter').value;
    const rows=document.querySelectorAll('#anBody tr[data-name]');
    let shown=0;
    rows.forEach(r=>{
        const ok=r.dataset.name.includes(q)&&(!status||r.dataset.status===status);
        r.style.display=ok?'':'none';
        if(ok)shown++;
    });
    document.getElementById('anCount').innerHTML='<strong>'+shown+'</strong> announcement'+(shown===1?'':'s');
}
document.getElementById('selectAll').addEventListener('change',function(){
    document.querySelectorAll('.row-check').forEach(cb=>cb.checked=this.checked);
});
</script>
@endsection