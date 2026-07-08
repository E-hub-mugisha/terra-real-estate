{{-- resources/views/admin/service-requests/show.blade.php --}}
@extends('layouts.app')
@section('title', 'Service Request #' . $serviceRequest->id)
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/dist/tabler-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .sra-page {
        --navy: #19265d;
        --navy-dark: #111a45;
        --gold: #D05208;
        --gold-light: #fdf1e8;
        --ink: #16203f;
        --muted: #6b7280;
        --line: #e7e9f2;
        --red: #C0392B;
        --red-bg: #fdeeec;
        --green: #166534;
        --green-bg: #f0fdf4;
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        max-width: 1000px;
        margin: 0 auto;
        padding: 1.75rem 0 3rem;
    }

    .sra-back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .82rem; font-weight: 600; color: var(--muted);
        margin-bottom: 1.25rem; transition: color .15s ease;
    }
    .sra-back-link:hover { color: var(--gold); }

    .sra-pill {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .3rem .75rem; border-radius: 20px; font-size: .72rem; font-weight: 600;
    }
    .sra-pill.new       { background: var(--gold-light); color: #8a4306; border: 1px solid #f0d3b8; }
    .sra-pill.assigned  { background: #eef0f8; color: var(--navy); border: 1px solid #d3d8ee; }
    .sra-pill.completed { background: var(--green-bg); color: var(--green); border: 1px solid #bbf7d0; }
    .sra-pill.cancelled { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .sra-pill-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .sra-alert-success {
        background: #eafaf1; border: 1px solid #b9e9cd; color: #146c43;
        border-radius: 12px; padding: .85rem 1.1rem; margin-bottom: 1.25rem; font-size: .88rem;
        display: flex; align-items: center; gap: .5rem;
    }

    .sra-detail-header {
        display: flex; align-items: flex-start; justify-content: space-between; gap: 20px;
        flex-wrap: wrap; margin-bottom: 1.75rem;
    }
    .sra-detail-title {
        font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 1.7rem;
        color: var(--navy); margin: .5rem 0 .2rem;
    }
    .sra-detail-sub { font-size: .8rem; color: var(--muted); }
    .sra-detail-actions { display: flex; gap: 10px; flex-shrink: 0; }

    .sra-btn-assign {
        background: var(--gold); color: #fff; border: none; border-radius: 9px;
        padding: .65rem 1.2rem; font-size: .82rem; font-weight: 700; cursor: pointer;
        transition: background .15s ease;
    }
    .sra-btn-assign:hover { background: #b84706; color: #fff; }
    .sra-btn-cancel-outline {
        background: #fff; color: var(--muted); border: 1.5px solid var(--line); border-radius: 9px;
        padding: .65rem 1.2rem; font-size: .82rem; font-weight: 700; cursor: pointer;
        transition: all .15s ease;
    }
    .sra-btn-cancel-outline:hover { background: var(--red-bg); color: var(--red); border-color: #f2c6c0; }

    .sra-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media (max-width: 720px) { .sra-detail-grid { grid-template-columns: 1fr; } }

    .sra-detail-card {
        background: #fff; border: 1px solid var(--line); border-radius: 14px;
        padding: 20px 22px; margin-bottom: 20px;
    }
    .sra-detail-card h5 {
        font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
        color: var(--gold); margin: 0 0 14px;
    }

    .sra-dl { display: flex; flex-direction: column; gap: 12px; }
    .sra-dl-row { display: flex; flex-direction: column; gap: 2px; }
    .sra-dl-row dt { font-size: .68rem; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
    .sra-dl-row dd { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .sra-dl-row dd.muted { font-weight: 400; color: var(--muted); }

    .sra-message-box {
        font-size: .86rem; color: var(--ink); line-height: 1.7;
        background: #f8fafc; border: 1px solid var(--line); border-radius: 10px; padding: 14px 16px;
    }

    .sra-consultant-block {
        display: flex; align-items: center; gap: 12px; padding: 12px 14px;
        background: #eef0f8; border: 1px solid #d3d8ee; border-radius: 10px;
    }
    .sra-consultant-avatar {
        width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
        background: var(--navy); color: #fff; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: .9rem;
    }
    .sra-consultant-name { font-weight: 700; font-size: .87rem; color: var(--navy); }
    .sra-consultant-sub { font-size: .74rem; color: var(--muted); }

    .sra-unassigned-box {
        text-align: center; padding: 20px 14px; color: var(--muted); font-size: .84rem;
        background: #f8fafc; border: 1px dashed var(--line); border-radius: 10px;
    }

    .sra-report-badge {
        display: inline-flex; align-items: center; gap: 6px; margin-top: 12px;
        font-size: .76rem; font-weight: 600; color: var(--green);
        background: var(--green-bg); border: 1px solid #bbf7d0; border-radius: 8px; padding: .4rem .7rem;
    }

    /* ── Modal (shared style) ── */
    .sra-modal-overlay {
        position: fixed; inset: 0; z-index: 1200;
        background: rgba(15,20,40,.55); backdrop-filter: blur(3px);
        display: flex; align-items: center; justify-content: center; padding: 20px;
        opacity: 0; visibility: hidden; transition: opacity .2s ease, visibility .2s ease;
    }
    .sra-modal-overlay.active { opacity: 1; visibility: visible; }

    .sra-modal {
        background: #fff; border-radius: 16px; width: 100%; max-width: 440px;
        box-shadow: 0 30px 70px rgba(0,0,0,.35);
        transform: translateY(16px) scale(.98); transition: transform .2s ease;
        overflow: hidden;
    }
    .sra-modal-overlay.active .sra-modal { transform: translateY(0) scale(1); }

    .sra-modal-header {
        background: linear-gradient(135deg, var(--navy), var(--navy-dark));
        padding: 20px 22px; display: flex; align-items: flex-start; justify-content: space-between; gap: 14px;
    }
    .sra-modal-eyebrow {
        display: block; font-size: .66rem; font-weight: 700; letter-spacing: .1em;
        text-transform: uppercase; color: var(--gold); margin-bottom: 5px;
    }
    .sra-modal-title { font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 1.3rem; color: #fff; margin: 0; line-height: 1.25; }
    .sra-modal-close {
        width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
        background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.16); color: rgba(255,255,255,.8);
        display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .15s ease;
    }
    .sra-modal-close:hover { background: rgba(255,255,255,.2); color: #fff; }

    .sra-modal-body { padding: 20px 22px 22px; }
    .sra-modal-desc { font-size: .84rem; color: var(--muted); line-height: 1.6; margin-bottom: 16px; }
    .sra-modal-desc strong { color: var(--ink); }

    .sra-field { margin-bottom: 18px; }
    .sra-field label { display: block; font-size: .74rem; font-weight: 700; color: var(--ink); margin-bottom: 6px; }
    .sra-select-full {
        width: 100%; padding: .6rem .75rem; border: 1.5px solid var(--line); border-radius: 9px;
        font-size: .85rem; font-family: 'DM Sans', sans-serif; background: #fbfbfd; color: var(--ink);
    }
    .sra-select-full:focus { border-color: var(--gold); outline: none; }

    .sra-modal-actions { display: flex; gap: 10px; }
    .sra-btn-outline {
        flex: 1; padding: .65rem; border-radius: 9px; background: #fff; border: 1.5px solid var(--line);
        color: var(--ink); font-size: .82rem; font-weight: 600; cursor: pointer; transition: all .15s ease;
    }
    .sra-btn-outline:hover { background: #f8fafc; }
    .sra-btn-confirm {
        flex: 1; padding: .65rem; border-radius: 9px; background: var(--gold); border: none;
        color: #fff; font-size: .82rem; font-weight: 700; cursor: pointer; transition: background .15s ease;
    }
    .sra-btn-confirm:hover { background: #b84706; }
    .sra-btn-confirm.danger { background: var(--red); }
    .sra-btn-confirm.danger:hover { background: #a5311f; }
</style>

<div class="sra-page">

    <a href="{{ route('admin.service-requests.index') }}" class="sra-back-link">
        <i class="ti ti-arrow-left"></i> Back to Service Requests
    </a>

    @if (session('success'))
    <div class="sra-alert-success">
        <i class="ti ti-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    <div class="sra-detail-header">
        <div>
            <span class="sra-pill {{ $serviceRequest->status }}">
                <span class="sra-pill-dot"></span>
                {{ ucfirst($serviceRequest->status) }}
            </span>
            <h1 class="sra-detail-title">{{ $serviceRequest->service->title }}</h1>
            <p class="sra-detail-sub">
                Request #{{ $serviceRequest->id }} &middot; Submitted {{ $serviceRequest->created_at->format('d M Y, H:i') }}
            </p>
        </div>
        <div class="sra-detail-actions">
            @if ($serviceRequest->status === 'new')
                <button type="button" class="sra-btn-assign" onclick="openAssignModal()">
                    <i class="ti ti-user-plus"></i> Assign Consultant
                </button>
            @elseif ($serviceRequest->status === 'assigned')
                <button type="button" class="sra-btn-cancel-outline" onclick="openCancelModal()">
                    <i class="ti ti-x"></i> Cancel Assignment
                </button>
            @endif
        </div>
    </div>

    <div class="sra-detail-grid">

        {{-- Left column --}}
        <div>
            <div class="sra-detail-card">
                <h5>Client Information</h5>
                <dl class="sra-dl">
                    <div class="sra-dl-row">
                        <dt>Full name</dt>
                        <dd>{{ $serviceRequest->full_name }}</dd>
                    </div>
                    <div class="sra-dl-row">
                        <dt>Phone</dt>
                        <dd>{{ $serviceRequest->phone }}</dd>
                    </div>
                    <div class="sra-dl-row">
                        <dt>Email</dt>
                        <dd class="{{ $serviceRequest->email ? '' : 'muted' }}">
                            {{ $serviceRequest->email ?: 'Not provided' }}
                        </dd>
                    </div>
                    <div class="sra-dl-row">
                        <dt>Location</dt>
                        <dd class="{{ $serviceRequest->location ? '' : 'muted' }}">
                            {{ $serviceRequest->location ?: 'Not provided' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="sra-detail-card">
                <h5>Request Message</h5>
                <div class="sra-message-box">
                    {{ $serviceRequest->message ?: 'No additional message provided.' }}
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div>
            <div class="sra-detail-card">
                <h5>Service & Timing</h5>
                <dl class="sra-dl">
                    <div class="sra-dl-row">
                        <dt>Service</dt>
                        <dd>{{ $serviceRequest->service->title }}</dd>
                    </div>
                    <div class="sra-dl-row">
                        <dt>Preferred date</dt>
                        <dd class="{{ $serviceRequest->preferred_date ? '' : 'muted' }}">
                            {{ $serviceRequest->preferred_date?->format('d M Y') ?? 'Not specified' }}
                        </dd>
                    </div>
                    <div class="sra-dl-row">
                        <dt>Preferred time</dt>
                        <dd class="{{ $serviceRequest->preferred_time ? '' : 'muted' }}">
                            {{ $serviceRequest->preferred_time ?? 'Not specified' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="sra-detail-card">
                <h5>Consultant Assignment</h5>

                @if ($serviceRequest->consultant)
                    @php $consultantName = $serviceRequest->consultant->user->name ?? $serviceRequest->consultant->name; @endphp
                    <div class="sra-consultant-block">
                        <div class="sra-consultant-avatar">{{ strtoupper(substr($consultantName, 0, 1)) }}</div>
                        <div>
                            <div class="sra-consultant-name">{{ $consultantName }}</div>
                            <div class="sra-consultant-sub">Assigned consultant</div>
                        </div>
                    </div>
                @else
                    <div class="sra-unassigned-box">
                        No consultant assigned yet.
                    </div>
                @endif

                @if ($serviceRequest->report)
                    <div class="sra-report-badge">
                        <i class="ti ti-file-check"></i> Consultant report submitted
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ── Assign Modal ── --}}
<div class="sra-modal-overlay" id="sraAssignOverlay" onclick="if(event.target===this) closeAssignModal()">
    <div class="sra-modal">
        <div class="sra-modal-header">
            <div>
                <span class="sra-modal-eyebrow">Confirm Assignment</span>
                <h3 class="sra-modal-title">Assign a consultant</h3>
            </div>
            <button type="button" class="sra-modal-close" onclick="closeAssignModal()">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="sra-modal-body">
            <p class="sra-modal-desc">
                Assigning <strong>{{ $serviceRequest->full_name }}</strong>'s request for
                <strong>{{ $serviceRequest->service->title }}</strong> to a consultant.
            </p>

            <form method="POST" action="{{ route('admin.service-requests.assign', $serviceRequest->id) }}">
                @csrf
                <div class="sra-field">
                    <label for="sraAssignSelect">Consultant</label>
                    <select name="consultant_id" id="sraAssignSelect" class="sra-select-full" required>
                        <option value="">Select consultant...</option>
                        @foreach ($consultants as $consultant)
                            <option value="{{ $consultant->id }}">
                                {{ $consultant->user->name ?? $consultant->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sra-modal-actions">
                    <button type="button" class="sra-btn-outline" onclick="closeAssignModal()">Cancel</button>
                    <button type="submit" class="sra-btn-confirm">Confirm Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── Cancel Modal ── --}}
<div class="sra-modal-overlay" id="sraCancelOverlay" onclick="if(event.target===this) closeCancelModal()">
    <div class="sra-modal">
        <div class="sra-modal-header">
            <div>
                <span class="sra-modal-eyebrow">Confirm Cancellation</span>
                <h3 class="sra-modal-title">Cancel this assignment?</h3>
            </div>
            <button type="button" class="sra-modal-close" onclick="closeCancelModal()">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="sra-modal-body">
            <p class="sra-modal-desc">
                This will cancel <strong>{{ $serviceRequest->full_name }}</strong>'s assigned request for
                <strong>{{ $serviceRequest->service->title }}</strong>. This action can't be undone from here.
            </p>

            <form method="POST" action="{{ route('admin.service-requests.cancel', $serviceRequest->id) }}">
                @csrf
                <div class="sra-modal-actions">
                    <button type="button" class="sra-btn-outline" onclick="closeCancelModal()">Keep Assignment</button>
                    <button type="submit" class="sra-btn-confirm danger">Cancel Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAssignModal() {
        document.getElementById('sraAssignOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeAssignModal() {
        document.getElementById('sraAssignOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    function openCancelModal() {
        document.getElementById('sraCancelOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeCancelModal() {
        document.getElementById('sraCancelOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { closeAssignModal(); closeCancelModal(); }
    });
</script>

@endsection
