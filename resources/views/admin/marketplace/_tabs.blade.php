{{--
    Filter tabs that keep the other query params.
    Expects $param, $options [query value => label] ('' = no param), $current; optional $counts [value => n]
--}}
<nav class="tp-box-tabs" aria-label="Filter">
    @foreach ($options as $value => $label)
        @php $query = array_merge(request()->except(['page', $param]), $value === '' ? [] : [$param => $value]); @endphp
        <a href="{{ request()->url() . ($query ? '?' . http_build_query($query) : '') }}" class="{{ (string) $current === (string) $value ? 'is-active' : '' }}">
            {{ $label }}@if (!empty($counts[$value])) <small>{{ $counts[$value] }}</small>@endif
        </a>
    @endforeach
</nav>
