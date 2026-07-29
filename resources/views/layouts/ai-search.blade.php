<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AI Search — Terra')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;400;500;700&family=Syne:wght@600;700&family=DM+Mono:wght@400;500&display=swap');

        :root {
            --ai-navy: #19265d;
            --ai-orange: #D05208;
            --ai-gold: #F5A25D;
            --ai-bg: #f6f7fb;
            --ai-surface: #ffffff;
            --ai-text: #19265d;
            --ai-text-soft: rgba(25, 38, 93, .58);
            --ai-border: rgba(25, 38, 93, .09);
            --ai-glass: rgba(255, 255, 255, .78);
            --t: .2s cubic-bezier(.4, 0, .2, 1);
        }

        * { box-sizing: border-box; }

        html { -webkit-font-smoothing: antialiased; }

        body {
            margin: 0;
            background: var(--ai-bg);
            color: var(--ai-text);
            font-family: 'DM Sans', sans-serif;
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }

        /* ══════════════════════════════
           Top bar — frosted glass, sticky
        ══════════════════════════════ */
        .ai-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 12px 28px;
            position: sticky;
            top: 0;
            z-index: 50;
            background: var(--ai-glass);
            backdrop-filter: blur(14px) saturate(160%);
            -webkit-backdrop-filter: blur(14px) saturate(160%);
            border-bottom: 1px solid var(--ai-border);
        }

        .ai-topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        /* Logo badge with a quiet gradient halo — the page's one signature
           flourish: a soft pulse that reads as "the agent is live/listening" */
        .ai-logo-badge {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 13px;
            flex-shrink: 0;
            background: var(--ai-surface);
            border: 1px solid var(--ai-border);
        }

        .ai-logo-badge::before {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 16px;
            background: radial-gradient(circle, rgba(208, 82, 8, .35), transparent 70%);
            opacity: .55;
            animation: aiHaloPulse 3.6s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes aiHaloPulse {
            0%, 100% { opacity: .35; transform: scale(.94); }
            50% { opacity: .65; transform: scale(1.04); }
        }

        .ai-logo-badge img {
            height: 22px;
            width: auto;
            display: block;
            position: relative;
        }

        .ai-brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .ai-brand-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.02rem;
            color: var(--ai-navy);
        }

        /* Live status readout — small monospace chip */
        .ai-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'DM Mono', monospace;
            font-size: .66rem;
            font-weight: 500;
            letter-spacing: .03em;
            color: var(--ai-text-soft);
        }

        .ai-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2d8a4e;
            flex-shrink: 0;
            animation: aiStatusPulse 1.8s ease-in-out infinite;
        }

        @keyframes aiStatusPulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(45, 138, 78, .35); }
            50% { opacity: .55; box-shadow: 0 0 0 3px rgba(45, 138, 78, 0); }
        }

        .ai-divider {
            width: 1px;
            height: 22px;
            background: var(--ai-border);
            flex-shrink: 0;
        }

        .ai-back-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: var(--ai-text-soft);
            font-weight: 600;
            font-size: .8rem;
            padding: 8px 4px;
            transition: color var(--t);
            white-space: nowrap;
        }

        .ai-back-home::before {
            content: '';
            width: 6px;
            height: 6px;
            border-left: 1.6px solid currentColor;
            border-bottom: 1.6px solid currentColor;
            transform: rotate(45deg);
            flex-shrink: 0;
        }

        .ai-back-home:hover { color: var(--ai-orange); }

        /* ══════════════════════════════
           Right cluster — language switch
        ══════════════════════════════ */
        .ai-topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .ai-lang-switch { position: relative; }

        .ai-lang-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 20px;
            border: 1px solid var(--ai-border);
            background: var(--ai-surface);
            color: var(--ai-navy);
            font-family: 'DM Mono', monospace;
            font-size: .74rem;
            font-weight: 500;
            letter-spacing: .04em;
            cursor: pointer;
            transition: border-color var(--t), color var(--t);
        }

        .ai-lang-btn:hover { border-color: var(--ai-orange); color: var(--ai-orange); }

        .ai-lang-btn::after {
            content: '';
            width: 5px;
            height: 5px;
            border-right: 1.4px solid currentColor;
            border-bottom: 1.4px solid currentColor;
            transform: rotate(45deg);
            margin-top: -3px;
            opacity: .7;
        }

        .ai-lang-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: var(--ai-surface);
            border: 1px solid var(--ai-border);
            border-radius: 12px;
            box-shadow: 0 16px 32px rgba(25, 38, 93, .14);
            overflow: hidden;
            min-width: 150px;
        }

        .ai-lang-menu.show { display: block; }

        .ai-lang-menu a {
            display: block;
            padding: 10px 14px;
            font-size: .82rem;
            color: var(--ai-text);
            text-decoration: none;
            transition: background var(--t), color var(--t);
        }

        .ai-lang-menu a:hover { background: rgba(208, 82, 8, .07); color: var(--ai-orange); }
        .ai-lang-menu a.active { color: var(--ai-orange); font-weight: 700; }

        /* ══════════════════════════════
           Responsive
        ══════════════════════════════ */
        @media (max-width: 640px) {
            .ai-topbar {
                padding: 10px 16px;
                gap: 10px;
            }

            .ai-topbar-left { gap: 10px; }

            .ai-logo-badge { width: 36px; height: 36px; border-radius: 11px; }
            .ai-logo-badge img { height: 19px; }

            .ai-brand-name { font-size: .92rem; }
            .ai-status-chip { display: none; }
            .ai-divider { display: none; }

            .ai-back-home span { display: none; }
            .ai-back-home { padding: 8px; }

            .ai-lang-btn { font-size: .7rem; padding: 7px 10px; }
        }

        @media (max-width: 380px) {
            .ai-brand-text { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="ai-topbar">
        <div class="ai-topbar-left">
            <a href="{{ Route::has('front.home') ? route('front.home') : url('/') }}" class="ai-logo-badge">
                <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra">
            </a>

            <div class="ai-brand-text">
                <span class="ai-brand-name">Terra</span>
                <span class="ai-status-chip"><span class="ai-status-dot"></span>{{ __('AI Agent — Online') }}</span>
            </div>

            <div class="ai-divider"></div>

            <a href="{{ Route::has('front.home') ? route('front.home') : url('/') }}" class="ai-back-home">
                <span>{{ __('Back to Home') }}</span>
            </a>
        </div>

        <div class="ai-topbar-right">
            <div class="ai-lang-switch">
                <button type="button" class="ai-lang-btn" id="ai-lang-btn">
                    {{ strtoupper(app()->getLocale()) }}
                </button>
                <div class="ai-lang-menu" id="ai-lang-menu">
                    @foreach (['en' => 'English', 'fr' => 'Français', 'rw' => 'Kinyarwanda'] as $code => $label)
                        <a href="{{ route('locale.switch', $code) }}"
                           class="{{ app()->getLocale() === $code ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <script>
        // Language dropdown
        const langBtn  = document.getElementById('ai-lang-btn');
        const langMenu = document.getElementById('ai-lang-menu');
        langBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            langMenu.classList.toggle('show');
        });
        document.addEventListener('click', () => langMenu.classList.remove('show'));
    </script>
    @stack('scripts')
</body>
</html>