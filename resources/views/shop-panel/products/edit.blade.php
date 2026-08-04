@extends('layouts.shop')
@section('page-title', 'Edit Product')

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

    [data-h-scope="product-form"] {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--terra-ink);
    }
    [data-h-scope="product-form"] h1,
    [data-h-scope="product-form"] .h-heading {
        font-family: 'Sora', sans-serif;
    }

    /* ---------- Page header ---------- */
    [data-h-scope="product-form"] .page-header {
        display: flex;
        align-items: center;
        gap: .85rem;
        margin-bottom: 1.5rem;
    }
    [data-h-scope="product-form"] .btn-back {
        width: 38px; height: 38px; border-radius: 10px;
        border: 1px solid var(--terra-line);
        background: #fff; color: var(--terra-navy);
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    [data-h-scope="product-form"] .btn-back:hover { background: var(--terra-navy); border-color: var(--terra-navy); color: #fff; }
    [data-h-scope="product-form"] .page-eyebrow {
        text-transform: uppercase;
        letter-spacing: .1em;
        font-size: .7rem;
        font-weight: 700;
        color: var(--terra-orange);
        margin-bottom: .1rem;
    }
    [data-h-scope="product-form"] .page-title { font-size: 1.3rem; font-weight: 700; margin: 0; }

    /* ---------- Info alert ---------- */
    [data-h-scope="product-form"] .alert-terra-info {
        background: rgba(25,38,93,.06);
        border: 1px solid rgba(25,38,93,.15);
        color: var(--terra-navy);
        border-radius: 12px;
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        font-size: .85rem;
        padding: .85rem 1.1rem;
    }
    [data-h-scope="product-form"] .alert-terra-info i { font-size: 1.05rem; margin-top: .05rem; }

    /* ---------- Form shell (shared look with profile form) ---------- */
    [data-h-scope="product-form"] .form-card { border: none; border-radius: 16px; box-shadow: 0 2px 14px rgba(25, 38, 93, 0.07); overflow: hidden; }
    [data-h-scope="product-form"] .form-section { padding: 1.75rem 2rem; border-bottom: 1px solid var(--terra-line); }
    [data-h-scope="product-form"] .form-section:last-of-type { border-bottom: none; }
    [data-h-scope="product-form"] .section-eyebrow { display: flex; align-items: center; gap: .6rem; margin-bottom: 1.25rem; }
    [data-h-scope="product-form"] .section-icon {
        width: 34px; height: 34px; border-radius: 9px;
        background: rgba(25,38,93,.08); color: var(--terra-navy);
        display: flex; align-items: center; justify-content: center; font-size: .95rem; flex-shrink: 0;
    }
    [data-h-scope="product-form"] .section-title { font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1rem; margin: 0; }
    [data-h-scope="product-form"] .section-desc { color: var(--terra-muted); font-size: .8rem; margin: 0; }

    [data-h-scope="product-form"] .form-label { font-weight: 600; font-size: .82rem; color: var(--terra-ink); margin-bottom: .4rem; }
    [data-h-scope="product-form"] .form-label .optional-tag { font-weight: 400; color: var(--terra-muted); }
    [data-h-scope="product-form"] .form-control,
    [data-h-scope="product-form"] .form-select {
        border: 1px solid var(--terra-line); border-radius: 10px;
        padding: .6rem .85rem; font-size: .9rem; background: var(--terra-bg-soft);
    }
    [data-h-scope="product-form"] .form-control:focus,
    [data-h-scope="product-form"] .form-select:focus {
        border-color: var(--terra-navy); box-shadow: 0 0 0 3px rgba(25,38,93,.1); background: #fff;
    }
    [data-h-scope="product-form"] .form-control.is-invalid { border-color: var(--terra-orange); background: #fff; }
    [data-h-scope="product-form"] .invalid-feedback { font-size: .78rem; color: var(--terra-orange); }
    [data-h-scope="product-form"] .form-text-hint { font-size: .76rem; color: var(--terra-muted); margin-top: .3rem; }

    /* ---------- Uploaders ---------- */
    [data-h-scope="product-form"] .uploader {
        border: 1.5px dashed var(--terra-line); border-radius: 14px; background: var(--terra-bg-soft);
        padding: 1.1rem; display: flex; align-items: center; gap: 1rem;
        transition: border-color .15s ease, background .15s ease; cursor: pointer; position: relative;
    }
    [data-h-scope="product-form"] .uploader:hover { border-color: var(--terra-orange); background: #fff; }
    [data-h-scope="product-form"] .uploader input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    [data-h-scope="product-form"] .uploader-placeholder.photos-icon {
        width: 46px; height: 46px; border-radius: 10px; background: #fff; border: 1px solid var(--terra-line);
        display: flex; align-items: center; justify-content: center; color: var(--terra-orange); font-size: 1.3rem; flex-shrink: 0;
    }
    [data-h-scope="product-form"] .uploader-text-title { font-weight: 600; font-size: .85rem; color: var(--terra-ink); }
    [data-h-scope="product-form"] .uploader-text-sub { font-size: .76rem; color: var(--terra-muted); }
    [data-h-scope="product-form"] .uploader-text-sub .js-file-name { color: var(--terra-orange); font-weight: 600; }

    [data-h-scope="product-form"] .photo-grid { display: flex; flex-wrap: wrap; gap: .6rem; }
    [data-h-scope="product-form"] .photo-thumb-wrap { position: relative; width: 76px; height: 76px; }
    [data-h-scope="product-form"] .photo-thumb {
        width: 76px; height: 76px; object-fit: cover; border-radius: 10px; border: 1px solid var(--terra-line);
    }
    [data-h-scope="product-form"] .photo-primary-badge {
        position: absolute; top: 4px; left: 4px;
        background: var(--terra-orange); color: #fff;
        font-size: .6rem; font-weight: 700; padding: .12rem .4rem; border-radius: 5px;
        text-transform: uppercase; letter-spacing: .04em;
    }

    /* ---------- Actions ---------- */
    [data-h-scope="product-form"] .form-actions {
        background: #fbfbfe; padding: 1.1rem 2rem;
        display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;
    }
    [data-h-scope="product-form"] .form-actions-hint { font-size: .8rem; color: var(--terra-muted); display: flex; align-items: center; gap: .4rem; }
    [data-h-scope="product-form"] .btn-terra {
        background: var(--terra-navy); border-color: var(--terra-navy); color: #fff; font-weight: 600;
        border-radius: 10px; padding: .6rem 1.4rem; font-size: .88rem;
    }
    [data-h-scope="product-form"] .btn-terra:hover { background: var(--terra-navy-light); border-color: var(--terra-navy-light); color: #fff; }
    [data-h-scope="product-form"] .btn-terra-outline {
        background: transparent; border: 1px solid var(--terra-line); color: var(--terra-muted); font-weight: 600;
        border-radius: 10px; padding: .6rem 1.2rem; font-size: .88rem;
    }
    [data-h-scope="product-form"] .btn-terra-outline:hover { border-color: var(--terra-navy); color: var(--terra-navy); }

    @media (max-width: 767px) {
        [data-h-scope="product-form"] .form-section { padding: 1.25rem 1.25rem; }
        [data-h-scope="product-form"] .form-actions { padding: 1rem 1.25rem; }
    }
</style>
@endpush

@section('content')
<div data-h-scope="product-form">

    <div class="page-header">
        <a href="{{ route('shop-panel.products.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="page-eyebrow">Inventory</div>
            <h1 class="page-title">Edit Product</h1>
        </div>
    </div>

    @if ($product->status === 'approved')
        <div class="alert-terra-info mb-3">
            <i class="bi bi-info-circle"></i>
            <span>This product is currently live. Saving changes will send it back for review before it's visible again.</span>
        </div>
    @endif

    <form method="POST" action="{{ route('shop-panel.products.update', $product) }}" enctype="multipart/form-data" class="card form-card">
        @csrf
        @method('PUT')
        @include('shop-panel.products._form', ['product' => $product])

        <div class="form-actions">
            <div class="form-actions-hint">
                <i class="bi bi-shield-check"></i> Changes are reviewed before they go live if this listing was approved.
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('shop-panel.products.index') }}" class="btn btn-terra-outline">Cancel</a>
                <button type="submit" class="btn btn-terra">
                    <i class="bi bi-check2"></i> Save Changes
                </button>
            </div>
        </div>
    </form>

</div>
@endsection