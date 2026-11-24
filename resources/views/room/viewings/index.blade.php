@extends('layouts.agents')
@section('title', 'Viewings')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Viewings</h1>
        <p>{{ $box === 'requested' ? 'Property visits you asked for.' : 'Clients who want to visit your properties. Confirm, decline or suggest another time.' }}</p>
    </div>
</div>

<div class="tp-toolbar">
    <nav class="tp-box-tabs" aria-label="Viewing box">
        @unless (auth()->user()->isClient() && !$counts['hosting'])
            <a href="{{ route('room.viewings.index', ['box' => 'hosting']) }}" class="{{ $box === 'hosting' ? 'is-active' : '' }}">On my listings <small>{{ $counts['hosting'] }}</small></a>
        @endunless
        <a href="{{ route('room.viewings.index', ['box' => 'requested']) }}" class="{{ $box === 'requested' ? 'is-active' : '' }}">My requests <small>{{ $counts['requested'] }}</small></a>
    </nav>
    <nav class="tp-box-tabs" aria-label="Filter by status">
        @foreach ([null => 'All', 'requested' => 'Awaiting', 'confirmed' => 'Confirmed', 'completed' => 'Done'] as $key => $label)
            <a href="{{ route('room.viewings.index', array_filter(['box' => $box, 'status' => $key ?: null])) }}" class="{{ request('status') == $key ? 'is-active' : '' }}">{{ $label }}</a>
        @endforeach
    </nav>
</div>

@if ($viewings->isEmpty())
    @include('room._empty', [
        'icon' => 'calendar',
        'title' => 'No viewings',
        'text' => $box === 'requested' ? 'Open a listing and choose “Book a viewing” to visit it.' : 'Viewing requests from clients will show up here.',
        'action' => $box === 'requested' ? ['Browse properties', route('front.properties.buy')] : null,
    ])
@else
    <div class="tp-cards">
        @foreach ($viewings as $v)
            @php $hosting = $box === 'hosting'; $person = $hosting ? $v->client : $v->host; $open = in_array($v->status, ['requested', 'confirmed'], true); @endphp
            <article class="tp-item {{ $hosting && $v->status === 'requested' ? 'is-new' : '' }}">
                <span class="tp-date"><b>{{ $v->scheduled_at->format('M') }}</b><strong>{{ $v->scheduled_at->format('j') }}</strong><span>{{ $v->scheduled_at->format('H:i') }}</span></span>
                <div style="min-width:0">
                    <h3 class="tp-item-title">
                        @if ($v->listable)<a href="{{ $v->listable->publicUrl() }}" target="_blank" rel="noopener">{{ $v->listable->title }}</a>@else Listing removed @endif
                    </h3>
                    <div class="tp-item-meta">
                        <span><x-tu-icon name="clock" /> {{ $v->scheduled_at->format('l j F Y, H:i') }}</span>
                        <span><x-tu-icon name="user" /> {{ $hosting ? 'Client' : 'Host' }}: {{ $person->name ?? 'Terra team' }}</span>
                        @if ($hosting && $person?->phone)<span><x-tu-icon name="phone" /> <a href="tel:{{ $person->phone }}">{{ $person->phone }}</a></span>@endif
                    </div>
                    @if ($v->note)<div class="tp-quote"><strong>Note:</strong> {{ $v->note }}</div>@endif
                    @if ($v->response_note)<div class="tp-quote"><strong>Reply:</strong> {{ $v->response_note }}</div>@endif
                </div>
                <div class="tp-item-actions">
                    @include('room._status', ['status' => $v->status])
                    @if ($hosting && $v->status === 'requested')
                        <form method="POST" action="{{ route('room.viewings.update', $v) }}">@csrf @method('PATCH')<input type="hidden" name="action" value="confirm"><button class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="check" /> Confirm</button></form>
                        <form method="POST" action="{{ route('room.viewings.update', $v) }}">@csrf @method('PATCH')<input type="hidden" name="action" value="decline"><button class="tu-btn tu-btn-sm">Decline</button></form>
                    @endif
                    @if ($hosting && $v->status === 'confirmed' && $v->scheduled_at->isPast())
                        <form method="POST" action="{{ route('room.viewings.update', $v) }}">@csrf @method('PATCH')<input type="hidden" name="action" value="complete"><button class="tu-btn tu-btn-primary tu-btn-sm">Mark done</button></form>
                    @endif
                    @if ($open)
                        <button type="button" class="tu-btn tu-btn-sm" data-modal-open="rescheduleModal" data-action="{{ route('room.viewings.update', $v) }}"
                            data-field-date="{{ $v->scheduled_at->format('Y-m-d') }}" data-field-time="{{ $v->scheduled_at->format('H:i') }}">Reschedule</button>
                        <form method="POST" action="{{ route('room.viewings.update', $v) }}" onsubmit="return confirm('Cancel this viewing?')">@csrf @method('PATCH')<input type="hidden" name="action" value="cancel"><button class="tu-btn tu-btn-sm tu-btn-ghost">Cancel</button></form>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
    <div class="mt-3">{{ $viewings->links() }}</div>
@endif

<div class="tu-modal" id="rescheduleModal" role="dialog" aria-modal="true" aria-labelledby="rescheduleTitle">
    <div class="tu-modal-box">
        <div class="tu-modal-head">
            <div><h3 id="rescheduleTitle">Suggest another time</h3><p>The other person will be asked to confirm again.</p></div>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
        </div>
        <form method="POST" action="#" class="tu-modal-body tu-stack" style="gap:14px">
            @csrf @method('PATCH')
            <input type="hidden" name="action" value="reschedule">
            <div class="tu-form-grid">
                <div class="tu-field"><label for="rsDate">Date</label><input id="rsDate" class="tu-input" type="date" name="date" min="{{ now()->format('Y-m-d') }}" required></div>
                <div class="tu-field"><label for="rsTime">Time</label><input id="rsTime" class="tu-input" type="time" name="time" step="900" required></div>
            </div>
            <div class="tu-field"><label for="rsNote">Note <span class="tu-hint">(optional)</span></label><textarea id="rsNote" name="response_note" maxlength="500" rows="3"></textarea></div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-block">Send new time</button>
        </form>
    </div>
</div>
@endsection
