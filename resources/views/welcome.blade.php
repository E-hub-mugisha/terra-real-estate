<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Terra | Your Complete Real Estate Partner in Rwanda</title>
    <meta name="description" content="Discover Terra's complete real estate ecosystem in Rwanda. Find properties, access professional brokerage, manage rentals and explore property services.">
    <meta name="theme-color" content="#101A44">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --orange: #D05208;
            --orange-dark: #AD4307;
            --orange-soft: #FDEEE4;
            --navy: #19265D;
            --navy-deep: #101A44;
            --ink: #1D2333;
            --muted: #636B7E;
            --paper: #F5F6F9;
            --line: #E4E7EE;
            --radius-lg: 28px;
            --radius-md: 16px;
            --radius-sm: 10px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 84px;
        }

        body {
            font-family: 'Figtree', system-ui, sans-serif;
            color: var(--ink);
            background: #fff;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Bricolage Grotesque', 'Figtree', sans-serif;
            font-weight: 700;
            letter-spacing: -.02em;
            color: var(--navy);
        }

        a {
            text-decoration: none;
        }

        :focus-visible {
            outline: 3px solid var(--orange);
            outline-offset: 3px;
            border-radius: 6px;
        }

        .skip-link {
            position: absolute;
            left: 12px;
            top: -60px;
            z-index: 2000;
            background: var(--orange);
            color: #fff;
            padding: 10px 16px;
            border-radius: 8px;
        }

        .skip-link:focus {
            top: 12px;
            color: #fff;
        }

        /* Buttons */
        .btn-terra,
        .btn-ghost,
        .btn-light-terra {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 700;
            font-size: 15px;
            padding: 14px 26px;
            border-radius: 999px;
            border: 1.5px solid transparent;
            transition: background .2s, color .2s, border-color .2s, transform .2s;
        }

        .btn-terra {
            background: var(--orange);
            color: #fff;
        }

        .btn-terra:hover {
            background: var(--orange-dark);
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-ghost {
            border-color: rgba(255, 255, 255, .35);
            color: #fff;
        }

        .btn-ghost:hover {
            background: #fff;
            color: var(--navy);
        }

        .btn-light-terra {
            background: #fff;
            color: var(--navy);
        }

        .btn-light-terra:hover {
            background: var(--orange-soft);
            color: var(--orange-dark);
        }

        /* Navigation */
        .site-nav {
            position: fixed;
            inset: 0 0 auto 0;
            z-index: 1030;
            padding: 16px 0;
            transition: background .3s, padding .3s, box-shadow .3s;
        }

        .site-nav.scrolled {
            background: rgba(16, 26, 68, .96);
            backdrop-filter: blur(10px);
            padding: 10px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800;
            font-size: 26px;
            letter-spacing: -.04em;
        }

        .brand:hover {
            color: #fff;
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            background: var(--orange);
            display: grid;
            place-items: center;
            font-size: 20px;
        }

        .brand .dot {
            color: var(--orange);
        }

        .site-nav .nav-link {
            color: rgba(255, 255, 255, .85);
            font-weight: 600;
            font-size: 15px;
            padding: 8px 12px !important;
        }

        .site-nav .nav-link:hover {
            color: #fff;
        }

        .navbar-toggler {
            border: 0;
            color: #fff;
            padding: 4px;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        @media (max-width: 991px) {
            .site-nav .navbar-collapse {
                background: var(--navy-deep);
                margin-top: 14px;
                padding: 18px;
                border-radius: var(--radius-md);
            }
        }

        /* Hero */
        .hero {
            background: var(--navy-deep);
            color: #fff;
            padding: 150px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            color: #fff;
            font-weight: 800;
            font-size: clamp(40px, 5.6vw, 72px);
            line-height: 1.04;
            letter-spacing: -.035em;
            margin-bottom: 22px;
        }

        .hero-lead {
            font-size: 18px;
            line-height: 1.7;
            color: rgba(255, 255, 255, .78);
            max-width: 500px;
            margin-bottom: 32px;
        }

        .hero-trust {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 22px;
            margin-top: 30px;
            color: rgba(255, 255, 255, .75);
            font-size: 14px;
            font-weight: 500;
        }

        .hero-trust i {
            color: #F59A62;
            margin-right: 6px;
        }

        .hero-visual {
            position: relative;
            padding-bottom: 20px;
        }

        .arch {
            border-radius: 280px 280px var(--radius-lg) var(--radius-lg);
            overflow: hidden;
            aspect-ratio: 4 / 4.6;
            background: var(--navy);
            border: 8px solid rgba(255, 255, 255, .08);
        }

        .arch img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-tag {
            position: absolute;
            left: -10px;
            bottom: 50px;
            background: #fff;
            color: var(--ink);
            border-radius: var(--radius-md);
            padding: 14px 18px;
            display: flex;
            gap: 12px;
            align-items: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .3);
            max-width: 250px;
        }

        .hero-tag .ico {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--orange-soft);
            color: var(--orange);
            display: grid;
            place-items: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .hero-tag strong {
            display: block;
            font-size: 15px;
            color: var(--navy);
            line-height: 1.2;
        }

        .hero-tag span {
            font-size: 13px;
            color: var(--muted);
        }

        /* Section basics */
        .section {
            padding: 96px 0;
        }

        .section-title {
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.12;
            margin-bottom: 14px;
        }

        .section-copy {
            color: var(--muted);
            font-size: 17px;
            line-height: 1.7;
            max-width: 560px;
        }

        /* Bento services */
        .bento {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
        }

        .tile {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            padding: 34px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            min-height: 380px;
            color: #fff;
            isolation: isolate;
        }

        .tile img.bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
            transition: transform .6s;
        }

        .tile::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background: linear-gradient(180deg, rgba(16, 26, 68, .1) 20%, rgba(16, 26, 68, .92) 100%);
        }

        .tile:hover img.bg {
            transform: scale(1.04);
        }

        .tile h3 {
            color: #fff;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .tile p {
            color: rgba(255, 255, 255, .85);
            line-height: 1.65;
            margin-bottom: 20px;
            max-width: 460px;
        }

        .tile-link {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            font-weight: 700;
            align-self: flex-start;
        }

        .tile-link .arr {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--orange);
            display: grid;
            place-items: center;
            transition: transform .25s;
        }

        .tile:hover .arr {
            transform: rotate(45deg);
        }

        .tile-a {
            grid-column: span 7;
        }

        .tile-b {
            grid-column: span 5;
            background: var(--orange);
        }

        .tile-b::after {
            display: none;
        }

        .tile-b h3,
        .tile-b p {
            color: #fff;
        }

        .tile-b .arr {
            background: #fff;
            color: var(--orange);
        }

        .tile-b .big-ico {
            position: absolute;
            right: -20px;
            top: -20px;
            font-size: 220px;
            color: rgba(255, 255, 255, .12);
            z-index: -1;
        }

        .tile-b .perks {
            list-style: none;
            padding: 0;
            margin: 0 0 22px;
        }

        .tile-b .perks li {
            display: flex;
            gap: 10px;
            align-items: center;
            padding: 6px 0;
            font-weight: 500;
        }

        .tile-c {
            grid-column: span 12;
            min-height: 340px;
        }

        @media (max-width: 991px) {

            .tile-a,
            .tile-b,
            .tile-c {
                grid-column: span 12;
                min-height: 340px;
            }

            .tile {
                padding: 26px;
            }
        }

        /* Why Terra */
        .why {
            background: var(--paper);
        }

        .why-img {
            border-radius: var(--radius-lg);
            width: 100%;
            height: 100%;
            min-height: 420px;
            object-fit: cover;
        }

        .why-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin: 30px 0;
        }

        .why-item {
            background: #fff;
            border-radius: var(--radius-md);
            padding: 20px;
        }

        .why-item i {
            font-size: 22px;
            color: var(--orange);
        }

        .why-item h5 {
            font-size: 17px;
            margin: 12px 0 6px;
        }

        .why-item p {
            margin: 0;
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        @media (max-width: 575px) {
            .why-list {
                grid-template-columns: 1fr;
            }
        }

        /* Numbers */
        .numbers {
            background: var(--navy);
            color: #fff;
            padding: 64px 0;
        }

        .number h3 {
            color: #fff;
            font-size: clamp(38px, 5vw, 56px);
            font-weight: 800;
            margin-bottom: 4px;
        }

        .number h3 small {
            color: #F59A62;
            font-size: .6em;
        }

        .number p {
            margin: 0;
            color: rgba(255, 255, 255, .7);
            font-size: 15px;
        }

        /* Journey (real sequence) */
        .journey {
            position: relative;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-top: 56px;
        }

        .journey::before {
            content: "";
            position: absolute;
            left: 6%;
            right: 6%;
            top: 29px;
            height: 2px;
            background: repeating-linear-gradient(90deg, var(--line) 0 8px, transparent 8px 16px);
        }

        .step {
            position: relative;
        }

        .step-dot {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid var(--orange);
            color: var(--orange);
            display: grid;
            place-items: center;
            font-weight: 800;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 20px;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        .step:first-child .step-dot {
            background: var(--orange);
            color: #fff;
        }

        .step h5 {
            font-size: 20px;
        }

        .step p {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.65;
            margin: 0;
            max-width: 250px;
        }

        @media (max-width: 991px) {
            .journey {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .journey::before {
                left: 28px;
                right: auto;
                top: 0;
                bottom: 0;
                width: 2px;
                height: auto;
                background: repeating-linear-gradient(180deg, var(--line) 0 8px, transparent 8px 16px);
            }

            .step {
                padding-left: 80px;
            }

            .step-dot {
                position: absolute;
                left: 0;
                top: 0;
                margin: 0;
            }
        }

        /* FAQ */
        .faq .accordion-item {
            border: 0;
            border-bottom: 1px solid var(--line);
            background: transparent;
        }

        .faq .accordion-button {
            background: transparent;
            box-shadow: none;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 700;
            font-size: 19px;
            color: var(--navy);
            padding: 22px 0;
        }

        .faq .accordion-button:not(.collapsed) {
            color: var(--orange);
            background: transparent;
        }

        .faq .accordion-body {
            padding: 0 0 22px;
            color: var(--muted);
            line-height: 1.7;
        }

        /* CTA */
        .cta {
            background: var(--navy-deep);
            border-radius: var(--radius-lg);
            padding: 64px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .cta h2 {
            color: #fff;
            font-size: clamp(30px, 4vw, 44px);
            margin-bottom: 14px;
        }

        .cta p {
            color: rgba(255, 255, 255, .78);
            font-size: 17px;
            line-height: 1.7;
            margin: 0;
            max-width: 520px;
        }

        .cta .col-lg-5 {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 767px) {
            .cta {
                padding: 36px 26px;
            }
        }

        /* Footer */
        footer {
            background: #0B1235;
            color: #fff;
            padding: 72px 0 24px;
            margin-top: 96px;
        }

        footer h5 {
            color: #fff;
            font-size: 16px;
            margin-bottom: 18px;
        }

        footer p,
        footer a {
            color: #B9C0D6;
            font-size: 15px;
            line-height: 2;
        }

        footer a:hover {
            color: #fff;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .social {
            display: flex;
            gap: 10px;
            margin-top: 18px;
        }

        .social a {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .2);
            display: grid;
            place-items: center;
            transition: .2s;
        }

        .social a:hover {
            background: var(--orange);
            border-color: var(--orange);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, .1);
            margin-top: 48px;
            padding-top: 22px;
        }

        /* Floating WhatsApp */
        .wa-float {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 1040;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #25D366;
            color: #fff;
            padding: 14px 20px;
            border-radius: 999px;
            font-weight: 700;
            box-shadow: 0 12px 30px rgba(37, 211, 102, .4);
        }

        .wa-float:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .wa-float i {
            font-size: 22px;
        }

        @media (max-width: 575px) {
            .wa-float span {
                display: none;
            }

            .wa-float {
                padding: 16px;
            }
        }

        /* One orchestrated entrance, hero only */
        @media (prefers-reduced-motion: no-preference) {
            .hero .rise {
                opacity: 0;
                transform: translateY(22px);
                animation: rise .8s cubic-bezier(.2, .7, .2, 1) forwards;
            }

            .hero .rise:nth-child(2) {
                animation-delay: .1s;
            }

            .hero .rise:nth-child(3) {
                animation-delay: .2s;
            }

            .hero .rise:nth-child(4) {
                animation-delay: .3s;
            }

            .hero .rise:nth-child(5) {
                animation-delay: .4s;
            }

            .hero-visual {
                opacity: 0;
                animation: rise .9s .25s cubic-bezier(.2, .7, .2, 1) forwards;
            }

            @keyframes rise {
                to {
                    opacity: 1;
                    transform: none;
                }
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                transition-duration: .01ms !important;
            }
        }

        @media (max-width: 991px) {
            .hero {
                padding-top: 120px;
            }

            .hero-tag {
                left: 10px;
            }

            .section {
                padding: 72px 0;
            }
        }
    </style>
</head>

<body>

    @php
    /*
    | Terra service destinations
    | Set TERRA_RENTAL_URL in .env once the rental app has its public URL.
    */
    $rentalUrl = env('TERRA_RENTAL_URL', 'http://rent.terra.rw/');
    $brokerageUrl = '#'; // TODO: add brokerage URL
    $marketplaceUrl = '#'; // TODO: add marketplace URL
    $servicesUrl = url('/our-services');
    $aboutUrl = url('/about');
    $contactUrl = url('/our-services');
    $whatsappUrl = 'https://wa.me/250796511725';
    $email = 'terraltd.rd@gmail.com';
    @endphp

    <a href="#main" class="skip-link">Skip to content</a>

    <!-- NAVIGATION -->
    <nav class="navbar navbar-expand-lg site-nav" id="siteNav" aria-label="Main navigation">
        <div class="container">
            <a class="brand" href="{{ url('/') }}" aria-label="Terra home">
                <span class="brand-mark"><i class="bi bi-buildings"></i></span>
                TERRA<span class="dot">.</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#terraNavbar" aria-controls="terraNavbar"
                aria-expanded="false" aria-label="Toggle menu">
                <i class="bi bi-list fs-1"></i>
            </button>

            <div class="collapse navbar-collapse" id="terraNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="{{ $rentalUrl }}">Rental Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ $brokerageUrl }}">Brokerage</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ $marketplaceUrl }}">Marketplace</a></li>
                    <li class="nav-item"><a class="nav-link" href="#why-terra">Why Terra</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ $aboutUrl }}">About us</a></li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a href="{{ $marketplaceUrl }}" class="btn-terra">
                            Browse properties <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main id="main">

        <!-- HERO -->
        <section class="hero" id="home">
            <div class="container">
                <div class="row align-items-center g-5">

                    <div class="col-lg-7">
                        <div class="rise">
                            <h1>Buy, rent and manage property in Rwanda. All in one place.</h1>
                        </div>
                        <p class="hero-lead rise">
                            Terra connects property seekers, owners and trusted agents with the tools to search,
                            transact and manage, from Kigali to every district.
                        </p>
                        <div class="d-flex flex-wrap gap-3 rise">
                            <a href="{{ $marketplaceUrl }}" class="btn-terra">
                                Find a property <i class="bi bi-search"></i>
                            </a>
                            <a href="{{ $rentalUrl }}" class="btn-ghost">
                                Manage my rentals
                            </a>
                        </div>
                        <div class="hero-trust rise">
                            <span><i class="bi bi-patch-check-fill"></i>Verified listings</span>
                            <span><i class="bi bi-person-check-fill"></i>Verified agents</span>
                            <span><i class="bi bi-geo-alt-fill"></i>All 30 districts</span>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="hero-visual">
                            <div class="arch">
                                <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1000"
                                    alt="Modern residential property in Rwanda" width="1000" height="1150">
                            </div>
                            <div class="hero-tag">
                                <div class="ico"><i class="bi bi-house-heart"></i></div>
                                <div>
                                    <strong>More than listings</strong>
                                    <span>A full property ecosystem</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>

        <!-- SERVICES -->
        <section class="section" id="services">
            <div class="container">
                <div class="row align-items-end g-4 mb-5">
                    <div class="col-lg-7">
                        <h2 class="section-title">Three services. One account for your property life.</h2>
                    </div>
                    <div class="col-lg-5">
                        <p class="section-copy mb-0">
                            Whether you own, invest, buy, sell or rent, pick the service that fits and
                            switch between them anytime.
                        </p>
                    </div>
                </div>

                <div class="bento">

                    <a href="{{ $marketplaceUrl }}" class="tile tile-a">
                        <img class="bg" loading="lazy" src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1200"
                            alt="" width="1200" height="800">
                        <h3>Property Marketplace</h3>
                        <p>Search houses, apartments, land and architectural designs across Rwanda and contact sellers directly.</p>
                        <span class="tile-link">Browse the marketplace <span class="arr"><i class="bi bi-arrow-up-right"></i></span></span>
                    </a>

                    <a href="{{ $rentalUrl }}" class="tile tile-b">
                        <i class="bi bi-key big-ico" aria-hidden="true"></i>
                        <h3>Smart Rental Management</h3>
                        <ul class="perks">
                            <li><i class="bi bi-check-circle-fill"></i> Buildings, units and tenants</li>
                            <li><i class="bi bi-check-circle-fill"></i> Leases and rent collection</li>
                            <li><i class="bi bi-check-circle-fill"></i> Payments and maintenance</li>
                        </ul>
                        <span class="tile-link">Open rental management <span class="arr"><i class="bi bi-arrow-up-right"></i></span></span>
                    </a>

                    <a href="{{ $brokerageUrl }}" class="tile tile-c">
                        <img class="bg" loading="lazy" src="https://images.unsplash.com/photo-1560520653-9e0e4c89eb11?w=1600"
                            alt="" width="1600" height="700">
                        <h3>Terra Brokerage</h3>
                        <p>Work with experienced agents who guide you through buying, selling or renting, from first viewing to signed contract.</p>
                        <span class="tile-link">Meet our agents <span class="arr"><i class="bi bi-arrow-up-right"></i></span></span>
                    </a>

                </div>
            </div>
        </section>

        <!-- WHY TERRA -->
        <section class="section why" id="why-terra">
            <div class="container">
                <div class="row g-5 align-items-stretch">

                    <div class="col-lg-5">
                        <img class="why-img" loading="lazy"
                            src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=1100"
                            alt="Modern property architecture" width="1100" height="1300">
                    </div>

                    <div class="col-lg-7 d-flex flex-column justify-content-center">
                        <h2 class="section-title">Property decisions are easier when everything is connected.</h2>
                        <p class="section-copy">
                            Terra is more than a listing website. We bring discovery, professional advice and
                            day-to-day management into one place.
                        </p>

                        <div class="why-list">
                            <div class="why-item">
                                <i class="bi bi-patch-check"></i>
                                <h5>Verified by our team</h5>
                                <p>Listings and professional profiles are reviewed before they go live.</p>
                            </div>
                            <div class="why-item">
                                <i class="bi bi-geo-alt"></i>
                                <h5>Nationwide reach</h5>
                                <p>Opportunities across Rwanda's 30 districts.</p>
                            </div>
                            <div class="why-item">
                                <i class="bi bi-laptop"></i>
                                <h5>Digital tools</h5>
                                <p>Search, manage rentals and contact professionals from any device.</p>
                            </div>
                            <div class="why-item">
                                <i class="bi bi-people"></i>
                                <h5>Real people to help</h5>
                                <p>Agents and consultants ready to advise at every stage.</p>
                            </div>
                        </div>

                        <div><a href="{{ $aboutUrl }}" class="btn-terra">About Terra <i class="bi bi-arrow-right"></i></a></div>
                    </div>

                </div>
            </div>
        </section>

        <!-- NUMBERS -->
        <section class="numbers" aria-label="Terra in numbers">
            <div class="container">
                <div class="row g-4 text-center text-lg-start">
                    <div class="col-6 col-lg-3 number">
                        <h3>500<small>+</small></h3>
                        <p>Properties listed</p>
                    </div>
                    <div class="col-6 col-lg-3 number">
                        <h3>120<small>+</small></h3>
                        <p>Verified agents</p>
                    </div>
                    <div class="col-6 col-lg-3 number">
                        <h3>30</h3>
                        <p>Districts covered</p>
                    </div>
                    <div class="col-6 col-lg-3 number">
                        <h3>98<small>%</small></h3>
                        <p>Client satisfaction</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- JOURNEY -->
        <section class="section" id="journey">
            <div class="container">
                <div class="text-center mx-auto" style="max-width:640px">
                    <h2 class="section-title">From first search to managing your investment.</h2>
                    <p class="section-copy mx-auto">Four steps, and Terra supports you through each one.</p>
                </div>

                <div class="journey">
                    <div class="step">
                        <div class="step-dot">1</div>
                        <h5>Discover</h5>
                        <p>Explore properties, land, designs and investment opportunities.</p>
                    </div>
                    <div class="step">
                        <div class="step-dot">2</div>
                        <h5>Connect</h5>
                        <p>Talk to owners, verified agents and professional consultants.</p>
                    </div>
                    <div class="step">
                        <div class="step-dot">3</div>
                        <h5>Transact</h5>
                        <p>Get support while you buy, sell or rent.</p>
                    </div>
                    <div class="step">
                        <div class="step-dot">4</div>
                        <h5>Manage</h5>
                        <p>Run your rentals and keep track of your property investments.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="section pt-0 faq" id="faq">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-4">
                        <h2 class="section-title">Questions we hear often</h2>
                        <p class="section-copy">Can't find your answer? Our team replies on WhatsApp during working hours.</p>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn-terra mt-2">
                            <i class="bi bi-whatsapp"></i> Ask on WhatsApp
                        </a>
                    </div>
                    <div class="col-lg-8">
                        <div class="accordion" id="faqList">

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#f1" aria-expanded="true" aria-controls="f1">
                                        How do I list my property on Terra?
                                    </button>
                                </h3>
                                <div id="f1" class="accordion-collapse collapse show" data-bs-parent="#faqList">
                                    <div class="accordion-body">Create an account, add your property details and photos, and our team reviews the listing before it appears on the marketplace.</div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f2" aria-expanded="false" aria-controls="f2">
                                        Can I manage several buildings and tenants?
                                    </button>
                                </h3>
                                <div id="f2" class="accordion-collapse collapse" data-bs-parent="#faqList">
                                    <div class="accordion-body">Yes. Terra Smart Rental Management handles buildings, units, tenants, leases, rent collection, payments and maintenance in one dashboard.</div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f3" aria-expanded="false" aria-controls="f3">
                                        Do I need an agent to buy or rent?
                                    </button>
                                </h3>
                                <div id="f3" class="accordion-collapse collapse" data-bs-parent="#faqList">
                                    <div class="accordion-body">No, you can contact sellers directly from the marketplace. If you want guidance, Terra Brokerage connects you with an experienced agent.</div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#f4" aria-expanded="false" aria-controls="f4">
                                        Which areas does Terra cover?
                                    </button>
                                </h3>
                                <div id="f4" class="accordion-collapse collapse" data-bs-parent="#faqList">
                                    <div class="accordion-body">All 30 districts of Rwanda, with the widest selection in Kigali.</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section aria-label="Get started">
            <div class="container">
                <div class="cta">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7" style="position:relative;z-index:1">
                            <h2>Whatever your property needs, start with Terra.</h2>
                            <p>Discover opportunities, make informed decisions and manage your investments with confidence.</p>
                        </div>
                        <div class="col-lg-5 d-flex flex-wrap gap-3 justify-lg-end">
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="btn-terra">
                                <i class="bi bi-whatsapp"></i> Contact our team
                            </a>
                            <a href="{{ $marketplaceUrl }}" class="btn-light-terra">Browse properties</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-4">
                    <a class="brand" href="{{ url('/') }}">
                        <span class="brand-mark"><i class="bi bi-buildings"></i></span>
                        TERRA<span class="dot">.</span>
                    </a>
                    <p class="mt-3">
                        Rwanda's real estate ecosystem connecting owners, buyers, sellers, tenants,
                        investors and professionals through trusted services and technology.
                    </p>
                    <div class="social">
                        <a href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h5>Services</h5>
                    <ul class="footer-links">
                        <li><a href="{{ $rentalUrl }}">Rental management</a></li>
                        <li><a href="{{ $brokerageUrl }}">Brokerage</a></li>
                        <li><a href="{{ $marketplaceUrl }}">Marketplace</a></li>
                        <li><a href="{{ $servicesUrl }}">Other services</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h5>Explore</h5>
                    <ul class="footer-links">
                        <li><a href="{{ $marketplaceUrl }}">Buy property</a></li>
                        <li><a href="{{ $marketplaceUrl }}">Rent property</a></li>
                        <li><a href="{{ $brokerageUrl }}">Find agents</a></li>
                        <li><a href="{{ $servicesUrl }}">Consultancy</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h5>Get in touch</h5>
                    <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>Kigali, Rwanda</p>
                    <p class="mb-1"><i class="bi bi-telephone me-2"></i><a href="tel:+250796511725">+250 796 511 725</a></p>
                    <p class="mb-1"><i class="bi bi-envelope me-2"></i><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    <p class="mb-0"><i class="bi bi-clock me-2"></i>Mon – Fri: 9:00 AM – 6:00 PM</p>
                </div>

            </div>

            <div class="footer-bottom">
                <div class="row align-items-center g-2">
                    <div class="col-md-6">
                        <p class="mb-0">© {{ date('Y') }} Terra Real Estate. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ url('/legal/privacy-policy') }}">Privacy Policy</a>
                        <span class="mx-2">|</span>
                        <a href="{{ url('/legal/terms-of-service') }}">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="wa-float" aria-label="Chat with Terra on WhatsApp">
        <i class="bi bi-whatsapp"></i><span>Chat with us</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar turns solid after scrolling
        (function() {
            var nav = document.getElementById('siteNav');

            function onScroll() {
                nav.classList.toggle('scrolled', window.scrollY > 40);
            }
            onScroll();
            window.addEventListener('scroll', onScroll, {
                passive: true
            });
        })();
    </script>

</body>

</html>