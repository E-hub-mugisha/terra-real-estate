@extends('layouts.app')
@section('title', 'Consultants')
@section('content')

<style>
    :root{--accent:#c9a96e;--accent-lt:#e4c990;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--green:#22c55e;--amber:#f59e0b;--teal:#0d9488;}
    .cn-page{padding:1.75rem 0 3rem;max-width:1320px;margin:0 auto;}
    .cn-topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem;}
    .cn-topbar h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .cn-topbar p{font-size:.82rem;color:var(--muted);margin:.15rem 0 0;}
    .cn-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .cn-btn-primary{background:var(--teal);color:#fff;}.cn-btn-primary:hover{background:#0f766e;color:#fff;transform:translateY(-1px);}
    .cn-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.cn-btn-ghost:hover{border-color:var(--teal);color:var(--teal);}
    .cn-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.cn-btn-danger:hover{background:#fef2f2;}
    .cn-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    .cn-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .cn-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .cn-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .cn-stats{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:1rem;margin-bottom:1.5rem;}
    .cn-stat{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:1rem 1.25rem;}
    .cn-stat-val{font-size:1.55rem;font-weight:700;line-height:1;}
    .cn-stat-val.teal{color:var(--teal);}
    .cn-stat-val.amber{color:var(--amber);}
    .cn-stat-val.accent{color:var(--accent);}
    .cn-stat-val.green{color:var(--green);}
    .cn-stat-label{font-size:.7rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-top:.3rem;}
    .cn-filters{display:flex;align-items:center;flex-wrap:wrap;gap:.75rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:.9rem 1.2rem;margin-bottom:1.25rem;}
    .cn-search-wrap{position:relative;flex:1;min-width:200px;max-width:320px;}
    .cn-search-wrap svg{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
    .cn-search{width:100%;padding:.56rem .85rem .56rem 2.3rem;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;color:var(--text);background:var(--surface);outline:none;font-family:inherit;transition:border-color .2s;}
    .cn-search:focus{border-color:var(--teal);}
    .cn-filter-select{padding:.56rem .85rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);background:var(--surface);outline:none;cursor:pointer;font-family:inherit;transition:border-color .2s;}
    .cn-filter-select:focus{border-color:var(--teal);}
    .cn-count{margin-left:auto;font-size:.78rem;color:var(--muted);white-space:nowrap;}
    .cn-count strong{color:var(--text-dim);}
    .cn-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .cn-card-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .cn-card-title{display:flex;align-items:center;gap:.5rem;font-size:.86rem;font-weight:600;color:var(--text);}
    .cn-table{width:100%;border-collapse:collapse;font-size:.84rem;}
    .cn-table thead{background:var(--surface);}
    .cn-table th{padding:.75rem 1.1rem;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap;}
    .cn-table td{padding:.9rem 1.1rem;border-bottom:1px solid var(--border);vertical-align:middle;}
    .cn-table tr:last-child td{border-bottom:none;}
    .cn-table tbody tr{transition:background .15s;}
    .cn-table tbody tr:hover{background:#fafafa;}
    .cn-cell{display:flex;align-items:center;gap:.75rem;}
    .cn-avatar{width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid var(--border);}
    .cn-avatar-initials{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--teal),#14b8a6);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;color:#fff;flex-shrink:0;}
    .cn-name{font-weight:600;color:var(--text);font-size:.87rem;text-decoration:none;transition:color .15s;}
    .cn-name:hover{color:var(--teal);}
    .cn-sub{font-size:.75rem;color:var(--muted);margin-top:.1rem;}
    .cn-title-badge{display:inline-flex;align-items:center;padding:.22rem .65rem;border-radius:100px;font-size:.71rem;font-weight:600;background:#f0fdfa;border:1px solid #99f6e4;color:var(--teal);white-space:nowrap;}
    .cn-cat-badges{display:flex;flex-wrap:wrap;gap:.3rem;}
    .cn-cat-badge{padding:.18rem .55rem;border-radius:100px;font-size:.68rem;font-weight:500;background:#c9a96e0d;border:1px solid #c9a96e30;color:var(--accent);white-space:nowrap;}
    .cn-contact{display:flex;gap:.4rem;}
    .cn-contact-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-dim);transition:all .15s;text-decoration:none;}
    .cn-contact-btn:hover{border-color:var(--teal);color:var(--teal);background:#f0fdfa;}
    .cn-actions{display:flex;align-items:center;gap:.35rem;}
    .cn-icon-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-dim);transition:all .15s;text-decoration:none;}
    .cn-icon-btn:hover{border-color:var(--teal);color:var(--teal);background:#f0fdfa;}
    .cn-icon-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    .cn-empty{text-align:center;padding:4rem 2rem;}
    .cn-empty-icon{width:54px;height:54px;border-radius:12px;background:#f0fdfa;border:1px solid #99f6e4;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;color:var(--teal);}
    .cn-empty h5{font-size:.96rem;font-weight:600;color:var(--text);margin:0 0 .4rem;}
    .cn-empty p{font-size:.82rem;color:var(--muted);margin:0 0 1.1rem;}
    .cn-pagination{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;padding:.9rem 1.2rem;border-top:1px solid var(--border);}
    .cn-pagination-info{font-size:.78rem;color:var(--muted);}
    .cn-pagination-info strong{color:var(--text-dim);}
    .cn-pages{display:flex;gap:.3rem;}
    .cn-page-btn{min-width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:none;color:var(--text-dim);font-size:.78rem;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-family:inherit;transition:all .15s;padding:0 .4rem;}
    .cn-page-btn:hover{border-color:var(--teal);color:var(--teal);}
    .cn-page-btn.current{background:var(--teal);color:#fff;border-color:var(--teal);font-weight:600;}
    .cn-page-btn.disabled{opacity:.35;pointer-events:none;}
    .cn-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .cn-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .cn-modal-icon{width:30px;height:30px;border-radius:7px;background:#fef2f2;color:var(--danger);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .cn-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--danger);margin:0;}
    .cn-modal .modal-body{padding:1.4rem;}
    .cn-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    .cn-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .cn-delete-box strong{color:var(--text);}
</style>

<div class="cn-page">
    <div class="cn-topbar">
        <div><h4>Consultants</h4><p>Manage all registered consultants and their service categories.</p></div>
        <a href="{{ route('admin.consultants.create') }}" class="cn-btn cn-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Add Consultant
        </a>
    </div>

    @if(session('success'))
        <div class="cn-alert cn-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="cn-alert cn-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="cn-stats">
        <div class="cn-stat"><div class="cn-stat-val teal">{{ $consultants->count() }}</div><div class="cn-stat-label">Total</div></div>
        <div class="cn-stat"><div class="cn-stat-val green">{{ $consultants->filter(fn($c)=>$c->user)->count() }}</div><div class="cn-stat-label">With Account</div></div>
        <div class="cn-stat"><div class="cn-stat-val accent">{{ $serviceCategories->count() }}</div><div class="cn-stat-label">Categories</div></div>
        <div class="cn-stat"><div class="cn-stat-val amber">{{ $consultants->filter(fn($c)=>$c->company)->count() }}</div><div class="cn-stat-label">Companies</div></div>
    </div>

    <div class="cn-filters">
        <div class="cn-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="cnSearch" class="cn-search" placeholder="Search name, title, email…" oninput="filterConsultants()">
        </div>
        <select id="cnCatFilter" class="cn-filter-select" onchange="filterConsultants()">
            <option value="">All categories</option>
            @foreach($serviceCategories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <p class="cn-count" id="cnCount"><strong>{{ $consultants->count() }}</strong> consultant{{ $consultants->count()===1?'':'s' }}</p>
    </div>

    <div class="cn-card">
        <div class="cn-card-toolbar">
            <div class="cn-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--teal)"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                All Consultants
            </div>
        </div>
        <div style="overflow-x:auto">
            <table class="cn-table">
                <thead>
                    <tr>
                        <th style="width:48px"><input type="checkbox" id="selectAll" style="cursor:pointer;accent-color:var(--teal);"></th>
                        <th>Consultant</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Service Categories</th>
                        <th>Contact</th>
                        <th style="width:100px">Actions</th>
                    </tr>
                </thead>
                <tbody id="cnBody">
                    @forelse($consultants as $con)
                        <tr data-name="{{ strtolower($con->name . ' ' . $con->title . ' ' . $con->email) }}"
                            data-cats="{{ $con->serviceCategories->pluck('id')->join(',') }}">
                            <td><input type="checkbox" class="row-check" value="{{ $con->id }}" style="cursor:pointer;accent-color:var(--teal);"></td>
                            <td>
                                <div class="cn-cell">
                                    <div style="position:relative;flex-shrink:0;">
                                        @if($con->photo)
                                            <img src="{{ asset('storage/'.$con->photo) }}" alt="{{ $con->name }}" class="cn-avatar">
                                        @else
                                            <div class="cn-avatar-initials">{{ strtoupper(substr($con->name,0,2)) }}</div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.consultants.show',$con->id) }}" class="cn-name">{{ $con->name }}</a>
                                        <div class="cn-sub">{{ $con->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($con->title)
                                    <span class="cn-title-badge">{{ $con->title }}</span>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td style="color:var(--text-dim);font-size:.82rem">{{ $con->company ?? '—' }}</td>
                            <td>
                                @if($con->serviceCategories->count())
                                    <div class="cn-cat-badges">
                                        @foreach($con->serviceCategories->take(3) as $cat)
                                            <span class="cn-cat-badge">{{ $cat->name }}</span>
                                        @endforeach
                                        @if($con->serviceCategories->count() > 3)
                                            <span class="cn-cat-badge">+{{ $con->serviceCategories->count()-3 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="cn-contact">
                                    <a href="mailto:{{ $con->email }}" class="cn-contact-btn" title="Email">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                    </a>
                                    @if($con->phone)
                                        <a href="tel:{{ $con->phone }}" class="cn-contact-btn" title="Call">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="cn-actions">
                                    <a href="{{ route('admin.consultants.show',$con->id) }}" class="cn-icon-btn" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.consultants.edit',$con->id) }}" class="cn-icon-btn" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <button class="cn-icon-btn danger" data-bs-toggle="modal" data-bs-target="#deleteCon{{ $con->id }}" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="cn-empty">
                                <div class="cn-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                                <h5>No consultants yet</h5>
                                <p>Add your first consultant to get started.</p>
                                <a href="{{ route('admin.consultants.create') }}" class="cn-btn cn-btn-primary cn-btn-sm">Add Consultant</a>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($consultants,'hasPages') && $consultants->hasPages())
            <div class="cn-pagination">
                <p class="cn-pagination-info">Showing <strong>{{ $consultants->firstItem() }}</strong>–<strong>{{ $consultants->lastItem() }}</strong> of <strong>{{ $consultants->total() }}</strong></p>
                <div class="cn-pages">
                    @if($consultants->onFirstPage())<span class="cn-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></span>
                    @else<a href="{{ $consultants->previousPageUrl() }}" class="cn-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></a>@endif
                    @foreach($consultants->getUrlRange(max(1,$consultants->currentPage()-2),min($consultants->lastPage(),$consultants->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="cn-page-btn {{ $page==$consultants->currentPage()?'current':'' }}">{{ $page }}</a>
                    @endforeach
                    @if($consultants->hasMorePages())<a href="{{ $consultants->nextPageUrl() }}" class="cn-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></a>
                    @else<span class="cn-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>@endif
                </div>
            </div>
        @endif
    </div>
</div>

@foreach($consultants as $con)
<div class="modal fade cn-modal" id="deleteCon{{ $con->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.consultants.destroy',$con->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="cn-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                <h5 class="modal-title">Delete Consultant</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="cn-delete-box">Are you sure you want to delete <strong>{{ $con->name }}</strong>? Their login account will also be removed.<br><br><span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="cn-btn cn-btn-ghost cn-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="cn-btn cn-btn-danger cn-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function filterConsultants(){
    const q=document.getElementById('cnSearch').value.toLowerCase();
    const cat=document.getElementById('cnCatFilter').value;
    const rows=document.querySelectorAll('#cnBody tr[data-name]');
    let shown=0;
    rows.forEach(r=>{
        const nameMatch=r.dataset.name.includes(q);
        const catMatch=!cat||r.dataset.cats.split(',').includes(cat);
        const ok=nameMatch&&catMatch;
        r.style.display=ok?'':'none';
        if(ok)shown++;
    });
    document.getElementById('cnCount').innerHTML='<strong>'+shown+'</strong> consultant'+(shown===1?'':'s');
}
document.getElementById('selectAll').addEventListener('change',function(){
    document.querySelectorAll('.row-check').forEach(cb=>cb.checked=this.checked);
});
</script>
@endsection