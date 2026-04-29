@extends('layouts.guest')
@section('title', $blog->title)
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --dark: #0E0E0C;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .14);
        --gold: #C8873A;
        --gold-lt: #E5A55E;
        --gold-bg: rgba(200, 135, 58, .07);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --r: 12px;
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

    /* ── Breadcrumb ── */
    .nd-bc {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 12px 0;
    }

    .nd-bc-inner {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: .75rem;
        color: var(--dim);
        flex-wrap: wrap;
    }

    .nd-bc-inner a {
        color: var(--muted);
        transition: color var(--t);
    }

    .nd-bc-inner a:hover {
        color: var(--gold);
    }

    .nd-bc-inner svg {
        width: 12px;
        height: 12px;
    }

    .nd-bc-inner .cur {
        color: var(--text);
        font-weight: 500;
    }

    /* ── Article hero ── */
    .nd-hero {
        background: var(--dark);
        position: relative;
        overflow: hidden;
        padding: 56px 0 48px;
    }

    .nd-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 50% 60% at 5% 50%, rgba(200, 135, 58, .11) 0%, transparent 65%),
            radial-gradient(ellipse 35% 50% at 95% 20%, rgba(200, 135, 58, .06) 0%, transparent 55%);
        pointer-events: none;
    }

    .nd-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255, 255, 255, .016) 39px, rgba(255, 255, 255, .016) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255, 255, 255, .01) 79px, rgba(255, 255, 255, .01) 80px);
        pointer-events: none;
    }

    .nd-hero .container {
        position: relative;
        z-index: 2;
        max-width: 820px;
    }

    .nd-cat-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 6px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .09em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 14px;
    }

    .nd-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 4.5vw, 3rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.025em;
        color: #F0EDE8;
        margin-bottom: 18px;
    }

    .nd-meta-strip {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .nd-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .76rem;
        color: rgba(240, 237, 232, .4);
    }

    .nd-meta-item svg {
        width: 13px;
        height: 13px;
        color: var(--gold-lt);
        flex-shrink: 0;
    }

    .nd-meta-item strong {
        color: rgba(240, 237, 232, .65);
        font-weight: 500;
    }

    .nd-meta-dot {
        width: 3px;
        height: 3px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .2);
    }

    /* Hero cover image */
    .nd-cover {
        margin-top: 40px;
        border-radius: 16px;
        overflow: hidden;
        aspect-ratio: 21/9;
        background: var(--bg);
    }

    .nd-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    @media (max-width: 640px) {
        .nd-cover {
            aspect-ratio: 16/9;
        }
    }

    /* ── Page layout ── */
    .nd-page {
        padding: 40px 0 80px;
    }

    .nd-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 28px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .nd-layout {
            grid-template-columns: 1fr;
        }

        .nd-sidebar {
            order: -1;
        }
    }

    /* ── Article body ── */
    .nd-article-body {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        padding: 36px 40px;
    }

    @media (max-width: 640px) {
        .nd-article-body {
            padding: 22px 18px;
        }
    }

    /* Share / save top bar */
    .nd-article-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border);
        flex-wrap: wrap;
        gap: 10px;
    }

    .nd-toolbar-left {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .75rem;
        color: var(--dim);
    }

    .nd-toolbar-left svg {
        width: 13px;
        height: 13px;
        color: var(--gold);
    }

    .nd-share-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .nd-share-label {
        font-size: .72rem;
        color: var(--dim);
        font-weight: 500;
    }

    .nd-share-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1px solid var(--border);
        background: var(--bg);
        display: grid;
        place-items: center;
        cursor: pointer;
        color: var(--dim);
        transition: all var(--t);
        text-decoration: none;
    }

    .nd-share-btn:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    .nd-share-btn svg {
        width: 13px;
        height: 13px;
    }

    /* Prose styles */
    .nd-prose {
        font-size: .92rem;
        color: var(--muted);
        line-height: 1.9;
    }

    .nd-prose h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text);
        letter-spacing: -.01em;
        line-height: 1.25;
        margin: 2rem 0 .9rem;
    }

    .nd-prose h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text);
        letter-spacing: -.01em;
        line-height: 1.3;
        margin: 1.6rem 0 .7rem;
    }

    .nd-prose p {
        margin-bottom: 1.2rem;
    }

    .nd-prose p:last-child {
        margin-bottom: 0;
    }

    .nd-prose strong {
        color: var(--text);
        font-weight: 600;
    }

    .nd-prose a {
        color: var(--gold);
        text-decoration: underline;
        text-decoration-color: var(--gold-bd);
    }

    .nd-prose a:hover {
        text-decoration-color: var(--gold);
    }

    .nd-prose ul,
    .nd-prose ol {
        padding-left: 1.4rem;
        margin-bottom: 1.2rem;
    }

    .nd-prose li {
        margin-bottom: .4rem;
    }

    .nd-prose blockquote {
        margin: 1.6rem 0;
        padding: 16px 20px;
        border-left: 3px solid var(--gold);
        border-radius: 0 8px 8px 0;
        background: var(--gold-bg);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.05rem;
        font-style: italic;
        color: var(--text);
        line-height: 1.65;
    }

    .nd-prose img {
        width: 100%;
        border-radius: var(--r);
        margin: 1.4rem 0;
        display: block;
    }

    /* Author card at bottom */
    .nd-author-card {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 32px;
        padding: 20px;
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: var(--r);
    }

    .nd-author-av {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: var(--gold-bg);
        border: 2px solid var(--gold-bd);
        display: grid;
        place-items: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gold);
        flex-shrink: 0;
    }

    .nd-author-name {
        font-size: .9rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 2px;
    }

    .nd-author-role {
        font-size: .75rem;
        color: var(--dim);
    }

    .nd-author-bio {
        font-size: .78rem;
        color: var(--muted);
        line-height: 1.65;
        margin-top: 5px;
    }

    /* ── SIDEBAR ── */
    .nd-sidebar {
        position: sticky;
        top: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    /* Panel */
    .nd-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
    }

    .nd-panel-head {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .nd-panel-icon {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .nd-panel-icon svg {
        width: 13px;
        height: 13px;
        color: var(--gold);
    }

    .nd-panel-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: .95rem;
        font-weight: 600;
        color: var(--text);
        margin: 0;
    }

    .nd-panel-body {
        padding: 14px 16px;
    }

    /* Search */
    .nd-sb-search {
        position: relative;
    }

    .nd-sb-search input {
        width: 100%;
        padding: 9px 38px 9px 12px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: .8rem;
        font-family: 'DM Sans', sans-serif;
        background: var(--bg);
        color: var(--text);
        transition: border-color var(--t);
    }

    .nd-sb-search input:focus {
        outline: none;
        border-color: var(--gold);
        background: var(--surface);
    }

    .nd-sb-search input::placeholder {
        color: var(--dim);
    }

    .nd-sb-search button {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--gold);
    }

    .nd-sb-search button svg {
        width: 14px;
        height: 14px;
        display: block;
    }

    /* Categories */
    .nd-cat-list {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .nd-cat-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 10px;
        border-radius: 8px;
        font-size: .8rem;
        color: var(--muted);
        transition: background var(--t), color var(--t);
        cursor: pointer;
        text-decoration: none;
    }

    .nd-cat-item:hover {
        background: var(--gold-bg);
        color: var(--gold);
    }

    .nd-cat-item:hover .nd-cat-count {
        background: var(--gold);
        color: #fff;
        border-color: var(--gold);
    }

    .nd-cat-name {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .nd-cat-name svg {
        width: 11px;
        height: 11px;
        color: var(--gold);
    }

    .nd-cat-count {
        font-size: .66rem;
        font-weight: 700;
        padding: 1px 6px;
        border-radius: 4px;
        background: var(--bg);
        border: 1px solid var(--border);
        color: var(--dim);
        transition: all var(--t);
    }

    /* Related posts */
    .nd-related-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .nd-rel-item {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        text-decoration: none;
        color: var(--text);
        transition: transform var(--t);
    }

    .nd-rel-item:hover {
        transform: translateX(3px);
    }

    .nd-rel-img {
        width: 64px;
        height: 52px;
        border-radius: 7px;
        overflow: hidden;
        background: var(--bg);
        flex-shrink: 0;
    }

    .nd-rel-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .nd-rel-date {
        font-size: .65rem;
        color: var(--gold);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 3px;
    }

    .nd-rel-title {
        font-size: .8rem;
        font-weight: 600;
        color: var(--text);
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ── RELATED POSTS GRID (bottom) ── */
    .nd-related-section {
        padding: 0 0 72px;
    }

    .nd-related-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .nd-related-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 500;
        color: var(--text);
    }

    .nd-related-title em {
        font-style: italic;
        color: var(--gold);
    }

    .nd-see-all {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .78rem;
        color: var(--gold);
        font-weight: 500;
        border-bottom: 1px solid var(--gold-bd);
        transition: gap var(--t);
    }

    .nd-see-all:hover {
        gap: 9px;
    }

    .nd-see-all svg {
        width: 12px;
        height: 12px;
    }

    .nd-rel-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        color: var(--text);
    }

    .nd-rel-card:hover {
        transform: translateY(-4px);
        border-color: var(--gold-bd);
        box-shadow: 0 10px 28px rgba(0, 0, 0, .09);
        color: var(--text);
    }

    .nd-rel-card-img {
        position: relative;
        aspect-ratio: 16/10;
        overflow: hidden;
        background: var(--bg);
        flex-shrink: 0;
    }

    .nd-rel-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }

    .nd-rel-card:hover .nd-rel-card-img img {
        transform: scale(1.06);
    }

    .nd-rel-card-cat {
        position: absolute;
        bottom: 8px;
        left: 8px;
        padding: 2px 7px;
        border-radius: 5px;
        background: var(--gold);
        color: #fff;
        font-size: .6rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        z-index: 2;
    }

    .nd-rel-card-body {
        padding: 13px 14px 15px;
        display: flex;
        flex-direction: column;
        gap: 7px;
        flex: 1;
    }

    .nd-rel-card-meta {
        font-size: .7rem;
        color: var(--dim);
    }

    .nd-rel-card-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: -.01em;
        color: var(--text);
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .nd-rel-card-foot {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid var(--border);
        padding-top: 8px;
        margin-top: auto;
    }

    .nd-rel-card-author {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .72rem;
        color: var(--muted);
    }

    .nd-rel-av {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        font-size: .58rem;
        font-weight: 700;
        color: var(--gold);
    }

    .nd-rel-readmore {
        display: flex;
        align-items: center;
        gap: 3px;
        font-size: .72rem;
        font-weight: 600;
        color: var(--gold);
        transition: gap var(--t);
    }

    .nd-rel-card:hover .nd-rel-readmore {
        gap: 7px;
    }

    .nd-rel-readmore svg {
        width: 11px;
        height: 11px;
    }

    /* ── CTA ── */
    .nd-cta {
        background: var(--dark);
        position: relative;
        overflow: hidden;
        padding: 64px 0;
    }

    .nd-cta::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 50% at 20% 50%, rgba(200, 135, 58, .13) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at 85% 30%, rgba(200, 135, 58, .06) 0%, transparent 55%);
        pointer-events: none;
    }

    .nd-cta .container {
        position: relative;
        z-index: 2;
    }

    .nd-cta-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
    }

    .nd-cta-eyebrow {
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold-lt);
        margin-bottom: 8px;
        display: block;
    }

    .nd-cta-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.6rem, 3.5vw, 2.4rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: #F0EDE8;
    }

    .nd-cta-title em {
        font-style: italic;
        color: var(--gold-lt);
    }

    .nd-cta-sub {
        font-size: .84rem;
        color: rgba(240, 237, 232, .38);
        line-height: 1.75;
        margin-top: 8px;
        max-width: 420px;
    }

    .nd-cta-btns {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        flex-shrink: 0;
    }

    .nd-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 12px 22px;
        border-radius: 9px;
        font-size: .84rem;
        font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        border: none;
        text-decoration: none;
    }

    .nd-cta-btn svg {
        width: 14px;
        height: 14px;
    }

    .nd-btn-gold {
        background: var(--gold);
        color: #fff;
    }

    .nd-btn-gold:hover {
        background: #a06828;
        color: #fff;
        transform: translateY(-1px);
    }

    .nd-btn-ghost {
        background: rgba(255, 255, 255, .08);
        color: #F0EDE8;
        border: 1px solid rgba(255, 255, 255, .15);
    }

    .nd-btn-ghost:hover {
        background: rgba(255, 255, 255, .16);
        color: #fff;
    }
</style>

{{-- ── Breadcrumb ── --}}
<div class="nd-bc">
    <div class="container">
        <div class="nd-bc-inner">
            <a href="{{ route('front.home') }}">Home</a>
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6l6 6-6 6" />
            </svg>
            <a href="{{ route('front.news.index') }}">News</a>
            <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M10 6l6 6-6 6" />
            </svg>
            <span class="cur">{{ Str::limit($blog->title, 48) }}</span>
        </div>
    </div>
</div>

{{-- ── Article Hero ── --}}
<section class="nd-hero">
    <div class="container">
        @if($blog->category ?? null)
        <div class="nd-cat-badge">{{ $blog->category->name }}</div>
        @endif
        <h1>{{ $blog->title }}</h1>
        <div class="nd-meta-strip">
            <div class="nd-meta-item">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
                <strong>By {{ $blog->author->name ?? 'Terra Editorial' }}</strong>
            </div>
            <div class="nd-meta-dot"></div>
            <div class="nd-meta-item">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10z" />
                </svg>
                {{ $blog->created_at->format('d F Y') }}
            </div>
            <div class="nd-meta-dot"></div>
            <div class="nd-meta-item">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z" />
                </svg>
                {{ ceil(str_word_count(strip_tags($blog->content ?? '')) / 200) ?: 3 }} min read
            </div>
            {{-- ── View count (total, human-formatted) ── --}}
            @if($blog->views_count > 0)
            <span class="view-chip">
                {{-- Eye icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                </svg>
                {{ number_format($blog->views_count) }} {{ Str::plural('view', $blog->views_count) }}
            </span>
            @endif
        </div>
    </div>
</section>

{{-- ── Cover image ── --}}
<div style="background:var(--bg);padding:0 0 0">
    <div class="container">
        <div class="nd-cover">
            @if($blog->featured_image ?? null)
            <img src="{{asset('image/blogs/')}}/{{ $blog->featured_image }}" alt="{{ $blog->title }}" loading="lazy">
            @else
            <img src="{{ asset('front/assets/img/all-images/blog/blog-img20.png') }}" alt="{{ $blog->title }}" loading="lazy">
            @endif
        </div>
    </div>
</div>

{{-- ── Page content ── --}}
<div class="nd-page">
    <div class="container">

        <div class="nd-layout">

            {{-- ══ MAIN ARTICLE ══ --}}
            <div>
                <div class="nd-article-body">

                    {{-- Toolbar ── --}}
                    <div class="nd-article-toolbar">
                        <div class="nd-toolbar-left">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z" />
                            </svg>
                            {{ ceil(str_word_count(strip_tags($blog->content ?? '')) / 200) ?: 3 }} min read
                        </div>
                        <div class="nd-share-group">
                            <span class="nd-share-label">Share</span>
                            <a href="https://wa.me/?text={{ urlencode($blog->title.' '.request()->url()) }}" target="_blank" class="nd-share-btn" title="WhatsApp">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                    <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                                </svg>
                            </a>
                            <button class="nd-share-btn" title="Copy link"
                                onclick="navigator.clipboard.writeText(window.location.href).then(()=>{ this.style.background='var(--gold)'; this.style.color='#fff'; setTimeout(()=>{ this.style.background=''; this.style.color=''; },1500); })">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13.1202 17.0228L8.92129 14.7324C8.19135 15.5125 7.15261 16 6 16C3.79086 16 2 14.2091 2 12C2 9.79086 3.79086 8 6 8C7.15255 8 8.19125 8.48746 8.92118 9.26746L13.1202 6.97713C13.0417 6.66441 13 6.33707 13 6C13 3.79086 14.7909 2 17 2C19.2091 2 21 3.79086 21 6C21 8.20914 19.2091 10 17 10C15.8474 10 14.8087 9.51251 14.0787 8.73246L9.87977 11.0228C9.9583 11.3355 10 11.6629 10 12C10 12.3371 9.95831 12.6644 9.87981 12.9771L14.0788 15.2675C14.8087 14.4875 15.8474 14 17 14C19.2091 14 21 15.7909 21 18C21 20.2091 19.2091 22 17 22C14.7909 22 13 20.2091 13 18C13 17.6629 13.0417 17.3355 13.1202 17.0228Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Prose ── --}}
                    <div class="nd-prose">
                        {!! $blog->content !!}
                    </div>

                    {{-- ─── Gallery Section ─────────────────────────────────────────────────────── --}}
                    @if($blog->images->isNotEmpty())
                    <div class="card bg-base-100 border border-base-300 rounded-xl">
                        <div class="card-body p-6 space-y-4">

                            {{-- Header + view toggle --}}
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-base-content flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Gallery
                                    <span class="badge badge-ghost badge-sm">{{ $blog->images->count() }}</span>
                                </h3>

                                <div class="join" role="group" aria-label="View toggle">
                                    {{-- Grid view --}}
                                    <button id="btn-grid" onclick="setView('grid')"
                                        class="join-item btn btn-sm btn-primary"
                                        title="Grid view">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                    </button>
                                    {{-- Masonry view --}}
                                    <button id="btn-masonry" onclick="setView('masonry')"
                                        class="join-item btn btn-sm btn-ghost"
                                        title="Masonry view">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7" />
                                        </svg>
                                    </button>
                                    {{-- Carousel view --}}
                                    <button id="btn-carousel" onclick="setView('carousel')"
                                        class="join-item btn btn-sm btn-ghost"
                                        title="Carousel view">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.069A1 1 0 0121 8.9V15.1a1 1 0 01-1.447.9L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- ── GRID VIEW ───────────────────────────────────────────────────── --}}
                            <div id="view-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach($blog->images as $i => $img)
                                <div class="gallery-thumb relative group rounded-xl overflow-hidden border border-base-300
                             bg-base-200 aspect-square cursor-zoom-in"
                                    data-index="{{ $i }}"
                                    onclick="openLightbox({{ $i }})">
                                    <img src="{{asset('image/blogs/')}}/{{ $img->image_path }}"
                                        alt="{{ $img->caption ?? 'Gallery image ' . ($i + 1) }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                                    {{-- Hover overlay --}}
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-all duration-300 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 drop-shadow"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </div>

                                    {{-- Caption --}}
                                    @if($img->caption)
                                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent
                                    px-3 py-2 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                        <p class="text-white text-xs truncate">{{ $img->caption }}</p>
                                    </div>
                                    @endif

                                    {{-- Index badge --}}
                                    <span class="absolute top-2 left-2 badge badge-xs bg-black/50 text-white border-0">
                                        {{ $i + 1 }}
                                    </span>
                                </div>
                                @endforeach
                            </div>

                            {{-- ── MASONRY VIEW ────────────────────────────────────────────────── --}}
                            <div id="view-masonry" class="hidden columns-2 sm:columns-3 lg:columns-4 gap-3 space-y-3">
                                @foreach($blog->images as $i => $img)
                                <div class="gallery-thumb break-inside-avoid rounded-xl overflow-hidden border border-base-300
                             cursor-zoom-in group relative"
                                    data-index="{{ $i }}"
                                    onclick="openLightbox({{ $i }})">
                                    <img src="{{asset('image/blogs/')}}/{{ $img->image_path }}"
                                        alt="{{ $img->caption ?? '' }}"
                                        class="w-full h-auto block transition-transform duration-300 group-hover:scale-105">

                                    @if($img->caption)
                                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent px-3 py-2">
                                        <p class="text-white text-xs">{{ $img->caption }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            {{-- ── CAROUSEL VIEW ───────────────────────────────────────────────── --}}
                            <div id="view-carousel" class="hidden space-y-3">
                                {{-- Main slide --}}
                                <div class="relative rounded-xl overflow-hidden bg-base-200 border border-base-300 select-none"
                                    style="aspect-ratio: 16/7;">
                                    <div id="carousel-track"
                                        class="flex h-full transition-transform duration-500 ease-in-out"
                                        style="width: {{ $blog->images->count() * 100 }}%">
                                        @foreach($blog->images as $i => $img)
                                        <div class="h-full cursor-zoom-in"
                                            style="width: {{ round(100 / $blog->images->count(), 4) }}%"
                                            onclick="openLightbox({{ $i }})">
                                            <img src="{{asset('image/blogs/')}}/{{ $img->image_path }}"
                                                alt="{{ $img->caption ?? '' }}"
                                                class="w-full h-full object-contain">
                                        </div>
                                        @endforeach
                                    </div>

                                    {{-- Prev / Next --}}
                                    <button onclick="carouselPrev()"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 btn btn-circle btn-sm
                               bg-black/40 hover:bg-black/70 border-0 text-white shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button onclick="carouselNext()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 btn btn-circle btn-sm
                               bg-black/40 hover:bg-black/70 border-0 text-white shadow-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>

                                    {{-- Slide counter --}}
                                    <div class="absolute bottom-3 right-3 badge bg-black/50 text-white border-0 text-xs">
                                        <span id="carousel-counter">1</span> / {{ $blog->images->count() }}
                                    </div>

                                    {{-- Caption --}}
                                    @if($blog->images->contains(fn($img) => $img->caption))
                                    <div id="carousel-caption"
                                        class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 to-transparent
                                px-5 py-4 pointer-events-none">
                                        <p class="text-white text-sm text-center font-medium" id="carousel-caption-text"></p>
                                    </div>
                                    @endif
                                </div>

                                {{-- Thumbnail strip --}}
                                <div class="flex gap-2 overflow-x-auto pb-1 scroll-smooth snap-x" id="carousel-thumbs">
                                    @foreach($blog->images as $i => $img)
                                    <button type="button"
                                        onclick="carouselGoTo({{ $i }})"
                                        class="carousel-dot flex-none w-16 h-12 rounded-lg overflow-hidden border-2
                                   border-transparent transition-all snap-start"
                                        data-carousel-thumb="{{ $i }}">
                                        <img src="{{ Storage::url($img->image_path) }}"
                                            alt=""
                                            class="w-full h-full object-cover">
                                    </button>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>


                    {{-- ═══════════════════════════════════════════════════════════════════════════ --}}
                    {{-- LIGHTBOX                                                                   --}}
                    {{-- ═══════════════════════════════════════════════════════════════════════════ --}}
                    <div id="lightbox"
                        class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/90 backdrop-blur-sm"
                        onclick="closeLightboxOnBackdrop(event)">

                        <div class="relative flex flex-col items-center max-w-5xl w-full mx-4 gap-4"
                            id="lightbox-inner">

                            {{-- Close --}}
                            <button onclick="closeLightbox()"
                                class="absolute -top-3 -right-3 z-10 btn btn-circle btn-sm bg-white/10 hover:bg-white/20
                       border-0 text-white shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            {{-- Image --}}
                            <div class="relative w-full flex items-center justify-center" style="max-height: 80vh;">
                                <img id="lightbox-img"
                                    src=""
                                    alt=""
                                    class="max-h-[80vh] max-w-full rounded-xl object-contain shadow-2xl select-none">

                                {{-- Prev --}}
                                <button onclick="lightboxPrev()"
                                    class="absolute left-2 btn btn-circle btn-sm bg-black/40 hover:bg-black/80 border-0 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>

                                {{-- Next --}}
                                <button onclick="lightboxNext()"
                                    class="absolute right-2 btn btn-circle btn-sm bg-black/40 hover:bg-black/80 border-0 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                            {{-- Caption + counter --}}
                            <div class="flex items-center gap-4 text-white/70 text-sm">
                                <span id="lightbox-caption" class="italic"></span>
                                <span class="text-white/40">·</span>
                                <span id="lightbox-counter" class="tabular-nums"></span>
                            </div>

                            {{-- Thumbnail strip --}}
                            <div class="flex gap-2 overflow-x-auto max-w-full pb-1">
                                @foreach($blog->images as $i => $img)
                                <button type="button"
                                    onclick="lightboxGoTo({{ $i }})"
                                    data-lightbox-thumb="{{ $i }}"
                                    class="flex-none w-14 h-10 rounded-md overflow-hidden border-2 border-transparent
                               transition-all opacity-60 hover:opacity-100">
                                    <img src="{{ Storage::url($img->image_path) }}"
                                        alt=""
                                        class="w-full h-full object-cover">
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif


                    <script>
                        (function() {
                            // ── Image data from PHP ──────────────────────────────────────────────────
                            const IMAGES = @json($blog->images->map(fn($img) => [
                                'src' => Storage::url($img->image_path),
                                'caption' => $img->caption ?? '',
                            ]));

                            const TOTAL = IMAGES.length;

                            // ═══════════════════════════════════════════════════════════════════════
                            // VIEW TOGGLE
                            // ═══════════════════════════════════════════════════════════════════════
                            const views = ['grid', 'masonry', 'carousel'];

                            window.setView = function(view) {
                                views.forEach(v => {
                                    const el = document.getElementById(`view-${v}`);
                                    const btn = document.getElementById(`btn-${v}`);
                                    if (!el || !btn) return;
                                    el.classList.toggle('hidden', v !== view);
                                    btn.classList.toggle('btn-primary', v === view);
                                    btn.classList.toggle('btn-ghost', v !== view);
                                });
                                if (view === 'carousel') carouselGoTo(0);
                                localStorage.setItem('blog-gallery-view', view);
                            };

                            // Restore last used view
                            const saved = localStorage.getItem('blog-gallery-view') || 'grid';
                            setView(saved);

                            // ═══════════════════════════════════════════════════════════════════════
                            // CAROUSEL
                            // ═══════════════════════════════════════════════════════════════════════
                            let carouselIdx = 0;
                            const track = document.getElementById('carousel-track');
                            const counter = document.getElementById('carousel-counter');
                            const captionEl = document.getElementById('carousel-caption-text');

                            window.carouselGoTo = function(i) {
                                carouselIdx = ((i % TOTAL) + TOTAL) % TOTAL;
                                if (track) track.style.transform = `translateX(-${carouselIdx * (100 / TOTAL)}%)`;
                                if (counter) counter.textContent = carouselIdx + 1;
                                if (captionEl) captionEl.textContent = IMAGES[carouselIdx].caption;

                                // Active thumb highlight
                                document.querySelectorAll('[data-carousel-thumb]').forEach(t => {
                                    const active = parseInt(t.dataset.carouselThumb) === carouselIdx;
                                    t.classList.toggle('border-primary', active);
                                    t.classList.toggle('opacity-100', active);
                                    t.classList.toggle('opacity-50', !active);
                                });
                            };

                            window.carouselPrev = () => carouselGoTo(carouselIdx - 1);
                            window.carouselNext = () => carouselGoTo(carouselIdx + 1);

                            // Swipe support for carousel
                            let touchStartX = 0;
                            if (track) {
                                track.addEventListener('touchstart', e => {
                                    touchStartX = e.touches[0].clientX;
                                }, {
                                    passive: true
                                });
                                track.addEventListener('touchend', e => {
                                    const diff = touchStartX - e.changedTouches[0].clientX;
                                    if (Math.abs(diff) > 50) diff > 0 ? carouselNext() : carouselPrev();
                                });
                            }

                            // ═══════════════════════════════════════════════════════════════════════
                            // LIGHTBOX
                            // ═══════════════════════════════════════════════════════════════════════
                            let lbIdx = 0;
                            const lb = document.getElementById('lightbox');
                            const lbImg = document.getElementById('lightbox-img');
                            const lbCap = document.getElementById('lightbox-caption');
                            const lbCnt = document.getElementById('lightbox-counter');

                            function updateLightbox() {
                                const img = IMAGES[lbIdx];
                                lbImg.src = img.src;
                                lbImg.alt = img.caption;
                                if (lbCap) lbCap.textContent = img.caption;
                                if (lbCnt) lbCnt.textContent = `${lbIdx + 1} / ${TOTAL}`;

                                document.querySelectorAll('[data-lightbox-thumb]').forEach(t => {
                                    const active = parseInt(t.dataset.lightboxThumb) === lbIdx;
                                    t.classList.toggle('border-primary', active);
                                    t.classList.toggle('opacity-100', active);
                                    t.classList.toggle('opacity-60', !active);
                                });
                            }

                            window.openLightbox = function(i) {
                                lbIdx = i;
                                updateLightbox();
                                lb.classList.remove('hidden');
                                lb.classList.add('flex');
                                document.body.classList.add('overflow-hidden');
                            };

                            window.closeLightbox = function() {
                                lb.classList.add('hidden');
                                lb.classList.remove('flex');
                                document.body.classList.remove('overflow-hidden');
                            };

                            window.closeLightboxOnBackdrop = function(e) {
                                if (e.target === lb) closeLightbox();
                            };

                            window.lightboxGoTo = function(i) {
                                lbIdx = ((i % TOTAL) + TOTAL) % TOTAL;
                                updateLightbox();
                            };

                            window.lightboxPrev = () => lightboxGoTo(lbIdx - 1);
                            window.lightboxNext = () => lightboxGoTo(lbIdx + 1);

                            // Keyboard navigation
                            document.addEventListener('keydown', e => {
                                if (lb.classList.contains('hidden')) return;
                                if (e.key === 'ArrowLeft') lightboxPrev();
                                if (e.key === 'ArrowRight') lightboxNext();
                                if (e.key === 'Escape') closeLightbox();
                            });

                            // Swipe in lightbox
                            let lbTouchX = 0;
                            lb.addEventListener('touchstart', e => {
                                lbTouchX = e.touches[0].clientX;
                            }, {
                                passive: true
                            });
                            lb.addEventListener('touchend', e => {
                                const diff = lbTouchX - e.changedTouches[0].clientX;
                                if (Math.abs(diff) > 50) diff > 0 ? lightboxNext() : lightboxPrev();
                            });

                        })();
                    </script>
                    {{-- Author card ── --}}
                    <div class="nd-author-card">
                        <div class="nd-author-av">
                            {{ strtoupper(substr($blog->author->name ?? 'T', 0, 1)) }}
                        </div>
                        <div>
                            <div class="nd-author-name">{{ $blog->author->name ?? 'Terra Editorial' }}</div>
                            <div class="nd-author-role">Terra Real Estate · Editorial Team</div>
                            @if($blog->author->bio ?? null)
                            <p class="nd-author-bio">{{ $blog->author->bio }}</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            {{-- ══ SIDEBAR ══ --}}
            <aside class="nd-sidebar">

                {{-- Search ── --}}
                <div class="nd-panel">
                    <div class="nd-panel-head">
                        <div class="nd-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z" />
                            </svg></div>
                        <p class="nd-panel-title">Search Articles</p>
                    </div>
                    <div class="nd-panel-body">
                        <form action="{{ route('front.news.index') }}" method="GET" class="nd-sb-search">
                            <input type="text" name="q" placeholder="Search news…" value="{{ request('q') }}">
                            <button type="submit">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Categories ── --}}
                @if(isset($blogCategories) && $blogCategories->count())
                <div class="nd-panel">
                    <div class="nd-panel-head">
                        <div class="nd-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.5 2C6.81 2 3 5.81 3 10.5S6.81 19 11.5 19h.5v3c4.86-2.34 8-7 8-11.5C20 5.81 16.19 2 11.5 2zm1 14.5h-2v-2h2v2zm0-4h-2c0-3.25 3-3 3-5 0-1.1-.9-2-2-2s-2 .9-2 2h-2c0-2.21 1.79-4 4-4s4 1.79 4 4c0 2.5-3 2.75-3 5z" />
                            </svg></div>
                        <p class="nd-panel-title">Categories</p>
                    </div>
                    <div class="nd-panel-body">
                        <div class="nd-cat-list">
                            @foreach($blogCategories as $cat)
                            <a href="{{ route('front.news.index', ['category' => $cat->slug ?? $cat->id]) }}" class="nd-cat-item">
                                <span class="nd-cat-name">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.1717 12.0007L8.22192 7.05093L9.63614 5.63672L16.0001 12.0007L9.63614 18.3646L8.22192 16.9504L13.1717 12.0007Z" />
                                    </svg>
                                    {{ $cat->name }}
                                </span>
                                <span class="nd-cat-count">{{ $cat->blogs_count ?? 0 }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                {{-- Related in sidebar ── --}}
                @if(isset($related) && $related->count())
                <div class="nd-panel">
                    <div class="nd-panel-head">
                        <div class="nd-panel-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                            </svg></div>
                        <p class="nd-panel-title">Related News</p>
                    </div>
                    <div class="nd-panel-body">
                        <div class="nd-related-list">
                            @foreach($related->take(4) as $rel)
                            <a href="{{ route('front.news.details', $rel->slug) }}" class="nd-rel-item">
                                <div class="nd-rel-img">
                                    @if($rel->image ?? null)
                                    <img src="{{ asset('storage/'.$rel->image) }}" alt="{{ $rel->title }}" loading="lazy">
                                    @else
                                    <img src="{{ asset('front/assets/img/all-images/blog/blog-img4.png') }}" alt="{{ $rel->title }}" loading="lazy">
                                    @endif
                                </div>
                                <div>
                                    <div class="nd-rel-date">{{ $rel->created_at->format('d M Y') }}</div>
                                    <div class="nd-rel-title">{{ $rel->title }}</div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </aside>

        </div>{{-- /layout --}}

        {{-- ══ RELATED POSTS GRID ══ --}}
        @if(isset($related) && $related->count())
        <div class="nd-related-section">
            <div class="nd-related-head">
                <h2 class="nd-related-title">More <em>articles</em></h2>
                <a href="{{ route('front.news.index') }}" class="nd-see-all">
                    All articles
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="row g-4">
                @foreach($related->take(3) as $i => $rel)
                <div class="col-lg-4 col-md-6 col-12" style="animation: fadeUp .4s ease {{ $i * 0.07 }}s both">
                    <a href="{{ route('front.news.details', $rel->slug) }}" class="nd-rel-card d-flex flex-column h-100">
                        <div class="nd-rel-card-img">
                            <span class="nd-rel-card-cat">{{ $rel->category?->name ?? 'News' }}</span>
                            @if($rel->image ?? null)
                            <img src="{{ asset('storage/'.$rel->image) }}" alt="{{ $rel->title }}" loading="lazy">
                            @else
                            <img src="{{ asset('front/assets/img/all-images/blog/blog-img1.png') }}" alt="{{ $rel->title }}" loading="lazy">
                            @endif
                        </div>
                        <div class="nd-rel-card-body">
                            <div class="nd-rel-card-meta">{{ $rel->created_at->format('d M Y') }}</div>
                            <h3 class="nd-rel-card-title">{{ $rel->title }}</h3>
                            <div class="nd-rel-card-foot">
                                <div class="nd-rel-card-author">
                                    <div class="nd-rel-av">{{ strtoupper(substr($rel->author->name ?? 'T', 0, 1)) }}</div>
                                    {{ $rel->author->name ?? 'Terra Editorial' }}
                                </div>
                                <span class="nd-rel-readmore">
                                    Read
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M13.0508 12.361L7.39395 18.0179L5.97974 16.6037L11.6366 10.9468L6.68684 5.99707H18.0006V17.3108L13.0508 12.361Z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>{{-- /container --}}
</div>{{-- /nd-page --}}

{{-- ══ CTA ══ --}}
<section class="nd-cta">
    <div class="container">
        <div class="nd-cta-inner">
            <div>
                <span class="nd-cta-eyebrow">Terra Real Estate</span>
                <h2 class="nd-cta-title">Ready to find your<br><em>dream property?</em></h2>
                <p class="nd-cta-sub">Browse our full range of properties for sale and rent across Rwanda — verified listings, trusted agents, and expert consultants.</p>
            </div>
            <div class="nd-cta-btns">
                <a href="{{ route('front.properties.buy') }}" class="nd-cta-btn nd-btn-gold">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                    Browse Properties
                </a>
                <a href="{{ route('front.news.index') }}" class="nd-cta-btn nd-btn-ghost">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                    </svg>
                    More Articles
                </a>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@endsection