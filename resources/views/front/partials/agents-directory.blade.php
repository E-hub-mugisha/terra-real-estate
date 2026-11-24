{{-- Agents directory. Expects $agents, $title, $subtitle; optional $searchValue --}}
<section class="tu-page-hero">
    <div class="tu-container">
        <ol class="tu-crumbs">
            <li><a href="{{ route('front.home') }}">Home</a></li>
            <li>Agents</li>
        </ol>
        <div class="tu-eyebrow" style="color:#D05208">Verified agents</div>
        <h1 class="tu-h1">{{ $title }}</h1>
        <p>{{ $subtitle }}</p>
        <form method="GET" action="{{ route('front.agents') }}" class="tu-search" style="margin-top:26px;max-width:640px">
            <div class="tu-search-field">
                <label for="agentQ">Name or area</label>
                <input id="agentQ" type="search" name="q" value="{{ $searchValue ?? '' }}" placeholder="e.g. Kacyiru, Musanze, Marie…">
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg"><x-tu-icon name="search" /> Find agents</button>
        </form>
    </div>
</section>

<section class="tu-container" style="padding:36px 20px 72px">
    <div class="tu-result-bar" style="margin-top:0">
        <span><strong>{{ $agents->count() }}</strong> {{ \Illuminate\Support\Str::plural('agent', $agents->count()) }}</span>
        @if (!empty($searchValue))
            <a href="{{ route('front.agents') }}" class="tu-btn tu-btn-sm tu-btn-ghost">Clear search</a>
        @endif
    </div>

    @if ($agents->isEmpty())
        <div class="tu-empty">
            <div class="tu-empty-ico"><x-tu-icon name="users" /></div>
            <h3>No agents found</h3>
            <p>Try another area or name — or message us and we'll connect you with someone nearby.</p>
            <a href="https://wa.me/{{ \App\Support\Listing::WHATSAPP }}" target="_blank" rel="noopener" class="tu-btn tu-btn-wa"><x-tu-icon name="whatsapp" /> Ask Terra</a>
        </div>
    @else
        <div class="tu-grid">
            @foreach ($agents as $agent)
                @include('front.partials.agent-card', ['agent' => $agent])
            @endforeach
        </div>
    @endif

    <div class="tu-cta" style="margin-top:56px">
        <div>
            <h2 class="tu-h2">Are you a real estate agent?</h2>
            <p>Join Terra to list houses, land and designs and get inquiries straight to your phone.</p>
        </div>
        <div class="tu-cta-actions">
            <a href="{{ route('front.agents.register') }}" class="tu-btn tu-btn-primary tu-btn-lg"><x-tu-icon name="plus" /> Become an agent</a>
        </div>
    </div>
</section>
