<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; background: #f0f0f0; padding: 20px; }
        .id-card {
            width: 320px;
            height: 500px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin: 0 auto;
        }
        .header {
            background: #15803d;
            height: 150px;
            text-align: center;
            padding-top: 30px;
            color: white;
        }
        .school-name { font-size: 18px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; }
        .photo-container {
            width: 120px;
            height: 120px;
            border-radius: 20px;
            border: 5px solid white;
            position: absolute;
            top: 90px;
            left: 50%;
            margin-left: -60px;
            overflow: hidden;
            background: #e2e8f0;
        }
        .photo-container img { width: 100%; height: 100%; object-fit: cover; }
        .content {
            margin-top: 80px;
            text-align: center;
            padding: 20px;
        }
        .teacher-name { font-size: 22px; font-weight: 900; color: #1e293b; margin-bottom: 5px; }
        .designation { font-size: 12px; font-weight: 900; color: #15803d; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; }
        .info-grid {
            text-align: left;
            margin-top: 20px;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }
        .info-item { margin-bottom: 15px; }
        .label { font-size: 8px; font-weight: 900; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .value { font-size: 14px; font-weight: 700; color: #334155; }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: #15803d;
            height: 15px;
        }
        .signature {
            margin-top: 30px;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            font-size: 10px;
            font-weight: 900;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="header">
            <div class="school-name">{{ $schoolSettings['school_name'] ?? 'Bangla Model School' }}</div>
            <div style="font-size: 10px; opacity: 0.8; margin-top: 5px;">STAFF IDENTITY CARD</div>
        </div>
        
        <div class="photo-container">
            @if($teacher->image)
                <img src="{{ public_path('storage/'.$teacher->image) }}">
            @else
                <div style="background: #15803d; width: 100%; height: 100%; display: flex; align-items: center; justify-center; color: white; font-size: 50px;">
                    {{ substr($teacher->name, 0, 1) }}
                </div>
            @endif
        </div>

        <div class="content">
            <div class="teacher-name">{{ $teacher->name }}</div>
            <div class="designation">{{ $teacher->designation ?? 'Faculty Member' }}</div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Teacher ID</div>
                    <div class="value">TMS-T-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Department / Subject</div>
                    <div class="value">{{ $teacher->subject }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Phone Number</div>
                    <div class="value">{{ $teacher->phone }}</div>
                </div>
            </div>

            <div class="signature">Principal Signature</div>
        </div>
        <div class="footer"></div>
    </div>
</body>
</html>
