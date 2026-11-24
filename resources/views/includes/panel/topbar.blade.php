{{-- Shared panel top bar. Optional: $quickCreate (list of [label, icon, url]), $notifications (collection) --}}
@php $user = auth()->user(); @endphp
<header class="tp-topbar">
    <button type="button" class="tp-icon-btn tp-burger" data-tp-open aria-label="Open menu"><x-tu-icon name="menu" /></button>
    <button type="button" class="tp-icon-btn tp-collapse-btn tp-hide-sm" data-tp-collapse aria-label="Collapse sidebar"><x-tu-icon name="sidebar" /></button>
    <h1 class="tp-topbar-title text-truncate">@yield('title', 'Dashboard')</h1>

    <div class="tp-topbar-actions">
        @if (!empty($quickCreate))
            <div class="tp-dd" data-tp-dd>
                <button type="button" class="tu-btn tu-btn-primary tu-btn-sm" data-tp-dd-toggle aria-expanded="false">
                    <x-tu-icon name="plus" /> <span class="tp-hide-sm">Create</span>
                </button>
                <div class="tp-dd-menu">
                    @foreach ($quickCreate as [$label, $icon, $url])
                        <a href="{{ $url }}" class="tp-dd-item"><x-tu-icon :name="$icon" /> {{ $label }}</a>
                    @endforeach
                </div>
            </div>
        @endif

        @isset($notifications)
            <div class="tp-dd" data-tp-dd>
                <button type="button" class="tp-icon-btn" data-tp-dd-toggle aria-label="Recent activity" aria-expanded="false">
                    <x-tu-icon name="bell" />
                    @if ($notifications->isNotEmpty())<span class="tp-dot"></span>@endif
                </button>
                <div class="tp-dd-menu" style="min-width:320px">
                    <div class="tp-dd-head"><strong>Recent activity</strong><span>Latest listings and agents</span></div>
                    @forelse ($notifications as $n)
                        <a href="{{ $n['url'] }}" class="tp-notif" style="text-decoration:none">
                            <span class="tu-menu-ico" style="width:34px;height:34px"><x-tu-icon :name="$n['icon']" /></span>
                            <span style="min-width:0">
                                <strong class="text-truncate d-block">{{ $n['title'] }}</strong>
                                <span>{{ $n['label'] }} · {{ optional($n['created_at'])->diffForHumans() }}</span>
                            </span>
                        </a>
                    @empty
                        <div class="tp-notif"><span>Nothing new yet.</span></div>
                    @endforelse
                </div>
            </div>
        @endisset

        <a href="{{ route('front.home') }}" target="_blank" rel="noopener" class="tp-icon-btn tp-hide-sm" title="View website" aria-label="View website"><x-tu-icon name="external" /></a>

        <div class="tp-dd" data-tp-dd>
            <button type="button" class="tp-profile-btn" data-tp-dd-toggle aria-expanded="false">
                <span class="tu-avatar">{{ strtoupper(mb_substr($user->name ?? 'U', 0, 1)) }}</span>
                <strong class="tp-hide-sm">{{ \Illuminate\Support\Str::limit($user->name, 16) }}</strong>
                <x-tu-icon name="chevron-down" size="14" class="tp-hide-sm" />
            </button>
            <div class="tp-dd-menu">
                <div class="tp-dd-head"><strong>{{ $user->name }}</strong><span>{{ $user->email }}</span></div>
                <a href="{{ route('profile.show') }}" class="tp-dd-item"><x-tu-icon name="user" /> My profile</a>
                <a href="{{ route('front.home') }}" class="tp-dd-item"><x-tu-icon name="globe" /> View website</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="tp-dd-item is-danger"><x-tu-icon name="logout" /> Sign out</button>
                </form>
            </div>
        </div>
    </div>
</header>
