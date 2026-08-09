<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Student;
use App\Services\FeeDuesService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with('student.schoolClass')->latest()->paginate(20);

        return view('fees.index', compact('fees'));
    }

    public function create()
    {
        $students = Student::with('schoolClass')->get();

        return view('fees.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'fee_type' => 'required|string|in:'.implode(',', FeeDuesService::FEE_TYPES),
            'month' => 'required|string|in:'.implode(',', FeeDuesService::MONTHS),
            'year' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:paid,unpaid',
        ]);

        $student = Student::with('schoolClass.feeStructures')->findOrFail($validated['student_id']);
        $structureAmount = $student->schoolClass->feeStructures
            ->where('fee_type', $validated['fee_type'])
            ->first()?->amount;

        if ($structureAmount !== null && (float) $validated['amount'] !== (float) $structureAmount) {
            return redirect()->back()
                ->withErrors(['amount' => 'The amount must match the configured fee structure (৳'.number_format($structureAmount, 2).').'])
                ->withInput();
        }

        $duplicate = Fee::where('student_id', $validated['student_id'])
            ->where('fee_type', $validated['fee_type'])
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->exists();

        if ($duplicate) {
            return redirect()->back()->with('error', 'A fee record for this student, type and month already exists.');
        }

        $fee = Fee::create($validated);

        return redirect()->route('fees.index')->with('success', 'Fee record created successfully.')
            ->with('print_id', $fee->id);
    }

    public function downloadReceipt(Fee $fee)
    {
        $fee->load('student.schoolClass');
        $pdf = Pdf::loadView('fees.receipt', compact('fee'))
            ->setPaper('a5', 'landscape');

        return $pdf->download('Receipt-'.$fee->id.'.pdf');
    }

    public function edit(Fee $fee)
    {
        $students = Student::all();

        return view('fees.edit', compact('fee', 'students'));
    }

    public function update(Request $request, Fee $fee)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,unpaid',
        ]);

        $fee->update($validated);

        return redirect()->route('fees.index')->with('success', 'Fee status updated.');
    }

    public function destroy(Fee $fee)
    {
        $fee->delete();

        return redirect()->route('fees.index')->with('success', 'Fee record deleted.');
    }
}
