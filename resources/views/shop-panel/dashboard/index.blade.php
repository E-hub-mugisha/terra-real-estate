@extends('layouts.shop')
@section('page-title', 'Dashboard')

@push('styles')
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

    [data-h-scope="shop-dashboard"] {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--terra-ink);
    }
    [data-h-scope="shop-dashboard"] h1,
    [data-h-scope="shop-dashboard"] h2,
    [data-h-scope="shop-dashboard"] h3,
    [data-h-scope="shop-dashboard"] h5,
    [data-h-scope="shop-dashboard"] .h-heading {
        font-family: 'Sora', sans-serif;
    }

    /* ---------- Welcome banner ---------- */
    [data-h-scope="shop-dashboard"] .welcome-banner {
        background: linear-gradient(135deg, var(--terra-navy-deep) 0%, var(--terra-navy) 55%, var(--terra-navy-light) 100%);
        border-radius: 18px;
        color: #fff;
        padding: 2rem 2.25rem;
        position: relative;
        overflow: hidden;
    }
    [data-h-scope="shop-dashboard"] .welcome-banner::before {
        content: "";
        position: absolute;
        right: -60px; top: -70px;
        width: 220px; height: 220px;
        background: rgba(208,82,8,.22);
        border-radius: 50%;
    }
    [data-h-scope="shop-dashboard"] .welcome-banner::after {
        content: "";
        position: absolute;
        left: 38%; bottom: -90px;
        width: 160px; height: 160px;
        background: rgba(255,255,255,.05);
        border-radius: 50%;
    }
    [data-h-scope="shop-dashboard"] .welcome-banner > * { position: relative; z-index: 1; }
    [data-h-scope="shop-dashboard"] .welcome-eyebrow {
        text-transform: uppercase;
        letter-spacing: .12em;
        font-size: .7rem;
        font-weight: 600;
        color: var(--terra-orange-light);
    }
    [data-h-scope="shop-dashboard"] .welcome-banner h5 {
        font-size: 1.4rem;
        font-weight: 700;
    }
    [data-h-scope="shop-dashboard"] .btn-terra-invert {
        background: #fff;
        color: var(--terra-navy);
        font-weight: 600;
        border: none;
    }
    [data-h-scope="shop-dashboard"] .btn-terra-invert:hover {
        background: var(--terra-orange-light);
        color: #fff;
    }

    /* ---------- Stat cards ---------- */
    [data-h-scope="shop-dashboard"] .stat-card {
        border: none;
        border-left: 4px solid transparent;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 2px 12px rgba(25, 38, 93, 0.06);
        transition: transform .15s ease, box-shadow .15s ease;
    }
    [data-h-scope="shop-dashboard"] .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(25, 38, 93, 0.1);
    }
    [data-h-scope="shop-dashboard"] .stat-card.accent-navy   { border-left-color: var(--terra-navy); }
    [data-h-scope="shop-dashboard"] .stat-card.accent-orange { border-left-color: var(--terra-orange); }
    [data-h-scope="shop-dashboard"] .stat-card.accent-green  { border-left-color: #1e9e63; }
    [data-h-scope="shop-dashboard"] .stat-card.accent-danger { border-left-color: #d64545; }

    [data-h-scope="shop-dashboard"] .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }
    [data-h-scope="shop-dashboard"] .stat-icon.bg-navy    { background: rgba(25,38,93,.08); color: var(--terra-navy); }
    [data-h-scope="shop-dashboard"] .stat-icon.bg-green   { background: rgba(30,158,99,.12); color: #1e9e63; }
    [data-h-scope="shop-dashboard"] .stat-icon.bg-orange  { background: rgba(208,82,8,.12); color: var(--terra-orange); }
    [data-h-scope="shop-dashboard"] .stat-icon.bg-danger  { background: rgba(214,69,69,.1); color: #d64545; }

    [data-h-scope="shop-dashboard"] .stat-label { color: var(--terra-muted); font-size: .8rem; font-weight: 500; }
    [data-h-scope="shop-dashboard"] .stat-value { font-family: 'Sora', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--terra-ink); }

    /* ---------- Panels ---------- */
    [data-h-scope="shop-dashboard"] .panel-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(25, 38, 93, 0.06);
    }
    [data-h-scope="shop-dashboard"] .panel-card .card-header {
        border-bottom: 1px solid var(--terra-line);
        border-radius: 14px 14px 0 0 !important;
        background: #fff;
        padding: 1rem 1.25rem;
    }
    [data-h-scope="shop-dashboard"] .panel-title {
        font-family: 'Sora', sans-serif;
        font-weight: 600;
        font-size: .95rem;
        color: var(--terra-ink);
    }
    [data-h-scope="shop-dashboard"] .panel-link {
        color: var(--terra-orange);
        font-weight: 600;
        font-size: .82rem;
        text-decoration: none;
    }
    [data-h-scope="shop-dashboard"] .panel-link:hover { color: var(--terra-navy); }

    [data-h-scope="shop-dashboard"] .btn-terra {
        background: var(--terra-navy);
        border-color: var(--terra-navy);
        color: #fff;
        font-weight: 600;
    }
    [data-h-scope="shop-dashboard"] .btn-terra:hover {
        background: var(--terra-navy-light);
        border-color: var(--terra-navy-light);
        color: #fff;
    }
    [data-h-scope="shop-dashboard"] .btn-terra-outline {
        background: transparent;
        border: 1px solid var(--terra-navy);
        color: var(--terra-navy);
        font-weight: 600;
    }
    [data-h-scope="shop-dashboard"] .btn-terra-outline:hover {
        background: var(--terra-navy);
        color: #fff;
    }

    /* ---------- Products table ---------- */
    [data-h-scope="shop-dashboard"] .table > :not(caption) > * > * { padding-top: .9rem; padding-bottom: .9rem; border-bottom-color: var(--terra-line); }
    [data-h-scope="shop-dashboard"] .table tbody tr { cursor: pointer; transition: background .12s ease; }
    [data-h-scope="shop-dashboard"] .table tbody tr:hover { background: var(--terra-bg-soft); }

    [data-h-scope="shop-dashboard"] .product-thumb {
        width: 46px; height: 46px; object-fit: cover; border-radius: 10px;
    }
    [data-h-scope="shop-dashboard"] .product-thumb-placeholder {
        width: 46px; height: 46px; border-radius: 10px;
        background: var(--terra-bg-soft); color: var(--terra-muted);
        display: flex; align-items: center; justify-content: center;
    }
    [data-h-scope="shop-dashboard"] .product-title { font-weight: 600; color: var(--terra-ink); font-size: .92rem; }
    [data-h-scope="shop-dashboard"] .product-meta { font-size: .78rem; color: var(--terra-muted); }
    [data-h-scope="shop-dashboard"] .product-price { font-weight: 600; font-size: .88rem; color: var(--terra-ink); }

    [data-h-scope="shop-dashboard"] .badge-soft-success { background: rgba(30,158,99,.12); color: #157a4c; font-weight: 600; }
    [data-h-scope="shop-dashboard"] .badge-soft-warning { background: rgba(208,82,8,.12); color: #a5430a; font-weight: 600; }
    [data-h-scope="shop-dashboard"] .badge-soft-danger  { background: rgba(214,69,69,.12); color: #b93434; font-weight: 600; }
    [data-h-scope="shop-dashboard"] .badge-soft-muted   { background: #eceef5; color: var(--terra-muted); font-weight: 600; }

    [data-h-scope="shop-dashboard"] .btn-view-detail {
        width: 34px; height: 34px; border-radius: 9px;
        border: 1px solid var(--terra-line);
        background: #fff; color: var(--terra-navy);
        display: inline-flex; align-items: center; justify-content: center;
    }
    [data-h-scope="shop-dashboard"] .btn-view-detail:hover { background: var(--terra-navy); border-color: var(--terra-navy); color: #fff; }

    /* ---------- Shop summary ---------- */
    [data-h-scope="shop-dashboard"] .shop-avatar {
        width: 58px; height: 58px; border-radius: 12px; object-fit: cover;
    }
    [data-h-scope="shop-dashboard"] .shop-avatar-placeholder {
        width: 58px; height: 58px; border-radius: 12px;
        background: var(--terra-bg-soft); color: var(--terra-muted);
        display: flex; align-items: center; justify-content: center;
    }
    [data-h-scope="shop-dashboard"] .info-list { font-size: .85rem; color: var(--terra-muted); }
    [data-h-scope="shop-dashboard"] .info-list li { display: flex; align-items: center; gap: .5rem; margin-bottom: .5rem; }
    [data-h-scope="shop-dashboard"] .info-list i { color: var(--terra-navy); width: 16px; }

    /* ---------- Product detail modal ---------- */
    [data-h-scope="shop-dashboard"] #productDetailModal .modal-content {
        border: none; border-radius: 16px; overflow: hidden;
    }
    [data-h-scope="shop-dashboard"] #productDetailModal .modal-header {
        background: var(--terra-navy); color: #fff; border: none; padding: 1.25rem 1.5rem;
    }
    [data-h-scope="shop-dashboard"] #productDetailModal .btn-close { filter: invert(1); }
    [data-h-scope="shop-dashboard"] #productDetailModal .modal-body { padding: 1.5rem; }
    [data-h-scope="shop-dashboard"] .pd-image {
        width: 100%; height: 220px; object-fit: cover; border-radius: 12px; background: var(--terra-bg-soft);
    }
    [data-h-scope="shop-dashboard"] .pd-image-placeholder {
        width: 100%; height: 220px; border-radius: 12px; background: var(--terra-bg-soft);
        color: var(--terra-muted); display: flex; align-items: center; justify-content: center; font-size: 2rem;
    }
    [data-h-scope="shop-dashboard"] .pd-label {
        text-transform: uppercase; letter-spacing: .08em; font-size: .68rem;
        font-weight: 700; color: var(--terra-muted); margin-bottom: .2rem;
    }
    [data-h-scope="shop-dashboard"] .pd-value { font-weight: 600; color: var(--terra-ink); font-size: .95rem; }
    [data-h-scope="shop-dashboard"] .pd-price {
        font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1.4rem; color: var(--terra-orange);
    }
    [data-h-scope="shop-dashboard"] .pd-divider { border-top: 1px solid var(--terra-line); margin: 1.1rem 0; }
    [data-h-scope="shop-dashboard"] .pd-desc { font-size: .88rem; color: var(--terra-muted); line-height: 1.6; }
</style>
@endpush

@section('content')
<div data-h-scope="shop-dashboard">

    {{-- Welcome banner --}}
    <div class="welcome-banner mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="welcome-eyebrow mb-1">Shop dashboard</div>
                <h5 class="mb-1 text-white">Welcome back, {{ auth()->user()->name }}</h5>
                <div class="text-white-50 small">
                    Here's how <strong class="text-white">{{ $shop->name }}</strong> is performing today.
                </div>
            </div>
            <a href="{{ route('shop-panel.products.create') }}" class="btn btn-terra-invert px-3">
                <i class="bi bi-plus-lg"></i> Add Product
            </a>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card accent-navy h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-navy"><i class="bi bi-box-seam"></i></div>
                    <div>
                        <div class="stat-label">Total Products</div>
                        <div class="stat-value">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card accent-green h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-green"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <div class="stat-label">Approved</div>
                        <div class="stat-value">{{ $stats['approved'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card accent-orange h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-orange"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="stat-label">Pending Review</div>
                        <div class="stat-value">{{ $stats['pending'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card accent-danger h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon bg-danger"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <div class="stat-label">Out of Stock</div>
                        <div class="stat-value">{{ $stats['out_stock'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- Chart + recent products --}}
        <div class="col-lg-8">
            <div class="card panel-card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="panel-title">Product Submissions</span>
                    <span class="small text-muted">Last 6 months</span>
                </div>
                <div class="card-body">
                    <canvas id="productsChart" height="110"></canvas>
                </div>
            </div>

            <div class="card panel-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="panel-title">Recent Products</span>
                    <a href="{{ route('shop-panel.products.index') }}" class="panel-link">View all</a>
                </div>

                @if ($recentProducts->isEmpty())
                    <div class="card-body text-center text-muted py-5">
                        <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                        No products yet.
                        <div class="mt-3">
                            <a href="{{ route('shop-panel.products.create') }}" class="btn btn-terra btn-sm">Add Your First Product</a>
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <tbody>
                            @foreach ($recentProducts as $product)
                                @php
                                    $badgeClass = ['pending' => 'badge-soft-warning', 'approved' => 'badge-soft-success', 'rejected' => 'badge-soft-danger'][$product->status] ?? 'badge-soft-muted';
                                    $img = $product->primaryImage();
                                    $imgUrl = $img ? asset('storage/' . $img->path) : null;
                                    $stockQty = $product->stock_quantity ?? $product->quantity ?? null;
                                @endphp
                                <tr class="js-product-row"
                                    data-title="{{ $product->title }}"
                                    data-category="{{ $product->category->name ?? '—' }}"
                                    data-price="{{ $product->price ? number_format($product->price) . ' ' . $product->currency : 'On request' }}"
                                    data-status="{{ ucfirst($product->status) }}"
                                    data-status-class="{{ $badgeClass }}"
                                    data-stock="{{ $stockQty !== null ? $stockQty : '—' }}"
                                    data-sku="{{ $product->sku ?? '—' }}"
                                    data-created="{{ $product->created_at?->format('M d, Y') ?? '—' }}"
                                    data-description="{{ $product->description ?? 'No description provided for this product.' }}"
                                    data-image="{{ $imgUrl }}"
                                    data-edit-url="{{ route('shop-panel.products.edit', $product) }}">
                                    <td style="width:60px;">
                                        @if ($imgUrl)
                                            <img src="{{ $imgUrl }}" class="product-thumb">
                                        @else
                                            <div class="product-thumb-placeholder"><i class="bi bi-image"></i></div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="product-title">{{ $product->title }}</div>
                                        <div class="product-meta">{{ $product->category->name ?? '—' }}</div>
                                    </td>
                                    <td>
                                        <span class="product-price">
                                            {{ $product->price ? number_format($product->price) . ' ' . $product->currency : 'On request' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($product->status) }}</span>
                                    </td>
                                    <td class="text-end" style="width:90px;">
                                        <button type="button" class="btn-view-detail js-view-detail me-1" title="View details">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('shop-panel.products.edit', $product) }}" class="btn-view-detail d-inline-flex" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Shop summary / quick actions --}}
        <div class="col-lg-4">
            <div class="card panel-card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if ($shop->logo)
                            <img src="{{ asset('storage/' . $shop->logo) }}" class="shop-avatar">
                        @else
                            <div class="shop-avatar-placeholder"><i class="bi bi-shop"></i></div>
                        @endif
                        <div>
                            <div class="fw-semibold" style="font-family:'Sora',sans-serif;">{{ $shop->name }}</div>
                            @php
                                $shopBadge = ['pending' => 'badge-soft-warning', 'approved' => 'badge-soft-success', 'rejected' => 'badge-soft-danger', 'suspended' => 'badge-soft-muted'][$shop->status] ?? 'badge-soft-muted';
                            @endphp
                            <span class="badge {{ $shopBadge }}">{{ ucfirst($shop->status) }}</span>
                        </div>
                    </div>

                    <ul class="list-unstyled info-list mb-0">
                        <li><i class="bi bi-geo-alt"></i> {{ $shop->district ?? '—' }}, {{ $shop->province ?? '—' }}</li>
                        <li><i class="bi bi-telephone"></i> {{ $shop->phone ?? '—' }}</li>
                        <li><i class="bi bi-eye"></i> {{ number_format($shop->views_count) }} shop views</li>
                    </ul>

                    <a href="{{ route('shop-panel.profile.edit') }}" class="btn btn-terra-outline btn-sm w-100 mt-3">
                        Edit Shop Profile
                    </a>
                </div>
            </div>

            <div class="card panel-card">
                <div class="card-body">
                    <div class="panel-title mb-2">Quick Actions</div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('shop-panel.products.create') }}" class="btn btn-terra btn-sm">
                            <i class="bi bi-plus-lg"></i> Add Product
                        </a>
                        <a href="{{ route('shop-panel.products.index') }}" class="btn btn-terra-outline btn-sm">
                            <i class="bi bi-list-ul"></i> Manage Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <div class="pd-price mb-2" id="pdPrice"></div>
                            <span class="badge" id="pdStatus"></span>

                            <div class="pd-divider"></div>

                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="pd-label">Stock</div>
                                    <div class="pd-value" id="pdStock"></div>
                                </div>
                                <div class="col-6">
                                    <div class="pd-label">SKU</div>
                                    <div class="pd-value" id="pdSku"></div>
                                </div>
                                <div class="col-6">
                                    <div class="pd-label">Listed on</div>
                                    <div class="pd-value" id="pdCreated"></div>
                                </div>
                            </div>

                            <div class="pd-divider"></div>

                            <div class="pd-label">Description</div>
                            <p class="pd-desc mb-0" id="pdDescription"></p>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ---- Chart ----
    const ctx = document.getElementById('productsChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Products Added',
                    data: @json($chartData),
                    borderColor: '#19265d',
                    backgroundColor: 'rgba(25,38,93,0.08)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#D05208',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#19265d',
                        padding: 10,
                        cornerRadius: 8,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { color: '#f0f1f7' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // ---- Product detail modal ----
    const modalEl = document.getElementById('productDetailModal');
    if (!modalEl || typeof bootstrap === 'undefined') return;
    const modal = new bootstrap.Modal(modalEl);

    function openDetail(row) {
        document.getElementById('pdModalTitle').textContent = row.dataset.title;
        document.getElementById('pdCategory').textContent = row.dataset.category;
        document.getElementById('pdPrice').textContent = row.dataset.price;
        document.getElementById('pdStock').textContent = row.dataset.stock;
        document.getElementById('pdSku').textContent = row.dataset.sku;
        document.getElementById('pdCreated').textContent = row.dataset.created;
        document.getElementById('pdDescription').textContent = row.dataset.description;
        document.getElementById('pdEditLink').href = row.dataset.editUrl;

        const statusEl = document.getElementById('pdStatus');
        statusEl.textContent = row.dataset.status;
        statusEl.className = 'badge ' + row.dataset.statusClass;

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
            if (e.target.closest('a')) return; // let edit link behave normally
            openDetail(row);
        });
    });

    document.querySelectorAll('.js-view-detail').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            openDetail(this.closest('.js-product-row'));
        });
    });
});
</script>
@endpush