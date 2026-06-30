@extends('layouts.agents')
@section('title', 'Land Details — '.$land->title)
@section('content')

@php
$isAgent = auth()->user()->role === 'agent';
$latestOrder = $land->planOrders()->latest()->first();
@endphp

<style>
    /* ── Page header ── */
    .ld-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .ld-topbar-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ld-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        background: #fff;
        font-size: .81rem;
        font-weight: 500;
        color: #475569;
        transition: all .18s;
        text-decoration: none;
    }

    .ld-back-btn:hover {
        border-color: #3b82f6;
        color: #2563eb;
        background: #eff6ff;
    }

    .ld-back-btn svg {
        width: 14px;
        height: 14px;
    }

    .ld-topbar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .ld-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: .81rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .18s;
        text-decoration: none;
    }

    .ld-btn-edit {
        background: #fef9c3;
        color: #854d0e;
        border: 1.5px solid #fde68a;
    }

    .ld-btn-edit:hover {
        background: #fde68a;
        color: #78350f;
    }

    .ld-btn-approve {
        background: #dcfce7;
        color: #166534;
        border: 1.5px solid #86efac;
    }

    .ld-btn-approve:hover {
        background: #86efac;
        color: #14532d;
    }

    .ld-btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1.5px solid #fca5a5;
    }

    .ld-btn-delete:hover {
        background: #fca5a5;
        color: #991b1b;
    }

    /* ── Gallery ── */
    .ld-gallery {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 240px 160px;
        gap: 8px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .ld-gal-main {
        grid-row: 1/3;
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }

    .ld-gal-thumb {
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }

    .ld-gal-main img,
    .ld-gal-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease;
        cursor: pointer;
    }

    .ld-gal-main:hover img,
    .ld-gal-thumb:hover img {
        transform: scale(1.04);
    }

    .ld-gal-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    }

    .ld-gal-placeholder svg {
        width: 40px;
        height: 40px;
        color: #cbd5e1;
    }

    .ld-photo-actions {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 5px;
        z-index: 3;
    }

    .ld-photo-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: rgba(255, 255, 255, .85);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, .5);
        display: grid;
        place-items: center;
        cursor: pointer;
        color: #475569;
        transition: all .18s;
        text-decoration: none;
    }

    .ld-photo-btn:hover {
        background: #fff;
        color: #2563eb;
    }

    .ld-photo-btn svg {
        width: 13px;
        height: 13px;
    }

    .ld-photo-count {
        position: absolute;
        bottom: 8px;
        left: 8px;
        padding: 2px 8px;
        border-radius: 5px;
        background: rgba(0, 0, 0, .55);
        color: #fff;
        font-size: .68rem;
        font-weight: 600;
        z-index: 3;
        cursor: pointer;
    }

    .ld-photo-count:hover {
        background: rgba(0, 0, 0, .75);
    }

    /* ── Lightbox Gallery ── */
    .ld-lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        overflow: hidden;
    }

    .ld-lightbox.active {
        display: flex;
        flex-direction: column;
        animation: fadeIn .3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Lightbox header */
    .ld-lightbox-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        border-bottom: 1px solid rgba(255, 255, 255, .1);
        background: rgba(0, 0, 0, .5);
        backdrop-filter: blur(10px);
    }

    .ld-lightbox-title {
        color: #fff;
        font-size: .9rem;
        font-weight: 600;
        margin: 0;
    }

    .ld-lightbox-counter {
        color: rgba(255, 255, 255, .7);
        font-size: .8rem;
        margin: 0;
    }

    .ld-lightbox-controls {
        display: flex;
        gap: 8px;
    }

    .ld-lightbox-btn {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .2);
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .2s;
    }

    .ld-lightbox-btn:hover {
        background: rgba(255, 255, 255, .2);
        border-color: rgba(255, 255, 255, .3);
    }

    .ld-lightbox-btn svg {
        width: 18px;
        height: 18px;
    }

    /* Lightbox body */
    .ld-lightbox-body {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .ld-lightbox-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        animation: zoomIn .3s ease;
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .ld-lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
        pointer-events: none;
    }

    .ld-lightbox-arrow {
        width: 44px;
        height: 44px;
        background: rgba(255, 255, 255, .15);
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 6px;
        color: #fff;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .2s;
        pointer-events: all;
    }

    .ld-lightbox-arrow:hover {
        background: rgba(255, 255, 255, .25);
    }

    .ld-lightbox-arrow svg {
        width: 20px;
        height: 20px;
    }

    /* Lightbox footer */
    .ld-lightbox-footer {
        padding: 16px 24px;
        border-top: 1px solid rgba(255, 255, 255, .1);
        background: rgba(0, 0, 0, .5);
        backdrop-filter: blur(10px);
    }

    .ld-lightbox-thumbnails {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 4px;
    }

    .ld-lightbox-thumbnails::-webkit-scrollbar {
        height: 4px;
    }

    .ld-lightbox-thumbnails::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, .05);
        border-radius: 2px;
    }

    .ld-lightbox-thumbnails::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, .2);
        border-radius: 2px;
    }

    .ld-lightbox-thumbnail {
        min-width: 56px;
        width: 56px;
        height: 56px;
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all .2s;
        opacity: 0.6;
    }

    .ld-lightbox-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .ld-lightbox-thumbnail:hover {
        opacity: 0.8;
    }

    .ld-lightbox-thumbnail.active {
        border-color: #3b82f6;
        opacity: 1;
    }

    /* Upload zone */
    .ld-upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
        padding: 24px;
        text-align: center;
        background: #fafbfc;
        transition: all .18s;
        cursor: pointer;
    }

    .ld-upload-zone:hover,
    .ld-upload-zone.dragover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .ld-upload-zone svg {
        width: 28px;
        height: 28px;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .ld-upload-zone p {
        font-size: .8rem;
        color: #64748b;
        margin: 0;
    }

    .ld-upload-zone span {
        font-size: .75rem;
        color: #94a3b8;
    }

    .ld-upload-previews {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }

    .ld-preview-thumb {
        position: relative;
        width: 64px;
        height: 54px;
        border-radius: 7px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .ld-preview-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .ld-preview-rm {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: rgba(220, 38, 38, .85);
        border: none;
        cursor: pointer;
        display: grid;
        place-items: center;
    }

    .ld-preview-rm svg {
        width: 9px;
        height: 9px;
        color: #fff;
    }

    /* ── Spec strip ── */
    .ld-specs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
        gap: 0;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .ld-spec-cell {
        padding: 14px 12px;
        text-align: center;
        border-right: 1px solid #e2e8f0;
    }

    .ld-spec-cell:last-child {
        border-right: none;
    }

    .ld-spec-label {
        font-size: .68rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 5px;
    }

    .ld-spec-val {
        font-weight: 700;
        font-size: .88rem;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .ld-spec-val svg {
        width: 13px;
        height: 13px;
        color: #64748b;
    }

    /* ── Detail table ── */
    .ld-detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: .82rem;
    }

    .ld-detail-row:last-child {
        border-bottom: none;
    }

    .ld-detail-label {
        color: #94a3b8;
        font-weight: 500;
        flex-shrink: 0;
    }

    .ld-detail-val {
        color: #1e293b;
        font-weight: 600;
        text-align: right;
        word-break: break-all;
    }

    /* ── UPI pill ── */
    .upi-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 6px;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        font-family: monospace;
        font-size: .78rem;
        color: #475569;
        font-weight: 600;
    }

    .upi-label {
        padding: 1px 5px;
        border-radius: 3px;
        background: #e2e8f0;
        font-size: .6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #64748b;
    }

    /* ── Status badge ── */
    .ld-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .ld-status::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .ls-active {
        background: #dcfce7;
        color: #166534;
    }

    .ls-pending {
        background: #fef9c3;
        color: #854d0e;
    }

    .ls-sold {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .ls-inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    /* ── Cards ── */
    .ld-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .ld-card-head {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .ld-card-head-title {
        font-size: .88rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .ld-card-body {
        padding: 18px;
    }

    /* ── Agent card ── */
    .ld-agent-av {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #eff6ff;
        border: 2px solid #bfdbfe;
        display: grid;
        place-items: center;
        font-weight: 700;
        font-size: 1rem;
        color: #2563eb;
        flex-shrink: 0;
    }

    .ld-agent-name {
        font-weight: 700;
        font-size: .9rem;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .ld-agent-role {
        font-size: .73rem;
        color: #64748b;
    }

    .ld-agent-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f8fafc;
        font-size: .8rem;
    }

    .ld-agent-row:last-child {
        border-bottom: none;
    }

    /* ── Plan card ── */
    .ld-plan-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: .81rem;
    }

    .ld-plan-item:last-child {
        border-bottom: none;
    }

    .ld-plan-label {
        color: #94a3b8;
    }

    .ld-plan-val {
        font-weight: 600;
        color: #1e293b;
    }

    @media (max-width:640px) {
        .ld-gallery {
            grid-template-columns: 1fr;
            grid-template-rows: 200px 130px 130px;
        }

        .ld-gal-main {
            grid-row: auto;
        }

        .ld-lightbox-nav {
            padding: 0 10px;
        }

        .ld-lightbox-arrow {
            width: 36px;
            height: 36px;
        }

        .ld-lightbox-arrow svg {
            width: 16px;
            height: 16px;
        }
    }
</style>

{{-- ── Top bar ── --}}
<div class="ld-topbar">
    <div class="ld-topbar-left">
        <a href="{{ route('agent.properties.land.index') }}" class="ld-back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 5l-7 7 7 7" />
            </svg>
            Back to Lands
        </a>
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="#">Property</a></li>
                <li class="breadcrumb-item"><a href="{{ route('agent.properties.land.index') }}">Lands</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width:180px">{{ $land->title }}</li>
            </ol>
        </nav>
    </div>
    <div class="ld-topbar-actions">
        @if(!$isAgent)
        <a href="{{ route('agent.properties.lands.edit', $land->id) }}" class="ld-action-btn ld-btn-edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Edit Land
        </a>
        @if(isset($latestOrder) && $latestOrder?->payment?->status === 'success' && !$land->is_approved)
        <button class="ld-action-btn ld-btn-approve" data-bs-toggle="modal" data-bs-target="#approveModal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Approve
        </button>
        @endif
        <button class="ld-action-btn ld-btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                <polyline points="3 6 5 6 21 6" />
                <path d="M19 6l-1 14H6L5 6" />
                <path d="M10 11v6M14 11v6" />
                <path d="M9 6V4h6v2" />
            </svg>
            Delete
        </button>
        @endif
    </div>
</div>

{{-- ── Main layout ── --}}
<div class="row g-3">
    {{-- ── Lightbox Gallery Modal ── --}}
    <div class="ld-lightbox" id="galleryLightbox">
        <div class="ld-lightbox-header">
            <div>
                <h6 class="ld-lightbox-title">{{ $land->title }}</h6>
                <p class="ld-lightbox-counter"><span id="currentImageIndex">1</span> / <span id="totalImages">{{ $land->images ? $land->images->count() : 0 }}</span></p>
            </div>
            <div class="ld-lightbox-controls">
                <button class="ld-lightbox-btn" id="downloadBtn" title="Download">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                    </svg>
                </button>
                <button class="ld-lightbox-btn" id="fullscreenBtn" title="Fullscreen">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z" />
                    </svg>
                </button>
                <button class="ld-lightbox-btn" id="closeLightboxBtn" title="Close">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="ld-lightbox-body">
            <img id="lightboxImage" class="ld-lightbox-image" src="" alt="Gallery image" />

            <div class="ld-lightbox-nav">
                <button class="ld-lightbox-arrow" id="prevBtn" title="Previous">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                    </svg>
                </button>
                <button class="ld-lightbox-arrow" id="nextBtn" title="Next">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="ld-lightbox-footer">
            <div class="ld-lightbox-thumbnails" id="thumbnailsContainer">
                @if($land->images && $land->images->count())
                @foreach($land->images as $index => $image)
                <div class="ld-lightbox-thumbnail {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                    <img src="{{asset('image/lands/')}}/{{ $image->image_path }}" alt="Thumbnail">
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    {{-- ══ LEFT: Main content ══ --}}
    <div class="col-xl-8">

        {{-- Gallery ── --}}
        <div class="ld-card">
            <div class="ld-card-head">
                <h6 class="ld-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px;margin-right:6px;color:#D05208">
                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                    </svg>
                    Property Photos
                </h6>
                <div class="d-flex gap-2">
                    {{-- Download all --}}
                    @if($land->images && $land->images->count())
                    <a href="{{ route('admin.properties.lands.images.download', $land->id) }}"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px">
                            <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                        </svg>
                        Download All
                    </a>
                    @endif
                    {{-- Upload toggle --}}
                    <button class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                        type="button" data-bs-toggle="collapse" data-bs-target="#uploadZone">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px">
                            <path d="M19.35 10.04A7.49 7.49 0 0012 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 000 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z" />
                        </svg>
                        Upload Photos
                    </button>
                </div>
            </div>
            <div class="ld-card-body">

                {{-- Scrollable preview thumbnails (if more than 3 images) ── --}}
                @if($land->images && $land->images->count() > 3)
                <div style="margin-bottom: 14px; display: flex; gap: 6px; overflow-x: auto; padding: 8px; border-radius: 10px; background: #f7f8fb; border: 1px solid #e7eaf1;">
                    @foreach($land->images as $index => $image)
                    <div style="min-width: 72px; width: 72px; height: 60px; border-radius: 8px; overflow: hidden; cursor: pointer; border: 2px solid transparent; transition: all .2s; {{ $index === 0 ? 'border-color: #19265d; opacity: 1;' : 'opacity: 0.6;' }}" class="preview-thumb-scroll" data-index="{{ $index }}" title="Image {{ $index + 1 }}">
                        <img src="{{asset('image/lands/')}}/{{ $image->image_path }}" alt="Photo {{ $index + 1 }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Gallery grid ── --}}
                <div class="ld-gallery">
                    {{-- Main image --}}
                    <div class="ld-gal-main">
                        @if($land->images && $land->images->count())
                        <img src="{{asset('image/lands/')}}/{{ $land->images->first()->image_path }}"
                            alt="{{ $land->title }}" loading="lazy" id="main-gallery-img" data-index="0" class="gallery-image">
                        <div class="ld-photo-actions">
                            <a href="{{asset('image/lands/')}}/{{ $land->images->first()->image_path }}"
                                download class="ld-photo-btn" title="Download">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg>
                            </a>
                            <a href="{{asset('image/lands/')}}/{{ $land->images->first()->image_path }}"
                                target="_blank" class="ld-photo-btn" title="View full size">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7" />
                                </svg>
                            </a>
                        </div>
                        <span class="ld-photo-count" id="photoCount">{{ $land->images->count() }} photos</span>
                        @else
                        <div class="ld-gal-placeholder">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9V20.5l.16-.03L9 18.9l6 2.1 5.64-1.9V3.5z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    {{-- Thumb 1 --}}
                    <div class="ld-gal-thumb">
                        @if($land->images && $land->images->count() > 1)
                        <img src="{{asset('image/lands/')}}/{{ $land->images->get(1)->image_path }}"
                            alt="{{ $land->title }}" loading="lazy" data-index="1" class="gallery-image">
                        <div class="ld-photo-actions">
                            <a href="{{asset('image/lands/')}}/{{ $land->images->get(1)->image_path }}"
                                download class="ld-photo-btn" title="Download">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg>
                            </a>
                        </div>
                        @else
                        <div class="ld-gal-placeholder">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    {{-- Thumb 2 --}}
                    <div class="ld-gal-thumb">
                        @if($land->images && $land->images->count() > 2)
                        <img src="{{asset('image/lands/')}}/{{ $land->images->get(2)->image_path }}"
                            alt="{{ $land->title }}" loading="lazy" data-index="2" class="gallery-image">
                        <div class="ld-photo-actions">
                            <a href="{{asset('image/lands/')}}/{{ $land->images->get(2)->image_path }}"
                                download class="ld-photo-btn" title="Download">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg>
                            </a>
                            @if($land->images->count() > 3)
                            <div style="position:absolute;inset:0;background:rgba(25,38,93,.55);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;font-weight:700;cursor:pointer" class="gallery-view-all">
                                +{{ $land->images->count() - 3 }}
                            </div>
                            @endif
                        </div>
                        @else
                        <div class="ld-gal-placeholder">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Upload zone (collapsible) ── --}}
                <div class="collapse" id="uploadZone">
                    <form method="POST" action="{{ route('agent.properties.lands.images.upload', $land->id) }}"
                        enctype="multipart/form-data" id="upload-form">
                        @csrf
                        <div class="ld-upload-zone" id="drop-zone" onclick="document.getElementById('photo-input').click()">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.35 10.04A7.49 7.49 0 0012 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 000 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z" />
                            </svg>
                            <p><b>Click to upload</b> or drag &amp; drop photos here</p>
                            <span>JPEG, PNG, WEBP — Max 5MB each</span>
                            <input type="file" id="photo-input" name="images[]" multiple accept="image/*" style="display:none">
                        </div>
                        <div class="ld-upload-previews" id="upload-previews"></div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-uploads">Clear</button>
                            <button type="submit" class="btn btn-sm btn-primary" id="submit-upload" disabled>
                                <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;margin-right:4px">
                                    <path d="M19.35 10.04A7.49 7.49 0 0012 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 000 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z" />
                                </svg>
                                Upload <span id="upload-count"></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        {{-- Title + specs ── --}}
        <div class="ld-card">
            <div class="ld-card-body">
                <div class="d-flex align-items-flex-start justify-content-between gap-2 flex-wrap mb-3">
                    <div>
                        <span class="ld-status {{ match(strtolower($land->status ?? 'active')) {
                            'active' => 'ls-active', 'pending' => 'ls-pending',
                            'sold' => 'ls-sold', default => 'ls-inactive'
                        } }}">{{ ucfirst($land->status ?? 'Active') }}</span>
                        <h5 class="mt-2 mb-1 fw-semibold">{{ $land->title }}</h5>
                        <p class="text-muted small mb-0 d-flex align-items-center gap-1">
                            <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;color:#D05208">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            </svg>
                            {{ $land->sector }}, {{ $land->district }}, {{ $land->province }}
                        </p>
                    </div>
                    <div class="text-end">
                        <p class="text-muted small mb-1">Listed Price</p>
                        <h4 class="fw-bold mb-0" style="color:#19265d">{{ number_format($land->price) }} <span class="fs-sm text-muted fw-normal">RWF</span></h4>
                        @if($land->upi)
                        <div class="mt-2">
                            <span class="upi-pill"><span class="upi-label">UPI</span>{{ $land->upi }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Spec strip ── --}}
                <div class="ld-specs">
                    <div class="ld-spec-cell">
                        <div class="ld-spec-label">Size</div>
                        <div class="ld-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                            </svg>
                            {{ number_format($land->size_sqm ?? 0) }} sqm
                        </div>
                    </div>
                    <div class="ld-spec-cell">
                        <div class="ld-spec-label">Zoning</div>
                        <div class="ld-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0z" />
                            </svg>
                            {{ $land->zoning ?? '—' }}
                        </div>
                    </div>
                    <div class="ld-spec-cell">
                        <div class="ld-spec-label">Land Use</div>
                        <div class="ld-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9V20.5l.16-.03L9 18.9l6 2.1 5.64-1.9V3.5z" />
                            </svg>
                            {{ $land->land_use ?? '—' }}
                        </div>
                    </div>
                    <div class="ld-spec-cell">
                        <div class="ld-spec-label">Province</div>
                        <div class="ld-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            </svg>
                            {{ $land->province ?? '—' }}
                        </div>
                    </div>
                    <div class="ld-spec-cell">
                        <div class="ld-spec-label">Approved</div>
                        <div class="ld-spec-val">
                            @if($land->is_approved)
                            <svg viewBox="0 0 24 24" fill="currentColor" style="color:#16a34a">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Yes
                            @else
                            <svg viewBox="0 0 24 24" fill="currentColor" style="color:#dc2626">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            No
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description ── --}}
        @if($land->description)
        <div class="ld-card">
            <div class="ld-card-head">
                <h6 class="ld-card-head-title">Description</h6>
            </div>
            <div class="ld-card-body">
                <p class="text-muted mb-0" style="font-size:.84rem;line-height:1.8">{{ $land->description }}</p>
            </div>
        </div>
        @endif

        {{-- Full details table ── --}}
        <div class="ld-card">
            <div class="ld-card-head">
                <h6 class="ld-card-head-title">Land Details</h6>
                @if(!$isAgent)
                <a href="{{ route('agent.properties.lands.edit', $land->id) }}"
                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                    Edit
                </a>
                @endif
            </div>
            <div class="ld-card-body">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="ld-detail-row"><span class="ld-detail-label">UPI</span><span class="ld-detail-val">{{ $land->upi ?? '—' }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Province</span><span class="ld-detail-val">{{ $land->province ?? '—' }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">District</span><span class="ld-detail-val">{{ $land->district ?? '—' }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Sector</span><span class="ld-detail-val">{{ $land->sector ?? '—' }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Cell</span><span class="ld-detail-val">{{ $land->cell ?? '—' }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Village</span><span class="ld-detail-val">{{ $land->village ?? '—' }}</span></div>
                    </div>
                    <div class="col-md-6 ps-md-4">
                        <div class="ld-detail-row"><span class="ld-detail-label">Size (sqm)</span><span class="ld-detail-val">{{ number_format($land->size_sqm ?? 0) }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Zoning</span><span class="ld-detail-val">{{ $land->zoning ?? '—' }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Land Use</span><span class="ld-detail-val">{{ $land->land_use ?? '—' }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Price (RWF)</span><span class="ld-detail-val">{{ number_format($land->price) }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Status</span><span class="ld-detail-val">{{ ucfirst($land->status ?? '—') }}</span></div>
                        <div class="ld-detail-row"><span class="ld-detail-label">Listed</span><span class="ld-detail-val">{{ $land->created_at->format('d M Y') }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Map ── --}}
        <div class="ld-card">
            <div class="ld-card-head">
                <h6 class="ld-card-head-title">Location Map</h6>
            </div>
            <div class="ld-card-body p-0">
                @if($land->latitude && $land->longitude)
                <iframe
                    width="100%" height="240"
                    style="border:0;display:block"
                    loading="lazy" allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q={{ $land->latitude }},{{ $land->longitude }}&output=embed">
                </iframe>
                @else
                <iframe
                    width="100%" height="240"
                    style="border:0;display:block"
                    loading="lazy" allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q={{ urlencode(($land->sector ?? '').','.($land->district ?? '').','.($land->province ?? '').', Rwanda') }}&output=embed">
                </iframe>
                @endif
            </div>
        </div>

        <div class="ld-card">
            <div class="ld-card-head">
                <h6 class="ld-card-head-title">Video</h6>
            </div>
            <div class="ld-card-body">
                @if($land->video_url)
                @php
                $isYoutube = preg_match(
                '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                $land->video_url,
                $ytMatches
                );
                $youtubeId = $isYoutube ? $ytMatches[1] : null;

                $isVimeo = preg_match(
                '/vimeo\.com\/(?:video\/)?(\d+)/',
                $land->video_url,
                $viMatches
                );
                $vimeoId = $isVimeo ? $viMatches[1] : null;

                $videoExtensions = ['mp4', 'webm', 'ogg', 'mov'];
                $ext = strtolower(pathinfo(parse_url($land->video_url, PHP_URL_PATH), PATHINFO_EXTENSION));
                $isDirectVideo = in_array($ext, $videoExtensions);
                @endphp

                @if($youtubeId)
                @php $isShort = str_contains($land->video_url, '/shorts/'); @endphp

                @if($isShort)
                <div style="display:flex;justify-content:center;">
                    <div style="position:relative;width:100%;max-width:340px;padding-bottom:min(177.78%,600px);height:0;overflow:hidden;border-radius:8px;">
                        <iframe
                            src="https://www.youtube.com/embed/{{ $youtubeId }}?shorts=1"
                            frameborder="0"
                            allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:8px;"></iframe>
                    </div>
                </div>
                @else
                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:8px;">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $youtubeId }}"
                        frameborder="0"
                        allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:8px;"></iframe>
                </div>
                @endif

                @elseif($vimeoId)
                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:8px;">
                    <iframe
                        src="https://player.vimeo.com/video/{{ $vimeoId }}"
                        frameborder="0"
                        allowfullscreen
                        allow="autoplay; fullscreen; picture-in-picture"
                        style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:8px;"></iframe>
                </div>

                @elseif($isDirectVideo)
                <video
                    controls
                    playsinline
                    style="width:100%;border-radius:8px;max-height:480px;background:#000;">
                    <source src="{{ $land->video_url }}" type="video/{{ $ext === 'mov' ? 'mp4' : $ext }}">
                    Your browser does not support the video tag.
                </video>

                @else
                <p class="text-muted">No video available</p>
                @endif
                @else
                <p class="text-muted">No video available</p>
                @endif
            </div>
        </div>

    </div>{{-- /col-xl-8 --}}

    {{-- ══ RIGHT: Sidebar ══ --}}
    <div class="col-xl-4">
        <div class="position-sticky" style="top:24px">

            {{-- Agent card ── --}}
            <div class="ld-card">
                <div class="ld-card-head">
                    <h6 class="ld-card-head-title">Listed By</h6>
                </div>
                <div class="ld-card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="ld-agent-av">
                            {{ strtoupper(substr($land->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="ld-agent-name">{{ $land->user->name ?? '—' }}</div>
                            <div class="ld-agent-role">{{ ucfirst($land->user->role ?? 'Agent') }}</div>
                        </div>
                    </div>
                    <div class="ld-agent-row"><span class="text-muted">Phone</span><span class="fw-600">{{ $land->user->phone ?? 'N/A' }}</span></div>
                    <div class="ld-agent-row"><span class="text-muted">Email</span><span class="fw-600 text-truncate" style="max-width:160px">{{ $land->user->email ?? '—' }}</span></div>
                    <div class="ld-agent-row"><span class="text-muted">Role</span><span class="fw-600">{{ ucfirst($land->user->role ?? '—') }}</span></div>
                    <div class="ld-agent-row"><span class="text-muted">Working Hours</span><span class="fw-600">Mon–Fri, 9am–6pm</span></div>
                    <a href="#" class="btn btn-outline-secondary btn-sm w-100 mt-3 d-flex align-items-center justify-content-center gap-1">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        View Agent Profile
                    </a>
                </div>
            </div>

            {{-- Plan card ── --}}
            <div class="ld-card">
                <div class="ld-card-head">
                    <h6 class="ld-card-head-title">Plan & Approval</h6>
                    @if($land->is_approved)
                    <span class="badge bg-success-subtle text-success">Approved</span>
                    @else
                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                    @endif
                </div>
                <div class="ld-card-body">
                    @php
                    // Get the latest plan order for this property
                    $latestOrder = $land->planOrders()->latest()->first();
                    @endphp
                    @if($latestOrder)
                    <div class="ld-plan-item"><span class="ld-plan-label">Plan</span><span class="ld-plan-val">{{ $latestOrder->plan?->name ?? 'N/A' }}</span></div>
                    <div class="ld-plan-item"><span class="ld-plan-label">Price/day</span><span class="ld-plan-val">{{ number_format($latestOrder->plan?->price_per_day ?? 0) }} RWF</span></div>
                    <div class="ld-plan-item"><span class="ld-plan-label">Duration</span><span class="ld-plan-val">{{ $latestOrder->days ?? '—' }} days</span></div>
                    <div class="ld-plan-item"><span class="ld-plan-label">Total</span><span class="ld-plan-val">{{ number_format($latestOrder->total_price ?? 0) }} RWF</span></div>
                    <div class="ld-plan-item">
                        <span class="ld-plan-label">Payment</span>
                        <span class="badge {{ match($latestOrder->payment?->status) { 'success' => 'bg-success', 'pending' => 'bg-warning text-dark', default => 'bg-danger' } }}">
                            {{ ucfirst($latestOrder->payment?->status ?? 'pending') }}
                        </span>
                    </div>
                    <div class="ld-plan-item">
                        <span class="ld-plan-label">Approval</span>
                        <span class="badge {{ $land->is_approved ? 'bg-success' : 'bg-secondary' }}">
                            {{ $land->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </div>
                    @if(!$isAgent)
                    @if($latestOrder->payment?->status === 'success' && !$land->is_approved)
                    <button class="btn btn-primary btn-sm w-100 mt-3 d-flex align-items-center justify-content-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#approveModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:13px;height:13px">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Approve This Land
                    </button>
                    @endif
                    @else
                    <p class="text-muted small mb-0 text-center py-2">No plan orders found.</p>
                    @endif
                    @endif
                </div>
            </div>

            {{-- Quick actions ── --}}
            <div class="ld-card">
                <div class="ld-card-head">
                    <h6 class="ld-card-head-title">Quick Actions</h6>
                </div>
                <div class="ld-card-body d-flex flex-column gap-2">
                    @if(!$isAgent)
                    <a href="{{ route('agent.properties.lands.edit', $land->id) }}"
                        class="btn btn-outline-warning btn-sm d-flex align-items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Edit Land Details
                    </a>
                    @endif
                    <button class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2"
                        type="button" data-bs-toggle="collapse" data-bs-target="#uploadZone"
                        onclick="document.getElementById('uploadZone').scrollIntoView({behavior:'smooth'})">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px">
                            <path d="M14 13v4h-4v-4H7l5-5 5 5h-3z M4 19h16v2H4v-2z" />
                        </svg>
                        Upload Photos
                    </button>
                    @if($land->images && $land->images->count())
                    <a href="{{ route('agent.properties.lands.images.download', $land->id) }}"
                        class="btn btn-outline-info btn-sm d-flex align-items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px">
                            <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                        </svg>
                        Download All Photos
                    </a>
                    @endif
                    <a href="{{ route('front.buy.land.details', $land->id) }}" target="_blank"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3" />
                        </svg>
                        View on Site
                    </a>
                    @if(!$isAgent)
                    <button class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14H6L5 6" />
                            <path d="M10 11v6M14 11v6" />
                            <path d="M9 6V4h6v2" />
                        </svg>
                        Delete Land
                    </button>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>{{-- /row --}}



<script>
    (function() {

        /* ── Gallery Lightbox ── */
        const lightbox = document.getElementById('galleryLightbox');
        const lightboxImg = document.getElementById('lightboxImage');
        const closeLightboxBtn = document.getElementById('closeLightboxBtn');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const downloadBtn = document.getElementById('downloadBtn');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const viewGalleryBtn = document.getElementById('viewGalleryBtn');
        const currentImageIndexSpan = document.getElementById('currentImageIndex');
        const galleryImages = document.querySelectorAll('.gallery-image');
        const photoCount = document.getElementById('photoCount');
        const galleryViewAll = document.querySelector('.gallery-view-all');

        let currentIndex = 0;
        // Get total images from lightbox thumbnails (which shows ALL images)
        const lightboxThumbnails = document.querySelectorAll('.ld-lightbox-thumbnail');
        let totalImages = lightboxThumbnails.length;

        function updateLightbox(index) {
            if (index < 0) currentIndex = totalImages - 1;
            if (index >= totalImages) currentIndex = 0;

            // Get image from lightbox thumbnails (which has ALL images)
            const thumbnail = lightboxThumbnails[currentIndex];
            if (thumbnail) {
                const thumbImg = thumbnail.querySelector('img');
                lightboxImg.src = thumbImg.src;
            }
            currentImageIndexSpan.textContent = currentIndex + 1;

            // Update active thumbnail
            document.querySelectorAll('.ld-lightbox-thumbnail').forEach((thumb, i) => {
                thumb.classList.toggle('active', i === currentIndex);
            });

            // Scroll thumbnail into view
            const activeThumbnail = document.querySelector('.ld-lightbox-thumbnail.active');
            if (activeThumbnail) {
                activeThumbnail.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        }

        function openLightbox(index = 0) {
            // Refresh total images count in case it changed
            const allThumbnails = document.querySelectorAll('.ld-lightbox-thumbnail');
            totalImages = allThumbnails.length;

            currentIndex = index;
            lightbox.classList.add('active');
            updateLightbox(currentIndex);
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Event listeners
        galleryImages.forEach((img, i) => {
            img.addEventListener('click', () => openLightbox(i));
        });

        photoCount?.addEventListener('click', () => openLightbox(0));
        galleryViewAll?.addEventListener('click', () => openLightbox(0));
        viewGalleryBtn?.addEventListener('click', () => openLightbox(0));

        closeLightboxBtn?.addEventListener('click', closeLightbox);

        prevBtn?.addEventListener('click', () => {
            currentIndex--;
            updateLightbox(currentIndex);
        });

        nextBtn?.addEventListener('click', () => {
            currentIndex++;
            updateLightbox(currentIndex);
        });

        downloadBtn?.addEventListener('click', () => {
            const link = document.createElement('a');
            link.href = lightboxImg.src;
            link.download = true;
            link.click();
        });

        fullscreenBtn?.addEventListener('click', () => {
            if (lightboxImg.requestFullscreen) {
                lightboxImg.requestFullscreen();
            }
        });

        // Lightbox thumbnail clicks
        document.querySelectorAll('.ld-lightbox-thumbnail').forEach((thumb, i) => {
            thumb.addEventListener('click', () => {
                currentIndex = i;
                updateLightbox(currentIndex);
            });
        });

        // Preview strip thumbnail clicks (update main gallery image)
        document.querySelectorAll('.preview-thumb-scroll').forEach((thumb) => {
            thumb.addEventListener('click', (e) => {
                const index = parseInt(thumb.dataset.index);
                const img = galleryImages[index];
                if (img) {
                    // Update main gallery image
                    document.getElementById('main-gallery-img').src = img.src;

                    // Update all preview thumbs
                    document.querySelectorAll('.preview-thumb-scroll').forEach((t, i) => {
                        t.style.borderColor = i === index ? '#19265d' : 'transparent';
                        t.style.opacity = i === index ? '1' : '0.6';
                    });
                }
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;

            if (e.key === 'ArrowLeft') {
                currentIndex--;
                updateLightbox(currentIndex);
            } else if (e.key === 'ArrowRight') {
                currentIndex++;
                updateLightbox(currentIndex);
            } else if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        // Close on background click
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });

        /* ── Photo upload zone ── */
        const input = document.getElementById('photo-input');
        const previews = document.getElementById('upload-previews');
        const submitBtn = document.getElementById('submit-upload');
        const cntSpan = document.getElementById('upload-count');
        const clearBtn = document.getElementById('clear-uploads');
        const dropZone = document.getElementById('drop-zone');
        let files = [];

        function renderPreviews() {
            previews.innerHTML = '';
            files.forEach((f, i) => {
                const url = URL.createObjectURL(f);
                const wrap = document.createElement('div');
                wrap.className = 'ld-preview-thumb';
                wrap.innerHTML = `<img src="${url}"><button class="ld-preview-rm" data-i="${i}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg></button>`;
                previews.appendChild(wrap);
            });
            const n = files.length;
            submitBtn.disabled = n === 0;
            cntSpan.textContent = n > 0 ? `(${n})` : '';
        }

        if (input) input.addEventListener('change', e => {
            files = [...files, ...Array.from(e.target.files)];
            renderPreviews();
        });

        if (previews) previews.addEventListener('click', e => {
            const btn = e.target.closest('[data-i]');
            if (!btn) return;
            files.splice(+btn.dataset.i, 1);
            renderPreviews();
        });

        if (clearBtn) clearBtn.addEventListener('click', () => {
            files = [];
            renderPreviews();
        });

        /* Drag & drop */
        if (dropZone) {
            dropZone.addEventListener('dragover', e => {
                e.preventDefault();
                dropZone.classList.add('dragover');
            });
            dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
            dropZone.addEventListener('drop', e => {
                e.preventDefault();
                dropZone.classList.remove('dragover');
                files = [...files, ...Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'))];
                renderPreviews();
            });
        }

        /* On form submit, attach files to a DataTransfer */
        const form = document.getElementById('upload-form');
        if (form) form.addEventListener('submit', e => {
            if (files.length === 0) {
                e.preventDefault();
                return;
            }
            const dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            input.files = dt.files;
        });
    })();
</script>

@endsection