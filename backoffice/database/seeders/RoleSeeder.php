<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $admin = Role::findOrCreate('admin', 'web');
        $finance = Role::findOrCreate('finance', 'web');
        $owner = Role::findOrCreate('owner', 'web');

        $admin->syncPermissions(Permission::query()->pluck('name')->all());

        $finance->syncPermissions([
            'view dashboard',
            'manage bookings',
            'manage payments',
            'manage tickets',
            'view reports',
        ]);

        $owner->syncPermissions([
            'view dashboard',
            'view reports',
            'manage settings',
        ]);
    }
}
