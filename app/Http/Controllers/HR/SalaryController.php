<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Salary;
use App\Models\Teacher;
use App\Services\NotificationService;
use App\Services\SalaryDuesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('teacher')->latest()->paginate(15);
        $teachers = Teacher::all();

        $service = app(SalaryDuesService::class);
        foreach ($teachers as $teacher) {
            $teacher->total_due = $service->calculate($teacher)['total_due'];
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

        $alreadyPaid = Salary::where('teacher_id', $validated['teacher_id'])
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->exists();

        if ($alreadyPaid) {
            return redirect()->back()->with('error', 'Salary for this teacher and month has already been paid.');
        }

        try {
            $salary = DB::transaction(function () use ($validated) {
                $salary = Salary::create($validated);

                Expense::create([
                    'salary_id' => $salary->id,
                    'title' => 'Salary Payment: '.$salary->teacher->name.' ('.$salary->month.' '.$salary->year.')',
                    'amount' => $salary->amount,
                    'category' => 'Salary',
                    'date' => $salary->payment_date,
                    'month' => $salary->month,
                    'year' => $salary->year,
                    'description' => $salary->note,
                ]);

                return $salary;
            });
        } catch (\Throwable $e) {
            Log::error('Salary payment error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Could not save the salary payment. Please try again.');
        }

        NotificationService::toAdmins(
            'Salary Paid',
            "{$salary->teacher->name} received ৳".number_format($salary->amount, 2)." for {$salary->month} {$salary->year}.",
            route('salaries.index')
        );

        return redirect()->back()->with('success', 'Salary paid and recorded as expense.');
    }

    public function destroy(Salary $salary)
    {
        // Deleting the salary cascades to its linked expense record.
        $salary->delete();

        return redirect()->back()->with('success', 'Salary payment deleted.');
    }
}
