@extends('layouts.guest')
@section('title', $category->name . ' - Construction Materials & Equipment')
@section('content')
<div class="container py-4 material-page">

    <nav class="small mb-3 breadcrumb-nav">
        <a href="{{ route('front.home') }}" class="text-decoration-none">Home</a>
        <span class="mx-1">/</span>
        <span>Construction Materials & Equipment</span>
        <span class="mx-1">/</span>
        <span class="fw-medium current-crumb">{{ $category->name }}</span>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-0 category-title">{{ $category->name }}</h1>
            <p class="text-muted small mt-1 mb-0">{{ $materials->total() }} {{ Str::plural('material', $materials->total()) }} found</p>
        </div>

        <form method="GET" class="d-flex gap-2 flex-wrap filter-form">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search in {{ $category->name }}"
                class="form-control form-control-sm search-input" style="width: 220px;">

            @if (request('subcategory'))
            <input type="hidden" name="subcategory" value="{{ request('subcategory') }}">
            @endif

            <select name="sort" onchange="this.form.submit()" class="form-select form-select-sm sort-select" style="width: auto;">
                <option value="">Newest</option>
                <option value="price_asc" @selected(request('sort')==='price_asc' )>Price: Low to High</option>
                <option value="price_desc" @selected(request('sort')==='price_desc' )>Price: High to Low</option>
            </select>

            <button class="btn btn-sm text-white fw-medium filter-btn">Filter</button>
        </form>
    </div>

    <div class="row g-4">

        {{-- Subcategory sidebar --}}
        <aside class="col-md-3">
            <h2 class="fw-semibold small mb-3 sidebar-label">Subcategories</h2>
            <ul class="list-unstyled d-flex flex-column gap-1">
                <li>
                    <a href="{{ route('front.materials.category', $category->slug) }}"
                        class="d-block px-3 py-2 rounded small text-decoration-none sub-link {{ !request('subcategory') ? 'sub-link-active' : '' }}">
                        All {{ $category->name }}
                    </a>
                </li>
                @foreach ($subcategories as $sub)
                <li>
                    <a href="{{ route('front.materials.category', ['category' => $category->slug, 'subcategory' => $sub->slug]) }}"
                        class="d-block px-3 py-2 rounded small text-decoration-none sub-link {{ request('subcategory') === $sub->slug ? 'sub-link-active' : '' }}">
                        {{ $sub->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </aside>

        {{-- Materials grid --}}
        <div class="col-md-9">
            @if ($materials->isEmpty())
            <div class="text-center py-5 text-muted empty-state">
                No materials found in this category yet.
            </div>
            @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
                @foreach ($materials as $material)
                @php($img = $material->primaryImage())
                <div class="col">
                    <div class="card h-100 material-card position-relative">

                        @if ($material->is_featured)
                        <span class="badge listing-featured-badge position-absolute">Featured</span>
                        @endif

                        <a href="{{ route('front.materials.show', [$category->slug, $material->slug]) }}"
                            class="text-decoration-none">
                            <div class="ratio ratio-16x9 bg-light">
                                @if ($img)
                                <img src="{{ asset('storage/' . $img->path) }}" alt="{{ $material->title }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                <div class="d-flex align-items-center justify-content-center text-muted small h-100">No image</div>
                                @endif
                            </div>
                        </a>

                        <div class="card-body p-3 d-flex flex-column">
                            @if ($material->subcategory)
                            <span class="listing-subcat mb-1">{{ $material->subcategory->name }}</span>
                            @endif

                            <a href="{{ route('front.materials.show', [$category->slug, $material->slug]) }}" class="text-decoration-none">
                                <h3 class="card-title fs-6 fw-medium text-truncate mb-1 listing-title">{{ $material->title }}</h3>
                            </a>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold small listing-price">
                                    @if ($material->price)
                                    {{ $material->currency }} {{ number_format($material->price) }}
                                    @if ($material->unit) <span class="text-muted fw-normal">/ {{ $material->unit }}</span> @endif
                                    @else
                                    Price on request
                                    @endif
                                </span>
                                <span @class([ 'listing-stock-dot' , 'stock-in'=> $material->stock_status === 'in_stock',
                                    'stock-out' => $material->stock_status === 'out_of_stock',
                                    'stock-made' => $material->stock_status === 'made_to_order',
                                    ])
                                    title="{{ str_replace('_', ' ', ucfirst($material->stock_status)) }}"></span>
                            </div>

                            @if ($material->shop)
                            <div class="d-flex align-items-center gap-1 mb-2 listing-shop">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;flex-shrink:0">
                                    <path d="M3 21h18M5 21V7l7-4 7 4v14M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1" />
                                </svg>
                                <span class="text-truncate">{{ $material->shop->name }}</span>
                            </div>
                            @endif

                            <div class="d-flex gap-2 mt-auto">
                                <a href="{{ route('front.materials.show', [$category->slug, $material->slug]) }}"
                                    class="btn listing-view-btn flex-grow-1 fw-medium">
                                    View Details
                                </a>
                                <a href="{{ $material->whatsappLink() }}" target="_blank" rel="noopener"
                                    class="btn listing-whatsapp-btn d-flex align-items-center justify-content-center"
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

            <div class="mt-4 listing-pagination">
                {{ $materials->links() }}
            </div>
            @endif
        </div>
    </div>
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
    .breadcrumb-nav {
        color: #6b7280;
    }

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

    /* Header */
    .category-title {
        font-family: var(--font-heading);
        color: var(--navy-dark);
        font-size: 2rem;
    }

    .search-input,
    .sort-select {
        border: 1px solid #e2e5ee;
        border-radius: 8px;
    }

    .search-input:focus,
    .sort-select:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 .2rem rgba(208, 82, 8, .12);
    }

    .filter-btn {
        background-color: var(--gold);
        border: none;
        border-radius: 8px;
        padding: .25rem 1rem;
        transition: background-color .15s ease;
    }

    .filter-btn:hover {
        background-color: #b34606;
        color: #fff;
    }

    /* Sidebar */
    .sidebar-label {
        font-family: var(--font-heading);
        font-size: 1rem;
        color: var(--navy);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .sub-link {
        color: #4b5563;
        transition: background-color .15s ease, color .15s ease;
    }

    .sub-link:hover {
        background-color: var(--gold-light);
        color: var(--gold);
    }

    .sub-link-active {
        background-color: var(--gold-light);
        color: var(--gold) !important;
        font-weight: 600;
    }

    .empty-state {
        background: #fff;
        border: 1px solid #eef0f5;
        border-radius: 12px;
    }

    /* Material cards */
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
    }

    .listing-featured-badge {
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

    .listing-subcat {
        display: block;
        font-size: .68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--gold);
    }

    .listing-title {
        color: var(--navy-dark);
    }

    .listing-price {
        color: var(--gold);
    }

    .listing-shop {
        color: #6b7280;
        font-size: .74rem;
    }

    .listing-stock-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    .listing-stock-dot.stock-in {
        background-color: #22c55e;
    }

    .listing-stock-dot.stock-out {
        background-color: #ef4444;
    }

    .listing-stock-dot.stock-made {
        background-color: var(--navy);
    }

    .listing-view-btn {
        background-color: var(--gold-light);
        color: var(--gold);
        border: none;
        border-radius: 8px;
        font-size: .78rem;
        padding: .45rem .5rem;
        transition: background-color .15s ease, color .15s ease;
    }

    .listing-view-btn:hover {
        background-color: var(--gold);
        color: #fff;
    }

    .listing-whatsapp-btn {
        background-color: #eafaf0;
        color: #1ebc59;
        border: none;
        border-radius: 8px;
        width: 38px;
        flex-shrink: 0;
        transition: background-color .15s ease, color .15s ease;
    }

    .listing-whatsapp-btn:hover {
        background-color: #25D366;
        color: #fff;
    }

    /* Pagination */
    .listing-pagination .page-link {
        color: var(--navy);
        border-color: #eef0f5;
    }

    .listing-pagination .page-link:hover {
        color: var(--gold);
        background-color: var(--gold-light);
    }

    .listing-pagination .page-item.active .page-link {
        background-color: var(--gold);
        border-color: var(--gold);
    }
</style>

@once
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@endonce

@endsection