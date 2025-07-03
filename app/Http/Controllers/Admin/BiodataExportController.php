<?php

namespace App\Http\Controllers\Admin;
use App\Exports\PesertaPelatihanPerJadwalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\JadwalPelatihan;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
    $pdf->Cell(0, 8, 'PELATIHAN TEKNIS PENYUSUNAN LAPORAN PENYELENGGARAAN PEMERINTAHAN DESA TAHUN 2024', 0, 1, 'C');
    $pdf->Cell(0, 8, 'KABUPATEN HALMAHERA TENGAH PROVINSI MALUKU UTARA', 0, 1, 'C');
    $pdf->Ln(4);

    // Tanggal
    $tanggal = Carbon::now()->translatedFormat('d F Y');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 2, 'Tanggal, ' . $tanggal, 0, 1, 'L');
    $pdf->Ln(2);

    // Header tabel baris 1
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(10, 14, 'NO', 1, 0, 'C');
    $pdf->Cell(60, 14, 'NAMA', 1, 0, 'C');
    $pdf->Cell(15, 14, 'L/P', 1, 0, 'C');
    $pdf->Cell(100, 14, 'JABATAN', 1, 0, 'C');

    // Merge kolom untuk "NILAI"
    $xNilai = $pdf->GetX();
    $yNilai = $pdf->GetY();
    $pdf->Cell(60, 7, 'N I L A I', 1, 1, 'C');

    // Subheader nilai (PRE TEST dan POST TEST)
    $pdf->SetXY($xNilai, $yNilai + 7);
    $pdf->Cell(30, 7, 'PRE TEST', 1, 0, 'C');
    $pdf->Cell(30, 7, 'POST TEST', 1, 1, 'C');

    // Isi Data
    $pdf->SetFont('Arial', '', 11);
    $no = 1;

    foreach ($users as $user) {
        if (!$user->biodata) continue;

        $jk = strtolower($user->biodata->jenis_kelamin) === 'perempuan' ? 'P' : 'L';

        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(60, 10, strtoupper($user->biodata->nama), 1, 0);
        $pdf->Cell(15, 10, $jk, 1, 0, 'C');
        $pdf->Cell(100, 10, $user->biodata->jabatan, 1, 0);
        $pdf->Cell(30, 10, '', 1, 0); // Kosong Pre Test
        $pdf->Cell(30, 10, '', 1, 1); // Kosong Post Test
    }

    // Tambah rata-rata
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(185, 10, 'RATA-RATA', 1, 0, 'C');
    $pdf->Cell(30, 10, '', 1, 0); // rata-rata pre
    $pdf->Cell(30, 10, '', 1, 1); // rata-rata post

    // Kategori
    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'KATEGORI PENILAIAN', 0, 1);
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

    // Jika ada query ?format=excel maka export Excel
    if (request('format') === 'excel') {
        $filename = 'nilai-pelatihan-' . $jadwal->id . '.xlsx';
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\NilaiPesertaExport($jadwal), $filename);
    }

    // PDF generation
    $pdf = new \FPDF('L', 'mm', 'A4');
    $pdf->AddPage();

    // Logo kiri atas
    $logoPath = public_path('img/logo-kemendagri.png');
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 19, 5, 20);
    }

    // Header
    $pdf->SetFont('Arial', '', 10);
    $pdf->SetXY(40, 10);
    $pdf->Cell(0, 5, 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA', 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetX(40);
    $pdf->Cell(0, 5, 'BALAI BESAR PEMERINTAHAN DESA DI MALANG', 0, 1, 'L');

    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 8, 'DAFTAR NILAI PRE TEST DAN POST TEST', 0, 1, 'C');
    $pdf->Cell(0, 8, 'PELATIHAN TEKNIS PENYUSUNAN LAPORAN PENYELENGGARAAN PEMERINTAHAN DESA TAHUN 2024', 0, 1, 'C');
    $pdf->Cell(0, 8, 'KABUPATEN HALMAHERA TENGAH PROVINSI MALUKU UTARA', 0, 1, 'C');
    $pdf->Ln(4);

    // Tanggal
    $tanggal = \Illuminate\Support\Carbon::now()->translatedFormat('d F Y');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 2, 'Tanggal, ' . $tanggal, 0, 1, 'L');
    $pdf->Ln(2);

    // Header tabel baris 1
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(10, 14, 'NO', 1, 0, 'C');
    $pdf->Cell(60, 14, 'NAMA', 1, 0, 'C');
    $pdf->Cell(15, 14, 'L/P', 1, 0, 'C');
    $pdf->Cell(100, 14, 'JABATAN', 1, 0, 'C');
    $pdf->Cell(60, 7, 'N I L A I', 1, 1, 'C');

    // Header tabel baris 2 (subheader nilai)
    $pdf->SetX(195);
    $pdf->Cell(30, 7, 'PRE TEST', 1, 0, 'C');
    $pdf->Cell(30, 7, 'POST TEST', 1, 1, 'C');

    // Isi tabel
    $pdf->SetFont('Arial', '', 11);
    $no = 1;
    foreach ($jadwal->pendaftars as $peserta) {
        if ($peserta->status_peserta !== 'approved') continue;

        $bio = $peserta->user->biodata;
        if (!$bio) continue;

        $jk = strtolower($bio->jenis_kelamin) === 'perempuan' ? 'P' : 'L';

        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(60, 10, strtoupper($bio->nama), 1, 0);
        $pdf->Cell(15, 10, $jk, 1, 0, 'C');
        $pdf->Cell(100, 10, $bio->jabatan, 1, 0);
        $pdf->Cell(30, 10, '', 1, 0); // Pre Test
        $pdf->Cell(30, 10, '', 1, 1); // Post Test
    }

    // Baris rata-rata
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(185, 10, 'RATA-RATA', 1, 0, 'C');
    $pdf->Cell(30, 10, '', 1, 0);
    $pdf->Cell(30, 10, '', 1, 1);

    $pdf->Ln(4);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'KATEGORI PENILAIAN', 0, 1);
    $pdf->Cell(0, 6, '81 - 100  :  Sangat Baik', 0, 1);
    $pdf->Cell(0, 6, '71 - 80    :  Baik', 0, 1);
    $pdf->Cell(0, 6, '56 - 70    :  Cukup', 0, 1);
    $pdf->Cell(0, 6, '< 56        :  Kurang', 0, 1);

    return response()->streamDownload(function () use ($pdf) {
        $pdf->Output();
    }, 'nilai-pelatihan-' . $jadwal->id . '.pdf');
}

public function exportExcelByJadwal($id)
{
    $jadwal = JadwalPelatihan::with('pendaftars.user.biodata')->findOrFail($id);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Tambah logo dan header tulisan
    $logoPath = public_path('img/logo-kemendagri.png');
    if (file_exists($logoPath)) {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath($logoPath);
        $drawing->setCoordinates('A1');
        $drawing->setHeight(80);
        $drawing->setOffsetX(10);
        $drawing->setWorksheet($sheet);
    }

    // Header tulisan
    $sheet->mergeCells('B1:F1');
    $sheet->mergeCells('B2:F2');
    $sheet->setCellValue('B1', 'KEMENTERIAN DALAM NEGERI REPUBLIK INDONESIA');
    $sheet->setCellValue('B2', 'BALAI BESAR PEMERINTAHAN DESA DI MALANG');
    $sheet->getStyle('B1:B2')->getFont()->setBold(true);
    $sheet->getStyle('B1:B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    // Judul tengah
    $sheet->mergeCells('A4:F4');
    $sheet->mergeCells('A5:F5');
    $sheet->mergeCells('A6:F6');
    $sheet->setCellValue('A4', 'DAFTAR NILAI PRE TEST DAN POST TEST');
    $sheet->setCellValue('A5', 'PELATIHAN TEKNIS PENYUSUNAN LAPORAN PENYELENGGARAAN PEMERINTAHAN DESA TAHUN 2024');
    $sheet->setCellValue('A6', 'KABUPATEN HALMAHERA TENGAH PROVINSI MALUKU UTARA');
    $sheet->getStyle('A4:A6')->getFont()->setBold(true)->setSize(13);
    $sheet->getStyle('A4:A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // Tanggal
    $sheet->setCellValue('A8', 'Tanggal, ' . Carbon::now()->translatedFormat('d F Y'));
    $sheet->getStyle('A8')->getFont()->setSize(10);

    // Header baris 1
    $sheet->setCellValue('A10', value: 'NO');
    $sheet->setCellValue('B10', 'NAMA');
    $sheet->setCellValue('C10', 'L/P');
    $sheet->setCellValue('D10', 'JABATAN');
    $sheet->setCellValue('E10', 'N I L A I');
    $sheet->mergeCells('E10:F10');

    // Header baris 2 (sub kolom)
    $sheet->setCellValue('E11', 'PRE TEST');
    $sheet->setCellValue('F11', 'POST TEST');

    // Merge header lainnya vertikal
    $sheet->mergeCells('A10:A11');
    $sheet->mergeCells('B10:B11');
    $sheet->mergeCells('C10:C11');
    $sheet->mergeCells('D10:D11');

    // Styling Header
    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'D9E1F2'],
        ],
    ];
    $sheet->getStyle('A10:F11')->applyFromArray($headerStyle);

    // Data peserta
    $row = 12;
    $no = 1;
    $preSum = 0;
    $postSum = 0;
    $nilaiCount = 0;

    foreach ($jadwal->pendaftars as $peserta) {
        if ($peserta->status_peserta !== 'approved') continue;
        $bio = $peserta->user->biodata;
        if (!$bio) continue;

        $jk = strtoupper($bio->jenis_kelamin) === 'LAKI-LAKI' ? 'L' : 'P';

        $pre = $peserta->pre_test ?? null;
        $post = $peserta->post_test ?? null;

        if (is_numeric($pre)) $preSum += $pre;
        if (is_numeric($post)) $postSum += $post;
        if (is_numeric($pre) || is_numeric($post)) $nilaiCount++;

        $sheet->setCellValue("A{$row}", $no++);
        $sheet->setCellValue("B{$row}", strtoupper($bio->nama));
        $sheet->setCellValue("C{$row}", $jk);
        $sheet->setCellValue("D{$row}", $bio->jabatan);
        $sheet->setCellValue("E{$row}", $pre);
        $sheet->setCellValue("F{$row}", $post);

        $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        $row++;
    }

    // Rata-rata
    $sheet->setCellValue("A{$row}", 'RATA-RATA');
    $sheet->mergeCells("A{$row}:D{$row}");
    $sheet->setCellValue("E{$row}", $nilaiCount ? round($preSum / $nilaiCount, 2) : '');
    $sheet->setCellValue("F{$row}", $nilaiCount ? round($postSum / $nilaiCount, 2) : '');
    $sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FBE5D6'],
        ],
    ]);
    $row++;

    // Kategori
    $sheet->setCellValue("A{$row}", 'KATEGORI PENILAIAN');
    $sheet->mergeCells("A{$row}:F{$row}");
    $row++;
    $kategori = [
        '81 - 100  :  Sangat Baik',
        '71 - 80   :  Baik',
        '56 - 70   :  Cukup',
        '< 56      :  Kurang',
    ];
    foreach ($kategori as $k) {
        $sheet->setCellValue("A{$row}", $k);
        $sheet->mergeCells("A{$row}:F{$row}");
        $row++;
    }

    foreach (range('A', 'F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'nilai-pelatihan-' . $jadwal->id . '.xlsx';
    $tempPath = tempnam(sys_get_temp_dir(), $filename);
    $writer->save($tempPath);

    return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
}


}
