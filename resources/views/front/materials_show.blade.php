@extends('layouts.app')

@section('title', $material->title . ' – Construction Materials – Terra Real Estate')
@section('meta_description', Str::limit($material->description, 160))

@section('content')

@php
$categories = [
    'cement'       => 'Cement',
    'iron_sheets'  => 'Iron Sheets',
    'bricks'       => 'Bricks & Blocks',
    'tiles'        => 'Tiles & Flooring',
    'timber'       => 'Timber & Wood',
    'paint'        => 'Paint & Finishes',
    'plumbing'     => 'Plumbing',
    'electrical'   => 'Electrical',
    'glass'        => 'Glass & Aluminum',
    'sand_gravel'  => 'Sand & Gravel',
];
$catIcons = [
    'cement'=>'🧱','iron_sheets'=>'🔩','bricks'=>'🏛️','tiles'=>'⬛',
    'timber'=>'🪵','paint'=>'🎨','plumbing'=>'🚿','electrical'=>'⚡',
    'glass'=>'🪟','sand_gravel'=>'⛏️',
];
$catLabel = $categories[$material->category] ?? ucfirst($material->category);
$icon = $catIcons[$material->category] ?? '📦';
$allImages = array_filter(array_merge(
    $material->thumbnail ? [$material->thumbnail] : [],
    $material->images ?? []
));
@endphp

<style>
    :root {
        --terra-primary:    #2c6e49;
        --terra-primary-dk: #1e4d34;
        --terra-accent:     #f0a500;
        --terra-text:       #1a1a2e;
        --terra-muted:      #6b7280;
        --terra-border:     #e5e7eb;
        --terra-bg:         #f9fafb;
        --terra-white:      #ffffff;
        --terra-radius:     10px;
        --terra-shadow:     0 2px 12px rgba(0,0,0,.07);
        --terra-shadow-lg:  0 8px 32px rgba(0,0,0,.12);
    }

    /* ─── Breadcrumb ──────────────────────────────────────── */
    .show-breadcrumb {
        padding: 14px 0; font-size: 13px; color: var(--terra-muted);
        border-bottom: 1px solid var(--terra-border);
    }
    .show-breadcrumb a { color: var(--terra-primary); text-decoration: none; }
    .show-breadcrumb a:hover { text-decoration: underline; }

    /* ─── Two-column layout ───────────────────────────────── */
    .show-layout {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 32px;
        padding: 28px 0 60px;
        align-items: start;
    }
    @media (max-width: 920px) {
        .show-layout { grid-template-columns: 1fr; }
    }

    /* ─── Gallery ─────────────────────────────────────────── */
    .gallery-main {
        width: 100%; aspect-ratio: 16/10; border-radius: var(--terra-radius);
        overflow: hidden; position: relative; background: #f0faf5;
        cursor: pointer;
    }
    .gallery-main img {
        width: 100%; height: 100%; object-fit: cover; display: block;
        transition: transform .4s ease;
    }
    .gallery-main:hover img { transform: scale(1.02); }
    .gallery-main .no-img {
        width: 100%; height: 100%; display: flex; flex-direction: column;
        align-items: center; justify-content: center; font-size: 64px; gap: 10px;
        color: var(--terra-primary);
    }
    .gallery-main .no-img span { font-size: 16px; color: var(--terra-muted); }
    .gallery-main .photo-count {
        position: absolute; bottom: 14px; right: 14px;
        background: rgba(0,0,0,.55); color: #fff; border-radius: 6px;
        padding: 5px 12px; font-size: 13px; font-weight: 600;
        backdrop-filter: blur(4px);
    }
    .gallery-thumbs {
        display: flex; gap: 10px; margin-top: 10px; overflow-x: auto;
        padding-bottom: 4px;
    }
    .gallery-thumbs::-webkit-scrollbar { height: 4px; }
    .gallery-thumbs::-webkit-scrollbar-track { background: transparent; }
    .gallery-thumbs::-webkit-scrollbar-thumb { background: var(--terra-border); border-radius: 4px; }
    .gallery-thumb {
        flex-shrink: 0; width: 80px; height: 60px; border-radius: 6px;
        overflow: hidden; border: 2px solid transparent; cursor: pointer;
        transition: border-color .2s;
    }
    .gallery-thumb.active { border-color: var(--terra-primary); }
    .gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* ─── Detail Body ─────────────────────────────────────── */
    .detail-header { margin: 20px 0 6px; }
    .detail-cat-badge {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--terra-primary);
        background: #f0faf5; padding: 4px 12px; border-radius: 999px;
        margin-bottom: 10px;
    }
    .detail-title {
        font-size: clamp(1.25rem, 2.5vw, 1.75rem); font-weight: 700;
        color: var(--terra-text); margin: 0 0 8px; line-height: 1.3;
    }
    .detail-meta-row {
        display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
        font-size: 13px; color: var(--terra-muted); margin-bottom: 6px;
    }
    .detail-meta-row span { display: flex; align-items: center; gap: 4px; }
    .detail-status {
        padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 700;
    }
    .status-available   { background: #d1fae5; color: #065f46; }
    .status-out_of_stock { background: #fee2e2; color: #991b1b; }
    .status-discontinued { background: #f3f4f6; color: #6b7280; }

    .detail-price-block {
        background: #f0faf5; border: 1px solid #c3e6d3;
        border-radius: var(--terra-radius); padding: 18px 20px;
        margin: 20px 0; display: flex; align-items: baseline; gap: 10px;
        flex-wrap: wrap;
    }
    .detail-price { font-size: 2rem; font-weight: 800; color: var(--terra-primary); }
    .detail-price-unit { font-size: 14px; color: var(--terra-muted); }

    .detail-section { margin: 24px 0; }
    .detail-section-title {
        font-size: 13px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--terra-muted);
        margin-bottom: 12px; padding-bottom: 8px;
        border-bottom: 1px solid var(--terra-border);
    }
    .detail-description {
        font-size: 15px; line-height: 1.7; color: #374151;
    }
    .detail-description.collapsed {
        max-height: 120px; overflow: hidden;
        -webkit-mask-image: linear-gradient(180deg, #000 60%, transparent);
        mask-image: linear-gradient(180deg, #000 60%, transparent);
    }
    .read-more-btn {
        background: none; border: none; color: var(--terra-primary);
        font-size: 14px; font-weight: 600; cursor: pointer;
        padding: 6px 0; display: block; margin-top: 6px;
    }

    .specs-table { width: 100%; border-collapse: collapse; }
    .specs-table tr:nth-child(even) td { background: var(--terra-bg); }
    .specs-table td {
        padding: 10px 14px; font-size: 14px; border-bottom: 1px solid var(--terra-border);
    }
    .specs-table td:first-child { color: var(--terra-muted); font-weight: 500; width: 40%; }
    .specs-table td:last-child { color: var(--terra-text); font-weight: 600; }

    /* ─── Sidebar Sticky Card ─────────────────────────────── */
    .contact-card {
        background: #fff; border: 1px solid var(--terra-border);
        border-radius: var(--terra-radius); box-shadow: var(--terra-shadow-lg);
        overflow: hidden; position: sticky; top: 20px;
    }
    .contact-card-head {
        background: linear-gradient(135deg, var(--terra-primary), var(--terra-primary-dk));
        padding: 20px; color: #fff;
    }
    .contact-card-price { font-size: 1.8rem; font-weight: 800; }
    .contact-card-unit { font-size: 13px; opacity: .8; }
    .contact-card-status {
        display: inline-block; margin-top: 8px;
        padding: 3px 12px; border-radius: 999px; font-size: 12px;
        font-weight: 700; background: rgba(255,255,255,.2); color: #fff;
    }
    .contact-card-body { padding: 20px; }
    .supplier-info { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
    .supplier-avatar {
        width: 44px; height: 44px; border-radius: 50%; background: #f0faf5;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px; color: var(--terra-primary); font-weight: 700;
        flex-shrink: 0;
    }
    .supplier-name { font-size: 14px; font-weight: 600; color: var(--terra-text); }
    .supplier-label { font-size: 12px; color: var(--terra-muted); }
    .contact-divider { border: none; border-top: 1px solid var(--terra-border); margin: 0 0 16px; }
    .contact-btn {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 12px; border-radius: 7px; font-size: 14px;
        font-weight: 600; text-decoration: none; text-align: center;
        transition: all .2s; margin-bottom: 10px; cursor: pointer; border: none;
    }
    .btn-primary-green {
        background: var(--terra-primary); color: #fff;
    }
    .btn-primary-green:hover { background: var(--terra-primary-dk); color: #fff; }
    .btn-whatsapp { background: #25d366; color: #fff; }
    .btn-whatsapp:hover { background: #1ebe5e; color: #fff; }
    .btn-outline {
        background: #fff; color: var(--terra-primary);
        border: 1.5px solid var(--terra-primary);
    }
    .btn-outline:hover { background: #f0faf5; }
    .contact-hours {
        text-align: center; font-size: 12px; color: var(--terra-muted); margin-top: 14px;
    }

    /* ─── Inquiry Modal ───────────────────────────────────── */
    .inquiry-modal .modal-header {
        border-bottom: 1px solid var(--terra-border); padding: 18px 20px;
    }
    .inquiry-modal .modal-title { font-size: 17px; font-weight: 700; }
    .inquiry-modal .form-label { font-size: 13px; font-weight: 600; color: var(--terra-text); }
    .inquiry-modal .form-control {
        border-radius: 7px; border-color: var(--terra-border); font-size: 14px;
    }
    .inquiry-modal .form-control:focus {
        border-color: var(--terra-primary); box-shadow: 0 0 0 3px rgba(44,110,73,.12);
    }
    .inquiry-modal .btn-send {
        background: var(--terra-primary); color: #fff; border: none;
        border-radius: 7px; font-size: 14px; font-weight: 600;
        padding: 11px 24px; width: 100%; transition: background .2s;
    }
    .inquiry-modal .btn-send:hover { background: var(--terra-primary-dk); }

    /* ─── Related Cards ───────────────────────────────────── */
    .related-section { padding: 40px 0 60px; border-top: 1px solid var(--terra-border); }
    .related-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px;
    }
    .related-header h2 { font-size: 20px; font-weight: 700; color: var(--terra-text); }
    .related-header a { font-size: 13px; color: var(--terra-primary); text-decoration: none; font-weight: 600; }
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 16px;
    }
    .rel-card {
        background: #fff; border: 1px solid var(--terra-border);
        border-radius: var(--terra-radius); overflow: hidden;
        text-decoration: none; color: inherit; display: flex; flex-direction: column;
        transition: transform .2s, box-shadow .2s; box-shadow: var(--terra-shadow);
    }
    .rel-card:hover { transform: translateY(-3px); box-shadow: var(--terra-shadow-lg); }
    .rel-card-img {
        width: 100%; height: 140px; object-fit: cover; background: #f0faf5;
    }
    .rel-card-placeholder {
        width: 100%; height: 140px; display: flex; align-items: center;
        justify-content: center; font-size: 32px; background: #f0faf5;
        color: var(--terra-primary);
    }
    .rel-card-body { padding: 14px; }
    .rel-card-title { font-size: 14px; font-weight: 600; margin-bottom: 4px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .rel-card-price { font-size: 15px; font-weight: 700; color: var(--terra-primary); }
    .rel-card-loc { font-size: 12px; color: var(--terra-muted); margin-top: 4px; }
</style>

{{-- ══ BREADCRUMB ═════════════════════════════════════════════ --}}
<div class="show-breadcrumb">
    <div class="container">
        <a href="{{ url('/') }}">Home</a> ›
        <a href="{{ route('materials.index') }}">Construction Materials</a> ›
        <a href="{{ route('materials.index', ['category' => $material->category]) }}">{{ $catLabel }}</a> ›
        <span>{{ $material->title }}</span>
    </div>
</div>

<div class="container">
    <div class="show-layout">

        {{-- ── LEFT COLUMN ──────────────────────────────────── --}}
        <div>

            {{-- Gallery --}}
            <div class="gallery-main" id="mainGallery" onclick="openLightbox(0)">
                @if(count($allImages))
                    <img src="{{ asset('storage/' . $allImages[0]) }}"
                         alt="{{ $material->title }}" id="mainImg">
                    @if(count($allImages) > 1)
                        <span class="photo-count">📷 {{ count($allImages) }} photos</span>
                    @endif
                @else
                    <div class="no-img">
                        {{ $icon }}
                        <span>No photos yet</span>
                    </div>
                @endif
            </div>

            @if(count($allImages) > 1)
            <div class="gallery-thumbs">
                @foreach($allImages as $i => $img)
                <div class="gallery-thumb {{ $i === 0 ? 'active' : '' }}"
                     onclick="switchImg({{ $i }}, '{{ asset('storage/'.$img) }}', this)">
                    <img src="{{ asset('storage/'.$img) }}" alt="{{ $material->title }} {{ $i+1 }}">
                </div>
                @endforeach
            </div>
            @endif

            {{-- Title & badges --}}
            <div class="detail-header">
                <span class="detail-cat-badge">{{ $icon }} {{ $catLabel }}</span>
                <h1 class="detail-title">{{ $material->title }}</h1>
                <div class="detail-meta-row">
                    <span>📍 {{ $material->location }}</span>
                    @if($material->brand)
                        <span>🏷️ {{ $material->brand }}</span>
                    @endif
                    <span>📅 {{ $material->created_at->diffForHumans() }}</span>
                    <span class="detail-status status-{{ $material->status }}">
                        {{ ucfirst(str_replace('_',' ',$material->status)) }}
                    </span>
                </div>
            </div>

            {{-- Price block --}}
            <div class="detail-price-block">
                <div class="detail-price">RWF {{ number_format($material->price) }}</div>
                <div class="detail-price-unit">/ {{ $material->price_unit }}</div>
            </div>

            {{-- Description --}}
            @if($material->description)
            <div class="detail-section">
                <div class="detail-section-title">About this product</div>
                <div class="detail-description collapsed" id="descBlock">
                    {!! nl2br(e($material->description)) !!}
                </div>
                <button class="read-more-btn" id="readMoreBtn" onclick="toggleDesc()">
                    Read more ↓
                </button>
            </div>
            @endif

            {{-- Specs table --}}
            <div class="detail-section">
                <div class="detail-section-title">Product Details</div>
                <table class="specs-table">
                    <tr>
                        <td>Category</td>
                        <td>{{ $catLabel }}</td>
                    </tr>
                    @if($material->brand)
                    <tr>
                        <td>Brand</td>
                        <td>{{ $material->brand }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Price</td>
                        <td>RWF {{ number_format($material->price) }} / {{ $material->price_unit }}</td>
                    </tr>
                    @if($material->stock_quantity)
                    <tr>
                        <td>Stock</td>
                        <td>{{ number_format($material->stock_quantity) }} units available</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Location</td>
                        <td>{{ $material->location }}, Rwanda</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>{{ ucfirst(str_replace('_',' ',$material->status)) }}</td>
                    </tr>
                    <tr>
                        <td>Listed</td>
                        <td>{{ $material->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>

        </div>

        {{-- ── RIGHT COLUMN (STICKY CONTACT CARD) ──────────── --}}
        <aside>
            <div class="contact-card">
                <div class="contact-card-head">
                    <div class="contact-card-price">RWF {{ number_format($material->price) }}</div>
                    <div class="contact-card-unit">{{ $material->price_unit }}</div>
                    <span class="contact-card-status">
                        {{ ucfirst(str_replace('_',' ',$material->status)) }}
                    </span>
                </div>

                <div class="contact-card-body">
                    {{-- Supplier --}}
                    <div class="supplier-info">
                        <div class="supplier-avatar">
                            {{ strtoupper(substr($material->supplier->name ?? 'S', 0, 1)) }}
                        </div>
                        <div>
                            <div class="supplier-name">{{ $material->supplier->name ?? 'Verified Supplier' }}</div>
                            <div class="supplier-label">Material Supplier · Terra Verified</div>
                        </div>
                    </div>
                    <hr class="contact-divider">

                    {{-- Contact buttons --}}
                    @if($material->contact_phone)
                    <a href="tel:{{ $material->contact_phone }}" class="contact-btn btn-primary-green">
                        📞 Call Supplier
                    </a>
                    @endif

                    @if($material->contact_whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$material->contact_whatsapp) }}?text=Hi%2C+I+found+your+listing+on+Terra+Real+Estate+and+I%27m+interested+in+{{ urlencode($material->title) }}."
                       class="contact-btn btn-whatsapp" target="_blank" rel="noopener">
                        💬 WhatsApp
                    </a>
                    @endif

                    <button class="contact-btn btn-outline"
                            data-bs-toggle="modal" data-bs-target="#inquiryModal">
                        ✉️ Send Inquiry
                    </button>

                    <div class="contact-hours">
                        <svg width="12" height="12" viewBox="0 0 20 20" fill="none" style="margin-right:3px;">
                            <circle cx="10" cy="10" r="8.5" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M10 6v4.5l3 1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Mon–Fri, 9 AM – 6 PM
                    </div>
                </div>
            </div>
        </aside>

    </div>
</div>

{{-- ══ RELATED MATERIALS ══════════════════════════════════════ --}}
@if($related->count())
<div class="related-section">
    <div class="container">
        <div class="related-header">
            <h2>Similar {{ $catLabel }}</h2>
            <a href="{{ route('materials.index', ['category' => $material->category]) }}">See all →</a>
        </div>
        <div class="related-grid">
            @foreach($related as $rel)
            @php $rIcon = $catIcons[$rel->category] ?? '📦'; @endphp
            <a href="{{ route('materials.show', $rel->slug) }}" class="rel-card">
                @if($rel->thumbnail)
                    <img src="{{ asset('storage/'.$rel->thumbnail) }}"
                         alt="{{ $rel->title }}" class="rel-card-img" loading="lazy">
                @else
                    <div class="rel-card-placeholder">{{ $rIcon }}</div>
                @endif
                <div class="rel-card-body">
                    <div class="rel-card-title">{{ $rel->title }}</div>
                    <div class="rel-card-price">RWF {{ number_format($rel->price) }} <span style="font-size:11px;font-weight:400;color:var(--terra-muted)">/ {{ $rel->price_unit }}</span></div>
                    <div class="rel-card-loc">📍 {{ $rel->location }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ══ INQUIRY MODAL ══════════════════════════════════════════ --}}
<div class="modal fade inquiry-modal" id="inquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Inquiry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <p style="font-size:14px;color:var(--terra-muted);margin-bottom:20px;">
                    Interested in <strong>{{ $material->title }}</strong>? Send a message directly to the supplier.
                </p>
                <form action="{{ route('materials.inquiry', $material->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="material_id" value="{{ $material->id }}">
                    <div class="mb-3">
                        <label class="form-label">Your Name *</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ auth()->user()->name ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ auth()->user()->email ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone (optional)</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+250 7xx xxx xxx">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Message *</label>
                        <textarea name="message" class="form-control" rows="4" required>Hi, I found your listing on Terra Real Estate and I'm interested in {{ $material->title }}. Please contact me with more details.</textarea>
                    </div>
                    <button type="submit" class="btn-send">Send Inquiry →</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ══ SCRIPTS ════════════════════════════════════════════════ --}}
<script>
// Thumbnail switcher
function switchImg(idx, src, el) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

// Read more toggle
function toggleDesc() {
    const block = document.getElementById('descBlock');
    const btn   = document.getElementById('readMoreBtn');
    if (block.classList.contains('collapsed')) {
        block.classList.remove('collapsed');
        btn.textContent = 'Read less ↑';
    } else {
        block.classList.add('collapsed');
        btn.textContent = 'Read more ↓';
    }
}

// Auto-hide read-more if content is short
document.addEventListener('DOMContentLoaded', function () {
    const block = document.getElementById('descBlock');
    const btn   = document.getElementById('readMoreBtn');
    if (block && block.scrollHeight <= 130) {
        block.classList.remove('collapsed');
        if (btn) btn.style.display = 'none';
    }
});
</script>

@endsection
