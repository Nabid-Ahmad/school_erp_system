<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\PermissionSeeder::class);
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_teacher_sees_no_financial_data_on_dashboard(): void
    {
        $class = \App\Models\SchoolClass::create(['name' => 'Six']);
        $student = Student::create(['name' => 'Rahat', 'roll' => '1001', 'school_class_id' => $class->id]);
        Fee::create(['student_id' => $student->id, 'amount' => 500, 'fee_type' => 'Monthly Fee', 'month' => 'August', 'year' => 2026, 'status' => 'paid']);

        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get('/dashboard');

        $response->assertOk();
        $response->assertDontSee('Monthly Income');
        $response->assertDontSee('Monthly Net Profit');
        $response->assertDontSee('Financial Overview');
        $response->assertDontSee('Class-wise Fee Collection');
    }

    public function test_admin_sees_financial_data_on_dashboard(): void
    {
        $class = \App\Models\SchoolClass::create(['name' => 'Six']);
        $student = Student::create(['name' => 'Rahat', 'roll' => '1001', 'school_class_id' => $class->id]);
        Fee::create(['student_id' => $student->id, 'amount' => 500, 'fee_type' => 'Monthly Fee', 'month' => 'August', 'year' => 2026, 'status' => 'paid']);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Financial Overview');
        $response->assertSee('Monthly Net Profit');
    }

    public function test_admin_sees_class_wise_school_analytics(): void
    {
        $class = \App\Models\SchoolClass::create(['name' => 'Six']);
        $student = Student::create(['name' => 'Rahat', 'roll' => '1001', 'school_class_id' => $class->id]);
        $subject = Subject::create(['name' => 'Math', 'school_class_id' => $class->id]);

        Attendance::create([
            'student_id' => $student->id,
            'date' => now()->toDateString(),
            'status' => 'present',
        ]);
        Fee::create([
            'student_id' => $student->id,
            'amount' => 500,
            'fee_type' => 'Monthly Fee',
            'month' => now()->format('F'),
            'year' => now()->year,
            'status' => 'paid',
        ]);
        Result::create([
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'marks' => 85,
            'grade' => 'A+',
        ]);

        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('School Analytics');
        $response->assertSee('Class-wise Attendance');
        $response->assertSee('Class-wise Fee Collection');
        $response->assertSee('Class-wise Results');
        $response->assertSee('classAttendanceChart');
        $response->assertSee('classFeesChart');
        $response->assertSee('classResultsChart');
    }

    public function test_register_routes_are_disabled(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [
            'name' => 'Hacker',
            'email' => 'hacker@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertNotFound();
    }

    public function test_fee_only_user_can_search_students_by_roll(): void
    {
        $class = \App\Models\SchoolClass::create(['name' => 'Six']);
        Student::create(['name' => 'Rahat', 'roll' => '1001', 'school_class_id' => $class->id]);

        $user = User::factory()->create(['role' => 'staff']);
        $user->givePermissionTo('manage fees');

        $response = $this->actingAs($user)->get('/api/students/find/1001');

        $response->assertOk();
        $response->assertJson(['name' => 'Rahat']);
    }

    public function test_user_without_student_or_fee_permission_cannot_search_students(): void
    {
        $class = \App\Models\SchoolClass::create(['name' => 'Six']);
        Student::create(['name' => 'Rahat', 'roll' => '1001', 'school_class_id' => $class->id]);

        $user = User::factory()->create(['role' => 'staff']);

        $response = $this->actingAs($user)->get('/api/students/find/1001');

        $response->assertForbidden();
    }

    public function test_attendance_store_rejects_students_not_in_selected_class(): void
    {
        $class = \App\Models\SchoolClass::create(['name' => 'Six']);
        $other = \App\Models\SchoolClass::create(['name' => 'Seven']);
        $classStudent = Student::create(['name' => 'In Class', 'roll' => '1001', 'school_class_id' => $class->id]);
        $otherStudent = Student::create(['name' => 'Other Class', 'roll' => '2001', 'school_class_id' => $other->id]);

        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->post('/attendances', [
            'date' => '2026-08-09',
            'class_id' => $class->id,
            'attendance' => [
                $classStudent->id => 'present',
                $otherStudent->id => 'absent',
            ],
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('attendances', ['student_id' => $otherStudent->id]);
    }
}
