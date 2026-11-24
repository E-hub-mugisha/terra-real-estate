{{--
    Contact sidebar + inquiry / message / viewing / offer modals.
    Expects: $agent (App\Models\Agent|null), $title, $wa (fallback WhatsApp link), $inquiryRoute,
             $idField / $idValue (hidden listing id); optional $listing (model), $extra (HTML above the buttons), $saveId
--}}
@php
    $listing = $listing ?? null;
    $type = $listing ? \App\Support\ListingRef::type($listing) : null;
    $me = auth()->user();
    // Owners list directly: when there is no agent, the owner (or submitter) is the contact.
    $contact = $listing?->contactUser();
    $ownerDirect = !$agent && $contact && !$contact->isStaff();
    $isMine = $me && $listing && $listing->isManagedBy($me) && !$me->isStaff();
    $agentPhone = $agent?->whatsapp ?: $agent?->phone ?: ($ownerDirect ? ($contact->whatsapp ?: $contact->phone) : null);
    $waLink = $agentPhone
        ? 'https://wa.me/' . preg_replace('/\D+/', '', $agentPhone) . '?text=' . rawurlencode("Hi, I'm interested in \"{$title}\" on Terra (" . url()->current() . ').')
        : $wa;
    $initials = $agent ? collect(explode(' ', (string) $agent->full_name))->map(fn ($p) => mb_substr($p, 0, 1))->take(2)->implode('') : 'T';
    $loginUrl = route('login') . '?redirect=' . rawurlencode(url()->current());
    $price = (float) ($listing->price ?? 0);
    $documents = $listing ? $listing->documents()->where('is_public', true)->where('status', 'verified')->get() : collect();
@endphp
<div class="tu-panel">
    @if ($agent)
        <a href="{{ route('front.agent.details', $agent) }}" class="tu-contact-person" style="text-decoration:none">
            @if ($agent->profile_image)
                <img src="{{ asset('image/agents/' . $agent->profile_image) }}" alt="{{ $agent->full_name }}" onerror="this.outerHTML='<span class=&quot;tu-avatar&quot;>{{ strtoupper($initials) }}</span>'">
            @else
                <span class="tu-avatar">{{ strtoupper($initials) }}</span>
            @endif
            <span>
                <strong>{{ $agent->full_name }} @if ($agent->is_verified)<x-tu-icon name="badge" size="15" style="color:var(--tu-info);vertical-align:-2px" />@endif</strong>
                <span>Listing agent · view profile</span>
            </span>
        </a>
    @elseif ($ownerDirect)
        <div class="tu-contact-person">
            <span class="tu-avatar">{{ strtoupper(mb_substr($contact->name, 0, 1)) }}</span>
            <span><strong>{{ $contact->name }}</strong><span>{{ $contact->isPartner() ? 'Terra partner' : 'Property owner · deal directly' }}</span></span>
        </div>
    @else
        <div class="tu-contact-person">
            <span class="tu-avatar" style="background:var(--tu-brand)">T</span>
            <span><strong>Terra Real Estate</strong><span>Listed by the Terra team</span></span>
        </div>
    @endif

    {!! $extra ?? '' !!}

    @if ($isMine)
        <div class="tu-alert" style="margin-bottom:12px;font-size:.86rem">This is your listing. <a href="{{ route('room.listings.index') }}">Manage it</a></div>
    @endif

    <div class="tu-stack">
        @if ($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="tu-btn tu-btn-wa tu-btn-lg tu-btn-block"><x-tu-icon name="whatsapp" /> Chat on WhatsApp</a>
        @endif
        @if ($listing && !$isMine && $contact)
            @if ($me)
                <button type="button" class="tu-btn tu-btn-dark tu-btn-lg tu-btn-block" data-modal-open="tuMessage"><x-tu-icon name="mail" /> Message {{ $agent ? 'agent' : 'owner' }}</button>
            @else
                <a href="{{ $loginUrl }}" class="tu-btn tu-btn-dark tu-btn-lg tu-btn-block"><x-tu-icon name="mail" /> Message {{ $agent ? 'agent' : 'owner' }}</a>
            @endif
        @endif
        @if ($listing && $type !== 'design' && !$isMine)
            <div class="tu-actions-grid">
                @if ($me)
                    <button type="button" class="tu-btn" data-modal-open="tuViewing"><x-tu-icon name="calendar" /> Book a viewing</button>
                    <button type="button" class="tu-btn" data-modal-open="tuOffer"><x-tu-icon name="tag" /> Make an offer</button>
                @else
                    <a href="{{ $loginUrl }}" class="tu-btn"><x-tu-icon name="calendar" /> Book a viewing</a>
                    <a href="{{ $loginUrl }}" class="tu-btn"><x-tu-icon name="tag" /> Make an offer</a>
                @endif
            </div>
        @endif
        <button type="button" class="tu-btn tu-btn-block" data-open-inquiry><x-tu-icon name="list" /> Send an inquiry</button>
        @isset($saveId)
            <button type="button" class="tu-btn tu-btn-block tu-save-btn" data-save-id="{{ $saveId }}" data-save-title="{{ $title }}" aria-pressed="false">
                <x-tu-icon name="heart" /> <span class="tu-save-off">Save listing</span><span class="tu-save-on">Saved</span>
            </button>
        @endisset
        @if ($agent?->phone)
            <a href="tel:{{ $agent->phone }}" class="tu-btn tu-btn-block"><x-tu-icon name="phone" /> {{ $agent->phone }}</a>
        @elseif ($ownerDirect && $contact->phone)
            <a href="tel:{{ $contact->phone }}" class="tu-btn tu-btn-block"><x-tu-icon name="phone" /> {{ $contact->phone }}</a>
        @else
            <a href="tel:+{{ \App\Support\Listing::WHATSAPP }}" class="tu-btn tu-btn-block"><x-tu-icon name="phone" /> +250 796 511 725</a>
        @endif
    </div>
    @guest
        <p class="tu-hint" style="margin:14px 0 0;text-align:center"><a href="{{ $loginUrl }}">Sign in</a> or <a href="{{ route('register') }}">create a free account</a> to message, book viewings and make offers.</p>
    @else
        <p class="tu-hint" style="margin:14px 0 0;text-align:center">Mention Terra when you get in touch.</p>
    @endguest
</div>

@if ($documents->isNotEmpty())
    <div class="tu-panel">
        <h2 class="tu-panel-title" style="font-size:.95rem"><x-tu-icon name="shield" size="16" /> Verified documents</h2>
        <ul style="list-style:none;padding:0;margin:0;display:grid;gap:8px">
            @foreach ($documents as $doc)
                <li><a href="{{ route('room.documents.download', $doc) }}" class="tu-btn tu-btn-sm tu-btn-block" style="justify-content:flex-start"><x-tu-icon name="download" /> {{ $doc->title }} <small style="margin-left:auto;color:var(--tu-muted)">{{ $doc->typeLabel() }}</small></a></li>
            @endforeach
        </ul>
        @guest<p class="tu-hint" style="margin:10px 0 0">Sign in to download.</p>@endguest
    </div>
@endif

{{-- Inquiry (anyone) --}}
<div class="tu-modal" id="tuInquiry" role="dialog" aria-modal="true" aria-labelledby="tuInquiryTitle">
    <div class="tu-modal-box">
        <div class="tu-modal-head">
            <div>
                <h3 id="tuInquiryTitle">Ask about this listing</h3>
                <p>{{ $title }}</p>
            </div>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-close-inquiry aria-label="Close"><x-tu-icon name="x" /></button>
        </div>
        <form method="POST" action="{{ $inquiryRoute }}" class="tu-modal-body tu-stack" style="gap:14px">
            @csrf
            <input type="hidden" name="{{ $idField }}" value="{{ $idValue }}">
            <div class="tu-field">
                <label for="inqName">Full name</label>
                <input id="inqName" class="tu-input" type="text" name="name" value="{{ old('name', $me->name ?? '') }}" required autocomplete="name">
            </div>
            <div class="tu-form-grid">
                <div class="tu-field">
                    <label for="inqEmail">Email</label>
                    <input id="inqEmail" class="tu-input" type="email" name="email" value="{{ old('email', $me->email ?? '') }}" required autocomplete="email">
                </div>
                <div class="tu-field">
                    <label for="inqPhone">Phone <span class="tu-hint">(optional)</span></label>
                    <input id="inqPhone" class="tu-input" type="tel" name="phone" value="{{ old('phone', $me->phone ?? '') }}" placeholder="+250 7XX XXX XXX" autocomplete="tel">
                </div>
            </div>
            <div class="tu-field">
                <label for="inqMsg">Message</label>
                <textarea id="inqMsg" name="message" required maxlength="2000">{{ old('message', "Hi, I'm interested in \"{$title}\". Please share more details.") }}</textarea>
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Send inquiry</button>
        </form>
    </div>
</div>

@if ($listing && $me && !$isMine)
    {{-- Direct message --}}
    <div class="tu-modal" id="tuMessage" role="dialog" aria-modal="true" aria-labelledby="tuMessageTitle" @if ($errors->has('body')) data-autoopen @endif>
        <div class="tu-modal-box">
            <div class="tu-modal-head">
                <div><h3 id="tuMessageTitle">Message {{ $agent->full_name ?? $contact?->name ?? 'Terra' }}</h3><p>Starts a private conversation in your Messages.</p></div>
                <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
            </div>
            <form method="POST" action="{{ route('listing.message', [$type, $listing->id]) }}" class="tu-modal-body tu-stack" style="gap:14px">
                @csrf
                <div class="tu-field">
                    <label for="dmBody">Message</label>
                    <textarea id="dmBody" name="body" required maxlength="3000" rows="5">{{ old('body', "Hello, is \"{$title}\" still available?") }}</textarea>
                    @error('body')<div class="tu-field-error">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Send message</button>
            </form>
        </div>
    </div>

    @if ($type !== 'design')
        {{-- Viewing request --}}
        <div class="tu-modal" id="tuViewing" role="dialog" aria-modal="true" aria-labelledby="tuViewingTitle" @if ($errors->hasAny(['date', 'time'])) data-autoopen @endif>
            <div class="tu-modal-box">
                <div class="tu-modal-head">
                    <div><h3 id="tuViewingTitle">Book a viewing</h3><p>Pick a time. The {{ $agent ? 'agent' : 'owner' }} confirms or suggests another.</p></div>
                    <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
                </div>
                <form method="POST" action="{{ route('listing.viewing', [$type, $listing->id]) }}" class="tu-modal-body tu-stack" style="gap:14px">
                    @csrf
                    <div class="tu-form-grid">
                        <div class="tu-field">
                            <label for="vDate">Date</label>
                            <input id="vDate" class="tu-input" type="date" name="date" min="{{ now()->format('Y-m-d') }}" value="{{ old('date', now()->addDay()->format('Y-m-d')) }}" required>
                            @error('date')<div class="tu-field-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="tu-field">
                            <label for="vTime">Time</label>
                            <input id="vTime" class="tu-input" type="time" name="time" step="900" value="{{ old('time', '10:00') }}" required>
                            @error('time')<div class="tu-field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="tu-field">
                        <label for="vNote">Note <span class="tu-hint">(optional)</span></label>
                        <textarea id="vNote" name="note" maxlength="500" rows="3" placeholder="e.g. I'll come with my partner">{{ old('note') }}</textarea>
                    </div>
                    <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Request viewing</button>
                </form>
            </div>
        </div>

        {{-- Offer --}}
        <div class="tu-modal" id="tuOffer" role="dialog" aria-modal="true" aria-labelledby="tuOfferTitle" @if ($errors->has('amount')) data-autoopen @endif>
            <div class="tu-modal-box">
                <div class="tu-modal-head">
                    <div><h3 id="tuOfferTitle">Make an offer</h3><p>@if ($price > 0)Asking price: {{ number_format($price) }} {{ $listing->currency ?: 'RWF' }}@else Price on request @endif</p></div>
                    <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
                </div>
                <form method="POST" action="{{ route('listing.offer', [$type, $listing->id]) }}" class="tu-modal-body tu-stack" style="gap:14px">
                    @csrf
                    <div class="tu-field">
                        <label for="oAmount">Your offer ({{ $listing->currency ?: 'RWF' }}{{ ($listing->condition ?? '') === 'for_rent' ? ' / month' : '' }})</label>
                        <input id="oAmount" class="tu-input" type="number" name="amount" min="1" step="1" value="{{ old('amount', $price > 0 ? (int) $price : '') }}" required>
                        @error('amount')<div class="tu-field-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="tu-field">
                        <label for="oMsg">Message <span class="tu-hint">(optional)</span></label>
                        <textarea id="oMsg" name="message" maxlength="1000" rows="3" placeholder="Payment plan, move-in date…">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Send offer</button>
                </form>
            </div>
        </div>
    @endif
@endif

@push('scripts')
<script>
    (function () {
        const modal = document.getElementById('tuInquiry');
        const open = () => { modal.classList.add('is-open'); document.body.style.overflow = 'hidden'; setTimeout(() => modal.querySelector('input:not([type=hidden])').focus(), 50); };
        const close = () => { modal.classList.remove('is-open'); document.body.style.overflow = ''; };
        document.querySelectorAll('[data-open-inquiry]').forEach(b => b.addEventListener('click', open));
        modal.querySelector('[data-close-inquiry]').addEventListener('click', close);
        modal.addEventListener('click', (e) => { if (e.target === modal) close(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && modal.classList.contains('is-open')) close(); });
        @if ($errors->hasAny(['name', 'email', 'message', 'phone'])) open(); @endif
    })();
</script>
@endpush
