<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

  :root {
    --gold: #C8873A;
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
    transition: box-shadow var(--t);
  }

  .nh-bar.scrolled {
    box-shadow: 0 4px 24px rgba(0, 0, 0, .12);
  }

  .nh-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 24px;
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    height: 68px;
  }

  .nh-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 20px;
  }

  .nh-logo img {
    height: 36px;
    width: auto;
    display: block;
  }

  /* ── Nav links ── */
  .nh-item {
    position: relative;
    list-style: none;
  }

  .nh-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: .82rem;
    font-weight: 700;
    color: var(--navy);
    cursor: pointer;
    white-space: nowrap;
    transition: color var(--t), background var(--t);
    text-decoration: none;
    border: none;
    background: none;
    font-family: 'DM Sans', sans-serif;
  }

  .nh-link:hover,
  .nh-link.active {
    color: var(--orange);
    background: rgba(208, 82, 8, .05);
  }

  .nh-link svg {
    width: 11px;
    height: 11px;
    transition: transform var(--t);
    flex-shrink: 0;
  }

  .nh-item:hover .nh-link svg {
    transform: rotate(180deg);
  }

  /* ── Sign In btn ── */
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
    margin-left: 6px;
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
     DROPDOWN — gap fix
     Key: top:100% (flush), pseudo-element bridge fills any sub-pixel gap,
     initial translateY is small (4px not 8px) so animation starts close
  ══════════════════════════════════════ */
  .nh-item {
    position: relative;
  }

  /* Invisible bridge between button bottom and dropdown top */
  .nh-item::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    height: 8px;
    /* covers any gap */
    display: none;
  }

  .nh-item:hover::after {
    display: block;
  }

  .nh-dropdown {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(4px);
    background: var(--navy);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 12px;
    min-width: 220px;
    padding: 8px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity var(--t), transform var(--t), visibility var(--t);
    box-shadow: 0 20px 48px rgba(0, 0, 0, .3);
    /* Extra top padding so first item isn't right at the edge */
    padding-top: 10px;
  }

  .nh-item:hover .nh-dropdown {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateX(-50%) translateY(0);
  }

  /* Right-aligned dropdowns (Rent, Sell, Updates) */
  .nh-dropdown-right {
    position: absolute;
    top: 100%;
    left: auto;
    right: 0;
    transform: translateY(4px);
    background: var(--navy);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 12px;
    min-width: 220px;
    padding: 10px 8px 8px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity var(--t), transform var(--t), visibility var(--t);
    box-shadow: 0 20px 48px rgba(0, 0, 0, .3);
  }

  .nh-item:hover .nh-dropdown-right {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0);
  }

  .nh-drop-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: .81rem;
    color: rgba(255, 255, 255, .65);
    font-weight: 500;
    transition: color var(--t), background var(--t);
    text-decoration: none;
    white-space: nowrap;
    width: 100%;
    border: none;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    background: none;
    text-align: left;
  }

  .nh-drop-item:hover {
    color: #fff;
    background: rgba(255, 255, 255, .1);
  }

  .nh-drop-item svg {
    width: 14px;
    height: 14px;
    color: var(--gold);
    flex-shrink: 0;
  }

  .nh-drop-divider {
    height: 1px;
    background: rgba(255, 255, 255, .1);
    margin: 6px 0;
  }

  /* ══════════════════════════════════════
     MEGA MENU
  ══════════════════════════════════════ */
  .nh-mega-item {
    position: static;
  }

  .nh-mega {
    position: absolute;
    top: 68px;
    left: 0;
    right: 0;
    background: var(--navy);
    border-top: 1px solid rgba(255, 255, 255, .08);
    border-bottom: 1px solid rgba(255, 255, 255, .08);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(-4px);
    transition: opacity var(--t), transform var(--t), visibility var(--t);
    box-shadow: 0 20px 48px rgba(0, 0, 0, .25);
  }

  .nh-bar .nh-mega-item:hover .nh-mega {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0);
  }

  .nh-mega-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 28px 24px;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr;
    gap: 40px;
  }

  .nh-mega-col-title {
    font-size: .64rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, .3);
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255, 255, 255, .1);
  }

  .nh-mega-link {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 10px 12px;
    border-radius: 9px;
    font-size: .83rem;
    color: rgba(255, 255, 255, .65);
    font-weight: 500;
    transition: color var(--t), background var(--t);
    text-decoration: none;
    margin-bottom: 2px;
    width: 100%;
    border: none;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    background: none;
    text-align: left;
  }

  .nh-mega-link:hover {
    color: #fff;
    background: rgba(255, 255, 255, .08);
  }

  .nh-mega-link .ml-icon {
    width: 30px;
    height: 30px;
    border-radius: 7px;
    background: rgba(200, 135, 58, .12);
    border: 1px solid rgba(200, 135, 58, .3);
    display: grid;
    place-items: center;
    flex-shrink: 0;
  }

  .nh-mega-link .ml-icon svg {
    width: 13px;
    height: 13px;
    color: var(--gold);
  }

  .nh-mega-link .ml-text strong {
    display: block;
    font-size: .82rem;
    color: #fff;
  }

  .nh-mega-link .ml-text span {
    font-size: .72rem;
    color: rgba(255, 255, 255, .35);
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
    padding: 0 20px;
    justify-content: space-between;
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
    padding: 12px;
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

  .nh-drawer-link svg {
    width: 14px;
    height: 14px;
    transition: transform var(--t);
    flex-shrink: 0;
  }

  .nh-drawer-link.open svg {
    transform: rotate(180deg);
  }

  .nh-drawer-sub {
    display: none;
    padding: 4px 0 6px 12px;
  }

  .nh-drawer-sub.open {
    display: block;
  }

  .nh-drawer-sub-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 7px;
    font-size: .8rem;
    color: rgba(255, 255, 255, .45);
    font-weight: 500;
    transition: color var(--t), background var(--t);
    text-decoration: none;
    width: 100%;
    border: none;
    background: none;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    text-align: left;
  }

  .nh-drawer-sub-item:hover {
    color: #fff;
    background: rgba(255, 255, 255, .06);
  }

  .nh-drawer-sub-item svg {
    width: 12px;
    height: 12px;
    color: var(--gold);
    flex-shrink: 0;
  }

  .nh-drawer-divider {
    height: 1px;
    background: rgba(255, 255, 255, .07);
    margin: 8px 0;
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

  .nh-drawer-contact {
    display: flex;
    gap: 8px;
  }

  .nh-drawer-contact a {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px;
    border-radius: 9px;
    border: 1px solid rgba(255, 255, 255, .12);
    background: rgba(255, 255, 255, .06);
    font-size: .75rem;
    color: rgba(255, 255, 255, .55);
    font-weight: 500;
    transition: all var(--t);
  }

  .nh-drawer-contact a:hover {
    border-color: var(--gold);
    color: var(--gold);
  }

  .nh-drawer-contact svg {
    width: 13px;
    height: 13px;
  }

  /* ══════════════════════════════════════
     MODALS
  ══════════════════════════════════════ */
  .nh-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: #19265d61;
    backdrop-filter: blur(6px);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }

  .nh-modal-overlay.open {
    display: flex;
  }

  .nh-modal-box {
    background: #111110;
    border: 1px solid rgba(255, 255, 255, .1);
    border-radius: 16px;
    width: 100%;
    max-width: 400px;
    overflow: hidden;
    box-shadow: 0 28px 72px rgba(0, 0, 0, .4);
    animation: nhMIn .3s ease both;
  }

  @keyframes nhMIn {
    from {
      opacity: 0;
      transform: scale(.96) translateY(8px);
    }

    to {
      opacity: 1;
      transform: none;
    }
  }

  .nh-modal-head {
    background: #19265d;
    padding: 20px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, .07);
  }

  .nh-modal-head h4 {
    font-size: .95rem;
    font-weight: 600;
    color: #F0EDE8;
    margin: 0;
  }

  .nh-modal-head p {
    font-size: .73rem;
    color: rgba(240, 237, 232, .4);
    margin-top: 2px;
  }

  .nh-modal-close {
    background: rgba(255, 255, 255, .08);
    border: none;
    border-radius: 7px;
    width: 30px;
    height: 30px;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: rgba(240, 237, 232, .5);
    transition: background var(--t);
  }

  .nh-modal-close:hover {
    background: rgba(255, 255, 255, .16);
    color: #F0EDE8;
  }

  .nh-modal-close svg {
    width: 15px;
    height: 15px;
  }

  .nh-modal-body {
    padding: 20px 22px;
  }

  .nh-modal-field {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 14px;
  }

  .nh-modal-field label {
    font-size: .7rem;
    font-weight: 600;
    letter-spacing: .07em;
    text-transform: uppercase;
    color: rgba(240, 237, 232, .35);
  }

  .nh-modal-field input,
  .nh-modal-field textarea {
    padding: 10px 13px;
    background: rgba(255, 255, 255, .05);
    border: 1.5px solid rgba(255, 255, 255, .1);
    border-radius: 9px;
    font-size: .84rem;
    font-family: 'DM Sans', sans-serif;
    color: #F0EDE8;
    transition: border-color var(--t);
    width: 100%;
  }

  .nh-modal-field input::placeholder,
  .nh-modal-field textarea::placeholder {
    color: rgba(240, 237, 232, .2);
  }

  .nh-modal-field input:focus,
  .nh-modal-field textarea:focus {
    outline: none;
    border-color: var(--gold);
  }

  .nh-modal-field textarea {
    resize: vertical;
    min-height: 80px;
  }

  .nh-modal-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 12px 16px;
    border-radius: 9px;
    background: var(--gold);
    border: none;
    color: #fff;
    font-size: .85rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background var(--t);
  }

  .nh-modal-submit:hover {
    background: #a06828;
  }

  .nh-modal-submit svg {
    width: 14px;
    height: 14px;
  }

  .nh-spacer-desktop {
    height: 68px;
  }

  .nh-spacer-mobile {
    height: 60px;
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

    {{-- ── LEFT NAV ── --}}
    <nav style="display:flex;align-items:center;gap:2px;list-style:none;margin:0;padding:0">

      <a href="{{ route('front.home') }}" class="nh-link">Home</a>

      {{-- Agents & Consultants — mega --}}
      <div class="nh-item nh-mega-item" style="position:static">
        <button class="nh-link">
          Agents &amp; Consultants
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 10l5 5 5-5z" />
          </svg>
        </button>
        <div class="nh-mega">
          <div class="nh-mega-inner">
            <div>
              <div class="nh-mega-col-title">Find a Professional</div>
              <a href="{{ route('front.agents') }}" class="nh-mega-link">
                <span class="ml-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                  </svg></span>
                <span class="ml-text"><strong>Real Estate Agents</strong><span>Browse verified agents across Rwanda</span></span>
              </a>
              <a href="{{ route('front.consultants.index') }}" class="nh-mega-link">
                <span class="ml-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
                  </svg></span>
                <span class="ml-text"><strong>Real Estate Consultants</strong><span>Get expert advice &amp; guidance</span></span>
              </a>
            </div>
            <div>
              <div class="nh-mega-col-title">Join as a Pro</div>
              <a href="{{ route('front.agents.register') }}" class="nh-mega-link">
                <span class="ml-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
                  </svg></span>
                <span class="ml-text"><strong>Become an Agent</strong><span>Create your agent profile</span></span>
              </a>
              <a href="{{ route('consultant.become') }}" class="nh-mega-link">
                <span class="ml-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
                  </svg></span>
                <span class="ml-text"><strong>Become a Consultant</strong><span>Register your expertise</span></span>
              </a>
            </div>
            <div>
              <div class="nh-mega-col-title">Work with a Pro</div>
              <button onclick="openModal('consult-modal')" class="nh-mega-link">
                <span class="ml-icon"><svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                  </svg></span>
                <span class="ml-text"><strong>Request a Consultant</strong><span>Describe your needs</span></span>
              </button>
            </div>
          </div>
        </div>
      </div>

      {{-- Buy --}}
      <div class="nh-item">
        <button class="nh-link">Buy <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 10l5 5 5-5z" />
          </svg></button>
        <div class="nh-dropdown">
          <a href="{{ route('front.buy.homes') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
            </svg>Houses for Sale
          </a>
          <a href="{{ route('front.buy.lands') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c-.21.07-.36.25-.36.48V3.5c0-.28-.22-.5-.5-.5z" />
            </svg>Lands for Sale
          </a>
          <a href="{{ route('front.buy.design') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
            </svg>Architectural Designs
          </a>
        </div>
      </div>

    </nav>

    {{-- ── CENTER LOGO ── --}}
    <div class="nh-logo">
      <a href="{{ route('front.home') }}">
        <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="{{ config('app.name') }}">
      </a>
    </div>

    {{-- ── RIGHT NAV ── --}}
    <nav style="display:flex;align-items:center;justify-content:flex-end;gap:2px;list-style:none;margin:0;padding:0">

      {{-- Rent --}}
      <div class="nh-item">
        <button class="nh-link">Rent <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 10l5 5 5-5z" />
          </svg></button>
        <div class="nh-dropdown-right">
          <a href="{{ route('front.rent.homes') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
            </svg>Houses for Rent
          </a>
          <a href="{{ route('front.rent.apartments') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4z" />
            </svg>Apartments for Rent
          </a>
          <a href="{{ route('front.rent.short-stays') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
            </svg>Short-Term Stays
          </a>
          <div class="nh-drop-divider"></div>
          <button onclick="openModal('near-me-modal')" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
            </svg>Rent Near Me
          </button>
        </div>
      </div>

      {{-- Sell --}}
      <div class="nh-item">
        <button class="nh-link">Sell <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 10l5 5 5-5z" />
          </svg></button>
        <div class="nh-dropdown-right">
          <a href="{{ route('front.add.property.house') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
            </svg>List Your House
          </a>
          <a href="{{ route('front.add.property.land') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c-.21.07-.36.25-.36.48V3.5c0-.28-.22-.5-.5-.5z" />
            </svg>List Your Land
          </a>
          <a href="{{ route('front.add.property.arch') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
            </svg>List a Design
          </a>
        </div>
      </div>

      {{-- Updates --}}
      <div class="nh-item">
        <button class="nh-link">Updates <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 10l5 5 5-5z" />
          </svg></button>
        <div class="nh-dropdown-right">
          <a href="{{ route('front.ads.index') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M3 3h18v18H3V3zm2 2v14h14V5H5z" />
            </svg>Advertisements
          </a>
          <a href="{{ route('front.news.index') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
            </svg>News
          </a>
          <a href="{{ route('front.tenders.index') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
            </svg>Tenders
          </a>
          <a href="{{ route('front.jobs.index') }}" class="nh-drop-item">
            <svg viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 6h-2.18c.07-.44.18-.86.18-1.3C18 2.56 15.44 1 12.76 1c-1.56 0-3.04.59-4.14 1.67L7 4H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2z" />
            </svg>Jobs
          </a>
        </div>
      </div>

      <a href="{{ route('front.contact') }}" class="nh-link">Help</a>

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

          {{-- User info --}}
          <li>
            <div class="px-3 py-2">
              <div class="fw-600 text-dark" style="font-size:.85rem">{{ auth()->user()->name }}</div>
              <div class="text-muted" style="font-size:.75rem">{{ auth()->user()->email }}</div>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          {{-- Dashboard --}}
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

          <li>
            <hr class="dropdown-divider">
          </li>

          {{-- Logout --}}
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"
                class="dropdown-item d-flex align-items-center gap-2 text-danger">
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

    </nav>
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

    <button class="nh-mobile-burger" onclick="openDrawer()">
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M3 4h18v2H3V4zm4 7h14v2H7v-2zm-4 7h18v2H3v-2z" />
      </svg>
    </button>
  </div>
</header>
<div class="nh-spacer-mobile d-block d-lg-none"></div>

<div class="nh-drawer-overlay" id="nh-overlay" onclick="closeDrawer()"></div>

{{-- Mobile Drawer --}}
<div class="nh-drawer" id="nh-drawer">
  <div class="nh-drawer-head">
    <img src="{{ asset('front/assets/img/logo/logo-white.png') }}" alt="{{ config('app.name') }}">
    <button class="nh-drawer-close" onclick="closeDrawer()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 6L6 18M6 6l12 12" />
      </svg>
    </button>
  </div>
  <nav class="nh-drawer-nav">
    <a href="{{ route('front.home') }}" class="nh-drawer-link">Home</a>
    <div class="nh-drawer-divider"></div>

    <button class="nh-drawer-link" onclick="toggleSub('sub-agents', this)">Agents &amp; Consultants <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M7 10l5 5 5-5z" />
      </svg></button>
    <div class="nh-drawer-sub" id="sub-agents">
      <a href="{{ route('front.agents') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
        </svg>Real Estate Agents</a>
      <a href="{{ route('front.consultants.index') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z" />
        </svg>Real Estate Consultants</a>
      <a href="{{ route('front.agents.register') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
        </svg>Become an Agent</a>
      <a href="{{ route('consultant.become') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z" />
        </svg>Become a Consultant</a>
    </div>

    <button class="nh-drawer-link" onclick="toggleSub('sub-buy', this)">Buy <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M7 10l5 5 5-5z" />
      </svg></button>
    <div class="nh-drawer-sub" id="sub-buy">
      <a href="{{ route('front.buy.homes') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
        </svg>Houses for Sale</a>
      <a href="{{ route('front.buy.lands') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c-.21.07-.36.25-.36.48V3.5c0-.28-.22-.5-.5-.5z" />
        </svg>Lands for Sale</a>
      <a href="{{ route('front.buy.design') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
        </svg>Architectural Designs</a>
    </div>

    <button class="nh-drawer-link" onclick="toggleSub('sub-rent', this)">Rent <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M7 10l5 5 5-5z" />
      </svg></button>
    <div class="nh-drawer-sub" id="sub-rent">
      <a href="{{ route('front.rent.homes') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
        </svg>Houses for Rent</a>
      <a href="{{ route('front.rent.apartments') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M17 11V3H7v4H3v14h8v-4h2v4h8V11h-4z" />
        </svg>Apartments for Rent</a>
      <a href="{{ route('front.rent.short-stays') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
        </svg>Short-Term Stays</a>
      <button onclick="closeDrawer();openModal('near-me-modal')" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
        </svg>Rent Near Me</button>
    </div>

    <button class="nh-drawer-link" onclick="toggleSub('sub-sell', this)">Sell <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M7 10l5 5 5-5z" />
      </svg></button>
    <div class="nh-drawer-sub" id="sub-sell">
      <a href="{{ route('front.add.property.house') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
        </svg>List Your House</a>
      <a href="{{ route('front.add.property.land') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c-.21.07-.36.25-.36.48V3.5c0-.28-.22-.5-.5-.5z" />
        </svg>List Your Land</a>
      <a href="{{ route('front.add.property.arch') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
        </svg>List a Design</a>
    </div>

    <button class="nh-drawer-link" onclick="toggleSub('sub-updates', this)">Updates <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M7 10l5 5 5-5z" />
      </svg></button>
    <div class="nh-drawer-sub" id="sub-updates">
      <a href="{{ route('front.ads.index') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M3 3h18v18H3V3zm2 2v14h14V5H5z" />
        </svg>Advertisements</a>
      <a href="{{ route('front.news.index') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
        </svg>News</a>
      <a href="{{ route('front.tenders.index') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
        </svg>Tenders</a>
      <a href="{{ route('front.jobs.index') }}" class="nh-drawer-sub-item"><svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
        </svg>Jobs</a>
    </div>

    <div class="nh-drawer-divider"></div>
    <a href="{{ route('front.contact') }}" class="nh-drawer-link">Get Help</a>
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
    <div class="nh-drawer-contact">
      <a href="tel:+250796511725">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
        </svg>
        Call Us
      </a>
      <a href="https://wa.me/250796511725" target="_blank">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
          <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
        </svg>
        WhatsApp
      </a>
    </div>
  </div>
</div>

{{-- MODALS --}}
<div class="nh-modal-overlay" id="near-me-modal" onclick="closeModalOnBg(event,'near-me-modal')">
  <div class="nh-modal-box">
    <div class="nh-modal-head">
      <div>
        <h4>Find Rentals Near You</h4>
        <p>Enter your preferred area in Rwanda</p>
      </div>
      <button class="nh-modal-close" onclick="closeModal('near-me-modal')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M18 6L6 18M6 6l12 12" />
        </svg>
      </button>
    </div>
    <form action="{{ route('rent.search.near.me') }}" method="GET">
      <div class="nh-modal-body">
        <div class="nh-modal-field">
          <label>Area / Neighbourhood</label>
          <input type="text" name="area" placeholder="e.g. Kacyiru, Remera, Nyarugenge" required>
        </div>
        <button type="submit" class="nh-modal-submit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.35-4.35" />
          </svg>
          Search Rentals
        </button>
      </div>
    </form>
  </div>
</div>

<div class="nh-modal-overlay" id="consult-modal" onclick="closeModalOnBg(event,'consult-modal')">
  <div class="nh-modal-box">
    <div class="nh-modal-head">
      <div>
        <h4>Request a Consultant</h4>
        <p>Describe what you need help with</p>
      </div>
      <button class="nh-modal-close" onclick="closeModal('consult-modal')">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M18 6L6 18M6 6l12 12" />
        </svg>
      </button>
    </div>
    <form method="POST" action="#">
      @csrf
      <div class="nh-modal-body">
        <div class="nh-modal-field">
          <label>Your Name</label>
          <input type="text" name="name" placeholder="e.g. Amina Uwimana" required>
        </div>
        <div class="nh-modal-field">
          <label>Phone / Email</label>
          <input type="text" name="contact" placeholder="+250 7XX XXX XXX" required>
        </div>
        <div class="nh-modal-field">
          <label>What do you need?</label>
          <textarea name="message" placeholder="Briefly describe your property or consultation need…"></textarea>
        </div>
        <button type="submit" class="nh-modal-submit">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
          </svg>
          Send Request
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  window.addEventListener('scroll', () => {
    document.getElementById('nh-bar')?.classList.toggle('scrolled', window.scrollY > 20);
  });
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
  window.toggleSub = function(id, btn) {
    const sub = document.getElementById(id);
    const isOpen = sub.classList.contains('open');
    document.querySelectorAll('.nh-drawer-sub').forEach(s => s.classList.remove('open'));
    document.querySelectorAll('.nh-drawer-link').forEach(b => b.classList.remove('open'));
    if (!isOpen) {
      sub.classList.add('open');
      btn.classList.add('open');
    }
  };
  window.openModal = id => {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
  };
  window.closeModal = id => {
    document.getElementById(id).classList.remove('open');
    document.body.style.overflow = '';
  };
  window.closeModalOnBg = (e, id) => {
    if (e.target === document.getElementById(id)) closeModal(id);
  };
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.querySelectorAll('.nh-modal-overlay.open').forEach(m => {
      m.classList.remove('open');
      document.body.style.overflow = '';
    });
  });
</script>