@extends('layouts.app')
@section('title', 'Payments')

@section('content')
@php $t = fn ($s, $f = 'total') => (float) ($totals[$s]->{$f} ?? 0); @endphp
<div class="tp-page-head">
    <div>
        <h1>Listing payments</h1>
        <p>Check the MoMo transaction ID, then confirm. Confirming starts the package (listing days, ads, spotlight) and creates commissions.</p>
    </div>
    <a href="{{ route('admin.marketplace.export', 'payments') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="download" /> Export CSV</a>
</div>

<div class="tp-stats">
    @foreach ([
        ['To verify', $t('processing', 'n'), 'clock', number_format($t('processing')) . ' RWF'],
        ['Confirmed', $t('completed', 'n'), 'check', number_format($t('completed')) . ' RWF'],
        ['Awaiting payment', $t('pending', 'n'), 'credit', number_format($t('pending')) . ' RWF'],
        ['Failed / rejected', $t('failed', 'n'), 'x', null],
    ] as [$label, $n, $icon, $sub])
        <div class="tp-stat"><div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span>@if ($sub)<span style="font-size:.72rem;font-weight:700;color:var(--tu-muted)">{{ $sub }}</span>@endif</div><div><div class="tp-stat-val">{{ number_format($n) }}</div><div class="tp-stat-label">{{ $label }}</div></div></div>
    @endforeach
</div>

<div class="tp-toolbar">
    @include('admin.marketplace._tabs', ['param' => 'status', 'current' => $status, 'options' => ['processing' => 'To verify', 'pending' => 'Awaiting payment', 'completed' => 'Confirmed', 'failed' => 'Failed', 'all' => 'All'], 'counts' => ['processing' => (int) $t('processing', 'n')]])
</div>

@if ($payments->isEmpty())
    @include('room._empty', ['icon' => 'credit', 'title' => $status === 'processing' ? 'Nothing to verify' : 'No payments', 'text' => 'Payments matching this filter appear here.'])
@else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Reference</th><th>Listing</th><th>Payer</th><th>Package</th><th class="text-end">Amount</th><th>Transaction</th><th>Status</th><th class="text-end"></th></tr></thead>
                <tbody>
                    @foreach ($payments as $p)
                        <tr>
                            <td><code style="font-size:.78rem">{{ $p->reference }}</code><div style="font-size:.72rem;color:var(--tu-subtle)">{{ $p->created_at->format('j M Y H:i') }}</div></td>
                            <td>@include('room._listing', ['listing' => $p->payable instanceof \Illuminate\Database\Eloquent\Model && method_exists($p->payable, 'thumbUrl') ? $p->payable : null])</td>
                            <td style="font-size:.84rem">{{ $p->user->name ?? '—' }}<div style="font-size:.74rem;color:var(--tu-muted)">{{ $p->phone_number }}</div></td>
                            <td style="font-size:.84rem;white-space:nowrap">
                                {{ $p->listingPackage ? ucfirst(\App\Services\Marketplace\PromotionService::normaliseTier($p->listingPackage->package_tier)) : '—' }}{{ $p->days ? ' · ' . $p->days . 'd' : '' }}
                                @if ($p->promotion)<div style="font-size:.72rem;color:var(--tu-success)">Running to {{ $p->promotion->ends_at->format('j M') }}</div>@endif
                            </td>
                            <td class="text-end" style="font-weight:800;color:var(--tu-ink);white-space:nowrap">{{ number_format($p->amount) }} <small>{{ $p->currency }}</small></td>
                            <td style="font-size:.8rem"><code>{{ $p->transaction_id ?: '—' }}</code>@if ($p->failure_reason)<div style="color:var(--tu-danger);font-size:.72rem">{{ $p->failure_reason }}</div>@endif</td>
                            <td>@include('room._status', ['status' => match ($p->status) { 'processing' => 'pending', 'completed' => 'paid', 'failed' => 'rejected', default => $p->status }])</td>
                            <td class="text-end">
                                @if (in_array($p->status, ['processing', 'pending'], true))
                                    <div class="tp-item-actions" style="flex-wrap:nowrap">
                                        <form method="POST" action="{{ route('admin.marketplace.payments.verify', $p) }}" onsubmit="return confirm('Confirm {{ number_format($p->amount) }} {{ $p->currency }} was received{{ $p->transaction_id ? ' (TX ' . $p->transaction_id . ')' : '' }}?')">
                                            @csrf @method('PATCH')<input type="hidden" name="decision" value="confirm">
                                            <button class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="check" /> Confirm</button>
                                        </form>
                                        <button type="button" class="tu-btn tu-btn-sm" data-modal-open="payRejectModal" data-action="{{ route('admin.marketplace.payments.verify', $p) }}">Reject</button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">{{ $payments->links() }}</div>
@endif

<div class="tu-modal" id="payRejectModal" role="dialog" aria-modal="true" aria-labelledby="payRejectTitle">
    <div class="tu-modal-box">
        <div class="tu-modal-head">
            <div><h3 id="payRejectTitle">Reject payment</h3><p>The payer can try again with a new transaction.</p></div>
            <button type="button" class="tu-btn tu-btn-icon tu-btn-ghost tu-btn-sm" data-modal-close aria-label="Close"><x-tu-icon name="x" /></button>
        </div>
        <form method="POST" action="#" class="tu-modal-body tu-stack" style="gap:14px">
            @csrf @method('PATCH')
            <input type="hidden" name="decision" value="reject">
            <div class="tu-field"><label for="prReason">Reason</label><input id="prReason" class="tu-input" name="reason" required maxlength="255" placeholder="e.g. Transaction ID not found on MoMo statement"></div>
            <button type="submit" class="tu-btn tu-btn-primary tu-btn-block">Reject payment</button>
        </form>
    </div>
</div>
@endsection
