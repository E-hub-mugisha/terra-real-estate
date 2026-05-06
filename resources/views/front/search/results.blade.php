@extends('layouts.front')

@section('title', $q ? "Search results for \"{$q}\" — Terra" : 'Search — Terra')

@section('content')

<style>
  /* ══════════════════════════════════════
     SEARCH RESULTS PAGE
  ══════════════════════════════════════ */
  .sr-page {
    min-height: 70vh;
    padding: 48px 0 80px;
    font-family: 'DM Sans', sans-serif;
  }

  .sr-hero {
    background: linear-gradient(135deg, #19265d 0%, #0f1a45 100%);
    padding: 40px 0 0;
    margin-bottom: 0;
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
    font-size: .78rem;
    color: rgba(255,255,255,.4);
    margin-bottom: 20px;
  }

  .sr-breadcrumb a {
    color: rgba(255,255,255,.5);
    text-decoration: none;
    transition: color .2s;
  }

  .sr-breadcrumb a:hover { color: #fff; }

  .sr-breadcrumb svg {
    width: 12px;
    height: 12px;
  }

  .sr-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
    line-height: 1.3;
  }

  .sr-title span {
    color: #C8873A;
  }

  .sr-meta {
    font-size: .84rem;
    color: rgba(255,255,255,.45);
    margin-bottom: 24px;
  }

  /* ── Search bar (in hero) ── */
  .sr-search-bar {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    max-width: 680px;
    box-shadow: 0 8px 32px rgba(0,0,0,.25);
  }

  .sr-search-bar form {
    display: flex;
    align-items: center;
    width: 100%;
  }

  .sr-search-icon {
    width: 48px;
    height: 52px;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    color: #C8873A;
  }

  .sr-search-icon svg { width: 18px; height: 18px; }

  .sr-search-bar input {
    flex: 1;
    border: none;
    outline: none;
    font-size: .95rem;
    font-family: 'DM Sans', sans-serif;
    color: #19265d;
    padding: 0 8px 0 0;
    height: 52px;
    background: transparent;
  }

  .sr-search-bar input::placeholder { color: #aaa; }

  .sr-search-bar button {
    height: 52px;
    padding: 0 28px;
    background: #D05208;
    border: none;
    color: #fff;
    font-size: .88rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background .2s;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .sr-search-bar button:hover { background: #19265d; }

  /* ── Filter tabs ── */
  .sr-tabs-wrap {
    background: #19265d;
    border-top: 1px solid rgba(255,255,255,.07);
  }

  .sr-tabs {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    gap: 0;
    overflow-x: auto;
    scrollbar-width: none;
  }

  .sr-tabs::-webkit-scrollbar { display: none; }

  .sr-tab {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 14px 18px;
    font-size: .82rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    color: rgba(255,255,255,.45);
    text-decoration: none;
    border-bottom: 2px solid transparent;
    white-space: nowrap;
    transition: color .2s, border-color .2s;
  }

  .sr-tab:hover {
    color: rgba(255,255,255,.75);
  }

  .sr-tab.active {
    color: #fff;
    border-bottom-color: #C8873A;
  }

  .sr-tab-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 6px;
    border-radius: 10px;
    background: rgba(200,135,58,.25);
    color: #C8873A;
    font-size: .7rem;
    font-weight: 700;
  }

  .sr-tab.active .sr-tab-count {
    background: #C8873A;
    color: #fff;
  }

  /* ── Main layout ── */
  .sr-body {
    max-width: 1240px;
    margin: 0 auto;
    padding: 40px 24px;
  }

  /* ── Section header ── */
  .sr-section {
    margin-bottom: 48px;
  }

  .sr-section-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid rgba(0,0,0,.07);
  }

  .sr-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1rem;
    font-weight: 700;
    color: #19265d;
  }

  .sr-section-title svg {
    width: 18px;
    height: 18px;
    color: #C8873A;
  }

  .sr-section-count {
    font-size: .75rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    background: rgba(200,135,58,.1);
    color: #C8873A;
  }

  .sr-view-all {
    font-size: .8rem;
    font-weight: 600;
    color: #D05208;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: gap .2s;
  }

  .sr-view-all:hover { gap: 8px; }

  .sr-view-all svg { width: 13px; height: 13px; }

  /* ── Property grid ── */
  .sr-prop-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
  }

  .sr-prop-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,.07);
    border-radius: 14px;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .sr-prop-card:hover {
    box-shadow: 0 12px 32px rgba(25,38,93,.12);
    transform: translateY(-3px);
  }

  .sr-prop-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
    background: #f0ede8;
  }

  .sr-prop-img-placeholder {
    width: 100%;
    height: 180px;
    background: linear-gradient(135deg, #e8e4df, #d5d0c8);
    display: grid;
    place-items: center;
  }

  .sr-prop-img-placeholder svg {
    width: 36px;
    height: 36px;
    color: #aaa;
  }

  .sr-prop-body {
    padding: 14px 16px 16px;
  }

  .sr-prop-type {
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #C8873A;
    margin-bottom: 5px;
  }

  .sr-prop-title {
    font-size: .9rem;
    font-weight: 600;
    color: #19265d;
    margin-bottom: 5px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .sr-prop-loc {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: .75rem;
    color: #888;
    margin-bottom: 10px;
  }

  .sr-prop-loc svg { width: 12px; height: 12px; flex-shrink: 0; }

  .sr-prop-price {
    font-size: .95rem;
    font-weight: 700;
    color: #D05208;
  }

  /* ── People grid (agents / consultants / professionals) ── */
  .sr-people-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
  }

  .sr-person-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,.07);
    border-radius: 14px;
    padding: 20px 16px;
    text-align: center;
    text-decoration: none;
    color: inherit;
    transition: box-shadow .2s, transform .2s;
    display: block;
  }

  .sr-person-card:hover {
    box-shadow: 0 8px 24px rgba(25,38,93,.1);
    transform: translateY(-2px);
  }

  .sr-person-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 10px;
    display: block;
    background: #e8e4df;
  }

  .sr-person-initials {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #19265d, #2d3f8e);
    color: #fff;
    font-size: 1.1rem;
    font-weight: 700;
    display: grid;
    place-items: center;
    margin: 0 auto 10px;
  }

  .sr-person-name {
    font-size: .88rem;
    font-weight: 700;
    color: #19265d;
    margin-bottom: 3px;
  }

  .sr-person-role {
    font-size: .73rem;
    color: #888;
    margin-bottom: 8px;
  }

  .sr-person-badge {
    display: inline-block;
    font-size: .67rem;
    font-weight: 700;
    padding: 2px 9px;
    border-radius: 20px;
    background: rgba(200,135,58,.12);
    color: #C8873A;
  }

  /* ── News / Tenders / Jobs list ── */
  .sr-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
  }

  .sr-list-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: #fff;
    border: 1px solid rgba(0,0,0,.07);
    border-radius: 12px;
    padding: 16px;
    text-decoration: none;
    color: inherit;
    transition: box-shadow .2s, border-color .2s;
  }

  .sr-list-item:hover {
    box-shadow: 0 6px 20px rgba(25,38,93,.08);
    border-color: rgba(25,38,93,.15);
  }

  .sr-list-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: rgba(200,135,58,.1);
    display: grid;
    place-items: center;
    flex-shrink: 0;
  }

  .sr-list-icon svg {
    width: 18px;
    height: 18px;
    color: #C8873A;
  }

  .sr-list-thumb {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
    background: #e8e4df;
  }

  .sr-list-body { flex: 1; min-width: 0; }

  .sr-list-label {
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #C8873A;
    margin-bottom: 3px;
  }

  .sr-list-title {
    font-size: .9rem;
    font-weight: 600;
    color: #19265d;
    margin-bottom: 4px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .sr-list-excerpt {
    font-size: .78rem;
    color: #888;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .sr-list-date {
    font-size: .72rem;
    color: #bbb;
    margin-top: 5px;
  }

  /* ── Empty state ── */
  .sr-empty {
    text-align: center;
    padding: 80px 24px;
  }

  .sr-empty-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: rgba(200,135,58,.08);
    display: grid;
    place-items: center;
    margin: 0 auto 20px;
  }

  .sr-empty-icon svg {
    width: 32px;
    height: 32px;
    color: #C8873A;
  }

  .sr-empty h3 {
    font-size: 1.15rem;
    font-weight: 700;
    color: #19265d;
    margin-bottom: 8px;
  }

  .sr-empty p {
    font-size: .88rem;
    color: #888;
    max-width: 380px;
    margin: 0 auto 24px;
    line-height: 1.6;
  }

  .sr-empty-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
  }

  .sr-empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 20px;
    border-radius: 9px;
    font-size: .84rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    transition: all .2s;
  }

  .sr-empty-btn-primary {
    background: #19265d;
    color: #fff;
  }

  .sr-empty-btn-primary:hover {
    background: #D05208;
    color: #fff;
  }

  .sr-empty-btn-outline {
    background: transparent;
    color: #19265d;
    border: 1.5px solid rgba(25,38,93,.2);
  }

  .sr-empty-btn-outline:hover {
    border-color: #D05208;
    color: #D05208;
  }

  /* ── No query state ── */
  .sr-no-query {
    text-align: center;
    padding: 80px 24px;
  }

  /* Highlight matched text */
  mark {
    background: rgba(200,135,58,.2);
    color: #a05c1a;
    border-radius: 3px;
    padding: 0 2px;
  }

  @media (max-width: 640px) {
    .sr-title { font-size: 1.2rem; }
    .sr-prop-grid { grid-template-columns: 1fr 1fr; }
    .sr-people-grid { grid-template-columns: 1fr 1fr; }
    .sr-search-bar button { padding: 0 16px; font-size: .8rem; }
  }

  @media (max-width: 400px) {
    .sr-prop-grid { grid-template-columns: 1fr; }
    .sr-people-grid { grid-template-columns: 1fr; }
  }
</style>

{{-- ── HERO ── --}}
<div class="sr-hero">
  <div class="sr-hero-inner">

    <div class="sr-breadcrumb">
      <a href="{{ route('front.home') }}">Home</a>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 18l6-6-6-6"/>
      </svg>
      <span>Search</span>
      @if($q)
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 18l6-6-6-6"/>
        </svg>
        <span>{{ Str::limit($q, 40) }}</span>
      @endif
    </div>

    @if($q)
      <h1 class="sr-title">
        Results for <span>"{{ $q }}"</span>
      </h1>
      <p class="sr-meta">
        {{ $total }} result{{ $total !== 1 ? 's' : '' }} found
        @if($type !== 'all') · filtered by {{ ucfirst($type) }} @endif
      </p>
    @else
      <h1 class="sr-title">Search Terra</h1>
      <p class="sr-meta">Find properties, agents, news, jobs and more</p>
    @endif

    <div class="sr-search-bar">
      <form action="{{ route('front.search') }}" method="GET" style="display:flex;align-items:center;width:100%">
        <input type="hidden" name="type" value="{{ $type }}">
        <span class="sr-search-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
        </span>
        <input type="text" name="q" value="{{ $q }}"
               placeholder="Search properties, agents, news, jobs…"
               autofocus autocomplete="off">
        <button type="submit">Search</button>
      </form>
    </div>

  </div>

  {{-- Filter tabs --}}
  @if($q)
  <div class="sr-tabs-wrap">
    <div class="sr-tabs">

      @php
        $tabs = [
          'all'        => ['label' => 'All',            'count' => $total],
          'properties' => ['label' => 'Properties',     'count' => $results['properties']->count()],
          'agents'     => ['label' => 'Agents & Pros',  'count' => $results['agents']->count() + $results['consultants']->count() + $results['professionals']->count()],
          'news'       => ['label' => 'News',           'count' => $results['news']->count()],
          'jobs'       => ['label' => 'Jobs',           'count' => $results['jobs']->count()],
          'tenders'    => ['label' => 'Tenders',        'count' => $results['tenders']->count()],
        ];
      @endphp

      @foreach($tabs as $key => $tab)
        @if($tab['count'] > 0 || $key === 'all')
          <a href="{{ route('front.search', ['q' => $q, 'type' => $key]) }}"
             class="sr-tab {{ $type === $key ? 'active' : '' }}">
            {{ $tab['label'] }}
            @if($tab['count'] > 0)
              <span class="sr-tab-count">{{ $tab['count'] }}</span>
            @endif
          </a>
        @endif
      @endforeach

    </div>
  </div>
  @endif
</div>

{{-- ── RESULTS BODY ── --}}
<div class="sr-page">
  <div class="sr-body">

    @if(!$q)
      {{-- No query entered --}}
      <div class="sr-no-query">
        <div class="sr-empty-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
        </div>
        <h3>What are you looking for?</h3>
        <p>Search for properties to buy or rent, verified agents, consultants, news, jobs, or tenders across Rwanda.</p>
        <div class="sr-empty-actions">
          <a href="{{ route('front.buy.homes') }}" class="sr-empty-btn sr-empty-btn-primary">
            <svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px">
              <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
            </svg>
            Browse Properties
          </a>
          <a href="{{ route('front.agents') }}" class="sr-empty-btn sr-empty-btn-outline">Find Agents</a>
          <a href="{{ route('front.jobs.index') }}" class="sr-empty-btn sr-empty-btn-outline">View Jobs</a>
        </div>
      </div>

    @elseif($total === 0)
      {{-- No results --}}
      <div class="sr-empty">
        <div class="sr-empty-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
        </div>
        <h3>No results for "{{ $q }}"</h3>
        <p>Try different keywords, check your spelling, or browse our categories below.</p>
        <div class="sr-empty-actions">
          <a href="{{ route('front.buy.homes') }}" class="sr-empty-btn sr-empty-btn-primary">Browse Properties</a>
          <a href="{{ route('front.agents') }}" class="sr-empty-btn sr-empty-btn-outline">Find Agents</a>
          <a href="{{ route('front.contact') }}" class="sr-empty-btn sr-empty-btn-outline">Get Help</a>
        </div>
      </div>

    @else

      {{-- ═══════════════════════════════
           PROPERTIES
      ═══════════════════════════════ --}}
      @if($results['properties']->isNotEmpty() && in_array($type, ['all', 'properties']))
        <div class="sr-section">
          <div class="sr-section-head">
            <div class="sr-section-title">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
              </svg>
              Properties
              <span class="sr-section-count">{{ $results['properties']->count() }}</span>
            </div>
            @if($type === 'all')
              <a href="{{ route('front.search', ['q' => $q, 'type' => 'properties']) }}" class="sr-view-all">
                View all
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </a>
            @endif
          </div>

          <div class="sr-prop-grid">
            @foreach($results['properties'] as $property)
              <a href="{{ route('front.property.show', $property->slug ?? $property->id) }}"
                 class="sr-prop-card">
                @if($property->images && $property->images->first())
                  <img src="{{ asset('storage/' . $property->images->first()->path) }}"
                       alt="{{ $property->title }}"
                       class="sr-prop-img">
                @else
                  <div class="sr-prop-img-placeholder">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                      <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                  </div>
                @endif
                <div class="sr-prop-body">
                  <div class="sr-prop-type">
                    {{ ucfirst($property->listing_type ?? 'Property') }}
                    · {{ ucfirst($property->property_type ?? '') }}
                  </div>
                  <div class="sr-prop-title">{{ $property->title }}</div>
                  @if($property->location || $property->district)
                    <div class="sr-prop-loc">
                      <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                      </svg>
                      {{ $property->location ?? $property->district }}
                    </div>
                  @endif
                  @if($property->price)
                    <div class="sr-prop-price">
                      RWF {{ number_format($property->price) }}
                    </div>
                  @endif
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

      {{-- ═══════════════════════════════
           AGENTS
      ═══════════════════════════════ --}}
      @if($results['agents']->isNotEmpty() && in_array($type, ['all', 'agents']))
        <div class="sr-section">
          <div class="sr-section-head">
            <div class="sr-section-title">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
              </svg>
              Agents
              <span class="sr-section-count">{{ $results['agents']->count() }}</span>
            </div>
            @if($type === 'all')
              <a href="{{ route('front.search', ['q' => $q, 'type' => 'agents']) }}" class="sr-view-all">
                View all
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </a>
            @endif
          </div>
          <div class="sr-people-grid">
            @foreach($results['agents'] as $agent)
              <a href="{{ route('front.agents.show', $agent->slug ?? $agent->id) }}"
                 class="sr-person-card">
                @if($agent->photo)
                  <img src="{{ asset('storage/' . $agent->photo) }}"
                       alt="{{ $agent->name }}"
                       class="sr-person-avatar">
                @else
                  <div class="sr-person-initials">
                    {{ strtoupper(substr($agent->name, 0, 1)) }}{{ strtoupper(substr(strstr($agent->name, ' '), 1, 1)) }}
                  </div>
                @endif
                <div class="sr-person-name">{{ $agent->name }}</div>
                <div class="sr-person-role">{{ $agent->location ?? 'Rwanda' }}</div>
                <span class="sr-person-badge">Agent</span>
              </a>
            @endforeach
          </div>
        </div>
      @endif

      {{-- ═══════════════════════════════
           CONSULTANTS
      ═══════════════════════════════ --}}
      @if($results['consultants']->isNotEmpty() && in_array($type, ['all', 'agents']))
        <div class="sr-section">
          <div class="sr-section-head">
            <div class="sr-section-title">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
              </svg>
              Consultants
              <span class="sr-section-count">{{ $results['consultants']->count() }}</span>
            </div>
          </div>
          <div class="sr-people-grid">
            @foreach($results['consultants'] as $consultant)
              <a href="{{ route('front.consultants.show', $consultant->slug ?? $consultant->id) }}"
                 class="sr-person-card">
                @if($consultant->photo)
                  <img src="{{ asset('storage/' . $consultant->photo) }}"
                       alt="{{ $consultant->name }}"
                       class="sr-person-avatar">
                @else
                  <div class="sr-person-initials">
                    {{ strtoupper(substr($consultant->name, 0, 1)) }}{{ strtoupper(substr(strstr($consultant->name, ' '), 1, 1)) }}
                  </div>
                @endif
                <div class="sr-person-name">{{ $consultant->name }}</div>
                <div class="sr-person-role">{{ $consultant->expertise ?? 'Consultant' }}</div>
                <span class="sr-person-badge">Consultant</span>
              </a>
            @endforeach
          </div>
        </div>
      @endif

      {{-- ═══════════════════════════════
           PROFESSIONALS
      ═══════════════════════════════ --}}
      @if($results['professionals']->isNotEmpty() && in_array($type, ['all', 'agents']))
        <div class="sr-section">
          <div class="sr-section-head">
            <div class="sr-section-title">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
              </svg>
              Professionals
              <span class="sr-section-count">{{ $results['professionals']->count() }}</span>
            </div>
          </div>
          <div class="sr-people-grid">
            @foreach($results['professionals'] as $pro)
              <a href="{{ route('front.professionals.show', $pro->slug ?? $pro->id) }}"
                 class="sr-person-card">
                @if($pro->photo)
                  <img src="{{ asset('storage/' . $pro->photo) }}"
                       alt="{{ $pro->name }}"
                       class="sr-person-avatar">
                @else
                  <div class="sr-person-initials">
                    {{ strtoupper(substr($pro->name, 0, 1)) }}{{ strtoupper(substr(strstr($pro->name, ' '), 1, 1)) }}
                  </div>
                @endif
                <div class="sr-person-name">{{ $pro->name }}</div>
                <div class="sr-person-role">{{ $pro->profession ?? 'Professional' }}</div>
                <span class="sr-person-badge">Professional</span>
              </a>
            @endforeach
          </div>
        </div>
      @endif

      {{-- ═══════════════════════════════
           NEWS
      ═══════════════════════════════ --}}
      @if($results['news']->isNotEmpty() && in_array($type, ['all', 'news']))
        <div class="sr-section">
          <div class="sr-section-head">
            <div class="sr-section-title">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z"/>
              </svg>
              News
              <span class="sr-section-count">{{ $results['news']->count() }}</span>
            </div>
            @if($type === 'all')
              <a href="{{ route('front.search', ['q' => $q, 'type' => 'news']) }}" class="sr-view-all">
                View all
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </a>
            @endif
          </div>
          <div class="sr-list">
            @foreach($results['news'] as $article)
              <a href="{{ route('front.news.show', $article->slug ?? $article->id) }}"
                 class="sr-list-item">
                @if($article->thumbnail)
                  <img src="{{ asset('storage/' . $article->thumbnail) }}"
                       alt="{{ $article->title }}"
                       class="sr-list-thumb">
                @else
                  <div class="sr-list-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                      <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z"/>
                    </svg>
                  </div>
                @endif
                <div class="sr-list-body">
                  <div class="sr-list-label">News</div>
                  <div class="sr-list-title">{{ $article->title }}</div>
                  @if($article->excerpt)
                    <div class="sr-list-excerpt">{{ $article->excerpt }}</div>
                  @endif
                  <div class="sr-list-date">
                    {{ optional($article->published_at)->format('M d, Y') }}
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

      {{-- ═══════════════════════════════
           JOBS
      ═══════════════════════════════ --}}
      @if($results['jobs']->isNotEmpty() && in_array($type, ['all', 'jobs']))
        <div class="sr-section">
          <div class="sr-section-head">
            <div class="sr-section-title">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 6h-2.18c.07-.44.18-.86.18-1.3C18 2.56 15.44 1 12.76 1c-1.56 0-3.04.59-4.14 1.67L7 4H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z"/>
              </svg>
              Jobs
              <span class="sr-section-count">{{ $results['jobs']->count() }}</span>
            </div>
            @if($type === 'all')
              <a href="{{ route('front.search', ['q' => $q, 'type' => 'jobs']) }}" class="sr-view-all">
                View all
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </a>
            @endif
          </div>
          <div class="sr-list">
            @foreach($results['jobs'] as $job)
              <a href="{{ route('front.jobs.show', $job->slug ?? $job->id) }}"
                 class="sr-list-item">
                <div class="sr-list-icon">
                  <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 6h-2.18c.07-.44.18-.86.18-1.3C18 2.56 15.44 1 12.76 1c-1.56 0-3.04.59-4.14 1.67L7 4H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z"/>
                  </svg>
                </div>
                <div class="sr-list-body">
                  <div class="sr-list-label">{{ $job->company ?? 'Job' }}</div>
                  <div class="sr-list-title">{{ $job->title }}</div>
                  @if($job->location)
                    <div class="sr-list-excerpt">{{ $job->location }}</div>
                  @endif
                  <div class="sr-list-date">
                    Deadline: {{ optional($job->deadline)->format('M d, Y') ?? 'Open' }}
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

      {{-- ═══════════════════════════════
           TENDERS
      ═══════════════════════════════ --}}
      @if($results['tenders']->isNotEmpty() && in_array($type, ['all', 'tenders']))
        <div class="sr-section">
          <div class="sr-section-head">
            <div class="sr-section-title">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
              </svg>
              Tenders
              <span class="sr-section-count">{{ $results['tenders']->count() }}</span>
            </div>
            @if($type === 'all')
              <a href="{{ route('front.search', ['q' => $q, 'type' => 'tenders']) }}" class="sr-view-all">
                View all
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
              </a>
            @endif
          </div>
          <div class="sr-list">
            @foreach($results['tenders'] as $tender)
              <a href="{{ route('front.tenders.show', $tender->slug ?? $tender->id) }}"
                 class="sr-list-item">
                <div class="sr-list-icon">
                  <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                  </svg>
                </div>
                <div class="sr-list-body">
                  <div class="sr-list-label">{{ $tender->organization ?? 'Tender' }}</div>
                  <div class="sr-list-title">{{ $tender->title }}</div>
                  @if($tender->description)
                    <div class="sr-list-excerpt">{{ Str::limit($tender->description, 100) }}</div>
                  @endif
                  <div class="sr-list-date">
                    Closes: {{ optional($tender->deadline)->format('M d, Y') ?? 'Open' }}
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

    @endif {{-- end $total > 0 --}}

  </div>
</div>

@endsection