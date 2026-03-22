@extends('layouts.agents')
@section('title', $architecturalDesign->title . ' — Design Detail')
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
        --purple:   #7c3aed;
    }

    .ad-page { padding: 1.75rem 0 3rem; max-width: 1200px; margin: 0 auto; }

    /* ── Breadcrumb ── */
    .ad-breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: var(--muted); margin-bottom: 1.5rem; }
    .ad-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
    .ad-breadcrumb a:hover { color: var(--accent); }

    /* ── Top bar ── */
    .ad-topbar { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.75rem; }
    .ad-topbar-left h3 { font-size: 1.45rem; font-weight: 700; color: var(--text); margin: 0 0 .5rem; line-height: 1.2; }
    .ad-topbar-meta { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
    .ad-topbar-actions { display: flex; gap: .5rem; flex-wrap: wrap; align-items: center; }

    /* ── Badges ── */
    .ad-badge {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .24rem .7rem; border-radius: 100px; font-size: .69rem; font-weight: 600;
        border: 1px solid; white-space: nowrap;
    }
    .ad-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .ad-badge.approved { color: #166534; border-color: #bbf7d0; background: #f0fdf4; }
    .ad-badge.pending  { color: #92400e; border-color: #fde68a; background: #fffbeb; }
    .ad-badge.rejected { color: #991b1b; border-color: #fecaca; background: #fef2f2; }
    .ad-badge.free     { color: #166534; border-color: #bbf7d0; background: #f0fdf4; }
    .ad-badge.paid     { color: var(--accent); border-color: #e4c99050; background: #c9a96e0a; }
    .ad-badge.featured { color: var(--blue); border-color: #bfdbfe; background: #eff6ff; }
    .ad-badge.purple   { color: var(--purple); border-color: #ddd6fe; background: #f5f3ff; }

    /* ── Buttons ── */
    .ad-btn {
        display: inline-flex; align-items: center; gap: .45rem; padding: .62rem 1.25rem;
        border-radius: 8px; font-size: .84rem; font-weight: 600; border: none;
        cursor: pointer; transition: all .2s; text-decoration: none; font-family: inherit;
    }
    .ad-btn-primary { background: var(--accent); color: #fff; }
    .ad-btn-primary:hover { background: var(--accent-lt); color: #fff; }
    .ad-btn-ghost   { background: none; border: 1.5px solid var(--border); color: var(--text-dim); }
    .ad-btn-ghost:hover { border-color: var(--accent); color: var(--accent); }
    .ad-btn-danger  { background: none; border: 1.5px solid #fecaca; color: var(--danger); }
    .ad-btn-danger:hover { background: #fef2f2; }
    .ad-btn-sm { padding: .42rem .9rem; font-size: .78rem; }
    .ad-btn-success { background: none; border: 1.5px solid #bbf7d0; color: #166534; }
    .ad-btn-success:hover { background: #f0fdf4; }

    /* ── Layout ── */
    .ad-layout { display: grid; grid-template-columns: 1fr 300px; gap: 1.25rem; align-items: start; }
    .ad-main { display: flex; flex-direction: column; gap: 1.25rem; }
    .ad-side { display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: 80px; }

    /* ── Card ── */
    .ad-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .ad-card-header {
        display: flex; align-items: center; gap: .75rem;
        padding: .9rem 1.4rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }
    .ad-card-header-icon {
        width: 30px; height: 30px; border-radius: 7px; background: #c9a96e18;
        display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;
    }
    .ad-card-header h6 { margin: 0; font-size: .86rem; font-weight: 600; color: var(--text); }
    .ad-card-header .ad-card-header-action { margin-left: auto; }
    .ad-card-body { padding: 1.4rem; }

    /* ── Preview image ── */
    .ad-preview-hero {
        width: 100%; aspect-ratio: 16/8; background: var(--surface);
        border-bottom: 1px solid var(--border); position: relative; overflow: hidden;
    }
    .ad-preview-hero img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .ad-preview-hero-placeholder {
        width: 100%; height: 100%; display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: .75rem; color: var(--muted);
    }
    .ad-preview-hero-placeholder svg { opacity: .3; }
    .ad-preview-hero-placeholder span { font-size: .82rem; }
    .ad-preview-overlay {
        position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.45) 0%, transparent 50%);
        pointer-events: none;
    }
    .ad-preview-overlay-badges {
        position: absolute; bottom: 1rem; left: 1rem; display: flex; gap: .4rem; flex-wrap: wrap;
    }

    /* ── Description prose ── */
    .ad-prose { font-size: .9rem; color: var(--text-dim); line-height: 1.8; }
    .ad-prose p { margin-bottom: .9rem; }
    .ad-prose p:last-child { margin-bottom: 0; }
    .ad-no-desc { font-size: .84rem; color: var(--muted); font-style: italic; }

    /* ── Meta table ── */
    .ad-meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: 8px; overflow: hidden; }
    .ad-meta-cell { background: #fff; padding: .85rem 1rem; }
    .ad-meta-cell:hover { background: var(--surface); }
    .ad-meta-key   { font-size: .68rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); margin-bottom: .3rem; }
    .ad-meta-val   { font-size: .88rem; color: var(--text); font-weight: 500; }
    .ad-meta-val.accent { color: var(--accent); }
    .ad-meta-val.muted  { color: var(--muted); font-weight: 400; font-style: italic; }

    /* ── File download card ── */
    .ad-file-row {
        display: flex; align-items: center; gap: .85rem; padding: 1rem;
        border: 1px solid var(--border); border-radius: 8px; background: var(--surface);
    }
    .ad-file-icon {
        width: 42px; height: 42px; border-radius: 8px; display: flex; align-items: center;
        justify-content: center; font-size: .65rem; font-weight: 700; letter-spacing: .05em;
        flex-shrink: 0;
    }
    .ad-file-icon.pdf    { background: #fef2f2; color: #b91c1c; }
    .ad-file-icon.zip    { background: #fffbeb; color: #92400e; }
    .ad-file-icon.dwg    { background: #eff6ff; color: #1d4ed8; }
    .ad-file-icon.other  { background: #f5f3ff; color: var(--purple); }
    .ad-file-details { flex: 1; min-width: 0; }
    .ad-file-details strong { display: block; font-size: .84rem; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ad-file-details span   { font-size: .73rem; color: var(--muted); }

    /* ── Status quick-change ── */
    .ad-status-actions { display: flex; flex-direction: column; gap: .5rem; }
    .ad-status-btn {
        display: flex; align-items: center; gap: .6rem; padding: .65rem .9rem;
        border-radius: 8px; border: 1.5px solid var(--border); background: none;
        font-family: inherit; font-size: .82rem; font-weight: 500; cursor: pointer;
        transition: all .15s; color: var(--text-dim); text-align: left; width: 100%;
    }
    .ad-status-btn:hover { border-color: var(--accent); color: var(--text); background: #c9a96e06; }
    .ad-status-btn.current { border-color: currentColor; cursor: default; }
    .ad-status-btn.approved { color: #166534; border-color: #bbf7d0; background: #f0fdf4; }
    .ad-status-btn.pending  { color: #92400e; border-color: #fde68a; background: #fffbeb; }
    .ad-status-btn.rejected { color: #991b1b; border-color: #fecaca; background: #fef2f2; }

    /* ── User card ── */
    .ad-user-row { display: flex; align-items: center; gap: .85rem; }
    .ad-avatar {
        width: 40px; height: 40px; border-radius: 50%; background: #c9a96e20;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .85rem; color: var(--accent); flex-shrink: 0;
    }
    .ad-user-name  { font-size: .88rem; font-weight: 600; color: var(--text); }
    .ad-user-email { font-size: .75rem; color: var(--muted); margin-top: .1rem; }

    /* ── Info list ── */
    .ad-info-list { display: flex; flex-direction: column; gap: .7rem; }
    .ad-info-item { display: flex; align-items: flex-start; justify-content: space-between; gap: .5rem; font-size: .82rem; }
    .ad-info-item .lbl { color: var(--muted); display: flex; align-items: center; gap: .4rem; white-space: nowrap; }
    .ad-info-item .lbl svg { flex-shrink: 0; }
    .ad-info-item .val { color: var(--text-dim); text-align: right; word-break: break-all; }
    .ad-info-item .val.accent { color: var(--accent); font-weight: 600; }

    /* ── Alerts ── */
    .ad-alert { border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem; display: flex; gap: .6rem; align-items: flex-start; margin-bottom: 1.25rem; }
    .ad-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .ad-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    /* ── Divider ── */
    .ad-divider { height: 1px; background: var(--border); margin: 1rem 0; }

    @media (max-width: 960px) {
        .ad-layout { grid-template-columns: 1fr; }
        .ad-side { position: static; }
        .ad-meta-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 500px) {
        .ad-meta-grid { grid-template-columns: 1fr; }
        .ad-topbar { flex-direction: column; }
    }
</style>

<div class="ad-page">

    {{-- ── Breadcrumb ── --}}
    <nav class="ad-breadcrumb">
        <a href="{{ route('admin.architectural-designs.index') }}">Designs</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">{{ Str::limit($architecturalDesign->title, 50) }}</span>
    </nav>

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

    {{-- ── Top bar ── --}}
    <div class="ad-topbar">
        <div class="ad-topbar-left">
            <h3>{{ $architecturalDesign->title }}</h3>
            <div class="ad-topbar-meta">
                <span class="ad-badge {{ $architecturalDesign->status }}">
                    <span class="ad-badge-dot"></span>{{ ucfirst($architecturalDesign->status) }}
                </span>
                @if($architecturalDesign->is_free || $architecturalDesign->price == 0)
                    <span class="ad-badge free">Free</span>
                @else
                    <span class="ad-badge paid">${{ number_format($architecturalDesign->price, 2) }}</span>
                @endif
                @if($architecturalDesign->featured)
                    <span class="ad-badge featured">⭐ Featured</span>
                @endif
                @if($architecturalDesign->category)
                    <span class="ad-badge purple">{{ $architecturalDesign->category->name }}</span>
                @endif
            </div>
        </div>
        <div class="ad-topbar-actions">
            <a href="{{ route('admin.architectural-designs.edit', $architecturalDesign->id) }}" class="ad-btn ad-btn-ghost ad-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            @if($architecturalDesign->design_file)
                <a href="{{ asset('storage/' . $architecturalDesign->design_file) }}" download
                   class="ad-btn ad-btn-primary ad-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                    Download File
                </a>
            @endif
            <form method="POST" action="{{ route('admin.architectural-designs.destroy', $architecturalDesign->id) }}"
                  onsubmit="return confirm('Permanently delete this design?')">
                @csrf @method('DELETE')
                <button type="submit" class="ad-btn ad-btn-danger ad-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="ad-layout">

        {{-- ══ MAIN ══ --}}
        <div class="ad-main">

            {{-- ── Preview image ── --}}
            <div class="ad-card" style="overflow:hidden;">
                @if($architecturalDesign->preview_image)
                    <div class="ad-preview-hero">
                        <img src="{{ asset('storage/' . $architecturalDesign->preview_image) }}" alt="{{ $architecturalDesign->title }}">
                        <div class="ad-preview-overlay"></div>
                        <div class="ad-preview-overlay-badges">
                            <span class="ad-badge {{ $architecturalDesign->status }}" style="backdrop-filter:blur(8px)">
                                <span class="ad-badge-dot"></span>{{ ucfirst($architecturalDesign->status) }}
                            </span>
                            @if($architecturalDesign->featured)
                                <span class="ad-badge featured" style="backdrop-filter:blur(8px)">⭐ Featured</span>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="ad-preview-hero">
                        <div class="ad-preview-hero-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            <span>No preview image</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- ── Description ── --}}
            <div class="ad-card">
                <div class="ad-card-header">
                    <div class="ad-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg>
                    </div>
                    <h6>Description</h6>
                </div>
                <div class="ad-card-body">
                    @if($architecturalDesign->description)
                        <div class="ad-prose">
                            {!! nl2br(e($architecturalDesign->description)) !!}
                        </div>
                    @else
                        <p class="ad-no-desc">No description provided.</p>
                    @endif
                </div>
            </div>

            {{-- ── Design metadata ── --}}
            <div class="ad-card">
                <div class="ad-card-header">
                    <div class="ad-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                    </div>
                    <h6>Design Details</h6>
                </div>
                <div class="ad-card-body" style="padding:0;">
                    <div class="ad-meta-grid">
                        <div class="ad-meta-cell">
                            <div class="ad-meta-key">Slug</div>
                            <div class="ad-meta-val" style="font-family:monospace;font-size:.82rem;color:var(--text-dim)">{{ $architecturalDesign->slug }}</div>
                        </div>
                        <div class="ad-meta-cell">
                            <div class="ad-meta-key">Category</div>
                            <div class="ad-meta-val">{{ $architecturalDesign->category?->name ?? '—' }}</div>
                        </div>
                        <div class="ad-meta-cell">
                            <div class="ad-meta-key">Service</div>
                            <div class="ad-meta-val">{{ $architecturalDesign->service?->title ?? '—' }}</div>
                        </div>
                        <div class="ad-meta-cell">
                            <div class="ad-meta-key">Price</div>
                            <div class="ad-meta-val accent">
                                {{ ($architecturalDesign->is_free || $architecturalDesign->price == 0) ? 'Free' : '$' . number_format($architecturalDesign->price, 2) }}
                            </div>
                        </div>
                        <div class="ad-meta-cell">
                            <div class="ad-meta-key">Status</div>
                            <div class="ad-meta-val">
                                <span class="ad-badge {{ $architecturalDesign->status }}">
                                    <span class="ad-badge-dot"></span>{{ ucfirst($architecturalDesign->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="ad-meta-cell">
                            <div class="ad-meta-key">Featured</div>
                            <div class="ad-meta-val">{{ $architecturalDesign->featured ? '✅ Yes' : '—' }}</div>
                        </div>
                        <div class="ad-meta-cell">
                            <div class="ad-meta-key">Uploaded</div>
                            <div class="ad-meta-val">{{ $architecturalDesign->created_at->format('M j, Y') }}</div>
                        </div>
                        <div class="ad-meta-cell">
                            <div class="ad-meta-key">Last Updated</div>
                            <div class="ad-meta-val">{{ $architecturalDesign->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Design file ── --}}
            <div class="ad-card">
                <div class="ad-card-header">
                    <div class="ad-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    </div>
                    <h6>Design File</h6>
                </div>
                <div class="ad-card-body">
                    @if($architecturalDesign->design_file)
                        @php
                            $ext      = strtolower(pathinfo($architecturalDesign->design_file, PATHINFO_EXTENSION));
                            $iconClass = in_array($ext, ['pdf','zip','dwg']) ? $ext : 'other';
                            $filename  = basename($architecturalDesign->design_file);
                        @endphp
                        <div class="ad-file-row">
                            <div class="ad-file-icon {{ $iconClass }}">{{ strtoupper($ext) }}</div>
                            <div class="ad-file-details">
                                <strong>{{ $filename }}</strong>
                                <span>{{ strtoupper($ext) }} — design package</span>
                            </div>
                            <a href="{{ asset('storage/' . $architecturalDesign->design_file) }}"
                               download class="ad-btn ad-btn-ghost ad-btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                Download
                            </a>
                        </div>
                    @else
                        <p class="ad-no-desc" style="font-size:.84rem;color:var(--muted);font-style:italic;">No design file uploaded.</p>
                    @endif
                </div>
            </div>

        </div>{{-- /.ad-main --}}

        {{-- ══ SIDEBAR ══ --}}
        <div class="ad-side">

            {{-- ── Quick status change ── --}}
            <div class="ad-card">
                <div class="ad-card-header">
                    <div class="ad-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <h6>Change Status</h6>
                </div>
                <div class="ad-card-body">
                    <div class="ad-status-actions">
                        @foreach(['approved' => ['label' => 'Approve', 'icon' => '<path d="M20 6 9 17l-5-5"/>'], 'pending' => ['label' => 'Set Pending', 'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'], 'rejected' => ['label' => 'Reject', 'icon' => '<path d="M18 6 6 18M6 6l12 12"/>']] as $status => $meta)
                            @if($architecturalDesign->status === $status)
                                <div class="ad-status-btn {{ $status }} current">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $meta['icon'] !!}</svg>
                                    {{ $meta['label'] }}
                                    <span style="margin-left:auto;font-size:.7rem;opacity:.7">Current</span>
                                </div>
                            @else
                                <form method="POST" action="{{ route('admin.architectural-designs.status', $architecturalDesign->id) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $status }}">
                                    <button type="submit" class="ad-status-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $meta['icon'] !!}</svg>
                                        {{ $meta['label'] }}
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                    <div class="ad-divider"></div>
                    {{-- Featured toggle --}}
                    <form method="POST" action="{{ route('admin.architectural-designs.feature', $architecturalDesign->id) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="ad-status-btn" style="color:var(--blue);border-color:#bfdbfe;background:{{ $architecturalDesign->featured ? '#eff6ff' : 'transparent' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="{{ $architecturalDesign->featured ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            {{ $architecturalDesign->featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── Uploader / Owner ── --}}
            <div class="ad-card">
                <div class="ad-card-header">
                    <div class="ad-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                    </div>
                    <h6>Uploaded By</h6>
                </div>
                <div class="ad-card-body">
                    @if($architecturalDesign->user)
                        <div class="ad-user-row">
                            <div class="ad-avatar">{{ strtoupper(substr($architecturalDesign->user->name, 0, 2)) }}</div>
                            <div>
                                <div class="ad-user-name">{{ $architecturalDesign->user->name }}</div>
                                <div class="ad-user-email">{{ $architecturalDesign->user->email }}</div>
                            </div>
                        </div>
                    @else
                        <div class="ad-user-row">
                            <div class="ad-avatar" style="background:#f1f5f9;color:var(--muted);">AD</div>
                            <div>
                                <div class="ad-user-name">Admin</div>
                                <div class="ad-user-email">Uploaded by admin account</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ── Quick info ── --}}
            <div class="ad-card">
                <div class="ad-card-header">
                    <div class="ad-card-header-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h6>Quick Info</h6>
                </div>
                <div class="ad-card-body">
                    <div class="ad-info-list">
                        <div class="ad-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                                Category
                            </span>
                            <span class="val">{{ $architecturalDesign->category?->name ?? '—' }}</span>
                        </div>
                        <div class="ad-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                Service
                            </span>
                            <span class="val">{{ $architecturalDesign->service?->title ?? '—' }}</span>
                        </div>
                        <div class="ad-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v2m0 8v2m-3-7h6m-6 0a3 3 0 0 0 6 0"/></svg>
                                Price
                            </span>
                            <span class="val accent">
                                {{ ($architecturalDesign->is_free || $architecturalDesign->price == 0) ? 'Free' : '$' . number_format($architecturalDesign->price, 2) }}
                            </span>
                        </div>
                        <div class="ad-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                Uploaded
                            </span>
                            <span class="val">{{ $architecturalDesign->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="ad-info-item">
                            <span class="lbl">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Updated
                            </span>
                            <span class="val">{{ $architecturalDesign->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Danger zone ── --}}
            <div class="ad-card" style="border-color:#fecaca;">
                <div class="ad-card-header" style="background:#fef2f2;border-color:#fecaca;">
                    <div class="ad-card-header-icon" style="background:#fee2e2;color:var(--danger);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>
                    </div>
                    <h6 style="color:var(--danger);">Danger Zone</h6>
                </div>
                <div class="ad-card-body">
                    <p style="font-size:.8rem;color:var(--muted);margin-bottom:.85rem;line-height:1.5;">
                        Deleting this design will permanently remove the file and preview image from storage.
                    </p>
                    <form method="POST" action="{{ route('admin.architectural-designs.destroy', $architecturalDesign->id) }}"
                          onsubmit="return confirm('Permanently delete this design and all its files? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="ad-btn ad-btn-danger" style="width:100%;justify-content:center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                            Delete Design
                        </button>
                    </form>
                </div>
            </div>

        </div>{{-- /.ad-side --}}

    </div>{{-- /.ad-layout --}}
</div>

@endsection