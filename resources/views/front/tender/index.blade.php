@extends('layouts.guest')
@section('title', 'Tenders')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:       #F7F5F2;
    --surface:  #FFFFFF;
    --dark:     #0E0E0C;
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
    --red:      #991B1B;
    --red-bg:   rgba(153,27,27,.07);
    --red-bd:   rgba(153,27,27,.2);
    --r:        12px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ══ HERO ══ */
.td-hero {
    background: var(--dark);
    position: relative; overflow: hidden; padding: 60px 0 52px;
}
.td-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 60% at 0% 50%, rgba(200,135,58,.12) 0%, transparent 65%),
        radial-gradient(ellipse 35% 50% at 100% 25%, rgba(200,135,58,.05) 0%, transparent 55%);
    pointer-events: none;
}
.td-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.016) 39px, rgba(255,255,255,.016) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255,255,255,.01) 79px, rgba(255,255,255,.01) 80px);
    pointer-events: none;
}
.td-hero .container { position: relative; z-index: 2; }
.td-hero-inner { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; flex-wrap: wrap; }

.td-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 10px;
}
.td-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .6; }
.td-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 4.5vw, 3rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.025em; color: #F0EDE8;
}
.td-hero h1 em { font-style: italic; color: var(--gold-lt); }
.td-hero p { font-size: .84rem; color: rgba(240,237,232,.38); margin-top: 8px; max-width: 420px; line-height: 1.7; }
.td-hero-stats { display: flex; gap: 20px; flex-shrink: 0; }
.td-hstat-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem; font-weight: 600; color: #F0EDE8; line-height: 1; letter-spacing: -.02em;
}
.td-hstat-val em { color: var(--gold-lt); font-style: normal; }
.td-hstat-lbl { font-size: .67rem; color: rgba(240,237,232,.3); text-transform: uppercase; letter-spacing: .08em; margin-top: 2px; }

/* ══ FILTER BAR ══ */
.td-filter {
    background: var(--surface); border-bottom: 1px solid var(--border);
    padding: 11px 0; position: sticky; top: 0; z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.td-filter-inner { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.td-search { position: relative; flex: 1; min-width: 160px; max-width: 260px; }
.td-search svg {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%); width: 13px; height: 13px;
    color: var(--dim); pointer-events: none;
}
.td-search input {
    width: 100%; padding: 8px 11px 8px 28px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .81rem; font-family: 'DM Sans', sans-serif;
    background: var(--bg); color: var(--text); transition: border-color var(--t);
}
.td-search input:focus { outline: none; border-color: var(--gold); background: var(--surface); }
.td-search input::placeholder { color: var(--dim); }
.td-select {
    padding: 6px 24px 6px 10px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .78rem; font-family: 'DM Sans', sans-serif; color: var(--text);
    background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 7px center no-repeat;
    appearance: none; cursor: pointer; transition: border-color var(--t);
}
.td-select:focus { outline: none; border-color: var(--gold); }
.td-meta { display: flex; align-items: center; gap: 8px; margin-left: auto; }
.td-count { font-size: .77rem; color: var(--dim); white-space: nowrap; }
.td-count strong { color: var(--text); }

/* ══ LAYOUT ══ */
.td-page { padding: 28px 0 80px; }
.td-layout {
    display: grid; grid-template-columns: 1fr 300px;
    gap: 24px; align-items: start;
}
@media (max-width: 900px) { .td-layout { grid-template-columns: 1fr; } .td-sidebar { order: -1; } }

/* ══ TENDER CARDS ══ */
.td-list { display: flex; flex-direction: column; gap: 14px; }

.td-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden;
    transition: border-color var(--t), box-shadow var(--t), transform var(--t);
    animation: tdFu .35s ease both;
}
.td-card:hover {
    border-color: var(--gold-bd);
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
    transform: translateY(-2px);
}
@keyframes tdFu { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

.td-card-inner {
    display: grid; grid-template-columns: 1fr auto;
    gap: 0; align-items: stretch;
}
@media (max-width: 600px) { .td-card-inner { grid-template-columns: 1fr; } }

.td-card-body { padding: 18px 20px; display: flex; flex-direction: column; gap: 10px; }

/* Top row: badges */
.td-card-tags { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.td-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 2px 8px; border-radius: 5px;
    font-size: .62rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
}
.td-badge-open    { background: var(--green-bg); border: 1px solid var(--green-bd); color: var(--green); }
.td-badge-open::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: var(--green); }
.td-badge-closed  { background: var(--red-bg); border: 1px solid var(--red-bd); color: var(--red); }
.td-badge-closed::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: var(--red); }
.td-badge-pending { background: rgba(180,140,10,.08); border: 1px solid rgba(180,140,10,.2); color: #8B6914; }
.td-badge-pending::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: #C8873A; }
.td-badge-loc {
    background: var(--gold-bg); border: 1px solid var(--gold-bd); color: var(--gold);
    font-size: .62rem; font-weight: 600; padding: 2px 7px; border-radius: 5px;
    display: inline-flex; align-items: center; gap: 3px;
}
.td-badge-loc svg { width: 9px; height: 9px; }

.td-card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem; font-weight: 600; letter-spacing: -.01em;
    color: var(--text); line-height: 1.3; margin: 0;
    transition: color var(--t);
}
.td-card:hover .td-card-title { color: var(--gold); }
.td-card-desc {
    font-size: .81rem; color: var(--muted); line-height: 1.7;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

.td-card-meta { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.td-meta-item {
    display: flex; align-items: center; gap: 5px;
    font-size: .74rem; color: var(--dim);
}
.td-meta-item svg { width: 12px; height: 12px; color: var(--gold); flex-shrink: 0; }
.td-meta-item strong { color: var(--muted); font-weight: 500; }

.td-card-foot {
    display: flex; align-items: center; justify-content: space-between;
    border-top: 1px solid var(--border); padding-top: 11px; margin-top: auto;
    flex-wrap: wrap; gap: 8px;
}
.td-deadline {
    display: flex; align-items: center; gap: 5px;
    font-size: .75rem; font-weight: 600;
}
.td-deadline svg { width: 12px; height: 12px; }
.td-deadline.near { color: #991B1B; }
.td-deadline.ok   { color: var(--green); }
.td-deadline.warn { color: #8B6914; }

.td-card-cta {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 7px 14px; border-radius: 8px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    font-size: .78rem; font-weight: 600; color: var(--gold);
    transition: all var(--t); text-decoration: none;
}
.td-card:hover .td-card-cta { background: var(--gold); border-color: var(--gold); color: #fff; }
.td-card-cta svg { width: 12px; height: 12px; }

/* Right accent strip */
.td-card-strip {
    width: 80px; display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 4px;
    border-left: 1px solid var(--border); padding: 16px 12px;
    background: var(--bg); flex-shrink: 0;
}
@media (max-width: 600px) { .td-card-strip { display: none; } }
.td-strip-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem; font-weight: 600; color: rgba(0,0,0,.06);
    line-height: 1; letter-spacing: -.04em; user-select: none;
}
.td-card:hover .td-strip-num { color: rgba(200,135,58,.1); }

/* ══ EMPTY ══ */
.td-empty { text-align: center; padding: 64px 20px; color: var(--dim); }
.td-empty svg { width: 42px; height: 42px; margin-bottom: 14px; opacity: .3; }
.td-empty h3 { font-size: .92rem; color: var(--muted); margin-bottom: 5px; }

/* ══ SIDEBAR ══ */
.td-sidebar { position: sticky; top: 24px; display: flex; flex-direction: column; gap: 14px; }
.td-panel { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r); overflow: hidden; }
.td-panel-head {
    padding: 13px 16px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 8px;
}
.td-panel-icon {
    width: 28px; height: 28px; border-radius: 7px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; flex-shrink: 0;
}
.td-panel-icon svg { width: 13px; height: 13px; color: var(--gold); }
.td-panel-title { font-family: 'Cormorant Garamond', serif; font-size: .95rem; font-weight: 600; color: var(--text); margin: 0; }
.td-panel-body { padding: 12px 14px; }

/* SB Search */
.td-sb-search { position: relative; }
.td-sb-search input {
    width: 100%; padding: 9px 36px 9px 12px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .8rem; font-family: 'DM Sans', sans-serif;
    background: var(--bg); color: var(--text); transition: border-color var(--t);
}
.td-sb-search input:focus { outline: none; border-color: var(--gold); background: var(--surface); }
.td-sb-search input::placeholder { color: var(--dim); }
.td-sb-search button {
    position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer; color: var(--gold);
}
.td-sb-search button svg { width: 14px; height: 14px; display: block; }

/* Locations */
.td-loc-list { display: flex; flex-direction: column; gap: 2px; }
.td-loc-item {
    display: flex; align-items: center; justify-content: space-between;
    padding: 7px 9px; border-radius: 7px;
    font-size: .79rem; color: var(--muted);
    transition: background var(--t), color var(--t);
    cursor: pointer; text-decoration: none;
}
.td-loc-item:hover { background: var(--gold-bg); color: var(--gold); }
.td-loc-item:hover .td-loc-count { background: var(--gold); color: #fff; border-color: var(--gold); }
.td-loc-name { display: flex; align-items: center; gap: 6px; }
.td-loc-name svg { width: 11px; height: 11px; color: var(--gold); }
.td-loc-count {
    font-size: .65rem; font-weight: 700; padding: 1px 6px; border-radius: 4px;
    background: var(--bg); border: 1px solid var(--border); color: var(--dim);
    transition: all var(--t);
}

/* Featured tenders in SB */
.td-feat-list { display: flex; flex-direction: column; gap: 11px; }
.td-feat-item {
    display: flex; gap: 10px; align-items: flex-start;
    transition: transform var(--t); cursor: pointer; text-decoration: none; color: var(--text);
}
.td-feat-item:hover { transform: translateX(3px); }
.td-feat-thumb {
    width: 58px; height: 48px; border-radius: 7px;
    overflow: hidden; background: var(--bg); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.td-feat-thumb svg { width: 20px; height: 20px; color: rgba(200,135,58,.3); }
.td-feat-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.td-feat-date {
    font-size: .64rem; color: var(--gold); font-weight: 600;
    text-transform: uppercase; letter-spacing: .05em; margin-bottom: 2px;
}
.td-feat-title {
    font-size: .78rem; font-weight: 600; color: var(--text); line-height: 1.35;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

/* Stats mini */
.td-sb-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.td-sb-stat {
    background: var(--bg); border: 1px solid var(--border); border-radius: 8px;
    padding: 10px 12px; text-align: center;
}
.td-sb-stat-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.2rem; font-weight: 600; color: var(--gold); line-height: 1; letter-spacing: -.01em;
}
.td-sb-stat-lbl { font-size: .65rem; color: var(--dim); margin-top: 2px; }

@media (max-width: 640px) { .td-meta { margin-left: 0; } .td-hero-stats { display: none; } }
</style>

{{-- ══ HERO ══ --}}
<section class="td-hero">
    <div class="container">
        <div class="td-hero-inner">
            <div>
                <div class="td-eyebrow">Procurement</div>
                <h1>Open <em>Tenders</em></h1>
                <p>Browse active procurement notices, government tenders, and real estate project bids published across Rwanda.</p>
            </div>
            <div class="td-hero-stats">
                <div>
                    <div class="td-hstat-val">{{ $tenders->count() }}<em>+</em></div>
                    <div class="td-hstat-lbl">Total</div>
                </div>
                <div>
                    <div class="td-hstat-val">{{ $tenders->where('status','open')->count() }}<em></em></div>
                    <div class="td-hstat-lbl">Open Now</div>
                </div>
                <div>
                    <div class="td-hstat-val">{{ $locations->count() }}<em>+</em></div>
                    <div class="td-hstat-lbl">Locations</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══ FILTER BAR ══ --}}
<div class="td-filter">
    <div class="container">
        <div class="td-filter-inner">
            <div class="td-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" id="td-q" placeholder="Search tenders…" autocomplete="off">
            </div>
            <select class="td-select" id="td-loc-f">
                <option value="">All Locations</option>
                @foreach($locations as $loc)
                <option value="{{ strtolower($loc) }}">{{ $loc }}</option>
                @endforeach
            </select>
            <select class="td-select" id="td-status-f">
                <option value="">Any Status</option>
                <option value="open">Open</option>
                <option value="pending">Pending</option>
                <option value="closed">Closed</option>
            </select>
            <select class="td-select" id="td-sort">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="deadline">Deadline Soon</option>
                <option value="az">A–Z</option>
            </select>
            <div class="td-meta">
                <span class="td-count"><strong id="td-count">{{ $tenders->count() }}</strong> tenders</span>
            </div>
        </div>
    </div>
</div>

{{-- ══ MAIN ══ --}}
<div class="td-page">
<div class="container">
<div class="td-layout">

    {{-- ══ TENDER LIST ══ --}}
    <div>
        <div class="td-list" id="td-list">
            @forelse($tenders as $i => $tender)
            @php
                $deadline = $tender->deadline ?? $tender->end_date ?? null;
                $daysLeft = $deadline ? now()->diffInDays(\Carbon\Carbon::parse($deadline), false) : null;
                $deadlineClass = $daysLeft === null ? '' : ($daysLeft < 0 ? 'near' : ($daysLeft <= 7 ? 'warn' : 'ok'));
                $statusClass = match($tender->status ?? 'open') {
                    'open'    => 'td-badge-open',
                    'closed'  => 'td-badge-closed',
                    default   => 'td-badge-pending',
                };
            @endphp
            <div class="td-card"
                 style="animation-delay:{{ $i * 0.04 }}s"
                 data-title="{{ strtolower($tender->title) }}"
                 data-desc="{{ strtolower($tender->description ?? '') }}"
                 data-loc="{{ strtolower($tender->location ?? '') }}"
                 data-status="{{ $tender->status ?? 'open' }}"
                 data-created="{{ $tender->created_at->timestamp ?? 0 }}"
                 data-deadline="{{ $deadline ? \Carbon\Carbon::parse($deadline)->timestamp : 9999999999 }}">

                <div class="td-card-inner">
                    <div class="td-card-body">

                        {{-- Tags row ── --}}
                        <div class="td-card-tags">
                            <span class="td-badge {{ $statusClass }}">{{ ucfirst($tender->status ?? 'Open') }}</span>
                            @if($tender->location)
                            <span class="td-badge-loc">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                {{ $tender->location }}
                            </span>
                            @endif
                            @if($tender->category ?? null)
                            <span style="font-size:.62rem;color:var(--muted);padding:2px 7px;border:1px solid var(--border);border-radius:5px">
                                {{ $tender->category }}
                            </span>
                            @endif
                        </div>

                        {{-- Title ── --}}
                        <a href="{{ route('front.tenders.details', $tender->id) }}" class="td-card-title">
                            {{ $tender->title }}
                        </a>

                        {{-- Description ── --}}
                        @if($tender->description)
                        <p class="td-card-desc">{{ Str::limit($tender->description, 140) }}</p>
                        @endif

                        {{-- Meta row ── --}}
                        <div class="td-card-meta">
                            <div class="td-meta-item">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                <strong>{{ $tender->user->name ?? 'Terra Admin' }}</strong>
                            </div>
                            <div class="td-meta-item">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                                Published {{ $tender->created_at->format('d M Y') }}
                            </div>
                        </div>

                        {{-- Footer ── --}}
                        <div class="td-card-foot">
                            @if($deadline)
                            <div class="td-deadline {{ $deadlineClass }}">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
                                @if($daysLeft < 0)
                                    Deadline passed
                                @elseif($daysLeft === 0)
                                    Closes today
                                @elseif($daysLeft <= 7)
                                    Closes in {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }}
                                @else
                                    Deadline: {{ \Carbon\Carbon::parse($deadline)->format('d M Y') }}
                                @endif
                            </div>
                            @else
                            <div></div>
                            @endif

                            <a href="{{ route('front.tenders.details', $tender->id) }}" class="td-card-cta">
                                View Details
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"/></svg>
                            </a>
                        </div>

                    </div>

                    {{-- Right strip ── --}}
                    <div class="td-card-strip">
                        <div class="td-strip-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="td-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3>No tenders found</h3>
                <p>Check back soon — new tenders are published regularly.</p>
            </div>
            @endforelse
        </div>

        {{-- JS empty ── --}}
        <div class="td-empty" id="td-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/></svg>
            <h3>No tenders match your filters</h3>
            <p>Try adjusting your search or clearing filters.</p>
        </div>
    </div>

    {{-- ══ SIDEBAR ══ --}}
    <aside class="td-sidebar">

        {{-- Search ── --}}
        <div class="td-panel">
            <div class="td-panel-head">
                <div class="td-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168Z"/></svg></div>
                <p class="td-panel-title">Search Tenders</p>
            </div>
            <div class="td-panel-body">
                <div class="td-sb-search">
                    <input type="text" id="td-sb-q" placeholder="Keyword…">
                    <button type="button" onclick="document.getElementById('td-q').value=document.getElementById('td-sb-q').value; run();">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168Z"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats ── --}}
        <div class="td-panel">
            <div class="td-panel-head">
                <div class="td-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg></div>
                <p class="td-panel-title">Overview</p>
            </div>
            <div class="td-panel-body">
                <div class="td-sb-stats">
                    <div class="td-sb-stat">
                        <div class="td-sb-stat-val">{{ $tenders->count() }}</div>
                        <div class="td-sb-stat-lbl">Total</div>
                    </div>
                    <div class="td-sb-stat">
                        <div class="td-sb-stat-val" style="color:var(--green)">{{ $tenders->where('status','open')->count() }}</div>
                        <div class="td-sb-stat-lbl">Open</div>
                    </div>
                    <div class="td-sb-stat">
                        <div class="td-sb-stat-val" style="color:#8B6914">{{ $tenders->where('status','pending')->count() }}</div>
                        <div class="td-sb-stat-lbl">Pending</div>
                    </div>
                    <div class="td-sb-stat">
                        <div class="td-sb-stat-val" style="color:var(--red)">{{ $tenders->where('status','closed')->count() }}</div>
                        <div class="td-sb-stat-lbl">Closed</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Locations ── --}}
        @if($locations->count())
        <div class="td-panel">
            <div class="td-panel-head">
                <div class="td-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg></div>
                <p class="td-panel-title">Locations</p>
            </div>
            <div class="td-panel-body">
                <div class="td-loc-list">
                    @foreach($locations as $loc)
                    <button class="td-loc-item" onclick="filterByLoc('{{ strtolower($loc) }}')">
                        <span class="td-loc-name">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"/></svg>
                            {{ $loc }}
                        </span>
                        <span class="td-loc-count">{{ $tenders->where('location', $loc)->count() }}</span>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- Featured tenders ── --}}
        @if(isset($featuredTenders) && $featuredTenders->count())
        <div class="td-panel">
            <div class="td-panel-head">
                <div class="td-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></div>
                <p class="td-panel-title">Featured Tenders</p>
            </div>
            <div class="td-panel-body">
                <div class="td-feat-list">
                    @foreach($featuredTenders as $ft)
                    <a href="{{ route('front.tenders.details', $ft->id) }}" class="td-feat-item">
                        <div class="td-feat-thumb">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <div class="td-feat-date">{{ $ft->created_at->format('d M Y') }}</div>
                            <div class="td-feat-title">{{ $ft->title }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </aside>

</div>{{-- /layout --}}
</div>{{-- /container --}}
</div>{{-- /td-page --}}

<script>
(function () {
    const cards  = Array.from(document.querySelectorAll('.td-card'));
    const listEl = document.getElementById('td-list');
    const countEl= document.getElementById('td-count');
    const emptyEl= document.getElementById('td-empty');

    let state = { q:'', loc:'', status:'', sort:'newest' };

    function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }

    window.run = function run() {
        const q = state.q.toLowerCase();
        let vis = cards.filter(c => {
            if (state.status && c.dataset.status !== state.status) return false;
            if (state.loc && !c.dataset.loc.includes(state.loc)) return false;
            if (q && !(c.dataset.title + ' ' + c.dataset.desc).includes(q)) return false;
            return true;
        });

        if (state.sort === 'oldest')   vis.sort((a,b) => +a.dataset.created - +b.dataset.created);
        if (state.sort === 'newest')   vis.sort((a,b) => +b.dataset.created - +a.dataset.created);
        if (state.sort === 'deadline') vis.sort((a,b) => +a.dataset.deadline - +b.dataset.deadline);
        if (state.sort === 'az')       vis.sort((a,b) => a.dataset.title.localeCompare(b.dataset.title));

        const vs = new Set(vis);
        cards.forEach(c => { c.style.display = vs.has(c) ? '' : 'none'; });
        vis.forEach(c => listEl.appendChild(c));

        const n = vis.length;
        countEl.textContent = n;
        if (emptyEl) emptyEl.style.display = n === 0 ? 'block' : 'none';
    };

    /* Sync filter bar search with sidebar search */
    const qMain = document.getElementById('td-q');
    const qSb   = document.getElementById('td-sb-q');
    if (qMain) qMain.addEventListener('input', debounce(e => { state.q = e.target.value; if (qSb) qSb.value = e.target.value; run(); }, 220));
    if (qSb)   qSb.addEventListener('input', debounce(e => { state.q = e.target.value; if (qMain) qMain.value = e.target.value; run(); }, 220));

    document.getElementById('td-loc-f')?.addEventListener('change',    e => { state.loc    = e.target.value; run(); });
    document.getElementById('td-status-f')?.addEventListener('change', e => { state.status = e.target.value; run(); });
    document.getElementById('td-sort')?.addEventListener('change',     e => { state.sort   = e.target.value; run(); });

    window.filterByLoc = function (loc) {
        state.loc = loc;
        const sel = document.getElementById('td-loc-f');
        if (sel) sel.value = loc;
        run();
    };

    run();
})();
</script>

@endsection