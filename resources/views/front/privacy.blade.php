@extends('layouts.guest')
@section('title', 'Privacy Policy — Terra Real Estate')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap');

    :root {
        --terra-navy:   #19265d;
        --terra-orange: #D05208;
        --terra-cream:  #F7F4EF;
        --terra-stone:  #7A736B;
        --terra-border: #E8E3DC;
        --terra-ink:    #2A2520;
    }

    .legal-hero {
        background: linear-gradient(135deg, #1a2d4a 0%, var(--terra-navy) 100%);
        padding: 80px 0 64px;
        position: relative;
        overflow: hidden;
    }

    .legal-hero::before {
        content: '';
        position: absolute;
        top: -40px; right: 8%;
        width: 280px; height: 280px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.05);
    }

    .legal-hero::after {
        content: '';
        position: absolute;
        bottom: -60px; left: 5%;
        width: 180px; height: 180px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.04);
    }

    .legal-hero-eyebrow {
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: rgba(255,255,255,.5);
        margin-bottom: 16px;
    }

    .legal-hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.2rem, 4vw, 3.2rem);
        font-weight: 300;
        color: #fff;
        line-height: 1.15;
        margin-bottom: 20px;
    }

    .legal-hero-title em {
        font-style: italic;
        color: rgba(255,255,255,.7);
    }

    .legal-hero-meta {
        font-family: 'DM Sans', sans-serif;
        font-size: .8rem;
        color: rgba(255,255,255,.45);
        display: flex;
        gap: 24px;
        flex-wrap: wrap;
    }

    .legal-hero-meta span::before {
        content: '—';
        margin-right: 8px;
        opacity: .4;
    }

    .legal-layout {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 0;
        max-width: 1080px;
        margin: 0 auto;
        padding: 60px 24px;
        align-items: start;
    }

    @media (max-width: 768px) {
        .legal-layout { grid-template-columns: 1fr; }
        .legal-toc { display: none; }
    }

    .legal-toc {
        position: sticky;
        top: 80px;
        padding-right: 40px;
    }

    .legal-toc-label {
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        font-weight: 500;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: var(--terra-stone);
        margin-bottom: 16px;
    }

    .legal-toc-list {
        list-style: none;
        padding: 0; margin: 0;
    }

    .legal-toc-list li { margin-bottom: 2px; }

    .legal-toc-list a {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: .78rem;
        color: var(--terra-stone);
        text-decoration: none;
        padding: 6px 10px 6px 12px;
        border-left: 2px solid transparent;
        transition: color .18s, border-color .18s;
        line-height: 1.4;
    }

    .legal-toc-list a:hover,
    .legal-toc-list a.active {
        color: var(--terra-navy);
        border-left-color: var(--terra-orange);
    }

    .legal-body { font-family: 'DM Sans', sans-serif; }

    .legal-section {
        padding-bottom: 48px;
        margin-bottom: 48px;
        border-bottom: 1px solid var(--terra-border);
    }

    .legal-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .legal-section-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: .88rem;
        font-weight: 400;
        color: var(--terra-orange);
        letter-spacing: .08em;
        margin-bottom: 6px;
    }

    .legal-section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.65rem;
        font-weight: 500;
        color: var(--terra-navy);
        line-height: 1.2;
        margin-bottom: 20px;
    }

    .legal-body p {
        font-size: .92rem;
        color: #4A4540;
        line-height: 1.85;
        margin-bottom: 16px;
    }

    .legal-body p:last-child { margin-bottom: 0; }

    .legal-body ul {
        margin: 12px 0 20px 0;
        padding: 0;
        list-style: none;
    }

    .legal-body ul li {
        font-size: .88rem;
        color: #4A4540;
        line-height: 1.75;
        padding: 6px 0 6px 20px;
        position: relative;
        border-bottom: 1px solid var(--terra-border);
    }

    .legal-body ul li:last-child { border-bottom: none; }

    .legal-body ul li::before {
        content: '';
        position: absolute;
        left: 0; top: 16px;
        width: 5px; height: 1px;
        background: var(--terra-orange);
    }

    .legal-callout {
        background: var(--terra-cream);
        border-left: 3px solid var(--terra-orange);
        padding: 20px 24px;
        margin: 24px 0;
        border-radius: 0 8px 8px 0;
    }

    .legal-callout p {
        margin: 0;
        font-size: .86rem !important;
        color: var(--terra-navy) !important;
        font-weight: 500;
        line-height: 1.65 !important;
    }

    .legal-callout-icon {
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--terra-orange);
        margin-bottom: 8px;
        display: block;
    }

    .data-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
        margin: 20px 0;
    }

    .data-card {
        background: var(--terra-cream);
        border: 1px solid var(--terra-border);
        border-radius: 10px;
        padding: 18px 20px;
    }

    .data-card-icon {
        width: 32px; height: 32px;
        border-radius: 8px;
        background: rgba(25,38,93,.08);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 10px;
    }

    .data-card-title {
        font-family: 'DM Sans', sans-serif;
        font-size: .78rem;
        font-weight: 500;
        color: var(--terra-navy);
        margin-bottom: 4px;
    }

    .data-card-desc {
        font-family: 'DM Sans', sans-serif;
        font-size: .74rem;
        color: var(--terra-stone);
        line-height: 1.55;
        margin: 0;
    }

    .rights-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px;
        margin: 20px 0;
    }

    .right-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 14px 16px;
        border: 1px solid var(--terra-border);
        border-radius: 8px;
        background: #fff;
    }

    .right-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--terra-orange);
        flex-shrink: 0;
        margin-top: 5px;
    }

    .right-text { font-family: 'DM Sans', sans-serif; }

    .right-text strong {
        display: block;
        font-size: .8rem;
        font-weight: 500;
        color: var(--terra-navy);
        margin-bottom: 2px;
    }

    .right-text span {
        font-size: .76rem;
        color: var(--terra-stone);
        line-height: 1.5;
    }

    .legal-contact-card {
        background: var(--terra-navy);
        border-radius: 12px;
        padding: 36px 40px;
        margin-top: 48px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
    }

    .legal-contact-card h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem;
        font-weight: 400;
        color: #fff;
        margin: 0 0 6px;
    }

    .legal-contact-card p {
        font-family: 'DM Sans', sans-serif;
        font-size: .8rem;
        color: rgba(255,255,255,.55);
        margin: 0;
    }

    .legal-contact-card a {
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 500;
        color: var(--terra-navy);
        background: #fff;
        padding: 10px 24px;
        border-radius: 6px;
        text-decoration: none;
        white-space: nowrap;
        transition: background .18s;
    }

    .legal-contact-card a:hover {
        background: var(--terra-cream);
    }

    .breadcrumb-legal {
        background: var(--terra-cream);
        border-bottom: 1px solid var(--terra-border);
        padding: 12px 0;
    }

    .breadcrumb-legal ol {
        display: flex;
        list-style: none;
        padding: 0; margin: 0;
        font-size: .76rem;
        font-family: 'DM Sans', sans-serif;
        gap: 6px;
        align-items: center;
        max-width: 1080px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .breadcrumb-legal li { color: var(--terra-stone); }
    .breadcrumb-legal li a { color: var(--terra-stone); text-decoration: none; }
    .breadcrumb-legal li a:hover { color: var(--terra-navy); }
    .breadcrumb-legal li.sep { opacity: .4; }
    .breadcrumb-legal li.current { color: var(--terra-navy); font-weight: 500; }

    .update-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(208,82,8,.1);
        color: var(--terra-orange);
        font-size: .7rem;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 20px;
        margin-bottom: 20px;
    }

    .update-badge::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--terra-orange);
    }

    .cookie-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .82rem;
        margin: 16px 0;
    }

    .cookie-table th {
        font-family: 'DM Sans', sans-serif;
        font-size: .72rem;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--terra-stone);
        padding: 10px 14px;
        background: var(--terra-cream);
        border: 1px solid var(--terra-border);
        text-align: left;
    }

    .cookie-table td {
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        color: #4A4540;
        padding: 10px 14px;
        border: 1px solid var(--terra-border);
        vertical-align: top;
        line-height: 1.55;
    }

    .cookie-table tr:hover td {
        background: var(--terra-cream);
    }

    .cookie-badge {
        display: inline-block;
        font-size: .66rem;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 10px;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .badge-essential { background: rgba(30,122,90,.1); color: #1E7A5A; }
    .badge-analytics  { background: rgba(25,38,93,.1);  color: var(--terra-navy); }
    .badge-marketing  { background: rgba(208,82,8,.1);  color: var(--terra-orange); }
</style>


{{-- Breadcrumb --}}
<nav class="breadcrumb-legal">
    <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="sep">/</li>
        <li><a href="#">Legal</a></li>
        <li class="sep">/</li>
        <li class="current">Privacy Policy</li>
    </ol>
</nav>

{{-- Hero --}}
<section class="legal-hero">
    <div style="max-width:1080px;margin:0 auto;padding:0 24px;position:relative;z-index:1">
        <div class="legal-hero-eyebrow">Terra Real Estate · Legal Documents</div>
        <h1 class="legal-hero-title">Privacy <em>Policy</em></h1>
        <div class="legal-hero-meta">
            <span>Effective: January 1, 2025</span>
            <span>Last Updated: April 1, 2025</span>
            <span>PDPA Compliant</span>
        </div>
    </div>
</section>

{{-- Body --}}
<div style="background:#fff">
    <div class="legal-layout">

        {{-- Sticky TOC --}}
        <aside class="legal-toc">
            <div class="legal-toc-label">Contents</div>
            <ul class="legal-toc-list" id="tocList">
                <li><a href="#overview">1. Overview</a></li>
                <li><a href="#information">2. Information We Collect</a></li>
                <li><a href="#how-we-use">3. How We Use Your Data</a></li>
                <li><a href="#sharing">4. Sharing & Disclosure</a></li>
                <li><a href="#cookies">5. Cookies & Tracking</a></li>
                <li><a href="#retention">6. Data Retention</a></li>
                <li><a href="#security">7. Security</a></li>
                <li><a href="#rights">8. Your Rights</a></li>
                <li><a href="#children">9. Children's Privacy</a></li>
                <li><a href="#international">10. International Transfers</a></li>
                <li><a href="#changes">11. Policy Changes</a></li>
                <li><a href="#contact">12. Contact & DPO</a></li>
            </ul>
        </aside>

        {{-- Body --}}
        <main class="legal-body">

            <div class="update-badge">PDPA Compliant · 2025</div>

            <div class="legal-callout" style="margin-top:0">
                <span class="legal-callout-icon">Your privacy matters</span>
                <p>At Terra Real Estate, we believe trust begins with transparency. This policy explains exactly what data we collect, why we collect it, and how you can control it. We are committed to protecting your personal information in accordance with the Personal Data Protection Act 2010 (Malaysia) and applicable international standards.</p>
            </div>

            {{-- Section 1 --}}
            <section class="legal-section" id="overview">
                <div class="legal-section-number">Section 01</div>
                <h2 class="legal-section-title">Overview & Controller</h2>
                <p>This Privacy Policy describes how <strong>Terra Real Estate Sdn. Bhd.</strong> ("Terra," "we," "us," or "our") collects, uses, stores, and protects personal data when you use our website, mobile applications, and related services (collectively, the "Platform").</p>
                <p>Terra Real Estate Sdn. Bhd. is the data controller responsible for your personal data. Our registered address is Level 18, Menara Terra, Jalan Ampang, 50450 Kuala Lumpur, Malaysia.</p>
                <p>This Policy applies to all visitors, registered users, property listers, agents, and other individuals who interact with our Platform. By accessing or using our Services, you consent to the practices described in this Policy. If you do not agree, please discontinue use and contact us to request deletion of any data we hold about you.</p>
            </section>

            {{-- Section 2 --}}
            <section class="legal-section" id="information">
                <div class="legal-section-number">Section 02</div>
                <h2 class="legal-section-title">Information We Collect</h2>
                <p>We collect personal data in the following categories depending on how you use our Platform:</p>

                <div class="data-grid">
                    <div class="data-card">
                        <div class="data-card-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" fill="var(--terra-navy)"/>
                            </svg>
                        </div>
                        <div class="data-card-title">Identity Data</div>
                        <p class="data-card-desc">Name, NRIC/passport number, date of birth, gender, profile photo</p>
                    </div>
                    <div class="data-card">
                        <div class="data-card-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" fill="var(--terra-navy)"/>
                            </svg>
                        </div>
                        <div class="data-card-title">Contact Data</div>
                        <p class="data-card-desc">Email address, phone number, mailing address, WhatsApp number</p>
                    </div>
                    <div class="data-card">
                        <div class="data-card-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="var(--terra-navy)"/>
                            </svg>
                        </div>
                        <div class="data-card-title">Property Data</div>
                        <p class="data-card-desc">Listing details, search history, saved properties, inquiry records</p>
                    </div>
                    <div class="data-card">
                        <div class="data-card-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z" fill="var(--terra-navy)"/>
                            </svg>
                        </div>
                        <div class="data-card-title">Transaction Data</div>
                        <p class="data-card-desc">Subscription details, payment records, invoice history</p>
                    </div>
                    <div class="data-card">
                        <div class="data-card-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.18 2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" stroke="var(--terra-navy)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="data-card-title">Usage Data</div>
                        <p class="data-card-desc">IP address, device type, browser, pages visited, click behaviour</p>
                    </div>
                    <div class="data-card">
                        <div class="data-card-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="var(--terra-navy)" stroke-width="2"/>
                                <path d="M12 8v4M12 16h.01" stroke="var(--terra-navy)" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="data-card-title">Communications</div>
                        <p class="data-card-desc">Messages with agents, support tickets, feedback, survey responses</p>
                    </div>
                </div>

                <p>We also collect data through cookies, tracking pixels, and analytics tools. Please see Section 5 for details. We do not collect special categories of sensitive personal data (such as race, religion, health, or biometric data) unless explicitly required and with your clear consent.</p>

                <p><strong>Data you provide voluntarily:</strong> When you register, list a property, submit an inquiry, or contact our support team, you provide data directly to us. Providing certain data is mandatory to use specific features; where it is optional, we will make this clear.</p>

                <p><strong>Data collected automatically:</strong> Our servers and third-party analytics tools automatically record certain technical information when you interact with our Platform, including your IP address, browser type, operating system, referring URLs, and pages viewed.</p>
            </section>

            {{-- Section 3 --}}
            <section class="legal-section" id="how-we-use">
                <div class="legal-section-number">Section 03</div>
                <h2 class="legal-section-title">How We Use Your Data</h2>
                <p>We process your personal data only for specific, legitimate purposes. The legal basis for each processing activity is noted in parentheses:</p>
                <ul>
                    <li>To create and manage your account and verify your identity <em>(Contract performance)</em></li>
                    <li>To display and manage property listings and facilitate buyer–seller connections <em>(Contract performance)</em></li>
                    <li>To process payments and maintain financial records <em>(Legal obligation)</em></li>
                    <li>To send transactional emails, account alerts, and notifications <em>(Contract performance)</em></li>
                    <li>To provide personalised property recommendations based on your search history <em>(Legitimate interest)</em></li>
                    <li>To send marketing communications, newsletters, and promotional offers — only with your consent <em>(Consent)</em></li>
                    <li>To improve, maintain, and develop our Platform and Services <em>(Legitimate interest)</em></li>
                    <li>To conduct analytics and generate aggregated, anonymised market reports <em>(Legitimate interest)</em></li>
                    <li>To prevent fraud, abuse, and unauthorized use of the Platform <em>(Legal obligation / Legitimate interest)</em></li>
                    <li>To comply with applicable legal obligations, court orders, or regulatory requirements <em>(Legal obligation)</em></li>
                </ul>
                <div class="legal-callout">
                    <span class="legal-callout-icon">Marketing opt-out</span>
                    <p>You may withdraw consent for marketing communications at any time by clicking "Unsubscribe" in any marketing email, updating your account notification preferences, or emailing us at <strong>privacy@terraestates.com</strong>. Withdrawal does not affect the lawfulness of prior processing.</p>
                </div>
            </section>

            {{-- Section 4 --}}
            <section class="legal-section" id="sharing">
                <div class="legal-section-number">Section 04</div>
                <h2 class="legal-section-title">Sharing & Disclosure</h2>
                <p>We do not sell, rent, or trade your personal data. We share data only in the following limited circumstances:</p>
                <ul>
                    <li><strong>Real estate agents and agencies:</strong> When you submit an inquiry about a property, your contact details and message are shared with the listing agent to facilitate the response. You consent to this by submitting an inquiry.</li>
                    <li><strong>Service providers:</strong> We engage trusted third-party vendors to provide services on our behalf (e.g., cloud hosting, email delivery, analytics, payment processing). These parties process data only on our instructions under binding data processing agreements.</li>
                    <li><strong>Business partners:</strong> With your explicit consent, we may share data with mortgage brokers, legal firms, and conveyancers who offer services relevant to your property transaction.</li>
                    <li><strong>Legal requirements:</strong> We will disclose data to government authorities, regulators, or courts when required by law, legal process, or to protect the rights, property, or safety of Terra, its users, or the public.</li>
                    <li><strong>Business transfers:</strong> In the event of a merger, acquisition, or sale of assets, your data may be transferred to a successor entity. We will notify registered users before data is transferred and becomes subject to a different privacy policy.</li>
                    <li><strong>Aggregated data:</strong> We may share anonymised, aggregated statistical data about Platform usage and property market trends with partners, researchers, and the public. This data cannot identify you personally.</li>
                </ul>
            </section>

            {{-- Section 5 --}}
            <section class="legal-section" id="cookies">
                <div class="legal-section-number">Section 05</div>
                <h2 class="legal-section-title">Cookies & Tracking Technologies</h2>
                <p>We use cookies, web beacons, pixels, and similar tracking technologies to enhance your experience, analyse usage patterns, and deliver relevant content. You can manage your cookie preferences at any time through your browser settings or our cookie preference centre.</p>

                <table class="cookie-table">
                    <thead>
                        <tr>
                            <th style="width:120px">Type</th>
                            <th>Purpose</th>
                            <th style="width:90px">Duration</th>
                            <th style="width:90px">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Session Cookies</strong></td>
                            <td>Keep you logged in and maintain your session state while browsing</td>
                            <td>Session</td>
                            <td><span class="cookie-badge badge-essential">Essential</span></td>
                        </tr>
                        <tr>
                            <td><strong>Preference Cookies</strong></td>
                            <td>Remember your settings such as language, currency, and filter preferences</td>
                            <td>1 year</td>
                            <td><span class="cookie-badge badge-essential">Essential</span></td>
                        </tr>
                        <tr>
                            <td><strong>Analytics Cookies</strong></td>
                            <td>Collect anonymised data about how users interact with the Platform (Google Analytics, Hotjar)</td>
                            <td>2 years</td>
                            <td><span class="cookie-badge badge-analytics">Analytics</span></td>
                        </tr>
                        <tr>
                            <td><strong>Advertising Cookies</strong></td>
                            <td>Track visits across websites to display relevant property ads and measure campaign performance</td>
                            <td>90 days</td>
                            <td><span class="cookie-badge badge-marketing">Marketing</span></td>
                        </tr>
                        <tr>
                            <td><strong>Social Media Pixels</strong></td>
                            <td>Enable social sharing features and track conversions from social media campaigns</td>
                            <td>180 days</td>
                            <td><span class="cookie-badge badge-marketing">Marketing</span></td>
                        </tr>
                    </tbody>
                </table>

                <p>Essential cookies cannot be disabled as they are required for the Platform to function. You may opt out of analytics and marketing cookies via our cookie banner or by adjusting your browser settings. Note that disabling cookies may affect your experience on the Platform.</p>
            </section>

            {{-- Section 6 --}}
            <section class="legal-section" id="retention">
                <div class="legal-section-number">Section 06</div>
                <h2 class="legal-section-title">Data Retention</h2>
                <p>We retain your personal data only for as long as necessary to fulfil the purposes for which it was collected, or as required by applicable law:</p>
                <ul>
                    <li><strong>Active account data:</strong> Retained for the duration of your account plus 3 years after account closure</li>
                    <li><strong>Transaction and financial records:</strong> Retained for 7 years to comply with Malaysian tax and accounting regulations</li>
                    <li><strong>Property listing data:</strong> Retained for 2 years after a listing expires or is removed</li>
                    <li><strong>Inquiry and communication records:</strong> Retained for 3 years from the date of the last communication</li>
                    <li><strong>Analytics data:</strong> Aggregated usage data retained indefinitely; identifiable session data deleted after 26 months</li>
                    <li><strong>Marketing preferences:</strong> Retained until you withdraw consent or request erasure</li>
                </ul>
                <p>Upon expiry of the relevant retention period, we securely delete or anonymise your personal data. In certain circumstances (such as ongoing legal proceedings), we may retain data beyond these standard periods.</p>
            </section>

            {{-- Section 7 --}}
            <section class="legal-section" id="security">
                <div class="legal-section-number">Section 07</div>
                <h2 class="legal-section-title">Security Measures</h2>
                <p>We implement appropriate technical and organisational security measures to protect your personal data against unauthorized access, accidental loss, disclosure, alteration, or destruction. Our security practices include:</p>
                <ul>
                    <li>SSL/TLS encryption for all data transmitted between your browser and our servers</li>
                    <li>AES-256 encryption for sensitive data stored in our databases</li>
                    <li>Multi-factor authentication options for all registered accounts</li>
                    <li>Regular security audits, vulnerability assessments, and penetration testing</li>
                    <li>Role-based access controls limiting staff access to personal data on a need-to-know basis</li>
                    <li>Comprehensive data breach response procedures with regulatory notification obligations</li>
                    <li>Annual security awareness training for all staff who handle personal data</li>
                </ul>
                <div class="legal-callout">
                    <span class="legal-callout-icon">Reporting a breach</span>
                    <p>If you believe your account has been compromised or you discover a security vulnerability in our Platform, please contact us immediately at <strong>security@terraestates.com</strong>. We take all security reports seriously and will respond within 24 hours.</p>
                </div>
                <p>Despite our best efforts, no method of electronic transmission or storage is 100% secure. We cannot guarantee absolute security but are committed to continuously improving our security posture.</p>
            </section>

            {{-- Section 8 --}}
            <section class="legal-section" id="rights">
                <div class="legal-section-number">Section 08</div>
                <h2 class="legal-section-title">Your Rights</h2>
                <p>Under the Personal Data Protection Act 2010 (Malaysia) and, where applicable, international data protection regulations, you have the following rights regarding your personal data:</p>

                <div class="rights-grid">
                    <div class="right-item">
                        <div class="right-dot"></div>
                        <div class="right-text">
                            <strong>Right of Access</strong>
                            <span>Request a copy of all personal data we hold about you</span>
                        </div>
                    </div>
                    <div class="right-item">
                        <div class="right-dot"></div>
                        <div class="right-text">
                            <strong>Right to Rectification</strong>
                            <span>Correct any inaccurate or incomplete data</span>
                        </div>
                    </div>
                    <div class="right-item">
                        <div class="right-dot"></div>
                        <div class="right-text">
                            <strong>Right to Erasure</strong>
                            <span>Request deletion of your data where no longer necessary</span>
                        </div>
                    </div>
                    <div class="right-item">
                        <div class="right-dot"></div>
                        <div class="right-text">
                            <strong>Right to Restrict Processing</strong>
                            <span>Limit how we use your data in certain circumstances</span>
                        </div>
                    </div>
                    <div class="right-item">
                        <div class="right-dot"></div>
                        <div class="right-text">
                            <strong>Right to Data Portability</strong>
                            <span>Receive your data in a structured, machine-readable format</span>
                        </div>
                    </div>
                    <div class="right-item">
                        <div class="right-dot"></div>
                        <div class="right-text">
                            <strong>Right to Object</strong>
                            <span>Object to processing based on legitimate interests or for direct marketing</span>
                        </div>
                    </div>
                    <div class="right-item">
                        <div class="right-dot"></div>
                        <div class="right-text">
                            <strong>Withdraw Consent</strong>
                            <span>Withdraw consent for consent-based processing at any time</span>
                        </div>
                    </div>
                    <div class="right-item">
                        <div class="right-dot"></div>
                        <div class="right-text">
                            <strong>Right to Complain</strong>
                            <span>Lodge a complaint with the Personal Data Protection Commissioner</span>
                        </div>
                    </div>
                </div>

                <p>To exercise any of these rights, please submit a written request to <strong>privacy@terraestates.com</strong> or contact our Data Protection Officer directly. We will respond within 21 days. We may need to verify your identity before fulfilling your request. Certain requests may be subject to legal exemptions.</p>
            </section>

            {{-- Section 9 --}}
            <section class="legal-section" id="children">
                <div class="legal-section-number">Section 09</div>
                <h2 class="legal-section-title">Children's Privacy</h2>
                <p>Our Platform is not intended for children under the age of 18. We do not knowingly collect personal data from individuals under 18 years of age. If you are a parent or guardian and believe your child has provided us with personal data without your consent, please contact us immediately at <strong>privacy@terraestates.com</strong>.</p>
                <p>Upon receiving such a request, we will promptly investigate and, where confirmed, delete the relevant personal data from our systems.</p>
            </section>

            {{-- Section 10 --}}
            <section class="legal-section" id="international">
                <div class="legal-section-number">Section 10</div>
                <h2 class="legal-section-title">International Data Transfers</h2>
                <p>Terra Real Estate's primary operations are based in Malaysia. Some of our third-party service providers may process your data in other countries, including Singapore, the United States, and the European Union.</p>
                <p>Where personal data is transferred outside Malaysia, we take appropriate safeguards to ensure your data receives an equivalent level of protection, including:</p>
                <ul>
                    <li>Transferring data only to countries with adequate data protection laws as recognised by Malaysian authorities</li>
                    <li>Entering into Standard Contractual Clauses approved by relevant regulatory bodies</li>
                    <li>Conducting transfer impact assessments for high-risk transfers</li>
                    <li>Ensuring service providers are certified under internationally recognised privacy frameworks</li>
                </ul>
            </section>

            {{-- Section 11 --}}
            <section class="legal-section" id="changes">
                <div class="legal-section-number">Section 11</div>
                <h2 class="legal-section-title">Policy Changes</h2>
                <p>We may update this Privacy Policy from time to time to reflect changes in our practices, technology, legal requirements, or other factors. When we make material changes, we will:</p>
                <ul>
                    <li>Post the updated policy on this page with a revised "Last Updated" date</li>
                    <li>Send a notification email to all registered users at least 14 days before changes take effect</li>
                    <li>Display a prominent notice on the Platform for 30 days following the update</li>
                    <li>Where required by law, seek your renewed consent for material changes</li>
                </ul>
                <p>We encourage you to review this Policy periodically. Your continued use of the Platform after changes take effect constitutes acceptance of the revised Policy.</p>
            </section>

            {{-- Section 12 --}}
            <section class="legal-section" id="contact">
                <div class="legal-section-number">Section 12</div>
                <h2 class="legal-section-title">Contact Us & Data Protection Officer</h2>
                <p>Terra Real Estate has appointed a Data Protection Officer (DPO) to oversee compliance with this Policy and applicable data protection legislation. If you have any questions, concerns, or requests regarding this Privacy Policy or your personal data, please contact:</p>
                <ul>
                    <li><strong>Data Protection Officer:</strong> Encik Ahmad Faris bin Aziz</li>
                    <li><strong>Email:</strong> dpo@terraestates.com</li>
                    <li><strong>Privacy Requests:</strong> privacy@terraestates.com</li>
                    <li><strong>Security Concerns:</strong> security@terraestates.com</li>
                    <li><strong>Address:</strong> Terra Real Estate Sdn. Bhd., Level 18, Menara Terra, Jalan Ampang, 50450 Kuala Lumpur, Malaysia</li>
                    <li><strong>Response Time:</strong> We aim to respond to all privacy-related requests within 21 business days</li>
                </ul>
                <p>If you are not satisfied with our response, you have the right to lodge a complaint with the <strong>Personal Data Protection Commissioner of Malaysia</strong> (pdp.com.my).</p>
            </section>

            {{-- CTA Card --}}
            <div class="legal-contact-card">
                <div>
                    <h4>Have a privacy concern?</h4>
                    <p>Our Data Protection Officer responds within 21 business days.</p>
                </div>
                <a href="mailto:dpo@terraestates.com">Contact Our DPO</a>
            </div>

            {{-- Also see --}}
            <div style="margin-top:32px;padding:20px 24px;border:1px solid var(--terra-border);border-radius:10px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
                <div>
                    <div style="font-family:'DM Sans',sans-serif;font-size:.72rem;font-weight:500;letter-spacing:.12em;text-transform:uppercase;color:var(--terra-stone);margin-bottom:4px">Also see</div>
                    <div style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:500;color:var(--terra-navy)">Terms of Service</div>
                </div>
                <a href="{{ route('legal.terms') }}" style="font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:500;color:var(--terra-navy);border:1px solid var(--terra-border);padding:8px 20px;border-radius:6px;text-decoration:none;transition:background .18s" onmouseover="this.style.background='var(--terra-cream)'" onmouseout="this.style.background='transparent'">
                    View Terms →
                </a>
            </div>

        </main>
    </div>
</div>


<script>
    (function () {
        const sections = document.querySelectorAll('.legal-section');
        const links    = document.querySelectorAll('#tocList a');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    links.forEach(l => l.classList.remove('active'));
                    const id = entry.target.id;
                    const active = document.querySelector(`#tocList a[href="#${id}"]`);
                    if (active) active.classList.add('active');
                }
            });
        }, { rootMargin: '-30% 0px -60% 0px' });

        sections.forEach(s => observer.observe(s));

        links.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    })();
</script>


@endsection
