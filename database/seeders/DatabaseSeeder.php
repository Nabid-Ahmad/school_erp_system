<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // 2. Create Classes
        $class6 = \App\Models\SchoolClass::firstOrCreate(['name' => 'Six']);
        $class7 = \App\Models\SchoolClass::firstOrCreate(['name' => 'Seven']);
        $class8 = \App\Models\SchoolClass::firstOrCreate(['name' => 'Eight']);

        // 3. Create Subjects
        \App\Models\Subject::firstOrCreate(['name' => 'Mathematics', 'school_class_id' => $class6->id]);
        \App\Models\Subject::firstOrCreate(['name' => 'English', 'school_class_id' => $class6->id]);
        \App\Models\Subject::firstOrCreate(['name' => 'General Science', 'school_class_id' => $class6->id]);

        \App\Models\Subject::firstOrCreate(['name' => 'Higher Math', 'school_class_id' => $class7->id]);
        \App\Models\Subject::firstOrCreate(['name' => 'Bangla', 'school_class_id' => $class7->id]);

        // 4. Create Students
        if (\App\Models\Student::count() == 0) {
            \App\Models\Student::create([
                'name' => 'Rahat Khan',
                'roll' => '1001',
                'school_class_id' => $class6->id,
                'phone' => '01711111111',
                'dob' => '2012-05-15'
            ]);

            \App\Models\Student::create([
                'name' => 'Sumaiya Akter',
                'roll' => '1002',
                'school_class_id' => $class6->id,
                'phone' => '01822222222',
                'dob' => '2012-08-20'
            ]);

            \App\Models\Student::create([
                'name' => 'Arif Ahmed',
                'roll' => '2001',
                'school_class_id' => $class7->id,
                'phone' => '01933333333',
                'dob' => '2011-03-10'
            ]);
        }
    }
}
