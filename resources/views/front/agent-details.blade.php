@extends('layouts.guest')
@section('title', $agent->full_name . ' · Agent')

@section('content')
@php
    $listings = \App\Support\Listing::collect($houses, $lands, $designs);
    $initials = collect(explode(' ', $agent->full_name ?? 'A'))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
    $phone = $agent->whatsapp ?: $agent->phone;
    $waNumber = $phone ? preg_replace('/\D+/', '', $phone) : \App\Support\Listing::WHATSAPP;
    $waText = rawurlencode("Hi {$agent->full_name}, I found your profile on Terra and I'd like to ask about your properties.");
    $socials = array_filter(['linkedin' => $agent->linkedin, 'facebook' => $agent->facebook, 'instagram' => $agent->instagram, 'twitter' => $agent->twitter]);
@endphp

<section class="tu-page-hero" style="padding-bottom:40px">
    <div class="tu-container">
        <ol class="tu-crumbs">
            <li><a href="{{ route('front.home') }}">Home</a></li>
            <li><a href="{{ route('front.agents') }}">Agents</a></li>
            <li>{{ $agent->full_name }}</li>
        </ol>
        <div class="tu-profile-head">
            <div class="tu-agent-photo">
                @if ($agent->profile_image)
                    <img src="{{ asset('image/agents/' . $agent->profile_image) }}" alt="{{ $agent->full_name }}" onerror="this.outerHTML='<span class=&quot;tu-avatar&quot;>{{ strtoupper($initials) }}</span>'">
                @else
                    <span class="tu-avatar">{{ strtoupper($initials) }}</span>
                @endif
                @if ($agent->is_verified)
                    <span class="tu-verified" title="Verified agent"><x-tu-icon name="check" /></span>
                @endif
            </div>
            <div style="flex:1;min-width:240px">
                @if ($agent->is_verified)<span class="tu-badge" style="background:rgba(255, 255, 255,.12);color:#FFFFFF"><x-tu-icon name="shield" size="12" /> Verified Terra agent</span>@endif
                <h1 class="tu-h1" style="margin-top:10px">{{ $agent->full_name }}</h1>
                <p style="display:flex;align-items:center;gap:8px;margin-top:8px"><x-tu-icon name="pin" size="16" /> {{ $agent->office_location ?: collect([$agent->district, $agent->province])->filter()->implode(', ') ?: 'Rwanda' }}</p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" rel="noopener" class="tu-btn tu-btn-wa tu-btn-lg"><x-tu-icon name="whatsapp" /> WhatsApp</a>
                @if ($agent->phone)<a href="tel:{{ $agent->phone }}" class="tu-btn tu-btn-light tu-btn-lg"><x-tu-icon name="phone" /> Call</a>@endif
            </div>
        </div>
    </div>
</section>

<section class="tu-container tu-detail">
    <div class="tu-detail-grid">
        <div>
            <div class="tu-tabs" role="tablist">
                <button type="button" class="tu-tab is-active" data-tab="listings">Listings ({{ $listings->count() }})</button>
                <button type="button" class="tu-tab" data-tab="about">About</button>
            </div>

            <div class="tu-tab-pane is-active" id="tab-listings">
                @if ($listings->isEmpty())
                    <div class="tu-empty">
                        <div class="tu-empty-ico"><x-tu-icon name="home" /></div>
                        <h3>No active listings right now</h3>
                        <p>{{ $agent->full_name }} can still help you find a property — send a message.</p>
                    </div>
                @else
                    <div class="tu-grid" style="grid-template-columns:repeat(auto-fill,minmax(250px,1fr))">
                        @foreach ($listings as $item)
                            @include('front.partials.card', ['item' => $item])
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="tu-tab-pane" id="tab-about">
                <div class="tu-panel">
                    <h2 class="tu-panel-title">About {{ \Illuminate\Support\Str::before($agent->full_name, ' ') ?: $agent->full_name }}</h2>
                    <p class="tu-prose" style="margin:0">{{ $agent->bio ?: 'This agent has not added a biography yet.' }}</p>
                    @if ($agent->languages)
                        <h3 class="tu-h3" style="font-size:.9rem;margin:22px 0 10px">Languages</h3>
                        <div class="tu-amenities">
                            @foreach (array_filter(array_map('trim', preg_split('/[,\/]/', $agent->languages))) as $lang)
                                <span class="tu-amenity"><x-tu-icon name="globe" /> {{ $lang }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <aside class="tu-sticky">
            <div class="tu-panel">
                <h2 class="tu-panel-title">Contact details</h2>
                <dl class="tu-kv" style="grid-template-columns:1fr">
                    @if ($agent->phone)<div><dt>Phone</dt><dd><a href="tel:{{ $agent->phone }}" style="text-decoration:none">{{ $agent->phone }}</a></dd></div>@endif
                    @if ($agent->whatsapp)<div><dt>WhatsApp</dt><dd>{{ $agent->whatsapp }}</dd></div>@endif
                    @if ($agent->email)<div><dt>Email</dt><dd><a href="mailto:{{ $agent->email }}" style="text-decoration:none">{{ $agent->email }}</a></dd></div>@endif
                    <div><dt>Listings</dt><dd>{{ $listings->count() }}</dd></div>
                    <div><dt>On Terra since</dt><dd>{{ optional($agent->created_at)->format('M Y') }}</dd></div>
                </dl>
                <div class="tu-stack" style="margin-top:18px">
                    <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" rel="noopener" class="tu-btn tu-btn-wa tu-btn-block"><x-tu-icon name="whatsapp" /> Message on WhatsApp</a>
                    @if ($agent->email)<a href="mailto:{{ $agent->email }}" class="tu-btn tu-btn-block"><x-tu-icon name="mail" /> Send an email</a>@endif
                </div>
                @if ($socials)
                    <div style="display:flex;gap:8px;margin-top:18px">
                        @foreach ($socials as $network => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" class="tu-btn tu-btn-icon tu-btn-sm" aria-label="{{ ucfirst($network) }}"><x-tu-icon :name="$network" /></a>
                        @endforeach
                    </div>
                @endif
            </div>
        </aside>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.tu-tab').forEach(tab => tab.addEventListener('click', () => {
        document.querySelectorAll('.tu-tab').forEach(t => t.classList.toggle('is-active', t === tab));
        document.querySelectorAll('.tu-tab-pane').forEach(p => p.classList.toggle('is-active', p.id === 'tab-' + tab.dataset.tab));
    }));
</script>
@endpush
