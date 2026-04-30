@extends('layouts.guest')
@section('title', $announcement->title)

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap');

    :root {
        --bg:        #F7F5F2;
        --surface:   #FFFFFF;
        --border:    #E8E3DC;
        --text:      #19265d;
        --muted:     #7A736B;
        --dim:       #B0A89E;
        --accent:    #D05208;
        --accent-dk: #A04006;
        --navy:      #19265d;
        --navy-lt:   #EEF0F7;
        --green:     #1E7A5A;
        --green-bg:  rgba(30,122,90,.07);
        --amber:     #B45309;
        --amber-bg:  rgba(180,83,9,.07);
        --red:       #DC2626;
        --red-bg:    rgba(220,38,38,.07);
        --r:         12px;
        --t:         .22s cubic-bezier(.4,0,.2,1);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
    }

    /* ── HERO ── */
    .ann-hero {
        background: var(--navy);
        padding: 100px 0 0;
        position: relative;
        overflow: hidden;
    }

    .ann-hero::before {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 70% 90% at 90% 50%, rgba(208,82,8,.1) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at 5% 90%, rgba(208,82,8,.05) 0%, transparent 60%);
        pointer-events: none;
    }

    .ann-hero::after {
        content: '';
        position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.016) 39px, rgba(255,255,255,.016) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.016) 39px, rgba(255,255,255,.016) 40px);
        pointer-events: none;
    }

    .ann-hero-inner {
        position: relative;
        z-index: 2;
        padding-bottom: 44px;
    }

    /* Breadcrumb */
    .ann-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .72rem;
        color: rgba(255,255,255,.3);
        margin-bottom: 20px;
    }

    .ann-breadcrumb a {
        color: rgba(255,255,255,.4);
        text-decoration: none;
        transition: color var(--t);
    }

    .ann-breadcrumb a:hover { color: var(--accent); }
    .ann-breadcrumb svg { width: 12px; height: 12px; }
    .ann-breadcrumb span { color: rgba(255,255,255,.6); }

    /* Status + category row */
    .ann-hero-tags {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .ann-status {
        padding: 4px 11px;
        border-radius: 20px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .ann-status.active   { background: var(--green-bg);  color: #4ade80; }
    .ann-status.inactive { background: var(--red-bg);    color: #f87171; }
    .ann-status.draft    { background: var(--amber-bg);  color: #fbbf24; }
    .ann-status.expired  { background: rgba(0,0,0,.15);  color: rgba(255,255,255,.4); }

    /* Title */
    .ann-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 4vw, 3rem);
        font-weight: 600;
        letter-spacing: -.025em;
        color: #F0EDE8;
        line-height: 1.12;
        margin-bottom: 20px;
        max-width: 780px;
    }

    /* Meta strip */
    .ann-hero-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .ann-hero-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: .76rem;
        color: rgba(255,255,255,.4);
    }

    .ann-hero-meta-item svg { width: 13px; height: 13px; }
    .ann-hero-meta-item strong { color: rgba(255,255,255,.7); font-weight: 500; }

    /* ── LAYOUT ── */
    .ann-layout {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 28px;
        padding: 36px 0 64px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .ann-layout { grid-template-columns: 1fr; }
    }

    /* ── ARTICLE ── */
    .ann-article {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }

    .ann-article-header {
        padding: 24px 28px 20px;
        border-bottom: 1px solid var(--border);
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .ann-article-header-left {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .75rem;
        color: var(--muted);
    }

    .ann-article-header-left svg { width: 14px; height: 14px; color: var(--accent); }

    .ann-share-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        background: var(--surface);
        font-family: 'DM Sans', sans-serif;
        font-size: .75rem;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        transition: all var(--t);
    }

    .ann-share-btn:hover { border-color: var(--accent); color: var(--accent); }
    .ann-share-btn svg { width: 13px; height: 13px; }

    /* Content body */
    .ann-content {
        padding: 32px 28px 36px;
        font-size: .9rem;
        color: #3D3832;
        line-height: 1.8;
    }

    .ann-content p   { margin-bottom: 18px; }
    .ann-content p:last-child { margin-bottom: 0; }

    .ann-content h2, .ann-content h3 {
        font-family: 'Cormorant Garamond', serif;
        color: var(--navy);
        margin: 28px 0 12px;
        font-weight: 600;
        letter-spacing: -.02em;
    }

    .ann-content h2 { font-size: 1.5rem; }
    .ann-content h3 { font-size: 1.2rem; }

    .ann-content ul, .ann-content ol {
        padding-left: 22px;
        margin-bottom: 18px;
    }

    .ann-content li { margin-bottom: 6px; }

    .ann-content strong { color: var(--navy); font-weight: 600; }
    .ann-content em { color: var(--muted); }

    .ann-content a {
        color: var(--accent);
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .ann-content blockquote {
        border-left: 3px solid var(--accent);
        padding: 12px 16px;
        margin: 20px 0;
        background: rgba(208,82,8,.04);
        border-radius: 0 8px 8px 0;
        font-style: italic;
        color: var(--muted);
    }

    /* ── SIDEBAR ── */
    .ann-sidebar { display: flex; flex-direction: column; gap: 16px; }

    .sidebar-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
    }

    .sidebar-card-header {
        padding: 12px 18px;
        border-bottom: 1px solid var(--border);
        background: var(--bg);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
    }

    .sidebar-card-body { padding: 16px 18px; }

    .sidebar-detail {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .sidebar-detail-row {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .sidebar-detail-label {
        font-size: .67rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--dim);
    }

    .sidebar-detail-value {
        font-size: .82rem;
        font-weight: 600;
        color: var(--text);
    }

    /* Timeline indicator */
    .ann-timeline {
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        position: relative;
    }

    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 9px; top: 32px;
        width: 1px;
        height: calc(100% - 16px);
        background: var(--border);
    }

    .timeline-dot {
        width: 18px; height: 18px;
        border-radius: 50%;
        background: var(--bg);
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        z-index: 1;
    }

    .timeline-dot.done  { background: var(--green);  border-color: var(--green); }
    .timeline-dot.now   { background: var(--accent);  border-color: var(--accent); }
    .timeline-dot svg { width: 9px; height: 9px; color: #fff; }

    .timeline-info { padding-top: 1px; }

    .timeline-label {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--dim);
        margin-bottom: 2px;
    }

    .timeline-value {
        font-size: .82rem;
        font-weight: 600;
        color: var(--text);
    }

    /* Status card */
    .status-card-body {
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .status-icon svg { width: 18px; height: 18px; }

    .status-info-label { font-size: .68rem; color: var(--dim); text-transform: uppercase; letter-spacing: .06em; }
    .status-info-value { font-size: .92rem; font-weight: 700; color: var(--text); }

    /* ── BACK LINK ── */
    .ann-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .78rem;
        font-weight: 600;
        color: var(--muted);
        text-decoration: none;
        padding: 8px 14px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        background: var(--surface);
        transition: all var(--t);
        margin-bottom: 16px;
    }

    .ann-back:hover { border-color: var(--accent); color: var(--accent); text-decoration: none; }
    .ann-back svg { width: 14px; height: 14px; }

    /* ── RELATED ANNOUNCEMENTS ── */
    .related-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
        color: inherit;
        transition: color var(--t);
    }

    .related-item:last-child { border-bottom: none; padding-bottom: 0; }
    .related-item:first-child { padding-top: 0; }

    .related-item:hover .related-title { color: var(--accent); }

    .related-title {
        font-size: .82rem;
        font-weight: 600;
        color: var(--text);
        transition: color var(--t);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .related-date { font-size: .7rem; color: var(--dim); }

    /* ── ANIMATIONS ── */
    .ann-article { animation: fadeUp .4s ease both; }
    .ann-sidebar > * { animation: fadeUp .4s ease both; }
    .ann-sidebar > *:nth-child(2) { animation-delay: .08s; }
    .ann-sidebar > *:nth-child(3) { animation-delay: .14s; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    /* ── View count chip ── */
    .view-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: .75rem;
        font-weight: 600;
        color: var(--clr-muted);
    }

    .view-chip svg { width: 14px; height: 14px; opacity: .7; }
</style>

@section('content')

@php
    $status = $announcement->status ?? 'active';
    $now = now();
    if ($announcement->end_date && $announcement->end_date->isPast()) $status = 'expired';

    $statusLabels = [
        'active'   => ['label' => 'Active',    'color' => '#1E7A5A', 'bg' => 'var(--green-bg)'],
        'inactive' => ['label' => 'Inactive',  'color' => '#DC2626', 'bg' => 'var(--red-bg)'],
        'draft'    => ['label' => 'Draft',     'color' => '#B45309', 'bg' => 'var(--amber-bg)'],
        'expired'  => ['label' => 'Expired',   'color' => '#7A736B', 'bg' => 'rgba(0,0,0,.05)'],
    ];

    $st = $statusLabels[$status] ?? $statusLabels['active'];
@endphp

{{-- ── HERO ── --}}
<div class="ann-hero">
    <div class="container ann-hero-inner">

        {{-- Breadcrumb --}}
        <div class="ann-breadcrumb">
            <a href="{{ route('front.announcements.index') }}">Announcements</a>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6"/>
            </svg>
            <span>{{ Str::limit($announcement->title, 50) }}</span>
        </div>

        {{-- Status --}}
        <div class="ann-hero-tags">
            <span class="ann-status {{ $status }}">{{ $st['label'] }}</span>
        </div>

        {{-- Title --}}
        <h1>{{ $announcement->title }}</h1>

        {{-- Meta --}}
        <div class="ann-hero-meta">
            <div class="ann-hero-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM7 11h5v5H7z"/>
                </svg>
                Published <strong>{{ $announcement->created_at->format('d M Y') }}</strong>
            </div>

            @if($announcement->creator)
            <div class="ann-hero-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
                By <strong>{{ $announcement->creator->name }}</strong>
            </div>
            @endif

            @if($announcement->start_date)
            <div class="ann-hero-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
                Active from <strong>{{ $announcement->start_date->format('d M Y') }}</strong>
                @if($announcement->end_date)
                    to <strong>{{ $announcement->end_date->format('d M Y') }}</strong>
                @endif
            </div>
            @endif
        </div>

    </div>
</div>

{{-- ── BODY ── --}}
<div class="container">
    <div class="ann-layout">

        {{-- ARTICLE ── --}}
        <div>
            <a href="{{ route('front.announcements.index') }}" class="ann-back">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Back to Announcements
            </a>

            <article class="ann-article">
                <div class="ann-article-header">
                    <div class="ann-article-header-left">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                        </svg>
                        Official Announcement · {{ $announcement->created_at->format('d F Y') }}
                    </div>

                    <button class="ann-share-btn" onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' style=\'width:13px;height:13px\'><path d=\'M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z\'/></svg> Copied!'">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                            <path d="M8.59 13.51l6.83 3.98M15.41 6.51l-6.82 3.98"/>
                        </svg>
                        Share
                    </button>
                </div>

                <div class="ann-content">
                    {!! $announcement->content !!}
                </div>
            </article>
        </div>

        {{-- SIDEBAR ── --}}
        <aside class="ann-sidebar">

            {{-- Current Status ── --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">Status</div>
                <div class="status-card-body">
                    <div class="status-icon" style="background:{{ $st['bg'] }}">
                        @if($status === 'active')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $st['color'] }}">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                        </svg>
                        @elseif($status === 'expired')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $st['color'] }}">
                            <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="{{ $st['color'] }}">
                            <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        @endif
                    </div>
                    <div>
                        <div class="status-info-label">Current Status</div>
                        <div class="status-info-value" style="color:{{ $st['color'] }}">{{ $st['label'] }}</div>
                    </div>
                    {{-- ── View count (total, human-formatted) ── --}}
                    @if($announcement->views_count > 0)
                    <span class="view-chip">
                        {{-- Eye icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                        {{ number_format($announcement->views_count) }} {{ Str::plural('view', $announcement->views_count) }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- Timeline ── --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">Timeline</div>
                <div class="ann-timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot done">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <div class="timeline-info">
                            <div class="timeline-label">Published</div>
                            <div class="timeline-value">{{ $announcement->created_at->format('d M Y') }}</div>
                        </div>
                    </div>

                    @if($announcement->start_date)
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $announcement->start_date->isPast() ? 'done' : 'now' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </div>
                        <div class="timeline-info">
                            <div class="timeline-label">Start Date</div>
                            <div class="timeline-value">{{ $announcement->start_date->format('d M Y') }}</div>
                        </div>
                    </div>
                    @endif

                    @if($announcement->end_date)
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $announcement->end_date->isPast() ? 'done' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 6h2v12H6zm3.5 6l8.5 6V6z"/>
                            </svg>
                        </div>
                        <div class="timeline-info">
                            <div class="timeline-label">End Date</div>
                            <div class="timeline-value">{{ $announcement->end_date->format('d M Y') }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="timeline-item">
                        <div class="timeline-dot">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                            </svg>
                        </div>
                        <div class="timeline-info">
                            <div class="timeline-label">Last Updated</div>
                            <div class="timeline-value">{{ $announcement->updated_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Details ── --}}
            <div class="sidebar-card">
                <div class="sidebar-card-header">Details</div>
                <div class="sidebar-card-body">
                    <div class="sidebar-detail">
                        @if($announcement->creator)
                        <div class="sidebar-detail-row">
                            <span class="sidebar-detail-label">Posted by</span>
                            <span class="sidebar-detail-value">{{ $announcement->creator->name }}</span>
                        </div>
                        @endif

                        <div class="sidebar-detail-row">
                            <span class="sidebar-detail-label">Published</span>
                            <span class="sidebar-detail-value">{{ $announcement->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="sidebar-detail-row">
                            <span class="sidebar-detail-label">Reference ID</span>
                            <span class="sidebar-detail-value" style="font-family:monospace;font-size:.75rem;color:var(--muted)">
                                ANN-{{ str_pad($announcement->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related ── --}}
            @if(isset($related) && $related->count())
            <div class="sidebar-card">
                <div class="sidebar-card-header">Related Announcements</div>
                <div class="sidebar-card-body" style="padding-top:4px;padding-bottom:4px">
                    @foreach($related as $rel)
                    <a href="{{ route('front.announcements.show', $rel->slug) }}" class="related-item">
                        <span class="related-title">{{ $rel->title }}</span>
                        <span class="related-date">{{ $rel->created_at->format('d M Y') }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </aside>
    </div>
</div>

@endsection