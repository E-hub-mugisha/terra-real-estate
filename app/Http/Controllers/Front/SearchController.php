<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Land;
use App\Models\ArchitecturalDesign;
use App\Models\Agent;
use App\Models\Consultant;
use App\Models\Professional;
use App\Models\Blog;
use App\Models\Tender;
use App\Models\JobListing;
use App\Models\Advertisement;
use App\Models\Announcement;
use App\Models\Service;
use App\Models\ServiceCategory;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim($request->get('q', ''));
        $type     = $request->get('type', 'all');
        $category = trim($request->get('category', ''));

        $hasQuery    = $q !== '';
        $hasCategory = $category !== '';
        $hasFilter   = $hasQuery || $hasCategory;

        // Resolve a friendly label for the matched category/service, used
        // by the view to render "Browsing <Category Name>" when a service
        // link was clicked directly (no free-text query typed).
        $categoryLabel = null;
        if ($hasCategory) {
            $categoryLabel = Service::where('slug', $category)->value('title') ?? $category;
        }

        $results = [
            'houses'                => collect(),
            'lands'                 => collect(),
            'architectural_designs' => collect(),
            'agents'                => collect(),
            'consultants'           => collect(),
            'professionals'         => collect(),
            'news'                  => collect(),
            'announcements'         => collect(),
            'tenders'               => collect(),
            'jobs'                  => collect(),
            'advertisements'        => collect(),
        ];

        $total = 0;

        if ($hasFilter) {

            // ── Houses ───────────────────────────────────────────────
            // Category (service slug) filters independently of q, so a
            // service link from the offcanvas — or the dropdown submitted
            // with an empty search box — returns results on its own.
            if (in_array($type, ['all', 'properties'])) {
                $results['houses'] = House::query()
                    ->where('is_approved', true)
                    ->when($hasQuery, function ($query) use ($q) {
                        $query->where(function ($sub) use ($q) {
                            $sub->where('title', 'like', "%{$q}%")
                                ->orWhere('description', 'like', "%{$q}%")
                                ->orWhere('district', 'like', "%{$q}%")
                                ->orWhere('sector', 'like', "%{$q}%")
                                ->orWhere('province', 'like', "%{$q}%")
                                ->orWhere('type', 'like', "%{$q}%")
                                ->orWhere('condition', 'like', "%{$q}%");
                        });
                    })
                    ->when($hasCategory, function ($query) use ($category) {
                        $query->whereHas('service', function ($sub) use ($category) {
                            $sub->where('slug', $category);
                        });
                    })
                    ->with(['images', 'service'])
                    ->orderByDesc('created_at')
                    ->limit(12)
                    ->get();

                $total += $results['houses']->count();
            }

            // ── Lands ────────────────────────────────────────────────
            if (in_array($type, ['all', 'properties'])) {
                $results['lands'] = Land::query()
                    ->where('is_approved', true)
                    ->when($hasQuery, function ($query) use ($q) {
                        $query->where(function ($sub) use ($q) {
                            $sub->where('title', 'like', "%{$q}%")
                                ->orWhere('description', 'like', "%{$q}%")
                                ->orWhere('district', 'like', "%{$q}%")
                                ->orWhere('sector', 'like', "%{$q}%")
                                ->orWhere('province', 'like', "%{$q}%")
                                ->orWhere('zoning', 'like', "%{$q}%")
                                ->orWhere('land_use', 'like', "%{$q}%");
                        });
                    })
                    ->when($hasCategory, function ($query) use ($category) {
                        $query->whereHas('service', function ($sub) use ($category) {
                            $sub->where('slug', $category);
                        });
                    })
                    ->with(['images', 'service'])
                    ->orderByDesc('created_at')
                    ->limit(12)
                    ->get();

                $total += $results['lands']->count();
            }

            // ── Architectural Designs ─────────────────────────────────
            // No service/category relation on this model — text search only.
            if (in_array($type, ['all', 'properties']) && $hasQuery) {
                $results['architectural_designs'] = ArchitecturalDesign::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(8)
                    ->get();

                $total += $results['architectural_designs']->count();
            }

            // ── Agents ───────────────────────────────────────────────
            if (in_array($type, ['all', 'agents']) && $hasQuery) {
                $results['agents'] = Agent::query()
                    ->where(function ($query) use ($q) {
                        $query->where('full_name', 'like', "%{$q}%")
                            ->orWhere('bio', 'like', "%{$q}%")
                            ->orWhere('office_location', 'like', "%{$q}%");
                    })
                    ->with(['user'])
                    ->orderByDesc('created_at')
                    ->limit(8)
                    ->get();

                $total += $results['agents']->count();
            }

            // ── Consultants ──────────────────────────────────────────
            if (in_array($type, ['all', 'agents']) && $hasQuery) {
                $results['consultants'] = Consultant::query()
                    ->where('is_active', true)
                    ->where(function ($query) use ($q) {
                        $query->where('name', 'like', "%{$q}%")
                            ->orWhere('bio', 'like', "%{$q}%")
                            ->orWhere('title', 'like', "%{$q}%")
                            ->orWhere('district', 'like', "%{$q}%")
                            ->orWhere('province', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['consultants']->count();
            }

            // ── Professionals ────────────────────────────────────────
            if (in_array($type, ['all', 'agents']) && $hasQuery) {
                if (class_exists(\App\Models\Professional::class)) {
                    $results['professionals'] = Professional::query()
                        ->where(function ($query) use ($q) {
                            $query->where('full_name', 'like', "%{$q}%")
                                ->orWhere('bio', 'like', "%{$q}%");
                        })
                        ->orderByDesc('created_at')
                        ->limit(6)
                        ->get();

                    $total += $results['professionals']->count();
                }
            }

            // ── Blog / News ───────────────────────────────────────────
            if (in_array($type, ['all', 'news']) && $hasQuery) {
                $results['news'] = Blog::query()
                    ->where('is_published', true)
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                            ->orWhere('content', 'like', "%{$q}%");
                    })
                    ->with(['author', 'category'])
                    ->orderByDesc('published_at')
                    ->limit(8)
                    ->get();

                $total += $results['news']->count();
            }

            // ── Announcements ─────────────────────────────────────────
            if (in_array($type, ['all', 'news']) && $hasQuery) {
                $results['announcements'] = Announcement::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                            ->orWhere('content', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['announcements']->count();
            }

            // ── Tenders ──────────────────────────────────────────────
            if (in_array($type, ['all', 'tenders']) && $hasQuery) {
                $results['tenders'] = Tender::query()
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['tenders']->count();
            }

            // ── Jobs ─────────────────────────────────────────────────
            if (in_array($type, ['all', 'jobs']) && $hasQuery) {
                $results['jobs'] = JobListing::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%")
                            ->orWhere('company_name', 'like', "%{$q}%")
                            ->orWhere('location', 'like', "%{$q}%")
                            ->orWhere('category', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['jobs']->count();
            }

            // ── Advertisements ───────────────────────────────────────
            if (in_array($type, ['all', 'advertisements']) && $hasQuery) {
                $results['advertisements'] = Advertisement::query()
                    ->where('status', 'active')
                    ->where(function ($query) use ($q) {
                        $query->where('title', 'like', "%{$q}%")
                            ->orWhere('description', 'like', "%{$q}%")
                            ->orWhere('location', 'like', "%{$q}%");
                    })
                    ->orderByDesc('created_at')
                    ->limit(6)
                    ->get();

                $total += $results['advertisements']->count();
            }
        }

        return view('front.search.results', compact(
            'q', 'type', 'results', 'category', 'total',
            'hasQuery', 'hasCategory', 'hasFilter', 'categoryLabel'
        ));
    }

    public function categories()
    {
        return response()->json(
            Service::select('id', 'title', 'slug')->orderBy('title')->get()
        );
    }
}