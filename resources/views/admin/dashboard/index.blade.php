@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
@php
    use Carbon\Carbon;

    $totalHouses  = \App\Models\House::count();
    $totalLands   = \App\Models\Land::count();
    $totalDesigns = \App\Models\ArchitecturalDesign::count();
    $totalAgents  = \App\Models\Agent::count();
    $pendingAgents = \App\Models\Agent::where('is_verified', false)->count();
    $totalUsers   = \App\Models\User::count();
    $totalClients = \App\Models\Client::count();

    $pendingHouses  = \App\Models\House::where('is_approved', false)->count();
    $pendingLands   = \App\Models\Land::where('is_approved', false)->count();
    $pendingDesigns = \App\Models\ArchitecturalDesign::where('is_approved', false)->count();
    $pendingTotal   = $pendingHouses + $pendingLands + $pendingDesigns;

    $paidFees    = \App\Models\ListingPayment::where('status', 'completed')->sum('amount');
    $pendingFees = \App\Models\ListingPayment::where('status', 'pending')->count();

    $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->startOfMonth()->subMonths($i));
    $perMonth = fn ($model) => $months->map(fn ($m) => $model::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count())->all();
    $chart = [
        'labels'  => $months->map(fn ($m) => $m->format('M'))->all(),
        'houses'  => $perMonth(\App\Models\House::class),
        'lands'   => $perMonth(\App\Models\Land::class),
        'designs' => $perMonth(\App\Models\ArchitecturalDesign::class),
    ];

    $recent = collect()
        ->merge(\App\Models\House::latest()->take(5)->get()->map(fn ($h) => ['title' => $h->title, 'type' => 'House', 'approved' => $h->is_approved, 'created' => $h->created_at, 'url' => route('admin.properties.houses.show', $h)]))
        ->merge(\App\Models\Land::latest()->take(5)->get()->map(fn ($l) => ['title' => $l->title, 'type' => 'Land', 'approved' => $l->is_approved, 'created' => $l->created_at, 'url' => route('admin.properties.lands.show', $l)]))
        ->merge(\App\Models\ArchitecturalDesign::latest()->take(5)->get()->map(fn ($d) => ['title' => $d->title, 'type' => 'Design', 'approved' => $d->is_approved, 'created' => $d->created_at, 'url' => route('admin.properties.architectural-designs.show', $d)]))
        ->sortByDesc('created')->values()->take(8);

    $newAgents = \App\Models\Agent::latest()->take(5)->get();
    $hour = now()->hour;
@endphp

<div class="tp-page-head">
    <div>
        <h1>Good {{ $hour < 12 ? 'morning' : ($hour < 18 ? 'afternoon' : 'evening') }}, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') ?: auth()->user()->name }}</h1>
        <p>Here's what's happening on Terra today · {{ now()->format('l, j F Y') }}</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a href="{{ route('admin.properties.houses.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="home" /> Add house</a>
        <a href="{{ route('admin.properties.lands.create') }}" class="tu-btn tu-btn-sm"><x-tu-icon name="land" /> Add land</a>
        <a href="{{ route('admin.architectural-designs.create') }}" class="tu-btn tu-btn-primary tu-btn-sm"><x-tu-icon name="ruler" /> Add design</a>
    </div>
</div>

@if ($pendingTotal > 0 || $pendingAgents > 0)
    <div class="alert d-flex align-items-center gap-3 flex-wrap" style="background:var(--tu-warn-50);color:var(--tu-warn)">
        <x-tu-icon name="clock" />
        <span><strong>Needs your review:</strong>
            @if ($pendingHouses) <a href="{{ route('admin.properties.houses.index') }}" style="color:inherit">{{ $pendingHouses }} {{ \Illuminate\Support\Str::plural('house', $pendingHouses) }}</a> · @endif
            @if ($pendingLands) <a href="{{ route('admin.properties.lands.index') }}" style="color:inherit">{{ $pendingLands }} {{ \Illuminate\Support\Str::plural('plot', $pendingLands) }}</a> · @endif
            @if ($pendingDesigns) <a href="{{ route('admin.architectural-designs.index') }}" style="color:inherit">{{ $pendingDesigns }} {{ \Illuminate\Support\Str::plural('design', $pendingDesigns) }}</a> · @endif
            @if ($pendingAgents) <a href="{{ route('admin.agents.index') }}" style="color:inherit">{{ $pendingAgents }} {{ \Illuminate\Support\Str::plural('agent', $pendingAgents) }} awaiting verification</a> @endif
        </span>
    </div>
@endif

<div class="tp-stats">
    @foreach ([
        ['Houses', $totalHouses, 'home', route('admin.properties.houses.index'), $pendingHouses ? $pendingHouses . ' pending' : 'All approved'],
        ['Land', $totalLands, 'land', route('admin.properties.lands.index'), $pendingLands ? $pendingLands . ' pending' : 'All approved'],
        ['Designs', $totalDesigns, 'ruler', route('admin.architectural-designs.index'), $pendingDesigns ? $pendingDesigns . ' pending' : 'All approved'],
        ['Agents', $totalAgents, 'users', route('admin.agents.index'), $pendingAgents ? $pendingAgents . ' to verify' : 'All verified'],
        ['Users & clients', $totalUsers, 'user', route('admin.users.index'), $totalClients . ' clients'],
        ['Listing fees (RWF)', $paidFees, 'credit', route('admin.listing-packages.index'), $pendingFees . ' payments pending'],
    ] as [$label, $value, $icon, $url, $hint])
        <a href="{{ $url }}" class="tp-stat">
            <div class="tp-stat-top">
                <span class="tp-stat-ico"><x-tu-icon :name="$icon" /></span>
                <span class="tu-badge {{ str_contains($hint, 'pending') || str_contains($hint, 'verify') ? 'tu-badge-warn' : '' }}">{{ $hint }}</span>
            </div>
            <div>
                <div class="tp-stat-val">{{ is_numeric($value) ? number_format($value) : $value }}</div>
                <div class="tp-stat-label">{{ $label }}</div>
            </div>
        </a>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>New listings · last 6 months</span>
                <span class="tu-badge">{{ array_sum($chart['houses']) + array_sum($chart['lands']) + array_sum($chart['designs']) }} added</span>
            </div>
            <div class="card-body"><div style="height:280px"><canvas id="listingChart"></canvas></div></div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Newest agents</span>
                <a href="{{ route('admin.agents.index') }}" class="tu-link-arrow" style="font-size:.8rem">All <x-tu-icon name="arrow-right" /></a>
            </div>
            <div class="card-body p-0">
                @forelse ($newAgents as $agent)
                    <a href="{{ route('admin.agents.show', $agent) }}" class="d-flex align-items-center gap-3 px-4 py-3 border-bottom text-decoration-none">
                        <span class="tu-avatar">{{ strtoupper(mb_substr($agent->full_name, 0, 1)) }}</span>
                        <span class="flex-grow-1" style="min-width:0">
                            <strong class="d-block text-truncate" style="color:var(--tu-ink);font-size:.88rem">{{ $agent->full_name }}</strong>
                            <span style="font-size:.76rem;color:var(--tu-muted)">{{ $agent->office_location ?: $agent->email }}</span>
                        </span>
                        <span class="tu-badge {{ $agent->is_verified ? 'tu-badge-success' : 'tu-badge-warn' }}">{{ $agent->is_verified ? 'Verified' : 'Pending' }}</span>
                    </a>
                @empty
                    <p class="p-4 mb-0" style="color:var(--tu-muted)">No agents yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">Recent listings</div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead><tr><th>Title</th><th>Type</th><th>Status</th><th>Added</th><th></th></tr></thead>
                    <tbody>
                        @forelse ($recent as $row)
                            <tr>
                                <td style="font-weight:600;color:var(--tu-ink)">{{ \Illuminate\Support\Str::limit($row['title'], 52) }}</td>
                                <td><span class="tu-badge tu-badge-{{ strtolower($row['type']) === 'house' ? 'house' : (strtolower($row['type']) === 'land' ? 'land' : 'design') }}">{{ $row['type'] }}</span></td>
                                <td><span class="tu-badge {{ $row['approved'] ? 'tu-badge-success' : 'tu-badge-warn' }}">{{ $row['approved'] ? 'Approved' : 'Pending review' }}</span></td>
                                <td style="color:var(--tu-muted)">{{ optional($row['created'])->diffForHumans() }}</td>
                                <td class="text-end"><a href="{{ $row['url'] }}" class="btn btn-sm btn-light">Open</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4" style="color:var(--tu-muted)">No listings yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    (function () {
        const data = @json($chart);
        const font = { family: "'Montserrat', system-ui, sans-serif", size: 12 };
        Chart.defaults.font = font;
        Chart.defaults.color = '#636B91';
        new Chart(document.getElementById('listingChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    { label: 'Houses', data: data.houses, backgroundColor: '#D05208', borderRadius: 6, maxBarThickness: 26 },
                    { label: 'Land', data: data.lands, backgroundColor: '#19265D', borderRadius: 6, maxBarThickness: 26 },
                    { label: 'Designs', data: data.designs, backgroundColor: '#19265D', borderRadius: 6, maxBarThickness: 26 },
                ],
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 18 } } },
                scales: {
                    x: { stacked: true, grid: { display: false }, border: { display: false } },
                    y: { stacked: true, beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#F6F6F9' }, border: { display: false } },
                },
            },
        });
    })();
</script>
@endpush
