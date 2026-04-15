@extends('layouts.professional')

@section('title', 'Order #' . $order->id . ' — Terra Professional')
@section('page_title', 'Order #' . $order->id)

@section('content')
<div class="page-header">
    <div>
        <h1>Order #{{ $order->id }}</h1>
        <p>Inquiry from {{ $order->user->name ?? 'Unknown' }} · {{ $order->created_at->format('d M Y, H:i') }}</p>
    </div>
    <a href="{{ route('professional.orders.index') }}" class="btn-outline">← Back to Orders</a>
</div>

<div class="order-detail-grid">

    {{-- Left column: order details --}}
    <div style="display:flex;flex-direction:column;gap:20px">

        {{-- Client & Design --}}
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Client Information
                </h2>
            </div>
            <div class="panel-body">
                <div class="detail-row">
                    <span class="detail-label">Name</span>
                    <span class="detail-value">{{ $order->user->name ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email</span>
                    <span class="detail-value">{{ $order->user->email ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone</span>
                    <span class="detail-value">{{ $order->phone ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Submitted</span>
                    <span class="detail-value">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Design info --}}
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Design
                </h2>
                <a href="{{ route('professional.designs.show', $order->design) }}" class="panel-link">View Design →</a>
            </div>
            <div class="panel-body" style="display:flex;gap:14px;align-items:flex-start">
                <div style="width:90px;height:65px;flex-shrink:0;border-radius:8px;overflow:hidden;background:var(--surface)">
                    @if($order->design->cover_image)
                    <img src="{{ asset($order->design->cover_image) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                    @endif
                </div>
                <div>
                    <div style="font-weight:600;color:var(--navy);font-size:15px;margin-bottom:4px">{{ $order->design->title ?? '—' }}</div>
                    <div style="font-size:13px;color:var(--muted)">{{ $order->design->category ?? '' }} · {{ $order->design->style ?? '' }}</div>
                    <div style="font-size:14px;font-weight:700;color:var(--gold);margin-top:6px">{{ $order->design->formatted_price ?? '' }}</div>
                </div>
            </div>
        </div>

        {{-- Message & Requirements --}}
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                    Client Message
                </h2>
            </div>
            <div class="panel-body">
                @if($order->message)
                    <p style="font-size:14px;line-height:1.7;color:var(--text)">{{ $order->message }}</p>
                @else
                    <p style="font-size:14px;color:var(--muted)">No message provided.</p>
                @endif

                @if($order->requirements)
                    <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--border)">
                        <div style="font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);margin-bottom:8px">Project Requirements</div>
                        <p style="font-size:14px;line-height:1.7">{{ $order->requirements }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right column: status management --}}
    <div style="display:flex;flex-direction:column;gap:20px">

        {{-- Current Status --}}
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">Order Status</h2>
                <span class="status-badge status-{{ $order->status }}">{{ $order->status_label }}</span>
            </div>
            <div class="panel-body">
                @if($order->status_note)
                    <div style="background:var(--surface);border-radius:8px;padding:12px;font-size:13px;color:var(--text);margin-bottom:16px;border-left:3px solid var(--gold)">
                        <strong>Last note:</strong> {{ $order->status_note }}
                    </div>
                @endif

                {{-- Status Update Form --}}
                @if($order->status !== 'completed' && $order->status !== 'cancelled')
                <form method="POST" action="{{ route('professional.orders.update-status', $order) }}">
                    @csrf @method('PATCH')

                    <div class="form-group" style="margin-bottom:14px">
                        <label>Update Status</label>
                        <select name="status">
                            @foreach(['pending'=>'Pending','in_progress'=>'In Progress','completed'=>'Completed','cancelled'=>'Cancelled'] as $val => $label)
                                <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom:16px">
                        <label>Note (optional)</label>
                        <textarea name="note" rows="3" placeholder="Add a note about this status change…"></textarea>
                    </div>

                    <button type="submit" class="btn-gold-lg" style="width:100%;justify-content:center">
                        Update Status
                    </button>
                </form>
                @else
                <p style="font-size:13px;color:var(--muted);text-align:center;padding:8px 0">This order is {{ $order->status }}.</p>
                @endif
            </div>
        </div>

        {{-- Amount --}}
        <div class="panel">
            <div class="panel-header">
                <h2 class="panel-title">Payment Info</h2>
            </div>
            <div class="panel-body">
                <div class="detail-row">
                    <span class="detail-label">Quoted Amount</span>
                    <span class="detail-value" style="color:var(--navy);font-weight:700;font-size:16px;font-family:var(--font-serif)">
                        @if($order->amount)
                            {{ number_format($order->amount) }} {{ $order->currency }}
                        @else
                            <span style="color:var(--muted);font-size:14px;font-family:var(--font-sans)">Not set</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
