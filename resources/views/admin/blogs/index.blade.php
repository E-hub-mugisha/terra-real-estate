@extends('layouts.app')
@section('title', 'News Posts')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--rose:#e11d48;--rose-lt:#fb7185;--green:#22c55e;--amber:#f59e0b;}
    .bl-page{padding:1.75rem 0 3rem;max-width:1320px;margin:0 auto;}
    .bl-topbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.75rem;}
    .bl-topbar h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .bl-topbar p{font-size:.82rem;color:var(--muted);margin:.15rem 0 0;}
    .bl-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.6rem 1.2rem;border-radius:8px;font-size:.84rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .bl-btn-primary{background:var(--rose);color:#fff;}.bl-btn-primary:hover{background:var(--rose-lt);color:#fff;transform:translateY(-1px);}
    .bl-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.bl-btn-ghost:hover{border-color:var(--rose);color:var(--rose);}
    .bl-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.bl-btn-danger:hover{background:#fef2f2;}
    .bl-btn-sm{padding:.38rem .85rem;font-size:.78rem;}
    .bl-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:center;margin-bottom:1.25rem;}
    .bl-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .bl-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .bl-stats{display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:1rem;margin-bottom:1.5rem;}
    .bl-stat{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:1rem 1.25rem;position:relative;overflow:hidden;}
    .bl-stat::before{content:'';position:absolute;top:0;left:0;width:3px;height:100%;background:var(--bc,var(--rose));}
    .bl-stat-val{font-size:1.55rem;font-weight:700;line-height:1;color:var(--bc,var(--rose));}
    .bl-stat-label{font-size:.7rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);margin-top:.3rem;}
    .bl-filters{display:flex;align-items:center;flex-wrap:wrap;gap:.75rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:.9rem 1.2rem;margin-bottom:1.25rem;}
    .bl-search-wrap{position:relative;flex:1;min-width:200px;max-width:320px;}
    .bl-search-wrap svg{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none;}
    .bl-search{width:100%;padding:.56rem .85rem .56rem 2.3rem;border:1.5px solid var(--border);border-radius:8px;font-size:.84rem;color:var(--text);background:var(--surface);outline:none;font-family:inherit;transition:border-color .2s;}
    .bl-search:focus{border-color:var(--rose);}
    .bl-filter-select{padding:.56rem .85rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);background:var(--surface);outline:none;cursor:pointer;font-family:inherit;}
    .bl-filter-select:focus{border-color:var(--rose);}
    .bl-count{margin-left:auto;font-size:.78rem;color:var(--muted);}
    .bl-count strong{color:var(--text-dim);}
    .bl-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .bl-card-toolbar{display:flex;align-items:center;justify-content:space-between;padding:.9rem 1.4rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .bl-card-title{display:flex;align-items:center;gap:.5rem;font-size:.86rem;font-weight:600;color:var(--text);}
    .bl-table{width:100%;border-collapse:collapse;font-size:.84rem;}
    .bl-table thead{background:var(--surface);}
    .bl-table th{padding:.75rem 1.1rem;text-align:left;font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap;}
    .bl-table td{padding:.85rem 1.1rem;border-bottom:1px solid var(--border);vertical-align:middle;}
    .bl-table tr:last-child td{border-bottom:none;}
    .bl-table tbody tr{transition:background .15s;}
    .bl-table tbody tr:hover{background:#fafafa;}
    /* post cell */
    .bl-post-cell{display:flex;align-items:center;gap:.85rem;}
    .bl-thumb{width:52px;height:40px;border-radius:6px;object-fit:cover;border:1px solid var(--border);flex-shrink:0;}
    .bl-thumb-placeholder{width:52px;height:40px;border-radius:6px;background:linear-gradient(135deg,#fce7f3,#fbe2e7);display:flex;align-items:center;justify-content:center;color:var(--rose-lt);flex-shrink:0;border:1px solid #fce7f3;}
    .bl-post-title{font-weight:600;color:var(--text);font-size:.87rem;text-decoration:none;transition:color .15s;display:block;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .bl-post-title:hover{color:var(--rose);}
    .bl-post-slug{font-size:.73rem;color:var(--muted);font-family:monospace;margin-top:.1rem;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    /* badges */
    .bl-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;border-radius:100px;font-size:.71rem;font-weight:600;white-space:nowrap;}
    .bl-badge-published{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .bl-badge-draft{background:#fffbeb;border:1px solid #fde68a;color:#92400e;}
    .bl-badge-cat{background:#fce7f3;border:1px solid #fbcfe8;color:var(--rose);font-size:.68rem;}
    /* author */
    .bl-author{display:flex;align-items:center;gap:.5rem;font-size:.81rem;color:var(--text-dim);}
    .bl-author-av{width:24px;height:24px;border-radius:50%;background:linear-gradient(135deg,var(--rose),var(--rose-lt));display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.6rem;color:#fff;flex-shrink:0;}
    /* actions */
    .bl-actions{display:flex;align-items:center;gap:.35rem;}
    .bl-icon-btn{width:30px;height:30px;border-radius:7px;border:1px solid var(--border);background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-dim);transition:all .15s;text-decoration:none;}
    .bl-icon-btn:hover{border-color:var(--rose);color:var(--rose);background:#fce7f308;}
    .bl-icon-btn.danger:hover{border-color:#fecaca;color:var(--danger);background:#fef2f2;}
    .bl-icon-btn.green:hover{border-color:#bbf7d0;color:var(--green);background:#f0fdf4;}
    /* empty */
    .bl-empty{text-align:center;padding:4rem 2rem;}
    .bl-empty-icon{width:54px;height:54px;border-radius:12px;background:#fce7f3;border:1px solid #fbcfe8;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;color:var(--rose);}
    .bl-empty h5{font-size:.96rem;font-weight:600;color:var(--text);margin:0 0 .4rem;}
    .bl-empty p{font-size:.82rem;color:var(--muted);margin:0 0 1.1rem;}
    /* pagination */
    .bl-pagination{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;padding:.9rem 1.2rem;border-top:1px solid var(--border);}
    .bl-pagination-info{font-size:.78rem;color:var(--muted);}
    .bl-pagination-info strong{color:var(--text-dim);}
    .bl-pages{display:flex;gap:.3rem;}
    .bl-page-btn{min-width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:none;color:var(--text-dim);font-size:.78rem;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;font-family:inherit;transition:all .15s;padding:0 .4rem;}
    .bl-page-btn:hover{border-color:var(--rose);color:var(--rose);}
    .bl-page-btn.current{background:var(--rose);color:#fff;border-color:var(--rose);font-weight:600;}
    .bl-page-btn.disabled{opacity:.35;pointer-events:none;}
    /* modal */
    .bl-modal .modal-content{border:1px solid var(--border);border-radius:var(--radius);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;}
    .bl-modal .modal-header{background:var(--surface);border-bottom:1px solid var(--border);padding:1rem 1.4rem;display:flex;align-items:center;gap:.75rem;}
    .bl-modal-icon{width:30px;height:30px;border-radius:7px;background:#fef2f2;color:var(--danger);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .bl-modal .modal-title{font-size:.92rem;font-weight:700;color:var(--danger);margin:0;}
    .bl-modal .modal-body{padding:1.4rem;}
    .bl-modal .modal-footer{padding:.85rem 1.4rem;border-top:1px solid var(--border);gap:.5rem;}
    .bl-delete-box{font-size:.87rem;color:var(--text-dim);line-height:1.6;padding:.85rem 1rem;border-radius:8px;border:1px solid #fecaca;background:#fef2f2;}
    .bl-delete-box strong{color:var(--text);}
</style>

<div class="bl-page">
    <div class="bl-topbar">
        <div><h4>News Posts</h4><p>Write, manage and publish news content.</p></div>
        <a href="{{ route('admin.blogs.create') }}" class="bl-btn bl-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            New Post
        </a>
    </div>

    @if(session('success'))
        <div class="bl-alert bl-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bl-alert bl-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="bl-stats">
        <div class="bl-stat" style="--bc:var(--rose)"><div class="bl-stat-val">{{ $stats['total'] }}</div><div class="bl-stat-label">Total Posts</div></div>
        <div class="bl-stat" style="--bc:var(--green)"><div class="bl-stat-val">{{ $stats['published'] }}</div><div class="bl-stat-label">Published</div></div>
        <div class="bl-stat" style="--bc:var(--amber)"><div class="bl-stat-val">{{ $stats['drafts'] }}</div><div class="bl-stat-label">Drafts</div></div>
        <div class="bl-stat" style="--bc:var(--accent)"><div class="bl-stat-val">{{ $stats['categories'] }}</div><div class="bl-stat-label">Categories</div></div>
    </div>

    {{-- Filters --}}
    <div class="bl-filters">
        <div class="bl-search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="blSearch" class="bl-search" placeholder="Search title, slug, author…" oninput="filterBlogs()">
        </div>
        <select id="blCatFilter" class="bl-filter-select" onchange="filterBlogs()">
            <option value="">All categories</option>
            @foreach($categories as $cat)
                <option value="{{ strtolower($cat->name) }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <select id="blStatusFilter" class="bl-filter-select" onchange="filterBlogs()">
            <option value="">All statuses</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
        <p class="bl-count" id="blCount"><strong>{{ $blogs->count() }}</strong> post{{ $blogs->count()===1?'':'s' }}</p>
    </div>

    {{-- Table --}}
    <div class="bl-card">
        <div class="bl-card-toolbar">
            <div class="bl-card-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--rose)"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                All Posts
            </div>
        </div>
        <div style="overflow-x:auto">
            <table class="bl-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll" style="cursor:pointer;accent-color:var(--rose);"></th>
                        <th>Post</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Published</th>
                        <th style="width:110px">Actions</th>
                    </tr>
                </thead>
                <tbody id="blBody">
                    @forelse($blogs as $blog)
                        <tr data-name="{{ strtolower($blog->title . ' ' . $blog->slug . ' ' . ($blog->author?->name ?? '')) }}"
                            data-cat="{{ strtolower($blog->category?->name ?? '') }}"
                            data-status="{{ $blog->is_published ? 'published' : 'draft' }}">
                            <td><input type="checkbox" class="row-check" value="{{ $blog->id }}" style="cursor:pointer;accent-color:var(--rose);"></td>
                            <td>
                                <div class="bl-post-cell">
                                    @if($blog->featured_image)
                                        <img src="{{ asset('storage/'.$blog->featured_image) }}" alt="{{ $blog->title }}" class="bl-thumb">
                                    @else
                                        <div class="bl-thumb-placeholder">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                        </div>
                                    @endif
                                    <div style="min-width:0">
                                        <a href="{{ route('admin.blogs.show',$blog->id) }}" class="bl-post-title" title="{{ $blog->title }}">{{ $blog->title }}</a>
                                        <div class="bl-post-slug">/{{ $blog->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($blog->category)
                                    <span class="bl-badge bl-badge-cat">{{ $blog->category->name }}</span>
                                @else
                                    <span style="color:var(--muted);font-size:.8rem">—</span>
                                @endif
                            </td>
                            <td>
                                @if($blog->is_published)
                                    <span class="bl-badge bl-badge-published">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="7" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                        Published
                                    </span>
                                @else
                                    <span class="bl-badge bl-badge-draft">Draft</span>
                                @endif
                            </td>
                            <td>
                                <div class="bl-author">
                                    <div class="bl-author-av">{{ strtoupper(substr($blog->author?->name ?? '?', 0, 2)) }}</div>
                                    <span>{{ $blog->author?->name ?? '—' }}</span>
                                </div>
                            </td>
                            <td style="font-size:.81rem;color:var(--text-dim)">
                                @if($blog->published_at)
                                    {{ $blog->published_at->format('M j, Y') }}
                                    <div style="font-size:.7rem;color:var(--muted)">{{ $blog->published_at->diffForHumans() }}</div>
                                @else
                                    <span style="color:var(--muted);font-style:italic">Not published</span>
                                @endif
                            </td>
                            <td>
                                <div class="bl-actions">
                                    <a href="{{ route('admin.blogs.show',$blog->id) }}" class="bl-icon-btn" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <a href="{{ route('admin.blogs.edit',$blog->id) }}" class="bl-icon-btn" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.blogs.toggle',$blog->id) }}" style="display:inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bl-icon-btn {{ $blog->is_published ? 'danger' : 'green' }}" title="{{ $blog->is_published ? 'Unpublish' : 'Publish' }}">
                                            @if($blog->is_published)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" x2="23" y1="1" y2="23"/></svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                                            @endif
                                        </button>
                                    </form>
                                    <button class="bl-icon-btn danger" data-bs-toggle="modal" data-bs-target="#deleteBlog{{ $blog->id }}" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">
                            <div class="bl-empty">
                                <div class="bl-empty-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
                                <h5>No blog posts yet</h5>
                                <p>Write and publish your first post.</p>
                                <a href="{{ route('admin.blogs.create') }}" class="bl-btn bl-btn-primary bl-btn-sm">New Post</a>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($blogs,'hasPages') && $blogs->hasPages())
            <div class="bl-pagination">
                <p class="bl-pagination-info">Showing <strong>{{ $blogs->firstItem() }}</strong>–<strong>{{ $blogs->lastItem() }}</strong> of <strong>{{ $blogs->total() }}</strong></p>
                <div class="bl-pages">
                    @if($blogs->onFirstPage())<span class="bl-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></span>
                    @else<a href="{{ $blogs->previousPageUrl() }}" class="bl-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></a>@endif
                    @foreach($blogs->getUrlRange(max(1,$blogs->currentPage()-2),min($blogs->lastPage(),$blogs->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="bl-page-btn {{ $page==$blogs->currentPage()?'current':'' }}">{{ $page }}</a>
                    @endforeach
                    @if($blogs->hasMorePages())<a href="{{ $blogs->nextPageUrl() }}" class="bl-page-btn"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></a>
                    @else<span class="bl-page-btn disabled"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></span>@endif
                </div>
            </div>
        @endif
    </div>
</div>

@foreach($blogs as $blog)
<div class="modal fade bl-modal" id="deleteBlog{{ $blog->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.blogs.destroy',$blog->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="bl-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg></div>
                <h5 class="modal-title">Delete Post</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="bl-delete-box">Delete <strong>{{ $blog->title }}</strong>? The featured image will also be permanently removed.<br><br><span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="bl-btn bl-btn-ghost bl-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="bl-btn bl-btn-danger bl-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
function filterBlogs(){
    const q=document.getElementById('blSearch').value.toLowerCase();
    const cat=document.getElementById('blCatFilter').value;
    const status=document.getElementById('blStatusFilter').value;
    const rows=document.querySelectorAll('#blBody tr[data-name]');
    let shown=0;
    rows.forEach(r=>{
        const ok=r.dataset.name.includes(q)&&(!cat||r.dataset.cat===cat)&&(!status||r.dataset.status===status);
        r.style.display=ok?'':'none';
        if(ok)shown++;
    });
    document.getElementById('blCount').innerHTML='<strong>'+shown+'</strong> post'+(shown===1?'':'s');
}
document.getElementById('selectAll').addEventListener('change',function(){
    document.querySelectorAll('.row-check').forEach(cb=>cb.checked=this.checked);
});
</script>
@endsection