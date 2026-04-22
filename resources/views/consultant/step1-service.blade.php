@extends('layouts.base')

@section('title', 'Request a Consultant – Choose Service')

@section('content')

<div class="terra-wizard-container">

    @include('consultant.partials.wizard-layout', ['currentStep' => 1])

    <form method="POST" action="{{ route('consultant.step1.post') }}" id="serviceForm">
        @csrf
        <input type="hidden" name="service_id" id="selectedService" value="{{ old('service_id') }}">

        <div class="wizard-card">
            <h2>Choose a service</h2>
            <p class="wizard-subtitle">What type of real estate consultation do you need?</p>

            <div class="option-grid">
                @foreach($services as $service)
                    <button type="button"
                        class="option-card {{ old('service_id') === $service['id'] ? 'selected' : '' }}"
                        data-value="{{ $service['id'] }}"
                        onclick="selectService('{{ $service['id'] }}', this)">
                        <span class="option-icon">{{ $service['icon'] }}</span>
                        <span>
                            <span class="option-label">{{ $service['title'] }}</span>
                            <span class="option-sub d-block">{{ $service['sub'] ?? '' }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="wizard-actions justify-content-end">
            <button type="submit" id="btnNext" class="btn-terra" disabled>
                Next <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </div>
    </form>

</div>

<script>
function selectService(value, el) {
    document.querySelectorAll('.option-card').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selectedService').value = value;
    document.getElementById('btnNext').disabled = false;
}

// Restore if old value
document.addEventListener('DOMContentLoaded', function() {
    const old = document.getElementById('selectedService').value;
    if (old) document.getElementById('btnNext').disabled = false;
});
</script>
@endsection