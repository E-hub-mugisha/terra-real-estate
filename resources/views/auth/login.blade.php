@extends('layouts.auth')
@section('title', 'Sign in')

@section('content')
        <h1>Welcome back</h1>
        <p>Sign in to manage your listings and inquiries.</p>
        <form method="POST" action="{{ route('login') }}" class="tu-stack" style="gap:16px" data-busy="Signing in…">
            @csrf
            <div class="tu-field">
                <label for="email">Email</label>
                <input id="email" class="tu-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            <div class="tu-field">
                <label for="password">Password</label>
                <div class="tu-pass">
                    <input id="password" class="tu-input" style="width:100%" type="password" name="password" required autocomplete="current-password">
                    <button type="button" data-toggle-pass aria-label="Show password">Show</button>
                </div>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;gap:12px">
                <label class="tu-check"><input type="checkbox" name="remember"> Remember me</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size:.86rem;font-weight:700;color:var(--tu-brand);text-decoration:none">Forgot password?</a>
                @endif
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Sign in</button>
        </form>
        <p class="tu-auth-alt">New to Terra? <a href="{{ route('register') }}">Create an account</a> · <a href="{{ route('front.agents.register') }}">Join as an agent</a></p>
@endsection
