@extends('layouts.agents')
@section('title', 'Dashboard')

@section('content')

{{-- ══════════════════════════════════════════════
     VERIFICATION GATE
══════════════════════════════════════════════ --}}
@if (!$isVerified)
<div id="verify-overlay" style="position:fixed;inset:0;background:rgba(25,38,93,.55);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);z-index:1050;display:flex;align-items:center;justify-content:center;padding:20px;animation:vFadeIn .3s ease both">
    <div style="background:#fff;border-radius:16px;max-width:460px;width:100%;box-shadow:0 24px 64px rgba(0,0,0,.18);overflow:hidden;animation:vSlideUp .35s cubic-bezier(.4,0,.2,1) both">
        <div style="height:4px;background:linear-gradient(90deg,#D05208,#F59E0B)"></div>
        <div style="padding:36px 32px 28px;text-align:center">
            <div style="width:68px;height:68px;border-radius:50%;background:rgba(208,82,8,.08);display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#D05208" stroke-width="1.8">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M12 8v4M12 16h.01"/>
                </svg>
            </div>
            <h2 style="font-size:1.2rem;font-weight:700;color:#19265d;margin-bottom:10px;letter-spacing:-.02em">Account Pending Verification</h2>
            <p style="font-size:.87rem;color:#7A736B;line-height:1.7;margin-bottom:6px">Hi <strong style="color:#19265d">{{ $user->name }}</strong>, your agent account is currently under review.</p>
            <p style="font-size:.84rem;color:#7A736B;line-height:1.65;margin-bottom:24px">Our team will verify your details and activate your account. You'll receive an email once approved.</p>
            <div style="display:inline-flex;align-items:center;gap:7px;padding:8px 16px;background:rgba(180,83,9,.06);border:1px solid rgba(180,83,9,.18);border-radius:20px;font-size:.75rem;font-weight:600;color:#B45309;margin-bottom:28px">
                <span style="width:8px;height:8px;border-radius:50%;background:#B45309;animation:vPulse 1.6s ease infinite;display:inline-block"></span>
                Awaiting Admin Approval
            </div>
            <div style="border-top:1px solid #E8E3DC;margin-bottom:20px"></div>
            <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap">
                <a href="{{ route('front.home') }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:8px;border:1.5px solid #E8E3DC;background:#F7F5F2;font-size:.82rem;font-weight:600;color:#7A736B;text-decoration:none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Go to Home
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0">
                    @csrf
                    <button type="submit" style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:8px;border:none;background:#19265d;font-family:'DM Sans',sans-serif;font-size:.82rem;font-weight:600;color:#fff;cursor:pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
        <div style="padding:12px 32px 14px;background:#F7F5F2;border-top:1px solid #E8E3DC;text-align:center;font-size:.72rem;color:#B0A89E">
            Questions? <a href="mailto:support@terra.rw" style="color:#D05208;text-decoration:none;font-weight:500">support@terra.rw</a>
        </div>
    </div>
</div>
<style>
    @keyframes vFadeIn  { from{opacity:0} to{opacity:1} }
    @keyframes vSlideUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
    @keyframes vPulse   { 0%,100%{opacity:1} 50%{opacity:.3} }
    body { overflow:hidden !important }
</style>
@endif

{{-- ══════════════════════════════════════════════
     DASHBOARD CONTENT
══════════════════════════════════════════════ --}}

<style>
    .dash-stat-card {
        background: #fff;
        border: 1px solid #E8E3DC;
        border-radius: 12px;
        padding: 20px 22px;
        transition: box-shadow .2s, transform .2s;
    }
    .dash-stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.07); transform: translateY(-2px); }

    .dash-level-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px;
        font-size: .7rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
    }
    .level-bronze { background: rgba(180,83,9,.08);  color: #92400E; }
    .level-silver { background: rgba(100,116,139,.1); color: #475569; }
    .level-gold   { background: rgba(234,179,8,.1);  color: #92400E; }
    .level-elite  { background: rgba(208,82,8,.1);   color: #D05208; }

    .commission-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 0; border-bottom: 1px solid #F0ECE7;
        font-size: .83rem;
    }
    .commission-row:last-child { border-bottom: none; }

    .bar-track { background: #F0ECE7; border-radius: 4px; height: 6px; overflow: hidden; }
    .bar-fill  { height: 100%; border-radius: 4px; transition: width 1s ease; }

    /* Sparkline bars */
    .spark-bar-wrap { display: flex; align-items: flex-end; gap: 4px; height: 52px; }
    .spark-bar { flex: 1; border-radius: 3px 3px 0 0; background: rgba(208,82,8,.18); transition: background .2s; min-width: 6px; }
    .spark-bar.active { background: #D05208; }
    .spark-bar:hover  { background: #D05208; }
</style>

{{-- Page heading --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h5 class="mb-0 fw-bold" style="color:#19265d">Dashboard</h5>
        <p class="text-muted mb-0" style="font-size:.82rem">Welcome back, {{ $user->name }}</p>
    </div>
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="#!" class="text-muted">Agent</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ul>
</div>

{{-- ── ROW 1 — KPI STATS ── --}}
<div class="row g-3 mb-4">

    {{-- Total Commission --}}
    <div class="col-6 col-xl-3">
        <div class="dash-stat-card h-100">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div style="width:38px;height:38px;border-radius:10px;background:rgba(208,82,8,.08);display:flex;align-items:center;justify-content:center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#D05208">
                        <path d="M21 18v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1h-9a2 2 0 00-2 2v8a2 2 0 002 2h9zm-9-2h10V8H12v8zm4-2.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                    </svg>
                </div>
                @if($commissionGrowth > 0)
                <span style="font-size:.72rem;font-weight:600;color:#1E7A5A;background:rgba(30,122,90,.08);padding:2px 7px;border-radius:20px">+{{ $commissionGrowth }}%</span>
                @elseif($commissionGrowth < 0)
                <span style="font-size:.72rem;font-weight:600;color:#DC2626;background:rgba(220,38,38,.08);padding:2px 7px;border-radius:20px">{{ $commissionGrowth }}%</span>
                @endif
            </div>
            <div style="font-size:1.3rem;font-weight:700;color:#19265d;letter-spacing:-.02em">
                {{ number_format($totalCommission) }} <span style="font-size:.7rem;font-weight:500;color:#7A736B">RWF</span>
            </div>
            <div style="font-size:.75rem;color:#7A736B;margin-top:3px">Total Commission</div>
        </div>
    </div>

    {{-- This Month --}}
    <div class="col-6 col-xl-3">
        <div class="dash-stat-card h-100">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div style="width:38px;height:38px;border-radius:10px;background:rgba(25,38,93,.07);display:flex;align-items:center;justify-content:center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#19265d">
                        <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11zM7 11h5v5H7z"/>
                    </svg>
                </div>
            </div>
            <div style="font-size:1.3rem;font-weight:700;color:#19265d;letter-spacing:-.02em">
                {{ number_format($thisMonthCommission) }} <span style="font-size:.7rem;font-weight:500;color:#7A736B">RWF</span>
            </div>
            <div style="font-size:.75rem;color:#7A736B;margin-top:3px">This Month</div>
        </div>
    </div>

    {{-- Total Referrals --}}
    <div class="col-6 col-xl-3">
        <div class="dash-stat-card h-100">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div style="width:38px;height:38px;border-radius:10px;background:rgba(30,122,90,.08);display:flex;align-items:center;justify-content:center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#1E7A5A">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                </div>
            </div>
            <div style="font-size:1.3rem;font-weight:700;color:#19265d;letter-spacing:-.02em">
                {{ number_format($totalReferrals) }}
            </div>
            <div style="font-size:.75rem;color:#7A736B;margin-top:3px">Total Referrals</div>
        </div>
    </div>

    {{-- Rating --}}
    <div class="col-6 col-xl-3">
        <div class="dash-stat-card h-100">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div style="width:38px;height:38px;border-radius:10px;background:rgba(234,179,8,.1);display:flex;align-items:center;justify-content:center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#D97706">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
            </div>
            <div style="font-size:1.3rem;font-weight:700;color:#19265d;letter-spacing:-.02em">
                {{ $avgRating > 0 ? $avgRating : '—' }}
                <span style="font-size:.7rem;font-weight:500;color:#7A736B">/ 5 &nbsp;({{ $reviewCount }})</span>
            </div>
            <div style="font-size:.75rem;color:#7A736B;margin-top:3px">Avg. Rating</div>
        </div>
    </div>

</div>

{{-- ── ROW 2 — CHART + PROFILE ── --}}
<div class="row g-3 mb-4">

    {{-- Commission Chart (last 6 months) --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                <div>
                    <h6 class="fw-bold mb-0" style="color:#19265d;font-size:.88rem">Commission — Last 6 Months</h6>
                    <p class="text-muted mb-0" style="font-size:.75rem">Monthly earnings breakdown</p>
                </div>
                <span style="font-size:.72rem;font-weight:600;padding:3px 10px;border-radius:20px;background:rgba(208,82,8,.08);color:#D05208">RWF</span>
            </div>
            <div class="card-body p-4">

                {{-- Simple CSS bar chart --}}
                @php
                    $maxAmount = $commissionChart->max('amount');
                    $maxAmount = $maxAmount > 0 ? $maxAmount : 1;
                @endphp

                <div style="display:flex;align-items:flex-end;gap:12px;height:120px;margin-bottom:10px">
                    @foreach($commissionChart as $i => $point)
                    @php $heightPct = round(($point['amount'] / $maxAmount) * 100); @endphp
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;height:100%;justify-content:flex-end">
                        <span style="font-size:.65rem;color:#7A736B;white-space:nowrap">
                            @if($point['amount'] > 0) {{ number_format($point['amount'] / 1000, 0) }}k @endif
                        </span>
                        <div style="width:100%;height:{{ max($heightPct, 3) }}%;background:{{ $i === 5 ? '#D05208' : 'rgba(208,82,8,.18)' }};border-radius:4px 4px 0 0;transition:background .2s;min-height:4px" title="{{ $point['label'] }}: {{ number_format($point['amount']) }} RWF"></div>
                    </div>
                    @endforeach
                </div>

                <div style="display:flex;gap:12px">
                    @foreach($commissionChart as $point)
                    <div style="flex:1;text-align:center;font-size:.68rem;color:#B0A89E;font-weight:600">{{ $point['label'] }}</div>
                    @endforeach
                </div>

                <div class="mt-3 pt-3" style="border-top:1px solid #F0ECE7">
                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em">This Month</div>
                            <div style="font-size:.9rem;font-weight:700;color:#19265d">{{ number_format($thisMonthCommission) }}</div>
                        </div>
                        <div class="col-4">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em">Last Month</div>
                            <div style="font-size:.9rem;font-weight:700;color:#19265d">{{ number_format($lastMonthCommission) }}</div>
                        </div>
                        <div class="col-4">
                            <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em">Growth</div>
                            <div style="font-size:.9rem;font-weight:700;color:{{ $commissionGrowth >= 0 ? '#1E7A5A' : '#DC2626' }}">
                                {{ $commissionGrowth >= 0 ? '+' : '' }}{{ $commissionGrowth }}%
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Agent Profile Card --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 text-center">

                {{-- Avatar --}}
                @if($agent?->profile_image)
                <img src="{{ asset('image/agents/' . $agent->profile_image) }}"
                    alt="{{ $agent->full_name }}"
                    style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #D05208;margin-bottom:12px">
                @else
                <div style="width:72px;height:72px;border-radius:50%;background:#19265d;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:1.5rem;font-weight:700;color:#fff">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                @endif

                <h6 class="fw-bold mb-1" style="color:#19265d">{{ $agent?->full_name ?? $user->name }}</h6>
                <p class="text-muted mb-2" style="font-size:.78rem">{{ $agent?->email ?? $user->email }}</p>

                {{-- Level badge --}}
                <span class="dash-level-badge level-{{ $currentLevel }} mb-3 d-inline-flex">
                    @if($currentLevel === 'elite')  ✦
                    @elseif($currentLevel === 'gold') ◆
                    @elseif($currentLevel === 'silver') ◇
                    @else ○
                    @endif
                    {{ ucfirst($currentLevel) }} Agent
                </span>

                {{-- Commission rate --}}
                <div style="background:#F7F5F2;border-radius:10px;padding:12px;margin-bottom:16px">
                    <div style="font-size:.68rem;color:#7A736B;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">Commission Rate</div>
                    <div style="font-size:1.4rem;font-weight:700;color:#D05208">{{ $saleCommissionRate }}%</div>
                </div>

                {{-- Level progress to next --}}
                @if($nextLevel && $currentLevel !== 'elite')
                <div style="text-align:left;margin-bottom:8px">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:.72rem;color:#7A736B">Progress to <strong style="color:#19265d">{{ ucfirst($nextLevel) }}</strong></span>
                        <span style="font-size:.72rem;font-weight:600;color:#D05208">{{ $referralProgress }}%</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:{{ $referralProgress }}%;background:#D05208"></div>
                    </div>
                    <div style="font-size:.68rem;color:#B0A89E;margin-top:4px">{{ $totalReferrals }} referrals · {{ number_format($totalRevenue) }} RWF generated</div>
                </div>
                @endif

                <a href="#" class="btn btn-sm w-100 mt-2" style="background:#19265d;color:#fff;border:none;font-size:.8rem">View Profile</a>
            </div>
        </div>
    </div>

</div>

{{-- ── ROW 3 — RECENT COMMISSIONS + QUICK STATS ── --}}
<div class="row g-3">

    {{-- Recent Commissions --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                <h6 class="fw-bold mb-0" style="color:#19265d;font-size:.88rem">Recent Commissions</h6>
                <span style="font-size:.72rem;color:#7A736B">Last {{ $recentCommissions->count() }} transactions</span>
            </div>
            <div class="card-body p-0">

                @forelse($recentCommissions as $commission)
                @php
                    $statusColors = [
                        'paid'    => ['#1E7A5A', 'rgba(30,122,90,.08)'],
                        'pending' => ['#B45309', 'rgba(180,83,9,.08)'],
                        'failed'  => ['#DC2626', 'rgba(220,38,38,.08)'],
                    ];
                    [$sc, $sb] = $statusColors[$commission->status ?? 'pending'] ?? ['#7A736B', '#F5F5F5'];
                @endphp
                <div class="commission-row px-4">
                    <div class="d-flex align-items-center gap-3" style="min-width:0;flex:1">
                        <div style="width:36px;height:36px;border-radius:9px;background:rgba(25,38,93,.06);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#19265d">
                                <path d="M21 18v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1h-9a2 2 0 00-2 2v8a2 2 0 002 2h9zm-9-2h10V8H12v8zm4-2.5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z"/>
                            </svg>
                        </div>
                        <div style="min-width:0">
                            <div style="font-size:.82rem;font-weight:600;color:#19265d;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                {{ $commission->listingPackage?->tier_label ?? 'Commission' }}
                            </div>
                            <div style="font-size:.72rem;color:#B0A89E">{{ $commission->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="text-end ms-3">
                        <div style="font-size:.88rem;font-weight:700;color:#19265d">{{ number_format($commission->agent_amount) }} <span style="font-size:.68rem;font-weight:400;color:#7A736B">RWF</span></div>
                        <span style="font-size:.68rem;font-weight:700;padding:2px 7px;border-radius:20px;background:{{ $sb }};color:{{ $sc }}">{{ ucfirst($commission->status ?? 'pending') }}</span>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:40px 20px;color:#B0A89E;font-size:.84rem">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:.3;display:block;margin:0 auto 10px">
                        <path d="M21 18v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v1h-9a2 2 0 00-2 2v8a2 2 0 002 2h9z"/>
                    </svg>
                    No commissions yet
                </div>
                @endforelse

            </div>
        </div>
    </div>

    {{-- Right sidebar — Quick Stats + Level Info --}}
    <div class="col-lg-4 d-flex flex-column gap-3">

        {{-- Revenue generated --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#7A736B;margin-bottom:12px">Revenue Generated</div>
                <div style="font-size:1.5rem;font-weight:700;color:#19265d;letter-spacing:-.02em;margin-bottom:4px">
                    {{ number_format($totalRevenue / 1000000, 2) }}M <span style="font-size:.75rem;font-weight:400;color:#7A736B">RWF</span>
                </div>
                <div style="font-size:.75rem;color:#7A736B;margin-bottom:16px">Cumulative platform revenue</div>
                <div class="bar-track">
                    <div class="bar-fill" style="width:{{ $revenueProgress }}%;background:linear-gradient(90deg,#D05208,#F59E0B)"></div>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span style="font-size:.68rem;color:#B0A89E">Progress to {{ ucfirst($nextLevel ?? 'max') }}</span>
                    <span style="font-size:.68rem;font-weight:600;color:#D05208">{{ $revenueProgress }}%</span>
                </div>
            </div>
        </div>

        {{-- Agent Info --}}
        <div class="card border-0 shadow-sm flex-grow-1">
            <div class="card-body p-4">
                <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#7A736B;margin-bottom:14px">Agent Details</div>

                @php
                $details = [
                    ['label' => 'Location',   'value' => $agent?->office_location ?? '—'],
                    ['label' => 'Languages',  'value' => $agent?->languages ?? '—'],
                    ['label' => 'Phone',      'value' => $agent?->phone ?? '—'],
                    ['label' => 'WhatsApp',   'value' => $agent?->whatsapp ?? '—'],
                    ['label' => 'Level',      'value' => ucfirst($currentLevel) . ' Agent'],
                ];
                @endphp

                <div style="display:flex;flex-direction:column;gap:10px">
                    @foreach($details as $d)
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px">
                        <span style="font-size:.72rem;color:#B0A89E;flex-shrink:0">{{ $d['label'] }}</span>
                        <span style="font-size:.78rem;font-weight:600;color:#19265d;text-align:right">{{ $d['value'] }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Social links --}}
                @if($agent?->linkedin || $agent?->facebook || $agent?->instagram || $agent?->twitter)
                <div style="border-top:1px solid #F0ECE7;margin-top:14px;padding-top:12px;display:flex;gap:8px">
                    @if($agent->linkedin)
                    <a href="{{ $agent->linkedin }}" target="_blank" style="width:28px;height:28px;border-radius:7px;border:1px solid #E8E3DC;display:flex;align-items:center;justify-content:center;color:#7A736B;text-decoration:none;font-size:.7rem;transition:border-color .2s">in</a>
                    @endif
                    @if($agent->facebook)
                    <a href="{{ $agent->facebook }}" target="_blank" style="width:28px;height:28px;border-radius:7px;border:1px solid #E8E3DC;display:flex;align-items:center;justify-content:center;color:#7A736B;text-decoration:none;font-size:.7rem">f</a>
                    @endif
                    @if($agent->instagram)
                    <a href="{{ $agent->instagram }}" target="_blank" style="width:28px;height:28px;border-radius:7px;border:1px solid #E8E3DC;display:flex;align-items:center;justify-content:center;color:#7A736B;text-decoration:none;font-size:.7rem">ig</a>
                    @endif
                    @if($agent->twitter)
                    <a href="{{ $agent->twitter }}" target="_blank" style="width:28px;height:28px;border-radius:7px;border:1px solid #E8E3DC;display:flex;align-items:center;justify-content:center;color:#7A736B;text-decoration:none;font-size:.7rem">𝕏</a>
                    @endif
                </div>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection