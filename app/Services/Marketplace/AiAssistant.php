<?php

namespace App\Services\Marketplace;

use Anthropic\Client;
use Anthropic\Core\Exceptions\AnthropicException;
use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use App\Models\House;
use App\Models\Land;
use App\Support\Listing;
use App\Support\Settings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Terra AI: answers questions about the marketplace and turns plain-language
 * searches ("3 bedroom house for rent in Kicukiro under 800k") into filters.
 *
 * Claude only produces a reply + filters (structured output). Listings always
 * come from the database, so the assistant can never invent a property.
 * Without an API key (or if the API fails) a keyword parser does the search.
 */
class AiAssistant
{
    public const KINDS = ['any', 'house', 'land', 'design'];
    public const CONDITIONS = ['any', 'for_sale', 'for_rent'];

    /**
     * @param  array<int, array{role: string, content: string}>  $history  earlier turns, oldest first
     * @return array{reply: string, items: array, see_all: ?array, filters: array, mode: string}
     */
    public function respond(string $message, array $history = []): array
    {
        $plan = $this->planWithClaude($message, $history) ?? $this->planWithKeywords($message);

        $items = [];
        $seeAll = null;
        if ($plan['search']) {
            [$found, $relaxed] = $this->search($plan);
            $items = $found->map(fn ($i) => $this->card($i))->values()->all();
            $seeAll = $this->seeAllLink($plan);
            if ($plan['mode'] === 'basic') {
                $plan['reply'] = $this->basicReply($plan, count($items), $relaxed);
            } elseif ($relaxed && $items) {
                $plan['reply'] .= ' ' . __('There was no exact match, so these are the closest listings.');
            }
        }

        return [
            'reply' => trim($plan['reply']),
            'items' => $items,
            'see_all' => $seeAll,
            'filters' => array_intersect_key($plan, array_flip(['kind', 'condition', 'location', 'house_type', 'min_price', 'max_price', 'bedrooms', 'keywords', 'design_category'])),
            'mode' => $plan['mode'],
        ];
    }

    public static function enabled(): bool
    {
        return filled(config('services.anthropic.key'));
    }

    // ── Claude ──────────────────────────────────────────────────────────────
    private function planWithClaude(string $message, array $history): ?array
    {
        if (!static::enabled()) {
            return null;
        }

        $messages = [];
        foreach (array_slice($history, -8) as $turn) {
            $messages[] = ['role' => $turn['role'], 'content' => $turn['content']];
        }
        $messages[] = ['role' => 'user', 'content' => $message];

        try {
            $client = new Client(apiKey: config('services.anthropic.key'));
            $response = $client->beta->messages->create(
                model: config('services.anthropic.model', 'claude-opus-5-5'),
                maxTokens: 4000,
                system: $this->systemPrompt(),
                messages: $messages,
                outputConfig: [
                    'effort' => config('services.anthropic.effort', 'low'),
                    'format' => ['type' => 'json_schema', 'schema' => $this->schema()],
                ],
                // If the model declines for policy reasons, the API retries on its default fallback model.
                fallbacks: 'default',
                betas: ['server-side-fallback-2026-07-01'],
                requestOptions: ['timeout' => 45.0, 'maxRetries' => 1],
            );
        } catch (AnthropicException|\Throwable $e) {
            Log::warning('Terra AI request failed; using keyword search.', ['error' => $e->getMessage(), 'type' => get_class($e)]);

            return null;
        }

        if ($response->stopReason === 'refusal') {
            return $this->planWithKeywords($message, __('I can only help with houses, land and architectural designs on Terra. Here is what I found for your search.'));
        }

        foreach ($response->content as $block) {
            if ($block->type === 'text') {
                $data = json_decode($block->text, true);
                if (is_array($data)) {
                    return $this->normalise($data, 'ai');
                }
            }
        }
        Log::warning('Terra AI returned no parsable output.', ['stop_reason' => $response->stopReason]);

        return null;
    }

    private function schema(): array
    {
        return [
            'type' => 'object',
            'additionalProperties' => false,
            'required' => ['reply', 'search', 'kind', 'condition', 'location', 'house_type', 'min_price', 'max_price', 'bedrooms', 'keywords', 'design_category'],
            'properties' => [
                'reply' => ['type' => 'string', 'description' => 'Short, friendly answer shown to the user (1-3 sentences, plain text).'],
                'search' => ['type' => 'boolean', 'description' => 'True when the app should show matching listings.'],
                'kind' => ['type' => 'string', 'enum' => self::KINDS],
                'condition' => ['type' => 'string', 'enum' => self::CONDITIONS],
                'location' => ['type' => 'string', 'description' => 'District, sector or city name, or empty string.'],
                'house_type' => ['type' => 'string', 'description' => 'e.g. Villa, Apartment, Bungalow, or empty string.'],
                'min_price' => ['type' => 'number', 'description' => 'Minimum price in RWF, 0 if none.'],
                'max_price' => ['type' => 'number', 'description' => 'Maximum price in RWF, 0 if none.'],
                'bedrooms' => ['type' => 'integer', 'description' => 'Minimum bedrooms, 0 if any.'],
                'keywords' => ['type' => 'string', 'description' => 'Other words to match in titles (e.g. "pool", "commercial"), or empty string.'],
                'design_category' => ['type' => 'string', 'description' => 'Design category name for design searches, or empty string.'],
            ],
        ];
    }

    /** Stable per deployment (no timestamps) so it stays cache-friendly. */
    private function systemPrompt(): string
    {
        $facts = Cache::remember('terra.ai.facts', 600, function () {
            return [
                'houses_sale' => House::publiclyVisible()->where('condition', 'for_sale')->count(),
                'houses_rent' => House::publiclyVisible()->where('condition', 'for_rent')->count(),
                'land_sale' => Land::publiclyVisible()->where('condition', 'for_sale')->count(),
                'land_rent' => Land::publiclyVisible()->where('condition', 'for_rent')->count(),
                'designs' => ArchitecturalDesign::publiclyVisible()->count(),
                'districts' => House::publiclyVisible()->distinct()->pluck('district')->merge(Land::publiclyVisible()->distinct()->pluck('district'))->filter()->unique()->sort()->values()->implode(', '),
                'house_types' => House::publiclyVisible()->distinct()->pluck('type')->filter()->implode(', '),
                'design_categories' => DesignCategory::orderBy('name')->pluck('name')->implode(', '),
            ];
        });
        $whatsapp = Settings::get('contact.whatsapp');

        return <<<PROMPT
You are Terra AI, the assistant on Terra, a real estate marketplace in Rwanda. Terra lists only three things: houses (for sale or rent), land plots (for sale or rent), and architectural designs (house plans to buy or download). Prices are in Rwandan francs (RWF) unless the user says otherwise.

Your job each turn:
1. Write a short, warm reply (1-3 sentences, plain text, no markdown). Reply in the user's language (English, Kinyarwanda or French).
2. Decide whether to show listings. Set "search" to true when the user is looking for a property or design, or refines a previous search; false for general questions or greetings.
3. Fill the filters from what the user asked, carrying over filters from earlier turns when they are refining. Use "any", empty strings and 0 for anything not mentioned.

Rules:
- Never describe or invent specific listings, prices or addresses: the app shows the real matching listings under your reply. Say something like "Here are the options I found" instead.
- Convert amounts like "50M", "50 million", "800k" into plain numbers (50000000, 800000). "Under X" sets max_price; "from X" sets min_price.
- "Apartment", "villa", "bungalow" are house types. "Plot" means land. "Plan" or "house design" means design.
- If the request is not about Terra's properties or services, politely steer back and set search to false.

What is on Terra now: {$facts['houses_sale']} houses for sale, {$facts['houses_rent']} houses for rent, {$facts['land_sale']} plots for sale, {$facts['land_rent']} plots for rent, {$facts['designs']} designs.
Areas with listings: {$facts['districts']}.
House types: {$facts['house_types']}.
Design categories: {$facts['design_categories']}.

How Terra works (for questions):
- Clients create a free account to save properties, message owners directly, book viewings and make offers from any listing page.
- Property owners register as "owner" and list houses, land or designs; Terra checks each listing before it goes live.
- Listing packages are paid per day: Basic, Medium and Premium. Premium listings appear in the homepage pop-up and are marked Featured; Basic and Medium appear in the homepage ads for part of the paid days.
- Agents and independent partners help find and promote properties and earn commissions; partners apply at /partners/apply.
- Support WhatsApp: +{$whatsapp}.
PROMPT;
    }

    // ── Keyword fallback ────────────────────────────────────────────────────
    private function planWithKeywords(string $message, ?string $reply = null): array
    {
        $text = Str::lower($message);
        $plan = ['reply' => $reply ?? '', 'search' => true, 'kind' => 'any', 'condition' => 'any', 'location' => '', 'house_type' => '',
            'min_price' => 0, 'max_price' => 0, 'bedrooms' => 0, 'keywords' => '', 'design_category' => ''];

        if (preg_match('/\b(design|plan|plans|drawing|architect)/', $text)) {
            $plan['kind'] = 'design';
        } elseif (preg_match('/\b(land|plot|plots|ikibanza|terrain)\b/', $text)) {
            $plan['kind'] = 'land';
        } elseif (preg_match('/\b(house|home|villa|apartment|bungalow|flat|inzu|maison|bedroom|bed)\b/', $text)) {
            $plan['kind'] = 'house';
        }
        if (preg_match('/\b(rent|rental|lease|gukodesha|louer|location)\b/', $text)) {
            $plan['condition'] = 'for_rent';
        } elseif (preg_match('/\b(buy|sale|sell|purchase|kugura|acheter)\b/', $text)) {
            $plan['condition'] = 'for_sale';
        }
        foreach (['villa', 'apartment', 'bungalow', 'double storey'] as $type) {
            if (str_contains($text, $type)) {
                $plan['house_type'] = $type;
                $plan['kind'] = 'house';
            }
        }
        if (preg_match('/(\d+)\s*(?:-|\s)?\s*(?:bed|bedroom|bd|br|chambre|ibyumba)/', $text, $m)) {
            $plan['bedrooms'] = (int) $m[1];
            $plan['kind'] = 'house';
        }
        $money = '(\d+(?:[.,]\d+)?)\s*(k|m|million|mil|thousand)?';
        if (preg_match('/(?:under|below|less than|max|up to|budget|munsi ya|moins de)\s*(?:rwf\s*)?' . $money . '/', $text, $m)) {
            $plan['max_price'] = $this->amount($m[1], $m[2] ?? '');
        }
        if (preg_match('/(?:over|above|from|more than|min|at least)\s*(?:rwf\s*)?' . $money . '/', $text, $m)) {
            $plan['min_price'] = $this->amount($m[1], $m[2] ?? '');
        }
        $areas = Cache::remember('terra.ai.areas', 600, fn () => House::query()->pluck('district')->merge(House::query()->pluck('sector'))
            ->merge(Land::query()->pluck('district'))->merge(Land::query()->pluck('sector'))->merge(collect(['Kigali']))
            ->filter()->map(fn ($a) => trim($a))->unique()->values()->all());
        foreach ($areas as $area) {
            if (Str::contains($text, Str::lower($area))) {
                $plan['location'] = $area;
                break;
            }
        }
        if ($plan['kind'] === 'design') {
            foreach (DesignCategory::pluck('name') as $cat) {
                if (Str::contains($text, Str::lower(Str::before($cat, ' ')))) {
                    $plan['design_category'] = $cat;
                }
            }
        }
        $faq = $this->faqAnswer($text);
        $isChat = preg_match('/^(how|what|who|can|do|does|is|are|why|when|where|hi|hello|hey|thanks|thank you|muraho|bonjour|salut)\b/', $text)
            && $plan['kind'] === 'any' && $plan['location'] === '' && $plan['bedrooms'] === 0 && $plan['max_price'] == 0;
        if ($faq !== null) {
            $plan['search'] = false;
            $plan['reply'] = $reply ?? $faq;
        } elseif ($isChat) {
            $plan['search'] = false;
            $plan['reply'] = $reply ?? __('I can search houses, land and designs for you. Try something like "3 bedroom house for rent in Kicukiro under 800k". For anything else, chat with the Terra team on WhatsApp (+:wa).', ['wa' => Settings::get('contact.whatsapp')]);
        }
        $plan['mode'] = 'basic';

        return $plan;
    }

    /** Short answers to common questions when Claude isn't configured. */
    private function faqAnswer(string $text): ?string
    {
        // A concrete search ("2 bedroom… under 600k") is never treated as a question.
        if (preg_match('/\d+\s*(bed|bd|br)|\b(under|below|for rent|for sale)\b/', $text)) {
            return null;
        }
        $answers = [
            '/\b(list|sell|post|advertise|upload)\b.*\b(property|properties|house|land|plot|home|design)|\bbecome an? owner\b/' => __('Create a free account and choose "List my property". Add photos, price and location; Terra checks it, then clients can message you, book viewings and make offers directly.'),
            '/\b(package|packages|premium|listing fee|promote|promotion|featured)\b/' => __('Listings are paid per day with Basic, Medium or Premium packages. Premium appears in the homepage pop-up and is marked Featured; Basic and Medium appear in the homepage ads for part of the days you pay.'),
            '/\b(viewing|viewings|visit|tour)\b/' => __('Open any house or plot and tap "Book a viewing". Pick a date and time; the owner confirms or suggests another time, and you can follow it under Viewings in your account.'),
            '/\b(offer|offers|negotiate|bargain)\b/' => __('Open the listing and tap "Make an offer". The owner can accept, reject or send a counter offer, and you will see the answer under Offers in your account.'),
            '/\b(partner|partners|referral|commission|earn)\b/' => __('Independent partners refer owners and buyers and earn a share of packages and deals. Apply at /partners/apply; licensed agents can use "Join as an agent".'),
            '/\b(agent|agents)\b/' => __('Browse verified agents on the Agents page, or join as an agent from "Join as an agent".'),
            '/\b(contact|support|whatsapp|help|phone|call)\b/' => __('You can reach the Terra team on WhatsApp at +:wa.', ['wa' => Settings::get('contact.whatsapp')]),
        ];
        foreach ($answers as $pattern => $answer) {
            if (preg_match($pattern, $text)) {
                return $answer;
            }
        }

        return null;
    }

    private function amount(string $number, string $unit): float
    {
        $n = (float) str_replace(',', '.', $number);

        return match (true) {
            in_array($unit, ['m', 'million', 'mil'], true) => $n * 1_000_000,
            in_array($unit, ['k', 'thousand'], true) => $n * 1_000,
            default => $n,
        };
    }

    private function basicReply(array $plan, int $count, bool $relaxed = false): string
    {
        if ($plan['reply'] !== '') {
            return $plan['reply'];
        }
        $what = match ($plan['kind']) {
            'house' => $plan['house_type'] ? Str::plural(Str::lower($plan['house_type'])) : __('houses'),
            'land' => __('plots'),
            'design' => __('designs'),
            default => __('listings'),
        };
        $parts = array_filter([
            $plan['condition'] === 'for_rent' ? __('for rent') : ($plan['condition'] === 'for_sale' ? __('for sale') : null),
            $plan['location'] ? __('in :place', ['place' => $plan['location']]) : null,
            $plan['bedrooms'] ? __('with :n+ bedrooms', ['n' => $plan['bedrooms']]) : null,
            $plan['max_price'] ? __('under :p RWF', ['p' => number_format($plan['max_price'])]) : null,
        ]);

        $label = trim($what . ' ' . implode(' ', $parts));

        return match (true) {
            $count > 0 && !$relaxed => __('Here are :label.', ['label' => $label]),
            $count > 0 => __('No exact match for :label yet, so here are the closest listings.', ['label' => $label]),
            default => __('I could not find :label yet. Try a wider area or budget.', ['label' => $label]),
        };
    }

    private function normalise(array $d, string $mode): array
    {
        return [
            'reply' => Str::limit((string) ($d['reply'] ?? ''), 600),
            'search' => (bool) ($d['search'] ?? false),
            'kind' => in_array($d['kind'] ?? '', self::KINDS, true) ? $d['kind'] : 'any',
            'condition' => in_array($d['condition'] ?? '', self::CONDITIONS, true) ? $d['condition'] : 'any',
            'location' => Str::limit(trim((string) ($d['location'] ?? '')), 60, ''),
            'house_type' => Str::limit(trim((string) ($d['house_type'] ?? '')), 40, ''),
            'min_price' => max(0, (float) ($d['min_price'] ?? 0)),
            'max_price' => max(0, (float) ($d['max_price'] ?? 0)),
            'bedrooms' => max(0, min(20, (int) ($d['bedrooms'] ?? 0))),
            'keywords' => Str::limit(trim((string) ($d['keywords'] ?? '')), 60, ''),
            'design_category' => Str::limit(trim((string) ($d['design_category'] ?? '')), 60, ''),
            'mode' => $mode,
        ];
    }

    // ── Search ──────────────────────────────────────────────────────────────
    /** @return array{0: Collection, 1: bool} results and whether filters were loosened */
    private function search(array $plan): array
    {
        $results = $this->query($plan);
        if ($results->isNotEmpty()) {
            return [$results, false];
        }
        // Loosen step by step: keywords, then type/price, then location.
        foreach ([['keywords', 'design_category'], ['house_type', 'min_price', 'max_price', 'bedrooms'], ['location']] as $drop) {
            foreach ($drop as $key) {
                $plan[$key] = is_numeric($plan[$key]) ? 0 : '';
            }
            $results = $this->query($plan);
            if ($results->isNotEmpty()) {
                return [$results, true];
            }
        }

        return [collect(), false];
    }

    private function query(array $p): Collection
    {
        $like = fn (string $v) => '%' . str_replace(['%', '_'], ['\\%', '\\_'], $v) . '%';
        $groups = [];

        if (in_array($p['kind'], ['any', 'house'], true)) {
            $q = House::publiclyVisible()->with(['images', 'activePromotion']);
            $this->common($q, $p, $like, ['district', 'sector', 'province', 'cell', 'village']);
            if ($p['house_type'] !== '') {
                $q->where('type', 'like', $like($p['house_type']));
            }
            if ($p['bedrooms'] > 0) {
                $q->where('bedrooms', '>=', $p['bedrooms']);
            }
            $groups[] = $q->latest()->take(12)->get();
        }
        if (in_array($p['kind'], ['any', 'land'], true) && ($p['kind'] === 'land' || ($p['bedrooms'] === 0 && $p['house_type'] === ''))) {
            $q = Land::publiclyVisible()->with(['images', 'activePromotion']);
            $this->common($q, $p, $like, ['district', 'sector', 'province', 'cell', 'village'], ['zoning', 'land_use']);
            $groups[] = $q->latest()->take(12)->get();
        }
        if (in_array($p['kind'], ['any', 'design'], true) && ($p['kind'] === 'design' || ($p['location'] === '' && $p['bedrooms'] === 0 && $p['condition'] !== 'for_rent'))) {
            $q = ArchitecturalDesign::publiclyVisible()->with(['images', 'category', 'activePromotion']);
            if ($p['design_category'] !== '') {
                $q->whereHas('category', fn ($c) => $c->where('name', 'like', $like($p['design_category'])));
            }
            if ($p['keywords'] !== '') {
                $q->where(fn ($w) => $w->where('title', 'like', $like($p['keywords']))->orWhere('description', 'like', $like($p['keywords'])));
            }
            if ($p['max_price'] > 0) {
                $q->where('price', '<=', $p['max_price']);
            }
            $groups[] = $q->latest()->take(12)->get();
        }

        return Listing::collect(...$groups)->take(6);
    }

    private function common($q, array $p, callable $like, array $locationColumns, array $extraKeywordColumns = []): void
    {
        if ($p['condition'] !== 'any') {
            $q->where('condition', $p['condition']);
        }
        if ($p['location'] !== '') {
            $q->where(fn ($w) => collect($locationColumns)->each(fn ($c) => $w->orWhere($c, 'like', $like($p['location']))));
        }
        if ($p['min_price'] > 0) {
            $q->where('price', '>=', $p['min_price']);
        }
        if ($p['max_price'] > 0) {
            $q->where('price', '<=', $p['max_price']);
        }
        if ($p['keywords'] !== '') {
            $cols = array_merge(['title', 'description'], $extraKeywordColumns);
            $q->where(fn ($w) => collect($cols)->each(fn ($c) => $w->orWhere($c, 'like', $like($p['keywords']))));
        }
    }

    private function card(array $i): array
    {
        return [
            'kind' => $i['kind'],
            'kind_label' => $i['kind_label'],
            'title' => $i['title'],
            'url' => $i['url'],
            'image' => $i['image'],
            'price' => Listing::price($i) . ($i['price'] > 0 ? ' ' . $i['currency'] : ''),
            'condition' => $i['kind'] === 'design' ? null : ($i['condition'] === 'for_rent' ? __('For rent') : __('For sale')),
            'location' => $i['location'],
            'meta' => array_values($i['meta']),
            'featured' => $i['featured'],
        ];
    }

    private function seeAllLink(array $p): array
    {
        if ($p['kind'] === 'design') {
            $category = $p['design_category'] !== '' ? DesignCategory::where('name', 'like', '%' . $p['design_category'] . '%')->value('id') : null;

            return ['url' => route('front.properties.architecture', array_filter(['category' => $category, 'search' => $p['keywords'] ?: null])), 'label' => __('See all designs')];
        }

        return [
            'url' => route('front.properties.buy', array_filter([
                'kind' => $p['kind'] !== 'any' ? $p['kind'] : null,
                'condition' => $p['condition'] !== 'any' ? $p['condition'] : null,
                'q' => $p['location'] ?: ($p['house_type'] ?: ($p['keywords'] ?: null)),
            ])),
            'label' => __('See all matching listings'),
        ];
    }
}
