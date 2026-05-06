<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Agent;
use App\Models\Consultant;
use App\Models\Professional;
use App\Models\News;
use App\Models\Tender;
use App\Models\Job;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\JobListing;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q    = trim($request->get('q', ''));
        $type = $request->get('type', 'all'); // all | properties | agents | news | jobs | tenders

        $results = [
            'properties'     => collect(),
            'agents'         => collect(),
            'consultants'    => collect(),
            'professionals'  => collect(),
            'news'           => collect(),
            'tenders'        => collect(),
            'jobs'           => collect(),
            'advertisements' => collect(),
        ];

        $total = 0;

        if ($q !== '') {

            // ── Properties (houses + lands) ──────────────────────────
            if (in_array($type, ['all', 'properties'])) {
                $results['properties'] = Property::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                              ->orWhere('description', 'like', "%{$q}%")
                              ->orWhere('location', 'like', "%{$q}%")
                              ->orWhere('district', 'like', "%{$q}%")
                              ->orWhere('property_type', 'like', "%{$q}%");
                    })
                    ->with(['images', 'agent'])
                    ->orderByDesc('created_at')
                    ->limit(12)
                    ->get();

                $total += $results['properties']->count();
            }

            // ── Agents ───────────────────────────────────────────────
            if (in_array($type, ['all', 'agents'])) {
                $results['agents'] = Agent::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%")
                              ->orWhere('bio', 'like', "%{$q}%")
                              ->orWhere('location', 'like', "%{$q}%")
                              ->orWhere('specialization', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(8)
                    ->get();

                $total += $results['agents']->count();
            }

            // ── Consultants ──────────────────────────────────────────
            if (in_array($type, ['all', 'agents'])) {
                $results['consultants'] = Consultant::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%")
                              ->orWhere('expertise', 'like', "%{$q}%")
                              ->orWhere('bio', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['consultants']->count();
            }

            // ── Professionals ────────────────────────────────────────
            if (in_array($type, ['all', 'agents'])) {
                $results['professionals'] = Professional::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%")
                              ->orWhere('profession', 'like', "%{$q}%")
                              ->orWhere('bio', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['professionals']->count();
            }

            // ── News ─────────────────────────────────────────────────
            if (in_array($type, ['all', 'news'])) {
                $results['news'] = Blog::query()
                    ->where('status', 'published')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                              ->orWhere('body', 'like', "%{$q}%")
                              ->orWhere('excerpt', 'like', "%{$q}%");
                    })
                    ->orderByDesc('published_at')
                    ->limit(8)
                    ->get();

                $total += $results['news']->count();
            }

            // ── Tenders ──────────────────────────────────────────────
            if (in_array($type, ['all', 'tenders'])) {
                $results['tenders'] = Tender::query()
                    ->where('status', 'open')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                              ->orWhere('description', 'like', "%{$q}%")
                              ->orWhere('organization', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['tenders']->count();
            }

            // ── Jobs ─────────────────────────────────────────────────
            if (in_array($type, ['all', 'jobs'])) {
                $results['jobs'] = JobListing::query()
                    ->where('status', 'open')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                              ->orWhere('description', 'like', "%{$q}%")
                              ->orWhere('company', 'like', "%{$q}%")
                              ->orWhere('location', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['jobs']->count();
            }

            // ── Advertisements ───────────────────────────────────────
            if (in_array($type, ['all'])) {
                $results['advertisements'] = Advertisement::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                              ->orWhere('description', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(4)
                    ->get();

                $total += $results['advertisements']->count();
            }
        }

        return view('front.search.results', compact('q', 'type', 'results', 'total'));
    }
}
