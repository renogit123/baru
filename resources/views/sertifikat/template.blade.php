<!-- resources/views/sertifikat/template.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 50px;
        }

        .sertifikat {
            border: 10px solid gold;
            padding: 30px;
            background: #fffbea;
        }

        h1 {
            font-size: 36px;
        }

        .nama {
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="sertifikat">
        <h1>SERTIFIKAT</h1>
        <p>Diberikan kepada:</p>
        <div class="nama">{{ strtoupper($user->name) }}</div>
        <p>Atas partisipasinya dalam kegiatan ini</p>
        <div class="footer">
            <p>{{ date('d F Y') }}</p>
            <p><strong>Panitia Penyelenggara</strong></p>
        </div>
    </div>
</body>
</html>
