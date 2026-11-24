<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@hasSection('title')@yield('title') · @endif{{ config('app.name', 'Terra Real Estate') }}</title>
    <meta name="description" content="@yield('meta_description', 'Find houses, land and architectural designs across Rwanda, listed by verified Terra agents.')">
    <meta name="theme-color" content="#19265D">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('front/assets/img/logo/fav-logo1.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="{{ asset('css/terra-ui.css') }}?v={{ @filemtime(public_path('css/terra-ui.css')) }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" defer></script>
    @include('includes.terra-account')
    <script src="{{ asset('js/terra-ui.js') }}?v={{ @filemtime(public_path('js/terra-ui.js')) }}" defer></script>
    @stack('head')
</head>

<body class="tu-body @yield('body_class')">
    <a href="#main" class="tu-sr">Skip to content</a>

    @include('includes.front.header')

    <main id="main">
        @yield('content')
    </main>

    @include('includes.front.footer')

    <a href="https://wa.me/{{ \App\Support\Listing::WHATSAPP }}?text={{ rawurlencode('Hello Terra, I need help finding a property.') }}"
        class="tu-wa-float" target="_blank" rel="noopener" aria-label="Chat with Terra on WhatsApp">
        <x-tu-icon name="whatsapp" />
        <span>Chat with us</span>
    </a>
    <button type="button" class="tu-to-top" id="tuToTop" aria-label="Back to top"><x-tu-icon name="arrow-up" /></button>

    <script src="{{ asset('front/assets/js/plugins/bootstrap.min.js') }}" defer></script>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            if (!window.Swal) return;
            const toast = (icon, title) => Swal.fire({ toast: true, position: 'top-end', icon, title, showConfirmButton: false, timer: 4000, timerProgressBar: true });
            @if (session('success')) toast('success', @json(session('success'))); @endif
            @if (session('error'))   toast('error', @json(session('error')));   @endif
            @if (session('warning')) toast('warning', @json(session('warning'))); @endif
            @if ($errors->any())     toast('error', @json($errors->first()));    @endif
        });
    </script>
    @include('includes.panel.modal-js')
    @stack('scripts')
</body>

</html>
