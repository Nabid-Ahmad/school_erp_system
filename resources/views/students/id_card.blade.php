<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student ID Card</title>
    <style>
        @page { margin: 0px; }
        body { margin: 0px; padding: 0px; font-family: 'Helvetica', sans-serif; background: white; }
        .id-card { width: 204pt; height: 324pt; border: none; position: relative; overflow: hidden; margin: 0 auto; }
        .header { background: #15803d; height: 80px; text-align: center; color: white; padding-top: 15px; }
        .school-name { font-size: 14px; font-weight: bold; margin: 0; text-transform: uppercase; }
        .school-subtitle { font-size: 7px; opacity: 0.8; margin-top: 3px; }
        
        .photo-area { text-align: center; margin-top: -40px; }
        .photo { width: 80px; height: 80px; border-radius: 50%; border: 4px solid white; object-fit: cover; background: #eee; }
        
        .student-info { text-align: center; margin-top: 10px; padding: 0 20px; }
        .student-name { font-size: 14px; font-weight: 800; color: #333; margin: 5px 0; text-transform: uppercase; }
        .student-roll { font-size: 10px; color: #15803d; font-weight: bold; margin-bottom: 15px; }
        
        .details-table { width: 100%; margin-top: 10px; font-size: 9px; }
        .details-table td { padding: 4px 0; vertical-align: top; }
        .label { font-weight: bold; color: #666; width: 60px; text-align: left; }
        .value { color: #333; font-weight: bold; }
        
        .footer { position: absolute; bottom: 0; width: 100%; background: #15803d; color: white; text-align: center; font-size: 8px; padding: 5px 0; }
        .signature { position: absolute; bottom: 40px; right: 20px; text-align: center; }
        .sign-line { border-top: 1px solid #333; width: 60px; margin-top: 20px; }
        .sign-text { font-size: 7px; color: #666; margin-top: 2px; }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="header">
            <h1 class="school-name">{{ $schoolSettings['school_name'] ?? 'Bangla Model School' }}</h1>
            <p class="school-subtitle">EXCELLENCE IN EDUCATION</p>
        </div>

        <div class="photo-area">
            @if($student->image)
                <img src="{{ public_path('storage/' . $student->image) }}" class="photo">
            @elseif(isset($schoolSettings['school_logo']))
                <img src="{{ public_path('storage/' . $schoolSettings['school_logo']) }}" class="photo">
            @else
                <div class="photo" style="display: flex; align-items: center; justify-content: center; background: #ddd; margin: auto;">PHOTO</div>
            @endif
        </div>

        <div class="student-info">
            <h2 class="student-name">{{ $student->name }}</h2>
            <div class="student-roll">ROLL: {{ $student->roll }}</div>

            <table class="details-table">
                <tr>
                    <td class="label">Class:</td>
                    <td class="value">Class {{ $student->schoolClass->name }}</td>
                </tr>
                <tr>
                    <td class="label">Phone:</td>
                    <td class="value">{{ $student->phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">DOB:</td>
                    <td class="value">{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M, Y') : 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <div class="signature">
            <div class="sign-line"></div>
            <div class="sign-text">Principal</div>
        </div>

        <div class="footer">
            www.banglamodel.edu.bd
        </div>
    </div>
</body>
</html>
