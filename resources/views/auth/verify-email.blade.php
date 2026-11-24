@extends('layouts.auth')
@section('title', 'Verify email')

@section('content')
        <h1>Check your inbox</h1>
        <p>We sent a verification link to your email address. Click it to activate your account.</p>
        @if (session('status') == 'verification-link-sent')
            <div class="tu-alert tu-alert-success">A new verification link has been sent to your email.</div>
        @endif
        <div class="tu-stack">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Resend verification email</button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="tu-btn tu-btn-block">Sign out</button>
            </form>
        </div>
@endsection
