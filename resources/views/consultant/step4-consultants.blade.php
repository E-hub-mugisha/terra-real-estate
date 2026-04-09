@extends('layouts.base')
@section('title', 'Choose a Consultant – Request a Consultant')

@section('content')


<style>
    .consultant-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .consultant-card {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 1rem 1.25rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        transition: all .15s;
        background: #fff;
    }

    .consultant-card:hover {
        border-color: #1D9E75;
        background: #f9fefe;
    }

    .consultant-card.selected {
        border-color: #1D9E75;
        background: #f0fdf6;
    }

    .c-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #e1f5ee;
        color: #0F6E56;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 15px;
        flex-shrink: 0;
    }

    .c-info {
        flex: 1;
    }

    .c-name-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 3px;
    }

    .c-name {
        font-size: 15px;
        font-weight: 500;
        color: #1a1a1a;
    }

    .badge-verified {
        font-size: 11px;
        background: #e1f5ee;
        color: #0F6E56;
        padding: 2px 8px;
        border-radius: 20px;
        font-weight: 500;
    }

    .c-spec {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .c-meta {
        font-size: 13px;
        color: #374151;
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .c-stars {
        color: #d97706;
        font-weight: 500;
    }

    .c-fee {
        text-align: right;
        flex-shrink: 0;
    }

    .fee-label {
        font-size: 12px;
        color: #9ca3af;
    }

    .fee-amount {
        font-size: 15px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .c-select-indicator {
        font-size: 12px;
        color: #1D9E75;
        display: none;
        align-items: center;
        gap: 4px;
        margin-top: 4px;
    }

    .consultant-card.selected .c-select-indicator {
        display: flex;
        justify-content: flex-end;
    }
</style>

<div class="terra-wizard-container">
    @include('consultant.partials.wizard-layout', ['currentStep' => 4])

    <form method="POST" action="{{ route('consultant.step4.post') }}" id="consultantForm">
        @csrf
        <input type="hidden" name="consultant_id" id="selectedConsultant" value="{{ old('consultant_id') }}">

        <div class="wizard-card">
            <h2>Available consultants</h2>
            <p class="wizard-subtitle">
                <strong>{{ $service_label }}</strong> experts in
                <strong>{{ $district }}</strong>
            </p>

            @if($consultants->isEmpty())
            <div class="text-center py-5">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                <h5>No consultants found in this area yet.</h5>
                <p class="text-muted">We're growing our network. <a href="{{ route('consultant.step3') }}">Try another district</a> or <a href="{{ url('/contact') }}">contact us directly</a>.</p>
            </div>
            @else
            <div class="consultant-list">
                @foreach($consultants as $c)
                <div class="consultant-card {{ old('consultant_id') == $c->id ? 'selected' : '' }}"
                    onclick="selectConsultant({{ $c->id }}, this)">

                    <div class="c-avatar">{{ $c->initials }}</div>

                    <div class="c-info">
                        <div class="c-name-row">
                            <span class="c-name">{{ $c->name }}</span>
                            @if($c->is_verified)
                            <span class="badge-verified">✓ Verified</span>
                            @endif
                        </div>
                        <div class="c-spec">{{ $c->specialty }}</div>
                        <div class="c-meta">
                            <span class="c-stars">★ {{ number_format($c->rating, 1) }}</span>
                            <span class="text-muted">({{ $c->reviews_count }} reviews)</span>
                            <span class="text-muted">· {{ $c->availability }}</span>
                        </div>
                    </div>

                    <div class="c-fee">
                        <div class="fee-label">Booking fee</div>
                        <div class="fee-amount">3,000 RWF</div>
                        <div class="c-select-indicator">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M8 12l3 3 5-5" />
                            </svg>
                            Selected
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="wizard-actions">
            <a href="{{ route('consultant.step3') }}" class="btn-back-link">← Back</a>
            @if($consultants->isNotEmpty())
            <button type="submit" id="btnNext" class="btn-terra" {{ old('consultant_id') ? '' : 'disabled' }}>
                Request Appointment →
            </button>
            @endif
        </div>
    </form>
</div>

<script>
    function selectConsultant(id, el) {
        document.querySelectorAll('.consultant-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('selectedConsultant').value = id;
        document.getElementById('btnNext').disabled = false;
    }
</script>

@endsection
