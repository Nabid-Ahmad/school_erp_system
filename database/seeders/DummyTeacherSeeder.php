<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;

class DummyTeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Abdur Rahman',
                'designation' => 'Headmaster',
                'subject' => 'Mathematics',
                'phone' => '01711223344',
                'salary' => 45000,
                'joining_date' => '2020-01-10'
            ],
            [
                'name' => 'Fatima Begum',
                'designation' => 'Assistant Teacher',
                'subject' => 'English',
                'phone' => '01822334455',
                'salary' => 25000,
                'joining_date' => '2021-05-15'
            ],
            [
                'name' => 'Kamal Hossain',
                'designation' => 'Senior Teacher',
                'subject' => 'Physics',
                'phone' => '01933445566',
                'salary' => 35000,
                'joining_date' => '2022-03-20'
            ],
            [
                'name' => 'Sultana Razia',
                'designation' => 'Lecturer',
                'subject' => 'Biology',
                'phone' => '01544556677',
                'salary' => 28000,
                'joining_date' => '2023-08-01'
            ]
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}
