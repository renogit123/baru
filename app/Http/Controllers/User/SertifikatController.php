<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\SertifikatText;
use setasign\Fpdi\Fpdi;

class SertifikatController extends Controller
{
    public function generate()
    {
        $userId = auth()->id();
        $biodata = Biodata::where('user_id', $userId)->firstOrFail();

        // Pastikan biodata sudah disetujui admin
        if (!$biodata->is_approved) {
            abort(403, 'Sertifikat belum tersedia. Menunggu persetujuan admin.');
        }

        $text = SertifikatText::first();

        $pdf = new Fpdi();
        $pdf->AddPage('L');

        // Template PDF background
        $templatePath = public_path('templates/sertifku.pdf');
        $pdf->setSourceFile($templatePath);
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId, 0, 0, 297, 210);

        $pdf->SetTextColor(0, 0, 0);

        // ===== Konten PDF =====

        // Deskripsi Atas
        // $pdf->SetFont('Arial', '', 11);
        // $pdf->SetXY(35, 50);
        // $pdf->MultiCell(229, 5, $text->deskripsi_atas ?? '', 0, 'C');

        // Nama
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(119, 87.7);
        $pdf->Cell(0, 8, strtoupper($biodata->nama), 0, 1, 'L');

        // NIK
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(119, 92.6);
        $pdf->Cell(0, 8, $biodata->nik ?? 'Kosong', 0, 1, 'L');

        // TTL
        $pdf->SetXY(119, 100.4);
        $ttl = ($biodata->tempat_lahir ?? '-') . ', ' . ($biodata->tanggal_lahir ? date('d F Y', strtotime($biodata->tanggal_lahir)) : '-');
        $pdf->Cell(0, 8, $ttl, 0, 1, 'L');

        // Jabatan
        $pdf->SetXY(119, 107.4);
        $pdf->Cell(0, 8, $biodata->jabatan ?? '-', 0, 1, 'L');

        // Alamat
        $pdf->SetXY(119, 112.7);
        $pdf->Cell(0, 8, $biodata->alamat ?? '-', 0, 1, 'L');

        // Judul Tengah
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(40, 120);
        $pdf->Cell(217, 10, strtoupper($text->judul_tengah ?? ''), 0, 1, 'C');

        // Deskripsi Bawah
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(25, 132);
        $pdf->MultiCell(247, 5, $text->deskripsi_bawah ?? '', 0, 'C');

        // 🔵 Nomor Sertifikat
        // $pdf->SetFont('Arial', '', 11);
        // $pdf->SetXY(136, 63.8); // Atur posisi sesuai template
        // $pdf->Cell(0, 6, 'KOSONG' . ($text->nomor_sertifikat ?? ''), 0, 1, 'L');

        // Tanggal Sertifikat
        // $pdf->SetXY(30, 180);
        // $tanggal = \Carbon\Carbon::parse($text->tanggal_sertifikat ?? now())->translatedFormat('d F Y');
        // $pdf->Cell(0, 6, 'Dikeluarkan pada: ' . $tanggal, 0, 1, 'L');

        // Penandatangan
        // $pdf->SetFont('Arial', 'B', 11);
        // $pdf->SetXY(150, 170);
        // $pdf->Cell(0, 6, $text->penandatangan ?? '-', 0, 1, 'L');

        // $pdf->SetFont('Arial', '', 11);
        // $pdf->SetXY(150, 176);
        // $pdf->Cell(0, 6, $text->jabatan_penandatangan ?? '-', 0, 1, 'L');

        // $pdf->SetXY(150, 182);
        // $pdf->Cell(0, 6, 'NIP. ' . ($text->nip_penandatangan ?? '-'), 0, 1, 'L');

        // Penandatangan
        // $pdf->SetFont('Arial', 'B', 11);
        // $pdf->SetXY(130, 80);
        // $pdf->Cell(0, 6, 'Pada tanggal '.$text->tanggal_penetapan ?? '-', 0, 1, 'L');

        // $pdf->SetFont('Arial', '', 11);
        // $pdf->SetXY(150, 90);
        // $pdf->Cell(0, 6, $text->jabatan_penetapan ?? '-', 0, 1, 'L');

        // $pdf->SetFont('Arial', '', 11);
        // $pdf->SetXY(150, 100);
        // $pdf->Cell(0, 6,  ($text->kota_penetapan ?? '-'), 0, 1, 'L');

        

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output('I', 'SERTIFIKAT PELATIHAN.pdf');
        }, 'sertifikat-' . $biodata->id . '.pdf');
    }
}
