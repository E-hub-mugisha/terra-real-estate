{{-- resources/views/vendor/pagination/terra.blade.php --}}
@if ($paginator->hasPages())
    <nav style="display:flex; gap:.4rem; align-items:center; flex-wrap:wrap;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="al-page-btn al-page-disabled">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="al-page-btn">&lsaquo;</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="al-page-btn al-page-disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="al-page-btn al-page-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="al-page-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="al-page-btn">&rsaquo;</a>
        @else
            <span class="al-page-btn al-page-disabled">&rsaquo;</span>
        @endif

    </nav>

    <style>
        .al-page-btn      { font-family:'DM Sans',sans-serif; font-size:.78rem; font-weight:500; color:#19265d; border:1px solid #dde0ee; border-radius:5px; padding:.3rem .65rem; text-decoration:none; transition:border-color .15s,background .15s; }
        .al-page-btn:hover        { border-color:#C8873A; color:#C8873A; }
        .al-page-active   { background:#19265d; color:#fff !important; border-color:#19265d; }
        .al-page-disabled { color:#c0c5d8; border-color:#eef0f8; cursor:default; }
    </style>
@endif