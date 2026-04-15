@extends('layouts.professional')

@section('title', 'Dashboard — Terra Professional')
@section('page_title', 'Dashboard')

@section('content')
{{-- ── Welcome Banner ─────────────────────────────────────────────────── --}}
<div class="welcome-banner">
    <div class="welcome-inner">
        <div>
            <p class="welcome-sub">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }},</p>
            <h1 class="welcome-name">{{ Auth::user()->name }}</h1>
            <p class="welcome-tagline">Here's what's happening with your designs today.</p>
        </div>
        <a href="{{ route('professional.architectural-designs.create') }}" class="btn-gold-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add New Design
        </a>
    </div>
</div>

{{-- ── Stat Cards ──────────────────────────────────────────────────────── --}}
<div class="stats-grid">
    <div class="stat-card stat-navy">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <div class="stat-body">
            <span class="stat-label">Total Designs</span>
            <span class="stat-value">{{ $stats['total_designs'] }}</span>
        </div>
    </div>

    <div class="stat-card stat-gold">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        </div>
        <div class="stat-body">
            <span class="stat-label">Active Designs</span>
            <span class="stat-value">{{ $stats['active_designs'] }}</span>
        </div>
    </div>

    <div class="stat-card stat-amber">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
        <div class="stat-body">
            <span class="stat-label">Pending Orders</span>
            <span class="stat-value">{{ $stats['pending_orders'] }}</span>
        </div>
    </div>

    <div class="stat-card stat-green">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <div class="stat-body">
            <span class="stat-label">Completed Orders</span>
            <span class="stat-value">{{ $stats['completed_orders'] }}</span>
        </div>
    </div>
</div>

{{-- ── Two-Column Layout ───────────────────────────────────────────────── --}}
<div class="dash-two-col">

    {{-- Recent Orders --}}
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                Recent Orders
            </h2>
            <a href="{{ route('professional.orders.index') }}" class="panel-link">View All →</a>
        </div>

        @forelse($recent_orders as $order)
        <div class="order-row">
            <div class="order-avatar">{{ strtoupper(substr($order->user->name ?? 'U', 0, 2)) }}</div>
            <div class="order-info">
                <p class="order-user">{{ $order->user->name ?? 'Unknown User' }}</p>
                <p class="order-design">{{ $order->design->title ?? '—' }}</p>
            </div>
            <div class="order-meta">
                <span class="status-badge status-{{ $order->status }}">{{ $order->status_label }}</span>
                <span class="order-date">{{ $order->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @empty
        <div class="empty-state-sm">
            <p>No orders yet. Share your designs to get inquiries!</p>
        </div>
        @endforelse
    </div>

    {{-- Recent Designs --}}
    <div class="panel">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                Recent Designs
            </h2>
            <a href="{{ route('professional.architectural-designs.index') }}" class="panel-link">View All →</a>
        </div>

        <div class="design-mini-grid">
            @forelse($recent_designs as $design)
            <a href="{{ route('professional.architectural-designs.show', $design) }}" class="design-mini-card">
                <div class="design-mini-thumb"
                     style="background-image: url('{{ $design->cover_image_url }}')">
                    <span class="design-mini-status design-status-{{ $design->status }}">{{ $design->status }}</span>
                </div>
                <div class="design-mini-body">
                    <p class="design-mini-title">{{ Str::limit($design->title, 30) }}</p>
                    <p class="design-mini-price">{{ $design->formatted_price }}</p>
                </div>
            </a>
            @empty
            <div class="empty-state-sm" style="grid-column: 1/-1">
                <p>No designs yet. <a href="{{ route('professional.architectural-designs.create') }}">Add your first design →</a></p>
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
