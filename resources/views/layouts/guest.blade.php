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
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&amp;family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">

    <!-- Vendor CSS (Bootstrap & Icon Font) -->

    <!-- Plugins CSS (All Plugins Files) -->

    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/swiper-bundle.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/magnific-popup.css') }}" />

    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/nice-select.css') }}" />


    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}" />

</head>


<body class="font-karla text-body text-tiny">
    <div class="overflow-hidden">

        @include('includes.front.header')

        @yield('content')

        @include('includes.front.footer')
        <a id="scrollUp" class="w-12 h-12 rounded-full bg-primary text-white fixed right-5 bottom-16 flex flex-wrap items-center justify-center transition-all duration-300 z-10" href="#" aria-label="scroll up">
            <svg width="25" height="25" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path d="M6.101 261.899L25.9 281.698c4.686 4.686 12.284 4.686 16.971 0L198 126.568V468c0 6.627 5.373 12 12 12h28c6.627 0 12-5.373 12-12V126.568l155.13 155.13c4.686 4.686 12.284 4.686 16.971 0l19.799-19.799c4.686-4.686 4.686-12.284 0-16.971L232.485 35.515c-4.686-4.686-12.284-4.686-16.971 0L6.101 244.929c-4.687 4.686-4.687 12.284 0 16.97z" />
            </svg>
        </a>

    </div>

    <!-- JS Vendor, Plugins & Activation Script Files -->

    <!-- Vendors JS -->
    <script src="{{ asset('front/assets/js/vendor/modernizr-3.11.7.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/vendor/jquery-migrate-3.3.2.min.js') }}"></script>
    <!-- Plugins JS -->
    <script src="{{ asset('front/assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/parallax.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.nice-select.min.js') }}"></script>

    <!-- Activation JS -->
    <script src="{{ asset('front/assets/js/main.js') }}"></script>

</body>

</html>