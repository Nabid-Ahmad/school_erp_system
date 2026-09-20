<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\ClassRoutine;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassRoutineController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount('students')->get();
        return view('academic.routines.index', compact('classes'));
    }

    public function show(SchoolClass $routine)
    {
        // $routine is a SchoolClass model because we pass class id to the route, let's rename param for clarity
        $schoolClass = $routine;
        
        $routines = ClassRoutine::with(['subject', 'teacher'])
            ->where('school_class_id', $schoolClass->id)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('academic.routines.show', compact('schoolClass', 'routines', 'days'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return view('academic.routines.create', compact('classes', 'subjects', 'teachers', 'days'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room_number' => 'nullable|string|max:255',
        ]);

        ClassRoutine::create($validated);

        return redirect()->route('routines.show', $request->school_class_id)
            ->with('success', 'Routine slot added successfully!');
    }

    public function destroy($id)
    {
        $routine = ClassRoutine::findOrFail($id);
        $classId = $routine->school_class_id;
        $routine->delete();
        
        return redirect()->route('routines.show', $classId)
            ->with('success', 'Routine slot removed successfully.');
    }
}
