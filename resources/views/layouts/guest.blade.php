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
    

    <!--===== PROGRESS STARTS=======-->
    <div class="paginacontainer">
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
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