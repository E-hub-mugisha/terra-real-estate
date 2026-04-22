<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. PERMISSIONS ───────────────────────────────────────
        $permissions = [
            // name         label                   group
            ['review',  'Review Records',        'content'],
            ['add',     'Add Records',            'content'],
            ['edit',    'Edit Records',           'content'],
            ['update',  'Update Records',         'content'],
            ['delete',  'Delete Records',         'content'],
            ['approve', 'Approve Records',        'content'],
        ];

        foreach ($permissions as [$name, $label, $group]) {
            Permission::firstOrCreate(
                ['name' => $name],
                ['label' => $label, 'group' => $group]
            );
        }

        // ── 2. ROLES WITH PERMISSIONS ────────────────────────────
        $roles = [
            [
                'name'        => 'administrator',
                'label'       => 'Administrator',
                'department'  => 'Administration',
                'color'       => '#19265d',
                'description' => 'Full access — can review, add, edit, update, approve and delete.',
                'permissions' => ['review', 'add', 'edit', 'update', 'delete', 'approve'],
            ],
            [
                'name'        => 'marketing',
                'label'       => 'Marketing & IT',
                'department'  => 'Marketing & IT',
                'color'       => '#1E7A5A',
                'description' => 'Can review, add and edit records. Cannot approve or delete.',
                'permissions' => ['review', 'add', 'edit'],
            ],
            [
                'name'        => 'partnership',
                'label'       => 'Partnership',
                'department'  => 'Partnership',
                'color'       => '#B45309',
                'description' => 'Read-only access — can only review records.',
                'permissions' => ['review'],
            ],
            [
                'name'        => 'operations',
                'label'       => 'Operations',
                'department'  => 'Operations',
                'color'       => '#6B21A8',
                'description' => 'Can review and edit records.',
                'permissions' => ['review', 'edit'],
            ],
        ];

        foreach ($roles as $roleData) {
            $permissionNames = $roleData['permissions'];
            unset($roleData['permissions']);

            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                $roleData
            );

            // Sync permissions
            $role->syncPermissionsByName($permissionNames);
        }

        $this->command->info('✓ Roles and permissions seeded successfully.');

        $adminRole = Role::where('name', 'administrator')->first();

        \App\Models\User::where('role', 'admin')->each(function ($user) use ($adminRole) {
            $user->roles()->syncWithoutDetaching([$adminRole->id]);
        });

        $this->command->info('✓ Existing administrator users linked to administrator role.');
    }
}
