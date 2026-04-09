@extends('layouts.base')
@section('title', 'Booking Confirmed – Terra')

@section('content')


<style>
    .success-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #e1f5ee;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ref-badge {
        display: inline-block;
        background: #f0fdf6;
        border: 1px solid #bbf0d9;
        color: #0F6E56;
        border-radius: 8px;
        padding: 8px 20px;
        font-size: 14px;
    }

    .booking-summary {
        max-width: 520px;
        background: #f9fafb;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        flex-wrap: wrap;
        gap: 4px;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-label {
        color: #6b7280;
    }

    .summary-val {
        font-weight: 500;
        color: #1a1a1a;
    }

    .status-badge {
        display: inline-block;
        font-size: 12px;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .status-pending {
        background: #fef9c3;
        color: #854d0e;
    }

    .info-box {
        background: #f0fdf6;
        border: 1px solid #bbf0d9;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 13px;
        color: #0F6E56;
    }
</style>

<div class="terra-wizard-container">
    @include('consultant.partials.wizard-layout', ['currentStep' => 7])

    <div class="wizard-card text-center">
        <div class="success-circle mx-auto mb-4">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#1D9E75" stroke-width="2.5">
                <path d="M20 6L9 17l-5-5" />
            </svg>
        </div>

        <h2 class="mb-2">Booking request submitted!</h2>
        <p style="color:#6b7280;max-width:480px;margin:0 auto 1.5rem;">
            Payment received. Your appointment is pending admin confirmation.
            You'll receive a confirmation email with the consultant's contact details once approved.
        </p>

        {{-- Reference badge --}}
        <div class="ref-badge mx-auto mb-4">
            Reference: <strong>{{ $booking->reference }}</strong>
        </div>

        {{-- Booking summary --}}
        <div class="booking-summary text-start mx-auto mb-4">
            <div class="summary-row">
                <span class="summary-label">Consultant</span>
                <span class="summary-val">{{ $booking->consultant->name }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Service</span>
                <span class="summary-val">{{ $booking->service_label }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">District</span>
                <span class="summary-val">{{ $booking->district }}, {{ $booking->province }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Appointment date</span>
                <span class="summary-val">{{ $booking->appointment_date?->format('D, d M Y') ?? 'TBD' }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Your email</span>
                <span class="summary-val">{{ $booking->client_email }}</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Fee paid</span>
                <span class="summary-val">{{ number_format($booking->fee) }} RWF</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Status</span>
                <span class="status-badge status-pending">⏳ Pending admin confirmation</span>
            </div>
        </div>

        {{-- Email note --}}
        <div class="info-box text-start mb-4" style="max-width:520px;margin-left:auto;margin-right:auto;">
            📧 Once an admin confirms your booking, we'll email:
            <ul class="mb-0 mt-2" style="font-size:13px;padding-left:1.25rem;">
                <li>You — with the consultant's phone number and contact details</li>
                <li>The consultant — with your name, phone, and appointment info</li>
            </ul>
        </div>

        <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('consultant.step1') }}" class="btn-terra">Book another consultation</a>
            <a href="{{ url('/') }}" class="btn-back-link">Back to Terra</a>
        </div>
    </div>
</div>
@endsection
