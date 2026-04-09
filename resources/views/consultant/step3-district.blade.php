@extends('layouts.base')
@section('title', 'Select District – Request a Consultant')

@section('content')
<div class="terra-wizard-container">
    @include('consultant.partials.wizard-layout', ['currentStep' => 3])

    <form method="POST" action="{{ route('consultant.step3.post') }}">
        @csrf
        <input type="hidden" name="district" id="selectedDistrict" value="{{ old('district') }}">

        <div class="wizard-card">
            <h2>Select your district</h2>
            <p class="wizard-subtitle">
                Province: <strong>{{ $province }}</strong>
                &nbsp;·&nbsp; Pick the district closest to your property.
            </p>

            <div class="option-grid">
                @foreach($districts as $district)
                    <button type="button"
                        class="option-card {{ old('district') === $district ? 'selected' : '' }}"
                        onclick="pick('selectedDistrict', '{{ $district }}', this)">
                        <span class="option-icon">🏘️</span>
                        <span>
                            <span class="option-label">{{ $district }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="wizard-actions">
            <a href="{{ route('consultant.step2') }}" class="btn-back-link">← Back</a>
            <button type="submit" id="btnNext" class="btn-terra" {{ old('district') ? '' : 'disabled' }}>
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
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('selectedDistrict').value) {
        document.getElementById('btnNext').disabled = false;
    }
});
</script>
@endsection
