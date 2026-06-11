@extends('layouts.app')

@section('title', 'Construction Materials – Terra Real Estate')
@section('meta_description', 'Browse verified construction materials in Rwanda — cement, tiles, timber, iron sheets, bricks, paint and more. Find trusted suppliers across every district.')

@section('content')

<style>
    /* ─── Terra Design Tokens ─────────────────────────────── */
    :root {
        --terra-primary:    #D05208;
        --terra-primary-dk: #19265d;
        --terra-accent:     #f0a500;
        --terra-text:       #1a1a2e;
        --terra-muted:      #6b7280;
        --terra-border:     #e5e7eb;
        --terra-bg:         #f9fafb;
        --terra-white:      #ffffff;
        --terra-radius:     10px;
        --terra-shadow:     0 2px 12px rgba(0,0,0,.07);
        --terra-shadow-lg:  0 8px 32px rgba(0,0,0,.10);
    }

    /* ─── Page Hero / Breadcrumb ──────────────────────────── */
    .mat-hero {
        background: linear-gradient(135deg, var(--terra-primary-dk) 0%, var(--terra-primary) 100%);
        padding: 48px 0 36px;
        color: #fff;
    }
    .mat-hero .breadcrumb-wrap {
        font-size: 13px;
        opacity: .75;
        margin-bottom: 12px;
    }
    .mat-hero .breadcrumb-wrap a { color: #fff; text-decoration: none; }
    .mat-hero .breadcrumb-wrap a:hover { text-decoration: underline; }
    .mat-hero h1 { font-size: clamp(1.6rem, 3vw, 2.4rem); font-weight: 700; margin: 0 0 6px; }
    .mat-hero h1 em { font-style: normal; color: var(--terra-accent); }
    .mat-hero .hero-sub { font-size: 15px; opacity: .85; margin: 0; }
    .mat-hero .hero-actions { margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap; }
    .btn-list-material {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--terra-accent); color: #fff; font-weight: 600;
        padding: 10px 22px; border-radius: 6px; text-decoration: none;
        font-size: 14px; transition: background .2s;
    }
    .btn-list-material:hover { background: #d4920a; color: #fff; }

    /* ─── Filter Bar ──────────────────────────────────────── */
    .filter-bar {
        background: var(--terra-white);
        border-bottom: 1px solid var(--terra-border);
        padding: 18px 0;
        position: sticky; top: 0; z-index: 100;
        box-shadow: 0 2px 8px rgba(0,0,0,.05);
    }
    .filter-inner {
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .filter-search {
        flex: 1; min-width: 200px; max-width: 320px;
        position: relative;
    }
    .filter-search input {
        width: 100%; padding: 9px 14px 9px 38px;
        border: 1px solid var(--terra-border); border-radius: 6px;
        font-size: 14px; color: var(--terra-text); outline: none;
        transition: border-color .2s;
    }
    .filter-search input:focus { border-color: var(--terra-primary); }
    .filter-search .search-icon {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--terra-muted); pointer-events: none;
    }
    .filter-select {
        padding: 9px 14px; border: 1px solid var(--terra-border);
        border-radius: 6px; font-size: 14px; color: var(--terra-text);
        background: #fff; cursor: pointer; outline: none;
        transition: border-color .2s;
    }
    .filter-select:focus { border-color: var(--terra-primary); }
    .filter-count {
        margin-left: auto; font-size: 13px; color: var(--terra-muted);
        white-space: nowrap;
    }
    .filter-count strong { color: var(--terra-text); }
    .btn-clear-filters {
        font-size: 13px; color: var(--terra-primary); background: none;
        border: 1px solid var(--terra-primary); border-radius: 6px;
        padding: 8px 14px; cursor: pointer; transition: all .2s;
        text-decoration: none;
    }
    .btn-clear-filters:hover { background: var(--terra-primary); color: #fff; }

    /* ─── Category Pills ──────────────────────────────────── */
    .cat-pills {
        padding: 16px 0 4px;
        display: flex; gap: 8px; flex-wrap: wrap; align-items: center;
    }
    .cat-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 16px; border-radius: 999px; font-size: 13px;
        font-weight: 500; text-decoration: none; transition: all .2s;
        border: 1.5px solid var(--terra-border); color: var(--terra-text);
        background: #fff;
    }
    .cat-pill:hover, .cat-pill.active {
        background: var(--terra-primary); border-color: var(--terra-primary);
        color: #fff;
    }
    .cat-pill .cat-icon { font-size: 15px; }

    /* ─── Main Grid ───────────────────────────────────────── */
    .mat-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 28px;
        padding: 28px 0 60px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .mat-layout { grid-template-columns: 1fr; }
        .mat-sidebar { display: none; }
    }

    /* ─── Sidebar ─────────────────────────────────────────── */
    .mat-sidebar {
        background: #fff; border: 1px solid var(--terra-border);
        border-radius: var(--terra-radius); padding: 20px;
        box-shadow: var(--terra-shadow);
        position: sticky; top: 76px;
    }
    .sidebar-section { margin-bottom: 24px; }
    .sidebar-section:last-child { margin-bottom: 0; }
    .sidebar-title {
        font-size: 12px; font-weight: 700; text-transform: uppercase;
        letter-spacing: .06em; color: var(--terra-muted); margin-bottom: 12px;
    }
    .sidebar-cat-list { list-style: none; padding: 0; margin: 0; }
    .sidebar-cat-list li a {
        display: flex; align-items: center; justify-content: space-between;
        padding: 8px 10px; border-radius: 6px; font-size: 14px;
        color: var(--terra-text); text-decoration: none; transition: all .15s;
    }
    .sidebar-cat-list li a:hover,
    .sidebar-cat-list li a.active {
        background: #f0faf5; color: var(--terra-primary); font-weight: 500;
    }
    .sidebar-cat-list .count {
        font-size: 11px; background: var(--terra-bg); border-radius: 999px;
        padding: 2px 8px; color: var(--terra-muted); font-weight: 600;
    }
    .sidebar-cat-list li a.active .count {
        background: var(--terra-primary); color: #fff;
    }
    .price-range-inputs { display: flex; gap: 8px; }
    .price-range-inputs input {
        flex: 1; padding: 8px 10px; border: 1px solid var(--terra-border);
        border-radius: 6px; font-size: 13px; outline: none;
    }
    .price-range-inputs input:focus { border-color: var(--terra-primary); }
    .btn-apply {
        width: 100%; margin-top: 10px; padding: 9px;
        background: var(--terra-primary); color: #fff; border: none;
        border-radius: 6px; font-size: 14px; font-weight: 600;
        cursor: pointer; transition: background .2s;
    }
    .btn-apply:hover { background: var(--terra-primary-dk); }
    .district-select {
        width: 100%; padding: 9px 12px; border: 1px solid var(--terra-border);
        border-radius: 6px; font-size: 14px; color: var(--terra-text);
        background: #fff; outline: none;
    }
    .district-select:focus { border-color: var(--terra-primary); }

    /* ─── Materials Grid ──────────────────────────────────── */
    .mat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    /* ─── Material Card ───────────────────────────────────── */
    .mat-card {
        background: #fff; border-radius: var(--terra-radius);
        border: 1px solid var(--terra-border); overflow: hidden;
        box-shadow: var(--terra-shadow); transition: transform .2s, box-shadow .2s;
        display: flex; flex-direction: column;
        text-decoration: none; color: inherit;
    }
    .mat-card:hover {
        transform: translateY(-3px); box-shadow: var(--terra-shadow-lg);
    }
    .mat-card-img {
        width: 100%; height: 195px; object-fit: cover; display: block;
        background: var(--terra-bg);
    }
    .mat-card-img-placeholder {
        width: 100%; height: 195px; display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        background: linear-gradient(135deg, #f0faf5, #e6f4ec);
        color: var(--terra-primary); font-size: 38px; gap: 6px;
    }
    .mat-card-img-placeholder span { font-size: 12px; color: var(--terra-muted); font-weight: 500; }
    .mat-card-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .mat-card-cat {
        display: inline-block; font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: .05em;
        color: var(--terra-primary); background: #f0faf5;
        padding: 3px 9px; border-radius: 999px; margin-bottom: 8px;
    }
    .mat-card-title {
        font-size: 15px; font-weight: 600; color: var(--terra-text);
        margin: 0 0 5px; line-height: 1.35;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .mat-card-brand {
        font-size: 12px; color: var(--terra-muted); margin-bottom: 10px;
    }
    .mat-card-price {
        font-size: 18px; font-weight: 700; color: var(--terra-primary);
        margin-bottom: 4px;
    }
    .mat-card-unit { font-size: 12px; color: var(--terra-muted); margin-bottom: 12px; }
    .mat-card-meta {
        margin-top: auto; display: flex; align-items: center;
        justify-content: space-between; padding-top: 12px;
        border-top: 1px solid var(--terra-border); font-size: 12px;
        color: var(--terra-muted);
    }
    .mat-card-location { display: flex; align-items: center; gap: 4px; }
    .mat-card-status {
        padding: 3px 9px; border-radius: 999px; font-size: 11px;
        font-weight: 600;
    }
    .status-available { background: #d1fae5; color: #065f46; }
    .status-out_of_stock { background: #fee2e2; color: #991b1b; }
    .status-discontinued { background: #f3f4f6; color: #6b7280; }
    .mat-card-cta {
        display: flex; align-items: center; justify-content: center;
        gap: 6px; padding: 10px 16px; margin: 0 16px 16px;
        background: var(--terra-primary); color: #fff; border-radius: 6px;
        font-size: 13px; font-weight: 600; transition: background .2s;
        text-decoration: none;
    }
    .mat-card:hover .mat-card-cta { background: var(--terra-primary-dk); }

    /* ─── Empty State ─────────────────────────────────────── */
    .empty-state {
        text-align: center; padding: 70px 24px; grid-column: 1 / -1;
    }
    .empty-state .empty-icon { font-size: 56px; margin-bottom: 16px; }
    .empty-state h3 { font-size: 20px; font-weight: 700; margin-bottom: 8px; color: var(--terra-text); }
    .empty-state p { color: var(--terra-muted); font-size: 14px; max-width: 360px; margin: 0 auto 20px; }
    .btn-empty-reset {
        display: inline-block; padding: 10px 24px;
        background: var(--terra-primary); color: #fff; border-radius: 6px;
        text-decoration: none; font-size: 14px; font-weight: 600;
    }

    /* ─── Pagination ──────────────────────────────────────── */
    .mat-pagination { padding: 32px 0 0; display: flex; justify-content: center; }
    .mat-pagination .pagination { gap: 4px; }
    .mat-pagination .page-link {
        border-radius: 6px !important; font-size: 14px;
        color: var(--terra-primary); border-color: var(--terra-border);
        padding: 8px 14px;
    }
    .mat-pagination .page-item.active .page-link {
        background: var(--terra-primary); border-color: var(--terra-primary); color: #fff;
    }

    /* ─── CTA Banner ──────────────────────────────────────── */
    .supplier-cta {
        background: linear-gradient(135deg, var(--terra-primary) 0%, var(--terra-primary-dk) 100%);
        border-radius: var(--terra-radius); padding: 32px;
        color: #fff; text-align: center; margin-bottom: 28px;
    }
    .supplier-cta h3 { font-size: 18px; font-weight: 700; margin-bottom: 8px; }
    .supplier-cta p { font-size: 14px; opacity: .85; margin-bottom: 18px; }
    .supplier-cta a {
        display: inline-block; background: var(--terra-accent); color: #fff;
        padding: 10px 22px; border-radius: 6px; font-size: 14px; font-weight: 600;
        text-decoration: none; transition: background .2s;
    }
    .supplier-cta a:hover { background: #d4920a; }
</style>

{{-- ══ HERO ══════════════════════════════════════════════════ --}}
<section class="mat-hero">
    <div class="container">
        <div class="breadcrumb-wrap">
            <a href="{{ url('/') }}">Home</a> ›
            <span>Construction Materials</span>
        </div>
        <h1>Construction <em>Materials</em></h1>
        <p class="hero-sub">
            {{ $materials->total() }} verified listings across Rwanda — cement, tiles, timber &amp; more
        </p>
        @auth
        <div class="hero-actions">
            <a href="{{ route('supplier.materials.create') }}" class="btn-list-material">
                🧱 List Your Materials
            </a>
        </div>
        @endauth
    </div>
</section>

{{-- ══ FILTER BAR ═════════════════════════════════════════════ --}}
<div class="filter-bar">
    <div class="container">
        <form method="GET" action="{{ route('materials.index') }}" id="filterForm">
            <div class="filter-inner">
                <div class="filter-search">
                    <svg class="search-icon" width="15" height="15" viewBox="0 0 20 20" fill="none">
                        <circle cx="8.5" cy="8.5" r="5.75" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M13 13l4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                    <input type="text" name="search" placeholder="Search materials, brands…"
                           value="{{ request('search') }}" autocomplete="off">
                </div>

                <select name="category" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

                <select name="location" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Districts</option>
                    @foreach(['Kigali','Gasabo','Kicukiro','Nyarugenge','Bugesera','Gatsibo','Kayonza','Kirehe',
                              'Ngoma','Rwamagana','Burera','Gakenke','Gicumbi','Musanze','Rulindo',
                              'Gisagara','Huye','Kamonyi','Muhanga','Nyamagabe','Nyanza','Nyaruguru','Ruhango',
                              'Karongi','Ngororero','Nyabihu','Nyamasheke','Rubavu','Rusizi','Rutsiro','Nyagatare','Kayonza'] as $d)
                        <option value="{{ $d }}" {{ request('location') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>

                <select name="sort" class="filter-select" onchange="this.form.submit()">
                    <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price ↑</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price ↓</option>
                </select>

                <button type="submit" class="btn-apply" style="width:auto;padding:9px 18px;">Search</button>

                @if(request()->hasAny(['search','category','location','sort','min_price','max_price']))
                    <a href="{{ route('materials.index') }}" class="btn-clear-filters">✕ Clear</a>
                @endif

                <span class="filter-count"><strong>{{ $materials->total() }}</strong> listings</span>
            </div>
        </form>
    </div>
</div>

{{-- ══ CATEGORY PILLS ══════════════════════════════════════════ --}}
<div class="container">
    <div class="cat-pills">
        <a href="{{ route('materials.index') }}"
           class="cat-pill {{ !request('category') ? 'active' : '' }}">
            <span class="cat-icon">🏗️</span> All
        </a>
        @php
        $catIcons = [
            'cement'       => '🧱',
            'iron_sheets'  => '🔩',
            'bricks'       => '🏛️',
            'tiles'        => '⬛',
            'timber'       => '🪵',
            'paint'        => '🎨',
            'plumbing'     => '🚿',
            'electrical'   => '⚡',
            'glass'        => '🪟',
            'sand_gravel'  => '⛏️',
        ];
        @endphp
        @foreach($categories as $key => $label)
            <a href="{{ route('materials.index', array_merge(request()->except('page'), ['category' => $key])) }}"
               class="cat-pill {{ request('category') == $key ? 'active' : '' }}">
                <span class="cat-icon">{{ $catIcons[$key] ?? '📦' }}</span>
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

{{-- ══ MAIN CONTENT ════════════════════════════════════════════ --}}
<div class="container">
    <div class="mat-layout">

        {{-- Sidebar --}}
        <aside class="mat-sidebar">
            <form method="GET" action="{{ route('materials.index') }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <div class="sidebar-section">
                    <div class="sidebar-title">Categories</div>
                    <ul class="sidebar-cat-list">
                        <li>
                            <a href="{{ route('materials.index') }}"
                               class="{{ !request('category') ? 'active' : '' }}">
                                All Materials <span class="count">{{ $materials->total() }}</span>
                            </a>
                        </li>
                        @foreach($categories as $key => $label)
                        <li>
                            <a href="{{ route('materials.index', ['category' => $key]) }}"
                               class="{{ request('category') == $key ? 'active' : '' }}">
                                {{ $catIcons[$key] ?? '📦' }} {{ $label }}
                                <span class="count">
                                    {{ \App\Models\ConstructionMaterial::where('category',$key)->where('is_approved',true)->count() }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-title">Price Range (RWF)</div>
                    <div class="price-range-inputs">
                        <input type="number" name="min_price" placeholder="Min"
                               value="{{ request('min_price') }}">
                        <input type="number" name="max_price" placeholder="Max"
                               value="{{ request('max_price') }}">
                    </div>
                    <button type="submit" class="btn-apply">Apply Filter</button>
                </div>

                <div class="sidebar-section">
                    <div class="sidebar-title">Location</div>
                    <select name="location" class="district-select" onchange="this.form.submit()">
                        <option value="">All Districts</option>
                        @foreach(['Kigali','Gasabo','Kicukiro','Nyarugenge','Bugesera','Gatsibo','Kayonza','Kirehe',
                                  'Ngoma','Rwamagana','Burera','Gakenke','Gicumbi','Musanze','Rulindo',
                                  'Gisagara','Huye','Kamonyi','Muhanga','Nyamagabe','Nyanza','Nyaruguru','Ruhango',
                                  'Karongi','Ngororero','Nyabihu','Nyamasheke','Rubavu','Rusizi','Rutsiro','Nyagatare'] as $d)
                            <option value="{{ $d }}" {{ request('location') == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            {{-- Supplier CTA --}}
            <div class="supplier-cta">
                <h3>Sell Materials on Terra</h3>
                <p>Reach thousands of builders, contractors, and homeowners across Rwanda.</p>
                <a href="{{ route('supplier.materials.create') }}">List for Free →</a>
            </div>
        </aside>

        {{-- Grid --}}
        <div>
            @if($materials->count())
                <div class="mat-grid">
                    @foreach($materials as $material)
                    @php
                    $catLabel = $categories[$material->category] ?? ucfirst($material->category);
                    $icon = $catIcons[$material->category] ?? '📦';
                    @endphp
                    <a href="{{ route('materials.show', $material->slug) }}" class="mat-card">

                        {{-- Thumbnail --}}
                        @if($material->thumbnail)
                            <img src="{{ asset('storage/' . $material->thumbnail) }}"
                                 alt="{{ $material->title }}" class="mat-card-img" loading="lazy">
                        @else
                            <div class="mat-card-img-placeholder">
                                {{ $icon }}
                                <span>{{ $catLabel }}</span>
                            </div>
                        @endif

                        <div class="mat-card-body">
                            <span class="mat-card-cat">{{ $catLabel }}</span>
                            <h3 class="mat-card-title">{{ $material->title }}</h3>
                            @if($material->brand)
                                <div class="mat-card-brand">Brand: {{ $material->brand }}</div>
                            @endif
                            <div class="mat-card-price">
                                RWF {{ number_format($material->price) }}
                            </div>
                            <div class="mat-card-unit">{{ $material->price_unit }}</div>

                            <div class="mat-card-meta">
                                <span class="mat-card-location">
                                    📍 {{ $material->location }}
                                </span>
                                <span class="mat-card-status status-{{ $material->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $material->status)) }}
                                </span>
                            </div>
                        </div>

                        <span class="mat-card-cta">View Details →</span>

                    </a>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mat-pagination">
                    {{ $materials->appends(request()->query())->links() }}
                </div>

            @else
                <div class="empty-state">
                    <div class="empty-icon">🧱</div>
                    <h3>No materials found</h3>
                    <p>Try adjusting your filters or be the first to list materials in this category.</p>
                    <a href="{{ route('materials.index') }}" class="btn-empty-reset">Clear Filters</a>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection
