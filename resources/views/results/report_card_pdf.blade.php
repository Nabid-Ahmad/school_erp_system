<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report Card - {{ $student->user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #5a67d8;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .school-name {
            font-size: 28px;
            font-weight: bold;
            color: #4c51bf;
            margin: 0 0 10px 0;
        }
        .report-title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            color: #4a5568;
            text-transform: uppercase;
        }
        .student-details {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .student-details td {
            padding: 8px;
            font-size: 14px;
        }
        .student-details td strong {
            color: #4a5568;
        }
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .results-table th, .results-table td {
            border: 1px solid #cbd5e0;
            padding: 12px 8px;
            text-align: center;
        }
        .results-table th {
            background-color: #ebf4ff;
            color: #2b6cb0;
            font-weight: bold;
            text-transform: uppercase;
        }
        .results-table td.subject-col {
            text-align: left;
            font-weight: bold;
        }
        .summary {
            width: 100%;
            border-collapse: collapse;
        }
        .summary td {
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            background-color: #f7fafc;
            border: 1px solid #cbd5e0;
        }
        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 12px;
            color: #718096;
        }
        .signatures {
            margin-top: 80px;
            width: 100%;
        }
        .signatures td {
            text-align: center;
            width: 33.33%;
        }
        .sign-line {
            border-top: 1px solid #000;
            margin: 0 20px;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="school-name">Global International School</h1>
        <p>123 Education Street, Knowledge City</p>
        <h2 class="report-title">Academic Report Card</h2>
        <p>{{ $exam->name }} ({{ \Carbon\Carbon::parse($exam->start_date)->format('M Y') }})</p>
    </div>

    <table class="student-details">
        <tr>
            <td><strong>Student Name:</strong> {{ $student->user->name }}</td>
            <td><strong>Admission No:</strong> {{ $student->admission_number }}</td>
        </tr>
        <tr>
            <td><strong>Class:</strong> {{ $student->schoolClass->name }}</td>
            <td><strong>Roll Number:</strong> {{ $student->roll_number }}</td>
        </tr>
    </table>

    <table class="results-table">
        <thead>
            <tr>
                <th class="subject-col">Subject</th>
                <th>Marks Obtained</th>
                <th>Maximum Marks</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td class="subject-col">{{ $result->subject->name }}</td>
                <td>{{ $result->marks }}</td>
                <td>100</td>
                <td>
                    <strong>{{ $result->grade }}</strong>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td style="text-align: left;">Total Marks: {{ $totalMarks }} / {{ $results->count() * 100 }}</td>
            <td style="text-align: center;">Average Percentage: {{ number_format($averageMarks, 2) }}%</td>
            <td style="text-align: right;">Overall Grade: {{ \App\Models\Result::calculateGrade($averageMarks) }}</td>
        </tr>
    </table>

    <table class="signatures">
        <tr>
            <td>
                <div class="sign-line">Class Teacher</div>
            </td>
            <td>
                <div class="sign-line">Parent/Guardian</div>
            </td>
            <td>
                <div class="sign-line">Principal</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        This is a computer-generated document. No signature is required. <br>
        Generated on {{ now()->format('d M Y, h:i A') }}
    </div>

</body>
</html>
