<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category', 'author')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $image = null;

        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image')->store('blogs', 'public');
        }

        Blog::create([
            'user_id' => auth()->id(),
            'blog_category_id' => $request->blog_category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'featured_image' => $image,
            'content' => $request->content,
            'is_published' => $request->is_published ? 1 : 0,
            'published_at' => now()
        ]);

        return redirect()->route('admin.blogs.index');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $blog->update($request->all());

        return back()->with('success', 'Blog updated');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back();
    }
}
