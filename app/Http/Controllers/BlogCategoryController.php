<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = \App\Models\BlogCategory::latest()->get();
        return view('admin.blog_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:blog_categories,name'
        ]);

        \App\Models\BlogCategory::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name)
        ]);

        return back()->with('success','Blog category created successfully');
    }

    public function update(Request $request, \App\Models\BlogCategory $blogCategory)
    {
        $request->validate([
            'name' => 'required|unique:blog_categories,name,'.$blogCategory->id
        ]);

        $blogCategory->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name)
        ]);

        return back()->with('success','Blog category updated successfully');
    }

    public function destroy(\App\Models\BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return back()->with('success','Blog category deleted successfully');
    }
}
