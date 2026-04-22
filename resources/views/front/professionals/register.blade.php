@extends('layouts.base')
@section('title', 'Become a Professional')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:      #F7F5F2;
    --surface: #FFFFFF;
    --border:  rgba(0,0,0,.08);
    --border2: rgba(0,0,0,.15);
    --gold:    #C8873A;
    --gold-bg: rgba(200,135,58,.07);
    --gold-bd: rgba(200,135,58,.22);
    --text:    #19265d;
    --muted:   #6B6560;
    --dim:     #9E9890;
    --green:   #1E7A5A;
    --green-bg:rgba(30,122,90,.07);
    --green-bd:rgba(30,122,90,.2);
    --err:     #dc2626;
    --err-bg:  rgba(220,38,38,.06);
    --err-bd:  rgba(220,38,38,.35);
    --r:       12px;
    --t:       .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; min-height: 100vh; }
a { text-decoration: none; color: inherit; }

.ar-page { min-height: 100vh; display: grid; grid-template-columns: 340px 1fr; }
@media (max-width: 860px) { .ar-page { grid-template-columns: 1fr; } }

.ar-left {
    background: #19265d; position: relative; overflow: hidden;
    display: flex; flex-direction: column; justify-content: space-between;
    padding: 44px 36px; min-height: 100vh;
}
.ar-left::before {
    content: ''; position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 70% 50% at 30% 20%, rgba(90,59,138,.22) 0%, transparent 60%),
        radial-gradient(ellipse 50% 40% at 80% 80%, rgba(200,135,58,.09) 0%, transparent 60%);
    pointer-events: none;
}
.ar-left::after {
    content: ''; position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px),
        repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255,255,255,.02) 39px, rgba(255,255,255,.02) 40px);
    pointer-events: none;
}
@media (max-width: 860px) { .ar-left { min-height: auto; padding: 28px 22px; } }

.ar-logo {
    position: relative; z-index: 2; display: flex; align-items: center; gap: 10px;
    font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-weight: 600;
    color: #F0EDE8; letter-spacing: -.01em;
}
.ar-logo-dot { width: 8px; height: 8px; background: var(--gold); border-radius: 50%; }

.ar-hero-text {
    position: relative; z-index: 2; flex: 1;
    display: flex; flex-direction: column; justify-content: center; padding: 28px 0;
}
.ar-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 14px;
}
.ar-eyebrow::before { content: ''; width: 18px; height: 1px; background: var(--gold); opacity: .55; }
.ar-hero-text h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.6rem, 2.6vw, 2.2rem); font-weight: 500; line-height: 1.18;
    letter-spacing: -.02em; color: #F0EDE8; margin-bottom: 14px;
}
.ar-hero-text h1 em { font-style: italic; color: var(--gold); }
.ar-hero-text p { font-size: .82rem; color: rgba(240,237,232,.45); line-height: 1.7; }

.ar-steps-nav { position: relative; z-index: 2; display: flex; flex-direction: column; gap: 0; }
.ar-step-nav-item {
    display: flex; align-items: flex-start; gap: 13px;
    padding: 11px 0; cursor: pointer; position: relative;
}
.ar-step-nav-item:not(:last-child)::after {
    content: ''; position: absolute; left: 13px; top: 38px;
    width: 1px; height: calc(100% - 14px); background: rgba(255,255,255,.07);
}
.ar-step-nav-item.active:not(:last-child)::after { background: rgba(200,135,58,.28); }
.ar-step-nav-item.done:not(:last-child)::after   { background: rgba(200,135,58,.45); }

.step-nav-circle {
    width: 27px; height: 27px; border-radius: 50%;
    display: grid; place-items: center; flex-shrink: 0;
    font-size: .7rem; font-weight: 700;
    border: 1.5px solid rgba(255,255,255,.12); color: rgba(255,255,255,.3);
    transition: all var(--t); position: relative; z-index: 1;
}
.ar-step-nav-item.active .step-nav-circle {
    background: var(--gold); border-color: var(--gold); color: #fff;
    box-shadow: 0 0 0 4px rgba(200,135,58,.18);
}
.ar-step-nav-item.done .step-nav-circle {
    background: rgba(30,122,90,.75); border-color: var(--green); color: #fff;
}
.step-nav-circle svg { width: 13px; height: 13px; }
.step-nav-label { padding-top: 3px; }
.step-nav-title { font-size: .79rem; font-weight: 600; color: rgba(255,255,255,.3); transition: color var(--t); }
.ar-step-nav-item.active .step-nav-title { color: #F0EDE8; }
.ar-step-nav-item.done .step-nav-title   { color: rgba(240,237,232,.55); }
.step-nav-sub { font-size: .69rem; color: rgba(255,255,255,.18); margin-top: 1px; }
.ar-step-nav-item.active .step-nav-sub  { color: rgba(200,135,58,.65); }

.ar-right {
    display: flex; flex-direction: column; justify-content: center; align-items: center;
    padding: 48px 40px; background: var(--bg);
}
@media (max-width: 600px) { .ar-right { padding: 28px 18px; } }
.ar-form-wrap { width: 100%; max-width: 560px; }

.ar-progress-bar { height: 3px; background: var(--border); border-radius: 2px; margin-bottom: 26px; overflow: hidden; }
.ar-progress-fill { height: 100%; background: var(--gold); border-radius: 2px; transition: width .45s cubic-bezier(.4,0,.2,1); }

.ar-step-header { margin-bottom: 22px; }
.ar-step-num { font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--gold); margin-bottom: 5px; }
.ar-step-header h2 { font-family: 'Cormorant Garamond', serif; font-size: 1.45rem; font-weight: 600; letter-spacing: -.02em; color: var(--text); margin: 0; }
.ar-step-header p { font-size: .81rem; color: var(--muted); margin-top: 4px; }

/* Inline field error */
.ar-field-error {
    display: flex; align-items: center; gap: 5px;
    font-size: .72rem; color: var(--err); font-weight: 500; margin-top: 2px;
}
.ar-field-error svg { width: 11px; height: 11px; flex-shrink: 0; }

/* Red border when invalid */
.ar-field input.is-invalid,
.ar-field textarea.is-invalid,
.ar-field select.is-invalid {
    border-color: var(--err-bd) !important;
    background: var(--err-bg) !important;
    box-shadow: 0 0 0 3px rgba(220,38,38,.08) !important;
}
.ar-upload-zone.is-invalid { border-color: var(--err-bd) !important; background: var(--err-bg) !important; }

.ar-step { display: none; animation: stepIn .32s cubic-bezier(.4,0,.2,1) both; }
.ar-step.active { display: block; }
@keyframes stepIn   { from { opacity:0; transform:translateX(24px);  } to { opacity:1; transform:none; } }
@keyframes stepBack { from { opacity:0; transform:translateX(-24px); } to { opacity:1; transform:none; } }
.ar-step.going-back { animation: stepBack .32s cubic-bezier(.4,0,.2,1) both; }

.ar-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 13px; }
.ar-field:last-child { margin-bottom: 0; }
.ar-field label { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
.ar-field label .req { color: var(--err); margin-left: 2px; }
.ar-field input,
.ar-field textarea,
.ar-field select {
    padding: 10px 13px; background: var(--bg); border: 1.5px solid var(--border);
    border-radius: 9px; font-size: .84rem; font-family: 'DM Sans', sans-serif;
    color: var(--text); transition: border-color var(--t), box-shadow var(--t), background var(--t); width: 100%;
}
.ar-field input::placeholder, .ar-field textarea::placeholder { color: var(--dim); }
.ar-field input:focus, .ar-field textarea:focus, .ar-field select:focus {
    outline: none; border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(200,135,58,.1); background: var(--surface);
}
.ar-field textarea { resize: vertical; min-height: 90px; }
.ar-field .hint { font-size: .71rem; color: var(--dim); }

.ar-row  { display: grid; grid-template-columns: 1fr 1fr; gap: 13px; }
.ar-row3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 13px; }
@media (max-width: 520px) { .ar-row, .ar-row3 { grid-template-columns: 1fr; } }

.ar-upload-zone {
    border: 2px dashed var(--border2); border-radius: var(--r);
    padding: 22px 16px; text-align: center; cursor: pointer;
    transition: border-color var(--t), background var(--t);
    background: var(--bg); position: relative;
}
.ar-upload-zone:hover { border-color: var(--gold); background: var(--gold-bg); }
.ar-upload-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; border: none; padding: 0; }
.ar-upload-zone svg { width: 26px; height: 26px; color: var(--dim); margin-bottom: 7px; }
.ar-upload-zone .uz-title { font-size: .8rem; color: var(--muted); font-weight: 500; }
.ar-upload-zone .uz-sub   { font-size: .7rem; color: var(--dim); margin-top: 2px; }
.ar-file-picked { display: none; align-items: center; justify-content: center; gap: 7px; font-size: .8rem; color: var(--green); font-weight: 500; }
.ar-file-picked svg { width: 14px; height: 14px; }
.photo-preview-img { width: 68px; height: 68px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold); margin: 0 auto 8px; display: none; }

.svc-section-label { font-size: .69rem; font-weight: 600; text-transform: uppercase; letter-spacing: .08em; color: var(--muted); margin-bottom: 10px; }
.service-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 8px; }
.service-check { position: relative; }
.service-check input[type="checkbox"] { position: absolute; opacity: 0; width: 0; height: 0; }
.service-check label {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 12px; border-radius: 9px; border: 1.5px solid var(--border);
    background: var(--bg); cursor: pointer; font-size: .79rem;
    font-weight: 500; color: var(--muted); transition: all var(--t); text-transform: none; letter-spacing: 0;
}
.service-check label::before {
    content: ''; width: 15px; height: 15px; border-radius: 4px;
    border: 1.5px solid var(--border2); background: var(--surface); flex-shrink: 0; transition: all var(--t);
}
.service-check input:checked + label { border-color: var(--gold-bd); background: var(--gold-bg); color: var(--text); }
.service-check input:checked + label::before {
    background: var(--gold); border-color: var(--gold);
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M9 12l2 2 4-4'/%3E%3C/svg%3E");
    background-size: 13px; background-repeat: no-repeat; background-position: center;
}
.service-check label:hover { border-color: var(--gold-bd); background: var(--gold-bg); }

.svc-cat-badge { margin-left: auto; font-size: .65rem; font-weight: 700; background: var(--gold); color: #fff; border-radius: 99px; padding: 1px 6px; line-height: 1.4; }
.svc-group { margin-bottom: 18px; }
.svc-group-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
.svc-group-title { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: var(--gold); }
.svc-select-all { font-size: .7rem; font-weight: 600; color: var(--muted); background: none; border: none; cursor: pointer; font-family: 'DM Sans', sans-serif; padding: 0; transition: color var(--t); }
.svc-select-all:hover { color: var(--gold); }

.svc-summary { display: flex; align-items: center; gap: 8px; margin-top: 12px; padding: 9px 13px; border-radius: 9px; background: var(--gold-bg); border: 1px solid var(--gold-bd); font-size: .78rem; color: var(--gold); }
.svc-summary svg { width: 13px; height: 13px; flex-shrink: 0; }
.svc-clear { margin-left: auto; font-size: .72rem; font-weight: 600; color: #ef4444; background: none; border: none; cursor: pointer; padding: 0; font-family: 'DM Sans', sans-serif; }
.svc-clear:hover { text-decoration: underline; }

.svc-search-wrap { position: relative; margin-bottom: 14px; }
.svc-search-wrap svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 13px; height: 13px; color: var(--dim); pointer-events: none; }
.svc-search { width: 100%; padding: 9px 12px 9px 33px; border: 1.5px solid var(--border); border-radius: 9px; background: var(--bg); color: var(--text); font-size: .82rem; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color var(--t); }
.svc-search:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200,135,58,.1); background: var(--surface); }

.ar-nav { display: flex; align-items: center; gap: 10px; margin-top: 22px; }
.ar-btn-back { padding: 10px 20px; border-radius: 9px; border: 1.5px solid var(--border2); background: var(--surface); font-size: .82rem; font-weight: 500; color: var(--muted); font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all var(--t); display: none; }
.ar-btn-back:hover { border-color: var(--gold); color: var(--gold); }
.ar-btn-next { flex: 1; padding: 11px 20px; border-radius: 9px; background: var(--gold); border: none; color: #fff; font-size: .84rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background var(--t), transform var(--t); display: flex; align-items: center; justify-content: center; gap: 7px; }
.ar-btn-next:hover { background: #a06828; transform: translateY(-1px); }
.ar-btn-next svg { width: 15px; height: 15px; }
</style>

@php
    $errIcon     = '<svg viewBox="0 0 24 24" fill="currentColor" style="width:11px;height:11px;flex-shrink:0"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V8h2v4z"/></svg>';

    // Resolve which step to open on page load.
    // The controller sets session('failingStep') when validation fails.
    // On a fresh visit this will be 0.
    $initialStep = (int) session('failingStep', 0);
@endphp

<div class="ar-page">

    <aside class="ar-left">
        <div class="ar-logo"><div class="ar-logo-dot"></div>Terra</div>

        <div class="ar-hero-text">
            <div class="ar-eyebrow">Professional Network</div>
            <h1>Add a<br><em>Terra Professional</em></h1>
            <p>Register an architect, engineer, or consultant to the Terra professional directory.</p>
        </div>

        <nav class="ar-steps-nav" id="steps-nav">
            <div class="ar-step-nav-item active" data-step="0">
                <div class="step-nav-circle">1</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Personal Info</div>
                    <div class="step-nav-sub">Name, email &amp; contact</div>
                </div>
            </div>
            <div class="ar-step-nav-item" data-step="1">
                <div class="step-nav-circle">2</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Professional Details</div>
                    <div class="step-nav-sub">Credentials &amp; bio</div>
                </div>
            </div>
            <div class="ar-step-nav-item" data-step="2">
                <div class="step-nav-circle">3</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Services</div>
                    <div class="step-nav-sub">What they offer</div>
                </div>
            </div>
        </nav>
    </aside>

    <main class="ar-right">
        <div class="ar-form-wrap">

            <div class="ar-progress-bar">
                <div class="ar-progress-fill" id="progress-fill" style="width:33.33%"></div>
            </div>

            {{-- PHP resolves the starting step; JS reads it from this hidden input --}}
            <input type="hidden" id="initial-step" value="{{ $initialStep }}">

            <form method="POST"
                  action="{{ route('front.professionals.register.store') }}"
                  enctype="multipart/form-data"
                  id="pro-form">
                @csrf
                <input type="hidden" name="_step" id="form-step-field" value="0">

                {{-- ═══════════════════════════════════════════════ STEP 1 ══ --}}
                <div class="ar-step active" id="step-0">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 1 of 3</div>
                        <h2>Personal Information</h2>
                        <p>Basic contact details for the professional.</p>
                    </div>

                    <div class="ar-field">
                        <label>Full Name <span class="req">*</span></label>
                        <input type="text" name="full_name" id="f_name"
                               value="{{ old('full_name') }}"
                               placeholder="e.g. Jean-Paul Habimana"
                               class="{{ $errors->has('full_name') ? 'is-invalid' : '' }}">
                        @error('full_name')
                            <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Email Address <span class="req">*</span></label>
                            <input type="email" name="email" id="f_email"
                                   value="{{ old('email') }}"
                                   placeholder="pro@email.com"
                                   class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                            @error('email')
                                <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ar-field">
                            <label>Phone Number <span class="req">*</span></label>
                            <input type="tel" name="phone" id="f_phone"
                                   value="{{ old('phone') }}"
                                   placeholder="+250 7XX XXX XXX"
                                   class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                            @error('phone')
                                <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>WhatsApp</label>
                            <input type="tel" name="whatsapp"
                                   value="{{ old('whatsapp') }}"
                                   placeholder="+250 7XX XXX XXX"
                                   class="{{ $errors->has('whatsapp') ? 'is-invalid' : '' }}">
                            @error('whatsapp')
                                <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ar-field">
                            <label>Office Location</label>
                            <input type="text" name="office_location"
                                   value="{{ old('office_location') }}"
                                   placeholder="e.g. Kigali, Nyarugenge"
                                   class="{{ $errors->has('office_location') ? 'is-invalid' : '' }}">
                            @error('office_location')
                                <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="ar-field">
                        <label>Languages Spoken</label>
                        <input type="text" name="languages"
                               value="{{ old('languages') }}"
                               placeholder="e.g. Kinyarwanda, English, French"
                               class="{{ $errors->has('languages') ? 'is-invalid' : '' }}">
                        @error('languages')
                            <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                        @else
                            <span class="hint">Separate multiple languages with commas.</span>
                        @enderror
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════ STEP 2 ══ --}}
                <div class="ar-step" id="step-1">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 2 of 3</div>
                        <h2>Professional Details</h2>
                        <p>Credentials, experience, and public profile information.</p>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Profession / Title <span class="req">*</span></label>
                            <input type="text" name="profession" id="f_profession"
                                   value="{{ old('profession') }}"
                                   placeholder="e.g. Architect, Civil Engineer"
                                   class="{{ $errors->has('profession') ? 'is-invalid' : '' }}">
                            @error('profession')
                                <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ar-field">
                            <label>License Number</label>
                            <input type="text" name="license_number"
                                   value="{{ old('license_number') }}"
                                   placeholder="e.g. RW-ARCH-0042"
                                   class="{{ $errors->has('license_number') ? 'is-invalid' : '' }}">
                            @error('license_number')
                                <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="ar-field">
                        <label>Bio <span class="req">*</span></label>
                        <textarea name="bio" id="f_bio" rows="4"
                                  placeholder="Describe their background, expertise, and specialisations…"
                                  class="{{ $errors->has('bio') ? 'is-invalid' : '' }}">{{ old('bio') }}</textarea>
                        @error('bio')
                            <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                        @else
                            <span class="hint">Displayed on their public Terra profile.</span>
                        @enderror
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Website</label>
                            <input type="url" name="website"
                                   value="{{ old('website') }}"
                                   placeholder="https://theirsite.com"
                                   class="{{ $errors->has('website') ? 'is-invalid' : '' }}">
                            @error('website')
                                <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                            @enderror
                        </div>
                        <div class="ar-field">
                            <label>Portfolio URL</label>
                            <input type="url" name="portfolio_url"
                                   value="{{ old('portfolio_url') }}"
                                   placeholder="https://behance.net/…"
                                   class="{{ $errors->has('portfolio_url') ? 'is-invalid' : '' }}">
                            @error('portfolio_url')
                                <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="ar-field">
                        <label>LinkedIn</label>
                        <input type="url" name="linkedin"
                               value="{{ old('linkedin') }}"
                               placeholder="https://linkedin.com/in/…"
                               class="{{ $errors->has('linkedin') ? 'is-invalid' : '' }}">
                        @error('linkedin')
                            <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="ar-field" style="margin-top:4px">
                        <label>Profile Photo</label>
                        <div class="ar-upload-zone {{ $errors->has('profile_image') ? 'is-invalid' : '' }}" id="photo-zone">
                            <input type="file" name="profile_image" accept=".jpg,.jpeg,.png,.webp" onchange="handlePhoto(this)">
                            <div id="photo-placeholder">
                                <img class="photo-preview-img" id="photo-preview" src="" alt="">
                                <svg id="photo-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                                </svg>
                                <p class="uz-title">Click to upload profile photo</p>
                                <p class="uz-sub">JPG, PNG or WEBP — Max 2MB</p>
                            </div>
                            <div class="ar-file-picked" id="photo-picked">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span id="photo-name"></span>
                            </div>
                        </div>
                        @error('profile_image')
                            <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="ar-field">
                        <label>Credentials Document</label>
                        <div class="ar-upload-zone {{ $errors->has('credentials_doc') ? 'is-invalid' : '' }}" id="cred-zone">
                            <input type="file" name="credentials_doc" accept=".pdf,.jpg,.jpeg,.png" onchange="handleCred(this)">
                            <div id="cred-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                    <path d="M14 2v6h6M12 18v-6M9 15l3-3 3 3"/>
                                </svg>
                                <p class="uz-title">Upload license or certificate</p>
                                <p class="uz-sub">PDF, JPG or PNG — Max 5MB</p>
                            </div>
                            <div class="ar-file-picked" id="cred-picked">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span id="cred-name"></span>
                            </div>
                        </div>
                        @error('credentials_doc')
                            <span class="ar-field-error">{!! $errIcon !!} {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════ STEP 3 ══ --}}
                <div class="ar-step" id="step-2">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 3 of 3</div>
                        <h2>Services Offered</h2>
                        <p>Select the services this professional provides.</p>
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
                        @error('service_categories')
                            <span class="ar-field-error" style="margin-top:6px">{!! $errIcon !!} {{ $message }}</span>
                        @enderror

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
                                            <button type="button" class="svc-select-all" data-group="{{ $category->id }}">Select all</button>
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

                            @error('services')
                                <span class="ar-field-error" style="margin-top:6px">{!! $errIcon !!} {{ $message }}</span>
                            @enderror

                            <div id="svcSummary" style="display:none" class="svc-summary">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                                <span><strong id="svcCount">0</strong> service(s) selected</span>
                                <button type="button" id="clearServices" class="svc-clear">Clear all</button>
                            </div>
                        </div>
                    @else
                        <p style="font-size:.83rem;color:var(--dim);text-align:center;padding:24px 0">No service categories available yet.</p>
                    @endif

                    <p style="font-size:.73rem;color:var(--dim);margin-top:14px">You can update your services later from your dashboard.</p>
                </div>

                <div class="ar-nav">
                    <button type="button" class="ar-btn-back" id="btn-back" onclick="stepNav(-1)">← Back</button>
                    <button type="button" class="ar-btn-next" id="btn-next" onclick="stepNav(1)">
                        Continue
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

{{-- ── SweetAlert feedback ─────────────────────────────────────────────────── --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Application Submitted',
        text: @json(session('success')),
        confirmButtonColor: '#1E7A5A',
        confirmButtonText: 'Continue',
    });
});
</script>

@elseif(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Something went wrong',
        text: @json(session('error')),
        confirmButtonColor: '#dc2626',
    });
});
</script>

@elseif($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show a SweetAlert summarising all validation errors.
    // The step jump (handled by JS below) runs first so the user
    // lands on the correct step before the modal appears.
    Swal.fire({
        icon: 'error',
        title: 'Please fix the following',
        html: @json(implode('<br>', $errors->all())),
        confirmButtonColor: '#D05208',
        confirmButtonText: 'Got it',
    });
});
</script>
@endif

<script>
// ── Multi-step wizard ────────────────────────────────────────────────────────
(function () {
    const TOTAL     = 3;
    let   current   = 0;
    const steps     = document.querySelectorAll('.ar-step');
    const navItems  = document.querySelectorAll('.ar-step-nav-item');
    const progFill  = document.getElementById('progress-fill');
    const btnBack   = document.getElementById('btn-back');
    const btnNext   = document.getElementById('btn-next');
    const stepField = document.getElementById('form-step-field');

    // Client-side required-field check before "Continue"
    const required = {
        0: ['f_name', 'f_email', 'f_phone'],
        1: ['f_profession', 'f_bio'],
        2: [],
    };

    // Read which step PHP told us to open (failingStep from session)
    const rawInit   = parseInt(document.getElementById('initial-step').value, 10);
    const startStep = Number.isFinite(rawInit) ? rawInit : 0;
    showStep(startStep, false);

    function showStep(n, back) {
        steps.forEach(s => s.classList.remove('active', 'going-back'));
        navItems.forEach((ni, i) => {
            ni.classList.remove('active', 'done');
            if (i < n)  ni.classList.add('done');
            if (i === n) ni.classList.add('active');
            const c = ni.querySelector('.step-nav-circle');
            c.innerHTML = i < n
                ? `<svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg>`
                : (i + 1);
        });

        const target = steps[n];
        if (back) target.classList.add('going-back');
        target.classList.add('active');

        progFill.style.width    = ((n + 1) / TOTAL * 100) + '%';
        btnBack.style.display   = n === 0 ? 'none' : 'inline-block';
        stepField.value         = n;
        current                 = n;

        if (n === TOTAL - 1) {
            btnNext.innerHTML = `<svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14l-4-4 1.41-1.41L11 13.17l6.59-6.59L19 8l-8 8z"/></svg> Create Professional`;
            btnNext.onclick = () => { if (validate(current)) document.getElementById('pro-form').submit(); };
        } else {
            btnNext.innerHTML = `Continue <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"/></svg>`;
            btnNext.onclick   = () => stepNav(1);
        }
    }

    window.stepNav = function (dir) {
        if (dir === 1 && !validate(current)) return;
        const next = current + dir;
        if (next < 0 || next >= TOTAL) return;
        showStep(next, dir < 0);
    };

    function validate(n) {
        const reqs = required[n] || [];
        let ok = true;
        reqs.forEach(id => {
            const el = document.getElementById(id);
            if (!el || !el.value.trim()) {
                if (el) {
                    el.focus();
                    el.classList.add('is-invalid');
                    const field = el.closest('.ar-field');
                    if (field && !field.querySelector('.ar-field-error')) {
                        const msg       = document.createElement('span');
                        msg.className   = 'ar-field-error js-err';
                        msg.innerHTML   = `<svg viewBox="0 0 24 24" fill="currentColor" style="width:11px;height:11px"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V8h2v4z"/></svg> This field is required.`;
                        field.appendChild(msg);
                    }
                    setTimeout(() => {
                        el.classList.remove('is-invalid');
                        el.closest('.ar-field')?.querySelector('.js-err')?.remove();
                    }, 2800);
                }
                ok = false;
            }
        });
        return ok;
    }

    // Allow clicking already-completed sidebar steps to go back
    navItems.forEach((ni, i) => {
        ni.addEventListener('click', () => { if (i < current) showStep(i, true); });
    });

    // ── File upload handlers ─────────────────────────────────────────────────
    window.handlePhoto = function (input) {
        if (!input.files?.[0]) return;
        const file = input.files[0];
        document.getElementById('photo-name').textContent = file.name;
        document.getElementById('photo-picked').style.display = 'flex';
        const reader = new FileReader();
        reader.onload = e => {
            const img  = document.getElementById('photo-preview');
            const icon = document.getElementById('photo-icon');
            img.src            = e.target.result;
            img.style.display  = 'block';
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(file);
    };

    window.handleCred = function (input) {
        if (!input.files?.[0]) return;
        document.getElementById('cred-name').textContent          = input.files[0].name;
        document.getElementById('cred-placeholder').style.display = 'none';
        document.getElementById('cred-picked').style.display      = 'flex';
    };
})();

// ── Services / categories widget ─────────────────────────────────────────────
(function () {
    const catTriggers   = document.querySelectorAll('.cat-trigger');
    const serviceInputs = document.querySelectorAll('.service-check-input');
    const searchEl      = document.getElementById('serviceSearch');
    const panel         = document.getElementById('servicesPanel');
    const summaryEl     = document.getElementById('svcSummary');
    const countEl       = document.getElementById('svcCount');
    const clearBtn      = document.getElementById('clearServices');

    function syncGroups() {
        const checkedCats = [...catTriggers].filter(c => c.checked).map(c => c.dataset.catId);
        if (panel) panel.style.display = checkedCats.length > 0 ? 'block' : 'none';
        document.querySelectorAll('.svc-group').forEach(group => {
            const catId   = group.id.replace('group-', '');
            const visible = checkedCats.includes(catId);
            group.style.display = visible ? 'block' : 'none';
            if (!visible) group.querySelectorAll('.service-check-input').forEach(i => { i.checked = false; });
        });
        updateSummary();
    }

    function updateSummary() {
        const total = [...serviceInputs].filter(i => i.checked).length;
        catTriggers.forEach(cat => {
            const catId    = cat.dataset.catId;
            const badge    = document.getElementById('badge-' + catId);
            const catCount = [...serviceInputs].filter(i => i.checked && i.dataset.group === catId).length;
            if (badge) {
                badge.textContent   = catCount;
                badge.style.display = catCount > 0 ? 'inline-block' : 'none';
            }
        });
        if (summaryEl) {
            summaryEl.style.display = total > 0 ? 'flex' : 'none';
            if (countEl) countEl.textContent = total;
        }
    }

    catTriggers.forEach(cat => cat.addEventListener('change', syncGroups));
    serviceInputs.forEach(input => input.addEventListener('change', updateSummary));

    document.querySelectorAll('.svc-select-all').forEach(btn => {
        btn.addEventListener('click', () => {
            const groupId     = btn.dataset.group;
            const groupInputs = [...serviceInputs].filter(i => i.dataset.group === groupId);
            const allChecked  = groupInputs.every(i => i.checked);
            groupInputs.forEach(i => { i.checked = !allChecked; });
            btn.textContent = allChecked ? 'Select all' : 'Deselect all';
            updateSummary();
        });
    });

    searchEl?.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        serviceInputs.forEach(input => {
            const wrap = input.closest('.service-check');
            if (wrap) wrap.style.display = input.dataset.name.includes(q) ? '' : 'none';
        });
    });

    clearBtn?.addEventListener('click', () => {
        serviceInputs.forEach(i => { i.checked = false; });
        updateSummary();
    });

    // Restore checked state (from old() input) after a failed submit
    syncGroups();
})();
</script>

@endsection