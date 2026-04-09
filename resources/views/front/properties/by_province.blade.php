@extends('layouts.guest')
@section('title', 'Properties in ' . $province)
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .15);
        --gold: #C8873A;
        --gold-bg: rgba(200, 135, 58, .08);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --green: #3B6E5A;
        --amber: #8B6914;
        --r: 13px;
        --t: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *, *::before, *::after { box-sizing: border-box; }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
    }

    a { text-decoration: none; color: inherit; }

    /* ── Page Hero ── */
    .pp-hero {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 52px 0 32px;
    }

    .pp-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .pp-eyebrow::before {
        content: '';
        width: 18px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .pp-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.7rem, 4vw, 2.8rem);
        font-weight: 500;
        letter-spacing: -.02em;
        color: var(--text);
        margin: 0;
    }

    .pp-hero h1 em { font-style: italic; color: var(--gold); }

    .pp-hero p {
        font-size: .85rem;
        color: var(--muted);
        margin-top: 6px;
    }

    .pp-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .pp-stat {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 12px;
        border-radius: 8px;
        background: var(--bg);
        border: 1px solid var(--border);
        font-size: .78rem;
        color: var(--muted);
    }

    .pp-stat svg { width: 13px; height: 13px; }

    .pp-stat.homes-stat {
        background: rgba(59, 110, 90, .07);
        border-color: rgba(59, 110, 90, .2);
        color: var(--green);
    }

    .pp-stat.lands-stat {
        background: rgba(139, 105, 20, .07);
        border-color: rgba(139, 105, 20, .2);
        color: var(--amber);
    }

    /* ── Sticky Filter Bar ── */
    .pp-filter {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 12px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }

    .pp-filter-inner {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pp-search {
        position: relative;
        flex: 1;
        min-width: 160px;
        max-width: 260px;
    }

    .pp-search svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        color: var(--dim);
    }

    .pp-search input {
        width: 100%;
        padding: 8px 12px 8px 30px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .82rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        transition: border-color var(--t);
    }

    .pp-search input:focus {
        outline: none;
        border-color: var(--gold);
        background: var(--surface);
    }

    .pp-search input::placeholder { color: var(--dim); }

    .pp-tabs { display: flex; gap: 4px; }

    .pp-tab {
        padding: 7px 13px;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .8rem;
        font-weight: 500;
        color: var(--muted);
        cursor: pointer;
        white-space: nowrap;
        transition: all var(--t);
    }

    .pp-tab:hover { border-color: var(--gold); color: var(--gold); }
    .pp-tab.on { background: var(--gold); border-color: var(--gold); color: #fff; }

    .pp-select {
        padding: 7px 28px 7px 11px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .8rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 8px center no-repeat;
        appearance: none;
        cursor: pointer;
        transition: border-color var(--t);
    }

    .pp-select:focus { outline: none; border-color: var(--gold); }

    .pp-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .pp-count { font-size: .78rem; color: var(--dim); white-space: nowrap; }
    .pp-count strong { color: var(--text); }

    .pp-view-btns { display: flex; gap: 4px; }

    .pp-vbtn {
        width: 32px;
        height: 32px;
        border-radius: 7px;
        border: 1.5px solid var(--border);
        background: transparent;
        display: grid;
        place-items: center;
        cursor: pointer;
        color: var(--dim);
        transition: all var(--t);
    }

    .pp-vbtn.on, .pp-vbtn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .pp-vbtn svg { width: 14px; height: 14px; }

    /* ── Results bar ── */
    .pp-results-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 28px 0 18px;
    }

    .pp-section-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .pp-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 500;
        color: var(--text);
        margin: 0;
    }

    .pp-section-badge {
        padding: 2px 8px;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 600;
        background: var(--gold-bg);
        color: var(--gold);
        border: 1px solid var(--gold-bd);
    }

    /* ── Tier Header ── */
    .tier-separator {
        width: 100%;
        margin-top: 32px;
    }

    .tier-separator:first-child { margin-top: 0; }

    .tier-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px 0 16px;
        border-bottom: 2px solid var(--border);
        margin-bottom: 20px;
        width: 100%;
    }

    .tier-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .tier-icon svg { width: 18px; height: 18px; }

    .tier-label {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.15rem;
        font-weight: 500;
        color: var(--text);
        margin: 0;
    }

    .tier-desc {
        font-size: .78rem;
        color: var(--muted);
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

    /* ── Property Card ── */
    .pp-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform var(--t), box-shadow var(--t), border-color var(--t);
        animation: ppFu .35s ease both;
        color: var(--text);
    }

    .pp-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 28px rgba(0,0,0,.1), 0 0 0 1px rgba(200,135,58,.1);
        border-color: var(--gold-bd);
        color: var(--text);
    }

    @keyframes ppFu {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .pp-card-img {
        position: relative;
        aspect-ratio: 16/10;
        overflow: hidden;
        background: var(--bg);
        flex-shrink: 0;
    }

    .pp-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease;
    }

    .pp-card:hover .pp-card-img img { transform: scale(1.06); }

    .pp-type-badge {
        position: absolute;
        top: 9px;
        left: 9px;
        padding: 2px 8px;
        border-radius: 6px;
        z-index: 2;
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #fff;
    }

    .pp-type-badge.home { background: var(--green); }
    .pp-type-badge.land { background: var(--amber); }

    .pp-cond-badge {
        position: absolute;
        top: 9px;
        right: 9px;
        padding: 2px 8px;
        border-radius: 6px;
        z-index: 2;
        font-size: .66rem;
        font-weight: 500;
        background: rgba(255,255,255,.88);
        color: var(--text);
        backdrop-filter: blur(4px);
    }

    /* Tier badge on card image */
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
        border: 1px solid rgba(255,255,255,.25);
        color: #fff;
    }

    .pp-wish {
        position: absolute;
        bottom: 9px;
        right: 9px;
        z-index: 2;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(255,255,255,.88);
        border: none;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background var(--t);
    }

    .pp-wish:hover { background: #fff; }
    .pp-wish svg { width: 13px; height: 13px; color: var(--dim); }
    .pp-wish.active svg { color: #e53e3e; fill: #e53e3e; }

    .pp-card-body {
        padding: 13px 15px 15px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }

    .pp-card-title {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text);
        margin: 0;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pp-card-loc {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .75rem;
        color: var(--muted);
    }

    .pp-card-loc svg { width: 11px; height: 11px; color: var(--gold); flex-shrink: 0; }

    .pp-card-stats { display: flex; gap: 10px; flex-wrap: wrap; }

    .pp-stat-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .74rem;
        color: var(--muted);
        font-weight: 500;
    }

    .pp-stat-item svg { width: 12px; height: 12px; }

    .pp-card-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 9px;
        border-top: 1px solid var(--border);
        margin-top: auto;
    }

    .pp-card-price { font-size: .92rem; font-weight: 700; color: var(--gold); margin: 0; }
    .pp-card-price span { font-size: .7rem; font-weight: 400; color: var(--dim); margin-left: 2px; }

    .pp-card-cta {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .75rem;
        font-weight: 600;
        color: var(--gold);
        transition: gap var(--t);
    }

    .pp-card-cta:hover { gap: 8px; color: #a06828; }
    .pp-card-cta svg { width: 12px; height: 12px; }

    /* ── List view ── */
    .tier-row.list-v .col-xl-3,
    .tier-row.list-v .col-lg-4,
    .tier-row.list-v .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .tier-row.list-v .pp-card {
        flex-direction: row;
        max-height: 150px;
    }

    .tier-row.list-v .pp-card-img {
        width: 180px;
        min-width: 180px;
        aspect-ratio: unset;
        flex-shrink: 0;
    }

    .tier-row.list-v .pp-card-body { padding: 11px 14px; }

    @media (max-width: 480px) {
        .tier-row.list-v .pp-card-img { width: 120px; min-width: 120px; }
    }

    /* ── Empty state ── */
    .pp-empty {
        text-align: center;
        padding: 64px 20px;
        color: var(--dim);
    }

    .pp-empty svg { width: 44px; height: 44px; margin-bottom: 14px; opacity: .35; }
    .pp-empty h3 { font-size: .95rem; color: var(--muted); margin-bottom: 6px; }
    .pp-empty p { font-size: .82rem; }

    @media (max-width: 640px) {
        .pp-tabs { overflow-x: auto; }
        .pp-meta { margin-left: 0; }
    }
</style>

{{-- ── Hero ── --}}
<div class="pp-hero">
    <div class="container">
        <div class="pp-eyebrow">Browse by Location</div>
        <h1>Properties in <em>{{ $province }}</em></h1>
        <p>All available homes and plots listed in this location.</p>

        <div class="pp-stats">
            <span class="pp-stat homes-stat">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
                {{ $homes->count() }} {{ Str::plural('House', $homes->count()) }}
            </span>
            <span class="pp-stat lands-stat">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5z"/>
                </svg>
                {{ $lands->count() }} {{ Str::plural('Plot', $lands->count()) }}
            </span>
        </div>
    </div>
</div>

{{-- ── Filter Bar ── --}}
<div class="pp-filter">
    <div class="container">
        <div class="pp-filter-inner">

            <div class="pp-search">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" id="pp-q" placeholder="Search title or location…" autocomplete="off">
            </div>

            <div class="pp-tabs">
                <button class="pp-tab on" data-t="all">All</button>
                <button class="pp-tab" data-t="home">🏠 Homes</button>
                <button class="pp-tab" data-t="land">📐 Plots</button>
            </div>

            <select class="pp-select" id="pp-price">
                <option value="">Any Price</option>
                <option value="0-5000000">Under 5M RWF</option>
                <option value="5000000-20000000">5M – 20M RWF</option>
                <option value="20000000-50000000">20M – 50M RWF</option>
                <option value="50000000-999999999">50M+ RWF</option>
            </select>

            <select class="pp-select" id="pp-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="price-asc">Price ↑</option>
                <option value="price-desc">Price ↓</option>
            </select>

            <div class="pp-meta">
                <span class="pp-count"><strong id="pp-count">0</strong> properties</span>
                <div class="pp-view-btns">
                    <button class="pp-vbtn on" id="pp-grid-btn" title="Grid">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm0 9h7v7h-7v-7zM4 13h7v7H4v-7z"/>
                        </svg>
                    </button>
                    <button class="pp-vbtn" id="pp-list-btn" title="List">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 4h13v2H8V4zM4.5 6.5a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zM4.5 20a1 1 0 110-2 1 1 0 010 2zM8 11h13v2H8v-2zm0 7h13v2H8v-2z"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Main Content ── --}}
<div class="container pb-5">

    @if($homes->isEmpty() && $lands->isEmpty())

        {{-- Global empty state — no listings at all --}}
        <div class="pp-empty mt-4">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
            <h3>No properties found in {{ $province }}</h3>
            <p>Check back soon — new listings are added regularly.</p>
        </div>

    @else

        {{-- Results bar --}}
        <div class="pp-results-bar">
            <div class="pp-section-dot" style="background:var(--gold)"></div>
            <h2 class="pp-section-title">All Properties</h2>
            <span class="pp-section-badge" id="pp-badge">{{ $homes->count() + $lands->count() }}</span>
        </div>

        {{-- ── Single filterable wrapper ── --}}
        <div id="pp-grid">

            @foreach($tiers as $tierKey => $tier)
            @php
                $tierHomes = $homes->filter(fn($h) => ($h->listingPackage->package_tier ?? 'basic') === $tierKey);
                $tierLands = $lands->filter(fn($l) => ($l->listingPackage->package_tier ?? 'basic') === $tierKey);
                $tierTotal = $tierHomes->count() + $tierLands->count();
            @endphp

            {{-- Skip tiers that have zero listings entirely --}}
            @if($tierTotal === 0)
                @continue
            @endif

            {{-- Tier separator — hidden by JS when all its cards are filtered out --}}
            <div class="tier-separator" data-tier-sep="{{ $tierKey }}">
                <div class="tier-header">
                    <div class="tier-divider" style="background:{{ $tier['color'] }}"></div>
                    <div class="tier-icon" style="background:{{ $tier['bg'] }};color:{{ $tier['color'] }}">
                        @if($tier['icon'] === 'star')
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        @elseif($tier['icon'] === 'trending')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                        @else
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 6h13v2H8V6zm-5-.5h2v2H3v-2zm0 7h2v2H3v-2zm0 7h2v2H3v-2zM8 13h13v2H8v-2zm0 7h13v2H8v-2z"/></svg>
                        @endif
                    </div>
                    <div>
                        <p class="tier-label">{{ $tier['label'] }}</p>
                        <p class="tier-desc">{{ $tier['description'] }}</p>
                    </div>
                    <span class="tier-count"
                          id="tier-count-{{ $tierKey }}"
                          style="background:{{ $tier['bg'] }};color:{{ $tier['color'] }}">
                        <span class="tier-count-num">{{ $tierTotal }}</span>&nbsp;{{ Str::plural('listing', $tierTotal) }}
                    </span>
                </div>
            </div>

            {{-- Cards row for this tier --}}
            <div class="row g-3 mb-5 tier-row" data-tier-row="{{ $tierKey }}">

                {{-- HOMES in this tier --}}
                @foreach($tierHomes as $i => $home)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12"
                     style="animation-delay:{{ $i * 0.04 }}s">
                    <a href="{{ route('front.buy.home.details', $home) }}"
                       class="pp-card d-flex"
                       data-type="home"
                       data-tier="{{ $tierKey }}"
                       data-title="{{ strtolower($home->title) }}"
                       data-location="{{ strtolower($home->address) }}"
                       data-price="{{ $home->price }}"
                       data-created="{{ $home->created_at->timestamp ?? 0 }}">

                        <div class="pp-card-img">
                            <span class="pp-type-badge home">Home</span>
                            @if($home->condition)
                                <span class="pp-cond-badge">{{ $home->condition }}</span>
                            @endif
                            @if($tierKey !== 'basic')
                                <span class="tier-badge" style="background:{{ $tier['color'] }}">
                                    {{ $tier['label'] }}
                                </span>
                            @endif
                            @if($home->images->first())
                                <img src="{{ asset('image/houses/') }}/{{ $home->images->first()->image_path }}"
                                     alt="{{ $home->title }}" loading="lazy">
                            @else
                                <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}"
                                     alt="{{ $home->title }}" loading="lazy">
                            @endif
                            <button class="wish-btn" onclick="event.preventDefault(); this.classList.toggle('active')">
                                <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra Real estate" style="width:20px; height:20px;">
                            </button>
                        </div>

                        <div class="pp-card-body">
                            <p class="pp-card-title">{{ $home->title }}</p>
                            <div class="pp-card-loc">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                </svg>
                                {{ Str::limit($home->address, 38) }}
                            </div>
                            <div class="pp-card-stats">
                                @if($home->bedrooms)
                                    <span class="pp-stat-item">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z"/></svg>
                                        {{ $home->bedrooms }}bd
                                    </span>
                                @endif
                                @if($home->bathrooms)
                                    <span class="pp-stat-item">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z"/></svg>
                                        {{ $home->bathrooms }}ba
                                    </span>
                                @endif
                                @if($home->area_sqft)
                                    <span class="pp-stat-item">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg>
                                        {{ number_format($home->area_sqft) }}sq
                                    </span>
                                @endif
                            </div>
                            <div class="pp-card-foot">
                                <p class="pp-card-price">{{ number_format($home->price) }}<span> RWF</span></p>
                                <span class="pp-card-cta">View
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

                {{-- LANDS in this tier --}}
                @foreach($tierLands as $i => $land)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12"
                     style="animation-delay:{{ ($tierHomes->count() + $i) * 0.04 }}s">
                    <a href="{{ route('front.buy.land.details', $land->id) }}"
                       class="pp-card d-flex"
                       data-type="land"
                       data-tier="{{ $tierKey }}"
                       data-title="{{ strtolower($land->title) }}"
                       data-location="{{ strtolower($land->sector . ' ' . $land->district . ' ' . $land->province) }}"
                       data-price="{{ $land->price }}"
                       data-created="{{ $land->created_at->timestamp ?? 0 }}">

                        <div class="pp-card-img">
                            <span class="pp-type-badge land">Plot</span>
                            @if($land->land_use)
                                <span class="pp-cond-badge">{{ $land->land_use }}</span>
                            @endif
                            @if($tierKey !== 'basic')
                                <span class="tier-badge" style="background:{{ $tier['color'] }}">
                                    {{ $tier['label'] }}
                                </span>
                            @endif
                            @if(isset($land->images) && $land->images->first())
                                <img src="{{ asset('image/lands/') }}/{{ $land->images->first()->image_path }}"
                                     alt="{{ $land->title }}" loading="lazy">
                            @else
                                <img src="{{ asset('front/assets/img/all-images/properties/property-img2.png') }}"
                                     alt="{{ $land->title }}" loading="lazy">
                            @endif
                            <button class="pp-wish" onclick="event.preventDefault(); this.classList.toggle('active')">
                                <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra Real estate" style="width:20px; height:20px;">
                            </button>
                        </div>

                        <div class="pp-card-body">
                            <p class="pp-card-title">{{ $land->title }}</p>
                            <div class="pp-card-loc">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                </svg>
                                {{ $land->sector }}, {{ $land->district }}
                            </div>
                            <div class="pp-card-stats">
                                @if($land->zoning)
                                    <span class="pp-stat-item">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0-2-2-3-4-3-4z"/></svg>
                                        {{ $land->zoning }}
                                    </span>
                                @endif
                                @if($land->size_sqm)
                                    <span class="pp-stat-item">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg>
                                        {{ number_format($land->size_sqm) }}sqm
                                    </span>
                                @endif
                            </div>
                            <div class="pp-card-foot">
                                <p class="pp-card-price">{{ number_format($land->price) }}<span> RWF</span></p>
                                <span class="pp-card-cta">View
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>{{-- /.tier-row --}}

            @endforeach

        </div>{{-- /#pp-grid --}}

        {{-- JS-driven empty state (shown when filters return nothing) --}}
        <div class="pp-empty" id="pp-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/>
                <path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/>
            </svg>
            <h3>No properties found</h3>
            <p>Try adjusting your search or filters.</p>
        </div>

    @endif
</div>

<script>
(function () {
    const grid = document.getElementById('pp-grid');
    if (!grid) return;

    const cards   = Array.from(grid.querySelectorAll('.pp-card'));
    const countEl = document.getElementById('pp-count');
    const badge   = document.getElementById('pp-badge');
    const empty   = document.getElementById('pp-empty');

    let state = { type: 'all', q: '', price: '', sort: 'newest' };

    function debounce(fn, ms) {
        let t;
        return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); };
    }

    function run() {
        const q = state.q.trim().toLowerCase();

        // 1. Determine which cards pass all filters
        const visible = new Set(cards.filter(c => {
            if (state.type !== 'all' && c.dataset.type !== state.type) return false;
            if (q && !(c.dataset.title + ' ' + c.dataset.location).includes(q)) return false;
            if (state.price) {
                const [mn, mx] = state.price.split('-').map(Number);
                const p = +c.dataset.price;
                if (p < mn || p > mx) return false;
            }
            return true;
        }));

        // 2. Sort visible cards
        const sorted = [...visible].sort((a, b) => {
            switch (state.sort) {
                case 'price-asc':  return +a.dataset.price   - +b.dataset.price;
                case 'price-desc': return +b.dataset.price   - +a.dataset.price;
                case 'oldest':     return +a.dataset.created - +b.dataset.created;
                default:           return +b.dataset.created - +a.dataset.created;
            }
        });

        // 3. Show/hide col wrappers; re-append in sorted order inside their tier-row
        cards.forEach(c => {
            const col = c.closest('[class*="col-"]');
            if (col) col.style.display = visible.has(c) ? '' : 'none';
        });
        sorted.forEach(c => {
            const col = c.closest('[class*="col-"]');
            if (col) col.parentElement.appendChild(col);
        });

        // 4. Show/hide each tier separator + row; update per-tier count
        document.querySelectorAll('[data-tier-sep]').forEach(sep => {
            const tier   = sep.dataset.tierSep;
            const row    = grid.querySelector(`[data-tier-row="${tier}"]`);
            const inTier = sorted.filter(c => c.dataset.tier === tier);
            const hasAny = inTier.length > 0;

            sep.style.display = hasAny ? '' : 'none';
            if (row) row.style.display = hasAny ? '' : 'none';

            // Update the live count badge inside the tier header
            const countBadge = document.getElementById(`tier-count-${tier}`);
            if (countBadge) {
                const numEl = countBadge.querySelector('.tier-count-num');
                if (numEl) numEl.textContent = inTier.length;
            }
        });

        // 5. Global count + overall empty state
        const n = visible.size;
        if (countEl) countEl.textContent = n;
        if (badge)   badge.textContent   = n;
        if (empty)   empty.style.display = n === 0 ? 'block' : 'none';
    }

    // ── Inputs ──
    document.getElementById('pp-q')
        .addEventListener('input', debounce(e => { state.q = e.target.value; run(); }, 220));
    document.getElementById('pp-price')
        .addEventListener('change', e => { state.price = e.target.value; run(); });
    document.getElementById('pp-sort')
        .addEventListener('change', e => { state.sort = e.target.value; run(); });

    document.querySelectorAll('.pp-tab').forEach(t => {
        t.addEventListener('click', () => {
            document.querySelectorAll('.pp-tab').forEach(x => x.classList.remove('on'));
            t.classList.add('on');
            state.type = t.dataset.t;
            run();
        });
    });

    // ── View toggle ──
    const gridBtn = document.getElementById('pp-grid-btn');
    const listBtn = document.getElementById('pp-list-btn');

    gridBtn.addEventListener('click', () => {
        grid.querySelectorAll('.tier-row').forEach(r => r.classList.remove('list-v'));
        gridBtn.classList.add('on');
        listBtn.classList.remove('on');
        localStorage.setItem('ppView', 'grid');
    });

    listBtn.addEventListener('click', () => {
        grid.querySelectorAll('.tier-row').forEach(r => r.classList.add('list-v'));
        listBtn.classList.add('on');
        gridBtn.classList.remove('on');
        localStorage.setItem('ppView', 'list');
    });

    if (localStorage.getItem('ppView') === 'list') listBtn.click();

    run();
})();
</script>

@endsection