@extends('layouts.app')
@section('title', 'Edit Post — ' . $blog->title)
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--rose:#e11d48;--rose-lt:#fb7185;--green:#22c55e;--amber:#f59e0b;}
    .be-page{padding:1.75rem 0 3rem;max-width:1100px;margin:0 auto;}
    .be-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .be-breadcrumb a{color:var(--muted);text-decoration:none;}.be-breadcrumb a:hover{color:var(--rose);}
    .be-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;flex-wrap:wrap;}
    .be-heading-avatar{width:48px;height:48px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#fce7f3,#fbe2e7);border:1px solid #fbcfe8;display:flex;align-items:center;justify-content:center;color:var(--rose);}
    .be-heading h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .be-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .be-heading-meta{margin-left:auto;display:flex;align-items:center;gap:.6rem;}
    .be-badge{display:inline-flex;align-items:center;gap:.3rem;padding:.24rem .7rem;border-radius:100px;font-size:.7rem;font-weight:600;border:1px solid;}
    .be-badge-pub{color:#166534;border-color:#bbf7d0;background:#f0fdf4;}
    .be-badge-draft{color:#92400e;border-color:#fde68a;background:#fffbeb;}
    .be-layout{display:grid;grid-template-columns:1fr 280px;gap:1.25rem;align-items:start;}
    .be-main{display:flex;flex-direction:column;gap:1.25rem;}
    .be-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .be-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .be-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .be-card-header-icon{width:32px;height:32px;border-radius:8px;background:#fce7f318;display:flex;align-items:center;justify-content:center;color:var(--rose);flex-shrink:0;}
    .be-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .be-card-body{padding:1.5rem;}
    .be-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .be-label .req{color:var(--danger);margin-left:.2rem;}
    .be-input,.be-select,.be-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .be-input:focus,.be-select:focus,.be-textarea:focus{border-color:var(--rose);box-shadow:0 0 0 3px rgba(225,29,72,.08);}
    .be-input.is-invalid{border-color:var(--danger);}
    .be-textarea{resize:vertical;line-height:1.7;}
    .be-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .be-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;display:flex;align-items:center;gap:.3rem;}
    .be-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .be-gap{display:flex;flex-direction:column;gap:1rem;}
    .be-slug-wrap{position:relative;}
    .be-slug-prefix{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);font-size:.82rem;color:var(--muted);pointer-events:none;font-family:monospace;}
    .be-slug-input{padding-left:5.5rem!important;font-family:monospace;font-size:.85rem;}
    /* image */
    .be-current-img{width:100%;height:140px;object-fit:cover;display:block;border-radius:8px;margin-bottom:.85rem;}
    .be-current-initials{width:100%;height:80px;background:linear-gradient(135deg,#fce7f3,#fbe2e7);display:flex;align-items:center;justify-content:center;color:var(--rose-lt);border-radius:8px;margin-bottom:.85rem;}
    .be-img-upload{border:2px dashed var(--border);border-radius:10px;padding:1.25rem;background:var(--surface);cursor:pointer;transition:border-color .2s,background .2s;position:relative;text-align:center;}
    .be-img-upload:hover{border-color:var(--rose);background:#fce7f304;}
    .be-img-upload input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
    .be-new-preview{display:none;border-radius:8px;overflow:hidden;margin-top:.75rem;position:relative;}
    .be-new-preview img{width:100%;height:120px;object-fit:cover;display:block;}
    .be-new-preview-remove{position:absolute;top:5px;right:5px;width:22px;height:22px;border-radius:50%;background:rgba(0,0,0,.6);border:none;color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:10px;}
    /* alerts */
    .be-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .be-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .be-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .be-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .be-alert li{margin-bottom:.2rem;}
    /* submit */
    .be-submit-bar{display:flex;align-items:center;justify-content:space-between;gap:.75rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .be-submit-bar-left{font-size:.78rem;color:var(--muted);display:flex;align-items:center;gap:.4rem;}
    .be-submit-bar-right{display:flex;gap:.6rem;}
    .be-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .be-btn-primary{background:var(--rose);color:#fff;}.be-btn-primary:hover{background:var(--rose-lt);color:#fff;transform:translateY(-1px);}
    .be-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.be-btn-ghost:hover{border-color:var(--rose);color:var(--rose);}
    .be-btn-danger{background:none;border:1.5px solid #fecaca;color:var(--danger);}.be-btn-danger:hover{background:#fef2f2;}
    .be-btn-sm{padding:.42rem .9rem;font-size:.78rem;}
    /* switch */
    .be-switch{position:relative;width:38px;height:22px;flex-shrink:0;}
    .be-switch input{opacity:0;width:0;height:0;}
    .be-switch-track{position:absolute;inset:0;background:var(--border);border-radius:100px;cursor:pointer;transition:background .2s;}
    .be-switch-track::before{content:'';position:absolute;width:16px;height:16px;border-radius:50%;background:#fff;top:3px;left:3px;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.2);}
    .be-switch input:checked+.be-switch-track{background:var(--rose);}
    .be-switch input:checked+.be-switch-track::before{transform:translateX(16px);}
    .be-toggle-row{display:flex;align-items:center;justify-content:space-between;padding:.6rem 0;}
    .be-toggle-label{font-size:.84rem;font-weight:500;color:var(--text);}
    .be-toggle-desc{font-size:.73rem;color:var(--muted);margin-top:.1rem;}
    @media(max-width:900px){.be-layout{grid-template-columns:1fr;}.be-side{position:static;}.be-row-2{grid-template-columns:1fr;}}

    .ck-editor__editable { min-height: 380px; }
    /* Dark-theme aware border */
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: hsl(var(--bc) / 0.2) !important;
    }
</style>

<div class="be-page">
    <nav class="be-breadcrumb">
        <a href="{{ route('admin.blogs.index') }}">Blog Posts</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <a href="{{ route('admin.blogs.show',$blog->id) }}">{{ Str::limit($blog->title,40) }}</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">Edit</span>
    </nav>

    <div class="be-heading">
        <div class="be-heading-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
        <div>
            <h4>Edit Post</h4>
            <p>{{ Str::limit($blog->title,60) }} — last updated {{ $blog->updated_at->diffForHumans() }}</p>
        </div>
        <div class="be-heading-meta">
            <span class="be-badge {{ $blog->is_published ? 'be-badge-pub' : 'be-badge-draft' }}">{{ $blog->is_published ? 'Published' : 'Draft' }}</span>
            <a href="{{ route('admin.blogs.show',$blog->id) }}" class="be-btn be-btn-ghost be-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                View
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="be-alert be-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif
    @if(session('success'))
        <div class="be-alert be-alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M20 6 9 17l-5-5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.blogs.update',$blog->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="be-layout">
            <div class="be-main">

                {{-- Content --}}
                <div class="be-card">
                    <div class="be-card-header">
                        <div class="be-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                        <h6>Post Content</h6>
                    </div>
                    <div class="be-card-body">
                        <div class="be-gap">
                            <div>
                                <label class="be-label">Title <span class="req">*</span></label>
                                <input type="text" name="title" class="be-input @error('title') is-invalid @enderror" value="{{ old('title',$blog->title) }}" required>
                                @error('title')<p class="be-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="be-label">Slug</label>
                                <div class="be-slug-wrap">
                                    <span class="be-slug-prefix">blog/</span>
                                    <input type="text" name="slug" class="be-input be-slug-input @error('slug') is-invalid @enderror" value="{{ old('slug',$blog->slug) }}">
                                </div>
                                @error('slug')<p class="be-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="be-label">Content <span class="req">*</span></label>
                                <textarea name="content" id="contentTextarea" rows="16" class="be-textarea @error('content') is-invalid @enderror">{{ old('content',$blog->content) }}</textarea>
                                @error('content')<p class="be-error">{{ $message }}</p>@enderror
                                <p class="be-hint" id="wordCount" style="text-align:right">
                                    {{ str_word_count(strip_tags($blog->content)) }} words
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="be-submit-bar">
                    <div class="be-submit-bar-left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Last saved {{ $blog->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div class="be-submit-bar-right">
                        <a href="{{ route('admin.blogs.show',$blog->id) }}" class="be-btn be-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                            Cancel
                        </a>
                        <button type="submit" class="be-btn be-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="be-side">

                {{-- Featured image --}}
                <div class="be-card">
                    <div class="be-card-header">
                        <div class="be-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg></div>
                        <h6>Featured Image</h6>
                    </div>
                    <div class="be-card-body">
                        @if($blog->featured_image)
                            <img src="{{asset('image/blogs/')}}/{{ $blog->featured_image }}" alt="{{ $blog->title }}" class="be-current-img">
                        @else
                            <div class="be-current-initials">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            </div>
                        @endif
                        <div class="be-img-upload">
                            <input type="file" name="featured_image" id="imgInput" accept="image/*">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--rose);margin-bottom:.4rem"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                            <p style="font-size:.83rem;font-weight:600;color:var(--text);margin:0 0 .2rem">{{ $blog->featured_image ? 'Replace image' : 'Upload image' }}</p>
                            <p style="font-size:.74rem;color:var(--muted);margin:0">JPG, PNG, WEBP — max 3MB</p>
                        </div>
                        <div class="be-new-preview" id="newPreviewBox">
                            <img id="newPreviewImg" src="" alt="New image">
                            <button type="button" class="be-new-preview-remove" onclick="clearNewImg()">✕</button>
                        </div>
                        @error('featured_image')<p class="be-error" style="margin-top:.5rem">{{ $message }}</p>@enderror
                    </div>
                </div>

                @include('admin.blogs._gallery')

                {{-- Settings --}}
                <div class="be-card">
                    <div class="be-card-header">
                        <div class="be-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg></div>
                        <h6>Post Settings</h6>
                    </div>
                    <div class="be-card-body">
                        <div class="be-gap">
                            <div>
                                <label class="be-label">Category</label>
                                <select name="blog_category_id" class="be-select @error('blog_category_id') is-invalid @enderror">
                                    <option value="">No category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('blog_category_id',$blog->blog_category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('blog_category_id')<p class="be-error">{{ $message }}</p>@enderror
                            </div>
                            <div class="be-toggle-row">
                                <div>
                                    <div class="be-toggle-label">Published</div>
                                    <div class="be-toggle-desc">Visible to public</div>
                                </div>
                                <label class="be-switch">
                                    <input type="checkbox" name="is_published" value="1" {{ old('is_published',$blog->is_published)?'checked':'' }}>
                                    <span class="be-switch-track"></span>
                                </label>
                            </div>
                            <div>
                                <label class="be-label">Publish Date</label>
                                <input type="datetime-local" name="published_at" class="be-input @error('published_at') is-invalid @enderror"
                                    value="{{ old('published_at', $blog->published_at?->format('Y-m-d\TH:i')) }}">
                                @error('published_at')<p class="be-error">{{ $message }}</p>@enderror
                            </div>
                            <div style="padding:.75rem;border-radius:8px;background:var(--surface);border:1px solid var(--border);font-size:.79rem;color:var(--text-dim);">
                                <div style="display:flex;justify-content:space-between;margin-bottom:.35rem;"><span style="color:var(--muted)">Author</span><span>{{ $blog->author?->name ?? '—' }}</span></div>
                                <div style="display:flex;justify-content:space-between;margin-bottom:.35rem;"><span style="color:var(--muted)">Created</span><span>{{ $blog->created_at->format('M j, Y') }}</span></div>
                                <div style="display:flex;justify-content:space-between;"><span style="color:var(--muted)">Words</span><span id="wordCount">{{ str_word_count(strip_tags($blog->content)) }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('contentTextarea').addEventListener('input',function(){
    const words=this.value.trim().split(/\s+/).filter(w=>w).length;
    document.getElementById('wordCount').textContent=words;
});
document.getElementById('imgInput').addEventListener('change',function(){
    const file=this.files[0];if(!file)return;
    const reader=new FileReader();
    reader.onload=e=>{
        document.getElementById('newPreviewImg').src=e.target.result;
        document.getElementById('newPreviewBox').style.display='block';
    };reader.readAsDataURL(file);
});
function clearNewImg(){
    document.getElementById('imgInput').value='';
    document.getElementById('newPreviewBox').style.display='none';
}
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#contentTextarea'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'link', 'blockQuote', 'code', 'codeBlock', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'insertTable', '|',
                'imageUpload', 'mediaEmbed', '|',
                'outdent', 'indent', '|',
                'undo', 'redo'
            ]
        },
        image: {
            toolbar: ['imageTextAlternative', 'toggleImageCaption', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
        },
        table: {
            contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
        }
    })
    .catch(console.error);
</script>
@endsection