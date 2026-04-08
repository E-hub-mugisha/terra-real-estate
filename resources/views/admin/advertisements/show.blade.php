@extends('layouts.app')
@section('title', 'Advertisement #' . $advertisement->id)

@section('content')

<style>
    @@keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    .ad-section   { animation: fadeIn .25s ease; background: #fff; border-radius: 12px; border: 1px solid #e5e8f0; padding: 1.5rem; margin-bottom: 1rem; }
    .dl-row       { display: grid; grid-template-columns: 160px 1fr; gap: .25rem .75rem; font-size: .875rem; }
    .dl-row dt    { color: #6b7280; font-weight: 500; padding: .3rem 0; }
    .dl-row dd    { color: #111827; padding: .3rem 0; margin: 0; }
    .sec-title    { font-family: 'Cormorant Garamond', serif; color: #19265d; font-size: 1rem; font-weight: 700; margin-bottom: 1rem; padding-bottom: .4rem; border-bottom: 1.5px solid #f0f2f8; }

    /* Status pills */
    .pill         { display: inline-flex; align-items: center; gap: .3rem; padding: .25rem .7rem; border-radius: 999px; font-size: .75rem; font-weight: 600; letter-spacing: .02em; }
    .pill-draft       { background: #f3f4f6; color: #6b7280; }
    .pill-pending     { background: #fef3c7; color: #92400e; }
    .pill-active      { background: #d1fae5; color: #065f46; }
    .pill-rejected    { background: #fee2e2; color: #991b1b; }
    .pill-paused      { background: #ede9fe; color: #5b21b6; }
    .pill-expired     { background: #f1f5f9; color: #475569; }
    .pill-paid        { background: #d1fae5; color: #065f46; }
    .pill-unpaid      { background: #fee2e2; color: #991b1b; }
    .pill-review      { background: #dbeafe; color: #1e40af; }

    /* Image thumbs */
    .img-thumb-grid { display: flex; flex-wrap: wrap; gap: .6rem; }
    .img-thumb-grid a { display: block; width: 110px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid #e5e8f0; transition: transform .15s; }
    .img-thumb-grid a:hover { transform: scale(1.04); }
    .img-thumb-grid img { width: 100%; height: 100%; object-fit: cover; }

    /* Timeline */
    .timeline     { list-style: none; padding: 0; margin: 0; }
    .tl-item      { display: flex; gap: .75rem; padding: .5rem 0; border-bottom: 1px solid #f0f2f8; font-size: .8rem; }
    .tl-item:last-child { border-bottom: none; }
    .tl-dot       { flex-shrink: 0; width: 10px; height: 10px; border-radius: 50%; margin-top: 3px; }
    .tl-meta      { color: #9ca3af; font-size: .72rem; }

    /* Action buttons */
    .action-btn   { display: block; width: 100%; padding: .55rem 1rem; border-radius: 8px; font-size: .875rem; font-weight: 600; text-align: center; border: none; cursor: pointer; transition: opacity .15s; }
    .action-btn:hover { opacity: .88; }
    .btn-approve  { background: #10b981; color: #fff; }
    .btn-reject   { background: #fff; color: #ef4444; border: 1.5px solid #ef4444 !important; }
    .btn-pause    { background: #fff; color: #7c3aed; border: 1.5px solid #7c3aed !important; }
    .btn-reactivate { background: #3b82f6; color: #fff; }
    .btn-delete   { background: #fff; color: #dc2626; border: 1.5px solid #fca5a5 !important; font-size: .8rem; }
    .btn-edit     { background: #19265d; color: #fff; }
</style>

<div class="container-fluid py-4" style="max-width:960px">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h2 style="font-family:'Cormorant Garamond',serif;color:#19265d;font-size:1.7rem;margin-bottom:.15rem">
                Advertisement #{{ $advertisement->id }}
            </h2>
            <p class="text-muted mb-0 small">{{ $advertisement->title }}</p>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            @php $sb = $advertisement->status_badge; $pb = $advertisement->payment_badge; @endphp
            <span class="pill pill-{{ $advertisement->status }}">
                {{ $sb['label'] }}
            </span>
            <span class="pill pill-{{ $advertisement->payment_status === 'paid' ? 'paid' : 'unpaid' }}">
                {{ $pb['label'] }}
            </span>
            <a href="{{ route('admin.advertisements.index') }}" class="btn btn-outline-secondary btn-sm">← Back</a>
        </div>
    </div>

    <div class="row g-3">

        {{-- ── LEFT COLUMN ─────────────────────────────────────────── --}}
        <div class="col-lg-8">

            {{-- Ad Details --}}
            <div class="ad-section">
                <div class="sec-title">Ad details</div>
                <dl class="dl-row">
                    <dt>Title</dt>
                    <dd>{{ $advertisement->title }}</dd>

                    <dt>Description</dt>
                    <dd style="white-space:pre-line">{{ $advertisement->description }}</dd>

                    <dt>Location</dt>
                    <dd>{{ $advertisement->location ?? '—' }}</dd>

                    <dt>Asking price</dt>
                    <dd>
                        @if($advertisement->price_amount)
                            <strong style="color:#D05208">{{ number_format($advertisement->price_amount) }} {{ $advertisement->currency ?? 'RWF' }}</strong>
                        @else
                            —
                        @endif
                    </dd>

                    <dt>Contact phone</dt>
                    <dd>{{ $advertisement->contact_phone ?? '—' }}</dd>

                    <dt>Contact email</dt>
                    <dd>{{ $advertisement->contact_email ?? '—' }}</dd>

                    @if($advertisement->advertisable)
                    <dt>Linked property</dt>
                    <dd>
                        {{ class_basename($advertisement->advertisable_type) }} #{{ $advertisement->advertisable_id }}
                        @if($advertisement->advertisable->title ?? false)
                            — {{ $advertisement->advertisable->title }}
                        @endif
                    </dd>
                    @endif

                    <dt>Owner</dt>
                    <dd>
                        {{ $advertisement->user->name ?? '—' }}
                        @if($advertisement->user?->email)
                            <span class="text-muted">({{ $advertisement->user->email }})</span>
                        @endif
                    </dd>

                    <dt>Created</dt>
                    <dd>{{ $advertisement->created_at->format('d M Y, H:i') }}</dd>
                </dl>
            </div>

            {{-- Images --}}
            @if($advertisement->images && count($advertisement->images))
            <div class="ad-section">
                <div class="sec-title">Images ({{ count($advertisement->images) }})</div>
                <div class="img-thumb-grid">
                    @foreach($advertisement->images as $img)
                        <a href="{{ asset($img) }}" target="_blank" title="View full size">
                            <img src="{{ asset($img) }}" alt="Ad image">
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Payment Details --}}
            <div class="ad-section">
                <div class="sec-title">Payment details</div>
                <dl class="dl-row">
                    <dt>Package</dt>
                    <dd>{{ $advertisement->listingPackage?->tier_label ?? '—' }}</dd>

                    <dt>Duration</dt>
                    <dd>{{ $advertisement->listing_days }} day{{ $advertisement->listing_days != 1 ? 's' : '' }}</dd>

                    <dt>Total cost</dt>
                    <dd><strong style="color:#D05208">{{ $advertisement->formatted_total }}</strong></dd>

                    <dt>Payment status</dt>
                    <dd><span class="pill pill-{{ $advertisement->payment_status === 'paid' ? 'paid' : 'unpaid' }}">{{ $pb['label'] }}</span></dd>

                    <dt>MoMo phone</dt>
                    <dd>{{ $advertisement->momo_phone ?? '—' }}</dd>

                    <dt>Transaction ID</dt>
                    <dd><code>{{ $advertisement->momo_transaction_id ?? '—' }}</code></dd>

                    <dt>Submitted at</dt>
                    <dd>{{ $advertisement->payment_submitted_at?->format('d M Y, H:i') ?? '—' }}</dd>

                    @if($advertisement->confirmedBy)
                    <dt>Reviewed by</dt>
                    <dd>{{ $advertisement->confirmedBy->name }}</dd>
                    @endif

                    @if($advertisement->admin_notes)
                    <dt>Admin notes</dt>
                    <dd style="white-space:pre-line;color:#dc2626">{{ $advertisement->admin_notes }}</dd>
                    @endif
                </dl>
            </div>

            {{-- Active period --}}
            @if($advertisement->starts_at)
            <div class="ad-section">
                <div class="sec-title">Schedule</div>
                <dl class="dl-row">
                    <dt>Starts</dt>
                    <dd>{{ $advertisement->starts_at->format('d M Y') }}</dd>
                    <dt>Expires</dt>
                    <dd>
                        {{ $advertisement->expires_at?->format('d M Y') ?? '—' }}
                        @if($advertisement->expires_at && $advertisement->expires_at->isPast())
                            <span class="pill pill-expired ms-1">Expired</span>
                        @elseif($advertisement->expires_at)
                            <span class="text-muted small ms-1">({{ $advertisement->expires_at->diffForHumans() }})</span>
                        @endif
                    </dd>
                </dl>
            </div>
            @endif

            {{-- Activity Log --}}
            @if(isset($activityLog) && $activityLog->count())
            <div class="ad-section">
                <div class="sec-title">Activity log</div>
                <ul class="timeline">
                    @foreach($activityLog as $log)
                    <li class="tl-item">
                        <span class="tl-dot" style="background:{{ $log->color ?? '#9ca3af' }}"></span>
                        <div>
                            <div>{{ $log->description }}</div>
                            <div class="tl-meta">{{ $log->causer?->name ?? 'System' }} · {{ $log->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>

        {{-- ── RIGHT COLUMN: Actions ──────────────────────────────── --}}
        <div class="col-lg-4">
            <div class="ad-section" style="position:sticky;top:1.5rem">
                <div class="sec-title">Admin actions</div>

                {{-- Edit --}}
                <a href="{{ route('admin.advertisements.edit', $advertisement) }}" class="action-btn btn-edit mb-2 text-decoration-none">
                    Edit advertisement
                </a>

                {{-- Approve --}}
                @if(in_array($advertisement->status, ['draft','pending_review','paused']))
                <form method="POST" action="{{ route('admin.advertisements.approve', $advertisement) }}" class="mb-2">
                    @csrf
                    <button type="submit" class="action-btn btn-approve"
                        onclick="return confirm('Confirm payment received and activate this ad?')">
                        ✓ Approve &amp; activate
                    </button>
                </form>
                @endif

                {{-- Pause / Re-activate --}}
                @if($advertisement->status === 'active')
                <form method="POST" action="{{ route('admin.advertisements.pause', $advertisement) }}" class="mb-2">
                    @csrf
                    <button type="submit" class="action-btn btn-pause"
                        onclick="return confirm('Pause this advertisement?')">
                        ⏸ Pause
                    </button>
                </form>
                @endif

                @if($advertisement->status === 'paused')
                <form method="POST" action="{{ route('admin.advertisements.reactivate', $advertisement) }}" class="mb-2">
                    @csrf
                    <button type="submit" class="action-btn btn-reactivate"
                        onclick="return confirm('Re-activate this advertisement?')">
                        ▶ Re-activate
                    </button>
                </form>
                @endif

                {{-- Reject --}}
                @if(!in_array($advertisement->status, ['rejected','active']))
                <div class="mt-3 pt-3" style="border-top:1px solid #f0f2f8">
                    <p class="small text-muted mb-2">Reject with optional reason:</p>
                    <form method="POST" action="{{ route('admin.advertisements.reject', $advertisement) }}">
                        @csrf
                        <textarea name="admin_notes" class="form-control form-control-sm mb-2" rows="3"
                            placeholder="Reason for rejection (optional)">{{ $advertisement->admin_notes }}</textarea>
                        <button type="submit" class="action-btn btn-reject"
                            onclick="return confirm('Reject this advertisement?')">
                            ✕ Reject
                        </button>
                    </form>
                </div>
                @endif

                {{-- Mark payment paid / unpaid --}}
                <div class="mt-3 pt-3" style="border-top:1px solid #f0f2f8">
                    <p class="small text-muted mb-2">Payment override:</p>
                    @if($advertisement->payment_status !== 'paid')
                    <form method="POST" action="{{ route('admin.advertisements.markPaid', $advertisement) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="action-btn" style="background:#059669;color:#fff"
                            onclick="return confirm('Mark payment as received?')">
                            Mark as paid
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.advertisements.markUnpaid', $advertisement) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="action-btn" style="background:#fff;color:#6b7280;border:1.5px solid #d1d5db"
                            onclick="return confirm('Revert payment to pending?')">
                            Mark as unpaid
                        </button>
                    </form>
                    @endif
                </div>

                {{-- Danger zone --}}
                <div class="mt-3 pt-3" style="border-top:1px solid #fee2e2">
                    <p class="small text-muted mb-2">Danger zone:</p>
                    <form method="POST" action="{{ route('admin.advertisements.destroy', $advertisement) }}"
                        onsubmit="return confirm('Permanently delete this advertisement and all its images? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-delete">Delete permanently</button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection