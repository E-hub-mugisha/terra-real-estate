{{-- "Explore" offcanvas: property categories with live counts. Opened by [data-tu-explore-open]. --}}
@php $explore = \App\Support\ExploreMenu::data(); @endphp
<div class="tu-oc-backdrop" data-tu-explore-close></div>
<aside class="tu-oc tu-oc-left" id="tuExplore" role="dialog" aria-modal="true" aria-labelledby="tuExploreTitle" aria-hidden="true" tabindex="-1">
    <div class="tu-oc-head">
        <div>
            <span class="tu-eyebrow">{{ __('Explore Terra') }}</span>
            <h2 id="tuExploreTitle">{{ __('Browse by category') }}</h2>
        </div>
        <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost" data-tu-explore-close aria-label="{{ __('Close') }}"><x-tu-icon name="x" /></button>
    </div>

    <div class="tu-oc-body">
        <label class="tu-ex-filter">
            <x-tu-icon name="search" />
            <input type="search" placeholder="{{ __('Filter categories…') }}" data-tu-explore-filter aria-label="{{ __('Filter categories') }}">
        </label>

        @foreach ($explore['sections'] as $section)
            <section class="tu-ex-section" data-ex-section>
                <h3>{{ $section['title'] }}</h3>
                <div class="tu-ex-grid">
                    @foreach ($section['items'] as $item)
                        <a href="{{ $item['url'] }}" class="tu-ex-card" data-ex-item="{{ \Illuminate\Support\Str::lower($item['label'] . ' ' . $item['sub']) }}">
                            <span class="tu-menu-ico"><x-tu-icon :name="$item['icon']" /></span>
                            <span class="tu-ex-text"><strong>{{ $item['label'] }}</strong><small>{{ $item['sub'] }}</small></span>
                            <span class="tu-ex-count">{{ number_format($item['count']) }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach

        @if ($explore['types'])
            <section class="tu-ex-section" data-ex-section>
                <h3>{{ __('House types') }}</h3>
                <div class="tu-ex-chips">
                    @foreach ($explore['types'] as $t)
                        <a href="{{ $t['url'] }}" class="tu-chip" data-ex-item="{{ \Illuminate\Support\Str::lower($t['label']) }}">{{ $t['label'] }} <span class="tu-chip-count">{{ $t['count'] }}</span></a>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="tu-ex-section" data-ex-section>
            <h3>
                {{ __('Architectural designs') }}
                <a href="{{ $explore['designs']['url'] }}">{{ __('All :n', ['n' => $explore['designs']['total']]) }} <x-tu-icon name="arrow-right" size="13" /></a>
            </h3>
            <div class="tu-ex-list">
                @foreach ($explore['designs']['categories'] as $c)
                    <a href="{{ $c['url'] }}" data-ex-item="{{ \Illuminate\Support\Str::lower($c['label'] . ' design') }}" class="{{ $c['count'] ? '' : 'is-empty' }}">
                        <x-tu-icon name="ruler" size="15" /> <span>{{ $c['label'] }}</span> <small>{{ $c['count'] }}</small>
                    </a>
                @endforeach
            </div>
        </section>

        @if ($explore['areas'])
            <section class="tu-ex-section" data-ex-section>
                <h3>{{ __('Popular areas') }}</h3>
                <div class="tu-ex-chips">
                    @foreach ($explore['areas'] as $a)
                        <a href="{{ $a['url'] }}" class="tu-chip" data-ex-item="{{ \Illuminate\Support\Str::lower($a['label']) }}"><x-tu-icon name="pin" size="13" /> {{ $a['label'] }} <span class="tu-chip-count">{{ $a['count'] }}</span></a>
                    @endforeach
                </div>
            </section>
        @endif

        <p class="tu-ex-empty" data-ex-empty hidden>{{ __('No category matches. Try asking Terra AI instead.') }}</p>
    </div>

    <div class="tu-oc-foot">
        <button type="button" class="tu-btn tu-btn-dark tu-btn-block" data-tu-ai-open data-tu-explore-close><x-tu-icon name="sparkle" /> {{ __('Not sure? Ask Terra AI') }}</button>
    </div>
</aside>
