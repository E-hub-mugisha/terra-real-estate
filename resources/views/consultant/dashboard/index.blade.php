@extends('layouts.users')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<style>
    /* ══════════════════════════════════════
       DASHBOARD TOKENS
    ══════════════════════════════════════ */
    :root {
        --card-r: 16px;
    }

    /* ── Welcome banner ── */
    .welcome-banner {
        background: var(--navy);
        border-radius: var(--card-r);
        padding: 2rem 2.25rem;
        margin-bottom: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -40px;
        right: 120px;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(208, 82, 8, .22) 0%, transparent 70%);
        pointer-events: none;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -20px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 255, 255, .04) 0%, transparent 70%);
        pointer-events: none;
    }

    .welcome-text {
        position: relative;
        z-index: 1;
    }

    .welcome-greeting {
        font-size: .8rem;
        font-weight: 500;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .4);
        margin-bottom: .35rem;
    }

    .welcome-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.9rem;
        font-weight: 600;
        color: #fff;
        line-height: 1.1;
        margin-bottom: .5rem;
    }

    .welcome-sub {
        font-size: .875rem;
        color: rgba(255, 255, 255, .5);
    }

    .welcome-sub strong {
        color: rgba(255, 255, 255, .8);
        font-weight: 500;
    }

    .welcome-action {
        position: relative;
        z-index: 1;
        background: var(--gold);
        color: #fff;
        padding: .65rem 1.4rem;
        border-radius: 9px;
        border: none;
        font-family: 'DM Sans', sans-serif;
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background .18s, transform .18s;
        display: flex;
        align-items: center;
        gap: .5rem;
        text-decoration: none;
    }

    .welcome-action:hover {
        background: var(--gold-hover);
        transform: translateY(-1px);
    }

    .welcome-action svg {
        width: 16px;
        height: 16px;
    }

    /* ── Stat cards ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .stat-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--card-r);
        padding: 1.4rem 1.5rem;
        box-shadow: var(--shadow-sm);
        position: relative;
        overflow: hidden;
        animation: fadeUp .4s ease both;
    }

    .stat-card:nth-child(1) {
        animation-delay: .05s;
    }

    .stat-card:nth-child(2) {
        animation-delay: .10s;
    }

    .stat-card:nth-child(3) {
        animation-delay: .15s;
    }

    .stat-card:nth-child(4) {
        animation-delay: .20s;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon svg {
        width: 20px;
        height: 20px;
    }

    .stat-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-icon.green {
        background: #d1fae5;
        color: #059669;
    }

    .stat-icon.amber {
        background: #fef3c7;
        color: #d97706;
    }

    .stat-icon.gold {
        background: var(--gold-pale);
        color: var(--gold);
    }

    .stat-trend {
        font-size: .72rem;
        font-weight: 600;
        padding: .2rem .55rem;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: .25rem;
    }

    .stat-trend.up {
        background: #d1fae5;
        color: #059669;
    }

    .stat-trend.down {
        background: #fee2e2;
        color: #dc2626;
    }

    .stat-trend svg {
        width: 11px;
        height: 11px;
    }

    .stat-value {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 600;
        color: var(--navy);
        line-height: 1;
        margin-bottom: .3rem;
    }

    .stat-label {
        font-size: .8rem;
        color: var(--muted);
    }

    /* Decorative corner */
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--cream);
        opacity: .6;
        pointer-events: none;
    }

    /* ── Two-col lower grid ── */
    .lower-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 1.25rem;
    }

    /* ── Section cards ── */
    .section-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: var(--card-r);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        animation: fadeUp .4s ease both;
        animation-delay: .25s;
    }

    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--navy);
    }

    .section-link {
        font-size: .78rem;
        font-weight: 500;
        color: var(--gold);
        transition: color .18s;
    }

    .section-link:hover {
        color: var(--gold-hover);
    }

    /* ── Recent bookings table ── */
    .bookings-mini {
        width: 100%;
        border-collapse: collapse;
    }

    .bookings-mini th {
        padding: .7rem 1.5rem;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        text-align: left;
        background: #fafaf9;
        border-bottom: 1px solid var(--border);
    }

    .bookings-mini td {
        padding: .85rem 1.5rem;
        font-size: .855rem;
        color: var(--navy);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    .bookings-mini tbody tr:last-child td {
        border-bottom: none;
    }

    .bookings-mini tbody tr {
        transition: background .15s;
    }

    .bookings-mini tbody tr:hover {
        background: #fafaf9;
    }

    .ref-pill {
        font-size: .73rem;
        font-weight: 600;
        letter-spacing: .04em;
        background: var(--gold-pale);
        color: var(--gold);
        border: 1px solid rgba(208, 82, 8, .18);
        padding: .18rem .5rem;
        border-radius: 5px;
    }

    .client-col {
        display: flex;
        flex-direction: column;
        gap: .08rem;
    }

    .client-col span:last-child {
        font-size: .75rem;
        color: var(--muted);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: .3rem;
        padding: .22rem .6rem;
        border-radius: 50px;
        font-size: .72rem;
        font-weight: 600;
    }

    .badge-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-rescheduled {
        background: #ede9fe;
        color: #4c1d95;
    }

    /* ── Right column ── */
    .right-col {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    /* ── Upcoming appointments ── */
    .appointment-list {
        padding: .5rem 0;
    }

    .appointment-item {
        display: flex;
        align-items: flex-start;
        gap: .9rem;
        padding: .85rem 1.5rem;
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }

    .appointment-item:last-child {
        border-bottom: none;
    }

    .appointment-item:hover {
        background: #fafaf9;
    }

    .appt-date {
        min-width: 44px;
        text-align: center;
        background: var(--navy);
        border-radius: 10px;
        padding: .45rem .35rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-shrink: 0;
    }

    .appt-day {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.35rem;
        font-weight: 600;
        color: #fff;
        line-height: 1;
    }

    .appt-month {
        font-size: .6rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .5);
    }

    .appt-info {
        flex: 1;
    }

    .appt-name {
        font-size: .875rem;
        font-weight: 500;
        color: var(--navy);
        margin-bottom: .15rem;
    }

    .appt-service {
        font-size: .77rem;
        color: var(--muted);
    }

    .appt-badge {
        margin-top: .3rem;
    }

    /* ── Quick stats mini ── */
    .quick-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .75rem;
        padding: 1.25rem 1.5rem;
    }

    .quick-item {
        background: var(--cream);
        border-radius: 10px;
        padding: .85rem 1rem;
    }

    .quick-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--navy);
        line-height: 1;
    }

    .quick-lbl {
        font-size: .72rem;
        color: var(--muted);
        margin-top: .25rem;
    }

    /* ── Performance bar ── */
    .perf-list {
        padding: 1rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: .85rem;
    }

    .perf-item-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: .35rem;
        font-size: .8rem;
        color: var(--navy);
    }

    .perf-item-label span:last-child {
        color: var(--muted);
        font-size: .75rem;
    }

    .perf-bar-track {
        height: 6px;
        background: var(--cream);
        border-radius: 50px;
        overflow: hidden;
    }

    .perf-bar-fill {
        height: 100%;
        border-radius: 50px;
        background: linear-gradient(90deg, var(--navy), var(--gold));
        transition: width 1s cubic-bezier(.4, 0, .2, 1);
    }

    /* ── Empty state ── */
    .empty-mini {
        text-align: center;
        padding: 2.5rem 1.5rem;
        color: var(--muted);
        font-size: .875rem;
    }

    .empty-mini svg {
        margin: 0 auto .75rem;
        display: block;
        opacity: .25;
    }

    /* ── Responsive ── */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .lower-grid {
            grid-template-columns: 1fr;
        }

        .right-col {
            grid-row: 1;
        }
    }

    @media (max-width: 600px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .welcome-action {
            display: none;
        }
    }
</style>


{{-- Welcome banner --}}
<div class="welcome-banner">
    <div class="welcome-text">
        <div class="welcome-greeting">{{ now()->format('l, d F Y') }}</div>
        <div class="welcome-name">Welcome back, {{ auth()->user()->name }}</div>
        <div class="welcome-sub">
            You have <strong>{{ $pendingBookings }} pending</strong> booking{{ $pendingBookings !== 1 ? 's' : '' }} waiting for your review.
        </div>
    </div>
    <a href="{{ route('consultant.bookings.index') }}" class="welcome-action">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Review Bookings
    </a>
</div>

{{-- Stat cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <span class="stat-trend up">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
                12%
            </span>
        </div>
        <div class="stat-value">{{ $totalBookings }}</div>
        <div class="stat-label">Total Bookings</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon green">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="stat-trend up">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
                8%
            </span>
        </div>
        <div class="stat-value">{{ $confirmedBookings }}</div>
        <div class="stat-label">Confirmed</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon amber">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <div class="stat-value">{{ $pendingBookings }}</div>
        <div class="stat-label">Awaiting Review</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon gold">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="stat-trend up">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                </svg>
                5%
            </span>
        </div>
        <div class="stat-value">{{ number_format($totalEarnings) }}<span style="font-size:1rem;font-weight:400;color:var(--muted);font-family:'DM Sans',sans-serif;"> RWF</span></div>
        <div class="stat-label">Total Earnings</div>
    </div>
</div>

{{-- Lower grid --}}
<div class="lower-grid">

    {{-- Recent bookings --}}
    <div class="section-card">
        <div class="section-head">
            <span class="section-title">Recent Bookings</span>
            <a href="{{ route('consultant.bookings.index') }}" class="section-link">View all →</a>
        </div>

        @if($recentBookings->isEmpty())
        <div class="empty-mini">
            <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p>No bookings yet.</p>
        </div>
        @else
        <table class="bookings-mini">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $booking)
                <tr>
                    <td><span class="ref-pill">{{ $booking->reference }}</span></td>
                    <td>
                        <div class="client-col">
                            <span>{{ $booking->client_name }}</span>
                            <span>{{ $booking->client_email }}</span>
                        </div>
                    </td>
                    <td>{{ $booking->service->name ?? '—' }}</td>
                    <td>{{ $booking->appointment_date->format('d M Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $booking->status }}">
                            <span class="badge-dot"></span>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- Right column --}}
    <div class="right-col">

        {{-- Upcoming appointments --}}
        <div class="section-card" style="animation-delay:.3s;">
            <div class="section-head">
                <span class="section-title">Upcoming</span>
                <a href="{{ route('consultant.bookings.index') }}" class="section-link">All →</a>
            </div>
            <div class="appointment-list">
                @forelse($upcomingBookings as $booking)
                <div class="appointment-item">
                    <div class="appt-date">
                        <span class="appt-day">{{ $booking->appointment_date->format('d') }}</span>
                        <span class="appt-month">{{ $booking->appointment_date->format('M') }}</span>
                    </div>
                    <div class="appt-info">
                        <div class="appt-name">{{ $booking->client_name }}</div>
                        <div class="appt-service">{{ $booking->service->name ?? 'Consultation' }}</div>
                        <div class="appt-badge">
                            <span class="badge badge-{{ $booking->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-mini">
                    <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>No upcoming appointments.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Quick stats --}}
        <div class="section-card" style="animation-delay:.35s;">
            <div class="section-head">
                <span class="section-title">This Month</span>
            </div>
            <div class="quick-grid">
                <div class="quick-item">
                    <div class="quick-val">{{ $monthBookings }}</div>
                    <div class="quick-lbl">Bookings</div>
                </div>
                <div class="quick-item">
                    <div class="quick-val">{{ $monthConfirmed }}</div>
                    <div class="quick-lbl">Confirmed</div>
                </div>
                <div class="quick-item">
                    <div class="quick-val">{{ $uniqueClients }}</div>
                    <div class="quick-lbl">Clients</div>
                </div>
                <div class="quick-item">
                    <div class="quick-val">{{ $activeServices }}</div>
                    <div class="quick-lbl">Services</div>
                </div>
            </div>
        </div>

        {{-- Performance --}}
        <div class="section-card" style="animation-delay:.4s;">
            <div class="section-head">
                <span class="section-title">Performance</span>
            </div>
            <div class="perf-list">
                @php
                $acceptRate = $totalBookings > 0 ? round(($confirmedBookings / $totalBookings) * 100) : 0;
                $rejectRate = $totalBookings > 0 ? round(($rejectedBookings / $totalBookings) * 100) : 0;
                $monthRate = $totalBookings > 0 ? round(($monthBookings / $totalBookings) * 100) : 0;
                @endphp
                <div>
                    <div class="perf-item-label"><span>Acceptance Rate</span><span>{{ $acceptRate }}%</span></div>
                    <div class="perf-bar-track">
                        <div class="perf-bar-fill" style="width:{{ $acceptRate }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="perf-item-label"><span>Rejection Rate</span><span>{{ $rejectRate }}%</span></div>
                    <div class="perf-bar-track">
                        <div class="perf-bar-fill" style="width:{{ $rejectRate }}%; background: linear-gradient(90deg, #ef4444, #dc2626);"></div>
                    </div>
                </div>
                <div>
                    <div class="perf-item-label"><span>Monthly Activity</span><span>{{ $monthRate }}%</span></div>
                    <div class="perf-bar-track">
                        <div class="perf-bar-fill" style="width:{{ $monthRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection