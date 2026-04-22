<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

    :root {
        --gold: #D05208;
        --gold-lt: #D05208;
        --gold-bg: rgba(200, 135, 58, .08);
        --gold-bd: rgba(200, 135, 58, .18);
        --dark: #19265d;
        --dark2: #19265d;
        --dark3: #1E1D1A;
        --border: rgba(255, 255, 255, .07);
        --border2: rgba(255, 255, 255, .12);
        --text-h: #F0EDE8;
        --muted-h: rgba(240, 237, 232, .45);
        --dim-h: rgba(240, 237, 232, .25);
        --t: .2s cubic-bezier(.4, 0, .2, 1);
    }

    /* ══════════════════════════════════════
       SECONDARY NAV BAR
    ══════════════════════════════════════ */
    .ft-subnav {
        background: var(--dark2);
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        font-family: 'DM Sans', sans-serif;
    }

    .ft-subnav-inner {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        align-items: center;
        height: 48px;
        gap: 0;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .ft-subnav-inner::-webkit-scrollbar {
        display: none;
    }

    .ft-subnav-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0 16px;
        height: 100%;
        font-size: .74rem;
        font-weight: 500;
        color: var(--muted-h);
        white-space: nowrap;
        border-right: 1px solid var(--border);
        transition: color var(--t), background var(--t);
        text-decoration: none;
    }

    .ft-subnav-item:first-child {
        padding-left: 0;
    }

    .ft-subnav-item:last-child {
        border-right: none;
    }

    .ft-subnav-item svg {
        width: 12px;
        height: 12px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .ft-subnav-item:hover {
        color: var(--text-h);
    }

    .ft-subnav-item.highlight {
        color: var(--gold-lt);
    }

    .ft-subnav-item.highlight:hover {
        color: var(--gold);
    }

    .ft-subnav-sep {
        flex: 1;
    }

    /* ══════════════════════════════════════
       MAIN FOOTER
    ══════════════════════════════════════ */
    .ft-main {
        background: #19265d;
        padding: 64px 0 0;
        font-family: 'DM Sans', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .ft-main::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 55% 45% at 5% 0%, rgba(200, 135, 58, .07) 0%, transparent 60%),
            radial-gradient(ellipse 35% 55% at 95% 100%, rgba(200, 135, 58, .05) 0%, transparent 55%);
        pointer-events: none;
    }

    .ft-main::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(0deg, transparent, transparent 39px, rgba(255, 255, 255, .015) 39px, rgba(255, 255, 255, .015) 40px),
            repeating-linear-gradient(90deg, transparent, transparent 79px, rgba(255, 255, 255, .01) 79px, rgba(255, 255, 255, .01) 80px);
        pointer-events: none;
    }

    .ft-container {
        max-width: 1240px;
        margin: 0 auto;
        padding: 0 24px;
        position: relative;
        z-index: 2;
    }

    /* ── Grid: FIX — was 5 columns but had 6 column divs ── */
    .ft-grid {
        display: grid;
        grid-template-columns: 1.6fr 1fr 1fr 1fr 1fr 1.4fr;
        gap: 40px;
        padding-bottom: 48px;
        border-bottom: 1px solid var(--border);
    }

    @media (max-width: 1100px) {
        .ft-grid {
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
        }

        .ft-col-map {
            display: none;
        }
    }

    @media (max-width: 720px) {
        .ft-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 480px) {
        .ft-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ── Brand column ── */
    .ft-brand-logo {
        height: 34px;
        width: auto;
        display: block;
        margin-bottom: 18px;
    }

    .ft-brand-desc {
        font-size: .8rem;
        color: var(--muted-h);
        line-height: 1.8;
        margin-bottom: 20px;
        max-width: 240px;
    }

    .ft-contact-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 22px;
    }

    .ft-contact-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .8rem;
        color: var(--muted-h);
        transition: color var(--t);
        text-decoration: none;
    }

    .ft-contact-item:hover {
        color: var(--text-h);
    }

    .ft-contact-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .ft-contact-icon svg {
        width: 13px;
        height: 13px;
        color: var(--gold);
    }

    /* Social icons */
    .ft-social {
        display: flex;
        gap: 7px;
    }

    .ft-soc {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid var(--border2);
        background: rgba(255, 255, 255, .04);
        display: grid;
        place-items: center;
        font-size: .75rem;
        color: var(--muted-h);
        transition: all var(--t);
        text-decoration: none;
    }

    .ft-soc:hover {
        background: var(--gold);
        border-color: var(--gold);
        color: #fff;
    }

    /* ── Link columns ── */
    .ft-col-label {
        font-size: .66rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 16px;
        display: block;
    }

    .ft-col-links {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .ft-col-link {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 6px 0;
        font-size: .8rem;
        color: var(--muted-h);
        transition: color var(--t), gap var(--t);
        text-decoration: none;
    }

    .ft-col-link:hover {
        color: var(--text-h);
        gap: 11px;
    }

    .ft-col-link svg {
        width: 10px;
        height: 10px;
        color: var(--gold);
        flex-shrink: 0;
        opacity: .6;
    }

    /* ── Map column ── */
    .ft-map-wrap {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid var(--border2);
        position: relative;
    }

    .ft-map-wrap iframe {
        width: 100%;
        height: 190px;
        border: none;
        display: block;
        filter: grayscale(30%) contrast(1.1) brightness(.9);
        transition: filter var(--t);
    }

    .ft-map-wrap:hover iframe {
        filter: grayscale(0%) contrast(1) brightness(1);
    }

    .ft-map-footer {
        background: rgba(14, 14, 12, .85);
        backdrop-filter: blur(8px);
        border-top: 1px solid var(--border2);
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .74rem;
        color: var(--muted-h);
    }

    .ft-map-footer svg {
        width: 12px;
        height: 12px;
        color: var(--gold);
        flex-shrink: 0;
    }

    .ft-map-footer a {
        margin-left: auto;
        font-size: .72rem;
        font-weight: 600;
        color: var(--gold);
        display: flex;
        align-items: center;
        gap: 4px;
        transition: gap var(--t);
    }

    .ft-map-footer a:hover {
        gap: 7px;
    }

    .ft-map-footer a svg {
        width: 10px;
        height: 10px;
    }

    /* Newsletter strip */
    .ft-newsletter {
        border: 1px solid var(--border2);
        border-radius: 10px;
        padding: 16px;
        margin-top: 16px;
    }

    .ft-nl-label {
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--dim-h);
        margin-bottom: 8px;
    }

    .ft-nl-form {
        display: flex;
        gap: 6px;
    }

    .ft-nl-input {
        flex: 1;
        padding: 8px 11px;
        background: rgba(255, 255, 255, .05);
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 7px;
        font-size: .78rem;
        font-family: 'DM Sans', sans-serif;
        color: var(--text-h);
        transition: border-color var(--t);
        min-width: 0;
    }

    .ft-nl-input::placeholder {
        color: var(--dim-h);
    }

    .ft-nl-input:focus {
        outline: none;
        border-color: var(--gold);
    }

    .ft-nl-btn {
        padding: 8px 14px;
        border-radius: 7px;
        background: var(--gold);
        border: none;
        color: #fff;
        font-size: .76rem;
        font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        white-space: nowrap;
        transition: background var(--t);
    }

    .ft-nl-btn:hover {
        background: #a06828;
    }

    /* ══════════════════════════════════════
       BOTTOM BAR
    ══════════════════════════════════════ */
    .ft-bottom {
        padding: 18px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }

    .ft-copyright {
        font-size: .74rem;
        color: var(--dim-h);
    }

    .ft-copyright a {
        color: var(--gold-lt);
        transition: color var(--t);
    }

    .ft-copyright a:hover {
        color: var(--gold);
    }

    .ft-bottom-links {
        display: flex;
        gap: 0;
    }

    .ft-bottom-link {
        padding: 0 12px;
        font-size: .72rem;
        color: var(--dim-h);
        border-right: 1px solid var(--border);
        transition: color var(--t);
        text-decoration: none;
    }

    .ft-bottom-link:last-child {
        border-right: none;
        padding-right: 0;
    }

    .ft-bottom-link:hover {
        color: var(--muted-h);
    }

    .ft-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 6px;
        background: var(--gold-bg);
        border: 1px solid var(--gold-bd);
        font-size: .66rem;
        font-weight: 600;
        color: var(--gold);
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .ft-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #4ade80;
    }
</style>


{{-- ══════════════════════════
     MAIN FOOTER
══════════════════════════ --}}
<footer class="ft-main">
    <div class="ft-container">
        <div class="ft-grid">

            {{-- ── Column 1: Brand ── --}}
            <div>
                <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}"
                    alt="{{ config('app.name') }}"
                    class="ft-brand-logo">

                <p class="ft-brand-desc">
                    Rwanda's premier real estate platform — connecting buyers, sellers, agents, and consultants across every district.
                </p>

                <div class="ft-contact-list">
                    <a href="tel:+250796511725" class="ft-contact-item">
                        <div class="ft-contact-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" />
                            </svg>
                        </div>
                        +250 796 511 725
                    </a>
                    <a href="mailto:terraltd.rd@gmail.com" class="ft-contact-item">
                        <div class="ft-contact-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                            </svg>
                        </div>
                        terraltd.rd@gmail.com
                    </a>
                    <a href="https://wa.me/250796511725" target="_blank" class="ft-contact-item">
                        <div class="ft-contact-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" />
                                <path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" />
                            </svg>
                        </div>
                        WhatsApp Chat
                    </a>
                    <span class="ft-contact-item" style="cursor:default">
                        <div class="ft-contact-icon">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                            </svg>
                        </div>
                        Kigali, Rwanda
                    </span>
                </div>

                <div class="ft-social">
                    <a href="https://x.com/terraltdrd" class="ft-soc" target="_blank">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/terra-ltd-1842403b7" target="_blank" class="ft-soc">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/terraltd.rd" target="_blank" class="ft-soc">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UC79ofkeQwIYyfynBYUr19GA" target="_blank" class="ft-soc">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="https://wa.me/250796511725" target="_blank" class="ft-soc">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            {{-- ── Column 2: Properties ── --}}
            <div>
                <span class="ft-col-label">Properties</span>
                <div class="ft-col-links">
                    <a href="{{ route('front.buy.homes') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Houses for Sale
                    </a>
                    <a href="{{ route('front.rent.homes') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Houses for Rent
                    </a>
                    <a href="{{ route('front.rent.apartments') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Apartments for Rent
                    </a>
                    <a href="{{ route('front.buy.lands') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Land for Sale
                    </a>
                    <a href="{{ route('front.buy.design') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Architectural Designs
                    </a>
                    <a href="{{ route('front.properties.buy') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Listings
                    </a>
                </div>
            </div>

            {{-- ── Column 3: Services ── --}}
            <div>
                <span class="ft-col-label">Services</span>
                <div class="ft-col-links">
                    <a href="{{ route('front.agents') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Real Estate Agents
                    </a>
                    <a href="{{ route('front.consultants.index') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Consultants
                    </a>
                    <a href="{{ route('front.agents.register') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Become an Agent
                    </a>
                    <a href="{{ route('consultant.register') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Become a Consultant
                    </a>
                    <a href="{{ route('front.properties.sell') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        List Your Property
                    </a>
                    <a href="{{ route('front.our.services') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        All Services
                    </a>
                </div>
            </div>

            {{-- ── Column 4: Company ── --}}
            <div>
                <span class="ft-col-label">Company</span>
                <div class="ft-col-links">
                    <a href="{{ route('front.about') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        About Terra
                    </a>
                    <a href="{{ route('front.news.index') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Blog &amp; News
                    </a>
                    <a href="{{ route('front.tenders.index') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Tenders
                    </a>
                    <a href="{{ route('front.ads.index') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Advertisements
                    </a>
                    {{-- FIX: was pointing to front.tenders.index (copy-paste error) --}}
                    <a href="{{ route('front.jobs.index') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Jobs
                    </a>
                    <a href="{{ route('front.contact') }}" class="ft-col-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        Contact Us
                    </a>
                </div>

                <!-- <div style="margin-top:22px">
                    <div class="ft-newsletter">
                        <div class="ft-nl-label">Stay updated</div>
                        <div class="ft-nl-form">
                            <input type="email" class="ft-nl-input" placeholder="your@email.com">
                            <button class="ft-nl-btn">Subscribe</button>
                        </div>
                    </div>
                </div> -->
            </div>

            {{-- ── Column 5: Partners / Quick Links ── --}}
            <div>
                <span class="ft-col-label">Quick Links</span>
                <div class="ft-col-links">
                    {{-- FIX 1: was `\App\Model\Partner as $partners` (invalid PHP + wrong namespace)
                         FIX 2: was @foreach($partner as $partners) (variables swapped)
                         FIX 3: $partner->name was unquoted — rendered as plain text --}}
                    @php
                    $partners = \App\Models\Partner::orderBy('name')->get();
                    @endphp

                    @foreach($partners as $partner)
                    <a href="{{ $partner->link }}" class="ft-col-link" target="_blank" rel="noopener noreferrer">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        {{ $partner->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- ── Column 6: Map ── --}}
            <div class="ft-col-map">
                <span class="ft-col-label">We're Located</span>
                <div class="ft-map-wrap">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d326.36075734823254!2d30.063273152438825!3d-1.9348056650284369!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca700357a3c8d%3A0xf28a78f475fe269e!2sTerra%20measures%20Ltd!5e1!3m2!1sen!2srw!4v1774257840816!5m2!1sen!2srw"
                        width="600" height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div class="ft-map-footer">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                        </svg>
                        Kigali, Rwanda
                        <a href="https://maps.app.goo.gl/Ro2rLRPTCoy9Uejy9" target="_blank" rel="noopener">
                            Open Maps
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div style="margin-top:14px;padding:14px;border:1px solid rgba(255,255,255,.08);border-radius:10px">
                    <div style="font-size:.66rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(240,237,232,.25);margin-bottom:8px">
                        Office Hours
                    </div>
                    <div style="font-size:.78rem;color:rgba(240,237,232,.45);line-height:1.9">
                        Mon – Fri: &nbsp;<strong style="color:#F0EDE8">9:00 AM – 6:00 PM</strong><br>
                        Saturday: &nbsp;&nbsp;&nbsp;&nbsp;<strong style="color:#F0EDE8">10:00 AM – 2:00 PM</strong><br>
                        Sunday: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong style="color:rgba(240,237,232,.3)">Closed</strong>
                    </div>
                </div>
            </div>

        </div>{{-- /grid --}}

        {{-- ── Bottom bar ── --}}
        <div class="ft-bottom">
            <p class="ft-copyright">
                &copy; <a href="{{ route('front.home') }}">{{ config('app.name') }}</a>. All rights reserved.
            </p>
            <div class="ft-bottom-links">
                <a href="{{ route('legal.privacy') }}" class="ft-bottom-link">Privacy Policy</a>
                <a href="{{ route('legal.terms') }}" class="ft-bottom-link">Terms of Service</a>
                <a href="{{ route('front.contact') }}" class="ft-bottom-link">Support</a>
            </div>
            <div class="ft-badge">
                <a href="#" onclick="document.getElementById('devModal').style.display='flex'; return false;">
                    Contact Developer
                </a>
            </div>

            <!-- Modal Overlay -->
            <div id="devModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
                <div style="background:#fff; border-radius:12px; padding:2rem; width:100%; max-width:420px; margin:1rem; position:relative;">

                    <!-- Close button -->
                    <button onclick="document.getElementById('devModal').style.display='none'"
                        style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:20px; cursor:pointer; color:#6b7280;">&#x2715;</button>

                    <!-- Header -->
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:1.5rem;">
                        <div style="width:48px; height:48px; border-radius:50%; background:#e8f5ed; display:flex; align-items:center; justify-content:center; font-weight:600; font-size:16px; color:#1a6b3a;">ME</div>
                        <div>
                            <p style="margin:0; font-weight:600; font-size:16px; color:#111827;">Mugisha Eric</p>
                            <p style="margin:0; font-size:13px; color:#6b7280;">Developer · terra.rw</p>
                        </div>
                    </div>

                    <!-- Contact options -->
                    <div style="display:flex; flex-direction:column; gap:10px;">

                        <a href="tel:+250782390919"
                            style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                            <span style="width:36px; height:36px; border-radius:50%; background:#e8f5ed; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" fill="none" stroke="#1a6b3a" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 11.5 19.79 19.79 0 01.0 2.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z" />
                                </svg>
                            </span>
                            <div>
                                <p style="margin:0; font-size:13px; color:#6b7280;">Call</p>
                                <p style="margin:0; font-size:14px; font-weight:500;">+250 782 390 919</p>
                            </div>
                        </a>

                        <a href="sms:+250782390919"
                            style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                            <span style="width:36px; height:36px; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                </svg>
                            </span>
                            <div>
                                <p style="margin:0; font-size:13px; color:#6b7280;">Text / SMS</p>
                                <p style="margin:0; font-size:14px; font-weight:500;">+250 782 390 919</p>
                            </div>
                        </a>

                        <a href="https://wa.me/250782390919" target="_blank"
                            style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                            <span style="width:36px; height:36px; border-radius:50%; background:#e8f5ed; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#1a6b3a">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </span>
                            <div>
                                <p style="margin:0; font-size:13px; color:#6b7280;">WhatsApp</p>
                                <p style="margin:0; font-size:14px; font-weight:500;">+250 782 390 919</p>
                            </div>
                        </a>

                        <a href="mailto:kericmugisha@gmail.com"
                            style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                            <span style="width:36px; height:36px; border-radius:50%; background:#fef3c7; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </span>
                            <div>
                                <p style="margin:0; font-size:13px; color:#6b7280;">Email</p>
                                <p style="margin:0; font-size:14px; font-weight:500;">kericmugisha@gmail.com</p>
                            </div>
                        </a>

                        <a href="https://www.linkedin.com/in/mugisha-eric-411547135/" target="_blank"
                            style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; color:#111827;">
                            <span style="width:36px; height:36px; border-radius:50%; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="#1d4ed8">
                                    <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z" />
                                    <circle cx="4" cy="4" r="2" />
                                </svg>
                            </span>
                            <div>
                                <p style="margin:0; font-size:13px; color:#6b7280;">LinkedIn</p>
                                <p style="margin:0; font-size:14px; font-weight:500;">Mugisha Eric</p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <!-- Close modal when clicking the backdrop -->
            <script>
                document.getElementById('devModal').addEventListener('click', function(e) {
                    if (e.target === this) this.style.display = 'none';
                });
            </script>
        </div>

    </div>{{-- /container --}}
</footer>