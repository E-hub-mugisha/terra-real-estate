@extends('layouts.users')

@section('title', 'My Profile — Terra')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
:root {
    --navy:     #19265d;
    --navy-06:  rgba(25,38,93,0.06);
    --navy-12:  rgba(25,38,93,0.12);
    --gold:     #D05208;
    --gold-10:  rgba(208,82,8,0.10);
    --gold-20:  rgba(208,82,8,0.18);
    --cream:    #FAF8F5;
    --white:    #ffffff;
    --text:     #1a1a2e;
    --muted:    #6b7280;
    --border:   #e5e0d8;
    --danger:   #b91c1c;
    --danger-bg:#fef2f2;
    --success:  #0f6844;
    --success-bg:#eaf5ee;
    --warn:     #92400e;
    --warn-bg:  #fffbeb;
    --warn-border:#fbbf24;

    --font-serif: 'Cormorant Garamond', Georgia, serif;
    --font-sans:  'DM Sans', system-ui, sans-serif;
    --shadow:    0 1px 4px rgba(25,38,93,0.07), 0 6px 28px rgba(25,38,93,0.06);
    --shadow-lg: 0 8px 40px rgba(25,38,93,0.18);
    --radius:    14px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body { font-family: var(--font-sans); }

.profile-wrap {
    background: var(--cream);
    min-height: 100vh;
    padding: 2rem 2rem 5rem;
    color: var(--text);
}

/* ── Page header ──────────────────────────────── */
.profile-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    gap: 1rem;
    flex-wrap: wrap;
}
.profile-header-left h1 {
    font-family: var(--font-serif);
    font-size: 2rem;
    font-weight: 500;
    color: var(--navy);
    line-height: 1.1;
}
.profile-header-left h1 span {
    display: block;
    font-family: var(--font-sans);
    font-size: 0.73rem;
    font-weight: 500;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 0.2rem;
}

/* Completeness bar */
.completeness-bar-wrap {
    margin-top: 0.9rem;
    max-width: 380px;
}
.completeness-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.4rem;
}
.completeness-label span {
    font-size: 0.76rem;
    font-weight: 500;
    color: var(--muted);
}
.completeness-label strong {
    font-size: 0.76rem;
    font-weight: 600;
    color: var(--navy);
}
.completeness-track {
    height: 6px;
    background: var(--border);
    border-radius: 99px;
    overflow: hidden;
}
.completeness-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, var(--navy) 0%, var(--gold) 100%);
    transition: width .6s cubic-bezier(.4,0,.2,1);
}
.completeness-hint {
    margin-top: 0.35rem;
    font-size: 0.72rem;
    color: var(--muted);
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-wrap: wrap;
    padding-top: 0.25rem;
}

/* ── Buttons ──────────────────────────────────── */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.55rem 1.1rem;
    border-radius: 9px;
    font-family: var(--font-sans);
    font-size: 0.82rem;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: all .15s;
    white-space: nowrap;
    text-decoration: none;
}
.btn svg { width: 14px; height: 14px; flex-shrink: 0; }
.btn-outline { background: var(--white); border: 1px solid var(--border); color: var(--navy); }
.btn-outline:hover { border-color: var(--navy); background: var(--navy-06); }
.btn-navy { background: var(--navy); color: #fff; }
.btn-navy:hover { background: #0f1a44; }
.btn-gold { background: var(--gold); color: #fff; }
.btn-gold:hover { background: #b34506; }
.btn-ghost { background: transparent; color: var(--muted); border: 1px solid transparent; }
.btn-ghost:hover { color: var(--danger); border-color: var(--danger-bg); background: var(--danger-bg); }
.btn-sm { padding: 0.38rem 0.8rem; font-size: 0.77rem; }

/* ── Tabs ─────────────────────────────────────── */
.tabs {
    display: flex;
    gap: 0.15rem;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 11px;
    padding: 4px;
    margin-bottom: 1.5rem;
    overflow-x: auto;
    scrollbar-width: none;
    box-shadow: var(--shadow);
}
.tabs::-webkit-scrollbar { display: none; }
.tab-btn {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.55rem 1.1rem;
    border-radius: 8px;
    font-family: var(--font-sans);
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--muted);
    border: none;
    background: transparent;
    cursor: pointer;
    white-space: nowrap;
    transition: all .15s;
}
.tab-btn svg { width: 14px; height: 14px; }
.tab-btn.active {
    background: var(--navy);
    color: #fff;
}
.tab-btn:hover:not(.active) { background: var(--navy-06); color: var(--navy); }

/* ── Tab panels ───────────────────────────────── */
.tab-panel { display: none; }
.tab-panel.active { display: block; }

/* ── Card ─────────────────────────────────────── */
.card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 1.2rem;
}
.card-head {
    padding: 1.15rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.card-head h2 {
    font-family: var(--font-serif);
    font-size: 1.15rem;
    font-weight: 500;
    color: var(--navy);
}
.card-head p {
    font-size: 0.77rem;
    color: var(--muted);
    margin-top: 1px;
}
.card-body { padding: 1.5rem; }

/* ── Form ─────────────────────────────────────── */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.1rem 1.4rem;
}
@media (max-width: 640px) { .form-grid { grid-template-columns: 1fr; } }
.form-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
@media (max-width: 900px) { .form-grid.cols-3 { grid-template-columns: 1fr 1fr; } }
@media (max-width: 640px) { .form-grid.cols-3 { grid-template-columns: 1fr; } }
.span-2 { grid-column: span 2; }
@media (max-width: 640px) { .span-2 { grid-column: span 1; } }

.field { display: flex; flex-direction: column; gap: 0.35rem; }
.field label {
    font-size: 0.74rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    color: var(--navy);
}
.field label .req { color: var(--gold); margin-left: 2px; }
.field input,
.field select,
.field textarea {
    font-family: var(--font-sans);
    font-size: 0.87rem;
    color: var(--text);
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 9px;
    padding: 0.6rem 0.85rem;
    outline: none;
    transition: border-color .15s, box-shadow .15s;
    width: 100%;
}
.field input:focus,
.field select:focus,
.field textarea:focus {
    border-color: var(--navy);
    box-shadow: 0 0 0 3px var(--navy-06);
}
.field textarea { resize: vertical; min-height: 100px; }
.field .hint { font-size: 0.71rem; color: var(--muted); }

/* Locked field */
.field-locked input,
.field-locked select {
    background: var(--cream);
    cursor: not-allowed;
    color: var(--muted);
}
.lock-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.68rem;
    font-weight: 600;
    color: var(--warn);
    background: var(--warn-bg);
    border: 1px solid var(--warn-border);
    border-radius: 20px;
    padding: 0.15rem 0.55rem;
    margin-left: 0.5rem;
    letter-spacing: 0.03em;
}
.lock-badge svg { width: 10px; height: 10px; }

.field-row-label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

/* Unlock trigger */
.unlock-link {
    font-size: 0.72rem;
    color: var(--gold);
    font-weight: 500;
    cursor: pointer;
    text-decoration: underline;
    text-underline-offset: 2px;
    margin-top: 0.2rem;
    display: inline-block;
}

/* Immediate badge */
.instant-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.67rem;
    font-weight: 600;
    color: var(--success);
    background: var(--success-bg);
    border-radius: 20px;
    padding: 0.12rem 0.5rem;
    margin-left: 0.4rem;
}
.instant-badge svg { width: 9px; height: 9px; }

/* ── Photo upload ─────────────────────────────── */
.photo-row {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}
.photo-avatar {
    width: 84px; height: 84px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--border);
    background: var(--navy-06);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-serif);
    font-size: 1.8rem;
    color: var(--navy);
    font-weight: 500;
    position: relative;
}
.photo-avatar img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }
.photo-info { flex: 1; }
.photo-info p { font-size: 0.8rem; color: var(--muted); margin-top: 0.4rem; }

/* ── Availability toggle ──────────────────────── */
.avail-options {
    display: flex;
    gap: 0.6rem;
    flex-wrap: wrap;
    margin-top: 0.2rem;
}
.avail-opt input[type="radio"] { display: none; }
.avail-opt label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.45rem 0.9rem;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 0.8rem;
    cursor: pointer;
    color: var(--muted);
    transition: all .15s;
    font-weight: 500;
}
.avail-opt input:checked + label {
    border-color: var(--navy);
    background: var(--navy-06);
    color: var(--navy);
}
.avail-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
}
.dot-available   { background: #22c55e; }
.dot-limited     { background: #f59e0b; }
.dot-unavailable { background: #ef4444; }

/* ── Services checkboxes ──────────────────────── */
.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 0.7rem;
}
.service-check input[type="checkbox"] { display: none; }
.service-check label {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    padding: 0.7rem 1rem;
    border: 1px solid var(--border);
    border-radius: 9px;
    font-size: 0.82rem;
    cursor: pointer;
    color: var(--text);
    transition: all .15s;
    user-select: none;
}
.service-check input:checked + label {
    border-color: var(--navy);
    background: var(--navy-06);
    color: var(--navy);
    font-weight: 500;
}
.check-box {
    width: 16px; height: 16px;
    border-radius: 4px;
    border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: all .15s;
}
.service-check input:checked + label .check-box {
    background: var(--navy);
    border-color: var(--navy);
}
.check-box svg { width: 10px; height: 10px; color: #fff; display: none; }
.service-check input:checked + label .check-box svg { display: block; }

/* ── Portfolio grid ───────────────────────────── */
.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}
.portfolio-item {
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    background: var(--white);
    transition: box-shadow .15s;
    animation: fadeIn .3s both;
}
.portfolio-item:hover { box-shadow: var(--shadow); }
@keyframes fadeIn { from { opacity:0; transform: scale(0.97); } to { opacity:1; transform: scale(1); } }
.portfolio-img {
    height: 130px;
    background: var(--cream);
    overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
.portfolio-img img { width: 100%; height: 100%; object-fit: cover; }
.portfolio-img .no-img {
    display: flex; flex-direction: column; align-items: center; gap: 0.4rem;
    color: var(--muted);
    font-size: 0.75rem;
}
.portfolio-img .no-img svg { width: 24px; height: 24px; opacity: .5; }
.portfolio-meta { padding: 0.7rem 0.85rem; }
.portfolio-meta strong { font-size: 0.85rem; color: var(--navy); display: block; }
.portfolio-meta small  { font-size: 0.74rem; color: var(--muted); }
.portfolio-remove {
    position: absolute;
    top: 0.5rem; right: 0.5rem;
    width: 26px; height: 26px;
    background: rgba(10,15,35,0.6);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    opacity: 0;
    transition: opacity .15s;
}
.portfolio-item:hover .portfolio-remove { opacity: 1; }
.portfolio-remove svg { width: 12px; height: 12px; }

.add-portfolio-card {
    border: 2px dashed var(--border);
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 2rem 1rem;
    cursor: pointer;
    color: var(--muted);
    font-size: 0.8rem;
    transition: all .15s;
    background: transparent;
    min-height: 200px;
    font-family: var(--font-sans);
}
.add-portfolio-card:hover { border-color: var(--navy); color: var(--navy); background: var(--navy-06); }
.add-portfolio-card svg { width: 28px; height: 28px; opacity: .4; }

/* ── Verify modal ─────────────────────────────── */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(10,15,35,0.55);
    backdrop-filter: blur(5px);
    z-index: 1000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.modal-overlay.open { display: flex; }
.modal-box {
    background: var(--white);
    border-radius: var(--radius);
    width: 100%;
    max-width: 480px;
    box-shadow: var(--shadow-lg);
    animation: popIn .22s cubic-bezier(.34,1.56,.64,1);
}
@keyframes popIn { from { opacity:0; transform: scale(0.92); } to { opacity:1; transform: scale(1); } }
.modal-head {
    padding: 1.3rem 1.5rem 1.1rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.modal-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.modal-icon.warn { background: var(--warn-bg); color: var(--warn); }
.modal-icon svg { width: 20px; height: 20px; }
.modal-head h3 { font-family: var(--font-serif); font-size: 1.15rem; color: var(--navy); font-weight: 500; }
.modal-head p  { font-size: 0.78rem; color: var(--muted); margin-top: 2px; }
.modal-body { padding: 1.25rem 1.5rem; font-size: 0.85rem; color: var(--text); line-height: 1.65; }
.modal-body ul { padding-left: 1.2rem; margin-top: 0.75rem; }
.modal-body ul li { margin-bottom: 0.4rem; color: var(--muted); font-size: 0.82rem; }
.modal-foot {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
    gap: 0.6rem;
}

/* ── Portfolio add modal ──────────────────────── */
.port-modal-body { padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; }

/* ── Preview modal ────────────────────────────── */
.preview-modal .modal-box { max-width: 400px; }
.preview-card {
    background: var(--white);
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border);
    margin: 1.2rem 1.5rem;
}
.preview-card-banner {
    height: 70px;
    background: linear-gradient(135deg, var(--navy) 0%, #2d3f8e 100%);
    position: relative;
}
.preview-card-avatar {
    position: absolute;
    bottom: -28px; left: 1.2rem;
    width: 56px; height: 56px;
    border-radius: 50%;
    border: 3px solid var(--white);
    overflow: hidden;
    background: var(--cream);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-serif);
    font-size: 1.3rem;
    color: var(--navy);
    font-weight: 500;
}
.preview-card-avatar img { width: 100%; height: 100%; object-fit: cover; }
.preview-card-body { padding: 2rem 1.2rem 1.2rem; }
.preview-card-name { font-family: var(--font-serif); font-size: 1.2rem; color: var(--navy); font-weight: 500; }
.preview-card-title { font-size: 0.78rem; color: var(--gold); font-weight: 500; margin-top: 1px; }
.preview-card-bio {
    font-size: 0.78rem;
    color: var(--muted);
    margin-top: 0.7rem;
    line-height: 1.55;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.preview-card-tags { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-top: 0.85rem; }
.preview-tag {
    background: var(--navy-06);
    color: var(--navy);
    font-size: 0.7rem;
    font-weight: 500;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
}
.preview-card-footer {
    padding: 0.75rem 1.2rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--cream);
}
.preview-card-footer .avail-pill {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.preview-card-footer .district {
    font-size: 0.75rem;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.preview-card-footer svg { width: 12px; height: 12px; }

/* verified badge */
.verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.68rem;
    font-weight: 600;
    color: #fff;
    background: var(--gold);
    border-radius: 20px;
    padding: 0.15rem 0.55rem;
    margin-left: 0.45rem;
}
.verified-badge svg { width: 10px; height: 10px; }

/* form save bar */
.save-bar {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: var(--white);
    border-top: 1px solid var(--border);
    padding: 0.9rem 2rem;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
    z-index: 50;
    box-shadow: 0 -4px 20px rgba(25,38,93,0.08);
}
.save-bar .saved-msg {
    font-size: 0.8rem;
    color: var(--success);
    display: none;
    align-items: center;
    gap: 0.35rem;
    font-weight: 500;
}
.save-bar .saved-msg svg { width: 14px; height: 14px; }

/* Animations */
.tab-panel { animation: fadeSlide .2s both; }
@keyframes fadeSlide { from { opacity:0; transform: translateY(6px); } to { opacity:1; transform: translateY(0); } }
</style>

<div class="profile-wrap">

    {{-- Flash --}}
    @if(session('success'))
    <div style="background:var(--success-bg);border:1px solid #bbf7d0;color:var(--success);border-radius:9px;padding:.75rem 1.1rem;font-size:.82rem;font-weight:500;margin-bottom:1.2rem;display:flex;align-items:center;gap:.5rem;">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Page header ── --}}
    <div class="profile-header">
        <div class="profile-header-left">
            <h1><span>Consultant</span>My Profile</h1>
            <div class="completeness-bar-wrap">
                <div class="completeness-label">
                    <span>Profile completeness</span>
                    <strong>{{ $completeness }}%</strong>
                </div>
                <div class="completeness-track">
                    <div class="completeness-fill" style="width: {{ $completeness }}%"></div>
                </div>
                @if($completeness < 100)
                <div class="completeness-hint">Complete all fields to appear higher in search results.</div>
                @else
                <div class="completeness-hint" style="color:var(--success);font-weight:500;">✓ Your profile is fully complete</div>
                @endif
            </div>
        </div>
        <div class="header-actions">
            <button class="btn btn-outline" onclick="openPreview()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Preview my profile
            </button>
        </div>
    </div>

    {{-- ── Tabs ── --}}
    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('personal', this)">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Personal Info
        </button>
        <button class="tab-btn" onclick="switchTab('professional', this)">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Professional
        </button>
        <button class="tab-btn" onclick="switchTab('coverage', this)">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Coverage & Rates
        </button>
        <button class="tab-btn" onclick="switchTab('services', this)">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Services
        </button>
        <button class="tab-btn" onclick="switchTab('portfolio', this)">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Portfolio
        </button>
    </div>

    <form id="profileForm" method="POST" action="{{ route('consultant.profile.update') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        {{-- ══ TAB: Personal Info ═══════════════════════════════ --}}
        <div class="tab-panel active" id="tab-personal">

            {{-- Photo --}}
            <div class="card">
                <div class="card-head">
                    <div>
                        <h2>Profile Photo</h2>
                        <p>Visible to all clients browsing your profile</p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="photo-row">
                        <div class="photo-avatar" id="avatarPreview">
                            @if($consultant->photo)
                                <img src="{{asset('image/consultant/')}}/{{ $consultant->photo }}" id="photoImg" alt="">
                            @else
                                <span id="avatarInitials">{{ $consultant->initials }}</span>
                            @endif
                        </div>
                        <div class="photo-info">
                            <input type="file" name="photo" id="photoInput" accept="image/*" style="display:none" onchange="previewPhoto(this)">
                            <div style="display:flex;gap:.6rem;flex-wrap:wrap;">
                                <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('photoInput').click()">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    Upload photo
                                </button>
                                @if($consultant->photo)
                                <button type="button" class="btn btn-ghost btn-sm" onclick="removePhoto()">Remove</button>
                                @endif
                            </div>
                            <p style="margin-top:.5rem;">JPG, PNG or WebP. Max 2 MB. Square photos work best.</p>
                            <input type="hidden" name="remove_photo" id="removePhotoInput" value="0">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Basic info --}}
            <div class="card">
                <div class="card-head">
                    <div><h2>Basic Information</h2><p>Your name and contact details shown to clients</p></div>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="field">
                            <label>Full Name <span class="req">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $consultant->name) }}" required>
                        </div>
                        <div class="field">
                            <label>Professional Title <span class="req">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $consultant->title) }}" placeholder="e.g. Licensed Land Surveyor" required>
                        </div>
                        <div class="field">
                            <label>Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $consultant->email) }}">
                            <span class="hint">Shown to clients upon booking confirmation</span>
                        </div>
                        <div class="field">
                            <label>Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $consultant->phone) }}" placeholder="+250 7xx xxx xxx">
                        </div>
                        <div class="field span-2">
                            <label>Professional Bio <span class="req">*</span></label>
                            <textarea name="bio" rows="4" placeholder="Describe your experience, specialisations, and what clients can expect when working with you…" required>{{ old('bio', $consultant->bio) }}</textarea>
                            <span class="hint">Aim for 80–200 words. This is your first impression.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ TAB: Professional ════════════════════════════════ --}}
        <div class="tab-panel" id="tab-professional">
            <div class="card">
                <div class="card-head">
                    <div>
                        <h2>Credentials & Verification</h2>
                        <p>Changes to licence number or discipline trigger a re-verification review</p>
                    </div>
                    @if($consultant->is_verified)
                    <span class="verified-badge">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Verified
                    </span>
                    @else
                    <span style="font-size:.75rem;color:var(--warn);font-weight:500;">⏳ Pending verification</span>
                    @endif
                </div>
                <div class="card-body">
                    <div style="background:var(--warn-bg);border:1px solid var(--warn-border);border-radius:9px;padding:.85rem 1rem;font-size:.8rem;color:var(--warn);margin-bottom:1.3rem;display:flex;align-items:flex-start;gap:.6rem;">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>These fields are <strong>locked</strong>. Requesting a change will suspend your verified status until our team completes a new review (typically 2–3 business days).</span>
                    </div>

                    <div class="form-grid">
                        <div class="field field-locked">
                            <div class="field-row-label">
                                <label>Registration / Licence Number</label>
                                <span class="lock-badge">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Locked
                                </span>
                            </div>
                            <input type="text" name="registration_number" value="{{ $consultant->registration_number }}" id="regInput" readonly>
                            <span class="unlock-link" onclick="openVerifyModal('licence')">Request change →</span>
                        </div>

                        <div class="field field-locked">
                            <div class="field-row-label">
                                <label>Primary Discipline</label>
                                <span class="lock-badge">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Locked
                                </span>
                            </div>
                            <select name="discipline" id="disciplineInput" disabled>
                                <option value="land_surveying"   {{ ($consultant->title ?? '') === 'land_surveying'   ? 'selected' : '' }}>Land Surveying</option>
                                <option value="architecture"     {{ ($consultant->title ?? '') === 'architecture'     ? 'selected' : '' }}>Architecture</option>
                                <option value="civil_engineering"{{ ($consultant->title ?? '') === 'civil_engineering'? 'selected' : '' }}>Civil Engineering</option>
                                <option value="urban_planning"   {{ ($consultant->title ?? '') === 'urban_planning'   ? 'selected' : '' }}>Urban Planning</option>
                                <option value="gis"              {{ ($consultant->title ?? '') === 'gis'              ? 'selected' : '' }}>GIS & Mapping</option>
                                <option value="valuation"        {{ ($consultant->title ?? '') === 'valuation'        ? 'selected' : '' }}>Property Valuation</option>
                            </select>
                            <span class="unlock-link" onclick="openVerifyModal('discipline')">Request change →</span>
                        </div>

                        <div class="field span-2">
                            <label>CV / Credentials Document</label>
                            @if($consultant->cv)
                            <div style="display:flex;align-items:center;gap:.7rem;padding:.6rem .85rem;border:1px solid var(--border);border-radius:9px;background:var(--cream);margin-bottom:.4rem;">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:var(--muted);"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span style="font-size:.82rem;color:var(--navy);font-weight:500;">{{ basename($consultant->cv) }}</span>
                                <a href="{{ asset('image/'.$consultant->cv) }}" target="_blank" style="font-size:.75rem;color:var(--gold);font-weight:500;margin-left:auto;text-decoration:none;">View</a>
                            </div>
                            @endif
                            <input type="file" name="cv" accept=".pdf,.doc,.docx">
                            <span class="hint">PDF, DOC or DOCX. Max 5 MB. Upload a newer version to replace the existing one.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ TAB: Coverage & Rates ═══════════════════════════ --}}
        <div class="tab-panel" id="tab-coverage">
            <div class="card">
                <div class="card-head">
                    <div>
                        <h2>Location Coverage</h2>
                        <p>
                            Changes take effect immediately
                            <span class="instant-badge">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Instant
                            </span>
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-grid">
                        <div class="field">
                            <label>Province</label>
                            <select name="province" id="provinceSelect" onchange="populateDistricts(this.value)">
                                <option value="">Select province…</option>
                                @foreach(['Kigali','Northern','Southern','Eastern','Western'] as $prov)
                                <option value="{{ $prov }}" {{ $consultant->province === $prov ? 'selected' : '' }}>{{ $prov }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>District</label>
                            <select name="district" id="districtSelect">
                                <option value="{{ $consultant->district }}" selected>{{ $consultant->district }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <div>
                        <h2>Availability</h2>
                        <p>
                            Shown on your public card
                            <span class="instant-badge">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Instant
                            </span>
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <div class="avail-options">
                        <div class="avail-opt">
                            <input type="radio" name="availability" id="avail_available" value="available" {{ $consultant->availability === 'available' ? 'checked' : '' }}>
                            <label for="avail_available"><span class="avail-dot dot-available"></span> Available</label>
                        </div>
                        <div class="avail-opt">
                            <input type="radio" name="availability" id="avail_limited" value="limited" {{ $consultant->availability === 'limited' ? 'checked' : '' }}>
                            <label for="avail_limited"><span class="avail-dot dot-limited"></span> Limited slots</label>
                        </div>
                        <div class="avail-opt">
                            <input type="radio" name="availability" id="avail_unavailable" value="unavailable" {{ $consultant->availability === 'unavailable' ? 'checked' : '' }}>
                            <label for="avail_unavailable"><span class="avail-dot dot-unavailable"></span> Unavailable</label>
                        </div>
                    </div>
                    <p style="font-size:.76rem;color:var(--muted);margin-top:.85rem;">Setting yourself as <strong>Unavailable</strong> hides you from search results until changed.</p>
                </div>
            </div>
        </div>

        {{-- ══ TAB: Services ════════════════════════════════════ --}}
        <div class="tab-panel" id="tab-services">
            <div class="card">
                <div class="card-head">
                    <div><h2>Offered Services</h2><p>Select all services you are qualified to deliver</p></div>
                </div>
                <div class="card-body">
                    <div class="services-grid">
                        @foreach($allServices as $service)
                        <div class="service-check">
                            <input type="checkbox"
                                name="services[]"
                                id="svc_{{ $service->id }}"
                                value="{{ $service->id }}"
                                {{ $consultant->services->contains($service->id) ? 'checked' : '' }}>
                            <label for="svc_{{ $service->id }}">
                                <span class="check-box">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </span>
                                {{ $service->title }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ TAB: Portfolio ═══════════════════════════════════ --}}
        <div class="tab-panel" id="tab-portfolio">
            <div class="card">
                <div class="card-head">
                    <div><h2>Portfolio</h2><p>Add or remove project samples — no re-verification required</p></div>
                    <button type="button" class="btn btn-navy btn-sm" onclick="openPortfolioModal()">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Add item
                    </button>
                </div>
                <div class="card-body">
                    <div class="portfolio-grid" id="portfolioGrid">
                        @forelse($portfolio as $item)
                        <div class="portfolio-item" data-id="{{ $item->id }}">
                            <div class="portfolio-img">
                                @if($item->image)
                                    <img src="{{ asset('image/'.$item->image) }}" alt="{{ $item->title }}">
                                @else
                                    <div class="no-img">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        No image
                                    </div>
                                @endif
                            </div>
                            <div class="portfolio-meta">
                                <strong>{{ $item->title }}</strong>
                                <small>{{ $item->location ?? '' }}{{ $item->year ? ' · '.$item->year : '' }}</small>
                            </div>
                            <button type="button" class="portfolio-remove" onclick="removePortfolioItem(this, {{ $item->id }})">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        @empty
                        <div id="portfolioEmpty" style="grid-column:1/-1;text-align:center;padding:2.5rem 1rem;color:var(--muted);font-size:.85rem;">
                            <svg width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="opacity:.25;color:var(--navy);display:block;margin:0 auto .75rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            No portfolio items yet. Add your first project above.
                        </div>
                        @endforelse
                    </div>
                    {{-- Hidden input list for removed items --}}
                    <div id="removedPortfolioInputs"></div>
                </div>
            </div>
        </div>

    </form>

    {{-- ── Save bar ── --}}
    <div class="save-bar">
        <div class="saved-msg" id="savedMsg">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Changes saved
        </div>
        <button type="button" class="btn btn-outline" onclick="window.location.reload()">Discard</button>
        <button type="submit" form="profileForm" class="btn btn-navy">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            Save changes
        </button>
    </div>
</div>

{{-- ══ Re-verification Modal ════════════════════════════════════ --}}
<div class="modal-overlay" id="verifyModal">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-icon warn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3>Request Credential Change</h3>
                <p id="verifyModalSub">This will trigger a re-verification review</p>
            </div>
        </div>
        <div class="modal-body">
            Changing your <strong id="verifyFieldName">licence number</strong> will:
            <ul>
                <li>Suspend your <em>Verified</em> badge until the review is complete</li>
                <li>Pause new bookings while under review (existing ones are unaffected)</li>
                <li>Require you to upload supporting documentation</li>
                <li>Typically resolve within 2–3 business days</li>
            </ul>
            <p style="margin-top:.85rem;">Do you want to submit a change request for review?</p>
        </div>
        <div class="modal-foot">
            <button class="btn btn-outline" onclick="closeVerifyModal()">Cancel</button>
            <button class="btn btn-gold" onclick="submitVerifyRequest()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Submit request
            </button>
        </div>
    </div>
</div>

{{-- ══ Portfolio Add Modal ═══════════════════════════════════════ --}}
<div class="modal-overlay" id="portfolioModal">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-icon" style="background:var(--navy-06);color:var(--navy);">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h3>Add Portfolio Item</h3>
                <p>Showcase a completed project to clients</p>
            </div>
        </div>
        <div class="port-modal-body">
            <div class="field">
                <label>Project Title <span class="req">*</span></label>
                <input type="text" id="portTitle" placeholder="e.g. Topographic Survey — Kicukiro">
            </div>
            <div class="form-grid">
                <div class="field">
                    <label>Location</label>
                    <input type="text" id="portLocation" placeholder="e.g. Kigali, Rwanda">
                </div>
                <div class="field">
                    <label>Year</label>
                    <input type="number" id="portYear" placeholder="{{ date('Y') }}" min="2000" max="{{ date('Y') }}">
                </div>
            </div>
            <div class="field">
                <label>Image</label>
                <input type="file" name="portfolio_images[]" id="portImageInput" accept="image/*" onchange="previewPortImage(this)">
                <div id="portImagePreview" style="display:none;margin-top:.5rem;">
                    <img id="portImgPreviewEl" style="width:100%;height:120px;object-fit:cover;border-radius:8px;border:1px solid var(--border);">
                </div>
                <input type="hidden" name="portfolio_titles[]" id="portTitleHidden">
                <input type="hidden" name="portfolio_locations[]" id="portLocationHidden">
                <input type="hidden" name="portfolio_years[]" id="portYearHidden">
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-outline" onclick="closePortfolioModal()">Cancel</button>
            <button class="btn btn-navy" onclick="addPortfolioItem()">Add to portfolio</button>
        </div>
    </div>
</div>

{{-- ══ Profile Preview Modal ════════════════════════════════════ --}}
<div class="modal-overlay preview-modal" id="previewModal">
    <div class="modal-box">
        <div class="modal-head" style="background:var(--navy);padding:1rem 1.3rem;">
            <div>
                <h3 style="color:#fff;font-size:1rem;">Public Profile Preview</h3>
                <p style="color:rgba(255,255,255,.5);font-size:.74rem;">This is how clients see your card</p>
            </div>
            <button class="modal-close" style="background:rgba(255,255,255,.12);border:none;color:#fff;width:28px;height:28px;border-radius:7px;cursor:pointer;font-size:.95rem;" onclick="closePreview()">✕</button>
        </div>
        <div class="preview-card" id="previewCard">
            <div class="preview-card-banner">
                <div class="preview-card-avatar" id="pvAvatar">
                    @if($consultant->photo)
                        <img src="{{asset('image/consultant/')}}/{{ $consultant->photo }}" id="pvAvatarImg" alt="">
                    @else
                        <span id="pvAvatarInitials">{{ $consultant->initials }}</span>
                    @endif
                </div>
            </div>
            <div class="preview-card-body">
                <div>
                    <span class="preview-card-name" id="pvName">{{ $consultant->name }}</span>
                    @if($consultant->is_verified)
                    <span class="verified-badge">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Verified
                    </span>
                    @endif
                </div>
                <div class="preview-card-title" id="pvTitle">{{ $consultant->title }}</div>
                <div class="preview-card-bio" id="pvBio">{{ $consultant->bio ?? 'No bio added yet.' }}</div>
                <div class="preview-card-tags" id="pvTags">
                    @foreach($consultant->services->take(4) as $svc)
                    <span class="preview-tag">{{ $svc->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="preview-card-footer">
                <span class="avail-pill" id="pvAvail" style="
                    {{ $consultant->availability === 'available'   ? 'background:var(--success-bg);color:var(--success);' : '' }}
                    {{ $consultant->availability === 'limited'     ? 'background:var(--warn-bg);color:var(--warn);'       : '' }}
                    {{ $consultant->availability === 'unavailable' ? 'background:var(--danger-bg);color:var(--danger);'   : '' }}
                ">
                    <span style="width:6px;height:6px;border-radius:50%;display:inline-block;background:currentColor;opacity:.7;"></span>
                    {{ ucfirst($consultant->availability ?? 'unknown') }}
                </span>
                <span class="district" id="pvDistrict">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $consultant->district }}, {{ $consultant->province }}
                </span>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-outline" onclick="closePreview()">Close</button>
        </div>
    </div>
</div>


<script>
/* ── Tabs ────────────────────────────────── */
function switchTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}

/* ── Photo preview ───────────────────────── */
function previewPhoto(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const av = document.getElementById('avatarPreview');
        let img = document.getElementById('photoImg');
        if (!img) {
            img = document.createElement('img');
            img.id = 'photoImg';
            img.style.position = 'absolute';
            img.style.inset = '0';
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            av.appendChild(img);
            const init = document.getElementById('avatarInitials');
            if (init) init.style.display = 'none';
        }
        img.src = e.target.result;
        // also update preview card
        const pvImg = document.getElementById('pvAvatarImg');
        if (pvImg) pvImg.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function removePhoto() {
    document.getElementById('removePhotoInput').value = '1';
    const img = document.getElementById('photoImg');
    if (img) img.remove();
    const init = document.getElementById('avatarInitials');
    if (init) init.style.display = '';
}

/* ── Districts ───────────────────────────── */
const districts = {
    Kigali:   ['Gasabo','Kicukiro','Nyarugenge'],
    Northern: ['Burera','Gakenke','Gicumbi','Musanze','Rulindo'],
    Southern: ['Gisagara','Huye','Kamonyi','Muhanga','Nyamagabe','Nyanza','Nyaruguru','Ruhango'],
    Eastern:  ['Bugesera','Gatsibo','Kayonza','Kirehe','Ngoma','Nyagatare','Rwamagana'],
    Western:  ['Karongi','Ngororero','Nyabihu','Nyamasheke','Rubavu','Rutsiro','Rusizi'],
};

function populateDistricts(province) {
    const sel = document.getElementById('districtSelect');
    const list = districts[province] || [];
    sel.innerHTML = list.map(d => `<option value="${d}">${d}</option>`).join('');
}

// initialise on load
(function(){
    const prov = document.getElementById('provinceSelect')?.value;
    if (prov) populateDistricts(prov);
    const curr = "{{ $consultant->district }}";
    const sel = document.getElementById('districtSelect');
    if (sel && curr) {
        Array.from(sel.options).forEach(o => { if (o.value === curr) o.selected = true; });
    }
})();

/* ── Re-verify modal ─────────────────────── */
let pendingVerifyField = null;

function openVerifyModal(field) {
    pendingVerifyField = field;
    const names = { licence: 'licence number', discipline: 'primary discipline' };
    document.getElementById('verifyFieldName').textContent = names[field] ?? field;
    document.getElementById('verifyModal').classList.add('open');
}
function closeVerifyModal() {
    document.getElementById('verifyModal').classList.remove('open');
}
function submitVerifyRequest() {
    // POST to verification request endpoint
    fetch('{{ route("consultant.profile.verify-request") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ field: pendingVerifyField })
    }).then(() => {
        closeVerifyModal();
        showToast('Verification change request submitted. Our team will be in touch.');
    }).catch(() => closeVerifyModal());
}

/* ── Portfolio modal ─────────────────────── */
function openPortfolioModal() {
    document.getElementById('portTitle').value = '';
    document.getElementById('portLocation').value = '';
    document.getElementById('portYear').value = '';
    document.getElementById('portImagePreview').style.display = 'none';
    document.getElementById('portfolioModal').classList.add('open');
}
function closePortfolioModal() {
    document.getElementById('portfolioModal').classList.remove('open');
}

function previewPortImage(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('portImgPreviewEl').src = e.target.result;
        document.getElementById('portImagePreview').style.display = 'block';
    };
    reader.readAsDataURL(file);
}

function addPortfolioItem() {
    const title    = document.getElementById('portTitle').value.trim();
    const location = document.getElementById('portLocation').value.trim();
    const year     = document.getElementById('portYear').value.trim();
    const imgInput = document.getElementById('portImageInput');

    if (!title) { alert('Please enter a project title.'); return; }

    // Set hidden inputs so they go with the main form
    document.getElementById('portTitleHidden').value    = title;
    document.getElementById('portLocationHidden').value = location;
    document.getElementById('portYearHidden').value     = year;

    // Build preview card
    const imgSrc = imgInput.files[0] ? document.getElementById('portImgPreviewEl').src : null;
    const grid   = document.getElementById('portfolioGrid');
    const empty  = document.getElementById('portfolioEmpty');
    if (empty) empty.remove();

    const div = document.createElement('div');
    div.className = 'portfolio-item';
    div.dataset.id = 'new_' + Date.now();
    div.innerHTML = `
        <div class="portfolio-img">
            ${imgSrc
                ? `<img src="${imgSrc}" alt="${title}">`
                : `<div class="no-img"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>No image</div>`}
        </div>
        <div class="portfolio-meta">
            <strong>${title}</strong>
            <small>${location}${year ? ' · ' + year : ''}</small>
        </div>
        <button type="button" class="portfolio-remove" onclick="removePortfolioItem(this, '${div.dataset.id}')">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>`;
    grid.insertBefore(div, grid.lastElementChild);
    closePortfolioModal();
}

function removePortfolioItem(btn, id) {
    const item = btn.closest('.portfolio-item');
    // If it's an existing DB record, add hidden input to signal deletion
    if (!String(id).startsWith('new_')) {
        const inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = 'remove_portfolio[]';
        inp.value = id;
        document.getElementById('removedPortfolioInputs').appendChild(inp);
    }
    item.style.opacity = '0';
    item.style.transform = 'scale(0.93)';
    item.style.transition = 'all .2s';
    setTimeout(() => item.remove(), 200);
}

/* ── Preview modal ───────────────────────── */
function openPreview() {
    // Sync live form values into the preview card
    const name  = document.querySelector('[name=name]')?.value  || '';
    const title = document.querySelector('[name=title]')?.value || '';
    const bio   = document.querySelector('[name=bio]')?.value   || '';
    const district  = document.getElementById('districtSelect')?.value  || '';
    const province  = document.getElementById('provinceSelect')?.value  || '';
    const avail = document.querySelector('[name=availability]:checked')?.value || 'available';

    document.getElementById('pvName').textContent    = name;
    document.getElementById('pvTitle').textContent   = title;
    document.getElementById('pvBio').textContent     = bio;
    document.getElementById('pvDistrict').innerHTML  = `<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>${district}, ${province}`;

    // Availability pill
    const pvAvail = document.getElementById('pvAvail');
    const colors = {
        available:   'background:var(--success-bg);color:var(--success);',
        limited:     'background:var(--warn-bg);color:var(--warn);',
        unavailable: 'background:var(--danger-bg);color:var(--danger);',
    };
    pvAvail.style.cssText = colors[avail] || '';
    pvAvail.innerHTML = `<span style="width:6px;height:6px;border-radius:50%;display:inline-block;background:currentColor;opacity:.7;"></span> ${avail.charAt(0).toUpperCase()+avail.slice(1)}`;

    document.getElementById('previewModal').classList.add('open');
}
function closePreview() {
    document.getElementById('previewModal').classList.remove('open');
}

/* ── Close overlays on backdrop click ────── */
['verifyModal','portfolioModal','previewModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
});

/* ── Toast ───────────────────────────────── */
function showToast(msg) {
    const t = document.createElement('div');
    t.style.cssText = 'position:fixed;bottom:5rem;right:1.5rem;background:var(--navy);color:#fff;padding:.7rem 1.1rem;border-radius:9px;font-size:.82rem;font-weight:500;z-index:2000;animation:fadeIn .2s;box-shadow:0 6px 24px rgba(25,38,93,.3);max-width:300px;';
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 4000);
}
</script>
@endsection