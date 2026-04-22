@extends('layouts.users')

@section('title', 'Booking Requests')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --navy:   #19265d;
        --navy-2: #1e2f6e;
        --navy-3: #111c48;
        --gold:   #D05208;
        --gold-2: #e8621a;
        --gold-pale: rgba(208,82,8,.08);
        --cream:  #faf8f5;
        --muted:  #8891a4;
        --border: rgba(25,38,93,.10);
        --card-shadow: 0 2px 20px rgba(25,38,93,.07), 0 1px 4px rgba(25,38,93,.04);
    }

    body { background: var(--cream); font-family: 'DM Sans', sans-serif; }

    /* ── Page header ── */
    .page-header {
        background: var(--navy);
        padding: 2.2rem 2.5rem 1.8rem;
        position: relative;
        overflow: hidden;
    }
    .page-header::after {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse 60% 80% at 90% 50%, rgba(208,82,8,.18) 0%, transparent 70%);
        pointer-events: none;
    }
    .page-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.1rem; font-weight: 600;
        color: #fff; margin: 0 0 .25rem;
    }
    .page-header p { color: rgba(255,255,255,.55); font-size: .875rem; margin: 0; }

    /* ── Stat pills ── */
    .stats-row { display: flex; gap: .75rem; flex-wrap: wrap; padding: 1.5rem 2.5rem; }
    .stat-pill {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 50px;
        padding: .45rem 1.1rem;
        display: flex; align-items: center; gap: .5rem;
        font-size: .8rem; font-weight: 500; color: var(--navy);
        box-shadow: var(--card-shadow);
    }
    .stat-pill .dot {
        width: 8px; height: 8px; border-radius: 50%;
    }
    .dot-pending  { background: #f59e0b; }
    .dot-confirmed{ background: #10b981; }
    .dot-rejected { background: #ef4444; }
    .dot-rescheduled { background: #6366f1; }
    .stat-pill strong { font-weight: 600; }

    /* ── Filter bar ── */
    .filter-bar {
        display: flex; align-items: center; gap: 1rem;
        padding: 0 2.5rem 1.5rem;
        flex-wrap: wrap;
    }
    .filter-tabs { display: flex; gap: .35rem; }
    .filter-tab {
        padding: .4rem .9rem; border-radius: 6px; border: 1px solid var(--border);
        background: #fff; color: var(--muted);
        font-size: .8rem; font-weight: 500; cursor: pointer;
        transition: all .18s;
    }
    .filter-tab:hover { border-color: var(--navy); color: var(--navy); }
    .filter-tab.active {
        background: var(--navy); color: #fff; border-color: var(--navy);
    }
    .search-input {
        margin-left: auto;
        background: #fff; border: 1px solid var(--border);
        border-radius: 8px; padding: .42rem .9rem;
        font-family: 'DM Sans', sans-serif; font-size: .85rem;
        color: var(--navy); outline: none; min-width: 220px;
        transition: border-color .18s;
    }
    .search-input:focus { border-color: var(--navy); }

    /* ── Table ── */
    .table-wrap { padding: 0 2.5rem 2.5rem; }
    .bookings-table {
        width: 100%; border-collapse: separate; border-spacing: 0;
        background: #fff; border-radius: 14px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    .bookings-table thead th {
        background: var(--navy);
        color: rgba(255,255,255,.65);
        font-size: .72rem; font-weight: 600; letter-spacing: .07em; text-transform: uppercase;
        padding: 1rem 1.2rem; text-align: left;
    }
    .bookings-table thead th:first-child { border-radius: 14px 0 0 0; }
    .bookings-table thead th:last-child  { border-radius: 0 14px 0 0; text-align: center; }

    .bookings-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .15s;
    }
    .bookings-table tbody tr:last-child { border-bottom: none; }
    .bookings-table tbody tr:hover { background: #f6f7fb; }

    .bookings-table td { padding: 1.05rem 1.2rem; vertical-align: middle; font-size: .875rem; color: var(--navy); }

    /* Reference */
    .ref-code {
        font-family: 'DM Sans', sans-serif; font-size: .78rem;
        background: var(--gold-pale); color: var(--gold);
        border: 1px solid rgba(208,82,8,.2);
        padding: .2rem .55rem; border-radius: 5px; font-weight: 600;
        letter-spacing: .04em;
    }

    /* Client */
    .client-name { font-weight: 500; color: var(--navy); }
    .client-sub  { font-size: .78rem; color: var(--muted); margin-top: .15rem; }

    /* Date */
    .date-block { display: flex; flex-direction: column; gap: .1rem; }
    .date-main  { font-weight: 500; }
    .date-sub   { font-size: .78rem; color: var(--muted); }

    /* Status badge */
    .badge {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .28rem .7rem; border-radius: 50px;
        font-size: .75rem; font-weight: 600; letter-spacing: .03em;
    }
    .badge-pending    { background: #fef3c7; color: #92400e; }
    .badge-confirmed  { background: #d1fae5; color: #065f46; }
    .badge-rejected   { background: #fee2e2; color: #991b1b; }
    .badge-rescheduled{ background: #ede9fe; color: #4c1d95; }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    /* Payment badge */
    .pay-badge {
        font-size: .73rem; padding: .22rem .6rem; border-radius: 4px; font-weight: 500;
    }
    .pay-paid   { background: #d1fae5; color: #065f46; }
    .pay-unpaid { background: #f3f4f6; color: #6b7280; }
    .pay-partial{ background: #fef3c7; color: #92400e; }

    /* Action buttons */
    .actions-cell { text-align: center; }
    .action-group { display: flex; justify-content: center; align-items: center; gap: .4rem; }
    .btn-icon {
        width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border);
        display: inline-flex; align-items: center; justify-content: center;
        background: #fff; color: var(--navy);
        cursor: pointer; transition: all .18s; text-decoration: none;
    }
    .btn-icon:hover { background: var(--navy); color: #fff; border-color: var(--navy); transform: translateY(-1px); }
    .btn-icon.accept:hover { background: #10b981; border-color: #10b981; color: #fff; }
    .btn-icon.reject:hover { background: #ef4444; border-color: #ef4444; color: #fff; }
    .btn-icon.reschedule:hover { background: #6366f1; border-color: #6366f1; color: #fff; }
    .btn-icon svg { width: 15px; height: 15px; }

    /* ── Modal base ── */
    .modal-backdrop {
        position: fixed; inset: 0; z-index: 1000;
        background: rgba(15,20,40,.55);
        backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none; transition: opacity .22s;
    }
    .modal-backdrop.open { opacity: 1; pointer-events: all; }
    .modal {
        background: #fff; border-radius: 18px;
        box-shadow: 0 24px 60px rgba(15,20,40,.25);
        width: 100%; max-width: 500px; padding: 2.2rem;
        transform: translateY(16px) scale(.98); transition: transform .22s;
    }
    .modal-backdrop.open .modal { transform: translateY(0) scale(1); }

    .modal-icon {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1.2rem;
    }
    .modal-icon.accept    { background: #d1fae5; color: #059669; }
    .modal-icon.reject    { background: #fee2e2; color: #dc2626; }
    .modal-icon.reschedule{ background: #ede9fe; color: #7c3aed; }

    .modal h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.55rem; font-weight: 600; color: var(--navy); margin: 0 0 .35rem;
    }
    .modal p { color: var(--muted); font-size: .875rem; margin: 0 0 1.5rem; }

    .modal-meta {
        background: var(--cream); border-radius: 10px; padding: 1rem 1.15rem;
        margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: .5rem;
    }
    .modal-meta-row { display: flex; justify-content: space-between; font-size: .83rem; }
    .modal-meta-row span:first-child { color: var(--muted); }
    .modal-meta-row span:last-child  { color: var(--navy); font-weight: 500; }

    .form-group { margin-bottom: 1.15rem; }
    .form-label { display: block; font-size: .8rem; font-weight: 600; color: var(--navy); margin-bottom: .4rem; letter-spacing: .03em; }
    .form-control {
        width: 100%; padding: .6rem .85rem;
        border: 1px solid var(--border); border-radius: 8px;
        font-family: 'DM Sans', sans-serif; font-size: .875rem; color: var(--navy);
        outline: none; transition: border-color .18s; box-sizing: border-box;
    }
    .form-control:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(25,38,93,.07); }

    .modal-footer { display: flex; gap: .75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--border); margin-top: 1.5rem; }
    .btn {
        padding: .6rem 1.4rem; border-radius: 8px; border: none;
        font-family: 'DM Sans', sans-serif; font-size: .875rem; font-weight: 600;
        cursor: pointer; transition: all .18s;
    }
    .btn-ghost { background: transparent; border: 1px solid var(--border); color: var(--navy); }
    .btn-ghost:hover { background: var(--cream); }
    .btn-accept     { background: #059669; color: #fff; }
    .btn-accept:hover { background: #047857; transform: translateY(-1px); }
    .btn-reject     { background: #dc2626; color: #fff; }
    .btn-reject:hover { background: #b91c1c; transform: translateY(-1px); }
    .btn-reschedule { background: #7c3aed; color: #fff; }
    .btn-reschedule:hover { background: #6d28d9; transform: translateY(-1px); }

    /* ── Empty state ── */
    .empty-state { text-align: center; padding: 4rem 2rem; color: var(--muted); }
    .empty-state svg { opacity: .3; margin-bottom: 1rem; }
    .empty-state p { font-size: .95rem; }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .page-header, .stats-row, .filter-bar, .table-wrap { padding-left: 1.25rem; padding-right: 1.25rem; }
        .col-hide { display: none; }
    }
</style>


{{-- Flash messages --}}
@if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:.75rem 2.5rem;font-size:.875rem;border-bottom:1px solid #a7f3d0;display:flex;align-items:center;gap:.5rem;">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd"/></svg>
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#fee2e2;color:#991b1b;padding:.75rem 2.5rem;font-size:.875rem;border-bottom:1px solid #fca5a5;">
        {{ session('error') }}
    </div>
@endif

{{-- Page header --}}
<div class="page-header">
    <h1>Booking Requests</h1>
    <p>Review and manage consultation appointments from clients</p>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-pill"><span class="dot dot-pending"></span>Pending <strong>{{ $bookings->where('status','pending')->count() }}</strong></div>
    <div class="stat-pill"><span class="dot dot-confirmed"></span>Confirmed <strong>{{ $bookings->where('status','confirmed')->count() }}</strong></div>
    <div class="stat-pill"><span class="dot dot-rejected"></span>Rejected <strong>{{ $bookings->where('status','rejected')->count() }}</strong></div>
    <div class="stat-pill"><span class="dot dot-rescheduled"></span>Rescheduled <strong>{{ $bookings->where('status','rescheduled')->count() }}</strong></div>
</div>

{{-- Filter bar --}}
<div class="filter-bar">
    <div class="filter-tabs">
        <button class="filter-tab active" data-filter="all">All</button>
        <button class="filter-tab" data-filter="pending">Pending</button>
        <button class="filter-tab" data-filter="confirmed">Confirmed</button>
        <button class="filter-tab" data-filter="rejected">Rejected</button>
        <button class="filter-tab" data-filter="rescheduled">Rescheduled</button>
    </div>
    <input type="text" class="search-input" id="searchInput" placeholder="Search by name, reference…">
</div>

{{-- Table --}}
<div class="table-wrap">
    @if($bookings->isEmpty())
        <div class="empty-state">
            <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p>No booking requests yet.</p>
        </div>
    @else
    <table class="bookings-table" id="bookingsTable">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Client</th>
                <th>Service</th>
                <th class="col-hide">Date</th>
                <th class="col-hide">Fee</th>
                <th class="col-hide">Payment</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr data-status="{{ $booking->status }}"
                data-search="{{ strtolower($booking->client_name . ' ' . $booking->reference . ' ' . $booking->client_email) }}">
                <td><span class="ref-code">{{ $booking->reference }}</span></td>
                <td>
                    <div class="client-name">{{ $booking->client_name }}</div>
                    <div class="client-sub">{{ $booking->client_email }}</div>
                    @if($booking->client_phone)
                        <div class="client-sub">{{ $booking->client_phone }}</div>
                    @endif
                </td>
                <td>{{ $booking->service->title ?? '—' }}</td>
                <td class="col-hide">
                    <div class="date-block">
                        <span class="date-main">{{ $booking->appointment_date->format('d M Y') }}</span>
                        <span class="date-sub">{{ $booking->appointment_date->format('l') }}</span>
                    </div>
                </td>
                <td class="col-hide">RWF {{ number_format($booking->fee) }}</td>
                <td class="col-hide">
                    <span class="badge pay-badge pay-{{ $booking->payment_status }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                </td>
                <td>
                    <span class="badge badge-{{ $booking->status }}">
                        <span class="badge-dot"></span>
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>
                <td class="actions-cell">
                    <div class="action-group">
                        {{-- View --}}
                        <button class="btn-icon"
                            title="View details"
                            onclick="openViewModal({{ $booking->id }})">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>

                        @if($booking->isPending())
                        {{-- Accept --}}
                        <button class="btn-icon accept" title="Accept booking"
                            onclick="openAcceptModal({{ $booking->id }}, '{{ $booking->reference }}', '{{ $booking->client_name }}', '{{ $booking->appointment_date->format('d M Y') }}', '{{ $booking->service->name ?? '' }}')">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </button>

                        {{-- Reject --}}
                        <button class="btn-icon reject" title="Reject booking"
                            onclick="openRejectModal({{ $booking->id }}, '{{ $booking->reference }}', '{{ $booking->client_name }}')">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        {{-- Reschedule --}}
                        <button class="btn-icon reschedule" title="Reschedule booking"
                            onclick="openRescheduleModal({{ $booking->id }}, '{{ $booking->reference }}', '{{ $booking->client_name }}', '{{ $booking->appointment_date->format('Y-m-d') }}')">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($bookings->hasPages())
        <div style="padding:1.25rem 0 0; display:flex; justify-content:flex-end;">
            {{ $bookings->links() }}
        </div>
    @endif
    @endif
</div>


{{-- ══════════════════════════════════════
     MODALS
══════════════════════════════════════ --}}

{{-- VIEW MODAL --}}
@foreach($bookings as $booking)
<div class="modal-backdrop" id="viewModal-{{ $booking->id }}">
    <div class="modal" style="max-width:560px;">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.5rem;">
            <div>
                <div style="font-size:.75rem;font-weight:600;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);margin-bottom:.3rem;">Booking Details</div>
                <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:600;color:var(--navy);margin:0;">{{ $booking->reference }}</h2>
            </div>
            <button onclick="closeModal('viewModal-{{ $booking->id }}')" style="background:var(--cream);border:none;width:32px;height:32px;border-radius:8px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem;background:var(--cream);border-radius:12px;padding:1.15rem;margin-bottom:1.5rem;">
            @foreach([
                ['Client',        $booking->client_name],
                ['Email',         $booking->client_email],
                ['Phone',         $booking->client_phone ?? '—'],
                ['Service',       $booking->service->title ?? '—'],
                ['Date',          $booking->appointment_date->format('d M Y (l)')],
                ['Location',      ($booking->district ? $booking->district.', ' : '').$booking->province],
                ['Fee',           'RWF '.number_format($booking->fee)],
                ['Payment',       ucfirst($booking->payment_status).' · '.ucfirst($booking->payment_method)],
                ['Pay Reference', $booking->payment_reference ?? '—'],
                ['Status',        ucfirst($booking->status)],
            ] as [$label, $value])
            <div>
                <div style="font-size:.72rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--muted);margin-bottom:.2rem;">{{ $label }}</div>
                <div style="font-size:.875rem;color:var(--navy);font-weight:500;">{{ $value }}</div>
            </div>
            @endforeach
        </div>

        @if($booking->notes)
        <div style="background:var(--cream);border-radius:10px;padding:1rem 1.15rem;margin-bottom:1.5rem;">
            <div style="font-size:.72rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem;">Notes from client</div>
            <p style="font-size:.875rem;color:var(--navy);margin:0;line-height:1.6;">{{ $booking->notes }}</p>
        </div>
        @endif

        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('viewModal-{{ $booking->id }}')">Close</button>
        </div>
    </div>
</div>
@endforeach

{{-- ACCEPT MODAL --}}
<div class="modal-backdrop" id="acceptModal">
    <div class="modal">
        <div class="modal-icon accept">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h2>Confirm Booking</h2>
        <p>You're about to accept this consultation appointment. The client will be notified.</p>

        <div class="modal-meta">
            <div class="modal-meta-row"><span>Reference</span><span id="accept-ref">—</span></div>
            <div class="modal-meta-row"><span>Client</span><span id="accept-client">—</span></div>
            <div class="modal-meta-row"><span>Service</span><span id="accept-service">—</span></div>
            <div class="modal-meta-row"><span>Date</span><span id="accept-date">—</span></div>
        </div>

        <form id="acceptForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <input type="hidden" name="action" value="confirm">
            <div class="form-group">
                <label class="form-label">Note to client <span style="color:var(--muted);font-weight:400;">(optional)</span></label>
                <textarea class="form-control" name="note" rows="3" placeholder="Add any preparation instructions or confirmation details…" style="resize:vertical;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('acceptModal')">Cancel</button>
                <button type="submit" class="btn btn-accept">Confirm Booking</button>
            </div>
        </form>
    </div>
</div>

{{-- REJECT MODAL --}}
<div class="modal-backdrop" id="rejectModal">
    <div class="modal">
        <div class="modal-icon reject">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <h2>Reject Booking</h2>
        <p>Please provide a reason so the client can understand and rebook if needed.</p>

        <div class="modal-meta">
            <div class="modal-meta-row"><span>Reference</span><span id="reject-ref">—</span></div>
            <div class="modal-meta-row"><span>Client</span><span id="reject-client">—</span></div>
        </div>

        <form id="rejectForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <input type="hidden" name="action" value="reject">
            <div class="form-group">
                <label class="form-label">Reason for rejection <span style="color:#ef4444;">*</span></label>
                <textarea class="form-control" name="rejection_reason" rows="3" placeholder="e.g. Unavailable on this date, outside service area…" required style="resize:vertical;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('rejectModal')">Cancel</button>
                <button type="submit" class="btn btn-reject">Reject Booking</button>
            </div>
        </form>
    </div>
</div>

{{-- RESCHEDULE MODAL --}}
<div class="modal-backdrop" id="rescheduleModal">
    <div class="modal">
        <div class="modal-icon reschedule">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <h2>Propose New Date</h2>
        <p>Suggest an alternative appointment date for this booking.</p>

        <div class="modal-meta">
            <div class="modal-meta-row"><span>Reference</span><span id="reschedule-ref">—</span></div>
            <div class="modal-meta-row"><span>Client</span><span id="reschedule-client">—</span></div>
        </div>

        <form id="rescheduleForm" method="POST" action="">
            @csrf
            @method('PATCH')
            <input type="hidden" name="action" value="reschedule">
            <div class="form-group">
                <label class="form-label">New appointment date <span style="color:#7c3aed;">*</span></label>
                <input type="date" class="form-control" name="new_date" id="reschedule-datepicker"
                    min="{{ now()->addDay()->format('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Message to client <span style="color:var(--muted);font-weight:400;">(optional)</span></label>
                <textarea class="form-control" name="note" rows="2" placeholder="Reason for rescheduling or any details…" style="resize:vertical;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('rescheduleModal')">Cancel</button>
                <button type="submit" class="btn btn-reschedule">Propose New Date</button>
            </div>
        </form>
    </div>
</div>

<script>
    /* ── Modal helpers ── */
    function openModal(id)  { document.getElementById(id).classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = ''; }

    // Close on backdrop click
    document.querySelectorAll('.modal-backdrop').forEach(el => {
        el.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
    // Close on Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.modal-backdrop.open').forEach(el => closeModal(el.id));
    });

    /* ── View modal ── */
    function openViewModal(id) { openModal('viewModal-' + id); }

    /* ── Accept modal ── */
    function openAcceptModal(id, ref, client, date, service) {
        document.getElementById('accept-ref').textContent     = ref;
        document.getElementById('accept-client').textContent  = client;
        document.getElementById('accept-date').textContent    = date;
        document.getElementById('accept-service').textContent = service;
        document.getElementById('acceptForm').action = `/consultant/bookings/${id}/status`;
        openModal('acceptModal');
    }

    /* ── Reject modal ── */
    function openRejectModal(id, ref, client) {
        document.getElementById('reject-ref').textContent    = ref;
        document.getElementById('reject-client').textContent = client;
        document.getElementById('rejectForm').action = `/consultant/bookings/${id}/status`;
        openModal('rejectModal');
    }

    /* ── Reschedule modal ── */
    function openRescheduleModal(id, ref, client, currentDate) {
        document.getElementById('reschedule-ref').textContent    = ref;
        document.getElementById('reschedule-client').textContent = client;
        document.getElementById('reschedule-datepicker').value   = currentDate;
        document.getElementById('rescheduleForm').action = `/consultant/bookings/${id}/status`;
        openModal('rescheduleModal');
    }

    /* ── Filter tabs ── */
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            filterTable();
        });
    });

    /* ── Search ── */
    document.getElementById('searchInput').addEventListener('input', filterTable);

    function filterTable() {
        const activeFilter = document.querySelector('.filter-tab.active').dataset.filter;
        const query = document.getElementById('searchInput').value.toLowerCase().trim();
        document.querySelectorAll('#bookingsTable tbody tr').forEach(row => {
            const matchStatus = activeFilter === 'all' || row.dataset.status === activeFilter;
            const matchSearch = !query || row.dataset.search.includes(query);
            row.style.display = (matchStatus && matchSearch) ? '' : 'none';
        });
    }
</script>
@endsection