<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentLevel extends Model
{
    protected $fillable = [
        'level_name',
        'label',
        'badge_emoji',
        'badge_color',
        'commission_rate',
        'requirements',
    ];

    protected $casts = [
        'commission_rate' => 'float',
    ];

    // Available level names
    public static function levelNames(): array
    {
        return [
            'bronze' => 'Bronze',
            'silver' => 'Silver',
            'gold'   => 'Gold',
            'elite'  => 'Elite',
        ];
    }

    // Badge color options
    public static function badgeColors(): array
    {
        return [
            '#cd7f32' => 'Bronze',
            '#c0c0c0' => 'Silver',
            '#ffd700' => 'Gold',
            '#1a2d5a' => 'Elite (Navy)',
        ];
    }

    // Get agents at this level
    public function agentStats()
    {
        return $this->hasMany(AgentStats::class, 'level_id');
    }

    // Formatted commission rate
    public function getFormattedRateAttribute(): string
    {
        return $this->commission_rate . '%';
    }

    // Badge style for UI
    public function getBadgeStyleAttribute(): string
    {
        return 'background-color:' . $this->badge_color . '20;color:' . $this->badge_color . ';border:1px solid ' . $this->badge_color . '40';
    }
}
