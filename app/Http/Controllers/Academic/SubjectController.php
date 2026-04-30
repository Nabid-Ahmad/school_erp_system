<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = \App\Models\Subject::with('schoolClass')->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $classes = \App\Models\SchoolClass::all();
        return view('subjects.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        \App\Models\Subject::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function edit(\App\Models\Subject $subject)
    {
        $classes = \App\Models\SchoolClass::all();
        return view('subjects.edit', compact('subject', 'classes'));
    }

    public function update(Request $request, \App\Models\Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(\App\Models\Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
