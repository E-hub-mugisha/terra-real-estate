<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title') - {{ config('app.name', 'Terra Real Estate') }}</title>
    <meta name="AdsBot-Google" content="noindex follow" />
    <meta name="description" content="Bery-Real Estate Listing Template">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/assets/images/favicon.png') }}" />

    <!-- CSS (Font, Vendor, Icon, Plugins & Style CSS files) -->

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!--=====FAB ICON=======-->
    <link rel="shortcut icon" href="{{ asset('front/assets/img/logo/fav-logo1.png') }}" type="image/x-icon">

    <!--===== CSS LINK =======-->
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/mobile.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/owlcarousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/slick-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/swiper-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/main.css') }}">

    <!--=====  JS SCRIPT LINK =======-->
    <script src="{{ asset('front/assets/js/plugins/jquery-3-7-1.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* ── Floating FAB ── */
        .fab-consult {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1050;
            display: flex;
            align-items: center;
            gap: 0;
            overflow: hidden;
            max-width: 56px;
            height: 56px;
            border-radius: 28px;
            border: 1px solid #19265d;
            padding: 0 1rem;
            background: #D05208;
            box-shadow: 0 6px 28px rgba(201, 168, 76, .45), 0 2px 8px rgba(0, 0, 0, .4);
            cursor: pointer;
            transition: max-width .4s cubic-bezier(.4, 0, .2, 1),
                border-radius .3s ease,
                box-shadow .3s ease;
            white-space: nowrap;
        }

        .fab-consult:hover {
            max-width: 260px;
            border-radius: 28px;
            box-shadow: 0 8px 36px rgba(201, 168, 76, .65), 0 4px 12px rgba(0, 0, 0, .5);
        }

        .fab-consult .fab-icon {
            font-size: 1.25rem;
            color: var(--dark);
            flex-shrink: 0;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 26px;
        }

        .fab-consult .fab-label {
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: .82rem;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--dark);
            opacity: 0;
            max-width: 0;
            overflow: hidden;
            transition: opacity .25s ease .1s, max-width .4s cubic-bezier(.4, 0, .2, 1);
            pointer-events: none;
        }

        .fab-consult:hover .fab-label {
            opacity: 1;
            max-width: 200px;
            margin-left: .6rem;
        }

        /* pulse ring */
        .fab-wrapper {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1049;
        }

        .fab-pulse {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(201, 168, 76, .35);
            animation: pulse 2.2s ease-out infinite;
            pointer-events: none;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: .7;
            }

            70% {
                transform: scale(1.7);
                opacity: 0;
            }

            100% {
                transform: scale(1.7);
                opacity: 0;
            }
        }

        /* ── Modal shell ── */
        .modal-content {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
        }

        /* ── Modal header ── */
        .modal-header {
            background: #ffffff;
            padding: 1.6rem 1.75rem 1.4rem;
        }

        .modal-header .modal-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #19265d;
            border: 1px solid #D05208;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .85rem;
        }

        .modal-header .modal-icon i {
            font-size: 1.1rem;
            color: #D05208;
        }

        .modal-title {
            font-family: 'Playfair Display', serif;
            color: #19265d;
            font-size: 1.35rem;
            margin-bottom: .25rem;
        }

        .modal-subtitle {
            color: #D05208;
            font-size: .82rem;
            letter-spacing: .02em;
        }

        .btn-close {
            filter: invert(1) sepia(1) saturate(2) hue-rotate(10deg) brightness(.8);
            opacity: .6;
        }

        /* ── Modal body ── */
        .modal-body {
            padding: 1.5rem 1.75rem;
        }

        .divider-label {
            display: flex;
            align-items: center;
            gap: .75rem;
            color: #19265d;
            font-size: .72rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-bottom: 1.1rem;
        }

        .divider-label::before,
        .divider-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Contact Cards ── */
        .contact-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.2rem;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, .06);
            background: rgba(255, 255, 255, .03);
            cursor: pointer;
            transition: background .2s, border-color .2s, transform .15s;
            text-decoration: none;
            margin-bottom: .75rem;
        }

        .contact-card:last-child {
            margin-bottom: 0;
        }

        .contact-card:hover {
            background: rgba(255, 255, 255, .06);
            transform: translateX(4px);
        }

        .contact-card.email:hover {
            border-color: rgba(66, 133, 244, .5);
        }

        .contact-card.whatsapp:hover {
            border-color: rgba(37, 211, 102, .5);
        }

        .contact-card.call:hover {
            border-color: rgba(201, 168, 76, .5);
        }

        .contact-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .icon-email {
            background: rgba(66, 133, 244, .15);
            color: #6ea8fe;
        }

        .icon-whatsapp {
            background: rgba(37, 211, 102, .15);
            color: #25d366;
        }

        .icon-call {
            background: rgba(201, 168, 76, .15);
            color: var(--gold);
        }

        .contact-info .label {
            font-size: .72rem;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #19265d;
            margin-bottom: .1rem;
        }

        .contact-info .value {
            font-size: .93rem;
            font-weight: 500;
            color: #D05208;
        }

        .contact-arrow {
            margin-left: auto;
            color: #D05208;
            font-size: .85rem;
            transition: color .2s, transform .2s;
        }

        .contact-card:hover .contact-arrow {
            color: #D05208;
            transform: translateX(3px);
        }

        /* ── Footer ── */
        .modal-footer {
            border-top: 1px solid #D05208;
            padding: .9rem 1.75rem;
            background: #19265d;
        }

        .modal-footer small {
            color: #ffffff;
            font-size: .75rem;
        }

        .modal-footer small i {
            color: #D05208;
            margin-right: .3rem;
        }
    </style>
</head>


<body class="homepage1-body">


    <!-- ── Floating Action Button ── -->
    <div class="fab-wrapper">
        <div class="fab-pulse"></div>
        <button class="fab-consult" data-bs-toggle="modal" data-bs-target="#consultModal" aria-label="Request a Consultation">
            <span class="fab-icon"><i class="bi bi-calendar2-check"></i></span>
            <span class="fab-label">Request a Consultation</span>
        </button>
    </div>
    <!--===== PROGRESS ENDS=======-->

    <!--===== SEARCHBAR STARTS=======-->
    <div class="header-search-form-wrapper">
        <div class="tx-search-close tx-close"><i class="fa-solid fa-xmark"></i></div>
        <div class="header-search-container">
            <form role="search" class="search-form">
                <input type="search" class="search-field" placeholder="Search …" value="" name="s">
                <button type="submit" class="search-submit"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M13.7955 13.8111L19 19M16 8.5C16 12.6421 12.6421 16 8.5 16C4.35786 16 1 12.6421 1 8.5C1 4.35786 4.35786 1 8.5 1C12.6421 1 16 4.35786 16 8.5Z" stroke="#030E0F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg></button>
            </form>
        </div>
    </div>
    <div class="body-overlay"></div>
    <!--===== SEARCHBAR STARTS=======-->

    @include('includes.front.header')

    @yield('content')

    @include('includes.front.footer')


    <!-- ── Modal ── -->
    <div class="modal fade" id="consultModal" tabindex="-1" aria-labelledby="consultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:450px">
            <div class="modal-content">

                <div class="modal-header">
                    <div>
                        <div class="modal-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h5 class="modal-title" id="consultModalLabel">Get in Touch with Terra</h5>
                        <p class="modal-subtitle mb-0">Choose your preferred way to reach us</p>
                    </div>
                    <button type="button" class="btn-close ms-auto mt-1" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="divider-label">Contact options</div>

                    <!-- Email -->
                    <a href="/cdn-cgi/l/email-protection#5139343d3d3e11283e2423353e3c30383f7f323e3c6e2224333b3432256c123e3f22243d253025383e3f74636103342024342225" class="contact-card email">
                        <div class="contact-icon icon-email">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div class="contact-info">
                            <div class="label">Send Email</div>
                            <div class="value"><span class="__cf_email__" data-cfemail="4129242d2d2e01382e3433252e2c20282f6f222e2c">[email&#160;protected]</span></div>
                        </div>
                        <i class="bi bi-chevron-right contact-arrow"></i>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/1234567890?text=Hello%2C%20I%27d%20like%20to%20request%20a%20consultation."
                        target="_blank" rel="noopener noreferrer"
                        class="contact-card whatsapp">
                        <div class="contact-icon icon-whatsapp">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div class="contact-info">
                            <div class="label">WhatsApp Chat</div>
                            <div class="value">+1 (234) 567-890</div>
                        </div>
                        <i class="bi bi-chevron-right contact-arrow"></i>
                    </a>

                    <!-- Call -->
                    <a href="tel:+11234567890" class="contact-card call">
                        <div class="contact-icon icon-call">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div class="contact-info">
                            <div class="label">Call Us</div>
                            <div class="value">+1 (234) 567-890</div>
                        </div>
                        <i class="bi bi-chevron-right contact-arrow"></i>
                    </a>
                </div>

                <div class="modal-footer">
                    <small><i class="bi bi-clock"></i>Available Mon–Fri, 9 AM – 6 PM</small>
                </div>
            </div>
        </div>
    </div>
    <!--===== JS SCRIPT LINK =======-->
    <!-- 1. Alpine FIRST (with defer) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('front/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/fontawesome.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/aos.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/counter.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/gsap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/Splitetext.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/sidebar.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/swiper-slider.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/mobilemenu.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/owlcarousel.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/nice-select.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/slick-slider.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/circle-progress.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('
            success ') }}',
            confirmButtonColor: '#3085d6'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('
            error ') }}',
            confirmButtonColor: '#d33'
        });
    </script>
    @endif
</body>

</html>