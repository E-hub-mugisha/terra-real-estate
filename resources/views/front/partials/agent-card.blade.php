{{-- Agent card. Expects $agent (App\Models\Agent, ideally with user + listing counts loaded) --}}
@php
    $listings = ($agent->user->houses_count ?? 0) + ($agent->user->lands_count ?? 0) + ($agent->user->architectural_designs_count ?? 0);
    $initials = collect(explode(' ', $agent->full_name ?? 'A'))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('');
@endphp
<a href="{{ route('front.agent.details', $agent) }}" class="tu-agent-card">
    <div class="tu-agent-photo">
        @if ($agent->profile_image)
            <img src="{{ asset('image/agents/' . $agent->profile_image) }}" alt="{{ $agent->full_name }}" loading="lazy"
                onerror="this.replaceWith(Object.assign(document.createElement('span'),{className:'tu-avatar',textContent:'{{ strtoupper($initials) }}'}))">
        @else
            <span class="tu-avatar">{{ strtoupper($initials) }}</span>
        @endif
        @if ($agent->is_verified)
            <span class="tu-verified" title="Verified agent"><x-tu-icon name="check" /></span>
        @endif
    </div>
    <div class="tu-agent-name">{{ $agent->full_name }}</div>
    <div class="tu-agent-loc">{{ $agent->office_location ?: collect([$agent->district, $agent->province])->filter()->implode(', ') ?: 'Rwanda' }}</div>
    <div class="tu-agent-stats">
        <div><strong>{{ $listings }}</strong><span>Listings</span></div>
        <div><strong>{{ $agent->languages ? count(array_filter(array_map('trim', preg_split('/[,\/]/', $agent->languages)))) : '—' }}</strong><span>Languages</span></div>
    </div>
</a>
