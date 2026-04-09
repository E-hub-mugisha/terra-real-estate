@extends('layouts.users')

@section('title', $client->name . ' — Client Details')

@section('content')


<style>
    /* ── Layout ── */
    .client-detail {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── Back Link ── */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        color: #9ca3af;
        font-size: .875rem;
        text-decoration: none;
        margin-bottom: .5rem;
        transition: color .2s;
    }

    .back-link:hover {
        color: #C8873A;
    }

    .back-link svg {
        width: 16px;
        height: 16px;
    }

    /* ── Page Header ── */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header__title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        font-weight: 600;
        color: #19265d;
        margin: 0;
    }

    .page-header__sub {
        color: #9ca3af;
        font-size: .875rem;
        margin: .25rem 0 0;
    }

    /* ── Detail Layout ── */
    .detail-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    /* ── Profile Card ── */
    .profile-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 2rem 1.5rem;
        text-align: center;
        position: sticky;
        top: 1rem;
    }

    .profile-card__avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        background: #19265d;
        display: grid;
        place-items: center;
        margin: 0 auto 1rem;
    }

    .profile-card__avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-card__avatar span {
        color: #fff;
        font-size: 1.75rem;
        font-weight: 600;
        font-family: 'Cormorant Garamond', serif;
    }

    .profile-card__name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.375rem;
        font-weight: 600;
        color: #19265d;
        margin: 0 0 1.25rem;
    }

    .profile-card__info {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: left;
        display: flex;
        flex-direction: column;
        gap: .75rem;
        border-top: 1px solid #f3f4f6;
        padding-top: 1.25rem;
    }

    .profile-card__info li {
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        font-size: .8125rem;
        color: #6b7280;
    }

    .profile-card__info svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
        margin-top: .1rem;
        color: #C8873A;
    }

    /* ── Stats Row ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: .875rem;
    }

    .stat-card__icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #eef2ff;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .stat-card__icon svg {
        width: 20px;
        height: 20px;
        color: #19265d;
    }

    .stat-card__icon--green {
        background: #ecfdf5;
    }

    .stat-card__icon--green svg {
        color: #059669;
    }

    .stat-card__icon--yellow {
        background: #fffbeb;
    }

    .stat-card__icon--yellow svg {
        color: #d97706;
    }

    .stat-card__icon--gold {
        background: #fef3e2;
    }

    .stat-card__icon--gold svg {
        color: #C8873A;
    }

    .stat-card__label {
        font-size: .7rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin: 0 0 .2rem;
    }

    .stat-card__value {
        font-size: 1.375rem;
        font-weight: 700;
        color: #19265d;
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
    }

    .stat-card__value small {
        font-size: .7rem;
        font-weight: 500;
        color: #9ca3af;
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Section Card ── */
    .section-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
    }

    .section-card__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .section-card__title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 600;
        color: #19265d;
        margin: 0;
    }

    .inline-filter {
        display: flex;
        gap: .5rem;
    }

    .filter-bar__select {
        padding: .4rem .75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: .8125rem;
        color: #374151;
        background: #fff;
        cursor: pointer;
        outline: none;
    }

    .filter-bar__select:focus {
        border-color: #C8873A;
    }

    /* ── Table ── */
    .table-wrap {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .875rem;
    }

    .data-table thead tr {
        background: #f9fafb;
    }

    .data-table th {
        padding: .75rem 1.5rem;
        text-align: left;
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #9ca3af;
        border-bottom: 1px solid #f3f4f6;
        white-space: nowrap;
    }

    .data-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f9fafb;
        vertical-align: middle;
        color: #374151;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: #fafafa;
    }

    .td-muted {
        color: #9ca3af;
    }

    .td-strong {
        font-weight: 600;
        color: #19265d;
    }

    .td-strong small {
        font-weight: 400;
        color: #9ca3af;
        font-size: .7rem;
    }

    .service-name {
        font-weight: 500;
        color: #19265d;
    }

    /* ── Badges ── */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: .2rem .65rem;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 600;
        text-transform: capitalize;
        letter-spacing: .03em;
    }

    .badge--green {
        background: #ecfdf5;
        color: #059669;
    }

    .badge--yellow {
        background: #fffbeb;
        color: #d97706;
    }

    .badge--red {
        background: #fef2f2;
        color: #dc2626;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #9ca3af;
    }

    .empty-state--sm {
        padding: 2rem;
    }

    .empty-state svg {
        width: 48px;
        height: 48px;
        margin-bottom: .75rem;
        opacity: .35;
    }

    /* ── Pagination ── */
    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: center;
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .detail-layout {
            grid-template-columns: 1fr;
        }

        .profile-card {
            position: static;
        }

        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 540px) {
        .client-detail {
            padding: 1rem;
        }

        .stats-row {
            grid-template-columns: 1fr 1fr;
        }
    }
</style>
<div class="client-detail">

    {{-- Back + Header --}}
    <div class="page-header">
        <div class="page-header__left">
            <a href="{{ route('users.clients.index') }}" class="back-link">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Back to Clients
            </a>
            <h1 class="page-header__title">{{ $client->name }}</h1>
            <p class="page-header__sub">Client since {{ $firstBookingDate?->format('F Y') ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="detail-layout">

        {{-- Left Column: Profile --}}
        <aside class="profile-card">
            <div class="profile-card__avatar">
                @if($client->avatar)
                <img src="{{ asset($client->avatar) }}" alt="{{ $client->name }}">
                @else
                <span>{{ strtoupper(substr($client->name, 0, 2)) }}</span>
                @endif
            </div>
            <h2 class="profile-card__name">{{ $client->name }}</h2>

            <ul class="profile-card__info">
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    <span>{{ $client->email }}</span>
                </li>
                @if($client->phone)
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13 19.79 19.79 0 0 1 1.61 4.4 2 2 0 0 1 3.6 2.22h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.16 6.16l.94-.94a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 21.72 17z" />
                    </svg>
                    <span>{{ $client->phone }}</span>
                </li>
                @endif
                @if($client->address)
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    <span>{{ $client->address }}</span>
                </li>
                @endif
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    <span>Joined {{ $client->created_at->format('d M Y') }}</span>
                </li>
                @if($lastBookingDate)
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <span>Last booking {{ $lastBookingDate->diffForHumans() }}</span>
                </li>
                @endif
            </ul>
        </aside>

        {{-- Right Column: Stats + Bookings --}}
        <div class="detail-main">

            {{-- Stats --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-card__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-card__label">Total Bookings</p>
                        <p class="stat-card__value">{{ $totalBookings }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon stat-card__icon--green">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-card__label">Confirmed</p>
                        <p class="stat-card__value">{{ $confirmedCount }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon stat-card__icon--yellow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-card__label">Pending</p>
                        <p class="stat-card__value">{{ $pendingCount }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon stat-card__icon--gold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                        </svg>
                    </div>
                    <div>
                        <p class="stat-card__label">Total Spent</p>
                        <p class="stat-card__value">{{ number_format($totalSpent) }} <small>RWF</small></p>
                    </div>
                </div>
            </div>

            {{-- Bookings Table --}}
            <div class="section-card">
                <div class="section-card__header">
                    <h2 class="section-card__title">Booking History</h2>

                    {{-- Status filter --}}
                    <form method="GET" action="{{ route('users.clients.show', $client) }}" class="inline-filter">
                        <select name="status" class="filter-bar__select" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="confirmed" @selected(request('status')==='confirmed' )>Confirmed</option>
                            <option value="pending" @selected(request('status')==='pending' )>Pending</option>
                            <option value="rejected" @selected(request('status')==='rejected' )>Rejected</option>
                        </select>
                    </form>
                </div>

                @if($bookings->isEmpty())
                <div class="empty-state empty-state--sm">
                    <p>No bookings found for this filter.</p>
                </div>
                @else
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Fee</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td class="td-muted">{{ $booking->id }}</td>
                                <td>
                                    <span class="service-name">{{ $booking->service?->title ?? 'N/A' }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->appointment_date)->format('d M Y') }}</td>
                                <td class="td-muted">{{ $booking->appointment_time ?? '—' }}</td>
                                <td class="td-strong">{{ number_format($booking->fee) }} <small>RWF</small></td>
                                <td>
                                    <span class="badge badge--{{ $booking->payment_status === 'paid' ? 'green' : ($booking->payment_status === 'pending' ? 'yellow' : 'red') }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge--{{ $booking->status === 'confirmed' ? 'green' : ($booking->status === 'pending' ? 'yellow' : 'red') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrap">
                    {{ $bookings->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection