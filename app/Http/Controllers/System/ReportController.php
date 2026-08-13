<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\Result;
use App\Models\Salary;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::all();
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = SchoolClass::count();
        $thisMonthFees = Fee::where('status', 'paid')
            ->where('month', now()->format('F'))
            ->where('year', (string) now()->year)
            ->sum('amount');
        $thisMonthExpenses = Expense::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->sum('amount');

        return view('reports.index', compact(
            'classes',
            'totalStudents',
            'totalTeachers',
            'totalClasses',
            'thisMonthFees',
            'thisMonthExpenses'
        ));
    }

    public function financialSummary(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('F'));
        $selectedYear = $request->get('year', (string) now()->year);
        $monthIndex = Carbon::parse("1 {$selectedMonth} {$selectedYear}")->month;

        $totalFees = (float) Fee::where('status', 'paid')
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

        $netBalance = $totalFees - ($totalExpenses + $totalSalaries);

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

        return view('reports.financial', compact(
            'selectedMonth',
            'selectedYear',
            'totalFees',
            'totalExpenses',
            'totalSalaries',
            'netBalance',
            'fees',
            'expenses',
            'salaries'
        ));
    }

    public function studentDues(Request $request)
    {
        $classId = $request->get('school_class_id');
        $query = Student::with(['schoolClass', 'fees']);

        if ($classId) {
            $query->where('school_class_id', $classId);
        }

        $students = $query->get();
        $selectedClass = $classId ? SchoolClass::find($classId) : null;

        return view('reports.student_dues', compact('students', 'selectedClass'));
    }

    public function attendanceSummary(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $classId = $request->get('school_class_id');

        $query = Attendance::with(['student', 'student.schoolClass'])
            ->whereDate('date', $date);

        if ($classId) {
            $query->whereHas('student', function ($q) use ($classId) {
                $q->where('school_class_id', $classId);
            });
        }

        $attendances = $query->get();
        $totalPresent = $attendances->where('status', 'present')->count();
        $totalAbsent = $attendances->where('status', 'absent')->count();
        $totalLate = $attendances->where('status', 'late')->count();

        $selectedClass = $classId ? SchoolClass::find($classId) : null;

        return view('reports.attendance', compact(
            'attendances',
            'date',
            'totalPresent',
            'totalAbsent',
            'totalLate',
            'selectedClass'
        ));
    }

    public function examResults(Request $request)
    {
        $classId = $request->get('school_class_id');
        $query = Result::with(['student', 'subject', 'student.schoolClass']);

        if ($classId) {
            $query->whereHas('student', function ($q) use ($classId) {
                $q->where('school_class_id', $classId);
            });
        }

        $results = $query->get();
        $selectedClass = $classId ? SchoolClass::find($classId) : null;

        return view('reports.results', compact('results', 'selectedClass'));
    }

    public function payrollSummary(Request $request)
    {
        $selectedMonth = $request->get('month', now()->format('F'));
        $selectedYear = $request->get('year', (string) now()->year);

        $salaries = Salary::with('teacher')
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->get();

        $totalDisbursed = $salaries->sum('amount');

        return view('reports.payroll', compact(
            'salaries',
            'selectedMonth',
            'selectedYear',
            'totalDisbursed'
        ));
    }
}
