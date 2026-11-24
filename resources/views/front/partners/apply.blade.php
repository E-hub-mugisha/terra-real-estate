@extends('layouts.auth')
@section('title', 'Become a partner')
@section('side_title', 'Earn with Terra as an independent partner.')
@section('side_text', 'Refer property owners and buyers, submit listings for people you know, and earn a share of every package and deal, with no office or license needed.')

@section('content')
        <h1>Become a Terra partner</h1>
        <p>Tell us a little about you. The Terra team reviews applications within one working day.</p>
        <form method="POST" action="{{ route('front.partners.apply.store') }}" class="tu-stack" style="gap:16px" data-busy="Sending application…">
            @csrf
            <div class="tu-field">
                <label for="name">Full name</label>
                <input id="name" class="tu-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')<div class="tu-field-error">{{ $message }}</div>@enderror
            </div>
            <div class="tu-form-grid">
                <div class="tu-field">
                    <label for="email">Email</label>
                    <input id="email" class="tu-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')<div class="tu-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="tu-field">
                    <label for="phone">Phone</label>
                    <input id="phone" class="tu-input" type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+250 7XX XXX XXX" autocomplete="tel">
                    @error('phone')<div class="tu-field-error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="tu-form-grid">
                <div class="tu-field">
                    <label for="whatsapp">WhatsApp <span class="tu-hint">(optional)</span></label>
                    <input id="whatsapp" class="tu-input" type="tel" name="whatsapp" value="{{ old('whatsapp') }}">
                </div>
                <div class="tu-field">
                    <label for="company_name">Company <span class="tu-hint">(optional)</span></label>
                    <input id="company_name" class="tu-input" type="text" name="company_name" value="{{ old('company_name') }}" autocomplete="organization">
                </div>
            </div>
            <div class="tu-field">
                <label for="areas">Areas you cover</label>
                <input id="areas" class="tu-input" type="text" name="areas" value="{{ old('areas') }}" required placeholder="e.g. Gasabo, Kicukiro, Musanze">
                @error('areas')<div class="tu-field-error">{{ $message }}</div>@enderror
            </div>
            <div class="tu-field">
                <label for="bio">About you <span class="tu-hint">(optional)</span></label>
                <textarea id="bio" name="bio" maxlength="1000" rows="3" placeholder="Your network, experience, the kind of properties you work with…">{{ old('bio') }}</textarea>
            </div>
            <div class="tu-form-grid">
                <div class="tu-field">
                    <label for="password">Password</label>
                    <div class="tu-pass">
                        <input id="password" class="tu-input" style="width:100%" type="password" name="password" required autocomplete="new-password" minlength="8">
                        <button type="button" data-toggle-pass aria-label="Show password">Show</button>
                    </div>
                    @error('password')<div class="tu-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="tu-field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" class="tu-input" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>
            <label class="tu-check">
                <input type="checkbox" name="terms" value="1" @checked(old('terms')) required>
                <span>I agree to the partner terms: I only refer people who agreed to be contacted, and commissions are paid after Terra confirms them.</span>
            </label>
            @error('terms')<div class="tu-field-error">{{ $message }}</div>@enderror
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Apply as a partner</button>
        </form>
        <p class="tu-auth-alt">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        <p class="tu-auth-alt" style="margin-top:8px">Licensed agent? <a href="{{ route('front.agents.register') }}">Join as an agent</a></p>
@endsection
