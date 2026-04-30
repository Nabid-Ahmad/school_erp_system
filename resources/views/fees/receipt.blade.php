<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Money Receipt</title>
    <style>
        @page { margin: 0px; }
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; margin: 0; padding: 0; }
        .receipt-box { border: 2px solid #15803d; padding: 30px; position: relative; margin: 20px; min-height: 350pt; }
        .header { text-align: center; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        .school-name { font-size: 24px; font-weight: bold; color: #15803d; text-transform: uppercase; margin: 0; }
        .school-addr { font-size: 10px; color: #666; margin: 5px 0; }
        .title { display: inline-block; background: #15803d; color: white; padding: 5px 20px; border-radius: 5px; font-weight: bold; margin-bottom: 10px; }
        
        .info-grid { width: 100%; margin-bottom: 20px; }
        .info-grid td { padding: 5px; font-size: 13px; }
        .label { font-weight: bold; color: #666; width: 100px; }
        .value { border-bottom: 1px dotted #ccc; }
        
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th { background: #f9f9f9; text-align: left; padding: 10px; border: 1px solid #eee; font-size: 12px; }
        .table td { padding: 10px; border: 1px solid #eee; font-size: 13px; }
        
        .footer { margin-top: 40px; }
        .signature { width: 150px; border-top: 1px solid #333; text-align: center; float: right; font-size: 12px; padding-top: 5px; margin-top: 30px; }
        .date { font-size: 12px; color: #666; }
        .stamp { position: absolute; bottom: 20px; left: 50px; opacity: 0.1; transform: rotate(-15deg); font-size: 40px; font-weight: bold; color: #15803d; border: 5px solid #15803d; padding: 10px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="receipt-box">
        <div class="header">
            <h1 class="school-name">{{ $schoolSettings['school_name'] ?? 'Bangla Model School' }}</h1>
            <p class="school-addr">{{ $schoolSettings['school_address'] ?? '123 School Road, Dhaka, Bangladesh' }} | {{ $schoolSettings['school_phone'] ?? '' }}</p>
            <div class="title">MONEY RECEIPT</div>
        </div>

        <table class="info-grid">
            <tr>
                <td class="label">Receipt No:</td>
                <td class="value">#{{ $fee->id }}</td>
                <td class="label" style="text-align: right;">Date:</td>
                <td class="value" style="text-align: right;">{{ $fee->created_at->format('d M, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Student Name:</td>
                <td class="value" colspan="3">{{ $fee->student->name }}</td>
            </tr>
            <tr>
                <td class="label">Roll Number:</td>
                <td class="value">{{ $fee->student->roll }}</td>
                <td class="label" style="text-align: right;">Class:</td>
                <td class="value" style="text-align: right;">Class {{ $fee->student->schoolClass->name }}</td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Month/Year</th>
                    <th style="text-align: right;">Amount (TK)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $fee->fee_type }}</td>
                    <td>{{ $fee->month }} {{ $fee->year }}</td>
                    <td style="text-align: right;">{{ number_format($fee->amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL PAID</td>
                    <td style="text-align: right; font-weight: bold; color: #15803d;">{{ number_format($fee->amount, 2) }} TK</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <div class="date">Payment Status: <span style="color: #15803d; font-weight: bold;">{{ strtoupper($fee->status) }}</span></div>
            <div class="signature">Authorized Signature</div>
            <div style="clear: both;"></div>
        </div>

        <div class="stamp">PAID</div>
    </div>
</body>
</html>
