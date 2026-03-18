@extends('layouts.guest')
@section('title', 'News & Updates')
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
    --r:        12px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ══ HERO ══ */
.nb-hero {
    background: var(--dark);
    position: relative; overflow: hidden;
    padding: 64px 0 56px;
}
.nb-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 55% 60% at 0% 50%, rgba(200,135,58,.12) 0%, transparent 65%),
        radial-gradient(ellipse 35% 50% at 100% 25%, rgba(200,135,58,.06) 0%, transparent 55%);
    pointer-events: none;
}
.nb-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.016) 39px, rgba(255,255,255,.016) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255,255,255,.01) 79px, rgba(255,255,255,.01) 80px);
    pointer-events: none;
}
.nb-hero .container { position: relative; z-index: 2; }
.nb-hero-inner { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; flex-wrap: wrap; }

.nb-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold-lt); margin-bottom: 10px;
}
.nb-eyebrow::before { content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .6; }
.nb-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.9rem, 4.5vw, 3.2rem);
    font-weight: 500; line-height: 1.1;
    letter-spacing: -.025em; color: #F0EDE8;
}
.nb-hero h1 em { font-style: italic; color: var(--gold-lt); }
.nb-hero p { font-size: .84rem; color: rgba(240,237,232,.38); margin-top: 8px; max-width: 400px; line-height: 1.7; }

.nb-hero-meta {
    display: flex; align-items: center; gap: 6px; flex-shrink: 0;
    font-size: .78rem; color: rgba(240,237,232,.35);
}
.nb-hero-meta strong { color: rgba(240,237,232,.65); font-weight: 600; font-size: .9rem; }

/* ══ FILTER BAR ══ */
.nb-filter {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 11px 0;
    position: sticky; top: 0; z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
}
.nb-filter-inner { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

.nb-search { position: relative; flex: 1; min-width: 160px; max-width: 260px; }
.nb-search svg {
    position: absolute; left: 10px; top: 50%;
    transform: translateY(-50%); width: 13px; height: 13px;
    color: var(--dim); pointer-events: none;
}
.nb-search input {
    width: 100%; padding: 8px 11px 8px 28px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .81rem; font-family: 'DM Sans', sans-serif;
    background: var(--bg); color: var(--text); transition: border-color var(--t);
}
.nb-search input:focus { outline: none; border-color: var(--gold); background: var(--surface); }
.nb-search input::placeholder { color: var(--dim); }

.nb-select {
    padding: 6px 24px 6px 10px;
    border: 1.5px solid var(--border); border-radius: 8px;
    font-size: .78rem; font-family: 'DM Sans', sans-serif; color: var(--text);
    background: var(--bg) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%239E9890' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") right 7px center no-repeat;
    appearance: none; cursor: pointer; transition: border-color var(--t);
}
.nb-select:focus { outline: none; border-color: var(--gold); }

.nb-meta { display: flex; align-items: center; gap: 8px; margin-left: auto; }
.nb-count { font-size: .77rem; color: var(--dim); white-space: nowrap; }
.nb-count strong { color: var(--text); }

/* ══ FEATURED CARD (first post) ══ */
.nb-featured {
    padding: 28px 0 0;
}
.nb-feat-card {
    display: grid; grid-template-columns: 1fr 1fr;
    border-radius: 16px; overflow: hidden;
    background: var(--surface); border: 1px solid var(--border);
    transition: box-shadow var(--t);
    text-decoration: none; color: var(--text);
}
.nb-feat-card:hover { box-shadow: 0 14px 40px rgba(0,0,0,.1); color: var(--text); }
@media (max-width: 700px) { .nb-feat-card { grid-template-columns: 1fr; } }

.nb-feat-img {
    position: relative; overflow: hidden; min-height: 300px;
    background: var(--bg);
}
.nb-feat-img img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .55s ease; }
.nb-feat-card:hover .nb-feat-img img { transform: scale(1.04); }
.nb-feat-img::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(14,14,12,.3) 0%, transparent 60%);
    pointer-events: none;
}
.nb-feat-label {
    position: absolute; top: 14px; left: 14px; z-index: 2;
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 6px;
    background: var(--gold); color: #fff;
    font-size: .64rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
}
.nb-feat-label svg { width: 10px; height: 10px; }

.nb-feat-content {
    padding: 32px 28px; display: flex; flex-direction: column; justify-content: center; gap: 12px;
}
.nb-feat-cat {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .7rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: var(--gold);
}
.nb-feat-cat::before { content: ''; width: 14px; height: 1px; background: var(--gold); opacity: .5; }
.nb-feat-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.3rem, 2.5vw, 1.9rem);
    font-weight: 500; line-height: 1.2;
    letter-spacing: -.015em; color: var(--text);
}
.nb-feat-excerpt {
    font-size: .84rem; color: var(--muted); line-height: 1.78;
    display: -webkit-box; -webkit-line-clamp: 3;
    -webkit-box-orient: vertical; overflow: hidden;
}
.nb-feat-meta {
    display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-top: 4px;
}
.nb-feat-meta-item {
    display: flex; align-items: center; gap: 5px;
    font-size: .74rem; color: var(--dim);
}
.nb-feat-meta-item svg { width: 12px; height: 12px; color: var(--gold); }
.nb-feat-readmore {
    display: inline-flex; align-items: center; gap: 5px; margin-top: 8px;
    font-size: .82rem; font-weight: 600; color: var(--gold);
    border-bottom: 1px solid var(--gold-bd); padding-bottom: 1px;
    transition: gap var(--t), border-color var(--t); align-self: flex-start;
}
.nb-feat-card:hover .nb-feat-readmore { gap: 9px; border-color: var(--gold); }
.nb-feat-readmore svg { width: 13px; height: 13px; }

/* ══ GRID SECTION ══ */
.nb-main { padding: 24px 0 72px; }

.nb-section-head {
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    margin-bottom: 20px; flex-wrap: wrap;
}
.nb-section-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold);
}
.nb-section-eyebrow::before { content: ''; width: 14px; height: 1px; background: var(--gold); opacity: .5; }
.nb-section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem; font-weight: 500; color: var(--text);
    letter-spacing: -.01em;
}
.nb-section-title em { font-style: italic; color: var(--gold); }

/* ══ BLOG CARD ══ */
.nb-card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden;
    height: 100%; display: flex; flex-direction: column;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
    animation: nbFu .4s ease both; color: var(--text);
}
.nb-card:hover {
    transform: translateY(-4px);
    border-color: var(--gold-bd);
    box-shadow: 0 10px 28px rgba(0,0,0,.09);
    color: var(--text);
}
@keyframes nbFu { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }

.nb-card-img {
    position: relative; aspect-ratio: 16/10;
    overflow: hidden; background: var(--bg); flex-shrink: 0;
}
.nb-card-img img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .5s ease;
}
.nb-card:hover .nb-card-img img { transform: scale(1.06); }

/* Read time badge */
.nb-read-time {
    position: absolute; top: 9px; right: 9px; z-index: 2;
    padding: 2px 8px; border-radius: 5px;
    background: rgba(14,14,12,.7); backdrop-filter: blur(5px);
    border: 1px solid rgba(255,255,255,.12);
    font-size: .62rem; color: rgba(240,237,232,.75); font-weight: 500;
}

/* Category chip */
.nb-card-cat {
    position: absolute; bottom: 9px; left: 9px; z-index: 2;
    padding: 2px 8px; border-radius: 5px;
    background: var(--gold); color: #fff;
    font-size: .62rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
}

.nb-card-body { padding: 14px 16px 16px; display: flex; flex-direction: column; gap: 8px; flex: 1; }

.nb-card-meta-row {
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
}
.nb-card-meta-item {
    display: flex; align-items: center; gap: 4px;
    font-size: .71rem; color: var(--dim);
}
.nb-card-meta-item svg { width: 11px; height: 11px; color: var(--gold); flex-shrink: 0; }

.nb-card-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.05rem; font-weight: 600; letter-spacing: -.01em;
    color: var(--text); line-height: 1.3; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.nb-card-excerpt {
    font-size: .78rem; color: var(--muted); line-height: 1.7;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.nb-card-foot {
    display: flex; align-items: center; justify-content: space-between;
    border-top: 1px solid var(--border); padding-top: 10px; margin-top: auto;
}

/* Author */
.nb-author {
    display: flex; align-items: center; gap: 7px;
}
.nb-author-av {
    width: 24px; height: 24px; border-radius: 50%;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center;
    font-size: .64rem; font-weight: 700; color: var(--gold); flex-shrink: 0;
}
.nb-author-name { font-size: .74rem; font-weight: 500; color: var(--text); }

.nb-card-readmore {
    display: flex; align-items: center; gap: 3px;
    font-size: .74rem; font-weight: 600; color: var(--gold);
    transition: gap var(--t);
}
.nb-card:hover .nb-card-readmore { gap: 7px; }
.nb-card-readmore svg { width: 11px; height: 11px; }

/* ══ EMPTY ══ */
.nb-empty { text-align: center; padding: 72px 20px; color: var(--dim); }
.nb-empty svg { width: 44px; height: 44px; margin-bottom: 16px; opacity: .3; }
.nb-empty h3 { font-size: .92rem; color: var(--muted); margin-bottom: 5px; }

/* ══ PAGINATION ══ */
.nb-pagination {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    padding-top: 40px; flex-wrap: wrap;
}
.nb-page-btn {
    min-width: 36px; height: 36px; padding: 0 10px;
    border-radius: 8px; border: 1.5px solid var(--border);
    background: var(--surface); font-size: .8rem; font-weight: 500;
    color: var(--muted); display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all var(--t); text-decoration: none;
}
.nb-page-btn:hover { border-color: var(--gold); color: var(--gold); }
.nb-page-btn.active { background: var(--gold); border-color: var(--gold); color: #fff; }
.nb-page-btn.disabled { opacity: .35; pointer-events: none; }
.nb-page-btn svg { width: 14px; height: 14px; }

@media (max-width: 640px) { .nb-meta { margin-left: 0; } }
</style>

{{-- ══ HERO ══ --}}
<section class="nb-hero">
    <div class="container">
        <div class="nb-hero-inner">
            <div>
                <div class="nb-eyebrow">Terra Updates</div>
                <h1>News &amp; <em>Insights</em></h1>
                <p>Stay informed with the latest property market news, expert guides, and real estate updates from across Rwanda.</p>
            </div>
            <div class="nb-hero-meta">
                <strong>{{ $blogs->total() }}</strong> articles published
            </div>
        </div>
    </div>
</section>

{{-- ══ FILTER BAR ══ --}}
<div class="nb-filter">
    <div class="container">
        <div class="nb-filter-inner">

            <div class="nb-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" id="nb-q" placeholder="Search articles…" autocomplete="off">
            </div>

            <select class="nb-select" id="nb-sort"
                onchange="window.location.href='?sort='+this.value+'&page=1'">
                <option value="newest" {{ request('sort','newest')==='newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request('sort')==='oldest' ? 'selected' : '' }}>Oldest</option>
                <option value="popular" {{ request('sort')==='popular' ? 'selected' : '' }}>Most Popular</option>
            </select>

            <div class="nb-meta">
                <span class="nb-count">
                    Page <strong>{{ $blogs->currentPage() }}</strong> of <strong>{{ $blogs->lastPage() }}</strong>
                </span>
            </div>

        </div>
    </div>
</div>

{{-- ══ FEATURED FIRST POST ══ --}}
@if($blogs->currentPage() === 1 && $blogs->count() > 0)
@php $featured = $blogs->first(); @endphp
<div class="nb-featured">
    <div class="container">
        <a href="{{ route('front.news.details', $featured->slug) }}" class="nb-feat-card">
            <div class="nb-feat-img">
                <span class="nb-feat-label">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Latest
                </span>
                @if($featured->image ?? null)
                    <img src="{{ asset('storage/'.$featured->image) }}" alt="{{ $featured->title }}" loading="lazy">
                @else
                    <img src="{{ asset('front/assets/img/all-images/blog/blog-img1.png') }}" alt="{{ $featured->title }}" loading="lazy">
                @endif
            </div>
            <div class="nb-feat-content">
                <div class="nb-feat-cat">{{ $featured->category?->name ?? 'Real Estate' }}</div>
                <h2 class="nb-feat-title">{{ $featured->title }}</h2>
                @if($featured->excerpt ?? null)
                <p class="nb-feat-excerpt">{{ $featured->excerpt }}</p>
                @endif
                <div class="nb-feat-meta">
                    <div class="nb-feat-meta-item">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                        {{ $featured->created_at->format('d M Y') }}
                    </div>
                    <div class="nb-feat-meta-item">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        By {{ $featured->author->name ?? 'Terra Editorial' }}
                    </div>
                    <div class="nb-feat-meta-item">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
                        {{ ceil(str_word_count(strip_tags($featured->content ?? '')) / 200) ?: 3 }} min read
                    </div>
                </div>
                <div class="nb-feat-readmore">
                    Read full article
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"/></svg>
                </div>
            </div>
        </a>
    </div>
</div>
@endif

{{-- ══ ARTICLES GRID ══ --}}
<div class="nb-main">
    <div class="container">

        <div class="nb-section-head">
            <div>
                <div class="nb-section-eyebrow">Latest Articles</div>
                <h2 class="nb-section-title">All <em>news & updates</em></h2>
            </div>
        </div>

        @if($blogs->count() > 0)
        <div class="row g-4" id="nb-row">
            @foreach($blogs as $i => $blog)
            @if($loop->first && $blogs->currentPage() === 1)
                @php continue; @endphp
            @endif
            <div class="col-xl-4 col-lg-4 col-md-6 col-12"
                 data-title="{{ strtolower($blog->title) }}"
                 style="animation-delay:{{ ($i - 1) * 0.05 }}s">
                <a href="{{ route('front.news.details', $blog->slug) }}" class="nb-card d-flex flex-column h-100">

                    <div class="nb-card-img">
                        <span class="nb-read-time">
                            {{ ceil(str_word_count(strip_tags($blog->content ?? '')) / 200) ?: 3 }} min read
                        </span>
                        <span class="nb-card-cat">{{ $blog->category?->name ?? 'News' }}</span>
                        @if($blog->image ?? null)
                            <img src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}" loading="lazy">
                        @else
                            <img src="{{ asset('front/assets/img/all-images/blog/blog-img1.png') }}" alt="{{ $blog->title }}" loading="lazy">
                        @endif
                    </div>

                    <div class="nb-card-body">
                        <div class="nb-card-meta-row">
                            <div class="nb-card-meta-item">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z"/></svg>
                                {{ $blog->created_at->format('d M Y') }}
                            </div>
                        </div>

                        <h3 class="nb-card-title">{{ $blog->title }}</h3>

                        @if($blog->excerpt ?? null)
                        <p class="nb-card-excerpt">{{ $blog->excerpt }}</p>
                        @endif

                        <div class="nb-card-foot">
                            <div class="nb-author">
                                <div class="nb-author-av">
                                    {{ strtoupper(substr($blog->author->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="nb-author-name">{{ $blog->author->name ?? 'Terra Editorial' }}</span>
                            </div>
                            <span class="nb-card-readmore">
                                Read
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z"/></svg>
                            </span>
                        </div>
                    </div>

                </a>
            </div>
            @endforeach
        </div>

        {{-- JS search empty state ── --}}
        <div class="nb-empty" id="nb-empty" style="display:none">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35M11 8v3m0 3h.01"/></svg>
            <h3>No articles match your search</h3>
            <p>Try a different keyword.</p>
        </div>

        @else
        <div class="nb-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                <path d="M8 10h8M8 14h5"/>
            </svg>
            <h3>No news found</h3>
            <p>Check back soon — new articles are published regularly.</p>
        </div>
        @endif

        {{-- ══ PAGINATION ══ --}}
        @if($blogs->hasPages())
        <div class="nb-pagination">
            {{-- Prev ── --}}
            @if($blogs->onFirstPage())
            <span class="nb-page-btn disabled">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"/></svg>
            </span>
            @else
            <a class="nb-page-btn" href="{{ $blogs->previousPageUrl() }}&sort={{ request('sort','newest') }}">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10.8284 12.0007L15.7782 16.9504L14.364 18.3646L8 12.0007L14.364 5.63672L15.7782 7.05093L10.8284 12.0007Z"/></svg>
            </a>
            @endif

            {{-- Page numbers ── --}}
            @foreach($blogs->links()->elements[0] ?? [] as $page => $url)
            <a class="nb-page-btn {{ $page == $blogs->currentPage() ? 'active' : '' }}"
               href="{{ $url }}&sort={{ request('sort','newest') }}">{{ $page }}</a>
            @endforeach

            {{-- Next ── --}}
            @if($blogs->hasMorePages())
            <a class="nb-page-btn" href="{{ $blogs->nextPageUrl() }}&sort={{ request('sort','newest') }}">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"/></svg>
            </a>
            @else
            <span class="nb-page-btn disabled">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z"/></svg>
            </span>
            @endif
        </div>
        @endif

    </div>
</div>

<script>
(function () {
    const rows   = Array.from(document.querySelectorAll('#nb-row [class*="col-"]'));
    const emptyEl= document.getElementById('nb-empty');
    let q = '';

    function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }

    function run() {
        const s = q.toLowerCase();
        let vis = 0;
        rows.forEach(col => {
            const title = col.dataset.title || '';
            const show  = !s || title.includes(s);
            col.style.display = show ? '' : 'none';
            if (show) vis++;
        });
        if (emptyEl) emptyEl.style.display = vis === 0 ? 'block' : 'none';
    }

    const input = document.getElementById('nb-q');
    if (input) input.addEventListener('input', debounce(e => { q = e.target.value; run(); }, 200));
})();
</script>

@endsection