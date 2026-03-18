@extends('layouts.guest')
@section('title', 'Architectural Designs')
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
        --text: #1A1714;
        --muted: #6B6560;
        --dim: #9E9890;
        --purple: #5A3B8C;
        --purple-bg: rgba(90, 59, 140, .08);
        --purple-bd: rgba(90, 59, 140, .22);
        --green: #1E7A5A;
        --green-bg: rgba(30, 122, 90, .07);
        --green-bd: rgba(30, 122, 90, .2);
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
    .dp-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 36px 0 28px;
    }

    .dp-eyebrow {
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

    .dp-eyebrow::before {
        content: '';
        width: 16px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .dp-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 500;
        letter-spacing: -.02em;
        color: var(--text);
        margin: 0;
    }

    .dp-header h1 em {
        font-style: italic;
        color: var(--gold);
    }

    .dp-header-sub {
        font-size: .82rem;
        color: var(--muted);
        margin-top: 4px;
    }

    /* ── Filter bar ── */
    .dp-filter {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 11px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    }

    .dp-filter-inner {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Search */
    .dp-search {
        position: relative;
        flex: 1;
        min-width: 150px;
        max-width: 240px;
    }

    .dp-search svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 13px;
        height: 13px;
        color: var(--dim);
        pointer-events: none;
    }

    .dp-search input {
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

    .dp-search input:focus {
        outline: none;
        border-color: var(--gold);
        background: var(--surface);
    }

    .dp-search input::placeholder {
        color: var(--dim);
    }

    /* Tabs */
    .dp-tabs {
        display: flex;
        gap: 4px;
    }

    .dp-tab {
        padding: 6px 12px;
        border-radius: 7px;
        border: 1.5px solid var(--border);
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .78rem;
        font-weight: 500;
        color: var(--muted);
        cursor: pointer;
        white-space: nowrap;
        transition: all var(--t);
    }

    .dp-tab:hover {
        border-color: var(--gold);
        color: var(--gold);
    }

    .dp-tab.on {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    /* Selects */
    .dp-select {
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

    .dp-select:focus {
        outline: none;
        border-color: var(--gold);
    }

    /* Meta */
    .dp-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .dp-count {
        font-size: .77rem;
        color: var(--dim);
        white-space: nowrap;
    }

    .dp-count strong {
        color: var(--text);
    }

    .dp-vbtns {
        display: flex;
        gap: 3px;
    }

    .dp-vbtn {
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

    .dp-vbtn.on,
    .dp-vbtn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .dp-vbtn svg {
        width: 13px;
        height: 13px;
    }

    /* ── Main ── */
    .dp-main {
        padding: 28px 0 72px;
    }

    /* ── Design Card ── */
    .dp-card {
        display: flex;
        flex-direction: column;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        height: 100%;
        transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        animation: dpFu .35s ease both;
        color: var(--text);
        cursor: pointer;
        text-decoration: none;
    }

    .dp-card:hover {
        transform: translateY(-4px);
        border-color: var(--gold-bd);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .09), 0 0 0 1px rgba(200, 135, 58, .09);
        color: var(--text);
    }

    @keyframes dpFu {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Image */
    .dp-card-img {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: var(--bg);
        flex-shrink: 0;
    }

    .dp-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }

    .dp-card:hover .dp-card-img img {
        transform: scale(1.05);
    }

    /* Category badge */
    .dp-badge-cat {
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 2;
        padding: 2px 8px;
        border-radius: 5px;
        background: var(--purple);
        color: #fff;
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    /* Free / Paid badge */
    .dp-badge-price {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 2;
        padding: 2px 8px;
        border-radius: 5px;
        font-size: .62rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .dp-badge-price.free {
        background: rgba(30, 122, 90, .85);
        color: #fff;
    }

    .dp-badge-price.paid {
        background: rgba(14, 14, 12, .72);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, .12);
        color: rgba(240, 237, 232, .75);
    }

    /* Featured badge */
    .dp-badge-feat {
        position: absolute;
        bottom: 8px;
        left: 8px;
        z-index: 2;
        padding: 2px 7px;
        border-radius: 5px;
        background: rgba(200, 135, 58, .85);
        color: #fff;
        font-size: .6rem;
        font-weight: 600;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    /* Card body */
    .dp-card-body {
        padding: 12px 14px 14px;
        display: flex;
        flex-direction: column;
        gap: 7px;
        flex: 1;
    }

    .dp-card-title {
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

    .dp-card-service {
        font-size: .73rem;
        color: var(--gold);
        font-weight: 500;
    }

    .dp-card-desc {
        font-size: .77rem;
        color: var(--muted);
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Stats */
    .dp-card-stats {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .dp-stat {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: .71rem;
        color: var(--muted);
        font-weight: 500;
    }

    .dp-stat svg {
        width: 11px;
        height: 11px;
    }

    /* Card footer */
    .dp-card-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid var(--border);
        padding-top: 9px;
        margin-top: auto;
        gap: 8px;
    }

    .dp-price-tag {
        font-size: .9rem;
        font-weight: 700;
        color: var(--gold);
        margin: 0;
        white-space: nowrap;
    }

    .dp-price-tag span {
        font-size: .68rem;
        font-weight: 400;
        color: var(--dim);
        margin-left: 2px;
    }

    .dp-price-free {
        font-size: .82rem;
        font-weight: 700;
        color: var(--green);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .dp-price-free svg {
        width: 13px;
        height: 13px;
    }

    /* CTA button */
    .dp-card-cta {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 7px;
        font-size: .74rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        transition: all var(--t);
        border: none;
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
    }

    .dp-cta-buy {
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        color: var(--gold);
    }

    .dp-card:hover .dp-cta-buy {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .dp-cta-dl {
        background: var(--green-bg);
        border: 1px solid var(--green-bd);
        color: var(--green);
    }

    .dp-card:hover .dp-cta-dl {
        background: var(--green);
        border-color: var(--green);
        color: #fff;
    }

    .dp-card-cta svg {
        width: 12px;
        height: 12px;
    }

    /* ── List view ── */
    .dp-row.list-v .col-xl-3,
    .dp-row.list-v .col-lg-4,
    .dp-row.list-v .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .dp-row.list-v .dp-card {
        flex-direction: row;
        max-height: 148px;
    }

    .dp-row.list-v .dp-card-img {
        width: 190px;
        min-width: 190px;
        aspect-ratio: unset;
        flex-shrink: 0;
    }

    .dp-row.list-v .dp-card-body {
        padding: 11px 13px;
    }

    .dp-row.list-v .dp-card-desc {
        display: none;
    }

    @media (max-width: 500px) {
        .dp-row.list-v .dp-card-img {
            width: 130px;
            min-width: 130px;
        }
    }

    /* ── Empty ── */
    .dp-empty {
        text-align: center;
        padding: 64px 20px;
        color: var(--dim);
    }

    .dp-empty svg {
        width: 42px;
        height: 42px;
        margin-bottom: 14px;
        opacity: .3;
    }

    .dp-empty h3 {
        font-size: .92rem;
        color: var(--muted);
        margin-bottom: 5px;
    }

    @media (max-width: 640px) {
        .dp-meta {
            margin-left: 0;
        }
    }
</style>

{{-- ── Page header ── --}}
<div class="dp-header">
    <div class="container">
        <div class="dp-eyebrow">Design Marketplace</div>
        <h1>Architectural <em>Designs</em></h1>
        <p class="dp-header-sub">{{ $designs->count() }} {{ Str::plural('design', $designs->count()) }} available — browse, buy or download for free</p>
    </div>
</div>

{{-- ── Filter bar ── --}}
<div class="dp-filter">
    <div class="container">
        <div class="dp-filter-inner">

            <div class="dp-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="text" id="dp-q" placeholder="Search title or category…" autocomplete="off">
            </div>

            <div class="dp-tabs">
                <button class="dp-tab on" data-f="all">All</button>
                <button class="dp-tab" data-f="free">Free</button>
                <button class="dp-tab" data-f="paid">Paid</button>
            </div>

            <select class="dp-select" id="dp-cat">
                <option value="">Any Category</option>
                @foreach($designs->pluck('category.name')->filter()->unique() as $cat)
                <option value="{{ strtolower($cat) }}">{{ $cat }}</option>
                @endforeach
            </select>

            <select class="dp-select" id="dp-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="price-asc">Price ↑</option>
                <option value="price-desc">Price ↓</option>
                <option value="name-az">Name A–Z</option>
            </select>

            <div class="dp-meta">
                <span class="dp-count"><strong id="dp-count">{{ $designs->count() }}</strong> designs</span>
                <div class="dp-vbtns">
                    <button class="dp-vbtn on" id="dp-vgrid" title="Grid view">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm0 9h7v7h-7v-7zM4 13h7v7H4v-7z" />
                        </svg>
                    </button>
                    <button class="dp-vbtn" id="dp-vlist" title="List view">
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
<div class="dp-main">
    <div class="container">

        <div class="row g-3 dp-row" id="dp-row">

            @forelse($designs as $i => $design)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12"
                style="animation-delay:{{ $i * 0.04 }}s">

                <div class="dp-card"
                    data-title="{{ strtolower($design->title) }}"
                    data-cat="{{ strtolower($design->category?->name ?? '') }}"
                    data-free="{{ $design->is_free ? '1' : '0' }}"
                    data-price="{{ $design->price ?? 0 }}"
                    data-created="{{ $design->created_at->timestamp ?? 0 }}"
                    onclick="window.location='{{ $design->is_free ? '#' : route('front.buy.design.show', $design->slug) }}'">

                    <div class="dp-card-img">
                        {{-- Category badge --}}
                        <span class="dp-badge-cat">{{ $design->category?->name ?? 'Design' }}</span>

                        {{-- Free / Paid --}}
                        <span class="dp-badge-price {{ $design->is_free ? 'free' : 'paid' }}">
                            {{ $design->is_free ? 'Free' : number_format($design->price).' RWF' }}
                        </span>

                        @if($design->featured)
                        <span class="dp-badge-feat">Featured</span>
                        @endif

                        @if($design->preview_image)
                        <img src="{{ asset('storage/'.$design->preview_image) }}" alt="{{ $design->title }}" loading="lazy">
                        @else
                        <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}" alt="{{ $design->title }}" loading="lazy">
                        @endif
                    </div>

                    <div class="dp-card-body">
                        <p class="dp-card-title">{{ $design->title }}</p>

                        @if($design->service)
                        <div class="dp-card-service">{{ $design->service->title }}</div>
                        @endif

                        @if($design->description)
                        <p class="dp-card-desc">{{ Str::limit($design->description, 80) }}</p>
                        @endif

                        <div class="dp-card-stats">
                            @if($design->category)
                            <span class="dp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                                </svg>
                                {{ $design->category->name }}
                            </span>
                            @endif
                            <span class="dp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                </svg>
                                {{ strtoupper(pathinfo($design->design_file ?? 'PDF', PATHINFO_EXTENSION) ?: 'PDF') }}
                            </span>
                            @if($design->status)
                            <span class="dp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ ucfirst($design->status) }}
                            </span>
                            @endif
                        </div>

                        <div class="dp-card-foot">
                            @if($design->is_free)
                            <div class="dp-price-free">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M5 16h14v2H5v-2zm9-4h5l-7 7-7-7h5V3h4v9z" />
                                </svg>
                                Free Download
                            </div>
                            <a href="{{ asset('storage/'.$design->design_file) }}"
                                download
                                onclick="event.stopPropagation()"
                                class="dp-card-cta dp-cta-dl">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M5 16h14v2H5v-2zm9-4h5l-7 7-7-7h5V3h4v9z" />
                                </svg>
                                Download
                            </a>
                            @else
                            <p class="dp-price-tag">{{ number_format($design->price ?? 0) }}<span>RWF</span></p>
                            <a href="{{ route('front.buy.design.purchase', $design->slug) }}"
                                onclick="event.stopPropagation()"
                                class="dp-card-cta dp-cta-buy">
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
                <div class="dp-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                    </svg>
                    <h3>No designs found</h3>
                    <p>Check back soon — new designs are uploaded regularly.</p>
                </div>
            </div>
            @endforelse

        </div>

        <div class="dp-empty" id="dp-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35M11 8v3m0 3h.01" />
            </svg>
            <h3>No designs match your filters</h3>
            <p>Try adjusting your search or clearing filters.</p>
        </div>

    </div>
</div>

<script>
    (function() {
        const row = document.getElementById('dp-row');
        const cards = Array.from(row.querySelectorAll('.dp-card'));
        const countEl = document.getElementById('dp-count');
        const emptyEl = document.getElementById('dp-empty');

        let state = {
            q: '',
            free: 'all',
            cat: '',
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
                if (state.free === 'free' && c.dataset.free !== '1') return false;
                if (state.free === 'paid' && c.dataset.free !== '0') return false;
                if (state.cat && !c.dataset.cat.includes(state.cat)) return false;
                if (q && !c.dataset.title.includes(q)) return false;
                return true;
            });

            if (state.sort === 'price-asc') vis.sort((a, b) => +a.dataset.price - +b.dataset.price);
            if (state.sort === 'price-desc') vis.sort((a, b) => +b.dataset.price - +a.dataset.price);
            if (state.sort === 'oldest') vis.sort((a, b) => +a.dataset.created - +b.dataset.created);
            if (state.sort === 'newest') vis.sort((a, b) => +b.dataset.created - +a.dataset.created);
            if (state.sort === 'name-az') vis.sort((a, b) => a.dataset.title.localeCompare(b.dataset.title));

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

        document.getElementById('dp-q')
            .addEventListener('input', debounce(e => {
                state.q = e.target.value;
                run();
            }, 220));
        document.getElementById('dp-cat')
            .addEventListener('change', e => {
                state.cat = e.target.value;
                run();
            });
        document.getElementById('dp-sort')
            .addEventListener('change', e => {
                state.sort = e.target.value;
                run();
            });

        document.querySelectorAll('.dp-tab').forEach(t => {
            t.addEventListener('click', () => {
                document.querySelectorAll('.dp-tab').forEach(x => x.classList.remove('on'));
                t.classList.add('on');
                state.free = t.dataset.f;
                run();
            });
        });

        /* View toggle */
        document.getElementById('dp-vgrid').addEventListener('click', () => {
            row.classList.remove('list-v');
            document.getElementById('dp-vgrid').classList.add('on');
            document.getElementById('dp-vlist').classList.remove('on');
            localStorage.setItem('dpView', 'grid');
        });
        document.getElementById('dp-vlist').addEventListener('click', () => {
            row.classList.add('list-v');
            document.getElementById('dp-vlist').classList.add('on');
            document.getElementById('dp-vgrid').classList.remove('on');
            localStorage.setItem('dpView', 'list');
        });
        if (localStorage.getItem('dpView') === 'list') {
            document.getElementById('dp-vlist').click();
        }

        run();
    })();
</script>

@endsection