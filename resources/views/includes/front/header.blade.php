<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;400;500;700&display=swap');

  :root {
    --gold: #D05208;
    --gold-bg: rgba(200, 135, 58, .08);
    --gold-bd: rgba(200, 135, 58, .22);
    --dark: #19265d;
    --dark2: #19265d;
    --border: rgba(255, 255, 255, .08);
    --orange: #D05208;
    --navy: #19265d;
    --t: .2s cubic-bezier(.4, 0, .2, 1);
  }

  .nh-bar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, .08);
    font-family: 'DM Sans', sans-serif;
    transition: box-shadow var(--t), border-color var(--t);
  }

  .nh-bar.scrolled {
    box-shadow: 0 4px 32px rgba(25, 38, 93, .13);
    border-bottom-color: rgba(25, 38, 93, .1);
  }

  .nh-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    gap: 24px;
    height: 68px;
    transition: height .3s cubic-bezier(.4, 0, .2, 1);
  }

  .nh-bar.scrolled .nh-inner {
    height: 58px;
  }

  .nh-logo {
    display: flex;
    align-items: center;
    justify-content: flex-start;
  }

  .nh-logo img {
    height: 36px;
    width: auto;
    display: block;
    transition: height .3s cubic-bezier(.4, 0, .2, 1);
  }

  .nh-bar.scrolled .nh-logo img {
    height: 30px;
  }

  .nh-link-rst {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 9px;
    background: #fff;
    color: var(--navy) !important;
    font-size: .82rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    transition: background var(--t), transform var(--t);
    text-decoration: none;
    border: 1px solid var(--navy);
    cursor: pointer;
    white-space: nowrap;
  }

  .nh-link-rst:hover {
    background: var(--orange);
    border-color: var(--orange);
    transform: translateY(-1px);
    color: #fff !important;
  }

  .nh-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 9px;
    background: var(--navy);
    color: #fff !important;
    font-size: .82rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    transition: background var(--t), transform var(--t);
    text-decoration: none;
    border: none;
    cursor: pointer;
    white-space: nowrap;
  }

  .nh-btn:hover {
    background: var(--orange);
    transform: translateY(-1px);
    color: #fff;
  }

  .nh-btn svg {
    width: 13px;
    height: 13px;
  }

  /* ══════════════════════════════════════
     SEARCH — normal search pill + separate AI Search button
  ══════════════════════════════════════ */
  .nh-search-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
  }

  .nh-search-pill {
    display: flex;
    align-items: center;
    height: 42px;
    width: 100%;
    max-width: 400px;
    border-radius: 22px;
    border: 1.5px solid rgba(25, 38, 93, .18);
    background: rgba(25, 38, 93, .03);
    overflow: hidden;
    box-shadow: 0 2px 14px rgba(25, 38, 93, .07);
    transition: border-color var(--t), box-shadow var(--t), background var(--t);
  }

  .nh-search-pill:focus-within {
    border-color: var(--orange);
    background: #fff;
    box-shadow: 0 2px 18px rgba(208, 82, 8, .14);
  }

  .nh-search-select {
    height: 100%;
    border: none;
    outline: none;
    background: rgba(25, 38, 93, .05);
    color: var(--navy);
    font-family: 'DM Sans', sans-serif;
    font-size: .76rem;
    font-weight: 600;
    padding: 0 10px;
    max-width: 118px;
    border-right: 1px solid rgba(25, 38, 93, .12);
    cursor: pointer;
    flex-shrink: 0;
  }

  .nh-search-pill input[type="text"] {
    flex: 1;
    min-width: 0;
    border: none;
    outline: none;
    background: transparent;
    font-size: .82rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--navy);
    padding: 0 10px;
  }

  .nh-search-pill input[type="text"]::placeholder {
    color: rgba(25, 38, 93, .35);
  }

  .nh-search-pill-btn {
    width: 32px;
    height: 32px;
    min-width: 32px;
    border-radius: 16px;
    background: var(--orange);
    border: none;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: #fff;
    margin-right: 4px;
    flex-shrink: 0;
    transition: background var(--t);
  }

  .nh-search-pill-btn:hover {
    background: var(--navy);
  }

  .nh-search-pill-btn svg {
    width: 13px;
    height: 13px;
  }

  /* ── Standalone AI Search button (own page) ── */
  .nh-ai-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    height: 42px;
    padding: 0 16px;
    border-radius: 22px;
    border: none;
    background: linear-gradient(135deg, var(--navy), #2c3d8f);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .01em;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    flex-shrink: 0;
    box-shadow: 0 2px 14px rgba(25, 38, 93, .18);
    transition: transform var(--t), box-shadow var(--t), background var(--t);
  }

  .nh-ai-btn:hover {
    background: linear-gradient(135deg, var(--orange), #f07a2e);
    transform: translateY(-1px);
    box-shadow: 0 4px 18px rgba(208, 82, 8, .28);
    color: #fff;
  }

  .nh-ai-btn svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
  }

  /* ══════════════════════════════════════
     LANGUAGE SWITCHER
  ══════════════════════════════════════ */
  .nh-lang {
    position: relative;
  }

  .nh-lang-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 10px;
    border-radius: 9px;
    border: 1px solid rgba(25, 38, 93, .18);
    background: #fff;
    color: var(--navy);
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 600;
    cursor: pointer;
    text-transform: uppercase;
    transition: border-color var(--t), color var(--t);
  }

  .nh-lang-btn:hover {
    border-color: var(--orange);
    color: var(--orange);
  }

  .nh-lang-btn svg {
    width: 10px;
    height: 10px;
  }

  .nh-lang-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 6px;
    background: var(--navy);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 10px;
    min-width: 140px;
    padding: 6px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(4px);
    transition: opacity var(--t), transform var(--t), visibility var(--t);
    box-shadow: 0 16px 40px rgba(0, 0, 0, .25);
    z-index: 10;
  }

  .nh-lang.open .nh-lang-dropdown {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0);
  }

  .nh-lang-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 8px 10px;
    border-radius: 7px;
    border: none;
    background: none;
    color: rgba(255, 255, 255, .65);
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: color var(--t), background var(--t);
  }

  .nh-lang-item:hover {
    color: #fff;
    background: rgba(255, 255, 255, .1);
  }

  .nh-lang-item.active {
    color: var(--gold);
  }

  .nh-right-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: flex-end;
  }

  /* ══════════════════════════════════════
     MOBILE HEADER
  ══════════════════════════════════════ */
  .nh-mobile {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, .08);
    height: 60px;
    display: flex;
    align-items: center;
    padding: 0 16px;
    justify-content: space-between;
    gap: 10px;
    font-family: 'DM Sans', sans-serif;
  }

  .nh-mobile-logo img {
    height: 28px;
  }

  .nh-mobile-actions {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .nh-mobile-user {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: transparent;
    border: 1.5px solid var(--navy);
    display: grid;
    place-items: center;
    color: var(--navy);
    text-decoration: none;
    transition: background var(--t);
  }

  .nh-mobile-user:hover {
    background: var(--navy);
    color: #fff;
  }

  .nh-mobile-user svg {
    width: 15px;
    height: 15px;
  }

  .nh-mobile-burger {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: var(--navy);
    border: none;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: #fff;
    transition: background var(--t);
  }

  .nh-mobile-burger:hover {
    background: var(--orange);
  }

  .nh-mobile-burger svg {
    width: 18px;
    height: 18px;
  }

  /* ══════════════════════════════════════
     MOBILE SECOND NAV — Search + AI Search
     (persistent row, not tucked in the drawer)
  ══════════════════════════════════════ */
  .nh-mobile-searchbar {
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    z-index: 998;
    background: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, .08);
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'DM Sans', sans-serif;
  }

  .nh-mobile-search-pill {
    flex: 1;
    min-width: 0;
    display: flex;
    align-items: center;
    height: 40px;
    border-radius: 20px;
    border: 1.5px solid rgba(25, 38, 93, .16);
    background: rgba(25, 38, 93, .03);
    overflow: hidden;
    transition: border-color var(--t), background var(--t), box-shadow var(--t);
  }

  .nh-mobile-search-pill:focus-within {
    border-color: var(--orange);
    background: #fff;
    box-shadow: 0 2px 14px rgba(208, 82, 8, .12);
  }

  .nh-mobile-search-select {
    height: 100%;
    border: none;
    outline: none;
    background: rgba(25, 38, 93, .05);
    color: var(--navy);
    font-family: 'DM Sans', sans-serif;
    font-size: .7rem;
    font-weight: 600;
    padding: 0 8px;
    max-width: 76px;
    border-right: 1px solid rgba(25, 38, 93, .12);
    flex-shrink: 0;
  }

  .nh-mobile-search-pill input[type="text"] {
    flex: 1;
    min-width: 0;
    border: none;
    outline: none;
    background: transparent;
    font-size: .8rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--navy);
    padding: 0 10px;
  }

  .nh-mobile-search-pill input[type="text"]::placeholder {
    color: rgba(25, 38, 93, .35);
  }

  .nh-mobile-search-pill-btn {
    width: 30px;
    height: 30px;
    min-width: 30px;
    border-radius: 15px;
    background: var(--orange);
    border: none;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: #fff;
    margin-right: 4px;
    flex-shrink: 0;
    transition: background var(--t);
  }

  .nh-mobile-search-pill-btn:hover {
    background: var(--navy);
  }

  .nh-mobile-search-pill-btn svg {
    width: 12px;
    height: 12px;
  }

  .nh-mobile-ai-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    height: 40px;
    padding: 0 14px;
    border-radius: 20px;
    border: none;
    background: linear-gradient(135deg, var(--navy), #2c3d8f);
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-size: .74rem;
    font-weight: 700;
    letter-spacing: .01em;
    white-space: nowrap;
    flex-shrink: 0;
    text-decoration: none;
    box-shadow: 0 2px 10px rgba(25, 38, 93, .18);
    transition: background var(--t), transform var(--t), box-shadow var(--t);
  }

  .nh-mobile-ai-btn:hover,
  .nh-mobile-ai-btn:active {
    background: linear-gradient(135deg, var(--orange), #f07a2e);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(208, 82, 8, .28);
    color: #fff;
  }

  .nh-mobile-ai-btn svg {
    width: 13px;
    height: 13px;
    flex-shrink: 0;
  }

  @media (max-width: 380px) {
    .nh-mobile-ai-btn span { display: none; }
    .nh-mobile-ai-btn { padding: 0 11px; }
  }

  /* ══════════════════════════════════════
     MOBILE DRAWER
  ══════════════════════════════════════ */
  .nh-drawer {
    position: fixed;
    top: 0;
    right: -100%;
    bottom: 0;
    z-index: 1100;
    width: min(320px, 90vw);
    background: var(--navy);
    border-left: 1px solid rgba(255, 255, 255, .08);
    display: flex;
    flex-direction: column;
    transition: right .35s cubic-bezier(.4, 0, .2, 1);
    font-family: 'DM Sans', sans-serif;
    overflow-y: auto;
  }

  .nh-drawer.open {
    right: 0;
  }

  .nh-drawer-overlay {
    position: fixed;
    inset: 0;
    z-index: 1099;
    background: rgba(0, 0, 0, .55);
    backdrop-filter: blur(4px);
    display: none;
  }

  .nh-drawer-overlay.open {
    display: block;
  }

  .nh-drawer-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, .07);
  }

  .nh-drawer-head img {
    height: 26px;
  }

  .nh-drawer-close {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: rgba(255, 255, 255, .1);
    border: none;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: #fff;
  }

  .nh-drawer-close svg {
    width: 16px;
    height: 16px;
  }

  .nh-drawer-nav {
    flex: 1;
    padding: 16px;
  }

  .nh-drawer-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 11px 12px;
    border-radius: 9px;
    font-size: .85rem;
    font-weight: 500;
    color: rgba(255, 255, 255, .65);
    cursor: pointer;
    transition: color var(--t), background var(--t);
    text-decoration: none;
    border: none;
    background: none;
    font-family: 'DM Sans', sans-serif;
    width: 100%;
    text-align: left;
  }

  .nh-drawer-link:hover {
    color: #fff;
    background: rgba(255, 255, 255, .08);
  }

  .nh-drawer-divider {
    height: 1px;
    background: rgba(255, 255, 255, .07);
    margin: 12px 0;
  }

  .nh-drawer-lang-row {
    display: flex;
    gap: 6px;
    margin-bottom: 4px;
  }

  .nh-drawer-lang-item {
    flex: 1;
    text-align: center;
    padding: 8px 4px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, .12);
    background: rgba(255, 255, 255, .05);
    color: rgba(255, 255, 255, .6);
    font-family: 'DM Sans', sans-serif;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    text-decoration: none;
    cursor: pointer;
    transition: all var(--t);
  }

  .nh-drawer-lang-item.active,
  .nh-drawer-lang-item:hover {
    border-color: var(--gold);
    color: var(--gold);
  }

  .nh-drawer-foot {
    padding: 16px 20px;
    border-top: 1px solid rgba(255, 255, 255, .07);
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .nh-drawer-signin {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 11px 16px;
    border-radius: 9px;
    background: var(--orange);
    color: #fff;
    font-size: .84rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    transition: background var(--t);
  }

  .nh-drawer-signin:hover {
    background: #fff;
    color: var(--navy);
  }

  .nh-drawer-signin svg {
    width: 14px;
    height: 14px;
  }

  .nh-spacer-desktop {
    height: 68px;
  }

  /* 60px mobile header + 60px second search/AI nav row */
  .nh-spacer-mobile {
    height: 120px;
  }

  .nh-mobile-logout {
    color: #5a5a5a;
    transition: color .2s;
    background: none;
    border: none;
    cursor: pointer;
  }

  .nh-mobile-logout:hover {
    color: #e05c5c;
  }
</style>

{{-- ════════════════════════════════════════════
     DESKTOP HEADER
════════════════════════════════════════════ --}}
<header class="nh-bar d-none d-lg-block" id="nh-bar">
  <div class="nh-inner">

    {{-- ── LOGO ── --}}
    <div class="nh-logo">
      <a href="{{ route('front.home') }}">
        <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="{{ config('app.name') }}">
      </a>
    </div>

    {{-- ── SEARCH: category dropdown + input, plus a separate AI Search page button ── --}}
    <div class="nh-search-wrap">
      <form class="nh-search-pill" id="nh-search-pill-desktop"
        action="{{ route('front.search') }}" method="GET">

        <select name="category" id="nh-cat-select-desktop" class="nh-search-select" aria-label="Filter by service">
          <option value="">All</option>
        </select>

        <input type="text" name="q" id="nh-q-desktop"
          placeholder="Properties, agents, news…"
          autocomplete="off"
          aria-label="Search">

        <button type="submit" class="nh-search-pill-btn" aria-label="Submit search">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
          </svg>
        </button>
      </form>

      <a href="{{ Route::has('front.ai.search.index') ? route('front.ai.search.index') : '#' }}" class="nh-ai-btn">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2l1.8 5.2L19 9l-5.2 1.8L12 16l-1.8-5.2L5 9l5.2-1.8L12 2zM19 13l.9 2.6L22.5 16.5l-2.6.9L19 20l-.9-2.6-2.6-.9 2.6-.9L19 13z" />
        </svg>
        AI Search
      </a>
    </div>

    {{-- ── RIGHT: Request Property, Language, Login ── --}}
    <div class="nh-right-nav">

      <a href="{{ route('property-request.create') }}" class="nh-link-rst">Request a Property</a>

      <div class="nh-lang" id="nh-lang-desktop">
        <button type="button" class="nh-lang-btn" onclick="nhToggleLang('nh-lang-desktop')">
          {{ app()->getLocale() }}
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5z" /></svg>
        </button>
        <div class="nh-lang-dropdown">
          <a href="{{ Route::has('locale.switch') ? route('locale.switch', 'en') : '#' }}" class="nh-lang-item {{ app()->getLocale() === 'en' ? 'active' : '' }}">English</a>
          <a href="{{ Route::has('locale.switch') ? route('locale.switch', 'rw') : '#' }}" class="nh-lang-item {{ app()->getLocale() === 'rw' ? 'active' : '' }}">Kinyarwanda</a>
          <a href="{{ Route::has('locale.switch') ? route('locale.switch', 'fr') : '#' }}" class="nh-lang-item {{ app()->getLocale() === 'fr' ? 'active' : '' }}">Français</a>
        </div>
      </div>

      @guest
      <a href="{{ route('login') }}" class="nh-btn">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
        </svg>
        Sign In
      </a>
      @else
      <div class="dropdown">
        <button class="nh-btn dropdown-toggle" type="button"
          data-bs-toggle="dropdown" aria-expanded="false">
          <svg viewBox="0 0 24 24" fill="currentColor" style="width:16px;height:16px">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
          </svg>
          {{ Str::limit(auth()->user()->name, 12) }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <div class="px-3 py-2">
              <div class="fw-600 text-dark" style="font-size:.85rem">{{ auth()->user()->name }}</div>
              <div class="text-muted" style="font-size:.75rem">{{ auth()->user()->email }}</div>
            </div>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center gap-2"
              href="{{ route(auth()->user()->redirectRoute()) }}">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;flex-shrink:0">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
              </svg>
              Dashboard
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:15px;height:15px;flex-shrink:0">
                  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                  <polyline points="16 17 21 12 16 7" />
                  <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
                Sign Out
              </button>
            </form>
          </li>
        </ul>
      </div>
      @endguest

    </div>
  </div>
</header>
<div class="nh-spacer-desktop d-none d-lg-block"></div>

{{-- ════════════════════════════════════════════
     MOBILE HEADER
════════════════════════════════════════════ --}}
<header class="nh-mobile d-flex d-lg-none">
  <a href="{{ route('front.home') }}" class="nh-mobile-logo">
    <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="{{ config('app.name') }}">
  </a>
  <div class="nh-mobile-actions">
    <a href="{{ route('property-request.create') }}" class="nh-mobile-user" aria-label="Request a Property">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 10.5L12 3l9 7.5"></path>
        <path d="M5 9.5V20h14V9.5"></path>
        <path d="M9 14h6"></path>
        <path d="M12 11v6"></path>
      </svg>
    </a>

    @guest
    <a href="{{ route('login') }}" class="nh-mobile-user">
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
      </svg>
    </a>
    @else
    <a href="{{ route(auth()->user()->redirectRoute()) }}" class="nh-mobile-user">
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
      </svg>
    </a>
    <form method="POST" action="{{ route('logout') }}" style="display:contents">
      @csrf
      <button type="submit" class="nh-mobile-user nh-mobile-logout" title="Sign out">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
          <polyline points="16 17 21 12 16 7" />
          <line x1="21" x2="9" y1="12" y2="12" />
        </svg>
      </button>
    </form>
    @endguest
    <button class="nh-mobile-burger" onclick="openDrawer()" aria-label="Open menu">
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M3 4h18v2H3V4zm4 7h14v2H7v-2zm-4 7h18v2H3v-2z" />
      </svg>
    </button>
  </div>
</header>

{{-- ════════════════════════════════════════════
     MOBILE SECOND NAV — persistent Search + AI Search
════════════════════════════════════════════ --}}
<div class="nh-mobile-searchbar d-flex d-lg-none">
  <form class="nh-mobile-search-pill" id="nh-search-pill-mobile"
    action="{{ route('front.search') }}" method="GET">

    <select name="category" id="nh-cat-select-mobile" class="nh-mobile-search-select" aria-label="Filter by service">
      <option value="">All</option>
    </select>

    <input type="text" name="q" id="nh-q-mobile"
      placeholder="Search properties, agents…"
      autocomplete="off"
      aria-label="Search">

    <button type="submit" class="nh-mobile-search-pill-btn" aria-label="Submit search">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <circle cx="11" cy="11" r="8" />
        <path d="m21 21-4.35-4.35" />
      </svg>
    </button>
  </form>

  <a href="{{ Route::has('front.ai.search.index') ? route('front.ai.search.index') : '#' }}" class="nh-mobile-ai-btn">
    <svg viewBox="0 0 24 24" fill="currentColor">
      <path d="M12 2l1.8 5.2L19 9l-5.2 1.8L12 16l-1.8-5.2L5 9l5.2-1.8L12 2zM19 13l.9 2.6L22.5 16.5l-2.6.9L19 20l-.9-2.6-2.6-.9 2.6-.9L19 13z" />
    </svg>
    <span>AI Search</span>
  </a>
</div>
<div class="nh-spacer-mobile d-block d-lg-none"></div>

<div class="nh-drawer-overlay" id="nh-overlay" onclick="closeDrawer()"></div>

{{-- Mobile Drawer --}}
<div class="nh-drawer" id="nh-drawer">
  <div class="nh-drawer-head">
    <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="{{ config('app.name') }}">
    <button class="nh-drawer-close" onclick="closeDrawer()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 6L6 18M6 6l12 12" />
      </svg>
    </button>
  </div>

  <nav class="nh-drawer-nav">

    <a href="{{ route('front.home') }}" class="nh-drawer-link">Home</a>
    <a href="{{ route('property-request.create') }}" class="nh-drawer-link">Request a Property</a>

    <div class="nh-drawer-divider"></div>

    <div class="nh-drawer-lang-row">
      <a href="{{ Route::has('locale.switch') ? route('locale.switch', 'en') : '#' }}" class="nh-drawer-lang-item {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
      <a href="{{ Route::has('locale.switch') ? route('locale.switch', 'rw') : '#' }}" class="nh-drawer-lang-item {{ app()->getLocale() === 'rw' ? 'active' : '' }}">RW</a>
      <a href="{{ Route::has('locale.switch') ? route('locale.switch', 'fr') : '#' }}" class="nh-drawer-lang-item {{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
    </div>

  </nav>

  <div class="nh-drawer-foot">
    @guest
    <a href="{{ route('login') }}" class="nh-drawer-signin">
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
      </svg>
      Sign In
    </a>
    @else
    <a href="{{ route(auth()->user()->redirectRoute()) }}" class="nh-drawer-signin">
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
      </svg>
      {{ auth()->user()->name }}
    </a>
    @endguest
  </div>
</div>

<script>
  // ── Scroll: shadow + header compression ──
  const nhBar = document.getElementById('nh-bar');
  window.addEventListener('scroll', () => {
    nhBar?.classList.toggle('scrolled', window.scrollY > 60);
  });

  // ── Mobile drawer ──
  window.openDrawer = () => {
    document.getElementById('nh-drawer').classList.add('open');
    document.getElementById('nh-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
  };
  window.closeDrawer = () => {
    document.getElementById('nh-drawer').classList.remove('open');
    document.getElementById('nh-overlay').classList.remove('open');
    document.body.style.overflow = '';
  };

  // ── Language dropdown (desktop) ──
  window.nhToggleLang = (id) => {
    const el = document.getElementById(id);
    const isOpen = el.classList.contains('open');
    document.querySelectorAll('.nh-lang.open').forEach(l => l.classList.remove('open'));
    if (!isOpen) el.classList.add('open');
  };
  document.addEventListener('click', (e) => {
    document.querySelectorAll('.nh-lang.open').forEach(l => {
      if (!l.contains(e.target)) l.classList.remove('open');
    });
  });

  // ── Dynamic category dropdown: fetch services/categories ──
  // NOTE: adjust this endpoint to whatever returns your list of services/property
  // categories as JSON, e.g. [{ "id": 1, "name": "Houses for Sale", "slug": "houses-sale" }, ...]
  (function loadSearchCategories() {
    const endpoint = '{{ Route::has('front.search.categories') ? route('front.search.categories') : '' }}';
    if (!endpoint) return;
    fetch(endpoint, { headers: { 'Accept': 'application/json' } })
      .then(r => r.ok ? r.json() : Promise.reject(r.status))
      .then(data => {
        const items = Array.isArray(data) ? data : (data.data || []);
        const selects = [
          document.getElementById('nh-cat-select-desktop'),
          document.getElementById('nh-cat-select-mobile')
        ];
        selects.forEach(sel => {
          if (!sel) return;
          items.forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.slug ?? item.id;
            opt.textContent = item.name ?? item.title;
            sel.appendChild(opt);
          });
        });
      })
      .catch(() => {
        // Silently keep the default "All" option if the endpoint isn't reachable
      });
  })();

  // ── Escape closes drawer ──
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
      closeDrawer();
      document.querySelectorAll('.nh-lang.open').forEach(l => l.classList.remove('open'));
    }
  });
</script>