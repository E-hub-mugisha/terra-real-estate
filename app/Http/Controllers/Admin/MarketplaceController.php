<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Inquiry;
use App\Models\ListingAssignment;
use App\Models\ListingDocument;
use App\Models\ListingPayment;
use App\Models\ListingPromotion;
use App\Models\Offer;
use App\Models\PartnerProfile;
use App\Models\Referral;
use App\Models\User;
use App\Models\Viewing;
use App\Services\Marketplace\CommissionService;
use App\Services\Marketplace\PromotionService;
use App\Support\ListingRef;
use App\Support\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Admin console for the marketplace: approvals, documents, activity monitoring,
 * people (users / partners), money (payments / promotions / commissions),
 * listing assignments, reports and platform settings.
 */
class MarketplaceController extends Controller
{
    // ── Listing approval queue ──────────────────────────────────────────────
    public function approvals(Request $request)
    {
        $type = $request->query('type');
        $state = $request->query('state', 'pending');

        $listings = collect(ListingRef::TYPES)
            ->filter(fn ($class, $key) => !$type || $type === $key)
            ->flatMap(function ($class, $key) use ($state) {
                $q = $class::query()->with(['ownerUser', 'partner'])->withCount('documents');
                if ($state === 'pending') {
                    $key === 'design' ? $q->where('status', 'pending') : $q->where('is_approved', false)->whereNull('rejection_reason');
                } elseif ($state === 'rejected') {
                    $key === 'design' ? $q->where('status', 'rejected') : $q->where('is_approved', false)->whereNotNull('rejection_reason');
                } else {
                    $q->publiclyVisible();
                }

                return $q->latest()->take(100)->get();
            })
            ->sortByDesc('created_at')->values();

        $counts = [
            'pending' => \App\Models\House::where('is_approved', false)->whereNull('rejection_reason')->count()
                + \App\Models\Land::where('is_approved', false)->whereNull('rejection_reason')->count()
                + \App\Models\ArchitecturalDesign::where('status', 'pending')->count(),
        ];

        return view('admin.marketplace.approvals', compact('listings', 'type', 'state', 'counts'));
    }

    public function decide(Request $request, string $type, int $id)
    {
        $listing = ListingRef::resolve($type, $id);
        $data = $request->validate([
            'decision' => 'required|in:approve,reject',
            'reason' => 'required_if:decision,reject|nullable|string|max:500',
        ]);

        if ($data['decision'] === 'approve') {
            $updates = ['rejection_reason' => null];
            $type === 'design' ? $updates += ['status' => 'approved', 'is_approved' => true] : $updates += ['is_approved' => true];
        } else {
            $updates = ['rejection_reason' => $data['reason']];
            $type === 'design' ? $updates += ['status' => 'rejected', 'is_approved' => false] : $updates += ['is_approved' => false];
        }
        $listing->forceFill($updates)->save();

        return back()->with('success', '“' . $listing->title . '” ' . ($data['decision'] === 'approve' ? 'approved and live.' : 'rejected.'));
    }

    // ── Property documents ──────────────────────────────────────────────────
    public function documents(Request $request)
    {
        $documents = ListingDocument::with(['listable', 'user'])
            ->when($request->query('status', 'pending'), fn ($q, $s) => $s === 'all' ? $q : $q->where('status', $s))
            ->latest()->paginate(25)->withQueryString();

        return view('admin.marketplace.documents', compact('documents'));
    }

    public function reviewDocument(Request $request, ListingDocument $document)
    {
        $document->update($request->validate(['status' => 'required|in:verified,rejected,pending']));

        return back()->with('success', 'Document marked ' . $document->status . '.');
    }

    // ── Activity monitoring ─────────────────────────────────────────────────
    public function inquiries(Request $request)
    {
        $inquiries = Inquiry::with(['listable', 'recipient', 'sender'])
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->when($request->query('q'), fn ($q, $term) => $q->where(fn ($w) => $w->where('name', 'like', "%$term%")->orWhere('email', 'like', "%$term%")->orWhere('message', 'like', "%$term%")))
            ->latest()->paginate(25)->withQueryString();

        $unanswered = Inquiry::where('status', 'new')->where('created_at', '<', now()->subDays(2))->count();

        return view('admin.marketplace.inquiries', compact('inquiries', 'unanswered'));
    }

    public function deals(Request $request)
    {
        $tab = $request->query('tab', 'offers');
        $offers = $tab === 'offers'
            ? Offer::with(['listable', 'client', 'recipient'])->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))->latest()->paginate(25)->withQueryString()
            : null;
        $viewings = $tab === 'viewings'
            ? Viewing::with(['listable', 'client', 'host'])->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))->orderByDesc('scheduled_at')->paginate(25)->withQueryString()
            : null;

        $counts = [
            'offers' => Offer::count(), 'accepted' => Offer::where('status', 'accepted')->count(),
            'viewings' => Viewing::count(), 'upcoming' => Viewing::where('status', 'confirmed')->where('scheduled_at', '>=', now())->count(),
        ];

        return view('admin.marketplace.deals', compact('tab', 'offers', 'viewings', 'counts'));
    }

    /** Mark a listing sold / rented and create the deal commissions for its agent / partner. */
    public function recordDeal(Request $request, string $type, int $id)
    {
        abort_if($type === 'design', 422);
        $listing = ListingRef::resolve($type, $id);
        $data = $request->validate([
            'outcome' => 'required|in:sold,rented',
            'value' => 'required|numeric|min:1',
        ]);

        $created = DB::transaction(function () use ($listing, $data) {
            $listing->forceFill(['status' => $data['outcome']])->save();

            return app(CommissionService::class)->forDeal($listing, (float) $data['value'], $listing->currency ?: 'RWF');
        });

        return back()->with('success', '“' . $listing->title . '” marked ' . $data['outcome'] . '. ' . count($created) . ' commission(s) created for approval.');
    }

    public function referrals(Request $request)
    {
        $referrals = Referral::with('referrer')
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()->paginate(25)->withQueryString();
        $pipeline = Referral::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.marketplace.referrals', compact('referrals', 'pipeline'));
    }

    // ── People ──────────────────────────────────────────────────────────────
    public function users(Request $request)
    {
        $users = User::query()
            ->when($request->query('role'), fn ($q, $r) => $q->where('role', $r))
            ->when($request->query('q'), fn ($q, $t) => $q->where(fn ($w) => $w->where('name', 'like', "%$t%")->orWhere('email', 'like', "%$t%")->orWhere('phone', 'like', "%$t%")))
            ->when($request->query('state') === 'inactive', fn ($q) => $q->where('is_active', false))
            ->latest()->paginate(30)->withQueryString();

        $roleCounts = User::selectRaw('role, count(*) as total')->groupBy('role')->pluck('total', 'role');

        return view('admin.marketplace.users', compact('users', 'roleCounts'));
    }

    public function updateUser(Request $request, User $user)
    {
        $me = $request->user();
        $data = $request->validate([
            'role' => 'nullable|in:' . implode(',', array_keys(User::ROLES)),
            'is_active' => 'nullable|boolean',
        ]);
        abort_if($user->id === $me->id, 422, 'You cannot change your own account here.');
        // Only admins grant or remove admin / staff access.
        if ((isset($data['role']) && in_array($data['role'], ['admin', 'staff'], true)) || in_array($user->role, ['admin', 'staff'], true)) {
            abort_unless($me->role === 'admin', 403, 'Only admins can change staff or admin accounts.');
        }

        $updates = array_filter($data, fn ($v) => $v !== null);
        $user->forceFill($updates)->save();
        if (($updates['role'] ?? null) === 'partner') {
            PartnerProfile::firstOrCreate(['user_id' => $user->id], ['phone' => $user->phone, 'status' => 'active', 'is_verified' => true]);
        }

        return back()->with('success', $user->name . ' updated.');
    }

    public function partners(Request $request)
    {
        $partners = PartnerProfile::with('user')
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->latest()->paginate(25)->withQueryString();

        $stats = User::where('role', 'partner')
            ->withCount(['referrals', 'referrals as converted_count' => fn ($q) => $q->where('status', 'converted')])
            ->withSum(['commissions as earned' => fn ($q) => $q->whereIn('status', ['approved', 'paid'])], 'amount')
            ->get()->keyBy('id');

        return view('admin.marketplace.partners', compact('partners', 'stats'));
    }

    public function updatePartner(Request $request, PartnerProfile $partner)
    {
        $data = $request->validate(['status' => 'required|in:pending,active,suspended']);
        $partner->update(['status' => $data['status'], 'is_verified' => $data['status'] === 'active']);

        return back()->with('success', 'Partner ' . ($partner->user->name ?? '') . ' is now ' . $data['status'] . '.');
    }

    // ── Money ───────────────────────────────────────────────────────────────
    public function payments(Request $request)
    {
        $status = $request->query('status', 'processing');
        $payments = ListingPayment::with(['payable', 'user', 'listingPackage', 'promotion'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()->paginate(25)->withQueryString();

        $totals = ListingPayment::selectRaw('status, count(*) as n, sum(amount) as total')->groupBy('status')->get()->keyBy('status');

        return view('admin.marketplace.payments', compact('payments', 'status', 'totals'));
    }

    public function verifyPayment(Request $request, ListingPayment $payment)
    {
        $data = $request->validate([
            'decision' => 'required|in:confirm,reject',
            'reason' => 'required_if:decision,reject|nullable|string|max:255',
        ]);
        abort_if($payment->isCompleted(), 422, 'This payment is already confirmed.');

        if ($data['decision'] === 'reject') {
            $payment->markFailed($data['reason']);

            return back()->with('success', 'Payment ' . $payment->reference . ' rejected.');
        }

        $promotion = DB::transaction(function () use ($payment, $request) {
            $payment->markCompleted($payment->transaction_id ?: 'ADMIN-' . $payment->reference);
            $payment->forceFill(['verified_by' => $request->user()->id])->save();

            return app(PromotionService::class)->activateFromPayment($payment);
        });

        return back()->with('success', 'Payment confirmed.' . ($promotion ? ' ' . ucfirst($promotion->tier) . ' package runs until ' . $promotion->ends_at->format('j M Y') . '.' : ''));
    }

    public function promotions(Request $request)
    {
        $state = $request->query('state', 'active');
        $promotions = ListingPromotion::with(['listable', 'user', 'payment'])
            ->when($state === 'active', fn ($q) => $q->active())
            ->when($state === 'ads', fn ($q) => $q->inAds())
            ->when($state === 'ended', fn ($q) => $q->where(fn ($w) => $w->where('ends_at', '<', now())->orWhere('status', '!=', 'active')))
            ->orderByRaw("FIELD(tier,'premium','medium','basic')")->orderByDesc('ends_at')
            ->paginate(30)->withQueryString();

        $counts = [
            'active' => ListingPromotion::active()->count(),
            'ads' => ListingPromotion::inAds()->count(),
            'spotlight' => ListingPromotion::spotlight()->count(),
        ];

        return view('admin.marketplace.promotions', compact('promotions', 'state', 'counts'));
    }

    public function updatePromotion(Request $request, ListingPromotion $promotion)
    {
        $data = $request->validate(['action' => 'required|in:cancel,spotlight_on,spotlight_off,end_ads']);
        match ($data['action']) {
            'cancel' => $promotion->update(['status' => 'cancelled']),
            'spotlight_on' => $promotion->update(['spotlight' => true]),
            'spotlight_off' => $promotion->update(['spotlight' => false]),
            'end_ads' => $promotion->update(['ad_ends_at' => now()]),
        };

        return back()->with('success', 'Promotion updated.');
    }

    public function commissions(Request $request)
    {
        $commissions = Commission::with(['user', 'listable'])
            ->when($request->query('status', 'pending'), fn ($q, $s) => $s === 'all' ? $q : $q->where('status', $s))
            ->when($request->query('role'), fn ($q, $r) => $q->where('role', $r))
            ->latest()->paginate(30)->withQueryString();
        $totals = Commission::selectRaw('status, count(*) as n, sum(amount) as total')->groupBy('status')->get()->keyBy('status');

        return view('admin.marketplace.commissions', compact('commissions', 'totals'));
    }

    public function updateCommission(Request $request, Commission $commission)
    {
        $data = $request->validate(['status' => 'required|in:approved,paid,cancelled,pending', 'notes' => 'nullable|string|max:500']);
        $updates = ['status' => $data['status']];
        if ($data['status'] === 'paid') {
            $updates['paid_at'] = now();
        }
        if (!empty($data['notes'])) {
            $updates['notes'] = $data['notes'];
        }
        $commission->update($updates);

        return back()->with('success', 'Commission ' . $data['status'] . '.');
    }

    public function bulkCommissions(Request $request)
    {
        $data = $request->validate(['ids' => 'required|array', 'ids.*' => 'integer', 'status' => 'required|in:approved,paid']);
        $q = Commission::whereIn('id', $data['ids'])->whereIn('status', $data['status'] === 'paid' ? ['approved', 'pending'] : ['pending']);
        $n = $q->update(['status' => $data['status'], 'paid_at' => $data['status'] === 'paid' ? now() : null]);

        return back()->with('success', $n . ' commission(s) marked ' . $data['status'] . '.');
    }

    // ── Listing assignments (agents / partners help promote) ────────────────
    public function assignments(Request $request)
    {
        $assignments = ListingAssignment::with(['listable', 'user', 'assigner'])->latest()->paginate(30);
        $helpers = User::whereIn('role', ['agent', 'partner'])->where('is_active', true)->orderBy('name')->get(['id', 'name', 'role']);
        $listings = ListingRef::collect(fn ($q) => $q->publiclyVisible()->select(['id', 'title', 'created_at'])->latest()->take(200))
            ->sortBy('title')->values();

        return view('admin.marketplace.assignments', compact('assignments', 'helpers', 'listings'));
    }

    public function storeAssignment(Request $request)
    {
        $data = $request->validate([
            'listing' => ['required', 'regex:/^(house|land|design)-\d+$/'],
            'user_id' => 'required|exists:users,id',
            'note' => 'nullable|string|max:500',
        ]);
        [$type, $id] = explode('-', $data['listing']);
        $listing = ListingRef::resolve($type, (int) $id);
        $helper = User::findOrFail($data['user_id']);
        abort_unless($helper->isAgent() || $helper->isPartner(), 422, 'Listings can be assigned to agents or partners only.');

        ListingAssignment::updateOrCreate(
            ['listable_type' => $listing->getMorphClass(), 'listable_id' => $listing->getKey(), 'user_id' => $helper->id],
            ['assigned_by' => $request->user()->id, 'note' => $data['note'] ?? null]
        );

        return back()->with('success', '“' . $listing->title . '” assigned to ' . $helper->name . '.');
    }

    public function destroyAssignment(ListingAssignment $assignment)
    {
        $assignment->delete();

        return back()->with('success', 'Assignment removed.');
    }

    // ── Reports ─────────────────────────────────────────────────────────────
    public function reports(Request $request)
    {
        $from = now()->subMonthsNoOverflow(5)->startOfMonth();
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonthsNoOverflow($i)->format('Y-m'));
        $monthly = fn ($query, string $col = 'created_at', ?string $sum = null) => $query
            ->where($col, '>=', $from)->get()
            ->groupBy(fn ($r) => $r->{$col}->format('Y-m'))
            ->map(fn ($g) => $sum ? $g->sum($sum) : $g->count());

        $series = [
            'revenue' => $monthly(ListingPayment::where('status', 'completed')->whereNotNull('paid_at'), 'paid_at', 'amount'),
            'listings' => $months->mapWithKeys(fn ($m) => [$m => collect(ListingRef::TYPES)->sum(
                fn ($c) => $c::whereBetween('created_at', [\Carbon\Carbon::parse($m . '-01')->startOfMonth(), \Carbon\Carbon::parse($m . '-01')->endOfMonth()])->count()
            )]),
            'inquiries' => $monthly(Inquiry::query()),
            'users' => $monthly(User::query()),
        ];

        $kpis = [
            'revenue' => (float) ListingPayment::where('status', 'completed')->sum('amount'),
            'commissions_paid' => (float) Commission::where('status', 'paid')->sum('amount'),
            'commissions_due' => (float) Commission::whereIn('status', ['pending', 'approved'])->sum('amount'),
            'live' => ListingRef::collect(fn ($q) => $q->publiclyVisible()->select('id'))->count(),
            'inquiries' => Inquiry::count(),
            'response_rate' => ($n = Inquiry::count()) ? round(Inquiry::where('status', '!=', 'new')->count() / $n * 100) : 0,
            'offers_accepted' => Offer::where('status', 'accepted')->count(),
            'viewings_done' => Viewing::where('status', 'completed')->count(),
        ];

        $topListings = ListingRef::collect(fn ($q) => $q->withCount('inquiries')->orderByDesc('views_count')->take(5))
            ->sortByDesc('views_count')->take(8)->values();
        $topEarners = User::whereIn('role', ['agent', 'partner'])
            ->withSum(['commissions as earned' => fn ($q) => $q->whereIn('status', ['approved', 'paid'])], 'amount')
            ->orderByDesc('earned')->take(8)->get()->filter(fn ($u) => $u->earned > 0);
        $roles = User::selectRaw('role, count(*) as total')->groupBy('role')->pluck('total', 'role');

        return view('admin.marketplace.reports', compact('months', 'series', 'kpis', 'topListings', 'topEarners', 'roles'));
    }

    public function export(Request $request, string $dataset): StreamedResponse
    {
        [$headers, $rows] = match ($dataset) {
            'payments' => [
                ['Reference', 'Date', 'Payer', 'Listing', 'Package', 'Days', 'Amount', 'Currency', 'Status', 'Transaction ID'],
                ListingPayment::with(['user', 'payable', 'listingPackage'])->latest()->cursor()->map(fn ($p) => [
                    $p->reference, $p->created_at?->format('Y-m-d H:i'), $p->user->name ?? '', $p->payable->title ?? '',
                    $p->listingPackage?->package_tier, $p->days, $p->amount, $p->currency, $p->status, $p->transaction_id,
                ]),
            ],
            'commissions' => [
                ['Date', 'Earner', 'Role', 'Type', 'Listing', 'Base', 'Rate %', 'Amount', 'Currency', 'Status', 'Paid at'],
                Commission::with(['user', 'listable'])->latest()->cursor()->map(fn ($c) => [
                    $c->created_at?->format('Y-m-d'), $c->user->name ?? '', $c->role, $c->type, $c->listable->title ?? '',
                    $c->base_amount, $c->rate, $c->amount, $c->currency, $c->status, $c->paid_at?->format('Y-m-d'),
                ]),
            ],
            'inquiries' => [
                ['Date', 'Name', 'Email', 'Phone', 'Listing', 'Recipient', 'Status', 'Message'],
                Inquiry::with(['listable', 'recipient'])->latest()->cursor()->map(fn ($i) => [
                    $i->created_at?->format('Y-m-d H:i'), $i->name, $i->email, $i->phone, $i->listable->title ?? '',
                    $i->recipient->name ?? '', $i->status, $i->message,
                ]),
            ],
            'listings' => [
                ['Type', 'ID', 'Title', 'Price', 'Currency', 'Approved', 'Status', 'Views', 'Inquiries', 'Created'],
                ListingRef::collect(fn ($q) => $q->withCount('inquiries'))->map(fn ($l) => [
                    ListingRef::label($l), $l->id, $l->title, $l->price, $l->currency, $l->isApproved() ? 'yes' : 'no',
                    $l->status, $l->views_count, $l->inquiries_count, $l->created_at?->format('Y-m-d'),
                ]),
            ],
            'users' => [
                ['ID', 'Name', 'Email', 'Phone', 'Role', 'Active', 'Joined', 'Last seen'],
                User::latest()->cursor()->map(fn ($u) => [
                    $u->id, $u->name, $u->email, $u->phone, $u->role, $u->is_active ? 'yes' : 'no',
                    $u->created_at?->format('Y-m-d'), $u->last_seen_at?->format('Y-m-d H:i'),
                ]),
            ],
            default => abort(404),
        };

        return response()->streamDownload(function () use ($headers, $rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // Excel-friendly UTF-8
            fputcsv($out, $headers);
            foreach ($rows as $row) {
                // Neutralise spreadsheet formulas in user-supplied text.
                fputcsv($out, array_map(fn ($v) => is_string($v) && preg_match('/^[=+\-@\t\r]/', $v) ? "'" . $v : $v, $row));
            }
            fclose($out);
        }, 'terra-' . $dataset . '-' . now()->format('Ymd') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    // ── Settings ────────────────────────────────────────────────────────────
    public function settings()
    {
        $groups = collect(Settings::DEFINITIONS)->map(fn ($d, $key) => [
            'key' => $key, 'label' => $d[1], 'group' => $d[2], 'type' => $d[3], 'value' => Settings::get($key), 'default' => $d[0],
        ])->groupBy('group');

        return view('admin.marketplace.settings', compact('groups'));
    }

    public function saveSettings(Request $request)
    {
        $rules = [];
        foreach (Settings::DEFINITIONS as $key => $d) {
            $field = str_replace('.', '__', $key);
            $rules[$field] = $d[3] === 'number'
                ? (str_ends_with($key, '_pct') ? 'required|numeric|min:0|max:100' : 'required|numeric|min:0')
                : 'nullable|string|max:255';
        }
        $data = $request->validate($rules);
        Settings::set(collect($data)->mapWithKeys(fn ($v, $k) => [str_replace('__', '.', $k) => $v])->all());

        return back()->with('success', 'Settings saved.');
    }
}
