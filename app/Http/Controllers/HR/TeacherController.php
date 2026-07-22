<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = \App\Models\Teacher::all();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = cloudinary()->upload($request->file('image')->getRealPath(), ['folder' => 'teachers'])->getSecurePath();
        }

        \App\Models\Teacher::create($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }

    public function edit(\App\Models\Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, \App\Models\Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = cloudinary()->upload($request->file('image')->getRealPath(), ['folder' => 'teachers'])->getSecurePath();
        }

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(\App\Models\Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
