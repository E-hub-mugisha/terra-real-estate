<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title') - {{ config('app.name', 'Terra Real Estate') }}</title>
    <meta name="AdsBot-Google" content="noindex follow" />
    <meta name="description" content="Terra Real Estate is Rwanda's premier one-stop property platform — connecting buyers, sellers, agents, consultants, and investors across every district. We believe great real estate isn't just about property; it's about people, communities, and futures.">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('front/assets/images/favicon.png') }}" />

    <!-- CSS (Font, Vendor, Icon, Plugins & Style CSS files) -->

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&amp;family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">

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
</head>


<body class="homepage1-body">
    

    @yield('content')

    <!--===== JS SCRIPT LINK =======-->
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