@extends('layouts.guest')
@section('title', $material->title . ' - Construction Materials & Equipment')
@section('content')

<div class="container py-4 material-page">

    <nav class="small mb-3 breadcrumb-nav">
        <a href="{{ route('front.home') }}" class="text-decoration-none">Home</a>
        <span class="mx-1">/</span>
        <a href="{{ route('front.materials.category', $category->slug) }}" class="text-decoration-none">
            {{ $category->name }}
        </a>
        <span class="mx-1">/</span>
        <span class="fw-medium current-crumb">{{ $material->title }}</span>
    </nav>

    <div class="row g-4">

        {{-- Images --}}
        <div class="col-lg-7">
            @if ($material->images->isNotEmpty())
            <div x-data="{ active: 0 }">
                <div class="ratio ratio-16x9 rounded-3 overflow-hidden bg-light mb-3 gallery-main">
                    <template x-for="(img, i) in {{ $material->images->pluck('image_path')->toJson() }}" :key="i">
                        <img x-show="active === i" :src="'{{ asset('storage') }}/' + img"
                            alt="{{ $material->title }}" class="w-100 h-100" style="object-fit: cover;">
                    </template>
                </div>

                @if ($material->images->count() > 1)
                <div class="d-flex gap-2 flex-wrap">
                    @foreach ($material->images as $i => $img)
                    <button @click="active = {{ $i }}" type="button"
                        class="p-0 border rounded-2 overflow-hidden thumb-btn"
                        style="width:64px;height:64px;"
                        :class="active === {{ $i }} ? 'thumb-active' : 'thumb-inactive'">
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-100 h-100" style="object-fit: cover;">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div class="ratio ratio-16x9 rounded-3 bg-light d-flex align-items-center justify-content-center text-muted gallery-main">
                No image available
            </div>
            @endif

            @if ($material->description)
            <div class="mt-4 description-block">
                <h2 class="fs-6 fw-semibold mb-2 section-label">Description</h2>
                <p class="text-muted small mb-0" style="line-height: 1.7;">{{ $material->description }}</p>
            </div>
            @endif
        </div>

        {{-- Details & inquiry --}}
        <div class="col-lg-5">
            <div class="detail-card sticky-top" style="top: 6rem;">

                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                    @if ($material->is_featured)
                    <span class="badge featured-badge px-2 py-1 d-inline-flex align-items-center gap-1">
                        <svg viewBox="0 0 24 24" fill="currentColor" style="width:12px;height:12px">
                            <path d="M12 2l2.9 6.6 7.1.6-5.4 4.7 1.7 7-6.3-3.8L5.7 21l1.7-7-5.4-4.7 7.1-.6z"/>
                        </svg>
                        Featured
                    </span>
                    @endif

                    @if ($material->category)
                    <span class="badge category-badge px-2 py-1">
                        {{ $material->category->name }}
                    </span>
                    @endif

                    @if ($material->subcategory)
                    <span class="badge subcategory-badge px-2 py-1">
                        {{ $material->subcategory->name }}
                    </span>
                    @endif
                </div>

                <h1 class="fs-4 fw-bold mt-1 mb-1 material-title">{{ $material->title }}</h1>

                <div class="fs-3 fw-bold price-tag mb-1">
                    @if ($material->price)
                    {{ $material->currency }} {{ number_format($material->price) }}
                    @if ($material->unit)
                    <span class="fs-6 fw-normal text-muted">/ {{ $material->unit }}</span>
                    @endif
                    @else
                    <span class="fs-5">Price on request</span>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                    <span @class([ 'badge fw-medium px-2 py-1 stock-badge' , 'stock-in'=> $material->stock_status === 'in_stock',
                        'stock-out' => $material->stock_status === 'out_of_stock',
                        'stock-made' => $material->stock_status === 'made_to_order',
                        ])>
                        {{ str_replace('_', ' ', ucfirst($material->stock_status)) }}
                    </span>

                    @if ($material->min_order_quantity)
                    <span class="small text-muted">
                        Min. order: {{ $material->min_order_quantity }} {{ Str::plural('unit', $material->min_order_quantity) }}
                    </span>
                    @endif
                </div>

                <hr class="my-3 divider">

                {{-- Shop info --}}
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle bg-light overflow-hidden flex-shrink-0 shop-avatar" style="width:48px;height:48px;">
                        @if ($material->shop->logo)
                        <img src="{{ asset('storage/' . $material->shop->logo) }}" class="w-100 h-100" style="object-fit: cover;">
                        @endif
                    </div>
                    <div class="min-w-0">
                        <div class="fw-medium small text-truncate shop-name">{{ $material->shop->name }}</div>
                        <div class="text-muted" style="font-size:.75rem;">
                            {{ $material->shop->district }}{{ $material->shop->district && $material->shop->province ? ', ' : '' }}{{ $material->shop->province }}
                        </div>
                    </div>
                </div>

                {{-- WhatsApp inquiry --}}
                <a href="{{ $material->whatsappLink() }}"
                    target="_blank" rel="noopener"
                    class="btn d-flex align-items-center justify-content-center gap-2 w-100 text-white fw-semibold py-2 whatsapp-btn">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px">
                        <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39c1.45.79 3.08 1.21 4.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.15h-.01c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.14.82.84-3.06-.2-.32a8.19 8.19 0 0 1-1.25-4.35c0-4.52 3.68-8.2 8.2-8.2 2.19 0 4.25.86 5.8 2.4a8.14 8.14 0 0 1 2.4 5.8c0 4.53-3.68 8.24-8.14 8.24zm4.49-6.15c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.24-.64.8-.78.97-.14.17-.29.19-.53.06-.25-.12-1.04-.38-1.99-1.22-.73-.65-1.23-1.46-1.37-1.7-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.15.16-.25.24-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.42-.14-.01-.31-.01-.48-.01a.92.92 0 0 0-.67.31c-.23.25-.87.85-.87 2.08 0 1.22.89 2.4 1.02 2.57.12.17 1.75 2.67 4.24 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.11-.23-.17-.48-.29z" />
                    </svg>
                    Inquire via WhatsApp
                </a>

                @if ($material->shop->phone)
                <a href="tel:{{ $material->shop->phone }}"
                    class="btn call-btn d-flex align-items-center justify-content-center gap-2 w-100 mt-2 fw-medium py-2">
                    Call Shop
                </a>
                @endif

                <p class="text-muted mt-3 mb-0 text-center" style="font-size:.75rem;">
                    {{ $material->views_count }} views
                </p>
            </div>
        </div>
    </div>

    {{-- Related products --}}
    @if ($related->isNotEmpty())
    <div class="mt-5">
        <h2 class="fs-5 fw-bold mb-3 section-heading">More in {{ $category->name }}</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            @foreach ($related as $item)
            @php($img = $item->primaryImage())
            <div class="col">
                <div class="card h-100 material-card position-relative">

                    @if ($item->is_featured)
                    <span class="badge related-featured-badge position-absolute">Featured</span>
                    @endif

                    <a href="{{ route('front.materials.show', [$category->slug, $item->slug]) }}"
                        class="text-decoration-none">
                        <div class="ratio ratio-16x9 bg-light">
                            @if ($img)
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                            <div class="d-flex align-items-center justify-content-center text-muted small">No image</div>
                            @endif
                        </div>
                    </a>

                    <div class="card-body p-3 d-flex flex-column">
                        @if ($item->subcategory)
                        <span class="related-subcat mb-1">{{ $item->subcategory->name }}</span>
                        @endif

                        <a href="{{ route('front.materials.show', [$category->slug, $item->slug]) }}" class="text-decoration-none">
                            <h3 class="card-title fs-6 fw-medium text-truncate mb-1 related-title">{{ $item->title }}</h3>
                        </a>

                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-semibold small related-price">
                                {{ $item->price ? $item->currency . ' ' . number_format($item->price) : 'Price on request' }}
                            </span>
                            <span @class([ 'related-stock-dot' , 'stock-in'=> $item->stock_status === 'in_stock',
                                'stock-out' => $item->stock_status === 'out_of_stock',
                                'stock-made' => $item->stock_status === 'made_to_order',
                                ])
                                title="{{ str_replace('_', ' ', ucfirst($item->stock_status)) }}"></span>
                        </div>

                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('front.materials.show', [$category->slug, $item->slug]) }}"
                                class="btn related-view-btn flex-grow-1 fw-medium">
                                View Details
                            </a>
                            <a href="{{ $item->whatsappLink() }}" target="_blank" rel="noopener"
                                class="btn related-whatsapp-btn d-flex align-items-center justify-content-center"
                                title="Inquire via WhatsApp">
                                <svg viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px">
                                    <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.29-1.39c1.45.79 3.08 1.21 4.75 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.5 2 12.04 2zm0 18.15h-.01c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.14.82.84-3.06-.2-.32a8.19 8.19 0 0 1-1.25-4.35c0-4.52 3.68-8.2 8.2-8.2 2.19 0 4.25.86 5.8 2.4a8.14 8.14 0 0 1 2.4 5.8c0 4.53-3.68 8.24-8.14 8.24zm4.49-6.15c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.24-.64.8-.78.97-.14.17-.29.19-.53.06-.25-.12-1.04-.38-1.99-1.22-.73-.65-1.23-1.46-1.37-1.7-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.15.16-.25.24-.42.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.42-.14-.01-.31-.01-.48-.01a.92.92 0 0 0-.67.31c-.23.25-.87.85-.87 2.08 0 1.22.89 2.4 1.02 2.57.12.17 1.75 2.67 4.24 3.74.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.11-.23-.17-.48-.29z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<style>
    :root {
        --navy-dark: #111a45;
        --navy: #19265d;
        --gold: #D05208;
        --gold-light: #fff3e9;
        --font-heading: 'Cormorant Garamond', serif;
        --font-body: 'DM Sans', sans-serif;
    }

    .material-page {
        font-family: var(--font-body);
        color: var(--navy-dark);
    }

    /* Breadcrumb */
    .breadcrumb-nav a {
        color: #6b7280;
        transition: color .15s ease;
    }

    .breadcrumb-nav a:hover {
        color: var(--gold);
    }

    .current-crumb {
        color: var(--navy-dark);
    }

    /* Gallery */
    .gallery-main {
        box-shadow: 0 4px 16px rgba(17, 26, 69, .08);
    }

    .thumb-btn {
        background: none;
        cursor: pointer;
        transition: border-color .15s ease, opacity .15s ease;
    }

    .thumb-active {
        border-color: var(--gold) !important;
        border-width: 2px !important;
        opacity: 1;
    }

    .thumb-inactive {
        border-color: transparent !important;
        opacity: .65;
    }

    .thumb-inactive:hover {
        opacity: 1;
    }

    /* Description */
    .section-label {
        font-family: var(--font-heading);
        font-size: 1.15rem !important;
        color: var(--navy);
        letter-spacing: .01em;
    }

    /* Detail card */
    .detail-card {
        background: #fff;
        border: 1px solid #eef0f5;
        border-radius: 14px;
        padding: 1.75rem;
        box-shadow: 0 6px 24px rgba(17, 26, 69, .08);
        display: flex;
        flex-direction: column;
    }

    .subcategory-badge {
        background-color: var(--gold-light);
        color: var(--gold);
        font-weight: 600;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-radius: 20px;
    }

    .category-badge {
        background-color: #eef2ff;
        color: var(--navy);
        font-weight: 600;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-radius: 20px;
    }

    .featured-badge {
        background-color: var(--navy-dark);
        color: #fff;
        font-weight: 600;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-radius: 20px;
    }

    .material-title {
        font-family: var(--font-heading);
        color: var(--navy-dark);
        font-size: 1.9rem !important;
        line-height: 1.2;
    }

    .price-tag {
        color: var(--gold);
        font-family: var(--font-heading);
    }

    .stock-badge {
        border-radius: 20px;
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .stock-in {
        background-color: #ecfdf3;
        color: #15803d;
    }

    .stock-out {
        background-color: #fef2f2;
        color: #b91c1c;
    }

    .stock-made {
        background-color: #eef2ff;
        color: var(--navy);
    }

    .divider {
        border-color: #eef0f5;
        opacity: 1;
    }

    .shop-avatar {
        border: 1px solid #eef0f5;
    }

    .shop-name {
        color: var(--navy-dark);
    }

    /* Buttons */
    .whatsapp-btn {
        background-color: #25D366;
        border: none;
        border-radius: 10px;
        transition: background-color .15s ease, transform .1s ease;
    }

    .whatsapp-btn:hover {
        background-color: #1ebc59;
        color: #fff;
        transform: translateY(-1px);
    }

    .call-btn {
        background-color: #fff;
        color: var(--navy);
        border: 1px solid var(--navy);
        border-radius: 10px;
        transition: background-color .15s ease, color .15s ease;
    }

    .call-btn:hover {
        background-color: var(--navy);
        color: #fff;
    }

    /* Related products */
    .section-heading {
        font-family: var(--font-heading);
        color: var(--navy-dark);
        font-size: 1.6rem !important;
    }

    .material-card {
        border: 1px solid #eef0f5;
        border-radius: 12px;
        overflow: hidden;
        transition: box-shadow .2s ease, transform .2s ease;
        color: inherit;
    }

    .material-card:hover {
        box-shadow: 0 .75rem 1.75rem rgba(17, 26, 69, .12);
        transform: translateY(-3px);
        color: inherit;
    }

    .related-title {
        color: var(--navy-dark);
    }

    .related-price {
        color: var(--gold);
    }

    .related-featured-badge {
        top: .6rem;
        left: .6rem;
        background-color: var(--navy-dark);
        color: #fff;
        font-size: .65rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03em;
        border-radius: 20px;
        padding: .3rem .6rem;
        z-index: 2;
    }

    .related-subcat {
        display: block;
        font-size: .68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--gold);
    }

    .related-stock-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    .related-stock-dot.stock-in {
        background-color: #22c55e;
    }

    .related-stock-dot.stock-out {
        background-color: #ef4444;
    }

    .related-stock-dot.stock-made {
        background-color: var(--navy);
    }

    .related-view-btn {
        background-color: var(--gold-light);
        color: var(--gold);
        border: none;
        border-radius: 8px;
        font-size: .78rem;
        padding: .45rem .5rem;
        transition: background-color .15s ease, color .15s ease;
    }

    .related-view-btn:hover {
        background-color: var(--gold);
        color: #fff;
    }

    .related-whatsapp-btn {
        background-color: #eafaf0;
        color: #1ebc59;
        border: none;
        border-radius: 8px;
        width: 38px;
        flex-shrink: 0;
        transition: background-color .15s ease, color .15s ease;
    }

    .related-whatsapp-btn:hover {
        background-color: #25D366;
        color: #fff;
    }
</style>

@once
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@endonce

@endsection