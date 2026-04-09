@extends('layouts.base')
@section('title', 'Appointment Details – Request a Consultant')

@section('content')

<style>
    .mini-consultant {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        background: #f0fdf6;
        border: 1px solid #bbf0d9;
        border-radius: 10px;
    }

    .mini-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #1D9E75;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }
</style>

<div class="terra-wizard-container">
    @include('consultant.partials.wizard-layout', ['currentStep' => 5])

    <form method="POST" action="{{ route('consultant.step5.post') }}">
        @csrf

        <div class="wizard-card">
            <h2>Your appointment details</h2>
            <p class="wizard-subtitle">
                Booking with <strong>{{ $consultant->name }}</strong>
                &nbsp;·&nbsp; {{ $consultant->specialty }}
            </p>

            {{-- Consultant mini card --}}
            <div class="mini-consultant mb-4">
                <div class="mini-avatar">{{ $consultant->initials }}</div>
                <div>
                    <div style="font-weight:500;">{{ $consultant->name }}</div>
                    <div style="font-size:13px;color:#6b7280;">{{ $consultant->availability }} &nbsp;·&nbsp; {{ $consultant->district }}</div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full name <span class="text-danger">*</span></label>
                    <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror"
                        placeholder="Your full name" value="{{ old('client_name', auth()->user()?->name) }}" required>
                    @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email address <span class="text-danger">*</span></label>
                    <input type="email" name="client_email" class="form-control @error('client_email') is-invalid @enderror"
                        placeholder="you@example.com" value="{{ old('client_email', auth()->user()?->email) }}" required>
                    @error('client_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone number <span class="text-danger">*</span></label>
                    <input type="tel" name="client_phone" class="form-control @error('client_phone') is-invalid @enderror"
                        placeholder="+250 7XX XXX XXX" value="{{ old('client_phone') }}" required>
                    @error('client_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Preferred appointment date <span class="text-danger">*</span></label>
                    <input type="date" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror"
                        value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}" required>
                    @error('appointment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Describe your need <span class="text-muted">(optional)</span></label>
                    <textarea name="notes" class="form-control" rows="3"
                        placeholder="Tell the consultant what you need help with...">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        <div class="wizard-actions">
            <a href="{{ route('consultant.step4') }}" class="btn-back-link">← Back</a>
            <button type="submit" class="btn-terra">Continue to Payment →</button>
        </div>
    </form>
</div>
@endsection