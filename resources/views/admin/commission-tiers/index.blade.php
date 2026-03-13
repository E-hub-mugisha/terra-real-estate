@extends('layouts.app')

@section('title', 'Consultant Commission Tiers')


<style>
    .tiers-wrap { max-width: 1100px; margin: 0 auto; padding: 40px 24px 80px; }

    /* Header */
    .page-hdr { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 32px; }
    .page-hdr h1 { font-family: var(--font-display); font-size: 2rem; color: var(--terra-navy); margin: 0 0 4px; }
    .page-hdr p { color: var(--terra-muted); font-size: .88rem; margin: 0; }
    .btn-new { display: inline-flex; align-items: center; gap: 8px; padding: 11px 22px;
        background: var(--terra-orange); color: #fff; border-radius: 10px; font-weight: 600;
        font-size: .88rem; text-decoration: none; transition: background .2s, transform .15s; }
    .btn-new:hover { background: #bf5516; color: #fff; transform: translateY(-1px); }

    /* Stats */
    .stats-bar { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }
    .stat-box { background: #fff; border: 1px solid var(--terra-border); border-radius: 12px;
        padding: 18px 20px; display: flex; align-items: center; gap: 14px; }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
    .stat-val { font-family: var(--font-display); font-size: 1.5rem; color: var(--terra-navy); line-height: 1; margin-bottom: 2px; }
    .stat-lbl { font-size: .72rem; color: var(--terra-muted); font-weight: 500; }

    /* Table */
    .table-wrap { background: #fff; border: 1px solid var(--terra-border); border-radius: 14px; overflow: hidden; }
    .tiers-table { width: 100%; border-collapse: collapse; }
    .tiers-table thead tr { background: var(--terra-navy); }
    .tiers-table thead th { padding: 14px 18px; font-size: .72rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.65);
        text-align: left; white-space: nowrap; }
    .tiers-table tbody tr { border-bottom: 1px solid var(--terra-border); transition: background .15s; }
    .tiers-table tbody tr:last-child { border-bottom: none; }
    .tiers-table tbody tr:hover { background: #fafbfd; }
    .tiers-table td { padding: 16px 18px; font-size: .88rem; color: var(--terra-navy); vertical-align: middle; }

    /* Range */
    .range-val { font-family: var(--font-display); font-size: 1rem; color: var(--terra-navy); }
    .range-label { font-size: .78rem; color: var(--terra-muted); margin-top: 2px; }

    /* Commission pills */
    .comm-pill { display: inline-flex; align-items: center; padding: 5px 12px;
        border-radius: 7px; font-size: .78rem; font-weight: 600; }
    .comm-terra { background: rgba(26,45,90,.08); color: var(--terra-navy); border: 1px solid rgba(26,45,90,.12); }
    .comm-consultant { background: rgba(45,122,79,.08); color: #1e5a35; border: 1px solid rgba(45,122,79,.15); }

    /* Sliding scale bar */
    .scale-bar { width: 100%; height: 6px; background: var(--terra-border);
        border-radius: 3px; overflow: hidden; margin-top: 6px; }
    .scale-fill { height: 100%; border-radius: 3px;
        background: linear-gradient(90deg, var(--terra-orange), var(--terra-gold)); }

    /* Actions */
    .action-btns { display: flex; gap: 6px; align-items: center; }
    .act-btn { display: inline-flex; align-items: center; gap: 4px; padding: 6px 12px;
        border-radius: 7px; font-size: .78rem; font-weight: 500; text-decoration: none;
        border: none; cursor: pointer; transition: all .18s; }
    .act-view { background: var(--terra-cream); color: var(--terra-navy); }
    .act-edit { background: rgba(26,45,90,.08); color: var(--terra-navy); }
    .act-del  { background: rgba(192,57,43,.08); color: #c0392b; }
    .act-view:hover { background: var(--terra-gold); color: #fff; }
    .act-edit:hover { background: var(--terra-navy); color: #fff; }
    .act-del:hover  { background: #c0392b; color: #fff; }

    /* Flash */
    .flash-success { padding: 14px 20px; border-left: 4px solid #2d7a4f;
        background: rgba(45,122,79,.07); border-radius: 0 10px 10px 0;
        margin-bottom: 24px; font-size: .9rem; color: #1e5a35;
        display: flex; align-items: center; gap: 10px; }

    /* Empty */
    .empty-state { text-align: center; padding: 80px 24px; }
    .empty-icon { width: 72px; height: 72px; background: var(--terra-cream);
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 1.8rem; margin: 0 auto 16px; }

    /* Info banner */
    .info-banner { background: rgba(26,45,90,.04); border: 1px solid rgba(26,45,90,.1);
        border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;
        display: flex; align-items: flex-start; gap: 12px; }
    .info-banner p { margin: 0; font-size: .85rem; color: var(--terra-muted); line-height: 1.6; }

    @media(max-width:768px) { .stats-bar { grid-template-columns: 1fr 1fr; } }
</style>

@section('content')
<div class="tiers-wrap">

    {{-- Header --}}
    <div class="page-hdr">
        <div>
            <h1>Commission Tiers</h1>
            <p>Sliding scale commission rates for consultant services</p>
        </div>
        <a href="{{ route('admin.commission-tiers.create') }}" class="btn-new">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Tier
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="flash-success">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Info banner --}}
    <div class="info-banner">
        <span style="font-size:1.2rem;flex-shrink:0">💡</span>
        <p>The sliding scale rewards consultants for higher-value services — the more a service is worth, the less Terra charges. Commission is calculated automatically when a consultant logs a completed service.</p>
    </div>

    {{-- Stats --}}
    @php
        $minTerra = $tiers->min('terra_commission_pct');
        $maxTerra = $tiers->max('terra_commission_pct');
        $maxPayout = $tiers->max('consultant_payout_pct');
    @endphp
    <div class="stats-bar">
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(26,45,90,.08)">📊</div>
            <div><div class="stat-val">{{ $tiers->count() }}</div><div class="stat-lbl">Total Tiers</div></div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(212,96,26,.08)">🏢</div>
            <div><div class="stat-val">{{ $minTerra ?? 0 }}% – {{ $maxTerra ?? 0 }}%</div><div class="stat-lbl">Terra Commission Range</div></div>
        </div>
        <div class="stat-box">
            <div class="stat-icon" style="background:rgba(45,122,79,.08)">👤</div>
            <div><div class="stat-val">{{ $maxPayout ?? 0 }}%</div><div class="stat-lbl">Max Consultant Payout</div></div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-wrap">
        @if($tiers->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📊</div>
            <h5 style="color:var(--terra-navy);font-family:var(--font-display);margin-bottom:8px">No tiers yet</h5>
            <p style="color:var(--terra-muted);font-size:.9rem;margin-bottom:20px">Create your first commission tier to start tracking consultant payouts.</p>
            <a href="{{ route('admin.commission-tiers.create') }}" class="btn-new" style="display:inline-flex">+ Create First Tier</a>
        </div>
        @else
        <table class="tiers-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Label</th>
                    <th>Service Value Range</th>
                    <th>Terra Commission</th>
                    <th>Consultant Payout</th>
                    <th>Split Visual</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tiers as $i => $tier)
                <tr>
                    {{-- # --}}
                    <td style="color:var(--terra-muted);font-size:.82rem">{{ $i + 1 }}</td>

                    {{-- Label --}}
                    <td>
                        <span style="font-weight:600;color:var(--terra-navy)">{{ $tier->label }}</span>
                    </td>

                    {{-- Range --}}
                    <td>
                        <div class="range-val">{{ $tier->range_description }}</div>
                    </td>

                    {{-- Terra commission --}}
                    <td>
                        <span class="comm-pill comm-terra">
                            🏢 {{ $tier->terra_commission_pct }}%
                        </span>
                    </td>

                    {{-- Consultant payout --}}
                    <td>
                        <span class="comm-pill comm-consultant">
                            👤 {{ $tier->consultant_payout_pct }}%
                        </span>
                    </td>

                    {{-- Split visual --}}
                    <td style="min-width:140px">
                        <div style="display:flex;align-items:center;gap:6px">
                            <div style="font-size:.7rem;color:var(--terra-orange);font-weight:600;width:28px">{{ $tier->terra_commission_pct }}%</div>
                            <div style="flex:1;height:8px;border-radius:4px;overflow:hidden;background:var(--terra-border)">
                                <div style="height:100%;width:{{ $tier->terra_commission_pct }}%;background:linear-gradient(90deg,var(--terra-navy),var(--terra-orange));border-radius:4px"></div>
                            </div>
                            <div style="font-size:.7rem;color:#2d7a4f;font-weight:600;width:28px">{{ $tier->consultant_payout_pct }}%</div>
                        </div>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.commission-tiers.show', $tier) }}" class="act-btn act-view">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                View
                            </a>
                            <a href="{{ route('admin.commission-tiers.edit', $tier) }}" class="act-btn act-edit">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.commission-tiers.destroy', $tier) }}"
                                onsubmit="return confirm('Delete tier: {{ $tier->label }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn act-del">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>
@endsection