@extends('layouts.app')
@section('title', 'Approval queue')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Listing approval queue</h1>
        <p>Check each property before it goes live. Rejected listings show your reason to the owner.</p>
    </div>
</div>

<div class="tp-toolbar">
    @include('admin.marketplace._tabs', ['param' => 'state', 'current' => $state, 'options' => ['pending' => 'Pending', 'rejected' => 'Rejected', 'live' => 'Live'], 'counts' => ['pending' => $counts['pending']]])
    @include('admin.marketplace._tabs', ['param' => 'type', 'current' => $type ?? '', 'options' => ['' => 'All types', 'house' => 'Houses', 'land' => 'Land', 'design' => 'Designs']])
</div>

@if ($listings->isEmpty())
    @include('room._empty', ['icon' => 'shield', 'title' => $state === 'pending' ? 'All caught up' : 'Nothing here', 'text' => $state === 'pending' ? 'No listings are waiting for review.' : 'No listings match this filter.'])
@else
    <div class="tp-cards">
        @foreach ($listings as $l)
            @php $t = \App\Support\ListingRef::type($l); $submitter = $l->ownerUser ?? $l->partner; @endphp
            <article class="tp-item">
                <div class="tp-item-media"><img src="{{ $l->thumbUrl() }}" alt="" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('front/assets/img/all-images/properties/property-img1.png') }}'"></div>
                <div style="min-width:0">
                    <h3 class="tp-item-title"><a href="{{ \App\Support\ListingRef::adminUrl($l) }}">{{ $l->title }}</a></h3>
                    <div class="tp-item-meta">
                        <span class="tu-badge tu-badge-{{ $t }}">{{ \App\Support\ListingRef::label($l) }}</span>
                        <span>{{ ($t === 'design' && $l->is_free) ? 'Free' : number_format((float) $l->price) . ' ' . ($l->currency ?: 'RWF') }}</span>
                        @if ($t !== 'design')<span><x-tu-icon name="pin" /> {{ collect([$l->sector, $l->district, $l->province])->filter()->implode(', ') ?: '—' }}</span>@endif
                        <span><x-tu-icon name="user" /> {{ $submitter ? $submitter->name . ' (' . $submitter->roleLabel() . ')' : ($l->agent_id ? 'Agent' : 'Terra') }}</span>
                        <span><x-tu-icon name="file" /> {{ $l->documents_count }} docs</span>
                        <span><x-tu-icon name="clock" /> {{ $l->created_at->diffForHumans() }}</span>
                    </div>
                    @if ($l->rejection_reason)<div class="tp-quote" style="color:var(--tu-danger)"><strong>Rejected:</strong> {{ $l->rejection_reason }}</div>@endif
                </div>
                <div class="tp-item-actions">
                    <a href="{{ \App\Support\ListingRef::adminUrl($l) }}" class="tu-btn tu-btn-sm"><x-tu-icon name="eye" /> Review</a>
                    @unless ($l->isApproved())
                        <form method="POST" action="{{ route('admin.marketplace.decide', [$t, $l->id]) }}">
                            @csrf @method('PATCH')<input type="hidden" name="decision" value="approve">
                            <button class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="check" /> Approve</button>
                        </form>
                    @endunless
                    @if ($state !== 'rejected')
                        <button type="button" class="tu-btn tu-btn-sm" data-modal-open="rejectModal" data-action="{{ route('admin.marketplace.decide', [$t, $l->id]) }}" data-title="Reject “{{ \Illuminate\Support\Str::limit($l->title, 40) }}”">{{ $l->isApproved() ? 'Unpublish' : 'Reject' }}</button>
                    @endif
                    @if ($l->isApproved() && $t !== 'design')
                        <button type="button" class="tu-btn tu-btn-sm tu-btn-dark" data-modal-open="dealModal" data-action="{{ route('admin.marketplace.deal', [$t, $l->id]) }}" data-field-value="{{ (int) $l->price }}" data-title="Record a deal: {{ \Illuminate\Support\Str::limit($l->title, 36) }}">Record deal</button>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
@endif

<div class="tu-modal" id="rejectModal" role="dialog" aria-modal="true" aria-labelledby="rejectTitle">
    <div class="tu-modal-box">
        <div class="tu-modal-head">
            <div><h3 id="rejectTitle" data-modal-title>Reject listing</h3><p>The owner sees this reason in their room and can fix the listing.</p></div>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
        </div>
        <form method="POST" action="#" class="tu-modal-body tu-stack" style="gap:14px">
            @csrf @method('PATCH')
            <input type="hidden" name="decision" value="reject">
            <div class="tu-field"><label for="rjReason">Reason</label><textarea id="rjReason" name="reason" required maxlength="500" rows="4" placeholder="e.g. Photos are blurry; please add the UPI number."></textarea></div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-block">Reject listing</button>
        </form>
    </div>
</div>

@include('admin.marketplace._deal-modal')
@endsection
