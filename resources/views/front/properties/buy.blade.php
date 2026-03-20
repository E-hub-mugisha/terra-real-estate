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
        transition: border-color var(--transition);
    }

    .search-wrap input:focus {
        outline: none;
        border-color: var(--clr-accent);
        background: #fff;
    }

    /* Type Tabs */
    .type-tabs {
        display: flex;
        gap: 4px;
    }

    .type-tab {
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

    .type-tab:hover {
        border-color: var(--clr-accent);
        color: var(--clr-accent);
    }

    .type-tab.active {
        background: var(--clr-accent);
        border-color: var(--clr-accent);
        color: #fff;
    }

    /* Selects */
    .filter-select {
        padding: 7px 30px 7px 12px;
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        font-size: .82rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--clr-text);
        background: var(--clr-bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237A736B' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 10px center no-repeat;
        appearance: none;
        cursor: pointer;
        transition: border-color var(--transition);
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--clr-accent);
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

    /* ── Section Label ── */
    .section-label {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 28px 0 16px;
    }

    .section-label h2 {
        font-family: 'DM Serif Display', serif;
        font-size: 1.1rem;
        font-weight: 400;
        color: var(--clr-text);
        margin: 0;
    }

    .section-label .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .section-label .count-badge {
        font-size: .78rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: 4px;
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
        height: 100%;
        text-decoration: none;
        color: inherit;
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

    /* ── Grid layout ── */
    .props-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 16px;
    }

    .props-grid.list-view {
        grid-template-columns: 1fr;
    }

    .props-grid.list-view .prop-card {
        flex-direction: row;
        max-height: 160px;
    }

    .props-grid.list-view .card-img-wrap {
        width: 200px;
        min-width: 200px;
        aspect-ratio: unset;
        flex-shrink: 0;
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

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .filter-bar .inner {
            gap: 8px;
        }

        .type-tabs {
            width: 100%;
            overflow-x: auto;
        }

        .view-toggle {
            margin-left: 0;
        }

        .props-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }

        .props-grid.list-view .card-img-wrap {
            width: 130px;
            min-width: 130px;
        }
    }
</style>

@section('content')

{{-- ── Page Header ── --}}
<div class="prop-header">
    <div class="container">
        <h1>Browse Properties</h1>
        <p>Homes, Plots & Architectural Designs across Rwanda</p>
        <div style="height:20px"></div>
    </div>
</div>

{{-- ── Sticky Filter Bar ── --}}
<div class="filter-bar">
    <div class="container">
        <div class="inner">

            {{-- Search --}}
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="text" id="filter-search" placeholder="Search title or location…" autocomplete="off">
            </div>

            {{-- Type Tabs --}}
            <div class="type-tabs">
                <button class="type-tab active" data-type="all">All</button>
                <button class="type-tab" data-type="home">🏠 Homes</button>
                <button class="type-tab" data-type="land">📐 Plots</button>
                <button class="type-tab" data-type="design">🏗 Designs</button>
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

{{-- ── Properties Listing ── --}}
<div class="container pb-5">

    {{-- All Properties Mixed Grid --}}
    <div class="section-label" id="all-section">
        <div class="dot" style="background: var(--clr-accent)"></div>
        <h2>All Properties</h2>
        <span class="count-badge" style="background:#FEF3E2; color:var(--clr-accent)" id="all-count-badge">{{ $homes->count() + $lands->count() + $designs->count() }}</span>
    </div>

    <div class="props-grid" id="props-grid">
        <div class="row">
            {{-- ── HOMES ── --}}
            @forelse($homes as $home)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route('front.buy.home.details', $home) }}">
                    <div class="prop-card"
                        data-type="home"
                        data-title="{{ strtolower($home->title) }}"
                        data-location="{{ strtolower($home->address) }}"
                        data-price="{{ $home->price }}"
                        data-created="{{ $home->created_at->timestamp ?? 0 }}">

                        <div class="card-img-wrap">
                            <span class="type-badge home">Home</span>
                            @if($home->condition)
                            <span class="cond-badge">{{ $home->condition }}</span>
                            @endif
                            <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}" alt="{{ $home->title }}" loading="lazy">
                            <button class="wish-btn" onclick="event.preventDefault(); toggleWish(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg>
                            </button>
                        </div>

                        <div class="card-body-custom">
                            <p class="card-title">{{ $home->title }}</p>
                            <p class="card-location">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                </svg>
                                {{ Str::limit($home->address, 40) }}
                            </p>
                            <div class="card-stats">
                                @if($home->bedrooms)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4a1 1 0 001 1h1v2h2v-2h12v2h2v-2h1a1 1 0 001-1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z" />
                                    </svg>
                                    {{ $home->bedrooms }} bed
                                </span>
                                @endif
                                @if($home->bathrooms)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z" />
                                    </svg>
                                    {{ $home->bathrooms }} bath
                                </span>
                                @endif
                                @if($home->area_sqft)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                                    </svg>
                                    {{ number_format($home->area_sqft) }} sq
                                </span>
                                @endif
                            </div>
                            <div class="card-footer-custom">
                                <p class="card-price">{{ number_format($home->price) }} <span>RWF</span></p>
                                <a href="{{ route('front.buy.home.details', $home) }}" class="card-cta">View
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            @endforelse

            {{-- ── LANDS ── --}}
            @forelse($lands as $land)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route('front.buy.land.details', $land->id) }}">
                    <div class="prop-card"
                        data-type="land"
                        data-title="{{ strtolower($land->title) }}"
                        data-location="{{ strtolower($land->sector . ' ' . $land->district . ' ' . $land->province) }}"
                        data-price="{{ $land->price }}"
                        data-created="{{ $land->created_at->timestamp ?? 0 }}">

                        <div class="card-img-wrap">
                            <span class="type-badge land">Plot</span>
                            @if($land->land_use)
                            <span class="cond-badge">{{ $land->land_use }}</span>
                            @endif
                            <img src="{{ asset('front/assets/img/all-images/properties/property-img2.png') }}" alt="{{ $land->title }}" loading="lazy">
                            <button class="wish-btn" onclick="event.preventDefault(); toggleWish(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg>
                            </button>
                        </div>

                        <div class="card-body-custom">
                            <p class="card-title">{{ $land->title }}</p>
                            <p class="card-location">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                                </svg>
                                {{ $land->sector }}, {{ $land->district }}, {{ $land->province }}
                            </p>
                            <div class="card-stats">
                                @if($land->zoning)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0-2-2-3-4-3-4z" />
                                    </svg>
                                    {{ $land->zoning }}
                                </span>
                                @endif
                                @if($land->size_sqm)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                                    </svg>
                                    {{ number_format($land->size_sqm) }} sqm
                                </span>
                                @endif
                            </div>
                            <div class="card-footer-custom">
                                <p class="card-price">{{ number_format($land->price) }} <span>RWF</span></p>
                                <span class="card-cta">View
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            @endforelse

            {{-- ── DESIGNS ── --}}
            @forelse($designs as $design)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route('front.buy.design.show', $design->slug) }}">
                    <div class="prop-card"
                        data-type="design"
                        data-title="{{ strtolower($design->title) }}"
                        data-location="{{ strtolower($design->category?->name ?? '') }}"
                        data-price="{{ $design->price ?? 0 }}"
                        data-created="{{ $design->created_at->timestamp ?? 0 }}"
                        data-free="{{ $design->is_free ? '1' : '0' }}">

                        <div class="card-img-wrap">
                            <span class="type-badge design">Design</span>
                            @if($design->category)
                            <span class="cond-badge">{{ $design->category->name }}</span>
                            @endif
                            @if($design->preview_image)
                            <img src="{{ asset('storage/'.$design->preview_image) }}" alt="{{ $design->title }}" loading="lazy">
                            @else
                            <img src="{{ asset('front/assets/img/all-images/properties/property-img3.png') }}" alt="{{ $design->title }}" loading="lazy">
                            @endif
                            <button class="wish-btn" onclick="event.preventDefault(); toggleWish(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z" />
                                </svg>
                            </button>
                        </div>

                        <div class="card-body-custom">
                            <p class="card-title">{{ $design->title }}</p>
                            <p class="card-location">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                </svg>
                                {{ $design->service->title ?? 'Architectural Design' }}
                            </p>
                            <div class="card-stats">
                                @if($design->is_free)
                                <span class="stat-item" style="color: var(--clr-home); font-weight:600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71L12 2z" />
                                    </svg>
                                    Free Download
                                </span>
                                @endif
                            </div>
                            <div class="card-footer-custom">
                                @if($design->is_free)
                                <p class="card-price" style="color: var(--clr-home)">Free</p>
                                <a href="{{ asset($design->design_file) }}" download class="card-cta" onclick="event.stopPropagation()">Download
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3" />
                                    </svg>
                                </a>
                                @else
                                <p class="card-price">{{ number_format($design->price ?? 0) }} <span>RWF</span></p>
                                <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="card-cta" onclick="event.stopPropagation()">Buy
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            @endforelse
        </div>
    </div>{{-- /props-grid --}}

    <div id="no-results">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35M11 8v3m0 3h.01" />
        </svg>
        <h3>No properties found</h3>
        <p>Try adjusting your search or filters.</p>
    </div>

</div>
{{-- /container --}}

<script>
    (function() {
        'use strict';

        /* ── Element refs ── */
        const grid = document.getElementById('props-grid');
        const allCards = Array.from(grid.querySelectorAll('.prop-card'));
        const searchInput = document.getElementById('filter-search');
        const priceSelect = document.getElementById('filter-price');
        const sortSelect = document.getElementById('filter-sort');
        const typeTabs = document.querySelectorAll('.type-tab');
        const btnGrid = document.getElementById('btn-grid');
        const btnList = document.getElementById('btn-list');
        const noResults = document.getElementById('no-results');
        const visibleCount = document.getElementById('visible-count');
        const allBadge = document.getElementById('all-count-badge');

        /* ── State ── */
        let state = {
            type: 'all',
            search: '',
            price: '',
            sort: 'newest'
        };

        /* ── Debounce ── */
        function debounce(fn, ms) {
            let t;
            return (...a) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...a), ms);
            };
        }

        /* ── Filter + Sort + Render ── */
        function applyFilters() {
            const q = state.search.trim().toLowerCase();
            const type = state.type;
            const price = state.price;

            /* 1. Filter */
            let visible = allCards.filter(card => {
                if (type !== 'all' && card.dataset.type !== type) return false;
                if (q) {
                    const hay = (card.dataset.title + ' ' + card.dataset.location);
                    if (!hay.includes(q)) return false;
                }
                if (price) {
                    const [min, max] = price.split('-').map(Number);
                    const p = Number(card.dataset.price);
                    if (p < min || p > max) return false;
                }
                return true;
            });

            /* 2. Sort */
            visible.sort((a, b) => {
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

            /* 3. DOM update */
            const visibleSet = new Set(visible);
            allCards.forEach(card => {
                card.style.display = visibleSet.has(card) ? '' : 'none';
            });

            /* Re-append in sorted order */
            visible.forEach(card => grid.appendChild(card));

            /* Count */
            visibleCount.textContent = visible.length;
            allBadge.textContent = visible.length;
            noResults.style.display = visible.length === 0 ? 'block' : 'none';
        }

        /* ── Event listeners ── */
        searchInput.addEventListener('input', debounce(e => {
            state.search = e.target.value;
            applyFilters();
        }, 250));

        priceSelect.addEventListener('change', e => {
            state.price = e.target.value;
            applyFilters();
        });

        sortSelect.addEventListener('change', e => {
            state.sort = e.target.value;
            applyFilters();
        });

        typeTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                typeTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                state.type = tab.dataset.type;
                applyFilters();
            });
        });

        /* ── View toggle ── */
        btnGrid.addEventListener('click', () => {
            grid.classList.remove('list-view');
            btnGrid.classList.add('active');
            btnList.classList.remove('active');
            localStorage.setItem('propView', 'grid');
        });
        btnList.addEventListener('click', () => {
            grid.classList.add('list-view');
            btnList.classList.add('active');
            btnGrid.classList.remove('active');
            localStorage.setItem('propView', 'list');
        });

        /* Restore view preference */
        if (localStorage.getItem('propView') === 'list') {
            btnList.click();
        }

        /* ── Wishlist toggle ── */
        window.toggleWish = function(btn) {
            btn.classList.toggle('active');
        };

        /* ── Init ── */
        applyFilters();

    })();
</script>
@endsection