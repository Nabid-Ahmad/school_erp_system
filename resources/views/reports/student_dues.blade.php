<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Dues Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #0f172a; margin: 0; padding: 30px; background: #ffffff; }
        .header-table { width: 100%; border-bottom: 2.5px solid #0f172a; padding-bottom: 12px; margin-bottom: 25px; }
        .school-title { font-size: 24px; font-weight: 900; color: #0f172a; margin: 0; text-transform: uppercase; }
        .report-sub { font-size: 13px; color: #475569; font-weight: 700; margin-top: 4px; }
        .report-table { width: 100%; border-collapse: collapse; font-size: 12px; margin-top: 15px; }
        .report-table th { background: #f1f5f9; color: #475569; font-weight: 800; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; padding: 10px 12px; text-align: left; border-bottom: 1.5px solid #cbd5e1; }
        .report-table td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; font-weight: 600; }
        .badge-paid { background: #ecfdf5; color: #047857; padding: 3px 8px; border-radius: 6px; font-weight: 800; font-size: 10px; }
        .badge-pending { background: #fef2f2; color: #b91c1c; padding: 3px 8px; border-radius: 6px; font-weight: 800; font-size: 10px; }
        .sign-area { margin-top: 60px; width: 100%; }
        .sign-col { width: 45%; float: left; text-align: center; }
        .sign-line { border-top: 1px solid #94a3b8; margin-top: 40px; margin-bottom: 5px; width: 80%; margin-left: auto; margin-right: auto; }
        .sign-label { font-size: 11px; font-weight: 800; color: #475569; text-transform: uppercase; }
        @media print { .no-print { display: none; } body { padding: 0; } }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #d97706; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer;">
            Print / Save PDF Report
        </button>
    </div>

    <table class="header-table">
        <tr>
            <td>
                <h1 class="school-title">Bangla Model School</h1>
                <div class="report-sub">STUDENT TUITION FEES DUES & PAYMENT LEDGER</div>
                <div class="report-sub">Filter: {{ $selectedClass ? 'Class '.$selectedClass->name : 'All Classes' }}</div>
            </td>
            <td style="text-align: right; font-size: 12px; color: #64748b; font-weight: bold;">
                Generated: {{ now()->format('d M, Y h:i A') }}
            </td>
        </tr>
    </table>

    <table class="report-table">
        <thead>
            <tr>
                <th>Roll</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Guardian Phone</th>
                <th>Paid Fees</th>
                <th>Pending Dues</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $s)
                @php
                    $paidSum = $s->fees->where('status', 'paid')->sum('amount');
                    $pendingSum = $s->fees->where('status', 'pending')->sum('amount');
                @endphp
                <tr>
                    <td><strong>{{ $s->roll }}</strong></td>
                    <td><strong>{{ $s->name }}</strong></td>
                    <td>Class {{ $s->schoolClass->name ?? 'N/A' }}</td>
                    <td>{{ $s->phone ?? 'N/A' }}</td>
                    <td style="color: #047857;">৳{{ number_format($paidSum, 2) }}</td>
                    <td style="color: #b91c1c; font-weight: 800;">৳{{ number_format($pendingSum, 2) }}</td>
                    <td>
                        @if($pendingSum > 0)
                            <span class="badge-pending">DUES PENDING</span>
                        @else
                            <span class="badge-paid">CLEAR</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align: center; color: #94a3b8;">No student records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="sign-area">
        <div class="sign-col"><div class="sign-line"></div><div class="sign-label">Accounts Officer</div></div>
        <div class="sign-col" style="float: right;"><div class="sign-line"></div><div class="sign-label">Principal Signature</div></div>
    </div>
</body>
</html>
