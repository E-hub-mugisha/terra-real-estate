@extends('layouts.users')
@section('title', 'My Service Reports')
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

    .sr-page { padding: 1.75rem 0 3rem; max-width: 1150px; margin: 0 auto; }

    /* ── Heading ── */
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

    .sr-new-btn {
        margin-left: auto; display: inline-flex; align-items: center; gap: .45rem;
        padding: .65rem 1.4rem; border-radius: 8px; font-size: .85rem; font-weight: 600;
        background: var(--accent); color: #fff; border: none; text-decoration: none; transition: background .2s;
        flex-shrink: 0;
    }
    .sr-new-btn:hover { background: var(--accent-lt); color: #fff; }

    /* ── Stat cards ── */
    .sr-stats { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    @media (max-width: 1050px) { .sr-stats { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 560px) { .sr-stats { grid-template-columns: 1fr; } }

    .sr-stat {
        background: #fff; border: 1px solid var(--border); border-radius: var(--radius);
        padding: 1.15rem 1.25rem; display: flex; align-items: center; gap: .9rem;
    }

    .sr-stat-icon {
        width: 40px; height: 40px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
    }
    .sr-stat-icon.total   { background: #D0520818; color: var(--accent); }
    .sr-stat-icon.draft   { background: #eef2ff; color: var(--draft); }
    .sr-stat-icon.paid    { background: #f0fdf4; color: var(--success); }
    .sr-stat-icon.pending { background: #fffbeb; color: var(--warning); }
    .sr-stat-icon.rejected{ background: #fef2f2; color: var(--danger); }

    .sr-stat-label { font-size: .73rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: .03em; font-weight: 600; margin-bottom: .2rem; }
    .sr-stat-value { font-size: 1.15rem; font-weight: 700; color: var(--text); }
    .sr-stat-value.accent { color: var(--accent); }
    .sr-stat-value.draft { color: var(--draft); }
    .sr-stat-value.warn { color: var(--warning); }
    .sr-stat-value.danger { color: var(--danger); }

    /* ── Alerts ── */
    .sr-alert {
        border-radius: 8px; padding: .85rem 1.1rem; font-size: .84rem;
        display: flex; gap: .6rem; align-items: flex-start; margin-bottom: 1.25rem;
    }
    .sr-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

    /* ── Draft banner ── */
    .sr-draft-banner {
        display: flex; align-items: center; gap: .75rem;
        background: #eef2ff; border: 1px solid #c7d2fe; color: #3730a3;
        border-radius: var(--radius); padding: .9rem 1.15rem; margin-bottom: 1.25rem; font-size: .84rem;
    }
    .sr-draft-banner strong { font-weight: 700; }

    /* ── Card ── */
    .sr-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }

    .sr-card-header {
        padding: 1.1rem 1.5rem; border-bottom: 1px solid var(--border); background: var(--surface);
        display: flex; align-items: center; gap: .5rem;
    }
    .sr-card-header h6 { margin: 0; font-size: .88rem; font-weight: 600; color: var(--text); }
    .sr-card-header span { margin-left: auto; font-size: .73rem; color: var(--muted); }

    /* ── Table ── */
    .sr-table-wrap { overflow-x: auto; }
    .sr-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .sr-table thead th {
        text-align: left; padding: .8rem 1.25rem; font-size: .72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .03em; color: var(--text-dim);
        background: var(--surface); border-bottom: 1px solid var(--border); white-space: nowrap;
    }
    .sr-table tbody td { padding: .9rem 1.25rem; border-bottom: 1px solid var(--border); vertical-align: middle; color: var(--text); }
    .sr-table tbody tr:last-child td { border-bottom: none; }
    .sr-table tbody tr:hover { background: #fffaf5; }
    .sr-table tbody tr.is-draft { background: #fafaff; }
    .sr-table tbody tr.is-draft:hover { background: #f2f2ff; }

    .sr-client-phone { font-size: .74rem; color: var(--muted); }
    .sr-amount { font-variant-numeric: tabular-nums; }
    .sr-amount.accent { color: var(--accent); font-weight: 700; }
    .sr-amount.muted { color: var(--muted); }

    /* ── Status pill ── */
    .sr-pill {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .3rem .75rem; border-radius: 20px; font-size: .72rem; font-weight: 600;
    }
    .sr-pill.draft     { background: #eef2ff; color: #3730a3; border: 1px solid #c7d2fe; }
    .sr-pill.pending   { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .sr-pill.approved  { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .sr-pill.rejected  { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .sr-pill-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .sr-view-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 7px;
        border: 1.5px solid var(--border); color: var(--text-dim);
        background: #fff; transition: all .15s; text-decoration: none;
    }
    .sr-view-btn:hover { border-color: var(--accent); color: var(--accent); background: #D0520808; }

    .sr-confirm-btn {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .4rem .8rem; border-radius: 7px; font-size: .76rem; font-weight: 600;
        border: 1.5px solid var(--draft); color: var(--draft); background: #fff;
        transition: all .15s; cursor: pointer; white-space: nowrap;
    }
    .sr-confirm-btn:hover { background: var(--draft); color: #fff; }

    .sr-row-actions { display: flex; align-items: center; gap: .4rem; }

    .sr-empty { text-align: center; color: var(--muted); padding: 3rem 1rem; font-size: .88rem; }
    .sr-empty svg { display: block; margin: 0 auto .6rem; color: var(--border); }
    .sr-empty-cta {
        display: inline-flex; align-items: center; gap: .4rem; margin-top: 1rem;
        padding: .55rem 1.2rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
        background: var(--accent); color: #fff; text-decoration: none;
    }
    .sr-empty-cta:hover { background: var(--accent-lt); color: #fff; }

    .sr-card-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border); background: var(--surface); }

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

    .sr-modal-summary {
        background: var(--surface); border: 1px solid var(--border); border-radius: 10px;
        padding: .9rem 1.1rem; margin-bottom: 1.1rem;
    }
    .sr-modal-summary-row {
        display: flex; justify-content: space-between; font-size: .82rem; padding: .3rem 0;
    }
    .sr-modal-summary-row .label { color: var(--text-dim); }
    .sr-modal-summary-row .value { font-weight: 600; color: var(--text); }

    .sr-form-label { font-size: .85rem; font-weight: 600; color: var(--text); margin-bottom: .4rem; display: block; }
    .sr-form-label .fw-normal { font-weight: 400; color: var(--muted); }

    .sr-form-control {
        width: 100%; border: 1.5px solid var(--border); border-radius: 8px;
        padding: .6rem .75rem; font-size: .92rem; color: var(--text);
        transition: border-color .15s, box-shadow .15s; font-family: inherit;
    }
    .sr-form-control:focus {
        border-color: var(--draft); box-shadow: 0 0 0 3px #6366f11c; outline: none;
    }
    textarea.sr-form-control { resize: none; }

    .sr-modal-calc {
        display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-top: 1rem;
    }
    .sr-calc-box {
        border-radius: 10px; padding: .85rem 1rem; border: 1px solid var(--border); background: var(--surface);
    }
    .sr-calc-box.terra { background: #D0520810; border-color: #D0520840; }
    .sr-calc-box .small-label { font-size: .7rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: .03em; margin-bottom: .2rem; }
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
                <line x1="8" y1="13" x2="16" y2="13"/>
                <line x1="8" y1="17" x2="13" y2="17"/>
            </svg>
        </div>
        <div>
            <h4>My Service Reports</h4>
            <p>Track the status of services you've submitted and your earnings.</p>
        </div>
        <a href="{{ route('consultant.service-reports.create') }}" class="sr-new-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            New Report
        </a>
    </div>

    @if (session('success'))
    <div class="sr-alert sr-alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0">
            <path d="M20 6 9 17l-5-5"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Stat cards ── --}}
    @php
        $totalReports   = $reports->total();
        $draftCount     = $reports->getCollection()->where('status', 'draft')->count();
        $approvedSum    = $reports->getCollection()->where('status', 'approved')->sum('consultant_amount');
        $pendingCount   = $reports->getCollection()->where('status', 'pending')->count();
        $rejectedCount  = $reports->getCollection()->where('status', 'rejected')->count();
    @endphp
    <div class="sr-stats">
        <div class="sr-stat">
            <div class="sr-stat-icon total">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <div class="sr-stat-label">Total Reports</div>
                <div class="sr-stat-value">{{ $totalReports }}</div>
            </div>
        </div>
        <div class="sr-stat">
            <div class="sr-stat-icon draft">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
            <div>
                <div class="sr-stat-label">Awaiting Confirmation</div>
                <div class="sr-stat-value draft">{{ $draftCount }}</div>
            </div>
        </div>
        <div class="sr-stat">
            <div class="sr-stat-icon paid">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
            </div>
            <div>
                <div class="sr-stat-label">Earnings (this page, approved)</div>
                <div class="sr-stat-value accent">{{ number_format($approvedSum) }} RWF</div>
            </div>
        </div>
        <div class="sr-stat">
            <div class="sr-stat-icon pending">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            </div>
            <div>
                <div class="sr-stat-label">Pending Review</div>
                <div class="sr-stat-value warn">{{ $pendingCount }}</div>
            </div>
        </div>
        <div class="sr-stat">
            <div class="sr-stat-icon rejected">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/></svg>
            </div>
            <div>
                <div class="sr-stat-label">Rejected</div>
                <div class="sr-stat-value danger">{{ $rejectedCount }}</div>
            </div>
        </div>
    </div>

    @if ($draftCount > 0)
    <div class="sr-draft-banner">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        <div>
            <strong>You have {{ $draftCount }} assigned {{ Str::plural('request', $draftCount) }} waiting on you.</strong>
            Confirm the actual amount charged to send them for Terra's approval.
        </div>
    </div>
    @endif

    {{-- ── Table card ── --}}
    <div class="sr-card">
        <div class="sr-card-header">
            <h6>Report History</h6>
            <span>{{ $reports->total() }} total</span>
        </div>

        <div class="sr-table-wrap">
            <table class="sr-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Date / Time</th>
                        <th>Amount</th>
                        <th>Your Share</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($reports as $report)
                    <tr class="{{ $report->status === 'draft' ? 'is-draft' : '' }}">
                        <td>
                            {{ $report->client_name }}
                            <div class="sr-client-phone">{{ $report->client_phone }}</div>
                        </td>
                        <td>{{ $report->service->title }}</td>
                        <td>
                            {{ $report->service_date->format('d M Y') }}
                            <div class="sr-client-phone">{{ \Carbon\Carbon::parse($report->service_time)->format('H:i') }}</div>
                        </td>
                        <td class="sr-amount {{ $report->status === 'draft' ? 'muted' : '' }}">
                            {{ number_format($report->amount) }}
                            @if($report->status === 'draft')
                                <div class="sr-client-phone">estimated</div>
                            @endif
                        </td>
                        <td class="sr-amount accent">{{ number_format($report->consultant_amount) }}</td>
                        <td>
                            @php $st = $report->status; @endphp
                            <span class="sr-pill {{ $st }}">
                                <span class="sr-pill-dot"></span>
                                {{ $st === 'draft' ? 'Needs Confirmation' : ucfirst($st) }}
                            </span>
                        </td>
                        <td>
                            <div class="sr-row-actions">
                                @if($report->status === 'draft')
                                    <button type="button" class="sr-confirm-btn js-open-confirm"
                                        data-action="{{ route('consultant.service-reports.confirm.update', $report) }}"
                                        data-client="{{ $report->client_name }}"
                                        data-service="{{ $report->service->title }}"
                                        data-amount="{{ $report->amount }}"
                                        data-notes="{{ $report->notes }}"
                                        data-commission-type="{{ $report->commission_type }}"
                                        data-commission-value="{{ $report->commission_value }}">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg>
                                        Confirm
                                    </button>
                                @endif
                                @if(Route::has('consultant.service-reports.show'))
                                <a href="{{ route('consultant.service-reports.show', $report) }}" class="sr-view-btn" title="View report">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="sr-empty">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                You haven't submitted any service reports yet.
                                <div>
                                    <a href="{{ route('consultant.service-reports.create') }}" class="sr-empty-cta">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                                        Submit your first report
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($reports->hasPages())
        <div class="sr-card-footer">
            {{ $reports->links() }}
        </div>
        @endif
    </div>
</div>

{{-- ── Confirm draft report modal (vanilla, no Bootstrap) ── --}}
<div class="sr-modal-overlay" id="confirmReportOverlay">
    <div class="sr-modal-box" role="dialog" aria-modal="true" aria-labelledby="confirmModalTitle">
        <form method="POST" id="confirmReportForm">
            @csrf
            @method('PATCH')

            <div class="sr-modal-header">
                <h5 id="confirmModalTitle">Confirm Service Amount</h5>
                <button type="button" class="sr-modal-close js-close-confirm" aria-label="Close">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="sr-modal-body">
                <div class="sr-modal-summary">
                    <div class="sr-modal-summary-row">
                        <span class="label">Client</span>
                        <span class="value" id="modalClient">—</span>
                    </div>
                    <div class="sr-modal-summary-row">
                        <span class="label">Service</span>
                        <span class="value" id="modalService">—</span>
                    </div>
                </div>

                <label class="sr-form-label" for="modalAmountInput">Actual Amount Charged (RWF)</label>
                <input type="number" step="0.01" min="0" name="amount" id="modalAmountInput" class="sr-form-control" required>

                <div class="sr-modal-calc">
                    <div class="sr-calc-box terra">
                        <div class="small-label">Terra Commission</div>
                        <div class="calc-value" id="modalTerraAmount">0 RWF</div>
                    </div>
                    <div class="sr-calc-box">
                        <div class="small-label">You Receive</div>
                        <div class="calc-value" id="modalConsultantAmount">0 RWF</div>
                    </div>
                </div>

                <label class="sr-form-label mt-3" for="modalNotesInput" style="margin-top:1rem;">
                    Notes <span class="fw-normal">(optional)</span>
                </label>
                <textarea name="notes" id="modalNotesInput" class="sr-form-control" rows="2" placeholder="Anything Terra should know about this service..."></textarea>
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
    const confirmForm  = document.getElementById('confirmReportForm');
    const amountInput  = document.getElementById('modalAmountInput');
    const notesInput   = document.getElementById('modalNotesInput');
    const terraEl      = document.getElementById('modalTerraAmount');
    const consultantEl = document.getElementById('modalConsultantAmount');

    let currentCommissionType  = 'percentage';
    let currentCommissionValue = 0;

    function formatRWF(n) {
        return new Intl.NumberFormat('en-RW').format(Math.round(n)) + ' RWF';
    }

    function recalcModal() {
        const amount = parseFloat(amountInput.value) || 0;
        const terra = currentCommissionType === 'fixed'
            ? Math.min(currentCommissionValue, amount)
            : (amount * currentCommissionValue / 100);
        const consultant = amount - terra;

        terraEl.textContent = formatRWF(terra);
        consultantEl.textContent = formatRWF(consultant);
    }

    function openModal(trigger) {
        confirmForm.setAttribute('action', trigger.getAttribute('data-action'));
        document.getElementById('modalClient').textContent = trigger.getAttribute('data-client');
        document.getElementById('modalService').textContent = trigger.getAttribute('data-service');

        amountInput.value = trigger.getAttribute('data-amount');
        notesInput.value = trigger.getAttribute('data-notes') || '';

        currentCommissionType = trigger.getAttribute('data-commission-type');
        currentCommissionValue = parseFloat(trigger.getAttribute('data-commission-value'));

        recalcModal();

        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        amountInput.focus();
    }

    function closeModal() {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.js-open-confirm').forEach(btn => {
        btn.addEventListener('click', () => openModal(btn));
    });

    document.querySelectorAll('.js-close-confirm').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    // Click outside the box closes it
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });

    // Escape key closes it
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) closeModal();
    });

    amountInput.addEventListener('input', recalcModal);
})();
</script>
@endsection