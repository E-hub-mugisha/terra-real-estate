@extends('layouts.users')

@section('title', 'Earnings — Terra')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --navy:      #19265d;
        --navy-80:   rgba(25, 38, 93, 0.08);
        --gold:      #D05208;
        --gold-10:   rgba(208, 82, 8, 0.10);
        --gold-20:   rgba(208, 82, 8, 0.18);
        --cream:     #FAF8F5;
        --white:     #ffffff;
        --text:      #1a1a2e;
        --muted:     #6b7280;
        --border:    #e5e0d8;
        --paid:      #0f6844;
        --paid-bg:   #eaf5ee;
        --escrow:    #7c5c00;
        --escrow-bg: #fef9ec;
        --pending:   #1e40af;
        --pending-bg:#eef2ff;

        --font-serif: 'Cormorant Garamond', Georgia, serif;
        --font-sans:  'DM Sans', system-ui, sans-serif;

        --shadow-card: 0 1px 4px rgba(25,38,93,0.08), 0 4px 24px rgba(25,38,93,0.06);
        --shadow-hover: 0 4px 16px rgba(25,38,93,0.14);
        --radius:    14px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    .earnings-wrap {
        font-family: var(--font-sans);
        background: var(--cream);
        min-height: 100vh;
        padding: 2rem 2rem 4rem;
        color: var(--text);
    }

    /* ─── Page header ─────────────────────── */
    .earnings-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .earnings-header h1 {
        font-family: var(--font-serif);
        font-size: 2rem;
        font-weight: 500;
        color: var(--navy);
        letter-spacing: -0.01em;
        line-height: 1.1;
    }
    .earnings-header h1 span {
        display: block;
        font-family: var(--font-sans);
        font-size: 0.78rem;
        font-weight: 400;
        color: var(--muted);
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 0.2rem;
    }
    .header-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .payout-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0.5rem 0.9rem;
        font-size: 0.8rem;
        color: var(--muted);
    }
    .payout-badge strong { color: var(--navy); font-weight: 600; }
    .payout-badge svg { color: var(--gold); }

    /* ─── Summary cards ────────────────────── */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.1rem;
        margin-bottom: 1.8rem;
    }
    @media (max-width: 1100px) { .summary-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 600px)  { .summary-grid { grid-template-columns: 1fr; } }

    .sum-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.4rem 1.5rem 1.3rem;
        box-shadow: var(--shadow-card);
        position: relative;
        overflow: hidden;
        transition: box-shadow .2s, transform .2s;
    }
    .sum-card:hover { box-shadow: var(--shadow-hover); transform: translateY(-1px); }
    .sum-card.featured {
        background: var(--navy);
        border-color: var(--navy);
    }
    .sum-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 80px; height: 80px;
        background: var(--navy-80);
        border-radius: 50%;
        transform: translate(30px, -30px);
        pointer-events: none;
    }
    .sum-card.featured::after { background: rgba(255,255,255,0.05); }

    .sum-label {
        font-size: 0.72rem;
        font-weight: 500;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.65rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .sum-card.featured .sum-label { color: rgba(255,255,255,0.6); }

    .sum-amount {
        font-family: var(--font-serif);
        font-size: 1.9rem;
        font-weight: 500;
        color: var(--navy);
        letter-spacing: -0.02em;
        line-height: 1;
    }
    .sum-card.featured .sum-amount { color: #fff; }

    .sum-currency {
        font-family: var(--font-sans);
        font-size: 0.85rem;
        font-weight: 400;
        margin-right: 3px;
        opacity: 0.7;
    }

    .sum-sub {
        margin-top: 0.7rem;
        font-size: 0.76rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
    .sum-card.featured .sum-sub { color: rgba(255,255,255,0.55); }

    .delta {
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
        font-size: 0.73rem;
        font-weight: 600;
        padding: 0.15rem 0.45rem;
        border-radius: 20px;
    }
    .delta.up   { background: #eaf5ee; color: #0f6844; }
    .delta.down { background: #fef2f2; color: #b91c1c; }
    .delta.neutral { background: var(--gold-10); color: var(--gold); }
    .sum-card.featured .delta.up { background: rgba(255,255,255,0.15); color: #a7f3d0; }

    .sum-icon {
        position: absolute;
        top: 1.2rem; right: 1.4rem;
        width: 36px; height: 36px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
        background: var(--navy-80);
    }
    .sum-card.featured .sum-icon { background: rgba(255,255,255,0.12); }
    .sum-icon svg { width: 18px; height: 18px; color: var(--navy); }
    .sum-card.featured .sum-icon svg { color: rgba(255,255,255,0.85); }

    /* ─── Transaction section ──────────────── */
    .tx-section {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .tx-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--border);
        gap: 1rem;
        flex-wrap: wrap;
    }
    .tx-toolbar-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .tx-toolbar h2 {
        font-family: var(--font-serif);
        font-size: 1.2rem;
        font-weight: 500;
        color: var(--navy);
    }
    .tx-count {
        background: var(--navy-80);
        color: var(--navy);
        font-size: 0.72rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        flex-wrap: wrap;
    }
    .filter-group label {
        font-size: 0.75rem;
        color: var(--muted);
        white-space: nowrap;
        font-weight: 500;
    }
    .filter-group input[type="date"],
    .filter-group select {
        height: 34px;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 0 0.75rem;
        font-family: var(--font-sans);
        font-size: 0.8rem;
        color: var(--text);
        background: var(--white);
        outline: none;
        transition: border-color .15s;
        cursor: pointer;
    }
    .filter-group input[type="date"]:focus,
    .filter-group select:focus { border-color: var(--navy); }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-family: var(--font-sans);
        font-size: 0.8rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: all .15s;
        white-space: nowrap;
        text-decoration: none;
    }
    .btn-outline {
        background: transparent;
        border: 1px solid var(--border);
        color: var(--navy);
    }
    .btn-outline:hover { border-color: var(--navy); background: var(--navy-80); }
    .btn-primary {
        background: var(--navy);
        color: #fff;
    }
    .btn-primary:hover { background: #0f1a44; }
    .btn-gold {
        background: var(--gold);
        color: #fff;
    }
    .btn-gold:hover { background: #b34506; }

    /* ─── Table ───────────────────────────── */
    .tx-table-wrap { overflow-x: auto; }

    table.tx-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.855rem;
    }
    .tx-table thead tr {
        background: var(--cream);
        border-bottom: 1.5px solid var(--border);
    }
    .tx-table th {
        padding: 0.75rem 1.1rem;
        text-align: left;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: var(--muted);
        white-space: nowrap;
    }
    .tx-table td {
        padding: 0.95rem 1.1rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        color: var(--text);
    }
    .tx-table tbody tr { transition: background .12s; }
    .tx-table tbody tr:hover { background: var(--cream); }
    .tx-table tbody tr:last-child td { border-bottom: none; }

    .tx-date {
        font-size: 0.82rem;
        color: var(--muted);
        white-space: nowrap;
    }
    .tx-ref {
        font-size: 0.7rem;
        color: var(--muted);
        font-family: 'Courier New', monospace;
        display: block;
        margin-top: 2px;
    }
    .tx-service {
        font-weight: 500;
        color: var(--navy);
        max-width: 220px;
    }
    .tx-service small {
        display: block;
        font-size: 0.75rem;
        font-weight: 400;
        color: var(--muted);
        margin-top: 1px;
    }
    .tx-client { color: var(--text); }

    .tx-amount {
        font-family: var(--font-serif);
        font-size: 1.05rem;
        font-weight: 500;
        color: var(--navy);
        white-space: nowrap;
    }
    .tx-amount .currency { font-size: 0.75rem; font-weight: 400; margin-right: 1px; }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-pill::before {
        content: '';
        width: 6px; height: 6px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-paid     { background: var(--paid-bg);    color: var(--paid);    }
    .status-paid::before { background: var(--paid); }
    .status-escrow   { background: var(--escrow-bg);  color: var(--escrow);  }
    .status-escrow::before { background: var(--escrow); }
    .status-pending  { background: var(--pending-bg); color: var(--pending); }
    .status-pending::before { background: var(--pending); }

    .actions-cell {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .icon-btn {
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 7px;
        border: 1px solid var(--border);
        background: transparent;
        cursor: pointer;
        color: var(--muted);
        transition: all .15s;
    }
    .icon-btn:hover { border-color: var(--navy); color: var(--navy); background: var(--navy-80); }
    .icon-btn svg { width: 14px; height: 14px; }

    /* ─── Empty / footer ──────────────────── */
    .tx-empty {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--muted);
        font-size: 0.9rem;
    }
    .tx-empty svg { width: 40px; height: 40px; margin-bottom: 0.75rem; opacity: 0.3; color: var(--navy); display: block; margin-inline: auto; }

    .tx-footer {
        padding: 0.9rem 1.5rem;
        border-top: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.78rem;
        color: var(--muted);
        background: var(--cream);
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .tx-footer strong { color: var(--navy); }

    /* ─── Invoice modal ───────────────────── */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(10,15,35,0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: var(--white);
        border-radius: var(--radius);
        width: 100%;
        max-width: 560px;
        box-shadow: 0 20px 60px rgba(25,38,93,0.3);
        overflow: hidden;
    }
    .modal-head {
        background: var(--navy);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .modal-head h3 {
        font-family: var(--font-serif);
        font-size: 1.15rem;
        color: #fff;
        font-weight: 500;
    }
    .modal-head p { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-top: 1px; }
    .modal-close {
        background: rgba(255,255,255,0.12);
        border: none;
        color: #fff;
        width: 30px; height: 30px;
        border-radius: 7px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        transition: background .15s;
    }
    .modal-close:hover { background: rgba(255,255,255,0.2); }

    /* Invoice preview inside modal */
    .invoice-preview {
        padding: 1.5rem;
    }
    .invoice-preview .inv-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    .inv-logo {
        font-family: var(--font-serif);
        font-size: 1.4rem;
        font-weight: 500;
        color: var(--navy);
    }
    .inv-logo small {
        display: block;
        font-family: var(--font-sans);
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--muted);
        font-weight: 400;
    }
    .inv-ref-block { text-align: right; }
    .inv-ref-block .inv-ref {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--navy);
        font-family: monospace;
    }
    .inv-ref-block .inv-date {
        font-size: 0.75rem;
        color: var(--muted);
        margin-top: 2px;
    }
    .inv-divider { border: none; border-top: 1px solid var(--border); margin: 1rem 0; }
    .inv-parties {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.2rem;
    }
    .inv-party-label {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.4rem;
    }
    .inv-party-name { font-weight: 600; font-size: 0.88rem; color: var(--navy); }
    .inv-party-sub  { font-size: 0.77rem; color: var(--muted); margin-top: 1px; }

    .inv-line-table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
    .inv-line-table th {
        background: var(--cream);
        padding: 0.5rem 0.75rem;
        font-size: 0.68rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--muted);
        text-align: left;
    }
    .inv-line-table td {
        padding: 0.65rem 0.75rem;
        font-size: 0.83rem;
        border-bottom: 1px solid var(--border);
        color: var(--text);
    }
    .inv-line-table td:last-child { text-align: right; font-weight: 500; color: var(--navy); }
    .inv-total-row td {
        border-top: 2px solid var(--navy);
        border-bottom: none;
        font-weight: 600;
        font-family: var(--font-serif);
        font-size: 1rem;
        color: var(--navy);
    }
    .inv-footer-note {
        font-size: 0.72rem;
        color: var(--muted);
        text-align: center;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border);
    }

    .modal-actions {
        padding: 1rem 1.5rem;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: flex-end;
        gap: 0.6rem;
    }

    /* animations */
    .sum-card { animation: fadeUp .35s both; }
    .sum-card:nth-child(1) { animation-delay: .05s; }
    .sum-card:nth-child(2) { animation-delay: .10s; }
    .sum-card:nth-child(3) { animation-delay: .15s; }
    .sum-card:nth-child(4) { animation-delay: .20s; }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>



<div class="earnings-wrap">

    {{-- Page header --}}
    <div class="earnings-header">
        <h1>
            <span>Financial Overview</span>
            Earnings
        </h1>
        <div class="header-meta">
            <div class="payout-badge">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                Next payout: <strong>{{ $nextPayoutDate }}</strong>
            </div>
        </div>
    </div>

    {{-- Summary cards --}}
    <div class="summary-grid">
        {{-- Total earned --}}
        <div class="sum-card featured">
            <div class="sum-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                </svg>
            </div>
            <div class="sum-label">Total Earned (All Time)</div>
            <div class="sum-amount"><span class="sum-currency">RWF</span>{{ number_format($totalEarned) }}</div>
            <div class="sum-sub">
                <span class="delta up">{{ $totalBookingCount }} bookings</span>
                across all time
            </div>
        </div>

        {{-- This month --}}
        <div class="sum-card">
            <div class="sum-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="sum-label">This Month</div>
            <div class="sum-amount"><span class="sum-currency">RWF</span>{{ number_format($thisMonthEarned) }}</div>
            <div class="sum-sub">
                @if($monthlyChange >= 0)
                    <span class="delta up">↑ {{ abs($monthlyChange) }}%</span> vs last month
                @else
                    <span class="delta down">↓ {{ abs($monthlyChange) }}%</span> vs last month
                @endif
            </div>
        </div>

        {{-- Pending / In escrow --}}
        <div class="sum-card">
            <div class="sum-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <div class="sum-label">Pending / In Escrow</div>
            <div class="sum-amount"><span class="sum-currency">RWF</span>{{ number_format($pendingBalance) }}</div>
            <div class="sum-sub">
                <span class="delta neutral">{{ $pendingCount }} transactions</span>
                awaiting release
            </div>
        </div>

        {{-- Last month reference --}}
        <div class="sum-card">
            <div class="sum-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="sum-label">Last Month</div>
            <div class="sum-amount"><span class="sum-currency">RWF</span>{{ number_format($lastMonthEarned) }}</div>
            <div class="sum-sub">
                <span class="delta neutral">{{ $lastMonthCount }} bookings</span>
                completed
            </div>
        </div>
    </div>

    {{-- Transaction table --}}
    <div class="tx-section">
        <div class="tx-toolbar">
            <div class="tx-toolbar-left">
                <h2>Transactions</h2>
                <span class="tx-count" id="visibleCount">{{ count($bookings) }}</span>

                <div class="filter-group">
                    <label>From</label>
                    <input type="date" id="dateFrom" value="{{ request('from') }}">
                    <label>To</label>
                    <input type="date" id="dateTo" value="{{ request('to') }}">

                    <select id="statusFilter">
                        <option value="">All statuses</option>
                        <option value="paid">Paid out</option>
                        <option value="escrow">In escrow</option>
                        <option value="pending">Pending</option>
                    </select>

                    <button class="btn btn-outline" onclick="applyFilters()">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M7 10h10M11 16h2"/>
                        </svg>
                        Filter
                    </button>
                    <button class="btn btn-outline" onclick="clearFilters()">Clear</button>
                </div>
            </div>

            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                <button class="btn btn-outline" onclick="exportCSV()">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Export CSV
                </button>
            </div>
        </div>

        <div class="tx-table-wrap">
            <table class="tx-table" id="txTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Booking / Service</th>
                        <th>Client</th>
                        <th>Amount (RWF)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="txBody">
                @forelse($bookings as $booking)
                    @php
                        $statusKey = match($booking->payment_status) {
                            'paid'    => 'paid',
                            'escrow'  => 'escrow',
                            default   => 'pending',
                        };
                        $statusLabel = match($statusKey) {
                            'paid'   => 'Paid out',
                            'escrow' => 'In escrow',
                            default  => 'Pending',
                        };
                    @endphp
                    <tr
                        data-date="{{ $booking->appointment_date->format('Y-m-d') }}"
                        data-status="{{ $statusKey }}"
                        data-id="{{ $booking->id }}"
                    >
                        <td>
                            <div class="tx-date">{{ $booking->appointment_date->format('d M Y') }}</div>
                            <span class="tx-ref">{{ $booking->reference }}</span>
                        </td>
                        <td>
                            <div class="tx-service">
                                {{ $booking->service->name ?? 'Consultation' }}
                                <small>{{ $booking->district }}, {{ $booking->province }}</small>
                            </div>
                        </td>
                        <td class="tx-client">{{ $booking->client_name }}</td>
                        <td>
                            <div class="tx-amount">
                                <span class="currency">RWF</span>{{ number_format($booking->fee) }}
                            </div>
                        </td>
                        <td>
                            <span class="status-pill status-{{ $statusKey }}">{{ $statusLabel }}</span>
                        </td>
                        <td>
                            <div class="actions-cell">
                                <button class="icon-btn"
                                    title="View invoice"
                                    onclick="openInvoice({
                                        ref: '{{ $booking->reference }}',
                                        date: '{{ $booking->appointment_date->format('d M Y') }}',
                                        service: '{{ addslashes($booking->service->name ?? 'Consultation') }}',
                                        location: '{{ $booking->district }}, {{ $booking->province }}',
                                        client: '{{ addslashes($booking->client_name) }}',
                                        clientEmail: '{{ $booking->client_email }}',
                                        amount: {{ $booking->fee }},
                                        status: '{{ $statusLabel }}',
                                        consultant: '{{ addslashes(auth()->user()->name) }}'
                                    })">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="tx-empty">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                No transactions found for the selected period.
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="tx-footer">
            <span>Showing <strong id="footerCount">{{ count($bookings) }}</strong> transactions</span>
            <span>All amounts in Rwandan Francs (RWF)</span>
        </div>
    </div>
</div>

{{-- Invoice Modal --}}
<div class="modal-overlay" id="invoiceModal">
    <div class="modal-box">
        <div class="modal-head">
            <div>
                <h3>Tax Invoice</h3>
                <p id="modalRef">—</p>
            </div>
            <button class="modal-close" onclick="closeInvoice()">✕</button>
        </div>

        <div class="invoice-preview" id="invoiceContent">
            <div class="inv-header">
                <div class="inv-logo">
                    Terra<small>Real Estate Platform</small>
                </div>
                <div class="inv-ref-block">
                    <div class="inv-ref" id="invRef">—</div>
                    <div class="inv-date" id="invDate">—</div>
                </div>
            </div>

            <hr class="inv-divider">

            <div class="inv-parties">
                <div>
                    <div class="inv-party-label">From (Consultant)</div>
                    <div class="inv-party-name" id="invConsultant">—</div>
                    <div class="inv-party-sub">terra.rw</div>
                </div>
                <div>
                    <div class="inv-party-label">Bill To</div>
                    <div class="inv-party-name" id="invClient">—</div>
                    <div class="inv-party-sub" id="invClientEmail">—</div>
                </div>
            </div>

            <table class="inv-line-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="invService">—</td>
                        <td id="invLocation">—</td>
                        <td id="invAmount">—</td>
                    </tr>
                    <tr class="inv-total-row">
                        <td colspan="2">Total Due</td>
                        <td id="invTotal">—</td>
                    </tr>
                </tbody>
            </table>

            <div class="inv-footer-note">
                Generated by Terra · terra.rw · This document serves as an official record for tax purposes.
            </div>
        </div>

        <div class="modal-actions">
            <button class="btn btn-outline" onclick="closeInvoice()">Close</button>
            <button class="btn btn-primary" onclick="downloadInvoicePDF()">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                </svg>
                Download PDF
            </button>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
/* ── Filter logic ────────────────────────────────── */
let allRows = Array.from(document.querySelectorAll('#txBody tr[data-date]'));

function applyFilters() {
    const from   = document.getElementById('dateFrom').value;
    const to     = document.getElementById('dateTo').value;
    const status = document.getElementById('statusFilter').value;

    let visible = 0;
    allRows.forEach(row => {
        const d   = row.dataset.date;
        const s   = row.dataset.status;
        const okDate   = (!from || d >= from) && (!to || d <= to);
        const okStatus = !status || s === status;
        const show = okDate && okStatus;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('visibleCount').textContent = visible;
    document.getElementById('footerCount').textContent  = visible;
}

function clearFilters() {
    document.getElementById('dateFrom').value  = '';
    document.getElementById('dateTo').value    = '';
    document.getElementById('statusFilter').value = '';
    allRows.forEach(r => r.style.display = '');
    const n = allRows.length;
    document.getElementById('visibleCount').textContent = n;
    document.getElementById('footerCount').textContent  = n;
}

/* ── CSV export ──────────────────────────────────── */
function exportCSV() {
    const headers = ['Date','Reference','Service','Location','Client','Amount (RWF)','Status'];
    const rows    = allRows
        .filter(r => r.style.display !== 'none')
        .map(r => {
            const cells = r.querySelectorAll('td');
            const dateText   = cells[0].querySelector('.tx-date').textContent.trim();
            const ref        = cells[0].querySelector('.tx-ref').textContent.trim();
            const service    = cells[1].querySelector('.tx-service').childNodes[0].textContent.trim();
            const location   = cells[1].querySelector('small').textContent.trim();
            const client     = cells[2].textContent.trim();
            const amount     = cells[3].textContent.replace(/[^0-9]/g, '');
            const status     = cells[4].textContent.trim();
            return [dateText, ref, service, location, client, amount, status];
        });

    const csv = [headers, ...rows].map(r => r.map(v => `"${v}"`).join(',')).join('\n');
    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url  = URL.createObjectURL(blob);
    const a    = document.createElement('a');
    a.href = url;
    a.download = `terra_earnings_${new Date().toISOString().slice(0,10)}.csv`;
    a.click();
    URL.revokeObjectURL(url);
}

/* ── Invoice modal ───────────────────────────────── */
let currentInvoice = null;

function openInvoice(data) {
    currentInvoice = data;
    document.getElementById('modalRef').textContent     = data.ref;
    document.getElementById('invRef').textContent       = data.ref;
    document.getElementById('invDate').textContent      = 'Date: ' + data.date;
    document.getElementById('invConsultant').textContent = data.consultant;
    document.getElementById('invClient').textContent    = data.client;
    document.getElementById('invClientEmail').textContent = data.clientEmail;
    document.getElementById('invService').textContent   = data.service;
    document.getElementById('invLocation').textContent  = data.location;

    const fmt = n => 'RWF ' + Number(n).toLocaleString();
    document.getElementById('invAmount').textContent = fmt(data.amount);
    document.getElementById('invTotal').textContent  = fmt(data.amount);

    document.getElementById('invoiceModal').classList.add('open');
}

function closeInvoice() {
    document.getElementById('invoiceModal').classList.remove('open');
}

/* Close on overlay click */
document.getElementById('invoiceModal').addEventListener('click', function(e) {
    if (e.target === this) closeInvoice();
});

/* ── PDF generation ──────────────────────────────── */
function downloadInvoicePDF() {
    if (!currentInvoice) return;
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ unit: 'mm', format: 'a4' });

    const navy  = [25, 38, 93];
    const gold  = [208, 82, 8];
    const grey  = [107, 114, 128];
    const light = [245, 243, 240];

    // Header bar
    doc.setFillColor(...navy);
    doc.rect(0, 0, 210, 36, 'F');

    doc.setTextColor(255, 255, 255);
    doc.setFontSize(22);
    doc.setFont('helvetica', 'bold');
    doc.text('Terra', 15, 18);

    doc.setFontSize(7);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(180, 185, 210);
    doc.text('REAL ESTATE PLATFORM', 15, 23);

    doc.setFontSize(9);
    doc.setTextColor(255, 255, 255);
    doc.text('TAX INVOICE', 195, 14, { align: 'right' });
    doc.setFontSize(8);
    doc.setTextColor(180, 185, 210);
    doc.text(currentInvoice.ref, 195, 20, { align: 'right' });
    doc.text('Date: ' + currentInvoice.date, 195, 26, { align: 'right' });

    // Parties
    let y = 50;
    doc.setFontSize(7);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...grey);
    doc.text('FROM (CONSULTANT)', 15, y);
    doc.text('BILL TO', 110, y);

    y += 6;
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...navy);
    doc.text(currentInvoice.consultant, 15, y);
    doc.text(currentInvoice.client, 110, y);

    y += 5;
    doc.setFontSize(8);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(...grey);
    doc.text('terra.rw', 15, y);
    doc.text(currentInvoice.clientEmail, 110, y);

    // Divider
    y += 12;
    doc.setDrawColor(...navy);
    doc.setLineWidth(0.3);
    doc.line(15, y, 195, y);

    // Table header
    y += 8;
    doc.setFillColor(...light);
    doc.rect(15, y - 5, 180, 10, 'F');

    doc.setFontSize(7.5);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...grey);
    doc.text('DESCRIPTION', 18, y);
    doc.text('LOCATION', 110, y);
    doc.text('AMOUNT', 195, y, { align: 'right' });

    // Table row
    y += 12;
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(9);
    doc.setTextColor(...navy);
    doc.text(currentInvoice.service, 18, y);

    doc.setTextColor(...grey);
    doc.text(currentInvoice.location, 110, y);

    doc.setFont('helvetica', 'bold');
    doc.setTextColor(...navy);
    doc.text('RWF ' + Number(currentInvoice.amount).toLocaleString(), 195, y, { align: 'right' });

    // Total
    y += 16;
    doc.setLineWidth(0.8);
    doc.setDrawColor(...navy);
    doc.line(110, y, 195, y);
    y += 8;
    doc.setFont('helvetica', 'bold');
    doc.setFontSize(11);
    doc.setTextColor(...navy);
    doc.text('TOTAL DUE', 110, y);
    doc.setTextColor(...gold);
    doc.text('RWF ' + Number(currentInvoice.amount).toLocaleString(), 195, y, { align: 'right' });

    // Status badge
    y += 14;
    doc.setFontSize(8);
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(...grey);
    doc.text('Payment status: ' + currentInvoice.status, 15, y);

    // Footer
    doc.setFillColor(...navy);
    doc.rect(0, 277, 210, 20, 'F');
    doc.setFontSize(7.5);
    doc.setTextColor(180, 185, 210);
    doc.text('Generated by Terra · terra.rw · This document is an official record for tax purposes.', 105, 288, { align: 'center' });

    doc.save(`invoice_${currentInvoice.ref}.pdf`);
}
</script>
@endsection