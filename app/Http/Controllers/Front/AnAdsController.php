<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnAdsController extends Controller
{
    public function showAdvertisements()
    {
        $ads = Advertisement::where('status', 'approved')->orderBy('created_at', 'desc')->paginate(9);
        return view('front.advertisements', compact('ads'));
    }

    public function showAnnouncements()
    {
        $announcements = Announcement::where('status', 'published')->orderBy('created_at', 'desc')->paginate(10);
        return view('front.announcements', compact('announcements'));
    }
    public function showAnnouncementDetail($slug)
    {
        $announcement = Announcement::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('front.announcement-detail', compact('announcement'));
    }
}
