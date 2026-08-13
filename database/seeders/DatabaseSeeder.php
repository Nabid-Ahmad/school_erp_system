<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run Permissions first
        $this->call(PermissionSeeder::class);

        // 1. Create Demo Users (Admin only)
        $demoUsers = [
            [
                'name' => 'Super Admin',
                'email' => env('ADMIN_EMAIL', 'admin@school.com'),
                'password' => env('ADMIN_PASSWORD', 'admin1234'),
                'role' => 'admin',
            ],
        ];

        foreach ($demoUsers as $demoUser) {
            $user = User::updateOrCreate(
                ['email' => $demoUser['email']],
                [
                    'name' => $demoUser['name'],
                    'password' => bcrypt($demoUser['password']),
                    'role' => $demoUser['role'],
                ]
            );

            // Keep the Spatie role in sync with the role column so that the
            // role-based routes and the permission-based sidebar agree.
            if (Role::where('name', $demoUser['role'])->exists()) {
                $user->syncRoles([$demoUser['role']]);
            }
        }

        if (! env('ADMIN_PASSWORD') && app()->environment('production')) {
            Log::warning('ADMIN_PASSWORD is not set. Falling back to the default demo password.');
        }

    }
}
