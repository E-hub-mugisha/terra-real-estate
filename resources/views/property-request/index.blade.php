@extends('layouts.guest')
@section('title', 'Buyer & Renter Requests - Terra Real Estate')
@section('content')

<style>
    /* Reuses --bg/--surface/--dark/--gold/--text/--muted/--border/--t vars
       already defined on the marketplace page's :root. If this page can be
       loaded standalone (not always after the marketplace page), copy the
       :root block from front.marketplace.index here too. */

    .preqs-hero {
        background: var(--dark);
        padding: 40px 0 34px;
    }

    .preqs-hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(1.8rem, 3vw, 2.6rem);
        font-weight: 500;
        color: #F7F5F2;
        margin-bottom: 10px;
    }

    .preqs-hero-title em { font-style: italic; color: var(--gold-lt); }

    .preqs-hero-sub {
        font-size: .88rem;
        color: rgba(240, 237, 232, .65);
        max-width: 560px;
        line-height: 1.7;
    }

    .preqs-filter-section {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 40;
        padding: 16px 0;
    }

    .preqs-tabs {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .preqs-tab {
        font-size: .78rem;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 999px;
        cursor: pointer;
        background: var(--bg);
        border: 1px solid var(--border);
        color: var(--muted);
        transition: all var(--t);
    }

    .preqs-tab.active { background: var(--dark); border-color: var(--dark); color: #fff; }
    .preqs-tab:hover:not(.active) { border-color: var(--gold-bd); color: var(--text); }

    .preqs-filter-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .preqs-filter-row select,
    .preqs-filter-row input[type="text"] {
        font-family: inherit;
        font-size: .85rem;
        color: var(--text);
        border: 1.5px solid var(--border);
        border-radius: 8px;
        background: var(--bg);
        padding: 10px 14px;
        outline: none;
    }

    .preqs-search-wrap { position: relative; flex: 1; min-width: 220px; }
    .preqs-search-wrap input { width: 100%; padding-left: 38px; }
    .preqs-search-wrap svg {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        width: 16px; height: 16px; color: var(--dim); pointer-events: none;
    }

    .preqs-clear-btn {
        font-size: .8rem; font-weight: 600; color: var(--gold);
        background: none; border: none; cursor: pointer; padding: 10px 6px;
    }

    .preqs-results-bar {
        display: flex; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;
    }

    .preqs-results-count { font-size: .82rem; color: var(--muted); }
    .preqs-results-count strong { color: var(--text); }

    .preqs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 18px;
    }

    .preqs-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        transition: all var(--t);
    }

    .preqs-card:hover { border-color: var(--gold-bd); transform: translateY(-3px); box-shadow: 0 14px 34px rgba(0,0,0,.08); }

    .preqs-card-top { display: flex; justify-content: space-between; gap: 8px; }

    .preqs-tag {
        font-size: .64rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
        padding: 4px 9px; border-radius: 999px; background: var(--gold-bg); border: 1px solid var(--gold-bd); color: var(--gold);
    }

    .preqs-ref { font-size: .68rem; color: var(--dim); font-weight: 600; }

    .preqs-title {
        font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 600; color: var(--text); line-height: 1.3;
    }

    .preqs-meta { font-size: .8rem; color: var(--muted); display: flex; flex-direction: column; gap: 5px; }
    .preqs-budget { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; font-weight: 600; color: var(--gold); }

    .preqs-actions { display: flex; gap: 8px; margin-top: 6px; }

    .preqs-btn {
        flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 9px 10px; border-radius: 8px; font-size: .78rem; font-weight: 600; transition: all var(--t);
    }

    .preqs-btn-wa { background: rgba(37,211,102,.1); color: #1a9c50; border: 1px solid rgba(37,211,102,.3); }
    .preqs-btn-wa:hover { background: rgba(37,211,102,.18); }
    .preqs-btn-call { background: var(--gold-bg); color: var(--gold); border: 1px solid var(--gold-bd); }
    .preqs-btn-call:hover { background: var(--gold); color: #fff; }
    .preqs-btn svg { width: 14px; height: 14px; }

    .preqs-empty { display: none; text-align: center; padding: 60px 20px; color: var(--muted); }
    .preqs-empty.show { display: block; }

    .preqs-loadmore-wrap { text-align: center; margin-top: 32px; }
    .preqs-loadmore-wrap.hide { display: none; }

    .preqs-load-more-btn {
        display: inline-flex; align-items: center; gap: 8px; padding: 12px 26px; border-radius: 10px;
        border: 1.5px solid var(--gold-bd); background: transparent; color: var(--gold);
        font-size: .85rem; font-weight: 600; cursor: pointer; transition: all var(--t);
    }
    .preqs-load-more-btn:hover { background: var(--gold); color: #fff; }
</style>

<section class="preqs-hero">
    <div class="container-xl">
        <h1 class="preqs-hero-title">Buyers &amp; renters <em>looking for a property</em></h1>
        <p class="preqs-hero-sub">Browse active requests from people searching for homes, plots and rentals across Rwanda. If one matches something you have, reach out directly by WhatsApp or phone.</p>
    </div>
</section>

<section class="preqs-filter-section">
    <div class="container-xl">
        <div class="preqs-tabs" id="preqsTabs">
            <button type="button" class="preqs-tab active" data-type="all">All</button>
            <button type="button" class="preqs-tab" data-type="buy">Buying</button>
            <button type="button" class="preqs-tab" data-type="rent">Renting</button>
        </div>

        <div class="preqs-filter-row" style="margin-bottom: 10px;">
            <div class="preqs-search-wrap">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" /><path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" id="preqsSearch" placeholder="Search by location or property type…" autocomplete="off">
            </div>
            <button type="button" class="preqs-clear-btn" id="preqsClear">Clear filters</button>
        </div>

        <div class="preqs-filter-row">
            <select id="preqsProvince">
                <option value="all">All Provinces</option>
                @foreach($provinces as $province)
                <option value="{{ strtolower($province) }}">{{ $province }}</option>
                @endforeach
            </select>

            <select id="preqsBudget">
                <option value="all">Any Budget</option>
                <option value="0-20000000">Under 20M RWF</option>
                <option value="20000000-50000000">20M – 50M RWF</option>
                <option value="50000000-100000000">50M – 100M RWF</option>
                <option value="100000000-999999999999">Above 100M RWF</option>
            </select>

            <select id="preqsSort">
                <option value="newest">Newest First</option>
                <option value="budget_low">Budget: Low to High</option>
                <option value="budget_high">Budget: High to Low</option>
            </select>
        </div>
    </div>
</section>

<section class="section" style="background: var(--bg);">
    <div class="container-xl">
        <div class="preqs-results-bar">
            <div class="preqs-results-count"><strong id="preqsCount">0</strong> requests found</div>
        </div>

        <div class="preqs-grid" id="preqsGrid">
            @forelse($requests as $req)
            <div class="preqs-card"
                 data-type="{{ $req->request_type }}"
                 data-province="{{ strtolower($req->preferred_province ?? '') }}"
                 data-budget="{{ $req->budget_max ?? $req->budget_min ?? 0 }}"
                 data-created="{{ $req->created_at->timestamp }}"
                 data-search="{{ strtolower(($req->property_type ?? '') . ' ' . $req->location_summary) }}">
                <div class="preqs-card-top">
                    <span class="preqs-tag">{{ ucfirst($req->request_type ?? 'Buy') }} · {{ ucfirst($req->property_type ?? 'Property') }}</span>
                    <span class="preqs-ref">{{ $req->reference_number }}</span>
                </div>
                <div class="preqs-title">{{ $req->display_name }} is looking for a {{ $req->property_type ?? 'property' }}</div>
                <div class="preqs-meta">
                    @if($req->location_summary)<span>📍 {{ $req->location_summary }}</span>@endif
                    @if($req->bedrooms_min)<span>🛏 {{ $req->bedrooms_min }}+ bedrooms</span>@endif
                    @if($req->timeline)<span>⏳ {{ $req->timeline }}</span>@endif
                </div>
                <div class="preqs-budget">{{ $req->formatted_budget }}</div>
                <div class="preqs-actions">
                    @if($req->whatsapp_number)
                    <a href="https://wa.me/{{ $req->whatsapp_number }}?text={{ urlencode('Hi ' . $req->display_name . ', I saw your property request ' . $req->reference_number . ' on Terra and I may have a match.') }}"
                       target="_blank" class="preqs-btn preqs-btn-wa">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z" /><path d="M11.999 2C6.477 2 2 6.477 2 12c0 1.89.52 3.659 1.428 5.18L2 22l4.975-1.395C8.43 21.51 10.17 22 11.999 22 17.522 22 22 17.523 22 12S17.522 2 11.999 2z" /></svg>
                        WhatsApp
                    </a>
                    @endif
                    @if($req->phone)
                    <a href="tel:+{{ $req->whatsapp_number ?? $req->phone }}" class="preqs-btn preqs-btn-call">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z" /></svg>
                        Call
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <p style="color: var(--muted); font-size: .85rem;">No active requests right now.</p>
            @endforelse
        </div>

        <div class="preqs-empty" id="preqsEmpty">
            <p>Nothing matches your filters. Try adjusting them.</p>
        </div>

        <div class="preqs-loadmore-wrap" id="preqsLoadMoreWrap">
            <button type="button" class="preqs-load-more-btn" id="preqsLoadMore">Load More</button>
        </div>
    </div>
</section>

<script>
(function() {
    const PAGE_SIZE = 9;
    const grid = document.getElementById('preqsGrid');
    const cards = Array.from(grid.querySelectorAll('.preqs-card'));
    const empty = document.getElementById('preqsEmpty');
    const countEl = document.getElementById('preqsCount');
    const loadMoreBtn = document.getElementById('preqsLoadMore');
    const loadMoreWrap = document.getElementById('preqsLoadMoreWrap');

    const tabs = document.querySelectorAll('#preqsTabs .preqs-tab');
    const searchInput = document.getElementById('preqsSearch');
    const provinceSel = document.getElementById('preqsProvince');
    const budgetSel = document.getElementById('preqsBudget');
    const sortSel = document.getElementById('preqsSort');
    const clearBtn = document.getElementById('preqsClear');

    let activeType = 'all';
    let visibleLimit = PAGE_SIZE;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            activeType = tab.dataset.type;
            visibleLimit = PAGE_SIZE;
            applyFilters();
        });
    });

    function applyFilters() {
        const q = searchInput.value.trim().toLowerCase();
        const province = provinceSel.value;
        const budgetRange = budgetSel.value;

        cards.forEach(card => {
            let visible = true;
            if (activeType !== 'all' && card.dataset.type !== activeType) visible = false;
            if (visible && province !== 'all' && card.dataset.province !== province) visible = false;
            if (visible && budgetRange !== 'all') {
                const [min, max] = budgetRange.split('-').map(Number);
                const budget = parseFloat(card.dataset.budget || '0');
                if (budget < min || budget > max) visible = false;
            }
            if (visible && q && !(card.dataset.search || '').includes(q)) visible = false;
            card.dataset.matched = visible ? '1' : '0';
        });

        renderPage();
    }

    function renderPage() {
        const sortBy = sortSel.value;
        const matched = cards.filter(c => c.dataset.matched === '1');

        matched.sort((a, b) => {
            if (sortBy === 'budget_low') return parseFloat(a.dataset.budget) - parseFloat(b.dataset.budget);
            if (sortBy === 'budget_high') return parseFloat(b.dataset.budget) - parseFloat(a.dataset.budget);
            return parseInt(b.dataset.created, 10) - parseInt(a.dataset.created, 10);
        });

        matched.forEach(card => grid.appendChild(card));
        cards.forEach(card => card.style.display = 'none');
        matched.slice(0, visibleLimit).forEach(card => card.style.display = '');

        countEl.textContent = matched.length;
        empty.classList.toggle('show', matched.length === 0);
        loadMoreWrap.classList.toggle('hide', matched.length <= visibleLimit);
    }

    loadMoreBtn.addEventListener('click', () => {
        visibleLimit += PAGE_SIZE;
        renderPage();
    });

    [searchInput, provinceSel, budgetSel, sortSel].forEach(el => {
        const evt = el.tagName === 'SELECT' ? 'change' : 'input';
        el.addEventListener(evt, () => { visibleLimit = PAGE_SIZE; applyFilters(); });
    });

    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        provinceSel.value = 'all';
        budgetSel.value = 'all';
        sortSel.value = 'newest';
        activeType = 'all';
        visibleLimit = PAGE_SIZE;
        tabs.forEach(t => t.classList.remove('active'));
        tabs[0].classList.add('active');
        applyFilters();
    });

    applyFilters();
})();
</script>

@endsection
