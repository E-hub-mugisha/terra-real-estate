<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Admin-editable platform settings with safe defaults.
 */
class Settings
{
    /** key => [default, label, group, type] */
    public const DEFINITIONS = [
        // Packages & ads
        'ads.basic_share_pct'    => [20,  'Basic: % of paid days in the ad rotation', 'Packages & ads', 'number'],
        'ads.medium_share_pct'   => [50,  'Medium: % of paid days in the ad rotation', 'Packages & ads', 'number'],
        'ads.premium_share_pct'  => [100, 'Premium: % of paid days in the ad rotation', 'Packages & ads', 'number'],
        'ads.spotlight_max'      => [6,   'Maximum premium listings in the homepage pop-up', 'Packages & ads', 'number'],
        'ads.rotation_max'       => [12,  'Maximum listings in the homepage ads strip', 'Packages & ads', 'number'],
        'listings.hide_expired'  => [0,   'Hide listings from search when their package has expired (1 = yes)', 'Packages & ads', 'number'],

        // Commissions & earnings
        'commission.agent_listing_pct'   => [20, 'Agent: % of listing package fee', 'Commissions', 'number'],
        'commission.agent_deal_pct'      => [3,  'Agent: % of deal value when sold/rented', 'Commissions', 'number'],
        'commission.partner_listing_pct' => [15, 'Partner: % of listing package fee', 'Commissions', 'number'],
        'commission.partner_deal_pct'    => [2,  'Partner: % of deal value when sold/rented', 'Commissions', 'number'],
        'commission.partner_referral_flat' => [5000, 'Partner: flat reward (RWF) per converted referral', 'Commissions', 'number'],

        // Contacts
        'contact.whatsapp' => ['250796511725', 'Support WhatsApp number (international format, no +)', 'Contact', 'text'],
        'contact.email'    => ['terraltd.rd@gmail.com', 'Support email', 'Contact', 'text'],
        'contact.phone'    => ['+250 796 511 725', 'Support phone (display)', 'Contact', 'text'],
    ];

    public static function get(string $key, $default = null)
    {
        $all = static::all();
        if (array_key_exists($key, $all)) {
            return $all[$key];
        }

        return $default ?? (static::DEFINITIONS[$key][0] ?? null);
    }

    public static function number(string $key): float
    {
        return (float) static::get($key);
    }

    public static function all(): array
    {
        return Cache::remember('terra.settings', 300, function () {
            $values = array_map(fn ($d) => $d[0], static::DEFINITIONS);
            try {
                if (Schema::hasTable('settings')) {
                    $values = array_merge($values, Setting::pluck('value', 'key')->all());
                }
            } catch (\Throwable $e) {
                // database not ready (e.g. during install)
            }

            return $values;
        });
    }

    public static function set(array $values): void
    {
        foreach ($values as $key => $value) {
            if (!array_key_exists($key, static::DEFINITIONS)) {
                continue;
            }
            Setting::updateOrCreate(['key' => $key], ['value' => is_null($value) ? null : (string) $value]);
        }
        Cache::forget('terra.settings');
    }
}
