@extends('layouts.app')

@section('title', 'Create Agent Level')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:var(--terra-navy)">Create Agent Level</h1>
            <p class="text-muted mb-0" style="font-size:.9rem">Define a new performance level and commission bonus rate</p>
        </div>
        <a href="{{ route('admin.agent-levels.index') }}" class="btn btn-outline-secondary btn-sm">
            ← Back to Levels
        </a>
    </div>

    {{-- Errors --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.agent-levels.store') }}">
        @csrf

        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0" style="color:var(--terra-navy)">Level Details</h6>
                    </div>
                    <div class="card-body p-4">

                        <div class="row g-3">

                            {{-- Level name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Level Name <span class="text-danger">*</span>
                                </label>
                                <select name="level_name" class="form-select" required>
                                    <option value="">— Select level —</option>
                                    @foreach($levelNames as $value => $label)
                                    <option value="{{ $value }}" {{ old('level_name') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Label --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Display Label <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="label" class="form-control"
                                    placeholder="e.g. Bronze Agent"
                                    value="{{ old('label') }}" required>
                            </div>

                            {{-- Badge emoji --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Badge Emoji
                                </label>
                                <input type="text" name="badge_emoji" class="form-control"
                                    placeholder="e.g. 🥉"
                                    value="{{ old('badge_emoji') }}" maxlength="10">
                                <div class="form-text">Optional emoji shown next to the level name.</div>
                            </div>

                            {{-- Badge color --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Badge Color <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="color" name="badge_color" id="badgeColor"
                                        class="form-control form-control-color"
                                        value="{{ old('badge_color', '#cd7f32') }}" required
                                        style="max-width:60px">
                                    <input type="text" id="badgeColorText" class="form-control"
                                        value="{{ old('badge_color', '#cd7f32') }}"
                                        placeholder="#cd7f32" maxlength="20"
                                        oninput="document.getElementById('badgeColor').value=this.value">
                                </div>
                            </div>

                            {{-- Commission rate --}}
                            <div class="col-md-4">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Commission Bonus Rate % <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="commission_rate" id="commRate"
                                        class="form-control" placeholder="e.g. 25"
                                        value="{{ old('commission_rate') }}"
                                        min="0" max="100" step="0.01" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            {{-- Requirements --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold" style="font-size:.85rem">
                                    Requirements / Notes
                                </label>
                                <textarea name="requirements" class="form-control" rows="3"
                                    placeholder="e.g. Minimum 10 referrals OR 500,000 RWF in revenue to reach Silver">{{ old('requirements') }}</textarea>
                                <div class="form-text">Describe what an agent needs to reach this level.</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="col-lg-4">

                {{-- Live preview --}}
                <div class="card border-0 shadow-sm" style="background:var(--terra-navy)">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4" style="color:var(--terra-gold)">Badge Preview</h6>

                        {{-- Badge --}}
                        <div class="text-center mb-4">
                            <div id="badgePreview" style="display:inline-flex;align-items:center;gap:8px;
                                padding:10px 24px;border-radius:30px;font-size:1rem;font-weight:700;
                                background:rgba(205,127,50,.2);color:#cd7f32;border:1px solid rgba(205,127,50,.4)">
                                <span id="badgeEmojiPreview">🥉</span>
                                <span id="badgeLabelPreview">Bronze Agent</span>
                            </div>
                        </div>

                        {{-- Rate preview --}}
                        <div style="border-top:1px solid rgba(255,255,255,.1);padding-top:16px">
                            <div style="font-size:.72rem;color:rgba(255,255,255,.35);text-transform:uppercase;letter-spacing:.08em;margin-bottom:10px">
                                Commission Bonus
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
                                <div style="flex:1;height:8px;border-radius:4px;overflow:hidden;background:rgba(255,255,255,.1)">
                                    <div id="rateBar" style="height:100%;border-radius:4px;
                                        background:linear-gradient(90deg,var(--terra-orange),var(--terra-gold));
                                        transition:width .3s;width:0%"></div>
                                </div>
                                <span id="ratePct" style="font-size:.85rem;color:var(--terra-gold);font-weight:700;min-width:36px">0%</span>
                            </div>
                            <div style="font-size:.78rem;color:rgba(255,255,255,.4)">
                                Applied to net listing amount on each commission payout
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn px-4 py-2 fw-semibold text-white"
                style="background:var(--terra-orange);border:none">
                Save Level
            </button>
            <a href="{{ route('admin.agent-levels.index') }}"
                class="btn btn-outline-secondary px-4 py-2">
                Cancel
            </a>
        </div>

    </form>
</div>

<script>
    const badgeColorInput = document.getElementById('badgeColor');
    const badgeColorText  = document.getElementById('badgeColorText');
    const commRateInput   = document.getElementById('commRate');
    const labelInput      = document.querySelector('[name="label"]');
    const emojiInput      = document.querySelector('[name="badge_emoji"]');

    function updatePreview() {
        const color   = badgeColorInput.value;
        const rate    = parseFloat(commRateInput.value) || 0;
        const label   = labelInput.value || 'Agent Level';
        const emoji   = emojiInput.value || '🏅';

        // Badge
        const badge = document.getElementById('badgePreview');
        badge.style.background   = color + '22';
        badge.style.color        = color;
        badge.style.borderColor  = color + '44';

        document.getElementById('badgeEmojiPreview').textContent  = emoji;
        document.getElementById('badgeLabelPreview').textContent  = label;

        // Rate bar
        document.getElementById('rateBar').style.width = rate + '%';
        document.getElementById('ratePct').textContent = rate + '%';
    }

    // Sync color picker and text input
    badgeColorInput.addEventListener('input', function () {
        badgeColorText.value = this.value;
        updatePreview();
    });

    commRateInput.addEventListener('input', updatePreview);
    labelInput.addEventListener('input', updatePreview);
    emojiInput.addEventListener('input', updatePreview);

    updatePreview();
</script>
@endsection