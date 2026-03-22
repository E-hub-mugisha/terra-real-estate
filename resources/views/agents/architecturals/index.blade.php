@extends('layouts.agents')
@section('title', 'Architectural Designs')
@section('content')

<style>
    :root {
        --accent:   #c9a96e;
        --accent-lt:#e4c990;
        --danger:   #dc3545;
        --success:  #198754;
        --warning:  #f59e0b;
        --border:   #e2e8f0;
        --surface:  #f8fafc;
        --muted:    #94a3b8;
        --text:     #1e293b;
        --text-dim: #64748b;
        --radius:   10px;
        --blue:     #3b82f6;
    }

    .ad-page { padding: 1.75rem 0 3rem; max-width: 1320px; margin: 0 auto; }

    /* ── Top bar ── */
    .ad-topbar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1.75rem;
    }
    .ad-topbar-left h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .ad-topbar-left p  { font-size: .82rem; color: var(--text-dim); margin: .15rem 0 0; }
    .ad-btn {
        display: inline-flex; align-items: center; gap: .45rem;
        padding: .62rem 1.25rem; border-radius: 8px; font-size: .84rem; font-weight: 600;
        border: none; cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .ad-btn-primary { background: var(--accent); color: #fff; }
    .ad-btn-primary:hover { background: var(--accent-lt); color: #fff; transform: translateY(-1px); }
    .ad-btn-ghost { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .ad-btn-ghost:hover { border-color: var(--accent); color: var(--accent); }
    .ad-btn-sm { padding: .38rem .85rem; font-size: .78rem; }
    .ad-btn-danger-ghost { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .ad-btn-danger-ghost:hover { background: #fef2f2; }

    /* ── Stats row ── */
    .ad-stats { display: grid; grid-template-columns: repeat(auto-fill,minmax(160px,1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .ad-stat {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        padding: 1rem 1.25rem; display: flex; flex-direction: column; gap: .3rem;
    }
    .ad-stat-label { font-size: .7rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); }
    .ad-stat-value { font-size: 1.6rem; font-weight: 700; color: var(--text); line-height: 1; }
    .ad-stat-value.accent  { color: var(--accent); }
    .ad-stat-value.success { color: var(--success); }
    .ad-stat-value.warning { color: var(--warning); }
    .ad-stat-value.danger  { color: var(--danger); }

    /* ── Filters card ── */
    .ad-filters {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        padding: 1rem 1.25rem; display: flex; flex-wrap: wrap; gap: .75rem;
        align-items: center; margin-bottom: 1.25rem;
    }
    .ad-search-wrap { position: relative; flex: 1; min-width: 220px; max-width: 360px; }
    .ad-search-wrap svg { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .ad-search-input {
        width: 100%; padding: .58rem .85rem .58rem 2.3rem;
        border: 1.5px solid var(--border); border-radius: 8px; font-size: .84rem;
        color: var(--text); background: var(--surface); outline: none; font-family: inherit;
        transition: border-color .2s;
    }
    .ad-search-input:focus { border-color: var(--accent); }
    .ad-select {
        padding: .56rem .85rem; border: 1.5px solid var(--border); border-radius: 8px;
        font-size: .82rem; color: var(--text-dim); background: var(--surface);
        outline: none; cursor: pointer; font-family: inherit; transition: border-color .2s;
    }
    .ad-select:focus { border-color: var(--accent); }
    .ad-filter-chips { display: flex; gap: .4rem; flex-wrap: wrap; }
    .ad-chip {
        padding: .38rem .85rem; border-radius: 100px; border: 1.5px solid var(--border);
        font-size: .76rem; font-weight: 500; color: var(--text-dim); background: none;
        cursor: pointer; text-decoration: none; transition: all .15s; white-space: nowrap;
    }
    .ad-chip:hover, .ad-chip.active { border-color: var(--accent); color: var(--accent); background: #c9a96e0d; }
    .ad-results-meta { margin-left: auto; font-size: .78rem; color: var(--muted); white-space: nowrap; }
    .ad-results-meta strong { color: var(--text-dim); }

    /* ── Table card ── */
    .ad-table-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .ad-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .ad-table thead { background: var(--surface); border-bottom: 1px solid var(--border); }
    .ad-table th {
        padding: .8rem 1rem; text-align: left; font-size: .7rem; font-weight: 700;
        letter-spacing: .08em; text-transform: uppercase; color: var(--muted);
        white-space: nowrap;
    }
    .ad-table th.sortable { cursor: pointer; user-select: none; }
    .ad-table th.sortable:hover { color: var(--accent); }
    .ad-table td { padding: .9rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .ad-table tr:last-child td { border-bottom: none; }
    .ad-table tbody tr { transition: background .15s; }
    .ad-table tbody tr:hover { background: #fafafa; }

    /* ── Design preview cell ── */
    .ad-design-cell { display: flex; align-items: center; gap: .85rem; }
    .ad-preview-thumb {
        width: 52px; height: 52px; border-radius: 8px; object-fit: cover;
        background: var(--surface); border: 1px solid var(--border); flex-shrink: 0;
    }
    .ad-preview-placeholder {
        width: 52px; height: 52px; border-radius: 8px; background: #c9a96e12;
        border: 1px solid #c9a96e30; display: flex; align-items: center; justify-content: center;
        color: var(--accent); flex-shrink: 0;
    }
    .ad-design-title {
        font-weight: 600; color: var(--text); font-size: .86rem;
        text-decoration: none; transition: color .15s;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .ad-design-title:hover { color: var(--accent); }
    .ad-design-slug { font-size: .73rem; color: var(--muted); margin-top: .15rem; }

    /* ── Badges ── */
    .ad-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .22rem .65rem; border-radius: 100px; font-size: .68rem; font-weight: 600;
        border: 1px solid; white-space: nowrap;
    }
    .ad-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .ad-badge.approved { color: #166534; border-color: #bbf7d0; background: #f0fdf4; }
    .ad-badge.pending  { color: #92400e; border-color: #fde68a; background: #fffbeb; }
    .ad-badge.rejected { color: #991b1b; border-color: #fecaca; background: #fef2f2; }

    .ad-badge.free    { color: #166534; border-color: #bbf7d0; background: #f0fdf4; }
    .ad-badge.paid    { color: var(--accent); border-color: #e4c99050; background: #c9a96e0a; }
    .ad-badge.featured { color: var(--blue); border-color: #bfdbfe; background: #eff6ff; }

    /* ── Actions ── */
    .ad-actions { display: flex; align-items: center; gap: .35rem; }
    .ad-icon-btn {
        width: 30px; height: 30px; border-radius: 6px; border: 1px solid var(--border);
        background: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
        color: var(--text-dim); transition: all .15s; text-decoration: none;
    }
    .ad-icon-btn:hover { border-color: var(--accent); color: var(--accent); background: #c9a96e08; }
    .ad-icon-btn.danger:hover { border-color: #fecaca; color: var(--danger); background: #fef2f2; }

    /* ── Empty state ── */
    .ad-empty {
        text-align: center; padding: 4rem 2rem;
    }
    .ad-empty-icon {
        width: 60px; height: 60px; border-radius: 14px; background: #c9a96e12;
        border: 1px solid #c9a96e30; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.25rem; color: var(--accent);
    }
    .ad-empty h5 { font-size: 1rem; font-weight: 600; color: var(--text); margin: 0 0 .5rem; }
    .ad-empty p  { font-size: .84rem; color: var(--muted); margin: 0 0 1.25rem; }

    /* ── Pagination ── */
    .ad-pagination { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; padding: 1rem 1.25rem; border-top: 1px solid var(--border); }
    .ad-pagination-info { font-size: .78rem; color: var(--muted); }
    .ad-pagination-info strong { color: var(--text-dim); }
    .ad-pages { display: flex; gap: .3rem; }
    .ad-page-btn {
        min-width: 34px; height: 34px; border-radius: 6px; border: 1px solid var(--border);
        background: none; color: var(--text-dim); font-size: .8rem; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        text-decoration: none; font-family: inherit; transition: all .15s; padding: 0 .5rem;
    }
    .ad-page-btn:hover { border-color: var(--accent); color: var(--accent); }
    .ad-page-btn.current { background: var(--accent); color: #fff; border-color: var(--accent); font-weight: 600; }
    .ad-page-btn.disabled { opacity: .35; pointer-events: none; }

    /* ── Alerts ── */
    .ad-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: flex-start; margin-bottom: 1.25rem; }
    .ad-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .ad-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    /* ── Responsive ── */
    .ad-table-wrap { overflow-x: auto; }
    @media (max-width: 768px) {
        .ad-results-meta { display: none; }
        .ad-stats { grid-template-columns: repeat(2,1fr); }
    }
</style>

<div class="ad-page">

    {{-- ── Top bar ── --}}
    <div class="ad-topbar">
        <div class="ad-topbar-left">
            <h4>Architectural Designs</h4>
            <p>Manage all uploaded design files and previews.</p>
        </div>
        <a href="{{ route('agent.designs.create') }}" class="ad-btn ad-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            New Design
        </a>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
        <div class="ad-alert ad-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="ad-alert ad-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="ad-stats">
        <div class="ad-stat">
            <span class="ad-stat-label">Total</span>
            <span class="ad-stat-value accent">{{ $stats['total'] ?? $designs->total() }}</span>
        </div>
        <div class="ad-stat">
            <span class="ad-stat-label">Approved</span>
            <span class="ad-stat-value success">{{ $stats['approved'] ?? 0 }}</span>
        </div>
        <div class="ad-stat">
            <span class="ad-stat-label">Pending</span>
            <span class="ad-stat-value warning">{{ $stats['pending'] ?? 0 }}</span>
        </div>
        <div class="ad-stat">
            <span class="ad-stat-label">Rejected</span>
            <span class="ad-stat-value danger">{{ $stats['rejected'] ?? 0 }}</span>
        </div>
        <div class="ad-stat">
            <span class="ad-stat-label">Free</span>
            <span class="ad-stat-value">{{ $stats['free'] ?? 0 }}</span>
        </div>
        <div class="ad-stat">
            <span class="ad-stat-label">Featured</span>
            <span class="ad-stat-value" style="color:var(--blue)">{{ $stats['featured'] ?? 0 }}</span>
        </div>
    </div>

    {{-- ── Filters ── --}}
    <div class="ad-filters">
        <form method="GET" action="{{ route('agent.designs.index') }}" style="display:contents">

            <div class="ad-search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" name="search" class="ad-search-input"
                       placeholder="Search title or slug…"
                       value="{{ request('search') }}">
            </div>

            <select name="category" class="ad-select" onchange="this.form.submit()">
                <option value="">All categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <select name="sort" class="ad-select" onchange="this.form.submit()">
                <option value="latest"    {{ request('sort','latest') === 'latest'    ? 'selected' : '' }}>Latest first</option>
                <option value="oldest"    {{ request('sort') === 'oldest'             ? 'selected' : '' }}>Oldest first</option>
                <option value="price_asc" {{ request('sort') === 'price_asc'          ? 'selected' : '' }}>Price ↑</option>
                <option value="price_desc"{{ request('sort') === 'price_desc'         ? 'selected' : '' }}>Price ↓</option>
                <option value="title"     {{ request('sort') === 'title'              ? 'selected' : '' }}>Title A–Z</option>
            </select>

            <div class="ad-filter-chips">
                <a href="{{ route('agent.designs.index', array_merge(request()->except('status'), [])) }}"
                   class="ad-chip {{ !request('status') ? 'active' : '' }}">All</a>
                <a href="{{ route('agent.designs.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}"
                   class="ad-chip {{ request('status') === 'pending' ? 'active' : '' }}">Pending</a>
                <a href="{{ route('agent.designs.index', array_merge(request()->except('status'), ['status' => 'approved'])) }}"
                   class="ad-chip {{ request('status') === 'approved' ? 'active' : '' }}">Approved</a>
                <a href="{{ route('agent.designs.index', array_merge(request()->except('status'), ['status' => 'rejected'])) }}"
                   class="ad-chip {{ request('status') === 'rejected' ? 'active' : '' }}">Rejected</a>
                <a href="{{ route('agent.designs.index', array_merge(request()->except('featured'), ['featured' => '1'])) }}"
                   class="ad-chip {{ request('featured') === '1' ? 'active' : '' }}">⭐ Featured</a>
                <a href="{{ route('agent.designs.index', array_merge(request()->except('free'), ['free' => '1'])) }}"
                   class="ad-chip {{ request('free') === '1' ? 'active' : '' }}">Free only</a>
            </div>

            <button type="submit" style="display:none"></button>
        </form>

        <p class="ad-results-meta">
            Showing <strong>{{ $designs->firstItem() }}–{{ $designs->lastItem() }}</strong>
            of <strong>{{ $designs->total() }}</strong>
        </p>
    </div>

    {{-- ── Table ── --}}
    <div class="ad-table-card">
        <div class="ad-table-wrap">
            <table class="ad-table">
                <thead>
                    <tr>
                        <th style="width:36px;">
                            <input type="checkbox" id="selectAll" style="cursor:pointer;accent-color:var(--accent);">
                        </th>
                        <th class="sortable">Design</th>
                        <th>Category</th>
                        <th>Service</th>
                        <th class="sortable">Price</th>
                        <th>Status</th>
                        <th>Flags</th>
                        <th class="sortable">Uploaded</th>
                        <th style="width:110px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($designs as $design)
                        <tr>
                            {{-- Checkbox --}}
                            <td>
                                <input type="checkbox" class="row-check" value="{{ $design->id }}"
                                       style="cursor:pointer;accent-color:var(--accent);">
                            </td>

                            {{-- Design preview + title --}}
                            <td>
                                <div class="ad-design-cell">
                                    @if($design->preview_image)
                                        <img src="{{ asset('storage/' . $design->preview_image) }}"
                                             alt="{{ $design->title }}" class="ad-preview-thumb">
                                    @else
                                        <div class="ad-preview-placeholder">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('agent.designs.show', $design->id) }}"
                                           class="ad-design-title">{{ $design->title }}</a>
                                        <div class="ad-design-slug">{{ $design->slug }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td style="color:var(--text-dim);font-size:.82rem;">
                                {{ $design->category?->name ?? '—' }}
                            </td>

                            {{-- Service --}}
                            <td style="color:var(--text-dim);font-size:.82rem;">
                                {{ $design->service?->title ?? '—' }}
                            </td>

                            {{-- Price --}}
                            <td>
                                @if($design->is_free || $design->price == 0)
                                    <span class="ad-badge free">Free</span>
                                @else
                                    <span style="font-weight:600;color:var(--accent)">${{ number_format($design->price, 2) }}</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="ad-badge {{ $design->status }}">
                                    <span class="ad-badge-dot"></span>
                                    {{ ucfirst($design->status) }}
                                </span>
                            </td>

                            {{-- Flags --}}
                            <td>
                                <div style="display:flex;gap:.3rem;flex-wrap:wrap;">
                                    @if($design->featured)
                                        <span class="ad-badge featured">Featured</span>
                                    @endif
                                    @if($design->design_file)
                                        <span class="ad-badge" style="color:#7c3aed;border-color:#ddd6fe;background:#f5f3ff;">
                                            File
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Uploaded ── --}}
                            <td style="color:var(--text-dim);font-size:.8rem;white-space:nowrap;">
                                {{ $design->created_at->format('M j, Y') }}<br>
                                <span style="color:var(--muted);font-size:.72rem">{{ $design->created_at->diffForHumans() }}</span>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="ad-actions">
                                    {{-- View --}}
                                    <a href="{{ route('agent.designs.show', $design->id) }}"
                                       class="ad-icon-btn" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ route('agent.designs.edit', $design->id) }}"
                                       class="ad-icon-btn" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    {{-- Download design file --}}
                                    @if($design->design_file)
                                        <a href="{{ asset('storage/' . $design->design_file) }}"
                                           download class="ad-icon-btn" title="Download file">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                        </a>
                                    @endif
                                    {{-- Delete --}}
                                    <form method="POST"
                                          action="{{ route('agent.designs.destroy', $design->id) }}"
                                          onsubmit="return confirm('Delete this design? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ad-icon-btn danger" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="ad-empty">
                                    <div class="ad-empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    </div>
                                    <h5>No designs found</h5>
                                    <p>
                                        @if(request()->hasAny(['search','status','category','featured','free']))
                                            Try adjusting your filters.
                                        @else
                                            Upload your first architectural design to get started.
                                        @endif
                                    </p>
                                    @if(request()->hasAny(['search','status','category','featured','free']))
                                        <a href="{{ route('agent.designs.index') }}" class="ad-btn ad-btn-ghost ad-btn-sm">Clear filters</a>
                                    @else
                                        <a href="{{ route('agent.designs.create') }}" class="ad-btn ad-btn-primary ad-btn-sm">Upload Design</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($designs->hasPages())
            <div class="ad-pagination">
                <p class="ad-pagination-info">
                    Showing <strong>{{ $designs->firstItem() }}</strong>–<strong>{{ $designs->lastItem() }}</strong>
                    of <strong>{{ $designs->total() }}</strong> designs
                </p>
                <div class="ad-pages">
                    {{-- Prev --}}
                    @if($designs->onFirstPage())
                        <span class="ad-page-btn disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        </span>
                    @else
                        <a href="{{ $designs->previousPageUrl() }}" class="ad-page-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        </a>
                    @endif

                    @foreach($designs->getUrlRange(max(1,$designs->currentPage()-2), min($designs->lastPage(),$designs->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}" class="ad-page-btn {{ $page == $designs->currentPage() ? 'current' : '' }}">{{ $page }}</a>
                    @endforeach

                    {{-- Next --}}
                    @if($designs->hasMorePages())
                        <a href="{{ $designs->nextPageUrl() }}" class="ad-page-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    @else
                        <span class="ad-page-btn disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

</div>

<script>
/* ── Select all checkbox ── */
document.getElementById('selectAll').addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
});
document.querySelectorAll('.row-check').forEach(cb => {
    cb.addEventListener('change', () => {
        const all   = document.querySelectorAll('.row-check');
        const checked = document.querySelectorAll('.row-check:checked');
        document.getElementById('selectAll').indeterminate = checked.length > 0 && checked.length < all.length;
        document.getElementById('selectAll').checked = checked.length === all.length;
    });
});
</script>

@endsection