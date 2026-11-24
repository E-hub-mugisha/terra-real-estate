@php
    $navBuy = [
        ['route' => 'front.buy.homes',      'icon' => 'home',   'title' => 'Houses for sale',  'sub' => 'Villas, apartments and family homes'],
        ['route' => 'front.buy.lands',      'icon' => 'land',   'title' => 'Land for sale',    'sub' => 'Residential, commercial and farm plots'],
        ['route' => 'front.properties.buy', 'icon' => 'layers', 'title' => 'All listings',     'sub' => 'Search every house, plot and design'],
    ];
    $navRent = [
        ['route' => 'front.rent.homes',       'icon' => 'home',     'title' => 'Houses for rent',  'sub' => 'Long-term family homes'],
        ['route' => 'front.rent.apartments',  'icon' => 'building', 'title' => 'Apartments',       'sub' => 'Flats and serviced apartments'],
        ['route' => 'front.rent.short-stays', 'icon' => 'key',      'title' => 'Short stays',      'sub' => 'Furnished stays by the night or week'],
        ['route' => 'front.rent.lands',       'icon' => 'land',     'title' => 'Land for rent',    'sub' => 'Lease plots for farming or business'],
    ];
    $locales = ['en' => 'English', 'rw' => 'Kinyarwanda', 'fr' => 'Français'];
    $user = auth()->user();
    $isActive = fn (...$names) => request()->routeIs(...$names) ? 'is-active' : '';
@endphp

<header class="tu-header" id="tuHeader">
    <div class="tu-container tu-header-row">
        <a href="{{ route('front.home') }}" class="tu-logo" aria-label="Terra home">
            <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="{{ config('app.name', 'Terra') }}">
        </a>

        <button type="button" class="tu-explore-btn" data-tu-explore-open aria-controls="tuExplore" aria-haspopup="dialog">
            <x-tu-icon name="grid" /> <span>{{ __('Explore') }}</span>
        </button>

        <nav class="tu-nav" aria-label="Main">
            <div class="tu-nav-item" data-tu-menu>
                <button type="button" class="tu-nav-link {{ $isActive('front.buy.homes', 'front.buy.lands', 'front.properties.buy', 'front.buy.home.details', 'front.buy.land.details') }}" aria-expanded="false">
                    Buy <x-tu-icon name="chevron-down" />
                </button>
                <div class="tu-menu">
                    @foreach ($navBuy as $item)
                        <a href="{{ route($item['route']) }}" class="tu-menu-link">
                            <span class="tu-menu-ico"><x-tu-icon :name="$item['icon']" /></span>
                            <span><span class="tu-menu-title">{{ $item['title'] }}</span><span class="tu-menu-sub">{{ $item['sub'] }}</span></span>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="tu-nav-item" data-tu-menu>
                <button type="button" class="tu-nav-link {{ $isActive('front.rent.*') }}" aria-expanded="false">
                    Rent <x-tu-icon name="chevron-down" />
                </button>
                <div class="tu-menu">
                    @foreach ($navRent as $item)
                        <a href="{{ route($item['route']) }}" class="tu-menu-link">
                            <span class="tu-menu-ico"><x-tu-icon :name="$item['icon']" /></span>
                            <span><span class="tu-menu-title">{{ $item['title'] }}</span><span class="tu-menu-sub">{{ $item['sub'] }}</span></span>
                        </a>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('front.properties.architecture') }}" class="tu-nav-link {{ $isActive('front.properties.architecture', 'front.buy.design*') }}">Designs</a>
            <a href="{{ route('front.agents') }}" class="tu-nav-link {{ $isActive('front.agents', 'front.agent.details', 'agents.search.near.me') }}">Agents</a>
        </nav>

        <div class="tu-header-actions">
            <button type="button" class="tu-ai-trigger" data-tu-ai-open aria-controls="tuAi" aria-haspopup="dialog" aria-label="{{ __('Ask Terra AI') }}">
                <x-tu-icon name="sparkle" />
                <span class="tu-ai-trigger-text">{{ __('Ask Terra AI…') }}</span>
                <kbd class="tu-ai-kbd" aria-hidden="true">/</kbd>
            </button>
            <a href="{{ route('front.properties.buy', ['saved' => 1]) }}" class="tu-nav-link tu-saved-link {{ request('saved') ? 'is-active' : '' }}" aria-label="Saved listings">
                <x-tu-icon name="heart" /> <span class="d-none d-xl-inline">Saved</span>
                <span data-saved-count hidden>0</span>
            </a>
            <div class="tu-nav-item tu-lang tu-hide-md" data-tu-menu>
                <button type="button" class="tu-nav-link" aria-expanded="false" aria-label="Language">
                    <x-tu-icon name="globe" /> {{ strtoupper(app()->getLocale()) }}
                </button>
                <div class="tu-menu">
                    @foreach ($locales as $code => $label)
                        <a href="{{ route('locale.switch', $code) }}" class="tu-menu-link"><span class="tu-menu-title">{{ $label }}</span></a>
                    @endforeach
                </div>
            </div>

            @guest
                <a href="{{ route('login') }}" class="tu-btn tu-btn-ghost tu-hide-md">Sign in</a>
                <a href="{{ route('front.agents.register') }}" class="tu-btn tu-btn-primary tu-hide-md">
                    <x-tu-icon name="plus" /> List with Terra
                </a>
            @else
                <div class="tu-nav-item tu-lang tu-hide-md" data-tu-menu>
                    <button type="button" class="tu-nav-link" aria-expanded="false">
                        <span class="tu-avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                        {{ \Illuminate\Support\Str::limit($user->name, 14) }}
                        <x-tu-icon name="chevron-down" />
                    </button>
                    <div class="tu-menu" style="min-width:220px">
                        <a href="{{ route($user->redirectRoute()) }}" class="tu-menu-link">
                            <span class="tu-menu-ico"><x-tu-icon name="dashboard" /></span>
                            <span><span class="tu-menu-title">Dashboard</span><span class="tu-menu-sub">{{ $user->email }}</span></span>
                        </a>
                        <a href="{{ route('profile.show') }}" class="tu-menu-link">
                            <span class="tu-menu-ico"><x-tu-icon name="user" /></span>
                            <span class="tu-menu-title">My profile</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="tu-menu-link" style="width:100%;border:0;background:none;text-align:left">
                                <span class="tu-menu-ico" style="background:var(--tu-danger-50);color:var(--tu-danger)"><x-tu-icon name="logout" /></span>
                                <span class="tu-menu-title">Sign out</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endguest

            <button type="button" class="tu-btn tu-btn-icon tu-burger" id="tuDrawerOpen" aria-label="Open menu">
                <x-tu-icon name="menu" />
            </button>
        </div>
    </div>
</header>

{{-- Mobile drawer --}}
<div class="tu-drawer-backdrop" data-tu-drawer-close></div>
<aside class="tu-drawer" aria-label="Menu">
    <div class="tu-drawer-head">
        <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="{{ config('app.name') }}" style="height:30px">
        <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost" data-tu-drawer-close aria-label="Close menu"><x-tu-icon name="x" /></button>
    </div>
    <div class="tu-drawer-body">
        <a href="{{ route('front.home') }}" class="tu-drawer-link"><x-tu-icon name="home" /> Home</a>
        <button type="button" class="tu-drawer-link" data-tu-ai-open style="width:100%;border:0;background:none;text-align:left"><x-tu-icon name="sparkle" /> {{ __('Ask Terra AI') }}</button>
        <button type="button" class="tu-drawer-link" data-tu-explore-open style="width:100%;border:0;background:none;text-align:left"><x-tu-icon name="grid" /> {{ __('Explore categories') }}</button>
        <div class="tu-drawer-label">Buy</div>
        @foreach ($navBuy as $item)
            <a href="{{ route($item['route']) }}" class="tu-drawer-link"><x-tu-icon :name="$item['icon']" /> {{ $item['title'] }}</a>
        @endforeach
        <div class="tu-drawer-label">Rent</div>
        @foreach ($navRent as $item)
            <a href="{{ route($item['route']) }}" class="tu-drawer-link"><x-tu-icon :name="$item['icon']" /> {{ $item['title'] }}</a>
        @endforeach
        <div class="tu-drawer-label">Explore</div>
        <a href="{{ route('front.properties.architecture') }}" class="tu-drawer-link"><x-tu-icon name="design" /> Architectural designs</a>
        <a href="{{ route('front.agents') }}" class="tu-drawer-link"><x-tu-icon name="users" /> Find an agent</a>
        <a href="{{ route('front.properties.buy', ['saved' => 1]) }}" class="tu-drawer-link"><x-tu-icon name="heart" /> Saved listings</a>
        <div class="tu-drawer-label">Language</div>
        <div style="display:flex;gap:8px;padding:0 12px">
            @foreach ($locales as $code => $label)
                <a href="{{ route('locale.switch', $code) }}" class="tu-chip {{ app()->getLocale() === $code ? 'is-active' : '' }}">{{ strtoupper($code) }}</a>
            @endforeach
        </div>
    </div>
    <div class="tu-drawer-foot">
        @guest
            <a href="{{ route('front.agents.register') }}" class="tu-btn tu-btn-primary tu-btn-block"><x-tu-icon name="plus" /> List with Terra</a>
            <a href="{{ route('login') }}" class="tu-btn tu-btn-block">Sign in</a>
        @else
            <a href="{{ route($user->redirectRoute()) }}" class="tu-btn tu-btn-dark tu-btn-block"><x-tu-icon name="dashboard" /> Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="tu-btn tu-btn-block">Sign out</button>
            </form>
        @endguest
    </div>
</aside>

@include('includes.front.explore')
@include('includes.front.ai-assistant')

@push('scripts')
<script>
    (function () {
        const header = document.getElementById('tuHeader');
        const onScroll = () => header.classList.toggle('is-scrolled', window.scrollY > 8);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        // Dropdown menus: click to toggle (works on touch), hover on desktop
        const menus = document.querySelectorAll('[data-tu-menu]');
        const closeAll = (except) => menus.forEach(m => {
            if (m !== except) { m.classList.remove('is-open'); m.querySelector('button')?.setAttribute('aria-expanded', 'false'); }
        });
        menus.forEach(menu => {
            const btn = menu.querySelector('button');
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const open = !menu.classList.contains('is-open');
                closeAll(menu);
                menu.classList.toggle('is-open', open);
                btn.setAttribute('aria-expanded', String(open));
            });
            if (window.matchMedia('(hover: hover)').matches) {
                let t;
                menu.addEventListener('mouseenter', () => { clearTimeout(t); closeAll(menu); menu.classList.add('is-open'); });
                menu.addEventListener('mouseleave', () => { t = setTimeout(() => menu.classList.remove('is-open'), 160); });
            }
        });
        document.addEventListener('click', () => closeAll());
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeAll(); document.body.classList.remove('tu-drawer-open'); } });

        // Mobile drawer
        document.getElementById('tuDrawerOpen')?.addEventListener('click', () => document.body.classList.add('tu-drawer-open'));
        document.querySelectorAll('[data-tu-drawer-close]').forEach(el => el.addEventListener('click', () => document.body.classList.remove('tu-drawer-open')));
    })();
</script>
@endpush
