@extends('layouts.app')

@section('content')
<div data-h-scope="material-categories">
<style>
    [data-h-scope="material-categories"] {
        --mc-accent: #00a667;
        --mc-text: #1a1a1a;
        --mc-muted: #6b7280;
        --mc-border: #e5e7eb;
        --mc-bg-soft: #f9fafb;
        --mc-danger: #dc2626;
        font-family: 'DM Sans', sans-serif;
        color: var(--mc-text);
    }
    [data-h-scope="material-categories"] h1,
    [data-h-scope="material-categories"] .mc-title { font-family: 'Syne', sans-serif; }

    .mc-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
    .mc-btn {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--mc-accent); color: #fff; border: none;
        padding: .6rem 1.1rem; border-radius: .5rem; font-weight: 600;
        font-size: .875rem; cursor: pointer; transition: opacity .15s;
    }
    .mc-btn:hover { opacity: .9; }
    .mc-btn-outline { background: #fff; color: var(--mc-accent); border: 1px solid var(--mc-accent); }
    .mc-btn-ghost { background: transparent; color: var(--mc-muted); border: 1px solid var(--mc-border); }
    .mc-btn-danger { background: var(--mc-danger); }
    .mc-btn-sm { padding: .35rem .7rem; font-size: .8rem; }

    .mc-table-wrap { background: #fff; border: 1px solid var(--mc-border); border-radius: .75rem; overflow: hidden; }
    table.mc-table { width: 100%; border-collapse: collapse; }
    table.mc-table th, table.mc-table td { padding: .75rem 1rem; text-align: left; font-size: .875rem; border-bottom: 1px solid var(--mc-border); }
    table.mc-table th { background: var(--mc-bg-soft); color: var(--mc-muted); font-weight: 600; text-transform: uppercase; font-size: .72rem; letter-spacing: .04em; }
    table.mc-table tbody tr:last-child td { border-bottom: none; }
    .mc-icon-cell { width: 40px; height: 40px; border-radius: .5rem; background: var(--mc-bg-soft); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .mc-badge { display: inline-block; padding: .2rem .6rem; border-radius: 999px; font-size: .72rem; font-weight: 600; }
    .mc-badge-active { background: #dcfce7; color: #166534; }
    .mc-badge-inactive { background: #fee2e2; color: #991b1b; }
    .mc-actions { display: flex; gap: .4rem; flex-wrap: wrap; }

    .mc-alert { padding: .75rem 1rem; border-radius: .5rem; margin-bottom: 1rem; font-size: .875rem; }
    .mc-alert-success { background: #dcfce7; color: #166534; }
    .mc-alert-error { background: #fee2e2; color: #991b1b; }

    /* Side panel (off-canvas drawer) */
    .mc-panel-backdrop {
        display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45);
        z-index: 999;
    }
    .mc-panel-backdrop.is-open { display: block; }

    .mc-panel {
        position: fixed; top: 0; right: -100%; height: 100vh; width: 100%; max-width: 440px;
        background: #fff; z-index: 1000; box-shadow: -12px 0 32px rgba(0,0,0,.18);
        display: flex; flex-direction: column; transition: right .28s ease;
    }
    .mc-panel.mc-panel-lg { max-width: 560px; }
    .mc-panel.is-open { right: 0; }

    .mc-panel-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 1.1rem 1.25rem; border-bottom: 1px solid var(--mc-border); flex-shrink: 0;
    }
    .mc-panel-header h3 { margin: 0; font-size: 1.05rem; }
    .mc-panel-close { background: none; border: none; font-size: 1.4rem; cursor: pointer; color: var(--mc-muted); line-height: 1; }
    .mc-panel-body { padding: 1.25rem; overflow-y: auto; flex: 1; }
    .mc-panel-footer { display: flex; justify-content: flex-end; gap: .6rem; padding: 1rem 1.25rem; border-top: 1px solid var(--mc-border); flex-shrink: 0; }

    .mc-field { margin-bottom: 1rem; }
    .mc-field label { display: block; font-size: .8rem; font-weight: 600; margin-bottom: .35rem; color: var(--mc-muted); }
    .mc-field input[type="text"], .mc-field input[type="number"] { width: 100%; padding: .55rem .7rem; border: 1px solid var(--mc-border); border-radius: .45rem; font-size: .875rem; }
    .mc-field-inline { display: flex; align-items: center; gap: .5rem; }
    .mc-error { color: var(--mc-danger); font-size: .75rem; margin-top: .25rem; }

    .mc-sub-list { list-style: none; margin: 0 0 1.25rem; padding: 0; border: 1px solid var(--mc-border); border-radius: .5rem; overflow: hidden; }
    .mc-sub-row { padding: .6rem .8rem; border-bottom: 1px solid var(--mc-border); font-size: .875rem; }
    .mc-sub-row:last-child { border-bottom: none; }
    .mc-sub-row-view { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }
    .mc-sub-row-view .mc-sub-name { flex: 1; min-width: 80px; }
    .mc-sub-edit-form { display: none; margin-top: .6rem; padding-top: .6rem; border-top: 1px dashed var(--mc-border); }
    .mc-sub-edit-form.is-open { display: block; }
    .mc-sub-edit-form input[type="text"] { width: 100%; padding: .4rem .6rem; border: 1px solid var(--mc-border); border-radius: .4rem; font-size: .82rem; margin-bottom: .5rem; }
    .mc-sub-empty { padding: 1rem; text-align: center; color: var(--mc-muted); font-size: .85rem; }
    .mc-add-sub-form { display: flex; gap: .5rem; }
    .mc-add-sub-form input[type="text"] { flex: 1; padding: .55rem .7rem; border: 1px solid var(--mc-border); border-radius: .45rem; font-size: .875rem; }
</style>

<div class="mc-header">
    <h1 class="mc-title">Material Categories</h1>
    <button type="button" class="mc-btn" onclick="openCategoryPanel()">+ Add Category</button>
</div>

@if (session('success'))
    <div class="mc-alert mc-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mc-alert mc-alert-error">{{ session('error') }}</div>
@endif

<div class="mc-table-wrap">
    <table class="mc-table">
        <thead>
            <tr>
                <th style="width:60px">Icon</th>
                <th>Name</th>
                <th>Slug</th>
                <th style="width:100px">Order</th>
                <th style="width:110px">Subcats</th>
                <th style="width:100px">Status</th>
                <th style="width:260px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td><div class="mc-icon-cell">{{ $category->icon ?? '📦' }}</div></td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->order }}</td>
                    <td>{{ $category->material_subcategories_count }}</td>
                    <td>
                        <span class="mc-badge {{ $category->is_active ? 'mc-badge-active' : 'mc-badge-inactive' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="mc-actions">
                            <button type="button" class="mc-btn mc-btn-outline mc-btn-sm"
                                onclick='openCategoryPanel(@json($category))'>Edit</button>

                            <button type="button" class="mc-btn mc-btn-ghost mc-btn-sm"
                                onclick="openPanel('subPanel-{{ $category->id }}')">
                                Subcategories
                            </button>

                            <form action="{{ route('admin.materials-categories.destroy', $category) }}" method="POST"
                                  onsubmit="return confirm('Delete this category? This cannot be undone.');" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="mc-btn mc-btn-danger mc-btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center; padding:2rem; color:var(--mc-muted);">No categories yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mc-panel-backdrop" id="mcBackdrop" onclick="closeAllPanels()"></div>

{{-- ===== Create / Edit Category Side Panel ===== --}}
<div class="mc-panel" id="categoryPanel">
    <div class="mc-panel-header">
        <h3 id="categoryPanelTitle">Add Category</h3>
        <button type="button" class="mc-panel-close" onclick="closePanel('categoryPanel')">&times;</button>
    </div>
    <form id="categoryForm" method="POST" action="{{ route('admin.materials-categories.store') }}" style="display:flex; flex-direction:column; flex:1; min-height:0;">
        @csrf
        <input type="hidden" name="_method" id="categoryFormMethod" value="">
        <div class="mc-panel-body">
            <div class="mc-field">
                <label for="cat_name">Name</label>
                <input type="text" id="cat_name" name="name" required value="{{ old('name') }}">
                @error('name') <div class="mc-error">{{ $message }}</div> @enderror
            </div>
            <div class="mc-field">
                <label for="cat_icon">Icon (emoji or class name)</label>
                <input type="text" id="cat_icon" name="icon" value="{{ old('icon') }}">
            </div>
            <div class="mc-field">
                <label for="cat_order">Order</label>
                <input type="number" id="cat_order" name="order" min="0" value="{{ old('order', 0) }}">
            </div>
            <div class="mc-field mc-field-inline">
                <input type="checkbox" id="cat_is_active" name="is_active" value="1" checked>
                <label for="cat_is_active" style="margin:0;">Active</label>
            </div>
        </div>
        <div class="mc-panel-footer">
            <button type="button" class="mc-btn mc-btn-ghost" onclick="closePanel('categoryPanel')">Cancel</button>
            <button type="submit" class="mc-btn">Save Category</button>
        </div>
    </form>
</div>

{{-- ===== Per-category Subcategories Side Panel ===== --}}
@foreach ($categories as $category)
    <div class="mc-panel mc-panel-lg" id="subPanel-{{ $category->id }}">
        <div class="mc-panel-header">
            <h3>Subcategories &ndash; {{ $category->name }}</h3>
            <button type="button" class="mc-panel-close" onclick="closePanel('subPanel-{{ $category->id }}')">&times;</button>
        </div>
        <div class="mc-panel-body">
            <ul class="mc-sub-list">
                @forelse ($category->materialSubcategories as $sub)
                    <li class="mc-sub-row">
                        <div class="mc-sub-row-view">
                            <span class="mc-sub-name">{{ $sub->name }}</span>
                            <span class="mc-badge {{ $sub->is_active ? 'mc-badge-active' : 'mc-badge-inactive' }}">
                                {{ $sub->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <button type="button" class="mc-btn mc-btn-outline mc-btn-sm"
                                onclick="document.getElementById('subEdit-{{ $sub->id }}').classList.toggle('is-open')">
                                Edit
                            </button>
                            <form action="{{ route('admin.materials-categories.subcategories.destroy', ['materialsCategoryId' => $category->id, 'subcategory' => $sub->id]) }}"
                                  method="POST" onsubmit="return confirm('Delete this subcategory?');" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="mc-btn mc-btn-danger mc-btn-sm">Delete</button>
                            </form>
                        </div>

                        <form id="subEdit-{{ $sub->id }}" class="mc-sub-edit-form"
                              action="{{ route('admin.materials-categories.subcategories.update', ['materialsCategoryId' => $category->id, 'subcategory' => $sub->id]) }}"
                              method="POST">
                            @csrf @method('PUT')
                            <input type="text" name="name" value="{{ $sub->name }}" required>
                            <div class="mc-field-inline" style="margin-bottom:.5rem;">
                                <input type="checkbox" id="subActive-{{ $sub->id }}" name="is_active" value="1" {{ $sub->is_active ? 'checked' : '' }}>
                                <label for="subActive-{{ $sub->id }}" style="margin:0;">Active</label>
                            </div>
                            <button type="submit" class="mc-btn mc-btn-sm">Save</button>
                        </form>
                    </li>
                @empty
                    <li class="mc-sub-empty">No subcategories yet.</li>
                @endforelse
            </ul>

            <form class="mc-add-sub-form"
                  action="{{ route('admin.materials-categories.subcategories.store', ['materialsCategoryId' => $category->id]) }}"
                  method="POST">
                @csrf
                <input type="hidden" name="is_active" value="1">
                <input type="text" name="name" placeholder="New subcategory name" required>
                <button type="submit" class="mc-btn mc-btn-sm">Add</button>
            </form>
        </div>
        <div class="mc-panel-footer">
            <button type="button" class="mc-btn mc-btn-ghost" onclick="closePanel('subPanel-{{ $category->id }}')">Close</button>
        </div>
    </div>
@endforeach

<script>
(function () {
    function backdrop() {
        return document.getElementById('mcBackdrop');
    }

    window.openPanel = function (id) {
        var el = document.getElementById(id);
        if (!el) return;
        el.classList.add('is-open');
        backdrop().classList.add('is-open');
    };

    window.closePanel = function (id) {
        var el = document.getElementById(id);
        if (el) el.classList.remove('is-open');
        if (!document.querySelector('.mc-panel.is-open')) {
            backdrop().classList.remove('is-open');
        }
    };

    window.closeAllPanels = function () {
        document.querySelectorAll('.mc-panel.is-open').forEach(function (el) {
            el.classList.remove('is-open');
        });
        backdrop().classList.remove('is-open');
    };

    window.openCategoryPanel = function (category) {
        const form = document.getElementById('categoryForm');
        const title = document.getElementById('categoryPanelTitle');
        const methodField = document.getElementById('categoryFormMethod');

        form.reset();

        if (category && category.id) {
            title.textContent = 'Edit Category';
            form.action = "{{ route('admin.materials-categories.update', ['materialsCategory' => '__ID__']) }}".replace('__ID__', category.id);
            methodField.value = 'PUT';
            document.getElementById('cat_name').value = category.name ?? '';
            document.getElementById('cat_icon').value = category.icon ?? '';
            document.getElementById('cat_order').value = category.order ?? 0;
            document.getElementById('cat_is_active').checked = !!category.is_active;
        } else {
            title.textContent = 'Add Category';
            form.action = "{{ route('admin.materials-categories.store') }}";
            methodField.value = '';
            document.getElementById('cat_is_active').checked = true;
        }

        openPanel('categoryPanel');
    };

    // Reopen the subcategories panel after a redirect (e.g. after add/edit/delete)
    @if (session('open_subcategories'))
        document.addEventListener('DOMContentLoaded', function () {
            openPanel('subPanel-{{ session('open_subcategories') }}');
        });
    @endif

    // Reopen category panel on validation error
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            openCategoryPanel({
                id: null,
                name: @json(old('name')),
                icon: @json(old('icon')),
                order: @json(old('order', 0)),
                is_active: {{ old('is_active') ? 'true' : 'false' }},
            });
        });
    @endif
})();
</script>
</div>
@endsection