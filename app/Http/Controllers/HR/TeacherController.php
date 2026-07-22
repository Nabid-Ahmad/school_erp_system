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
            $validated['image'] = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'teachers'])['secure_url'];
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
            $validated['image'] = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'teachers'])['secure_url'];
        }

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(\App\Models\Teacher $teacher)
    {
        if ($teacher->image && str_contains($teacher->image, 'res.cloudinary.com')) {
            try {
                $parts = explode('/upload/', $teacher->image);
                if (isset($parts[1])) {
                    $pathParts = explode('/', $parts[1]);
                    array_shift($pathParts);
                    $publicIdWithExt = implode('/', $pathParts);
                    $publicId = pathinfo($publicIdWithExt, PATHINFO_DIRNAME) . '/' . pathinfo($publicIdWithExt, PATHINFO_FILENAME);
                    cloudinary()->uploadApi()->destroy($publicId);
                }
            } catch (\Exception $e) {}
        }

        if ($teacher->user) {
            $teacher->user->delete();
        }

        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
