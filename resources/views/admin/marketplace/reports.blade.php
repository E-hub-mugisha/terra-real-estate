@extends('layouts.app')
@section('title', 'Reports')

@section('content')
<div class="tp-page-head">
    <div>
        <h1>Reports</h1>
        <p>Marketplace health over the last six months. Export any dataset to CSV for Excel.</p>
    </div>
    <div style="display:flex;gap:6px;flex-wrap:wrap">
        @foreach (['payments' => 'Payments', 'commissions' => 'Commissions', 'listings' => 'Listings', 'inquiries' => 'Inquiries', 'users' => 'Users'] as $ds => $label)
            <a href="{{ route('admin.marketplace.export', $ds) }}" class="tu-btn tu-btn-sm"><x-tu-icon name="download" /> {{ $label }}</a>
        @endforeach
    </div>
</div>

<div class="tp-stats">
    @foreach ([
        ['Package revenue (RWF)', $kpis['revenue'], 'credit'],
        ['Commissions paid (RWF)', $kpis['commissions_paid'], 'check'],
        ['Commissions due (RWF)', $kpis['commissions_due'], 'clock'],
        ['Live listings', $kpis['live'], 'layers'],
        ['Inquiries', $kpis['inquiries'], 'mail'],
        ['Inquiry response rate', $kpis['response_rate'] . '%', 'percent'],
        ['Offers accepted', $kpis['offers_accepted'], 'tag'],
        ['Viewings completed', $kpis['viewings_done'], 'calendar'],
    ] as [$label, $v, $icon])
        <div class="tp-stat"><div class="tp-stat-top"><span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span></div><div><div class="tp-stat-val">{{ is_numeric($v) ? number_format($v) : $v }}</div><div class="tp-stat-label">{{ $label }}</div></div></div>
    @endforeach
</div>

<div class="row g-3">
    @foreach (['revenue' => ['Revenue (RWF)', true], 'listings' => ['New listings', false], 'inquiries' => ['Inquiries', false], 'users' => ['New users', false]] as $key => [$title, $money])
        @php $data = $months->mapWithKeys(fn ($m) => [$m => (float) ($series[$key][$m] ?? 0)]); $max = max($data->max(), 1); @endphp
        <div class="col-md-6 col-xl-3">
            <div class="card h-100">
                <div class="card-header tp-card-head">{{ $title }} <span style="font-size:.8rem;color:var(--tu-muted);font-weight:700">{{ number_format($data->sum()) }}</span></div>
                <div class="card-body">
                    <div class="tp-bars" style="height:130px;gap:8px" role="img" aria-label="{{ $title }} by month: {{ $data->map(fn ($v, $m) => \Carbon\Carbon::parse($m . '-01')->format('M') . ' ' . number_format($v))->implode(', ') }}">
                        @foreach ($data as $m => $v)
                            <div title="{{ \Carbon\Carbon::parse($m . '-01')->format('M Y') }}: {{ number_format($v) }}">
                                <b>{{ $v ? ($money && $v >= 1000 ? number_format($v / 1000) . 'k' : number_format($v)) : '' }}</b>
                                <i style="height:{{ max(round($v / $max * 100), 3) }}%"></i>
                                <small>{{ \Carbon\Carbon::parse($m . '-01')->format('M') }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header">Most viewed listings</div>
            @if ($topListings->isEmpty())
                <div class="tp-card-empty">No listings yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Listing</th><th class="text-end">Views</th><th class="text-end">Inquiries</th></tr></thead>
                        <tbody>
                            @foreach ($topListings as $l)
                                <tr><td>@include('room._listing', ['listing' => $l])</td><td class="text-end" style="font-weight:700">{{ number_format($l->views_count) }}</td><td class="text-end">{{ $l->inquiries_count }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card h-100">
            <div class="card-header">Top earners</div>
            @if ($topEarners->isEmpty())
                <div class="tp-card-empty">No approved commissions yet.</div>
            @else
                <ul class="tp-list">
                    @foreach ($topEarners as $u)
                        <li><span class="tu-avatar">{{ strtoupper(mb_substr($u->name, 0, 1)) }}</span><span class="tp-list-main"><strong>{{ $u->name }}</strong><span>{{ $u->roleLabel() }}</span></span><strong style="font-size:.84rem;color:var(--tu-ink);white-space:nowrap">{{ number_format($u->earned) }}</strong></li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card h-100">
            <div class="card-header">Users by role</div>
            @php $totalUsers = max($roles->sum(), 1); @endphp
            <ul class="tp-list">
                @foreach ($roles->sortDesc() as $role => $n)
                    <li style="flex-wrap:wrap;gap:6px">
                        <span class="tp-list-main"><strong>{{ ucfirst($role) }}</strong></span>
                        <strong style="font-size:.84rem;color:var(--tu-ink)">{{ $n }}</strong>
                        <div class="tp-meter" style="flex-basis:100%"><i style="width:{{ round($n / $totalUsers * 100) }}%"></i></div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
