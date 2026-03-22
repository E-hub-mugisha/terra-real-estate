@extends('layouts.app')
@section('title', 'Commission — '.$commission->property_title)
@section('content')

@php
    $agent       = $commission->agent;
    $agentName   = $agent?->user?->name ?? $agent?->name ?? '—';
    $agentEmail  = $agent?->user?->email ?? '—';
    $agentPhone  = $agent?->user?->phone ?? $agent?->phone ?? 'N/A';
    $agentInitial= strtoupper(substr($agentName, 0, 1));

    $propType = strtolower($commission->property_type ?? '');
    $ptClass  = match($propType) {
        'house'  => 'cs-pt-house',
        'land'   => 'cs-pt-land',
        'design' => 'cs-pt-design',
        default  => 'cs-pt-house',
    };

    $ls = $commission->listing_commission_status;
    $ss = $commission->sale_commission_status;

    $statusClass = fn($s) => match($s) {
        'pending'  => 'cs-s-pending',
        'approved' => 'cs-s-approved',
        'paid'     => 'cs-s-paid',
        default    => 'cs-s-none',
    };
@endphp

<style>
/* ── Topbar ── */
.cs-topbar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:22px; }
.cs-back { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border:1.5px solid #e2e8f0; border-radius:8px; background:#fff; font-size:.81rem; font-weight:500; color:#475569; text-decoration:none; transition:all .18s; }
.cs-back:hover { border-color:#3b82f6; color:#2563eb; background:#eff6ff; }
.cs-back svg { width:14px; height:14px; }
.cs-act-btn { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:8px; font-size:.81rem; font-weight:600; border:none; cursor:pointer; transition:all .18s; text-decoration:none; }
.cs-btn-approve { background:#dbeafe; color:#1d4ed8; border:1.5px solid #93c5fd; }
.cs-btn-approve:hover { background:#93c5fd; color:#1e40af; }
.cs-btn-paid    { background:#dcfce7; color:#166534; border:1.5px solid #86efac; }
.cs-btn-paid:hover { background:#86efac; color:#14532d; }
.cs-btn-delete  { background:#fef2f2; color:#dc2626; border:1.5px solid #fca5a5; }
.cs-btn-delete:hover { background:#fca5a5; color:#991b1b; }

/* ── Cards ── */
.cs-card { background:#fff; border:1px solid #e5e7eb; border-radius:12px; margin-bottom:16px; overflow:hidden; }
.cs-card-head { padding:13px 18px; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; gap:10px; }
.cs-card-title { font-size:.88rem; font-weight:700; color:#1e293b; margin:0; display:flex; align-items:center; gap:7px; }
.cs-card-title svg { width:14px; height:14px; color:#64748b; }
.cs-card-body { padding:18px; }

/* ── Hero price strip ── */
.cs-hero { background:#0E0E0C; border-radius:12px; overflow:hidden; margin-bottom:16px; position:relative; }
.cs-hero::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 70% 60% at 20% 50%,rgba(37,99,235,.18) 0%,transparent 65%); pointer-events:none; }
.cs-hero-inner { position:relative; z-index:1; padding:22px 24px; display:grid; grid-template-columns:1fr 1fr; gap:20px; }
@media(max-width:540px){ .cs-hero-inner { grid-template-columns:1fr; } }
.cs-hero-block {}
.cs-hero-label { font-size:.65rem; color:rgba(255,255,255,.35); text-transform:uppercase; letter-spacing:.1em; margin-bottom:5px; }
.cs-hero-val { font-family:'Cormorant Garamond',serif; font-size:1.6rem; font-weight:600; letter-spacing:-.02em; line-height:1; color:#fff; }
.cs-hero-unit { font-size:.72rem; color:rgba(255,255,255,.3); margin-top:3px; }

/* ── Detail rows ── */
.cs-row { display:flex; align-items:flex-start; justify-content:space-between; padding:9px 0; border-bottom:1px solid #f8fafc; font-size:.82rem; gap:12px; }
.cs-row:last-child { border-bottom:none; }
.cs-row-label { color:#94a3b8; font-weight:500; flex-shrink:0; }
.cs-row-val   { color:#1e293b; font-weight:600; text-align:right; }

/* ── Status badges ── */
.cs-status { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:6px; font-size:.68rem; font-weight:700; letter-spacing:.05em; text-transform:uppercase; white-space:nowrap; }
.cs-status::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; }
.cs-s-pending  { background:#fef9c3; color:#854d0e; }
.cs-s-approved { background:#dbeafe; color:#1d4ed8; }
.cs-s-paid     { background:#dcfce7; color:#166534; }
.cs-s-none     { background:#f1f5f9; color:#94a3b8; }

/* ── Property type ── */
.cs-pt { display:inline-flex; align-items:center; gap:4px; padding:2px 8px; border-radius:5px; font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; }
.cs-pt-house  { background:#eff6ff; color:#1d4ed8; }
.cs-pt-land   { background:#f0fdf4; color:#166534; }
.cs-pt-design { background:#fdf4ff; color:#7e22ce; }

/* ── Agent card ── */
.cs-agent-av { width:46px; height:46px; border-radius:50%; background:#eff6ff; border:2px solid #bfdbfe; display:grid; place-items:center; font-weight:700; font-size:.95rem; color:#2563eb; flex-shrink:0; }

/* ── Timeline ── */
.cs-timeline { list-style:none; margin:0; padding:0; position:relative; }
.cs-timeline::before { content:''; position:absolute; left:13px; top:0; bottom:0; width:2px; background:#f1f5f9; border-radius:2px; }
.cs-tl-item { display:flex; align-items:flex-start; gap:12px; padding-bottom:18px; position:relative; }
.cs-tl-item:last-child { padding-bottom:0; }
.cs-tl-dot { width:28px; height:28px; border-radius:50%; display:grid; place-items:center; flex-shrink:0; position:relative; z-index:1; border:2px solid #fff; }
.cs-tl-dot.blue   { background:#dbeafe; }
.cs-tl-dot.green  { background:#dcfce7; }
.cs-tl-dot.indigo { background:#ede9fe; }
.cs-tl-dot svg { width:12px; height:12px; }
.cs-tl-dot.blue   svg { color:#2563eb; }
.cs-tl-dot.green  svg { color:#16a34a; }
.cs-tl-dot.indigo svg { color:#6d28d9; }
.cs-tl-label { font-size:.82rem; font-weight:600; color:#1e293b; margin-bottom:2px; }
.cs-tl-date  { font-size:.72rem; color:#94a3b8; }

/* ── Commission breakdown ── */
.cs-breakdown { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; overflow:hidden; }
.cs-breakdown-row { display:flex; align-items:center; justify-content:space-between; padding:10px 16px; border-bottom:1px solid #e2e8f0; font-size:.82rem; }
.cs-breakdown-row:last-child { border-bottom:none; background:#fff; border-top:2px solid #e2e8f0; font-weight:700; }
.cs-breakdown-label { color:#64748b; }
.cs-breakdown-val   { font-weight:600; color:#1e293b; }

/* ── Alert flash ── */
.cs-alert { padding:11px 16px; border-radius:8px; font-size:.82rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
.cs-alert.success { background:#dcfce7; color:#166534; border:1px solid #86efac; }
.cs-alert.error   { background:#fef2f2; color:#dc2626; border:1px solid #fca5a5; }
.cs-alert svg { width:15px; height:15px; flex-shrink:0; }
</style>

{{-- Flash --}}
@if(session('success'))
<div class="cs-alert success">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

{{-- ── Topbar ── --}}
<div class="cs-topbar">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <a href="{{ route('admin.commissions.index') }}" class="cs-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Back to Commissions
        </a>
        <nav aria-label="breadcrumb" class="d-none d-md-block">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('admin.commissions.index') }}">Commissions</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width:200px">{{ $commission->property_title }}</li>
            </ol>
        </nav>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
        {{-- Approve listing commission --}}
        @if($ls === 'pending')
        <form method="POST" action="{{ route('admin.commissions.approve', $commission->id) }}">
            @csrf
            <button type="submit" class="cs-act-btn cs-btn-approve">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Approve Listing
            </button>
        </form>
        @endif

        {{-- Mark listing paid --}}
        @if($ls === 'approved')
        <form method="POST" action="{{ route('admin.commissions.mark-paid', $commission->id) }}">
            @csrf
            <input type="hidden" name="type" value="listing">
            <button type="submit" class="cs-act-btn cs-btn-paid">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                Mark Listing Paid
            </button>
        </form>
        @endif

        {{-- Mark sale paid --}}
        @if($commission->sale_commission && $ss === 'approved')
        <form method="POST" action="{{ route('admin.commissions.mark-paid', $commission->id) }}">
            @csrf
            <input type="hidden" name="type" value="sale">
            <button type="submit" class="cs-act-btn cs-btn-paid">
                Mark Sale Paid
            </button>
        </form>
        @endif

        {{-- Delete --}}
        <form method="POST" action="{{ route('admin.commissions.destroy', $commission->id) }}"
              onsubmit="return confirm('Delete this commission record permanently?')">
            @csrf @method('DELETE')
            <button type="submit" class="cs-act-btn cs-btn-delete">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                Delete
            </button>
        </form>
    </div>
</div>

<div class="row g-3">

    {{-- ══ LEFT ══ --}}
    <div class="col-xl-8">

        {{-- Hero price strip --}}
        <div class="cs-hero">
            <div class="cs-hero-inner">
                <div class="cs-hero-block">
                    <div class="cs-hero-label">Listing Commission</div>
                    <div class="cs-hero-val">{{ number_format($commission->listing_commission ?? 0) }}</div>
                    <div class="cs-hero-unit">Rwandan Francs (RWF)</div>
                </div>
                <div class="cs-hero-block">
                    <div class="cs-hero-label">Sale Commission</div>
                    <div class="cs-hero-val">{{ number_format($commission->sale_commission ?? 0) }}</div>
                    <div class="cs-hero-unit">Rwandan Francs (RWF)</div>
                </div>
                <div class="cs-hero-block">
                    <div class="cs-hero-label">Total Earned</div>
                    <div class="cs-hero-val">{{ number_format($commission->total_earned) }}</div>
                    <div class="cs-hero-unit">Combined RWF</div>
                </div>
                <div class="cs-hero-block">
                    <div class="cs-hero-label">Sale Price</div>
                    <div class="cs-hero-val">{{ $commission->sale_price ? number_format($commission->sale_price) : '—' }}</div>
                    <div class="cs-hero-unit">Property sale value (RWF)</div>
                </div>
            </div>
        </div>

        {{-- Listing Commission Breakdown --}}
        <div class="cs-card">
            <div class="cs-card-head">
                <h6 class="cs-card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>
                    Listing Commission Breakdown
                </h6>
                <span class="cs-status {{ $statusClass($ls) }}">{{ ucfirst($ls ?? 'none') }}</span>
            </div>
            <div class="cs-card-body">
                <div class="cs-breakdown">
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Listing Package</span>
                        <span class="cs-breakdown-val">{{ $commission->listingPackage?->name ?? 'N/A' }}</span>
                    </div>
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Duration</span>
                        <span class="cs-breakdown-val">{{ $commission->listing_days ?? '—' }} days</span>
                    </div>
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Price per Day</span>
                        <span class="cs-breakdown-val">{{ number_format($commission->price_per_day ?? 0) }} RWF</span>
                    </div>
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Gross Listing Fee</span>
                        <span class="cs-breakdown-val">{{ number_format($commission->listing_fee_gross ?? 0) }} RWF</span>
                    </div>
                    @if($commission->discount_applied_pct)
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Discount Applied</span>
                        <span class="cs-breakdown-val text-warning">−{{ $commission->discount_applied_pct }}%</span>
                    </div>
                    @endif
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Net Listing Fee</span>
                        <span class="cs-breakdown-val">{{ number_format($commission->listing_fee_net ?? 0) }} RWF</span>
                    </div>
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Agent Commission Rate</span>
                        <span class="cs-breakdown-val">{{ $commission->listing_agent_pct ?? '—' }}%</span>
                    </div>
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Agent Commission</span>
                        <span class="cs-breakdown-val" style="color:#1d4ed8">{{ number_format($commission->listing_commission ?? 0) }} RWF</span>
                    </div>
                    @if($commission->listing_commission_paid_at)
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Paid On</span>
                        <span class="cs-breakdown-val text-success">{{ $commission->listing_commission_paid_at->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sale Commission Breakdown --}}
        @if($commission->sale_commission || $commission->sale_price)
        <div class="cs-card">
            <div class="cs-card-head">
                <h6 class="cs-card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    Sale Commission Breakdown
                </h6>
                <span class="cs-status {{ $statusClass($ss) }}">{{ ucfirst($ss ?? 'none') }}</span>
            </div>
            <div class="cs-card-body">
                <div class="cs-breakdown">
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Agent Level</span>
                        <span class="cs-breakdown-val">{{ $commission->agentLevel?->name ?? 'N/A' }}</span>
                    </div>
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Sale Price</span>
                        <span class="cs-breakdown-val">{{ number_format($commission->sale_price ?? 0) }} RWF</span>
                    </div>
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Commission Rate</span>
                        <span class="cs-breakdown-val">{{ $commission->sale_commission_rate ?? '—' }}%</span>
                    </div>
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Sale Commission</span>
                        <span class="cs-breakdown-val" style="color:#16a34a">{{ number_format($commission->sale_commission ?? 0) }} RWF</span>
                    </div>
                    @if($commission->sale_commission_paid_at)
                    <div class="cs-breakdown-row">
                        <span class="cs-breakdown-label">Paid On</span>
                        <span class="cs-breakdown-val text-success">{{ $commission->sale_commission_paid_at->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Notes --}}
        @if($commission->notes)
        <div class="cs-card">
            <div class="cs-card-head">
                <h6 class="cs-card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/></svg>
                    Notes
                </h6>
            </div>
            <div class="cs-card-body">
                <p class="text-muted mb-0" style="font-size:.84rem;line-height:1.8">{{ $commission->notes }}</p>
            </div>
        </div>
        @endif

        {{-- Activity Timeline --}}
        <div class="cs-card">
            <div class="cs-card-head">
                <h6 class="cs-card-title">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 5h2v6H8v-2h3V7zm-1 10v-2h2v2h-2z"/></svg>
                    Activity Timeline
                </h6>
            </div>
            <div class="cs-card-body">
                <ul class="cs-timeline">
                    @foreach($timeline as $event)
                    <li class="cs-tl-item">
                        <div class="cs-tl-dot {{ $event['color'] }}">
                            @if($event['icon'] === 'created')
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 5h2v6H8v-2h3V7z"/></svg>
                            @elseif($event['icon'] === 'approved')
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif($event['icon'] === 'paid')
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16C6.36 5.58 4.8 6.84 4.8 7.77c0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                            @endif
                        </div>
                        <div>
                            <div class="cs-tl-label">{{ $event['label'] }}</div>
                            <div class="cs-tl-date">{{ \Carbon\Carbon::parse($event['date'])->format('d M Y, H:i') }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>{{-- /col-xl-8 --}}

    {{-- ══ SIDEBAR ══ --}}
    <div class="col-xl-4">
        <div style="position:sticky;top:24px">

            {{-- Agent Card --}}
            <div class="cs-card">
                <div class="cs-card-head"><h6 class="cs-card-title">Agent Details</h6></div>
                <div class="cs-card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="cs-agent-av">{{ $agentInitial }}</div>
                        <div>
                            <div style="font-weight:700;font-size:.9rem;color:#1e293b">{{ $agentName }}</div>
                            <div style="font-size:.73rem;color:#64748b">{{ $agent?->agentLevel?->name ?? 'Agent' }}</div>
                        </div>
                    </div>
                    <div class="cs-row"><span class="cs-row-label">Email</span><span class="cs-row-val text-truncate" style="max-width:160px">{{ $agentEmail }}</span></div>
                    <div class="cs-row"><span class="cs-row-label">Phone</span><span class="cs-row-val">{{ $agentPhone }}</span></div>
                    <div class="cs-row"><span class="cs-row-label">Agent Level</span><span class="cs-row-val">{{ $commission->agentLevel?->name ?? '—' }}</span></div>
                    <div class="cs-row"><span class="cs-row-label">Sale Rate</span><span class="cs-row-val">{{ $commission->sale_commission_rate ?? '—' }}%</span></div>
                </div>
            </div>

            {{-- Property Card --}}
            <div class="cs-card">
                <div class="cs-card-head"><h6 class="cs-card-title">Property</h6></div>
                <div class="cs-card-body">
                    <div class="cs-row">
                        <span class="cs-row-label">Title</span>
                        <span class="cs-row-val text-truncate" style="max-width:170px" title="{{ $commission->property_title }}">
                            {{ $commission->property_title ?? '—' }}
                        </span>
                    </div>
                    <div class="cs-row">
                        <span class="cs-row-label">Type</span>
                        <span class="cs-row-val"><span class="cs-pt {{ $ptClass }}">{{ ucfirst($propType ?: '—') }}</span></span>
                    </div>
                    <div class="cs-row">
                        <span class="cs-row-label">Commissionable ID</span>
                        <span class="cs-row-val">#{{ $commission->commissionable_id }}</span>
                    </div>
                    @if($commission->commissionable)
                    <div class="cs-row">
                        <span class="cs-row-label">View Property</span>
                        <span class="cs-row-val">
                            @php
                                $propRoute = match($propType) {
                                    'house'  => 'admin.properties.houses.show',
                                    'land'   => 'admin.properties.lands.show',
                                    'design' => 'admin.properties.designs.show',
                                    default  => null
                                };
                            @endphp
                            @if($propRoute && \Illuminate\Support\Facades\Route::has($propRoute))
                            <a href="{{ route($propRoute, $commission->commissionable_id) }}"
                               class="btn btn-sm btn-outline-secondary" style="font-size:.72rem">
                                Open →
                            </a>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </span>
                    </div>
                    @endif
                    <div class="cs-row">
                        <span class="cs-row-label">Listed</span>
                        <span class="cs-row-val">{{ $commission->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Summary Card --}}
            <div class="cs-card">
                <div class="cs-card-head"><h6 class="cs-card-title">Commission Summary</h6></div>
                <div class="cs-card-body">
                    <div class="cs-row">
                        <span class="cs-row-label">Listing Commission</span>
                        <span class="cs-row-val">{{ number_format($commission->listing_commission ?? 0) }} RWF</span>
                    </div>
                    <div class="cs-row">
                        <span class="cs-row-label">Listing Status</span>
                        <span class="cs-row-val"><span class="cs-status {{ $statusClass($ls) }}">{{ ucfirst($ls ?? 'none') }}</span></span>
                    </div>
                    <div class="cs-row">
                        <span class="cs-row-label">Sale Commission</span>
                        <span class="cs-row-val">{{ number_format($commission->sale_commission ?? 0) }} RWF</span>
                    </div>
                    <div class="cs-row">
                        <span class="cs-row-label">Sale Status</span>
                        <span class="cs-row-val"><span class="cs-status {{ $statusClass($ss) }}">{{ ucfirst($ss ?? 'none') }}</span></span>
                    </div>
                    <div class="cs-row" style="border-top:2px solid #e2e8f0;margin-top:4px;padding-top:12px">
                        <span class="cs-row-label" style="font-weight:700;color:#1e293b">Total Earned</span>
                        <span class="cs-row-val" style="font-size:1rem;color:#1d4ed8">{{ number_format($commission->total_earned) }} RWF</span>
                    </div>
                </div>
            </div>

            {{-- Meta Card --}}
            <div class="cs-card">
                <div class="cs-card-head"><h6 class="cs-card-title">Record Info</h6></div>
                <div class="cs-card-body">
                    <div class="cs-row"><span class="cs-row-label">Record ID</span><span class="cs-row-val">#{{ $commission->id }}</span></div>
                    <div class="cs-row"><span class="cs-row-label">Created</span><span class="cs-row-val">{{ $commission->created_at->format('d M Y, H:i') }}</span></div>
                    <div class="cs-row"><span class="cs-row-label">Last Updated</span><span class="cs-row-val">{{ $commission->updated_at->format('d M Y, H:i') }}</span></div>
                    @if($commission->listing_commission_paid_at)
                    <div class="cs-row"><span class="cs-row-label">Listing Paid At</span><span class="cs-row-val text-success">{{ $commission->listing_commission_paid_at->format('d M Y') }}</span></div>
                    @endif
                    @if($commission->sale_commission_paid_at)
                    <div class="cs-row"><span class="cs-row-label">Sale Paid At</span><span class="cs-row-val text-success">{{ $commission->sale_commission_paid_at->format('d M Y') }}</span></div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
