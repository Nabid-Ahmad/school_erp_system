<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Teacher ID Card</title>
    <style>
        @page {
            size: 216pt 342pt;
            margin: 0px;
        }
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }
        html, body {
            width: 216pt;
            height: 342pt;
            margin: 0px;
            padding: 0px;
            font-family: 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif;
            background: #ffffff;
            overflow: hidden;
            -webkit-print-color-adjust: exact;
        }
        .id-card {
            width: 216pt;
            height: 342pt;
            position: relative;
            background: #ffffff;
            overflow: hidden;
            margin: 0;
            padding: 0;
            page-break-inside: avoid;
            page-break-after: avoid;
        }
        
        /* Premium Header Banner */
        .header {
            background: #022c22;
            height: 90pt;
            text-align: center;
            color: #ffffff;
            padding-top: 12pt;
            position: relative;
            border-bottom: 3.5pt solid #fbbf24;
        }
        .school-name {
            font-size: 11pt;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
            color: #ffffff;
            line-height: 1.15;
            padding: 0 8pt;
        }
        .est-text {
            font-size: 5.5pt;
            font-weight: 800;
            color: #fbbf24;
            letter-spacing: 1.5pt;
            text-transform: uppercase;
            margin-top: 3pt;
        }

        /* Photo Area */
        .photo-area {
            position: absolute;
            top: 58pt;
            left: 50%;
            margin-left: -38pt;
            width: 76pt;
            height: 76pt;
            border-radius: 18pt;
            border: 3.5pt solid #ffffff;
            background: #f1f5f9;
            overflow: hidden;
            text-align: center;
            z-index: 10;
        }
        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-placeholder {
            width: 100%;
            height: 100%;
            background: #065f46;
            color: #ffffff;
            font-size: 28pt;
            font-weight: 900;
            line-height: 76pt;
            text-align: center;
        }

        /* Main Body Content */
        .card-body {
            margin-top: 48pt;
            padding: 0 14pt;
            text-align: center;
        }
        .teacher-name {
            font-size: 13pt;
            font-weight: 900;
            color: #0f172a;
            margin: 0 0 3pt 0;
            line-height: 1.15;
            text-transform: capitalize;
        }
        .designation-pill {
            display: inline-block;
            font-size: 7.5pt;
            font-weight: 900;
            color: #065f46;
            text-transform: uppercase;
            letter-spacing: 0.8pt;
            background: #ecfdf5;
            padding: 2.5pt 10pt;
            border-radius: 6pt;
            border: 0.5pt solid #a7f3d0;
            margin-bottom: 8pt;
        }

        /* Info List Table */
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 3.5pt;
            font-size: 8pt;
            text-align: left;
        }
        .info-row {
            background: #f8fafc;
        }
        .info-cell-label {
            padding: 3.5pt 8pt;
            font-size: 5.5pt;
            font-weight: 900;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.6pt;
            width: 44%;
            background: #f1f5f9;
            border-top-left-radius: 5pt;
            border-bottom-left-radius: 5pt;
        }
        .info-cell-val {
            padding: 3.5pt 8pt;
            font-size: 7.5pt;
            font-weight: 900;
            color: #0f172a;
            text-align: right;
            border-top-right-radius: 5pt;
            border-bottom-right-radius: 5pt;
            background: #f8fafc;
        }

        /* Bottom Section: Signature & Barcode */
        .bottom-section {
            position: absolute;
            bottom: 14pt;
            left: 14pt;
            right: 14pt;
            height: 38pt;
        }
        .barcode-box {
            float: left;
            width: 58%;
            text-align: left;
        }
        .barcode-lines {
            font-family: 'Courier', monospace;
            font-size: 9.5pt;
            font-weight: 900;
            letter-spacing: 1.4pt;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 2pt;
        }
        .barcode-subtext {
            font-size: 6pt;
            font-weight: 900;
            color: #64748b;
            letter-spacing: 0.6pt;
        }
        .signature-box {
            float: right;
            width: 38%;
            text-align: center;
        }
        .sign-line {
            border-top: 1pt solid #94a3b8;
            margin-top: 16pt;
            margin-bottom: 2pt;
        }
        .sign-title {
            font-size: 5.5pt;
            font-weight: 900;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5pt;
        }
    </style>
</head>
<body>
    @php
        $imageSrc = null;
        $rawImage = $teacher->image ?? null;
        if ($rawImage) {
            if (filter_var($rawImage, FILTER_VALIDATE_URL) || str_starts_with($rawImage, 'http://') || str_starts_with($rawImage, 'https://')) {
                try {
                    $ctx = stream_context_create([
                        "ssl" => [
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                        ],
                        "http" => [
                            "timeout" => 5,
                        ]
                    ]);
                    $imageData = @file_get_contents($rawImage, false, $ctx);
                    if ($imageData !== false) {
                        $ext = pathinfo(parse_url($rawImage, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpeg';
                        $imageSrc = 'data:image/' . $ext . ';base64,' . base64_encode($imageData);
                    } else {
                        $imageSrc = $rawImage;
                    }
                } catch (\Throwable $e) {
                    $imageSrc = $rawImage;
                }
            } else {
                $cleanPath = ltrim(str_replace(['public/', 'storage/', '/storage/'], '', $rawImage), '/');
                $possiblePaths = [
                    public_path('storage/' . $cleanPath),
                    public_path($cleanPath),
                    storage_path('app/public/' . $cleanPath),
                ];
                foreach ($possiblePaths as $p) {
                    if (file_exists($p) && is_file($p)) {
                        $ext = strtolower(pathinfo($p, PATHINFO_EXTENSION));
                        $mime = ($ext === 'png') ? 'image/png' : (($ext === 'webp') ? 'image/webp' : 'image/jpeg');
                        $data = file_get_contents($p);
                        $imageSrc = 'data:' . $mime . ';base64,' . base64_encode($data);
                        break;
                    }
                }
            }
        }
    @endphp

    <div class="id-card">
        <!-- Premium Header Section -->
        <div class="header">
            <div class="school-name">{{ $schoolSettings['school_name'] ?? 'Bangla Model School' }}</div>
            <div class="est-text">EXCELLENCE IN EDUCATION • EST. 1995</div>
        </div>

        <!-- Photo Frame -->
        <div class="photo-area">
            @if($imageSrc)
                <img src="{{ $imageSrc }}" class="photo">
            @else
                <div class="photo-placeholder">
                    {{ strtoupper(substr($teacher->name, 0, 1)) }}
                </div>
            @endif
        </div>

        <!-- Body Section -->
        <div class="card-body">
            <h1 class="teacher-name">{{ $teacher->name }}</h1>
            <div class="designation-pill">{{ $teacher->designation ?? 'Faculty Member' }}</div>

            <table class="info-table">
                <tr class="info-row">
                    <td class="info-cell-label">Teacher ID</td>
                    <td class="info-cell-val">TMS-T-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-cell-label">Subject</td>
                    <td class="info-cell-val">{{ $teacher->subject ?? 'N/A' }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-cell-label">Phone</td>
                    <td class="info-cell-val">{{ $teacher->phone ?? 'N/A' }}</td>
                </tr>
                <tr class="info-row">
                    <td class="info-cell-label">Joined Date</td>
                    <td class="info-cell-val">{{ $teacher->joining_date ? \Carbon\Carbon::parse($teacher->joining_date)->format('M Y') : 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- Bottom Signature & Barcode Section -->
        <div class="bottom-section">
            <div class="barcode-box">
                <div class="barcode-lines">|| | ||| || |||| |||</div>
                <div class="barcode-subtext">ID: T-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="signature-box">
                <div class="sign-line"></div>
                <div class="sign-title">Authorized Signature</div>
            </div>
        </div>
    </div>
</body>
</html>
