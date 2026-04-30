<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

use App\Models\Salary;
use App\Models\Teacher;
use App\Models\Expense;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('teacher')->latest()->paginate(15);
        $teachers = Teacher::all();

        // Calculate total due for each teacher
        foreach ($teachers as $teacher) {
            $joiningDate = $teacher->joining_date ? \Carbon\Carbon::parse($teacher->joining_date) : $teacher->created_at;
            $currentDate = \Carbon\Carbon::now()->startOfMonth();
            $totalFixed = 0;
            
            $tempDate = $joiningDate->copy()->startOfMonth();
            while ($tempDate->lte($currentDate)) {
                $totalFixed += $teacher->salary;
                $tempDate->addMonth();
            }

            $totalPaid = $teacher->salaries()->sum('amount');
            $teacher->total_due = $totalFixed - $totalPaid;
        }

        return view('salaries.index', compact('salaries', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string',
            'year' => 'required|integer',
            'payment_date' => 'nullable|date',
            'note' => 'nullable|string',
        ]);

        if (empty($validated['payment_date'])) {
            $validated['payment_date'] = date('Y-m-d');
        }

        $salary = Salary::create($validated);

        // Auto-create an expense record
        Expense::create([
            'title' => 'Salary Payment: ' . $salary->teacher->name . ' (' . $salary->month . ' ' . $salary->year . ')',
            'amount' => $salary->amount,
            'category' => 'Salary',
            'date' => $salary->payment_date,
            'month' => $salary->month,
            'year' => $salary->year,
            'description' => $salary->note,
        ]);

        return redirect()->back()->with('success', 'Salary paid and recorded as expense.');
    }
}
