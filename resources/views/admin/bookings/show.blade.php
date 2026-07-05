@extends('layouts.app')
@section('title', 'Booking ' . $booking->reference )

@section('content')

<style>
    :root {
        --accent: #00a667;
        --accent-light: #e6f7ef;
        --accent-dark: #007a4d;
        --ink: #1a1a1a;
        --muted: #6b7280;
        --border: #e5e7eb;
        --bg-soft: #f9fafb;
    }

    body { background: #f6f8f7; }

    .pill {
        display: inline-block;
        font-size: 12px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .pill-success { background: var(--accent-light); color: var(--accent-dark); }
    .pill-warning { background: #fef9c3; color: #854d0e; }
    .pill-danger  { background: #fee2e2; color: #b91c1c; }

    .btn-back {
        border: 1px solid var(--border);
        color: var(--muted);
        background: #fff;
        border-radius: 8px;
        font-size: 13px;
    }
    .btn-back:hover { border-color: var(--accent); color: var(--accent-dark); background: var(--accent-light); }

    .alert-success {
        background: var(--accent-light);
        border: 1px solid #bbf0d9;
        color: var(--accent-dark);
        border-radius: 8px;
    }

    .detail-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
    }

    .detail-card-title {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #9ca3af;
        padding: 10px 16px;
        background: var(--bg-soft);
        border-bottom: 1px solid #f3f4f6;
    }

    .drow {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 16px;
        font-size: 14px;
        border-bottom: 1px solid #f9fafb;
        gap: 8px;
        color: var(--ink);
    }
    .drow:last-child { border-bottom: none; }
    .drow span:first-child { color: var(--muted); flex-shrink: 0; }
    .drow a { color: var(--accent-dark); text-decoration: none; }
    .drow a:hover { text-decoration: underline; }

    .action-card {
        border-radius: 10px;
        padding: 16px;
        border: 1px solid;
    }
    .action-card h6 { font-weight: 600; margin-bottom: 6px; }
    .action-card p { font-size: 13px; color: var(--muted); margin-bottom: 12px; }

    .confirm-card { border-color: #bbf0d9; background: var(--accent-light); }
    .confirm-card h6 { color: var(--accent-dark); }

    .reject-card { border-color: #fecaca; background: #fff5f5; }
    .reject-card h6 { color: #b91c1c; }

    .btn-confirm {
        background: var(--accent);
        color: #fff;
        border: none;
        border-radius: 8px;
    }
    .btn-confirm:hover { background: var(--accent-dark); color: #fff; }

    .btn-reject {
        border: 1px solid #f87171;
        color: #b91c1c;
        background: #fff;
        border-radius: 8px;
    }
    .btn-reject:hover { background: #fee2e2; }

    .btn-delete {
        border: 1px solid var(--border);
        color: #b91c1c;
        background: #fff;
        border-radius: 8px;
    }
    .btn-delete:hover { background: #fee2e2; border-color: #f87171; }

    textarea.form-control, input.form-control {
        border: 1px solid var(--border);
        border-radius: 8px;
    }
    textarea.form-control:focus, input.form-control:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-light);
    }
</style>

<div class="container py-4">

    <div class="d-flex align-items-center gap-3 mb-4 flex-wrap">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-back">← All Bookings</a>
        <h4 class="mb-0 fw-600">{{ $booking->reference }}</h4>
        @if($booking->status === 'pending')
        <span class="pill pill-warning">Pending</span>
        @elseif($booking->status === 'confirmed')
        <span class="pill pill-success">Confirmed</span>
        @elseif($booking->status === 'rejected')
        <span class="pill pill-danger">Rejected</span>
        @endif
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">

        {{-- Left: booking details --}}
        <div class="col-md-7">

            <div class="detail-card mb-4">
                <div class="detail-card-title">Service & Location</div>
                <div class="drow"><span>Service</span><strong>{{ $booking->service->title }}</strong></div>
                <div class="drow"><span>Province</span><strong>{{ $booking->province }}</strong></div>
                <div class="drow"><span>District</span><strong>{{ $booking->district }}</strong></div>
                <div class="drow"><span>Appointment date</span><strong>{{ $booking->appointment_date?->format('D, d M Y') ?? '—' }}</strong></div>
                @if($booking->notes)
                <div class="drow align-items-start">
                    <span>Client notes</span>
                    <strong style="max-width:280px;text-align:right;">{{ $booking->notes }}</strong>
                </div>
                @endif
            </div>

            <div class="detail-card mb-4">
                <div class="detail-card-title">Client</div>
                <div class="drow"><span>Name</span><strong>{{ $booking->client_name }}</strong></div>
                <div class="drow"><span>Email</span><a href="mailto:{{ $booking->client_email }}">{{ $booking->client_email }}</a></div>
                <div class="drow"><span>Phone</span><a href="tel:{{ $booking->client_phone }}">{{ $booking->client_phone }}</a></div>
            </div>

            <div class="detail-card mb-4">
                <div class="detail-card-title">Consultant</div>
                <div class="drow"><span>Name</span><strong>{{ $booking->consultant->name }}</strong></div>
                <div class="drow"><span>Email</span><a href="mailto:{{ $booking->consultant->email }}">{{ $booking->consultant->email }}</a></div>
                <div class="drow"><span>Phone</span><a href="tel:{{ $booking->consultant->phone }}">{{ $booking->consultant->phone }}</a></div>
                <div class="drow"><span>Specialty</span><strong>{{ $booking->consultant->specialty }}</strong></div>
            </div>

            <div class="detail-card">
                <div class="detail-card-title">Payment</div>
                <div class="drow"><span>Fee</span><strong>{{ number_format($booking->fee) }} RWF</strong></div>
                <div class="drow"><span>Method</span><strong>{{ strtoupper($booking->payment_method ?? '—') }}</strong></div>
                <div class="drow"><span>Reference</span><code>{{ $booking->payment_reference ?? '—' }}</code></div>
                <div class="drow">
                    <span>Status</span>
                    <span class="pill {{ $booking->payment_status === 'paid' ? 'pill-success' : 'pill-warning' }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                </div>
            </div>

        </div>

        {{-- Right: actions --}}
        <div class="col-md-5">

            {{-- Notifications sent --}}
            <div class="detail-card mb-4">
                <div class="detail-card-title">Notifications</div>
                <div class="drow">
                    <span>Client emailed</span>
                    <span style="color: {{ $booking->client_notified ? 'var(--accent-dark)' : 'var(--muted)' }};">
                        {{ $booking->client_notified ? '✓ Sent' : '✗ Not sent' }}
                    </span>
                </div>
                <div class="drow">
                    <span>Consultant emailed</span>
                    <span style="color: {{ $booking->consultant_notified ? 'var(--accent-dark)' : 'var(--muted)' }};">
                        {{ $booking->consultant_notified ? '✓ Sent' : '✗ Not sent' }}
                    </span>
                </div>
                @if($booking->confirmed_at)
                <div class="drow">
                    <span>Confirmed at</span>
                    <strong>{{ $booking->confirmed_at->format('d M Y, H:i') }}</strong>
                </div>
                @endif
                @if($booking->confirmedBy)
                <div class="drow">
                    <span>By</span>
                    <strong>{{ $booking->confirmedBy->name }}</strong>
                </div>
                @endif
                @if($booking->admin_note)
                <div class="drow align-items-start">
                    <span>Admin note</span>
                    <strong style="max-width:200px;text-align:right;">{{ $booking->admin_note }}</strong>
                </div>
                @endif
            </div>

            {{-- Confirm action --}}
            @if($booking->isPending())

            <div class="action-card confirm-card mb-3">
                <h6>✓ Confirm this booking</h6>
                <p>This will mark the booking as confirmed and send emails to both the client and the consultant with contact details.</p>
                <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}" onsubmit="return confirm('Confirm this booking and send emails?')">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="font-size:13px;">Admin note (optional)</label>
                        <textarea name="admin_note" class="form-control form-control-sm" rows="2"
                            placeholder="Internal note…"></textarea>
                    </div>
                    <button type="submit" class="btn btn-confirm w-100">
                        Confirm &amp; Send Emails
                    </button>
                </form>
            </div>

            <div class="action-card reject-card">
                <h6>✗ Reject this booking</h6>
                <p>Provide a reason. The client will not be notified automatically — you may do so manually.</p>
                <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}" onsubmit="return confirm('Reject this booking?')">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="font-size:13px;">Reason <span class="text-danger">*</span></label>
                        <textarea name="admin_note" class="form-control form-control-sm @error('admin_note') is-invalid @enderror"
                            rows="2" placeholder="Reason for rejection…" required></textarea>
                        @error('admin_note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-reject w-100">Reject Booking</button>
                </form>
            </div>

            @elseif($booking->status === 'confirmed')
            <div class="alert alert-success">
                This booking has been confirmed and emails have been sent.
            </div>
            @elseif($booking->status === 'rejected')
            <div class="alert" style="background:#fee2e2;border:1px solid #fecaca;color:#b91c1c;border-radius:8px;">
                This booking was rejected.
            </div>
            @endif

            <!-- delete modal button -->
            <button class="btn btn-sm btn-delete w-100 mt-3" data-bs-toggle="modal" data-bs-target="#deleteModal">
                Delete Booking
            </button>

            <!-- delete modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this booking? This action cannot be undone.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Booking</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection