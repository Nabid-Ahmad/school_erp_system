<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = \App\Models\Result::with(['student.schoolClass', 'subject'])
            ->latest()
            ->paginate(20);
        return view('results.index', compact('results'));
    }

    public function create(Request $request)
    {
        $classes = \App\Models\SchoolClass::all();
        $subjects = [];
        $students = [];
        $selected_class = $request->class_id;
        $selected_subject = $request->subject_id;

        if ($selected_class) {
            $subjects = \App\Models\Subject::where('school_class_id', $selected_class)->get();
            $students = \App\Models\Student::where('school_class_id', $selected_class)->get();
        }

        return view('results.create', compact('classes', 'subjects', 'students', 'selected_class', 'selected_subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|array',
            'marks.*' => 'nullable|integer|min:0|max:100',
        ]);

        foreach ($request->marks as $student_id => $mark) {
            if ($mark !== null) {
                \App\Models\Result::updateOrCreate(
                    ['student_id' => $student_id, 'subject_id' => $request->subject_id],
                    [
                        'marks' => $mark,
                        'grade' => \App\Models\Result::calculateGrade($mark)
                    ]
                );
            }
        }

        return redirect()->route('results.index')->with('success', 'Results recorded successfully.');
    }
}
