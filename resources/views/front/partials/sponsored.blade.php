{{--
    Sponsored strip + premium spotlight pop-up for the homepage.
    $sponsored: listings currently in the ad rotation (premium + basic/medium within their paid ad days)
    $spotlight: premium listings for the pop-up
--}}
@if ($sponsored->isNotEmpty())
<section class="tu-section-tight" style="padding-top:40px">
    <div class="tu-container">
        <div class="tu-section-head">
            <div>
                <div class="tu-eyebrow">Sponsored</div>
                <h2 class="tu-h2">Promoted listings</h2>
                <p class="tu-lead">Properties boosted by their owners and agents with a Terra package.</p>
            </div>
            <a href="{{ route('front.agents.register') }}" class="tu-link-arrow">Promote your property <x-tu-icon name="arrow-right" /></a>
        </div>
        <div class="tu-scroller tu-sponsored">
            @foreach ($sponsored as $item)
                @include('front.partials.card', ['item' => $item])
            @endforeach
        </div>
    </div>
</section>
@endif

@if ($spotlight->isNotEmpty())
<div class="tu-spot" id="tuSpotlight" role="dialog" aria-modal="true" aria-labelledby="tuSpotTitle" hidden>
    <div class="tu-spot-box">
        <button type="button" class="tu-spot-close" data-spot-close aria-label="Close"><x-tu-icon name="x" /></button>
        <div class="tu-spot-track" id="tuSpotTrack">
            @foreach ($spotlight as $i => $item)
                <article class="tu-spot-slide {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}">
                    <a href="{{ $item['url'] }}" class="tu-spot-media">
                        <img src="{{ $item['image'] ?: asset('front/assets/img/all-images/properties/property-img1.png') }}" alt="" loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                        <span class="tu-badge tu-badge-featured" style="position:absolute;top:16px;left:16px"><x-tu-icon name="star" size="11" /> Premium</span>
                    </a>
                    <div class="tu-spot-body">
                        <div class="tu-eyebrow" style="margin-bottom:8px">Featured on Terra</div>
                        <h3 @if ($i === 0) id="tuSpotTitle" @endif>{{ $item['title'] }}</h3>
                        <p class="tu-card-loc" style="margin:6px 0 14px"><x-tu-icon name="pin" /> {{ $item['location'] }}</p>
                        <div class="tu-card-price" style="font-size:1.5rem">
                            @if ($item['free'] ?? false) Free
                            @elseif ($item['price'] > 0) {{ number_format($item['price']) }}<small>{{ $item['currency'] }}</small>
                            @else Price on request @endif
                        </div>
                        @if (count($item['meta']))
                            <div class="tu-card-meta" style="border:0;padding-top:10px">
                                @foreach ($item['meta'] as $value)<span>{{ $value }}</span>@endforeach
                            </div>
                        @endif
                        <div style="display:flex;gap:10px;margin-top:20px;flex-wrap:wrap">
                            <a href="{{ $item['url'] }}" class="tu-btn tu-btn-primary">View listing <x-tu-icon name="arrow-right" /></a>
                            @if ($item['wa'])<a href="{{ $item['wa'] }}" target="_blank" rel="noopener" class="tu-btn tu-btn-wa"><x-tu-icon name="whatsapp" /> Ask</a>@endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        @if ($spotlight->count() > 1)
            <div class="tu-spot-nav">
                <button type="button" data-spot-step="-1" aria-label="Previous">‹</button>
                <div class="tu-spot-dots">
                    @foreach ($spotlight as $i => $item)<span class="{{ $i === 0 ? 'is-active' : '' }}"></span>@endforeach
                </div>
                <button type="button" data-spot-step="1" aria-label="Next">›</button>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const spot = document.getElementById('tuSpotlight');
        if (!spot) return;
        const KEY = 'terra.spotlight.seen';
        let seen = false;
        try { seen = sessionStorage.getItem(KEY) === '1'; } catch (e) {}
        if (seen) return;

        const slides = spot.querySelectorAll('.tu-spot-slide');
        const dots = spot.querySelectorAll('.tu-spot-dots span');
        let i = 0, timer;
        const show = (n) => {
            i = (n + slides.length) % slides.length;
            slides.forEach((s, k) => s.classList.toggle('is-active', k === i));
            dots.forEach((d, k) => d.classList.toggle('is-active', k === i));
        };
        const close = () => {
            spot.classList.remove('is-open');
            setTimeout(() => { spot.hidden = true; }, 250);
            document.body.style.overflow = '';
            clearInterval(timer);
            try { sessionStorage.setItem(KEY, '1'); } catch (e) {}
        };
        spot.querySelectorAll('[data-spot-step]').forEach(b => b.addEventListener('click', () => { show(i + Number(b.dataset.spotStep)); clearInterval(timer); }));
        spot.querySelector('[data-spot-close]').addEventListener('click', close);
        spot.addEventListener('click', (e) => { if (e.target === spot) close(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !spot.hidden) close(); });

        // Open after a short pause so the page loads first. Never interrupt someone who is
        // already searching (Explore / Terra AI open, or arriving on a deep link).
        const busy = () => location.hash.startsWith('#ai') || location.hash === '#explore'
            || document.body.classList.contains('tu-ai-open') || document.body.classList.contains('tu-explore-open')
            || document.body.classList.contains('tu-drawer-open');
        setTimeout(() => {
            if (busy()) return;
            spot.hidden = false;
            requestAnimationFrame(() => spot.classList.add('is-open'));
            if (slides.length > 1 && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                timer = setInterval(() => show(i + 1), 5000);
            }
        }, 1800);
    })();
</script>
@endpush
@endif
