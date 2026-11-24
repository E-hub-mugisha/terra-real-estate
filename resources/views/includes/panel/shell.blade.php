{{-- Panel body shell. Used by layouts.app and layouts.agents. --}}
@php $panel = \App\Support\PanelNav::for(auth()->user()); @endphp
<body class="tp-body">
    @include('includes.panel.sidebar', ['nav' => $panel['nav'], 'tag' => $panel['tag'], 'home' => $panel['home']])

    <div class="tp-main">
        @include('includes.panel.topbar', array_filter(['quickCreate' => $panel['create'], 'notifications' => $panel['activity']], fn ($v) => $v !== null))

        <main class="tp-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>

        <footer class="tp-footer">
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'Terra Real Estate') }} · {{ $panel['tag'] }}</span>
            <a href="https://wa.me/{{ \App\Support\Listing::WHATSAPP }}" target="_blank" rel="noopener" style="color:inherit">Need help? Chat with Terra</a>
        </footer>
    </div>

    @include('includes.panel.scripts')
    @stack('scripts')
</body>
