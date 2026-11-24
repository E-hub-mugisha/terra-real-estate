@extends('layouts.auth')
@section('title', 'Forgot password')

@section('content')
        <h1>Reset your password</h1>
        <p>Enter your email and we'll send you a reset link.</p>
        <form method="POST" action="{{ route('password.email') }}" class="tu-stack" style="gap:16px" data-busy="Sending…">
            @csrf
            <div class="tu-field">
                <label for="email">Email</label>
                <input id="email" class="tu-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Email reset link</button>
        </form>
        <p class="tu-auth-alt"><a href="{{ route('login') }}">Back to sign in</a></p>
@endsection
