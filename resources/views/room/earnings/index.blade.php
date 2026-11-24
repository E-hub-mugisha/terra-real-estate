@extends('layouts.agents')
@section('title', 'Earnings')

@section('content')
@php
    $sum = fn ($s) => (float) ($totals[$s]->total ?? 0);
    $max = max($months->max(), 1);
@endphp
<div class="tp-page-head">
    <div>
        <h1>Earnings</h1>
        <p>Commissions from listing packages, closed deals and confirmed referrals. Terra approves and pays them.</p>
    </div>
</div>

<div class="tp-stats">
    @foreach ([
        ['Paid out', $sum('paid'), 'check', 'paid'],
        ['Approved, to be paid', $sum('approved'), 'credit', 'approved'],
        ['Pending approval', $sum('pending'), 'clock', 'pending'],
        ['Total earned', $sum('paid') + $sum('approved'), 'trending', null],
    ] as [$label, $value, $icon, $status])
        <a href="{{ route('room.earnings', array_filter(['status' => $status])) }}" class="tp-stat">
            <div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span><span style="font-size:.72rem;font-weight:700;color:var(--tu-muted)">RWF</span></div>
            <div><div class="tp-stat-val">{{ number_format($value) }}</div><div class="tp-stat-label">{{ $label }}</div></div>
        </a>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header">Last 6 months</div>
            <div class="card-body">
                <div class="tp-bars">
                    @foreach ($months as $ym => $amount)
                        <div title="{{ \Carbon\Carbon::parse($ym . '-01')->format('M Y') }}: {{ number_format($amount) }} RWF">
                            <b>{{ $amount ? number_format($amount / 1000, $amount < 10000 ? 1 : 0) . 'k' : '' }}</b>
                            <i style="height:{{ max(round($amount / $max * 100), 3) }}%"></i>
                            <small>{{ \Carbon\Carbon::parse($ym . '-01')->format('M') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header tp-card-head">
                Commissions
                <nav class="tp-box-tabs" aria-label="Filter by status">
                    @foreach ([null => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'paid' => 'Paid'] as $key => $label)
                        <a href="{{ route('room.earnings', array_filter(['status' => $key])) }}" class="{{ request('status') == $key ? 'is-active' : '' }}" style="padding:6px 10px;font-size:.76rem;color:inherit">{{ $label }}</a>
                    @endforeach
                </nav>
            </div>
            @if ($commissions->isEmpty())
                <div class="tp-card-empty"><div class="tu-empty-ico"><x-tu-icon name="credit" /></div><strong>No commissions yet</strong>They appear as soon as a payment or deal is recorded.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>Source</th><th>Type</th><th class="text-end">Base</th><th class="text-end">Rate</th><th class="text-end">Amount</th><th>Status</th></tr></thead>
                        <tbody>
                            @foreach ($commissions as $c)
                                <tr>
                                    <td>
                                        <strong style="color:var(--tu-ink);font-size:.86rem;display:block">{{ \Illuminate\Support\Str::limit($c->listable->title ?? ($c->notes ?: 'Referral'), 40) }}</strong>
                                        <span style="font-size:.74rem;color:var(--tu-muted)">{{ $c->created_at->format('j M Y') }}</span>
                                    </td>
                                    <td><span class="tu-badge">{{ $c->typeLabel() }}</span></td>
                                    <td class="text-end" style="font-size:.84rem">{{ $c->base_amount ? number_format($c->base_amount) : '—' }}</td>
                                    <td class="text-end" style="font-size:.84rem">{{ $c->rate ? rtrim(rtrim(number_format($c->rate, 2), '0'), '.') . '%' : 'Flat' }}</td>
                                    <td class="text-end" style="font-weight:800;color:var(--tu-ink);white-space:nowrap">{{ number_format($c->amount) }} <small style="color:var(--tu-muted)">{{ $c->currency }}</small></td>
                                    <td>@include('room._status', ['status' => $c->status])@if ($c->paid_at)<div style="font-size:.72rem;color:var(--tu-subtle)">{{ $c->paid_at->format('j M') }}</div>@endif</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        <div class="mt-3">{{ $commissions->links() }}</div>
    </div>
</div>
@endsection
