<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create basic permissions
        $permissions = [
            'manage users',
            'manage classes',
            'manage subjects',
            'manage teachers',
            'manage students',
            'manage fees',
            'manage attendances',
            'manage results',
            'manage galleries',
            'manage events',
            'manage expenses',
            'manage salaries',
            'manage promotions',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin role gets every permission. The Gate::before() bypass in
        // AppServiceProvider already grants admins all abilities, but seeding
        // the role keeps the permission tables consistent for tooling.
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions($permissions);

        // Teacher role: academic day-to-day operations only.
        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->syncPermissions([
            'manage attendances',
            'manage results',
        ]);

        // Staff role: receives no permissions by default. An admin grants
        // individual abilities (e.g. manage fees) through User Management.
        Role::firstOrCreate(['name' => 'staff']);
    }
}
