@extends('layouts.shop')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>My Products</h3>
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-success">+ Add Product</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            @switch(session('status'))
                @case('product-created') Product created and sent for review. @break
                @case('product-updated') Product updated. @break
                @case('product-deleted') Product removed. @break
            @endswitch
        </div>
    @endif

    @if ($products->isEmpty())
        <div class="alert alert-light border">You haven't listed any products yet.</div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @if ($img = $product->primaryImage())
                                <img src="{{ asset('storage/' . $img->path) }}" width="56" height="56"
                                     class="rounded object-fit-cover" style="object-fit:cover;">
                            @else
                                <div class="bg-light rounded" style="width:56px;height:56px;"></div>
                            @endif
                        </td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->category->name ?? '—' }}</td>
                        <td>
                            {{ $product->price ? number_format($product->price) . ' ' . $product->currency : 'On request' }}
                        </td>
                        <td>
                            @php
                                $badge = ['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'][$product->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($product->status) }}</span>
                            @if ($product->status === 'rejected' && $product->rejection_reason)
                                <div class="small text-muted">{{ $product->rejection_reason }}</div>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('dashboard.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('dashboard.products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this product?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $products->links() }}
    @endif
</div>
@endsection