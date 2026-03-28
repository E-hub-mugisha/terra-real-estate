@extends('layouts.guest')
@section('title', 'Plots for Sale')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .14);
        --gold: #C8873A;
        --gold-bg: rgba(200, 135, 58, .07);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --amber: #8B6914;
        --amber-bg: rgba(139, 105, 20, .08);
        --amber-bd: rgba(139, 105, 20, .22);
        --r: 12px;
        --t: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* ── Page header ── */
    .lp-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 36px 0 28px;
    }

    .lp-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 8px;
    }

    .lp-eyebrow::before {
        content: '';
        width: 16px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .lp-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 500;
        letter-spacing: -.02em;
        color: var(--text);
        margin: 0;
    }

    .lp-header h1 em {
        font-style: italic;
        color: var(--gold);
    }

    .lp-header-sub {
        font-size: .82rem;
        color: var(--muted);
        margin-top: 4px;
    }

    /* ── Filter bar ── */
    .lp-filter {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 11px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    }

    .lp-filter-inner {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .lp-search {
        position: relative;
        flex: 1;
        min-width: 150px;
        max-width: 240px;
    }

    .lp-search svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 13px;
        height: 13px;
        color: var(--dim);
        pointer-events: none;
    }

    .lp-search input {
        width: 100%;
        padding: 8px 11px 8px 28px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .81rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        transition: border-color var(--t);
    }

    .lp-search input:focus {
        outline: none;
        border-color: var(--gold);
        background: var(--surface);
    }

    .lp-search input::placeholder {
        color: var(--dim);
    }

    .lp-select {
        padding: 6px 24px 6px 10px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .78rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 7px center no-repeat;
        appearance: none;
        cursor: pointer;
        transition: border-color var(--t);
    }

    .lp-select:focus {
        outline: none;
        border-color: var(--gold);
    }

    .lp-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .lp-count {
        font-size: .77rem;
        color: var(--dim);
        white-space: nowrap;
    }

    .lp-count strong {
        color: var(--text);
    }

    .lp-vbtns {
        display: flex;
        gap: 3px;
    }

    .lp-vbtn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1.5px solid var(--border);
        background: transparent;
        display: grid;
        place-items: center;
        cursor: pointer;
        color: var(--dim);
        transition: all var(--t);
    }

    .lp-vbtn.on,
    .lp-vbtn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .lp-vbtn svg {
        width: 13px;
        height: 13px;
    }

    /* ── Main area ── */
    .lp-main {
        padding: 28px 0 72px;
    }

    /* ── Plot Card ── */
    .lp-card {
        display: block;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        height: 100%;
        transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        animation: lpFu .35s ease both;
        color: var(--text);
        cursor: pointer;
    }

    .lp-card:hover {
        transform: translateY(-4px);
        border-color: var(--gold-bd);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .09), 0 0 0 1px rgba(200, 135, 58, .09);
        color: var(--text);
    }

    @keyframes lpFu {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card image */
    .lp-card-img {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: var(--bg);
        flex-shrink: 0;
    }

    .lp-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }

    .lp-card:hover .lp-card-img img {
        transform: scale(1.06);
    }

    /* Badges */
    .lp-badge-type {
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 2;
        padding: 2px 8px;
        border-radius: 5px;
        background: var(--amber);
        color: #fff;
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .lp-badge-use {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 2;
        padding: 2px 7px;
        border-radius: 5px;
        background: rgba(14, 14, 12, .72);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, .12);
        font-size: .6rem;
        font-weight: 600;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: rgba(240, 237, 232, .75);
    }

    /* Wishlist */
    .lp-wish {
        position: absolute;
        bottom: 8px;
        right: 8px;
        z-index: 2;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .88);
        border: none;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: background var(--t);
    }

    .lp-wish:hover {
        background: #fff;
    }

    .lp-wish svg {
        width: 12px;
        height: 12px;
        color: var(--dim);
        transition: all var(--t);
    }

    .lp-wish.active svg {
        color: #e53e3e;
        fill: #e53e3e;
    }

    /* Card body */
    .lp-card-body {
        padding: 12px 14px 14px;
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .lp-card-title {
        font-size: .87rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.3;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .lp-card-service {
        font-size: .73rem;
        color: var(--gold);
        font-weight: 500;
    }

    .lp-card-loc {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .73rem;
        color: var(--muted);
    }

    .lp-card-loc svg {
        width: 10px;
        height: 10px;
        color: var(--gold);
        flex-shrink: 0;
    }

    /* UPI badge */
    .lp-upi {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: .68rem;
        font-weight: 700;
        color: var(--gold);
        font-family: 'DM Mono', monospace;
        letter-spacing: .04em;
    }

    .lp-upi-label {
        padding: 1px 5px;
        border-radius: 3px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .6rem;
        font-weight: 700;
        color: var(--gold);
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    /* Stats row */
    .lp-card-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .lp-stat {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: .71rem;
        color: var(--muted);
        font-weight: 500;
    }

    .lp-stat svg {
        width: 11px;
        height: 11px;
    }

    /* Card footer */
    .lp-card-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid var(--border);
        padding-top: 9px;
        margin-top: auto;
    }

    .lp-card-price {
        font-size: .9rem;
        font-weight: 700;
        color: var(--gold);
        margin: 0;
    }

    .lp-card-price span {
        font-size: .68rem;
        font-weight: 400;
        color: var(--dim);
        margin-left: 2px;
    }

    .lp-card-view {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: .74rem;
        font-weight: 600;
        color: var(--gold);
        transition: gap var(--t);
    }

    .lp-card:hover .lp-card-view {
        gap: 7px;
    }

    .lp-card-view svg {
        width: 11px;
        height: 11px;
    }

    /* ── List view ── */
    .lp-row.list-v .col-xl-3,
    .lp-row.list-v .col-lg-4,
    .lp-row.list-v .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .lp-row.list-v .lp-card {
        flex-direction: row;
        max-height: 148px;
        display: flex;
    }

    .lp-row.list-v .lp-card-img {
        width: 190px;
        min-width: 190px;
        aspect-ratio: unset;
        flex-shrink: 0;
    }

    .lp-row.list-v .lp-card-body {
        padding: 11px 13px;
    }

    @media (max-width: 500px) {
        .lp-row.list-v .lp-card-img {
            width: 130px;
            min-width: 130px;
        }
    }

    /* ── Empty state ── */
    .lp-empty {
        text-align: center;
        padding: 64px 20px;
        color: var(--dim);
    }

    .lp-empty svg {
        width: 42px;
        height: 42px;
        margin-bottom: 14px;
        opacity: .3;
    }

    .lp-empty h3 {
        font-size: .92rem;
        color: var(--muted);
        margin-bottom: 5px;
    }

    @media (max-width: 640px) {
        .lp-meta {
            margin-left: 0;
        }
    }

    .wish-btn {
        position: absolute;
        bottom: 8px;
        right: 8px;
        z-index: 3;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .92);
        border: 1px solid rgba(200, 135, 58, .2);
        display: grid;
        place-items: center;
        cursor: pointer;
        backdrop-filter: blur(4px);
        transition: background .2s, border-color .2s, transform .2s;
        padding: 0;
    }

    .wish-btn:hover {
        background: #fff;
        border-color: rgba(200, 135, 58, .5);
        transform: scale(1.1);
    }

    .wish-btn.active {
        background: #C8873A;
        border-color: #C8873A;
    }

    .wish-btn.active img {
        filter: brightness(0) invert(1);
    }
</style>

{{-- ── Page header ── --}}
<div class="lp-header">
    <div class="container">
        <div class="lp-eyebrow">Browse Properties</div>
        <h1>Plots &amp; Land <em>for Sale</em></h1>
        <p class="lp-header-sub">{{ $lands->count() }} {{ Str::plural('plot', $lands->count()) }} available across Rwanda</p>
    </div>
</div>

{{-- ── Filter bar ── --}}
<div class="lp-filter">
    <div class="container">
        <div class="lp-filter-inner">

            <div class="lp-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="text" id="lp-q" placeholder="Search title or location…" autocomplete="off">
            </div>

            <select class="lp-select" id="lp-zoning">
                <option value="">Any Zoning</option>
                <option value="R1">R1 – Residential Low</option>
                <option value="R2">R2 – Residential Medium</option>
                <option value="R3">R3 – Residential High</option>
                <option value="Commercial">Commercial</option>
                <option value="Industrial">Industrial</option>
                <option value="Agricultural">Agricultural</option>
            </select>

            <select class="lp-select" id="lp-price">
                <option value="">Any Price</option>
                <option value="0-5000000">Under 5M RWF</option>
                <option value="5000000-20000000">5M – 20M</option>
                <option value="20000000-50000000">20M – 50M</option>
                <option value="50000000-999999999">50M+</option>
            </select>

            <select class="lp-select" id="lp-size">
                <option value="">Any Size</option>
                <option value="0-300">Under 300 sqm</option>
                <option value="300-600">300 – 600 sqm</option>
                <option value="600-1000">600 – 1000 sqm</option>
                <option value="1000-999999">1000 sqm+</option>
            </select>

            <select class="lp-select" id="lp-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="price-asc">Price ↑</option>
                <option value="price-desc">Price ↓</option>
                <option value="size-asc">Size ↑</option>
                <option value="size-desc">Size ↓</option>
            </select>

            <div class="lp-meta">
                <span class="lp-count"><strong id="lp-count">{{ $lands->count() }}</strong> plots</span>
                <div class="lp-vbtns">
                    <button class="lp-vbtn on" id="lp-vgrid" title="Grid view">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm0 9h7v7h-7v-7zM4 13h7v7H4v-7z" />
                        </svg>
                    </button>
                    <button class="lp-vbtn" id="lp-vlist" title="List view">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 4h13v2H8V4zM4.5 6.5a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zM4.5 20a1 1 0 110-2 1 1 0 010 2zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Listings ── --}}
<div class="lp-main">
    <div class="container">

        <div class="row g-3 lp-row" id="lp-row">

            @forelse($lands as $i => $land)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12"
                style="animation-delay:{{ $i * 0.04 }}s">
                <a href="{{ route('front.buy.land.details', $land->id) }}"
                    class="lp-card d-flex flex-column"
                    data-title="{{ strtolower($land->title) }}"
                    data-loc="{{ strtolower($land->sector . ' ' . $land->district . ' ' . $land->province) }}"
                    data-zoning="{{ $land->zoning }}"
                    data-price="{{ $land->price }}"
                    data-size="{{ $land->size_sqm ?? 0 }}"
                    data-created="{{ $land->created_at->timestamp ?? 0 }}">

                    <div class="lp-card-img">
                        <span class="hp-badge-cond {{ $land->condition === 'for_rent' ? 'rent' : '' }}">
                            {{ $land->condition === 'for_rent' ? 'For Rent' : 'For Sale' }}
                        </span>

                        @if($land->land_use)
                        <span class="lp-badge-use">{{ $land->land_use }}</span>
                        @endif

                        @if(isset($land->images) && $land->images->first())
                        <img src="{{ asset('image/lands/') }}/{{ $land->images->first()->image_path }}"
                            alt="{{ $land->title }}" loading="lazy">
                        @else
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img2.png') }}"
                            alt="{{ $land->title }}" loading="lazy">
                        @endif

                        {{-- Terra logo bookmark — bottom right ── --}}
                        <button class="wish-btn" onclick="event.preventDefault(); this.classList.toggle('active')" title="Save">
                            <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra Real Estate" style="width:20px;height:20px;object-fit:contain;">
                        </button>
                    </div>

                    <div class="lp-card-body">
                        <p class="lp-card-title">{{ $land->title }}</p>

                        @if($land->service ?? null)
                        <div class="lp-card-service">{{ $land->service->title }}</div>
                        @endif

                        <div class="lp-card-loc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            </svg>
                            {{ $land->sector }}, {{ $land->district }}, {{ $land->province }}
                        </div>

                        @if($land->upi)
                        <div class="lp-upi">
                            <span class="lp-upi-label">UPI</span>
                            {{ $land->upi }}
                        </div>
                        @endif

                        <div class="lp-card-stats">
                            @if($land->zoning)
                            <span class="lp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 8C8 10 5.9 16.17 3.82 21.34L5.71 22l1-2.3A4.49 4.49 0 008 20C19 20 22 3 22 3c-1 2-8 2-9 0-2-2-3-4-3-4z" />
                                </svg>
                                {{ $land->zoning }}
                            </span>
                            @endif
                            @if($land->size_sqm)
                            <span class="lp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4 4h16v16H4V4zm2 2v12h12V6H6z" />
                                </svg>
                                {{ number_format($land->size_sqm) }} sqm
                            </span>
                            @endif
                            @if($land->status)
                            <span class="lp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ ucfirst($land->status) }}
                            </span>
                            @endif
                        </div>

                        <div class="lp-card-foot">
                            <p class="lp-card-price">{{ number_format($land->price) }}<span>RWF</span></p>
                            <span class="lp-card-view">
                                View
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </div>

                </a>
            </div>
            @empty
            <div class="col-12">
                <div class="lp-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5z" />
                    </svg>
                    <h3>No plots found</h3>
                    <p>Check back soon — new listings are added regularly.</p>
                </div>
            </div>
            @endforelse

        </div>

        <div class="lp-empty" id="lp-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35M11 8v3m0 3h.01" />
            </svg>
            <h3>No plots match your filters</h3>
            <p>Try adjusting your search or clearing filters.</p>
        </div>

    </div>
</div>

<script>
    (function() {
        const row = document.getElementById('lp-row');
        const cards = Array.from(row.querySelectorAll('.lp-card'));
        const countEl = document.getElementById('lp-count');
        const emptyEl = document.getElementById('lp-empty');

        let state = {
            q: '',
            zoning: '',
            price: '',
            size: '',
            sort: 'newest'
        };

        function debounce(fn, ms) {
            let t;
            return (...a) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...a), ms);
            };
        }

        function run() {
            const q = state.q.toLowerCase();

            let vis = cards.filter(c => {
                if (state.zoning && c.dataset.zoning !== state.zoning) return false;
                if (q && !(c.dataset.title + ' ' + c.dataset.loc).includes(q)) return false;
                if (state.price) {
                    const [mn, mx] = state.price.split('-').map(Number);
                    if (+c.dataset.price < mn || +c.dataset.price > mx) return false;
                }
                if (state.size) {
                    const [mn, mx] = state.size.split('-').map(Number);
                    if (+c.dataset.size < mn || +c.dataset.size > mx) return false;
                }
                return true;
            });

            if (state.sort === 'price-asc') vis.sort((a, b) => +a.dataset.price - +b.dataset.price);
            if (state.sort === 'price-desc') vis.sort((a, b) => +b.dataset.price - +a.dataset.price);
            if (state.sort === 'size-asc') vis.sort((a, b) => +a.dataset.size - +b.dataset.size);
            if (state.sort === 'size-desc') vis.sort((a, b) => +b.dataset.size - +a.dataset.size);
            if (state.sort === 'oldest') vis.sort((a, b) => +a.dataset.created - +b.dataset.created);
            if (state.sort === 'newest') vis.sort((a, b) => +b.dataset.created - +a.dataset.created);

            const vs = new Set(vis);
            cards.forEach(c => {
                const col = c.closest('[class*="col-"]');
                if (col) col.style.display = vs.has(c) ? '' : 'none';
            });
            vis.forEach(c => {
                const col = c.closest('[class*="col-"]');
                if (col) row.appendChild(col);
            });

            const n = vis.length;
            countEl.textContent = n;
            if (emptyEl) emptyEl.style.display = n === 0 ? 'block' : 'none';
        }

        document.getElementById('lp-q')
            .addEventListener('input', debounce(e => {
                state.q = e.target.value;
                run();
            }, 220));
        document.getElementById('lp-zoning')
            .addEventListener('change', e => {
                state.zoning = e.target.value;
                run();
            });
        document.getElementById('lp-price')
            .addEventListener('change', e => {
                state.price = e.target.value;
                run();
            });
        document.getElementById('lp-size')
            .addEventListener('change', e => {
                state.size = e.target.value;
                run();
            });
        document.getElementById('lp-sort')
            .addEventListener('change', e => {
                state.sort = e.target.value;
                run();
            });

        /* View toggle */
        document.getElementById('lp-vgrid').addEventListener('click', () => {
            row.classList.remove('list-v');
            document.getElementById('lp-vgrid').classList.add('on');
            document.getElementById('lp-vlist').classList.remove('on');
            localStorage.setItem('lpView', 'grid');
        });
        document.getElementById('lp-vlist').addEventListener('click', () => {
            row.classList.add('list-v');
            document.getElementById('lp-vlist').classList.add('on');
            document.getElementById('lp-vgrid').classList.remove('on');
            localStorage.setItem('lpView', 'list');
        });
        if (localStorage.getItem('lpView') === 'list') {
            document.getElementById('lp-vlist').click();
        }

        run();
    })();
</script>

@endsection