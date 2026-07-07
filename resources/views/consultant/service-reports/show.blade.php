@extends('layouts.users')
@section('title', 'Service Report Detail')
@section('content')

<style>
    :root {
        --accent: #D05208;
        --accent-lt: #e4c990;
        --danger: #dc3545;
        --success: #198754;
        --warning: #f59e0b;
        --draft: #6366f1;
        --draft-dark: #4f46e5;
        --border: #e2e8f0;
        --surface: #f8fafc;
        --muted: #94a3b8;
        --text: #1e293b;
        --text-dim: #64748b;
        --radius: 10px;
    }

    .sr-page { padding: 1.75rem 0 3rem; max-width: 820px; margin: 0 auto; }

    .sr-heading { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.75rem; flex-wrap: wrap; }

    .sr-heading-icon {
        width: 44px; height: 44px; border-radius: 10px;
        background: linear-gradient(135deg, #D0520822, #D0520844);
        border: 1px solid #D0520855;
        display: flex; align-items: center; justify-content: center;
        color: var(--accent); flex-shrink: 0;
    }

    .sr-heading h4 { font-size: 1.2rem; font-weight: 700; color: var(--text); margin: 0; }
    .sr-heading p { font-size: .82rem; color: var(--text-dim); margin: .15rem 0 0; }

    .sr-back {
        margin-left: auto; display: inline-flex; align-items: center; gap: .4rem;
        font-size: .82rem; font-weight: 600; color: var(--text-dim); text-decoration: none;
        padding: .55rem 1rem; border: 1.5px solid var(--border); border-radius: 8px; transition: all .15s;
        flex-shrink: 0;
    }
    .sr-back:hover { border-color: var(--accent); color: var(--accent); }

    .sr-status-banner {
        display: flex; align-items: center; gap: .75rem;
        padding: 1rem 1.25rem; border-radius: var(--radius); margin-bottom: 1.25rem; font-size: .88rem;
    }
    .sr-status-banner.draft    { background: #eef2ff; border: 1px solid #c7d2fe; color: #3730a3; }
    .sr-status-banner.pending  { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
    .sr-status-banner.approved { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .sr-status-banner.rejected { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    .sr-status-banner-icon {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.6);
    }

    .sr-status-banner-body { flex: 1; }

    .sr-banner-cta {
        display: inline-flex; align-items: center; gap: .4rem; margin-top: .6rem;
        padding: .5rem 1rem; border-radius: 7px; font-size: .8rem; font-weight: 600;
        background: var(--draft); color: #fff; border: none; cursor: pointer; text-decoration: none;
        transition: background .15s;
    }
    .sr-banner-cta:hover { background: var(--draft-dark); color: #fff; }

    .sr-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); margin-bottom: 1.25rem; overflow: hidden; }

    .sr-card-header {
        display: flex; align-items: center; gap: .75rem;
        padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); background: var(--surface);
    }

    .sr-card-header-icon {
        width: 32px; height: 32px; border-radius: 8px; background: #D0520818;
        display: flex; align-items: center; justify-content: center; color: var(--accent); flex-shrink: 0;
    }

    .sr-card-header h6 { margin: 0; font-size: .88rem; font-weight: 600; color: var(--text); }
    .sr-card-body { padding: 1.5rem; }

    /* ── Simple grid replacing Bootstrap row/col ── */
    .sr-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem 1.5rem; }
    .sr-grid .sr-field-full { grid-column: 1 / -1; }
    @media (max-width: 560px) { .sr-grid { grid-template-columns: 1fr; } }

    .sr-field-label {
        font-size: .73rem; font-weight: 600; letter-spacing: .03em; color: var(--text-dim);
        text-transform: uppercase; margin-bottom: .3rem;
    }
    .sr-field-value { font-size: .92rem; color: var(--text); }

    .sr-breakdown-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: .65rem 0; font-size: .86rem; border-bottom: 1px dashed var(--border);
    }
    .sr-breakdown-row:last-child { border-bottom: none; }
    .sr-breakdown-row .label { color: var(--text-dim); }
    .sr-breakdown-row .value { font-weight: 600; color: var(--text); font-variant-numeric: tabular-nums; }
    .sr-breakdown-row.total .value { color: var(--accent); font-size: 1rem; }
    .sr-breakdown-row.payout .value { color: var(--success); font-size: 1rem; }
    .sr-breakdown-note { font-size: .74rem; color: var(--muted); margin-top: .5rem; }

    /* ══════════════ Vanilla modal (no Bootstrap) ══════════════ */
    .sr-modal-overlay {
        display: none; position: fixed; inset: 0; z-index: 1050;
        background: rgba(15, 23, 42, .5);
        align-items: center; justify-content: center; padding: 1rem;
    }
    .sr-modal-overlay.is-open { display: flex; }

    .sr-modal-box {
        background: #fff; border-radius: 14px; width: 100%; max-width: 480px;
        box-shadow: 0 20px 45px -12px rgba(30, 41, 59, .35);
        overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;
        animation: srModalIn .15s ease-out;
    }
    @keyframes srModalIn {
        from { opacity: 0; transform: translateY(-8px) scale(.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .sr-modal-header {
        display: flex; align-items: center; gap: .75rem;
        padding: 1.15rem 1.5rem; background: var(--surface); border-bottom: 1px solid var(--border);
    }
    .sr-modal-header-icon {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        background: #6366f11c; color: var(--draft);
        display: flex; align-items: center; justify-content: center;
    }
    .sr-modal-header h5 { margin: 0; font-size: .95rem; font-weight: 700; color: var(--text); }
    .sr-modal-close {
        margin-left: auto; width: 28px; height: 28px; border-radius: 6px;
        border: none; background: transparent; color: var(--text-dim);
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        transition: background .15s;
    }
    .sr-modal-close:hover { background: #e2e8f088; color: var(--text); }

    .sr-modal-body { padding: 1.5rem; overflow-y: auto; }
    .sr-modal-footer {
        display: flex; justify-content: flex-end; gap: .6rem;
        padding: 1.1rem 1.5rem; border-top: 1px solid var(--border); background: var(--surface);
    }

    .sr-form-label { font-size: .73rem; font-weight: 600; letter-spacing: .03em; color: var(--text-dim); text-transform: uppercase; margin-bottom: .45rem; display: block; }
    .sr-form-label .fw-normal { text-transform: none; letter-spacing: 0; font-size: .78rem; color: var(--muted); font-weight: 400; }

    .sr-form-control {
        width: 100%; border: 1.5px solid var(--border); border-radius: 8px;
        padding: .6rem .75rem; font-size: .92rem; color: var(--text);
        transition: border-color .15s, box-shadow .15s; font-family: inherit;
    }
    .sr-form-control:focus { border-color: var(--draft); box-shadow: 0 0 0 3px #6366f11c; outline: none; }
    textarea.sr-form-control { resize: none; }

    .sr-modal-calc { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-top: 1.1rem; }
    .sr-calc-box { border-radius: 10px; padding: .85rem 1rem; border: 1px solid var(--border); background: var(--surface); }
    .sr-calc-box.terra { background: #D0520810; border-color: #D0520840; }
    .sr-calc-box .small-label { font-size: .7rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: .03em; margin-bottom: .25rem; }
    .sr-calc-box .calc-value { font-size: 1.05rem; font-weight: 700; color: var(--text); font-variant-numeric: tabular-nums; }
    .sr-calc-box.terra .calc-value { color: var(--accent); }

    .sr-btn-cancel {
        font-size: .85rem; font-weight: 600; color: var(--text-dim);
        background: #fff; border: 1.5px solid var(--border); border-radius: 8px;
        padding: .55rem 1.1rem; cursor: pointer; transition: all .15s;
    }
    .sr-btn-cancel:hover { border-color: var(--muted); color: var(--text); }
    .sr-btn-confirm {
        font-size: .85rem; font-weight: 600; color: #fff;
        background: var(--draft); border: none; border-radius: 8px;
        padding: .55rem 1.1rem; display: inline-flex; align-items: center; gap: .4rem;
        cursor: pointer; transition: background .15s;
    }
    .sr-btn-confirm:hover { background: var(--draft-dark); }
</style>

<div class="sr-page">

    {{-- ── Heading ── --}}
    <div class="sr-heading">
        <div class="sr-heading-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
            </svg>
        </div>
        <div>
            <h4>Service Report #{{ $serviceReport->id }}</h4>
            <p>Submitted {{ $serviceReport->created_at->diffForHumans() }}</p>
        </div>
        <a href="{{ route('consultant.service-reports.index') }}" class="sr-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Back to My Reports
        </a>
    </div>

    {{-- ── Status banner ── --}}
    @php
        $st = $serviceReport->status;
        $bannerText = [
            'draft'    => 'This request was auto-assigned to you. Confirm the amount actually charged to submit it for review.',
            'pending'  => 'Your report is awaiting Terra\'s review.',
            'approved' => 'Your report has been approved and your payout is confirmed.',
            'rejected' => 'This report was rejected — see admin notes below if provided.',
        ][$st] ?? '';
    @endphp
    <div class="sr-status-banner {{ $st }}">
        <div class="sr-status-banner-icon">
            @if($st === 'approved')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
            @elseif($st === 'rejected')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>
            @elseif($st === 'draft')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            @else
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            @endif
        </div>
        <div class="sr-status-banner-body">
            <strong>{{ $st === 'draft' ? 'Needs Confirmation.' : ucfirst($st) . '.' }}</strong> {{ $bannerText }}
            @if($serviceReport->reviewed_at)
                <div style="font-size:.78rem;opacity:.85;margin-top:.15rem;">
                    Reviewed {{ $serviceReport->reviewed_at->diffForHumans() }}
                </div>
            @endif
            @if($st === 'draft')
                <div>
                    <button type="button" class="sr-banner-cta" id="openConfirmModalBtn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                        Confirm Amount &amp; Submit
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- ── Client & service ── --}}
    <div class="sr-card">
        <div class="sr-card-header">
            <div class="sr-card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <h6>Client &amp; Service Details</h6>
        </div>
        <div class="sr-card-body">
            <div class="sr-grid">
                <div>
                    <div class="sr-field-label">Client</div>
                    <div class="sr-field-value">{{ $serviceReport->client_name }}</div>
                </div>
                <div>
                    <div class="sr-field-label">Client Phone</div>
                    <div class="sr-field-value">{{ $serviceReport->client_phone }}</div>
                </div>
                <div>
                    <div class="sr-field-label">Service</div>
                    <div class="sr-field-value">{{ $serviceReport->service->title }}</div>
                </div>
                <div>
                    <div class="sr-field-label">Location</div>
                    <div class="sr-field-value">{{ $serviceReport->location }}</div>
                </div>
                <div>
                    <div class="sr-field-label">Date</div>
                    <div class="sr-field-value">{{ $serviceReport->service_date->format('d M Y') }}</div>
                </div>
                <div>
                    <div class="sr-field-label">Time</div>
                    <div class="sr-field-value">{{ \Carbon\Carbon::parse($serviceReport->service_time)->format('H:i') }}</div>
                </div>
                @if($serviceReport->notes)
                <div class="sr-field-full">
                    <div class="sr-field-label">{{ $st === 'draft' ? 'Message from Client Request' : 'Your Notes' }}</div>
                    <div class="sr-field-value">{{ $serviceReport->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Amount breakdown ── --}}
    <div class="sr-card">
        <div class="sr-card-header">
            <div class="sr-card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <h6>Amount Breakdown</h6>
        </div>
        <div class="sr-card-body">
            <div class="sr-breakdown-row total">
                <span class="label">{{ $st === 'draft' ? 'Estimated Amount' : 'Total Reported Amount' }}</span>
                <span class="value">{{ number_format($serviceReport->amount) }} RWF</span>
            </div>
            <div class="sr-breakdown-row">
                <span class="label">Terra Commission ({{ $serviceReport->commission_value }}{{ $serviceReport->commission_type === 'percentage' ? '%' : ' RWF' }})</span>
                <span class="value">-{{ number_format($serviceReport->terra_commission_amount) }} RWF</span>
            </div>
            <div class="sr-breakdown-row payout">
                <span class="label"><strong>{{ $st === 'draft' ? 'Estimated Payout' : 'Your Payout' }}</strong></span>
                <span class="value">{{ number_format($serviceReport->consultant_amount) }} RWF</span>
            </div>
            @if($st === 'draft')
                <div class="sr-breakdown-note">
                    This is based on the service's listed price. Confirm the actual amount charged to update these figures.
                </div>
            @endif
        </div>
    </div>

    {{-- ── Admin notes (if reviewed) ── --}}
    @if($serviceReport->admin_notes)
    <div class="sr-card">
        <div class="sr-card-header">
            <div class="sr-card-header-icon">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                </svg>
            </div>
            <h6>Admin Notes</h6>
        </div>
        <div class="sr-card-body">
            <div class="sr-field-value">{{ $serviceReport->admin_notes }}</div>
        </div>
    </div>
    @endif

</div>

{{-- ── Confirm draft report modal (vanilla, no Bootstrap) ── --}}
@if($st === 'draft')
<div class="sr-modal-overlay" id="confirmReportOverlay">
    <div class="sr-modal-box" role="dialog" aria-modal="true" aria-labelledby="confirmModalTitle">
        <form method="POST" action="{{ route('consultant.service-reports.confirm.update', $serviceReport) }}">
            @csrf
            @method('PATCH')

            <div class="sr-modal-header">
                <div class="sr-modal-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>
                </div>
                <h5 id="confirmModalTitle">Confirm Service Amount</h5>
                <button type="button" class="sr-modal-close js-close-confirm" aria-label="Close">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="sr-modal-body">
                <label class="sr-form-label" for="modalAmountInput">Actual Amount Charged (RWF)</label>
                <input type="number" step="0.01" min="0" name="amount" id="modalAmountInput"
                    class="sr-form-control" value="{{ old('amount', $serviceReport->amount) }}" required>

                <div class="sr-modal-calc">
                    <div class="sr-calc-box terra">
                        <div class="small-label">Terra Commission</div>
                        <div class="calc-value" id="modalTerraAmount">
                            {{ number_format($serviceReport->terra_commission_amount) }} RWF
                        </div>
                    </div>
                    <div class="sr-calc-box">
                        <div class="small-label">You Receive</div>
                        <div class="calc-value" id="modalConsultantAmount">
                            {{ number_format($serviceReport->consultant_amount) }} RWF
                        </div>
                    </div>
                </div>

                <label class="sr-form-label mt-3" for="modalNotesInput" style="margin-top:1rem;">
                    Notes <span class="fw-normal">(optional)</span>
                </label>
                <textarea name="notes" id="modalNotesInput" class="sr-form-control" rows="2"
                    placeholder="Anything Terra should know about this service...">{{ old('notes', $serviceReport->notes) }}</textarea>
            </div>

            <div class="sr-modal-footer">
                <button type="button" class="sr-btn-cancel js-close-confirm">Cancel</button>
                <button type="submit" class="sr-btn-confirm">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                    Confirm &amp; Submit for Approval
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const overlay      = document.getElementById('confirmReportOverlay');
    const openBtn       = document.getElementById('openConfirmModalBtn');
    const amountInput  = document.getElementById('modalAmountInput');
    const terraEl      = document.getElementById('modalTerraAmount');
    const consultantEl = document.getElementById('modalConsultantAmount');

    const commissionType  = @json($serviceReport->commission_type);
    const commissionValue = {{ $serviceReport->commission_value }};

    function formatRWF(n) {
        return new Intl.NumberFormat('en-RW').format(Math.round(n)) + ' RWF';
    }

    function recalcModal() {
        const amount = parseFloat(amountInput.value) || 0;
        const terra = commissionType === 'fixed'
            ? Math.min(commissionValue, amount)
            : (amount * commissionValue / 100);
        const consultant = amount - terra;

        terraEl.textContent = formatRWF(terra);
        consultantEl.textContent = formatRWF(consultant);
    }

    function openModal() {
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        amountInput.focus();
    }

    function closeModal() {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    if (openBtn) openBtn.addEventListener('click', openModal);

    overlay.querySelectorAll('.js-close-confirm').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) closeModal();
    });

    amountInput.addEventListener('input', recalcModal);
})();
</script>
@endif

@endsection