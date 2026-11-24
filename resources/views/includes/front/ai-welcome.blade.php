<div class="tu-ai-welcome" data-tu-ai-welcome>
    <h3>{{ __('What are you looking for?') }}</h3>
    <p>{{ __('Search houses, land and designs the way you would ask a friend: area, budget, bedrooms, rent or buy.') }}</p>
    <div class="tu-ai-suggest">
        @foreach ($suggestions as $s)
            <button type="button" class="tu-chip" data-tu-ai-suggest>{{ $s }}</button>
        @endforeach
    </div>
</div>
