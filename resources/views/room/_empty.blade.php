{{-- Empty state. Expects $icon, $title, $text; optional $action [label, url] --}}
<div class="card">
    <div class="tu-empty" style="padding:56px 20px">
        <div class="tu-empty-ico"><x-tu-icon :name="$icon" /></div>
        <h3>{{ $title }}</h3>
        <p>{{ $text }}</p>
        @isset($action)
            <a href="{{ $action[1] }}" class="tu-btn tu-btn-primary">{{ $action[0] }}</a>
        @endisset
    </div>
</div>
