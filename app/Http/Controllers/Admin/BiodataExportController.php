<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\JadwalPelatihan;

require_once base_path('vendor/setasign/fpdf/fpdf.php');

class BiodataExportController extends Controller
{
    public function exportKosong()
    {
        $users = User::with('biodata')->get();

        $pdf = new \FPDF('L', 'mm', 'A4'); // Landscape
        $pdf->AddPage();

        // Logo kiri atas
        $logoPath = public_path('img/logo-kemendagri.png');
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 19, 5, 20); // x = 10, y = 10, width = 25mm
        }
        
        // Header tulisan
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(40, 10);
        $pdf->Cell(0, 5, 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA', 0, 1, 'L');
        
        $pdf->SetFont('Arial', 'B', 10); // ⬅️ Jadikan bold hanya untuk baris ini
        $pdf->SetX(40);
        $pdf->Cell(0, 5, 'BALAI BESAR PEMERINTAHAN DESA DI MALANG', 0, 1, 'L');
        
        $pdf->Ln(10);

        // Judul Tengah
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, 'DAFTAR NILAI PRE TEST DAN POST TEST', 0, 1, 'C');
        $pdf->Cell(0, 8, 'PELATIHAN TEKNIS PENYUSUNAN LAPORAN PENYELENGGARAAN PEMERINTAHAN DESA TAHUN 2024', 0, 1, 'C');
        $pdf->Cell(0, 8, 'KABUPATEN HALMAHERA TENGAH PROVINSI MALUKU UTARA', 0, 1, 'C');
        $pdf->Ln(4);

        // Tanggal rata kanan
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 2, 'Tanggal, ' . $tanggal, 0, 1, 'L');
        $pdf->Ln(2);

        // Table Header
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, 'NO', 1, 0, 'C');
        $pdf->Cell(60, 10, 'NAMA', 1, 0, 'C');
        $pdf->Cell(15, 10, 'L/P', 1, 0, 'C');
        $pdf->Cell(100, 10, 'JABATAN', 1, 0, 'C');
        $pdf->Cell(30, 10, 'PRE TEST', 1, 0, 'C');
        $pdf->Cell(30, 10, 'POST TEST', 1, 1, 'C');

        // Table Rows
        $pdf->SetFont('Arial', '', 11);
        $no = 1;

        foreach ($users as $user) {
            if (!$user->biodata) continue;

            // Ubah gender jadi L/P
            $jk = strtoupper(substr($user->biodata->jenis_kelamin, 0, 1)); // L atau P

            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(60, 10, strtoupper($user->biodata->nama), 1, 0);
            $pdf->Cell(15, 10, $jk, 1, 0, 'C');
            $pdf->Cell(100, 10, $user->biodata->jabatan, 1, 0);
            $pdf->Cell(30, 10, '', 1, 0); // Pre test kosong
            $pdf->Cell(30, 10, '', 1, 1); // Post test kosong
        }

        // Tambah baris rata-rata dan kategori penilaian
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(185, 10, 'RATA-RATA', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0); // rata-rata pre
        $pdf->Cell(30, 10, '', 1, 1); // rata-rata post

        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'KATEGORI PENILAIAN', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, '81 - 100  :  Sangat Baik', 0, 1);
        $pdf->Cell(0, 6, '71 - 80    :  Baik', 0, 1);
        $pdf->Cell(0, 6, '56 - 70    :  Cukup', 0, 1);
        $pdf->Cell(0, 6, '< 56        :  Kurang', 0, 1);

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, 'daftar-nilai-kosong.pdf');
    }

    public function exportByJadwal($id)
    {
        $jadwal = JadwalPelatihan::with('pendaftars.user.biodata')->findOrFail($id);
    
        $pdf = new \FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
    
        // Logo kiri atas
        $logoPath = public_path('img/logo-kemendagri.png');
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 19, 5, 20);
        }
    
        // Header tulisan
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(40, 10);
        $pdf->Cell(0, 5, 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA', 0, 1, 'L');
    
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetX(40);
        $pdf->Cell(0, 5, 'BALAI BESAR PEMERINTAHAN DESA DI MALANG', 0, 1, 'L');
    
        $pdf->Ln(10);
    
        // Judul Tengah
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 8, 'DAFTAR NILAI PRE TEST DAN POST TEST', 0, 1, 'C');
        $pdf->Cell(0, 8, 'PELATIHAN ' . strtoupper($jadwal->judul), 0, 1, 'C');
        $pdf->Cell(0, 8, 'KABUPATEN HALMAHERA TENGAH PROVINSI MALUKU UTARA', 0, 1, 'C');
        $pdf->Ln(4);
        
    
        // Tanggal
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(0, 2, 'Tanggal, ' . $tanggal, 0, 1, 'L');
        $pdf->Ln(2);
    
        // Table Header
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(10, 10, 'NO', 1, 0, 'C');
        $pdf->Cell(60, 10, 'NAMA', 1, 0, 'C');
        $pdf->Cell(15, 10, 'L/P', 1, 0, 'C');
        $pdf->Cell(100, 10, 'JABATAN', 1, 0, 'C');
        $pdf->Cell(30, 10, 'PRE TEST', 1, 0, 'C');
        $pdf->Cell(30, 10, 'POST TEST', 1, 1, 'C');
    
        // Isi Data
        $pdf->SetFont('Arial', '', 11);
        $no = 1;
    
        foreach ($jadwal->pendaftars as $peserta) {
            if ($peserta->status_peserta !== 'approved') continue;
            $bio = $peserta->user->biodata;
            if (!$bio) continue;
    
            $jk = strtoupper(substr($bio->jenis_kelamin, 0, 1)); // L / P
    
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(60, 10, strtoupper($bio->nama), 1, 0);
            $pdf->Cell(15, 10, $jk, 1, 0, 'C');
            $pdf->Cell(100, 10, $bio->jabatan, 1, 0);
            $pdf->Cell(30, 10, '', 1, 0); // Kosong pre test
            $pdf->Cell(30, 10, '', 1, 1); // Kosong post test
        }
    
        // Tambah baris rata-rata dan kategori penilaian
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(185, 10, 'RATA-RATA', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0); // rata-rata pre
        $pdf->Cell(30, 10, '', 1, 1); // rata-rata post
    
        $pdf->Ln(4);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'KATEGORI PENILAIAN', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, '81 - 100  :  Sangat Baik', 0, 1);
        $pdf->Cell(0, 6, '71 - 80    :  Baik', 0, 1);
        $pdf->Cell(0, 6, '56 - 70    :  Cukup', 0, 1);
        $pdf->Cell(0, 6, '< 56        :  Kurang', 0, 1);
    
        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output();
        }, 'nilai-pelatihan-' . $jadwal->id . '.pdf');
    }
    
}
