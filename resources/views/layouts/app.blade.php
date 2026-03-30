<!DOCTYPE html>
<html lang="en" class="scroll-smooth group" data-layout="modern" data-content-width="fluid" data-bs-theme="light"
    data-sidebar-colors="dark" data-sidebar="large" data-nav-type="default" dir="ltr" data-colors="default"
    data-profile-sidebar>


<head>

    <!-- Basic Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name') }} - Dashboard</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="@yield('title') | {{ config('app.name') }} - Dashboard">
    <meta name="description"
        content="Terra Real Estate is Rwanda's premier one-stop property platform — connecting buyers, sellers, agents, consultants, and investors across every district. We believe great real estate isn't just about property; it's about people, communities, and futures.">
    <meta name="keywords"
        content="Terra Real Estate is Rwanda's premier one-stop property platform — connecting buyers, sellers, agents, consultants, and investors across every district. We believe great real estate isn't just about property; it's about people, communities, and futures.">
    <meta name="author" content="SRBThemes">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="#!">
    <meta property="og:title" content="@yield('title') | {{ config('app.name') }} - Dashboard">
    <meta property="og:description"
        content="Terra Real Estate is Rwanda's premier one-stop property platform — connecting buyers, sellers, agents, consultants, and investors across every district. We believe great real estate isn't just about property; it's about people, communities, and futures.">
    <meta property="og:image" content="#!">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="#!">
    <meta property="twitter:title" content="@yield('title') | {{ config('app.name') }} - Dashboard">
    <meta property="twitter:description"
        content="Terra Real Estate is Rwanda's premier one-stop property platform — connecting buyers, sellers, agents, consultants, and investors across every district. We believe great real estate isn't just about property; it's about people, communities, and futures.">
    <meta property="twitter:image" content="#!">

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('dashboard/assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- Layout JS -->

    <!-- Bootstrap CSS -->

    <link href="{{ asset('dashboard/assets/css/bootstrap.rtl.css') }}" rel="stylesheet" type="text/css" disabled>
    <!-- Icons CSS -->

    <!-- App CSS -->

    <link href="{{ asset('dashboard/assets/css/app.rtl.css') }}" rel="stylesheet" type="text/css" disabled>
    <!-- Admin Bundle JS -->

    <script type="module" crossorigin src="{{ asset('dashboard/assets/js/src/index.js') }}"></script>
    <link rel="modulepreload" crossorigin href="{{ asset('dashboard/assets/admin.bundle-CEbNEZ37.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('dashboard/assets/swiper-bundle-EE6_k-Kw.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('dashboard/assets/apexcharts.esm-B_m6KPN7.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('dashboard/assets/main-O_SKZbQk.js') }}">

    <script type="module" crossorigin src="{{ asset('dashboard/assets/js/src/apps-agents-profile.js') }}"></script>
    <link rel="modulepreload" crossorigin href="{{ asset('dashboard/assets/progress-circle.init-BSjgPg28.js') }}">

    <link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/css/swiper-bundle.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/css/admin.css') }}">

    <script type="module" crossorigin src="{{ asset('dashboard/assets/table-datatables-basic.init.js') }}"></script>
    <script type="module" crossorigin src="{{ asset('dashboard/assets/main.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/dataTables.bootstrap5.css') }}">
</head>

<body class="sidebar-hidden ">

    @include('includes.admin.header')

    @include('includes.admin.sidebar')

    <div class="min-vh-100 position-relative">
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('content')

                @include('includes.admin.footer')
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    @if(session('permission_denied'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: '{{ session('
                permission_denied ') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#e3342f',
            });
        });
    </script>
    @endif
</body>

</html>