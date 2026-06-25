@extends('layouts.guest')
@section('title', 'Properties')

<style>
    /* ── Google Fonts ── */
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap');

    /* ── CSS Variables ── */
    :root {
        --clr-bg: #F7F5F2;
        --clr-surface: #FFFFFF;
        --clr-border: #E8E3DC;
        --clr-text: #19265d;
        --clr-muted: #7A736B;
        --clr-accent: #D05208;
        --clr-accent-dk: #A06828;
        --clr-home: #3B6E5A;
        --clr-land: #8B6914;
        --clr-design: #5A3B6E;
        --radius-card: 14px;
        --shadow-card: 0 2px 12px rgba(0, 0, 0, .07), 0 1px 3px rgba(0, 0, 0, .05);
        --shadow-hover: 0 8px 28px rgba(0, 0, 0, .13), 0 2px 6px rgba(0, 0, 0, .07);
        --transition: .22s cubic-bezier(.4, 0, .2, 1);
    }

    body {
        background: var(--clr-bg);
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Page Header ── */
    .prop-header {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 100px 0 0;
    }

    .prop-header h1 {
        font-family: 'DM Serif Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        color: var(--clr-text);
        font-weight: 400;
        letter-spacing: -.02em;
    }

    .prop-header p {
        color: var(--clr-muted);
        font-size: .9rem;
    }

    /* ── Filter Bar ── */
    .filter-bar {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 14px 0;
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

    /* Category Dropdown */
    .hs-filter-group {
        position: relative;
        display: flex;
        align-items: center;
        min-width: 140px;
        flex-shrink: 0;
    }

    .hs-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;

        width: 100%;
        padding: 8px 32px 8px 12px;

        background-color: var(--clr-bg);
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;

        font-size: .82rem;
        font-weight: 500;
        color: var(--clr-text);
        cursor: pointer;
        font-family: 'DM Sans', sans-serif;

        transition: all var(--transition);
    }

    .hs-select:hover {
        border-color: var(--clr-accent);
    }

    .hs-select:focus {
        outline: none;
        border-color: var(--clr-accent);
        background: var(--clr-surface);
        box-shadow: 0 0 0 3px rgba(208, 82, 8, 0.1);
    }

    .hs-select-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--clr-accent);
        pointer-events: none;
        flex-shrink: 0;
    }

    .hs-select option:first-child {
        color: var(--clr-muted);
    }

    .hs-select option {
        color: var(--clr-text);
        padding: 8px;
    }

    /* Search */
    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 180px;
        max-width: 280px;
    }

    .search-wrap svg {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--clr-muted);
        width: 16px;
        height: 16px;
    }

    .search-wrap input {
        width: 100%;
        padding: 8px 12px 8px 34px;
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        font-size: .85rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--clr-bg);
        color: var(--clr-text);
        transition: all var(--transition);
    }

    .search-wrap input:focus {
        outline: none;
        border-color: var(--clr-accent);
        background: var(--clr-surface);
    }

    .search-wrap input::placeholder {
        color: var(--clr-muted);
    }

    /* Selects */
    .filter-select {
        padding: 8px 30px 8px 12px;
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        font-size: .82rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--clr-text);
        background: var(--clr-bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237A736B' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 10px center no-repeat;
        appearance: none;
        cursor: pointer;
        transition: all var(--transition);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--clr-accent);
        background: var(--clr-surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23D05208' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 10px center no-repeat;
    }

    /* View toggle */
    .view-toggle {
        display: flex;
        gap: 4px;
        margin-left: auto;
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
        width: 16px;
        height: 16px;
    }

    /* Result count */
    .result-count {
        font-size: .82rem;
        color: var(--clr-muted);
        white-space: nowrap;
    }

    .result-count strong {
        color: var(--clr-text);
    }

    /* ── Property Card ── */
    .prop-card {
        background: var(--clr-surface);
        border-radius: var(--radius-card);
        border: 1px solid var(--clr-border);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: transform var(--transition), box-shadow var(--transition);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        height: 100%;
    }

    .prop-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        text-decoration: none;
        color: inherit;
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

    /* Type Badge */
    .type-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #fff;
        z-index: 2;
    }

    .type-badge.home {
        background: var(--clr-home);
    }

    .type-badge.land {
        background: var(--clr-land);
    }

    .type-badge.design {
        background: var(--clr-design);
    }

    /* Condition badge */
    .cond-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 500;
        background: rgba(255, 255, 255, .9);
        backdrop-filter: blur(4px);
        color: var(--clr-text);
        z-index: 2;
    }

    /* Wishlist btn */
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
        gap: 10px;
        flex: 1;
    }

    .card-title {
        font-size: .92rem;
        font-weight: 600;
        color: var(--clr-text);
        line-height: 1.35;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-location {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: .78rem;
        color: var(--clr-muted);
        margin: 0;
    }

    .card-location svg {
        width: 12px;
        height: 12px;
        flex-shrink: 0;
    }

    /* Stats row */
    .card-stats {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .78rem;
        color: var(--clr-muted);
        font-weight: 500;
    }

    .stat-item svg {
        width: 14px;
        height: 14px;
    }

    /* Card footer */
    .card-footer-custom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid var(--clr-border);
        margin-top: auto;
    }

    .card-price {
        font-size: .95rem;
        font-weight: 700;
        color: var(--clr-accent);
        font-family: 'DM Sans', sans-serif;
        margin: 0;
    }

    .card-price span {
        font-size: .72rem;
        font-weight: 500;
        color: var(--clr-muted);
        margin-left: 2px;
    }

    .card-cta {
        font-size: .78rem;
        font-weight: 600;
        color: var(--clr-accent);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: gap var(--transition);
    }

    .card-cta:hover {
        gap: 8px;
        color: var(--clr-accent-dk);
        text-decoration: none;
    }

    .card-cta svg {
        width: 14px;
        height: 14px;
    }

    /* ── List View Card ── */
    .prop-card.list-mode {
        flex-direction: row;
        aspect-ratio: unset;
        max-height: 160px;
    }

    .prop-card.list-mode .card-img-wrap {
        width: 200px;
        min-width: 200px;
        aspect-ratio: unset;
        flex-shrink: 0;
    }

    .prop-card.list-mode .card-body-custom {
        padding: 12px 16px;
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--clr-muted);
    }

    .empty-state svg {
        width: 48px;
        height: 48px;
        margin-bottom: 16px;
        opacity: .4;
    }

    .empty-state h3 {
        font-size: 1rem;
        color: var(--clr-text);
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: .85rem;
    }

    /* ── No-results banner ── */
    #no-results {
        display: none;
        padding: 48px;
        text-align: center;
        color: var(--clr-muted);
        font-size: .9rem;
    }

    /* ── Animate in ── */
    .prop-card {
        animation: fadeUp .35s ease both;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tier section header */
    .tier-section {
        margin-bottom: 48px;
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
        margin-bottom: 20px;
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
        margin: 0;
    }

    .tier-count {
        margin-left: auto;
        font-size: .75rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .tier-divider {
        width: 3px;
        height: 32px;
        border-radius: 2px;
        flex-shrink: 0;
    }

    /* Tier badge on card */
    .tier-badge {
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
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, .25);
    }

    /* Standard tier gets a gold top border on cards */
    [data-tier="standard"] .prop-card {
        border-top: 3px solid #D05208;
    }

    [data-tier="medium"] .prop-card {
        border-top: 3px solid #3B6E5A;
    }

    /* Bootstrap column override for list view */
    .props-row.list-view .col-xl-3,
    .props-row.list-view .col-lg-4,
    .props-row.list-view .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .filter-bar .inner {
            gap: 8px;
        }

        .view-toggle {
            margin-left: 0;
        }

        .search-wrap {
            max-width: 100%;
            flex: 1;
            min-width: 150px;
        }

        .hs-filter-group {
            min-width: 120px;
        }
    }

    @media (max-width: 600px) {
        .filter-bar .inner {
            flex-direction: column;
            gap: 6px;
        }

        .search-wrap,
        .hs-filter-group,
        .filter-select {
            width: 100%;
            max-width: 100%;
        }

        .view-toggle {
            width: 100%;
            justify-content: flex-end;
        }

        .result-count {
            width: 100%;
        }
    }
</style>

@section('content')

{{-- ── Page Header ── --}}
<div class="prop-header">
    <div class="container-lg">
        <h1>Browse Properties</h1>
        <p>Homes, Plots & Architectural Designs across Rwanda</p>
        <div style="height:20px"></div>
    </div>
</div>

{{-- ── Sticky Filter Bar ── --}}
<div class="filter-bar">
    <div class="container-lg">
        <div class="inner">

            {{-- Category Dropdown --}}
            <div class="hs-filter-group">
                <select class="hs-select" id="filter-category">
                    <option value="">All Categories</option>
                    <option value="home">Homes</option>
                    <option value="land">Plots</option>
                    <option value="design">Designs</option>
                </select>
                <svg class="hs-select-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </div>

            {{-- Search --}}
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="text" id="filter-search" placeholder="Search title or location…" autocomplete="off">
            </div>

            {{-- Price Range --}}
            <select class="filter-select" id="filter-price">
                <option value="">Any Price</option>
                <option value="0-5000000">Under 5M RWF</option>
                <option value="5000000-20000000">5M – 20M RWF</option>
                <option value="20000000-50000000">20M – 50M RWF</option>
                <option value="50000000-999999999">50M+ RWF</option>
            </select>

            {{-- Sort --}}
            <select class="filter-select" id="filter-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="price-asc">Price ↑</option>
                <option value="price-desc">Price ↓</option>
            </select>

            {{-- Result Count --}}
            <span class="result-count" id="result-count">
                <strong id="visible-count">0</strong> properties
            </span>

            {{-- View Toggle --}}
            <div class="view-toggle">
                <button class="view-btn active" id="btn-grid" title="Grid view">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm0 9h7v7h-7v-7zM4 13h7v7H4v-7z" />
                    </svg>
                </button>
                <button class="view-btn" id="btn-list" title="List view">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 4h13v2H8V4zM4.5 6.5a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zM4.5 20a1 1 0 110-2 1 1 0 010 2zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
                    </svg>
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ── Properties Listing — grouped by tier ── --}}
<div class="container-lg pb-5">

    <div id="no-results" style="display:none">
        <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35M11 8v3m0 3h.01" />
        </svg> -->
        <h3>No properties found</h3>
        <p>Try adjusting your search or filters.</p>
    </div>

    @foreach($tiers as $tierKey => $tier)
    @php
    $tierHomes = $homes->filter(fn($h) => ($h->listingPackage->package_tier ?? 'basic') === $tierKey);
    $tierLands = $lands->filter(fn($l) => ($l->listingPackage->package_tier ?? 'basic') === $tierKey);
    $tierDesigns = $designs->filter(fn($d) => ($d->listingPackage->package_tier ?? 'basic') === $tierKey);
    $tierTotal = $tierHomes->count() + $tierLands->count() + $tierDesigns->count();
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
            <span class="tier-count" style="background: {{ $tier['bg'] }}; color: {{ $tier['color'] }}" id="tier-count-{{ $tierKey }}">
                {{ $tierTotal }} {{ Str::plural('listing', $tierTotal) }}
            </span>
        </div>

        {{-- Bootstrap Row for Cards --}}
        <div class="row props-row" id="tier-row-{{ $tierKey }}">

            {{-- HOMES in this tier --}}
            @foreach($tierHomes as $home)
            @php $imgSrc = $home->images->first()
            ? asset('image/houses/' . $home->images->first()->image_path)
            : asset('front/assets/img/all-images/properties/property-img1.png');
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12"
                data-type="home"
                data-tier="{{ $tierKey }}"
                data-title="{{ strtolower($home->title) }}"
                data-location="{{ strtolower($home->province . ' ' . $home->district . ' ' . $home->sector) }}"
                data-price="{{ $home->price }}"
                data-created="{{ $home->created_at->timestamp ?? 0 }}">
                <a href="{{ route('front.buy.home.details', $home) }}" class="prop-card">
                    <div class="card-img-wrap">
                        <span class="type-badge home">Home</span>
                        @if($home->condition)
                        <span class="cond-badge">{{ $home->condition }}</span>
                        @endif

                        @if( $home->status === 'sold' )
                        <span class="tier-badge" style="background:#e53e3e; color:#fff;">{{ $home->status }}</span>
                        @else
                        <span class="tier-badge" style="background:rgba(59,110,90,.85); color:#fff;">{{ ucfirst($home->status) }}</span>
                        @endif
                        @if($home->negotiable === 'negotiable')
                        <span class="badge-featured" style="background: #1E7A5A; color: #fff;">Negotiable</span>
                        @else
                        <span class="badge-featured" style="background: #e53e3e; color: #fff;">Non-Negotiable</span>
                        @endif
                        <img src="{{ $imgSrc }}" alt="{{ $home->title }}" loading="lazy">
                        <button class="wish-btn" onclick="event.preventDefault(); this.classList.toggle('active')">
                            <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra Real estate" style="width:20px; height:20px;">
                        </button>
                    </div>
                    <div class="card-body-custom">
                        <p class="card-title">{{ $home->title }}</p>
                        <p class="card-location">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            {{ Str::limit($home->sector . ', ' . $home->district, 36) }}
                        </p>
                        <div class="card-stats">
                            @if($home->bedrooms) <span class="stat-item">🛏 {{ $home->bedrooms }} bed</span> @endif
                            @if($home->bathrooms) <span class="stat-item">🚿 {{ $home->bathrooms }} bath</span> @endif
                            @if($home->area_sqft) <span class="stat-item">📐 {{ number_format($home->area_sqft) }} sq</span> @endif
                        </div>
                        <div class="card-footer-custom">
                            <p class="card-price">{{ number_format($home->price) }} <span>{{ $home->currency ?? 'RWF' }}</span></p>
                            <span class="card-cta">View <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg></span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

            {{-- LANDS in this tier --}}
            @foreach($tierLands as $land)
            @php $imgSrc = $land->images->first()
            ? asset('image/lands/' . $land->images->first()->image_path)
            : asset('front/assets/img/all-images/properties/property-img2.png');
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12"
                data-type="land"
                data-tier="{{ $tierKey }}"
                data-title="{{ strtolower($land->title) }}"
                data-location="{{ strtolower($land->sector . ' ' . $land->district . ' ' . $land->province) }}"
                data-price="{{ $land->price }}"
                data-created="{{ $land->created_at->timestamp ?? 0 }}">
                <a href="{{ route('front.buy.land.details', $land->id) }}" class="prop-card">
                    <div class="card-img-wrap">
                        <span class="type-badge land">Plot</span>
                        @if($land->land_use) <span class="cond-badge">{{ $land->land_use }}</span> @endif
                        @if($land->status === 'sold')
                        <span class="tier-badge" style="background:#e53e3e; color:#fff;">{{ $land->status }}</span>
                        @else
                        <span class="tier-badge" style="background:#1E7A5A; color:#fff;">{{ $land->status }}</span>
                        @endif
                        @if($land->negotiable === 'negotiable')
                        <span class="badge-featured" style="background: #1E7A5A; color: #fff;">Negotiable</span>
                        @else
                        <span class="badge-featured" style="background: #e53e3e; color: #fff;">Non-Negotiable</span>
                        @endif
                        <img src="{{ $imgSrc }}" alt="{{ $land->title }}" loading="lazy">
                        <button class="wish-btn" onclick="event.preventDefault(); this.classList.toggle('active')">
                            <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra Real estate" style="width:20px; height:20px;">
                        </button>
                    </div>
                    <div class="card-body-custom">
                        <p class="card-title">{{ $land->title }}</p>
                        <p class="card-location">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            {{ $land->sector }}, {{ $land->district }}
                        </p>
                        <div class="card-stats">
                            @if($land->zoning) <span class="stat-item">🌿 {{ $land->zoning }}</span> @endif
                            @if($land->size_sqm) <span class="stat-item">📐 {{ number_format($land->size_sqm) }} sqm</span> @endif
                        </div>
                        <div class="card-footer-custom">
                            <p class="card-price">{{ number_format($land->price) }} <span>{{ $land->currency }}</span></p>
                            <span class="card-cta">View <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg></span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

            {{-- DESIGNS in this tier --}}
            @foreach($tierDesigns as $design)
            @php $imgSrc = $design->images->first()
            ? asset('image/architectural_designs/images/' . $design->images->first()->image_path)
            : asset('front/assets/img/all-images/properties/property-img3.png');
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12"
                data-type="design"
                data-tier="{{ $tierKey }}"
                data-title="{{ strtolower($design->title) }}"
                data-location="{{ strtolower($design->category?->name ?? '') }}"
                data-price="{{ $design->price ?? 0 }}"
                data-created="{{ $design->created_at->timestamp ?? 0 }}"
                data-free="{{ $design->is_free ? '1' : '0' }}">
                <div class="prop-card h-100">
                    <div class="card-img-wrap">

                        {{-- Category badge --}}
                        <span class="tier-badge" style="background: #1E7A5A; color: #fff;">{{ $design->category?->name ?? 'Design' }}</span>

                        {{-- Free / Paid badge --}}
                        <!-- <span class="tier-badge" style="background:#1E7A5A; color:#fff;">
                            {{ $design->is_free ? 'Free' : number_format($design->price) . ' RWF' }}
                        </span> -->

                        {{-- Featured badge for standard tier --}}
                        @if($tierKey === 'standard')
                        <span class="tier-badge">⭐ Featured</span>
                        @endif

                        <img src="{{ $imgSrc }}" alt="{{ $design->title }}" loading="lazy">

                        <button class="wish-btn" onclick="event.preventDefault(); this.classList.toggle('active')">
                            <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra Real estate" style="width:20px; height:20px;">
                        </button>
                    </div>

                    <div class="card-body-custom">
                        <a href="{{ $design->is_free ? '#' : route('front.buy.design.show', $design->slug) }}" class="card-title">{{ $design->title }}</a>

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
                            <!-- price -->
                            @if($design->is_free)
                            <span class="card-price-free">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 14.5v.5a1 1 0 11-2 0v-.5a1 1 0 112 0zm-1-9a3 3 0 013 3h2a5 5 0 00-5-5v2zm0 0a3 3 0 00-3 3H8a5 5 0 015-5v2z" />
                                </svg>
                                Free
                            </span>
                            @else
                            <span class="card-price">
                                {{ number_format($design->price) }} RWF
                            </span>
                            @endif
                            <a href="{{ route('front.buy.design.show', $design->slug) }}"
                                onclick="event.stopPropagation()"
                                class="card-cta cta-buy">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM5.82 5H21v2l-2.27 4.54c-.27.53-.84.87-1.46.87H9.26L8.4 14H19v2H8c-1.32 0-2-.9-2-2.12l1.1-2.2L4 4H2V2h2.27L5.82 5z" />
                                </svg>
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>{{-- /row --}}
    </div>{{-- /tier-section --}}
    @endforeach

</div>{{-- /container --}}

<script>
    (function() {
        'use strict';

        const allCards = Array.from(document.querySelectorAll('[data-type]'));
        const searchInput = document.getElementById('filter-search');
        const categorySelect = document.getElementById('filter-category');
        const priceSelect = document.getElementById('filter-price');
        const sortSelect = document.getElementById('filter-sort');
        const btnGrid = document.getElementById('btn-grid');
        const btnList = document.getElementById('btn-list');
        const noResults = document.getElementById('no-results');
        const visibleCount = document.getElementById('visible-count');

        let state = {
            category: '',
            search: '',
            price: '',
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
            const category = state.category;

            let visible = allCards.filter(card => {
                if (category && card.dataset.type !== category) return false;
                if (q && !(card.dataset.title + ' ' + card.dataset.location).includes(q)) return false;
                if (state.price) {
                    const [min, max] = state.price.split('-').map(Number);
                    const p = Number(card.dataset.price);
                    if (p < min || p > max) return false;
                }
                return true;
            });

            // Sort within each tier to preserve tier grouping
            const tierOrder = {
                standard: 0,
                medium: 1,
                basic: 2
            };
            visible.sort((a, b) => {
                const tA = tierOrder[a.dataset.tier] ?? 9;
                const tB = tierOrder[b.dataset.tier] ?? 9;
                if (tA !== tB) return tA - tB;

                switch (state.sort) {
                    case 'price-asc':
                        return Number(a.dataset.price) - Number(b.dataset.price);
                    case 'price-desc':
                        return Number(b.dataset.price) - Number(a.dataset.price);
                    case 'oldest':
                        return Number(a.dataset.created) - Number(b.dataset.created);
                    default:
                        return Number(b.dataset.created) - Number(a.dataset.created);
                }
            });

            // Show/hide cards
            const visSet = new Set(visible);
            allCards.forEach(card => card.style.display = visSet.has(card) ? '' : 'none');

            // Update tier section visibility & counts
            ['standard', 'medium', 'basic'].forEach(tierKey => {
                const section = document.getElementById('tier-section-' + tierKey);
                const countEl = document.getElementById('tier-count-' + tierKey);
                const tierCards = visible.filter(c => c.dataset.tier === tierKey);
                if (section) section.classList.toggle('is-empty', tierCards.length === 0);
                if (countEl) countEl.textContent = tierCards.length + ' ' + (tierCards.length === 1 ? 'listing' : 'listings');
            });

            visibleCount.textContent = visible.length;
            noResults.style.display = visible.length === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', debounce(e => {
            state.search = e.target.value;
            applyFilters();
        }, 250));
        categorySelect.addEventListener('change', e => {
            state.category = e.target.value;
            applyFilters();
        });
        priceSelect.addEventListener('change', e => {
            state.price = e.target.value;
            applyFilters();
        });
        sortSelect.addEventListener('change', e => {
            state.sort = e.target.value;
            applyFilters();
        });

        btnGrid.addEventListener('click', () => {
            document.querySelectorAll('.props-row').forEach(row => row.classList.remove('list-view'));
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
            localStorage.setItem('propView', 'grid');
        });

        btnList.addEventListener('click', () => {
            document.querySelectorAll('.props-row').forEach(row => row.classList.add('list-view'));
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
            localStorage.setItem('propView', 'list');
        });

        if (localStorage.getItem('propView') === 'list') btnList.click();

        applyFilters();
    })();
</script>
@endsection