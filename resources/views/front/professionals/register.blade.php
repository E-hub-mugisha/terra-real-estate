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
    --r:       12px;
    --t:       .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; min-height: 100vh; }
a { text-decoration: none; color: inherit; }

/* ── Page split ── */
.ar-page { min-height: 100vh; display: grid; grid-template-columns: 340px 1fr; }
@media (max-width: 860px) { .ar-page { grid-template-columns: 1fr; } }

/* ══ LEFT PANEL ══ */
.ar-left {
    background: #19265d;
    position: relative; overflow: hidden;
    display: flex; flex-direction: column;
    justify-content: space-between;
    padding: 44px 36px;
    min-height: 100vh;
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
    padding: 28px 0;
}
.ar-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .68rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 14px;
}
.ar-eyebrow::before { content: ''; width: 18px; height: 1px; background: var(--gold); opacity: .55; }
.ar-hero-text h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.6rem, 2.6vw, 2.2rem);
    font-weight: 500; line-height: 1.18;
    letter-spacing: -.02em; color: #F0EDE8; margin-bottom: 14px;
}
.ar-hero-text h1 em { font-style: italic; color: var(--gold); }
.ar-hero-text p { font-size: .82rem; color: rgba(240,237,232,.45); line-height: 1.7; }

/* Sidebar step nav */
.ar-steps-nav { position: relative; z-index: 2; display: flex; flex-direction: column; gap: 0; }
.ar-step-nav-item {
    display: flex; align-items: flex-start; gap: 13px;
    padding: 11px 0; cursor: pointer; position: relative;
}
.ar-step-nav-item:not(:last-child)::after {
    content: ''; position: absolute; left: 13px; top: 38px;
    width: 1px; height: calc(100% - 14px);
    background: rgba(255,255,255,.07);
}
.ar-step-nav-item.active:not(:last-child)::after { background: rgba(200,135,58,.28); }
.ar-step-nav-item.done:not(:last-child)::after   { background: rgba(200,135,58,.45); }

.step-nav-circle {
    width: 27px; height: 27px; border-radius: 50%;
    display: grid; place-items: center; flex-shrink: 0;
    font-size: .7rem; font-weight: 700;
    border: 1.5px solid rgba(255,255,255,.12);
    color: rgba(255,255,255,.3); transition: all var(--t);
    position: relative; z-index: 1;
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

/* ══ RIGHT PANEL ══ */
.ar-right {
    display: flex; flex-direction: column;
    justify-content: center; align-items: center;
    padding: 48px 40px; background: var(--bg);
}
@media (max-width: 600px) { .ar-right { padding: 28px 18px; } }

.ar-form-wrap { width: 100%; max-width: 560px; }

/* Progress bar */
.ar-progress-bar {
    height: 3px; background: var(--border); border-radius: 2px;
    margin-bottom: 26px; overflow: hidden;
}
.ar-progress-fill {
    height: 100%; background: var(--gold); border-radius: 2px;
    transition: width .45s cubic-bezier(.4,0,.2,1);
}

/* Step header */
.ar-step-header { margin-bottom: 22px; }
.ar-step-num { font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--gold); margin-bottom: 5px; }
.ar-step-header h2 { font-family: 'Cormorant Garamond', serif; font-size: 1.45rem; font-weight: 600; letter-spacing: -.02em; color: var(--text); margin: 0; }
.ar-step-header p { font-size: .81rem; color: var(--muted); margin-top: 4px; }

/* Errors */
.ar-errors { background: #fef2f2; border: 1px solid #fecaca; border-radius: var(--r); padding: 12px 16px; margin-bottom: 18px; }
.ar-errors ul { margin: 0; padding-left: 16px; }
.ar-errors li { font-size: .8rem; color: #dc2626; }

/* Steps */
.ar-step { display: none; animation: stepIn .32s cubic-bezier(.4,0,.2,1) both; }
.ar-step.active { display: block; }
@keyframes stepIn  { from { opacity:0; transform:translateX(24px);  } to { opacity:1; transform:none; } }
@keyframes stepBack { from { opacity:0; transform:translateX(-24px); } to { opacity:1; transform:none; } }
.ar-step.going-back { animation: stepBack .32s cubic-bezier(.4,0,.2,1) both; }

/* Fields */
.ar-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 13px; }
.ar-field:last-child { margin-bottom: 0; }
.ar-field label { font-size: .72rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
.ar-field label .req { color: #dc2626; margin-left: 2px; }
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

.ar-row { display: grid; grid-template-columns: 1fr 1fr; gap: 13px; }
.ar-row3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 13px; }
@media (max-width: 520px) { .ar-row, .ar-row3 { grid-template-columns: 1fr; } }

/* Upload zones */
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

/* Photo preview */
.photo-preview-img { width: 68px; height: 68px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold); margin: 0 auto 8px; display: none; }

/* Services */
.service-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 8px; }
.service-check { position: relative; }
.service-check input[type="checkbox"] { position: absolute; opacity: 0; width: 0; height: 0; }
.service-check label {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 12px; border-radius: 9px; border: 1.5px solid var(--border);
    background: var(--bg); cursor: pointer; font-size: .79rem;
    font-weight: 500; color: var(--muted);
    transition: all var(--t); text-transform: none; letter-spacing: 0;
}
.service-check label::before {
    content: ''; width: 15px; height: 15px; border-radius: 4px;
    border: 1.5px solid var(--border2); background: var(--surface);
    flex-shrink: 0; transition: all var(--t);
}
.service-check input:checked + label { border-color: var(--gold-bd); background: var(--gold-bg); color: var(--text); }
.service-check input:checked + label::before {
    background: var(--gold); border-color: var(--gold);
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M9 12l2 2 4-4'/%3E%3C/svg%3E");
    background-size: 13px; background-repeat: no-repeat; background-position: center;
}
.service-check label:hover { border-color: var(--gold-bd); background: var(--gold-bg); }

.svc-summary {
    display: flex; align-items: center; gap: 8px; margin-top: 12px;
    padding: 9px 13px; border-radius: 9px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    font-size: .78rem; color: var(--gold);
}
.svc-summary svg { width: 13px; height: 13px; flex-shrink: 0; }
.svc-clear { margin-left: auto; font-size: .72rem; font-weight: 600; color: #ef4444; background: none; border: none; cursor: pointer; padding: 0; font-family: 'DM Sans', sans-serif; }
.svc-clear:hover { text-decoration: underline; }

/* Password */
.ar-pw { position: relative; }
.ar-pw input { padding-right: 40px; }
.pw-toggle { position: absolute; right: 11px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--dim); padding: 0; transition: color var(--t); }
.pw-toggle:hover { color: var(--gold); }
.pw-toggle svg { width: 15px; height: 15px; display: block; }
.pw-strength { margin-top: 5px; }
.pw-strength-bar { height: 3px; background: var(--border); border-radius: 2px; overflow: hidden; margin-bottom: 3px; }
.pw-strength-fill { height: 100%; border-radius: 2px; transition: width .3s, background .3s; width: 0%; }
.pw-strength-label { font-size: .7rem; color: var(--dim); }

/* Toggle switch (for is_verified / send_credentials / auto_password) */
.ar-toggle-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 15px; border-radius: 10px;
    background: var(--bg); border: 1.5px solid var(--border);
    cursor: pointer; transition: border-color var(--t), background var(--t);
    margin-bottom: 10px;
}
.ar-toggle-row:hover, .ar-toggle-row.on { border-color: var(--gold-bd); background: var(--gold-bg); }
.ar-toggle-left { display: flex; align-items: center; gap: 10px; }
.ar-toggle-icon { width: 30px; height: 30px; border-radius: 8px; background: var(--surface); border: 1px solid var(--border); display: grid; place-items: center; }
.ar-toggle-icon svg { width: 13px; height: 13px; color: var(--gold); }
.ar-toggle-label { font-size: .83rem; font-weight: 600; color: var(--text); }
.ar-toggle-sub   { font-size: .71rem; color: var(--muted); margin-top: 1px; }
.ar-toggle-input { display: none; }
.ar-toggle-switch { width: 38px; height: 21px; border-radius: 11px; background: var(--border2); position: relative; transition: background var(--t); flex-shrink: 0; }
.ar-toggle-switch::after { content: ''; position: absolute; width: 15px; height: 15px; border-radius: 50%; background: #fff; top: 3px; left: 3px; transition: left var(--t); box-shadow: 0 1px 3px rgba(0,0,0,.2); }
.ar-toggle-row.on .ar-toggle-switch { background: var(--gold); }
.ar-toggle-row.on .ar-toggle-switch::after { left: 20px; }

/* Notice */
.ar-notice { display: flex; align-items: flex-start; gap: 9px; padding: 12px 14px; border-radius: var(--r); font-size: .78rem; line-height: 1.6; margin-bottom: 14px; }
.ar-notice.green { background: var(--green-bg); border: 1px solid var(--green-bd); color: var(--green); }
.ar-notice.gold  { background: var(--gold-bg);  border: 1px solid var(--gold-bd);  color: #7a4e12; }
.ar-notice svg { width: 14px; height: 14px; flex-shrink: 0; margin-top: 1px; }

/* Rating stars */
.star-rating { display: flex; gap: 6px; }
.star-rating span { font-size: 1.4rem; cursor: pointer; color: var(--border2); transition: color .15s; }
.star-rating span.on { color: var(--gold); }

/* Nav buttons */
.ar-nav { display: flex; align-items: center; gap: 10px; margin-top: 22px; }
.ar-btn-back { padding: 10px 20px; border-radius: 9px; border: 1.5px solid var(--border2); background: var(--surface); font-size: .82rem; font-weight: 500; color: var(--muted); font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all var(--t); display: none; }
.ar-btn-back:hover { border-color: var(--gold); color: var(--gold); }
.ar-btn-next { flex: 1; padding: 11px 20px; border-radius: 9px; background: var(--gold); border: none; color: #fff; font-size: .84rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background var(--t), transform var(--t); display: flex; align-items: center; justify-content: center; gap: 7px; }
.ar-btn-next:hover { background: #a06828; transform: translateY(-1px); }
.ar-btn-next svg { width: 15px; height: 15px; }

.svc-search-wrap { position: relative; margin-bottom: 14px; }
.svc-search-wrap svg { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); width: 13px; height: 13px; color: var(--dim); }
.svc-search { width: 100%; padding: 9px 12px 9px 33px; border: 1.5px solid var(--border); border-radius: 9px; background: var(--bg); color: var(--text); font-size: .82rem; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color var(--t); }
.svc-search:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200,135,58,.1); background: var(--surface); }
</style>

<div class="ar-page">

    {{-- ══ LEFT ══ --}}
    <aside class="ar-left">
        <div class="ar-logo">
            <div class="ar-logo-dot"></div>
            Terra
        </div>

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
            <div class="ar-step-nav-item" data-step="3">
                <div class="step-nav-circle">4</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Account & Security</div>
                    <div class="step-nav-sub">Password &amp; settings</div>
                </div>
            </div>
        </nav>
    </aside>

    {{-- ══ RIGHT ══ --}}
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

            <input type="hidden" id="initial-step" value="{{ $errors->any() ? old('_step', 0) : 0 }}">

            <form method="POST"
                  action="{{ route('front.professionals.register.store') }}"
                  enctype="multipart/form-data"
                  id="pro-form">
                @csrf
                <input type="hidden" name="_step" id="form-step-field" value="0">

                {{-- ══ STEP 1: PERSONAL ══ --}}
                <div class="ar-step active" id="step-0">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 1 of 4</div>
                        <h2>Personal Information</h2>
                        <p>Basic contact details for the professional.</p>
                    </div>

                    <div class="ar-field">
                        <label>Full Name <span class="req">*</span></label>
                        <input type="text" name="full_name" id="f_name"
                               value="{{ old('full_name') }}"
                               placeholder="e.g. Jean-Paul Habimana" required>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Email Address <span class="req">*</span></label>
                            <input type="email" name="email" id="f_email"
                                   value="{{ old('email') }}"
                                   placeholder="pro@email.com" required>
                        </div>
                        <div class="ar-field">
                            <label>Phone Number <span class="req">*</span></label>
                            <input type="tel" name="phone" id="f_phone"
                                   value="{{ old('phone') }}"
                                   placeholder="+250 7XX XXX XXX" required>
                        </div>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>WhatsApp</label>
                            <input type="tel" name="whatsapp"
                                   value="{{ old('whatsapp') }}"
                                   placeholder="+250 7XX XXX XXX">
                        </div>
                        <div class="ar-field">
                            <label>Office Location</label>
                            <input type="text" name="office_location"
                                   value="{{ old('office_location') }}"
                                   placeholder="e.g. Kigali, Nyarugenge">
                        </div>
                    </div>

                    <div class="ar-field">
                        <label>Languages Spoken</label>
                        <input type="text" name="languages"
                               value="{{ old('languages') }}"
                               placeholder="e.g. Kinyarwanda, English, French">
                        <span class="hint">Separate multiple languages with commas.</span>
                    </div>
                </div>

                {{-- ══ STEP 2: PROFESSIONAL ══ --}}
                <div class="ar-step" id="step-1">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 2 of 4</div>
                        <h2>Professional Details</h2>
                        <p>Credentials, experience, and public profile information.</p>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Profession / Title <span class="req">*</span></label>
                            <input type="text" name="profession" id="f_profession"
                                   value="{{ old('profession') }}"
                                   placeholder="e.g. Architect, Civil Engineer" required>
                        </div>
                        <div class="ar-field">
                            <label>License Number</label>
                            <input type="text" name="license_number"
                                   value="{{ old('license_number') }}"
                                   placeholder="e.g. RW-ARCH-0042">
                        </div>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Years of Experience</label>
                            <input type="number" name="years_experience"
                                   value="{{ old('years_experience') }}"
                                   min="0" max="60" placeholder="e.g. 8">
                        </div>
                        <div class="ar-field">
                            <label>Initial Rating</label>
                            <input type="number" name="rating"
                                   id="f_rating"
                                   value="{{ old('rating', '') }}"
                                   min="0" max="5" step="0.1"
                                   placeholder="0.0 – 5.0">
                            <span class="hint">Leave blank to start unrated.</span>
                        </div>
                    </div>

                    <div class="ar-field">
                        <label>Bio <span class="req">*</span></label>
                        <textarea name="bio" id="f_bio" rows="4" required
                                  placeholder="Describe their background, expertise, and specialisations…">{{ old('bio') }}</textarea>
                        <span class="hint">Displayed on their public Terra profile.</span>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Website</label>
                            <input type="url" name="website"
                                   value="{{ old('website') }}"
                                   placeholder="https://theirsite.com">
                        </div>
                        <div class="ar-field">
                            <label>Portfolio URL</label>
                            <input type="url" name="portfolio_url"
                                   value="{{ old('portfolio_url') }}"
                                   placeholder="https://behance.net/…">
                        </div>
                    </div>

                    <div class="ar-field">
                        <label>LinkedIn</label>
                        <input type="url" name="linkedin"
                               value="{{ old('linkedin') }}"
                               placeholder="https://linkedin.com/in/…">
                    </div>

                    {{-- Profile photo --}}
                    <div class="ar-field" style="margin-top:4px">
                        <label>Profile Photo</label>
                        <div class="ar-upload-zone" id="photo-zone">
                            <input type="file" name="profile_image" accept=".jpg,.jpeg,.png,.webp"
                                   onchange="handlePhoto(this)">
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
                    </div>

                    {{-- Credentials doc --}}
                    <div class="ar-field">
                        <label>Credentials Document</label>
                        <div class="ar-upload-zone" id="cred-zone">
                            <input type="file" name="credentials_doc" accept=".pdf,.jpg,.jpeg,.png"
                                   onchange="handleCred(this)">
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
                    </div>
                </div>

                {{-- ══ STEP 3: SERVICES ══ --}}
                <div class="ar-step" id="step-2">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 3 of 4</div>
                        <h2>Services Offered</h2>
                        <p>Select the services this professional provides.</p>
                    </div>

                    @if(isset($services) && $services->count())

                        <div class="svc-search-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                            </svg>
                            <input type="text" id="svc-search" class="svc-search" placeholder="Filter services…">
                        </div>

                        <div class="service-grid" id="svc-grid">
                            @foreach($services as $svc)
                            <div class="service-check svc-item" data-name="{{ strtolower($svc->title) }}">
                                <input type="checkbox"
                                       name="services[]"
                                       value="{{ $svc->id }}"
                                       id="svc{{ $svc->id }}"
                                       class="svc-check-input"
                                       {{ in_array($svc->id, old('services', [])) ? 'checked' : '' }}>
                                <label for="svc{{ $svc->id }}">{{ $svc->title }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div id="svc-summary" class="svc-summary" style="display:none">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                            <span><strong id="svc-count">0</strong> service(s) selected</span>
                            <button type="button" id="svc-clear" class="svc-clear">Clear all</button>
                        </div>

                    @else
                        <div style="text-align:center;padding:32px 0">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:36px;height:36px;color:var(--dim);margin:0 auto 10px;display:block">
                                <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <p style="font-size:.82rem;color:var(--dim)">No services configured yet. You can assign services later.</p>
                        </div>
                    @endif

                    <p style="font-size:.72rem;color:var(--dim);margin-top:14px">
                        Services can be updated at any time from the professional's profile.
                    </p>
                </div>

                {{-- ══ STEP 4: ACCOUNT ══ --}}
                <div class="ar-step" id="step-3">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 4 of 4</div>
                        <h2>Account &amp; Security</h2>
                        <p>Configure login credentials and account settings.</p>
                    </div>

                    {{-- Auto password toggle --}}
                    <div class="ar-toggle-row" id="auto-pw-row" onclick="toggleSwitch('auto-pw-row','auto_password','auto-pw-check','autoPassGroup',true)">
                        <div class="ar-toggle-left">
                            <div class="ar-toggle-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                            </div>
                            <div>
                                <div class="ar-toggle-label">Auto-generate password</div>
                                <div class="ar-toggle-sub">System creates a secure random password</div>
                            </div>
                        </div>
                        <input type="checkbox" name="auto_password" id="auto-pw-check" class="ar-toggle-input" value="1" checked>
                        <div class="ar-toggle-switch"></div>
                    </div>

                    {{-- Custom password (shown when auto is off) --}}
                    <div id="autoPassGroup" style="display:none">
                        <div class="ar-field">
                            <label>Custom Password <span class="req">*</span></label>
                            <div class="ar-pw">
                                <input type="password" name="custom_password" id="f_password"
                                       placeholder="Minimum 8 characters"
                                       oninput="checkStrength(this.value)">
                                <button type="button" class="pw-toggle" onclick="togglePw('f_password',this)">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="pw-strength">
                                <div class="pw-strength-bar"><div class="pw-strength-fill" id="pw-bar"></div></div>
                                <span class="pw-strength-label" id="pw-label">Enter a password</span>
                            </div>
                        </div>
                    </div>

                    {{-- Send credentials toggle --}}
                    <div class="ar-toggle-row on" id="send-cred-row" onclick="toggleSwitch('send-cred-row','send_credentials','send-cred-check')">
                        <div class="ar-toggle-left">
                            <div class="ar-toggle-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                            </div>
                            <div>
                                <div class="ar-toggle-label">Email login credentials</div>
                                <div class="ar-toggle-sub">Send password to the professional by email</div>
                            </div>
                        </div>
                        <input type="checkbox" name="send_credentials" id="send-cred-check" class="ar-toggle-input" value="1" checked>
                        <div class="ar-toggle-switch"></div>
                    </div>

                    {{-- Verified toggle --}}
                    <div class="ar-toggle-row" id="verified-row" onclick="toggleSwitch('verified-row','is_verified','verified-check')">
                        <div class="ar-toggle-left">
                            <div class="ar-toggle-icon">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <div class="ar-toggle-label">Mark as verified</div>
                                <div class="ar-toggle-sub">Skip email verification — activate immediately</div>
                            </div>
                        </div>
                        <input type="checkbox" name="is_verified" id="verified-check" class="ar-toggle-input" value="1"
                               {{ old('is_verified') ? 'checked' : '' }}>
                        <div class="ar-toggle-switch"></div>
                    </div>

                    <div class="ar-notice green" style="margin-top:16px">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>After creation, the professional can log in and update their own profile. Admins can manage their account from the professionals panel.</span>
                    </div>

                    <div class="ar-notice gold">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-2h2v2zm0-4H11V8h2v4z"/></svg>
                        <span>The account will be created with role <strong>professional</strong>. Terra admins control verification and listing approval.</span>
                    </div>
                </div>

                {{-- Navigation --}}
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

<script>
(function () {
    let current = 0;
    const TOTAL = 4;

    const steps      = document.querySelectorAll('.ar-step');
    const navItems   = document.querySelectorAll('.ar-step-nav-item');
    const progFill   = document.getElementById('progress-fill');
    const btnBack    = document.getElementById('btn-back');
    const btnNext    = document.getElementById('btn-next');
    const stepField  = document.getElementById('form-step-field');

    // Required field IDs per step
    const required = {
        0: ['f_name', 'f_email', 'f_phone'],
        1: ['f_profession', 'f_bio'],
        2: [],
        3: [],
    };

    // Restore step after validation failure
    const init = parseInt(document.getElementById('initial-step').value, 10) || 0;
    showStep(init, false);

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

        progFill.style.width = ((n + 1) / TOTAL * 100) + '%';
        btnBack.style.display = n === 0 ? 'none' : 'inline-block';
        stepField.value = n;
        current = n;

        if (n === TOTAL - 1) {
            btnNext.innerHTML = `
                <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14l-4-4 1.41-1.41L11 13.17l6.59-6.59L19 8l-8 8z"/></svg>
                Create Professional`;
            btnNext.onclick = () => {
                if (validate(current)) document.getElementById('pro-form').submit();
            };
        } else {
            btnNext.innerHTML = `Continue <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"/></svg>`;
            btnNext.onclick = () => stepNav(1);
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
                    el.style.borderColor = '#dc2626';
                    el.style.boxShadow   = '0 0 0 3px rgba(220,38,38,.12)';
                    setTimeout(() => { el.style.borderColor = ''; el.style.boxShadow = ''; }, 2200);
                }
                ok = false;
            }
        });
        return ok;
    }

    // Sidebar click to go back
    navItems.forEach((ni, i) => {
        ni.addEventListener('click', () => { if (i < current) showStep(i, true); });
    });

    /* ── File handlers ── */
    window.handlePhoto = function (input) {
        if (!input.files?.[0]) return;
        const file = input.files[0];
        document.getElementById('photo-name').textContent = file.name;
        document.getElementById('photo-picked').style.display = 'flex';
        const reader = new FileReader();
        reader.onload = e => {
            const img  = document.getElementById('photo-preview');
            const icon = document.getElementById('photo-icon');
            img.src = e.target.result;
            img.style.display = 'block';
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(file);
    };

    window.handleCred = function (input) {
        if (!input.files?.[0]) return;
        document.getElementById('cred-name').textContent     = input.files[0].name;
        document.getElementById('cred-placeholder').style.display = 'none';
        document.getElementById('cred-picked').style.display  = 'flex';
    };

    /* ── Toggle switch ── */
    window.toggleSwitch = function (rowId, name, checkId, showGroup, invert) {
        const row   = document.getElementById(rowId);
        const check = document.getElementById(checkId);
        check.checked = !check.checked;
        row.classList.toggle('on', check.checked);
        if (showGroup) {
            const grp = document.getElementById(showGroup);
            if (grp) grp.style.display = (invert ? !check.checked : check.checked) ? 'block' : 'none';
        }
    };

    // Init verified row state from old()
    if (document.getElementById('verified-check').checked) {
        document.getElementById('verified-row').classList.add('on');
    }
    // Auto-pw row: default checked, so group hidden
    document.getElementById('auto-pw-row').classList.add('on');

    /* ── Password visibility ── */
    window.togglePw = function (id, btn) {
        const el = document.getElementById(id);
        el.type = el.type === 'text' ? 'password' : 'text';
        btn.querySelector('svg').style.opacity = el.type === 'text' ? '.45' : '1';
    };

    /* ── Password strength ── */
    window.checkStrength = function (val) {
        const bar   = document.getElementById('pw-bar');
        const label = document.getElementById('pw-label');
        let score = 0;
        if (val.length >= 8)          score++;
        if (/[A-Z]/.test(val))        score++;
        if (/[0-9]/.test(val))        score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;
        const lvl = [
            { w:'0%',   bg:'transparent', txt:'Enter a password' },
            { w:'25%',  bg:'#ef4444',     txt:'Weak' },
            { w:'50%',  bg:'#f97316',     txt:'Fair' },
            { w:'75%',  bg:'#eab308',     txt:'Good' },
            { w:'100%', bg:'#22c55e',     txt:'Strong' },
        ][val.length === 0 ? 0 : score] || { w:'25%', bg:'#ef4444', txt:'Weak' };
        bar.style.width      = lvl.w;
        bar.style.background = lvl.bg;
        label.textContent    = lvl.txt;
        label.style.color    = lvl.bg === 'transparent' ? 'var(--dim)' : lvl.bg;
    };

})();

/* ── Services filter + summary ── */
(function () {
    const inputs = document.querySelectorAll('.svc-check-input');
    const search = document.getElementById('svc-search');

    function updateSummary() {
        const n = document.querySelectorAll('.svc-check-input:checked').length;
        const s = document.getElementById('svc-summary');
        if (s) { s.style.display = n > 0 ? 'flex' : 'none'; document.getElementById('svc-count').textContent = n; }
    }

    inputs.forEach(i => i.addEventListener('change', updateSummary));

    search?.addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('.svc-item').forEach(item => {
            item.style.display = item.dataset.name.includes(q) ? '' : 'none';
        });
    });

    document.getElementById('svc-clear')?.addEventListener('click', () => {
        inputs.forEach(i => i.checked = false);
        updateSummary();
    });

    updateSummary();
})();
</script>

@endsection