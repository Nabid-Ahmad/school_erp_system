<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('F'));
        $selectedYear = $request->get('year', (string) now()->year);
        $selectedType = $request->get('type', 'all');

        // Month index (1-12) for date filtering
        $monthIndex = Carbon::parse("1 {$selectedMonth} {$selectedYear}")->month;

        // 1. Income (Fees Collected)
        $incomeQuery = Fee::where('status', 'paid')
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear);
        $totalIncome = (float) $incomeQuery->sum('amount');

        $yearlyIncome = (float) Fee::where('status', 'paid')
            ->where('year', $selectedYear)
            ->sum('amount');

        // 2. Operational Expenses
        $expenseQuery = Expense::whereYear('date', $selectedYear)
            ->whereMonth('date', $monthIndex)
            ->whereNull('salary_id');
        $totalExpenses = (float) $expenseQuery->sum('amount');

        $yearlyExpenses = (float) Expense::whereYear('date', $selectedYear)
            ->whereNull('salary_id')
            ->sum('amount');

        // 3. Salaries (Staff Payroll)
        $salaryQuery = Salary::where('month', $selectedMonth)
            ->where('year', $selectedYear);
        $totalSalaries = (float) $salaryQuery->sum('amount');

        $yearlySalaries = (float) Salary::where('year', $selectedYear)
            ->sum('amount');

        // Calculations
        $totalCombinedExpenses = $totalExpenses + $totalSalaries;
        $netBalance = $totalIncome - $totalCombinedExpenses;

        $yearlyCombinedExpenses = $yearlyExpenses + $yearlySalaries;
        $yearlyNetBalance = $yearlyIncome - $yearlyCombinedExpenses;

        // 4. Combined Financial Ledger (Unified Transactions)
        $ledger = new Collection();

        if ($selectedType === 'all' || $selectedType === 'income') {
            $fees = Fee::with('student')
                ->where('status', 'paid')
                ->where('month', $selectedMonth)
                ->where('year', $selectedYear)
                ->get();

            foreach ($fees as $fee) {
                $ledger->push([
                    'id' => 'FEE-' . $fee->id,
                    'date' => $fee->updated_at ?? $fee->created_at,
                    'type' => 'income',
                    'category' => $fee->fee_type ?? 'Student Tuition Fee',
                    'title' => 'Fee Payment - ' . ($fee->student->name ?? 'Student'),
                    'payer_payee' => $fee->student->name ?? 'N/A',
                    'amount' => (float) $fee->amount,
                    'reference' => 'REC-FEE-' . str_pad($fee->id, 5, '0', STR_PAD_LEFT),
                ]);
            }
        }

        if ($selectedType === 'all' || $selectedType === 'expense') {
            $expenses = Expense::whereYear('date', $selectedYear)
                ->whereMonth('date', $monthIndex)
                ->whereNull('salary_id')
                ->get();

            foreach ($expenses as $exp) {
                $ledger->push([
                    'id' => 'EXP-' . $exp->id,
                    'date' => Carbon::parse($exp->date),
                    'type' => 'expense',
                    'category' => $exp->category ?? 'Operational Expense',
                    'title' => $exp->title,
                    'payer_payee' => 'School Outflow',
                    'amount' => (float) $exp->amount,
                    'reference' => 'EXP-' . str_pad($exp->id, 5, '0', STR_PAD_LEFT),
                ]);
            }

            $salaries = Salary::with('teacher')
                ->where('month', $selectedMonth)
                ->where('year', $selectedYear)
                ->get();

            foreach ($salaries as $sal) {
                $ledger->push([
                    'id' => 'SAL-' . $sal->id,
                    'date' => $sal->payment_date ? Carbon::parse($sal->payment_date) : ($sal->created_at ?? now()),
                    'type' => 'expense',
                    'category' => 'Staff Payroll Salary',
                    'title' => 'Salary Disbursement - ' . ($sal->teacher->name ?? 'Teacher'),
                    'payer_payee' => $sal->teacher->name ?? 'Teacher',
                    'amount' => (float) $sal->amount,
                    'reference' => 'SAL-' . str_pad($sal->id, 5, '0', STR_PAD_LEFT),
                ]);
            }
        }

        // Sort ledger by date descending
        $ledger = $ledger->sortByDesc('date')->values();

        // Months list for dropdown
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Available years
        $years = range(now()->year - 2, now()->year + 1);

        return view('accounts.index', compact(
            'selectedMonth',
            'selectedYear',
            'selectedType',
            'totalIncome',
            'totalExpenses',
            'totalSalaries',
            'totalCombinedExpenses',
            'netBalance',
            'yearlyIncome',
            'yearlyCombinedExpenses',
            'yearlyNetBalance',
            'ledger',
            'months',
            'years'
        ));
    }

    public function report(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('F'));
        $selectedYear = $request->get('year', (string) now()->year);

        $monthIndex = Carbon::parse("1 {$selectedMonth} {$selectedYear}")->month;

        $totalIncome = (float) Fee::where('status', 'paid')
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->sum('amount');

        $totalExpenses = (float) Expense::whereYear('date', $selectedYear)
            ->whereMonth('date', $monthIndex)
            ->whereNull('salary_id')
            ->sum('amount');

        $totalSalaries = (float) Salary::where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->sum('amount');

        $totalCombinedExpenses = $totalExpenses + $totalSalaries;
        $netBalance = $totalIncome - $totalCombinedExpenses;

        $fees = Fee::with('student')
            ->where('status', 'paid')
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->get();

        $expenses = Expense::whereYear('date', $selectedYear)
            ->whereMonth('date', $monthIndex)
            ->whereNull('salary_id')
            ->get();

        $salaries = Salary::with('teacher')
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->get();

        return view('accounts.report', compact(
            'selectedMonth',
            'selectedYear',
            'totalIncome',
            'totalExpenses',
            'totalSalaries',
            'totalCombinedExpenses',
            'netBalance',
            'fees',
            'expenses',
            'salaries'
        ));
    }
}
