<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SystemPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = [
            'property' => ['view', 'create', 'edit', 'update_status', 'approve', 'delete'],
            'listing'  => ['view', 'create', 'edit', 'update_status', 'approve', 'delete'],
            'client'   => ['view', 'create', 'edit', 'delete'],
            'contract' => ['view', 'create', 'edit', 'sign', 'approve', 'delete'],
            'payment'  => ['view', 'create', 'process', 'approve', 'refund'],
            'report'   => ['view', 'create', 'generate', 'approve', 'export'],
            'staff'    => ['view', 'create', 'edit', 'manage', 'assign_permissions'],
            'settings' => ['view', 'edit'],
            'dashboard' => ['view', 'analytics'],
            
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$module}.{$action}"]);
            }
        }

        // Staff Role
        $staff = Role::firstOrCreate(['name' => 'staff']);
        $staff->syncPermissions([
            'property.view',
            'property.edit',
            'property.update_status',
            'listing.view',
            'listing.edit',
            'listing.update_status',
            'client.view',
            'client.create',
            'client.edit',
            'contract.view',
            'contract.edit',
            'payment.view',
            'report.view',
            'report.generate',
            'staff.view',
            'dashboard.view',
        ]);

        // Admin Role
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());
    }
}
