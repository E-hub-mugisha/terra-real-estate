@extends('layouts.app')
@section('title', 'House Details — '.$house->title)
@section('content')

<style>
    :root {
        --accent:      #D05208;
        --accent-lt:   #dfc28f;
        --accent-dim:  #D0520818;
        --border:      #e8e3db;
        --border-md:   #d5cec3;
        --surface:     #faf8f5;
        --muted:       #a89f92;
        --text:        #1e1a14;
        --text-dim:    #6b6259;
        --radius:      12px;
        --radius-sm:   8px;
        --shadow-card: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.04);
    }

    /* ── Top bar ── */
    .hd-topbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px; }

    .hd-back-btn {
        display:inline-flex; align-items:center; gap:6px; padding:7px 14px;
        border:1.5px solid var(--border-md); border-radius:var(--radius-sm);
        background:#fff; font-size:.81rem; font-weight:500; color:var(--text-dim);
        transition:all .18s; text-decoration:none;
    }
    .hd-back-btn:hover { border-color:var(--accent); color:var(--accent); background:var(--accent-dim); }

    .hd-action-btn {
        display:inline-flex; align-items:center; gap:6px; padding:7px 14px;
        border-radius:var(--radius-sm); font-size:.81rem; font-weight:600;
        border:none; cursor:pointer; transition:all .18s; text-decoration:none;
    }
    .hd-btn-edit    { background:#fef9c3; color:#854d0e; border:1.5px solid #fde68a; }
    .hd-btn-edit:hover { background:#fde68a; color:#78350f; }
    .hd-btn-approve { background:#dcfce7; color:#166534; border:1.5px solid #86efac; }
    .hd-btn-approve:hover { background:#86efac; color:#14532d; }
    .hd-btn-delete  { background:#fef2f2; color:#dc2626; border:1.5px solid #fca5a5; }
    .hd-btn-delete:hover { background:#fca5a5; color:#991b1b; }

    /* ── Card ── */
    .hd-card { background:#fff; border:1px solid var(--border); border-radius:var(--radius); box-shadow:var(--shadow-card); margin-bottom:16px; overflow:hidden; }
    .hd-card-head { padding:13px 18px; border-bottom:1px solid var(--surface); display:flex; align-items:center; justify-content:space-between; gap:10px; background:var(--surface); }
    .hd-card-head-title { font-size:.875rem; font-weight:700; color:var(--text); margin:0; display:flex; align-items:center; gap:6px; }
    .hd-card-head-title svg { width:14px; height:14px; color:var(--muted); }
    .hd-card-body { padding:18px; }

    /* ── Gallery ── */
    .hd-gallery { display:grid; grid-template-columns:1fr 1fr; grid-template-rows:260px 170px; gap:8px; border-radius:var(--radius); overflow:hidden; margin-bottom:24px; }
    .hd-gal-main  { grid-row:1/3; position:relative; overflow:hidden; background:var(--border); }
    .hd-gal-thumb { position:relative; overflow:hidden; background:var(--border); }
    .hd-gal-main img, .hd-gal-thumb img { width:100%; height:100%; object-fit:cover; display:block; transition:transform .45s ease; cursor:pointer; }
    .hd-gal-main:hover img, .hd-gal-thumb:hover img { transform:scale(1.04); }
    .hd-gal-ph { width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,var(--surface),var(--border)); }
    .hd-gal-ph svg { width:36px; height:36px; color:var(--border-md); }

    .hd-photo-actions { position:absolute; top:8px; right:8px; display:flex; gap:5px; z-index:3; }
    .hd-photo-btn {
        width:30px; height:30px; border-radius:7px;
        background:rgba(255,255,255,.85); backdrop-filter:blur(6px);
        border:1px solid rgba(255,255,255,.5); display:grid; place-items:center;
        cursor:pointer; color:var(--text-dim); transition:all .18s; text-decoration:none;
    }
    .hd-photo-btn:hover { background:#fff; color:var(--accent); }
    .hd-photo-btn svg { width:13px; height:13px; }
    .hd-photo-count { position:absolute; bottom:8px; left:8px; padding:2px 8px; border-radius:5px; background:rgba(0,0,0,.55); color:#fff; font-size:.68rem; font-weight:600; z-index:3; cursor:pointer; }
    .hd-photo-count:hover { background:rgba(0,0,0,.75); }

    /* ── Lightbox ── */
    .hd-lightbox { display:none; position:fixed; inset:0; background:rgba(0,0,0,.95); z-index:9999; overflow:hidden; }
    .hd-lightbox.active { display:flex; flex-direction:column; animation:fadeIn .3s ease; }
    @keyframes fadeIn { from{opacity:0} to{opacity:1} }
    .hd-lightbox-header { display:flex; align-items:center; justify-content:space-between; padding:16px 24px; border-bottom:1px solid rgba(255,255,255,.1); background:rgba(0,0,0,.5); backdrop-filter:blur(10px); }
    .hd-lightbox-title { color:#fff; font-size:.9rem; font-weight:600; margin:0; }
    .hd-lightbox-counter { color:rgba(255,255,255,.7); font-size:.8rem; margin:0; }
    .hd-lightbox-controls { display:flex; gap:8px; }
    .hd-lightbox-btn { width:36px; height:36px; border-radius:6px; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .2s; }
    .hd-lightbox-btn:hover { background:rgba(255,255,255,.2); }
    .hd-lightbox-btn svg { width:18px; height:18px; }
    .hd-lightbox-body { flex:1; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden; }
    .hd-lightbox-image { max-width:100%; max-height:100%; object-fit:contain; animation:zoomIn .3s ease; }
    @keyframes zoomIn { from{opacity:0;transform:scale(.95)} to{opacity:1;transform:scale(1)} }
    .hd-lightbox-nav { position:absolute; top:50%; transform:translateY(-50%); width:100%; display:flex; justify-content:space-between; padding:0 20px; pointer-events:none; }
    .hd-lightbox-arrow { width:44px; height:44px; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.2); border-radius:6px; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all .2s; pointer-events:all; }
    .hd-lightbox-arrow:hover { background:rgba(255,255,255,.25); }
    .hd-lightbox-arrow svg { width:20px; height:20px; }
    .hd-lightbox-footer { padding:16px 24px; border-top:1px solid rgba(255,255,255,.1); background:rgba(0,0,0,.5); backdrop-filter:blur(10px); }
    .hd-lightbox-thumbnails { display:flex; gap:8px; overflow-x:auto; scroll-behavior:smooth; padding:4px; }
    .hd-lightbox-thumbnails::-webkit-scrollbar { height:4px; }
    .hd-lightbox-thumbnails::-webkit-scrollbar-track { background:rgba(255,255,255,.05); border-radius:2px; }
    .hd-lightbox-thumbnails::-webkit-scrollbar-thumb { background:rgba(255,255,255,.2); border-radius:2px; }
    .hd-lightbox-thumbnail { min-width:56px; width:56px; height:56px; border-radius:6px; overflow:hidden; cursor:pointer; border:2px solid transparent; transition:all .2s; opacity:.6; }
    .hd-lightbox-thumbnail img { width:100%; height:100%; object-fit:cover; display:block; }
    .hd-lightbox-thumbnail:hover { opacity:.8; }
    .hd-lightbox-thumbnail.active { border-color:var(--accent); opacity:1; }

    /* ── Upload zone ── */
    .hd-upload-zone { border:2px dashed var(--border-md); border-radius:var(--radius-sm); padding:20px; text-align:center; background:var(--surface); cursor:pointer; transition:all .18s; }
    .hd-upload-zone:hover, .hd-upload-zone.dragover { border-color:var(--accent); background:var(--accent-dim); }
    .hd-upload-zone svg { width:26px; height:26px; color:var(--muted); margin-bottom:6px; }
    .hd-upload-zone p { font-size:.8rem; color:var(--text-dim); margin:0; }
    .hd-upload-zone span { font-size:.72rem; color:var(--muted); }
    .hd-upload-previews { display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }
    .hd-prev-thumb { position:relative; width:64px; height:52px; border-radius:7px; overflow:hidden; border:1px solid var(--border); }
    .hd-prev-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
    .hd-prev-rm { position:absolute; top:2px; right:2px; width:16px; height:16px; border-radius:50%; background:rgba(220,38,38,.85); border:none; cursor:pointer; display:grid; place-items:center; }
    .hd-prev-rm svg { width:9px; height:9px; color:#fff; }

    /* ── Specs strip ── */
    .hd-specs { display:grid; grid-template-columns:repeat(auto-fit,minmax(100px,1fr)); gap:0; border:1px solid var(--border); border-radius:var(--radius-sm); overflow:hidden; margin-bottom:20px; }
    .hd-spec-cell { padding:13px 10px; text-align:center; border-right:1px solid var(--border); background:#fff; }
    .hd-spec-cell:last-child { border-right:none; }
    .hd-spec-label { font-size:.67rem; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; margin-bottom:4px; }
    .hd-spec-val { font-weight:700; font-size:.86rem; color:var(--text); display:flex; align-items:center; justify-content:center; gap:4px; }
    .hd-spec-val svg { width:12px; height:12px; color:var(--muted); }

    /* ── Condition badge ── */
    .hd-cond { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:6px; font-size:.7rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }
    .hd-cond::before { content:''; width:6px; height:6px; border-radius:50%; background:currentColor; }
    .hc-for_sale { background:#eff6ff; color:#1d4ed8; }
    .hc-for_rent { background:#f0fdf4; color:#166534; }
    .hc-sold     { background:#fdf4ff; color:#7e22ce; }
    .hc-inactive { background:#fef2f2; color:#dc2626; }

    /* ── Detail table ── */
    .hd-detail-row { display:flex; align-items:flex-start; justify-content:space-between; padding:9px 0; border-bottom:1px solid var(--surface); font-size:.82rem; }
    .hd-detail-row:last-child { border-bottom:none; }
    .hd-detail-label { color:var(--muted); font-weight:500; flex-shrink:0; }
    .hd-detail-val   { color:var(--text); font-weight:600; text-align:right; }

    /* ── Amenity grid ── */
    .hd-amenity-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:8px; }
    .hd-amenity { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:9px; background:var(--surface); border:1px solid var(--border); font-size:.8rem; color:var(--text-dim); transition:all .18s; }
    .hd-amenity:hover { border-color:#D0520855; background:var(--accent-dim); color:var(--text); }
    .hd-amenity-icon { width:28px; height:28px; border-radius:7px; background:var(--accent-dim); border:1px solid #D0520844; display:grid; place-items:center; flex-shrink:0; }
    .hd-amenity-icon svg { width:13px; height:13px; color:var(--accent); }

    /* ── Sidebar ── */
    .hd-sidebar { position:sticky; top:24px; }

    /* Price card */
    .hd-sb-price { background:#0E0E0C; border-radius:var(--radius); overflow:hidden; margin-bottom:14px; position:relative; box-shadow:var(--shadow-card); }
    .hd-sb-price::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 70% 60% at 20% 50%,rgba(201,169,110,.22) 0%,transparent 65%); pointer-events:none; }
    .hd-sb-price-inner { position:relative; z-index:1; padding:22px 20px; }
    .hd-sb-label { font-size:.68rem; color:rgba(255,255,255,.35); text-transform:uppercase; letter-spacing:.1em; margin-bottom:5px; }
    .hd-sb-val { font-family:'Cormorant Garamond',serif; font-size:1.7rem; font-weight:600; letter-spacing:-.02em; line-height:1; color:#fff; margin-bottom:3px; }
    .hd-sb-unit { font-size:.75rem; color:rgba(255,255,255,.35); }
    .hd-cond-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:5px; margin-top:10px; font-size:.68rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; }
    .hd-cond-badge.for_sale { background:rgba(201,169,110,.15); border:1px solid rgba(201,169,110,.3); color:#e4c97a; }
    .hd-cond-badge.for_rent { background:rgba(34,197,94,.12); border:1px solid rgba(34,197,94,.25); color:#86efac; }
    .hd-cond-badge.sold     { background:rgba(168,85,247,.12); border:1px solid rgba(168,85,247,.25); color:#d8b4fe; }
    .hd-cond-badge::before  { content:''; width:6px; height:6px; border-radius:50%; background:currentColor; }

    /* Agent card */
    .hd-agent-av { width:48px; height:48px; border-radius:50%; background:var(--accent-dim); border:2px solid #D0520855; display:grid; place-items:center; font-weight:700; font-size:1rem; color:var(--accent); flex-shrink:0; }
    .hd-agent-row { display:flex; align-items:center; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--surface); font-size:.8rem; }
    .hd-agent-row:last-child { border-bottom:none; }

    /* Plan card */
    .hd-plan-item { display:flex; align-items:center; justify-content:space-between; padding:9px 0; border-bottom:1px solid var(--surface); font-size:.81rem; }
    .hd-plan-item:last-child { border-bottom:none; }
    .hd-plan-label { color:var(--muted); }
    .hd-plan-val   { font-weight:600; color:var(--text); }

    /* Action button inside card */
    .hd-outline-btn {
        display:inline-flex; align-items:center; gap:6px; width:100%;
        padding:8px 14px; border-radius:var(--radius-sm); font-size:.8rem; font-weight:500;
        border:1.5px solid var(--border-md); background:#fff; color:var(--text-dim);
        cursor:pointer; transition:all .18s; text-decoration:none; justify-content:flex-start;
    }
    .hd-outline-btn:hover { border-color:var(--accent); color:var(--accent); background:var(--accent-dim); }
    .hd-outline-btn.danger:hover { border-color:#dc2626; color:#dc2626; background:#fef2f2; }
    .hd-outline-btn svg { width:14px; height:14px; flex-shrink:0; }

    @media(max-width:640px) {
        .hd-gallery { grid-template-columns:1fr; grid-template-rows:200px 130px 130px; }
        .hd-gal-main { grid-row:auto; }
        .hd-lightbox-nav { padding:0 10px; }
        .hd-lightbox-arrow { width:36px; height:36px; }
    }
</style>

{{-- ── Lightbox ── --}}
<div class="hd-lightbox" id="galleryLightbox">
    <div class="hd-lightbox-header">
        <div>
            <h6 class="hd-lightbox-title">{{ $house->title }}</h6>
            <p class="hd-lightbox-counter"><span id="currentImageIndex">1</span> / <span id="totalImages">{{ $house->images ? $house->images->count() : 0 }}</span></p>
        </div>
        <div class="hd-lightbox-controls">
            <button class="hd-lightbox-btn" id="downloadBtn" title="Download">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
            </button>
            <button class="hd-lightbox-btn" id="fullscreenBtn" title="Fullscreen">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/></svg>
            </button>
            <button class="hd-lightbox-btn" id="closeLightboxBtn" title="Close">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
            </button>
        </div>
    </div>
    <div class="hd-lightbox-body">
        <img id="lightboxImage" class="hd-lightbox-image" src="" alt="Gallery image"/>
        <div class="hd-lightbox-nav">
            <button class="hd-lightbox-arrow" id="prevBtn" title="Previous">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
            </button>
            <button class="hd-lightbox-arrow" id="nextBtn" title="Next">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
            </button>
        </div>
    </div>
    <div class="hd-lightbox-footer">
        <div class="hd-lightbox-thumbnails" id="thumbnailsContainer">
            @if($house->images && $house->images->count())
                @foreach($house->images as $index => $image)
                <div class="hd-lightbox-thumbnail {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <img src="{{ asset('image/houses/') }}/{{ $image->image_path }}" alt="Thumbnail">
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

{{-- ── Top bar ── --}}
<div class="hd-topbar">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.properties.houses.index') }}" class="hd-back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to Houses
        </a>
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.properties.houses.index') }}">Houses</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width:180px">{{ $house->title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="{{ route('admin.properties.houses.edit', $house->id) }}" class="hd-action-btn hd-btn-edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit House
        </a>
        @php $latestOrder = $house->planOrders()->latest()->first(); @endphp
        @if($latestOrder?->payment?->status === 'success' && !$house->is_approved)
        <button class="hd-action-btn hd-btn-approve" data-bs-toggle="modal" data-bs-target="#approveModal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Approve
        </button>
        @endif
        <button class="hd-action-btn hd-btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6M9 6V4h6v2"/></svg>
            Delete
        </button>
    </div>
</div>

<div class="row g-3">

    {{-- ══ LEFT ══ --}}
    <div class="col-xl-8">

        {{-- ── Gallery ── --}}
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                    Property Photos
                </h6>
                <div class="d-flex gap-2">
                    @if($house->images->count())
                    <a href="{{ route('admin.properties.houses.images.download', $house->id) }}"
                       class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
                        Download All
                    </a>
                    @endif
                    <button class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                            type="button" data-bs-toggle="collapse" data-bs-target="#uploadZone">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px"><path d="M14 13v4h-4v-4H7l5-5 5 5h-3z M4 19h16v2H4v-2z"/></svg>
                        Upload Photos
                    </button>
                </div>
            </div>
            <div class="hd-card-body">

                {{-- Scrollable thumbnail strip if > 3 images ── --}}
                @if($house->images && $house->images->count() > 3)
                <div style="margin-bottom:12px;display:flex;gap:6px;overflow-x:auto;padding:8px;border-radius:8px;background:var(--surface);border:1px solid var(--border);">
                    @foreach($house->images as $index => $image)
                    <div style="min-width:72px;width:72px;height:60px;border-radius:6px;overflow:hidden;cursor:pointer;border:2px solid transparent;transition:all .2s;{{ $index===0?'border-color:var(--accent);opacity:1;':'opacity:.6;' }}" class="preview-thumb-scroll" data-index="{{ $index }}" title="Image {{ $index + 1 }}">
                        <img src="{{ asset('image/houses/') }}/{{ $image->image_path }}" alt="Photo {{ $index + 1 }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="hd-gallery">
                    {{-- Main image --}}
                    <div class="hd-gal-main">
                        @if($house->images->first())
                        <img src="{{ asset('image/houses/') }}/{{ $house->images->first()->image_path }}"
                             alt="{{ $house->title }}" loading="lazy" data-index="0" class="gallery-image">
                        <div class="hd-photo-actions">
                            <a href="{{ asset('image/houses/') }}/{{ $house->images->first()->image_path }}" download class="hd-photo-btn" title="Download">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
                            </a>
                            <a href="{{ asset('image/houses/') }}/{{ $house->images->first()->image_path }}" target="_blank" class="hd-photo-btn" title="View full size">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
                            </a>
                        </div>
                        <span class="hd-photo-count" id="photoCount">{{ $house->images->count() }} photos</span>
                        @else
                        <div class="hd-gal-ph"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>
                        @endif
                    </div>

                    {{-- Thumb 1 --}}
                    <div class="hd-gal-thumb">
                        @if($house->images->get(1))
                        <img src="{{ asset('image/houses/') }}/{{ $house->images->get(1)->image_path }}"
                             alt="{{ $house->title }}" loading="lazy" data-index="1" class="gallery-image">
                        <div class="hd-photo-actions">
                            <a href="{{ asset('image/houses/') }}/{{ $house->images->get(1)->image_path }}" download class="hd-photo-btn">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
                            </a>
                        </div>
                        @else
                        <div class="hd-gal-ph"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg></div>
                        @endif
                    </div>

                    {{-- Thumb 2 --}}
                    <div class="hd-gal-thumb" style="position:relative">
                        @if($house->images->get(2))
                        <img src="{{ asset('image/houses/') }}/{{ $house->images->get(2)->image_path }}"
                             alt="{{ $house->title }}" loading="lazy" data-index="2" class="gallery-image">
                        <div class="hd-photo-actions">
                            <a href="{{ asset('image/houses/') }}/{{ $house->images->get(2)->image_path }}" download class="hd-photo-btn">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
                            </a>
                        </div>
                        @if($house->images->count() > 3)
                        <div style="position:absolute;inset:0;background:rgba(0,0,0,.45);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;font-weight:700;cursor:pointer" class="gallery-view-all">
                            +{{ $house->images->count() - 3 }}
                        </div>
                        @endif
                        @else
                        <div class="hd-gal-ph"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg></div>
                        @endif
                    </div>
                </div>

                {{-- Upload zone ── --}}
                <div class="collapse" id="uploadZone">
                    <form method="POST" action="{{ route('admin.properties.houses.images.upload', $house->id) }}"
                          enctype="multipart/form-data" id="upload-form">
                        @csrf
                        <div class="hd-upload-zone" id="drop-zone" onclick="document.getElementById('photo-input').click()">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.35 10.04A7.49 7.49 0 0012 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 000 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                            <p><b>Click to upload</b> or drag &amp; drop photos here</p>
                            <span>JPEG, PNG, WEBP — Max 5MB each</span>
                            <input type="file" id="photo-input" name="images[]" multiple accept="image/*" style="display:none">
                        </div>
                        <div class="hd-upload-previews" id="upload-previews"></div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-uploads">Clear</button>
                            <button type="submit" class="btn btn-sm btn-primary" id="submit-upload" disabled>
                                Upload <span id="upload-count"></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        {{-- ── Title + specs ── --}}
        <div class="hd-card">
            <div class="hd-card-body">
                @php $cond = strtolower($house->condition ?? 'for_sale'); @endphp
                <div class="d-flex align-items-flex-start justify-content-between gap-2 flex-wrap mb-3">
                    <div>
                        <span class="hd-cond {{ match($cond){ 'for_sale'=>'hc-for_sale','for_rent'=>'hc-for_rent','sold'=>'hc-sold',default=>'hc-inactive' } }}">
                            {{ ucwords(str_replace('_',' ',$cond)) }}
                        </span>
                        <h5 class="mt-2 mb-1 fw-semibold">
                            {{ $house->title }}
                            <span class="badge bg-secondary">{{ ucfirst($house->status) }}</span>
                        </h5>
                        <p class="text-muted small mb-0 d-flex align-items-center gap-1">
                            <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;color:var(--accent)"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                            {{ $house->cell }}, {{ $house->sector }}, {{ $house->district }} {{ $house->province }}
                        </p>
                    </div>
                    <div class="text-end">
                        <p class="text-muted small mb-1">Listed Price</p>
                        <h4 class="fw-bold mb-0" style="color:var(--accent)">
                            {{ number_format($house->price) }}
                            <span class="fs-sm text-muted fw-normal">{{ $house->currency ?? 'RWF' }}</span>
                        </h4>
                        <p class="small text-muted mt-1 mb-0">Type: <b style="color:var(--text)">{{ ucfirst($house->type ?? '—') }}</b></p>
                    </div>
                </div>

                <div class="hd-specs">
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Bedrooms</div>
                        <div class="hd-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z"/></svg>
                            {{ $house->bedrooms ?? '—' }}
                        </div>
                    </div>
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Bathrooms</div>
                        <div class="hd-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3v6.93L7 22h2l-.895-2h7.79L15 22h2l4-5.07V10z"/></svg>
                            {{ $house->bathrooms ?? '—' }}
                        </div>
                    </div>
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Area (ft²)</div>
                        <div class="hd-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg>
                            {{ number_format($house->area_sqft ?? 0) }}
                        </div>
                    </div>
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Garages</div>
                        <div class="hd-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/></svg>
                            {{ $house->garages ?? '—' }}
                        </div>
                    </div>
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Approved</div>
                        <div class="hd-spec-val">
                            @if($house->is_approved)
                            <svg viewBox="0 0 24 24" fill="currentColor" style="color:#16a34a"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Yes
                            @else
                            <svg viewBox="0 0 24 24" fill="currentColor" style="color:#dc2626"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> No
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Description ── --}}
        @if($house->description)
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/></svg>
                    Description
                </h6>
            </div>
            <div class="hd-card-body">
                <p class="mb-0" style="font-size:.84rem;line-height:1.8;color:var(--text-dim)">{{ $house->description }}</p>
            </div>
        </div>
        @endif

        {{-- ── Full details ── --}}
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                    Property Details
                </h6>
                <a href="{{ route('admin.properties.houses.edit', $house->id) }}"
                   class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </a>
            </div>
            <div class="hd-card-body">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="hd-detail-row"><span class="hd-detail-label">Title</span><span class="hd-detail-val">{{ $house->title }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Type</span><span class="hd-detail-val">{{ ucfirst($house->type ?? '—') }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Condition</span><span class="hd-detail-val">{{ ucwords(str_replace('_',' ',$house->condition ?? '—')) }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Bedrooms</span><span class="hd-detail-val">{{ $house->bedrooms ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Bathrooms</span><span class="hd-detail-val">{{ $house->bathrooms ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Garages</span><span class="hd-detail-val">{{ $house->garages ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Status</span><span class="hd-detail-val">{{ ucfirst($house->status) }}</span></div>
                    </div>
                    <div class="col-md-6 ps-md-4">
                        <div class="hd-detail-row"><span class="hd-detail-label">Area (ft²)</span><span class="hd-detail-val">{{ number_format($house->area_sqft ?? 0) }}</span></div>
                        <div class="hd-detail-row">
                            <span class="hd-detail-label">Price {{ $house->currency ?? 'RWF' }}</span>
                            <span class="hd-detail-val">{{ number_format($house->price) }} <small style="font-weight:400;color:var(--muted)">{{ $house->negotiable === 'negotiable' ? '(Neg.)' : '(Fixed)' }}</small></span>
                        </div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Province</span><span class="hd-detail-val">{{ $house->province ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">District</span><span class="hd-detail-val">{{ $house->district ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Sector</span><span class="hd-detail-val">{{ $house->sector ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Cell</span><span class="hd-detail-val">{{ $house->cell ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Village</span><span class="hd-detail-val">{{ $house->village ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Listed</span><span class="hd-detail-val">{{ $house->created_at->format('d M Y') }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Amenities ── --}}
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Amenities &amp; Features
                </h6>
            </div>
            <div class="hd-card-body">
                <div class="hd-amenity-grid">
                    <div class="hd-amenity"><div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4z"/></svg></div>{{ $house->bedrooms ?? '—' }} Bedrooms</div>
                    <div class="hd-amenity"><div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3v6.93L7 22h2l-.895-2h7.79L15 22h2l4-5.07V10z"/></svg></div>{{ $house->bathrooms ?? '—' }} Bathrooms</div>
                    <div class="hd-amenity"><div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg></div>{{ number_format($house->area_sqft ?? 0) }} ft²</div>
                    <div class="hd-amenity"><div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z"/></svg></div>{{ $house->garages ?? '—' }} Garages</div>
                    <div class="hd-amenity"><div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg></div>{{ $house->district }}</div>
                    <div class="hd-amenity"><div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>{{ ucfirst($house->type ?? 'House') }}</div>
                    @foreach($house->facilities ?? [] as $facility)
                    <div class="hd-amenity">
                        <div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                        {{ $facility->name }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── Map ── --}}
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                    Location Map
                </h6>
            </div>
            <div style="padding:0">
                @if($house->latitude && $house->longitude)
                <iframe width="100%" height="240" style="border:0;display:block" loading="lazy" allowfullscreen
                    src="https://www.google.com/maps?q={{ $house->latitude }},{{ $house->longitude }}&output=embed"></iframe>
                @else
                <iframe width="100%" height="240" style="border:0;display:block" loading="lazy" allowfullscreen
                    src="https://www.google.com/maps?q={{ urlencode(($house->sector ?? '').','.($house->district ?? '').','.($house->province ?? '').', Rwanda') }}&output=embed"></iframe>
                @endif
            </div>
        </div>

        {{-- ── Video Tour ── --}}
        @if($house->video_url)
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    Video Tour
                </h6>
            </div>
            @php
                $isYoutube = preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $house->video_url, $ytMatches);
                $youtubeId = $isYoutube ? $ytMatches[1] : null;
                $isVimeo   = preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $house->video_url, $viMatches);
                $vimeoId   = $isVimeo ? $viMatches[1] : null;
                $ext       = strtolower(pathinfo(parse_url($house->video_url, PHP_URL_PATH), PATHINFO_EXTENSION));
                $isDirectVideo = in_array($ext, ['mp4','webm','ogg','mov']);
            @endphp
            <div style="padding:0">
                @if($youtubeId)
                    @if(str_contains($house->video_url, '/shorts/'))
                    <div style="display:flex;justify-content:center;">
                        <div style="position:relative;width:100%;max-width:340px;padding-bottom:min(177.78%,600px);height:0;overflow:hidden;">
                            <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?shorts=1" frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                        </div>
                    </div>
                    @else
                    <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                        <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                    </div>
                    @endif
                @elseif($vimeoId)
                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                    <iframe src="https://player.vimeo.com/video/{{ $vimeoId }}" frameborder="0" allow="autoplay;fullscreen;picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                </div>
                @elseif($isDirectVideo)
                <video controls playsinline style="width:100%;max-height:320px;background:#000;">
                    <source src="{{ $house->video_url }}" type="video/{{ $ext === 'mov' ? 'mp4' : $ext }}">
                </video>
                @endif
            </div>
        </div>
        @endif

    </div>{{-- /col-xl-8 --}}

    {{-- ══ SIDEBAR ══ --}}
    <div class="col-xl-4">
        <div class="hd-sidebar">

            {{-- Price card ── --}}
            <div class="hd-sb-price">
                <div class="hd-sb-price-inner">
                    <div class="hd-sb-label">Listed Price</div>
                    <div class="hd-sb-val">{{ number_format($house->price) }}</div>
                    <div class="hd-sb-unit">{{ $house->currency ?? 'RWF' }}</div>
                    <div class="hd-cond-badge {{ $cond }}">{{ ucwords(str_replace('_',' ',$cond)) }}</div>
                </div>
            </div>

            {{-- Listed by ── --}}
            <div class="hd-card">
                <div class="hd-card-head">
                    <h6 class="hd-card-head-title">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                        Listed By
                    </h6>
                </div>
                <div class="hd-card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="hd-agent-av">{{ strtoupper(substr($house->user->name ?? 'U', 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:700;font-size:.9rem;color:var(--text)">{{ $house->user->name ?? '—' }}</div>
                            <div style="font-size:.73rem;color:var(--muted)">{{ ucfirst($house->user->role ?? 'Agent') }}</div>
                        </div>
                    </div>
                    <div class="hd-agent-row"><span style="color:var(--muted)">Phone</span><span style="font-weight:600">{{ $house->user->phone ?? 'N/A' }}</span></div>
                    <div class="hd-agent-row"><span style="color:var(--muted)">Email</span><span style="font-weight:600;overflow:hidden;text-overflow:ellipsis;max-width:160px;white-space:nowrap">{{ $house->user->email ?? '—' }}</span></div>
                    <div class="hd-agent-row"><span style="color:var(--muted)">Role</span><span style="font-weight:600">{{ ucfirst($house->user->role ?? '—') }}</span></div>
                    <a href="#" class="hd-outline-btn mt-3">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        View Agent Profile
                    </a>
                </div>
            </div>

            {{-- Plan & Approval ── --}}
            <div class="hd-card">
                <div class="hd-card-head">
                    <h6 class="hd-card-head-title">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                        Plan &amp; Approval
                    </h6>
                    @if($house->is_approved)
                    <span class="badge bg-success-subtle text-success">Approved</span>
                    @else
                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                    @endif
                </div>
                <div class="hd-card-body">
                    @php $payment = $house->payments()->with('listingPackage')->latest()->first(); @endphp

                    @if($payment)
                    <div class="hd-plan-item"><span class="hd-plan-label">Package</span><span class="hd-plan-val">{{ $payment->listingPackage?->package_tier ?? 'N/A' }}</span></div>
                    <div class="hd-plan-item"><span class="hd-plan-label">Price/day</span><span class="hd-plan-val">{{ number_format($payment->listingPackage?->price_per_day ?? 0) }} {{ $house->currency ?? 'RWF' }}</span></div>
                    <div class="hd-plan-item"><span class="hd-plan-label">Duration</span><span class="hd-plan-val">{{ $payment->payable?->listing_days ?? '—' }} days</span></div>
                    <div class="hd-plan-item"><span class="hd-plan-label">Total</span><span class="hd-plan-val">{{ number_format($payment->amount) }} {{ $house->currency ?? 'RWF' }}</span></div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Payment</span>
                        <span class="badge {{ match($payment->status){ 'completed'=>'bg-success','pending'=>'bg-warning text-dark','processing'=>'bg-info text-dark',default=>'bg-danger' } }}">{{ ucfirst($payment->status) }}</span>
                    </div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Reference</span>
                        <span class="hd-plan-val" style="font-family:monospace;font-size:.78rem;color:var(--accent)">{{ $payment->reference }}</span>
                    </div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Approval</span>
                        <span class="badge {{ $house->is_approved ? 'bg-success' : 'bg-secondary' }}">{{ $house->is_approved ? 'Approved' : 'Pending' }}</span>
                    </div>
                    @if($payment->status === 'completed' && !$house->is_approved)
                    <button class="btn btn-primary btn-sm w-100 mt-3 d-flex align-items-center justify-content-center gap-1"
                            data-bs-toggle="modal" data-bs-target="#approveModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Approve This House
                    </button>
                    @endif
                    @if($payment->status === 'pending')
                    <a href="{{ route('payment.show', $payment->reference) }}"
                       class="btn btn-warning btn-sm w-100 mt-3 text-dark fw-semibold">Complete Payment →</a>
                    @endif
                    @else
                    <p class="text-muted small mb-0 text-center py-2">No payment record found.</p>
                    @endif
                </div>
            </div>

            {{-- Quick actions ── --}}
            <div class="hd-card">
                <div class="hd-card-head">
                    <h6 class="hd-card-head-title">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Quick Actions
                    </h6>
                </div>
                <div class="hd-card-body d-flex flex-column gap-2">
                    @if($house->images->count())
                    <button class="hd-outline-btn" id="viewGalleryBtn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        View Gallery
                    </button>
                    @endif

                    <button class="hd-outline-btn" data-bs-toggle="modal" data-bs-target="#statusModal">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Change Status
                    </button>

                    <a href="{{ route('admin.properties.houses.edit', $house->id) }}" class="hd-outline-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit House Details
                    </a>

                    <button class="hd-outline-btn" type="button" data-bs-toggle="collapse" data-bs-target="#uploadZone"
                            onclick="document.getElementById('uploadZone').scrollIntoView({behavior:'smooth'})">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                        Upload Photos
                    </button>

                    @if($house->images->count())
                    <a href="{{ route('admin.properties.houses.images.download', $house->id) }}" class="hd-outline-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
                        Download All Photos
                    </a>
                    @endif

                    <a href="{{ route('front.buy.home.details', $house->id) }}" target="_blank" class="hd-outline-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3"/></svg>
                        View on Site
                    </a>

                    <button class="hd-outline-btn danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                        Delete House
                    </button>
                </div>
            </div>

        </div>
    </div>{{-- /col-xl-4 --}}

</div>{{-- /.row --}}

{{-- ── Status Modal ── --}}
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <form method="POST" action="{{ route('admin.properties.houses.status', $house) }}" class="modal-content">
            @csrf @method('PATCH')
            <div class="modal-header border-0 pb-0">
                <h6 class="mb-0">Change House Status</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <p class="text-muted small mb-2">Changing status for:</p>
                <div class="bg-light rounded p-3 mb-3">
                    <p class="fw-bold mb-1">{{ $house->title }}</p>
                    <p class="text-muted small mb-0">Listed by <b>{{ $house->user->name }}</b> · {{ $house->district }}, {{ $house->province }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">Select new status</label>
                    <select class="form-select" name="status" required>
                        <option value="available" {{ $house->status === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="reserved"  {{ $house->status === 'reserved'  ? 'selected' : '' }}>Reserved</option>
                        <option value="sold"       {{ $house->status === 'sold'      ? 'selected' : '' }}>Sold</option>
                        <option value="rented"     {{ $house->status === 'rented'    ? 'selected' : '' }}>Rented</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Status</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Approve Modal ── --}}
@if(isset($payment) && $payment?->status === 'completed' && !$house->is_approved)
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <form method="POST" action="{{ route('admin.properties.houses.approve', $house) }}" class="modal-content">
            @csrf
            <div class="modal-header border-0 pb-0">
                <h6 class="mb-0">Approve House Property</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <div class="bg-light rounded p-3 mb-3">
                    <p class="fw-bold mb-1">{{ $house->title }}</p>
                    <p class="text-muted small mb-0">Listed by <b>{{ $house->user->name }}</b> · {{ $house->district }}, {{ $house->province }}</p>
                </div>
                <div class="border rounded p-3 mb-3" style="border-color:#D0520844 !important;background:var(--surface);">
                    <div class="d-flex justify-content-between mb-1"><span class="text-muted small">Package</span><span class="small fw-semibold">{{ ucfirst($payment->listingPackage?->package_tier ?? 'N/A') }}</span></div>
                    <div class="d-flex justify-content-between mb-1"><span class="text-muted small">Amount Paid</span><span class="small fw-semibold text-success">{{ number_format($payment->amount) }} {{ $payment->currency }}</span></div>
                    <div class="d-flex justify-content-between"><span class="text-muted small">Reference</span><span class="small" style="font-family:monospace;color:var(--accent)">{{ $payment->reference }}</span></div>
                </div>
                <p class="text-muted small mb-0">This will publish the house publicly on Terra.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-sm px-4">Approve &amp; Publish</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ── Delete Modal ── --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px">
        <div class="modal-content p-4 text-center">
            <div class="d-flex justify-content-center mb-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;background:#fef2f2">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" style="width:24px;height:24px"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                </div>
            </div>
            <h6 class="mb-1">Delete this house property?</h6>
            <p class="text-muted small mb-4"><b>{{ $house->title }}</b> — this action cannot be undone.</p>
            <div class="d-flex justify-content-center gap-2">
                <form method="POST" action="{{ route('admin.properties.houses.destroy', $house) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4">Delete</button>
                </form>
                <button class="btn btn-outline-secondary btn-sm px-4" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    /* ── Gallery Lightbox ── */
    const lightbox          = document.getElementById('galleryLightbox');
    const lightboxImg       = document.getElementById('lightboxImage');
    const closeLightboxBtn  = document.getElementById('closeLightboxBtn');
    const prevBtn           = document.getElementById('prevBtn');
    const nextBtn           = document.getElementById('nextBtn');
    const downloadBtn       = document.getElementById('downloadBtn');
    const fullscreenBtn     = document.getElementById('fullscreenBtn');
    const viewGalleryBtn    = document.getElementById('viewGalleryBtn');
    const currentIdxSpan    = document.getElementById('currentImageIndex');
    const galleryImages     = document.querySelectorAll('.gallery-image');
    const lightboxThumbnails = document.querySelectorAll('.hd-lightbox-thumbnail');
    let currentIndex = 0;
    let totalImages  = lightboxThumbnails.length;

    function updateLightbox(index) {
        if (index < 0) currentIndex = totalImages - 1;
        if (index >= totalImages) currentIndex = 0;
        const thumb = lightboxThumbnails[currentIndex];
        if (thumb) lightboxImg.src = thumb.querySelector('img').src;
        currentIdxSpan.textContent = currentIndex + 1;
        document.querySelectorAll('.hd-lightbox-thumbnail').forEach((t, i) => t.classList.toggle('active', i === currentIndex));
        document.querySelector('.hd-lightbox-thumbnail.active')?.scrollIntoView({ behavior:'smooth', block:'nearest', inline:'center' });
    }

    function openLightbox(index) {
        totalImages  = document.querySelectorAll('.hd-lightbox-thumbnail').length;
        currentIndex = index;
        lightbox.classList.add('active');
        updateLightbox(currentIndex);
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    galleryImages.forEach((img, i) => img.addEventListener('click', () => openLightbox(i)));
    document.getElementById('photoCount')?.addEventListener('click', () => openLightbox(0));
    document.querySelector('.gallery-view-all')?.addEventListener('click', () => openLightbox(0));
    viewGalleryBtn?.addEventListener('click', () => openLightbox(0));
    closeLightboxBtn?.addEventListener('click', closeLightbox);
    prevBtn?.addEventListener('click', () => { currentIndex--; updateLightbox(currentIndex); });
    nextBtn?.addEventListener('click', () => { currentIndex++; updateLightbox(currentIndex); });
    downloadBtn?.addEventListener('click', () => { const a = document.createElement('a'); a.href = lightboxImg.src; a.download = true; a.click(); });
    fullscreenBtn?.addEventListener('click', () => lightboxImg.requestFullscreen?.());
    lightboxThumbnails.forEach((t, i) => t.addEventListener('click', () => { currentIndex = i; updateLightbox(i); }));
    lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
    document.addEventListener('keydown', e => {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'ArrowLeft')  { currentIndex--; updateLightbox(currentIndex); }
        if (e.key === 'ArrowRight') { currentIndex++; updateLightbox(currentIndex); }
        if (e.key === 'Escape')     closeLightbox();
    });

    /* ── Preview thumbnail strip ── */
    document.querySelectorAll('.preview-thumb-scroll').forEach(thumb => {
        thumb.addEventListener('click', () => {
            const index = parseInt(thumb.dataset.index);
            const img   = galleryImages[index];
            if (img) {
                document.querySelector('.hd-gal-main img').src = img.src;
                document.querySelectorAll('.preview-thumb-scroll').forEach((t, i) => {
                    t.style.borderColor = i === index ? 'var(--accent)' : 'transparent';
                    t.style.opacity     = i === index ? '1' : '0.6';
                });
            }
        });
    });

    /* ── Photo upload zone ── */
    const input      = document.getElementById('photo-input');
    const previews   = document.getElementById('upload-previews');
    const submitBtn  = document.getElementById('submit-upload');
    const cntSpan    = document.getElementById('upload-count');
    const clearBtn   = document.getElementById('clear-uploads');
    const dropZone   = document.getElementById('drop-zone');
    let files = [];

    function renderPreviews() {
        previews.innerHTML = '';
        files.forEach((f, i) => {
            const url  = URL.createObjectURL(f);
            const wrap = document.createElement('div');
            wrap.className = 'hd-prev-thumb';
            wrap.innerHTML = `<img src="${url}"><button class="hd-prev-rm" data-i="${i}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg></button>`;
            previews.appendChild(wrap);
        });
        if (submitBtn) submitBtn.disabled = files.length === 0;
        if (cntSpan)   cntSpan.textContent = files.length > 0 ? `(${files.length})` : '';
    }

    input?.addEventListener('change', e => { files = [...files, ...Array.from(e.target.files)]; renderPreviews(); });
    previews?.addEventListener('click', e => {
        const btn = e.target.closest('[data-i]');
        if (btn) { files.splice(+btn.dataset.i, 1); renderPreviews(); }
    });
    clearBtn?.addEventListener('click', () => { files = []; renderPreviews(); });

    if (dropZone) {
        dropZone.addEventListener('dragover',  e => { e.preventDefault(); dropZone.classList.add('dragover'); });
        dropZone.addEventListener('dragleave', ()  => dropZone.classList.remove('dragover'));
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            files = [...files, ...Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'))];
            renderPreviews();
        });
    }

    document.getElementById('upload-form')?.addEventListener('submit', e => {
        if (files.length === 0) { e.preventDefault(); return; }
        const dt = new DataTransfer();
        files.forEach(f => dt.items.add(f));
        if (input) input.files = dt.files;
    });
})();
</script>

@endsection