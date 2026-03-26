@extends('layouts.guest')
@section('title', 'Properties for Rent')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap');

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
        --clr-rent-tag: #1a5276;
        --radius-card: 14px;
        --shadow-card: 0 2px 12px rgba(0,0,0,.07), 0 1px 3px rgba(0,0,0,.05);
        --shadow-hover: 0 8px 28px rgba(0,0,0,.13), 0 2px 6px rgba(0,0,0,.07);
        --transition: .22s cubic-bezier(.4,0,.2,1);
    }

    body {
        background: var(--clr-bg);
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Page Header ── */
    .prop-header {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 40px 0 0;
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

    /* ── Rent Banner Strip ── */
    .rent-strip {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 14px 0;
        border-top: 1px solid var(--clr-border);
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .rent-strip-item {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: .8rem;
        color: var(--clr-muted);
        font-weight: 500;
    }

    .rent-strip-item svg {
        width: 15px;
        height: 15px;
        color: var(--clr-accent);
    }

    /* ── Filter Bar ── */
    .filter-bar {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 14px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
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

    /* Advanced filter panel toggle */
    .adv-toggle {
        padding: 7px 12px;
        border-radius: 8px;
        border: 1.5px solid var(--clr-border);
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 500;
        color: var(--clr-muted);
        cursor: pointer;
        transition: all var(--transition);
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .adv-toggle svg { width: 14px; height: 14px; }
    .adv-toggle:hover, .adv-toggle.open {
        border-color: var(--clr-accent);
        color: var(--clr-accent);
        background: #FEF3E2;
    }

    .adv-toggle .badge-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--clr-accent);
        display: none;
    }

    .adv-toggle.has-filters .badge-dot { display: block; }

    /* Advanced filter panel */
    .adv-panel {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height .3s ease, padding .3s ease;
    }

    .adv-panel.open {
        max-height: 200px;
        padding: 16px 0;
    }

    .adv-panel .inner {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .adv-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .adv-group label {
        font-size: .75rem;
        font-weight: 600;
        color: var(--clr-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .adv-reset {
        padding: 7px 14px;
        border-radius: 8px;
        border: 1.5px solid var(--clr-border);
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        color: var(--clr-muted);
        cursor: pointer;
        transition: all var(--transition);
        margin-left: auto;
    }

    .adv-reset:hover {
        border-color: #e53e3e;
        color: #e53e3e;
    }

    .view-toggle {
        display: flex;
        gap: 4px;
        margin-left: auto;
    }

    .view-btn {
        width: 34px; height: 34px;
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        background: transparent;
        display: grid;
        place-items: center;
        cursor: pointer;
        color: var(--clr-muted);
        transition: all var(--transition);
    }

    .view-btn.active, .view-btn:hover {
        background: var(--clr-accent);
        border-color: var(--clr-accent);
        color: #fff;
    }

    .view-btn svg { width: 16px; height: 16px; }

    .result-count {
        font-size: .82rem;
        color: var(--clr-muted);
        white-space: nowrap;
    }

    .result-count strong { color: var(--clr-text); }

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
        width: 8px; height: 8px;
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

    .prop-card:hover .card-img-wrap img { transform: scale(1.06); }

    .type-badge {
        position: absolute;
        top: 10px; left: 10px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #fff;
        z-index: 2;
    }

    .type-badge.home { background: var(--clr-home); }
    .type-badge.land { background: var(--clr-land); }

    /* Rent pill overlay */
    .rent-pill {
        position: absolute;
        bottom: 10px;
        left: 10px;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: .7rem;
        font-weight: 700;
        background: var(--clr-rent-tag);
        color: #fff;
        letter-spacing: .06em;
        text-transform: uppercase;
        z-index: 2;
    }

    .cond-badge {
        position: absolute;
        top: 10px; right: 10px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 500;
        background: rgba(255,255,255,.9);
        backdrop-filter: blur(4px);
        color: var(--clr-text);
        z-index: 2;
    }

    .wish-btn {
        position: absolute;
        bottom: 10px; right: 10px;
        width: 32px; height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,.9);
        backdrop-filter: blur(4px);
        border: none;
        display: grid;
        place-items: center;
        cursor: pointer;
        z-index: 2;
        transition: background var(--transition);
    }

    .wish-btn:hover { background: #fff; }
    .wish-btn svg { width: 15px; height: 15px; color: var(--clr-muted); }
    .wish-btn.active svg { color: #e53e3e; fill: #e53e3e; }

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

    .card-location svg { width: 12px; height: 12px; flex-shrink: 0; }

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

    .stat-item svg { width: 14px; height: 14px; }

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
        line-height: 1.2;
    }

    .card-price span {
        font-size: .72rem;
        font-weight: 500;
        color: var(--clr-muted);
        margin-left: 2px;
    }

    .card-price .per-period {
        display: block;
        font-size: .7rem;
        font-weight: 500;
        color: var(--clr-muted);
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

    .card-cta svg { width: 14px; height: 14px; }

    /* ── Grid layout ── */
    .props-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 16px;
    }

    .props-grid.list-view { grid-template-columns: 1fr; }

    .props-grid.list-view .prop-card {
        flex-direction: row;
        max-height: 170px;
    }

    .props-grid.list-view .card-img-wrap {
        width: 220px;
        min-width: 220px;
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
        width: 48px; height: 48px;
        margin-bottom: 16px;
        opacity: .4;
    }

    .empty-state h3 { font-size: 1rem; color: var(--clr-text); margin-bottom: 6px; }
    .empty-state p { font-size: .85rem; }

    #no-results {
        display: none;
        padding: 48px;
        text-align: center;
        color: var(--clr-muted);
        font-size: .9rem;
    }

    /* ── Animate in ── */
    .prop-card { animation: fadeUp .35s ease both; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .filter-bar .inner { gap: 8px; }
        .type-tabs { width: 100%; overflow-x: auto; }
        .view-toggle { margin-left: 0; }
        .props-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
        .props-grid.list-view .card-img-wrap { width: 130px; min-width: 130px; }
        .adv-panel.open { max-height: 400px; }
    }
</style>

@section('content')

{{-- ── Page Header ── --}}
<div class="prop-header">
    <div class="container">
        <h1>Properties for Rent</h1>
        <p>Houses &amp; Plots available for rent across Rwanda</p>

        {{-- Info strip --}}
        <div class="rent-strip">
            <div class="rent-strip-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                </svg>
                All Districts
            </div>
            <div class="rent-strip-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 1a11 11 0 100 22A11 11 0 0012 1zm1 17h-2v-6h2v6zm0-8h-2V8h2v2z"/>
                </svg>
                Verified Listings
            </div>
            <div class="rent-strip-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 18v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1h-9a2 2 0 00-2 2v8a2 2 0 002 2h9zm-9-2h10V8H12v8zm4-2.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                </svg>
                Monthly &amp; Annual Terms
            </div>
            <div class="rent-strip-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Houses &amp; Plots
            </div>
        </div>
    </div>
</div>

{{-- ── Sticky Filter Bar ── --}}
<div class="filter-bar">
    <div class="container">
        <div class="inner">

            {{-- Search --}}
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" id="filter-search" placeholder="Title, district, sector…" autocomplete="off">
            </div>

            {{-- Type Tabs --}}
            <div class="type-tabs">
                <button class="type-tab active" data-type="all">All</button>
                <button class="type-tab" data-type="home">🏠 Houses</button>
                <button class="type-tab" data-type="land">📐 Plots</button>
            </div>

            {{-- Rent Period --}}
            <select class="filter-select" id="filter-period">
                <option value="">Any Period</option>
                <option value="monthly">Monthly</option>
                <option value="annual">Annual</option>
            </select>

            {{-- Price Range --}}
            <select class="filter-select" id="filter-price">
                <option value="">Any Price</option>
                <option value="0-100000">Under 100K RWF</option>
                <option value="100000-300000">100K – 300K RWF</option>
                <option value="300000-600000">300K – 600K RWF</option>
                <option value="600000-1000000">600K – 1M RWF</option>
                <option value="1000000-999999999">1M+ RWF</option>
            </select>

            {{-- Sort --}}
            <select class="filter-select" id="filter-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="price-asc">Price ↑</option>
                <option value="price-desc">Price ↓</option>
            </select>

            {{-- Advanced Filters toggle --}}
            <button class="adv-toggle" id="adv-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="8" y1="12" x2="20" y2="12"/>
                    <line x1="12" y1="18" x2="20" y2="18"/>
                </svg>
                Filters
                <span class="badge-dot"></span>
            </button>

            {{-- Result Count --}}
            <span class="result-count" id="result-count">
                <strong id="visible-count">0</strong> listings
            </span>

            {{-- View Toggle --}}
            <div class="view-toggle">
                <button class="view-btn active" id="btn-grid" title="Grid view">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm0 9h7v7h-7v-7zM4 13h7v7H4v-7z"/>
                    </svg>
                </button>
                <button class="view-btn" id="btn-list" title="List view">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 4h13v2H8V4zM4.5 6.5a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zM4.5 20a1 1 0 110-2 1 1 0 010 2zM8 11h13v2H8v-2zm0 7h13v2H8v-2z"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ── Advanced Filter Panel ── --}}
<div class="adv-panel" id="adv-panel">
    <div class="container">
        <div class="inner">

            {{-- Bedrooms (houses only) --}}
            <div class="adv-group">
                <label>Bedrooms</label>
                <select class="filter-select" id="filter-beds">
                    <option value="">Any</option>
                    <option value="1">1+</option>
                    <option value="2">2+</option>
                    <option value="3">3+</option>
                    <option value="4">4+</option>
                </select>
            </div>

            {{-- Furnished --}}
            <div class="adv-group">
                <label>Furnished</label>
                <select class="filter-select" id="filter-furnished">
                    <option value="">Any</option>
                    <option value="furnished">Furnished</option>
                    <option value="unfurnished">Unfurnished</option>
                    <option value="semi-furnished">Semi-Furnished</option>
                </select>
            </div>

            {{-- Province --}}
            <div class="adv-group">
                <label>Province</label>
                <select class="filter-select" id="filter-province">
                    <option value="">All Provinces</option>
                    <option value="kigali">Kigali</option>
                    <option value="northern">Northern</option>
                    <option value="southern">Southern</option>
                    <option value="eastern">Eastern</option>
                    <option value="western">Western</option>
                </select>
            </div>

            {{-- Min Size (sqm for land) --}}
            <div class="adv-group">
                <label>Min Size (sqm)</label>
                <select class="filter-select" id="filter-size">
                    <option value="">Any Size</option>
                    <option value="50">50+</option>
                    <option value="100">100+</option>
                    <option value="300">300+</option>
                    <option value="500">500+</option>
                    <option value="1000">1000+</option>
                </select>
            </div>

            {{-- Availability --}}
            <div class="adv-group">
                <label>Availability</label>
                <select class="filter-select" id="filter-availability">
                    <option value="">Any</option>
                    <option value="available">Available Now</option>
                    <option value="soon">Available Soon</option>
                </select>
            </div>

            <button class="adv-reset" id="adv-reset">✕ Reset All</button>
        </div>
    </div>
</div>

{{-- ── Properties Listing ── --}}
<div class="container pb-5">

    <div class="section-label" id="all-section">
        <div class="dot" style="background: var(--clr-rent-tag)"></div>
        <h2>All Rentals</h2>
        <span class="count-badge" style="background:#EBF5FB; color:var(--clr-rent-tag)" id="all-count-badge">
            {{ ($rentHomes->count() ?? 0) + ($rentLands->count() ?? 0) }}
        </span>
    </div>

    <div class="props-grid" id="props-grid">
        <div class="row">

            {{-- ── RENT HOUSES ── --}}
            @forelse($rentHomes as $home)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route('front.buy.home.details', $home) }}">
                    <div class="prop-card"
                        data-type="home"
                        data-title="{{ strtolower($home->title) }}"
                        data-location="{{ strtolower($home->address . ' ' . ($home->province ?? '')) }}"
                        data-price="{{ $home->rent_price }}"
                        data-period="{{ strtolower($home->rent_period ?? '') }}"
                        data-beds="{{ $home->bedrooms ?? 0 }}"
                        data-furnished="{{ strtolower($home->furnished_status ?? '') }}"
                        data-province="{{ strtolower($home->province ?? '') }}"
                        data-size="{{ $home->area_sqft ?? 0 }}"
                        data-availability="{{ strtolower($home->availability ?? 'available') }}"
                        data-created="{{ $home->created_at->timestamp ?? 0 }}">

                        <div class="card-img-wrap">
                            <span class="type-badge home">House</span>
                            @if($home->condition)
                            <span class="cond-badge">{{ $home->condition }}</span>
                            @endif
                            <span class="rent-pill">For Rent</span>
                            <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}"
                                alt="{{ $home->title }}" loading="lazy">
                            <button class="wish-btn" onclick="event.preventDefault(); toggleWish(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body-custom">
                            <p class="card-title">{{ $home->title }}</p>
                            <p class="card-location">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                {{ Str::limit($home->address, 40) }}
                            </p>
                            <div class="card-stats">
                                @if($home->bedrooms)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4a1 1 0 001 1h1v2h2v-2h12v2h2v-2h1a1 1 0 001-1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z"/>
                                    </svg>
                                    {{ $home->bedrooms }} bed
                                </span>
                                @endif
                                @if($home->bathrooms)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z"/>
                                    </svg>
                                    {{ $home->bathrooms }} bath
                                </span>
                                @endif
                                @if($home->area_sqft)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/>
                                    </svg>
                                    {{ number_format($home->area_sqft) }} sq
                                </span>
                                @endif
                                @if($home->furnished_status)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20 10V7a2 2 0 00-2-2H6a2 2 0 00-2 2v3a2 2 0 00-2 2v5h1.33L4 19h1l.67-2h12.66L19 19h1l-.33-2H21v-5a2 2 0 00-2-2z"/>
                                    </svg>
                                    {{ $home->furnished_status }}
                                </span>
                                @endif
                            </div>
                            <div class="card-footer-custom">
                                <p class="card-price">
                                    {{ number_format($home->rent_price) }} <span>RWF</span>
                                    <span class="per-period">/ {{ $home->rent_period ?? 'month' }}</span>
                                </p>
                                <a href="{{ route('front.buy.home.details', $home) }}" class="card-cta">View
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            @endforelse

            {{-- ── RENT LANDS ── --}}
            @forelse($rentLands as $land)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="{{ route('front.buy.land.details', $land->id) }}">
                    <div class="prop-card"
                        data-type="land"
                        data-title="{{ strtolower($land->title) }}"
                        data-location="{{ strtolower($land->sector . ' ' . $land->district . ' ' . $land->province) }}"
                        data-price="{{ $land->rent_price }}"
                        data-period="{{ strtolower($land->rent_period ?? '') }}"
                        data-beds="0"
                        data-furnished=""
                        data-province="{{ strtolower($land->province ?? '') }}"
                        data-size="{{ $land->size_sqm ?? 0 }}"
                        data-availability="{{ strtolower($land->availability ?? 'available') }}"
                        data-created="{{ $land->created_at->timestamp ?? 0 }}">

                        <div class="card-img-wrap">
                            <span class="type-badge land">Plot</span>
                            @if($land->land_use)
                            <span class="cond-badge">{{ $land->land_use }}</span>
                            @endif
                            <span class="rent-pill">For Rent</span>
                            <img src="{{ asset('front/assets/img/all-images/properties/property-img2.png') }}"
                                alt="{{ $land->title }}" loading="lazy">
                            <button class="wish-btn" onclick="event.preventDefault(); toggleWish(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="card-body-custom">
                            <p class="card-title">{{ $land->title }}</p>
                            <p class="card-location">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                {{ $land->sector }}, {{ $land->district }}, {{ $land->province }}
                            </p>
                            <div class="card-stats">
                                @if($land->zoning)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0-2-2-3-4-3-4z"/>
                                    </svg>
                                    {{ $land->zoning }}
                                </span>
                                @endif
                                @if($land->size_sqm)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/>
                                    </svg>
                                    {{ number_format($land->size_sqm) }} sqm
                                </span>
                                @endif
                                @if($land->land_use)
                                <span class="stat-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 3L2 12h3v8h6v-5h2v5h6v-8h3L12 3z"/>
                                    </svg>
                                    {{ $land->land_use }}
                                </span>
                                @endif
                            </div>
                            <div class="card-footer-custom">
                                <p class="card-price">
                                    {{ number_format($land->rent_price) }} <span>RWF</span>
                                    <span class="per-period">/ {{ $land->rent_period ?? 'month' }}</span>
                                </p>
                                <a href="{{ route('front.buy.land.details', $land->id) }}" class="card-cta">View
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </a>
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
            <circle cx="11" cy="11" r="8"/>
            <path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/>
        </svg>
        <h3>No rentals found</h3>
        <p>Try adjusting your search or filters.</p>
    </div>

</div>

<script>
(function () {
    'use strict';

    /* ── Refs ── */
    const grid         = document.getElementById('props-grid');
    const allCards     = Array.from(grid.querySelectorAll('.prop-card'));
    const searchInput  = document.getElementById('filter-search');
    const priceSelect  = document.getElementById('filter-price');
    const sortSelect   = document.getElementById('filter-sort');
    const periodSelect = document.getElementById('filter-period');
    const bedsSelect   = document.getElementById('filter-beds');
    const furnSelect   = document.getElementById('filter-furnished');
    const provSelect   = document.getElementById('filter-province');
    const sizeSelect   = document.getElementById('filter-size');
    const availSelect  = document.getElementById('filter-availability');
    const typeTabs     = document.querySelectorAll('.type-tab');
    const btnGrid      = document.getElementById('btn-grid');
    const btnList      = document.getElementById('btn-list');
    const noResults    = document.getElementById('no-results');
    const visibleCount = document.getElementById('visible-count');
    const allBadge     = document.getElementById('all-count-badge');
    const advToggle    = document.getElementById('adv-toggle');
    const advPanel     = document.getElementById('adv-panel');
    const advReset     = document.getElementById('adv-reset');

    /* ── State ── */
    let state = {
        type:         'all',
        search:       '',
        price:        '',
        sort:         'newest',
        period:       '',
        beds:         '',
        furnished:    '',
        province:     '',
        size:         '',
        availability: ''
    };

    /* ── Debounce ── */
    function debounce(fn, ms) {
        let t;
        return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); };
    }

    /* ── Check if advanced filters are active ── */
    function hasAdvancedFilters() {
        return state.period || state.beds || state.furnished ||
               state.province || state.size || state.availability;
    }

    /* ── Filter + Sort + Render ── */
    function applyFilters() {
        const q     = state.search.trim().toLowerCase();
        const type  = state.type;
        const price = state.price;

        let visible = allCards.filter(card => {
            const d = card.dataset;

            /* Type */
            if (type !== 'all' && d.type !== type) return false;

            /* Search */
            if (q) {
                const hay = d.title + ' ' + d.location;
                if (!hay.includes(q)) return false;
            }

            /* Price range */
            if (price) {
                const [min, max] = price.split('-').map(Number);
                const p = Number(d.price);
                if (p < min || p > max) return false;
            }

            /* Rent period */
            if (state.period && d.period && !d.period.includes(state.period)) return false;

            /* Bedrooms */
            if (state.beds) {
                const beds = Number(d.beds);
                if (beds < Number(state.beds)) return false;
            }

            /* Furnished */
            if (state.furnished && d.furnished && !d.furnished.includes(state.furnished)) return false;

            /* Province */
            if (state.province && d.province && !d.province.includes(state.province)) return false;

            /* Min size */
            if (state.size) {
                const sz = Number(d.size);
                if (sz < Number(state.size)) return false;
            }

            /* Availability */
            if (state.availability && d.availability && !d.availability.includes(state.availability)) return false;

            return true;
        });

        /* Sort */
        visible.sort((a, b) => {
            switch (state.sort) {
                case 'price-asc':  return Number(a.dataset.price) - Number(b.dataset.price);
                case 'price-desc': return Number(b.dataset.price) - Number(a.dataset.price);
                case 'oldest':     return Number(a.dataset.created) - Number(b.dataset.created);
                default:           return Number(b.dataset.created) - Number(a.dataset.created);
            }
        });

        /* DOM update */
        const visibleSet = new Set(visible);
        allCards.forEach(card => { card.style.display = visibleSet.has(card) ? '' : 'none'; });
        visible.forEach(card => grid.appendChild(card));

        visibleCount.textContent = visible.length;
        allBadge.textContent     = visible.length;
        noResults.style.display  = visible.length === 0 ? 'block' : 'none';

        /* Advanced filter badge dot */
        advToggle.classList.toggle('has-filters', !!hasAdvancedFilters());
    }

    /* ── Event Listeners ── */
    searchInput.addEventListener('input', debounce(e => { state.search = e.target.value; applyFilters(); }, 250));
    priceSelect.addEventListener('change', e  => { state.price         = e.target.value; applyFilters(); });
    sortSelect.addEventListener('change', e   => { state.sort          = e.target.value; applyFilters(); });
    periodSelect.addEventListener('change', e => { state.period        = e.target.value; applyFilters(); });
    bedsSelect.addEventListener('change', e   => { state.beds          = e.target.value; applyFilters(); });
    furnSelect.addEventListener('change', e   => { state.furnished     = e.target.value; applyFilters(); });
    provSelect.addEventListener('change', e   => { state.province      = e.target.value; applyFilters(); });
    sizeSelect.addEventListener('change', e   => { state.size          = e.target.value; applyFilters(); });
    availSelect.addEventListener('change', e  => { state.availability  = e.target.value; applyFilters(); });

    typeTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            typeTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            state.type = tab.dataset.type;
            applyFilters();
        });
    });

    /* Advanced panel toggle */
    advToggle.addEventListener('click', () => {
        const isOpen = advPanel.classList.toggle('open');
        advToggle.classList.toggle('open', isOpen);
    });

    /* Reset all advanced filters */
    advReset.addEventListener('click', () => {
        state.period = state.beds = state.furnished =
        state.province = state.size = state.availability = '';

        [periodSelect, bedsSelect, furnSelect, provSelect, sizeSelect, availSelect]
            .forEach(s => s.value = '');

        applyFilters();
    });

    /* ── View toggle ── */
    btnGrid.addEventListener('click', () => {
        grid.classList.remove('list-view');
        btnGrid.classList.add('active');
        btnList.classList.remove('active');
        localStorage.setItem('rentView', 'grid');
    });

    btnList.addEventListener('click', () => {
        grid.classList.add('list-view');
        btnList.classList.add('active');
        btnGrid.classList.remove('active');
        localStorage.setItem('rentView', 'list');
    });

    if (localStorage.getItem('rentView') === 'list') btnList.click();

    /* ── Wishlist ── */
    window.toggleWish = function (btn) { btn.classList.toggle('active'); };

    /* ── Init ── */
    applyFilters();
})();
</script>

@endsection