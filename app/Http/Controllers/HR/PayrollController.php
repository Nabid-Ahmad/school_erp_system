<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Payslip;
use App\Models\Teacher;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::latest()->paginate(10);
        return view('payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        return view('payrolls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required|string',
            'year' => 'required|integer',
        ]);

        // Check if payroll already exists for this month/year
        if (Payroll::where('month', $request->month)->where('year', $request->year)->exists()) {
            return redirect()->back()->with('error', 'Payroll for this month already exists.');
        }

        $teachers = Teacher::all();
        if ($teachers->isEmpty()) {
            return redirect()->back()->with('error', 'No teachers found to generate payroll.');
        }

        DB::transaction(function () use ($request, $teachers) {
            $totalAmount = 0;

            $payroll = Payroll::create([
                'month' => $request->month,
                'year' => $request->year,
                'created_by' => auth()->id(),
                'status' => 'draft',
                'total_amount' => 0 // updated below
            ]);

            foreach ($teachers as $teacher) {
                // Here you can calculate actual deductions/allowances based on rules.
                // For simplicity, we just use the fixed basic salary.
                $basic = $teacher->salary;
                $allowance = 0; 
                $deduction = 0; 
                $net = $basic + $allowance - $deduction;

                Payslip::create([
                    'payroll_id' => $payroll->id,
                    'teacher_id' => $teacher->id,
                    'basic_salary' => $basic,
                    'allowance' => $allowance,
                    'deduction' => $deduction,
                    'net_salary' => $net,
                    'status' => 'unpaid'
                ]);

                $totalAmount += $net;
            }

            $payroll->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('payrolls.index')->with('success', 'Payroll generated successfully.');
    }

    public function show(Payroll $payroll)
    {
        $payslips = $payroll->payslips()->with('teacher')->get();
        return view('payrolls.show', compact('payroll', 'payslips'));
    }

    public function pay(Request $request, Payslip $payslip)
    {
        if ($payslip->status === 'paid') {
            return redirect()->back()->with('error', 'Payslip already paid.');
        }

        DB::transaction(function () use ($payslip) {
            $payslip->update([
                'status' => 'paid',
                'payment_date' => now(),
            ]);

            Expense::create([
                'payslip_id' => $payslip->id,
                'title' => 'Salary Payment: ' . $payslip->teacher->name . ' (' . $payslip->payroll->month . ' ' . $payslip->payroll->year . ')',
                'amount' => $payslip->net_salary,
                'category' => 'Salary',
                'date' => now(),
                'description' => 'Salary via Payroll System',
            ]);

            $payroll = $payslip->payroll;
            $unpaidCount = $payroll->payslips()->where('status', 'unpaid')->count();
            
            if ($unpaidCount === 0) {
                $payroll->update(['status' => 'paid']);
            } elseif ($payroll->status === 'draft') {
                $payroll->update(['status' => 'processing']);
            }
        });

        return redirect()->back()->with('success', 'Payment marked successfully and expense recorded.');
    }
}
