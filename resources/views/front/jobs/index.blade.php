@extends('layouts.guest')
@section('title', 'Job Opportunities')

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
        --clr-job: #1a5276;
        --clr-job-light: #EBF5FB;
        --radius-card: 14px;
        --shadow-card: 0 2px 12px rgba(0,0,0,.07), 0 1px 3px rgba(0,0,0,.05);
        --shadow-hover: 0 8px 28px rgba(0,0,0,.13), 0 2px 6px rgba(0,0,0,.07);
        --transition: .22s cubic-bezier(.4,0,.2,1);
    }

    body { background: var(--clr-bg); font-family: 'DM Sans', sans-serif; }

    /* ── Header ── */
    .jobs-header {
        background: var(--clr-text);
        padding: 110px 0 48px;
        position: relative;
        overflow: hidden;
    }

    .jobs-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .jobs-header h1 {
        font-family: 'DM Serif Display', serif;
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        color: #fff;
        font-weight: 400;
        letter-spacing: -.02em;
        margin-bottom: 10px;
    }

    .jobs-header p { color: rgba(255,255,255,.6); font-size: .95rem; margin-bottom: 28px; }

    .header-stats {
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .header-stat {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .82rem;
        color: rgba(255,255,255,.5);
    }

    .header-stat strong { color: #fff; font-size: 1rem; }

    .post-job-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: var(--clr-accent);
        color: #fff;
        border-radius: 8px;
        font-weight: 600;
        font-size: .88rem;
        text-decoration: none;
        transition: background var(--transition), transform var(--transition);
    }

    .post-job-btn:hover {
        background: var(--clr-accent-dk);
        color: #fff;
        transform: translateY(-1px);
        text-decoration: none;
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
        min-width: 200px;
        max-width: 320px;
    }

    .search-wrap svg {
        position: absolute;
        left: 11px; top: 50%;
        transform: translateY(-50%);
        color: var(--clr-muted);
        width: 16px; height: 16px;
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

    .search-wrap input:focus { outline: none; border-color: var(--clr-accent); background: #fff; }

    .type-tabs { display: flex; gap: 4px; }

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

    .type-tab:hover { border-color: var(--clr-accent); color: var(--clr-accent); }
    .type-tab.active { background: var(--clr-accent); border-color: var(--clr-accent); color: #fff; }

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

    .filter-select:focus { outline: none; border-color: var(--clr-accent); }

    .result-count { font-size: .82rem; color: var(--clr-muted); white-space: nowrap; margin-left: auto; }
    .result-count strong { color: var(--clr-text); }

    /* ── Job Card ── */
    .job-card {
        background: var(--clr-surface);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-card);
        padding: 20px 22px;
        box-shadow: var(--shadow-card);
        transition: transform var(--transition), box-shadow var(--transition), border-color var(--transition);
        text-decoration: none;
        color: inherit;
        display: block;
        animation: fadeUp .35s ease both;
    }

    .job-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-hover);
        border-color: var(--clr-accent);
        text-decoration: none;
        color: inherit;
    }

    .job-card-top {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 14px;
    }

    .company-logo {
        width: 48px; height: 48px;
        border-radius: 10px;
        border: 1px solid var(--clr-border);
        object-fit: cover;
        flex-shrink: 0;
        background: var(--clr-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--clr-text);
    }

    .job-card-info { flex: 1; min-width: 0; }

    .job-title {
        font-size: .98rem;
        font-weight: 700;
        color: var(--clr-text);
        margin: 0 0 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .company-name {
        font-size: .82rem;
        color: var(--clr-muted);
        margin: 0;
    }

    .job-badges {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .job-badge {
        padding: 3px 9px;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .03em;
    }

    .badge-type { background: var(--clr-job-light); color: var(--clr-job); }
    .badge-fulltime { background: #E8F5E9; color: #2E7D32; }
    .badge-parttime { background: #FFF8E1; color: #F57F17; }
    .badge-contract { background: #F3E5F5; color: #6A1B9A; }
    .badge-internship { background: #E3F2FD; color: #1565C0; }
    .badge-remote { background: #E0F2F1; color: #00695C; }

    .job-meta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        font-size: .78rem;
        color: var(--clr-muted);
    }

    .job-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .job-meta svg { width: 13px; height: 13px; flex-shrink: 0; }

    .job-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid var(--clr-border);
    }

    .job-salary {
        font-size: .88rem;
        font-weight: 700;
        color: var(--clr-accent);
    }

    .job-salary small {
        font-size: .72rem;
        font-weight: 400;
        color: var(--clr-muted);
        margin-left: 4px;
    }

    .expires-badge {
        font-size: .72rem;
        color: var(--clr-muted);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .expires-badge.urgent { color: #e53e3e; }
    .expires-badge svg { width: 12px; height: 12px; }

    /* ── Empty state ── */
    #no-results {
        display: none;
        text-align: center;
        padding: 60px 20px;
        color: var(--clr-muted);
    }

    #no-results svg { width: 48px; height: 48px; margin-bottom: 16px; opacity: .4; }
    #no-results h3 { font-size: 1rem; color: var(--clr-text); margin-bottom: 6px; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .filter-bar .inner { gap: 8px; }
        .type-tabs { width: 100%; overflow-x: auto; }
    }
</style>

@section('content')

{{-- ── Header ── --}}
<div class="jobs-header">
    <div class="container">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
            <div>
                <h1>Job Opportunities</h1>
                <p>Find your next career move from verified companies across Rwanda</p>
                <div class="header-stats">
                    <div class="header-stat">
                        <strong>{{ $jobs->count() }}</strong> active jobs
                    </div>
                    <div class="header-stat">
                        <strong>{{ $jobs->unique('company_name')->count() }}</strong> companies
                    </div>
                </div>
            </div>
            <a href="{{ route('front.jobs.create') }}" class="post-job-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Post a Job
            </a>
        </div>
    </div>
</div>

{{-- ── Filter Bar ── --}}
<div class="filter-bar">
    <div class="container">
        <div class="inner">
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" id="filter-search" placeholder="Job title or company…" autocomplete="off">
            </div>

            <div class="type-tabs">
                <button class="type-tab active" data-type="all">All</button>
                <button class="type-tab" data-type="full-time">Full Time</button>
                <button class="type-tab" data-type="part-time">Part Time</button>
                <button class="type-tab" data-type="contract">Contract</button>
                <button class="type-tab" data-type="internship">Internship</button>
                <button class="type-tab" data-type="remote">Remote</button>
            </div>

            <select class="filter-select" id="filter-location">
                <option value="">All Locations</option>
                <option value="kigali">Kigali</option>
                <option value="northern">Northern Province</option>
                <option value="southern">Southern Province</option>
                <option value="eastern">Eastern Province</option>
                <option value="western">Western Province</option>
            </select>

            <select class="filter-select" id="filter-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="deadline">Closing Soon</option>
            </select>

            <span class="result-count">
                <strong id="visible-count">{{ $jobs->count() }}</strong> listings
            </span>
        </div>
    </div>
</div>

{{-- ── Job Listings ── --}}
<div class="container py-5">
    <div id="jobs-list" class="d-flex flex-column gap-3">
        @forelse($jobs as $job)
        <a href="{{ route('front.jobs.show', $job->slug) }}"
            class="job-card"
            data-type="{{ $job->job_type }}"
            data-title="{{ strtolower($job->title) }}"
            data-company="{{ strtolower($job->company_name) }}"
            data-location="{{ strtolower($job->location) }}"
            data-created="{{ $job->published_at?->timestamp ?? 0 }}"
            data-deadline="{{ $job->application_deadline?->timestamp ?? 9999999999 }}"
            style="animation-delay: {{ $loop->index * 0.05 }}s">

            <div class="job-card-top">
                @if($job->company_logo)
                    <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company_name }}" class="company-logo">
                @else
                    <div class="company-logo">{{ strtoupper(substr($job->company_name, 0, 1)) }}</div>
                @endif

                <div class="job-card-info">
                    <h3 class="job-title">{{ $job->title }}</h3>
                    <p class="company-name">{{ $job->company_name }}</p>
                </div>
            </div>

            <div class="job-badges">
                <span class="job-badge badge-type">{{ $job->job_type_label }}</span>
                @if($job->category)
                <span class="job-badge" style="background:#F5F5F5;color:var(--clr-muted)">{{ $job->category }}</span>
                @endif
            </div>

            <div class="job-meta">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    {{ $job->location }}
                </span>
                @if($job->application_deadline)
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM7 11h5v5H7z"/>
                    </svg>
                    Closes {{ $job->application_deadline->format('d M Y') }}
                </span>
                @endif
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    Posted {{ $job->published_at?->diffForHumans() ?? 'Recently' }}
                </span>
            </div>

            <div class="job-card-footer">
                <div class="job-salary">
                    {{ $job->salary_range }}
                </div>
                <div class="expires-badge {{ $job->days_remaining <= 3 ? 'urgent' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                    {{ $job->days_remaining }} day{{ $job->days_remaining === 1 ? '' : 's' }} left
                </div>
            </div>
        </a>
        @empty
        <div style="text-align:center;padding:60px 20px;color:var(--clr-muted)">
            <p>No active job listings at the moment.</p>
        </div>
        @endforelse
    </div>

    <div id="no-results">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/>
        </svg>
        <h3>No jobs found</h3>
        <p>Try adjusting your search or filters.</p>
    </div>
</div>

<script>
(function () {
    'use strict';

    const list      = document.getElementById('jobs-list');
    const allCards  = Array.from(list.querySelectorAll('.job-card'));
    const search    = document.getElementById('filter-search');
    const locSel    = document.getElementById('filter-location');
    const sortSel   = document.getElementById('filter-sort');
    const typeTabs  = document.querySelectorAll('.type-tab');
    const noResults = document.getElementById('no-results');
    const countEl   = document.getElementById('visible-count');

    let state = { type: 'all', search: '', location: '', sort: 'newest' };

    function debounce(fn, ms) {
        let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); };
    }

    function applyFilters() {
        const q = state.search.trim().toLowerCase();

        let visible = allCards.filter(c => {
            const d = c.dataset;
            if (state.type !== 'all' && d.type !== state.type) return false;
            if (q && !(d.title + ' ' + d.company).includes(q)) return false;
            if (state.location && !d.location.includes(state.location)) return false;
            return true;
        });

        visible.sort((a, b) => {
            if (state.sort === 'oldest')   return Number(a.dataset.created) - Number(b.dataset.created);
            if (state.sort === 'deadline') return Number(a.dataset.deadline) - Number(b.dataset.deadline);
            return Number(b.dataset.created) - Number(a.dataset.created);
        });

        const set = new Set(visible);
        allCards.forEach(c => { c.style.display = set.has(c) ? '' : 'none'; });
        visible.forEach(c => list.appendChild(c));

        countEl.textContent = visible.length;
        noResults.style.display = visible.length === 0 ? 'block' : 'none';
    }

    search.addEventListener('input', debounce(e => { state.search = e.target.value; applyFilters(); }, 250));
    locSel.addEventListener('change', e => { state.location = e.target.value; applyFilters(); });
    sortSel.addEventListener('change', e => { state.sort = e.target.value; applyFilters(); });
    typeTabs.forEach(t => t.addEventListener('click', () => {
        typeTabs.forEach(x => x.classList.remove('active'));
        t.classList.add('active');
        state.type = t.dataset.type;
        applyFilters();
    }));
})();
</script>

@endsection