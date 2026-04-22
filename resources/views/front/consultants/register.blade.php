@extends('layouts.base')
@section('title', 'Become a Terra Consultant')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:      #F7F5F2;
    --surface: #FFFFFF;
    --border:  rgba(0,0,0,.08);
    --border2: rgba(0,0,0,.15);
    --gold:    #D05208;
    --gold-bg: rgba(200,135,58,.07);
    --gold-bd: rgba(200,135,58,.22);
    --text:    #19265d;
    --muted:   #6B6560;
    --dim:     #9E9890;
    --green:   #1E7A5A;
    --purple:  #5A3B8A;
    --r:       12px;
    --t:       .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; min-height: 100vh; }
a { text-decoration: none; color: inherit; }

/* ── Page split ── */
.ar-page {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 380px 1fr;
}
@media (max-width: 860px) { .ar-page { grid-template-columns: 1fr; } }

/* ══════════════════════════════
   LEFT PANEL
══════════════════════════════ */
.ar-left {
    background: #19265d;
    position: relative; overflow: hidden;
    display: flex; flex-direction: column;
    justify-content: space-between;
    padding: 44px 40px;
    min-height: 100vh;
}
.ar-left::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 70% 50% at 30% 20%, rgba(90,59,138,.25) 0%, transparent 60%),
        radial-gradient(ellipse 50% 40% at 80% 80%, rgba(200,135,58,.08) 0%, transparent 60%);
    pointer-events: none;
}
.ar-left::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px);
    pointer-events: none;
}
@media (max-width: 860px) { .ar-left { min-height: auto; padding: 32px 24px; } }

.ar-logo {
    position: relative; z-index: 2;
    display: flex; align-items: center; gap: 10px;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem; font-weight: 600;
    color: #F0EDE8; letter-spacing: -.01em;
}
.ar-logo-dot { width: 8px; height: 8px; background: var(--gold); border-radius: 50%; }

.ar-hero-text {
    position: relative; z-index: 2;
    flex: 1; display: flex; flex-direction: column; justify-content: center;
    padding: 32px 0;
}
.ar-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 16px;
}
.ar-eyebrow::before { content: ''; width: 20px; height: 1px; background: var(--gold); opacity: .6; }
.ar-hero-text h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 3vw, 2.6rem);
    font-weight: 500; line-height: 1.15;
    letter-spacing: -.02em; color: #F0EDE8; margin-bottom: 16px;
}
.ar-hero-text h1 em { font-style: italic; color: var(--gold); }
.ar-hero-text p { font-size: .83rem; color: rgba(240,237,232,.5); line-height: 1.7; }

/* Step navigation sidebar */
.ar-steps-nav {
    position: relative; z-index: 2;
    display: flex; flex-direction: column; gap: 0;
}
.ar-step-nav-item {
    display: flex; align-items: flex-start; gap: 14px;
    padding: 12px 0; cursor: pointer;
    position: relative;
}
.ar-step-nav-item:not(:last-child)::after {
    content: '';
    position: absolute; left: 14px; top: 40px;
    width: 1px; height: calc(100% - 16px);
    background: rgba(255,255,255,.08);
}
.ar-step-nav-item.active:not(:last-child)::after { background: rgba(200,135,58,.3); }
.ar-step-nav-item.done:not(:last-child)::after   { background: rgba(200,135,58,.5); }

.step-nav-circle {
    width: 28px; height: 28px; border-radius: 50%;
    display: grid; place-items: center; flex-shrink: 0;
    font-size: .72rem; font-weight: 700;
    border: 1.5px solid rgba(255,255,255,.15);
    color: rgba(255,255,255,.35);
    transition: all var(--t);
    position: relative; z-index: 1;
}
.ar-step-nav-item.active .step-nav-circle {
    background: var(--gold); border-color: var(--gold); color: #fff;
    box-shadow: 0 0 0 4px rgba(200,135,58,.2);
}
.ar-step-nav-item.done .step-nav-circle {
    background: rgba(30,122,90,.8); border-color: var(--green); color: #fff;
}
.step-nav-circle svg { width: 13px; height: 13px; }

.step-nav-label { padding-top: 4px; }
.step-nav-title {
    font-size: .8rem; font-weight: 600;
    color: rgba(255,255,255,.35); transition: color var(--t);
}
.ar-step-nav-item.active .step-nav-title { color: #F0EDE8; }
.ar-step-nav-item.done .step-nav-title   { color: rgba(240,237,232,.6); }
.step-nav-sub { font-size: .7rem; color: rgba(255,255,255,.2); margin-top: 1px; }
.ar-step-nav-item.active .step-nav-sub  { color: rgba(200,135,58,.7); }

/* ══════════════════════════════
   RIGHT PANEL
══════════════════════════════ */
.ar-right {
    display: flex; flex-direction: column;
    justify-content: center; align-items: center;
    padding: 48px 40px;
    background: var(--bg);
    overflow: hidden;
}
@media (max-width: 600px) { .ar-right { padding: 32px 20px; } }

.ar-form-wrap { width: 100%; max-width: 520px; }

/* Progress bar */
.ar-progress-bar {
    height: 3px; background: var(--border); border-radius: 2px;
    margin-bottom: 28px; overflow: hidden;
}
.ar-progress-fill {
    height: 100%; background: var(--gold); border-radius: 2px;
    transition: width .5s cubic-bezier(.4,0,.2,1);
}

/* Step header */
.ar-step-header { margin-bottom: 24px; }
.ar-step-num {
    font-size: .7rem; font-weight: 600; letter-spacing: .1em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 6px;
}
.ar-step-header h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem; font-weight: 600;
    letter-spacing: -.02em; color: var(--text); margin: 0;
}
.ar-step-header p { font-size: .82rem; color: var(--muted); margin-top: 4px; }

/* Validation errors */
.ar-errors {
    background: #fef2f2; border: 1px solid #fecaca;
    border-radius: var(--r); padding: 12px 16px; margin-bottom: 20px;
}
.ar-errors ul { margin: 0; padding-left: 16px; }
.ar-errors li { font-size: .8rem; color: #dc2626; }

/* Step panels */
.ar-step { display: none; animation: stepIn .35s cubic-bezier(.4,0,.2,1) both; }
.ar-step.active { display: block; }
@keyframes stepIn {
    from { opacity: 0; transform: translateX(28px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes stepBack {
    from { opacity: 0; transform: translateX(-28px); }
    to   { opacity: 1; transform: translateX(0); }
}
.ar-step.going-back { animation: stepBack .35s cubic-bezier(.4,0,.2,1) both; }

/* Fields */
.ar-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
.ar-field:last-child { margin-bottom: 0; }
.ar-field label {
    font-size: .72rem; font-weight: 600; text-transform: uppercase;
    letter-spacing: .06em; color: var(--muted);
}
.ar-field label .req { color: #dc2626; margin-left: 2px; }
.ar-field input,
.ar-field textarea,
.ar-field select {
    padding: 10px 13px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: 9px; font-size: .84rem;
    font-family: 'DM Sans', sans-serif; color: var(--text);
    transition: border-color var(--t), box-shadow var(--t), background var(--t);
    width: 100%;
}
.ar-field input::placeholder,
.ar-field textarea::placeholder { color: var(--dim); }
.ar-field input:focus,
.ar-field textarea:focus,
.ar-field select:focus {
    outline: none; border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(200,135,58,.1);
    background: var(--surface);
}
.ar-field textarea { resize: vertical; min-height: 90px; }
.ar-field .hint { font-size: .71rem; color: var(--dim); }

/* File upload field */
.ar-field input[type="file"] {
    padding: 8px 13px;
    cursor: pointer;
}
.ar-field input[type="file"]::file-selector-button {
    padding: 5px 12px; border-radius: 6px; border: none;
    background: var(--gold-bg); color: var(--gold);
    font-size: .75rem; font-weight: 600; cursor: pointer;
    font-family: 'DM Sans', sans-serif; margin-right: 10px;
    transition: background var(--t);
}
.ar-field input[type="file"]::file-selector-button:hover { background: var(--gold); color: #fff; }

.ar-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
@media (max-width: 480px) { .ar-row { grid-template-columns: 1fr; } }

/* Password eye toggle */
.ar-pw { position: relative; }
.ar-pw input { padding-right: 40px; }
.pw-toggle {
    position: absolute; right: 12px; top: 50%;
    transform: translateY(-50%); background: none; border: none;
    cursor: pointer; color: var(--dim); padding: 0;
    transition: color var(--t);
}
.pw-toggle:hover { color: var(--gold); }
.pw-toggle svg { width: 15px; height: 15px; display: block; }

/* Service category checkboxes */
.service-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(155px, 1fr));
    gap: 8px;
}
.service-check { position: relative; }
.service-check input[type="checkbox"] {
    position: absolute; opacity: 0; width: 0; height: 0;
}
.service-check label {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 12px; border-radius: 9px;
    border: 1.5px solid var(--border);
    background: var(--bg); cursor: pointer;
    font-size: .8rem; font-weight: 500; color: var(--muted);
    transition: all var(--t);
    text-transform: none; letter-spacing: 0;
}
.service-check label::before {
    content: '';
    width: 16px; height: 16px; border-radius: 4px;
    border: 1.5px solid var(--border2); background: var(--surface);
    flex-shrink: 0; transition: all var(--t);
}
.service-check input:checked + label {
    border-color: var(--gold-bd);
    background: var(--gold-bg); color: var(--text);
}
.service-check input:checked + label::before {
    background: var(--gold); border-color: var(--gold);
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M9 12l2 2 4-4'/%3E%3C/svg%3E");
    background-size: 14px; background-repeat: no-repeat; background-position: center;
}
.service-check label:hover {
    border-color: var(--gold-bd); background: var(--gold-bg);
}

/* ══════════════════════════════
   CV upload zone
══════════════════════════════ */
.cv-upload-zone {
    border: 2px dashed var(--border2); border-radius: var(--r);
    padding: 24px 20px; text-align: center; cursor: pointer;
    transition: border-color var(--t), background var(--t);
    background: var(--bg); position: relative;
}
.cv-upload-zone:hover { border-color: var(--gold); background: var(--gold-bg); }
.cv-upload-zone input {
    position: absolute; inset: 0; opacity: 0; cursor: pointer;
    width: 100%; height: 100%; border: none; padding: 0;
}
.cv-upload-zone svg { width: 28px; height: 28px; color: var(--dim); margin-bottom: 8px; }
.cv-upload-zone .cvu-title { font-size: .82rem; color: var(--muted); font-weight: 500; }
.cv-upload-zone .cvu-sub   { font-size: .71rem; color: var(--dim); margin-top: 3px; }
.cv-filename {
    display: none; align-items: center; gap: 8px;
    font-size: .82rem; color: var(--green); font-weight: 500;
    justify-content: center;
}
.cv-filename svg { width: 16px; height: 16px; }

/* ✅ FIX 1 — Photo upload zone (was missing entirely, copied and adapted from cv styles) */
.photo-upload-zone {
    border: 2px dashed var(--border2); border-radius: var(--r);
    padding: 24px 20px; text-align: center; cursor: pointer;
    transition: border-color var(--t), background var(--t);
    background: var(--bg); position: relative;
}
.photo-upload-zone:hover { border-color: var(--gold); background: var(--gold-bg); }
.photo-upload-zone input {
    position: absolute; inset: 0; opacity: 0; cursor: pointer;
    width: 100%; height: 100%; border: none; padding: 0;
}
.photo-upload-zone svg  { width: 28px; height: 28px; color: var(--dim); margin-bottom: 8px; }
.photo-upload-zone .photou-title { font-size: .82rem; color: var(--muted); font-weight: 500; }
.photo-upload-zone .photou-sub   { font-size: .71rem; color: var(--dim); margin-top: 3px; }
.photo-filename {
    display: none; align-items: center; gap: 8px;
    font-size: .82rem; color: var(--green); font-weight: 500;
    justify-content: center;
}
.photo-filename svg { width: 16px; height: 16px; }

/* Photo preview inside zone */
.photo-preview-img {
    width: 72px; height: 72px; border-radius: 50%;
    object-fit: cover; border: 2px solid var(--gold);
    margin: 0 auto 8px; display: none;
}

/* Password strength */
.pw-strength { margin-top: 6px; }
.pw-strength-bar {
    height: 3px; background: var(--border); border-radius: 2px;
    overflow: hidden; margin-bottom: 4px;
}
.pw-strength-fill {
    height: 100%; border-radius: 2px;
    transition: width .3s ease, background .3s ease;
    width: 0%;
}
.pw-strength-label { font-size: .7rem; color: var(--dim); }

/* Notice */
.ar-notice {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 14px 16px; border-radius: var(--r);
    background: rgba(30,122,90,.06); border: 1px solid rgba(30,122,90,.18);
    font-size: .8rem; color: var(--green); margin-bottom: 20px; line-height: 1.6;
}
.ar-notice svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 2px; }

/* Nav buttons */
.ar-nav {
    display: flex; align-items: center; gap: 10px; margin-top: 24px;
}
.ar-btn-back {
    padding: 10px 20px; border-radius: 9px;
    border: 1.5px solid var(--border2); background: var(--surface);
    font-size: .83rem; font-weight: 500; color: var(--muted);
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t); display: none;
}
.ar-btn-back:hover { border-color: var(--gold); color: var(--gold); }
.ar-btn-next {
    flex: 1; padding: 11px 20px; border-radius: 9px;
    background: var(--gold); border: none; color: #fff;
    font-size: .85rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: background var(--t), transform var(--t);
    display: flex; align-items: center; justify-content: center; gap: 7px;
}
.ar-btn-next:hover { background: #a06828; transform: translateY(-1px); }
.ar-btn-next svg { width: 15px; height: 15px; }

.ar-login-link {
    text-align: center; font-size: .78rem; color: var(--muted); margin-top: 16px;
}
.ar-login-link a { color: var(--gold); font-weight: 500; }

/* ══════════════════════════════
   ✅ FIX 3 — Service panel CSS corrected to light theme
══════════════════════════════ */
.svc-section-label {
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: var(--dim);
    margin-bottom: 10px;
}

.svc-cat-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 20px;
    background: var(--gold); /* ✅ was var(--primary, #0d9488) */
    color: #fff;
    font-size: .65rem;
    font-weight: 700;
    margin-left: 6px;
    line-height: 1;
}

.svc-search-wrap {
    position: relative;
    margin-bottom: 16px;
}
.svc-search-wrap svg {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    width: 14px; height: 14px;
    color: var(--dim); /* ✅ was hardcoded color */
}
.svc-search {
    width: 100%;
    padding: 10px 12px 10px 36px;
    border: 1.5px solid var(--border); /* ✅ was rgba(255,255,255,.12) — dark theme */
    border-radius: 9px;
    background: var(--bg);            /* ✅ was rgba(255,255,255,.05) — dark theme */
    color: var(--text);
    font-size: .84rem;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color var(--t), box-shadow var(--t), background var(--t);
}
.svc-search:focus {
    border-color: var(--gold);        /* ✅ was var(--primary, #0d9488) */
    box-shadow: 0 0 0 3px rgba(200,135,58,.1);
    background: var(--surface);
}

.svc-group { margin-bottom: 20px; }
.svc-group-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid var(--border); /* ✅ was rgba(255,255,255,.08) — dark theme */
}
.svc-group-title {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--gold);  /* ✅ was var(--primary, #0d9488) */
}
.svc-select-all {
    font-size: .72rem;
    font-weight: 600;
    color: var(--gold);  /* ✅ was var(--primary, #0d9488) */
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    font-family: 'DM Sans', sans-serif;
}
.svc-select-all:hover { text-decoration: underline; }

.svc-summary {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 14px;
    padding: 10px 14px;
    border-radius: 9px;
    background: var(--gold-bg);  /* ✅ was rgba(13,148,136,.1) */
    border: 1px solid var(--gold-bd); /* ✅ was rgba(13,148,136,.25) */
    font-size: .78rem;
    color: var(--gold);          /* ✅ was var(--primary, #0d9488) */
}
.svc-summary svg { width: 14px; height: 14px; flex-shrink: 0; }
.svc-clear {
    margin-left: auto;
    font-size: .72rem;
    font-weight: 600;
    color: #ef4444;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    font-family: 'DM Sans', sans-serif;
}
.svc-clear:hover { text-decoration: underline; }
</style>

<div class="ar-page">

    {{-- ══ LEFT PANEL ══ --}}
    <aside class="ar-left">
        <div class="ar-logo">
            <div class="ar-logo-dot"></div>
            Terra
        </div>

        <div class="ar-hero-text">
            <div class="ar-eyebrow">Join our network</div>
            <h1>Become a<br><em>Terra Consultant</em></h1>
            <p>Connect with property buyers and sellers across Rwanda as a certified Terra consultant.</p>
        </div>

        <nav class="ar-steps-nav" id="steps-nav">
            <div class="ar-step-nav-item active" data-step="0">
                <div class="step-nav-circle">1</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Personal Info</div>
                    <div class="step-nav-sub">Name, email &amp; phone</div>
                </div>
            </div>
            <div class="ar-step-nav-item" data-step="1">
                <div class="step-nav-circle">2</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Professional</div>
                    <div class="step-nav-sub">Reg number, CV &amp; bio</div>
                </div>
            </div>
            <div class="ar-step-nav-item" data-step="2">
                <div class="step-nav-circle">3</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Services</div>
                    <div class="step-nav-sub">What you offer</div>
                </div>
            </div>
            <div class="ar-step-nav-item" data-step="3">
                <div class="step-nav-circle">4</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Account Security</div>
                    <div class="step-nav-sub">Password setup</div>
                </div>
            </div>
        </nav>
    </aside>

    {{-- ══ RIGHT PANEL ══ --}}
    <main class="ar-right">
        <div class="ar-form-wrap">

            <div class="ar-progress-bar">
                <div class="ar-progress-fill" id="progress-fill" style="width:25%"></div>
            </div>

            @if($errors->any())
            <div class="ar-errors">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- ✅ FIX 4 — pass the failed step index back so JS can restore it --}}
            <input type="hidden" id="initial-step" value="{{ $errors->any() ? (old('_step', 0)) : 0 }}">

            <form method="POST" action="{{ route('consultant.register.store') }}"
                  enctype="multipart/form-data" id="consultant-form">
                @csrf
                {{-- ✅ FIX 4 — hidden field tracks which step submitted --}}
                <input type="hidden" name="_step" id="form-step-field" value="0">

                {{-- ══ STEP 1: PERSONAL ══ --}}
                <div class="ar-step active" id="step-0">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 1 of 4</div>
                        <h2>Personal Information</h2>
                        <p>Let's start with the basics.</p>
                    </div>

                    <div class="ar-field">
                        <label>Full Name <span class="req">*</span></label>
                        <input type="text" name="name" id="f_name"
                               value="{{ old('name') }}"
                               placeholder="e.g. Jean-Paul Habimana" required>
                    </div>
                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Email Address <span class="req">*</span></label>
                            <input type="email" name="email" id="f_email"
                                   value="{{ old('email') }}"
                                   placeholder="you@email.com" required>
                        </div>
                        <div class="ar-field">
                            <label>Phone Number <span class="req">*</span></label>
                            <input type="tel" name="phone" id="f_phone"
                                   value="{{ old('phone') }}"
                                   placeholder="+250 7XX XXX XXX" required>
                        </div>
                    </div>
                    @include('includes.lc-form')
                </div>

                {{-- ══ STEP 2: PROFESSIONAL ══ --}}
                <div class="ar-step" id="step-1">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 2 of 4</div>
                        <h2>Professional Profile</h2>
                        <p>Tell us about your credentials and background.</p>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Registration Number</label>
                            <input type="text" name="reg_number"
                                   value="{{ old('reg_number') }}"
                                   placeholder="e.g. RW-2024-001">
                        </div>
                        <div class="ar-field">
                            <label>Company / Organization</label>
                            <input type="text" name="company"
                                   value="{{ old('company') }}"
                                   placeholder="Optional">
                        </div>
                    </div>

                    <div class="ar-field">
                        <label>Upload CV</label>
                        <div class="cv-upload-zone" id="cv-zone">
                            <input type="file" name="cv" accept=".pdf,.doc,.docx"
                                   onchange="handleCvUpload(this)">
                            <div id="cv-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                    <path d="M14 2v6h6M12 18v-6M9 15l3-3 3 3"/>
                                </svg>
                                <p class="cvu-title">Click to upload your CV</p>
                                <p class="cvu-sub">PDF, DOC or DOCX — Max 5MB</p>
                            </div>
                            <div class="cv-filename" id="cv-filename">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/><path d="M14 2v6h6"/></svg>
                                <span id="cv-name-label">file.pdf</span>
                            </div>
                        </div>
                    </div>

                    {{-- ✅ FIX 5 — added required attribute to match JS validation --}}
                    <div class="ar-field">
                        <label>Bio / About You <span class="req">*</span></label>
                        <textarea name="bio" id="f_bio" rows="4" required
                                  placeholder="Describe your experience, expertise, and what you offer as a consultant…">{{ old('bio') }}</textarea>
                        <span class="hint">This appears on your public profile.</span>
                    </div>

                    {{-- ✅ FIX 1 + 2 — Photo upload zone with correct CSS classes and working preview --}}
                    <div class="ar-field">
                        <label>Profile Photo</label>
                        <div class="photo-upload-zone" id="photo-zone">
                            <input type="file" name="photo" accept=".png,.jpg,.jpeg,.webp"
                                   onchange="handlePhotoUpload(this)">
                            <div id="photo-placeholder">
                                <img class="photo-preview-img" id="photo-preview-img" src="" alt="Preview">
                                <svg id="photo-placeholder-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                                <p class="photou-title">Click to upload your photo</p>
                                <p class="photou-sub">JPG, PNG or WEBP — Max 2MB</p>
                            </div>
                            <div class="photo-filename" id="photo-filename">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                                <span id="photo-name-label">photo.jpg</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══ STEP 3: SERVICES ══ --}}
                <div class="ar-step" id="step-2">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 3 of 4</div>
                        <h2>Services You Offer</h2>
                        <p>Select your service categories, then pick the specific services you provide.</p>
                    </div>

                    @if(isset($serviceCategories) && $serviceCategories->count())

                        <div class="svc-section-label">Step 1 — Choose your categories</div>
                        <div class="service-grid" id="catGrid">
                            @foreach($serviceCategories as $category)
                                @if($category->services->count())
                                <div class="service-check">
                                    <input type="checkbox"
                                           class="cat-trigger"
                                           name="service_categories[]"
                                           value="{{ $category->id }}"
                                           id="cat{{ $category->id }}"
                                           data-cat-id="{{ $category->id }}"
                                           {{ in_array($category->id, old('service_categories', [])) ? 'checked' : '' }}>
                                    <label for="cat{{ $category->id }}">
                                        {{ $category->name }}
                                        <span class="svc-cat-badge" id="badge-{{ $category->id }}" style="display:none">0</span>
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>

                        <div id="servicesPanel" style="display:none;margin-top:24px">
                            <div class="svc-section-label">Step 2 — Pick your specific services</div>

                            <div class="svc-search-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                                </svg>
                                <input type="text" id="serviceSearch" class="svc-search" placeholder="Filter services…">
                            </div>

                            <div id="serviceGroups">
                                @foreach($serviceCategories as $category)
                                    @if($category->services->count())
                                    <div class="svc-group" id="group-{{ $category->id }}" style="display:none">
                                        <div class="svc-group-header">
                                            <span class="svc-group-title">{{ $category->name }}</span>
                                            <button type="button" class="svc-select-all" data-group="{{ $category->id }}">
                                                Select all
                                            </button>
                                        </div>
                                        <div class="service-grid">
                                            @foreach($category->services as $svc)
                                            <div class="service-check">
                                                <input type="checkbox"
                                                       class="service-check-input"
                                                       name="services[]"
                                                       value="{{ $svc->id }}"
                                                       id="svc{{ $svc->id }}"
                                                       data-group="{{ $category->id }}"
                                                       data-name="{{ strtolower($svc->title) }}"
                                                       {{ in_array($svc->id, old('services', [])) ? 'checked' : '' }}>
                                                <label for="svc{{ $svc->id }}">{{ $svc->title }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>

                            <div id="svcSummary" style="display:none" class="svc-summary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 6 9 17l-5-5"/>
                                </svg>
                                <span><strong id="svcCount">0</strong> service(s) selected</span>
                                <button type="button" id="clearServices" class="svc-clear">Clear all</button>
                            </div>
                        </div>

                    @else
                        <p style="font-size:.83rem;color:var(--dim);text-align:center;padding:24px 0">
                            No service categories available yet.
                        </p>
                    @endif

                    <p style="font-size:.73rem;color:var(--dim);margin-top:14px">
                        You can update your services later from your dashboard.
                    </p>
                </div>

                {{-- ══ STEP 4: SECURITY ══ --}}
                <div class="ar-step" id="step-3">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 4 of 4</div>
                        <h2>Account Security</h2>
                        <p>Set a strong password to protect your account.</p>
                    </div>

                    <div class="ar-field">
                        <label>Password <span class="req">*</span></label>
                        <div class="ar-pw">
                            <input type="password" name="password" id="f_password"
                                   placeholder="Enter a strong password" required
                                   oninput="checkStrength(this.value)">
                            <button type="button" class="pw-toggle" onclick="togglePw('f_password', this)" aria-label="Toggle password">
                                <svg id="eye-pw" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <div class="pw-strength">
                            <div class="pw-strength-bar">
                                <div class="pw-strength-fill" id="pw-bar"></div>
                            </div>
                            <span class="pw-strength-label" id="pw-label">Enter a password</span>
                        </div>
                    </div>

                    <div class="ar-field">
                        <label>Confirm Password <span class="req">*</span></label>
                        <div class="ar-pw">
                            <input type="password" name="password_confirmation" id="f_confirm"
                                   placeholder="Re-enter your password" required>
                            <button type="button" class="pw-toggle" onclick="togglePw('f_confirm', this)" aria-label="Toggle confirm password">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="ar-notice">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Your application will be reviewed by our team before approval. You'll receive an email once your account is activated.</span>
                    </div>
                </div>

                {{-- Navigation --}}
                <div class="ar-nav">
                    <button type="button" class="ar-btn-back" id="btn-back" onclick="stepNav(-1)">
                        ← Back
                    </button>
                    <button type="button" class="ar-btn-next" id="btn-next" onclick="stepNav(1)">
                        Continue
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"/></svg>
                    </button>
                </div>

                <div class="ar-login-link">
                    Already have an account? <a href="{{ route('login') }}">Sign in here</a>
                </div>

            </form>
        </div>
    </main>

</div>

<script>
(function () {
    let current = 0;
    const TOTAL = 4;

    const steps        = document.querySelectorAll('.ar-step');
    const navItems     = document.querySelectorAll('.ar-step-nav-item');
    const progressFill = document.getElementById('progress-fill');
    const btnBack      = document.getElementById('btn-back');
    const btnNext      = document.getElementById('btn-next');
    const stepField    = document.getElementById('form-step-field');

    const required = {
        0: ['f_name', 'f_email', 'f_phone'],
        1: ['f_bio'],
        2: [],
        3: ['f_password', 'f_confirm'],
    };

    // ✅ FIX 4 — restore the correct step after a validation failure
    const initialStep = parseInt(document.getElementById('initial-step').value, 10) || 0;
    showStep(initialStep, false);

    /* ── Show step ── */
    function showStep(n, back) {
        steps.forEach(s => s.classList.remove('active', 'going-back'));
        navItems.forEach((ni, i) => {
            ni.classList.remove('active', 'done');
            if (i < n)  ni.classList.add('done');
            if (i === n) ni.classList.add('active');

            const circle = ni.querySelector('.step-nav-circle');
            if (i < n) {
                circle.innerHTML = `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg>`;
            } else {
                circle.textContent = i + 1;
            }
        });

        const target = steps[n];
        if (back) target.classList.add('going-back');
        target.classList.add('active');

        progressFill.style.width = ((n + 1) / TOTAL * 100) + '%';
        btnBack.style.display = n === 0 ? 'none' : 'inline-block';

        // ✅ FIX 4 — keep hidden field in sync so server knows which step failed
        stepField.value = n;

        if (n === TOTAL - 1) {
            btnNext.innerHTML = `<svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14l-4-4 1.41-1.41L11 13.17l6.59-6.59L19 8l-8 8z"/></svg> Submit Application`;
            btnNext.onclick = () => {
                if (validate(current)) {
                    if (!checkPasswordMatch()) return;
                    document.getElementById('consultant-form').submit();
                }
            };
        } else {
            btnNext.innerHTML = `Continue <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"/></svg>`;
            btnNext.onclick = () => stepNav(1);
        }

        current = n;
    }

    /* ── Navigate ── */
    window.stepNav = function (dir) {
        if (dir === 1 && !validate(current)) return;
        const next = current + dir;
        if (next < 0 || next >= TOTAL) return;
        showStep(next, dir < 0);
    };

    /* ── Validate required fields ── */
    function validate(n) {
        const req = required[n] || [];
        let ok = true;
        req.forEach(id => {
            const el = document.getElementById(id);
            if (!el || !el.value.trim()) {
                if (el) {
                    el.focus();
                    el.style.borderColor = '#dc2626';
                    el.style.boxShadow   = '0 0 0 3px rgba(220,38,38,.12)';
                    setTimeout(() => { el.style.borderColor = ''; el.style.boxShadow = ''; }, 2000);
                }
                ok = false;
            }
        });
        return ok;
    }

    /* ── Password match check ── */
    function checkPasswordMatch() {
        const pw = document.getElementById('f_password').value;
        const cf = document.getElementById('f_confirm');
        if (pw !== cf.value) {
            cf.style.borderColor = '#dc2626';
            cf.style.boxShadow   = '0 0 0 3px rgba(220,38,38,.12)';
            cf.focus();
            setTimeout(() => { cf.style.borderColor = ''; cf.style.boxShadow = ''; }, 2000);
            return false;
        }
        return true;
    }

    /* ── Sidebar nav — click to go back ── */
    navItems.forEach((ni, i) => {
        ni.addEventListener('click', () => {
            if (i < current) showStep(i, true);
        });
    });

    /* ── CV upload label ── */
    window.handleCvUpload = function (input) {
        if (!input.files || !input.files[0]) return;
        const name = input.files[0].name;
        document.getElementById('cv-placeholder').style.display  = 'none';
        document.getElementById('cv-name-label').textContent     = name;
        document.getElementById('cv-filename').style.display     = 'flex';
    };

    // ✅ FIX 2 — handlePhotoUpload function was missing entirely
    window.handlePhotoUpload = function (input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const name = file.name;

        // Show filename
        document.getElementById('photo-name-label').textContent  = name;
        document.getElementById('photo-filename').style.display  = 'flex';

        // Show image preview
        const reader = new FileReader();
        reader.onload = e => {
            const img  = document.getElementById('photo-preview-img');
            const icon = document.getElementById('photo-placeholder-icon');
            img.src          = e.target.result;
            img.style.display = 'block';
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(file);
    };

    /* ── Password visibility toggle ── */
    window.togglePw = function (id, btn) {
        const el = document.getElementById(id);
        const isText = el.type === 'text';
        el.type = isText ? 'password' : 'text';
        btn.querySelector('svg').style.opacity = isText ? '1' : '0.45';
    };

    /* ── Password strength ── */
    window.checkStrength = function (val) {
        const bar   = document.getElementById('pw-bar');
        const label = document.getElementById('pw-label');
        let score = 0;
        if (val.length >= 8)           score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^A-Za-z0-9]/.test(val))  score++;

        const levels = [
            { w: '0%',   bg: 'transparent', txt: 'Enter a password' },
            { w: '25%',  bg: '#ef4444',     txt: 'Weak' },
            { w: '50%',  bg: '#f97316',     txt: 'Fair' },
            { w: '75%',  bg: '#eab308',     txt: 'Good' },
            { w: '100%', bg: '#22c55e',     txt: 'Strong' },
        ];
        const lvl = val.length === 0 ? levels[0] : levels[score] || levels[1];
        bar.style.width      = lvl.w;
        bar.style.background = lvl.bg;
        label.textContent    = lvl.txt;
        label.style.color    = lvl.bg === 'transparent' ? 'var(--dim)' : lvl.bg;
    };

})();
</script>

<script>
(function () {

    // ── Category toggle ──────────────────────────────────────────
    document.querySelectorAll('.cat-trigger').forEach(cb => {
        cb.addEventListener('change', handleCatChange);
    });

    function handleCatChange() {
        const catId = this.dataset.catId;
        const group = document.getElementById('group-' + catId);
        const panel = document.getElementById('servicesPanel');

        if (this.checked) {
            if (group) group.style.display = 'block';
        } else {
            if (group) {
                group.style.display = 'none';
                group.querySelectorAll('.service-check-input').forEach(s => s.checked = false);
            }
        }

        const anyChecked = document.querySelectorAll('.cat-trigger:checked').length > 0;
        panel.style.display = anyChecked ? 'block' : 'none';

        updateBadges();
        updateSummary();
    }

    // ── Select all per group ─────────────────────────────────────
    document.querySelectorAll('.svc-select-all').forEach(btn => {
        btn.addEventListener('click', function () {
            const groupId    = this.dataset.group;
            const services   = document.querySelectorAll(`.service-check-input[data-group="${groupId}"]`);
            const allChecked = [...services].every(s => s.checked);
            services.forEach(s => s.checked = !allChecked);
            this.textContent = allChecked ? 'Select all' : 'Deselect all';
            updateBadges();
            updateSummary();
        });
    });

    // ── Individual service change ────────────────────────────────
    document.querySelectorAll('.service-check-input').forEach(cb => {
        cb.addEventListener('change', () => { updateBadges(); updateSummary(); });
    });

    // ── Badge counts ─────────────────────────────────────────────
    function updateBadges() {
        document.querySelectorAll('.cat-trigger').forEach(cb => {
            const catId = cb.dataset.catId;
            const count = document.querySelectorAll(`.service-check-input[data-group="${catId}"]:checked`).length;
            const badge = document.getElementById('badge-' + catId);
            if (badge) {
                badge.textContent   = count;
                badge.style.display = count > 0 ? 'inline-flex' : 'none';
            }
        });
    }

    // ── Summary bar ──────────────────────────────────────────────
    function updateSummary() {
        const total   = document.querySelectorAll('.service-check-input:checked').length;
        const summary = document.getElementById('svcSummary');
        document.getElementById('svcCount').textContent = total;
        summary.style.display = total > 0 ? 'flex' : 'none';
    }

    // ── Search / filter ──────────────────────────────────────────
    document.getElementById('serviceSearch')?.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.service-check-input').forEach(cb => {
            const match = cb.dataset.name.includes(q);
            cb.parentElement.style.display = match ? '' : 'none';
        });
    });

    // ── Clear all ────────────────────────────────────────────────
    document.getElementById('clearServices')?.addEventListener('click', () => {
        document.querySelectorAll('.service-check-input').forEach(s => s.checked = false);
        document.querySelectorAll('.svc-select-all').forEach(b => b.textContent = 'Select all');
        updateBadges();
        updateSummary();
    });

    // ── Restore state on load (old() after validation failure) ───
    document.querySelectorAll('.cat-trigger:checked').forEach(cb => {
        const group = document.getElementById('group-' + cb.dataset.catId);
        if (group) group.style.display = 'block';
    });
    const anyOnLoad = document.querySelectorAll('.cat-trigger:checked').length > 0;
    if (anyOnLoad) document.getElementById('servicesPanel').style.display = 'block';

    document.querySelectorAll('.svc-select-all').forEach(btn => {
        const groupId  = btn.dataset.group;
        const services = document.querySelectorAll(`.service-check-input[data-group="${groupId}"]`);
        if (services.length && [...services].every(s => s.checked)) {
            btn.textContent = 'Deselect all';
        }
    });

    updateBadges();
    updateSummary();

})();
</script>

@endsection