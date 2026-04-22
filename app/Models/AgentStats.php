<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentStats extends Model
{
    protected $fillable = [
        'agent_id',
        'level_id',
        'total_referrals',
        'total_revenue_generated',
        'total_commissions_earned',
        'total_commissions_paid',
        'pending_payout',
        'last_level_upgrade_at',
    ];

    protected $casts = [
        'total_referrals'           => 'integer',
        'total_revenue_generated'   => 'integer',
        'total_commissions_earned'  => 'integer',
        'total_commissions_paid'    => 'integer',
        'pending_payout'            => 'integer',
        'last_level_upgrade_at'     => 'datetime',
    ];

    // Agent this stat belongs to
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // Level this agent is on
    public function level()
    {
        return $this->belongsTo(AgentLevel::class, 'level_id');
    }
}
