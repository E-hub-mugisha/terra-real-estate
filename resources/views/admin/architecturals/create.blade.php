@extends('layouts.app')
@section('title', 'Upload Architectural Design')
@section('content')

<style>
/* ── Google Font ── */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=DM+Serif+Display&display=swap');

:root {
    --brand:       #C94E07;
    --brand-dark:  #a33e05;
    --brand-glow:  #C94E0718;
    --brand-mid:   #C94E0730;
    --ink:         #111827;
    --ink-2:       #374151;
    --ink-3:       #6B7280;
    --ink-4:       #9CA3AF;
    --line:        #E5E7EB;
    --line-strong: #D1D5DB;
    --bg:          #F9FAFB;
    --surface:     #FFFFFF;
    --danger:      #DC2626;
    --danger-bg:   #FEF2F2;
    --success:     #16A34A;
    --success-bg:  #F0FDF4;
    --gold:        #F59E0B;
    --r-sm:        6px;
    --r-md:        10px;
    --r-lg:        14px;
    --shadow-sm:   0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
    --shadow-md:   0 4px 12px rgba(0,0,0,.08), 0 2px 4px rgba(0,0,0,.04);
}

*, *::before, *::after { box-sizing: border-box; }

.adp-root {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    padding: 2rem 1.25rem 4rem;
    color: var(--ink);
}

/* ── Page header ── */
.adp-page-header {
    max-width: 1120px;
    margin: 0 auto 2rem;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}

.adp-breadcrumb {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .72rem;
    font-weight: 500;
    color: var(--ink-3);
    margin-bottom: .5rem;
    letter-spacing: .02em;
    text-transform: uppercase;
}

.adp-breadcrumb a {
    color: var(--ink-3);
    text-decoration: none;
    transition: color .15s;
}

.adp-breadcrumb a:hover { color: var(--brand); }

.adp-breadcrumb-sep {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--ink-4);
}

.adp-page-title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.7rem;
    font-weight: 400;
    color: var(--ink);
    line-height: 1.2;
    margin: 0;
}

.adp-page-sub {
    font-size: .82rem;
    color: var(--ink-3);
    margin: .35rem 0 0;
}

.adp-header-actions {
    display: flex;
    gap: .5rem;
    flex-shrink: 0;
    padding-top: .15rem;
}

/* ── Layout ── */
.adp-layout {
    max-width: 1120px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 288px;
    gap: 1.25rem;
    align-items: start;
}

.adp-main { display: flex; flex-direction: column; gap: 1.25rem; }

.adp-side {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    position: sticky;
    top: 88px;
}

/* ── Card ── */
.adp-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.adp-card-head {
    display: flex;
    align-items: center;
    gap: .7rem;
    padding: .95rem 1.4rem;
    border-bottom: 1px solid var(--line);
}

.adp-card-head-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--brand);
    flex-shrink: 0;
}

.adp-card-head h6 {
    margin: 0;
    font-size: .84rem;
    font-weight: 650;
    color: var(--ink);
    letter-spacing: -.01em;
}

.adp-card-head-pill {
    margin-left: auto;
    background: var(--brand-glow);
    color: var(--brand);
    font-size: .67rem;
    font-weight: 700;
    padding: .18rem .55rem;
    border-radius: 100px;
    display: none;
    letter-spacing: .02em;
}

.adp-card-head-pill.show { display: inline-block; }

.adp-card-body { padding: 1.4rem; }

/* ── Alerts ── */
.adp-alert {
    max-width: 1120px;
    margin: 0 auto 1.25rem;
    border-radius: var(--r-md);
    padding: .9rem 1.2rem;
    font-size: .83rem;
    display: flex;
    gap: .65rem;
    align-items: flex-start;
}

.adp-alert-err  { background: var(--danger-bg); border: 1px solid #FECACA; color: #991B1B; }
.adp-alert-ok   { background: var(--success-bg); border: 1px solid #BBF7D0; color: #14532D; }
.adp-alert ul   { margin: .3rem 0 0 1rem; padding: 0; }
.adp-alert li   { margin-bottom: .2rem; }
.adp-alert-icon { flex-shrink: 0; margin-top: .1rem; }

/* ── Grid helpers ── */
.adp-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1.1rem; }
.adp-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.1rem; }
.adp-span-2 { grid-column: span 2; }

/* ── Form elements ── */
.adp-field { display: flex; flex-direction: column; }

.adp-lbl {
    font-size: .71rem;
    font-weight: 600;
    letter-spacing: .05em;
    text-transform: uppercase;
    color: var(--ink-3);
    margin-bottom: .45rem;
}

.adp-lbl .req { color: var(--danger); margin-left: .15rem; }

.adp-input,
.adp-select,
.adp-textarea {
    width: 100%;
    padding: .62rem .9rem;
    border: 1.5px solid var(--line-strong);
    border-radius: var(--r-sm);
    font-size: .875rem;
    color: var(--ink);
    background: var(--surface);
    font-family: inherit;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    appearance: none;
}

.adp-input:focus,
.adp-select:focus,
.adp-textarea:focus {
    border-color: var(--brand);
    box-shadow: 0 0 0 3px var(--brand-glow);
}

.adp-input.err,
.adp-select.err,
.adp-textarea.err {
    border-color: var(--danger);
    box-shadow: 0 0 0 3px #DC262612;
}

.adp-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right .8rem center;
    padding-right: 2.2rem;
}

.adp-textarea { resize: vertical; line-height: 1.65; }

.adp-hint {
    font-size: .72rem;
    color: var(--ink-4);
    margin-top: .35rem;
    line-height: 1.5;
}

.adp-err-msg {
    font-size: .72rem;
    color: var(--danger);
    margin-top: .35rem;
    display: flex;
    align-items: center;
    gap: .3rem;
}

/* ── Input prefix/suffix ── */
.adp-input-wrap { display: flex; align-items: stretch; }

.adp-addon {
    padding: .62rem .85rem;
    background: var(--bg);
    border: 1.5px solid var(--line-strong);
    font-size: .8rem;
    font-weight: 600;
    color: var(--ink-3);
    display: flex;
    align-items: center;
    white-space: nowrap;
    flex-shrink: 0;
}

.adp-addon.left  { border-right: none; border-radius: var(--r-sm) 0 0 var(--r-sm); }
.adp-addon.right { border-left:  none; border-radius: 0 var(--r-sm) var(--r-sm) 0; }

.adp-input-wrap .adp-input.with-l { border-radius: 0 var(--r-sm) var(--r-sm) 0; }
.adp-input-wrap .adp-input.with-r { border-radius: var(--r-sm) 0 0 var(--r-sm); border-right: none; }

/* ── Section divider ── */
.adp-section-divider {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin: 1.5rem 0 1.25rem;
}

.adp-section-divider span {
    font-size: .69rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--ink-4);
    white-space: nowrap;
}

.adp-section-divider::before,
.adp-section-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--line);
}

/* ── File upload zone ── */
.adp-dropzone {
    border: 2px dashed var(--line-strong);
    border-radius: var(--r-md);
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    background: var(--bg);
    position: relative;
}

.adp-dropzone:hover,
.adp-dropzone.over {
    border-color: var(--brand);
    background: var(--brand-glow);
}

.adp-dropzone input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}

.adp-dropzone-icon {
    width: 44px; height: 44px;
    border-radius: var(--r-md);
    background: var(--brand-glow);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto .85rem;
    color: var(--brand);
}

.adp-dropzone h6 {
    font-size: .875rem;
    font-weight: 600;
    color: var(--ink-2);
    margin: 0 0 .3rem;
}

.adp-dropzone p {
    font-size: .76rem;
    color: var(--ink-4);
    margin: 0;
    line-height: 1.5;
}

.adp-dropzone-browse { color: var(--brand); font-weight: 600; }

/* ── Selected file row ── */
.adp-file-row {
    display: none;
    align-items: center;
    gap: .75rem;
    padding: .8rem 1rem;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-md);
    margin-top: .75rem;
}

.adp-file-row.show { display: flex; }

.adp-file-ext {
    width: 38px; height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .62rem;
    font-weight: 800;
    letter-spacing: .04em;
    flex-shrink: 0;
}

.adp-file-ext.pdf { background: #FEF2F2; color: #B91C1C; }
.adp-file-ext.zip { background: #FFFBEB; color: #92400E; }
.adp-file-ext.dwg { background: #EFF6FF; color: #1D4ED8; }

.adp-file-info      { flex: 1; min-width: 0; }
.adp-file-info b    { display: block; font-size: .82rem; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.adp-file-info span { font-size: .72rem; color: var(--ink-4); }

.adp-file-clear {
    background: none;
    border: none;
    color: var(--ink-4);
    cursor: pointer;
    padding: .3rem;
    border-radius: 4px;
    transition: color .15s;
    display: flex;
    align-items: center;
}

.adp-file-clear:hover { color: var(--danger); }

/* ── Image grid ── */
.adp-img-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(108px, 1fr));
    gap: .65rem;
    margin-top: .9rem;
}

.adp-thumb {
    position: relative;
    aspect-ratio: 1;
    border-radius: var(--r-md);
    overflow: hidden;
    background: var(--bg);
    border: 1.5px solid var(--line);
    transition: border-color .15s, box-shadow .15s;
}

.adp-thumb img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}

.adp-thumb-badge {
    position: absolute;
    top: 6px; left: 6px;
    background: rgba(0,0,0,.5);
    color: #fff;
    font-size: .58rem;
    font-weight: 700;
    padding: .1rem .35rem;
    border-radius: 100px;
    pointer-events: none;
}

.adp-thumb-cover {
    position: absolute;
    top: 6px; left: 6px;
    background: var(--brand);
    color: #fff;
    font-size: .58rem;
    font-weight: 700;
    padding: .1rem .4rem;
    border-radius: 100px;
    pointer-events: none;
    display: none;
    letter-spacing: .03em;
}

.adp-thumb.primary            { border-color: var(--brand); box-shadow: 0 0 0 2px var(--brand-mid); }
.adp-thumb.primary .adp-thumb-badge { display: none; }
.adp-thumb.primary .adp-thumb-cover { display: block; }

.adp-thumb-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.4);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .35rem;
    opacity: 0;
    transition: opacity .15s;
}

.adp-thumb:hover .adp-thumb-overlay { opacity: 1; }

.adp-thumb-btn {
    width: 30px; height: 30px;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    transition: transform .1s;
    font-weight: 700;
}

.adp-thumb-btn:hover { transform: scale(1.1); }
.adp-thumb-btn.star  { background: var(--brand); color: #fff; }
.adp-thumb-btn.del   { background: rgba(255,255,255,.92); color: var(--danger); }

.adp-add-tile {
    aspect-ratio: 1;
    border: 2px dashed var(--line-strong);
    border-radius: var(--r-md);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .3rem;
    cursor: pointer;
    color: var(--ink-4);
    font-size: .71rem;
    font-weight: 600;
    transition: border-color .15s, color .15s, background .15s;
    position: relative;
}

.adp-add-tile input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%; height: 100%;
}

.adp-add-tile:hover { border-color: var(--brand); color: var(--brand); background: var(--brand-glow); }

.adp-img-strip {
    display: none;
    align-items: center;
    justify-content: space-between;
    margin-top: .9rem;
    padding: .6rem .9rem;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-sm);
    font-size: .77rem;
    color: var(--ink-3);
}

.adp-img-strip.show { display: flex; }
.adp-img-strip strong { color: var(--ink); }

.adp-img-strip button {
    background: none;
    border: none;
    font-size: .72rem;
    color: var(--ink-4);
    cursor: pointer;
    padding: 0;
    transition: color .15s;
}

.adp-img-strip button:hover { color: var(--danger); }

/* ── Spec row inputs ── */
.adp-spec-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

/* ── Toggles ── */
.adp-toggle-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .85rem 0;
    border-bottom: 1px solid var(--line);
}

.adp-toggle-row:last-child { border-bottom: none; padding-bottom: 0; }

.adp-toggle-lbl   { font-size: .84rem; font-weight: 500; color: var(--ink); }
.adp-toggle-desc  { font-size: .72rem; color: var(--ink-4); margin-top: .1rem; }

.adp-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
.adp-switch input { opacity: 0; width: 0; height: 0; }

.adp-switch-track {
    position: absolute;
    inset: 0;
    background: var(--line-strong);
    border-radius: 100px;
    cursor: pointer;
    transition: background .2s;
}

.adp-switch-track::before {
    content: '';
    position: absolute;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: #fff;
    top: 3px; left: 3px;
    transition: transform .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}

.adp-switch input:checked + .adp-switch-track { background: var(--brand); }
.adp-switch input:checked + .adp-switch-track::before { transform: translateX(16px); }

/* ── Status radio chips ── */
.adp-status-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .5rem;
}

.adp-status-radio { display: none; }

.adp-status-chip {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .35rem;
    padding: .75rem .5rem;
    border: 1.5px solid var(--line);
    border-radius: var(--r-sm);
    cursor: pointer;
    font-size: .73rem;
    font-weight: 600;
    color: var(--ink-3);
    text-align: center;
    transition: all .15s;
    background: var(--surface);
}

.adp-status-chip:hover { border-color: var(--line-strong); }

.adp-status-dot { width: 9px; height: 9px; border-radius: 50%; }

.adp-status-radio[value="pending"]:checked  + .adp-status-chip { border-color: #F59E0B; background: #FFFBEB; color: #92400E; }
.adp-status-radio[value="approved"]:checked + .adp-status-chip { border-color: #22C55E; background: #F0FDF4; color: #14532D; }
.adp-status-radio[value="rejected"]:checked + .adp-status-chip { border-color: #EF4444; background: #FEF2F2; color: #991B1B; }

/* ── Pricing preview ── */
.adp-price-preview {
    margin-top: 1rem;
    padding: .8rem 1rem;
    background: var(--brand-glow);
    border: 1px solid var(--brand-mid);
    border-radius: var(--r-sm);
    font-size: .78rem;
    color: var(--brand-dark);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: .5rem;
}

/* ── Listing fee preview ── */
.adp-fee-preview {
    margin-top: .9rem;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-sm);
    overflow: hidden;
}

.adp-fee-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .55rem .9rem;
    font-size: .78rem;
    border-bottom: 1px solid var(--line);
}

.adp-fee-row:last-child { border-bottom: none; }
.adp-fee-row .lbl { color: var(--ink-3); }
.adp-fee-row .val { font-weight: 600; color: var(--ink); }
.adp-fee-row.total { background: var(--bg); }
.adp-fee-row.total .lbl { font-weight: 600; color: var(--ink-2); }
.adp-fee-row.total .val { color: var(--brand); font-size: .88rem; }

/* ── Buttons ── */
.adp-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .62rem 1.35rem;
    border-radius: var(--r-sm);
    font-size: .84rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
    font-family: inherit;
    white-space: nowrap;
}

.adp-btn-primary {
    background: var(--brand);
    color: #fff;
    box-shadow: 0 1px 3px rgba(201,78,7,.35);
}

.adp-btn-primary:hover {
    background: var(--brand-dark);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(201,78,7,.3);
}

.adp-btn-ghost {
    background: var(--surface);
    border: 1.5px solid var(--line-strong);
    color: var(--ink-2);
}

.adp-btn-ghost:hover {
    border-color: var(--brand);
    color: var(--brand);
    background: var(--brand-glow);
}

/* ── Submit bar ── */
.adp-submit-bar {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: .6rem;
    padding: 1.1rem 1.4rem;
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-sm);
}

.adp-submit-hint {
    margin-right: auto;
    font-size: .75rem;
    color: var(--ink-4);
}

/* ── Responsive ── */
@media (max-width: 900px) {
    .adp-layout { grid-template-columns: 1fr; }
    .adp-side { position: static; }
    .adp-grid-2 { grid-template-columns: 1fr; }
    .adp-spec-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 560px) {
    .adp-spec-grid { grid-template-columns: 1fr; }
    .adp-grid-3 { grid-template-columns: 1fr; }
    .adp-page-header { flex-direction: column; gap: .75rem; }
    .adp-header-actions { width: 100%; justify-content: flex-end; }
}
</style>

<div class="adp-root">

    {{-- ── Page header ── --}}
    <div class="adp-page-header">
        <div>
            <nav class="adp-breadcrumb">
                <a href="{{ route('admin.architectural-designs.index') }}">Designs</a>
                <span class="adp-breadcrumb-sep"></span>
                <span>New Upload</span>
            </nav>
            <h1 class="adp-page-title">Upload Architectural Design</h1>
            <p class="adp-page-sub">Add a design file with metadata, preview images, and pricing.</p>
        </div>
        <div class="adp-header-actions">
            <a href="{{ route('admin.architectural-designs.index') }}" class="adp-btn adp-btn-ghost">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                Back
            </a>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if ($errors->any())
    <div class="adp-alert adp-alert-err">
        <svg class="adp-alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="adp-alert adp-alert-ok">
        <svg class="adp-alert-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 6 9 17l-5-5"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST"
          action="{{ route('admin.architectural-designs.store') }}"
          enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="primary_image_index" id="primaryImageIndex" value="0">

        <div class="adp-layout">

            {{-- ══════════ MAIN ══════════ --}}
            <div class="adp-main">

                {{-- ── Basic Info ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Design Information</h6>
                    </div>
                    <div class="adp-card-body">

                        <div class="adp-field" style="margin-bottom:1.1rem">
                            <label class="adp-lbl">Title <span class="req">*</span></label>
                            <input type="text" name="title"
                                class="adp-input @error('title') err @enderror"
                                placeholder="e.g. Modern 3-Bedroom Villa Blueprint"
                                value="{{ old('title') }}" required>
                            <p class="adp-hint">A URL slug will be auto-generated from this title.</p>
                            @error('title')<p class="adp-err-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="adp-grid-2" style="margin-bottom:1.1rem">
                            <div class="adp-field">
                                <label class="adp-lbl">Category <span class="req">*</span></label>
                                <select name="category_id"
                                    class="adp-select @error('category_id') err @enderror" required>
                                    <option value="">Select category…</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>

                            <div class="adp-field">
                                <label class="adp-lbl">Assign to User</label>
                                <select name="user_id"
                                    class="adp-select @error('user_id') err @enderror">
                                    <option value="">— Admin account —</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_id')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="adp-field">
                            <label class="adp-lbl">Description</label>
                            <textarea name="description" rows="4"
                                class="adp-textarea @error('description') err @enderror"
                                placeholder="Describe the design — floor plan, dimensions, style, included deliverables…">{{ old('description') }}</textarea>
                            @error('description')<p class="adp-err-msg">{{ $message }}</p>@enderror
                        </div>

                    </div>
                </div>

                {{-- ── Specifications ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Specifications</h6>
                    </div>
                    <div class="adp-card-body">
                        <div class="adp-spec-grid">
                            <div class="adp-field">
                                <label class="adp-lbl">Bedrooms</label>
                                <input type="number" name="bedrooms" min="0"
                                    class="adp-input @error('bedrooms') err @enderror"
                                    placeholder="e.g. 3"
                                    value="{{ old('bedrooms') }}">
                                @error('bedrooms')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Bathrooms</label>
                                <input type="number" name="bathrooms" min="0"
                                    class="adp-input @error('bathrooms') err @enderror"
                                    placeholder="e.g. 2"
                                    value="{{ old('bathrooms') }}">
                                @error('bathrooms')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Floors</label>
                                <input type="number" name="floors" min="1"
                                    class="adp-input @error('floors') err @enderror"
                                    placeholder="e.g. 2"
                                    value="{{ old('floors') }}">
                                @error('floors')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Total Area (m²)</label>
                                <input type="number" name="total_area" min="0" step="0.01"
                                    class="adp-input @error('total_area') err @enderror"
                                    placeholder="e.g. 240"
                                    value="{{ old('total_area') }}">
                                @error('total_area')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Plot Size (m²)</label>
                                <input type="number" name="plot_size" min="0" step="0.01"
                                    class="adp-input @error('plot_size') err @enderror"
                                    placeholder="e.g. 600"
                                    value="{{ old('plot_size') }}">
                                @error('plot_size')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                            <div class="adp-field">
                                <label class="adp-lbl">Style</label>
                                <select name="style" class="adp-select @error('style') err @enderror">
                                    <option value="">Select…</option>
                                    @foreach(['Modern','Contemporary','Colonial','Traditional','Minimalist','Tropical','Industrial','Ranch'] as $st)
                                    <option value="{{ $st }}" {{ old('style') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                                @error('style')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Design File ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Design File <span style="color:var(--danger);font-size:.8rem;font-weight:400">Required</span></h6>
                    </div>
                    <div class="adp-card-body">

                        <div class="adp-dropzone" id="dznDesign">
                            <input type="file" name="design_file" id="designFileInput" accept=".pdf,.zip,.dwg" required>
                            <div class="adp-dropzone-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="12" x2="12" y1="11" y2="17"/>
                                    <line x1="9" x2="15" y1="14" y2="14"/>
                                </svg>
                            </div>
                            <h6>Drop your design file here</h6>
                            <p>or <span class="adp-dropzone-browse">browse files</span><br>PDF · ZIP · DWG — max 20 MB</p>
                        </div>

                        <div class="adp-file-row" id="designFileRow">
                            <div class="adp-file-ext" id="designFileExt">PDF</div>
                            <div class="adp-file-info">
                                <b id="designFileName">—</b>
                                <span id="designFileSize">—</span>
                            </div>
                            <button type="button" class="adp-file-clear" onclick="clearDesignFile()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                            </button>
                        </div>

                        @error('design_file')<p class="adp-err-msg" style="margin-top:.6rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Preview Images ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Preview Images</h6>
                        <span class="adp-card-head-pill" id="imgBadge">0 photos</span>
                    </div>
                    <div class="adp-card-body">

                        <div class="adp-dropzone" id="dznImages">
                            <input type="file" name="images[]" id="previewImageInput" accept="image/*" multiple>
                            <div class="adp-dropzone-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <rect width="18" height="18" x="3" y="3" rx="2"/>
                                    <circle cx="9" cy="9" r="2"/>
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                                </svg>
                            </div>
                            <h6>Drop preview images here</h6>
                            <p>or <span class="adp-dropzone-browse">browse</span> — JPG · PNG · WEBP<br>Up to 10 images · 4 MB each</p>
                        </div>

                        <div class="adp-img-strip" id="imgStrip">
                            <span><strong id="imgStripCount">0 images</strong> selected — first is the cover</span>
                            <button type="button" onclick="clearAllImages()">Remove all</button>
                        </div>

                        <div class="adp-img-grid" id="imgGrid"></div>
                        <div id="imgInputsContainer" style="display:none"></div>

                        @error('images')<p class="adp-err-msg" style="margin-top:.6rem">{{ $message }}</p>@enderror
                        @error('images.*')<p class="adp-err-msg" style="margin-top:.4rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Listing Package ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Listing Package</h6>
                    </div>
                    <div class="adp-card-body">
                        <div class="adp-grid-2">
                            <div class="adp-field">
                                <label class="adp-lbl">Package <span class="req">*</span></label>
                                <select name="listing_package_id" class="adp-select @error('listing_package_id') err @enderror"
                                    onchange="recalcFee()" required>
                                    <option value="">Select a package…</option>
                                    @foreach($packages as $pkg)
                                    <option value="{{ $pkg->id }}"
                                        data-price="{{ $pkg->price_per_day }}"
                                        data-agent-pct="{{ $pkg->agent_commission_pct }}"
                                        data-terra-pct="{{ $pkg->terra_share_pct }}"
                                        {{ old('listing_package_id') == $pkg->id ? 'selected' : '' }}>
                                        {{ ucfirst($pkg->package_tier) }} — RWF {{ number_format($pkg->price_per_day) }}/day
                                        (you earn {{ $pkg->agent_commission_pct }}%)
                                    </option>
                                    @endforeach
                                </select>
                                @error('listing_package_id')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>

                            <div class="adp-field">
                                <label class="adp-lbl">Duration (days) <span class="req">*</span></label>
                                <input type="number" name="listing_days" class="adp-input @error('listing_days') err @enderror"
                                    value="{{ old('listing_days', 30) }}" min="1" oninput="recalcFee()" required>
                                <p class="adp-hint">31–59 days: 10% off · 61–89 days: 15% off · 90+ days: 20% off</p>
                                @error('listing_days')<p class="adp-err-msg">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="adp-fee-preview" id="feePreview" style="display:none">
                            <div class="adp-fee-row">
                                <span class="lbl">Base rate</span>
                                <span class="val" id="feeBase">—</span>
                            </div>
                            <div class="adp-fee-row">
                                <span class="lbl">Duration discount</span>
                                <span class="val" id="feeDiscount">—</span>
                            </div>
                            <div class="adp-fee-row total">
                                <span class="lbl">Listing fee</span>
                                <span class="val" id="feeTotal">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Submit bar ── --}}
                <div class="adp-submit-bar">
                    <span class="adp-submit-hint">All required fields must be filled before upload.</span>
                    <a href="{{ route('admin.architectural-designs.index') }}" class="adp-btn adp-btn-ghost">Cancel</a>
                    <button type="submit" class="adp-btn adp-btn-primary">
                        Upload &amp; Continue
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>
                </div>

            </div>{{-- /.adp-main --}}

            {{-- ══════════ SIDEBAR ══════════ --}}
            <div class="adp-side">

                {{-- ── Pricing ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Pricing</h6>
                    </div>
                    <div class="adp-card-body">

                        <div class="adp-field" style="margin-bottom:.9rem">
                            <label class="adp-lbl">Sale Price</label>
                            <div class="adp-input-wrap">
                                <span class="adp-addon left" id="priceCurrencyAddon">RWF</span>
                                <input type="number" name="price" id="priceInput"
                                    class="adp-input with-l @error('price') err @enderror"
                                    placeholder="0" min="0" step="0.01"
                                    value="{{ old('price', 0) }}"
                                    oninput="updatePricePreview()">
                            </div>
                            @error('price')<p class="adp-err-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="adp-field" style="margin-bottom:.75rem">
                            <label class="adp-lbl">Currency</label>
                            <select name="currency" id="currencyInput"
                                class="adp-select @error('currency') err @enderror"
                                onchange="updatePricePreview()">
                                <option value="RWF" {{ old('currency','RWF') == 'RWF' ? 'selected' : '' }}>Rwandan Franc (RWF)</option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                            </select>
                            @error('currency')<p class="adp-err-msg">{{ $message }}</p>@enderror
                        </div>

                        <div class="adp-price-preview" id="pricePreview">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            <span id="pricePreviewText">Listed as Free</span>
                        </div>

                    </div>
                </div>

                {{-- ── Status ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Status</h6>
                    </div>
                    <div class="adp-card-body">
                        <div class="adp-status-grid">
                            @foreach(['pending' => ['label'=>'Pending','color'=>'#F59E0B'], 'approved' => ['label'=>'Approved','color'=>'#22C55E'], 'rejected' => ['label'=>'Rejected','color'=>'#EF4444']] as $val => $meta)
                            <input type="radio" name="status" id="status_{{ $val }}"
                                value="{{ $val }}" class="adp-status-radio"
                                {{ old('status','pending') === $val ? 'checked' : '' }} required>
                            <label for="status_{{ $val }}" class="adp-status-chip">
                                <span class="adp-status-dot" style="background:{{ $meta['color'] }}"></span>
                                {{ $meta['label'] }}
                            </label>
                            @endforeach
                        </div>
                        @error('status')<p class="adp-err-msg" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- ── Options ── --}}
                <div class="adp-card">
                    <div class="adp-card-head">
                        <span class="adp-card-head-dot"></span>
                        <h6>Options</h6>
                    </div>
                    <div class="adp-card-body">
                        <div class="adp-toggle-row">
                            <div>
                                <div class="adp-toggle-lbl">Featured</div>
                                <div class="adp-toggle-desc">Show on homepage spotlight</div>
                            </div>
                            <label class="adp-switch">
                                <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                                <span class="adp-switch-track"></span>
                            </label>
                        </div>
                        <div class="adp-toggle-row">
                            <div>
                                <div class="adp-toggle-lbl">Downloadable</div>
                                <div class="adp-toggle-desc">Allow buyers to download</div>
                            </div>
                            <label class="adp-switch">
                                <input type="checkbox" name="is_downloadable" value="1" {{ old('is_downloadable',true) ? 'checked' : '' }}>
                                <span class="adp-switch-track"></span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>{{-- /.adp-side --}}

        </div>{{-- /.adp-layout --}}
    </form>
</div>

<script>
/* ═══════════════════════════════════
   Design file upload
═══════════════════════════════════ */
const designInput = document.getElementById('designFileInput');
const designRow   = document.getElementById('designFileRow');
const dznDesign   = document.getElementById('dznDesign');

designInput.addEventListener('change', () => showDesignFile(designInput.files[0]));

['dragover','dragleave','drop'].forEach(ev => {
    dznDesign.addEventListener(ev, e => {
        e.preventDefault();
        dznDesign.classList.toggle('over', ev === 'dragover');
        if (ev === 'drop' && e.dataTransfer.files[0]) {
            const dt = new DataTransfer();
            dt.items.add(e.dataTransfer.files[0]);
            designInput.files = dt.files;
            showDesignFile(e.dataTransfer.files[0]);
        }
    });
});

function showDesignFile(file) {
    if (!file) return;
    const ext = file.name.split('.').pop().toLowerCase();
    document.getElementById('designFileName').textContent = file.name;
    document.getElementById('designFileSize').textContent = fmtBytes(file.size);
    const extEl = document.getElementById('designFileExt');
    extEl.textContent  = ext.toUpperCase();
    extEl.className    = 'adp-file-ext ' + (ext === 'pdf' ? 'pdf' : ext === 'zip' ? 'zip' : 'dwg');
    designRow.classList.add('show');
}

function clearDesignFile() {
    designInput.value = '';
    designRow.classList.remove('show');
}

/* ═══════════════════════════════════
   Multi-image manager
═══════════════════════════════════ */
const MAX_IMGS = 10;
let imgItems   = [];

const dznImages = document.getElementById('dznImages');
const imgGrid   = document.getElementById('imgGrid');

document.getElementById('previewImageInput').addEventListener('change', function () {
    addImgFiles(Array.from(this.files));
    this.value = '';
});

['dragover','dragleave','drop'].forEach(ev => {
    [dznImages, imgGrid].forEach(el => {
        el.addEventListener(ev, e => {
            e.preventDefault();
            el.classList.toggle('over', ev === 'dragover');
            if (ev === 'drop') {
                const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
                addImgFiles(files);
            }
        });
    });
});

function addImgFiles(files) {
    const room = MAX_IMGS - imgItems.length;
    files = files.slice(0, room);
    if (!files.length) return;
    let done = 0;
    files.forEach(file => {
        const r = new FileReader();
        r.onload = ev => {
            imgItems.push({ file, dataUrl: ev.target.result });
            if (++done === files.length) renderImgGrid();
        };
        r.readAsDataURL(file);
    });
}

function renderImgGrid() {
    imgGrid.innerHTML = '';

    imgItems.forEach((item, i) => {
        const t = document.createElement('div');
        t.className = 'adp-thumb' + (i === 0 ? ' primary' : '');
        t.innerHTML = `
            <img src="${item.dataUrl}" alt="Preview ${i+1}">
            <span class="adp-thumb-badge">${i+1}</span>
            <span class="adp-thumb-cover">Cover</span>
            <div class="adp-thumb-overlay">
                ${i !== 0 ? `<button type="button" class="adp-thumb-btn star" title="Set as cover" onclick="setImgPrimary(${i})">★</button>` : ''}
                <button type="button" class="adp-thumb-btn del" title="Remove" onclick="removeImg(${i})">✕</button>
            </div>`;
        imgGrid.appendChild(t);
    });

    if (imgItems.length < MAX_IMGS) {
        const tile = document.createElement('div');
        tile.className = 'adp-add-tile';
        tile.innerHTML = `
            <input type="file" accept="image/*" multiple onchange="addMoreImgs(this)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/>
            </svg>
            <span>Add more</span>`;
        imgGrid.appendChild(tile);
    }

    updateImgUI();
}

function addMoreImgs(input) { addImgFiles(Array.from(input.files)); input.value = ''; }
function setImgPrimary(i)  { const [x] = imgItems.splice(i, 1); imgItems.unshift(x); renderImgGrid(); }
function removeImg(i)       { imgItems.splice(i, 1); renderImgGrid(); }
function clearAllImages()   { imgItems = []; renderImgGrid(); }

function updateImgUI() {
    const c = imgItems.length;
    const badge = document.getElementById('imgBadge');
    badge.textContent = c + (c === 1 ? ' photo' : ' photos');
    badge.classList.toggle('show', c > 0);
    document.getElementById('imgStripCount').textContent = c + (c === 1 ? ' image' : ' images');
    document.getElementById('imgStrip').classList.toggle('show', c > 0);
    dznImages.style.display = c > 0 ? 'none' : '';
    document.getElementById('primaryImageIndex').value = 0;
    syncImgInputs();
}

function syncImgInputs() {
    const con = document.getElementById('imgInputsContainer');
    con.innerHTML = '';
    if (!imgItems.length) return;
    const dt = new DataTransfer();
    imgItems.forEach(item => dt.items.add(item.file));
    const inp = document.createElement('input');
    inp.type = 'file'; inp.name = 'images[]'; inp.multiple = true; inp.style.display = 'none';
    try { inp.files = dt.files; } catch(e) {
        imgItems.forEach(item => {
            const d2 = new DataTransfer(); d2.items.add(item.file);
            const i2 = document.createElement('input');
            i2.type = 'file'; i2.name = 'images[]'; i2.style.display = 'none';
            try { i2.files = d2.files; } catch(e2) {}
            con.appendChild(i2);
        });
        return;
    }
    con.appendChild(inp);
}

/* ═══════════════════════════════════
   Price preview
═══════════════════════════════════ */
function updatePricePreview() {
    const v    = parseFloat(document.getElementById('priceInput').value) || 0;
    const cur  = document.getElementById('currencyInput').value;
    const text = document.getElementById('pricePreviewText');
    const addon= document.getElementById('priceCurrencyAddon');
    addon.textContent = cur;
    text.textContent = v === 0
        ? 'This design will be listed as Free'
        : `Listed at ${cur} ${v.toLocaleString('en', {minimumFractionDigits: cur === 'USD' ? 2 : 0})}`;
}

updatePricePreview();

/* ═══════════════════════════════════
   Listing fee calculator
═══════════════════════════════════ */
function recalcFee() {
    const pkgEl  = document.querySelector('select[name="listing_package_id"]');
    const days   = parseInt(document.querySelector('input[name="listing_days"]').value) || 0;
    const preview= document.getElementById('feePreview');

    if (!pkgEl.value || !days) { preview.style.display = 'none'; return; }

    const opt      = pkgEl.options[pkgEl.selectedIndex];
    const ppd      = parseFloat(opt.dataset.price) || 0;
    const base     = ppd * days;
    const discount = days >= 90 ? .20 : days >= 61 ? .15 : days >= 31 ? .10 : 0;
    const total    = base * (1 - discount);

    document.getElementById('feeBase').textContent     = 'RWF ' + fmt(base);
    document.getElementById('feeDiscount').textContent = discount ? `−${discount*100}%` : '—';
    document.getElementById('feeTotal').textContent    = 'RWF ' + fmt(total);
    preview.style.display = '';
}

function fmt(n) { return Math.round(n).toLocaleString('en'); }

/* ═══════════════════════════════════
   Helpers
═══════════════════════════════════ */
function fmtBytes(b) {
    if (b < 1024)    return b + ' B';
    if (b < 1048576) return (b/1024).toFixed(1) + ' KB';
    return (b/1048576).toFixed(1) + ' MB';
}
</script>

@endsection