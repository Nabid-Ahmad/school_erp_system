<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index()
    {
        $homeworks = Homework::with(['schoolClass', 'subject', 'teacher'])->withCount('submissions')->get();
        return view('academic.homework.index', compact('homeworks'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('academic.homework.create', compact('classes', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        Homework::create($validated);

        return redirect()->route('academic.homework.index')->with('success', 'Homework assigned successfully.');
    }

    public function show(Homework $homework)
    {
        $homework->load(['schoolClass', 'subject', 'teacher', 'submissions.student.user']);
        return view('academic.homework.show', compact('homework'));
    }

    public function gradeSubmission(Request $request, HomeworkSubmission $submission)
    {
        $request->validate([
            'grade' => 'required|string|max:50',
        ]);

        $submission->update([
            'grade' => $request->grade,
            'status' => 'graded'
        ]);

        return back()->with('success', 'Submission graded successfully.');
    }

    public function destroy(Homework $homework)
    {
        $homework->delete();
        return redirect()->route('academic.homework.index')->with('success', 'Homework deleted.');
    }
}
