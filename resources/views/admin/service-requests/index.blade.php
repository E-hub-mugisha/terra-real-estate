{{-- resources/views/admin/service-requests/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Service Requests')
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
        font-family: 'DM Sans', sans-serif;
        color: var(--ink);
        max-width: 1180px;
        margin: 0 auto;
        padding: 1.75rem 0 3rem;
    }

    .sra-heading { display: flex; align-items: center; gap: .8rem; margin-bottom: 1.5rem; }
    .sra-heading-icon {
        width: 46px; height: 46px; border-radius: 12px;
        background: linear-gradient(135deg, var(--navy), var(--navy-dark));
        color: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }
    .sra-heading h4 { font-family: 'Cormorant Garamond', serif; font-weight: 700; font-size: 1.5rem; margin: 0; color: var(--navy); }
    .sra-heading p { font-size: .82rem; color: var(--muted); margin: .1rem 0 0; }

    .sra-alert-success {
        background: #eafaf1; border: 1px solid #b9e9cd; color: #146c43;
        border-radius: 12px; padding: .85rem 1.1rem; margin-bottom: 1.25rem; font-size: .88rem;
        display: flex; align-items: center; gap: .5rem;
    }

    .sra-card { background: #fff; border: 1px solid var(--line); border-radius: 14px; overflow: hidden; }

    .sra-table { width: 100%; border-collapse: collapse; font-size: .84rem; }
    .sra-table thead th {
        text-align: left; padding: .8rem 1.25rem; font-size: .7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .03em; color: var(--muted);
        background: #f8fafc; border-bottom: 1px solid var(--line); white-space: nowrap;
    }
    .sra-table tbody td { padding: .9rem 1.25rem; border-bottom: 1px solid var(--line); vertical-align: middle; }
    .sra-table tbody tr:last-child td { border-bottom: none; }
    .sra-table tbody tr:hover { background: #fffaf5; }

    .sra-client-sub { font-size: .74rem; color: var(--muted); }

    .sra-pill {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .3rem .75rem; border-radius: 20px; font-size: .72rem; font-weight: 600;
    }
    .sra-pill.new       { background: var(--gold-light); color: #8a4306; border: 1px solid #f0d3b8; }
    .sra-pill.assigned  { background: #eef0f8; color: var(--navy); border: 1px solid #d3d8ee; }
    .sra-pill.completed { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .sra-pill.cancelled { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .sra-pill-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    .sra-actions { display: flex; align-items: center; gap: .4rem; }

    .sra-btn-icon {
        width: 32px; height: 32px; border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        background: #f8fafc; border: 1px solid var(--line); color: var(--navy);
        font-size: .9rem; transition: all .15s ease; flex-shrink: 0;
    }
    .sra-btn-icon:hover { background: var(--navy); color: #fff; border-color: var(--navy); }

    .sra-btn-assign {
        background: var(--gold); color: #fff; border: none; border-radius: 8px;
        padding: .42rem .9rem; font-size: .78rem; font-weight: 600; white-space: nowrap;
        transition: background .15s ease; cursor: pointer;
    }
    .sra-btn-assign:hover { background: #b84706; color: #fff; }

    .sra-btn-cancel {
        background: #fff; color: var(--muted); border: 1px solid var(--line); border-radius: 8px;
        padding: .42rem .9rem; font-size: .78rem; font-weight: 600; white-space: nowrap;
        transition: all .15s ease; cursor: pointer;
    }
    .sra-btn-cancel:hover { background: var(--red-bg); color: var(--red); border-color: #f2c6c0; }

    .sra-consultant-name { font-weight: 600; font-size: .84rem; }
    .sra-empty { text-align: center; color: var(--muted); padding: 3rem 1rem; font-size: .88rem; }

    /* ── Modal ── */
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

    <div class="sra-heading">
        <div class="sra-heading-icon"><i class="ti ti-clipboard-list"></i></div>
        <div>
            <h4>Service Requests</h4>
            <p>Review incoming client requests and assign them to a consultant.</p>
        </div>
    </div>

    @if (session('success'))
    <div class="sra-alert-success">
        <i class="ti ti-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    <div class="sra-card">
        <div class="table-responsive">
            <table class="sra-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Preferred Date/Time</th>
                        <th>Status</th>
                        <th>Consultant</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($requests as $req)
                    <tr>
                        <td>
                            {{ $req->full_name }}
                            <div class="sra-client-sub">{{ $req->phone }} &middot; {{ $req->location }}</div>
                        </td>
                        <td>{{ $req->service->title }}</td>
                        <td>
                            {{ $req->preferred_date?->format('d M Y') ?? '—' }}
                            <div class="sra-client-sub">{{ $req->preferred_time ?? '' }}</div>
                        </td>
                        <td>
                            <span class="sra-pill {{ $req->status }}">
                                <span class="sra-pill-dot"></span>
                                {{ ucfirst($req->status) }}
                            </span>
                        </td>
                        <td>
                            @if ($req->consultant)
                                <span class="sra-consultant-name">{{ $req->consultant->user->name ?? $req->consultant->name }}</span>
                            @else
                                <span class="sra-client-sub">Unassigned</span>
                            @endif
                        </td>
                        <td>
                            <div class="sra-actions">
                                <a href="{{ route('admin.service-requests.show', $req->id) }}" class="btn sra-btn-icon" title="View details">
                                    <i class="ti ti-eye"></i>View
                                </a>

                                @if ($req->status === 'new')
                                    <button type="button" class="sra-btn-assign"
                                        onclick="openAssignModal({{ $req->id }}, '{{ addslashes($req->full_name) }}', '{{ addslashes($req->service->title) }}')">
                                        Assign
                                    </button>
                                @elseif ($req->status === 'assigned')
                                    <button type="button" class="sra-btn-cancel"
                                        onclick="openCancelModal({{ $req->id }}, '{{ addslashes($req->full_name) }}', '{{ addslashes($req->service->title) }}')">
                                        Cancel
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="sra-empty">No service requests yet.</div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
        <div class="p-3 border-top">
            {{ $requests->links() }}
        </div>
        @endif
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
                Assigning <strong id="sraAssignClient">—</strong>'s request for
                <strong id="sraAssignService">—</strong> to a consultant.
            </p>

            <form method="POST" id="sraAssignForm">
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
                This will cancel <strong id="sraCancelClient">—</strong>'s assigned request for
                <strong id="sraCancelService">—</strong>. This action can't be undone from here.
            </p>

            <form method="POST" id="sraCancelForm">
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
    // Route templates — the value in place of the id is replaced at runtime.
    const SRA_ASSIGN_URL_TEMPLATE = "{{ route('admin.service-requests.assign', ['__ID__']) }}";
    const SRA_CANCEL_URL_TEMPLATE = "{{ route('admin.service-requests.cancel', ['__ID__']) }}";

    function openAssignModal(id, clientName, serviceName) {
        document.getElementById('sraAssignClient').textContent = clientName;
        document.getElementById('sraAssignService').textContent = serviceName;
        document.getElementById('sraAssignSelect').value = '';
        document.getElementById('sraAssignForm').action = SRA_ASSIGN_URL_TEMPLATE.replace('__ID__', id);
        document.getElementById('sraAssignOverlay').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    function closeAssignModal() {
        document.getElementById('sraAssignOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }

    function openCancelModal(id, clientName, serviceName) {
        document.getElementById('sraCancelClient').textContent = clientName;
        document.getElementById('sraCancelService').textContent = serviceName;
        document.getElementById('sraCancelForm').action = SRA_CANCEL_URL_TEMPLATE.replace('__ID__', id);
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