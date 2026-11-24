@extends('layouts.agents')
@section('title', 'Saved properties')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Saved properties</h1>
        <p>Everything you hearted, on any device you sign in with.</p>
    </div>
    <a href="{{ route('front.properties.buy') }}" class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="search" /> Find more</a>
</div>

@if ($items->isEmpty())
    @include('room._empty', ['icon' => 'heart', 'title' => 'No saved properties', 'text' => 'Tap the heart on any house, plot or design to keep it here and compare later.', 'action' => ['Browse properties', route('front.properties.buy')]])
@else
    <div class="tu-grid" id="savedGrid">
        @foreach ($items as $item)
            @include('front.partials.card', ['item' => $item])
        @endforeach
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Unsaving here removes the card once the account confirms it.
    document.addEventListener('terra:saved', (e) => {
        document.querySelectorAll('#savedGrid .tu-card').forEach(card => {
            const btn = card.querySelector('[data-save-id]');
            if (btn && !e.detail.has(btn.dataset.saveId)) card.remove();
        });
    });
</script>
@endpush
