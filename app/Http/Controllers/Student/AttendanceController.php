<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = \App\Models\Attendance::with('student.schoolClass')
            ->latest('date')
            ->paginate(20);
        return view('attendances.index', compact('attendances'));
    }

    public function create(Request $request)
    {
        $classes = \App\Models\SchoolClass::all();
        $students = [];
        $selected_class = $request->class_id;
        $selected_date = $request->date ?? date('Y-m-d');

        if ($selected_class) {
            $students = \App\Models\Student::where('school_class_id', $selected_class)->get();
        }

        return view('attendances.create', compact('classes', 'students', 'selected_class', 'selected_date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent',
        ]);

        foreach ($request->attendance as $student_id => $status) {
            \App\Models\Attendance::updateOrCreate(
                ['student_id' => $student_id, 'date' => $request->date],
                ['status' => $status]
            );
        }

        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully.');
    }
}
