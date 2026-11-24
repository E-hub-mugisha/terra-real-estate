@extends('layouts.app')
@section('title', 'Marketplace settings')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Marketplace settings</h1>
        <p>Package ad timing, commission rates and support contacts. Changes apply to new payments and deals immediately.</p>
    </div>
</div>

<form method="POST" action="{{ route('admin.marketplace.settings.save') }}">
    @csrf @method('PUT')
    <div class="row g-3">
        @foreach ($groups as $group => $items)
            <div class="col-xl-6">
                <div class="card h-100">
                    <div class="card-header">{{ $group }}</div>
                    <div class="card-body tu-stack" style="gap:14px">
                        @if ($group === 'Packages & ads')
                            <p class="tu-hint" style="margin:0">A listing is live for every day paid. The share below is how many of those days it also runs in the homepage ads strip. Premium listings also appear in the spotlight pop-up.</p>
                        @endif
                        @foreach ($items as $s)
                            @php $field = str_replace('.', '__', $s['key']); @endphp
                            <div class="tu-field">
                                <label for="{{ $field }}">{{ $s['label'] }}</label>
                                <div style="display:flex;align-items:center;gap:10px">
                                    <input id="{{ $field }}" class="tu-input" style="max-width:{{ $s['type'] === 'number' ? '160px' : '100%' }};flex:1" name="{{ $field }}"
                                        type="{{ $s['type'] === 'number' ? 'number' : 'text' }}" @if ($s['type'] === 'number') step="any" min="0" @if (str_ends_with($s['key'], '_pct')) max="100" @endif @endif
                                        value="{{ old($field, $s['value']) }}" {{ $s['type'] === 'number' ? 'required' : '' }}>
                                    @if (str_ends_with($s['key'], '_pct'))<span style="color:var(--tu-muted);font-weight:700">%</span>@endif
                                    @if ((string) $s['value'] !== (string) $s['default'])<span class="tu-hint">default {{ $s['default'] }}</span>@endif
                                </div>
                                @error($field)<div class="tu-field-error">{{ $message }}</div>@enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="tp-savebar">
        <span class="tu-hint">Rates already recorded on existing commissions are not changed.</span>
        <button class="tu-btn tu-btn-primary"><x-tu-icon name="check" /> Save settings</button>
    </div>
</form>
@endsection
