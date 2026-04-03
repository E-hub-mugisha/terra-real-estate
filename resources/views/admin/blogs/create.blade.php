{{-- ================================================================
     SAVE AS: resources/views/admin/blogs/create.blade.php
     ================================================================ --}}
@extends('layouts.app')
@section('title', 'New News Post')
@section('content')

<style>
    :root{--accent:#c9a96e;--danger:#dc3545;--border:#e2e8f0;--surface:#f8fafc;--muted:#94a3b8;--text:#1e293b;--text-dim:#64748b;--radius:10px;--rose:#e11d48;--rose-lt:#fb7185;--green:#22c55e;--amber:#f59e0b;}
    .bc-page{padding:1.75rem 0 3rem;max-width:1100px;margin:0 auto;}
    .bc-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.78rem;color:var(--muted);margin-bottom:1.5rem;}
    .bc-breadcrumb a{color:var(--muted);text-decoration:none;}.bc-breadcrumb a:hover{color:var(--rose);}
    .bc-heading{display:flex;align-items:center;gap:1rem;margin-bottom:2rem;}
    .bc-heading-icon{width:48px;height:48px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,#fce7f3,#fbe2e7);border:1px solid #fbcfe8;display:flex;align-items:center;justify-content:center;color:var(--rose);}
    .bc-heading h4{font-size:1.2rem;font-weight:700;color:var(--text);margin:0;}
    .bc-heading p{font-size:.82rem;color:var(--text-dim);margin:.15rem 0 0;}
    .bc-layout{display:grid;grid-template-columns:1fr 280px;gap:1.25rem;align-items:start;}
    .bc-main{display:flex;flex-direction:column;gap:1.25rem;}
    .bc-side{display:flex;flex-direction:column;gap:1.25rem;position:sticky;top:80px;}
    .bc-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .bc-card-header{display:flex;align-items:center;gap:.75rem;padding:1rem 1.5rem;border-bottom:1px solid var(--border);background:var(--surface);}
    .bc-card-header-icon{width:32px;height:32px;border-radius:8px;background:#fce7f318;display:flex;align-items:center;justify-content:center;color:var(--rose);flex-shrink:0;}
    .bc-card-header h6{margin:0;font-size:.88rem;font-weight:600;color:var(--text);}
    .bc-card-body{padding:1.5rem;}
    .bc-label{display:block;font-size:.77rem;font-weight:600;letter-spacing:.03em;color:var(--text-dim);text-transform:uppercase;margin-bottom:.45rem;}
    .bc-label .req{color:var(--danger);margin-left:.2rem;}
    .bc-input,.bc-select,.bc-textarea{width:100%;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.875rem;color:var(--text);background:#fff;outline:none;font-family:inherit;transition:border-color .2s,box-shadow .2s;}
    .bc-input:focus,.bc-select:focus,.bc-textarea:focus{border-color:var(--rose);box-shadow:0 0 0 3px rgba(225,29,72,.08);}
    .bc-input.is-invalid{border-color:var(--danger);}
    .bc-textarea{resize:vertical;line-height:1.7;}
    .bc-hint{font-size:.73rem;color:var(--muted);margin-top:.35rem;}
    .bc-error{font-size:.73rem;color:var(--danger);margin-top:.35rem;display:flex;align-items:center;gap:.3rem;}
    .bc-row-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
    .bc-gap{display:flex;flex-direction:column;gap:1rem;}
    /* slug preview */
    .bc-slug-wrap{position:relative;}
    .bc-slug-prefix{position:absolute;left:.9rem;top:50%;transform:translateY(-50%);font-size:.82rem;color:var(--muted);pointer-events:none;font-family:monospace;}
    .bc-slug-input{padding-left:5.5rem!important;font-family:monospace;font-size:.85rem;}
    /* image upload */
    .bc-img-upload{border:2px dashed var(--border);border-radius:10px;background:var(--surface);cursor:pointer;transition:border-color .2s,background .2s;position:relative;overflow:hidden;}
    .bc-img-upload:hover{border-color:var(--rose);background:#fce7f304;}
    .bc-img-upload input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;z-index:2;}
    .bc-img-placeholder{padding:1.5rem;text-align:center;}
    .bc-img-placeholder-icon{width:44px;height:44px;border-radius:10px;background:#fce7f3;display:flex;align-items:center;justify-content:center;margin:0 auto .65rem;color:var(--rose);}
    .bc-img-preview{display:none;width:100%;height:180px;object-fit:cover;}
    .bc-img-preview.visible{display:block;}
    .bc-img-label-bar{display:none;align-items:center;justify-content:space-between;padding:.6rem 1rem;background:#fff;border-top:1px solid var(--border);font-size:.78rem;color:var(--text-dim);}
    .bc-img-label-bar.visible{display:flex;}
    /* status radio */
    .bc-status-grid{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;}
    .bc-status-radio{display:none;}
    .bc-status-label{display:flex;align-items:center;gap:.5rem;padding:.65rem .9rem;border:1.5px solid var(--border);border-radius:8px;font-size:.82rem;color:var(--text-dim);cursor:pointer;transition:all .15s;user-select:none;font-weight:500;}
    .bc-status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
    .bc-status-radio[value="1"]:checked+.bc-status-label{border-color:var(--green);background:#f0fdf4;color:#166534;}
    .bc-status-radio[value="0"]:checked+.bc-status-label{border-color:#fde68a;background:#fffbeb;color:#92400e;}
    /* alerts */
    .bc-alert{border-radius:8px;padding:.85rem 1.1rem;font-size:.84rem;display:flex;gap:.6rem;align-items:flex-start;margin-bottom:1.25rem;}
    .bc-alert-danger{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
    .bc-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;}
    .bc-alert ul{margin:.35rem 0 0 1rem;padding:0;}
    .bc-alert li{margin-bottom:.2rem;}
    /* submit bar */
    .bc-submit-bar{display:flex;align-items:center;justify-content:flex-end;gap:.6rem;padding:1.1rem 1.5rem;background:#fff;border:1px solid var(--border);border-radius:var(--radius);}
    .bc-btn{display:inline-flex;align-items:center;gap:.45rem;padding:.65rem 1.4rem;border-radius:8px;font-size:.85rem;font-weight:600;border:none;cursor:pointer;transition:all .2s;text-decoration:none;font-family:inherit;}
    .bc-btn-primary{background:var(--rose);color:#fff;}.bc-btn-primary:hover{background:var(--rose-lt);color:#fff;transform:translateY(-1px);}
    .bc-btn-ghost{background:none;border:1.5px solid var(--border);color:var(--text-dim);}.bc-btn-ghost:hover{border-color:var(--rose);color:var(--rose);}
    @media(max-width:900px){.bc-layout{grid-template-columns:1fr;}.bc-side{position:static;}.bc-row-2{grid-template-columns:1fr;}}
</style>

<div class="bc-page">
    <nav class="bc-breadcrumb">
        <a href="{{ route('admin.blogs.index') }}">News Posts</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
        <span style="color:var(--text-dim)">New Post</span>
    </nav>

    <div class="bc-heading">
        <div class="bc-heading-icon"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
        <div><h4>New News Post</h4><p>Write content, set a category, upload a featured image and publish.</p></div>
    </div>

    @if($errors->any())
        <div class="bc-alert bc-alert-danger">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:.1rem"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
            <div><strong>Please fix the following errors:</strong><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="bc-layout">
            <div class="bc-main">

                {{-- Core --}}
                <div class="bc-card">
                    <div class="bc-card-header">
                        <div class="bc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" x2="3" y1="10" y2="10"/><line x1="21" x2="3" y1="6" y2="6"/><line x1="21" x2="3" y1="14" y2="14"/><line x1="13" x2="3" y1="18" y2="18"/></svg></div>
                        <h6>Post Content</h6>
                    </div>
                    <div class="bc-card-body">
                        <div class="bc-gap">
                            <div>
                                <label class="bc-label">Title <span class="req">*</span></label>
                                <input type="text" name="title" id="titleInput" class="bc-input @error('title') is-invalid @enderror" value="{{ old('title') }}" oninput="autoSlug()" placeholder="Enter a compelling blog title" required>
                                @error('title')<p class="bc-error"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="bc-label">Slug</label>
                                <div class="bc-slug-wrap">
                                    <span class="bc-slug-prefix">blog/</span>
                                    <input type="text" name="slug" id="slugInput" class="bc-input bc-slug-input @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="auto-generated-from-title">
                                </div>
                                <p class="bc-hint">Leave blank to auto-generate from title.</p>
                                @error('slug')<p class="bc-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="bc-label">Content <span class="req">*</span></label>
                                <textarea name="content" id="contentTextarea" rows="16" class="bc-textarea @error('content') is-invalid @enderror" placeholder="Write your blog post content here…">{{ old('content') }}</textarea>
                                @error('content')<p class="bc-error">{{ $message }}</p>@enderror
                                <p class="bc-hint" id="wordCount" style="text-align:right">0 words</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bc-submit-bar">
                    <a href="{{ route('admin.blogs.index') }}" class="bc-btn bc-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
                        Cancel
                    </a>
                    <button type="submit" name="is_published" value="0" class="bc-btn bc-btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/></svg>
                        Save Draft
                    </button>
                    <button type="submit" name="is_published" value="1" class="bc-btn bc-btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        Publish Post
                    </button>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="bc-side">

                {{-- Featured image --}}
                <div class="bc-card">
                    <div class="bc-card-header">
                        <div class="bc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg></div>
                        <h6>Featured Image</h6>
                    </div>
                    <div class="bc-card-body" style="padding:0;overflow:hidden">
                        <div class="bc-img-upload" id="imgUploadWrap">
                            <input type="file" name="featured_image" id="imgInput" accept="image/*">
                            <img id="imgPreview" class="bc-img-preview" src="" alt="Preview">
                            <div class="bc-img-placeholder" id="imgPlaceholder">
                                <div class="bc-img-placeholder-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg></div>
                                <p style="font-size:.84rem;font-weight:600;color:var(--text);margin:0 0 .2rem">Upload featured image</p>
                                <p style="font-size:.74rem;color:var(--muted);margin:0">JPG, PNG, WEBP — max 3MB</p>
                            </div>
                            <div class="bc-img-label-bar" id="imgLabelBar">
                                <span id="imgFileName">—</span>
                                <button type="button" style="border:none;background:none;cursor:pointer;color:var(--danger);font-size:.75rem;" onclick="clearImg()">Remove</button>
                            </div>
                        </div>
                    </div>
                    @error('featured_image')<p class="bc-error" style="padding:.5rem 1rem">{{ $message }}</p>@enderror
                </div>

                {{-- Settings --}}
                <div class="bc-card">
                    <div class="bc-card-header">
                        <div class="bc-card-header-icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg></div>
                        <h6>Post Settings</h6>
                    </div>
                    <div class="bc-card-body">
                        <div class="bc-gap">
                            <div>
                                <label class="bc-label">Category</label>
                                <select name="blog_category_id" class="bc-select @error('blog_category_id') is-invalid @enderror">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('blog_category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('blog_category_id')<p class="bc-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="bc-label">Publish Date</label>
                                <input type="datetime-local" name="published_at" class="bc-input @error('published_at') is-invalid @enderror" value="{{ old('published_at') }}">
                                <p class="bc-hint">Leave blank to use current time on publish.</p>
                                @error('published_at')<p class="bc-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
function autoSlug(){
    const t=document.getElementById('titleInput').value;
    const s=document.getElementById('slugInput');
    if(!s.dataset.manual){
        s.value=t.toLowerCase().trim().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-');
    }
}
document.getElementById('slugInput').addEventListener('input',function(){ this.dataset.manual='1'; });
document.getElementById('contentTextarea').addEventListener('input',function(){
    const words=this.value.trim().split(/\s+/).filter(w=>w).length;
    document.getElementById('wordCount').textContent=words+' word'+(words===1?'':'s');
});
document.getElementById('imgInput').addEventListener('change',function(){
    const file=this.files[0];if(!file)return;
    const reader=new FileReader();
    reader.onload=e=>{
        document.getElementById('imgPreview').src=e.target.result;
        document.getElementById('imgPreview').classList.add('visible');
        document.getElementById('imgPlaceholder').style.display='none';
        document.getElementById('imgFileName').textContent=file.name;
        document.getElementById('imgLabelBar').classList.add('visible');
    };reader.readAsDataURL(file);
});
function clearImg(){
    document.getElementById('imgInput').value='';
    document.getElementById('imgPreview').classList.remove('visible');
    document.getElementById('imgPlaceholder').style.display='block';
    document.getElementById('imgLabelBar').classList.remove('visible');
}
</script>
@endsection