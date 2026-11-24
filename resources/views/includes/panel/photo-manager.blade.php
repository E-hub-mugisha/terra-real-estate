{{--
    Photo manager for listing edit forms (inside the main <form>).
    Existing photos can be marked for removal (delete_images[]); new ones are previewed before upload (images[]).
    Expects: $images (collection with id + image_path), $dir ('image/houses' | 'image/lands'), $downloadUrl
--}}
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span>Photos <span class="tu-badge ms-1" id="photoCount">{{ $images->count() }}</span></span>
        @if ($images->isNotEmpty())
            <a href="{{ $downloadUrl }}" class="btn btn-sm btn-light"><x-tu-icon name="download" size="15" /> Download all</a>
        @endif
    </div>
    <div class="card-body">
        <p class="text-muted small mb-3">The first photo is used as the cover. Click a photo to mark it for removal — nothing is deleted until you save.</p>

        <div class="tp-photos" id="photoGrid">
            @foreach ($images as $i => $img)
                <label class="tp-photo" title="Click to remove">
                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="tp-photo-check">
                    <img src="{{ asset($dir . '/' . $img->image_path) }}" alt="Photo {{ $i + 1 }}" loading="lazy"
                        onerror="this.style.opacity=.25">
                    @if ($i === 0)<span class="tp-photo-tag">Cover</span>@endif
                    <span class="tp-photo-remove"><x-tu-icon name="x" size="14" /> Remove</span>
                </label>
            @endforeach

            <label class="tp-photo tp-photo-add" for="photoInput">
                <x-tu-icon name="plus" size="22" />
                <span>Add photos</span>
                <small>JPG, PNG, WebP · max 5 MB each</small>
            </label>
        </div>
        <input type="file" id="photoInput" name="images[]" accept="image/jpeg,image/png,image/webp" multiple class="d-none">
        @error('images')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
        @error('images.*')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
    </div>
</div>

@push('scripts')
<script>
    (function () {
        const input = document.getElementById('photoInput');
        const grid = document.getElementById('photoGrid');
        const addTile = grid.querySelector('.tp-photo-add');
        const count = document.getElementById('photoCount');
        let files = new DataTransfer();

        const refreshCount = () => {
            const kept = grid.querySelectorAll('.tp-photo-check:not(:checked)').length;
            count.textContent = kept + files.files.length;
        };

        grid.addEventListener('change', (e) => {
            if (e.target.classList.contains('tp-photo-check')) {
                e.target.closest('.tp-photo').classList.toggle('is-removed', e.target.checked);
                refreshCount();
            }
        });

        input.addEventListener('change', () => {
            Array.from(input.files).forEach(file => {
                if (file.size > 5 * 1024 * 1024) {
                    window.Swal ? Swal.fire({ icon: 'warning', title: 'Photo too large', text: file.name + ' is over 5 MB.' }) : alert(file.name + ' is over 5 MB.');
                    return;
                }
                files.items.add(file);
                const tile = document.createElement('div');
                tile.className = 'tp-photo is-new';
                tile.innerHTML = '<img alt=""><span class="tp-photo-tag">New</span><button type="button" class="tp-photo-remove">Undo</button>';
                tile.querySelector('img').src = URL.createObjectURL(file);
                tile.querySelector('button').addEventListener('click', () => {
                    const next = new DataTransfer();
                    Array.from(files.files).filter(f => f !== file).forEach(f => next.items.add(f));
                    files = next;
                    input.files = files.files;
                    tile.remove();
                    refreshCount();
                });
                grid.insertBefore(tile, addTile);
            });
            input.files = files.files;
            refreshCount();
        });
    })();
</script>
@endpush
