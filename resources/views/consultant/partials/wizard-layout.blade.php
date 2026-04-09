{{-- resources/views/consultant/partials/wizard-layout.blade.php --}}
{{-- Usage: @include('consultant.partials.wizard-layout', ['currentStep' => 1]) --}}

@php
$steps = [
    1 => 'Service',
    2 => 'Province',
    3 => 'District',
    4 => 'Consultant',
    5 => 'Details',
    6 => 'Payment',
    7 => 'Confirmed',
];
@endphp

<div class="terra-wizard-header">
    <div class="container">
        <a href="{{ url('/') }}" class="wizard-logo">
            <img src="{{ asset('front/assets/img/logo/logo.png') }}" alt="Terra Real Estate" height="36">
        </a>
        <h1 class="wizard-title">Request a Consultant</h1>
    </div>
</div>

<div class="container terra-wizard-container">
    {{-- Step bar --}}
    <div class="wizard-steps">
        @foreach($steps as $num => $label)
            <div class="wizard-step {{ $num < $currentStep ? 'done' : ($num === $currentStep ? 'active' : '') }}">
                <div class="step-circle">
                    @if($num < $currentStep)
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                    @else
                        {{ $num }}
                    @endif
                </div>
                <span class="step-name">{{ $label }}</span>
            </div>
            @if(!$loop->last)
                <div class="step-connector {{ $num < $currentStep ? 'done' : '' }}"></div>
            @endif
        @endforeach
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Main slot --}}
    @yield('content')
</div>

<style>
.terra-wizard-header {
    background: #fff;
    border-bottom: 1px solid #e5e7eb;
    padding: 1rem 0;
    margin-bottom: 2rem;
}
.wizard-logo img { height: 36px; }
.wizard-title {
    font-size: 1.1rem;
    font-weight: 500;
    color: #1a1a1a;
    margin: 0;
    display: inline-block;
    margin-left: 1rem;
    vertical-align: middle;
}
.terra-wizard-container { max-width: 740px; margin: 0 auto; padding: 0 1rem 3rem; }

/* Step bar */
.wizard-steps {
    display: flex;
    align-items: center;
    margin-bottom: 2.5rem;
    overflow-x: auto;
    padding-bottom: 4px;
}
.wizard-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}
.step-circle {
    width: 32px; height: 32px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 500;
    border: 2px solid #d1d5db;
    color: #9ca3af;
    background: #fff;
    transition: all .2s;
}
.wizard-step.active .step-circle {
    border-color: #1D9E75;
    background: #1D9E75;
    color: #fff;
}
.wizard-step.done .step-circle {
    border-color: #1D9E75;
    background: #1D9E75;
    color: #fff;
}
.step-name {
    font-size: 11px;
    color: #9ca3af;
    white-space: nowrap;
}
.wizard-step.active .step-name { color: #1D9E75; font-weight: 500; }
.wizard-step.done .step-name { color: #0F6E56; }
.step-connector {
    flex: 1;
    height: 2px;
    background: #e5e7eb;
    min-width: 20px;
    margin-bottom: 18px;
}
.step-connector.done { background: #1D9E75; }

/* Wizard card */
.wizard-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.75rem;
    margin-bottom: 1.25rem;
}
.wizard-card h2 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 4px;
}
.wizard-card .wizard-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 1.5rem;
}

/* Option grid */
.option-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
    gap: 10px;
}
.option-card {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 14px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    cursor: pointer;
    transition: all .15s;
    background: #fff;
    width: 100%;
    text-align: left;
}
.option-card:hover { border-color: #1D9E75; background: #f0fdf6; }
.option-card.selected { border-color: #1D9E75; background: #f0fdf6; }
.option-icon {
    width: 36px; height: 36px;
    background: #e1f5ee;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.option-label { font-size: 14px; font-weight: 500; color: #1a1a1a; line-height: 1.3; }
.option-sub { font-size: 12px; color: #6b7280; margin-top: 2px; }

/* Action buttons */
.wizard-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
}
.btn-terra {
    background: #1D9E75;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background .15s;
}
.btn-terra:hover { background: #0F6E56; color: #fff; }
.btn-terra:disabled { background: #d1d5db; cursor: not-allowed; }
.btn-back-link {
    background: transparent;
    color: #6b7280;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 14px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-back-link:hover { background: #f9fafb; color: #374151; }
</style>
