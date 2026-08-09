<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::with(['student.schoolClass', 'subject'])
            ->latest()
            ->paginate(20);

        return view('results.index', compact('results'));
    }

    public function create(Request $request)
    {
        $classes = SchoolClass::all();
        $subjects = [];
        $students = [];
        $selected_class = $request->class_id;
        $selected_subject = $request->subject_id;

        if ($selected_class) {
            $subjects = Subject::where('school_class_id', $selected_class)->get();
            $students = Student::where('school_class_id', $selected_class)->get();
        }

        return view('results.create', compact('classes', 'subjects', 'students', 'selected_class', 'selected_subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:school_classes,id',
            'marks' => 'required|array',
            'marks.*' => 'nullable|integer|min:0|max:100',
        ]);

        $subject = Subject::find($request->subject_id);

        // The selected subject must belong to the selected class so results
        // cannot be recorded for the wrong subject/class combination.
        if (! $subject || $subject->school_class_id !== (int) $request->class_id) {
            return redirect()->back()->with('error', 'The selected subject does not belong to the selected class.');
        }

        $studentIds = array_keys(array_filter($request->marks, fn ($mark) => $mark !== null));

        if (empty($studentIds)) {
            return redirect()->back()->with('error', 'No marks were submitted.');
        }

        // Only allow entering marks for students that belong to the class the
        // subject belongs to, so users cannot tamper with other classes' results.
        $validCount = Student::whereIn('id', $studentIds)
            ->where('school_class_id', $request->class_id)
            ->count();

        if ($validCount !== count($studentIds)) {
            return redirect()->back()->with('error', 'Invalid students selected for this subject.');
        }

        foreach ($request->marks as $student_id => $mark) {
            if ($mark !== null) {
                Result::updateOrCreate(
                    ['student_id' => $student_id, 'subject_id' => $request->subject_id],
                    [
                        'marks' => $mark,
                        'grade' => Result::calculateGrade($mark),
                    ]
                );
            }
        }

        return redirect()->route('results.index')->with('success', 'Results recorded successfully.');
    }
}
