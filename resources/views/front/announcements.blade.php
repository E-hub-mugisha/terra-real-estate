@extends('layouts.guest')
@section('title', 'Announcements')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap');

    :root {
        --bg:        #F7F5F2;
        --surface:   #FFFFFF;
        --border:    #E8E3DC;
        --text:      #19265d;
        --muted:     #7A736B;
        --dim:       #B0A89E;
        --accent:    #D05208;
        --accent-dk: #A04006;
        --navy:      #19265d;
        --navy-lt:   #EEF0F7;
        --green:     #1E7A5A;
        --green-bg:  rgba(30,122,90,.07);
        --amber:     #B45309;
        --amber-bg:  rgba(180,83,9,.07);
        --red:       #DC2626;
        --red-bg:    rgba(220,38,38,.07);
        --r:         12px;
        --t:         .22s cubic-bezier(.4,0,.2,1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
    }

    /* ── PAGE HEADER ── */
    .ann-header {
        background: var(--navy);
        padding: 100px 0 0;
        position: relative;
        overflow: hidden;
    }

    .ann-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 80% 50%, rgba(208,82,8,.12) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at 10% 80%, rgba(208,82,8,.06) 0%, transparent 60%);
        pointer-events: none;
    }

    .ann-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.018) 39px, rgba(255,255,255,.018) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.018) 39px, rgba(255,255,255,.018) 40px);
        pointer-events: none;
    }

    .ann-header-inner {
        position: relative;
        z-index: 2;
        padding-bottom: 36px;
    }

    .ann-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 14px;
    }

    .ann-eyebrow::before {
        content: '';
        width: 22px; height: 1px;
        background: var(--accent);
        opacity: .6;
    }

    .ann-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 600;
        letter-spacing: -.025em;
        color: #F0EDE8;
        line-height: 1.1;
        margin-bottom: 12px;
    }

    .ann-header h1 em {
        font-style: italic;
        color: var(--accent);
    }

    .ann-header p {
        font-size: .88rem;
        color: rgba(240,237,232,.45);
        max-width: 520px;
        line-height: 1.65;
    }

    .ann-header-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .ann-meta-pill {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .75rem;
        font-weight: 500;
        color: rgba(255,255,255,.4);
    }

    .ann-meta-pill svg { width: 13px; height: 13px; }
    .ann-meta-pill strong { color: rgba(255,255,255,.75); }

    /* ── STICKY FILTER BAR ── */
    .filter-bar {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
    }

    .filter-bar-inner {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 13px 0;
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
        left: 11px; top: 50%;
        transform: translateY(-50%);
        width: 15px; height: 15px;
        color: var(--dim);
        pointer-events: none;
    }

    .search-wrap input {
        width: 100%;
        padding: 8px 12px 8px 33px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .82rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        transition: border-color var(--t), background var(--t);
    }

    .search-wrap input:focus {
        outline: none;
        border-color: var(--accent);
        background: #fff;
    }

    .search-wrap input::placeholder { color: var(--dim); }

    /* Status tabs */
    .status-tabs { display: flex; gap: 4px; }

    .status-tab {
        padding: 7px 13px;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .78rem;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        transition: all var(--t);
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .status-tab .tab-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
        opacity: .5;
    }

    .status-tab:hover { border-color: var(--accent); color: var(--accent); }
    .status-tab.active { background: var(--accent); border-color: var(--accent); color: #fff; }
    .status-tab.active .tab-dot { opacity: 1; background: rgba(255,255,255,.7); }

    /* Sort select */
    .filter-select {
        padding: 7px 28px 7px 11px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .78rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='11' viewBox='0 0 24 24' fill='none' stroke='%237A736B' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 9px center no-repeat;
        appearance: none;
        cursor: pointer;
        transition: border-color var(--t);
    }

    .filter-select:focus { outline: none; border-color: var(--accent); }

    /* Result count */
    .result-count {
        font-size: .78rem;
        color: var(--muted);
        white-space: nowrap;
        margin-left: auto;
    }

    .result-count strong { color: var(--text); }

    /* ── CONTENT AREA ── */
    .ann-body { padding: 36px 0 60px; }

    /* ── ANNOUNCEMENT CARD ── */
    .ann-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        padding: 24px 26px;
        display: flex;
        gap: 20px;
        align-items: flex-start;
        text-decoration: none;
        color: inherit;
        transition: transform var(--t), box-shadow var(--t), border-color var(--t);
        animation: fadeUp .4s ease both;
        position: relative;
        overflow: hidden;
    }

    .ann-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: transparent;
        transition: background var(--t);
    }

    .ann-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(0,0,0,.09);
        border-color: rgba(208,82,8,.25);
        text-decoration: none;
        color: inherit;
    }

    .ann-card:hover::before { background: var(--accent); }

    /* Date column */
    .ann-date-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 52px;
        flex-shrink: 0;
        padding-top: 2px;
    }

    .ann-date-day {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--navy);
        line-height: 1;
    }

    .ann-date-month {
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--accent);
        margin-top: 2px;
    }

    .ann-date-year {
        font-size: .65rem;
        color: var(--dim);
        margin-top: 1px;
    }

    /* Divider line */
    .ann-divider {
        width: 1px;
        background: var(--border);
        align-self: stretch;
        flex-shrink: 0;
    }

    /* Main content */
    .ann-card-body { flex: 1; min-width: 0; }

    .ann-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .ann-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1.35;
        flex: 1;
        transition: color var(--t);
    }

    .ann-card:hover .ann-card-title { color: var(--accent); }

    /* Status badge */
    .ann-status {
        padding: 3px 9px;
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .ann-status.active   { background: var(--green-bg);  color: var(--green); }
    .ann-status.inactive { background: var(--red-bg);    color: var(--red); }
    .ann-status.draft    { background: var(--amber-bg);  color: var(--amber); }
    .ann-status.expired  { background: rgba(0,0,0,.05);  color: var(--muted); }

    .ann-excerpt {
        font-size: .84rem;
        color: var(--muted);
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .ann-card-footer {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .ann-meta {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: .72rem;
        color: var(--dim);
    }

    .ann-meta svg { width: 12px; height: 12px; flex-shrink: 0; }

    .ann-read-more {
        margin-left: auto;
        font-size: .75rem;
        font-weight: 600;
        color: var(--accent);
        display: flex;
        align-items: center;
        gap: 4px;
        transition: gap var(--t);
    }

    .ann-card:hover .ann-read-more { gap: 8px; }
    .ann-read-more svg { width: 13px; height: 13px; }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 64px 24px;
        color: var(--muted);
    }

    .empty-state svg {
        width: 52px; height: 52px;
        margin: 0 auto 16px;
        opacity: .25;
        display: block;
    }

    .empty-state h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        color: var(--text);
        font-weight: 600;
        margin-bottom: 6px;
    }

    .empty-state p { font-size: .84rem; }

    /* ── NO-RESULTS ── */
    #no-results { display: none; }

    /* ── PAGINATION ── */
    .ann-pagination { margin-top: 32px; }

    /* ── ANIMATIONS ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 640px) {
        .ann-card { flex-direction: column; gap: 14px; }
        .ann-date-col { flex-direction: row; align-items: baseline; gap: 6px; width: auto; }
        .ann-divider { display: none; }
        .filter-bar-inner { gap: 8px; }
        .status-tabs { overflow-x: auto; width: 100%; }
    }
</style>

@section('content')

{{-- ── PAGE HEADER ── --}}
<div class="ann-header">
    <div class="container ann-header-inner">
        <div class="ann-eyebrow">Terra Platform</div>
        <h1>Official <em>Announcements</em></h1>
        <p>Stay informed with the latest updates, notices, and news from Terra.</p>

        <div class="ann-header-meta">
            <div class="ann-meta-pill">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
                <strong>{{ $announcements->total() }}</strong> total announcements
            </div>
            <div class="ann-meta-pill">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
                Updated regularly
            </div>
        </div>
    </div>
</div>

{{-- ── STICKY FILTER BAR ── --}}
<div class="filter-bar">
    <div class="container">
        <div class="filter-bar-inner">

            {{-- Search --}}
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" id="filter-search" placeholder="Search announcements…" autocomplete="off">
            </div>

            {{-- Status tabs --}}
            <div class="status-tabs">
                <button class="status-tab active" data-status="all">
                    <span class="tab-dot"></span> All
                </button>
                <button class="status-tab" data-status="active">
                    <span class="tab-dot" style="background:#1E7A5A"></span> Active
                </button>
                <button class="status-tab" data-status="draft">
                    <span class="tab-dot" style="background:#B45309"></span> Draft
                </button>
                <button class="status-tab" data-status="inactive">
                    <span class="tab-dot" style="background:#DC2626"></span> Inactive
                </button>
            </div>

            {{-- Sort --}}
            <select class="filter-select" id="filter-sort">
                <option value="newest">Newest first</option>
                <option value="oldest">Oldest first</option>
                <option value="az">A → Z</option>
                <option value="za">Z → A</option>
            </select>

            {{-- Result count --}}
            <span class="result-count">
                <strong id="visible-count">{{ $announcements->count() }}</strong> shown
            </span>

        </div>
    </div>
</div>

{{-- ── BODY ── --}}
<div class="container ann-body">

    @if ($announcements->count())

        <div id="ann-list" class="d-flex flex-column gap-3">
            @foreach ($announcements as $i => $ann)
            @php
                $status = $ann->status ?? 'active';
                $now = now();
                if ($ann->end_date && $ann->end_date->isPast()) $status = 'expired';
            @endphp
            <a href="{{ route('front.announcements.show', $ann->slug) }}"
                class="ann-card"
                data-title="{{ strtolower($ann->title) }}"
                data-status="{{ $status }}"
                data-created="{{ $ann->created_at->timestamp }}"
                style="animation-delay: {{ $i * 0.05 }}s">

                {{-- Date column --}}
                <div class="ann-date-col">
                    <div class="ann-date-day">{{ $ann->created_at->format('d') }}</div>
                    <div class="ann-date-month">{{ $ann->created_at->format('M') }}</div>
                    <div class="ann-date-year">{{ $ann->created_at->format('Y') }}</div>
                </div>

                <div class="ann-divider"></div>

                {{-- Body --}}
                <div class="ann-card-body">
                    <div class="ann-card-top">
                        <h2 class="ann-card-title">{{ $ann->title }}</h2>
                        <span class="ann-status {{ $status }}">{{ ucfirst($status) }}</span>
                    </div>

                    <p class="ann-excerpt">{{ strip_tags($ann->content) }}</p>

                    <div class="ann-card-footer">
                        @if($ann->creator)
                        <span class="ann-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            {{ $ann->creator->name }}
                        </span>
                        @endif

                        @if($ann->start_date)
                        <span class="ann-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM7 11h5v5H7z"/>
                            </svg>
                            From {{ $ann->start_date->format('d M Y') }}
                            @if($ann->end_date) · Until {{ $ann->end_date->format('d M Y') }} @endif
                        </span>
                        @endif

                        <span class="ann-read-more">
                            Read more
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        {{-- No results message --}}
        <div id="no-results" class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/>
            </svg>
            <h3>No announcements found</h3>
            <p>Try adjusting your search or filter.</p>
        </div>

        {{-- Pagination --}}
        <div class="ann-pagination">
            {{ $announcements->links() }}
        </div>

    @else

        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/>
            </svg>
            <h3>No announcements yet</h3>
            <p>Check back later for updates from Terra.</p>
        </div>

    @endif

</div>

<script>
(function () {
    'use strict';

    const list      = document.getElementById('ann-list');
    if (!list) return;

    const cards     = Array.from(list.querySelectorAll('.ann-card'));
    const searchEl  = document.getElementById('filter-search');
    const sortEl    = document.getElementById('filter-sort');
    const tabs      = document.querySelectorAll('.status-tab');
    const countEl   = document.getElementById('visible-count');
    const noResults = document.getElementById('no-results');

    let state = { search: '', status: 'all', sort: 'newest' };

    function debounce(fn, ms) {
        let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); };
    }

    function apply() {
        const q = state.search.trim().toLowerCase();

        let visible = cards.filter(c => {
            if (state.status !== 'all' && c.dataset.status !== state.status) return false;
            if (q && !c.dataset.title.includes(q)) return false;
            return true;
        });

        visible.sort((a, b) => {
            switch (state.sort) {
                case 'oldest': return Number(a.dataset.created) - Number(b.dataset.created);
                case 'az':     return a.dataset.title.localeCompare(b.dataset.title);
                case 'za':     return b.dataset.title.localeCompare(a.dataset.title);
                default:       return Number(b.dataset.created) - Number(a.dataset.created);
            }
        });

        const set = new Set(visible);
        cards.forEach(c => { c.style.display = set.has(c) ? '' : 'none'; });
        visible.forEach(c => list.appendChild(c));

        countEl.textContent  = visible.length;
        noResults.style.display = visible.length === 0 ? 'block' : 'none';
    }

    searchEl.addEventListener('input', debounce(e => { state.search = e.target.value; apply(); }, 220));
    sortEl.addEventListener('change', e => { state.sort = e.target.value; apply(); });

    tabs.forEach(tab => tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        state.status = tab.dataset.status;
        apply();
    }));

    apply();
})();
</script>

@endsection