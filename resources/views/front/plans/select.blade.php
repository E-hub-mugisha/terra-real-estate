@extends('layouts.base')
@section('title', 'Choose Your Listing Plan')
@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;400;500&display=swap');

:root {
    --bg:       #F7F5F2;
    --surface:  #FFFFFF;
    --border:   rgba(0,0,0,.08);
    --border2:  rgba(0,0,0,.15);
    --gold:     #C8873A;
    --gold-bg:  rgba(200,135,58,.07);
    --gold-bd:  rgba(200,135,58,.22);
    --gold-lt:  #E5A55E;
    --text:     #1A1714;
    --muted:    #6B6560;
    --dim:      #9E9890;
    --green:    #1E7A5A;
    --green-bg: rgba(30,122,90,.08);
    --green-bd: rgba(30,122,90,.2);
    --r:        14px;
    --t:        .22s cubic-bezier(.4,0,.2,1);
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; }
a { text-decoration: none; color: inherit; }

/* ── Page ── */
.sp-page { padding: 60px 0 80px; }

/* ── Header ── */
.sp-header { text-align: center; margin-bottom: 52px; }
.sp-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .7rem; font-weight: 500; letter-spacing: .14em;
    text-transform: uppercase; color: var(--gold); margin-bottom: 12px;
}
.sp-eyebrow::before, .sp-eyebrow::after {
    content: ''; width: 20px; height: 1px; background: var(--gold); opacity: .5;
}
.sp-header h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 500; line-height: 1.15;
    letter-spacing: -.02em; color: var(--text);
}
.sp-header h1 em { font-style: italic; color: var(--gold); }
.sp-header p { font-size: .88rem; color: var(--muted); max-width: 460px; margin: 10px auto 0; line-height: 1.7; }

/* ── Errors ── */
.sp-errors {
    background: #fef2f2; border: 1px solid #fecaca;
    border-radius: var(--r); padding: 14px 18px; margin-bottom: 28px;
}
.sp-errors ul { margin: 0; padding-left: 18px; }
.sp-errors li { font-size: .8rem; color: #dc2626; }

/* ── Plan grid ── */
.sp-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 18px;
}

/* ── Plan card ── */
.sp-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    padding: 28px 24px 24px;
    display: flex; flex-direction: column;
    transition: transform var(--t), border-color var(--t), box-shadow var(--t);
    position: relative; overflow: hidden;
    cursor: pointer;
}
.sp-card:hover {
    transform: translateY(-5px);
    border-color: var(--gold-bd);
    box-shadow: 0 14px 36px rgba(0,0,0,.09), 0 0 0 1px rgba(200,135,58,.12);
}
.sp-card.popular {
    border-color: var(--gold);
    box-shadow: 0 8px 28px rgba(200,135,58,.18);
}

/* Popular ribbon */
.sp-ribbon {
    position: absolute; top: 0; right: 0;
    background: var(--gold); color: #fff;
    font-size: .66rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    padding: 4px 16px;
    border-bottom-left-radius: 10px;
}

/* Card header */
.sp-card-head { margin-bottom: 20px; }
.sp-plan-icon {
    width: 44px; height: 44px; border-radius: 11px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    display: grid; place-items: center; margin-bottom: 14px;
}
.sp-plan-icon svg { width: 20px; height: 20px; color: var(--gold); }
.sp-plan-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.2rem; font-weight: 600;
    letter-spacing: -.01em; color: var(--text);
    margin-bottom: 2px;
}
.sp-plan-desc { font-size: .78rem; color: var(--muted); }

/* Price */
.sp-price-row { margin-bottom: 20px; }
.sp-price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2rem; font-weight: 600;
    color: var(--gold); line-height: 1; letter-spacing: -.02em;
}
.sp-price-unit { font-size: .78rem; font-weight: 400; color: var(--muted); font-family: 'DM Sans', sans-serif; margin-left: 4px; }

/* Features list */
.sp-features { list-style: none; padding: 0; margin: 0 0 24px; display: flex; flex-direction: column; gap: 8px; }
.sp-feature {
    display: flex; align-items: center; gap: 9px;
    font-size: .8rem; color: var(--muted);
}
.sp-feature-dot {
    width: 18px; height: 18px; border-radius: 50%;
    background: var(--green-bg); border: 1px solid var(--green-bd);
    display: grid; place-items: center; flex-shrink: 0;
}
.sp-feature-dot svg { width: 10px; height: 10px; color: var(--green); }

/* CTA */
.sp-cta {
    margin-top: auto;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 11px 20px; border-radius: 10px;
    background: var(--gold-bg); border: 1.5px solid var(--gold-bd);
    color: var(--gold); font-size: .84rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t); width: 100%;
}
.sp-cta:hover,
.sp-card.popular .sp-cta {
    background: var(--gold); border-color: var(--gold); color: #fff;
}
.sp-cta svg { width: 14px; height: 14px; }

/* ══════════════════════════════
   REVIEW MODAL
══════════════════════════════ */
.rm-overlay {
    position: fixed; inset: 0; z-index: 1000;
    background: rgba(10,10,8,.65);
    backdrop-filter: blur(6px);
    display: none; align-items: center; justify-content: center;
    padding: 20px;
}
.rm-overlay.open { display: flex; }
.rm-box {
    background: var(--surface);
    border-radius: 18px; width: 100%; max-width: 560px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,.2);
    animation: rmIn .32s cubic-bezier(.4,0,.2,1) both;
}
@keyframes rmIn { from { opacity:0; transform:scale(.96) translateY(10px); } to { opacity:1; transform:none; } }

.rm-head {
    background: var(--text);
    padding: 22px 26px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
}
.rm-head::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 80% at 20% 50%, rgba(200,135,58,.18) 0%, transparent 65%);
    pointer-events: none;
}
.rm-head-text { position: relative; z-index: 1; }
.rm-head h4 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.2rem; font-weight: 500; color: #F0EDE8; margin: 0;
}
.rm-head p { font-size: .75rem; color: rgba(240,237,232,.45); margin-top: 2px; }
.rm-close {
    position: relative; z-index: 1;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.15);
    border-radius: 8px; width: 32px; height: 32px;
    display: grid; place-items: center; cursor: pointer; color: #F0EDE8;
    transition: background var(--t);
}
.rm-close:hover { background: rgba(255,255,255,.2); }
.rm-close svg { width: 16px; height: 16px; }

.rm-body { padding: 24px 26px; }

/* Selected plan badge */
.rm-plan-badge {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 16px; border-radius: 10px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    margin-bottom: 20px;
}
.rm-plan-badge-icon {
    width: 36px; height: 36px; border-radius: 8px;
    background: var(--gold); display: grid; place-items: center; flex-shrink: 0;
}
.rm-plan-badge-icon svg { width: 16px; height: 16px; color: #fff; }
.rm-plan-name { font-size: .9rem; font-weight: 600; color: var(--text); }
.rm-plan-price { font-size: .75rem; color: var(--muted); }

/* Fields */
.rm-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
.rm-field label {
    font-size: .72rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .06em; color: var(--muted);
}
.rm-field input, .rm-field .rm-readonly {
    padding: 10px 13px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: 9px; font-size: .84rem;
    font-family: 'DM Sans', sans-serif; color: var(--text);
    transition: border-color var(--t), box-shadow var(--t), background var(--t);
    width: 100%;
}
.rm-field input:focus {
    outline: none; border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(200,135,58,.1);
    background: var(--surface);
}
.rm-field .rm-readonly { color: var(--muted); cursor: default; }

.rm-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* Days stepper */
.rm-counter {
    display: flex; align-items: center;
    background: var(--bg); border: 1.5px solid var(--border); border-radius: 9px; overflow: hidden;
}
.rm-counter-btn {
    width: 42px; height: 42px; display: grid; place-items: center;
    background: none; border: none; cursor: pointer;
    color: var(--muted); font-size: 1.1rem; font-weight: 600;
    flex-shrink: 0; transition: background var(--t), color var(--t);
}
.rm-counter-btn:hover { background: var(--gold-bg); color: var(--gold); }
.rm-counter input {
    flex: 1; text-align: center; background: transparent;
    border: none; border-left: 1px solid var(--border); border-right: 1px solid var(--border);
    font-size: .88rem; font-weight: 600; color: var(--text); padding: 0; height: 42px;
}
.rm-counter input:focus { outline: none; }

/* Total highlight */
.rm-total-box {
    background: var(--green-bg); border: 1px solid var(--green-bd);
    border-radius: 10px; padding: 16px 18px;
    display: flex; align-items: center; justify-content: space-between;
    margin-top: 6px; margin-bottom: 4px;
}
.rm-total-label { font-size: .78rem; color: var(--green); font-weight: 500; }
.rm-total-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem; font-weight: 600; color: var(--green); letter-spacing: -.01em;
}

/* Summary review */
.rm-summary {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 10px; padding: 14px 16px; margin-top: 14px;
}
.rm-summary-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 5px 0; font-size: .8rem;
    border-bottom: 1px solid var(--border);
}
.rm-summary-row:last-child { border-bottom: none; }
.rm-summary-row span:first-child { color: var(--muted); }
.rm-summary-row span:last-child  { color: var(--text); font-weight: 600; }

/* Footer */
.rm-foot {
    padding: 16px 26px 24px;
    display: flex; gap: 10px;
}
.rm-btn-back {
    padding: 11px 20px; border-radius: 9px;
    border: 1.5px solid var(--border2); background: var(--surface);
    font-size: .83rem; font-weight: 500; color: var(--muted);
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t);
}
.rm-btn-back:hover { border-color: var(--gold); color: var(--gold); }
.rm-btn-confirm {
    flex: 1; padding: 11px 20px; border-radius: 9px;
    background: var(--gold); border: none; color: #fff;
    font-size: .85rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: background var(--t), transform var(--t);
    display: flex; align-items: center; justify-content: center; gap: 7px;
}
.rm-btn-confirm:hover { background: #a06828; transform: translateY(-1px); }
.rm-btn-confirm svg { width: 15px; height: 15px; }
</style>

<div class="sp-page">
<div class="container">

    {{-- Header --}}
    <div class="sp-header">
        <div class="sp-eyebrow">Boost Your Listing</div>
        <h1>Choose your <em>listing plan</em></h1>
        <p>Select the right plan to increase your property's visibility and reach more buyers faster.</p>
    </div>

    {{-- Errors --}}
    @if($errors->any())
    <div class="sp-errors">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Plan cards --}}
    <div class="sp-grid">
        @foreach($plans as $loop_index => $plan)
        @php $isPopular = $loop_index === 1; @endphp

        <div class="sp-card {{ $isPopular ? 'popular' : '' }}"
             onclick="openPlanModal({{ $plan->id }}, '{{ addslashes($plan->name) }}', {{ $plan->price_per_day }})">

            @if($isPopular)
                <div class="sp-ribbon">Most Popular</div>
            @endif

            <div class="sp-card-head">
                <div class="sp-plan-icon">
                    @if($loop_index === 0)
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    @elseif($loop_index === 1)
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @else
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>
                    @endif
                </div>
                <div class="sp-plan-name">{{ $plan->name }}</div>
                <div class="sp-plan-desc">Boost your property reach with {{ strtolower($plan->name) }}</div>
            </div>

            <div class="sp-price-row">
                <span class="sp-price">{{ number_format($plan->price_per_day) }}</span>
                <span class="sp-price-unit">RWF / day</span>
            </div>

            <ul class="sp-features">
                <li class="sp-feature">
                    <div class="sp-feature-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                    Featured listing badge
                </li>
                <li class="sp-feature">
                    <div class="sp-feature-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                    Higher search visibility
                </li>
                <li class="sp-feature">
                    <div class="sp-feature-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                    Priority search ranking
                </li>
                <li class="sp-feature">
                    <div class="sp-feature-dot"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4"/></svg></div>
                    More buyer views &amp; enquiries
                </li>
            </ul>

            <button type="button" class="sp-cta">
                Select Plan
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 13H4V11H12V4L20 12L12 20V13Z"/></svg>
            </button>

        </div>

        @endforeach
    </div>

</div>
</div>

{{-- ══ REVIEW MODAL ══ --}}
<div class="rm-overlay" id="rm-overlay" onclick="closeRmOnBg(event)">
    <div class="rm-box">

        <div class="rm-head">
            <div class="rm-head-text">
                <h4>Review Your Plan</h4>
                <p>Confirm the details before proceeding to payment</p>
            </div>
            <button class="rm-close" onclick="closePlanModal()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('plans.store') }}" id="plan-form">
            @csrf
            <input type="hidden" name="plan_id"       id="plan_id">
            <input type="hidden" name="property_id"   value="{{ $id }}">
            <input type="hidden" name="property_type" value="{{ $type }}">
            <input type="hidden" name="days"          id="days_hidden">

            <div class="rm-body">

                {{-- Selected plan badge --}}
                <div class="rm-plan-badge">
                    <div class="rm-plan-badge-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <div class="rm-plan-name" id="rm-plan-name">—</div>
                        <div class="rm-plan-price" id="rm-plan-price">— RWF / day</div>
                    </div>
                </div>

                {{-- Days stepper --}}
                <div class="rm-field">
                    <label>Number of Days <span style="color:#dc2626">*</span></label>
                    <div class="rm-counter">
                        <button type="button" class="rm-counter-btn" onclick="adjustDays(-1)">−</button>
                        <input type="number" id="rm-days" value="1" min="1" oninput="calcTotal()">
                        <button type="button" class="rm-counter-btn" onclick="adjustDays(1)">+</button>
                    </div>
                </div>

                {{-- Total --}}
                <div class="rm-total-box">
                    <span class="rm-total-label">Total Amount</span>
                    <span class="rm-total-value" id="rm-total">— RWF</span>
                </div>

                {{-- Summary --}}
                <div class="rm-summary">
                    <div class="rm-summary-row">
                        <span>Plan</span>
                        <span id="sum-plan">—</span>
                    </div>
                    <div class="rm-summary-row">
                        <span>Price per day</span>
                        <span id="sum-price">—</span>
                    </div>
                    <div class="rm-summary-row">
                        <span>Duration</span>
                        <span id="sum-days">—</span>
                    </div>
                    <div class="rm-summary-row">
                        <span>Total</span>
                        <span id="sum-total" style="color:var(--green)">—</span>
                    </div>
                </div>

            </div>

            <div class="rm-foot">
                <button type="button" class="rm-btn-back" onclick="closePlanModal()">
                    ← Choose Another
                </button>
                <button type="submit" class="rm-btn-confirm" onclick="syncDays()">
                    Confirm &amp; Continue
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14l-4-4 1.41-1.41L11 13.17l6.59-6.59L19 8l-8 8z"/></svg>
                </button>
            </div>

        </form>
    </div>
</div>

<script>
(function () {
    let selectedPrice = 0;

    window.openPlanModal = function (id, name, price) {
        selectedPrice = parseFloat(price);

        document.getElementById('plan_id').value     = id;
        document.getElementById('rm-plan-name').textContent = name;
        document.getElementById('rm-plan-price').textContent = price.toLocaleString() + ' RWF / day';

        document.getElementById('rm-days').value = 1;
        document.getElementById('sum-plan').textContent  = name;
        document.getElementById('sum-price').textContent = price.toLocaleString() + ' RWF';

        calcTotal();

        document.getElementById('rm-overlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.closePlanModal = function () {
        document.getElementById('rm-overlay').classList.remove('open');
        document.body.style.overflow = '';
    };

    window.closeRmOnBg = function (e) {
        if (e.target === document.getElementById('rm-overlay')) closePlanModal();
    };

    window.adjustDays = function (delta) {
        const input = document.getElementById('rm-days');
        const val   = Math.max(1, (parseInt(input.value) || 1) + delta);
        input.value = val;
        calcTotal();
    };

    window.calcTotal = function () {
        const days  = Math.max(1, parseInt(document.getElementById('rm-days').value) || 1);
        const total = selectedPrice * days;
        const fmt   = total.toLocaleString() + ' RWF';

        document.getElementById('rm-total').textContent     = fmt;
        document.getElementById('sum-days').textContent     = days + (days === 1 ? ' day' : ' days');
        document.getElementById('sum-total').textContent    = fmt;
    };

    window.syncDays = function () {
        document.getElementById('days_hidden').value = document.getElementById('rm-days').value;
    };

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closePlanModal();
    });
})();
</script>

@endsection