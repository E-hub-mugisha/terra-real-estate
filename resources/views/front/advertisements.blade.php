@extends('layouts.guest')
@section('title', 'Advertisements')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:       #F7F5F2;
    --surface:  #FFFFFF;
    --dark:     #0E0E0C;
    --border:   rgba(0,0,0,.08);
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
    --r:        12px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ── Page hero ── */
.ad-hero {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 52px 0 44px;
}
.ad-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 50% 60% at 5% 50%, rgba(200,135,58,.12) 0%, transparent 65%),
        radial-gradient(ellipse 35% 50% at 95% 30%, rgba(200,135,58,.06) 0%, transparent 55%);
    pointer-events: none;
}
.ad-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.016) 39px, rgba(255,255,255,.016) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255,255,255,.01) 79px, rgba(255,255,255,.01) 80px);
    pointer-events: none;
}
.ad-hero .container { position: relative; z-index: 2; }

.ad-hero-inner { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
.ad-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 10px;
}
.ad-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .6; }
.ad-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.7rem, 4vw, 2.8rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.02em; color: #F0EDE8;
}
.ad-hero h1 em { font-style: italic; color: var(--gold-lt); }
.ad-hero p { font-size: .84rem; color: rgba(240,237,232,.4); margin-top: 6px; max-width: 420px; line-height: 1.7; }

/* Stats strip */
.ad-hero-stats { display: flex; gap: 20px; flex-shrink: 0; }
.ad-hstat-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem; font-weight: 600; color: #F0EDE8; line-height: 1; letter-spacing: -.02em;
}
.ad-hstat-val em { color: var(--gold-lt); font-style: normal; }
.ad-hstat-lbl { font-size: .67rem; color: rgba(240,237,232,.3); text-transform: uppercase; letter-spacing: .08em; margin-top: 2px; }

/* ── Filter bar ── */
.ad-filter {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 11px 0;
    position: sticky; top: 0; z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.ad-filter-inner { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

.ad-search { position: relative; flex: 1; min-width: 150px; max-width: 240px; }
.ad-search svg {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%); width: 13px; height: 13px;
    color: var(--dim); pointer-events: none;
}
.ad-search input {
    width: 100%; padding: 8px 11px 8px 28px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .81rem; font-family: 'DM Sans', sans-serif;
    background: var(--bg); color: var(--text); transition: border-color var(--t);
}
.ad-search input:focus { outline: none; border-color: var(--gold); background: var(--surface); }
.ad-search input::placeholder { color: var(--dim); }

.ad-tabs { display: flex; gap: 4px; }
.ad-tab {
    padding: 6px 12px; border-radius: 7px;
    border: 1.5px solid var(--border); background: transparent;
    font-family: 'DM Sans', sans-serif; font-size: .78rem;
    font-weight: 500; color: var(--muted); cursor: pointer;
    white-space: nowrap; transition: all var(--t);
}
.ad-tab:hover { border-color: var(--gold); color: var(--gold); }
.ad-tab.on { background: var(--gold); border-color: var(--gold); color: #fff; }

.ad-select {
    padding: 6px 24px 6px 10px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .78rem; font-family: 'DM Sans', sans-serif; color: var(--text);
    background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 7px center no-repeat;
    appearance: none; cursor: pointer; transition: border-color var(--t);
}
.ad-select:focus { outline: none; border-color: var(--gold); }

.ad-meta { display: flex; align-items: center; gap: 8px; margin-left: auto; }
.ad-count { font-size: .77rem; color: var(--dim); white-space: nowrap; }
.ad-count strong { color: var(--text); }
.ad-vbtns { display: flex; gap: 3px; }
.ad-vbtn {
    width: 30px; height: 30px; border-radius: 7px;
    border: 1.5px solid var(--border); background: transparent;
    display: grid; place-items: center; cursor: pointer; color: var(--dim);
    transition: all var(--t);
}
.ad-vbtn.on, .ad-vbtn:hover { background: var(--gold); border-color: var(--gold); color: #fff; }
.ad-vbtn svg { width: 13px; height: 13px; }

/* ── Featured banner slot ── */
.ad-featured-strip { padding: 24px 0 0; }
.ad-banner {
    position: relative; border-radius: var(--r); overflow: hidden;
    background: var(--dark); min-height: 180px; margin-bottom: 8px;
    display: flex; align-items: center;
    cursor: pointer;
    transition: box-shadow var(--t);
}
.ad-banner:hover { box-shadow: 0 12px 36px rgba(0,0,0,.16); }
.ad-banner-bg {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
    opacity: .35; transition: opacity var(--t);
}
.ad-banner:hover .ad-banner-bg { opacity: .45; }
.ad-banner-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to right, rgba(14,14,12,.85) 0%, rgba(14,14,12,.4) 60%, transparent 100%);
}
.ad-banner-content { position: relative; z-index: 2; padding: 28px 32px; }
.ad-banner-type {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 3px 10px; border-radius: 6px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    font-size: .64rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 10px;
}
.ad-banner-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.3rem, 3vw, 2rem);
    font-weight: 500; color: #F0EDE8; letter-spacing: -.01em;
    line-height: 1.2; margin-bottom: 8px;
}
.ad-banner-desc { font-size: .82rem; color: rgba(240,237,232,.5); max-width: 480px; line-height: 1.65; margin-bottom: 16px; }
.ad-banner-cta {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: 8px;
    background: var(--gold); border: none; color: #fff;
    font-size: .82rem; font-weight: 600; font-family: 'DM Sans', sans-serif;
    cursor: pointer; transition: background var(--t);
    text-decoration: none;
}
.ad-banner-cta:hover { background: #a06828; color: #fff; }
.ad-banner-cta svg { width: 13px; height: 13px; }
.ad-banner-agent {
    position: absolute; top: 16px; right: 20px; z-index: 3;
    display: flex; align-items: center; gap: 8px;
    background: rgba(14,14,12,.65); backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.12); border-radius: 8px; padding: 6px 10px;
}
.ad-banner-agent-avatar {
    width: 26px; height: 26px; border-radius: 50%;
    background: var(--gold); display: grid; place-items: center;
    font-size: .68rem; font-weight: 700; color: #fff; flex-shrink: 0;
}
.ad-banner-agent-name { font-size: .73rem; color: rgba(240,237,232,.75); font-weight: 500; }
.ad-banner-dates {
    position: absolute; bottom: 14px; right: 20px; z-index: 3;
    font-size: .67rem; color: rgba(240,237,232,.35); font-weight: 500;
}

/* ── Ad Cards ── */
.ad-main { padding: 24px 0 72px; }

.ad-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden;
    height: 100%; display: flex; flex-direction: column;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
    animation: adFu .35s ease both; cursor: pointer;
    position: relative;
}
.ad-card:hover {
    transform: translateY(-4px);
    border-color: var(--gold-bd);
    box-shadow: 0 10px 28px rgba(0,0,0,.09), 0 0 0 1px rgba(200,135,58,.09);
}
@keyframes adFu { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }

/* Card image */
.ad-card-img {
    position: relative; aspect-ratio: 16/9;
    overflow: hidden; background: var(--bg); flex-shrink: 0;
}
.ad-card-img img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .5s ease;
}
.ad-card:hover .ad-card-img img { transform: scale(1.05); }
.ad-card-img-placeholder {
    width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #E8E3DC 0%, #D4CFC8 100%);
}
.ad-card-img-placeholder svg { width: 36px; height: 36px; color: rgba(200,135,58,.4); }

/* Ad type badge */
.ad-type-badge {
    position: absolute; top: 8px; left: 8px; z-index: 2;
    padding: 2px 8px; border-radius: 5px;
    font-size: .62rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase; color: #fff;
}
.ad-type-featured  { background: #C8873A; }
.ad-type-spotlight { background: #5A3B8C; }
.ad-type-banner    { background: #1E7A5A; }
.ad-type-boost     { background: #185FA5; }

/* Status badge */
.ad-status-badge {
    position: absolute; top: 8px; right: 8px; z-index: 2;
    display: flex; align-items: center; gap: 4px;
    padding: 2px 8px; border-radius: 5px;
    font-size: .62rem; font-weight: 600;
    backdrop-filter: blur(6px);
}
.ad-status-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
.ad-s-active   { background: rgba(30,122,90,.75);  color: #6ee7b7; }
.ad-s-pending  { background: rgba(180,140,10,.75);  color: #fcd34d; }
.ad-s-expired  { background: rgba(100,100,100,.75); color: #d1d5db; }

/* Card body */
.ad-card-body { padding: 13px 15px 15px; display: flex; flex-direction: column; gap: 7px; flex: 1; }
.ad-card-title {
    font-size: .9rem; font-weight: 600; color: var(--text);
    line-height: 1.3; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.ad-card-desc {
    font-size: .77rem; color: var(--muted); line-height: 1.6;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}

/* Agent row */
.ad-card-agent {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
}
.ad-agent-avatar {
    width: 26px; height: 26px; border-radius: 50%;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center;
    font-size: .68rem; font-weight: 700; color: var(--gold); flex-shrink: 0;
}
.ad-agent-name { font-size: .75rem; font-weight: 500; color: var(--text); }
.ad-agent-role { font-size: .68rem; color: var(--dim); }

/* Dates */
.ad-card-dates { display: flex; align-items: center; gap: 10px; }
.ad-date-item {
    display: flex; align-items: center; gap: 4px;
    font-size: .71rem; color: var(--dim);
}
.ad-date-item svg { width: 11px; height: 11px; color: var(--gold); }
.ad-date-item strong { color: var(--muted); font-weight: 500; }

/* Card footer */
.ad-card-foot {
    display: flex; align-items: center; justify-content: space-between;
    padding-top: 9px; margin-top: auto;
}
.ad-card-entity {
    display: flex; align-items: center; gap: 5px;
    font-size: .72rem; color: var(--muted);
}
.ad-card-entity svg { width: 11px; height: 11px; color: var(--gold); }
.ad-card-view {
    display: flex; align-items: center; gap: 4px;
    font-size: .74rem; font-weight: 600; color: var(--gold);
    transition: gap var(--t);
}
.ad-card:hover .ad-card-view { gap: 8px; }
.ad-card-view svg { width: 11px; height: 11px; }

/* Expired overlay */
.ad-card.expired { opacity: .55; }

/* ── List view ── */
.ad-row.list-v .col-xl-3, .ad-row.list-v .col-lg-4, .ad-row.list-v .col-md-6 { flex: 0 0 100%; max-width: 100%; }
.ad-row.list-v .ad-card { flex-direction: row; max-height: 150px; }
.ad-row.list-v .ad-card-img { width: 200px; min-width: 200px; aspect-ratio: unset; flex-shrink: 0; }
.ad-row.list-v .ad-card-body { padding: 11px 13px; }
.ad-row.list-v .ad-card-desc { display: none; }
@media (max-width: 500px) { .ad-row.list-v .ad-card-img { width: 130px; min-width: 130px; } }

/* ── Empty ── */
.ad-empty { text-align: center; padding: 64px 20px; color: var(--dim); }
.ad-empty svg { width: 42px; height: 42px; margin-bottom: 14px; opacity: .3; }
.ad-empty h3 { font-size: .92rem; color: var(--muted); margin-bottom: 5px; }

@media (max-width: 640px) { .ad-meta { margin-left: 0; } .ad-hero-stats { display: none; } }
</style>

{{-- ── Hero ── --}}
<section class="ad-hero">
    <div class="container">
        <div class="ad-hero-inner">
            <div>
                <div class="ad-eyebrow">Terra Marketplace</div>
                <h1>Featured <em>Advertisements</em></h1>
                <p>Explore promoted listings, spotlight properties, and exclusive offers from verified agents across Rwanda.</p>
            </div>
            <div class="ad-hero-stats">
                <div>
                    <div class="ad-hstat-val">{{ $advertisements->count() }}<em>+</em></div>
                    <div class="ad-hstat-lbl">Active Ads</div>
                </div>
                <div>
                    <div class="ad-hstat-val">{{ $advertisements->where('status','active')->count() }}<em></em></div>
                    <div class="ad-hstat-lbl">Live Now</div>
                </div>
                <div>
                    <div class="ad-hstat-val">{{ $advertisements->pluck('agent_id')->unique()->count() }}<em>+</em></div>
                    <div class="ad-hstat-lbl">Agents</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Filter bar ── --}}
<div class="ad-filter">
    <div class="container">
        <div class="ad-filter-inner">

            <div class="ad-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" id="ad-q" placeholder="Search title or description…" autocomplete="off">
            </div>

            <div class="ad-tabs">
                <button class="ad-tab on" data-s="all">All</button>
                <button class="ad-tab" data-s="active">Active</button>
                <button class="ad-tab" data-s="pending">Pending</button>
                <button class="ad-tab" data-s="expired">Expired</button>
            </div>

            <select class="ad-select" id="ad-type-f">
                <option value="">Any Type</option>
                <option value="featured">Featured</option>
                <option value="spotlight">Spotlight</option>
                <option value="banner">Banner</option>
                <option value="boost">Boost</option>
            </select>

            <select class="ad-select" id="ad-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="ending-soon">Ending Soon</option>
                <option value="price-desc">Price High–Low</option>
                <option value="price-asc">Price Low–High</option>
            </select>

            <div class="ad-meta">
                <span class="ad-count"><strong id="ad-count">{{ $advertisements->count() }}</strong> ads</span>
                <div class="ad-vbtns">
                    <button class="ad-vbtn on" id="ad-vgrid" title="Grid view">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h7v7H4V4zm9 0h7v7h-7V4zm0 9h7v7h-7v-7zM4 13h7v7H4v-7z"/></svg>
                    </button>
                    <button class="ad-vbtn" id="ad-vlist" title="List view">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 4h13v2H8V4zM4.5 6.5a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zM4.5 20a1 1 0 110-2 1 1 0 010 2zM8 11h13v2H8v-2zm0 7h13v2H8v-2z"/></svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Featured Banner (top ad) ── --}}
@php $featuredBanner = $advertisements->where('ad_type','banner')->where('status','active')->first(); @endphp
@if($featuredBanner)
<div class="ad-featured-strip">
    <div class="container">
        <div class="ad-banner">
            @if($featuredBanner->banner_image)
            <div class="ad-banner-bg" style="background-image:url('{{ asset('storage/'.$featuredBanner->banner_image) }}')"></div>
            @endif
            <div class="ad-banner-overlay"></div>
            <div class="ad-banner-content">
                <div class="ad-banner-type">
                    <svg viewBox="0 0 24 24" fill="currentColor" style="width:10px;height:10px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Banner Ad · Active
                </div>
                <h2 class="ad-banner-title">{{ $featuredBanner->title }}</h2>
                @if($featuredBanner->description)
                <p class="ad-banner-desc">{{ Str::limit($featuredBanner->description, 120) }}</p>
                @endif
                <a href="#" class="ad-banner-cta">
                    Learn More
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            {{-- Agent info ── --}}
            <div class="ad-banner-agent">
                <div class="ad-banner-agent-avatar">{{ strtoupper(substr($featuredBanner->agent->user->name ?? 'A', 0, 1)) }}</div>
                <div>
                    <div class="ad-banner-agent-name">{{ $featuredBanner->agent->user->name ?? 'Terra Agent' }}</div>
                </div>
            </div>
            <div class="ad-banner-dates">
                {{ \Carbon\Carbon::parse($featuredBanner->start_date)->format('M j') }} –
                {{ \Carbon\Carbon::parse($featuredBanner->end_date)->format('M j, Y') }}
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── Ad Cards ── --}}
<div class="ad-main">
    <div class="container">

        <div class="row g-3 ad-row" id="ad-row">

            @forelse($advertisements as $i => $ad)
            @php
                $initials = strtoupper(substr($ad->agent->user->name ?? 'A', 0, 2));
                $typeClass = 'ad-type-'.($ad->ad_type ?? 'featured');
                $statusClass = 'ad-s-'.($ad->status ?? 'pending');
                $isExpired = $ad->status === 'expired';
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 col-12"
                 style="animation-delay:{{ $i * 0.04 }}s">
                <div class="ad-card {{ $isExpired ? 'expired' : '' }}"
                     data-title="{{ strtolower($ad->title) }}"
                     data-desc="{{ strtolower($ad->description ?? '') }}"
                     data-status="{{ $ad->status }}"
                     data-adtype="{{ $ad->ad_type }}"
                     data-price="{{ $ad->price }}"
                     data-end="{{ \Carbon\Carbon::parse($ad->end_date)->timestamp }}"
                     data-created="{{ $ad->created_at->timestamp ?? 0 }}">

                    <div class="ad-card-img">
                        <span class="ad-type-badge {{ $typeClass }}">{{ ucfirst($ad->ad_type) }}</span>
                        <span class="ad-status-badge {{ $statusClass }}">{{ ucfirst($ad->status) }}</span>

                        @if($ad->banner_image)
                            <img src="{{ asset('storage/'.$ad->banner_image) }}" alt="{{ $ad->title }}" loading="lazy">
                        @else
                            <div class="ad-card-img-placeholder">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                            </div>
                        @endif
                    </div>

                    <div class="ad-card-body">
                        <p class="ad-card-title">{{ $ad->title }}</p>
                        @if($ad->description)
                        <p class="ad-card-desc">{{ Str::limit($ad->description, 90) }}</p>
                        @endif

                        {{-- Agent row ── --}}
                        <div class="ad-card-agent">
                            <div class="ad-agent-avatar">{{ $initials }}</div>
                            <div>
                                <div class="ad-agent-name">{{ $ad->agent->user->name ?? 'Terra Agent' }}</div>
                                <div class="ad-agent-role">Verified Agent</div>
                            </div>
                        </div>

                        {{-- Dates ── --}}
                        <div class="ad-card-dates">
                            <div class="ad-date-item">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                                {{ \Carbon\Carbon::parse($ad->start_date)->format('M j') }}
                            </div>
                            <span style="color:var(--dim);font-size:.7rem">→</span>
                            <div class="ad-date-item">
                                <strong>{{ \Carbon\Carbon::parse($ad->end_date)->format('M j, Y') }}</strong>
                            </div>
                            @if($ad->status === 'active')
                            <span style="font-size:.68rem;color:var(--green);font-weight:600;margin-left:auto">
                                {{ \Carbon\Carbon::parse($ad->end_date)->diffForHumans() }}
                            </span>
                            @endif
                        </div>

                        <div class="ad-card-foot">
                            <div class="ad-card-entity">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                {{ ucfirst(class_basename($ad->advertisable_type ?? 'Property')) }}
                                @if($ad->price > 0)
                                &nbsp;·&nbsp; <span style="color:var(--gold);font-weight:600">{{ number_format($ad->price) }} RWF</span>
                                @endif
                            </div>
                            <span class="ad-card-view">
                                View
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="ad-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M3 3h18v18H3V3zm2 2v14h14V5H5z"/>
                    </svg>
                    <h3>No advertisements found</h3>
                    <p>Check back soon — new ads are posted regularly.</p>
                </div>
            </div>
            @endforelse

        </div>

        <div class="ad-empty" id="ad-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/></svg>
            <h3>No ads match your filters</h3>
            <p>Try adjusting your search or clearing filters.</p>
        </div>

    </div>
</div>

<script>
(function () {
    const row    = document.getElementById('ad-row');
    const cards  = Array.from(row.querySelectorAll('.ad-card'));
    const countEl= document.getElementById('ad-count');
    const emptyEl= document.getElementById('ad-empty');

    let state = { q:'', status:'all', adtype:'', sort:'newest' };

    function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }

    function run() {
        const q = state.q.toLowerCase();

        let vis = cards.filter(c => {
            if (state.status !== 'all' && c.dataset.status !== state.status) return false;
            if (state.adtype && c.dataset.adtype !== state.adtype) return false;
            if (q && !(c.dataset.title + ' ' + c.dataset.desc).includes(q)) return false;
            return true;
        });

        if (state.sort === 'oldest')      vis.sort((a,b) => +a.dataset.created - +b.dataset.created);
        if (state.sort === 'newest')      vis.sort((a,b) => +b.dataset.created - +a.dataset.created);
        if (state.sort === 'ending-soon') vis.sort((a,b) => +a.dataset.end - +b.dataset.end);
        if (state.sort === 'price-asc')   vis.sort((a,b) => +a.dataset.price - +b.dataset.price);
        if (state.sort === 'price-desc')  vis.sort((a,b) => +b.dataset.price - +a.dataset.price);

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

    document.getElementById('ad-q')
        .addEventListener('input', debounce(e => { state.q = e.target.value; run(); }, 220));
    document.getElementById('ad-type-f')
        .addEventListener('change', e => { state.adtype = e.target.value; run(); });
    document.getElementById('ad-sort')
        .addEventListener('change', e => { state.sort = e.target.value; run(); });

    document.querySelectorAll('.ad-tab').forEach(t => {
        t.addEventListener('click', () => {
            document.querySelectorAll('.ad-tab').forEach(x => x.classList.remove('on'));
            t.classList.add('on');
            state.status = t.dataset.s;
            run();
        });
    });

    /* View toggle */
    document.getElementById('ad-vgrid').addEventListener('click', () => {
        row.classList.remove('list-v');
        document.getElementById('ad-vgrid').classList.add('on');
        document.getElementById('ad-vlist').classList.remove('on');
        localStorage.setItem('adView', 'grid');
    });
    document.getElementById('ad-vlist').addEventListener('click', () => {
        row.classList.add('list-v');
        document.getElementById('ad-vlist').classList.add('on');
        document.getElementById('ad-vgrid').classList.remove('on');
        localStorage.setItem('adView', 'list');
    });
    if (localStorage.getItem('adView') === 'list') document.getElementById('ad-vlist').click();

    run();
})();
</script>

@endsection