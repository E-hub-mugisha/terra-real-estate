<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Terra Property Management | Kigali, Rwanda')
    </title>

    <meta name="description"
          content="@yield(
              'meta_description',
              'Terra Property Management provides professionally managed rental properties and property management services across Kigali, Rwanda.'
          )">

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">


    <style>

        :root {

            --terra-orange: #D05208;
            --terra-orange-dark: #ad4205;

            --terra-navy: #19265d;
            --terra-dark: #111936;

            --terra-text: #303643;
            --terra-muted: #737b8c;

            --terra-border: #e7e9ee;
            --terra-light: #f7f8fa;

        }


        * {
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {

            margin: 0;

            font-family: 'DM Sans', sans-serif;

            background: #ffffff;

            color: var(--terra-text);

            -webkit-font-smoothing: antialiased;

        }


        a {

            transition:
                color .2s ease,
                background-color .2s ease,
                border-color .2s ease,
                transform .2s ease;

        }


        /* ============================================================
           HEADER
        ============================================================ */

        .terra-header {

            position: relative;

            z-index: 1030;

            background: #ffffff;

            border-bottom: 1px solid #e9ebef;

        }


        .terra-navbar {

            min-height: 88px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 30px;

        }


        /* ============================================================
           BRAND
        ============================================================ */

        .terra-brand {

            display: inline-flex;

            align-items: center;

            gap: 13px;

            color: var(--terra-navy);

            text-decoration: none;

            flex-shrink: 0;

        }


        .terra-logo-mark {

            width: 48px;

            height: 48px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: var(--terra-navy);

            color: #ffffff;

            font-size: 1.25rem;

            font-weight: 800;

            letter-spacing: -.04em;

        }


        .terra-brand-text {

            display: flex;

            flex-direction: column;

            line-height: 1.15;

        }


        .terra-brand-text strong {

            color: var(--terra-navy);

            font-size: .98rem;

            font-weight: 800;

            letter-spacing: -.025em;

        }


        .terra-brand-text span {

            color: #7b8190;

            font-size: .67rem;

            margin-top: 5px;

            letter-spacing: .05em;

        }


        /* ============================================================
           DESKTOP NAVIGATION
        ============================================================ */

        .terra-nav-links {

            display: flex;

            align-items: center;

            gap: 36px;

        }


        .terra-nav-link {

            position: relative;

            color: #303643;

            text-decoration: none;

            font-size: .82rem;

            font-weight: 600;

            white-space: nowrap;

        }


        .terra-nav-link:hover {

            color: var(--terra-orange);

        }


        .terra-nav-link.active {

            color: var(--terra-orange);

        }


        .terra-nav-link.active::after {

            content: "";

            position: absolute;

            left: 0;

            right: 0;

            bottom: -11px;

            height: 2px;

            background: var(--terra-orange);

        }


        /* ============================================================
           INQUIRE BUTTON
        ============================================================ */

        .terra-inquire-btn {

            min-height: 46px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding: 0 23px;

            background: var(--terra-orange);

            border: 1px solid var(--terra-orange);

            color: #ffffff;

            text-decoration: none;

            font-size: .73rem;

            font-weight: 800;

            letter-spacing: .09em;

        }


        .terra-inquire-btn:hover {

            background: var(--terra-orange-dark);

            border-color: var(--terra-orange-dark);

            color: #ffffff;

            transform: translateY(-1px);

        }


        /* ============================================================
           MOBILE BUTTON
        ============================================================ */

        .terra-mobile-toggle {

            display: none;

            width: 44px;

            height: 44px;

            align-items: center;

            justify-content: center;

            border: 1px solid #e0e3e8;

            background: #ffffff;

            color: var(--terra-navy);

            font-size: 1.35rem;

        }


        .terra-mobile-toggle:hover {

            background: var(--terra-light);

        }


        /* ============================================================
           MOBILE MENU
        ============================================================ */

        .terra-mobile-menu {

            width: min(390px, 92vw);

            border-left: 1px solid var(--terra-border);

        }


        .terra-mobile-menu .offcanvas-header {

            padding: 22px;

            border-bottom: 1px solid var(--terra-border);

        }


        .terra-mobile-menu .offcanvas-body {

            padding: 10px 22px 30px;

        }


        .terra-mobile-links {

            display: flex;

            flex-direction: column;

        }


        .terra-mobile-link {

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding: 21px 0;

            border-bottom: 1px solid var(--terra-border);

            color: var(--terra-navy);

            font-size: .9rem;

            font-weight: 600;

            text-decoration: none;

        }


        .terra-mobile-link:hover {

            color: var(--terra-orange);

        }


        .terra-mobile-link span {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        .terra-mobile-link span i {

            color: var(--terra-orange);

        }


        .terra-mobile-link > i {

            color: var(--terra-orange);

        }


        .terra-mobile-inquire {

            min-height: 52px;

            margin-top: 26px;

            padding: 0 18px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            background: var(--terra-orange);

            color: #ffffff;

            text-decoration: none;

            font-size: .75rem;

            font-weight: 800;

            letter-spacing: .09em;

        }


        .terra-mobile-inquire:hover {

            background: var(--terra-orange-dark);

            color: #ffffff;

        }


        /* ============================================================
           MAIN
        ============================================================ */

        main {

            min-height: 400px;

        }


        /* ============================================================
           FOOTER
        ============================================================ */

        .terra-footer {

            background: var(--terra-dark);

            color: rgba(255,255,255,.68);

        }


        .terra-footer-main {

            padding: 72px 0 58px;

        }


        /* ------------------------------------------------------------
           FOOTER BRAND
        ------------------------------------------------------------ */

        .terra-footer-brand {

            display: inline-flex;

            align-items: center;

            gap: 12px;

            color: #ffffff;

            text-decoration: none;

        }


        .terra-footer-logo {

            width: 46px;

            height: 46px;

            display: flex;

            align-items: center;

            justify-content: center;

            background: var(--terra-orange);

            color: #ffffff;

            font-size: 1.15rem;

            font-weight: 800;

        }


        .terra-footer-brand-text {

            display: flex;

            flex-direction: column;

            line-height: 1.15;

        }


        .terra-footer-brand-text strong {

            color: #ffffff;

            font-size: .98rem;

            font-weight: 800;

        }


        .terra-footer-brand-text span {

            color: rgba(255,255,255,.42);

            font-size: .65rem;

            margin-top: 5px;

            letter-spacing: .05em;

        }


        .terra-footer-description {

            max-width: 440px;

            margin: 21px 0 0;

            color: rgba(255,255,255,.56);

            font-size: .8rem;

            line-height: 1.85;

        }


        /* ------------------------------------------------------------
           FOOTER TITLE
        ------------------------------------------------------------ */

        .terra-footer-title {

            color: #ffffff;

            font-size: .72rem;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .12em;

            margin-bottom: 21px;

        }


        /* ------------------------------------------------------------
           FOOTER LINKS
        ------------------------------------------------------------ */

        .terra-footer-link {

            display: block;

            width: fit-content;

            margin-bottom: 12px;

            color: rgba(255,255,255,.55);

            font-size: .78rem;

            text-decoration: none;

        }


        .terra-footer-link:hover {

            color: #ffffff;

            transform: translateX(2px);

        }


        /* ------------------------------------------------------------
           FOOTER CONTACT
        ------------------------------------------------------------ */

        .terra-footer-contact {

            display: flex;

            align-items: flex-start;

            gap: 11px;

            margin-bottom: 13px;

            color: rgba(255,255,255,.57);

            font-size: .78rem;

            line-height: 1.6;

        }


        .terra-footer-contact i {

            color: var(--terra-orange);

            font-size: .9rem;

            margin-top: 2px;

        }


        .terra-footer-contact a {

            color: rgba(255,255,255,.57);

            text-decoration: none;

        }


        .terra-footer-contact a:hover {

            color: #ffffff;

        }


        /* ------------------------------------------------------------
           OWNER CTA IN FOOTER
        ------------------------------------------------------------ */

        .terra-footer-owner {

            margin-top: 24px;

            padding-top: 24px;

            border-top: 1px solid rgba(255,255,255,.08);

        }


        .terra-footer-owner-title {

            color: #ffffff;

            font-size: .84rem;

            font-weight: 700;

            margin-bottom: 7px;

        }


        .terra-footer-owner-text {

            color: rgba(255,255,255,.48);

            font-size: .74rem;

            line-height: 1.7;

            margin-bottom: 14px;

        }


        .terra-footer-owner-btn {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 10px 14px;

            border: 1px solid rgba(255,255,255,.15);

            color: rgba(255,255,255,.78);

            font-size: .7rem;

            font-weight: 700;

            text-decoration: none;

        }


        .terra-footer-owner-btn:hover {

            background: rgba(255,255,255,.05);

            border-color: rgba(255,255,255,.28);

            color: #ffffff;

        }


        .terra-footer-owner-btn i {

            color: var(--terra-orange);

        }


        /* ------------------------------------------------------------
           FOOTER BOTTOM
        ------------------------------------------------------------ */

        .terra-footer-bottom {

            border-top: 1px solid rgba(255,255,255,.08);

            padding: 21px 0;

        }


        .terra-footer-copyright {

            margin: 0;

            color: rgba(255,255,255,.4);

            font-size: .68rem;

        }


        .terra-footer-bottom-links {

            display: flex;

            justify-content: flex-end;

            align-items: center;

            gap: 21px;

        }


        .terra-footer-bottom-links a {

            color: rgba(255,255,255,.42);

            font-size: .68rem;

            text-decoration: none;

        }


        .terra-footer-bottom-links a:hover {

            color: #ffffff;

        }


        /* ============================================================
           RESPONSIVE
        ============================================================ */

        @media (max-width: 991.98px) {

            .terra-navbar {

                min-height: 76px;

            }


            .terra-nav-links {

                display: none;

            }


            .terra-mobile-toggle {

                display: inline-flex;

            }


            .terra-footer-bottom-links {

                justify-content: flex-start;

                margin-top: 10px;

            }

        }


        @media (max-width: 575.98px) {

            .terra-navbar {

                min-height: 70px;

            }


            .terra-logo-mark {

                width: 43px;

                height: 43px;

            }


            .terra-brand-text strong {

                font-size: .88rem;

            }


            .terra-brand-text span {

                font-size: .61rem;

            }


            .terra-footer-main {

                padding: 55px 0 40px;

            }


            .terra-footer-bottom {

                padding: 18px 0;

            }

        }

    </style>


    @stack('styles')

</head>


<body>


{{-- ================================================================
    HEADER
================================================================ --}}

<header class="terra-header">

    <div class="container">

        <nav class="terra-navbar">


            {{-- BRAND --}}

            <a href="{{ route('terra.home') }}"
               class="terra-brand">

                <div class="terra-logo-mark">
                    T
                </div>

                <div class="terra-brand-text">

                    <strong>
                        Terra Property Management
                    </strong>

                    <span>
                        Kigali, Rwanda
                    </span>

                </div>

            </a>


            {{-- DESKTOP NAVIGATION --}}

            <div class="terra-nav-links">


                <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}"
                   class="terra-nav-link
                   {{ request()->routeIs('terra.properties.index') && request('purpose') === 'rent' ? 'active' : '' }}">

                    Units for Rent

                </a>


                <a href="{{ route('terra.home') }}#property-management"
                   class="terra-nav-link">

                    For Owners & Developers

                </a>


                <a href="{{ route('terra.contact') }}"
                   class="terra-inquire-btn">

                    INQUIRE NOW

                </a>


            </div>


            {{-- MOBILE MENU BUTTON --}}

            <button type="button"
                    class="terra-mobile-toggle"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#terraMobileMenu"
                    aria-label="Open navigation">

                <i class="bi bi-list"></i>

            </button>


        </nav>

    </div>

</header>



{{-- ================================================================
    MOBILE OFFCANVAS
================================================================ --}}

<div class="offcanvas offcanvas-end terra-mobile-menu"
     tabindex="-1"
     id="terraMobileMenu"
     aria-labelledby="terraMobileMenuLabel">


    <div class="offcanvas-header">


        <div class="terra-brand">

            <div class="terra-logo-mark">
                T
            </div>

            <div class="terra-brand-text">

                <strong>
                    Terra Property Management
                </strong>

                <span>
                    Kigali, Rwanda
                </span>

            </div>

        </div>


        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"></button>


    </div>


    <div class="offcanvas-body">


        <div class="terra-mobile-links">


            <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}"
               class="terra-mobile-link">

                <span>

                    <i class="bi bi-buildings"></i>

                    Units for Rent

                </span>

                <i class="bi bi-arrow-right"></i>

            </a>


            <a href="{{ route('terra.home') }}#property-management"
               class="terra-mobile-link"
               data-bs-dismiss="offcanvas">

                <span>

                    <i class="bi bi-briefcase"></i>

                    For Owners & Developers

                </span>

                <i class="bi bi-arrow-right"></i>

            </a>


            <a href="{{ route('terra.contact') }}"
               class="terra-mobile-inquire">

                <span>
                    INQUIRE NOW
                </span>

                <i class="bi bi-arrow-right"></i>

            </a>


        </div>


    </div>

</div>



{{-- ================================================================
    MAIN CONTENT
================================================================ --}}

<main>

    @yield('content')

</main>



{{-- ================================================================
    FOOTER
================================================================ --}}

<footer class="terra-footer">


    <div class="terra-footer-main">

        <div class="container">

            <div class="row g-5">


                {{-- =================================================
                    BRAND / DESCRIPTION
                ================================================== --}}

                <div class="col-lg-5">


                    <a href="{{ route('terra.home') }}"
                       class="terra-footer-brand">


                        <div class="terra-footer-logo">
                            T
                        </div>


                        <div class="terra-footer-brand-text">

                            <strong>
                                Terra Property Management
                            </strong>

                            <span>
                                Kigali, Rwanda
                            </span>

                        </div>


                    </a>


                    <p class="terra-footer-description">

                        Terra Property Management provides professional
                        rental and property management services across Kigali.
                        We connect tenants with quality homes while helping
                        owners and developers manage their properties
                        professionally.

                    </p>


                    <div class="terra-footer-owner">


                        <div class="terra-footer-owner-title">

                            For Owners & Developers

                        </div>


                        <p class="terra-footer-owner-text">

                            Looking for a reliable partner to manage your
                            residential property or rental building?

                        </p>


                        <a href="{{ route('terra.contact') }}"
                           class="terra-footer-owner-btn">

                            Discuss Property Management

                            <i class="bi bi-arrow-right"></i>

                        </a>


                    </div>


                </div>



                {{-- =================================================
                    RENTALS
                ================================================== --}}

                <div class="col-6 col-md-3 col-lg-3">


                    <div class="terra-footer-title">

                        Rentals

                    </div>


                    <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}"
                       class="terra-footer-link">

                        Units for Rent

                    </a>


                    <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}"
                       class="terra-footer-link">

                        Apartments

                    </a>


                    <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}"
                       class="terra-footer-link">

                        Houses

                    </a>


                    <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}"
                       class="terra-footer-link">

                        Available Properties

                    </a>


                    <a href="{{ route('terra.contact') }}"
                       class="terra-footer-link">

                        Rental Inquiry

                    </a>


                </div>



                {{-- =================================================
                    CONTACT
                ================================================== --}}

                <div class="col-6 col-md-3 col-lg-4">


                    <div class="terra-footer-title">

                        Contact

                    </div>


                    <div class="terra-footer-contact">

                        <i class="bi bi-geo-alt"></i>

                        <span>
                            Kigali, Rwanda
                        </span>

                    </div>


                    <div class="terra-footer-contact">

                        <i class="bi bi-telephone"></i>

                        <span>

                            <a href="tel:+250788000000">
                                +250 788 000 000
                            </a>

                        </span>

                    </div>


                    <div class="terra-footer-contact">

                        <i class="bi bi-whatsapp"></i>

                        <span>

                            <a href="https://wa.me/250788000000"
                               target="_blank"
                               rel="noopener">

                                WhatsApp: +250 788 000 000

                            </a>

                        </span>

                    </div>


                    <div class="terra-footer-contact">

                        <i class="bi bi-envelope"></i>

                        <span>

                            <a href="mailto:info@terra.rw">

                                info@terra.rw

                            </a>

                        </span>

                    </div>


                    <div class="terra-footer-contact">

                        <i class="bi bi-clock"></i>

                        <span>

                            Monday – Friday<br>
                            8:00 AM – 5:00 PM

                        </span>

                    </div>


                </div>


            </div>

        </div>

    </div>



    {{-- ================================================================
        FOOTER BOTTOM
    ================================================================= --}}

    <div class="terra-footer-bottom">


        <div class="container">


            <div class="row align-items-center">


                <div class="col-md-7">


                    <p class="terra-footer-copyright">

                        © {{ date('Y') }}
                        Terra Property Management.
                        All rights reserved.

                    </p>


                </div>


                <div class="col-md-5">


                    <div class="terra-footer-bottom-links">


                        <a href="{{ route('terra.home') }}">

                            Home

                        </a>


                        <a href="{{ route('terra.properties.index', ['purpose' => 'rent']) }}">

                            Units for Rent

                        </a>


                        <a href="{{ route('terra.contact') }}">

                            Contact

                        </a>


                    </div>


                </div>


            </div>


        </div>

    </div>


</footer>



{{-- ================================================================
    BOOTSTRAP
================================================================ --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@stack('scripts')


</body>

</html>