@extends('layouts.app')
@section('title', $blog->title . ' — Blog')
@section('content')

<style>
    :root {
        --accent: #c9a96e;
        --danger: #dc3545;
        --border: #e2e8f0;
        --surface: #f8fafc;
        --muted: #94a3b8;
        --text: #1e293b;
        --text-dim: #64748b;
        --radius: 10px;
        --rose: #e11d48;
        --rose-lt: #fb7185;
        --green: #22c55e;
        --amber: #f59e0b;
    }

    .bs-page {
        padding: 1.75rem 0 3rem;
        max-width: 1160px;
        margin: 0 auto;
    }

    .bs-breadcrumb {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .78rem;
        color: var(--muted);
        margin-bottom: 1.5rem;
    }

    .bs-breadcrumb a {
        color: var(--muted);
        text-decoration: none;
    }

    .bs-breadcrumb a:hover {
        color: var(--rose);
    }

    .bs-alert {
        border-radius: 8px;
        padding: .85rem 1.1rem;
        font-size: .84rem;
        display: flex;
        gap: .6rem;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .bs-alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .bs-alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    .bs-layout {
        display: grid;
        grid-template-columns: 1fr 280px;
        gap: 1.25rem;
        align-items: start;
    }

    .bs-main {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .bs-side {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        position: sticky;
        top: 80px;
    }

    .bs-btn {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .6rem 1.2rem;
        border-radius: 8px;
        font-size: .84rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        font-family: inherit;
    }

    .bs-btn-primary {
        background: var(--rose);
        color: #fff;
    }

    .bs-btn-primary:hover {
        background: var(--rose-lt);
        color: #fff;
    }

    .bs-btn-ghost {
        background: none;
        border: 1.5px solid var(--border);
        color: var(--text-dim);
    }

    .bs-btn-ghost:hover {
        border-color: var(--rose);
        color: var(--rose);
    }

    .bs-btn-danger {
        background: none;
        border: 1.5px solid #fecaca;
        color: var(--danger);
    }

    .bs-btn-danger:hover {
        background: #fef2f2;
    }

    .bs-btn-warning {
        background: none;
        border: 1.5px solid #fde68a;
        color: #92400e;
    }

    .bs-btn-warning:hover {
        background: #fffbeb;
    }

    .bs-btn-green {
        background: none;
        border: 1.5px solid #bbf7d0;
        color: var(--green);
    }

    .bs-btn-green:hover {
        background: #f0fdf4;
    }

    .bs-btn-sm {
        padding: .38rem .85rem;
        font-size: .78rem;
    }

    /* hero */
    .bs-hero {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .bs-hero-img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        display: block;
    }

    .bs-hero-img-placeholder {
        width: 100%;
        height: 140px;
        background: linear-gradient(135deg, #fce7f3, #fbe2e7, #fce7f3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--rose-lt);
    }

    .bs-hero-body {
        padding: 1.75rem 2rem;
    }

    .bs-hero-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: .75rem;
        font-size: .8rem;
        color: var(--muted);
        margin-bottom: 1rem;
    }

    .bs-hero-meta span {
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .bs-badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .24rem .7rem;
        border-radius: 100px;
        font-size: .71rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .bs-badge-pub {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .bs-badge-draft {
        background: #fffbeb;
        border: 1px solid #fde68a;
        color: #92400e;
    }

    .bs-badge-cat {
        background: #fce7f3;
        border: 1px solid #fbcfe8;
        color: var(--rose);
    }

    .bs-hero-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 .5rem;
        line-height: 1.3;
    }

    .bs-hero-actions {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border);
    }

    /* cards */
    .bs-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }

    .bs-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .9rem 1.4rem;
        border-bottom: 1px solid var(--border);
        background: var(--surface);
    }

    .bs-card-header-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: #fce7f318;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--rose);
        flex-shrink: 0;
    }

    .bs-card-header h6 {
        margin: 0;
        font-size: .86rem;
        font-weight: 600;
        color: var(--text);
    }

    .bs-card-action {
        margin-left: auto;
    }

    .bs-card-body {
        padding: 1.4rem;
    }

    /* content */
    .bs-content {
        font-size: .93rem;
        color: var(--text-dim);
        line-height: 1.9;
        white-space: pre-line;
    }

    /* info grid */
    .bs-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: var(--border);
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .bs-info-cell {
        background: #fff;
        padding: .85rem 1rem;
        transition: background .15s;
    }

    .bs-info-cell:hover {
        background: var(--surface);
    }

    .bs-info-key {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: .3rem;
    }

    .bs-info-val {
        font-size: .88rem;
        color: var(--text);
        font-weight: 500;
    }

    .bs-info-val.rose {
        color: var(--rose);
    }

    .bs-info-val.mono {
        font-family: monospace;
        font-size: .82rem;
    }

    /* author card */
    .bs-author-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
    }

    .bs-author-av {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--rose), var(--rose-lt));
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .9rem;
        color: #fff;
        flex-shrink: 0;
    }

    .bs-author-name {
        font-size: .92rem;
        font-weight: 600;
        color: var(--text);
    }

    .bs-author-sub {
        font-size: .75rem;
        color: var(--muted);
        margin-top: .15rem;
    }

    /* actions */
    .bs-action-btn {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .65rem .9rem;
        border-radius: 8px;
        border: 1.5px solid var(--border);
        background: none;
        font-family: inherit;
        font-size: .82rem;
        font-weight: 500;
        cursor: pointer;
        transition: all .15s;
        color: var(--text-dim);
        text-align: left;
        width: 100%;
        text-decoration: none;
    }

    .bs-action-btn:hover {
        border-color: var(--rose);
        color: var(--text);
        background: #fce7f304;
    }

    .bs-action-btn.green:hover {
        border-color: #bbf7d0;
        color: var(--green);
        background: #f0fdf4;
    }

    .bs-action-btn.warning:hover {
        border-color: #fde68a;
        color: #92400e;
        background: #fffbeb;
    }

    .bs-action-btn.danger:hover {
        border-color: #fecaca;
        color: var(--danger);
        background: #fef2f2;
    }

    .bs-actions-list {
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    /* timeline */
    .bs-tl {
        display: flex;
        flex-direction: column;
    }

    .bs-tl-item {
        display: flex;
        gap: 1rem;
        padding-bottom: 1.25rem;
    }

    .bs-tl-item:last-child {
        padding-bottom: 0;
    }

    .bs-tl-left {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-shrink: 0;
    }

    .bs-tl-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid var(--border);
        background: #fff;
        color: var(--muted);
        flex-shrink: 0;
    }

    .bs-tl-dot.rose {
        border-color: #fbcfe8;
        background: #fce7f3;
        color: var(--rose);
    }

    .bs-tl-dot.green {
        border-color: #bbf7d0;
        background: #f0fdf4;
        color: var(--green);
    }

    .bs-tl-dot.amber {
        border-color: #fde68a;
        background: #fffbeb;
        color: var(--amber);
    }

    .bs-tl-line {
        width: 1px;
        flex: 1;
        background: var(--border);
        margin-top: 4px;
        min-height: 16px;
    }

    .bs-tl-item:last-child .bs-tl-line {
        display: none;
    }

    .bs-tl-content {
        flex: 1;
        padding-top: .2rem;
    }

    .bs-tl-title {
        font-size: .86rem;
        font-weight: 600;
        color: var(--text);
    }

    .bs-tl-meta {
        font-size: .76rem;
        color: var(--muted);
        margin-top: .2rem;
    }

    /* modal */
    .bs-modal .modal-content {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 8px 32px rgba(0, 0, 0, .12);
        overflow: hidden;
    }

    .bs-modal .modal-header {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 1rem 1.4rem;
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .bs-modal-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: #fef2f2;
        color: var(--danger);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .bs-modal .modal-title {
        font-size: .92rem;
        font-weight: 700;
        color: var(--danger);
        margin: 0;
    }

    .bs-modal .modal-body {
        padding: 1.4rem;
    }

    .bs-modal .modal-footer {
        padding: .85rem 1.4rem;
        border-top: 1px solid var(--border);
        gap: .5rem;
    }

    .bs-delete-box {
        font-size: .87rem;
        color: var(--text-dim);
        line-height: 1.6;
        padding: .85rem 1rem;
        border-radius: 8px;
        border: 1px solid #fecaca;
        background: #fef2f2;
    }

    .bs-delete-box strong {
        color: var(--text);
    }

    @media(max-width:960px) {
        .bs-layout {
            grid-template-columns: 1fr;
        }

        .bs-side {
            position: static;
        }

        .bs-info-grid {
            grid-template-columns: 1fr;
        }
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

<div class="bs-page">
    <nav class="bs-breadcrumb">
        <a href="{{ route('admin.blogs.index') }}">Blog Posts</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m9 18 6-6-6-6" />
        </svg>
        <span style="color:var(--text-dim)">{{ Str::limit($blog->title, 50) }}</span>
    </nav>

    @if(session('success'))
    <div class="bs-alert bs-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bs-alert bs-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 8v4m0 4h.01" />
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="bs-layout">

        {{-- ── MAIN ── --}}
        <div class="bs-main">

            {{-- Hero --}}
            <div class="bs-hero">
                @if($blog->featured_image)
                <img src="{{ asset('storage/'.$blog->featured_image) }}" alt="{{ $blog->title }}" class="bs-hero-img">
                @else
                <div class="bs-hero-img-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <circle cx="9" cy="9" r="2" />
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                    </svg>
                </div>
                @endif
                <div class="bs-hero-body">
                    <div class="bs-hero-meta">
                        @if($blog->is_published)
                        <span class="bs-badge bs-badge-pub"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="7" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="10" />
                            </svg>Published</span>
                        @else
                        <span class="bs-badge bs-badge-draft">Draft</span>
                        @endif
                        @if($blog->category)
                        <span class="bs-badge bs-badge-cat">{{ $blog->category->name }}</span>
                        @endif
                        @if($blog->published_at)
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            {{ $blog->published_at->format('F j, Y') }}
                        </span>
                        @endif
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                            </svg>
                            {{ $blog->author?->name ?? '—' }}
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="17" x2="3" y1="10" y2="10" />
                                <line x1="21" x2="3" y1="6" y2="6" />
                                <line x1="21" x2="3" y1="14" y2="14" />
                            </svg>
                            {{ str_word_count(strip_tags($blog->content)) }} words
                        </span>
                    </div>
                    <h1 class="bs-hero-title">{{ $blog->title }}</h1>
                    <p style="font-size:.82rem;font-family:monospace;color:var(--muted)">blog/{{ $blog->slug }}</p>
                    <div class="bs-hero-actions">
                        <a href="{{ route('admin.blogs.edit',$blog->id) }}" class="bs-btn bs-btn-primary bs-btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit Post
                        </a>
                        <form method="POST" action="{{ route('admin.blogs.toggle',$blog->id) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="bs-btn bs-btn-sm {{ $blog->is_published ? 'bs-btn-warning' : 'bs-btn-green' }}">
                                @if($blog->is_published)
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                    <line x1="1" x2="23" y1="1" y2="23" />
                                </svg>
                                Unpublish
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                                Publish
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Meta --}}
            <div class="bs-card">
                <div class="bs-card-header">
                    <div class="bs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect width="20" height="14" x="2" y="7" rx="2" />
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                        </svg></div>
                    <h6>Post Details</h6>
                    <a href="{{ route('admin.blogs.edit',$blog->id) }}" class="bs-card-action bs-btn bs-btn-ghost bs-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Edit
                    </a>
                </div>
                <div class="bs-card-body" style="padding:0">
                    <div class="bs-info-grid">
                        <div class="bs-info-cell">
                            <div class="bs-info-key">Title</div>
                            <div class="bs-info-val">{{ $blog->title }}</div>
                        </div>
                        <div class="bs-info-cell">
                            <div class="bs-info-key">Slug</div>
                            <div class="bs-info-val mono">{{ $blog->slug }}</div>
                        </div>
                        <div class="bs-info-cell">
                            <div class="bs-info-key">Category</div>
                            <div class="bs-info-val rose">{{ $blog->category?->name ?? '—' }}</div>
                        </div>
                        <div class="bs-info-cell">
                            <div class="bs-info-key">Status</div>
                            <div class="bs-info-val">
                                <span class="bs-badge {{ $blog->is_published ? 'bs-badge-pub' : 'bs-badge-draft' }}">{{ $blog->is_published ? 'Published' : 'Draft' }}</span>
                            </div>
                        </div>
                        <div class="bs-info-cell">
                            <div class="bs-info-key">Published At</div>
                            <div class="bs-info-val">{{ $blog->published_at?->format('M j, Y g:i A') ?? '—' }}</div>
                        </div>
                        <div class="bs-info-cell">
                            <div class="bs-info-key">Word Count</div>
                            <div class="bs-info-val">{{ number_format(str_word_count(strip_tags($blog->content))) }} words</div>
                        </div>
                        <div class="bs-info-cell">
                            <div class="bs-info-key">Created</div>
                            <div class="bs-info-val">{{ $blog->created_at->format('M j, Y') }}</div>
                        </div>
                        <div class="bs-info-cell">
                            <div class="bs-info-key">Updated</div>
                            <div class="bs-info-val">{{ $blog->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content preview --}}
            <div class="bs-card">
                <div class="bs-card-header">
                    <div class="bs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="17" x2="3" y1="10" y2="10" />
                            <line x1="21" x2="3" y1="6" y2="6" />
                            <line x1="21" x2="3" y1="14" y2="14" />
                            <line x1="13" x2="3" y1="18" y2="18" />
                        </svg></div>
                    <h6>Content</h6>
                </div>
                <div class="bs-card-body">
                    <div class="bs-content">{{ $blog->content }}</div>
                </div>
            </div>

        </div>{{-- /.bs-main --}}

        {{-- ── SIDE ── --}}
        <div class="bs-side">

            {{-- Author --}}
            <div class="bs-card">
                <div class="bs-author-card">
                    <div class="bs-author-av">{{ strtoupper(substr($blog->author?->name ?? '?', 0, 2)) }}</div>
                    <div>
                        <div class="bs-author-name">{{ $blog->author?->name ?? 'Unknown' }}</div>
                        <div class="bs-author-sub">{{ $blog->author?->email ?? '—' }}</div>
                    </div>
                </div>
            </div>
            {{-- ── VIEW ANALYTICS CARD ─────────────────────────────────────── --}}
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold mb-0" style="color:var(--terra-navy);font-size:.88rem">👁 View Analytics</h6>
                    @if($blog->status !== 'active')
                    <span style="font-size:.68rem;color:#7A736B;background:#F5F5F5;padding:2px 8px;border-radius:10px">
                        Only tracked when active
                    </span>
                    @endif
                </div>

                {{-- Top counters ── --}}
                <div class="card-body p-0">
                    <div class="row g-0" style="border-bottom:1px solid #E8E3DC">

                        {{-- Total views --}}
                        <div class="col-6" style="padding:16px 20px;border-right:1px solid #E8E3DC">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Total Views</div>
                            <div style="font-size:1.6rem;font-weight:800;color:var(--terra-navy);line-height:1">
                                {{ number_format($viewStats['total']) }}
                            </div>
                            <div style="font-size:.7rem;color:#7A736B;margin-top:3px">all time</div>
                        </div>

                        {{-- Unique views --}}
                        <div class="col-6" style="padding:16px 20px">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Unique Visitors</div>
                            <div style="font-size:1.6rem;font-weight:800;color:#1a5276;line-height:1">
                                {{ number_format($viewStats['unique']) }}
                            </div>
                            <div style="font-size:.7rem;color:#7A736B;margin-top:3px">distinct IPs</div>
                        </div>
                    </div>

                    {{-- Period breakdown ── --}}
                    <div style="padding:12px 20px;border-bottom:1px solid #E8E3DC">
                        @php
                        $periods = [
                        ['label' => 'Today', 'value' => $viewStats['today']],
                        ['label' => 'This Week', 'value' => $viewStats['this_week']],
                        ['label' => 'This Month', 'value' => $viewStats['this_month']],
                        ];
                        // Compute the max for the tiny bar widths
                        $maxPeriod = max(max(array_column($periods, 'value')), 1);
                        @endphp

                        @foreach($periods as $period)
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <div style="width:72px;font-size:.72rem;color:#7A736B;flex-shrink:0">{{ $period['label'] }}</div>
                            <div style="flex:1;height:6px;background:#F0EDE8;border-radius:3px;overflow:hidden">
                                <div style="height:100%;width:{{ $maxPeriod > 0 ? round(($period['value'] / $maxPeriod) * 100) : 0 }}%;background:var(--terra-navy);border-radius:3px;transition:width .4s ease"></div>
                            </div>
                            <div style="width:28px;text-align:right;font-size:.78rem;font-weight:700;color:var(--terra-navy);flex-shrink:0">
                                {{ number_format($period['value']) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- 14-day sparkline ── --}}
                    <div style="padding:16px 20px">
                        <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px">
                            Last 14 Days
                        </div>

                        @php
                        $chartData = $viewStats['daily_chart']; // ['Y-m-d' => count]
                        $chartMax = max(array_values($chartData) ?: [1]);
                        $chartDates = array_keys($chartData);
                        $chartVals = array_values($chartData);
                        $barCount = count($chartVals);
                        @endphp

                        @if(array_sum($chartVals) === 0)
                        <div style="text-align:center;padding:20px 0;color:#7A736B;font-size:.78rem">
                            No views recorded in the last 14 days.
                        </div>
                        @else
                        {{-- SVG sparkline --}}
                        <svg viewBox="0 0 280 60" xmlns="http://www.w3.org/2000/svg"
                            style="width:100%;height:60px;overflow:visible"
                            aria-label="Daily views chart">

                            {{-- Grid lines --}}
                            <line x1="0" y1="0" x2="280" y2="0" stroke="#E8E3DC" stroke-width=".5" />
                            <line x1="0" y1="30" x2="280" y2="30" stroke="#E8E3DC" stroke-width=".5" stroke-dasharray="3,3" />
                            <line x1="0" y1="59" x2="280" y2="59" stroke="#E8E3DC" stroke-width=".5" />

                            @php
                            $barW = floor(280 / $barCount) - 2;
                            $barW = max($barW, 4);
                            $gap = (280 - ($barW * $barCount)) / ($barCount + 1);
                            @endphp

                            @foreach($chartVals as $i => $val)
                            @php
                            $barH = $chartMax > 0 ? max(2, round(($val / $chartMax) * 56)) : 2;
                            $x = round($gap + $i * ($barW + $gap));
                            $y = 58 - $barH;
                            $isLast = $i === $barCount - 1;
                            @endphp
                            <rect x="{{ $x }}" y="{{ $y }}"
                                width="{{ $barW }}" height="{{ $barH }}"
                                rx="2"
                                fill="{{ $isLast ? 'var(--terra-navy, #19265d)' : '#B8C5D6' }}"
                                opacity="{{ $isLast ? '1' : '0.6' }}">
                                <title>{{ $chartDates[$i] }}: {{ $val }} view{{ $val === 1 ? '' : 's' }}</title>
                            </rect>
                            @endforeach
                        </svg>

                        {{-- x-axis labels: first, mid, last --}}
                        <div style="display:flex;justify-content:space-between;margin-top:4px">
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse($chartDates[0])->format('d M') }}
                            </span>
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse($chartDates[floor($barCount/2)])->format('d M') }}
                            </span>
                            <span style="font-size:.62rem;color:#7A736B">
                                {{ \Carbon\Carbon::parse(end($chartDates))->format('d M') }}
                            </span>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            {{-- ── END VIEW ANALYTICS CARD ─────────────────────────────────── --}}
            {{-- Quick actions --}}
            <div class="bs-card">
                <div class="bs-card-header">
                    <div class="bs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg></div>
                    <h6>Quick Actions</h6>
                </div>
                <div class="bs-card-body">
                    <div class="bs-actions-list">
                        <a href="{{ route('admin.blogs.edit',$blog->id) }}" class="bs-action-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit Post
                        </a>
                        <form method="POST" action="{{ route('admin.blogs.toggle',$blog->id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="bs-action-btn {{ $blog->is_published ? 'warning' : 'green' }}">
                                @if($blog->is_published)
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                    <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8" />
                                    <line x1="1" x2="23" y1="1" y2="23" />
                                </svg>
                                Unpublish Post
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                                Publish Post
                                @endif
                            </button>
                        </form>
                        <button class="bs-action-btn danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                            </svg>
                            Delete Post
                        </button>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="bs-card">
                <div class="bs-card-header">
                    <div class="bs-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg></div>
                    <h6>Activity</h6>
                </div>
                <div class="bs-card-body">
                    <div class="bs-tl">
                        <div class="bs-tl-item">
                            <div class="bs-tl-left">
                                <div class="bs-tl-dot rose"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M20 6 9 17l-5-5" />
                                    </svg></div>
                                <div class="bs-tl-line"></div>
                            </div>
                            <div class="bs-tl-content">
                                <div class="bs-tl-title">Post created</div>
                                <div class="bs-tl-meta">{{ $blog->created_at->format('F j, Y g:i A') }} by {{ $blog->author?->name }}</div>
                            </div>
                        </div>
                        @if($blog->is_published && $blog->published_at)
                        <div class="bs-tl-item">
                            <div class="bs-tl-left">
                                <div class="bs-tl-dot green"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg></div>
                                <div class="bs-tl-line"></div>
                            </div>
                            <div class="bs-tl-content">
                                <div class="bs-tl-title">Published</div>
                                <div class="bs-tl-meta">{{ $blog->published_at->format('F j, Y g:i A') }} — {{ $blog->published_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endif
                        <div class="bs-tl-item">
                            <div class="bs-tl-left">
                                <div class="bs-tl-dot"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg></div>
                            </div>
                            <div class="bs-tl-content">
                                <div class="bs-tl-title">Last updated</div>
                                <div class="bs-tl-meta">{{ $blog->updated_at->format('F j, Y g:i A') }} — {{ $blog->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danger zone --}}
            <div class="bs-card" style="border-color:#fecaca;">
                <div class="bs-card-header" style="background:#fef2f2;border-color:#fecaca;">
                    <div class="bs-card-header-icon" style="background:#fee2e2;color:var(--danger);"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                            <line x1="12" x2="12" y1="9" y2="13" />
                        </svg></div>
                    <h6 style="color:var(--danger)">Danger Zone</h6>
                </div>
                <div class="bs-card-body">
                    <p style="font-size:.82rem;color:var(--muted);margin-bottom:1rem;line-height:1.55;">Permanently deletes this blog post and its featured image.</p>
                    <button class="bs-btn bs-btn-danger" style="width:100%;justify-content:center;" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                            <path d="M10 11v6M14 11v6" />
                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                        </svg>
                        Delete Post
                    </button>
                </div>
            </div>

        </div>{{-- /.bs-side --}}
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade bs-modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('admin.blogs.destroy',$blog->id) }}" class="modal-content">
            @csrf @method('DELETE')
            <div class="modal-header">
                <div class="bs-modal-icon"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                        <line x1="12" x2="12" y1="9" y2="13" />
                        <line x1="12" x2="12.01" y1="17" y2="17" />
                    </svg></div>
                <h5 class="modal-title">Delete Post</h5>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="bs-delete-box">Permanently delete <strong>{{ $blog->title }}</strong>? The featured image will also be removed.<br><br><span style="font-size:.79rem;color:var(--danger)">⚠ This action cannot be undone.</span></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="bs-btn bs-btn-ghost bs-btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="bs-btn bs-btn-danger bs-btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                    </svg>
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

@endsection