@extends('layouts.guest')
@section('title', 'List of Professionals')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --dark: #19265d;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .14);
        --gold: #C8873A;
        --gold-lt: #E5A55E;
        --gold-bg: rgba(200, 135, 58, .07);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --green: #1E7A5A;
        --green-bg: rgba(30, 122, 90, .07);
        --green-bd: rgba(30, 122, 90, .2);
        --r: 13px;
        --t: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
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

    /* HERO */
    .cc-hero {
        background: var(--dark);
        position: relative;
        overflow: hidden;
        padding: 80px 0 72px;
    }

    .cc-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 55% 60% at 0% 50%, rgba(200, 135, 58, .12) 0%, transparent 65%),
            radial-gradient(ellipse 35% 50% at 100% 20%, rgba(200, 135, 58, .06) 0%, transparent 55%);
        pointer-events: none;
    }

    .cc-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255, 255, 255, .018) 39px, rgba(255, 255, 255, .018) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255, 255, 255, .012) 79px, rgba(255, 255, 255, .012) 80px);
        pointer-events: none;
    }

    .cc-hero-inner {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 40px;
    }

    @media (max-width:720px) {
        .cc-hero-inner {
            grid-template-columns: 1fr;
        }

        .cc-hero-stats {
            display: none;
        }
    }

    .cc-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 14px;
    }

    .cc-eyebrow::before {
        content: '';
        width: 18px;
        height: 1px;
        background: var(--gold);
        opacity: .6;
    }

    .cc-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 5vw, 3.4rem);
        font-weight: 500;
        line-height: 1.1;
        letter-spacing: -.02em;
        color: #F0EDE8;
        margin-bottom: 14px;
    }

    .cc-hero h1 em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .cc-hero>.container>.cc-hero-inner>div>p {
        font-size: .88rem;
        color: rgba(240, 237, 232, .45);
        max-width: 480px;
        line-height: 1.75;
        margin-bottom: 24px;
    }

    .cc-hero-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .cc-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 22px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .84rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), transform var(--t);
        text-decoration: none;
    }

    .cc-btn-primary:hover {
        background: #a06828;
        transform: translateY(-1px);
        color: #fff;
    }

    .cc-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 11px 22px;
        border-radius: 9px;
        background: rgba(255, 255, 255, .08);
        color: rgba(240, 237, 232, .7);
        border: 1px solid rgba(255, 255, 255, .15);
        font-size: .84rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        text-decoration: none;
    }

    .cc-btn-outline:hover {
        background: rgba(255, 255, 255, .14);
        color: #F0EDE8;
    }

    .cc-btn-primary svg,
    .cc-btn-outline svg {
        width: 14px;
        height: 14px;
    }

    .cc-hero-stats {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .cc-stat {
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 12px;
        padding: 16px 20px;
        min-width: 150px;
        text-align: center;
    }

    .cc-stat-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 600;
        color: #F0EDE8;
        line-height: 1;
        letter-spacing: -.02em;
    }

    .cc-stat-val em {
        color: var(--gold-lt);
        font-style: normal;
    }

    .cc-stat-label {
        font-size: .7rem;
        color: rgba(240, 237, 232, .35);
        text-transform: uppercase;
        letter-spacing: .08em;
        margin-top: 4px;
    }

    /* FILTER BAR */
    .cc-filter {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 12px 0;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    }

    .cc-filter-inner {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .cc-search {
        position: relative;
        flex: 1;
        min-width: 160px;
        max-width: 260px;
    }

    .cc-search svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        color: var(--dim);
        pointer-events: none;
    }

    .cc-search input {
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

    .cc-search input:focus {
        outline: none;
        border-color: var(--gold);
        background: var(--surface);
    }

    .cc-search input::placeholder {
        color: var(--dim);
    }

    .cc-tabs {
        display: flex;
        gap: 4px;
        flex-wrap: wrap;
    }

    .cc-tab {
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

    .cc-tab:hover {
        border-color: var(--gold);
        color: var(--gold);
    }

    .cc-tab.on {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .cc-select {
        padding: 7px 26px 7px 11px;
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

    .cc-select:focus {
        outline: none;
        border-color: var(--gold);
    }

    .cc-filter-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }

    .cc-count {
        font-size: .78rem;
        color: var(--dim);
        white-space: nowrap;
    }

    .cc-count strong {
        color: var(--text);
    }

    /* GRID */
    .cc-section {
        padding: 52px 0 80px;
    }

    .cc-section-header {
        margin-bottom: 28px;
    }

    .cc-section-eyebrow {
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

    .cc-section-eyebrow::before {
        content: '';
        width: 16px;
        height: 1px;
        background: var(--gold);
        opacity: .5;
    }

    .cc-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 500;
        color: var(--text);
        letter-spacing: -.02em;
    }

    .cc-section-title em {
        font-style: italic;
        color: var(--gold);
    }

    /* Card */
    .cc-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        animation: ccFu .4s ease both;
        color: var(--text);
    }

    .cc-card:hover {
        transform: translateY(-5px);
        border-color: var(--gold-bd);
        box-shadow: 0 12px 32px rgba(0, 0, 0, .09), 0 0 0 1px rgba(200, 135, 58, .1);
        color: var(--text);
    }

    @keyframes ccFu {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cc-card-photo {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: var(--bg);
    }

    .cc-card-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }

    .cc-card:hover .cc-card-photo img {
        transform: scale(1.05);
    }

    .cc-card-photo-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(14, 14, 12, .65) 0%, transparent 55%);
        opacity: 0;
        transition: opacity var(--t);
    }

    .cc-card:hover .cc-card-photo-overlay {
        opacity: 1;
    }

    .cc-card-socials {
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%) translateY(6px);
        display: flex;
        gap: 6px;
        opacity: 0;
        transition: opacity var(--t), transform var(--t);
    }

    .cc-card:hover .cc-card-socials {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .cc-soc-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .15);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, .2);
        display: grid;
        place-items: center;
        cursor: pointer;
        color: #fff;
        transition: background var(--t);
        text-decoration: none;
    }

    .cc-soc-btn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .cc-soc-btn svg {
        width: 13px;
        height: 13px;
    }

    .cc-role-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
        padding: 3px 9px;
        border-radius: 6px;
        background: rgba(14, 14, 12, .75);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, .12);
        font-size: .64rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: rgba(240, 237, 232, .8);
    }

    .cc-verified {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(30, 122, 90, .85);
        backdrop-filter: blur(6px);
        display: grid;
        place-items: center;
    }

    .cc-verified svg {
        width: 13px;
        height: 13px;
        color: #fff;
    }

    .cc-card-body {
        padding: 16px 16px 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .cc-card-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text);
        letter-spacing: -.01em;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .cc-card-title {
        font-size: .78rem;
        color: var(--gold);
        font-weight: 500;
        margin-bottom: 10px;
    }

    .cc-card-bio {
        font-size: .78rem;
        color: var(--muted);
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .cc-card-tags {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .cc-card-tag {
        padding: 2px 8px;
        border-radius: 5px;
        font-size: .66rem;
        font-weight: 600;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        color: var(--muted);
        letter-spacing: .03em;
    }

    .cc-card-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 11px;
        border-top: 1px solid var(--border);
        margin-top: auto;
        flex-wrap: wrap;
    }

    .cc-card-meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .72rem;
        color: var(--dim);
    }

    .cc-card-meta-item svg {
        width: 12px;
        height: 12px;
        color: var(--gold);
    }

    .cc-card-link {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .76rem;
        font-weight: 600;
        color: var(--gold);
        transition: gap var(--t);
        pointer-events: none;
    }

    .cc-card-link svg {
        width: 12px;
        height: 12px;
    }

    .cc-stars {
        display: flex;
        gap: 1px;
        align-items: center;
    }

    .cc-stars svg {
        width: 10px;
        height: 10px;
    }

    .cc-star-on {
        color: var(--gold);
    }

    .cc-star-off {
        color: var(--border2);
    }

    .cc-empty {
        text-align: center;
        padding: 64px 20px;
        color: var(--dim);
    }

    .cc-empty svg {
        width: 44px;
        height: 44px;
        margin-bottom: 14px;
        opacity: .3;
    }

    .cc-empty h3 {
        font-size: .95rem;
        color: var(--muted);
        margin-bottom: 6px;
    }

    /* JOIN */
    .cc-join {
        background: var(--dark);
        position: relative;
        overflow: hidden;
        padding: 56px 0;
        margin-top: 12px;
    }

    .cc-join::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 55% 60% at 80% 50%, rgba(200, 135, 58, .11) 0%, transparent 65%);
        pointer-events: none;
    }

    .cc-join-inner {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
        flex-wrap: wrap;
    }

    .cc-join-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        font-weight: 500;
        color: #F0EDE8;
        letter-spacing: -.02em;
    }

    .cc-join-title em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .cc-join-desc {
        font-size: .84rem;
        color: rgba(240, 237, 232, .4);
        margin-top: 6px;
    }

    .cc-join-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .85rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), transform var(--t);
        white-space: nowrap;
        text-decoration: none;
    }

    .cc-join-btn:hover {
        background: #a06828;
        transform: translateY(-1px);
        color: #fff;
    }

    .cc-join-btn svg {
        width: 14px;
        height: 14px;
    }
</style>

{{-- HERO --}}
<section class="cc-hero">
    <div class="container">
        <div class="cc-hero-inner">
            <div>
                <div class="cc-eyebrow">Expert Guidance</div>
                <h1>Meet our <em>certified<br>professionals</em></h1>
                <p>Work directly with experienced real estate professionals who know Rwanda's property market inside out — from land valuation to investment strategy.</p>
                <div class="cc-hero-actions">
                    <button class="cc-btn-primary" onclick="document.getElementById('cc-grid-section').scrollIntoView({behavior:'smooth'})">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        Browse Professionals
                    </button>
                    <a href="{{ route('professionals.register') }}" class="cc-btn-outline">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
                        </svg>
                        Become a Professional
                    </a>
                </div>
            </div>
            <div class="cc-hero-stats">
                <div class="cc-stat">
                    <div class="cc-stat-val">{{ $professionals->count() }}<em>+</em></div>
                    <div class="cc-stat-label">Professionals</div>
                </div>
                <div class="cc-stat">
                    <div class="cc-stat-val">9<em>K</em></div>
                    <div class="cc-stat-label">Happy Clients</div>
                </div>
                <div class="cc-stat">
                    <div class="cc-stat-val">98<em>%</em></div>
                    <div class="cc-stat-label">Satisfaction</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FILTER BAR --}}
<div class="cc-filter" id="cc-filter-bar">
    <div class="container">
        <div class="cc-filter-inner">
            <div class="cc-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>
                <input type="text" id="cc-q" placeholder="Search by name or profession…" autocomplete="off">
            </div>

            <div class="cc-tabs">
                <button class="cc-tab on" data-profession="all">All</button>
                @foreach($professionTypes ?? [] as $type)
                <button class="cc-tab" data-profession="{{ strtolower($type) }}">{{ $type }}</button>
                @endforeach
            </div>

            <select class="cc-select" id="cc-exp">
                <option value="">Any Experience</option>
                <option value="1">1–3 years</option>
                <option value="4">4–7 years</option>
                <option value="8">8+ years</option>
            </select>

            <select class="cc-select" id="cc-sort">
                <option value="newest">Newest</option>
                <option value="rating">Top Rated</option>
                <option value="name-az">Name A–Z</option>
                <option value="name-za">Name Z–A</option>
            </select>

            <div class="cc-filter-meta">
                <span class="cc-count"><strong id="cc-vis-count">{{ $professionals->count() }}</strong> professionals</span>
            </div>
        </div>
    </div>
</div>

{{-- GRID --}}
<section class="cc-section" id="cc-grid-section">
    <div class="container">
        <div class="cc-section-header">
            <div class="cc-section-eyebrow">Certified Professionals</div>
            <h2 class="cc-section-title">The Terra <em>professional team</em></h2>
        </div>

        <div class="row g-3" id="cc-grid">
            @forelse($professionals as $professional)
            @php
            $expYears = (int)($professional->years_experience ?? 0);
            $rating = (float)($professional->rating ?? 0);
            $services = $professional->professionalServices->pluck('title')->take(3); // safe now
            $languages = collect(json_decode($professional->languages ?? '[]', true));
            $imgSrc = $professional->profile_image
            ? asset($professional->profile_image)
            : asset('front/assets/img/all-images/team/team-img1.png');
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 col-12"
                data-name="{{ strtolower($professional->full_name) }}"
                data-profession="{{ strtolower($professional->profession ?? '') }}"
                data-exp="{{ $expYears }}"
                data-rating="{{ $rating }}"
                data-created="{{ $professional->created_at->timestamp }}">
                <div class="cc-card h-100">
                    <div class="cc-card-photo">
                            <span class="cc-role-badge">{{ $professional->profession ?? 'Professional' }}</span>
                            @if($professional->is_verified)
                            <div class="cc-verified" title="Verified Professional">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            @endif
                            <img src="{{ $imgSrc }}" alt="{{ $professional->full_name }}" loading="lazy">
                            <div class="cc-card-photo-overlay"></div>

                            {{-- Social quick-links --}}
                            <div class="cc-card-socials">
                                @if($professional->linkedin)
                                <a href="{{ $professional->linkedin }}" target="_blank" class="cc-soc-btn"
                                    onclick="event.preventDefault();event.stopPropagation();window.open(this.getAttribute('href'),'_blank')" title="LinkedIn">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" />
                                        <circle cx="4" cy="4" r="2" />
                                    </svg>
                                </a>
                                @endif
                                @if($professional->phone)
                                <a href="tel:{{ $professional->phone }}" class="cc-soc-btn" onclick="event.stopPropagation()" title="Call">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                                    </svg>
                                </a>
                                @endif
                                @if($professional->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/\D+/','',$professional->whatsapp) }}" target="_blank" class="cc-soc-btn" onclick="event.stopPropagation()" title="WhatsApp">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51A10.45 10.45 0 009 5.99c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                        <path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.52 3.66 1.428 5.18L2 22l4.975-1.395A10 10 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" />
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>

                        <div class="cc-card-body">
                            <div class="cc-card-name">{{ $professional->full_name }}</div>
                            <div class="cc-card-title">{{ $professional->profession ?? 'Real Estate Professional' }}</div>

                            @if($professional->bio)
                            <p class="cc-card-bio">{{ $professional->bio }}</p>
                            @endif

                            @if($services->isNotEmpty())
                            <div class="cc-card-tags">
                                @foreach($services as $svc)
                                <span class="cc-card-tag">{{ $svc }}</span>
                                @endforeach
                            </div>
                            @endif

                            <div class="cc-card-meta">
                                @if($rating > 0)
                                <div class="cc-card-meta-item">
                                    <div class="cc-stars">
                                        @for($s = 1; $s <= 5; $s++)
                                            <svg viewBox="0 0 24 24" fill="currentColor" class="{{ $s <= round($rating) ? 'cc-star-on' : 'cc-star-off' }}">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" /></svg>
                                            @endfor
                                    </div>
                                    <span>{{ number_format($rating, 1) }}</span>
                                </div>
                                @endif

                                @if($expYears)
                                <div class="cc-card-meta-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z" />
                                    </svg>
                                    {{ $expYears }} yrs
                                </div>
                                @endif

                                @if($professional->office_location)
                                <div class="cc-card-meta-item">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                    </svg>
                                    {{ Str::limit($professional->office_location, 14) }}
                                </div>
                                @endif

                                <a href="{{ route('front.professional.details', $professional) }}">
                                    <span class="cc-card-link">
                                    View Profile
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                    
                                </span>
                            </a>
                            </div>
                        </div>
                    
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="cc-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                    <h3>No professionals found</h3>
                    <p>Check back soon — we're growing our team.</p>
                </div>
            </div>
            @endforelse
        </div>

        <div class="cc-empty" id="cc-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.35-4.35M11 8v3m0 3h.01" />
            </svg>
            <h3>No professionals match your filters</h3>
            <p>Try adjusting your search or clearing filters.</p>
        </div>
    </div>
</section>

{{-- JOIN CTA --}}
<div class="cc-join">
    <div class="container">
        <div class="cc-join-inner">
            <div>
                <h2 class="cc-join-title">Are you a property expert?<br><em>Join Terra as a Professional</em></h2>
                <p class="cc-join-desc">Register your expertise and connect with hundreds of buyers and investors looking for guidance across Rwanda.</p>
            </div>
            <a href="{{ route('professionals.register') }}" class="cc-join-btn">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
                </svg>
                Become a Professional
            </a>
        </div>
    </div>
</div>

<script>
    (function() {
        const grid = document.getElementById('cc-grid');
        const cols = Array.from(grid.querySelectorAll(':scope > [data-name]'));
        const countEl = document.getElementById('cc-vis-count');
        const emptyEl = document.getElementById('cc-empty');
        let state = {
            q: '',
            profession: 'all',
            exp: '',
            sort: 'newest'
        };

        const debounce = (fn, ms) => {
            let t;
            return (...a) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...a), ms);
            };
        };

        function run() {
            const q = state.q.trim().toLowerCase();

            let vis = cols.filter(col => {
                if (state.profession !== 'all' && !col.dataset.profession.includes(state.profession)) return false;
                if (q && !col.dataset.name.includes(q)) return false;
                if (state.exp) {
                    const yrs = parseInt(col.dataset.exp) || 0;
                    const ranges = {
                        '1': [1, 3],
                        '4': [4, 7],
                        '8': [8, 99]
                    };
                    const [lo, hi] = ranges[state.exp] || [0, 99];
                    if (yrs < lo || yrs > hi) return false;
                }
                return true;
            });

            if (state.sort === 'name-az') vis.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
            if (state.sort === 'name-za') vis.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
            if (state.sort === 'rating') vis.sort((a, b) => parseFloat(b.dataset.rating || 0) - parseFloat(a.dataset.rating || 0));
            if (state.sort === 'newest') vis.sort((a, b) => parseInt(b.dataset.created || 0) - parseInt(a.dataset.created || 0));

            const visSet = new Set(vis);
            cols.forEach(col => col.style.display = visSet.has(col) ? '' : 'none');
            vis.forEach(col => grid.appendChild(col));

            countEl.textContent = vis.length;
            if (emptyEl) emptyEl.style.display = vis.length === 0 ? 'block' : 'none';
        }

        document.getElementById('cc-q').addEventListener('input', debounce(e => {
            state.q = e.target.value;
            run();
        }, 220));
        document.getElementById('cc-sort').addEventListener('change', e => {
            state.sort = e.target.value;
            run();
        });
        document.getElementById('cc-exp').addEventListener('change', e => {
            state.exp = e.target.value;
            run();
        });
        document.querySelectorAll('.cc-tab').forEach(t => {
            t.addEventListener('click', () => {
                document.querySelectorAll('.cc-tab').forEach(x => x.classList.remove('on'));
                t.classList.add('on');
                state.profession = t.dataset.profession;
                run();
            });
        });

        run();
    })();
</script>

@endsection