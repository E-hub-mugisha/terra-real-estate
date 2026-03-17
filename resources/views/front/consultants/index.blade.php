@extends('layouts.guest')
@section('title', 'Real Estate Consultants')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:       #F7F5F2;
    --surface:  #FFFFFF;
    --dark:     #0E0E0C;
    --dark2:    #161613;
    --border:   rgba(0,0,0,.08);
    --border2:  rgba(0,0,0,.14);
    --gold:     #C8873A;
    --gold-lt:  #E5A55E;
    --gold-bg:  rgba(200,135,58,.07);
    --gold-bd:  rgba(200,135,58,.22);
    --text:     #1A1714;
    --muted:    #6B6560;
    --dim:      #9E9890;
    --green:    #1E7A5A;
    --green-bg: rgba(30,122,90,.07);
    --green-bd: rgba(30,122,90,.2);
    --r:        13px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ══════════════════════════
   HERO
══════════════════════════ */
.cc-hero {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 80px 0 72px;
}
.cc-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 60% at 0% 50%, rgba(200,135,58,.12) 0%, transparent 65%),
        radial-gradient(ellipse 35% 50% at 100% 20%, rgba(200,135,58,.06) 0%, transparent 55%);
    pointer-events: none;
}
.cc-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.018) 39px, rgba(255,255,255,.018) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255,255,255,.012) 79px, rgba(255,255,255,.012) 80px);
    pointer-events: none;
}
.cc-hero-inner {
    position: relative; z-index: 2;
    display: grid; grid-template-columns: 1fr auto; align-items: center; gap: 40px;
}
@media (max-width: 720px) { .cc-hero-inner { grid-template-columns: 1fr; } .cc-hero-stats { display: none; } }
.cc-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 14px;
}
.cc-eyebrow::before { content: ''; width: 18px; height: 1px; background: var(--gold); opacity: .6; }
.cc-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(2rem, 5vw, 3.4rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.02em; color: #F0EDE8;
    margin-bottom: 14px;
}
.cc-hero h1 em { font-style: italic; color: var(--gold-lt); }
.cc-hero p {
    font-size: .88rem; color: rgba(240,237,232,.45);
    max-width: 480px; line-height: 1.75; margin-bottom: 24px;
}
.cc-hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.cc-btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 11px 22px; border-radius: 9px;
    background: var(--gold); border: none; color: #fff;
    font-size: .84rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: background var(--t), transform var(--t); text-decoration: none;
}
.cc-btn-primary:hover { background: #a06828; transform: translateY(-1px); color: #fff; }
.cc-btn-outline {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 11px 22px; border-radius: 9px;
    background: rgba(255,255,255,.08); color: rgba(240,237,232,.7);
    border: 1px solid rgba(255,255,255,.15);
    font-size: .84rem; font-weight: 500;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t); text-decoration: none;
}
.cc-btn-outline:hover { background: rgba(255,255,255,.14); color: #F0EDE8; }
.cc-btn-primary svg, .cc-btn-outline svg { width: 14px; height: 14px; }

/* Stats */
.cc-hero-stats {
    display: flex; flex-direction: column; gap: 10px;
}
.cc-stat {
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 12px; padding: 16px 20px;
    min-width: 150px; text-align: center;
}
.cc-stat-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem; font-weight: 600; color: #F0EDE8;
    line-height: 1; letter-spacing: -.02em;
}
.cc-stat-val em { color: var(--gold-lt); font-style: normal; }
.cc-stat-label { font-size: .7rem; color: rgba(240,237,232,.35); text-transform: uppercase; letter-spacing: .08em; margin-top: 4px; }

/* ══════════════════════════
   FILTER BAR
══════════════════════════ */
.cc-filter {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 12px 0;
    position: sticky; top: 0; z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.cc-filter-inner {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
}

/* Search */
.cc-search {
    position: relative; flex: 1; min-width: 160px; max-width: 260px;
}
.cc-search svg {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%); width: 14px; height: 14px; color: var(--dim);
    pointer-events: none;
}
.cc-search input {
    width: 100%; padding: 8px 12px 8px 30px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .82rem; font-family: 'DM Sans', sans-serif;
    background: var(--bg); color: var(--text);
    transition: border-color var(--t);
}
.cc-search input:focus { outline: none; border-color: var(--gold); background: var(--surface); }
.cc-search input::placeholder { color: var(--dim); }

/* Filter tabs */
.cc-tabs { display: flex; gap: 4px; }
.cc-tab {
    padding: 7px 13px; border-radius: 8px;
    border: 1.5px solid var(--border); background: transparent;
    font-family: 'DM Sans', sans-serif; font-size: .8rem;
    font-weight: 500; color: var(--muted); cursor: pointer;
    white-space: nowrap; transition: all var(--t);
}
.cc-tab:hover { border-color: var(--gold); color: var(--gold); }
.cc-tab.on { background: var(--gold); border-color: var(--gold); color: #fff; }

/* Selects */
.cc-select {
    padding: 7px 26px 7px 11px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .8rem; font-family: 'DM Sans', sans-serif; color: var(--text);
    background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 8px center no-repeat;
    appearance: none; cursor: pointer; transition: border-color var(--t);
}
.cc-select:focus { outline: none; border-color: var(--gold); }

/* Meta */
.cc-filter-meta { display: flex; align-items: center; gap: 8px; margin-left: auto; }
.cc-count { font-size: .78rem; color: var(--dim); white-space: nowrap; }
.cc-count strong { color: var(--text); }

/* Active filter chips */
.cc-active-chips {
    display: flex; gap: 6px; flex-wrap: wrap;
    padding: 8px 0 0;
}
.cc-chip {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 10px; border-radius: 20px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    font-size: .74rem; color: var(--gold); font-weight: 500;
}
.cc-chip-x { cursor: pointer; opacity: .6; transition: opacity var(--t); }
.cc-chip-x:hover { opacity: 1; }

/* ══════════════════════════
   ABOUT STRIP
══════════════════════════ */
.cc-about {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 44px 0;
}
.cc-about-grid {
    display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: center;
}
@media (max-width: 768px) { .cc-about-grid { grid-template-columns: 1fr; } }

.cc-about-eyebrow {
    font-size: .68rem; font-weight: 600; letter-spacing: .12em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 10px;
}
.cc-about-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 500; line-height: 1.15;
    letter-spacing: -.02em; color: var(--text);
}
.cc-about-title em { font-style: italic; color: var(--gold); }
.cc-about-desc { font-size: .85rem; color: var(--muted); line-height: 1.8; margin-top: 12px; }

.cc-about-cta {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; border-radius: 9px;
    background: var(--gold); color: #fff;
    font-size: .84rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    transition: background var(--t), transform var(--t);
    margin-top: 20px;
}
.cc-about-cta:hover { background: #a06828; transform: translateY(-1px); color: #fff; }
.cc-about-cta svg { width: 14px; height: 14px; }

/* Stats row */
.cc-about-stats {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;
}
.cc-about-stat {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: var(--r); padding: 18px 16px; text-align: center;
}
.cc-about-stat-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.7rem; font-weight: 600; color: var(--gold);
    line-height: 1; letter-spacing: -.02em;
}
.cc-about-stat-lbl { font-size: .72rem; color: var(--muted); margin-top: 4px; }

/* ══════════════════════════
   CONSULTANTS GRID
══════════════════════════ */
.cc-section { padding: 52px 0 80px; }
.cc-section-header { margin-bottom: 28px; }
.cc-section-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 8px;
}
.cc-section-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .5; }
.cc-section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.4rem, 3vw, 2rem);
    font-weight: 500; color: var(--text); letter-spacing: -.02em;
}
.cc-section-title em { font-style: italic; color: var(--gold); }

/* Card grid — Bootstrap row handles layout */
.cc-grid { }

/* ── Consultant Card ── */
.cc-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r);
    overflow: hidden;
    display: flex; flex-direction: column;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
    animation: ccFu .4s ease both;
    color: var(--text);
}
.cc-card:hover {
    transform: translateY(-5px);
    border-color: var(--gold-bd);
    box-shadow: 0 12px 32px rgba(0,0,0,.09), 0 0 0 1px rgba(200,135,58,.1);
    color: var(--text);
}
@keyframes ccFu { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }

/* Photo area */
.cc-card-photo {
    position: relative;
    aspect-ratio: 4/3; overflow: hidden;
    background: var(--bg);
}
.cc-card-photo img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .5s ease;
}
.cc-card:hover .cc-card-photo img { transform: scale(1.05); }
.cc-card-photo-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(14,14,12,.65) 0%, transparent 55%);
    opacity: 0; transition: opacity var(--t);
}
.cc-card:hover .cc-card-photo-overlay { opacity: 1; }

/* Social links over photo */
.cc-card-socials {
    position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%);
    display: flex; gap: 6px; opacity: 0;
    transition: opacity var(--t), transform var(--t);
    transform: translateX(-50%) translateY(6px);
}
.cc-card:hover .cc-card-socials { opacity: 1; transform: translateX(-50%) translateY(0); }
.cc-soc-btn {
    width: 32px; height: 32px; border-radius: 8px;
    background: rgba(255,255,255,.15); backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,.2);
    display: grid; place-items: center; cursor: pointer;
    color: #fff; font-size: .72rem;
    transition: background var(--t);
    text-decoration: none;
}
.cc-soc-btn:hover { background: var(--gold); border-color: var(--gold); color: #fff; }
.cc-soc-btn svg { width: 13px; height: 13px; }

/* Role badge */
.cc-role-badge {
    position: absolute; top: 10px; left: 10px; z-index: 2;
    padding: 3px 9px; border-radius: 6px;
    background: rgba(14,14,12,.75); backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,.12);
    font-size: .64rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: rgba(240,237,232,.8);
}

/* Verified badge */
.cc-verified {
    position: absolute; top: 10px; right: 10px; z-index: 2;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(30,122,90,.85); backdrop-filter: blur(6px);
    display: grid; place-items: center;
}
.cc-verified svg { width: 13px; height: 13px; color: #fff; }

/* Card body */
.cc-card-body { padding: 16px 16px 18px; flex: 1; display: flex; flex-direction: column; }
.cc-card-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 600; color: var(--text);
    letter-spacing: -.01em; margin-bottom: 4px; line-height: 1.2;
}
.cc-card-title { font-size: .78rem; color: var(--gold); font-weight: 500; margin-bottom: 10px; }
.cc-card-bio {
    font-size: .78rem; color: var(--muted); line-height: 1.65;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 12px;
}

/* Tags */
.cc-card-tags { display: flex; gap: 5px; flex-wrap: wrap; margin-bottom: 14px; }
.cc-card-tag {
    padding: 2px 8px; border-radius: 5px;
    font-size: .66rem; font-weight: 600;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    color: var(--muted); letter-spacing: .03em;
}

/* Meta row */
.cc-card-meta {
    display: flex; align-items: center; gap: 12px;
    padding-top: 11px; border-top: 1px solid var(--border);
    margin-top: auto;
}
.cc-card-meta-item {
    display: flex; align-items: center; gap: 4px;
    font-size: .72rem; color: var(--dim);
}
.cc-card-meta-item svg { width: 12px; height: 12px; color: var(--gold); }
.cc-card-link {
    margin-left: auto;
    display: flex; align-items: center; gap: 4px;
    font-size: .76rem; font-weight: 600; color: var(--gold);
    transition: gap var(--t);
}
.cc-card-link:hover { gap: 8px; }
.cc-card-link svg { width: 12px; height: 12px; }

/* Empty state */
.cc-empty {
    grid-column: 1 / -1; text-align: center; padding: 64px 20px; color: var(--dim);
}
.cc-empty svg { width: 44px; height: 44px; margin-bottom: 14px; opacity: .3; }
.cc-empty h3 { font-size: .95rem; color: var(--muted); margin-bottom: 6px; }

/* ══════════════════════════
   BECOME A CONSULTANT CTA
══════════════════════════ */
.cc-join {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 56px 0; margin-top: 12px;
}
.cc-join::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 55% 60% at 80% 50%, rgba(200,135,58,.11) 0%, transparent 65%);
    pointer-events: none;
}
.cc-join-inner {
    position: relative; z-index: 2;
    display: flex; align-items: center; justify-content: space-between;
    gap: 32px; flex-wrap: wrap;
}
.cc-join-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 500; color: #F0EDE8; letter-spacing: -.02em;
}
.cc-join-title em { font-style: italic; color: var(--gold-lt); }
.cc-join-desc { font-size: .84rem; color: rgba(240,237,232,.4); margin-top: 6px; }
.cc-join-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px; border-radius: 9px;
    background: var(--gold); border: none; color: #fff;
    font-size: .85rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: background var(--t), transform var(--t);
    white-space: nowrap; text-decoration: none;
}
.cc-join-btn:hover { background: #a06828; transform: translateY(-1px); color: #fff; }
.cc-join-btn svg { width: 14px; height: 14px; }
</style>

{{-- ══ HERO ══ --}}
<section class="cc-hero">
    <div class="container">
        <div class="cc-hero-inner">
            <div>
                <div class="cc-eyebrow">Expert Guidance</div>
                <h1>Meet our <em>certified<br>consultants</em></h1>
                <p>Work directly with experienced real estate consultants who know Rwanda's property market inside out — from land valuation to investment strategy.</p>
                <div class="cc-hero-actions">
                    <button class="cc-btn-primary" onclick="document.getElementById('cc-grid-section').scrollIntoView({behavior:'smooth'})">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        Browse Consultants
                    </button>
                    <a href="{{ route('consultant.become') }}" class="cc-btn-outline">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                        Become a Consultant
                    </a>
                </div>
            </div>
            <div class="cc-hero-stats">
                <div class="cc-stat">
                    <div class="cc-stat-val">{{ $consultants->count() }}<em>+</em></div>
                    <div class="cc-stat-label">Consultants</div>
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

{{-- ══ FILTER BAR ══ --}}
<div class="cc-filter" id="cc-filter-bar">
    <div class="container">
        <div class="cc-filter-inner">

            <div class="cc-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" id="cc-q" placeholder="Search by name or specialty…" autocomplete="off">
            </div>

            <div class="cc-tabs">
                <button class="cc-tab on" data-role="all">All</button>
                <button class="cc-tab" data-role="agent">Agents</button>
                <button class="cc-tab" data-role="consultant">Consultants</button>
            </div>

            <select class="cc-select" id="cc-specialty">
                <option value="">Any Specialty</option>
                <option value="residential">Residential</option>
                <option value="commercial">Commercial</option>
                <option value="land">Land &amp; Plots</option>
                <option value="investment">Investment</option>
            </select>

            <select class="cc-select" id="cc-sort">
                <option value="newest">Newest</option>
                <option value="name-az">Name A–Z</option>
                <option value="name-za">Name Z–A</option>
            </select>

            <div class="cc-filter-meta">
                <span class="cc-count"><strong id="cc-vis-count">{{ $consultants->count() }}</strong> consultants</span>
            </div>

        </div>
    </div>
</div>

{{-- ══ ABOUT STRIP ══ --}}
<section class="cc-about">
    <div class="container">
        <div class="cc-about-grid">
            <div>
                <div class="cc-about-eyebrow">About Terra Consultants</div>
                <h2 class="cc-about-title">Embrace the <em>elegance</em><br>of expert property guidance</h2>
                <p class="cc-about-desc">
                    At Terra Real Estate, we've built a network of certified property consultants who simplify every step of your real estate journey. Whether you're buying your first home, selling land, or building an investment portfolio — our consultants bring local knowledge, verified credentials, and transparent advice.
                </p>
                <a href="{{ route('front.our.services') }}" class="cc-about-cta">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    Explore Our Services
                </a>
            </div>
            <div>
                <div class="cc-about-stats">
                    <div class="cc-about-stat">
                        <div class="cc-about-stat-val">10K</div>
                        <div class="cc-about-stat-lbl">Homes Sold</div>
                    </div>
                    <div class="cc-about-stat">
                        <div class="cc-about-stat-val">9K</div>
                        <div class="cc-about-stat-lbl">Happy Clients</div>
                    </div>
                    <div class="cc-about-stat">
                        <div class="cc-about-stat-val">98%</div>
                        <div class="cc-about-stat-lbl">Satisfaction</div>
                    </div>
                    <div class="cc-about-stat">
                        <div class="cc-about-stat-val">{{ $consultants->count() }}+</div>
                        <div class="cc-about-stat-lbl">Consultants</div>
                    </div>
                    <div class="cc-about-stat">
                        <div class="cc-about-stat-val">30+</div>
                        <div class="cc-about-stat-lbl">Districts</div>
                    </div>
                    <div class="cc-about-stat">
                        <div class="cc-about-stat-val">5★</div>
                        <div class="cc-about-stat-lbl">Avg Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ CONSULTANTS GRID ══ --}}
<section class="cc-section" id="cc-grid-section">
    <div class="container">

        <div class="cc-section-header">
            <div class="cc-section-eyebrow">Certified Professionals</div>
            <h2 class="cc-section-title">The Terra <em>consultant team</em></h2>
        </div>

        <div class="row g-3" id="cc-grid">

            @forelse($consultants as $i => $consultant)
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
            <a href="{{ route('front.consultant.details', $consultant) }}"
               class="cc-card h-100"
               style="animation-delay:{{ $i * 0.05 }}s"
               data-name="{{ strtolower($consultant->name) }}"
               data-role="{{ strtolower($consultant->role ?? 'consultant') }}"
               data-created="{{ $consultant->created_at->timestamp ?? 0 }}">

                <div class="cc-card-photo">
                    <span class="cc-role-badge">{{ ucfirst($consultant->role ?? 'Consultant') }}</span>
                    @if($consultant->is_verified ?? false)
                        <div class="cc-verified" title="Verified Consultant">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    @endif
                    @if($consultant->profile_image)
                        <img src="{{ asset('storage/'.$consultant->profile_image) }}" alt="{{ $consultant->name }}" loading="lazy">
                    @else
                        <img src="{{ asset('front/assets/img/all-images/team/team-img1.png') }}" alt="{{ $consultant->name }}" loading="lazy">
                    @endif
                    <div class="cc-card-photo-overlay"></div>
                    <div class="cc-card-socials">
                        <a href="{{ route('front.consultant.details', $consultant) }}" class="cc-soc-btn" onclick="event.stopPropagation()">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                        </a>
                        <a href="tel:{{ $consultant->phone ?? '#' }}" class="cc-soc-btn" onclick="event.stopPropagation()">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$consultant->phone ?? '') }}" target="_blank" class="cc-soc-btn" onclick="event.stopPropagation()">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="cc-card-body">
                    <div class="cc-card-name">{{ $consultant->name }}</div>
                    <div class="cc-card-title">{{ $consultant->title ?? ucfirst($consultant->role ?? 'Real Estate Consultant') }}</div>

                    @if($consultant->bio ?? null)
                    <p class="cc-card-bio">{{ $consultant->bio }}</p>
                    @endif

                    @php $tags = array_filter([$consultant->specialty ?? null, $consultant->location ?? null]); @endphp
                    @if(count($tags))
                    <div class="cc-card-tags">
                        @foreach($tags as $tag)
                        <span class="cc-card-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif

                    <div class="cc-card-meta">
                        @if($consultant->phone ?? null)
                        <div class="cc-card-meta-item">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/></svg>
                            Available
                        </div>
                        @endif
                        <div class="cc-card-meta-item">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                            Kigali
                        </div>
                        <span class="cc-card-link">
                            View Profile
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </div>
            </a>
            </div>{{-- /.col --}}
            @empty
            <div class="col-12">
            <div class="cc-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                <h3>No consultants found</h3>
                <p>Check back soon — we're growing our team.</p>
            </div>
            </div>{{-- /.col --}}
            @endforelse

        </div>

        {{-- JS empty state --}}
        <div class="cc-empty" id="cc-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/></svg>
            <h3>No consultants match your filters</h3>
            <p>Try changing your search or clearing filters.</p>
        </div>

    </div>
</section>

{{-- ══ JOIN CTA ══ --}}
<div class="cc-join">
    <div class="container">
        <div class="cc-join-inner">
            <div>
                <h2 class="cc-join-title">Are you a property expert?<br><em>Join Terra as a consultant</em></h2>
                <p class="cc-join-desc">Register your expertise and connect with hundreds of buyers and investors looking for guidance across Rwanda.</p>
            </div>
            <a href="{{ route('consultant.become') }}" class="cc-join-btn">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                Become a Consultant
            </a>
        </div>
    </div>
</div>

<script>
(function () {
    const grid     = document.getElementById('cc-grid');
    const cards    = Array.from(grid.querySelectorAll('.cc-card'));
    const countEl  = document.getElementById('cc-vis-count');
    const emptyEl  = document.getElementById('cc-empty');

    let state = { q: '', role: 'all', sort: 'newest' };

    function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }

    function run() {
        const q = state.q.trim().toLowerCase();

        let vis = cards.filter(c => {
            if (state.role !== 'all' && !c.dataset.role.includes(state.role)) return false;
            if (q && !c.dataset.name.includes(q)) return false;
            return true;
        });

        if (state.sort === 'name-az') vis.sort((a,b) => a.dataset.name.localeCompare(b.dataset.name));
        if (state.sort === 'name-za') vis.sort((a,b) => b.dataset.name.localeCompare(a.dataset.name));
        if (state.sort === 'newest') vis.sort((a,b) => +b.dataset.created - +a.dataset.created);

        /* Hide/show Bootstrap col wrappers to avoid gap holes */
        const vs = new Set(vis);
        cards.forEach(c => {
            const col = c.closest('[class*="col-"]');
            if (col) col.style.display = vs.has(c) ? '' : 'none';
        });

        /* Re-append col wrappers in sorted order */
        vis.forEach(c => {
            const col = c.closest('[class*="col-"]');
            if (col) grid.appendChild(col);
        });

        countEl.textContent = vis.length;
        if (emptyEl) emptyEl.style.display = vis.length === 0 ? 'block' : 'none';
    }

    document.getElementById('cc-q')
        .addEventListener('input', debounce(e => { state.q = e.target.value; run(); }, 220));
    document.getElementById('cc-sort')
        .addEventListener('change', e => { state.sort = e.target.value; run(); });

    document.querySelectorAll('.cc-tab').forEach(t => {
        t.addEventListener('click', () => {
            document.querySelectorAll('.cc-tab').forEach(x => x.classList.remove('on'));
            t.classList.add('on');
            state.role = t.dataset.role;
            run();
        });
    });

    run();
})();
</script>

@endsection