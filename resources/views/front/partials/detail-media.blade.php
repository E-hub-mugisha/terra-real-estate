{{-- Video tour + map panels. Expects optional $video, $lat, $lng, $address --}}
@php
    $embed = null;
    $file = null;
    if (!empty($video)) {
        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([\w-]{11})~', $video, $m)) {
            $embed = 'https://www.youtube.com/embed/' . $m[1];
        } elseif (preg_match('~vimeo\.com/(\d+)~', $video, $m)) {
            $embed = 'https://player.vimeo.com/video/' . $m[1];
        } elseif (preg_match('~\.(mp4|webm|ogg|mov)(\?|$)~i', $video)) {
            $file = $video;
        }
    }
    $hasMap = !empty($lat) && !empty($lng);
@endphp

@if (!empty($video))
    <div class="tu-panel">
        <h2 class="tu-panel-title">Video tour</h2>
        @if ($embed)
            <div class="tu-embed"><iframe src="{{ $embed }}" title="Video tour" loading="lazy" allowfullscreen allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"></iframe></div>
        @elseif ($file)
            <div class="tu-embed"><video src="{{ $file }}" controls preload="metadata"></video></div>
        @else
            <a href="{{ $video }}" target="_blank" rel="noopener" class="tu-btn"><x-tu-icon name="video" /> Watch the video</a>
        @endif
    </div>
@endif

@if ($hasMap || !empty($address))
    <div class="tu-panel">
        <h2 class="tu-panel-title">Location</h2>
        @if (!empty($address))
            <p style="display:flex;gap:8px;align-items:center;margin:0 0 14px;color:var(--tu-muted)"><x-tu-icon name="pin" size="16" /> {{ $address }}</p>
        @endif
        @if ($hasMap)
            <div class="tu-embed" style="aspect-ratio:16/8">
                <iframe src="https://www.google.com/maps?q={{ $lat }},{{ $lng }}&z=15&output=embed" title="Map" loading="lazy"></iframe>
            </div>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $lat }},{{ $lng }}" target="_blank" rel="noopener" class="tu-link-arrow" style="margin-top:12px">Get directions <x-tu-icon name="external" /></a>
        @endif
    </div>
@endif
