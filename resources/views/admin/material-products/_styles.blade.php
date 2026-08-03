{{-- resources/views/admin/material-products/_styles.blade.php --}}
<style>
    [data-h-scope="material-products"] {
        --mp-accent: #00a667;
        --mp-text: #1a1a1a;
        --mp-muted: #6b7280;
        --mp-border: #e5e7eb;
        --mp-bg-soft: #f9fafb;
        --mp-danger: #dc2626;
        --mp-warning: #b45309;
        font-family: 'DM Sans', sans-serif;
        color: var(--mp-text);
    }
    [data-h-scope="material-products"] h1,
    [data-h-scope="material-products"] .mp-title { font-family: 'Syne', sans-serif; }

    .mp-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
    .mp-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--mp-accent); color: #fff; border: none;
        padding: .6rem 1.1rem; border-radius: .5rem; font-weight: 600;
        font-size: .875rem; cursor: pointer; transition: opacity .15s; text-decoration: none;
    }
    .mp-btn:hover { opacity: .9; color: #fff; }
    .mp-btn-outline { background: #fff; color: var(--mp-accent); border: 1px solid var(--mp-accent); }
    .mp-btn-ghost { background: transparent; color: var(--mp-muted); border: 1px solid var(--mp-border); }
    .mp-btn-danger { background: var(--mp-danger); }
    .mp-btn-sm { padding: .35rem .7rem; font-size: .8rem; }

    .mp-alert { padding: .75rem 1rem; border-radius: .5rem; margin-bottom: 1rem; font-size: .875rem; }
    .mp-alert-success { background: #dcfce7; color: #166534; }
    .mp-alert-error { background: #fee2e2; color: #991b1b; }

    /* Filters */
    .mp-filters { background: #fff; border: 1px solid var(--mp-border); border-radius: .75rem; padding: 1rem; margin-bottom: 1.25rem; }
    .mp-filters form { display: flex; gap: .75rem; flex-wrap: wrap; align-items: flex-end; }
    .mp-filters .mp-field { margin-bottom: 0; min-width: 160px; }
    .mp-filters .mp-field label { display: block; font-size: .72rem; font-weight: 600; color: var(--mp-muted); margin-bottom: .3rem; text-transform: uppercase; letter-spacing: .03em; }
    .mp-filters input, .mp-filters select { padding: .5rem .65rem; border: 1px solid var(--mp-border); border-radius: .45rem; font-size: .85rem; }

    /* Table */
    .mp-table-wrap { background: #fff; border: 1px solid var(--mp-border); border-radius: .75rem; overflow: hidden; }
    table.mp-table { width: 100%; border-collapse: collapse; }
    table.mp-table th, table.mp-table td { padding: .75rem 1rem; text-align: left; font-size: .875rem; border-bottom: 1px solid var(--mp-border); vertical-align: middle; }
    table.mp-table th { background: var(--mp-bg-soft); color: var(--mp-muted); font-weight: 600; text-transform: uppercase; font-size: .72rem; letter-spacing: .04em; }
    table.mp-table tbody tr:last-child td { border-bottom: none; }
    .mp-thumb { width: 48px; height: 48px; border-radius: .5rem; object-fit: cover; background: var(--mp-bg-soft); display: block; }
    .mp-thumb-placeholder { width: 48px; height: 48px; border-radius: .5rem; background: var(--mp-bg-soft); display: flex; align-items: center; justify-content: center; color: var(--mp-muted); font-size: 1.1rem; }
    .mp-actions { display: flex; gap: .4rem; flex-wrap: wrap; }
    .mp-product-title { font-weight: 600; }
    .mp-product-sub { color: var(--mp-muted); font-size: .78rem; }

    .mp-badge { display: inline-block; padding: .2rem .6rem; border-radius: 999px; font-size: .72rem; font-weight: 600; }
    .mp-badge-approved { background: #dcfce7; color: #166534; }
    .mp-badge-pending { background: #fef3c7; color: #92400e; }
    .mp-badge-rejected { background: #fee2e2; color: #991b1b; }
    .mp-badge-featured { background: #e0e7ff; color: #3730a3; }
    .mp-badge-stock-in_stock { background: #dcfce7; color: #166534; }
    .mp-badge-stock-low_stock { background: #fef3c7; color: #92400e; }
    .mp-badge-stock-out_of_stock { background: #fee2e2; color: #991b1b; }

    .mp-pagination { margin-top: 1.25rem; }

    /* Forms */
    .mp-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 1.25rem; align-items: start; }
    @media (max-width: 900px) { .mp-grid { grid-template-columns: 1fr; } }

    .mp-card { background: #fff; border: 1px solid var(--mp-border); border-radius: .75rem; padding: 1.25rem; margin-bottom: 1.25rem; }
    .mp-card-title { margin: 0 0 1rem; font-size: 1rem; }

    .mp-field { margin-bottom: 1rem; }
    .mp-field label { display: block; font-size: .8rem; font-weight: 600; margin-bottom: .35rem; color: var(--mp-muted); }
    .mp-field input[type="text"], .mp-field input[type="number"], .mp-field input[type="file"],
    .mp-field select, .mp-field textarea {
        width: 100%; padding: .55rem .7rem; border: 1px solid var(--mp-border); border-radius: .45rem; font-size: .875rem; font-family: inherit;
    }
    .mp-field textarea { resize: vertical; }
    .mp-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media (max-width: 500px) { .mp-field-row { grid-template-columns: 1fr; } }
    .mp-field-inline { display: flex; align-items: center; gap: .5rem; }
    .mp-error { color: var(--mp-danger); font-size: .75rem; margin-top: .25rem; }
    .mp-hint { color: var(--mp-muted); font-size: .75rem; margin: .35rem 0 0; }

    .mp-form-actions { display: flex; justify-content: flex-end; gap: .6rem; margin-top: .5rem; }

    /* Image list in form */
    .mp-image-list { list-style: none; margin: 0 0 1rem; padding: 0; display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: .75rem; }
    .mp-image-item { border: 1px solid var(--mp-border); border-radius: .5rem; overflow: hidden; }
    .mp-image-item img { width: 100%; height: 90px; object-fit: cover; display: block; }
    .mp-image-controls { padding: .5rem; display: flex; flex-direction: column; gap: .3rem; font-size: .72rem; }
    .mp-radio, .mp-checkbox { display: flex; align-items: center; gap: .35rem; cursor: pointer; }
    .mp-checkbox-danger { color: var(--mp-danger); }

    /* Show page */
    .mp-show-grid { display: grid; grid-template-columns: 420px 1fr; gap: 1.5rem; align-items: start; }
    @media (max-width: 900px) { .mp-show-grid { grid-template-columns: 1fr; } }
    .mp-gallery-main { width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: .75rem; border: 1px solid var(--mp-border); background: var(--mp-bg-soft); }
    .mp-gallery-thumbs { display: flex; gap: .5rem; margin-top: .75rem; flex-wrap: wrap; }
    .mp-gallery-thumbs img { width: 64px; height: 64px; object-fit: cover; border-radius: .45rem; border: 2px solid transparent; cursor: pointer; }
    .mp-gallery-thumbs img.is-active { border-color: var(--mp-accent); }
    .mp-info-list { list-style: none; margin: 0; padding: 0; }
    .mp-info-list li { display: flex; justify-content: space-between; padding: .6rem 0; border-bottom: 1px solid var(--mp-border); font-size: .875rem; }
    .mp-info-list li:last-child { border-bottom: none; }
    .mp-info-label { color: var(--mp-muted); }
    .mp-price { font-size: 1.6rem; font-weight: 700; font-family: 'Syne', sans-serif; }
    .mp-whatsapp-btn { background: #25D366; }
</style>
