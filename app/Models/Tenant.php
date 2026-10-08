<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'first_name',
        'last_name',
        'email',
        'phone',

        'national_id',
        'date_of_birth',
        'gender',

        'district',
        'sector',
        'cell',
        'village',
        'address',

        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',

        'kyc_status',
        'status',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | User Account
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Future Lease Relationship
    |--------------------------------------------------------------------------
    */

    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(TenantApplication::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim(
            $this->first_name . ' ' . $this->last_name
        );
    }

    public function invoices()
    {
        return $this->hasMany(RentInvoice::class);
    }

    public function payments()
    {
        return $this->hasMany(
            RentPayment::class,
            'tenant_id'
        );
    }

    public function ledgerEntries()
    {
        return $this->hasMany(RentLedgerEntries::class);
    }

    public function receipts()
    {
        return $this->hasMany(RentReceipt::class);
    }
}
