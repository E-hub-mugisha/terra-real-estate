@extends('layouts.app')

@section('title', 'Advertisements — Admin')

@section('content')


<style>
    .admin-page {
        padding: 28px;
    }

    .admin-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .admin-stat {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px 20px;
    }

    .admin-stat__val {
        display: block;
        font-size: 28px;
        font-weight: 800;
        color: #051321;
    }

    .admin-stat__label {
        font-size: 13px;
        color: #6b7280;
    }

    .admin-stat--warning .admin-stat__val {
        color: #d97706;
    }

    .admin-stat--success .admin-stat__val {
        color: #00a667;
    }

    .admin-stat--danger .admin-stat__val {
        color: #ef4444;
    }

    .admin-filters {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .admin-table-wrap {
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .admin-table th {
        background: #f9fafb;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #6b7280;
        font-weight: 600;
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .admin-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: top;
        font-size: 14px;
    }

    .admin-table tbody tr:last-child td {
        border-bottom: none;
    }

    .admin-table tbody tr:hover td {
        background: #f9fafb;
    }

    .td-id {
        color: #9ca3af;
        font-size: 13px;
    }

    .td-ad {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .td-ad__thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
    }

    .td-ad__title {
        display: block;
        font-weight: 600;
        color: #051321;
    }

    .td-ad__type {
        display: block;
        font-size: 12px;
        color: #9ca3af;
    }

    .td-user {
        display: block;
        font-weight: 500;
    }

    .td-user__phone {
        font-size: 12px;
        color: #9ca3af;
        display: block;
    }

    .td-price {
        display: block;
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
    }

    .td-momo {
        display: block;
        font-weight: 500;
        font-size: 13px;
    }

    .td-txn {
        display: block;
        font-size: 11px;
        color: #6b7280;
        font-family: monospace;
    }

    .td-na {
        color: #d1d5db;
    }

    .td-expired {
        color: #ef4444;
    }

    .td-empty {
        text-align: center;
        padding: 40px;
        color: #9ca3af;
    }

    .badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .badge-pkg {
        background: #eff6ff;
        color: #1e40af;
    }

    .badge-video {
        background: #f3e8ff;
        color: #7c3aed;
        margin-left: 4px;
    }

    .status-pill {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-pill--pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-pill--confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pill--rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-pill--active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pill--draft {
        background: #f3f4f6;
        color: #6b7280;
    }

    .status-pill--pending-review {
        background: #fef3c7;
        color: #92400e;
    }

    .status-pill--expired {
        background: #f3f4f6;
        color: #9ca3af;
    }

    .td-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .action-btn {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border: none;
    }

    .action-btn--confirm {
        background: #d1fae5;
        color: #065f46;
    }

    .action-btn--confirm:hover {
        background: #a7f3d0;
    }

    .action-btn--reject {
        background: #fee2e2;
        color: #991b1b;
    }

    .action-btn--reject:hover {
        background: #fecaca;
    }

    .action-btn--expire {
        background: #f3f4f6;
        color: #6b7280;
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999;
    }

    .modal-box {
        background: #fff;
        border-radius: 14px;
        padding: 28px;
        width: 460px;
        max-width: 90vw;
    }

    .modal-box h4 {
        font-size: 18px;
        font-weight: 700;
        color: #051321;
        margin-bottom: 8px;
    }

    .modal-box p {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 16px;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 16px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .btn {
        padding: 9px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
    }

    .btn-ghost {
        background: none;
        border: 1px solid #d1d5db;
        color: #6b7280;
    }

    .btn-danger {
        background: #ef4444;
        color: #fff;
    }
</style>

<div class="admin-page">

    {{-- Stats bar --}}
    <div class="admin-stats">
        <div class="admin-stat admin-stat--warning">
            <span class="admin-stat__val">{{ $stats['pending'] }}</span>
            <span class="admin-stat__label">Pending Review</span>
        </div>
        <div class="admin-stat admin-stat--success">
            <span class="admin-stat__val">{{ $stats['active'] }}</span>
            <span class="admin-stat__label">Active</span>
        </div>
        <div class="admin-stat admin-stat--muted">
            <span class="admin-stat__val">{{ $stats['expired'] }}</span>
            <span class="admin-stat__label">Expired</span>
        </div>
        <div class="admin-stat admin-stat--danger">
            <span class="admin-stat__val">{{ $stats['rejected'] }}</span>
            <span class="admin-stat__label">Rejected</span>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" class="admin-filters">
        <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            @foreach(['draft','pending_review','active','paused','expired','rejected'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                {{ ucwords(str_replace('_', ' ', $s)) }}
            </option>
            @endforeach
        </select>
        <select name="payment" class="filter-select" onchange="this.form.submit()">
            <option value="">All Payments</option>
            <option value="pending" {{ request('payment') === 'pending'   ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('payment') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="rejected" {{ request('payment') === 'rejected'  ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Ads table --}}
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ad</th>
                    <th>User</th>
                    <th>Package</th>
                    <th>MoMo</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Expires</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ads as $ad)
                <tr>
                    <td class="td-id">#{{ $ad->id }}</td>
                    <td>
                        <div class="td-ad">
                            @if($ad->first_image_url)
                            <img src="{{ $ad->first_image_url }}" class="td-ad__thumb" alt="">
                            @endif
                            <div>
                                <span class="td-ad__title">{{ Str::limit($ad->title, 40) }}</span>
                                <span class="td-ad__type">{{ $ad->listing_type }}</span>
                                @if($ad->video_path)
                                <span class="badge badge-video">VIDEO</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="td-user">{{ $ad->user->name }}</span>
                        <span class="td-user__phone">{{ $ad->user->phone ?? '—' }}</span>
                    </td>
                    <td>
                        <span class="badge badge-pkg">{{ $ad->package->name }}</span>
                        <span class="td-price">{{ number_format($ad->package->price) }} RWF</span>
                    </td>
                    <td>
                        @if($ad->momo_phone)
                        <span class="td-momo">{{ $ad->momo_phone }}</span>
                        @if($ad->momo_transaction_id)
                        <span class="td-txn">TXN: {{ $ad->momo_transaction_id }}</span>
                        @endif
                        @else
                        <span class="td-na">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-pill status-pill--{{ $ad->payment_status }}">
                            {{ ucfirst($ad->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <span class="status-pill status-pill--{{ str_replace('_','-',$ad->status) }}">
                            {{ ucwords(str_replace('_', ' ', $ad->status)) }}
                        </span>
                    </td>
                    <td>
                        @if($ad->expires_at)
                        <span class="{{ $ad->is_expired ? 'td-expired' : '' }}">
                            {{ $ad->expires_at->format('d M Y') }}
                            @if(!$ad->is_expired)
                            <br><small>{{ $ad->days_remaining }}d left</small>
                            @endif
                        </span>
                        @else —
                        @endif
                    </td>
                    <td>
                        <div class="td-actions">
                            {{-- Confirm --}}
                            @if($ad->payment_status !== 'confirmed' && $ad->momo_phone)
                            <form action="{{ route('admin.advertisements.confirm', $ad) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="action-btn action-btn--confirm"
                                    onclick="return confirm('Confirm payment and activate this ad?')">
                                    Activate
                                </button>
                            </form>
                            @endif

                            {{-- Reject --}}
                            @if(!in_array($ad->status, ['rejected','expired']))
                            <button type="button" class="action-btn action-btn--reject"
                                onclick="openReject({{ $ad->id }})">
                                Reject
                            </button>
                            @endif

                            {{-- Expire --}}
                            @if($ad->status === 'active')
                            <form action="{{ route('admin.advertisements.expire', $ad) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="action-btn action-btn--expire"
                                    onclick="return confirm('Expire this ad?')">
                                    Expire
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="td-empty">No advertisements found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $ads->withQueryString()->links() }}</div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <h4>Reject Advertisement</h4>
        <p>Provide a reason — this will be stored and can be communicated to the user.</p>
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="reason" rows="3" class="form-control" placeholder="Reason for rejection..." required></textarea>
            <div class="modal-actions">
                <button type="button" onclick="closeReject()" class="btn btn-ghost">Cancel</button>
                <button type="submit" class="btn btn-danger">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReject(adId) {
        const form = document.getElementById('rejectForm');
        form.action = `/admin/advertisements/${adId}/reject`;
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeReject() {
        document.getElementById('rejectModal').style.display = 'none';
    }
</script>
@endsection