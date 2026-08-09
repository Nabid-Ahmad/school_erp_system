<?php

namespace App\Services;

use App\Models\Teacher;
use Carbon\Carbon;

class SalaryDuesService
{
    /**
     * Compute a per-month salary breakdown for a teacher from their joining month
     * through the current month.
     *
     * @return array{months: array<int, array{month: string, year: string, fixed_salary: float, paid: float, due: float, status: string}>, total_due: float}
     */
    public function calculate(Teacher $teacher): array
    {
        $teacher->load('salaries');
        $salaries = $teacher->salaries;
        $joiningDate = $teacher->joining_date
            ? Carbon::parse($teacher->joining_date)
            : $teacher->created_at;

        $start = $joiningDate->copy()->startOfMonth();
        $end = now()->startOfMonth();

        $months = [];
        $totalDue = 0.0;

        $cursor = $start;
        while ($cursor->lte($end)) {
            $month = $cursor->format('F');
            $year = $cursor->format('Y');

            $payment = $salaries->first(
                fn ($salary) => $salary->month === $month && (string) $salary->year === $year
            );

            $paid = $payment ? (float) $payment->amount : 0.0;
            $due = (float) $teacher->salary - $paid;

            if ($due > 0) {
                $months[] = [
                    'month' => $month,
                    'year' => $year,
                    'fixed_salary' => (float) $teacher->salary,
                    'paid' => $paid,
                    'due' => $due,
                    'status' => $paid > 0 ? 'Partial' : 'Pending',
                ];
                $totalDue += $due;
            }

            $cursor->addMonth();
        }

        return ['months' => $months, 'total_due' => $totalDue];
    }
}
