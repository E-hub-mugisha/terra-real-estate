@extends('layouts.agents')
@section('title', 'Assigned listings')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Assigned listings</h1>
        <p>Properties the Terra team asked you to help promote and find clients for.</p>
    </div>
</div>

@if ($assignments->isEmpty())
    @include('room._empty', ['icon' => 'briefcase', 'title' => 'Nothing assigned yet', 'text' => 'When Terra assigns a listing to you, it appears here with any notes from the team.'])
@else
    <div class="tp-cards">
        @foreach ($assignments as $a)
            @php $l = $a->listable; @endphp
            <article class="tp-item">
                <div class="tp-item-media"><img src="{{ $l->thumbUrl() }}" alt="" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('front/assets/img/all-images/properties/property-img1.png') }}'"></div>
                <div style="min-width:0">
                    <h3 class="tp-item-title"><a href="{{ $l->publicUrl() }}" target="_blank" rel="noopener">{{ $l->title }}</a></h3>
                    <div class="tp-item-meta">
                        <span class="tu-badge tu-badge-{{ \App\Support\ListingRef::type($l) }}">{{ \App\Support\ListingRef::label($l) }}</span>
                        <span>{{ ($l->is_free ?? false) ? 'Free' : number_format((float) $l->price) . ' ' . ($l->currency ?: 'RWF') }}</span>
                        <span><x-tu-icon name="clock" /> Assigned {{ $a->created_at->diffForHumans() }}{{ $a->assigner ? ' by ' . $a->assigner->name : '' }}</span>
                    </div>
                    @if ($a->note)<div class="tp-quote">{{ $a->note }}</div>@endif
                </div>
                <div class="tp-item-actions">
                    @include('room._status', ['status' => $l->reviewState()])
                    <a href="{{ $l->publicUrl() }}" target="_blank" rel="noopener" class="tu-btn tu-btn-sm"><x-tu-icon name="external" /> Open</a>
                    <a href="https://wa.me/?text={{ rawurlencode($l->title . ' on Terra: ' . $l->publicUrl()) }}" target="_blank" rel="noopener" class="tu-btn tu-btn-wa tu-btn-sm"><x-tu-icon name="whatsapp" /> Share</a>
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
