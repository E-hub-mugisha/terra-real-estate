<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = [
            // Keep your five existing tenant arrays here.
        ];

        DB::transaction(function () use ($tenants) {
            foreach ($tenants as $data) {
                // Create or update the tenant's login account.
                $user = User::updateOrCreate(
                    ['email' => $data['email']],
                    [
                        'name' => $data['first_name'] . ' ' . $data['last_name'],
                        'password' => Hash::make('password'),
                        'email_verified_at' => now(),
                        'role' => 'tenant',
                    ]
                );

                // Create or update the profile and link it to the user.
                Tenant::updateOrCreate(
                    ['tenant_code' => $data['tenant_code']],
                    array_merge($data, [
                        'user_id' => $user->id,
                    ])
                );
            }
        });
    }
}