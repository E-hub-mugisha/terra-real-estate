<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · {{ config('app.name', 'Terra Real Estate') }}</title>
    <meta name="robots" content="noindex">
    <link rel="icon" type="image/png" href="{{ asset('front/assets/img/logo/fav-logo1.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('front/assets/css/plugins/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/terra-ui.css') }}?v={{ @filemtime(public_path('css/terra-ui.css')) }}">
</head>

<body class="tu-body">
    <div class="tu-auth">
        <aside class="tu-auth-side">
            <img class="tu-auth-bg" src="{{ asset('front/assets/img/all-images/hero/image-1.png') }}" alt="">
            <a href="{{ route('front.home') }}"><img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="{{ config('app.name') }}" style="height:34px"></a>
            <div>
                <h2>@yield('side_title', 'Houses, land and designs — all in one place.')</h2>
                <p>@yield('side_text', 'Sign in to manage your listings, track inquiries and keep your agent profile up to date.')</p>
            </div>
            <span style="font-size:.8rem;color:rgba(255, 255, 255,.5)">&copy; {{ date('Y') }} {{ config('app.name', 'Terra Real Estate') }}</span>
        </aside>

        <main class="tu-auth-main">
            <div class="tu-auth-card">
                <a href="{{ route('front.home') }}" class="d-lg-none" style="display:inline-block;margin-bottom:28px">
                    <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="{{ config('app.name') }}" style="height:30px">
                </a>

                @if (session('status'))
                    <div class="tu-alert tu-alert-success">{{ session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="tu-alert tu-alert-danger">{{ $errors->first() }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.querySelectorAll('[data-toggle-pass]').forEach(btn => btn.addEventListener('click', () => {
            const input = btn.parentElement.querySelector('input');
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            btn.textContent = show ? 'Hide' : 'Show';
        }));
        document.querySelectorAll('form[data-busy]').forEach(form => form.addEventListener('submit', () => {
            const b = form.querySelector('[type=submit]');
            if (b) { b.disabled = true; b.dataset.label = b.textContent; b.textContent = form.dataset.busy; }
        }));
    </script>
</body>

</html>
