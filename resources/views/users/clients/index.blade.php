@extends('layouts.users')

@section('title', 'My Clients')

@section('content')

<style>
    /* ── Layout ── */
    .consultant-clients {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
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
        color: #6b7280;
        font-size: .875rem;
        margin: .25rem 0 0;
    }

    /* ── Stats Row ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-card__icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: #eef2ff;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .stat-card__icon svg {
        width: 22px;
        height: 22px;
        color: #19265d;
    }

    .stat-card__icon--gold {
        background: #fef3e2;
    }

    .stat-card__icon--gold svg {
        color: #C8873A;
    }

    .stat-card__icon--green {
        background: #ecfdf5;
    }

    .stat-card__icon--green svg {
        color: #059669;
    }

    .stat-card__label {
        font-size: .75rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin: 0 0 .25rem;
    }

    .stat-card__value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #19265d;
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
    }

    .stat-card__value small {
        font-size: .75rem;
        font-weight: 500;
        color: #9ca3af;
        font-family: 'DM Sans', sans-serif;
    }

    /* ── Filter Bar ── */
    .filter-bar {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.75rem;
    }

    .filter-bar__form {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: .75rem;
    }

    .filter-bar__search {
        position: relative;
        flex: 1;
        min-width: 220px;
    }

    .filter-bar__search svg {
        position: absolute;
        left: .75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: #9ca3af;
        pointer-events: none;
    }

    .filter-bar__input {
        width: 100%;
        padding: .5rem .75rem .5rem 2.25rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: .875rem;
        outline: none;
        transition: border-color .2s;
    }

    .filter-bar__input:focus {
        border-color: #C8873A;
    }

    .filter-bar__select {
        padding: .5rem .75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: .875rem;
        color: #374151;
        background: #fff;
        cursor: pointer;
        outline: none;
    }

    .filter-bar__select:focus {
        border-color: #C8873A;
    }

    /* ── Buttons ── */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        font-size: .875rem;
        font-weight: 500;
        border-radius: 8px;
        cursor: pointer;
        border: none;
        text-decoration: none;
        transition: background .2s, opacity .2s;
    }

    .btn--primary {
        background: #19265d;
        color: #fff;
        padding: .5rem 1.25rem;
    }

    .btn--primary:hover {
        background: #C8873A;
    }

    .btn--ghost {
        background: transparent;
        color: #6b7280;
        border: 1px solid #d1d5db;
        padding: .5rem 1rem;
    }

    .btn--ghost:hover {
        border-color: #9ca3af;
        color: #374151;
    }

    .btn--sm {
        font-size: .8125rem;
        padding: .4rem 1rem;
    }

    .btn--full {
        width: 100%;
    }

    /* ── Clients Grid ── */
    .clients-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.25rem;
    }

    /* ── Client Card ── */
    .client-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        transition: box-shadow .2s, border-color .2s;
    }

    .client-card:hover {
        box-shadow: 0 4px 16px rgba(25, 38, 93, .08);
        border-color: #C8873A33;
    }

    .client-card__header {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .client-card__avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        background: #19265d;
        display: grid;
        place-items: center;
    }

    .client-card__avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .client-card__avatar span {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 600;
        font-family: 'Cormorant Garamond', serif;
    }

    .client-card__name {
        font-size: 1rem;
        font-weight: 600;
        color: #19265d;
        margin: 0 0 .2rem;
    }

    .client-card__email {
        font-size: .8rem;
        color: #6b7280;
        margin: 0;
    }

    .client-card__phone {
        font-size: .8rem;
        color: #9ca3af;
        margin: .1rem 0 0;
    }

    .client-card__stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: .5rem;
        background: #f9fafb;
        border-radius: 10px;
        padding: .875rem .75rem;
    }

    .client-card__stat {
        text-align: center;
    }

    .client-card__stat-value {
        display: block;
        font-size: 1.1rem;
        font-weight: 700;
        color: #19265d;
        font-family: 'Cormorant Garamond', serif;
    }

    .client-card__stat-value--green {
        color: #059669;
    }

    .client-card__stat-value--yellow {
        color: #d97706;
    }

    .client-card__stat-value--gold {
        color: #C8873A;
    }

    .client-card__stat-label {
        display: block;
        font-size: .65rem;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-top: .1rem;
    }

    .client-card__last {
        font-size: .8rem;
        color: #9ca3af;
        margin: 0;
    }

    .client-card__last strong {
        color: #6b7280;
    }

    .client-card__actions {
        margin-top: auto;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9ca3af;
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
        opacity: .4;
    }

    .empty-state p {
        font-size: 1rem;
    }

    /* ── Pagination ── */
    .pagination-wrap {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 640px) {
        .consultant-clients {
            padding: 1rem;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }

        .clients-grid {
            grid-template-columns: 1fr;
        }

        .filter-bar__form {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<div class="consultant-clients">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header__left">
            <h1 class="page-header__title">Clients</h1>
            <p class="page-header__sub">Everyone who has booked a session with you</p>
        </div>
    </div>

    {{-- Summary Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <span class="stat-card__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </span>
            <div>
                <p class="stat-card__label">Total Clients</p>
                <p class="stat-card__value">{{ number_format($totalClients) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card__icon stat-card__icon--gold">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </span>
            <div>
                <p class="stat-card__label">Total Revenue</p>
                <p class="stat-card__value">{{ number_format($totalRevenue) }} <small>RWF</small></p>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card__icon stat-card__icon--green">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <polyline points="17 1 21 5 17 9" />
                    <path d="M3 11V9a4 4 0 0 1 4-4h14" />
                    <polyline points="7 23 3 19 7 15" />
                    <path d="M21 13v2a4 4 0 0 1-4 4H3" />
                </svg>
            </span>
            <div>
                <p class="stat-card__label">Returning Clients</p>
                <p class="stat-card__value">{{ number_format($returningCount) }}</p>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('consultant.clients.index') }}" class="filter-bar__form">
            <div class="filter-bar__search">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input
                    type="text"
                    name="search"
                    placeholder="Search by name, email or phone…"
                    value="{{ request('search') }}"
                    class="filter-bar__input">
            </div>

            <select name="status" class="filter-bar__select">
                <option value="">All Statuses</option>
                <option value="confirmed" @selected(request('status')==='confirmed' )>Confirmed</option>
                <option value="pending" @selected(request('status')==='pending' )>Pending</option>
                <option value="rejected" @selected(request('status')==='rejected' )>Rejected</option>
            </select>

            <select name="sort" class="filter-bar__select">
                <option value="latest" @selected(request('sort', 'latest' )==='latest' )>Newest First</option>
                <option value="name" @selected(request('sort')==='name' )>Name A–Z</option>
                <option value="bookings" @selected(request('sort')==='bookings' )>Most Bookings</option>
                <option value="revenue" @selected(request('sort')==='revenue' )>Highest Spend</option>
            </select>

            <button type="submit" class="btn btn--primary btn--sm">Filter</button>

            @if(request()->hasAny(['search', 'status', 'sort']))
            <a href="{{ route('consultant.clients.index') }}" class="btn btn--ghost btn--sm">Clear</a>
            @endif
        </form>
    </div>

    {{-- Clients Grid --}}
    @if($clients->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
        <p>No clients found{{ request('search') ? ' for "' . request('search') . '"' : '' }}.</p>
    </div>
    @else
    <div class="clients-grid">
        @foreach($clients as $client)
        <div class="client-card">
            <div class="client-card__header">
                <div class="client-card__avatar">
                    @if($client->avatar)
                    <img src="{{ asset($client->avatar) }}" alt="{{ $client->name }}">
                    @else
                    <span>{{ strtoupper(substr($client->name, 0, 2)) }}</span>
                    @endif
                </div>
                <div class="client-card__identity">
                    <h3 class="client-card__name">{{ $client->name }}</h3>
                    <p class="client-card__email">{{ $client->email }}</p>
                    @if($client->phone)
                    <p class="client-card__phone">{{ $client->phone }}</p>
                    @endif
                </div>
            </div>

            <div class="client-card__stats">
                <div class="client-card__stat">
                    <span class="client-card__stat-value">{{ $client->total_bookings }}</span>
                    <span class="client-card__stat-label">Bookings</span>
                </div>
                <div class="client-card__stat">
                    <span class="client-card__stat-value client-card__stat-value--green">{{ $client->confirmed_bookings }}</span>
                    <span class="client-card__stat-label">Confirmed</span>
                </div>
                <div class="client-card__stat">
                    <span class="client-card__stat-value client-card__stat-value--yellow">{{ $client->pending_bookings }}</span>
                    <span class="client-card__stat-label">Pending</span>
                </div>
                <div class="client-card__stat">
                    <span class="client-card__stat-value client-card__stat-value--gold">{{ number_format($client->total_paid ?? 0) }}</span>
                    <span class="client-card__stat-label">RWF Paid</span>
                </div>
            </div>

            @if($client->consultantBookings->isNotEmpty())
            <p class="client-card__last">
                Last booking:
                <strong>{{ $client->consultantBookings->first()->created_at->diffForHumans() }}</strong>
            </p>
            @endif

            <div class="client-card__actions">
                <a href="{{ route('consultant.clients.show', $client) }}" class="btn btn--primary btn--sm btn--full">
                    View Details & Bookings
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrap">
        {{ $clients->links() }}
    </div>
    @endif

</div>

@endsection