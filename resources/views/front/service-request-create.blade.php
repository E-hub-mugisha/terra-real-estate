<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Request a Service — Terra</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/themify-icons/1.0.1/css/themify-icons.min.css">

<style>
    :root {
        --navy: #19265d;
        --navy-dark: #111a45;
        --navy-tint: #eef0f8;
        --gold: #D05208;
        --gold-light: #fdf1e8;
        --gold-bd: rgba(208,82,8,.22);
        --ink: #16203f;
        --muted: #6b7280;
        --dim: #9aa0b4;
        --line: #e7e9f2;
        --danger: #dc3545;
        --r: 16px;
        --t: .22s cubic-bezier(.4,0,.2,1);
    }
    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body {
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        background: #f7f7fb;
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    /* ── Navy header band: sizes itself to its content (topbar + hero),
         instead of the old fixed-300px body gradient which cut off
         mid-content whenever the hero text wrapped to more lines. ── */
    .rq-header-band {
        background:
            radial-gradient(ellipse 60% 50% at 15% 0%, rgba(208,82,8,.14) 0%, transparent 60%),
            linear-gradient(180deg, var(--navy-dark) 0%, var(--navy) 100%);
        padding: 2rem 1.25rem 2.5rem;
    }
    .rq-header-inner { max-width: 1080px; margin: 0 auto; }

    .rq-shell { max-width: 1080px; margin: 0 auto; padding: 2rem 1.25rem 3.5rem; flex: 1; width: 100%; }

    /* ── Top bar ── */
    .rq-topbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap;
    }
    .rq-back-home {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1.1rem; border-radius: 30px;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.16);
        color: rgba(255,255,255,.85); font-size: .82rem; font-weight: 600;
        text-decoration: none; transition: all var(--t);
    }
    .rq-back-home:hover { background: rgba(255,255,255,.16); color: #fff; }
    .rq-back-home i { font-size: .95rem; }

    .rq-brand { display: flex; align-items: center; }
    .rq-brand img {
        height: 36px; width: auto; display: block;
        filter: drop-shadow(0 3px 10px rgba(0,0,0,.28));
    }

    /* ── Hero ── */
    .rq-hero { margin-bottom: 0; }
    .rq-hero h1 {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 700; font-size: clamp(2rem, 4vw, 2.6rem); color: #fff; margin-bottom: .5rem;
        letter-spacing: -.01em;
    }
    .rq-hero p { color: rgba(255,255,255,.72); font-size: .96rem; max-width: 520px; line-height: 1.65; }

    .rq-alert-success {
        background: #eafaf1; border: 1px solid #b9e9cd; color: #146c43;
        border-radius: 14px; padding: 1rem 1.2rem; margin-bottom: 1.75rem;
        display: flex; align-items: center; gap: .6rem; font-size: .9rem;
    }

    /* ── Toolbar ── */
    .rq-toolbar {
        background: #fff; border: 1px solid var(--line); border-radius: 18px;
        padding: 1.1rem 1.3rem; margin-bottom: 1.75rem;
        box-shadow: 0 20px 45px -30px rgba(17,26,69,.4);
        display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;
    }
    .rq-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .rq-search-wrap i.ti-search {
        position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
        color: var(--dim); font-size: 1rem; pointer-events: none;
    }
    .rq-search-input {
        width: 100%; border: 1.5px solid var(--line); border-radius: 12px;
        padding: .72rem 2.4rem .72rem 2.7rem; font-size: .9rem; background: #fbfbfd;
        font-family: 'DM Sans', sans-serif; color: var(--ink);
        transition: border-color var(--t), box-shadow var(--t), background var(--t);
    }
    .rq-search-input:focus {
        border-color: var(--gold); box-shadow: 0 0 0 4px rgba(208,82,8,.1);
        background: #fff; outline: none;
    }
    .rq-search-clear {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        background: none; border: none; color: var(--dim); font-size: 1rem;
        cursor: pointer; padding: 4px; line-height: 1; display: none; border-radius: 6px;
    }
    .rq-search-clear.show { display: block; }
    .rq-search-clear:hover { color: var(--ink); background: var(--navy-tint); }

    .rq-service-count { font-size: .8rem; color: var(--muted); white-space: nowrap; }
    .rq-service-count strong { color: var(--ink); }

    /* ── Service grid — 3 columns ── */
    .rq-service-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;
    }
    @media (max-width: 860px) { .rq-service-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .rq-service-grid { grid-template-columns: 1fr; } }

    .rq-service-card {
        background: #fff; border: 1.5px solid var(--line); border-radius: var(--r);
        padding: 1.35rem 1.3rem 1.2rem; text-align: left; width: 100%;
        cursor: pointer; transition: transform var(--t), border-color var(--t), box-shadow var(--t);
        display: flex; flex-direction: column; gap: .7rem;
        font-family: 'DM Sans', sans-serif; position: relative; overflow: hidden;
        animation: rqCardIn .35s ease both;
    }
    @keyframes rqCardIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .rq-service-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, var(--gold), transparent); opacity: 0; transition: opacity var(--t);
    }
    .rq-service-card:hover {
        border-color: var(--gold-bd); transform: translateY(-4px);
        box-shadow: 0 18px 34px -20px rgba(17,26,69,.35);
    }
    .rq-service-card:hover::before { opacity: 1; }
    .rq-service-card:focus-visible { outline: 2px solid var(--gold); outline-offset: 2px; }

    .rq-service-card-icon {
        width: 42px; height: 42px; border-radius: 11px;
        background: var(--gold-light); border: 1px solid var(--gold-bd);
        display: flex; align-items: center; justify-content: center;
        color: var(--gold); font-size: 1.1rem; transition: all var(--t);
    }
    .rq-service-card:hover .rq-service-card-icon { background: var(--gold); color: #fff; border-color: var(--gold); }

    .rq-service-card-title {
        font-weight: 700; font-size: .96rem; color: var(--ink); line-height: 1.3;
    }
    .rq-service-card-price { font-size: .78rem; font-weight: 600; color: var(--gold); }

    .rq-service-card-cta {
        display: flex; align-items: center; gap: .3rem; margin-top: auto; padding-top: .6rem;
        border-top: 1px solid var(--line); font-size: .78rem; font-weight: 700; color: var(--gold);
        transition: gap var(--t);
    }
    .rq-service-card:hover .rq-service-card-cta { gap: .55rem; }

    .rq-service-empty {
        text-align: center; padding: 3.5rem 1rem; color: var(--muted); font-size: .9rem;
        background: #fff; border: 1px dashed var(--line); border-radius: var(--r);
    }
    .rq-service-empty i { font-size: 2rem; display: block; margin-bottom: .7rem; color: #c7cbdb; }

    /* ── Load more ── */
    .rq-load-more-wrap { display: flex; justify-content: center; margin-top: 1.75rem; }
    .rq-load-more-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        background: #fff; border: 1.5px solid var(--line); border-radius: 30px;
        padding: .68rem 1.5rem; font-size: .84rem; font-weight: 700; color: var(--ink);
        cursor: pointer; transition: all var(--t);
        box-shadow: 0 12px 28px -20px rgba(17,26,69,.35);
    }
    .rq-load-more-btn:hover { border-color: var(--gold-bd); color: var(--gold); background: var(--gold-light); }
    .rq-load-more-btn i { font-size: .95rem; transition: transform var(--t); }
    .rq-load-more-btn:hover i { transform: translateY(2px); }

    /* ── Inputs (shared with modal) ── */
    .rq-label { display: block; font-size: .78rem; font-weight: 700; color: var(--ink); margin-bottom: .4rem; }
    .rq-label .opt { font-weight: 400; color: var(--dim); }
    .rq-input-wrap { position: relative; margin-bottom: 1.05rem; }
    .rq-input-icon {
        position: absolute; left: 15px; top: 50%; transform: translateY(-50%);
        color: var(--dim); font-size: .98rem; pointer-events: none; z-index: 2;
    }
    .rq-control {
        width: 100%; border: 1.5px solid var(--line); border-radius: 11px;
        padding: .68rem .95rem .68rem 2.75rem; font-size: .88rem; background: #fbfbfd;
        transition: border-color var(--t), box-shadow var(--t), background var(--t);
        font-family: 'DM Sans', sans-serif; color: var(--ink);
    }
    .rq-control:focus {
        border-color: var(--gold); box-shadow: 0 0 0 4px rgba(208,82,8,.1);
        background: #fff; outline: none;
    }
    textarea.rq-control { padding-left: .95rem; resize: vertical; min-height: 90px; }
    .rq-error { color: var(--danger); font-size: .74rem; margin-top: -.75rem; margin-bottom: .9rem; }

    /* ══════════════════════════
       MODAL
    ══════════════════════════ */
    .rq-modal-overlay {
        position: fixed; inset: 0; z-index: 1200;
        background: rgba(15,20,40,.6); backdrop-filter: blur(3px);
        display: flex; align-items: center; justify-content: center; padding: 20px;
        opacity: 0; visibility: hidden; transition: opacity var(--t), visibility var(--t);
    }
    .rq-modal-overlay.active { opacity: 1; visibility: visible; }

    .rq-modal {
        background: #fff; border-radius: 20px; width: 100%; max-width: 600px;
        max-height: 90vh; display: flex; flex-direction: column; overflow: hidden;
        box-shadow: 0 30px 70px rgba(0,0,0,.35);
        transform: translateY(16px) scale(.98); transition: transform var(--t);
    }
    .rq-modal-overlay.active .rq-modal { transform: translateY(0) scale(1); }

    .rq-modal-header {
        background: linear-gradient(135deg, var(--navy), var(--navy-dark));
        padding: 22px 26px; display: flex; align-items: flex-start; justify-content: space-between;
        gap: 16px; flex-shrink: 0; position: relative; overflow: hidden;
    }
    .rq-modal-header::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse 60% 100% at 0% 0%, rgba(208,82,8,.2) 0%, transparent 60%);
        pointer-events: none;
    }
    .rq-modal-eyebrow {
        position: relative; z-index: 1; display: block; font-size: .68rem; font-weight: 700;
        letter-spacing: .12em; text-transform: uppercase; color: var(--gold); margin-bottom: 6px;
    }
    .rq-modal-title {
        position: relative; z-index: 1;
        font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 1.4rem;
        color: #fff; margin: 0; line-height: 1.25;
    }
    .rq-modal-price {
        position: relative; z-index: 1; font-size: .8rem; color: rgba(255,255,255,.6); margin-top: 3px;
    }
    .rq-modal-close {
        position: relative; z-index: 1; width: 30px; height: 30px; border-radius: 9px; flex-shrink: 0;
        background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.16); color: rgba(255,255,255,.85);
        display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all var(--t);
    }
    .rq-modal-close:hover { background: rgba(255,255,255,.2); color: #fff; }

    .rq-modal-body { padding: 22px 26px 26px; overflow-y: auto; }

    .rq-btn-submit {
        width: 100%; border: none; border-radius: 12px; background: var(--gold); color: #fff;
        font-weight: 700; font-size: .92rem; padding: .85rem; cursor: pointer;
        transition: background var(--t), transform var(--t);
        box-shadow: 0 10px 22px -10px rgba(208,82,8,.55);
        display: flex; align-items: center; justify-content: center; gap: .5rem;
    }
    .rq-btn-submit:hover { background: #b84706; transform: translateY(-1px); }

    @media (max-width: 560px) {
        .rq-modal { max-height: 94vh; }
        .rq-modal-header, .rq-modal-body { padding-left: 20px; padding-right: 20px; }
    }

    /* ══════════════════════════
       FOOTER
    ══════════════════════════ */
    .rq-footer {
        background: var(--navy-dark);
        border-top: 1px solid rgba(255,255,255,.08);
        padding: 1.75rem 1.25rem;
        margin-top: auto;
    }
    .rq-footer-inner {
        max-width: 1080px; margin: 0 auto;
        display: flex; align-items: center; justify-content: space-between;
        gap: 1rem; flex-wrap: wrap;
    }
    .rq-footer-brand img { height: 24px; width: auto; opacity: .9; }
    .rq-footer-links { display: flex; align-items: center; gap: 1.4rem; flex-wrap: wrap; }
    .rq-footer-links a {
        color: rgba(255,255,255,.6); font-size: .8rem; font-weight: 500;
        text-decoration: none; transition: color var(--t);
    }
    .rq-footer-links a:hover { color: var(--gold-light); }
    .rq-footer-copy { color: rgba(255,255,255,.4); font-size: .76rem; }

    @media (max-width: 640px) {
        .rq-footer-inner { flex-direction: column; text-align: center; }
    }
</style>

</head>
<body>

<div class="rq-header-band">
    <div class="rq-header-inner">
        <div class="rq-topbar">
            <a href="{{ route('front.home') }}" class="rq-back-home">
                <i class="ti ti-arrow-left"></i> Back to Home
            </a>
            <div class="rq-brand">
                <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="{{ config('app.name') }}">
            </div>
        </div>

        <div class="rq-hero">
            <h1>Request a Consultation</h1>
            <p>Browse our services below, pick the one you need, and fill in a few quick details. One of our Terra consultants will reach out to confirm.</p>
        </div>
    </div>
</div>

<div class="rq-shell">

    @if (session('success'))
    <div class="rq-alert-success">
        <i class="ti ti-circle-check fs-5"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Search toolbar ── --}}
    <div class="rq-toolbar">
        <div class="rq-search-wrap">
            <i class="ti ti-search"></i>
            <input type="text" class="rq-search-input" id="rqServiceSearch" placeholder="Search services...">
            <button type="button" class="rq-search-clear" id="rqSearchClear" aria-label="Clear search">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="rq-service-count" id="rqServiceCount"></div>
    </div>

    {{-- ── Service grid ── --}}
    <div class="rq-service-grid" id="rqServiceGrid">
        @foreach ($services as $i => $service)
            <button type="button" class="rq-service-card"
                data-service-card
                data-service-id="{{ $service->id }}"
                data-service-name="{{ strtolower($service->title) }}"
                data-service-title="{{ $service->title }}"
                data-service-price="{{ isset($service->price) ? number_format($service->price) . ' RWF' : '' }}"
                style="animation-delay:{{ ($i % 9) * 0.04 }}s"
                onclick="openRequestModal(this)">
                <!-- <div class="rq-service-card-icon"><i class="ti ti-briefcase"></i></div> -->
                <div>
                    <div class="rq-service-card-title">{{ $service->title }}</div>
                    @if(isset($service->price))
                        <div class="rq-service-card-price">From {{ number_format($service->price) }} RWF</div>
                    @endif
                </div>
                <div class="rq-service-card-cta">
                    Request this <i class="ti ti-arrow-right"></i>
                </div>
            </button>
        @endforeach
    </div>

    <div class="rq-service-empty d-none" id="rqServiceEmpty">
        <i class="ti ti-search-off"></i>
        No services match your search.
    </div>

    <div class="rq-load-more-wrap d-none" id="rqLoadMoreWrap">
        <button type="button" class="rq-load-more-btn" id="rqLoadMoreBtn">
            Load More Services <i class="ti ti-chevron-down"></i>
        </button>
    </div>

</div>

{{-- ══════════════════════════
     REQUEST MODAL
══════════════════════════ --}}
<div class="rq-modal-overlay" id="rqModalOverlay" onclick="if(event.target===this) closeRequestModal()">
    <div class="rq-modal">

        <div class="rq-modal-header">
            <div>
                <span class="rq-modal-eyebrow">Requesting</span>
                <h3 class="rq-modal-title" id="rqModalTitle">—</h3>
                <div class="rq-modal-price" id="rqModalPrice"></div>
            </div>
            <button type="button" class="rq-modal-close" onclick="closeRequestModal()">
                <i class="ti ti-x"></i>
            </button>
        </div>

        <div class="rq-modal-body">
            <form method="POST" action="{{ route('service-requests.store') }}" id="rqForm" novalidate>
                @csrf
                <input type="hidden" name="service_id" id="rqServiceId" value="{{ old('service_id') }}">

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="rq-label">Full Name</label>
                        <div class="rq-input-wrap">
                            <i class="ti ti-user rq-input-icon"></i>
                            <input type="text" name="full_name" class="rq-control" value="{{ old('full_name') }}" required>
                        </div>
                        @error('full_name') <div class="rq-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-6">
                        <label class="rq-label">Phone Number</label>
                        <div class="rq-input-wrap">
                            <i class="ti ti-phone rq-input-icon"></i>
                            <input type="text" name="phone" class="rq-control" placeholder="0788123456" value="{{ old('phone') }}" required>
                        </div>
                        @error('phone') <div class="rq-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <label class="rq-label">Email <span class="opt">(optional)</span></label>
                <div class="rq-input-wrap">
                    <i class="ti ti-mail rq-input-icon"></i>
                    <input type="email" name="email" class="rq-control" value="{{ old('email') }}">
                </div>
                @error('email') <div class="rq-error">{{ $message }}</div> @enderror

                <label class="rq-label">Location</label>
                <div class="rq-input-wrap">
                    <i class="ti ti-map-pin rq-input-icon"></i>
                    <input type="text" name="location" class="rq-control" placeholder="e.g. Kicukiro, Kigali" value="{{ old('location') }}" required>
                </div>
                @error('location') <div class="rq-error">{{ $message }}</div> @enderror

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="rq-label">Preferred Date <span class="opt">(optional)</span></label>
                        <div class="rq-input-wrap">
                            <i class="ti ti-calendar rq-input-icon"></i>
                            <input type="date" name="preferred_date" class="rq-control" value="{{ old('preferred_date') }}">
                        </div>
                        @error('preferred_date') <div class="rq-error">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-6">
                        <label class="rq-label">Preferred Time <span class="opt">(optional)</span></label>
                        <div class="rq-input-wrap">
                            <i class="ti ti-clock rq-input-icon"></i>
                            <input type="time" name="preferred_time" class="rq-control" value="{{ old('preferred_time') }}">
                        </div>
                        @error('preferred_time') <div class="rq-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <label class="rq-label">Message <span class="opt">(optional)</span></label>
                <div class="rq-input-wrap">
                    <textarea name="message" class="rq-control" rows="4" placeholder="Tell us more about what you need...">{{ old('message') }}</textarea>
                </div>
                @error('message') <div class="rq-error">{{ $message }}</div> @enderror

                <button type="submit" class="rq-btn-submit">
                    <i class="ti ti-send"></i> Submit Request
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════
     FOOTER
══════════════════════════ --}}
<footer class="rq-footer">
    <div class="rq-footer-inner">
        <div class="rq-footer-brand">
            <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="{{ config('app.name') }}">
        </div>
        <div class="rq-footer-links">
            <a href="{{ route('front.home') }}">Home</a>
            <a href="{{ route('front.our.services') }}">Services</a>
            <a href="{{ route('front.contact') }}">Contact</a>
            <a href="tel:+250796511725">+250 796 511 725</a>
        </div>
        <div class="rq-footer-copy">&copy; {{ date('Y') }} Terra Real Estate. All rights reserved.</div>
    </div>
</footer>

<script>
    const allCards = Array.from(document.querySelectorAll('[data-service-card]'));
    const totalServices = allCards.length;

    const INITIAL_BATCH = 9;
    const INCREMENT = 9;
    let visibleLimit = INITIAL_BATCH;

    const searchInput   = document.getElementById('rqServiceSearch');
    const searchClear   = document.getElementById('rqSearchClear');
    const serviceGrid   = document.getElementById('rqServiceGrid');
    const serviceEmpty  = document.getElementById('rqServiceEmpty');
    const serviceCount  = document.getElementById('rqServiceCount');
    const loadMoreWrap  = document.getElementById('rqLoadMoreWrap');
    const loadMoreBtn   = document.getElementById('rqLoadMoreBtn');

    /* ── Modal open/close ── */
    function openRequestModal(cardEl) {
        const id    = cardEl.dataset.serviceId;
        const title = cardEl.dataset.serviceTitle;
        const price = cardEl.dataset.servicePrice;

        document.getElementById('rqServiceId').value = id;
        document.getElementById('rqModalTitle').textContent = title;
        document.getElementById('rqModalPrice').textContent = price ? `From ${price}` : '';

        document.getElementById('rqModalOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeRequestModal() {
        document.getElementById('rqModalOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeRequestModal();
    });

    /* ── Search + pagination combined ── */
    function updateCount(visible, query) {
        if (!query) {
            serviceCount.innerHTML = `Showing <strong>${visible}</strong> of ${totalServices} services`;
        } else {
            serviceCount.innerHTML = `<strong>${visible}</strong> of ${totalServices} match "${query}"`;
        }
    }

    function applyView() {
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        if (query) {
            // While searching, show every match regardless of the load-more limit.
            allCards.forEach(card => {
                const matches = (card.dataset.serviceName || '').includes(query);
                card.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });
            loadMoreWrap.classList.add('d-none');
        } else {
            allCards.forEach((card, idx) => {
                const show = idx < visibleLimit;
                card.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });
            loadMoreWrap.classList.toggle('d-none', visibleLimit >= totalServices);
        }

        serviceGrid.classList.toggle('d-none', visibleCount === 0);
        serviceEmpty.classList.toggle('d-none', visibleCount !== 0);
        searchClear.classList.toggle('show', query.length > 0);
        updateCount(visibleCount, query);
    }

    searchInput.addEventListener('input', applyView);

    searchClear.addEventListener('click', () => {
        searchInput.value = '';
        applyView();
        searchInput.focus();
    });

    loadMoreBtn.addEventListener('click', () => {
        visibleLimit += INCREMENT;
        applyView();
    });

    /* ── Reopen modal automatically if validation failed ── */
    document.addEventListener('DOMContentLoaded', () => {
        applyView();

        const hasErrors = document.querySelectorAll('.rq-error').length > 0;
        if (hasErrors) {
            const oldServiceId = document.getElementById('rqServiceId').value;
            const matchingCard = allCards.find(c => c.dataset.serviceId === String(oldServiceId));
            const targetCard = matchingCard || allCards[0];

            if (targetCard) {
                // Make sure the selected card's batch is actually visible before opening the modal.
                const idx = allCards.indexOf(targetCard);
                if (idx >= visibleLimit) {
                    visibleLimit = Math.ceil((idx + 1) / INCREMENT) * INCREMENT;
                    applyView();
                }
                openRequestModal(targetCard);
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>