<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\Announcement;
use Illuminate\Support\Str;

class NewsAdsController extends Controller
{
    // --- Advertisements ---
    public function adsIndex()
    {
        $ads = Advertisement::latest()->paginate(10);
        return view('admin.ads.index', compact('ads'));
    }

    public function adsCreate()
    {
        return view('admin.ads.create');
    }

    public function adsStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image',
            'price' => 'required|numeric',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['created_by'] = auth()->id();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ads', 'public');
        }
        Advertisement::create($data);

        return redirect()->route('admin.ads.index')->with('success', 'Advertisement created. Payment pending.');
    }

    public function adsEdit(Advertisement $ad)
    {
        return view('admin.ads.edit', compact('ad'));
    }

    public function adsUpdate(Request $request, Advertisement $ad)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image',
            'price' => 'required|numeric',
        ]);

        $data['slug'] = Str::slug($data['title']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ads', 'public');
        }
        $ad->update($data);

        return redirect()->route('admin.ads.index')->with('success', 'Advertisement updated.');
    }

    public function adsDestroy(Advertisement $ad)
    {
        $ad->delete();
        return back()->with('success', 'Advertisement deleted.');
    }

    // --- Announcements ---
    public function announceIndex()
    {
        $announcements = Announcement::latest()->paginate(10);
        return view('admin.announcements.index', compact('announcements'));
    }

    public function announceCreate()
    {
        return view('admin.announcements.create');
    }

    public function announceStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['title']);
        $data['created_by'] = auth()->id();
        Announcement::create($data);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created. Payment pending.');
    }

    public function announceEdit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function announceUpdate(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
        ]);
        $data['slug'] = Str::slug($data['title']);
        $announcement->update($data);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated.');
    }

    public function announceDestroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement deleted.');
    }
}
