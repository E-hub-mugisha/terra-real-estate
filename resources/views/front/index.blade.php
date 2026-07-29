@extends('layouts.guest')
@section('title', 'Terra Rwanda Property Exchange - Terra Real Estate')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --dark: #19265d;
        --dark2: #19265d;
        --border: rgba(0, 0, 0, .08);
        --gold: #D05208;
        --gold-lt: #E5A55E;
        --gold-bg: rgba(200, 135, 58, .08);
        --gold-bd: rgba(200, 135, 58, .22);
        --rent: #2f8a5b;
        --rent-bg: rgba(47, 138, 91, .1);
        --rent-bd: rgba(47, 138, 91, .28);
        --service: #2f6f8a;
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --t: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; overflow-x: hidden; }
    a { text-decoration: none; color: inherit; }

    .section { padding: 10px 0; }
    .section-sm { padding: 8px 0; }
    .container-xl { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

    .eyebrow {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: .7rem; font-weight: 500; letter-spacing: .14em; text-transform: uppercase;
        color: var(--gold); margin-bottom: 12px;
    }
    .eyebrow::before, .eyebrow::after { content: ''; width: 20px; height: 1px; background: var(--gold); opacity: .5; }

    .section-title {
        font-family: 'Cormorant Garamond', serif; font-size: clamp(1.8rem, 3.5vw, 2.8rem);
        font-weight: 500; line-height: 1.15; letter-spacing: -.02em; color: var(--text);
    }
    .section-title em { font-style: italic; color: var(--gold); }
    .section-sub { font-size: .88rem; color: var(--muted); line-height: 1.7; max-width: 500px; margin-top: 10px; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .fu { animation: fadeUp .5s ease both; }
    .fu2 { animation: fadeUp .5s ease .1s both; }
    .fu3 { animation: fadeUp .5s ease .2s both; }
    .fu4 { animation: fadeUp .5s ease .3s both; }

    /* ══════════════════════════════════════
       SIMPLE HERO
    ══════════════════════════════════════ */
    .mkt-hero {
        position: relative;
        background: var(--dark);
        overflow: hidden;
        padding: 64px 0 56px;
    }
    .mkt-hero::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse 55% 65% at 15% 15%, rgba(208, 82, 8, .16) 0%, transparent 60%);
        pointer-events: none;
    }
    .mkt-hero-top { position: relative; z-index: 2; }
    .mkt-hero-eyebrow {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: .7rem; font-weight: 600; letter-spacing: .16em; text-transform: uppercase;
        color: var(--gold-lt); margin-bottom: 16px;
    }
    .mkt-hero-eyebrow::before { content: ''; width: 26px; height: 1px; background: var(--gold); }
    .mkt-hero-title {
        font-family: 'Cormorant Garamond', serif; font-size: clamp(2.2rem, 3.6vw, 3.4rem);
        font-weight: 500; line-height: 1.08; letter-spacing: -.02em; color: #F0EDE8;
        max-width: 720px; margin-bottom: 16px;
    }
    .mkt-hero-title em { font-style: italic; color: var(--gold-lt); }
    .mkt-hero-sub {
        font-size: .95rem; color: rgba(240, 237, 232, .55); line-height: 1.7;
        max-width: 520px; margin-bottom: 28px;
    }
    .mkt-hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
    .h-btn-primary, .h-btn-outline {
        display: inline-flex; align-items: center; gap: 8px; padding: 13px 26px; border-radius: 10px;
        font-size: .86rem; font-weight: 600; font-family: 'DM Sans', sans-serif; border: none; cursor: pointer;
        transition: background var(--t), transform var(--t);
    }
    .h-btn-primary { background: var(--gold); color: #fff; }
    .h-btn-primary:hover { background: #a06828; transform: translateY(-2px); color: #fff; }
    .h-btn-outline {
        background: rgba(255, 255, 255, .1); color: #F0EDE8; border: 1px solid rgba(255, 255, 255, .2);
        font-weight: 500; backdrop-filter: blur(8px);
    }
    .h-btn-outline:hover { background: rgba(255, 255, 255, .18); color: #fff; transform: translateY(-2px); }
    .h-btn-primary svg, .h-btn-outline svg { width: 15px; height: 15px; }

    @media (max-width: 768px) {
        .mkt-hero { padding: 44px 0 36px; }
        .mkt-hero-title { font-size: 2rem; }
    }

    /* ══════════════════════════════════════
       FILTER BAR — sticky, live client-side filter
    ══════════════════════════════════════ */
    .mkt-filter-section { background: var(--surface); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 40; }
    .mkt-filter-inner { padding: 16px 0; }

    .mkt-tabs { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; }
    .mkt-tab {
        font-size: .78rem; font-weight: 600; padding: 8px 16px; border-radius: 999px; cursor: pointer;
        background: var(--bg); border: 1px solid var(--border); color: var(--muted);
        transition: all var(--t);
    }
    .mkt-tab.active { background: var(--dark); border-color: var(--dark); color: #fff; }
    .mkt-tab:hover:not(.active) { border-color: var(--gold-bd); color: var(--text); }

    .mkt-filter-row { display: flex; gap: 10px; flex-wrap: wrap; align-items: stretch; margin-bottom: 10px; }
    .mkt-filter-row:last-child { margin-bottom: 0; }
    .mkt-filter-row select, .mkt-filter-row input[type="text"] {
        font-family: inherit; font-size: .85rem; color: var(--text);
        border: 1.5px solid var(--border); border-radius: 8px; background: var(--bg);
        padding: 10px 14px; outline: none; transition: border-color var(--t);
    }
    .mkt-filter-row select:hover, .mkt-filter-row input:hover { border-color: var(--gold-bd); }
    .mkt-filter-row select:focus, .mkt-filter-row input:focus { border-color: var(--gold); }
    .mkt-filter-row select:disabled { opacity: .55; cursor: not-allowed; }
    .mkt-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .mkt-search-wrap input { width: 100%; padding-left: 38px; }
    .mkt-search-wrap svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; color: var(--dim); pointer-events: none;
    }
    .mkt-clear-btn {
        font-size: .8rem; font-weight: 600; color: var(--gold); background: none; border: none; cursor: pointer;
        white-space: nowrap; padding: 10px 6px;
    }

    /* Browse-services strip (subcategory -> service) */
    .mkt-service-browse {
        display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
        margin-top: 4px; padding-top: 12px; border-top: 1px dashed var(--border);
    }
    .mkt-service-browse-label {
        font-size: .74rem; font-weight: 600; letter-spacing: .04em; text-transform: uppercase;
        color: var(--dim); white-space: nowrap;
    }

    @media (max-width: 640px) {
        .mkt-filter-row select, .mkt-filter-row input[type="text"] { width: 100%; }
        .mkt-search-wrap { min-width: 100%; }
    }

    /* ══════════════════════════════════════
       LISTINGS GRID — marketplace cards
    ══════════════════════════════════════ */
    .mkt-listings-section { background: var(--bg); }
    .mkt-results-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 10px; }
    .mkt-results-count { font-size: .82rem; color: var(--muted); }
    .mkt-results-count strong { color: var(--text); }

    .mkt-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 18px; }

    .mkt-card {
        background: var(--surface); border: 1px solid var(--border); border-radius: 14px; overflow: hidden;
        transition: transform var(--t), box-shadow var(--t), border-color var(--t); display: flex; flex-direction: column;
    }
    .mkt-card:hover { transform: translateY(-4px); box-shadow: 0 14px 34px rgba(0, 0, 0, .09); border-color: var(--gold-bd); }

    .mkt-card-img-wrap { position: relative; aspect-ratio: 4/3; overflow: hidden; background: var(--bg); }
    .mkt-card-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .5s ease; }
    .mkt-card:hover .mkt-card-img-wrap img { transform: scale(1.06); }

    .mkt-badge-row { position: absolute; top: 10px; left: 10px; right: 10px; display: flex; justify-content: space-between; gap: 6px; }
    .mkt-badge {
        font-size: .64rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
        padding: 4px 9px; border-radius: 999px; backdrop-filter: blur(6px);
    }
    .mkt-badge-type { background: rgba(25, 38, 93, .85); color: #fff; }
    .mkt-badge-type.land { background: rgba(208, 82, 8, .85); }
    .mkt-badge-type.design { background: rgba(107, 101, 96, .85); }
    .mkt-badge-new { background: var(--gold); color: #fff; }
    .mkt-badge-condition { background: rgba(255, 255, 255, .92); color: var(--text); }
    .mkt-badge-condition.for_rent { color: var(--rent); }
    .mkt-badge-condition.for_sale { color: var(--dark); }

    .mkt-card-body { padding: 16px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
    .mkt-card-price { font-family: 'Cormorant Garamond', serif; font-size: 1.35rem; font-weight: 600; color: var(--text); }
    .mkt-card-price span { font-size: .7rem; font-weight: 500; color: var(--muted); font-family: 'DM Sans', sans-serif; }
    .mkt-card-title { font-size: .88rem; font-weight: 600; color: var(--text); line-height: 1.35; }
    .mkt-card-loc { display: flex; align-items: center; gap: 5px; font-size: .78rem; color: var(--muted); margin-top: 2px; }
    .mkt-card-loc svg { width: 13px; height: 13px; color: var(--gold); flex-shrink: 0; }
    .mkt-card-cta {
        margin-top: auto; padding-top: 10px; display: flex; align-items: center; gap: 5px;
        font-size: .78rem; font-weight: 600; color: var(--gold); transition: gap var(--t);
    }
    .mkt-card:hover .mkt-card-cta { gap: 9px; }
    .mkt-card-cta svg { width: 12px; height: 12px; }

    .mkt-empty { display: none; text-align: center; padding: 60px 20px; color: var(--muted); }
    .mkt-empty svg { width: 40px; height: 40px; color: var(--dim); margin-bottom: 12px; }
    .mkt-empty p { font-size: .9rem; }
    .mkt-empty.show { display: block; }

    .mkt-loadmore-wrap { text-align: center; margin-top: 32px; }
    .mkt-loadmore-wrap.hide { display: none; }
    .mkt-load-more-btn {
        display: inline-flex; align-items: center; gap: 8px; padding: 12px 26px; border-radius: 10px;
        border: 1.5px solid var(--gold-bd); background: transparent; color: var(--gold); font-size: .85rem; font-weight: 600;
        font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all var(--t);
    }
    .mkt-load-more-btn:hover { background: var(--gold); color: #fff; }
    .mkt-load-more-btn svg { width: 14px; height: 14px; }
</style>

{{-- ══════════════════════════════
     HERO — simplified
══════════════════════════════ --}}
<section class="mkt-hero">
    <div class="container-xl mkt-hero-top">
        <div class="mkt-hero-eyebrow">Terra Marketplace</div>
        <h1 class="mkt-hero-title">
            Find your next <em>home, plot or service</em> in Rwanda
        </h1>
        <p class="mkt-hero-sub">
            Browse verified houses, plots, architectural designs and real estate services from trusted professionals across Rwanda.
        </p>
        <div class="mkt-hero-actions">
            <a href="{{ route('front.properties.buy') }}" class="h-btn-primary">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                Browse Properties
            </a>
            <a href="{{ route('front.properties.sell') }}" class="h-btn-outline">Sell Your Property</a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     LIVE FILTER BAR
══════════════════════════════ --}}
<section class="mkt-filter-section">
    <div class="container-xl mkt-filter-inner">
        <div class="mkt-tabs" id="mktTabs">
            <button type="button" class="mkt-tab active" data-type="all">All</button>
            <button type="button" class="mkt-tab" data-type="house">Houses</button>
            <button type="button" class="mkt-tab" data-type="land">Land / Plots</button>
            <button type="button" class="mkt-tab" data-type="design">Designs</button>
        </div>

        {{-- search row (always visible) --}}
        <div class="mkt-filter-row">
            <div class="mkt-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" id="mktSearch" placeholder="Search by title or location…" autocomplete="off">
            </div>
            <button type="button" class="mkt-clear-btn" id="mktClear">Clear filters</button>
        </div>

        {{-- property filters: houses / land / designs --}}
        <div class="mkt-filter-row" id="mktPropertyFilters">
            <select id="mktCondition">
                <option value="all">Any Condition</option>
                <option value="for_sale">For Sale</option>
                <option value="for_rent">For Rent</option>
            </select>

            <select id="mktProvince">
                <option value="all">All Districts</option>
                @foreach($districts as $district => $data)
                <option value="{{ strtolower($district) }}">{{ $district }}</option>
                @endforeach
            </select>

            <select id="mktPrice">
                <option value="all">Any Price</option>
                <option value="0-20000000">Under 20M RWF</option>
                <option value="20000000-50000000">20M – 50M RWF</option>
                <option value="50000000-100000000">50M – 100M RWF</option>
                <option value="100000000-999999999999">Above 100M RWF</option>
            </select>

            <select id="mktBedrooms">
                <option value="all">Any Bedrooms</option>
                <option value="1">1+ Bedrooms</option>
                <option value="2">2+ Bedrooms</option>
                <option value="3">3+ Bedrooms</option>
                <option value="4">4+ Bedrooms</option>
                <option value="5">5+ Bedrooms</option>
            </select>

            {{-- NOTE: pass $propertyTypes (distinct House::pluck('type')) from the controller
                 for a data-driven list; falls back to a generic list if not provided. --}}
            <select id="mktPropertyType">
                <option value="all">Any Type</option>
                @foreach(($propertyTypes ?? ['Apartment', 'Villa', 'Bungalow', 'Duplex', 'Studio', 'Commercial']) as $type)
                <option value="{{ strtolower($type) }}">{{ $type }}</option>
                @endforeach
            </select>

            <select id="mktSort">
                <option value="newest">Newest First</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
            </select>
        </div>

        {{-- browse services: pick a sub-category, then jump straight to a service in it.
             NOTE: this no longer filters the property grid — services are no longer
             listed as marketplace cards. If you want this dropdown to also narrow down
             houses/land/designs, the House/Land/Design models need their own
             subcategory field to match against ($sub->id). --}}
        <div class="mkt-service-browse">
            <span class="mkt-service-browse-label">Browse Services</span>
            <select id="mktSubcategory">
                <option value="">Select a sub-category…</option>
                @foreach($serviceCategories as $category)
                @foreach(($category->subCategories ?? []) as $sub)
                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                @endforeach
                @endforeach
            </select>

            <select id="mktServiceSelect" disabled>
                <option value="">Select a sub-category first…</option>
            </select>
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     LISTINGS GRID
══════════════════════════════ --}}
<section class="section mkt-listings-section">
    <div class="container-xl">
        <div class="mkt-results-bar">
            <div class="mkt-results-count"><strong id="mktCount">0</strong> results found</div>
        </div>

        <div class="mkt-grid" id="mktGrid">
            @php
                $marketplaceItems = collect();

                foreach ($newHouses as $h) {
                    $marketplaceItems->push([
                        'type' => 'house',
                        'condition' => $h->condition ?? 'for_sale',
                        'title' => $h->title ?? 'House Listing',
                        'district' => $h->district ?? '',
                        'province' => $h->province ?? '',
                        'price' => (float) ($h->price ?? 0),
                        'currency' => $h->currency ?? 'RWF',
                        'image' => optional(optional($h->images)->first())->path,
                        'created_at' => $h->created_at,
                        'bedrooms' => (int) ($h->bedrooms ?? 0),
                        'property_type' => strtolower($h->type ?? ''),
                        // NOTE: adjust to your actual property-detail route name
                        'url' => route('front.properties.buy') . '#house-' . $h->id,
                    ]);
                }

                foreach ($newLands as $l) {
                    $marketplaceItems->push([
                        'type' => 'land',
                        'condition' => 'for_sale',
                        'title' => $l->title ?? 'Land / Plot',
                        'district' => $l->district ?? '',
                        'province' => $l->province ?? '',
                        'price' => (float) ($l->price ?? 0),
                        'currency' => $l->currency ?? 'RWF',
                        'image' => optional(optional($l->images)->first())->path,
                        'created_at' => $l->created_at,
                        'bedrooms' => 0,
                        'property_type' => '',
                        'url' => route('front.properties.buy') . '#land-' . $l->id,
                    ]);
                }

                foreach ($newDesigns as $d) {
                    $marketplaceItems->push([
                        'type' => 'design',
                        'condition' => 'for_sale',
                        'title' => $d->title ?? 'Architectural Design',
                        'district' => optional($d->category)->name ?? '',
                        'province' => '',
                        'price' => (float) ($d->price ?? 0),
                        'currency' => $d->currency ?? 'RWF',
                        'image' => optional(optional($d->images)->first())->path,
                        'created_at' => $d->created_at,
                        'bedrooms' => 0,
                        'property_type' => '',
                        'url' => route('front.our.services'),
                    ]);
                }

                $marketplaceItems = $marketplaceItems->sortByDesc('created_at')->values();
            @endphp

            @forelse($marketplaceItems as $item)
            @php
                $isNew = $item['created_at'] && \Carbon\Carbon::parse($item['created_at'])->gt(now()->subDays(7));
            @endphp
            <a href="{{ $item['url'] }}"
                class="mkt-card"
                data-type="{{ $item['type'] }}"
                data-condition="{{ $item['condition'] }}"
                data-province="{{ strtolower($item['province']) }}"
                data-price="{{ $item['price'] }}"
                data-bedrooms="{{ $item['bedrooms'] }}"
                data-propertytype="{{ $item['property_type'] }}"
                data-title="{{ strtolower($item['title'] . ' ' . $item['district'] . ' ' . $item['province']) }}"
                data-created="{{ $item['created_at'] ? \Carbon\Carbon::parse($item['created_at'])->timestamp : 0 }}">
                <div class="mkt-card-img-wrap">
                    <img src="{{ $item['image'] ? asset($item['image']) : asset('front/assets/img/all-images/hero/image-1.png') }}" alt="{{ $item['title'] }}" loading="lazy">
                    <div class="mkt-badge-row">
                        <span class="mkt-badge mkt-badge-type {{ $item['type'] }}">{{ ucfirst($item['type']) }}</span>
                        @if($isNew)
                        <span class="mkt-badge mkt-badge-new">New</span>
                        @endif
                    </div>
                    @if(in_array($item['type'], ['house', 'land']))
                    <div class="mkt-badge-row" style="top: auto; bottom: 10px;">
                        <span class="mkt-badge mkt-badge-condition {{ $item['condition'] }}">{{ $item['condition'] === 'for_rent' ? 'For Rent' : 'For Sale' }}</span>
                    </div>
                    @endif
                </div>
                <div class="mkt-card-body">
                    <div class="mkt-card-price">
                        @if($item['price'] > 0)
                            {{ number_format($item['price']) }} <span>{{ $item['currency'] }}</span>
                        @else
                            <span style="font-size:.85rem; font-weight:600; color:var(--service);">Get a Quote</span>
                        @endif
                    </div>
                    <div class="mkt-card-title">{{ $item['title'] }}</div>
                    <div class="mkt-card-loc">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        {{ $item['district'] }}{{ $item['district'] && $item['province'] ? ', ' : '' }}{{ $item['province'] }}
                    </div>
                    <div class="mkt-card-cta">
                        View Details
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>
            @empty
            <p style="color: var(--muted); font-size: .85rem;">No listings yet.</p>
            @endforelse
        </div>

        <div class="mkt-empty" id="mktEmpty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            <p>Nothing matches your filters. Try adjusting them.</p>
        </div>

        <div class="mkt-loadmore-wrap" id="mktLoadMoreWrap">
            <button type="button" class="mkt-load-more-btn" id="mktLoadMore">
                Load More
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            </button>
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     SERVICES SECTION
══════════════════════════════ --}}
<section class="section services-section" style="background: var(--surface);">
    <div class="container-xl">
        <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:48px; flex-wrap:wrap; gap:16px;">
            <div>
                <div class="eyebrow">What We Offer</div>
                <h2 class="section-title">Terra Connect Services</h2>
                <p class="section-sub">Browse our verified real estate services, choose what you need, and submit a few details. We'll connect you with the right expert or institution to assist you.</p>
            </div>
            <a href="{{ route('front.our.services') }}" style="display:inline-flex; align-items:center; gap:5px; font-size:.8rem; color:var(--gold); font-weight:500; border-bottom:1px solid var(--gold-bd);">
                All services
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:12px;">
            @foreach($serviceCategories as $i => $category)
            <a href="{{ route('services.category', $category->id) }}"
                style="background:var(--bg); border:1px solid var(--border); border-radius:13px; padding:20px; transition:all var(--t); display:block; color:inherit;"
                class="fu" style="animation-delay: {{ $i * 0.07 }}s">
                <div style="font-size:.9rem; font-weight:600; color:var(--text); margin-bottom:4px;">{{ $category->name }}</div>
                <div style="font-size:.76rem; color:var(--muted); line-height:1.55;">Explore {{ strtolower($category->name) }} services from verified professionals.</div>
                <span style="display:flex; align-items:center; gap:4px; font-size:.74rem; color:var(--gold); margin-top:12px; font-weight:500;">
                    Learn more
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     DISTRICTS SECTION
══════════════════════════════ --}}
<section class="section" style="background: var(--bg);">
    <div class="container-xl">
        <div style="text-align:center; margin-bottom:48px;">
            <div class="eyebrow">Browse by Location</div>
            <h2 class="section-title">Properties across <span style="color: #D05208;">every district</span></h2>
            <p class="section-sub" style="margin: 10px auto 0">Find the perfect property in your preferred location in Rwanda.</p>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:14px;">
            @foreach($districts as $district => $data)
            <a href="{{ route('properties.by.province', $district) }}"
                style="background:var(--surface); border:1px solid var(--border); border-radius:13px; padding:22px 20px; transition:all var(--t); display:block; color:inherit;"
                class="fu">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                    <div style="width:36px; height:36px; border-radius:9px; background:var(--gold-bg); border:1px solid var(--gold-bd); display:grid; place-items:center;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="var(--gold)"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    </div>
                    <span style="font-size:.7rem; font-weight:600; letter-spacing:.05em; text-transform:uppercase; color:var(--dim);">{{ $data['total'] ?? 0 }} listings</span>
                </div>
                <div style="font-family:'Cormorant Garamond', serif; font-size:1.15rem; font-weight:600; color:var(--text); margin-bottom:4px;">{{ $district }}</div>
                <div style="font-size:.78rem; color:var(--muted);">{{ $data['total'] ?? 0 }} {{ ($data['total'] ?? 0) == 1 ? 'property' : 'properties' }} available</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════
     PARTNERS
══════════════════════════════ --}}
<div style="background: var(--surface);">
    @include('front.partners')
</div>

@include('front.testimonials._section')

{{-- ══════════════════════════════
     CTA SECTION
══════════════════════════════ --}}
<div class="cta1-section-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-bg-area" style="background-image: url(front/assets/img/all-images/bg/cta-bg1.png); background-position: center; background-repeat: no-repeat; background-size: cover;">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <div class="cta-header">
                                <h2 class="text-anime-style-3" style="perspective: 400px;">Real Estate Consultation</h2>
                                <div class="space16"></div>
                                <p data-aos="fade-left" data-aos-duration="1000" class="aos-init aos-animate">Our team of experts is available Monday to Friday, 9am–6pm. Reach out and we'll guide you every step of the way.</p>
                            </div>
                        </div>
                        <div class="col-lg-5 aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1000">
                            <div style="display:flex; align-items:center; gap:10px; flex-shrink:0;">
                                <a href="mailto:terraltd.rd@gmail.com" style="display:inline-flex; align-items:center; gap:8px; padding:11px 11px; border-radius:10px; font-size:.83rem; font-weight:500; background:var(--gold); color:#fff;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                    Send an Email
                                </a>
                                <a href="https://wa.me/+250796511725" target="_blank" style="display:inline-flex; align-items:center; gap:8px; padding:11px 11px; border-radius:10px; font-size:.83rem; font-weight:500; background:rgba(37, 211, 102, .12); color:#25D366; border:1px solid rgba(37, 211, 102, .25);">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z"/></svg>
                                    WhatsApp Chat
                                </a>
                                <a href="tel:+250796511725" style="display:inline-flex; align-items:center; gap:8px; padding:11px 11px; border-radius:10px; font-size:.83rem; font-weight:500; background:rgba(255, 255, 255, .08); color:#F0EDE8; border:1px solid rgba(255, 255, 255, .15);">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                                    Call Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    window.__mktSubcategoryServices = {
        @foreach($serviceCategories as $category)
        @foreach(($category->subCategories ?? []) as $sub)
        "{{ $sub->id }}": [
            @foreach(($sub->services ?? []) as $service)
            {
                id: "{{ $service->id }}",
                name: @json($service->title ?? $service->name ?? 'Service'),
                url: @json(route('services.category', $category->id) . '#service-' . $service->id)
            },
            @endforeach
        ],
        @endforeach
        @endforeach
    };
</script>

<script>
(function () {
    const PAGE_SIZE = 9;

    const grid = document.getElementById('mktGrid');
    const cards = Array.from(grid.querySelectorAll('.mkt-card'));
    const empty = document.getElementById('mktEmpty');
    const countEl = document.getElementById('mktCount');
    const loadMoreBtn = document.getElementById('mktLoadMore');
    const loadMoreWrap = document.getElementById('mktLoadMoreWrap');

    const tabs = document.querySelectorAll('#mktTabs .mkt-tab');
    const searchInput = document.getElementById('mktSearch');
    const conditionSel = document.getElementById('mktCondition');
    const provinceSel = document.getElementById('mktProvince');
    const priceSel = document.getElementById('mktPrice');
    const bedroomsSel = document.getElementById('mktBedrooms');
    const propertyTypeSel = document.getElementById('mktPropertyType');
    const sortSel = document.getElementById('mktSort');
    const clearBtn = document.getElementById('mktClear');

    const subcategoryBrowseSel = document.getElementById('mktSubcategory');
    const serviceBrowseSel = document.getElementById('mktServiceSelect');
    const subcategoryServiceData = window.__mktSubcategoryServices || {};

    let activeType = 'all';
    let visibleLimit = PAGE_SIZE;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            activeType = tab.dataset.type;
            visibleLimit = PAGE_SIZE;
            applyFilters();
        });
    });

    // Browse Services: subcategory -> service (navigates to the chosen service)
    subcategoryBrowseSel.addEventListener('change', () => {
        const services = subcategoryServiceData[subcategoryBrowseSel.value] || [];
        if (!subcategoryBrowseSel.value || services.length === 0) {
            serviceBrowseSel.innerHTML = '<option value="">Select a sub-category first…</option>';
            serviceBrowseSel.disabled = true;
            return;
        }
        serviceBrowseSel.innerHTML = '<option value="">Select a service…</option>' +
            services.map(s => `<option value="${s.url}">${s.name}</option>`).join('');
        serviceBrowseSel.disabled = false;
    });

    serviceBrowseSel.addEventListener('change', () => {
        if (serviceBrowseSel.value) {
            window.location.href = serviceBrowseSel.value;
        }
    });

    function applyFilters() {
        const q = searchInput.value.trim().toLowerCase();
        const condition = conditionSel.value;
        const province = provinceSel.value;
        const priceRange = priceSel.value;
        const bedrooms = bedroomsSel.value;
        const propertyType = propertyTypeSel.value;

        cards.forEach(card => {
            const type = card.dataset.type;
            let visible = true;

            if (activeType !== 'all' && type !== activeType) visible = false;

            if (visible) {
                if (condition !== 'all' && card.dataset.condition !== condition) visible = false;
                if (visible && province !== 'all' && card.dataset.province !== province) visible = false;
                if (visible && bedrooms !== 'all' && parseInt(card.dataset.bedrooms || '0', 10) < parseInt(bedrooms, 10)) visible = false;
                if (visible && propertyType !== 'all' && card.dataset.propertytype !== propertyType) visible = false;
                if (visible && priceRange !== 'all') {
                    const [min, max] = priceRange.split('-').map(Number);
                    const price = parseFloat(card.dataset.price || '0');
                    if (price < min || price > max) visible = false;
                }
            }

            if (visible && q && !(card.dataset.title || '').includes(q)) visible = false;

            card.dataset.matched = visible ? '1' : '0';
        });

        renderPage();
    }

    function renderPage() {
        const sortBy = sortSel.value;
        const matched = cards.filter(c => c.dataset.matched === '1');

        matched.sort((a, b) => {
            if (sortBy === 'price_low') return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            if (sortBy === 'price_high') return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            return parseInt(b.dataset.created, 10) - parseInt(a.dataset.created, 10);
        });

        matched.forEach(card => grid.appendChild(card));
        cards.forEach(card => { card.style.display = 'none'; });
        matched.slice(0, visibleLimit).forEach(card => { card.style.display = ''; });

        countEl.textContent = matched.length;
        empty.classList.toggle('show', matched.length === 0);
        loadMoreWrap.classList.toggle('hide', matched.length <= visibleLimit);
    }

    loadMoreBtn.addEventListener('click', () => {
        visibleLimit += PAGE_SIZE;
        renderPage();
    });

    [searchInput, conditionSel, provinceSel, priceSel, bedroomsSel, propertyTypeSel, sortSel].forEach(el => {
        const evt = el.tagName === 'SELECT' ? 'change' : 'input';
        el.addEventListener(evt, () => {
            visibleLimit = PAGE_SIZE;
            applyFilters();
        });
    });

    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        conditionSel.value = 'all';
        provinceSel.value = 'all';
        priceSel.value = 'all';
        bedroomsSel.value = 'all';
        propertyTypeSel.value = 'all';
        sortSel.value = 'newest';
        subcategoryBrowseSel.value = '';
        serviceBrowseSel.innerHTML = '<option value="">Select a sub-category first…</option>';
        serviceBrowseSel.disabled = true;
        activeType = 'all';
        visibleLimit = PAGE_SIZE;
        tabs.forEach(t => t.classList.remove('active'));
        tabs[0].classList.add('active');
        applyFilters();
    });

    applyFilters();
})();
</script>

@endsection