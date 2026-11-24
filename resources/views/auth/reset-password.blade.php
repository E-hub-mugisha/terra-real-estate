@extends('layouts.auth')
@section('title', 'Reset password')

@section('content')
        <h1>Choose a new password</h1>
        <p>Use at least 8 characters.</p>
        <form method="POST" action="{{ route('password.store') }}" class="tu-stack" style="gap:16px" data-busy="Saving…">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="tu-field">
                <label for="email">Email</label>
                <input id="email" class="tu-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autocomplete="username">
            </div>
            <div class="tu-field">
                <label for="password">New password</label>
                <div class="tu-pass">
                    <input id="password" class="tu-input" style="width:100%" type="password" name="password" required autofocus autocomplete="new-password" minlength="8">
                    <button type="button" data-toggle-pass aria-label="Show password">Show</button>
                </div>
            </div>
            <div class="tu-field">
                <label for="password_confirmation">Confirm new password</label>
                <div class="tu-pass">
                    <input id="password_confirmation" class="tu-input" style="width:100%" type="password" name="password_confirmation" required autocomplete="new-password">
                    <button type="button" data-toggle-pass aria-label="Show password">Show</button>
                </div>
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Reset password</button>
        </form>
@endsection
