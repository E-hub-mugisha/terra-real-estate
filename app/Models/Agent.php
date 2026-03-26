<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'bio',
        'linkedin',
        'facebook',
        'instagram',
        'twitter',
        'profile_image',
        'whatsapp',
        'office_location',
        'languages',
        'is_verified',
        'agent_level_id',
        'total_referrals',
        'total_revenue_generated',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(AgentReview::class);
    }
    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'agent_service');
    }
    public function level()
    {
        return $this->belongsTo(AgentLevel::class, 'agent_level_id');
    }

    public function commissions()
    {
        return $this->hasMany(AgentCommission::class);
    }

    /**
     * The listing commission % this agent earns — comes from ListingPackage.
     * The sale commission % — comes from AgentLevel.
     */
    public function getSaleCommissionRate(): float
    {
        return (float) ($this->level?->commission_rate ?? 0);
    }

    /**
     * Check if agent qualifies for a level upgrade and apply it.
     */
    public function checkAndUpgradeLevel(): void
    {
        $levels = AgentLevel::orderByDesc('commission_rate')->get();

        foreach ($levels as $level) {
            $requirements = $this->parseLevelRequirements($level);

            if (
                $this->total_referrals >= $requirements['referrals']
                || $this->total_revenue_generated >= $requirements['revenue']
            ) {
                if ($this->agent_level_id !== $level->id) {
                    $this->update(['agent_level_id' => $level->id]);
                }
                return;
            }
        }
    }

    private function parseLevelRequirements(AgentLevel $level): array
    {
        // Map level names to hard-coded thresholds from your seeder
        return match ($level->level_name) {
            'elite'  => ['referrals' => 75,  'revenue' => 10_000_000],
            'gold'   => ['referrals' => 30,  'revenue' =>  2_000_000],
            'silver' => ['referrals' => 10,  'revenue' =>    500_000],
            default  => ['referrals' => 0,   'revenue' =>          0],
        };
    }

    protected static function booted()
    {
        static::deleting(function ($agent) {
            if ($agent->user) {
                $agent->user->delete();
            }
        });
    }
}
