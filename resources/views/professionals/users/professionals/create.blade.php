@extends('layouts.app')
@section('title', 'Add New Professional')
@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --navy:    #0f172a;
    --navy-2:  #1e293b;
    --navy-3:  #334155;
    --gold:    #c9a96e;
    --gold-lt: #e8d5a3;
    --gold-bg: rgba(201,169,110,.08);
    --gold-bd: rgba(201,169,110,.25);
    --teal:    #0d9488;
    --teal-bg: rgba(13,148,136,.08);
    --danger:  #ef4444;
    --border:  #e2e8f0;
    --border-2:#cbd5e1;
    --surface: #f8fafc;
    --bg:      #f1f5f9;
    --white:   #ffffff;
    --text:    #0f172a;
    --dim:     #64748b;
    --muted:   #94a3b8;
    --green:   #10b981;
    --blue:    #3b82f6;
    --r:       12px;
    --r-sm:    8px;
    --shadow:  0 1px 3px rgba(15,23,42,.06), 0 4px 16px rgba(15,23,42,.04);
    --shadow-md: 0 4px 20px rgba(15,23,42,.08), 0 1px 4px rgba(15,23,42,.04);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'Plus Jakarta Sans', sans-serif; }

/* ── Page shell ─────────────────────────────────────────────── */
.ap-page { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

/* ── Breadcrumb ─────────────────────────────────────────────── */
.ap-crumb {
    display: flex; align-items: center; gap: .45rem;
    font-size: .76rem; font-weight: 500; color: var(--muted);
    margin-bottom: 1.75rem; letter-spacing: .01em;
}
.ap-crumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
.ap-crumb a:hover { color: var(--gold); }
.ap-crumb svg { opacity: .5; }

/* ── Page heading ───────────────────────────────────────────── */
.ap-heading {
    display: flex; align-items: flex-start; gap: 1.1rem;
    margin-bottom: 2.25rem; padding-bottom: 2.25rem;
    border-bottom: 1px solid var(--border);
}
.ap-heading-icon {
    width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg, #0f172a, #1e3a5f);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 12px rgba(15,23,42,.2);
}
.ap-heading-icon svg { color: var(--gold); }
.ap-heading-text h1 {
    font-family: 'Playfair Display', serif;
    font-size: 1.55rem; font-weight: 600; color: var(--navy);
    letter-spacing: -.02em; line-height: 1.2; margin-bottom: .25rem;
}
.ap-heading-text p { font-size: .83rem; color: var(--dim); font-weight: 400; }
.ap-heading-badge {
    margin-left: auto; flex-shrink: 0;
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .72rem; font-weight: 600; letter-spacing: .04em;
    text-transform: uppercase; color: var(--teal);
    background: var(--teal-bg); border: 1px solid rgba(13,148,136,.2);
    border-radius: 99px; padding: .35rem .85rem;
}

/* ── Alerts ─────────────────────────────────────────────────── */
.ap-alert {
    display: flex; gap: .7rem; align-items: flex-start;
    padding: .95rem 1.2rem; border-radius: var(--r-sm);
    font-size: .83rem; margin-bottom: 1.5rem; line-height: 1.55;
}
.ap-alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }
.ap-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.ap-alert ul { margin: .35rem 0 0 1.1rem; padding: 0; }
.ap-alert li { margin-bottom: .2rem; }

/* ── Layout grid ────────────────────────────────────────────── */
.ap-layout { display: grid; grid-template-columns: 1fr 292px; gap: 1.25rem; align-items: start; }
.ap-main   { display: flex; flex-direction: column; gap: 1.25rem; }
.ap-side   { display: flex; flex-direction: column; gap: 1.25rem; position: sticky; top: 80px; }
@media (max-width: 920px) { .ap-layout { grid-template-columns: 1fr; } .ap-side { position: static; } }

/* ── Cards ──────────────────────────────────────────────────── */
.ap-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden;
}
.ap-card-header {
    display: flex; align-items: center; gap: .8rem;
    padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border);
    background: linear-gradient(to right, var(--surface), var(--white));
}
.ap-card-icon {
    width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: flex; align-items: center; justify-content: center; color: var(--gold);
}
.ap-card-header h6 {
    font-size: .88rem; font-weight: 700; color: var(--navy);
    letter-spacing: -.01em; margin: 0;
}
.ap-card-header p { font-size: .75rem; color: var(--muted); margin: .1rem 0 0; }
.ap-card-body { padding: 1.5rem; }

/* ── Info banner inside card ────────────────────────────────── */
.ap-info-banner {
    display: flex; align-items: flex-start; gap: .65rem;
    padding: .85rem 1rem; border-radius: var(--r-sm);
    background: #eff6ff; border: 1px solid #bfdbfe;
    font-size: .8rem; color: #1d4ed8; line-height: 1.55;
    margin-bottom: 1.35rem;
}

/* ── Form elements ──────────────────────────────────────────── */
.ap-label {
    display: block; font-size: .72rem; font-weight: 700;
    letter-spacing: .05em; text-transform: uppercase;
    color: var(--dim); margin-bottom: .45rem;
}
.ap-label .req { color: var(--danger); margin-left: .2rem; }

.ap-input, .ap-select, .ap-textarea {
    width: 100%; padding: .7rem 1rem;
    border: 1.5px solid var(--border); border-radius: var(--r-sm);
    font-size: .875rem; color: var(--text); background: var(--white);
    font-family: 'Plus Jakarta Sans', sans-serif; outline: none;
    transition: border-color .18s, box-shadow .18s, background .18s;
    line-height: 1.5;
}
.ap-input::placeholder, .ap-textarea::placeholder { color: var(--muted); font-weight: 400; }
.ap-input:focus, .ap-select:focus, .ap-textarea:focus {
    border-color: var(--gold); background: #fffdf9;
    box-shadow: 0 0 0 3px rgba(201,169,110,.12);
}
.ap-input.is-invalid { border-color: var(--danger); background: #fff8f8; }
.ap-textarea { resize: vertical; line-height: 1.65; min-height: 110px; }

.ap-input-icon { position: relative; }
.ap-input-icon .icon {
    position: absolute; left: .95rem; top: 50%; transform: translateY(-50%);
    color: var(--muted); pointer-events: none;
}
.ap-input-icon .ap-input { padding-left: 2.6rem; }

.ap-hint  { font-size: .72rem; color: var(--muted); margin-top: .35rem; }
.ap-error { font-size: .72rem; color: var(--danger); margin-top: .35rem; display: flex; align-items: center; gap: .3rem; }

.ap-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.ap-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }
.ap-stack  { display: flex; flex-direction: column; gap: 1rem; }
@media (max-width: 600px) { .ap-grid-2, .ap-grid-3 { grid-template-columns: 1fr; } }

/* ── Social / link row ──────────────────────────────────────── */
.ap-link-row {
    display: flex; align-items: center; gap: .7rem;
    padding: .65rem 1rem; border: 1.5px solid var(--border);
    border-radius: var(--r-sm); background: var(--white);
    transition: border-color .18s, box-shadow .18s;
}
.ap-link-row:focus-within {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(201,169,110,.12);
}
.ap-link-row .link-icon { flex-shrink: 0; display: flex; align-items: center; }
.ap-link-row input {
    flex: 1; border: none; outline: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: .875rem; color: var(--text); background: transparent;
}
.ap-link-row input::placeholder { color: var(--muted); }

/* ── Section divider ────────────────────────────────────────── */
.ap-section-divider {
    display: flex; align-items: center; gap: .75rem;
    margin: .25rem 0 1rem;
}
.ap-section-divider span {
    font-size: .7rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: var(--gold); white-space: nowrap;
}
.ap-section-divider::before, .ap-section-divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
}

/* ── Services / categories widget ──────────────────────────── */
.svc-wrapper { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed var(--border); }
.svc-step-label {
    display: flex; align-items: center; gap: .6rem;
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: var(--dim); margin-bottom: .85rem;
}
.svc-step-badge {
    width: 20px; height: 20px; border-radius: 50%; background: var(--navy);
    color: #fff; font-size: .62rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.svc-cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 8px; }
.svc-cat-check { position: relative; }
.svc-cat-check input[type="checkbox"] { position: absolute; opacity: 0; width: 0; height: 0; }
.svc-cat-check label {
    display: flex; align-items: center; gap: .55rem;
    padding: .6rem .9rem; border-radius: var(--r-sm);
    border: 1.5px solid var(--border); background: var(--surface);
    cursor: pointer; font-size: .79rem; font-weight: 500; color: var(--dim);
    transition: all .18s; user-select: none;
}
.svc-cat-check input:checked + label {
    border-color: var(--gold-bd); background: var(--gold-bg);
    color: var(--navy); box-shadow: 0 0 0 3px rgba(201,169,110,.08);
}
.svc-cat-check label:hover { border-color: var(--gold-bd); background: var(--gold-bg); color: var(--navy); }
.svc-cat-dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    border: 1.5px solid var(--border-2); background: var(--white);
    transition: all .18s;
}
.svc-cat-check input:checked + label .svc-cat-dot {
    background: var(--gold); border-color: var(--gold);
}
.svc-count-badge {
    margin-left: auto; font-size: .62rem; font-weight: 700;
    background: var(--gold); color: #fff; border-radius: 99px;
    padding: 1px 6px; display: none;
}

.svc-panel { margin-top: 1.25rem; display: none; }
.svc-search-wrap { position: relative; margin-bottom: 1rem; }
.svc-search-wrap .icon {
    position: absolute; left: .9rem; top: 50%; transform: translateY(-50%);
    color: var(--muted); pointer-events: none;
}
.svc-search {
    width: 100%; padding: .65rem .9rem .65rem 2.5rem;
    border: 1.5px solid var(--border); border-radius: var(--r-sm);
    font-size: .82rem; font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text); outline: none; background: var(--surface);
    transition: border-color .18s, box-shadow .18s;
}
.svc-search:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,169,110,.12); background: var(--white); }

.svc-group { margin-bottom: 1.25rem; display: none; }
.svc-group-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: .65rem; padding-bottom: .55rem;
    border-bottom: 1px solid var(--border);
}
.svc-group-title { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--gold); }
.svc-select-all-btn {
    font-size: .72rem; font-weight: 600; color: var(--dim);
    background: none; border: none; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif; padding: 0;
    transition: color .15s;
}
.svc-select-all-btn:hover { color: var(--gold); }
.svc-summary {
    display: none; align-items: center; gap: .6rem;
    margin-top: 1rem; padding: .7rem 1rem; border-radius: var(--r-sm);
    background: var(--teal-bg); border: 1px solid rgba(13,148,136,.2);
    font-size: .8rem; color: var(--teal);
}
.svc-clear-btn {
    margin-left: auto; font-size: .72rem; font-weight: 700; color: var(--danger);
    background: none; border: none; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif; padding: 0;
}
.svc-clear-btn:hover { text-decoration: underline; }

/* ── File upload zones ──────────────────────────────────────── */
.ap-file-zone {
    border: 2px dashed var(--border-2); border-radius: var(--r);
    padding: 1.5rem; text-align: center; cursor: pointer;
    transition: border-color .18s, background .18s; background: var(--surface);
    position: relative;
}
.ap-file-zone:hover { border-color: var(--gold); background: var(--gold-bg); }
.ap-file-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.ap-file-zone .fz-icon { color: var(--gold); margin-bottom: .6rem; }
.ap-file-zone .fz-title { font-size: .84rem; font-weight: 600; color: var(--text); margin-bottom: .2rem; }
.ap-file-zone .fz-sub   { font-size: .74rem; color: var(--muted); }
.ap-file-picked {
    display: none; align-items: center; gap: .75rem;
    padding: .85rem 1rem; border: 1px solid #bbf7d0;
    border-radius: var(--r-sm); background: #f0fdf4; margin-top: .75rem;
    font-size: .83rem; color: #166534;
}
.ap-file-picked.visible { display: flex; }

/* ── Photo upload ───────────────────────────────────────────── */
.ap-photo-zone {
    border: 2px dashed var(--border-2); border-radius: var(--r);
    padding: 1.75rem 1rem; text-align: center; cursor: pointer;
    transition: border-color .18s, background .18s; background: var(--surface);
    position: relative;
}
.ap-photo-zone:hover { border-color: var(--gold); background: var(--gold-bg); }
.ap-photo-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
.ap-photo-avatar {
    width: 72px; height: 72px; border-radius: 50%; overflow: hidden;
    background: linear-gradient(135deg, var(--navy), #2d4a7a);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto .85rem; border: 3px solid var(--gold-bd);
    box-shadow: 0 4px 16px rgba(201,169,110,.2); transition: border-color .18s;
}
.ap-photo-zone:hover .ap-photo-avatar { border-color: var(--gold); }
#imgPreview { width: 100%; height: 100%; object-fit: cover; display: none; }
.ap-photo-avatar svg { color: rgba(255,255,255,.5); }
.ap-photo-zone .fz-title { font-size: .83rem; font-weight: 600; color: var(--text); margin-bottom: .2rem; }
.ap-photo-zone .fz-sub   { font-size: .73rem; color: var(--muted); }

/* ── Live preview card ──────────────────────────────────────── */
.ap-preview-card {
    background: var(--white); border: 1px solid var(--border);
    border-radius: var(--r); overflow: hidden; box-shadow: var(--shadow);
}
.ap-preview-banner {
    height: 52px;
    background: linear-gradient(135deg, var(--navy) 0%, #1e3a5f 50%, #2d4a7a 100%);
    position: relative;
}
.ap-preview-banner::after {
    content: '';
    position: absolute; inset: 0;
    background: repeating-linear-gradient(
        45deg, transparent, transparent 8px,
        rgba(255,255,255,.02) 8px, rgba(255,255,255,.02) 9px
    );
}
.ap-preview-body { padding: 0 1.25rem 1.25rem; }
.ap-preview-avatar-wrap { margin-top: -26px; margin-bottom: .7rem; }
.ap-preview-av {
    width: 52px; height: 52px; border-radius: 50%;
    background: linear-gradient(135deg, var(--navy), #2d4a7a);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1rem; color: #fff;
    border: 3px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,.15);
}
.ap-preview-name  { font-size: .92rem; font-weight: 700; color: var(--navy); margin-bottom: .15rem; }
.ap-preview-email { font-size: .74rem; color: var(--muted); margin-bottom: .3rem; word-break: break-all; }
.ap-preview-role  {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .68rem; font-weight: 600; text-transform: uppercase;
    letter-spacing: .05em; color: var(--gold);
}

/* ── Toggle switch ──────────────────────────────────────────── */
.ap-toggle-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: .8rem 0; border-bottom: 1px solid var(--border);
}
.ap-toggle-row:last-of-type { border-bottom: none; padding-bottom: 0; }
.ap-toggle-label { font-size: .84rem; font-weight: 500; color: var(--text); }
.ap-toggle-desc  { font-size: .72rem; color: var(--muted); margin-top: .1rem; }
.ap-switch { position: relative; width: 40px; height: 23px; flex-shrink: 0; }
.ap-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
.ap-switch-track {
    position: absolute; inset: 0; background: var(--border-2);
    border-radius: 100px; cursor: pointer; transition: background .2s;
}
.ap-switch-track::before {
    content: ''; position: absolute; width: 17px; height: 17px;
    border-radius: 50%; background: #fff; top: 3px; left: 3px;
    transition: transform .2s; box-shadow: 0 1px 4px rgba(0,0,0,.2);
}
.ap-switch input:checked + .ap-switch-track { background: var(--gold); }
.ap-switch input:checked + .ap-switch-track::before { transform: translateX(17px); }

/* ── Submit bar ─────────────────────────────────────────────── */
.ap-submit-bar {
    display: flex; align-items: center; justify-content: flex-end; gap: .65rem;
    padding: 1.1rem 1.5rem; background: var(--white);
    border: 1px solid var(--border); border-radius: var(--r); box-shadow: var(--shadow);
}
.ap-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .7rem 1.5rem; border-radius: var(--r-sm); font-size: .85rem;
    font-weight: 600; font-family: 'Plus Jakarta Sans', sans-serif;
    border: none; cursor: pointer; transition: all .2s; text-decoration: none;
    letter-spacing: -.01em;
}
.ap-btn-primary {
    background: linear-gradient(135deg, #c9a96e, #b8924d);
    color: #fff; box-shadow: 0 2px 10px rgba(201,169,110,.35);
}
.ap-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 18px rgba(201,169,110,.45); filter: brightness(1.05); }
.ap-btn-ghost { background: none; border: 1.5px solid var(--border-2); color: var(--dim); }
.ap-btn-ghost:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-bg); }

/* ── Success / access info box ──────────────────────────────── */
.ap-access-info {
    margin-top: .85rem; padding: .8rem 1rem; border-radius: var(--r-sm);
    background: #f0fdf4; border: 1px solid #bbf7d0;
    font-size: .78rem; color: #166534; line-height: 1.55;
    display: flex; align-items: flex-start; gap: .5rem;
}
</style>

<div class="ap-page">

    {{-- Breadcrumb --}}
    <nav class="ap-crumb">
        <a href="{{ route('admin.professionals.index') }}">Professionals</a>
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text)">Add New</span>
    </nav>

    {{-- Page Heading --}}
    <div class="ap-heading">
        <div class="ap-heading-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div class="ap-heading-text">
            <h1>Add New Professional</h1>
            <p>A login account will be auto-created and credentials emailed to the professional.</p>
        </div>
        <div class="ap-heading-badge" style="margin-left:auto;align-self:flex-start">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
            Admin Action
        </div>
    </div>

    {{-- Alerts --}}
    @if($errors->any())
        <div class="ap-alert ap-alert-danger">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif
    @if(session('success'))
        <div class="ap-alert ap-alert-success">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.professionals.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="ap-layout">

            {{-- ══════════════════ MAIN COLUMN ══════════════════ --}}
            <div class="ap-main">

                {{-- ── Account & Identity ── --}}
                <div class="ap-card">
                    <div class="ap-card-header">
                        <div class="ap-card-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        </div>
                        <div>
                            <h6>Account &amp; Identity</h6>
                            <p>Core contact information and login credentials.</p>
                        </div>
                    </div>
                    <div class="ap-card-body">
                        <div class="ap-info-banner">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
                            A <strong>login account</strong> will be created automatically. Credentials will be emailed to the address you enter below.
                        </div>
                        <div class="ap-stack">
                            <div class="ap-grid-2">
                                <div>
                                    <label class="ap-label">Full Name <span class="req">*</span></label>
                                    <input type="text" name="full_name" id="fullNameInput"
                                           class="ap-input @error('full_name') is-invalid @enderror"
                                           value="{{ old('full_name') }}"
                                           oninput="syncPreview()"
                                           placeholder="e.g. Dr. Alice Uwimana" required>
                                    @error('full_name')<p class="ap-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="ap-label">Email Address <span class="req">*</span></label>
                                    <input type="email" name="email" id="emailInput"
                                           class="ap-input @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           oninput="syncPreview()"
                                           placeholder="alice@firm.com" required>
                                    <p class="ap-hint">Login credentials will be sent here.</p>
                                    @error('email')<p class="ap-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="ap-grid-2">
                                <div>
                                    <label class="ap-label">Phone <span class="req">*</span></label>
                                    <div class="ap-input-icon">
                                        <svg class="icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                        <input type="text" name="phone" class="ap-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+250 7XX XXX XXX" required>
                                    </div>
                                    @error('phone')<p class="ap-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="ap-label">WhatsApp</label>
                                    <div class="ap-input-icon">
                                        <svg class="icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                        <input type="text" name="whatsapp" class="ap-input @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" placeholder="+250 7XX XXX XXX">
                                    </div>
                                    @error('whatsapp')<p class="ap-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Professional Details ── --}}
                <div class="ap-card">
                    <div class="ap-card-header">
                        <div class="ap-card-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                        </div>
                        <div>
                            <h6>Professional Details</h6>
                            <p>Credentials, expertise, and office information.</p>
                        </div>
                    </div>
                    <div class="ap-card-body ap-stack">
                        <div class="ap-grid-2">
                            <div>
                                <label class="ap-label">Profession / Title</label>
                                <input type="text" name="profession" class="ap-input @error('profession') is-invalid @enderror" value="{{ old('profession') }}" placeholder="e.g. Architect, Lawyer, Valuer">
                                @error('profession')<p class="ap-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ap-label">License / Registration No.</label>
                                <input type="text" name="license_number" class="ap-input @error('license_number') is-invalid @enderror" value="{{ old('license_number') }}" placeholder="e.g. RWA-ARCH-001">
                                @error('license_number')<p class="ap-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="ap-grid-2">
                            <div>
                                <label class="ap-label">Office Location</label>
                                <div class="ap-input-icon">
                                    <svg class="icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <input type="text" name="office_location" class="ap-input @error('office_location') is-invalid @enderror" value="{{ old('office_location') }}" placeholder="e.g. Kigali, KN 5 Rd">
                                </div>
                                @error('office_location')<p class="ap-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ap-label">Languages Spoken</label>
                                <input type="text" name="languages" class="ap-input @error('languages') is-invalid @enderror" value="{{ old('languages') }}" placeholder="English, French, Kinyarwanda">
                                <p class="ap-hint">Comma-separated.</p>
                                @error('languages')<p class="ap-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="ap-label">Bio</label>
                            <textarea name="bio" rows="4" class="ap-textarea @error('bio') is-invalid @enderror" placeholder="Professional background, expertise, notable projects…">{{ old('bio') }}</textarea>
                            @error('bio')<p class="ap-error">{{ $message }}</p>@enderror
                        </div>

                        {{-- Services widget --}}
                        @if($serviceCategories->count())
                        <div class="svc-wrapper">
                            <div class="ap-section-divider"><span>Services Offered</span></div>

                            <div class="svc-step-label">
                                <span class="svc-step-badge">1</span>
                                Select service categories
                            </div>
                            <div class="svc-cat-grid" id="catGrid">
                                @foreach($serviceCategories as $cat)
                                <div class="svc-cat-check">
                                    <input type="checkbox"
                                           class="cat-trigger"
                                           name="service_categories[]"
                                           id="cat{{ $cat->id }}"
                                           value="{{ $cat->id }}"
                                           data-cat-id="{{ $cat->id }}"
                                           {{ in_array($cat->id, old('service_categories', [])) ? 'checked' : '' }}>
                                    <label for="cat{{ $cat->id }}">
                                        <span class="svc-cat-dot"></span>
                                        {{ $cat->name }}
                                        <span class="svc-count-badge" id="count-{{ $cat->id }}">0</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <div class="svc-panel" id="servicesPanel">
                                <div class="svc-step-label" style="margin-top:1.25rem">
                                    <span class="svc-step-badge">2</span>
                                    Choose specific services
                                </div>
                                <div class="svc-search-wrap">
                                    <svg class="icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                    <input type="text" id="serviceSearch" class="svc-search" placeholder="Filter services…">
                                </div>
                                <div id="serviceGroups">
                                    @foreach($serviceCategories as $cat)
                                        @if($cat->services->count())
                                        <div class="svc-group" id="group-{{ $cat->id }}">
                                            <div class="svc-group-header">
                                                <span class="svc-group-title">{{ $cat->name }}</span>
                                                <button type="button" class="svc-select-all-btn select-all-btn" data-group="{{ $cat->id }}">Select all</button>
                                            </div>
                                            <div class="svc-cat-grid">
                                                @foreach($cat->services as $svc)
                                                <div class="svc-cat-check">
                                                    <input type="checkbox"
                                                           class="service-check"
                                                           id="svc{{ $svc->id }}"
                                                           name="services[]"
                                                           value="{{ $svc->id }}"
                                                           data-group="{{ $cat->id }}"
                                                           data-name="{{ strtolower($svc->title) }}"
                                                           {{ in_array($svc->id, old('services', [])) ? 'checked' : '' }}>
                                                    <label for="svc{{ $svc->id }}">
                                                        <span class="svc-cat-dot"></span>{{ $svc->title }}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="svc-summary" id="selectedSummary">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 6 9 17l-5-5"/></svg>
                                    <strong id="selectedCount">0</strong>&nbsp;service(s) selected
                                    <button type="button" id="clearServices" class="svc-clear-btn">Clear all</button>
                                </div>
                            </div>
                        </div>
                        @else
                            <p class="ap-hint" style="text-align:center;padding:.5rem 0">No service categories found. <a href="{{ route('service-categories.index') }}" style="color:var(--gold)">Add categories first.</a></p>
                        @endif
                    </div>
                </div>

                {{-- ── Portfolio & Links ── --}}
                <div class="ap-card">
                    <div class="ap-card-header">
                        <div class="ap-card-icon">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
                        </div>
                        <div>
                            <h6>Portfolio &amp; Links</h6>
                            <p>Online presence and professional documents.</p>
                        </div>
                    </div>
                    <div class="ap-card-body ap-stack">
                        <div>
                            <label class="ap-label">LinkedIn Profile</label>
                            <div class="ap-link-row">
                                <div class="link-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="#0a66c2"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg></div>
                                <input type="url" name="linkedin" value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/…">
                            </div>
                            @error('linkedin')<p class="ap-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="ap-grid-2">
                            <div>
                                <label class="ap-label">Personal Website</label>
                                <div class="ap-link-row">
                                    <div class="link-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
                                    <input type="url" name="website" value="{{ old('website') }}" placeholder="https://website.com">
                                </div>
                                @error('website')<p class="ap-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="ap-label">Portfolio URL</label>
                                <div class="ap-link-row">
                                    <div class="link-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><rect width="18" height="14" x="3" y="5" rx="2"/><path d="M3 7l9 6 9-6"/></svg></div>
                                    <input type="url" name="portfolio_url" value="{{ old('portfolio_url') }}" placeholder="https://behance.net/…">
                                </div>
                                @error('portfolio_url')<p class="ap-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="ap-label">Credentials Document</label>
                            <div class="ap-file-zone" id="credDropzone">
                                <input type="file" name="credentials_doc" id="credInput" accept=".pdf,.jpg,.jpeg,.png">
                                <div class="fz-icon">
                                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <p class="fz-title">Drop credentials document here</p>
                                <p class="fz-sub">PDF, JPG, PNG — max 5MB</p>
                            </div>
                            <div class="ap-file-picked" id="credSelected">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;color:#10b981"><path d="M20 6 9 17l-5-5"/></svg>
                                <span id="credFileName" style="font-size:.83rem">—</span>
                            </div>
                            @error('credentials_doc')<p class="ap-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Submit bar --}}
                <div class="ap-submit-bar">
                    <a href="{{ route('admin.professionals.index') }}" class="ap-btn ap-btn-ghost">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        Cancel
                    </a>
                    <button type="submit" class="ap-btn ap-btn-primary">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        Create &amp; Send Credentials
                    </button>
                </div>

            </div>{{-- /ap-main --}}

            {{-- ══════════════════ SIDEBAR ══════════════════ --}}
            <div class="ap-side">

                {{-- Profile Photo --}}
                <div class="ap-card">
                    <div class="ap-card-header">
                        <div class="ap-card-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                        </div>
                        <h6>Profile Photo</h6>
                    </div>
                    <div class="ap-card-body">
                        <div class="ap-photo-zone" id="imgUploadZone">
                            <input type="file" name="profile_image" id="profileImageInput" accept="image/jpg,image/jpeg,image/png,image/webp">
                            <div class="ap-photo-avatar">
                                <img id="imgPreview" src="" alt="Preview">
                                <svg id="imgPlaceholder" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            </div>
                            <p class="fz-title">Upload profile photo</p>
                            <p class="fz-sub">JPG, PNG, WEBP — max 2MB</p>
                        </div>
                        @error('profile_image')<p class="ap-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Live preview --}}
                <div class="ap-preview-card">
                    <div class="ap-preview-banner"></div>
                    <div class="ap-preview-body">
                        <div class="ap-preview-avatar-wrap">
                            <div class="ap-preview-av" id="previewAvatar">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            </div>
                        </div>
                        <p class="ap-preview-name" id="previewName" style="color:var(--muted);font-style:italic;font-weight:400">Enter name…</p>
                        <p class="ap-preview-email" id="previewEmail">—</p>
                        <div class="ap-preview-role">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                            Professional · Terra
                        </div>
                    </div>
                </div>

                {{-- Password & Access --}}
                <div class="ap-card">
                    <div class="ap-card-header">
                        <div class="ap-card-icon" style="background:#eff6ff;border-color:#bfdbfe;color:#3b82f6">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <h6>Password &amp; Access</h6>
                    </div>
                    <div class="ap-card-body">
                        <div class="ap-toggle-row" style="padding-top:0">
                            <div>
                                <div class="ap-toggle-label">Auto-generate password</div>
                                <div class="ap-toggle-desc">Secure 12-char via Hash::make()</div>
                            </div>
                            <label class="ap-switch">
                                <input type="checkbox" name="auto_password" id="autoPass" value="1" checked onchange="togglePass()">
                                <span class="ap-switch-track"></span>
                            </label>
                        </div>
                        <div id="customPassWrap" style="display:none;padding:.85rem 0 .25rem">
                            <label class="ap-label">Custom Password</label>
                            <input type="password" name="custom_password" class="ap-input" placeholder="Min. 8 characters" minlength="8" autocomplete="new-password">
                        </div>
                        <div class="ap-toggle-row">
                            <div>
                                <div class="ap-toggle-label">Email credentials</div>
                                <div class="ap-toggle-desc">Send login details on create</div>
                            </div>
                            <label class="ap-switch">
                                <input type="checkbox" name="send_credentials" value="1" checked>
                                <span class="ap-switch-track"></span>
                            </label>
                        </div>
                        <div class="ap-toggle-row">
                            <div>
                                <div class="ap-toggle-label">Mark as verified</div>
                                <div class="ap-toggle-desc">Skip email verification step</div>
                            </div>
                            <label class="ap-switch">
                                <input type="checkbox" name="is_verified" value="1" checked>
                                <span class="ap-switch-track"></span>
                            </label>
                        </div>
                        <div class="ap-access-info">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            Password is always hashed with <strong>Hash::make()</strong> before storage.
                        </div>
                    </div>
                </div>

            </div>{{-- /ap-side --}}
        </div>
    </form>
</div>

<script>
// ── Live preview ─────────────────────────────────────────────────────────────
function syncPreview() {
    const name   = document.getElementById('fullNameInput').value.trim();
    const email  = document.getElementById('emailInput').value.trim();
    const initials = name.split(/\s+/).map(w => w[0]?.toUpperCase() ?? '').slice(0, 2).join('');
    const avatar = document.getElementById('previewAvatar');
    const pName  = document.getElementById('previewName');

    if (initials) {
        avatar.textContent   = initials;
        avatar.style.fontSize = '1rem';
        pName.textContent    = name;
        pName.style.cssText  = 'font-size:.92rem;font-weight:700;color:var(--navy);margin-bottom:.15rem;';
    } else {
        avatar.innerHTML     = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>';
        pName.textContent    = 'Enter name…';
        pName.style.cssText  = 'color:var(--muted);font-style:italic;font-weight:400;';
    }
    document.getElementById('previewEmail').textContent = email || '—';
}

// ── Custom password toggle ───────────────────────────────────────────────────
function togglePass() {
    document.getElementById('customPassWrap').style.display =
        document.getElementById('autoPass').checked ? 'none' : 'block';
}

// ── Profile image preview ────────────────────────────────────────────────────
document.getElementById('profileImageInput').addEventListener('change', function () {
    if (!this.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('imgPreview');
        const icon    = document.getElementById('imgPlaceholder');
        preview.src          = e.target.result;
        preview.style.display = 'block';
        if (icon) icon.style.display = 'none';
    };
    reader.readAsDataURL(this.files[0]);
});

// ── Credential file name ─────────────────────────────────────────────────────
document.getElementById('credInput').addEventListener('change', function () {
    const file = this.files[0];
    document.getElementById('credFileName').textContent = file ? file.name : '—';
    document.getElementById('credSelected').classList.toggle('visible', !!file);
});

// ── Category → Services dynamic reveal ──────────────────────────────────────
document.querySelectorAll('.cat-trigger').forEach(cb => cb.addEventListener('change', handleCategoryChange));

function handleCategoryChange() {
    const catId = this.dataset.catId;
    const group = document.getElementById('group-' + catId);
    const panel = document.getElementById('servicesPanel');

    if (this.checked) {
        if (group) group.style.display = 'block';
    } else {
        if (group) {
            group.style.display = 'none';
            group.querySelectorAll('.service-check').forEach(s => s.checked = false);
        }
    }
    const anyChecked = document.querySelectorAll('.cat-trigger:checked').length > 0;
    if (panel) panel.style.display = anyChecked ? 'block' : 'none';
    updateCounts();
    updateSummary();
}

// ── Select all per group ─────────────────────────────────────────────────────
document.querySelectorAll('.select-all-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const groupId  = this.dataset.group;
        const services = document.querySelectorAll(`.service-check[data-group="${groupId}"]`);
        const allChecked = [...services].every(s => s.checked);
        services.forEach(s => s.checked = !allChecked);
        this.textContent = allChecked ? 'Select all' : 'Deselect all';
        updateCounts();
        updateSummary();
    });
});

document.querySelectorAll('.service-check').forEach(cb => cb.addEventListener('change', () => { updateCounts(); updateSummary(); }));

function updateCounts() {
    document.querySelectorAll('.cat-trigger').forEach(cb => {
        const catId  = cb.dataset.catId;
        const count  = document.querySelectorAll(`.service-check[data-group="${catId}"]:checked`).length;
        const badge  = document.getElementById('count-' + catId);
        if (badge) { badge.textContent = count; badge.style.display = count > 0 ? 'inline-block' : 'none'; }
    });
}

function updateSummary() {
    const total   = document.querySelectorAll('.service-check:checked').length;
    const summary = document.getElementById('selectedSummary');
    if (document.getElementById('selectedCount')) document.getElementById('selectedCount').textContent = total;
    if (summary) summary.style.display = total > 0 ? 'flex' : 'none';
}

document.getElementById('serviceSearch')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.service-check').forEach(cb => {
        const label = cb.nextElementSibling;
        const match = cb.dataset.name?.includes(q) ?? true;
        if (cb.parentElement) cb.parentElement.style.display = match ? '' : 'none';
    });
});

document.getElementById('clearServices')?.addEventListener('click', () => {
    document.querySelectorAll('.service-check').forEach(s => s.checked = false);
    updateCounts();
    updateSummary();
});

// Restore state on load (old() values after validation failure)
document.querySelectorAll('.cat-trigger:checked').forEach(cb => {
    const group = document.getElementById('group-' + cb.dataset.catId);
    if (group) group.style.display = 'block';
});
const anyCheckedOnLoad = document.querySelectorAll('.cat-trigger:checked').length > 0;
const panel = document.getElementById('servicesPanel');
if (anyCheckedOnLoad && panel) panel.style.display = 'block';
updateCounts();
updateSummary();
</script>
@endsection