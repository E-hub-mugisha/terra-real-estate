{{-- "Add referral" modal (agents & partners) --}}
<div class="tu-modal" id="referralModal" role="dialog" aria-modal="true" aria-labelledby="referralTitle" @if ($errors->hasAny(['name', 'phone', 'email', 'type'])) data-autoopen @endif>
    <div class="tu-modal-box">
        <div class="tu-modal-head">
            <div><h3 id="referralTitle">Add a referral</h3><p>An owner with a property to list, or a client looking to buy or rent.</p></div>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
        </div>
        <form method="POST" action="{{ route('room.referrals.store') }}" class="tu-modal-body tu-stack" style="gap:14px">
            @csrf
            <div class="tp-seg" role="radiogroup" aria-label="Referral type">
                <input type="radio" id="refOwner" name="type" value="owner" @checked(old('type', 'owner') === 'owner')><label for="refOwner"><x-tu-icon name="home" size="15" /> Property owner</label>
                <input type="radio" id="refClient" name="type" value="client" @checked(old('type') === 'client')><label for="refClient"><x-tu-icon name="search" size="15" /> Client</label>
            </div>
            <div class="tu-field">
                <label for="refName">Full name</label>
                <input id="refName" class="tu-input" name="name" value="{{ old('name') }}" required maxlength="150">
                @error('name')<div class="tu-field-error">{{ $message }}</div>@enderror
            </div>
            <div class="tu-form-grid">
                <div class="tu-field">
                    <label for="refPhone">Phone</label>
                    <input id="refPhone" class="tu-input" type="tel" name="phone" value="{{ old('phone') }}" placeholder="+250 7XX XXX XXX">
                    @error('phone')<div class="tu-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="tu-field">
                    <label for="refEmail">Email</label>
                    <input id="refEmail" class="tu-input" type="email" name="email" value="{{ old('email') }}">
                    @error('email')<div class="tu-field-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="tu-field">
                <label for="refInterest">What do they need?</label>
                <input id="refInterest" class="tu-input" name="interest" value="{{ old('interest') }}" maxlength="255" placeholder="e.g. Selling a 600 m² plot in Kicukiro">
            </div>
            <div class="tu-field">
                <label for="refNotes">Notes <span class="tu-hint">(optional)</span></label>
                <textarea id="refNotes" name="notes" maxlength="1000" rows="3">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-block">Add referral</button>
        </form>
    </div>
</div>
