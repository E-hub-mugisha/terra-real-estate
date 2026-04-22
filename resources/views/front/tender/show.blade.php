@extends('layouts.guest')
@section('title', $tender->title)
@section('content')

<style>
  .td-hero {
    background: linear-gradient(135deg, #19265d 0%, #1e3a8a 60%, #0f172a 100%);
    padding: 52px 0 36px;
    position: relative;
    overflow: hidden;
  }

  .td-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(200, 135, 58, .13) 0%, transparent 70%);
    pointer-events: none;
  }

  .td-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    margin-bottom: 14px;
  }

  .td-hero-badge.open {
    background: rgba(34, 197, 94, .15);
    color: #4ade80;
    border: 1px solid rgba(34, 197, 94, .3);
  }

  .td-hero-badge.closed {
    background: rgba(239, 68, 68, .15);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, .3);
  }

  .td-hero-badge svg {
    width: 8px;
    height: 8px;
    fill: currentColor;
  }

  .td-hero h1 {
    font-size: clamp(1.4rem, 3vw, 2rem);
    font-weight: 800;
    color: #fff;
    margin: 0 0 10px;
    line-height: 1.25;
  }

  .td-hero-ref {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255, 255, 255, .08);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 8px;
    padding: 5px 12px;
    font-size: .78rem;
    color: rgba(255, 255, 255, .6);
    font-weight: 500;
  }

  .td-hero-ref span {
    color: rgba(255, 255, 255, .9);
    font-weight: 600;
  }

  /* ── Layout ── */
  .td-wrap {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .td-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 28px;
    padding: 36px 0 60px;
    align-items: start;
  }

  @media(max-width:960px) {
    .td-grid {
      grid-template-columns: 1fr;
    }
  }

  /* ── Cards ── */
  .td-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(25, 38, 93, .06);
  }

  .td-card-head {
    padding: 20px 24px 0;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
  }

  .td-card-head-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    background: rgba(25, 38, 93, .07);
    display: grid;
    place-items: center;
    flex-shrink: 0;
  }

  .td-card-head-icon svg {
    width: 16px;
    height: 16px;
    color: #19265d;
  }

  .td-card-head h2 {
    font-size: .82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #19265d;
    margin: 0;
  }

  .td-card-body {
    padding: 20px 24px 24px;
  }

  .td-divider {
    height: 1px;
    background: #f0f2f8;
    margin: 20px 0;
  }

  /* ── Description ── */
  .td-description {
    font-size: .92rem;
    color: #374151;
    line-height: 1.75;
  }

  /* ── Meta grid ── */
  .td-meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
  }

  @media(max-width:560px) {
    .td-meta-grid {
      grid-template-columns: 1fr;
    }
  }

  .td-meta-item {
    background: #f8f9fd;
    border: 1px solid #eef0f8;
    border-radius: 12px;
    padding: 14px 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
  }

  .td-meta-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: grid;
    place-items: center;
    flex-shrink: 0;
    margin-top: 1px;
  }

  .td-meta-icon svg {
    width: 15px;
    height: 15px;
  }

  .td-meta-icon.gold {
    background: rgba(200, 135, 58, .1);
    color: #C8873A;
  }

  .td-meta-icon.blue {
    background: rgba(25, 38, 93, .08);
    color: #19265d;
  }

  .td-meta-icon.green {
    background: rgba(34, 197, 94, .1);
    color: #16a34a;
  }

  .td-meta-icon.red {
    background: rgba(239, 68, 68, .09);
    color: #dc2626;
  }

  .td-meta-label {
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #9ca3af;
    margin-bottom: 3px;
  }

  .td-meta-value {
    font-size: .9rem;
    font-weight: 700;
    color: #111827;
  }

  /* ── Document download ── */
  .td-doc-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 12px;
    background: #f8f9fd;
    border: 1.5px dashed #c7cde8;
    text-decoration: none;
    transition: all .2s;
    color: #19265d;
  }

  .td-doc-btn:hover {
    background: #eef0f8;
    border-color: #19265d;
    color: #19265d;
  }

  .td-doc-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #19265d;
    display: grid;
    place-items: center;
    flex-shrink: 0;
  }

  .td-doc-icon svg {
    width: 18px;
    height: 18px;
    color: #fff;
  }

  .td-doc-text strong {
    display: block;
    font-size: .88rem;
    font-weight: 700;
  }

  .td-doc-text span {
    font-size: .75rem;
    color: #6b7280;
  }

  .td-doc-arrow {
    margin-left: auto;
    color: #9ca3af;
  }

  .td-doc-arrow svg {
    width: 16px;
    height: 16px;
  }

  /* ── Sidebar ── */
  .td-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .td-owner-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #19265d, #1e3a8a);
    display: grid;
    place-items: center;
    flex-shrink: 0;
  }

  .td-owner-avatar svg {
    width: 22px;
    height: 22px;
    color: #fff;
  }

  .td-owner-info strong {
    display: block;
    font-size: .92rem;
    font-weight: 700;
    color: #111827;
  }

  .td-owner-info span {
    font-size: .78rem;
    color: #6b7280;
  }

  .td-posted {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8f9fd;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: .8rem;
    color: #6b7280;
  }

  .td-posted svg {
    width: 14px;
    height: 14px;
    color: #9ca3af;
  }

  .td-posted strong {
    color: #374151;
    font-weight: 600;
  }

  /* ── Apply button ── */
  .td-apply-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: .88rem;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all .2s;
    font-family: inherit;
  }

  .td-apply-btn.open {
    background: linear-gradient(135deg, #16a34a, #15803d);
    color: #fff;
    box-shadow: 0 4px 14px rgba(22, 163, 74, .3);
  }

  .td-apply-btn.open:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(22, 163, 74, .4);
    color: #fff;
  }

  .td-apply-btn.closed {
    background: #f3f4f6;
    color: #9ca3af;
    cursor: not-allowed;
  }

  .td-apply-btn svg {
    width: 16px;
    height: 16px;
  }

  /* ── Share strip ── */
  .td-share {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 14px 20px;
  }

  .td-share-label {
    font-size: .75rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-right: auto;
  }

  .td-share-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #f3f4f6;
    border: none;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: #6b7280;
    transition: background .2s, color .2s;
    text-decoration: none;
  }

  .td-share-btn:hover {
    background: #19265d;
    color: #fff;
  }

  .td-share-btn svg {
    width: 14px;
    height: 14px;
  }

  /* ── Breadcrumb ── */
  .td-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .75rem;
    color: rgba(255, 255, 255, .45);
    margin-bottom: 18px;
  }

  .td-breadcrumb a {
    color: rgba(255, 255, 255, .45);
    text-decoration: none;
  }

  .td-breadcrumb a:hover {
    color: rgba(255, 255, 255, .8);
  }

  .td-breadcrumb svg {
    width: 10px;
    height: 10px;
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

{{-- ── Hero ── --}}
<div class="td-hero">
  <div class="td-wrap">

    <div class="td-breadcrumb">
      <a href="{{ route('front.home') }}">Home</a>
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M9 18l6-6-6-6" />
      </svg>
      <a href="{{ route('front.tenders.index') }}">Tenders</a>
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M9 18l6-6-6-6" />
      </svg>
      <span>{{ Str::limit($tender->title, 40) }}</span>
    </div>

    <div class="td-hero-badge {{ $tender->is_open ? 'open' : 'closed' }}">
      <svg viewBox="0 0 8 8">
        <circle cx="4" cy="4" r="4" />
      </svg>
      {{ $tender->is_open ? 'Open for Applications' : 'Tender Closed' }}
    </div>

    <h1>{{ $tender->title }}</h1>

    <div class="td-hero-ref">
      Ref No: <span>{{ $tender->reference_no }}</span>
    </div>
    {{-- ── View count (total, human-formatted) ── --}}
    @if($job->views_count > 0)
    <span class="view-chip">
      {{-- Eye icon --}}
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
      </svg>
      {{ number_format($tender->views_count) }} {{ Str::plural('view', $tender->views_count) }}
    </span>
    @endif
  </div>
</div>

{{-- ── Body ── --}}
<div class="td-wrap">
  <div class="td-grid">

    {{-- ── Main column ── }}
    <div>

      {{-- Description --}}
      <div class="td-card" style="margin-bottom:20px">
        <div class="td-card-head">
          <div class="td-card-head-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
              <polyline points="14 2 14 8 20 8" />
              <line x1="16" y1="13" x2="8" y2="13" />
              <line x1="16" y1="17" x2="8" y2="17" />
            </svg>
          </div>
          <h2>Description</h2>
        </div>
        <div class="td-card-body">
          <p class="td-description">{{ $tender->description }}</p>
        </div>
      </div>

      {{-- Meta details --}}
      <div class="td-card" style="margin-bottom:20px">
        <div class="td-card-head">
          <div class="td-card-head-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <line x1="12" y1="8" x2="12" y2="12" />
              <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
          </div>
          <h2>Tender Details</h2>
        </div>
        <div class="td-card-body">
          <div class="td-meta-grid">

            <div class="td-meta-item">
              <div class="td-meta-icon gold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <line x1="12" y1="1" x2="12" y2="23" />
                  <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                </svg>
              </div>
              <div>
                <div class="td-meta-label">Budget</div>
                <div class="td-meta-value">${{ number_format($tender->budget, 2) }}</div>
              </div>
            </div>

            <div class="td-meta-item">
              <div class="td-meta-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                  <circle cx="12" cy="10" r="3" />
                </svg>
              </div>
              <div>
                <div class="td-meta-label">Location</div>
                <div class="td-meta-value">{{ $tender->location }}</div>
              </div>
            </div>

            <div class="td-meta-item">
              <div class="td-meta-icon red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                  <line x1="16" y1="2" x2="16" y2="6" />
                  <line x1="8" y1="2" x2="8" y2="6" />
                  <line x1="3" y1="10" x2="21" y2="10" />
                </svg>
              </div>
              <div>
                <div class="td-meta-label">Submission Deadline</div>
                <div class="td-meta-value">
                  {{ \Carbon\Carbon::parse($tender->submission_deadline)->format('d M Y') }}
                </div>
              </div>
            </div>

            <div class="td-meta-item">
              <div class="td-meta-icon {{ $tender->is_open ? 'green' : 'red' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  @if($tender->is_open)
                  <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
                  <polyline points="22 4 12 14.01 9 11.01" />
                  @else
                  <circle cx="12" cy="12" r="10" />
                  <line x1="15" y1="9" x2="9" y2="15" />
                  <line x1="9" y1="9" x2="15" y2="15" />
                  @endif
                </svg>
              </div>
              <div>
                <div class="td-meta-label">Status</div>
                <div class="td-meta-value" style="color:{{ $tender->is_open ? '#16a34a' : '#dc2626' }}">
                  {{ $tender->is_open ? 'Open' : 'Closed' }}
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      {{-- Document --}}
      @if($tender->document_path)
      <div class="td-card">
        <div class="td-card-head">
          <div class="td-card-head-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
              <polyline points="7 10 12 15 17 10" />
              <line x1="12" y1="15" x2="12" y2="3" />
            </svg>
          </div>
          <h2>Tender Document</h2>
        </div>
        <div class="td-card-body">
          <a href="{{ asset('storage/' . $tender->document_path) }}"
            class="td-doc-btn"
            target="_blank">
            <div class="td-doc-icon">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM13 10h6v10H5V4h7v6z" />
              </svg>
            </div>
            <div class="td-doc-text">
              <strong>Download Tender Document</strong>
              <span>Click to view or download the official document</span>
            </div>
            <div class="td-doc-arrow">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M7 17L17 7M7 7h10v10" />
              </svg>
            </div>
          </a>
        </div>
      </div>
      @endif

    </div>

    {{-- ── Sidebar ── --}}
    <div class="td-sidebar">

      {{-- Apply card --}}
      <div class="td-card">
        <div class="td-card-body">

          {{-- Owner --}}
          <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
            <div class="td-owner-avatar">
              <svg viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
              </svg>
            </div>
            <div class="td-owner-info">
              <strong>{{ $tender->user->name ?? 'N/A' }}</strong>
              <span>Tender Owner</span>
            </div>
          </div>

          {{-- Posted date --}}
          <div class="td-posted" style="margin-bottom:20px">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
              <line x1="16" y1="2" x2="16" y2="6" />
              <line x1="8" y1="2" x2="8" y2="6" />
              <line x1="3" y1="10" x2="21" y2="10" />
            </svg>
            Posted on <strong>{{ $tender->created_at->format('d M Y') }}</strong>
          </div>

          <div class="td-divider" style="margin:0 0 20px"></div>

          {{-- Apply / Closed button --}}
          @if($tender->is_open)
          <a href="#" class="td-apply-btn open">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.06 1.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92z" />
            </svg>
            Apply for Tender
          </a>
          @else
          <button class="td-apply-btn closed" disabled>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10" />
              <line x1="4.93" y1="4.93" x2="19.07" y2="19.07" />
            </svg>
            Tender Closed
          </button>
          @endif

        </div>

        {{-- Share strip --}}
        <div class="td-divider" style="margin:0"></div>
        <div class="td-share">
          <span class="td-share-label">Share</span>
          <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
            target="_blank" class="td-share-btn" title="Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
            </svg>
          </a>
          <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($tender->title) }}"
            target="_blank" class="td-share-btn" title="Twitter / X">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
            </svg>
          </a>
          <a href="https://wa.me/?text={{ urlencode($tender->title . ' ' . request()->url()) }}"
            target="_blank" class="td-share-btn" title="WhatsApp">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
              <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
            </svg>
          </a>
        </div>

      </div>

      {{-- Deadline countdown card --}}
      @if($tender->is_open)
      <div class="td-card">
        <div class="td-card-body" style="text-align:center">
          <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#9ca3af;margin-bottom:8px">
            Deadline
          </div>
          <div style="font-size:1.35rem;font-weight:800;color:#111827">
            {{ \Carbon\Carbon::parse($tender->submission_deadline)->format('d M Y') }}
          </div>
          <div style="font-size:.8rem;color:#6b7280;margin-top:4px">
            {{ \Carbon\Carbon::parse($tender->submission_deadline)->diffForHumans() }}
          </div>
          <div style="height:6px;background:#f3f4f6;border-radius:99px;margin-top:14px;overflow:hidden">
            @php
            $total = $tender->created_at->diffInDays(\Carbon\Carbon::parse($tender->submission_deadline));
            $elapsed = $tender->created_at->diffInDays(now());
            $pct = $total > 0 ? min(100, round(($elapsed / $total) * 100)) : 100;
            @endphp
            <div style="height:100%;width:{{ $pct }}%;background:{{ $pct > 80 ? '#ef4444' : ($pct > 50 ? '#f59e0b' : '#16a34a') }};border-radius:99px;transition:width .3s"></div>
          </div>
          <div style="font-size:.7rem;color:#9ca3af;margin-top:6px">{{ $pct }}% of time elapsed</div>
        </div>
      </div>
      @endif

    </div>

  </div>
</div>

@endsection