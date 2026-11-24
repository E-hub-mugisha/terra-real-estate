@extends('layouts.auth')
@section('title', 'Create account')
@section('side_title', 'One marketplace for owners and buyers.')
@section('side_text', 'Owners list houses, land and designs and talk to buyers directly. Clients save properties, book viewings and make offers.')

@section('content')
        <h1>Create your account</h1>
        <p>Free for owners and clients. It takes a minute.</p>
        <form method="POST" action="{{ route('register') }}" class="tu-stack" style="gap:16px" data-busy="Creating account…">
            @csrf
            @php $role = old('role', request('role') === 'owner' ? 'owner' : 'client'); @endphp
            <fieldset class="tu-role-pick">
                <legend class="tu-sr">I want to</legend>
                <label class="tu-role-card">
                    <input type="radio" name="role" value="client" @checked($role === 'client')>
                    <span class="tu-menu-ico"><x-tu-icon name="search" /></span>
                    <span><strong>Find a property</strong><small>Save, book viewings, make offers</small></span>
                </label>
                <label class="tu-role-card">
                    <input type="radio" name="role" value="owner" @checked($role === 'owner')>
                    <span class="tu-menu-ico"><x-tu-icon name="home" /></span>
                    <span><strong>List my property</strong><small>Sell or rent directly to clients</small></span>
                </label>
            </fieldset>
            <div class="tu-field">
                <label for="name">Full name</label>
                <input id="name" class="tu-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>
            <div class="tu-form-grid">
                <div class="tu-field">
                    <label for="email">Email</label>
                    <input id="email" class="tu-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                </div>
                <div class="tu-field">
                    <label for="phone">Phone <span class="tu-hint">(optional)</span></label>
                    <input id="phone" class="tu-input" type="tel" name="phone" value="{{ old('phone') }}" placeholder="+250 7XX XXX XXX" autocomplete="tel">
                </div>
            </div>
            <div class="tu-field">
                <label for="password">Password</label>
                <div class="tu-pass">
                    <input id="password" class="tu-input" style="width:100%" type="password" name="password" required autocomplete="new-password" minlength="8">
                    <button type="button" data-toggle-pass aria-label="Show password">Show</button>
                </div>
            </div>
            <div class="tu-field">
                <label for="password_confirmation">Confirm password</label>
                <div class="tu-pass">
                    <input id="password_confirmation" class="tu-input" style="width:100%" type="password" name="password_confirmation" required autocomplete="new-password">
                    <button type="button" data-toggle-pass aria-label="Show password">Show</button>
                </div>
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Create account</button>
        </form>
        <p class="tu-auth-alt">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        <p class="tu-auth-alt" style="margin-top:8px">
            Real estate professional? <a href="{{ route('front.agents.register') }}">Join as an agent</a> · <a href="{{ route('front.partners.apply') }}">Become a partner</a>
        </p>
@endsection
