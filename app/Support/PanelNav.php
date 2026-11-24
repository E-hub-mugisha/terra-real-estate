<?php

namespace App\Support;

use App\Models\Agent;
use App\Models\ArchitecturalDesign;
use App\Models\Commission;
use App\Models\House;
use App\Models\Inquiry;
use App\Models\Land;
use App\Models\ListingPayment;
use App\Models\PartnerProfile;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Sidebar navigation, quick-create links and activity feed for each room.
 * Every role shares the same panel shell; what they see is decided here.
 */
class PanelNav
{
    public static function for(?User $user): array
    {
        if (!$user) {
            return self::client(null);
        }

        return match ($user->role) {
            'admin', 'staff' => self::admin(),
            'agent' => self::agent($user),
            'owner' => self::owner($user),
            'partner' => self::partner($user),
            default => self::client($user),
        };
    }

    // ── Shared blocks ────────────────────────────────────────────────────────
    private static function communication(User $user, bool $hosts): array
    {
        $badges = self::badges($user);

        return ['label' => 'Communication', 'items' => [
            ['label' => 'Messages', 'icon' => 'mail', 'route' => 'room.messages.index', 'active' => 'room.messages.*', 'badge' => $badges['messages']],
            ['label' => 'Inquiries', 'icon' => 'list', 'route' => 'room.inquiries.index', 'active' => 'room.inquiries.*', 'badge' => $hosts ? $badges['inquiries'] : 0],
            ['label' => 'Viewings', 'icon' => 'calendar', 'route' => 'room.viewings.index', 'active' => 'room.viewings.*', 'badge' => $hosts ? $badges['viewings'] : 0],
            ['label' => 'Offers', 'icon' => 'tag', 'route' => 'room.offers.index', 'active' => 'room.offers.*', 'badge' => $hosts ? $badges['offers'] : 0],
        ]];
    }

    private static function listingBlock(string $label = 'My properties'): array
    {
        return ['label' => $label, 'items' => [
            ['label' => 'All my listings', 'icon' => 'layers', 'route' => 'room.listings.index', 'active' => ['room.listings.*', 'agent.properties.*', 'agent.designs.index', 'agent.designs.show', 'agent.designs.edit']],
            ['label' => 'Add property', 'icon' => 'plus', 'active' => ['agent.properties.houses.create', 'agent.properties.lands.create', 'agent.designs.create'], 'children' => [
                ['label' => 'House', 'route' => 'agent.properties.houses.create'],
                ['label' => 'Land', 'route' => 'agent.properties.lands.create'],
                ['label' => 'Architectural design', 'route' => 'agent.designs.create'],
            ]],
            ['label' => 'Performance', 'icon' => 'trending', 'route' => 'room.performance', 'active' => 'room.performance'],
        ]];
    }

    private static function badges(User $user): array
    {
        static $cache = [];

        return $cache[$user->id] ??= [
            'messages' => $user->unreadMessagesCount(),
            'inquiries' => $user->inquiriesReceived()->where('status', 'new')->count(),
            'viewings' => $user->viewingsHosted()->where('status', 'requested')->count(),
            'offers' => $user->offersReceived()->where('status', 'pending')->count(),
        ];
    }

    private static function createLinks(): array
    {
        return [
            ['House', 'home', route('agent.properties.houses.create')],
            ['Land', 'land', route('agent.properties.lands.create')],
            ['Design', 'ruler', route('agent.designs.create')],
        ];
    }

    // ── Rooms ────────────────────────────────────────────────────────────────
    private static function owner(User $user): array
    {
        return [
            'tag' => 'Owner',
            'home' => route('owner.dashboard'),
            'nav' => [
                ['label' => null, 'items' => [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'owner.dashboard', 'active' => 'owner.dashboard'],
                ]],
                self::listingBlock(),
                self::communication($user, true),
                ['label' => 'Account', 'items' => [
                    ['label' => 'My profile', 'icon' => 'user', 'route' => 'profile.show', 'active' => 'profile.*'],
                ]],
            ],
            'create' => self::createLinks(),
            'activity' => null,
        ];
    }

    private static function client(?User $user): array
    {
        return [
            'tag' => 'Client',
            'home' => $user ? route('client.dashboard') : route('front.home'),
            'nav' => array_values(array_filter([
                ['label' => null, 'items' => [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'client.dashboard', 'active' => 'client.dashboard'],
                    ['label' => 'Search properties', 'icon' => 'search', 'route' => 'front.properties.buy', 'external' => false],
                    ['label' => 'Saved properties', 'icon' => 'heart', 'route' => 'room.saved.index', 'active' => 'room.saved.*'],
                ]],
                $user ? self::communication($user, false) : null,
                ['label' => 'Account', 'items' => [
                    ['label' => 'My profile', 'icon' => 'user', 'route' => 'profile.show', 'active' => 'profile.*'],
                ]],
            ])),
            'create' => [],
            'activity' => null,
        ];
    }

    private static function agent(User $user): array
    {
        $profile = $user->agent;

        return [
            'tag' => 'Agent',
            'home' => route('agent.dashboard.index'),
            'nav' => [
                ['label' => null, 'items' => [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'agent.dashboard.index', 'active' => 'agent.dashboard.*'],
                ]],
                self::listingBlock('Properties'),
                ['label' => 'Clients & leads', 'items' => [
                    ['label' => 'Client leads', 'icon' => 'users', 'route' => 'room.referrals.index', 'active' => 'room.referrals.*'],
                    ['label' => 'Assigned listings', 'icon' => 'briefcase', 'route' => 'room.assigned', 'active' => 'room.assigned'],
                ]],
                self::communication($user, true),
                ['label' => 'Earnings', 'items' => [
                    ['label' => 'Commissions', 'icon' => 'credit', 'route' => 'room.earnings', 'active' => 'room.earnings'],
                ]],
                ['label' => 'Account', 'items' => array_values(array_filter([
                    ['label' => 'Agent profile', 'icon' => 'user', 'route' => 'agent.profile.view', 'active' => ['agent.profile.*', 'profile.show']],
                    $profile ? ['label' => 'Public profile', 'icon' => 'external', 'href' => route('front.agent.details', $profile), 'external' => true] : null,
                ]))],
            ],
            'create' => self::createLinks(),
            'activity' => null,
        ];
    }

    private static function partner(User $user): array
    {
        return [
            'tag' => 'Partner',
            'home' => route('partner.dashboard'),
            'nav' => [
                ['label' => null, 'items' => [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'partner.dashboard', 'active' => 'partner.dashboard'],
                ]],
                ['label' => 'Referrals', 'items' => [
                    ['label' => 'Owner & client leads', 'icon' => 'users', 'route' => 'room.referrals.index', 'active' => 'room.referrals.*'],
                    ['label' => 'Assigned listings', 'icon' => 'briefcase', 'route' => 'room.assigned', 'active' => 'room.assigned'],
                ]],
                self::listingBlock('Submitted properties'),
                self::communication($user, true),
                ['label' => 'Earnings', 'items' => [
                    ['label' => 'Partnership earnings', 'icon' => 'credit', 'route' => 'room.earnings', 'active' => 'room.earnings'],
                ]],
                ['label' => 'Account', 'items' => [
                    ['label' => 'My profile', 'icon' => 'user', 'route' => 'profile.show', 'active' => 'profile.*'],
                ]],
            ],
            'create' => self::createLinks(),
            'activity' => null,
        ];
    }

    private static function admin(): array
    {
        $pendingPayments = ListingPayment::where('status', 'processing')->count();
        $pendingPartners = PartnerProfile::where('status', 'pending')->count();
        $pendingCommissions = Commission::where('status', 'pending')->count();
        $pendingListings = House::where('is_approved', false)->count() + Land::where('is_approved', false)->count()
            + ArchitecturalDesign::where('status', 'pending')->count();

        return [
            'tag'  => 'Admin',
            'home' => route('admin.dashboard'),
            'nav'  => [
                ['label' => null, 'items' => [
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
                    ['label' => 'Approval queue', 'icon' => 'shield', 'route' => 'admin.marketplace.approvals', 'active' => 'admin.marketplace.approvals', 'badge' => $pendingListings],
                ]],
                ['label' => 'Listings', 'items' => [
                    ['label' => 'Houses', 'icon' => 'home', 'route' => 'admin.properties.houses.index', 'active' => 'admin.properties.houses.*'],
                    ['label' => 'Land', 'icon' => 'land', 'route' => 'admin.properties.lands.index', 'active' => 'admin.properties.lands.*'],
                    ['label' => 'Designs', 'icon' => 'ruler', 'active' => ['admin.architectural-designs.*', 'admin.properties.architectural-designs.*', 'admin.design-categories.*'], 'children' => [
                        ['label' => 'All designs', 'route' => 'admin.architectural-designs.index', 'active' => ['admin.architectural-designs.*', 'admin.properties.architectural-designs.*']],
                        ['label' => 'Categories', 'route' => 'admin.design-categories.index', 'active' => 'admin.design-categories.*'],
                    ]],
                    ['label' => 'Documents', 'icon' => 'file', 'route' => 'admin.marketplace.documents', 'active' => 'admin.marketplace.documents'],
                    ['label' => 'Facilities', 'icon' => 'check', 'route' => 'admin.facilities.index', 'active' => 'admin.facilities.*'],
                ]],
                ['label' => 'Marketplace activity', 'items' => [
                    ['label' => 'Inquiries', 'icon' => 'list', 'route' => 'admin.marketplace.inquiries', 'active' => 'admin.marketplace.inquiries'],
                    ['label' => 'Viewings & offers', 'icon' => 'calendar', 'route' => 'admin.marketplace.deals', 'active' => 'admin.marketplace.deals'],
                    ['label' => 'Leads & referrals', 'icon' => 'users', 'route' => 'admin.marketplace.referrals', 'active' => 'admin.marketplace.referrals'],
                    ['label' => 'Assignments', 'icon' => 'briefcase', 'route' => 'admin.marketplace.assignments', 'active' => 'admin.marketplace.assignments'],
                ]],
                ['label' => 'People', 'items' => [
                    ['label' => 'All users', 'icon' => 'user', 'route' => 'admin.marketplace.users', 'active' => ['admin.marketplace.users', 'admin.users.*']],
                    ['label' => 'Agents', 'icon' => 'users', 'route' => 'admin.agents.index', 'active' => 'admin.agents.*'],
                    ['label' => 'Partners', 'icon' => 'briefcase', 'route' => 'admin.marketplace.partners', 'active' => 'admin.marketplace.partners', 'badge' => $pendingPartners],
                    ['label' => 'Clients (owners CRM)', 'icon' => 'id', 'route' => 'admin.clients.index', 'active' => 'admin.clients.*'],
                ]],
                ['label' => 'Money', 'items' => [
                    ['label' => 'Payments', 'icon' => 'credit', 'route' => 'admin.marketplace.payments', 'active' => 'admin.marketplace.payments', 'badge' => $pendingPayments],
                    ['label' => 'Promotions & ads', 'icon' => 'star', 'route' => 'admin.marketplace.promotions', 'active' => 'admin.marketplace.promotions'],
                    ['label' => 'Commissions', 'icon' => 'percent', 'route' => 'admin.marketplace.commissions', 'active' => 'admin.marketplace.commissions', 'badge' => $pendingCommissions],
                    ['label' => 'Packages', 'icon' => 'package', 'active' => ['admin.listing-packages.*', 'admin.duration-discounts.*', 'admin.pricing-plans.*', 'admin.property-plan-orders.*'], 'children' => [
                        ['label' => 'Listing packages', 'route' => 'admin.listing-packages.index', 'active' => 'admin.listing-packages.*'],
                        ['label' => 'Duration discounts', 'route' => 'admin.duration-discounts.index', 'active' => 'admin.duration-discounts.*'],
                        ['label' => 'Pricing plans', 'route' => 'admin.pricing-plans.index', 'active' => 'admin.pricing-plans.*'],
                    ]],
                ]],
                ['label' => 'System', 'items' => [
                    ['label' => 'Reports', 'icon' => 'trending', 'route' => 'admin.marketplace.reports', 'active' => 'admin.marketplace.reports'],
                    ['label' => 'Settings', 'icon' => 'settings', 'route' => 'admin.marketplace.settings', 'active' => 'admin.marketplace.settings'],
                    ['label' => 'Staff', 'icon' => 'briefcase', 'route' => 'admin.staff.index', 'active' => ['admin.staff.*', 'staff.permissions.*']],
                    ['label' => 'Departments', 'icon' => 'building', 'route' => 'staff.departments.index', 'active' => 'staff.departments.*'],
                    ['label' => 'Roles & permissions', 'icon' => 'lock', 'route' => 'admin.roles.index', 'active' => 'admin.roles.*'],
                ]],
            ],
            'create' => [
                ['House', 'home', route('admin.properties.houses.create')],
                ['Land', 'land', route('admin.properties.lands.create')],
                ['Design', 'ruler', route('admin.architectural-designs.create')],
                ['Agent', 'users', route('admin.agents.create')],
            ],
            'activity' => self::activity(),
        ];
    }

    private static function activity(): Collection
    {
        return collect()
            ->merge(House::latest()->take(3)->get()->map(fn ($h) => ['title' => $h->title, 'label' => 'House', 'icon' => 'home', 'created_at' => $h->created_at, 'url' => route('admin.properties.houses.show', $h)]))
            ->merge(Land::latest()->take(3)->get()->map(fn ($l) => ['title' => $l->title, 'label' => 'Land', 'icon' => 'land', 'created_at' => $l->created_at, 'url' => route('admin.properties.lands.show', $l)]))
            ->merge(ArchitecturalDesign::latest()->take(3)->get()->map(fn ($d) => ['title' => $d->title, 'label' => 'Design', 'icon' => 'ruler', 'created_at' => $d->created_at, 'url' => route('admin.properties.architectural-designs.show', $d)]))
            ->merge(Agent::latest()->take(3)->get()->map(fn ($a) => ['title' => $a->full_name, 'label' => 'New agent', 'icon' => 'users', 'created_at' => $a->created_at, 'url' => route('admin.agents.show', $a)]))
            ->merge(Inquiry::with('listable')->latest()->take(3)->get()->map(fn ($i) => ['title' => $i->name . ' → ' . ($i->listable->title ?? 'listing'), 'label' => 'Inquiry', 'icon' => 'mail', 'created_at' => $i->created_at, 'url' => route('admin.marketplace.inquiries')]))
            ->sortByDesc('created_at')
            ->take(8)
            ->values();
    }
}
