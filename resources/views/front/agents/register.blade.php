@extends('layouts.guest')
@section('title', 'Become a Terra agent')

@section('content')
<section class="tu-page-hero">
    <div class="tu-container">
        <ol class="tu-crumbs">
            <li><a href="{{ route('front.home') }}">Home</a></li>
            <li><a href="{{ route('front.agents') }}">Agents</a></li>
            <li>Become an agent</li>
        </ol>
        <div class="tu-eyebrow" style="color:#D05208">Join Terra</div>
        <h1 class="tu-h1">Become a Terra agent</h1>
        <p>List houses, land and architectural designs, and get inquiries from buyers across Rwanda. It takes about two minutes.</p>
    </div>
</section>

<div class="tu-container tu-detail">
    <div class="tu-detail-grid">
        <form method="POST" action="{{ route('front.agents.register.store') }}" enctype="multipart/form-data" id="agentForm">
            @csrf

            @if ($errors->any())
                <div class="tu-alert tu-alert-danger">Please fix the highlighted fields below.</div>
            @endif

            <div class="tu-panel">
                <h2 class="tu-panel-title">1. About you</h2>
                <div class="tu-form-grid">
                    <div class="tu-field tu-span-2">
                        <label for="f_full_name">Full name *</label>
                        <input class="tu-input" type="text" name="full_name" id="f_full_name" value="{{ old('full_name') }}" required autocomplete="name">
                        @error('full_name')<span class="tu-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="tu-field">
                        <label for="f_email">Email *</label>
                        <input class="tu-input" type="email" name="email" id="f_email" value="{{ old('email') }}" required autocomplete="email">
                        <span class="tu-hint">Your login details will be sent here.</span>
                        @error('email')<span class="tu-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="tu-field">
                        <label for="f_phone">Phone *</label>
                        <input class="tu-input" type="tel" name="phone" id="f_phone" value="{{ old('phone') }}" placeholder="+250 7XX XXX XXX" required autocomplete="tel">
                        @error('phone')<span class="tu-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="tu-field">
                        <label for="f_whatsapp">WhatsApp</label>
                        <input class="tu-input" type="tel" name="whatsapp" id="f_whatsapp" value="{{ old('whatsapp') }}" placeholder="Same as phone if empty">
                        @error('whatsapp')<span class="tu-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="tu-field">
                        <label for="f_languages">Languages</label>
                        <input class="tu-input" type="text" name="languages" id="f_languages" value="{{ old('languages') }}" placeholder="Kinyarwanda, English, French">
                        @error('languages')<span class="tu-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="tu-field tu-span-2">
                        <label for="f_office">Office location</label>
                        <input class="tu-input" type="text" name="office_location" id="f_office" value="{{ old('office_location') }}" placeholder="e.g. KG 11 Ave, Kacyiru, Gasabo">
                        @error('office_location')<span class="tu-field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="tu-field tu-span-2">
                        <label for="f_bio">Short bio</label>
                        <textarea name="bio" id="f_bio" maxlength="1000" placeholder="Areas you cover, experience, the kind of properties you specialise in…">{{ old('bio') }}</textarea>
                        @error('bio')<span class="tu-field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="tu-panel">
                <h2 class="tu-panel-title">2. Profile photo</h2>
                <label for="f_photo" style="display:flex;align-items:center;gap:18px;cursor:pointer">
                    <span class="tu-agent-photo" style="margin:0;width:84px;height:84px">
                        <img id="photoPreview" src="" alt="" style="display:none">
                        <span class="tu-avatar" id="photoPlaceholder"><x-tu-icon name="user" /></span>
                    </span>
                    <span>
                        <span class="tu-btn tu-btn-sm"><x-tu-icon name="image" /> Choose photo</span>
                        <span class="tu-hint" style="display:block;margin-top:8px">JPG, PNG or WebP, up to 2 MB. A clear headshot builds trust.</span>
                    </span>
                </label>
                <input type="file" name="profile_image" id="f_photo" accept="image/jpeg,image/png,image/webp" class="tu-sr">
                @error('profile_image')<span class="tu-field-error">{{ $message }}</span>@enderror
            </div>

            <div class="tu-panel">
                <h2 class="tu-panel-title">3. Social profiles <span class="tu-hint" style="font-weight:500">(optional)</span></h2>
                <div class="tu-form-grid">
                    @foreach (['linkedin' => 'LinkedIn', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'twitter' => 'X / Twitter'] as $field => $label)
                        <div class="tu-field">
                            <label for="f_{{ $field }}">{{ $label }}</label>
                            <input class="tu-input" type="url" name="{{ $field }}" id="f_{{ $field }}" value="{{ old($field) }}" placeholder="https://">
                            @error($field)<span class="tu-field-error">{{ $message }}</span>@enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg" id="agentSubmit" style="margin-top:20px">Create my agent account</button>
            <p class="tu-hint" style="margin-top:12px">Your profile goes live after the Terra team verifies it — usually within one working day.</p>
        </form>

        <aside class="tu-sticky">
            <div class="tu-panel">
                <h2 class="tu-panel-title">Why list with Terra</h2>
                <div class="tu-stack" style="gap:16px">
                    @foreach ([
                        ['users', 'Buyers across Rwanda', 'Your listings appear in search, on the homepage and on your public profile.'],
                        ['whatsapp', 'Leads straight to your phone', 'Buyers contact you by WhatsApp, phone or email.'],
                        ['dashboard', 'Simple dashboard', 'Add houses, land and designs, upload photos and track listings.'],
                        ['shield', 'Verified badge', 'A verified profile helps buyers choose you with confidence.'],
                    ] as [$icon, $title, $text])
                        <div style="display:flex;gap:12px">
                            <span class="tu-menu-ico"><x-tu-icon :name="$icon" /></span>
                            <span><strong style="display:block;color:var(--tu-ink);font-size:.9rem">{{ $title }}</strong><span class="tu-hint" style="font-size:.84rem">{{ $text }}</span></span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tu-panel" style="text-align:center">
                <p class="tu-hint" style="font-size:.88rem;margin:0 0 10px">Already have an account?</p>
                <a href="{{ route('login') }}" class="tu-btn tu-btn-block">Sign in</a>
            </div>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const input = document.getElementById('f_photo');
        const preview = document.getElementById('photoPreview');
        const placeholder = document.getElementById('photoPlaceholder');
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                input.value = '';
                window.Swal ? Swal.fire({ icon: 'warning', title: 'Photo too large', text: 'Please choose an image under 2 MB.' }) : alert('Please choose an image under 2 MB.');
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        });
        document.getElementById('agentForm').addEventListener('submit', () => {
            const btn = document.getElementById('agentSubmit');
            btn.disabled = true;
            btn.textContent = 'Creating your account…';
        });
    })();
</script>
@endpush
