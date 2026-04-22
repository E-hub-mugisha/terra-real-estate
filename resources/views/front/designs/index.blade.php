@extends('layouts.guest')
@section('title', 'Architectural Designs')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap');

    :root {
        --clr-bg: #F7F5F2;
        --clr-surface: #FFFFFF;
        --clr-border: #E8E3DC;
        --clr-text: #19265d;
        --clr-muted: #7A736B;
        --clr-accent: #C8873A;
        --clr-accent-dk: #A06828;
        --clr-purple: #5A3B8C;
        --clr-green: #1E7A5A;
        --clr-green-bg: rgba(30, 122, 90, .07);
        --clr-green-bd: rgba(30, 122, 90, .2);
        --radius-card: 14px;
        --shadow-card: 0 2px 12px rgba(0, 0, 0, .07), 0 1px 3px rgba(0, 0, 0, .05);
        --shadow-hover: 0 8px 28px rgba(0, 0, 0, .13), 0 2px 6px rgba(0, 0, 0, .07);
        --transition: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        background: var(--clr-bg);
        font-family: 'DM Sans', sans-serif;
        color: var(--clr-text);
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* ── Page Header ── */
    .prop-header {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 80px 0 28px;
    }

    .prop-header-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--clr-accent);
        margin-bottom: 8px;
    }

    .prop-header-eyebrow::before {
        content: '';
        width: 18px;
        height: 1px;
        background: var(--clr-accent);
        opacity: .5;
    }

    .prop-header h1 {
        font-family: 'DM Serif Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        color: var(--clr-text);
        font-weight: 400;
        letter-spacing: -.02em;
        margin: 0 0 6px;
    }

    .prop-header h1 em {
        font-style: italic;
        color: var(--clr-accent);
    }

    .prop-header p {
        color: var(--clr-muted);
        font-size: .88rem;
        margin: 0;
    }

    /* ── Filter Bar ── */
    .filter-bar {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 12px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    }

    .filter-bar .inner {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 180px;
        max-width: 260px;
    }

    .search-wrap svg {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--clr-muted);
        width: 15px;
        height: 15px;
        pointer-events: none;
    }

    .search-wrap input {
        width: 100%;
        padding: 8px 12px 8px 34px;
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        font-size: .83rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--clr-bg);
        color: var(--clr-text);
        transition: border-color var(--transition);
    }

    .search-wrap input:focus {
        outline: none;
        border-color: var(--clr-accent);
        background: #fff;
    }

    .search-wrap input::placeholder {
        color: var(--clr-muted);
    }

    /* Free / Paid tabs */
    .price-tabs {
        display: flex;
        gap: 4px;
    }

    .price-tab {
        padding: 7px 14px;
        border-radius: 8px;
        border: 1.5px solid var(--clr-border);
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 500;
        color: var(--clr-muted);
        cursor: pointer;
        transition: all var(--transition);
        white-space: nowrap;
    }

    .price-tab:hover {
        border-color: var(--clr-accent);
        color: var(--clr-accent);
    }

    .price-tab.active {
        background: var(--clr-accent);
        border-color: var(--clr-accent);
        color: #fff;
    }

    .filter-select {
        padding: 7px 28px 7px 11px;
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        font-size: .82rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--clr-text);
        background: var(--clr-bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237A736B' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 9px center no-repeat;
        appearance: none;
        cursor: pointer;
        transition: border-color var(--transition);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--clr-accent);
    }

    .filter-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .result-count {
        font-size: .8rem;
        color: var(--clr-muted);
        white-space: nowrap;
    }

    .result-count strong {
        color: var(--clr-text);
    }

    .view-toggle {
        display: flex;
        gap: 4px;
    }

    .view-btn {
        width: 34px;
        height: 34px;
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        background: transparent;
        display: grid;
        place-items: center;
        cursor: pointer;
        color: var(--clr-muted);
        transition: all var(--transition);
    }

    .view-btn.active,
    .view-btn:hover {
        background: var(--clr-accent);
        border-color: var(--clr-accent);
        color: #fff;
    }

    .view-btn svg {
        width: 15px;
        height: 15px;
    }

    /* ── Main area ── */
    .dp-main {
        padding: 28px 0 72px;
    }

    /* ── Tier section ── */
    .tier-section {
        margin-bottom: 52px;
    }

    .tier-section.is-empty {
        display: none;
    }

    .tier-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px 0 16px;
        border-bottom: 2px solid var(--clr-border);
        margin-bottom: 22px;
    }

    .tier-divider {
        width: 3px;
        height: 34px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    .tier-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .tier-icon svg {
        width: 18px;
        height: 18px;
    }

    .tier-label {
        font-family: 'DM Serif Display', serif;
        font-size: 1.15rem;
        font-weight: 400;
        color: var(--clr-text);
        margin: 0;
    }

    .tier-desc {
        font-size: .78rem;
        color: var(--clr-muted);
        margin: 2px 0 0;
    }

    .tier-count {
        margin-left: auto;
        font-size: .75rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    /* ── Design Card ── */
    .prop-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        background: var(--clr-surface);
        border-radius: var(--radius-card);
        border: 1px solid var(--clr-border);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition);
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        animation: fadeUp .35s ease both;
    }

    .prop-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        border-color: rgba(200, 135, 58, .3);
        color: inherit;
        text-decoration: none;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tier top accent */
    [data-tier="standard"] .prop-card {
        border-top: 3px solid #C8873A;
    }

    [data-tier="medium"] .prop-card {
        border-top: 3px solid #3B6E5A;
    }

    /* Card Image */
    .card-img-wrap {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/10;
        background: var(--clr-border);
        flex-shrink: 0;
    }

    .card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .45s ease;
        display: block;
    }

    .prop-card:hover .card-img-wrap img {
        transform: scale(1.06);
    }

    /* Badges */
    .badge-cat {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: #fff;
        z-index: 2;
        background: var(--clr-purple);
    }

    .badge-pricing {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        z-index: 2;
    }

    .badge-pricing.free {
        background: rgba(30, 122, 90, .85);
        color: #fff;
    }

    .badge-pricing.paid {
        background: rgba(14, 14, 12, .72);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, .12);
        color: rgba(240, 237, 232, .75);
    }

    .badge-featured {
        position: absolute;
        bottom: 10px;
        left: 10px;
        z-index: 3;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        background: rgba(200, 135, 58, .85);
        color: #fff;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, .25);
    }

    /* Wishlist */
    .wish-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .9);
        backdrop-filter: blur(4px);
        border: none;
        display: grid;
        place-items: center;
        cursor: pointer;
        z-index: 2;
        transition: background var(--transition);
    }

    .wish-btn:hover {
        background: #fff;
    }

    .wish-btn svg {
        width: 15px;
        height: 15px;
        color: var(--clr-muted);
    }

    .wish-btn.active svg {
        color: #e53e3e;
        fill: #e53e3e;
    }

    /* Card Body */
    .card-body-custom {
        padding: 14px 16px 16px;
        display: flex;
        flex-direction: column;
        gap: 9px;
        flex: 1;
    }

    .card-title {
        font-size: .91rem;
        font-weight: 600;
        color: var(--clr-text);
        line-height: 1.35;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-service {
        font-size: .77rem;
        color: var(--clr-accent);
        font-weight: 500;
    }

    .card-desc {
        font-size: .77rem;
        color: var(--clr-muted);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-stats {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .77rem;
        color: var(--clr-muted);
        font-weight: 500;
    }

    .stat-item svg {
        width: 13px;
        height: 13px;
    }

    /* Card Footer */
    .card-footer-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid var(--clr-border);
        margin-top: auto;
        gap: 8px;
    }

    .card-price {
        font-size: .95rem;
        font-weight: 700;
        color: var(--clr-accent);
        margin: 0;
        white-space: nowrap;
    }

    .card-price span {
        font-size: .7rem;
        font-weight: 500;
        color: var(--clr-muted);
        margin-left: 2px;
    }

    .card-price-free {
        font-size: .85rem;
        font-weight: 700;
        color: var(--clr-green);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .card-price-free svg {
        width: 14px;
        height: 14px;
    }

    /* CTA buttons */
    .card-cta {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 13px;
        border-radius: 7px;
        font-size: .76rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        transition: all var(--transition);
        border: none;
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
    }

    .cta-buy {
        background: rgba(200, 135, 58, .08);
        border: 1px solid rgba(200, 135, 58, .22);
        color: var(--clr-accent);
    }

    .prop-card:hover .cta-buy {
        background: var(--clr-accent);
        border-color: var(--clr-accent);
        color: #fff;
    }

    .cta-dl {
        background: var(--clr-green-bg);
        border: 1px solid var(--clr-green-bd);
        color: var(--clr-green);
    }

    .prop-card:hover .cta-dl {
        background: var(--clr-green);
        border-color: var(--clr-green);
        color: #fff;
    }

    .card-cta svg {
        width: 13px;
        height: 13px;
    }

    /* ── List View ── */
    .props-grid.list-view {
        grid-template-columns: 1fr !important;
    }

    .props-grid.list-view .prop-card {
        flex-direction: row;
        max-height: 162px;
    }

    .props-grid.list-view .card-img-wrap {
        width: 200px;
        min-width: 200px;
        aspect-ratio: unset;
        flex-shrink: 0;
    }

    .props-grid.list-view .card-desc {
        display: none;
    }

    /* ── Grid layout ── */
    .props-grid {
        gap: 18px;
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--clr-muted);
    }

    .empty-state svg {
        width: 46px;
        height: 46px;
        margin-bottom: 14px;
        opacity: .35;
    }

    .empty-state h3 {
        font-size: .96rem;
        color: var(--clr-text);
        margin-bottom: 5px;
    }

    .empty-state p {
        font-size: .84rem;
    }

    /* ── No-results global ── */
    #no-results {
        display: none;
        text-align: center;
        padding: 56px 20px;
        color: var(--clr-muted);
    }

    #no-results svg {
        width: 46px;
        height: 46px;
        margin-bottom: 14px;
        opacity: .35;
        display: block;
        margin-inline: auto;
    }

    #no-results h3 {
        font-size: 1rem;
        color: var(--clr-text);
        margin-bottom: 5px;
    }

    @media (max-width: 640px) {
        .filter-meta {
            margin-left: 0;
        }

        .props-grid.list-view .card-img-wrap {
            width: 130px;
            min-width: 130px;
        }
    }
</style>

{{-- ── Page Header ── --}}
<div class="prop-header">
    <div class="container">
        <div class="prop-header-eyebrow">Design Marketplace</div>
        <h1>Architectural <em>Designs</em></h1>
        <p>{{ $designs->count() }} {{ Str::plural('design', $designs->count()) }} available — browse, buy or download for free</p>
        <div style="height: 16px"></div>
    </div>
</div>

{{-- ── Sticky Filter Bar ── --}}
<div class="filter-bar">
    <div class="container">
        <div class="inner">

            {{-- Search --}}
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="text" id="filter-search" placeholder="Search title or category…" autocomplete="off">
            </div>

            {{-- Free / Paid tabs --}}
            <div class="price-tabs">
                <button class="price-tab active" data-f="all">All</button>
                <button class="price-tab" data-f="free">Free</button>
                <button class="price-tab" data-f="paid">Paid</button>
            </div>

            {{-- Category --}}
            <select class="filter-select" id="filter-cat">
                <option value="">Any Category</option>
                @foreach($designs->pluck('category.name')->filter()->unique()->sort() as $cat)
                <option value="{{ strtolower($cat) }}">{{ $cat }}</option>
                @endforeach
            </select>

            {{-- Sort --}}
            <select class="filter-select" id="filter-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="price-asc">Price ↑</option>
                <option value="price-desc">Price ↓</option>
                <option value="name-az">Name A–Z</option>
            </select>

            {{-- Meta --}}
            <div class="filter-meta">
                <span class="result-count"><strong id="visible-count">{{ $designs->count() }}</strong> designs</span>
                <div class="view-toggle">
                    <button class="view-btn active" id="btn-grid" title="Grid view">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm0 9h7v7h-7v-7zM4 13h7v7H4v-7z" />
                        </svg>
                    </button>
                    <button class="view-btn" id="btn-list" title="List view">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 4h13v2H8V4zM4.5 6.5a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zM4.5 20a1 1 0 110-2 1 1 0 010 2zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Listings grouped by tier ── --}}
<div class="dp-main">
    <div class="container">

        <div id="no-results">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35M11 8v3m0 3h.01" />
            </svg>
            <h3>No designs match your filters</h3>
            <p>Try adjusting your search or clearing filters.</p>
        </div>

        @foreach($tiers as $tierKey => $tier)
        @php
        $tierDesigns = $designs->filter(fn($d) => ($d->listingPackage->package_tier ?? 'basic') === $tierKey);
        $tierTotal = $tierDesigns->count();
        @endphp

        <div class="tier-section {{ $tierTotal === 0 ? 'is-empty' : '' }}"
            id="tier-section-{{ $tierKey }}"
            data-tier-key="{{ $tierKey }}">

            {{-- Tier Header --}}
            <div class="tier-header">
                <div class="tier-divider" style="background: {{ $tier['color'] }}"></div>
                <div class="tier-icon" style="background: {{ $tier['bg'] }}; color: {{ $tier['color'] }}">
                    @if($tier['icon'] === 'star')
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                    </svg>
                    @elseif($tier['icon'] === 'trending')
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" />
                        <polyline points="17 6 23 6 23 12" />
                    </svg>
                    @else
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 6h13v2H8V6zm-5-.5h2v2H3v-2zm0 7h2v2H3v-2zm0 7h2v2H3v-2zM8 13h13v2H8v-2zm0 7h13v2H8v-2z" />
                    </svg>
                    @endif
                </div>
                <div>
                    <p class="tier-label">{{ $tier['label'] }}</p>
                    <p class="tier-desc">{{ $tier['description'] }}</p>
                </div>
                <span class="tier-count"
                    style="background: {{ $tier['bg'] }}; color: {{ $tier['color'] }}"
                    id="tier-count-{{ $tierKey }}">
                    {{ $tierTotal }} {{ Str::plural('listing', $tierTotal) }}
                </span>
            </div>

            {{-- Cards grid --}}
            <div class="props-grid row" id="tier-row-{{ $tierKey }}">

                @forelse($tierDesigns as $design)
                @php
                $imgSrc = $design->preview_image
                ? asset('storage/' . $design->preview_image)
                : asset('front/assets/img/all-images/properties/property-img3.png');
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3"
                    data-tier="{{ $tierKey }}"
                    data-title="{{ strtolower($design->title) }}"
                    data-cat="{{ strtolower($design->category?->name ?? '') }}"
                    data-free="{{ $design->is_free ? '1' : '0' }}"
                    data-price="{{ $design->price ?? 0 }}"
                    data-created="{{ $design->created_at->timestamp ?? 0 }}">

                    <div class="prop-card h-100"
                        {{ $design->is_free ? '' : '' }}>
                        <div class="card-img-wrap">

                            {{-- Category badge --}}
                            <span class="badge-cat">{{ $design->category?->name ?? 'Design' }}</span>

                            {{-- Free / Paid badge --}}
                            <span class="badge-pricing {{ $design->is_free ? 'free' : 'paid' }}">
                                {{ $design->is_free ? 'Free' : number_format($design->price) . ' RWF' }}
                            </span>

                            {{-- Featured badge for standard tier --}}
                            @if($tierKey === 'standard')
                            <span class="badge-featured">⭐ Featured</span>
                            @endif

                            <img src="{{ $imgSrc }}" alt="{{ $design->title }}" loading="lazy">

                            <button class="wish-btn" onclick="event.preventDefault(); this.classList.toggle('active')">
                                <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra Real estate" style="width:20px; height:20px;">
                            </button>
                        </div>

                        <div class="card-body-custom">
                            <a href="{{ $design->is_free ? '#' : route('front.buy.design.show', $design->slug) }}" class="card-title">{{ $design->title }}</a>

                            @if($design->service)
                            <div class="card-service">{{ $design->service->title }}</div>
                            @endif

                            @if($design->description)
                            <p class="card-desc">{{ Str::limit($design->description, 80) }}</p>
                            @endif

                            <div class="card-stats">
                                @if($design->category)
                                <span class="stat-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                    </svg>
                                    {{ $design->category->name }}
                                </span>
                                @endif
                                <span class="stat-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                    </svg>
                                    {{ strtoupper(pathinfo($design->design_file ?? 'PDF', PATHINFO_EXTENSION) ?: 'PDF') }}
                                </span>
                                @if($design->status)
                                <span class="stat-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ ucfirst($design->status) }}
                                </span>
                                @endif
                            </div>

                            <div class="card-footer-custom">
                                @if($design->is_free)
                                <div class="card-price-free">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M5 16h14v2H5v-2zm9-4h5l-7 7-7-7h5V3h4v9z" />
                                    </svg>
                                    Free Download
                                </div>
                                <a href="{{ asset('storage/' . $design->design_file) }}"
                                    download
                                    onclick="event.stopPropagation()"
                                    class="card-cta cta-dl">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M5 16h14v2H5v-2zm9-4h5l-7 7-7-7h5V3h4v9z" />
                                    </svg>
                                    Download
                                </a>
                                @else
                                <p class="card-price">
                                    {{ number_format($design->price ?? 0) }}
                                    <span>RWF</span>
                                </p>
                                <a href="{{ route('front.buy.design.purchase', $design->slug) }}"
                                    onclick="event.stopPropagation()"
                                    class="card-cta cta-buy">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM5.82 5H21v2l-2.27 4.54c-.27.53-.84.87-1.46.87H9.26L8.4 14H19v2H8c-1.32 0-2-.9-2-2.12l1.1-2.2L4 4H2V2h2.27L5.82 5z" />
                                    </svg>
                                    Buy Now
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                        </svg>
                        <h3>No designs in this tier yet</h3>
                        <p>Check back soon — new designs are uploaded regularly.</p>
                    </div>
                </div>
                @endforelse

            </div>{{-- /tier-row --}}
        </div>{{-- /tier-section --}}
        @endforeach

    </div>
</div>

<script>
    (function() {
        'use strict';

        const allCols = Array.from(document.querySelectorAll('[data-tier]'));
        const searchInput = document.getElementById('filter-search');
        const catSelect = document.getElementById('filter-cat');
        const sortSelect = document.getElementById('filter-sort');
        const priceTabs = document.querySelectorAll('.price-tab');
        const btnGrid = document.getElementById('btn-grid');
        const btnList = document.getElementById('btn-list');
        const noResults = document.getElementById('no-results');
        const visibleCount = document.getElementById('visible-count');

        const TIER_ORDER = {
            standard: 0,
            medium: 1,
            basic: 2
        };
        const TIER_KEYS = ['standard', 'medium', 'basic'];

        let state = {
            search: '',
            free: 'all',
            cat: '',
            sort: 'newest'
        };

        const debounce = (fn, ms) => {
            let t;
            return (...a) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...a), ms);
            };
        };

        function applyFilters() {
            const q = state.search.trim().toLowerCase();

            let visible = allCols.filter(col => {
                // Free / Paid
                if (state.free === 'free' && col.dataset.free !== '1') return false;
                if (state.free === 'paid' && col.dataset.free !== '0') return false;
                // Category
                if (state.cat && !col.dataset.cat.includes(state.cat)) return false;
                // Search
                if (q && !(col.dataset.title + ' ' + col.dataset.cat).includes(q)) return false;
                return true;
            });

            // Sort — tier order always preserved first
            visible.sort((a, b) => {
                const tDiff = (TIER_ORDER[a.dataset.tier] ?? 9) - (TIER_ORDER[b.dataset.tier] ?? 9);
                if (tDiff !== 0) return tDiff;
                switch (state.sort) {
                    case 'price-asc':
                        return Number(a.dataset.price) - Number(b.dataset.price);
                    case 'price-desc':
                        return Number(b.dataset.price) - Number(a.dataset.price);
                    case 'oldest':
                        return Number(a.dataset.created) - Number(b.dataset.created);
                    case 'name-az':
                        return a.dataset.title.localeCompare(b.dataset.title);
                    default:
                        return Number(b.dataset.created) - Number(a.dataset.created);
                }
            });

            // Show / hide
            const visSet = new Set(visible);
            allCols.forEach(col => col.style.display = visSet.has(col) ? '' : 'none');

            // Re-append in sorted order into correct tier rows
            visible.forEach(col => {
                const row = document.getElementById('tier-row-' + col.dataset.tier);
                if (row) row.appendChild(col);
            });

            // Update tier section visibility + counts
            TIER_KEYS.forEach(key => {
                const section = document.getElementById('tier-section-' + key);
                const countEl = document.getElementById('tier-count-' + key);
                const n = visible.filter(c => c.dataset.tier === key).length;
                if (section) section.classList.toggle('is-empty', n === 0);
                if (countEl) countEl.textContent = n + ' ' + (n === 1 ? 'listing' : 'listings');
            });

            visibleCount.textContent = visible.length;
            noResults.style.display = visible.length === 0 ? 'block' : 'none';
        }

        // ── Event listeners ──
        searchInput.addEventListener('input', debounce(e => {
            state.search = e.target.value;
            applyFilters();
        }, 250));
        catSelect.addEventListener('change', e => {
            state.cat = e.target.value;
            applyFilters();
        });
        sortSelect.addEventListener('change', e => {
            state.sort = e.target.value;
            applyFilters();
        });

        priceTabs.forEach(tab => tab.addEventListener('click', () => {
            priceTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            state.free = tab.dataset.f;
            applyFilters();
        }));

        // ── View toggle ──
        btnGrid.addEventListener('click', () => {
            document.querySelectorAll('.props-grid').forEach(g => g.classList.remove('list-view'));
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
            localStorage.setItem('designsView', 'grid');
        });

        btnList.addEventListener('click', () => {
            document.querySelectorAll('.props-grid').forEach(g => g.classList.add('list-view'));
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
            localStorage.setItem('designsView', 'list');
        });

        if (localStorage.getItem('designsView') === 'list') btnList.click();

        applyFilters();
    })();
</script>

@endsection