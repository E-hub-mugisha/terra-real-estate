{{-- resources/views/consultant/service-reports/show.blade.php --}}
{{-- NOTE: the consultant ServiceReportController you shared has no show()
     method/route yet — add one (e.g. Route::get('service-reports/{serviceReport}', ...))
     that authorizes the report belongs to Auth::user()->consultant before this
     view is reachable. --}}
@extends('layouts.app')
@section('title', 'Service Report Detail')
@section('content')

<style>
    :root {
        --accent: #D05208;
        --accent-lt: #e4c990;
        --danger: #dc3545;
        --success: #198754;
        --warning: #f59e0b;
        --border: #e2e8f0;
        --surface: #f8fafc;
        --muted: #94a3b8;
        --text: #1e293b;
        --text-dim: #64748b;
        --radius: 10px;
    }

    .sr-page { padding: 1.75rem 0 3rem; max-width: 820px; margin: 0 auto; }

    .sr-heading { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.75rem; }

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
    .sr-status-banner.pending  { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
    .sr-status-banner.approved { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .sr-status-banner.rejected { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

    .sr-status-banner-icon {
        width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,.6);
    }

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

    .sr-field-label {
        font-size: .73rem; font-weight: 600; letter-spacing: .03em; color: var(--text-dim);
        text-transform: uppercase; margin-bottom: .3rem;
    }
    .sr-field-value { font-size: .92rem; color: var(--text); margin-bottom: 1.1rem; }
    .sr-field-value:last-child { margin-bottom: 0; }

    .sr-breakdown-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: .65rem 0; font-size: .86rem; border-bottom: 1px dashed var(--border);
    }
    .sr-breakdown-row:last-child { border-bottom: none; }
    .sr-breakdown-row .label { color: var(--text-dim); }
    .sr-breakdown-row .value { font-weight: 600; color: var(--text); font-variant-numeric: tabular-nums; }
    .sr-breakdown-row.total .value { color: var(--accent); font-size: 1rem; }
    .sr-breakdown-row.payout .value { color: var(--success); font-size: 1rem; }
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
            @else
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            @endif
        </div>
        <div>
            <strong>{{ ucfirst($st) }}.</strong> {{ $bannerText }}
            @if($serviceReport->reviewed_at)
                <div style="font-size:.78rem;opacity:.85;margin-top:.15rem;">
                    Reviewed {{ $serviceReport->reviewed_at->diffForHumans() }}
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
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="sr-field-label">Client</div>
                    <div class="sr-field-value">{{ $serviceReport->client_name }}</div>
                </div>
                <div class="col-md-6">
                    <div class="sr-field-label">Client Phone</div>
                    <div class="sr-field-value">{{ $serviceReport->client_phone }}</div>
                </div>
                <div class="col-md-6">
                    <div class="sr-field-label">Service</div>
                    <div class="sr-field-value">{{ $serviceReport->service->title }}</div>
                </div>
                <div class="col-md-6">
                    <div class="sr-field-label">Location</div>
                    <div class="sr-field-value">{{ $serviceReport->location }}</div>
                </div>
                <div class="col-md-6">
                    <div class="sr-field-label">Date</div>
                    <div class="sr-field-value">{{ $serviceReport->service_date->format('d M Y') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="sr-field-label">Time</div>
                    <div class="sr-field-value">{{ \Carbon\Carbon::parse($serviceReport->service_time)->format('H:i') }}</div>
                </div>
                @if($serviceReport->notes)
                <div class="col-12">
                    <div class="sr-field-label">Your Notes</div>
                    <div class="sr-field-value" style="margin-bottom:0;">{{ $serviceReport->notes }}</div>
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
                <span class="label">Total Reported Amount</span>
                <span class="value">{{ number_format($serviceReport->amount) }} RWF</span>
            </div>
            <div class="sr-breakdown-row">
                <span class="label">Terra Commission ({{ $serviceReport->commission_value }}{{ $serviceReport->commission_type === 'percentage' ? '%' : ' RWF' }})</span>
                <span class="value">-{{ number_format($serviceReport->terra_commission_amount) }} RWF</span>
            </div>
            <div class="sr-breakdown-row payout">
                <span class="label"><strong>Your Payout</strong></span>
                <span class="value">{{ number_format($serviceReport->consultant_amount) }} RWF</span>
            </div>
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
            <div class="sr-field-value" style="margin-bottom:0;">{{ $serviceReport->admin_notes }}</div>
        </div>
    </div>
    @endif

</div>
@endsection
