<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('student.schoolClass')
            ->latest('date')
            ->paginate(20);

        return view('attendances.index', compact('attendances'));
    }

    public function create(Request $request)
    {
        $classes = SchoolClass::all();
        $students = [];
        $selected_class = $request->class_id;
        $selected_date = $request->date ?? date('Y-m-d');

        if ($selected_class) {
            $students = Student::where('school_class_id', $selected_class)->get();
        }

        return view('attendances.create', compact('classes', 'students', 'selected_class', 'selected_date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class_id' => 'required|exists:school_classes,id',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent',
        ]);

        $studentIds = array_keys($request->attendance);

        if (empty($studentIds)) {
            return redirect()->back()->with('error', 'No attendance data was submitted.');
        }

        // Only allow marking attendance for students that actually belong to
        // the selected class, so users cannot tamper with other classes' records.
        $validCount = Student::whereIn('id', $studentIds)
            ->where('school_class_id', $request->class_id)
            ->count();

        if ($validCount !== count($studentIds)) {
            return redirect()->back()->with('error', 'Invalid students selected for this class.');
        }

        foreach ($request->attendance as $student_id => $status) {
            Attendance::updateOrCreate(
                ['student_id' => $student_id, 'date' => $request->date],
                ['status' => $status]
            );
        }

        return redirect()->route('attendances.index')->with('success', 'Attendance recorded successfully.');
    }
}
