<?php

namespace App\Http\Controllers\StudentPortal;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'student' || !$user->student) {
            abort(403, 'Unauthorized action.');
        }

        $student = $user->student;
        $homeworks = Homework::where('school_class_id', $student->school_class_id)
            ->with(['subject', 'teacher', 'submissions' => function($q) use ($student) {
                $q->where('student_id', $student->id);
            }])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('student.homework.index', compact('homeworks'));
    }

    public function show(Homework $homework)
    {
        $user = Auth::user();
        $student = $user->student;

        if ($homework->school_class_id !== $student->school_class_id) {
            abort(403, 'Unauthorized action.');
        }

        $submission = $homework->submissions()->where('student_id', $student->id)->first();
        
        return view('student.homework.show', compact('homework', 'submission'));
    }

    public function submit(Request $request, Homework $homework)
    {
        $user = Auth::user();
        $student = $user->student;

        if ($homework->school_class_id !== $student->school_class_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'submission_text' => 'required|string',
        ]);

        HomeworkSubmission::updateOrCreate(
            ['homework_id' => $homework->id, 'student_id' => $student->id],
            ['submission_text' => $request->submission_text, 'status' => 'pending']
        );

        return back()->with('success', 'Homework submitted successfully.');
    }
}
