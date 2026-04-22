@extends('layouts.guest')
@section('title', 'Terms of Service — Terra Real Estate')

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
        background: var(--terra-navy);
        padding: 80px 0 64px;
        position: relative;
        overflow: hidden;
    }

    .legal-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 320px; height: 320px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,.06);
    }

    .legal-hero::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 10%;
        width: 200px; height: 200px;
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

    .legal-toc-list li {
        margin-bottom: 2px;
    }

    .legal-toc-list a {
        display: block;
        font-family: 'DM Sans', sans-serif;
        font-size: .78rem;
        color: var(--terra-stone);
        text-decoration: none;
        padding: 6px 10px 6px 0;
        border-left: 2px solid transparent;
        padding-left: 12px;
        transition: color .18s, border-color .18s;
        line-height: 1.4;
    }

    .legal-toc-list a:hover,
    .legal-toc-list a.active {
        color: var(--terra-navy);
        border-left-color: var(--terra-orange);
    }

    .legal-body {
        font-family: 'DM Sans', sans-serif;
    }

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
</style>


{{-- Breadcrumb --}}
<nav class="breadcrumb-legal">
    <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="sep">/</li>
        <li><a href="#">Legal</a></li>
        <li class="sep">/</li>
        <li class="current">Terms of Service</li>
    </ol>
</nav>

{{-- Hero --}}
<section class="legal-hero">
    <div style="max-width:1080px;margin:0 auto;padding:0 24px;position:relative;z-index:1">
        <div class="legal-hero-eyebrow">Terra Real Estate · Legal Documents</div>
        <h1 class="legal-hero-title">Terms of <em>Service</em></h1>
        <div class="legal-hero-meta">
            <span>Effective: January 1, 2025</span>
            <span>Last Updated: April 1, 2025</span>
            <span>Version 2.1</span>
        </div>
    </div>
</section>

{{-- Main content --}}
<div style="background:#fff">
    <div class="legal-layout">

        {{-- Sticky TOC --}}
        <aside class="legal-toc">
            <div class="legal-toc-label">Contents</div>
            <ul class="legal-toc-list" id="tocList">
                <li><a href="#acceptance">1. Acceptance</a></li>
                <li><a href="#services">2. Our Services</a></li>
                <li><a href="#eligibility">3. Eligibility</a></li>
                <li><a href="#accounts">4. User Accounts</a></li>
                <li><a href="#listings">5. Property Listings</a></li>
                <li><a href="#conduct">6. Acceptable Use</a></li>
                <li><a href="#intellectual">7. Intellectual Property</a></li>
                <li><a href="#privacy">8. Privacy</a></li>
                <li><a href="#disclaimers">9. Disclaimers</a></li>
                <li><a href="#liability">10. Limitation of Liability</a></li>
                <li><a href="#termination">11. Termination</a></li>
                <li><a href="#governing">12. Governing Law</a></li>
                <li><a href="#contact">13. Contact Us</a></li>
            </ul>
        </aside>

        {{-- Body --}}
        <main class="legal-body">

            <div class="update-badge">Recently Updated</div>

            <div class="legal-callout" style="margin-top:0">
                <span class="legal-callout-icon">Please read carefully</span>
                <p>These Terms of Service govern your access to and use of Terra Real Estate's platform, website, and services. By using our platform, you agree to be bound by these terms. If you do not agree, please discontinue use immediately.</p>
            </div>

            {{-- Section 1 --}}
            <section class="legal-section" id="acceptance">
                <div class="legal-section-number">Section 01</div>
                <h2 class="legal-section-title">Acceptance of Terms</h2>
                <p>By accessing or using the Terra Real Estate website located at <strong>terraestates.com</strong> ("Platform"), mobile applications, or any related services (collectively, "Services"), you acknowledge that you have read, understood, and agree to be legally bound by these Terms of Service ("Terms") and our Privacy Policy, which is incorporated herein by reference.</p>
                <p>These Terms constitute a legally binding agreement between you ("User," "you," or "your") and Terra Real Estate Sdn. Bhd. ("Terra," "we," "us," or "our"), a company registered under the laws of Malaysia. If you are using our Services on behalf of an organization, you represent and warrant that you have the authority to bind that organization to these Terms.</p>
                <p>We reserve the right to update these Terms at any time. Continued use of our Services following any changes constitutes your acceptance of the revised Terms. We will notify registered users of material changes via email or prominent notice on the Platform.</p>
            </section>

            {{-- Section 2 --}}
            <section class="legal-section" id="services">
                <div class="legal-section-number">Section 02</div>
                <h2 class="legal-section-title">Our Services</h2>
                <p>Terra Real Estate provides a comprehensive digital platform designed to connect property buyers, sellers, renters, and real estate professionals. Our Services include, but are not limited to:</p>
                <ul>
                    <li>Property listing search and discovery tools for residential and commercial properties</li>
                    <li>Direct inquiry and communication channels between buyers, sellers, and agents</li>
                    <li>Property valuation estimates and market analytics dashboards</li>
                    <li>Agent and agency profile pages with verified credentials</li>
                    <li>Document management and transaction coordination tools</li>
                    <li>Mortgage and financing calculator and referral services</li>
                    <li>Neighbourhood insights including schools, amenities, and commute data</li>
                    <li>Virtual tours and 3D property walkthroughs where available</li>
                </ul>
                <p>Terra acts as an intermediary platform and is not a licensed real estate agency unless explicitly stated. All transactions are conducted between the parties involved, and Terra is not a party to any purchase, sale, or rental agreement unless otherwise specified in a separate written agreement.</p>
            </section>

            {{-- Section 3 --}}
            <section class="legal-section" id="eligibility">
                <div class="legal-section-number">Section 03</div>
                <h2 class="legal-section-title">Eligibility</h2>
                <p>To access and use our Services, you must:</p>
                <ul>
                    <li>Be at least 18 years of age or the age of majority in your jurisdiction</li>
                    <li>Have the legal capacity to enter into binding contracts</li>
                    <li>Not be prohibited from receiving our Services under applicable law</li>
                    <li>Provide accurate, complete, and current registration information</li>
                    <li>Comply with all applicable local, state, national, and international laws and regulations</li>
                </ul>
                <p>Terra reserves the right to refuse service, terminate accounts, or remove content at our sole discretion for any reason, including but not limited to violations of these Terms.</p>
            </section>

            {{-- Section 4 --}}
            <section class="legal-section" id="accounts">
                <div class="legal-section-number">Section 04</div>
                <h2 class="legal-section-title">User Accounts</h2>
                <p>Certain features of our Platform require you to create an account. When registering, you agree to provide accurate and complete information and to keep this information up to date. You are solely responsible for:</p>
                <ul>
                    <li>Maintaining the confidentiality of your account credentials and password</li>
                    <li>All activities that occur under your account, whether authorized or not</li>
                    <li>Notifying Terra immediately of any unauthorized use or security breach</li>
                    <li>Ensuring your account information remains accurate and current</li>
                </ul>
                <div class="legal-callout">
                    <span class="legal-callout-icon">Security Notice</span>
                    <p>Terra will never ask for your password via email or phone. If you suspect unauthorized access, change your password immediately and contact our support team at <strong>security@terraestates.com</strong>.</p>
                </div>
                <p>You may not create accounts using automated means, create multiple accounts for abusive purposes, or transfer your account to another person without our written consent. Each individual may maintain only one personal account.</p>
            </section>

            {{-- Section 5 --}}
            <section class="legal-section" id="listings">
                <div class="legal-section-number">Section 05</div>
                <h2 class="legal-section-title">Property Listings & Content</h2>
                <p>Users who submit property listings to our Platform represent and warrant that:</p>
                <ul>
                    <li>All information provided is accurate, complete, and not misleading in any material respect</li>
                    <li>You hold all necessary rights, permissions, and licences for any content submitted, including photographs and descriptions</li>
                    <li>The property is legally available for sale or rent at the stated price and on the stated terms</li>
                    <li>You will promptly update or remove listings when the property status changes</li>
                    <li>You will respond to genuine inquiries in a timely and professional manner</li>
                    <li>No discriminatory conditions or restrictions will be applied in violation of applicable housing laws</li>
                </ul>
                <p>Terra reserves the right to review, edit, reject, or remove any listing that violates these Terms, applicable law, or our community standards, without notice and at our sole discretion. We do not guarantee the accuracy of user-submitted listings and disclaim all liability for inaccuracies therein.</p>
                <p>Listing fees, subscription charges, and premium placement fees are non-refundable once a listing has been published, except as required by applicable consumer protection law.</p>
            </section>

            {{-- Section 6 --}}
            <section class="legal-section" id="conduct">
                <div class="legal-section-number">Section 06</div>
                <h2 class="legal-section-title">Acceptable Use</h2>
                <p>You agree not to use our Platform to:</p>
                <ul>
                    <li>Post false, misleading, fraudulent, or deceptive property listings or information</li>
                    <li>Scrape, harvest, or collect data from the Platform using automated tools without written permission</li>
                    <li>Circumvent, disable, or interfere with security-related features of the Platform</li>
                    <li>Transmit spam, unsolicited commercial messages, or chain letters</li>
                    <li>Impersonate any person or entity, or misrepresent your affiliation with any entity</li>
                    <li>Engage in any form of discriminatory conduct in connection with property transactions</li>
                    <li>Use the Platform for any unlawful purpose or in violation of any applicable regulations</li>
                    <li>Attempt to gain unauthorized access to any portion of the Platform or its related systems</li>
                    <li>Interfere with or disrupt the integrity or performance of the Platform</li>
                    <li>Post content that is defamatory, obscene, harassing, or otherwise objectionable</li>
                </ul>
                <p>Violations of our acceptable use policy may result in immediate suspension or termination of your account, removal of content, and where warranted, referral to appropriate legal authorities.</p>
            </section>

            {{-- Section 7 --}}
            <section class="legal-section" id="intellectual">
                <div class="legal-section-number">Section 07</div>
                <h2 class="legal-section-title">Intellectual Property</h2>
                <p>The Terra Real Estate Platform, including its design, layout, graphics, logos, icons, text, software, and all other content (collectively, "Terra Content"), is owned by or licensed to Terra Real Estate Sdn. Bhd. and is protected by applicable intellectual property laws.</p>
                <p>You are granted a limited, non-exclusive, non-transferable, revocable licence to access and use the Platform and Terra Content solely for personal, non-commercial purposes in accordance with these Terms. You may not reproduce, modify, distribute, transmit, display, perform, publish, license, create derivative works from, transfer, or sell any Terra Content without our prior written consent.</p>
                <p>By submitting content to our Platform (including photographs, descriptions, reviews, and comments), you grant Terra a worldwide, royalty-free, non-exclusive, sublicensable licence to use, reproduce, modify, adapt, publish, translate, distribute, and display such content in connection with providing and promoting our Services.</p>
                <p>You retain ownership of content you submit, but represent and warrant that such content does not infringe the intellectual property rights of any third party.</p>
            </section>

            {{-- Section 8 --}}
            <section class="legal-section" id="privacy">
                <div class="legal-section-number">Section 08</div>
                <h2 class="legal-section-title">Privacy</h2>
                <p>Your use of our Services is also governed by our <a href="{{ route('legal.privacy') }}" style="color:var(--terra-orange);text-decoration:none;font-weight:500;border-bottom:1px solid rgba(208,82,8,.3)">Privacy Policy</a>, which is incorporated into these Terms by reference. Please review our Privacy Policy carefully to understand how we collect, use, and share information about you.</p>
                <p>By using our Services, you consent to the collection, use, and disclosure of your personal information as described in our Privacy Policy. If you do not agree to the Privacy Policy, please do not use our Services.</p>
            </section>

            {{-- Section 9 --}}
            <section class="legal-section" id="disclaimers">
                <div class="legal-section-number">Section 09</div>
                <h2 class="legal-section-title">Disclaimers</h2>
                <p>OUR SERVICES ARE PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT.</p>
                <p>Terra does not warrant that:</p>
                <ul>
                    <li>The Platform will be uninterrupted, error-free, or secure at all times</li>
                    <li>Any information, including property listings and valuations, is accurate or complete</li>
                    <li>Any defects in the Platform will be corrected</li>
                    <li>The Platform is free of viruses or other harmful components</li>
                </ul>
                <div class="legal-callout">
                    <span class="legal-callout-icon">Important</span>
                    <p>Property valuations and market estimates provided by Terra are for informational purposes only and do not constitute professional appraisal, financial, legal, or investment advice. Always engage qualified professionals for property transactions.</p>
                </div>
            </section>

            {{-- Section 10 --}}
            <section class="legal-section" id="liability">
                <div class="legal-section-number">Section 10</div>
                <h2 class="legal-section-title">Limitation of Liability</h2>
                <p>TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, TERRA REAL ESTATE AND ITS DIRECTORS, EMPLOYEES, AGENTS, AND LICENSORS SHALL NOT BE LIABLE FOR ANY INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL, OR PUNITIVE DAMAGES ARISING FROM YOUR USE OF OR INABILITY TO USE OUR SERVICES.</p>
                <p>In no event shall Terra's total cumulative liability to you for all claims relating to our Services exceed the greater of (a) the amounts paid by you to Terra in the twelve months preceding the claim, or (b) one hundred Malaysian Ringgit (MYR 100).</p>
                <p>Some jurisdictions do not allow the exclusion of certain warranties or limitation of liability. In such jurisdictions, our liability is limited to the maximum extent permitted by law.</p>
            </section>

            {{-- Section 11 --}}
            <section class="legal-section" id="termination">
                <div class="legal-section-number">Section 11</div>
                <h2 class="legal-section-title">Termination</h2>
                <p>Either party may terminate these Terms at any time. You may close your account at any time by contacting us at <strong>support@terraestates.com</strong> or through your account settings.</p>
                <p>Terra may suspend or terminate your access immediately, without prior notice or liability, for any reason, including if you breach these Terms. Upon termination:</p>
                <ul>
                    <li>Your right to access and use the Services will immediately cease</li>
                    <li>We may delete your account and all associated data, subject to our data retention obligations</li>
                    <li>Any active listings may be removed from the Platform</li>
                    <li>All provisions of these Terms which by their nature should survive termination will do so</li>
                </ul>
            </section>

            {{-- Section 12 --}}
            <section class="legal-section" id="governing">
                <div class="legal-section-number">Section 12</div>
                <h2 class="legal-section-title">Governing Law & Disputes</h2>
                <p>These Terms shall be governed by and construed in accordance with the laws of Malaysia, without regard to its conflict of law principles. Any disputes arising from or relating to these Terms or our Services shall be subject to the exclusive jurisdiction of the courts of Kuala Lumpur, Malaysia.</p>
                <p>Before initiating formal legal proceedings, you agree to first attempt to resolve any dispute informally by contacting Terra at <strong>legal@terraestates.com</strong>. We will make reasonable efforts to resolve disputes within 30 days of receiving written notice.</p>
                <p>Nothing in this section prevents either party from seeking urgent injunctive or other equitable relief from a court of competent jurisdiction.</p>
            </section>

            {{-- Section 13 --}}
            <section class="legal-section" id="contact">
                <div class="legal-section-number">Section 13</div>
                <h2 class="legal-section-title">Contact Us</h2>
                <p>If you have any questions, concerns, or requests relating to these Terms of Service, please contact our legal team:</p>
                <ul>
                    <li><strong>Email:</strong> legal@terraestates.com</li>
                    <li><strong>General Support:</strong> support@terraestates.com</li>
                    <li><strong>Address:</strong> Terra Real Estate Sdn. Bhd., Level 18, Menara Terra, Jalan Ampang, 50450 Kuala Lumpur, Malaysia</li>
                    <li><strong>Business Hours:</strong> Monday – Friday, 9:00 AM – 6:00 PM (MYT)</li>
                </ul>
            </section>

            {{-- CTA Card --}}
            <div class="legal-contact-card">
                <div>
                    <h4>Questions about our terms?</h4>
                    <p>Our legal team is happy to clarify anything you need.</p>
                </div>
                <a href="mailto:legal@terraestates.com">Contact Legal Team</a>
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
