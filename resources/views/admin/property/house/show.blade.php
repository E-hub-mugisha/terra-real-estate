@extends('layouts.app')
@section('title', 'House Details — '.$house->title)
@section('content')

<style>
    /* ── Top bar ── */
    .hd-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .hd-back-btn {
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

    .hd-back-btn:hover {
        border-color: #3b82f6;
        color: #2563eb;
        background: #eff6ff;
    }

    .hd-back-btn svg {
        width: 14px;
        height: 14px;
    }

    .hd-action-btn {
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

    .hd-btn-edit {
        background: #fef9c3;
        color: #854d0e;
        border: 1.5px solid #fde68a;
    }

    .hd-btn-edit:hover {
        background: #fde68a;
        color: #78350f;
    }

    .hd-btn-approve {
        background: #dcfce7;
        color: #166534;
        border: 1.5px solid #86efac;
    }

    .hd-btn-approve:hover {
        background: #86efac;
        color: #14532d;
    }

    .hd-btn-delete {
        background: #fef2f2;
        color: #dc2626;
        border: 1.5px solid #fca5a5;
    }

    .hd-btn-delete:hover {
        background: #fca5a5;
        color: #991b1b;
    }

    /* ── Gallery ── */
    .hd-gallery {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 260px 170px;
        gap: 8px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
    }

    .hd-gal-main {
        grid-row: 1/3;
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }

    .hd-gal-thumb {
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
    }

    .hd-gal-main img,
    .hd-gal-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease;
    }

    .hd-gal-main:hover img,
    .hd-gal-thumb:hover img {
        transform: scale(1.04);
    }

    .hd-gal-ph {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    }

    .hd-gal-ph svg {
        width: 36px;
        height: 36px;
        color: #cbd5e1;
    }

    .hd-photo-actions {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 5px;
        z-index: 3;
    }

    .hd-photo-btn {
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

    .hd-photo-btn:hover {
        background: #fff;
        color: #2563eb;
    }

    .hd-photo-btn svg {
        width: 13px;
        height: 13px;
    }

    .hd-photo-count {
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
    }

    /* Upload zone */
    .hd-upload-zone {
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        background: #fafbfc;
        cursor: pointer;
        transition: all .18s;
    }

    .hd-upload-zone:hover,
    .hd-upload-zone.dragover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .hd-upload-zone svg {
        width: 26px;
        height: 26px;
        color: #94a3b8;
        margin-bottom: 6px;
    }

    .hd-upload-zone p {
        font-size: .8rem;
        color: #64748b;
        margin: 0;
    }

    .hd-upload-zone span {
        font-size: .72rem;
        color: #94a3b8;
    }

    .hd-upload-previews {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .hd-prev-thumb {
        position: relative;
        width: 64px;
        height: 52px;
        border-radius: 7px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .hd-prev-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .hd-prev-rm {
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

    .hd-prev-rm svg {
        width: 9px;
        height: 9px;
        color: #fff;
    }

    /* ── Specs strip ── */
    .hd-specs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        gap: 0;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .hd-spec-cell {
        padding: 13px 10px;
        text-align: center;
        border-right: 1px solid #e2e8f0;
    }

    .hd-spec-cell:last-child {
        border-right: none;
    }

    .hd-spec-label {
        font-size: .67rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .06em;
        margin-bottom: 4px;
    }

    .hd-spec-val {
        font-weight: 700;
        font-size: .86rem;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }

    .hd-spec-val svg {
        width: 12px;
        height: 12px;
        color: #64748b;
    }

    /* ── Cards ── */
    .hd-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .hd-card-head {
        padding: 13px 18px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .hd-card-head-title {
        font-size: .88rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .hd-card-head-title svg {
        width: 14px;
        height: 14px;
        color: #64748b;
    }

    .hd-card-body {
        padding: 18px;
    }

    /* ── Condition badge ── */
    .hd-cond {
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

    .hd-cond::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .hc-for_sale {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .hc-for_rent {
        background: #f0fdf4;
        color: #166534;
    }

    .hc-sold {
        background: #fdf4ff;
        color: #7e22ce;
    }

    .hc-inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    /* ── Detail table ── */
    .hd-detail-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 9px 0;
        border-bottom: 1px solid #f8fafc;
        font-size: .82rem;
    }

    .hd-detail-row:last-child {
        border-bottom: none;
    }

    .hd-detail-label {
        color: #94a3b8;
        font-weight: 500;
        flex-shrink: 0;
    }

    .hd-detail-val {
        color: #1e293b;
        font-weight: 600;
        text-align: right;
    }

    /* ── Amenity grid ── */
    .hd-amenity-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 8px;
    }

    .hd-amenity {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 9px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        font-size: .8rem;
        color: #475569;
        transition: all .18s;
    }

    .hd-amenity:hover {
        border-color: #bfdbfe;
        background: #eff6ff;
        color: #1d4ed8;
    }

    .hd-amenity-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .hd-amenity-icon svg {
        width: 13px;
        height: 13px;
        color: #2563eb;
    }

    /* ── Sidebar ── */
    .hd-sidebar {
        position: sticky;
        top: 24px;
    }

    .hd-sb-price {
        background: #0E0E0C;
        border-radius: var(--r, 12px);
        overflow: hidden;
        margin-bottom: 14px;
        position: relative;
    }

    .hd-sb-price::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 60% at 20% 50%, rgba(37, 99, 235, .18) 0%, transparent 65%);
        pointer-events: none;
    }

    .hd-sb-price-inner {
        position: relative;
        z-index: 1;
        padding: 22px 20px;
    }

    .hd-sb-label {
        font-size: .68rem;
        color: rgba(255, 255, 255, .35);
        text-transform: uppercase;
        letter-spacing: .1em;
        margin-bottom: 5px;
    }

    .hd-sb-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.7rem;
        font-weight: 600;
        letter-spacing: -.02em;
        line-height: 1;
        color: #fff;
        margin-bottom: 3px;
    }

    .hd-sb-unit {
        font-size: .75rem;
        color: rgba(255, 255, 255, .35);
    }

    .hd-cond-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 9px;
        border-radius: 5px;
        margin-top: 10px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .hd-cond-badge.for_sale {
        background: rgba(59, 130, 246, .15);
        border: 1px solid rgba(59, 130, 246, .3);
        color: #93c5fd;
    }

    .hd-cond-badge.for_rent {
        background: rgba(34, 197, 94, .12);
        border: 1px solid rgba(34, 197, 94, .25);
        color: #86efac;
    }

    .hd-cond-badge.sold {
        background: rgba(168, 85, 247, .12);
        border: 1px solid rgba(168, 85, 247, .25);
        color: #d8b4fe;
    }

    .hd-cond-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Agent card */
    .hd-agent-av {
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

    .hd-agent-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f8fafc;
        font-size: .8rem;
    }

    .hd-agent-row:last-child {
        border-bottom: none;
    }

    /* Plan card */
    .hd-plan-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 9px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: .81rem;
    }

    .hd-plan-item:last-child {
        border-bottom: none;
    }

    .hd-plan-label {
        color: #94a3b8;
    }

    .hd-plan-val {
        font-weight: 600;
        color: #1e293b;
    }

    @media (max-width:640px) {
        .hd-gallery {
            grid-template-columns: 1fr;
            grid-template-rows: 200px 130px 130px;
        }

        .hd-gal-main {
            grid-row: auto;
        }
    }
</style>

{{-- ── Top bar ── --}}
<div class="hd-topbar">
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.properties.houses.index') }}" class="hd-back-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 5l-7 7 7 7" />
            </svg>
            Back to Houses
        </a>
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="#">Property</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.properties.houses.index') }}">Houses</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width:180px">{{ $house->title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="{{ route('admin.properties.houses.edit', $house->id) }}" class="hd-action-btn hd-btn-edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
            </svg>
            Edit House
        </a>
        @php $latestOrder = $house->planOrders()->latest()->first(); @endphp
        @if($latestOrder?->payment?->status === 'success' && !$house->is_approved)
        <button class="hd-action-btn hd-btn-approve" data-bs-toggle="modal" data-bs-target="#approveModal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Approve
        </button>
        @endif
        <button class="hd-action-btn hd-btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                <polyline points="3 6 5 6 21 6" />
                <path d="M19 6l-1 14H6L5 6" />
                <path d="M10 11v6M14 11v6" />
                <path d="M9 6V4h6v2" />
            </svg>
            Delete
        </button>
    </div>
</div>

<div class="row g-3">

    {{-- ══ LEFT ══ --}}
    <div class="col-xl-8">

        {{-- Gallery ── --}}
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                    </svg>
                    Property Photos
                </h6>
                <div class="d-flex gap-2">
                    @if($house->images->count())
                    <a href="{{ route('admin.properties.houses.images.download', $house->id) }}"
                        class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px">
                            <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                        </svg>
                        Download All
                    </a>
                    @endif
                    <button class="btn btn-sm btn-primary d-flex align-items-center gap-1"
                        type="button" data-bs-toggle="collapse" data-bs-target="#uploadZone">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px">
                            <path d="M14 13v4h-4v-4H7l5-5 5 5h-3z M4 19h16v2H4v-2z" />
                        </svg>
                        Upload Photos
                    </button>
                </div>
            </div>
            <div class="hd-card-body">

                <div class="hd-gallery">

                    {{-- Main image --}}
                    <div class="hd-gal-main">
                        @if($house->images->first())
                        <img src="{{asset('image/houses/')}}/{{ $house->images->first()->image_path }}"
                            alt="{{ $house->title }}" loading="lazy">

                        <div class="hd-photo-actions">
                            <a href="{{asset('image/houses/')}}/{{ $house->images->first()->image_path }}" download class="hd-photo-btn" title="Download">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg>
                            </a>
                            <a href="{{asset('image/houses/')}}/{{ $house->images->first()->image_path }}" target="_blank" class="hd-photo-btn" title="View full size">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7" />
                                </svg>
                            </a>
                        </div>

                        <span class="hd-photo-count">{{ $house->images->count() }} photos</span>
                        @else
                        <div class="hd-gal-ph">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    {{-- Thumb 1 --}}
                    <div class="hd-gal-thumb">
                        @if($house->images->get(1))
                        <img src="{{asset('image/houses/')}}/{{ $house->images->get(1)->image_path}}"
                            alt="{{ $house->title }}" loading="lazy">

                        <div class="hd-photo-actions">
                            <a href="{{asset('image/houses/')}}/{{ $house->images->get(1)->image_path}}" download class="hd-photo-btn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg>
                            </a>
                        </div>
                        @else
                        <div class="hd-gal-ph">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                    {{-- Thumb 2 --}}
                    <div class="hd-gal-thumb" style="position:relative">
                        @if($house->images->get(2))
                        <img src="{{asset('image/houses/')}}/{{ $house->images->get(2)->image_path}}"
                            alt="{{ $house->title }}" loading="lazy">

                        <div class="hd-photo-actions">
                            <a href="{{asset('image/houses/')}}/{{ $house->images->get(2)->image_path}}" download class="hd-photo-btn">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                                </svg>
                            </a>
                        </div>

                        @if($house->images->count() > 3)
                        <div style="position:absolute;inset:0;background:rgba(0,0,0,.45);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;font-weight:700">
                            +{{ $house->images->count() - 3 }}
                        </div>
                        @endif

                        @else
                        <div class="hd-gal-ph">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                            </svg>
                        </div>
                        @endif
                    </div>

                </div>

                {{-- Upload zone ── --}}
                <div class="collapse" id="uploadZone">
                    <form method="POST" action="{{ route('admin.properties.houses.images.upload', $house->id) }}"
                        enctype="multipart/form-data" id="upload-form">
                        @csrf
                        <div class="hd-upload-zone" id="drop-zone" onclick="document.getElementById('photo-input').click()">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.35 10.04A7.49 7.49 0 0012 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 000 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z" />
                            </svg>
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

        {{-- Title + specs ── --}}
        <div class="hd-card">
            <div class="hd-card-body">
                @php $cond = strtolower($house->condition ?? 'for_sale'); @endphp
                <div class="d-flex align-items-flex-start justify-content-between gap-2 flex-wrap mb-3">
                    <div>
                        <span class="hd-cond {{ match($cond){ 'for_sale'=>'hc-for_sale','for_rent'=>'hc-for_rent','sold'=>'hc-sold',default=>'hc-inactive' } }}">
                            {{ ucwords(str_replace('_',' ',$cond)) }}
                        </span>
                        <h5 class="mt-2 mb-1 fw-semibold">{{ $house->title }}</h5>
                        <p class="text-muted small mb-0 d-flex align-items-center gap-1">
                            <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px;color:#c8873a">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            </svg>
                            {{ $house->address }}, {{ $house->city }}, {{ $house->state }} {{ $house->zip_code }}
                        </p>
                    </div>
                    <div class="text-end">
                        <p class="text-muted small mb-1">Listed Price</p>
                        <h4 class="fw-bold text-primary mb-0">{{ number_format($house->price) }} <span class="fs-sm text-muted fw-normal">RWF</span></h4>
                        <p class="small text-muted mt-1 mb-0">Type: <b class="text-dark">{{ $house->type ?? '—' }}</b></p>
                    </div>
                </div>

                {{-- Spec strip ── --}}
                <div class="hd-specs">
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Bedrooms</div>
                        <div class="hd-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z" />
                            </svg>
                            {{ $house->bedrooms ?? '—' }}
                        </div>
                    </div>
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Bathrooms</div>
                        <div class="hd-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z" />
                            </svg>
                            {{ $house->bathrooms ?? '—' }}
                        </div>
                    </div>
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Area (ft²)</div>
                        <div class="hd-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                            </svg>
                            {{ number_format($house->area_sqft ?? 0) }}
                        </div>
                    </div>
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Garages</div>
                        <div class="hd-spec-val">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z" />
                            </svg>
                            {{ $house->garages ?? '—' }}
                        </div>
                    </div>
                    <div class="hd-spec-cell">
                        <div class="hd-spec-label">Approved</div>
                        <div class="hd-spec-val">
                            @if($house->is_approved)
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
        @if($house->description)
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title"><svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                    </svg>Description</h6>
            </div>
            <div class="hd-card-body">
                <p class="text-muted mb-0" style="font-size:.84rem;line-height:1.8">{{ $house->description }}</p>
            </div>
        </div>
        @endif

        {{-- Full details ── --}}
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title"><svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>Property Details</h6>
                <a href="{{ route('admin.properties.houses.edit', $house->id) }}"
                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                    <i class="ri-edit-line"></i> Edit
                </a>
            </div>
            <div class="hd-card-body">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="hd-detail-row"><span class="hd-detail-label">Title</span><span class="hd-detail-val">{{ $house->title }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Type</span><span class="hd-detail-val">{{ $house->type ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Condition</span><span class="hd-detail-val">{{ ucwords(str_replace('_',' ',$house->condition ?? '—')) }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Bedrooms</span><span class="hd-detail-val">{{ $house->bedrooms ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Bathrooms</span><span class="hd-detail-val">{{ $house->bathrooms ?? '—' }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Garages</span><span class="hd-detail-val">{{ $house->garages ?? '—' }}</span></div>
                    </div>
                    <div class="col-md-6 ps-md-4">
                        <div class="hd-detail-row"><span class="hd-detail-label">Area (ft²)</span><span class="hd-detail-val">{{ number_format($house->area_sqft ?? 0) }}</span></div>
                        <div class="hd-detail-row"><span class="hd-detail-label">Price (RWF)</span><span class="hd-detail-val">{{ number_format($house->price) }}</span></div>
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

        {{-- Amenities / Facilities ── --}}
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title"><svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>Amenities &amp; Features</h6>
            </div>
            <div class="hd-card-body">
                <div class="hd-amenity-grid">
                    <div class="hd-amenity">
                        <div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4z" />
                            </svg></div>{{ $house->bedrooms ?? '—' }} Bedrooms
                    </div>
                    <div class="hd-amenity">
                        <div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3v6.93L7 22h2l-.895-2h7.79L15 22h2l4-5.07V10z" />
                            </svg></div>{{ $house->bathrooms ?? '—' }} Bathrooms
                    </div>
                    <div class="hd-amenity">
                        <div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                            </svg></div>{{ number_format($house->area_sqft ?? 0) }} ft²
                    </div>
                    <div class="hd-amenity">
                        <div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4z" />
                            </svg></div>{{ $house->garages ?? '—' }} Garages
                    </div>
                    <div class="hd-amenity">
                        <div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            </svg></div>{{ $house->city }}
                    </div>
                    <div class="hd-amenity">
                        <div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg></div>{{ $house->type ?? 'House' }}
                    </div>
                    @foreach($house->facilities ?? [] as $facility)
                    <div class="hd-amenity">
                        <div class="hd-amenity-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg></div>{{ $facility->name }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Map ── --}}
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title"><svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                    </svg>Location Map</h6>
            </div>
            <div style="padding:0">
                @if($house->latitude && $house->longitude)
                <iframe
                    width="100%" height="240"
                    style="border:0;display:block"
                    loading="lazy" allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q={{ $house->latitude }},{{ $house->longitude }}&output=embed">
                </iframe>
                @else
                <iframe
                    width="100%" height="240"
                    style="border:0;display:block"
                    loading="lazy" allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.google.com/maps?q={{ urlencode(($house->sector ?? '').','.($house->district ?? '').','.($house->province ?? '').', Rwanda') }}&output=embed">
                </iframe>
                @endif
            </div>
        </div>
        @if($house->video_url)
        <div class="hd-card">
            <div class="hd-card-head">
                <h6 class="hd-card-head-title">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                    Video Tour
                </h6>
            </div>

            @php
            $isYoutube = preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $house->video_url,
            $ytMatches
            );
            $youtubeId = $isYoutube ? $ytMatches[1] : null;
            @endphp

            <div style="padding:0">
                @if($youtubeId)
                <div style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $youtubeId }}"
                        title="Video Tour"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
                </div>
                @else
                <video
                    src="{{ $house->video_url }}"
                    controls
                    style="width:100%;max-height:320px;background:#000;"></video>
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
                    <div class="hd-sb-unit">Rwandan Francs (RWF)</div>
                    <div class="hd-cond-badge {{ $cond }}">
                        {{ ucwords(str_replace('_',' ',$cond)) }}
                    </div>
                </div>
            </div>

            {{-- Agent card ── --}}
            <div class="hd-card">
                <div class="hd-card-head">
                    <h6 class="hd-card-head-title">Listed By</h6>
                </div>
                <div class="hd-card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="hd-agent-av">{{ strtoupper(substr($house->user->name ?? 'U', 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:700;font-size:.9rem;color:#1e293b">{{ $house->user->name ?? '—' }}</div>
                            <div style="font-size:.73rem;color:#64748b">{{ ucfirst($house->user->role ?? 'Agent') }}</div>
                        </div>
                    </div>
                    <div class="hd-agent-row"><span class="text-muted">Phone</span><span class="fw-600">{{ $house->user->phone ?? 'N/A' }}</span></div>
                    <div class="hd-agent-row"><span class="text-muted">Email</span><span class="fw-600 text-truncate" style="max-width:160px">{{ $house->user->email ?? '—' }}</span></div>
                    <div class="hd-agent-row"><span class="text-muted">Role</span><span class="fw-600">{{ ucfirst($house->user->role ?? '—') }}</span></div>
                    <div class="hd-agent-row"><span class="text-muted">Working Hours</span><span class="fw-600">Mon–Fri, 9am–6pm</span></div>
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
            <div class="hd-card">
                <div class="hd-card-head">
                    <h6 class="hd-card-head-title">Plan & Approval</h6>
                    @if($house->is_approved)
                    <span class="badge bg-success-subtle text-success">Approved</span>
                    @else
                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                    @endif
                </div>
                <div class="hd-card-body">
                    @php
                    $payment = $house->payments()->with('listingPackage')->latest()->first();
                    @endphp

                    @if($payment)
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Package</span>
                        <span class="hd-plan-val">{{ $payment->listingPackage?->package_tier ?? 'N/A' }}</span>
                    </div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Price/day</span>
                        <span class="hd-plan-val">{{ number_format($payment->listingPackage?->price_per_day ?? 0) }} RWF</span>
                    </div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Duration</span>
                        <span class="hd-plan-val">
                            {{ $payment->payable?->listing_days ?? '—' }} days
                        </span>
                    </div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Total</span>
                        <span class="hd-plan-val">{{ number_format($payment->amount) }} RWF</span>
                    </div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Payment</span>
                        <span class="badge {{ match($payment->status) {
                    'completed'  => 'bg-success',
                    'pending'    => 'bg-warning text-dark',
                    'processing' => 'bg-info text-dark',
                    default      => 'bg-danger'
                } }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Reference</span>
                        <span class="hd-plan-val" style="font-family:monospace;font-size:.78rem;color:#C8873A;">
                            {{ $payment->reference }}
                        </span>
                    </div>
                    <div class="hd-plan-item">
                        <span class="hd-plan-label">Approval</span>
                        <span class="badge {{ $house->is_approved ? 'bg-success' : 'bg-secondary' }}">
                            {{ $house->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </div>

                    @if($payment->status === 'completed' && !$house->is_approved)
                    <button class="btn btn-primary btn-sm w-100 mt-3 d-flex align-items-center justify-content-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#approveModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="width:13px;height:13px">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Approve This house
                    </button>
                    @endif

                    @if($payment->status === 'pending')
                    <a href="{{ route('payment.show', $payment->reference) }}"
                        class="btn btn-warning btn-sm w-100 mt-3 text-dark fw-semibold">
                        Complete Payment →
                    </a>
                    @endif

                    @else
                    <p class="text-muted small mb-0 text-center py-2">No payment found.</p>
                    @endif
                </div>
            </div>
            {{-- ── VIEW ANALYTICS CARD ─────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">👁 View Analytics</h6>
                    @if($house->status !== 'active')
                    <span style="font-size:.68rem;color:#7A736B;background:#F5F5F5;padding:2px 8px;border-radius:10px">
                        Only tracked when active
                    </span>
                    @endif
                </div>

                {{-- Top counters ── --}}
                <div class="card-body p-0">
                    <div class="row g-0" style="border-bottom:1px solid #E8E3DC">

                        {{-- Total views --}}
                        <div class="col-6" style="padding:16px 20px;border-right:1px solid #E8E3DC">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Total Views</div>
                            <div style="font-size:1.6rem;font-weight:800;color:var(--terra-navy);line-height:1">
                                {{ number_format($viewStats['total']) }}
                            </div>
                            <div style="font-size:.7rem;color:#7A736B;margin-top:3px">all time</div>
                        </div>

                        {{-- Unique views --}}
                        <div class="col-6" style="padding:16px 20px">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Unique Visitors</div>
                            <div style="font-size:1.6rem;font-weight:800;color:#1a5276;line-height:1">
                                {{ number_format($viewStats['unique']) }}
                            </div>
                            <div style="font-size:.7rem;color:#7A736B;margin-top:3px">distinct IPs</div>
                        </div>
                    </div>

                    {{-- Period breakdown ── --}}
                    <div style="padding:12px 20px;border-bottom:1px solid #E8E3DC">
                        @php
                        $periods = [
                        ['label' => 'Today', 'value' => $viewStats['today']],
                        ['label' => 'This Week', 'value' => $viewStats['this_week']],
                        ['label' => 'This Month', 'value' => $viewStats['this_month']],
                        ];
                        // Compute the max for the tiny bar widths
                        $maxPeriod = max(max(array_column($periods, 'value')), 1);
                        @endphp

                        @foreach($periods as $period)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div style="width:72px;font-size:.72rem;color:#7A736B;flex-shrink:0">{{ $period['label'] }}</div>
                            <div style="flex:1;height:6px;background:#F0EDE8;border-radius:3px;overflow:hidden">
                                <div style="height:100%;width:{{ $maxPeriod > 0 ? round(($period['value'] / $maxPeriod) * 100) : 0 }}%;background:var(--terra-navy);border-radius:3px;transition:width .4s ease"></div>
                            </div>
                            <div style="width:28px;text-align:right;font-size:.78rem;font-weight:700;color:var(--terra-navy);flex-shrink:0">
                                {{ number_format($period['value']) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- 14-day sparkline ── --}}
                    <div style="padding:16px 20px">
                        <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px">
                            Last 14 Days
                        </div>

                        @php
                        $chartData = $viewStats['daily_chart']; // ['Y-m-d' => count]
                        $chartMax = max(array_values($chartData) ?: [1]);
                        $chartDates = array_keys($chartData);
                        $chartVals = array_values($chartData);
                        $barCount = count($chartVals);
                        @endphp

                        @if(array_sum($chartVals) === 0)
                        <div style="text-align:center;padding:20px 0;color:#7A736B;font-size:.78rem">
                            No views recorded in the last 14 days.
                        </div>
                        @else
                        {{-- SVG sparkline --}}
                        <svg viewBox="0 0 280 60" xmlns="http://www.w3.org/2000/svg"
                            style="width:100%;height:60px;overflow:visible"
                            aria-label="Daily views chart">

                            {{-- Grid lines --}}
                            <line x1="0" y1="0" x2="280" y2="0" stroke="#E8E3DC" stroke-width=".5" />
                            <line x1="0" y1="30" x2="280" y2="30" stroke="#E8E3DC" stroke-width=".5" stroke-dasharray="3,3" />
                            <line x1="0" y1="59" x2="280" y2="59" stroke="#E8E3DC" stroke-width=".5" />

                            @php
                            $barW = floor(280 / $barCount) - 2;
                            $barW = max($barW, 4);
                            $gap = (280 - ($barW * $barCount)) / ($barCount + 1);
                            @endphp

                            @foreach($chartVals as $i => $val)
                            @php
                            $barH = $chartMax > 0 ? max(2, round(($val / $chartMax) * 56)) : 2;
                            $x = round($gap + $i * ($barW + $gap));
                            $y = 58 - $barH;
                            $isLast = $i === $barCount - 1;
                            @endphp
                            <rect x="{{ $x }}" y="{{ $y }}"
                                width="{{ $barW }}" height="{{ $barH }}"
                                rx="2"
                                fill="{{ $isLast ? 'var(--terra-navy, #19265d)' : '#B8C5D6' }}"
                                opacity="{{ $isLast ? '1' : '0.6' }}">
                                <title>{{ $chartDates[$i] }}: {{ $val }} view{{ $val === 1 ? '' : 's' }}</title>
                            </rect>
                            @endforeach
                        </svg>

                        {{-- x-axis labels: first, mid, last --}}
                        <div style="display:flex;justify-content:space-between;margin-top:4px">
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse($chartDates[0])->format('d M') }}
                            </span>
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse($chartDates[floor($barCount/2)])->format('d M') }}
                            </span>
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse(end($chartDates))->format('d M') }}
                            </span>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            {{-- ── END VIEW ANALYTICS CARD ─────────────────────────────────── --}}
            {{-- Quick actions ── --}}
            <div class="hd-card">
                <div class="hd-card-head">
                    <h6 class="hd-card-head-title">Quick Actions</h6>
                </div>
                <div class="hd-card-body d-flex flex-column gap-2">
                    <!-- status button modal -->
                    <button class="btn btn-outline-info btn-sm d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#statusModal">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px">
                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Change Status
                    </button>


                    <a href="{{ route('admin.properties.houses.edit', $house->id) }}"
                        class="btn btn-outline-warning btn-sm d-flex align-items-center gap-2">
                        <i class="ri-edit-line"></i> Edit House Details
                    </a>
                    <button class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2"
                        type="button" data-bs-toggle="collapse" data-bs-target="#uploadZone"
                        onclick="document.getElementById('uploadZone').scrollIntoView({behavior:'smooth'})">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px">
                            <path d="M14 13v4h-4v-4H7l5-5 5 5h-3z" />
                        </svg>
                        Upload Photos
                    </button>
                    @if($house->images->count())
                    <a href="{{ route('admin.properties.houses.images.download', $house->id) }}"
                        class="btn btn-outline-info btn-sm d-flex align-items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px">
                            <path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z" />
                        </svg>
                        Download All Photos
                    </a>
                    @endif
                    <a href="{{ route('front.buy.home.details', $house->id) }}" target="_blank"
                        class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                            <path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6M15 3h6v6M10 14L21 3" />
                        </svg>
                        View on Site
                    </a>
                    <button class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14H6L5 6" />
                            <path d="M10 11v6M14 11v6" />
                            <path d="M9 6V4h6v2" />
                        </svg>
                        Delete House
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <form method="POST" action="{{ route('admin.properties.houses.status', $house) }}" class="modal-content">
            @csrf
            @method('PATCH')
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                        <svg viewBox="0 0 24 24" fill="#3b82f6" style="width:18px;height:18px">
                            <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h6 class="mb-0">Change house Status</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <p class="text-muted small mb-2">You are changing the status of the following house:</p>
                <div class="bg-light rounded p-3 mb-3">
                    <p class="fw-600 mb-1">{{ $house->title }}</p>
                    <p class="text-muted small mb-0">
                        Listed by <b>{{ $house->user->name }}</b> · {{ $house->district }}, {{ $house->province }}
                    </p>
                </div>
                <div class="mb-3">
                    <label for="statusSelect" class="form-label">Select new status</label>
                    <select class="form-select" id="statusSelect" name="status" required>
                        <option value="available" {{ $house->status === 'available' ? 'selected' : '' }}>available</option>
                        <option value="reserved" {{ $house->status === 'reserved' ? 'selected' : '' }}>reserved</option>
                        <option value="sold" {{ $house->status === 'sold' ? 'selected' : '' }}>Sold</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-info w-100">Update Status</button>
            </div>
        </form>
    </div>
</div>

{{-- ══ APPROVE MODAL ══ --}}
@if(isset($payment) && $payment?->status === 'completed' && !$house->is_approved)
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <form method="POST" action="{{ route('admin.properties.houses.approve', $house) }}" class="modal-content">
            @csrf
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" style="width:18px;height:18px">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h6 class="mb-0">Approve house Property</h6>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <p class="text-muted small mb-2">You are approving the following property:</p>
                <div class="bg-light rounded p-3 mb-3">
                    <p class="fw-600 mb-1">{{ $house->title }}</p>
                    <p class="text-muted small mb-0">
                        Listed by <b>{{ $house->user->name }}</b> · {{ $house->district }}, {{ $house->province }}
                    </p>
                </div>

                {{-- Payment summary ── --}}
                <div class="border rounded p-3 mb-3" style="border-color:rgba(200,135,58,.25) !important;background:#faf7f2;">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Package</span>
                        <span class="small fw-semibold">{{ ucfirst($payment->listingPackage?->package_tier ?? 'N/A') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Amount Paid</span>
                        <span class="small fw-semibold text-success">{{ number_format($payment->amount) }} {{ $payment->currency }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Transaction ID</span>
                        <span class="small" style="font-family:monospace;color:#C8873A;">{{ $payment->transaction_id ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Reference</span>
                        <span class="small" style="font-family:monospace;color:#C8873A;">{{ $payment->reference }}</span>
                    </div>
                </div>

                <p class="text-muted small mb-0">This will make the house visible to the public on Terra.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success btn-sm px-4">Approve &amp; Publish</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══ DELETE MODAL ══ --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px">
        <div class="modal-content p-4 text-center">
            <div class="d-flex justify-content-center mb-3">
                <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width:56px;height:56px">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" style="width:24px;height:24px">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14H6L5 6" />
                        <path d="M10 11v6M14 11v6" />
                        <path d="M9 6V4h6v2" />
                    </svg>
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
                wrap.className = 'hd-prev-thumb';
                wrap.innerHTML = `<img src="${url}"><button class="hd-prev-rm" data-i="${i}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M18 6L6 18M6 6l12 12"/></svg></button>`;
                previews.appendChild(wrap);
            });
            if (submitBtn) {
                submitBtn.disabled = files.length === 0;
            }
            if (cntSpan) {
                cntSpan.textContent = files.length > 0 ? `(${files.length})` : '';
            }
        }

        if (input) input.addEventListener('change', e => {
            files = [...files, ...Array.from(e.target.files)];
            renderPreviews();
        });
        if (previews) previews.addEventListener('click', e => {
            const btn = e.target.closest('[data-i]');
            if (btn) {
                files.splice(+btn.dataset.i, 1);
                renderPreviews();
            }
        });
        if (clearBtn) clearBtn.addEventListener('click', () => {
            files = [];
            renderPreviews();
        });

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

        const form = document.getElementById('upload-form');
        if (form) form.addEventListener('submit', e => {
            if (files.length === 0) {
                e.preventDefault();
                return;
            }
            const dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            if (input) input.files = dt.files;
        });
    })();
</script>

@endsection