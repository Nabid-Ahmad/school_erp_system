<?php

namespace App\Services;

use App\Models\Student;

class FeeDuesService
{
    public const FEE_TYPES = [
        'Admission Fee',
        'Monthly Fee',
        'Exam Fee 1',
        'Exam Fee 2',
        'Other Fee',
    ];

    public const MONTHS = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December',
    ];

    private const ONE_TIME_FEE_TYPES = [
        'Admission Fee',
        'Exam Fee 1',
        'Exam Fee 2',
        'Other Fee',
    ];

    /**
     * Fee amounts configured per class, keyed by fee type.
     */
    public function classStructure(Student $student): array
    {
        $structure = [];

        foreach ($student->schoolClass->feeStructures as $feeStructure) {
            $structure[$feeStructure->fee_type] = (float) $feeStructure->amount;
        }

        return $structure;
    }

    /**
     * Calculate unpaid fees for a student, broken down per month (Monthly Fee)
     * and per one-time fee type.
     *
     * @return array{dues: array<int, array{type: string, month: string, year: int|string|null, amount: float}>, total_due: float}
     */
    public function calculateDues(Student $student): array
    {
        $student->load('schoolClass.feeStructures', 'fees');

        $structure = $this->classStructure($student);
        $dues = [];
        $totalDue = 0.0;

        $monthlyFeeAmount = $structure['Monthly Fee'] ?? 0;

        // Iterate from the month after admission through the current month so that
        // previous-year mid-year joiners are charged correctly and dues are scoped by year.
        $start = $student->created_at->copy()->startOfMonth();
        $end = now()->startOfMonth();

        $cursor = $start;
        while ($cursor->lte($end)) {
            $month = $cursor->format('F');
            $year = $cursor->format('Y');

            $paid = $student->fees->first(
                fn ($fee) => $fee->fee_type === 'Monthly Fee'
                    && $fee->month === $month
                    && (string) $fee->year === $year
                    && $fee->status === 'paid'
            );

            if (! $paid && $monthlyFeeAmount > 0) {
                $dues[] = [
                    'type' => 'Monthly Fee',
                    'month' => $month,
                    'year' => $year,
                    'amount' => $monthlyFeeAmount,
                ];
                $totalDue += $monthlyFeeAmount;
            }

            $cursor->addMonth();
        }

        foreach (self::ONE_TIME_FEE_TYPES as $type) {
            $amount = $structure[$type] ?? 0;

            if ($amount <= 0) {
                continue;
            }

            $paid = $student->fees->first(
                fn ($fee) => $fee->fee_type === $type && $fee->status === 'paid'
            );

            if (! $paid) {
                $dues[] = [
                    'type' => $type,
                    'month' => 'N/A',
                    'year' => null,
                    'amount' => $amount,
                ];
                $totalDue += $amount;
            }
        }

        return ['dues' => $dues, 'total_due' => $totalDue];
    }
}
