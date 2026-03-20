<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs      = Blog::with(['author', 'category'])->latest()->get();
        $categories = BlogCategory::orderBy('name')->get();

        $stats = [
            'total'       => $blogs->count(),
            'published'   => $blogs->where('is_published', true)->count(),
            'drafts'      => $blogs->where('is_published', false)->count(),
            'categories'  => $categories->count(),
        ];

        return view('admin.blogs.index', compact('blogs', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:blogs,slug',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'content'          => 'required|string',
            'is_published'     => 'nullable',
            'published_at'     => 'nullable|date',
        ]);

        // Auto-generate slug
        $data['slug'] = $data['slug']
            ? Str::slug($data['slug'])
            : Str::slug($data['title']) . '-' . Str::random(5);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')
                ->store('blogs/images', 'public');
        }

        $data['user_id']      = Auth::id();
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published']
            ? ($data['published_at'] ?? now())
            : null;

        Blog::create($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', '✅ Blog post ' . ($data['is_published'] ? 'published' : 'saved as draft') . ' successfully.');
    }

    public function show(Blog $blog)
    {
        $blog->load(['author', 'category']);

        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $blog->load(['author', 'category']);
        $categories = BlogCategory::orderBy('name')->get();

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'content'          => 'required|string',
            'is_published'     => 'nullable',
            'published_at'     => 'nullable|date',
        ]);

        // Keep existing slug if not changed, or re-slug new input
        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = $blog->slug;
        }

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')
                ->store('blogs/images', 'public');
        }

        $wasPublished         = $blog->is_published;
        $data['is_published'] = $request->boolean('is_published');

        // Set published_at when first publishing
        if (!$wasPublished && $data['is_published']) {
            $data['published_at'] = $data['published_at'] ?? now();
        } elseif (!$data['is_published']) {
            $data['published_at'] = null;
        }

        $blog->update($data);

        return back()->with('success', '✅ Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $title = $blog->title;

        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', "Blog post \"{$title}\" has been deleted.");
    }

    public function togglePublish(Blog $blog)
    {
        $blog->update([
            'is_published' => !$blog->is_published,
            'published_at' => !$blog->is_published ? now() : null,
        ]);

        $status = $blog->is_published ? 'published' : 'unpublished';

        return back()->with('success', "\"{$blog->title}\" has been {$status}.");
    }
}