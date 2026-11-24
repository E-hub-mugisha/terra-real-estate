{{-- Hero carousel of premium listings. Expects $slides (Listing arrays) and $premium (bool). --}}
@php
    $fallback = asset('front/assets/img/all-images/properties/property-img1.png');
@endphp
<aside class="tu-hs" id="tuHeroSlider" aria-roledescription="carousel" aria-label="{{ $premium ? __('Premium properties') : __('Featured properties') }}" data-no-aos>
    <div class="tu-hs-head">
        <span class="tu-hs-label"><x-tu-icon name="star" size="14" /> {{ $premium ? __('Premium properties') : __('Featured on Terra') }}</span>
        @if ($slides->count() > 1)
            <span class="tu-hs-count" aria-hidden="true"><b data-hs-current>1</b> / {{ $slides->count() }}</span>
        @endif
    </div>

    <div class="tu-hs-viewport">
        <div class="tu-hs-track" data-hs-track>
            @foreach ($slides as $i => $s)
                <article class="tu-hs-slide" role="group" aria-roledescription="slide" aria-label="{{ $i + 1 }} / {{ $slides->count() }}" @if ($i > 0) aria-hidden="true" @endif>
                    <a href="{{ $s['url'] }}" class="tu-hs-media" tabindex="{{ $i === 0 ? 0 : -1 }}" aria-label="{{ $s['title'] }}">
                        <img src="{{ $s['image'] ?: $fallback }}" alt="" @if ($i > 0) loading="lazy" @else fetchpriority="high" @endif onerror="this.onerror=null;this.src='{{ $fallback }}'">
                    </a>
                    <div class="tu-hs-badges">
                        @if ($premium || $s['featured'])<span class="tu-badge tu-badge-featured"><x-tu-icon name="star" size="11" /> {{ __('Premium') }}</span>@endif
                        <span class="tu-badge tu-hs-chip">{{ $s['kind_label'] }}</span>
                        @if ($s['kind'] !== 'design')<span class="tu-badge tu-hs-chip">{{ $s['condition'] === 'for_rent' ? __('For rent') : __('For sale') }}</span>@endif
                    </div>
                    <div class="tu-hs-body">
                        <div class="tu-hs-price">{{ \App\Support\Listing::price($s) }}@if ($s['price'] > 0) <small>{{ $s['currency'] }}{{ $s['condition'] === 'for_rent' && $s['kind'] !== 'design' ? ' / ' . __('month') : '' }}</small>@endif</div>
                        <h3 class="tu-hs-title"><a href="{{ $s['url'] }}" tabindex="-1">{{ $s['title'] }}</a></h3>
                        <div class="tu-hs-meta">
                            <span><x-tu-icon name="pin" size="14" /> {{ $s['location'] }}</span>
                            @foreach (array_slice($s['meta'], 0, 3) as $m)<span>{{ $m }}</span>@endforeach
                        </div>
                        <a href="{{ $s['url'] }}" class="tu-btn tu-btn-primary tu-hs-cta" tabindex="{{ $i === 0 ? 0 : -1 }}">{{ __('View property') }} <x-tu-icon name="arrow-right" /></a>
                    </div>
                </article>
            @endforeach
        </div>
        @if ($slides->count() > 1)
            <button type="button" class="tu-hs-nav tu-hs-prev" data-hs-step="-1" aria-label="{{ __('Previous property') }}"><x-tu-icon name="arrow-left" /></button>
            <button type="button" class="tu-hs-nav tu-hs-next" data-hs-step="1" aria-label="{{ __('Next property') }}"><x-tu-icon name="arrow-right" /></button>
        @endif
    </div>

    @if ($slides->count() > 1)
        <div class="tu-hs-foot">
            <div class="tu-hs-dots" role="tablist" aria-label="{{ __('Choose a property') }}">
                @foreach ($slides as $i => $s)
                    <button type="button" role="tab" class="{{ $i === 0 ? 'is-active' : '' }}" data-hs-go="{{ $i }}" aria-label="{{ $s['title'] }}" aria-selected="{{ $i === 0 ? 'true' : 'false' }}"><i></i></button>
                @endforeach
            </div>
            <button type="button" class="tu-hs-pause" data-hs-pause aria-label="{{ __('Pause slideshow') }}" aria-pressed="false">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true" data-hs-icon-pause><rect x="6" y="5" width="4" height="14" rx="1"/><rect x="14" y="5" width="4" height="14" rx="1"/></svg>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor" aria-hidden="true" data-hs-icon-play hidden><path d="M8 5.5v13a1 1 0 0 0 1.5.86l10.5-6.5a1 1 0 0 0 0-1.72L9.5 4.64A1 1 0 0 0 8 5.5z"/></svg>
            </button>
        </div>
    @endif
</aside>

@if ($slides->count() > 1)
@push('scripts')
<script>
    (function () {
        const root = document.getElementById('tuHeroSlider');
        if (!root) return;
        const track = root.querySelector('[data-hs-track]');
        const slides = [...track.children];
        const dots = [...root.querySelectorAll('[data-hs-go]')];
        const counter = root.querySelector('[data-hs-current]');
        const pauseBtn = root.querySelector('[data-hs-pause]');
        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const DELAY = 5500;
        let i = 0, timer = null, paused = reduce, hovering = false;

        const go = (n) => {
            i = (n + slides.length) % slides.length;
            track.style.transform = 'translateX(' + (-100 * i) + '%)';
            slides.forEach((s, k) => {
                const on = k === i;
                s.setAttribute('aria-hidden', String(!on));
                s.querySelectorAll('a').forEach(a => a.tabIndex = on && !a.closest('.tu-hs-title') ? 0 : -1);
            });
            dots.forEach((d, k) => { d.classList.toggle('is-active', k === i); d.setAttribute('aria-selected', String(k === i)); });
            if (counter) counter.textContent = i + 1;
            restart();
        };
        const restart = () => {
            clearTimeout(timer);
            root.classList.remove('is-running');
            if (paused || hovering || document.hidden) return;
            void root.offsetWidth; // restart the dot progress animation
            root.classList.add('is-running');
            timer = setTimeout(() => go(i + 1), DELAY);
        };
        const setPaused = (p) => {
            paused = p;
            pauseBtn.setAttribute('aria-pressed', String(p));
            pauseBtn.setAttribute('aria-label', p ? @json(__('Play slideshow')) : @json(__('Pause slideshow')));
            pauseBtn.querySelector('[data-hs-icon-pause]').hidden = p;
            pauseBtn.querySelector('[data-hs-icon-play]').hidden = !p;
            restart();
        };

        root.querySelectorAll('[data-hs-step]').forEach(b => b.addEventListener('click', () => go(i + Number(b.dataset.hsStep))));
        dots.forEach(d => d.addEventListener('click', () => go(Number(d.dataset.hsGo))));
        pauseBtn.addEventListener('click', () => setPaused(!paused));
        root.addEventListener('mouseenter', () => { hovering = true; restart(); });
        root.addEventListener('mouseleave', () => { hovering = false; restart(); });
        root.addEventListener('focusin', () => { hovering = true; restart(); });
        root.addEventListener('focusout', (e) => { if (!root.contains(e.relatedTarget)) { hovering = false; restart(); } });
        root.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') { e.preventDefault(); go(i + 1); }
            if (e.key === 'ArrowLeft') { e.preventDefault(); go(i - 1); }
        });
        document.addEventListener('visibilitychange', restart);

        // Swipe on touch screens
        let x0 = null, y0 = null;
        track.addEventListener('touchstart', (e) => { x0 = e.touches[0].clientX; y0 = e.touches[0].clientY; }, { passive: true });
        track.addEventListener('touchend', (e) => {
            if (x0 === null) return;
            const dx = e.changedTouches[0].clientX - x0, dy = e.changedTouches[0].clientY - y0;
            if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) go(i + (dx < 0 ? 1 : -1));
            x0 = null;
        });

        if (reduce) setPaused(true); else restart();
    })();
</script>
@endpush
@endif
