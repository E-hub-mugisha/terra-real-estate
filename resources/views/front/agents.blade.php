@extends('layouts.guest')
@section('title', 'Meet Our Agents')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --bg2: #FFFFFF;
        --bg3: #F2EFE9;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .16);
        --gold: #C8873A;
        --text: #1A1714;
        --muted: #6B6560;
        --muted2: #3D3830;
        --dim: #9E9890;
        --r: 13px;
        --t: .18s cubic-bezier(.4, 0, .2, 1);
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

    /* ── make <a> fill its col so entire card is clickable ── */
    #ag-grid .col-xl-3>a,
    #ag-grid .col-lg-4>a,
    #ag-grid .col-md-6>a,
    #ag-grid .col-12>a {
        display: block;
        height: 100%;
    }

    /* ── Hero ── */
    .ah-hero {
        position: relative;
        padding: 100px 0 52px;
        text-align: center;
        overflow: hidden;
    }

    .ah-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 60% 45% at 50% 0%, rgba(200, 135, 58, .08) 0%, transparent 70%);
        pointer-events: none;
    }

    .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 16px;
    }

    .eyebrow::before,
    .eyebrow::after {
        content: '';
        width: 24px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .ah-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.2rem, 5vw, 3.8rem);
        font-weight: 500;
        line-height: 1.1;
        letter-spacing: -.02em;
    }

    .ah-hero h1 em {
        font-style: italic;
        color: var(--gold);
    }

    .ah-hero .sub {
        margin-top: 14px;
        font-size: .85rem;
        color: var(--muted);
        max-width: 420px;
        margin-inline: auto;
        line-height: 1.65;
    }

    /* ── Filter Panel ── */
    .fp {
        background: #FFFFFF;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .fp-top {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        flex-wrap: wrap;
    }

    .fp-bot {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 10px 0;
        flex-wrap: wrap;
    }

    .fp-bot label {
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--dim);
        white-space: nowrap;
        margin-right: 2px;
        margin-bottom: 0;
    }

    /* Search */
    .af-search {
        position: relative;
        flex: 1;
        min-width: 160px;
        max-width: 260px;
    }

    .af-search svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 13px;
        height: 13px;
        color: var(--muted);
    }

    .af-search input {
        width: 100%;
        padding: 8px 10px 8px 30px;
        background: var(--bg3);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: .8rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        transition: border-color var(--t);
    }

    .af-search input::placeholder {
        color: var(--dim);
    }

    .af-search input:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: none;
    }

    /* Right meta */
    .fp-right {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .af-count {
        font-size: .78rem;
        color: var(--dim);
        white-space: nowrap;
    }

    .af-count strong {
        color: var(--muted2);
    }

    .clear-btn {
        padding: 5px 11px;
        border-radius: 7px;
        border: 1px solid var(--border);
        background: transparent;
        font-size: .74rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--muted);
        cursor: pointer;
        transition: all var(--t);
        display: none;
    }

    .clear-btn.vis {
        display: block;
    }

    .clear-btn:hover {
        border-color: var(--gold);
        color: var(--gold);
    }

    /* Selects */
    .fsel {
        padding: 6px 26px 6px 10px;
        background: var(--bg3) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 7px center no-repeat;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: .78rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--muted2);
        appearance: none;
        cursor: pointer;
        transition: border-color var(--t), color var(--t);
    }

    .fsel:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: none;
    }

    .fsel.active {
        border-color: rgba(200, 135, 58, .45);
        color: var(--gold);
    }

    .fsel option {
        background: #FFFFFF;
        color: var(--text);
    }

    .fp-divider {
        width: 1px;
        height: 18px;
        background: var(--border);
        margin: 0 2px;
        flex-shrink: 0;
    }

    /* Active filter chips */
    .fp-chips {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 20px;
        background: rgba(200, 135, 58, .1);
        border: 1px solid rgba(200, 135, 58, .22);
        font-size: .71rem;
        color: var(--gold);
        cursor: pointer;
        transition: background var(--t);
    }

    .chip:hover {
        background: rgba(200, 135, 58, .2);
    }

    .chip-x {
        font-size: .65rem;
        opacity: .65;
    }

    /* ── Section ── */
    .ag-section {
        padding: 28px 0 72px;
    }

    /* ── Card ── */
    .ag-card {
        background: var(--bg2);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        animation: fadeUp .38s ease both;
    }

    .ag-card:hover {
        transform: translateY(-4px);
        border-color: var(--border2);
        box-shadow: 0 14px 36px rgba(0, 0, 0, .10), 0 0 0 1px rgba(200, 135, 58, .15);
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

    /* Image */
    .ag-img {
        position: relative;
        aspect-ratio: 1 / 1.05;
        overflow: hidden;
        background: var(--bg3);
        flex-shrink: 0;
    }

    .ag-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        display: block;
        transition: transform .45s ease, filter .45s ease;
        filter: grayscale(15%);
    }

    .ag-card:hover .ag-img img {
        transform: scale(1.06);
        filter: grayscale(0%);
    }

    .ag-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(20, 15, 10, .80) 0%, transparent 52%);
        opacity: 0;
        transition: opacity var(--t);
        display: flex;
        align-items: flex-end;
        padding: 12px;
    }

    .ag-card:hover .ag-overlay {
        opacity: 1;
    }

    .ag-socials {
        display: flex;
        gap: 5px;
    }

    .ag-soc {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .14);
        display: grid;
        place-items: center;
        color: #fff;
        font-size: .75rem;
        transition: background var(--t), transform var(--t);
    }

    .ag-soc:hover {
        background: var(--gold);
        transform: translateY(-2px);
    }

    .ag-rbadge {
        position: absolute;
        top: 9px;
        left: 9px;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: .64rem;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        z-index: 2;
        background: rgba(59, 138, 110, .15);
        color: #1E7A5A;
        border: 1px solid rgba(59, 138, 110, .25);
    }

    .ag-verified {
        position: absolute;
        top: 9px;
        right: 9px;
        width: 22px;
        height: 22px;
        background: var(--gold);
        border-radius: 50%;
        display: grid;
        place-items: center;
    }

    .ag-verified svg {
        width: 11px;
        height: 11px;
    }

    /* Body */
    .ag-body {
        padding: 13px 14px 14px;
        display: flex;
        flex-direction: column;
        gap: 9px;
        flex: 1;
    }

    .ag-spec {
        font-size: .67rem;
        font-weight: 500;
        color: var(--gold);
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .ag-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.2;
        letter-spacing: -.01em;
        margin: 0;
    }

    .ag-loc {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .73rem;
        color: var(--muted);
    }

    .ag-loc svg {
        width: 10px;
        height: 10px;
        flex-shrink: 0;
        color: var(--gold);
    }

    .ag-rating {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .ag-stars {
        display: flex;
        gap: 1px;
    }

    .ag-star {
        width: 10px;
        height: 10px;
        color: var(--gold);
    }

    .ag-star.empty {
        color: #D9D4CC;
    }

    .ag-rval {
        font-size: .73rem;
        color: var(--muted);
    }

    .ag-meta {
        display: flex;
        border-top: 1px solid var(--border);
        padding-top: 9px;
    }

    .ag-stat {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1px;
        padding-right: 8px;
    }

    .ag-stat+.ag-stat {
        border-left: 1px solid var(--border);
        padding-left: 8px;
        padding-right: 0;
    }

    .ag-stat span:first-child {
        font-size: .63rem;
        color: var(--dim);
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .ag-stat span:last-child {
        font-size: .82rem;
        font-weight: 500;
        color: var(--muted2);
    }

    .ag-cta {
        margin-top: auto;
    }

    .ag-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 8px 13px;
        border-radius: 8px;
        width: 100%;
        background: rgba(200, 135, 58, .08);
        border: 1px solid rgba(200, 135, 58, .2);
        color: var(--gold);
        font-size: .77rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        transition: all var(--t);
    }

    .ag-card:hover .ag-btn {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .ag-btn svg {
        width: 12px;
        height: 12px;
        transition: transform var(--t);
    }

    .ag-card:hover .ag-btn svg {
        transform: translateX(3px);
    }

    /* Empty state */
    .ag-empty {
        text-align: center;
        padding: 64px 20px;
        color: var(--dim);
    }

    .ag-empty strong {
        display: block;
        font-size: .95rem;
        color: var(--muted);
        margin-bottom: 6px;
    }
</style>

{{-- ── Hero ── --}}
<div class="ah-hero">
    <div class="container">
        <div class="eyebrow">Verified Professionals</div>
        <h1>Meet our <em>agents</em></h1>
        <p class="sub">Every agent on Terra is verified, experienced, and ready to guide your property journey.</p>
    </div>
</div>

{{-- ── Filter Panel ── --}}
<div class="fp">
    <div class="container">

        {{-- Top row --}}
        <div class="fp-top">
            <div class="af-search">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="text" id="af-q" placeholder="Search by name or specialty…" autocomplete="off">
            </div>
            <div class="fp-right">
                <div class="fp-chips" id="af-chips"></div>
                <span class="af-count"><strong id="af-count">0</strong> agents</span>
                <button class="clear-btn" id="af-clear">Clear all</button>
            </div>
        </div>

        {{-- Bottom row --}}
        <div class="fp-bot">
            <label>Filter by</label>
            <select class="fsel" id="af-loc">
                <option value="">Location</option>
                <option value="kigali">Kigali</option>
                <option value="gasabo">Gasabo</option>
                <option value="kicukiro">Kicukiro</option>
                <option value="nyarugenge">Nyarugenge</option>
                <option value="musanze">Musanze</option>
                <option value="huye">Huye</option>
                <option value="rubavu">Rubavu</option>
                <option value="nyagatare">Nyagatare</option>
            </select>
            <select class="fsel" id="af-exp">
                <option value="">Experience</option>
                <option value="1">1–3 years</option>
                <option value="3">3–6 years</option>
                <option value="6">6–10 years</option>
                <option value="10">10+ years</option>
            </select>
            <select class="fsel" id="af-list">
                <option value="">Listings</option>
                <option value="1">1–10</option>
                <option value="10">10–20</option>
                <option value="20">20+</option>
            </select>
            <select class="fsel" id="af-rat">
                <option value="">Rating</option>
                <option value="5">5 stars</option>
                <option value="4">4+ stars</option>
                <option value="3">3+ stars</option>
            </select>
            <select class="fsel" id="af-spec">
                <option value="">Specialty</option>
                <option value="Residential">Residential</option>
                <option value="Commercial">Commercial</option>
                <option value="Land">Land &amp; Plots</option>
                <option value="Luxury">Luxury</option>
            </select>
            <div class="fp-divider"></div>
            <select class="fsel" id="af-sort">
                <option value="default">Sort: Default</option>
                <option value="name-asc">Name A → Z</option>
                <option value="name-desc">Name Z → A</option>
                <option value="listings">Most Listings</option>
                <option value="rating">Highest Rated</option>
                <option value="exp">Most Experienced</option>
            </select>
        </div>

    </div>
</div>

{{-- ── Agent Grid ── --}}
<div class="ag-section">
    <div class="container">
        <div class="row g-3" id="ag-grid">

            @forelse($agents as $i => $agent)
            @php
            $fullStars = (int) round($agent->rating ?? 5);
            @endphp

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                {{-- fills col height → entire card is clickable --}}
                <div class="ag-card" style="animation-delay: {{ $i * 0.04 }}s">

                    {{-- Image --}}
                    <div class="ag-img">
                        <span class="ag-rbadge">Agent</span>
                        <span class="ag-verified" title="Verified">
                            <svg viewBox="0 0 24 24" fill="white">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>

                        <img src="{{ $agent->profile_photo
                                            ? asset('storage/' . $agent->profile_photo)
                                            : asset('front/assets/img/all-images/team/team-img1.png') }}"
                            alt="{{ $agent->full_name }}"
                            loading="lazy">

                        <div class="ag-overlay">
                            <div class="ag-socials">
                                @if($agent->facebook)
                                <a href="{{ $agent->facebook }}"
                                    onclick="event.stopPropagation()"
                                    target="_blank" rel="noopener"
                                    class="ag-soc">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                @endif
                                @if($agent->linkedin)
                                <a href="{{ $agent->linkedin }}"
                                    onclick="event.stopPropagation()"
                                    target="_blank" rel="noopener"
                                    class="ag-soc">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                                @endif
                                @if($agent->instagram)
                                <a href="{{ $agent->instagram }}"
                                    onclick="event.stopPropagation()"
                                    target="_blank" rel="noopener"
                                    class="ag-soc">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="ag-body">
                        <div>
                            <p class="ag-spec">{{ $agent->specialty ?? $agent->role ?? 'Real Estate' }} Agent</p>
                            <h3 class="ag-name">{{ $agent->full_name }}</h3>
                        </div>

                        @if($agent->district ?? $agent->location ?? false)
                        <div class="ag-loc">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                            </svg>
                            {{ $agent->district ?? $agent->location }}
                        </div>
                        @endif

                        @if($agent->rating ?? false)
                        <div class="ag-rating">
                            <div class="ag-stars">
                                @for($s = 1; $s <= 5; $s++)
                                    <svg class="ag-star {{ $s > $fullStars ? 'empty' : '' }}"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    @endfor
                            </div>
                            <span class="ag-rval">{{ number_format($agent->rating, 1) }}</span>
                        </div>
                        @endif

                        <div class="ag-meta">
                            <div class="ag-stat">
                                <span>Listings</span>
                                <span>{{ $agent->properties_count ?? '—' }}</span>
                            </div>
                            @if($agent->experience_years ?? false)
                            <div class="ag-stat">
                                <span>Experience</span>
                                <span>{{ $agent->experience_years }}y</span>
                            </div>
                            @endif
                            @if($agent->phone ?? false)
                            <div class="ag-stat">
                                <span>Phone</span>
                                <span style="font-size:.7rem">{{ Str::limit($agent->phone, 14) }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="ag-cta">
                            <a href="{{ route('front.agent.details', $agent) }}" class="ag-btn">
                                View Profile
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>{{-- /.ag-card --}}
            </div>{{-- /.col --}}

            @empty
            <div class="col-12">
                <div class="ag-empty">
                    <strong>No agents found</strong>
                    <p>Check back soon or adjust your filters.</p>
                </div>
            </div>
            @endforelse

        </div>{{-- /.row --}}
    </div>
</div>

<script>
    (function() {
        const grid = document.getElementById('ag-grid');
        const cards = Array.from(grid.querySelectorAll('.ag-card'));
        const fcount = document.getElementById('af-count');
        const chipsEl = document.getElementById('af-chips');
        const clearBtn = document.getElementById('af-clear');

        let state = {
            q: '',
            loc: '',
            exp: '',
            list: '',
            rat: '',
            spec: '',
            sort: 'default'
        };

        function debounce(fn, ms) {
            let t;
            return (...a) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...a), ms);
            };
        }

        const expLabel = v => ({
            1: '1–3y',
            3: '3–6y',
            6: '6–10y',
            10: '10+y'
        } [v] || '');
        const listLabel = v => ({
            1: '1–10 listings',
            10: '10–20 listings',
            20: '20+ listings'
        } [v] || '');

        function updateChips() {
            const defs = {
                loc: state.loc ? state.loc.charAt(0).toUpperCase() + state.loc.slice(1) : '',
                exp: expLabel(state.exp),
                list: listLabel(state.list),
                rat: state.rat ? state.rat + '★+' : '',
                spec: state.spec
            };
            chipsEl.innerHTML = Object.entries(defs)
                .filter(([, v]) => v)
                .map(([k, v]) => `<span class="chip" data-k="${k}">${v} <span class="chip-x">×</span></span>`)
                .join('');

            const any = state.loc || state.exp || state.list || state.rat || state.spec || state.q;
            clearBtn.classList.toggle('vis', !!any);

            ['af-loc', 'af-exp', 'af-list', 'af-rat', 'af-spec'].forEach(id => {
                const key = {
                    'af-loc': 'loc',
                    'af-exp': 'exp',
                    'af-list': 'list',
                    'af-rat': 'rat',
                    'af-spec': 'spec'
                } [id];
                document.getElementById(id).classList.toggle('active', !!state[key]);
            });
        }

        chipsEl.addEventListener('click', e => {
            const chip = e.target.closest('.chip');
            if (!chip) return;
            const k = chip.dataset.k;
            state[k] = '';
            const selMap = {
                loc: 'af-loc',
                exp: 'af-exp',
                list: 'af-list',
                rat: 'af-rat',
                spec: 'af-spec'
            };
            if (selMap[k]) document.getElementById(selMap[k]).value = '';
            run();
        });

        clearBtn.addEventListener('click', () => {
            state = {
                ...state,
                q: '',
                loc: '',
                exp: '',
                list: '',
                rat: '',
                spec: ''
            };
            document.getElementById('af-q').value = '';
            ['af-loc', 'af-exp', 'af-list', 'af-rat', 'af-spec'].forEach(id => document.getElementById(id).value = '');
            run();
        });

        function run() {
            const q = state.q.trim().toLowerCase();

            let vis = cards.filter(c => {
                if (q && !c.dataset.name.includes(q) && !c.dataset.spec.toLowerCase().includes(q)) return false;
                if (state.loc && c.dataset.loc !== state.loc) return false;
                if (state.spec && c.dataset.spec !== state.spec) return false;
                if (state.rat && +c.dataset.rating < +state.rat) return false;
                if (state.exp) {
                    const ex = +c.dataset.exp;
                    if (state.exp === '1' && (ex < 1 || ex > 3)) return false;
                    if (state.exp === '3' && (ex < 3 || ex > 6)) return false;
                    if (state.exp === '6' && (ex < 6 || ex > 10)) return false;
                    if (state.exp === '10' && ex < 10) return false;
                }
                if (state.list) {
                    const li = +c.dataset.listings;
                    if (state.list === '1' && (li < 1 || li > 10)) return false;
                    if (state.list === '10' && (li < 10 || li > 20)) return false;
                    if (state.list === '20' && li < 20) return false;
                }
                return true;
            });

            vis.sort((a, b) => {
                switch (state.sort) {
                    case 'name-asc':
                        return a.dataset.name.localeCompare(b.dataset.name);
                    case 'name-desc':
                        return b.dataset.name.localeCompare(a.dataset.name);
                    case 'listings':
                        return +b.dataset.listings - +a.dataset.listings;
                    case 'rating':
                        return +b.dataset.rating - +a.dataset.rating;
                    case 'exp':
                        return +b.dataset.exp - +a.dataset.exp;
                    default:
                        return 0;
                }
            });

            const visSet = new Set(vis);

            /* Hide/show the col wrapper (not just the card) to avoid gap holes */
            cards.forEach(card => {
                const col = card.closest('[class*="col-"]');
                if (col) col.style.display = visSet.has(card) ? '' : 'none';
            });

            /* Re-order col wrappers in sorted order */
            vis.forEach(card => {
                const col = card.closest('[class*="col-"]');
                if (col) grid.appendChild(col);
            });

            fcount.textContent = vis.length;

            /* Empty state */
            const em = grid.querySelector('.ag-empty-js');
            if (vis.length === 0) {
                if (!em) {
                    const col = document.createElement('div');
                    col.className = 'col-12 ag-empty-js';
                    col.innerHTML = '<div class="ag-empty"><strong>No agents found</strong><p>Try adjusting your filters.</p></div>';
                    grid.appendChild(col);
                }
            } else if (em) {
                em.remove();
            }

            updateChips();
        }

        document.getElementById('af-q').addEventListener('input', debounce(e => {
            state.q = e.target.value;
            run();
        }, 220));
        document.getElementById('af-loc').addEventListener('change', e => {
            state.loc = e.target.value;
            run();
        });
        document.getElementById('af-exp').addEventListener('change', e => {
            state.exp = e.target.value;
            run();
        });
        document.getElementById('af-list').addEventListener('change', e => {
            state.list = e.target.value;
            run();
        });
        document.getElementById('af-rat').addEventListener('change', e => {
            state.rat = e.target.value;
            run();
        });
        document.getElementById('af-spec').addEventListener('change', e => {
            state.spec = e.target.value;
            run();
        });
        document.getElementById('af-sort').addEventListener('change', e => {
            state.sort = e.target.value;
            run();
        });

        run();
    })();
</script>

@endsection