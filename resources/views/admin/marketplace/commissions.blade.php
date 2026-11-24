@extends('layouts.app')
@section('title', 'Commissions')

@section('content')
@php $t = fn ($s, $f = 'total') => (float) ($totals[$s]->{$f} ?? 0); $status = request('status', 'pending'); @endphp
<div class="tp-page-head">
    <div>
        <h1>Commissions</h1>
        <p>Agent and partner earnings from listing fees, deals and referrals. Approve them, then mark them paid once sent.</p>
    </div>
    <div style="display:flex;gap:8px">
        <a href="{{ route('admin.marketplace.settings') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="percent" /> Rates</a>
        <a href="{{ route('admin.marketplace.export', 'commissions') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="download" /> Export CSV</a>
    </div>
</div>

<div class="tp-stats">
    @foreach ([['Pending approval', 'pending', 'clock'], ['Approved, unpaid', 'approved', 'credit'], ['Paid', 'paid', 'check']] as [$label, $s, $icon])
        <a href="{{ route('admin.marketplace.commissions', ['status' => $s]) }}" class="tp-stat"><div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span><span style="font-size:.72rem;font-weight:700;color:var(--tu-muted)">{{ (int) $t($s, 'n') }}</span></div><div><div class="tp-stat-val">{{ number_format($t($s)) }}</div><div class="tp-stat-label">{{ $label }} (RWF)</div></div></a>
    @endforeach
</div>

<div class="tp-toolbar">
    @include('admin.marketplace._tabs', ['param' => 'status', 'current' => $status, 'options' => ['pending' => 'Pending', 'approved' => 'Approved', 'paid' => 'Paid', 'cancelled' => 'Cancelled', 'all' => 'All']])
    @include('admin.marketplace._tabs', ['param' => 'role', 'current' => request('role', ''), 'options' => ['' => 'Everyone', 'agent' => 'Agents', 'partner' => 'Partners']])
</div>

@if ($commissions->isEmpty())
    @include('room._empty', ['icon' => 'credit', 'title' => 'No commissions', 'text' => 'Commissions are created automatically from confirmed payments, recorded deals and converted referrals.'])
@else
    <form method="POST" action="{{ route('admin.marketplace.commissions.bulk') }}" id="bulkForm">@csrf</form>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th style="width:36px"><input type="checkbox" aria-label="Select all" data-check-all></th><th>Earner</th><th>Source</th><th class="text-end">Base</th><th class="text-end">Rate</th><th class="text-end">Amount</th><th>Status</th><th class="text-end"></th></tr></thead>
                <tbody>
                    @foreach ($commissions as $c)
                        <tr>
                            <td>@if (in_array($c->status, ['pending', 'approved'], true))<input type="checkbox" name="ids[]" value="{{ $c->id }}" form="bulkForm" aria-label="Select commission {{ $c->id }}">@endif</td>
                            <td><strong style="color:var(--tu-ink);display:block">{{ $c->user->name ?? '—' }}</strong><span style="font-size:.74rem;color:var(--tu-muted)">{{ ucfirst($c->role) }} · {{ $c->user->phone ?? '' }}</span></td>
                            <td style="font-size:.84rem"><span class="tu-badge">{{ $c->typeLabel() }}</span> {{ \Illuminate\Support\Str::limit($c->listable->title ?? ($c->notes ?: ''), 36) }}<div style="font-size:.72rem;color:var(--tu-subtle)">{{ $c->created_at->format('j M Y') }}</div></td>
                            <td class="text-end" style="font-size:.84rem">{{ $c->base_amount ? number_format($c->base_amount) : '—' }}</td>
                            <td class="text-end" style="font-size:.84rem">{{ $c->rate ? rtrim(rtrim(number_format($c->rate, 2), '0'), '.') . '%' : 'Flat' }}</td>
                            <td class="text-end" style="font-weight:800;color:var(--tu-ink);white-space:nowrap">{{ number_format($c->amount) }} <small>{{ $c->currency }}</small></td>
                            <td>@include('room._status', ['status' => $c->status])@if ($c->paid_at)<div style="font-size:.72rem;color:var(--tu-subtle)">{{ $c->paid_at->format('j M') }}</div>@endif</td>
                            <td class="text-end">
                                <div class="tp-item-actions" style="flex-wrap:nowrap">
                                    @if ($c->status === 'pending')
                                        <form method="POST" action="{{ route('admin.marketplace.commissions.update', $c) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button class="tu-btn tu-btn-primary tu-btn-sm">Approve</button></form>
                                    @endif
                                    @if (in_array($c->status, ['pending', 'approved'], true))
                                        <form method="POST" action="{{ route('admin.marketplace.commissions.update', $c) }}" onsubmit="return confirm('Mark {{ number_format($c->amount) }} {{ $c->currency }} as paid to {{ addslashes($c->user->name ?? '') }}?')">@csrf @method('PATCH')<input type="hidden" name="status" value="paid"><button class="tu-btn tu-btn-sm">Mark paid</button></form>
                                        <form method="POST" action="{{ route('admin.marketplace.commissions.update', $c) }}" onsubmit="return confirm('Cancel this commission?')">@csrf @method('PATCH')<input type="hidden" name="status" value="cancelled"><button class="tu-btn tu-btn-sm tu-btn-ghost" aria-label="Cancel commission"><x-tu-icon name="x" /></button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
            <span style="font-size:.84rem;color:var(--tu-muted)">With selected:</span>
            <button form="bulkForm" name="status" value="approved" class="tu-btn tu-btn-sm">Approve</button>
            <button form="bulkForm" name="status" value="paid" class="tu-btn tu-btn-sm tu-btn-primary" onclick="return confirm('Mark the selected commissions as paid?')">Mark paid</button>
        </div>
    </div>
    <div class="mt-3">{{ $commissions->links() }}</div>
@endif
@endsection

@push('scripts')
<script>
    document.querySelector('[data-check-all]')?.addEventListener('change', (e) => {
        document.querySelectorAll('input[name="ids[]"]').forEach(cb => { cb.checked = e.target.checked; });
    });
</script>
@endpush
