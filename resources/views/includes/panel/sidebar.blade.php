{{--
    Shared panel sidebar.
    $nav: list of sections: ['label' => ?string, 'items' => [ [label, icon, route|null, active-patterns, children?] ]]
    $tag: small label next to the logo (Admin / Agent)
--}}
@php
    $isOn = fn ($patterns) => collect((array) $patterns)->contains(fn ($p) => request()->routeIs($p));
    $user = auth()->user();
@endphp
<aside class="tp-sidebar" id="tpSidebar" aria-label="Sidebar">
    <a href="{{ $home }}" class="tp-brand">
        <img src="{{ asset('front/assets/img/logo/logo-wc.png') }}" alt="{{ config('app.name') }}">
        <span class="tp-brand-tag">{{ $tag }}</span>
    </a>

    <nav class="tp-nav">
        @foreach ($nav as $section)
            @if (!empty($section['label']))
                <div class="tp-nav-label">{{ $section['label'] }}</div>
            @endif
            @foreach ($section['items'] as $item)
                @continue(empty($item['href']) && !empty($item['route']) && !\Illuminate\Support\Facades\Route::has($item['route']))
                @php $children = $item['children'] ?? []; $active = $isOn($item['active'] ?? []); @endphp
                @if ($children)
                    <div class="tp-group {{ $active ? 'is-open has-active' : '' }}">
                        <button type="button" class="tp-link" data-tp-group aria-expanded="{{ $active ? 'true' : 'false' }}" title="{{ $item['label'] }}">
                            <x-tu-icon :name="$item['icon']" /><span>{{ $item['label'] }}</span>
                            <x-tu-icon name="chevron-right" class="tp-caret" />
                        </button>
                        <div class="tp-sub">
                            @foreach ($children as $child)
                                <a href="{{ route($child['route']) }}" class="{{ $isOn($child['active'] ?? $child['route']) ? 'is-active' : '' }}">{{ $child['label'] }}</a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $item['href'] ?? route($item['route']) }}" class="tp-link {{ $active ? 'is-active' : '' }}" title="{{ $item['label'] }}"
                        @if (!empty($item['external'])) target="_blank" rel="noopener" @endif>
                        <x-tu-icon :name="$item['icon']" /><span>{{ $item['label'] }}</span>
                        @if (!empty($item['badge']))<b class="tp-badge" aria-label="{{ $item['badge'] }} new">{{ $item['badge'] > 99 ? '99+' : $item['badge'] }}</b>@endif
                    </a>
                @endif
            @endforeach
        @endforeach
    </nav>

    <div class="tp-side-foot">
        <div class="tp-user">
            <span class="tu-avatar">{{ strtoupper(mb_substr($user->name ?? 'U', 0, 1)) }}</span>
            <span class="tp-user-meta" style="min-width:0">
                <span class="tp-user-name d-block text-truncate">{{ $user->name }}</span>
                <span class="tp-user-role">{{ $user->roleLabel() }}</span>
            </span>
        </div>
    </div>
</aside>
<div class="tp-backdrop" data-tp-close></div>
