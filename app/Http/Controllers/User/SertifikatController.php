<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biodata;
use setasign\Fpdi\Fpdi;

class SertifikatController extends Controller
{
    public function generate($userId)
    {
        $biodata = Biodata::where('user_id', $userId)->firstOrFail();

        // CEK APPROVED
        if (!$biodata->is_approved) {
            abort(403, 'Sertifikat belum tersedia. Menunggu persetujuan Admin.');
        }

        $pdf = new Fpdi();
        $pdf->AddPage('L'); // Landscape
        $path = public_path('templates/sertifikat-template.pdf');
        $pdf->setSourceFile($path);
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, 0, 0, 297, 210); // A4 Landscape

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0);

        // Nama
        $pdf->SetXY(119, 69.5);
        $pdf->Cell(0, 8, strtoupper($biodata->nama), 0, 1, 'L');

        // NIK
        $pdf->SetXY(119, 76.3);
        $pdf->Cell(0, 8, $biodata->nik ?? '-', 0, 1, 'L');

        // TTL
        $pdf->SetXY(119, 87);
        $ttl = ($biodata->tempat_lahir ?? '-') . ', ' . ($biodata->tanggal_lahir ? date('d F Y', strtotime($biodata->tanggal_lahir)) : '-');
        $pdf->Cell(0, 8, $ttl, 0, 1, 'L');

        // Jabatan
        $pdf->SetXY(119, 96.2);
        $pdf->Cell(0, 8, $biodata->jabatan ?? '-', 0, 1, 'L');

        // Alamat
        $pdf->SetXY(119, 102.7);
        $pdf->Cell(0, 8, $biodata->alamat ?? '-', 0, 1, 'L');

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output('I', 'sertifikat.pdf');
        }, 'sertifikat-' . $biodata->id . '.pdf');
    }
}
