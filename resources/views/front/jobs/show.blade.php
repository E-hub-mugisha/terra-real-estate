@extends('layouts.guest')
@section('title', $job->title . ' — ' . $job->company_name)

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap');

    :root {
        --clr-bg: #F7F5F2;
        --clr-surface: #FFFFFF;
        --clr-border: #E8E3DC;
        --clr-text: #19265d;
        --clr-muted: #7A736B;
        --clr-accent: #D05208;
        --clr-job: #1a5276;
        --clr-job-light: #EBF5FB;
        --radius-card: 14px;
        --shadow-card: 0 2px 12px rgba(0,0,0,.07), 0 1px 3px rgba(0,0,0,.05);
        --transition: .22s cubic-bezier(.4,0,.2,1);
    }

    body { background: var(--clr-bg); font-family: 'DM Sans', sans-serif; }

    /* ── Hero ── */
    .job-hero {
        background: var(--clr-surface);
        border-bottom: 1px solid var(--clr-border);
        padding: 100px 0 32px;
    }

    .job-hero-inner {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
    }

    .company-logo-lg {
        width: 72px; height: 72px;
        border-radius: 14px;
        border: 1px solid var(--clr-border);
        object-fit: cover;
        background: var(--clr-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--clr-text);
        flex-shrink: 0;
    }

    .job-hero-info { flex: 1; min-width: 0; }

    .job-hero-info h1 {
        font-family: 'DM Serif Display', serif;
        font-size: clamp(1.4rem, 3vw, 2rem);
        color: var(--clr-text);
        font-weight: 400;
        margin-bottom: 6px;
    }

    .job-hero-company {
        font-size: .9rem;
        color: var(--clr-muted);
        margin-bottom: 16px;
    }

    .job-hero-company a { color: var(--clr-job); text-decoration: none; }
    .job-hero-company a:hover { text-decoration: underline; }

    .job-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 16px; }

    .job-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 600;
    }

    .badge-type { background: var(--clr-job-light); color: var(--clr-job); }
    .badge-cat  { background: #F5F5F5; color: var(--clr-muted); }

    .job-meta-row {
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        font-size: .82rem;
        color: var(--clr-muted);
    }

    .job-meta-row span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .job-meta-row svg { width: 14px; height: 14px; }

    /* ── Countdown bar ── */
    .countdown-bar {
        background: var(--clr-bg);
        border-bottom: 1px solid var(--clr-border);
        padding: 10px 0;
    }

    .countdown-inner {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .8rem;
        color: var(--clr-muted);
    }

    .countdown-inner.urgent { color: #e53e3e; }

    .days-pill {
        padding: 3px 10px;
        border-radius: 20px;
        font-size: .75rem;
        font-weight: 700;
        background: #FEF3E2;
        color: var(--clr-accent);
    }

    .days-pill.urgent { background: #FFF5F5; color: #e53e3e; }

    /* ── Layout ── */
    .job-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px;
        padding: 32px 0 60px;
    }

    @media (max-width: 900px) {
        .job-layout { grid-template-columns: 1fr; }
    }

    /* ── Content sections ── */
    .content-card {
        background: var(--clr-surface);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-card);
        padding: 28px;
        box-shadow: var(--shadow-card);
        margin-bottom: 20px;
    }

    .content-card h2 {
        font-family: 'DM Serif Display', serif;
        font-size: 1.1rem;
        font-weight: 400;
        color: var(--clr-text);
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--clr-border);
    }

    .content-card p, .content-card li {
        font-size: .88rem;
        color: var(--clr-muted);
        line-height: 1.75;
    }

    .content-card ul { padding-left: 20px; }
    .content-card ul li { margin-bottom: 6px; }

    /* ── Sidebar ── */
    .sidebar-card {
        background: var(--clr-surface);
        border: 1px solid var(--clr-border);
        border-radius: var(--radius-card);
        padding: 22px;
        box-shadow: var(--shadow-card);
        margin-bottom: 16px;
    }

    .sidebar-card h3 {
        font-size: .8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--clr-muted);
        margin-bottom: 16px;
    }

    .sidebar-detail {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .sidebar-detail-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .sidebar-detail-item svg {
        width: 16px; height: 16px;
        color: var(--clr-accent);
        flex-shrink: 0;
        margin-top: 2px;
    }

    .sidebar-detail-label {
        font-size: .72rem;
        color: var(--clr-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        display: block;
        margin-bottom: 2px;
    }

    .sidebar-detail-value {
        font-size: .85rem;
        font-weight: 600;
        color: var(--clr-text);
    }

    .apply-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background: var(--clr-accent);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        transition: background var(--transition), transform var(--transition);
        margin-bottom: 10px;
    }

    .apply-btn:hover {
        background: #A06828;
        color: #fff;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .share-btn {
        display: block;
        width: 100%;
        padding: 10px;
        border: 1.5px solid var(--clr-border);
        border-radius: 8px;
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 600;
        color: var(--clr-muted);
        text-align: center;
        cursor: pointer;
        transition: all var(--transition);
    }

    .share-btn:hover { border-color: var(--clr-text); color: var(--clr-text); }

    .salary-highlight {
        background: linear-gradient(135deg, #FEF3E2 0%, #FFF8F0 100%);
        border: 1px solid #FDDCB5;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    .salary-highlight .label { font-size: .72rem; color: var(--clr-muted); text-transform: uppercase; letter-spacing: .05em; }
    .salary-highlight .value { font-size: 1.05rem; font-weight: 700; color: var(--clr-accent); margin-top: 4px; }
</style>

@section('content')

{{-- ── Job Hero ── --}}
<div class="job-hero">
    <div class="container">
        <div class="mb-3">
            <a href="{{ route('front.jobs.index') }}" style="font-size:.82rem;color:var(--clr-muted);text-decoration:none">
                ← Back to Jobs
            </a>
        </div>

        <div class="job-hero-inner">
            @if($job->company_logo)
                <img src="{{ asset('storage/' . $job->company_logo) }}" alt="{{ $job->company_name }}" class="company-logo-lg">
            @else
                <div class="company-logo-lg">{{ strtoupper(substr($job->company_name, 0, 1)) }}</div>
            @endif

            <div class="job-hero-info">
                <h1>{{ $job->title }}</h1>
                <div class="job-hero-company">
                    {{ $job->company_name }}
                    @if($job->company_website)
                    · <a href="{{ $job->company_website }}" target="_blank" rel="noopener">Website ↗</a>
                    @endif
                </div>

                <div class="job-badges">
                    <span class="job-badge badge-type">{{ $job->job_type_label }}</span>
                    @if($job->category)
                    <span class="job-badge badge-cat">{{ $job->category }}</span>
                    @endif
                </div>

                <div class="job-meta-row">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        {{ $job->location }}
                    </span>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                        Posted {{ $job->published_at?->format('d M Y') }}
                    </span>
                    @if($job->application_deadline)
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM7 11h5v5H7z"/>
                        </svg>
                        Deadline: {{ $job->application_deadline->format('d M Y') }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Countdown Bar ── --}}
<div class="countdown-bar">
    <div class="container">
        <div class="countdown-inner {{ $job->days_remaining <= 3 ? 'urgent' : '' }}">
            <span class="days-pill {{ $job->days_remaining <= 3 ? 'urgent' : '' }}">
                {{ $job->days_remaining }} day{{ $job->days_remaining === 1 ? '' : 's' }} remaining
            </span>
            This listing expires on {{ $job->expires_at?->format('d M Y') }}
        </div>
    </div>
</div>

{{-- ── Body ── --}}
<div class="container">
    <div class="job-layout">

        {{-- LEFT — Content ── --}}
        <div>
            <div class="content-card">
                <h2>Job Description</h2>
                <div>{!! nl2br(e($job->description)) !!}</div>
            </div>

            @if($job->requirements)
            <div class="content-card">
                <h2>Requirements</h2>
                <div>{!! nl2br(e($job->requirements)) !!}</div>
            </div>
            @endif

            @if($job->benefits)
            <div class="content-card">
                <h2>Benefits</h2>
                <div>{!! nl2br(e($job->benefits)) !!}</div>
            </div>
            @endif

            {{-- Apply section ── --}}
            <div class="content-card">
                <h2>How to Apply</h2>
                <p style="margin-bottom:16px">
                    Send your application to
                    <a href="mailto:{{ $job->application_email }}" style="color:var(--clr-accent);font-weight:600">
                        {{ $job->application_email }}
                    </a>
                    @if($job->application_deadline)
                    before <strong>{{ $job->application_deadline->format('d M Y') }}</strong>
                    @endif
                    .
                </p>
                @if($job->application_url)
                <a href="{{ $job->application_url }}" target="_blank" class="apply-btn" style="max-width:280px">
                    Apply via Website ↗
                </a>
                @else
                <a href="mailto:{{ $job->application_email }}" class="apply-btn" style="max-width:280px">
                    Apply by Email
                </a>
                @endif
            </div>
        </div>

        {{-- RIGHT — Sidebar ── --}}
        <div>
            {{-- CTA ── --}}
            <div class="sidebar-card">
                <div class="salary-highlight">
                    <div class="label">Salary</div>
                    <div class="value">{{ $job->salary_range }}</div>
                </div>

                @if($job->application_url)
                <a href="{{ $job->application_url }}" target="_blank" class="apply-btn">Apply Now ↗</a>
                @else
                <a href="mailto:{{ $job->application_email }}" class="apply-btn">Apply via Email</a>
                @endif

                <button class="share-btn" onclick="navigator.clipboard.writeText(window.location.href); this.textContent='Link Copied!'">
                    Share this Job
                </button>
            </div>

            {{-- Details ── --}}
            <div class="sidebar-card">
                <h3>Job Details</h3>
                <div class="sidebar-detail">
                    <div class="sidebar-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 6h-2.18c.07-.44.18-.88.18-1.33C18 2.54 15.46 0 12.33 0c-1.7 0-3.21.84-4.15 2.15L7 3 5.82 2.15C4.88.84 3.37 0 1.67 0H1v2h.67C2.9 2 3.96 2.6 4.6 3.5L6 5H4C2.9 5 2 5.9 2 7v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z"/>
                        </svg>
                        <div>
                            <span class="sidebar-detail-label">Job Type</span>
                            <span class="sidebar-detail-value">{{ $job->job_type_label }}</span>
                        </div>
                    </div>

                    <div class="sidebar-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                        <div>
                            <span class="sidebar-detail-label">Location</span>
                            <span class="sidebar-detail-value">{{ $job->location }}</span>
                        </div>
                    </div>

                    @if($job->category)
                    <div class="sidebar-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                        </svg>
                        <div>
                            <span class="sidebar-detail-label">Category</span>
                            <span class="sidebar-detail-value">{{ $job->category }}</span>
                        </div>
                    </div>
                    @endif

                    @if($job->application_deadline)
                    <div class="sidebar-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM7 11h5v5H7z"/>
                        </svg>
                        <div>
                            <span class="sidebar-detail-label">Application Deadline</span>
                            <span class="sidebar-detail-value">{{ $job->application_deadline->format('d M Y') }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="sidebar-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 18v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1h-9a2 2 0 00-2 2v8a2 2 0 002 2h9zm-9-2h10V8H12v8zm4-2.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                        </svg>
                        <div>
                            <span class="sidebar-detail-label">Company</span>
                            <span class="sidebar-detail-value">{{ $job->company_name }}</span>
                        </div>
                    </div>

                    @if($job->company_phone)
                    <div class="sidebar-detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                        <div>
                            <span class="sidebar-detail-label">Phone</span>
                            <span class="sidebar-detail-value">{{ $job->company_phone }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Back ── --}}
            <a href="{{ route('front.jobs.index') }}"
               style="display:block;text-align:center;font-size:.82rem;color:var(--clr-muted);text-decoration:none;padding:8px">
                ← All Jobs
            </a>
        </div>

    </div>
</div>

@endsection