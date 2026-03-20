@extends('layouts.guest')
@section('title', 'Houses for Sale')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:       #F7F5F2;
    --surface:  #FFFFFF;
    --dark:     #0E0E0C;
    --border:   rgba(0,0,0,.08);
    --border2:  rgba(0,0,0,.14);
    --gold:     #C8873A;
    --gold-bg:  rgba(200,135,58,.07);
    --gold-bd:  rgba(200,135,58,.22);
    --text:     #19265d;
    --muted:    #6B6560;
    --dim:      #9E9890;
    --green:    #1E7A5A;
    --r:        12px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ── Page header ── */
.hp-header {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 36px 0 28px;
}
.hp-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 8px;
}
.hp-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .5; }
.hp-header h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 500; letter-spacing: -.02em; color: var(--text); margin: 0;
}
.hp-header h1 em { font-style: italic; color: var(--gold); }
.hp-header-sub { font-size: .82rem; color: var(--muted); margin-top: 4px; }

/* ── Filter bar ── */
.hp-filter {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 11px 0;
    position: sticky; top: 0; z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.hp-filter-inner {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
}

/* Search */
.hp-search {
    position: relative; flex: 1; min-width: 150px; max-width: 240px;
}
.hp-search svg {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%); width: 13px; height: 13px;
    color: var(--dim); pointer-events: none;
}
.hp-search input {
    width: 100%; padding: 8px 11px 8px 28px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .81rem; font-family: 'DM Sans', sans-serif;
    background: var(--bg); color: var(--text);
    transition: border-color var(--t);
}
.hp-search input:focus { outline: none; border-color: var(--gold); background: var(--surface); }
.hp-search input::placeholder { color: var(--dim); }

/* Filter tabs */
.hp-tabs { display: flex; gap: 4px; }
.hp-tab {
    padding: 6px 12px; border-radius: 7px;
    border: 1.5px solid var(--border); background: transparent;
    font-family: 'DM Sans', sans-serif; font-size: .78rem;
    font-weight: 500; color: var(--muted); cursor: pointer;
    white-space: nowrap; transition: all var(--t);
}
.hp-tab:hover { border-color: var(--gold); color: var(--gold); }
.hp-tab.on { background: var(--gold); border-color: var(--gold); color: #fff; }

/* Selects */
.hp-select {
    padding: 6px 24px 6px 10px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .78rem; font-family: 'DM Sans', sans-serif; color: var(--text);
    background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 7px center no-repeat;
    appearance: none; cursor: pointer; transition: border-color var(--t);
}
.hp-select:focus { outline: none; border-color: var(--gold); }

/* Meta: count + view toggle */
.hp-meta { display: flex; align-items: center; gap: 8px; margin-left: auto; }
.hp-count { font-size: .77rem; color: var(--dim); white-space: nowrap; }
.hp-count strong { color: var(--text); }
.hp-vbtns { display: flex; gap: 3px; }
.hp-vbtn {
    width: 30px; height: 30px; border-radius: 7px;
    border: 1.5px solid var(--border); background: transparent;
    display: grid; place-items: center; cursor: pointer; color: var(--dim);
    transition: all var(--t);
}
.hp-vbtn.on, .hp-vbtn:hover { background: var(--gold); border-color: var(--gold); color: #fff; }
.hp-vbtn svg { width: 13px; height: 13px; }

/* ── Main area ── */
.hp-main { padding: 28px 0 72px; }

/* ── Property Card ── */
.hp-card {
    display: block;  /* <a> is block */
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    overflow: hidden;
    height: 100%;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
    animation: hpFu .35s ease both;
    color: var(--text);
    cursor: pointer;
}
.hp-card:hover {
    transform: translateY(-4px);
    border-color: var(--gold-bd);
    box-shadow: 0 10px 28px rgba(0,0,0,.09), 0 0 0 1px rgba(200,135,58,.09);
    color: var(--text);
}
@keyframes hpFu { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }

/* Card image */
.hp-card-img {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden; background: var(--bg); flex-shrink: 0;
}
.hp-card-img img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .5s ease;
}
.hp-card:hover .hp-card-img img { transform: scale(1.06); }

/* Badges */
.hp-badge-cond {
    position: absolute; top: 8px; left: 8px; z-index: 2;
    padding: 2px 8px; border-radius: 5px;
    background: var(--green); color: #fff;
    font-size: .62rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
}
.hp-badge-cond.rent { background: #C8873A; }
.hp-badge-feat {
    position: absolute; top: 8px; right: 8px; z-index: 2;
    padding: 2px 7px; border-radius: 5px;
    background: rgba(14,14,12,.72); backdrop-filter: blur(5px);
    border: 1px solid rgba(255,255,255,.12);
    font-size: .6rem; font-weight: 600;
    letter-spacing: .05em; text-transform: uppercase;
    color: rgba(240,237,232,.75);
}

/* Wishlist */
.hp-wish {
    position: absolute; bottom: 8px; right: 8px; z-index: 2;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(255,255,255,.88); border: none;
    display: grid; place-items: center; cursor: pointer;
    transition: background var(--t);
}
.hp-wish:hover { background: #fff; }
.hp-wish svg { width: 12px; height: 12px; color: var(--dim); transition: all var(--t); }
.hp-wish.active svg { color: #e53e3e; fill: #e53e3e; }

/* Card body */
.hp-card-body { padding: 12px 14px 14px; display: flex; flex-direction: column; gap: 7px; }
.hp-card-title {
    font-size: .87rem; font-weight: 600; color: var(--text);
    line-height: 1.3; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.hp-card-service { font-size: .73rem; color: var(--gold); font-weight: 500; }
.hp-card-loc {
    display: flex; align-items: center; gap: 4px;
    font-size: .73rem; color: var(--muted);
}
.hp-card-loc svg { width: 10px; height: 10px; color: var(--gold); flex-shrink: 0; }

/* Stats row */
.hp-card-stats {
    display: flex; gap: 10px; flex-wrap: wrap;
}
.hp-stat {
    display: flex; align-items: center; gap: 3px;
    font-size: .71rem; color: var(--muted); font-weight: 500;
}
.hp-stat svg { width: 11px; height: 11px; }

/* Card footer */
.hp-card-foot {
    display: flex; align-items: center; justify-content: space-between;
    border-top: 1px solid var(--border); padding-top: 9px; margin-top: auto;
}
.hp-card-price { font-size: .9rem; font-weight: 700; color: var(--gold); margin: 0; }
.hp-card-price span { font-size: .68rem; font-weight: 400; color: var(--dim); margin-left: 2px; }
.hp-card-view {
    display: flex; align-items: center; gap: 3px;
    font-size: .74rem; font-weight: 600; color: var(--gold);
    transition: gap var(--t);
}
.hp-card:hover .hp-card-view { gap: 7px; }
.hp-card-view svg { width: 11px; height: 11px; }

/* ── List view ── */
.hp-row.list-v .col-xl-3,
.hp-row.list-v .col-lg-4,
.hp-row.list-v .col-md-6 { flex: 0 0 100%; max-width: 100%; }
.hp-row.list-v .hp-card { flex-direction: row; max-height: 148px; display: flex; }
.hp-row.list-v .hp-card-img { width: 190px; min-width: 190px; aspect-ratio: unset; flex-shrink: 0; }
.hp-row.list-v .hp-card-body { padding: 11px 13px; }
@media (max-width: 500px) { .hp-row.list-v .hp-card-img { width: 130px; min-width: 130px; } }

/* ── Empty state ── */
.hp-empty {
    grid-column: 1/-1; text-align: center; padding: 64px 20px; color: var(--dim);
}
.hp-empty svg { width: 42px; height: 42px; margin-bottom: 14px; opacity: .3; }
.hp-empty h3 { font-size: .92rem; color: var(--muted); margin-bottom: 5px; }

@media (max-width: 640px) {
    .hp-tabs { overflow-x: auto; }
    .hp-meta { margin-left: 0; }
}
</style>

{{-- ── Page header ── --}}
<div class="hp-header">
    <div class="container">
        <div class="hp-eyebrow">Browse Properties</div>
        <h1>Houses for <em>Sale & Rent</em></h1>
        <p class="hp-header-sub">{{ $homes->count() }} {{ Str::plural('property', $homes->count()) }} available across Rwanda</p>
    </div>
</div>

{{-- ── Filter bar ── --}}
<div class="hp-filter">
    <div class="container">
        <div class="hp-filter-inner">

            <div class="hp-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" id="hp-q" placeholder="Search title or location…" autocomplete="off">
            </div>

            <div class="hp-tabs">
                <button class="hp-tab on" data-c="all">All</button>
                <button class="hp-tab" data-c="for_sale">For Sale</button>
                <button class="hp-tab" data-c="for_rent">For Rent</button>
            </div>

            <select class="hp-select" id="hp-type">
                <option value="">Any Type</option>
                <option value="house">House</option>
                <option value="apartment">Apartment</option>
                <option value="villa">Villa</option>
                <option value="townhouse">Townhouse</option>
            </select>

            <select class="hp-select" id="hp-price">
                <option value="">Any Price</option>
                <option value="0-5000000">Under 5M RWF</option>
                <option value="5000000-20000000">5M – 20M</option>
                <option value="20000000-50000000">20M – 50M</option>
                <option value="50000000-999999999">50M+</option>
            </select>

            <select class="hp-select" id="hp-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="price-asc">Price ↑</option>
                <option value="price-desc">Price ↓</option>
            </select>

            <div class="hp-meta">
                <span class="hp-count"><strong id="hp-count">{{ $homes->count() }}</strong> properties</span>
                <div class="hp-vbtns">
                    <button class="hp-vbtn on" id="hp-vgrid" title="Grid view">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm0 9h7v7h-7v-7zM4 13h7v7H4v-7z"/></svg>
                    </button>
                    <button class="hp-vbtn" id="hp-vlist" title="List view">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 4h13v2H8V4zM4.5 6.5a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zM4.5 20a1 1 0 110-2 1 1 0 010 2zM8 11h13v2H8v-2zm0 7h13v2H8v-2z"/></svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Listings ── --}}
<div class="hp-main">
    <div class="container">

        <div class="row g-3 hp-row" id="hp-row">

            @forelse($homes as $i => $home)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12"
                 style="animation-delay:{{ $i * 0.04 }}s">
                <a href="{{ route('front.buy.home.details', $home) }}"
                   class="hp-card d-flex flex-column"
                   data-title="{{ strtolower($home->title) }}"
                   data-loc="{{ strtolower($home->address) }}"
                   data-condition="{{ $home->condition }}"
                   data-type="{{ strtolower($home->type ?? '') }}"
                   data-price="{{ $home->price }}"
                   data-created="{{ $home->created_at->timestamp ?? 0 }}">

                    <div class="hp-card-img">
                        <span class="hp-badge-cond {{ $home->condition === 'for_rent' ? 'rent' : '' }}">
                            {{ $home->condition === 'for_rent' ? 'For Rent' : 'For Sale' }}
                        </span>
                        <span class="hp-badge-feat">Featured</span>

                        @if($home->images->first())
                            <img src="{{ asset('storage/'.$home->images->first()->image_path) }}"
                                 alt="{{ $home->title }}" loading="lazy">
                        @else
                            <img src="{{ asset('front/assets/img/all-images/properties/property-img1.png') }}"
                                 alt="{{ $home->title }}" loading="lazy">
                        @endif

                        <button class="hp-wish" onclick="event.preventDefault(); this.classList.toggle('active')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                            </svg>
                        </button>
                    </div>

                    <div class="hp-card-body">
                        <p class="hp-card-title">{{ $home->title }}</p>
                        @if($home->service)
                        <div class="hp-card-service">{{ $home->service->title }}</div>
                        @endif
                        <div class="hp-card-loc">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                            {{ Str::limit($home->address, 36) }}
                        </div>
                        <div class="hp-card-stats">
                            @if($home->bedrooms)
                            <span class="hp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 9.556V3h-2v2H6V3H4v6.557C2.81 10.25 2 11.526 2 13v4h1v2h2v-2h14v2h2v-2h1v-4c0-1.474-.811-2.75-2-3.444zM11 9H6V7h5v2zm7 0h-5V7h5v2z"/></svg>
                                {{ $home->bedrooms }}bd
                            </span>
                            @endif
                            @if($home->bathrooms)
                            <span class="hp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 10H7V7c0-1.103.897-2 2-2s2 .897 2 2h2c0-2.206-1.794-4-4-4S5 4.794 5 7v3H3a1 1 0 00-1 1v2c0 3.478 2.549 6.385 5.895 6.93L7 22h2l-.895-2h7.79L15 22h2l-.895-2.07C19.451 19.385 22 16.478 22 13v-2a1 1 0 00-1-1z"/></svg>
                                {{ $home->bathrooms }}ba
                            </span>
                            @endif
                            @if($home->area_sqft)
                            <span class="hp-stat">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6z"/></svg>
                                {{ number_format($home->area_sqft) }}sq
                            </span>
                            @endif
                        </div>
                        <div class="hp-card-foot">
                            <p class="hp-card-price">{{ number_format($home->price) }}<span>RWF</span></p>
                            <span class="hp-card-view">
                                View
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>

                </a>
            </div>
            @empty
            <div class="col-12">
                <div class="hp-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                    <h3>No properties found</h3>
                    <p>Check back soon — new listings are added regularly.</p>
                </div>
            </div>
            @endforelse

        </div>

        {{-- JS empty ── --}}
        <div class="hp-empty" id="hp-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/>
            </svg>
            <h3>No properties match your filters</h3>
            <p>Try adjusting your search or clearing filters.</p>
        </div>

    </div>
</div>

<script>
(function () {
    const row    = document.getElementById('hp-row');
    const cards  = Array.from(row.querySelectorAll('.hp-card'));
    const countEl= document.getElementById('hp-count');
    const emptyEl= document.getElementById('hp-empty');

    let state = { q:'', condition:'all', type:'', price:'', sort:'newest' };

    function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }

    function run() {
        const q = state.q.toLowerCase();

        let vis = cards.filter(c => {
            if (state.condition !== 'all' && c.dataset.condition !== state.condition) return false;
            if (state.type && !c.dataset.type.includes(state.type)) return false;
            if (q && !(c.dataset.title + ' ' + c.dataset.loc).includes(q)) return false;
            if (state.price) {
                const [mn, mx] = state.price.split('-').map(Number);
                const p = +c.dataset.price;
                if (p < mn || p > mx) return false;
            }
            return true;
        });

        if (state.sort === 'price-asc')  vis.sort((a,b) => +a.dataset.price - +b.dataset.price);
        if (state.sort === 'price-desc') vis.sort((a,b) => +b.dataset.price - +a.dataset.price);
        if (state.sort === 'oldest')     vis.sort((a,b) => +a.dataset.created - +b.dataset.created);
        if (state.sort === 'newest')     vis.sort((a,b) => +b.dataset.created - +a.dataset.created);

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

    document.getElementById('hp-q')
        .addEventListener('input', debounce(e => { state.q = e.target.value; run(); }, 220));
    document.getElementById('hp-type')
        .addEventListener('change', e => { state.type = e.target.value; run(); });
    document.getElementById('hp-price')
        .addEventListener('change', e => { state.price = e.target.value; run(); });
    document.getElementById('hp-sort')
        .addEventListener('change', e => { state.sort = e.target.value; run(); });

    document.querySelectorAll('.hp-tab').forEach(t => {
        t.addEventListener('click', () => {
            document.querySelectorAll('.hp-tab').forEach(x => x.classList.remove('on'));
            t.classList.add('on');
            state.condition = t.dataset.c;
            run();
        });
    });

    /* View toggle */
    document.getElementById('hp-vgrid').addEventListener('click', () => {
        row.classList.remove('list-v');
        document.getElementById('hp-vgrid').classList.add('on');
        document.getElementById('hp-vlist').classList.remove('on');
        localStorage.setItem('hpView', 'grid');
    });
    document.getElementById('hp-vlist').addEventListener('click', () => {
        row.classList.add('list-v');
        document.getElementById('hp-vlist').classList.add('on');
        document.getElementById('hp-vgrid').classList.remove('on');
        localStorage.setItem('hpView', 'list');
    });
    if (localStorage.getItem('hpView') === 'list') {
        document.getElementById('hp-vlist').click();
    }

    run();
})();
</script>

@endsection