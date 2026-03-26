<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use App\Models\ListingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobListingController extends Controller
{
    /**
     * Public job board.
     */
    public function index()
    {
        $jobs = JobListing::active()
            ->paid()
            ->latest('published_at')
            ->get();

        return view('front.jobs.index', compact('jobs'));
    }

    /**
     * Job detail page.
     */
    public function show(string $slug)
    {
        $job = JobListing::where('slug', $slug)
            ->active()
            ->paid()
            ->firstOrFail();

        // Auto-expire check
        $job->checkExpiry();

        return view('front.jobs.show', compact('job'));
    }
}