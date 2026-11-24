@extends('layouts.auth')
@section('title', 'Confirm password')

@section('content')
        <h1>Confirm your password</h1>
        <p>This is a secure area. Please confirm your password to continue.</p>
        <form method="POST" action="{{ route('password.confirm') }}" class="tu-stack" style="gap:16px">
            @csrf
            <div class="tu-field">
                <label for="password">Password</label>
                <div class="tu-pass">
                    <input id="password" class="tu-input" style="width:100%" type="password" name="password" required autocomplete="current-password">
                    <button type="button" data-toggle-pass aria-label="Show password">Show</button>
                </div>
            </div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-lg tu-btn-block">Confirm</button>
        </form>
@endsection
