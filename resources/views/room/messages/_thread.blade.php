{{-- Message bubbles. Expects $messages, $me --}}
@php $lastDay = null; @endphp
@forelse ($messages as $m)
    @php $day = $m->created_at->isToday() ? 'Today' : ($m->created_at->isYesterday() ? 'Yesterday' : $m->created_at->format('D j M Y')); @endphp
    @if ($day !== $lastDay)
        <div class="tp-msg-day">{{ $day }}</div>
        @php $lastDay = $day; @endphp
    @endif
    <div class="tp-msg {{ $m->user_id === $me->id ? 'is-me' : '' }}" data-msg-id="{{ $m->id }}">{{ $m->body }}<time datetime="{{ $m->created_at->toIso8601String() }}">{{ $m->created_at->format('H:i') }}</time></div>
@empty
    <div class="tp-msg-day">Say hello 👋</div>
@endforelse
