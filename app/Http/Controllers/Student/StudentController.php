<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function index()
    {
        $students = \App\Models\Student::with('schoolClass')->get();
        return view('students.index', compact('students'));
    }

    public function show(\App\Models\Student $student)
    {
        $student->load(['schoolClass', 'fees' => function($q) {
            $q->latest();
        }, 'attendances' => function($q) {
            $q->latest()->take(30);
        }]);
        
        return view('students.show', compact('student'));
    }

    public function generateIDCard(\App\Models\Student $student)
    {
        $student->load('schoolClass');
        $pdf = Pdf::loadView('students.id_card', compact('student'))
                  ->setPaper([0, 0, 204, 324], 'portrait'); // Standard CR80 size (approx)
        
        return $pdf->download('ID-Card-'.$student->roll.'.pdf');
    }

    public function create()
    {
        $classes = \App\Models\SchoolClass::with('feeStructures')->get();
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
            $validated['image'] = $request->file('image')->store('students', 'public');
        }

        \App\Models\Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    public function edit(\App\Models\Student $student)
    {
        $classes = \App\Models\SchoolClass::all();
        return view('students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, \App\Models\Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'roll' => 'required|string|max:50|unique:students,roll,' . $student->id,
            'school_class_id' => 'required|exists:school_classes,id',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(\App\Models\Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function dues(\App\Models\Student $student)
    {
        $student->load('schoolClass.feeStructures', 'fees');
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $currentMonthIndex = date('n') - 1;
        $admissionMonthIndex = ($student->created_at->year == date('Y')) ? $student->created_at->month - 1 : 0;
        
        $dues = [];
        $totalDueAmount = 0;
        $feeStructures = $student->schoolClass->feeStructures;

        $monthlyFeeAmount = $feeStructures->where('fee_type', 'Monthly Fee')->first()->amount ?? 0;
        for ($i = $admissionMonthIndex; $i <= $currentMonthIndex; $i++) {
            $month = $months[$i];
            $paid = $student->fees->where('fee_type', 'Monthly Fee')->where('month', $month)->where('status', 'paid')->first();
            if (!$paid) {
                $dues[] = ['type' => 'Monthly Fee', 'month' => $month, 'amount' => $monthlyFeeAmount];
                $totalDueAmount += $monthlyFeeAmount;
            }
        }
        
        $otherTypes = ['Admission Fee', 'Exam Fee 1', 'Exam Fee 2', 'Other Fee'];
        foreach ($otherTypes as $type) {
            $structure = $feeStructures->where('fee_type', $type)->first();
            if ($structure && $structure->amount > 0) {
                $paid = $student->fees->where('fee_type', $type)->where('status', 'paid')->first();
                if (!$paid) {
                    $dues[] = ['type' => $type, 'month' => 'N/A', 'amount' => $structure->amount];
                    $totalDueAmount += $structure->amount;
                }
            }
        }
        
        return view('students.dues', compact('student', 'dues', 'totalDueAmount'));
    }

    public function apiFind($roll)
    {
        $student = \App\Models\Student::with('schoolClass.feeStructures', 'fees')->where('roll', $roll)->first();
        if (!$student) return response()->json(null);

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $currentMonthIndex = date('n') - 1;
        $admissionMonthIndex = ($student->created_at->year == date('Y')) ? $student->created_at->month - 1 : 0;
        
        $dues = [];
        $totalDueAmount = 0;
        $feeStructures = $student->schoolClass->feeStructures;
        $classStructure = [];
        foreach ($feeStructures as $fs) {
            $classStructure[$fs->fee_type] = $fs->amount;
        }

        $monthlyFeeAmount = $classStructure['Monthly Fee'] ?? 0;
        for ($i = $admissionMonthIndex; $i <= $currentMonthIndex; $i++) {
            $month = $months[$i];
            $paid = $student->fees->where('fee_type', 'Monthly Fee')->where('month', $month)->where('status', 'paid')->first();
            if (!$paid) {
                $dues[] = ['label' => $month . ' (Monthly Fee)', 'amount' => $monthlyFeeAmount];
                $totalDueAmount += $monthlyFeeAmount;
            }
        }
        
        $otherTypes = ['Admission Fee', 'Exam Fee 1', 'Exam Fee 2', 'Other Fee'];
        foreach ($otherTypes as $type) {
            $amount = $classStructure[$type] ?? 0;
            if ($amount > 0) {
                $paid = $student->fees->where('fee_type', $type)->where('status', 'paid')->first();
                if (!$paid) {
                    $dues[] = ['label' => $type, 'amount' => $amount];
                    $totalDueAmount += $amount;
                }
            }
        }

        return response()->json([
            'id' => $student->id,
            'name' => $student->name,
            'dues' => $dues,
            'total_due' => $totalDueAmount,
            'class_structure' => $classStructure
        ]);
    }
}
