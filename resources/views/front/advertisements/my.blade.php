@extends('layouts.app')

@section('title', 'My Advertisements — Terra')

@section('content')

<style>
.my-ads-hero { background: #051321; padding: 56px 0 40px; }
.my-ads-hero__inner { display: flex; justify-content: space-between; align-items: center; }
.my-ads-hero__title { color: #fff; font-size: 32px; font-weight: 700; margin-bottom: 6px; }
.my-ads-hero__sub { color: rgba(255,255,255,.6); font-size: 16px; }

.btn-primary { background: #00a667; color: #fff; padding: 11px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 15px; display: inline-block; border: none; }
.btn-primary:hover { background: #008f57; }

.section-pad { padding: 48px 0; }

.alert { padding: 14px 18px; border-radius: 10px; margin-bottom: 28px; font-size: 14px; }
.alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

.my-ad-card {
    display: flex; gap: 0; background: #fff; border: 1.5px solid #e5e7eb;
    border-radius: 14px; overflow: hidden; margin-bottom: 20px;
    transition: box-shadow .2s;
}
.my-ad-card:hover { box-shadow: 0 4px 20px rgba(5,19,33,.08); }
.my-ad-card--active { border-color: #a7f3d0; }

.my-ad-card__media { width: 160px; flex-shrink: 0; position: relative; }
.my-ad-card__media img { width: 100%; height: 100%; object-fit: cover; display: block; }
.my-ad-card__media-placeholder {
    width: 100%; height: 100%; background: #f3f4f6;
    display: flex; align-items: center; justify-content: center;
}
.my-ad-card__media-placeholder svg { width: 40px; height: 40px; color: #d1d5db; }
.my-ad-card__video-badge {
    position: absolute; bottom: 8px; left: 8px;
    background: rgba(124,58,237,.9); color: #fff; font-size: 10px;
    font-weight: 700; padding: 3px 7px; border-radius: 4px; letter-spacing: .05em;
}

.my-ad-card__content { flex: 1; padding: 20px 24px; }
.my-ad-card__top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
.my-ad-card__title { font-size: 17px; font-weight: 700; color: #051321; margin-bottom: 4px; }
.my-ad-card__meta { font-size: 13px; color: #6b7280; }
.my-ad-card__badges { display: flex; flex-direction: column; gap: 6px; align-items: flex-end; }

.status-pill { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; }
.status-pill--active          { background: #d1fae5; color: #065f46; }
.status-pill--draft           { background: #f3f4f6; color: #6b7280; }
.status-pill--pending-review  { background: #fef3c7; color: #92400e; }
.status-pill--expired         { background: #f3f4f6; color: #9ca3af; }
.status-pill--rejected        { background: #fee2e2; color: #991b1b; }
.status-pill--pmt-pending     { background: #fef3c7; color: #92400e; }
.status-pill--pmt-confirmed   { background: #d1fae5; color: #065f46; }
.status-pill--pmt-rejected    { background: #fee2e2; color: #991b1b; }

.my-ad-card__stats { display: flex; gap: 24px; margin-bottom: 12px; }
.my-ad-stat__val { display: block; font-size: 22px; font-weight: 800; color: #051321; }
.my-ad-stat__label { font-size: 12px; color: #9ca3af; }

.my-ad-card__progress { height: 4px; background: #f3f4f6; border-radius: 4px; overflow: hidden; margin-bottom: 6px; }
.my-ad-card__progress-bar { height: 100%; background: #00a667; border-radius: 4px; }
.my-ad-card__progress-label { font-size: 12px; color: #9ca3af; }

.my-ad-card__notice {
    background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 8px;
    padding: 10px 14px; font-size: 13px; color: #374151; margin-top: 12px;
}
.my-ad-card__notice a { color: #00a667; }
.my-ad-card__notice--pending { background: #fffbeb; border-color: #fde68a; }
.my-ad-card__notice--danger  { background: #fef2f2; border-color: #fecaca; color: #991b1b; }

.my-ads-empty { text-align: center; padding: 80px 0; }
.my-ads-empty p { color: #6b7280; margin-bottom: 20px; font-size: 16px; }

@media (max-width: 600px) {
    .my-ad-card { flex-direction: column; }
    .my-ad-card__media { width: 100%; height: 180px; }
    .my-ads-hero__inner { flex-direction: column; gap: 16px; }
    .my-ad-card__top { flex-direction: column; gap: 10px; }
    .my-ad-card__badges { align-items: flex-start; flex-direction: row; }
    .my-ad-card__stats { flex-wrap: wrap; gap: 16px; }
}
</style>

<section class="my-ads-hero">
    <div class="container">
        <div class="my-ads-hero__inner">
            <div>
                <h1 class="my-ads-hero__title">My Advertisements</h1>
                <p class="my-ads-hero__sub">Track performance and manage your active property ads.</p>
            </div>
            <a href="{{ route('advertisements.packages') }}" class="btn btn-primary">
                + New Advertisement
            </a>
        </div>
    </div>
</section>

<section class="my-ads section-pad">
    <div class="container">

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse ($ads as $ad)
        <div class="my-ad-card {{ $ad->is_active ? 'my-ad-card--active' : '' }}">
            {{-- Thumbnail --}}
            <div class="my-ad-card__media">
                @if($ad->first_image_url)
                <img src="{{ $ad->first_image_url }}" alt="{{ $ad->title }}">
                @else
                <div class="my-ad-card__media-placeholder">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif
                @if($ad->video_path)
                <span class="my-ad-card__video-badge">VIDEO</span>
                @endif
            </div>

            {{-- Content --}}
            <div class="my-ad-card__content">
                <div class="my-ad-card__top">
                    <div>
                        <h3 class="my-ad-card__title">{{ $ad->title }}</h3>
                        <p class="my-ad-card__meta">
                            {{ $ad->package->name }} Package ·
                            {{ $ad->listing_type }} ·
                            @if($ad->location) {{ $ad->location }} @endif
                        </p>
                    </div>
                    <div class="my-ad-card__badges">
                        {{-- Status --}}
                        <span class="status-pill status-pill--{{ str_replace('_','-',$ad->status) }}">
                            {{ ucwords(str_replace('_', ' ', $ad->status)) }}
                        </span>
                        {{-- Payment --}}
                        <span class="status-pill status-pill--pmt-{{ $ad->payment_status }}">
                            {{ ucfirst($ad->payment_status) }} payment
                        </span>
                    </div>
                </div>

                {{-- Stats --}}
                @if($ad->is_active)
                <div class="my-ad-card__stats">
                    <div class="my-ad-stat">
                        <span class="my-ad-stat__val">{{ number_format($ad->impressions) }}</span>
                        <span class="my-ad-stat__label">Views</span>
                    </div>
                    <div class="my-ad-stat">
                        <span class="my-ad-stat__val">{{ number_format($ad->clicks) }}</span>
                        <span class="my-ad-stat__label">Clicks</span>
                    </div>
                    <div class="my-ad-stat">
                        <span class="my-ad-stat__val">{{ $ad->days_remaining }}d</span>
                        <span class="my-ad-stat__label">Remaining</span>
                    </div>
                    <div class="my-ad-stat">
                        <span class="my-ad-stat__val">
                            {{ $ad->impressions > 0 ? round(($ad->clicks / $ad->impressions) * 100, 1) : 0 }}%
                        </span>
                        <span class="my-ad-stat__label">CTR</span>
                    </div>
                </div>

                {{-- Progress bar --}}
                @php
                    $totalDays = $ad->package->duration_days;
                    $usedDays  = $totalDays - $ad->days_remaining;
                    $pct       = min(100, round(($usedDays / $totalDays) * 100));
                @endphp
                <div class="my-ad-card__progress">
                    <div class="my-ad-card__progress-bar" style="width: {{ $pct }}%"></div>
                </div>
                <p class="my-ad-card__progress-label">
                    {{ $usedDays }} of {{ $totalDays }} days used ·
                    Expires {{ $ad->expires_at->format('d M Y') }}
                </p>
                @endif

                {{-- Pending review notice --}}
                @if($ad->status === 'pending_review')
                <div class="my-ad-card__notice my-ad-card__notice--pending">
                    <strong>Awaiting verification.</strong> Our team is confirming your MoMo payment ({{ $ad->momo_phone }}). Usually 2–4 hours.
                </div>
                @endif

                {{-- Draft notice → go to checkout --}}
                @if($ad->status === 'draft')
                <div class="my-ad-card__notice">
                    Your ad details are saved. <a href="{{ route('advertisements.checkout', $ad) }}">Complete your payment →</a>
                </div>
                @endif

                {{-- Rejected notice --}}
                @if($ad->status === 'rejected' && $ad->admin_notes)
                <div class="my-ad-card__notice my-ad-card__notice--danger">
                    <strong>Rejected:</strong> {{ $ad->admin_notes }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="my-ads-empty">
            <p>You haven't created any advertisements yet.</p>
            <a href="{{ route('advertisements.packages') }}" class="btn btn-primary">Advertise a Property</a>
        </div>
        @endforelse

        <div class="mt-4">{{ $ads->links() }}</div>
    </div>
</section>
@endsection
