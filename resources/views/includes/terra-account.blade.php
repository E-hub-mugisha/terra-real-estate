{{-- Signed-in context for terra-ui.js (saved hearts sync with the account). --}}
@auth
    @php
        $savedIds = auth()->user()->savedListings()->get(['listable_type', 'listable_id'])
            ->map(fn ($s) => array_search($s->listable_type, \App\Support\ListingRef::TYPES, true) . '-' . $s->listable_id)
            ->values();
    @endphp
    <script>
        window.TerraAccount = {
            user: @json(auth()->id()),
            csrf: @json(csrf_token()),
            toggle: @json(route('room.saved.toggle')),
            sync: @json(route('room.saved.sync')),
            ids: @json($savedIds),
        };
    </script>
@endauth
