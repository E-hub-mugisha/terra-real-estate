<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Submitted — Terra Real Estate</title>
    <link rel="icon" href="https://www.terra.rw/front/assets/img/logo/logo.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:opsz,wght@9..40,300;400;500;600&display=swap" rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green: #1a6b4a;
            --green-d: #144f38;
            --green-l: #e8f5f0;
            --green-ll: #f2faf6;
            --gold: #c8a96e;
            --gold-l: #faf4ea;
            --dark: #111a14;
            --mid: #3d5246;
            --muted: #6b7c72;
            --line: #dde8e2;
            --bg: #f8faf9;
            --white: #ffffff;
            --font-d: 'Cormorant Garamond', serif;
            --font-b: 'DM Sans', sans-serif;
            --r: 14px;
            --r-sm: 8px;
            --shadow: 0 4px 24px rgba(26, 107, 74, .10);
            --shadow-lg: 0 16px 56px rgba(26, 107, 74, .18);
            --t: .3s cubic-bezier(.4, 0, .2, 1);
        }

        html {
            font-size: 16px;
        }

        body {
            font-family: var(--font-b);
            background: var(--bg);
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Header ── */
        header {
            background: var(--white);
            border-bottom: 1px solid var(--line);
            height: 64px;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header img {
            height: 36px;
        }

        header a.back-link {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .85rem;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            transition: color var(--t);
        }

        header a.back-link:hover {
            color: var(--green);
        }

        /* ── Page wrapper ── */
        .page {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border-radius: var(--r);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 680px;
            overflow: hidden;
            animation: rise .6s cubic-bezier(.16, 1, .3, 1) both;
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(28px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ── Top band ── */
        .card__band {
            background: linear-gradient(135deg, var(--green) 0%, #0f5238 100%);
            padding: 3rem 2.5rem 2rem;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .card__band::before {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .04);
            top: -80px;
            right: -80px;
        }

        .card__band::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(200, 169, 110, .10);
            bottom: -60px;
            left: -40px;
        }

        /* ── Checkmark animation ── */
        .check-ring {
            width: 88px;
            height: 88px;
            margin: 0 auto 1.5rem;
            position: relative;
            z-index: 1;
        }

        .check-ring svg {
            width: 100%;
            height: 100%;
        }

        .check-circle {
            fill: none;
            stroke: rgba(255, 255, 255, .25);
            stroke-width: 2;
        }

        .check-circle-fill {
            fill: none;
            stroke: #fff;
            stroke-width: 2;
            stroke-dasharray: 251;
            stroke-dashoffset: 251;
            stroke-linecap: round;
            animation: drawCircle .7s .2s cubic-bezier(.4, 0, .2, 1) forwards;
        }

        @keyframes drawCircle {
            to {
                stroke-dashoffset: 0;
            }
        }

        .check-tick {
            fill: none;
            stroke: #fff;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 40;
            stroke-dashoffset: 40;
            animation: drawTick .35s .85s cubic-bezier(.4, 0, .2, 1) forwards;
        }

        @keyframes drawTick {
            to {
                stroke-dashoffset: 0;
            }
        }

        .check-glow {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200, 169, 110, .35) 0%, transparent 70%);
            opacity: 0;
            animation: glow .5s 1s ease forwards;
        }

        @keyframes glow {
            to {
                opacity: 1;
            }
        }

        .card__band h1 {
            font-family: var(--font-d);
            font-size: 2.2rem;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
            position: relative;
            z-index: 1;
        }

        .card__band p {
            font-size: .95rem;
            color: rgba(255, 255, 255, .75);
            margin-top: .5rem;
            position: relative;
            z-index: 1;
        }

        /* ── Reference badge ── */
        .ref-badge {
            display: inline-flex;
            align-items: center;
            gap: .6rem;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 99px;
            padding: .45rem 1.1rem;
            margin-top: 1.25rem;
            position: relative;
            z-index: 1;
            cursor: pointer;
            transition: background var(--t);
        }

        .ref-badge:hover {
            background: rgba(255, 255, 255, .2);
        }

        .ref-badge__label {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .6);
        }

        .ref-badge__number {
            font-size: .9rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .05em;
            font-family: monospace;
        }

        .ref-badge__copy {
            width: 16px;
            height: 16px;
            color: rgba(255, 255, 255, .5);
            flex-shrink: 0;
        }

        .ref-badge__copied {
            font-size: .72rem;
            color: var(--gold);
            font-weight: 600;
            opacity: 0;
            transition: opacity .2s;
        }

        .ref-badge__copied.show {
            opacity: 1;
        }

        /* ── Body ── */
        .card__body {
            padding: 2.25rem 2.5rem;
        }

        /* ── What happens next ── */
        .next-steps {
            margin-bottom: 2rem;
        }

        .next-steps__heading {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--green);
            margin-bottom: 1.25rem;
        }

        .step-track {
            position: relative;
            padding-left: 2.25rem;
        }

        .step-track::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--line);
        }

        .step-track__item {
            position: relative;
            padding-bottom: 1.5rem;
            animation: fadeIn .4s both;
        }

        .step-track__item:last-child {
            padding-bottom: 0;
        }

        .step-track__item:nth-child(1) {
            animation-delay: .15s;
        }

        .step-track__item:nth-child(2) {
            animation-delay: .3s;
        }

        .step-track__item:nth-child(3) {
            animation-delay: .45s;
        }

        .step-track__item:nth-child(4) {
            animation-delay: .6s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(-8px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .step-track__dot {
            position: absolute;
            left: -2.25rem;
            top: 2px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--white);
            border: 2px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .step-track__dot svg {
            width: 12px;
            height: 12px;
            color: var(--muted);
        }

        .step-track__item--active .step-track__dot {
            border-color: var(--green);
            background: var(--green-l);
        }

        .step-track__item--active .step-track__dot svg {
            color: var(--green);
        }

        .step-track__title {
            font-size: .875rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: .2rem;
        }

        .step-track__desc {
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.5;
        }

        /* ── Info strip ── */
        .info-strip {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .75rem;
            margin-bottom: 2rem;
        }

        .info-chip {
            background: var(--green-ll);
            border: 1px solid var(--line);
            border-radius: var(--r-sm);
            padding: .875rem 1rem;
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .info-chip__icon {
            width: 34px;
            height: 34px;
            background: var(--green-l);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-chip__icon svg {
            width: 16px;
            height: 16px;
            color: var(--green);
        }

        .info-chip__label {
            font-size: .72rem;
            color: var(--muted);
            margin-bottom: 2px;
        }

        .info-chip__value {
            font-size: .85rem;
            font-weight: 600;
            color: var(--dark);
        }

        /* ── CTA row ── */
        .cta-row {
            display: flex;
            gap: .875rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .75rem 1.5rem;
            border-radius: var(--r-sm);
            font-family: var(--font-b);
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all var(--t);
            border: none;
        }

        .btn svg {
            width: 16px;
            height: 16px;
        }

        .btn--primary {
            background: var(--green);
            color: #fff;
            flex: 1;
            justify-content: center;
        }

        .btn--primary:hover {
            background: var(--green-d);
            box-shadow: 0 4px 18px rgba(26, 107, 74, .3);
            transform: translateY(-1px);
        }

        .btn--outline {
            border: 1.5px solid var(--line);
            color: var(--mid);
            background: var(--white);
            flex: 1;
            justify-content: center;
        }

        .btn--outline:hover {
            border-color: var(--green);
            color: var(--green);
        }

        .btn--whatsapp {
            background: #25d366;
            color: #fff;
            flex: 1;
            justify-content: center;
        }

        .btn--whatsapp:hover {
            background: #1ebe5d;
            transform: translateY(-1px);
        }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1px solid var(--line);
            margin: 1.75rem 0;
        }

        /* ── Contact note ── */
        .contact-note {
            text-align: center;
            font-size: .8rem;
            color: var(--muted);
            line-height: 1.7;
        }

        .contact-note a {
            color: var(--green);
            text-decoration: none;
            font-weight: 500;
        }

        .contact-note a:hover {
            text-decoration: underline;
        }

        /* ── Footer ── */
        footer {
            text-align: center;
            padding: 1.5rem;
            font-size: .78rem;
            color: var(--muted);
            border-top: 1px solid var(--line);
        }

        footer a {
            color: var(--green);
            text-decoration: none;
        }

        /* ── Toast ── */
        .toast {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: var(--dark);
            color: #fff;
            padding: .65rem 1.25rem;
            border-radius: 99px;
            font-size: .82rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, .25);
            transition: transform .35s cubic-bezier(.16, 1, .3, 1);
            z-index: 999;
            pointer-events: none;
        }

        .toast.show {
            transform: translateX(-50%) translateY(0);
        }

        .toast svg {
            width: 14px;
            height: 14px;
            color: #4ade80;
        }

        @media (max-width: 640px) {
            .card__band {
                padding: 2rem 1.5rem 1.75rem;
            }

            .card__band h1 {
                font-size: 1.75rem;
            }

            .card__body {
                padding: 1.75rem 1.5rem;
            }

            .info-strip {
                grid-template-columns: 1fr;
            }

            .cta-row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <header>
        <a href="https://www.terra.rw">
            <img src="https://www.terra.rw/front/assets/img/logo/logo.png" alt="Terra Real Estate">
        </a>
        <a href="https://www.terra.rw" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6" />
            </svg>
            Back to Terra
        </a>
    </header>

    <div class="page">
        <div class="card">

            {{-- Top green band --}}
            <div class="card__band">

                {{-- Animated checkmark --}}
                <div class="check-ring">
                    <svg viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle class="check-circle" cx="44" cy="44" r="40" />
                        <circle class="check-circle-fill" cx="44" cy="44" r="40" transform="rotate(-90 44 44)" />
                        <polyline class="check-tick" points="28,45 39,56 60,34" />
                    </svg>
                    <div class="check-glow"></div>
                </div>

                <h1>Request Submitted!</h1>
                <p>Thank you, <strong style="color:#fff">{{ session('full_name', 'there') }}</strong>. We have received your property request.</p>

                {{-- Reference number badge --}}
                <div class="ref-badge" id="refBadge" onclick="copyRef()" title="Click to copy">
                    <span class="ref-badge__label">Reference</span>
                    <span class="ref-badge__number" id="refNum">{{ session('reference_number', 'TERRA-XXXXXXXX') }}</span>
                    <svg class="ref-badge__copy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="9" y="9" width="13" height="13" rx="2" />
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                    </svg>
                    <span class="ref-badge__copied" id="copiedText">Copied!</span>
                </div>
            </div>

            {{-- Body --}}
            <div class="card__body">

                {{-- Info chips --}}
                <div class="info-strip">
                    <div class="info-chip">
                        <div class="info-chip__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <div class="info-chip__label">Confirmation sent to</div>
                            <div class="info-chip__value" style="word-break:break-all;font-size:.8rem">{{ session('email', 'your email') }}</div>
                        </div>
                    </div>
                    <div class="info-chip">
                        <div class="info-chip__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        <div>
                            <div class="info-chip__label">Expected response</div>
                            <div class="info-chip__value">Within 24–48 hours</div>
                        </div>
                    </div>
                </div>

                {{-- What happens next --}}
                <div class="next-steps">
                    <p class="next-steps__heading">What happens next</p>
                    <div class="step-track">

                        <div class="step-track__item step-track__item--active">
                            <div class="step-track__dot">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            </div>
                            <div class="step-track__title">Request received</div>
                            <div class="step-track__desc">Your request has been saved and our team has been notified immediately.</div>
                        </div>

                        <div class="step-track__item">
                            <div class="step-track__dot">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8" />
                                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                </svg>
                            </div>
                            <div class="step-track__title">Request review &amp; matching</div>
                            <div class="step-track__desc">A Terra specialist will review your preferences and search our active listings for the best matches.</div>
                        </div>

                        <div class="step-track__item">
                            <div class="step-track__dot">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.07 11.9 19.79 19.79 0 011 3.3 2 2 0 012.96 1.1h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L7.09 8.9a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                                </svg>
                            </div>
                            <div class="step-track__title">We contact you</div>
                            <div class="step-track__desc">Our agent will reach out via your preferred contact method to share curated options and schedule viewings.</div>
                        </div>

                        <div class="step-track__item">
                            <div class="step-track__dot">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                            </div>
                            <div class="step-track__title">Find your dream property</div>
                            <div class="step-track__desc">We guide you through viewings, negotiations, and paperwork until you have the keys in hand.</div>
                        </div>

                    </div>
                </div>

                <hr class="divider">

                {{-- CTA row --}}
                <div class="cta-row" style="margin-bottom:1.5rem">
                    <a href="https://www.terra.rw/buy/listings" class="btn btn--primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        Browse Listings
                    </a>
                    <a href="https://wa.me/250796511725?text=Hello%2C%20my%20reference%20is%20{{ urlencode(session('reference_number', '')) }}" target="_blank" class="btn btn--whatsapp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        WhatsApp Us
                    </a>
                    <a href="{{ route('property-request.step', ['step' => 1]) }}" class="btn btn--outline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        New Request
                    </a>
                </div>

                <p class="contact-note">
                    Have a question about your request? Contact us at
                    <a href="mailto:terraltd.rd@gmail.com">terraltd.rd@gmail.com</a> or call
                    <a href="tel:+250796511725">+250 796 511 725</a><br>
                    and quote your reference number <strong>{{ session('reference_number') }}</strong>.
                </p>

            </div>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} <a href="https://www.terra.rw">Terra Real Estate</a>. All rights reserved. &nbsp;&middot;&nbsp;
        Kigali, Rwanda &nbsp;&middot;&nbsp;
        <a href="https://www.terra.rw/legal/privacy-policy">Privacy Policy</a>
    </footer>

    {{-- Copy-ref toast --}}
    <div class="toast" id="toast">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12" />
        </svg>
        Reference number copied!
    </div>

    <script>
        function copyRef() {
            const ref = document.getElementById('refNum').textContent.trim();
            const toast = document.getElementById('toast');
            const copied = document.getElementById('copiedText');

            navigator.clipboard.writeText(ref).then(() => {
                copied.classList.add('show');
                toast.classList.add('show');
                setTimeout(() => {
                    copied.classList.remove('show');
                    toast.classList.remove('show');
                }, 2200);
            });
        }
    </script>

</body>

</html>