<!DOCTYPE html>
<html lang="en" class="scroll-smooth group" data-layout="modern" data-content-width="fluid" data-bs-theme="light" data-sidebar-colors="dark" data-sidebar="large" data-nav-type="default" dir="ltr" data-colors="default" data-profile-sidebar>

<head>

    <!-- Basic Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name') }} - Dashboard</title>
    
    <!-- Primary Meta Tags -->
    <meta name="title" content="Evohus | Admin Dashboard Template">
    <meta name="description" content="Get the best admin dashboard template with Bootstrap 5.3.8, multiple layouts, RTL/LTR support, dark/light mode, responsive design, and Sass support. Lightweight, easy to customize, and perfect for your next project.">
    <meta name="keywords" content="bootstrap dashboard, admin template, responsive dashboard, analytics dashboard, e-commerce dashboard, admin dashboard template, bootstrap 5.3.8, responsive design, RTL LTR support, dark light mode, sass supported, lightweight, easy to customize, bootstrap">
    <meta name="author" content="SRBThemes">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="#!">
    <meta property="og:title" content="Evohus| Admin Dashboard Template">
    <meta property="og:description" content="Get the best admin dashboard template with Bootstrap 5.3.8, multiple layouts, RTL/LTR support, dark/light mode, responsive design, and Sass support. Lightweight, easy to customize, and perfect for your next project.">
    <meta property="og:image" content="#!">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="#!">
    <meta property="twitter:title" content="Evohus| Admin Dashboard Template">
    <meta property="twitter:description" content="Get the best admin dashboard template with Bootstrap 5.3.8, multiple layouts, RTL/LTR support, dark/light mode, responsive design, and Sass support. Lightweight, easy to customize, and perfect for your next project.">
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

  <script type="module" crossorigin src="{{ asset('dashboard/assets/admin.bundle-CEbNEZ37.js') }}"></script>
  <!-- <script type="module" crossorigin src="{{ asset('dashboard/assets/signin-basic.init-CarhJS1N.js') }}"></script> -->
  
  <link rel="stylesheet" crossorigin href="{{ asset('dashboard/assets/css/admin.css') }}">
</head>

<body class="sidebar-hidden ">
<div class="auth-wrapper">
    @yield('content')
</div>

<!-- load your vendor scripts for all pages  -->


</body>


</html>