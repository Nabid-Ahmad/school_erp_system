<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Services\FeeDuesService;
use App\Services\NotificationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('schoolClass')->get();

        return view('students.index', compact('students'));
    }

    public function show(Student $student)
    {
        $student->load(['schoolClass', 'fees' => function ($q) {
            $q->latest();
        }, 'attendances' => function ($q) {
            $q->latest()->take(30);
        }]);

        return view('students.show', compact('student'));
    }

    public function generateIDCard(Student $student)
    {
        $student->load('schoolClass');
        $pdf = Pdf::loadView('students.id_card', compact('student'))
            ->setPaper([0, 0, 204, 324], 'portrait'); // Standard CR80 size (approx)

        return $pdf->download('ID-Card-'.$student->roll.'.pdf');
    }

    public function create()
    {
        $classes = SchoolClass::with('feeStructures')->get();

        return view('students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'roll' => 'required|string|max:50|unique:students,roll',
            'school_class_id' => 'required|exists:school_classes,id',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = cloudinary()->uploadApi()->upload($request->file('image')->getRealPath(), ['folder' => 'students'])['secure_url'];
        }

        $student = Student::create($validated);

        NotificationService::toAdmins(
            'New Student Registered',
            "{$student->name} (Roll: {$student->roll}) was added.",
            route('students.show', $student)
        );

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::all();

        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'roll' => 'required|string|max:50|unique:students,roll,'.$student->id,
            'school_class_id' => 'required|exists:school_classes,id',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        if ($student->image && str_contains($student->image, 'res.cloudinary.com')) {
            try {
                $parts = explode('/upload/', $student->image);
                if (isset($parts[1])) {
                    $pathParts = explode('/', $parts[1]);
                    array_shift($pathParts);
                    $publicIdWithExt = implode('/', $pathParts);
                    $publicId = pathinfo($publicIdWithExt, PATHINFO_DIRNAME).'/'.pathinfo($publicIdWithExt, PATHINFO_FILENAME);
                    cloudinary()->uploadApi()->destroy($publicId);
                }
            } catch (\Exception $e) {
            }
        }

        if ($student->user) {
            $student->user->delete();
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function dues(Student $student)
    {
        $student->load('schoolClass');

        $result = app(FeeDuesService::class)->calculateDues($student);

        return view('students.dues', [
            'student' => $student,
            'dues' => $result['dues'],
            'totalDueAmount' => $result['total_due'],
        ]);
    }

    public function apiFind($roll)
    {
        $student = Student::where('roll', $roll)->first();
        if (! $student) {
            return response()->json(null);
        }

        $service = app(FeeDuesService::class);
        $result = $service->calculateDues($student);

        $dues = array_map(function ($due) {
            $label = $due['type'] === 'Monthly Fee'
                ? $due['month'].' (Monthly Fee)'
                : $due['type'];

            return ['label' => $label, 'amount' => $due['amount']];
        }, $result['dues']);

        return response()->json([
            'id' => $student->id,
            'name' => $student->name,
            'dues' => $dues,
            'total_due' => $result['total_due'],
            'class_structure' => $service->classStructure($student),
        ]);
    }
}
