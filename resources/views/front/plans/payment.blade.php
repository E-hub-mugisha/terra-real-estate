@extends('layouts.base')
@section('title', 'Plan Payment')
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

/* ── Page wrapper ── */
.pp-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 48px 20px;
}

/* ── Card ── */
.pp-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    width: 100%;
    max-width: 480px;
    box-shadow: 0 8px 40px rgba(0,0,0,.08);
    animation: ppIn .4s cubic-bezier(.4,0,.2,1) both;
}
@keyframes ppIn {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ── Card header ── */
.pp-head {
    background: #1A1714;
    padding: 28px 28px 24px;
    position: relative;
    overflow: hidden;
}
.pp-head::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 70% 80% at 15% 50%, rgba(200,135,58,.18) 0%, transparent 65%);
    pointer-events: none;
}
.pp-head-inner { position: relative; z-index: 1; }
.pp-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .65rem; font-weight: 500;
    letter-spacing: .14em; text-transform: uppercase;
    color: rgba(200,135,58,.8); margin-bottom: 8px;
}
.pp-eyebrow::before {
    content: ''; width: 16px; height: 1px; background: var(--gold); opacity: .6;
}
.pp-head h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem; font-weight: 500; color: #F0EDE8;
    letter-spacing: -.01em; margin: 0;
}

/* ── Plan summary ── */
.pp-summary {
    padding: 22px 28px 0;
}
.pp-plan-badge {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 16px; border-radius: 10px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    margin-bottom: 18px;
}
.pp-plan-icon {
    width: 36px; height: 36px; border-radius: 8px;
    background: var(--gold); display: grid; place-items: center; flex-shrink: 0;
}
.pp-plan-icon svg { width: 16px; height: 16px; color: #fff; }
.pp-plan-name  { font-size: .9rem; font-weight: 600; color: var(--text); }
.pp-plan-sub   { font-size: .73rem; color: var(--muted); margin-top: 1px; }

/* Order rows */
.pp-rows { display: flex; flex-direction: column; gap: 0; }
.pp-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 11px 0;
    border-bottom: 1px solid var(--border);
    font-size: .83rem;
}
.pp-row:last-child { border-bottom: none; }
.pp-row-label { color: var(--muted); display: flex; align-items: center; gap: 6px; }
.pp-row-label svg { width: 13px; height: 13px; color: var(--gold); }
.pp-row-val   { font-weight: 600; color: var(--text); }

/* Total row */
.pp-total {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 18px; margin-top: 14px; border-radius: 10px;
    background: var(--green-bg); border: 1px solid var(--green-bd);
}
.pp-total-label { font-size: .82rem; font-weight: 500; color: var(--green); }
.pp-total-val {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem; font-weight: 600; color: var(--green); letter-spacing: -.02em;
}
.pp-total-val span { font-size: .85rem; font-weight: 400; font-family: 'DM Sans', sans-serif; margin-left: 3px; }

/* ── Actions ── */
.pp-actions {
    padding: 20px 28px 28px;
    display: flex; flex-direction: column; gap: 10px;
}
.pp-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 13px 20px; border-radius: 10px;
    font-size: .86rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t); border: none; width: 100%;
    text-decoration: none;
}
.pp-btn svg { width: 16px; height: 16px; }
.pp-btn-momo {
    background: var(--gold); color: #fff;
}
.pp-btn-momo:hover { background: #a06828; transform: translateY(-1px); color: #fff; }

.pp-btn-later {
    background: var(--bg); border: 1.5px solid var(--border2);
    color: var(--muted);
}
.pp-btn-later:hover { border-color: var(--gold); color: var(--gold); }

.pp-divider {
    display: flex; align-items: center; gap: 10px;
    font-size: .72rem; color: var(--dim);
}
.pp-divider::before, .pp-divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
}

/* ══════════════════════════════
   MOMO MODAL
══════════════════════════════ */
.mm-overlay {
    position: fixed; inset: 0; z-index: 1000;
    background: rgba(10,10,8,.65);
    backdrop-filter: blur(6px);
    display: none; align-items: center; justify-content: center;
    padding: 20px;
}
.mm-overlay.open { display: flex; }
.mm-box {
    background: var(--surface);
    border-radius: 18px; width: 100%; max-width: 420px;
    overflow: hidden;
    box-shadow: 0 32px 80px rgba(0,0,0,.2);
    animation: mmIn .32s cubic-bezier(.4,0,.2,1) both;
}
@keyframes mmIn { from { opacity:0; transform:scale(.96) translateY(10px); } to { opacity:1; transform:none; } }

.mm-head {
    background: #1A1714;
    padding: 22px 24px;
    display: flex; align-items: center; justify-content: space-between;
    position: relative; overflow: hidden;
}
.mm-head::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 80% at 20% 50%, rgba(200,135,58,.15) 0%, transparent 65%);
    pointer-events: none;
}
.mm-head-text { position: relative; z-index: 1; }
.mm-head h4 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem; font-weight: 500; color: #F0EDE8; margin: 0;
}
.mm-head p { font-size: .73rem; color: rgba(240,237,232,.4); margin-top: 2px; }
.mm-close {
    position: relative; z-index: 1;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.15);
    border-radius: 8px; width: 32px; height: 32px;
    display: grid; place-items: center; cursor: pointer; color: #F0EDE8;
    transition: background var(--t);
}
.mm-close:hover { background: rgba(255,255,255,.2); }
.mm-close svg { width: 16px; height: 16px; }

.mm-body { padding: 22px 24px; }

/* MTN badge */
.mm-provider {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 14px; border-radius: 10px;
    background: rgba(255,188,0,.08); border: 1px solid rgba(255,188,0,.22);
    margin-bottom: 18px;
}
.mm-provider-dot {
    width: 32px; height: 32px; border-radius: 8px;
    background: #FFC200; display: grid; place-items: center; flex-shrink: 0;
}
.mm-provider-dot svg { width: 16px; height: 16px; color: #1A1714; }
.mm-provider-name { font-size: .85rem; font-weight: 600; color: var(--text); }
.mm-provider-sub  { font-size: .72rem; color: var(--muted); }

/* Phone field */
.mm-field { display: flex; flex-direction: column; gap: 5px; margin-bottom: 14px; }
.mm-field label {
    font-size: .72rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .06em; color: var(--muted);
}
.mm-phone-wrap { position: relative; }
.mm-phone-prefix {
    position: absolute; left: 12px; top: 50%;
    transform: translateY(-50%);
    font-size: .84rem; font-weight: 600; color: var(--muted);
    pointer-events: none;
}
.mm-phone-wrap input {
    width: 100%; padding: 11px 13px 11px 42px;
    background: var(--bg); border: 1.5px solid var(--border);
    border-radius: 9px; font-size: .88rem;
    font-family: 'DM Sans', sans-serif; color: var(--text);
    letter-spacing: .04em;
    transition: border-color var(--t), box-shadow var(--t), background var(--t);
}
.mm-phone-wrap input:focus {
    outline: none; border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(200,135,58,.1);
    background: var(--surface);
}
.mm-phone-wrap input::placeholder { color: var(--dim); letter-spacing: 0; }

/* Dial code box */
.mm-dial-box {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 10px; padding: 14px 16px;
    margin-bottom: 6px;
}
.mm-dial-title { font-size: .7rem; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; color: var(--dim); margin-bottom: 8px; }
.mm-dial-row { display: flex; align-items: center; gap: 10px; }
.mm-dial-code {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; border-radius: 6px;
    background: rgba(255,188,0,.12); border: 1px solid rgba(255,188,0,.25);
    font-size: .82rem; font-weight: 700; color: #8A6800; font-family: 'DM Mono', monospace;
}
.mm-dial-sep { font-size: .75rem; color: var(--dim); }
.mm-merchant {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; border-radius: 6px;
    background: var(--gold-bg); border: 1px solid var(--gold-bd);
    font-size: .82rem; font-weight: 700; color: var(--gold); font-family: 'DM Mono', monospace;
}

/* Modal footer */
.mm-foot { padding: 0 24px 24px; display: flex; flex-direction: column; gap: 8px; }
.mm-btn-confirm {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 13px 20px; border-radius: 10px;
    background: var(--gold); border: none; color: #fff;
    font-size: .86rem; font-weight: 600;
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: background var(--t), transform var(--t); width: 100%;
}
.mm-btn-confirm:hover { background: #a06828; transform: translateY(-1px); }
.mm-btn-confirm svg { width: 15px; height: 15px; }
.mm-btn-cancel {
    display: flex; align-items: center; justify-content: center;
    padding: 10px 20px; border-radius: 10px;
    background: transparent; border: 1.5px solid var(--border2);
    font-size: .82rem; font-weight: 500; color: var(--muted);
    font-family: 'DM Sans', sans-serif; cursor: pointer;
    transition: all var(--t); width: 100%;
}
.mm-btn-cancel:hover { border-color: var(--gold); color: var(--gold); }

.mm-secure {
    display: flex; align-items: center; justify-content: center; gap: 5px;
    font-size: .72rem; color: var(--dim); padding-top: 4px;
}
.mm-secure svg { width: 12px; height: 12px; color: var(--green); }
</style>

{{-- ── Page ── --}}
<div class="pp-page">
    <div class="pp-card">

        {{-- Header --}}
        <div class="pp-head">
            <div class="pp-head-inner">
                <div class="pp-eyebrow">Secure Checkout</div>
                <h2>Plan Payment</h2>
            </div>
        </div>

        {{-- Plan summary --}}
        <div class="pp-summary">
            <div class="pp-plan-badge">
                <div class="pp-plan-icon">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div>
                    <div class="pp-plan-name">{{ $order->plan->name }}</div>
                    <div class="pp-plan-sub">Featured listing plan</div>
                </div>
            </div>

            <div class="pp-rows">
                <div class="pp-row">
                    <span class="pp-row-label">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.86 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/></svg>
                        Price per day
                    </span>
                    <span class="pp-row-val">{{ number_format($order->price_per_day) }} RWF</span>
                </div>
                <div class="pp-row">
                    <span class="pp-row-label">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.9 4 3 4.9 3 6v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM5 8V6h14v2H5z"/></svg>
                        Duration
                    </span>
                    <span class="pp-row-val">{{ $order->days }} {{ $order->days == 1 ? 'day' : 'days' }}</span>
                </div>
                <div class="pp-row">
                    <span class="pp-row-label">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Status
                    </span>
                    <span class="pp-row-val" style="color:var(--gold)">Pending Payment</span>
                </div>
            </div>

            <div class="pp-total">
                <span class="pp-total-label">Total Amount</span>
                <span class="pp-total-val">
                    {{ number_format($order->total_price) }}<span>RWF</span>
                </span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="pp-actions">
            <button type="button" class="pp-btn pp-btn-momo" onclick="openMomo()">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/></svg>
                Pay with Mobile Money
            </button>

            <div class="pp-divider">or</div>

            <a href="{{ route('login') }}" class="pp-btn pp-btn-later">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 13H11v-5h1.5v5zm0-6H11V7h1.5v2z"/></svg>
                Pay Later
            </a>
        </div>

    </div>
</div>

{{-- ══ MOMO MODAL ══ --}}
<div class="mm-overlay" id="mm-overlay" onclick="closeMomoOnBg(event)">
    <div class="mm-box">

        <div class="mm-head">
            <div class="mm-head-text">
                <h4>Mobile Money Payment</h4>
                <p>MTN MoMo — secure & instant</p>
            </div>
            <button class="mm-close" onclick="closeMomo()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('plans.pay.momo') }}" id="momo-form">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <div class="mm-body">

                {{-- MTN provider badge --}}
                <div class="mm-provider">
                    <div class="mm-provider-dot">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14z"/></svg>
                    </div>
                    <div>
                        <div class="mm-provider-name">MTN Mobile Money</div>
                        <div class="mm-provider-sub">A push request will be sent to your phone</div>
                    </div>
                </div>

                {{-- Phone field --}}
                <div class="mm-field">
                    <label>MTN Phone Number <span style="color:#dc2626">*</span></label>
                    <div class="mm-phone-wrap">
                        <span class="mm-phone-prefix">+250</span>
                        <input type="tel" name="phone"
                               placeholder="78X XXX XXX"
                               required maxlength="12">
                    </div>
                </div>

                {{-- Dial / merchant info --}}
                <div class="mm-dial-box">
                    <div class="mm-dial-title">Manual Payment Option</div>
                    <div class="mm-dial-row">
                        <span class="mm-dial-code">*182*8*1#</span>
                        <span class="mm-dial-sep">Merchant</span>
                        <span class="mm-merchant">511725</span>
                    </div>
                </div>

            </div>

            <div class="mm-foot">
                <button type="submit" class="mm-btn-confirm">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Confirm Payment — {{ number_format($order->total_price) }} RWF
                </button>
                <button type="button" class="mm-btn-cancel" onclick="closeMomo()">
                    Cancel
                </button>
                <div class="mm-secure">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3z"/></svg>
                    256-bit encrypted · Powered by MTN MoMo
                </div>
            </div>

        </form>
    </div>
</div>

<script>
window.openMomo    = () => { document.getElementById('mm-overlay').classList.add('open'); document.body.style.overflow = 'hidden'; };
window.closeMomo   = () => { document.getElementById('mm-overlay').classList.remove('open'); document.body.style.overflow = ''; };
window.closeMomoOnBg = e => { if (e.target === document.getElementById('mm-overlay')) closeMomo(); };
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMomo(); });
</script>

@endsection