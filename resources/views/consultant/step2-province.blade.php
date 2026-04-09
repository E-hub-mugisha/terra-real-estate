@extends('layouts.base')
@section('title', 'Select Province – Request a Consultant')
@section('content')
<div class="terra-wizard-container">
    @include('consultant.partials.wizard-layout', ['currentStep' => 2])

    <form method="POST" action="{{ route('consultant.step2.post') }}" id="provinceForm">
        @csrf
        <input type="hidden" name="province" id="selectedProvince" value="{{ old('province') }}">

        <div class="wizard-card">
            <h2>Select your province</h2>
            <p class="wizard-subtitle">
                Service: <strong>{{ $service_label }}</strong>
                &nbsp;·&nbsp; Choose the province where you need help.
            </p>

            <div class="option-grid">
                @foreach($provinces as $province)
                    <button type="button"
                        class="option-card {{ old('province') === $province ? 'selected' : '' }}"
                        onclick="pick('selectedProvince', '{{ $province }}', this)">
                        <span class="option-icon">📍</span>
                        <span class="option-label">{{ $province }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="wizard-actions">
            <a href="{{ route('consultant.step1') }}" class="btn-back-link">← Back</a>
            <button type="submit" id="btnNext" class="btn-terra" {{ old('province') ? '' : 'disabled' }}>
                Next →
            </button>
        </div>
    </form>
</div>


<script>
function pick(inputId, value, el) {
    el.closest('.option-grid').querySelectorAll('.option-card').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById(inputId).value = value;
    document.getElementById('btnNext').disabled = false;
}
</script>

@endsection

