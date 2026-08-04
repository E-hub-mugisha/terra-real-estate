@extends('layouts.shop')
@section('page-title', 'Product Details')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --terra-navy: #19265d;
        --terra-navy-deep: #121b45;
        --terra-navy-light: #2a3a82;
        --terra-orange: #D05208;
        --terra-orange-light: #ea6f1f;
        --terra-bg-soft: #f5f6fb;
        --terra-ink: #1c2340;
        --terra-muted: #6b7290;
        --terra-line: #eaebf4;
    }

    [data-h-scope="product-show"] {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--terra-ink);
    }
    [data-h-scope="product-show"] h1,
    [data-h-scope="product-show"] h5,
    [data-h-scope="product-show"] .h-heading {
        font-family: 'Sora', sans-serif;
    }

    /* ---------- Page header ---------- */
    [data-h-scope="product-show"] .page-header {
        display: flex;
        align-items: center;
        gap: .85rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    [data-h-scope="product-show"] .btn-back {
        width: 38px; height: 38px; border-radius: 10px;
        border: 1px solid var(--terra-line);
        background: #fff; color: var(--terra-navy);
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    [data-h-scope="product-show"] .btn-back:hover { background: var(--terra-navy); border-color: var(--terra-navy); color: #fff; }
    [data-h-scope="product-show"] .page-eyebrow {
        text-transform: uppercase;
        letter-spacing: .1em;
        font-size: .7rem;
        font-weight: 700;
        color: var(--terra-orange);
        margin-bottom: .1rem;
    }
    [data-h-scope="product-show"] .page-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: .6rem;
        flex-wrap: wrap;
    }
    [data-h-scope="product-show"] .page-actions {
        margin-left: auto;
        display: flex;
        gap: .5rem;
    }

    [data-h-scope="product-show"] .badge-soft-success { background: rgba(30,158,99,.12); color: #157a4c; font-weight: 600; }
    [data-h-scope="product-show"] .badge-soft-warning { background: rgba(208,82,8,.12); color: #a5430a; font-weight: 600; }
    [data-h-scope="product-show"] .badge-soft-danger  { background: rgba(214,69,69,.12); color: #b93434; font-weight: 600; }
    [data-h-scope="product-show"] .badge-soft-info    { background: rgba(25,38,93,.08); color: var(--terra-navy); font-weight: 600; }
    [data-h-scope="product-show"] .badge-soft-muted   { background: #eceef5; color: var(--terra-muted); font-weight: 600; }

    [data-h-scope="product-show"] .btn-terra {
        background: var(--terra-navy); border-color: var(--terra-navy); color: #fff; font-weight: 600;
        border-radius: 10px; padding: .55rem 1.15rem; font-size: .86rem;
    }
    [data-h-scope="product-show"] .btn-terra:hover { background: var(--terra-navy-light); border-color: var(--terra-navy-light); color: #fff; }
    [data-h-scope="product-show"] .btn-terra-outline {
        background: #fff; border: 1px solid var(--terra-line); color: var(--terra-navy); font-weight: 600;
        border-radius: 10px; padding: .55rem 1.1rem; font-size: .86rem;
    }
    [data-h-scope="product-show"] .btn-terra-outline:hover { border-color: var(--terra-navy); background: var(--terra-bg-soft); }
    [data-h-scope="product-show"] .btn-terra-danger-outline {
        background: #fff; border: 1px solid rgba(214,69,69,.35); color: #c62839; font-weight: 600;
        border-radius: 10px; padding: .55rem 1.1rem; font-size: .86rem;
    }
    [data-h-scope="product-show"] .btn-terra-danger-outline:hover { background: #c62839; border-color: #c62839; color: #fff; }

    /* ---------- Rejection banner ---------- */
    [data-h-scope="product-show"] .alert-terra-danger {
        background: rgba(214,69,69,.08); border: 1px solid rgba(214,69,69,.2);
        color: #b93434; border-radius: 12px; padding: .9rem 1.1rem; font-size: .87rem;
        display: flex; align-items: flex-start; gap: .6rem; margin-bottom: 1rem;
    }
    [data-h-scope="product-show"] .alert-terra-danger i { font-size: 1.05rem; margin-top: .05rem; }
    [data-h-scope="product-show"] .alert-terra-danger strong { display: block; margin-bottom: .1rem; }

    [data-h-scope="product-show"] .alert-terra-info {
        background: rgba(25,38,93,.06); border: 1px solid rgba(25,38,93,.15); color: var(--terra-navy);
        border-radius: 12px; padding: .85rem 1.1rem; font-size: .85rem;
        display: flex; align-items: flex-start; gap: .6rem; margin-bottom: 1rem;
    }
    [data-h-scope="product-show"] .alert-terra-info i { font-size: 1.05rem; margin-top: .05rem; }

    /* ---------- Card shell ---------- */
    [data-h-scope="product-show"] .panel-card { border: none; border-radius: 16px; box-shadow: 0 2px 14px rgba(25, 38, 93, 0.07); }
    [data-h-scope="product-show"] .panel-card-body { padding: 1.5rem; }

    /* ---------- Gallery ---------- */
    [data-h-scope="product-show"] .gallery-main {
        width: 100%; height: 320px; border-radius: 14px; object-fit: cover;
        background: var(--terra-bg-soft); border: 1px solid var(--terra-line);
    }
    [data-h-scope="product-show"] .gallery-main-placeholder {
        width: 100%; height: 320px; border-radius: 14px; background: var(--terra-bg-soft);
        color: var(--terra-muted); display: flex; align-items: center; justify-content: center; font-size: 2.4rem;
        border: 1px solid var(--terra-line);
    }
    [data-h-scope="product-show"] .gallery-thumbs { display: flex; gap: .55rem; margin-top: .75rem; flex-wrap: wrap; }
    [data-h-scope="product-show"] .gallery-thumb {
        width: 62px; height: 62px; border-radius: 9px; object-fit: cover; cursor: pointer;
        border: 2px solid transparent; opacity: .75; transition: opacity .12s ease, border-color .12s ease;
    }
    [data-h-scope="product-show"] .gallery-thumb:hover { opacity: 1; }
    [data-h-scope="product-show"] .gallery-thumb.is-active { opacity: 1; border-color: var(--terra-orange); }
    [data-h-scope="product-show"] .gallery-thumb-wrap { position: relative; }
    [data-h-scope="product-show"] .gallery-primary-badge {
        position: absolute; top: -6px; right: -6px;
        background: var(--terra-orange); color: #fff; font-size: .55rem; font-weight: 700;
        padding: .1rem .32rem; border-radius: 4px; text-transform: uppercase;
    }

    /* ---------- Detail rows ---------- */
    [data-h-scope="product-show"] .section-title {
        font-family: 'Sora', sans-serif; font-weight: 700; font-size: .95rem; margin-bottom: 1rem;
    }
    [data-h-scope="product-show"] .detail-label {
        text-transform: uppercase; letter-spacing: .06em; font-size: .68rem; font-weight: 700;
        color: var(--terra-muted); margin-bottom: .3rem;
    }
    [data-h-scope="product-show"] .detail-value { font-size: .92rem; font-weight: 600; color: var(--terra-ink); }
    [data-h-scope="product-show"] .detail-value.is-muted { font-weight: 400; color: var(--terra-muted); font-style: italic; }
    [data-h-scope="product-show"] .detail-desc { font-size: .9rem; color: var(--terra-ink); line-height: 1.65; }
    [data-h-scope="product-show"] .detail-divider { border-top: 1px solid var(--terra-line); margin: 1.25rem 0; }

    /* ---------- Price panel ---------- */
    [data-h-scope="product-show"] .price-tag {
        font-family: 'Sora', sans-serif; font-weight: 800; font-size: 1.7rem; color: var(--terra-orange); line-height: 1.1;
    }
    [data-h-scope="product-show"] .price-unit { font-size: .8rem; color: var(--terra-muted); }

    /* ---------- Mini stat rows ---------- */
    [data-h-scope="product-show"] .mini-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: .65rem 0; border-bottom: 1px solid var(--terra-line); font-size: .85rem;
    }
    [data-h-scope="product-show"] .mini-row:last-child { border-bottom: none; }
    [data-h-scope="product-show"] .mini-row-label { color: var(--terra-muted); display: flex; align-items: center; gap: .45rem; }
    [data-h-scope="product-show"] .mini-row-label i { color: var(--terra-navy); }
    [data-h-scope="product-show"] .mini-row-value { font-weight: 600; color: var(--terra-ink); }

    @media (max-width: 767px) {
        [data-h-scope="product-show"] .panel-card-body { padding: 1.25rem; }
        [data-h-scope="product-show"] .page-actions { margin-left: 0; width: 100%; }
        [data-h-scope="product-show"] .page-actions .btn { flex: 1; }
    }
</style>
@endpush

@section('content')
<div data-h-scope="product-show">

    @php
        $statusBadgeClass = ['pending' => 'badge-soft-warning', 'approved' => 'badge-soft-success', 'rejected' => 'badge-soft-danger'][$product->status] ?? 'badge-soft-muted';
        $stockLabels = ['in_stock' => 'In Stock', 'out_of_stock' => 'Out of Stock', 'made_to_order' => 'Made to Order'];
        $stockBadgeClass = ['in_stock' => 'badge-soft-success', 'out_of_stock' => 'badge-soft-danger', 'made_to_order' => 'badge-soft-info'][$product->stock_status] ?? 'badge-soft-muted';
        $images = $product->images ?? collect();
        $primaryImage = $images->firstWhere('is_primary', true) ?? $images->first();
    @endphp

    <div class="page-header">
        <a href="{{ route('shop-panel.products.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="page-eyebrow">Inventory</div>
            <h1 class="page-title">
                {{ $product->title }}
                <span class="badge {{ $statusBadgeClass }}">{{ ucfirst($product->status) }}</span>
            </h1>
        </div>
        <div class="page-actions">
            <a href="{{ route('shop-panel.products.edit', $product) }}" class="btn btn-terra">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form action="{{ route('shop-panel.products.destroy', $product) }}" method="POST"
                  onsubmit="return confirm('Delete this product? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button class="btn btn-terra-danger-outline">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    @if ($product->status === 'rejected' && $product->rejection_reason)
        <div class="alert-terra-danger">
            <i class="bi bi-exclamation-circle"></i>
            <div>
                <strong>This product was rejected</strong>
                {{ $product->rejection_reason }}
            </div>
        </div>
    @elseif ($product->status === 'pending')
        <div class="alert-terra-info">
            <i class="bi bi-hourglass-split"></i>
            <span>This product is awaiting review and isn't visible to buyers yet.</span>
        </div>
    @endif

    <div class="row g-3">
        {{-- Gallery + description --}}
        <div class="col-lg-7">
            <div class="card panel-card mb-3">
                <div class="panel-card-body">
                    @if ($primaryImage)
                        <img src="{{ asset('storage/' . $primaryImage->path) }}" class="gallery-main" id="galleryMain">
                    @else
                        <div class="gallery-main-placeholder"><i class="bi bi-image"></i></div>
                    @endif

                    @if ($images->count() > 1)
                        <div class="gallery-thumbs">
                            @foreach ($images as $img)
                                <div class="gallery-thumb-wrap">
                                    <img src="{{ asset('storage/' . $img->path) }}"
                                         class="gallery-thumb {{ $img->id === optional($primaryImage)->id ? 'is-active' : '' }}"
                                         onclick="document.getElementById('galleryMain').src=this.src; document.querySelectorAll('.gallery-thumb').forEach(t=>t.classList.remove('is-active')); this.classList.add('is-active');">
                                    @if ($img->is_primary)
                                        <span class="gallery-primary-badge">★</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card panel-card">
                <div class="panel-card-body">
                    <div class="section-title">Description</div>
                    @if ($product->description)
                        <p class="detail-desc mb-0">{{ $product->description }}</p>
                    @else
                        <p class="detail-value is-muted mb-0">No description added yet.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Details sidebar --}}
        <div class="col-lg-5">
            <div class="card panel-card mb-3">
                <div class="panel-card-body">
                    <div class="price-tag">
                        {{ $product->price ? number_format($product->price) . ' ' . $product->currency : 'On request' }}
                    </div>
                    @if ($product->unit)
                        <div class="price-unit">{{ $product->unit }}</div>
                    @endif

                    <div class="detail-divider"></div>

                    <div class="mini-row">
                        <div class="mini-row-label"><i class="bi bi-tag"></i> Category</div>
                        <div class="mini-row-value">{{ $product->category->name ?? '—' }}</div>
                    </div>
                    @if (!empty($product->subcategory))
                        <div class="mini-row">
                            <div class="mini-row-label"><i class="bi bi-tags"></i> Subcategory</div>
                            <div class="mini-row-value">{{ $product->subcategory->name }}</div>
                        </div>
                    @endif
                    <div class="mini-row">
                        <div class="mini-row-label"><i class="bi bi-box-seam"></i> Stock</div>
                        <span class="badge {{ $stockBadgeClass }}">{{ $stockLabels[$product->stock_status] ?? $product->stock_status }}</span>
                    </div>
                    <div class="mini-row">
                        <div class="mini-row-label"><i class="bi bi-stack"></i> Min. Order Qty</div>
                        <div class="mini-row-value">{{ $product->min_order_quantity ?? 1 }}</div>
                    </div>
                    <div class="mini-row">
                        <div class="mini-row-label"><i class="bi bi-calendar-plus"></i> Listed on</div>
                        <div class="mini-row-value">{{ $product->created_at?->format('M d, Y') ?? '—' }}</div>
                    </div>
                    <div class="mini-row">
                        <div class="mini-row-label"><i class="bi bi-arrow-repeat"></i> Last updated</div>
                        <div class="mini-row-value">{{ $product->updated_at?->format('M d, Y') ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
