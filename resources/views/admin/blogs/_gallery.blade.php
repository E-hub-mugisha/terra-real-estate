{{-- ─── Gallery Images ──────────────────────────────────────────────────────── --}}
<div class="card bg-base-100 border border-base-300 rounded-xl">
    <div class="card-body p-6 space-y-5">
        <h3 class="font-semibold text-base-content flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Gallery Images
        </h3>

        {{-- Existing images (edit only) --}}
        @if(isset($blog) && $blog->images->isNotEmpty())
            <div>
                <p class="text-xs text-base-content/50 mb-3 uppercase tracking-wide font-medium">Existing — check to delete</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3" id="existing-gallery">
                    @foreach($blog->images as $img)
                        <div class="relative group rounded-lg overflow-hidden border border-base-300 bg-base-200">
                            <img src="{{asset('image/blogs/')}}/{{ $img->image_path }}"
                                 alt="{{ $img->caption }}"
                                 class="w-full h-28 object-cover">

                            {{-- Delete toggle --}}
                            <label class="absolute top-1.5 right-1.5 cursor-pointer">
                                <input type="checkbox"
                                       name="delete_images[]"
                                       value="{{ $img->id }}"
                                       class="peer hidden gallery-delete-cb">
                                <span class="flex items-center justify-center w-6 h-6 rounded-full
                                             bg-base-100/80 peer-checked:bg-error text-base-content
                                             peer-checked:text-white transition-all shadow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </span>
                            </label>

                            {{-- Delete overlay --}}
                            <div class="absolute inset-0 bg-error/20 opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></div>

                            @if($img->caption)
                                <p class="absolute bottom-0 inset-x-0 text-[10px] text-white bg-black/50 px-2 py-1 truncate">
                                    {{ $img->caption }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="divider my-1"></div>
        @endif

        {{-- Upload new images --}}
        <div>
            @if(isset($blog) && $blog->images->isNotEmpty())
                <p class="text-xs text-base-content/50 mb-3 uppercase tracking-wide font-medium">Add New Images</p>
            @endif

            {{-- Drop zone --}}
            <label id="gallery-dropzone"
                   class="flex flex-col items-center justify-center gap-3 border-2 border-dashed border-base-300
                          rounded-xl p-8 cursor-pointer hover:border-primary hover:bg-primary/5 transition-all">
                <input type="file"
                       id="gallery-input"
                       name="gallery_images[]"
                       accept="image/jpg,image/jpeg,image/png,image/webp"
                       multiple
                       class="hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-base-content/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <div class="text-center">
                    <p class="text-sm font-medium text-base-content">Drop images here or <span class="text-primary">browse</span></p>
                    <p class="text-xs text-base-content/40 mt-1">JPG, PNG, WEBP · Max 3 MB each · Up to 10 images</p>
                </div>
            </label>

            {{-- New image previews --}}
            <div id="gallery-preview" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mt-4 empty:hidden"></div>
        </div>
    </div>
</div>


<script>
(function () {
    const input    = document.getElementById('gallery-input');
    const preview  = document.getElementById('gallery-preview');
    const dropzone = document.getElementById('gallery-dropzone');

    if (!input) return;

    // Track files across multiple selections
    let fileList = new DataTransfer();

    function renderPreviews() {
        preview.innerHTML = '';
        Array.from(fileList.files).forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrap = document.createElement('div');
                wrap.className = 'relative group rounded-lg overflow-hidden border border-base-300 bg-base-200';
                wrap.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-28 object-cover" alt="">
                    <button type="button" data-idx="${idx}"
                        class="remove-gallery-img absolute top-1.5 right-1.5 w-6 h-6 rounded-full
                               bg-error text-white flex items-center justify-center shadow text-xs
                               opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                    <div class="absolute bottom-0 inset-x-0 px-2 py-1 bg-black/40">
                        <input type="text" name="gallery_captions[]" placeholder="Caption…"
                               class="w-full bg-transparent text-white text-[10px] outline-none placeholder-white/50">
                    </div>`;
                preview.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        });
    }

    function syncInput() {
        input.files = fileList.files;
    }

    input.addEventListener('change', () => {
        Array.from(input.files).forEach(f => fileList.items.add(f));
        syncInput();
        renderPreviews();
    });

    preview.addEventListener('click', e => {
        const btn = e.target.closest('.remove-gallery-img');
        if (!btn) return;

        const idx  = parseInt(btn.dataset.idx);
        const fresh = new DataTransfer();
        Array.from(fileList.files).forEach((f, i) => i !== idx && fresh.items.add(f));
        fileList = fresh;
        syncInput();
        renderPreviews();
    });

    // Drag & drop
    dropzone.addEventListener('dragover',  e => { e.preventDefault(); dropzone.classList.add('border-primary', 'bg-primary/5'); });
    dropzone.addEventListener('dragleave', () => dropzone.classList.remove('border-primary', 'bg-primary/5'));
    dropzone.addEventListener('drop', e => {
        e.preventDefault();
        dropzone.classList.remove('border-primary', 'bg-primary/5');
        Array.from(e.dataTransfer.files)
            .filter(f => f.type.startsWith('image/'))
            .forEach(f => fileList.items.add(f));
        syncInput();
        renderPreviews();
    });

    // Overlay feedback for delete checkboxes on existing images
    document.querySelectorAll('.gallery-delete-cb').forEach(cb => {
        cb.addEventListener('change', () => {
            const card = cb.closest('.relative');
            card.querySelector('img').classList.toggle('opacity-40', cb.checked);
        });
    });
})();
</script>
