@extends('layouts.app')
@section('title', $architecturalDesign->title . ' — Design Detail')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=DM+Serif+Display&display=swap');

:root {
    --brand:        #C94E07;
    --brand-dark:   #a33e05;
    --brand-glow:   #C94E0712;
    --brand-mid:    #C94E0728;
    --ink:          #111827;
    --ink-2:        #374151;
    --ink-3:        #6B7280;
    --ink-4:        #9CA3AF;
    --line:         #E5E7EB;
    --line-strong:  #D1D5DB;
    --bg:           #F9FAFB;
    --surface:      #FFFFFF;
    --danger:       #DC2626;
    --danger-bg:    #FEF2F2;
    --success:      #16A34A;
    --success-bg:   #F0FDF4;
    --warn:         #D97706;
    --warn-bg:      #FFFBEB;
    --blue:         #2563EB;
    --blue-bg:      #EFF6FF;
    --purple:       #7C3AED;
    --purple-bg:    #F5F3FF;
    --r-sm:         6px;
    --r-md:         10px;
    --r-lg:         14px;
    --shadow-sm:    0 1px 3px rgba(0,0,0,.07), 0 1px 2px rgba(0,0,0,.04);
    --shadow-md:    0 4px 12px rgba(0,0,0,.08), 0 2px 4px rgba(0,0,0,.04);
}

*, *::before, *::after { box-sizing: border-box; }

.ds-root {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    padding: 2rem 1.25rem 4rem;
    color: var(--ink);
}

/* ── Breadcrumb ── */
.ds-bc {
    max-width: 1160px;
    margin: 0 auto .5rem;
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .72rem;
    font-weight: 500;
    color: var(--ink-3);
    letter-spacing: .02em;
    text-transform: uppercase;
}

.ds-bc a { color: var(--ink-3); text-decoration: none; transition: color .15s; }
.ds-bc a:hover { color: var(--brand); }
.ds-bc-dot { width: 3px; height: 3px; border-radius: 50%; background: var(--ink-4); }

/* ── Alerts ── */
.ds-alert {
    max-width: 1160px;
    margin: .75rem auto;
    border-radius: var(--r-md);
    padding: .85rem 1.2rem;
    font-size: .83rem;
    display: flex;
    gap: .6rem;
    align-items: flex-start;
}

.ds-alert-ok  { background: var(--success-bg); border: 1px solid #BBF7D0; color: #14532D; }
.ds-alert-err { background: var(--danger-bg);  border: 1px solid #FECACA; color: #991B1B; }
.ds-alert svg { flex-shrink: 0; margin-top: .1rem; }

/* ── Hero banner ── */
.ds-hero {
    max-width: 1160px;
    margin: 0 auto 1.5rem;
    border-radius: var(--r-lg);
    overflow: hidden;
    position: relative;
    aspect-ratio: 21 / 7;
    background: var(--ink);
    box-shadow: var(--shadow-md);
}

.ds-hero img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    opacity: .92;
}

.ds-hero-empty {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .75rem;
    background: linear-gradient(135deg, #1F2937 0%, #111827 100%);
    color: var(--ink-4);
}

.ds-hero-empty svg { opacity: .2; }
.ds-hero-empty span { font-size: .82rem; }

/* gradient veil */
.ds-hero-veil {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.72) 0%, rgba(0,0,0,.1) 55%, transparent 100%);
    pointer-events: none;
}

/* hero bottom content */
.ds-hero-bottom {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    padding: 1.25rem 1.75rem;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
}

.ds-hero-title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.75rem;
    font-weight: 400;
    color: #fff;
    line-height: 1.2;
    margin: 0 0 .55rem;
    text-shadow: 0 1px 3px rgba(0,0,0,.5);
}

.ds-hero-chips { display: flex; align-items: center; gap: .4rem; flex-wrap: wrap; }

/* Thumbnail strip */
.ds-thumb-strip {
    max-width: 1160px;
    margin: 0 auto .35rem;
    display: flex;
    gap: .5rem;
    overflow-x: auto;
    padding-bottom: .25rem;
    scrollbar-width: thin;
}

.ds-thumb {
    width: 72px;
    height: 52px;
    border-radius: 6px;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid transparent;
    cursor: pointer;
    transition: border-color .15s, opacity .15s;
    opacity: .65;
}

.ds-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.ds-thumb.active { border-color: var(--brand); opacity: 1; }
.ds-thumb:hover { opacity: .9; }

/* ── Layout ── */
.ds-layout {
    max-width: 1160px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 292px;
    gap: 1.25rem;
    align-items: start;
}

.ds-main { display: flex; flex-direction: column; gap: 1.25rem; }

.ds-side {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    position: sticky;
    top: 84px;
}

/* ── Card ── */
.ds-card {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: var(--r-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.ds-card-head {
    display: flex;
    align-items: center;
    gap: .65rem;
    padding: .9rem 1.4rem;
    border-bottom: 1px solid var(--line);
}

.ds-card-head-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--brand); flex-shrink: 0; }

.ds-card-head h6 { margin: 0; font-size: .84rem; font-weight: 650; color: var(--ink); letter-spacing: -.01em; }

.ds-card-head-action { margin-left: auto; }

.ds-card-body { padding: 1.4rem; }

/* ── Badges ── */
.ds-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    padding: .22rem .65rem;
    border-radius: 100px;
    font-size: .68rem;
    font-weight: 700;
    border: 1px solid;
    white-space: nowrap;
    letter-spacing: .02em;
}

.ds-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

.ds-badge.approved { color: #166534; border-color: #BBF7D0; background: var(--success-bg); }
.ds-badge.pending  { color: #92400E; border-color: #FDE68A; background: var(--warn-bg); }
.ds-badge.rejected { color: #991B1B; border-color: #FECACA; background: var(--danger-bg); }
.ds-badge.free     { color: #166534; border-color: #BBF7D0; background: var(--success-bg); }
.ds-badge.paid     { color: var(--brand); border-color: var(--brand-mid); background: var(--brand-glow); }
.ds-badge.featured { color: var(--blue); border-color: #BFDBFE; background: var(--blue-bg); }
.ds-badge.cat      { color: var(--purple); border-color: #DDD6FE; background: var(--purple-bg); }
.ds-badge.glass {
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,.18);
    border-color: rgba(255,255,255,.35);
    color: #fff;
}

/* ── Buttons ── */
.ds-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .6rem 1.25rem;
    border-radius: var(--r-sm);
    font-size: .83rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
    font-family: inherit;
    white-space: nowrap;
}

.ds-btn-primary {
    background: var(--brand);
    color: #fff;
    box-shadow: 0 1px 3px rgba(201,78,7,.3);
}

.ds-btn-primary:hover {
    background: var(--brand-dark);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(201,78,7,.28);
}

.ds-btn-ghost {
    background: var(--surface);
    border: 1.5px solid var(--line-strong);
    color: var(--ink-2);
}

.ds-btn-ghost:hover { border-color: var(--brand); color: var(--brand); background: var(--brand-glow); }

.ds-btn-danger { background: var(--surface); border: 1.5px solid #FECACA; color: var(--danger); }
.ds-btn-danger:hover { background: var(--danger-bg); }

.ds-btn-success { background: var(--surface); border: 1.5px solid #BBF7D0; color: var(--success); }
.ds-btn-success:hover { background: var(--success-bg); }

.ds-btn-sm { padding: .42rem .9rem; font-size: .77rem; }

/* ── Description prose ── */
.ds-prose {
    font-size: .9rem;
    color: var(--ink-2);
    line-height: 1.85;
}

.ds-prose p { margin: 0 0 .85rem; }
.ds-prose p:last-child { margin-bottom: 0; }

.ds-empty { font-size: .83rem; color: var(--ink-4); font-style: italic; }

/* ── Spec grid ── */
.ds-specs {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .75rem;
}

.ds-spec-tile {
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-md);
    padding: .9rem 1rem;
    transition: border-color .15s;
}

.ds-spec-tile:hover { border-color: var(--brand-mid); }

.ds-spec-key {
    font-size: .67rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--ink-4);
    margin-bottom: .35rem;
}

.ds-spec-val {
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--ink);
}

.ds-spec-unit {
    font-size: .72rem;
    font-weight: 500;
    color: var(--ink-3);
    margin-left: .2rem;
}

/* ── Meta table ── */
.ds-meta-table {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1px;
    background: var(--line);
    border: 1px solid var(--line);
    border-radius: var(--r-md);
    overflow: hidden;
}

.ds-meta-cell {
    background: var(--surface);
    padding: .85rem 1.1rem;
    transition: background .12s;
}

.ds-meta-cell:hover { background: var(--bg); }

.ds-meta-key {
    font-size: .67rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--ink-4);
    margin-bottom: .28rem;
}

.ds-meta-val {
    font-size: .875rem;
    color: var(--ink);
    font-weight: 500;
}

.ds-meta-val.accent { color: var(--brand); }
.ds-meta-val.mono   { font-family: 'Courier New', monospace; font-size: .8rem; color: var(--ink-3); }
.ds-meta-val.muted  { color: var(--ink-4); font-weight: 400; font-style: italic; }

/* ── Design file row ── */
.ds-file-row {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: 1rem;
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-md);
}

.ds-file-ext {
    width: 44px; height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .63rem;
    font-weight: 800;
    letter-spacing: .05em;
    flex-shrink: 0;
}

.ds-file-ext.pdf { background: #FEF2F2; color: #B91C1C; }
.ds-file-ext.zip { background: #FFFBEB; color: #92400E; }
.ds-file-ext.dwg { background: #EFF6FF; color: #1D4ED8; }
.ds-file-ext.other { background: var(--purple-bg); color: var(--purple); }

.ds-file-info      { flex: 1; min-width: 0; }
.ds-file-info b    { display: block; font-size: .84rem; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ds-file-info span { font-size: .73rem; color: var(--ink-4); }

/* ── Analytics card ── */
.ds-analytics-nums {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1px;
    background: var(--line);
    border-radius: var(--r-md);
    overflow: hidden;
    margin-bottom: 1.1rem;
}

.ds-analytics-num {
    background: var(--surface);
    padding: 1rem 1.1rem;
}

.ds-analytics-num .key {
    font-size: .67rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--ink-4);
    margin-bottom: .35rem;
}

.ds-analytics-num .val {
    font-size: 1.7rem;
    font-weight: 800;
    color: var(--ink);
    line-height: 1;
}

.ds-analytics-num .sub {
    font-size: .7rem;
    color: var(--ink-4);
    margin-top: .25rem;
}

/* Period bars */
.ds-period-bars { display: flex; flex-direction: column; gap: .55rem; margin-bottom: 1.1rem; }

.ds-period-row { display: flex; align-items: center; gap: .65rem; }

.ds-period-lbl {
    width: 76px;
    font-size: .72rem;
    color: var(--ink-3);
    flex-shrink: 0;
}

.ds-period-track {
    flex: 1;
    height: 6px;
    background: var(--bg);
    border-radius: 3px;
    overflow: hidden;
    border: 1px solid var(--line);
}

.ds-period-fill {
    height: 100%;
    background: var(--brand);
    border-radius: 3px;
    transition: width .5s cubic-bezier(.4,0,.2,1);
}

.ds-period-count {
    width: 28px;
    text-align: right;
    font-size: .77rem;
    font-weight: 700;
    color: var(--ink);
    flex-shrink: 0;
}

/* Sparkline label */
.ds-spark-label {
    font-size: .67rem;
    font-weight: 700;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: var(--ink-4);
    margin-bottom: .65rem;
}

.ds-spark-axis {
    display: flex;
    justify-content: space-between;
    margin-top: .35rem;
}

.ds-spark-axis span { font-size: .62rem; color: var(--ink-4); }

/* ── Status action buttons ── */
.ds-status-actions { display: flex; flex-direction: column; gap: .45rem; }

.ds-status-btn {
    display: flex;
    align-items: center;
    gap: .6rem;
    padding: .65rem .9rem;
    border-radius: var(--r-sm);
    border: 1.5px solid var(--line);
    background: var(--surface);
    font-family: inherit;
    font-size: .82rem;
    font-weight: 500;
    cursor: pointer;
    transition: all .15s;
    color: var(--ink-2);
    text-align: left;
    width: 100%;
}

.ds-status-btn:hover { border-color: var(--brand); color: var(--ink); background: var(--brand-glow); }

.ds-status-btn.current { cursor: default; }
.ds-status-btn.approved { color: #166534; border-color: #BBF7D0; background: var(--success-bg); }
.ds-status-btn.pending  { color: #92400E; border-color: #FDE68A; background: var(--warn-bg); }
.ds-status-btn.rejected { color: #991B1B; border-color: #FECACA; background: var(--danger-bg); }

.ds-current-tag {
    margin-left: auto;
    font-size: .67rem;
    font-weight: 700;
    opacity: .6;
    letter-spacing: .04em;
    text-transform: uppercase;
}

/* Featured button */
.ds-feature-btn {
    display: flex;
    align-items: center;
    gap: .6rem;
    padding: .65rem .9rem;
    border-radius: var(--r-sm);
    border: 1.5px solid #BFDBFE;
    background: var(--surface);
    font-family: inherit;
    font-size: .82rem;
    font-weight: 500;
    cursor: pointer;
    color: var(--blue);
    text-align: left;
    width: 100%;
    transition: all .15s;
}

.ds-feature-btn.on { background: var(--blue-bg); }
.ds-feature-btn:hover { background: var(--blue-bg); }

/* ── Plan card ── */
.ds-plan-rows { display: flex; flex-direction: column; }

.ds-plan-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .6rem 0;
    border-bottom: 1px solid var(--line);
    font-size: .82rem;
}

.ds-plan-row:last-child { border-bottom: none; padding-bottom: 0; }
.ds-plan-row .key { color: var(--ink-3); }
.ds-plan-row .val { color: var(--ink); font-weight: 600; }
.ds-plan-row .val.mono { font-family: monospace; font-size: .78rem; color: var(--brand); }

/* ── User row ── */
.ds-user-row { display: flex; align-items: center; gap: .85rem; }

.ds-avatar {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: var(--brand-glow);
    border: 2px solid var(--brand-mid);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: .85rem;
    color: var(--brand);
    flex-shrink: 0;
}

.ds-user-name  { font-size: .88rem; font-weight: 600; color: var(--ink); }
.ds-user-email { font-size: .74rem; color: var(--ink-4); margin-top: .1rem; }

/* ── Divider ── */
.ds-divider { height: 1px; background: var(--line); margin: 1rem 0; }

/* ── Top bar (below hero) ── */
.ds-topbar {
    max-width: 1160px;
    margin: 0 auto 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
    flex-wrap: wrap;
}

.ds-topbar-actions { display: flex; gap: .45rem; flex-wrap: wrap; align-items: center; }

/* ── Approve modal ── */
.ds-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(3px);
    z-index: 9000;
    align-items: center;
    justify-content: center;
}

.ds-modal-backdrop.open { display: flex; }

.ds-modal {
    background: var(--surface);
    border-radius: var(--r-lg);
    width: min(440px, 94vw);
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    overflow: hidden;
    animation: modalIn .2s cubic-bezier(.34,1.56,.64,1);
}

@keyframes modalIn {
    from { opacity: 0; transform: scale(.95) translateY(12px); }
    to   { opacity: 1; transform: none; }
}

.ds-modal-head {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: 1.25rem 1.5rem 1rem;
    border-bottom: 1px solid var(--line);
}

.ds-modal-head-icon {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: var(--success-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ds-modal-title { font-size: .95rem; font-weight: 700; color: var(--ink); margin: 0; }
.ds-modal-close {
    margin-left: auto;
    background: none;
    border: none;
    color: var(--ink-3);
    cursor: pointer;
    padding: .25rem;
    border-radius: 4px;
    transition: color .15s;
}

.ds-modal-close:hover { color: var(--ink); }

.ds-modal-body { padding: 1.25rem 1.5rem; }

.ds-modal-subject {
    background: var(--bg);
    border: 1px solid var(--line);
    border-radius: var(--r-md);
    padding: .85rem 1rem;
    margin-bottom: 1rem;
}

.ds-modal-subject-title { font-size: .88rem; font-weight: 600; color: var(--ink); margin-bottom: .15rem; }
.ds-modal-subject-sub   { font-size: .75rem; color: var(--ink-3); }

.ds-payment-summary {
    border: 1px solid #FDE68A;
    background: var(--warn-bg);
    border-radius: var(--r-md);
    padding: .85rem 1rem;
    margin-bottom: 1rem;
}

.ds-payment-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: .8rem;
    padding: .2rem 0;
}

.ds-payment-row .k { color: var(--ink-3); }
.ds-payment-row .v { font-weight: 600; color: var(--ink); }
.ds-payment-row .v.mono { font-family: monospace; color: var(--brand); }

.ds-modal-note { font-size: .78rem; color: var(--ink-3); line-height: 1.55; }

.ds-modal-foot {
    display: flex;
    justify-content: flex-end;
    gap: .5rem;
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--line);
}

/* ── Responsive ── */
@media (max-width: 960px) {
    .ds-layout { grid-template-columns: 1fr; }
    .ds-side { position: static; }
    .ds-specs { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 600px) {
    .ds-hero { aspect-ratio: 16 / 9; }
    .ds-hero-title { font-size: 1.2rem; }
    .ds-specs { grid-template-columns: 1fr 1fr; }
    .ds-meta-table { grid-template-columns: 1fr; }
    .ds-analytics-nums { grid-template-columns: 1fr; }
    .ds-topbar { flex-direction: column; align-items: flex-start; }
}
</style>

<div class="ds-root">

    {{-- ── Breadcrumb ── --}}
    <nav class="ds-bc">
        <a href="{{ route('admin.architectural-designs.index') }}">Designs</a>
        <span class="ds-bc-dot"></span>
        <span style="color:var(--ink-2)">{{ Str::limit($architecturalDesign->title, 48) }}</span>
    </nav>

    {{-- ── Alerts ── --}}
    @if(session('success'))
    <div class="ds-alert ds-alert-ok">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="ds-alert ds-alert-err">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Hero ── --}}
    <div class="ds-hero" id="heroEl">
        @if($architecturalDesign->images && $architecturalDesign->images->isNotEmpty())
        <img id="heroImg"
             src="{{ asset('image/architectural_designs/images/' . ($architecturalDesign->primaryImage?->image_path ?? $architecturalDesign->images->first()->image_path)) }}"
             alt="{{ $architecturalDesign->title }}">
        @elseif($architecturalDesign->preview_image)
        <img id="heroImg"
             src="{{ asset('image/architectural_designs/previews/' . $architecturalDesign->preview_image) }}"
             alt="{{ $architecturalDesign->title }}">
        @else
        <div class="ds-hero-empty">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                <rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/>
                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
            </svg>
            <span>No preview image uploaded</span>
        </div>
        @endif
        <div class="ds-hero-veil"></div>
        <div class="ds-hero-bottom">
            <div>
                <h1 class="ds-hero-title">{{ $architecturalDesign->title }}</h1>
                <div class="ds-hero-chips">
                    <span class="ds-badge glass {{ $architecturalDesign->status }}">
                        <span class="ds-badge-dot"></span>{{ ucfirst($architecturalDesign->status) }}
                    </span>
                    @if($architecturalDesign->is_free || $architecturalDesign->price == 0)
                    <span class="ds-badge glass">Free</span>
                    @else
                    <span class="ds-badge glass">{{ $architecturalDesign->currency }} {{ number_format($architecturalDesign->price) }}</span>
                    @endif
                    @if($architecturalDesign->featured)
                    <span class="ds-badge glass">⭐ Featured</span>
                    @endif
                    @if($architecturalDesign->category)
                    <span class="ds-badge glass">{{ $architecturalDesign->category->name }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ── Thumbnail strip ── --}}
    @if($architecturalDesign->images && $architecturalDesign->images->count() > 1)
    <div class="ds-thumb-strip" id="thumbStrip">
        @foreach($architecturalDesign->images as $idx => $img)
        <div class="ds-thumb {{ $idx === 0 ? 'active' : '' }}"
             data-src="{{ asset('image/architectural_designs/images/' . $img->image_path) }}"
             onclick="switchHeroImg(this)">
            <img src="{{ asset('image/architectural_designs/images/' . $img->image_path) }}" alt="Preview {{ $idx + 1 }}">
        </div>
        @endforeach
    </div>
    @endif

    {{-- ── Top action bar ── --}}
    <div class="ds-topbar">
        <div style="font-size:.78rem;color:var(--ink-3)">
            Added {{ $architecturalDesign->created_at->format('M j, Y') }}
            &nbsp;·&nbsp;
            Updated {{ $architecturalDesign->updated_at->diffForHumans() }}
        </div>
        <div class="ds-topbar-actions">
            <a href="{{ route('admin.architectural-designs.edit', $architecturalDesign->id) }}"
               class="ds-btn ds-btn-ghost ds-btn-sm">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Edit
            </a>
            @if($architecturalDesign->design_file || $architecturalDesign->design_file_path)
            @php
                $filePath = $architecturalDesign->design_file_path ?? $architecturalDesign->design_file;
            @endphp
            <a href="{{ asset('image/architectural_designs/files/' . $filePath) }}" download class="ds-btn ds-btn-primary ds-btn-sm">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="3" x2="12" y2="15"/>
                </svg>
                Download File
            </a>
            @endif
            <form method="POST"
                  action="{{ route('admin.architectural-designs.destroy', $architecturalDesign->id) }}"
                  onsubmit="return confirm('Permanently delete this design?')">
                @csrf @method('DELETE')
                <button type="submit" class="ds-btn ds-btn-danger ds-btn-sm">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                    Delete
                </button>
            </form>
        </div>
    </div>

    {{-- ══════════ BODY GRID ══════════ --}}
    <div class="ds-layout">

        {{-- ════ MAIN ════ --}}
        <div class="ds-main">

            {{-- ── Description ── --}}
            <div class="ds-card">
                <div class="ds-card-head">
                    <span class="ds-card-head-dot"></span>
                    <h6>Description</h6>
                    <a href="{{ route('admin.architectural-designs.edit', $architecturalDesign->id) }}"
                       class="ds-btn ds-btn-ghost ds-btn-sm ds-card-head-action" style="padding:.3rem .65rem;font-size:.72rem">
                        Edit
                    </a>
                </div>
                <div class="ds-card-body">
                    @if($architecturalDesign->description)
                    <div class="ds-prose">
                        {!! nl2br(e($architecturalDesign->description)) !!}
                    </div>
                    @else
                    <p class="ds-empty">No description has been added yet.</p>
                    @endif
                </div>
            </div>

            {{-- ── Specs ── --}}
            @if($architecturalDesign->bedrooms || $architecturalDesign->bathrooms || $architecturalDesign->floors || $architecturalDesign->total_area || $architecturalDesign->plot_size || $architecturalDesign->style)
            <div class="ds-card">
                <div class="ds-card-head">
                    <span class="ds-card-head-dot"></span>
                    <h6>Specifications</h6>
                </div>
                <div class="ds-card-body">
                    <div class="ds-specs">
                        @if($architecturalDesign->bedrooms)
                        <div class="ds-spec-tile">
                            <div class="ds-spec-key">Bedrooms</div>
                            <div class="ds-spec-val">{{ $architecturalDesign->bedrooms }}</div>
                        </div>
                        @endif
                        @if($architecturalDesign->bathrooms)
                        <div class="ds-spec-tile">
                            <div class="ds-spec-key">Bathrooms</div>
                            <div class="ds-spec-val">{{ $architecturalDesign->bathrooms }}</div>
                        </div>
                        @endif
                        @if($architecturalDesign->floors)
                        <div class="ds-spec-tile">
                            <div class="ds-spec-key">Floors</div>
                            <div class="ds-spec-val">{{ $architecturalDesign->floors }}</div>
                        </div>
                        @endif
                        @if($architecturalDesign->total_area)
                        <div class="ds-spec-tile">
                            <div class="ds-spec-key">Total Area</div>
                            <div class="ds-spec-val">{{ number_format($architecturalDesign->total_area) }}<span class="ds-spec-unit">m²</span></div>
                        </div>
                        @endif
                        @if($architecturalDesign->plot_size)
                        <div class="ds-spec-tile">
                            <div class="ds-spec-key">Plot Size</div>
                            <div class="ds-spec-val">{{ number_format($architecturalDesign->plot_size) }}<span class="ds-spec-unit">m²</span></div>
                        </div>
                        @endif
                        @if($architecturalDesign->style)
                        <div class="ds-spec-tile">
                            <div class="ds-spec-key">Style</div>
                            <div class="ds-spec-val" style="font-size:.88rem">{{ $architecturalDesign->style }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- ── Design Details ── --}}
            <div class="ds-card">
                <div class="ds-card-head">
                    <span class="ds-card-head-dot"></span>
                    <h6>Design Details</h6>
                </div>
                <div class="ds-card-body" style="padding:0">
                    <div class="ds-meta-table">
                        <div class="ds-meta-cell">
                            <div class="ds-meta-key">Slug</div>
                            <div class="ds-meta-val mono">{{ $architecturalDesign->slug }}</div>
                        </div>
                        <div class="ds-meta-cell">
                            <div class="ds-meta-key">Category</div>
                            <div class="ds-meta-val">{{ $architecturalDesign->category?->name ?? '—' }}</div>
                        </div>
                        <div class="ds-meta-cell">
                            <div class="ds-meta-key">Price</div>
                            <div class="ds-meta-val accent">
                                {{ ($architecturalDesign->is_free || $architecturalDesign->price == 0) ? 'Free' : ($architecturalDesign->currency . ' ' . number_format($architecturalDesign->price)) }}
                            </div>
                        </div>
                        <div class="ds-meta-cell">
                            <div class="ds-meta-key">Status</div>
                            <div class="ds-meta-val">
                                <span class="ds-badge {{ $architecturalDesign->status }}">
                                    <span class="ds-badge-dot"></span>{{ ucfirst($architecturalDesign->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="ds-meta-cell">
                            <div class="ds-meta-key">Featured</div>
                            <div class="ds-meta-val">{{ $architecturalDesign->featured ? 'Yes' : 'No' }}</div>
                        </div>
                        <div class="ds-meta-cell">
                            <div class="ds-meta-key">Downloadable</div>
                            <div class="ds-meta-val">{{ ($architecturalDesign->is_downloadable ?? true) ? 'Yes' : 'No' }}</div>
                        </div>
                        <div class="ds-meta-cell">
                            <div class="ds-meta-key">Uploaded</div>
                            <div class="ds-meta-val">{{ $architecturalDesign->created_at->format('M j, Y') }}</div>
                        </div>
                        <div class="ds-meta-cell">
                            <div class="ds-meta-key">Last Updated</div>
                            <div class="ds-meta-val">{{ $architecturalDesign->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Design File ── --}}
            <div class="ds-card">
                <div class="ds-card-head">
                    <span class="ds-card-head-dot"></span>
                    <h6>Design File</h6>
                </div>
                <div class="ds-card-body">
                    @php
                        $designFilePath = $architecturalDesign->design_file_path ?? $architecturalDesign->design_file ?? null;
                    @endphp
                    @if($designFilePath)
                    @php
                        $ext      = strtolower(pathinfo($designFilePath, PATHINFO_EXTENSION));
                        $iconCls  = in_array($ext, ['pdf','zip','dwg']) ? $ext : 'other';
                        $filename = basename($designFilePath);
                    @endphp
                    <div class="ds-file-row">
                        <div class="ds-file-ext {{ $iconCls }}">{{ strtoupper($ext) }}</div>
                        <div class="ds-file-info">
                            <b>{{ $filename }}</b>
                            <span>{{ strtoupper($ext) }} · design package</span>
                        </div>
                        <a href="{{ Storage::url($designFilePath) }}" download
                           class="ds-btn ds-btn-ghost ds-btn-sm">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                <polyline points="7 10 12 15 17 10"/>
                                <line x1="12" y1="3" x2="12" y2="15"/>
                            </svg>
                            Download
                        </a>
                    </div>
                    @else
                    <p class="ds-empty">No design file uploaded.</p>
                    @endif
                </div>
            </div>

        </div>{{-- /.ds-main --}}

        {{-- ════ SIDEBAR ════ --}}
        <div class="ds-side">

            {{-- ── View Analytics ── --}}
            <div class="ds-card">
                <div class="ds-card-head">
                    <span class="ds-card-head-dot"></span>
                    <h6>View Analytics</h6>
                    @if($architecturalDesign->status !== 'approved')
                    <span style="margin-left:auto;font-size:.67rem;color:var(--ink-4);background:var(--bg);padding:.18rem .5rem;border-radius:100px;border:1px solid var(--line)">Active only</span>
                    @endif
                </div>
                <div class="ds-card-body">

                    <div class="ds-analytics-nums">
                        <div class="ds-analytics-num">
                            <div class="key">Total Views</div>
                            <div class="val">{{ number_format($viewStats['total']) }}</div>
                            <div class="sub">all time</div>
                        </div>
                        <div class="ds-analytics-num">
                            <div class="key">Unique Visitors</div>
                            <div class="val">{{ number_format($viewStats['unique']) }}</div>
                            <div class="sub">distinct IPs</div>
                        </div>
                    </div>

                    @php
                        $periods   = [['Today', $viewStats['today']], ['This week', $viewStats['this_week']], ['This month', $viewStats['this_month']]];
                        $maxPeriod = max(max(array_column($periods, 1)), 1);
                    @endphp

                    <div class="ds-period-bars">
                        @foreach($periods as [$lbl, $val])
                        <div class="ds-period-row">
                            <span class="ds-period-lbl">{{ $lbl }}</span>
                            <div class="ds-period-track">
                                <div class="ds-period-fill" style="width:{{ $maxPeriod > 0 ? round(($val / $maxPeriod) * 100) : 0 }}%"></div>
                            </div>
                            <span class="ds-period-count">{{ number_format($val) }}</span>
                        </div>
                        @endforeach
                    </div>

                    @php
                        $chartData = $viewStats['daily_chart'];
                        $chartVals = array_values($chartData);
                        $chartDates= array_keys($chartData);
                        $chartMax  = max(array_values($chartData) ?: [1]);
                        $barCount  = count($chartVals);
                    @endphp

                    <div class="ds-spark-label">Last 14 Days</div>

                    @if(array_sum($chartVals) === 0)
                    <div style="text-align:center;padding:18px 0;font-size:.77rem;color:var(--ink-4)">No views in the last 14 days.</div>
                    @else
                    <svg viewBox="0 0 280 56" xmlns="http://www.w3.org/2000/svg"
                         style="width:100%;height:56px;overflow:visible" aria-label="14-day view chart">
                        <line x1="0" y1="0"  x2="280" y2="0"  stroke="var(--line)" stroke-width=".5"/>
                        <line x1="0" y1="28" x2="280" y2="28" stroke="var(--line)" stroke-width=".5" stroke-dasharray="3,3"/>
                        <line x1="0" y1="55" x2="280" y2="55" stroke="var(--line)" stroke-width=".5"/>
                        @php
                            $bw  = max(floor(280 / $barCount) - 2, 4);
                            $gap = (280 - ($bw * $barCount)) / ($barCount + 1);
                        @endphp
                        @foreach($chartVals as $i => $val)
                        @php
                            $bh   = $chartMax > 0 ? max(2, round(($val / $chartMax) * 52)) : 2;
                            $bx   = round($gap + $i * ($bw + $gap));
                            $by   = 54 - $bh;
                            $last = $i === $barCount - 1;
                        @endphp
                        <rect x="{{ $bx }}" y="{{ $by }}" width="{{ $bw }}" height="{{ $bh }}" rx="2"
                              fill="{{ $last ? 'var(--brand)' : '#D1D5DB' }}"
                              opacity="{{ $last ? 1 : .7 }}">
                            <title>{{ $chartDates[$i] }}: {{ $val }} view{{ $val === 1 ? '' : 's' }}</title>
                        </rect>
                        @endforeach
                    </svg>

                    <div class="ds-spark-axis">
                        <span>{{ \Carbon\Carbon::parse($chartDates[0])->format('d M') }}</span>
                        <span>{{ \Carbon\Carbon::parse($chartDates[floor($barCount / 2)])->format('d M') }}</span>
                        <span>{{ \Carbon\Carbon::parse(end($chartDates))->format('d M') }}</span>
                    </div>
                    @endif

                </div>
            </div>

            {{-- ── Plan & Approval ── --}}
            @php $payment = $architecturalDesign->payments()->with('listingPackage')->latest()->first(); @endphp
            <div class="ds-card">
                <div class="ds-card-head">
                    <span class="ds-card-head-dot"></span>
                    <h6>Plan &amp; Payment</h6>
                    <span class="ds-badge {{ $architecturalDesign->is_approved ? 'approved' : 'pending' }}" style="margin-left:auto">
                        <span class="ds-badge-dot"></span>
                        {{ $architecturalDesign->is_approved ? 'Approved' : 'Pending' }}
                    </span>
                </div>
                <div class="ds-card-body">
                    @if($payment)
                    <div class="ds-plan-rows">
                        <div class="ds-plan-row">
                            <span class="key">Package</span>
                            <span class="val">{{ ucfirst($payment->listingPackage?->package_tier ?? 'N/A') }}</span>
                        </div>
                        <div class="ds-plan-row">
                            <span class="key">Rate</span>
                            <span class="val">{{ number_format($payment->listingPackage?->price_per_day ?? 0) }} RWF/day</span>
                        </div>
                        <div class="ds-plan-row">
                            <span class="key">Duration</span>
                            <span class="val">{{ $payment->payable?->listing_days ?? '—' }} days</span>
                        </div>
                        <div class="ds-plan-row">
                            <span class="key">Total</span>
                            <span class="val">{{ number_format($payment->amount) }} RWF</span>
                        </div>
                        <div class="ds-plan-row">
                            <span class="key">Payment</span>
                            <span class="ds-badge {{ match($payment->status) { 'completed' => 'approved', 'pending' => 'pending', default => 'rejected' } }}">
                                <span class="ds-badge-dot"></span>{{ ucfirst($payment->status) }}
                            </span>
                        </div>
                        <div class="ds-plan-row">
                            <span class="key">Reference</span>
                            <span class="val mono">{{ $payment->reference }}</span>
                        </div>
                    </div>

                    @if($payment->status === 'completed' && !$architecturalDesign->is_approved)
                    <button type="button" class="ds-btn ds-btn-success"
                            style="width:100%;justify-content:center;margin-top:1rem"
                            onclick="document.getElementById('approveModal').classList.add('open')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Approve &amp; Publish
                    </button>
                    @endif

                    @if($payment->status === 'pending')
                    <a href="{{ route('payment.show', $payment->reference) }}"
                       class="ds-btn ds-btn-ghost" style="width:100%;justify-content:center;margin-top:1rem">
                        Complete Payment →
                    </a>
                    @endif

                    @else
                    <p class="ds-empty">No payment record found.</p>
                    @endif
                </div>
            </div>

            {{-- ── Change Status ── --}}
            <div class="ds-card">
                <div class="ds-card-head">
                    <span class="ds-card-head-dot"></span>
                    <h6>Change Status</h6>
                </div>
                <div class="ds-card-body">
                    <div class="ds-status-actions">
                        @foreach([
                            'approved' => ['label' => 'Approve',     'path' => '<path d="M20 6 9 17l-5-5"/>'],
                            'pending'  => ['label' => 'Set Pending', 'path' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
                            'rejected' => ['label' => 'Reject',      'path' => '<path d="M18 6 6 18M6 6l12 12"/>'],
                        ] as $status => $meta)
                        @if($architecturalDesign->status === $status)
                        <div class="ds-status-btn {{ $status }} current">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $meta['path'] !!}</svg>
                            {{ $meta['label'] }}
                            <span class="ds-current-tag">Current</span>
                        </div>
                        @else
                        <form method="POST" action="{{ route('admin.architectural-designs.status', $architecturalDesign->id) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="{{ $status }}">
                            <button type="submit" class="ds-status-btn">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $meta['path'] !!}</svg>
                                {{ $meta['label'] }}
                            </button>
                        </form>
                        @endif
                        @endforeach
                    </div>

                    <div class="ds-divider"></div>

                    <form method="POST" action="{{ route('admin.architectural-designs.feature', $architecturalDesign->id) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="ds-feature-btn {{ $architecturalDesign->featured ? 'on' : '' }}">
                            <svg width="14" height="14" viewBox="0 0 24 24"
                                 fill="{{ $architecturalDesign->featured ? 'currentColor' : 'none' }}"
                                 stroke="currentColor" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                            {{ $architecturalDesign->featured ? 'Remove from Featured' : 'Mark as Featured' }}
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── Uploaded By ── --}}
            <div class="ds-card">
                <div class="ds-card-head">
                    <span class="ds-card-head-dot"></span>
                    <h6>Uploaded By</h6>
                </div>
                <div class="ds-card-body">
                    @if($architecturalDesign->user)
                    <div class="ds-user-row">
                        <div class="ds-avatar">{{ strtoupper(substr($architecturalDesign->user->name, 0, 2)) }}</div>
                        <div>
                            <div class="ds-user-name">{{ $architecturalDesign->user->name }}</div>
                            <div class="ds-user-email">{{ $architecturalDesign->user->email }}</div>
                        </div>
                    </div>
                    @else
                    <div class="ds-user-row">
                        <div class="ds-avatar" style="background:var(--bg);color:var(--ink-4)">AD</div>
                        <div>
                            <div class="ds-user-name">Admin</div>
                            <div class="ds-user-email">Uploaded by admin account</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ── Danger Zone ── --}}
            <div class="ds-card" style="border-color:#FECACA">
                <div class="ds-card-head" style="background:var(--danger-bg);border-color:#FECACA">
                    <span class="ds-card-head-dot" style="background:var(--danger)"></span>
                    <h6 style="color:var(--danger)">Danger Zone</h6>
                </div>
                <div class="ds-card-body">
                    <p style="font-size:.78rem;color:var(--ink-3);margin:0 0 .85rem;line-height:1.6">
                        Permanently removes the design, all uploaded files, and preview images from storage. This cannot be undone.
                    </p>
                    <form method="POST"
                          action="{{ route('admin.architectural-designs.destroy', $architecturalDesign->id) }}"
                          onsubmit="return confirm('Delete this design permanently? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="ds-btn ds-btn-danger"
                                style="width:100%;justify-content:center">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6M14 11v6M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                            </svg>
                            Delete Design
                        </button>
                    </form>
                </div>
            </div>

        </div>{{-- /.ds-side --}}

    </div>{{-- /.ds-layout --}}
</div>

{{-- ══ APPROVE MODAL ══ --}}
@if(isset($payment) && $payment?->status === 'completed' && !$architecturalDesign->is_approved)
<div class="ds-modal-backdrop" id="approveModal"
     onclick="if(event.target===this) this.classList.remove('open')">
    <div class="ds-modal">
        <div class="ds-modal-head">
            <div class="ds-modal-head-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h6 class="ds-modal-title">Approve &amp; Publish Design</h6>
            <button type="button" class="ds-modal-close"
                    onclick="document.getElementById('approveModal').classList.remove('open')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.architectural-designs.approve', $architecturalDesign) }}">
            @csrf
            <div class="ds-modal-body">
                <p style="font-size:.8rem;color:var(--ink-3);margin:0 0 .85rem">You are approving the following design and making it publicly visible on Terra:</p>

                <div class="ds-modal-subject">
                    <div class="ds-modal-subject-title">{{ $architecturalDesign->title }}</div>
                    <div class="ds-modal-subject-sub">Uploaded by {{ $architecturalDesign->user?->name ?? 'Admin' }}</div>
                </div>

                <div class="ds-payment-summary">
                    <div class="ds-payment-row">
                        <span class="k">Package</span>
                        <span class="v">{{ ucfirst($payment->listingPackage?->package_tier ?? 'N/A') }}</span>
                    </div>
                    <div class="ds-payment-row">
                        <span class="k">Amount Paid</span>
                        <span class="v" style="color:var(--success)">{{ number_format($payment->amount) }} {{ $payment->currency }}</span>
                    </div>
                    @if($payment->transaction_id)
                    <div class="ds-payment-row">
                        <span class="k">Transaction ID</span>
                        <span class="v mono">{{ $payment->transaction_id }}</span>
                    </div>
                    @endif
                    <div class="ds-payment-row">
                        <span class="k">Reference</span>
                        <span class="v mono">{{ $payment->reference }}</span>
                    </div>
                </div>

                <p class="ds-modal-note">Once approved, the design will be listed publicly on Terra and buyers will be able to view and purchase it.</p>
            </div>
            <div class="ds-modal-foot">
                <button type="button" class="ds-btn ds-btn-ghost ds-btn-sm"
                        onclick="document.getElementById('approveModal').classList.remove('open')">
                    Cancel
                </button>
                <button type="submit" class="ds-btn ds-btn-success ds-btn-sm" style="background:var(--success);color:#fff;border-color:var(--success)">
                    Approve &amp; Publish
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
/* ── Hero image switcher ── */
function switchHeroImg(thumb) {
    const heroImg = document.getElementById('heroImg');
    if (!heroImg) return;
    heroImg.src = thumb.dataset.src;
    document.querySelectorAll('.ds-thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
}

/* ── Close modal on Escape ── */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.ds-modal-backdrop.open')
            .forEach(m => m.classList.remove('open'));
    }
});
</script>

@endsection