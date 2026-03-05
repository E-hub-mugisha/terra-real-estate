@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3>Property Plan Orders</h3>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Property</th>
                <th>User</th>
                <th>Plan</th>
                <th>Payment Status</th>
                <th>Approval</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->property_type }} #{{ $order->property_id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->plan->name }}</td>
                <td>
                    <span class="badge 
                        @if($order->payment?->status === 'success') bg-success 
                        @elseif($order->payment?->status === 'pending') bg-warning 
                        @else bg-danger 
                        @endif">
                        {{ $order->payment?->status ?? 'pending' }}
                    </span>
                </td>
                <td>
                    @if($order->is_approved)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-secondary">Pending</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                        View
                    </button>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Property Order #{{ $order->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Property Details</h6>
                            <p><strong>Type:</strong> {{ $order->property_type }}</p>
                            <p><strong>ID:</strong> {{ $order->property_id }}</p>
                            <p><strong>Title:</strong> {{ $order->property?->title ?? 'N/A' }}</p>
                            <p><strong>Description:</strong> {{ $order->property?->description ?? 'N/A' }}</p>
                            <p><strong>Owner:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>

                            <hr>
                            <h6>Payment Details</h6>
                            <p><strong>Status:</strong> {{ $order->payment?->status ?? 'pending' }}</p>
                            <p><strong>Amount:</strong> ${{ number_format($order->payment?->amount ?? 0,2) }}</p>
                            <p><strong>Transaction ID:</strong> {{ $order->payment?->transaction_id ?? 'N/A' }}</p>
                        </div>
                        <div class="modal-footer">
                            @if(!$order->is_approved && $order->payment?->status === 'success')
                            <form method="POST" action="{{ route('admin.property-plan-orders.approve', $order->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve Property</button>
                            </form>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>
@endsection