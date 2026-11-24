    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') · {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('front/assets/img/logo/fav-logo1.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">

    {{-- Theme bundle (Bootstrap, icons, charts, DataTables) used by existing panel pages --}}
    <script type="module" crossorigin src="{{ asset('dashboard/assets/js/src/index.js') }}"></script>
    <link rel="modulepreload" crossorigin href="{{ asset('dashboard/assets/admin.bundle-CEbNEZ37.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('dashboard/assets/apexcharts.esm-B_m6KPN7.js') }}">
    <link rel="modulepreload" crossorigin href="{{ asset('dashboard/assets/main-O_SKZbQk.js') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/css/swiper-bundle.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/css/admin.css') }}">
    <script type="module" crossorigin src="{{ asset('dashboard/assets/table-datatables-basic.init.js') }}"></script>
    <script type="module" crossorigin src="{{ asset('dashboard/assets/main.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/dataTables.bootstrap5.css') }}">

    {{-- Terra design system (loaded last so it wins) --}}
    <link rel="stylesheet" href="{{ asset('css/terra-ui.css') }}?v={{ @filemtime(public_path('css/terra-ui.css')) }}">
