{{-- Photo gallery + lightbox. Expects $images (array of URLs), $title, $fallback --}}
@php
    $images = array_values(array_filter($images ?: []));
    if (!$images) $images = [$fallback];
    $shown = array_slice($images, 0, 5);
    $class = count($shown) <= 3 ? 'is-' . count($shown) : '';
@endphp
<div class="tu-gallery {{ $class }}">
    @foreach ($shown as $i => $src)
        <button type="button" data-lb="{{ $i }}" aria-label="View photo {{ $i + 1 }} of {{ count($images) }}">
            <img src="{{ $src }}" alt="{{ $title }} — photo {{ $i + 1 }}" loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                onerror="this.onerror=null;this.src='{{ $fallback }}'">
            @if ($i === count($shown) - 1 && count($images) > count($shown))
                <span class="tu-gallery-more">+{{ count($images) - count($shown) }} photos</span>
            @endif
        </button>
    @endforeach
</div>

<div class="tu-lightbox" id="tuLightbox" role="dialog" aria-modal="true" aria-label="Photo viewer">
    <button type="button" class="tu-lb-close" aria-label="Close">&times;</button>
    <button type="button" class="tu-lb-prev" aria-label="Previous">&lsaquo;</button>
    <img src="" alt="">
    <button type="button" class="tu-lb-next" aria-label="Next">&rsaquo;</button>
    <span class="tu-lb-count"></span>
</div>

@push('scripts')
<script>
    (function () {
        const images = @json($images);
        const lb = document.getElementById('tuLightbox');
        const img = lb.querySelector('img');
        const count = lb.querySelector('.tu-lb-count');
        let i = 0;
        const show = (n) => { i = (n + images.length) % images.length; img.src = images[i]; count.textContent = (i + 1) + ' / ' + images.length; };
        const open = (n) => { show(n); lb.classList.add('is-open'); document.body.style.overflow = 'hidden'; };
        const close = () => { lb.classList.remove('is-open'); document.body.style.overflow = ''; };
        document.querySelectorAll('[data-lb]').forEach(b => b.addEventListener('click', () => open(Number(b.dataset.lb))));
        lb.querySelector('.tu-lb-close').addEventListener('click', close);
        lb.querySelector('.tu-lb-prev').addEventListener('click', () => show(i - 1));
        lb.querySelector('.tu-lb-next').addEventListener('click', () => show(i + 1));
        lb.addEventListener('click', (e) => { if (e.target === lb) close(); });
        document.addEventListener('keydown', (e) => {
            if (!lb.classList.contains('is-open')) return;
            if (e.key === 'Escape') close();
            if (e.key === 'ArrowLeft') show(i - 1);
            if (e.key === 'ArrowRight') show(i + 1);
        });
    })();
</script>
@endpush
