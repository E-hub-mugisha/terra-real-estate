<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'whatsapp',
        'avatar',
        'national_id',
        'bio',
        'province',
        'district',
        'is_active',
        'last_seen_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_seen_at' => 'datetime',
        ];
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }

    public function lands()
    {
        return $this->hasMany(Land::class);
    }
    public function architecturalDesigns()
    {
        return $this->hasMany(ArchitecturalDesign::class);
    }
    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public const ROLES = [
        'client'  => 'Client',
        'owner'   => 'Property owner',
        'agent'   => 'Agent',
        'partner' => 'Independent partner',
        'staff'   => 'Staff',
        'admin'   => 'Administrator',
    ];

    public function redirectRoute(): string
    {
        return match ($this->role) {
            'admin', 'staff' => 'admin.dashboard',
            'agent'   => 'agent.dashboard.index',
            'owner'   => 'owner.dashboard',
            'partner' => 'partner.dashboard',
            default   => 'client.dashboard',
        };
    }

    public function roleLabel(): string
    {
        return self::ROLES[$this->role] ?? ucfirst((string) $this->role);
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'staff'], true);
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    public function isPartner(): bool
    {
        return $this->role === 'partner';
    }

    /** Roles that list properties (owner, agent, partner). */
    public function canList(): bool
    {
        return in_array($this->role, ['owner', 'agent', 'partner', 'admin', 'staff'], true);
    }

    public function partnerProfile(): HasOne
    {
        return $this->hasOne(PartnerProfile::class);
    }

    public function savedListings(): HasMany
    {
        return $this->hasMany(SavedListing::class);
    }

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')->withPivot('last_read_at')->withTimestamps();
    }

    public function inquiriesReceived(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'recipient_id');
    }

    public function inquiriesSent(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'sender_id');
    }

    public function viewingsRequested(): HasMany
    {
        return $this->hasMany(Viewing::class, 'client_id');
    }

    public function viewingsHosted(): HasMany
    {
        return $this->hasMany(Viewing::class, 'host_id');
    }

    public function offersMade(): HasMany
    {
        return $this->hasMany(Offer::class, 'client_id');
    }

    public function offersReceived(): HasMany
    {
        return $this->hasMany(Offer::class, 'recipient_id');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(Commission::class);
    }

    public function assignedListings(): HasMany
    {
        return $this->hasMany(ListingAssignment::class);
    }

    public function unreadMessagesCount(): int
    {
        return Message::query()
            ->join('conversation_participants as cp', function ($j) {
                $j->on('cp.conversation_id', '=', 'messages.conversation_id')->where('cp.user_id', $this->id);
            })
            ->where('messages.user_id', '!=', $this->id)
            ->where(fn ($q) => $q->whereNull('cp.last_read_at')->orWhereColumn('messages.created_at', '>', 'cp.last_read_at'))
            ->count();
    }

    public function avatarUrl(): ?string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    // ── Role relationship ────────────────────────────
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    // Primary role (first assigned, or highest)
    public function primaryRole(): ?Role
    {
        return $this->roles()->with('permissions')->first();
    }

    // Check a single permission across all roles
    public function hasPermission(string $permission): bool
    {
        // Platform admins have every permission; staff get theirs from roles.
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->roles()
            ->whereHas('permissions', fn($q) => $q->where('name', $permission))
            ->exists();
    }

    // Check if user has ANY of the given permissions
    public function hasAnyPermission(array $permissions): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->roles()
            ->whereHas('permissions', fn($q) => $q->whereIn('name', $permissions))
            ->exists();
    }

    // Check if user has ALL given permissions
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $perm) {
            if (!$this->hasPermission($perm)) return false;
        }
        return true;
    }

    /** Admin account (role column) or the "administrator" staff role. */
    public function isSuperAdmin(): bool
    {
        return in_array($this->role, ['admin', 'administrator'], true) || $this->hasRole('administrator');
    }

    // Check if user belongs to a named role
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
