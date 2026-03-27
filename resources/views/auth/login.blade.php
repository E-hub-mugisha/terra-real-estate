@extends('layouts.auth')
@section('title', 'Sign In')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    /* ── Reset & Variables ─────────────────────────── */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --ink: #19265d;
        --ink-mid: #2c3245;
        --ink-soft: #5a6278;
        --muted: #9099b0;
        --border: #e2e5ee;
        --surface: #f8f9fc;
        --white: #ffffff;
        --gold: #D05208;
        --gold-light: #f0e0b8;
        --gold-glow: rgba(200, 164, 90, .15);
        --red: #e05454;
        --green: #1e9e6b;
        --radius: 10px;
        --transition: .25s cubic-bezier(.4, 0, .2, 1);
    }

    html,
    body {
        height: 100%;
        font-family: 'Jost', sans-serif;
        background: var(--ink);
        color: var(--ink);
        -webkit-font-smoothing: antialiased;
    }

    /* ── Split Layout ──────────────────────────────── */
    .sl-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
    }

    /* ── Left Panel ────────────────────────────────── */
    .sl-left {
        position: relative;
        overflow: hidden;
        background: var(--ink);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 52px 56px;
    }

    /* geometric background lines */
    .sl-left::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 80% 60% at 20% 80%, rgba(200, 164, 90, .12) 0%, transparent 55%),
            radial-gradient(ellipse 60% 80% at 85% 10%, rgba(200, 164, 90, .07) 0%, transparent 50%);
        pointer-events: none;
    }

    /* grid lines decoration */
    .sl-grid {
        position: absolute;
        inset: 0;
        overflow: hidden;
        opacity: .04;
    }

    .sl-grid::before,
    .sl-grid::after {
        content: '';
        position: absolute;
        background: var(--gold);
    }

    .sl-grid::before {
        width: 1px;
        top: 0;
        bottom: 0;
        left: 33%;
    }

    .sl-grid::after {
        height: 1px;
        left: 0;
        right: 0;
        top: 45%;
    }

    .sl-grid-h {
        position: absolute;
        width: 100%;
        height: 1px;
        background: var(--gold);
        opacity: .04;
        top: 72%;
    }

    /* floating orb */
    .sl-orb {
        position: absolute;
        width: 340px;
        height: 340px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(200, 164, 90, .18) 0%, transparent 70%);
        bottom: -80px;
        right: -60px;
        pointer-events: none;
        animation: orb-drift 8s ease-in-out infinite alternate;
    }

    @keyframes orb-drift {
        from {
            transform: translate(0, 0) scale(1);
        }

        to {
            transform: translate(-20px, -30px) scale(1.08);
        }
    }

    .sl-brand {
        position: relative;
        z-index: 2;
        animation: fadeUp .6s ease both;
    }

    .sl-brand img {
        height: 38px;
        filter: brightness(0) invert(1);
        opacity: .9;
    }

    .sl-copy {
        position: relative;
        z-index: 2;
        animation: fadeUp .6s .12s ease both;
    }

    .sl-copy-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: .7rem;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--gold);
        font-weight: 600;
        margin-bottom: 20px;
    }

    .sl-copy-tag::before {
        content: '';
        display: block;
        width: 24px;
        height: 1px;
        background: var(--gold);
    }

    .sl-headline {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2rem, 3.2vw, 2.8rem);
        font-weight: 700;
        color: var(--white);
        line-height: 1.2;
        letter-spacing: -.02em;
        margin-bottom: 20px;
    }

    .sl-headline em {
        font-style: italic;
        color: var(--gold);
    }

    .sl-subline {
        font-size: .9rem;
        color: rgba(255, 255, 255, .45);
        line-height: 1.75;
        max-width: 360px;
        font-weight: 300;
    }

    .sl-stats {
        position: relative;
        z-index: 2;
        display: flex;
        gap: 36px;
        padding-top: 32px;
        border-top: 1px solid rgba(255, 255, 255, .08);
        animation: fadeUp .6s .22s ease both;
    }

    .sl-stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--white);
        line-height: 1;
        margin-bottom: 4px;
    }

    .sl-stat-val span {
        color: var(--gold);
    }

    .sl-stat-label {
        font-size: .7rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .35);
        font-weight: 500;
    }

    /* ── Right Panel ───────────────────────────────── */
    .sl-right {
        background: var(--surface);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 40px;
        position: relative;
        overflow: hidden;
    }

    /* subtle dot-grid background */
    .sl-right::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle, var(--border) 1px, transparent 1px);
        background-size: 24px 24px;
        opacity: .5;
    }

    .sl-form-box {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 420px;
        animation: fadeUp .55s .05s ease both;
    }

    .sl-form-head {
        margin-bottom: 32px;
    }

    .sl-form-head .pre-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .68rem;
        letter-spacing: .14em;
        text-transform: uppercase;
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .sl-form-head h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--ink);
        letter-spacing: -.03em;
        margin-bottom: 8px;
        line-height: 1.15;
    }

    .sl-form-head p {
        font-size: .85rem;
        color: var(--muted);
        font-weight: 400;
    }

    .sl-form-head p a {
        color: var(--gold);
        font-weight: 600;
        text-decoration: none;
    }

    .sl-form-head p a:hover {
        text-decoration: underline;
    }

    /* ── Alerts ─────────────────────────────────────── */
    .sl-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 14px;
        border-radius: var(--radius);
        font-size: .83rem;
        line-height: 1.5;
        margin-bottom: 20px;
        animation: fadeUp .3s ease both;
    }

    .sl-alert--error {
        background: #fef2f2;
        border: 1px solid #fcd5d5;
        color: #b91c1c;
    }

    .sl-alert--success {
        background: #f0fdf6;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .sl-alert ul {
        padding-left: 16px;
        margin: 0;
    }

    .sl-alert .al-icon {
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .sl-alert-close {
        margin-left: auto;
        background: none;
        border: none;
        cursor: pointer;
        opacity: .5;
        font-size: 1rem;
        line-height: 1;
        color: inherit;
        flex-shrink: 0;
        padding: 0;
    }

    .sl-alert-close:hover {
        opacity: 1;
    }

    /* ── Form Fields ─────────────────────────────────── */
    .sl-field {
        margin-bottom: 18px;
    }

    .sl-label {
        display: block;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--ink-soft);
        margin-bottom: 7px;
    }

    .sl-input-wrap {
        position: relative;
    }

    .sl-input-wrap .field-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        font-size: .9rem;
        pointer-events: none;
        display: flex;
        align-items: center;
        transition: color var(--transition);
    }

    .sl-input {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        font-family: 'Jost', sans-serif;
        font-size: .9rem;
        color: var(--ink);
        background: var(--white);
        outline: none;
        transition: border-color var(--transition), box-shadow var(--transition);
        -webkit-appearance: none;
    }

    .sl-input::placeholder {
        color: var(--muted);
        font-weight: 300;
    }

    .sl-input:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px var(--gold-glow);
    }

    .sl-input:focus~.field-icon,
    .sl-input-wrap:focus-within .field-icon {
        color: var(--gold);
    }

    /* password has toggle on right */
    .sl-input--pw {
        padding-right: 46px;
    }

    .pw-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        color: var(--muted);
        display: flex;
        align-items: center;
        transition: color var(--transition);
        line-height: 1;
    }

    .pw-toggle:hover {
        color: var(--gold);
    }

    .pw-toggle svg {
        width: 18px;
        height: 18px;
    }

    .pw-toggle .eye-off {
        display: block;
    }

    .pw-toggle .eye-on {
        display: none;
    }

    .pw-toggle.revealed .eye-off {
        display: none;
    }

    .pw-toggle.revealed .eye-on {
        display: block;
    }

    /* ── Row: remember + forgot ──────────────────────── */
    .sl-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        font-size: .82rem;
    }

    .sl-check {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        color: var(--ink-soft);
        user-select: none;
    }

    .sl-check input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--gold);
        cursor: pointer;
        border-radius: 4px;
    }

    .sl-forgot {
        color: var(--muted);
        text-decoration: none;
        font-weight: 500;
        transition: color var(--transition);
    }

    .sl-forgot:hover {
        color: var(--gold);
    }

    /* ── Submit ──────────────────────────────────────── */
    .sl-submit {
        width: 100%;
        padding: 13px 20px;
        background: var(--ink);
        color: var(--white);
        border: none;
        border-radius: var(--radius);
        font-family: 'Jost', sans-serif;
        font-size: .9rem;
        font-weight: 600;
        letter-spacing: .04em;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
    }

    .sl-submit::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, transparent 40%, rgba(200, 164, 90, .18) 100%);
        opacity: 0;
        transition: opacity var(--transition);
    }

    .sl-submit:hover {
        background: #1a2035;
        box-shadow: 0 8px 24px rgba(11, 15, 26, .25);
        transform: translateY(-1px);
    }

    .sl-submit:hover::after {
        opacity: 1;
    }

    .sl-submit:active {
        transform: translateY(0);
    }

    /* ── Bottom link ─────────────────────────────────── */
    .sl-bottom {
        text-align: center;
        margin-top: 22px;
        font-size: .83rem;
        color: var(--muted);
    }

    .sl-bottom a {
        color: var(--gold);
        font-weight: 600;
        text-decoration: none;
    }

    .sl-bottom a:hover {
        text-decoration: underline;
    }

    /* ── Divider ─────────────────────────────────────── */
    .sl-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 22px 0;
        color: var(--border);
        font-size: .75rem;
        color: var(--muted);
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .sl-divider::before,
    .sl-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── Animations ──────────────────────────────────── */
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ── Responsive ──────────────────────────────────── */
    @media (max-width: 820px) {
        .sl-wrap {
            grid-template-columns: 1fr;
        }

        .sl-left {
            display: none;
        }

        .sl-right {
            min-height: 100vh;
            padding: 40px 24px;
        }
    }
</style>



<div class="sl-wrap">

    {{-- ══ LEFT PANEL ══ --}}
    <div class="sl-left">
        <div class="sl-grid">
            <div class="sl-grid-h"></div>
        </div>
        <div class="sl-orb"></div>

        {{-- Logo --}}
        <div class="sl-brand">
            <a href="/">
                <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Logo">
            </a>
        </div>

        {{-- Headline copy --}}
        <div class="sl-copy">
            <div class="sl-copy-tag">Member Portal</div>
            <h2 class="sl-headline">
                Your next <em>great deal</em><br>starts here.
            </h2>
            <p class="sl-subline">
                Access your dashboard, connect with top consultants,
                and manage your real estate portfolio — all in one place.
            </p>
        </div>

        {{-- Stats --}}
        <div class="sl-stats">
            <div>
                <div class="sl-stat-val">2.4K<span>+</span></div>
                <div class="sl-stat-label">Active Listings</div>
            </div>
            <div>
                <div class="sl-stat-val">840<span>+</span></div>
                <div class="sl-stat-label">Consultants</div>
            </div>
            <div>
                <div class="sl-stat-val">98<span>%</span></div>
                <div class="sl-stat-label">Client Satisfaction</div>
            </div>
        </div>
    </div>

    {{-- ══ RIGHT PANEL ══ --}}
    <div class="sl-right">
        <div class="sl-form-box">

            {{-- Heading --}}
            <div class="sl-form-head">
                <div class="pre-label">✦ Secure Sign In</div>
                <h1>Welcome back</h1>
                <p>New here? <a href="{{ route('register') }}">Create a free account</a></p>
            </div>

            {{-- Laravel validation errors --}}
            @if($errors->any())
            <div class="sl-alert sl-alert--error" id="sl-err-bag">
                <span class="al-icon">⚠</span>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="sl-alert-close" onclick="this.closest('.sl-alert').remove()">✕</button>
            </div>
            @endif

            {{-- Session success (e.g. after password reset) --}}
            @if(session('status'))
            <div class="sl-alert sl-alert--success">
                <span class="al-icon">✓</span>
                <span>{{ session('status') }}</span>
                <button class="sl-alert-close" onclick="this.closest('.sl-alert').remove()">✕</button>
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="sl-field">
                    <label class="sl-label" for="email">Email or Username</label>
                    <div class="sl-input-wrap">
                        <span class="field-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            class="sl-input"
                            placeholder="you@example.com"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            required>
                    </div>
                </div>

                {{-- Password --}}
                <div class="sl-field">
                    <label class="sl-label" for="password">Password</label>
                    <div class="sl-input-wrap">
                        <span class="field-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="sl-input sl-input--pw"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required>
                        {{-- Show / Hide toggle --}}
                        <button type="button" class="pw-toggle" id="pw-toggle" aria-label="Toggle password visibility">
                            {{-- eye-off (hidden state) --}}
                            <svg class="eye-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94" />
                                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                            {{-- eye-on (visible state) --}}
                            <svg class="eye-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember + Forgot --}}
                <div class="sl-meta">
                    <label class="sl-check">
                        <input type="checkbox" name="remember" id="remember_me">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="sl-forgot">Forgot password?</a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="sl-submit">
                    Sign In →
                </button>
            </form>

            {{-- Bottom --}}
            <div class="sl-bottom">
                Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
            </div>

        </div>
    </div>
</div>

<script>
    (function() {
        const toggle = document.getElementById('pw-toggle');
        const input = document.getElementById('password');
        if (!toggle || !input) return;

        toggle.addEventListener('click', function() {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            toggle.classList.toggle('revealed', isHidden);
            toggle.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        });
    })();
</script>

@endsection