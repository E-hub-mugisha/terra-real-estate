@extends('layouts.app')

@section('title', 'Listing Packages')


<style>
    .pkg-wrap { max-width: 1200px; margin: 0 auto; padding: 40px 24px 80px; }

    /* Header */
    .page-hdr { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 40px; }
    .page-hdr-left h1 { font-family: var(--font-display); font-size: 2rem; color: var(--terra-navy); margin: 0 0 4px; }
    .page-hdr-left p { color: var(--terra-muted); font-size: .88rem; margin: 0; }
    .btn-new { display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px;
        background: var(--terra-orange); color: #fff; border-radius: 10px; font-weight: 600;
        font-size: .88rem; text-decoration: none; border: none; cursor: pointer;
        transition: background .2s, transform .15s; }
    .btn-new:hover { background: #bf5516; color: #fff; transform: translateY(-1px); }

    /* Stats bar */
    .stats-bar { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 40px; }
    .stat-box { background: #fff; border: 1px solid var(--terra-border); border-radius: 12px;
        padding: 18px 20px; display: flex; align-items: center; gap: 14px; }
    .stat-icon { width: 42px; height: 42px; border-radius: 10px; display: flex;
        align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .stat-val { font-family: var(--font-display); font-size: 1.5rem; color: var(--terra-navy); line-height: 1; margin-bottom: 2px; }
    .stat-lbl { font-size: .72rem; color: var(--terra-muted); font-weight: 500; letter-spacing: .04em; }

    /* Type section */
    .type-section { margin-bottom: 44px; }
    .type-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
    .type-icon { width: 36px; height: 36px; background: var(--terra-navy); border-radius: 9px;
        display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
    .type-name { font-family: var(--font-display); font-size: 1.1rem; color: var(--terra-navy); font-weight: 600; }
    .type-count { font-size: .75rem; color: var(--terra-muted); background: var(--terra-cream);
        padding: 3px 10px; border-radius: 20px; }
    .type-line { flex: 1; height: 1px; background: var(--terra-border); }

    /* Package cards */
    .pkg-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
    .pkg-card { background: #fff; border: 1px solid var(--terra-border); border-radius: 16px;
        overflow: hidden; transition: box-shadow .25s, transform .2s; position: relative; }
    .pkg-card:hover { box-shadow: 0 8px 32px rgba(26,45,90,.1); transform: translateY(-2px); }
    .pkg-card.inactive { opacity: .6; }

    /* Card top stripe */
    .card-stripe { height: 5px; width: 100%; }
    .stripe-basic    { background: linear-gradient(90deg, #c9a96e, #e8c87e); }
    .stripe-medium   { background: linear-gradient(90deg, #1a2d5a, #2d4a8a); }
    .stripe-standard { background: linear-gradient(90deg, #d4601a, #e8843a); }

    .card-body-inner { padding: 20px 22px 0; }

    /* Tier + status row */
    .card-top-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .pkg-tier { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 20px;
        font-size: .7rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; }
    .tier-basic    { background: rgba(201,169,110,.15); color: #7a5c1e; }
    .tier-medium   { background: rgba(26,45,90,.1);    color: var(--terra-navy); }
    .tier-standard { background: rgba(212,96,26,.12);  color: var(--terra-orange); }
    .status-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .status-active   { background: #2d7a4f; box-shadow: 0 0 0 3px rgba(45,122,79,.15); }
    .status-inactive { background: #c0392b; box-shadow: 0 0 0 3px rgba(192,57,43,.15); }

    /* Price */
    .pkg-price-row { margin-bottom: 4px; }
    .pkg-price { font-family: var(--font-display); font-size: 1.8rem; color: var(--terra-navy); line-height: 1; }
    .pkg-price span { font-family: var(--font-body); font-size: .78rem; color: var(--terra-muted); font-weight: 400; margin-left: 4px; }
    .pkg-type-label { font-size: .78rem; color: var(--terra-muted); margin-bottom: 14px; }

    /* Commission pills */
    .comm-row { display: flex; gap: 8px; margin-bottom: 14px; }
    .comm-pill { padding: 5px 12px; border-radius: 7px; font-size: .72rem; font-weight: 600;
        display: flex; align-items: center; gap: 4px; }
    .comm-agent { background: rgba(45,122,79,.08); color: #1e5a35; border: 1px solid rgba(45,122,79,.15); }
    .comm-terra { background: rgba(26,45,90,.06); color: var(--terra-navy); border: 1px solid rgba(26,45,90,.12); }

    /* Features */
    .pkg-features { list-style: none; padding: 0; margin: 0 0 16px; }
    .pkg-features li { font-size: .8rem; color: var(--terra-muted); padding: 4px 0;
        display: flex; gap: 8px; align-items: flex-start;
        border-bottom: 1px dashed rgba(0,0,0,.05); }
    .pkg-features li:last-child { border-bottom: none; }
    .pkg-features li::before { content: '✓'; color: var(--terra-orange); font-weight: 700;
        flex-shrink: 0; font-size: .75rem; margin-top: 1px; }
    .more-features { font-size: .75rem; color: var(--terra-orange); font-weight: 600;
        padding: 4px 0; display: block; }

    /* Actions */
    .pkg-actions { display: flex; gap: 0; border-top: 1px solid var(--terra-border); margin-top: 4px; }
    .action-btn { flex: 1; padding: 11px 8px; font-size: .78rem; font-weight: 600;
        text-align: center; text-decoration: none; border: none; background: none;
        cursor: pointer; transition: background .18s, color .18s;
        display: flex; align-items: center; justify-content: center; gap: 5px; color: var(--terra-muted); }
    .action-btn:not(:last-child) { border-right: 1px solid var(--terra-border); }
    .action-btn:hover { background: var(--terra-cream); color: var(--terra-navy); }
    .action-btn.del:hover { background: rgba(192,57,43,.07); color: #c0392b; }

    /* Flash */
    .flash-success { padding: 14px 20px; border-left: 4px solid #2d7a4f;
        background: rgba(45,122,79,.07); border-radius: 0 10px 10px 0;
        margin-bottom: 28px; font-size: .9rem; color: #1e5a35; display: flex;
        align-items: center; gap: 10px; }

    /* Empty */
    .empty-state { text-align: center; padding: 80px 24px;
        background: #fff; border: 1px solid var(--terra-border); border-radius: 16px; }
    .empty-icon { width: 72px; height: 72px; background: var(--terra-cream);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin: 0 auto 16px; }

    @media(max-width:900px) { .pkg-grid { grid-template-columns: 1fr 1fr; } .stats-bar { grid-template-columns: 1fr 1fr; } }
    @media(max-width:600px) { .pkg-grid { grid-template-columns: 1fr; } .stats-bar { grid-template-columns: 1fr 1fr; } }
</style>


@section('content')
<div class="pkg-wrap">

    {{-- Header --}}
    <div class="page-hdr">
        <div class="page-hdr-left">
            <h1>Listing Packages</h1>
            <p>Manage pricing tiers and commission rates for all listing types</p>
        </div>
        <a href="{{ route('admin.listing-packages.create') }}" class="btn-new">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Package
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="flash-success">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats bar --}}
    @php
        $allPkgs   = $packages->flatten();
        $total     = $allPkgs->count();
        $active    = $allPkgs->where('is_active', true)->count();
        $inactive  = $allPkgs->where('is_active', false)->count();
        $typeCount = $packages->count();
    @endphp
    <div class="stats-bar">
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(26,45,90,.08)">📦</div>
            <div><div class="stat-val">{{ $total }}</div><div class="stat-lbl">Total Packages</div></div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(45,122,79,.08)">✅</div>
            <div><div class="stat-val">{{ $active }}</div><div class="stat-lbl">Active</div></div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(192,57,43,.08)">⛔</div>
            <div><div class="stat-val">{{ $inactive }}</div><div class="stat-lbl">Inactive</div></div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(212,96,26,.08)">🗂️</div>
            <div><div class="stat-val">{{ $typeCount }}</div><div class="stat-lbl">Listing Types</div></div>
        </div>
    </div>

    {{-- Empty state --}}
    @if($packages->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">📦</div>
        <h5 style="color:var(--terra-navy);font-family:var(--font-display);margin-bottom:8px">No packages yet</h5>
        <p style="color:var(--terra-muted);font-size:.9rem;margin-bottom:20px">
            Create your first listing package to start managing commissions.
        </p>
        <a href="{{ route('admin.listing-packages.create') }}" class="btn-new" style="display:inline-flex">
            + Create First Package
        </a>
    </div>

    @else

    @php
        $typeIcons = [
            'land'          => '🏞️',
            'house'         => '🏠',
            'design'        => '📐',
            'tender'        => '📋',
            'advertisement' => '📢',
        ];
    @endphp

    @foreach($packages as $type => $typePackages)
    <div class="type-section">

        {{-- Type header --}}
        <div class="type-header">
            <div class="type-icon">{{ $typeIcons[$type] ?? '📦' }}</div>
            <span class="type-name">{{ \App\Models\ListingPackage::listingTypes()[$type] ?? ucfirst($type) }}</span>
            <span class="type-count">{{ $typePackages->count() }} {{ Str::plural('package', $typePackages->count()) }}</span>
            <div class="type-line"></div>
        </div>

        <div class="pkg-grid">
            @foreach($typePackages as $pkg)
            @php
                $features = is_array($pkg->features)
                    ? $pkg->features
                    : (json_decode($pkg->features, true) ?? []);
            @endphp
            <div class="pkg-card {{ $pkg->is_active ? '' : 'inactive' }}">

                {{-- Top stripe --}}
                <div class="card-stripe stripe-{{ $pkg->package_tier }}"></div>

                <div class="card-body-inner">

                    {{-- Tier + status --}}
                    <div class="card-top-row">
                        <span class="pkg-tier tier-{{ $pkg->package_tier }}">{{ $pkg->tier_label }}</span>
                        <div class="d-flex align-items-center gap-2">
                            <span style="font-size:.72rem;color:var(--terra-muted)">
                                {{ $pkg->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <div class="status-dot {{ $pkg->is_active ? 'status-active' : 'status-inactive' }}"></div>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="pkg-price-row">
                        <div class="pkg-price">
                            {{ number_format($pkg->price_per_day) }}<span>RWF / day</span>
                        </div>
                    </div>
                    <div class="pkg-type-label">{{ $pkg->type_label }}</div>

                    {{-- Commission --}}
                    <div class="comm-row">
                        <span class="comm-pill comm-agent">
                            👤 Agent {{ $pkg->agent_commission_pct }}%
                        </span>
                        <span class="comm-pill comm-terra">
                            🏢 Terra {{ $pkg->terra_share_pct }}%
                        </span>
                    </div>

                    {{-- Features --}}
                    @if(count($features) > 0)
                    <ul class="pkg-features">
                        @foreach(array_slice($features, 0, 3) as $feature)
                        <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    @if(count($features) > 3)
                        <span class="more-features">+ {{ count($features) - 3 }} more features</span>
                    @endif
                    @endif

                </div>

                {{-- Actions --}}
                <div class="pkg-actions">
                    <a href="{{ route('admin.listing-packages.show', $pkg) }}" class="action-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        View
                    </a>
                    <a href="{{ route('admin.listing-packages.edit', $pkg) }}" class="action-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit
                    </a>
                    <form method="POST" action="{{ route('admin.listing-packages.destroy', $pkg) }}"
                        onsubmit="return confirm('Delete {{ $pkg->tier_label }} {{ $pkg->type_label }} package?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn del">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            Delete
                        </button>
                    </form>
                </div>

            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    @endif

</div>
@endsection