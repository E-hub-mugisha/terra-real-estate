@extends('layouts.app')
@section('title', 'Agent Commissions')
@section('content')

<style>
/* ── Page header ── */
.cm-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:24px; }
.cm-title { font-size:1.15rem; font-weight:700; color:#0f172a; margin:0; }
.cm-subtitle { font-size:.78rem; color:#94a3b8; margin:2px 0 0; }

/* ── Stat cards ── */
.cm-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:14px; margin-bottom:24px; }
.cm-stat { background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:18px 20px; position:relative; overflow:hidden; }
.cm-stat::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:12px 12px 0 0; }
.cm-stat.pending::before  { background:#f59e0b; }
.cm-stat.approved::before { background:#3b82f6; }
.cm-stat.paid::before     { background:#22c55e; }
.cm-stat-label { font-size:.7rem; font-weight:600; text-transform:uppercase; letter-spacing:.07em; color:#94a3b8; margin-bottom:8px; display:flex; align-items:center; gap:6px; }
.cm-stat-label span { width:8px; height:8px; border-radius:50%; display:inline-block; }
.cm-stat.pending  .cm-stat-label span { background:#f59e0b; }
.cm-stat.approved .cm-stat-label span { background:#3b82f6; }
.cm-stat.paid     .cm-stat-label span { background:#22c55e; }
.cm-stat-val { font-size:1.45rem; font-weight:800; color:#0f172a; letter-spacing:-.02em; line-height:1; }
.cm-stat-unit { font-size:.7rem; color:#94a3b8; margin-top:4px; }

/* ── Toolbar ── */
.cm-toolbar { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:16px; }
.cm-search { position:relative; flex:1; min-width:200px; max-width:320px; }
.cm-search input { width:100%; padding:8px 12px 8px 34px; border:1px solid #e2e8f0; border-radius:8px; font-size:.82rem; color:#334155; background:#fff; outline:none; transition:border-color .18s; }
.cm-search input:focus { border-color:#3b82f6; }
.cm-search svg { position:absolute; left:10px; top:50%; transform:translateY(-50%); width:14px; height:14px; color:#94a3b8; pointer-events:none; }
.cm-filter select { padding:8px 12px; border:1px solid #e2e8f0; border-radius:8px; font-size:.82rem; color:#334155; background:#fff; outline:none; cursor:pointer; }
.cm-filter select:focus { border-color:#3b82f6; }

/* ── Table card ── */
.cm-card { background:#fff; border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; }
.cm-table { width:100%; border-collapse:collapse; font-size:.81rem; }
.cm-table thead tr { background:#f8fafc; border-bottom:1px solid #e5e7eb; }
.cm-table thead th { padding:11px 14px; font-size:.68rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.07em; white-space:nowrap; }
.cm-table tbody tr { border-bottom:1px solid #f1f5f9; transition:background .12s; }
.cm-table tbody tr:last-child { border-bottom:none; }
.cm-table tbody tr:hover { background:#f8fafc; }
.cm-table td { padding:12px 14px; vertical-align:middle; color:#334155; }

/* Agent cell */
.cm-agent { display:flex; align-items:center; gap:9px; }
.cm-agent-av { width:32px; height:32px; border-radius:50%; background:#eff6ff; border:1.5px solid #bfdbfe; display:grid; place-items:center; font-weight:700; font-size:.78rem; color:#2563eb; flex-shrink:0; }
.cm-agent-name { font-weight:600; color:#1e293b; font-size:.82rem; white-space:nowrap; }
.cm-agent-email { font-size:.71rem; color:#94a3b8; }

/* Property cell */
.cm-prop-title { font-weight:600; color:#1e293b; font-size:.82rem; max-width:160px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.cm-prop-type { display:inline-flex; align-items:center; gap:4px; padding:2px 7px; border-radius:5px; font-size:.65rem; font-weight:700; text-transform:uppercase; letter-spacing:.05em; margin-top:3px; }
.cm-pt-house  { background:#eff6ff; color:#1d4ed8; }
.cm-pt-land   { background:#f0fdf4; color:#166534; }
.cm-pt-design { background:#fdf4ff; color:#7e22ce; }

/* Commission amounts */
.cm-amount { font-weight:700; color:#0f172a; white-space:nowrap; }
.cm-amount-sub { font-size:.7rem; color:#94a3b8; margin-top:2px; white-space:nowrap; }

/* Status badges */
.cm-status { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:6px; font-size:.68rem; font-weight:700; letter-spacing:.05em; text-transform:uppercase; white-space:nowrap; }
.cm-status::before { content:''; width:5px; height:5px; border-radius:50%; background:currentColor; }
.cm-s-pending  { background:#fef9c3; color:#854d0e; }
.cm-s-approved { background:#dbeafe; color:#1d4ed8; }
.cm-s-paid     { background:#dcfce7; color:#166534; }
.cm-s-none     { background:#f1f5f9; color:#94a3b8; }

/* Actions */
.cm-actions { display:flex; gap:5px; }
.cm-act-btn { width:28px; height:28px; border-radius:7px; border:1px solid #e2e8f0; background:#fff; display:grid; place-items:center; cursor:pointer; color:#64748b; transition:all .15s; text-decoration:none; }
.cm-act-btn:hover { border-color:#3b82f6; color:#2563eb; background:#eff6ff; }
.cm-act-btn.danger:hover { border-color:#fca5a5; color:#dc2626; background:#fef2f2; }
.cm-act-btn svg { width:12px; height:12px; }

/* Empty state */
.cm-empty { padding:56px 24px; text-align:center; }
.cm-empty svg { width:44px; height:44px; color:#cbd5e1; margin-bottom:12px; }
.cm-empty h6 { font-size:.9rem; color:#475569; margin-bottom:4px; }
.cm-empty p  { font-size:.78rem; color:#94a3b8; margin:0; }

/* Pagination */
.cm-pagination { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; padding:14px 18px; border-top:1px solid #f1f5f9; }
.cm-pag-info { font-size:.75rem; color:#94a3b8; }
</style>

{{-- ── Page Header ── --}}
<div class="cm-header">
    <div>
        <h5 class="cm-title">Agent Commissions</h5>
        <p class="cm-subtitle">Track listing and sale commissions across all agents</p>
    </div>
    <a href="#" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
        <svg viewBox="0 0 24 24" fill="currentColor" style="width:13px;height:13px"><path d="M13 10h5l-6 6-6-6h5V3h2v7zm-9 9h16v2H4v-2z"/></svg>
        Export CSV
    </a>
</div>

{{-- ── Stat Cards ── --}}
<div class="cm-stats">
    <div class="cm-stat pending">
        <div class="cm-stat-label"><span></span>Pending</div>
        <div class="cm-stat-val">{{ number_format($totals['pending']) }}</div>
        <div class="cm-stat-unit">RWF awaiting approval</div>
    </div>
    <div class="cm-stat approved">
        <div class="cm-stat-label"><span></span>Approved</div>
        <div class="cm-stat-val">{{ number_format($totals['approved']) }}</div>
        <div class="cm-stat-unit">RWF approved, not yet paid</div>
    </div>
    <div class="cm-stat paid">
        <div class="cm-stat-label"><span></span>Paid Out</div>
        <div class="cm-stat-val">{{ number_format($totals['paid']) }}</div>
        <div class="cm-stat-unit">RWF successfully disbursed</div>
    </div>
    <div class="cm-stat" style="border-top:3px solid #e2e8f0;">
        <div class="cm-stat-label" style="color:#94a3b8"><span style="background:#e2e8f0"></span>Total Records</div>
        <div class="cm-stat-val">{{ $commissions->total() }}</div>
        <div class="cm-stat-unit">commission entries</div>
    </div>
</div>

{{-- ── Toolbar ── --}}
<div class="cm-toolbar">
    <div class="cm-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" id="cm-search-input" placeholder="Search agent or property…">
    </div>
    <div class="cm-filter">
        <select id="cm-status-filter" onchange="filterTable()">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="paid">Paid</option>
        </select>
    </div>
    <div class="cm-filter">
        <select id="cm-type-filter" onchange="filterTable()">
            <option value="">All Types</option>
            <option value="house">House</option>
            <option value="land">Land</option>
            <option value="design">Design</option>
        </select>
    </div>
</div>

{{-- ── Table ── --}}
<div class="cm-card">
    @if($commissions->isEmpty())
    <div class="cm-empty">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/></svg>
        <h6>No commission records found</h6>
        <p>Commissions will appear here once agents complete property plan payments.</p>
    </div>
    @else
    <div style="overflow-x:auto">
        <table class="cm-table" id="cm-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Agent</th>
                    <th>Property</th>
                    <th>Listing Commission</th>
                    <th>Sale Commission</th>
                    <th>Listing Status</th>
                    <th>Sale Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commissions as $index => $commission)
                @php
                    $propType = strtolower($commission->property_type ?? '');
                    $ptClass  = match($propType) {
                        'house'  => 'cm-pt-house',
                        'land'   => 'cm-pt-land',
                        'design' => 'cm-pt-design',
                        default  => 'cm-pt-house',
                    };
                    $agent = $commission->agent;
                @endphp
                <tr data-listing-status="{{ $commission->listing_commission_status }}"
                    data-sale-status="{{ $commission->sale_commission_status }}"
                    data-type="{{ $propType }}">

                    {{-- # --}}
                    <td class="text-muted" style="font-size:.72rem">
                        {{ $commissions->firstItem() + $index }}
                    </td>

                    {{-- Agent --}}
                    <td>
                        <div class="cm-agent">
                            <div class="cm-agent-av">{{ strtoupper(substr($agent?->user?->name ?? $agent?->name ?? 'A', 0, 1)) }}</div>
                            <div>
                                <div class="cm-agent-name">{{ $agent?->user?->name ?? $agent?->name ?? '—' }}</div>
                                <div class="cm-agent-email">{{ $agent?->user?->email ?? '—' }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Property --}}
                    <td>
                        <div class="cm-prop-title" title="{{ $commission->property_title }}">
                            {{ $commission->property_title ?? '—' }}
                        </div>
                        <div>
                            <span class="cm-prop-type {{ $ptClass }}">{{ ucfirst($propType ?: '—') }}</span>
                        </div>
                    </td>

                    {{-- Listing Commission --}}
                    <td>
                        <div class="cm-amount">{{ number_format($commission->listing_commission ?? 0) }} <span style="font-weight:400;font-size:.7rem;color:#94a3b8">RWF</span></div>
                        <div class="cm-amount-sub">
                            @if($commission->listing_days && $commission->price_per_day)
                                {{ $commission->listing_days }}d × {{ number_format($commission->price_per_day) }}
                            @endif
                            @if($commission->listing_agent_pct)
                                · {{ $commission->listing_agent_pct }}%
                            @endif
                        </div>
                    </td>

                    {{-- Sale Commission --}}
                    <td>
                        @if($commission->sale_commission)
                        <div class="cm-amount">{{ number_format($commission->sale_commission) }} <span style="font-weight:400;font-size:.7rem;color:#94a3b8">RWF</span></div>
                        <div class="cm-amount-sub">
                            @if($commission->sale_price) Sale: {{ number_format($commission->sale_price) }} @endif
                            @if($commission->sale_commission_rate) · {{ $commission->sale_commission_rate }}% @endif
                        </div>
                        @else
                        <span class="text-muted" style="font-size:.75rem">—</span>
                        @endif
                    </td>

                    {{-- Listing Status --}}
                    <td>
                        @php $ls = $commission->listing_commission_status; @endphp
                        <span class="cm-status {{ match($ls){ 'pending'=>'cm-s-pending','approved'=>'cm-s-approved','paid'=>'cm-s-paid',default=>'cm-s-none' } }}">
                            {{ ucfirst($ls ?? 'none') }}
                        </span>
                        @if($commission->listing_commission_paid_at)
                        <div style="font-size:.67rem;color:#94a3b8;margin-top:3px">
                            {{ $commission->listing_commission_paid_at->format('d M Y') }}
                        </div>
                        @endif
                    </td>

                    {{-- Sale Status --}}
                    <td>
                        @php $ss = $commission->sale_commission_status; @endphp
                        <span class="cm-status {{ match($ss){ 'pending'=>'cm-s-pending','approved'=>'cm-s-approved','paid'=>'cm-s-paid',default=>'cm-s-none' } }}">
                            {{ ucfirst($ss ?? 'none') }}
                        </span>
                        @if($commission->sale_commission_paid_at)
                        <div style="font-size:.67rem;color:#94a3b8;margin-top:3px">
                            {{ $commission->sale_commission_paid_at->format('d M Y') }}
                        </div>
                        @endif
                    </td>

                    {{-- Date --}}
                    <td style="white-space:nowrap">
                        <div style="font-size:.8rem;color:#475569;font-weight:500">{{ $commission->created_at->format('d M Y') }}</div>
                        <div style="font-size:.7rem;color:#94a3b8">{{ $commission->created_at->format('H:i') }}</div>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="cm-actions">
                            <a href="{{ route('admin.commissions.show', $commission->id) }}" class="cm-act-btn" title="View">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @if($commission->listing_commission_status !== 'paid')
                            <a href="{{ route('admin.commissions.approve', $commission->id) }}" class="cm-act-btn" title="Approve">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </a>
                            @endif
                            <form method="POST" action="{{ route('admin.commissions.destroy', $commission->id) }}" onsubmit="return confirm('Delete this commission record?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="cm-act-btn danger" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="cm-pagination">
        <span class="cm-pag-info">
            Showing {{ $commissions->firstItem() }}–{{ $commissions->lastItem() }} of {{ $commissions->total() }} records
        </span>
        {{ $commissions->links() }}
    </div>
    @endif
</div>

<script>
(function () {
    const searchInput  = document.getElementById('cm-search-input');
    const statusFilter = document.getElementById('cm-status-filter');
    const typeFilter   = document.getElementById('cm-type-filter');

    function filter() {
        const q      = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        const type   = typeFilter.value.toLowerCase();

        document.querySelectorAll('#cm-table tbody tr').forEach(row => {
            const text       = row.innerText.toLowerCase();
            const rowStatus  = (row.dataset.listingStatus + ' ' + row.dataset.saleStatus).toLowerCase();
            const rowType    = (row.dataset.type || '').toLowerCase();

            const matchQ      = !q      || text.includes(q);
            const matchStatus = !status || rowStatus.includes(status);
            const matchType   = !type   || rowType === type;

            row.style.display = (matchQ && matchStatus && matchType) ? '' : 'none';
        });
    }

    if (searchInput)  searchInput.addEventListener('input', filter);
    if (statusFilter) statusFilter.addEventListener('change', filter);
    if (typeFilter)   typeFilter.addEventListener('change', filter);

    // expose for inline onchange fallback
    window.filterTable = filter;
})();
</script>

@endsection