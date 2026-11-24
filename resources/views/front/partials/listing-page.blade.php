{{--
    Shared listing page.
    Required: $items (Collection of App\Support\Listing arrays), $title
    Optional: $subtitle, $eyebrow, $crumb, $paginator (server-side paginated designs),
              $serverSearch (bool: search box submits to the server instead of filtering in the page)
--}}
@php
    $kinds = $items->pluck('kind')->unique()->values();
    $conditions = $items->pluck('condition')->unique()->values();
    $hasHouses = $kinds->contains('house');
    $kindLabels = ['house' => 'Houses', 'land' => 'Land', 'design' => 'Designs'];
    $counts = $items->countBy('kind');
    $serverSearch = $serverSearch ?? false;
@endphp

<section class="tu-page-hero">
    <div class="tu-container">
        <ol class="tu-crumbs">
            <li><a href="{{ route('front.home') }}">Home</a></li>
            <li>{{ $crumb ?? $title }}</li>
        </ol>
        @isset($eyebrow)<div class="tu-eyebrow" style="color:#D05208">{{ $eyebrow }}</div>@endisset
        <h1 class="tu-h1">{{ $title }}</h1>
        @isset($subtitle)<p>{{ $subtitle }}</p>@endisset
    </div>
</section>

<div class="tu-toolbar">
    <form class="tu-container tu-toolbar-row" id="tuFilters" @if($serverSearch) method="GET" @else onsubmit="return false" @endif>
        <label class="tu-input-icon">
            <span class="tu-sr">Search</span>
            <x-tu-icon name="search" />
            <input type="search" class="tu-input" name="{{ $serverSearch ? 'search' : 'q' }}" id="tuQ"
                value="{{ request($serverSearch ? 'search' : 'q') }}" placeholder="Search by title or location…" autocomplete="off">
        </label>

        @if ($kinds->count() > 1)
            <div class="tu-toolbar-chips" role="group" aria-label="Type">
                <button type="button" class="tu-chip is-active" data-kind="">All <span class="tu-chip-count">{{ $items->count() }}</span></button>
                @foreach ($kinds as $kind)
                    <button type="button" class="tu-chip" data-kind="{{ $kind }}">{{ $kindLabels[$kind] }} <span class="tu-chip-count">{{ $counts[$kind] }}</span></button>
                @endforeach
            </div>
        @endif

        @if ($conditions->count() > 1)
            <select class="tu-select" id="tuCondition" aria-label="Sale or rent">
                <option value="">Sale &amp; rent</option>
                <option value="for_sale">For sale</option>
                <option value="for_rent">For rent</option>
            </select>
        @endif

        @if (!empty($filters ?? null))
            {!! $filters !!}
        @endif

        <select class="tu-select" id="tuPrice" aria-label="Price">
            <option value="">Any price</option>
            <option value="0-10000000">Under 10M</option>
            <option value="10000000-50000000">10M – 50M</option>
            <option value="50000000-150000000">50M – 150M</option>
            <option value="150000000-">150M+</option>
        </select>

        @if ($hasHouses)
            <select class="tu-select" id="tuBeds" aria-label="Bedrooms">
                <option value="">Any beds</option>
                @foreach ([1, 2, 3, 4, 5] as $n)
                    <option value="{{ $n }}">{{ $n }}+ beds</option>
                @endforeach
            </select>
        @endif

        <select class="tu-select" id="tuSort" aria-label="Sort">
            <option value="featured">Recommended</option>
            <option value="newest">Newest</option>
            <option value="price-asc">Price: low to high</option>
            <option value="price-desc">Price: high to low</option>
        </select>
    </form>
</div>

<section class="tu-container" style="padding-bottom:64px">
    <div class="tu-result-bar">
        <span><strong id="tuCount">{{ $items->count() }}</strong> <span id="tuCountLabel">{{ \Illuminate\Support\Str::plural('listing', $items->count()) }}</span></span>
        <div style="display:flex;align-items:center;gap:8px">
            <button type="button" class="tu-chip" id="tuSavedOnly" aria-pressed="false"><x-tu-icon name="heart" size="15" /> Saved <span class="tu-chip-count" data-saved-count>0</span></button>
            <button type="button" class="tu-btn tu-btn-sm tu-btn-ghost" id="tuReset" hidden>Clear filters</button>
            <div class="tu-view-toggle" role="group" aria-label="Layout">
                <button type="button" class="is-active" data-view="grid" aria-label="Grid view"><x-tu-icon name="grid" size="16" /></button>
                <button type="button" data-view="list" aria-label="List view"><x-tu-icon name="list" size="16" /></button>
                @if ($items->contains(fn ($i) => !empty($i['lat']) && !empty($i['lng'])))
                    <button type="button" data-view="map" aria-label="Map view"><x-tu-icon name="pin" size="16" /></button>
                @endif
            </div>
        </div>
    </div>

    @if ($items->isEmpty())
        <div class="tu-empty">
            <div class="tu-empty-ico"><x-tu-icon name="search" /></div>
            <h3>No listings here yet</h3>
            <p>New properties are added every week. Talk to an agent and we'll help you find the right one.</p>
            <a href="{{ route('front.agents') }}" class="tu-btn tu-btn-primary">Find an agent</a>
        </div>
    @else
        <div class="tu-map" id="tuMap" hidden aria-label="Map of listings"></div>
        <div class="tu-grid" id="tuGrid">
            @foreach ($items as $item)
                @include('front.partials.card', ['item' => $item])
            @endforeach
        </div>
        <div class="tu-empty" id="tuNoMatch" hidden>
            <div class="tu-empty-ico"><x-tu-icon name="filter" /></div>
            <h3 id="tuNoMatchTitle">Nothing matches those filters</h3>
            <p id="tuNoMatchText">Try a wider price range or a different area.</p>
            <button type="button" class="tu-btn" data-reset>Clear filters</button>
        </div>
        @isset($paginator)
            {{ $paginator->withQueryString()->links('pagination::bootstrap-5') }}
        @endisset
    @endif
</section>

@push('scripts')
<script>
    (function () {
        const grid = document.getElementById('tuGrid');
        if (!grid) return;
        const cards = Array.from(grid.children);
        const $ = (id) => document.getElementById(id);
        const q = $('tuQ'), cond = $('tuCondition'), price = $('tuPrice'), beds = $('tuBeds'), sort = $('tuSort');
        const serverSearch = @json($serverSearch);
        const chips = document.querySelectorAll('.tu-toolbar-chips .tu-chip');
        let kind = '';
        let savedOnly = false;
        const savedBtn = $('tuSavedOnly');

        const params = new URLSearchParams(location.search);
        const legacy = { home: 'house', house: 'house', land: 'land', design: 'design' };
        if (legacy[params.get('category')] || legacy[params.get('kind')]) {
            kind = legacy[params.get('kind')] || legacy[params.get('category')];
        }
        if (['for_sale', 'for_rent'].includes(params.get('condition')) && cond) cond.value = params.get('condition');
        if (params.get('saved')) savedOnly = true;

        function apply() {
            const term = serverSearch ? '' : q.value.trim().toLowerCase();
            const [min, max] = (price.value || '-').split('-').map(v => v === '' ? null : Number(v));
            const minBeds = beds && beds.value ? Number(beds.value) : 0;
            const saved = window.TerraSaved ? window.TerraSaved.all() : new Set();
            let shown = 0;

            const sorted = [...cards].sort((a, b) => {
                const d = (k) => Number(a.dataset[k]) - Number(b.dataset[k]);
                switch (sort.value) {
                    case 'newest': return -d('created');
                    case 'price-asc': return d('price');
                    case 'price-desc': return -d('price');
                    default: return -d('featured') || -d('created');
                }
            });
            sorted.forEach(card => {
                const p = Number(card.dataset.price);
                const ok = (!kind || card.dataset.kind === kind)
                    && (!cond || !cond.value || card.dataset.condition === cond.value)
                    && (min === null || p >= min) && (max === null || p <= max)
                    && (!minBeds || card.dataset.kind !== 'house' || Number(card.dataset.beds) >= minBeds)
                    && (!term || card.dataset.search.includes(term))
                    && (!savedOnly || saved.has(card.querySelector('[data-save-id]').dataset.saveId));
                card.hidden = !ok;
                if (ok) shown++;
                grid.appendChild(card);
            });

            $('tuCount').textContent = shown;
            $('tuCountLabel').textContent = (savedOnly ? 'saved ' : '') + (shown === 1 ? 'listing' : 'listings');
            $('tuNoMatch').hidden = shown !== 0;
            $('tuNoMatchTitle').textContent = savedOnly && saved.size === 0 ? 'No saved listings yet' : 'Nothing matches those filters';
            $('tuNoMatchText').textContent = savedOnly && saved.size === 0 ? 'Tap the heart on any listing to keep it here for later.' : 'Try a wider price range or a different area.';
            savedBtn.classList.toggle('is-active', savedOnly);
            savedBtn.setAttribute('aria-pressed', String(savedOnly));
            window.TerraUI && window.TerraUI.refresh();
            const dirty = kind || savedOnly || (cond && cond.value) || price.value || (beds && beds.value) || (!serverSearch && q.value);
            $('tuReset').hidden = !dirty;
            chips.forEach(c => c.classList.toggle('is-active', c.dataset.kind === kind));
            drawMarkers();
        }

        function reset() {
            kind = '';
            savedOnly = false;
            if (!serverSearch) q.value = '';
            [cond, price, beds].forEach(el => el && (el.value = ''));
            sort.value = 'featured';
            apply();
        }

        chips.forEach(c => c.addEventListener('click', () => { kind = c.dataset.kind; apply(); }));
        [cond, price, beds, sort].forEach(el => el && el.addEventListener('change', apply));
        if (!serverSearch) { let t; q.addEventListener('input', () => { clearTimeout(t); t = setTimeout(apply, 150); }); }
        $('tuReset').addEventListener('click', reset);
        savedBtn.addEventListener('click', () => { savedOnly = !savedOnly; apply(); });
        document.addEventListener('terra:saved', () => { if (savedOnly) apply(); });

        // Grid / list layout, remembered per browser
        // Map view: Leaflet is loaded on first use; markers follow the active filters.
        const mapEl = $('tuMap');
        let map = null, layer = null, leafletLoading = null;
        const loadLeaflet = () => leafletLoading ||= new Promise((resolve, reject) => {
            if (window.L) return resolve();
            const css = document.createElement('link');
            css.rel = 'stylesheet'; css.href = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css';
            document.head.appendChild(css);
            const js = document.createElement('script');
            js.src = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js';
            js.onload = resolve; js.onerror = reject;
            document.head.appendChild(js);
        });
        const esc = (s) => String(s || '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
        const colors = { house: '#D05208', land: '#19265D', design: '#19265D' };
        function drawMarkers() {
            if (!map) return;
            layer.clearLayers();
            const pts = [];
            cards.filter(c => !c.hidden && c.dataset.lat).forEach(c => {
                const ll = [Number(c.dataset.lat), Number(c.dataset.lng)];
                pts.push(ll);
                L.circleMarker(ll, { radius: 9, weight: 3, color: '#FFFFFF', fillColor: colors[c.dataset.kind] || '#19265D', fillOpacity: 1 })
                    .bindPopup('<a class="tu-map-pop" href="' + esc(c.dataset.url) + '">' + (c.dataset.image ? '<img src="' + esc(c.dataset.image) + '" alt="">' : '')
                        + '<strong>' + esc(c.dataset.title) + '</strong><span>' + esc(c.dataset.priceLabel) + '</span></a>')
                    .addTo(layer);
            });
            if (pts.length) map.fitBounds(pts, { padding: [40, 40], maxZoom: 14 });
        }
        function showMap(on) {
            mapEl.hidden = !on;
            if (!on) return;
            loadLeaflet().then(() => {
                if (!map) {
                    map = L.map(mapEl, { scrollWheelZoom: false }).setView([-1.9441, 30.0619], 9);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
                    layer = L.layerGroup().addTo(map);
                }
                setTimeout(() => { map.invalidateSize(); drawMarkers(); }, 30);
            }).catch(() => { mapEl.innerHTML = '<p class="tu-hint" style="padding:20px">The map could not load. Check your connection and try again.</p>'; });
        }

        const viewBtns = document.querySelectorAll('[data-view]');
        const setView = (v) => {
            if (v === 'map' && !mapEl) v = 'grid';
            showMap(v === 'map');
            grid.classList.toggle('is-list', v === 'list');
            viewBtns.forEach(b => b.classList.toggle('is-active', b.dataset.view === v));
            try { localStorage.setItem('terra.view', v); } catch (e) {}
            window.TerraUI && window.TerraUI.refresh();
        };
        viewBtns.forEach(b => b.addEventListener('click', () => setView(b.dataset.view)));
        try { const saved = localStorage.getItem('terra.view'); if (saved === 'list' || (saved === 'map' && document.querySelector('[data-view=map]'))) setView(saved); } catch (e) {}
        document.querySelector('[data-reset]')?.addEventListener('click', reset);
        apply();
    })();
</script>
@endpush
