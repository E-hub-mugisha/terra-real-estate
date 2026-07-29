<?php

namespace App\Services;

use App\Models\House;
use App\Models\Land;
use App\Models\ArchitecturalDesign;
use App\Models\Agent;
use App\Models\Consultant;
use App\Models\Professional;
use App\Models\Blog;
use App\Models\Announcement;
use App\Models\Tender;
use App\Models\JobListing;
use App\Models\Advertisement;

/**
 * Same public interface as AiSearchService (search(), returns
 * ['filters' => ..., 'summary' => ..., 'results' => ..., 'total' => ...])
 * but extracts filters with plain PHP string/regex matching instead of
 * calling any AI API. Drop-in replacement — swap the binding in
 * AiSearchController (or a service provider) if you want to switch back
 * and forth, or just rename this class to AiSearchService.
 */
class RuleBasedSearchService implements SearchServiceInterface
{
    /** Rwanda's provinces — extend/adjust to match your schema's exact naming. */
    protected array $provinces = [
        'Kigali City', 'Northern Province', 'Southern Province',
        'Eastern Province', 'Western Province',
    ];

    /** A representative set of Rwandan districts — add any missing ones. */
    protected array $districts = [
        'Gasabo', 'Kicukiro', 'Nyarugenge',
        'Musanze', 'Burera', 'Gakenke', 'Gicumbi', 'Rulindo',
        'Huye', 'Nyanza', 'Gisagara', 'Nyaruguru', 'Muhanga', 'Kamonyi', 'Ruhango', 'Nyamagabe',
        'Rwamagana', 'Kayonza', 'Ngoma', 'Kirehe', 'Nyagatare', 'Gatsibo', 'Bugesera',
        'Rubavu', 'Rusizi', 'Nyamasheke', 'Karongi', 'Ngororero', 'Rutsiro', 'Nyabihu',
    ];

    /** A representative set of sectors/neighbourhoods — extend as needed. */
    protected array $sectors = [
        'Kacyiru', 'Remera', 'Kimihurura', 'Nyarutarama', 'Kagugu', 'Gisozi', 'Kinyinya',
        'Kimironko', 'Gikondo', 'Nyamirambo', 'Muhima', 'Kanombe', 'Gatenga', 'Niboye',
        'Kabuga', 'Rebero',
    ];

    protected array $propertyTypes = ['bungalow', 'apartment', 'villa', 'duplex', 'mansion', 'flat', 'studio'];

    protected array $conditions = ['new', 'used', 'under construction', 'renovated', 'off-plan'];

    protected array $zoning = ['residential', 'commercial', 'agricultural', 'industrial', 'mixed use'];

    /** Keyword => category mapping, checked in this order (first match wins). */
    protected array $categoryKeywords = [
        'lands'                 => ['land', 'lands', 'plot', 'plots', 'acre', 'hectare'],
        'architectural_designs' => ['design', 'designs', 'architectural', 'architecture', 'blueprint', 'floor plan'],
        'agents'                => ['agent', 'agents', 'realtor', 'broker'],
        'consultants'           => ['consultant', 'consultants', 'consultancy'],
        'professionals'         => ['professional', 'professionals', 'contractor', 'engineer', 'architect'],
        'news'                  => ['news', 'article', 'blog'],
        'announcements'         => ['announcement', 'announcements', 'notice'],
        'tenders'               => ['tender', 'tenders', 'bid', 'procurement'],
        'jobs'                  => ['job', 'jobs', 'vacancy', 'vacancies', 'hiring', 'career', 'employment'],
        'advertisements'        => ['advert', 'adverts', 'advertisement', 'ad', 'ads', 'promo'],
        'houses'                => ['house', 'houses', 'home', 'homes', 'bedroom', 'bungalow', 'apartment', 'villa'],
    ];

    public function search(string $query): array
    {
        $filters = $this->extractFilters($query);
        $results = $this->runQueries($filters);
        $total   = collect($results)->sum(fn ($c) => $c->count());

        return [
            'filters' => $filters,
            'summary' => $this->buildSummary($filters),
            'results' => $results,
            'total'   => $total,
        ];
    }

    /**
     * Parses the query with plain string/regex matching. No external
     * calls, no API key, no network round-trip.
     */
    protected function extractFilters(string $query): array
    {
        $q    = trim($query);
        $qLow = mb_strtolower($q);

        $filters = [
            'category'      => $this->detectCategory($qLow),
            'keywords'      => $this->stripKnownTermsForKeywords($q),
            'district'      => $this->matchFromList($qLow, $this->districts),
            'province'      => $this->matchFromList($qLow, $this->provinces),
            'sector'        => $this->matchFromList($qLow, $this->sectors),
            'price_min'     => null,
            'price_max'     => null,
            'bedrooms'      => $this->detectBedrooms($qLow),
            'property_type' => $this->matchFromList($qLow, $this->propertyTypes),
            'condition'     => $this->matchFromList($qLow, $this->conditions),
            'zoning'        => $this->matchFromList($qLow, $this->zoning),
            'land_use'      => null,
        ];

        [$priceMin, $priceMax] = $this->detectPriceRange($qLow);
        $filters['price_min'] = $priceMin;
        $filters['price_max'] = $priceMax;

        return $filters;
    }

    protected function detectCategory(string $qLow): string
    {
        foreach ($this->categoryKeywords as $category => $keywords) {
            foreach ($keywords as $kw) {
                if (str_contains($qLow, $kw)) {
                    return $category;
                }
            }
        }

        return 'all';
    }

    protected function matchFromList(string $qLow, array $list): ?string
    {
        foreach ($list as $item) {
            if (str_contains($qLow, mb_strtolower($item))) {
                return $item;
            }
        }

        return null;
    }

    protected function detectBedrooms(string $qLow): ?int
    {
        if (preg_match('/(\d+)\s*(?:\+)?\s*bed(?:room)?s?/i', $qLow, $m)) {
            return (int) $m[1];
        }

        return null;
    }

    /**
     * Handles patterns like:
     *  "under 80 million", "below 50m", "under RWF 20,000,000",
     *  "above 30 million", "over 10m", "between 20 million and 40 million"
     */
    protected function detectPriceRange(string $qLow): array
    {
        $qLow = str_replace(',', '', $qLow);

        // "between X and Y" (million or plain digits)
        if (preg_match('/between\s+([\d.]+)\s*(million|m)?\s+and\s+([\d.]+)\s*(million|m)?/i', $qLow, $m)) {
            $min = $this->normalizeAmount($m[1], $m[2] ?? '');
            $max = $this->normalizeAmount($m[3], $m[4] ?? '');

            return [$min, $max];
        }

        // "under / below / less than X"
        if (preg_match('/(?:under|below|less than|max(?:imum)?)\s+(?:rwf\s*)?([\d.]+)\s*(million|m)?/i', $qLow, $m)) {
            return [null, $this->normalizeAmount($m[1], $m[2] ?? '')];
        }

        // "above / over / more than / min X"
        if (preg_match('/(?:above|over|more than|min(?:imum)?)\s+(?:rwf\s*)?([\d.]+)\s*(million|m)?/i', $qLow, $m)) {
            return [$this->normalizeAmount($m[1], $m[2] ?? ''), null];
        }

        return [null, null];
    }

    protected function normalizeAmount(string $number, string $unit): float
    {
        $value = (float) $number;

        if (in_array(mb_strtolower($unit), ['million', 'm'])) {
            $value *= 1_000_000;
        }

        return $value;
    }

    /**
     * Keeps the original query as the free-text keyword fallback for
     * LIKE matching against titles/descriptions — same role `keywords`
     * played when Claude extracted it.
     */
    protected function stripKnownTermsForKeywords(string $query): string
    {
        return trim($query);
    }

    /**
     * Identical to AiSearchService::runQueries() — same models, same
     * approval/status guards, same searchable fields.
     */
    protected function runQueries(array $filters): array
    {
        $category = $filters['category'] ?? 'all';
        $kw       = $filters['keywords'] ?? '';
        $wants    = fn (string $key) => $category === 'all' || $category === $key;

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

        if ($wants('houses')) {
            $results['houses'] = House::query()
                ->where('is_approved', true)
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('title', 'like', "%{$kw}%")
                    ->orWhere('description', 'like', "%{$kw}%")))
                ->when($filters['district'] ?? null, fn ($qr, $v) => $qr->where('district', 'like', "%{$v}%"))
                ->when($filters['province'] ?? null, fn ($qr, $v) => $qr->where('province', 'like', "%{$v}%"))
                ->when($filters['sector'] ?? null, fn ($qr, $v) => $qr->where('sector', 'like', "%{$v}%"))
                ->when($filters['property_type'] ?? null, fn ($qr, $v) => $qr->where('type', 'like', "%{$v}%"))
                ->when($filters['condition'] ?? null, fn ($qr, $v) => $qr->where('condition', 'like', "%{$v}%"))
                ->when($filters['bedrooms'] ?? null, fn ($qr, $v) => $qr->where('bedrooms', '>=', (int) $v))
                ->when($filters['price_min'] ?? null, fn ($qr, $v) => $qr->where('price', '>=', $v))
                ->when($filters['price_max'] ?? null, fn ($qr, $v) => $qr->where('price', '<=', $v))
                ->with(['images'])
                ->orderByDesc('created_at')
                ->limit(12)
                ->get();
        }

        if ($wants('lands')) {
            $results['lands'] = Land::query()
                ->where('is_approved', true)
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('title', 'like', "%{$kw}%")
                    ->orWhere('description', 'like', "%{$kw}%")))
                ->when($filters['district'] ?? null, fn ($qr, $v) => $qr->where('district', 'like', "%{$v}%"))
                ->when($filters['province'] ?? null, fn ($qr, $v) => $qr->where('province', 'like', "%{$v}%"))
                ->when($filters['sector'] ?? null, fn ($qr, $v) => $qr->where('sector', 'like', "%{$v}%"))
                ->when($filters['zoning'] ?? null, fn ($qr, $v) => $qr->where('zoning', 'like', "%{$v}%"))
                ->when($filters['land_use'] ?? null, fn ($qr, $v) => $qr->where('land_use', 'like', "%{$v}%"))
                ->when($filters['price_min'] ?? null, fn ($qr, $v) => $qr->where('price', '>=', $v))
                ->when($filters['price_max'] ?? null, fn ($qr, $v) => $qr->where('price', '<=', $v))
                ->with(['images'])
                ->orderByDesc('created_at')
                ->limit(12)
                ->get();
        }

        if ($wants('architectural_designs')) {
            $results['architectural_designs'] = ArchitecturalDesign::query()
                ->where('status', 'active')
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('title', 'like', "%{$kw}%")
                    ->orWhere('description', 'like', "%{$kw}%")))
                ->orderByDesc('created_at')
                ->limit(8)
                ->get();
        }

        if ($wants('agents')) {
            $results['agents'] = Agent::query()
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('full_name', 'like', "%{$kw}%")
                    ->orWhere('bio', 'like', "%{$kw}%")
                    ->orWhere('office_location', 'like', "%{$kw}%")))
                ->when($filters['district'] ?? null, fn ($qr, $v) => $qr->where('office_location', 'like', "%{$v}%"))
                ->with(['user'])
                ->orderByDesc('created_at')
                ->limit(8)
                ->get();
        }

        if ($wants('consultants')) {
            $results['consultants'] = Consultant::query()
                ->where('is_active', true)
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('name', 'like', "%{$kw}%")
                    ->orWhere('bio', 'like', "%{$kw}%")
                    ->orWhere('title', 'like', "%{$kw}%")))
                ->when($filters['district'] ?? null, fn ($qr, $v) => $qr->where('district', 'like', "%{$v}%"))
                ->when($filters['province'] ?? null, fn ($qr, $v) => $qr->where('province', 'like', "%{$v}%"))
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        }

        if ($wants('professionals') && class_exists(\App\Models\Professional::class)) {
            $results['professionals'] = Professional::query()
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('full_name', 'like', "%{$kw}%")
                    ->orWhere('bio', 'like', "%{$kw}%")))
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        }

        if ($wants('news')) {
            $results['news'] = Blog::query()
                ->where('is_published', true)
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('title', 'like', "%{$kw}%")
                    ->orWhere('content', 'like', "%{$kw}%")))
                ->with(['author', 'category'])
                ->orderByDesc('published_at')
                ->limit(8)
                ->get();
        }

        if ($wants('announcements')) {
            $results['announcements'] = Announcement::query()
                ->where('status', 'active')
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('title', 'like', "%{$kw}%")
                    ->orWhere('content', 'like', "%{$kw}%")))
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        }

        if ($wants('tenders')) {
            $results['tenders'] = Tender::query()
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('title', 'like', "%{$kw}%")
                    ->orWhere('description', 'like', "%{$kw}%")))
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        }

        if ($wants('jobs')) {
            $results['jobs'] = JobListing::query()
                ->where('status', 'active')
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('title', 'like', "%{$kw}%")
                    ->orWhere('description', 'like', "%{$kw}%")
                    ->orWhere('company_name', 'like', "%{$kw}%")
                    ->orWhere('location', 'like', "%{$kw}%")
                    ->orWhere('category', 'like', "%{$kw}%")))
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        }

        if ($wants('advertisements')) {
            $results['advertisements'] = Advertisement::query()
                ->where('status', 'active')
                ->when($kw, fn ($qr) => $qr->where(fn ($q) => $q
                    ->where('title', 'like', "%{$kw}%")
                    ->orWhere('description', 'like', "%{$kw}%")
                    ->orWhere('location', 'like', "%{$kw}%")))
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        }

        return $results;
    }

    protected function buildSummary(array $filters): string
    {
        $parts = [];

        if (($filters['category'] ?? 'all') !== 'all') {
            $parts[] = str_replace('_', ' ', $filters['category']);
        }
        if (! empty($filters['bedrooms'])) {
            $parts[] = "{$filters['bedrooms']}+ bedrooms";
        }
        if (! empty($filters['property_type'])) {
            $parts[] = $filters['property_type'];
        }
        if (! empty($filters['sector'])) {
            $parts[] = "in {$filters['sector']}";
        } elseif (! empty($filters['district'])) {
            $parts[] = "in {$filters['district']}";
        } elseif (! empty($filters['province'])) {
            $parts[] = "in {$filters['province']}";
        }
        if (! empty($filters['price_max'])) {
            $parts[] = 'under RWF '.number_format((float) $filters['price_max']);
        } elseif (! empty($filters['price_min'])) {
            $parts[] = 'above RWF '.number_format((float) $filters['price_min']);
        }

        return $parts ? 'Showing results for: '.implode(', ', $parts) : 'Showing results based on your query';
    }
}
