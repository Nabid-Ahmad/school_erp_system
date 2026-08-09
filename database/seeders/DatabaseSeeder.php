<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
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

        // 1. Create Demo Users (one per role)
        $demoUsers = [
            [
                'name' => 'Super Admin',
                'email' => env('ADMIN_EMAIL', 'admin@school.com'),
                'password' => env('ADMIN_PASSWORD', 'admin1234'),
                'role' => 'admin',
            ],
            [
                'name' => 'Demo Teacher',
                'email' => 'teacher@school.com',
                'password' => 'teacher1234',
                'role' => 'teacher',
            ],
            [
                'name' => 'Demo Staff',
                'email' => 'staff@school.com',
                'password' => 'staff1234',
                'role' => 'staff',
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

        // 2. Create Classes
        $class6 = SchoolClass::firstOrCreate(['name' => 'Six']);
        $class7 = SchoolClass::firstOrCreate(['name' => 'Seven']);
        $class8 = SchoolClass::firstOrCreate(['name' => 'Eight']);

        // 3. Create Subjects
        Subject::firstOrCreate(['name' => 'Mathematics', 'school_class_id' => $class6->id]);
        Subject::firstOrCreate(['name' => 'English', 'school_class_id' => $class6->id]);
        Subject::firstOrCreate(['name' => 'General Science', 'school_class_id' => $class6->id]);

        Subject::firstOrCreate(['name' => 'Higher Math', 'school_class_id' => $class7->id]);
        Subject::firstOrCreate(['name' => 'Bangla', 'school_class_id' => $class7->id]);

        // 4. Create Students
        if (Student::count() == 0) {
            Student::create([
                'name' => 'Rahat Khan',
                'roll' => '1001',
                'school_class_id' => $class6->id,
                'phone' => '01711111111',
                'dob' => '2012-05-15',
            ]);

            Student::create([
                'name' => 'Sumaiya Akter',
                'roll' => '1002',
                'school_class_id' => $class6->id,
                'phone' => '01822222222',
                'dob' => '2012-08-20',
            ]);

            Student::create([
                'name' => 'Arif Ahmed',
                'roll' => '2001',
                'school_class_id' => $class7->id,
                'phone' => '01933333333',
                'dob' => '2011-03-10',
            ]);
        }
    }
}
