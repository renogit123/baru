<?php

// app/Http/Controllers/User/SertifikatController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biodata;
use setasign\Fpdi\Fpdi;

class SertifikatController extends Controller
{
    public function generate()
    {
        $biodata = Biodata::where('user_id', auth()->id())->firstOrFail();

        $pdf = new Fpdi();
        $pdf->AddPage('L'); // Landscape
        $path = public_path('templates/sertifikat-template.pdf');
        $pdf->setSourceFile($path);
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, 0, 0, 297, 210); // A4 Landscape

        $pdf->SetFont('Arial', 'B', 12); // Bold, Times
        $pdf->SetTextColor(0, 0, 0);

        // NAMA
        $pdf->SetXY(119, 69.5);
        $pdf->Cell(0, 8, strtoupper($biodata->nama), 0, 1, 'L');

        // NIK
        $pdf->SetXY(119, 76.3);
        $pdf->Cell(0, 8, $biodata->nik ?? 'kosong', 0, 1, 'L');

        // TTL
        $pdf->SetXY(119, 87);
        $ttl = ($biodata->tempat_lahir ?? '-') . ', ' . ($biodata->tanggal_lahir ? date('d F Y', strtotime($biodata->tanggal_lahir)) : '-');
        $pdf->Cell(0, 8, $ttl, 0, 1, 'L');

        // JABATAN
        $pdf->SetXY(119, 96.2);
        $pdf->Cell(0, 8, $biodata->jabatan ?? 'kosong', 0, 1, 'L');

        // ALAMAT
        $pdf->SetXY(119, 102.7);
        $pdf->Cell(0, 8, $biodata->alamat ?? 'kosong', 0, 1, 'L');

        // Output PDF ke browser
        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output('I', 'sertifikat.pdf');
        }, 'sertifikat-' . $biodata->id . '.pdf');
    }
}



