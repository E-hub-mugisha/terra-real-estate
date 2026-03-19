@extends('layouts.guest')
@section('title', 'Terra Jobs — Opportunities')
@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">

<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --bg: #0e0e0e;
        --surface: #161616;
        --border: #242424;
        --muted: #5a5a5a;
        --text: #e8e2d9;
        --text-dim: #9e9891;
        --accent: #c9a96e;
        --accent-lt: #e4c990;
        --danger: #e05c5c;
        --green: #6bcb8b;
        --radius: 6px;
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        font-weight: 300;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* ── Noise overlay ── */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
        pointer-events: none;
        z-index: 0;
    }

    /* ── Header ── */
    header {
        position: sticky;
        top: 0;
        z-index: 100;
        background: rgba(14, 14, 14, .88);
        backdrop-filter: blur(18px);
        border-bottom: 1px solid var(--border);
        padding: 0 clamp(1.5rem, 5vw, 4rem);
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 64px;
    }

    .logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 900;
        letter-spacing: -.02em;
        color: var(--text);
        text-decoration: none;
    }

    .logo span {
        color: var(--accent);
    }

    .header-actions {
        display: flex;
        gap: .75rem;
        align-items: center;
    }

    /* ── Wrapper ── */
    .wrapper {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 clamp(1.5rem, 5vw, 4rem);
        position: relative;
        z-index: 1;
    }

    /* ── Hero ── */
    .hero {
        padding: 5rem 0 3.5rem;
        border-bottom: 1px solid var(--border);
    }

    .hero-label {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 1.25rem;
    }

    .hero-label::before {
        content: '';
        display: block;
        width: 20px;
        height: 1px;
        background: var(--accent);
    }

    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.6rem, 6vw, 4.8rem);
        font-weight: 900;
        line-height: .96;
        letter-spacing: -.03em;
        color: var(--text);
        max-width: 18ch;
    }

    .hero h1 em {
        font-style: italic;
        color: var(--accent);
    }

    .hero-sub {
        margin-top: 1.5rem;
        color: var(--text-dim);
        font-size: 1rem;
        max-width: 42ch;
        line-height: 1.65;
    }

    /* ── Filters bar ── */
    .filters-bar {
        padding: 1.75rem 0;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        border-bottom: 1px solid var(--border);
    }

    .search-wrap {
        position: relative;
        flex: 1;
        min-width: 240px;
        max-width: 420px;
    }

    .search-wrap svg {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: .7rem 1rem .7rem 2.6rem;
        color: var(--text);
        font-family: inherit;
        font-size: .875rem;
        font-weight: 300;
        transition: border-color .2s;
        outline: none;
    }

    .search-input::placeholder {
        color: var(--muted);
    }

    .search-input:focus {
        border-color: var(--accent);
    }

    .filter-group {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem 1rem;
        border-radius: 100px;
        border: 1px solid var(--border);
        background: transparent;
        color: var(--text-dim);
        font-family: inherit;
        font-size: .8rem;
        font-weight: 400;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }

    .filter-chip:hover,
    .filter-chip.active {
        border-color: var(--accent);
        color: var(--accent);
        background: rgba(201, 169, 110, .07);
    }

    .filter-select {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        color: var(--text-dim);
        font-family: inherit;
        font-size: .8rem;
        padding: .5rem .9rem;
        cursor: pointer;
        outline: none;
        appearance: none;
        padding-right: 2rem;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%235a5a5a' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .7rem center;
        transition: border-color .2s;
    }

    .filter-select:focus {
        border-color: var(--accent);
    }

    .results-meta {
        margin-left: auto;
        font-size: .78rem;
        color: var(--muted);
        white-space: nowrap;
    }

    .results-meta strong {
        color: var(--text-dim);
        font-weight: 500;
    }

    /* ── Grid ── */
    .jobs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 1px;
        background: var(--border);
        margin-top: 0;
    }

    /* ── Job card ── */
    .job-card {
        background: var(--surface);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        transition: background .2s;
        position: relative;
        overflow: hidden;
    }

    .job-card::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(201, 169, 110, .05) 0%, transparent 60%);
        opacity: 0;
        transition: opacity .3s;
        pointer-events: none;
    }

    .job-card:hover {
        background: #1c1c1c;
    }

    .job-card:hover::after {
        opacity: 1;
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .job-type-badge {
        display: inline-flex;
        align-items: center;
        padding: .28rem .75rem;
        border-radius: 100px;
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .06em;
        text-transform: uppercase;
        border: 1px solid;
        white-space: nowrap;
    }

    .badge-full-time {
        color: var(--green);
        border-color: rgba(107, 203, 139, .3);
        background: rgba(107, 203, 139, .06);
    }

    .badge-part-time {
        color: var(--accent);
        border-color: rgba(201, 169, 110, .3);
        background: rgba(201, 169, 110, .06);
    }

    .badge-contract {
        color: #7eb8f7;
        border-color: rgba(126, 184, 247, .3);
        background: rgba(126, 184, 247, .06);
    }

    .status-dot {
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--green);
        box-shadow: 0 0 6px var(--green);
        flex-shrink: 0;
        margin-top: .3rem;
    }

    .status-dot.inactive {
        background: var(--muted);
        box-shadow: none;
    }

    .job-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.25;
        color: var(--text);
        text-decoration: none;
        transition: color .2s;
        display: block;
    }

    .job-title:hover {
        color: var(--accent-lt);
    }

    .card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem .9rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: .35rem;
        font-size: .8rem;
        color: var(--text-dim);
    }

    .meta-item svg {
        color: var(--muted);
        flex-shrink: 0;
    }

    .job-excerpt {
        font-size: .855rem;
        color: var(--text-dim);
        line-height: 1.7;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: auto;
        padding-top: 1.2rem;
        border-top: 1px solid var(--border);
    }

    .deadline-info {
        font-size: .75rem;
        color: var(--muted);
    }

    .deadline-info.urgent {
        color: var(--danger);
    }

    .btn-apply {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .55rem 1.25rem;
        border-radius: var(--radius);
        background: var(--accent);
        color: #0e0e0e;
        font-family: inherit;
        font-size: .8rem;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: background .2s, transform .15s;
        white-space: nowrap;
    }

    .btn-apply:hover {
        background: var(--accent-lt);
        transform: translateY(-1px);
    }

    /* ── Empty state ── */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 6rem 2rem;
        background: var(--surface);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1.25rem;
        display: block;
        opacity: .4;
    }

    .empty-state h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        margin-bottom: .75rem;
        color: var(--text-dim);
    }

    .empty-state p {
        color: var(--muted);
        font-size: .9rem;
    }

    /* ── Pagination ── */
    .pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: 3rem 0;
    }

    .page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 .5rem;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        background: transparent;
        color: var(--text-dim);
        font-family: inherit;
        font-size: .82rem;
        text-decoration: none;
        cursor: pointer;
        transition: all .2s;
    }

    .page-btn:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    .page-btn.current {
        background: var(--accent);
        color: #0e0e0e;
        border-color: var(--accent);
        font-weight: 500;
    }

    .page-btn.disabled {
        opacity: .3;
        pointer-events: none;
    }

    /* ── Flash alerts ── */
    .flash {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .9rem 1.25rem;
        border-radius: var(--radius);
        font-size: .85rem;
        margin-bottom: 1.5rem;
        border-left: 3px solid;
    }

    .flash-success {
        background: rgba(107, 203, 139, .08);
        border-color: var(--green);
        color: var(--green);
    }

    .flash-error {
        background: rgba(224, 92, 92, .08);
        border-color: var(--danger);
        color: var(--danger);
    }

    /* ── Animations ── */
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

    .hero {
        animation: fadeUp .5s ease both;
    }

    .filters-bar {
        animation: fadeUp .5s .1s ease both;
    }

    .job-card {
        animation: fadeUp .45s ease both;
    }

    .job-card:nth-child(1) {
        animation-delay: .05s;
    }

    .job-card:nth-child(2) {
        animation-delay: .10s;
    }

    .job-card:nth-child(3) {
        animation-delay: .15s;
    }

    .job-card:nth-child(4) {
        animation-delay: .20s;
    }

    .job-card:nth-child(5) {
        animation-delay: .25s;
    }

    .job-card:nth-child(6) {
        animation-delay: .30s;
    }

    .job-card:nth-child(7) {
        animation-delay: .35s;
    }

    .job-card:nth-child(8) {
        animation-delay: .40s;
    }

    .job-card:nth-child(9) {
        animation-delay: .45s;
    }

    .job-card:nth-child(10) {
        animation-delay: .50s;
    }

    .job-card:nth-child(11) {
        animation-delay: .55s;
    }

    .job-card:nth-child(12) {
        animation-delay: .60s;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .jobs-grid {
            grid-template-columns: 1fr;
        }

        .results-meta {
            display: none;
        }
    }
</style>


<div class="wrapper">

    {{-- ══ HERO ══ --}}
    <section class="hero">
        <p class="hero-label">Opportunities await</p>
        <h1>Find Your Next <em>Role</em></h1>
        <p class="hero-sub">Browse curated positions across industries. Every listing is vetted — no noise, just opportunity.</p>
    </section>

    {{-- ══ FLASH MESSAGES ══ --}}
    @if(session('success'))
    <div class="flash flash-success" style="margin-top:1.5rem">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash flash-error" style="margin-top:1.5rem">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4m0 4h.01" />
        </svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ══ FILTERS ══ --}}
    <div class="filters-bar">
        {{-- Search --}}
        <form method="GET" action="{{ route('front.jobs.index') }}" style="display:contents">
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Search title or location…"
                    value="{{ request('search') }}">
            </div>

            {{-- Type filter --}}
            <div class="filter-group">
                <a href="{{ route('front.jobs.index', array_merge(request()->except('type'), ['type' => ''])) }}"
                    class="filter-chip {{ !request('type') ? 'active' : '' }}">All</a>
                <a href="{{ route('front.jobs.index', array_merge(request()->except('type'), ['type' => 'full-time'])) }}"
                    class="filter-chip {{ request('type') === 'full-time' ? 'active' : '' }}">Full-time</a>
                <a href="{{ route('front.jobs.index', array_merge(request()->except('type'), ['type' => 'part-time'])) }}"
                    class="filter-chip {{ request('type') === 'part-time' ? 'active' : '' }}">Part-time</a>
                <a href="{{ route('front.jobs.index', array_merge(request()->except('type'), ['type' => 'contract'])) }}"
                    class="filter-chip {{ request('type') === 'contract' ? 'active' : '' }}">Contract</a>
            </div>

            {{-- Sort --}}
            <select name="sort" class="filter-select" onchange="this.form.submit()">
                <option value="latest" {{ request('sort', 'latest') === 'latest'     ? 'selected' : '' }}>Latest first</option>
                <option value="salary_asc" {{ request('sort') === 'salary_asc'           ? 'selected' : '' }}>Salary ↑</option>
                <option value="salary_desc" {{ request('sort') === 'salary_desc'          ? 'selected' : '' }}>Salary ↓</option>
                <option value="deadline" {{ request('sort') === 'deadline'             ? 'selected' : '' }}>Closing soon</option>
            </select>
        </form>

        <p class="results-meta">
            Showing <strong>{{ $jobs->firstItem() }}–{{ $jobs->lastItem() }}</strong> of <strong>{{ $jobs->total() }}</strong> jobs
        </p>
    </div>

    {{-- ══ JOB GRID ══ --}}
    <div class="jobs-grid">

        @forelse($jobs as $job)
        <article class="job-card">
            {{-- Top row --}}
            <div class="card-top">
                @php
                $badgeClass = match($job->type) {
                'full-time' => 'badge-full-time',
                'part-time' => 'badge-part-time',
                'contract' => 'badge-contract',
                default => 'badge-full-time',
                };
                @endphp
                <span class="job-type-badge {{ $badgeClass }}">{{ ucfirst(str_replace('-', ' ', $job->type)) }}</span>
                <span class="status-dot {{ $job->is_active ? '' : 'inactive' }}" title="{{ $job->is_active ? 'Active' : 'Closed' }}"></span>
            </div>

            {{-- Title --}}
            <a href="{{ route('jobs.show', $job->id) }}" class="job-title">{{ $job->title }}</a>

            {{-- Meta --}}
            <div class="card-meta">
                @if($job->location)
                <span class="meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    {{ $job->location }}
                </span>
                @endif
                @if($job->salary)
                <span class="meta-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 6v2m0 8v2m-3-7h6m-6 0a3 3 0 0 0 6 0" />
                    </svg>
                    ${{ number_format($job->salary, 0) }}
                </span>
                @endif
            </div>

            {{-- Excerpt --}}
            <p class="job-excerpt">{{ Str::limit(strip_tags($job->description), 180) }}</p>

            {{-- Footer --}}
            <div class="card-footer">
                @if($job->deadline)
                @php
                $daysLeft = now()->diffInDays($job->deadline, false);
                $deadlineClass = $daysLeft <= 7 ? 'urgent' : '' ;
                    @endphp
                    <span class="deadline-info {{ $deadlineClass }}">
                    @if($daysLeft < 0)
                        Closed
                        @elseif($daysLeft===0)
                        Closes today
                        @elseif($daysLeft <=7)
                        {{ $daysLeft }}d left
                        @else
                        Due {{ \Carbon\Carbon::parse($job->deadline)->format('M j') }}
                        @endif
                        </span>
                        @else
                        <span class="deadline-info">No deadline</span>
                        @endif

                        @if($job->is_active)
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn-apply">
                            View &amp; Apply
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                        @else
                        <span class="deadline-info urgent">Position closed</span>
                        @endif
            </div>
        </article>
        @empty
        <div class="empty-state">
            <span class="empty-icon">🌿</span>
            <h3>No jobs found</h3>
            <p>Try adjusting your filters or check back soon for new listings.</p>
        </div>
        @endforelse

    </div>{{-- /.jobs-grid --}}

    {{-- ══ PAGINATION ══ --}}
    @if($jobs->hasPages())
    <div class="pagination">
        {{-- Previous --}}
        @if($jobs->onFirstPage())
        <span class="page-btn disabled">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </span>
        @else
        <a href="{{ $jobs->previousPageUrl() }}" class="page-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m15 18-6-6 6-6" />
            </svg>
        </a>
        @endif

        {{-- Page numbers --}}
        @foreach($jobs->getUrlRange(max(1, $jobs->currentPage() - 2), min($jobs->lastPage(), $jobs->currentPage() + 2)) as $page => $url)
        <a href="{{ $url }}" class="page-btn {{ $page == $jobs->currentPage() ? 'current' : '' }}">{{ $page }}</a>
        @endforeach

        {{-- Next --}}
        @if($jobs->hasMorePages())
        <a href="{{ $jobs->nextPageUrl() }}" class="page-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </a>
        @else
        <span class="page-btn disabled">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m9 18 6-6-6-6" />
            </svg>
        </span>
        @endif
    </div>
    @endif

</div>{{-- /.wrapper --}}

@endsection