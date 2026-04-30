<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;

use App\Models\Teacher;
use App\Models\Salary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TeacherProfileController extends Controller
{
    public function show(Teacher $teacher)
    {
        $salaries = $teacher->salaries()->latest()->get();
        $joiningDate = $teacher->joining_date ? Carbon::parse($teacher->joining_date) : $teacher->created_at;
        $currentDate = Carbon::now();
        
        $pendingSalaries = [];
        $tempDate = $joiningDate->copy()->startOfMonth();

        while ($tempDate->lte($currentDate->startOfMonth())) {
            $monthName = $tempDate->format('F');
            $year = $tempDate->format('Y');

            // Find if any payment exists for this month and year
            $payment = $teacher->salaries()->where('month', $monthName)->where('year', $year)->first();
            
            $paidAmount = $payment ? $payment->amount : 0;
            $dueAmount = $teacher->salary - $paidAmount;

            if ($dueAmount > 0) {
                $pendingSalaries[] = [
                    'month' => $monthName,
                    'year' => $year,
                    'fixed_salary' => $teacher->salary,
                    'paid' => $paidAmount,
                    'due' => $dueAmount,
                    'status' => $paidAmount > 0 ? 'Partial' : 'Pending'
                ];
            }
            
            $tempDate->addMonth();
        }

        return view('teachers.profile', compact('teacher', 'salaries', 'pendingSalaries'));
    }

    public function idCard(Teacher $teacher)
    {
        $pdf = Pdf::loadView('teachers.id_card_pdf', compact('teacher'));
        return $pdf->stream($teacher->name . '_ID_Card.pdf');
    }
}
