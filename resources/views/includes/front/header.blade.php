@php
$serviceCategories = \App\Models\ServiceCategory::with(['subcategories.services'])
->where('is_active', 1)
->orderBy('name')
->get();

$materialCategories = \App\Models\MaterialCategory::with('materialSubcategories')
->where('is_active', 1)
->orderBy('name')
->get();

$consultancyItems = collect(config('consultancy', [
['slug' => 'buying-advice', 'name' => 'Property Buying Advice'],
['slug' => 'rental-advice', 'name' => 'Rental Advice'],
['slug' => 'investment-advice', 'name' => 'Investment Advice'],
['slug' => 'price-guidance', 'name' => 'Market Price Guidance'],
['slug' => 'location-analysis', 'name' => 'Location Analysis'],
]));

$shopLocations = \App\Models\Shop::where('status', 'approved')
->orderBy('name')
->get()
->groupBy('province')
->map(function ($shops) {
return $shops->groupBy('district');
});

// Property Management page  →  /terra/property-management  (route name: terra.home)
$pmUrl = Route::has('terra.home') ? route('terra.home') : '#';
$pmActive = request()->routeIs('terra.home');

@endphp

<style>
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;400;500;700&display=swap');

  :root {
    --gold: #D05208;
    --gold-bg: rgba(208, 82, 8, .08);
    --gold-bd: rgba(208, 82, 8, .22);
    --dark: #19265d;
    --dark2: #19265d;
    --border: rgba(255, 255, 255, .08);
    --orange: #D05208;
    --orange-soft: rgba(208, 82, 8, .09);
    --navy: #19265d;
    --navy-soft: rgba(25, 38, 93, .05);
    --navy-line: rgba(25, 38, 93, .12);
    --t: .22s cubic-bezier(.4, 0, .2, 1);
  }

  /* ───────── DESKTOP BAR ───────── */
  .nh-bar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background: rgba(255, 255, 255, .92);
    backdrop-filter: saturate(160%) blur(14px);
    -webkit-backdrop-filter: saturate(160%) blur(14px);
    border-bottom: 1px solid rgba(25, 38, 93, .07);
    font-family: 'DM Sans', sans-serif;
    transition: box-shadow var(--t), border-color var(--t);
  }

  .nh-bar::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--navy) 0%, var(--navy) 55%, var(--orange) 100%);
  }

  .nh-bar.scrolled {
    box-shadow: 0 8px 30px rgba(25, 38, 93, .12);
    border-bottom-color: rgba(25, 38, 93, .1);
  }

  .nh-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    display: grid;
    grid-template-columns: auto auto 1fr auto;
    align-items: center;
    gap: 16px;
    height: 70px;
    transition: height .3s cubic-bezier(.4, 0, .2, 1);
  }

  .nh-bar.scrolled .nh-inner {
    height: 60px;
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

  /* Explore button */
  .nh-all-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 42px;
    padding: 0 16px;
    border-radius: 12px;
    border: 1px solid var(--navy-line);
    background: var(--navy-soft);
    color: var(--navy);
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    flex-shrink: 0;
    transition: border-color var(--t), background var(--t), color var(--t), transform var(--t);
  }

  .nh-all-btn:hover {
    border-color: var(--orange);
    background: var(--orange-soft);
    color: var(--orange);
    transform: translateY(-1px);
  }

  .nh-all-btn svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
  }

  /* Outline + solid buttons */
  .nh-link-rst,
  .nh-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    height: 40px;
    padding: 0 16px;
    border-radius: 12px;
    font-size: .82rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    cursor: pointer;
    white-space: nowrap;
    transition: background var(--t), border-color var(--t), color var(--t), transform var(--t), box-shadow var(--t);
  }

  .nh-link-rst {
    background: #fff;
    color: var(--navy) !important;
    border: 1.5px solid var(--navy);
  }

  .nh-link-rst:hover {
    background: var(--orange);
    border-color: var(--orange);
    transform: translateY(-1px);
    color: #fff !important;
  }

  .nh-btn {
    background: var(--navy);
    color: #fff !important;
    border: 1.5px solid var(--navy);
    box-shadow: 0 4px 14px rgba(25, 38, 93, .18);
  }

  .nh-btn:hover {
    background: var(--orange);
    border-color: var(--orange);
    transform: translateY(-1px);
    color: #fff;
    box-shadow: 0 6px 18px rgba(208, 82, 8, .28);
  }

  .nh-btn svg {
    width: 13px;
    height: 13px;
  }

  /* ★ NEW — Property Management link (desktop) */
  .nh-link-pm {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    height: 40px;
    padding: 0 14px;
    border-radius: 12px;
    background: var(--orange-soft);
    border: 1.5px solid var(--gold-bd);
    color: var(--orange) !important;
    font-size: .82rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    white-space: nowrap;
    transition: background var(--t), color var(--t), transform var(--t), box-shadow var(--t);
  }

  .nh-link-pm svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
  }

  .nh-link-pm:hover,
  .nh-link-pm.is-active {
    background: var(--orange);
    color: #fff !important;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(208, 82, 8, .28);
  }

  @media (max-width: 1199.98px) {
    .nh-link-pm .nh-pm-label {
      display: none;
    }

    .nh-link-pm {
      width: 40px;
      padding: 0;
      justify-content: center;
    }
  }

  /* Search */
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
    border-radius: 24px;
    border: 1.5px solid var(--navy-line);
    background: var(--navy-soft);
    overflow: hidden;
    box-shadow: 0 2px 14px rgba(25, 38, 93, .06);
    transition: border-color var(--t), box-shadow var(--t), background var(--t);
  }

  .nh-search-pill:focus-within {
    border-color: var(--orange);
    background: #fff;
    box-shadow: 0 4px 20px rgba(208, 82, 8, .15);
  }

  .nh-search-select {
    height: 100%;
    border: none;
    outline: none;
    background: rgba(25, 38, 93, .06);
    color: var(--navy);
    font-family: 'DM Sans', sans-serif;
    font-size: .76rem;
    font-weight: 700;
    padding: 0 10px;
    max-width: 118px;
    border-right: 1px solid var(--navy-line);
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
    padding: 0 12px;
  }

  .nh-search-pill input[type="text"]::placeholder {
    color: rgba(25, 38, 93, .38);
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
    margin-right: 5px;
    flex-shrink: 0;
    transition: background var(--t), transform var(--t);
  }

  .nh-search-pill-btn:hover {
    background: var(--navy);
    transform: scale(1.06);
  }

  .nh-search-pill-btn svg {
    width: 13px;
    height: 13px;
  }

  .nh-ai-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    height: 42px;
    padding: 0 16px;
    border-radius: 24px;
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
    box-shadow: 0 4px 14px rgba(25, 38, 93, .2);
    transition: transform var(--t), box-shadow var(--t), background var(--t);
  }

  .nh-ai-btn:hover {
    background: linear-gradient(135deg, var(--orange), #f07a2e);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(208, 82, 8, .3);
    color: #fff;
  }

  .nh-ai-btn svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
  }

  /* Language */
  .nh-lang {
    position: relative;
  }

  .nh-lang-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    height: 40px;
    padding: 0 12px;
    border-radius: 12px;
    border: 1.5px solid var(--navy-line);
    background: #fff;
    color: var(--navy);
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem;
    font-weight: 700;
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
    margin-top: 8px;
    background: var(--navy);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 12px;
    min-width: 150px;
    padding: 6px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(4px);
    transition: opacity var(--t), transform var(--t), visibility var(--t);
    box-shadow: 0 18px 44px rgba(0, 0, 0, .28);
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
    padding: 9px 10px;
    border-radius: 8px;
    border: none;
    background: none;
    color: rgba(255, 255, 255, .68);
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
    color: #ffb27a;
  }

  .nh-right-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    justify-content: flex-end;
  }

  /* ───────── MOBILE BAR ───────── */
  .nh-mobile {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background: rgba(255, 255, 255, .94);
    backdrop-filter: saturate(160%) blur(14px);
    -webkit-backdrop-filter: saturate(160%) blur(14px);
    border-bottom: 1px solid rgba(25, 38, 93, .07);
    border-top: 3px solid var(--navy);
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
    width: 36px;
    height: 36px;
    border-radius: 12px;
    background: transparent;
    border: 1.5px solid var(--navy);
    display: grid;
    place-items: center;
    color: var(--navy);
    text-decoration: none;
    transition: background var(--t), color var(--t), border-color var(--t);
  }

  .nh-mobile-user:hover {
    background: var(--navy);
    color: #fff;
  }

  .nh-mobile-user svg {
    width: 16px;
    height: 16px;
  }

  /* ★ NEW — Property Management (mobile icon) */
  .nh-mobile-pm {
    background: var(--orange-soft);
    border-color: var(--gold-bd);
    color: var(--orange);
  }

  .nh-mobile-pm:hover,
  .nh-mobile-pm.is-active {
    background: var(--orange);
    border-color: var(--orange);
    color: #fff;
  }

  .nh-mobile-burger {
    width: 36px;
    height: 36px;
    border-radius: 12px;
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

  .nh-mobile-searchbar {
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    z-index: 998;
    background: rgba(255, 255, 255, .96);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(25, 38, 93, .07);
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-family: 'DM Sans', sans-serif;
  }

  .nh-mobile-all-btn {
    width: 40px;
    height: 40px;
    min-width: 40px;
    border-radius: 20px;
    border: 1.5px solid var(--navy-line);
    background: var(--navy-soft);
    display: grid;
    place-items: center;
    cursor: pointer;
    color: var(--navy);
    flex-shrink: 0;
    transition: border-color var(--t), background var(--t), color var(--t);
  }

  .nh-mobile-all-btn:hover,
  .nh-mobile-all-btn:active {
    border-color: var(--orange);
    background: var(--orange-soft);
    color: var(--orange);
  }

  .nh-mobile-all-btn svg {
    width: 17px;
    height: 17px;
  }

  .nh-mobile-search-pill {
    flex: 1;
    min-width: 0;
    display: flex;
    align-items: center;
    height: 40px;
    border-radius: 20px;
    border: 1.5px solid var(--navy-line);
    background: var(--navy-soft);
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
    background: rgba(25, 38, 93, .06);
    color: var(--navy);
    font-family: 'DM Sans', sans-serif;
    font-size: .7rem;
    font-weight: 700;
    padding: 0 8px;
    max-width: 76px;
    border-right: 1px solid var(--navy-line);
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
    color: rgba(25, 38, 93, .38);
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
    .nh-mobile-ai-btn span {
      display: none;
    }

    .nh-mobile-ai-btn {
      padding: 0 11px;
    }
  }

  /* ───────── MOBILE DRAWER ───────── */
  .nh-drawer {
    position: fixed;
    top: 0;
    right: -100%;
    bottom: 0;
    z-index: 1100;
    width: min(320px, 90vw);
    background: linear-gradient(180deg, var(--navy) 0%, #121c47 100%);
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
    border-radius: 10px;
    background: rgba(255, 255, 255, .1);
    border: none;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: #fff;
    transition: background var(--t);
  }

  .nh-drawer-close:hover {
    background: var(--orange);
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
    padding: 12px 12px;
    border-radius: 10px;
    font-size: .86rem;
    font-weight: 500;
    color: rgba(255, 255, 255, .7);
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

  /* ★ NEW — Property Management (drawer) */
  .nh-drawer-link--pm {
    justify-content: flex-start;
    gap: 10px;
    color: #fff;
    font-weight: 700;
    background: rgba(208, 82, 8, .22);
    border: 1px solid rgba(208, 82, 8, .45);
  }

  .nh-drawer-link--pm:hover {
    background: var(--orange);
  }

  .nh-drawer-link--pm svg {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
  }

  .nh-drawer-arrow {
    width: 14px;
    height: 14px;
    min-width: 14px;
    flex-shrink: 0;
    transition: transform .2s cubic-bezier(.4, 0, .2, 1);
  }

  .nh-drawer-link.expanded .nh-drawer-arrow {
    transform: rotate(180deg);
  }

  .nh-drawer-sub {
    max-height: 0;
    overflow: hidden;
    transition: max-height .25s cubic-bezier(.4, 0, .2, 1);
    padding-left: 8px;
  }

  .nh-drawer-sub.open {
    max-height: 1400px;
  }

  .nh-drawer-sub-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: .8rem;
    font-weight: 500;
    color: rgba(255, 255, 255, .62);
    text-decoration: none;
    transition: color var(--t), background var(--t);
  }

  .nh-drawer-sub-item:hover {
    background: rgba(255, 255, 255, .06);
    color: #fff;
  }

  .nh-drawer-sub-item svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    color: #ff9a57;
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
    border-color: #ff9a57;
    color: #ff9a57;
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
    padding: 12px 16px;
    border-radius: 12px;
    background: var(--orange);
    color: #fff;
    font-size: .84rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    text-decoration: none;
    transition: background var(--t), color var(--t);
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
    height: 70px;
  }

  .nh-spacer-mobile {
    height: 123px;
  }

  .nh-mobile-logout {
    color: #5a5a5a;
    transition: color .2s;
    background: none;
    cursor: pointer;
  }

  .nh-mobile-logout:hover {
    color: #e05c5c;
  }

  /* ───────── SECOND NAV BAR ───────── */
  .nh2-bar {
    background: var(--navy);
    font-family: 'DM Sans', sans-serif;
    position: relative;
    z-index: 500;
  }

  .nh2-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .nh2-menu {
    display: flex;
    align-items: center;
    gap: 2px;
  }

  .nh2-item {
    position: relative;
  }

  .nh2-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 11px;
    font-size: .8rem;
    font-weight: 600;
    color: rgba(255, 255, 255, .92);
    background: none;
    border: 1px solid transparent;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    font-family: 'DM Sans', sans-serif;
    transition: border-color var(--t), background var(--t);
    white-space: nowrap;
  }

  .nh2-link:hover,
  .nh2-item.open>.nh2-link {
    border-color: rgba(255, 255, 255, .45);
    background: rgba(255, 255, 255, .06);
    color: #fff;
  }

  .nh2-link svg {
    width: 11px;
    height: 11px;
    flex-shrink: 0;
    transition: transform var(--t);
  }

  .nh2-item.open>.nh2-link svg {
    transform: rotate(180deg);
  }

  .nh2-link.nh2-plain {
    padding: 9px 11px;
  }

  .nh2-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 220px;
    background: #fff;
    border: 1px solid rgba(25, 38, 93, .08);
    border-radius: 14px;
    box-shadow: 0 18px 44px rgba(25, 38, 93, .14);
    padding: 8px;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: translateY(6px);
    transition: opacity var(--t), transform var(--t), visibility var(--t);
  }

  .nh2-item.open>.nh2-dropdown {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateY(0);
  }

  .nh2-dropdown a {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 10px;
    border-radius: 8px;
    font-size: .82rem;
    font-weight: 500;
    color: var(--navy);
    text-decoration: none;
    transition: background var(--t), color var(--t);
  }

  .nh2-dropdown a:hover {
    background: var(--orange-soft);
    color: var(--orange);
  }

  .nh2-dropdown a svg {
    width: 15px;
    height: 15px;
    flex-shrink: 0;
    color: var(--orange);
  }

  /* ───────── SERVICES OFFCANVAS ───────── */
  .svc-overlay {
    position: fixed;
    inset: 0;
    z-index: 1199;
    background: rgba(15, 20, 40, .55);
    backdrop-filter: blur(3px);
    opacity: 0;
    visibility: hidden;
    transition: opacity var(--t), visibility var(--t);
  }

  .svc-overlay.open {
    opacity: 1;
    visibility: visible;
  }

  .svc-offcanvas {
    position: fixed;
    top: 0;
    bottom: 0;
    left: -100%;
    z-index: 1200;
    width: min(340px, 92vw);
    background: #fff;
    display: flex;
    flex-direction: column;
    font-family: 'DM Sans', sans-serif;
    box-shadow: 20px 0 60px rgba(0, 0, 0, .25);
    transition: left .32s cubic-bezier(.4, 0, .2, 1);
  }

  .svc-offcanvas.open {
    left: 0;
  }

  .svc-offcanvas-head {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 18px 18px;
    background: linear-gradient(135deg, var(--navy), #2c3d8f);
    color: #fff;
    flex-shrink: 0;
  }

  .svc-offcanvas-title {
    flex: 1;
    min-width: 0;
    font-size: .98rem;
    font-weight: 700;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .svc-offcanvas-close {
    width: 30px;
    height: 30px;
    min-width: 30px;
    border-radius: 10px;
    background: rgba(255, 255, 255, .12);
    border: none;
    display: grid;
    place-items: center;
    cursor: pointer;
    color: #fff;
    transition: background var(--t);
  }

  .svc-offcanvas-close:hover {
    background: var(--orange);
  }

  .svc-offcanvas-close svg {
    width: 15px;
    height: 15px;
  }

  .svc-offcanvas-body {
    flex: 1;
    overflow-y: auto;
  }

  .svc-cat-list {
    padding: 10px;
  }

  .svc-cat-row {
    position: relative;
    margin-bottom: 2px;
  }

  .svc-cat-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    width: 100%;
    padding: 12px 12px;
    border: none;
    background: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: .86rem;
    font-weight: 600;
    color: var(--navy);
    text-align: left;
    text-decoration: none;
    cursor: pointer;
    transition: background var(--t), color var(--t), padding-left var(--t);
  }

  .svc-cat-item:hover,
  .svc-cat-item.active {
    background: var(--orange-soft);
    color: var(--orange);
    padding-left: 15px;
  }

  .svc-cat-item svg {
    width: 14px;
    height: 14px;
    flex-shrink: 0;
    color: rgba(25, 38, 93, .35);
    transition: color var(--t);
  }

  .svc-cat-item:hover svg,
  .svc-cat-item.active svg {
    color: var(--orange);
  }

  /* ★ NEW — Property Management row (offcanvas) */
  .svc-cat-item--pm {
    justify-content: flex-start;
    gap: 10px;
    background: var(--orange-soft);
    border: 1px solid var(--gold-bd);
    color: var(--orange);
    margin-bottom: 8px;
  }

  .svc-cat-item--pm svg {
    color: var(--orange);
  }

  .svc-cat-item--pm:hover {
    background: var(--orange);
    color: #fff;
  }

  .svc-cat-item--pm:hover svg {
    color: #fff;
  }

  .svc-flyout {
    position: fixed;
    z-index: 1250;
    min-width: 220px;
    max-width: 280px;
    max-height: 70vh;
    overflow-y: auto;
    background: #fff;
    border-radius: 14px;
    border: 1px solid rgba(25, 38, 93, .08);
    box-shadow: 0 22px 54px rgba(25, 38, 93, .2);
    padding: 6px;
    opacity: 0;
    visibility: hidden;
    transform: translateX(-6px);
    transition: opacity .16s ease, transform .16s ease, visibility .16s ease;
  }

  .svc-flyout.open {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translateX(0);
  }

  .svc-flyout:not(.open) {
    pointer-events: none;
  }

  .svc-flyout-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    width: 100%;
    padding: 10px 10px;
    border: none;
    background: none;
    border-radius: 9px;
    font-family: 'DM Sans', sans-serif;
    font-size: .83rem;
    font-weight: 500;
    color: var(--navy);
    text-align: left;
    text-decoration: none;
    cursor: pointer;
    transition: background var(--t), color var(--t);
  }

  .svc-flyout-item:hover,
  .svc-flyout-item.active {
    background: var(--orange-soft);
    color: var(--orange);
  }

  .svc-flyout-item svg {
    width: 13px;
    height: 13px;
    flex-shrink: 0;
    color: rgba(25, 38, 93, .35);
    transition: color var(--t);
  }

  .svc-flyout-item:hover svg {
    color: var(--orange);
  }

  .svc-flyout-empty {
    padding: 12px 10px;
    font-size: .8rem;
    color: rgba(25, 38, 93, .4);
  }
</style>

{{-- ════════════════════════════════════════════
     DESKTOP HEADER
════════════════════════════════════════════ --}}
<header class="nh-bar d-none d-lg-block" id="nh-bar">
  <div class="nh-inner">

    <div class="nh-logo">
      <a href="{{ route('front.home') }}">
        <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="{{ config('app.name') }}">
      </a>
    </div>

    <button type="button" class="nh-all-btn" id="nh-all-btn-desktop" onclick="openServicesOffcanvas()" aria-label="Browse all services" aria-haspopup="true">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
        <line x1="4" y1="7" x2="20" y2="7" />
        <line x1="4" y1="12" x2="20" y2="12" />
        <line x1="4" y1="17" x2="20" y2="17" />
      </svg>
      Explore
    </button>

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

    <div class="nh-right-nav">

      {{-- ★ NEW: Property Management --}}
      <a href="{{ $pmUrl }}" class="nh-link-pm {{ $pmActive ? 'is-active' : '' }}" title="Property Management" aria-label="Property Management">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 21h18" />
          <path d="M5 21V7l7-4 7 4v14" />
          <path d="M9 21v-6h6v6" />
          <path d="M9 10h.01M12 10h.01M15 10h.01" />
        </svg>
        <span class="nh-pm-label">Property Management</span>
      </a>

      <a href="{{ route('property-request.create') }}" class="nh-link-rst">Request a Property</a>

      <div class="nh-lang" id="nh-lang-desktop">
        <button type="button" class="nh-lang-btn" onclick="nhToggleLang('nh-lang-desktop')">
          {{ app()->getLocale() }}
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 10l5 5 5-5z" />
          </svg>
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
          <li>
            <hr class="dropdown-divider">
          </li>
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

    {{-- ★ NEW: Property Management --}}
    <a href="{{ $pmUrl }}" class="nh-mobile-user nh-mobile-pm {{ $pmActive ? 'is-active' : '' }}" aria-label="Property Management" title="Property Management">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 21h18" />
        <path d="M5 21V7l7-4 7 4v14" />
        <path d="M9 21v-6h6v6" />
        <path d="M9 10h.01M12 10h.01M15 10h.01" />
      </svg>
    </a>

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
    <!-- <button class="nh-mobile-burger" onclick="openDrawer()" aria-label="Open menu" type="button">
      <svg viewBox="0 0 24 24" fill="currentColor">
        <path d="M3 4h18v2H3V4zm4 7h14v2H7v-2zm-4 7h18v2H3v-2z" />
      </svg>
    </button> -->
  </div>
</header>

<div class="nh-mobile-searchbar d-flex d-lg-none">
  <button type="button" class="nh-mobile-all-btn" onclick="openServicesOffcanvas()" aria-label="Browse all services">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
      <line x1="4" y1="7" x2="20" y2="7" />
      <line x1="4" y1="12" x2="20" y2="12" />
      <line x1="4" y1="17" x2="20" y2="17" />
    </svg>
  </button>

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

{{-- ════════════════════════════════════════════
     MOBILE DRAWER
════════════════════════════════════════════ --}}
<div class="nh-drawer" id="nh-drawer">
  <div class="nh-drawer-head">
    <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="{{ config('app.name') }}">
    <button class="nh-drawer-close" onclick="closeDrawer()" type="button">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 6L6 18M6 6l12 12" />
      </svg>
    </button>
  </div>

  <nav class="nh-drawer-nav">

    <a href="{{ route('front.home') }}" class="nh-drawer-link">Home</a>
    <a href="{{ route('property-request.create') }}" class="nh-drawer-link">Request a Property</a>

    {{-- ★ NEW: Property Management --}}
    <a href="{{ $pmUrl }}" class="nh-drawer-link nh-drawer-link--pm">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 21h18" />
        <path d="M5 21V7l7-4 7 4v14" />
        <path d="M9 21v-6h6v6" />
      </svg>
      Property Management
    </a>

    <div class="nh-drawer-divider"></div>

    <button class="nh-drawer-link" type="button" onclick="toggleSub('sub-buy', this)">Buy
      <svg viewBox="0 0 24 24" fill="currentColor" class="nh-drawer-arrow">
        <path d="M7 10l5 5 5-5z" />
      </svg>
    </button>
    <div class="nh-drawer-sub" id="sub-buy">
      <a href="{{ route('front.buy.homes') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
        </svg>
        Houses for Sale
      </a>
      <a href="{{ route('front.buy.lands') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c-.21.07-.36.25-.36.48V3.5c0-.28-.22-.5-.5-.5z" />
        </svg>
        Lands for Sale
      </a>
      <a href="{{ route('front.buy.design') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
        </svg>
        Architectural Designs
      </a>
    </div>

    <button class="nh-drawer-link" type="button" onclick="toggleSub('sub-rent', this)">Rent
      <svg viewBox="0 0 24 24" fill="currentColor" class="nh-drawer-arrow">
        <path d="M7 10l5 5 5-5z" />
      </svg>
    </button>
    <div class="nh-drawer-sub" id="sub-rent">
      <a href="{{ route('front.rent.homes') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
        </svg>
        Houses for Rent
      </a>
      <a href="{{ route('front.rent.lands') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c-.21.07-.36.25-.36.48V3.5c0-.28-.22-.5-.5-.5z" />
        </svg>
        Lands for Rent
      </a>
    </div>

    <button class="nh-drawer-link" type="button" onclick="toggleSub('sub-sell', this)">Sell
      <svg viewBox="0 0 24 24" fill="currentColor" class="nh-drawer-arrow">
        <path d="M7 10l5 5 5-5z" />
      </svg>
    </button>
    <div class="nh-drawer-sub" id="sub-sell">
      <a href="{{ route('front.add.property.house') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
        </svg>
        List Your House
      </a>
      <a href="{{ route('front.add.property.land') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c-.21.07-.36.25-.36.48V3.5c0-.28-.22-.5-.5-.5z" />
        </svg>
        List Your Land
      </a>
      <a href="{{ route('front.add.property.arch') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
        </svg>
        List a Design
      </a>
    </div>

    <button class="nh-drawer-link" type="button" onclick="openServicesOffcanvas()">Categories
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="nh-drawer-arrow" style="transform:rotate(-90deg)">
        <path d="M7 10l5 5 5-5z" fill="currentColor" stroke="none" />
      </svg>
    </button>

    <button class="nh-drawer-link" type="button" onclick="toggleSub('sub-updates', this)">Updates
      <svg viewBox="0 0 24 24" fill="currentColor" class="nh-drawer-arrow">
        <path d="M7 10l5 5 5-5z" />
      </svg>
    </button>
    <div class="nh-drawer-sub" id="sub-updates">
      <a href="{{ route('front.news.index') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
        </svg>
        News
      </a>
      <a href="{{ route('front.jobs.index') }}" class="nh-drawer-sub-item">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
        </svg>
        Jobs
      </a>
    </div>

    <div class="nh-drawer-divider"></div>
    <a href="{{ route('front.contact') }}" class="nh-drawer-link">Get Help</a>

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

{{-- ════════════════════════════════════════════
     SHARED SERVICES OFFCANVAS
════════════════════════════════════════════ --}}
<div class="svc-overlay" id="svc-overlay" onclick="closeServicesOffcanvas()"></div>
<aside class="svc-offcanvas" id="svc-offcanvas" aria-label="Browse services">
  <div class="svc-offcanvas-head">
    <h3 class="svc-offcanvas-title">All Categories</h3>
    <button class="svc-offcanvas-close" type="button" onclick="closeServicesOffcanvas()" aria-label="Close">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M18 6L6 18M6 6l12 12" />
      </svg>
    </button>
  </div>

  <div class="svc-offcanvas-body">

    {{-- LEVEL 1 --}}
    <div class="svc-cat-list">

      {{-- ★ NEW: Property Management --}}
      <div class="svc-cat-row">
        <a href="{{ $pmUrl }}" class="svc-cat-item svc-cat-item--pm">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 21h18" />
            <path d="M5 21V7l7-4 7 4v14" />
            <path d="M9 21v-6h6v6" />
          </svg>
          Property Management
        </a>
      </div>

      @forelse($serviceCategories as $category)
      <div class="svc-cat-row">
        <button type="button" class="svc-cat-item"
          data-opens-flyout="svc-subflyout-{{ $category->id }}"
          onclick="svcToggleCat(event, '{{ $category->id }}')"
          onmouseenter="svcHoverOpen('svc-subflyout-{{ $category->id }}', this, 'cat')"
          onmouseleave="svcHoverClose('svc-subflyout-{{ $category->id }}')">
          {{ $category->name }}
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6" />
          </svg>
        </button>
      </div>
      @empty
      <div class="svc-flyout-empty">No service categories yet</div>
      @endforelse

      {{-- construction --}}
      <div class="svc-cat-row">
        <button type="button" class="svc-cat-item"
          data-opens-flyout="svc-subflyout-construction"
          onclick="svcToggleCat(event, 'construction')"
          onmouseenter="svcHoverOpen('svc-subflyout-construction', this, 'cat')"
          onmouseleave="svcHoverClose('svc-subflyout-construction')">
          Construction Materials & Equipment
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6" />
          </svg>
        </button>
      </div>

      <!-- shops -->
      <div class="svc-cat-row">
        <button type="button" class="svc-cat-item"
          data-opens-flyout="svc-subflyout-shops"
          onclick="svcToggleCat(event, 'shops')"
          onmouseenter="svcHoverOpen('svc-subflyout-shops', this, 'cat')"
          onmouseleave="svcHoverClose('svc-subflyout-shops')">
          Shops
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6" />
          </svg>
        </button>
      </div>

      <div class="svc-cat-row">
        <a href="{{ route('front.property-requests.index') }}" class="svc-cat-item">
          Requested Properties
        </a>
      </div>

      {{-- Consultancy --}}
      <div class="svc-cat-row">
        <button type="button" class="svc-cat-item"
          data-opens-flyout="svc-subflyout-consultancy"
          onclick="svcToggleCat(event, 'consultancy')"
          onmouseenter="svcHoverOpen('svc-subflyout-consultancy', this, 'cat')"
          onmouseleave="svcHoverClose('svc-subflyout-consultancy')">
          Real Estate Consultancy
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6" />
          </svg>
        </button>
      </div>

      <!-- latest updates & news -->
      <div class="svc-cat-row">
        <button type="button" class="svc-cat-item"
          data-opens-flyout="svc-subflyout-latest-updates"
          onclick="svcToggleCat(event, 'latest-updates')"
          onmouseenter="svcHoverOpen('svc-subflyout-latest-updates', this, 'cat')"
          onmouseleave="svcHoverClose('svc-subflyout-latest-updates')">
          Latest Updates & News
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 18l6-6-6-6" />
          </svg>
        </button>
      </div>

      <div class="svc-cat-row">
        <a href="{{ route('front.brokage-services') }}" class="svc-cat-item">
          Brokage Services
        </a>
      </div>

    </div>

  </div>
</aside>

{{-- LEVEL 2 flyouts — categories' subcategories --}}
@foreach($serviceCategories as $category)
<div class="svc-flyout svc-sub-flyout" id="svc-subflyout-{{ $category->id }}"
  onmouseenter="svcCancelClose('svc-subflyout-{{ $category->id }}')"
  onmouseleave="svcHoverClose('svc-subflyout-{{ $category->id }}')">
  @forelse($category->subcategories as $sub)
  <button type="button" class="svc-flyout-item"
    data-opens-flyout="svc-serviceflyout-{{ $sub->id }}"
    onclick="svcToggleSub(event, '{{ $sub->id }}')"
    onmouseenter="svcHoverOpen('svc-serviceflyout-{{ $sub->id }}', this, 'sub')"
    onmouseleave="svcHoverClose('svc-serviceflyout-{{ $sub->id }}')">
    {{ $sub->name }}
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <path d="M9 18l6-6-6-6" />
    </svg>
  </button>
  @empty
  <div class="svc-flyout-empty">No sub-categories yet</div>
  @endforelse
</div>
@endforeach

{{-- LEVEL 3 flyouts — subcategories' services
     ★ data-parent-flyout links each L3 back to its L2 parent
     so the JS can cancel the L2 close timer when the mouse
     enters the L3 flyout --}}
@foreach($serviceCategories as $category)
@foreach($category->subcategories as $sub)
<div class="svc-flyout svc-service-flyout" id="svc-serviceflyout-{{ $sub->id }}"
  data-parent-flyout="svc-subflyout-{{ $category->id }}"
  onmouseenter="svcCancelClose('svc-serviceflyout-{{ $sub->id }}')"
  onmouseleave="svcHoverClose('svc-serviceflyout-{{ $sub->id }}')">
  @forelse($sub->services as $svc)
  <a href="{{ route('front.search', ['category' => $svc->slug]) }}" class="svc-flyout-item">
    {{ $svc->title ?? $svc->name }}
  </a>
  @empty
  <div class="svc-flyout-empty">No services yet</div>
  @endforelse
</div>
@endforeach
@endforeach

{{-- LEVEL 2 flyout — Construction Materials & Equipment → material categories --}}
<div class="svc-flyout svc-sub-flyout" id="svc-subflyout-construction"
  onmouseenter="svcCancelClose('svc-subflyout-construction')"
  onmouseleave="svcHoverClose('svc-subflyout-construction')">
  @forelse($materialCategories as $materialCategory)
  <div class="svc-flyout-item" style="padding:0;display:flex;align-items:stretch;">
    <a href="{{ route('front.materials.category', $materialCategory->slug) }}"
      class="svc-flyout-item" style="flex:1;border-radius:8px 0 0 8px;">
      {{ $materialCategory->name }}
    </a>
    @if ($materialCategory->materialSubcategories->isNotEmpty())
    <button type="button"
      style="border:none;background:none;padding:0 10px;cursor:pointer;color:rgba(25,38,93,.35);display:flex;align-items:center;"
      data-opens-flyout="svc-serviceflyout-material-{{ $materialCategory->id }}"
      onclick="event.stopPropagation(); svcToggleSub(event, 'material-{{ $materialCategory->id }}')"
      onmouseenter="svcHoverOpen('svc-serviceflyout-material-{{ $materialCategory->id }}', this, 'sub')"
      onmouseleave="svcHoverClose('svc-serviceflyout-material-{{ $materialCategory->id }}')"
      aria-label="Show {{ $materialCategory->name }} subcategories">
      <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 18l6-6-6-6" />
      </svg>
    </button>
    @endif
  </div>
  @empty
  <div class="svc-flyout-empty">No material categories yet</div>
  @endforelse
</div>

{{-- LEVEL 3 flyouts — each material category's subcategories --}}
@foreach($materialCategories as $materialCategory)
<div class="svc-flyout svc-service-flyout" id="svc-serviceflyout-material-{{ $materialCategory->id }}"
  data-parent-flyout="svc-subflyout-construction"
  onmouseenter="svcCancelClose('svc-serviceflyout-material-{{ $materialCategory->id }}')"
  onmouseleave="svcHoverClose('svc-serviceflyout-material-{{ $materialCategory->id }}')">

  <a href="{{ route('front.materials.category', $materialCategory->slug) }}" class="svc-flyout-item" style="font-weight:700;color:var(--orange);border-bottom:1px solid rgba(25,38,93,.06);margin-bottom:4px;">
    View all {{ $materialCategory->name }}
  </a>

  @forelse($materialCategory->materialSubcategories as $subcategory)
  <a href="{{ route('front.materials.category', ['category' => $materialCategory->slug, 'subcategory' => $subcategory->slug]) }}" class="svc-flyout-item">
    {{ $subcategory->title ?? $subcategory->name }}
  </a>
  @empty
  <div class="svc-flyout-empty">No sub categories yet</div>
  @endforelse
</div>
@endforeach

{{-- Consultancy flyout — direct anchor links, no third level --}}
<div class="svc-flyout svc-sub-flyout" id="svc-subflyout-consultancy"
  onmouseenter="svcCancelClose('svc-subflyout-consultancy')"
  onmouseleave="svcHoverClose('svc-subflyout-consultancy')">

  @forelse($consultancyItems as $item)
  <a href="{{ Route::has('front.consultancy.request') ? route('front.consultancy.request', ['topic' => $item['slug']]) : '#' }}" class="svc-flyout-item">
    {{ $item['name'] }}
  </a>
  @empty
  <div class="svc-flyout-empty">No consultancy services yet</div>
  @endforelse
</div>

<!-- shops -->
<div class="svc-flyout svc-sub-flyout" id="svc-subflyout-shops"
  onmouseenter="svcCancelClose('svc-subflyout-shops')"
  onmouseleave="svcHoverClose('svc-subflyout-shops')">

  @forelse($shopLocations as $province => $districts)
  @php $provinceKey = \Illuminate\Support\Str::slug($province); @endphp
  <div class="svc-flyout-item" style="padding:0;display:flex;align-items:stretch;">
    <a href="{{ Route::has('front.shops.locations') ? route('front.shops.locations', ['province' => $province]) : '#' }}"
      class="svc-flyout-item" style="flex:1;border-radius:8px 0 0 8px;">
      {{ $province }}
    </a>
    @if ($districts->isNotEmpty())
    <button type="button"
      style="border:none;background:none;padding:0 10px;cursor:pointer;color:rgba(25,38,93,.35);display:flex;align-items:center;"
      data-opens-flyout="svc-serviceflyout-shopprovince-{{ $provinceKey }}"
      onclick="event.stopPropagation(); svcToggleSub(event, 'shopprovince-{{ $provinceKey }}')"
      onmouseenter="svcHoverOpen('svc-serviceflyout-shopprovince-{{ $provinceKey }}', this, 'sub')"
      onmouseleave="svcHoverClose('svc-serviceflyout-shopprovince-{{ $provinceKey }}')"
      aria-label="Show {{ $province }} districts">
      <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 18l6-6-6-6" />
      </svg>
    </button>
    @endif
  </div>
  @empty
  <div class="svc-flyout-empty">No shops available</div>
  @endforelse
</div>

{{-- LEVEL 3 flyouts — each province's districts --}}
@foreach($shopLocations as $province => $districts)
@php $provinceKey = \Illuminate\Support\Str::slug($province); @endphp
<div class="svc-flyout svc-service-flyout" id="svc-serviceflyout-shopprovince-{{ $provinceKey }}"
  data-parent-flyout="svc-subflyout-shops"
  onmouseenter="svcCancelClose('svc-serviceflyout-shopprovince-{{ $provinceKey }}')"
  onmouseleave="svcHoverClose('svc-serviceflyout-shopprovince-{{ $provinceKey }}')">

  <a href="{{ Route::has('front.shops.locations') ? route('front.shops.locations', ['province' => $province]) : '#' }}"
     class="svc-flyout-item" style="font-weight:700;color:var(--orange);border-bottom:1px solid rgba(25,38,93,.06);margin-bottom:4px;">
    View all in {{ $province }}
  </a>

  @forelse($districts as $district => $shopsInDistrict)
  <a href="{{ Route::has('front.shops.locations') ? route('front.shops.locations', ['province' => $province, 'district' => $district]) : '#' }}"
     class="svc-flyout-item">
    {{ $district }}
    <span style="color:rgba(25,38,93,.35);font-weight:400;font-size:.75em;">({{ $shopsInDistrict->count() }})</span>
  </a>
  @empty
  <div class="svc-flyout-empty">No districts yet</div>
  @endforelse
</div>
@endforeach

<!-- Latest Updates & News -->
<div class="svc-flyout svc-sub-flyout" id="svc-subflyout-latest-updates"
  onmouseenter="svcCancelClose('svc-subflyout-latest-updates')"
  onmouseleave="svcHoverClose('svc-subflyout-latest-updates')">

  <a href="{{ route('front.news.index') }}" class="svc-flyout-item">
    Recent News
  </a>
  <a href="{{ route('front.jobs.index') }}" class="svc-flyout-item">
    Jobs
  </a>
</div>

<script>
  /* ════════════════════════════════════════════
     SCROLL EFFECT
     ════════════════════════════════════════════ */
  const nhBar = document.getElementById('nh-bar');
  window.addEventListener('scroll', () => {
    nhBar?.classList.toggle('scrolled', window.scrollY > 60);
  });

  /* ════════════════════════════════════════════
     MOBILE DRAWER
     ════════════════════════════════════════════ */
  window.openDrawer = () => {
    document.getElementById('nh-drawer').classList.add('open');
    document.getElementById('nh-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
  };
  window.closeDrawer = () => {
    document.getElementById('nh-drawer').classList.remove('open');
    document.getElementById('nh-overlay').classList.remove('open');
    if (!document.getElementById('svc-offcanvas').classList.contains('open')) {
      document.body.style.overflow = '';
    }
  };

  window.toggleSub = function(id, btn) {
    const panel = document.getElementById(id);
    const isOpen = panel.classList.contains('open');
    document.querySelectorAll('.nh-drawer-sub.open').forEach(p => p.classList.remove('open'));
    document.querySelectorAll('.nh-drawer-link.expanded').forEach(b => b.classList.remove('expanded'));
    if (!isOpen) {
      panel.classList.add('open');
      btn.classList.add('expanded');
    }
  };

  /* ════════════════════════════════════════════
     LANGUAGE TOGGLE
     ════════════════════════════════════════════ */
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

  /* ════════════════════════════════════════════
     NH2 MENU (second nav bar)
     ════════════════════════════════════════════ */
  (function() {
    const menuRoot = document.getElementById('nh2-menu');
    if (!menuRoot) return;
    window.nh2Toggle = function(btn) {
      const item = btn.closest('.nh2-item');
      const isOpen = item.classList.contains('open');
      menuRoot.querySelectorAll('.nh2-item.open').forEach(i => i.classList.remove('open'));
      if (!isOpen) item.classList.add('open');
    };
    document.addEventListener('click', (e) => {
      if (!menuRoot.contains(e.target)) {
        menuRoot.querySelectorAll('.nh2-item.open').forEach(i => i.classList.remove('open'));
      }
    });
  })();

  /* ════════════════════════════════════════════
     SERVICES OFFCANVAS — 3-level flyout
     ════════════════════════════════════════════ */
  (function() {
    const overlay = document.getElementById('svc-overlay');
    const panel = document.getElementById('svc-offcanvas');

    const CLOSE_DELAY = 280;
    const closeTimers = {};

    function getParentFlyoutId(flyoutId) {
      const el = document.getElementById(flyoutId);
      return el ? (el.dataset.parentFlyout || null) : null;
    }

    function cancelCloseChain(flyoutId) {
      if (closeTimers[flyoutId]) {
        clearTimeout(closeTimers[flyoutId]);
        delete closeTimers[flyoutId];
      }
      const parentId = getParentFlyoutId(flyoutId);
      if (parentId) cancelCloseChain(parentId);
    }

    function closeNow(flyoutId) {
      if (closeTimers[flyoutId]) {
        clearTimeout(closeTimers[flyoutId]);
        delete closeTimers[flyoutId];
      }
      const el = document.getElementById(flyoutId);
      if (el) el.classList.remove('open');

      document.querySelectorAll('[data-opens-flyout="' + flyoutId + '"]').forEach(t => {
        t.classList.remove('active');
      });

      document.querySelectorAll('[data-parent-flyout="' + flyoutId + '"]').forEach(child => {
        if (child.id) closeNow(child.id);
      });
    }

    function scheduleClose(flyoutId) {
      if (closeTimers[flyoutId]) clearTimeout(closeTimers[flyoutId]);
      closeTimers[flyoutId] = setTimeout(() => {
        closeNow(flyoutId);
        delete closeTimers[flyoutId];
      }, CLOSE_DELAY);
    }

    function closeSiblings(flyoutId, type) {
      if (type === 'cat') {
        document.querySelectorAll('.svc-sub-flyout.open').forEach(f => {
          if (f.id !== flyoutId) closeNow(f.id);
        });
      } else if (type === 'sub') {
        const parentId = getParentFlyoutId(flyoutId);
        if (parentId) {
          document.querySelectorAll('[data-parent-flyout="' + parentId + '"].open').forEach(f => {
            if (f.id !== flyoutId) closeNow(f.id);
          });
        }
      }
    }

    function positionFlyout(flyout, triggerEl, type) {
      const rect = triggerEl.getBoundingClientRect();

      if (type === 'cat') {
        const offRect = panel.getBoundingClientRect();
        flyout.style.top = rect.top + 'px';
        flyout.style.left = (offRect.right + 4) + 'px';
      } else if (type === 'sub') {
        const parentFlyout = triggerEl.closest('.svc-flyout');
        const parentRect = parentFlyout ? parentFlyout.getBoundingClientRect() : rect;
        flyout.style.top = rect.top + 'px';
        flyout.style.left = (parentRect.right + 4) + 'px';
      }

      requestAnimationFrame(() => {
        const fRect = flyout.getBoundingClientRect();
        if (fRect.right > window.innerWidth - 10) {
          flyout.style.left = '';
          flyout.style.right = '10px';
        }
        if (fRect.bottom > window.innerHeight - 10) {
          flyout.style.top = Math.max(10, window.innerHeight - fRect.height - 10) + 'px';
        }
      });
    }

    window.svcHoverOpen = function(flyoutId, triggerEl, type) {
      cancelCloseChain(flyoutId);

      const parentFlyout = triggerEl.closest('.svc-flyout');
      if (parentFlyout && parentFlyout.id) {
        cancelCloseChain(parentFlyout.id);
      }

      const flyout = document.getElementById(flyoutId);
      if (!flyout) return;

      closeSiblings(flyoutId, type);

      positionFlyout(flyout, triggerEl, type);
      flyout.classList.add('open');
      triggerEl.classList.add('active');
    };

    window.svcHoverClose = function(flyoutId) {
      scheduleClose(flyoutId);
    };

    window.svcCancelClose = function(flyoutId) {
      cancelCloseChain(flyoutId);
    };

    window.openServicesOffcanvas = function() {
      overlay.classList.add('open');
      panel.classList.add('open');
      document.body.style.overflow = 'hidden';
      populateCategorySelects();
    };

    window.closeServicesOffcanvas = function() {
      overlay.classList.remove('open');
      panel.classList.remove('open');
      document.querySelectorAll('.svc-flyout.open').forEach(f => f.classList.remove('open'));
      document.querySelectorAll('.svc-cat-item.active, .svc-flyout-item.active').forEach(el => el.classList.remove('active'));
      Object.keys(closeTimers).forEach(id => {
        clearTimeout(closeTimers[id]);
        delete closeTimers[id];
      });
      if (!document.getElementById('nh-drawer').classList.contains('open')) {
        document.body.style.overflow = '';
      }
    };

    window.svcToggleCat = function(e, catId) {
      const flyoutId = 'svc-subflyout-' + catId;
      const flyout = document.getElementById(flyoutId);
      if (!flyout) return;
      if (flyout.classList.contains('open')) {
        closeNow(flyoutId);
      } else {
        document.querySelectorAll('.svc-sub-flyout.open').forEach(f => {
          if (f.id !== flyoutId) closeNow(f.id);
        });
        positionFlyout(flyout, e.currentTarget, 'cat');
        flyout.classList.add('open');
        e.currentTarget.classList.add('active');
      }
    };

    window.svcToggleSub = function(e, subId) {
      const flyoutId = 'svc-serviceflyout-' + subId;
      const flyout = document.getElementById(flyoutId);
      if (!flyout) return;
      if (flyout.classList.contains('open')) {
        closeNow(flyoutId);
      } else {
        const parentFlyout = e.currentTarget.closest('.svc-flyout');
        if (parentFlyout) {
          document.querySelectorAll('[data-parent-flyout="' + parentFlyout.id + '"].open').forEach(f => {
            if (f.id !== flyoutId) closeNow(f.id);
          });
        }
        positionFlyout(flyout, e.currentTarget, 'sub');
        flyout.classList.add('open');
        e.currentTarget.classList.add('active');
      }
    };

    function populateCategorySelects() {
      const selects = [
        document.getElementById('nh-cat-select-desktop'),
        document.getElementById('nh-cat-select-mobile')
      ];
      selects.forEach(sel => {
        if (!sel || sel.dataset.populated) return;
        sel.dataset.populated = '1';
        @foreach($serviceCategories as $category)
        @foreach($category->subcategories as $sub) {
          const o = document.createElement('option');
          o.value = '{{ $sub->slug }}';
          o.textContent = '{{ $sub->name }}';
          sel.appendChild(o);
        }
        @endforeach
        @endforeach
      });
    }

    document.addEventListener('click', function(e) {
      if (!panel.contains(e.target) &&
        !e.target.closest('.svc-flyout') &&
        !e.target.closest('.nh-all-btn') &&
        !e.target.closest('.nh-mobile-all-btn')) {
        document.querySelectorAll('.svc-flyout.open').forEach(f => closeNow(f.id));
      }
    });

  })();
</script>