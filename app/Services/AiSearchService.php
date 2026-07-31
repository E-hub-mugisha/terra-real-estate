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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Turns a plain-language query — in any language — into structured filters
 * (via Claude tool-use) and runs them against the same tables SearchController
 * already queries.
 *
 * Multilingual strategy: rather than translating the query and searching only
 * in English, we ask Claude to expand `keywords` to include BOTH the original
 * language terms AND English equivalents/synonyms. This way the plain LIKE
 * search still matches listing rows regardless of what language they were
 * stored in, without a separate translation call.
 */
class AiSearchService implements SearchServiceInterface
{
    protected ?string $apiKey;
    protected string $model;

    /**
     * Words that carry no search value against a listing's title/description.
     * NOTE: Location names (Kigali, Gasabo, etc.) have been removed from here
     * so that local fallback searches still work properly if the AI fails.
     * NOTE: This stopword list is English-only by design — it only feeds the
     * *local regex fallback* below, which is itself English-only. It does not
     * limit what Claude can extract from non-English queries.
     */
    protected const STOPWORDS = [
        'a', 'an', 'the', 'for', 'sale', 'rent', 'buy', 'looking', 'find', 'search',
        'me', 'i', 'want', 'need', 'please', 'show', 'get', 'any',
        'under', 'over', 'above', 'below', 'less', 'more', 'than', 'least', 'most',
        'in', 'on', 'at', 'of', 'to', 'with', 'and', 'or', 'is', 'are', 'near',
        'rwf', 'frw', 'million', 'millions', 'thousand', 'thousands', 'rwanda',
        'bedroom', 'bedrooms', 'bed', 'beds', 'br', 'property', 'properties',
        'new', 'used', 'modern', 'furnished', 'unfurnished',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.key');
        $this->model  = config('services.anthropic.model', 'claude-sonnet-5');
    }

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
     * Calls Claude with a tool definition and forces it to return
     * structured filters extracted from the natural-language query,
     * in whatever language the user wrote it in.
     */
    protected function extractFilters(string $query): array
    {
        $default = [
            'detected_language'  => null,
            'category'           => 'all',
            'keywords'           => $query,
            'district'           => null,
            'province'           => null,
            'sector'             => null,
            'price_min'          => null,
            'price_max'          => null,
            'bedrooms'           => null,
            'property_type'      => null,
            'condition'          => null,
            'zoning'             => null,
            'land_use'           => null,
            'summary_localized'  => null,
        ];

        $filters = $default;

        if (! empty($this->apiKey)) {
            try {
                $response = Http::withHeaders([
                    'x-api-key'         => $this->apiKey,
                    'anthropic-version' => '2023-06-01',
                    'content-type'      => 'application/json',
                ])->timeout(20)->post('https://api.anthropic.com/v1/messages', [
                    'model'       => $this->model,
                    'max_tokens'  => 512,
                    'tools'       => [$this->toolDefinition()],
                    'tool_choice' => ['type' => 'tool', 'name' => 'extract_search_filters'],
                    'messages'    => [
                        [
                            'role'    => 'user',
                            'content' => $this->buildPrompt($query),
                        ],
                    ],
                ]);

                if (! $response->successful()) {
                    Log::warning('AI search extraction failed', ['status' => $response->status(), 'body' => $response->body()]);
                } else {
                    foreach ($response->json('content', []) as $block) {
                        if (($block['type'] ?? null) === 'tool_use' && ($block['name'] ?? null) === 'extract_search_filters') {
                            $extracted = array_filter(
                                $block['input'] ?? [],
                                fn ($v) => $v !== null && $v !== ''
                            );

                            $filters = array_merge($default, $extracted);
                            break;
                        }
                    }
                }
            } catch (\Throwable $e) {
                Log::error('AI search error: '.$e->getMessage());
            }
        }

        // Local regex fallback: fills in bedrooms / price only where the AI
        // extraction left them null. Never overwrites a value Claude already gave us.
        // NOTE: this fallback is English-only (see STOPWORDS note above). It exists
        // to keep English queries working if the API key is missing or the call
        // fails — it will not rescue a non-English query in that failure case,
        // since Claude is the only multilingual path. That's an acceptable
        // degradation, not a bug: it just means non-English search quality is
        // tied to API availability.
        return $this->applyLocalFallback($query, $filters);
    }

    protected function buildPrompt(string $query): string
    {
        return "You are a multilingual search parser for a Rwandan real estate platform. "
            . "The user's query may be written in English, Kinyarwanda, French, Swahili, or a mix of these — "
            . "detect the language automatically, do not ask for clarification.\n\n"
            . "Query: \"{$query}\"\n\n"
            . "Extract structured filters:\n"
            . "- `detected_language`: the ISO 639-1 code of the language the query is written in (e.g. \"en\", \"rw\", \"fr\", \"sw\").\n"
            . "- `keywords`: translate the query's intent into English AND include the original-language terms too "
            . "(comma-separated), since listing data in our database may be stored in either language — e.g. if the "
            . "query says \"inzu\" (Kinyarwanda for house) or \"maison\" (French), include both \"inzu\"/\"maison\" "
            . "and \"house\" as keywords, plus synonyms (e.g. 'flat' -> 'apartment'). Do NOT put location, price, "
            . "or bedroom count in this field — those go in their own fields below.\n"
            . "- `district`/`province`/`sector`: Rwandan administrative names are spelled the same across languages "
            . "(e.g. Gasabo, Kacyiru, Musanze) — normalize to the standard spelling regardless of the surrounding language.\n"
            . "- `price_min`/`price_max`: normalize numbers/currency phrases regardless of language "
            . "(e.g. 'un million', 'miliyoni imwe', '1M' all mean 1,000,000 RWF).\n"
            . "- `summary_localized`: a short, one-sentence summary of what you searched for, written back in the "
            . "SAME language the user asked in (detected_language). E.g. for a Kinyarwanda query, respond in Kinyarwanda.\n\n"
            . "Only fill in fields you are confident about from the query; leave everything else null.";
    }

    protected function applyLocalFallback(string $query, array $filters): array
    {
        if (empty($filters['bedrooms']) && preg_match('/(\d+)\s*[- ]?(?:bed(?:room)?s?|br)\b/i', $query, $m)) {
            $filters['bedrooms'] = (int) $m[1];
        }

        if (empty($filters['price_max']) && preg_match('/(?:under|below|less than|max(?:imum)?|up to)\s*(?:rwf|frw)?\s*([\d,.]+)\s*(million|m|thousand|k)?/i', $query, $m)) {
            $filters['price_max'] = $this->normalizeAmount($m[1], $m[2] ?? '');
        }

        if (empty($filters['price_min']) && preg_match('/(?:above|over|more than|at least|min(?:imum)?)\s*(?:rwf|frw)?\s*([\d,.]+)\s*(million|m|thousand|k)?/i', $query, $m)) {
            $filters['price_min'] = $this->normalizeAmount($m[1], $m[2] ?? '');
        }

        return $filters;
    }

    protected function normalizeAmount(string $number, string $unit): float
    {
        $value = (float) str_replace(',', '', $number);
        $unit  = strtolower($unit);

        return match (true) {
            in_array($unit, ['million', 'm'], true)   => $value * 1_000_000,
            in_array($unit, ['thousand', 'k'], true)   => $value * 1_000,
            default                                    => $value,
        };
    }

    protected function toolDefinition(): array
    {
        return [
            'name'        => 'extract_search_filters',
            'description' => 'Extract structured filters for searching Rwandan real estate listings and related content, from a query that may be written in any language.',
            'input_schema' => [
                'type'       => 'object',
                'properties' => [
                    'detected_language' => [
                        'type'        => 'string',
                        'description' => 'ISO 639-1 code of the language the user wrote the query in (e.g. "en", "rw", "fr", "sw").',
                    ],
                    'category' => [
                        'type'        => 'string',
                        'enum'        => ['houses', 'lands', 'architectural_designs', 'agents', 'consultants', 'professionals', 'news', 'announcements', 'tenders', 'jobs', 'advertisements', 'all'],
                        'description' => 'The primary category the user is looking for, used to prioritize results at the top. Default to "all" if the query spans multiple types or is ambiguous.',
                    ],
                    'keywords' => [
                        'type'        => 'string',
                        'description' => 'Comma-separated search terms in BOTH English and the original query language (if different), plus synonyms and features from the query. Used for broad text matching across title, description, and location columns. Do NOT include location, price, or bedroom count here — those go in their own fields.',
                    ],
                    'district'      => ['type' => 'string', 'description' => 'Rwandan district, e.g. Kicukiro, Gasabo, Nyarugenge, Musanze.'],
                    'province'      => ['type' => 'string', 'description' => 'Rwandan province, e.g. Kigali City, Northern Province.'],
                    'sector'        => ['type' => 'string', 'description' => 'Rwandan sector / neighbourhood, e.g. Kacyiru, Remera, Kimihurura.'],
                    'price_min'     => ['type' => 'number', 'description' => 'Minimum price in RWF.'],
                    'price_max'     => ['type' => 'number', 'description' => 'Maximum price in RWF.'],
                    'bedrooms'      => ['type' => 'integer', 'description' => 'Minimum number of bedrooms requested, for houses.'],
                    'property_type' => ['type' => 'string', 'description' => 'House/property type, e.g. bungalow, apartment, villa, duplex.'],
                    'condition'     => ['type' => 'string', 'description' => 'Condition, e.g. new, used, under construction.'],
                    'zoning'        => ['type' => 'string', 'description' => 'Zoning type, for land listings, e.g. residential, commercial, agricultural.'],
                    'land_use'      => ['type' => 'string', 'description' => 'Intended land use, for land listings.'],
                    'summary_localized' => [
                        'type'        => 'string',
                        'description' => 'A short one-sentence summary of what was searched for, written in the same language as detected_language.',
                    ],
                ],
                'required' => ['category', 'keywords'],
            ],
        ];
    }

    /**
     * Splits free text into meaningful search tokens: lowercased, stopwords and
     * short/numeric-only fragments removed.
     */
    protected function tokenize(?string $kw): array
    {
        if (! $kw) {
            return [];
        }

        $words = preg_split('/[\s,]+/', mb_strtolower(trim($kw))) ?: [];

        return collect($words)
            ->map(fn ($w) => trim($w, ".,!?'\""))
            ->filter(fn ($w) => mb_strlen($w) >= 3
                && ! is_numeric($w)
                && ! in_array($w, self::STOPWORDS, true))
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Applies a tokenized OR-across-columns keyword clause to a query builder.
     * Any single matching token is enough. Because `keywords` from Claude now
     * contains multilingual terms, this naturally matches listings whose
     * title/description are in Kinyarwanda, French, or English.
     */
    protected function applyKeywordSearch(Builder $builder, ?string $kw, array $columns): Builder
    {
        $tokens = $this->tokenize($kw);

        if (empty($tokens)) {
            return $builder;
        }

        return $builder->where(function ($q) use ($tokens, $columns) {
            foreach ($tokens as $token) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$token}%");
                }
            }
        });
    }

    protected function runQueries(array $filters): array
    {
        $kw = $filters['keywords'] ?? '';

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

        // ════════════════════════════════════════════════════════════════
        // SEARCH ENGINE BEHAVIOR:
        // We no longer restrict queries based on category. We ALWAYS search
        // every table to provide comprehensive "all results". The AI's chosen
        // category is only used by the frontend to visually prioritize the
        // most relevant section at the top.
        // ════════════════════════════════════════════════════════════════

        $results['houses'] = $this->applyKeywordSearch(
            House::query()->where('is_approved', true),
            $kw,
            ['title', 'description', 'district', 'sector', 'province', 'type', 'condition']
        )
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

        $results['lands'] = $this->applyKeywordSearch(
            Land::query()->where('is_approved', true),
            $kw,
            ['title', 'description', 'district', 'sector', 'province', 'zoning', 'land_use']
        )
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

        $results['architectural_designs'] = $this->applyKeywordSearch(
            ArchitecturalDesign::query()->where('status', 'active'),
            $kw,
            ['title', 'description']
        )
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $results['agents'] = $this->applyKeywordSearch(
            Agent::query(),
            $kw,
            ['full_name', 'bio', 'office_location']
        )
            ->when($filters['district'] ?? null, fn ($qr, $v) => $qr->where('office_location', 'like', "%{$v}%"))
            ->with(['user'])
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $results['consultants'] = $this->applyKeywordSearch(
            Consultant::query()->where('is_active', true),
            $kw,
            ['name', 'bio', 'title', 'district', 'province']
        )
            ->when($filters['district'] ?? null, fn ($qr, $v) => $qr->where('district', 'like', "%{$v}%"))
            ->when($filters['province'] ?? null, fn ($qr, $v) => $qr->where('province', 'like', "%{$v}%"))
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        if (class_exists(\App\Models\Professional::class)) {
            $results['professionals'] = $this->applyKeywordSearch(
                Professional::query(),
                $kw,
                ['full_name', 'bio']
            )
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        }

        $results['news'] = $this->applyKeywordSearch(
            Blog::query()->where('is_published', true),
            $kw,
            ['title', 'content']
        )
            ->with(['author', 'category'])
            ->orderByDesc('published_at')
            ->limit(8)
            ->get();

        $results['announcements'] = $this->applyKeywordSearch(
            Announcement::query()->where('status', 'active'),
            $kw,
            ['title', 'content']
        )
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $results['tenders'] = $this->applyKeywordSearch(
            Tender::query(),
            $kw,
            ['title', 'description']
        )
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $results['jobs'] = $this->applyKeywordSearch(
            JobListing::query()->where('status', 'active'),
            $kw,
            ['title', 'description', 'company_name', 'location', 'category']
        )
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        $results['advertisements'] = $this->applyKeywordSearch(
            Advertisement::query()->where('status', 'active'),
            $kw,
            ['title', 'description', 'location']
        )
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return $results;
    }

    protected function buildSummary(array $filters): string
    {
        // Prefer Claude's own in-language summary when we have one — it's
        // written in the same language the user searched in.
        if (! empty($filters['summary_localized'])) {
            return $filters['summary_localized'];
        }

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

        return $parts ? 'Showing results for: '.implode(', ', $parts) : 'Showing all results based on your query';
    }
}