<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        if (! class_exists(\Spatie\Permission\Models\Role::class)) {
            return;
        }

        $permissions = [
            'manage users',
            'manage categories',
            'manage formations',
            'manage sessions',
            'manage inscriptions',
            'publish formation',
            'view dashboard',
            'manage blog',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'Super Admin' => $permissions,
            'Admin' => [
                'manage users',
                'manage categories',
                'manage formations',
                'manage sessions',
                'manage inscriptions',
                'publish formation',
                'view dashboard',
                'manage blog',
                'view reports',
            ],
            'Formateur' => [
                'view dashboard',
                'manage sessions',
                'manage formations',
            ],
            'Participant' => [
                'view dashboard',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
