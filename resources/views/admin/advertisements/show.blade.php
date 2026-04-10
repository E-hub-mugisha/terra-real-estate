@extends('layouts.app')

@section('title', 'Advertisement – ' . $advertisement->title)


@section('content')
<style>
    :root {
        --navy:   #19265d;
        --gold:   #C8873A;
        --gold-lt:#e0a55e;
        --cream:  #f9f6f1;
        --ink:    #1a1a2e;
        --muted:  #6b7280;
        --border: rgba(200,135,58,.18);
        --card-bg:#ffffff;
        --shadow: 0 2px 16px rgba(25,38,93,.08);
    }

    /* ── Page header ────────────────────────────────────────── */
    .show-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .show-header-left .breadcrumb-label {
        font-family: 'DM Sans', sans-serif;
        font-size: .7rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: .35rem;
    }

    .show-header-left h1 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.9rem;
        font-weight: 600;
        color: var(--navy);
        margin: 0;
        line-height: 1.1;
    }

    .show-header-right {
        display: flex;
        gap: .6rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-terra {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .8rem;
        font-weight: 600;
        letter-spacing: .05em;
        padding: .55rem 1.2rem;
        border-radius: 7px;
        border: 1px solid transparent;
        cursor: pointer;
        text-decoration: none;
        transition: all .18s;
    }

    .btn-terra.primary  { background: var(--gold); color: #fff; }
    .btn-terra.primary:hover { background: #b5752e; color: #fff; }
    .btn-terra.outline  { background: transparent; border-color: var(--navy); color: var(--navy); }
    .btn-terra.outline:hover { background: var(--navy); color: #fff; }
    .btn-terra.danger   { background: transparent; border-color: #dc2626; color: #dc2626; }
    .btn-terra.danger:hover { background: #dc2626; color: #fff; }
    .btn-terra.success  { background: #059669; color: #fff; border-color: #059669; }
    .btn-terra.success:hover { background: #047857; color: #fff; }
    .btn-terra.warning  { background: #d97706; color: #fff; border-color: #d97706; }
    .btn-terra.warning:hover { background: #b45309; color: #fff; }

    /* ── Layout grid ─────────────────────────────────────────── */
    .show-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 1.5rem;
        align-items: start;
    }

    @media (max-width: 900px) {
        .show-grid { grid-template-columns: 1fr; }
    }

    /* ── Sections ────────────────────────────────────────────── */
    .section-card {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        margin-bottom: 1.25rem;
    }

    .section-card:last-child { margin-bottom: 0; }

    .section-title {
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        letter-spacing: .13em;
        text-transform: uppercase;
        color: var(--gold);
        font-weight: 600;
        margin-bottom: 1.1rem;
        padding-bottom: .6rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    /* ── Detail rows ─────────────────────────────────────────── */
    .detail-row {
        display: grid;
        grid-template-columns: 150px 1fr;
        gap: .4rem 1rem;
        margin-bottom: .7rem;
        font-family: 'DM Sans', sans-serif;
    }

    .detail-row:last-child { margin-bottom: 0; }

    .detail-label {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: var(--muted);
        padding-top: .1rem;
    }

    .detail-value {
        font-size: .88rem;
        color: var(--ink);
        font-weight: 500;
        line-height: 1.4;
    }

    /* ── Images grid ─────────────────────────────────────────── */
    .images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: .65rem;
        margin-top: .5rem;
    }

    .images-grid a {
        display: block;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--border);
        aspect-ratio: 1;
        transition: transform .2s, box-shadow .2s;
    }

    .images-grid a:hover { transform: scale(1.03); box-shadow: 0 4px 16px rgba(25,38,93,.14); }

    .images-grid img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ── Badges ──────────────────────────────────────────────── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: .25rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        padding: .3rem .75rem;
        border-radius: 30px;
    }

    .badge::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-success  { background: #d1fae5; color: #065f46; }
    .badge-warning  { background: #fef3c7; color: #92400e; }
    .badge-danger   { background: #fee2e2; color: #991b1b; }
    .badge-secondary{ background: #f3f4f6; color: #374151; }
    .badge-info     { background: #dbeafe; color: #1e40af; }
    .badge-dark     { background: #1f2937; color: #d1d5db; }

    /* ── Metrics ─────────────────────────────────────────────── */
    .metrics-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: .75rem;
    }

    .metric-box {
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: .9rem 1rem;
        text-align: center;
    }

    .metric-box .m-value {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--navy);
        line-height: 1;
    }

    .metric-box .m-label {
        font-family: 'DM Sans', sans-serif;
        font-size: .68rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        margin-top: .2rem;
    }

    /* ── Timeline ────────────────────────────────────────────── */
    .timeline {
        list-style: none;
        padding: 0; margin: 0;
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 10px; top: 0; bottom: 0;
        width: 1px;
        background: var(--border);
    }

    .timeline li {
        display: flex;
        gap: .85rem;
        align-items: flex-start;
        padding: .5rem 0;
        font-family: 'DM Sans', sans-serif;
    }

    .timeline li .tl-dot {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: var(--cream);
        border: 2px solid var(--border);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .6rem;
        color: var(--navy);
        position: relative;
        z-index: 1;
    }

    .timeline li.done .tl-dot { background: var(--navy); border-color: var(--navy); color: #fff; }
    .timeline li.gold .tl-dot { background: var(--gold); border-color: var(--gold); color: #fff; }

    .timeline li .tl-info .tl-event {
        font-size: .82rem;
        font-weight: 600;
        color: var(--ink);
    }

    .timeline li .tl-info .tl-time {
        font-size: .72rem;
        color: var(--muted);
    }

    /* ── Admin note ──────────────────────────────────────────── */
    .admin-note-box {
        background: #fffbeb;
        border: 1px solid #fbbf24;
        border-radius: 8px;
        padding: .85rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .85rem;
        color: #78350f;
        margin-top: .75rem;
    }

    /* ── Quick approve/reject panel ──────────────────────────── */
    .action-panel {
        background: var(--navy);
        color: #fff;
        border-radius: 12px;
        padding: 1.4rem;
        margin-bottom: 1.25rem;
    }

    .action-panel h3 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 1rem;
        color: var(--gold-lt);
    }

    .action-panel textarea {
        width: 100%;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 6px;
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        padding: .6rem .8rem;
        resize: vertical;
        min-height: 70px;
        margin-bottom: .75rem;
        outline: none;
    }

    .action-panel textarea::placeholder { color: rgba(255,255,255,.4); }

    .action-panel .panel-btns {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }
</style>

<div class="container-fluid py-4 px-4">

    {{-- Page Header --}}
    <div class="show-header">
        <div class="show-header-left">
            <div class="breadcrumb-label">
                <a href="{{ route('admin.advertisements.index') }}"
                   style="color:var(--gold);text-decoration:none;">Advertisements</a>
                &rsaquo; Detail
            </div>
            <h1>{{ $advertisement->title }}</h1>
        </div>
        <div class="show-header-right">
            <a href="{{ route('admin.advertisements.edit', $advertisement) }}"
               class="btn-terra outline">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <form method="POST"
                  action="{{ route('admin.advertisements.destroy', $advertisement) }}"
                  onsubmit="return confirm('Delete this advertisement permanently?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-terra danger">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="show-grid">

        {{-- ── LEFT COLUMN ──────────────────────────────────────── --}}
        <div>

            {{-- Core details --}}
            <div class="section-card">
                <div class="section-title">
                    <i class="bi bi-info-circle"></i> Advertisement Details
                </div>

                <div class="detail-row">
                    <span class="detail-label">Title</span>
                    <span class="detail-value">{{ $advertisement->title }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Description</span>
                    <span class="detail-value" style="white-space:pre-wrap;">{{ $advertisement->description }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Location</span>
                    <span class="detail-value">{{ $advertisement->location ?: '—' }}</span>
                </div>
                @if($advertisement->price_amount)
                <div class="detail-row">
                    <span class="detail-label">Listed Price</span>
                    <span class="detail-value">
                        {{ number_format($advertisement->price_amount) }}
                        {{ $advertisement->currency }}
                    </span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Contact Phone</span>
                    <span class="detail-value">{{ $advertisement->contact_phone ?: '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Email</span>
                    <span class="detail-value">{{ $advertisement->contact_email ?: '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">
                        @php $sb = $advertisement->status_badge; @endphp
                        <span class="badge {{ $sb['class'] }}">{{ $sb['label'] }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Created</span>
                    <span class="detail-value">{{ $advertisement->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            {{-- Images --}}
            @if(!empty($advertisement->images) && count($advertisement->images))
            <div class="section-card">
                <div class="section-title">
                    <i class="bi bi-images"></i> Images
                    <span style="font-size:.7rem;color:var(--muted);margin-left:auto;text-transform:none;letter-spacing:0;">
                        {{ count($advertisement->images) }} file(s)
                    </span>
                </div>
                <div class="images-grid">
                    @foreach($advertisement->images as $img)
                        <a href="{{ asset($img) }}" target="_blank">
                            <img src="{{ asset($img) }}" alt="Ad image">
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Video --}}
            @if($advertisement->video_path)
            <div class="section-card">
                <div class="section-title"><i class="bi bi-camera-video"></i> Video</div>
                <video
                    src="{{ asset($advertisement->video_path) }}"
                    controls
                    style="width:100%;border-radius:8px;max-height:320px;background:#000;"
                ></video>
            </div>
            @endif

            {{-- Performance --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-bar-chart-line"></i> Performance</div>
                <div class="metrics-row">
                    <div class="metric-box">
                        <div class="m-value">{{ number_format($advertisement->impressions) }}</div>
                        <div class="m-label">Impressions</div>
                    </div>
                    <div class="metric-box">
                        <div class="m-value">{{ number_format($advertisement->clicks) }}</div>
                        <div class="m-label">Clicks</div>
                    </div>
                    <div class="metric-box">
                        <div class="m-value">
                            @if($advertisement->impressions > 0)
                                {{ number_format(($advertisement->clicks / $advertisement->impressions) * 100, 2) }}%
                            @else
                                0%
                            @endif
                        </div>
                        <div class="m-label">CTR</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── RIGHT COLUMN ─────────────────────────────────────── --}}
        <div>

            {{-- Quick action panel (only for pending_review) --}}
            @if($advertisement->status === 'pending_review')
            <div class="action-panel">
                <h3>Review Advertisement</h3>

                {{-- Approve --}}
                <form method="POST"
                      action="{{ route('admin.advertisements.approve', $advertisement) }}"
                      style="margin-bottom:.5rem;">
                    @csrf
                    <button type="submit" class="btn-terra success" style="width:100%;justify-content:center;">
                        <i class="bi bi-check-circle"></i> Approve & Activate
                    </button>
                </form>

                {{-- Reject --}}
                <form method="POST"
                      action="{{ route('admin.advertisements.reject', $advertisement) }}">
                    @csrf
                    <textarea name="admin_notes"
                              placeholder="Rejection reason (optional)…"></textarea>
                    <div class="panel-btns">
                        <button type="submit" class="btn-terra danger" style="flex:1;justify-content:center;">
                            <i class="bi bi-x-circle"></i> Reject
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Package & payment --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-box"></i> Package & Payment</div>

                <div class="detail-row">
                    <span class="detail-label">Package</span>
                    <span class="detail-value">{{ $advertisement->listingPackage?->name ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Duration</span>
                    <span class="detail-value">{{ $advertisement->listing_days }} day(s)</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Cost</span>
                    <span class="detail-value" style="color:var(--gold);font-weight:700;">
                        {{ $advertisement->formatted_total }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment</span>
                    <span class="detail-value">
                        @php $pb = $advertisement->payment_badge; @endphp
                        <span class="badge {{ $pb['class'] }}">{{ $pb['label'] }}</span>
                    </span>
                </div>
                @if($advertisement->momo_phone)
                <div class="detail-row">
                    <span class="detail-label">MoMo Phone</span>
                    <span class="detail-value">{{ $advertisement->momo_phone }}</span>
                </div>
                @endif
                @if($advertisement->momo_transaction_id)
                <div class="detail-row">
                    <span class="detail-label">Transaction ID</span>
                    <span class="detail-value" style="font-family:monospace;font-size:.82rem;">
                        {{ $advertisement->momo_transaction_id }}
                    </span>
                </div>
                @endif
            </div>

            {{-- Owner --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-person"></i> Owner</div>

                <div class="detail-row">
                    <span class="detail-label">Name</span>
                    <span class="detail-value">{{ $advertisement->user?->name ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $advertisement->user?->email ?? '—' }}</span>
                </div>
                @if($advertisement->confirmedBy)
                <div class="detail-row">
                    <span class="detail-label">Confirmed by</span>
                    <span class="detail-value">{{ $advertisement->confirmedBy->name }}</span>
                </div>
                @endif
            </div>

            {{-- Timeline --}}
            <div class="section-card">
                <div class="section-title"><i class="bi bi-clock-history"></i> Timeline</div>
                <ul class="timeline">
                    <li class="{{ $advertisement->created_at ? 'done' : '' }}">
                        <div class="tl-dot"><i class="bi bi-plus-sm"></i></div>
                        <div class="tl-info">
                            <div class="tl-event">Created</div>
                            <div class="tl-time">
                                {{ $advertisement->created_at?->format('d M Y, H:i') ?? '—' }}
                            </div>
                        </div>
                    </li>
                    <li class="{{ $advertisement->payment_submitted_at ? 'done' : '' }}">
                        <div class="tl-dot"><i class="bi bi-credit-card"></i></div>
                        <div class="tl-info">
                            <div class="tl-event">Payment Submitted</div>
                            <div class="tl-time">
                                {{ $advertisement->payment_submitted_at?->format('d M Y, H:i') ?? 'Pending' }}
                            </div>
                        </div>
                    </li>
                    <li class="{{ $advertisement->payment_confirmed_at ? 'gold' : '' }}">
                        <div class="tl-dot"><i class="bi bi-check"></i></div>
                        <div class="tl-info">
                            <div class="tl-event">Activated</div>
                            <div class="tl-time">
                                {{ $advertisement->payment_confirmed_at?->format('d M Y, H:i') ?? '—' }}
                            </div>
                        </div>
                    </li>
                    <li class="{{ $advertisement->expires_at?->isPast() ? 'done' : '' }}">
                        <div class="tl-dot"><i class="bi bi-flag"></i></div>
                        <div class="tl-info">
                            <div class="tl-event">Expires</div>
                            <div class="tl-time">
                                {{ $advertisement->expires_at?->format('d M Y, H:i') ?? '—' }}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            {{-- Admin notes --}}
            @if($advertisement->admin_notes)
            <div class="section-card">
                <div class="section-title"><i class="bi bi-sticky"></i> Admin Notes</div>
                <div class="admin-note-box">{{ $advertisement->admin_notes }}</div>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection