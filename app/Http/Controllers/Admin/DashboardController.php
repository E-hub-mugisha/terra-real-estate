<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Announcement;
use App\Models\ArchitecturalDesign;
use App\Models\Blog;
use App\Models\Consultant;
use App\Models\House;
use App\Models\Land;
use App\Models\Tender;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [
            'stats' => [
                'properties'    => House::count() + Land::count(),
                'agents'        => Agent::count(),
                'consultants'   => Consultant::count(),
                'blogs'         => Blog::count(),
                'announcements' => Announcement::count(),
                'tenders'       => Tender::count(),
            ],
        ]);
    }

    public function notifications()
    {
        // Get latest 5 notifications from each type
        $lands = Land::latest()->take(5)->get();
        $houses = House::latest()->take(5)->get();
        $designs = ArchitecturalDesign::latest()->take(5)->get();
        $agents = Agent::latest()->take(5)->get();
        $consultants = Consultant::latest()->take(5)->get();

        // Merge into one collection and sort by created_at desc
        $notifications = $lands->map(fn($l) => ['type' => 'land', 'title' => $l->title, 'image' => $l->image ?? 'default.png', 'created_at' => $l->created_at])
            ->merge($houses->map(fn($h) => ['type' => 'house', 'title' => $h->title, 'image' => $h->image ?? 'default.png', 'created_at' => $h->created_at]))
            ->merge($designs->map(fn($d) => ['type' => 'design', 'title' => $d->title, 'image' => $d->image ?? 'default.png', 'created_at' => $d->created_at]))
            ->merge($agents->map(fn($a) => ['type' => 'agent', 'title' => $a->name, 'image' => $a->profile_image ?? 'default.png', 'created_at' => $a->created_at]))
            ->merge($consultants->map(fn($c) => ['type' => 'consultant', 'title' => $c->name, 'image' => $c->profile_image ?? 'default.png', 'created_at' => $c->created_at]))
            ->sortByDesc('created_at')
            ->take(10); // latest 10 notifications

        return view('admin.partials.notifications', compact('notifications'));
    }
}
