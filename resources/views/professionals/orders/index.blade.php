@extends('layouts.professional')

@section('title', 'Orders & Inquiries — Terra Professional')
@section('page_title', 'Orders & Inquiries')

@section('content')
<div class="page-header">
    <div>
        <h1>Orders & Inquiries</h1>
        <p>Manage user inquiries about your architectural designs</p>
    </div>
</div>

{{-- Status Tabs --}}
<div class="tabs">
    @php $currentStatus = request('status', ''); @endphp
    <a href="{{ route('professional.orders.index') }}" class="tab {{ $currentStatus === '' ? 'active' : '' }}">
        All <span style="background:var(--border);color:var(--muted);padding:2px 8px;border-radius:20px;font-size:11px;margin-left:4px">{{ $statusCounts['all'] }}</span>
    </a>
    <a href="{{ route('professional.orders.index', ['status' => 'pending']) }}" class="tab {{ $currentStatus === 'pending' ? 'active' : '' }}">
        Pending <span style="background:var(--warning-bg);color:var(--warning);padding:2px 8px;border-radius:20px;font-size:11px;margin-left:4px">{{ $statusCounts['pending'] }}</span>
    </a>
    <a href="{{ route('professional.orders.index', ['status' => 'in_progress']) }}" class="tab {{ $currentStatus === 'in_progress' ? 'active' : '' }}">
        In Progress <span style="background:var(--info-bg);color:var(--info);padding:2px 8px;border-radius:20px;font-size:11px;margin-left:4px">{{ $statusCounts['in_progress'] }}</span>
    </a>
    <a href="{{ route('professional.orders.index', ['status' => 'completed']) }}" class="tab {{ $currentStatus === 'completed' ? 'active' : '' }}">
        Completed <span style="background:var(--success-bg);color:var(--success);padding:2px 8px;border-radius:20px;font-size:11px;margin-left:4px">{{ $statusCounts['completed'] }}</span>
    </a>
    <a href="{{ route('professional.orders.index', ['status' => 'cancelled']) }}" class="tab {{ $currentStatus === 'cancelled' ? 'active' : '' }}">
        Cancelled
    </a>
</div>

{{-- Search --}}
<form method="GET" class="filter-bar">
    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
    <input type="text" name="search" placeholder="Search by client or design…" value="{{ request('search') }}">
    <button type="submit" class="btn-navy" style="padding:10px 18px;font-size:14px;">Search</button>
    @if(request('search'))
        <a href="{{ route('professional.orders.index', array_filter(['status' => request('status')])) }}" class="btn-outline">Clear</a>
    @endif
    <span style="margin-left:auto;font-size:13px;color:var(--muted)">{{ $orders->total() }} order{{ $orders->total() !== 1 ? 's' : '' }}</span>
</form>

{{-- Table --}}
<div class="panel">
    @if($orders->isEmpty())
    <div class="empty-state">
        <div class="empty-state-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
        </div>
        <h3>No orders found</h3>
        <p>{{ request('status') ? 'No orders with this status.' : 'When users inquire about your designs, they\'ll appear here.' }}</p>
    </div>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Design</th>
                    <th>Message</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td style="color:var(--muted);font-size:13px">#{{ $order->id }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="order-avatar" style="width:32px;height:32px;font-size:11px">{{ strtoupper(substr($order->user->name ?? 'U', 0, 2)) }}</div>
                            <div>
                                <div style="font-weight:500;font-size:14px">{{ $order->user->name ?? '—' }}</div>
                                <div style="font-size:12px;color:var(--muted)">{{ $order->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:14px;font-weight:500;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ $order->design->title ?? 'Design removed' }}
                        </div>
                        <div style="font-size:12px;color:var(--muted)">{{ $order->design->category ?? '' }}</div>
                    </td>
                    <td style="max-width:200px">
                        <p style="font-size:13px;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ Str::limit($order->message, 60) ?? '—' }}
                        </p>
                    </td>
                    <td style="font-weight:600;font-size:14px">
                        @if($order->amount)
                            {{ number_format($order->amount) }} {{ $order->currency }}
                        @else
                            <span style="color:var(--muted)">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ $order->status }}">{{ $order->status_label }}</span>
                    </td>
                    <td style="font-size:13px;color:var(--muted);white-space:nowrap">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('professional.orders.show', $order) }}" class="btn-outline" style="padding:6px 14px;font-size:13px">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">{{ $orders->appends(request()->query())->links() }}</div>
    @endif
</div>
@endsection
