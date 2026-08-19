@extends('layouts.app')
@section('title', $shop->name . ' - Shop Details')
@section('content')

<div class="shop-show">

    <nav class="small mb-3 breadcrumb-nav">
        <a href="{{ route('admin.shops.index') }}" class="text-decoration-none">Shops</a>
        <span class="mx-1">/</span>
        <span class="fw-medium current-crumb">{{ $shop->name }}</span>
    </nav>

    {{-- Cover + header --}}
    <div class="shop-header-card mb-4">
        <div class="shop-cover">
            @if ($shop->cover_image)
            <img src="{{ asset('image/shops/covers/' . $shop->cover_image) }}" alt="{{ $shop->name }} cover">
            @endif
        </div>

        <div class="shop-header-body">
            <div class="d-flex align-items-start gap-3 flex-wrap">
                <div class="shop-logo">
                    @if ($shop->logo)
                    <img src="{{ asset('image/shops/logos/' . $shop->logo) }}" alt="{{ $shop->name }}">
                    @else
                    <span>{{ Str::substr($shop->name, 0, 1) }}</span>
                    @endif
                </div>

                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <h1 class="fw-bold mb-0 shop-title">{{ $shop->name }}</h1>
                        <span @class([ 'badge status-badge' , 'status-approved'=> $shop->status === 'approved',
                            'status-pending' => $shop->status === 'pending',
                            'status-rejected' => $shop->status === 'rejected',
                            'status-suspended' => $shop->status === 'suspended',
                            ])>
                            {{ ucfirst($shop->status) }}
                        </span>
                        @if ($shop->is_featured)
                        <span class="badge featured-badge">Featured</span>
                        @endif
                    </div>
                    <p class="text-muted mb-0 small">{{ $shop->slug }}</p>
                </div>

                {{-- Status actions --}}
                <div class="d-flex gap-2 flex-wrap action-buttons">
                    @if ($shop->status !== 'approved')
                    <form method="POST" action="{{ route('admin.shops.approve', $shop->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm approve-btn fw-medium">Approve</button>
                    </form>
                    @endif

                    @if ($shop->status !== 'rejected')
                    <button type="button" class="btn btn-sm reject-btn fw-medium" data-bs-toggle="modal" data-bs-target="#rejectShopModal">
                        Reject
                    </button>
                    @endif

                    @if ($shop->status !== 'suspended')
                    <form method="POST" action="{{ route('admin.shops.suspend', $shop->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm suspend-btn fw-medium">Suspend</button>
                    </form>
                    @endif

                    <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn btn-sm edit-btn fw-medium">Edit</a>
                </div>
            </div>

            @if ($shop->status === 'rejected' && $shop->rejection_reason)
            <div class="rejection-note mt-3">
                <strong>Rejection reason:</strong> {{ $shop->rejection_reason }}
            </div>
            @endif
        </div>
    </div>

    <div class="row g-4 mb-4">
        {{-- Details --}}
        <div class="col-lg-8">
            <div class="detail-card h-100">
                <h2 class="section-label mb-3">Shop Details</h2>

                @if ($shop->description)
                <p class="text-muted mb-4" style="line-height:1.7;">{{ $shop->description }}</p>
                @endif

                <div class="row g-3">
                    <div class="col-sm-6">
                        <span class="field-label">Phone</span>
                        <p class="field-value">{{ $shop->phone ?: '—' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="field-label">WhatsApp</span>
                        <p class="field-value">{{ $shop->whatsapp_number ?: '—' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="field-label">Email</span>
                        <p class="field-value">{{ $shop->email ?: '—' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="field-label">Owner</span>
                        <p class="field-value">{{ $shop->user->name ?? '—' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="field-label">Address</span>
                        <p class="field-value">{{ $shop->address ?: '—' }}</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="field-label">Location</span>
                        <p class="field-value">
                            {{ collect([$shop->sector, $shop->district, $shop->province])->filter()->implode(', ') ?: '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Meta --}}
        <div class="col-lg-4">
            <div class="detail-card h-100">
                <h2 class="section-label mb-3">Activity</h2>

                <div class="d-flex justify-content-between align-items-center mb-3 meta-row">
                    <span class="field-label mb-0">Views</span>
                    <span class="fw-semibold">{{ number_format($shop->views_count) }}</span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3 meta-row">
                    <span class="field-label mb-0">Registered</span>
                    <span class="fw-semibold">{{ $shop->created_at->format('M j, Y') }}</span>
                </div>

                @if ($shop->approved_at)
                <div class="d-flex justify-content-between align-items-center mb-3 meta-row">
                    <span class="field-label mb-0">Approved</span>
                    <span class="fw-semibold">{{ $shop->approved_at->format('M j, Y') }}</span>
                </div>
                @endif

                @if ($shop->approvedBy)
                <div class="d-flex justify-content-between align-items-center meta-row">
                    <span class="field-label mb-0">Approved by</span>
                    <span class="fw-semibold">{{ $shop->approvedBy->name }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Products --}}
    <div class="d-flex justify-content-between align-items-end gap-3 mb-3">
        <h2 class="section-heading mb-0">Products</h2>
        <span class="text-muted small">{{ $products->total() }} {{ Str::plural('product', $products->total()) }}</span>
    </div>

    <div class="table-card">
        @if ($products->isEmpty())
        <div class="text-center py-5 text-muted">
            This shop has not listed any products yet.
        </div>
        @else
        <div class="table-responsive">
            <table class="table align-middle mb-0 products-table">
                <thead>
                    <tr>
                        <th style="width:64px;"></th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-center">Featured</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    @php($img = $product->primaryImage())
                    <tr>
                        <td>
                            <div class="product-thumb">
                                @if ($img)
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $product->title }}">
                                @endif
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.materials-products.show', $product->id) }}" class="fw-medium product-name-link text-decoration-none">
                                {{ $product->title }}
                            </a>
                        </td>
                        <td class="small text-muted">
                            {{ $product->category->name ?? '—' }}
                            @if ($product->subcategory)
                            <div class="text-muted" style="font-size:.72rem;">{{ $product->subcategory->name }}</div>
                            @endif
                        </td>
                        <td class="small">
                            @if ($product->price)
                            <span class="fw-semibold product-price">{{ $product->currency }} {{ number_format($product->price) }}</span>
                            @if ($product->unit)<span class="text-muted"> / {{ $product->unit }}</span>@endif
                            @else
                            <span class="text-muted">On request</span>
                            @endif
                        </td>
                        <td>
                            <span @class([ 'badge stock-badge' , 'stock-in'=> $product->stock_status === 'in_stock',
                                'stock-out' => $product->stock_status === 'out_of_stock',
                                'stock-made' => $product->stock_status === 'made_to_order',
                                ])>
                                {{ str_replace('_', ' ', ucfirst($product->stock_status)) }}
                            </span>
                        </td>
                        <td>
                            <span @class([ 'badge status-badge-sm' , 'status-approved'=> $product->status === 'approved',
                                'status-pending' => $product->status === 'pending',
                                'status-rejected' => $product->status === 'rejected',
                                ])>
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if ($product->is_featured)
                            <svg viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px;color:#D05208">
                                <path d="M12 2l2.9 6.6 7.1.6-5.4 4.7 1.7 7-6.3-3.8L5.7 21l1.7-7-5.4-4.7 7.1-.6z"/>
                            </svg>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.materials-products.show', $product->id) }}" class="btn btn-sm view-btn">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-3 pagination-wrap">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Reject modal --}}
<div class="modal fade" id="rejectShopModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content reject-modal">
            <form method="POST" action="{{ route('admin.shops.reject', $shop->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Reject {{ $shop->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="rejection_reason" class="form-label advice-label">Reason for rejection</label>
                    <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4" required
                        placeholder="Explain why this shop is being rejected — shown to the owner."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm clear-btn" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm reject-btn fw-medium">Reject Shop</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --navy-dark: #111a45;
        --navy: #19265d;
        --gold: #D05208;
        --gold-light: #fff3e9;
        --font-heading: 'Cormorant Garamond', serif;
        --font-body: 'DM Sans', sans-serif;
    }

    .shop-show {
        font-family: var(--font-body);
        color: var(--navy-dark);
    }

    .breadcrumb-nav {
        color: #6b7280;
    }

    .breadcrumb-nav a {
        color: #6b7280;
        transition: color .15s ease;
    }

    .breadcrumb-nav a:hover {
        color: var(--gold);
    }

    .current-crumb {
        color: var(--navy-dark);
    }

    /* Header card */
    .shop-header-card {
        background: #fff;
        border: 1px solid #eef0f5;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(17, 26, 69, .06);
    }

    .shop-cover {
        height: 160px;
        background-color: var(--gold-light);
    }

    .shop-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .shop-header-body {
        padding: 1.5rem;
        margin-top: -48px;
    }

    .shop-logo {
        width: 88px;
        height: 88px;
        border-radius: 14px;
        overflow: hidden;
        background-color: var(--gold-light);
        color: var(--gold);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.8rem;
        border: 4px solid #fff;
        box-shadow: 0 4px 16px rgba(17, 26, 69, .1);
        flex-shrink: 0;
    }

    .shop-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .shop-title {
        font-family: var(--font-heading);
        color: var(--navy-dark);
        font-size: 1.8rem;
    }

    .action-buttons {
        margin-left: auto;
        margin-top: 48px;
    }

    /* Badges */
    .status-badge, .status-badge-sm {
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .status-badge {
        font-size: .72rem;
        padding: .35rem .7rem;
    }

    .status-badge-sm {
        font-size: .68rem;
        padding: .25rem .55rem;
    }

    .status-approved { background-color: #ecfdf3; color: #15803d; }
    .status-pending { background-color: #fffbeb; color: #b45309; }
    .status-rejected { background-color: #fef2f2; color: #b91c1c; }
    .status-suspended { background-color: #f3f4f6; color: #4b5563; }

    .featured-badge {
        background-color: var(--navy-dark);
        color: #fff;
        border-radius: 20px;
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .03em;
        padding: .35rem .7rem;
    }

    .rejection-note {
        background-color: #fef2f2;
        color: #b91c1c;
        border-radius: 8px;
        padding: .7rem 1rem;
        font-size: .85rem;
    }

    /* Action buttons */
    .approve-btn {
        background-color: #ecfdf3;
        color: #15803d;
        border: none;
        border-radius: 8px;
        padding: .4rem .9rem;
    }
    .approve-btn:hover { background-color: #15803d; color: #fff; }

    .reject-btn {
        background-color: #fef2f2;
        color: #b91c1c;
        border: none;
        border-radius: 8px;
        padding: .4rem .9rem;
    }
    .reject-btn:hover { background-color: #b91c1c; color: #fff; }

    .suspend-btn {
        background-color: #f3f4f6;
        color: #4b5563;
        border: none;
        border-radius: 8px;
        padding: .4rem .9rem;
    }
    .suspend-btn:hover { background-color: #4b5563; color: #fff; }

    .edit-btn {
        background-color: #fff;
        color: var(--navy);
        border: 1px solid var(--navy);
        border-radius: 8px;
        padding: .4rem .9rem;
    }
    .edit-btn:hover { background-color: var(--navy); color: #fff; }

    /* Detail cards */
    .detail-card {
        background: #fff;
        border: 1px solid #eef0f5;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 6px 24px rgba(17, 26, 69, .06);
    }

    .section-label {
        font-family: var(--font-heading);
        font-size: 1.2rem;
        color: var(--navy);
    }

    .section-heading {
        font-family: var(--font-heading);
        color: var(--navy-dark);
        font-size: 1.5rem;
    }

    .field-label {
        display: block;
        font-size: .7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #9ca3af;
        margin-bottom: .2rem;
    }

    .field-value {
        margin: 0;
        font-size: .9rem;
        color: var(--navy-dark);
    }

    .meta-row {
        border-bottom: 1px solid #f3f4f8;
        padding-bottom: .6rem;
    }

    /* Products table */
    .table-card {
        background: #fff;
        border: 1px solid #eef0f5;
        border-radius: 14px;
        box-shadow: 0 6px 24px rgba(17, 26, 69, .06);
        overflow: hidden;
    }

    .products-table thead th {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #6b7280;
        border-bottom: 1px solid #eef0f5;
        padding: .9rem 1rem;
        background-color: #fafbfd;
    }

    .products-table tbody td {
        padding: .8rem 1rem;
        border-bottom: 1px solid #f3f4f8;
        vertical-align: middle;
    }

    .products-table tbody tr:last-child td {
        border-bottom: none;
    }

    .products-table tbody tr:hover {
        background-color: #fafbfd;
    }

    .product-thumb {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        overflow: hidden;
        background-color: #f3f4f8;
    }

    .product-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-name-link {
        color: var(--navy-dark);
    }

    .product-name-link:hover {
        color: var(--gold);
    }

    .product-price {
        color: var(--gold);
    }

    .stock-badge {
        border-radius: 20px;
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        padding: .3rem .6rem;
    }

    .stock-in { background-color: #ecfdf3; color: #15803d; }
    .stock-out { background-color: #fef2f2; color: #b91c1c; }
    .stock-made { background-color: #eef2ff; color: var(--navy); }

    .view-btn {
        background-color: var(--gold-light);
        color: var(--gold);
        border: none;
        border-radius: 8px;
        font-size: .78rem;
        font-weight: 600;
        padding: .4rem .8rem;
        transition: background-color .15s ease, color .15s ease;
    }

    .view-btn:hover {
        background-color: var(--gold);
        color: #fff;
    }

    .pagination-wrap .page-link {
        color: var(--navy);
        border-color: #eef0f5;
    }

    .pagination-wrap .page-link:hover {
        color: var(--gold);
        background-color: var(--gold-light);
    }

    .pagination-wrap .page-item.active .page-link {
        background-color: var(--gold);
        border-color: var(--gold);
    }

    .reject-modal .modal-header,
    .reject-modal .modal-footer {
        border-color: #eef0f5;
    }

    .clear-btn {
        background-color: #fff;
        color: #6b7280;
        border: 1px solid #e2e5ee;
        border-radius: 8px;
        padding: .4rem .9rem;
    }
</style>

@once
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@endonce

@endsection
