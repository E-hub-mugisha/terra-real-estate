@extends('layouts.base')
@section('title', 'Become a Terra Agent')
@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --bg: #F7F5F2;
        --surface: #FFFFFF;
        --border: rgba(0, 0, 0, .08);
        --border2: rgba(0, 0, 0, .15);
        --gold: #D05208;
        --gold-bg: rgba(200, 135, 58, .07);
        --gold-bd: rgba(200, 135, 58, .22);
        --text: #19265d;
        --muted: #6B6560;
        --dim: #9E9890;
        --green: #1E7A5A;
        --r: 12px;
        --t: .22s cubic-bezier(.4, 0, .2, 1);
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: var(--bg);
        color: var(--text);
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    /* ── Page split ── */
    .ar-page {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 380px 1fr;
    }

    @media (max-width: 860px) {
        .ar-page {
            grid-template-columns: 1fr;
        }
    }

    /* ══════════════════════════════
   LEFT PANEL
══════════════════════════════ */
    .ar-left {
        background: #19265d;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 44px 40px;
        min-height: 100vh;
    }

    .ar-left::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 70% 50% at 30% 20%, rgba(200, 135, 58, .18) 0%, transparent 60%),
            radial-gradient(ellipse 50% 40% at 80% 80%, rgba(200, 135, 58, .08) 0%, transparent 60%);
        pointer-events: none;
    }

    .ar-left::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255, 255, 255, .02) 39px, rgba(255, 255, 255, .02) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 39px, rgba(255, 255, 255, .02) 39px, rgba(255, 255, 255, .02) 40px);
        pointer-events: none;
    }

    @media (max-width: 860px) {
        .ar-left {
            min-height: auto;
            padding: 32px 24px;
        }
    }

    .ar-logo {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        font-weight: 600;
        color: #F0EDE8;
        letter-spacing: -.01em;
    }

    .ar-logo-dot {
        width: 8px;
        height: 8px;
        background: var(--gold);
        border-radius: 50%;
    }

    .ar-hero-text {
        position: relative;
        z-index: 2;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 32px 0;
    }

    .ar-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 16px;
    }

    .ar-eyebrow::before {
        content: '';
        width: 20px;
        height: 1px;
        background: var(--gold);
        opacity: .6;
    }

    .ar-hero-text h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3vw, 2.6rem);
        font-weight: 500;
        line-height: 1.15;
        letter-spacing: -.02em;
        color: #F0EDE8;
        margin-bottom: 16px;
    }

    .ar-hero-text h1 em {
        font-style: italic;
        color: var(--gold);
    }

    .ar-hero-text p {
        font-size: .83rem;
        color: rgba(240, 237, 232, .5);
        line-height: 1.7;
    }

    /* Step navigation sidebar */
    .ar-steps-nav {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .ar-step-nav-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 12px 0;
        cursor: pointer;
        position: relative;
    }

    .ar-step-nav-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 14px;
        top: 40px;
        width: 1px;
        height: calc(100% - 16px);
        background: rgba(255, 255, 255, .08);
    }

    .ar-step-nav-item.active:not(:last-child)::after {
        background: rgba(200, 135, 58, .3);
    }

    .ar-step-nav-item.done:not(:last-child)::after {
        background: rgba(200, 135, 58, .5);
    }

    .step-nav-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        font-size: .72rem;
        font-weight: 700;
        border: 1.5px solid rgba(255, 255, 255, .15);
        color: rgba(255, 255, 255, .35);
        transition: all var(--t);
        position: relative;
        z-index: 1;
    }

    .ar-step-nav-item.active .step-nav-circle {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
        box-shadow: 0 0 0 4px rgba(200, 135, 58, .2);
    }

    .ar-step-nav-item.done .step-nav-circle {
        background: rgba(30, 122, 90, .8);
        border-color: var(--green);
        color: #fff;
    }

    .step-nav-circle svg {
        width: 13px;
        height: 13px;
    }

    .step-nav-label {
        padding-top: 4px;
    }

    .step-nav-title {
        font-size: .8rem;
        font-weight: 600;
        color: rgba(255, 255, 255, .35);
        transition: color var(--t);
    }

    .ar-step-nav-item.active .step-nav-title {
        color: #F0EDE8;
    }

    .ar-step-nav-item.done .step-nav-title {
        color: rgba(240, 237, 232, .6);
    }

    .step-nav-sub {
        font-size: .7rem;
        color: rgba(255, 255, 255, .2);
        margin-top: 1px;
    }

    .ar-step-nav-item.active .step-nav-sub {
        color: rgba(200, 135, 58, .7);
    }

    /* ══════════════════════════════
   RIGHT PANEL
══════════════════════════════ */
    .ar-right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 48px 40px;
        background: var(--bg);
        overflow: hidden;
    }

    @media (max-width: 600px) {
        .ar-right {
            padding: 32px 20px;
        }
    }

    .ar-form-wrap {
        width: 100%;
        max-width: 520px;
    }

    /* Progress bar */
    .ar-progress-bar {
        height: 3px;
        background: var(--border);
        border-radius: 2px;
        margin-bottom: 28px;
        overflow: hidden;
    }

    .ar-progress-fill {
        height: 100%;
        background: var(--gold);
        border-radius: 2px;
        transition: width .5s cubic-bezier(.4, 0, .2, 1);
    }

    /* Step header */
    .ar-step-header {
        margin-bottom: 24px;
    }

    .ar-step-num {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 6px;
    }

    .ar-step-header h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 600;
        letter-spacing: -.02em;
        color: var(--text);
        margin: 0;
    }

    .ar-step-header p {
        font-size: .82rem;
        color: var(--muted);
        margin-top: 4px;
    }

    /* Validation errors */
    .ar-errors {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: var(--r);
        padding: 12px 16px;
        margin-bottom: 20px;
    }

    .ar-errors ul {
        margin: 0;
        padding-left: 16px;
    }

    .ar-errors li {
        font-size: .8rem;
        color: #dc2626;
    }

    /* Step panels */
    .ar-step {
        display: none;
        animation: stepIn .35s cubic-bezier(.4, 0, .2, 1) both;
    }

    .ar-step.active {
        display: block;
    }

    @keyframes stepIn {
        from {
            opacity: 0;
            transform: translateX(28px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes stepBack {
        from {
            opacity: 0;
            transform: translateX(-28px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .ar-step.going-back {
        animation: stepBack .35s cubic-bezier(.4, 0, .2, 1) both;
    }

    /* Fields */
    .ar-field {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 14px;
    }

    .ar-field:last-child {
        margin-bottom: 0;
    }

    .ar-field label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: var(--muted);
    }

    .ar-field label .req {
        color: #dc2626;
        margin-left: 2px;
    }

    .ar-field input,
    .ar-field textarea,
    .ar-field select {
        padding: 10px 13px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: .84rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text);
        transition: border-color var(--t), box-shadow var(--t), background var(--t);
        width: 100%;
    }

    .ar-field input::placeholder,
    .ar-field textarea::placeholder {
        color: var(--dim);
    }

    .ar-field input:focus,
    .ar-field textarea:focus,
    .ar-field select:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(200, 135, 58, .1);
        background: var(--surface);
    }

    .ar-field textarea {
        resize: vertical;
        min-height: 90px;
    }

    .ar-field .hint {
        font-size: .71rem;
        color: var(--dim);
    }

    .ar-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 480px) {
        .ar-row {
            grid-template-columns: 1fr;
        }
    }

    /* Social icon inputs */
    .ar-si {
        position: relative;
    }

    .ar-si svg.si-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        width: 14px;
        height: 14px;
        color: var(--dim);
        pointer-events: none;
    }

    .ar-si input {
        padding-left: 32px;
    }

    /* Avatar upload */
    .ar-avatar-upload {
        border: 2px dashed var(--border2);
        border-radius: var(--r);
        padding: 32px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color var(--t), background var(--t);
        background: var(--bg);
        position: relative;
        overflow: hidden;
    }

    .ar-avatar-upload:hover {
        border-color: var(--gold);
        background: var(--gold-bg);
    }

    .ar-avatar-upload input {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .ar-avatar-upload svg {
        width: 32px;
        height: 32px;
        color: var(--dim);
        margin-bottom: 10px;
    }

    .ar-avatar-upload .au-title {
        font-size: .83rem;
        color: var(--muted);
        font-weight: 500;
    }

    .ar-avatar-upload .au-sub {
        font-size: .72rem;
        color: var(--dim);
        margin-top: 3px;
    }

    .au-preview {
        display: none;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .au-preview img {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--gold);
    }

    .au-preview span {
        font-size: .78rem;
        color: var(--green);
        font-weight: 500;
    }

    /* Notice */
    .ar-notice {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        border-radius: var(--r);
        background: rgba(30, 122, 90, .06);
        border: 1px solid rgba(30, 122, 90, .18);
        font-size: .8rem;
        color: var(--green);
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .ar-notice svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    /* Nav buttons */
    .ar-nav {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 24px;
    }

    .ar-btn-back {
        padding: 10px 20px;
        border-radius: 9px;
        border: 1.5px solid var(--border2);
        background: var(--surface);
        font-size: .83rem;
        font-weight: 500;
        color: var(--muted);
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: all var(--t);
        display: none;
    }

    .ar-btn-back:hover {
        border-color: var(--gold);
        color: var(--gold);
    }

    .ar-btn-next {
        flex: 1;
        padding: 11px 20px;
        border-radius: 9px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .85rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        transition: background var(--t), transform var(--t);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .ar-btn-next:hover {
        background: #a06828;
        transform: translateY(-1px);
    }

    .ar-btn-next svg {
        width: 15px;
        height: 15px;
    }

    .ar-login-link {
        text-align: center;
        font-size: .78rem;
        color: var(--muted);
        margin-top: 16px;
    }

    .ar-login-link a {
        color: var(--gold);
        font-weight: 500;
    }
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
            <h1>Become a<br><em>Terra Agent</em></h1>
            <p>Join hundreds of verified professionals helping clients find their perfect property across Rwanda.</p>
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
                    <div class="step-nav-sub">Experience &amp; bio</div>
                </div>
            </div>
            <div class="ar-step-nav-item" data-step="2">
                <div class="step-nav-circle">3</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Social Media</div>
                    <div class="step-nav-sub">LinkedIn, Facebook…</div>
                </div>
            </div>
            <div class="ar-step-nav-item" data-step="3">
                <div class="step-nav-circle">4</div>
                <div class="step-nav-label">
                    <div class="step-nav-title">Final Details</div>
                    <div class="step-nav-sub">Photo &amp; location</div>
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

            <form method="POST" action="{{ route('front.agents.register.store') }}"
                enctype="multipart/form-data" id="agent-form">
                @csrf

                {{-- ══ STEP 1: PERSONAL ══ --}}
                <div class="ar-step active" id="step-0">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 1 of 4</div>
                        <h2>Personal Information</h2>
                        <p>Let's start with the basics.</p>
                    </div>

                    <div class="ar-field">
                        <label>Full Name <span class="req">*</span></label>
                        <input type="text" name="full_name" id="f_full_name"
                            value="{{ old('full_name') }}"
                            placeholder="e.g. Amina Uwimana" required>
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
                </div>

                {{-- ══ STEP 2: PROFESSIONAL ══ --}}
                <div class="ar-step" id="step-1">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 2 of 4</div>
                        <h2>Professional Profile</h2>
                        <p>Tell clients about your expertise.</p>
                    </div>

                    <div class="ar-field">
                        <label>Languages Spoken</label>
                        <input type="text" name="languages"
                            value="{{ old('languages') }}"
                            placeholder="Kinyarwanda, English…">
                    </div>
                    <div class="ar-field">
                        <label>Bio / About You <span class="req">*</span></label>
                        <textarea name="bio" id="f_bio" rows="4"
                            placeholder="Describe your experience, background, and what makes you stand out…">{{ old('bio') }}</textarea>
                        <span class="hint">This appears on your public profile.</span>
                    </div>
                </div>

                {{-- ══ STEP 3: SOCIAL ══ --}}
                <div class="ar-step" id="step-2">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 3 of 4</div>
                        <h2>Social Media</h2>
                        <p>Optional — helps clients connect with you.</p>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>LinkedIn</label>
                            <div class="ar-si">
                                <svg class="si-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" />
                                    <circle cx="4" cy="4" r="2" />
                                </svg>
                                <input type="url" name="linkedin"
                                    value="{{ old('linkedin') }}"
                                    placeholder="linkedin.com/in/…">
                            </div>
                        </div>
                        <div class="ar-field">
                            <label>Facebook</label>
                            <div class="ar-si">
                                <svg class="si-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                                </svg>
                                <input type="url" name="facebook"
                                    value="{{ old('facebook') }}"
                                    placeholder="facebook.com/…">
                            </div>
                        </div>
                    </div>
                    <div class="ar-row">
                        <div class="ar-field">
                            <label>Instagram</label>
                            <div class="ar-si">
                                <svg class="si-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="2" y="2" width="20" height="20" rx="5" />
                                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" />
                                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                                </svg>
                                <input type="url" name="instagram"
                                    value="{{ old('instagram') }}"
                                    placeholder="instagram.com/…">
                            </div>
                        </div>
                        <div class="ar-field">
                            <label>Twitter / X</label>
                            <div class="ar-si">
                                <svg class="si-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                                <input type="url" name="twitter"
                                    value="{{ old('twitter') }}"
                                    placeholder="x.com/…">
                            </div>
                        </div>
                    </div>
                    <p style="font-size:.75rem;color:var(--dim);text-align:center;margin-top:4px">
                        All social fields are optional. You can skip this step.
                    </p>
                </div>

                {{-- ══ STEP 4: FINAL ══ --}}
                <div class="ar-step" id="step-3">
                    <div class="ar-step-header">
                        <div class="ar-step-num">Step 4 of 4</div>
                        <h2>Final Details</h2>
                        <p>Almost done — just a few more things.</p>
                    </div>

                    <div class="ar-field" style="margin-bottom:14px">
                        <label>Profile Photo</label>
                        <div class="ar-avatar-upload">
                            <input type="file" name="profile_image"
                                accept="image/*"
                                onchange="previewAvatar(this)">
                            <div id="au-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" />
                                </svg>
                                <p class="au-title">Click to upload your profile photo</p>
                                <p class="au-sub">JPG, PNG or WEBP — Max 2MB</p>
                            </div>
                            <div class="au-preview" id="au-preview">
                                <img id="au-preview-img" src="" alt="preview">
                                <span>Photo selected ✓</span>
                            </div>
                        </div>
                    </div>

                    <div class="ar-row">
                        <div class="ar-field">
                            <label>WhatsApp Number</label>
                            <input type="tel" name="whatsapp"
                                value="{{ old('whatsapp') }}"
                                placeholder="+250 7XX XXX XXX">
                        </div>

                        <div class="ar-field">
                            <label>Office Location</label>
                            <input type="text" name="office_location"
                                value="{{ old('office_location') }}"
                                placeholder="Kigali, Rwanda">
                        </div>
                    </div>

                    <div class="ar-notice">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
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
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 13H4V11H12V4L20 12L12 20V13Z" />
                        </svg>
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
    (function() {
        let current = 0;
        const TOTAL = 4;

        const steps = document.querySelectorAll('.ar-step');
        const navItems = document.querySelectorAll('.ar-step-nav-item');
        const progressFill = document.getElementById('progress-fill');
        const btnBack = document.getElementById('btn-back');
        const btnNext = document.getElementById('btn-next');

        /* Required field IDs per step */
        const required = {
            0: ['f_full_name', 'f_email', 'f_phone'],
            1: ['f_bio'],
            2: [],
            3: [],
        };

        showStep(0, false);

        /* ── Show step ── */
        function showStep(n, back) {
            steps.forEach(s => s.classList.remove('active', 'going-back'));
            navItems.forEach((ni, i) => {
                ni.classList.remove('active', 'done');
                if (i < n) ni.classList.add('done');
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

            if (n === TOTAL - 1) {
                btnNext.innerHTML = `<svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14l-4-4 1.41-1.41L11 13.17l6.59-6.59L19 8l-8 8z"/></svg> Submit Application`;
                btnNext.onclick = () => document.getElementById('agent-form').submit();
            } else {
                btnNext.innerHTML = `Continue <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"/></svg>`;
                btnNext.onclick = () => stepNav(1);
            }

            current = n;
        }

        /* ── Navigate ── */
        window.stepNav = function(dir) {
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
                        el.style.boxShadow = '0 0 0 3px rgba(220,38,38,.12)';
                        setTimeout(() => {
                            el.style.borderColor = '';
                            el.style.boxShadow = '';
                        }, 2000);
                    }
                    ok = false;
                }
            });
            return ok;
        }

        /* ── Sidebar nav — click to go back ── */
        navItems.forEach((ni, i) => {
            ni.addEventListener('click', () => {
                if (i < current) showStep(i, true);
            });
        });

        /* ── Avatar preview ── */
        window.previewAvatar = function(input) {
            if (!input.files || !input.files[0]) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('au-preview-img').src = e.target.result;
                document.getElementById('au-placeholder').style.display = 'none';
                document.getElementById('au-preview').style.display = 'flex';
            };
            reader.readAsDataURL(input.files[0]);
        };

    })();
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ── Auto-jump to the step that contains the first errored field ──
    @if ($errors->any())
    (function () {
        // Map field names to their step index
        const fieldStepMap = {
            full_name: 0, email: 0, phone: 0,
            bio: 1, languages: 1,
            linkedin: 2, facebook: 2, instagram: 2, twitter: 2,
            profile_image: 3, whatsapp: 3, office_location: 3,
        };

        const errorFields = @json(array_keys($errors->messages()));
        let targetStep = 0;

        for (const field of errorFields) {
            if (fieldStepMap[field] !== undefined) {
                targetStep = fieldStepMap[field];
                break;
            }
        }

        // Jump the multi-step form to the correct step
        if (typeof showStep === 'function') {
            showStep(targetStep, false);
        } else {
            // showStep is defined inside an IIFE so we expose it below
            window.__initialStep = targetStep;
        }
    })();
    @endif
</script>

{{-- Single consolidated SweetAlert ── --}}
@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Application Submitted',
        text: @json(session('success')),
        confirmButtonColor: '#1E7A5A',
        confirmButtonText: 'Continue',
    });
</script>

@elseif (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Something went wrong',
        text: @json(session('error')),
        confirmButtonColor: '#dc2626',
    });
</script>

@elseif ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Please fix the following',
        html: `{!! implode('<br>', array_map('e', $errors->all())) !!}`,
        confirmButtonColor: '#D05208',
        confirmButtonText: 'Got it',
    });
</script>
@endif
@endsection