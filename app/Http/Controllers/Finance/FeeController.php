<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

class FeeController extends Controller
{
    public function index()
    {
        $fees = \App\Models\Fee::with('student.schoolClass')->latest()->paginate(20);
        return view('fees.index', compact('fees'));
    }

    public function create()
    {
        $students = \App\Models\Student::with('schoolClass')->get();
        return view('fees.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'fee_type' => 'required|string',
            'month' => 'required|string',
            'year' => 'required|integer|min:2000|max:2100',
            'status' => 'required|in:paid,unpaid',
        ]);

        $fee = \App\Models\Fee::create($validated);

        return redirect()->route('fees.index')->with('success', 'Fee record created successfully.')
                         ->with('print_id', $fee->id);
    }

    public function downloadReceipt(\App\Models\Fee $fee)
    {
        $fee->load('student.schoolClass');
        $pdf = Pdf::loadView('fees.receipt', compact('fee'))
                  ->setPaper('a5', 'landscape');
        
        return $pdf->download('Receipt-'.$fee->id.'.pdf');
    }

    public function edit(\App\Models\Fee $fee)
    {
        $students = \App\Models\Student::all();
        return view('fees.edit', compact('fee', 'students'));
    }

    public function update(Request $request, \App\Models\Fee $fee)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,unpaid',
        ]);

        $fee->update($validated);

        return redirect()->route('fees.index')->with('success', 'Fee status updated.');
    }

    public function destroy(\App\Models\Fee $fee)
    {
        $fee->delete();
        return redirect()->route('fees.index')->with('success', 'Fee record deleted.');
    }
}
