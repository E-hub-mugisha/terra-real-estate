<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogImage;
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
            'gallery_images'         => 'nullable|array|max:10',
            'gallery_images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            'gallery_captions'       => 'nullable|array',
            'gallery_captions.*'     => 'nullable|string|max:255',
        ]);

        $data['slug'] = $data['slug']
            ? Str::slug($data['slug'])
            : Str::slug($data['title']) . '-' . Str::random(5);

        if ($featured_image = $request->file('featured_image')) {
            $destinationPath = 'image/blogs/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $featured_image->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $featured_image->move($destinationPath, $filename);

            // Save relative path in DB
            $data['featured_image'] = "$filename";
        }

        $data['user_id']      = Auth::id();
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published']
            ? ($data['published_at'] ?? now())
            : null;

        $blog = Blog::create($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', '✅ Blog post ' . ($data['is_published'] ? 'published' : 'saved as draft') . ' successfully.');
    }

    public function show(Blog $blog)
    {
        $blog->load(['author', 'category', ]);

        $blog->recordView(request());

        $viewStats = [
            'total'       => $blog->views_count,
            'unique'      => $blog->unique_views_count,
            'today'       => $blog->viewsToday(),
            'this_week'   => $blog->viewsThisWeek(),
            'this_month'  => $blog->viewsThisMonth(),
            'daily_chart' => $blog->dailyViewsForPast(14),
        ];

        return view('admin.blogs.show', compact('blog', 'viewStats'));
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
            'gallery_images'         => 'nullable|array|max:10',
            'gallery_images.*'       => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            'gallery_captions'       => 'nullable|array',
            'gallery_captions.*'     => 'nullable|string|max:255',
            'delete_images'          => 'nullable|array',
            'delete_images.*'        => 'integer|exists:blog_images,id',
        ]);

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = $blog->slug;
        }

        if ($featured_image = $request->file('featured_image')) {
            $destinationPath = 'image/blogs/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $featured_image->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $featured_image->move($destinationPath, $filename);

            // Save relative path in DB
            $data['featured_image'] = "$filename";
        }

        $wasPublished         = $blog->is_published;
        $data['is_published'] = $request->boolean('is_published');

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

        // Gallery images are cascade-deleted by the DB,
        // but we still clean up files from storage.
        foreach ($blog->images as $img) {
            Storage::disk('public')->delete($img->image_path);
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

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function storeGalleryImages(Request $request, Blog $blog): void
    {
        if (!$request->hasFile('gallery_images')) {
            return;
        }

        $captions        = $request->input('gallery_captions', []);
        $sortStart       = $blog->images()->max('sort_order') + 1;
        $destinationPath = public_path('image/blogs/');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        foreach ($request->file('gallery_images') as $index => $file) {
            $filename = uniqid('', true) . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $filename);

            $blog->images()->create([
                'image_path' => $filename,
                'caption'    => $captions[$index] ?? null,
                'sort_order' => $sortStart + $index,
            ]);
        }
    }
}
