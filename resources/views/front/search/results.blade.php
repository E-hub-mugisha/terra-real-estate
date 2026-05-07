@extends('layouts.guest')

@section('title', $q ? "Search: \"{$q}\" — Terra Real Estate" : 'Search — Terra Real Estate')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

  :root {
    --gold: #C8873A;
    --orange: #D05208;
    --navy: #19265d;
    --t: .2s cubic-bezier(.4, 0, .2, 1);
  }

  *,
  *::before,
  *::after {
    box-sizing: border-box;
  }

  /* ══════════════════════════════════════
     HERO BAND
  ══════════════════════════════════════ */
  .sr-hero {
    background: linear-gradient(135deg, #19265d 0%, #0f1a45 100%);
    padding: 36px 0 0;
    font-family: 'DM Sans', sans-serif;
  }

  .sr-hero-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px 32px;
  }

  .sr-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .75rem;
    color: rgba(255, 255, 255, .4);
    margin-bottom: 18px;
    font-family: 'DM Sans', sans-serif;
  }

  .sr-breadcrumb a {
    color: rgba(255, 255, 255, .5);
    text-decoration: none;
    transition: color var(--t);
  }

  .sr-breadcrumb a:hover {
    color: #fff;
  }

  .sr-breadcrumb svg {
    width: 11px;
    height: 11px;
  }

  .sr-title {
    font-size: 1.55rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 5px;
    font-family: 'DM Sans', sans-serif;
    line-height: 1.3;
  }

  .sr-title em {
    color: var(--gold);
    font-style: normal;
  }

  .sr-meta {
    font-size: .82rem;
    color: rgba(255, 255, 255, .4);
    margin-bottom: 22px;
    font-family: 'DM Sans', sans-serif;
  }

  /* ── Inline search bar ── */
  .sr-searchbar {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    max-width: 660px;
    box-shadow: 0 8px 28px rgba(0, 0, 0, .22);
  }

  .sr-searchbar form {
    display: flex;
    align-items: center;
    width: 100%;
  }

  .sr-searchbar-icon {
    width: 48px;
    height: 52px;
    display: grid;
    place-items: center;
    color: var(--gold);
    flex-shrink: 0;
  }

  .sr-searchbar-icon svg {
    width: 18px;
    height: 18px;
  }

  .sr-searchbar input {
    flex: 1;
    border: none;
    outline: none;
    font-size: .93rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--navy);
    height: 52px;
    background: transparent;
    padding: 0 6px 0 0;
  }

  .sr-searchbar input::placeholder {
    color: #aaa;
  }

  .sr-searchbar select {
    border: none;
    border-left: 1px solid rgba(0, 0, 0, .08);
    outline: none;
    font-size: .8rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--navy);
    height: 52px;
    padding: 0 10px;
    background: transparent;
    cursor: pointer;
    flex-shrink: 0;
  }

  .sr-searchbar button {
    height: 52px;
    padding: 0 26px;
    background: var(--orange);
    border: none;
    color: #fff;
    font-size: .86rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background var(--t);
    white-space: nowrap;
    flex-shrink: 0;
  }

  .sr-searchbar button:hover {
    background: var(--navy);
  }

  /* ── Filter tabs ── */
  .sr-tabs-band {
    background: rgba(0, 0, 0, .25);
    border-top: 1px solid rgba(255, 255, 255, .06);
  }

  .sr-tabs {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    gap: 0;
    overflow-x: auto;
    scrollbar-width: none;
    font-family: 'DM Sans', sans-serif;
  }

  .sr-tabs::-webkit-scrollbar {
    display: none;
  }

  .sr-tab {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 13px 16px;
    font-size: .8rem;
    font-weight: 600;
    color: rgba(255, 255, 255, .42);
    text-decoration: none;
    border-bottom: 2px solid transparent;
    white-space: nowrap;
    transition: color var(--t), border-color var(--t);
  }

  .sr-tab:hover {
    color: rgba(255, 255, 255, .75);
  }

  .sr-tab.active {
    color: #fff;
    border-bottom-color: var(--gold);
  }

  .sr-tab-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 9px;
    background: rgba(200, 135, 58, .22);
    color: var(--gold);
    font-size: .67rem;
    font-weight: 700;
  }

  .sr-tab.active .sr-tab-pill {
    background: var(--gold);
    color: #fff;
  }

  /* ══════════════════════════════════════
     PAGE BODY
  ══════════════════════════════════════ */
  .sr-page {
    min-height: 60vh;
    font-family: 'DM Sans', sans-serif;
    padding: 40px 0 80px;
    background: #f7f6f3;
  }

  .sr-body {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
  }

  /* ── Section ── */
  .sr-section {
    margin-bottom: 44px;
  }

  .sr-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
    padding-bottom: 10px;
    border-bottom: 1.5px solid rgba(25, 38, 93, .07);
  }

  .sr-section-title {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: .95rem;
    font-weight: 700;
    color: var(--navy);
  }

  .sr-section-title svg {
    width: 17px;
    height: 17px;
    color: var(--gold);
  }

  .sr-section-badge {
    font-size: .68rem;
    font-weight: 700;
    padding: 2px 9px;
    border-radius: 20px;
    background: rgba(200, 135, 58, .12);
    color: var(--gold);
  }

  .sr-view-all {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .78rem;
    font-weight: 600;
    color: var(--orange);
    text-decoration: none;
    transition: gap var(--t);
  }

  .sr-view-all:hover {
    gap: 8px;
    color: var(--orange);
  }

  .sr-view-all svg {
    width: 12px;
    height: 12px;
  }

  /* ══════════════════════════════════════
     PROPERTY CARDS
  ══════════════════════════════════════ */
  .sr-prop-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(248px, 1fr));
    gap: 18px;
  }

  .sr-prop-card {
    background: #fff;
    border: 1px solid rgba(0, 0, 0, .07);
    border-radius: 14px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: block;
    transition: box-shadow var(--t), transform var(--t);
  }

  .sr-prop-card:hover {
    box-shadow: 0 12px 32px rgba(25, 38, 93, .11);
    transform: translateY(-3px);
  }

  .sr-prop-thumb {
    width: 100%;
    height: 174px;
    object-fit: cover;
    display: block;
    background: #e8e4df;
  }

  .sr-prop-thumb-ph {
    width: 100%;
    height: 174px;
    background: linear-gradient(135deg, #e8e4df, #d0ccc5);
    display: grid;
    place-items: center;
  }

  .sr-prop-thumb-ph svg {
    width: 34px;
    height: 34px;
    color: #bbb;
  }

  .sr-prop-body {
    padding: 13px 15px 15px;
  }

  .sr-prop-kicker {
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--gold);
    margin-bottom: 4px;
  }

  .sr-prop-title {
    font-size: .88rem;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.4;
    margin-bottom: 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .sr-prop-loc {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: .73rem;
    color: #888;
    margin-bottom: 8px;
  }

  .sr-prop-loc svg {
    width: 11px;
    height: 11px;
    flex-shrink: 0;
  }

  .sr-prop-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .sr-prop-price {
    font-size: .92rem;
    font-weight: 700;
    color: var(--orange);
  }

  .sr-prop-status {
    font-size: .65rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
    background: rgba(25, 38, 93, .07);
    color: var(--navy);
    text-transform: capitalize;
  }

  /* ══════════════════════════════════════
     DESIGN CARDS (architectural)
  ══════════════════════════════════════ */
  .sr-design-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
  }

  .sr-design-card {
    background: #fff;
    border: 1px solid rgba(0, 0, 0, .07);
    border-radius: 14px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    display: block;
    transition: box-shadow var(--t), transform var(--t);
  }

  .sr-design-card:hover {
    box-shadow: 0 10px 28px rgba(25, 38, 93, .11);
    transform: translateY(-2px);
  }

  .sr-design-thumb {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
    background: #e8e4df;
  }

  .sr-design-thumb-ph {
    width: 100%;
    height: 150px;
    background: linear-gradient(135deg, #19265d15, #c8873a15);
    display: grid;
    place-items: center;
  }

  .sr-design-thumb-ph svg {
    width: 32px;
    height: 32px;
    color: var(--gold);
  }

  .sr-design-body {
    padding: 12px 14px 14px;
  }

  .sr-design-title {
    font-size: .86rem;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 6px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .sr-design-price {
    font-size: .84rem;
    font-weight: 700;
    color: var(--orange);
  }

  .sr-design-free {
    font-size: .75rem;
    font-weight: 700;
    color: #2d8a4e;
  }

  /* ══════════════════════════════════════
     PEOPLE GRID (agents / consultants / professionals)
  ══════════════════════════════════════ */
  .sr-people-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 14px;
  }

  .sr-person-card {
    background: #fff;
    border: 1px solid rgba(0, 0, 0, .07);
    border-radius: 14px;
    padding: 20px 14px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    display: block;
    transition: box-shadow var(--t), transform var(--t);
  }

  .sr-person-card:hover {
    box-shadow: 0 8px 22px rgba(25, 38, 93, .1);
    transform: translateY(-2px);
  }

  .sr-person-avatar {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    margin: 0 auto 10px;
    background: #e8e4df;
  }

  .sr-person-initials {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2d3f8e);
    color: #fff;
    font-size: 1.05rem;
    font-weight: 700;
    display: grid;
    place-items: center;
    margin: 0 auto 10px;
  }

  .sr-person-name {
    font-size: .86rem;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 3px;
    line-height: 1.3;
  }

  .sr-person-sub {
    font-size: .72rem;
    color: #888;
    margin-bottom: 8px;
  }

  .sr-person-badge {
    display: inline-block;
    font-size: .65rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 20px;
    background: rgba(200, 135, 58, .1);
    color: var(--gold);
  }

  /* ══════════════════════════════════════
     LIST ITEMS (news / tenders / jobs / ads / announcements)
  ══════════════════════════════════════ */
  .sr-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .sr-list-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: #fff;
    border: 1px solid rgba(0, 0, 0, .07);
    border-radius: 12px;
    padding: 14px 16px;
    text-decoration: none;
    color: inherit;
    transition: box-shadow var(--t), border-color var(--t);
  }

  .sr-list-item:hover {
    box-shadow: 0 6px 18px rgba(25, 38, 93, .08);
    border-color: rgba(25, 38, 93, .14);
  }

  .sr-list-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(200, 135, 58, .1);
    display: grid;
    place-items: center;
    flex-shrink: 0;
  }

  .sr-list-icon svg {
    width: 17px;
    height: 17px;
    color: var(--gold);
  }

  .sr-list-thumb {
    width: 78px;
    height: 58px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
    background: #e8e4df;
  }

  .sr-list-body {
    flex: 1;
    min-width: 0;
  }

  .sr-list-kicker {
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--gold);
    margin-bottom: 3px;
  }

  .sr-list-title {
    font-size: .88rem;
    font-weight: 700;
    color: var(--navy);
    line-height: 1.4;
    margin-bottom: 3px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .sr-list-excerpt {
    font-size: .76rem;
    color: #888;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 4px;
  }

  .sr-list-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
  }

  .sr-list-date {
    font-size: .7rem;
    color: #bbb;
  }

  .sr-list-tag {
    font-size: .65rem;
    font-weight: 700;
    padding: 1px 7px;
    border-radius: 10px;
    background: rgba(25, 38, 93, .07);
    color: var(--navy);
  }

  /* ══════════════════════════════════════
     EMPTY / NO QUERY STATES
  ══════════════════════════════════════ */
  .sr-state {
    text-align: center;
    padding: 72px 24px;
    font-family: 'DM Sans', sans-serif;
  }

  .sr-state-icon {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: rgba(200, 135, 58, .09);
    display: grid;
    place-items: center;
    margin: 0 auto 18px;
  }

  .sr-state-icon svg {
    width: 30px;
    height: 30px;
    color: var(--gold);
  }

  .sr-state h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 8px;
  }

  .sr-state p {
    font-size: .85rem;
    color: #888;
    max-width: 360px;
    margin: 0 auto 22px;
    line-height: 1.6;
  }

  .sr-state-btns {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .sr-state-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    border-radius: 9px;
    font-size: .82rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    transition: all var(--t);
  }

  .sr-state-btn-solid {
    background: var(--navy);
    color: #fff;
  }

  .sr-state-btn-solid:hover {
    background: var(--orange);
    color: #fff;
  }

  .sr-state-btn-outline {
    border: 1.5px solid rgba(25, 38, 93, .18);
    color: var(--navy);
  }

  .sr-state-btn-outline:hover {
    border-color: var(--orange);
    color: var(--orange);
  }

  /* ══════════════════════════════════════
     RESPONSIVE
  ══════════════════════════════════════ */
  @media (max-width: 640px) {
    .sr-title {
      font-size: 1.2rem;
    }

    .sr-prop-grid {
      grid-template-columns: 1fr 1fr;
    }

    .sr-design-grid {
      grid-template-columns: 1fr 1fr;
    }

    .sr-people-grid {
      grid-template-columns: 1fr 1fr;
    }

    .sr-searchbar button {
      padding: 0 14px;
    }

    .sr-searchbar select {
      display: none;
    }
  }

  @media (max-width: 380px) {

    .sr-prop-grid,
    .sr-design-grid,
    .sr-people-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

{{-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ --}}
<div class="sr-hero">
  <div class="sr-hero-inner">

    {{-- Breadcrumb --}}
    <div class="sr-breadcrumb">
      <a href="{{ route('front.home') }}">Home</a>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 18l6-6-6-6" />
      </svg>
      <span>Search</span>
      @if($q)
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 18l6-6-6-6" />
      </svg>
      <span>{{ Str::limit($q, 45) }}</span>
      @endif
    </div>

    {{-- Title --}}
    @if($q)
    <h1 class="sr-title">Results for <em>"{{ $q }}"</em></h1>
    <p class="sr-meta">
      {{ $total }} result{{ $total !== 1 ? 's' : '' }} found
      @if($type !== 'all') &middot; filtered by <strong style="color:rgba(255,255,255,.65)">{{ ucfirst($type) }}</strong>@endif
    </p>
    @else
    <h1 class="sr-title">Search Terra Real Estate</h1>
    <p class="sr-meta">Find houses, lands, designs, agents, news, jobs and more across Rwanda</p>
    @endif

    {{-- Search bar --}}
    <div class="sr-searchbar">
      <form action="{{ route('front.search') }}" method="GET" style="display:flex;align-items:center;width:100%">
        <span class="sr-searchbar-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
          </svg>
        </span>
        <input type="text" name="q" value="{{ $q }}"
          placeholder="Search houses, lands, agents, jobs…"
          autofocus autocomplete="off">
        <select name="type">
          <option value="all" {{ $type === 'all'            ? 'selected' : '' }}>All</option>
          <option value="properties" {{ $type === 'properties'     ? 'selected' : '' }}>Properties</option>
          <option value="agents" {{ $type === 'agents'         ? 'selected' : '' }}>Agents & Pros</option>
          <option value="news" {{ $type === 'news'           ? 'selected' : '' }}>News</option>
          <option value="jobs" {{ $type === 'jobs'           ? 'selected' : '' }}>Jobs</option>
          <option value="tenders" {{ $type === 'tenders'        ? 'selected' : '' }}>Tenders</option>
          <option value="advertisements" {{ $type === 'advertisements' ? 'selected' : '' }}>Ads</option>
        </select>
        <button type="submit">Search</button>
      </form>
    </div>

  </div>

  {{-- Filter tabs (only when we have a query) --}}
  @if($q)
  @php
  $tabs = [
  'all' => ['label' => 'All', 'count' => $total],
  'properties' => ['label' => 'Properties', 'count' => $results['houses']->count() + $results['lands']->count() + $results['architectural_designs']->count()],
  'agents' => ['label' => 'Agents & Pros', 'count' => $results['agents']->count() + $results['consultants']->count() + $results['professionals']->count()],
  'news' => ['label' => 'News & Updates','count' => $results['news']->count() + $results['announcements']->count()],
  'jobs' => ['label' => 'Jobs', 'count' => $results['jobs']->count()],
  'tenders' => ['label' => 'Tenders', 'count' => $results['tenders']->count()],
  'advertisements' => ['label' => 'Ads', 'count' => $results['advertisements']->count()],
  ];
  @endphp
  <div class="sr-tabs-band">
    <div class="sr-tabs">
      @foreach($tabs as $key => $tab)
      @if($tab['count'] > 0 || $key === 'all')
      <a href="{{ route('front.search', ['q' => $q, 'type' => $key]) }}"
        class="sr-tab {{ $type === $key ? 'active' : '' }}">
        {{ $tab['label'] }}
        @if($tab['count'] > 0)
        <span class="sr-tab-pill">{{ $tab['count'] }}</span>
        @endif
      </a>
      @endif
      @endforeach
    </div>
  </div>
  @endif
</div>

{{-- ════════════════════════════════════════
     RESULTS BODY
════════════════════════════════════════ --}}
<div class="sr-page">
  <div class="sr-body">

    {{-- ── No query ── --}}
    @if(!$q)
    <div class="sr-state">
      <div class="sr-state-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <circle cx="11" cy="11" r="8" />
          <path d="m21 21-4.35-4.35" />
        </svg>
      </div>
      <h3>What are you looking for?</h3>
      <p>Search across all of Terra — houses, lands, architectural designs, verified agents, news, jobs, tenders and more.</p>
      <div class="sr-state-btns">
        <a href="{{ route('front.buy.homes') }}" class="sr-state-btn sr-state-btn-solid">Browse Houses</a>
        <a href="{{ route('front.buy.lands') }}" class="sr-state-btn sr-state-btn-outline">Browse Lands</a>
        <a href="{{ route('front.agents') }}" class="sr-state-btn sr-state-btn-outline">Find Agents</a>
      </div>
    </div>

    {{-- ── No results ── --}}
    @elseif($total === 0)
    <div class="sr-state">
      <div class="sr-state-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <circle cx="11" cy="11" r="8" />
          <path d="m21 21-4.35-4.35" />
        </svg>
      </div>
      <h3>No results for "{{ $q }}"</h3>
      <p>Try different keywords, a shorter search term, or browse our categories below.</p>
      <div class="sr-state-btns">
        <a href="{{ route('front.buy.homes') }}" class="sr-state-btn sr-state-btn-solid">Browse Houses</a>
        <a href="{{ route('front.buy.lands') }}" class="sr-state-btn sr-state-btn-outline">Browse Lands</a>
        <a href="{{ route('front.contact') }}" class="sr-state-btn sr-state-btn-outline">Get Help</a>
      </div>
    </div>

    @else

    {{-- ════════════════════════
           HOUSES
      ════════════════════════ --}}
    @if($results['houses']->isNotEmpty() && in_array($type, ['all', 'properties']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
          </svg>
          Houses
          <span class="sr-section-badge">{{ $results['houses']->count() }}</span>
        </div>
        <a href="{{ route('front.buy.homes') }}" class="sr-view-all">
          All houses <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-prop-grid">
        @foreach($results['houses'] as $house)
        <a href="{{ route('front.buy.home.details', $house->id) }}" class="sr-prop-card">
          @php $img = $house->images->first(); @endphp
          @if($img)
          <img src="{{ asset('image/houses/' . $house->images->first()->image_path) }}"
            alt="{{ $house->title }}" class="sr-prop-thumb">
          @else
          <div class="sr-prop-thumb-ph">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
            </svg>
          </div>
          @endif
          <div class="sr-prop-body">
            <div class="sr-prop-kicker">House &middot; {{ ucfirst($house->type ?? 'For Sale') }}</div>
            <div class="sr-prop-title">{{ $house->title }}</div>
            @if($house->district)
            <div class="sr-prop-loc">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
              </svg>
              {{ $house->district }}{{ $house->sector ? ', ' . $house->sector : '' }}
            </div>
            @endif
            <div class="sr-prop-footer">
              <div class="sr-prop-price">
                {{ $house->price ? 'RWF ' . number_format($house->price) : 'Contact for price' }}
              </div>
              @if($house->bedrooms)
              <div class="sr-prop-status">{{ $house->bedrooms }} bed</div>
              @endif
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           LANDS
      ════════════════════════ --}}
    @if($results['lands']->isNotEmpty() && in_array($type, ['all', 'properties']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5z" />
          </svg>
          Lands
          <span class="sr-section-badge">{{ $results['lands']->count() }}</span>
        </div>
        <a href="{{ route('front.buy.lands') }}" class="sr-view-all">
          All lands <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-prop-grid">
        @foreach($results['lands'] as $land)
        <a href="{{ route('front.buy.land.details', $land->id) }}" class="sr-prop-card">
          @php $img = $land->images->first(); @endphp
          @if($img)
          <img src="{{ asset('image/lands/' . $land->images->first()->image_path) }}"
            alt="{{ $land->title }}" class="sr-prop-thumb">
          @else
          <div class="sr-prop-thumb-ph">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5z" />
            </svg>
          </div>
          @endif
          <div class="sr-prop-body">
            <div class="sr-prop-kicker">Land &middot; {{ ucfirst($land->land_use ?? $land->zoning ?? 'Plot') }}</div>
            <div class="sr-prop-title">{{ $land->title }}</div>
            @if($land->district)
            <div class="sr-prop-loc">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
              </svg>
              {{ $land->district }}{{ $land->sector ? ', ' . $land->sector : '' }}
            </div>
            @endif
            <div class="sr-prop-footer">
              <div class="sr-prop-price">
                {{ $land->price ? 'RWF ' . number_format($land->price) : 'Contact for price' }}
              </div>
              @if($land->size_sqm)
              <div class="sr-prop-status">{{ number_format($land->size_sqm) }} m²</div>
              @endif
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           ARCHITECTURAL DESIGNS
      ════════════════════════ --}}
    @if($results['architectural_designs']->isNotEmpty() && in_array($type, ['all', 'properties']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
          </svg>
          Architectural Designs
          <span class="sr-section-badge">{{ $results['architectural_designs']->count() }}</span>
        </div>
        <a href="{{ route('front.buy.design') }}" class="sr-view-all">
          All designs <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-design-grid">
        @foreach($results['architectural_designs'] as $design)
        <a href="{{ route('front.buy.design.purchase', $design->slug) }}" class="sr-design-card">
          @if($design->preview_image)
          <img src="{{ asset($design->preview_image) }}"
            alt="{{ $design->title }}" class="sr-design-thumb">
          @else
          <div class="sr-design-thumb-ph">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
            </svg>
          </div>
          @endif
          <div class="sr-design-body">
            <div class="sr-design-title">{{ $design->title }}</div>
            @if($design->is_free)
            <div class="sr-design-free">Free Download</div>
            @else
            <div class="sr-design-price">{{ $design->formatted_price }}</div>
            @endif
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           AGENTS
      ════════════════════════ --}}
    @if($results['agents']->isNotEmpty() && in_array($type, ['all', 'agents']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
          </svg>
          Agents
          <span class="sr-section-badge">{{ $results['agents']->count() }}</span>
        </div>
        <a href="{{ route('front.agents') }}" class="sr-view-all">
          All agents <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-people-grid">
        @foreach($results['agents'] as $agent)
        <a href="{{ route('front.agent.details', $agent->id) }}" class="sr-person-card">
          @if($agent->profile_image)
          <img src="{{ asset('storage/' . $agent->profile_image) }}"
            alt="{{ $agent->full_name }}" class="sr-person-avatar">
          @else
          @php
          $parts = explode(' ', $agent->full_name);
          $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
          @endphp
          <div class="sr-person-initials">{{ $initials }}</div>
          @endif
          <div class="sr-person-name">{{ $agent->full_name }}</div>
          <div class="sr-person-sub">{{ $agent->office_location ?? 'Rwanda' }}</div>
          <span class="sr-person-badge">
            {{ $agent->is_verified ? '✓ Verified Agent' : 'Agent' }}
          </span>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           CONSULTANTS
      ════════════════════════ --}}
    @if($results['consultants']->isNotEmpty() && in_array($type, ['all', 'agents']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
          </svg>
          Consultants
          <span class="sr-section-badge">{{ $results['consultants']->count() }}</span>
        </div>
        <a href="{{ route('front.consultants.index') }}" class="sr-view-all">
          All consultants <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-people-grid">
        @foreach($results['consultants'] as $consultant)
        <a href="{{ route('front.consultant.details', $consultant->id) }}" class="sr-person-card">
          @if($consultant->photo)
          <img src="{{ asset('storage/' . $consultant->photo) }}"
            alt="{{ $consultant->name }}" class="sr-person-avatar">
          @else
          <div class="sr-person-initials">{{ $consultant->initials }}</div>
          @endif
          <div class="sr-person-name">{{ $consultant->name }}</div>
          <div class="sr-person-sub">{{ $consultant->title ?? ($consultant->district ?? 'Rwanda') }}</div>
          <span class="sr-person-badge">
            {{ $consultant->is_verified ? '✓ Verified' : 'Consultant' }}
          </span>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           PROFESSIONALS
      ════════════════════════ --}}
    @if($results['professionals']->isNotEmpty() && in_array($type, ['all', 'agents']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
          </svg>
          Professionals
          <span class="sr-section-badge">{{ $results['professionals']->count() }}</span>
        </div>
        <a href="{{ route('front.professionals.index') }}" class="sr-view-all">
          All professionals <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-people-grid">
        @foreach($results['professionals'] as $pro)
        <a href="{{ route('front.professional.details', $pro->id) }}" class="sr-person-card">
          @if($pro->photo ?? null)
          <img src="{{ asset('storage/' . $pro->photo) }}"
            alt="{{ $pro->name }}" class="sr-person-avatar">
          @else
          @php
          $pparts = explode(' ', $pro->name ?? 'P');
          $pinitials = strtoupper(substr($pparts[0], 0, 1) . (isset($pparts[1]) ? substr($pparts[1], 0, 1) : ''));
          @endphp
          <div class="sr-person-initials">{{ $pinitials }}</div>
          @endif
          <div class="sr-person-name">{{ $pro->name ?? 'Professional' }}</div>
          <div class="sr-person-sub">{{ $pro->profession ?? 'Professional' }}</div>
          <span class="sr-person-badge">Professional</span>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           NEWS (Blog)
      ════════════════════════ --}}
    @if($results['news']->isNotEmpty() && in_array($type, ['all', 'news']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
          </svg>
          News
          <span class="sr-section-badge">{{ $results['news']->count() }}</span>
        </div>
        <a href="{{ route('front.news.index') }}" class="sr-view-all">
          All news <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-list">
        @foreach($results['news'] as $article)
        <a href="{{ route('front.news.details', $article->slug ?? $article->id) }}"
          class="sr-list-item">
          @if($article->featured_image)
          <img src="{{ asset('storage/' . $article->featured_image) }}"
            alt="{{ $article->title }}" class="sr-list-thumb">
          @else
          <div class="sr-list-icon">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
            </svg>
          </div>
          @endif
          <div class="sr-list-body">
            <div class="sr-list-kicker">News{{ $article->category ? ' · ' . $article->category->name : '' }}</div>
            <div class="sr-list-title">{{ $article->title }}</div>
            <div class="sr-list-meta">
              <span class="sr-list-date">{{ optional($article->published_at)->format('M d, Y') }}</span>
              @if($article->author)
              <span class="sr-list-tag">{{ $article->author->name }}</span>
              @endif
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           ANNOUNCEMENTS
      ════════════════════════ --}}
    @if($results['announcements']->isNotEmpty() && in_array($type, ['all', 'news']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z" />
          </svg>
          Announcements
          <span class="sr-section-badge">{{ $results['announcements']->count() }}</span>
        </div>
        <a href="{{ route('front.announcements.index') }}" class="sr-view-all">
          All announcements <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-list">
        @foreach($results['announcements'] as $ann)
        <a href="{{ route('front.announcements.show', $ann->slug ?? $ann->id) }}"
          class="sr-list-item">
          <div class="sr-list-icon">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z" />
            </svg>
          </div>
          <div class="sr-list-body">
            <div class="sr-list-kicker">Announcement</div>
            <div class="sr-list-title">{{ $ann->title }}</div>
            @if($ann->content)
            <div class="sr-list-excerpt">{{ Str::limit(strip_tags($ann->content), 100) }}</div>
            @endif
            <div class="sr-list-meta">
              <span class="sr-list-date">{{ $ann->created_at->format('M d, Y') }}</span>
              @if($ann->start_date)
              <span class="sr-list-tag">From {{ $ann->start_date->format('M d') }}</span>
              @endif
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           JOBS
      ════════════════════════ --}}
    @if($results['jobs']->isNotEmpty() && in_array($type, ['all', 'jobs']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 6h-2.18c.07-.44.18-.86.18-1.3C18 2.56 15.44 1 12.76 1c-1.56 0-3.04.59-4.14 1.67L7 4H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z" />
          </svg>
          Jobs
          <span class="sr-section-badge">{{ $results['jobs']->count() }}</span>
        </div>
        <a href="{{ route('front.jobs.index') }}" class="sr-view-all">
          All jobs <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-list">
        @foreach($results['jobs'] as $job)
        <a href="{{ route('front.jobs.show', $job->slug ?? $job->id) }}"
          class="sr-list-item">
          @if($job->company_logo)
          <img src="{{ asset('storage/' . $job->company_logo) }}"
            alt="{{ $job->company_name }}" class="sr-list-thumb"
            style="object-fit:contain;background:#f7f6f3;padding:6px;">
          @else
          <div class="sr-list-icon">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 6h-2.18c.07-.44.18-.86.18-1.3C18 2.56 15.44 1 12.76 1c-1.56 0-3.04.59-4.14 1.67L7 4H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z" />
            </svg>
          </div>
          @endif
          <div class="sr-list-body">
            <div class="sr-list-kicker">{{ $job->company_name ?? 'Job' }}</div>
            <div class="sr-list-title">{{ $job->title }}</div>
            <div class="sr-list-excerpt">{{ $job->location }}{{ $job->job_type ? ' · ' . $job->job_type_label : '' }}</div>
            <div class="sr-list-meta">
              <span class="sr-list-date">
                Deadline: {{ $job->application_deadline ? $job->application_deadline->format('M d, Y') : 'Open' }}
              </span>
              <span class="sr-list-tag">{{ $job->salary_range }}</span>
              @if($job->category)
              <span class="sr-list-tag">{{ $job->category }}</span>
              @endif
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           TENDERS
      ════════════════════════ --}}
    @if($results['tenders']->isNotEmpty() && in_array($type, ['all', 'tenders']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
          </svg>
          Tenders
          <span class="sr-section-badge">{{ $results['tenders']->count() }}</span>
        </div>
        <a href="{{ route('front.tenders.index') }}" class="sr-view-all">
          All tenders <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-list">
        @foreach($results['tenders'] as $tender)
        <a href="{{ route('front.tenders.show', $tender->slug ?? $tender->id) }}"
          class="sr-list-item">
          <div class="sr-list-icon">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
            </svg>
          </div>
          <div class="sr-list-body">
            <div class="sr-list-kicker">Tender</div>
            <div class="sr-list-title">{{ $tender->title }}</div>
            @if($tender->description)
            <div class="sr-list-excerpt">{{ Str::limit(strip_tags($tender->description), 100) }}</div>
            @endif
            <div class="sr-list-meta">
              <span class="sr-list-date">{{ $tender->created_at->format('M d, Y') }}</span>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ════════════════════════
           ADVERTISEMENTS
      ════════════════════════ --}}
    @if($results['advertisements']->isNotEmpty() && in_array($type, ['all', 'advertisements']))
    <div class="sr-section">
      <div class="sr-section-head">
        <div class="sr-section-title">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 3h18v18H3V3zm2 2v14h14V5H5z" />
          </svg>
          Advertisements
          <span class="sr-section-badge">{{ $results['advertisements']->count() }}</span>
        </div>
        <a href="{{ route('advertisements.index') }}" class="sr-view-all">
          All ads <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M5 12h14M12 5l7 7-7 7" />
          </svg>
        </a>
      </div>
      <div class="sr-list">
        @foreach($results['advertisements'] as $ad)
        @php
        $adImages = is_array($ad->images) ? $ad->images : [];
        $adThumb = $adImages[0] ?? null;
        @endphp
        <a href="{{ $ad->advertisable_url ?? route('advertisements.index') }}"
          class="sr-list-item">
          @if($adThumb)
          <img src="{{ asset('storage/' . $adThumb) }}"
            alt="{{ $ad->title }}" class="sr-list-thumb">
          @else
          <div class="sr-list-icon">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 3h18v18H3V3zm2 2v14h14V5H5z" />
            </svg>
          </div>
          @endif
          <div class="sr-list-body">
            <div class="sr-list-kicker">
              Advertisement{{ $ad->advertisable_type_label ? ' · ' . $ad->advertisable_type_label : '' }}
            </div>
            <div class="sr-list-title">{{ $ad->title }}</div>
            @if($ad->description)
            <div class="sr-list-excerpt">{{ Str::limit($ad->description, 100) }}</div>
            @endif
            <div class="sr-list-meta">
              @if($ad->location)
              <span class="sr-list-tag">{{ $ad->location }}</span>
              @endif
              @if($ad->price_amount)
              <span class="sr-list-tag">{{ number_format($ad->price_amount) }} {{ $ad->currency }}</span>
              @endif
              @if($ad->expires_at)
              <span class="sr-list-date">Expires {{ $ad->expires_at->format('M d, Y') }}</span>
              @endif
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

    @endif {{-- end total > 0 --}}

  </div>
</div>

@endsection