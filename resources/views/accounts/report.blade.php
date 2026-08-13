<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Financial Report - {{ $selectedMonth }} {{ $selectedYear }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 30px;
            background: #ffffff;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .school-title {
            font-size: 24px;
            font-weight: 900;
            color: #0f172a;
            margin: 0;
            text-transform: uppercase;
        }
        .report-sub {
            font-size: 13px;
            color: #64748b;
            font-weight: 700;
            margin-top: 4px;
        }
        .summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px;
            margin-bottom: 25px;
        }
        .summary-card {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
        }
        .card-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 1px;
        }
        .card-val {
            font-size: 20px;
            font-weight: 900;
            margin-top: 6px;
        }
        .income-val { color: #059669; }
        .expense-val { color: #dc2626; }
        .net-val { color: #2563eb; }

        .section-title {
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 1.5px solid #cbd5e1;
            padding-bottom: 5px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 20px;
        }
        .report-table th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #cbd5e1;
        }
        .report-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
        }
        .sign-area {
            margin-top: 60px;
            width: 100%;
        }
        .sign-col {
            width: 45%;
            float: left;
            text-align: center;
        }
        .sign-line {
            border-top: 1px solid #94a3b8;
            margin-top: 40px;
            margin-bottom: 5px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .sign-label {
            font-size: 11px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer;">
            Print / Save PDF Report
        </button>
    </div>

    <table class="header-table">
        <tr>
            <td>
                <h1 class="school-title">Bangla Model School</h1>
                <div class="report-sub">FINANCIAL PROFIT & LOSS STATEMENT (INCOME STATEMENT)</div>
                <div class="report-sub">Period: {{ $selectedMonth }} {{ $selectedYear }}</div>
            </td>
            <td style="text-align: right; font-size: 12px; color: #64748b; font-weight: bold;">
                Report Generated: {{ now()->format('d M, Y h:i A') }}
            </td>
        </tr>
    </table>

    <table class="summary-grid">
        <tr>
            <td class="summary-card" style="width: 33%;">
                <div class="card-label">Total Revenue (Fees)</div>
                <div class="card-val income-val">৳{{ number_format($totalIncome, 2) }}</div>
            </td>
            <td class="summary-card" style="width: 33%;">
                <div class="card-label">Total Expenses & Payroll</div>
                <div class="card-val expense-val">৳{{ number_format($totalCombinedExpenses, 2) }}</div>
            </td>
            <td class="summary-card" style="width: 33%;">
                <div class="card-label">Net Balance (Surplus / Deficit)</div>
                <div class="card-val net-val">৳{{ number_format($netBalance, 2) }}</div>
            </td>
        </tr>
    </table>

    <!-- Incomes Section -->
    <div class="section-title">1. Revenue / Income Breakdown (Student Fees Collected)</div>
    <table class="report-table">
        <thead>
            <tr>
                <th>Receipt #</th>
                <th>Student Name</th>
                <th>Fee Category</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fees as $f)
                <tr>
                    <td>REC-FEE-{{ str_pad($f->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $f->student->name ?? 'Student' }}</td>
                    <td>{{ $f->fee_type ?? 'Tuition Fee' }}</td>
                    <td style="text-align: right; color: #059669; font-weight: 800;">৳{{ number_format($f->amount, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center; color: #94a3b8;">No fee income recorded for this period.</td></tr>
            @endforelse
            <tr style="background: #f8fafc; font-weight: 900;">
                <td colspan="3" style="text-align: right; text-transform: uppercase;">Subtotal Revenue:</td>
                <td style="text-align: right; color: #059669; font-size: 13px;">৳{{ number_format($totalIncome, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Expenses Section -->
    <div class="section-title">2. Operating Expenses Breakdown</div>
    <table class="report-table">
        <thead>
            <tr>
                <th>Expense #</th>
                <th>Title / Description</th>
                <th>Category</th>
                <th>Date</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $e)
                <tr>
                    <td>EXP-{{ str_pad($e->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $e->title }}</td>
                    <td>{{ $e->category ?? 'Operational' }}</td>
                    <td>{{ \Carbon\Carbon::parse($e->date)->format('d M, Y') }}</td>
                    <td style="text-align: right; color: #dc2626; font-weight: 800;">৳{{ number_format($e->amount, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center; color: #94a3b8;">No operational expenses recorded for this period.</td></tr>
            @endforelse
            <tr style="background: #f8fafc; font-weight: 900;">
                <td colspan="4" style="text-align: right; text-transform: uppercase;">Subtotal Operating Expenses:</td>
                <td style="text-align: right; color: #dc2626; font-size: 13px;">৳{{ number_format($totalExpenses, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Salaries Section -->
    <div class="section-title">3. Staff Payroll & Salary Disbursements</div>
    <table class="report-table">
        <thead>
            <tr>
                <th>Voucher #</th>
                <th>Teacher Name</th>
                <th>Payment Date</th>
                <th style="text-align: right;">Amount Paid</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salaries as $s)
                <tr>
                    <td>SAL-{{ str_pad($s->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $s->teacher->name ?? 'Teacher' }}</td>
                    <td>{{ $s->payment_date ? \Carbon\Carbon::parse($s->payment_date)->format('d M, Y') : 'N/A' }}</td>
                    <td style="text-align: right; color: #dc2626; font-weight: 800;">৳{{ number_format($s->amount, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align: center; color: #94a3b8;">No salary disbursements recorded for this period.</td></tr>
            @endforelse
            <tr style="background: #f8fafc; font-weight: 900;">
                <td colspan="3" style="text-align: right; text-transform: uppercase;">Subtotal Staff Salaries:</td>
                <td style="text-align: right; color: #dc2626; font-size: 13px;">৳{{ number_format($totalSalaries, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="sign-area">
        <div class="sign-col">
            <div class="sign-line"></div>
            <div class="sign-label">Prepared By (Accountant)</div>
        </div>
        <div class="sign-col" style="float: right;">
            <div class="sign-line"></div>
            <div class="sign-label">Approved By (Principal)</div>
        </div>
    </div>
</body>
</html>
