<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function redirectRoute()
    {
        if (in_array($this->role, ['professional', 'consultant'])) {
            return 'users.dashboard.index';
        }

        return match ($this->role) {
            'admin' => 'admin.dashboard',
            'agent' => 'agent.dashboard.index',
            default => 'front.home',
        };
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
        return $this->roles()
            ->whereHas('permissions', fn($q) => $q->where('name', $permission))
            ->exists();
    }

    // Check if user has ANY of the given permissions
    public function hasAnyPermission(array $permissions): bool
    {
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

    // Check if user belongs to a named role
    public function hasRole(string $role): bool
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function assignedTasks()
    {
        return $this->hasMany(TerraTask::class, 'assigned_to');
    }

    public function taskSubmissions()
    {
        return $this->hasMany(TerraTaskSubmission::class, 'submitted_by');
    }

    public function taskDocuments()
    {
        return $this->hasMany(TerraTaskDocument::class, 'uploaded_by');
    }

    // app/Models/User.php
    public function consultant()
    {
        return $this->hasOne(\App\Models\Consultant::class);
    }
}
