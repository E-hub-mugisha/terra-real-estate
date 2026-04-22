@extends('layouts.app')
@section('title', 'Blog Categories')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--rose:#e11d48;--rose-lt:#fb7185;--green:#22c55e;}
    .bcat-page{padding:1.75rem 0 3rem;max-width:860px;margin:0 auto;}
    .bcat-topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem;}
    .bcat-topbar h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .bcat-topbar p{font-size:.82rem;color:var(--muted);margin:.15rem 0 0;}
    /* Buttons */
    .bcat-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .bcat-btn-primary{background:var(--rose);color:#fff;}.bcat-btn-primary:hover{background:var(--rose-lt);color:#fff;transform:translateY(-1px);}
    .bcat-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.bcat-btn-ghost:hover{border-color:var(--rose);color:var(--rose);}
    .bcat-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.bcat-btn-danger:hover{background:#fef2f2;}
    .bcat-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    /* Alerts */
    .bcat-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .bcat-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .bcat-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    /* Stats strip */
    .bcat-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;}
    .bcat-stat{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:.9rem 1.1rem;position:relative;overflow:hidden;}
    .bcat-stat::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:var(--rose);}
    .bcat-stat-val{font-size:1.5rem;font-weight:700;color:var(--rose);line-height:1;}
    .bcat-stat-label{font-size:.7rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-top:.3rem;}
    /* Card */
    .bcat-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .bcat-card-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .bcat-card-title{display:flex;align-items:center;gap:.5rem;font-size:.86rem;font-weight:600;color:var(--text);}
    /* Search */
    .bcat-search-wrap{position:relative;width:220px;}
    .bcat-search-wrap svg{position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
    .bcat-search{width:100%;padding:.48rem .75rem .48rem 2.15rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text);background:var(--surface);outline:none;font-family:inherit;}
    .bcat-search:focus{border-color:var(--rose);}
    /* Table */
    .bcat-table{width:100%;border-collapse:collapse;font-size:.84rem;}
    .bcat-table thead{background:var(--surface);}
    .bcat-table th{padding:.75rem 1.1rem;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap;}
    .bcat-table td{padding:.9rem 1.1rem;border-bottom:1px solid var(--border);vertical-align:middle;}
    .bcat-table tr:last-child td{border-bottom:none;}
    .bcat-table tbody tr{transition:background .15s;}
    .bcat-table tbody tr:hover{background:#fafafa;}
    /* Category cell */
    .bcat-cat-cell{display:flex;align-items:center;gap:.7rem;}
    .bcat-avatar{width:34px;height:34px;border-radius:8px;background:linear-gradient(135deg,#fce7f3,#fbe2e7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.82rem;color:var(--rose);flex-shrink:0;}
    .bcat-cat-name{font-weight:600;color:var(--text);font-size:.87rem;}
    /* Row index */
    .bcat-idx{width:32px;height:32px;border-radius:6px;background:var(--surface);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600;color:var(--muted);}
    /* Actions */
    .bcat-actions{display:flex;align-items:center;gap:.35rem;}
    .bcat-icon-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-dim);transition:all .15s;}
    .bcat-icon-btn:hover{border-color:var(--rose);color:var(--rose);background:#fce7f308;}
    .bcat-icon-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    /* Empty */
    .bcat-empty{text-align:center;padding:3.5rem 2rem;}
    .bcat-empty-icon{width:48px;height:48px;border-radius:12px;background:#fce7f3;border:1px solid #fbcfe8;display:flex;align-items:center;justify-content:center;margin:0 auto .85rem;color:var(--rose);}
    .bcat-empty h5{font-size:.92rem;font-weight:600;color:var(--text);margin:0 0 .35rem;}
    .bcat-empty p{font-size:.81rem;color:var(--muted);margin:0 0 1rem;}
    /* Modals */
    .bcat-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .bcat-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .bcat-modal-icon{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .bcat-modal-icon.rose{background:#fce7f3;color:var(--rose);}
    .bcat-modal-icon.danger{background:#fef2f2;color:var(--danger);}
    .bcat-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--text);margin:0;}
    .bcat-modal .modal-body{padding:1.4rem;}
    .bcat-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    /* Form */
    .bcat-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .bcat-label .req{color:var(--danger);margin-left:.2rem;}
    .bcat-input{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .bcat-input:focus{border-color:var(--rose);box-shadow:0 0 0 3px rgba(225,29,72,.08);}
    /* Delete box */
    .bcat-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .bcat-delete-box strong{color:var(--text);}
</style>

<div class="bcat-page">

    {{-- Top bar --}}
    <div class="bcat-topbar">
        <div>
            <h4>Blog Categories</h4>
            <p>Organise your blog posts by category.</p>
        </div>
        <button class="bcat-btn bcat-btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Add Category
        </button>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bcat-alert bcat-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bcat-alert bcat-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bcat-alert bcat-alert-danger" style="align-items:flex-start;">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
    @endif

    {{-- Stats --}}
    <div class="bcat-stats">
        <div class="bcat-stat">
            <div class="bcat-stat-val">{{ $categories->count() }}</div>
            <div class="bcat-stat-label">Total Categories</div>
        </div>
        <div class="bcat-stat">
            <div class="bcat-stat-val" style="color:var(--green)">{{ $categories->count() }}</div>
            <div class="bcat-stat-label">Active</div>
        </div>
        <div class="bcat-stat">
            <div class="bcat-stat-val" style="color:var(--accent)">
                {{ $categories->sum(fn($c) => $c->blogs_count ?? ($c->blogs()->count() ?? 0)) }}
            </div>
            <div class="bcat-stat-label">Total Posts</div>
        </div>
    </div>

    {{-- Table card --}}
    <div class="bcat-card">
        <div class="bcat-card-toolbar">
            <div class="bcat-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--rose)"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                All Categories
            </div>
            <div class="bcat-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" id="catSearch" class="bcat-search" placeholder="Search…" oninput="filterCats()">
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="bcat-table">
                <thead>
                    <tr>
                        <th style="width:52px">#</th>
                        <th>Category</th>
                        <th style="width:120px;text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody id="catBody">
                    @forelse($categories as $category)
                        <tr data-name="{{ strtolower($category->name) }}">
                            <td><div class="bcat-idx">{{ $loop->iteration }}</div></td>
                            <td>
                                <div class="bcat-cat-cell">
                                    <div class="bcat-avatar">{{ strtoupper(substr($category->name,0,2)) }}</div>
                                    <span class="bcat-cat-name">{{ $category->name }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="bcat-actions" style="justify-content:flex-end">
                                    <button class="bcat-icon-btn" title="Edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $category->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button class="bcat-icon-btn danger" title="Delete"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $category->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="bcat-empty">
                                    <div class="bcat-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                                    </div>
                                    <h5>No categories yet</h5>
                                    <p>Create your first blog category.</p>
                                    <button class="bcat-btn bcat-btn-primary bcat-btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#createModal">
                                        Add Category
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer count --}}
        @if($categories->count())
            <div style="padding:.75rem 1.4rem;border-top:1px solid var(--border);font-size:.78rem;color:var(--muted);">
                <span id="catCount"><strong>{{ $categories->count() }}</strong> {{ Str::plural('category', $categories->count()) }}</span>
            </div>
        @endif
    </div>
</div>

{{-- ══ CREATE MODAL ══ --}}
<div class="modal fade bcat-modal" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.blog-categories.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <div class="bcat-modal-icon rose">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                </div>
                <h5 class="modal-title">Add Blog Category</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="bcat-label">Category Name <span class="req">*</span></label>
                <input type="text" name="name" class="bcat-input" placeholder="e.g. Real Estate Tips" required autofocus>
            </div>
            <div class="modal-footer">
                <button type="button" class="bcat-btn bcat-btn-ghost bcat-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="bcat-btn bcat-btn-primary bcat-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Save Category
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══ EDIT & DELETE MODALS (per category) ══ --}}
@foreach($categories as $category)

    {{-- Edit --}}
    <div class="modal fade bcat-modal" id="editModal{{ $category->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.blog-categories.update', $category->id) }}" method="POST" class="modal-content">
                @csrf @method('PUT')
                <div class="modal-header">
                    <div class="bcat-modal-icon rose">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </div>
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="bcat-label">Category Name <span class="req">*</span></label>
                    <input type="text" name="name" class="bcat-input" value="{{ $category->name }}" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="bcat-btn bcat-btn-ghost bcat-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="bcat-btn bcat-btn-primary bcat-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete --}}
    <div class="modal fade bcat-modal" id="deleteModal{{ $category->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.blog-categories.destroy', $category->id) }}" method="POST" class="modal-content">
                @csrf @method('DELETE')
                <div class="modal-header">
                    <div class="bcat-modal-icon danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    </div>
                    <h5 class="modal-title" style="color:var(--danger)">Delete Category</h5>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="bcat-delete-box">
                        Delete <strong>{{ $category->name }}</strong>? Any blog posts in this category may be affected.
                        <br><br>
                        <span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="bcat-btn bcat-btn-ghost bcat-btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="bcat-btn bcat-btn-danger bcat-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

@endforeach

<script>
function filterCats(){
    const q=document.getElementById('catSearch').value.toLowerCase();
    const rows=document.querySelectorAll('#catBody tr[data-name]');
    let shown=0;
    rows.forEach(r=>{
        const ok=r.dataset.name.includes(q);
        r.style.display=ok?'':'none';
        if(ok)shown++;
    });
    const el=document.getElementById('catCount');
    if(el)el.innerHTML='<strong>'+shown+'</strong> '+( shown===1?'category':'categories');
}
</script>

@endsection