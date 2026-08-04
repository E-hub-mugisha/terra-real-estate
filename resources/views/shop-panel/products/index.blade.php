@extends('layouts.shop')
@section('page-title', 'My Products')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --terra-navy: #19265d;
        --terra-navy-deep: #121b45;
        --terra-navy-light: #2a3a82;
        --terra-orange: #D05208;
        --terra-orange-light: #ea6f1f;
        --terra-bg-soft: #f5f6fb;
        --terra-ink: #1c2340;
        --terra-muted: #6b7290;
        --terra-line: #eaebf4;
    }

    [data-h-scope="shop-products"] {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--terra-ink);
    }
    [data-h-scope="shop-products"] h1,
    [data-h-scope="shop-products"] h5,
    [data-h-scope="shop-products"] .h-heading {
        font-family: 'Sora', sans-serif;
    }

    /* ---------- Header ---------- */
    [data-h-scope="shop-products"] .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    [data-h-scope="shop-products"] .page-eyebrow {
        text-transform: uppercase;
        letter-spacing: .1em;
        font-size: .7rem;
        font-weight: 700;
        color: var(--terra-orange);
        margin-bottom: .2rem;
    }
    [data-h-scope="shop-products"] .page-title {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0;
    }
    [data-h-scope="shop-products"] .page-sub {
        color: var(--terra-muted);
        font-size: .85rem;
        margin-top: .15rem;
    }
    [data-h-scope="shop-products"] .btn-terra {
        background: var(--terra-navy);
        border-color: var(--terra-navy);
        color: #fff;
        font-weight: 600;
        border-radius: 10px;
        padding: .6rem 1.25rem;
        font-size: .87rem;
    }
    [data-h-scope="shop-products"] .btn-terra:hover {
        background: var(--terra-navy-light);
        border-color: var(--terra-navy-light);
        color: #fff;
    }
    [data-h-scope="shop-products"] .btn-terra-outline {
        background: #fff;
        border: 1px solid var(--terra-line);
        color: var(--terra-navy);
        font-weight: 600;
        border-radius: 10px;
        font-size: .87rem;
    }
    [data-h-scope="shop-products"] .btn-terra-outline:hover {
        border-color: var(--terra-navy);
        background: var(--terra-bg-soft);
    }

    /* ---------- Alert ---------- */
    [data-h-scope="shop-products"] .alert-terra-success {
        background: rgba(30,158,99,.1);
        border: 1px solid rgba(30,158,99,.25);
        color: #157a4c;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: .6rem;
        font-weight: 500;
        font-size: .9rem;
    }

    /* ---------- Toolbar: tabs + search ---------- */
    [data-h-scope="shop-products"] .toolbar {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(25, 38, 93, 0.06);
        padding: .6rem .75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }
    [data-h-scope="shop-products"] .filter-tabs {
        display: flex;
        gap: .35rem;
        flex-wrap: wrap;
    }
    [data-h-scope="shop-products"] .filter-tab {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .45rem .9rem;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 600;
        color: var(--terra-muted);
        text-decoration: none;
        background: transparent;
        transition: background .15s ease, color .15s ease;
    }
    [data-h-scope="shop-products"] .filter-tab:hover { background: var(--terra-bg-soft); color: var(--terra-ink); }
    [data-h-scope="shop-products"] .filter-tab.is-active {
        background: var(--terra-navy);
        color: #fff;
    }
    [data-h-scope="shop-products"] .filter-tab .count {
        font-size: .72rem;
        opacity: .75;
    }
    [data-h-scope="shop-products"] .search-box {
        position: relative;
        min-width: 220px;
    }
    [data-h-scope="shop-products"] .search-box input {
        border: 1px solid var(--terra-line);
        border-radius: 10px;
        padding: .5rem .75rem .5rem 2.1rem;
        font-size: .85rem;
        background: var(--terra-bg-soft);
        width: 100%;
    }
    [data-h-scope="shop-products"] .search-box input:focus {
        outline: none;
        border-color: var(--terra-navy);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(25,38,93,.1);
    }
    [data-h-scope="shop-products"] .search-box i {
        position: absolute;
        left: .75rem; top: 50%;
        transform: translateY(-50%);
        color: var(--terra-muted);
        font-size: .85rem;
    }

    /* ---------- Empty state ---------- */
    [data-h-scope="shop-products"] .empty-state {
        background: #fff;
        border: 1.5px dashed var(--terra-line);
        border-radius: 16px;
        text-align: center;
        padding: 3.5rem 1.5rem;
    }
    [data-h-scope="shop-products"] .empty-state i { color: var(--terra-muted); }
    [data-h-scope="shop-products"] .empty-state p { color: var(--terra-muted); margin: .5rem 0 1.25rem; }

    /* ---------- Table card ---------- */
    [data-h-scope="shop-products"] .panel-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 14px rgba(25, 38, 93, 0.07);
    }
    [data-h-scope="shop-products"] .table thead th {
        background: var(--terra-bg-soft);
        color: var(--terra-muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        font-size: .7rem;
        font-weight: 700;
        border: none;
        padding: .9rem 1rem;
    }
    [data-h-scope="shop-products"] .table thead th:first-child { border-radius: 16px 0 0 0; }
    [data-h-scope="shop-products"] .table thead th:last-child { border-radius: 0 16px 0 0; text-align: right; }
    [data-h-scope="shop-products"] .table > :not(caption) > * > * {
        padding: .9rem 1rem;
        border-bottom-color: var(--terra-line);
        vertical-align: middle;
    }
    [data-h-scope="shop-products"] .table tbody tr { cursor: pointer; transition: background .12s ease; }
    [data-h-scope="shop-products"] .table tbody tr:hover { background: var(--terra-bg-soft); }
    [data-h-scope="shop-products"] .table tbody tr:last-child td { border-bottom: none; }

    [data-h-scope="shop-products"] .product-thumb { width: 52px; height: 52px; object-fit: cover; border-radius: 10px; }
    [data-h-scope="shop-products"] .product-thumb-placeholder {
        width: 52px; height: 52px; border-radius: 10px;
        background: var(--terra-bg-soft); color: var(--terra-muted);
        display: flex; align-items: center; justify-content: center;
    }
    [data-h-scope="shop-products"] .product-title { font-weight: 600; color: var(--terra-ink); font-size: .92rem; }
    [data-h-scope="shop-products"] .product-meta { font-size: .78rem; color: var(--terra-muted); }
    [data-h-scope="shop-products"] .rejection-note {
        font-size: .76rem; color: var(--terra-orange); font-weight: 500;
        display: flex; align-items: center; gap: .3rem; margin-top: .15rem;
    }
    [data-h-scope="shop-products"] .product-price { font-weight: 600; font-size: .88rem; color: var(--terra-ink); }
    [data-h-scope="shop-products"] .product-unit { font-size: .76rem; color: var(--terra-muted); }

    [data-h-scope="shop-products"] .badge-soft-success { background: rgba(30,158,99,.12); color: #157a4c; font-weight: 600; }
    [data-h-scope="shop-products"] .badge-soft-warning { background: rgba(208,82,8,.12); color: #a5430a; font-weight: 600; }
    [data-h-scope="shop-products"] .badge-soft-danger  { background: rgba(214,69,69,.12); color: #b93434; font-weight: 600; }
    [data-h-scope="shop-products"] .badge-soft-info    { background: rgba(25,38,93,.08); color: var(--terra-navy); font-weight: 600; }
    [data-h-scope="shop-products"] .badge-soft-muted   { background: #eceef5; color: var(--terra-muted); font-weight: 600; }

    [data-h-scope="shop-products"] .row-actions { display: inline-flex; gap: .35rem; }
    [data-h-scope="shop-products"] .btn-icon {
        width: 34px; height: 34px; border-radius: 9px;
        border: 1px solid var(--terra-line);
        background: #fff; color: var(--terra-navy);
        display: inline-flex; align-items: center; justify-content: center;
    }
    [data-h-scope="shop-products"] .btn-icon:hover { background: var(--terra-navy); border-color: var(--terra-navy); color: #fff; }
    [data-h-scope="shop-products"] .btn-icon.btn-icon-danger { color: #c62839; }
    [data-h-scope="shop-products"] .btn-icon.btn-icon-danger:hover { background: #c62839; border-color: #c62839; color: #fff; }

    /* ---------- Pagination ---------- */
    [data-h-scope="shop-products"] .pagination-wrap { margin-top: 1.25rem; }
    [data-h-scope="shop-products"] .pagination { justify-content: center; }
    [data-h-scope="shop-products"] .page-link { color: var(--terra-navy); border-color: var(--terra-line); font-size: .85rem; }
    [data-h-scope="shop-products"] .page-item.active .page-link { background: var(--terra-navy); border-color: var(--terra-navy); }
    [data-h-scope="shop-products"] .page-link:hover { background: var(--terra-bg-soft); color: var(--terra-navy); }

    /* ---------- Product detail modal ---------- */
    [data-h-scope="shop-products"] #productDetailModal .modal-content { border: none; border-radius: 16px; overflow: hidden; }
    [data-h-scope="shop-products"] #productDetailModal .modal-header { background: var(--terra-navy); color: #fff; border: none; padding: 1.25rem 1.5rem; }
    [data-h-scope="shop-products"] #productDetailModal .btn-close { filter: invert(1); }
    [data-h-scope="shop-products"] #productDetailModal .modal-body { padding: 1.5rem; }
    [data-h-scope="shop-products"] .pd-image { width: 100%; height: 220px; object-fit: cover; border-radius: 12px; background: var(--terra-bg-soft); }
    [data-h-scope="shop-products"] .pd-image-placeholder {
        width: 100%; height: 220px; border-radius: 12px; background: var(--terra-bg-soft);
        color: var(--terra-muted); display: flex; align-items: center; justify-content: center; font-size: 2rem;
    }
    [data-h-scope="shop-products"] .pd-label { text-transform: uppercase; letter-spacing: .08em; font-size: .68rem; font-weight: 700; color: var(--terra-muted); margin-bottom: .2rem; }
    [data-h-scope="shop-products"] .pd-value { font-weight: 600; color: var(--terra-ink); font-size: .95rem; }
    [data-h-scope="shop-products"] .pd-price { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1.4rem; color: var(--terra-orange); }
    [data-h-scope="shop-products"] .pd-divider { border-top: 1px solid var(--terra-line); margin: 1.1rem 0; }
    [data-h-scope="shop-products"] .pd-rejection {
        background: rgba(214,69,69,.08); border: 1px solid rgba(214,69,69,.2);
        border-radius: 10px; padding: .75rem .9rem; font-size: .84rem; color: #b93434; margin-top: 1rem;
    }

    @media (max-width: 767px) {
        [data-h-scope="shop-products"] .toolbar { flex-direction: column; align-items: stretch; }
        [data-h-scope="shop-products"] .search-box { min-width: 0; }
    }
</style>

<div data-h-scope="shop-products">

    <div class="page-header">
        <div>
            <div class="page-eyebrow">Inventory</div>
            <h1 class="page-title">My Products</h1>
            <div class="page-sub">{{ $products->total() }} product{{ $products->total() === 1 ? '' : 's' }} listed in your shop.</div>
        </div>
        <a href="{{ route('shop-panel.products.create') }}" class="btn btn-terra">
            <i class="bi bi-plus-lg"></i> Add Product
        </a>
    </div>

    @if (session('status'))
        <div class="alert alert-terra-success py-3 px-4 mb-3">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>
                @switch(session('status'))
                    @case('product-created') Product created and sent for review. @break
                    @case('product-updated') Product updated. @break
                    @case('product-deleted') Product removed. @break
                @endswitch
            </span>
        </div>
    @endif

    @if ($products->isEmpty())
        <div class="empty-state">
            <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
            <p class="mb-0">You haven't listed any products yet. Add your first one to start selling.</p>
            <a href="{{ route('shop-panel.products.create') }}" class="btn btn-terra btn-sm">
                <i class="bi bi-plus-lg"></i> Add Your First Product
            </a>
        </div>
    @else
        {{-- Toolbar: status tabs + search (wire ?status= and ?q= in the controller query to make these functional) --}}
        <div class="toolbar">
            <div class="filter-tabs">
                <a href="{{ request()->url() }}" class="filter-tab {{ !request('status') ? 'is-active' : '' }}">All</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'approved']) }}" class="filter-tab {{ request('status') === 'approved' ? 'is-active' : '' }}">Approved</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="filter-tab {{ request('status') === 'pending' ? 'is-active' : '' }}">Pending</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}" class="filter-tab {{ request('status') === 'rejected' ? 'is-active' : '' }}">Rejected</a>
            </div>
            <form method="GET" class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products...">
            </form>
        </div>

        <div class="card panel-card">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:70px;">Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        @php
                            $stockLabels = ['in_stock' => 'In Stock', 'out_of_stock' => 'Out of Stock', 'made_to_order' => 'Made to Order'];
                            $stockBadgeClass = ['in_stock' => 'badge-soft-success', 'out_of_stock' => 'badge-soft-danger', 'made_to_order' => 'badge-soft-info'][$product->stock_status] ?? 'badge-soft-muted';
                            $statusBadgeClass = ['pending' => 'badge-soft-warning', 'approved' => 'badge-soft-success', 'rejected' => 'badge-soft-danger'][$product->status] ?? 'badge-soft-muted';
                            $img = $product->primaryImage();
                            $imgUrl = $img ? asset('storage/' . $img->path) : null;
                        @endphp
                        <tr class="js-product-row"
                            data-title="{{ $product->title }}"
                            data-category="{{ $product->category->name ?? '—' }}"
                            data-price="{{ $product->price ? number_format($product->price) . ' ' . $product->currency : 'On request' }}"
                            data-unit="{{ $product->unit ?? '' }}"
                            data-status="{{ ucfirst($product->status) }}"
                            data-status-class="{{ $statusBadgeClass }}"
                            data-stock-label="{{ $stockLabels[$product->stock_status] ?? $product->stock_status }}"
                            data-stock-class="{{ $stockBadgeClass }}"
                            data-rejection="{{ $product->status === 'rejected' ? $product->rejection_reason : '' }}"
                            data-description="{{ $product->description ?? 'No description provided for this product.' }}"
                            data-created="{{ $product->created_at?->format('M d, Y') ?? '—' }}"
                            data-image="{{ $imgUrl }}"
                            data-edit-url="{{ route('shop-panel.products.edit', $product) }}">
                            <td>
                                @if ($imgUrl)
                                    <img src="{{ $imgUrl }}" class="product-thumb">
                                @else
                                    <div class="product-thumb-placeholder"><i class="bi bi-image"></i></div>
                                @endif
                            </td>
                            <td>
                                <div class="product-title">{{ $product->title }}</div>
                                @if ($product->status === 'rejected' && $product->rejection_reason)
                                    <div class="rejection-note"><i class="bi bi-exclamation-circle"></i> {{ Str::limit($product->rejection_reason, 40) }}</div>
                                @endif
                            </td>
                            <td class="product-meta">{{ $product->category->name ?? '—' }}</td>
                            <td>
                                <div class="product-price">{{ $product->price ? number_format($product->price) . ' ' . $product->currency : 'On request' }}</div>
                                @if ($product->unit)
                                    <div class="product-unit">{{ $product->unit }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $stockBadgeClass }}">{{ $stockLabels[$product->stock_status] ?? $product->stock_status }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $statusBadgeClass }}">{{ ucfirst($product->status) }}</span>
                            </td>
                            <td class="text-end">
                                <div class="row-actions">
                                    <a href="{{ route('shop-panel.products.show', $product) }}" class="btn-icon" title="View Details" onclick="event.stopPropagation();">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('shop-panel.products.edit', $product) }}" class="btn-icon" title="Edit" onclick="event.stopPropagation();">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('shop-panel.products.destroy', $product) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this product? This cannot be undone.');" onclick="event.stopPropagation();">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-icon btn-icon-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-wrap">
            {{ $products->links() }}
        </div>
    @endif

    {{-- Product detail modal --}}
    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0" id="pdModalTitle" style="font-family:'Sora',sans-serif;">Product details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <img id="pdImage" src="" class="pd-image d-none" alt="">
                            <div id="pdImagePlaceholder" class="pd-image-placeholder"><i class="bi bi-image"></i></div>
                        </div>
                        <div class="col-md-7">
                            <div id="pdCategory" class="pd-label"></div>
                            <div class="pd-price mb-1" id="pdPrice"></div>
                            <div class="pd-value mb-2" id="pdUnit" style="font-weight:400;color:var(--terra-muted);font-size:.82rem;"></div>
                            <div class="d-flex gap-2">
                                <span class="badge" id="pdStatus"></span>
                                <span class="badge" id="pdStock"></span>
                            </div>

                            <div class="pd-divider"></div>

                            <div class="pd-label">Listed on</div>
                            <div class="pd-value mb-3" id="pdCreated"></div>

                            <div class="pd-label">Description</div>
                            <p class="pd-desc mb-0" id="pdDescription" style="font-size:.88rem;color:var(--terra-muted);line-height:1.6;"></p>

                            <div class="pd-rejection d-none" id="pdRejectionBox">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                <span id="pdRejectionText"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-terra-outline btn-sm" data-bs-dismiss="modal">Close</button>
                    <a href="#" id="pdEditLink" class="btn btn-terra btn-sm">
                        <i class="bi bi-pencil"></i> Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('productDetailModal');
    if (!modalEl || typeof bootstrap === 'undefined') return;
    const modal = new bootstrap.Modal(modalEl);

    function openDetail(row) {
        document.getElementById('pdModalTitle').textContent = row.dataset.title;
        document.getElementById('pdCategory').textContent = row.dataset.category;
        document.getElementById('pdPrice').textContent = row.dataset.price;
        document.getElementById('pdUnit').textContent = row.dataset.unit || '';
        document.getElementById('pdCreated').textContent = row.dataset.created;
        document.getElementById('pdDescription').textContent = row.dataset.description;
        document.getElementById('pdEditLink').href = row.dataset.editUrl;

        const statusEl = document.getElementById('pdStatus');
        statusEl.textContent = row.dataset.status;
        statusEl.className = 'badge ' + row.dataset.statusClass;

        const stockEl = document.getElementById('pdStock');
        stockEl.textContent = row.dataset.stockLabel;
        stockEl.className = 'badge ' + row.dataset.stockClass;

        const rejectionBox = document.getElementById('pdRejectionBox');
        if (row.dataset.rejection) {
            document.getElementById('pdRejectionText').textContent = row.dataset.rejection;
            rejectionBox.classList.remove('d-none');
        } else {
            rejectionBox.classList.add('d-none');
        }

        const img = document.getElementById('pdImage');
        const placeholder = document.getElementById('pdImagePlaceholder');
        if (row.dataset.image) {
            img.src = row.dataset.image;
            img.classList.remove('d-none');
            placeholder.classList.add('d-none');
        } else {
            img.classList.add('d-none');
            placeholder.classList.remove('d-none');
        }

        modal.show();
    }

    document.querySelectorAll('.js-product-row').forEach(row => {
        row.addEventListener('click', function (e) {
            if (e.target.closest('a') || e.target.closest('form') || e.target.closest('button')) return;
            openDetail(row);
        });
    });
});
</script>
@endsection